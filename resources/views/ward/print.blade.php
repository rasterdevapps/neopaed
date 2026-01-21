<?php $permissions = session('menu_permission');
      $site_url = url('/public');
      $public_url = url('public').'/';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Neopaed</title>
    <link href="{{ $site_url}}/css/customized.css" rel="stylesheet">
    <link href="{{ $site_url}}/css/main.css" rel="stylesheet">
    <link href="{{ $site_url}}/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css-min">
    <link href="{{ $site_url}}/css/custom.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{$site_url}}/css/prescription_print.css">
    <link rel="stylesheet" href="{{ $site_url}}/css/fontawesome/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="{{ $site_url }}/plugins/toastr-master/build/toastr.css"/>
    <link href="{{ $site_url }}/plugins/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ $site_url }}/img/logo.png" />

    <!-- Fonts -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{ $site_url }}/plugins/amcharts/plugins/export/export.css" type="text/css" media="all" />
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="{{ $site_url }}/css/growthchart.css" rel="stylesheet" type="text/css" />

  <script type="text/javascript" src="{{ $site_url }}/js/libs/jquery-1.10.2.min.js"></script>

	<link href="{{ $site_url }}/css/print.css" rel="stylesheet" type="text/css" />
  
</head>

<body class="print">
<div class="row">
 @if(!Session::has('discharge-editor')) 
    <div class="print-tool-bar hidden-print ">
     @if(Request::segment(1) != 'growthchart-view' && Request::segment(1) != 'nicu-nurse-sheet-graph')
     <a href="javascript:void(0);" onclick="window.print();" class="btn" title="print">
        <i class="fa fa-print fa-2x" aria-hidden="true"></i>
     </a> 
     @endif
     @if(Request::segment(1) == 'growthchart-view')
      <a href="javascript:void(0);" onclick="printPage('chart-print');" class="btn" title="print">
        <i class="fa fa-print fa-2x" aria-hidden="true"></i>
     </a> 
     @endif
     
     @if(isset($closewinlink))
      <a href="{{ $closewinlink }}"  title="back" class="btn">
         <i class="fa fa-times fa-2x" aria-hidden="true"></i>
     </a> 
     @endif  
     @if(Request::segment(1) == 'nicu-discharge-summary')
     @php $specialPermission = \Session::get('specialPermissions'); @endphp
    @php if(isset($dischargeSummarymodified['is_completed']) && $dischargeSummarymodified['is_completed'] == 2 && !in_array('DISCHARGE_EDIT',$specialPermission)){ $dischargeEditpermission = 'hide'; }else{ $dischargeEditpermission = ''; } @endphp
       
       <a href="javascript:void(0);" class="btn savebtn hide hidden-print {!! $dischargeEditpermission !!}  neonatal-intensive-care-save">
         <i class="fa fa-floppy-o fa-2x" aria-hidden="true"></i>
       </a>
        <a href="javascript:void(0);" title="open editor for full page" class="btn hidden-print open-editor">
          <i class="fa fa-file-text fa-2x" aria-hidden="true"></i>
        </a>
        <a href="javascript:void(0);" title="Default" class="btn hidden-print pull-right neonatal-intensive-care-default {!! $dischargeEditpermission !!}  @if(count($dischargeSummarymodified) > 0 && $dischargeSummarymodified['status']==0) hide @elseif(count($dischargeSummarymodified)<=0) hide @endif">
         <i class="fa fa-undo fa-2x" aria-hidden="true"></i>
       </a>
     @endif
    </div>
   @endif   
    <br/>

    <div class="container main">
        @yield('content')
    </div>



</div>
<!-- Scripts -->
<script src="{{ $site_url}}/js/bootstrap.js"></script>
<script type="text/javascript" src="{{ $site_url }}/js/nicudischarge.js"></script>  
<script type="text/javascript" src="{{ $site_url }}/plugins/bootbox/bootbox.min.js"></script>
<script type="text/javascript" src="{{ $site_url }}/plugins/toastr-master/build/toastr.min.js"></script>
<script type="text/javascript" src="{{ $site_url }}/plugins/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>

<script type="text/javascript" src="{{ $site_url}}/plugins/amcharts/amcharts.js"></script>
<script type="text/javascript" src="{{ $site_url}}/plugins/amcharts/serial.js"></script>
<script type="text/javascript" src="{{ $site_url}}/plugins/amcharts/amstock.js"></script>

<script src="{{ $site_url }}/plugins/amcharts/xy.js"></script>
<script src="{{ $site_url }}/plugins/amcharts/amexport_combined.js"></script>
<script type="text/javascript" src="{{ $site_url}}/plugins/amcharts/plugins/export/export.min.js"></script>
<script type="text/javascript" src="{{ $site_url}}/plugins/amcharts/themes/light.js"></script>

<script src="{{ $site_url }}/plugins/amcharts/plugins/export/libs/blob.js/blob.js"></script>
<script src="{{ $site_url }}/plugins/amcharts/plugins/export/libs/classList.js/classList.min.js"></script>
<script src="{{ $site_url }}/plugins/amcharts/plugins/export/libs/fabric.js/fabric.min.js"></script>
<script src="{{ $site_url }}/plugins/amcharts/plugins/export/libs/FileSaver.js/FileSaver.min.js"></script>
<script src="{{ $site_url }}/plugins/amcharts/plugins/export/libs/jszip/jszip.min.js"></script>
<script src="{{ $site_url }}/plugins/amcharts/plugins/export/libs/pdfmake/pdfmake.min.js"></script>
<script src="{{ $site_url }}/plugins/amcharts/plugins/export/libs/xlsx/xlsx.min.js"></script>
<script type="text/javascript" src="{{ $site_url }}/js/growth-chart.js"></script>

<script type="text/javascript" src="{{ $site_url }}/js/annual_report.js"></script>
<script  type="text/javascript" src="{{ $site_url }}/plugins/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="{{ $site_url }}/js/nurse-chart.js"></script>


<script type="text/javascript">
    CKEDITOR.config.customConfig = '{{ $site_url }}/js/ckeditor.js';
</script>
<script type="text/javascript">
@if(Session::has('Success'))
  toastr.success('Success',' {!! Session::get("Success")  !!}');
@endif        
@if(Session::has('info'))
  toastr.info('info',' {!! Session::get("info")  !!}');
@endif         
@if(Session::has('warning'))
  toastr.warning('warning',' {!! Session::get("warning")  !!}');
@endif
@if(Session::has('error'))
  toastr.error('error',' {!! Session::get("error")  !!}');
@endif

function Showalert(type,message){
  toastr.remove();
  toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": true,
                    "progressBar": false,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": true,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut" }
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



function responseMessageajax(errorNo,message){
 
  switch(errorNo){
      case 200:
          return Showalert('success',message); 
      case 201:
          return Showalert('warning',message);    
      case 302:
         return Showalert('warning','You not have permission !');
      break;
      default:
         return Showalert('warning','Something went worng contact admin !');
      break;
  }
  }

</script>


@yield('scripts')

</body>
</html>
