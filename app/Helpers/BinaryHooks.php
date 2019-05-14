<?php
/**
 * Created by jomeravengoza.
 * User: POA
 * Date: 4/11/17
 * Time: 11:41 AM
 */

namespace App\Helpers;

class BinaryHooks{

    function make($accountObject, $totalPairsForToday, $currentLevel, $incomeObject){

        $hookFunctions = config('pairingHooks.hooks');

        foreach ($hookFunctions as $functionName){
            if (function_exists($functionName)) {
                return call_user_func($functionName,
                    $accountObject,
                    $totalPairsForToday,
                    $currentLevel,
                    $incomeObject
                );
            }
        }

    }

}