<?php namespace App\Models;

class PointsSummary extends AbstractLayer {

    protected $table = 'points_summary';
    

    public function getPointsValue()
    {
        return $this->select('user_details.first_name', 'user_details.last_name', 'activation_codes.account_id',
                    'membership_settings.membership_type_name', 'points_summary.account_id as p_account_id', 'points_summary.left_points_value', 'points_summary.right_points_value')
                    ->leftJoin('accounts', 'accounts.id', '=', 'points_summary.account_id')
                    ->leftJoin('users', 'users.id', '=', 'accounts.user_id')
                    ->leftJoin('user_details', 'user_details.id', '=', 'users.user_details_id')
                    ->leftJoin('activation_codes', 'activation_codes.user_id', '=', 'users.id')
                    ->leftJoin('membership_settings', 'membership_settings.id', '=', 'users.member_type_id');
                    // ->orderBy('user_details.first_name', 'ASC');
                    
    }

}
