function BoxwhiskerchartCursorMini() {
    var chartCursor = {};
    chartCursor.enabled = false;
    chartCursor.pan = false;
    // chartCursor.valueLineEnabled = false;
    // chartCursor.valueLineBalloonEnabled = false;
    chartCursor.cursorAlpha = 1;
    chartCursor.cursorColor = "#258cbb";
    chartCursor.limitToGraph = "g1";
    chartCursor.valueLineAlpha = 0.2;
    chartCursor.valueZoomable = true;
    // chartCursor.oneBalloonOnly = false;
    return chartCursor;
}

function BoxwhiskerchartCursor() {
    var chartCursor = {};
    chartCursor.enabled = true;
    chartCursor.pan = false;
    // chartCursor.valueLineEnabled = false;
    // chartCursor.valueLineBalloonEnabled = false;
    // chartCursor.cursorAlpha = 0;
    chartCursor.cursorColor = "#258cbb";
    chartCursor.limitToGraph = "g1";
    chartCursor.valueLineAlpha = 0.2;
    chartCursor.valueZoomable = false;
    // chartCursor.oneBalloonOnly = true;
    chartCursor.leaveCursor = false;
    chartCursor.leaveAfterTouch = false;
    return chartCursor;
}

function BoxexportOptions(file_name = '') {
    var exportOptions = {}
    exportOptions.enabled = true;
    exportOptions.fileName = file_name;
    exportOptions.pageOrigin = false;
    return exportOptions;
}

function BoxscrollBare() {
    var scrollBare = {};
    scrollBare.autoGridCount = true;
    scrollBare.graph = "g1";
    scrollBare.scrollbarHeight = 40;
    scrollBare.oppositeAxis = false;
    scrollBare.offset = 75;
    scrollBare.backgroundAlpha = 1;
    scrollBare.backgroundColor = "#85c5e3";
    scrollBare.graphFillColor = "#85c5e3";
    scrollBare.color = "#85c5e3";
    scrollBare.selectedBackgroundColor = "#9cc580";
    scrollBare.selectedGraphFillColor = "#9cc580";
    scrollBare.graphFillAlpha = 1;
    scrollBare.fontSize = 0;
    return scrollBare;
}

function BoxscrollBarecompare() {
    var scrollBare = {};
    scrollBare.autoGridCount = true;
    scrollBare.graph = "g1";
    scrollBare.scrollbarHeight = 40;
    scrollBare.oppositeAxis = false;
    scrollBare.offset = 75;
    return scrollBare;
}

function boxWhiskerbox(valueField, lineColor, columnWidth, valueAxis) {
    var box = {};
    box.type = "column";
    box.columnWidth = columnWidth;
    box.valueField = valueField;
    box.openField = valueField;
    box.lineColor = lineColor;
    box.valueAxis = valueAxis;
    box.lineThickness = 3;
    box.showBalloon = false;
    box.clustered = false;
    //box.fillColorsR    = lineColor;
    return box;
}

function boxWhiskerboxCompare(valueField, lineColor, columnWidth, valueAxis) {
    var box = {};
    box.type = "column";
    box.columnWidth = columnWidth;
    box.valueField = valueField;
    box.openField = valueField;
    box.lineColor = lineColor;
    box.valueAxis = valueAxis;
    box.lineThickness = 3;
    box.showBalloon = false;
    box.clustered = false;
    //box.fillColorsR    = lineColor;
    return box;
}

function boxWhiskerboxMini(valueField, lineColor, columnWidth) {
    var box = {};
    box.type = "column";
    box.columnWidth = columnWidth;
    box.valueField = valueField;
    box.openField = valueField;
    box.lineColor = lineColor;
    box.lineThickness = 2;
    box.showBalloon = false;
    box.clustered = false;
    //box.fillColorsR    = lineColor;
    return box;
}

function boxWhiskergraphChart(high, open, mid, close, low, fillColors, lineColor, label, id) {
    var graphChart = {};
    graphChart.type = "candlestick";
    graphChart.balloonText = "" + label + "\n &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspMax: [[" + high + "]]\n Third Quartile: [[" + close + "]]\n &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspMedian: [[" + mid + "]]\n First Quartile: [[" + open + "]]\n&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspMin: [[" + low + "]]";
    graphChart.highField = high;
    graphChart.openField = open;
    graphChart.closeField = close;
    graphChart.valueField = close;
    graphChart.lowField = low;
    graphChart.fillColors = fillColors;
    graphChart.lineColor = lineColor;
    graphChart.lineAlpha = 1;
    graphChart.fillAlphas = 0.9;
    graphChart.columnWidth = 0.4;
    graphChart.id = id;
    return graphChart;
}

function boxWhiskergraphChartCompare(high, open, mid, close, low, fillColors, lineColor, label, id, valueAxis) {
    var graphChart = {};
    graphChart.type = "candlestick";
    graphChart.balloonText = "" + label + "\n &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspMax: [[" + high + "]]\n Third Quartile: [[" + open + "]]\n &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspMedian: [[" + mid + "]]\n First Quartile: [[" + close + "]]\n&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspMin: [[" + low + "]]";
    graphChart.highField = high;
    graphChart.openField = open;
    graphChart.closeField = close;
    graphChart.valueField = close;
    graphChart.lowField = low;
    graphChart.fillColors = fillColors;
    graphChart.lineColor = lineColor;
    graphChart.lineAlpha = 1;
    graphChart.fillAlphas = 0.9;
    graphChart.columnWidth = 0.4;
    graphChart.valueAxis = valueAxis;
    graphChart.id = id;
    return graphChart;
}

function boxWhiskergraphChartMini(high, open, mid, close, low, fillColors, lineColor, label, id) {
    var graphChart = {};
    graphChart.type = "candlestick";
    //  graphChart.balloonText  = ""+label+"\n High: [["+high+"]]\n Open: [["+open+"]]\n Mid: [["+mid+"]]\n Close: [["+close+"]]\nLow: [["+low+"]]";
    graphChart.highField = high;
    graphChart.openField = open;
    graphChart.closeField = close;
    graphChart.valueField = close;
    graphChart.lowField = low;
    graphChart.fillColors = fillColors;
    graphChart.lineColor = lineColor;
    graphChart.lineAlpha = 1;
    graphChart.fillAlphas = 0.5;
    graphChart.columnWidth = 0.2;
    graphChart.id = id;
    return graphChart;
}

function boxEventProperties(id, bulletType, bulletBorder, bulletColor, bulletSize, hideBulletsCount, lineThickness, title, bulletLine, valueField, date, balloonProperty, label) {

    var properties = {};
    properties.id = id;
    properties.balloon = balloonProperty;
    properties.bullet = "none";
    properties.bulletBorderAlpha = bulletBorder;
    properties.bulletColor = bulletColor;
    properties.bulletSize = bulletSize;
    properties.lineThickness = lineThickness;
    properties.type = "smoothedLine";
    properties.title = title;
    properties.useLineColorForBulletBorder = bulletLine;
    properties.valueField = valueField;
    properties.showBalloon = false;
    properties.customBulletField = "bullet";
    properties.bulletOffset = -150;
    properties.balloonText = "<span class='font-size-13'>[[" + date + "]] \n <b style='color: #FDA510;'>Event(s):</b> [[event]]</span>";

    properties.labelFunction = function(data) {
        return console.log(data);
    };
    return properties;
}

function boxLineChartGraphBalloon() {
    var graphsBalloon = {};
    graphsBalloon.color = "#000000";
    graphsBalloon.borderColor = "#FDA510";
    graphsBalloon.fillColor = "#FFFFFF";
    graphsBalloon.fillAlpha = 1;
    return graphsBalloon;
}
function boxWhiskergraph(mid_value, color_code, title) {

    var boxWhiskergraph = [];

    var high_value = mid_value.replace('mid', 'high');
    var low_value = mid_value.replace('mid', 'low');
    var open_value = mid_value.replace('mid', 'open');
    var close_value = mid_value.replace('mid', 'close');
    var lineone = 0.2;
    var linetwo = 0.2;
    var linethree = 0.4;
    var property_id = 1;
    var fillColors = '#FFFFFF';

    boxWhiskergraph.push(boxWhiskergraphChart(high_value, open_value, mid_value, close_value, low_value, fillColors, color_code, title, property_id));
    boxWhiskergraph.push(boxWhiskerbox(high_value, color_code, lineone));
    boxWhiskergraph.push(boxWhiskerbox(low_value, color_code, linetwo));
    boxWhiskergraph.push(boxWhiskerbox(mid_value, color_code, linethree));

    var balloonProperty = boxLineChartGraphBalloon();
    var propertiesTwo = boxEventProperties("ge" + property_id, "round", 1, "#B0DE09", 10, 50, 0, "Event", false, "event_option", "date", balloonProperty, title);

    boxWhiskergraph.push(propertiesTwo);

    return boxWhiskergraph;
}

// function boxWhiskergraphcompare(parameters, chartproperty) {
//     var boxWhiskergraph = [];
//     var boxWhiskerProperties = chartproperty;
//     $.each(parameters, function(index, value) {
//         $.each(boxWhiskerProperties, function(propertyIndex, propertyValue) {
//             if (value == propertyValue.coreName) {
//                 var valueAxis = (propertyValue.coreName == 't1_t2') ? "v2" : "v1";
//                 boxWhiskergraph.push(boxWhiskergraphChartCompare(propertyValue.high, propertyValue.open, propertyValue.mid, propertyValue.close, propertyValue.low, propertyValue.fillColors, propertyValue.lineColors, propertyValue.label, propertyValue.id, valueAxis));
//                 boxWhiskergraph.push(boxWhiskerboxCompare(propertyValue.high, propertyValue.lineColors, propertyValue.lineone, valueAxis));
//                 boxWhiskergraph.push(boxWhiskerboxCompare(propertyValue.low, propertyValue.lineColors, propertyValue.linetwo, valueAxis));
//                 boxWhiskergraph.push(boxWhiskerboxCompare(propertyValue.mid, propertyValue.lineColors, propertyValue.linethere, valueAxis));
//             }
//         });
//     });
//     return boxWhiskergraph;
// }

function boxWhiskergraphMini(color_code, mid_value, labelNumber, title) {

    var boxWhiskergraph = [];

    var high_value = mid_value.replace('mid', 'high');
    var low_value = mid_value.replace('mid', 'low');
    var open_value = mid_value.replace('mid', 'open');
    var close_value = mid_value.replace('mid', 'close');
    var lineone = 0.2;
    var linetwo = 0.2;
    var linethree = 0.4;
    var fillColors = '#FFFFFF';

    var boxWhiskergraph = [];

    boxWhiskergraph.push(boxWhiskergraphChartMini(high_value, open_value, mid_value, close_value, low_value, fillColors, color_code, title, labelNumber));
    boxWhiskergraph.push(boxWhiskerboxMini(high_value, color_code, lineone));
    boxWhiskergraph.push(boxWhiskerboxMini(low_value, color_code, linetwo));
    boxWhiskergraph.push(boxWhiskerboxMini(mid_value, color_code, linethree));

    return boxWhiskergraph;
}

function boxWhiskerCategory() {
    var boxWhiskerCategory = {};
    boxWhiskerCategory.title = "Time";
    boxWhiskerCategory.gridPosition = "start";
    boxWhiskerCategory.tickPosition = "start";
    boxWhiskerCategory.tickLength = 1;
    boxWhiskerCategory.axisAlpha = 0.7;
    boxWhiskerCategory.gridAlpha = 0;
    boxWhiskerCategory.centerRotatedLabels = false;
    boxWhiskerCategory.labelRotation = 45;
    return boxWhiskerCategory;
}

function boxWhiskerCategorycompare() {
    var boxWhiskerCategory = {};
    boxWhiskerCategory.title = "Time";
    boxWhiskerCategory.gridPosition = "start";
    boxWhiskerCategory.tickPosition = "start";
    boxWhiskerCategory.tickLength = 1;
    boxWhiskerCategory.axisAlpha = 0.7;
    boxWhiskerCategory.gridAlpha = 0;
    boxWhiskerCategory.centerRotatedLabels = true;
    boxWhiskerCategory.labelRotation = 45;
    return boxWhiskerCategory;
}

function boxWhiskerCategoryMini() {
    var boxWhiskerCategory = {};
    boxWhiskerCategory.title = "Time";
    boxWhiskerCategory.gridPosition = "start";
    boxWhiskerCategory.tickPosition = "start";
    boxWhiskerCategory.tickLength = 1;
    boxWhiskerCategory.axisAlpha = 0.7;
    boxWhiskerCategory.gridAlpha = 0;
    boxWhiskerCategory.labelsEnabled = false;
    // boxWhiskerCategory.centerRotatedLabels = true;
    // boxWhiskerCategory.labelRotation = 45;
    return boxWhiskerCategory;
}

function boxWhiskerValueAxes(title) {
    var boxWhiskerValueAxesmaster = [];
    var boxWhiskerValueAxes = {};
    boxWhiskerValueAxes.id = "v1";
    // boxWhiskerValueAxes.maximum = 100;
    // boxWhiskerValueAxes.minimum = 10;
    boxWhiskerValueAxes.position = "left";
    boxWhiskerValueAxes.title = title;
    // boxWhiskerValueAxes.fontSize = 5;
    boxWhiskerValueAxes.axisAlpha = 0;
    boxWhiskerValueAxes.autoGridCount = true;
    boxWhiskerValueAxes.minorGridAlpha = 0.01;
    boxWhiskerValueAxes.minMaxMultiplier = 1;
    boxWhiskerValueAxesmaster.push(boxWhiskerValueAxes);
    return boxWhiskerValueAxesmaster;
}

function boxWhiskerValueAxescompare(title) {
    var boxWhiskerValueAxesmaster = [];
    var boxWhiskerValueAxes = {};
    boxWhiskerValueAxes.id = "v1";
    // boxWhiskerValueAxes.maximum = 100;
    // boxWhiskerValueAxes.minimum = 10;
    boxWhiskerValueAxes.position = "left";
    boxWhiskerValueAxes.title = title;
    boxWhiskerValueAxes.axisAlpha = 0;
    boxWhiskerValueAxes.autoGridCount = true;
    // boxWhiskerValueAxes.gridCount = 100;
    // boxWhiskerValueAxes.minorGridAlpha =0.01;
    // boxWhiskerValueAxes.minMaxMultiplier = 1;
    boxWhiskerValueAxesmaster.push(boxWhiskerValueAxes);
    var boxWhiskerValueAxes1 = {};
    boxWhiskerValueAxes1.id = "v2";
    // boxWhiskerValueAxes.maximum = 0;
    // boxWhiskerValueAxes.minimum = -10;
    boxWhiskerValueAxes1.position = "right";
    boxWhiskerValueAxes1.title = title;
    boxWhiskerValueAxes1.axisAlpha = 0;
    boxWhiskerValueAxes.autoGridCount = true;
    // boxWhiskerValueAxes1.gridCount = 100;
    // boxWhiskerValueAxes1.minorGridAlpha =0.01;
    // boxWhiskerValueAxes1.minMaxMultiplier = 1;
    boxWhiskerValueAxesmaster.push(boxWhiskerValueAxes1);
    return boxWhiskerValueAxesmaster;
}

function boxWhiskerValueAxesMini(title) {
    var boxWhiskerValueAxesmaster = [];
    var boxWhiskerValueAxes = {};
    boxWhiskerValueAxes.position = "left";
    boxWhiskerValueAxes.title = title;
    boxWhiskerValueAxes.axisAlpha = 0;
    boxWhiskerValueAxes.autoGridCount = true;
    boxWhiskerValueAxes.fontSize = 5;
    //  boxWhiskerValueAxes.gridCount = 100;
    boxWhiskerValueAxes.minorGridAlpha = 0.01;
    boxWhiskerValueAxesmaster.push(boxWhiskerValueAxes);
    return boxWhiskerValueAxesmaster;
}

function intiateBoxwhisker(data, id, title, zoomPosition, selectedDate, color_code, mid_value) {

    var file_name = $('input[name="file_name"]').val() + " " + title;
    var chart = AmCharts.makeChart(id, {
        "type": "serial",
        "theme": "light",
        "titles": [{
            "text": "",
            "size": 15
        }],
        "graphs": boxWhiskergraph(mid_value, color_code, title),
        "chartCursor": BoxwhiskerchartCursor(),
        "categoryField": "date",
        "categoryAxis": boxWhiskerCategory(),
        "valueAxes": boxWhiskerValueAxes(title),
        "chartScrollbar": BoxscrollBare(),
        "dataProvider": data,
        // "export": {
        //     "enabled": false
        // },
        "export": BoxexportOptions(file_name),
        "periodSelector": {
            "periods": [{
                "period": "hh",
                "count": 1,
                "label": "1 H",
                "selected": true
            }, {
                "period": "hh",
                "count": 8,
                "label": "8 H"
            }, {
                "period": "DD",
                "count": 1,
                "label": "1 D"
            }, {
                "period": "DD",
                "count": 10,
                "label": "10 D"
            }, {
                "period": "MM",
                "selected": true,
                "count": 1,
                "label": "1 M"
            }, {
                "period": "YYYY",
                "count": 1,
                "label": "1 Y"
            }, {
                "period": "YTD",
                "label": "YTD"
            }, {
                "period": "MAX",
                "label": "MAX"
            }],
        },
    });

    $('input[name="event"]').click(function() {
        var lineJoinstatus = $(this).is(":checked");
        if (lineJoinstatus) {
            chart.graphs[4].bullet = "round";
            chart.graphs[4].bulletOffset = 0;
            chart.graphs[4].showBalloon = true;
            $('input[name="pointer"][value="on"]').prop('checked', true).trigger('click');
        } else {
            chart.graphs[4].bullet = "none";
            chart.graphs[4].bulletOffset = -150;
            chart.graphs[4].showBalloon = false;
        }
        chart.validateNow();
    });

    var value = $('input[name="pointer"]:checked').val();
    pointerEnable(chart, value);
    $('.filterValuesByDates').change(function() {
        zoomChart($(this).val());
    });
    $('input[name="pointer"], input[name="line_pointer_vendilator"]').click(function() {
        var value = $(this).val();
        pointerEnable(chart, value);
    });
    // chart.addListener("filtered", filterChartData);
    // chart.addListener("rendered", zoomChart);
    var selected_date = getDateFormat(selectedDate);
    var selected_date_start = selected_date + ' 00:00';
    var selected_date_end = selected_date + ' 23:00';
    chart.zoomToCategoryValues(selected_date_start, selected_date_end);

    function zoomChart(position_value) {
        // if (position_value == 'all') {
        //     chart.zoomOut();
        // } else {
        //     var last_value_of_data = chart.dataProvider[chart.dataProvider.length - 1];
        //     if (last_value_of_data.tempDate === undefined) {
        //         last_value_of_data = chart.dataProvider[chart.dataProvider.length - 2];
        //     }
        //     var last_date = getDateReformat(last_value_of_data.tempDate);
        //     var end_date = getDateFormat(last_date) + ' 23:00';
        //     var chart_start_date = getDateReformat(last_value_of_data.tempDate);
        //     chart_start_date.setDate(chart_start_date.getDate() - parseInt(position_value));
        //     var start_date = getDateFormat(chart_start_date) + ' 00:00';
        //     chart.zoomToCategoryValues(start_date, end_date);
        // }
        if (position_value == 'all') {
            chart.zoomOut();
        } else {
            var last_value_of_data = chart.dataProvider[chart.dataProvider.length - 1];
            if (last_value_of_data.tempDate === undefined) {
                last_value_of_data = chart.dataProvider[chart.dataProvider.length - 2];
            }
            var last_date = getDateReformat(last_value_of_data.tempDate);
            var chart_start_date = getDateReformat(last_value_of_data.tempDate);
            chart_start_date.setDate(chart_start_date.getDate() - parseInt(position_value));
            if (last_value_of_data.date.length <= 15) {
                var end_date = getDateFormat(last_date) + ' 23:00';
                var start_date = getDateFormat(chart_start_date) + ' 00:00';
            }
            else
            {
                var end_date = getDateFormat(last_date) + ' ' + getDateFormat(last_date) + ' 23:00';
                var start_date = getDateFormat(chart_start_date) + ' ' + getDateFormat(chart_start_date) + ' 00:00';
            }
            chart.zoomToCategoryValues(start_date, end_date);
        }
    }
    zoomedChart();

    function zoomedChart(e) {
        if (typeof e != 'undefined') {
            if (data[e.chart.startIndex].tempDate == data[e.chart.endIndex].tempDate) {
                chart.categoryAxis.title = data[e.chart.startIndex].tempDate;
            } else {
                if (data[e.chart.endIndex].tempDate != 'undefined') {
                    if (typeof data[e.chart.endIndex].tempDate != 'undefined') {
                        chart.categoryAxis.title = data[e.chart.startIndex].tempDate + ' - ' + data[e.chart.endIndex].tempDate;
                    } else {
                        chart.categoryAxis.title = data[e.chart.startIndex].tempDate
                    }
                }
            }
        }
    }
}

function pointerEnable(chart, value) {
    if (value == 'off') {
        chart.chartCursor.enabled = false;
    }
    if (value == 'on') {
        chart.chartCursor.enabled = true;
    }
}

function getDateFormat(date) {
    date = new Date(date);
    var month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    var selected_month = month[date.getMonth()];
    var selected_date = ("0" + date.getDate()).slice(-2);
    var selected_year = date.getFullYear().toString().substr(-2);
    return selected_date + '-' + selected_month + '-' + selected_year;
}

function getDateReformat(date) {
    var month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    var splitted_date = date.split('-');
    var selected_date = splitted_date[0];
    var selected_month = '';
    var current_year = new Date().getFullYear().toString().substring(0, 2);
    for (var i = 0; i < month.length; i++) {
        if (month[i] == splitted_date[1]) {
            selected_month = i + 1;
        }
    }
    return new Date(current_year + splitted_date[2] + '-' + selected_month + '-' + selected_date + ' 00:00:00');
}

function intiateBoxwhiskercompare(data, parameters, chartproperty, id, title) {
    var file_name = $('input[name="file_name"]').val() + " " + title;
    var chart = AmCharts.makeChart(id, {
        "type": "serial",
        "theme": "light",
        "titles": [{
            "text": "",
            "size": 15
        }],
        "graphs": boxWhiskergraphcompare(parameters, chartproperty),
        "chartCursor": BoxwhiskerchartCursor(),
        "categoryField": "date",
        "categoryAxis": boxWhiskerCategorycompare(),
        "valueAxes": boxWhiskerValueAxescompare(title),
        "chartScrollbar": BoxscrollBarecompare(),
        "dataProvider": data,
        "export": BoxexportOptions(file_name),
        "periodSelector": {
            "fromText": "",
            "toText": "",
            "periodsText": "",
            "position": "top",
            "dateFormat": "YYYY-MM-DD JJ:NN",
            "inputFieldWidth": 150,
            "periods": [{
                "period": "hh",
                "count": 1,
                "label": "1 H",
                "selected": true
            }, {
                "period": "hh",
                "count": 8,
                "label": "8 H"
            }, {
                "period": "DD",
                "count": 1,
                "label": "1 D"
            }, {
                "period": "DD",
                "count": 10,
                "label": "10 D"
            }, {
                "period": "MM",
                "selected": true,
                "count": 1,
                "label": "1 M"
            }, {
                "period": "YYYY",
                "count": 1,
                "label": "1 Y"
            }, {
                "period": "YTD",
                "label": "YTD"
            }, {
                "period": "MAX",
                "label": "MAX"
            }]
        },
    });
    chart.addListener("rendered", zoomChart);
    zoomChart();
    // function zoomChart() {
    //     chart.zoomToIndexes( chart.dataProvider.length - 50, chart.dataProvider.length - 1 );
    // }
}

function intiateBoxwhiskerMini(data, id, title, color_code, plotting_value_name, labelNumber) {
    var file_name = $('input[name="file_name"]').val() + " " + title;
    var chart = AmCharts.makeChart(id, {
        "type": "serial",
        "theme": "light",
        "titles": [{
            "text": "",
            "size": 5
        }],
        "graphs": boxWhiskergraphMini(color_code, plotting_value_name, labelNumber, title),
        "chartCursor": BoxwhiskerchartCursorMini(),
        "categoryField": "date",
        "categoryAxis": boxWhiskerCategoryMini(),
        "valueAxes": boxWhiskerValueAxesMini(title),
        "dataProvider": data,
        "export": BoxexportOptions(file_name),
        "periodSelector": {
            "fromText": "",
            "toText": "",
            "periodsText": "",
            "position": "top",
            "dateFormat": "YYYY-MM-DD JJ:NN",
            "inputFieldWidth": 150,
            "periods": [{
                "period": "hh",
                "count": 1,
                "label": "1 H",
                "selected": true
            }, {
                "period": "hh",
                "count": 8,
                "label": "8 H"
            }, {
                "period": "DD",
                "count": 1,
                "label": "1 D"
            }, {
                "period": "DD",
                "count": 10,
                "label": "10 D"
            }, {
                "period": "MM",
                "selected": true,
                "count": 1,
                "label": "1 M"
            }, {
                "period": "YYYY",
                "count": 1,
                "label": "1 Y"
            }, {
                "period": "YTD",
                "label": "YTD"
            }, {
                "period": "MAX",
                "label": "MAX"
            }],
        },
    });
    chart.addListener("rendered", zoomChart);
    zoomChart();

    function zoomChart() {
        chart.zoomToIndexes(chart.dataProvider.length - 50, chart.dataProvider.length - 1);
    }
}
