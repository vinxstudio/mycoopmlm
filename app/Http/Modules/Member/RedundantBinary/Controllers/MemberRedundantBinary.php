<?php

namespace App\Http\Modules\Member\RedundantBinary\Controllers;

use App\Models\Earnings;
use App\Http\AbstractHandlers\MemberAbstract;
use App\Models\Accounts;
use App\Models\User;
use App\Models\Membership;
use App\Models\Details;
use App\Models\ActivationCodes;
use App\Models\ActivationCodeBatches;
use App\Models\AccountRedudantPoints;
use App\Models\AccountRedudantPointsHistory;
use App\Models\ProductPointsEquivalent;
use App\Models\Settings;
use App\Models\AvailableBalance;
use App\Models\Withdrawals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class MemberRedundantBinary extends MemberAbstract
{

    protected $viewpath = 'Member.RedundantBinary.views.';

    function __construct()
    {
        parent::__construct();
    }

    public function redundant_history($account_id, $from_date = 0, $from_to = 0)
    {

        $from_date = $from_date != 0 ? date('Y-m-d H:i:s', $from_date) : 0;
        $from_to = $from_to != 0 ? date('Y-m-d H:i:s', $from_to) : 0;

        $user_account = Accounts::where('id', $account_id)->first();

        if (!$user_account) {
            return redirect()->back();
        }

        $user = User::where('id', $user_account->user_id)->first();

        $activationcode = ActivationCodes::where('user_id', $user->id)->first();
        $activation_batch = ActivationCodeBatches::where('id', $activationcode->batch_id)->first();

        $batchname = (!isset($activation_batch->name)) ? '' : $activation_batch->name;

        $membership = Membership::where('id', $user->member_type_id)->first();
        $fullname = Details::where('id', $user->user_details_id)->first();

        $rend_binary = Earnings::where('source', Earnings::SOURCE_REDUNDANT)
            ->where('account_id', $account_id)
            ->sum('amount');


        $user_info = array(
            'batchid' => $batchname,
            'code' => $activationcode->code,
            'accountid' => $activationcode->account_id,
            'username' => $user->username,
            'fullname' => $fullname->first_name . ' ' . $fullname->last_name,
            'package' => $membership->membership_type_name,
            'total_rend_amount' => ($rend_binary) ? number_format($rend_binary, 2) : '0.00'
        );

        $rend_points = AccountRedudantPoints::where('account_id', $account_id)
            ->first();

        $rend_points_history = AccountRedudantPointsHistory::where('account_redundant_points_id', $rend_points->id)->paginate(30);

        $rend_settings = ProductPointsEquivalent::find(ProductPointsEquivalent::REDUNDANT_BINARY_SETTINGS);

        return view($this->viewpath . 'index')
            ->with([
                'user_info' => $user_info,
                'rend_points' => $rend_points,
                'rend_history' => $rend_points_history,
                'rend_settings' => $rend_settings
            ]);
    }


    public function encash_income()
    {
        $bank_details = array(
            'bank_name' => $this->theDetails['bank_name'],
            'bank_acc_name' => $this->theDetails['account_name'],
            'bank_acc_num' => $this->theDetails['account_number'],
            'truemoney' => $this->theDetails['truemoney'],
        );

        $minimum_withdrawal = Settings::where('name', Settings::REDUNDANT_BINARY_DEDUCTION_AMOUNT)->pluck('value');

        $redundant_binary_income = Earnings::whereIn('user_id', $this->theUser->userIds)->where('source', Earnings::SOURCE_REDUNDANT)->sum('amount');
        $commision_withdrawn = Withdrawals::whereIn('user_id', $this->theUser->userIds)->where('source', Withdrawals::SOURCE_REDUNDANT_INCOME)->whereIn('status', ['pending', 'approved'])->get();



        $commision_withdrawn_amount = 0;
        $withdrawn_amount = 0;
        $deduction_amount = 0;


        foreach ($commision_withdrawn as $com_withdrawn) {
            $commision_withdrawn_amount += $com_withdrawn->amount;
            $deduction_amount += 600;
            $withdrawn_amount += $com_withdrawn->amount - $deduction_amount;
        }

        $remaining_balance = AvailableBalance::where(['group_id' => $this->theUser->group_id, 'source' => AvailableBalance::SOURCE_REDUNDANT_BINARY_INCOME])->pluck('available_balance');



        return view($this->viewpath . 'encash_rendundant_income')->with([
            'details' => $bank_details,
            'minimun_withdrawal' => $minimum_withdrawal,
            'rend_income' => $redundant_binary_income,
            'commision_withdrawn' => $commision_withdrawn_amount,
            'withdrawn_amount' => $withdrawn_amount,
            'deduction_amount' => $deduction_amount,
            'remaining_balance' => $remaining_balance
        ]);
    }

    public function encash_income_submit(Request $request)
    {

        $message = [
            'amount.required' => 'Amount is required',
            'amount.numeric' => 'Amount must be a number',
            'amount.min' => 'Amount must be greater than or equal to 600',
            'bank_name.required' => 'Bank name is required',
            'bank_account_number.required' => 'Bank account number is required'
        ];

        $this->validate($request, [
            'amount' => 'required|numeric|min:600',
            'bank_name' => 'required',
            'bank_account_number' => 'required'
        ], $message);

        $message = '';

        $rend_balance = AvailableBalance::where(['group_id' => $this->theUser->group_id, 'source' => AvailableBalance::SOURCE_REDUNDANT_BINARY_INCOME])->first();

        $balance = $rend_balance->available_balance;
        if ($balance < $request->amount) {


            $message = 'Current balance is lesser than the inputted amount';

            return redirect()->back()->with([
                'status' => 'error',
                'message' => $message
            ]);
        }
        /**
         * Notes
         * 
         * Withdrawal Summary
         */
        $auto_deduction = Settings::where('name', Settings::REDUNDANT_BINARY_DEDUCTION_AMOUNT)->pluck('value');

        $notes = $request->notes;
        $notes .= "\r\n\r\n********** Withdrawals Summary **********\r\n";
        $notes .= "\r\nRequested Amount : " . $request->amount;
        $notes .= "\r\nAuto Deduction Amount : " . $auto_deduction;
        $notes .= "\r\nNet Amount : " . ($request->amount - (int)$auto_deduction);
        $notes .= "\r\r";
        $notes .= "\r\nCurrent Redundant Balance : " . $balance;
        $notes .= "\r\nTotal Amount Accumulated : " . $request->amount;
        $notes .= "\r\nNew Redundant Balance : " . ($balance - $request->amount);

        DB::beginTransaction();
        try {

            $withdraw = new Withdrawals();

            $withdraw->user_id = $this->theUser->id;
            $withdraw->savings = 0;
            $withdraw->shared_capital = 0;
            $withdraw->maintenance = 0;
            $withdraw->source = Withdrawals::SOURCE_REDUNDANT_INCOME;
            $withdraw->amount = ($request->input('transaction_type') == 0) ? $request->amount : 0;
            $withdraw->bank_name = ($request->input('transaction_type') == 0) ? $request->bank_name : 'No Withdrawals';
            $withdraw->account_name = $request->bank_account_name;
            $withdraw->account_number = $request->bank_account_number;
            $withdraw->notes = $notes;
            $withdraw->save();

            $new_rend_balance = $balance - $request->amount;

            $rend_balance->available_balance = $new_rend_balance;

            $rend_balance->save();


            DB::commit();
        } catch (\Exception $ex) {

            Log::debug('Redundant Withdrawal Request');
            Log::debug('Date : ' . Carbon::now());
            Log::debug('File : ' . $ex->getFile());
            Log::debug('Exception : ' . get_class($ex));
            Log::debug('Error : ' . $ex->getTraceAsString());

            DB::rollback();
        }


        $message = 'Successfully request withdraw amount ' . $request->amount;

        return redirect()->back()->with([
            'status' => 'success',
            'message' => $message
        ]);
    }
}
