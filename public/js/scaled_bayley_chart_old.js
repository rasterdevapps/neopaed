$(document).ready(function() {

    var title_color = ['#5388C7', '#00B3A6', '#00A650', '#EB1752', '#F79320'];
    var color = ['#C5D2EC', '#BEE4DF', '#B3DDC0', '#F0BED8', '#FEDAB4'];
    var cg_scaled_score = $('input[name="cg_scaled_score"]').val();
    var rc_scaled_score = $('input[name="rc_scaled_score"]').val();
    var ec_scaled_score = $('input[name="ec_scaled_score"]').val();
    var fm_scaled_score = $('input[name="fm_scaled_score"]').val();
    var gm_scaled_score = $('input[name="gm_scaled_score"]').val();
    var se_scaled_score = $('input[name="se_scaled_score"]').val();
    var rec_scaled_score = $('input[name="rec_scaled_score"]').val();
    var exp_scaled_score = $('input[name="exp_scaled_score"]').val();
    var per_scaled_score = $('input[name="per_scaled_score"]').val();
    var ipr_scaled_score = $('input[name="ipr_scaled_score"]').val();
    var pla_scaled_score = $('input[name="pla_scaled_score"]').val();

    if (cg_scaled_score > 0 || rc_scaled_score > 0 || ec_scaled_score > 0 || fm_scaled_score > 0 || gm_scaled_score > 0 || se_scaled_score > 0 || rec_scaled_score > 0 || exp_scaled_score > 0 || per_scaled_score > 0 || ipr_scaled_score > 0 || pla_scaled_score > 0) {
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
        var root = am5.Root.new("scaled");

        // Set themes
        // https://www.amcharts.com/docs/v5/concepts/themes/
        root.setThemes([
            am5themes_Animated.new(root)
        ]);

        // Create chart
        // https://www.amcharts.com/docs/v5/charts/xy-chart/
        var chart = root.container.children.push(
            am5xy.XYChart.new(root, {
                panX: false,
                panY: false,
                wheelX: "none",
                wheelY: "none",
                paddingLeft: 0
            })
        );

        // Create axes
        // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
        var xRenderer = am5xy.AxisRendererX.new(root, {
            minGridDistance: 30
        });
        xRenderer.labels.template.setAll({
            text: "{realName}",
            inside: true,
            dx: -20,
            dy: -94,
            fontSize: 12
        });
        xRenderer.labels.template.set("rotation", -90);
        xRenderer.grid.template.setAll({
            strokeOpacity: 1
        });
        var xAxis = chart.xAxes.push(
            am5xy.CategoryAxis.new(root, {
                categoryField: "category",
                renderer: xRenderer,
                tooltip: false,
            })
        );

        var yRenderer = am5xy.AxisRendererY.new(root, {
            minGridDistance: 15,
        });
        yRenderer.grid.template.setAll({
            strokeOpacity: 0
        });
        yRenderer.labels.template.setAll({
            minPosition: 0.3,
            fontSize: 12
        });
        var yAxis = chart.yAxes.push(
            am5xy.ValueAxis.new(root, {
                min: -7,
                max: 19,
                strictMinMax: true,
                renderer: yRenderer,
            })
        );
        yAxis.children.moveValue(am5.Label.new(root, {
            text: 'Scaled\nscore',
            x: 20,
            y: am5.p100,
            dy: -40,
            paddingLeft: 0,
            paddingRight: 0,
            fontWeight: "600",
            fontSize: 11,
        }), 0);

        var yRenderer1 = am5xy.AxisRendererY.new(root, {
            minGridDistance: 15,
            opposite: true
        });
        yRenderer1.labels.template.setAll({
            minPosition: 0.3,
            fontSize: 12
        });
        yRenderer1.grid.template.set("forceHidden", true);
        var yAxis1 = chart.yAxes.push(
            am5xy.ValueAxis.new(root, {
                min: -7,
                max: 19,
                strictMinMax: true,
                renderer: yRenderer1,
            })
        );

        // Create series
        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
        var lineSeries = chart.series.push(
            am5xy.LineSeries.new(root, {
                name: "Series",
                xAxis: xAxis,
                yAxis: yAxis,
                yAxis: yAxis1,
                valueYField: "value",
                sequencedInterpolation: true,
                stroke: '#000000',
                fill: '#000000',
                categoryXField: "category",
                tooltip: false
            })
        );

        lineSeries.strokes.template.set("strokeWidth", 2);

        lineSeries.bullets.push(function() {
            return am5.Bullet.new(root, {
                sprite: am5.Circle.new(root, {
                    radius: 5,
                    fill: lineSeries.get("fill")
                })
            });
        });


        var series = chart.series.push(
            am5xy.LineSeries.new(root, {
                name: "Series",
                xAxis: xAxis,
                yAxis: yAxis,
                yAxis: yAxis1,
                valueYField: "temp",
                sequencedInterpolation: true,
                stroke: '#000000',
                fill: '#000000',
                categoryXField: "category",
                tooltip: false
            })
        );

        var lang = 0;
        var mot = 0;
        var soem = 0;
        var adbe = 0;

        series.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.provider == 'Cognitive\n(COG)') {
                return am5.Bullet.new(root, {
                    sprite: am5.Rectangle.new(root, {
                        width: 57,
                        height: 50,
                        dx: -30,
                        dy: -204.7,
                        fill: title_color[0],
                    })
                });
            }
            if (dataItem.dataContext.provider == 'Language\n(LANG)') {
                lang++;
                return am5.Bullet.new(root, {
                    sprite: am5.Rectangle.new(root, {
                        width: lang == 1 ? 57 : 55.5,
                        height: 50,
                        dx: -28,
                        dy: -204.7,
                        fill: title_color[1],
                    })
                });
            }
            if (dataItem.dataContext.provider == 'Motor\n(MOT)') {
                mot++;
                return am5.Bullet.new(root, {
                    sprite: am5.Rectangle.new(root, {
                        width: mot == 1 ? 57 : 55.5,
                        height: 50,
                        dx: -27.5,
                        dy: -204.7,
                        fill: title_color[2],
                    })
                });
            }
            if (dataItem.dataContext.provider == 'Social-\nEmotional\n(SOEM)') {
                soem++;
                return am5.Bullet.new(root, {
                    sprite: am5.Rectangle.new(root, {
                        width: 55,
                        height: 50,
                        dx: -27,
                        dy: -204.7,
                        fill: title_color[3],
                    })
                });
            }
            if (dataItem.dataContext.provider == 'Adaptive Behavior\n(ADBE)') {
                adbe++;
                return am5.Bullet.new(root, {
                    sprite: am5.Rectangle.new(root, {
                        width: adbe == 5 ? 54 : 57,
                        height: 50,
                        dx: -27,
                        dy: -204.7,
                        fill: title_color[4],
                    })
                });
            }
        });

        series.bullets.push(function(root, series, dataItem) {
            if (dataItem.dataContext.provider == 'Cognitive\n(COG)') {
                return am5.Bullet.new(root, {
                    sprite: am5.Rectangle.new(root, {
                        width: 54,
                        height: 29,
                        dx: -27,
                        dy: -30,
                        fill: '#FFFFFF',
                    })
                });
            }
            if (dataItem.dataContext.provider == 'Language\n(LANG)') {
                return am5.Bullet.new(root, {
                    sprite: am5.Rectangle.new(root, {
                        width: 54,
                        height: 29,
                        dx: -27,
                        dy: -30,
                        fill: '#FFFFFF',
                    })
                });
            }
            if (dataItem.dataContext.provider == 'Motor\n(MOT)') {
                return am5.Bullet.new(root, {
                    sprite: am5.Rectangle.new(root, {
                        width: 54,
                        height: 29,
                        dx: -27,
                        dy: -30,
                        fill: '#FFFFFF',
                    })
                });
            }
            if (dataItem.dataContext.provider == 'Social-\nEmotional\n(SOEM)') {
                return am5.Bullet.new(root, {
                    sprite: am5.Rectangle.new(root, {
                        width: 53,
                        height: 29,
                        dx: -27,
                        dy: -30,
                        fill: '#FFFFFF',
                    })
                });
            }
            if (dataItem.dataContext.provider == 'Adaptive Behavior\n(ADBE)') {
                return am5.Bullet.new(root, {
                    sprite: am5.Rectangle.new(root, {
                        width: 54,
                        height: 29,
                        dx: -27,
                        dy: -30,
                        fill: '#FFFFFF',
                    })
                });
            }
        });

        var chartData = [];

        // Set data
        var data = {
            "Cognitive\n(COG)": {
                "Cognitive (CG)": (cg_scaled_score > 0 ? cg_scaled_score : null)
            },
            "Language\n(LANG)": {
                "Receptive\nCommunication (RC)": (rc_scaled_score > 0 ? rc_scaled_score : null),
                "Expressive\nCommunication (EC)": (ec_scaled_score > 0 ? ec_scaled_score : null)
            },
            "Motor\n(MOT)": {
                "Fine Motor (FM)": (fm_scaled_score > 0 ? fm_scaled_score : null),
                "Gross Motor (GM)": (gm_scaled_score > 0 ? gm_scaled_score : null)
            },
            "Social-\nEmotional\n(SOEM)": {
                "Social-Emotional (SE)": (se_scaled_score > 0 ? se_scaled_score : null)
            },
            "Adaptive Behavior\n(ADBE)": {
                "Receptive (REC)": (rec_scaled_score > 0 ? rec_scaled_score : null),
                "Expressive (EXP)": (exp_scaled_score > 0 ? exp_scaled_score : null),
                "Personal (PER)": (per_scaled_score > 0 ? per_scaled_score : null),
                "Interpersonal\nRelationships (IPR)": (ipr_scaled_score > 0 ? ipr_scaled_score : null),
                "Play and\nLeisure (PLA)": (pla_scaled_score > 0 ? pla_scaled_score : null)
            }
        };

        var i = 0;
        // process data ant prepare it for the chart
        for (var providerName in data) {
            var providerData = data[providerName];

            // add data of one provider to temp array
            var tempArray = [];
            // add items
            for (var itemName in providerData) {
                // we generate unique category for each column (providerName + "_" + itemName) and store realName
                tempArray.push({
                    category: providerName + "_" + itemName,
                    realName: itemName,
                    value: providerData[itemName],
                    temp: -7,
                    provider: providerName
                });
            }

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
                dx: 0,
                dy: -208,
                fontWeight: "bold",
                tooltipText: tempArray[0].provider,
                rotation: 0,
                textAlign: "center",
                fill: '#FFFFFF'
            });

            var range = xAxis.createAxisRange(range);
            range.get("axisFill").setAll({
                fill: color[i],
                fillOpacity: 0.2,
                visible: true
            });
            i++;

        }

        // Value placing
        var range = xAxis.makeDataItem({});
        xAxis.createAxisRange(range);
        range.set("value", -7);
        var label = range.get("label");
        label.setAll({
            text: cg_scaled_score,
            dy: -27,
            dx: 25,
            fontWeight: "bold",
            rotation: 0,
        });

        var range = xAxis.makeDataItem({});
        xAxis.createAxisRange(range);
        range.set("value", -7);
        var label = range.get("label");
        label.setAll({
            text: rc_scaled_score,
            dy: -27,
            dx: 85,
            fontWeight: "bold",
            rotation: 0,
        });

        var range = xAxis.makeDataItem({});
        xAxis.createAxisRange(range);
        range.set("value", -7);
        var label = range.get("label");
        label.setAll({
            text: ec_scaled_score,
            dy: -27,
            dx: 140,
            fontWeight: "bold",
            rotation: 0,
        });

        var range = xAxis.makeDataItem({});
        xAxis.createAxisRange(range);
        range.set("value", -7);
        var label = range.get("label");
        label.setAll({
            text: fm_scaled_score,
            dy: -27,
            dx: 195,
            fontWeight: "bold",
            rotation: 0,
        });

        var range = xAxis.makeDataItem({});
        xAxis.createAxisRange(range);
        range.set("value", -7);
        var label = range.get("label");
        label.setAll({
            text: gm_scaled_score,
            dy: -27,
            dx: 250,
            fontWeight: "bold",
            rotation: 0,
        });

        var range = xAxis.makeDataItem({});
        xAxis.createAxisRange(range);
        range.set("value", -7);
        var label = range.get("label");
        label.setAll({
            text: se_scaled_score,
            dy: -27,
            dx: 310,
            fontWeight: "bold",
            rotation: 0,
        });

        var range = xAxis.makeDataItem({});
        xAxis.createAxisRange(range);
        range.set("value", -7);
        var label = range.get("label");
        label.setAll({
            text: rec_scaled_score,
            dy: -27,
            dx: 365,
            fontWeight: "bold",
            rotation: 0,
        });

        var range = xAxis.makeDataItem({});
        xAxis.createAxisRange(range);
        range.set("value", -7);
        var label = range.get("label");
        label.setAll({
            text: exp_scaled_score,
            dy: -27,
            dx: 420,
            fontWeight: "bold",
            rotation: 0,
        });

        var range = xAxis.makeDataItem({});
        xAxis.createAxisRange(range);
        range.set("value", -7);
        var label = range.get("label");
        label.setAll({
            text: per_scaled_score,
            dy: -27,
            dx: 475,
            fontWeight: "bold",
            rotation: 0,
        });

        var range = xAxis.makeDataItem({});
        xAxis.createAxisRange(range);
        range.set("value", -7);
        var label = range.get("label");
        label.setAll({
            text: ipr_scaled_score,
            dy: -27,
            dx: 535,
            fontWeight: "bold",
            rotation: 0,
        });

        var range = xAxis.makeDataItem({});
        xAxis.createAxisRange(range);
        range.set("value", -7);
        var label = range.get("label");
        label.setAll({
            text: pla_scaled_score,
            dy: -27,
            dx: 590,
            fontWeight: "bold",
            rotation: 0,
        });

        // x-grid
        var range = xAxis.makeDataItem({});
        xAxis.createAxisRange(range);
        range.set("category", chartData[0].category);
        var grid = range.get("grid");
        grid.setAll({
            stroke: '#000000',
            strokeOpacity: 1,
            location: 0
        });

        var range = xAxis.makeDataItem({});
        xAxis.createAxisRange(range);
        range.set("category", chartData[chartData.length - 1].category);
        var grid = range.get("grid");
        grid.setAll({
            stroke: '#000000',
            strokeOpacity: 1,
            location: 1
        });

        // y-grid
        var range = yAxis.makeDataItem({});
        yAxis.createAxisRange(range);
        range.set("value", -7);
        var grid = range.get("grid");
        grid.setAll({
            stroke: '#000000',
            strokeOpacity: 1,
            location: 1
        });

        var range = yAxis.makeDataItem({});
        yAxis.createAxisRange(range);
        range.set("value", -5.8);
        var grid = range.get("grid");
        grid.setAll({
            stroke: '#000000',
            strokeOpacity: 1,
            location: 1
        });

        var range = yAxis.makeDataItem({});
        yAxis.createAxisRange(range);
        range.set("value", -1);
        var grid = range.get("grid");
        grid.setAll({
            stroke: '#000000',
            strokeOpacity: 1,
            location: 1
        });

        var range = yAxis.makeDataItem({});
        yAxis.createAxisRange(range);
        range.set("value", 1);
        var grid = range.get("grid");
        grid.setAll({
            stroke: '#000000',
            strokeOpacity: 1,
            location: 1
        });

        var range = yAxis.makeDataItem({});
        yAxis.createAxisRange(range);
        range.set("value", 19);
        var grid = range.get("grid");
        grid.setAll({
            stroke: '#000000',
            strokeOpacity: 1
        });

        // temp range
        var rangeDataItem = yAxis.makeDataItem({
            value: 1,
            endValue: 19
        });
        var range = yAxis.createAxisRange(rangeDataItem);
        range.get("axisFill").setAll({
            fill: '#FFFFFF',
            fillOpacity: 0.2,
            visible: true
        });

        // Shaded range
        var rangeDataItem = yAxis.makeDataItem({
            value: 4
        });
        var range = yAxis.createAxisRange(rangeDataItem);
        range.get("axisFill").setAll({
            fill: '#EAEAEA',
            fillOpacity: 0.2,
            visible: true
        });

        var rangeDataItem = yAxis.makeDataItem({
            value: 7
        });
        var range = yAxis.createAxisRange(rangeDataItem);
        range.get("axisFill").setAll({
            fill: '#DDDDDD',
            fillOpacity: 0.2,
            visible: true
        });

        var rangeDataItem = yAxis.makeDataItem({
            value: 10
        });
        var range = yAxis.createAxisRange(rangeDataItem);
        range.get("axisFill").setAll({
            fill: '#C0C0C0',
            fillOpacity: 0.2,
            visible: true
        });

        var rangeDataItem = yAxis.makeDataItem({
            value: 13
        });
        var range = yAxis.createAxisRange(rangeDataItem);
        range.get("axisFill").setAll({
            fill: '#DDDDDD',
            fillOpacity: 0.2,
            visible: true
        });

        var rangeDataItem = yAxis.makeDataItem({
            value: 16
        });
        var range = yAxis.createAxisRange(rangeDataItem);
        range.get("axisFill").setAll({
            fill: '#EAEAEA',
            fillOpacity: 0.2,
            visible: true
        });

        xAxis.data.setAll(chartData);
        lineSeries.data.setAll(chartData);
        series.data.setAll(chartData);

        // Make stuff animate on load
        // https://www.amcharts.com/docs/v5/concepts/animations/
        chart.appear(1000, 100);
    }

});
