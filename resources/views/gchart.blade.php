
<!DOCTYPE html>
	@php
	 $site_url = url('/').'/public';
	 $specialPermission = \Session::get('specialPermissions');
	 $permissions=session('menu_permission');
	@endphp
<html>
<head>
	<!-- Bootstrap -->
	<link href="{{ $site_url }}/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="{{ $site_url }}/css/selectwithtext.css?rev=<?php echo time();?>"/>
    <link rel="shortcut icon" href="{{ $site_url }}/img/logo.png" />

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
<!-- 	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
 -->	
    <link href="{{ $site_url }}/css/custom.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css" />
	<link href="{{ $site_url }}/plugins/toastr-master/build/toastr.css" rel="stylesheet" type="text/css" />
    <link href="{{ $site_url }}/plugins/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link href="{{ $site_url }}/plugins/bootstrap-inputtags/bootstrap-tagsinput.css" rel="stylesheet" type="text/css"/>
    <link href="{{ $site_url }}/plugins/Bootstrap-Horizontal-Selector/css/horizontal_selector.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css"/>
	<link href="{{ $site_url }}/css/fontawesome/font-awesome.min.css" rel="stylesheet">
	<link href="{{ $site_url }}/css/customized.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css">
    <link href="{{ $site_url }}/plugins/duallistboxes/bootstrap-duallistbox.css" rel="stylesheet" type="text/css">
   
	<script type="text/javascript" src="{{ $site_url }}/js/libs/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="{{ $site_url }}/js/libs/jquery-ui.min.js" ></script>
	<script type="text/javascript" src="{{ $site_url }}/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="{{ $site_url }}/js/libs/lodash.compat.min.js"></script>
	<script type="text/javascript" src="{{ $site_url }}/js/libs/breakpoints.js"></script>
    <script type="text/javascript" src="{{ $site_url }}/plugins/bootstrap-switch/bootstrap-switch.js"></script>
    
	<title>
	Scroll test 
	</title>
</head>

<body style=" background: lightblue;">
        <canvas id="canvas" width="1240px" height="880px" style="background: #fff;margin:20px;"></canvas>
        <script type="text/javascript" language="javascript">
    var gestation = 37;
    var value     = 21;    	
    var bw = 1220;
    var bh = 860;
    var p = 10;
    var cw = bw + (p*2) + 1;
    var ch = bh + (p*2) + 1;
    var t =bw/gestation; 

    var canvas = document.getElementById("canvas");
    var context = canvas.getContext("2d");
    function drawBoard(){
    // for (var x = 0; x <= bw; x += 10) {
    //     context.moveTo(0.5 + x + p, p);
    //     context.lineTo(0.5 + x + p, bh + p);
    //     context.lineWidth = 1;
    // }

     for (var x = 0; x <= bw; x += t) {
        context.moveTo(0.5 + t + p, p);
        context.lineTo(0.5 + t + p, bh + p);
        context.lineWidth = 1;
    }

    // for (var x = 0; x <= bw; x += 6) {
    //     context.moveTo(0.5 + x + 5, 5);
    //     context.lineTo(0.5 + x + 5, bh + 5);
    // }


    for (var x = 0; x <= bh; x += 19) {
        context.moveTo(p, 0.5 + x + p);
        context.lineTo(bw + p, 0.5 + x + p);
        context.lineWidth = 1;
    }

    // for (var x = 0; x <= bh; x += 10) {
    //     context.moveTo(5, 0.5 + x + 5);
    //     context.lineTo(bw + 5, 0.5 + x + 5);
    // }

    context.strokeStyle = "black";
    context.stroke();
    }

    drawBoard();

    </script>

</body>
</html>