<?php
/**
 * Created by PhpStorm.
 * User: POA
 * Date: 7/13/17
 * Time: 10:44 AM
 */

namespace App\Helpers;

use Illuminate\Support\Facades\Lang;

class UploadHelper{

    protected $location = 'public/uploads/deposit-slip';
    protected $acceptedTypes = [
        'image/jpg',
        'image/jpeg',
        'image/png',
    ];

    protected $result;

    function __construct(){
        $this->result = new \stdClass();
        $this->result->error = false;
        $this->result->path = null;
        $this->result->message = '';
    }

    function upload($fileInstance){

        if (!in_array($fileInstance->getMimeType(), $this->acceptedTypes)){
            $this->result->error = true;
            $this->result->message = Lang::get('labels.unacceptable_file');
        }

        if (!$this->result->error){
            $newName = sprintf('%s.%s', ShortEncrypt::make(time()), $fileInstance->getClientOriginalExtension());
            $this->result->path = sprintf('%s/%s', $this->location, $newName);

            $fileInstance->move($this->location, $newName);
        }

        return $this->result;

    }

}