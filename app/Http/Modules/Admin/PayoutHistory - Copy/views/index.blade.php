@extends('layouts.master')
@section('content')

	{{ Form::open(['class'=>'form-horizontal form-bordered']) }}
		<div class="container">
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
		</div>
	{{ Form::close() }}
	<?php

		$from = (!empty($date_from))? strtotime($date_from):'0';
		$to = (!empty($date_to))? strtotime($date_to):'0';
	?>
    <table class="dataTable5 table table-bordered table-hover table-striped" style="font-size:8px;">
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
            @foreach ($payments as $payout)
                <tr>
				    <td>{{$payout['batchid']}}</td>
					<td>{{$payout['code']}}</td>
					<td>{{$payout['accountid']}}</td>
					<td>{{$payout['ornum']}}</td>
					<td>{{$payout['ordate']}}</td>
					<td>{{$payout['teller']}}</td>
					<td>{{$payout['branch']}}</td>
					<td>{{$payout['username']}}</td>
                    <td>{{$payout['fullname']}}</td>
					<td>{{$payout['package']}}</td>
					<td>{{$payout['amount']}}</td>
					<td>{{$payout['upgraded_on']}}</td>
					<td>{{$payout['from_package']}}</td>
                    <td>
                    	@if( $payout['dr'] != 0 )
                    		<a href="direct-referral/{{$payout['acc_id']}}/{{$from}}/{{$to}}">{{$payout['dr']}}</a>
                    	@else
                    		{{$payout['dr']}}
                    	@endif
                    </td>
					<td>
						@if($payout['mb'] != 0)
                    		<a href="matching-bonus/{{$payout['acc_id']}}/{{$from}}/{{$to}}">{{$payout['mb']}}</a>
                    	@else
                    		{{$payout['mb']}}
                    	@endif
					</td>	
                    <td>{{ $payout['total'] }}</td>
					<td>{{ $payout['totalpayout'] }}</td>
					 <td>{{ $payout['rb'] }}</td>
					<td>{{ $payout['GC'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
		{{ $earnings->render() }}
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