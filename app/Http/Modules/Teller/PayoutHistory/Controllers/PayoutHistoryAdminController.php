<?php
/**
 * Created by PhpStorm.
 * User: POA
 * Date: 7/13/17
 * Time: 11:26 AM
 */

namespace App\Http\Modules\Admin\PayoutHistory\Controllers;

use App\Http\AbstractHandlers\AdminAbstract;
use App\Models\Accounts;
use App\Models\Earnings;
use App\Models\Membership;
use App\Models\ActivationCodes;
use App\Models\ActivationCodeBatches;
use App\Models\User;
use App\Models\Details;
use App\Models\WeeklyApprovedPayout;
use App\Helpers\CommonHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\Models\WeeklyPayout;
use App\Models\AvailableBalance;
use Carbon\Carbon;

class PayoutHistoryAdminController extends AdminAbstract
{

    protected $viewpath = 'Admin.PayoutHistory.views.';

    function __construct()
    {
        parent::__construct();
    }

    function getIndex()
    {
        $earnings = Earnings::groupBy('user_id')->paginate(30);

        $total_earning = Earnings::whereIn('source', ['direct_referral', 'pairing'])->sum('amount');

        return view($this->viewpath . 'index')
            ->with([
                'payments' => $earnings,
                'total_earnings' => $total_earning,
                'date_from' => '',
                'date_to' => ''
            ]);
    }

    function postIndex(Request $request)
    {

        $payout = array();
        $counter = 0;

        $date_from = (!empty($request->input('date_from'))) ? $request->input('date_from') : '';
        $date_to = (!empty($request->input('date_to'))) ? $request->input('date_to') : '';

        $q = Earnings::groupBy('user_id');

        if (!empty($date_from)) {
            $q->where('earnings.earned_date', '>=', $date_from);
        }

        if (!empty($date_to)) {
            $q->where('earnings.earned_date', '<=', $date_to);
        }

        $earnings = $q->paginate(30);

        $sum_earnings = Earnings::whereIn('source', ['direct_referral', 'pairing']);
        if (!empty($date_from)) {
            $sum_earnings->where('earnings.earned_date', '>=', $date_from);
        }
        if (!empty($date_to)) {
            $sum_earnings->where('earnings.earned_date', '<=', $date_to);
        }
        $total_earnings = $sum_earnings->sum('amount');

        return view($this->viewpath . 'index')
            ->with([
                'payments' => $earnings,
                'date_from' => $date_from,
                'date_to' => $date_to,
                'total_earnings' => $total_earnings,
            ]);
    }

    function getDirectreferral($date_from = null, $date_to = null)
    {

        $date_from = (!empty($date_from)) ? $date_from : '';
        $date_to = (!empty($date_to)) ? $date_to : '';

        $q = Earnings::where('source', 'direct_referral');

        if (!empty($date_from)) {
            $q->where('earnings.earned_date', '>=', $date_from);
        }

        if (!empty($date_to)) {
            $q->where('earnings.earned_date', '<=', $date_to);
        }

        $earnings = $q->get();
        return view($this->viewpath . 'direct_referral_index')
            ->with([
                'payments' => $earnings,
                'date_from' => $date_from,
                'date_to' => $date_to
            ]);
    }

    function postDirectreferral(Request $request)
    {
        return redirect('admin/payout-history/directreferral/' . $request->date_from . '/' . $request->date_to);
    }


    function getMatchingbonus($date_from = null, $date_to = null)
    {

        $date_from = (!empty($date_from)) ? $date_from : '';
        $date_to = (!empty($date_to)) ? $date_to : '';

        $q = Earnings::whereIn('source', ['pairing', 'GC']);

        if (!empty($date_from)) {
            $q->where('earnings.earned_date', '>=', $date_from);
        }

        if (!empty($date_to)) {
            $q->where('earnings.earned_date', '<=', $date_to);
        }

        $earnings = $q->get();
        return view($this->viewpath . 'matching_bonus_index')
            ->with([
                'payments' => $earnings,
                'date_from' => $date_from,
                'date_to' => $date_to
            ]);
    }

    function postMatchingbonus(Request $request)
    {
        return redirect('admin/payout-history/matchingbonus/' . $request->date_from . '/' . $request->date_to);
    }

    function getIncome($date_from = null, $date_to = null, $keyword = null)
    {

        $query = new WeeklyPayout();
        $date_range = array();
        $dates = WeeklyPayout::select('date_from', 'date_to')->orderBy('date_from', 'DESC')->get();

        foreach ($dates as $date) {
            // $month_year =  Carbon::parse($dates['created_at'])->format('F, Y');
            // $month_num = Carbon::parse($dates['created_at'])->month;
            $startDate = date('Y-m-d', strtotime($date->date_from));
            $endDate = date('Y-m-d', strtotime($date->date_to));

            $start_date_index = date("Y-m-d", strtotime($startDate)) . ' 06:00:01';
            $end_date_index = date("Y-m-d", strtotime($endDate)) . ' 05:59:59';

            $date_range_index = $start_date_index . '_' . $end_date_index;

            if (!in_array($date_range_index, $date_range)) {
                $date_range[$date_range_index] = Carbon::parse($startDate)->format('F d, Y') . ' - ' . Carbon::parse($endDate)->format('F d, Y');
            }
        }

        if (empty($date_from) && empty($date_to)) {
            // $shift_date = array_shift($date_range);
            // $date = explode(' - ', $shift_date);

            // $start_date_index = date("Y-m-d", strtotime($date[0])).' 06:00:01';
            // $end_date_index = date("Y-m-d", strtotime($date[1])).' 05:59:59';

            // $date_from = $start_date_index;
            // $date_to = $end_date_index;
            // array_unshift($date_range, $shift_date);

            $last_saturday = date("Y-m-d", strtotime("2 saturdays ago"));
            $current_saturday = date("Y-m-d", strtotime("saturdays ago"));
            // $last_saturday = '2018-06-09';
            // $current_saturday = '2018-06-15';

            $date_from = $last_saturday . ' 06:00:01';
            $date_to = $current_saturday . ' 05:59:59';
        }



        $weekly_details = $query->getWeeklyPayout('display', $date_from, $date_to, $keyword);

        $total_GI = $query->getTotalIncome('gross_income', $date_from, $date_to);
        $total_NI = $query->getTotalIncome('net_income', $date_from, $date_to);

        return view($this->viewpath . 'income_history')
            ->with([
                'weekly_payouts' => $weekly_details,
                'date_range' => $date_range,
                'date_from' => $date_from,
                'date_to' => $date_to,
                'overall_total_GI' => $total_GI,
                'overall_total_NI' => $total_NI,
                'date_range' => $date_range
                // 'total_earnings' => $total_earnings
            ]);
    }

    function postIncome(Request $request)
    {

        $date_range = explode('_', $request->date);
        return redirect('admin/payout-history/income/' . $date_range[0] . '/' . $date_range[1] . '/' . $request->search);
    }

    function getApprove($id, $amount, $from, $to, $status)
    {
        $date_from = $from . ' 06:00:01';
        $date_to = $to . ' 05:59:59';
        $approve = new WeeklyApprovedPayout();
        $approve->approver_id = $this->theUser->id;
        $approve->group_id = $id;
        $approve->amount = $amount;
        $approve->status = $status;
        $approve->date_from = $date_from;
        $approve->date_to = $date_to;

        if ($approve->save()) {
            #get available balance
            $balance = AvailableBalance::where(['group_id' => $id, 'source' => AvailableBalance::SOURCE_TOTAL_INCOME])->first();
            if (empty($balance)) {
                $new_user = new AvailableBalance();
                $new_user->group_id = $id;
                $new_user->available_balance = $amount;

                if ($new_user->save()) {
                    $this->updateWeeklyStatus($id, $status, $date_from, $date_to);
                    return response()->json(['message' => "Successfully approved"]);
                }
            } else {
                $new_balance = $balance->available_balance + $amount;
                $available = AvailableBalance::where(['group_id' => $id, 'source' => AvailableBalance::SOURCE_TOTAL_INCOME])->update(['available_balance' => $new_balance]);
                if ($available) {
                    $this->updateWeeklyStatus($id, $status, $date_from, $date_to);
                    return response()->json(['message' => "Successfully Approved"]);
                }
            }
        }
    }

    function getDecline($id, $amount, $from, $to, $status, $reason = null)
    {
        $date_from = $from . ' 06:00:01';
        $date_to = $to . ' 05:59:59';

        $new_reason = (!empty($reason)) ? $reason : '';
        #check if weekly payout already approved
        $chk_weekly_payout = WeeklyPayout::where('group_id', $id)
            ->where('date_from', $date_from)
            ->where('date_to', $date_to)
            ->first();

        if ($chk_weekly_payout->status == 'approved') {
            $update_status = WeeklyApprovedPayout::where('group_id', $id)
                ->where('date_from', $date_from)
                ->where('date_to', $date_to)
                ->update([
                    'amount' => $amount,
                    'status' => $status,
                    'reason' => $reason,
                ]);

            $balance = AvailableBalance::where(['group_id' => $id, 'source' => AvailableBalance::SOURCE_TOTAL_INCOME])->first();
            $new_balance = $balance->available_balance - $amount;
            $available = AvailableBalance::where(['group_id' => $id, 'source' => AvailableBalance::SOURCE_TOTAL_INCOME])->update(['available_balance' => $new_balance]);
            if ($available) {
                $this->updateWeeklyStatus($id, $status, $date_from, $date_to);
                return response()->json(['message' => "Successfully Declined"]);
            }
        } else {
            $approve = new WeeklyApprovedPayout();
            $approve->approver_id = $this->theUser->id;
            $approve->group_id = $id;
            $approve->amount = $amount;
            $approve->status = $status;
            $approve->reason = $reason;
            $approve->date_from = $date_from;
            $approve->date_to = $date_to;

            if ($approve->save()) {
                $this->updateWeeklyStatus($id, $status, $date_from, $date_to);
                return response()->json(['message' => "Successfully Declined"]);
            }
        }
    }

    function updateWeeklyStatus($id, $status, $from, $to)
    {
        $success = WeeklyPayout::where('group_id', $id)
            ->where('date_from', $from)
            ->where('date_to', $to)
            ->update(['status' => $status]);
        if ($success) {
            return true;
        } else {
            return false;
        }
    }

    function postApprove(Request $request, $id)
    {
        $wa_payout = WeeklyApprovedPayout::find($id);
        $wa_payout->status = 'disapproved';
        $wa_payout->reason = $request->input('delete_reason');
        if ($wa_payout->save()) {
            return response()->json(['message' => "Successfully Canceled"]);
        } else {
            return response()->json(['errors' => "Error cancelling payout."]);
        }
    }

    function getReason($id)
    {
        $code = WeeklyApprovedPayout::select('reason')->where('id', $id)->first();

        if ($code) {
            return response()->json($code);
        }
    }

    function exportIncomeHistory($file_type, $from, $to)
    {
        // echo $date_from.' to '.$date_to;
        // $q = User::leftjoin('user_details', 'user_details.id', '=', 'users.user_details_id')
        //              ->where('users.role','member')
        //              ->orderBy('user_details.first_name', 'ASC')
        //              ->groupBy('users.group_id');

        // $users = $q->get();

        $query = new WeeklyPayout();
        $weekly_details = $query->getWeeklyPayout('download', $from, $to);

        $total_DR = $query->getTotalIncome('direct_referral', $from, $to);
        $total_MB = $query->getTotalIncome('matching_bonus', $from, $to);
        $total_GC = $query->getTotalIncome('gift_check', $from, $to);
        $total_GI = $query->getTotalIncome('gross_income', $from, $to);
        $total_NI = $query->getTotalIncome('net_income', $from, $to);

        $earningexcel = array(
            'payments' => $weekly_details,
            'direct_referral' => $total_DR,
            'matching_bonus' => $total_MB,
            'gift_check' => $total_GC,
            'gross_income' => $total_GI,
            'net_income' => $total_NI,
            'date_from' => $from,
            'date_to' => $to
        );

        return \Excel::create('Income_Hisotry', function ($excel) use ($earningexcel) {

            $excel->sheet('Income_Hisotry', function ($sheet) use (&$earningexcel) {
                $sheet->loadView($this->viewpath . 'income_history_excel')
                    ->withearningexcel($earningexcel);
            });
        })->download($file_type);
    }

    function exportPayoutHistory($file_type, $type, $from, $to)
    {

        $date_from = (!empty($from)) ?  date('Y-m-d H:i:s', strtotime($from)) : '';
        $date_to = (!empty($to)) ? date('Y-m-d H:i:s', strtotime($to)) : '';

        if ($type == 'DR') { // DR
            $q = Earnings::where('source', 'direct_referral');

            if (!empty($date_from)) {
                $q->where('earnings.earned_date', '>=', $date_from);
            }

            if (!empty($date_to)) {
                $q->where('earnings.earned_date', '<=', $date_to);
            }

            $earnings = $q->get();
            $earningexcel = array(
                'payments' => $earnings,
                'date_from' => $date_from,
                'date_to' => $date_to
            );

            return \Excel::create('Payout_History_Direct_referral', function ($excel) use ($earningexcel) {

                $excel->sheet('Payout_History_Direct_referral', function ($sheet) use (&$earningexcel) {
                    $sheet->loadView($this->viewpath . 'direct_referral_excel')
                        ->withearningexcel($earningexcel);
                });
            })->download($file_type);
        } else if ($type == 'all') {
            $q = Earnings::groupBy('user_id');

            if (!empty($date_from)) {
                $q->where('earnings.earned_date', '>=', $date_from);
            }

            if (!empty($date_to)) {
                $q->where('earnings.earned_date', '<=', $date_to);
            }

            $earnings = $q->get();
            $earningexcel = array(
                'payments' => $earnings,
                'date_from' => $date_from,
                'date_to' => $date_to
            );

            return \Excel::create('Payout_History', function ($excel) use ($earningexcel) {

                $excel->sheet('Payout_History', function ($sheet) use (&$earningexcel) {
                    $sheet->loadView($this->viewpath . 'payout_history_excel')
                        ->withearningexcel($earningexcel);
                });
            })->download($file_type);
        } else { // MB
            $q = Earnings::whereIn('source', ['pairing', 'GC']);

            if (!empty($date_from)) {
                $q->where('earnings.earned_date', '>=', $date_from);
            }

            if (!empty($date_to)) {
                $q->where('earnings.earned_date', '<=', $date_to);
            }

            $earnings = $q->get();

            $earningexcel = array(
                'payments' => $earnings,
                'date_from' => $date_from,
                'date_to' => $date_to
            );

            return \Excel::create('Payout_Matching_Bonus', function ($excel) use ($earningexcel) {

                $excel->sheet('Payout_Matching_Bonus', function ($sheet) use (&$earningexcel) {
                    $sheet->loadView($this->viewpath . 'matching_bonus_excel')
                        ->withearningexcel($earningexcel);
                });
            })->download($file_type);
        }
    }

    function getAction($action, $paymentID)
    {
        $actionLabel = ($action == 'approve') ? APPROVED_STATUS : DENIED_STATUS;

        PaymentHistory::where([
            'id' => $paymentID
        ])->update([
            'status' => ($action == 'approve') ? 'approved' : 'denied'
        ]);

        if ($action == 'approve') {
            $payment = PaymentHistory::find($paymentID);
            $user = User::find($payment->user_id);
            $user->needs_activation = TRUE_STATUS;
            $user->save();
        }

        return redirect('admin/payment-history')->with([
            'success' => sprintf('%s %s', Lang::get('labels.payment_status_changed'), $actionLabel)
        ]);
    }

    function directReferral($accountid, $from, $to)
    {
        $payout = array();

        $from = (!empty($from)) ? date('Y-m-d H:i:s', $from) : 0;
        $to = (!empty($to)) ? date('Y-m-d H:i:s', $to) : 0;

        $user_account = Accounts::find($accountid);
        $user = User::find($user_account->user_id);
        $activationcode = ActivationCodes::where('user_id', $user->id)->first();
        $activationBatch = ActivationCodeBatches::find($activationcode->batch_id);
        //echo $activationcode->batch_id;
        $batchname = (!isset($activationBatch->name)) ? '' : $activationBatch->name;
        $membership = Membership::find($user->member_type_id);
        $fullname = Details::find($user->user_details_id);


        $DR_q = Earnings::where('source', 'direct_referral')
            ->where('account_id', $accountid);

        if (!empty($from)) $DR_q->whereDate('earnings.earned_date', '>=', $from);
        if (!empty($to)) $DR_q->whereDate('earnings.earned_date', '<=', $to);

        $DRamount = $DR_q->sum('amount');

        $user_info = array(
            'batchid' => $batchname,
            'code' => $activationcode->code,
            'accountid' => $activationcode->account_id,
            'username' => $user->username,
            'fullname' => $fullname->first_name . ' ' . $fullname->last_name,
            'package' => $membership->membership_type_name,
            'total_mb_amount' => ($DRamount) ? number_format($DRamount, 2) : '0.00'
        );

        $q = Earnings::where('source', 'direct_referral')
            ->where('account_id', $accountid);

        if (!empty($from)) $q->whereDate('earnings.earned_date', '>=', $from);
        if (!empty($to)) $q->whereDate('earnings.earned_date', '<=', $to);

        $earnings = $q->orderBy('earnings.earned_date', 'ASC')->get();

        foreach ($earnings as $earning) {
            $r_account = Accounts::find($earning->left_user_id);
            $r_user = User::find($r_account->user_id);
            $r_user_details = Details::find($r_user->user_details_id);
            $r_membership = Membership::find($r_user->member_type_id);
            $r_activationcode = ActivationCodes::where('user_id', $r_user->id)->first();

            $payout[] = [
                'account_id' => $r_activationcode->account_id,
                'name' => $r_user_details->first_name . ' ' . $r_user_details->last_name,
                'package' => $r_membership->membership_type_name,
                'dr' => $earning->amount,
                'date' => $earning->earned_date,
            ];
        }

        return view($this->viewpath . 'direct_referral')
            ->with([
                'payments' => $payout,
                'user_info' => $user_info
            ]);
    }

    function matchingBonus($accountid, $from, $to)
    {
        $payout = array();

        $from = (!empty($from)) ? date('Y-m-d H:i:s', $from) : 0;
        $to = (!empty($to)) ? date('Y-m-d H:i:s', $to) : 0;

        $user_account = Accounts::find($accountid);
        $user = User::find($user_account->user_id);
        $activationcode = ActivationCodes::where('user_id', $user->id)->first();
        $activationBatch = ActivationCodeBatches::find($activationcode->batch_id);
        //echo $activationcode->batch_id;
        $batchname = (!isset($activationBatch->name)) ? '' : $activationBatch->name;
        $membership = Membership::find($user->member_type_id);
        $fullname = Details::find($user->user_details_id);

        $MB_q = Earnings::where('source', 'pairing')
            ->where('account_id', $accountid);

        if (!empty($from)) $MB_q->whereDate('earnings.earned_date', '>=', $from);
        if (!empty($to)) $MB_q->whereDate('earnings.earned_date', '<=', $to);

        $MBAmount = $MB_q->sum('amount');

        $user_info = array(
            'batchid' => $batchname,
            'code' => $activationcode->code,
            'accountid' => $activationcode->account_id,
            'username' => $user->username,
            'fullname' => $fullname->first_name . ' ' . $fullname->last_name,
            'package' => $membership->membership_type_name,
            'total_mb_amount' => ($MBAmount) ? number_format($MBAmount, 2) : '0.00'
        );

        $q = Earnings::whereIn('source', ['pairing', 'GC'])
            ->where('account_id', $accountid);

        if (!empty($from)) $q->whereDate('earnings.earned_date', '>=', $from);
        if (!empty($to)) $q->whereDate('earnings.earned_date', '<=', $to);

        $earnings = $q->orderBy('earnings.earned_date', 'ASC')->get();

        foreach ($earnings as $earning) {
            $l_account = Accounts::find($earning->left_user_id);
            $l_user = User::find($l_account->user_id);
            $l_user_details = Details::find($l_user->user_details_id);
            $l_membership = Membership::find($l_user->member_type_id);
            $l_activationcode = ActivationCodes::where('user_id', $l_user->id)->first();


            $r_account = Accounts::find($earning->right_user_id);
            $r_user = User::find($r_account->user_id);
            $r_user_details = Details::find($r_user->user_details_id);
            $r_membership = Membership::find($r_user->member_type_id);
            $r_activationcode = ActivationCodes::where('user_id', $r_user->id)->first();

            $payout[] = [
                'left_account_id' => $l_activationcode->account_id,
                'left_name' => $l_user_details->first_name . ' ' . $l_user_details->last_name,
                'left_package' => $l_membership->membership_type_name,
                'left_account_date' => $l_account->created_at,

                'right_account_id' => $r_activationcode->account_id,
                'right_name' => $r_user_details->first_name . ' ' . $r_user_details->last_name,
                'right_package' => $r_membership->membership_type_name,
                'right_account_date' => $r_account->created_at,

                'mb' => ($earning->amount == 1) ? 0 : $earning->amount,
                'date' => $earning->earned_date,

            ];
        }

        return view($this->viewpath . 'matching_bonus')
            ->with([
                'payments' => $payout,
                'user_info' => $user_info
            ]);
    }
}
