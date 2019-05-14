<?php
namespace App\Models;

class Flushout extends AbstractLayer {

	protected $table = 'flushout';

	public function getFlushout()
    {
        return $this->select('activation_codes.account_id', 'user_details.first_name', 'user_details.last_name', 'flushout.account_id as f_account_id', 'flushout.created_at', \DB::raw('SUM(flushout.amount) as amount'))
                    ->leftJoin('accounts', 'accounts.id', '=', 'flushout.account_id')
                    ->leftJoin('activation_codes', 'activation_codes.user_id', '=', 'accounts.user_id')
                    ->leftJoin('users', 'users.id', '=', 'accounts.user_id')
                    ->leftJoin('user_details', 'user_details.id', '=', 'users.user_details_id')
                    ->groupBy('flushout.account_id')
                    ->orderBy('amount', 'Desc')
                    ->whereIn('source', ['pairing']);
    }

    // function getFlushoutDetails($id, $date_from, $date_to)
    // {
    //     // return $this->select('activation_codes.account_id', 'user_details.first_name', 'user_details.last_name', 'earnings.created_at', \DB::raw('SUM(earnings.amount) as amount'))
    //     //             ->leftJoin('accounts', 'accounts.id', '=', 'earnings.account_id')
    //     //             ->leftJoin('activation_codes', 'activation_codes.id', '=', 'accounts.code_id')
    //     //             ->leftJoin('users', 'users.id', '=', 'accounts.user_id')
    //     //             ->leftJoin('user_details', 'user_details.id', '=', 'users.user_details_id')
    //     //             ->orderBy('amount', 'ASC')
    //     //             ->whereIn('source', ['flushout'])
    //     //             ->where('earnings.user_id', $user_id);
    //     $flushout =  $this->where('account_id', $id)
    //                 ->whereIn('source', ['GC', 'pairing'])
    //                 ->orderBy('earned_date', 'DESC');
            

    //     if(!empty($date_from)) $flushout->where('earned_date', '>=', $date_from);
    //     if(!empty($date_to)) $flushout->where('earned_date', '<=', $date_to);
                   
    //     $details = $flushout->get();
                    
    //     foreach($details as $detail)
    //     {   
            
    //         $l_account = Accounts::find($detail->left_user_id);
    // 		$l_user = User::find($l_account->user_id);
    // 		$l_user_details = Details::find($l_user->user_details_id);
    // 		$l_membership = Membership::find($l_user->member_type_id);
    // 		$l_activationcode = ActivationCodes::where('user_id',$l_user->id)->first();
		

    // 		$r_account = Accounts::find($detail->right_user_id);
    // 		$r_user = User::find($r_account->user_id);
    // 		$r_user_details = Details::find($r_user->user_details_id);
    // 		$r_membership = Membership::find($r_user->member_type_id);
    // 		$r_activationcode = ActivationCodes::where('user_id',$r_user->id)->first();

    // 		$payout[] = [
	// 			'left_account_id' => $l_activationcode->account_id,
	// 			'left_name' => $l_user_details->first_name.' '.$l_user_details->last_name,
	// 			'left_package' => $l_membership->membership_type_name,
	// 			'left_account_date' => $l_account->created_at,

	// 			'right_account_id' => (!empty($r_activationcode))?$r_activationcode->account_id:'',
	// 			'right_name' => $r_user_details->first_name.' '.$r_user_details->last_name,
	// 			'right_package' => $r_membership->membership_type_name,
    //             'right_account_date' =>$r_account->created_at,
                
    //             'source' => $detail->source,
	// 			'mb' => ($detail->amount == 1)? 0 : $detail->amount,
	// 			'date' => $detail->earned_date,
				
	// 			];
    //     }
      
    //     return $payout;
    // }

    // function getFlushoutTotalAmount($id, $date_from, $date_to)
    // {
    //     $flushout =  $this->where('account_id', $id)
    //                 ->where('source', 'pairing');

    //     if(!empty($date_from)) $flushout->where('earned_date', '>=', $date_from);
    //     if(!empty($date_to)) $flushout->where('earned_date', '<=', $date_to);
                   
    //     $details = $flushout->sum('amount');

    //     return $details;
    // }

}

?>