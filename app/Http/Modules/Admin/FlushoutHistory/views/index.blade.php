@extends('layouts.master')
@section('content')
    <?php
         $from = (!empty($date_from))? strtotime($date_from):'0';
        $to = (!empty($date_to))? strtotime($date_to):'0';
    ?>
    <div class="row">
        <div class="col-md-3">
            <label><h1>Flushout Report</h1></label>
        </div>
        <div class="col-md-5 col-md-offset-4">
            <h4 class="pull-right" style="padding-top:20px;">Overall Total Amount: {{ number_format(abs($overall_total), 2) }}</h4>
        </div>
        <!-- <div class="col-md-5 col-md-offset-4">
            <h4 class="pull-right" style="padding-top:5px;">Total Amount: {{ number_format(abs($flushout_total), 2) }}</h4>
        </div> -->
    </div>
    {{ Form::open(['class'=>'form-horizontal form-bordered']) }}
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
       <div class='col-md-3'>
                <?php
                    $date_from = (!empty($date_from))? $date_from:'0';
                    $date_to = (!empty($date_to))? $date_to:'0';
                ?>
            <div class="form-group pull-right">
                <label>&nbsp;</label>
                <div class='input-group date'>
                    <a class="btn btn-success pull-right" href="{{ url('/admin/export-flushout/xlsx/'.$date_from.'/'.$date_to) }}"><i class="fas fa-download"></i> Download Flushout History Reports</a>
                </div>
            </div>
        </div>
    {{ Form::close() }}

    {{ view('widgets.flushout.flushout-list')->with([
        'flushout_list'=> $flushout_list,
        'flushout_total'=>$flushout_total
    ])->render() }}
    {{ $flushout_list->render() }}
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
