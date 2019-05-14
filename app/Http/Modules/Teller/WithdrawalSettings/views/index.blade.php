@extends('layouts.master')
@section('content')
    <div class="col-md-6 col-xs-12 col-sm-12">
        {{ Form::open() }}
        <div class="panel panel-theme rounded shadow">
            <div class="panel-heading">
                <h3 class="panel-title">{{ Lang::get('withdrawal.settings') }}</h3>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    {{ validationError($errors, 'minimum_amount') }}
                    <label class="control-label">{{ Lang::get('withdrawal.minimum_amount') }}</label>
                    {{ Form::text('minimum_amount', old('minimum_amount', $settings->minimum_amount), [
                        'class'=>'form-control'
                    ]); }}
                </div>
                <div class="form-group">
                    {{ validationError($errors, 'admin_charge') }}
                    <label class="control-label">{{ Lang::get('withdrawal.admin_charge') }}</label>
                    {{ Form::text('admin_fee', old('admin_fee', $settings->admin_charge), [
                        'class'=>'form-control'
                    ]); }}
                </div>
                <div class="form-group">
                    {{ validationError($errors, 'tax') }}
                    <label class="control-label">{{ Lang::get('withdrawal.tax_percentage') }}</label>
                    {{ Form::text('tax', old('tax', $settings->tax_percentage), [
                        'class'=>'form-control'
                    ]); }}
                </div>
                <div class="form-group">
                    {{ Form::button(Lang::get('labels.save'), [
                        'class'=>'btn btn-primary',
                        'name'=>'save',
                        'value'=>'save',
                        'type'=>'submit'
                    ]) }}
                </div>
            </div>
        </div>
        {{ Form::close() }}
    </div>
@stop