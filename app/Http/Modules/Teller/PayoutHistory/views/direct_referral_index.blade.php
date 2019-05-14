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
@extends('layouts.master')
@section('content')
	<?php

		$from = (!empty($date_from))? strtotime($date_from):'0';
		$to = (!empty($date_to))? strtotime($date_to):'0';
	?>

	<label><h1>Direct Referral Report</h1></label>
	{{ Form::open(['class'=>'form-horizontal form-bordered']) }}
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
	        <div class="form-group pull-right">
	        	<label>&nbsp;</label>
	            <div class='input-group date'>
	                <a class="btn btn-success pull-right" href="{{ url('admin/export-payout-history/xlsx/DR/'.$date_from.'/'.$date_to) }}"><i class="fas fa-download"></i> Download Direct Referral Reports</a>
	            </div>
	        </div>
	    </div>
	    
	{{ Form::close() }}
	
	@if($payments)
    <table class="dataTable table table-bordered table-hover table-striped" style="font-size:8px;">
        <thead>
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
        </thead>
        <tbody>
        	<?php $counter = 0; ?>
            @foreach ($payments as $earning)

            <?php
				$username = User::find($earning->user_id);

				if(empty($username)) continue;

				$acc = Accounts::find($earning->account_id);

				// $from_acc = Accounts::find($earning->left_user_id);
				// $from_user = User::find($from_acc->user_id);
				// $from_package = Membership::find($from_user->membership_type_id);
				
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
    @endif
    <script type="text/javascript">

		$(function() {
		    $( "#from_date" ).datetimepicker({
		    	 format:'YYYY-MM-DD 00:01:00',
		    });
		});

		$(function() {
		    $( "#to_date" ).datetimepicker({
		    	format:'YYYY-MM-DD 23:59:59',
		    });
		});
	</script>
@stop