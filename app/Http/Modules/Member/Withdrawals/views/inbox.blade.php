@extends('layouts.members')
@section('content')
    <div class="col-md-12 col-xs-12">
        <div class="panel panel-theme rounded shadow">
            <div class="panel-heading">
                <h3 class="panel-title">{{ Lang::get('withdrawal.inbox') }}</h3>
                <div class="clearfix"></div>
            </div>
        </div>
        <div style="float: right; margin-bottom: 25px">
            <select id="inbox_status" class="form-control" style="width: 150px">
                <option value="" class="hide" selected disabled>Select Status...</option>
                <option value="">All</option>
                <option value="approved" @if($status == 'approved') selected @endif>Approved</option>
                <option value="declined" @if($status == 'declined') selected @endif>Declined</option>
            </select>
        </div>
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <!-- Gross Income -->
                <th>
                    Gross Income
                </th>
                <!-- Cut off Start -->
                <th>
                    Cut-Off Start
                </th>
                <!-- Cut off End -->
                <th>
                    Cut-Off End
                </th>
                <!-- Status -->
                <th>
                    Status
                </th>
                <!-- Reason -->
                <th>
                    Reason
                </th>
            </thead>
            <tbody>
                @if(count($weekly_payout) > 0)
                    @foreach ($weekly_payout as $payout)
                        <tr>
                            <!-- Gross Income -->
                            <td class="col-sm-1">
                                <b style="color: green;">
                                    {{ $payout->gross_income }}
                                </b>
                            </td>
                            <!-- Cut off date started -->
                            <td class="col-md-2">   
                                {{ date('F d, Y', strtotime($payout->date_from)) }}
                            </td>
                            <!-- Cut off date ended -->
                            <td class="col-md-2">
                                {{ date('F d, Y', strtotime($payout->date_to)) }}
                            </td>
                            <!-- status -->
                            <td class="col-sm-1">
                                <span style="padding: 5px;" class="@if($payout->status == 'approved') bg-success @elseif($payout->status == 'declined') bg-warning @endif">
                                    {{ $payout->status }}
                                </span>
                            </td>
                            <!-- reason -->
                            <td class="col-md-4">
                                {{ $payout->reason }}
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>

        </table>
        <div class="text-right">
            {{ $weekly_payout->render() }}
        </div>


    </div>

    <script>

        $(document).ready(function(){
            $('#inbox_status').change(function(e){

                console.log(e);

                if(e.target.value == ''){
                    // go to /teller/product-codes/
                    location.href = location.protocol + '//' + location.host + location.pathname;
                }
                else{
                    // add parameter ?product_name=value
                    location.href = location.protocol + '//' + location.host + location.pathname + '?status=' + e.target.value;
                }

            });
        });


    </script>
@stop