@extends('layouts.setupLayout')
@section('content')
    <div id="sign-wrapper">
        {{ BootstrapAlert() }}

        <!-- Login form -->
        <p class="text-center sign-link">This is a password protected settings, if you are really the owner, you have a password sent to you by email or by personall message.</p>
        {{ Form::open(
            [
                'class'=>'sign-in form-horizontal shadow rounded no-overflow'
            ]
        ) }}

        <div class="sign-header">
            <div class="form-group">
                <div class="sign-text">
                    <span>Authentication Code</span>
                </div>
            </div><!-- /.form-group -->
        </div><!-- /.sign-header -->
        <div class="sign-body">
            <div class="form-group">
                <div class="input-group input-group-lg rounded no-overflow {{ $errors->first('password') ? 'has-error has-feedback' : null }}">
                    <input type="password" class="form-control input-sm" autocomplete="off" placeholder="Authentication Code" name="password">
                    {{ validationError($errors, 'password') }}
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                </div>
            </div>
        </div><!-- /.sign-body -->
        <div class="sign-footer">
            <div class="form-group">
                <button type="submit" class="btn btn-theme btn-lg btn-block no-margin rounded spinner" name="authenticate" id="login-btn">Sign In</button>
            </div>
        </div>
        {{ Form::close() }}
        <!--/ Login form -->

    </div><!-- /#sign-wrapper -->
@stop