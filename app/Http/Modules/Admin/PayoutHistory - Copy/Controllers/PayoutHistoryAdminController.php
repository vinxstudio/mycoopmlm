<?php
/**
 * Created by PhpStorm.
 * User: POA
 * Date: 7/13/17
 * Time: 11:26 AM
 */

namespace App\Http\Modules\Admin\PayoutHistory\Controllers;

use App\Http\AbstractHandlers\AdminAbstract;
use App\Models\Accounts;
use App\Models\Earnings;
use App\Models\Membership;
use App\Models\ActivationCodes;
use App\Models\ActivationCodeBatches;
use App\Models\User;
use App\Models\Details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class PayoutHistoryAdminController extends AdminAbstract{

    protected $viewpath = 'Admin.PayoutHistory.views.';

    function __construct(){
        parent::__construct();
    }

    function getIndex(){
        $earnings_pagination = $earnings = Earnings::groupBy('user_id')->paginate(10);
		// $earnings = Earnings::groupBy('user_id')->get();
		$counter = 0;
		if($earnings){
			foreach ($earnings as $earning){
				$username = User::find($earning->user_id);

				$acc = Accounts::find($earning->account_id);

				$from_package = Membership::find($acc->from_package);

				$activationcode = ActivationCodes::where('user_id',$earning->user_id)->first();
				if(empty($activationcode->batch_id)) continue;
				$activationBatch = ActivationCodeBatches::find($activationcode->batch_id);
					
				// print_r($activationcode);
				// die;

				$batchname = (!isset ($activationBatch->name)) ? '' : $activationBatch->name;
				$membership = Membership::find($username->member_type_id);
				$fullname = Details::find($username->user_details_id);
				$DRamount = Earnings::where('source', 'direct_referral')->where('user_id',$earning->user_id)->sum('amount');
				$MBAmount = Earnings::where('source', 'pairing')->where('user_id',$earning->user_id)->sum('amount'); 
				$GC = Earnings::where('source', 'GC')->where('user_id',$earning->user_id)->sum('amount');
				if($membership->entry_fee < 0) {
					$total = $DRamount + $MBAmount;
					$GC = 0;
				} else {
					$total = $DRamount + $MBAmount;
				}
				
				$created_at = $earning->created_at;
				if ($membership->entry_fee < 0) {
					$totalpayout = ($total / 2);
					$rb = $membership->entry_fee + ($total / 2);
					if($rb > 0) {
						$totalpayout = $totalpayout + $rb;
						$rb = 0;	
						
					}
				}  else {
					$totalpayout = $total;
					$rb = 0;
				}
			
				$payout[] = [
					'batchid' => $batchname,
					'code' => $activationcode->code,
					'accountid' => $activationcode->account_id,
					'ornum' => $activationcode->or_number,
					'ordate' => ($activationcode->or_number)?$activationcode->created_at:'',
					'teller' => 'teller',
					'branch' => 'Cebu People`s Multi-Purpose Cooperative',
					'username' => $username->username,
					'fullname' => $fullname->first_name.' '.$fullname->last_name,
					'package' => $membership->membership_type_name,
					'amount' => $membership->entry_fee,
					'upgraded_on'=>$acc->upgraded_on,
					'from_package'=>(!empty($from_package->membership_type_name))?$from_package->membership_type_name:'',
					'dr' => $DRamount,
					'mb' => $MBAmount,
					'total' => $total,
					'totalpayout' => $totalpayout,
					'rb' => $rb,
					'GC' => $GC,
					'acc_id'=>$earning->account_id,
					'user_id'=>$earning->user_id
					];
					$counter++;
		  	}
	  	}
        return view( $this->viewpath . 'index' )
            ->with([
                'payments'=>$payout,
                'earnings'=>$earnings_pagination,
                'date_from'=>'',
                'date_to'=>''
            ]);
    }

    function postIndex( Request $request ){

    	$payout = array();
		$counter = 0;

    	$date_from = (!empty($request->input('date_from')))? $request->input('date_from') : '';
    	$date_to = (!empty($request->input('date_to')))?$request->input('date_to') : '';

		$q = Earnings::groupBy('user_id');

		if(!empty($date_from)){
			$q->where('earnings.earned_date', '>=', $date_from);
		}

		if(!empty($date_to)){
			$q->where('earnings.earned_date', '<=', $date_to);
		}

		$earnings_pagination = $earnings = $q->paginate(100);

		foreach ($earnings as $earning){
			$username = User::find($earning->user_id);
			$acc = Accounts::find($earning->account_id);
			$from_package = Membership::find($acc->from_package);

			$activationcode = ActivationCodes::where('user_id',$earning->user_id)->first();
			$activationBatch = ActivationCodeBatches::find($activationcode->batch_id);
			//echo $activationcode->batch_id;
			$batchname = (!isset ($activationBatch->name)) ? '' : $activationBatch->name;
			$membership = Membership::find($username->member_type_id);
			$fullname = Details::find($username->user_details_id);

			$DR_q = Earnings::where('source', 'direct_referral')
							->where('user_id',$earning->user_id);

					if(!empty($date_from)) $DR_q->where('earnings.earned_date', '>=', $date_from);
					if(!empty($date_to)) $DR_q->where('earnings.earned_date', '<=', $date_to);

			$DRamount = $DR_q->sum('amount');

			$MB_q = Earnings::where('source', 'pairing')
							->where('user_id',$earning->user_id);

					if(!empty($date_from)) $MB_q->where('earnings.earned_date', '>=', $date_from);
					if(!empty($date_to)) $MB_q->where('earnings.earned_date', '<=', $date_to);
					
			$MBAmount = $MB_q->sum('amount'); 

			$GC_q = Earnings::where('source', 'GC')
							->where('user_id',$earning->user_id);

					if(!empty($date_from)) $GC_q->where('earnings.earned_date', '>=', $date_from);
					if(!empty($date_to)) $GC_q->where('earnings.earned_date', '<=', $date_to);

			$GC = $GC_q->sum('amount');

			if($membership->entry_fee < 0) {
				$total = $DRamount + $MBAmount;
				$GC = 0;
			} else {
				$total = $DRamount + $MBAmount;
			}
			
			$created_at = $earning->created_at;
			if ($membership->entry_fee < 0) {
				$totalpayout = ($total / 2);
				$rb = $membership->entry_fee + ($total / 2);
				if($rb > 0) {
					$totalpayout = $totalpayout + $rb;
					$rb = 0;	
					
				}
			}  else {
				$totalpayout = $total;
				$rb = 0;
			}
		
			$payout[] = [
				'batchid' => $batchname,
				'code' => $activationcode->code,
				'accountid' => $activationcode->account_id,
				'ornum' => '',
				'ordate' => '',
				'teller' => 'HQ',
				'branch' => 'HQ',
				'username' => $username->username,
				'fullname' => $fullname->first_name.' '.$fullname->last_name,
				'package' => $membership->membership_type_name,
				'amount' => $membership->entry_fee,
				'upgraded_on'=>$acc->upgraded_on,
				'from_package'=>(!empty($from_package->membership_type_name))?$from_package->membership_type_name:'',
				'dr' => $DRamount,
				'mb' => $MBAmount,
				'total' => $total,
				'totalpayout' => $totalpayout,
				'rb' => $rb,
				'GC' => $GC,
				'acc_id'=>$earning->account_id,
				'user_id'=>$earning->user_id
				];
				$counter++;
	  	}
        return view( $this->viewpath . 'index' )
            ->with([
                'payments'=>$payout,
                'date_from'=>$date_from,
                'date_to'=>$date_to
            ]);
    }

    function getAction($action, $paymentID){
        $actionLabel = ($action == 'approve') ? APPROVED_STATUS : DENIED_STATUS;

        PaymentHistory::where([
            'id'=>$paymentID
        ])->update([
            'status'=>($action == 'approve') ? 'approved' : 'denied'
        ]);

        if ($action == 'approve') {
            $payment = PaymentHistory::find($paymentID);
            $user = User::find($payment->user_id);
            $user->needs_activation = TRUE_STATUS;
            $user->save();
        }

        return redirect('admin/payment-history')->with([
            'success'=>sprintf('%s %s', Lang::get('labels.payment_status_changed'), $actionLabel)
        ]);
    }

    function directReferral($accountid, $from,$to){
		$payout = array();
    	
    	$from = (!empty($from))? date('Y-m-d H:i:s', $from):0;
    	$to = (!empty($to))? date('Y-m-d H:i:s', $to):0;

    	$user_account = Accounts::find($accountid);
    	$user = User::find($user_account->user_id);
		$activationcode = ActivationCodes::where('user_id',$user->id)->first();
		$activationBatch = ActivationCodeBatches::find($activationcode->batch_id);
		//echo $activationcode->batch_id;
		$batchname = (!isset ($activationBatch->name)) ? '' : $activationBatch->name;
		$membership = Membership::find($user->member_type_id);
		$fullname = Details::find($user->user_details_id);


		$DR_q = Earnings::where('source','direct_referral')
					->where('account_id',$accountid);

		if(!empty($from)) $DR_q->whereDate('earnings.earned_date', '>=', $from);
		if(!empty($to)) $DR_q->whereDate('earnings.earned_date', '<=', $to);

		$DRamount = $DR_q->sum('amount'); 

		$user_info = array(
				'batchid' => $batchname,
				'code' => $activationcode->code,
				'accountid' => $activationcode->account_id,
				'username' => $user->username,
				'fullname' => $fullname->first_name.' '.$fullname->last_name,
				'package' => $membership->membership_type_name,
				'total_mb_amount' => ($DRamount)?number_format($DRamount,2): '0.00'
		);

		$q = Earnings::where('source', 'direct_referral')
						->where('account_id',$accountid);

		if(!empty($from)) $q->whereDate('earnings.earned_date', '>=', $from);
		if(!empty($to)) $q->whereDate('earnings.earned_date', '<=', $to);

		$earnings = $q->orderBy('earnings.earned_date','ASC')->get();	

    	foreach ($earnings as $earning) {
			$r_account = Accounts::find($earning->left_user_id);
			$r_user = User::find($r_account->user_id);
			$r_user_details = Details::find($r_user->user_details_id);
			$r_membership = Membership::find($r_user->member_type_id);
			$r_activationcode = ActivationCodes::where('user_id',$r_user->id)->first();

			$payout[] = [
					'account_id' => $r_activationcode->account_id,
					'name' => $r_user_details->first_name.' '.$r_user_details->last_name,
					'package' => $r_membership->membership_type_name,
					'dr' => $earning->amount,
					'date' => $earning->earned_date,
					];
		}	

		return view( $this->viewpath . 'direct_referral' )
            ->with([
                'payments'=>$payout,
                'user_info'=>$user_info
            ]);

    }

    function matchingBonus($accountid, $from, $to){
    	$payout = array();

    	$from = (!empty($from))? date('Y-m-d H:i:s', $from):0;
    	$to = (!empty($to))? date('Y-m-d H:i:s', $to):0;

    	$user_account = Accounts::find($accountid);
    	$user = User::find($user_account->user_id);
		$activationcode = ActivationCodes::where('user_id',$user->id)->first();
		$activationBatch = ActivationCodeBatches::find($activationcode->batch_id);
		//echo $activationcode->batch_id;
		$batchname = (!isset ($activationBatch->name)) ? '' : $activationBatch->name;
		$membership = Membership::find($user->member_type_id);
		$fullname = Details::find($user->user_details_id);

		$MB_q = Earnings::where('source', 'pairing')
					->where('account_id',$accountid);

		if(!empty($from)) $MB_q->whereDate('earnings.earned_date', '>=', $from);
		if(!empty($to)) $MB_q->whereDate('earnings.earned_date', '<=', $to);

		$MBAmount = $MB_q->sum('amount'); 

		$user_info = array(
				'batchid' => $batchname,
				'code' => $activationcode->code,
				'accountid' => $activationcode->account_id,
				'username' => $user->username,
				'fullname' => $fullname->first_name.' '.$fullname->last_name,
				'package' => $membership->membership_type_name,
				'total_mb_amount' => ($MBAmount)?number_format($MBAmount,2): '0.00'
		);

		$q = Earnings::whereIn('source', ['pairing','GC'])
						->where('account_id',$accountid);

		if(!empty($from)) $q->whereDate('earnings.earned_date', '>=', $from);
		if(!empty($to)) $q->whereDate('earnings.earned_date', '<=', $to);

		$earnings = $q->orderBy('earnings.earned_date','ASC')->get();

    	foreach ($earnings as $earning) {
    		$l_account = Accounts::find($earning->left_user_id);
    		$l_user = User::find($l_account->user_id);
    		$l_user_details = Details::find($l_user->user_details_id);
    		$l_membership = Membership::find($l_user->member_type_id);
    		$l_activationcode = ActivationCodes::where('user_id',$l_user->id)->first();
		

    		$r_account = Accounts::find($earning->right_user_id);
    		$r_user = User::find($r_account->user_id);
    		$r_user_details = Details::find($r_user->user_details_id);
    		$r_membership = Membership::find($r_user->member_type_id);
    		$r_activationcode = ActivationCodes::where('user_id',$r_user->id)->first();

    		$payout[] = [
				'left_account_id' => $l_activationcode->account_id,
				'left_name' => $l_user_details->first_name.' '.$l_user_details->last_name,
				'left_package' => $l_membership->membership_type_name,
				'left_account_date' => $l_account->created_at,

				'right_account_id' => $r_activationcode->account_id,
				'right_name' => $r_user_details->first_name.' '.$r_user_details->last_name,
				'right_package' => $r_membership->membership_type_name,
				'right_account_date' =>$r_account->created_at,

				'mb' => ($earning->amount == 1)? 0 : $earning->amount,
				'date' => $earning->earned_date,
				
				];
		}	

		return view( $this->viewpath . 'matching_bonus' )
            ->with([
                'payments'=>$payout,
                'user_info'=>$user_info
            ]);
    }

}