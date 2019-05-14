<?php

namespace App\Models;

class UpgradedAccount extends AbstractLayer{

    protected $table = 'upgraded_account';

    function user(){
        return $this->hasOne($this->namespace . '\User', 'id', 'user_id');
    }

}
