<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 3/7/17
 * Time: 7:41 PM
 */

namespace App\Models;

class UserDetails extends AbstractLayer{

    protected $table = 'user_details';

    public function user(){
        return $this->hasOne($this->namespace . '\User', 'user_details_id', 'id');
    }

    public function account(){
    	return $this->hasOne($this->namespace . '\Accounts', 'user_id', 'id');
    }

    public function getCdAccounts($keyword = null, $download = null)
    {   

        $members = $this->select('users.id as user_id', 'users.username', 'users.member_type_id', 'users.role', 'users.created_at',
                                'membership_settings.membership_type_name', 'membership_settings.entry_fee',
                                'user_details.first_name', 'user_details.last_name', 'activation_codes.account_id', \DB::raw('SUM(earnings.amount) as total_earnings'))
                        ->leftjoin('users', 'users.user_details_id', '=', 'user_details.id')
                        ->leftjoin('activation_codes', 'activation_codes.user_id', '=', 'users.id')
                        ->leftJoin('membership_settings', 'membership_settings.id', '=', 'users.member_type_id')
                        ->leftJoin('earnings', 'earnings.user_id', '=', 'users.id')
                        ->whereIn('earnings.source', ['pairing', 'direct_referral'])
                        ->orderBy('total_earnings', 'DESC')
                        ->groupBy('activation_codes.account_id');
               

        if ($keyword != null){
            $collectedUserId = [0];

            $q1 = Details::where('first_name', 'like', '%'.$keyword.'%')
            ->orWhere('last_name', 'like', '%'.$keyword.'%')->get();

            $detailsId = [0];

            foreach ($q1 as $q1row){
                $detailsId[] = $q1row->id;
            }

            $activationCodes = ActivationCodes::where('account_id', 'like', '%'.$keyword.'%')->where('status', 'used')->get();

            $activationIds = [];

            foreach ($activationCodes as $row){
                $activationIds[] = $row->id;
            }

            if (count($activationIds) > 0) {
                $accounts = Accounts::whereIn('code_id', $activationIds)->get();
                foreach ($accounts as $acc){
                    $collectedUserId[] = $acc->user_id;
                }
            }
            
            
            
            $members->where('users.username', 'like', '%'.$keyword.'%')
                        ->where('users.member_type_id', '>', 3)
                        ->where('users.role', 'member')
                    ->orWhereIn('users.id', $collectedUserId)
                        ->where('users.member_type_id', '>', 3)
                        ->where('users.role', 'member')
                    ->orWhereIn('users.user_details_id', $detailsId)
                        ->where('users.member_type_id', '>', 3)
                        ->where('users.role', 'member');
        }
        
        $members->where('users.member_type_id', '>', 3)
                ->where('users.role', 'member');

        if($download != null)
        {   
            $details = $members->get();
        }
        else
        {
            $details = $members->paginate(50);
        }            
        
        foreach($details as $member)
        {   
            $first_name = (!empty($member->first_name)) ? $member->first_name : '';
            $last_name = (!empty($member->last_name)) ? $member->last_name : '';

            #get earnings
            // $total_earnings = Earnings::where('user_id', $member->user_id)
            //                             ->whereIn('source',['pairing', 'direct_referral'])
            //                             ->sum('amount');

            // $member->total_earnings = (!empty($member->total_earnings)) ? $member->$total_earnings : 0;
            $member->full_name = strtoupper($first_name).' '.strtoupper($first_name);
            $member->account_id = strtoupper($member->account_id);
            $member->role = ucwords($member->role);
        }

        return $details;
    }

}