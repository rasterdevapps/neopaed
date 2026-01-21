<?php  
$site_url =url('/public');
$public_url =url('public').'/';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@if(isset($summary_type) && $summary_type == 'interim') Interim Summary ( Problem Based ) @else Nicu Problem Based Discharge Summary @endif</title>
    <style type="text/css">
        .print-tool-bar {
            float: right;
        }
        .print-tool-bar a {
            background-color: #FFB3B3;
            border-radius: 50%;
            /* transform: rotate(-90deg); */
            padding: 4px 7.5px;
            margin: 5px;
            color: #03324c;
            text-align: center;
            border-radius: 20px;
            background-image: linear-gradient(#b1ccda 49%, #b1ccda 51%);
            box-shadow: 0 2px 2px #888888;
            transition: color 0.3s, background-image 0.5s, ease-in-out;
        }
        .main-content {
            padding-top: 50px;
        }
        .print-tool-bar a:hover {
            background-image: linear-gradient(#335b71 45%, #03324c 55%);
            color: white;
        }
        .custom-padding-0 {
            padding: 0px !important;
        }
        .content-block {
            margin-top: 20px !important;
        }
        .mt-0 {
            margin-top: 0px;
        }
        .pt-30 {
            padding-top: 30px;
        }
        .plr-must-0 {
            padding-left: 0px !important;
            padding-right: 0px !important;
        }
        form {
            margin-top: 50px;
        }
        @media print {
            .cke_show_border {
                border: none !important;
            }
            .print-tool-bar {
                display: none;
            }
        }
        ins {
                text-decoration: none;
                /*display: none;*/
                background-color: #d4fcbc;
            }

            del {
                text-decoration: none;
                background-color: red;
                /*background-color: #baff6c;*/
                /*background-color: #fbb6c2;
                color: #555;*/
            }
            #page-loader {
              position: fixed;
              left: 0px;
              top: 0px;
              width: 100%;
              height: 100%;
              z-index: 3;
            }
            .widget {
              margin-top: 0px;
              margin-bottom: 25px;
              padding: 0px;
              /* Divider */

            }
            .widget .widget-header {
              margin-bottom: 15px;
              border-bottom: 1px solid #ececec;
              *zoom: 1;
            }
            .widget .widget-header:before,
            .widget .widget-header:after {
              display: table;
              content: "";
              line-height: 0;
            }
            .widget .widget-header:after {
              clear: both;
            }
            .widget .widget-header h4 {
              display: inline-block;
              color: #fff;
              font-size: 14px;
              font-weight: bold;
              margin: 0;
              padding: 0;
              margin-bottom: 7px;
            }
            .widget .widget-header h4 i {
              font-size: 14px;
              margin-right: 5px;
              color: #fff;
            }
            .widget .widget-header .toolbar {
              display: inline-block;
              padding: 0;
              margin: 0;
              float: right;
            }
            .widget.box {
              border: 1px solid #d9d9d9;
              box-shadow: 0px 0px 5px #3F444454;
            }
            .widget.box .widget-header {
              background: #434468;
              border-bottom-color: #d9d9d9;
              line-height: 35px;
              padding: 0 12px;
              margin-bottom: 0;
              box-shadow: 0px 0px 10px #4444447d;
            }
            .widget.box .widget-header h4 {
              margin-bottom: 0;
            }
            .widget.box .widget-header .toolbar {
              margin-right: -5px;
            }
            .widget.box .widget-header .toolbar.no-padding {
              margin: -3px -13px;
            }
            .widget.box .widget-header .toolbar.no-padding .btn {
                font-size: 13px;
                line-height: 31px;
                margin-top: 3px;
            }
            .widget.box .widget-content {
              padding: 10px;
              position: relative;
              background-color: transparent;
            }
            .widget.box .widget-content.no-padding {
              padding: 0;
            }
            .widget.box .widget-content.no-padding .row {
              padding-left: 15px;
              padding-right: 15px;
            }
            .widget.box .widget-content.widget-deeper {
              background-color: #f9f9f9;
              -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05) inset;
              -moz-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05) inset;
              box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05) inset;
            }
            .widget.box.box-shadow {
              -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
              -moz-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
              box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
              border-bottom-color: #cccccc;
            }
            .widget.widget-closed.box .widget-header {
              margin-bottom: -1px;
              border-bottom: 1px solid #d9d9d9;
            }
            .widget.widget-closed .widget-content {
              display: none;
            }
            .widget > .divider,
            .widget .widget-content > .divider {
              width: 100%;
              border-bottom: 1px solid #d9d9d9;
              border-top: 1px solid #fff;
            }
            .widget > .divider.bright,
            .widget .widget-content > .divider.bright {
              border-bottom-color: #ececec;
            }
            .widget .widget-content > .divider {
              margin: 5px 0;
            }
            .px-0
            {
                padding: 0px 0px !important;
            }
            .mx-0
            {
                margin: 0px 0px !important;
            }
            form
            {
                width: 100%;
            }
            li { 
                display: none;
            }
    </style>
    <link rel="stylesheet" type="text/css" href="{{ $site_url}}/css/fontawesome/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="{{ $site_url}}/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{ $site_url }}/plugins/toastr-master/build/toastr.css">
    <link rel="stylesheet" type="text/css" href="{{ $site_url }}/plugins/bootstrap-toggle/css/bootstrap-toggle.min.css">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:400,300">
    <link href="{{ $site_url }}/css/customized.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="print-tool-bar">
        <div id="page-loader" class="loading-center" style="background: url('{{ url('/') }}/public/img/icons/preloader.gif') center no-repeat #fff"></div>
        @if(isset($summary_type) && $summary_type != 'interimiframe')
        <a href="javascript:void(0);" class="btn save-report" title="Save report">
            <i class="fa fa-floppy-o fa-2x" aria-hidden="true"></i>
        </a>
        @if(isset($summary_type) && $summary_type != 'interim')
        <a href="#" class="btn problem-close" title="Back">
            <i class="fa fa-times fa-2x" aria-hidden="true"></i>
        </a>
        @else
        <a href="#" class="btn problem-close" title="Back">
            <i class="fa fa-times fa-2x" aria-hidden="true"></i>
        </a>
        @endif 
        @if(isset($summary_type) && $summary_type != 'interim' && $summary_type != 'interimiframe' && $interim)
        <a href="javascript:void(0);" title="Compare" class="btn hidden-print open-compare">
            <i class="fa fa-exchange" aria-hidden="true" style="font-size: 23px; padding: 4px 1px"></i>
        </a>
        <a href="javascript:void(0);" title="Compare" class="btn hidden-print close-compare">
            <i class="fa fa-minus fa-2x" aria-hidden="true"></i>
        </a>

        <a href="javascript:void(0);" title="Compare Text" class="btn hidden-print text-compare">
            <i class="fa fa-search-plus fa-2x" aria-hidden="true"></i>
        </a>

        <a href="javascript:void(0);" title="Compare Text" class="btn hidden-print" id="undo-compare" style="display: none">
            <i class="fa fa-search-minus fa-2x" aria-hidden="true"></i>
        </a>
        @endif
        @endif
    </div>
    <div class="container">
        <div class="row mx-0">
            <div class="col-md-12 change-column-width">
                @if(isset($summary_type) && $summary_type == 'interim')

                @php $form_url = action('Reports\ProblemDischargeController@saveFullEditor',null).'/interim'; @endphp
                @else 
                @php $form_url = action('Reports\ProblemDischargeController@saveFullEditor',null); @endphp
                @endif
                {!! Form::model(null,['method' => 'POST','url' => $form_url ,'id'=>'nicu-problem-based-reports']) !!}
                {!! Form::hidden('baby_id',$dischage_summary['baby_id']) !!}
                {!! Form::hidden('admission_id',$dischage_summary['admission_id']) !!}
                @if(isset($summary_type) && $summary_type != 'interimiframe')
                <textarea name="daycare_summary" id="daycare_summary">
                    {!! $discharge_details['content'] !!}
                </textarea>
                @else 
                {!! $discharge_details['content'] !!}
                @endif
                {!! Form::close() !!}
                @php $toastrOptions = SiteHelpers::toastrOptions(); @endphp
                @if(isset($toastrOptions->custom_toastr))
                {!! Form::hidden('toastr_options',$toastrOptions->custom_toastr,['id'=>'toastr_options']) !!}
                @endif
            </div>

            <div class="widget box interim-summary-widget col-md-6 px-0" style="display: none;">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> Interim Summary</h4>
                </div>
                <div class="widget-content">
                    <iframe id="problem-base-interim-summary" style="display: none; width: 100%"></iframe>
                </div>
            </div>
        </div>
        <div id="split_report_content_from_summary" class="hide"></div>
    </div>
    <script type="text/javascript" src="{{ $site_url }}/js/libs/jquery-1.10.2.min.js"></script>
    <script src="{{ $site_url}}/js/bootstrap.js"></script>
    <script src="{{ $site_url}}/js/html_diff.js"></script>
    <script type="text/javascript" src="{{ $site_url }}/plugins/toastr-master/build/toastr.min.js"></script>
    <script type="text/javascript" src="{{ $site_url }}/plugins/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>
    <script type="text/javascript" src="{{ $site_url }}/plugins/ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            CKEDITOR.replace('daycare_summary', {
                toolbar: [{
                    name: 'document',
                    items: ['Print']
                },
                {
                    name: 'clipboard',
                    items: ['Undo', 'Redo']
                },
                {
                    name: 'styles',
                    items: ['Format', 'Font', 'FontSize']
                },
                {
                    name: 'basicstyles',
                    items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat', 'CopyFormatting']
                },
                {
                    name: 'colors',
                    items: ['TextColor', 'BGColor']
                },
                {
                    name: 'align',
                    items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
                },
                {
                    name: 'links',
                    items: ['Link', 'Unlink']
                },
                {
                    name: 'paragraph',
                    items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote']
                },
                {
                    name: 'insert',
                    items: ['Image', 'Table']
                },
                {
                    name: 'tools',
                    items: ['Maximize']
                },
                {
                    name: 'editing',
                    items: ['Scayt']
                }
                ],
                disallowedContent: 'a,img',
                height: $(window).height() - 200,
                contentsCss: ['{{ $public_url }}css/discharge-summary-editor.css', "{{ $site_url}}/css/customized.css", "{{ $site_url}}/css/main.css", "{{ $site_url}}/css/custom.css", "{{ $site_url }}/plugins/amcharts/plugins/export/export.css"],
                allowedContent: true,
            });
            CKEDITOR.instances["daycare_summary"].on('blur',function() {
                problemReportSave();
            });
            $('.save-report').click(function() {
                $('#nicu-problem-based-reports').submit();
            });
            $(document).on('click', '#cke_16', function() {
                problemReportSave();
            });
            $('.problem-close').click(function() {
                problemReportSave(false);  
            });
            function problemReportSave($slug=true) {
                    var report=CKEDITOR.instances['daycare_summary'].getData();
                    $('textarea[name="daycare_summary"]').val(report);
                    $.ajax({
                        headers: {
                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                          },
                          type    :"POST",
                          url     : "{{ url('nicu-pblm-disch-reports-save') }}@if(isset($summary_type) && $summary_type == 'interim')/interim @endif",
                          data    :$('#nicu-problem-based-reports').serialize(),
                          cache   : false,
                          dataType: "json",
                          success:function(response) {
                            if ($slug) {
                                Showalert(response.type, response.msg);
                            } else {
                                window.location = "{{ url('problems-discharge-baby-list') }}@if(isset($summary_type) && $summary_type == 'interim')/interim @endif"                       
                            }
                        },
                        error: function(response) {
                            Showalert('error','Record Not Saved. Try after some time !');
                        }
                    });
            }
            @if(Session::has('success'))
            Showalert('success', ' {!! Session::get("success")  !!}');
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
        });
    
            $('.close-compare').hide();
                $('.text-compare').hide();
            $('.container').css({'width':'100%', 'padding': '0px'});
            $('.open-compare').on('click', function() {
                $('.change-column-width').removeClass('col-md-12');
                $('.change-column-width').addClass('col-md-6');
                $('.text-compare').show();
                // $("#page-loader").fadeIn();
                $('form').css({'float': 'left', 'padding-right': '10px', 'border-right': '2px solid red'});
                if($("iframe#problem-base-interim-summary").attr('src') === undefined) {
                    // $('iframe#problem-base-interim-summary').attr('src', '{{ url('nicu-abbrivated-summary/'.Request::segment(2)) }}/interimiframe');

                    $('iframe#problem-base-interim-summary').attr('src', '{{ url('nicu-pblm-disch-abbreviated/'.Request::segment(2)) }}/interimiframe');
                }
                
                $('#problem-base-interim-summary').css({'display': 'block','height': screen.height - 214, 'float': 'left', 'border': 'none'});    
                
                $('iframe#problem-base-interim-summary body').css({'overflow': 'hidden !important'});
                
                $('iframe#problem-base-interim-summary .print-tool-bar').css({'display': 'none'});

                
                $('.interim-summary-widget').show();
                $('.open-compare').hide();
                $('.close-compare').show();
                // $("#page-loader").fadeOut();
                $("iframe#problem-base-interim-summary").contents().find(".widget-header").remove();                
                $("iframe#problem-base-interim-summary").contents().find(".change-column-width").removeClass('widget');                
                $("iframe#problem-base-interim-summary").contents().find(".change-column-width").removeClass('box');                
                $("iframe#problem-base-interim-summary").contents().find(".change-column-width").removeClass('widget-content');                

            }); 
            $('.close-compare').on('click', function() {
                $('.text-compare').hide();
                $('.change-column-width').removeClass('col-md-6');
                $('.change-column-width').addClass('col-md-12');
                $('.interim-summary-widget').hide();
                $('.open-compare').show();
                $('.close-compare').hide();
                $('iframe#problem-base-interim-summary, .interim-summary').hide();
                // $('form').css({'width':'100%', 'float': 'left', 'padding-right': '0px', 'border-right': 'none'});
                // $('.container').css({'width':'unset', 'padding': 'unset'});
            })

            $('#undo-compare').click(function(e){
                $('iframe#problem-base-interim-summary').attr('src', '{{ url('nicu-pblm-disch-abbreviated/'.Request::segment(2)) }}/interimiframe');
                $(this).hide();
                $('.text-compare').show();
            });
            $('.text-compare').click(function()
            {
                var old_content = $("#problem-base-interim-summary").contents().find(".nicu-summary").html();

                var new_content = $("#daycare_summary").val();
                $('#split_report_content_from_summary').html(new_content);
                new_content = $('#split_report_content_from_summary .nicu-summary').html();
                var output = htmldiff(old_content, new_content);
                $("#problem-base-interim-summary").contents().find(".nicu-summary").html(output);
                $(this).hide();
                $('#undo-compare').show();
            });

            $(window).load(function() {
                $("#page-loader").fadeOut();
            });

        // $('.close-compare').hide();
        // $('.container').css({'width':'100%', 'padding': '0px'});
        // $('.open-compare').on('click', function() {

        //     $('form').css({'width':'50%', 'float': 'left', 'padding-right': '10px', 'border-right': '2px solid red'});

        //     $('iframe#problem-base-interim-summary').before('<h2 class="text-center problem-base-interim-summary"><b>Interim Summary</b></h2>').attr('src', '{{ url('nicu-pblm-disch-abbreviated/'.Request::segment(2)) }}/interimiframe');

        //     $('#problem-base-interim-summary').css({'display': 'block','width': '50%', 'height': screen.height - 210, 'float': 'left', 'border': 'none'});    

        //     $('iframe#problem-base-interim-summary body').css({'overflow': 'hidden !important'});

        //     $('iframe#problem-base-interim-summary .print-tool-bar').css({'display': 'none'});                

        //     $('.open-compare').hide();
        //     $('.close-compare').show();
        // }); 
        // $('.close-compare').on('click', function() {
        //     $('.open-compare').show();
        //     $('.close-compare').hide();
        //     $('iframe#problem-base-interim-summary, .problem-base-interim-summary').hide();
        //     $('form').css({'width':'100%', 'float': 'left', 'padding-right': '0px', 'border-right': 'none'});
        //         // $('.container').css({'width':'unset', 'padding': 'unset'});
        // });
    </script>
</body>
</html>