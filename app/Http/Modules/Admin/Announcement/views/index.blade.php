@extends('layouts.master')

@section('content')
	<a class="btn btn-primary pull-left" data-toggle="modal" data-target="#announcement"><i class="fa fa-plus"></i> {{ Lang::get('labels.new') }}</a>
    <div class="clearfix"></div>
    <br/>
    <h1>ANNOUNCEMENT</h1>

    {{ view('widgets.announcement.announcement')->with([
        'announcement'=> $announcement
    ])->render() }}

    @include('Admin.Announcement.views.script')
    @include('Admin.Announcement.views.modal')
@stop
