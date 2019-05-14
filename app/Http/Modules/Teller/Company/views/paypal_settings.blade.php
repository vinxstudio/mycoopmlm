@extends('layouts.master')

@section('content')
    <div class="col-md-6">
        <div class="panel panel-theme rounded shadow">
            <div class="panel-heading">
                <div class="pull-left">
                    <h3 class="panel-title">{{ Lang::get('company.paypal') }}</h3>
                </div>
                <div class="pull-right">
                    <button class="btn btn-sm" data-action="collapse" data-container="body" data-toggle="tooltip" data-placement="top" data-title="Collapse" data-original-title="" title=""><i class="fa fa-angle-up"></i></button>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body no-padding">
                @if ((bool)config('system.demo') == true)
                    <center>
                        <p>Feature is disabled for Demo Mode</p>
                    </center>
                @else
                    {{ Form::open([
                        'class'=>'form-horizontal'
                    ]) }}
                    <div class="form-body">
                        <div class="form-group no-margin">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label">Username</label>
                                    {{ validationError($errors, 'paypalUsername') }}
                                    {{ Form::text('paypalUsername', old('paypalUsername', config('paypal.username')), [
                                        'class'=>'form-control mb-15',
                                        'placeholder'=>Lang::get('company.paypal_username')
                                    ]) }}
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label">Password</label>
                                    {{ validationError($errors, 'paypalPassword') }}
                                    {{ Form::text('paypalPassword', old('paypalPassword', config('paypal.password')), [
                                        'class'=>'form-control mb-15',
                                        'placeholder'=>Lang::get('company.paypal_password')
                                    ]) }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Signature</label>
                            {{ validationError($errors, 'paypalSignature') }}
                            {{ Form::text('paypalSignature', old('paypalSignature', config('paypal.signature')), [
                                'class'=>'form-control mb-15',
                                'placeholder'=>Lang::get('company.paypal_signature')
                            ]) }}
                        </div>
                        <div class="form-group">
                            <div class="col-md-3 col-xs-12 row">
                                <label class="control-label">Sandbox Mode?</label>
                                {{ Form::select('paypalSandbox', [
                                    'true'=>'Yes',
                                    'false'=>'No'
                                ], old('paypalSandbox', config('paypal.sandbox')), [
                                    'class'=>'form-control chosen'
                                ]) }}
                            </div>
                        </div>
                    </div>
                    <div class="form-footer">
                        <button type="submit" name="save_paypal" value="save_paypal" class="btn btn-success">Submit</button>
                    </div>
                    {{ Form::close() }}
                @endif
            </div>
        </div>
    </div>
@stop