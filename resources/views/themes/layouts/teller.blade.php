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
<body class="page-session page-header-fixed page-sidebar-fixed demo-dashboard-session" data-base-url="{{ url() }}">

<!--[if lt IE 9]>
<p class="upgrade-browser">Upps!! You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/" target="_blank">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<!-- START @WRAPPER -->
<section id="wrapper">
    @include('layouts.partial.headerMenu')

    @include('layouts.partial.sidebarteller')

    <section id="page-content">

        @include('layouts.partial.breadcrumb')

        <div class="body-content animated fadeIn">
            {{ BootstrapAlert() }}
            @yield('content')

        </div>

    </section>
</section><!-- /#wrapper -->
<!--/ END WRAPPER -->

@include('layouts.partial.corePlugins')

@include('layouts.partial.googleAnalytics')

@yield('custom_includes')

{{ Html::script('public/custom/js/default_script.js') }}

@yield('plugin_js')

</body>
<!--/ END BODY -->

</html>
