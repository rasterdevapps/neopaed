@php $boys_chart_weight  = url('public/img/growth-chart/cht-wfa-boys-p-0-5.svg'); @endphp
@php $girls_chart_weight = url('public/img/growth-chart/cht-wfa-girls-p-0-5.svg'); @endphp
<div class="clearfix"></div>
<div id="{{ $growthcharts_parent }}">
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
			$('#{{$growthcharts_parent}}').addClass('who-growth-chart-male-weight');
		} else if(sex == 'Female') {
			$('#{{$growthcharts_parent}}').addClass('who-growth-chart-female-weight');
		}
		createWeightchart('{{ $growth_chart_id }}','{{ $sex }}','{{ $chartType }}');

		$(document).on('change','.growth-weight, #Sex',function() {

			createWeightchart('{{ $growth_chart_id }}','{{ $sex }}','{{ $chartType }}');

		});   

		$(window).resize(function() {

			createWeightchart('{{ $growth_chart_id }}','{{ $sex }}','{{ $chartType }}');

		});

	});

	function getWeightchartData(sex, chartCharacter) {

		if(sex == 'Male') {

			return JSON.parse('{!! $boys_weight !!}');

		} else if(sex == 'Female') {

			return JSON.parse('{!! $girls_weight !!}');

		}
	}

	function setWeightChartBackground(sourceId,sex,chartCharacter) {

		var windowWidth = $(window).width();

		var browser     = navigator.userAgent;

		if (sex == 'Male') {
	    	// $('#'+sourceId).css('background-image','url("{{ $boys_chart_weight }}")');	
	    	// $('#'+sourceId).attr('style', 'background-image: url("{{ $boys_chart_weight }}") !important;');

	    } else if(sex == 'Female') {

	    	// $('#'+sourceId).attr('style', 'background-image: url("{{ $girls_chart_weight }}") !important;');
			// $('#'+sourceId).css('background-image','url("{{ $girls_chart_weight }}")');	
		}

	}
	
	function createWeightchart(chartId,sex,chartCharacter) {

		var weightChartdata = getWeightchartData(sex,chartCharacter);
		setWeightChartBackground(chartId,sex,chartCharacter);
		var bulletSize      = getBulletSize();    

		var igWeightChart     = new AmCharts.AmXYChart();  
		var marginProperty    = getMarginproperty();  

		igWeightChart.dataProvider = weightChartdata;
		igWeightChart.marginRight  = marginProperty.marginRight;
		igWeightChart.marginBottom = marginProperty.marginBottom;
		igWeightChart.marginLeft   = marginProperty.marginLeft;
		igWeightChart.startDuration = 0;
		igWeightChart.autoMargins = false;



		//xAxis contain weight

		var xAxisWeight              = new AmCharts.ValueAxis();
		xAxisWeight.position         = "left";
		xAxisWeight.autoGridCount    = false;
		xAxisWeight.gridCount        = (sex =='Female') ? 25 : 25 ;
		xAxisWeight.gridAlpha        = 0;
		xAxisWeight.maximum 		 = (sex =='Female') ? 25 : 25 ;
		xAxisWeight.minimum			 = 1;
		xAxisWeight.minMaxMultiplier = 0.5;
		xAxisWeight.minorGridEnabled = false;
		xAxisWeight.labelFrequency 	 = 0.1;
		xAxisWeight.minorGridAlpha   = 0;
		xAxisWeight.minorTickLength  = 0;
		xAxisWeight.labelsEnabled    = false;
		xAxisWeight.tickLength       = 0;
		xAxisWeight.axisThickness    = 0;
		igWeightChart.addValueAxis(xAxisWeight);



        //xAxis contain gestation
        var yAxisWeight 			 = new AmCharts.ValueAxis();
        yAxisWeight.position      	 = "bottom";
        yAxisWeight.autoGridCount    = false;
        yAxisWeight.gridCount        = 240;
        yAxisWeight.gridAlpha 		 = 0;
        yAxisWeight.maximum 		 = 60;
        yAxisWeight.minimum 		 = 0;
        yAxisWeight.minorGridEnabled = true;
        yAxisWeight.minorGridAlpha	 = 0.8;
        yAxisWeight.labelsEnabled 	 = false;
        yAxisWeight.tickLength       = 0;
        yAxisWeight.axisThickness    = 0;
        igWeightChart.addValueAxis(yAxisWeight);  



		//add lines      

        //This for 3rd centile
        var firstGlineWeight = new AmCharts.AmGraph();
        firstGlineWeight.valueField = "value";
        firstGlineWeight.xField = "x";
        firstGlineWeight.yField = "y";
        firstGlineWeight.lineAlpha= 0.8;
        firstGlineWeight.lineThickness= 0;
        firstGlineWeight.bullet = "none";
        firstGlineWeight.title  = "3rd";
        firstGlineWeight.lineColor = "#FA2B2E";
        igWeightChart.addGraph(firstGlineWeight);


        //This for 3rd centile
        var secondGlineWeight = new AmCharts.AmGraph();
        secondGlineWeight.valueField = "value1";
        secondGlineWeight.xField = "x1";
        secondGlineWeight.yField = "y1";
        secondGlineWeight.lineAlpha= 0.8;
        secondGlineWeight.lineThickness= 0;
        secondGlineWeight.bullet = "none";
        secondGlineWeight.title  = "5th";
        secondGlineWeight.lineColor = "#141313";
        igWeightChart.addGraph(secondGlineWeight);


        //This for 10th centile
        var thirdGlineWeight = new AmCharts.AmGraph();
        thirdGlineWeight.valueField = "value2";
        thirdGlineWeight.xField = "x2";
        thirdGlineWeight.yField = "y2";
        thirdGlineWeight.lineAlpha= 0.8;
        thirdGlineWeight.lineThickness= 0;
        thirdGlineWeight.bullet = "none";
        thirdGlineWeight.title  = "15th";
        thirdGlineWeight.lineColor = "#141313";
        igWeightChart.addGraph(thirdGlineWeight);


         //This for 50th centile
         var fourthGlineWeight = new AmCharts.AmGraph();
         fourthGlineWeight.valueField = "value3";
         fourthGlineWeight.xField = "x3";
         fourthGlineWeight.yField = "y3";
         fourthGlineWeight.lineAlpha= 0.8;
         fourthGlineWeight.lineThickness= 0;
         fourthGlineWeight.bullet = "none";
         fourthGlineWeight.title  = "50th";
         fourthGlineWeight.lineColor = "#0eb725";
         igWeightChart.addGraph(fourthGlineWeight);

         //This for 90th centile
         var fifthGlineWeight = new AmCharts.AmGraph();
         fifthGlineWeight.valueField = "value4";
         fifthGlineWeight.xField = "x4";
         fifthGlineWeight.yField = "y4";
         fifthGlineWeight.lineAlpha= 0.8;
         fifthGlineWeight.lineThickness= 0;
         fifthGlineWeight.bullet = "none";
         fifthGlineWeight.title  = "95th";
         fifthGlineWeight.lineColor = "#141313";
         igWeightChart.addGraph(fifthGlineWeight);


         //This for 97th centile
         var seventhGlineWeight = new AmCharts.AmGraph();
         seventhGlineWeight.valueField = "value5";
         seventhGlineWeight.xField = "x5";
         seventhGlineWeight.yField = "y5";
         seventhGlineWeight.lineAlpha= 0.8;
         seventhGlineWeight.lineThickness= 0;
         seventhGlineWeight.bullet = "none";
         seventhGlineWeight.title  = "97th";
         seventhGlineWeight.lineColor = "#FA2B2E";
         igWeightChart.addGraph(seventhGlineWeight);

		//end lines    


        //This for baby growth  plots 
        var bGrowthlineWeight = new AmCharts.AmGraph();
        bGrowthlineWeight.valueField = "value";
        bGrowthlineWeight.id = "babyGrowthline";
        bGrowthlineWeight.xField = "x7";
        bGrowthlineWeight.yField = "y7";
        bGrowthlineWeight.lineAlpha = 0.8;
        bGrowthlineWeight.lineThickness= 0;
        bGrowthlineWeight.maxBulletSize = bulletSize;
        bGrowthlineWeight.minBulletSize = bulletSize;
        bGrowthlineWeight.bullet = "triangleUp";
        bGrowthlineWeight.bulletSize = 10;
        bGrowthlineWeight.title  = "bubbule";
        bGrowthlineWeight.lineColor = "#114caa";
        bGrowthlineWeight.balloonText = "<span class='font-size-13'>Chronological Age : [[x7]] \n Weight : [[value]]</span>";
        igWeightChart.addGraph(bGrowthlineWeight);

        var correctedLineweight = new AmCharts.AmGraph();
        correctedLineweight.valueField = "value";
        correctedLineweight.id = "correctedGrowthline";
        correctedLineweight.xField = "x8";
        correctedLineweight.yField = "y8";
        correctedLineweight.lineAlpha = 0.8;
        correctedLineweight.lineThickness= 0;
        correctedLineweight.maxBulletSize = bulletSize;
        correctedLineweight.minBulletSize = bulletSize;
        correctedLineweight.bullet = "square";
        bGrowthlineWeight.bulletSize = 8;
        correctedLineweight.title  = "bubbule";
        correctedLineweight.lineColor = "#e200c8";
        <?php 
          $baby_gestation = json_decode($baby->Gestation)->g_weeks; 
          if ($baby_gestation > 36) {
               ?>
               correctedLineweight.balloonText = "<span class='font-size-13'>Chronological Age : [[x8]] \n Weight : [[value]]</span>";
               <?php
          }
          else
          {
          ?>
               correctedLineweight.balloonText = "<span class='font-size-13'>Corrected Age : [[x8]] \n Weight : [[value]]</span>";
               <?php

          }
        ?>

        igWeightChart.addGraph(correctedLineweight);



        
        //data 



        @foreach($corrected_age_weight as $weight)  
        var cweight       = new Object();
        cweight.x8    = '{{ $weight["x8"] }}';
        cweight.y8    = '{{ $weight["y8"] }}';
        cweight.value = '{{ $weight["value"] }}';
        weightChartdata.push(cweight);
        @endforeach

        var chartCursorWeight          = new AmCharts.ChartCursor();
        chartCursorWeight.zoomable = false;
        igWeightChart.addChartCursor(chartCursorWeight);



        igWeightChart.write(chartId);

    }

    setInterval(function(){
    	$('.amcharts-chart-div').children('a').hide();
    },300);
    window.matchMedia('print').addListener(function(mql) {
    	if (mql.matches) {
    		createWeightchart('{{ $growth_chart_id }}','{{ $sex }}','{{ $chartType }}');
    	}
    });

    window.onbeforeprint = createWeightchart('{{ $growth_chart_id }}','{{ $sex }}','{{ $chartType }}');

function getBulletSize() {

    var windowWidth = $(window).width();

        if(windowWidth < 320 ) {

             bulletSize = 1;

        } else if(windowWidth > 320 && windowWidth <= 480) {

             bulletSize = 2;

        } else if(windowWidth > 481 && windowWidth <= 780) {

             bulletSize = 5;

        } else if(windowWidth > 781 && windowWidth  <= 1024) {

             bulletSize = 4;

        } else if(windowWidth > 1025 && windowWidth <= 1223) {

             bulletSize = 5;

        }  else if(windowWidth > 1224 && windowWidth < 1824) {

             bulletSize = 6;

        } else {

             bulletSize = 7;

        }

    return bulletSize; 
} 
</script>
