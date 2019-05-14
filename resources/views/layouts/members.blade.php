<?php $segment1 = Request::segment(1); $segment2 = Request::segment(2); $segment3 = Request::segment(3) ?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->

<!-- START @HEAD -->
<head>
    <!-- START @META SECTION -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="Taking you further, starting today">
    <meta name="keywords" content="Cebu People's, CPMPC, Cebu People's Multi-Purpose Cooperative">

    @include('layouts.partial.header')

    @yield('plugin_css')

</head>
<body class="page-session page-header-fixed page-sidebar-fixed demo-dashboard-session {{ ($theUser->is_maintained == false or $theUser->paid == 'false') ? 'not-maintained' : '' }}" data-base-url="{{ url() }}">
@if ($theUser->is_maintained == false)
    <div class="fixed-notice">{{ Lang::get('labels.activation_reason') }}</div>
@endif

@if ($theUser->paid == 'false')
    <div class="fixed-notice {{ ($theUser->needs_activation == 'true') ? 'for-activation' : null }}">
        @if ($theUser->needs_activation == 'false')
            {{ Lang::get('labels.pay_now_message') }} <a href="{{ url('member/pay-now') }}" class="pay-now">{{ Lang::get('labels.pay_now') }} {{ config('money.currency_symbol') }}{{ number_format($member->entry_fee, 2) }}</a>
        @else
            {{ Lang::get('labels.needs_activation') }}
        @endif
    </div>
@endif

@if($segment2 == 'dashboard'
    && $theDetails->truemoney == '' 
    && $theDetails->cellphone_no == '' 
    && $theDetails->present_street == '' 
    && $theDetails->present_barangay == '' 
    && $theDetails->present_town == '' 
    && $theDetails->present_city == '' 
    && $theDetails->present_province == '' 
    && $theDetails->present_zipcode == '' 
    )
<div class="fixed-notice ">
        Please complete your profile info Address, Contact No., Truemoney account. <a href="{{ url('member/profile') }}" class="pay-now">Click here to update your profile.</a>
</div>
@endif
<!--[if lt IE 9]>
<p class="upgrade-browser">Upps!! You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/" target="_blank">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
<!-- START @WRAPPER -->
<section id="wrapper">
    @include('layouts.partial.headerMenu')

    <section id="page-content">

        @include('layouts.partial.member-horizontalbar')

        <div class="body-content animated fadeIn">
            {{ BootstrapAlert() }}
            @yield('content')

        </div>

    </section>
    <footer class="foot row" style="background-color: #eeeeef;min-height: 50px;">
        <div class="col">
            <!-- Footer Content Here -->
        </div>
    </footer>
</section><!-- /#wrapper -->
<!--/ END WRAPPER -->

@include('layouts.partial.corePlugins')

@include('layouts.partial.googleAnalytics')

{{ Html::script('public/custom/js/default_script.js') }}
@yield('plugin_js')

@yield('custom_includes')

</body>
<!--/ END BODY -->

</html>
