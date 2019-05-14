<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberGrossIncome extends AbstractLayer {

	protected $table = 'member_gross_income';


	function getGrossIncome($type = null)
	{	
		$gross = $this->where('gross_income', '>', 0)
                                                ->orderBy('gross_income', 'DESC');
                                                
		if(empty($type))
		{
			$gross_income = $gross->paginate(50);
		}
		else
		{
			$gross_income = $gross->get();
		}
		
      
        foreach($gross_income as $income)
        {   

            $details = User::select('users.id', 'user_details.first_name', 'user_details.last_name', 'membership_settings.membership_type_name as package_type',
                                             'activation_codes.account_id', 'users.username', 'users.created_at as users_created')
                                             ->leftJoin('user_details', 'user_details.id', '=', 'users.user_details_id')
                                             ->leftJoin('membership_settings', 'membership_settings.id', '=', 'users.member_type_id')
                                             ->leftJoin('activation_codes', 'activation_codes.user_id', '=', 'users.id')
                                             ->where('users.group_id', $income->group_id)
                                             ->first();

            $first_name = (!empty($details->first_name)) ? $details->first_name : '';
            $last_name = (!empty($details->last_name)) ? $details->last_name : '';
            $package_type = (!empty($details->package_type)) ? $details->package_type : '';
            $account_id = (!empty($details->account_id)) ? $details->account_id : '';
            $username = (!empty($details->username)) ? $details->username : '';

            $income->full_name = $first_name.' '.$last_name;
            $income->package_type = $package_type;
            $income->account_id = $account_id;
            $income->username = $username;
            $income->user_created = $details->users_created;

		}
		
		return $gross_income;
	}

}
