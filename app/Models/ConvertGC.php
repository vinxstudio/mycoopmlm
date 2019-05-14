<?php

namespace App\Models;

class ConvertGC extends AbstractLayer{

    protected $table = 'gc_convert';


    function getGiftCheckHistory()
    {

        $convertedGC = $this->select('earnings.left_user_id', 'earnings.right_user_id','earnings.account_id','earnings.earned_date',
                                    'gc_convert.id','gc_convert.voucher_value', 'gc_convert.earnings_id', 'gc_convert.type', 'gc_convert.created_at', 'gc_convert.updated_at',
                                    'gc_convert.converted_voucher_value', 'gc_convert.user_id', 'gc_convert.status','gc_convert.reason',
                                    'user_details.first_name', 'user_details.last_name')
                                    ->leftJoin('earnings', 'earnings.id', '=', 'gc_convert.earnings_id')
                                    ->leftJoin('user_details','user_details.id', '=', 'gc_convert.validated_by_id')
                                    ->orderBy('gc_convert.created_at', 'DESC')
                                    ->where('gc_convert.id', '!=', 0);

        return $convertedGC;
    }

    function getConvertedGCDetails($converted_gc)
    {   
        foreach($converted_gc as $gc) {

            $left_accounts = Accounts::select('user_id')->where('id', $gc->left_user_id)->first();
            $right_accounts = Accounts::select('user_id')->where('id', $gc->right_user_id)->first();
            $upline_accounts = Accounts::select('user_id')->where('id', $gc->account_id)->first();
            $gc->left_details = User::select('users.member_type_id', 'user_details.first_name', 'user_details.last_name', 'activation_codes.account_id')
                                    ->leftJoin('user_details', 'user_details.id', '=', 'users.user_details_id')
                                    ->leftJoin('activation_codes', 'activation_codes.user_id', '=', 'users.id')
                                    ->where('users.id', $left_accounts->user_id)
                                    ->first();
            $gc->right_details = User::select('users.member_type_id', 'user_details.first_name', 'user_details.last_name', 'activation_codes.account_id')
                                    ->leftJoin('user_details', 'user_details.id', '=', 'users.user_details_id')
                                    ->leftJoin('activation_codes', 'activation_codes.user_id', '=', 'users.id')
                                    ->where('users.id', $right_accounts->user_id)
                                    ->first();
            $gc->upline_details = User::select('users.member_type_id', 'user_details.first_name', 'user_details.last_name', 'activation_codes.account_id')
                                    ->leftJoin('user_details', 'user_details.id', '=', 'users.user_details_id')
                                    ->leftJoin('activation_codes', 'activation_codes.user_id', '=', 'users.id')
                                    ->where('users.id', $upline_accounts->user_id)
                                    ->first();
            $gc->left_fullName = $gc->left_details->first_name.' '.$gc->left_details->last_name;
            $gc->right_fullName = $gc->right_details->first_name.' '.$gc->right_details->last_name;
            $gc->upline_fullName = $gc->upline_details->first_name.' '.$gc->upline_details->last_name;
            $gc->membership_left = Membership::select('membership_type_name', 'pairing_income')
                                                ->where('id', $gc->left_details->member_type_id)
                                                ->first();
            $gc->membership_right = Membership::select('membership_type_name', 'pairing_income')
                                                ->where('id', $gc->right_details->member_type_id)
                                                ->first();
            $gc->membership_upline = Membership::select('membership_type_name', 'pairing_income')
                                                ->where('id', $gc->upline_details->member_type_id)
                                                ->first();
        }

        return $converted_gc;
     
    }
    
}
