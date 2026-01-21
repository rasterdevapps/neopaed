<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />

		<!-- AmCharts includes -->
		<script src="http://www.amcharts.com/lib/3/amcharts.js"></script>
		<script src="http://www.amcharts.com/lib/3/xy.js"></script>

		

		<style>
			body, html {
				height: 100%;
				padding: 0;
				margin: 0;
				overflow: hidden;
				font-size: 11px;
				font-family: Verdana;
			}
			#chartdiv {
				width: 100%;
				height: 100%;
			}
		</style>

		<script type="text/javascript">
			var chart = AmCharts.makeChart( "chartdiv", {
				"type": "xy",
				"marginTop": 25,
				"startDuration": 1.5,
				"trendLines": [],
				"graphs": [ {
					"title": "round",
					"balloonText": "x:<b>[[x]]</b> y:<b>[[y]]</b><br>value:<b>[[value]]</b>",
					"id": "AmGraph-1",
					"bullet": "none",
				    "maxBulletSize": 1,
				    "lineAlpha": 0.8,
				    "lineThickness": 2,
				    "lineColor":"#FA2B2E",
					"minValue":1,
					"valueField": "value",
					"xField": "x",
					"yField": "y"
				},{
					"title": "round",
					"balloonText": "x:<b>[[x]]</b> y:<b>[[y]]</b><br>value:<b>[[value]]</b>",
					"id": "AmGraph-2",
					"bullet": "round",
				    "maxBulletSize": 10,
				    "lineAlpha": 0.8,
				    "lineThickness": 0,
				    "lineColor":"#141313",
					"minValue":1,
					"valueField": "value",
					"xField": "x1",
					"yField": "y1"
				}],
				"guides": [ {
					"fillAlpha": 0.3,
					"fillColor": "#ff8000",
					"id": "Guide-1",
					"toValue": 2,
					"value": 0,
					"valueAxis": "ValueAxis-2"
				} ],
				"valueAxes": [ {
					"id": "ValueAxis-1",
					"axisAlpha": 0,
					"max":10.5,
					"min":0.0,
					"minorGridEnabled":true,
				}, {
					"id": "ValueAxis-2",
					"axisAlpha": 0,
					"position": "bottom",
					"max":64,
					"min":27,
					"minorGridEnabled":true,
				} ],
				"allLabels": [],
				"balloon": {},
				"titles": [],
				"dataProvider": [ {
					"y": 0.45,
					"x": 27,
					"value": 1
				},{
					"y": 0.57,
					"x": 28,
					"value": 1
				},{
					"y": 0.70,
					"x": 29,
					"value": 1
				} ,{
					"y": 0.85,
					"x": 30,
					"value": 1
				} ,{
					"y": 1.00,
					"x": 31,
					"value": 1
				} ,{
					"y": 1.17,
					"x": 32,
					"value": 1
				},{
					"y": 1.51,
					"x": 34,
					"value": 1
				},{
					"y": 1.70,
					"x": 35,
					"value": 1
				},{
					"y": 1.88,
					"x": 36,
					"value": 1
				},{
					"y": 2.07,
					"x": 37,
					"value": 1
				},{
					"y": 2.26,
					"x": 38,
					"value": 1
				},{
					"y": 2.45,
					"x": 39,
					"value": 1
				},{
					"y": 2.64,
					"x": 40,
					"value": 1
				},{
					"y": 2.82,
					"x": 41,
					"value": 1
				},{
					"y": 3.01,
					"x": 42,
					"value": 1
				},{
					"y": 3.19,
					"x": 43,
					"value": 1
				},{
					"y": 3.37,
					"x": 44,
					"value": 1
				},{
					"y": 3.55,
					"x": 45,
					"value": 1
				},{
					"y": 3.72,
					"x": 46,
					"value": 1
				},{
					"y": 3.89,
					"x": 47,
					"value": 1
				},{
					"y": 4.06,
					"x": 48,
					"value": 1
				},{
					"y": 4.22,
					"x": 49,
					"value": 1
				},{
					"y": 4.37,
					"x": 50,
					"value": 1
				},{
					"y": 4.52,
					"x": 51,
					"value": 1
				},{
					"y": 4.67,
					"x": 52,
					"value": 1
				},{
					"y": 4.81,
					"x": 53,
					"value": 1
				},{
					"y": 4.95,
					"x": 54,
					"value": 1
				},{
					"y": 5.09,
					"x": 55,
					"value": 1
				},{
					"y": 5.22,
					"x": 56,
					"value": 1
				},{
					"y": 5.34,
					"x": 57,
					"value": 1
				},{
					"y": 5.47,
					"x": 58,
					"value": 1
				},{
					"y": 5.58,
					"x": 59,
					"value": 1
				},{
					"y": 5.70,
					"x": 60,
					"value": 1
				},{
					"y": 5.81,
					"x": 61,
					"value": 1
				},{
					"y": 5.92,
					"x": 62,
					"value": 1
				},{
					"y": 6.02,
					"x": 63,
					"value": 1
				},{
					"y": 6.12,
					"x": 64,
					"value": 1
				},{
					"y1": 5.81,
					"x1": 61,
					"value": 1
				}  ],
				"chartCursor": {},
				"legend": {
					"position": "bottom"
				}
			} );
		</script>
	</head>
	<body>
		<div id="chartdiv"></div>
	</body>
</html>