<?php namespace App\Models;

class ActivationCodes extends AbstractLayer {

    protected $table = 'activation_codes';

    function membership(){
        return $this->hasOne($this->namespace.'\Membership', 'id', 'type_id');
    }

    public function get_account_name($account_id){
    	return $this->where('account_id', $account_id )
    			->leftJoin('users', 'users.id', '=', 'activation_codes.user_id')
    			->leftJoin('user_details', 'user_details.id', '=', 'users.user_details_id')
    			->first();
    }

    public function get_sponsor_name($account_id){
        return $this->select('first_name', 'last_name', 'activation_codes.account_id', 'user_details.id')->where('account_id', $account_id )
                ->leftJoin('users', 'users.id', '=', 'activation_codes.user_id')
                ->leftJoin('user_details', 'user_details.id', '=', 'users.user_details_id')
                ->first();
    }

    public function getActivationCodes()
    {
        return $this->select('user_details.first_name', 'user_details.last_name',
                        'activation_codes.*', 'branches.name','users.username')
                    ->leftJoin('users', 'users.id', '=', 'activation_codes.teller_id')
                    ->leftJoin('branches', 'branches.id', '=', 'users.branch_id')
                    ->leftJoin('user_details', 'user_details.id', '=', 'users.user_details_id')
                    ->orderBy('activation_codes.created_at', 'DESC');
    }
}
