<?php

use App\Models\Accounts;
use App\Models\Earnings;
use App\Models\Membership;
use App\Models\ActivationCodes;
use App\Models\ActivationCodeBatches;
use App\Models\User;
use App\Models\Details;
use App\Models\Branches;
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
			<h2>Income History</h2>
			@if(!empty($from) && !empty($to))
			<h4>From : {{ $new_from_date }} To : {{ $new_to_date }} </h4>
			@endif 
		</span>
	</div>
	{{ Form::open(['class'=>'form-horizontal form-bordered']) }}
		<div>
		    <div class='col-md-3'>
		        <div class="form-group">
		        	<label>Date From</label>
		            <div class='input-group date' id='from_date'>
		                <input type='text' name="date_from" class="form-control" value="{{ $date_from }}"/>
		                <span class="input-group-addon">
		                    <span class="glyphicon glyphicon-calendar"></span>
		                </span>
		            </div>
		        </div>
		    </div>
		    <div class='col-md-3'>
		        <div class="form-group">
		        	<label>Date To</label>
		            <div class='input-group date' id='to_date'>
		                <input type='text' name="date_to" class="form-control" value="{{ $date_to }}" />
		                <span class="input-group-addon">
		                    <span class="glyphicon glyphicon-calendar"></span>
		                </span>
		            </div>
		        </div>
		    </div>
		    <div class='col-md-3'>
		        <div class="form-group">
		        	<label>&nbsp;</label>
		            <div class='input-group date'>
		                <input type='submit' class="form-control btn btn-primary" value="SUBMIT"  />
		            </div>
		        </div>
		    </div>
		    <div class='col-md-3'>
		    	<?php
					$date_from = (!empty($date_from))? $date_from:'0';
					$date_to = (!empty($date_to))? $date_to:'0';
		    	?>
		        <div class="form-group pull-right">
		        	<label>&nbsp;</label>
		            <div class='input-group date'>
		                <a class="btn btn-success pull-right" href="{{ url('admin/export-payout-history/xlsx/all/'.$date_from.'/'.$date_to) }}"><i class="fas fa-download"></i> Download Income History Reports</a>
		            </div>
		        </div>
		    </div>
		</div>
	{{ Form::close() }}
		
	@if($payments)
	<?php 
		$total_net = 0;
		$total_gross = 0; 
	?>
    <table class="dataTable1 table table-bordered table-hover table-striped" style="font-size:8px;">
        <thead>
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
        </thead>
        <tbody>
        	<?php 
        		$counter = 0; 
        	?>
            @foreach ($payments as $earning)

            <?php
				$username = User::find($earning->user_id);

				if(empty($username)) continue;

				$acc = Accounts::find($earning->account_id);

				$from_package = (!empty($acc))? Membership::find($acc->from_package): '';

				$activationcode = ActivationCodes::where('user_id',$earning->user_id)->first();

				if(empty($activationcode->batch_id)) continue;

				if($activationcode->teller_id){
					// get teller
					// $teller  = User::find($activationcode->teller_id);
					// // $teller_details  = Details::find($teller->user_details_id);
					// $branches  = Branches::find($teller->branch_id);
	                // if($branches->name){
	                //     $t_name = explode(' - ',$branches->name);
	                //     $tname = $t_name[1];
	                //     $branch = $branches->name;
	                // }else{
	                //     $tname = 'Head Office';
	                //     $branch = "Cebu People's Coop Head Office";
					// }
					$tname = 'Head Office';
	                $branch = "Cebu People's Coop Head Office";
					
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
						$QDR->where('earnings.created_at', '>=', $date_from);
					}

					if(!empty($date_to)){
						$QDR->where('earnings.created_at', '<=', $date_to);
					}

				$DRamount = $QDR->sum('amount');


				$QMB = Earnings::where('source', 'pairing')
								->where('user_id',$earning->user_id);

					if(!empty($date_from)){
						$QMB->where('earnings.created_at', '>=', $date_from);
					}

					if(!empty($date_to)){
						$QMB->where('earnings.created_at', '<=', $date_to);
					}

				$MBAmount =	$QMB->sum('amount'); 


				$QDC = Earnings::where('source', 'GC')
								->where('user_id',$earning->user_id);

					if(!empty($date_from)){
						$QDC->where('earnings.created_at', '>=', $date_from);
					}

					if(!empty($date_to)){
						$QDC->where('earnings.created_at', '<=', $date_to);
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

				$total_gross = $total_gross + $total;

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
                    <td>
                    	@if( $payout[$counter]['dr'] != 0 )
                    		<a href="/admin/direct-referral/{{$payout[$counter]['acc_id']}}/{{$from}}/{{$to}}">{{$payout[$counter]['dr']}}</a>
                    	@else
                    		{{$payout[$counter]['dr']}}
                    	@endif
                    </td>
					<td>
						@if($payout[$counter]['mb'] != 0)
                    		<a href="/admin/matching-bonus/{{$payout[$counter]['acc_id']}}/{{$from}}/{{$to}}">{{$payout[$counter]['mb']}}</a>
                    	@else
                    		{{$payout[$counter]['mb']}}
                    	@endif
					</td>	
                    <td>{{ $payout[$counter]['total'] }}</td>
					<td>{{ $payout[$counter]['totalpayout'] }}</td>
					 <td>{{ $payout[$counter]['rb'] }}</td>
					<td>{{ $payout[$counter]['GC'] }}</td>
                </tr>
                <?php $counter ++; ?>
            @endforeach
            <tr>
            	<th colspan="15" class="text-right">Over All Total</th>
            	<th>{{ number_format($total_earnings,2) }}</td>
            	<td></td>
            	<td></td>
            	<td></td>
            </tr>
        </tbody>
    </table>
    {{ $payments->render() }}
    @endif
    <script type="text/javascript">

		$(function() {
		    $( "#from_date" ).datetimepicker({
		    	 format:'YYYY-MM-DD 00:00:01',
		    });
		});

		$(function() {
		    $( "#to_date" ).datetimepicker({
		    	format:'YYYY-MM-DD 23:59:59',
		    });
		});
	</script>
@stop