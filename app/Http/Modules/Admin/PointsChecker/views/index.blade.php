@extends('layouts.master')
@section('content')
  <?php
    // set_time_limit(3000);

    // $new_from_date = date("F d, Y", strtotime($date_from));
    // $new_to_date = date("F d, Y", strtotime($date_to));

    // $total = 0;
    // foreach($details as $detail)
    // {
    //     $list_downlines = $detail['list_downlines'];
    // }
    // echo $details;
        
  ?>
   <div class='col-md-12'>
        <div class="col-md-4">
          <h2>Points Checker</h2>
          {{-- <h4>From : {{ $new_from_date }} To : {{ $new_to_date }}</h4>  --}}
        </div>
        {{-- <div class="col-md-4 col-md-offset-4">
            <h4>All Total Maintenance Amount: {{ number_format($total_maintenance, 2) }}</h4>
        </div> --}}
    </div>
    {{-- @include('Admin.FlushoutHistory.views.user_info', ['user_info'=>$user_info ]) --}}
    {{ Form::open(['class'=>'form-horizontal form-bordered']) }}
        <div class='col-md-16 form-group'>
          <div class="pull-left" style="margin-top: 40px;">
            <div class="pull-left">
              <h5>Search User : &nbsp;</h5>
            </div>
            <div class="pull-left">
              <input type="text" name="account_id" class="form-control">
            </div>
            <div class="pull-left">
              <span><button type="submit" class="btn btn-success"> Submit </button></span>
            </div>
          </div>
          
        </div>
        <div class="col-md-12">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <th>Left Points Value</th>
                    <th>Right Points Value</th>
                    <th>Strong Leg</th>
                </thead>
                <tbody>
                    @if(!empty($pv_table))
                        @foreach($pv_table as $pv)
                        <tr>
                            <td>{{$pv['left_total_pv']}}</td>
                            <td>{{$pv['right_total_pv']}}</td>
                            <td>{{$pv['strong_leg']}}</td>
                        </tr>
                        @endforeach
                    @else 
                    <tr>
                        <td colspan="3">
                            <center>
                                <i>No Available Data</i>
                            </center>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        
      {{ Form::close() }}
      <div class="col-md-12">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <th>FullName</th>
                <th>Account ID.</th>
                <th>Left Package Type</th>
                <th>Node</th>
                <th>PV</th>
            </thead>
            <tbody>
                @if(!empty($lists))
                    @foreach($lists as $list)
                        <tr>
                        
                            <td>{{(!empty($list->full_name)) ? $list->full_name : ''}}</td>
                            <td>{{(!empty($list->account_id)) ? $list->account_id : ''}}</td>
                            <td>{{(!empty($list->package)) ? $list->package : ''}}</td>
                            <td>{{(!empty($list->node)) ? $list->node : ''}}</td>
                            <td>{{(!empty($list->pv)) ? $list->pv : ''}}</td>

                        </tr>
                        
                    @endforeach
                @else 
                <tr>
                    <td colspan="4">
                        <center>
                            <i>Search User</i>
                        </center>
                    </td>
                </tr>
                @endif
            </tbody>
            <tfoot>
                <tr class="strong">
                    <td colspan="4"></td>
                    {{-- <td>{{ number_format($total, 2) }}</td> --}}
                    <td colspan="4"></td>
                </tr>
            </tfoot>
        </table>
       {{(!empty($lists)) ? $lists->render() : ''}}
      </div>
@stop
