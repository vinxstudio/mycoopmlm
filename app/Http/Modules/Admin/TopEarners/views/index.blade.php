@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-md-6 form-group">
            <label><h1>Member Gross Income Report</h1></label>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-12">
            <a class="btn btn-success pull-right" href="{{ url('/admin/export-gross-income/xlsx/') }}"><i class="fas fa-download"></i> Download Gross Income Reports</a>   
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table id="cd_account_table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#.</th>
                        <th>Full Name</th>
                        <th>User Name</th>
                        <th>Account ID.</th>
                        <th>Package Type</th>
                        <th>Total Gross Earnings</th>
                        <th>Date Encoded</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $counter = 1; ?>
                    @if(!empty($gross_income))
                        @foreach ($gross_income as $member)
                            
                            <tr>
                                <td>{{$gross_income->perPage()*($gross_income->currentPage()-1) + $counter}}</td>
                                <td>{{strtoupper($member->full_name)}}</td>
                                <td>{{$member->username}}</td>
                                <td>{{strtoupper($member->account_id)}}</td>
                                <td>{{$member->package_type}}</td>
                                <td>{{number_format($member->gross_income, 2)}}</td>
                                <td>{{$member->user_created}}</td>
                            </tr>
                            <?php $counter++; ?>
                        @endforeach
                    @endif
                </tbody>
            </table>
            {{$gross_income->render()}}
        </div>
    </div>
    <script type="text/javascript">

        // $(document).ready(function(){
        //     $('#cd_account_table').DataTable({
        //         "ordering": false,
        //         // "searching": false,
        //         // "paging" : false,
        //         "lengthChange": false,
        //         // "iDisplayLength": 50
        //     });
        // });
    </script>
@stop
