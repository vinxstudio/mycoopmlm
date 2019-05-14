@extends('layouts.master')

@section('content')
	<a class="btn btn-primary pull-left" data-toggle="modal" data-target="#news_update"><i class="fa fa-plus"></i> {{ Lang::get('labels.new') }}</a>
    <div class="clearfix"></div>
    <br/>
    <h1>NEWS AND UPDATES</h1>

    {{ view('widgets.newsUpdate.news_update')->with([
        'news'=> $news
    ])->render() }}

    @include('Admin.NewsUpdate.views.script')
    @include('Admin.NewsUpdate.views.modal')
@stop
