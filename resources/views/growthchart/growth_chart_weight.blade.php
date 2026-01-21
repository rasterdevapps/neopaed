@php $boys_chart_weight  = url('public/img/growth-chart/growth_preterm_boys_bw_en.svg'); @endphp
@php $girls_chart_weight = url('public/img/growth-chart/growth_preterm_girls_bw_en.svg'); @endphp

	<div id="{{ $growthcharts_parent  }}">
		<div id="{{ $growth_chart_id }}" class="growth-charts-container">

		</div>
	</div>
<script type="text/javascript">
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
    	$('#'+sourceId).css('background-image','url("{{ $boys_chart_weight }}")').css('background-color','#4D90FE');	
    	   
      } else if(sex == 'Female') {

		$('#'+sourceId).css('background-image','url("{{ $girls_chart_weight }}")').css('background-color','#F390BC');	
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

       	var xAxisWeight = new AmCharts.ValueAxis();
		xAxisWeight.position = "left";
		xAxisWeight.autoGridCount = false;
	    xAxisWeight.gridCount = 22;
	    xAxisWeight.gridAlpha = 0;
	    xAxisWeight.maximum  = 10.5;
	    xAxisWeight.minimum  = 0.0;
	    xAxisWeight.minorGridEnabled = true;
	    xAxisWeight.minorGridAlpha = 0.1;
	    xAxisWeight.minorTickLength = 0;
	    xAxisWeight.labelsEnabled = false;
	    xAxisWeight.tickLength = 0;
	    xAxisWeight.axisThickness = 1;
		igWeightChart.addValueAxis(xAxisWeight);


        //xAxis contain gestation
		var yAxisWeight = new AmCharts.ValueAxis();
		yAxisWeight.position = "bottom";
		yAxisWeight.autoGridCount = false;
	    yAxisWeight.gridCount=44;
	    yAxisWeight.gridAlpha =0;
	    yAxisWeight.maximum  = 64;
	    yAxisWeight.minimum  = 27;
	    yAxisWeight.minorGridEnabled = true;
	    yAxisWeight.minorGridAlpha = 0.8;
	    yAxisWeight.labelsEnabled = false;
	    yAxisWeight.tickLength = 3;
	    yAxisWeight.axisThickness = 1;
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
		secondGlineWeight.valueField = "value";
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
		thirdGlineWeight.valueField = "value";
		thirdGlineWeight.xField = "x2";
		thirdGlineWeight.yField = "y2";
		thirdGlineWeight.lineAlpha= 0.8;
	    thirdGlineWeight.lineThickness= 0;
		thirdGlineWeight.bullet = "none";
	    thirdGlineWeight.title  = "10th";
        thirdGlineWeight.lineColor = "#141313";
		igWeightChart.addGraph(thirdGlineWeight);


         //This for 50th centile
		var fourthGlineWeight = new AmCharts.AmGraph();
		fourthGlineWeight.valueField = "value";
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
		fifthGlineWeight.valueField = "value";
		fifthGlineWeight.xField = "x4";
		fifthGlineWeight.yField = "y4";
		fifthGlineWeight.lineAlpha= 0.8;
	    fifthGlineWeight.lineThickness= 0;
		fifthGlineWeight.bullet = "none";
		fifthGlineWeight.title  = "90th";
        fifthGlineWeight.lineColor = "#141313";
		igWeightChart.addGraph(fifthGlineWeight);

         //This for 95th centile
		var sixthGlineWeight = new AmCharts.AmGraph();
		sixthGlineWeight.valueField = "value";
		sixthGlineWeight.xField = "x5";
		sixthGlineWeight.yField = "y5";
		sixthGlineWeight.lineAlpha= 0.8;
	    sixthGlineWeight.lineThickness= 0;
		sixthGlineWeight.bullet = "none";
		sixthGlineWeight.title  = "95th";
        sixthGlineWeight.lineColor = "#141313";
		igWeightChart.addGraph(sixthGlineWeight);

         //This for 97th centile
		var seventhGlineWeight = new AmCharts.AmGraph();
		seventhGlineWeight.valueField = "value";
		seventhGlineWeight.xField = "x6";
		seventhGlineWeight.yField = "y6";
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
		bGrowthlineWeight.bullet = "round";
		bGrowthlineWeight.title  = "bubbule";
		bGrowthlineWeight.lineColor = "#114caa";
		igWeightChart.addGraph(bGrowthlineWeight);


	  $.each(weightChartdata, function(index, value) {

       	   if (weightChartdata.length > 265) {

       	   	    weightChartdata.pop();

       	   }

       });        
        
      @foreach($growth_weight as $weight)  
	      var weight       = new Object();
	          weight.x7    = '{{ $weight["x7"] }}';
	          weight.y7    = '{{ $weight["y7"] }}';
	          weight.value = '{{ $weight["value"] }}';
		      weightChartdata.push(weight);
      @endforeach  


     



		var chartCursorWeight          = new AmCharts.ChartCursor();
		    chartCursorWeight.zoomable = false;
		igWeightChart.addChartCursor(chartCursorWeight);


		
		igWeightChart.write(chartId);

}
$(document).ready(function() {



	createWeightchart('{{ $growth_chart_id }}','{{ $sex }}','{{ $chartType }}');

	$(document).on('change','.growth-weight, #Sex',function() {
           alert()
	   createWeightchart('{{ $growth_chart_id }}','{{ $sex }}','{{ $chartType }}');
					
	});   

	$(window).resize(function(){

	   createWeightchart('{{ $growth_chart_id }}','{{ $sex }}','{{ $chartType }}');

	});

});

  setInterval(function(){
          $('.amcharts-chart-div').children('a').hide();
      },300);


window.matchMedia('print').addListener(function(mql) {
	if (mql.matches) {
	   createWeightchart('{{ $growth_chart_id }}','{{ $sex }}','{{ $chartType }}');
	}
});

window.onbeforeprint = createWeightchart('{{ $growth_chart_id }}','{{ $sex }}','{{ $chartType }}');
</script>
