@extends('layouts.loginLayout')
@section('content')
    <div id="sign-wrapper">
        {{ BootstrapAlert() }}

        <!-- Login form -->
        {{ Form::open(
            [
                'class'=>'sign-in form-horizontal shadow rounded no-overflow'
            ]
        ) }}
        <div class="sign-header">
            <div class="form-group">
                <div class="sign-text">
                    <span>{{ Lang::get('labels.members_area') }}</span>
                </div>
            </div>
        </div>
        <div class="sign-body">
            <div class="form-group">
                <div class="input-group input-group-lg rounded no-overflow {{ $errors->first('email') ? 'has-error has-feedback' : null }}">
                    <input type="text" class="form-control input-sm" placeholder="{{ Lang::get('labels.verification_code') }}" name="verification_code">
                    {{ validationError($errors, 'verification_code') }}
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                </div>
            </div>
        </div>
        <div class="sign-footer">
            <div class="form-group">
                <button type="submit" class="btn btn-theme btn-lg btn-block no-margin rounded spinner" id="login-btn">{{ Lang::get('labels.sign_in') }}</button>
            </div>
        </div>
        {{ Form::close() }}

        <div class="col-md-12">
            <p class="text-muted text-center sign-link">{{ Lang::get('labels.have_account') }} <a href="{{ url('auth/login') }}"> {{ Lang::get('labels.sign_in') }}</a></p>
            <p class="text-muted text-center sign-link">{{ Lang::get('labels.not_yet_registered') }} <a href="{{ url('auth/sign-up') }}"> {{ Lang::get('labels.sign_up') }}</a></p>
        </div>

    </div>
@stop