<?php namespace App\Http\AbstractHandlers;

use App\Helpers\ModelHelper;
use Illuminate\Support\Facades\Validator;

class MainValidationHandler{

    public $result;

    public $inputs;

    protected $rowID;

    protected $rules;

    function __construct(){
        $this->result = new \stdClass();
        $this->result->message = '';
        $this->result->message_type = '';
        $this->result->data = [];
        $this->result->error = false;
    }

    function setInputs($inputs){
        $this->inputs = $inputs;
    }

    function getInputs(){
        return $this->inputs;
    }

    function setRowID($id){
        $this->rowID = $id;
        return $this;
    }

    function getRowID(){
        return $this->rowID;
    }

    function setRules($rules){
        $this->rules = $rules;
        return $this;
    }

    function getRules(){
        return $this->rules;
    }

    function handle($inputs = [], $rules = [], $customMessages = []){

        $validation = Validator::make($inputs, $rules, $customMessages);

        if ($validation->fails()){
            $this->result->error = true;
        }

        $this->result->validation = $validation;

        return $this->result;

    }

}