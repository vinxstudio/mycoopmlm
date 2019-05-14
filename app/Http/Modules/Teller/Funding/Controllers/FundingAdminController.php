<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 4/7/17
 * Time: 9:16 PM
 */

namespace App\Http\Modules\Admin\Funding\Controllers;

use App\Http\AbstractHandlers\AdminAbstract;
use App\Http\TraitLayer\GlobalSettingsTrait;
use App\Http\TraitLayer\UserTrait;
use App\Models\Accounts;
use App\Models\Earnings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;

class FundingAdminController extends AdminAbstract{

    use UserTrait;
    use GlobalSettingsTrait;

    protected $viewpath = 'Admin.Funding.views.';

    function __construct(){
        parent::__construct();
    }

    function getIndex(){

        $fundingHistory = Earnings::where('from_funding', 'true')->paginate($this->records_per_page);

        return view( $this->viewpath . 'index' )
            ->with([
                'members'=>$this->getAccountsDropdown(),
                'history'=>$fundingHistory
            ]);
    }

    function postIndex(Request $request){

        $error = false;
        $message = '';

        $validate = Validator::make($request->input(), [
            'member' => 'required',
            'amount' => 'numeric|min:1'
        ]);

        if ($this->theCompany->remainingBalance <= 0){

            $error = true;
            $message = Lang::get('funding.low_company_balance');

        } else if ($request->amount > $this->theCompany->remainingBalance){

            $error = true;
            $message = Lang::get('funding.amount_too_huge');

        } else {


            if ($validate->fails()) {
                $error = true;
            } else {

                $account = Accounts::find($request->member);
                $earnings = new Earnings();

                $earnings->account_id = $account->id;
                $earnings->user_id = $account->user_id;
                $earnings->source = $this->earningsDirectReferralKey;
                $earnings->from_funding = 'true';
                $earnings->amount = $request->amount;
                $earnings->level = 0;
                $earnings->save();

                $message = Lang::get('funding.success_add');

            }
        }

        return ($error) ? back()->withErrors($validate->errors())->withInput()->with('danger', $message) : back()->with('success', $message);

    }

    function getDelete($id){
        Earnings::where([
            'id'=>$id
        ])->delete();

        return back()->with('success', 'Transferred funds cancelled.');
    }

}