<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 4/23/16
 * Time: 6:22 PM
 */

namespace App\Http\Modules\Admin\Products\Validation;

use App\Helpers\ActivationCodeHelperClass;
use App\Helpers\ModelHelper;
use App\Http\AbstractHandlers\MainValidationHandler;
use App\Models\Products;
use App\Models\PurchaseCodes;
use Illuminate\Support\Facades\Validator;

class ProductValidationHandler extends MainValidationHandler{

    protected $numberOfZerosInCode = 7;
    protected $codePrefixLength = 5;
    protected $numberAfterEveryLetter = 3;
    protected $memberID = 0;

    function setMemberID($id){
        $this->memberID = $id;
        return $this;
    }

    function validatePurchaseCodes(){
        $inputs = $this->getInputs();
        $rules = [
            'quantity'=>'required|numeric',
            'product'=>'required'
        ];

        $codeFor = ($this->memberID > 0) ? 'members' : 'products';

        $handle = $this->handle($inputs, $rules);

        if (!$handle->error){

            try {
                $codes = new ActivationCodeHelperClass();
                $codes
                    ->setProductID($inputs['product'])
                    ->setCodeFor($codeFor)
                    ->setOwnerID($this->memberID)
                    ->setNumOfZeros($this->numberOfZerosInCode)
                    ->setPatternEveryLetter($this->numberAfterEveryLetter)
                    ->setPrefixLength($this->codePrefixLength);

                $theCodes = $codes->generateCodes($inputs['quantity']);

                PurchaseCodes::insert($theCodes);

                $label = ($inputs['quantity'] > 1) ? ' codes' : ' code';
                $this->result->message = $inputs['quantity'].$label.' sucessfully generated.';

            } catch (\Exception $e){
                $this->result->error = true;
                $this->result->message = $e->getMessage();
            }
        }

        $this->result->message_type = ($this->result->error) ? 'danger' : 'success';
        return $this->result;
    }

}