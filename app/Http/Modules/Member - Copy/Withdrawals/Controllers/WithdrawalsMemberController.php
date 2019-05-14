<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 3/10/17
 * Time: 1:51 PM
 */

namespace App\Http\Modules\Member\Withdrawals\Controllers;

use App\Http\AbstractHandlers\MemberAbstract;
use App\Models\Withdrawals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;

class WithdrawalsMemberController extends MemberAbstract{

    protected $viewpath = 'Member.Withdrawals.views.';

    function __construct(){
        parent::__construct();
    }

    function getRequest(){

        return view( $this->viewpath . 'request' );

    }

    function postRequest(Request $request){

        $rules = [
            'amount'=>'required|numeric',
            'bank_name'=>'required',
            'bank_account_name'=>'required',
            'bank_account_number'=>'required'
        ];

        $validation = Validator::make($request->input(), $rules);

        $minimum_withdraw = $this->theCompany->withdrawalSettings->minimum_amount;

        $result = new \stdClass();

        $result->error = false;
        $result->message = '';

        if ($validation->fails()){
            $result->error = true;
        } else if ($request->amount < $minimum_withdraw) {
            $result->error = true;
            $result->message = Lang::get('messages.minimum_withdrawal') . ' ' . $minimum_withdraw;
        } else if ($this->theUser->remainingBalance < $request->amount){
            $result->error = true;
            $result->message = Lang::get('messages.request_over_balance');
        }

        if (!$result->error){

            DB::beginTransaction();
            try{

                $withdraw = new Withdrawals();
                $withdraw->user_id = $this->theUser->id;
                $withdraw->amount = $request->amount;
                $withdraw->bank_name = $request->bank_name;
                $withdraw->account_name = $request->bank_account_name;
                $withdraw->account_number = $request->bank_account_number;
                $withdraw->notes = $request->notes;
                $withdraw->save();
                $result->message = Lang::get('messages.withdraw_success');

                DB::commit();
            } catch (\Exception $e){
                $result->error = true;
                $result->message = $this->formatException($e);
                DB::rollback();
            }

        }

        return ($result->error) ? redirect('member/withdrawals/request')->withInput()
            ->withErrors($validation->errors())
            ->with('danger', $result->message) : redirect('member/withdrawals/request')->with('success', $result->message);

    }

    function getPending(){

        return view( $this->viewpath . 'pending' )
            ->with([
                'withdrawals'=>Withdrawals::where([
                    'status'=>'pending',
                    'user_id'=>$this->theUser->id
                ])->paginate($this->records_per_page)
            ]);

    }

    function getHistory(){

        return view( $this->viewpath . 'history' )
            ->with([
                'withdrawals'=>Withdrawals::where([
                    'user_id'=>$this->theUser->id
                ])->paginate($this->records_per_page)
            ]);

    }

    function getCancelRequest($id){

        Withdrawals::where([
            'status'=>'pending',
            'id'=>$id,
            'user_id'=>$this->theUser->id
        ])->delete();

        return back()->with('success', Lang::get('withdrawal.success_cancel'));

    }

}