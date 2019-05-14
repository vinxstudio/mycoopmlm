<?php namespace App\Models;

class EncashmentSummary extends AbstractLayer {

    protected $table = 'encashment_summary';
    

    function getEncashmentSummary($group_id)
    {
        $details = $this->where('group_id', $group_id)->orderBy('created_at', 'ASC')->paginate(10);

        foreach ($details as $detail) {
            #get username
            $q = User::select('users.username', 'users.member_type_id', 'membership_settings.membership_type_name')
                        ->leftJoin('membership_settings', 'membership_settings.id', '=', 'users.member_type_id')
                        ->where('users.id', '=', $detail->user_id)
                        ->first();
            
            $detail->package_type = $q->membership_type_name;
            $detail->username = $q->username;
        }

        return $details;
    }

    function insertSummary($data)
    {
        
    }
	
}
