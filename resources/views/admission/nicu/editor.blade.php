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
    <title>Nicu Admission Report</title>
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
        <a href="javascript:void(0);" class="btn save-report" title="Save report">
            <i class="fa fa-floppy-o fa-2x" aria-hidden="true"></i>
        </a>
        <a href="#" id="nicu-close" class="btn" title="Back">
            <i class="fa fa-times fa-2x" aria-hidden="true"></i>
        </a>
    </div>
    <div class="container">
        {!! Form::model(null,['method' => 'POST','url' => action('Admission\NicuController@saveFullEditor',null),'id'=>'nicu-reports']) !!}
        {!! Form::hidden('nicu_id',$dischage_summary['nicu_id']) !!}
        <textarea name="nicu_report" id="nicu_report">
            {!! $discharge_details['content'] !!}
        </textarea>
        {!! Form::close() !!}
        @php $toastrOptions = SiteHelpers::toastrOptions(); @endphp
        @if(isset($toastrOptions->custom_toastr))
        {!! Form::hidden('toastr_options',$toastrOptions->custom_toastr,['id'=>'toastr_options']) !!}
        @endif
    </div>
    <script type="text/javascript" src="{{ $site_url }}/js/libs/jquery-1.10.2.min.js"></script>
    <script src="{{ $site_url}}/js/bootstrap.js"></script>
    <script type="text/javascript" src="{{ $site_url }}/plugins/toastr-master/build/toastr.min.js"></script>
    <script type="text/javascript" src="{{ $site_url }}/plugins/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>
    <script type="text/javascript" src="{{ $site_url }}/plugins/ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            CKEDITOR.replace('nicu_report', {
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
            CKEDITOR.instances["nicu_report"].on('blur',function() {
             nicuReportSave();
            });
            $('.save-report').click(function() {
                $('#nicu-reports').submit();
            });
            $(document).on('click', '#cke_16', function() {
                nicuReportSave();
            });
            $('#nicu-close').click(function() {
                nicuReportSave(false);  
            });

            function nicuReportSave($slug=true) {
                    var report=CKEDITOR.instances['nicu_report'].getData();
                    $('textarea[name="nicu_report"]').val(report);

                    $.ajax({
                        headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      },
                      type    :"POST",
                      url     : "{{ url('nicu-adm-reports-save') }}",
                      data    :$('#nicu-reports').serialize(),
                      cache   : false,
                      dataType: "json",
                      success:function(response) {
                        if ($slug) {
                            Showalert(response.type, response.msg);
                        } else {
                            window.location = "{{ url('nicu-admission') }}";                        
                        }
                        },
                        error: function(response) {
                            Showalert('error','Record not saved. Try after some time !');
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
    </script>
</body>
</html>