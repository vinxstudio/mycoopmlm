@extends('layouts.members')
@section('content')
	<?php

		$total_DR = 0;
		$total_MB = 0;
		$total_GC = 0;
		$total_GI = 0;
		$total_NI = 0;
		$total_admin_fee = 0;
		$total_cd_fee = 0;

	?>
	<div class='col-md-12'>
		<div class="row">
			<div class="col-md-4">
                <h2>Weekly Payout History</h2>
				<!-- <h4>Starting Date: August 11, 2018 - August 18, 2018</h4> -->
				<h4>Starting Date: {{ date('F d, Y', strtotime($start_at)) }} - {{ date('F d, Y', time()) }}</h4>
			</div>
			<div class="col-md-4 col-md-offset-4">
				<h4>Overall Total Gross Income: {{ number_format($overall_total_GI, 2) }}</h4>
				<h4>Overall Total Net Income: {{ number_format($overall_total_NI, 2) }}</h4>
			</div>
		</div>
	</div>
    <table id='weekly_payout' class="dataTable1 table table-bordered table-hover table-striped">
        <thead>
			<th>Username</th>
			<th>Direct Referral</th>
			<th>Matching Bonus</th>
			<th>GC</th> 
			<th>Gross Income</th>
			<th>10% Admin Fee</th>
			<th>50% CD Acct. Bal.</th>
			<th>Net Income</th>
			<th>Status</th>
			<th>Reason</th>
            <th>Date From</th>
            <th>Date To</th>
        </thead>
        <tbody>
			@if(!empty($weekly_payouts))
				@foreach ($weekly_payouts as $payout)
					<?php
						$total_DR += $payout->direct_referral;
						$total_MB += $payout->matching_bonus;
						$total_GC += $payout->gift_check;
						$total_GI += $payout->gross_income;
						$total_NI += $payout->net_income;
						$total_admin_fee += $payout->admin_fee;
						$total_cd_fee += $payout->cd_account_fee;
						if($payout->status == 'pending')
						{
							$color = 'text-warning';
							$prop = '';
						}
						elseif($payout->status == 'approved')
						{
							$color = 'text-success';
							$prop = 'disabled';
						}
						else
						{
							$color = 'text-danger';
							$prop = '';
						}
					?>
					<tr>
						<td>{{$payout->username.'('.$payout->package_type.')'}}</td>
						<td>{{number_format($payout->direct_referral, 2)}}</td>
						<td>{{number_format($payout->matching_bonus, 2)}}</td>
						<td>{{$payout->gift_check}}</td>
						<td>{{number_format($payout->gross_income, 2)}}</td>
						<td>{{number_format($payout->admin_fee, 2)}}</td>
						<td>{{number_format($payout->cd_account_fee, 2)}}</td>
						<td>{{number_format($payout->net_income, 2)}}</td>
						<td class="{{$color}}">{{ ucfirst($payout->status)}}</td>
						<td>
							<button class="btn btn-warning btn-reason" data-reason="{{ $payout->reason }}">Reason</button>
						</td>
                        <td>{{ $payout->date_from }}</td>
                        <td>{{ $payout->date_to }}</td>
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
                <td>Total</td>
				<td>{{ number_format($total_DR, 2) }}</td>
				<td>{{ number_format($total_MB, 2) }}</td>
				<td>{{ $total_GC }}</td>
				<td>{{ number_format($total_GI, 2) }}</td>
				<td>{{ number_format($total_admin_fee, 2) }}</td>
				<td>{{ number_format($total_cd_fee, 2) }}</td>
                <td>{{ number_format($total_NI, 2) }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
			</tr>
		</tfoot>
	</table>
	@if($weekly_payouts instanceof \Illuminate\Pagination\AbstractPaginator)

	{{$weekly_payouts->render()}}

	@endif


<!-- Modal -->
<div id="withdrawal_reason" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <div id="reason-modal-alert" class="hide alert alert-dismissible show" role="alert">
                    </div>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Reason</h4>
                </div>
                <div class="modal-body">
                    <h4 class="message"></h4>
					<div id="reason_message" class="m-5"></div>
				</div>
                <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">
                        Close
                </button>
            </div>
        </div>
    </div>
</div>



<script>


	$(document).ready(function(){

		var modal_reason = $('#reason_message');
		var modal = $('#withdrawal_reason');

		$('.btn-reason').click(function(e){

			let reason = $(this).attr('data-reason');

			if(reason == '')
				reason = 'N / A';

			modal_reason.text(reason);

			modal.appendTo('body').modal('show');
		});

		$('#withdrawal_reason').on('hidden.bs.modal', function(e){
			modal_reason.empty();

		});

	});

</script>

@stop
