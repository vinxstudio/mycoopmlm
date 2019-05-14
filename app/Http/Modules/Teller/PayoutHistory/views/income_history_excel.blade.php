<?php

use App\Models\Earnings;
use App\Models\User;
set_time_limit(3000);
?>
<?php 
	$counter = 0; 
	$earnings = $earningexcel['payments'];
	$date_from = $earningexcel['date_from'];
	$date_to = $earningexcel['date_to'];

	$start_date = date("M d, Y", strtotime($date_from));
	$end_date = date("M d, Y", strtotime($date_to));

	$total_earnings = 0;
?>
<table>
	<tr>
		<th colspan="5">Weekly Payout History ({{$start_date}} - {{$end_date}} )</th>
	</tr>
    <tr>
        <th>Full Name</th>
		<th>Direct Referral</th>
		<th>Matching Bonus</th>
		<th>GC</th> 
		<th>Total</th> 
    </tr>
    <tbody>
    	
        @foreach ($earnings as $earning)

        <?php
        	// echo $earning->group_id;
        	$user_group = User::where('group_id',$earning->group_id)->lists('id');
        	// $user_group = User::select('id')->where('group_id',2)->lists('id');

        	$user_group_ids = $user_group;

			$QDR = Earnings::where('source', 'direct_referral')
							->whereIn('user_id',$user_group_ids);

				if(!empty($date_from)){
					$QDR->where('earnings.earned_date', '>=', $date_from);
				}

				if(!empty($date_to)){
					$QDR->where('earnings.earned_date', '<=', $date_to);
				}

			$DRamount = $QDR->sum('amount');


			$QMB = Earnings::where('source', 'pairing')
							->whereIn('user_id',$user_group_ids);

				if(!empty($date_from)){
					$QMB->where('earnings.earned_date', '>=', $date_from);
				}

				if(!empty($date_to)){
					$QMB->where('earnings.earned_date', '<=', $date_to);
				}

			$MBAmount =	$QMB->sum('amount'); 


			$QDC = Earnings::where('source', 'GC')
							->whereIn('user_id',$user_group_ids);

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
				'fullname' => $earning->first_name.' '.$earning->last_name,
				'dr' => $DRamount,
				'mb' => $MBAmount,
				'total' => $total,
				'GC' => $GC,
				'acc_id'=>$earning->account_id,
				'user_id'=>$earning->user_id
				];

			$total_earnings = $total_earnings + $total;
  			?>
            <tr>
                <td>{{$payout[$counter]['fullname']}}</td>
                <td>{{number_format($payout[$counter]['dr'],2)}} </td>
				<td>{{number_format($payout[$counter]['mb'],2)}} </td>	
				<td>{{ $payout[$counter]['GC'] }}</td>
				<td>{{ number_format($payout[$counter]['total'],2) }}</td>
            </tr>
            <?php $counter ++; ?>
        @endforeach
        <tr>
			<td colspan="4">TOTAL</td>
			<td>{{ number_format($total_earnings,2) }}</td>
        </tr>
    </tbody>
</table>
