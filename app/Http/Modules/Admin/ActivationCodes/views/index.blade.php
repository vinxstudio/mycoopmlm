@extends('layouts.master')
@section('content')
    @include('Admin.ActivationCodes.views.form')
    {{ Form::open(['class'=>'form-horizontal form-bordered']) }}
	<?php //die($date_from);?>
        <input type="hidden" name="date_range" value="1">
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
    {{ Form::close() }}
    <?php

    $from = (!empty($date_from))? strtotime($date_from):'0';
    $to = (!empty($date_to))? strtotime($date_to):'0';
    ?>

    <div class="col-md-12 mt-15">
        <table class="table table-bordered table-stiped table-hover">
            <thead>
                <th>Batch ID</th>
                <th>Total Codes</th>
                <th>Available Codes</th>
                <th>Code Type</th>
            </thead>
            <tbody>
                @if ($batches->isEmpty())
                    <tr>
                        <td colspan="3">
                            <center>
                                <i>No activation codes were made yet.</i>
                            </center>
                        </td>
                    </tr>
                @else
                    @foreach($batches as $batch)
                        <tr>
                            <td><a href="{{ url('admin/activation-codes/view-batch/'.$batch->id) }}">{{ $batch->name }}</a></td>
                            <td>{{ $batch->activationCodes()->count() }}</td>
                            <td>{{ $batch->activationCodes()->where('status', 'available')->count() }}</td>
                            <td>{{ $batch->type }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        {{ $batches->render() }}
    </div>
    <div class="clearfix"></div>
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
