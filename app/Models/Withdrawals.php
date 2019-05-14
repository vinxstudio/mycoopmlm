<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 3/7/17
 * Time: 7:41 PM
 */

namespace App\Models;

class Withdrawals extends AbstractLayer
{

    protected $table = 'withdrawals';

    const SOURCE_EARNINGS_TOTAL = 'earnings_income';
    const SOURCE_REDUNDANT_INCOME = 'redundat_binary_income';

    function user()
    {
        return $this->hasOne($this->namespace . '\User', 'id', 'user_id');
    }

    function getMaintenance()
    {
        return $this->select(
            'users.username',
            'activation_codes.account_id',
            'withdrawals.maintenance',
            'withdrawals.created_at',
            'user_details.first_name',
            'user_details.last_name'
        )
            ->leftJoin('accounts', 'accounts.user_id', '=', 'withdrawals.user_id')
            ->leftJoin('users', 'users.id', '=', 'accounts.user_id')
            ->leftJoin('activation_codes', 'activation_codes.id', '=', 'accounts.code_id')
            ->leftJoin('user_details', 'user_details.id', '=', 'users.user_details_id')
            ->where('withdrawals.maintenance', '!=', 0)
            ->where('withdrawals.status', '=', 'approved')
            ->orderBy('withdrawals.created_at', 'DESC');
    }
}
