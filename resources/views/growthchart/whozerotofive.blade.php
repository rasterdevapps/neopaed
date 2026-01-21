@extends('print')
@section('content')

<script class="special-print-css" type="text/javascript" src="{{ url('/') }}/public/plugins/amcharts/amcharts.js"></script>
<script class="special-print-css" type="text/javascript" src="{{ url('/') }}/public/plugins/amcharts/serial.js"></script>
<script class="special-print-css" type="text/javascript" src="{{ url('/') }}/public/plugins/amcharts/amstock.js"></script>

<script class="special-print-css" type="text/javascript" src="{{ url('/') }}/public/plugins/amcharts/xy.js"></script>
<script class="special-print-css" type="text/javascript" src="{{ url('/') }}/public/plugins/amcharts/amexport_combined.js"></script>
<script class="special-print-css" type="text/javascript" src="{{ url('/') }}/public/plugins/amcharts/plugins/export/export.min.js"></script>
<script class="special-print-css" type="text/javascript" src="{{ url('/') }}/public/plugins/amcharts/themes/light.js"></script>

<script class="special-print-css" type="text/javascript" src="{{ url('/') }}/public/plugins/amcharts/plugins/export/libs/blob.js/blob.js"></script>
<script class="special-print-css" type="text/javascript" src="{{ url('/') }}/public/plugins/amcharts/plugins/export/libs/classList.js/classList.min.js"></script>
<script class="special-print-css" type="text/javascript" src="{{ url('/') }}/public/plugins/amcharts/plugins/export/libs/fabric.js/fabric.min.js"></script>
<script class="special-print-css" type="text/javascript" src="{{ url('/') }}/public/plugins/amcharts/plugins/export/libs/FileSaver.js/FileSaver.min.js"></script>
<script class="special-print-css" type="text/javascript" src="{{ url('/') }}/public/plugins/amcharts/plugins/export/libs/jszip/jszip.min.js"></script>
<script class="special-print-css" type="text/javascript" src="{{ url('/') }}/public/plugins/amcharts/plugins/export/libs/pdfmake/pdfmake.min.js"></script>
<script class="special-print-css" type="text/javascript" src="{{ url('/') }}/public/plugins/amcharts/plugins/export/libs/xlsx/xlsx.min.js"></script>
<script type="text/javascript">
        
function getMarginproperty() {

    var marginProperty ;

    var windowWidth = $(window).width();

    if(windowWidth >= 1280 ) {
            //window size greater than 1280

          marginProperty =  JSON.parse('{ "marginRight":70, "marginBottom":20, "marginLeft":30,"marginTop":0}');

    } else if(windowWidth < 1280 && windowWidth >= 960) {
            //window size less than 1280 and greater than 960
         marginProperty =  JSON.parse('{ "marginRight":70, "marginBottom":20, "marginLeft":30,"marginTop":0}');

    } else if(windowWidth < 960 && windowWidth >= 860) {
            //window size less than 1280 and greater than 960
         marginProperty =  JSON.parse('{ "marginRight":40, "marginBottom":15, "marginLeft":20,"marginTop":0}');

    } else if(windowWidth < 860 && windowWidth >= 768) {

         marginProperty =  JSON.parse('{ "marginRight":50, "marginBottom":15, "marginLeft":20,"marginTop":0}');

    } else if(windowWidth < 768 && windowWidth >= 700) {

         marginProperty =  JSON.parse('{ "marginRight":40, "marginBottom":10, "marginLeft":20,"marginTop":0}');

    }  else if(windowWidth < 768 && windowWidth >= 700) {

        marginProperty =  JSON.parse('{ "marginRight":40, "marginBottom":10, "marginLeft":20,"marginTop":0}');

    } else {
        marginProperty =  JSON.parse('{ "marginRight":40, "marginBottom":10, "marginLeft":20,"marginTop":0}');

    }



    return marginProperty;
}
    </script>
<style type="text/css">
    
@media only screen {
    body.print .container {
        width: 91%;
        margin: auto;
    }
    body.print .container {    
        padding-left: 0px;
        padding-right: 0px;  
        padding-top: 1em;
        padding-bottom: 1em;
        background-color: unset;
        box-shadow: unset;
    }
    body.print .container .temp-container {   
        padding-top: 1em;
        padding-bottom: 1em;
        padding-left: 1em;
        padding-right: 4em;
        background-color: white;
        box-shadow: 0px 0px 8px -1px #000;
        display: inline-block;
    }
}
</style>
    <div id="page-loader" class="loading-center" style="background: url('{{ url('/') }}/public/img/icons/preloader.gif') center no-repeat #fff"></div>
<div class="temp-container">
    <div class="temp-row">
        <div class="col-md-11">
            <div class="col-md-6">
                <img src="{{ ValuelistHelpers::printPagelogo() }}">
            </div>
        </div>
        <div class="col-md-11">
            <h3 class="print-head">
             {{ $chart_name }}
            </h3>
        </div> 
      <div class="col-md-12">
            <div class="col-md-3">
                Baby Name : {{ $baby->BabyName}}
            </div>
            <div class="col-md-3">
                Baby {{ Lang::get('home.mrn') }} : {{ $baby->BMrNo}}
            </div>
            <div class="col-md-3">
                Baby Gestation : {{ SiteHelpers::decode_gestation($baby->Gestation)}}
            </div>

        </div>
    </div>
    @php $growthchart_term_weight_id =($baby->Sex == 'Female') ?  'who-birthtofive-weight-female' : 'who-birthtofive-weight-male' @endphp
    @php $growthchart_term_lenght_id =($baby->Sex == 'Female') ?  'who-birthtofive-length-female' : 'who-birthtofive-length-male' @endphp
    @php $growthchart_term_head_id =($baby->Sex == 'Female') ?  'who-birthtofive-head-female' : 'who-birthtofive-head-male' @endphp
     <!-- <div  id="page-list" class="col-md-11 page-change1 chart-headings">
            <h4> {{ title_case($weight_label) }} <h4>
        </div> -->
        <div class="col-md-10 page-change1" style="z-index: 0;">
            
            @include('growthchart.zerotofiveweight',['growth_chart_id' => $growthchart_term_weight_id, 'chartType'=>'WEIGHT', 'growthcharts_parent' => 'growthcharts-parent4'])
        </div> 
        <div class="col-xs-12">
            <!-- <hr class="seperater">  -->
        </div> 
        <!-- <div  id="page-list" class="col-md-11 page-change2 chart-headings">
            <h4> {{ title_case($length_label) }} <h4>
        </div> -->
        <div class="col-md-10 page-change2" style="z-index: 0;">
            @include('growthchart.zerotofivelength',['growth_chart_id' => $growthchart_term_lenght_id, 'chartType'=>'WEIGHT', 'growthcharts_parent' => 'growthcharts-parent5'])
        </div> 
<div class="col-xs-12">
            <!-- <hr class="seperater">  -->
        </div> 
        <!-- <div  id="page-list" class="col-md-11 chart-headings" style='overflow:hidden;page-break-before:always;'>
            <h4> {{ title_case($head_label) }} <h4>
        </div> -->
        <div class="col-md-10 page-change4" style="z-index: 0;">
            @include('growthchart.zerotofivehead',['growth_chart_id' => $growthchart_term_head_id, 'chartType'=>'WEIGHT', 'growthcharts_parent' => 'growthcharts-parent6'])
        </div> 
</div>
</div>
 <style type="text/css"> 
        body
        {
            overflow-x: hidden;
        }
    </style>
<script type="text/javascript">
  $(window).load(function() {
    $("#page-loader").fadeOut();
});
</script>
    
@endsection
