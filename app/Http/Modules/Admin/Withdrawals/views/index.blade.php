@extends('layouts.master')
@section('content')

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
		        <div class="form-group pull-right">
		        	<label>&nbsp;</label>
		            <div class='input-group date'>
		            	<?php
							$date_from = (!empty($date_from))? $date_from:'0';
							$date_to = (!empty($date_to))? $date_to:'0';
				    	?>
		                <a class="btn btn-success pull-right" href="{{ url('admin/export-request-withdrawal/xlsx/'.$date_from.'/'.$date_to) }}"><i class="fas fa-download"></i> Download Request Withdrawals History Reports</a>
		            </div>
		        </div>
		    </div>
		</div>
	{{ Form::close() }}

	{{ view('widgets.withdrawals.table_widget')
     ->with([
        'withdrawals'=>$withdrawals
     ])->render() }}

    <center>{{ $withdrawals->render() }}</center>

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