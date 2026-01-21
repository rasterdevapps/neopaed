function LineChartvalueAxis(label, parameter) {
    var valueAxis = {};
    valueAxis.id = "v1";
    valueAxis.axisAlpha = 0;
    valueAxis.autoGridCount = false;
    valueAxis.position = "left";
    valueAxis.ignoreAxisWidth = true;
    valueAxis.fontSize = 10;
    valueAxis.title = label;
    // // console.log(label);
    // if (label == 'IT(S)') {
    //     valueAxis.min = 0.1;
    //     valueAxis.max = 1;
    //     valueAxis.includeAllValues = true;
    //     valueAxis.strictMinMax = true;
    //     valueAxis.labelFrequency = 0.1;
    //     valueAxis.minMaxMultiplier = 0.1
    // }
    return valueAxis;
}

function LineChartvalueAxisMini(label) {
    var valueAxis = {};
    valueAxis.id = "v1";
    valueAxis.axisAlpha = 0;
    valueAxis.position = "left";
    valueAxis.ignoreAxisWidth = true;
    valueAxis.fontSize = 5;
    valueAxis.title = label;
    return valueAxis;
}

function LineChartballoon() {
    var balloon = {};
    balloon.borderThickness = 1;
    balloon.fillAlpha = 1;
    balloon.borderAlpha = 1;
    balloon.shadowAlpha = 0.5;
    balloon.fixedPosition = false;
    balloon.follow = true;
    return balloon;
}

function LineChartballoonMini() {
    var balloon = {};
    balloon.borderThickness = 0;
    balloon.fillAlpha = 0;
    balloon.borderAlpha = 0;
    balloon.shadowAlpha = 0;
    balloon.fixedPosition = false;
    balloon.follow = false;
    return balloon;
}

function LineChartGraphBalloon(drop, adjustBorderColor, BorderColor, fillColor) {
    var graphsBalloon = {};
    // graphsBalloon.drop = drop;
    graphsBalloon.adjustBorderColor = adjustBorderColor;
    graphsBalloon.color = BorderColor;
    graphsBalloon.fillColor = fillColor;
    // graphsBalloon.drop = true;
    return graphsBalloon;
}

function lineChartGraphBalloon() {
    var graphsBalloon = {};
    graphsBalloon.color = "#000000";
    graphsBalloon.borderColor = "#FDA510";
    graphsBalloon.fillColor = "#FFFFFF";
    graphsBalloon.fillAlpha = 1;
    return graphsBalloon;
}

function LineChartGraphBalloonMini(drop, adjustBorderColor, BorderColor, fillColor) {
    var graphsBalloon = {};
    graphsBalloon.drop = drop;
    graphsBalloon.adjustBorderColor = adjustBorderColor;
    graphsBalloon.color = BorderColor;
    graphsBalloon.fillColor = fillColor;
    graphsBalloon.drop = true;
    return graphsBalloon;
}

function LinegraphProperties(id, bulletType, bulletBorder, bulletColor, bulletSize, hideBulletsCount, lineThickness, title, bulletLine, valueField, date, balloonProperty, label) {
    var properties = {};
    properties.id = id;
    // properties.balloon = balloonProperty;
    properties.bullet = bulletType;
    properties.bulletBorderAlpha = bulletBorder;
    properties.bulletColor = bulletColor;
    properties.bulletSize = bulletSize;
    // properties.hideBulletsCount = hideBulletsCount;
    properties.lineThickness = lineThickness;
    properties.type = "smoothedLine";
    properties.title = title;
    properties.useLineColorForBulletBorder = bulletLine;
    properties.valueField = valueField;
    properties.balloonText = "<span class='font-size-13'>[[" + date + "]] \n " + label + ": [[" + valueField + "]]</span>";

    properties.labelFunction = function(data) {
        return console.log(data);
    };
    return properties;
}

function eventProperties(id, bulletType, bulletBorder, bulletColor, bulletSize, hideBulletsCount, lineThickness, title, bulletLine, valueField, date, balloonProperty, label) {

    var properties = {};
    properties.id = id;
    // properties.balloon = balloonProperty;
    properties.bullet = "none";
    properties.bulletBorderAlpha = bulletBorder;
    properties.bulletColor = bulletColor;
    properties.bulletSize = bulletSize;
    // properties.hideBulletsCount = hideBulletsCount;
    properties.lineThickness = lineThickness;
    // properties.lineColor = "#e1ede9";
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

function formatedValues(data) {
    // console.log(data);
}

function LinegraphPropertiesMini(id, bulletType, bulletBorder, bulletColor, bulletSize, hideBulletsCount, lineThickness, title, bulletLine, valueField, date, balloonProperty, label) {
    var properties = {};
    properties.id = id;
    balloonProperty.enabled = false;
    properties.balloon = balloonProperty;
    properties.bullet = bulletType;
    properties.bulletBorderAlpha = bulletBorder;
    properties.bulletColor = bulletColor;
    properties.bulletSize = bulletSize;
    properties.hideBulletsCount = hideBulletsCount;
    properties.lineThickness = lineThickness;
    properties.title = title;
    properties.useLineColorForBulletBorder = bulletLine;
    properties.valueField = valueField;
    //properties.balloonText = "<span style='font-size:13px;'>[["+date+"]] \n "+label+": [["+valueField+"]]</span>";
    return properties;
}

function LinegraphPropertiesSet(color_code, label, mid_value, temp_line) {
    var propertiesSet = [];
    var i = 1;
    var balloonProperty = LineChartGraphBalloon(true, true, color_code, color_code);
    var propertiesOne = LinegraphProperties("g" + i, "round", 1, color_code, 8, 50, 0, "red line", false, 
        mid_value, "date", balloonProperty, label);

    var balloonProperty = lineChartGraphBalloon();
    var propertiesTwo = eventProperties("ge" + i, "round", 1, color_code, 10, 50, 0, "Event", false, "event_option", "date", balloonProperty, label);

    propertiesSet.push(propertiesOne);
    propertiesSet.push(propertiesTwo);

    return propertiesSet;
}

function LinegraphPropertiesSetMini(color_code, label, plotting_value_name, index, temp_line) {

    var propertiesSet = [];
    var balloonProperty = LineChartGraphBalloonMini(true, true, color_code, color_code);
    var propertiesOne = LinegraphPropertiesMini("g" + index, "round", 1, color_code, 8, 50, 0, "red line", false, plotting_value_name, "date", balloonProperty, label);
    propertiesSet.push(propertiesOne);
    return propertiesSet;
}

function LinechartCursor() {
    var chartCursor = {};
    chartCursor.pan = true;
    // chartCursor.valueLineEnabled = true;
    // chartCursor.valueLineBalloonEnabled = true;
    chartCursor.cursorAlpha = 1;
    chartCursor.cursorColor = "#258cbb";
    // chartCursor.limitToGraph = "g1";
    chartCursor.valueLineAlpha = 0.2;
    chartCursor.valueZoomable = true;
    // chartCursor.oneBalloonOnly = true;
    return chartCursor;
}

function LinechartCursorMini() {
    var chartCursor = {};
    chartCursor.enabled = false;
    chartCursor.pan = false;
    chartCursor.valueLineEnabled = false;
    chartCursor.valueLineBalloonEnabled = false;
    chartCursor.cursorAlpha = 1;
    chartCursor.cursorColor = "#258cbb";
    // chartCursor.limitToGraph = "g1";
    chartCursor.valueLineAlpha = 0.2;
    chartCursor.valueZoomable = true;
    chartCursor.oneBalloonOnly = false;
    return chartCursor;
}

function LinescrollBare() {
    var scrollBare = {};
    scrollBare.autoGridCount = true;
    scrollBare.graph = "g1";
    scrollBare.scrollbarHeight = 40;
    scrollBare.oppositeAxis = false;
    scrollBare.offset = 75;
    //scroll bar color 
    scrollBare.backgroundColor = "#85c5e3";
    scrollBare.graphFillColor = "#85c5e3";
    scrollBare.color = "#85c5e3";
    scrollBare.selectedBackgroundColor = "#9cc580";
    scrollBare.selectedGraphFillColor = "#9cc580";
    scrollBare.fontSize = 0;
    return scrollBare;
}

function LinescrollBareMini() {
    var scrollBare = {};
    scrollBare.autoGridCount = true;
    scrollBare.graph = "g1";
    scrollBare.scrollbarHeight = 40;
    scrollBare.oppositeAxis = false;
    scrollBare.enabled = false;
    scrollBare.offset = 75;
    return scrollBare;
}

function valueScrollbar() {
    var valueScrollbar = {};
    valueScrollbar.oppositeAxis = false;
    valueScrollbar.offset = 50;
    valueScrollbar.scrollbarHeight = 10;
    valueScrollbar.enabled = false;
    return valueScrollbar;
}

function valueScrollbarMini() {
    var valueScrollbar = {};
    valueScrollbar.oppositeAxis = false;
    valueScrollbar.offset = 50;
    valueScrollbar.scrollbarHeight = 10;
    valueScrollbar.enabled = false;
    return valueScrollbar;
}

function LinecategoryAxis() {
    var categoryAxis = {};
    categoryAxis.parseDates = false;
    categoryAxis.dashLength = 1;
    categoryAxis.minorGridEnabled = false;
    categoryAxis.dateFormats = "DD-MM-YYYY HH:NN";
    categoryAxis.labelRotation = 45;
    categoryAxis.fontSize = 10;
    return categoryAxis;
}

function LinecategoryAxisMini() {
    var categoryAxis = {};
    categoryAxis.title = "Time";
    categoryAxis.parseDates = false;
    categoryAxis.dashLength = 0;
    categoryAxis.axisAlpha = 0.7;
    categoryAxis.minorGridEnabled = false;
    categoryAxis.dateFormats = "DD-MM-YYYY HH:NN";
    categoryAxis.labelsEnabled = false;
    return categoryAxis;
}

function exportOptions(file_name = '') {
    var exportOptions = {}
    exportOptions.enabled = true;
    exportOptions.fileName = file_name;
    exportOptions.pageOrigin = false;
    return exportOptions;
}

function linepointerEnable(chart, value) {
    if (value == 'off') {
        chart.chartCursor.enabled = false;
    }
    if (value == 'on') {
        chart.chartCursor.enabled = true;
    }
}

function translateData(data) {
    var newData = [],
    dates = [];
    data.map(function(item) {
        var index = dates.indexOf(item.date);
        if (index > -1) {
            newData[index].value += item.value;
        } else {
            newData.push(item);
            dates.push(item.date);
        }
    });
    return newData;
}

function intiateLineChart(data, id, label, zoomPosition, selectedDate, events = null, color_code, mid_value, temp_line = false) {

    var file_name = $('input[name="file_name"]').val() + " " + label;
    var chart = AmCharts.makeChart(id, {
        "type": "serial",
        "theme": "none",
        "marginRight": 40,
        "marginLeft": 60,
        "autoMarginOffset": 20,
        "mouseWheelZoomEnabled": false,
        "dataDateFormat": "HH:NN",
        "valueAxes": [LineChartvalueAxis(label)],
        "balloon": LineChartballoon(),
        "graphs": LinegraphPropertiesSet(color_code, label, mid_value, temp_line),
        "chartScrollbar": LinescrollBare(),
        "chartCursor": LinechartCursor(),
        "valueScrollbar": valueScrollbar(),
        "categoryField": "date",
        "categoryAxis": LinecategoryAxis(),
        "export": exportOptions(file_name),
        "dataProvider": translateData(data),
        // "guides": eventsGenerator(events),
    });
    var pointerStatus = $('input[name="pointer"]:checked').val();
    linepointerEnable(chart, pointerStatus);
    $('input[name="event"]').click(function() {

        var lineJoinstatus = $(this).is(":checked");
        if (lineJoinstatus) {
            chart.graphs[1].bullet = "round";
            chart.graphs[1].bulletOffset = 0;
            chart.graphs[1].showBalloon = true;
            $('input[name="pointer"][value="on"]').prop('checked', true).trigger('click');
        } else {
            chart.graphs[1].bullet = "none";
            chart.graphs[1].bulletOffset = -150;
            chart.graphs[1].showBalloon = false;
        }
        chart.validateNow();
    });

    var lineJoinstatus = $('input[name="line_join_vendilator"]').is(":checked");
    $('.filterValuesByDates').val('').change();
    if (lineJoinstatus) {
        $.each(chart.graphs, function(index, value) {
            $.each(value, function(index1, value1) {
                chart.graphs[0].lineThickness = 1;
            });
        });
    } else {
        $.each(chart.graphs, function(index, value) {
            $.each(value, function(index1, value1) {
                chart.graphs[0].lineThickness = 0;
            });
        });
    }
    var lineJoinstatus = $('input[name="line_join"]').is(":checked");
    if (lineJoinstatus) {
        $.each(chart.graphs, function(index, value) {
            $.each(value, function(index1, value1) {
                chart.graphs[0].lineThickness = 1;
            });
        });
    } else {
        $.each(chart.graphs, function(index, value) {
            $.each(value, function(index1, value1) {
                chart.graphs[0].lineThickness = 0;
            });
        });
    }
    $('input[name="line_join_vendilator"],input[name="line_join"]').click(function() {
        // $('.filterValuesByDates').val('').change();
        var lineJoinstatus = $(this).is(":checked");
        if (lineJoinstatus) {
            $.each(chart.graphs, function(index, value) {
                $.each(value, function(index1, value1) {
                    chart.graphs[0].lineThickness = 1;
                });
            });
        } else {
            $.each(chart.graphs, function(index, value) {
                $.each(value, function(index1, value1) {
                    chart.graphs[0].lineThickness = 0;
                });
            });
        }
        chart.validateNow();
        // chart.validateData();
        // zoomChart();
    });
    $('input[name="line_pointer_vendilator"], input[name="pointer"]').click(function() {
        var pointerStatus = $(this).val();
        linepointerEnable(chart, pointerStatus);
    });
    // chart.addListener("rendered", zoomChart);
    chart.addListener("zoomed", zoomedChart);
    chart.addListener("drawn",modifyAxis);

    chart.addListener("updateAfterValueZoom", function(e) {});

    if (selectedDate != '') {
        var selected_date = getDateFormat(selectedDate);
        var selected_date_start = selected_date + ' 00:00';
        var selected_date_end = selected_date + ' 23:00';
        
        chart.zoomToCategoryValues(selected_date_start, selected_date_end);
    }
    $('.filterValuesByDates').change(function() {
        zoomChart($(this).val());
    });

    function zoomChart(position_value) {
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
    // zoomChart();
    // function zoomChartLastIndex() { 
    //    chart.zoomToIndexes(zoomPosition, chart.dataProvider.length - 1);     
    // }
    // zoomedChart();
    function zoomedChart(e) {
        if (typeof e != 'undefined') {
            if (data[e.chart.startIndex].tempDate == data[e.chart.endIndex].tempDate) {
                chart.categoryAxis.title = data[e.chart.startIndex].tempDate;
            } else {
                if (data[e.chart.endIndex].tempDate != 'undefined') {
                    if (typeof data[e.chart.endIndex].tempDate != 'undefined') {
                        chart.categoryAxis.title = data[e.chart.startIndex].tempDate + ' - ' + data[e.chart.endIndex].tempDate;
                    } else {
                        chart.categoryAxis.title = data[e.chart.startIndex].tempDate;
                    }
                }
            }
        }
        // modifyAxis(e);
    }
    function modifyAxis(e) {
        var axes = [e.chart.categoryAxis]; //e.chart.valueAxes;

        for ( i1 in axes ) {
            var labels = axes[i1].allLabels;
            var parent = labels[0].node.parentNode; 

            $.each(chart.guides, function (key, value) {
                var x_position = $('.amcharts-guide-fill-'+value.id).attr('transform');
                if (typeof x_position != 'undefined') {
                    x_position = x_position.split(',')[0];
                    x_position = x_position.split('(')[1];
                    x_position = x_position - 10;

                    var group = document.createElementNS('http://www.w3.org/2000/svg', "g");
                    var img   = document.createElementNS('http://www.w3.org/2000/svg', "image");

                    // Setup image
                    img.setAttributeNS('http://www.w3.org/1999/xlink', 'href', 'http://localhost/neonatal_test_chart/public/img/images.png');
                    img.setAttribute('x',x_position);
                    img.setAttribute('y',-10); // half the height
                    img.setAttribute('width','25');
                    img.setAttribute('height','15');

                    group.appendChild(img);
                    parent.appendChild(group);
                }
            });

        }
    }
}

function intiateLineChartMini(data, id, label, color_code, plotting_value_name, index, temp_line = false) {
    var file_name = $('input[name="file_name"]').val() + " " + label;

    var chart = AmCharts.makeChart(id, {
        "type": "serial",
        "theme": "none",
        "marginRight": 40,
        "marginLeft": 60,
        "autoMarginOffset": 20,
        "mouseWheelZoomEnabled": false,
        "dataDateFormat": "DD-MM-YYYY HH:NN",
        "valueAxes": [LineChartvalueAxisMini(label)],
        "balloon": LineChartballoonMini(),
        "graphs": LinegraphPropertiesSetMini(color_code, label, plotting_value_name, index, temp_line),
        "chartScrollbar": LinescrollBareMini(),
        "chartCursor": LinechartCursorMini(),
        "valueScrollbar": valueScrollbarMini(),
        "categoryField": "date",
        "categoryAxis": LinecategoryAxisMini(),
        "export": exportOptions(file_name),
        "dataProvider": data,
        "zoomControl": {
            "zoomControlEnabled": true,
            "maxZoomLevel": 12
        }
    });
    chart.addListener("rendered", zoomChart);
    zoomChart();

    function zoomChart() {
        chart.zoomToIndexes(chart.dataProvider.length - 40, chart.dataProvider.length - 1);
    }
}

function lineEnable(chart, lineStatus) {
    if (lineStatus == 'on') {
        $.each(chart.graphs, function(index, value) {
            $.each(value, function(index1, value1) {
                chart.graphs[index].lineThickness = 1;
            });
        });
        chart.validateNow();
    } else {
        $.each(chart.graphs, function(index, value) {
            $.each(value, function(index1, value1) {
                chart.graphs[index].lineThickness = 0;
            });
        });
        chart.validateNow();
    }
}
