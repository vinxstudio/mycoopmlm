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
use App\Models\User;
use App\Models\AvailableBalance;
use App\Models\EncashmentSummary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use App\Models\WeeklyPayout;
use App\Models\WithdrawalsSummary;

class WithdrawalsMemberController extends MemberAbstract
{

    protected $viewpath = 'Member.Withdrawals.views.';

    function __construct()
    {
        parent::__construct();
    }

    function getRequest()
    {
        $data = array(
            'bank_name' => $this->theDetails['bank_name'],
            'bank_acc_name' => $this->theDetails['account_name'],
            'bank_acc_num' => $this->theDetails['account_number'],
            'truemoney' => $this->theDetails['truemoney'],
        );
        return view($this->viewpath . 'request')->with(['details' => $data]);
    }

    function postRequest(Request $request)
    {
        $date_from = $request->input('date_from');
        $date_to = $request->input('date_to');

        $user = User::where('id', $this->theUser->id)->first();

        if ($request->input('transaction_type') == 0) {
            $rules = [
                'amount' => 'required|numeric',
                'bank_name' => 'required',
                'bank_account_number' => 'required'
            ];
        } else {
            $rules = [];
        }

        $validation = Validator::make($request->input(), $rules);
        $minimum_withdraw = $this->theCompany->withdrawalSettings->minimum_amount;

        $result = new \stdClass();

        $result->error = false;
        $result->message = '';

        $total_amount = ($request->amount + $request->savings + $request->shared_capital + $request->maintenance);

        if ($validation->fails()) {
            $result->error = true;
        } else if ($request->amount < $minimum_withdraw) {
            $result->error = true;
            $result->message = Lang::get('messages.minimum_withdrawal') . ' ' . $minimum_withdraw;
        } else if ($total_amount > $this->theUser->remainingBalance) {
            $result->error = true;
            $result->message = Lang::get('messages.request_over_balance');
        } else if ($total_amount <= 0) {
            $result->error = true;
            $result->message = 'Please Enter Amount...';
        }

        if (!$result->error) {

            $withdrawals_summary = array();
            $remaining_amount = $total_amount;
            $total_balance = 0;
            $total_accumulated = 0;
            $text_summary = "";
            $weekly_amount = WeeklyPayout::where('group_id', $user->group_id)->orderBy('created_at', 'ASC')->get();
            foreach ($weekly_amount as $weekly) {

                if ($weekly->remaining_balance > 0) {
                    if ($remaining_amount > 0) {
                        if ($remaining_amount > $weekly->remaining_balance) {
                            $remaining_amount = $remaining_amount - $weekly->remaining_balance;
                            $r_amount = 0;
                        } else {
                            $r_amount = $weekly->remaining_balance - $remaining_amount;
                            $remaining_amount = 0;
                        }

                        $amount_deducted = $weekly->remaining_balance - $r_amount;

                        WeeklyPayout::where('date_from', $weekly->date_from)
                            ->where('date_to', $weekly->date_to)
                            ->where('user_id', $weekly->user_id)
                            ->update(['remaining_balance' => $r_amount]);

                        $text_summary .= 'Cut off Dates : ' . $weekly->date_from . ' - ' . $weekly->date_to . " : \r\n Net Income : " . number_format($weekly->net_income, 2) . ' | Amount Accumulated : ' . round($amount_deducted) . ' | Remaining Balance : ' . number_format($r_amount, 2) . "\r\n\r\n";

                        $total_accumulated += $amount_deducted;

                        $withdrawals_summary[$weekly->id] = [
                            'weekly_payout_id' => $weekly->id,
                            'amount_deducted' => $amount_deducted,
                        ];
                    }
                }
            }

            $total_balance = $this->theUser->remainingBalance - $total_amount;
            $current_balance = "\r\nCurrent Available Balance : " . number_format($this->theUser->remainingBalance, 2);
            $accumulated_amount = "\r\nTotal Amount Accumulated : " . number_format(round($total_accumulated), 2);
            $amount_requested = "\r\nAmount Requested : " . number_format($total_amount, 2);
            $balance_text = "\r\nNew Available Balance : " . number_format(round($total_balance), 2);
            $header = "\r\n\r\n********** Withdrawals Summary **********\r\n";
            $notes = $request->notes . $header . "\r\n" . $text_summary . $current_balance . $accumulated_amount . $balance_text;

            DB::beginTransaction();
            try {
                $withdraw = new Withdrawals();
                $withdraw->user_id = $this->theUser->id;
                $withdraw->savings = $request->savings;
                $withdraw->shared_capital = $request->shared_capital;
                $withdraw->maintenance = $request->maintenance;
                $withdraw->amount = ($request->input('transaction_type') == 0) ? $request->amount : 0;
                $withdraw->bank_name = ($request->input('transaction_type') == 0) ? $request->bank_name : 'No Withdrawals';
                $withdraw->account_name = $request->bank_account_name;
                $withdraw->account_number = $request->bank_account_number;
                $withdraw->notes = $notes;
                $withdraw->save();

                $result->message = Lang::get('messages.withdraw_success');

                $withdrawals_db = new WithdrawalsSummary();
                foreach ($withdrawals_summary as $w_summary) {
                    $withdrawals_db = new WithdrawalsSummary();
                    $withdrawals_db->withdrawals_id = $withdraw->id;
                    $withdrawals_db->weekly_payout_id = $w_summary['weekly_payout_id'];
                    $withdrawals_db->amount_deducted = $w_summary['amount_deducted'];
                    $withdrawals_db->save();
                }

                DB::commit();

                $new_balance = $this->theUser->remainingBalance - $total_amount;
                AvailableBalance::where(['group_id' => $user->group_id, 'source' => AvailableBalance::SOURCE_TOTAL_INCOME])
                    ->update(['available_balance' => $new_balance]);

                $summary_details = EncashmentSummary::select('balance')
                    ->where('group_id', $user->group_id)
                    ->orderBy('created_at', 'DESC')
                    ->first();

                $summary = new EncashmentSummary();
                $summary->group_id = $user->group_id;
                $summary->user_id = $this->theUser->id;
                $summary->particular = "Encashment/Withdrawal";
                $summary->gross_income = 0;
                $summary->admin_fee = 0;
                $summary->cd_account_fee = 0;
                $summary->net_income = 0;
                $summary->amount_withdrawn = $total_amount;
                $summary->adjustment = 0;
                $summary->balance = $summary_details->balance - $total_amount;
                $summary->save();
            } catch (\Exception $e) {
                $result->error = true;
                $result->message = $this->formatException($e);
                DB::rollback();
            }
        }

        return ($result->error) ? redirect('member/withdrawals/request')->withInput()
            ->withErrors($validation->errors())
            ->with('danger', $result->message) : redirect('member/withdrawals/request')->with('success', $result->message);
    }

    function getPending()
    {

        return view($this->viewpath . 'pending')
            ->with([
                'withdrawals' => Withdrawals::where([
                    'status' => 'pending',
                    'user_id' => $this->theUser->id
                ])->paginate($this->records_per_page)
            ]);
    }

    function getHistory()
    {

        return view($this->viewpath . 'history')
            ->with([
                'withdrawals' => Withdrawals::where([
                    'user_id' => $this->theUser->id
                ])->orderBy('created_at', 'DESC')->paginate($this->records_per_page)
            ]);
    }

    function getCancelRequest($id)
    {

        $withdrawal = Withdrawals::where([
            'status' => 'pending',
            'id' => $id,
            'user_id' => $this->theUser->id
        ])->first();

        $total_amount = ($withdrawal->amount + $withdrawal->savings + $withdrawal->shared_capital + $withdrawal->maintenance);

        #get group id
        $user = User::where('id', $this->theUser->id)->first();

        #calculate new balance
        $new_balance = $this->theUser->remainingBalance + $total_amount;

        $source = AvailableBalance::SOURCE_TOTAL_INCOME;

        if ($withdrawal->source == Withdrawals::SOURCE_REDUNDANT_INCOME) {
            $source = AvailableBalance::SOURCE_REDUNDANT_BINARY_INCOME;
        }

        #update available balance
        AvailableBalance::where(['group_id' => $user->group_id, 'source' => $source])
            ->update(['available_balance' => $new_balance]);

        $summary_details = EncashmentSummary::select('balance')
            ->where('group_id', $user->group_id)
            ->orderBy('created_at', 'DESC')
            ->first();

        $summary = new EncashmentSummary();
        $summary->group_id = $user->group_id;
        $summary->user_id = $this->theUser->id;
        $summary->particular = "Cancel Withdrawal";
        $summary->gross_income = 0;
        $summary->admin_fee = 0;
        $summary->cd_account_fee = 0;
        $summary->net_income = 0;
        $summary->amount_withdrawn = 0;
        $summary->adjustment = $total_amount;
        $summary->balance = $summary_details->balance + $total_amount;
        $summary->save();

        #get withdrawals summary
        $w_summaries = WithdrawalsSummary::where([
            'withdrawals_id' => $id,
        ])->get();


        #get weekly payout
        if (!$w_summaries->isEmpty()) {
            return 'hahah';
            foreach ($w_summaries as $w_summary) {
                $weekly_payout = WeeklyPayout::where('id', $w_summary->weekly_payout_id)->first();
                $remaining_balance = $weekly_payout->remaining_balance + $w_summary->amount_deducted;

                $weekly_payout->remaining_balance = $remaining_balance;
                $weekly_payout->save();
            }
        } else {

            $balance = AvailableBalance::where(['group_id' => $user->group_id, 'source' => $source])->first();
            $weeklyPayout = WeeklyPayout::where('group_id', $user->group_id)->get();

            $countWeeklyPayout = count($weeklyPayout);

            if ($countWeeklyPayout > 0) {
                $amount = $total_amount / $countWeeklyPayout;
                foreach ($weeklyPayout as $payout) {
                    $r_balance = $payout->remaining_balance + $amount;
                    WeeklyPayout::where('id', $payout->id)
                        ->update(['remaining_balance' => $r_balance]);
                }
            } else {
                $w_payout = new WeeklyPayout();
                $w_payout->group_id = $user->group_id;
                $w_payout->user_id = $user->id;
                $w_payout->direct_referral = 0;
                $w_payout->matching_bonus = 0;
                $w_payout->gift_check = 0;
                $w_payout->gross_income = 0;
                $w_payout->net_income = $total_amount;
                $w_payout->remaining_balance = $total_amount;
                $w_payout->status = 'Adjustment';
                $w_payout->date_from = '2018-08-04 06:00:01';
                $w_payout->date_to = '2018-08-11 05:59:59';
                $w_payout->save();
            }
        }


        Withdrawals::where([
            'status' => 'pending',
            'id' => $id,
            'user_id' => $this->theUser->id
        ])->delete();
        return back()->with('success', Lang::get('withdrawal.success_cancel'));
    }

    # withrawal inbox
    # 
    #function getInbox()
    #{
    #    $weekly_payout = '';
    #    $status = '';
    #
    #    if (!empty($_GET['status'])) {
    #        $status = $_GET['status'];
    #        $weekly_payout = WeeklyPayout::select('gross_income', 'status', 'reason', 'date_from', 'date_to')->where(['user_id' => $this->theUser->id, 'status' => $status])->orderBy('created_at', 'DESC')->paginate(15);
    #    } else {
    #        $weekly_payout = WeeklyPayout::select('gross_income', 'status', 'reason', 'date_from', 'date_to')->where(['user_id' => $this->theUser->id])->orderBy('created_at', 'DESC')->paginate(15);
    #    }  
    #
    #    return view($this->viewpath . 'inbox')->with([
    #        'weekly_payout' => $weekly_payout,
    #        'status' => $status
    #    ]);
    #   
    #}
}
