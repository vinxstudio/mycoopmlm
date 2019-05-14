<?php namespace App\Models;

class Branches extends AbstractLayer {

	protected $table = 'branches';

    function company(){
        return $this->hasOne($this->namespace.'\Company', 'id', 'company_id');
    }

}
