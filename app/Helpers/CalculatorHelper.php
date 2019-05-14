<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 4/23/16
 * Time: 6:53 PM
 */

if (!function_exists('calculatePercentage')){

    function calculatePercentage($percentage, $baseAmount){
        return ($percentage / 100) * $baseAmount;
    }

}