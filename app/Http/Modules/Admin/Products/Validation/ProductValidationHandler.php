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

use PhpSpec\Exception\Exception;
use Illuminate\Support\Facades\Log;
use App\Helpers\GeneratePurchaseCodes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ProductValidationHandler extends MainValidationHandler
{

    //protected $numberOfZerosInCode = 7;
    //protected $codePrefixLength = 5;
    //protected $numberAfterEveryLetter = 3;

    protected $prefix_length = 11;

    protected $memberID = 0;

    function setMemberID($id)
    {
        $this->memberID = $id;
        return $this;
    }

    function validatePurchaseCodes()
    {
        $inputs = $this->getInputs();
        $rules = [
            'quantity' => 'required|numeric',
            'product' => 'required'
        ];

        $codeFor = ($this->memberID > 0) ? 'members' : 'products';

        $handle = $this->handle($inputs, $rules);

        /*
         *
         * new Generate Codes for Admin
         * 
         */


        if (!$handle->error) {

            $product = $inputs['product'];
            $owner_id = Auth::id();
            $no_of_codes = $inputs['quantity'];
            $price_type = $inputs['price_type'];
            $prefix_length = $this->prefix_length;

            try {

                $codes = new GeneratePurchaseCodes();
                $codes->set_product_id($product)
                    ->set_owner_id($owner_id)
                    ->set_prefix_length($prefix_length)
                    ->set_price_type($price_type);

                $generated_codes = $codes->generate_codes($no_of_codes);

                $label = ($no_of_codes > 1) ? ' codes' : ' code';

                $this->result->codes = $generated_codes;

                $this->result->message = $no_of_codes . $label . ' sucessfully generated.';

                for ($i = 0; $i < count($generated_codes); $i++) {

                    $product = new PurchaseCodes();

                    $product->barcode_c93 = $generated_codes[$i]['barcode_c93'];
                    $product->product_id = $generated_codes[$i]['product_id'];
                    $product->product_type = $generated_codes[$i]['product_type'];
                    $product->code = $generated_codes[$i]['code'];
                    $product->password = $generated_codes[$i]['password'];
                    $product->status = $generated_codes[$i]['status'];
                    $product->owner_id = $generated_codes[$i]['owner_id'];
                    $product->generated_by = $generated_codes[$i]['generated_by'];
                    $product->purchase_value = $generated_codes[$i]['purchase_value'];
                    $product->branch_id = $generated_codes[$i]['branch_id'];

                    $product->save();

                }

            } catch (Exception $ex) {
                $this->result->error = true;
                $this->result->message = $e->getMessage();
            }

        }


        /*
         *
         * Old Generate Codes for Admin
         * 
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
         */

        $this->result->message_type = ($this->result->error) ? 'danger' : 'success';
        return $this->result;

    }





}