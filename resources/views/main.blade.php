<!DOCTYPE html>
<html lang="en">
<head>
@php $site_url = url('/').'/public'; @endphp
<?php $permissions=session('menu_permission'); ?>
	<meta charset="utf-8">
<!--	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />    
    <meta name="csrf-token" content="{{ csrf_token() }}" />
	<title>Neopaed</title>

	<!-- Bootstrap -->
	<link href="{{ $site_url }}/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

	<!-- jQuery UI -->
	<!--<link href="/plugins/jquery-ui/jquery-ui-1.10.2.custom.css" rel="stylesheet" type="text/css" />-->
	<!--[if lt IE 9]>
		<link rel="stylesheet" type="text/css" href="/plugins/jquery-ui/jquery.ui.1.10.2.ie.css"/>
	<![endif]-->

	<!-- Theme -->
	<link href="{{ $site_url }}/css/main.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css" />
	<link href="{{ $site_url }}/css/plugins.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css" />    
	<link href="{{ $site_url }}/css/responsive.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css" />
	<link href="{{ $site_url }}/css/icons.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css" />
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
	<link href="{{ $site_url }}/css/custom.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css" />

	<link rel="stylesheet" href="{{ $site_url }}/css/fontawesome/font-awesome.min.css">

	<script type="text/javascript" src="{{ $site_url }}/js/libs/jquery-1.10.2.min.js"></script>
<!--	<script type="text/javascript" src="/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script> -->

	<script type="text/javascript" src="{{ $site_url }}/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="{{ $site_url }}/js/libs/lodash.compat.min.js"></script>
	<script type="text/javascript" src="{{ $site_url }}/js/libs/breakpoints.js"></script>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
    	<script>
	$(document).ready(function(){
		"use strict";
		App.init(); // Init layout and core plugins
	});
		</script>
</head>
<body class="theme-dark login">
	<header class="header navbar navbar-fixed-top" role="banner">
		<!-- Top Navigation Bar -->
		<div class="container">

			<!-- Only visible on smartphones, menu toggle -->
			<ul class="nav navbar-nav">
				<li class="nav-toggle"><a href="javascript:void(0);" title=""><i class="fa fa fa-reorder"></i></a></li>
			</ul>

			<!-- Logo -->
			<a class="navbar-brand" href="{{ url('/') }}">
				<img src="{{ $site_url }}/img/neonatal_logo.png" alt="logo" width="50px" height="50px" />
				<strong>Neo</strong>natal
			</a>
			<!-- /logo -->
			<!-- Top Right Menu -->
			<ul class="nav navbar-nav navbar-right" style="padding: 14px;">
                @if (Auth::guest())
                    <li><a href="{{ url('/login') }}">Login</a></li>
                    <!--<li><a href="/auth/register">Register</a></li>  -->
                @endif
			</ul>
			<!-- /Top Right Menu -->
		</div>
		<!-- /top navigation bar -->
	</header>
    <div id="container">
        @if (Auth::guest())
			<div class="container">
            	@yield('content')
			</div>
			<!-- /.container -->
		@endif
	</div>
	<!-- Scripts --> 
	<!--=== JavaScript ===-->

    
    <script type="text/javascript" src="{{ $site_url }}/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="{{ $site_url }}/js/sisyphus.js"></script>
	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
		<script src="/js/libs/html5shiv.js"></script>
	<![endif]-->

	<!-- Smartphone Touch Events -->
<!--	<script type="text/javascript" src="/plugins/touchpunch/jquery.ui.touch-punch.min.js"></script>
	<script type="text/javascript" src="/plugins/event.swipe/jquery.event.move.js"></script>
	<script type="text/javascript" src="/plugins/event.swipe/jquery.event.swipe.js"></script>
-->	<!-- General -->

<!--	<script type="text/javascript" src="/plugins/respond/respond.min.js"></script> <!-- Polyfill for min/max-width CSS3 Media Queries (only for IE8) -->
	<script type="text/javascript" src="{{ $site_url }}/plugins/cookie/jquery.cookie.min.js"></script>
	<!-- <script type="text/javascript" src="{{ $site_url }}/plugins/slimscroll/jquery.slimscroll.min.js"></script> -->
	<!-- <script type="text/javascript" src="{{ $site_url }}/plugins/slimscroll/jquery.slimscroll.horizontal.min.js"></script> -->

	<!-- App -->
	<script type="text/javascript" src="{{ $site_url }}/js/app.js?rev=<?php echo time();?>"></script>
	<script type="text/javascript" src="{{ $site_url }}/js/plugins.js?rev=<?php echo time();?>"></script>
	<script type="text/javascript" src="{{ $site_url }}/js/plugins.form-components.js?rev=<?php echo time();?>"></script>
	<script>
	$(document).ready(function(){
		"use strict";
		Plugins.init(); // Init all plugins
		FormComponents.init(); // Init all form-specific plugins
	});
	</script>
	<!-- Demo JS -->
	<!-- <script type="text/javascript" src="{{ $site_url }}/js/custom.js?rev=<?php echo time();?>"></script>     -->
	<!-- <script src="{{ $site_url }}/js/scripts.js?rev=<?php echo time();?>"></script>         -->
    @yield('scripts')  
</body>
</html>