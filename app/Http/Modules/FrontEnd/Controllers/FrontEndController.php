<?php namespace App\Http\Modules\FrontEnd\Controllers;

use App\Helpers\MailHelper;
use App\Helpers\ShortEncrypt;
use App\Http\AbstractHandlers\MainAbstract;
use App\Http\Modules\FrontEnd\Validation\FrontEndValidationHandler;
use App\Http\TraitLayer\BinaryTrait;
use App\Models\Accounts;
use App\Models\ActivationCodes;
use App\Models\Details;
use App\Models\User;
use App\Models\Withdrawals;
use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Binary;
use App\Models\Company;
use App\Models\Logs;
use App\Models\CompanyEarnings;

class FrontEndController extends MainAbstract {

    use BinaryTrait;

    protected $viewPath = 'FrontEnd.views.';

    function getLogin(){
        return view($this->viewPath.'login');
    }
	function encodeCodes(Request $request) {
					
		$batch = [
                    'name' => $theBatchName,
					'type' => $codeType
                 ];

        $manageModel = new ModelHelper();
        $batchObject = $manageModel->manageModelData(new ActivationCodeBatches, $batch);

        $codes = new ActivationCodeHelperClass();
        $codes
            ->setBatchID($batchObject->id)
            ->setCodeType($inputs['type'])
            ->setNumOfZeros(5)
            ->setPatternEveryLetter(3)
            ->setPrefixLength(5);

        $theCodes = $codes->generateCodes($inputs['quantity'], $inputs['type']);

        ActivationCodes::insert($theCodes);
	}
	function validateUsername(Request $request){
		$thisusername = $request->username;
		/*
		User::find(0);
		return view( $this->viewPath . 'sign_up' )
            ->with([
                'id'=>0,
                'user'=>User::find(0),
				'membership'=>Membership::paginate(50),
                'referral'=>$request->ref,
				'úpline'=>$uplineid,
				'sponsor'=>$sponsorid,
				'node'=>$node,
                'suffix'=>($request->ref != null) ? '?ref=' . $request->ref : null
            ]);
		*/
		$usercount = User::where('username', $thisusername)->count();
		
		if($usercount > 0) {
			$thisuser = User::where('username',$thisusername)->get();
			$detailsId = $thisuser->user_details_id;
			
			$userDetails = Details::find($detailsId);
			$result = $userDetails->first_name." ".$userDetails->middle_name." ".$userDetails->last_name;
			//$result->error = true;
		} else {
			$result = "Does not exist";
		}
		
		return $result;
		return view($this->viewPath . 'auth/validateusername')->with([result=>$result]);
	}

    function postLogin(Request $request){

        $validate = new FrontEndValidationHandler();
            $validate
                ->setInputs($request->input());

        $result = $validate->validate();

        Session::flash($result->message_type, $result->message);

         if (!$result->error) {
            $role = Auth::user()->role;
        }

        $nextUrl = null;
        if (!$result->error){
            $user = Auth::user();
			$user->details->email;
            if ($user->details->email != null and isEmailRequired() and $user->role == MEMBER_ROLE){
                $code = ShortEncrypt::make(time());
                $user->verification_code = $code;
                $user->save();
                $nextUrl = 'auth/verify';
                $mail = new MailHelper();
                $mail->setUserObject($user)->setVerificationCode($code);
                $mail->sendMail(LOGIN_KEY);
            } else {
				if($role == 'teller') {
					$nextUrl = sprintf('%s/activation-codes', $role);
				} else {
					$nextUrl = sprintf('%s/dashboard', $role);
				}
            }
        }

        return ($result->error) ? redirect('auth/login') : redirect($nextUrl);

    }

    function getSignUp(Request $request){
		
		$uplineid = $request->input('uplineid');
		$sponsorid = $request->input('sponsorid');
		$node = $request->input('node');

		$activationCode = new ActivationCodes();

		$upline_info = $activationCode->get_account_name($uplineid);
		$sponsor_info = $activationCode->get_account_name($sponsorid);

        return view( $this->viewPath . 'sign_up' )
            ->with([
                'id'=>0,
                'user'=>User::find(0),
				'membership'=>Membership::paginate(50),
                'referral'=>$request->ref,
				'upline_name'=> (!empty($upline_info))? $upline_info->first_name.' '.$upline_info->last_name:'',
				'upline'=> $uplineid,
				'sponsor_name'=>(!empty($sponsor_info))? $sponsor_info->first_name.' '.$sponsor_info->last_name:'',
				'sponsor'=>$sponsorid,
				'node'=>$node,
                'suffix'=>($request->ref != null) ? '?ref=' . $request->ref : null
            ]);
    }

    function postSignUp(Request $request){

        $result = new \stdClass();
        $result->error = false;
        $result->message = '';

		if($request->input('own_Account') && ($request->input('own_Account') == 'Own Account')) {

			// $details = new Details();
			$thisuser = Auth::user();
            $request->first_name = $thisuser->details->first_name;
            $request->last_name = $thisuser->details->last_name;
            $request->email = $thisuser->details->email;
             //   $details->save();

            //    $user = new User();
           // $request->username = $thisuser->usernname.'-'.
            //    $user->password = Hash::make($request->password);
            //    $user->user_details_id = $details->id;
            //    $user->paid = ($request->have_activation == YES_STATUS) ? TRUE_STATUS : FALSE_STATUS;
			$thisusername = $request->input('forusername');
			$usercount = User::where("group_id",$thisuser->group_id)->count();
			// die('total = '.$usercount.' - '.$thisusername);
			if($usercount > 7) {
					$result->message = "Own User Account limit exceeded";
					$result->error = true;
			} else {
				$result->error = false;
			}
			//$validation = Validator::make($request->input());
		} else {

			$additional_rules = [
				'bank_name'=>'required',
				'bank_account_name'=>'required',
				'bank_account_number'=>'required',
				'password'=>'required|min:8',
				'password_confirm'=>'same:password|required',
				'first_name'=>'required',
				'last_name'=>'required',
				'username'=>'required|unique:users'
			];

			if ($request->have_activation == YES_STATUS){
				$additional_rules['upline_id'] = 'required';
				$additional_rules['account_id'] = 'required';
				$additional_rules['activation_code'] = 'required';
			}

			if (isEmailRequired()){
				$additional_rules['email'] = 'required|email|unique:user_details,email';
			}

			$validation = Validator::make($request->input(), $additional_rules);

			if ($validation->fails()){
				$result->error = true;
			}
		}
			if ($request->have_activation == YES_STATUS){
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
				
				/*if($request->input('own_Account') && ($request->input('own_Account') == 'Own Account')) {
					$thisusername = $request->input('forusername');
					$usercount = User::where('username','LIKE',"{$thisusername}%")->count();
					if($usercount >= 31) {
						$result->message = "Own User Account limit exceeded";
						$result->error = true;
					}
				}
				*/
				
				if (isset($validation) && $validation->fails()){
					$result->error = true;
				} else if ($checkActivation->isEmpty()){

					$result->message = Lang::get('messages.invalid_activation_code');
					$result->error = true;

				} else if($searchUpline->isEmpty()) {

					$result->error = true;
					$result->message = Lang::get('messages.invalid_upline');

				} else if ($uplineDownlineCount >= 2){

					$result->error = true;
					$result->message = Lang::get('messages.upline_has_complete_nodes');

				} else if(Accounts::where('node', $request->node_placement)->where('upline_id', $account->id)->count() > 0 ){

					$result->message = Lang::get('messages.node_already_occupied');
					$result->error = true;

				} else if (!isset($account->id)) {
					$result->message = Lang::get('There was a problem on encoding. Please try again!');
					$result->error = true;
			    }
			} else {
				
				$member_type = $request->type;
				$type = true;
			}
		
        if (!$result->error) {
            try {
				 
				
				
                $details = new Details();
                $details->first_name = $request->first_name;
                $details->last_name = $request->last_name;
                $details->email = $request->email;
                $details->save();
				
				$logs = new Logs();
                $logs->logs_name = 'Enter Details of '.$request->first_name.' '.$request->last_name;
                $logs->logs_description = 'User Details has been inserted....';
                $logs->save();

				if($request->input('own_Account') && ($request->input('own_Account') == 'Own Account')) {
					$user = new User();
					$user->username = $request->input('forusername')."-".$details->id;
					
					$user->password = $thisuser->password;
					$user->user_details_id = $details->id;
					$user->paid = true;
					$user->member_type_id = $checkActivation->first()->type_id;
					$user->role = MEMBER_ROLE;
					$user->group_id = $thisuser->group_id;
					$user->save();
				} else {
					$user = new User();
					$user->username = $request->username;
					$user->password = Hash::make($request->password);
					$user->user_details_id = $details->id;
					$user->paid = ($request->have_activation == YES_STATUS) ? TRUE_STATUS : FALSE_STATUS;
					//$user->paid = 'true';
					//addded 
					if(isset($type)){
						$user->member_type_id = $member_type;
					} else {
						$activationCode = $request->activation_code;
						
						//$user->paid = 'true';
						//$user->needs_activaton = 'true';
						$user->member_type_id = $checkActivation->first()->type_id;
					}
					
					// end added
					
					$user->role = MEMBER_ROLE;
					$user->save();

					$new_users = User::find($user->id);
					$new_users->group_id = $new_users->id;
					$new_users->update();
				}
               // $this->saveDetails($user->id, $request);

                if ($request->have_activation == YES_STATUS){
					
					$setaccount = new Accounts();
					$setaccount->user_id = $user->id;
					$setaccount->code_id = $checkActivation->first()->id;
					//if(isset($account->id)) {
					$setaccount->upline_id = $account->id;
					//} else {
						
					//}
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

					$binary->runPointsValue($setaccount->upline_id, $user->id, $request->node_placement, $membership->points_value);

					$logs = new Logs();
					$logs->logs_name = 'Enter Points Value '.$sponsor_id;
					$logs->logs_description = 'Points Value has been inserted....';
					$logs->save();

                    $pairing = $binary
                            ->setMemberObject($setaccount)
                            ->crawl();
							
					$logs = new Logs();
					$logs->logs_name = 'Enter Pairing of '.$user->id;
					$logs->logs_description = 'Craw to binary has been inserted....';
					$logs->save();
							
					 //$companyIncome = $this->calculateCompanyBaseIncome();
					 //private function calculateCompanyBaseIncome(){
					//	$result = new \stdClass();
					//	$company = Company::find($this->companyID);

					//	$result->referral_income = $company->referral_income;
					//	$result->money_pot = $company->money_pot;
						//$result->company_income = $company->entry_fee - ($company->referral_income + $company->money_pot);
					//	return $result;
					//}
					
					
					
					/*
                    $result = $this
                        ->setUserObject($user)
                        ->setSponsorId($sponsorAccountId->id)
                        ->setActivationCodeId($checkActivation->first()->id)
                        ->setUplineId($account->id)
                        ->validateAdminRegistration($request);
					*/
					
                }

                $mail = new MailHelper();
                $mail->setUserObject($user);
                $mail->sendMail(REGISTRATION_KEY);

                if (!isset(Auth::user()->id)) {
                    //if no one is logged in, then auto sign in
                    Auth::loginUsingId($user->id);
                    return redirect('member/dashboard');
                }

            } catch (\Exception $e) {
                $result->error = true;
                $result->message = $this->formatException($e);
            }
        }

        $suffix = ($request->ref != null) ? '?ref=' . $request->ref : null;
		if (isset($validation)) {
			$validationErrors = $validation->errors();
		} else {
		    $validationErrors = "";
		}
		$suffix .= '?node='.$request->node_placement;
        return ($result->error) ? redirect(sprintf('auth/sign-up%s', $suffix))
            ->withInput()
            ->withErrors($validationErrors)
            ->with('danger', $result->message) : redirect('auth/login')
            ->with('success', $result->message);

    }

    function getVerify(){
        if (!Auth::check()){
            return redirect('auth/login');
        }

        return view($this->viewPath . 'verify');
    }

    function postVerify(Request $request){
        $user = Auth::user();

        if ($request->verification_code != $user->verification_code){
            return back()->with('danger', Lang::get('messages.invalid_code'));
        } else {
            $user->verification_code = '';
            $user->save();
            return redirect('member/dashboard');
        }
    }

    function getTestMail(){
        $mail = new MailHelper();
        $mail->setPreview(true)->setUserObject(User::find(2))->setWithdrawalObject(Withdrawals::find(1));
        return $mail->sendMail(WITHDRAWAL_KEY);
    }
    
    function getWide(){
        return view($this->viewPath . 'wide');
    }
    
    function getAwarding(){
        return view($this->viewPath . 'awarding');
    }
    
    function getRegistrationSocials(){
        return view($this->viewPath . 'registration-socials');
    }

}
