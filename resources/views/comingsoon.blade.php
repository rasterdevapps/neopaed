<?php
$site_url =  url().'/public';
?>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <title>Login</title>
    <!--=== CSS ===-->
    <!-- Bootstrap -->
    <link href="{{ $site_url}}/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme -->
    <link href="{{ $site_url}}/css/main.css" rel="stylesheet" type="text/css" />
    <link href="{{ $site_url}}//css/plugins.css" rel="stylesheet" type="text/css" />
    <!--	<link href="/css/plugins.css" rel="stylesheet" type="text/css" /> -->
    <link href="{{ $site_url}}/css/responsive.css" rel="stylesheet" type="text/css" />
    <link href="{{ $site_url}}/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="{{ $site_url}}/css/error.css" rel="stylesheet" type="text/css" />

    <!-- Login -->
    <link href="{{ $site_url}}/css/login.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ $site_url}}/css/fontawesome/font-awesome.min.css">
    <link href='{{ $site_url}}/css/google-font.css' rel='stylesheet' type='text/css' >

    <!--=== JavaScript ===-->
</head>
<body class="error">
<!--=== Error Title ===-->
<div class="title">
    <h1>404</h1> <!-- You can use something like <h1 class="red">500</h1> for other error codes -->
</div>
<!-- /Error Title -->

<div class="actions">
    <div class="list-group">
        <li class="list-group-item list-group-header align-center">
            Ooops! It looks like you have taken a wrong turn.
        </li>
        <a href="{{ url('/') }}" class="list-group-item"><i class="icon-home"></i> Go to Dashboard <i class="icon-angle-right align-right"></i></a>

    </div>
</div>

<!-- Footer -->

<!-- /Footer -->
</body>
<script type="text/javascript" src="/js/libs/jquery-1.10.2.min.js"></script>

<script type="text/javascript" src="/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/libs/lodash.compat.min.js"></script>

<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="assets/js/libs/html5shiv.js"></script>
<![endif]-->

<!-- Beautiful Checkboxes -->
<script type="text/javascript" src="/plugins/uniform/jquery.uniform.min.js"></script>

<!-- Form Validation -->
<script type="text/javascript" src="/plugins/validation/jquery.validate.min.js"></script>

<!-- Slim Progress Bars -->
<script type="text/javascript" src="/plugins/nprogress/nprogress.js"></script>

<!-- App -->
<script type="text/javascript" src="/js/login.js"></script>
<script>
    $(document).ready(function(){
        "use strict";

        Login.init(); // Init login JavaScript
    });
</script>
</html>