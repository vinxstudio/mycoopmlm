@extends('layouts.master')
@section('content')

    <div class="col-md-4 col-xs-12">
        @include('Admin.Connect.views.form')
    </div>

    <div class="col-md-8 col-xs-12">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <th>{{ Lang::get('connection.url') }}</th>
                <th>{{ Lang::get('connection.passcode') }}</th>
                <th>{{ Lang::get('labels.action') }}</th>
            </thead>
            <tbody>
                @if ($connections->isEmpty())
                    <tr>
                        <td colspan="3">
                            <center>{{ Lang::get('connection.empty') }}</center>
                        </td>
                    </tr>
                @else
                    @foreach ($connections as $row)
                        <tr>
                            <td><a href="{{ $row->url }}" target="_blank">{{ $row->url }}</a></td>
                            <td>{{ $row->passcode }}</td>
                            <td>
                                <a class="btn btn-danger btn-xs" href="{{ url('admin/connections/delete/'.$row->id) }}"><i class="fa fa-trash"></i> {{ Lang::get('labels.delete') }}</a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

@stop