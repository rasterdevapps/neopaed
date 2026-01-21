<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        $site_url = url('/').'/public';
        $specialPermission = \Session::get('specialPermissions');
        $permissions=session('menu_permission');
        $role_id = Auth::user()->RoleId;
        ?>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        <meta name="csrf-token" content="<?php echo e(csrf_token(), false); ?>" />
        <title>DEMO || Neopaed</title>
        <link rel="shortcut icon" href="<?php echo e($site_url, false); ?>/img/neonatal_logo.png" />
        <meta name="site-orgin" content="<?php echo e(url('/'), false); ?>">
        <!-- Bootstrap -->
        <link href="<?php echo e($site_url, false); ?>/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme -->
        <link href="<?php echo e($site_url, false); ?>/css/main.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo e($site_url, false); ?>/css/fontawesome/font-awesome.min.css" rel="stylesheet">
        <link href="<?php echo e($site_url, false); ?>/plugins/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet">
        <link href="<?php echo e($site_url, false); ?>/plugins/bootstrap-inputtags/bootstrap-tagsinput.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo e($site_url, false); ?>/plugins/Bootstrap-Horizontal-Selector/css/horizontal_selector.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo e($site_url, false); ?>/plugins/toastr-master/build/toastr.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo e($site_url, false); ?>/css/plugins.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo e($site_url, false); ?>/plugins/duallistbox/dual-listbox.css" rel="stylesheet" type="text/css">
        <?php if(Request::segment(1) == 'appointment-calendar'): ?>
        <link  href="<?php echo e($site_url, false); ?>/plugins/calen-style/src/calenstyle.css" rel="stylesheet" type="text/css"/>
        <link  href="<?php echo e($site_url, false); ?>/plugins/calen-style/src/calenstyle-iconfont.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo e($site_url, false); ?>/css/calendar.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css" />
        <?php endif; ?>
        <link href="<?php echo e($site_url, false); ?>/css/custom.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="<?php echo e($site_url, false); ?>/css/selectwithtext.css"/>
        <link href="<?php echo e($site_url, false); ?>/css/responsive.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo e($site_url, false); ?>/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo e($site_url, false); ?>/css/plugins/select2.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo e($site_url, false); ?>/css/customized.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css">
        <link href="<?php echo e($site_url, false); ?>/css/modal.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css" />
        <?php if(Request::segment(1) == 'ward-dashboard'): ?>
        <link href="<?php echo e($site_url, false); ?>/css/ward-dashboard.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css" />
        <?php endif; ?>
        <link href="<?php echo e($site_url, false); ?>/css/sidenav.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo e($site_url, false); ?>/css/dashboard.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css" />
        <?php if(Request::segment(1) == 'growthchart-view' || Request::segment(1) == 'growthchartzerotofive'): ?>
        <link href="<?php echo e($site_url, false); ?>/css/growthchart.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css" />
        <?php endif; ?>
        <?php if(Request::segment(1) == 'quality-indicator'): ?>
        <link href="<?php echo e($site_url, false); ?>/css/baby-form-create.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css" />
        <?php endif; ?>
        <!-- <link href="<?php echo e($site_url, false); ?>/css/complaint-modal.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css" /> -->
        <?php if((Request::segment(1) == 'prescription' && Request::segment(2) != 'create') || Request::segment(1) == 'prescription-generate'): ?>
        <link rel="stylesheet" href="<?php echo e($site_url, false); ?>/css/circle.css?rev=<?php echo time();?>">
        <link rel="stylesheet" href="<?php echo e($site_url, false); ?>/css/pump_prescription.css?rev=<?php echo time();?>">
        <?php endif; ?>
        <?php if(Request::segment(1) == 'neuro-develop'): ?>
        <link rel="stylesheet" href="<?php echo e($site_url, false); ?>/css/ddst_chart.css?rev=<?php echo time();?>">
        <link rel="stylesheet" href="<?php echo e($site_url, false); ?>/css/bayley.css?rev=<?php echo time();?>">
        <?php endif; ?>
        <?php if(Request::segment(1) == 'neonatal'): ?>
        <link href="<?php echo e($site_url, false); ?>/css/neonatal-proforma.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css" />
        <?php endif; ?>
        <?php if(Request::segment(1) == 'nicu-admission' || Request::segment(1) == 'nicu-discharge-main-list'): ?>
        <link href="<?php echo e($site_url, false); ?>/css/nicu.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css" />
        <?php endif; ?>
        <link href="<?php echo e($site_url, false); ?>/css/table-responsive.css" rel="stylesheet" type="text/css" />
        <?php if(Request::segment(1) == 'nurse-nicu-daycare'): ?>
        <link href="<?php echo e($site_url, false); ?>/css/nurse-daily-entry-form.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css" />
        <?php endif; ?>
        <?php if(Request::segment(1) == 'postanatal-admission'): ?>
        <link href="<?php echo e($site_url, false); ?>/css/postnatal.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css" />
        <?php endif; ?>
        <link href="<?php echo e($site_url, false); ?>/css/settings.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo e($site_url, false); ?>/css/customized-responsive.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="<?php echo e($site_url, false); ?>/plugins/context-menu/dist/jquery.contextMenu.min.css">
        <?php if(Request::segment(1) == 'nicu-nurse-sheets'): ?>
        <link  href="<?php echo e($site_url, false); ?>/css/nicu-nurse-sheets.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css"/>
        <link  href="<?php echo e($site_url, false); ?>/css/mdtimepicker.min.css" rel="stylesheet" type="text/css">
        <?php endif; ?>	
        <?php if(Request::segment(1) == 'out-patient' || (Request::segment(1) == 'neuro-develop' && Request::segment(3) == 'edit') || (Request::segment(1) == 'nicu-nurse-sheets' && Request::segment(3) == 'edit') || (Request::segment(1) == 'nicu-admission' && Request::segment(3) == 'edit') || (Request::segment(1) == 'daycare-admission' && Request::segment(3) == 'edit') || Request::segment(1) == 'nicu-discharge' || (Request::segment(1) == 'pediatric-admission' && Request::segment(3) == 'edit')): ?>
        <link href="<?php echo e($site_url, false); ?>/css/bootstrap-fileinput/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="<?php echo e($site_url, false); ?>/css/media.css?rev=<?php echo time();?>">
        <?php endif; ?>
	    <?php if(Request::segment(1) == 'tpn-calculator'): ?>
            <link  href="<?php echo e($site_url, false); ?>/css/tpn_calculator.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css"/>
        <?php endif; ?>
        <?php if(Request::segment(2) == 'vaccine-chart' || (Request::segment(1) == 'out-patient' && (Request::segment(2) == 'create' || Request::segment(3) == 'edit')) || (Request::segment(1) == 'pediatric-out-patient' && (Request::segment(2) == 'create' || Request::segment(3) == 'edit'))): ?>
            <link  href="<?php echo e($site_url, false); ?>/css/vaccine_chart_view.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css"/>
        <?php endif; ?>
        <link href="<?php echo e($site_url, false); ?>/js/timedropper.min.css" rel="stylesheet" type="text/css" />
        <?php if(Request::segment(1) == 'site'): ?>
        <link  href="<?php echo e($site_url, false); ?>/css/plugins/croppie.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css" />
        <?php endif; ?>
        <?php if(Request::segment(1) == 'live-chart'): ?>
            <link rel="stylesheet" type="text/css" href="<?php echo e($site_url, false); ?>/css/live_chart.css">
        <?php endif; ?>

        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/libs/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/libs/jquery-ui.min.js" ></script>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/libs/lodash.compat.min.js"></script>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/libs/breakpoints.js"></script>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/plugins/bootstrap-switch/bootstrap-switch.js"></script>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/timedropper.js"></script>
        <!-- calendar test -->
        <?php if(Request::segment(1) == 'appointment-calendar'): ?>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/plugins/calen-style/src/calenstyle.js"></script>
        <?php endif; ?>
        <!-- calendar test -->
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/plugins/context-menu/dist/jquery.contextMenu.min.js"></script>
        <?php if(Request::segment(1) == 'problems-settings'): ?>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/drag-drop.min.js"></script>
        <?php endif; ?>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/plugins/select2/select2.min.js"></script> <!-- Styled select boxes -->
        <?php $echo_port = env('LARAVEL_ECHO_PORT'); ?>
	    <script>
            window.laravel_echo_port = '<?php echo e($echo_port, false); ?>';
        </script>
        <?php $socket_is_connected = true; ?>
        <?php if(Request::segment(1) == 'prescription' || Request::segment(1) == 'ward-dashboard' || Request::segment(1) == 'ward-dashboard-view'): ?>
            <?php $ward_folder = substr($_SERVER['REMOTE_ADDR'], 0, 4) == '172.' ?>
            <?php if($ward_folder): ?>
                <script type="text/javascript" src="http://172.16.7.211:6001/socket.io/socket.io.js"></script>
                <script>window.laravel_echo_port = '6001';</script>
            <?php else: ?>
                <script type="text/javascript" src="http://neopaed.sks.net.in:90/socket.io/socket.io.js"></script>
                <script>window.laravel_echo_port = '90';</script>
            <?php endif; ?>
            <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/laravel-echo-setup.js"></script>
        <?php endif; ?>
        <?php if(Request::segment(1) == 'prescription' && Request::segment(2) != 'create'): ?>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/prescription.js"></script>
        <?php endif; ?>
        <?php if(Request::segment(1) == 'ward-dashboard'): ?>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/ward-dashboard.js"></script>
        <?php endif; ?>
        <?php if(Request::segment(1) == 'users' || Request::segment(1) == 'profile'): ?>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/signature_pad.min.js"></script>
        <?php endif; ?>
       <!--  <script type="text/javascript">
            function togglebuttons(id) {
              var selfsrc = $('#'+id);
              var options = selfsrc.children('option');
              var buttons = '';
              $.each(options,function(index, opt) {
                 if (opt.selected){   
                  var active = 'active';
              }              
              buttons +="<button type='button' class='btn btn-default box-button "+active+"' data-togselect='"+id+"' value='"+opt.value+"'>"+opt.text+"</button>";                
            });
              var btnGroup = $("<div class='btn-group'>").append(buttons);
              selfsrc.after(btnGroup);
              selfsrc.hide();
            
            }           
            
            $(document).on('click','.box-button',function() {
              var activeBtn = $(this).siblings(".active");
              activeBtn.removeClass('active');
              $(this).addClass('active');
              var ids = $(this).data('togselect');    
              var parents = $('select[name="'+ids+'"]');
              parents.children("option:selected").prop("selected", false);
              parents.val($(this).val()).trigger('change');
            });
            
        </script> -->
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script>
            $(document).ready(function() {
                "use strict";
                App.init(); // Init layout and core plugins 
            
                $(".toggle-sidebar").click(function(){
                    $(".wrapper").toggleClass("active");
                    $("#notification-footer").toggleClass("full-width-must").toggleClass("start-at-left");
                });
                $("#content").click(function() {
                    $(".wrapper").addClass("active");
                });
            });         
        </script>
        <style>
            @media  screen and (min-width: 300px) and (max-width : 376px) {
                .navbar .nav>li>a>span {
                    padding-left: 0px !important;
                    margin-left: 1px !important;
                }

                i {
                    padding-left: 0px !important;
                }
            }

            body::-webkit-scrollbar {
                width: 1em !important;
            }

            body::-webkit-scrollbar-track {
                -webkit-box-shadow: 5px 1px 8px -3px rgba(0, 0, 0, 0.4) !important;
            }

            body::-webkit-scrollbar-thumb {
                background-color: var(--theme-color) !important;
                outline: 1px solid #00050a !important;
            }
        </style>
    </head>
    <body class="theme-dark">
        <header class="header navbar navbar-fixed-top" role="banner">
            <!-- Top Navigation Bar -->
            <div class="container">
                <!-- Only visible on smartphones, menu toggle -->
                <ul class="nav navbar-nav hide">
                    <li class="nav-toggle">
                        <a href="javascript:void(0);">
                        <i class="fa fa fa-reorder"></i>
                        </a>
                    </li>
                </ul>
                <!-- Logo -->
                <a class="navbar-brand custom-logo-container" href="<?php echo e(url('/'), false); ?>">
                <img class="logo-image" src="<?php echo e($site_url, false); ?>/img/neonatal_logo.png" width="50px" height="50px" alt="logo" />
                <strong><?php echo e(env('APP_NAME'), false); ?> </strong>
                <small> (3.10)</small>
                </a>
                <!-- /logo -->
                <!-- Sidebar Toggler -->
                <a href="#" class="toggle-sidebar header-icons hover-fx" data-placement="bottom" data-original-title="Toggle navigation" style="margin-left: 0px !important;">
                <i class="fa fa-reorder"></i>
                </a>
                <!-- /Sidebar Toggler -->
                <!-- Top Left Menu -->
                <?php if(Auth::guest()): ?>
                <?php else: ?>
                <ul class="nav navbar-nav navbar-left">
                    <li>
                        <a href="<?php echo e(url('/'), false); ?>/" class="header-icons hover-fx" title="Home" style="margin-top: 12px !important; margin-left: 10px !important; padding-top: 1px !important; padding-left: 4px !important;" rel="external">
                        <i class="fa fa-home nav-home-icon-size"></i>
                        <span></span>
                        </a>
                    </li>
                    <?php if(is_array($permissions) && in_array('WARD_MANAGEMENT',$permissions)): ?>   
                        <li>
                            <a href="<?php echo e(url('ward-dashboard/'), false); ?>" class="header-icons hover-fx" title="Ward Dashboard" style="margin-top: 12px !important;padding-top: 5px; padding-left: 3px;padding-right: 28px !important; margin-left: 9px !important;" rel="external">
                            <i class="fas fa-bed nav-home-icon-size" style="font-size: 20px;"></i>
                            <span></span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <!-- /Top Left Menu -->
                <?php endif; ?>
                <!-- Top Right Menu -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- User Login Dropdown -->
                    <?php if(Auth::guest()): ?>
                    <li>
                        <a href="<?php echo e(url('/login'), false); ?>">Login</a>
                    </li>
                    <!--<li><a href="/register">Register</a></li>  -->
                    <?php else: ?>
                    <li class="dropdown user admin-profile">
                        <a href="#" class="dropdown-toggle header-icons hover-fx" data-toggle="dropdown" style="padding-top: 4px; margin-top: 8px !important;" title="Profile">
                            <!-- <span class="icons-wrapper icons-wrapper-alt rounded-circle">
                                <span class="icons-wrapper-bg"></span> -->
                            <i class="fas fa-user-tie fa-2x"></i>
                            <!-- </span> -->
                            <!-- <i class="fa fa-male"></i>
                                <span class="username"><?php echo e(Auth::user()->name, false); ?></span>
                                <i class="fa fa-caret-down small"></i> -->
                        </a>
                        <ul class="dropdown-menu master-drop-down">
                            <li class="p-10 title" title="Logged in as">
                                <i class="fa fa-user"></i> <?php echo e(Auth::user()->name, false); ?>

                            </li>
                            <li>
                                <a href="<?php echo e(url('/profile'), false); ?>">
                                <i class="fa fa-male"></i> <?php echo e(Lang::get('menu.top_menu_my_profile'), false); ?>

                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(url('/logout'), false); ?>">
                                <i class="fa fa-key"></i><?php echo e(Lang::get('menu.top_menu_log_out'), false); ?>

                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- /user login dropdown -->
                    <?php endif; ?>
                </ul>
                <ul class="nav navbar-nav navbar-right data-content ">
                    <!-- User Login Dropdown -->
                    <?php if(Auth::guest()): ?>
                    <?php else: ?>
                    <?php if(is_array($permissions) && count(array_intersect(['USER_GROUPS','USERS','MAS_PROBLEM_SETTING', 'SITESETTING'],$permissions))>0): ?>
                    <li class="dropdown settings">
                        <a href="#" class="dropdown-toggle header-icons hover-fx" data-toggle="dropdown" style="padding-top: 4px; margin-top: 8px !important;" title="Settings">
                            <!-- <span class="icons-wrapper icons-wrapper-alt rounded-circle">
                                <span class="icons-wrapper-bg"></span> -->
                            <i class="fa fa-cog fa-2x"></i>
                            <!-- </span> -->
                        </a>
                        <ul class="dropdown-menu master-drop-down">
                            <li class="title">
                                <span><?php echo e(Lang::get('menu.top_menu_settings'), false); ?></span>
                            </li>
                            <?php if(in_array('USER_GROUPS',$permissions)): ?>
                            <li>
                                <a href="<?php echo e(action('Settings\UsergroupController@index'), false); ?>">
                                <i class="fa fa-group"></i> 
                                <span><?php echo e(Lang::get('menu.top_menu_usergroups'), false); ?></span>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if(in_array('USERS',$permissions)): ?>
                            <li>
                                <a href="<?php echo e(action('Settings\UserController@index'), false); ?>">&nbsp;
                                <i class="fa fa-male"></i> 
                                <span class="master_users"><?php echo e(Lang::get('menu.top_menu_users'), false); ?></span>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if(in_array('SITESETTING',$permissions)): ?>
                            <li class="">
                                <a href="<?php echo e(action('Settings\SiteController@edit'), false); ?>">&nbsp;
                                <i class="fa fa-cog"></i> 
                                <span><?php echo e(Lang::get('menu.top_menu_site_settings'), false); ?></span>
                                </a>
                            </li>
                            <?php endif; ?>
                            <!-- <li class="hide" >
                                <a href="<?php echo e(action('Settings\SiteSettingController@index'), false); ?>">&nbsp;
                                <i class="fa fa-cog"></i> 
                                <span><?php echo e(Lang::get('menu.top_menu_site_settings'), false); ?></span>
                                </a>
                                </li> -->
                            <?php if(in_array('MAS_PROBLEM_SETTING',$permissions)): ?>   
                            <li>
                                <a href="<?php echo e(action('ProblemsSettings\ProblemsSettingController@index'), false); ?>">
                                <i class="fa fa-cogs" aria-hidden="true"></i>
                                <span><?php echo e(Lang::get('menu.top_menu_psite_settings'), false); ?></span>
                                </a>
                            </li>
                            <?php endif; ?>
                            <!-- <li><a href="<?php echo e(action('Settings\ComplaintsController@index'), false); ?>">&nbsp;<i class="fa fa-comments"></i> <span>Complaints</span></a></li> -->
                        </ul>
                    </li>
                    <?php endif; ?>
                    <!-- /user login dropdown -->
                    <?php endif; ?>
                </ul>
                <ul class="nav navbar-nav navbar-right" title="Masters">
                    <?php if(Auth::guest()): ?>
                    <?php else: ?>
                    <?php if(is_array($permissions) && count(array_intersect(['MAS_ANTIBIOTICS','MAS_COMPLICATIONS','MAS_M_PROBLEM','MAS_B_PROCEDUURE','MAS_B_PROBLEM','MAS_VACCINE','MAS_VACCINE_AGE','MAS_INDICATION','MAS_DOCTORS','MAS_ADMISSIONMODE','MAS_RESPIRATORYINDICATION','MAS_PROBLEM_SETTING','MAS_NURSE_LIST','MAS_REFERRAL','MAS_WARD','MAS_BED','MAS_FREQUENCY','MAS_DOSE','MAS_DRUG_IVFLUID','MAS_PRESCRIPTION_TYPE', 'MAS_DDST', 'MAS_BAYLEY_SCALE', 'MAS_SHORTCODE', 'MAS_ISSA_QUESTIONS'],$permissions))>0): ?>
                    <li class="dropdown masters">
                        <a href="#" class="dropdown-toggle header-icons hover-fx" data-toggle="dropdown" style="padding-top: 4px; margin-top: 8px !important;" title="Masters">
                            <!-- <span class="icons-wrapper icons-wrapper-alt rounded-circle">
                                <span class="icons-wrapper-bg"></span> -->
                            <i class="fa fa-database fa-2x"></i>
                            <!-- </span> -->
                        </a>
                        <ul class="dropdown-menu master-drop-down">
                            <li class="title">
                                <span><?php echo e(Lang::get('menu.top_menu_masters'), false); ?></span>
                            </li>
                            <?php if(in_array('MAS_ANTIBIOTICS',$permissions)): ?>
                            <li class="hide">
                                <a href="<?php echo e(action('Masters\AntibioticController@index'), false); ?>"><?php echo e(Lang::get('menu.top_menu_antibiotics'), false); ?></a>
                            </li>
                            <?php endif; ?>
                            <?php if(in_array('MAS_COMPLICATIONS',$permissions)): ?> 
                            <li>
                                <a href="<?php echo e(action('Masters\ComplicationController@index'), false); ?>"><?php echo e(Lang::get('menu.top_menu_complications'), false); ?></a>
                            </li>
                            <?php endif; ?>
                            <!--   <?php if(in_array('MAS_DRUGS',$permissions)): ?> 
                                <li>
                                <a href="<?php echo e(action('Masters\DrugController@index'), false); ?>"><?php echo e(Lang::get('menu.top_menu_drugs'), false); ?></a>
                                </li>
                                <?php endif; ?> -->
                            <?php if(in_array('MAS_M_PROBLEM',$permissions)): ?> 
                            <li>
                                <a href="<?php echo e(action('Masters\MediprobsController@index'), false); ?>"><?php echo e(Lang::get('menu.top_menu_medical_problems'), false); ?></a>
                            </li>
                            <?php endif; ?>
                            <?php if(in_array('MAS_B_PROCEDUURE',$permissions)): ?>  
                            <li>
                                <a href="<?php echo e(action('Masters\ProcedureController@index'), false); ?>"><?php echo e(Lang::get('menu.top_menu_procedures'), false); ?></a>
                            </li>
                            <?php endif; ?>
                            <?php if(in_array('MAS_B_PROBLEM',$permissions)): ?> 
                            <li>
                                <a href="<?php echo e(action('Masters\ProblemController@index'), false); ?>"><?php echo e(Lang::get('menu.top_menu_problems'), false); ?></a>
                            </li>
                            <?php endif; ?>
                            <?php if(in_array('MAS_VACCINE_AGE',$permissions)): ?>   
                            <li>
                                <a href="<?php echo e(action('Masters\VaccineAgeController@index'), false); ?>"><?php echo e(Lang::get('menu.top_menu_vaccine_age'), false); ?></a>
                            </li>
                            <?php endif; ?>
                            <?php if(in_array('MAS_VACCINE',$permissions)): ?>   
                            <li>
                                <a href="<?php echo e(action('Masters\VaccineController@index'), false); ?>"><?php echo e(Lang::get('menu.top_menu_vaccines'), false); ?></a>
                            </li>
                            <?php endif; ?>
                            <?php if(in_array('REPORT_NICU',$permissions)): ?>   
                            <li>
                                <a href="<?php echo e(action('Admission\IcdController@index'), false); ?>"><?php echo e(Lang::get('menu.top_menu_icd_10'), false); ?></a>
                            </li>
                            <?php endif; ?>
                            <?php if(in_array('MAS_INDICATION',$permissions)): ?>    
                            <li>
                                <a href="<?php echo e(action('Masters\IndicationController@index'), false); ?>"><?php echo e(Lang::get('menu.top_menu_indication'), false); ?></a>
                            </li>
                            <?php endif; ?>
                            <?php if(in_array('MAS_DOCTORS',$permissions)): ?>   
                            <li>
                                <a href="<?php echo e(action('Masters\DoctorController@index'), false); ?>"><?php echo e(Lang::get('menu.top_menu_doctors_surgeons'), false); ?></a>
                            </li>
                            <?php endif; ?>
                            <?php if(in_array('MAS_ADMISSIONMODE',$permissions)): ?> 
                            <li>
                                <a href="<?php echo e(action('Masters\AdmissionmodeController@index'), false); ?>"><?php echo e(Lang::get('menu.top_menu_admission_mode'), false); ?></a>
                            </li>
                            <?php endif; ?>
                            <?php if(in_array('MAS_RESPIRATORYINDICATION',$permissions)): ?> 
                            <li>
                                <a href="<?php echo e(action('Masters\RespiratoryIndicationController@index'), false); ?>"><?php echo e(Lang::get('menu.top_menu_respiratory_indication'), false); ?></a>
                            </li>
                            <?php endif; ?>
                            <!--     <?php if(in_array('MAS_IVFLUIDS',$permissions)): ?>  
                                <li>
                                <a href="<?php echo e(action('Masters\IvFluidsController@index'), false); ?>"><?php echo e(Lang::get('menu.top_menu_iv_fluid_med'), false); ?></a>
                                </li>
                                <?php endif; ?> -->
                            <?php if(in_array('MAS_NURSE_LIST',$permissions)): ?>    
                            <li>
                                <a href="<?php echo e(action('Masters\NurseController@index'), false); ?>"><?php echo e(Lang::get('menu.top_menu_nurse_master'), false); ?></a>
                            </li>
                            <?php endif; ?>
                            <?php if(in_array('MAS_REFERRAL',$permissions)): ?>    
                            <li>
                                <a href="<?php echo e(action('Masters\ReferralController@index'), false); ?>"><?php echo e(Lang::get('menu.top_menu_referral'), false); ?></a>
                            </li>
                            <?php endif; ?>
                            <?php if(in_array('MAS_WARD',$permissions)): ?> 
                            <li>
                                <a href="<?php echo e(action('Masters\WardController@index'), false); ?>"><?php echo e(Lang::get('menu.top_menu_ward'), false); ?></a>
                            </li>
                            <?php endif; ?>
                            <?php if(in_array('MAS_BED',$permissions)): ?>  
                            <li>
                                <a href="<?php echo e(action('Masters\BedController@index'), false); ?>"><?php echo e(Lang::get('menu.top_menu_bed'), false); ?></a>
                            </li>
                            <?php endif; ?>
                            <?php if(in_array('MAS_FREQUENCY', $permissions)): ?>
                            <li>
                                <a href="<?php echo e(action('Masters\FrequencyController@index'), false); ?>"><?php echo e(Lang::get('menu.top_menu_freq'), false); ?></a>
                            </li>
                            <?php endif; ?>
                            <?php if(in_array('MAS_DOSE', $permissions)): ?>
                            <li>
                                <a href="<?php echo e(action('Masters\DoseController@index'), false); ?>"><?php echo e(Lang::get('menu.top_menu_dose'), false); ?></a>
                            </li>
                            <?php endif; ?>
                            <?php if(in_array('MAS_DRUG_IVFLUID', $permissions)): ?>
                            <li>
                                <a href="<?php echo e(action('Masters\DrugIvFluidController@index'), false); ?>"><?php echo e(Lang::get('menu.top_menu_drugivfluid'), false); ?></a>
                            </li>
                            <?php endif; ?>
                            <?php if(in_array('MAS_PRESCRIPTION_TYPE', $permissions)): ?>
                            <li>
                                <a href="<?php echo e(action('Masters\PrescriptionTypeController@index'), false); ?>"><?php echo e(Lang::get('menu.top_menu_prescriptiontype'), false); ?></a>
                            </li>
                            <?php endif; ?>
                            <?php if(in_array('MAS_INVESTIGATIONS', $permissions)): ?>
                            <li>
                                <a href="<?php echo e(action('Masters\InvestigationsController@index'), false); ?>"><?php echo e(Lang::get('menu.top_menu_investigations'), false); ?></a>
                            </li>
                            <?php endif; ?>
                            <?php if(in_array('MAS_M_CHAT_R_QUESTIONS', $permissions)): ?>
                            <li>
                                <a href="<?php echo e(action('Masters\MchatquestionsController@index'), false); ?>"><?php echo e(Lang::get('menu.top_menu_m_chat_r_questions'), false); ?></a>
                            </li>
                            <?php endif; ?>
                            <?php if(in_array('MAS_M_CHAT_R_FOLLOWUP_QUESTIONS', $permissions)): ?>
                            <li>
                                <a href="<?php echo e(action('Masters\MchatfollowupquestionsController@index'), false); ?>"><?php echo e(Lang::get('menu.top_menu_m_chat_r_followup_questions'), false); ?></a>
                            </li>
                            <?php endif; ?>
                            <?php if(in_array('MAS_DASII_QUESTIONS', $permissions)): ?>
                            <li>
                                <a href="<?php echo e(action('Masters\DasiiquestionsController@index'), false); ?>"><?php echo e(Lang::get('menu.top_menu_dasii_questions'), false); ?></a>
                            </li>
                            <?php endif; ?>
                            <?php if(in_array('MAS_CBCL_QUESTIONS', $permissions)): ?>
                            <li>
                                <a href="<?php echo e(action('Masters\CBCLQuestionsController@index'), false); ?>"><?php echo e(Lang::get('menu.top_menu_cbcl_questions'), false); ?></a>
                            </li>
                            <?php endif; ?>
                            <?php if(in_array('MAS_DDST', $permissions)): ?>
                            <li>
                                <a href="<?php echo e(action('Masters\DdstController@index'), false); ?>"><?php echo e(Lang::get('menu.top_menu_ddst_questions'), false); ?></a>
                            </li>
                            <?php endif; ?>
                            <?php if(in_array('MAS_BAYLEY_SCALE', $permissions)): ?>
                            <li>
                                <a href="<?php echo e(action('Masters\BayleyScaleController@index'), false); ?>"><?php echo e(Lang::get('menu.top_menu_bayley_scale'), false); ?></a>
                            </li>
                            <?php endif; ?>
                            <?php if(in_array('MAS_ISSA_QUESTIONS', $permissions)): ?>
                            <li>
                                <a href="<?php echo e(action('Masters\ISSAQuestionsController@index'), false); ?>"><?php echo e(Lang::get('menu.top_menu_issa_questions'), false); ?></a>
                            </li>
                            <?php endif; ?>
                            <?php if(in_array('MAS_SHORTCODE', $permissions)): ?>
                            <li>
                                <a href="<?php echo e(action('Masters\ShortcodeController@index'), false); ?>"><?php echo e(Lang::get('menu.top_menu_shortcode'), false); ?></a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                    <?php endif; ?>                                   
                    <?php endif; ?>
                </ul>
                <!-- /Top Right Menu -->
                <?php if(Auth::guest()): ?>
                <?php else: ?>
                <!-- <ul class="nav navbar-nav new-register flow-con hidden-xs hidden-sm">
                    <li>
                    <a href="javascript:void(0);" id="new-patinent">
                    <i class="fa fa fa-plus"></i><span>Registration / Admission</span>
                    </a>
                    </li>
                    </ul> -->
                <?php if(count(array_intersect(['NICU_DAY','POST_DAY'], \Session::get('write_permission'))) > 0): ?>
                <!-- <ul class="nav navbar-nav hidden-xs  flow-con hidden-sm">
                    <li>
                    <a href="javascript:void(0);" id="daily-care">
                    <i class="fa fa-table"></i><span>Daily Entry</span>
                    </a>
                    </li>
                    </ul> -->
                <?php endif; ?>
                <?php if(count(array_intersect(['NICU_MODULE_SHEET'], \Session::get('write_permission'))) > 0): ?>
                <!-- <ul class="nav navbar-nav hidden-xs  flow-con hidden-sm">
                    <li>
                    <a href="javascript:void(0);" id="nurse-daily-care">
                    <i class="fa fa-table"></i><span>Nurse Daily Entry</span>
                    </a>
                    </li>
                    </ul> -->
                <?php endif; ?>
                <?php if(count(array_intersect(['NICU_PROBLEM_DAY','POST_PROBLEM_SYSTEM'], \Session::get('write_permission'))) > 0): ?>
                <!-- <ul class="nav navbar-nav hidden-xs flow-con hide hidden-sm">
                    <li>
                    <a href="javascript:void(0);" id="problem-based-entry">
                    <i class="fa fa-heartbeat"></i><span>Problem Sheet</span>
                    </a>
                    </li>
                    </ul> -->
                <?php endif; ?>
                <?php if(count(array_intersect(['NICU_DISCHARGE','POST_DISCHARGE'], \Session::get('write_permission'))) > 0): ?>
                <!-- <ul class="nav navbar-nav hidden-xs flow-con hidden-sm">
                    <li>
                    <a hhref="javascript:void(0);" id="discharge-details">
                    <i class="fa fa-dashboard"></i><span>Discharge / Transfer</span>
                    </a>
                    </li>
                    </ul> -->
                <?php endif; ?>  
                <!-- <ul class="nav navbar-nav navbar-right">
                    <li style="margin: 3px 0px;">
                        <a href="#" id="add-complaints" class="header-icons hover-fx" title="Complaints" style="padding-top: 4px; margin-top: 8px !important;">
                        <i class="fa fa-comments fa-2x" aria-hidden="true"></i>
                        </a>
                    </li>
                </ul> -->
                 <ul class="nav navbar-nav navbar-right">
                    <li style="margin: 3px 0px;">
                        <a href="<?php echo e(action('HomeController@search'), false); ?>" class="header-icons hover-fx" title="Reports search" style="padding-top: 4px; margin-top: 8px !important;">
                            <i class="fa fa-file fa-2x" aria-hidden="true"></i><i class="fa fa-search file-search-icon"></i>
                        </a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li style="margin: 3px 0px;">
                        <a href="<?php echo e(action('HomeController@getTimelinePage'), false); ?>" class="header-icons hover-fx" title="Software Timeline" style="padding-top: 4px; margin-top: 8px !important;">
                            <i class="fa fa-list fa-2x"></i>
                        </a>
                    </li>
                </ul>
                
                <ul class="nav navbar-nav notify border-left-none info-menu-icon">
                    <?php $notification = SiteHelpers::getFlownotification(); ?>
                    <?php if(Request::segment(1) == 'neonatal-search' || Request::segment(1) == 'nicu-search' 
                    || Request::segment(1) == 'nicu-admission-search-view' || Request::segment(1)=='daycare-search' ||
                    Request::segment(1) == 'daycare-search-box-view'|| Request::segment(1)=='quality-indicator-searchview' || Request::segment(1)=='quality-indicator-search'): ?>
                    <li class="dropdown user hidden-xs" >
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-info" aria-hidden="true"></i>                       
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="javascript:void(0);">
                                <b>Character & Words </b>
                                </a>
                            <li>
                                <a href="javascript:void(0);" class="remove-highlight"> &equals; match whole word (or match empty)</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="remove-highlight"> &equals;&equals; match entire field</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="remove-highlight"> &ldquo;&ldquo; match phrase (from word start) </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="remove-highlight"> &ast;&ldquo;&ldquo; match phrase (from anywhere) </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="remove-highlight"> &commat; any one character </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="remove-highlight"> ! find duplicate values</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="remove-highlight hide"> &ast; zero or more character </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="remove-highlight hide"> &bsol; escape next character </a>
                            </li>
                            </li>
                            <li>
                                <a href="javascript:void(0);"><b>Numbers</b></a>
                            <li>
                                <a href="javascript:void(0);" class="remove-highlight"> &lt; less than </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="remove-highlight"> &le; less than or equal</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="remove-highlight"> &gt; greater than</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="remove-highlight"> &ge; greater than or equal</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="remove-highlight"> &num; any one digit </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="remove-highlight"> &hellip; range</a>
                            </li>
                            </li>
                            <li>
                                <a href="javascript:void(0);"><b>Date</b></a>
                            <li>
                                <a href="javascript:void(0);" class="remove-highlight"> &num; any one digit </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="remove-highlight"> &sol;&sol; today's date </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="remove-highlight"> &quest; invalid date or time </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="remove-highlight"> &hellip; range</a>
                            </li>
                            </li>
                        </ul>
                    </li>
                    <?php endif; ?>
                </ul>
                <?php endif; ?>
            </div>
            <!-- /top navigation bar -->
        </header>
        <div id="container" class="">
            <?php if(Auth::guest()): ?>
            <div id="content">
                <div class="container">
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
                <!-- /.container -->
            </div>
            <?php else: ?>    
            <div class="wrapper active">
                <div class="side-bar">
                    <ul>
                        <div class="menu">
                            <?php if(is_array($permissions) && count(array_intersect(['MOTHER_REG','BABY_REG'],$permissions))>0): ?>
                            <li class="submenu <?php echo e((isset($navigate) && $navigate['main_nav']=='register') ? 'open' : '', false); ?>">
                                <a href="javascript:void(0);">
                                <i class="fas fa-registered pull-right" style="font-size: 20px;"></i><?php echo e(Lang::get('menu.side_menu_registartion'), false); ?>

                                </a>
                                <ul class="sub-menu">
                                    <li class="title">
                                        <span><?php echo e(Lang::get('menu.side_menu_registartion'), false); ?></span>
                                    </li>
                                    <?php if(in_array('MOTHER_REG',$permissions)): ?>
                                    <li class="<?php echo e((isset($navigate) && $navigate['sub_nav']=='mother') ? 'current' : '', false); ?>">
                                        <a href="<?php echo e(action('Registration\MotherController@index'), false); ?>" >
                                        <i class="fa fa-female pull-right"></i>
                                        <?php echo e(Lang::get('menu.side_menu_mother_registartion'), false); ?>

                                        </a>
                                    </li>
                                    <?php endif; ?>
                                    <?php if(in_array('BABY_REG',$permissions)): ?>
                                    <li class="<?php echo e((isset($navigate) && $navigate['sub_nav']=='baby') ? 'current' : '', false); ?>">
                                        <a href="<?php echo e(action('Registration\BabyController@index'), false); ?>">
                                        <i class="fas fa-baby-carriage pull-right" style="font-size: 14px;"></i>
                                        <?php echo e(Lang::get('menu.side_menu_baby_registartion'), false); ?>

                                        </a>
                                    </li>
                                    <?php endif; ?>              
                                </ul>
                            </li>
                            <?php endif; ?>
                            <?php if(in_array('NEONATAL',$permissions)): ?>
                            <li class="submenu <?php echo e((isset($navigate) && $navigate['main_nav']=='neo_proforma') ? 'open' : '', false); ?>">
                                <a href="<?php echo e(action('Registration\NeonatalController@index'), false); ?>">
                                <i class="fas fa-baby pull-right" style="font-size: 26px;"></i>
                                <?php echo e(Lang::get('menu.side_menu_neonatal_proforma'), false); ?>

                                </a>
                                <ul class="sub-menu">
                                    <li class="title module">
                                        <a href="<?php echo e(action('Registration\NeonatalController@index'), false); ?>">
                                        <?php echo e(Lang::get('menu.side_menu_neonatal_proforma'), false); ?>

                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <?php endif; ?>
                            <?php if(is_array($permissions) && count(array_intersect(['MOTHER_REG','BABY_REG','NEONATAL'],$permissions))>0): ?>
                            <li class="menu-separate"></li>
                            <?php endif; ?>
                            <?php if(is_array($permissions) && count(array_intersect(['NICU_FORM','NICU_DAY', 'NICU_PROBLEM_DAY','NICU_DISCHARGE','NICU_PROBLEM_DISCHARGE'],$permissions))>0): ?>
                            <li class="submenu <?php echo e((isset($navigate) && $navigate['main_nav']=='nicu') ? 'open' : '', false); ?>">
                                <a href="javascript:void(0);">
                                <i class="fas fa-dolly-flatbed pull-right custom-menu-icon-size" style="font-size: 16px !important;"></i>
                                <?php echo e(Lang::get('menu.side_menu_nicu_admission'), false); ?> <img src="data:image/svg+xml;utf8,<svg fill='white' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/><path d='M0 0h24v24H0z' fill='none'/></svg>" class="<?php echo e((isset($navigate) && $navigate['main_nav']=='nicu') ? 'transform-180' : '', false); ?>" />
                                </a>
                                <ul class="sub-menu">
                                    <li class="title">
                                        <span><?php echo e(Lang::get('menu.side_menu_nicu_admission'), false); ?></span>
                                    </li>
                                    <?php if(in_array('NICU_FORM',$permissions)): ?>
                                    <li class="<?php if(isset($navigate) && $navigate['sub_nav']=='nicu_proforma'): ?>current <?php endif; ?>">
                                        <a href="<?php echo e(action('Admission\NicuController@index'), false); ?>">
                                        <i class="fas fa-book-medical pull-right" style="font-size: 17px;"></i>
                                        <?php echo e(Lang::get('menu.side_menu_nicu_admission_proforma'), false); ?>

                                        </a>
                                    </li>
                                    <?php endif; ?>
                                    <?php if(in_array('NICU_DAY',$permissions)): ?>
                                    <li class="<?php if(isset($navigate) && $navigate['sub_nav']=='nicu_daycare'): ?>current <?php endif; ?>">
                                        <a href="<?php echo e(action('Admission\DaycareController@index'), false); ?>">
                                        <i class="fas fa-user-md pull-right" style="font-size: 16px;"></i>
                                        <?php echo e(Lang::get('menu.side_menu_nicu_daycare'), false); ?>

                                        </a>
                                    </li>
                                    <?php endif; ?>
                                    <?php if(in_array('NICU_PROBLEM_DAY',$permissions)): ?>
                                    <li class="<?php if(isset($navigate) && $navigate['sub_nav']=='nicu_problem_base'): ?> current <?php endif; ?>">
                                        <a href="<?php echo e(action('ProblemBaseDaycare\ProblemDaycareController@index'), false); ?>">
                                        <i class="fas fa-notes-medical pull-right" style="font-size: 18px !important;"></i>
                                        <?php echo e(Lang::get('menu.side_menu_problem_base_daycare'), false); ?>

                                        </a>
                                    </li>
                                    <?php endif; ?>
                                    <?php if(in_array('NICU_DISCHARGE',$permissions)): ?>
                                    <li class="<?php if(isset($navigate) && $navigate['sub_nav']=='discharge-list'): ?> current <?php endif; ?>">
                                        <a href="<?php echo e(action('Admission\NicuController@dischargeList'), false); ?>">
                                        <i class="fas fa-user-clock pull-right custom-menu-icon-size" style="font-size: 13px !important;"></i>
                                        <?php echo e(Lang::get('menu.side_menu_nicu_discharge_details'), false); ?>

                                        </a>
                                    </li>
                                    <?php endif; ?>
                                    <?php if(in_array('NICU_DISCHARGE',$permissions)): ?>                         
                                    <!-- <li class="<?php if(isset($navigate) && $navigate['sub_nav']=='nicu_discharge'): ?> current <?php endif; ?>">
                                        <a href="<?php echo e(action('Reports\NicuDischargeController@discharge_main_list'), false); ?>/interim">
                                        <img src="<?php echo e($site_url, false); ?>/img/icons/menu/medical_notes.png" class="pull-right" alt="Interim Summary ( Daycare )" width="20" height="40"> 
                                        <?php echo e(Lang::get('menu.side_menu_daycare_interim_summary'), false); ?>

                                        </a>
                                        </li> -->
                                    <?php endif; ?>
                                    <?php if(in_array('NICU_DISCHARGE',$permissions)): ?>                         
                                    <li class="<?php if(isset($navigate) && $navigate['sub_nav']=='nicu_discharge'): ?> current <?php endif; ?>">
                                        <a href="<?php echo e(action('Reports\NicuDischargeController@discharge_main_list'), false); ?>">
                                        <i class="fas fa-sticky-note pull-right custom-menu-icon-size"></i>
                                        <?php echo e(Lang::get('menu.side_menu_nicu_discharge_summary'), false); ?>

                                        </a>
                                    </li>
                                    <?php endif; ?>  
                                    <?php if(in_array('NICU_PROBLEM_DISCHARGE',$permissions)): ?>                         
                                    <!-- <li class="<?php if(isset($navigate) && $navigate['sub_nav']=='problem_nicu_discharge'): ?>current <?php endif; ?>">
                                        <a href="<?php echo e(action('Reports\ProblemDischargeController@dischargeBabylist'), false); ?>/interim">
                                        <img src="<?php echo e($site_url, false); ?>/img/icons/menu/problem_base_discharge.png" class="pull-right" alt="NICU Discharge Summary Probelm base" width="22" height="20">
                                        <?php echo e(Lang::get('menu.side_menu_problem_interim_summary'), false); ?>

                                        </a> -->
                                    </li>
                                    <?php endif; ?>  
                                    <?php if(in_array('NICU_PROBLEM_DISCHARGE',$permissions)): ?>                         
                                    <li class="<?php if(isset($navigate) && $navigate['sub_nav']=='problem_nicu_discharge'): ?>current <?php endif; ?>">
                                        <a href="<?php echo e(action('Reports\ProblemDischargeController@dischargeBabylist'), false); ?>">
                                        <i class="fas fa-list-alt pull-right custom-menu-icon-size"></i>
                                        <?php echo e(Lang::get('menu.side_menu_nicu_problem_summary'), false); ?>

                                        </a>
                                    </li>
                                    <?php endif; ?>  
                                </ul>
                            </li>
                            <?php endif; ?>
                            <?php if(is_array($permissions) && in_array('NICU_NURSE_DAY',$permissions)): ?>   
                            <!-- <li class="submenu <?php echo e((isset($navigate) && $navigate['main_nav']=='nicu_nurse_day') ? 'open' : '', false); ?>">
                                <a href="<?php echo e(action('Nurse\NicuNurseDaycareController@index'), false); ?>">
                                    <i class="fas fa-edit pull-right custom-menu-icon-size" style="font-size: 16px !important;"></i>
                                    <?php echo e(Lang::get('menu.side_menu_nurse_daycare'), false); ?>

                                </a>
                                <ul class="sub-menu">
                                    <li class="title module">
                                        <a href="<?php echo e(action('Nurse\NicuNurseDaycareController@index'), false); ?>">
                                            <?php echo e(Lang::get('menu.side_menu_nurse_daycare'), false); ?>

                                        </a>
                                    </li>
                                </ul>
                                </li> -->
                            <?php endif; ?> 
                            <?php if(is_array($permissions) && in_array('NICU_MODULE_SHEET',$permissions)): ?>   
                            <li class="submenu <?php echo e((isset($navigate) && $navigate['main_nav']=='nicu_nurse_sheet') ? 'open' : '', false); ?>">
                                <a href="<?php echo e(action('Nurse\NurseSheetController@index'), false); ?>">
                                <i class="fas fa-user-nurse pull-right" style="font-size: 23px !important"></i>
                                <?php echo e(Lang::get('menu.side_menu_nurse_hourly_sheet'), false); ?>

                                </a>
                                <ul class="sub-menu">
                                    <li class="title module">
                                        <a href="<?php echo e(action('Nurse\NurseSheetController@index'), false); ?>">
                                        <?php echo e(Lang::get('menu.side_menu_nurse_hourly_sheet'), false); ?>

                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <?php endif; ?>  
                            <?php if(is_array($permissions) && count(array_intersect(['PEDI_FORM'],$permissions))>0): ?>
                            <li class="submenu <?php echo e((isset($navigate) && $navigate['main_nav']=='pediatric') ? 'open' : '', false); ?>">
                                <a href="<?php echo e(action('Admission\PediatricController@index'), false); ?>">
                                <i class="fas fa-child pull-right" style="font-size: 23px !important"></i>
                                <?php echo e(Lang::get('menu.side_menu_pediatric_admission'), false); ?>

                                </a>
                                <ul class="sub-menu">
                                    <li class="title module">
                                        <a href="<?php echo e(action('Admission\PediatricController@index'), false); ?>">
                                        <?php echo e(Lang::get('menu.side_menu_pediatric_admission'), false); ?>

                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <?php endif; ?>
                            <?php if(is_array($permissions) && in_array('WARD_MANAGEMENT',$permissions)): ?>   
                            <li class="submenu <?php echo e((isset($navigate) && $navigate['main_nav']=='ward-dashboard') ? 'open' : '', false); ?>">
                                <a href="<?php echo e(action('Ward\BabyWardController@index'), false); ?>">
                                <i class="fas fa-bed pull-right custom-menu-icon-size" aria-hidden="true" style="font-size: 16px !important"></i>
                                <?php echo e(Lang::get('menu.card_ward_mangagement'), false); ?>

                                </a>
                                <ul class="sub-menu">
                                    <li class="title module">
                                        <a href="<?php echo e(action('Ward\BabyWardController@index'), false); ?>">
                                        <?php echo e(Lang::get('menu.card_ward_mangagement'), false); ?>

                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <?php endif; ?>  
                            <?php if(is_array($permissions) && in_array('PRESCRIPTION',\Session::get('write_permission'))): ?>   
                            <li class="submenu <?php echo e((isset($navigate) && $navigate['main_nav']=='prescription') ? 'open' : '', false); ?>">
                                <a href="<?php echo e(action('prescription\PrescriptionController@create'), false); ?>">
                                <?php echo e(Lang::get('menu.side_menu_prescription'), false); ?>  
                                <i class="fas fa-prescription pull-right" style="padding: 0px 2px;font-size: 21px;"></i>
                                </a>
                                <ul class="sub-menu">
                                    <li class="title module">
                                        <a href="<?php echo e(action('prescription\PrescriptionController@create'), false); ?>">
                                        <?php echo e(Lang::get('menu.side_menu_prescription'), false); ?> 
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <?php endif; ?>    
                            <?php if(is_array($permissions) && in_array('CLINICAL_EVENT',\Session::get('write_permission'))): ?>   
                            <li class="submenu <?php echo e((isset($navigate) && $navigate['main_nav'] == 'Events') ? 'open' : '', false); ?>">
                                <a href="javascript:void(0);">
                                <i class="fas fa-first-aid pull-right" style="font-size: 18px;"></i>
                                Events <img src="data:image/svg+xml;utf8,<svg fill='white' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/><path d='M0 0h24v24H0z' fill='none'/></svg>" class="<?php echo e((isset($navigate) && $navigate['main_nav']=='nicu') ? 'transform-180' : '', false); ?>" />
                                </a>
                                <ul class="sub-menu">
                                    <li class="title">
                                        <span>Events</span>
                                    </li>
                                    <li class="submenu <?php echo e((isset($navigate) && $navigate['sub_nav'] == 'Care Event') ? 'open' : '', false); ?>">
                                        <a href="<?php echo e(action('Nurse\DashboardEventController@index'), false); ?>">
                                        <?php echo e(Lang::get('menu.side_menu_nicu_care_events'), false); ?> 
                                        <i class="fa fa-thumb-tack pull-right" style="font-size: 18px; transform: rotate(45deg);"></i>
                                        </a>
                                    </li>
                                    <li class="submenu <?php echo e((isset($navigate) && $navigate['sub_nav'] == 'Clinical Event') ? 'open' : '', false); ?>">
                                        <a href="<?php echo e(action('ClinicalEventController@create'), false); ?>">
                                        <i class="fas fa-first-aid pull-right" style="font-size: 16px;"></i>
                                        <?php echo e(Lang::get('menu.side_menu_nicu_clinical_events'), false); ?> 
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <?php endif; ?>    
                            <?php if(is_array($permissions) && in_array('WARD_MANAGEMENT',$permissions)): ?>   
                            <?php if(env('MONITOR_INTERFACE') || env('VENTILATOR_MACHINE') || env('LAB_INTERFACE')): ?>
                            <li class="submenu <?php echo e((isset($navigate) && $navigate['main_nav']=='interface_log') ? 'open' : '', false); ?>">
                                <a href="javascript:void(0);">
                                <i class="fa fa-desktop pull-right custom-menu-icon-size" style="font-size: 18px !important"></i>
                                <?php echo e(Lang::get('menu.side_menu_interface_data'), false); ?> <img src="data:image/svg+xml;utf8,<svg fill='white' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/><path d='M0 0h24v24H0z' fill='none'/></svg>" class="<?php echo e((isset($navigate) && $navigate['main_nav']=='nicu') ? 'transform-180' : '', false); ?>" />
                                </a>
                                <ul class="sub-menu">
                                    <li class="title">
                                        <span><?php echo e(Lang::get('menu.side_menu_interface_data'), false); ?></span>
                                    </li>
                                    <li class="<?php echo e((isset($navigate) && $navigate['sub_nav']=='interface_monitor') ? 'current' : '', false); ?>">
                                        <a href="<?php echo e(action('Fhir\FhirFormattedValuesController@monitordata'), false); ?>">
                                        <i class="fas fa-pager pull-right" style="font-size: 16px;"></i>
                                        <?php echo e(Lang::get('menu.side_menu_monitor'), false); ?>

                                        </a>
                                    </li>
                                    <li class="<?php echo e((isset($navigate) && $navigate['sub_nav']=='interface_ventilator') ? 'current' : '', false); ?>">
                                        <a href="<?php echo e(action('Fhir\FhirFormattedValuesController@ventilatordata'), false); ?>">
                                        <i class="fas fa-lungs pull-right" style="font-size: 14px;"></i>
                                        <?php echo e(Lang::get('menu.side_menu_ventilator'), false); ?>

                                        </a>
                                    </li>
                                    <li class="<?php echo e((isset($navigate) && $navigate['sub_nav']=='interface_prescription') ? 'current' : '', false); ?>">
                                        <a href="<?php echo e(action('Fhir\FhirFormattedValuesController@pumpdata'), false); ?>">
                                        <i class="fas fa-syringe pull-right" style="font-size: 16px;"></i>
                                        <?php echo e(Lang::get('menu.side_menu_pump'), false); ?>

                                        </a>
                                    </li>
                                    <?php if(env('SUPER_ADMIN_ROLE') == $role_id): ?>
                                    <li class="">
                                        <a href="<?php echo e(action('LocalCodeGroupController@index'), false); ?>">
                                        <i class="fa fa-code pull-right" style="font-size: 16px;"></i>
                                        Local Code Group
                                        </a>
                                    </li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                            <?php endif; ?>  
                            <?php endif; ?>  
                            <?php if(is_array($permissions) && count(array_intersect(['GROWTH_CHART','NICU_MODULE_SHEET'],$permissions))>0): ?>
                            <li class="submenu <?php echo e((isset($navigate) && $navigate['main_nav']=='chart') ? 'open' : '', false); ?>">
                                <a href="javascript:void(0);">    
                                <i class="fas fa-pie-chart pull-right" style="font-size: 19px"></i>
                                Chart <img src="data:image/svg+xml;utf8,<svg fill='white' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/><path d='M0 0h24v24H0z' fill='none'/></svg>" class="<?php echo e((isset($navigate) && $navigate['main_nav']=='nicu') ? 'transform-180' : '', false); ?>" />
                                </a>
                                <ul class="sub-menu">
                                    <li class="title">
                                        <span>Chart</span>
                                    </li>
                                    <?php if(in_array('GROWTH_CHART',$permissions)): ?>                    
                                    <li class="<?php echo e((isset($navigate) && $navigate['sub_nav']=='growth_chart') ? 'current' : '', false); ?>">
                                        <a href="<?php echo e(action('Growthchart\GrowthChartController@index'), false); ?>">
                                        <i class="fa fa-sort-amount-asc pull-right" aria-hidden="true" style="transform: rotate(180deg); font-size: 14px;"></i>
                                        <?php echo e(Lang::get('menu.side_menu_growth_chart'), false); ?>

                                        </a>
                                    </li>
                                    <?php endif; ?>   
                                    <?php if(in_array('NICU_MODULE_SHEET',$permissions)): ?>
                                    <li class="<?php echo e((isset($navigate) && $navigate['sub_nav']=='single_chart') ? 'current' : '', false); ?>">
                                        <a href="<?php echo e(action('Nurse\NurseSheetController@chartBabySelect'), false); ?>" class="" data-placement="right" data-title="Single Chart">
                                        <i class="fa fa-line-chart pull-right" style="font-size: 13px;" aria-hidden="true"></i>
                                        Single Chart
                                        </a>
                                    </li>
                                    <?php endif; ?>
                                    <?php if(in_array('NICU_MODULE_SHEET',$permissions)): ?>
                                    <li class="<?php echo e((isset($navigate) && $navigate['sub_nav']=='all_in_one_chart') ? 'current' : '', false); ?>">
                                        <a href="<?php echo e(action('Nurse\NurseSheetController@allInOneChartBabySelect'), false); ?>" class="" data-placement="right" data-title="All-In-One Chart">
                                        <i class="fa fa-area-chart pull-right" style="font-size: 13px;" aria-hidden="true"></i>
                                        All-In-One Chart
                                        </a>
                                    </li>
                                    <?php endif; ?>                                    
                                </ul>
                            </li>
                            <?php endif; ?>
                            <?php if(is_array($permissions) && in_array('LABREQUEST',$permissions)): ?>   
                            <li class="submenu <?php echo e((isset($navigate) && $navigate['main_nav']=='lab_reports') ? 'open' : '', false); ?>">
                                <a href="javascript:void(0);">    
                                <i class="fa fa-flask pull-right" aria-hidden="true"></i>
                                Lab Report <img src="data:image/svg+xml;utf8,<svg fill='white' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/><path d='M0 0h24v24H0z' fill='none'/></svg>" class="<?php echo e((isset($navigate) && $navigate['main_nav']=='nicu') ? 'transform-180' : '', false); ?>" />
                                </a>
                                <ul class="sub-menu">
                                    <li class="title">
                                        <span>Lab Report</span>
                                    </li>
                                    <li class="<?php echo e((isset($navigate) && $navigate['sub_nav']=='lab_report') ? 'current' : '', false); ?>">
                                        <a href="<?php echo e(action('Nurse\NurseSheetController@labBabySelect'), false); ?>">
                                        <i class="fa fa-flask pull-right" aria-hidden="true"></i>
                                        Admission Wise Report
                                        </a>
                                    </li>
                                    <li class="<?php echo e((isset($navigate) && $navigate['sub_nav']=='lab_report_all') ? 'current' : '', false); ?>">
                                        <a href="<?php echo e(action('Nurse\NurseSheetController@labBabySelect', 'overall'), false); ?>" class="" data-placement="right" data-title="Single Chart">
                                        <i class="fa fa-flask pull-right" aria-hidden="true"></i>
                                        Overall Lab Report
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <?php endif; ?> 
                            <?php if(is_array($permissions) && in_array('NICU_MODULE_SHEET',$permissions)): ?>   
                            <li class="submenu <?php echo e((isset($navigate) && $navigate['main_nav']=='weekly_observation') ? 'open' : '', false); ?>">
                                <a href="<?php echo e(action('Nurse\NurseSheetController@weeklyObservationBabySelect'), false); ?>">
                                <i class="fa fa-print pull-right" aria-hidden="true"></i>
                                Weekly Observations
                                </a>
                                <ul class="sub-menu">
                                    <li class="title module">
                                        <a href="<?php echo e(action('Nurse\NurseSheetController@weeklyObservationBabySelect'), false); ?>">
                                        Weekly Observations
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <?php endif; ?>  
                            <?php if(is_array($permissions) && count(array_intersect(['NICU_FORM','NICU_DAY', 'NICU_PROBLEM_DAY','NICU_DISCHARGE','NICU_PROBLEM_DISCHARGE','NICU_NURSE_DAY','NICU_MODULE_SHEET','WARD_MANAGEMENT'],$permissions))>0): ?>
                            <li class="menu-separate"></li>
                            <?php endif; ?>
                            <?php if(is_array($permissions) && count(array_intersect(['POST_FORM','POST_DAY','POST_PROBLEM_SYSTEM','POST_DISCHARGE'],$permissions))>0): ?>
                            <li class="submenu <?php echo e((isset($navigate) && $navigate['main_nav']=='postnatal') ? 'open' : '', false); ?>">
                                <a href="javascript:void(0);">    
                                <i class="fas fa-clinic-medical pull-right" style="font-size: 18px;"></i>
                                <?php echo e(Lang::get('menu.side_menu_postnatal_admission'), false); ?> <img src="data:image/svg+xml;utf8,<svg fill='white' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/><path d='M0 0h24v24H0z' fill='none'/></svg>" class="<?php echo e((isset($navigate) && $navigate['main_nav']=='postnatal') ? 'transform-180' : '', false); ?>" />
                                </a>
                                <ul class="sub-menu">
                                    <li class="title">
                                        <span><?php echo e(Lang::get('menu.side_menu_postnatal_admission'), false); ?></span>
                                    </li>
                                    <?php if(in_array('POST_FORM',$permissions)): ?>
                                    <li class="<?php echo e((isset($navigate) && $navigate['sub_nav']=='postnatal_proforma') ? 'current' : '', false); ?>">
                                        <a href="<?php echo e(action('Admission\PostnatalController@index'), false); ?>">
                                        <i class="fas fa-book-medical pull-right" style="font-size: 16px;"></i>
                                        <?php echo e(Lang::get('menu.side_menu_postnatal_admission_form'), false); ?>

                                        </a>
                                    </li>
                                    <?php endif; ?>
                                    <?php if(in_array('POST_DAY',$permissions)): ?>
                                    <li class="<?php echo e((isset($navigate) && $navigate['sub_nav']=='post_daycare') ? 'current' : '', false); ?>">
                                        <a href="<?php echo e(action('Admission\PostnatalDaycareController@index'), false); ?>">
                                        <i class="fa fa-user-md pull-right"></i>
                                        <?php echo e(Lang::get('menu.side_menu_postnatal_daycare'), false); ?>

                                        </a>
                                    </li>
                                    <?php endif; ?>
                                    <?php if(in_array('POST_PROBLEM_SYSTEM',$permissions)): ?>
                                    <li class="<?php echo e((isset($navigate) && $navigate['sub_nav']=='post_problem_system') ? 'current' : '', false); ?>">
                                        <a href="<?php echo e(action('ProblemBaseDaycare\ProblemPostnatalController@index'), false); ?>">
                                        <i class="pull-right fas fa-notes-medical"></i>
                                        <?php echo e(Lang::get('menu.side_menu_postnatal_problem'), false); ?>

                                        </a>
                                    </li>
                                    <?php endif; ?>
                                    <?php if(in_array('POST_DISCHARGE',$permissions)): ?>
                                    <li class="<?php echo e((isset($navigate) && $navigate['sub_nav']=='post_discharge') ? 'current ' : '', false); ?>">
                                        <a href="<?php echo e(action('Admission\PostnatalDischargeController@index'), false); ?>">
                                        <i class="pull-right fas fa-user-clock custom-menu-icon-size" style="font-size: 12px !important;"></i>
                                        <?php echo e(Lang::get('menu.side_menu_postnatal_details'), false); ?>

                                        </a>
                                    </li>
                                    <?php endif; ?> 
                                    <?php if(in_array('POST_DISCHARGE',$permissions)): ?>
                                    <li class="<?php echo e((isset($navigate) && $navigate['sub_nav']=='post_problem_discharge') ? 'current' : '', false); ?> ">
                                        <a href="<?php echo e(action('Reports\PostnatalDischargeSummary@index'), false); ?>">
                                        <i class="pull-right fas fa-sticky-note custom-menu-icon-size" style="font-size: 17px !important;"></i>
                                        <?php echo e(Lang::get('menu.side_menu_postnatal_summary'), false); ?>

                                        </a>
                                    </li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                            <li class="menu-separate"></li>
                            <?php endif; ?>
                            <?php if(in_array('OP_REG',$permissions) || in_array('PEDIATRICS_OP_REG', $permissions) || in_array('NEURO_DEVELOPMENT',$permissions) || in_array('BAYLEY_SCALE',$permissions)): ?>
                            <li class="submenu <?php if(isset($navigate) && $navigate['sub_nav']=='op'): ?> open <?php endif; ?>">
                                <a href="javascript:void(0);">
                                <i class="fa fa-user-md pull-right" style="font-size: 25px;"></i>
                                <?php echo e(Lang::get('menu.side_menu_op_registration'), false); ?> <img src="data:image/svg+xml;utf8,<svg fill='white' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/><path d='M0 0h24v24H0z' fill='none'/></svg>" class="<?php echo e((isset($navigate) && $navigate['main_nav']=='postnatal') ? 'transform-180' : '', false); ?>" />
                                </a>
                                <ul class="sub-menu">
                                    <li class="title">
                                        <span><?php echo e(Lang::get('menu.side_menu_op_registration'), false); ?></span>
                                    </li>
                                    <?php if(in_array('OP_REG',$permissions)): ?>
                                    <li class="<?php echo e((isset($navigate) && $navigate['sub_nav']=='neo') ? 'current' : '', false); ?> ">
                                        <a href="<?php echo e(action('Registration\OpController@index'), false); ?>">
                                        <?php echo e(Lang::get('menu.side_menu_neo_op_registration'), false); ?>

                                        </a>
                                    </li>
                                    <?php endif; ?>   
                                    <?php if(in_array('PEDIATRICS_OP_REG', $permissions)): ?>
                                    <li class="<?php echo e((isset($navigate) && $navigate['sub_nav']=='pediatric') ? 'current' : '', false); ?> ">
                                        <a href="<?php echo e(action('Registration\PediatricOpController@index'), false); ?>">
                                        <?php echo e(Lang::get('menu.side_menu_pediatrics_op_registration'), false); ?>

                                        </a>
                                    </li>
                                    <?php endif; ?>      
                                    <?php if(in_array('NEURO_DEVELOPMENT',$permissions)): ?>
                                    <li class="<?php echo e((isset($navigate) && $navigate['sub_nav']=='neuro') ? 'current' : '', false); ?> ">
                                        <a href="<?php echo e(action('Registration\NeuroController@index'), false); ?>">
                                        <?php echo e(Lang::get('menu.side_menu_neuro'), false); ?>

                                        </a>
                                    </li>
                                    <?php endif; ?>
                                    <?php if(in_array('FEEDING',$permissions)): ?>
                                    <li class="<?php echo e((isset($navigate) && $navigate['sub_nav']=='feeding') ? 'current' : '', false); ?> ">
                                        <a href="<?php echo e(action('Registration\FeedingController@index'), false); ?>">
                                        <?php echo e(Lang::get('menu.side_menu_feeding'), false); ?>

                                        </a>
                                    </li>
                                    <?php endif; ?>  
                                </ul>
                            </li>
                            <li class="menu-separate"></li>
                            <?php endif; ?>
                            <?php if(is_array($permissions) && count(array_intersect(['TEST_ECHO','TEST_ULTRA','TEST_CULTURE'],$permissions))>0): ?>           
                            <li class="submenu <?php echo e((isset($navigate) && $navigate['main_nav']=='tests') ? 'open' : '', false); ?>">
                                <a href="javascript:void(0);">
                                <i class="fa fa-filter pull-right" style="font-size: 24px;"></i>
                                <?php echo e(Lang::get('menu.side_menu_tests'), false); ?> <img src="data:image/svg+xml;utf8,<svg fill='white' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/><path d='M0 0h24v24H0z' fill='none'/></svg>" class="<?php echo e((isset($navigate) && $navigate['main_nav']=='tests') ? 'transform-180' : '', false); ?>" />
                                </a>                    
                                <ul class="sub-menu">
                                    <li class="title">
                                        <span><?php echo e(Lang::get('menu.side_menu_tests'), false); ?></span>
                                    </li>
                                    <?php if(in_array('TEST_ECHO',$permissions)): ?>
                                    <li class="<?php echo e((isset($navigate) && $navigate['sub_nav']=='cardio') ? 'current' : '', false); ?>">
                                        <a href="<?php echo e(action('Extras\CardioController@index'), false); ?>">
                                        <i class="fa fa-life-ring pull-right" style="font-size: 15px;"></i>
                                        <?php echo e(Lang::get('menu.side_menu_test_echocardiography'), false); ?>

                                        </a>
                                    </li>
                                    <?php endif; ?>
                                    <?php if(in_array('TEST_ULTRA',$permissions)): ?>
                                    <li class="<?php echo e((isset($navigate) && $navigate['sub_nav']=='ultra') ? 'current' : '', false); ?>">
                                        <a href="<?php echo e(action('Extras\UltraController@index'), false); ?>">
                                        <i class="fa fa-life-ring pull-right" style="font-size: 15px;"></i>
                                        <?php echo e(Lang::get('menu.side_menu_test_cranial_ultrasonography'), false); ?>

                                        </a>
                                    </li>
                                    <?php endif; ?>
                                    <?php if(in_array('TEST_CULTURE',$permissions)): ?>                       
                                    <li class="<?php echo e((isset($navigate) && $navigate['sub_nav']=='culture') ? 'current' : '', false); ?> ">
                                        <a href="<?php echo e(action('Extras\CultureController@index'), false); ?>">
                                        <i class="fa fa-life-ring pull-right" style="font-size: 15px;"></i>
                                        <?php echo e(Lang::get('menu.side_menu_test_culture_registry'), false); ?>

                                        </a>
                                    </li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                            <?php endif; ?> 
                            <?php if(is_array($permissions) && in_array('QUALITY_INDICATORS',$permissions)): ?>   
                            <li class="submenu <?php echo e((isset($navigate) && $navigate['main_nav']=='quality_indicator') ? 'open' : '', false); ?>">
                                <a href="<?php echo e(action('Quality\QualityController@index'), false); ?>">
                                <i class="fa fa-line-chart pull-right custom-menu-icon-size" aria-hidden="true" style="font-size: 16px !important"></i>
                                <?php echo e(Lang::get('menu.side_menu_quality_indicator'), false); ?>

                                </a>
                                <ul class="sub-menu">
                                    <li class="title module">
                                        <a href="<?php echo e(action('Quality\QualityController@index'), false); ?>">
                                        <?php echo e(Lang::get('menu.side_menu_quality_indicator'), false); ?>

                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <?php endif; ?> 
                            <?php if(is_array($permissions) && count(array_intersect(['REPORT_INPATIENT','REPORT_NICU','REPORT_OP','REPORT_NEWBORN','REPORT_BIRTH','REPORT_ECHO','REPORT_CRANIAL','REPORT_OP_ACTIVITY','REPORT_ANNUAL', 'USAGE_TRACKER'],$permissions))>0): ?> 
                            <li class="submenu <?php echo e((isset($navigate) && $navigate['main_nav']=='report') ? 'open' : '', false); ?>" id="report-nav">
                                <a href="javascript:void(0);">
                                <i class="pull-right fas fa-file-alt" style="font-size: 22px;"></i>
                                <?php echo e(Lang::get('menu.side_menu_reports'), false); ?> <img src="data:image/svg+xml;utf8,<svg fill='white' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/><path d='M0 0h24v24H0z' fill='none'/></svg>" class="<?php echo e((isset($navigate) && $navigate['main_nav']=='report') ? 'transform-180' : '', false); ?>" />
                                </a>
                                <ul class="sub-menu">
                                    <li class="title">
                                        <span><?php echo e(Lang::get('menu.side_menu_reports'), false); ?></span>
                                    </li>
                                    <?php if(in_array('REPORT_BABY',$permissions)): ?>
                                    <li class="<?php echo e((isset($navigate) && $navigate['sub_nav']=='inpatient_report') ? 'current' : '', false); ?>">
                                        <a href="<?php echo e(action('Reports\BabyReportController@index'), false); ?>">
                                        <i class="pull-right fa fa-file-pdf-o" style="font-size: 16px;"></i>
                                        <?php echo e(Lang::get('menu.side_menu_baby_tag_print'), false); ?>

                                        </a>
                                    </li>
                                    <?php endif; ?>
                                    <?php if(in_array('REPORT_INPATIENT',$permissions)): ?>
                                    <li class="<?php echo e((isset($navigate) && $navigate['sub_nav']=='inpatient_report') ? 'current' : '', false); ?>">
                                        <a href="<?php echo e(action('Reports\InpatientListController@index'), false); ?>">
                                        <i class="pull-right fa fa-file-pdf-o" style="font-size: 16px;"></i>
                                        <?php echo e(Lang::get('menu.side_menu_inpatient_report'), false); ?>

                                        </a>
                                    </li>
                                    <?php endif; ?>
                                    <?php if(in_array('REPORT_NICU',$permissions)): ?>
                                    <li class="<?php echo e((isset($navigate) && $navigate['sub_nav']=='nicu_report') ? 'current' : '', false); ?>">
                                        <a href="<?php echo e(action('Reports\NicuReportController@index'), false); ?>">
                                        <i class="pull-right fa fa-file-pdf-o" style="font-size: 16px;"></i>
                                        <?php echo e(Lang::get('menu.side_menu_nicu_report'), false); ?>

                                        </a>
                                    </li>
                                    <?php endif; ?>
                                    <?php if(in_array('REPORT_OP',$permissions)): ?>
                                    <li class="<?php echo e((isset($navigate) && $navigate['sub_nav']=='op_report') ? 'current' : '', false); ?> ">
                                        <a href="<?php echo e(action('Reports\OpReportController@index'), false); ?>">
                                        <i class="pull-right fa fa-file-pdf-o" style="font-size: 16px;"></i>
                                        <?php echo e(Lang::get('menu.side_menu_op_report'), false); ?>

                                        </a>
                                    </li>
                                    <?php endif; ?>
                                    <?php if(in_array('REPORT_PEDI',$permissions)): ?>
                                    <li class="<?php echo e((isset($navigate) && $navigate['sub_nav']=='pediatric_report') ? 'current' : '', false); ?> hide">
                                        <a href="<?php echo e(action('Reports\PediatricReportController@index'), false); ?> ">
                                        <i class="pull-right fa fa-file-pdf-o" style="font-size: 16px;"></i>
                                        <?php echo e(Lang::get('menu.side_menu_pediatric_report'), false); ?>

                                        </a>
                                    </li>
                                    <?php endif; ?>
                                    <?php if(in_array('REPORT_NEWBORN',$permissions)): ?>                                
                                    <li class="<?php echo e((isset($navigate) && $navigate['sub_nav']=='newborn_report') ? 'current' : '', false); ?> ">
                                        <a href="<?php echo e(action('Reports\NbReportController@index'), false); ?>">
                                        <i class="pull-right fa fa-file-pdf-o" style="font-size: 16px;"></i>
                                        <?php echo e(Lang::get('menu.side_menu_newborn_report'), false); ?>

                                        </a>
                                    </li>
                                    <?php endif; ?>
                                    <?php if(in_array('REPORT_CULTURE',$permissions)): ?>                                
                                    <li class="<?php echo e((isset($navigate) && $navigate['sub_nav']=='culture_report') ? 'current' : '', false); ?> hide">
                                        <a href="<?php echo e(action('Reports\CultureReportController@index'), false); ?>">
                                        <i class="pull-right fa fa-file-pdf-o" style="font-size: 16px;"></i>
                                        <?php echo e(Lang::get('menu.side_menu_culture_report'), false); ?>

                                        </a>
                                    </li>
                                    <?php endif; ?>
                                    <?php if(in_array('REPORT_BIRTH',$permissions)): ?>                                
                                    <li class="<?php echo e((isset($navigate) && $navigate['sub_nav']=='birth_report') ? 'current' : '', false); ?>">
                                        <a href="<?php echo e(action('Reports\BirthReportController@index'), false); ?>">
                                        <i class="pull-right fa fa-file-pdf-o" style="font-size: 16px;"></i>
                                        <?php echo e(Lang::get('menu.side_menu_live_birth_report'), false); ?>

                                        </a>
                                    </li>
                                    <?php endif; ?>    
                                    <?php if(in_array('REPORT_ECHO',$permissions)): ?>  
                                    <li class="<?php echo e((isset($navigate) && $navigate['sub_nav']=='echo_report') ? 'current' : '', false); ?>">
                                        <a href="<?php echo e(action('Reports\EchoReportsController@filter'), false); ?>">
                                        <i class="pull-right fa fa-file-pdf-o" style="font-size: 16px;"></i>
                                        <?php echo e(Lang::get('menu.side_menu_echo_report'), false); ?>

                                        </a>
                                    </li>
                                    <?php endif; ?>  
                                    <?php if(in_array('REPORT_CRANIAL',$permissions)): ?>  
                                    <li class="<?php echo e((isset($navigate) && $navigate['sub_nav']=='cranial_report') ? 'current' : '', false); ?>">
                                        <a href="<?php echo e(action('Reports\CranialReportController@filter'), false); ?>">
                                        <i class="pull-right fa fa-file-pdf-o" style="font-size: 16px;"></i>
                                        <?php echo e(Lang::get('menu.side_menu_cranial_report'), false); ?>

                                        </a>
                                    </li>
                                    <?php endif; ?>  
                                    <?php if(in_array('REPORT_OP_ACTIVITY',$permissions)): ?>  
                                    <li class="<?php echo e((isset($navigate) && $navigate['sub_nav']=='op_activity_report') ? 'current' : '', false); ?>">
                                        <a href="<?php echo e(action('Reports\OpActivityController@filter'), false); ?>">
                                        <i class="pull-right fa fa-file-pdf-o" style="font-size: 16px;"></i>
                                        <?php echo e(Lang::get('menu.side_menu_op_activity_report'), false); ?>

                                        </a></a>
                                    </li>
                                    <?php endif; ?>
                                    <?php if(in_array('REPORT_ANNUAL',$permissions)): ?>  
                                    <li class="<?php echo e((isset($navigate) && $navigate['sub_nav']=='annual_report') ? 'current' : '', false); ?>">
                                        <a href="<?php echo e(action('Reports\AnnualReportsController@create'), false); ?>"><i class="pull-right fa fa-file-pdf-o"></i><?php echo e(Lang::get('menu.side_menu_annual_reports'), false); ?>

                                        </a>
                                    </li>
                                    <?php endif; ?>           
                                    <?php if(in_array('USAGE_TRACKER', $permissions)): ?>
                                    <li class="<?php echo e((isset($navigate) && $navigate['sub_nav']=='usage_tracker') ? 'current' : '', false); ?>">
                                        <a href="<?php echo e(action('Reports\UsageTrackController@list'), false); ?>"><i class="pull-right fa fa-file-pdf-o"></i><?php echo e(Lang::get('menu.side_menu_usage_tracker'), false); ?>

                                        </a>
                                    </li>
                                    <?php endif; ?>                  
                                    <?php if(in_array('REPORT_NNF', $permissions) || in_array(Auth::user()->id, json_decode(env('NNF_USER_ID')))): ?>
                                    <li class="<?php echo e((isset($navigate) && $navigate['sub_nav']=='nnf') ? 'current' : '', false); ?>">
                                        <a href="<?php echo e(action('Reports\NNFController@filter'), false); ?>"><i class="pull-right fa fa-file-pdf-o"></i><?php echo e(Lang::get('menu.side_menu_nnf'), false); ?>

                                        </a>
                                    </li>
                                    <?php endif; ?>                 
                                </ul>
                            </li>
                            <?php endif; ?>                                      
                            <?php if(is_array($permissions) && in_array('CALCULATOR',$permissions)): ?>               
                            <li class="submenu <?php echo e((isset($navigate) && $navigate['main_nav']=='calc') ? 'open' : '', false); ?>" id="calc-nav">
                                <a href="javascript:void(0);">
                                <i class="fa fa-calculator pull-right custom-menu-icon-size" style="font-size: 18px !important;"></i>
                                <?php echo e(Lang::get('menu.side_menu_calculators'), false); ?> <img src="data:image/svg+xml;utf8,<svg fill='white' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/><path d='M0 0h24v24H0z' fill='none'/></svg>" class="<?php echo e((isset($navigate) && $navigate['main_nav']=='calc') ? 'transform-180' : '', false); ?>"/>
                                </a>
                                <ul class="sub-menu">
                                    <li class="title">
                                        <span><?php echo e(Lang::get('menu.side_menu_calculators'), false); ?></span>
                                    </li>
                                    <li class="<?php echo e((isset($navigate) && $navigate['sub_nav']=='ballard_calc') ? 'current' : '', false); ?>">
                                        <a href="<?php echo e(action('Calculators\BallardController@index'), false); ?>">
                                        <i class="fa fa-barcode pull-right" style="font-size: 15px;"></i>
                                        <?php echo e(Lang::get('menu.side_menu_ballard_score'), false); ?>

                                        </a>
                                    </li>
                                    <li class="<?php echo e((isset($navigate) && $navigate['sub_nav']=='glucose_calc') ? 'current' : '', false); ?>">
                                        <a href="<?php echo e(action('Calculators\GlucoseController@index'), false); ?>">
                                        <i class="fa fa-barcode pull-right" style="font-size: 15px;"></i>
                                        <?php echo e(Lang::get('menu.side_menu_glucose_rate_calculator'), false); ?>

                                        </a>
                                    </li>
                                    <li class="<?php echo e((isset($navigate) && $navigate['sub_nav']=='age_calc') ? 'current' : '', false); ?>">
                                        <a href="<?php echo e(action('Calculators\AgeController@index'), false); ?>">
                                        <i class="fa fa-barcode pull-right" style="font-size: 15px;"></i>
                                        <?php echo e(Lang::get('menu.side_menu_age_calculator'), false); ?>

                                        </a>
                                    </li>
                                    <li class="<?php echo e((isset($navigate) && $navigate['sub_nav']=='tpn_calc') ? 'current' : '', false); ?>">
                                        <a href="<?php echo e(action('Calculators\TpnCalculatorController@index'), false); ?>">
                                        <i class="fa fa-barcode pull-right" style="font-size: 15px;"></i>
                                        <?php echo e(Lang::get('menu.side_menu_tpn_calculator'), false); ?>

                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <?php endif; ?>   
                            <?php if(is_array($permissions) && in_array('DELETE_ACCESS',$permissions)): ?>   
                            <li class="submenu <?php echo e((isset($navigate) && $navigate['main_nav']=='delete_access') ? 'open' : '', false); ?>">
                                <a href="<?php echo e(action('Settings\DeleteApprovalController@index'), false); ?>">
                                <i class="fa fa-remove pull-right" style="font-size: 26px;"></i>
                                <?php echo e(Lang::get('menu.side_menu_delete_approvals'), false); ?>

                                </a>
                                <ul class="sub-menu">
                                    <li class="title module">
                                        <a href="<?php echo e(action('Settings\DeleteApprovalController@index'), false); ?>">
                                        <?php echo e(Lang::get('menu.side_menu_delete_approvals'), false); ?>

                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <?php endif; ?>
                            <li style="margin-bottom: 46px;">
                            </li>
                            <li class="submenu <?php echo e((isset($navigate) && $navigate['main_nav']=='audio_logs') ? 'current' : '', false); ?> hide">
                                <a href="<?php echo e(action('Audio\AudioFileController@index'), false); ?>">
                                <i class="fa fa-file-audio-o pull-right"></i>
                                <?php echo e(Lang::get('menu.side_menu_audio_log'), false); ?>

                                </a>
                                <ul class="sub-menu">
                                    <li class="title module">
                                        <a href="<?php echo e(action('Audio\AudioFileController@index'), false); ?>">
                                        <?php echo e(Lang::get('menu.side_menu_audio_log'), false); ?>

                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </div>
                    </ul>
                </div>
                <!-- <div id="divider" class="" resizeable></div> -->
            </div>
            <?php if(Request::segment(1) == 'nicu-nurse-sheets' || Request::segment(1) == 'nurse-sheets-manual'): ?>
            <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/nurse-sheet.js?rev=<?php echo time();?>"></script>
            <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/nurse-hour-wise.js?rev=<?php echo time();?>"></script>
            <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/mdtimepicker.min.js"> </script>
            <?php endif; ?>
            <!-- /Sidebar -->
            <?php echo Form::hidden('site_base_url',url('/')); ?>

            <div id="content">
                <div id="page-loader" class="loading-center" style="background: url('<?php echo e(url('/'), false); ?>/public/img/icons/preloader.gif') center no-repeat #fff"></div>
                <div class="container">
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
                <div id="notification-footer" class="warning-content" style="display: none;">
                    <div id="notification-footer-close">
                        <i class="fa fa-times fa-2x" aria-hidden="true"></i>
                    </div>
                    <div id="notification-footer-content" class="animated-example animated bounceInRight">
                        <div class="col-lg-2 col-md-3 col-sm-3 col-xs-3 notification-title-container">
                            <span class="notification-title blink_connect">Device Disconnected</span>
                        </div>
                        <div class="col-lg-9 col-md-8 col-sm-8 col-xs-8 notification-content plr-0">
                            <div id="notification-text"></div>
                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 notification-icon" title="Device Connect Alert">
                            <i class="fa fa-exclamation-triangle blink_me" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                <!-- <div id="notification-footer-open">
                    <i class="fa fa-expand" aria-hidden="true"></i>
                    </div> -->
                <!-- /.container -->
            </div>
            <?php endif; ?>
            <?php $toastrOptions = SiteHelpers::toastrOptions(); ?>
            <?php if(isset($toastrOptions->custom_toastr)): ?>
            <?php echo Form::hidden('toastr_options',$toastrOptions->custom_toastr,['id'=>'toastr_options']); ?>

            <?php endif; ?>
            <?php $highLight = SiteHelpers::highLight(); ?>
            <?php if(isset($highLight)): ?>
            <?php echo Form::hidden('high_light',json_encode($highLight),['id'=>'high_light']); ?>

            <?php endif; ?>
            <div id="hero-score-div"></div>
        </div>
        <div class="modal fade flow-control-modal" id="master-modal" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="text-center text-white">Add <span id="master_modal_header"></span></h3>
                        <button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true" style="color:white"><i class="fa fa-times"></i></button>
                    </div>
                    <div class="modal-body">
                        <h5 class="error text-center" id="master_error_block" style="display: none;"><strong>Please fill all fields</strong></h5>
                        <form id="master-from-popup" action="#">
                        </form>
                    </div>
                    <div class="modal-footer" style="background-color: white;">
                        <div class="row mx-0">
                            <div class="col-md-12 text-center">
                                <input type="hidden" id="master_destination_elements" value="">
                                <input type="hidden" id="master_option_value" value="">
                                <input type="hidden" id="master_option_text" value="">
                                <input type="hidden" id="master_table_name" value="">
                                <button type="button" class="btn btn-theme-primary" id="save-master-data"><i class="fa fa-save"></i> Save</button>
                                <button type="button" class="btn btn-secondary" id="cancel-master-data"><i class="fa fa-refresh"></i> Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade flow-control-modal" id="login-modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="text-center text-white">Login</h3>
                        <button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true" style="color:white"><i class="fa fa-times"></i></button>
                    </div>
                    <form id="login-modal-form">
                        <div class="modal-body mt-20">
                            <h5 class="error text-center" id="login_error_block" style="display: none;"></h5>
                            <div class="form-group row mx-0">
                                <div class="col-md-3 label-control text-right">
                                    <label for="Username">User Name:</label>
                                </div>
                                <div class="col-md-8 custom-input">
                                    <input type="text" id="login_user_name" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row mx-0">
                                <div class="col-md-3 label-control text-right">
                                    <label for="Username">Password:</label>
                                </div>
                                <div class="col-md-8 custom-input">
                                    <input type="password" id="login_password" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="background-color: white;">
                            <div class="row mx-0">
                                <div class="col-md-4 col-md-offset-3">
                                    <button type="submit" class="btn btn-theme-primary" id="login-submit-button"></i> Login</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade dsn-modal-up" id="dsn-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-header">
                    <button type="button" class="close modal-close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title">
                        <h3 class="text-center text-white">Device Disconnect</h3>
                    </h5>
                </div>
                <div class="modal-body row m-10 text-center">
                    <p class="badge badge-success disconnect-baby-name p-5 mt-5 font-size-12 color-white-must text-captialize"></p>
                    <p class="badge badge-primary disconnect-bed p-5 mt-5 font-size-12 color-white-must"></p>
                    <form id="disconnect-post">
                        <?php echo e(Form::hidden('bed_no'), false); ?>

                        <?php echo e(Form::hidden('device_count'), false); ?>

                        <div class="col-md-12 plr-0"></div>
                        <p class="col-md-12" id="cross-verify-content">
                            <i class="fas fa-exclamation-triangle fa-2x error-message pr-15"></i>
                            <span class="pt-15">Do you want to discharge the baby ?</span>
                            <a href="javascript:void(0);" id="baby-discharge" class="btn btn-warning ml-15" data-bed-no="0" data-ward-no="0" data-baby-id="0" data-admission-id="0">Yes</a>
                        </p>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
        <a href="javascript:void(0)" id="scrollToTop"><i class="fa fa-angle-up"></i></a>
        <!-- Scripts --> 
        <!--=== JavaScript ===-->
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/sisyphus.js"></script>
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
        <script src="/js/libs/html5shiv.js"></script>
        <![endif]-->
        <!-- Smartphone Touch Events -->
        <!--
            <script type="text/javascript" src="/plugins/touchpunch/jquery.ui.touch-punch.min.js"></script>
            <script type="text/javascript" src="/plugins/event.swipe/jquery.event.move.js"></script>
            <script type="text/javascript" src="/plugins/event.swipe/jquery.event.swipe.js"></script>
            --> 
        <!-- General -->
        <!--    <script type="text/javascript" src="/plugins/respond/respond.min.js"></script> <!-- Polyfill for min/max-width CSS3 Media Queries (only for IE8) -->
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/plugins/cookie/jquery.cookie.min.js"></script>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/plugins/slimscroll/jquery.slimscroll.min.js"></script>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/plugins/slimscroll/jquery.slimscroll.horizontal.min.js"></script>
        <!-- DataTables -->
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/plugins/datatables/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/plugins/datatables/DT_bootstrap.js"></script>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/plugins/datatables/responsive/datatables.responsive.js"></script> <!-- optional -->
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/plugins/datatables/columnfilter/jquery.dataTables.columnFilter.js"></script> <!-- optional -->    
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/plugins/datatables/tabletools/TableTools.min.js"></script>
        <!-- optional -->
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/plugins/datatables/FixedColumns.js"></script>
        <!-- validation -->
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/plugins/validation/jquery.validate.min.js"></script>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/plugins/validation/additional-methods.min.js"></script>
        <!-- validation -->
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/plugins/bootstrap-wizard/jquery.bootstrap.wizard.js"></script>
        <!-- toster message  -->
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/plugins/toastr-master/build/toastr.min.js"></script>
        <!-- toster message  -->
        <!-- App -->
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/app.js"></script>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/plugins.js"></script>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/plugins.form-components.js"></script>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/plugins/bootbox/bootbox.min.js"></script>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/plugins/typeahead/typeahead.min.js"></script> <!-- AutoComplete -->
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/plugins/tagsinput/jquery.tagsinput.min.js"></script>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/plugins/bootstrap-inputtags/bootstrap-tagsinput.js"></script>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/demo/form_components.js?rev=<?php echo time();?>"></script>  
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/plugins/uniform/jquery.uniform.min.js"></script> <!-- Styled radio and checkboxes -->   
        <script>
            $(document).ready(function () {
                "use strict";
                Plugins.init(); // Init all plugins
                FormComponents.init(); // Init all form-specific plugins
            });

            function babyMrcheck() {
                <?php if(Request::segment(3) == 'edit'): ?>
                return true;
                <?php else: ?>
                return "<?php echo e(url('baby-mrnumber-check'), false); ?>";
                <?php endif; ?>
            }

            <?php if(Session::has('Success')): ?>
            Showalert('success', ' <?php echo Session::get("Success"); ?>');
            <?php endif; ?>
            <?php if(Session::has('info')): ?>
            Showalert('info', ' <?php echo Session::get("info"); ?>');
            <?php endif; ?>
            <?php if(Session::has('warning')): ?>
            Showalert('warning', ' <?php echo Session::get("warning"); ?>');
            <?php endif; ?>
            <?php if(Session::has('error')): ?>
            Showalert('error', ' <?php echo Session::get("error"); ?>');
            <?php endif; ?>

            function Showalert(type, message) {
                var option = JSON.parse($('#toastr_options').val());

                toastr.options.closeButton = option.closeButton;
                toastr.options.debug = option.debug;
                toastr.options.newestOnTop = option.newestOnTop;
                toastr.options.progressBar = option.progressBar;
                toastr.options.positionClass = option.positionClass;
                toastr.options.preventDuplicates = option.preventDuplicates;
                toastr.options.onclick = option.onclick;
                toastr.options.showDuration = option.showDuration;
                toastr.options.hideDuration = option.hideDuration;
                toastr.options.timeOut = option.timeOut;
                toastr.options.extendedTimeOut = option.extendedTimeOut;
                toastr.options.showEasing = option.showEasing;
                toastr.options.hideEasing = option.hideEasing;
                toastr.options.hideMethod = option.hideMethod;

                if (type == 'success') {

                    toastr.success(type, message);

                } else if (type == 'error') {

                    toastr.error(type, message);

                } else if (type == 'info') {

                    toastr.info(type, message);

                } else if (type == 'warning') {

                    toastr.warning(type, message);

                }

            }

            $('.permission-denied').click(function () {
                Showalert('warning', 'Access Denied');
            });

            function clearMasterPopupData() {
                $('#master_modal_header').text('');
                $('#master_destination_elements').val('');
                $('#master_option_value').val('');
                $('#master_option_text').val('');
                $('#master_table_name').val('');
                $('#master-from-popup').html('');
                $('#master_error_block').hide();

            }
            $(document).on('click', '#cancel-master-data', function () {
                $('#master-modal').modal('hide');
                clearMasterPopupData();
            });
            $(document).on('click', '#save-master-data', function () {
                $('#save-master-data').prop('disabled', true);
                $('#page-loader').show();
                $('#master_error_block').hide();
                var valid_inputs;
                var table_name = $('#master_table_name').val();
                // console.log(table_name);
                $('.master_required').each(function () {
                    if ($(this).val() === "" || $(this).val() === null) {
                        if ($(this).attr('name') != 'Qualification' && $(this).attr('name') != 'job_title') {
                            valid_inputs = false
                        }
                        if (table_name == 'mas_referral') {
                            if ($('input[name="doctor_name"]').val() || $('input[name="hospital_name"]').val()) {
                                valid_inputs = true
                            }
                        }
                    }
                });
                if (valid_inputs === false) {
                    $('#page-loader').hide();
                    $('#master_error_block').show();
                    $('#save-master-data').prop('disabled', false);
                    return false;
                }
                var destination_elements = $('#master_destination_elements').val();
                var option_value = $('#master_option_value').val();
                var option_text = $('#master_option_text').val();

                if (option_text.indexOf(',') > -1) {
                    var text = option_text.split(',');
                    option_text = '';
                    if (text.length > 0) {
                        $.each(text, function (index, value) {
                            var temp_value = $('#master-from-popup input[name=' + value + ']').val();
                            if (temp_value != '' && option_text != '') {
                                if (table_name == 'mas_referral') {
                                    option_text += ', ';
                                } else {
                                    option_text += ' / ';
                                }
                            }
                            option_text += temp_value;
                        });
                    }
                } else {
                    option_text = $('#master-from-popup input[name=' + option_text + ']').val();
                }

                if (option_text[0] == ',') {
                    option_text = option_text.slice(1);
                }

                var post_data = $('#master-from-popup').serialize();
                var modal_header = $('#master_modal_header').text()
                post_data += '&table_name=' + table_name;
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: '<?php echo e(url("save_master_data/"), false); ?>',
                    data: post_data,
                    beforeSend: function () {

                    },
                    success: function (response) {
                        if (response.status != false) {
                            var append_select = '';
                            if (option_value == 'id') {
                                append_select += '<option value="' + response.id + '">' + option_text + '</option>';
                            } else {
                                append_select += '<option value="' + $('#master-from-popup input[name=' + option_value + ']').val() + '">' + option_text + '</option>';
                            }
                            var destination_elements_array = destination_elements.split(',');
                            $.each(destination_elements_array, function (index, value) {
                                if (value.indexOf('^') != -1) {
                                    value = value.replace('^', '');
                                    $('select[name^="' + value + '"]').append(append_select);
                                } else if (value.indexOf('[]') != -1) {
                                    value = value.replace('[]', '');
                                    $('select[name^="' + value + '"]').append(append_select);
                                } else {
                                    $('select[name="' + value + '"]').append(append_select);
                                }
                            });
                        }
                        Showalert('success', modal_header + ' Added Successfully');

                    },
                    complete: function (response) {
                        $('#page-loader').hide();
                    },

                    error: function (response) {
                        $('#page-loader').hide();
                        if (typeof response.responseJSON.message != 'undefined') {
                            var message = response.responseJSON.message;
                            Showalert('error', message);
                        }
                    }

                });
                $('#page-loader').hide();
                $('#save-master-data').prop('disabled', false);
                $('#master-modal').modal('hide');
                // clearMasterPopupData();

            });
            $(document).on('click', '.add_master_data', function () {
                $('#page-loader').show();
                clearMasterPopupData();

                var table_name = $(this).data('mas_table');
                var modal_header = $(this).data('modal_header');
                var destination_elements = $(this).attr('data-destination_elements');
                var option_value = $(this).data('option_value');
                var option_text = $(this).data('option_text');
                var drug_type = $(this).data('drug_type');

                $('#master_destination_elements').val(destination_elements);
                $('#master_option_value').val(option_value);
                $('#master_option_text').val(option_text);
                $('#master_table_name').val(table_name);
                $('#master_modal_header').text(modal_header);

                $.ajax({
                    type: 'GET',
                    url: '<?php echo e(url("get-master-table-fields"), false); ?>' + '/' + table_name,
                    beforeSend: function () {

                    },
                    success: function (responseText) {
                        if (responseText.type == 'failure') {

                        } else {
                            // console.log(responseText.html);
                            $('#master-from-popup').html(responseText.html);
                            if (typeof drug_type != 'undefined' && drug_type == 'antibiotic') {
                                $('#master-from-popup').append('<input type="hidden" name="anti_status" value="1">');
                            } else if (typeof drug_type != 'undefined' && drug_type == 'oral') {
                                $('#master-from-popup').find('select[name="type"]').parent().parent().remove();
                                $('#master-from-popup').append('<input type="hidden" name="type" value="ORAL">');
                            }
                        }
                    },
                    complete: function (responseText) {
                        $('#master-modal').modal({
                            backdrop: 'static',
                            show: true
                        });
                        $('#page-loader').hide();

                    },

                    error: function (responseText) {
                        // $('#page-loader').hide();
                        if (typeof responseText.responseJSON.message != 'undefined') {
                            var message = responseText.responseJSON.message;
                            Showalert('error', message);
                        }
                    }

                });
                // $('#page-loader').hide();
            });

            let warningTimeout = 5 * 60 * 1000;
            let warningTimerID;

            function startTimer() {
                // window.setTimeout returns an ID that can be used to start and stop the timer
                warningTimerID = window.setTimeout(idleLogout, warningTimeout);
                animate(5, 0, warningTimeout);
            }
            //function for resetting the timer
            function resetTimer() {
                window.clearTimeout(warningTimerID);
                startTimer();
            }
            // Logout the user.
            function idleLogout() {
                $('#login_error_block').hide();
                $('#login_password').val('');
                $('#login_user_name').val('');
                $('#login-modal').modal(
                {
                    backdrop: 'static',
                    keyboard: false,
                    show: true
                });
                $('.modal:not(#login-modal)').removeClass('in');
                $('.modal-backdrop').addClass('modal-backdrop-bg');
            }
            // startCountdown();

            function startCountdown() {
                document.addEventListener("mousemove", resetTimer);
                document.addEventListener("mousedown", resetTimer);
                document.addEventListener("keypress", resetTimer);
                document.addEventListener("touchmove", resetTimer);
                document.addEventListener("onscroll", resetTimer);
                document.addEventListener("wheel", resetTimer);
                startTimer();
            }
            //the animating function
            function animate(initVal, lastVal, duration) {
                // console.log(duration);
                let startTime = null;
                //get the current timestamp and assign it to the currentTime variable
                let currentTime = Date.now();
                //pass the current timestamp to the step function
                const step = (currentTime) => {
                    //if the start time is null, assign the current time to startTime
                    if (!startTime) {
                        startTime = currentTime;
                    }
                    //calculate the value to be used in calculating the number to be displayed
                    const progress = Math.min((currentTime - startTime) / duration, 1);
                    //calculate what is to be displayed using the value gotten above
                    displayValue = Math.floor(progress * (lastVal - initVal) + initVal);
                    //checking to make sure the counter does not exceed the last value(lastVal)
                    if (progress < 1) {
                        window.requestAnimationFrame(step);
                    } else {
                        window.cancelAnimationFrame(window.requestAnimationFrame(step));
                    }
                };
                //start animating
                window.requestAnimationFrame(step);
            }

            $(document).on('click', '#login-submit-button', function (e) {
                e.preventDefault();
                relogin();
            });
            $('#login-modal-form').submit(function (e) {
                e.preventDefault();
                relogin();
            });

            function relogin() {

                var user_name = $('#login_user_name').val();

                if (user_name == '' || !user_name || user_name == null) {
                    $('#login_error_block').text('Invalid user name...!').show();
                    $('#login_user_name').focus();
                    return false;
                }
                var password = $('#login_password').val();
                if (password == '' || !password || password == null) {
                    $('#login_error_block').text('Invalid Password...!').show();
                    $('#login_password').focus();
                    return false;
                }
                $('#login-submit-button').prop('disabled', true);
                $.ajax({
                    url: "<?php echo e(url('check-user-login'), false); ?>",
                    type: "POST",
                    data: {
                        user_name: user_name,
                        password: password,
                    },
                    success: function (response) {
                        if (response.type == 'failure') {
                            $('#login_error_block').text(response.message).show();
                            $('#login-submit-button').prop('disabled', false);
                        } else if (response.type == 'warning') {
                            $('#login_error_block').text(response.message).show();
                            $('#login-submit-button').prop('disabled', false);
                        } else if (response.type == 'anotherUser') {
                            window.location.href = "<?php echo e(url('/'), false); ?>";
                        } else {
                            // window.location.reload();
                            $('#login-modal').modal('hide');
                            $('#login-submit-button').prop('disabled', false);
                            $('.modal-backdrop').removeClass('modal-backdrop-bg');
                        }
                    },
                    error: function () {
                        window.location.reload();
                        $('#login-modal').modal('hide');
                        $('#login-submit-button').prop('disabled', false);
                    }
                });
            }
        </script>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/plugins/Bootstrap-Horizontal-Selector/js/horizontal_selector.js?rev=<?php echo time();?>"></script>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/plugins/duallistbox/dual-listbox.js"></script>
        <script  type="text/javascript" src="<?php echo e($site_url, false); ?>/plugins/ckeditor/ckeditor.js"></script>
        <script type="text/javascript">
            CKEDITOR.config.customConfig = '<?php echo e($site_url, false); ?>/js/ckeditor.js';
        </script>
        <?php if(Request::segment(1) == 'pediatric-admission' || Request::segment(1) == 'neuro-develop' || Request::segment(1) == 'pediatric-search' || Request::segment(1) == 'pediatric-search-view' || Request::segment(1) == 'neuro-search' || Request::segment(1) == 'neuro-search-view' || Request::segment(1) == 'pediatric-out-patient' || Request::segment(1) == 'feeding' || Request::segment(2) == 'shortcode-list'): ?>
        <script  type="text/javascript" src="<?php echo e($site_url, false); ?>/js/tinymce/tinymce.min.js"></script>
        <?php endif; ?>
        <!-- Demo JS -->
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/custom.js"></script>  
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/selectwithtext.js"></script>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/scripts.js?rev=<?php echo time();?>"></script> 
        <?php if(Request::segment(1) != 'nicu-discharge-search' && Request::segment(1) != 'nicu-discharge-search-view' && Request::segment(1) != 'postnatal-discharge-search' && Request::segment(1) != 'postnatal-discharge-search-view'): ?>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/nicudischarge.js?rev=<?php echo time();?>"></script> 
        <?php endif; ?>
        <?php if((Request::segment(1) == 'out-patient' && (Request::segment(3) == 'edit' || Request::segment(2) == 'visite-list')) || (Request::segment(1) == 'neuro-develop' && (Request::segment(3) == 'edit' || Request::segment(2) == 'visite-list')) || (Request::segment(1) == 'nicu-nurse-sheets' && (Request::segment(3) == 'edit' || Request::segment(1) == 'nicu-nurse-sheet-day')) || (Request::segment(1) == 'nicu-admission' && (Request::segment(3) == 'edit' || Request::segment(2) == 'sub-nicu-list')) || (Request::segment(1) == 'daycare-admission' && (Request::segment(3) == 'edit' || Request::segment(2) == 'daycare-admission-daylist')) || (Request::segment(1) == 'pediatric-admission' && (Request::segment(3) == 'edit' || Request::segment(2) == 'sub-list'))): ?>
            <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/bootstrap-fileinput/fileinput.min.js"></script>
            <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/media.js?rev=<?php echo time();?>"></script>
        <?php endif; ?>
        <?php if(Request::segment(1) == 'out-patient' && Request::segment(2) == 'select'): ?>
            <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/select2_pagination.js?rev=<?php echo time();?>"></script>
        <?php endif; ?>

        <?php if(Request::segment(1) == 'mother-registration' || Request::segment(1) == 'mother-registration-nurse'): ?>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/mother.js?rev=<?php echo time();?>"></script>
        <?php endif; ?>
        <?php if(Request::segment(1) == 'baby-registration' || Request::segment(1) == 'baby-registration-nurse' || Request::segment(1) == 'baby-readmission'): ?> 
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/baby-form.js?rev=<?php echo time();?>"></script>
        <?php endif; ?>
        <?php if(Request::segment(1)=='nurse-nicu-daycare'): ?>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/nursedaycare.js?rev=<?php echo time();?>"></script>
        <?php endif; ?>  
        <?php if(Request::segment(1)=='daycare-admission'): ?>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/daycare.js?rev=<?php echo time();?>"></script> 
        <?php endif; ?> 
        <?php if(Request::segment(1)=='nicu-admission' || Request::segment(1)=='nicu-discharge'): ?>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/nicu_admission.js?rev=<?php echo time();?>"></script>
        <?php endif; ?>
        <?php if(Request::segment(1)=='neonatal'): ?>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/neonatal_proforma.js?rev=<?php echo time();?>"></script>
        <?php endif; ?>
        <?php if(Request::segment(1)=='postnatal-daycare'): ?>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/postnatal_daycare.js?rev=<?php echo time();?>"></script>
        <?php endif; ?>
        <?php if(Request::segment(1)=='echocardiography' || Request::segment(1)=='cranialultrasound' || Request::segment(1)=='culture-registry'): ?>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/lab_test.js?rev=<?php echo time();?>"></script>
        <?php endif; ?>
        <?php if(Request::segment(1)=='out-patient'): ?>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/op.js?rev=<?php echo time();?>"></script>
        <?php endif; ?>
        <?php if(Request::segment(1)=='pediatric-out-patient'): ?>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/oppediatric.js?rev=<?php echo time();?>"></script>
        <?php endif; ?>
        <?php if(Request::segment(1)=='neuro-develop' && (Request::segment(2) == 'create' || Request::segment(3) == 'edit')): ?>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/neuro.js?rev=<?php echo time();?>"></script>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/m_chart_followup.js?rev=<?php echo time();?>"></script>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/ddst_chart.js?rev=<?php echo time();?>"></script>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/neuro_cbcl.js?rev=<?php echo time();?>"></script>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/neuro_issa.js?rev=<?php echo time();?>"></script>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/bayley.js?rev=<?php echo time();?>"></script>
        <?php endif; ?>
        <?php if(Request::segment(1)=='feeding' && (Request::segment(2) == 'create' || Request::segment(3) == 'edit')): ?>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/feeding.js?rev=<?php echo time();?>"></script>
        <?php endif; ?>
        <?php if(Request::segment(1) == 'postanatal-admission'): ?>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/postnatal_admission.js?rev=<?php echo time();?>"></script>
        <?php endif; ?>
        <?php if(Request::segment(1)=='problems-settings'): ?>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/form-builder/basic-components.js?rev=<?php echo time();?>"></script>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/form-builder/form-component.js?rev=<?php echo time();?>"></script>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/form-builder/modal-form.js?rev=<?php echo time();?>"></script>
        <?php endif; ?>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/plugins/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>
        <?php if(Request::segment(1) == 'problems-systems' || Request::segment(1) == 'problem-systems-postnatal'): ?>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/problem-daycare.js?rev=<?php echo time();?>"></script>
        <?php endif; ?>
        <?php if(Request::segment(1) == 'site'): ?>
        <script  type="text/javascript" src="<?php echo e($site_url, false); ?>/plugins/croppie/croppie.js"></script>
	    <?php endif; ?>
        <?php if(Request::segment(1) == 'nicu-discharge-search' || Request::segment(1) == 'nicu-discharge-search-view'): ?>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/search/nicu-discharge.js?rev=<?php echo time();?>"></script> 
        <?php endif; ?>
        <?php if(Request::segment(1) == 'postnatal-discharge-search' || Request::segment(1) == 'postnatal-discharge-search-view'): ?>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/search/postnatal-discharge.js?rev=<?php echo time();?>"></script> 
        <?php endif; ?>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/select_field_filter.js?rev=<?php echo time();?>"></script> 
        <?php if(Request::segment(1) == 'medication-template'): ?>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/medication_template.js?rev=<?php echo time();?>"></script> 
        <?php endif; ?>
        <?php if(Request::segment(1) == 'pediatric-admission' && (Request::segment(3) == 'create' || Request::segment(3) == 'edit')): ?>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/pediatric.js?rev=<?php echo time();?>"></script> 
        <?php endif; ?>
        <?php if(Request::segment(1) == 'profile'): ?>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/userprofile.js?rev=<?php echo time();?>"></script> 
        <?php endif; ?>
        <?php if(Request::segment(1) == 'tpn-calculator'): ?>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/tpn_calculator.js?rev=<?php echo time();?>"></script> 
        <?php endif; ?>
        <?php if(Request::segment(1) == 'live-chart'): ?>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/amcharts5/live_chart/index.js"></script>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/amcharts5/live_chart/xy.js"></script>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/amcharts5/stock.js"></script>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/amcharts5/themes_responsive.js"></script>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/amcharts5/live_chart/exporting.js"></script>
        <script type="text/javascript" src="<?php echo e($site_url, false); ?>/js/live_chart.js?rev=<?php echo time();?>"></script> 
        <?php endif; ?>
        <?php echo $__env->make('flowcontrol.flow-control', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="modal fade" id="complaints" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <h3>Complaint</h3>
                        </h5>
                        <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="font-size-one">&times;</span>
                        </button> 
                    </div>
                    <?php echo Form::open(['url' => action('Settings\ComplaintsController@index'), 'id' => 'complaint_form']); ?>

                    <div class="modal-body m-20">
                        <div class="form-group">
                            <?php
                            $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";  
                            $CurPageURL = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];  
                            ?>
                            <?php echo e(Form::hidden('current_url',$CurPageURL), false); ?>

                            <?php echo e(Form::label('complaint','Suggestion or Complaint:'), false); ?>

                            <?php echo e(Form::textarea('complaint',null,['class'=>'form-control','rows'=>'3']), false); ?>    
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <button type="button" id="close" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                    <?php echo Form::close(); ?>

                </div>
            </div>
        </div>
        <?php echo $__env->yieldContent('scripts'); ?>
    </body>
</html>
