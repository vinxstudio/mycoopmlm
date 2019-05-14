@extends('layouts.members')
@section('content')

	<!-- {{ Form::open(['class'=>'form-horizontal form-bordered']) }}
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
	{{ Form::close() }} -->
	<?php

		$from = (!empty($date_from))? strtotime($date_from):'0';
		$to = (!empty($date_to))? strtotime($date_to):'0';
	?>
    <table class="dataTable table table-bordered table-hover table-striped" style="font-size:8px;">
        <thead>
		    <th>#</th>
			<th>CUTOFF</th>
            <th>CUTOFF</th>
			<th>Gross Income</th>
			<th>Deductions</th>
			<th>Net Income</th>
			<th>Mentainance</th>
            <th>Remarks</th>
        </thead>
        <tbody>
        	<?php $i = 1; ?>
            @foreach ($payments as $payout)
                <tr>
				    <td>{{ $i++ }}</td>
					<td>{{$payout['code']}}</td>
					<td>{{$payout['accountid']}}</td>
					<td>{{$payout['total']}}</td>
					<td> </td>
					<td>{{$payout['totalpayout']}}</td>
					<td> </td>
					<td> </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- <script type="text/javascript">

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
	</script> -->
@stop