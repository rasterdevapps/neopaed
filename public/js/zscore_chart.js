$(document).ready(function() {
    generateWhoChart('wt-chart-container', 'wt_provider', 'Weight (kg)', 1, 30, 'wt_value_count', 'Weight');
    generateWhoChartTwoParts('ht-chart-container', 'ht_provider', 'Length/Height (cm)', 43, 127, 'ht_value_count', 'Length');

    var gender = $('input[name="gender"]').val();
    if (gender == 'male') {
        generateWhoChart('hc-chart-container', 'hc_provider', 'Head Circumference (cm)', 31, 56.5, 'hc_value_count', 'Head Circumference');
    } else {
        generateWhoChart('hc-chart-container', 'hc_provider', 'Head Circumference (cm)', 31, 56.5, 'hc_value_count', 'Head Circumference');
    }

    function generateWhoChart(containter_name, provider_name, chart_name, min_y_value, max_y_value, value_count, chart_title) {
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
        var responsive = am5themes_Responsive.newEmpty(root);
        responsive.addRule({
            name: "AxisRendererX",
            relevant: function(width, height) {
                return width < am5themes_Responsive.XL;
            },
            settings: {
                minGridDistance: 12
            }
        });
        responsive.addRule({
            name: "AxisRendererX",
            relevant: function(width, height) {
                return width >= am5themes_Responsive.XL;
            },
            settings: {
                minGridDistance: 20
            }
        });
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
        var xRenderer = am5xy.AxisRendererX.new(root, {});
        xRenderer.labels.template.setAll({
            text: "{realName}",
            fill: '#FFFFFF',
            fontSize: 10,
            fontWeight: "bold"
        });
        xRenderer.grid.template.setAll({
            strokeOpacity: 0,
            strokeWidth: 0
        });
        var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
            categoryField: "category",
            renderer: xRenderer,
            tooltip: false
        }));
        xAxis.children.push(am5.Label.new(root, {
            text: "Age (completed months and years)",
            x: am5.p50,
            centerX: am5.p50,
            fontSize: 18,
            fill: '#FFFFFF',
            paddingBottom: 0
        }));
        var xRenderer1 = am5xy.AxisRendererX.new(root, {
        });
        xRenderer1.labels.template.setAll({
            fill: '#FFFFFF',
            fontSize: 10,
        });
        var xAxis1 = chart.xAxes.push(am5xy.ValueAxis.new(root, {
            min: 0,
            max: 63,
            strictMinMax: true,
            renderer: xRenderer1,
            tooltip: false
        }));
        xRenderer1.grid.template.set("forceHidden", true);
        xRenderer1.labels.template.set("forceHidden", true);
        var yRenderer = am5xy.AxisRendererY.new(root, {
            minGridDistance: 30
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
        var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
            min: min_y_value,
            max: max_y_value,
            strictMinMax: true,
            maxPrecision: 0,
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
            minGridDistance: 7,
            opposite: true,
        });
        yRenderer2.labels.template.setAll({
            fill: charttheme,
            fontSize: 10,
        });
        yRenderer2.labels.template.set("forceHidden", true);
        var yAxis2 = chart.yAxes.push(am5xy.ValueAxis.new(root, {
            min: min_y_value,
            max: max_y_value,
            strictMinMax: true,
            maxPrecision: 0,
            renderer: yRenderer2
        }));
        var yRenderer3 = am5xy.AxisRendererY.new(root, {
            minGridDistance: 30,
            opposite: true,
        });
        yRenderer3.grid.template.setAll({
            stroke: '#F79463',
        });
        yRenderer3.labels.template.setAll({
            fill: '#FFFFFF',
            fontSize: 10,
            fontWeight: "bold",
            paddingLeft: 10
        });
        yRenderer3.grid.template.set("forceHidden", true);
        var yAxis3 = chart.yAxes.push(am5xy.ValueAxis.new(root, {
            min: min_y_value,
            max: max_y_value,
            strictMinMax: true,
            maxPrecision: 0,
            renderer: yRenderer3
        }));
        // Create series
        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/  
        var sd3neglineSeries = chart.series.push(am5xy.SmoothedXYLineSeries.new(root, {
            name: "-3",
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: "sd_3_neg",
            sequencedInterpolation: true,
            stroke: '#E51636',
            categoryXField: "category",
            tooltip: false,
            locationX: 0,
        }));
        sd3neglineSeries.strokes.template.setAll({
            templateField: "strokeSettings",
            strokeWidth: 1.5,
        });
        sd3neglineSeries.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.showBullets == true) {
                return am5.Bullet.new(root, {
                    sprite: am5.Circle.new(root, {
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dx: 8,
                        radius: 12,
                        fill: '#FFFFFF'
                    })
                });
            }
        });
        sd3neglineSeries.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.showBullets == true) {
                return am5.Bullet.new(root, {
                    sprite: am5.Label.new(root, {
                        text: '-3',
                        fill: '#E51636',
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dx: 0,
                        fontWeight: 'bold',
                        fontSize: 12,
                    })
                });
            }
        });
        sd3neglineSeries.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.showBullets == true) {
                return am5.Bullet.new(root, {
                    sprite: am5.Label.new(root, {
                      //  text: '-3',
                        fill: '#E51636',
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dy: -3,
                        paddingLeft: 17,
                        fontWeight: 'bold',
                        fontSize: 8,
                    })
                });
            }
        });
        var sd2neglineSeries = chart.series.push(am5xy.SmoothedXYLineSeries.new(root, {
            name: "-2",
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: "sd_2_neg",
            sequencedInterpolation: true,
            stroke: '#F47435',
            categoryXField: "category",
            tooltip: false,
            locationX: 0
        }));
        sd2neglineSeries.strokes.template.setAll({
            templateField: "strokeSettings",
            strokeWidth: 1.5
        });
        sd2neglineSeries.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.showBullets == true) {
                return am5.Bullet.new(root, {
                    sprite: am5.Circle.new(root, {
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dx: 8,
                        radius: 12,
                        fill: '#FFFFFF'
                    })
                });
            }
        });
        sd2neglineSeries.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.showBullets == true) {
                return am5.Bullet.new(root, {
                    sprite: am5.Label.new(root, {
                        text: '-2',
                        fill: '#F47435',
                        centerX: am5.p0,
                        centerY: am5.p50,
                        fontWeight: 'bold',
                        fontSize: 12,
                        dy: -3,
                    })
                });
            }
        });
        sd2neglineSeries.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.showBullets == true) {
                return am5.Bullet.new(root, {
                    sprite: am5.Label.new(root, {
                      //  text: '-2',
                        fill: '#F47435',
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dy: -7,
                        paddingLeft: 24,
                        fontWeight: 'bold',
                        fontSize: 8,
                    })
                });
            }
        });
        var sd1neglineSeries = chart.series.push(am5xy.SmoothedXYLineSeries.new(root, {
            name: "-1",
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: "sd_1_neg",
            sequencedInterpolation: true,
            stroke: '#27904F',
            categoryXField: "category",
            tooltip: false,
            locationX: 0
        }));
        sd1neglineSeries.strokes.template.setAll({
            templateField: "strokeSettings",
            strokeWidth: 1.5
        });
        sd1neglineSeries.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.showBullets == true) {
                return am5.Bullet.new(root, {
                    sprite: am5.Circle.new(root, {
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dx: 8,
                        radius: 12,
                        fill: '#FFFFFF'
                    })
                });
            }
        });
        sd1neglineSeries.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.showBullets == true) {
                return am5.Bullet.new(root, {
                    sprite: am5.Label.new(root, {
                         text: '-1',
                        fill: '#27904F',
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dy: -3,
                        fontWeight: 'bold',
                        fontSize: 12,
                    })
                });
            }
        });
        sd1neglineSeries.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.showBullets == true) {
                return am5.Bullet.new(root, {
                    sprite: am5.Label.new(root, {
                      //  text: '-1',
                        fill: '#27904F',
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dy: -7,
                        paddingLeft: 24,
                        fontWeight: 'bold',
                        fontSize: 8,
                    })
                });
            }
        });
        //console.log(sd1neglineSeries);
        var sd0lineSeries = chart.series.push(am5xy.SmoothedXYLineSeries.new(root, {
            name: "0",
            xAxis: xAxis,
            yAxis: yAxis3,
            valueYField: "sd_0",
            sequencedInterpolation: true,
            stroke: '#F47435',
            categoryXField: "category",
            tooltip: false,
            locationX: 0
        }));
        sd0lineSeries.strokes.template.setAll({
            templateField: "strokeSettings",
            strokeWidth: 1.5
        });
        sd0lineSeries.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.showBullets == true) {
                return am5.Bullet.new(root, {
                    sprite: am5.Circle.new(root, {
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dx: 8,
                        radius: 12,
                        fill: '#FFFFFF'
                    })
                });
            }
        });
        sd0lineSeries.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.showBullets == true) {
                return am5.Bullet.new(root, {
                    sprite: am5.Label.new(root, {
                        text: '0',
                        fill: '#F47435',
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dy: -3,
                        fontWeight: 'bold',
                        fontSize: 12,
                    })
                });
            }
        });
        sd0lineSeries.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.showBullets == true) {
                return am5.Bullet.new(root, {
                    sprite: am5.Label.new(root, {
                       // text: '0',
                        fill: '#F47435',
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dy: -7,
                        paddingLeft: 24,
                        fontWeight: 'bold',
                        fontSize: 8,
                    })
                });
            }
        });
        var sd1lineSeries = chart.series.push(am5xy.SmoothedXYLineSeries.new(root, {
            name: "1",
            xAxis: xAxis,
            yAxis: yAxis2,
            valueYField: "sd_1",
            sequencedInterpolation: true,
            stroke: '#E51636',
            categoryXField: "category",
            tooltip: false,
            locationX: 0
        }));
        sd1lineSeries.strokes.template.setAll({
            templateField: "strokeSettings",
            strokeWidth: 1.5
        });
        sd1lineSeries.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.showBullets == true) {
                return am5.Bullet.new(root, {
                    sprite: am5.Circle.new(root, {
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dx: 8,
                        radius: 12,
                        fill: '#FFFFFF'
                    })
                });
            }
        });
        sd1lineSeries.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.showBullets == true) {
                return am5.Bullet.new(root, {
                    sprite: am5.Label.new(root, {
                        text: '1',
                        fill: '#E51636',
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dy: -3,
                        fontWeight: 'bold',
                        fontSize: 12,
                    })
                });
            }
        });
        sd1lineSeries.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.showBullets == true) {
                return am5.Bullet.new(root, {
                    sprite: am5.Label.new(root, {
                       // text: '1',
                        fill: '#E51636',
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dy: -7,
                        paddingLeft: 24,
                        fontWeight: 'bold',
                        fontSize: 8,
                    })
                });
            }
        });
         var sd2lineSeries = chart.series.push(am5xy.SmoothedXYLineSeries.new(root, {
            name: "2",
            xAxis: xAxis,
            yAxis: yAxis2,
            valueYField: "sd_2",
            sequencedInterpolation: true,
            stroke: '#E51636',
            categoryXField: "category",
            tooltip: false,
            locationX: 0
        }));
        sd2lineSeries.strokes.template.setAll({
            templateField: "strokeSettings",
            strokeWidth: 1.5
        });
        sd2lineSeries.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.showBullets == true) {
                return am5.Bullet.new(root, {
                    sprite: am5.Circle.new(root, {
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dx: 8,
                        radius: 12,
                        fill: '#FFFFFF'
                    })
                });
            }
        });
        sd2lineSeries.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.showBullets == true) {
                return am5.Bullet.new(root, {
                    sprite: am5.Label.new(root, {
                        text: '2',
                        fill: '#E51636',
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dy: -3,
                        fontWeight: 'bold',
                        fontSize: 12,
                    })
                });
            }
        });
        sd2lineSeries.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.showBullets == true) {
                return am5.Bullet.new(root, {
                    sprite: am5.Label.new(root, {
                      //  text: '2',
                        fill: '#E51636',
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dy: -7,
                        paddingLeft: 24,
                        fontWeight: 'bold',
                        fontSize: 8,
                    })
                });
            }
        });
         var sd3lineSeries = chart.series.push(am5xy.SmoothedXYLineSeries.new(root, {
            name: "3",
            xAxis: xAxis,
            yAxis: yAxis2,
            valueYField: "sd_3",
            sequencedInterpolation: true,
            stroke: '#E51636',
            categoryXField: "category",
            tooltip: false,
            locationX: 0
        }));
        sd3lineSeries.strokes.template.setAll({
            templateField: "strokeSettings",
            strokeWidth: 1.5
        });
        sd3lineSeries.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.showBullets == true) {
                return am5.Bullet.new(root, {
                    sprite: am5.Circle.new(root, {
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dx: 8,
                        radius: 12,
                        fill: '#FFFFFF'
                    })
                });
            }
        });
        sd3lineSeries.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.showBullets == true) {
                return am5.Bullet.new(root, {
                    sprite: am5.Label.new(root, {
                        text:'3',
                        fill: '#E51636',
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dy: -3,
                        fontWeight: 'bold',
                        fontSize: 12,
                    })
                });
            }
        });
        sd3lineSeries.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.showBullets == true) {
                return am5.Bullet.new(root, {
                    sprite: am5.Label.new(root, {
                      //  text:'3',
                        fill: '#E51636',
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dy: -7,
                        paddingLeft: 24,
                        fontWeight: 'bold',
                        fontSize: 8,
                    })
                });
            }
        });
        var dotSeries = chart.series.push(am5xy.LineSeries.new(root, {
            name: "Value Series",
            xAxis: xAxis1,
            yAxis: yAxis,
            valueYField: 'value',
            valueXField: 'cage',
            openValueXField: 'label_name',
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
                stroke: '#D800BF',
                strokeOpacity: 1,
                strokeWidth: 2,
            });
            return am5.Bullet.new(root, {
                locationX: 0.5,
                sprite: am5.Rectangle.new(root, {
                    width: 7,
                    height: 7,
                    centerX: 2,
                    fill: '#D800BF',
                    tooltipText: "{openValueX} Age : [/]{highValueY}[/]\n"+chart_title+": [/]{valueY}\nModule Name: [/]{openValueY}",
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
                xAxis: xAxis1,
                yAxis: yAxis,
                valueYField: 'value_' + i,
                valueXField: 'cage_' + i,
                openValueXField: 'label_name_' + i,
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
                    stroke: '#D800BF',
                    strokeOpacity: 1,
                    strokeWidth: 2,
                });
                return am5.Bullet.new(root, {
                    locationX: 0.5,
                    sprite: am5.Rectangle.new(root, {
                        width: 7,
                        height: 7,
                        centerX: 2,
                        fill: '#D800BF',
                        tooltipText: "{openValueX} Age : [/]{highValueY}[/]\n"+chart_title+": [/]{valueY}\nModule Name: [/]{openValueY}",
                        tooltip: tooltip
                    })
                })
            });
            dotPlotSeries[i].strokes.template.set("strokeOpacity", 0);
        }
        var chartData = [];
        var provider = $('input[name="' + provider_name + '"]').val();
        provider = JSON.parse(provider);
        
        // Set data
        var data = {};
        $.each(provider, function(key, value) {
            var provider_temp = [];
            $.each(value, function(zscore_name, zscore_value) {
                provider_temp[zscore_value.month] = zscore_value;
            });
            data[key] = provider_temp;
        });
        // process data ant prepare it for the chart
        var temp_count = 0;
        for (var providerName in data) {
            var providerData = data[providerName];

            // add data of one provider to temp array
            var tempArray = [];
            var count = 0;
            // add items
            var show_bullets = false;
            for (var itemName in providerData) {
                if (itemName != "quantity") {
                    count++;
                    // we generate unique category for each column (providerName + "_" + itemName) and store realName
                    if (temp_count == 59) {
                        show_bullets = true;
                    }
                    var item_name = itemName;
                    if ((temp_count == 61 || temp_count == 62) || item_name == 0) {
                        item_name = '';
                    }
                    itemName = itemName.split('.')[0];
                    var temp_percentile = {
                        category: providerName + "_" + itemName,
                        realName: item_name,
                        provider: providerName,
                        showBullets: show_bullets,
                    }
                    $.each(Object.keys(providerData[itemName]), function(key, value) {
                        if (value != 'month' && value != 'year' && value.indexOf('label_name') == -1 && value.indexOf('data_from') == -1 && value.indexOf('display_age') == -1) {
                            Object.assign(temp_percentile, {
                                [value]: providerData[itemName][value] > 0 ? parseFloat(providerData[itemName][value]) : null
                            });
                        } else if (value.indexOf('label_name') != -1 || value.indexOf('data_from') != -1 || value.indexOf('display_age') != -1) {
                            Object.assign(temp_percentile, {
                                [value]: providerData[itemName][value]
                            });                            
                        }
                    });
                    tempArray.push(temp_percentile);
                    temp_count++;
                }
            }
            // add quantity and count to middle data item (line series uses it)
            var lineSeriesDataIndex = Math.floor(count / 2);
            tempArray[lineSeriesDataIndex].count = count;
            // push to the final data
            am5.array.each(tempArray, function(item) {
                chartData.push(item);
            });
            // create range (the additional label at the bottom)
            var range = xAxis.makeDataItem({});
            xAxis.createAxisRange(range);
            range.set("category", tempArray[0].category);
            range.set("endCategory", tempArray[tempArray.length - 1].category);
            var label = range.get("label");
            label.setAll({
                text: tempArray[0].provider,
                dy: 12,
                fontSize: 12,
                fontWeight: "bold",
                location: 0,
            });
            var tick = range.get("tick");
            tick.setAll({
                visible: true,
                stroke: '#000000',
                strokeWidth: 1,
                strokeOpacity: 1,
                length: 10,
                location: 0,
            });
            var grid = range.get("grid");
            grid.setAll({
                stroke: '#000000',
                strokeWidth: 1,
                strokeOpacity: 1,
            });
        }
        // add odd grid
        $.each(chartData, function(key, value) {

            var current_grid = key % 2;
            var stroke_color = '#D3D3D3';
            if (current_grid == 0) {
                stroke_color = '#a09ea0';
            }
            if (key != 61 && key != 62 && key % 12 != 0) {
                var range = xAxis.makeDataItem({});
                xAxis.createAxisRange(range);
                range.set("category", chartData[key].category);
                var grid = range.get("grid");
                grid.setAll({
                    stroke: stroke_color,
                    strokeOpacity: 1,
                });
            };
        })
           
        // add range for the last grid
        var range = xAxis.makeDataItem({});
        xAxis.createAxisRange(range);
        range.set("category", chartData[chartData.length - 1].category);
        var grid = range.get("grid");
        grid.setAll({
            stroke: '#BDBBBC',
            strokeOpacity: 1,
            location: 5
        });
        xAxis.data.setAll(chartData);
        xAxis1.data.setAll(chartData);
        sd3neglineSeries.data.setAll(chartData);
        sd2neglineSeries.data.setAll(chartData);
        sd1neglineSeries.data.setAll(chartData);
        sd0lineSeries.data.setAll(chartData);
        sd1lineSeries.data.setAll(chartData);
        sd2lineSeries.data.setAll(chartData);
        sd3lineSeries.data.setAll(chartData);
        dotSeries.data.setAll(chartData);

        for (var i = 1; i <= value_count; i++) {
            dotPlotSeries[i].data.setAll(chartData);
        }
        var range = xAxis.makeDataItem({});
        xAxis.createAxisRange(range);
        range.set("category", 'Birth_0');
        var label = range.get("label");
        label.setAll({
            text: "Months",
            dx: -55,
            dy: 0,
            fontSize: 10,
        });
        if (chart_name == 'Head Circumference (cm)') {
            for (i = min_y_value; i < max_y_value; i++) {
                var grid_value = i + 0.5;
                var range = yAxis.makeDataItem({
                    value: grid_value,
                });
                yAxis.createAxisRange(range);
                var grid = range.get("grid");
                grid.setAll({
                    stroke: '#C3BCBC',
                    strokeOpacity: 1,
                    strokeWidth: 1,
                    visible: true
                });
            }
        }
        // Make stuff animate on load
        // https://www.amcharts.com/docs/v5/concepts/animations/
        chart.appear(1000, 100);
    }

    function generateWhoChartTwoParts(containter_name, provider_name, chart_name, min_y_value, max_y_value, value_count, chart_title) {
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
        var responsive = am5themes_Responsive.newEmpty(root);
        responsive.addRule({
            name: "AxisRendererX",
            relevant: function(width, height) {
                return width < am5themes_Responsive.XL;
            },
            settings: {
                minGridDistance: 12
            }
        });
        responsive.addRule({
            name: "AxisRendererX",
            relevant: function(width, height) {
                return width >= am5themes_Responsive.XL;
            },
            settings: {
                minGridDistance: 20
            }
        });
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
        var xRenderer = am5xy.AxisRendererX.new(root, {});
        xRenderer.labels.template.setAll({
            text: "{realName}",
            fill: '#FFFFFF',
            fontSize: 10,
            fontWeight: "bold"
        });
        xRenderer.grid.template.setAll({
            strokeOpacity: 0,
            strokeWidth: 0
        });
        var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
            categoryField: "category",
            renderer: xRenderer,
            tooltip: false
        }));
        xAxis.children.push(am5.Label.new(root, {
            text: "Age (completed months and years)",
            x: am5.p50,
            centerX: am5.p50,
            fontSize: 18,
            fill: '#FFFFFF',
            paddingBottom: 0
        }));
        var xRenderer1 = am5xy.AxisRendererX.new(root, {
        });
        xRenderer1.labels.template.setAll({
            fill: '#FFFFFF',
            fontSize: 10,
        });
        var xAxis1 = chart.xAxes.push(am5xy.ValueAxis.new(root, {
            min: 0,
            max: 63,
            strictMinMax: true,
            renderer: xRenderer1,
            tooltip: false
        }));
        xRenderer1.grid.template.set("forceHidden", true);
        xRenderer1.labels.template.set("forceHidden", true);
        var yRenderer = am5xy.AxisRendererY.new(root, {
            minGridDistance: 30
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
        var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
            min: min_y_value,
            max: max_y_value,
            strictMinMax: true,
            maxPrecision: 0,
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
            minGridDistance: 5,
            opposite: true,
        });
        yRenderer2.labels.template.setAll({
            fill: charttheme,
            fontSize: 10,
        });
        yRenderer2.labels.template.set("forceHidden", true);
        var yAxis2 = chart.yAxes.push(am5xy.ValueAxis.new(root, {
            min: min_y_value,
            max: max_y_value,
            strictMinMax: true,
            maxPrecision: 0,
            renderer: yRenderer2
        }));
        var yRenderer3 = am5xy.AxisRendererY.new(root, {
            minGridDistance: 30,
            opposite: true,
        });
        yRenderer3.grid.template.setAll({
            stroke: '#F79463',
        });
        yRenderer3.labels.template.setAll({
            fill: '#FFFFFF',
            fontSize: 10,
            fontWeight: "bold",
            // paddingLeft: 10
        });
        yRenderer3.grid.template.set("forceHidden", true);
        var yAxis3 = chart.yAxes.push(am5xy.ValueAxis.new(root, {
            min: min_y_value,
            max: max_y_value,
            strictMinMax: true,
            maxPrecision: 0,
            renderer: yRenderer3
        }));
        // Create series
        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/  
        var sd3neglineSeriesPart1 = chart.series.push(am5xy.SmoothedXYLineSeries.new(root, {
            name: "-3",
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: "sd_3_neg_part_1",
            sequencedInterpolation: true,
            stroke: '#E51636',
            categoryXField: "category",
            tooltip: false,
            locationX: 0,
        }));
        sd3neglineSeriesPart1.strokes.template.setAll({
            templateField: "strokeSettings",
            strokeWidth: 1.5,
        });
        var sd2neglineSeriesPart1 = chart.series.push(am5xy.SmoothedXYLineSeries.new(root, {
            name: "-2",
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: "sd_2_neg_part_1",
            sequencedInterpolation: true,
            stroke: '#F47435',
            categoryXField: "category",
            tooltip: false,
            locationX: 0
        }));
        sd2neglineSeriesPart1.strokes.template.setAll({
            templateField: "strokeSettings",
            strokeWidth: 1.5
        });
        var sd1neglineSeriesPart1 = chart.series.push(am5xy.SmoothedXYLineSeries.new(root, {
            name: "-1",
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: "sd_1_neg_part_1",
            sequencedInterpolation: true,
            stroke: '#27904F',
            categoryXField: "category",
            tooltip: false,
            locationX: 0
        }));
        sd1neglineSeriesPart1.strokes.template.setAll({
            templateField: "strokeSettings",
            strokeWidth: 1.5
        });
        var sd0lineSeriesPart1 = chart.series.push(am5xy.SmoothedXYLineSeries.new(root, {
            name: "0",
            xAxis: xAxis,
            yAxis: yAxis3,
            valueYField: "sd_0_part_1",
            sequencedInterpolation: true,
            stroke: '#F47435',
            categoryXField: "category",
            tooltip: false,
            locationX: 0
        }));
        sd0lineSeriesPart1.strokes.template.setAll({
            templateField: "strokeSettings",
            strokeWidth: 1.5
        });
        var sd1lineSeriesPart1 = chart.series.push(am5xy.SmoothedXYLineSeries.new(root, {
            name: "1",
            xAxis: xAxis,
            yAxis: yAxis2,
            valueYField: "sd_1_part_1",
            sequencedInterpolation: true,
            stroke: '#E51636',
            categoryXField: "category",
            tooltip: false,
            locationX: 0
        }));
        sd1lineSeriesPart1.strokes.template.setAll({
            templateField: "strokeSettings",
            strokeWidth: 1.5
        });
        var sd2lineSeriesPart1 = chart.series.push(am5xy.SmoothedXYLineSeries.new(root, {
            name: "2",
            xAxis: xAxis,
            yAxis: yAxis2,
            valueYField: "sd_2_part_1",
            sequencedInterpolation: true,
            stroke: '#E51636',
            categoryXField: "category",
            tooltip: false,
            locationX: 0
        }));
        sd2lineSeriesPart1.strokes.template.setAll({
            templateField: "strokeSettings",
            strokeWidth: 1.5
        });
        var sd3lineSeriesPart1 = chart.series.push(am5xy.SmoothedXYLineSeries.new(root, {
            name: "3",
            xAxis: xAxis,
            yAxis: yAxis2,
            valueYField: "sd_3_part_1",
            sequencedInterpolation: true,
            stroke: '#E51636',
            categoryXField: "category",
            tooltip: false,
            locationX: 0,
            paddingRight: 10
        }));
        sd3lineSeriesPart1.strokes.template.setAll({
            templateField: "strokeSettings",
            strokeWidth: 1.5
        });

    ////  part 2
         var sd3neglineSeriesPart2 = chart.series.push(am5xy.SmoothedXYLineSeries.new(root, {
            name: "-3",
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: "sd_3_neg_part_2",
            sequencedInterpolation: true,
            stroke: '#E51636',
            categoryXField: "category",
            tooltip: false,
            locationX: 0,
        }));
        sd3neglineSeriesPart2.strokes.template.setAll({
            templateField: "strokeSettings",
            strokeWidth: 1.5,
        });
        sd3neglineSeriesPart2.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.showBullets == true) {
                return am5.Bullet.new(root, {
                    sprite: am5.Circle.new(root, {
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dx: 8,
                        radius: 12,
                        fill: '#FFFFFF'
                    })
                });
            }
        });
        sd3neglineSeriesPart2.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.showBullets == true) {
                return am5.Bullet.new(root, {
                    sprite: am5.Label.new(root, {
                        text: '-3',
                        fill: '#E51636',
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dx: 0,
                        fontWeight: 'bold',
                        fontSize: 12,
                    })
                });
            }
        });
      sd3neglineSeriesPart2.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.showBullets == true) {
                return am5.Bullet.new(root, {
                    sprite: am5.Label.new(root, {
                      //  text: '-3',
                        fill: '#E51636',
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dy: -3,
                        paddingLeft: 17,
                        fontWeight: 'bold',
                        fontSize: 8,
                    })
                });
            }
        });
        var sd2neglineSeriesPart2 = chart.series.push(am5xy.SmoothedXYLineSeries.new(root, {
            name: "-2",
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: "sd_2_neg_part_2",
            sequencedInterpolation: true,
            stroke: '#F47435',
            categoryXField: "category",
            tooltip: false,
            locationX: 0
        }));
        sd2neglineSeriesPart2.strokes.template.setAll({
            templateField: "strokeSettings",
            strokeWidth: 1.5
        });
        sd2neglineSeriesPart2.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.showBullets == true) {
                return am5.Bullet.new(root, {
                    sprite: am5.Circle.new(root, {
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dx: 8,
                        radius: 12,
                        fill: '#FFFFFF'
                    })
                });
            }
        });
        sd2neglineSeriesPart2.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.showBullets == true) {
                return am5.Bullet.new(root, {
                    sprite: am5.Label.new(root, {
                        text: '-2',
                        fill: '#F47435',
                        centerX: am5.p0,
                        centerY: am5.p50,
                        fontWeight: 'bold',
                        fontSize: 12,
                        dy: -3,
                    })
                });
            }
        });
         sd2neglineSeriesPart2.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.showBullets == true) {
                return am5.Bullet.new(root, {
                    sprite: am5.Label.new(root, {
                     //   text: '-2',
                        fill: '#F47435',
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dy: -7,
                        paddingLeft: 24,
                        fontWeight: 'bold',
                        fontSize: 8,
                    })
                });
            }
        });
        var sd1neglineSeriesPart2 = chart.series.push(am5xy.SmoothedXYLineSeries.new(root, {
            name: "-1",
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: "sd_1_neg_part_2",
            sequencedInterpolation: true,
            stroke: '#27904F',
            categoryXField: "category",
            tooltip: false,
            locationX: 0
        }));
        sd1neglineSeriesPart2.strokes.template.setAll({
            templateField: "strokeSettings",
            strokeWidth: 1.5
        });
        sd1neglineSeriesPart2.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.showBullets == true) {
                return am5.Bullet.new(root, {
                    sprite: am5.Circle.new(root, {
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dx: 8,
                        radius: 12,
                        fill: '#FFFFFF'
                    })
                });
            }
        });
        sd1neglineSeriesPart2.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.showBullets == true) {
                return am5.Bullet.new(root, {
                    sprite: am5.Label.new(root, {
                        text: '-1',
                        fill: '#27904F',
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dy: -3,
                        fontWeight: 'bold',
                        fontSize: 12,
                    })
                });
            }
        });
         sd1neglineSeriesPart2.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.showBullets == true) {
                return am5.Bullet.new(root, {
                    sprite: am5.Label.new(root, {
                      //  text: '-1',
                        fill: '#27904F',
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dy: -7,
                        paddingLeft: 24,
                        fontWeight: 'bold',
                        fontSize: 8,
                    })
                });
            }
        });
        
        
        var sd0lineSeriesPart2 = chart.series.push(am5xy.SmoothedXYLineSeries.new(root, {
            name: "0",
            xAxis: xAxis,
            yAxis: yAxis3,
            valueYField: "sd_0_part_2",
            sequencedInterpolation: true,
            stroke: '#F47435',
            categoryXField: "category",
            tooltip: false,
            locationX: 0
        }));
        sd0lineSeriesPart2.strokes.template.setAll({
            templateField: "strokeSettings",
            strokeWidth: 1.5
        });
        sd0lineSeriesPart2.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.showBullets == true) {
                return am5.Bullet.new(root, {
                    sprite: am5.Circle.new(root, {
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dx: 8,
                        radius: 12,
                        fill: '#FFFFFF'
                    })
                });
            }
        });
        sd0lineSeriesPart2.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.showBullets == true) {
                return am5.Bullet.new(root, {
                    sprite: am5.Label.new(root, {
                        text: '0',
                        fill: '#F47435',
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dy: -3,
                        fontWeight: 'bold',
                        fontSize: 12,
                    })
                });
            }
        });
        sd0lineSeriesPart2.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.showBullets == true) {
                return am5.Bullet.new(root, {
                    sprite: am5.Label.new(root, {
                      //  text: '0',
                        fill: '#F47435',
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dy: -7,
                        paddingLeft: 24,
                        fontWeight: 'bold',
                        fontSize: 8,
                    })
                });
            }
        });
      
        //
        var sd1lineSeriesPart2 = chart.series.push(am5xy.SmoothedXYLineSeries.new(root, {
            name: "1",
            xAxis: xAxis,
            yAxis: yAxis2,
            valueYField: "sd_1_part_2",
            sequencedInterpolation: true,
            stroke: '#E51636',
            categoryXField: "category",
            tooltip: false,
            locationX: 0
        }));
        sd1lineSeriesPart2.strokes.template.setAll({
            templateField: "strokeSettings",
            strokeWidth: 1.5
        });
        sd1lineSeriesPart2.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.showBullets == true) {
                return am5.Bullet.new(root, {
                    sprite: am5.Circle.new(root, {
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dx: 8,
                        radius: 12,
                        fill: '#FFFFFF'
                    })
                });
            }
        });
        sd1lineSeriesPart2.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.showBullets == true) {
                return am5.Bullet.new(root, {
                    sprite: am5.Label.new(root, {
                        text: '1',
                        fill: '#E51636',
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dy: -3,
                        fontWeight: 'bold',
                        fontSize: 12,
                    })
                });
            }
        });
          sd1lineSeriesPart2.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.showBullets == true) {
                return am5.Bullet.new(root, {
                    sprite: am5.Label.new(root, {
                       // text: '1',
                        fill: '#E51636',
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dy: -7,
                        paddingLeft:24,
                        fontWeight: 'bold',
                        fontSize: 8,
                    })
                });
            }
        });
       //
        var sd2lineSeriesPart2 = chart.series.push(am5xy.SmoothedXYLineSeries.new(root, {
            name: "2",
            xAxis: xAxis,
            yAxis: yAxis2,
            valueYField: "sd_2_part_2",
            sequencedInterpolation: true,
            stroke: '#E51636',
            categoryXField: "category",
            tooltip: false,
            locationX: 0
        }));
        sd2lineSeriesPart2.strokes.template.setAll({
            templateField: "strokeSettings",
            strokeWidth: 1.5
        });
        sd2lineSeriesPart2.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.showBullets == true) {
                return am5.Bullet.new(root, {
                    sprite: am5.Circle.new(root, {
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dx: 8,
                        radius: 12,
                        fill: '#FFFFFF'
                    })
                });
            }
        });
        sd2lineSeriesPart2.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.showBullets == true) {
                return am5.Bullet.new(root, {
                    sprite: am5.Label.new(root, {
                        text: '2',
                        fill: '#E51636',
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dy: -3,
                        fontWeight: 'bold',
                        fontSize: 12,
                    })
                });
            }
        });
         sd2lineSeriesPart2.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.showBullets == true) {
                return am5.Bullet.new(root, {
                    sprite: am5.Label.new(root, {
                       // text: '2',
                        fill: '#E51636',
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dy: -7,
                        paddingLeft: 24,
                        fontWeight: 'bold',
                        fontSize: 8,
                    })
                });
            }
        });

        var sd3lineSeriesPart2 = chart.series.push(am5xy.SmoothedXYLineSeries.new(root, {
            name: "3",
            xAxis: xAxis,
            yAxis: yAxis2,
            valueYField: "sd_3_part_2",
            sequencedInterpolation: true,
            stroke: '#E51636',
            categoryXField: "category",
            tooltip: false,
            locationX: 0
        }));
        sd3lineSeriesPart2.strokes.template.setAll({
            templateField: "strokeSettings",
            strokeWidth: 1.5
        });
        sd3lineSeriesPart2.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.showBullets == true) {
                return am5.Bullet.new(root, {
                    sprite: am5.Circle.new(root, {
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dx: 8,
                        radius: 12,
                        fill: '#FFFFFF'
                    })
                });
            }
        });
        sd3lineSeriesPart2.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.showBullets == true) {
                return am5.Bullet.new(root, {
                    sprite: am5.Label.new(root, {
                        text: '3',
                        fill: '#E51636',
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dy: -3,
                        fontWeight: 'bold',
                        fontSize: 12,
                    })
                });
            }
        });
       sd3lineSeriesPart2.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.showBullets == true) {
                return am5.Bullet.new(root, {
                    sprite: am5.Label.new(root, {
                        //text: '3',
                        fill: '#E51636',
                        centerX: am5.p0,
                        centerY: am5.p50,
                        dy: -7,
                        paddingLeft: 24,
                        fontWeight: 'bold',
                        fontSize: 8,
                    })
                });
            }
        });
        var dotSeries = chart.series.push(am5xy.LineSeries.new(root, {
            name: "Value Series",
            xAxis: xAxis1,
            yAxis: yAxis,
            valueYField: 'value',
            valueXField: 'cage',
            openValueXField: 'label_name',
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
                stroke: '#D800BF',
                strokeOpacity: 1,
                strokeWidth: 2,
            });
            return am5.Bullet.new(root, {
                locationX: 0.5,
                sprite: am5.Rectangle.new(root, {
                    width: 7,
                    height: 7,
                    centerX: 2,
                    fill: '#D800BF',
                    tooltipText: "{openValueX} Age : [/]{highValueY}[/]\n"+chart_title+": [/]{valueY}\nModule Name: [/]{openValueY}",
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
                xAxis: xAxis1,
                yAxis: yAxis,
                valueYField: 'value_' + i,
                valueXField: 'cage_' + i,
                openValueXField: 'label_name_' + i,
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
                    stroke: '#D800BF',
                    strokeOpacity: 1,
                    strokeWidth: 2,
                });
                return am5.Bullet.new(root, {
                    locationX: 0.5,
                    sprite: am5.Rectangle.new(root, {
                        width: 7,
                        height: 7,
                        centerX: 2,
                        fill: '#D800BF',
                        tooltipText: "{openValueX} Age : [/]{highValueY}[/]\n"+chart_title+": [/]{valueY}\nModule Name: [/]{openValueY}",
                        tooltip: tooltip
                    })
                })
            });
            dotPlotSeries[i].strokes.template.set("strokeOpacity", 0);
        }

        var chartData = [];
        var provider = $('input[name="' + provider_name + '"]').val();
                

        provider = JSON.parse(provider);
        console.log(provider)
        // Set data
        var data = {};
        $.each(provider, function(key, value) {
            var provider_temp = [];
            $.each(value, function(zscore_name, zscore_value) {
                if (zscore_value.year == 2 && zscore_value.month == 0 && (zscore_value.id == 278 || zscore_value.id == 342)) {
                    provider_temp[zscore_value.month] = $.extend(provider_temp[zscore_value.month],zscore_value);
                } else {
                    provider_temp[zscore_value.month] = zscore_value;
                }
            });
            data[key] = provider_temp;
        });
        // process data ant prepare it for the chart
        var temp_count = 0;
        for (var providerName in data) {
            var providerData = data[providerName];
            // add data of one provider to temp array
            var tempArray = [];
            var count = 0;
            // add items
            var show_bullets = false;
            for (var itemName in providerData) {
                if (itemName != "quantity") {
                    count++;
                    // we generate unique category for each column (providerName + "_" + itemName) and store realName
                    if (temp_count == 59) {
                        show_bullets = true;
                    }
                    var item_name = itemName;
                    if ((temp_count == 61 || temp_count == 62) || item_name == 0) {
                        item_name = '';
                    }
                    itemName = itemName.split('.')[0];
                    var temp_percentile = {
                        category: providerName + "_" + itemName,
                        realName: item_name,
                        provider: providerName,
                        showBullets: show_bullets,
                    }
                    $.each(Object.keys(providerData[itemName]), function(key, value) {
                        if (value != 'month' && value != 'year' && value.indexOf('label_name') == -1 && value.indexOf('data_from') == -1 && value.indexOf('display_age') == -1) {
                            Object.assign(temp_percentile, {
                                [value]: providerData[itemName][value] > 0 ? parseFloat(providerData[itemName][value]) : null
                            });
                        } else if (value.indexOf('label_name') != -1 || value.indexOf('data_from') != -1 || value.indexOf('display_age') != -1) {
                            Object.assign(temp_percentile, {
                                [value]: providerData[itemName][value]
                            });                            
                        }
                    });
                    tempArray.push(temp_percentile);
                    temp_count++;
                }

            }
            console.log(tempArray)
            // add quantity and count to middle data item (line series uses it)
            var lineSeriesDataIndex = Math.floor(count / 2);
            tempArray[lineSeriesDataIndex].count = count;
            // push to the final data
            am5.array.each(tempArray, function(item) {
                chartData.push(item);
            });
            // create range (the additional label at the bottom)
            var range = xAxis.makeDataItem({});
            xAxis.createAxisRange(range);
            range.set("category", tempArray[0].category);
            range.set("endCategory", tempArray[tempArray.length - 1].category);
            var label = range.get("label");
            label.setAll({
                text: tempArray[0].provider,
                dy: 12,
                fontSize: 12,
                fontWeight: "bold",
                location: 0,
            });
            var tick = range.get("tick");
            tick.setAll({
                visible: true,
                stroke: '#000000',
                strokeWidth: 1,
                strokeOpacity: 1,
                length: 10,
                location: 0,
            });
            var grid = range.get("grid");
            grid.setAll({
                stroke: '#000000',
                strokeWidth: 1,
                strokeOpacity: 1,
            });
        }

        // add odd grid
        $.each(chartData, function(key, value) {
            var current_grid = key % 2;
            var stroke_color = '#D3D3D3';
            if (current_grid == 0) {
                stroke_color = '#a09ea0';
            }
            if (key != 61 && key != 62 && key % 12 != 0) {
                var range = xAxis.makeDataItem({});
                xAxis.createAxisRange(range);
                range.set("category", chartData[key].category);
                var grid = range.get("grid");
                grid.setAll({
                    stroke: stroke_color,
                    strokeOpacity: 1,
                });
            }
        })
        // add range for the last grid

        var range = xAxis.makeDataItem({});
        xAxis.createAxisRange(range);
        range.set("category", chartData[chartData.length - 1].category);
        var grid = range.get("grid");
        grid.setAll({
            stroke: '#BDBBBC',
            strokeOpacity: 1,
            location: 5
        });


        xAxis.data.setAll(chartData);
        xAxis1.data.setAll(chartData);
 
        sd3neglineSeriesPart1.data.setAll(chartData);
        sd2neglineSeriesPart1.data.setAll(chartData);
        sd1neglineSeriesPart1.data.setAll(chartData);
        sd0lineSeriesPart1.data.setAll(chartData);
        sd1lineSeriesPart1.data.setAll(chartData);
        sd2lineSeriesPart1.data.setAll(chartData);
        sd3lineSeriesPart1.data.setAll(chartData);

        sd3neglineSeriesPart2.data.setAll(chartData);
        sd2neglineSeriesPart2.data.setAll(chartData);
        sd1neglineSeriesPart2.data.setAll(chartData);
        sd0lineSeriesPart2.data.setAll(chartData);
        sd1lineSeriesPart2.data.setAll(chartData);
        sd2lineSeriesPart2.data.setAll(chartData);
        sd3lineSeriesPart2.data.setAll(chartData);
          

        
        dotSeries.data.setAll(chartData);

        for (var i = 1; i <= value_count; i++) {
            dotPlotSeries[i].data.setAll(chartData);
        }
        var range = xAxis.makeDataItem({});
        xAxis.createAxisRange(range);
        range.set("category", 'Birth_0');
        var label = range.get("label");
        label.setAll({
            text: "Months",
            dx: -55,
            dy: 0,
            fontSize: 10,
        });
        if (chart_name == 'Head Circumference (cm)') {
            for (i = min_y_value; i < max_y_value; i++) {
                var grid_value = i + 0.5;
                var range = yAxis.makeDataItem({
                    value: grid_value,
                });
                yAxis.createAxisRange(range);
                var grid = range.get("grid");
                grid.setAll({
                    stroke: '#C3BCBC',
                    strokeOpacity: 1,
                    strokeWidth: 1,
                    visible: true
                });
            }
        }
        // Make stuff animate on load
        // https://www.amcharts.com/docs/v5/concepts/animations/
        chart.appear(1000, 100);

    }
});