@extends('print')
@section('content')
@php $i = 1; @endphp
<style type="text/css">
    #chartdiv{
      width:100%;
      height:500px;
    }
</style>

<div class="content hide" style="margin-top: 35px">
  <input type="date" name="startdate">
  <input type="date" name="enddate">
  <button id="search"> search</button>
</div>
@foreach($parameter_settings as $res)
    <div id="chartdiv{{$i}}"></div>
    @php $i++; @endphp
@endforeach

@endsection
@section('scripts')
<script>
function getValueAxis(title)
{
  valueAxis           = {};
  valueAxis.id              = "v1";
  valueAxis.axisAlpha       = 0;
  valueAxis.position        = "left";  
  valueAxis.ignoreAxisWidth = false; 
  valueAxis.title = title;
    
  return valueAxis;

}    
function getBalloon() {
    ballon = {};
    ballon.borderThickness = 1;
    ballon.shadowAlpha     = 0;
    return ballon;
}
function getBalloonDesign() {

    balloon = {};
    balloon.drop              = true;
    balloon.adjustBorderColor = false;
    balloon.color             = "#ffffff";

}
function getGraph() {
    graph           = {}
    graph.id                        = "g1";
    graph.balloon                   = getBalloonDesign();
    graph.bullet                    = "round";
    graph.bulletBorderAlpha         = 1;
    graph.bulletColor               = "#FFFFFF";
    graph.bulletSize                = 5;
    graph.hideBulletsCount          = 50;
    graph.lineThickness             = 0;
    graph.title                     = "red line";
    graph.useLineColorForBulletBorder = true;
    graph.valueField                = "value";
    graph.balloonText               = "<span style='font-size:18px;'>[[value]]</span>";
    return graph;
}

function getChartScrollBar() {

    chartScrollBar = {};
    chartScrollBar.graph =  "g1";
    chartScrollBar.oppositeAxis = false;
    chartScrollBar.offset = 10;
    chartScrollBar.scrollbarHeight =  10;
    chartScrollBar.backgroundAlpha =  0;
    chartScrollBar.selectedBackgroundAlpha =  0;
    chartScrollBar.backgroundColor ="#85c5e3";
    chartScrollBar.graphFillColor = "#85c5e3";
    chartScrollBar.color = "#85c5e3";
    chartScrollBar.selectedBackgroundColor = "#9cc580";
    chartScrollBar.selectedGraphFillColor = "#9cc580";
    chartScrollBar.graphFillAlpha =  0;
    chartScrollBar.graphLineAlpha =  0;
    chartScrollBar.selectedGraphFillAlpha =  0;
    chartScrollBar.selectedGraphLineAlpha =  0;
    chartScrollBar.autoGridCount = true;
    chartScrollBar.color = "#AAAAAA";
    chartScrollBar.enabled = false;
    return chartScrollBar; 
}

function getChartCursor() {
    chartCursor = {};
    chartCursor.pan= true;
    chartCursor.valueLineEnabled= false;
    chartCursor.valueLineBalloonEnabled= false;
    chartCursor.cursorAlpha=0;
    chartCursor.cursorColor="#258cbb";
    chartCursor.limitToGraph="g1";
    chartCursor.valueLineAlpha=0;
    chartCursor.valueZoomable=true;
    return chartCursor;
}

function getValueScrollBar() {
    valueScrollbar = {};
    valueScrollbar.oppositeAxis    = false;
    valueScrollbar.offset          = 50;
    valueScrollbar.scrollbarHeight = 10;
    valueScrollbar.enabled        = false; 
    return valueScrollbar;
}

function getCategoryAxis() {

    categoryAxis = {};
    categoryAxis.parseDates = false;
    categoryAxis.dashLength = 0;
    categoryAxis.minorGridEnabled = false;
    categoryAxis.labelsEnabled = false;
    return categoryAxis; 
}
function createChart() {

  $.ajax({
        type:'GET',
        url:'{{ action("Nurse\NurseChartController@nurseChartData",$baby_id) }}',
        beforeSend:function() {
          $('#vital-signs-chart-content').html('<div class="col-md-12"><div class="vitals-loader"><i class="fa fa-spinner fa-pulse fa-5x fa-fw" aria-hidden="true"></i></div></div>');
        },
        success: function(responseText){
            var id = 1;
            $.each(responseText.parameter_settings, function(index, value) {
                if(responseText.parameter_settings[index].charttype == 1 ) {
                    getDotChart(id, responseText.result[index], value);
                } else if(responseText.parameter_settings[index].charttype == 2) {
                    getBoxwhiskerplot(id,responseText.result[index], value)
                }
                id++;
            });

        }
})

}



function getDotChart(id, chartData, value)
{
    $("#chartdiv"+id).css('width', '100%').css('height', '400px');
    console.log(chartData);
    var chart = AmCharts.makeChart("chartdiv"+id, {
        "type": "serial",
        "theme": "none",
        "marginRight": 40,
        "marginLeft": 40,
        "autoMarginOffset": 20,
        "mouseWheelZoomEnabled":false,
        "dataDateFormat": "DD-MM-YYYY JJ:NN",
        "valueAxes": [getValueAxis(value.name)],
        "balloon": getBalloon(),
        "graphs": [getGraph()],
        "chartScrollbar": getChartScrollBar(),
        "chartCursor": getChartCursor(),
        "valueScrollbar":getValueScrollBar(),
        "categoryField": "date",
        "categoryAxis": getCategoryAxis(),
        "export": {
            "enabled": false
        },
        "dataProvider": chartData
    });

    chart.addListener("rendered", zoomChart);
    function zoomChart() {
        chart.zoomToIndexes(chart.dataProvider.length - 40, chart.dataProvider.length - 1);
    }
    zoomChart();
  
}

function BoxwhiskerchartCursor() {

  var chartCursor = {};
    chartCursor.enabled = true;
    chartCursor.pan = false;
    chartCursor.valueLineEnabled = false;
    chartCursor.valueLineBalloonEnabled = false;
    chartCursor.cursorAlpha = 0;
    chartCursor.cursorColor = "#258cbb";
    chartCursor.limitToGraph = "g1";
    chartCursor.valueLineAlpha = 0.2;
    chartCursor.valueZoomable = false;
    chartCursor.oneBalloonOnly =true;
    chartCursor.leaveCursor = false;
    chartCursor.leaveAfterTouch = false;

    return chartCursor;

}
function boxWhiskerCategory(valueLabel) {
    var boxWhiskerCategory = {};
        //boxWhiskerCategory.title = "Time";
        boxWhiskerCategory.gridPosition = "start";
        boxWhiskerCategory.tickPosition = "start";
        boxWhiskerCategory.tickLength = 1;
        boxWhiskerCategory.axisAlpha = 0.7;
        boxWhiskerCategory.gridAlpha = 0;
        boxWhiskerCategory.centerRotatedLabels = false;
        boxWhiskerCategory.labelRotation = 45;
        boxWhiskerCategory.labelsEnabled = valueLabel;


   return boxWhiskerCategory;
}

function boxWhiskerValueAxes(title) {
       var boxWhiskerValueAxesmaster = [];
       var boxWhiskerValueAxes = {};
           boxWhiskerValueAxes.id="v1";
           boxWhiskerValueAxes.position = "left";
           boxWhiskerValueAxes.title = title;
           boxWhiskerValueAxes.axisAlpha = 0;
           boxWhiskerValueAxes.autoGridCount = true;
           boxWhiskerValueAxes.gridCount = 100;
           boxWhiskerValueAxes.minorGridAlpha =0.01;
           boxWhiskerValueAxes.minMaxMultiplier = 1;

           boxWhiskerValueAxesmaster.push(boxWhiskerValueAxes);
         
    return boxWhiskerValueAxesmaster;
}

function BoxscrollBare() {
  var scrollBare = {};
      scrollBare.autoGridCount = true;
      scrollBare.graph = "g1";
      scrollBare.scrollbarHeight = 40;   
      scrollBare.oppositeAxis = false;
      scrollBare.offset = 10; 
      scrollBare.backgroundAlpha = 1;
      scrollBare.backgroundColor ="#85c5e3";
      scrollBare.graphFillColor = "#85c5e3";
      scrollBare.color = "#85c5e3";
      scrollBare.selectedBackgroundColor = "#9cc580";
      scrollBare.selectedGraphFillColor = "#9cc580";
      scrollBare.graphFillAlpha  = 1; 
      scrollBare.enabled = false;

  return scrollBare;         
}

function getBoxwhiskerGraph(value) {

  var test = []
  var getBoxwhiskerGraph1 = {};
      getBoxwhiskerGraph1.type        = "candlestick";
      getBoxwhiskerGraph1.balloonText = "e";
      getBoxwhiskerGraph1.highField   = value.highField;
      getBoxwhiskerGraph1.openField   = value.openField;
      getBoxwhiskerGraph1.closeField  = value.closeField;
      getBoxwhiskerGraph1.valueField  = value.closeField;
      getBoxwhiskerGraph1.lowField    = value.lowField; 
      getBoxwhiskerGraph1.fillColors  = "#ffffff";
      getBoxwhiskerGraph1.lineColor   = "#e50d0d";
      getBoxwhiskerGraph1.lineAlpha   = 1;
      getBoxwhiskerGraph1.fillAlphas  = 0.9;
      getBoxwhiskerGraph1.columnWidth = 0.4;
      getBoxwhiskerGraph1.id          = "chartdiv";
      test.push(boxWhiskerValueAxes);

  var getBoxwhiskerGraph2 = {};

      getBoxwhiskerGraph2.type        = "column";
      getBoxwhiskerGraph2.columnWidth   = "0.1";
      getBoxwhiskerGraph2.valueField    = value.highField;
      getBoxwhiskerGraph2.openField     = value.highField;
      getBoxwhiskerGraph2.lineColor     = "#e50d0d";
      getBoxwhiskerGraph2.lineThickness = 3;
      getBoxwhiskerGraph2.showBalloon   = false;
      getBoxwhiskerGraph2.clustered     = false;
      test.push(getBoxwhiskerGraph2);
 
  var getBoxwhiskerGraph3 = {};
      getBoxwhiskerGraph3.type           =  "column";
      getBoxwhiskerGraph3.columnWidth    =  "0.1";
      getBoxwhiskerGraph3.valueField     =  value.lowField;
      getBoxwhiskerGraph3.openField      =  value.lowField;
      getBoxwhiskerGraph3.lineColor      =  "#e50d0d";
      getBoxwhiskerGraph3.lineThickness  =  3;
      getBoxwhiskerGraph3.showBalloon    =  false;
      getBoxwhiskerGraph3.clustered      =  false;
      test.push(getBoxwhiskerGraph3);

  var getBoxwhiskerGraph4 = {};
      getBoxwhiskerGraph4.type           = "column";
      getBoxwhiskerGraph4.columnWidth    = "0.5";
      getBoxwhiskerGraph4.valueField     = value.midField;
      getBoxwhiskerGraph4.openField      = value.midField;
      getBoxwhiskerGraph4.lineColor      = "#e50d0d";
      getBoxwhiskerGraph4.lineThickness  = 3;
      getBoxwhiskerGraph4.showBalloon    = false;
      getBoxwhiskerGraph4.clustered      = false;

      test.push(getBoxwhiskerGraph4);

      return test;
}

function getBoxwhiskerplot(id, chartData, value) {
    $("#chartdiv"+id).css('width', '100%').css('height', '400px');
 var chart = AmCharts.makeChart('chartdiv'+id, {
                                "type": "serial",
                                "theme": "light",
                                "titles": [{
                                  "text": "",
                                  "size": 15
                                }],
                                "graphs": [{ 
                                  "type"        : "candlestick",
                                  "balloonText" :""+value.name+"\n High: [["+value.highField+"]]\n Open: [["+value.openField+"]]\n Mid: [["+value.midField+"]]\n Close: [["+value.closeField+"]]\nLow: [["+value.lowField+"]]",
                                  "highField"   : value.highField,
                                  "openField"   : value.openField,
                                  "closeField"  : value.closeField,
                                  "valueField"  : value.closeField,    
                                  "lowField"    : value.lowField,
                                  "fillColors"  : "#ffffff",
                                  "lineColor"   : "#e50d0d",
                                  "lineAlpha"   : 1,
                                  "fillAlphas"  : 0.9,
                                  "columnWidth" : 0.4,
                                  "id"          : "chartdiv",
                                },{
                                 "type"           : "column",
                                 "columnWidth"    : "0.1",
                                 "valueField"     : value.highField,
                                 "openField"      : value.highField,
                                 "lineColor"      : "#e50d0d",
                                 "lineThickness"  : 3,
                                 "showBalloon"    : false,
                                 "clustered"      : false,
                                 },{
                                 "type"           : "column",
                                 "columnWidth"    : "0.1",
                                 "valueField"     : value.lowField,
                                 "openField"      : value.lowField,
                                 "lineColor"      : "#e50d0d",
                                 "lineThickness"  : 3,
                                 "showBalloon"    : false,
                                 "clustered"      : false,
                                 },{
                                 "type"           : "column",
                                 "columnWidth"    : "0.5",
                                 "valueField"     : value.midField,
                                 "openField"      : value.midField,
                                 "lineColor"      : "#e50d0d",
                                 "lineThickness"  : 3,
                                 "showBalloon"    : false,
                                 "clustered"      : false,
                                },],
                      "chartCursor": BoxwhiskerchartCursor(),
                      "categoryField": "date",
                      "mouseWheelZoomEnabled":false,
                      "categoryAxis": boxWhiskerCategory(value.label),
                      "valueAxes": boxWhiskerValueAxes(value.name),
                      "chartScrollbar": BoxscrollBare(),
                      "dataProvider": chartData,
                      "export": {
                        "enabled": false
                      }
        });

      chart.addListener( "rendered", zoomChart);
      function zoomChart() {
        chart.zoomToIndexes( chart.dataProvider.length -50, chart.dataProvider.length - 1 );
      }
      zoomChart();

}

createChart();



</script>
@endsection