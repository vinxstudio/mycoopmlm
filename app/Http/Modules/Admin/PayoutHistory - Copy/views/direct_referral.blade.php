@extends('layouts.master')
@section('content')
    
    
    @include('Admin.PayoutHistory.views.user_info', ['user_info'=>$user_info ])

    <?php $total=0 ?>

    <div class="panel panel-theme rounded shadow">
        <div class="panel-heading">
            <div class="pull-left">
                <h3 class="panel-title">Direct Referral Bunos<code></code></h3>
            </div>
            <div class="pull-right">
            </div>
            <div class="clearfix"></div>
        </div><!-- /.panel-heading -->
        <div class="panel-body no-padding" style="display: block;">
              <table class="dataTable table table-bordered table-hover table-striped" style="font-size:8px;">
                    <thead>
                        <th>Account ID</th>
                        <th>Full Name</th>
                        <th>Package</th>
                        <th>Date Encoded</th>
                        <th>Direct Referral Amount</th>
                        
                    </thead>
                    <tbody>
                        @foreach ($payments as $payout)
                            <?php $total = $total + $payout['dr']; ?>
                            <tr>
                                <td>{{$payout['account_id']}}</td>
                                <td>{{$payout['name']}}</td>
                                <td>{{$payout['package']}}</td>
                                <td>{{$payout['date']}}</td>
                                <td>{{$payout['dr']}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4">Total Amount</td>   
                            <td>{{ number_format($total,2) }}</td>   
                        </tr>
                    </tfoot>
                </table>

        </div><!-- /.panel-body -->
    </div><!-- /.panel -->
@stop