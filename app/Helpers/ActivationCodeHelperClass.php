<?php

/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 4/23/16
 * Time: 3:19 PM
 */

namespace App\Helpers;

use App\Models\ActivationCodes;
use App\Models\Company;
use App\Models\Products;
use App\Models\PurchaseCodes;
use App\Models\Membership;
use App\Models\User;


class ActivationCodeHelperClass
{

    protected $numOfZeros = 5;

    protected $prefixLength = 5;

    protected $toRandomize = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];

    protected $patternEveryLetter = 3;

    protected $batchId = 0;

   // protected $codeType = 'regular';

    protected $codeFor = 'admin';

    protected $productID = 0;

    protected $ownerID = 0;

    protected $OR = 0;

    protected $payor = '';

    protected $teller_id = 0;

    protected $min = 00000000;

    protected $max = 99999999;

    protected $payment_method = '';

    protected $coop_id = '';

    protected $name = '';


    function setNumOfZeros($num)
    {
        $this->numOfZeros = $num;
        return $this;
    }

    private function getNumOfZeros()
    {
        return $this->numOfZeros;
    }

    function setPrefixLength($num)
    {
        $this->prefixLength = $num;
        return $this;
    }

    private function getPrefixLength()
    {
        return $this->prefixLength;
    }

    function setPatternEveryLetter($pattern)
    {
        $this->patternEveryLetter = $pattern;
        return $this;
    }

    private function getPatternEveryLetter()
    {
        return $this->patternEveryLetter;
    }

    function setBatchID($id)
    {
        $this->batchId = $id;
        return $this;
    }

    private function getBatchID()
    {
        return $this->batchId;
    }

    function setTellerId($id)
    {
        $this->teller_id = $id;
        return $this;
    }

    private function getTellerID()
    {
        return $this->teller_id;
    }

    function setCodeType($type)
    {
        $this->codeType = $type;
        return $this;
    }

    private function getCodeType($type)
    {
        $this->codeType = $type;
        return $this->codeType;
    }

    function setCodeFor($codeFor)
    {
        $this->codeFor = $codeFor;
        return $this;
    }

    private function getCodeFor()
    {
        return $this->codeFor;
    }

    function setProductID($id)
    {
        $this->productID = $id;
        return $this;
    }

    private function getProductID()
    {
        return $this->productID;
    }

    function setOwnerID($ownerID)
    {
        $this->ownerID = $ownerID;
        return $this;
    }

    function setORNumber($OR)
    {
        $this->OR = $OR;
        return $this;
    }

    private function getORNumber()
    {
        return $this->OR;
    }

    function setPayor($payor)
    {
        $this->payor = $payor;
        return $this;
    }

    private function getPayor()
    {
        return $this->payor;
    }

    function setPaymentMethod($method)
    {
        $this->payment_method = $method;
        return $this;
    }

    private function getPaymentMethod()
    {
        return $this->payment_method;
    }

    function setCoopID($coop_id)
    {
        $this->coop_id = $coop_id;
        return $this;
    }

    private function getCoopID()
    {
        return $this->coop_id;
    }

    function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    private function getName()
    {
        return $this->name;
    }

    function getPackageCode($type)
    {
        $code = '';
        switch ($type) {
            case 1:
                $code = 'PA';
                break;
            case 2:
                $code = 'PB';
                break;
            case 3:
                $code = 'PC';
                break;
            case 4:
                $code = 'CDA';
                break;
            case 5:
                $code = 'CDB';
                break;
            case 6:
                $code = 'CDC';
                break;
            case 7:
                $code = 'ARA';
                break;
            case 8:
                $code = 'ARB';
                break;
            case 9:
                $code = 'ARC';
                break;
        }

        return $code;
    }

    function generateCodes($quantity = 1, $type, $username)
    {

        $prefixCount = $this->getPrefixLength();

        $letters = $this->toRandomize;

        $company = Company::find(1);

        $pattern = $this->getPatternEveryLetter();

        $numberOfZeros = $this->getNumOfZeros();

        $teller_id = $this->getTellerID();

        $batchid = $this->getBatchID();

        $codeType = $this->getCodeType($type);

        $codeFor = $this->getCodeFor();

        $productID = $this->getProductID();

        $product = Products::find($productID);

        $or_number = $this->getORNumber();

        $payors_name = $this->getPayor();

        $codes = [];

        $last = ($codeFor == 'members') ? ActivationCodes::orderBy('id', 'desc')->get() : PurchaseCodes::orderBy('id', 'desc')->get();

        $lastId = 1;

        if (!$last->isEmpty()) {
            $lastId = $last->first()->id;
        }

        try {

            for ($codeNum = 0; $codeNum < $quantity; $codeNum++) {
                $thisCode = ($codeFor == 'members') ? $company->activation_code_prefix : $company->product_code_prefix;
                $codePattern = 0;
                $i = 0;

                while ($i < $prefixCount) {

                    shuffle($letters);
                    $thisCode .= $letters[0];
                    if ($codePattern >= $pattern) {
                        $thisCode .= rand(20, 1);
                        $codePattern = 0;
                    }
                    $i++;
                    $codePattern++;
                }

                $package = $this->getPackageCode($type);
                $activation = $package . mt_rand($this->min, $this->max);
                $account = $package . mt_rand($this->min, $this->max);

                #check if activation code and account code already taken
                $has_activation_code = true;
                while ($has_activation_code) {
                    $code_exist = ActivationCodes::where('account_id', $account)->where('code', $activation)->count();
                    if ($code_exist > 0) {
                        #regenerate activation code
                        $activation = $package . mt_rand($this->min, $this->max);
                        $account = $package . mt_rand($this->min, $this->max);
                    } else {
                        $has_activation_code = false;
                    }
                }

                // $activation = $thisCode.str_pad($lastId, $numberOfZeros + 5, '0', STR_PAD_LEFT).$date;
                // $account = $thisCode.str_pad($lastId, $numberOfZeros, '0', STR_PAD_LEFT).$date;
				
				//if ($type != 'free') {
				//	$membershipType = Membership::find($type);
				//	$codeTypeId = $type;
				//	$codeType = $membershipType->membership_type_name;
					
				//} else {
				//	$codeTypeId = 0;

                //$codeType = $type;				}
				
				// *edit: keen - 1/20/2018
				
				/*if ($type == '6' || $type == '5' || $type == '4') {
                    $membershipType = Membership::find($type);
                    $codeTypeId = $type;
                    $codeType = $membershipType->membership_type_name;
                    $cd = 'true';
                } else {
                    $membershipType = Membership::find($type);
                    $codeTypeId = $type;
                    $codeType = $membershipType->membership_type_name;
                    $cd = 'false';
                }
                 */
                if (!$type) {
                    $type = User::find($this->ownerID)->member_type_id;
                }

                if ($type > 3) {
                    $membershipType = Membership::find($type);
                    $codeTypeId = $type;
                    $codeType = $membershipType->membership_type_name;
                    $cd = 'true';
                } else {
                    $membershipType = Membership::find($type);
                    $codeTypeId = $type;
                    $codeType = $membershipType->membership_type_name;
                    $cd = 'false';
                }

                $codesValue = ($productID > 0) ? [
                    'product_id' => $productID,
                    'code' => strtoupper($activation),
                    'password' => shortEncrypt($lastId . $productID . time()),
                    'status' => '0',
                    'created_at' => date('Y-m-d H:i:s')
                ] : [

                    'batch_id' => $batchid,
                    'teller_id' => $teller_id,
                    'code' => strtoupper($activation),
                    'account_id' => $account,
                    'status' => 'available',
                    'transferred_to' => $username,
                    'type' => $codeType,
                    'type_id' => $codeTypeId,
                    'user_id' => ($this->ownerID > 0) ? $this->ownerID : '0',
                    'paid_by_balance' => $cd,
                    'or_number' => $or_number,
                    'payors_name' => $payors_name,
                    'created_at' => date('Y-m-d H:i:s')

                ];
				// end edit
				
				
                //$codesValue = ($productID > 0) ? [
                //    'product_id'=>$productID,
                //    'code'=>strtoupper($activation),
                //    'password'=>shortEncrypt($lastId.$productID.time()),
                //    'status'=>'0',
                //    'created_at' => date('Y-m-d h:i:s')
                //] : [

                //    'batch_id'=>$batchid,
                //    'code'=>strtoupper($activation),
                //    'account_id'=>$account,
                //    'status'=>'available',
                //    'type'=>$codeType,
				//	'type_id'=>$codeTypeId,
                //   'user_id'=>($this->ownerID > 0) ? $this->ownerID : '0',
                //    'created_at'=>date('Y-m-d h:i:s')

                //];

                if ($codeFor == 'members') {
                    $codesValue['owner_id'] = $this->ownerID;
                    $codesValue['purchase_value'] = $product->purchaseValue;
                }
                $codes[] = $codesValue;

                $lastId++;

            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        return $codes;
    }

    function generateCodesTeller($quantity = 1, $type, $username)
    {

        $prefixCount = $this->getPrefixLength();

        $letters = $this->toRandomize;

        $company = Company::find(1);

        $pattern = $this->getPatternEveryLetter();

        $numberOfZeros = $this->getNumOfZeros();

        $batchid = $this->getBatchID();

        $teller_id = $this->getTellerID();

        $codeType = $this->getCodeType($type);

        $codeFor = $this->getCodeFor();

        $productID = $this->getProductID();

        $product = Products::find($productID);

        $or_number = $this->getORNumber();

        $payors_name = $this->getPayor();

        $payment_method = $this->getPaymentMethod();

        $coop_id = $this->getCoopID();

        $name = $this->getName();

        $codes = [];

        $last = ($codeFor == 'members') ? ActivationCodes::orderBy('id', 'desc')->get() : PurchaseCodes::orderBy('id', 'desc')->get();

        $lastId = 1;

        if (!$last->isEmpty()) {
            $lastId = $last->first()->id;
        }

        try {

            for ($codeNum = 0; $codeNum < $quantity; $codeNum++) {
                $thisCode = ($codeFor == 'members') ? $company->activation_code_prefix : $company->product_code_prefix;
                $codePattern = 0;
                $i = 0;

                while ($i < $prefixCount) {

                    shuffle($letters);
                    $thisCode .= $letters[0];
                    if ($codePattern >= $pattern) {
                        $thisCode .= rand(20, 1);
                        $codePattern = 0;
                    }
                    $i++;
                    $codePattern++;
                }

                $package = $this->getPackageCode($type);
                $activation = $package . mt_rand($this->min, $this->max);
                $account = $package . mt_rand($this->min, $this->max);

                #check if activation code and account code already taken
                $has_activation_code = true;
                while ($has_activation_code) {
                    $code_exist = ActivationCodes::where('account_id', $account)->where('code', $activation)->count();
                    if ($code_exist > 0) {
                        #regenerate activation code
                        $activation = $package . mt_rand($this->min, $this->max);
                        $account = $package . mt_rand($this->min, $this->max);
                    } else {
                        $has_activation_code = false;
                    }
                }
                
                // $date = date('Hyimsd');
                // $activation = $thisCode.str_pad($lastId, $numberOfZeros + 5, '0', STR_PAD_LEFT).$date;
                // $account = $thisCode.str_pad($lastId, $numberOfZeros, '0', STR_PAD_LEFT).$date;
				
				//if ($type != 'free') {
				//	$membershipType = Membership::find($type);
				//	$codeTypeId = $type;
				//	$codeType = $membershipType->membership_type_name;
					
				//} else {
				//	$codeTypeId = 0;

                //$codeType = $type;				}
				
				// *edit: keen - 1/20/2018
				
				/*if ($type == '6' || $type == '5' || $type == '4') {
                    $membershipType = Membership::find($type);
                    $codeTypeId = $type;
                    $codeType = $membershipType->membership_type_name;
                    $cd = 'true';
                } else {
                    $membershipType = Membership::find($type);
                    $codeTypeId = $type;
                    $codeType = $membershipType->membership_type_name;
                    $cd = 'false';
                }*/

                if ($type > 3) {
                    $membershipType = Membership::find($type);
                    $codeTypeId = $type;
                    $codeType = $membershipType->membership_type_name;
                    $cd = 'true';
                } else {
                    $membershipType = Membership::find($type);
                    $codeTypeId = $type;
                    $codeType = $membershipType->membership_type_name;
                    $cd = 'false';
                }

                $codesValue = ($productID > 0) ? [
                    'product_id' => $productID,
                    'code' => strtoupper($activation),
                    'password' => shortEncrypt($lastId . $productID . time()),
                    'status' => '0',
                    'created_at' => date('Y-m-d H:i:s')
                ] : [

                    'batch_id' => $batchid,
                    'teller_id' => $teller_id,
                    'code' => strtoupper($activation),
                    'account_id' => $account,
                    'status' => 'available',
                    'transferred_to' => $username,
                    'type' => $codeType,
                    'type_id' => $codeTypeId,
                    'or_number' => $or_number,
                    'payors_name' => $payors_name,
                    'user_id' => ($this->ownerID > 0) ? $this->ownerID : '0',
                    'paid_by_balance' => $cd,
                    'created_at' => date('Y-m-d H:i:s'),
                    'name' => $name,
                    'payment_method' => $payment_method,
                    'coop_id' => $coop_id
                ];
				
				// end edit
				
				
                //$codesValue = ($productID > 0) ? [
                //    'product_id'=>$productID,
                //    'code'=>strtoupper($activation),
                //    'password'=>shortEncrypt($lastId.$productID.time()),
                //    'status'=>'0',
                //    'created_at' => date('Y-m-d h:i:s')
                //] : [

                //    'batch_id'=>$batchid,
                //    'code'=>strtoupper($activation),
                //    'account_id'=>$account,
                //    'status'=>'available',
                //    'type'=>$codeType,
				//	'type_id'=>$codeTypeId,
                //   'user_id'=>($this->ownerID > 0) ? $this->ownerID : '0',
                //    'created_at'=>date('Y-m-d h:i:s')

                //];

                if ($codeFor == 'members') {
                    $codesValue['owner_id'] = $this->ownerID;
                    $codesValue['purchase_value'] = $product->purchaseValue;
                }
                $codes[] = $codesValue;


                $lastId++;

            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        return $codes;
    }

}