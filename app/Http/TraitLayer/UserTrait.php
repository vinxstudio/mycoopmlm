<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 3/3/17
 * Time: 10:39 PM
 */

namespace App\Http\TraitLayer;

use App\Models\Accounts;
use App\Models\User;

trait UserTrait{

    function getMembersDropdown(){

        $users = User::where([
            'role'=>'member'
        ])->get();

        $dropdown = [];

        foreach ($users as $user){
            $dropdown[$user->id] = sprintf('%s - %s', $user->details->fullName, $user->account->account_id);
        }

        return $dropdown;

    }

    function getAccountsDropdown($asUpline = false){

        $accounts = Accounts::all();

        $dropdown = [];

        foreach ($accounts as $account){
            $encode = true;
            $level1Downlines = $account->downlines()->where('level', 1)->count();
            if ($asUpline == true and $level1Downlines >= 2) {
                $encode = false;
            }

            if (!isset($account->code->account_id) or !isset($account->user->details->fullName)){
                $encode = false;
            }

            if ($encode){
                $dropdown[$account->id] = sprintf('%s - %s', $account->code->account_id, $account->user->details->fullName);
            }
        }

        return $dropdown;

    }

}