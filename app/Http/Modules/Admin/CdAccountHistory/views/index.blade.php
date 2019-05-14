@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-md-4 form-group">
            <label><h1>CD Account Report</h1></label>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
            {{ Form::open(['class'=>'form-inline']) }}
                <label for="keyword">Search:</label>
                <input type="keyword" name="keyword" class="form-control" id="keyword" value="{{$search_keyword}}" placeholder="Search Member...">
                <button type="submit" class="btn btn-success">Search</button>
            {{ Form::close() }}
            </div>
        </div>
        <div class="col-md-6">
            <?php
                $search_keyword = (!empty($search_keyword)) ? $search_keyword : '0';
            ?>
            <a class="btn btn-success pull-right" href="{{ url('/admin/export-cd-accounts/xlsx/'.$search_keyword) }}"><i class="fas fa-download"></i> Download CD-Account Reports</a>   
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table id="cd_account_table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>User Name</th>
                        <th>Role</th>
                        <th>Account ID.</th>
                        <th>Package Type</th>
                        <th>Package Amount</th>
                        <th>Total Earnings</th>
                        <th>Date Encoded</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($members))
                        @foreach ($members as $member)
                            <tr>
                                <td>{{$member->full_name}}</td>
                                <td>{{$member->username}}</td>
                                <td>{{$member->role}}</td>
                                <td>{{$member->account_id}}</td>
                                <td>{{$member->membership_type_name}}</td>
                                <td>{{$member->entry_fee}}</td>
                                <td>{{number_format($member->total_earnings, 2)}}</td>
                                <td>{{$member->created_at}}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            {{$members->render()}}
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
