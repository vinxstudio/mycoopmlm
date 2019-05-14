<?php

namespace App\Http\Modules\Member\NetworkTree\Controllers;

use App\Helpers\Binary;
use App\Http\AbstractHandlers\MemberAbstract;
use App\Models\User;
use App\Models\Downlines;
use App\Models\Earnings;
use App\Models\Accounts;
use App\Models\ActivationCodes;
use App\Models\UpgradedAccount;
use App\Models\Membership;
use Illuminate\Http\Request;
use App\Http\TraitLayer\UserTrait;
use App\Http\TraitLayer\BinaryTrait;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Details;
use App\Models\Company;
use App\Models\Logs;
use App\Helpers\MailHelper;
use App\Models\CompanyEarnings;
use App\Models\PointsChecker;
use Response;
use Validator;

class NetworkTreeMemberController extends MemberAbstract{

	use UserTrait;
    protected $viewpath = 'Member.NetworkTree.views.';

    function __construct(){
        parent::__construct();
    }

    function getIndex(Request $request, $start = null){

        if (!isset($this->theUser->account->id)){
            return view('widgets.activate_account');
        }
	
	   $level1Account = $this->theUser->account->id;

        $binary = new Binary();
        $recorded = (session('recorded_viewing')) ? session('recorded_viewing') : [];

        
        $currentUser = $this->theUser;
        if ($start != null){
            $exp = explode('-', $start);
            $userID = $exp[1];
            $user = User::find($userID);
            $currentUser = $user;
            $level1Account = $user->account->id;
            if (!in_array($userID, $recorded)){
                $recorded[] = $userID;
                session(['recorded_viewing'=>$recorded]);
            } else {

                $newRecord = [];
                foreach ($recorded as $key=>$value){
                    if ($value == $userID){
                        $newRecord[] = $userID;
                        break;
                    } else {
                        $newRecord[] = $userID;
                    }
                }

                session(['recorded_viewing'=>$newRecord]);

            }
        } else {
            Session::forget('recorded_viewing');
        }
		
		if (isset($user->account->id)) {
				$thisaccount = $user->account->id;
                $sponsorId = $user->account->sponsor_id;
		} else {
				$thisaccount = $level1Account;
                $sponsorId = $this->theUser->account->sponsor_id;
		}
        $activation_code = new ActivationCodes();
        $sponsor = $activation_code->get_sponsor_name($sponsorId);
       
		    $colorFlag = 0;
		    // $countDR = Earnings::where([
            //                 'account_id'=>$thisaccount,
            //                 'source'=>'direct_referral'
            //             ])->sum('amount');
			// $countMB = Earnings::where([
            //                 'account_id'=>$thisaccount,
            //                 'source'=>'pairing'
            //             ])->sum('amount');
			$membership	= Membership::find($currentUser->member_type_id);
			// $countRB = $countMB + $countDR;

            $countLPV = 0;
            $countRPV = 0;

			// $countLPV = Earnings::where([
            //                 'account_id'=>$thisaccount,
            //                 'source'=>'left_pv'
            //             ])->sum('amount');
			// $countRPV = Earnings::where([
            //                 'account_id'=>$thisaccount,
            //                 'source'=>'right_pv'
            //             ])->sum('amount');

            // if ($countRPV > $countLPV)  {
            //     $countRPV = abs($countRPV - $countLPV);
            //     $countLPV = 0;
            //     // $countRPV = abs($countRPV);
            // }
            // else if ($countLPV > $countRPV)  {
            //     $countLPV = abs($countLPV - $countRPV);
            //     $countRPV = 0;
            // }
            // else 
            // {
            //     $countRPV = 0;
            //     $countLPV = 0;
            // }

            $points_value = PointsChecker::where('account_id', $thisaccount)->first();
            if(!empty($points_value))
            {
                $countLPV = $points_value->left_points_value;
                $countRPV = $points_value->right_points_value;
            }
            else
            {
                $countLPV = 0;
                $countRPV = 0;
            }
            
            // $countLPV = (!empty($points_value->left_points_value)) ? $points_value->left_points_value : 0;
            // $countRPV = (!empty($points_value->right_points_value)) ? $points_value->right_points_value : 0;

        $listedUser = [];
        if (count($recorded) > 0){
            $usersQuery = User::whereIn('id', $recorded)->get();
            foreach ($usersQuery as $user){
                $listedUser[$user->id] = $user;
            }
        }

        // My edits
        $downlinesArray = $currentUser->account->childIds;
        $downlinesCount = count($downlinesArray);
        $maxAccounts = 100;
        if($downlinesCount >= 0 && $downlinesCount <= $maxAccounts){
            $availableSlots = $maxAccounts - $downlinesCount;
        }
		
		//$packageCount = DB::select("SELECT * FROM accounts WHERE user_id = '$currentUser'");
		//if($packageCount > 0){
		//	$packageType = DB::select("SELECT type FROM accounts WHERE user_id = '$currentUser'");
		//} else {
		//	$packageType = '';
		//}
       // end
		
		 if ($currentUser->account->code->type == "Package A") {
				$color = "#a894f3";
				$colorFlag = 0;
			} else if ($currentUser->account->code->type == "Package B")  {
				$color = "#f394c6";
				$colorFlag = 0;
			} else if ($currentUser->account->code->type == "Package C") {
				$color ="#cff394";
				$colorFlag = 0;
			} else if ($currentUser->account->code->type == "CD - Package A") {
				$color ="#E1DFDE";
				$colorFlag = 1;
			} else if ($currentUser->account->code->type == "CD - Package B") {
				$color ="#D1CECE";
				$colorFlag = 1;
			} else if ($currentUser->account->code->type == "CD - Package C") {
				$color ="#C1BCBB";
				$colorFlag = 1;
			} else if ($currentUser->account->code->type == "AR - Package A") {
				$color ="#edc4a1";
				$colorFlag = 1;
			} else if ($currentUser->account->code->type == "AR - Package B") {
				$color ="#eab68a";
				$colorFlag = 1;
			} else if ($currentUser->account->code->type == "AR - Package C") {
				$color ="#e8aa76";
				$colorFlag = 1;
			}
		$availableSlots = 100;
		$LevelNum = 0;
		$getlevel = Downlines::where('account_id',$thisaccount)->get();
			foreach ($getlevel as $getlevel){
				$LevelNum = $getlevel->level;
			}
			
		$thisnewusername = explode("-", $this->theUser->username);
		$members = User::where('username', 'like', $thisnewusername[0].'%')->where('role', 'member')->get();

		$binary->setLevelOneAccount($level1Account);
 
        return view( $this->viewpath . 'advanced' )
            ->with([
                // 'binaryTree'=>$binary->setLevelOneAccount($level1Account)->renderTree(),
                'account_id'=>$thisaccount,
                'viewed'=>session('recorded_viewing'),
                'listedUser'=>$listedUser,
                'currentUser'=>$currentUser,
                'downlinesArray'=>$downlinesArray,
				'color'=>$color,
				'colorFlag'=>$colorFlag,
                'currentUser'=>$currentUser,
                'downlinesArray'=>$downlinesArray,
				'level'=>$LevelNum ,
                'sponsor' => $sponsor,
				// 'countRB'=>$countRB,
				// 'countDR'=>$countDR,
				// 'countMB'=>$countMB,
				'countLPV'=>$countLPV,
				'countRPV'=>$countRPV,
                'availableSlots' => $availableSlots
            ]);

    }

	function search($account_id)
    {
        $account = ActivationCodes::select('account_id', 'user_id')
                            ->where('account_id', trim($account_id))
                            ->first();
        if(!$account){
            return Response::json(array('errors' => 'Account id not found.'));
        }
        $data['account_id'] = strtoupper($account->account_id);
        $data['user_id'] = strtoupper($account->user_id);
        return response()->json($data);
        
    }

    function upgradeAccount(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'account_id' => 'required',
            'activation_code' => 'required'
        ]);

        if($validator->fails()){
            return response()->json(['errors' => "Input fields are required"]);
        }

        $activation = ActivationCodes::where('account_id', $request->account_id)
                                ->where('code', $request->activation_code)
                                ->where('status', '=', 'available')
                                ->first();

        if($activation)
        {
            $activation_id = $activation->id;
            $account_id = $activation->account_id;
            $user_id = $request->user_id;
            $type_id = $activation->type_id;
            
            $binary = new Binary();
            $oldAccount = $binary->getOldAccount($user_id);
            $message = $binary->upgradeAccount($activation_id, $account_id, $user_id, $type_id);
            $newAccount = $binary->getNewAccount($user_id);
            $upgraded = new UpgradedAccount();

            $upgraded->user_id = $user_id;
            $upgraded->account_id = $oldAccount['id'];
            $upgraded->from_activation_id = $oldAccount['activation_id'];
            $upgraded->from_membership_type_id = $oldAccount['member_type_id'];
            $upgraded->to_activation_id = $newAccount['activation_id'];
            $upgraded->to_membership_type_id = $newAccount['member_type_id'];

            if($upgraded->save())
            {
                return response()->json($message);
            }
        }

        return response()->json(['errors' => "Oops! Something went wrong. Please try again!"]);
        
    }

    function getUpline(Request $request)
    {
        $uplineid = $request->input('upline_id');
        // $sponsorid = $request->input('sponsorid');
        $node = $request->input('node');

        $activationCode = new ActivationCodes();

        $upline_info = $activationCode->get_account_name($uplineid);

        return response()->json([
            'upline_name'=> (!empty($upline_info))? $upline_info->first_name.' '.$upline_info->last_name:'',
            'upline'=> $uplineid,
            'node_replacement' => $node
        ]);
    }

    function getSponsor($sponsor_id)
    {
        $activationCode = new ActivationCodes();
        $sponsor_info = $activationCode->get_account_name($sponsor_id);
        if ($sponsor_info) {
             return response()->json([
                'sponsor_name'=>(!empty($sponsor_info))? $sponsor_info->first_name.' '.$sponsor_info->last_name:'',
                'sponsor'=>$sponsor_id,
            ]);
        }
        return response()->json(['errors' => "Sponsor ID. not found!"]);
    }

    function getValidate(Request $request)
    {   
        $invalid_activation = '';
        $account_id = $request->account_id;
        $activation_code = $request->activation_code;

        // validate account tab
        if($request->validate == 'account')
        {
            $validator = Validator::make($request->all(), [
                'account_id'    => 'required',
                'activation_code' => 'required',
                'sponsor_id'    => 'required',
                'sponsor_name'  => 'required',
            ]);

            if($account_id || $activation_code)
            {
                $activation = ActivationCodes::where('account_id', $account_id)
                                    ->where('code', $activation_code)
                                    ->where('status', '=', 'available')
                                    ->first();
                
                if(!$activation)
                {
                    $invalid_activation = 'Please Enter Valid Account ID./Activation Code';
                    return response()->json([
                        'invalid_code' => $invalid_activation
                    ], 200);
                    
                } 
            
            }
        }

        if($request->validate == 'member')
        {
            $validator = Validator::make($request->all(), [
                'coop_id'       => 'required',
                'first_name'    => 'required',
                'middle_name'    => 'required',
                'last_name'     => 'required',
                'username'      => 'required|unique:users',
                'email'         => 'required|email|unique:user_details',
                'password'      => 'required|confirmed|min:8',
                'password_confirmation' => 'required'
            ]);
        }

        if($request->validate == 'other')
        {
            $validator = Validator::make($request->all(), [
                'true_money'            => 'required',
                'cel_number'            => 'required',
                'present_region'        => 'required',
                'present_province'      => 'required',
                'present_city_mun'      => 'required',
                'present_barangay'      => 'required'
            ]);
        }
        
        if($validator->fails()){
            $error_message = $validator->messages();
            return response()->json([
                'errors'  => (!empty($error_message)) ? $error_message : ''
            ], 200);
        }

        return response()->json([
            'success'  => 'success',
        ], 200);

    }

    function postActivate(Request $request)
    {   
        try {

            if($request->own_Account == 'own account')
            {
                $thisuser = Auth::user();
                $request->first_name = $thisuser->details->first_name;
                // $request->middle_name = (!empty($thisuser->detials->middle_name)) ? $thisuser->detials->middle_name : null;
                $request->last_name = $thisuser->details->last_name;
                // $request->suffix = (!empty($thisuser->details->suffix)) ? $thisuser->details->suffix : null;
                $request->email = $thisuser->details->email;
                // $request->present_street = $thisuser->details->present_street;
                // $request->present_barangay = $thisuser->details->present_barangay;
                // $request->present_town = $thisuser->details->present_town;
                // $request->present_city = $thisuser->details->present_city;
            }

            $searchUpline = ActivationCodes::where([
                'account_id'=>$request->upline_id,
                'status'=>'used'
            ])->get();

            $searchSponsor = ActivationCodes::where([
                'account_id'=>$request->sponsor_id,
                'status'=>'used'
            ])->get();

            $checkActivation = ActivationCodes::where([
                'account_id'=>$request->account_id,
                'code'=>$request->activation_code,
                'status'=>'available'
            ])->get();

            $account = (!$searchUpline->isEmpty()) ? Accounts::where('code_id', $searchUpline->first()->id)->get()->first() : null;
            
            $sponsorAccountId = (!$searchSponsor->isEmpty()) ? Accounts::where('code_id', $searchSponsor->first()->id)->get()->first() : null;

            $uplineDownlineCount = (!$searchUpline->isEmpty()) ? Accounts::where('upline_id', $account->id)->count() : 0;
            
            

            $details = new Details();
            $details->first_name = ucwords($request->first_name);
            $details->last_name = ucwords($request->last_name);
            $details->email = $request->email;
            if($request->own_Account == 'new account')
            {   
                $details->coop_id = $request->coop_id;
                $details->suffix = $request->suffix;
                $details->middle_name = ucwords($request->middle_name);

                $details->present_region = ucwords($request->present_region);
                $details->present_province = ucwords($request->present_province);
                $details->present_barangay = ucwords($request->present_barangay);
                $details->present_city = ucwords($request->present_city_mun);
                $details->present_zipcode = $request->present_zipcode;
                $details->present_address_details = ucwords($request->present_address);

                $details->provincial_region = ucwords($request->provincial_region);
                $details->provincial_province = ucwords($request->provincial_province);
                $details->provincial_barangay = ucwords($request->provincial_barangay);
                $details->provincial_city = ucwords($request->provincial_city_mun);
                $details->provincial_zipcode = $request->provincial_zipcode;
                $details->provincial_address_details = ucwords($request->provincial_address);

                $details->cellphone_no = $request->cel_number;
                $details->truemoney = $request->true_money;
            }
            
            $details->save();
            
            $logs = new Logs();
            $logs->logs_name = 'Enter Details of '.$request->first_name.' '.$request->last_name;
            $logs->logs_description = 'User Details has been inserted....';
            $logs->save();

            if($request->own_Account == 'own account')
            {
                $user = new User();
                $user->username = $request->input('for_username')."-".$details->id;
                
                $user->password = $thisuser->password;
                $user->user_details_id = $details->id;
                $user->paid = true;
                $user->member_type_id = $checkActivation->first()->type_id;
                $user->role = MEMBER_ROLE;
                $user->group_id = $thisuser->group_id;
                $user->save();

            }

            if($request->own_Account == 'new account')
            {
                $user = new User();
                $user->username = $request->username;
                $user->password = Hash::make($request->password);
                $user->user_details_id = $details->id;
                $user->paid = true;
                $activationCode = $request->activation_code;
                $user->member_type_id = $checkActivation->first()->type_id;
                $user->role = MEMBER_ROLE;
                $user->save();

                $new_users = User::find($user->id);
                $new_users->group_id = $new_users->id;
                $new_users->update();
            }

            $setaccount = new Accounts();
            $setaccount->user_id = $user->id;
            $setaccount->code_id = $checkActivation->first()->id;

            $setaccount->upline_id = $account->id;
   
            $setaccount->sponsor_id = $sponsorAccountId->id;
            $setaccount->node = $request->node_placement;
            
            $setaccount->save();

            $setActivationCode = ActivationCodes::find($checkActivation->first()->id);
            $setActivationCode->status = 'used';
            $setActivationCode->user_id = $user->id;
            $setActivationCode->paid_by_balance = 'false';
            $setActivationCode->save();
            
            $logs = new Logs();
            $logs->logs_name = 'Enter Accounts of '.$user->id;
            $logs->logs_description = 'Activation Codes has been inserted....';
            $logs->save();

            $binary = new Binary();
            $membership = Membership::find($user->member_type_id);
            $companyIncome = $membership->entry_fee - ($membership->referral_income + $membership->money_pot);
            
            // $sponsor_id = ($this->sponsor_id > 0) ? $this->sponsor_id : $request->sponsor;
            
            //$activationCode = ActivationCodes::find($activation_id);
            //$company = Company::find($this->companyID);
            

            $sponsor_id = $sponsorAccountId->id;
            $sponsor = ($sponsor_id > 0) ? Accounts::find($sponsorAccountId->id) : null;

            //$sponsor_id = (isset($sponsor->id) and $sponsor->id > 0) ? $sponsor->id : 0;
            
            $binary->runReferral( $companyIncome, $sponsor_id, $sponsor, $setActivationCode, $user->id);
           
            $logs = new Logs();
            $logs->logs_name = 'Enter Referral of '.$sponsor_id;
            $logs->logs_description = 'Direct Referral has been inserted....';
            $logs->save();
            // $binary->runPointsValue($setaccount->upline_id, $user->id, $request->node_placement, $membership->points_value);
            
            // return response()->json([
            //     'success'  => "Success"
            // ], 200);

            $pairing = $binary
                    ->setMemberObject($setaccount)
                    ->crawl();

            
            $logs = new Logs();
            $logs->logs_name = 'Enter Pairing of '.$user->id;
            $logs->logs_description = 'Craw to binary has been inserted....';
            $logs->save();

           

            // $mail = new MailHelper();
            // $mail->setUserObject($user);
            // $mail->sendMail(REGISTRATION_KEY);

            return response()->json([
                'success'  => "Success"
            ], 200);
        }
        catch (\Exception $e) {
            return response()->json([
                'error'  => $this->formatException($e)
            ], 200);
        }
    }

    function getCheckAccount(Request $request)
    {
        $thisuser = Auth::user();
        $thisusername = $request->input('for_username');
        $usercount = User::where("group_id", $thisuser->group_id)->count();
        // die('total = '.$usercount.' - '.$thisusername);
        if($usercount > 7) {
            return response()->json([
                'error'  => "Own User Account limit exceeded"
            ], 200);
        }

        return response()->json([
            'success'  => "Success"
        ], 200);

    }

	function getLogin($id){
        Auth::logout();
        Session::flush();
        Auth::loginUsingId($id);
        $role = Auth::user()->role;
        return redirect($role . '/dashboard');
    }

}
