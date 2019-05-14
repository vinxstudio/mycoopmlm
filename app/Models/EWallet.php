<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 5/20/17
 * Time: 12:05 PM
 */

namespace App\Models;

use Auth;

class EWallet extends AbstractLayer{

    protected $table = 'e_wallet';

    /*
    * Checks if eWallet has sufficient funds against amount/amounts to be deducted.
    *
    * @param $amountToDeduct array|number
    * 
    * @return boolean
    */
    public function hasSufficientFunds($amountToDeduct = null)
    {
    	if (!$amountToDeduct) return false;

    	$userId        = Auth::user()->id;
    	$accountId     = Accounts::where(['user_id' => $userId])->first()->id;
    	$eWalletAmount = $this->where([ 
    		'user_id'    => $userId,
    		'account_id' => $accountId
    	])->first()->amount;

    	if (is_array($amountToDeduct)) {
    		$amountToDeduct = array_sum($amountToDeduct);
    	}

    	return $eWalletAmount > $amountToDeduct;
    }

    /*
    * Deducts to user's ewallet the passed amount/amounts.
    *
    * @param $amountToDeduct array|number
    * 
    * @return boolean
    */
    public function debitEwallet($amountToDeduct = null, $available_balance = null)
    {

        if (!$amountToDeduct) return false;

    	if (!$available_balance) return false;

    	$userId    = Auth::user()->id;
    	$accountId = Accounts::where(['user_id' => $userId])->first()->id;

    	if (is_array($amountToDeduct)) {
    		$amountToDeduct = array_sum($amountToDeduct);
    	}

        if ($available_balance < $amountToDeduct) {
            return false;
        }

        $eWallet = new EWallet;
        $eWallet->account_id = $accountId;
        $eWallet->user_id = $userId;
        $eWallet->source = "Ecommerce";
    	$eWallet->amount = "-".$amountToDeduct;
    	$eWallet->save();

    	return true;
    }
}