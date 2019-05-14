<?php

/**
 * Created by PhpStorm.
 * User: billycris
 * Date: 3/7/17
 * Time: 7:41 PM
 */

namespace App\Models;

class WeeklyPayout extends AbstractLayer
{

    protected $table = 'weekly_payout';


    function getWeeklyPayout($type, $date_from = null, $date_to = null, $keyword = null)
    {


        if ($type == 'display') {
            if ($keyword != null) {
                $collectedUserId = [0];

                $q1 = Details::select('users.group_id')
                    ->leftJoin('users', 'users.user_details_id', '=', 'user_details.id')
                    ->where('first_name', 'like', '%' . $keyword . '%')
                    ->orWhere('last_name', 'like', '%' . $keyword . '%')
                    ->first();
    
                // $activationCodes = ActivationCodes::where('account_id', 'like', '%'.$keyword.'%')->where('status', 'used')->get();
    
                // $activationIds = [];
    
                // foreach ($activationCodes as $row){
                //     $activationIds[] = $row->id;
                // }
    
                // if (count($activationIds) > 0) {
                //     $accounts = Accounts::whereIn('code_id', $activationIds)->get();
                //     foreach ($accounts as $acc){
                //         $collectedUserId[] = $acc->user_id;
                //     }
                // }
                if ($q1) {
                    $weekly_details = $this->select(
                        'weekly_payout.group_id',
                        'weekly_payout.user_id',
                        'weekly_payout.direct_referral',
                        'weekly_payout.matching_bonus',
                        'weekly_payout.gift_check',
                        'weekly_payout.gross_income',
                        'weekly_payout.net_income',
                        'weekly_payout.status',
                        'weekly_payout.date_from',
                        'weekly_payout.date_to'
                    )
                        ->where('date_from', '>=', $date_from)
                        ->where('date_to', '<=', $date_to)
                        ->where('weekly_payout.group_id', '=', $q1->group_id)
                        ->paginate(50);
                } else {
                    $weekly_details = [];
                }

            } else {
                $weekly_details = $this->select(
                    'weekly_payout.group_id',
                    'weekly_payout.user_id',
                    'weekly_payout.direct_referral',
                    'weekly_payout.matching_bonus',
                    'weekly_payout.gift_check',
                    'weekly_payout.gross_income',
                    'weekly_payout.net_income',
                    'weekly_payout.status',
                    'weekly_payout.date_from',
                    'weekly_payout.date_to'
                )
                    ->where('date_from', '>=', $date_from)
                    ->where('date_to', '<=', $date_to)
                    ->paginate(50);
            }


        } else {
            $weekly_details = $this->select(
                'weekly_payout.group_id',
                'weekly_payout.user_id',
                'weekly_payout.direct_referral',
                'weekly_payout.matching_bonus',
                'weekly_payout.gift_check',
                'weekly_payout.gross_income',
                'weekly_payout.net_income',
                'weekly_payout.status',
                'weekly_payout.date_from',
                'weekly_payout.date_to'
            )
                ->where('date_from', '>=', $date_from)
                ->where('date_to', '<=', $date_to)
                ->get();
        }


        foreach ($weekly_details as $details) {

            $q = User::select('users.username', 'users.member_type_id', 'user_details.first_name', 'user_details.last_name', 'membership_settings.membership_type_name', 'membership_settings.entry_fee', 'activation_codes.account_id')
                ->leftjoin('user_details', 'user_details.id', '=', 'users.user_details_id')
                ->leftJoin('activation_codes', 'activation_codes.user_id', '=', 'users.id')
                ->leftJoin('membership_settings', 'membership_settings.id', '=', 'users.member_type_id')
                ->where('users.id', '=', $details->user_id)
                ->first();

            $total_earnings = Earnings::where('user_id', $details->user_id)
                ->whereIn('source', ['pairing', 'direct_referral'])
                ->sum('amount');
            
            #check if CD Account
            if ($q->member_type_id > 3) {
                $entry_fee = abs($q->entry_fee);
                $admin_entry_fee = $entry_fee * 0.1;
                $total_fee = ($entry_fee * 2) + $admin_entry_fee;


                if ($total_earnings < $total_fee) {
                    $cd_account_fee = $details->gross_income / 2;
                    $cd_admin_fee = $details->gross_income * 0.1;
                    $total_deduction = $cd_account_fee + $cd_admin_fee;
                    $cd_account_fee = $cd_account_fee;
                    $net_income = $details->gross_income - $total_deduction;
                } else {
                    $cd_account_fee = 0;
                    $net_income = $details->net_income;
                }

                $details->cd_account_fee = $cd_account_fee;
                $details->net_income = $net_income;

            } else {
                $details->cd_account_fee = 0;
            }

            $admin_fee = $details->gross_income * 0.1;

            $details->admin_fee = $admin_fee;

            $first_name = (!empty($q->first_name)) ? $q->first_name : '';
            $last_name = (!empty($q->last_name)) ? $q->last_name : '';
            $username = (!empty($q->username)) ? $q->username : '';

            $details->full_name = $first_name . ' ' . $last_name;
            $details->package_type = $q->membership_type_name;
            $details->account_id = $q->account_id;
            $details->username = $username;
            $details->total_earnings = $total_earnings;

        }
        return $weekly_details;

    }

    function getTotalIncome($source, $from, $to)
    {
        return $this->where('date_from', '>=', $from)
            ->where('date_to', '<=', $to)
            ->sum($source);
    }

    function getWeeklyPayoutById($group_id)
    {
        $details = $this->where('group_id', $group_id)->orderBy('date_from', 'DESC')->paginate(10);
        foreach ($details as $detail) {
            #get username
            $q = User::select('users.username', 'users.member_type_id', 'membership_settings.membership_type_name', 'membership_settings.entry_fee')
                ->leftjoin('user_details', 'user_details.id', '=', 'users.user_details_id')
                ->leftJoin('membership_settings', 'membership_settings.id', '=', 'users.member_type_id')
                ->where('users.id', '=', $detail->user_id)
                ->first();

            $total_earnings = Earnings::where('user_id', $detail->user_id)
                ->whereIn('source', ['pairing', 'direct_referral'])
                ->sum('amount');
            
            #check if CD Account
            if ($q->member_type_id > 3) {
                $entry_fee = abs($q->entry_fee);
                $admin_entry_fee = $entry_fee * 0.1;
                $total_fee = ($entry_fee * 2) + $admin_entry_fee;


                if ($total_earnings < $total_fee) {
                    $cd_account_fee = $detail->gross_income / 2;
                    $cd_admin_fee = $detail->gross_income * 0.1;
                    $total_deduction = $cd_account_fee + $cd_admin_fee;
                    $detail->cd_account_fee = $cd_account_fee;
                    $detail->net_income = $detail->gross_income - $total_deduction;
                }

            } else {
                $details->cd_account_fee = 0;
            }

            $admin_fee = $detail->gross_income * 0.1;
            $detail->admin_fee = $admin_fee;
            $detail->package_type = $q->membership_type_name;
            $detail->username = $q->username;
        }

        return $details;
    }

}