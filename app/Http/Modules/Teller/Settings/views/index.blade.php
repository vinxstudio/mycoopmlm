@extends('layouts.master')
@section('content')
    {{ Form::open([
        'class'=>'form-horizontal'
    ]) }}
    <div class="col-md-6">
        <div class="panel rounded shadow panel-success">
            <div class="panel-heading">
                <div class="pull-left">
                    <h3 class="panel-title">{{ Lang::get('codes.code_settings') }}</h3>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body no-padding">
                <div class="form-body">
                    <div class="form-group">
                        {{ validationError($errors, 'companyName') }}
                        <input type="text" class="form-control mb-15" placeholder="Activation & Account Prefix" value="{{ old('companyName', strtoupper($company->activation_code_prefix)) }}" name="activationPrefix">
                    </div><!-- /.form-group -->
                    <div class="form-group">
                        {{ validationError($errors, 'productPrefix') }}
                        <input type="text" class="form-control" placeholder="Product Code Prefix" name="productPrefix" value="{{ old('productPrefix', strtoupper($company->product_code_prefix)) }}">
                    </div>
                </div>


            </div>
        </div>

    </div>
    <div class="col-md-6">
        <div class="panel rounded shadow panel-danger">
            <div class="panel-heading">
                <div class="pull-left">
                    <h3 class="panel-title">{{ Lang::get('codes.free_code_earnings') }}</h3>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-5 text-right">{{ Lang::get('codes.binary_pairing') }}</label>
                    <div class="col-sm-7">
                        <?php $checked = ($company->free_code_pairing <= 0) ? 'checked="checked"' : null ?>
                        <input type="checkbox" class="switch" {{ $checked }} name="pairing" data-on-text="ON" data-off-text="OFF" data-on-color="teal">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-5 text-right">{{ Lang::get('codes.direct_referral') }}</label>
                    <div class="col-sm-7">
                        <?php $checked = ($company->free_code_referral <= 0) ? 'checked="checked"' : null ?>
                        <input type="checkbox" class="switch" {{ $checked }} name="referral" data-on-text="ON" data-off-text="OFF" data-on-color="teal">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-5 text-right">{{ Lang::get('codes.allow_multiple_account') }}</label>
                    <div class="col-sm-7">
                        <?php $checked = ($company->multiple_account <= 0) ? 'checked="checked"' : null ?>
                        <input type="checkbox" class="switch" {{ $checked }} name="multiple_account" data-on-text="ON" data-off-text="OFF" data-on-color="teal">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-footer">
            <button type="submit" name="submit" value="submit" class="btn btn-success">{{ Lang::get('labels.save') }}</button>
        </div>
    </div>
    {{ Form::close() }}

@stop
@section('custom_includes')
    {{ Html::style('public/assets/global/plugins/bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css') }}
    {{ Html::script('public/assets/global/plugins/bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js') }}
    {{ Html::script('public/custom/js/code-settings.js') }}
@stop