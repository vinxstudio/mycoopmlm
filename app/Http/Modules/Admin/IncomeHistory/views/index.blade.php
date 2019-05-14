@extends('layouts.master')
@section('content')
    <?php
        $from = (!empty($date_from))? $date_from:'0';
        $to = (!empty($date_to))? $date_to:'0';
    ?>

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
                    <a class="btn btn-success pull-right" href="{{ url('admin/export-registration-history/xlsx/'.$from.'/'.$to) }}"><i class="fas fa-download"></i> Download Reports</a>
                </div>
            </div>
        </div>
    {{ Form::close() }}
    

    <table class="dataTable table table-bordered table-hover table-striped">
        <thead>
			<th>Batch ID</th>
            <th>Account ID</th>
			<th>Account Code</th>
            <th>Username</th>
            <th>Full Name</th>
            <th>Teller</th>
            <th>Branch</th>
            <th>Package Type</th>
			<th>Entry Fee</th>
            <th>Encoded on</th>
            
        </thead>
        <tbody>
            @foreach ($payments as $payment)
                <?php 
                if($payment->bname){
                    $t_name = explode(' - ',$payment->bname);
                    $name = !empty($t_name[1]) ? $t_name[1] : 'N / A';
                    $branch = $payment->bname;
                }else{
                    $name = 'Head Office';
                    $branch = "Cebu People's Coop Head Office";
                }
                ?>
                <tr>
					<td>{{ $payment->name }}</td>
                    <td>{{ $payment->account_id }}</td>
					<td>{{ $payment->code }}</td>
                    <td>{{ $payment->username }}</td>
                    <td>{{ $payment->first_name }} {{ $payment->last_name }}</td>
                    <td>{{ $name }} </td>
                    <td>{{ $branch }}</td>
                    <td>{{ $payment->type }}</td>
					<td>{{ $payment->entry_fee }}</td>
                    <td>{{ $payment->created_at }}</td>
                  
                </tr>
				
            @endforeach
			
			
		      
        </tbody>
    </table>
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