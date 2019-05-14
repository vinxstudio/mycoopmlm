<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 4/23/16
 * Time: 12:05 PM
 */

namespace App\Http\Modules\Admin\ActivationCodes\Validation;

use App\Helpers\ModelHelper;
use App\Http\AbstractHandlers\MainValidationHandler;
use App\Models\ActivationCodeBatches;
use App\Helpers\ActivationCodeHelperClass;
use App\Models\ActivationCodes;
use App\Models\Membership;

class ActivationCodeValidationHandler extends MainValidationHandler{

    protected $teller_id;
    
    function setTellerId( $teller_id ){
        $this->teller_id = $teller_id;
    }

    function validate(){

        $inputs = $this->getInputs();

        if (isset($inputs['generate-code'])){

            $rules = [
                'quantity'=>'required|numeric|min:1',
                'type'=>'required'
            ];

            $validate = $this->handle($inputs, $rules);

            if (!$validate->error){

                $theBatchName = makeBatchId();
				$TypeId = $inputs['type'];
				if ($TypeId != 'free') {
					$membershipType = Membership::find($TypeId);
					//$codeTypeId = $codeType;
					$codeType = $membershipType->membership_type_name;
				}
					
                try {
                    $batch = [
                        'name' => $theBatchName,
						'type' => $codeType
                    ];

                    $manageModel = new ModelHelper();
                    $batchObject = $manageModel->manageModelData(new ActivationCodeBatches, $batch);

                    $codes = new ActivationCodeHelperClass();
                    $codes
                        ->setBatchID($batchObject->id)
                        ->setCodeType($inputs['type'])
                        ->setTellerId($this->teller_id)
                        ->setNumOfZeros(5)
                        ->setPatternEveryLetter(3)
                        ->setPrefixLength(5);

                    $theCodes = $codes->generateCodes($inputs['quantity'], $inputs['type'],$inputs['username']);

                    ActivationCodes::insert($theCodes);

                    $this->result->message = $inputs['quantity'].' Activation codes has been generated';
                    $this->result->batchName = $theBatchName;
                    $this->result->batch_id = $batchObject->id;

                } catch (\Exception $e){
                    $this->result->error = true;

                    $this->result->message = $e->getMessage();
                }

            }

        }

        $this->result->message_type = ($this->result->error) ? 'danger' : 'success';
        return $this->result;

    }

}