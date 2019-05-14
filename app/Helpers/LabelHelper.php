<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 4/22/16
 * Time: 9:22 AM
 */

if (!function_exists('ToLabel')){

    function ToLabel($string){
        return ucwords(str_replace('-', ' ', $string));
    }

}

if (!function_exists('getInitials')){

    function getInitials($string, $until = 3){

        $newString = explode(' ', $string);

        $result = '';

        foreach ($newString as $segments){
            $result .= substr($segments, 1, 1);
        }

        return $result;

    }

}