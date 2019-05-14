@extends('layouts.master')
@section('content')
   <div class='col-md-12'>
        <div class="col-md-4">
          <h2>Points Details</h2>
          {{-- <h4>From : {{ $new_from_date }} To : {{ $new_to_date }}</h4>  --}}
        </div>
        {{-- <div class="col-md-4 col-md-offset-4">
            <h4>All Total Maintenance Amount: {{ number_format($total_maintenance, 2) }}</h4>
        </div> --}}
    </div>
    <div class="col-md-12">
        @include('Admin.PointsSummary.views.user_info', ['user_info'=> $user_info ])
    </div>
    <div class="col-md-12 form-group">
        <table id='points_details' class="table table-bordered table-hover table-striped" style="font-size:10px;">
            <col width="30%;">
            <col width="5%;">
            <col width="5%;">
            <col width="5%;">
            <col width="5%;">
            <col width="5%;">
            <col width="15%;">
            <col width="15%;">
            <thead>
                <th>Downline</th>
                <th>Node</th>
                <th>LPV</th>
                <th>RPV</th>
                <th>Flushout Point</th>
                <th>Retention Point</th>
                <th>Reason Flushout</th>
                <th>Date Encoded</th>
            </thead>
            <tbody>
                @if(!empty($details))
                    @foreach($details as $detail)
                        <?php
                            $firstname = (!empty($detail->first_name)) ? $detail->first_name : '';
                            $lastname = (!empty($detail->last_name)) ? $detail->last_name : '';
                            $account_id = (!empty($detail->account_id)) ? $detail->account_id : '';
                            $membership_type = (!empty($detail->membership_type_name)) ? $detail->membership_type_name : '';

                            if($detail->paired_account == '1' || $detail->paired_account == '')
                            {
                                $paired_account = '';
                            }
                            else
                            {
                                $paired_account = $detail->paired_account;
                            }
                        ?>
                        <tr>
                            <td>
                                {{$firstname.' '.$lastname.' ('.$account_id.' - '.$membership_type.') '.$detail->upgraded_account}}
                            </td>
                            <td>{{$detail->node}}</td>
                            <td>{{$detail->left_points_value}}</td>
                            <td>{{$detail->right_points_value}}</td>
                            <td>{{$detail->flushout_points}}</td>
                            <td>{{$detail->retention_points}}</td>
                            <td>{{$detail->reason_for_flushout}}</td>
                            <td>{{$detail->created_at}}</td>
                        </tr>
                    @endforeach
                @else
                <tr>
                    <td colspan="9">
                        <center>
                            <i>No Available Data</i>
                        </center>
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#points_details').DataTable({
                "ordering": false,
                "searching": false,
                "lengthChange": false,
                "iDisplayLength": 50
            });
        });

    </script>

@stop
