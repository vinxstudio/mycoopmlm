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
    <meta name="keywords" content="Cebu People's, CPMPC, Cebu People's Multi-Purpose Cooperative">    @include('layouts.partial.header')

</head>

<body class="body" data-base-url="{{ url() }}">

<!--[if lt IE 9]>
<p class="upgrade-browser">Upps!! You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/" target="_blank">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
<div class="login-wrapper">
<div class="login-background">
	<div class="login-header">
		<div class="header-tagline">
			<h1>Let's get started by joining <strong>As A Member</strong></h1>
		</div>
	</div>

	@yield('content')

	@include('layouts.partial.corePlugins')

	@yield('pageIncludes')

	@include('layouts.partial.googleAnalytics')	
</div>
</div>

</body>
<!-- END BODY -->

</html>