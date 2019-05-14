<?php namespace App\Http\Controllers\Teller\ProductCodes;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\AbstractHandlers\AdminAbstract;
use App\Models\PurchaseCodes;
use Illuminate\Support\Collection;
use App\Models\Products;
use App\Models\User;
use App\Models\TransferBranchHistory;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Branches;

class ProductsTellerController extends AdminAbstract

{
	# /teller/product-codes - route
	# the index url for product code admin
	# index_path is the blade.php is located
	protected $index_path = 'admin.teller.product_codes';


	function getIndex()
	{
		$product_id = '';

		# GET parameters
		$slug_name = '';
		$product_availability = '';

		$date_from = '2018-12-01';
		$date_to = Carbon::now()->format('Y-m-d');

		$branches = '';

		$product_codes_query = [
			'product_purchase_codes.branch_id' => $this->user_true->branch_id
		];

		if (!empty($_GET['product_name'])) {
			$slug_name = $_GET['product_name'];
			# product id
			$product_id = Products::where('slug', $slug_name)->pluck('id');
			$product_codes_query['product_id'] = $product_id;
		}
		if (!empty($_GET['product_availability'])) {
			# set availability
			$product_availability = $_GET['product_availability'];
			if ($product_availability == 'bought')
				$product_codes_query['status'] = 1;
			else if ($product_availability == 'available')
				$product_codes_query['status'] = 2;
		}

		if (!empty($_GET['date_from']) && !empty($_GET['date_to'])) {
			$date_from = $_GET['date_from'];
			$date_to = $_GET['date_to'];
		}

		# get product codes
		$product_codes = PurchaseCodes::select(
			'product_purchase_codes.*',
			'user_a.username as generated_username',
			'user_b.username as owner_username',
			'products.name',
			'transfer_branch_histories.created_at as transfered_on'
		)
			->orderBy('created_at', 'DESC')
			->leftJoin('users as user_a', 'user_a.id', '=', 'product_purchase_codes.generated_by')
			->leftJoin('accounts', 'accounts.id', '=', 'product_purchase_codes.owner_id')
			->leftJoin('users as user_b', 'user_b.id', '=', 'accounts.user_id')
			->leftJoin('products', 'products.id', '=', 'product_purchase_codes.product_id')
			->leftJoin('transfer_branch_histories', function ($join) {
				$join->on('transfer_branch_histories.code', '=', 'product_purchase_codes.code');
				$join->on('transfer_branch_histories.current_branch', '=', 'product_purchase_codes.branch_id');
			})
			->where($product_codes_query)
			->whereDate('product_purchase_codes.created_at', '>=', $date_from)
			->whereDate('product_purchase_codes.created_at', '<=', $date_to)
			->paginate(10);


		# product list
		$product_list = Products::select('name', 'slug')->get();

		# For Invetory Codes
		$total_product_codes = '';
		$total_product_codes_per_product = '';

		if ($slug_name == '') {

			# Total Product Codes
			# Total, Available, Bought
			$total_product_codes = PurchaseCodes::selectRaw('count(*) as product_codes, status')
				->where(['branch_id' => $this->user_true->branch_id])
				->where('status', '!=', PurchaseCodes::STATUS_UNUSED)
				->orWhere(['branch_id' => $this->user_true->branch_id, 'status' => PurchaseCodes::STATUS_TRANSFERED])
				->orWhere(['branch_id' => $this->user_true->branch_id, 'status' => PurchaseCodes::STATUS_USED])
				->groupBy('status')
				->get();
			
			# Total Per Products
			# Get Product names, id first
			$product_name_for_inventory = Products::select('id', 'name')->get();
			
			# then map every product 
			# to get total, available, and bought
			$total_product_codes_per_product = $product_name_for_inventory->map(function ($item, $key) {

				$branch_id = $this->user_true->branch_id;
				$product_id = $item->id;

				$total = PurchaseCodes::where(['branch_id' => $branch_id, 'product_id' => $product_id])->where('status', '!=', PurchaseCodes::STATUS_UNUSED)->count();
				$available = PurchaseCodes::where(['branch_id' => $branch_id, 'product_id' => $product_id, 'status' => PurchaseCodes::STATUS_TRANSFERED])->count();
				$bought = PurchaseCodes::where(['branch_id' => $branch_id, 'product_id' => $product_id, 'status' => PurchaseCodes::STATUS_USED])->orWhere(['branch_id' => $branch_id, 'product_id' => $product_id, 'status' => 3])->count();

				$item->total = $total;
				$item->available = $available;
				$item->bought = $bought;

				return $item;

			});


		} else {

			$total_product_codes = collect([]);

			$total = PurchaseCodes::where(['branch_id' => $this->user_true->branch_id, 'product_id' => $product_id])
				->where('status', '!=', PurchaseCodes::STATUS_UNUSED)->count();

			$available = PurchaseCodes::where(['branch_id' => $this->user_true->branch_id, 'product_id' => $product_id, 'status' => PurchaseCodes::STATUS_TRANSFERED])->count();

			$bought = PurchaseCodes::where(['branch_id' => $this->user_true->branch_id, 'product_id' => $product_id, 'status' => PurchaseCodes::STATUS_USED])->count();

			$total_product_codes->total = $total;
			$total_product_codes->available = $available;
			$total_product_codes->bought = $bought;

		}

		$branches = Branches::select('id', 'name')->get();

		return view($this->index_path)->with([
			'product_slug_name' => $slug_name,
			'product_availability' => $product_availability,
			'date_from' => $date_from,
			'date_to' => $date_to,
			'product_codes' => $product_codes,
			'product_list' => $product_list,
			'total_product_codes' => $total_product_codes,
			'total_per_products' => $total_product_codes_per_product,
			'branches' => $branches
		]);
	}


	function postTransferBranch(Request $request)
	{
		# get code Id
		# get new branch id
		$codeId = $request->codeId;
		$branchId = $request->branchId;

		$message = '';
		$status = '';

		$responseCode = 0;

		# get code if exist
		$code = PurchaseCodes::select('code', 'branch_id', 'id')
			->where('id', $codeId)
			->first();

		if ($code && $branchId != $code->branch_id) {

			# get last branch if exist
			$lastBranch = TransferBranchHistory::where('code', $code->code)
				->orderBy('created_at', 'DESC')
				->pluck('id');

			# if last branch no exist set to 0;
			$lastBranch = $lastBranch ? $lastBranch : 0;

			$code->branch_id = $branchId;

			if ($code->save()) {

				# create new transfer branch
				$transfer = new TransferBranchHistory();

				$transfer->code = $code->code;
				$transfer->current_branch = $code->branch_id;
				$transfer->last_branch = $lastBranch;

				if ($transfer->save()) {

					$message = 'Successfully transferred to another branch';
					$status = 'success';

					$responseCode = 200;
				} else {
					$message = 'Unable to transfer branch';
					$status = 'error';

					$responseCode = 400;
				}

			} else {

				$message = 'Unable to transfer branch';
				$status = 'error';

				$responseCode = 400;
			}


		} else {

			$message = 'Couldnt transfer to the same branch';
			$status = 'error';

			$responseCode = 400;
		}

		return response()->json(['status' => $status, 'message' => $message], $responseCode);
	}

}
