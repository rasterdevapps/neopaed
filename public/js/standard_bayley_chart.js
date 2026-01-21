$(document).ready(function() {

    var title_color = ['#5388C7', '#00B3A6', '#00A650', '#EB1752', '#F79320', '#F79320', '#F79320', '#F79320'];

    var cog = $('input[name="cog"]').val();
    var lang = $('input[name="lang"]').val();
    var mot = $('input[name="mot"]').val();
    var soem = $('input[name="soem"]').val();
    var com = $('input[name="com"]').val();
    var dls = $('input[name="dls"]').val();
    var soc = $('input[name="soc"]').val();
    var adbe = $('input[name="adbe"]').val();

    var cog_start = $('input[name="cog_start"]').val();
    var cog_end = $('input[name="cog_end"]').val();

    var lang_start = $('input[name="lang_start"]').val();
    var lang_end = $('input[name="lang_end"]').val();

    var mot_start = $('input[name="mot_start"]').val();
    var mot_end = $('input[name="mot_end"]').val();

    var soem_start = $('input[name="soem_start"]').val();
    var soem_end = $('input[name="soem_end"]').val();

    var mot_start = $('input[name="mot_start"]').val();
    var mot_end = $('input[name="mot_end"]').val();

    var com_start = $('input[name="com_start"]').val();
    var com_end = $('input[name="com_end"]').val();

    var dls_start = $('input[name="dls_start"]').val();
    var dls_end = $('input[name="dls_end"]').val();

    var soc_start = $('input[name="soc_start"]').val();
    var soc_end = $('input[name="soc_end"]').val();

    var adbe_start = $('input[name="adbe_start"]').val();
    var adbe_end = $('input[name="adbe_end"]').val();

    var confidence_interval = $('input[name="confidence_interval"]').val();

    var merge = false; 
    var standard_chart_1 = false;
    var standard_chart_2 = false;

    var bullet_width = 48;
    var bullet_height = 37;
    var bullet_dx = -24;
    var bullet_dy = -49.5;

    var bullet_2_width = 48;
    var bullet_2_height = 37.5;
    var bullet_2_dx = -24;
    var bullet_2_dy = -88.5;

    var value_dy = -70;
    var value_cog_dx = 23;
    var value_lang_dx = 75;
    var value_mot_dx = 125;

    var value_range_dy = -30;
    var value_range_cog_dx = 25;
    var value_range_lang_dx = 75;
    var value_range_mot_dx = 125;

    var bullet_type_2_width = 48;
    var bullet_type_2_height = 37;
    var bullet_type_2_dx = -24;
    var bullet_type_2_dy = -49.5;

    var bullet_type_2_2_width = 48;
    var bullet_type_2_2_height = 37.5;
    var bullet_type_2_2_dx = -24;
    var bullet_type_2_2_dy = -88.5;

    var bullet_type_2_value_dy = -70;
    var bullet_type_2_value_soem_dx = 175;
    var bullet_type_2_value_com_dx = 225;
    var bullet_type_2_value_dls_dx = 273;
    var bullet_type_2_value_soc_dx = 320;
    var bullet_type_2_value_adbe_dx = 375;

    var bullet_type_2_value_range_dy = -30;
    var bullet_type_2_value_range_soem_dx = 175;
    var bullet_type_2_value_range_com_dx = 225;
    var bullet_type_2_value_range_dls_dx = 275;
    var bullet_type_2_value_range_soc_dx = 326;
    var bullet_type_2_value_range_adbe_dx = 375;

    if (merge) {
        standard('standard');
    } else {
        if (cog > 0 || lang > 0 || mot > 0) {
            standard_chart_1 = true;
            bullet_width = 48;
            bullet_height = 37;
            bullet_dx = -24;
            bullet_dy = -49.5;
            bullet_2_width = 48;
            bullet_2_height = 37.5;
            bullet_2_dx = -24;
            bullet_2_dy = -88.5;
            value_dy = -70;
            value_cog_dx = 23;
            value_lang_dx = 75;
            value_mot_dx = 125;
            value_range_dy = -30;
            value_range_cog_dx = 25;
            value_range_lang_dx = 75;
            value_range_mot_dx = 125;
            standard('standard_chart_1');
        }
        if (soem > 0 || com > 0 || dls > 0 || soc > 0 || adbe > 0) {
            standard_chart_1 = false;
            standard_chart_2 = true;

            bullet_type_2_width = 48;
            bullet_type_2_height = 37;
            bullet_type_2_dx = -24;
            bullet_type_2_dy = -49.5;

            bullet_type_2_2_width = 48;
            bullet_type_2_2_height = 37.5;
            bullet_type_2_2_dx = -24;
            bullet_type_2_2_dy = -88.5;

            bullet_type_2_value_dy = -70;
            bullet_type_2_value_soem_dx = 23;
            bullet_type_2_value_com_dx = 75;
            bullet_type_2_value_dls_dx = 123;
            bullet_type_2_value_soc_dx = 175;
            bullet_type_2_value_adbe_dx = 225;

            bullet_type_2_value_range_dy = -30;
            bullet_type_2_value_range_soem_dx = 25;
            bullet_type_2_value_range_com_dx = 75;
            bullet_type_2_value_range_dls_dx = 125;
            bullet_type_2_value_range_soc_dx = 176;
            bullet_type_2_value_range_adbe_dx = 225;

            standard('standard_chart_2');
        }
    }

    function standard(chartdiv) {
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
        var s_root = am5.Root.new(chartdiv);

        // Set themes
        // https://www.amcharts.com/docs/v5/concepts/themes/
        s_root.setThemes([
            am5themes_Animated.new(s_root)
            ]);

        // Create chart
        // https://www.amcharts.com/docs/v5/charts/xy-chart/
        var s_chart = s_root.container.children.push(
            am5xy.XYChart.new(s_root, {
                panX: false,
                panY: false,
                wheelX: "none",
                wheelY: "none",
                paddingLeft: 0
            })
            );

        // Create axes
        // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
        var s_xRenderer = am5xy.AxisRendererX.new(s_root, {
            minGridDistance: 30
        });
        s_xRenderer.labels.template.setAll({
            text: "{realName}",
            textAlign: "left",
            inside: true,
            dx: -15,
            dy: -137,
            fill: '#FFFFFF',
            fontWeight: "600",
            fontSize: 12
        });
        s_xRenderer.labels.template.set("rotation", -90);
        s_xRenderer.grid.template.setAll({
            strokeOpacity: 1
        });
        var s_xAxis = s_chart.xAxes.push(
            am5xy.CategoryAxis.new(s_root, {
                categoryField: "category",
                renderer: s_xRenderer,
                tooltip: false,
            })
            );

        var s_yRenderer = am5xy.AxisRendererY.new(s_root, {
            minGridDistance: 25,
        });
        s_yRenderer.grid.template.setAll({
            strokeOpacity: 0
        });
        s_yRenderer.labels.template.setAll({
            minPosition: 0.3,
            fontSize: 12
        });
        var s_yAxis = s_chart.yAxes.push(
            am5xy.ValueAxis.new(s_root, {
                min: -12,
                max: 160,
                strictMinMax: true,
                renderer: s_yRenderer,
            })
            );
        s_yAxis.children.moveValue(am5.Label.new(s_root, {
            text: 'Standard\nscore',
            x: 25,
            y: am5.p100,
            dy: -75,
            paddingLeft: 0,
            paddingRight: 0,
            fontWeight: "600",
            fontSize: 11,
        }), 0);
        s_yAxis.children.push(am5.Label.new(s_root, {
            text: 'Conf int\n' + confidence_interval + '%',
            x: 30,
            y: am5.p100,
            dy: -40,
            paddingLeft: 0,
            paddingRight: 0,
            fontWeight: "600",
            fontSize: 11,
        }), 0);

        var s_yRenderer1 = am5xy.AxisRendererY.new(s_root, {
            minGridDistance: 25,
            opposite: true
        });
        s_yRenderer1.labels.template.setAll({
            minPosition: 0.3,
            fontSize: 12
        });
        s_yRenderer1.grid.template.set("forceHidden", true);
        var s_yAxis1 = s_chart.yAxes.push(
            am5xy.ValueAxis.new(s_root, {
                min: -12,
                max: 160,
                strictMinMax: true,
                renderer: s_yRenderer1,
            })
            );

        // Create series
        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
        var s_lineSeries = s_chart.series.push(
            am5xy.LineSeries.new(s_root, {
                name: "Series",
                xAxis: s_xAxis,
                yAxis: s_yAxis,
                yAxis: s_yAxis1,
                valueYField: "value",
                sequencedInterpolation: true,
                stroke: '#000000',
                fill: '#000000',
                categoryXField: "category",
                tooltip: false
            })
            );

        s_lineSeries.strokes.template.set("strokeWidth", 2);

        s_lineSeries.bullets.push(function() {
            return am5.Bullet.new(s_root, {
                sprite: am5.Circle.new(s_root, {
                    radius: 5,
                    fill: s_lineSeries.get("fill")
                })
            });
        });

        var stickSeries = s_chart.series.push(
            am5xy.ColumnSeries.new(s_root, {
                name: "Series 1",
                xAxis: s_xAxis,
                yAxis: s_yAxis,
                valueYField: "open",
                openValueYField: "close",
                categoryXField: "category",
                tooltip: am5.Tooltip.new(s_root, {
                    labelText: "{openValueY} - {valueY}"
                })
            }));
        stickSeries.columns.template.setAll({
            width: 2,
            stroke: '#000000',
            fill: '#000000',
        });


        var series = s_chart.series.push(
            am5xy.LineSeries.new(s_root, {
                name: "Series",
                xAxis: s_xAxis,
                yAxis: s_yAxis,
                valueYField: "temp",
                sequencedInterpolation: true,
                stroke: '#000000',
                fill: '#000000',
                categoryXField: "category",
                tooltip: false
            })
            );

        // conf in bg
        if (standard_chart_1) {
            console.log('>>>>>>>>>>');
            series.bullets.push(function(s_root, series, dataItem) {
                if (dataItem.dataContext.provider == 'Cognitive (COG)') {
                    return am5.Bullet.new(s_root, {
                        sprite: am5.Rectangle.new(s_root, {
                            width: bullet_width,
                            height: bullet_height,
                            dx: bullet_dx,
                            dy: bullet_dy,
                            fill: '#FFFFFF',
                        })
                    });
                }
                if (dataItem.dataContext.provider == 'Language (LANG)') {
                    return am5.Bullet.new(s_root, {
                        sprite: am5.Rectangle.new(s_root, {
                            width: bullet_width,
                            height: bullet_height,
                            dx: bullet_dx,
                            dy: bullet_dy,
                            fill: '#FFFFFF',
                        })
                    });
                }
                if (dataItem.dataContext.provider == 'Motor (MOT)') {
                    return am5.Bullet.new(s_root, {
                        sprite: am5.Rectangle.new(s_root, {
                            width: bullet_width,
                            height: bullet_height,
                            dx: bullet_dx,
                            dy: bullet_dy,
                            fill: '#FFFFFF',
                        })
                    });
                }
            });
        }
        if (standard_chart_2) {
            series.bullets.push(function(s_root, series, dataItem) {
                if (dataItem.dataContext.provider == 'Social-Emotional\n(SOEM)') {
                    return am5.Bullet.new(s_root, {
                        sprite: am5.Rectangle.new(s_root, {
                            width: bullet_type_2_width,
                            height: bullet_type_2_height,
                            dx: bullet_type_2_dx,
                            dy: bullet_type_2_dy,
                            fill: '#FFFFFF',
                        })
                    });
                }
                if (dataItem.dataContext.provider == 'Communication\n(COM)') {
                    return am5.Bullet.new(s_root, {
                        sprite: am5.Rectangle.new(s_root, {
                            width: bullet_type_2_width,
                            height: bullet_type_2_height,
                            dx: bullet_type_2_dx,
                            dy: bullet_type_2_dy,
                            fill: '#FFFFFF',
                        })
                    });
                }
                if (dataItem.dataContext.provider == 'Daily Living Skills\n(DLS)') {
                    return am5.Bullet.new(s_root, {
                        sprite: am5.Rectangle.new(s_root, {
                            width: bullet_type_2_width,
                            height: bullet_type_2_height,
                            dx: bullet_type_2_dx,
                            dy: bullet_type_2_dy,
                            fill: '#FFFFFF',
                        })
                    });
                }
                if (dataItem.dataContext.provider == 'Socialization\n(SOC)') {
                    return am5.Bullet.new(s_root, {
                        sprite: am5.Rectangle.new(s_root, {
                            width: bullet_type_2_width,
                            height: bullet_type_2_height,
                            dx: bullet_type_2_dx,
                            dy: bullet_type_2_dy,
                            fill: '#FFFFFF',
                        })
                    });
                }
                if (dataItem.dataContext.provider == 'Adaptive Behavior\n(ADBE)') {
                    return am5.Bullet.new(s_root, {
                        sprite: am5.Rectangle.new(s_root, {
                            width: bullet_type_2_width,
                            height: bullet_type_2_height,
                            dx: bullet_type_2_dx,
                            dy: bullet_type_2_dy,
                            fill: '#FFFFFF',
                        })
                    });
                }
            });
        }

        // standard score bg
        if (standard_chart_1) {
            series.bullets.push(function(s_root, series, dataItem) {
                if (dataItem.dataContext.provider == 'Cognitive (COG)') {
                    return am5.Bullet.new(s_root, {
                        sprite: am5.Rectangle.new(s_root, {
                            width: bullet_2_width,
                            height: bullet_2_height,
                            dx: bullet_2_dx,
                            dy: bullet_2_dy,
                            fill: '#FFFFFF',
                        })
                    });
                }
                if (dataItem.dataContext.provider == 'Language (LANG)') {
                    return am5.Bullet.new(s_root, {
                        sprite: am5.Rectangle.new(s_root, {
                            width: bullet_2_width,
                            height: bullet_2_height,
                            dx: bullet_2_dx,
                            dy: bullet_2_dy,
                            fill: '#FFFFFF',
                        })
                    });
                }
                if (dataItem.dataContext.provider == 'Motor (MOT)') {
                    return am5.Bullet.new(s_root, {
                        sprite: am5.Rectangle.new(s_root, {
                            width: bullet_2_width,
                            height: bullet_2_height,
                            dx: bullet_2_dx,
                            dy: bullet_2_dy,
                            fill: '#FFFFFF',
                        })
                    });
                }
            });
        }
        if (standard_chart_2) {
            series.bullets.push(function(s_root, series, dataItem) {
                if (dataItem.dataContext.provider == 'Social-Emotional\n(SOEM)') {
                    return am5.Bullet.new(s_root, {
                        sprite: am5.Rectangle.new(s_root, {
                            width: bullet_type_2_2_width,
                            height: bullet_type_2_2_height,
                            dx: bullet_type_2_2_dx,
                            dy: bullet_type_2_2_dy,
                            fill: '#FFFFFF',
                        })
                    });
                }
                if (dataItem.dataContext.provider == 'Communication\n(COM)') {
                    return am5.Bullet.new(s_root, {
                        sprite: am5.Rectangle.new(s_root, {
                            width: bullet_type_2_2_width,
                            height: bullet_type_2_2_height,
                            dx: bullet_type_2_2_dx,
                            dy: bullet_type_2_2_dy,
                            fill: '#FFFFFF',
                        })
                    });
                }
                if (dataItem.dataContext.provider == 'Daily Living Skills\n(DLS)') {
                    return am5.Bullet.new(s_root, {
                        sprite: am5.Rectangle.new(s_root, {
                            width: bullet_type_2_2_width,
                            height: bullet_type_2_2_height,
                            dx: bullet_type_2_2_dx,
                            dy: bullet_type_2_2_dy,
                            fill: '#FFFFFF',
                        })
                    });
                }
                if (dataItem.dataContext.provider == 'Socialization\n(SOC)') {
                    return am5.Bullet.new(s_root, {
                        sprite: am5.Rectangle.new(s_root, {
                            width: bullet_type_2_2_width,
                            height: bullet_type_2_2_height,
                            dx: bullet_type_2_2_dx,
                            dy: bullet_type_2_2_dy,
                            fill: '#FFFFFF',
                        })
                    });
                }
                if (dataItem.dataContext.provider == 'Adaptive Behavior\n(ADBE)') {
                    return am5.Bullet.new(s_root, {
                        sprite: am5.Rectangle.new(s_root, {
                            width: bullet_type_2_2_width,
                            height: bullet_type_2_2_height,
                            dx: bullet_type_2_2_dx,
                            dy: bullet_type_2_2_dy,
                            fill: '#FFFFFF',
                        })
                    });
                }
            });
        }

        var s_chartData = [];

        if (merge) {
            // Set data
            var s_data = {
                "Cognitive (COG)": (cog > 0 ? cog : null),
                "Language (LANG)": (lang > 0 ? lang : null),
                "Motor (MOT)": (mot > 0 ? mot : null),
                "Social-Emotional\n(SOEM)": (soem > 0 ? soem : null),
                "Communication\n(COM)": (com > 0 ? com : null),
                "Daily Living Skills\n(DLS)": (dls > 0 ? dls : null),
                "Socialization\n(SOC)": (soc > 0 ? soc : null),
                "Adaptive Behavior\n(ADBE)": (adbe > 0 ? adbe : null)
            };
        } else {
            if (standard_chart_1) {
                var s_data = {
                    "Cognitive (COG)": (cog > 0 ? cog : null),
                    "Language (LANG)": (lang > 0 ? lang : null),
                    "Motor (MOT)": (mot > 0 ? mot : null),
                };
            }
            if (standard_chart_2) {
                var s_data = {
                    "Social-Emotional\n(SOEM)": (soem > 0 ? soem : null),
                    "Communication\n(COM)": (com > 0 ? com : null),
                    "Daily Living Skills\n(DLS)": (dls > 0 ? dls : null),
                    "Socialization\n(SOC)": (soc > 0 ? soc : null),
                    "Adaptive Behavior\n(ADBE)": (adbe > 0 ? adbe : null)
                };
            }
        }

        // process data ant prepare it for the chart
        if (merge) {
            var i = 0;
            $.each(s_data, function(s_providerName, s_value) {
                var open = 0;
                var close = 0;
                if (i == 0) {
                    open = (cog_start > 0 ? cog_start : null);
                    close = (cog_end > 0 ? cog_end : null);
                } else if (i == 1) {
                    open = (lang_start > 0 ? lang_start : null);
                    close = (lang_end > 0 ? lang_end : null);
                } else if (i == 2) {
                    open = (mot_start > 0 ? mot_start : null);
                    close = (mot_end > 0 ? mot_end : null);
                } else if (i == 3) {
                    open = (soem_start > 0 ? soem_start : null);
                    close = (soem_end > 0 ? soem_end : null);
                } else if (i == 4) {
                    open = (com_start > 0 ? com_start : null);
                    close = (com_end > 0 ? com_end : null);
                } else if (i == 5) {
                    open = (dls_start > 0 ? dls_start : null);
                    close = (dls_end > 0 ? dls_end : null);
                } else if (i == 6) {
                    open = (soc_start > 0 ? soc_start : null);
                    close = (soc_end > 0 ? soc_end : null);
                } else if (i == 7) {
                    open = (adbe_start > 0 ? adbe_start : null);
                    close = (adbe_end > 0 ? adbe_end : null);
                }

                var s_tempArray = [];
                s_tempArray.push({
                    category: s_providerName,
                    realName: s_providerName,
                    value: s_value,
                    open: open,
                    close: close,
                    temp: -15,
                    provider: s_providerName
                });

                am5.array.each(s_tempArray, function(item) {
                    s_chartData.push(item);
                });

            // create range (the additional label at the bottom)
                var s_range = s_xAxis.makeDataItem({});
                s_xAxis.createAxisRange(s_range);

                s_range.set("category", s_tempArray[0].category);
                s_range.set("endCategory", s_tempArray[s_tempArray.length - 1].category);

                var s_range = s_xAxis.createAxisRange(s_range);
                s_range.get("axisFill").setAll({
                    fill: title_color[i],
                    fillOpacity: 0.2,
                    visible: true
                });
                i++;
            });
        } else {
            if (standard_chart_1) {
                var i = 0;
                $.each(s_data, function(s_providerName, s_value) {
                    var open = 0;
                    var close = 0;
                    if (i == 0) {
                        open = (cog_start > 0 ? cog_start : null);
                        close = (cog_end > 0 ? cog_end : null);
                    } else if (i == 1) {
                        open = (lang_start > 0 ? lang_start : null);
                        close = (lang_end > 0 ? lang_end : null);
                    } else if (i == 2) {
                        open = (mot_start > 0 ? mot_start : null);
                        close = (mot_end > 0 ? mot_end : null);
                    }

                    var s_tempArray = [];
                    s_tempArray.push({
                        category: s_providerName,
                        realName: s_providerName,
                        value: s_value,
                        open: open,
                        close: close,
                        temp: -15,
                        provider: s_providerName
                    });

                    am5.array.each(s_tempArray, function(item) {
                        s_chartData.push(item);
                    });

            // create range (the additional label at the bottom)
                    var s_range = s_xAxis.makeDataItem({});
                    s_xAxis.createAxisRange(s_range);

                    s_range.set("category", s_tempArray[0].category);
                    s_range.set("endCategory", s_tempArray[s_tempArray.length - 1].category);

                    var s_range = s_xAxis.createAxisRange(s_range);
                    s_range.get("axisFill").setAll({
                        fill: title_color[i],
                        fillOpacity: 0.2,
                        visible: true
                    });
                    i++;
                });
            }
            if (standard_chart_2) {
                var i = 3;
                $.each(s_data, function(s_providerName, s_value) {
                    var open = 0;
                    var close = 0;
                    if (i == 3) {
                        open = (soem_start > 0 ? soem_start : null);
                        close = (soem_end > 0 ? soem_end : null);
                    } else if (i == 4) {
                        open = (com_start > 0 ? com_start : null);
                        close = (com_end > 0 ? com_end : null);
                    } else if (i == 5) {
                        open = (dls_start > 0 ? dls_start : null);
                        close = (dls_end > 0 ? dls_end : null);
                    } else if (i == 6) {
                        open = (soc_start > 0 ? soc_start : null);
                        close = (soc_end > 0 ? soc_end : null);
                    } else if (i == 7) {
                        open = (adbe_start > 0 ? adbe_start : null);
                        close = (adbe_end > 0 ? adbe_end : null);
                    }

                    var s_tempArray = [];
                    s_tempArray.push({
                        category: s_providerName,
                        realName: s_providerName,
                        value: s_value,
                        open: open,
                        close: close,
                        temp: -15,
                        provider: s_providerName
                    });

                    am5.array.each(s_tempArray, function(item) {
                        s_chartData.push(item);
                    });

            // create range (the additional label at the bottom)
                    var s_range = s_xAxis.makeDataItem({});
                    s_xAxis.createAxisRange(s_range);

                    s_range.set("category", s_tempArray[0].category);
                    s_range.set("endCategory", s_tempArray[s_tempArray.length - 1].category);

                    var s_range = s_xAxis.createAxisRange(s_range);
                    s_range.get("axisFill").setAll({
                        fill: title_color[i],
                        fillOpacity: 0.2,
                        visible: true
                    });
                    i++;
                });
            }
        }

        // Value placing
        if (standard_chart_1 && !standard_chart_2) {
            var s_range = s_xAxis.makeDataItem({});
            s_xAxis.createAxisRange(s_range);
            s_range.set("value", -12);
            var s_label = s_range.get("label");
            s_label.setAll({
                text: cog,
                dy: value_dy,
                dx: value_cog_dx,
                fontWeight: "bold",
                rotation: 0,
                fill: "#000000"
            });

            var s_range = s_xAxis.makeDataItem({});
            s_xAxis.createAxisRange(s_range);
            s_range.set("value", -12);
            var s_label = s_range.get("label");
            s_label.setAll({
                text: lang,
                dy: value_dy,
                dx: value_lang_dx,
                fontWeight: "bold",
                rotation: 0,
                fill: "#000000"
            });

            var s_range = s_xAxis.makeDataItem({});
            s_xAxis.createAxisRange(s_range);
            s_range.set("value", -12);
            var s_label = s_range.get("label");
            s_label.setAll({
                text: mot,
                dy: value_dy,
                dx: value_mot_dx,
                fontWeight: "bold",
                rotation: 0,
                fill: "#000000"
            });


            var s_range = s_xAxis.makeDataItem({});
            s_xAxis.createAxisRange(s_range);
            s_range.set("value", -12);
            var s_label = s_range.get("label");
            s_label.setAll({
                text: cog_start + ' - ' + cog_end,
                dy: value_range_dy,
                dx: value_range_cog_dx,
                fontWeight: "bold",
                rotation: 0,
                fill: "#000000"
            });

            var s_range = s_xAxis.makeDataItem({});
            s_xAxis.createAxisRange(s_range);
            s_range.set("value", -12);
            var s_label = s_range.get("label");
            s_label.setAll({
                text: lang_start + ' - ' + lang_end,
                dy: value_range_dy,
                dx: value_range_lang_dx,
                fontWeight: "bold",
                rotation: 0,
                fill: "#000000"
            });

            var s_range = s_xAxis.makeDataItem({});
            s_xAxis.createAxisRange(s_range);
            s_range.set("value", -12);
            var s_label = s_range.get("label");
            s_label.setAll({
                text: mot_start + ' - ' + mot_end,
                dy: value_range_dy,
                dx: value_range_mot_dx,
                fontWeight: "bold",
                rotation: 0,
                fill: "#000000"
            });

        }

        if (standard_chart_2) {
            var s_range = s_xAxis.makeDataItem({});
            s_xAxis.createAxisRange(s_range);
            s_range.set("value", -12);
            var s_label = s_range.get("label");
            s_label.setAll({
                text: soem,
                dy: bullet_type_2_value_dy,
                dx: bullet_type_2_value_soem_dx,
                fontWeight: "bold",
                rotation: 0,
                fill: "#000000"
            });

            var s_range = s_xAxis.makeDataItem({});
            s_xAxis.createAxisRange(s_range);
            s_range.set("value", -12);
            var s_label = s_range.get("label");
            s_label.setAll({
                text: com,
                dy: bullet_type_2_value_dy,
                dx: bullet_type_2_value_com_dx,
                fontWeight: "bold",
                rotation: 0,
                fill: "#000000"
            });

            var s_range = s_xAxis.makeDataItem({});
            s_xAxis.createAxisRange(s_range);
            s_range.set("value", -12);
            var s_label = s_range.get("label");
            s_label.setAll({
                text: dls,
                dy: bullet_type_2_value_dy,
                dx: bullet_type_2_value_dls_dx,
                fontWeight: "bold",
                rotation: 0,
                fill: "#000000"
            });

            var s_range = s_xAxis.makeDataItem({});
            s_xAxis.createAxisRange(s_range);
            s_range.set("value", -12);
            var s_label = s_range.get("label");
            s_label.setAll({
                text: soc,
                dy: bullet_type_2_value_dy,
                dx: bullet_type_2_value_soc_dx,
                fontWeight: "bold",
                rotation: 0,
                fill: "#000000"
            });

            var s_range = s_xAxis.makeDataItem({});
            s_xAxis.createAxisRange(s_range);
            s_range.set("value", -12);
            var s_label = s_range.get("label");
            s_label.setAll({
                text: adbe,
                dy: bullet_type_2_value_dy,
                dx: bullet_type_2_value_adbe_dx,
                fontWeight: "bold",
                rotation: 0,
                fill: "#000000"
            });

            

            var s_range = s_xAxis.makeDataItem({});
            s_xAxis.createAxisRange(s_range);
            s_range.set("value", -12);
            var s_label = s_range.get("label");
            s_label.setAll({
                text: soem_start + ' - ' + soem_end,
                dy: bullet_type_2_value_range_dy,
                dx: bullet_type_2_value_range_soem_dx,
                fontWeight: "bold",
                rotation: 0,
                fill: "#000000"
            });

            var s_range = s_xAxis.makeDataItem({});
            s_xAxis.createAxisRange(s_range);
            s_range.set("value", -12);
            var s_label = s_range.get("label");
            s_label.setAll({
                text: com_start + ' - ' + com_end,
                dy: bullet_type_2_value_range_dy,
                dx: bullet_type_2_value_range_com_dx,
                fontWeight: "bold",
                rotation: 0,
                fill: "#000000"
            });

            var s_range = s_xAxis.makeDataItem({});
            s_xAxis.createAxisRange(s_range);
            s_range.set("value", -12);
            var s_label = s_range.get("label");
            s_label.setAll({
                text: dls_start + ' - ' + dls_end,
                dy: bullet_type_2_value_range_dy,
                dx: bullet_type_2_value_range_dls_dx,
                fontWeight: "bold",
                rotation: 0,
                fill: "#000000"
            });

            var s_range = s_xAxis.makeDataItem({});
            s_xAxis.createAxisRange(s_range);
            s_range.set("value", -12);
            var s_label = s_range.get("label");
            s_label.setAll({
                text: soc_start + ' - ' + soc_end,
                dy: bullet_type_2_value_range_dy,
                dx: bullet_type_2_value_range_soc_dx,
                fontWeight: "bold",
                rotation: 0,
                fill: "#000000"
            });

            var s_range = s_xAxis.makeDataItem({});
            s_xAxis.createAxisRange(s_range);
            s_range.set("value", -12);
            var s_label = s_range.get("label");
            s_label.setAll({
                text: adbe_start + ' - ' + adbe_end,
                dy: bullet_type_2_value_range_dy,
                dx: bullet_type_2_value_range_adbe_dx,
                fontWeight: "bold",
                rotation: 0,
                fill: "#000000"
            });
        }

        // x-grid
        var s_range = s_xAxis.makeDataItem({});
        s_xAxis.createAxisRange(s_range);
        s_range.set("category", s_chartData[0].category);
        var s_grid = s_range.get("grid");
        s_grid.setAll({
            stroke: '#000000',
            strokeOpacity: 1,
            location: 0
        });

        var s_range = s_xAxis.makeDataItem({});
        s_xAxis.createAxisRange(s_range);
        s_range.set("category", s_chartData[s_chartData.length - 1].category);
        var s_grid = s_range.get("grid");
        s_grid.setAll({
            stroke: '#000000',
            strokeOpacity: 1,
            location: 1
        });

        // y-grid
        var s_range = s_yAxis.makeDataItem({});
        s_yAxis.createAxisRange(s_range);
        s_range.set("value", -12);
        var s_grid = s_range.get("grid");
        s_grid.setAll({
            stroke: '#000000',
            strokeOpacity: 1,
            location: 1
        });

        var s_range = s_yAxis.makeDataItem({});
        s_yAxis.createAxisRange(s_range);
        s_range.set("value", -2);
        var s_grid = s_range.get("grid");
        s_grid.setAll({
            stroke: '#000000',
            strokeOpacity: 1,
            location: 1
        });

        var s_range = s_yAxis.makeDataItem({});
        s_yAxis.createAxisRange(s_range);
        s_range.set("value", 8);
        var s_grid = s_range.get("grid");
        s_grid.setAll({
            stroke: '#000000',
            strokeOpacity: 1,
            location: 1
        });

        var s_range = s_yAxis.makeDataItem({});
        s_yAxis.createAxisRange(s_range);
        s_range.set("value", 40);
        var s_grid = s_range.get("grid");
        s_grid.setAll({
            stroke: '#000000',
            strokeOpacity: 1,
            location: 1
        });

        var s_range = s_yAxis.makeDataItem({});
        s_yAxis.createAxisRange(s_range);
        s_range.set("value", 160);
        var s_grid = s_range.get("grid");
        s_grid.setAll({
            stroke: '#000000',
            strokeOpacity: 1
        });

        // temp range
        var s_rangeDataItem = s_yAxis.makeDataItem({
            value: 40,
            endValue: 160
        });
        var s_range = s_yAxis.createAxisRange(s_rangeDataItem);
        s_range.get("axisFill").setAll({
            fill: '#FFFFFF',
            fillOpacity: 0.2,
            visible: true
        });

        // Shaded range
        var s_rangeDataItem = s_yAxis.makeDataItem({
            value: 55,
            endValue: 70
        });
        var s_range = s_yAxis.createAxisRange(s_rangeDataItem);
        s_range.get("axisFill").setAll({
            fill: '#EAEAEA',
            fillOpacity: 0.2,
            visible: true
        });

        var s_rangeDataItem = s_yAxis.makeDataItem({
            value: 70,
            endValue: 85
        });
        var s_range = s_yAxis.createAxisRange(s_rangeDataItem);
        s_range.get("axisFill").setAll({
            fill: '#DDDDDD',
            fillOpacity: 0.2,
            visible: true
        });

        var s_rangeDataItem = s_yAxis.makeDataItem({
            value: 85,
            endValue: 115
        });
        var s_range = s_yAxis.createAxisRange(s_rangeDataItem);
        s_range.get("axisFill").setAll({
            fill: '#C0C0C0',
            fillOpacity: 0.2,
            visible: true
        });

        var s_rangeDataItem = s_yAxis.makeDataItem({
            value: 115,
            endValue: 130
        });
        var s_range = s_yAxis.createAxisRange(s_rangeDataItem);
        s_range.get("axisFill").setAll({
            fill: '#DDDDDD',
            fillOpacity: 0.2,
            visible: true
        });

        var s_rangeDataItem = s_yAxis.makeDataItem({
            value: 130,
            endValue: 145
        });
        var s_range = s_yAxis.createAxisRange(s_rangeDataItem);
        s_range.get("axisFill").setAll({
            fill: '#EAEAEA',
            fillOpacity: 0.2,
            visible: true
        });

        s_xAxis.data.setAll(s_chartData);
        s_lineSeries.data.setAll(s_chartData);
        series.data.setAll(s_chartData);
        stickSeries.data.setAll(s_chartData);

        // Make stuff animate on load
        // https://www.amcharts.com/docs/v5/concepts/animations/
        s_chart.appear(1000, 100);
    }
});
