@extends('layouts.members')
@section('content')
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="panel panel-theme rounded shadow">
            <div class="panel-heading">
                <h3 class="panel-title">{{ Lang::get('labels.select_upline') }}</h3>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                {{ Form::open() }}
                <div class="form-group">
                    <div class="form-group">
                        {{ validationError($errors, 'upline') }}
                        <label class="control-label">{{ Lang::get('labels.upline') }}</label>
                        {{ Form::select('upline', [''=>Lang::get('members.select_upline')] + $uplineDropdown, old('upline'), [
                            'class'=>'form-control chosen-select'
                        ]) }}
                    </div>
                    <div class="form-group">
                        {{ Form::button(Lang::get('labels.activate_account'), [
                            'class'=>'btn btn-primary pull-right',
                            'name'=>'activate',
                            'value'=>'activate',
                            'type'=>'submit'
                        ]) }}
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop