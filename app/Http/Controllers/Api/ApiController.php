<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 3/7/17
 * Time: 8:05 PM
 */

namespace App\Http\Controllers\Api;

use App\Helpers\Binary;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Earnings;
use App\Models\Accounts;
use App\Models\UserDetails;
use App\Models\ActivationCodes;
use App\Models\Membership;
use App\Models\ConvertGC;
use Illuminate\Http\Request;
use App\Http\TraitLayer\UserTrait;
use Response;
use Validator;

class ApiController extends Controller{

    use UserTrait;
    // protected $viewpath = 'Api.GiftCheckHistory.views.';

    function __construct(){
        
    }

    function accountInfo(Request $request){
        $activationCode = new ActivationCodes();
        $account_info = $activationCode->get_account_name($request->account_id);
      
        // return response()->json($account_info);
        if(!$account_info)
        {
            return response()->json([
                'status' => 200,
                'message' => 'Account ID. not found',
                'reponse' => []
            ], 200);
        }

        $barangay = (!empty($account_info->present_barangay)) ? $account_info->present_barangay : '';
        $city = (!empty($account_info->present_city)) ? $account_info->present_city : '';
        $address = $barangay.' '.$city;
        $first_name =  (!empty($account_info->first_name)) ? $account_info->first_name : '';
        $last_name =  (!empty($account_info->last_name)) ? $account_info->last_name : '';

        return response()->json([
                'status' => 200,
                'message' => 'Account Info.',
                'response' => [
                    'full_name' => $first_name.' '.$last_name,
                    'user_name' => (!empty($account_info->username)) ? $account_info->username : '',
                    'contact_details' => [
                        'cellphone_no' => (!empty($account_info->cellphone_no)) ? $account_info->cellphone_no : '',
                        'other_contact_no' => (!empty($account_info->other_contact_no)) ? $account_info->other_contact_no : '',
                        'home_tel_no' => (!empty($account_info->home_tel_no)) ? $account_info->home_tel_no : '',
                        'spouse_tel_no' => (!empty($account_info->spouse_tel_no)) ? $account_info->spouse_tel_no : '',
                        'province_tel_no' => (!empty($account_info->province_tel_no)) ? $account_info->province_tel_no : ''
                    ],
                    'address' => (!empty($address)) ? $address : "",
                    'email' => (!empty($account_info->email)) ? $account_info->email : ''
                ]
            ], 200);
    }

}
