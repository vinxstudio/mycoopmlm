<?php
/**
 * Created by PhpStorm.
 * User: billycrispilapil
 * Date: 3/7/17
 * Time: 7:41 PM
 */

namespace App\Models;

class ForMaintenance extends AbstractLayer{

    protected $table = 'for_maintenance';

    
    function getMaintenance()
    {   
        return $this->select('users.username', 'activation_codes.account_id', 'for_maintenance.cbu', 'for_maintenance.my_c', 'for_maintenance.created_at',                                  'for_maintenance.receipt', 'user_details.first_name', 'user_details.last_name')
                    ->leftJoin('accounts', 'accounts.id', '=', 'for_maintenance.account_id')
                    ->leftJoin('users', 'users.id', '=', 'accounts.user_id')
                    ->leftJoin('activation_codes', 'activation_codes.id', '=', 'accounts.code_id')
                    ->leftJoin('user_details', 'user_details.id', '=', 'users.user_details_id')
                    ->orderBy('for_maintenance.created_at' , 'DESC');
    }
}
