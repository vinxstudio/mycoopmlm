@extends('layouts.master')
@section('content')
	<?php

		$from = (!empty($date_from))? strtotime($date_from):'0';
		$to = (!empty($date_to))? strtotime($date_to):'0';

		$new_from_date = date("F d, Y", strtotime($date_from));
		$new_to_date = date("F d, Y", strtotime($date_to));


		$total_DR = 0;
		$total_MB = 0;
		$total_GC = 0;
		$total_GI = 0;
		$total_NI = 0;
		$total_admin_fee = 0;
		$total_cd_account = 0;

	?>
	<div class='col-md-12'>
		<div class="row">
			<div class="col-md-4">
				<h2>Weekly Payout History</h2>
				<h4>From : {{ $new_from_date }} To : {{ $new_to_date }} </h4> 
			</div>
			<div class="col-md-4 col-md-offset-4">
				<h4>Overall Total Gross Income: {{ number_format($overall_total_GI, 2) }}</h4>
				<h4>Overall Total Net Income: {{ number_format($overall_total_NI, 2) }}</h4>
			</div>
		</div>
	</div>
	<div class="row form-group">
		<div class="col-md-8">
			{{ Form::open(['class'=>'form-inline']) }}
				<div style="margin-top: 40px;">
					<div class="form-group">
						<label for="date">Weekly Income</label>
						<?php $selected = $date_from.'_'.$date_to; ?>
						{{ 
						  Form::select('date',$date_range, $selected, [
									  'class'=>'form-control'] ) 
						}}
					</div>
					<div class="form-group">
						<label for="search">Search User</label>
						<input type="text" name="search" class="form-control">
					</div>
					<button type="submit" class="btn btn-success"> Submit </button>
				</div>
			{{ Form::close() }}
		</div>
		<div class="col-md-4">
			 <div class="form-group" style="margin-top: 40px;">
				<?php
					$date_from = (!empty($date_from))? $date_from:'0';
					$date_to = (!empty($date_to))? $date_to:'0';
				?>
				<a class="btn btn-success pull-right" href="{{ url('admin/export-weekly-payout-history/xlsx/'.$date_from.'/'.$date_to) }}"><i class="fas fa-download"></i> Download Weekly Payout History</a>
	        </div>
		</div>
	</div>
    <table id='weekly_payout' class="dataTable1 table table-bordered table-hover table-striped">
        <thead>
			<th>Member Account Details</th>
			<th>Total Earnings</th>
			<th>Direct Referral</th>
			<th>Matching Bonus</th>
			<th>GC</th> 
			<th>Gross Income</th>
			<th>10% Admin Fee</th>
			<th>50% CD Acc. Bal.</th>
			<th>Net Income</th>
			<th>Status</th> 
			<th>Action</th> 
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
						$total_cd_account += $payout->cd_account_fee;

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
						<td>
							{{'Fullname: '.$payout->full_name.' ('.$payout->package_type.')'}}<br>
							{{'Account ID: '.$payout->account_id}}<br>
							{{'Username: '.$payout->username}}
						</td>
						<td>{{number_format($payout->total_earnings, 2)}}</td>
						<td>{{number_format($payout->direct_referral, 2)}}</td>
						<td>{{number_format($payout->matching_bonus, 2)}}</td>
						<td>{{$payout->gift_check}}</td>
						<td>{{number_format($payout->gross_income, 2)}}</td>
						<td>{{number_format($payout->admin_fee, 2)}}</td>
						<td>{{number_format($payout->cd_account_fee, 2)}}</td>
						<td>{{number_format($payout->net_income, 2)}}</td>
						<td class="{{$color}}">{{ ucfirst($payout->status)}}</td>
						<td>
							<button class="btn btn-success btn-sm btn-approve-decline form-control"
								data-groupId ={{$payout->group_id}} 
								data-id={{ $payout->user_id}}
								data-grossAmount={{$payout->gross_income}}
								data-adminFee={{$payout->admin_fee}}
								data-cdFee={{$payout->cd_account_fee}}
								data-netAmount={{$payout->net_income}}
								data-from={{$payout->date_from}}
								data-to={{$payout->date_to}}
								data-status='approved'
								{{$prop}}
								{{-- send to know whos button is this --}}
								data-who='approved'
								>
								APPROVE
							</button>
							<button @if($payout->status == 'declined') disabled @endif
								 class="btn btn-danger btn-sm btn-approve-decline form-control"
								data-id={{ $payout->user_id }} 
								data-netAmount={{$payout->net_income}} 
								data-from={{$payout->date_from}} 
								data-to={{$payout->date_to}} 
								data-status='declined' 
								data-who='declined'>DECLINE</button>
						</td>
						
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
	@if($weekly_payouts instanceof \Illuminate\Pagination\AbstractPaginator)

	{{$weekly_payouts->render()}}

	@endif
    @include('Admin.PayoutHistory.views.validate-scripts')
@stop