<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 4/23/16
 * Time: 12:05 PM
 */
namespace App\Http\Modules\Teller\ActivationCodes\Validation;

use App\Helpers\ModelHelper;
use App\Http\AbstractHandlers\MainValidationHandler;
use App\Models\ActivationCodeBatches;
use App\Helpers\ActivationCodeHelperClass;
use App\Models\ActivationCodes;
use App\Models\Membership;
use Exception;

class ActivationCodeValidationHandler extends MainValidationHandler{

	protected $teller_id;
	
	function setTellerId( $teller_id ){
		$this->teller_id = $teller_id;
	}


	function validate2(){

        $inputs = $this->getInputs();
		$validation = false;
		$qtyFlag = 0;
		$this->result = new \stdClass();
        $this->result->message = '';
        $this->result->message_type = '';
        $this->result->data = [];
        $this->result->error = false;
		$message = 0;
		
        
        // if (isset($inputs['generate-code'])){
        if (isset($_POST)){
        	
        	$packages = explode(',',$inputs['packages']);
        	$quantity = explode(',',$inputs['no_of_codes']);
        	$names = explode(',', $inputs['name']);
        	$coop_id = explode(',', $inputs['coop_id']);
        	$inputs['list'] = array();

        	for($i = 0; $i < count($packages); $i++){
        		$inputs['list'][] = array(
        			'type' => $packages[$i],
        			'quantity' => $quantity[$i],
        			'name' => $names[$i],
        			'coop_id' => $coop_id[$i]
        		);
        	}

        	$or_number = $inputs['ornumber'];
        	$payors_name = $inputs['payorname'];
        	$payment_method = $inputs['method'];
        	// return $payment_method;
			// if ($inputs['quantity-1'] <= 0 ) {
			// 	$qtyFlag += 0;
			// } else {
			// 	$qtyFlag++;
			// }
			// if ($inputs['quantity-2'] <= 0 ) {
			//     $qtyFlag += 0;
			// }else {
			// 	$qtyFlag++;
			// }
   //          if ($inputs['quantity-3'] <= 0) {
			// 	$qtyFlag += 0;
			// } else {
			// 	$qtyFlag++;
			// }
			

			// if ($qtyFlag <= 0) {
			// 	$validation = false;
			//     $this->result->error = true;
			// 	$this->result->message = 'Please do fill in any quantity amount.';
			// 	$this->result->message_type = "danger";
			// 	$message = "Please do fill in any quantity amount.";
			// } else {
			// 	$validation = true; 
   //              $this->result->error = false;
				
			// }

			$validation = true;
            if ($validation){
				try {

					// validate OR NUMBER
					$or = ActivationCodes::where('or_number', $or_number)->count();
		        	if($or > 0){
		        		throw new Exception("OR number already exist.");
        			}

					$counter = "";
					$codeGenerator = "";
					$theBatchName = makeBatchId();
					
					foreach($inputs['list'] as $v){

						$counter += $v['quantity'];

						// if ($inputs['quantity-1'] > 0) {
						if ($v['quantity'] > 0  && $v['type'] == 'quantity-1') {
							$codeType = 1;
							$codeFor = 'member';
							$batch1 = [
								'name' => $theBatchName,
								'type' => 'Package A'
							];

							$manageModel = new ModelHelper();
							$batchObject = $manageModel->manageModelData(new ActivationCodeBatches, $batch1);

							$codes = new ActivationCodeHelperClass();
							$codes
								->setBatchID($batchObject->id)
								->setTellerId($this->teller_id)
								->setCodeType(1)
								->setNumOfZeros(5)
								->setCodeFor($codeFor)
								->setPatternEveryLetter(3)
								->setPrefixLength(5)
								->setORNumber($or_number)
								->setPayor($payors_name)
								->setName($v['name'])
    							->setPaymentMethod($payment_method)
    							->setCoopID($v['coop_id']);

							$theCodes = $codes->generateCodesTeller($v['quantity'], 1, $inputs['username']);
						//	$theCodes = $codes->generateCodes($inputs['quantity-2'], $inputs['packageB']);
						//	$theCodes = $codes->generateCodes($inputs['quantity-3'], $inputs['packageC']);
							ActivationCodes::insert($theCodes);
							
						} 
						// if ($inputs['quantity-2'] > 0) {
						if ($v['quantity'] > 0 && $v['type'] == 'quantity-2') {
							//$theBatchName2 = makeBatchId();
							$codeType = 2;
							$codeFor = 'member';
							$batch2 = [
								'name' => $theBatchName,
								'type' => 'Package B'
							];

							$manageModel = new ModelHelper();
							$batchObject = $manageModel->manageModelData(new ActivationCodeBatches, $batch2);

							$codes = new ActivationCodeHelperClass();
							$codes
								->setBatchID($batchObject->id)
								->setTellerId($this->teller_id)
								->setCodeType(2)
								->setNumOfZeros(5)
								->setCodeFor($codeFor)
								->setPatternEveryLetter(3)
								->setPrefixLength(5)
								->setORNumber($or_number)
								->setPayor($payors_name)
								->setName($v['name'])
    							->setPaymentMethod($payment_method)
    							->setCoopID($v['coop_id']);

							$theCodes2 = $codes->generateCodesTeller($v['quantity'], 2,$inputs['username']);
							ActivationCodes::insert($theCodes2);
						}
						// if ($inputs['quantity-3'] > 0) {
						if ($v['quantity'] > 0 && $v['type'] == 'quantity-3') {
							//$theBatchName3 = makeBatchId();
							$codeType = 3;
							$codeFor = 'member';
							$batch3 = [
								'name' => $theBatchName,
								'type' => 'Package C'
							];

							$manageModel = new ModelHelper();
							$batchObject = $manageModel->manageModelData(new ActivationCodeBatches, $batch3);

							$codes = new ActivationCodeHelperClass();
							$codes
								->setBatchID($batchObject->id)
								->setTellerId($this->teller_id)
								->setCodeType(3)
								->setNumOfZeros(5)
								->setCodeFor($codeFor)
								->setPatternEveryLetter(3)
								->setPrefixLength(5)
								->setORNumber($or_number)
								->setPayor($payors_name)
								->setName($v['name'])
    							->setPaymentMethod($payment_method)
    							->setCoopID($v['coop_id']);

							$theCodes3 = $codes->generateCodesTeller($v['quantity'], 3,$inputs['username']);
							ActivationCodes::insert($theCodes3);
						}
					}

					// return $counter;

					//ActivationCodes::insert($theCodes1);
					$this->result->message = $counter.' Activation codes has been generated';
					$this->result->batchName = $theBatchName;
					$this->result->username = $inputs['username'];
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

    function validate(){

        $inputs = $this->getInputs();
		$validation = false;
		$qtyFlag = 0;
		$this->result = new \stdClass();
        $this->result->message = '';
        $this->result->message_type = '';
        $this->result->data = [];
        $this->result->error = false;
		$message = 0;
		
        
        // if (isset($inputs['generate-code'])){
        if (isset($_POST)){

        	$or_number = $inputs['ornumber'];
        	$payors_name = $inputs['payorname'];

			/*
            $rules = [
                'quantity-1'=>'required|numeric|min:1',
				'quantity-2'=>'required|numeric|min:1',
				'quantity-3'=>'required|numeric|min:1',
				  
                'type'=>'required'
            ];
            $validate = $this->handle($inputs, $rules);
			*/
			if ($inputs['quantity-1'] <= 0 ) {
				$qtyFlag += 0;
			} else {
				$qtyFlag++;
			}
			if ($inputs['quantity-2'] <= 0 ) {
			    $qtyFlag += 0;
			}else {
				$qtyFlag++;
			}
            if ($inputs['quantity-3'] <= 0) {
				$qtyFlag += 0;
			} else {
				$qtyFlag++;
			}
			if ($inputs['quantity-4'] <= 0) {
				$qtyFlag += 0;
			} else {
				$qtyFlag++;
			}
			if ($inputs['quantity-5'] <= 0) {
				$qtyFlag += 0;
			} else {
				$qtyFlag++;
			}
			if ($inputs['quantity-6'] <= 0) {
				$qtyFlag += 0;
			} else {
				$qtyFlag++;
			}
			if ($inputs['quantity-7'] <= 0) {
				$qtyFlag += 0;
			} else {
				$qtyFlag++;
			}
			if ($inputs['quantity-8'] <= 0) {
				$qtyFlag += 0;
			} else {
				$qtyFlag++;
			}
			if ($inputs['quantity-9'] <= 0) {
				$qtyFlag += 0;
			} else {
				$qtyFlag++;
			}
			

			if ($qtyFlag <= 0) {
				$validation = false;
			    $this->result->error = true;
				$this->result->message = 'Please do fill in any quantity amount.';
				$this->result->message_type = "danger";
				$message = "Please do fill in any quantity amount.";
			} else {
				$validation = true; 
                $this->result->error = false;
				
			}
            if ($validation){

                
			//	$TypeId = $inputs['type'];
			/*
				if ($TypeId != 'free') {
					$membershipType = Membership::find($TypeId);
					//$codeTypeId = $codeType;
					$codeType = $membershipType->membership_type_name;
				}
			*/
				try {

					// validate OR NUMBER
					$or = ActivationCodes::where('or_number', $or_number)->count();
		        	if($or > 0){
		        		throw new Exception("OR number already exist.");
        			}

					$counter = $inputs['quantity-1'] + $inputs['quantity-2'] + $inputs['quantity-3'] + $inputs['quantity-4'] + $inputs['quantity-5'] + $inputs['quantity-6'] + $inputs['quantity-7']  + $inputs['quantity-8']  + $inputs['quantity-9'];
					//$theBatchName = makeBatchId();
					$codeGenerator = "";
					$theBatchName = makeBatchId();
					if ($inputs['quantity-1'] > 0) {
						
						$codeType = 1;
						$codeFor = 'member';
						$batch1 = [
							'name' => $theBatchName,
							'type' => 'Package A'
						];

						$manageModel = new ModelHelper();
						$batchObject = $manageModel->manageModelData(new ActivationCodeBatches, $batch1);

						$codes = new ActivationCodeHelperClass();
						$codes
							->setBatchID($batchObject->id)
							->setTellerId($this->teller_id)
							->setCodeType(1)
							->setNumOfZeros(5)
							->setCodeFor($codeFor)
							->setPatternEveryLetter(3)
							->setPrefixLength(5)
							->setORNumber($or_number)
							->setPayor($payors_name);

						$theCodes = $codes->generateCodesTeller($inputs['quantity-1'], 1, $inputs['username']);
					//	$theCodes = $codes->generateCodes($inputs['quantity-2'], $inputs['packageB']);
					//	$theCodes = $codes->generateCodes($inputs['quantity-3'], $inputs['packageC']);
						ActivationCodes::insert($theCodes);
						
					} 
					if ($inputs['quantity-2'] > 0) {
						//$theBatchName2 = makeBatchId();
						$codeType = 2;
						$codeFor = 'member';
						$batch2 = [
							'name' => $theBatchName,
							'type' => 'Package B'
						];

						$manageModel = new ModelHelper();
						$batchObject = $manageModel->manageModelData(new ActivationCodeBatches, $batch2);

						$codes = new ActivationCodeHelperClass();
						$codes
							->setBatchID($batchObject->id)
							->setTellerId($this->teller_id)
							->setCodeType(2)
							->setNumOfZeros(5)
							->setCodeFor($codeFor)
							->setPatternEveryLetter(3)
							->setPrefixLength(5)
							->setORNumber($or_number)
							->setPayor($payors_name);

						$theCodes2 = $codes->generateCodesTeller($inputs['quantity-2'], 2,$inputs['username']);
						ActivationCodes::insert($theCodes2);
					}
					if ($inputs['quantity-3'] > 0) {
						//$theBatchName3 = makeBatchId();
						$codeType = 3;
						$codeFor = 'member';
						$batch3 = [
							'name' => $theBatchName,
							'type' => 'Package C'
						];

						$manageModel = new ModelHelper();
						$batchObject = $manageModel->manageModelData(new ActivationCodeBatches, $batch3);

						$codes = new ActivationCodeHelperClass();
						$codes
							->setBatchID($batchObject->id)
							->setTellerId($this->teller_id)
							->setCodeType(3)
							->setNumOfZeros(5)
							->setCodeFor($codeFor)
							->setPatternEveryLetter(3)
							->setPrefixLength(5)
							->setORNumber($or_number)
							->setPayor($payors_name);

						$theCodes3 = $codes->generateCodesTeller($inputs['quantity-3'], 3,$inputs['username']);
						ActivationCodes::insert($theCodes3);
					}
					if ($inputs['quantity-4'] > 0) {
						
						$codeType = 7;
						$codeFor = 'member';
						$batch1 = [
							'name' => $theBatchName,
							'type' => 'AR - Package A'
						];

						$manageModel = new ModelHelper();
						$batchObject = $manageModel->manageModelData(new ActivationCodeBatches, $batch1);

						$codes = new ActivationCodeHelperClass();
						$codes
							->setBatchID($batchObject->id)
							->setTellerId($this->teller_id)
							->setCodeType(7)
							->setNumOfZeros(5)
							->setCodeFor($codeFor)
							->setPatternEveryLetter(3)
							->setPrefixLength(5)
							->setORNumber($or_number)
							->setPayor($payors_name);

						$theCodes = $codes->generateCodesTeller($inputs['quantity-4'], 7, $inputs['username']);
					//	$theCodes = $codes->generateCodes($inputs['quantity-2'], $inputs['packageB']);
					//	$theCodes = $codes->generateCodes($inputs['quantity-3'], $inputs['packageC']);
						ActivationCodes::insert($theCodes);
						
					} 
					if ($inputs['quantity-5'] > 0) {
						//$theBatchName2 = makeBatchId();
						$codeType = 8;
						$codeFor = 'member';
						$batch2 = [
							'name' => $theBatchName,
							'type' => 'AR - Package B'
						];

						$manageModel = new ModelHelper();
						$batchObject = $manageModel->manageModelData(new ActivationCodeBatches, $batch2);

						$codes = new ActivationCodeHelperClass();
						$codes
							->setBatchID($batchObject->id)
							->setTellerId($this->teller_id)
							->setCodeType(8)
							->setNumOfZeros(5)
							->setCodeFor($codeFor)
							->setPatternEveryLetter(3)
							->setPrefixLength(5)
							->setORNumber($or_number)
							->setPayor($payors_name);

						$theCodes2 = $codes->generateCodesTeller($inputs['quantity-5'], 8,$inputs['username']);
						ActivationCodes::insert($theCodes2);
					}
					if ($inputs['quantity-6'] > 0) {
						//$theBatchName3 = makeBatchId();
						$codeType = 9;
						$codeFor = 'member';
						$batch3 = [
							'name' => $theBatchName,
							'type' => 'AR - Package C'
						];

						$manageModel = new ModelHelper();
						$batchObject = $manageModel->manageModelData(new ActivationCodeBatches, $batch3);

						$codes = new ActivationCodeHelperClass();
						$codes
							->setBatchID($batchObject->id)
							->setTellerId($this->teller_id)
							->setCodeType(9)
							->setNumOfZeros(5)
							->setCodeFor($codeFor)
							->setPatternEveryLetter(3)
							->setPrefixLength(5)
							->setORNumber($or_number)
							->setPayor($payors_name);

						$theCodes3 = $codes->generateCodesTeller($inputs['quantity-6'], 9,$inputs['username']);
						ActivationCodes::insert($theCodes3);
					}

					if ($inputs['quantity-7'] > 0) {
						//$theBatchName3 = makeBatchId();
						$codeType = 4;
						$codeFor = 'member';
						$batch3 = [
							'name' => $theBatchName,
							'type' => 'CD - Package A'
						];

						$manageModel = new ModelHelper();
						$batchObject = $manageModel->manageModelData(new ActivationCodeBatches, $batch3);

						$codes = new ActivationCodeHelperClass();
						$codes
							->setBatchID($batchObject->id)
							->setTellerId($this->teller_id)
							->setCodeType(4)
							->setNumOfZeros(5)
							->setCodeFor($codeFor)
							->setPatternEveryLetter(3)
							->setPrefixLength(5)
							->setORNumber($or_number)
							->setPayor($payors_name);

						$theCodes3 = $codes->generateCodesTeller($inputs['quantity-7'], 4,$inputs['username']);
						ActivationCodes::insert($theCodes3);
					}
					if ($inputs['quantity-8'] > 0) {
						//$theBatchName3 = makeBatchId();
						$codeType = 5;
						$codeFor = 'member';
						$batch3 = [
							'name' => $theBatchName,
							'type' => 'CD - Package B'
						];

						$manageModel = new ModelHelper();
						$batchObject = $manageModel->manageModelData(new ActivationCodeBatches, $batch3);

						$codes = new ActivationCodeHelperClass();
						$codes
							->setBatchID($batchObject->id)
							->setTellerId($this->teller_id)
							->setCodeType(5)
							->setNumOfZeros(5)
							->setCodeFor($codeFor)
							->setPatternEveryLetter(3)
							->setPrefixLength(5)
							->setORNumber($or_number)
							->setPayor($payors_name);

						$theCodes3 = $codes->generateCodesTeller($inputs['quantity-8'], 5,$inputs['username']);
						ActivationCodes::insert($theCodes3);
					}
					if ($inputs['quantity-9'] > 0) {
						//$theBatchName3 = makeBatchId();
						$codeType = 6;
						$codeFor = 'member';
						$batch3 = [
							'name' => $theBatchName,
							'type' => 'CD - Package C'
						];

						$manageModel = new ModelHelper();
						$batchObject = $manageModel->manageModelData(new ActivationCodeBatches, $batch3);

						$codes = new ActivationCodeHelperClass();
						$codes
							->setBatchID($batchObject->id)
							->setTellerId($this->teller_id)
							->setCodeType(6)
							->setNumOfZeros(5)
							->setCodeFor($codeFor)
							->setPatternEveryLetter(3)
							->setPrefixLength(5)
							->setORNumber($or_number)
							->setPayor($payors_name);

						$theCodes3 = $codes->generateCodesTeller($inputs['quantity-9'], 6,$inputs['username']);
						ActivationCodes::insert($theCodes3);
					}
						//ActivationCodes::insert($theCodes1);
						$this->result->message = $counter.' Activation codes has been generated';
						$this->result->batchName = $theBatchName;
						$this->result->username = $inputs['username'];
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