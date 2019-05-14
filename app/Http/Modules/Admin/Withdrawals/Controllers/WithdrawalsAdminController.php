<?php

/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 3/4/17
 * Time: 6:20 PM
 */

namespace App\Http\Modules\Admin\Withdrawals\Controllers;

use App\Helpers\MailHelper;
use App\Http\AbstractHandlers\AdminAbstract;
use App\Models\Withdrawals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\Models\WeeklyPayout;
use App\Models\WithdrawalsSummary;
use App\Models\User;
use App\Models\AvailableBalance;
use App\Models\EncashmentSummary;

class WithdrawalsAdminController extends AdminAbstract
{

    protected $viewpath = 'Admin.Withdrawals.views.';

    function __construct()
    {
        parent::__construct();
    }

    function getIndex()
    {
        $q = Withdrawals::orderBy('id', 'desc');

        $withdrawals = $q->paginate($this->records_per_page);
        return view($this->viewpath . 'index')
            ->with([
                'withdrawals' => $withdrawals,
                'date_from' => '',
                'date_to' => ''
            ]);
    }

    function postIndex(Request $request)
    {

        $date_from = ($request->date_from) ? $request->date_from : '';
        $date_to = ($request->date_to) ? $request->date_to : '';

        $q = Withdrawals::orderBy('id', 'desc');

        if (!empty($date_from)) {
            $q->where('created_at', '>=', $date_from);
        }

        if (!empty($date_to)) {
            $q->where('created_at', '<=', $date_to);
        }

        $withdrawals = $q->paginate($this->records_per_page);

        return view($this->viewpath . 'index')
            ->with([
                'withdrawals' => $withdrawals,
                'date_from' => $date_from,
                'date_to' => $date_to
            ]);
    }

    function getCancelRequest($id, $reason)
    {
        $withdraw = Withdrawals::find($id);

        if (isset($withdraw->id)) {
            $withdraw->status = DENIED_STATUS;
            $withdraw->reason = $reason;
            $withdraw->save();

            $total_amount = ($withdraw->amount + $withdraw->savings + $withdraw->shared_capital + $withdraw->maintenance);
            $user = User::where('id', $withdraw->user_id)->first();

            // $balance = AvailableBalance::where('group_id', $user->group_id)->first();
            // $new_balance = $balance->available_balance + $total_amount;

            // $balance->available_balance = $new_balance;
            // $balance->save();
            // AvailableBalance::where('group_id', $user->group_id)
            // ->update(['available_balance' => $new_balance]);

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
                foreach ($w_summaries as $w_summary) {
                    $weekly_payout = WeeklyPayout::where('id', $w_summary->weekly_payout_id)->first();
                    $remaining_balance = $weekly_payout->remaining_balance + $w_summary->amount_deducted;

                    $weekly_payout->remaining_balance = $remaining_balance;
                    $weekly_payout->save();
                }
            } else {
                $source = AvailableBalance::SOURCE_TOTAL_INCOME;
                if ($withdraw->source == Withdrawals::SOURCE_REDUNDANT_INCOME) {
                    $source = AvailableBalance::SOURCE_REDUNDANT_BINARY_INCOME;
                }
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

            if ($withdraw->user->details->email != null and isEmailRequired()) {
                $mail = new MailHelper();
                $mail->setUserObject($withdraw->user)
                    ->setWithdrawalObject($withdraw)
                    ->sendMail(WITHDRAWAL_KEY);
            }
        }

        return back()->with('success', Lang::get('withdrawal.success_deny'));;
    }

    function getApproveRequest($id, $reason = '')
    {
        $withdraw = Withdrawals::find($id);

        if (isset($withdraw->id)) {
            $withdraw->status = APPROVED_STATUS;
            $withdraw->reason = $reason;
            $withdraw->save();

            if ($withdraw->user->details->email != null and isEmailRequired()) {
                $mail = new MailHelper();
                $mail->setUserObject($withdraw->user)
                    ->setWithdrawalObject($withdraw)
                    ->sendMail(WITHDRAWAL_KEY);
            }
        }

        return back()->with('success', Lang::get('withdrawal.success_approved'));;
    }

    function downloadWithdrawals($file_type, $from, $to)
    {
        // echo $date_from.' to '.$date_to;
        $date_from = ($from) ? $from : '';
        $date_to = ($to) ? $to : '';

        $q = Withdrawals::orderBy('id', 'desc');

        if (!empty($date_from)) {
            $q->where('created_at', '>=', $date_from);
        }

        if (!empty($date_to)) {
            $q->where('created_at', '<=', $date_to);
        }

        $withdrawals = $q->get();

        $requestedlist = array(
            'withdrawals' => $withdrawals,
            'date_from' => $from,
            'date_to' => $to
        );

        return \Excel::create('Request Withdrawal Report', function ($excel) use ($requestedlist) {

            $excel->sheet('Request Withdrawal Report', function ($sheet) use (&$requestedlist) {
                $sheet->loadView($this->viewpath . 'request_withdrawal_report')
                    ->withrequestedlist($requestedlist);
            });
        })->download($file_type);
    }
}
