<?php 

namespace App\Http\Controllers\ProgramServices;

use Illuminate\Http\Request;
use Session;

use App\Http\AbstractHandlers\MemberAbstract;
use Illuminate\Support\Facades\DB;
use App\Models\Products;
use App\Models\PurchasesProducts;
use App\Models\ProductIncentives;
use App\Models\ProductPurchase;
use App\Models\PurchaseCodes;
use App\Models\Purchases;
use App\Models\Accounts;
use App\Models\EWallet;
use App\Models\User;
use Symfony\Component\VarDumper\VarDumper;
use App\Models\ProductUnilevel;
use App\Models\PurchaseCodesBought;

class PurchasesController extends MemberAbstract
{
	private $accountId;
	protected $sponsor_id = [];

	function __construct()
	{
		parent::__construct();

		$this->accountId = Accounts::where(['user_id' => $this->theUser->id])->first()->id;
	}

	/**
	 * Display all bought products.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$status = $request->status;

		$history = $request->history;
		$unilevel = $request->unilevel;

		$purchases = Purchases::where([
			'user_id' => $this->theUser->id,
			'account_id' => $this->accountId
		]);

		if ($status) {
			$purchases->where(['status' => $status]);
		}

		$purchases = $purchases->orderBy('created_at', 'desc')->paginate(10)->appends(['status' => $status]);
		
		# get items purchases products 
		for ($i = 0; $i < $purchases->count(); $i++) {
			# code...
			$item = $purchases[$i];

			$purchase_products = PurchasesProducts::where('purchase_id', $item->id)->get();

			$item->purchase_products = $purchase_products;

			$purchases[$i] = $item;

		}
		# get product codes of the products
		# of this account
		foreach ($purchases as $purchase) {
			# code...
			for ($i = 0; $i < $purchase->purchase_products->count(); $i++) {

				$item = $purchase->purchase_products[$i];

				$purchase_products_codes = PurchaseCodesBought::select(
					'purchase_codes_boughts.id',
					'purchase_codes_boughts.purchase_id',
					'purchase_codes_boughts.product_code',
					'product_purchase_codes.password',
					'product_purchase_codes.product_id',
					'product_purchase_codes.status'
				)
					->leftJoin('product_purchase_codes', 'product_purchase_codes.code', '=', 'purchase_codes_boughts.product_code')
					->where([
						'purchase_id' => $item->purchase_id,
						'purchases_products_id' => $item->id
					])
					->get();

				$item->purchase_product_codes = $purchase_products_codes;

				$purchase->purchase_products[$i] = $item;
			}

		}

		$prod_incentives = new ProductIncentives();

		$incentives = $prod_incentives->getInventives($this->accountId);

		$products_unilevel_amount = ProductUnilevel::select('product_unilevel.product_id', 'product_unilevel.amount')
			->where('product_id', '>', 1000)
			->orderBy('product_id', 'ASC')
			->get();

		return view('purchases.index', [
			'unilevels' => $incentives,
			'status' => $status,
			'history' => $history,
			'purchases' => $purchases,
			'unilevel_amount' => $products_unilevel_amount
		]);
	}

	/**
	 * Store purchases from cart->place_order.
	 *
	 * @param $request Request
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		// Get available balance
		$available_balance = $this->theUser->remainingBalance;

		// Deduct total purcahse cost to eWallet
		$EWallet = new EWallet();

		if (!$EWallet->debitEwallet($request->total, $available_balance)) {
			return redirect()->back()->withErrors('Insufficient funds.');
		}

		// // Save purchase
		$purchaseId = $this->savePurchase($request->branch);

		//Save purchase products
		$this->savePurchaseProductsAndCodes($purchaseId, $request->product);

		$this->emptyCartSession();

		return redirect('member/purchases/list');
	}

	/**
	 * Removes cart to session after successfull purchase.
	 *
	 * @return boolean
	 */
	private function emptyCartSession()
	{
		Session::forget('cart');
		Session::save();

		return true;
	}

	/**
	 * Save purchase products of user.
	 *
	 * @param $purchaseId int
	 * @param $products   array
	 *
	 * @return boolean
	 */
	private function savePurchaseProductsAndCodes($purchaseId = null, $products = null)
	{
		if (!$products || !$purchaseId) return null;

		$user = new User();

		$accounts = $user->getAccountsByUsername($this->theUser->username);

		foreach ($products as $id => $product) {
			$productDetail = Products::find($id)->first();

			if (!$productDetail) continue;

			$PurchasesProducts = new PurchasesProducts([
				'purchase_id' => $purchaseId,
				'product_id' => $id,
				'amount' => $productDetail->price,
				'rebates' => $productDetail->rebates,
				'quantity' => $product['quantity']
			]);
			$PurchasesProducts->save();

			if (!isset($PurchasesProducts->id)) continue;

			foreach ($product['codes']['value'] as $key => $value) {
				$PurchaseCodes = new PurchaseCodes([
					'product_id' => $id,
					'code' => $value,
					'password' => $product['codes']['password'][$key],
					'status' => PurchaseCodes::STATUS_USED,
					'owner_id' => $this->accountId,
					'purchase_value' => $productDetail->rebates
				]);
				$PurchaseCodes->save();
			}

			// Save to product purchase
			$product_purchase = new ProductPurchase();
			$product_purchase->teller_id = $this->theUser->id;
			$product_purchase->account_id = $this->theUser->account->id;
			$product_purchase->quantity = $product['quantity'];
			$product_purchase->type = $product['name'];
			$product_purchase->or = "Ewallet";
			$product_purchase->payors_name = $this->theUser->details->first_name . ' ' . $this->theUser->details->last_name;
			$product_purchase->created_at = date('Y-m-d H:i:s');
			$product_purchase->payment_method = "Ewallet Account";
			$product_purchase->save();

			$product_unilevel = DB::table('product_unilevel')
				->select('product_unilevel.level', 'product_unilevel.amount', 'product_unilevel.product_id')
				->leftJoin('products', 'product_unilevel.product_id', '=', 'products.id')
				->where('products.name', $product['name'])
				->get();
            
            // calculate unilevel
			if ($product_unilevel) {
				$x = count($product_unilevel);
				$this->sponsor_id[] = $accounts->account_id;
				self::sponsor_ids($x, $accounts->account_id);
				for ($ii = 0; $ii < count(array_unique($this->sponsor_id)); $ii++) {
					if ($ii == 10) continue;
					$data1[] = array(
						'account_id' => $this->theUser->account->id,
						'sponsor_id' => $this->sponsor_id[$ii + 1],
						'product_purchase_id' => $product_purchase->id,
						'purchase_product_id' => $PurchasesProducts->id,
						'product_purchase_via' => 'member account',
						'level' => $product_unilevel[$ii]->level,
						'amount' => ($product_unilevel[$ii]->amount * $product['quantity']),
						'created_at' => date('Y-m-d H:i:s')
					);
				}
			}
		}

		DB::table('product_incentive')->insert($data1);

		return true;
	}

	/**
	 * Save purchase of user.
	 *
	 * @param  $branch_id
	 *
	 * @return $purchaseId
	 */
	private function savePurchase($branch_id)
	{
		$Purchases = new Purchases([
			'user_id' => $this->theUser->id,
			'account_id' => $this->accountId,
			'status' => Purchases::STATUS_PICK_UP,
			'branch_id' => $branch_id
		]);
		$Purchases->save();

		return $Purchases->id;
	}

	private function sponsor_ids($x, $id = null)
	{
		$sponsor_id = DB::table('accounts')
			->select('sponsor_id')
			->where('id', $id)
			->get();

		if ($id && $x != 0) {
			$this->sponsor_id[] = $sponsor_id[0]->sponsor_id;
			self::sponsor_ids($x - 1, $sponsor_id[0]->sponsor_id);
		}
		return;
	}
}