@php $boys_chart_weight  = url('public/img/growth-chart/growth_preterm_boys_bw_en.svg'); @endphp
@php $girls_chart_weight = url('public/img/growth-chart/growth_preterm_girls_bw_en.svg'); @endphp
@php $boys_chart_length  = url('public/img/growth-chart/growth_preterm_boys_lt_en.svg'); @endphp
@php $boys_chart_head  = url('public/img/growth-chart/growth_preterm_boys_hc_en.svg'); @endphp


<div id="{{ $growthcharts_parent  }}">
	<div id="{{ $growth_chart_id }}" class="growth-charts-container">
	</div>
</div>

<script type="text/javascript">
$(document).ready(function() {


function gendrateChartdata(sex , chartCharacter) {

	switch (chartCharacter) {

    	case 'WEIGHT':

    	    if(sex == 'Male') {

     	       return JSON.parse('{!! $boys_weight !!}');

            }else if(sex == 'Female') {
   
                return JSON.parse('{!! $girls_weight !!}');
            }
    		
    		break;

    	case 'HEAD':

    	    if(sex == 'Male') {

     	       return JSON.parse('{!! $boys_head !!}');

            }else if(sex == 'Female') {
   
                return JSON.parse('{!! $girls_head !!}');
            }
    		
    	break;	

    	case 'LENGTH':

    	    if(sex == 'Male') {

     	       return JSON.parse('{!! $boys_length !!}');

            }else if(sex == 'Female') {
   
                return JSON.parse('{!! $girls_length !!}');
            }
    		
    	break;
    	
    	default:

    		if(sex == 'Male') {

     	       return JSON.parse('{!! $boys_weight !!}');

            }else if(sex == 'Female') {
   
                return JSON.parse('{!! $girls_weight !!}');
            }
    		
    		break;
    }

}


function setChartbackground(sourceId,sex,chartCharacter) {

	var windowWidth = $(window).width();

	var browser     = navigator.userAgent;

     switch (chartCharacter) {

    	case 'WEIGHT':

    	    if(sex == 'Male') {
    	    	   $('#'+sourceId).css('background-image','url("{{ $boys_chart_weight }}")').css('background-color','#4D90FE');	

    	    	

    	   
            }else if(sex == 'Female') {

				
    	    	   $('#'+sourceId).css('background-image','url("{{ $girls_chart_weight }}")');	

    	    


            }
    		
    		break;

    	case 'HEAD':

    	    if(sex == 'Male') {

    	        $('#'+sourceId).css('background-image','url("{{ $boys_chart_head }}")').css('background-color','#4D90FE');

            }else if(sex == 'Female') {
   
     	        $('#'+sourceId).css('background-image','url("{{ $boys_chart_head }}")');
            }
    		
    	break;	

    	case 'LENGTH':

    	    if(sex == 'Male') {

    	        $('#'+sourceId).css('background-image','url("{{ $boys_chart_length }}")').css('background-color','#4D90FE');

            }else if(sex == 'Female') {
   
     	        $('#'+sourceId).css('background-image','url("{{ $boys_chart_length }}")');
            }
    		
    	break;
    	
    	default:

    		if(sex == 'Male') {

    	        $('#'+sourceId).css('background-image','url("{{ $boys_chart_weight }}")');

            }else if(sex == 'Female') {
   
     	        $('#'+sourceId).css('background-image','url("{{ $girls_chart_weight }}")');
            }
    		
    		break;
    }

 

}





function growthChart(chartId,sex,chartCharacter){

	    var chartData = gendrateChartdata(sex,chartCharacter);
	                    setChartbackground(chartId,sex,chartCharacter);

		var interGrowthchart  = new AmCharts.AmXYChart();  

		var marginProperty    = getMarginproperty();  


		interGrowthchart.dataProvider = chartData;

		interGrowthchart.marginRight  = marginProperty.marginRight;
		interGrowthchart.marginBottom = marginProperty.marginBottom;
		interGrowthchart.marginLeft   = marginProperty.marginLeft;


		
		interGrowthchart.startDuration = 0;
		interGrowthchart.autoMargins = false;

		//xAxis contain weight
       if (chartCharacter == 'WEIGHT') {

       	var xAxis = new AmCharts.ValueAxis();
		xAxis.position = "left";
		xAxis.autoGridCount = false;
	    xAxis.gridCount = 22;
	    xAxis.gridAlpha = 0;
	    xAxis.maximum  = 10.5;
	    xAxis.minimum  = 0.0;
	    xAxis.minorGridEnabled = true;
	    xAxis.minorGridAlpha = 0.1;
	    xAxis.minorTickLength = 1;
	    xAxis.labelsEnabled = false;
	    xAxis.tickLength = 5;
	    xAxis.axisThickness = 1;

		interGrowthchart.addValueAxis(xAxis);

        //xAxis contain gestation
		var yAxis = new AmCharts.ValueAxis();
		yAxis.position = "bottom";
		yAxis.autoGridCount = false;
	    yAxis.gridCount=44;
	    yAxis.gridAlpha =0;
	    yAxis.maximum  = 64;
	    yAxis.minimum  = 27;
	    yAxis.minorGridEnabled = true;
	    yAxis.minorGridAlpha = 0.8;
	    yAxis.labelsEnabled = false;
	    yAxis.tickLength = 5;
	    yAxis.axisThickness = 1;
		interGrowthchart.addValueAxis(yAxis);   

       } else if(chartCharacter == 'LENGTH') {

       	  var xAxis = new AmCharts.ValueAxis();
			xAxis.position = "left";
			xAxis.autoGridCount = false;
		    xAxis.gridCount = 44;
		    xAxis.gridAlpha = 0;
		    xAxis.maximum  = 72;
		    xAxis.minimum  = 28;
		    xAxis.minorGridEnabled = true;
		    xAxis.minorGridAlpha = 0.1;
		    xAxis.minorTickLength = 1;
		    xAxis.labelsEnabled = false;
		    xAxis.tickLength = 5;
		    xAxis.axisThickness = 1;

			interGrowthchart.addValueAxis(xAxis);

	        //xAxis contain gestation
			var yAxis = new AmCharts.ValueAxis();
			yAxis.position = "bottom";
			yAxis.autoGridCount = false;
		    yAxis.gridCount=44;
		    yAxis.gridAlpha =0;
		    yAxis.maximum  = 64;
		    yAxis.minimum  = 27;
		    yAxis.minorGridEnabled = true;
		    yAxis.minorGridAlpha = 0.8;
		    yAxis.labelsEnabled = false;
		    yAxis.tickLength = 5;
		    yAxis.axisThickness = 1;
			interGrowthchart.addValueAxis(yAxis);

       }  else if(chartCharacter == 'HEAD') {

       	  var xAxis = new AmCharts.ValueAxis();
			xAxis.position = "left";
			xAxis.autoGridCount = false;
		    xAxis.gridCount = 44;
		    xAxis.gridAlpha = 0;
		    xAxis.maximum  = 47;
		    xAxis.minimum  = 21;
		    xAxis.minorGridEnabled = true;
		    xAxis.minorGridAlpha = 0.1;
		    xAxis.minorTickLength = 1;
		    xAxis.labelsEnabled = false;
		    xAxis.tickLength = 5;
		    xAxis.axisThickness = 1;

			interGrowthchart.addValueAxis(xAxis);

	        //xAxis contain gestation
			var yAxis = new AmCharts.ValueAxis();
			yAxis.position = "bottom";
			yAxis.autoGridCount = false;
		    yAxis.gridCount=44;
		    yAxis.gridAlpha =0;
		    yAxis.maximum  = 64;
		    yAxis.minimum  = 27;
		    yAxis.minorGridEnabled = true;
		    yAxis.minorGridAlpha = 0.8;
		    yAxis.labelsEnabled = false;
		    yAxis.tickLength = 5;
		    yAxis.axisThickness = 1;
			interGrowthchart.addValueAxis(yAxis);

       }

		

		//add lines      

        //This for 3rd centile
		var firstGline = new AmCharts.AmGraph();
		firstGline.valueField = "value";
		firstGline.xField = "x";
		firstGline.yField = "y";
		firstGline.lineAlpha= 0.8;
	    firstGline.lineThickness= 0;
		firstGline.bullet = "none";
		firstGline.title  = "3rd";
        firstGline.lineColor = "#FA2B2E";
		interGrowthchart.addGraph(firstGline);


        //This for 3rd centile
		var secondGline = new AmCharts.AmGraph();
		secondGline.valueField = "value";
		secondGline.xField = "x1";
		secondGline.yField = "y1";
		secondGline.lineAlpha= 0.8;
	    secondGline.lineThickness= 0;
		secondGline.bullet = "none";
		secondGline.title  = "5th";
        secondGline.lineColor = "#141313";
		interGrowthchart.addGraph(secondGline);


        //This for 10th centile
		var thirdGline = new AmCharts.AmGraph();
		thirdGline.valueField = "value";
		thirdGline.xField = "x2";
		thirdGline.yField = "y2";
		thirdGline.lineAlpha= 0.8;
	    thirdGline.lineThickness= 0;
		thirdGline.bullet = "none";
	    thirdGline.title  = "10th";
        thirdGline.lineColor = "#141313";
		interGrowthchart.addGraph(thirdGline);


         //This for 50th centile
		var fourthGline = new AmCharts.AmGraph();
		fourthGline.valueField = "value";
		fourthGline.xField = "x3";
		fourthGline.yField = "y3";
		fourthGline.lineAlpha= 0.8;
	    fourthGline.lineThickness= 0;
		fourthGline.bullet = "none";
		fourthGline.title  = "50th";
        fourthGline.lineColor = "#0eb725";
		interGrowthchart.addGraph(fourthGline);

         //This for 90th centile
		var fifthGline = new AmCharts.AmGraph();
		fifthGline.valueField = "value";
		fifthGline.xField = "x4";
		fifthGline.yField = "y4";
		fifthGline.lineAlpha= 0.8;
	    fifthGline.lineThickness= 0;
		fifthGline.bullet = "none";
		fifthGline.title  = "90th";
        fifthGline.lineColor = "#141313";
		interGrowthchart.addGraph(fifthGline);

         //This for 95th centile
		var sixthGline = new AmCharts.AmGraph();
		sixthGline.valueField = "value";
		sixthGline.xField = "x5";
		sixthGline.yField = "y5";
		sixthGline.lineAlpha= 0.8;
	    sixthGline.lineThickness= 0;
		sixthGline.bullet = "none";
		sixthGline.title  = "95th";
        sixthGline.lineColor = "#141313";
		interGrowthchart.addGraph(sixthGline);

         //This for 97th centile
		var seventhGline = new AmCharts.AmGraph();
		seventhGline.valueField = "value";
		seventhGline.xField = "x6";
		seventhGline.yField = "y6";
		seventhGline.lineAlpha= 0.8;
	    seventhGline.lineThickness= 0;
		seventhGline.bullet = "none";
		seventhGline.title  = "97th";
        seventhGline.lineColor = "#FA2B2E";
		interGrowthchart.addGraph(seventhGline);

		//end lines    


        //This for baby growth  plots 
		var babyGrowthline = new AmCharts.AmGraph();
		babyGrowthline.valueField = "value";
		babyGrowthline.id = "babyGrowthline";
		babyGrowthline.xField = "x7";
		babyGrowthline.yField = "y7";
		babyGrowthline.lineAlpha = 0.8;
		babyGrowthline.lineThickness= 0;
		babyGrowthline.maxBulletSize = 7;
		babyGrowthline.minBulletSize = 7;
		babyGrowthline.bullet = "round";
		babyGrowthline.title  = "bubbule";
		babyGrowthline.lineColor = "#114caa";
		interGrowthchart.addGraph(babyGrowthline);
             
       $.each(chartData,function(index,value){

       	   if(chartData.length > 265){

       	   	    chartData.pop();

       	   }

       });        
        
      @foreach($growth_weight as $weight)  
       if (chartCharacter == 'WEIGHT') {

	      var weight = new Object();
	          weight.x7 = '{{ $weight["x7"] }}';
	          weight.y7 = '{{ $weight["y7"] }}';
	          weight.value = '{{ $weight["value"] }}';
		      chartData.push(weight);
        }
      @endforeach  

      if(chartCharacter == 'LENGTH') {

      	var length = new Object();
	        length.x7 = 33;
	        length.y7 = 48;
	        length.value = 48;
		    chartData.push(length);


      }

      if(chartCharacter == 'HEAD') {

      	var length = new Object();
	        length.x7 = 33;
	        length.y7 = 48;
	        length.value = 48;
		    chartData.push(length);


      }

     //    var index = 1;
     //    $('.chart_gestation').each(function(){

		   // var chartGestation = $('#chart_gestation'+index).val();
		   // var chartWeight    = $('#chart_weigth'+index).val();
		   // if(chartGestation != '' && chartWeight !='') {
		       
		   // }
     //      index++		
     //    });


		var chartCursor = new AmCharts.ChartCursor();

		     chartCursor.zoomable= false;
		interGrowthchart.addChartCursor(chartCursor);
		

	     


        if (chartCharacter == 'WEIGHT') {

		     $(document).on('click','#export-weight',function() {

			  var exp = new AmCharts.AmExport(interGrowthchart);
				    exp.init();
				    exp.output({
				        format: 'print'
				    });
		    });
		}  


          if(chartCharacter == 'LENGTH') {


			   // $(document).on('click','#export-length',function() {
					//printDiv('{{ $growthcharts_parent  }}');
					var exp = new AmCharts.AmExport(interGrowthchart);
				    exp.init();
				    exp.userCFG = {
						menuTop		: '0px',
						menuLeft	: 'auto',
						menuRight	: '0px',
						menuBottom	: '0px',
						menuItems	: [{
							textAlign : 'center',
							icon      : 'http://localhost/neo_up/public/plugins/amcharts/images/export.png',
							iconTitle : 'Save chart as an image',
							onclick   : function () {},
							items     : [{
								title: 'JPG',
								format: 'print'
							}, {
								title: 'PNG',
								format: 'print'
							}, {
								title: 'SVG',
								format: 'print'
							}]
						}],
						menuItemStyle: {
							backgroundColor		: 'red',
							opacity			: 1,
							rollOverBackgroundColor	: '#EFEFEF',
							color			: '#000000',
							rollOverColor		: '#CC0000',
							paddingTop		: '6px',
							paddingRight		: '6px',
							paddingBottom		: '6px',
							paddingLeft		: '6px',
							marginTop		: '0px',
							marginRight		: '0px',
							marginBottom		: '0px',
							marginLeft		: '0px',
							textAlign		: 'left',
							textDecoration		: 'none',
							fontFamily		: 'Arial', // Default: charts default
							fontSize		: '12px', // Default: charts default
						},
						menuItemOutput: {
							backgroundColor		: '#FFFFFF',
							fileName		: 'amCharts',
							format			: 'print',
							output			: 'print',
							render			: 'browser',
							dpi			    : 90,
							onclick			: function(instance, config, event) {

								console.log(instance);
						    exp.output({
				                       format: 'print'
				                   });
						    }
						},
						legendPosition: "top", //top,left,right
						removeImagery: true
					};
					
			    //});
		 }

		 if(chartCharacter == 'HEAD') {


			//$(document).on('click','#export-head',function() {
			//printDiv('{{ $growthcharts_parent  }}');
				var exp = new AmCharts.AmExport(interGrowthchart);
				    exp.init();
				    exp.userCFG = {
						menuTop		: '0px',
						menuLeft	: 'auto',
						menuRight	: '0px',
						menuBottom	: '0px',
						menuItems	: [{
							textAlign : 'center',
							icon      : 'http://localhost/neo_up/public/plugins/amcharts/images/export.png',
							iconTitle : 'Save chart as an image',
							onclick   : function () {},
							items     : [{
								title: 'JPG',
								format: 'jpg'
							}, {
								title: 'PNG',
								format: 'png'
							}, {
								title: 'SVG',
								format: 'svg'
							}]
						}],
						menuItemStyle: {
							backgroundColor		: 'red',
							opacity			: 1,
							rollOverBackgroundColor	: '#EFEFEF',
							color			: '#000000',
							rollOverColor		: '#CC0000',
							paddingTop		: '6px',
							paddingRight		: '6px',
							paddingBottom		: '6px',
							paddingLeft		: '6px',
							marginTop		: '0px',
							marginRight		: '0px',
							marginBottom		: '0px',
							marginLeft		: '0px',
							textAlign		: 'left',
							textDecoration		: 'none',
							fontFamily		: 'Arial', // Default: charts default
							fontSize		: '12px', // Default: charts default
						},
						menuItemOutput: {
							backgroundColor		: '#FFFFFF',
							fileName		: 'amCharts',
							format			: 'png',
							output			: 'dataurlnewwindow',
							render			: 'browser',
							dpi			: 90,
							onclick			: function(instance, config, event) {
								event.preventDefault();
								instance.output(config);
							}
						},
						legendPosition: "top", //top,left,right
						removeImagery: true
					};

		  //  });
		  }

		  interGrowthchart.write(chartId);


		

}



function PrintMe(DivID) {
var disp_setting="toolbar=yes,location=no,";
disp_setting+="directories=yes,menubar=yes,";
disp_setting+="scrollbars=yes,width=650, height=600, left=100, top=25";
   var content_vlue = document.getElementById(DivID).innerHTML;
   var docprint=window.open("","",disp_setting);
   docprint.document.open();
   docprint.document.write('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"');
   docprint.document.write('"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">');
   docprint.document.write('<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">');
   docprint.document.write('<head><title>My Title</title>');
   docprint.document.write('<style type="text/css">body{ margin:0px;');
   docprint.document.write('font-family:verdana,Arial;color:#000;');
   docprint.document.write('font-family:Verdana, Geneva, sans-serif; font-size:12px;}');
   docprint.document.write('a{color:#000;text-decoration:none;} </style>');
   docprint.document.write('</head><body onLoad="self.print()"><center>');
   docprint.document.write(content_vlue);
   docprint.document.write('</center></body></html>');
   docprint.document.close();
   docprint.focus();
}


function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}   	

	growthChart('{{ $growth_chart_id }}',$('#Sex').val(),'{{ $chartType }}');

	$(document).on('change','.chart_weigth,.chart_gestation,#Sex',function() {

	   growthChart('{{ $growth_chart_id }}',$('#Sex').val(),'{{ $chartType }}');
					
	});   

	$(document).on('click','.weight-remove',function() {

		$(this).parent('td').parent('tr').remove();
		 growthChart('{{ $growth_chart_id }}',$('#Sex').val(),'{{ $chartType }}');

	});

	$(window).resize(function(){

	   growthChart('{{ $growth_chart_id }}',$('#Sex').val(),'{{ $chartType }}');

	});

});

  // setInterval(function(){
  //         $('.amcharts-chart-div').children('a').hide();
  //     },300);

</script>
	