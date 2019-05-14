<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 3/4/17
 * Time: 11:11 AM
 */

namespace App\Models;

class Downlines extends AbstractLayer{

    protected $table = 'downlines';

    function account(){
        return $this->hasOne($this->namespace. '\Accounts', 'id', 'account_id');
    }

    function getDownlines($account_id, $node)
    {   

        $cd_ids = array();
        $id;
        $downlines = $this->select('users.member_type_id', 'user_details.first_name', 'user_details.last_name', 'activation_codes.account_id',
                            'membership_settings.membership_type_name', 'downlines.account_id as d_account_id', 'membership_settings.points_value', 'downlines.node', 'downlines.created_at', 'accounts.created_at as account_created')
                            ->leftJoin('accounts', 'accounts.id', '=', 'downlines.account_id')
                            ->leftJoin('users', 'users.id', '=', 'accounts.user_id')
                            ->leftJoin('user_details', 'user_details.id', '=', 'users.user_details_id')
                            ->leftJoin('activation_codes', 'activation_codes.user_id', '=', 'users.id')
                            ->leftJoin('membership_settings', 'membership_settings.id', '=', 'users.member_type_id')
                            ->where('downlines.parent_id', '=', $account_id)
                            ->where('downlines.node', '=', $node)
                            ->get();
        
        foreach($downlines as $downline)
        {   
            if($downline->member_type_id > 3)
            {
                $downline->points_value = 0;
            }
            else
            {
                $user_node = $node.'_user_id';
                #check if already paired
                $is_paired = Earnings::where($user_node, $downline->d_account_id)
                                        ->whereIn('source', ['GC', 'pairing'])
                                        ->where('account_id', '=', $account_id)
                                        ->get();
                                        
                if(count($is_paired) != 0)
                {
                    $downline->status = 'Paired';
                    $downline->num_paired = count($is_paired);
                }
                else
                {
                    $downline->status = 'Unpaired';
                }
            }

            

            $first_name = (!empty($downline->first_name)) ? $downline->first_name : '';
            $last_name = (!empty($downline->last_name)) ? $downline->last_name : '';

            $downline->full_name = $first_name.' '.$last_name;
        }

        return $downlines;

    }

    function getTotalPV($account_id, $node)
    {
        $cd_ids = array();
        $id;
        $total_points = 0;
        $downlines = $this->select('membership_settings.points_value', 'users.member_type_id', 'downlines.account_id')
                            ->leftJoin('accounts', 'accounts.id', '=', 'downlines.account_id')
                            ->leftJoin('users', 'users.id', '=', 'accounts.user_id')
                            ->leftJoin('membership_settings', 'membership_settings.id', '=', 'users.member_type_id')
                            ->where('downlines.parent_id', '=', $account_id)
                            ->where('downlines.node', '=', $node)
                            ->get();
                        
        // $parent_pv = Accounts::select('membership_settings.points_value')
        //                     ->leftJoin('users', 'users.id', '=', 'accounts.user_id')
        //                     ->leftJoin('membership_settings', 'membership_settings.id', '=', 'users.member_type_id')
        //                     ->where('accounts.id', '=', $account_id)
        //                     ->first();

        foreach($downlines as $downline)
        {   
            if($downline->member_type_id > 3)
            {
                $downline->points_value = 0;
            }
            else
            {
                #check if account is upgraded
                $is_upgraded = UpgradedAccount::where('account_id', $downline->account_id)->first();
                if(empty($is_upgraded))
                {   
                     #get minimun points value
                    // $min_pv = min($parent_pv->points_value, $downline->points_value);
                    $total_points = $total_points + $downline->points_value;
                }
                
            }
        }

        return $total_points;
    }

}