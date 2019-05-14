@extends('layouts.master')
@section('content')


    <a class="btn btn-primary pull-left" href="{{ url('admin/administrators/form') }}"><i class="fa fa-plus"></i> {{ Lang::get('labels.new') }}</a>
    <div class="clearfix"></div>
    <br/>
    <table class="table table-bordered table-hover table-striped">

        <thead>
        <th>{{ Lang::get('members.photo') }}</th>
        <th>{{ Lang::get('members.name') }}</th>
        <th>{{ Lang::get('members.username') }}</th>
        <th>{{ Lang::get('labels.action') }}</th>
        </thead>

        <tbody>

        @if ($admins->isEmpty())
            <tr>
                <td colspan="10"><center>{{ Lang::get('members.no_records') }}</center></td>
            </tr>
        @else
            @foreach ($admins as $admin)
                <tr>
                    <td><img src="{{ url($admin->details->thePhoto) }}" class="img-circle" width="40" height="40" alt=""/></td>
                    <td>{{ $admin->details->fullName }}</td>
                    <td>{{ $admin->username }}</td>
                    <td>
                        <a class="btn btn-warning btn-xs" href="{{ url('admin/administrators/form/'.$admin->id) }}"><i class="fa fa-pencil"></i></a>
                        <a class="btn btn-danger btn-xs" href="{{ url('admin/administrators/delete/'.$admin->id) }}"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach
        @endif

        </tbody>

    </table>

    <center>{{ $admins->render() }}</center>

@stop