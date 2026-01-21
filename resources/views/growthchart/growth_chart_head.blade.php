@php $boys_chart_head  = url('public/img/growth-chart/growth_preterm_boys_hc_en.svg'); @endphp
@php $girls_chart_head  = url('public/img/growth-chart/growth_preterm-girls_hc_en.svg'); @endphp


<div id="{{ $growthcharts_parent  }}">
	<div id="{{ $growth_chart_id }}" class="growth-charts-container">
	</div>
</div>

<script type="text/javascript">
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

    	$('#'+sourceId).css('background-image','url("{{ $boys_chart_head }}")').css('background-color','#4D90FE');

    } else if(sex == 'Female') {
   
     	$('#'+sourceId).css('background-image','url("{{ $girls_chart_head }}")').css('background-color','#F390BC');
    }
    		
    	

}





function growthChart(chartId,sex,chartCharacter){

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
     

       	  var xAxisHead = new AmCharts.ValueAxis();
			xAxisHead.position = "left";
			xAxisHead.autoGridCount = false;
		    xAxisHead.gridCount = 44;
		    xAxisHead.gridAlpha = 0;
		    xAxisHead.maximum  = (sex == 'Female') ? 46 : 47;
		    xAxisHead.minimum  = (sex == 'Female') ? 20 : 21;
		    xAxisHead.minorGridEnabled = true;
		    xAxisHead.minorGridAlpha = 0.1;
		    xAxisHead.minorTickLength = 1;
		    xAxisHead.labelsEnabled = false;
		    xAxisHead.tickLength = 0;
		    xAxisHead.axisThickness = 1;

			igHeadChart.addValueAxis(xAxisHead);

	        //xAxis contain gestation
			var yAxisHead = new AmCharts.ValueAxis();
			yAxisHead.position = "bottom";
			yAxisHead.autoGridCount = false;
		    yAxisHead.gridCount=44;
		    yAxisHead.gridAlpha =0;
		    yAxisHead.maximum  = 64;
		    yAxisHead.minimum  = 27;
		    yAxisHead.minorGridEnabled = true;
		    yAxisHead.minorGridAlpha = 0.8;
		    yAxisHead.labelsEnabled = false;
		    yAxisHead.tickLength = 0;
		    yAxisHead.axisThickness = 1;
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
		babyGrowthlineHead.bullet = "round";
		babyGrowthlineHead.title  = "bubbule";
		babyGrowthlineHead.lineColor = "#114caa";
		igHeadChart.addGraph(babyGrowthlineHead);
             
       $.each(headChartdata,function(index,value) {

       	   if(headChartdata.length > 265){

       	   	    headChartdata.pop();

       	   }

       });        
        
      @foreach($growth_head as $head)  

	      var head = new Object();
	          head.x7 = '{{ $head["x7"] }}';
	          head.y7 = '{{ $head["y7"] }}';
	          head.value = '{{ $head["value"] }}';
		      headChartdata.push(head);
      @endforeach
  
    


		var chartCursor = new AmCharts.ChartCursor();

		     chartCursor.zoomable= false;
		igHeadChart.addChartCursor(chartCursor);
		

		igHeadChart.write(chartId);


		

}
$(document).ready(function() {



	growthChart('{{ $growth_chart_id }}','{{ $sex }}','{{ $chartType }}');

	$(document).on('change','.chart_weigth,.chart_gestation,#Sex',function() {

	   growthChart('{{ $growth_chart_id }}','{{ $sex }}','{{ $chartType }}');
					
	});   

	$(document).on('click','.weight-remove',function() {
		$(this).parent('td').parent('tr').remove();
		 growthChart('{{ $growth_chart_id }}','{{ $sex }}','{{ $chartType }}');

	});

	$(window).resize(function(){

	   growthChart('{{ $growth_chart_id }}','{{ $sex }}','{{ $chartType }}');

	});

});

window.matchMedia('print').addListener(function(mql) {
	if (mql.matches) {
	   growthChart('{{ $growth_chart_id }}','{{ $sex }}','{{ $chartType }}');
	}
});

window.onbeforeprint = growthChart('{{ $growth_chart_id }}','{{ $sex }}','{{ $chartType }}');

</script>
	