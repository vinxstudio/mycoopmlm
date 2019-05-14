<?php

use App\Models\Accounts;
use App\Models\Earnings;
use App\Models\Membership;
use App\Models\ActivationCodes;
use App\Models\ActivationCodeBatches;
use App\Models\User;
use App\Models\Details;
set_time_limit(3000);
?>

<table>
		<tr>
	        <th>Account ID</th>
	        <th>Full Name</th>
			<th>OR Number</th>
			<th>OR Date</th>
			<th>Teller</th>
			<th>Branch</th>
	        <th>Username</th>
			<th>Package</th>
			<th>Package Amount</th>
			<!-- <th>From Package</th> -->
			<th>Direct Referral</th>
		</tr>

    	<?php 
    		$counter = 0; 
    		// pr($earningexcel); die;
    		$earnings = $earningexcel['payments'];
    		$date_from = $earningexcel['date_from'];
    		$date_to = $earningexcel['date_to'];
    	?>

        @foreach ($earnings as $earning)

        <?php
			$username = User::find($earning->user_id);

			if(empty($username)) continue;

			$acc = Accounts::find($earning->account_id);

			$from_package = (!empty($acc))? Membership::find($acc->from_package): '';

			$activationcode = ActivationCodes::where('user_id',$earning->user_id)->first();
			if(empty($activationcode->batch_id)) continue;
			$activationBatch = ActivationCodeBatches::find($activationcode->batch_id);
				
			$batchname = (!isset ($activationBatch->name)) ? '' : $activationBatch->name;

			$membership = (!empty($username))? Membership::find($username->member_type_id): '';

			$fullname = Details::find($username->user_details_id);

			$date_from = (!empty($date_from))? $date_from : '';
			$date_to = (!empty($date_to))? $date_to : '';

			
			$QDR = Earnings::where('source', 'direct_referral')
							->where('user_id',$earning->user_id);

				if(!empty($date_from)){
					$QDR->where('earnings.earned_date', '>=', $date_from);
				}

				if(!empty($date_to)){
					$QDR->where('earnings.earned_date', '<=', $date_to);
				}

			$DRamount = $QDR->sum('amount');
			
			
			if(!empty($membership) && $membership->entry_fee < 0) {
				$total = $DRamount;
				$GC = 0;
			} else {
				$total = $DRamount;
			}
			
			
			$created_at = $earning->created_at;
		
			$payout[] = [
				'accountid' => $activationcode->account_id,
				'ornum' => $activationcode->or_number,
				'ordate' => ($activationcode->or_number)?$activationcode->created_at:'',
				'teller' => 'teller',
				'branch' => 'Cebu People`s Multi-Purpose Cooperative',
				'username' => $username->username,
				'fullname' => $fullname->first_name.' '.$fullname->last_name,
				'package' => (!empty($membership))? $membership->membership_type_name:'',
				'amount' => (!empty($membership))? $membership->entry_fee:'',
				'from_package'=>(!empty($from_package))?$from_package->membership_type_name:'',
				'dr' => $DRamount,
				'acc_id'=>$earning->account_id,
				'user_id'=>$earning->user_id
				];
  			?>
            <tr>
				<td>{{$payout[$counter]['accountid']}}</td>
				<td>{{$payout[$counter]['fullname']}}</td>
				<td>{{$payout[$counter]['ornum']}}</td>
				<td>{{$payout[$counter]['ordate']}}</td>
				<td>{{$payout[$counter]['teller']}}</td>
				<td>{{$payout[$counter]['branch']}}</td>
				<td>{{$payout[$counter]['username']}}</td>
				<td>{{$payout[$counter]['package']}}</td>
				<td>{{$payout[$counter]['amount']}}</td>
				<!-- <td>{{$payout[$counter]['from_package']}}</td> -->
                <td>{{$payout[$counter]['dr']}}</td>
            </tr>
            <?php $counter ++; ?>
        @endforeach
    </tbody>
</table>
    
