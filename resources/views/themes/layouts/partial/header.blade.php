<link href="{{ url('public/assets/fonts/open-sans.css') }}" rel="stylesheet">
<link href="{{ url('public/assets/fonts/oswald.css') }}" rel="stylesheet">

<link href="{{ url('public/assets/global/plugins/bower_components/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
<!--/ END GLOBAL MANDATORY STYLES -->

<!-- START @PAGE LEVEL STYLES -->
<link href="{{ url('public/assets/global/plugins/bower_components/fontawesome/css/font-awesome.min.css') }}" rel="stylesheet">
<link href="{{ url('public/assets/global/plugins/bower_components/animate.css/animate.min.css') }}" rel="stylesheet">
<link href="{{ url('public/assets/global/plugins/bower_components/jasny-bootstrap-fileinput/css/jasny-bootstrap-fileinput.min.css') }}" rel="stylesheet">
<link href="{{ url('public/assets/admin/css/reset.css') }}" rel="stylesheet">
<link href="{{ url('public/assets/admin/css/layout.css') }}" rel="stylesheet">
<link href="{{ url('public/assets/admin/css/components.css') }}" rel="stylesheet">
<link href="{{ url('public/assets/admin/css/plugins.css') }}" rel="stylesheet">
<link href="{{ url('public/assets/admin/css/themes/default.theme.css') }}" rel="stylesheet" id="theme">
<link href="{{ url('public/assets/admin/css/pages/sign.css') }}" rel="stylesheet">
<link href="{{ url('public/assets/admin/css/custom.css') }}" rel="stylesheet">
<link href="{{ url('public/plugins/datepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">

<link href="{{ url('public/custom/css/globalCustom.css') }}" rel="stylesheet"><link rel="icon" type="image/png" href="{{ url('public/img/logo-2-icon.png')}}">

<script src="{{ url('public/assets/global/plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>

<?php
    $page_title = str_replace('-', ' ', Request::segment(2));
?>

<title>Cebu People's Multi-Purpose Cooperative | Network</title>