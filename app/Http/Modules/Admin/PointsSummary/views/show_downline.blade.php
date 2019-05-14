@extends('layouts.master')
@section('content')
    <div class='col-md-12'>
        <div class="col-md-12">
          <h2>Downline</h2>
        </div>
        
    </div>
    <div class="col-md-12">
        @include('Admin.PointsSummary.views.user_info', ['user_info'=> $user_info ])
    </div>
    <div class="col-md-6">
        <table class="table table-bordered table-hover table-striped"  style="font-size:10px;">
            <col width="10%;">
            <col width="10%;">
            <col>
            <col>
            <col>
            <thead>
                <th>Full Name</th>
                <th>Account ID.</th>
                <th>Package Type</th>
                <th>Left PV</th>
                <th>Date Created</th>
                <th>Status</th>
                <th>#. Paired</th>
            </thead>
            <tbody>
                @if(!empty($left_downlines))
                    @foreach($left_downlines as $left)
                        <?php
                            $color = ($left->status == 'Paired') ? 'text-success' : 'text-danger';
                        ?>
                        <tr>
                            <td>{{$left->full_name}}</td>
                            <td>{{$left->account_id}}</td>
                            <td>{{$left->membership_type_name}}</td>
                            <td>{{$left->points_value}}</td>
                            <td>{{$left->account_created}}</td>
                            <td class="{{$color}}">{{$left->status}}</td>
                            <td>{{$left->num_paired}}</td>
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
            <tfoot>
                <tr class="strong">
                    <td colspan="2"></td>
                    <td>Total</td>
                    <td>{{ $left_total_points }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="col-md-6">
        <table class="table table-bordered table-hover table-striped"  style="font-size:10px;">
            <col width="10%;">
            <col width="10%;">
            <col>
            <col>
            <col>
            <thead>
                <th>Full Name</th>
                <th>Account ID.</th>
                <th>Package Type</th>
                <th>Right PV</th>
                <th>Date Created</th>
                <th>Status</th>
                <th>#. Paired</th>
            </thead>
            <tbody>
                @if(!empty($right_downlines))
                    @foreach($right_downlines as $right)
                        <?php
                            $color = (($right->status == 'Paired')) ? 'text-success' : 'text-danger';
                        ?>
                        <tr>
                            <td>{{$right->full_name}}</td>
                            <td>{{$right->account_id}}</td>
                            <td>{{$right->membership_type_name}}</td>
                            <td>{{$right->points_value}}</td>
                            <td>{{$right->account_created}}</td>
                            <td class="{{$color}}">{{$right->status}}</td>
                            <td>{{$right->num_paired}}</td>
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
            <tfoot>
                <td colspan="2"></td>
                <td>Total</td>
                <td>{{ $right_total_points }}</td>
                <td></td>
                <td></td>
                <td></td>
            </tfoot>
        </table>
    </div>

@stop
