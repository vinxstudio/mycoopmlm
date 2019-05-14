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
          <h2>Points Summary</h2>
          {{-- <h4>From : {{ $new_from_date }} To : {{ $new_to_date }}</h4>  --}}
        </div>
        {{-- <div class="col-md-4 col-md-offset-4">
            <h4>All Total Maintenance Amount: {{ number_format($total_maintenance, 2) }}</h4>
        </div> --}}
    </div>
    {{ Form::open(['class'=>'form-horizontal form-bordered']) }}
        <div class='col-md-16 form-group'>
          <div class="pull-left" style="margin-top: 40px;">
            <div class="pull-left">
              <h5>Search User : &nbsp;</h5>
            </div>
            <div class="pull-left">
              <input type="text" name="search" class="form-control">
            </div>
            <div class="pull-left">
              <span><button type="submit" class="btn btn-success"> Submit </button></span>
            </div>
          </div>
          
        </div>
        <div class="col-md-12">
            <table class="table table-bordered table-hover table-striped">
                <col width="20%;">
                <col width="20%;">
                <col width="10%;">
                <col width="10%;">
                <col width="10%;">
                <col width="30%;">
                <thead>
                    <th>Full Name</th>
                    <th>Account ID.</th>
                    <th>Package Type</th>
                    <th>Left PV</th>
                    <th>Right PV</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @if(!empty($lists))
                        @foreach($lists as $list)
                        <?php 
                            $first_name = (!empty($list->first_name)) ? $list->first_name : '';
                            $last_name = (!empty($list->last_name)) ? $list->last_name : '';

                            $account_id = (!empty($list->account_id)) ? $list->account_id : '';
                            $package_type = (!empty($list->membership_type_name)) ? $list->membership_type_name : '';
                            $left_points_value = (!empty($list->left_points_value)) ? $list->left_points_value : 0; 
                            $right_points_value = (!empty($list->right_points_value)) ? $list->right_points_value : 0;
                        ?>
                        <tr>
                            <td>{{$first_name.' '.$last_name}}</td>
                            <td>{{$account_id}}</td>
                            <td>{{$package_type}}</td>
                            <td>{{$left_points_value}}</td>
                            <td>{{$right_points_value}}</td>
                            <td>
                                <a href="{{url('admin/points-summary/downline/?account_id='.$list->p_account_id)}}" class="btn btn-danger btn-xs">View Downline</a>
                                <a href="{{url('admin/points-summary/details/?account_id='.$list->p_account_id)}}" class="btn btn-success btn-xs">Points Details</a>
                                <a href="{{url('admin/points-summary/pairing/?account_id='.$list->p_account_id)}}" class="btn btn-warning btn-xs">View Pairing</a>
                                <a href="{{url('admin/points-summary/pairing/?account_id='.$list->p_account_id)}}" class="btn btn-info btn-xs">View History</a>
                            </td>
                        </tr>
                        @endforeach
                    @else 
                    <tr>
                        <td colspan="5">
                            <center>
                                <i>No Available Data</i>
                            </center>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
       {{$lists->render()}}
      </div>
@stop
