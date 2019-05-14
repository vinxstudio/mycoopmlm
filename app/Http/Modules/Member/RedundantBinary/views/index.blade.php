@extends('layouts.members')
@section('content')
    
<div class="panel panel-theme rounded shadow">
    <div class="panel-heading">
        <div class="pull-left">
            <h3 class="panel-title">User Info<code></code></h3>
        </div>
        <div class="pull-right">
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="panel-body no-padding" style="display: block;">
        <div class="form-body">
            <div class="form-group col-md-12">
                <label class="col-sm-3 control-label">Account ID : </label>
                <div class="col-sm-3"><strong>{{ $user_info['accountid'] }}</strong></div>

                <label class="col-sm-3 control-label">Account Code</label>
                <div class="col-sm-3">
                    <strong>
                        {{ $user_info['code'] }}
                    </strong>
                </div>
            </div>
            <div class="form-group col-md-12">
                <label class="col-sm-3 control-label">Fullname : </label>
                <div class="col-sm-3">
                    <strong>
                        {{ $user_info['fullname'] }}
                    </strong>
                </div>

                <label class="col-sm-3 control-label">Username : </label>
                <div class="col-sm-3">
                    <strong>
                        {{ $user_info['username'] }}
                    </strong>
                </div>
            </div>
            <div class="form-group col-md-12">
                <label class="col-sm-3 control-label">Package : </label>
                <div class="col-sm-3">
                    <strong>
                        {{ $user_info['package'] }}
                    </strong>
                </div>

                <label class="col-sm-3 control-label">Total Income : </label>
                <div class="col-sm-3">
                    <strong>
                        {{ $user_info['total_rend_amount'] }}
                    </strong>
                </div>
            </div>
        </div>
        <hr>
        <div class="form-group col-md-12">
            <div class="col-md-8">
                <label class="col-sm-3">
                    Total Redundant Points :  
                </label>
                <strong class="col-sm-3">
                    @if(isset($rend_points->left_points_value) && isset($rend_points->right_points_value))
                        {{ number_format($rend_points->left_points_value + $rend_points->right_points_value, 2) }}
                    @else
                        0.00
                    @endif
                    </strong>
                </strong>
            </div>
            <div class="col-md-8">
                <label class="col-sm-3">
                    Total Left Redundant Points :
                </label>
                <strong class="col-sm-3">
                    @if(isset($rend_points->left_points_value))
                        {{ number_format($rend_points->left_points_value, 2) }}
                    @else
                        0.00
                        @endif
                </strong>
            </div>
            <div class="col-md-8">
                <label class="col-sm-3">
                    Total Right Redundant Points :
                </label>
                <strong class="col-sm-3">
                    @if(isset($rend_points->right_points_value))
                        {{ number_format($rend_points->right_points_value, 2) }}
                    @else
                        0.00
                    @endif
                </strong>
            </div>
            <div class="col-md-8 mt-10">
                <p>Note : <i>Every Left and Right Points have more than or equal to {{ $rend_settings->points_value }} it must be paired with each other</i></p>
                <p>Note : <i>Deducted {{ $rend_settings->points_value }} Points is equal to {{ $rend_settings->points_equivalent }} Peso</i></p>
            </div>
        </div>
    </div>
</div>

<table class="table">
    <thead>
        <tr>
            <th>
                Purchased By
            </th>
            <th>
                Product Code
            </th>
            <th>
                Transfer/Deduct
            </th>
            <th>
                Node
            </th>
            <th>
                Amount
            </th>
            <th>
                Date
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($rend_history as $rend)
            <tr>
                <td>
                    @if(isset($rend->purchases_name) && $rend->purchases_name != 'N / A')
                        {{ $rend->purchases_name }}
                    @else
                        Paired
                    @endif
                </td>
                <td>
                    @if(isset($rend->product_code_use) && $rend->product_code_use != 'N/A')
                        {{ $rend->product_code_use }}
                    @else
                        Paired
                    @endif
                </td>
                <td>
                    @if($rend->type == 'add_points')
                        Transfer Points
                    @elseif($rend->type == 'deduct_points')
                        Deducted Points
                    @endif
                </td>
                <td>
                    @if($rend->points_node == 'both')
                        Left and Right
                    @elseif($rend->points_node == 'left' || $rend->points_node == 'right')
                        {{ ucfirst($rend->points_node) }}
                    @endif
                </td>
                <td>
                    {{ number_format($rend->amount, 2) }}
                </td>
                <td>
                    {{ date('F d, Y - h:i A', strtotime($rend->created_at)) }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $rend_history->render() }}

<script type="text/javascript">
    $(document).ready(function(){
        $('#dataTable_mb').DataTable({
            "ordering": false,
            // "searching": false,
            "lengthChange": false
        });
    });

</script>

<style>

    th{
        background-color: #212529 !important;
        border-color: #32383e !important;
        color: #ffffff;
    }
    td{
        padding: 10px;
    }

</style>

@stop