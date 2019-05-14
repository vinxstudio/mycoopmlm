<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 3/3/17
 * Time: 6:15 PM
 */

namespace App\Helpers;

use App\Http\TraitLayer\GlobalSettingsTrait;
use App\Models\Accounts;
use App\Models\ActivationCodes;
use App\Models\Company;
use App\Models\CompanyEarnings;
use App\Models\Downlines;
use App\Models\Membership; /*addded*/
use App\Models\PointsPairing;
use App\Models\Earnings;
use App\Models\EWallet;
use App\Models\MoneyPot;
use App\Models\PairingSettings;
use App\Models\ReactivationPurchases;
use App\Models\User;
use App\Models\Logs;
use App\Models\Details;
use App\Models\PointsChecker;
use Illuminate\Support\Facades\Auth;

class Binary{

    use GlobalSettingsTrait;

    private $memberObject = null;

    protected $levelOneAccountId;

    protected $maxLevelsToShow = 8;

    protected $everyNthLevel = [];
	
	public $thisurl = '';

    function __construct(){

        $this->thisurl = config('app.url');
        
        $company = Company::find($this->companyID);
        $maxPair = $company->daily_max_pair;
        $counters = [];
        $every = config('pairingHooks.everyNthPair');


        for ($i = $every; $i<= $maxPair; $i+=$every){
            $counters[] = $i;
        }

        $this->everyNthLevel = $counters;
		
    }

    function setMemberObject($object){
        $this->memberObject = $object;
        return $this;
    }

    private function getMemberObject(){
        return $this->memberObject;
    }

    function setStaticCompensation($amount){
        $this->compensation = $amount;
        return $this;
    }

    private function enlistAccounts(){
        $accounts = Accounts::all();

        $result = new \stdClass();

        $result->list = [];
        $result->userIdsFreeCodes = [];

        foreach ($accounts as $account){
            $result->list[$account->id] = $account;

	    //$type = (!empty($account->code->type))? $account->code->type : '';

            //if (in_array($type, $this->toAvoidCodeTypes)){
            //    $result->userIdsFreeCodes[] = $account->id;
            //}
        }

        return $result;
    }

    private function hookEvents($pair, $upline, $baseMember, $level){

       if (in_array($baseMember->codes->code_type, $this->blockTypes)){
            $pair = false;
        }

        return $pair;

    }

    private function getPairedIds(){
        $earnings = Earnings::where('source', $this->earningsPairingKey)->get();

        $ids = [];

        foreach ($earnings as $row){
            $ids[$row->account_id][] = $row->left_user_id;
            $Ids[$row->account_id][] = $row->right_user_id;
        }

        return $ids;
    }

    function crawl(){

        $base = $this->getMemberObject();

        $userList = $this->enlistAccounts()->list;

        $upline_id = $base->upline_id;

        $currentLevel = 1;

        $node = $base->node;

        $downlines = [];

        while ($upline_id > 0){

            $query = Downlines::where([
                'parent_id'=>$upline_id,
                'account_id'=>$base->id,
                'level'=>$currentLevel,
                'node'=>$node
            ])->get();

            if ($query->isEmpty()) {
                $downlines[] = [
                    'parent_id' => $upline_id,
                    'account_id' => $base->id,
                    'level' => $currentLevel,
                    'node' => $node,
                    'code_id'=>$base->code_id,
                    'created_at' => date('Y-m-d h:i:s')
                ];
            }

            $currentLevel++;
            $node = $userList[$upline_id]->node;
            $upline_id = $userList[$upline_id]->upline_id;

        }

        if (count($downlines) > 0){
            Downlines::insert($downlines);
        }

        $details = $this->crawlIncome($base);

        return true;
        // return $details;

    }

    function crawlIncome($base){

        $pairedIDs = $this->getPairedIds(); //avoid pairing if ids match from stack

        $result = new \stdClass();

        $result->totalDeductionsToCompanyEarnings = 0;

        if (count($base->uplineIDs) <= 0){
            return;
        }

        $account_ids = implode(",", $base->uplineIDs);
        
        shell_exec("sh /var/www/html/mycoop_prod/cron/run.sh ".$account_ids);

        // $this->flushout();
        // $this->reclaimFreeAccounts();
        
        return $result;

    }

    function flushout(){

		//exit;
        $countryCode = config('system.countryCode');

        $timeZones = \DateTimeZone::listIdentifiers(\DateTimeZone::PER_COUNTRY, $countryCode);
        date_default_timezone_set($timeZones[0]);
		
        $currentDate = date('Y-m-d');
		$currentTime = date('H:i:s');
		
		$tomorrow=strtotime("tomorrow");
		$tomorrowDate = date("Y-m-d", $tomorrow);
		
		$yesterday = new \DateTime('yesterday');
		$yesterdayDate = $yesterday->format('Y-m-d');
		//added date time
		//$currentDateTime = date('Y-m-d hh:mm:ss');
		//      ->whereBetween('created_at', array($from, $to))->first();
		
		//  $company = Company::find($this->companyID);
        $company = getCompanyObject();
        $maxPair = $company->daily_max_pair;
		$first_start_time = $company->first_start_time;
		$first_cut_off_time = $company->first_cut_off_time;
		$second_start_time = $company->second_start_time;
		$second_cut_off_time = $company->second_cut_off_time;
		
		if ((strtotime($currentTime) > strtotime($first_cut_off_time)) || (strtotime($currentTime) < strtotime($first_start_time))) {
			if(strtotime($currentTime) > strtotime($first_cut_off_time) ) {
				$from = $currentDate.' '.$second_start_time;
				$to = $tomorrowDate.' '.$second_cut_off_time;
			} else {
				$from = $yesterdayDate.' '.$second_start_time;
				$to = $currentDate.' '.$second_cut_off_time;
			}
		} else {
			$from = $currentDate.' '.$first_start_time;
			$to = $currentDate.' '.$first_cut_off_time;
		}
		/*
        $check = Earnings::whereDate('created_at', '=', $currentDate)->where([
            'source'=>PAIRING_EARNINGS,
        ])->get(); //so we need only the user ids that are involved
		*/
		/*
		$check = Earnings::whereBetween('updated_at', array($from, $to))
				->whereIn(
						'source', ['GC',PAIRING_EARNINGS
				])->get();
		*/
		$check = Earnings::whereIn('source',['GC',$this->earningsPairingKey])
							 ->whereBetween('created_at', [$from, $to])->get();
		
					
        $userIds = [];
        $earningsToUpdate = [];

        foreach ($check as $ch){
            if (!in_array($ch->user_id, $userIds)) {
                $userIds[] = $ch->user_id;
            }
        }

        if (count($userIds) > 0) {
            foreach ($userIds as $userID) {
				/*
                $q = Earnings::whereDate('created_at', '=', $currentDate)->where([
                    'user_id' => $userID,
                    'source' => PAIRING_EARNINGS
                ])->orderBy('id', 'DESC')->get();
				*/
				$q = Earnings::whereBetween('created_at', [$from, $to])
				->whereIn('source', ['GC',PAIRING_EARNINGS])
				->where('user_id', $userID)->get();
				
				

                $todayCount = 1;
                $totalPairs = 1; //plus current earnings

                foreach ($q as $earnings) {
					$maxPair = $maxPair + 1;
                    if ($todayCount >= $maxPair) {
                        $earningsToUpdate[] = $earnings->id;
						
						Earnings::whereIn('id', $earningsToUpdate)->update([
							'amount'=>0
						]);
                    }

                    $todayCount++;
                    $totalPairs++;
                }

            }

        }

        if (count($earningsToUpdate) > 0){
            Earnings::whereIn('id', $earningsToUpdate)->update([
                'amount'=>0
            ]);
			
        }

        //then recheck again for the account maintenance
        $usersToUpdate = [];
        $saveDeductions = [];
        foreach ($userIds as $userID) {
            $user = User::find($userID);
            if ($user->is_maintained == TRUE_STATUS) {
                $overallEarnings = $user->earnings;
                $purchasedReactivation = ReactivationPurchases::where([
                    'user_id' => $user->id
                ])->get();

                $targetNumberOfActivation = (int)($overallEarnings / $company->activation_every);

                if ($targetNumberOfActivation > $purchasedReactivation->count()) {
                    $usersToUpdate[] = $user->id;
                    //deduct earnings
                    $multiplier = $purchasedReactivation->count();
                    if ($multiplier <= 0) {
                        $multiplier = 1;
                    }
                    $toDeduct = $overallEarnings - ($company->activation_every * $multiplier);
                    $saveDeductions[] = [
                        'account_id' => $user->account->id,
                        'user_id' => $user->id,
                        'source' => SYSTEM_GENERATED,
                        'amount' => ($toDeduct * -1),
                        'created_at' => date(CREATED_AT_FORMAT),
                    ];
                }
            }
        }

		/*
        if (count($usersToUpdate) > 0){
            User::whereIn('id', $usersToUpdate)->update([
                'is_maintained'=>FALSE_STATUS
            ]);
        }
		*/

        if (count($saveDeductions) > 0){
            Earnings::insert($saveDeductions);
        }

    }

    private function reclaimFreeAccounts(){
        $freeCodes = ActivationCodes::where([
            'type'=>FREE_CODE,
            'status'=>USED_STATUS
        ])->get();

        $accountIds = [];
        $codesToUpdate = [];
        $userEarningsToUpdate = [];

        foreach ($freeCodes as $free){
            $accountIds[] = $free->id;
        }

        if (count($accountIds) > 0){
            $company = getCompanyObject();
            $accounts = Accounts::whereIn('code_id', $accountIds)->get();
            foreach ($accounts as $account){
                if ($account->totalEarned >= $company->entry_fee){
                    $codesToUpdate[] = $account->code_id;
					
					// added Activation code activation to other Type
					$thisUser = User::find($account->user_id);
					$membershipId = $thisUser->member_type_id;
				
					$thisUserMembership = Membership::find($membershipId);
					
					$membershipname = $thisUserMembership->membership_type_name;
					 ActivationCodes::where('id', $account->code_id)->update(['type'=>$membershipname]);
					
					//end added  ---> code activation to other Type
					
                    $userEarningsToUpdate[] = [
                        'user_id'=>$account->user_id,
                        'account_id'=>$account->id
                    ];
                }
            }
        }
		/*
        if (count($codesToUpdate) > 0){
            ActivationCodes::whereIn('id', $codesToUpdate)->update(['type'=>REGULAR_CODE]);
			
        }
		*/

        if (count($userEarningsToUpdate) > 0){
            $earnings = [];
            $company = getCompanyObject();
            //$balance = ($company->entry_fee * (-1));
			
			
			
			
            foreach ($userEarningsToUpdate as $row){
				
				//added to get the exact entry fee for balance
				if ($row['user_id'] != NULL) {
					$thisUser = User::find($row['user_id']);
					$membershipId = $thisUser->member_type_id;
				
					$thisUserMembership = Membership::find($membershipId);
					
					$balance = ($thisUserMembership->entry_fee * (-1));
					
				} else {
					
					$balance = ($company->entry_fee * (-1));
					
				}
			
				// end --- to get the exact entry fee for balance
				
                $earnings[] = [
                    'account_id'=>$row['account_id'],
                    'user_id'=>$row['user_id'],
                    'amount'=>$balance,
                    'source'=>SYSTEM_GENERATED,
                    'created_at'=>date('Y-m-d H:i:s')
                ];
            }

            Earnings::insert($earnings);
        }

    }

    private function EarningsHook($account_id, $earningsArray){

        /*if (config('pairingHooks.enable')) {
            $earnings = Earnings::where([
                'account_id' => $account_id,
                'source' => $this->earningsPairingKey,
                'from_funding' => false
            ])->whereDate('created_at', '=', date('Y-m-d'))->get();

            if (in_array($earnings->count(), $this->everyNthLevel)) {
                $earningsArray['source'] = $this->earningsGCKey;
            }
        }*/

        return $earningsArray;
    }

    function setLevelOneAccount($id){
        $this->levelOneAccountId = $id;
        return $this;
    }

	function convertCDtoRegular($userId, $accountId, $typeId) {
		//ConvertCD to Regular Accounts

		if ($typeId == 4) {
			$type = 1;
			$typename = 'Package A';
			$referralIncome = 200;
		} else if ($typeId == 5) {
			$type = 2;
			$typename = 'Package B';
			$referralIncome = 400;
		} else if ($typeId == 6) {
			$type = 3;
			$typename = 'Package C';
			$referralIncome = 800;
		}
	
		User::where('id', $userId)->update([
							'member_type_id'=> $type
						]);
						
		ActivationCodes::where('user_id', $userId)->update([
							'type_id'=> $type,
							'type'=> $typename
						]);
		//updateReferral of Upline
		$thisAccount = Accounts::where('user_id', $userId)->first();
		$sponsor = Accounts::find($thisAccount->sponsor_id);
		if(isset($sponsor)) {
		$earnings = new Earnings;
                    $earnings->account_id = $sponsor->id;
                    $earnings->user_id = $sponsor->user_id;
                    $earnings->source = $this->earningsDirectReferralKey;
                    $earnings->amount = $referralIncome;
                    $earnings->save();
		}

        
		//updateBinary and Referral
		/*
		$binary = new Binary();
		$membership = Membership::find($user->member_type_id);
					
		$binary->runPointsValue($setaccount->upline_id, $user->id, $request->node_placement, $membership->points_value);
					
         
		*/
		
		/*
		$companyIncome = $membership->entry_fee - ($membership->referral_income + $membership->money_pot);
					
                   
					 $sponsor_id = $sponsorAccountId->id;
					 $sponsor = ($sponsor_id > 0) ? Accounts::find($sponsorAccountId->id) : null;

					 $sponsor_id = (isset($sponsor->id) and $sponsor->id > 0) ? $sponsor->id : 0;
					
					$binary->runReferral($pairing, $companyIncome, $sponsor_id, $sponsor, $setActivationCode, $user->id);
		*/			
	}
    function getOldAccount($user_id)
    {
        $oldAccount = [];
        $old = Accounts::select('id', 'code_id')->where('user_id', $user_id)->first();
        $oldMemberType = User::select('member_type_id')->where('id', $user_id)->first();
        return $oldAccount = [
            'id' => $old->id,
            'activation_id' => $old->code_id,
            'member_type_id' => $oldMemberType->member_type_id
        ];
    }

    function getNewAccount($user_id)
    {
        $newAccount = [];
        $new = Accounts::select('code_id')->where('user_id', $user_id)->first();
        $newMemberType = User::select('member_type_id')->where('id', $user_id)->first();
        return $newAccount = [
            'activation_id' => $new->code_id,
            'member_type_id' => $newMemberType->member_type_id
        ];
    }
    // upgrade account
    function upgradeAccount($activation_id, $account_id, $user_id, $type_id) {

            if ($type_id == 1) {
                $type = 1;
                $referralIncome = 200;
            } else if ($type_id == 2) {
                $type = 2;
                $referralIncome = 400;
            } else if ($type_id == 3) {
                $type = 3;
                $referralIncome = 800;
            }

            $user = User::where('id', $user_id)->update([
                                'member_type_id'=> $type
                            ]);

            $activation_code = ActivationCodes::where('account_id', $account_id)
                                 ->update([
                                    'status'=> 'used',
                                    'user_id'=> $user_id
                                ]);
            
            //updateReferral of Upline
            $thisAccount = Accounts::where('user_id', $user_id)->first();
            $accounts = Accounts::where('user_id', $user_id)->update(['code_id' => $activation_id]);
            $sponsor = ActivationCodes::select('accounts.user_id', 'accounts.id')
                                    ->leftJoin('accounts', 'accounts.user_id', '=', 'activation_codes.user_id')
                                    ->where('account_id', $thisAccount->sponsor_id)
                                    ->first();
          
            if(isset($sponsor)) {
                
                $earnings = new Earnings;
                $earnings->account_id = $sponsor->id;
                $earnings->user_id = $sponsor->user_id;
                $earnings->source = $this->earningsDirectReferralKey;
                $earnings->left_user_id = $thisAccount->id;
                $earnings->earned_date = date(CREATED_AT_FORMAT);
                $earnings->amount = $referralIncome;
                $earnings->save();
            }

            if($earnings && $accounts && $thisAccount && $user && $activation_code)
            {
                return ['message' => 'Success'];
            }
            return ['message' => 'Something went wrong!'];
        }
                    
    function getAccountTree($start_id = null){
        $data = array();
        if($start_id){
            $colorFlag = 0;
            $LevelNum = 0;
            $countRB = 0;
            $countDR = 0;
            $countMB = 0;
            $countLPV = 0;
            $countRPV = 0;

            // $start_id = $this->levelOneAccountId;
            $total_count = 0;
            $nodeCtr = 0;
            $usr = Accounts::where('upline_id', $start_id)->orderBy('node', 'asc')->get();
            $counterNode = Accounts::where('upline_id', $start_id)->count();
            $loginuser = Auth::user();
            $color = "";
                    
            $loginuserId = $loginuser->id;
                    
            $accountuser = ActivationCodes::where('user_id', $loginuserId)->get();
            
            foreach ($accountuser as $accountuser){
                $sponsorId = $accountuser->account_id;
                $accountid = $accountuser->account_id;
                //$uplineid = $accountuser->account_id;
            }
            $forUpline = Accounts::find($start_id);
            // $accountUpline = ActivationCodes::where('user_id', $forUpline->user_id)->get();
            // foreach ($accountUpline as $accountUpline){
            //     $uplineId = $accountUpline->account_id;
            // }
            foreach ($usr as $row) {
                if ($row->code->type == "Package A") {
                    $color = "#a894f3";
                    $colorFlag = 0;
                } else if ($row->code->type == "Package B")  {
                    $color = "#f394c6";
                    $colorFlag = 0;
                } else if ($row->code->type == "Package C") {
                    $color ="#cff394";
                    $colorFlag = 0;
                } else if ($row->code->type == "CD - Package A") {
                    $color ="#E1DFDE";
                    $colorFlag = 1;
                } else if ($row->code->type == "CD - Package B") {
                    $color ="#D1CECE";
                    $colorFlag = 1;
                } else if ($row->code->type == "CD - Package C") {
                    $color ="#C1BCBB";
                    $colorFlag = 1;
                } else if ($row->code->type == "AR - Package A") {
                    $color ="#E1DFDE";
                    $colorFlag = 1;
                } else if ($row->code->type == "AR - Package B") {
                    $color ="#D1CECE";
                    $colorFlag = 1;
                } else if ($row->code->type == "AR - Package C") {
                    $color ="#C1BCBB";
                    $colorFlag = 1;
                }
                $activation_code = new ActivationCodes();
                $sponsor = $activation_code->get_sponsor_name($row->sponsor_id);
                $nodeCtr++;
                //$earnings = Earnings::find($row->code->account_id);
                // $countDR = Earnings::where([
                //                 'account_id'=>$row->id,
                //                 'source'=>'direct_referral'
                //             ])->sum('amount');
                // $countMB = Earnings::where([
                //                 'account_id'=>$row->id,
                //                 'source'=>'pairing'
                //             ])->sum('amount');
                $membership = Membership::find($row->code->type_id);
                //$countRB = ($membership->entry_fee) + $countMB + $countDR;
                $countRB = $countMB + $countDR;
                // $countLPV = Earnings::where([
                //                 'account_id'=>$row->id,
                //                 'source'=>'left_pv'
                //             ])->sum('amount');
                // $countRPV = Earnings::where([
                //                 'account_id'=>$row->id,
                //                 'source'=>'right_pv'
                //             ])->sum('amount');
                
                // if ($countRPV < 0)  {
                //     $countRPV = abs($countRPV);
                // }
                // if ($countLPV < 0)  {
                //     $countLPV = abs($countLPV);
                // } 

                // if ($countRPV > $countLPV)  {
                //     $countRPV = $countRPV - $countLPV;
                //     $countLPV = 0;
                //     // $countRPV = abs($countRPV);
                // }

                // if ($countLPV > $countRPV)  {
                //     $countLPV = $countLPV - $countRPV;
                //     $countRPV = 0;
                // }

                // if ($countRPV > $countLPV)  {
                //     $countRPV = $countRPV - $countLPV;
                //     $countLPV = 0;
                //     // $countRPV = abs($countRPV);
                // }
                // else if ($countLPV > $countRPV)  {
                //     $countLPV = $countLPV - $countRPV;
                //     $countRPV = 0;
                // }
                // else 
                // {
                //     $countRPV = 0;
                //     $countLPV = 0;
                // }

                $points_value = PointsChecker::where('account_id', $row->id)->first();
                if(!empty($points_value))
                {
                    $countLPV = $points_value->left_points_value;
                    $countRPV = $points_value->right_points_value;
                }else
                {
                    $countLPV = 0;
                    $countRPV = 0;
                }
                // $countLPV = (!empty($points_value->left_points_value)) ? $points_value->left_points_value : 0;
                // $countRPV = (!empty($points_value->right_points_value)) ? $points_value->right_points_value : 0;
                
                $getlevel = Downlines::where('code_id',$row->code->id)->get();
                foreach ($getlevel as $getlevel){
                    $LevelNum = $getlevel->level;
                }

                if( empty($LevelNum) ) $LevelNum = 1; 

            $data[$row->node] = array(
                            'account_id'=>$row->id,
                            'viewed'=>session('recorded_viewing'),
                            // 'downlinesArray'=>$downlinesArray,
                            'color'=>$color,
                            'colorFlag'=>$colorFlag,
                            'currentUser'=>$row,
                            'level'=>$LevelNum ,
                            'sponsor' => $sponsor,
                            // 'countRB'=>$countRB,
                            // 'countDR'=>$countDR,
                            // 'countMB'=>$countMB,
                            'countLPV'=>$countLPV,
                            'countRPV'=>$countRPV,
                        );
                
            }

            

        }
        
        return $data;
    }

    function renderTree($level = 1){

		$start_id = $this->levelOneAccountId;
        $total_count = 0;
        $html = "";
        $level++;
		$nodeCtr = 0;
        $usr = Accounts::where('upline_id', $start_id)->orderBy('node', 'asc')->get();
		$counterNode = Accounts::where('upline_id', $start_id)->count();
		$loginuser = Auth::user();
		$color = "";
		
				
		$loginuserId = $loginuser->id;
				
		$accountuser = ActivationCodes::where('user_id', $loginuserId)->get();
		
		foreach ($accountuser as $accountuser){
			$sponsorId = $accountuser->account_id;
			$accountid = $accountuser->account_id;
			//$uplineid = $accountuser->account_id;
		}
		$forUpline = Accounts::find($start_id);
		$accountUpline = ActivationCodes::where('user_id', $forUpline->user_id)->get();
		foreach ($accountUpline as $accountUpline){
			$uplineId = $accountUpline->account_id;
		}
        foreach ($usr as $row) {
			if ($row->code->type == "Package A") {
				$color = "#a894f3";
				$colorFlag = 0;
			} else if ($row->code->type == "Package B")  {
				$color = "#f394c6";
				$colorFlag = 0;
			} else if ($row->code->type == "Package C") {
				$color ="#cff394";
				$colorFlag = 0;
			} else if ($row->code->type == "CD - Package A") {
				$color ="#E1DFDE";
				$colorFlag = 1;
			} else if ($row->code->type == "CD - Package B") {
				$color ="#D1CECE";
				$colorFlag = 1;
			} else if ($row->code->type == "CD - Package C") {
				$color ="#C1BCBB";
				$colorFlag = 1;
			} else if ($row->code->type == "AR - Package A") {
				$color ="#E1DFDE";
				$colorFlag = 1;
			} else if ($row->code->type == "AR - Package B") {
				$color ="#D1CECE";
				$colorFlag = 1;
			} else if ($row->code->type == "AR - Package C") {
				$color ="#C1BCBB";
				$colorFlag = 1;
			}
			
			$nodeCtr++;
			//$earnings = Earnings::find($row->code->account_id);
			$countDR = Earnings::where([
                            'account_id'=>$row->id,
                            'source'=>'direct_referral'
                        ])->sum('amount');
			$countMB = Earnings::where([
                            'account_id'=>$row->id,
                            'source'=>'pairing'
                        ])->sum('amount');
			$membership	= Membership::find($row->code->type_id);
			//$countRB = ($membership->entry_fee) + $countMB + $countDR;
			$countRB = $countMB + $countDR;
			$countLPV = Earnings::where([
                            'account_id'=>$row->id,
                            'source'=>'left_pv'
                        ])->sum('amount');
			$countRPV = Earnings::where([
                            'account_id'=>$row->id,
                            'source'=>'right_pv'
                        ])->sum('amount');
			if ($countRPV < 0)  {
				$countRPV = abs($countRPV);
			}
			if ($countLPV < 0)  {
				$countLPV = abs($countLPV);
			} 
			
			$getlevel = Downlines::where('code_id',$row->code->id)->get();
			foreach ($getlevel as $getlevel){
				$LevelNum = $getlevel->level;
			}

			if( empty($LevelNum) ) $LevelNum = 1; 
			
			if (($counterNode < 2) && ($row->node == 'right')){
				$html .= sprintf("<li  class=\"binary code-\">%s </br>" ,'left');
				$html .= sprintf("<a href='#' onClick=\"javascript:popUp('".$this->thisurl."auth/sign-up?uplineid=".$uplineId."&sponsorid=".$sponsorId."&node=left&theusername=".$loginuser->username."')\" class=\"btn\">Activate</a>");
				
				$html .= "</li>";
				$forRighthtml = "";
				$forRighthtml .= sprintf("<li style=\"background-color:".$color."\" class=\"binary code-\">%s", $row->code->type .'</br> Level '.$LevelNum);
				
				if ($row->code->type != "Package C" && (preg_match('#^'.$row->username.'#', $loginuser->username) === 1) ) {
					$forRighthtml .= "</br><a href='#' onClick=\"javascript:popUp2('".$this->thisurl."auth/sign-up?upgrade=upgrade&accountid=".$row->id."')\"> Upgrade </a>";
					//href='#' onClick=\"javascript:popUp('http://localhost/latestmycoop/auth/sign-up?uplineid=".$uplineId."&sponsorid=".$sponsorId."&node=right&username=".$loginuser->username."'
				}
				$forRighthtml .= sprintf("<a href=\"%s\">", url('member/network-tree/index/' .strtoupper($row->code->account_id) . '-' . $row->user->id));
				$forRighthtml .= sprintf("<img  src=\"%s\" width=\"80\" height=\"80\">", url($row->user->details->thePhoto));
				$forRighthtml .= sprintf("<span class=\"owner-name\">%s</span>", $row->user->details->fullName);
				$forRighthtml .= sprintf("<span style='font-size:10px' class=\"account-id\">ID: %s</span></br>", strtoupper($row->code->account_id));
				if($colorFlag == 1) {
					$forRighthtml .= sprintf("<span style='font-size:10px' class=\"matching-income\">AR: %s</span></br>", $countRB);
				} else {
					$forRighthtml .= sprintf("<span style='font-size:10px' class=\"matching-income\">MB: %s</span></br>", $countMB);
					$forRighthtml .= sprintf("<span style='font-size:10px' class=\"referral-income\">DR: %s</span></br>", $countDR);
					$forRighthtml .= sprintf("<span style='font-size:10px' class=\"points-value\">LPV: %s</span></br>", $countLPV);
					$forRighthtml .= sprintf("<span style='font-size:10px' class=\"points-value\">RPV: %s</span></br>", $countRPV);
				}
				$forRighthtml .= '</a>';
				$forRighthtml .= "<ul>";
				$html .= $forRighthtml;
				
			} else {
				
				$html .= sprintf("<li style=\"background-color:".$color."\" class=\"binary code-\">%s", $row->code->type .'</br>Level '.$LevelNum);
				if ($row->code->type != "Package C" && (preg_match('#^'.$row->username.'#', $loginuser->username) === 1) ) {
					$html .= "</br><a href='#' onClick=\"javascript:popUp2('".$this->thisurl."auth/sign-up?upgrade=upgrade&accountid=".$row->id."')\"> Upgrade </a>";
				}
				$html .= sprintf("<a href=\"%s\">", url('member/network-tree/index/' .strtoupper($row->code->account_id) . '-' . $row->user->id));
				$html .= sprintf("<img  src=\"%s\" width=\"80\" height=\"80\">", url($row->user->details->thePhoto));
				$html .= sprintf("<span class=\"owner-name\">%s</span>", $row->user->details->fullName);
				$html .= sprintf("<span style='font-size:10px' class=\"account-id\">ID: %s</span></br>", strtoupper($row->code->account_id));
				if($colorFlag == 1) {
					$html  .= sprintf("<span style='font-size:10px' class=\"matching-income\">AR: %s</span></br>", $countRB);
				} else {
					$html  .= sprintf("<span style='font-size:10px' class=\"matching-income\">MB: %s</span></br>", $countMB);
					$html  .= sprintf("<span style='font-size:10px' class=\"referral-income\">DR: %s</span></br>", $countDR);
					$html  .= sprintf("<span style='font-size:10px' class=\"points-value\">LPV: %s</span></br>", $countLPV);
					$html  .= sprintf("<span style='font-size:10px' class=\"points-value\">RPV: %s</span></br>", $countRPV);
				}
				$html .= '</a>';
				$html .= "<ul>";
			}

            if (($level-1) < 2) {
				
                $html .= $this->setLevelOneAccount($row->id)->renderTree($level);
            } else {
				$html .= $this->renderActivate($row->id, $level, $row->code->account_id, $sponsorId, $row->node);
			}
			$accountid = $row->code->account_id;
            $html .= "</ul>";
            $html .= "</li>";
        }
		
		if ($nodeCtr < 2) {
			if ($nodeCtr == 1){
				if ($row->node == 'left') {
					$thisnode = 'right';
				} else {
					$thisnode = 'left';
					
				}
				if (($counterNode < 2) && ($row->node == 'right')){
				$html .= "";
				}	else {
				
				$html .= sprintf("<li  class=\"binary code-\">%s </br>" ,$thisnode);
				$html .= sprintf("<a href='#' onClick=\"javascript:popUp('".$this->thisurl."auth/sign-up?uplineid=".$uplineId."&sponsorid=".$sponsorId."&node=right&theusername=".$loginuser->username."')\" class=\"btn\">Activate</a>");
				
				$html .= "</li>";
				}
			
				
			} else {
				$usr = Accounts::find($start_id);
				
				$accountuser = ActivationCodes::where('user_id', $usr->user_id)->get();
		
					foreach ($accountuser as $accountuser){
						
						$accountid = $accountuser->account_id;
					}
				
				$html .= $this->renderActivate($start_id, $level, $uplineId, $sponsorId, 'left');
			}
		}
		
        $level++;
        return $html;
    }
	
	//for inside node
	function renderLeftActivate(){
		$html .= "";
		
				$html .= "<ul>";
				$html .= sprintf("<li class=\"binary code-\">%s" ,'left');
				$html .= sprintf("<a href=\"\">", url('member/network-tree/index/'));
				$html .= sprintf("<span class=\"owner-name\">%s</span>", 'Taken');
				$html .= sprintf("<span class=\"account-id\"></span><br/>");
				
				
				
				$html .= "</a>";
				
				$html .= "</li>";
				
				$html .= sprintf("<li class=\"binary code-\">%s" ,'right');
				$html .= sprintf("<a id=\"onclick\" href=\"\">", url('member/network-tree/index/'));
				$html .= sprintf("<span class=\"owner-name\">%s</span>", 'TAken');
				$html .= sprintf("<span class=\"account-id\"></span><br/>");
				
				
				
				$html .= "</a>";
				
				$html .= "</li>";
				$html .= "</ul>";
		
				
			return $html;
	} 
	function renderRightActivate(){
		$html .= "";
		
				$html .= "<ul>";
				$html .= sprintf("<li class=\"binary code-\">%s" ,'left');
				$html .= sprintf("<a href=\"\">", url('member/network-tree/index/'));
				$html .= sprintf("<span class=\"owner-name\">%s</span>", 'Taken');
				$html .= sprintf("<span class=\"account-id\"></span><br/>");
				
				
				
				$html .= "</a>";
				
				$html .= "</li>";
				
				$html .= sprintf("<li class=\"binary code-\">%s" ,'right');
				$html .= sprintf("<a href=\"\">", url('member/network-tree/index/'));
				$html .= sprintf("<span class=\"owner-name\">%s</span>", 'Taken');
				$html .= sprintf("<span class=\"account-id\"></span><br/>");
				
				
				
				$html .= "</a>";
				
				$html .= "</li>";
				$html .= "</ul>";
		
				
			return $html;
	} 
	function renderActivate($parentid, $level, $uplineid, $sponsorId, $thisnode){
			$checkLeft = 'Activate';
			$checkRight = 'Activate';
			$queryLeft = Downlines::where([
                'parent_id'=>$parentid,
                'node'=>'left'
            ])->get();
			$queryRight = Downlines::where([
                'parent_id'=>$parentid,
                'node'=>'right'
            ])->get();
			$newhtml = "";
			$loginuser = Auth::user();
			
				$newhtml .= sprintf("<li class=\"binary code-\">%s </br>" ,'left');
				if (!$queryLeft->isEmpty()){
					$newhtml .=  'Taken';
				} else {
					$newhtml .= "<a href='#' onClick=\"javascript:popUp('".$this->thisurl."auth/sign-up?uplineid=".$uplineid."&sponsorid=".$sponsorId."&node=left&theusername=".$loginuser->username."')\" class=\"btn\">".$checkLeft."</a>";
				}
				$newhtml .= "</li>";
				 
				$newhtml .= sprintf("<li class=\"binary code-\">%s </br>" ,'right');
				
				if (!$queryRight->isEmpty()){
					$newhtml .= 'Taken';
				} else {
					$newhtml .= "<a href='#' onClick=\"javascript:popUp('".$this->thisurl."auth/sign-up?uplineid=".$uplineid."&sponsorid=".$sponsorId."&node=right&theusername=".$loginuser->username."')\" class=\"btn\">".$checkRight."</a>";
				}
				
				$newhtml .= "</li>";
		
		
				
			return $newhtml;
	} 
	function runPointsValue ($uplineId, $userid, $node, $pointsValue) {
		/*
		$accountUser = Accounts::find($uplineId);
		
		$PVearnings = new Earnings;
        $PVearnings->account_id = $accountUser->id;
        $PVearnings->user_id = $accountUser->user_id;
        $PVearnings->source = $node."_pv";
        $PVearnings->amount = $pointsValue;
        $PVearnings->save();
		*/
		
		//$usr = Accounts::where('upline_id', $uplineId)->get();
		//foreach ($usr as $row) {
		
		$row = Accounts::find($uplineId);
		if(isset($row->id)){
			$PVearnings = new Earnings;
			$user_new = User::find($userid);

			$PVearnings->account_id = $row->id;
			$PVearnings->user_id = $row->user_id;
			
			$PVearnings->source = $node."_pv";
			
			$thisUser = User::find($row->user_id);
			$memberId = $thisUser->member_type_id;
			
			$memberUser = Membership::find($memberId);
			$newpointsValue = $memberUser->points_value;
			
			if($user_new->created_at > $thisUser->created_at)
			{
				$earned_date = $user_new->created_at;
			}else{
				$earned_date = $thisUser->created_at;
			}

			if($memberUser->id > 3 ){
				$PVearnings->amount = 0;
			}else{
				$thisnewpointsValue = min($pointsValue,$newpointsValue);
				$PVearnings->amount = $thisnewpointsValue;
			}
			
			$PVearnings->earned_date = $earned_date;
			$PVearnings->left_user_id = $row->user_id;
			$PVearnings->right_user_id = $userid;
			
			$PVearnings->save();
			
			$this->runPointsValue ($row->upline_id, $userid, $row->node, $pointsValue);
		}
		//
	}
    function runReferral($companyIncome, $sponsor_id, $sponsor, $activationCode, $userid){
        $allowReferral = true;
        $company = getCompanyObject();

        $sponsor = Accounts::find($sponsor_id);

        if (isset($sponsor->id)) {
            if (in_array($sponsor->code->type, $this->toAvoidCodeTypes) and $company->free_code_referral >= 1) {
                $allowReferral = false;
            }

            if ($activationCode->type == FREE_CODE) { //if the current encoded is also free code, then no referral
                $allowReferral = false;
            }

            if ($allowReferral) {
				
				// added and updated to get the exact user referral_income
				if ($sponsor_id != NULL) {
					//$companyEarnings = new CompanyEarnings();
					$theUser = User::find($userid);
					$memberAccount = Accounts::where('user_id',$userid)->first();
					// 1/17/2018 edit
					$accountSponsor = Accounts::find($sponsor_id);
					$sponsorUser = User::find($accountSponsor->user_id);
					
					$sponsormembershipId = $sponsorUser->member_type_id;
					// 1/17/2018 end
					
					$usermembershipId = $theUser->member_type_id;
					
					$sponsorMembership = Membership::find($sponsormembershipId);
					$userMembership = Membership::find($usermembershipId);
					
					if($userMembership->id > 3){
						$referralIncome = 0;
					}else{
					   $referralIncome = min($sponsorMembership->referral_income,$userMembership->referral_income);
					}

					/*if ($sponsorMembership->referral_income > 0) {
						$referralIncome = min($sponsorMembership->referral_income,$userMembership->referral_income);
					//$referralIncome = $sponsorMembership->referral_income;
					} else {
						$referralIncome = $userMembership->referral_income;
					}*/
					
					$companyEarningsAmount =  $userMembership->entry_fee;
					//$companyEarningsAmount = $sponsorMembership->entry_fee;
					
					$moneyPotAmount = min($sponsorMembership->money_pot, $userMembership->money_pot);
					//$moneyPotAmount = $sponsorMembership->money_pot;
				} else {
					$referralIncome = $company->referral_income;
					$companyEarningsAmount = $company->entry_fee;
					$moneyPotAmount = $company->money_pot;
				}
					
				//end added for referral_income

                if ($sponsor_id > 0) {
                    //$referralIncome = $company->referral_income;
					
					 
					/*
                    if ($sponsor->user->is_maintained == false) {
                        $referralIncome = 0;
                    }
					*/

                    $directReferralCharge = config('system.direct_referral_charge');
                    if ($referralIncome > 0 and $directReferralCharge > 0) {
                        $eWallet = calculatePercentage($directReferralCharge, $referralIncome);
                        $wallet = new EWallet();
                        $wallet->account_id = $sponsor->id;
                        $wallet->user_id = $sponsor->user_id;
                        $wallet->source = $this->earningsDirectReferralKey;
                        $wallet->amount = $eWallet;
                        $wallet->save();
                        $referralIncome = $referralIncome - $eWallet;
                    }

                    $earned_date = (!empty($memberAccount->upgraded_on))? $memberAccount->upgraded_on:$memberAccount->created_at;
                    
                    $earnings = new Earnings;
                    $earnings->account_id = $sponsor->id;
                    $earnings->user_id = $sponsor->user_id;
                    $earnings->source = $this->earningsDirectReferralKey;
                    $earnings->amount = $referralIncome;
                    $earnings->left_user_id = $memberAccount->id;
                    $earnings->earned_date =  $earned_date;
                    $earnings->save();
					
					$logs = new Logs();
					$logs->logs_name = 'Sponsor Earnings of '.$sponsor->id;
					$logs->logs_description = 'Sponsor Earnings has been inserted....';
					$logs->save();
					
					
                }

                $companyEarnings = new CompanyEarnings();
                //$companyEarnings->amount = $company->entry_fee;
                $companyEarnings->amount = $companyEarningsAmount;
				//added exact package entry_fee
				
				$companyEarnings->details = $this->companyIncomeDetails;
                $companyEarnings->save();

                $moneyPot = new MoneyPot();
                //$moneyPot->amount = $company->money_pot;
				$moneyPot->amount = $moneyPotAmount;
                $moneyPot->source = $this->companyIncomeDetails;
                $moneyPot->save();
				
				$membership	= Membership::find($sponsorUser->member_type_id);
				
				if($membership->id > 3 && $membership->id < 7) {
					$countDR = Earnings::where([
                            'account_id'=>$sponsor->id,
                            'source'=>'direct_referral'
                        ])->sum('amount');
					$countMB = Earnings::where([
								'account_id'=>$sponsor->id,
								'source'=>'pairing'
							])->sum('amount');
					
					$countRB = ($membership->entry_fee) + $countMB + $countDR;
					if ($countRB >= 0) {
						    //userid && accountid
							$this->convertCDtoRegular($sponsor->user_id, $sponsor->id, $sponsorUser->member_type_id);
					}
				}
            }
        }

    }

}
