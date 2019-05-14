<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 4/29/16
 * Time: 9:56 AM
 */
namespace App\Http\Modules\Admin\Settings\Validation;

use App\Helpers\ModelHelper;
use App\Http\AbstractHandlers\MainValidationHandler;
use App\Models\Company;

class CodeValidationHandler extends MainValidationHandler{

    function __construct(){
        parent::__construct();
    }

    function validate(){
        $inputs = $this->getInputs();
        $rules = $this->getRules();

        $validate = $this->handle($inputs, $rules);

        if (!$validate->error){

            try{

                $model = new ModelHelper();

                $data = [
                    'id'=>1,
                    'activation_code_prefix'=>$inputs['activationPrefix'],
                    'product_code_prefix'=>$inputs['productPrefix']
                ];


                $data['free_code_pairing'] = (isset($inputs['pairing'])) ? 0 : 1;
                $data['free_code_referral'] = (isset($inputs['referral'])) ? 0 : 1;
                $data['multiple_account'] = (isset($inputs['multiple_account'])) ? 0 : 1;

                $model->setPrimaryKey('id')->manageModelData(new Company, $data);

                $this->result->message = 'Code settings are now updated.';

            } catch (\Exception $e){
                $this->result->error = true;
                $this->result->message = $e->getMessage();
            }

        }

        $this->result->message_type = ($this->result->error) ? 'danger' : 'success';

        return $this->result;
    }

}