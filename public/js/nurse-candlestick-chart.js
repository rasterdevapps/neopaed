
function candleChartgraph(id, open, high, low, close, fillColors, lineColor, title) {
  var candlestickgraph = {};
      candlestickgraph.id                 = id;
      candlestickgraph.proCandlesticks    = true;
      candlestickgraph.balloonText        = "<b>"+title+"</b><br>Open:<b>[["+open+"]]</b><br>High:<b>[["+high+"]]</b><br>Low:<b>[["+low+"]]</b><br>Close:<b>[["+close+"]]</b><br>";
      candlestickgraph.closeField         = close;
      candlestickgraph.fillColors         = fillColors;
      candlestickgraph.highField          = high;
      candlestickgraph.lineColor          = lineColor;
      candlestickgraph.lineAlpha          = 1;
      candlestickgraph.lowField           = low;
      candlestickgraph.fillAlphas         = 1;
      candlestickgraph.negativeFillColors = "#db4c3c";
      candlestickgraph.negativeLineColor  = "#db4c3c";
      candlestickgraph.openField          = open;
      candlestickgraph.title              = title;
      candlestickgraph.type               = "candlestick";
      candlestickgraph.valueField         = close;
   return candlestickgraph;
}


function candleChartgraphdataSet(parameters, chartproperty) {

  var candlestickgraphDataset =[];
  var candlestickgraph = chartproperty;

  $.each(parameters, function(index, value) {
  	  $.each(candlestickgraph, function(propertyIndex, propertyValue) {
  	  	  if (value == propertyValue.coreName) {
  			var graphSet = candleChartgraph(propertyValue.id, propertyValue.open, propertyValue.high, propertyValue.low, propertyValue.close, propertyValue.fillColor, propertyValue.lineColor, propertyValue.title);
                candlestickgraphDataset.push(graphSet);
  	  	  }
  	  });
  });
    
   return candlestickgraphDataset;
}

function candleChartcursor() {
	var chartCursor = {};
        chartCursor.valueLineEnabled        = true;
        chartCursor.valueLineBalloonEnabled = true;	
    return chartCursor;	

}

function candleChartscrollbar() {
    var chartscrollbar = {};
		chartscrollbar.graph = "g1";
		chartscrollbar.graphType = "line";
		chartscrollbar.scrollbarHeight = 30;
		chartscrollbar.position = "bottom";
		chartscrollbar.oppositeAxis = false;
		chartscrollbar.offset = 35;
 return chartscrollbar;   	   	
}
function candleExportOptions() {
  var exportOptions = {}
  exportOptions.enabled = false;  
   return exportOptions; 
}

function intiateCandlesticksChart(data, parameters, chartproperty, id) {

  var chart = AmCharts.makeChart( id, {
      "type": "serial",
      "theme": "none",
      "dataDateFormat":"YYYY-MM-DD",
      "valueAxes": [ {
        "position": "left",
        "dashLength": 1
      } ],
      "graphs": candleChartgraphdataSet(parameters, chartproperty),
      "chartScrollbar": candleChartscrollbar(),
      "chartCursor": candleChartcursor(),
      "categoryField": "date",
      "categoryAxis": {
        "parseDates": false,
        "dashLength": 1,
        "labelRotation":40
      },
      "dataProvider":data,
      "export": candleExportOptions(),
      
    
    } );
  
    chart.addListener( "rendered", zoomChart );
    zoomChart();

    function zoomChart() {
      chart.zoomToIndexes( chart.dataProvider.length - 50, chart.dataProvider.length - 1 );
    }

}
