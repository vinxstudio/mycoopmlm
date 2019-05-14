<?php

use App\Models\Accounts;
use App\Models\Earnings;
use App\Models\Membership;
use App\Models\ActivationCodes;
use App\Models\ActivationCodeBatches;
use App\Models\User;
use App\Models\Details;
use App\Models\Branches;
set_time_limit(30000);

$counter = 0; 
// pr($earningexcel); die;
$earnings = $earningexcel['payments'];
$date_from = $earningexcel['date_from'];
$date_to = $earningexcel['date_to'];

$start_date = date("M d, Y", strtotime($date_from));
$end_date = date("M d, Y", strtotime($date_to));

$total_earnings = 0;

?>

<table>
	<tr>
		<th colspan="19" style="text-align: center;">Income History ({{$start_date}} - {{$end_date}} )</th>
	</tr>
    <tr>
	    <th>Batch ID</th>
		<th>Account Code</th>
        <th>Account ID</th>
		<th>OR Number</th>
		<th>OR Date</th>
		<th>Teller</th>
		<th>Branch</th>
        <th>Username</th>
        <th>Full Name</th>
		<th>Package</th>
		<th>Package Amount</th>
		<th>Upgraded ON</th>
		<th>From Package</th>
		<th>Direct Referral</th>
		<th>Matching Bonus</th>
		<th>Gross Payout </th>
		<th>Net Payout</th>
		<th>Remaining Balance</th>
		<th>GC</th> 
    </tr>

        @foreach ($earnings as $earning)

        <?php
			$username = User::find($earning->user_id);

			if(empty($username)) continue;

			$acc = Accounts::find($earning->account_id);

			$from_package = (!empty($acc))? Membership::find($acc->from_package): '';

			$activationcode = ActivationCodes::where('user_id',$earning->user_id)->first();
			if(empty($activationcode->batch_id)) continue;
			if($activationcode->teller_id){
				// get teller
				$teller  = User::find($activationcode->teller_id);
				// $teller_details  = Details::find($teller->user_details_id);
				$branches  = Branches::find($teller->branch_id);
                if(!empty($branches->name)){
                    $t_name = explode(' - ',$branches->name);
                    $tname = $t_name[1];
                    $branch = $branches->name;
                }else{
                    $tname = 'Head Office';
                    $branch = "Cebu People's Coop Head Office";
                }
			}else{
				$tname = 'Head Office';
                $branch = "Cebu People's Coop Head Office";
			}
				
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


			$QMB = Earnings::where('source', 'pairing')
							->where('user_id',$earning->user_id);

				if(!empty($date_from)){
					$QMB->where('earnings.earned_date', '>=', $date_from);
				}

				if(!empty($date_to)){
					$QMB->where('earnings.earned_date', '<=', $date_to);
				}

			$MBAmount =	$QMB->sum('amount'); 


			$QDC = Earnings::where('source', 'GC')
							->where('user_id',$earning->user_id);

				if(!empty($date_from)){
					$QDC->where('earnings.earned_date', '>=', $date_from);
				}

				if(!empty($date_to)){
					$QDC->where('earnings.earned_date', '<=', $date_to);
				}
			$GC = $QDC->sum('amount');

			if(!empty($membership) && $membership->entry_fee < 0) {
				$total = $DRamount + $MBAmount;
				$GC = 0;
			} else {
				$total = $DRamount + $MBAmount;
			}
			
			$created_at = $earning->created_at;
			if (!empty($membership) &&  $membership->entry_fee < 0) {
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
				'teller' => $tname,
				'branch' => $branch,
				'username' => $username->username,
				'fullname' => $fullname->first_name.' '.$fullname->last_name,
				'package' => (!empty($membership))? $membership->membership_type_name:'',
				'amount' => (!empty($membership))? $membership->entry_fee:'',
				'upgraded_on'=>$acc->upgraded_on,
				'from_package'=>(!empty($from_package))?$from_package->membership_type_name:'',
				'dr' => $DRamount,
				'mb' => $MBAmount,
				'total' => $total,
				'totalpayout' => $totalpayout,
				'rb' => $rb,
				'GC' => $GC,
				'acc_id'=>$earning->account_id,
				'user_id'=>$earning->user_id
				];
  			?>
            <tr>
			    <td>{{$payout[$counter]['batchid']}}</td>
				<td>{{$payout[$counter]['code']}}</td>
				<td>{{$payout[$counter]['accountid']}}</td>
				<td>{{$payout[$counter]['ornum']}}</td>
				<td>{{$payout[$counter]['ordate']}}</td>
				<td>{{$payout[$counter]['teller']}}</td>
				<td>{{$payout[$counter]['branch']}}</td>
				<td>{{$payout[$counter]['username']}}</td>
                <td>{{$payout[$counter]['fullname']}}</td>
				<td>{{$payout[$counter]['package']}}</td>
				<td>{{$payout[$counter]['amount']}}</td>
				<td>{{$payout[$counter]['upgraded_on']}}</td>
				<td>{{$payout[$counter]['from_package']}}</td>
                <td> {{$payout[$counter]['dr']}} </td>
				<td> {{$payout[$counter]['mb']}} </td>	
                <td>{{ $payout[$counter]['total'] }}</td>
				<td>{{ $payout[$counter]['totalpayout'] }}</td>
				 <td>{{ $payout[$counter]['rb'] }}</td>
				<td>{{ $payout[$counter]['GC'] }}</td>
            </tr>
            <?php $counter ++; ?>
        @endforeach
</table>
