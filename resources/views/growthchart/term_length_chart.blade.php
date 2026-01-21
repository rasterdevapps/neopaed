
@php $boys_chart_length  = url('public/img/growth-chart/chart_length_boy.svg'); @endphp
@php $girls_chart_length  = url('public/img/growth-chart/chart_length_girls.svg'); @endphp


<div id="{{ $growthcharts_parent  }}">
	<div id="{{ $growth_chart_id }}" class="growth-charts-container">
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {


		function getLengthdata(sex , chartCharacter) {

			if(sex == 'Male') {

				return JSON.parse('{!! $term_boys_length !!}');

			}else if(sex == 'Female') {
				
				return JSON.parse('{!! $term_girls_length !!}');
			}
			
			

		}


		function setLengthChartBackground(sourceId,sex,chartCharacter) {

			var windowWidth = $(window).width();

			var browser     = navigator.userAgent;

			if(sex == 'Male') {

				$('#'+sourceId).css('background-image','url("{{ $boys_chart_length }}")').css('background-color','#4D90FE');

			}else if(sex == 'Female') {
				
				$('#'+sourceId).css('background-image','url("{{ $girls_chart_length }}")').css('background-color','#F390BC');
			}
			
			
			

		}





		function growthChart(chartId,sex,chartCharacter){

			var lengthChartdata = getLengthdata(sex,chartCharacter);
			setLengthChartBackground(chartId,sex,chartCharacter);
			var bulletSize      = getBulletSize();    

			var igLengthChart  = new AmCharts.AmXYChart();  

			var marginProperty    = getMarginproperty();  


			igLengthChart.dataProvider = lengthChartdata;

			igLengthChart.marginRight  = marginProperty.marginRight;
			igLengthChart.marginBottom = marginProperty.marginBottom;
			igLengthChart.marginLeft   = marginProperty.marginLeft;


			
			igLengthChart.startDuration = 0;
			igLengthChart.autoMargins = false;

		//xAxis contain weight

		var xAxisLength                  = new AmCharts.ValueAxis();
		xAxisLength.position          = "left";
		xAxisLength.autoGridCount     = false;
		xAxisLength.gridCount         = 10;
		xAxisLength.gridAlpha         = 0;
		xAxisLength.maximum  	      = 95;
		xAxisLength.minimum  	      = (sex == 'Female') ? 45 : 45;
		xAxisLength.minorGridEnabled  = true;
		xAxisLength.minorGridAlpha    = 0.1;
		xAxisLength.minorTickLength   = 1;
		xAxisLength.labelsEnabled     = false;
		xAxisLength.tickLength        = 0;
		xAxisLength.axisThickness     = 0;
		igLengthChart.addValueAxis(xAxisLength);

	        //xAxis contain gestation
	        var yAxisLength 			 = new AmCharts.ValueAxis();
	        yAxisLength.position 	     = "bottom";
	        yAxisLength.autoGridCount    = false;
	        yAxisLength.gridCount        = 24;
	        yAxisLength.gridAlpha        = 0;
	        yAxisLength.maximum          = 24;
	        yAxisLength.minimum          = 0;
	        yAxisLength.minorGridEnabled = true;
	        yAxisLength.minorGridAlpha   = 0.8;
	        yAxisLength.labelsEnabled    = false;
	        yAxisLength.tickLength       = 0;
	        yAxisLength.axisThickness    = 0;
	        igLengthChart.addValueAxis(yAxisLength);
	        

	        

		//add lines      

        //This for 3rd centile
        var firstGlineLength = new AmCharts.AmGraph();
        firstGlineLength.valueField = "value";
        firstGlineLength.xField = "x";
        firstGlineLength.yField = "y";
        firstGlineLength.lineAlpha= 0.8;
        firstGlineLength.lineThickness= 0;
        firstGlineLength.bullet = "none";
        firstGlineLength.title  = "3rd";
        firstGlineLength.lineColor = "#FA2B2E";
        igLengthChart.addGraph(firstGlineLength);


        //This for 3rd centile
        var secondGlineLength = new AmCharts.AmGraph();
        secondGlineLength.valueField = "value";
        secondGlineLength.xField = "x1";
        secondGlineLength.yField = "y1";
        secondGlineLength.lineAlpha= 0.8;
        secondGlineLength.lineThickness= 0;
        secondGlineLength.bullet = "none";
        secondGlineLength.title  = "5th";
        secondGlineLength.lineColor = "#141313";
        igLengthChart.addGraph(secondGlineLength);


        //This for 10th centile
        var thirdGlineLength = new AmCharts.AmGraph();
        thirdGlineLength.valueField = "value";
        thirdGlineLength.xField = "x2";
        thirdGlineLength.yField = "y2";
        thirdGlineLength.lineAlpha= 0.8;
        thirdGlineLength.lineThickness= 0;
        thirdGlineLength.bullet = "none";
        thirdGlineLength.title  = "10th";
        thirdGlineLength.lineColor = "#141313";
        igLengthChart.addGraph(thirdGlineLength);


         //This for 50th centile
         var fourthGlineLength = new AmCharts.AmGraph();
         fourthGlineLength.valueField = "value";
         fourthGlineLength.xField = "x3";
         fourthGlineLength.yField = "y3";
         fourthGlineLength.lineAlpha= 0.8;
         fourthGlineLength.lineThickness= 0;
         fourthGlineLength.bullet = "none";
         fourthGlineLength.title  = "50th";
         fourthGlineLength.lineColor = "#0eb725";
         igLengthChart.addGraph(fourthGlineLength);

         //This for 90th centile
         var fifthGlineLength = new AmCharts.AmGraph();
         fifthGlineLength.valueField = "value";
         fifthGlineLength.xField = "x4";
         fifthGlineLength.yField = "y4";
         fifthGlineLength.lineAlpha= 0.8;
         fifthGlineLength.lineThickness= 0;
         fifthGlineLength.bullet = "none";
         fifthGlineLength.title  = "90th";
         fifthGlineLength.lineColor = "#141313";
         igLengthChart.addGraph(fifthGlineLength);

         //This for 95th centile
         var sixthGlineLength = new AmCharts.AmGraph();
         sixthGlineLength.valueField = "value";
         sixthGlineLength.xField = "x5";
         sixthGlineLength.yField = "y5";
         sixthGlineLength.lineAlpha= 0.8;
         sixthGlineLength.lineThickness= 0;
         sixthGlineLength.bullet = "none";
         sixthGlineLength.title  = "95th";
         sixthGlineLength.lineColor = "#141313";
         igLengthChart.addGraph(sixthGlineLength);

         //This for 97th centile
         var seventhGlineLength = new AmCharts.AmGraph();
         seventhGlineLength.valueField = "value";
         seventhGlineLength.xField = "x6";
         seventhGlineLength.yField = "y6";
         seventhGlineLength.lineAlpha= 0.8;
         seventhGlineLength.lineThickness= 0;
         seventhGlineLength.bullet = "none";
         seventhGlineLength.title  = "97th";
         seventhGlineLength.lineColor = "#FA2B2E";
         igLengthChart.addGraph(seventhGlineLength);

		//end lines    


        //This for baby growth  plots 
        var babyGrowthlineLength = new AmCharts.AmGraph();
        babyGrowthlineLength.valueField = "value";
        babyGrowthlineLength.id = "babyGrowthlineLength";
        babyGrowthlineLength.xField = "x7";
        babyGrowthlineLength.yField = "y7";
        babyGrowthlineLength.lineAlpha = 0.8;
        babyGrowthlineLength.lineThickness= 0;
        babyGrowthlineLength.maxBulletSize = bulletSize;
        babyGrowthlineLength.minBulletSize = bulletSize;
        babyGrowthlineLength.bullet = "triangleUp";
        babyGrowthlineLength.title  = "bubbule";
        babyGrowthlineLength.lineColor = "#114caa";
        babyGrowthlineLength.balloonText = "<span class='font-size-13'>Chronological Age : [[x7]] \n Length : [[value]]</span>";

        igLengthChart.addGraph(babyGrowthlineLength);


        var cbabyGrowthlineLength = new AmCharts.AmGraph();
        cbabyGrowthlineLength.valueField = "value";
        cbabyGrowthlineLength.id = "cbabyGrowthlineLength";
        cbabyGrowthlineLength.xField = "x8";
        cbabyGrowthlineLength.yField = "y8";
        cbabyGrowthlineLength.lineAlpha = 0.8;
        cbabyGrowthlineLength.lineThickness= 0;
        cbabyGrowthlineLength.maxBulletSize = bulletSize;
        cbabyGrowthlineLength.minBulletSize = bulletSize;
        cbabyGrowthlineLength.bullet = "square";
        cbabyGrowthlineLength.title  = "bubbule";
        cbabyGrowthlineLength.lineColor = "#e200c8";
        cbabyGrowthlineLength.balloonText = "<span class='font-size-13'>Corrected Age : [[x8]] \n Length : [[value]]</span>";
        igLengthChart.addGraph(cbabyGrowthlineLength);

        
        $.each(lengthChartdata,function(index,value) {

        	if(lengthChartdata.length > 265){

        		lengthChartdata.pop();

        	}

        });   

        @foreach($growth_height as $length)  
        var length       = new Object();
        length.x7    = '{{ $length["x7"] }}';
        length.y7    = '{{ $length["y7"] }}';
        length.value = '{{ $length["value"] }}';
        lengthChartdata.push(length);
        @endforeach 

        @foreach($corrected_age_height as $height)  
        var clength       = new Object();
        clength.x8    = '{{ $height["x8"] }}';
        clength.y8    = '{{ $height["y8"] }}';
        clength.value = '{{ $height["value"] }}';
        lengthChartdata.push(clength);
        @endforeach            
        
        
        var chartCursor = new AmCharts.ChartCursor();

        chartCursor.zoomable= false;
        igLengthChart.addChartCursor(chartCursor);



        igLengthChart.write(chartId);


        

    }





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

    window.matchMedia('print').addListener(function(mql) {
    	if (mql.matches) {
    		growthChart('{{ $growth_chart_id }}','{{ $sex }}','{{ $chartType }}');
    	}
    });

    window.onbeforeprint = growthChart('{{ $growth_chart_id }}','{{ $sex }}','{{ $chartType }}');
});

setInterval(function(){
	$('.amcharts-chart-div').children('a').hide();
},300);

</script>

