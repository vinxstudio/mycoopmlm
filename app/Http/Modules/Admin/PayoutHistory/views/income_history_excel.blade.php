<?php
use App\Models\Earnings;
use App\Models\User;
set_time_limit(3000);
?>
<?php 

	$earnings = $earningexcel['payments'];
	$date_from = $earningexcel['date_from'];
	$date_to = $earningexcel['date_to'];

	$direct_referral = $earningexcel['direct_referral'];
	$matching_bonus = $earningexcel['matching_bonus'];
	$gift_check = $earningexcel['gift_check'];
	$gross_income = $earningexcel['gross_income'];
	$cd_account_fee = $earningexcel['total_cd_account_fee'];
	$admin_fee = $earningexcel['total_admin_fee'];
	$net_income = $earningexcel['net_income'];

	$start_date = date("M d, Y", strtotime($date_from));
	$end_date = date("M d, Y", strtotime($date_to));
			
	$total_earnings = 0;
	$total_DR = 0;
	$total_MB = 0;
	$total_GC = 0;
	$total_GI = 0;
	$total_NI = 0;
	$total_admin_fee = 0;
	$total_cd_account = 0;
?>
<table>
	<tr>
		<th colspan="5">Weekly Payout History ({{$start_date}} - {{$end_date}} )</th>
	</tr>
	<tr></tr>
	<tr>
		<th>Total Direct Referral: {{ number_format($direct_referral, 2)}}</th>
	</tr>
	<tr>
		<th>Total Matching Bonus: {{ number_format($matching_bonus, 2)}}</th>
	</tr>
	<tr>
		<th>Total Gift Check: {{$gift_check}}</th>
	</tr>
	<tr>
		<th>Total Gross Income: {{ number_format($gross_income, 2)}}</th>
	</tr>
	<tr>
		<th>Total Admin Fee: {{ number_format($admin_fee, 2)}}</th>
	</tr>
	<tr>
		<th>Total CD Account Fee: {{ number_format($cd_account_fee, 2)}}</th>
	</tr>
	<tr>
		<th>Total Net Income: {{ number_format($net_income, 2)}}</th>
	</tr>
	<tr></tr>
    <tr>
		<th>Full Name & Package Type</th>
		<th>Account ID.</th>
		<th>User Name</th>
		<th>Total Earnings</th>
		<th>Direct Referral</th>
		<th>Matching Bonus</th>
		<th>GC</th> 
		<th>Gross Income</th>
		<th>10% Admin Fee</th>
		<th>50% CD Acc. Bal.</th>
		<th>Net Income</th>
		<th>Status</th> 
    </tr>
    <tbody>
		@if(!empty($earnings))
			@foreach ($earnings as $payout)
				<?php
					$total_DR += $payout->direct_referral;
					$total_MB += $payout->matching_bonus;
					$total_GC += $payout->gift_check;
					$total_GI += $payout->gross_income;
					$total_NI += $payout->net_income;
					$total_admin_fee += $payout->admin_fee;
					$total_cd_account += $payout->cd_account_fee;
				?>
				<tr>
					<td>{{$payout->full_name.' ('.$payout->package_type.')'}}</td>
					<td>{{$payout->account_id}}</td>
					<td>{{$payout->username}}</td>
					<td>{{number_format($payout->total_earnings, 2)}}</td>
					<td>{{number_format($payout->direct_referral, 2)}}</td>
					<td>{{number_format($payout->matching_bonus, 2)}}</td>
					<td>{{$payout->gift_check}}</td>
					<td>{{number_format($payout->gross_income, 2)}}</td>
					<td>{{number_format($payout->admin_fee, 2)}}</td>
					<td>{{number_format($payout->cd_account_fee, 2)}}</td>
					<td>{{number_format($payout->net_income, 2)}}</td>
					<td>{{ ucfirst($payout->status)}}</td>
				</tr>	
			@endforeach
		@else
		<tr>
			<td colspan="7">
				<center>
					<i>No Weekly Payout</i>
				</center>
			</td>
		</tr>
		@endif
	</tbody>
	<tfoot>
		<tr class="strong">
			<td colspan="2">Total</td>
			<td>{{ number_format($total_DR, 2) }}</td>
			<td>{{ number_format($total_MB, 2) }}</td>
			<td>{{ number_format($total_GC, 2) }}</td>
			<td>{{ number_format($total_GI, 2) }}</td>
			<td>{{ number_format($total_admin_fee, 2) }}</td>
			<td>{{ number_format($total_cd_account, 2) }}</td>
			<td>{{ number_format($total_NI, 2) }}</td>
			<td></td>
			<td></td>
		</tr>
	</tfoot>
</table>
