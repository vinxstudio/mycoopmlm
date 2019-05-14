<?php

use App\Models\Accounts;
use App\Models\Earnings;
use App\Models\Membership;
use App\Models\ActivationCodes;
use App\Models\ActivationCodeBatches;
use App\Models\User;
use App\Models\Details;
use App\Models\Branches;
use App\Models\WeeklyApprovedPayout;
set_time_limit(3000);
?>
@extends('layouts.master')
@section('content')
	<?php

		$from = (!empty($date_from))? strtotime($date_from):'0';
		$to = (!empty($date_to))? strtotime($date_to):'0';

		$new_from_date = date("F d, Y", strtotime($date_from));
		$new_to_date = date("F d, Y", strtotime($date_to));

	?>
	<div class='col-md-12'>
		<span>
			<h2>Weekly Payout History</h2>
			<h4>From : {{ $new_from_date }} To : {{ $new_to_date }} </h4> 
		</span>
	</div>
	{{ Form::open(['class'=>'form-horizontal form-bordered']) }}
		<!-- <div>
		    <div class='col-md-3'>
		    	<?php
					$date_from = (!empty($date_from))? $date_from:'0';
					$date_to = (!empty($date_to))? $date_to:'0';
		    	?>
		        <div class="form-group pull-right">
		        	<label>&nbsp;</label>
		            <div class='input-group date'>
		                <a class="btn btn-success pull-right" href="{{ url('admin/export-payout-history/xlsx/all/'.$date_from.'/'.$date_to) }}"><i class="fas fa-download"></i> Download Payout History Reports</a>
		            </div>
		        </div>
		    </div>
		</div> -->
		<div class='col-md-6'>
			<div class="pull-left" style="margin-top: 40px;">
				<div class="pull-left">
					<h5>Weekly Income : &nbsp;</h5>
				</div>
				<div class="pull-left">
					<?php $selected = $date_from.'_'.$date_to; ?>
					{{ 
						Form::select('date_range',$date_range, $selected, [
                        'class'=>'form-control'] ) 
                    }}
				</div>
				<div class="pull-left">
					<span><button type="submit" class="btn btn-success"> Submit </button></span>
				</div>
			</div>
		</div>
		<div class='col-md-6'>
	        <div class="form-group pull-right">
	        	<label>&nbsp;</label>
	            <div class='input-group date'>
	            	<?php
						$date_from = (!empty($date_from))? $date_from:'0';
						$date_to = (!empty($date_to))? $date_to:'0';
			    	?>
	                <a class="btn btn-success pull-right" href="{{ url('admin/export-weekly-payout-history/xlsx/'.$date_from.'/'.$date_to) }}"><i class="fas fa-download"></i> Download Weekly Payout History</a>
	            </div>
	        </div>
		</div>
	{{ Form::close() }}
	
	@if($payments)
    <table class="dataTable1 table table-bordered table-hover table-striped">
        <thead>
            <th>Full Name</th>
			<th>Direct Referral</th>
			<th>Matching Bonus</th>
			<th>GC</th> 
			<th>Total</th> 
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
						<td>{{$payout->full_name.' ('.$payout->package_type.')'}}</td>
						<td>{{number_format($payout->direct_referral, 2)}}</td>
						<td>{{number_format($payout->matching_bonus, 2)}}</td>
						<td>{{$payout->gift_check}}</td>
						<td>{{number_format($payout->gross_income, 2)}}</td>
						<td>{{number_format($payout->net_income, 2)}}</td>
						<td class="{{$color}}">{{ ucfirst($payout->status)}}</td>
						<td>
							<button id="approve_id" class="btn btn-success btn-sm btn-approve form-control" data-id={{ $payout->group_id}} data-amount={{$payout->net_income}} data-from={{$payout->date_from}} data-to={{$payout->date_to}} data-status={{'approved'}} {{$prop}}>APPROVE</button>
							@if($payout->status == 'declined')
								<button class="btn btn-primary btn-sm btn-reason form-control" data-id={{ $payout->group_id }}>REASON</button>
							@else
								
							@endif
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
        </tbody>
    </table>
    {{ $payments->render() }}
    @endif
    @include('Admin.PayoutHistory.views.action-scripts')
@stop