@extends('layouts.members')
@section('content')
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="panel panel-danger rounded shadow">
            <div class="panel-heading">
                <h3 class="panel-title">{{ Lang::get('members.account_inactive') }}</h3>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <p>{{ Lang::get('members.activation_message') }}</p>
                </div>
            </div>
        </div>
    </div>
@stop