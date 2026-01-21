@extends('print')
@section('content')
<style type="text/css">
  
@media only screen {
    body.print .container {
        width: unset;
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
        background-color: white;
        box-shadow: 0px 0px 8px -1px #000;
        display: inline-block;
    }
}
</style>
    {!! Form::hidden('print_style',$print_style,['id'=>'print_style']) !!}

    <div id="page-loader" class="loading-center" style="background: url('{{ url('/') }}/public/img/icons/preloader.gif') center no-repeat #fff"></div>
<div class="temp-container" id="chart-print">
	<div class="temp-row">
        <div class="col-md-12">
                <img src="{{ ValuelistHelpers::printPagelogo() }}">
        </div>
      
        <div class="col-md-12 pt-10">
		    <h3 class="print-head">
             {{ $chart_name }}
            </h3>
        </div>
         
         <div class="col-md-12 col-sm-12  col-xs-12 plr-must-0">
                <div class="col-md-6 col-sm-6  col-xs-6" >{{ isset($baby_detail->BabyName)  && !empty($baby_detail->BabyName) ? 'Baby Name : '.$baby_detail->BabyName : '' }}</div>
                <div class="col-md-6 col-sm-6  col-xs-6" >{{ isset($baby_detail->BMrNo)  && !empty($baby_detail->BMrNo) ? 'B'. Lang::get('home.mrn') .' : '.$baby_detail->BMrNo : '' }}</div>
        </div>  
        <div class="clearfix"></div> 
         <div class="col-md-12 plr-must-0">
            <div class="col-md-6" >{{ isset($baby_detail->Sex)  && !empty($baby_detail->Sex) ? 'Gender : '.$baby_detail->Sex : '' }}</div>
            <div class="col-md-6" >{{ isset($baby_detail->DOB)  && !empty($baby_detail->DOB) ? 'DOB : '.date('d-m-Y', strtotime($baby_detail->DOB)) : '' }}</div>
        </div>  
        <div class="clearfix"></div> 
           @php $term = false; @endphp
    
           @php $growthchart_length_ids =($baby_detail->Sex == 'Female') ?  'growthCharts-length' : 'growthCharts-length-male' @endphp
           @php $growthchart_term_weight_id =($baby_detail->Sex == 'Female') ?  'termchart-weight' : 'termchart-weight-male' @endphp
           @php $growthchart_term_lenght_id =($baby_detail->Sex == 'Female') ?  'termchart-length' : 'termchart-length-male' @endphp
           @php $growthchart_term_head_id =($baby_detail->Sex == 'Female') ?  'termchart-head' : 'termchart-head-male' @endphp

        <div class="col-md-11 chart-headings">
            <h4> {{ title_case($weight_label) }} </h4>
        </div>
        <div class="col-md-11">
        	@include('growthchart.growth_chart_weight',['growth_chart_id' => 'growthCharts-weight', 'chartType'=>'WEIGHT', 'growthcharts_parent' => 'growthcharts-parent1'])
        </div> 
        <div class="col-md-11 chart-headings row-spacing" >
            <h4> {{ title_case($length_label) }} </h4>
        </div>
        <div class="col-md-11">
            @include('growthchart.growth_chart_length',['growth_chart_id' => $growthchart_length_ids, 'chartType'=>'LENGTH', 'growthcharts_parent' => 'growthcharts-parent2'])
        </div> 
        <div  id="page-list" class="col-md-11 chart-headings row-spacing">
            <h4> {{ title_case($head_label) }} <h4>
        </div>
        <div class="col-md-11">
            @include('growthchart.growth_chart_head',['growth_chart_id' => 'growthCharts-head', 'chartType'=>'HEAD', 'growthcharts_parent' => 'growthcharts-parent3'])
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
