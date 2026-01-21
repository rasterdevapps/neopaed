<?php
$site_url = url('/').'/public';
?>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
    <title>Login</title>
    <link rel="shortcut icon" href="<?php echo e($site_url, false); ?>/img/neonatal_logo.png" />
    <!--=== CSS ===-->
    <!-- Bootstrap -->
    <link href="<?php echo e($site_url, false); ?>/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <!-- Theme -->
    <link href="<?php echo e($site_url, false); ?>/css/main.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css"/>
    <!--    <link href="/css/plugins.css" rel="stylesheet" type="text/css" /> -->
    <link href="<?php echo e($site_url, false); ?>/css/responsive.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo e($site_url, false); ?>/css/icons.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css"/>
    <!-- Login -->
    <link href="<?php echo e($site_url, false); ?>/css/login.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="<?php echo e($site_url, false); ?>/css/fontawesome/font-awesome.min.css">
    <link href='<?php echo e($site_url, false); ?>/css/google-font.css' rel='stylesheet' type='text/css'>
    <!--=== JavaScript ===-->
</head>
<body class="login">
    <!-- Login Box -->
    <div class="box">
        <div class="box-content">
            <div class="logo-content text-center">
                <img src="<?php echo e($site_url, false); ?>/img/neonatal_logo.png" class="project-logo" /> <br/>
                <!-- <h1><strong>Neo</strong>paed</h1> -->
                <!-- Login Formular -->
                <?php echo Form::open(['method' => 'POST','url' => 'login','class'=>'form-vertical login-form']); ?>

                <!-- Logo -->
                <div class="logo">
                    <img src="<?php echo e($site_url, false); ?>/img/sks_logo.png" alt="logo" width="250px" height="100%" />
                </div>
                <!-- /Logo -->
                <!-- Title -->
                <h3 class="form-title">Please login to your account</h3>
                <!-- Error Message -->
                <?php if(count($errors) > 0): ?>
                <div class="alert fade in alert-danger">
                    <i class="fa fa-remove close" data-dismiss="alert"></i>
                    <?php echo $errors->first(); ?>

                </div>
                <?php endif; ?>
                <!-- Input Fields -->
                <div class="form-group">
                    <!--<label for="username">Username:</label>-->
                    <div class="input-icon">
                        <i class="fa fa-user"></i>
                        <input type="text" name="email" class="form-control" placeholder="Username" autofocus
                        data-rule-required="true" data-msg-required="Please enter your username."/>
                    </div>
                </div>
                <div class="form-group">
                    <!--<label for="password">Password:</label>-->
                    <div class="input-icon">
                        <i class="fa fa-lock"></i>
                        <input type="password" name="password" class="form-control" placeholder="Password"
                        data-rule-required="true" data-msg-required="Please enter your password."/>
                    </div>
                </div>
                <!-- /Input Fields -->
                <!-- Form Actions -->
                <div class="form-actions">
                    <!--<label class="checkbox pull-left"><input type="checkbox" class="uniform" name="remember"> Remember me</label>-->
                    <button type="submit" class="submit btn btn-success pull-right btn-block">
                        Sign In <i class="fa fa-angle-right"></i>
                    </button>
                </div>
                <?php echo Form::close(); ?>

                <!-- /Login Formular -->
                <!-- /.content -->
                <!-- Forgot Password Form -->
                <div class="inner-box">
                    <div class="content">
                        <!-- Close Button -->
                        <i class="fa fa-remove close hide-default"></i>
                        <!-- Link as Toggle Button -->
                        <a href="<?php echo e(url('/password/reset'), false); ?>" class="">Forgot Password?</a>
                    </div>
                    <!-- /.content -->
                </div>
                <!-- /Forgot Password Form -->
            </div>
        </div>
        <a href="https://www.raster.in/" style="display: flex; flex-direction: row; align-items: flex-end; color: black;"><img src="<?php echo e($site_url, false); ?>/img/raster_logo.svg" alt="Company" /><span style="padding: 0px 10px;">Raster Images (P) Ltd.</span></a>
    </div>
    <!-- /Login Box -->
</body>
<script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/libs/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/libs/lodash.compat.min.js"></script>
<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="assets/js/libs/html5shiv.js"></script>
<![endif]-->
<!-- Beautiful Checkboxes -->
<script type="text/javascript" src="<?php echo e($site_url, false); ?>/plugins/uniform/jquery.uniform.min.js"></script>
<!-- Form Validation -->
<script type="text/javascript" src="<?php echo e($site_url, false); ?>/plugins/validation/jquery.validate.min.js"></script>
<!-- Slim Progress Bars -->
<script type="text/javascript" src="<?php echo e($site_url, false); ?>/plugins/nprogress/nprogress.js"></script>
<!-- App -->
<script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/login.js?rev=<?php echo time();?>"></script>
<script>
        /*$(document).ready(function(){
            "use strict";
        
            Login.init(); // Init login JavaScript
        });*/
    </script>
    </html>
