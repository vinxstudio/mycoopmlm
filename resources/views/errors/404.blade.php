<?php
    $template = 'layouts.loginLayout';
    $previous = 'auth/login';
    if (Request::segment(1) == 'admin'){
        $previous = 'admin/dashboard';
    } else if (Request::segment(1) == 'member'){
        $previous = 'member/dashboard';
    }
?>

@extends($template)
@section('content')
    @if ($template == 'layouts.loginLayout')
        <div class="sign-up" id="sign-wrapper">
    @endif
    <div class="row">
        <div class="col-md-12">

            <div class="error-wrapper">
                <h1>404!</h1>
                <h3>The page you are looking for has not been found!</h3>
                <h4>The page you are looking for might have been removed, or unavailable. <br></h4>
                <a href="{{ url($previous) }}"><h2><i class="fa fa-arrow-left"></i> Back</h2></a>
            </div>

        </div>
    </div>
    @if ($template == 'layouts.loginLayout')
        </div>
    @endif
@stop