@php $boys_chart_head  = url('public/img/growth-chart/boys-chart-head-circumference-for-age-birth-to-5-years.svg'); @endphp
@php $girls_chart_head  = url('public/img/growth-chart/girls-chart-head-circumference-for-age-birth-to-5-years.svg'); @endphp


<div id="{{ $growthcharts_parent  }}">
	<div id="{{ $growth_chart_id }}" class="growth-charts-container">
	</div>
</div>

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
	$(document).ready(function() {
		var sex = '{{$sex}}';
		if(sex == 'Male') {
			$('#{{$growthcharts_parent}}').addClass('who-growth-chart-male-head');

		}else if(sex == 'Female') {
			$('#{{$growthcharts_parent}}').addClass('who-growth-chart-female-head');
		}

		growthHeadChart('{{ $growth_chart_id }}','{{ $sex }}','{{ $chartType }}');

		$(document).on('change','.chart_weigth,.chart_gestation,#Sex',function() {

			growthHeadChart('{{ $growth_chart_id }}','{{ $sex }}','{{ $chartType }}');

		});   

		$(document).on('click','.weight-remove',function() {

			$(this).parent('td').parent('tr').remove();
			growthHeadChart('{{ $growth_chart_id }}','{{ $sex }}','{{ $chartType }}');

		});

		$(window).resize(function(){

			growthHeadChart('{{ $growth_chart_id }}','{{ $sex }}','{{ $chartType }}');

		});

	});

	function getHeaddata(sex , chartCharacter) {


		if(sex == 'Male') {

			return JSON.parse('{!! $boys_head !!}');

		} else if(sex == 'Female') {

			return JSON.parse('{!! $girls_head !!}');
		}

	}


	function setHeadChartBackground(sourceId,sex,chartCharacter) {

		var windowWidth = $(window).width();

		var browser     = navigator.userAgent;



		if(sex == 'Male') {

    	// $('#'+sourceId).css('background-image','url("{{ $boys_chart_head }}")').css('background-color','#4D90FE');
    	// $('#'+sourceId).attr('style', 'background-image: url("{{ $boys_chart_head }}") !important; background-color: #0098DB;');

    } else if(sex == 'Female') {

	     	// $('#'+sourceId).css('background-image','url("{{ $girls_chart_head }}")').css('background-color','#F390BC');
	    	// $('#'+sourceId).attr('style', 'background-image: url("{{ $girls_chart_head }}") !important; background-color: #e45bbf;');
	    }



	}

	function growthHeadChart(chartId,sex,chartCharacter){

		var headChartdata = getHeaddata(sex,chartCharacter);

		setHeadChartBackground(chartId,sex,chartCharacter);
		var bulletSize      = getBulletSize();    



		var igHeadChart  = new AmCharts.AmXYChart();  

		var marginProperty    = getMarginproperty();  


		igHeadChart.dataProvider = headChartdata;

		igHeadChart.marginRight  = marginProperty.marginRight;
		igHeadChart.marginBottom = marginProperty.marginBottom;
		igHeadChart.marginLeft   = marginProperty.marginLeft;



		igHeadChart.startDuration = 0;
		igHeadChart.autoMargins = false;

		//xAxis contain weight


		var xAxisHead				   = new AmCharts.ValueAxis();
		xAxisHead.position 		   = "left";
		xAxisHead.autoGridCount    = false;
		xAxisHead.gridCount 	   = 60;
		xAxisHead.gridAlpha        = 0;
		xAxisHead.maximum          = (sex == 'Female') ? 54 : 55;
		xAxisHead.minimum          = (sex == 'Female') ? 31 : 32;
		xAxisHead.minorGridEnabled = true;
		xAxisHead.minorGridAlpha   = 10;
		xAxisHead.minorTickLength  = 0;
		xAxisHead.labelFrequency   = 0.5;
		   // xAxisHead.strictMinMax     = true;
		   xAxisHead.labelsEnabled    = false;
		   xAxisHead.tickLength       = 0;
		   xAxisHead.axisThickness    = 0;
		   igHeadChart.addValueAxis(xAxisHead);


	        //xAxis contain gestation
	        var yAxisHead 				= new AmCharts.ValueAxis();
	        yAxisHead.position 			= "bottom";
	        yAxisHead.autoGridCount 	= false;
	        yAxisHead.gridCount         = 60;
	        yAxisHead.gridAlpha         = 0;
	        yAxisHead.maximum           = 60;
	        yAxisHead.minimum           = 0;
	        yAxisHead.minorGridEnabled  = true;
	        yAxisHead.minorGridAlpha    = 0.8;
	        yAxisHead.labelsEnabled     = false;
	        yAxisHead.tickLength        = 0;
	        yAxisHead.axisThickness     = 0;
	        igHeadChart.addValueAxis(yAxisHead);




		//add lines      

        //This for 3rd centile
        var firstGlineHead = new AmCharts.AmGraph();
        firstGlineHead.valueField = "value";
        firstGlineHead.xField = "x";
        firstGlineHead.yField = "y";
        firstGlineHead.lineAlpha= 0.8;
        firstGlineHead.lineThickness= 0;
        firstGlineHead.bullet = "none";
        firstGlineHead.title  = "3rd";
        firstGlineHead.lineColor = "#FA2B2E";
        igHeadChart.addGraph(firstGlineHead);


        //This for 3rd centile
        var secondGlineHead = new AmCharts.AmGraph();
        secondGlineHead.valueField = "value";
        secondGlineHead.xField = "x1";
        secondGlineHead.yField = "y1";
        secondGlineHead.lineAlpha= 0.8;
        secondGlineHead.lineThickness= 0;
        secondGlineHead.bullet = "none";
        secondGlineHead.title  = "5th";
        secondGlineHead.lineColor = "#141313";
        igHeadChart.addGraph(secondGlineHead);


        //This for 10th centile
        var thirdGlineHead = new AmCharts.AmGraph();
        thirdGlineHead.valueField = "value";
        thirdGlineHead.xField = "x2";
        thirdGlineHead.yField = "y2";
        thirdGlineHead.lineAlpha= 0.8;
        thirdGlineHead.lineThickness= 0;
        thirdGlineHead.bullet = "none";
        thirdGlineHead.title  = "10th";
        thirdGlineHead.lineColor = "#141313";
        igHeadChart.addGraph(thirdGlineHead);


         //This for 50th centile
         var fourthGlineHead = new AmCharts.AmGraph();
         fourthGlineHead.valueField = "value";
         fourthGlineHead.xField = "x3";
         fourthGlineHead.yField = "y3";
         fourthGlineHead.lineAlpha= 0.8;
         fourthGlineHead.lineThickness= 0;
         fourthGlineHead.bullet = "none";
         fourthGlineHead.title  = "50th";
         fourthGlineHead.lineColor = "#0eb725";
         igHeadChart.addGraph(fourthGlineHead);

         //This for 90th centile
         var fifthGlineHead = new AmCharts.AmGraph();
         fifthGlineHead.valueField = "value";
         fifthGlineHead.xField = "x4";
         fifthGlineHead.yField = "y4";
         fifthGlineHead.lineAlpha= 0.8;
         fifthGlineHead.lineThickness= 0;
         fifthGlineHead.bullet = "none";
         fifthGlineHead.title  = "90th";
         fifthGlineHead.lineColor = "#141313";
         igHeadChart.addGraph(fifthGlineHead);

         //This for 95th centile
         var sixthGlineHead = new AmCharts.AmGraph();
         sixthGlineHead.valueField = "value";
         sixthGlineHead.xField = "x5";
         sixthGlineHead.yField = "y5";
         sixthGlineHead.lineAlpha= 0.8;
         sixthGlineHead.lineThickness= 0;
         sixthGlineHead.bullet = "none";
         sixthGlineHead.title  = "95th";
         sixthGlineHead.lineColor = "#141313";
         igHeadChart.addGraph(sixthGlineHead);

         //This for 97th centile
         var seventhGlineHead = new AmCharts.AmGraph();
         seventhGlineHead.valueField = "value";
         seventhGlineHead.xField = "x6";
         seventhGlineHead.yField = "y6";
         seventhGlineHead.lineAlpha= 0.8;
         seventhGlineHead.lineThickness= 0;
         seventhGlineHead.bullet = "none";
         seventhGlineHead.title  = "97th";
         seventhGlineHead.lineColor = "#FA2B2E";
         igHeadChart.addGraph(seventhGlineHead);

		//end lines    


        //This for baby growth  plots 
        var babyGrowthlineHead = new AmCharts.AmGraph();
        babyGrowthlineHead.valueField = "value";
        babyGrowthlineHead.id = "babyGrowthlineHead";
        babyGrowthlineHead.xField = "x7";
        babyGrowthlineHead.yField = "y7";
        babyGrowthlineHead.lineAlpha = 0.8;
        babyGrowthlineHead.lineThickness= 0;
        babyGrowthlineHead.maxBulletSize = bulletSize;
        babyGrowthlineHead.minBulletSize = bulletSize;
        babyGrowthlineHead.bullet = "triangleUp";
        babyGrowthlineHead.title  = "bubbule";
        babyGrowthlineHead.lineColor = "#114caa";
        babyGrowthlineHead.balloonText = "<span class='font-size-13'>Chronological Age : [[x7]] \n  Head Circumference  : [[value]]</span>";
        igHeadChart.addGraph(babyGrowthlineHead);

        var cbabyGrowthlineHead = new AmCharts.AmGraph();
        cbabyGrowthlineHead.valueField = "value";
        cbabyGrowthlineHead.id = "cbabyGrowthlineHead";
        cbabyGrowthlineHead.xField = "x8";
        cbabyGrowthlineHead.yField = "y8";
        cbabyGrowthlineHead.lineAlpha = 0.8;
        cbabyGrowthlineHead.lineThickness= 0;
        cbabyGrowthlineHead.maxBulletSize = bulletSize;
        cbabyGrowthlineHead.minBulletSize = bulletSize;
        cbabyGrowthlineHead.bullet = "square";
        cbabyGrowthlineHead.title  = "bubbule";
        cbabyGrowthlineHead.lineColor = "#e200c8";
        <?php 
          $baby_gestation = json_decode($baby->Gestation)->g_weeks; 
          if ($baby_gestation > 36) {
               ?>
            cbabyGrowthlineHead.balloonText = "<span class='font-size-13'>Chronological Age : [[x8]] \n  Head Circumference  : [[value]]</span>";
               <?php
          }
          else
          {
          ?>
            cbabyGrowthlineHead.balloonText = "<span class='font-size-13'>Corrected Age : [[x8]] \n  Head Circumference  : [[value]]</span>";
               <?php

          }
        ?>
        igHeadChart.addGraph(cbabyGrowthlineHead);

        $.each(headChartdata,function(index,value) {

        	if(headChartdata.length > 265){

        		headChartdata.pop();

        	}

        });        
        
        @foreach($corrected_age_head as $head)  

        var head = new Object();
        head.x8 = '{{ $head["x8"] }}';
        head.y8 = '{{ $head["y8"] }}';
        head.value = '{{ $head["value"] }}';
        headChartdata.push(head);
        @endforeach 





        var chartCursor = new AmCharts.ChartCursor();

        chartCursor.zoomable= false;
        igHeadChart.addChartCursor(chartCursor);


        igHeadChart.write(chartId);




    }


    window.matchMedia('print').addListener(function(mql) {
    	if (mql.matches) {
    		growthHeadChart('{{ $growth_chart_id }}','{{ $sex }}','{{ $chartType }}');
    	}
    });

    window.onbeforeprint = growthHeadChart('{{ $growth_chart_id }}','{{ $sex }}','{{ $chartType }}');
</script>

