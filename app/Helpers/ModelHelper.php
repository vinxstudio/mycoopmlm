<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 4/22/16
 * Time: 11:24 PM
 */

namespace App\Helpers;

class ModelHelper{

    protected $primaryKey = 'id';

    function setPrimaryKey($fieldName){
        $this->primaryKey = $fieldName;
        return $this;
    }

    private function getPrimaryKey(){
        return $this->primaryKey;
    }

    function manageModelData($model, $values){

        $primaryKey = $this->getPrimaryKey();

        if (isset($values[$primaryKey]) and $values[$primaryKey] > 0){
            $model = $model->find($values[$primaryKey]);
        }

        foreach($values as $field => $val){
            $model->$field = $val;
        }

        $model->save();

        return $model;

    }

}