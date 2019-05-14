<?php namespace App\Models;

class Details extends AbstractLayer {

	protected $table = 'user_details';

    protected $appends = ['fullName', 'thePhoto'];

    function credentials(){
        return $this->hasOne($this->namespace.'\User', 'user_details_id', 'id');
    }

    function accounts(){
        return $this->hasMany($this->namespace.'\Accounts', 'user_details_id', 'id');
    }

    function earnings(){
        return $this->hasMany($this->namespace.'\Earnings', 'user_id', 'id');
    }

    function getFullNameAttribute(){
        return $this->attributes['first_name']. ' '.$this->attributes['middle_name'].' ' .$this->attributes['last_name'];
    }

    function getThePhotoAttribute(){
        $photo = $this->attributes['photo'];
        return (file_exists($photo)) ? $photo : 'public/custom/images/default_user.jpg';
    }

}
