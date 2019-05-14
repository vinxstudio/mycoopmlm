@extends('layouts.members')
@section('content')
	<?php
		$color = '';
	?>
	<div class='col-md-12'>
		<div class="row">
			<div class="col-md-12">
                <h2>Income/Encashment Summary</h2>
                <h4>Starting Date: September 01, 2018</h4>
			</div>
		</div>
	</div>
    <table id='weekly_payout' class="dataTable1 table table-bordered table-hover table-striped">
        <thead>
			<th>Username</th>
			<th>Transaction Date</th>
			<th>Particular</th>
			<th>Gross Income</th>
			<th>10% Admin Fee</th>
			<th>50% CD Acct. Bal.</th>
			<th>Net Income (CREDIT)</th>
			<th>Adjustment (DEBIT/CREDIT)</th>
			<th>Amount Withdrawn (DEBIT)</th>
            <th>Balance</th>
        </thead>
        <tbody>
			@if(!empty($summaries))
				@foreach ($summaries as $summary)
					<?php
						if($summary->particular == 'Income For The Period' || $summary->particular == 'Forwarded Balance')
						{
							$color = 'text-success';
						}
						else if($summary->particular == 'Cancel Withdrawal')
						{
							$color = 'text-success';
						}
						else
						{
							$color = 'text-danger';
						}
					?>
					<tr>
						<td>{{$summary->username.'('.$summary->package_type.')'}}</td>
						<td>{{$summary->created_at}}</td>
						<td class="{{$color}}">{{$summary->particular}}</td>
						<td>{{number_format($summary->gross_income, 2)}}</td>
						<td>{{number_format($summary->admin_fee, 2)}}</td>
						<td>{{number_format($summary->cd_account_fee, 2)}}</td>
						<td class="{{$color}}">{{number_format($summary->net_income, 2)}}</td>
						<td class="{{$color}}">{{number_format($summary->adjustment, 2)}}</td>
						<td class="{{$color}}">{{number_format($summary->amount_withdrawn, 2)}}</td>
						<td>{{number_format($summary->balance, 2)}}</td>
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
	</table>
	{{ $summaries->render() }}

@stop