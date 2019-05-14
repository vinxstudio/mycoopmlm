<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 3/8/17
 * Time: 9:47 PM
 */

namespace App\Models;

class ProductUnilevel extends AbstractLayer{

    protected $table = 'product_unilevel';
    protected $account_id;

    function product(){
        return $this->hasOne($this->namespace . '\Products', 'id', 'product_id');
    }
    
    

}