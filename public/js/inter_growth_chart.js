$(document).ready(function() {
    var corrected_gestation_plot = $('input[name="corrected_gestation_plot"]').val();
    generateWhoChart('wt-chart-container', 'wt_percentiles', 'Weight (kg)', 0, 10.5, 'Weight', 'wt_value_count');
    var gender = $('input[name="gender"]').val();
    if (gender == 'male') {
        generateWhoChart('ht-chart-container', 'ht_percentiles', 'Length (cm)', 28, 72, 'Length', 'ht_value_count');
    } else {
        generateWhoChart('ht-chart-container', 'ht_percentiles', 'Length (cm)', 26, 72, 'Length', 'ht_value_count');
    }
    if (gender == 'male') {
        generateWhoChart('hc-chart-container', 'hc_percentiles', 'Head Circumference (cm)', 21, 47, 'Head Circumference', 'hc_value_count');
    } else {
        generateWhoChart('hc-chart-container', 'hc_percentiles', 'Head Circumference (cm)', 20, 46, 'Head Circumference', 'hc_value_count');
    }

    function generateWhoChart(containter_name, provider_name, chart_name, min_y_value, max_y_value, chart_title, value_count) {
        var charttheme = $('input[name="color"]').val();
        /**
         * ---------------------------------------
         * This demo was created using amCharts 5.
         * 
         * For more information visit:
         * https://www.amcharts.com/
         * 
         * Documentation is available at:
         * https://www.amcharts.com/docs/v5/
         * ---------------------------------------
         */
        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new(containter_name);
        var responsive = am5themes_Responsive.new(root);
        // Set themes
        // https://www.amcharts.com/docs/v5/concepts/themes/
        root.setThemes([
            am5themes_Animated.new(root),
            responsive
        ]);
        // Create chart
        // https://www.amcharts.com/docs/v5/charts/xy-chart/
        var chart = root.container.children.push(am5xy.XYChart.new(root, {
            panX: false,
            panY: false,
            wheelX: "none",
            wheelY: "none",
            layout: root.verticalLayout,
        }));
        chart.set("background", am5.Rectangle.new(root, {
            stroke: am5.color(0x297373),
            strokeOpacity: 0.5,
            fill: charttheme,
            fillOpacity: 1
        }));
        chart.plotContainer.get("background").setAll({
            fill: '#FFFFFF',
            fillOpacity: 1,
        });
        // Add cursor
        // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
        chart.set("cursor", am5xy.XYCursor.new(root, {
            xAxis: xAxis,
        }));
        let cursor = chart.get("cursor");
        cursor.lineX.setAll({
            stroke: '#d20000',
            strokeWidth: 0.7,
            strokeDasharray: []
        });
        cursor.lineY.setAll({
            stroke: '#d20000',
            strokeWidth: 0.7,
            strokeDasharray: []
        });
        // Create axes
        // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
        var xRenderer = am5xy.AxisRendererX.new(root, {
            minGridDistance: 7,
        });
        xRenderer.labels.template.setAll({
            fill: '#FFFFFF',
            fontSize: 10,
            fontWeight: "bold"
        });
        var xAxis = chart.xAxes.push(am5xy.ValueAxis.new(root, {
            min: 27,
            max: 64.95,
            strictMinMax: true,
            renderer: xRenderer,
            tooltip: false,
            maxPrecision: 0,
        }));
        xAxis.children.push(am5.Label.new(root, {
            text: "Postmenstrual age (weeks)",
            x: am5.p50,
            centerX: am5.p50,
            fontSize: 18,
            fill: '#FFFFFF',
        }));
        var xRenderer2 = am5xy.AxisRendererX.new(root, {
            minGridDistance: 7,
            opposite: true,
        });
        xRenderer2.labels.template.setAll({
            fill: '#FFFFFF',
            fontSize: 10,
            fontWeight: "bold"
        });
        var xAxis2 = chart.xAxes.push(am5xy.ValueAxis.new(root, {
            min: 27,
            max: 64.95,
            strictMinMax: true,
            renderer: xRenderer2,
            tooltip: false,
            maxPrecision: 0,
        }));
        var yRenderer = am5xy.AxisRendererY.new(root, {
            minGridDistance: 15
        });
        yRenderer.grid.template.setAll({
            stroke: '#BDBBBC',
        });
        yRenderer.labels.template.setAll({
            fill: '#FFFFFF',
            fontSize: 10,
            fontWeight: "bold",
            paddingRight: 10
        });
        var number_format = "#";
        if (containter_name == 'wt-chart-container') {
            number_format = "#.0";
        }
        var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
            numberFormat: number_format,
            min: min_y_value,
            max: max_y_value,
            strictMinMax: true,
            renderer: yRenderer
        }));
        yAxis.children.moveValue(am5.Label.new(root, {
            text: chart_name,
            rotation: -90,
            y: am5.p50,
            centerX: am5.p50,
            fontSize: 16,
            fill: '#FFFFFF',
        }), 0);
        var yRenderer2 = am5xy.AxisRendererY.new(root, {
            minGridDistance: 15,
            opposite: true,
        });
        yRenderer2.labels.template.setAll({
            fill: '#FFFFFF',
            fontSize: 10,
            fontWeight: "bold",
            paddingLeft: 10
        });
        var yAxis2 = chart.yAxes.push(am5xy.ValueAxis.new(root, {
            numberFormat: number_format,
            min: min_y_value,
            max: max_y_value,
            strictMinMax: true,
            renderer: yRenderer2
        }));
        yAxis2.children.push(am5.Label.new(root, {
            text: chart_name,
            rotation: -90,
            y: am5.p50,
            centerX: am5.p50,
            fontSize: 16,
            fill: '#FFFFFF',
        }), 0);
        var thirdlineSeries = chart.series.push(am5xy.SmoothedXYLineSeries.new(root, {
            name: "3rd",
            xAxis: xAxis,
            yAxis: yAxis,
            valueXField: "week_wise_age",
            valueYField: "third_percentile",
            sequencedInterpolation: true,
            stroke: '#E51636',
            tooltip: false,
            locationX: 0,
        }));
        thirdlineSeries.strokes.template.setAll({
            templateField: "strokeSettings",
            strokeWidth: 1.5,
        });
        thirdlineSeries.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.week_wise_age == 64) {
                return am5.Bullet.new(root, {
                    sprite: am5.Circle.new(root, {
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dx: 0,
                        radius: 10,
                        fill: '#FFFFFF'
                    })
                });
            }
        });
        thirdlineSeries.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.week_wise_age == 64) {
                return am5.Bullet.new(root, {
                    sprite: am5.Label.new(root, {
                        text: '3',
                        fill: '#E51636',
                        centerX: am5.p50,
                        centerY: am5.p50,
                        paddingLeft: 23,
                        fontWeight: 'bold',
                        fontSize: 10,
                    })
                });
            }
        });
        thirdlineSeries.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.week_wise_age == 64) {
                return am5.Bullet.new(root, {
                    sprite: am5.Label.new(root, {
                        text: 'rd',
                        fill: '#E51636',
                        centerX: am5.p50,
                        centerY: am5.p50,
                        paddingLeft: 38,
                        paddingBottom: 15,
                        fontWeight: 'bold',
                        fontSize: 8,
                    })
                });
            }
        });
        var tenthlineSeries = chart.series.push(am5xy.SmoothedXYLineSeries.new(root, {
            name: "10th",
            xAxis: xAxis,
            yAxis: yAxis,
            valueXField: "week_wise_age",
            valueYField: "tenth_percentile",
            sequencedInterpolation: true,
            stroke: '#231F20',
            tooltip: false,
            locationX: 0,
        }));
        tenthlineSeries.strokes.template.setAll({
            templateField: "strokeSettings",
            strokeWidth: 1.5,
        });
        tenthlineSeries.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.week_wise_age == 64) {
                return am5.Bullet.new(root, {
                    sprite: am5.Circle.new(root, {
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dx: 0,
                        dy: -3,
                        radius: 10,
                        fill: '#FFFFFF'
                    })
                });
            }
        });
        tenthlineSeries.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.week_wise_age == 64) {
                return am5.Bullet.new(root, {
                    sprite: am5.Label.new(root, {
                        text: '10',
                        fill: '#231F20',
                        centerX: am5.p50,
                        centerY: am5.p50,
                        paddingLeft: 23,
                        paddingBottom: 13,
                        fontWeight: 'bold',
                        fontSize: 10,
                    })
                });
            }
        });
        tenthlineSeries.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.week_wise_age == 64) {
                return am5.Bullet.new(root, {
                    sprite: am5.Label.new(root, {
                        text: 'th',
                        fill: '#231F20',
                        centerX: am5.p50,
                        centerY: am5.p50,
                        paddingLeft: 41,
                        paddingBottom: 23,
                        fontWeight: 'bold',
                        fontSize: 8,
                    })
                });
            }
        });
        var fiftylineSeries = chart.series.push(am5xy.SmoothedXYLineSeries.new(root, {
            name: "50th",
            xAxis: xAxis,
            yAxis: yAxis,
            valueXField: "week_wise_age",
            valueYField: "fiftieth_percentile",
            sequencedInterpolation: true,
            stroke: '#00843D',
            tooltip: false,
            locationX: 0,
        }));
        fiftylineSeries.strokes.template.setAll({
            templateField: "strokeSettings",
            strokeWidth: 1.5,
        });
        fiftylineSeries.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.week_wise_age == 64) {
                return am5.Bullet.new(root, {
                    sprite: am5.Circle.new(root, {
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dx: 0,
                        radius: 10,
                        fill: '#FFFFFF'
                    })
                });
            }
        });
        fiftylineSeries.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.week_wise_age == 64) {
                return am5.Bullet.new(root, {
                    sprite: am5.Label.new(root, {
                        text: '50',
                        fill: '#00843D',
                        centerX: am5.p50,
                        centerY: am5.p50,
                        paddingLeft: 23,
                        fontWeight: 'bold',
                        fontSize: 10,
                    })
                });
            }
        });
        fiftylineSeries.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.week_wise_age == 64) {
                return am5.Bullet.new(root, {
                    sprite: am5.Label.new(root, {
                        text: 'th',
                        fill: '#00843D',
                        centerX: am5.p50,
                        centerY: am5.p50,
                        paddingLeft: 41,
                        paddingBottom: 15,
                        fontWeight: 'bold',
                        fontSize: 8,
                    })
                });
            }
        });
        var ninetylineSeries = chart.series.push(am5xy.SmoothedXYLineSeries.new(root, {
            name: "90th",
            xAxis: xAxis,
            yAxis: yAxis,
            valueXField: "week_wise_age",
            valueYField: "ninety_percentile",
            sequencedInterpolation: true,
            stroke: '#231F20',
            tooltip: false,
            locationX: 0,
        }));
        ninetylineSeries.strokes.template.setAll({
            templateField: "strokeSettings",
            strokeWidth: 1.5,
        });
        ninetylineSeries.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.week_wise_age == 64) {
                return am5.Bullet.new(root, {
                    sprite: am5.Circle.new(root, {
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dx: 0,
                        radius: 15,
                        fill: '#FFFFFF'
                    })
                });
            }
        });
        ninetylineSeries.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.week_wise_age == 64) {
                return am5.Bullet.new(root, {
                    sprite: am5.Label.new(root, {
                        text: '90',
                        fill: '#231F20',
                        centerX: am5.p50,
                        centerY: am5.p50,
                        paddingLeft: 23,
                        fontWeight: 'bold',
                        fontSize: 10,
                    })
                });
            }
        });
        ninetylineSeries.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.week_wise_age == 64) {
                return am5.Bullet.new(root, {
                    sprite: am5.Label.new(root, {
                        text: 'th',
                        fill: '#231F20',
                        centerX: am5.p50,
                        centerY: am5.p50,
                        paddingLeft: 41,
                        paddingBottom: 15,
                        fontWeight: 'bold',
                        fontSize: 8,
                    })
                });
            }
        });
        var ninetyseventhlineSeries = chart.series.push(am5xy.SmoothedXYLineSeries.new(root, {
            name: "97th",
            xAxis: xAxis,
            yAxis: yAxis,
            valueXField: "week_wise_age",
            valueYField: "ninetyseventh_percentile",
            sequencedInterpolation: true,
            stroke: '#E51636',
            tooltip: false,
            locationX: 0,
        }));
        ninetyseventhlineSeries.strokes.template.setAll({
            templateField: "strokeSettings",
            strokeWidth: 1.5,
        });
        ninetyseventhlineSeries.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.week_wise_age == 64) {
                return am5.Bullet.new(root, {
                    sprite: am5.Circle.new(root, {
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dx: 0,
                        radius: 10,
                        fill: '#FFFFFF'
                    })
                });
            }
        });
        ninetyseventhlineSeries.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.week_wise_age == 64) {
                return am5.Bullet.new(root, {
                    sprite: am5.Label.new(root, {
                        text: '97',
                        fill: '#E51636',
                        centerX: am5.p50,
                        centerY: am5.p50,
                        paddingLeft: 23,
                        fontWeight: 'bold',
                        fontSize: 10,
                    })
                });
            }
        });
        ninetyseventhlineSeries.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.week_wise_age == 64) {
                return am5.Bullet.new(root, {
                    sprite: am5.Label.new(root, {
                        text: 'th',
                        fill: '#E51636',
                        centerX: am5.p50,
                        centerY: am5.p50,
                        paddingLeft: 41,
                        paddingBottom: 15,
                        fontWeight: 'bold',
                        fontSize: 8,
                    })
                });
            }
        });
        var dotSeries = chart.series.push(am5xy.LineSeries.new(root, {
            name: "Value Series",
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: 'value',
            valueXField: 'cage',
            openValueYField: 'data_from',
            highValueYField: 'display_age',
            sequencedInterpolation: true,
            connect: false,
            tooltip: false,
        }));
        dotSeries.bullets.push(function() {
            var tooltip = am5.Tooltip.new(root, {
                getFillFromSprite: false,
                autoTextColor: false,
                getStrokeFromSprite: false,
            });
            tooltip.label.setAll({
                fill: '#000000',
                fontSize: 12,
                fillOpacity: 0.5
            });
            tooltip.get("background").setAll({
                fill: am5.color(0xffffff),
                fillOpacity: 0.6,
                stroke: '#114CAA',
                strokeOpacity: 1,
                strokeWidth: 2,
            });
            return am5.Bullet.new(root, {
                locationX: 0.5,
                sprite: am5.Circle.new(root, {
                    centerX: 3,
                    radius: 3,
                    fill: '#114CAA',
                    tooltipText: "{openValueX}Age : [/]{highValueY}[/]\n"+chart_title+": [/]{valueY}\nModule Name: [/]{openValueY}",
                    tooltip: tooltip
                })
            })
        });
        dotSeries.strokes.template.set("strokeOpacity", 0);

        var value_count = $('input[name="' + value_count + '"]').val();
        var dotPlotSeries = [];
        // Create a universal tooltip to be used for multiple series
        for (var i = 1; i <= value_count; i++) {
            dotPlotSeries[i] = chart.series.push(am5xy.LineSeries.new(root, {
                name: "Value Series" + i,
                xAxis: xAxis,
                yAxis: yAxis,
                valueYField: 'value_' + i,
                valueXField: 'cage_' + i,
                openValueYField: 'data_from_' + i,
                highValueYField: 'display_age_' + i,
                sequencedInterpolation: true,
                connect: false,
                tooltip: false,
            }));
            dotPlotSeries[i].bullets.push(function() {
                var tooltip = am5.Tooltip.new(root, {
                getFillFromSprite: false,
                autoTextColor: false,
                getStrokeFromSprite: false,
                });
                tooltip.label.setAll({
                    fill: '#000000',
                    fontSize: 12,
                    fillOpacity: 0.5
                });
                tooltip.get("background").setAll({
                    fill: am5.color(0xffffff),
                    fillOpacity: 0.6,
                    stroke: '#114CAA',
                    strokeOpacity: 1,
                    strokeWidth: 2,
                });
                return am5.Bullet.new(root, {
                    locationX: 0.5,
                    sprite: am5.Circle.new(root, {
                        centerX: 3,
                        radius: 3,
                        fill: '#114CAA',
                        tooltipText: "{openValueX}Age : [/]{highValueY}[/]\n"+chart_title+": [/]{valueY}\nModule Name: [/]{openValueY}",
                        tooltip: tooltip
                    })
                })
            });
            dotPlotSeries[i].strokes.template.set("strokeOpacity", 0);
        }

        var chartData = [];
        var provider = $('input[name="' + provider_name + '"]').val();
        chartData = JSON.parse(provider);
        // add range grid
        for (var i = 27; i < 64; i++) {
            var grid1 = i + 0.143;
            var grid2 = i + 0.286;
            var grid3 = i + 0.429;
            var grid4 = i + 0.572;
            var grid5 = i + 0.715;
            var grid6 = i + 0.858;
            var range = xAxis.makeDataItem({});
            xAxis.createAxisRange(range);
            range.set("value", grid1);
            var grid = range.get("grid");
            grid.setAll({
                stroke: '#D6D6D8',
                strokeOpacity: 1,
            });
            var range = xAxis.makeDataItem({});
            xAxis.createAxisRange(range);
            range.set("value", grid2);
            var grid = range.get("grid");
            grid.setAll({
                stroke: '#D6D6D8',
                strokeOpacity: 1,
            });
            var range = xAxis.makeDataItem({});
            xAxis.createAxisRange(range);
            range.set("value", grid3);
            var grid = range.get("grid");
            grid.setAll({
                stroke: '#D6D6D8',
                strokeOpacity: 1,
            });
            var range = xAxis.makeDataItem({});
            xAxis.createAxisRange(range);
            range.set("value", grid4);
            var grid = range.get("grid");
            grid.setAll({
                stroke: '#D6D6D8',
                strokeOpacity: 1,
            });
            var range = xAxis.makeDataItem({});
            xAxis.createAxisRange(range);
            range.set("value", grid5);
            var grid = range.get("grid");
            grid.setAll({
                stroke: '#D6D6D8',
                strokeOpacity: 1,
            });
            var range = xAxis.makeDataItem({});
            xAxis.createAxisRange(range);
            range.set("value", grid6);
            var grid = range.get("grid");
            grid.setAll({
                stroke: '#D6D6D8',
                strokeOpacity: 1,
            });

            if ((i == 31 || i == 35 || i == 39 || i == 43 || i == 47 || i == 51 || i == 55 || i == 59 || i == 63) && i != corrected_gestation_plot) {
                var range = xAxis.makeDataItem({});
                xAxis.createAxisRange(range);
                range.set("value", i);
                var grid = range.get("grid");
                grid.setAll({
                    stroke: '#000000',
                    strokeOpacity: 1,
                });
            } else if (i != corrected_gestation_plot) {
                var range = xAxis.makeDataItem({});
                xAxis.createAxisRange(range);
                range.set("value", i);
                var grid = range.get("grid");
                grid.setAll({
                    stroke: '#898b8dc9',
                    strokeOpacity: 1,
                });                
            }
        }
        if (containter_name == 'wt-chart-container') {
            for (var i = 0; i < 10.5;) {
                var grid1 = i + 0.1;
                var grid2 = i + 0.2;
                var grid3 = i + 0.3;
                var grid4 = i + 0.4;
                var range = yAxis.makeDataItem({});
                yAxis.createAxisRange(range);
                range.set("value", grid1);
                var grid = range.get("grid");
                grid.setAll({
                    stroke: '#D6D6D8',
                    strokeOpacity: 1,
                });
                var range = yAxis.makeDataItem({});
                yAxis.createAxisRange(range);
                range.set("value", grid2);
                var grid = range.get("grid");
                grid.setAll({
                    stroke: '#D6D6D8',
                    strokeOpacity: 1,
                });
                var range = yAxis.makeDataItem({});
                yAxis.createAxisRange(range);
                range.set("value", grid3);
                var grid = range.get("grid");
                grid.setAll({
                    stroke: '#D6D6D8',
                    strokeOpacity: 1,
                });
                var range = yAxis.makeDataItem({});
                yAxis.createAxisRange(range);
                range.set("value", grid4);
                var grid = range.get("grid");
                grid.setAll({
                    stroke: '#D6D6D8',
                    strokeOpacity: 1,
                });
                i = i + 0.5;
            }
        }
        if (containter_name == 'ht-chart-container') {
            for (var i = 27; i < 72;) {
                var range = yAxis.makeDataItem({});
                yAxis.createAxisRange(range);
                range.set("value", i);
                var grid = range.get("grid");
                grid.setAll({
                    stroke: '#A3A2A2',
                    strokeOpacity: 1,
                });
                i = i + 2;
            }
        }
        if (containter_name == 'hc-chart-container') {
            for (var i = min_y_value; i < max_y_value; i++) {
                var grid1 = i + 0.2;
                var grid2 = i + 0.4;
                var grid3 = i + 0.6;
                var grid4 = i + 0.8;
                var range = yAxis.makeDataItem({});
                yAxis.createAxisRange(range);
                range.set("value", grid1);
                var grid = range.get("grid");
                grid.setAll({
                    stroke: '#D6D6D8',
                    strokeOpacity: 1,
                });
                var range = yAxis.makeDataItem({});
                yAxis.createAxisRange(range);
                range.set("value", grid2);
                var grid = range.get("grid");
                grid.setAll({
                    stroke: '#D6D6D8',
                    strokeOpacity: 1,
                });
                var range = yAxis.makeDataItem({});
                yAxis.createAxisRange(range);
                range.set("value", grid3);
                var grid = range.get("grid");
                grid.setAll({
                    stroke: '#D6D6D8',
                    strokeOpacity: 1,
                });
                var range = yAxis.makeDataItem({});
                yAxis.createAxisRange(range);
                range.set("value", grid4);
                var grid = range.get("grid");
                grid.setAll({
                    stroke: '#D6D6D8',
                    strokeOpacity: 1,
                });
            }
        }
        // var range = xAxis.makeDataItem({});
        // xAxis.createAxisRange(range);
        // range.set("value", corrected_gestation_plot);
        // var grid = range.get("grid");
        // grid.setAll({
        //     stroke: charttheme,
        //     strokeOpacity: 1,
        //     strokeWidth: 2,
        // });
        var range = xAxis.makeDataItem({});
        xAxis.createAxisRange(range);
        range.set("value", 37);
        var grid = range.get("grid");
        grid.setAll({
            stroke: charttheme,
            strokeOpacity: 1,
            strokeWidth: 2,
        });
        xAxis.data.setAll(chartData);
        thirdlineSeries.data.setAll(chartData);
        tenthlineSeries.data.setAll(chartData);
        fiftylineSeries.data.setAll(chartData);
        ninetylineSeries.data.setAll(chartData);
        ninetyseventhlineSeries.data.setAll(chartData);
        dotSeries.data.setAll(chartData);
        for (var i = 1; i <= value_count; i++) {
            dotPlotSeries[i].data.setAll(chartData);
        }
        // Make stuff animate on load
        // https://www.amcharts.com/docs/v5/concepts/animations/
        chart.appear(1000, 100);
    }
});
