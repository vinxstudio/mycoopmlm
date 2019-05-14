<?php namespace App\Http\Controllers\Admin\Products\Codes;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\PurchaseCodes;
use App\Models\TransferBranchHistory;
use Symfony\Component\Debug\Exception\FatalErrorException;
use Illuminate\Support\Facades\Session;
use App\Models\Branches;
use App\Http\AbstractHandlers\AdminAbstract;

class GeneratedProductCodesContoller extends AdminAbstract
{
	# Target Branch for Generated Codes
	# POST

	protected $result;

	public function branch(Request $request)
	{

		$result = new \stdClass();
		$result->message_type = '';
		$result->message = '';
		
		# check if request branch has value
		if ($request->branch) {

			if ($request->branch == $this->user_true->branch_id) {
				$result->message_type = "danger";
				$result->message = "You cannot transfer code to your own branch";
			} else {

				
				# get purchase code using unique code
				$purchase_code = PurchaseCodes::where('code', '=', $request->unique_code)->first();
				
				# change the branch id to the inputed branch
				$purchase_code->branch_id = $request->branch;
				
				# change status to 2
				# status 2 = tranfered branch
				$purchase_code->status = PurchaseCodes::STATUS_TRANSFERED;
				
				# update the purchase code
				$purchase_code->save();
				
				# create instance of Transfer Branch History
				$history = new TransferBranchHistory();
				
				# assign code to unique code
				$history->code = $request->unique_code;
				
				# assing current branch to the inputted current branch
				$history->current_branch = $request->branch;
				
				# query to the database for
				# for getting the last branch
				$last_branch = TransferBranchHistory::where('code', '=', $request->unique_code)->orderBy('id', 'DESC')->first();
				
				# check if last branch has value 
				# assign default value if empty
				$last_branch = (!$last_branch) ? 0 : $last_branch;
				
				# assign last branch coloum
				$history->last_branch = $last_branch;
				
				# save history
				$history->save();
				
				# get branch name
				$branch_name = Branches::where('id', '=', $request->branch)->pluck('name');
				
				# set results
				$result->message_type = 'success';
				$result->message = 'Successfully Transfer Code ' . $request->unique_code . ' To Branch ' . $branch_name;
			}
		} else {
			
			# set error results
			$result->message_type = 'danger';
			$result->message = 'Select a Branch to Transfer';
		}

		Session::flash($result->message_type, $result->message);

		return back();
	}
	# end

}
