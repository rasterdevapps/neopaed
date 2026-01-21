<?php 
    $permissions = session('menu_permission');
    $write_permission = session('write_permission');
    $site_url = url('/').'/public';
    $public_url = url('public').'/';
?>
<!DOCTYPE html>
<html lang="en">
    <head id="special-print-head">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>Neopaed</title>
        <link rel="shortcut icon" href="{{ $site_url }}/img/neonatal_logo.png" />
        <!-- Fonts -->
        <link class="special-print-css" href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

        <link class="special-print-css" href="{{ $site_url }}/css/customized.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css">
        <link class="special-print-css" href="{{ $site_url }}/css/main.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css">
        <link class="special-print-css" href="{{ $site_url }}/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bootstrap-css-min">
        @if(Request::segment(1) != 'multiple-chart' && Request::segment(1) != 'nurse-sheets-manual-multiple-chart' && Request::segment(1) != 'prescription-print')    
            <link class="special-print-css" href="{{ $site_url }}/css/custom.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css">
        @endif
        @if(Request::segment(2) == 'vaccine-chart-print' || Request::segment(3) == 'op-with-vaccine')    
            <link class="special-print-css" href="{{ $site_url }}/css/vaccine_chart.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css">
        @endif
        <link class="special-print-css" href="{{ $site_url }}/css/fontawesome/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link class="special-print-css" href="{{ $site_url }}/plugins/toastr-master/build/toastr.css" rel="stylesheet" type="text/css"/>
        <link class="special-print-css" href="{{ $site_url }}/plugins/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet" type="text/css">
        @if(Request::segment(1) == 'mass-reports')
        <link class="special-print-css" rel="stylesheet" href="{{ $site_url }}/plugins/amcharts/plugins/export/export.css" type="text/css" media="all" />
        @endif
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        @if(Request::segment(1) == 'growthchart-view' || Request::segment(1) == 'growthchartzerotofive')
        <link class="special-print-css" href="{{ $site_url }}/css/growthchart.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css" />
        @endif
        <link href="{{ $site_url }}/css/print.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css" />
        <!-- <link href="{{ $site_url }}/css/nurse-chart.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css" /> -->
        @if (Request::segment(1) == 'baby-print')
        <link rel="stylesheet" href="{{ $site_url }}/css/baby-tag.css?rev=<?php echo time();?>">
        @endif
        @if (Request::segment(1) == 'inpatient-list' || Request::segment(1) == 'nicu-report' || Request::segment(1) == 'op-report' || Request::segment(1) == 'nb-report' || Request::segment(1) == 'birth-report' || Request::segment(1) == 'echo-report' || Request::segment(1) == 'carnial-ultrasound-report' || Request::segment(1) == 'op-activity-report' || Request::segment(1) == 'mass-reports')
        <link rel="stylesheet" href="{{ $site_url }}/css/report.css?rev=<?php echo time();?>">
        @endif
        @if(Request::segment(1) == 'nicu-nurse-sheet-print' || Request::segment(1) == 'lab-value-print')
        <link rel="stylesheet" href="{{ $site_url }}/css/nurse-sheet-print.css?rev=<?php echo time();?>">
        @endif
        @if(Request::segment(1) == 'prescription-print')
        <link class="special-print-css" href="{{ $site_url }}/css/prescription_print.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css">
        @endif
        @if(Request::segment(1) == 'multiple-chart' || Request::segment(1) == 'nurse-sheets-manual-multiple-chart' || Request::segment(1) == 'prescription-print' || Request::segment(1) == 'pediatric-admission')
            <link href="{{ $site_url }}/css/plugins/jquery-ui.css" rel="stylesheet" type="text/css">
        @endif
        @if(Request::segment(1) == 'nicu-discharge-summary' || Request::segment(1) == 'problems-discharge-summary' || Request::segment(1) == 'postproblem-systems-summary')
            <link href="{{ $site_url }}/css/copy_summary.css" rel="stylesheet" type="text/css">
        @endif
        @if(Request::segment(1) == 'neuro-develop')
            <link href="{{ $site_url }}/css/neuro_print.css" rel="stylesheet" type="text/css">
            <link href="{{ $site_url }}/css/bayley_print.css" rel="stylesheet" type="text/css">
        @endif
        @if(Request::segment(1) == 'neuro-assessment-print')
            <link href="{{ $site_url }}/css/assessment_print.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css">
        @endif
        @if(Request::segment(1) == 'pediatric-admission')
            <link href="{{ $site_url }}/css/pediatric-print.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css">
        @endif   
        @if(Request::segment(1) == 'lab-value-print' || Request::segment(1) == 'overall-lab-value-print')
            <link href="{{ $site_url }}/css/lab_print.css?rev=<?php echo time();?>" rel="stylesheet" type="text/css">
        @endif  
        @if(Request::segment(1) == 'inter-growth-chart')
            <link rel="stylesheet" type="text/css" href="{{$site_url}}/css/inter_growth_chart.css">
        @endif
        @if(Request::segment(1) == 'who-growth-chart')
            <link rel="stylesheet" type="text/css" href="{{$site_url}}/css/whochart.css">
        @endif
        @if(Request::segment(1) == 'zscore-growth-chart')
            <link rel="stylesheet" type="text/css" href="{{$site_url}}/css/zscorechart.css">
        @endif
        @if(Request::segment(1) == 'who-g5-growth-chart')
            <link rel="stylesheet" type="text/css" href="{{$site_url}}/css/whochart.css">
        @endif
        @if(Request::segment(1) == 'ballard-score-print')
            <link rel="stylesheet" type="text/css" href="{{$site_url}}/css/ballard_score_print.css">
        @endif

        <script class="special-print-css" type="text/javascript" src="{{ $site_url }}/js/libs/jquery-1.10.2.min.js"></script>
        @if(Request::segment(1) == 'pediatric-admission')
        <script type="text/javascript" src="{{ $site_url }}/plugins/validation/jquery.validate.min.js"></script>
        @endif
        <script class="special-print-css" type="text/javascript" src="{{ $site_url}}/js/bootstrap.js"></script>
        @if(Request::segment(1) == 'nicu-discharge-summary')
        <script class="special-print-css" type="text/javascript" src="{{ $site_url }}/js/nicudischarge.js?rev=<?php echo time();?>"></script>  
        @endif
        @if(Request::segment(1) == 'problems-discharge-summary')
        <script class="special-print-css" type="text/javascript" src="{{ $site_url }}/js/nicuproblemdischarge.js?rev=<?php echo time();?>"></script>  
        @endif
        @if(Request::segment(1) == 'postproblem-systems-summary')
        <script class="special-print-css" type="text/javascript" src="{{ $site_url }}/js/postnataldischarge.js?rev=<?php echo time();?>"></script>  
        @endif
        <script class="special-print-css" type="text/javascript" src="{{ $site_url }}/plugins/bootbox/bootbox.min.js"></script>
        <script class="special-print-css" type="text/javascript" src="{{ $site_url }}/plugins/toastr-master/build/toastr.min.js"></script>
        <script class="special-print-css" type="text/javascript" src="{{ $site_url }}/plugins/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>
        @if(Request::segment(1) == 'mass-reports' || Request::segment(1) == 'growthchart-view')
        <script class="special-print-css" type="text/javascript" src="{{ $site_url}}/plugins/amcharts/amcharts.js"></script>
        <script class="special-print-css" type="text/javascript" src="{{ $site_url}}/plugins/amcharts/serial.js"></script>
        <script class="special-print-css" type="text/javascript" src="{{ $site_url}}/plugins/amcharts/amstock.js"></script>
        <script class="special-print-css" type="text/javascript" src="{{ $site_url }}/plugins/amcharts/xy.js"></script>
        <script class="special-print-css" type="text/javascript" src="{{ $site_url }}/plugins/amcharts/amexport_combined.js"></script>
        <script class="special-print-css" type="text/javascript" src="{{ $site_url}}/plugins/amcharts/plugins/export/export.min.js"></script>
        <script class="special-print-css" type="text/javascript" src="{{ $site_url}}/plugins/amcharts/themes/light.js"></script>
        <script class="special-print-css" type="text/javascript" src="{{ $site_url }}/plugins/amcharts/plugins/export/libs/blob.js/blob.js"></script>
        <script class="special-print-css" type="text/javascript" src="{{ $site_url }}/plugins/amcharts/plugins/export/libs/classList.js/classList.min.js"></script>
        <script class="special-print-css" type="text/javascript" src="{{ $site_url }}/plugins/amcharts/plugins/export/libs/fabric.js/fabric.min.js"></script>
        <script class="special-print-css" type="text/javascript" src="{{ $site_url }}/plugins/amcharts/plugins/export/libs/FileSaver.js/FileSaver.min.js"></script>
        <script class="special-print-css" type="text/javascript" src="{{ $site_url }}/plugins/amcharts/plugins/export/libs/jszip/jszip.min.js"></script>
        <script class="special-print-css" type="text/javascript" src="{{ $site_url }}/plugins/amcharts/plugins/export/libs/pdfmake/pdfmake.min.js"></script>
        <script class="special-print-css" type="text/javascript" src="{{ $site_url }}/plugins/amcharts/plugins/export/libs/xlsx/xlsx.min.js"></script>
        <script class="special-print-css" type="text/javascript" src="{{ $site_url }}/js/annual_report.js?rev=<?php echo time();?>"></script>
        @endif
        @if(Request::segment(1) == 'growthchart-view' || Request::segment(1) == 'growthchartzerotofive')
        <script class="special-print-css" type="text/javascript" src="{{ $site_url }}/js/growth-chart.js?rev=<?php echo time();?>"></script>
        @endif
        @if(Request::segment(1) == 'nicu-discharge-summary' || Request::segment(1) == 'problems-discharge-summary' || Request::segment(1) == 'postproblem-systems-summary')
        <script class="special-print-css" type="text/javascript" src="{{ $site_url }}/plugins/ckeditor/ckeditor.js?rev=<?php echo time();?>"></script>
        @endif
        <script type="text/javascript" src="{{ $site_url }}/plugins/slimscroll/jquery.slimscroll.js"></script>
        <script type="text/javascript" src="{{ $site_url }}/plugins/slimscroll/jquery.slimscroll.min.js"></script>
        <script type="text/javascript" src="{{ $site_url }}/plugins/slimscroll/jquery.slimscroll.horizontal.min.js"></script>
        <script type="text/javascript" src="{{ $site_url }}/js/jquery-ui.min.js"></script>
        @if(Request::segment(1) == 'pediatric-out-patient' || Request::segment(1) == 'out-patient')
        <script type="text/javascript" src="{{ $site_url }}/js/op_print_config.js"></script>
        @endif    
        @if(Request::segment(1) == 'lab-value-print' || Request::segment(1) == 'overall-lab-value-print')
        <script type="text/javascript" src="{{ $site_url }}/js/lab_print.js"></script>
        @endif

        @if(Request::segment(1) == 'inter-growth-chart' || Request::segment(1) == 'who-growth-chart' || Request::segment(1) == 'who-g5-growth-chart' || Request::segment(1) == 'neuro-develop' || Request::segment(1) == 'zscore-growth-chart')
            <script type="text/javascript" src="{{$site_url}}/js/amcharts5/index.js"></script>
            <script type="text/javascript" src="{{$site_url}}/js/amcharts5/xy.js"></script>
            <script type="text/javascript" src="{{$site_url}}/js/amcharts5/themes_animated.js"></script>
            <script type="text/javascript" src="{{$site_url}}/js/amcharts5/themes_responsive.js"></script>
            <script type="text/javascript" src="{{$site_url}}/js/amcharts5/themes/Animated.js"></script>
        @endif
        @if(Request::segment(1) == 'inter-growth-chart')
            <script type="text/javascript" src="{{$site_url}}/js/inter_growth_chart.js"></script>
        @endif
        @if(Request::segment(1) == 'who-growth-chart')
            <script type="text/javascript" src="{{$site_url}}/js/who_chart.js"></script>
        @endif
        @if(Request::segment(1) == 'zscore-growth-chart')
            <script type="text/javascript" src="{{$site_url}}/js/zscore_chart.js"></script>
        @endif
        @if(Request::segment(1) == 'who-g5-growth-chart')
            <script type="text/javascript" src="{{$site_url}}/js/who_g5_chart.js"></script>
        @endif
        @if(Request::segment(1) == 'neuro-develop')
            <script type="text/javascript" src="{{$site_url}}/js/scaled_bayley_chart.js"></script>
            <script type="text/javascript" src="{{$site_url}}/js/standard_bayley_chart.js"></script>
        @endif
        @if(Request::segment(1) == 'get-events')
        <link href="{{ $site_url }}/css/plugins/select2.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="{{ $site_url }}/plugins/select2/select2.min.js"></script> <!-- Styled select boxes -->
        @endif

        @php $echo_port = env('LARAVEL_ECHO_PORT'); @endphp
        <script>
            window.laravel_echo_port = '{{$echo_port}}';
        </script>
        @php $socket_is_connected = true; @endphp
        @if(Request::segment(1) == 'get-events')
            @php $ward_folder = substr($_SERVER['REMOTE_ADDR'], 0, 4) == '172.' @endphp
            @if($ward_folder)
                <script type="text/javascript" src="http://neopaed.sks.net.in:6001/socket.io/socket.io.js"></script>
                <script>window.laravel_echo_port = '6001';</script>
            @else
                <script type="text/javascript" src="http://neopaed.sks.net.in:90/socket.io/socket.io.js"></script>
                <script>window.laravel_echo_port = '90';</script>
            @endif
            <script type="text/javascript" src="{{ $site_url }}/js/laravel-echo-setup.js"></script>
        @endif
        
    </head>
    <body class="print" id ="special-print">
        <div class="row">
        @php $editor_gen_option = isset($editor_gen_option) ? $editor_gen_option : 2 @endphp
        @php $approval_status = isset($approval_status) ? $approval_status : 0 @endphp

        @if(!Session::has('discharge-editor') || !Session::has('neonatal-editor')) 
            <div class="print-tool-bar hidden-print ">
                @if(Request::segment(1) == 'pediatric-out-patient' || Request::segment(1) == 'out-patient')
                    <ul class="nav navbar-nav" id="btn-op-page-custom" title="Custom marign setup">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-arrows fa-2x"></i>
                            </a>
                            <ul class="dropdown-menu">
                                {!! Form::model(null,['url' => action('Settings\SiteController@opPageSpacing'),'method'=>'PATCH','id'=>'page-spacing-config']) !!}                    
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th colspan="2">
                                                @php
                                                    $user_based = (isset($user_config->user_id) && $user_config->user_id != '') ? true : false;
                                                    $ip_based = (isset($ip_config->ip_address) && $ip_config->ip_address != '' && !$user_based) ? true : false;
                                                @endphp
                                                {!! Form::hidden('user_based', @$user_config->id) !!}
                                                {!! Form::hidden('ip_based', @$ip_config->id) !!}
                                                {!! Form::radio('config', 'user', $user_based) !!} <b>User</b>
                                                {!! Form::radio('config', 'ip_address', $ip_based) !!} <b>Ip Address</b>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="user_based">
                                            <td>Top {!! Form::text('user_top_spacing', @$user_config->top_spacing, ['class'=>'form-control input-width-small']) !!}</td>
                                            <td>Right {!! Form::text('user_right_spacing', @$user_config->right_spacing, ['class'=>'form-control input-width-small']) !!}</td>
                                        </tr>
                                        <tr class="user_based">
                                            <td>Bottom {!! Form::text('user_bottom_spacing', @$user_config->bottom_spacing, ['class'=>'form-control input-width-small']) !!}</td>
                                            <td>Left {!! Form::text('user_left_spacing', @$user_config->left_spacing, ['class'=>'form-control input-width-small']) !!}</td>
                                        </tr>
                                        <tr class="ip_based">
                                            <td>Top {!! Form::text('ip_top_spacing', @$ip_config->top_spacing, ['class'=>'form-control input-width-small']) !!}</td>
                                            <td>Right {!! Form::text('ip_right_spacing', @$ip_config->right_spacing, ['class'=>'form-control input-width-small']) !!}</td>
                                        </tr>
                                        <tr class="ip_based">
                                            <td>Bottom {!! Form::text('ip_bottom_spacing', @$ip_config->bottom_spacing, ['class'=>'form-control input-width-small']) !!}</td>
                                            <td>Left {!! Form::text('ip_left_spacing', @$ip_config->left_spacing, ['class'=>'form-control input-width-small']) !!}</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2" class="text-center">
                                                <button type="submit" class="btn btn-primary">Apply</button>
                                                <button type="button" class="btn btn-default">Close</button>                                                
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                                {!! Form::close() !!}
                            </ul>
                        </li>
                    </ul>
                @endif
                @if(Request::segment(1) == 'nicu-discharge-summary' && isset($result->status) && $result->status == 'Inpatient')
                <a href="javascript:void(0);" title="Discharge Creation" class="btn" id="discharge-edit-btn">
                    <i class="fa fa-pencil fa-2x" aria-hidden="true"></i>
                </a>
                @endif
                @if(Request::segment(1) == 'nicu-nurse-sheet-print' || Request::segment(1) == 'lab-value-print')
                <a href="{{ action('Ward\BabyWardController@index') }}" class="btn ward-nav">
                    <i class="fas fa-bed fa-2x" aria-hidden="true"></i>
                </a> 
                @endif
                @if(Request::segment(1) == 'lab-value-print' && isset($baby->BabyId) && isset($closewinlink_temp))
                    <a href="javascript:void(0);" class="btn btn-default" id="btn-refresh-lab-report" data-baby-id="{{$baby->BabyId}}" data-closewinlink="{{$closewinlink_temp}}" title="Reload the lab report">
                        <i class="fa fa-refresh fa-2x" aria-hidden="true"></i>
                    </a>
                @endif
                @if(Request::segment(1) == 'lab-value-print')
                    <a href="javascript:void(0);" class="btn btn-success" id="btn-export" title="Export" data-mrn="{{$baby->BMrNo}}" data-baby-name="{{$baby->BabyName}}">
                        <i class="fa fa-file-excel-o fa-2x"></i>
                    </a>
                @endif
                @if(Request::segment(1) == 'overall-lab-value-print')
                    <a href="javascript:void(0);" class="btn btn-success" id="btn-export" title="Export" data-mrn="{{$baby_mrn}}">
                        <i class="fa fa-file-excel-o fa-2x"></i>
                    </a>
                @endif
                @if(Request::segment(1) == 'nicu-discharge-summary' && isset($dischargewinlink))
                    <a href="{{$dischargewinlink}}" class="btn printed-list-btn back-discharge" title="Back To Discharge Details">
                        <i class="fas fa-user-clock fa-2x" aria-hidden="true"></i>
                    </a>
                @endif
                @if(Request::segment(1) == 'neuro-assessment-print')
                <a href="javascript:void(0);" class="btn" id="btn-assessment-reset" title="Reset assessment">
                    <i class="fa fa-refresh fa-2x" aria-hidden="true"></i>
                </a> 
                @endif
                @if(Request::segment(1) == 'pediatric-admission' && Request::segment(3) == 'summaryprint')
                    <a href="javascript:void(0);" class="btn issued-mark-btn" id="issued-mark" data-display="0">
                        <i class="fa fa-question-circle" aria-hidden="true"></i>
                    </a>
                @endif
                @if(Request::segment(1) == 'pediatric-admission' && Request::segment(3) == 'summaryprint' && $summary_approval)
                    @if ($is_approved)
                    <a href="javascript:void(0);" class="btn unapproval-btn" id="pediatric-approval" title="Un Approve" data-display="0">
                        <i class="fa fa-check fa-2x" aria-hidden="true"></i>
                    </a>
                    @else
                    <a href="javascript:void(0);" class="btn approval-btn" id="pediatric-approval" title="Approve" data-display="0">
                        <i class="fa fa-shield fa-2x" aria-hidden="true"></i>
                    </a>
                    @endif
                @endif
                @if(Request::segment(1) == 'nicu-nurse-sheet-print')
                    @if (isset($prev_id) && !is_null($prev_id))
                    @php
                    $prev_id = explode('||', $prev_id);
                    $previd = $prev_id[0];
                    $prev_day_name = $prev_id[1];
                    @endphp
                    <a href="{{ action('Nurse\NurseSheetController@print', \SiteHelpers::encrypt_id($previd)) }}" class="btn nurse-day-nav" title="Day {{$prev_day_name}}">
                        <i class="fa fa-chevron-left fa-2x" aria-hidden="true"></i>
                    </a>
                    @endif
                    @if (isset($next_id) && !is_null($next_id))
                    @php
                    $next_id = explode('||', $next_id);
                    $nextid = $next_id[0];
                    $next_day_name = $next_id[1];
                    @endphp
                    <a href="{{ action('Nurse\NurseSheetController@print', \SiteHelpers::encrypt_id($nextid)) }}" class="btn nurse-day-nav" title="Day {{$next_day_name}}">
                        <i class="fa fa-chevron-right fa-2x" aria-hidden="true"></i>
                    </a>
                    @endif
                @endif
                <a href="javascript:void(0);" onclick="printSpecialPage('special-print');" class="btn hide print-btn" title="speical-print">
                    <i class="fa fa-print fa-2x" aria-hidden="true"></i>
                </a> 
                @if(Request::segment(1) != 'whogrowthchart-view' && Request::segment(1) != 'growthchart-who-view' && Request::segment(1) != 'nicu-nurse-sheet-graph' && Request::segment(1) != 'multiple-chart' && Request::segment(1) != 'nurse-sheets-manual-graph' && Request::segment(1) != 'nurse-sheets-manual-multiple-chart' && Request::segment(1) != 'growthchart-view' && Request::segment(1) != 'get-events' && $approval_status == 0 && Request::segment(1) != 'nicu-discharge-summary' && Request::segment(1) != 'problems-discharge-summary')
                    <a href="javascript:void(0);" onclick="window.print();" class="btn print-btn" title="print">
                    <i class="fa fa-print fa-2x" aria-hidden="true"></i>
                    </a> 
                @endif
                @if($approval_status != 0 && in_array('NICU_MODULE_SHEET',$write_permission))
                    <a href="javascript:void(0);" class="btn approval-btn" id="approval-screen" title="Approve" data-display="0">
                        <i class="fa fa-shield fa-2x" aria-hidden="true"></i>
                    </a>
                @endif
                @if(Request::segment(1) == 'whogrowthchart-view' || Request::segment(1) == 'growthchart-who-view' || Request::segment(1) == 'growthchart-view')
                    <a href="javascript:void(0);" onclick="printPage('chart-print');" class="btn print-btn" title="print">
                        <i class="fa fa-print fa-2x" aria-hidden="true"></i>
                    </a>
                @endif
                @if(isset($closewinlink))
                <a href="{{ $closewinlink }}"  title="back" class="btn back-close-btn">
                    <i class="fa fa-times fa-2x" aria-hidden="true"></i>
                </a> 
                @endif
                @if (Request::segment(1) == 'nicu-nurse-sheet-print' || Request::segment(2) == 'get-weekly-observations')
                    @php 
                        $mrn = $baby->BMrNo;

                        echo \SiteHelpers::menuList($mrn, $admission_id, 'nurse_sheet_print');
                    @endphp
                @endif
                @if (Request::segment(1) == 'lab-value-print')
                    @php 
                        $mrn = $baby->BMrNo; 

                        echo \SiteHelpers::menuList($mrn, $active_admission_id, 'lab_report');
                    @endphp
                @endif
                @if (Request::segment(1) == 'get-events')
                    @php 
                        $mrn = $baby_details->BMrNo; 

                        echo \SiteHelpers::menuList($mrn, 'care_event_marker');
                    @endphp
                @endif
                @if (Request::segment(1) == 'nicu-discharge-summary')
                    @php 
                        $mrn = $result->BMrNo; 

                        echo \SiteHelpers::menuList($mrn, $current_admission_id);
                    @endphp
                @endif
                @if((Request::segment(1) == 'nicu-discharge-summary' || Request::segment(1) == 'problems-discharge-summary' || Request::segment(1) == 'postproblem-systems-summary') && isset($old_print_sheet_count) && $old_print_sheet_count > 0)
                    <a href="javascript:void(0);" class="btn printed-list-btn unactive" title="Printed List">
                        <i class="fas fa-list fa-2x" aria-hidden="true"></i>
                    </a>
                @endif
                @if((Request::segment(1) == 'nicu-discharge-summary' && !@$generated) || Request::segment(1) == 'problems-discharge-summary' || Request::segment(1) == 'postproblem-systems-summary')
                    @php $specialPermission = \Session::get('specialPermissions'); @endphp
                    {{-- @php if(isset($dischargeSummarymodified['is_completed']) && $dischargeSummarymodified['is_completed'] == 2 && !in_array('DISCHARGE_EDIT',$specialPermission)){ $dischargeEditpermission = 'hide'; }else{ $dischargeEditpermission = ''; } @endphp --}}
                    @php $dischargeEditpermission = '' @endphp
                    <a href="javascript:void(0);" class="btn savebtn hide hidden-print {!! $dischargeEditpermission !!}  neonatal-intensive-care-save save-btn">
                        <i class="fa fa-floppy-o fa-2x" aria-hidden="true"></i>
                    </a>
                    @if($editor_gen_option == 1)
                            <!-- <a href="javascript:void(0);" title="open editor for full page" class="btn hidden-print open-editor">
                                <i class="fa fa-file-text fa-2x" aria-hidden="true"></i>
                            </a> -->
                    @endif
                @elseif($editor_gen_option == 1)
                    <a href="javascript:void(0);" title="open editor for full page" class="btn hidden-print open-editor hide edit-btn">
                        <i class="fas fa-edit fa-2x" aria-hidden="true" style="font-size: 22px;padding: 4px 0px;"></i>
                    </a>
                    <!-- <a href="javascript:void(0);" title="Default" class="btn hidden-print pull-right neonatal-intensive-care-default  ">
                        <i class="fa fa-undo fa-2x" aria-hidden="true"></i>
                    </a> -->
                @endif
            </div>
        @endif 
        @if(Request::segment(1) == 'prescription-print')
            <div id="page-loader" class="loading-center" style="background: url('{{ url('/') }}/public/img/icons/preloader.gif') center no-repeat #fff"></div>
        @endif
        @if(Request::segment(1) == 'nicu-nurse-sheet-print' || Request::segment(1) == 'multiple-list-chart' || Request::segment(1) == 'nurse-sheets-manual-print')
            <div class="container-fluid main">
        @else
                <div class="container main">
        @endif
            {!! Form::hidden('site_base_url',url('/')) !!}
                    @yield('content')
                </div>
            </div>
        <!-- Scripts -->
        @php $toastrOptions = SiteHelpers::toastrOptions(); @endphp
        @if(isset($toastrOptions->custom_toastr))
            {!! Form::hidden('toastr_options',$toastrOptions->custom_toastr,['id'=>'toastr_options']) !!}
        @endif

        @if(Request::segment(1) != 'prescription-print' && Request::segment(1) != 'nurse-sheets-manual-graph' && Request::segment(1) != 'nurse-sheets-manual-multiple-chart')
        <script type="text/javascript">            
            var body_ht = $('body.print').height();
            var container_ht = $('.print .container').height();
            
            if (body_ht > container_ht) {
                // $('.print .container').css('height', '100vh');
            }
        </script>
        @endif
        @if(Request::segment(1) == 'prescription-print')
        <script type="text/javascript">            
            $(window).load(function() {
                $("#page-loader").fadeOut();
            });
        </script>
        @endif
        @if(Request::segment(1) == 'nicu-discharge-summary' || Request::segment(1) == 'problems-discharge-summary' || Request::segment(1) == 'postproblem-systems-summary')
        <script type="text/javascript">
            CKEDITOR.config.customConfig = '{{ $site_url }}/js/ckeditor.js?rev=<?php echo time();?>';
        </script>
        @endif
        @if (Request::segment(1) == 'neuro-develop')
        <script type="text/javascript" src="{{ $site_url }}/js/tinymce/tinymce.min.js"></script>
        @endif
        <script type="text/javascript">
            @if(Session::has('Success'))
             Showalert('success',' {!! Session::get("Success")  !!}');
            @endif
            @if(Session::has('info'))
             Showalert('info',' {!! Session::get("info")  !!}');
            @endif
            @if(Session::has('warning'))
             Showalert('warning',' {!! Session::get("warning")  !!}');
            @endif
            @if(Session::has('error'))
             Showalert('error',' {!! Session::get("error")  !!}');
            @endif
            
            function Showalert(type,message) {
                toastr.remove();
                var option = JSON.parse($('#toastr_options').val());

                toastr.options.closeButton       = option.closeButton;
                toastr.options.debug             = option.debug;
                toastr.options.newestOnTop       = option.newestOnTop;
                toastr.options.progressBar       = option.progressBar;
                toastr.options.positionClass     = option.positionClass;
                toastr.options.preventDuplicates = option.preventDuplicates;
                toastr.options.onclick           = option.onclick;      
                toastr.options.showDuration      = option.showDuration;
                toastr.options.hideDuration      = option.hideDuration;
                toastr.options.timeOut           = option.timeOut;
                toastr.options.extendedTimeOut   = option.extendedTimeOut;
                toastr.options.showEasing        = option.showEasing;
                toastr.options.hideEasing        = option.hideEasing;
                toastr.options.hideMethod        = option.hideMethod;

                if (type == 'success') {                 
                    toastr.success(type,message);
                } else if (type == 'error') {
                    toastr.error(type,message);
                } else if (type == 'info') {
                    toastr.info(type,message);
                } else if(type == 'warning') {
                    toastr.warning(type,message);
                } 
            }  
              
            function responseMessageajax(errorNo,message) {
               
                switch(errorNo){
                  case 200:
                  return Showalert('success',message); 
                  case 201:
                  return Showalert('warning',message);    
                  case 302:
                  return Showalert('warning','You not have permission !');
                  break;
                  default:
                  return Showalert('warning','Something went wrong contact admin !');
                  break;
                }
              }        
              
            $(document).on('click', '#live-chart-link', function() {
                var client_zone = Intl.DateTimeFormat().resolvedOptions().timeZone;
                var link = $(this).attr('data-url')+'&client_zone='+client_zone;
                window.location = link;
            });    
                  $(document).on('click', '#discharge-edit-btn', function() {
                    $('#discharge-details').modal({
                        backdrop: 'static',
                        keyboard: false,
                        show: true
                    });
                });


                  $(document).on('click', '#discharge-data', function() {
                    var temp_status = $('#temp_status').val();
                    var temp_discharge_date = $('#temp_discharge_date').val();
                    temp_discharge_date = temp_discharge_date.split('-');
                    temp_discharge_date = temp_discharge_date[2] + '-' + temp_discharge_date[1] + '-' + temp_discharge_date[0];
                    var temp_discharge_weight = $('#temp_discharge_weight').val();
                    var temp_ofc = $('#temp_ofc').val();
                    var temp_length = $('#temp_length').val();

                    $('.for-discharge').addClass('summary-display');
                    $('.for-inpatient').addClass('summary-display-none');
                    $('.for-discharge').removeClass('hide');
                    $('.for-inpatient').addClass('hide');

                    $("#temp-status-change").html(temp_status);
                    $("#temp-discharge-date-change").html(temp_discharge_date);
                    $("#temp-discharge-weight-change").html(temp_discharge_weight);
                    $("#temp-discharge-ofc-change").html(temp_ofc);
                    $("#temp-discharge-length-change").html(temp_length);
                    $('.savebtn').removeClass('hide');
                    $('#discharge-details').modal('hide');
                });

                $(document).on('click', '#cancel-data', function() {
                    $('#discharge-details').modal('hide');
                });

                  @if(Request::segment(1) == 'nicu-discharge-summary' && isset($result->status) && $result->status == 'Inpatient')
                  // $('.for-discharge').removeClass('summary-display');
                  // $('.for-inpatient').addClass('summary-display');
                  $('.for-discharge').addClass('hide');
                  $('.for-inpatient').removeClass('hide')
                  @endif
        </script>
        @yield('scripts')
    </body>
</html>
