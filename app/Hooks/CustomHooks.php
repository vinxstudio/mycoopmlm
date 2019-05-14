<?php
/**
 * Created by jomeravengoza.
 * User: POA
 * Date: 4/11/17
 * Time: 1:08 PM
 */
/*
 * --------------------------------------------------------
 *|                     CUSTOM HOOKS                       |
 * --------------------------------------------------------
 *
 * */


function defaultHook($accountObject, $totalPairsForToday, $currentLevel, $incomeObject){

    $company = getCompanyObject();
    if ($totalPairsForToday > $company->daily_max_pair){
        $incomeObject['amount'] = 0; //means flush out
    }

    return $incomeObject; //you must return income object after.
}

function customHook($accountObject, $totalPairsForToday, $currentLevel, $incomeObject){

    return $incomeObject;

}