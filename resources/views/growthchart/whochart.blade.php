@extends('print')
@section('content')
<style type="text/css">
  .chart-headings > h4:last-child {
    margin: 0px;
  }
</style>
<div id="page-loader" class="loading-center" style="background: url('{{ url('/') }}/public/img/icons/preloader.gif') center no-repeat #fff"></div>
    {!! Form::hidden('print_style',$print_style,['id'=>'print_style']) !!}
<div class="temp-container" id="chart-print">
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
         
         <div class="col-md-11">
           @if(isset($baby_detail->BabyName) && isset($baby_detail->BMrNo)) 
            <div class="col-md-4" >Baby Name : {{ $baby_detail->BabyName}}</div>
            <div class="col-md-4" >Gender : {{ $baby_detail->Sex}}</div>
            <div class="col-md-4" >B{{ Lang::get('home.mrn') }} : {{ $baby_detail->BMrNo}}</div>
           @endif 
        </div>  
           @php $term = false; @endphp
    
           @php $growthchart_length_ids =($baby_detail->Sex == 'Female') ?  'growthCharts-length' : 'growthCharts-length-male' @endphp
           @php $growthchart_term_weight_id =($baby_detail->Sex == 'Female') ?  'termchart-weight' : 'termchart-weight-male' @endphp
           @php $growthchart_term_lenght_id =($baby_detail->Sex == 'Female') ?  'termchart-length' : 'termchart-length-male' @endphp
           @php $growthchart_term_head_id =($baby_detail->Sex == 'Female') ?  'termchart-head' : 'termchart-head-male' @endphp

       
        
        <div  id="page-list" class="col-md-11 page-change1 chart-headings">
            <h4> {{ title_case($weight_label) }} <h4>
        </div>
        <div class="col-md-11 page-change1">
            @include('growthchart.term_weight_chart',['growth_chart_id' => $growthchart_term_weight_id, 'chartType'=>'WEIGHT', 'growthcharts_parent' => 'growthcharts-parent4'])
        </div> 

        <div  id="page-list" class="col-md-11 page-change2 chart-headings">
            <h4> {{ title_case($length_label) }} <h4>
        </div>
        <div class="col-md-11 page-change2">
            @include('growthchart.term_length_chart',['growth_chart_id' => $growthchart_term_lenght_id, 'chartType'=>'WEIGHT', 'growthcharts_parent' => 'growthcharts-parent5'])
        </div> 

        <div  id="page-list" class="col-md-11 chart-headings" style='overflow:hidden;page-break-before:always;'>
            <h4> {{ title_case($head_label) }} <h4>
        </div>
        <div class="col-md-11 page-change4">
            @include('growthchart.term_head_chart',['growth_chart_id' => $growthchart_term_head_id, 'chartType'=>'WEIGHT', 'growthcharts_parent' => 'growthcharts-parent6'])
        </div> 



        <div class="col-md-11">
              <div id="inner-style">
              </div>
        </div>
            
    </div>
   
</div>
<script type="text/javascript">
  $(window).load(function() {
    $("#page-loader").fadeOut();
});
</script>
@endsection
