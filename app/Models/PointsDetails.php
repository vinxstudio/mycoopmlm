<?php namespace App\Models;

class PointsDetails extends AbstractLayer {

    protected $table = 'points_details';
    

    public function getDetails($account_id)
    {
        $details = $this->select('user_details.first_name', 'user_details.last_name',
                                'activation_codes.account_id',
                                'membership_settings.membership_type_name', 'points_details.downline_account_id',
                                'points_details.node', 'points_details.left_points_value', 'points_details.right_points_value',
                                'points_details.flushout_points','points_details.retention_points', 'points_details.paired_account',
                                'points_details.reason_for_flushout', 'points_details.created_at')
                                ->leftJoin('accounts', 'accounts.id', '=', 'points_details.downline_account_id')
                                ->leftJoin('users', 'users.id', '=', 'accounts.user_id')
                                ->leftJoin('user_details', 'user_details.id', '=', 'users.user_details_id')
                                ->leftJoin('activation_codes', 'activation_codes.id', '=', 'accounts.code_id')
                                ->leftJoin('membership_settings', 'membership_settings.id', '=', 'users.member_type_id')
                                ->where('points_details.parent_account_id', '=', $account_id)
                                ->orderBy('points_details.created_at', 'ASC')
                                ->get();

            foreach($details as $detail)
            {   

                $is_upgraded = UpgradedAccount::where('account_id', '=', $detail->downline_account_id)->count() > 0;

                if($is_upgraded)
                {
                    $detail->upgraded_account = 'Upgraded Account';
                }
                else
                {
                    $detail->upgraded_account = '';
                }

                if($detail->paired_account == '1' || $detail->paired_account == '')
                {
                    $paired_account = '';
                }
                else
                {
                    $paired_account = $detail->paired_account;
                   
                    $ids = explode('-', $paired_account);
                    
                    $left_accounts = Accounts::select('user_id', 'code_id')->where('id', $ids[0])->first();
                    $right_accounts = Accounts::select('user_id', 'code_id')->where('id', $ids[1])->first();

                    $left_code = ActivationCodes::select('account_id')->where('id', $left_accounts->code_id)->first();
                    $right_code = ActivationCodes::select('account_id')->where('id', $right_accounts->code_id)->first();

                    $left_user = User::select('user_details_id', 'member_type_id')->where('id', $left_accounts->user_id)->first();
                    $right_user = User::select('user_details_id', 'member_type_id')->where('id', $right_accounts->user_id)->first();

                    $left_member_name = Membership::select('membership_type_name')->where('id', $left_user->member_type_id)->first();
                    $right_member_name = Membership::select('membership_type_name')->where('id', $right_user->member_type_id)->first();

                    $left_details = Details::select('first_name', 'last_name')->where('id', $left_user->user_details_id)->first();
                    $right_details = Details::select('first_name', 'last_name')->where('id', $right_user->user_details_id)->first();
                    
                    $left_firstname = (!empty($left_details->first_name)) ? $left_details->first_name : '';
                    $left_lastname = (!empty($left_details->last_name)) ? $left_details->last_name : '';

                    $right_firstname = (!empty($right_details->first_name)) ? $right_details->first_name : '';
                    $right_lastname = (!empty($right_details->last_name)) ? $right_details->last_name : '';

                    $detail->left_details = $left_firstname.' '.$left_lastname.' ('.$left_code->account_id.' - '.$left_member_name->membership_type_name.')';
                    $detail->right_details = $right_firstname.' '.$right_lastname.' ('.$right_code->account_id.' - '.$right_member_name->membership_type_name.')';
                }

            }

        return $details;
                    
    }

}
