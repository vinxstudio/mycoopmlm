<?php
/**
 * Created by PhpStorm.
 * User: POA
 * Date: 7/10/17
 * Time: 4:38 PM
 */

namespace App\Models;

class PaymentHistory extends AbstractLayer{

    protected $table = 'payment_history';

    protected $appends = [
        'user',
        'paidVia'
    ];

    function getUserAttribute(){
        return User::find($this->attributes['user_id']);
    }

    function getPaidViaAttribute(){
        return ucwords(str_replace('-', ' ', $this->attributes['payment_type']));
    }

}