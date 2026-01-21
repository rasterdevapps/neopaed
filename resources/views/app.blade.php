<!DOCTYPE html>
<html lang="en">
    <head>
        @php
        $site_url = url('/').'/public';
        $specialPermission = \Session::get('specialPermissions');
        $permissions=session('menu_permission');
        $role_id = Auth::user()->RoleId;
        @endphp
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>DEMO || Neopaed</title>
        <link rel="shortcut icon" href="{{ $site_url }}/img/neonatal_logo.png" />
        <meta name="site-orgin" content="{{ url('/') }}">
        <!-- Bootstrap -->
        <link href="{{ $site_url }}/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme -->
        <link href="{{ $site_url }}/css/main.css" rel="stylesheet" type="text/css" />
        <link href="{{ $site_url }}/css/fontawesome/font-awesome.min.css" rel="stylesheet">
        <link href="{{ $site_url }}/plugins/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet">
        <link href="{{ $site_url }}/plugins/bootstrap-inputtags/bootstrap-tagsinput.css" rel="stylesheet" type="text/css"/>
        <link href="{{ $site_url }}/plugins/Bootstrap-Horizontal-Selector/css/horizontal_selector.css" rel="stylesheet" type="text/css"/>
        <link href="{{ $site_url }}/plugins/toastr-master/build/toastr.css" rel="stylesheet" type="text/css" />
        <link href="{{ $site_url }}/css/plugins.css" rel="stylesheet" type="text/css" />
        <link href="{{ $site_url }}/plugins/duallistbox/dual-listbox.css" rel="stylesheet" type="text/css">
        @if(Request::segment(1) == 'appointment-calendar')
        <link  href="{{ $site_url }}/plugins/calen-style/src/calenstyle.css" rel="stylesheet" type="text/css"/>
        <link  href="{{ $site_url }}/plugins/calen-style/src/calenstyle-iconfont.css" rel="stylesheet" type="text/css"/>
        <link href="{{ $site_url }}/css/calendar.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css" />
        @endif
        <link href="{{ $site_url }}/css/custom.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="{{ $site_url }}/css/selectwithtext.css"/>
        <link href="{{ $site_url }}/css/responsive.css" rel="stylesheet" type="text/css" />
        <link href="{{ $site_url }}/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="{{ $site_url }}/css/plugins/select2.css" rel="stylesheet" type="text/css" />
        <link href="{{ $site_url }}/css/customized.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css">
        <link href="{{ $site_url }}/css/modal.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css" />
        @if(Request::segment(1) == 'ward-dashboard')
        <link href="{{ $site_url }}/css/ward-dashboard.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css" />
        @endif
        <link href="{{ $site_url }}/css/sidenav.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css" />
        <link href="{{ $site_url }}/css/dashboard.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css" />
        @if(Request::segment(1) == 'growthchart-view' || Request::segment(1) == 'growthchartzerotofive')
        <link href="{{ $site_url }}/css/growthchart.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css" />
        @endif
        @if(Request::segment(1) == 'quality-indicator')
        <link href="{{ $site_url }}/css/baby-form-create.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css" />
        @endif
        <!-- <link href="{{ $site_url }}/css/complaint-modal.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css" /> -->
        @if((Request::segment(1) == 'prescription' && Request::segment(2) != 'create') || Request::segment(1) == 'prescription-generate')
        <link rel="stylesheet" href="{{ $site_url }}/css/circle.css?rev=<?php echo time();?>">
        <link rel="stylesheet" href="{{ $site_url }}/css/pump_prescription.css?rev=<?php echo time();?>">
        @endif
        @if(Request::segment(1) == 'neuro-develop')
        <link rel="stylesheet" href="{{ $site_url }}/css/ddst_chart.css?rev=<?php echo time();?>">
        <link rel="stylesheet" href="{{ $site_url }}/css/bayley.css?rev=<?php echo time();?>">
        @endif
        @if(Request::segment(1) == 'neonatal')
        <link href="{{ $site_url }}/css/neonatal-proforma.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css" />
        @endif
        @if(Request::segment(1) == 'nicu-admission' || Request::segment(1) == 'nicu-discharge-main-list')
        <link href="{{ $site_url }}/css/nicu.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css" />
        @endif
        <link href="{{ $site_url }}/css/table-responsive.css" rel="stylesheet" type="text/css" />
        @if(Request::segment(1) == 'nurse-nicu-daycare')
        <link href="{{ $site_url }}/css/nurse-daily-entry-form.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css" />
        @endif
        @if(Request::segment(1) == 'postanatal-admission')
        <link href="{{ $site_url }}/css/postnatal.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css" />
        @endif
        <link href="{{ $site_url }}/css/settings.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css" />
        <link href="{{ $site_url }}/css/customized-responsive.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="{{ $site_url }}/plugins/context-menu/dist/jquery.contextMenu.min.css">
        @if(Request::segment(1) == 'nicu-nurse-sheets')
        <link  href="{{ $site_url }}/css/nicu-nurse-sheets.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css"/>
        <link  href="{{ $site_url }}/css/mdtimepicker.min.css" rel="stylesheet" type="text/css">
        @endif	
        @if (Request::segment(1) == 'out-patient' || (Request::segment(1) == 'neuro-develop' && Request::segment(3) == 'edit') || (Request::segment(1) == 'nicu-nurse-sheets' && Request::segment(3) == 'edit') || (Request::segment(1) == 'nicu-admission' && Request::segment(3) == 'edit') || (Request::segment(1) == 'daycare-admission' && Request::segment(3) == 'edit') || Request::segment(1) == 'nicu-discharge' || (Request::segment(1) == 'pediatric-admission' && Request::segment(3) == 'edit'))
        <link href="{{ $site_url }}/css/bootstrap-fileinput/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="{{ $site_url }}/css/media.css?rev=<?php echo time();?>">
        @endif
	    @if(Request::segment(1) == 'tpn-calculator')
            <link  href="{{ $site_url }}/css/tpn_calculator.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css"/>
        @endif
        @if(Request::segment(2) == 'vaccine-chart' || (Request::segment(1) == 'out-patient' && (Request::segment(2) == 'create' || Request::segment(3) == 'edit')) || (Request::segment(1) == 'pediatric-out-patient' && (Request::segment(2) == 'create' || Request::segment(3) == 'edit')))
            <link  href="{{ $site_url }}/css/vaccine_chart_view.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css"/>
        @endif
        <link href="{{ $site_url }}/js/timedropper.min.css" rel="stylesheet" type="text/css" />
        @if(Request::segment(1) == 'site')
        <link  href="{{ $site_url }}/css/plugins/croppie.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css" />
        @endif
        @if(Request::segment(1) == 'live-chart')
            <link rel="stylesheet" type="text/css" href="{{$site_url}}/css/live_chart.css">
        @endif

        <script type="text/javascript" src="{{ $site_url }}/js/libs/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="{{ $site_url }}/js/libs/jquery-ui.min.js" ></script>
        <script type="text/javascript" src="{{ $site_url }}/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="{{ $site_url }}/js/libs/lodash.compat.min.js"></script>
        <script type="text/javascript" src="{{ $site_url }}/js/libs/breakpoints.js"></script>
        <script type="text/javascript" src="{{ $site_url }}/plugins/bootstrap-switch/bootstrap-switch.js"></script>
        <script type="text/javascript" src="{{ $site_url }}/js/timedropper.js"></script>
        <!-- calendar test -->
        @if(Request::segment(1) == 'appointment-calendar')
        <script type="text/javascript" src="{{ $site_url }}/plugins/calen-style/src/calenstyle.js"></script>
        @endif
        <!-- calendar test -->
        <script type="text/javascript" src="{{ $site_url }}/plugins/context-menu/dist/jquery.contextMenu.min.js"></script>
        @if(Request::segment(1) == 'problems-settings')
        <script type="text/javascript" src="{{ $site_url }}/js/drag-drop.min.js"></script>
        @endif
        <script type="text/javascript" src="{{ $site_url }}/plugins/select2/select2.min.js"></script> <!-- Styled select boxes -->
        @php $echo_port = env('LARAVEL_ECHO_PORT'); @endphp
	    <script>
            window.laravel_echo_port = '{{$echo_port}}';
        </script>
        @php $socket_is_connected = true; @endphp
        @if(Request::segment(1) == 'prescription' || Request::segment(1) == 'ward-dashboard' || Request::segment(1) == 'ward-dashboard-view')
            @php $ward_folder = substr($_SERVER['REMOTE_ADDR'], 0, 4) == '172.' @endphp
            @if($ward_folder)
                <script type="text/javascript" src="http://172.16.7.211:6001/socket.io/socket.io.js"></script>
                <script>window.laravel_echo_port = '6001';</script>
            @else
                <script type="text/javascript" src="http://neopaed.sks.net.in:90/socket.io/socket.io.js"></script>
                <script>window.laravel_echo_port = '90';</script>
            @endif
            <script type="text/javascript" src="{{ $site_url }}/js/laravel-echo-setup.js"></script>
        @endif
        @if(Request::segment(1) == 'prescription' && Request::segment(2) != 'create')
        <script type="text/javascript" src="{{ $site_url }}/js/prescription.js"></script>
        @endif
        @if(Request::segment(1) == 'ward-dashboard')
        <script type="text/javascript" src="{{ $site_url }}/js/ward-dashboard.js"></script>
        @endif
        @if(Request::segment(1) == 'users' || Request::segment(1) == 'profile')
        <script type="text/javascript" src="{{ $site_url }}/js/signature_pad.min.js"></script>
        @endif
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
            @media screen and (min-width: 300px) and (max-width : 376px) {
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
                <a class="navbar-brand custom-logo-container" href="{{ url('/') }}">
                <img class="logo-image" src="{{ $site_url }}/img/neonatal_logo.png" width="50px" height="50px" alt="logo" />
                <strong>{{ env('APP_NAME') }} </strong>
                <small> (3.10)</small>
                </a>
                <!-- /logo -->
                <!-- Sidebar Toggler -->
                <a href="#" class="toggle-sidebar header-icons hover-fx" data-placement="bottom" data-original-title="Toggle navigation" style="margin-left: 0px !important;">
                <i class="fa fa-reorder"></i>
                </a>
                <!-- /Sidebar Toggler -->
                <!-- Top Left Menu -->
                @if (Auth::guest())
                @else
                <ul class="nav navbar-nav navbar-left">
                    <li>
                        <a href="{{ url('/') }}/" class="header-icons hover-fx" title="Home" style="margin-top: 12px !important; margin-left: 10px !important; padding-top: 1px !important; padding-left: 4px !important;" rel="external">
                        <i class="fa fa-home nav-home-icon-size"></i>
                        <span></span>
                        </a>
                    </li>
                    @if(is_array($permissions) && in_array('WARD_MANAGEMENT',$permissions))   
                        <li>
                            <a href="{{ url('ward-dashboard/') }}" class="header-icons hover-fx" title="Ward Dashboard" style="margin-top: 12px !important;padding-top: 5px; padding-left: 3px;padding-right: 28px !important; margin-left: 9px !important;" rel="external">
                            <i class="fas fa-bed nav-home-icon-size" style="font-size: 20px;"></i>
                            <span></span>
                            </a>
                        </li>
                    @endif
                </ul>
                <!-- /Top Left Menu -->
                @endif
                <!-- Top Right Menu -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- User Login Dropdown -->
                    @if (Auth::guest())
                    <li>
                        <a href="{{ url('/login') }}">Login</a>
                    </li>
                    <!--<li><a href="/register">Register</a></li>  -->
                    @else
                    <li class="dropdown user admin-profile">
                        <a href="#" class="dropdown-toggle header-icons hover-fx" data-toggle="dropdown" style="padding-top: 4px; margin-top: 8px !important;" title="Profile">
                            <!-- <span class="icons-wrapper icons-wrapper-alt rounded-circle">
                                <span class="icons-wrapper-bg"></span> -->
                            <i class="fas fa-user-tie fa-2x"></i>
                            <!-- </span> -->
                            <!-- <i class="fa fa-male"></i>
                                <span class="username">{{ Auth::user()->name }}</span>
                                <i class="fa fa-caret-down small"></i> -->
                        </a>
                        <ul class="dropdown-menu master-drop-down">
                            <li class="p-10 title" title="Logged in as">
                                <i class="fa fa-user"></i> {{ Auth::user()->name }}
                            </li>
                            <li>
                                <a href="{{ url('/profile') }}">
                                <i class="fa fa-male"></i> {{ Lang::get('menu.top_menu_my_profile') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/logout') }}">
                                <i class="fa fa-key"></i>{{ Lang::get('menu.top_menu_log_out') }}
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- /user login dropdown -->
                    @endif
                </ul>
                <ul class="nav navbar-nav navbar-right data-content ">
                    <!-- User Login Dropdown -->
                    @if (Auth::guest())
                    @else
                    @if(is_array($permissions) && count(array_intersect(['USER_GROUPS','USERS','MAS_PROBLEM_SETTING', 'SITESETTING'],$permissions))>0)
                    <li class="dropdown settings">
                        <a href="#" class="dropdown-toggle header-icons hover-fx" data-toggle="dropdown" style="padding-top: 4px; margin-top: 8px !important;" title="Settings">
                            <!-- <span class="icons-wrapper icons-wrapper-alt rounded-circle">
                                <span class="icons-wrapper-bg"></span> -->
                            <i class="fa fa-cog fa-2x"></i>
                            <!-- </span> -->
                        </a>
                        <ul class="dropdown-menu master-drop-down">
                            <li class="title">
                                <span>{{ Lang::get('menu.top_menu_settings') }}</span>
                            </li>
                            @if(in_array('USER_GROUPS',$permissions))
                            <li>
                                <a href="{{ action('Settings\UsergroupController@index') }}">
                                <i class="fa fa-group"></i> 
                                <span>{{ Lang::get('menu.top_menu_usergroups') }}</span>
                                </a>
                            </li>
                            @endif
                            @if(in_array('USERS',$permissions))
                            <li>
                                <a href="{{ action('Settings\UserController@index') }}">&nbsp;
                                <i class="fa fa-male"></i> 
                                <span class="master_users">{{ Lang::get('menu.top_menu_users') }}</span>
                                </a>
                            </li>
                            @endif
                            @if(in_array('SITESETTING',$permissions))
                            <li class="">
                                <a href="{{ action('Settings\SiteController@edit') }}">&nbsp;
                                <i class="fa fa-cog"></i> 
                                <span>{{ Lang::get('menu.top_menu_site_settings') }}</span>
                                </a>
                            </li>
                            @endif
                            <!-- <li class="hide" >
                                <a href="{{ action('Settings\SiteSettingController@index') }}">&nbsp;
                                <i class="fa fa-cog"></i> 
                                <span>{{ Lang::get('menu.top_menu_site_settings') }}</span>
                                </a>
                                </li> -->
                            @if(in_array('MAS_PROBLEM_SETTING',$permissions))   
                            <li>
                                <a href="{{ action('ProblemsSettings\ProblemsSettingController@index') }}">
                                <i class="fa fa-cogs" aria-hidden="true"></i>
                                <span>{{ Lang::get('menu.top_menu_psite_settings') }}</span>
                                </a>
                            </li>
                            @endif
                            <!-- <li><a href="{{ action('Settings\ComplaintsController@index') }}">&nbsp;<i class="fa fa-comments"></i> <span>Complaints</span></a></li> -->
                        </ul>
                    </li>
                    @endif
                    <!-- /user login dropdown -->
                    @endif
                </ul>
                <ul class="nav navbar-nav navbar-right" title="Masters">
                    @if (Auth::guest())
                    @else
                    @if(is_array($permissions) && count(array_intersect(['MAS_ANTIBIOTICS','MAS_COMPLICATIONS','MAS_M_PROBLEM','MAS_B_PROCEDUURE','MAS_B_PROBLEM','MAS_VACCINE','MAS_VACCINE_AGE','MAS_INDICATION','MAS_DOCTORS','MAS_ADMISSIONMODE','MAS_RESPIRATORYINDICATION','MAS_PROBLEM_SETTING','MAS_NURSE_LIST','MAS_REFERRAL','MAS_WARD','MAS_BED','MAS_FREQUENCY','MAS_DOSE','MAS_DRUG_IVFLUID','MAS_PRESCRIPTION_TYPE', 'MAS_DDST', 'MAS_BAYLEY_SCALE', 'MAS_SHORTCODE', 'MAS_ISSA_QUESTIONS'],$permissions))>0)
                    <li class="dropdown masters">
                        <a href="#" class="dropdown-toggle header-icons hover-fx" data-toggle="dropdown" style="padding-top: 4px; margin-top: 8px !important;" title="Masters">
                            <!-- <span class="icons-wrapper icons-wrapper-alt rounded-circle">
                                <span class="icons-wrapper-bg"></span> -->
                            <i class="fa fa-database fa-2x"></i>
                            <!-- </span> -->
                        </a>
                        <ul class="dropdown-menu master-drop-down">
                            <li class="title">
                                <span>{{ Lang::get('menu.top_menu_masters') }}</span>
                            </li>
                            @if(in_array('MAS_ANTIBIOTICS',$permissions))
                            <li class="hide">
                                <a href="{{ action('Masters\AntibioticController@index') }}">{{ Lang::get('menu.top_menu_antibiotics') }}</a>
                            </li>
                            @endif
                            @if(in_array('MAS_COMPLICATIONS',$permissions)) 
                            <li>
                                <a href="{{ action('Masters\ComplicationController@index') }}">{{ Lang::get('menu.top_menu_complications') }}</a>
                            </li>
                            @endif
                            <!--   @if(in_array('MAS_DRUGS',$permissions)) 
                                <li>
                                <a href="{{ action('Masters\DrugController@index') }}">{{ Lang::get('menu.top_menu_drugs') }}</a>
                                </li>
                                @endif -->
                            @if(in_array('MAS_M_PROBLEM',$permissions)) 
                            <li>
                                <a href="{{ action('Masters\MediprobsController@index') }}">{{ Lang::get('menu.top_menu_medical_problems') }}</a>
                            </li>
                            @endif
                            @if(in_array('MAS_B_PROCEDUURE',$permissions))  
                            <li>
                                <a href="{{ action('Masters\ProcedureController@index') }}">{{ Lang::get('menu.top_menu_procedures') }}</a>
                            </li>
                            @endif
                            @if(in_array('MAS_B_PROBLEM',$permissions)) 
                            <li>
                                <a href="{{ action('Masters\ProblemController@index') }}">{{ Lang::get('menu.top_menu_problems') }}</a>
                            </li>
                            @endif
                            @if(in_array('MAS_VACCINE_AGE',$permissions))   
                            <li>
                                <a href="{{ action('Masters\VaccineAgeController@index') }}">{{ Lang::get('menu.top_menu_vaccine_age') }}</a>
                            </li>
                            @endif
                            @if(in_array('MAS_VACCINE',$permissions))   
                            <li>
                                <a href="{{ action('Masters\VaccineController@index') }}">{{ Lang::get('menu.top_menu_vaccines') }}</a>
                            </li>
                            @endif
                            @if(in_array('REPORT_NICU',$permissions))   
                            <li>
                                <a href="{{ action('Admission\IcdController@index') }}">{{ Lang::get('menu.top_menu_icd_10') }}</a>
                            </li>
                            @endif
                            @if(in_array('MAS_INDICATION',$permissions))    
                            <li>
                                <a href="{{ action('Masters\IndicationController@index') }}">{{ Lang::get('menu.top_menu_indication') }}</a>
                            </li>
                            @endif
                            @if(in_array('MAS_DOCTORS',$permissions))   
                            <li>
                                <a href="{{ action('Masters\DoctorController@index') }}">{{ Lang::get('menu.top_menu_doctors_surgeons') }}</a>
                            </li>
                            @endif
                            @if(in_array('MAS_ADMISSIONMODE',$permissions)) 
                            <li>
                                <a href="{{ action('Masters\AdmissionmodeController@index') }}">{{ Lang::get('menu.top_menu_admission_mode') }}</a>
                            </li>
                            @endif
                            @if(in_array('MAS_RESPIRATORYINDICATION',$permissions)) 
                            <li>
                                <a href="{{ action('Masters\RespiratoryIndicationController@index') }}">{{ Lang::get('menu.top_menu_respiratory_indication') }}</a>
                            </li>
                            @endif
                            <!--     @if(in_array('MAS_IVFLUIDS',$permissions))  
                                <li>
                                <a href="{{ action('Masters\IvFluidsController@index') }}">{{ Lang::get('menu.top_menu_iv_fluid_med') }}</a>
                                </li>
                                @endif -->
                            @if(in_array('MAS_NURSE_LIST',$permissions))    
                            <li>
                                <a href="{{ action('Masters\NurseController@index') }}">{{ Lang::get('menu.top_menu_nurse_master') }}</a>
                            </li>
                            @endif
                            @if(in_array('MAS_REFERRAL',$permissions))    
                            <li>
                                <a href="{{ action('Masters\ReferralController@index') }}">{{ Lang::get('menu.top_menu_referral') }}</a>
                            </li>
                            @endif
                            @if(in_array('MAS_WARD',$permissions)) 
                            <li>
                                <a href="{{ action('Masters\WardController@index') }}">{{ Lang::get('menu.top_menu_ward') }}</a>
                            </li>
                            @endif
                            @if(in_array('MAS_BED',$permissions))  
                            <li>
                                <a href="{{ action('Masters\BedController@index') }}">{{ Lang::get('menu.top_menu_bed') }}</a>
                            </li>
                            @endif
                            @if(in_array('MAS_FREQUENCY', $permissions))
                            <li>
                                <a href="{{ action('Masters\FrequencyController@index') }}">{{ Lang::get('menu.top_menu_freq') }}</a>
                            </li>
                            @endif
                            @if(in_array('MAS_DOSE', $permissions))
                            <li>
                                <a href="{{ action('Masters\DoseController@index') }}">{{ Lang::get('menu.top_menu_dose') }}</a>
                            </li>
                            @endif
                            @if(in_array('MAS_DRUG_IVFLUID', $permissions))
                            <li>
                                <a href="{{ action('Masters\DrugIvFluidController@index') }}">{{ Lang::get('menu.top_menu_drugivfluid') }}</a>
                            </li>
                            @endif
                            @if(in_array('MAS_PRESCRIPTION_TYPE', $permissions))
                            <li>
                                <a href="{{ action('Masters\PrescriptionTypeController@index') }}">{{ Lang::get('menu.top_menu_prescriptiontype') }}</a>
                            </li>
                            @endif
                            @if(in_array('MAS_INVESTIGATIONS', $permissions))
                            <li>
                                <a href="{{ action('Masters\InvestigationsController@index') }}">{{ Lang::get('menu.top_menu_investigations') }}</a>
                            </li>
                            @endif
                            @if(in_array('MAS_M_CHAT_R_QUESTIONS', $permissions))
                            <li>
                                <a href="{{ action('Masters\MchatquestionsController@index') }}">{{ Lang::get('menu.top_menu_m_chat_r_questions') }}</a>
                            </li>
                            @endif
                            @if(in_array('MAS_M_CHAT_R_FOLLOWUP_QUESTIONS', $permissions))
                            <li>
                                <a href="{{ action('Masters\MchatfollowupquestionsController@index') }}">{{ Lang::get('menu.top_menu_m_chat_r_followup_questions') }}</a>
                            </li>
                            @endif
                            @if(in_array('MAS_DASII_QUESTIONS', $permissions))
                            <li>
                                <a href="{{ action('Masters\DasiiquestionsController@index') }}">{{ Lang::get('menu.top_menu_dasii_questions') }}</a>
                            </li>
                            @endif
                            @if(in_array('MAS_CBCL_QUESTIONS', $permissions))
                            <li>
                                <a href="{{ action('Masters\CBCLQuestionsController@index') }}">{{ Lang::get('menu.top_menu_cbcl_questions') }}</a>
                            </li>
                            @endif
                            @if(in_array('MAS_DDST', $permissions))
                            <li>
                                <a href="{{ action('Masters\DdstController@index') }}">{{ Lang::get('menu.top_menu_ddst_questions') }}</a>
                            </li>
                            @endif
                            @if(in_array('MAS_BAYLEY_SCALE', $permissions))
                            <li>
                                <a href="{{ action('Masters\BayleyScaleController@index') }}">{{ Lang::get('menu.top_menu_bayley_scale') }}</a>
                            </li>
                            @endif
                            @if(in_array('MAS_ISSA_QUESTIONS', $permissions))
                            <li>
                                <a href="{{ action('Masters\ISSAQuestionsController@index') }}">{{ Lang::get('menu.top_menu_issa_questions') }}</a>
                            </li>
                            @endif
                            @if(in_array('MAS_SHORTCODE', $permissions))
                            <li>
                                <a href="{{ action('Masters\ShortcodeController@index') }}">{{ Lang::get('menu.top_menu_shortcode') }}</a>
                            </li>
                            @endif
                        </ul>
                    </li>
                    @endif                                   
                    @endif
                </ul>
                <!-- /Top Right Menu -->
                @if (Auth::guest())
                @else
                <!-- <ul class="nav navbar-nav new-register flow-con hidden-xs hidden-sm">
                    <li>
                    <a href="javascript:void(0);" id="new-patinent">
                    <i class="fa fa fa-plus"></i><span>Registration / Admission</span>
                    </a>
                    </li>
                    </ul> -->
                @if(count(array_intersect(['NICU_DAY','POST_DAY'], \Session::get('write_permission'))) > 0)
                <!-- <ul class="nav navbar-nav hidden-xs  flow-con hidden-sm">
                    <li>
                    <a href="javascript:void(0);" id="daily-care">
                    <i class="fa fa-table"></i><span>Daily Entry</span>
                    </a>
                    </li>
                    </ul> -->
                @endif
                @if(count(array_intersect(['NICU_MODULE_SHEET'], \Session::get('write_permission'))) > 0)
                <!-- <ul class="nav navbar-nav hidden-xs  flow-con hidden-sm">
                    <li>
                    <a href="javascript:void(0);" id="nurse-daily-care">
                    <i class="fa fa-table"></i><span>Nurse Daily Entry</span>
                    </a>
                    </li>
                    </ul> -->
                @endif
                @if(count(array_intersect(['NICU_PROBLEM_DAY','POST_PROBLEM_SYSTEM'], \Session::get('write_permission'))) > 0)
                <!-- <ul class="nav navbar-nav hidden-xs flow-con hide hidden-sm">
                    <li>
                    <a href="javascript:void(0);" id="problem-based-entry">
                    <i class="fa fa-heartbeat"></i><span>Problem Sheet</span>
                    </a>
                    </li>
                    </ul> -->
                @endif
                @if(count(array_intersect(['NICU_DISCHARGE','POST_DISCHARGE'], \Session::get('write_permission'))) > 0)
                <!-- <ul class="nav navbar-nav hidden-xs flow-con hidden-sm">
                    <li>
                    <a hhref="javascript:void(0);" id="discharge-details">
                    <i class="fa fa-dashboard"></i><span>Discharge / Transfer</span>
                    </a>
                    </li>
                    </ul> -->
                @endif  
                <!-- <ul class="nav navbar-nav navbar-right">
                    <li style="margin: 3px 0px;">
                        <a href="#" id="add-complaints" class="header-icons hover-fx" title="Complaints" style="padding-top: 4px; margin-top: 8px !important;">
                        <i class="fa fa-comments fa-2x" aria-hidden="true"></i>
                        </a>
                    </li>
                </ul> -->
                 <ul class="nav navbar-nav navbar-right">
                    <li style="margin: 3px 0px;">
                        <a href="{{action('HomeController@search')}}" class="header-icons hover-fx" title="Reports search" style="padding-top: 4px; margin-top: 8px !important;">
                            <i class="fa fa-file fa-2x" aria-hidden="true"></i><i class="fa fa-search file-search-icon"></i>
                        </a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li style="margin: 3px 0px;">
                        <a href="{{action('HomeController@getTimelinePage')}}" class="header-icons hover-fx" title="Software Timeline" style="padding-top: 4px; margin-top: 8px !important;">
                            <i class="fa fa-list fa-2x"></i>
                        </a>
                    </li>
                </ul>
                {{--     
                <ul class="nav navbar-nav notify navbar-right">
                    @php $notification = SiteHelpers::getFlownotification(); @endphp
                    <li class="dropdown user hidden-xs" >
                        <a href="javascript:void(0);" class="dropdown-toggle notification show-count notify header-icons" data-toggle="dropdown" data-count="{{ count($notification) }}" title="Incomplete Record">
                        </a>
                        <ul class="dropdown-menu master-drop-down">
                            <li class="title">
                                <span>Incomplete Record</span>
                            </li>
                            @if(count($notification) != 0)      
                            @foreach($notification as $notificationlist)
                            <li>
                                <a href="{{ action('Flow\FlowController@resumeFlow', $notificationlist->fcid) }}">
                                @if(isset($notificationlist->baby_name))        
                                {{ title_case(str_replace('_', ' ', $notificationlist->module)).' - '. $notificationlist->baby_name .'-'. $notificationlist->mr_no}}
                                @else
                                {{ title_case(str_replace('_', ' ', $notificationlist->module)) }}
                                @endif      
                                <span class="badge"> {!! ($notificationlist->is_new_patient) ? 'New' : 'Reg' !!}</span>
                                </a>
                            </li>
                            @endforeach
                            <li>
                                <a href="{{ action('Flow\FlowController@index') }}"> More Details...</a>
                            </li>
                            @else
                            <li>
                                <a href="javascript::void(0);">No Record In Queue</a>
                            </li>
                            @endif      
                        </ul>
                    </li>
                </ul>
                --}}
                <ul class="nav navbar-nav notify border-left-none info-menu-icon">
                    @php $notification = SiteHelpers::getFlownotification(); @endphp
                    @if(Request::segment(1) == 'neonatal-search' || Request::segment(1) == 'nicu-search' 
                    || Request::segment(1) == 'nicu-admission-search-view' || Request::segment(1)=='daycare-search' ||
                    Request::segment(1) == 'daycare-search-box-view'|| Request::segment(1)=='quality-indicator-searchview' || Request::segment(1)=='quality-indicator-search')
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
                    @endif
                </ul>
                @endif
            </div>
            <!-- /top navigation bar -->
        </header>
        <div id="container" class="">
            @if (Auth::guest())
            <div id="content">
                <div class="container">
                    @yield('content')
                </div>
                <!-- /.container -->
            </div>
            @else    
            <div class="wrapper active">
                <div class="side-bar">
                    <ul>
                        <div class="menu">
                            @if(is_array($permissions) && count(array_intersect(['MOTHER_REG','BABY_REG'],$permissions))>0)
                            <li class="submenu {{ (isset($navigate) && $navigate['main_nav']=='register') ? 'open' : '' }}">
                                <a href="javascript:void(0);">
                                <i class="fas fa-registered pull-right" style="font-size: 20px;"></i>{{ Lang::get('menu.side_menu_registartion') }}
                                </a>
                                <ul class="sub-menu">
                                    <li class="title">
                                        <span>{{ Lang::get('menu.side_menu_registartion') }}</span>
                                    </li>
                                    @if(in_array('MOTHER_REG',$permissions))
                                    <li class="{{ (isset($navigate) && $navigate['sub_nav']=='mother') ? 'current' : '' }}">
                                        <a href="{{ action('Registration\MotherController@index') }}" >
                                        <i class="fa fa-female pull-right"></i>
                                        {{ Lang::get('menu.side_menu_mother_registartion') }}
                                        </a>
                                    </li>
                                    @endif
                                    @if(in_array('BABY_REG',$permissions))
                                    <li class="{{ (isset($navigate) && $navigate['sub_nav']=='baby') ? 'current' : '' }}">
                                        <a href="{{ action('Registration\BabyController@index') }}">
                                        <i class="fas fa-baby-carriage pull-right" style="font-size: 14px;"></i>
                                        {{ Lang::get('menu.side_menu_baby_registartion') }}
                                        </a>
                                    </li>
                                    @endif              
                                </ul>
                            </li>
                            @endif
                            @if(in_array('NEONATAL',$permissions))
                            <li class="submenu {{ (isset($navigate) && $navigate['main_nav']=='neo_proforma') ? 'open' : '' }}">
                                <a href="{{ action('Registration\NeonatalController@index') }}">
                                <i class="fas fa-baby pull-right" style="font-size: 26px;"></i>
                                {{ Lang::get('menu.side_menu_neonatal_proforma') }}
                                </a>
                                <ul class="sub-menu">
                                    <li class="title module">
                                        <a href="{{ action('Registration\NeonatalController@index') }}">
                                        {{ Lang::get('menu.side_menu_neonatal_proforma') }}
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            @endif
                            @if(is_array($permissions) && count(array_intersect(['MOTHER_REG','BABY_REG','NEONATAL'],$permissions))>0)
                            <li class="menu-separate"></li>
                            @endif
                            @if(is_array($permissions) && count(array_intersect(['NICU_FORM','NICU_DAY', 'NICU_PROBLEM_DAY','NICU_DISCHARGE','NICU_PROBLEM_DISCHARGE'],$permissions))>0)
                            <li class="submenu {{ (isset($navigate) && $navigate['main_nav']=='nicu') ? 'open' : '' }}">
                                <a href="javascript:void(0);">
                                <i class="fas fa-dolly-flatbed pull-right custom-menu-icon-size" style="font-size: 16px !important;"></i>
                                {{ Lang::get('menu.side_menu_nicu_admission') }} <img src="data:image/svg+xml;utf8,<svg fill='white' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/><path d='M0 0h24v24H0z' fill='none'/></svg>" class="{{ (isset($navigate) && $navigate['main_nav']=='nicu') ? 'transform-180' : '' }}" />
                                </a>
                                <ul class="sub-menu">
                                    <li class="title">
                                        <span>{{ Lang::get('menu.side_menu_nicu_admission') }}</span>
                                    </li>
                                    @if(in_array('NICU_FORM',$permissions))
                                    <li class="@if(isset($navigate) && $navigate['sub_nav']=='nicu_proforma')current @endif">
                                        <a href="{{ action('Admission\NicuController@index') }}">
                                        <i class="fas fa-book-medical pull-right" style="font-size: 17px;"></i>
                                        {{ Lang::get('menu.side_menu_nicu_admission_proforma') }}
                                        </a>
                                    </li>
                                    @endif
                                    @if(in_array('NICU_DAY',$permissions))
                                    <li class="@if(isset($navigate) && $navigate['sub_nav']=='nicu_daycare')current @endif">
                                        <a href="{{ action('Admission\DaycareController@index') }}">
                                        <i class="fas fa-user-md pull-right" style="font-size: 16px;"></i>
                                        {{ Lang::get('menu.side_menu_nicu_daycare') }}
                                        </a>
                                    </li>
                                    @endif
                                    @if(in_array('NICU_PROBLEM_DAY',$permissions))
                                    <li class="@if(isset($navigate) && $navigate['sub_nav']=='nicu_problem_base') current @endif">
                                        <a href="{{ action('ProblemBaseDaycare\ProblemDaycareController@index') }}">
                                        <i class="fas fa-notes-medical pull-right" style="font-size: 18px !important;"></i>
                                        {{ Lang::get('menu.side_menu_problem_base_daycare') }}
                                        </a>
                                    </li>
                                    @endif
                                    @if(in_array('NICU_DISCHARGE',$permissions))
                                    <li class="@if(isset($navigate) && $navigate['sub_nav']=='discharge-list') current @endif">
                                        <a href="{{ action('Admission\NicuController@dischargeList') }}">
                                        <i class="fas fa-user-clock pull-right custom-menu-icon-size" style="font-size: 13px !important;"></i>
                                        {{ Lang::get('menu.side_menu_nicu_discharge_details') }}
                                        </a>
                                    </li>
                                    @endif
                                    @if(in_array('NICU_DISCHARGE',$permissions))                         
                                    <!-- <li class="@if(isset($navigate) && $navigate['sub_nav']=='nicu_discharge') current @endif">
                                        <a href="{{ action('Reports\NicuDischargeController@discharge_main_list') }}/interim">
                                        <img src="{{$site_url}}/img/icons/menu/medical_notes.png" class="pull-right" alt="Interim Summary ( Daycare )" width="20" height="40"> 
                                        {{ Lang::get('menu.side_menu_daycare_interim_summary') }}
                                        </a>
                                        </li> -->
                                    @endif
                                    @if(in_array('NICU_DISCHARGE',$permissions))                         
                                    <li class="@if(isset($navigate) && $navigate['sub_nav']=='nicu_discharge') current @endif">
                                        <a href="{{ action('Reports\NicuDischargeController@discharge_main_list') }}">
                                        <i class="fas fa-sticky-note pull-right custom-menu-icon-size"></i>
                                        {{ Lang::get('menu.side_menu_nicu_discharge_summary') }}
                                        </a>
                                    </li>
                                    @endif  
                                    @if(in_array('NICU_PROBLEM_DISCHARGE',$permissions))                         
                                    <!-- <li class="@if(isset($navigate) && $navigate['sub_nav']=='problem_nicu_discharge')current @endif">
                                        <a href="{{ action('Reports\ProblemDischargeController@dischargeBabylist') }}/interim">
                                        <img src="{{$site_url}}/img/icons/menu/problem_base_discharge.png" class="pull-right" alt="NICU Discharge Summary Probelm base" width="22" height="20">
                                        {{ Lang::get('menu.side_menu_problem_interim_summary') }}
                                        </a> -->
                                    </li>
                                    @endif  
                                    @if(in_array('NICU_PROBLEM_DISCHARGE',$permissions))                         
                                    <li class="@if(isset($navigate) && $navigate['sub_nav']=='problem_nicu_discharge')current @endif">
                                        <a href="{{ action('Reports\ProblemDischargeController@dischargeBabylist') }}">
                                        <i class="fas fa-list-alt pull-right custom-menu-icon-size"></i>
                                        {{ Lang::get('menu.side_menu_nicu_problem_summary') }}
                                        </a>
                                    </li>
                                    @endif  
                                </ul>
                            </li>
                            @endif
                            @if(is_array($permissions) && in_array('NICU_NURSE_DAY',$permissions))   
                            <!-- <li class="submenu {{ (isset($navigate) && $navigate['main_nav']=='nicu_nurse_day') ? 'open' : '' }}">
                                <a href="{{ action('Nurse\NicuNurseDaycareController@index') }}">
                                    <i class="fas fa-edit pull-right custom-menu-icon-size" style="font-size: 16px !important;"></i>
                                    {{ Lang::get('menu.side_menu_nurse_daycare') }}
                                </a>
                                <ul class="sub-menu">
                                    <li class="title module">
                                        <a href="{{ action('Nurse\NicuNurseDaycareController@index') }}">
                                            {{ Lang::get('menu.side_menu_nurse_daycare') }}
                                        </a>
                                    </li>
                                </ul>
                                </li> -->
                            @endif 
                            @if(is_array($permissions) && in_array('NICU_MODULE_SHEET',$permissions))   
                            <li class="submenu {{ (isset($navigate) && $navigate['main_nav']=='nicu_nurse_sheet') ? 'open' : '' }}">
                                <a href="{{ action('Nurse\NurseSheetController@index') }}">
                                <i class="fas fa-user-nurse pull-right" style="font-size: 23px !important"></i>
                                {{ Lang::get('menu.side_menu_nurse_hourly_sheet') }}
                                </a>
                                <ul class="sub-menu">
                                    <li class="title module">
                                        <a href="{{ action('Nurse\NurseSheetController@index') }}">
                                        {{ Lang::get('menu.side_menu_nurse_hourly_sheet') }}
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            @endif  
                            @if(is_array($permissions) && count(array_intersect(['PEDI_FORM'],$permissions))>0)
                            <li class="submenu {{ (isset($navigate) && $navigate['main_nav']=='pediatric') ? 'open' : '' }}">
                                <a href="{{ action('Admission\PediatricController@index') }}">
                                <i class="fas fa-child pull-right" style="font-size: 23px !important"></i>
                                {{ Lang::get('menu.side_menu_pediatric_admission') }}
                                </a>
                                <ul class="sub-menu">
                                    <li class="title module">
                                        <a href="{{ action('Admission\PediatricController@index') }}">
                                        {{ Lang::get('menu.side_menu_pediatric_admission') }}
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            @endif
                            @if(is_array($permissions) && in_array('WARD_MANAGEMENT',$permissions))   
                            <li class="submenu {{ (isset($navigate) && $navigate['main_nav']=='ward-dashboard') ? 'open' : '' }}">
                                <a href="{{ action('Ward\BabyWardController@index') }}">
                                <i class="fas fa-bed pull-right custom-menu-icon-size" aria-hidden="true" style="font-size: 16px !important"></i>
                                {{ Lang::get('menu.card_ward_mangagement') }}
                                </a>
                                <ul class="sub-menu">
                                    <li class="title module">
                                        <a href="{{ action('Ward\BabyWardController@index') }}">
                                        {{ Lang::get('menu.card_ward_mangagement') }}
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            @endif  
                            @if(is_array($permissions) && in_array('PRESCRIPTION',\Session::get('write_permission')))   
                            <li class="submenu {{ (isset($navigate) && $navigate['main_nav']=='prescription') ? 'open' : '' }}">
                                <a href="{{ action('prescription\PrescriptionController@create') }}">
                                {{ Lang::get('menu.side_menu_prescription') }}  
                                <i class="fas fa-prescription pull-right" style="padding: 0px 2px;font-size: 21px;"></i>
                                </a>
                                <ul class="sub-menu">
                                    <li class="title module">
                                        <a href="{{ action('prescription\PrescriptionController@create') }}">
                                        {{ Lang::get('menu.side_menu_prescription') }} 
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            @endif    
                            @if(is_array($permissions) && in_array('CLINICAL_EVENT',\Session::get('write_permission')))   
                            <li class="submenu {{ (isset($navigate) && $navigate['main_nav'] == 'Events') ? 'open' : '' }}">
                                <a href="javascript:void(0);">
                                <i class="fas fa-first-aid pull-right" style="font-size: 18px;"></i>
                                Events <img src="data:image/svg+xml;utf8,<svg fill='white' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/><path d='M0 0h24v24H0z' fill='none'/></svg>" class="{{ (isset($navigate) && $navigate['main_nav']=='nicu') ? 'transform-180' : '' }}" />
                                </a>
                                <ul class="sub-menu">
                                    <li class="title">
                                        <span>Events</span>
                                    </li>
                                    <li class="submenu {{ (isset($navigate) && $navigate['sub_nav'] == 'Care Event') ? 'open' : '' }}">
                                        <a href="{{ action('Nurse\DashboardEventController@index') }}">
                                        {{ Lang::get('menu.side_menu_nicu_care_events') }} 
                                        <i class="fa fa-thumb-tack pull-right" style="font-size: 18px; transform: rotate(45deg);"></i>
                                        </a>
                                    </li>
                                    <li class="submenu {{ (isset($navigate) && $navigate['sub_nav'] == 'Clinical Event') ? 'open' : '' }}">
                                        <a href="{{ action('ClinicalEventController@create') }}">
                                        <i class="fas fa-first-aid pull-right" style="font-size: 16px;"></i>
                                        {{ Lang::get('menu.side_menu_nicu_clinical_events') }} 
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            @endif    
                            @if(is_array($permissions) && in_array('WARD_MANAGEMENT',$permissions))   
                            @if(env('MONITOR_INTERFACE') || env('VENTILATOR_MACHINE') || env('LAB_INTERFACE'))
                            <li class="submenu {{ (isset($navigate) && $navigate['main_nav']=='interface_log') ? 'open' : '' }}">
                                <a href="javascript:void(0);">
                                <i class="fa fa-desktop pull-right custom-menu-icon-size" style="font-size: 18px !important"></i>
                                {{ Lang::get('menu.side_menu_interface_data') }} <img src="data:image/svg+xml;utf8,<svg fill='white' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/><path d='M0 0h24v24H0z' fill='none'/></svg>" class="{{ (isset($navigate) && $navigate['main_nav']=='nicu') ? 'transform-180' : '' }}" />
                                </a>
                                <ul class="sub-menu">
                                    <li class="title">
                                        <span>{{ Lang::get('menu.side_menu_interface_data') }}</span>
                                    </li>
                                    <li class="{{ (isset($navigate) && $navigate['sub_nav']=='interface_monitor') ? 'current' : '' }}">
                                        <a href="{{ action('Fhir\FhirFormattedValuesController@monitordata') }}">
                                        <i class="fas fa-pager pull-right" style="font-size: 16px;"></i>
                                        {{ Lang::get('menu.side_menu_monitor') }}
                                        </a>
                                    </li>
                                    <li class="{{ (isset($navigate) && $navigate['sub_nav']=='interface_ventilator') ? 'current' : '' }}">
                                        <a href="{{ action('Fhir\FhirFormattedValuesController@ventilatordata') }}">
                                        <i class="fas fa-lungs pull-right" style="font-size: 14px;"></i>
                                        {{ Lang::get('menu.side_menu_ventilator') }}
                                        </a>
                                    </li>
                                    <li class="{{ (isset($navigate) && $navigate['sub_nav']=='interface_prescription') ? 'current' : '' }}">
                                        <a href="{{ action('Fhir\FhirFormattedValuesController@pumpdata') }}">
                                        <i class="fas fa-syringe pull-right" style="font-size: 16px;"></i>
                                        {{ Lang::get('menu.side_menu_pump') }}
                                        </a>
                                    </li>
                                    @if (env('SUPER_ADMIN_ROLE') == $role_id)
                                    <li class="">
                                        <a href="{{ action('LocalCodeGroupController@index') }}">
                                        <i class="fa fa-code pull-right" style="font-size: 16px;"></i>
                                        Local Code Group
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                            </li>
                            @endif  
                            @endif  
                            @if(is_array($permissions) && count(array_intersect(['GROWTH_CHART','NICU_MODULE_SHEET'],$permissions))>0)
                            <li class="submenu {{ (isset($navigate) && $navigate['main_nav']=='chart') ? 'open' : '' }}">
                                <a href="javascript:void(0);">    
                                <i class="fas fa-pie-chart pull-right" style="font-size: 19px"></i>
                                Chart <img src="data:image/svg+xml;utf8,<svg fill='white' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/><path d='M0 0h24v24H0z' fill='none'/></svg>" class="{{ (isset($navigate) && $navigate['main_nav']=='nicu') ? 'transform-180' : '' }}" />
                                </a>
                                <ul class="sub-menu">
                                    <li class="title">
                                        <span>Chart</span>
                                    </li>
                                    @if(in_array('GROWTH_CHART',$permissions))                    
                                    <li class="{{ (isset($navigate) && $navigate['sub_nav']=='growth_chart') ? 'current' : '' }}">
                                        <a href="{{ action('Growthchart\GrowthChartController@index') }}">
                                        <i class="fa fa-sort-amount-asc pull-right" aria-hidden="true" style="transform: rotate(180deg); font-size: 14px;"></i>
                                        {{ Lang::get('menu.side_menu_growth_chart') }}
                                        </a>
                                    </li>
                                    @endif   
                                    @if(in_array('NICU_MODULE_SHEET',$permissions))
                                    <li class="{{ (isset($navigate) && $navigate['sub_nav']=='single_chart') ? 'current' : '' }}">
                                        <a href="{{ action('Nurse\NurseSheetController@chartBabySelect') }}" class="" data-placement="right" data-title="Single Chart">
                                        <i class="fa fa-line-chart pull-right" style="font-size: 13px;" aria-hidden="true"></i>
                                        Single Chart
                                        </a>
                                    </li>
                                    @endif
                                    @if(in_array('NICU_MODULE_SHEET',$permissions))
                                    <li class="{{ (isset($navigate) && $navigate['sub_nav']=='all_in_one_chart') ? 'current' : '' }}">
                                        <a href="{{ action('Nurse\NurseSheetController@allInOneChartBabySelect') }}" class="" data-placement="right" data-title="All-In-One Chart">
                                        <i class="fa fa-area-chart pull-right" style="font-size: 13px;" aria-hidden="true"></i>
                                        All-In-One Chart
                                        </a>
                                    </li>
                                    @endif                                    
                                </ul>
                            </li>
                            @endif
                            @if(is_array($permissions) && in_array('LABREQUEST',$permissions))   
                            <li class="submenu {{ (isset($navigate) && $navigate['main_nav']=='lab_reports') ? 'open' : '' }}">
                                <a href="javascript:void(0);">    
                                <i class="fa fa-flask pull-right" aria-hidden="true"></i>
                                Lab Report <img src="data:image/svg+xml;utf8,<svg fill='white' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/><path d='M0 0h24v24H0z' fill='none'/></svg>" class="{{ (isset($navigate) && $navigate['main_nav']=='nicu') ? 'transform-180' : '' }}" />
                                </a>
                                <ul class="sub-menu">
                                    <li class="title">
                                        <span>Lab Report</span>
                                    </li>
                                    <li class="{{ (isset($navigate) && $navigate['sub_nav']=='lab_report') ? 'current' : '' }}">
                                        <a href="{{ action('Nurse\NurseSheetController@labBabySelect') }}">
                                        <i class="fa fa-flask pull-right" aria-hidden="true"></i>
                                        Admission Wise Report
                                        </a>
                                    </li>
                                    <li class="{{ (isset($navigate) && $navigate['sub_nav']=='lab_report_all') ? 'current' : '' }}">
                                        <a href="{{ action('Nurse\NurseSheetController@labBabySelect', 'overall') }}" class="" data-placement="right" data-title="Single Chart">
                                        <i class="fa fa-flask pull-right" aria-hidden="true"></i>
                                        Overall Lab Report
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            @endif 
                            @if(is_array($permissions) && in_array('NICU_MODULE_SHEET',$permissions))   
                            <li class="submenu {{ (isset($navigate) && $navigate['main_nav']=='weekly_observation') ? 'open' : '' }}">
                                <a href="{{ action('Nurse\NurseSheetController@weeklyObservationBabySelect') }}">
                                <i class="fa fa-print pull-right" aria-hidden="true"></i>
                                Weekly Observations
                                </a>
                                <ul class="sub-menu">
                                    <li class="title module">
                                        <a href="{{ action('Nurse\NurseSheetController@weeklyObservationBabySelect') }}">
                                        Weekly Observations
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            @endif  
                            @if(is_array($permissions) && count(array_intersect(['NICU_FORM','NICU_DAY', 'NICU_PROBLEM_DAY','NICU_DISCHARGE','NICU_PROBLEM_DISCHARGE','NICU_NURSE_DAY','NICU_MODULE_SHEET','WARD_MANAGEMENT'],$permissions))>0)
                            <li class="menu-separate"></li>
                            @endif
                            @if(is_array($permissions) && count(array_intersect(['POST_FORM','POST_DAY','POST_PROBLEM_SYSTEM','POST_DISCHARGE'],$permissions))>0)
                            <li class="submenu {{ (isset($navigate) && $navigate['main_nav']=='postnatal') ? 'open' : '' }}">
                                <a href="javascript:void(0);">    
                                <i class="fas fa-clinic-medical pull-right" style="font-size: 18px;"></i>
                                {{ Lang::get('menu.side_menu_postnatal_admission') }} <img src="data:image/svg+xml;utf8,<svg fill='white' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/><path d='M0 0h24v24H0z' fill='none'/></svg>" class="{{ (isset($navigate) && $navigate['main_nav']=='postnatal') ? 'transform-180' : '' }}" />
                                </a>
                                <ul class="sub-menu">
                                    <li class="title">
                                        <span>{{ Lang::get('menu.side_menu_postnatal_admission') }}</span>
                                    </li>
                                    @if(in_array('POST_FORM',$permissions))
                                    <li class="{{ (isset($navigate) && $navigate['sub_nav']=='postnatal_proforma') ? 'current' : '' }}">
                                        <a href="{{ action('Admission\PostnatalController@index') }}">
                                        <i class="fas fa-book-medical pull-right" style="font-size: 16px;"></i>
                                        {{ Lang::get('menu.side_menu_postnatal_admission_form') }}
                                        </a>
                                    </li>
                                    @endif
                                    @if(in_array('POST_DAY',$permissions))
                                    <li class="{{ (isset($navigate) && $navigate['sub_nav']=='post_daycare') ? 'current' : '' }}">
                                        <a href="{{ action('Admission\PostnatalDaycareController@index') }}">
                                        <i class="fa fa-user-md pull-right"></i>
                                        {{ Lang::get('menu.side_menu_postnatal_daycare') }}
                                        </a>
                                    </li>
                                    @endif
                                    @if(in_array('POST_PROBLEM_SYSTEM',$permissions))
                                    <li class="{{ (isset($navigate) && $navigate['sub_nav']=='post_problem_system') ? 'current' : '' }}">
                                        <a href="{{ action('ProblemBaseDaycare\ProblemPostnatalController@index') }}">
                                        <i class="pull-right fas fa-notes-medical"></i>
                                        {{ Lang::get('menu.side_menu_postnatal_problem') }}
                                        </a>
                                    </li>
                                    @endif
                                    @if(in_array('POST_DISCHARGE',$permissions))
                                    <li class="{{ (isset($navigate) && $navigate['sub_nav']=='post_discharge') ? 'current ' : '' }}">
                                        <a href="{{ action('Admission\PostnatalDischargeController@index') }}">
                                        <i class="pull-right fas fa-user-clock custom-menu-icon-size" style="font-size: 12px !important;"></i>
                                        {{ Lang::get('menu.side_menu_postnatal_details') }}
                                        </a>
                                    </li>
                                    @endif 
                                    @if(in_array('POST_DISCHARGE',$permissions))
                                    <li class="{{ (isset($navigate) && $navigate['sub_nav']=='post_problem_discharge') ? 'current' : '' }} ">
                                        <a href="{{ action('Reports\PostnatalDischargeSummary@index') }}">
                                        <i class="pull-right fas fa-sticky-note custom-menu-icon-size" style="font-size: 17px !important;"></i>
                                        {{ Lang::get('menu.side_menu_postnatal_summary') }}
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                            </li>
                            <li class="menu-separate"></li>
                            @endif
                            @if(in_array('OP_REG',$permissions) || in_array('PEDIATRICS_OP_REG', $permissions) || in_array('NEURO_DEVELOPMENT',$permissions) || in_array('BAYLEY_SCALE',$permissions))
                            <li class="submenu @if(isset($navigate) && $navigate['sub_nav']=='op') open @endif">
                                <a href="javascript:void(0);">
                                <i class="fa fa-user-md pull-right" style="font-size: 25px;"></i>
                                {{ Lang::get('menu.side_menu_op_registration') }} <img src="data:image/svg+xml;utf8,<svg fill='white' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/><path d='M0 0h24v24H0z' fill='none'/></svg>" class="{{ (isset($navigate) && $navigate['main_nav']=='postnatal') ? 'transform-180' : '' }}" />
                                </a>
                                <ul class="sub-menu">
                                    <li class="title">
                                        <span>{{ Lang::get('menu.side_menu_op_registration') }}</span>
                                    </li>
                                    @if(in_array('OP_REG',$permissions))
                                    <li class="{{ (isset($navigate) && $navigate['sub_nav']=='neo') ? 'current' : '' }} ">
                                        <a href="{{ action('Registration\OpController@index') }}">
                                        {{ Lang::get('menu.side_menu_neo_op_registration') }}
                                        </a>
                                    </li>
                                    @endif   
                                    @if(in_array('PEDIATRICS_OP_REG', $permissions))
                                    <li class="{{ (isset($navigate) && $navigate['sub_nav']=='pediatric') ? 'current' : '' }} ">
                                        <a href="{{ action('Registration\PediatricOpController@index') }}">
                                        {{ Lang::get('menu.side_menu_pediatrics_op_registration') }}
                                        </a>
                                    </li>
                                    @endif      
                                    @if(in_array('NEURO_DEVELOPMENT',$permissions))
                                    <li class="{{ (isset($navigate) && $navigate['sub_nav']=='neuro') ? 'current' : '' }} ">
                                        <a href="{{ action('Registration\NeuroController@index') }}">
                                        {{ Lang::get('menu.side_menu_neuro') }}
                                        </a>
                                    </li>
                                    @endif
                                    @if(in_array('FEEDING',$permissions))
                                    <li class="{{ (isset($navigate) && $navigate['sub_nav']=='feeding') ? 'current' : '' }} ">
                                        <a href="{{ action('Registration\FeedingController@index') }}">
                                        {{ Lang::get('menu.side_menu_feeding') }}
                                        </a>
                                    </li>
                                    @endif  
                                </ul>
                            </li>
                            <li class="menu-separate"></li>
                            @endif
                            @if(is_array($permissions) && count(array_intersect(['TEST_ECHO','TEST_ULTRA','TEST_CULTURE'],$permissions))>0)           
                            <li class="submenu {{ (isset($navigate) && $navigate['main_nav']=='tests') ? 'open' : '' }}">
                                <a href="javascript:void(0);">
                                <i class="fa fa-filter pull-right" style="font-size: 24px;"></i>
                                {{ Lang::get('menu.side_menu_tests') }} <img src="data:image/svg+xml;utf8,<svg fill='white' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/><path d='M0 0h24v24H0z' fill='none'/></svg>" class="{{ (isset($navigate) && $navigate['main_nav']=='tests') ? 'transform-180' : '' }}" />
                                </a>                    
                                <ul class="sub-menu">
                                    <li class="title">
                                        <span>{{ Lang::get('menu.side_menu_tests') }}</span>
                                    </li>
                                    @if(in_array('TEST_ECHO',$permissions))
                                    <li class="{{ (isset($navigate) && $navigate['sub_nav']=='cardio') ? 'current' : '' }}">
                                        <a href="{{ action('Extras\CardioController@index') }}">
                                        <i class="fa fa-life-ring pull-right" style="font-size: 15px;"></i>
                                        {{ Lang::get('menu.side_menu_test_echocardiography') }}
                                        </a>
                                    </li>
                                    @endif
                                    @if(in_array('TEST_ULTRA',$permissions))
                                    <li class="{{ (isset($navigate) && $navigate['sub_nav']=='ultra') ? 'current' : '' }}">
                                        <a href="{{ action('Extras\UltraController@index') }}">
                                        <i class="fa fa-life-ring pull-right" style="font-size: 15px;"></i>
                                        {{ Lang::get('menu.side_menu_test_cranial_ultrasonography') }}
                                        </a>
                                    </li>
                                    @endif
                                    @if(in_array('TEST_CULTURE',$permissions))                       
                                    <li class="{{ (isset($navigate) && $navigate['sub_nav']=='culture') ? 'current' : '' }} ">
                                        <a href="{{ action('Extras\CultureController@index') }}">
                                        <i class="fa fa-life-ring pull-right" style="font-size: 15px;"></i>
                                        {{ Lang::get('menu.side_menu_test_culture_registry') }}
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                            </li>
                            @endif 
                            @if(is_array($permissions) && in_array('QUALITY_INDICATORS',$permissions))   
                            <li class="submenu {{ (isset($navigate) && $navigate['main_nav']=='quality_indicator') ? 'open' : '' }}">
                                <a href="{{ action('Quality\QualityController@index') }}">
                                <i class="fa fa-line-chart pull-right custom-menu-icon-size" aria-hidden="true" style="font-size: 16px !important"></i>
                                {{ Lang::get('menu.side_menu_quality_indicator') }}
                                </a>
                                <ul class="sub-menu">
                                    <li class="title module">
                                        <a href="{{ action('Quality\QualityController@index') }}">
                                        {{ Lang::get('menu.side_menu_quality_indicator') }}
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            @endif 
                            @if(is_array($permissions) && count(array_intersect(['REPORT_INPATIENT','REPORT_NICU','REPORT_OP','REPORT_NEWBORN','REPORT_BIRTH','REPORT_ECHO','REPORT_CRANIAL','REPORT_OP_ACTIVITY','REPORT_ANNUAL', 'USAGE_TRACKER'],$permissions))>0) 
                            <li class="submenu {{ (isset($navigate) && $navigate['main_nav']=='report') ? 'open' : '' }}" id="report-nav">
                                <a href="javascript:void(0);">
                                <i class="pull-right fas fa-file-alt" style="font-size: 22px;"></i>
                                {{ Lang::get('menu.side_menu_reports') }} <img src="data:image/svg+xml;utf8,<svg fill='white' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/><path d='M0 0h24v24H0z' fill='none'/></svg>" class="{{ (isset($navigate) && $navigate['main_nav']=='report') ? 'transform-180' : '' }}" />
                                </a>
                                <ul class="sub-menu">
                                    <li class="title">
                                        <span>{{ Lang::get('menu.side_menu_reports') }}</span>
                                    </li>
                                    @if(in_array('REPORT_BABY',$permissions))
                                    <li class="{{ (isset($navigate) && $navigate['sub_nav']=='inpatient_report') ? 'current' : '' }}">
                                        <a href="{{ action('Reports\BabyReportController@index') }}">
                                        <i class="pull-right fa fa-file-pdf-o" style="font-size: 16px;"></i>
                                        {{ Lang::get('menu.side_menu_baby_tag_print') }}
                                        </a>
                                    </li>
                                    @endif
                                    @if(in_array('REPORT_INPATIENT',$permissions))
                                    <li class="{{ (isset($navigate) && $navigate['sub_nav']=='inpatient_report') ? 'current' : '' }}">
                                        <a href="{{ action('Reports\InpatientListController@index') }}">
                                        <i class="pull-right fa fa-file-pdf-o" style="font-size: 16px;"></i>
                                        {{ Lang::get('menu.side_menu_inpatient_report') }}
                                        </a>
                                    </li>
                                    @endif
                                    @if(in_array('REPORT_NICU',$permissions))
                                    <li class="{{ (isset($navigate) && $navigate['sub_nav']=='nicu_report') ? 'current' : '' }}">
                                        <a href="{{ action('Reports\NicuReportController@index') }}">
                                        <i class="pull-right fa fa-file-pdf-o" style="font-size: 16px;"></i>
                                        {{ Lang::get('menu.side_menu_nicu_report') }}
                                        </a>
                                    </li>
                                    @endif
                                    @if(in_array('REPORT_OP',$permissions))
                                    <li class="{{ (isset($navigate) && $navigate['sub_nav']=='op_report') ? 'current' : '' }} ">
                                        <a href="{{ action('Reports\OpReportController@index') }}">
                                        <i class="pull-right fa fa-file-pdf-o" style="font-size: 16px;"></i>
                                        {{ Lang::get('menu.side_menu_op_report') }}
                                        </a>
                                    </li>
                                    @endif
                                    @if(in_array('REPORT_PEDI',$permissions))
                                    <li class="{{ (isset($navigate) && $navigate['sub_nav']=='pediatric_report') ? 'current' : '' }} hide">
                                        <a href="{{ action('Reports\PediatricReportController@index') }} ">
                                        <i class="pull-right fa fa-file-pdf-o" style="font-size: 16px;"></i>
                                        {{ Lang::get('menu.side_menu_pediatric_report') }}
                                        </a>
                                    </li>
                                    @endif
                                    @if(in_array('REPORT_NEWBORN',$permissions))                                
                                    <li class="{{ (isset($navigate) && $navigate['sub_nav']=='newborn_report') ? 'current' : '' }} ">
                                        <a href="{{ action('Reports\NbReportController@index') }}">
                                        <i class="pull-right fa fa-file-pdf-o" style="font-size: 16px;"></i>
                                        {{ Lang::get('menu.side_menu_newborn_report') }}
                                        </a>
                                    </li>
                                    @endif
                                    @if(in_array('REPORT_CULTURE',$permissions))                                
                                    <li class="{{ (isset($navigate) && $navigate['sub_nav']=='culture_report') ? 'current' : '' }} hide">
                                        <a href="{{ action('Reports\CultureReportController@index') }}">
                                        <i class="pull-right fa fa-file-pdf-o" style="font-size: 16px;"></i>
                                        {{ Lang::get('menu.side_menu_culture_report') }}
                                        </a>
                                    </li>
                                    @endif
                                    @if(in_array('REPORT_BIRTH',$permissions))                                
                                    <li class="{{ (isset($navigate) && $navigate['sub_nav']=='birth_report') ? 'current' : '' }}">
                                        <a href="{{ action('Reports\BirthReportController@index') }}">
                                        <i class="pull-right fa fa-file-pdf-o" style="font-size: 16px;"></i>
                                        {{ Lang::get('menu.side_menu_live_birth_report') }}
                                        </a>
                                    </li>
                                    @endif    
                                    @if(in_array('REPORT_ECHO',$permissions))  
                                    <li class="{{ (isset($navigate) && $navigate['sub_nav']=='echo_report') ? 'current' : '' }}">
                                        <a href="{{ action('Reports\EchoReportsController@filter') }}">
                                        <i class="pull-right fa fa-file-pdf-o" style="font-size: 16px;"></i>
                                        {{ Lang::get('menu.side_menu_echo_report') }}
                                        </a>
                                    </li>
                                    @endif  
                                    @if(in_array('REPORT_CRANIAL',$permissions))  
                                    <li class="{{ (isset($navigate) && $navigate['sub_nav']=='cranial_report') ? 'current' : '' }}">
                                        <a href="{{ action('Reports\CranialReportController@filter') }}">
                                        <i class="pull-right fa fa-file-pdf-o" style="font-size: 16px;"></i>
                                        {{ Lang::get('menu.side_menu_cranial_report') }}
                                        </a>
                                    </li>
                                    @endif  
                                    @if(in_array('REPORT_OP_ACTIVITY',$permissions))  
                                    <li class="{{ (isset($navigate) && $navigate['sub_nav']=='op_activity_report') ? 'current' : '' }}">
                                        <a href="{{ action('Reports\OpActivityController@filter') }}">
                                        <i class="pull-right fa fa-file-pdf-o" style="font-size: 16px;"></i>
                                        {{ Lang::get('menu.side_menu_op_activity_report') }}
                                        </a></a>
                                    </li>
                                    @endif
                                    @if(in_array('REPORT_ANNUAL',$permissions))  
                                    <li class="{{ (isset($navigate) && $navigate['sub_nav']=='annual_report') ? 'current' : '' }}">
                                        <a href="{{ action('Reports\AnnualReportsController@create') }}"><i class="pull-right fa fa-file-pdf-o"></i>{{ Lang::get('menu.side_menu_annual_reports') }}
                                        </a>
                                    </li>
                                    @endif           
                                    @if (in_array('USAGE_TRACKER', $permissions))
                                    <li class="{{ (isset($navigate) && $navigate['sub_nav']=='usage_tracker') ? 'current' : '' }}">
                                        <a href="{{ action('Reports\UsageTrackController@list') }}"><i class="pull-right fa fa-file-pdf-o"></i>{{ Lang::get('menu.side_menu_usage_tracker') }}
                                        </a>
                                    </li>
                                    @endif                  
                                    @if (in_array('REPORT_NNF', $permissions) || in_array(Auth::user()->id, json_decode(env('NNF_USER_ID'))))
                                    <li class="{{ (isset($navigate) && $navigate['sub_nav']=='nnf') ? 'current' : '' }}">
                                        <a href="{{ action('Reports\NNFController@filter') }}"><i class="pull-right fa fa-file-pdf-o"></i>{{ Lang::get('menu.side_menu_nnf') }}
                                        </a>
                                    </li>
                                    @endif                 
                                </ul>
                            </li>
                            @endif                                      
                            @if(is_array($permissions) && in_array('CALCULATOR',$permissions))               
                            <li class="submenu {{ (isset($navigate) && $navigate['main_nav']=='calc') ? 'open' : '' }}" id="calc-nav">
                                <a href="javascript:void(0);">
                                <i class="fa fa-calculator pull-right custom-menu-icon-size" style="font-size: 18px !important;"></i>
                                {{ Lang::get('menu.side_menu_calculators') }} <img src="data:image/svg+xml;utf8,<svg fill='white' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/><path d='M0 0h24v24H0z' fill='none'/></svg>" class="{{ (isset($navigate) && $navigate['main_nav']=='calc') ? 'transform-180' : '' }}"/>
                                </a>
                                <ul class="sub-menu">
                                    <li class="title">
                                        <span>{{ Lang::get('menu.side_menu_calculators') }}</span>
                                    </li>
                                    <li class="{{ (isset($navigate) && $navigate['sub_nav']=='ballard_calc') ? 'current' : '' }}">
                                        <a href="{{ action('Calculators\BallardController@index') }}">
                                        <i class="fa fa-barcode pull-right" style="font-size: 15px;"></i>
                                        {{ Lang::get('menu.side_menu_ballard_score') }}
                                        </a>
                                    </li>
                                    <li class="{{ (isset($navigate) && $navigate['sub_nav']=='glucose_calc') ? 'current' : '' }}">
                                        <a href="{{ action('Calculators\GlucoseController@index') }}">
                                        <i class="fa fa-barcode pull-right" style="font-size: 15px;"></i>
                                        {{ Lang::get('menu.side_menu_glucose_rate_calculator') }}
                                        </a>
                                    </li>
                                    <li class="{{ (isset($navigate) && $navigate['sub_nav']=='age_calc') ? 'current' : '' }}">
                                        <a href="{{ action('Calculators\AgeController@index') }}">
                                        <i class="fa fa-barcode pull-right" style="font-size: 15px;"></i>
                                        {{ Lang::get('menu.side_menu_age_calculator') }}
                                        </a>
                                    </li>
                                    <li class="{{ (isset($navigate) && $navigate['sub_nav']=='tpn_calc') ? 'current' : '' }}">
                                        <a href="{{ action('Calculators\TpnCalculatorController@index') }}">
                                        <i class="fa fa-barcode pull-right" style="font-size: 15px;"></i>
                                        {{ Lang::get('menu.side_menu_tpn_calculator') }}
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            @endif   
                            @if(is_array($permissions) && in_array('DELETE_ACCESS',$permissions))   
                            <li class="submenu {{ (isset($navigate) && $navigate['main_nav']=='delete_access') ? 'open' : '' }}">
                                <a href="{{ action('Settings\DeleteApprovalController@index') }}">
                                <i class="fa fa-remove pull-right" style="font-size: 26px;"></i>
                                {{ Lang::get('menu.side_menu_delete_approvals') }}
                                </a>
                                <ul class="sub-menu">
                                    <li class="title module">
                                        <a href="{{ action('Settings\DeleteApprovalController@index') }}">
                                        {{ Lang::get('menu.side_menu_delete_approvals') }}
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            @endif
                            <li style="margin-bottom: 46px;">
                            </li>
                            <li class="submenu {{ (isset($navigate) && $navigate['main_nav']=='audio_logs') ? 'current' : '' }} hide">
                                <a href="{{ action('Audio\AudioFileController@index') }}">
                                <i class="fa fa-file-audio-o pull-right"></i>
                                {{ Lang::get('menu.side_menu_audio_log') }}
                                </a>
                                <ul class="sub-menu">
                                    <li class="title module">
                                        <a href="{{ action('Audio\AudioFileController@index') }}">
                                        {{ Lang::get('menu.side_menu_audio_log') }}
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </div>
                    </ul>
                </div>
                <!-- <div id="divider" class="" resizeable></div> -->
            </div>
            @if(Request::segment(1) == 'nicu-nurse-sheets' || Request::segment(1) == 'nurse-sheets-manual')
            <script type="text/javascript" src="{{ $site_url }}/js/nurse-sheet.js?rev=<?php echo time();?>"></script>
            <script type="text/javascript" src="{{ $site_url }}/js/nurse-hour-wise.js?rev=<?php echo time();?>"></script>
            <script type="text/javascript" src="{{ $site_url }}/js/mdtimepicker.min.js"> </script>
            @endif
            <!-- /Sidebar -->
            {!! Form::hidden('site_base_url',url('/')) !!}
            <div id="content">
                <div id="page-loader" class="loading-center" style="background: url('{{ url('/') }}/public/img/icons/preloader.gif') center no-repeat #fff"></div>
                <div class="container">
                    @yield('content')
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
            @endif
            @php $toastrOptions = SiteHelpers::toastrOptions(); @endphp
            @if(isset($toastrOptions->custom_toastr))
            {!! Form::hidden('toastr_options',$toastrOptions->custom_toastr,['id'=>'toastr_options']) !!}
            @endif
            @php $highLight = SiteHelpers::highLight(); @endphp
            @if(isset($highLight))
            {!! Form::hidden('high_light',json_encode($highLight),['id'=>'high_light']) !!}
            @endif
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
                        {{ Form::hidden('bed_no') }}
                        {{ Form::hidden('device_count') }}
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
        <script type="text/javascript" src="{{ $site_url }}/js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="{{ $site_url }}/js/sisyphus.js"></script>
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
        <script type="text/javascript" src="{{ $site_url }}/plugins/cookie/jquery.cookie.min.js"></script>
        <script type="text/javascript" src="{{ $site_url }}/plugins/slimscroll/jquery.slimscroll.min.js"></script>
        <script type="text/javascript" src="{{ $site_url }}/plugins/slimscroll/jquery.slimscroll.horizontal.min.js"></script>
        <!-- DataTables -->
        <script type="text/javascript" src="{{ $site_url }}/plugins/datatables/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="{{ $site_url }}/plugins/datatables/DT_bootstrap.js"></script>
        <script type="text/javascript" src="{{ $site_url }}/plugins/datatables/responsive/datatables.responsive.js"></script> <!-- optional -->
        <script type="text/javascript" src="{{ $site_url }}/plugins/datatables/columnfilter/jquery.dataTables.columnFilter.js"></script> <!-- optional -->    
        <script type="text/javascript" src="{{ $site_url }}/plugins/datatables/tabletools/TableTools.min.js"></script>
        <!-- optional -->
        <script type="text/javascript" src="{{ $site_url }}/plugins/datatables/FixedColumns.js"></script>
        <!-- validation -->
        <script type="text/javascript" src="{{ $site_url }}/plugins/validation/jquery.validate.min.js"></script>
        <script type="text/javascript" src="{{ $site_url }}/plugins/validation/additional-methods.min.js"></script>
        <!-- validation -->
        <script type="text/javascript" src="{{ $site_url }}/plugins/bootstrap-wizard/jquery.bootstrap.wizard.js"></script>
        <!-- toster message  -->
        <script type="text/javascript" src="{{ $site_url }}/plugins/toastr-master/build/toastr.min.js"></script>
        <!-- toster message  -->
        <!-- App -->
        <script type="text/javascript" src="{{ $site_url }}/js/app.js"></script>
        <script type="text/javascript" src="{{ $site_url }}/js/plugins.js"></script>
        <script type="text/javascript" src="{{ $site_url }}/js/plugins.form-components.js"></script>
        <script type="text/javascript" src="{{ $site_url }}/plugins/bootbox/bootbox.min.js"></script>
        <script type="text/javascript" src="{{ $site_url }}/plugins/typeahead/typeahead.min.js"></script> <!-- AutoComplete -->
        <script type="text/javascript" src="{{ $site_url }}/plugins/tagsinput/jquery.tagsinput.min.js"></script>
        <script type="text/javascript" src="{{ $site_url }}/plugins/bootstrap-inputtags/bootstrap-tagsinput.js"></script>
        <script type="text/javascript" src="{{ $site_url }}/js/demo/form_components.js?rev=<?php echo time();?>"></script>  
        <script type="text/javascript" src="{{ $site_url }}/plugins/uniform/jquery.uniform.min.js"></script> <!-- Styled radio and checkboxes -->   
        <script>
            $(document).ready(function () {
                "use strict";
                Plugins.init(); // Init all plugins
                FormComponents.init(); // Init all form-specific plugins
            });

            function babyMrcheck() {
                @if(Request::segment(3) == 'edit')
                return true;
                @else
                return "{{ url('baby-mrnumber-check') }}";
                @endif
            }

            @if(Session::has('Success'))
            Showalert('success', ' {!! Session::get("Success")  !!}');
            @endif
            @if(Session::has('info'))
            Showalert('info', ' {!! Session::get("info")  !!}');
            @endif
            @if(Session::has('warning'))
            Showalert('warning', ' {!! Session::get("warning")  !!}');
            @endif
            @if(Session::has('error'))
            Showalert('error', ' {!! Session::get("error")  !!}');
            @endif

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
                    url: '{{ url("save_master_data/") }}',
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
                    url: '{{ url("get-master-table-fields") }}' + '/' + table_name,
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
                    url: "{{ url('check-user-login') }}",
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
                            window.location.href = "{{ url('/') }}";
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
        <script type="text/javascript" src="{{ $site_url }}/plugins/Bootstrap-Horizontal-Selector/js/horizontal_selector.js?rev=<?php echo time();?>"></script>
        <script type="text/javascript" src="{{ $site_url }}/plugins/duallistbox/dual-listbox.js"></script>
        <script  type="text/javascript" src="{{ $site_url }}/plugins/ckeditor/ckeditor.js"></script>
        <script type="text/javascript">
            CKEDITOR.config.customConfig = '{{ $site_url }}/js/ckeditor.js';
        </script>
        @if (Request::segment(1) == 'pediatric-admission' || Request::segment(1) == 'neuro-develop' || Request::segment(1) == 'pediatric-search' || Request::segment(1) == 'pediatric-search-view' || Request::segment(1) == 'neuro-search' || Request::segment(1) == 'neuro-search-view' || Request::segment(1) == 'pediatric-out-patient' || Request::segment(1) == 'feeding' || Request::segment(2) == 'shortcode-list')
        <script  type="text/javascript" src="{{ $site_url }}/js/tinymce/tinymce.min.js"></script>
        @endif
        <!-- Demo JS -->
        <script type="text/javascript" src="{{ $site_url }}/js/custom.js"></script>  
        <script type="text/javascript" src="{{ $site_url }}/js/selectwithtext.js"></script>
        <script type="text/javascript" src="{{ $site_url }}/js/scripts.js?rev=<?php echo time();?>"></script> 
        @if(Request::segment(1) != 'nicu-discharge-search' && Request::segment(1) != 'nicu-discharge-search-view' && Request::segment(1) != 'postnatal-discharge-search' && Request::segment(1) != 'postnatal-discharge-search-view')
        <script type="text/javascript" src="{{ $site_url }}/js/nicudischarge.js?rev=<?php echo time();?>"></script> 
        @endif
        @if ((Request::segment(1) == 'out-patient' && (Request::segment(3) == 'edit' || Request::segment(2) == 'visite-list')) || (Request::segment(1) == 'neuro-develop' && (Request::segment(3) == 'edit' || Request::segment(2) == 'visite-list')) || (Request::segment(1) == 'nicu-nurse-sheets' && (Request::segment(3) == 'edit' || Request::segment(1) == 'nicu-nurse-sheet-day')) || (Request::segment(1) == 'nicu-admission' && (Request::segment(3) == 'edit' || Request::segment(2) == 'sub-nicu-list')) || (Request::segment(1) == 'daycare-admission' && (Request::segment(3) == 'edit' || Request::segment(2) == 'daycare-admission-daylist')) || (Request::segment(1) == 'pediatric-admission' && (Request::segment(3) == 'edit' || Request::segment(2) == 'sub-list')))
            <script type="text/javascript" src="{{ $site_url }}/js/bootstrap-fileinput/fileinput.min.js"></script>
            <script type="text/javascript" src="{{ $site_url }}/js/media.js?rev=<?php echo time();?>"></script>
        @endif
        @if (Request::segment(1) == 'out-patient' && Request::segment(2) == 'select')
            <script type="text/javascript" src="{{ $site_url }}/js/select2_pagination.js?rev=<?php echo time();?>"></script>
        @endif

        @if(Request::segment(1) == 'mother-registration' || Request::segment(1) == 'mother-registration-nurse')
        <script type="text/javascript" src="{{ $site_url }}/js/mother.js?rev=<?php echo time();?>"></script>
        @endif
        @if(Request::segment(1) == 'baby-registration' || Request::segment(1) == 'baby-registration-nurse' || Request::segment(1) == 'baby-readmission') 
        <script type="text/javascript" src="{{ $site_url }}/js/baby-form.js?rev=<?php echo time();?>"></script>
        @endif
        @if(Request::segment(1)=='nurse-nicu-daycare')
        <script type="text/javascript" src="{{ $site_url }}/js/nursedaycare.js?rev=<?php echo time();?>"></script>
        @endif  
        @if(Request::segment(1)=='daycare-admission')
        <script type="text/javascript" src="{{ $site_url }}/js/daycare.js?rev=<?php echo time();?>"></script> 
        @endif 
        @if(Request::segment(1)=='nicu-admission' || Request::segment(1)=='nicu-discharge')
        <script type="text/javascript" src="{{ $site_url }}/js/nicu_admission.js?rev=<?php echo time();?>"></script>
        @endif
        @if(Request::segment(1)=='neonatal')
        <script type="text/javascript" src="{{ $site_url }}/js/neonatal_proforma.js?rev=<?php echo time();?>"></script>
        @endif
        @if(Request::segment(1)=='postnatal-daycare')
        <script type="text/javascript" src="{{ $site_url }}/js/postnatal_daycare.js?rev=<?php echo time();?>"></script>
        @endif
        @if(Request::segment(1)=='echocardiography' || Request::segment(1)=='cranialultrasound' || Request::segment(1)=='culture-registry')
        <script type="text/javascript" src="{{ $site_url }}/js/lab_test.js?rev=<?php echo time();?>"></script>
        @endif
        @if(Request::segment(1)=='out-patient')
        <script type="text/javascript" src="{{ $site_url }}/js/op.js?rev=<?php echo time();?>"></script>
        @endif
        @if(Request::segment(1)=='pediatric-out-patient')
        <script type="text/javascript" src="{{ $site_url }}/js/oppediatric.js?rev=<?php echo time();?>"></script>
        @endif
        @if(Request::segment(1)=='neuro-develop' && (Request::segment(2) == 'create' || Request::segment(3) == 'edit'))
        <script type="text/javascript" src="{{ $site_url }}/js/neuro.js?rev=<?php echo time();?>"></script>
        <script type="text/javascript" src="{{ $site_url }}/js/m_chart_followup.js?rev=<?php echo time();?>"></script>
        <script type="text/javascript" src="{{ $site_url }}/js/ddst_chart.js?rev=<?php echo time();?>"></script>
        <script type="text/javascript" src="{{ $site_url }}/js/neuro_cbcl.js?rev=<?php echo time();?>"></script>
        <script type="text/javascript" src="{{ $site_url }}/js/neuro_issa.js?rev=<?php echo time();?>"></script>
        <script type="text/javascript" src="{{ $site_url }}/js/bayley.js?rev=<?php echo time();?>"></script>
        @endif
        @if(Request::segment(1)=='feeding' && (Request::segment(2) == 'create' || Request::segment(3) == 'edit'))
        <script type="text/javascript" src="{{ $site_url }}/js/feeding.js?rev=<?php echo time();?>"></script>
        @endif
        @if(Request::segment(1) == 'postanatal-admission')
        <script type="text/javascript" src="{{ $site_url }}/js/postnatal_admission.js?rev=<?php echo time();?>"></script>
        @endif
        @if(Request::segment(1)=='problems-settings')
        <script type="text/javascript" src="{{ $site_url }}/js/form-builder/basic-components.js?rev=<?php echo time();?>"></script>
        <script type="text/javascript" src="{{ $site_url }}/js/form-builder/form-component.js?rev=<?php echo time();?>"></script>
        <script type="text/javascript" src="{{ $site_url }}/js/form-builder/modal-form.js?rev=<?php echo time();?>"></script>
        @endif
        <script type="text/javascript" src="{{ $site_url }}/plugins/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>
        @if(Request::segment(1) == 'problems-systems' || Request::segment(1) == 'problem-systems-postnatal')
        <script type="text/javascript" src="{{ $site_url }}/js/problem-daycare.js?rev=<?php echo time();?>"></script>
        @endif
        @if(Request::segment(1) == 'site')
        <script  type="text/javascript" src="{{ $site_url }}/plugins/croppie/croppie.js"></script>
	    @endif
        @if(Request::segment(1) == 'nicu-discharge-search' || Request::segment(1) == 'nicu-discharge-search-view')
        <script type="text/javascript" src="{{ $site_url }}/js/search/nicu-discharge.js?rev=<?php echo time();?>"></script> 
        @endif
        @if(Request::segment(1) == 'postnatal-discharge-search' || Request::segment(1) == 'postnatal-discharge-search-view')
        <script type="text/javascript" src="{{ $site_url }}/js/search/postnatal-discharge.js?rev=<?php echo time();?>"></script> 
        @endif
        <script type="text/javascript" src="{{ $site_url }}/js/select_field_filter.js?rev=<?php echo time();?>"></script> 
        @if(Request::segment(1) == 'medication-template')
        <script type="text/javascript" src="{{ $site_url }}/js/medication_template.js?rev=<?php echo time();?>"></script> 
        @endif
        @if(Request::segment(1) == 'pediatric-admission' && (Request::segment(3) == 'create' || Request::segment(3) == 'edit'))
        <script type="text/javascript" src="{{ $site_url }}/js/pediatric.js?rev=<?php echo time();?>"></script> 
        @endif
        @if(Request::segment(1) == 'profile')
        <script type="text/javascript" src="{{ $site_url }}/js/userprofile.js?rev=<?php echo time();?>"></script> 
        @endif
        @if(Request::segment(1) == 'tpn-calculator')
        <script type="text/javascript" src="{{ $site_url }}/js/tpn_calculator.js?rev=<?php echo time();?>"></script> 
        @endif
        @if(Request::segment(1) == 'live-chart')
        <script type="text/javascript" src="{{$site_url}}/js/amcharts5/live_chart/index.js"></script>
        <script type="text/javascript" src="{{$site_url}}/js/amcharts5/live_chart/xy.js"></script>
        <script type="text/javascript" src="{{$site_url}}/js/amcharts5/stock.js"></script>
        <script type="text/javascript" src="{{$site_url}}/js/amcharts5/themes_responsive.js"></script>
        <script type="text/javascript" src="{{$site_url}}/js/amcharts5/live_chart/exporting.js"></script>
        <script type="text/javascript" src="{{ $site_url }}/js/live_chart.js?rev=<?php echo time();?>"></script> 
        @endif
        @include('flowcontrol.flow-control')
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
                    {!! Form::open(['url' => action('Settings\ComplaintsController@index'), 'id' => 'complaint_form']) !!}
                    <div class="modal-body m-20">
                        <div class="form-group">
                            @php
                            $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";  
                            $CurPageURL = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];  
                            @endphp
                            {{ Form::hidden('current_url',$CurPageURL) }}
                            {{ Form::label('complaint','Suggestion or Complaint:') }}
                            {{ Form::textarea('complaint',null,['class'=>'form-control','rows'=>'3']) }}    
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Submit</button>
                        <button type="button" id="close" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        @yield('scripts')
    </body>
</html>
