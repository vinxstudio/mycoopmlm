@extends('layouts.teller')
@section('content')

<div class='col-md-12'>
    <span>
        <h2>For Maintenance</h2>
    </span>
</div>

<table class="table table-bordered table-striped">
    <thead>
    <th>Teller</th>
    <th>Full Name</th>
    <th>Username</th>
    <th>OR#</th>
    <th>Payors Name</th>
    <th>CBU</th>
    <th>MY-C</th>
    <th>Created Date</th>
    </thead>
    <tbody>
    @if ($maintenances->isEmpty())
        <tr>
            <td colspan="10">
                <center>
                    <i>{{ Lang::get('codes.no_record') }}</i>
                </center>
            </td>
        </tr>
    @else
        @foreach($maintenances as $maintenance)
            <tr>
                <td>{{ $maintenance->T_fname.' '.$maintenance->T_mname.' '.$maintenance->T_lname }}</td>
                <td>{{ $maintenance->M_fname.' '.$maintenance->M_mname.' '.$maintenance->M_lname }}</td>
                <td>{{ $maintenance->M_username }}</td>
                <td>{{ $maintenance->or }}</td>
                <td>{{ $maintenance->payors_name }}</td>
                <td>{{ $maintenance->cbu }}</td>
                <td>{{ $maintenance->my_c }}</td>
                <td>{{ $maintenance->created_at }}</td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>

@stop