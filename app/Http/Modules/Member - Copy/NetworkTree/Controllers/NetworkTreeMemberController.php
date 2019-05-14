<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 3/7/17
 * Time: 8:05 PM
 */

namespace App\Http\Modules\Member\NetworkTree\Controllers;

use App\Helpers\Binary;
use App\Http\AbstractHandlers\MemberAbstract;
use App\Models\User;
use App\Models\Earnings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class NetworkTreeMemberController extends MemberAbstract{

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
		} else {
				$thisaccount = $level1Account;
		}
		$countDR = Earnings::where([
                            'account_id'=>$thisaccount,
                            'source'=>'direct_referral'
                        ])->sum('amount');
			$countMB = Earnings::where([
                            'account_id'=>$thisaccount,
                            'source'=>'pairing'
                        ])->sum('amount');
			$countLPV = Earnings::where([
                            'account_id'=>$thisaccount,
                            'source'=>'left_pv'
                        ])->sum('amount');
			$countRPV = Earnings::where([
                            'account_id'=>$thisaccount,
                            'source'=>'right_pv'
                        ])->sum('amount');

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

        return view( $this->viewpath . 'index' )
            ->with([
                'binaryTree'=>$binary->setLevelOneAccount($level1Account)->renderTree(),
                'viewed'=>session('recorded_viewing'),
                'listedUser'=>$listedUser,
                'currentUser'=>$currentUser,
                'downlinesArray'=>$downlinesArray,
				'countDR'=>$countDR,
				'countMB'=>$countMB,
				'countLPV'=>$countLPV,
				'countRPV'=>$countRPV,
                'availableSlots' => $availableSlots
            ]);

    }

}