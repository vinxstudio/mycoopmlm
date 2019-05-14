<?php

namespace App\Helpers;

use App\Models\PurchaseCodes;
use Illuminate\Support\Facades\Log;
use App\Models\Products;
use Carbon\Carbon;


class GeneratePurchaseCodes
{
    protected $product_id = 0;

    protected $owner_id = 0;

    //protected $pattern_every_letter = 3;

    protected $prefix_length = 11;

    protected $default_branch_id = 0;

    protected $price_type = PurchaseCodes::PRODUCT_TYPE_SRP;

    # generate unique code method
    function generate_codes($no_of_generated_codes)
    {
        # array of generated codes
        $codes = [];    

        # start loop
        for ($i = 0; $i < $no_of_generated_codes; $i++) {

            # generate unique alpha numerical string
            $unique_code = $this->generate_random_alpha_numeric();
            
            # check if the generated alpha numerical string exists alread
            while (PurchaseCodes::where('code', '=', $unique_code)->exists()) {
                # generate new unique alpha
                $unique_code = $this->generate_random_alpha_numeric();

                #continue loop until generated code is not in the database
            }

            # set product id
            $product_id = $this->product_id;
            $price_type = $this->price_type;
            # generate password
            # no need for unique one
            $password = $this->generate_password();

            # status { 0 = Available | 1 = Used }
            $status = 0;

            # set owner id of the one that generate the code
            $owner = $this->owner_id;

            # # # # # #
            $purchase_value = 0;

            # generate new barcode with the value of
            # generated unique code
            $barcode = \DNS1D::getBarcodePNGPath($unique_code, "C93");

            # default branch id
            $branch_id = $this->default_branch_id;

            # remove the " // " in the barcode
            # and replace with /public/
            $barcode = str_replace("//", "/public/", $barcode);

            # create new unique code array
            $code = [
                'product_id' => (int)$product_id,
                'product_type' => $price_type,
                'product_name' => Products::findOrFail($product_id)->first()->pluck('name'),
                'code' => $unique_code,
                'password' => $password,
                'barcode_c93' => $barcode,
                'status' => $status,
                'owner_id' => 0,
                'generated_by' => $owner,
                'purchase_value' => $purchase_value,
                'created_at' => Carbon::now(),
                'branch_id' => $branch_id
            ];

            # push new unique code to codes
            array_push($codes, $code);
        }
        # return the fucking codes 
        return $codes;
    }

    # generate random lower case alpabetical string
    function generate_password()
    {
        $password = '';

        $prefix_length = ((int)($this->prefix_length / 2) <= 5) ? 5 : $this->prefix_length / 2;

        $lower_case_alphabet = 'abcdefghijklmnopqrstuvwxyz';

        $max = strlen($lower_case_alphabet);

        for ($i = 0; $i < $prefix_length; $i++) {
            $password .= $lower_case_alphabet[$this->crypto_rand_secure(0, $max - 1)];
        }
        return $password;
    }

    # generate random alpha numerical string
    function generate_random_alpha_numeric()
    {
        $unique_alpha_numeric = '';

        $upper_case_alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $lower_case_alphabet = 'abcdefghijklmnopqrstuvwxyz';

        $numbers = '0123456789';

        $alphabet_numeric = $upper_case_alphabet . $lower_case_alphabet . $numbers;

        $max = strlen($alphabet_numeric);

        for ($i = 0; $i < $this->prefix_length; $i++) {
            $unique_alpha_numeric .= $alphabet_numeric[$this->crypto_rand_secure(0, $max - 1)];
        }

        return $unique_alpha_numeric;
    }

    # return encrypted random number 
    # based on the inputted min and max
    function crypto_rand_secure($min, $max)
    {
        $range = $max - $min;

        if ($range < $min) return $min;

        $log = ceil(log($range, 2));

        $bytes = (int)($log / 8) + 1;

        $bits = (int)$log + 1;

        $filter = (int)(1 << $bits) - 1;

        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter;

        } while ($rnd > $range);

        return $min + $rnd;

    }

    #
    # Getter
    # and
    # Setter
    # 
    # all of the code below 

    function set_prefix_length($prefix_length)
    {
        $this->prefix_length = $prefix_length;
        return $this;
    }

    function get_prefix_length()
    {
        return $this->prefix_length;
    }

    function set_owner_id($owner_id)
    {
        $this->owner_id = $owner_id;
        return $this;
    }

    function get_owner_id()
    {
        return $this->owner_id;
    }

    function set_product_id($product_id)
    {
        $this->product_id = $product_id;
        return $this;
    }

    function get_product_id()
    {
        return $this->product_id;
    }


    function get_price_type()
    {
        return $this->price_type;
    }

    function set_price_type($price_type = PurchaseCodes::PRODUCT_TYPE_SRP)
    {
        $this->price_type = $price_type;
    }

}


