@extends('layouts.master')
@section('content')
    
    
    @include('Admin.PayoutHistory.views.user_info', ['user_info'=>$user_info ])

    <?php $total=0 ?>

    <div class="panel panel-theme rounded shadow">
        <div class="panel-heading">
            <div class="pull-left">
                <h3 class="panel-title">Matching Bunos<code></code></h3>
            </div>
            <div class="pull-right">
            </div>
            <div class="clearfix"></div>
        </div><!-- /.panel-heading -->
        <div class="panel-body no-padding" style="display: block;">
              <table id="dataTable_mb" class=" table table-bordered table-hover table-striped" style="font-size:8px;">
                    <thead>
                        <th>Left Account ID</th>
                        <th>Left Full Name</th>
                        <th>Left Package</th>
                        <th>Left Date Encoded</th>
                        <th>Right Account ID</th>
                        <th>Right Full Name</th>
                        <th>Right Package</th>
                        <th>Right Date Encoded</th>
                        <th>Matching Bonus Amount</th>
                        <th>Pairing Date</th>
                        
                    </thead>
                    <tbody>
                        @foreach ($payments as $payout)
                            <?php $total = $total + $payout['mb']; ?>
                            <tr>
                                <td>{{$payout['left_account_id']}}</td>
                                <td>{{$payout['left_name']}}</td>
                                <td>{{$payout['left_package']}}</td>
                                <td>{{$payout['left_account_date']}}</td>
                                <td>{{$payout['right_account_id']}}</td>
                                <td>{{$payout['right_name']}}</td>
                                <td>{{$payout['right_package']}}</td>
                                <td>{{$payout['right_account_date']}}</td>
                                <td>{{$payout['mb']}}</td>
                                <td>{{$payout['date']}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="8" style="text-align: right">Total Amount</td>   
                            <td>{{ number_format($total,2) }}</td>   
                        </tr>
                    </tfoot>
                </table>
        </div><!-- /.panel-body -->
    </div><!-- /.panel -->
    <script type="text/javascript">
        $(document).ready(function(){
            $('#dataTable_mb').DataTable({
                 "order": [[ 9, "asc" ]]
            });
        });

    </script>
@stop