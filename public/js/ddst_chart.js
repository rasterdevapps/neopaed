var root;
var chart;
var fill_column_id = null;
var unfill_column_id = null;
var current_task_id = null;
$(document).on('change', 'input[name="ddst_age"]', function() {
    if (typeof root !== 'undefined') {
        root.dispose();
        chart.dispose();
    }

    var ddst_age = $(this).val();

    var baby_id = $('input[name="baby_id"]').val();
    var neuro_visit_id = $('input[name="id"]').val();
    var op_date = $('input[name="visit_date"]').val();

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
    root = am5.Root.new("chartdiv");
    root.dateFormatter.setAll({
        dateFormat: "yyyy-MM-dd",
        dateFields: ["valueX", "openValueX"]
    });
    // Set themes
    // https://www.amcharts.com/docs/v5/concepts/themes/
    root.setThemes([
        // am5themes_Animated.new(root)
        ]);
    // Create chart
    // https://www.amcharts.com/docs/v5/charts/xy-chart/
    chart = root.container.children.push(am5xy.XYChart.new(root, {
        panX: false,
        panY: false,
        wheelX: "none",
        wheelY: "none",
        layout: root.verticalLayout
    }));
    chart.plotContainer.get("background").setAll({
        stroke: '#000000',
        strokeOpacity: 3,
        fill: '#FFFFFF',
        fillOpacity: 1,
    });
    chart.set("background", am5.Rectangle.new(root, {
        fill: '#FFFFFF',
        fillOpacity: 1
    }));

    // Add legend
    // https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
    var legend = chart.children.push(am5.Legend.new(root, {
        centerX: am5.p50,
        x: am5.p50
    }))
    var colors = chart.get("colors");
    // Data
    var data = JSON.parse($('input[name="ddst_settings"]').val());
    // Create axes
    // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
    var xRenderer = am5xy.AxisRendererX.new(root, {
        minGridDistance: 1,
    });
    xRenderer.labels.template.setAll({
        fill: '#FFFFFF',
    });
    xRenderer.grid.template.setAll({
        strokeOpacity: 0,
        strokeWidth: 0
    });
    var xAxis = chart.xAxes.push(am5xy.ValueAxis.new(root, {
        min: 0,
        max: 40,
        strictMinMax: true,
        maxPrecision: 0,
        renderer: xRenderer,
    }));
    var yRenderer = am5xy.AxisRendererY.new(root, {
        minGridDistance: 1,
    });
    var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
        min: 0,
        max: 65,
        renderer: yRenderer,
        maxPrecision: 0,
        tooltip: am5.Tooltip.new(root, {})
    }));
    yRenderer.grid.template.set("forceHidden", true);
    yRenderer.labels.template.set("forceHidden", true);
    yAxis.children.moveValue(am5.Label.new(root, {
        text: 'GROSS MOTOR',
        rotation: -90,
        y: am5.p100,
        x: am5.percent(60),
        dx: 20,
        fontSize: 14,
        paddingTop: 0,
        paddingBottom: 0
    }), 0);
    yAxis.children.unshift(am5.Label.new(root, {
        text: 'LANGUAGE',
        rotation: -90,
        y: am5.percent(83),
        x: am5.percent(60),
        dx: 20,
        fontSize: 14,
        paddingTop: 0,
        paddingBottom: 0
    }), 0);
    yAxis.children.moveValue(am5.Label.new(root, {
        text: 'FINE MOTOR - ADAPTIVE',
        rotation: -90,
        y: am5.percent(62),
        x: am5.percent(60),
        dx: 20,
        fontSize: 14,
        paddingTop: 0,
        paddingBottom: 0
    }), 0);
    yAxis.children.moveValue(am5.Label.new(root, {
        text: 'PERSONAL - SOCIAL',
        rotation: -90,
        y: am5.percent(40),
        x: am5.percent(60),
        dx: 20,
        fontSize: 14,
        paddingTop: 0,
        paddingBottom: 0
    }), 0);
    var xRenderer2 = am5xy.AxisRendererX.new(root, {
        minGridDistance: 1,
        opposite: true,
    });
    xRenderer2.labels.template.setAll({
        fill: '#FFFFFF',
    });
    xRenderer2.grid.template.set("forceHidden", true);
    var xAxis2 = chart.yAxes.push(am5xy.ValueAxis.new(root, {
        min: 0,
        max: 40,
        strictMinMax: true,
        maxPrecision: 0,
        renderer: xRenderer2
    }));
    // Add series
    // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
    var series = chart.series.push(am5xy.ColumnSeries.new(root, {
        name: "Value Series",
        xAxis: xAxis,
        yAxis: yAxis,
        openValueXField: "value",
        valueXField: "endValue",
        openValueYField: "yvalue",
        valueYField: "yendValue",
        sequencedInterpolation: true,
    }));
    series.columns.template.setAll({
        templateField: "columnSettings",
        strokeOpacity: 0,
    });
    series.bullets.push(function(root, series, dataItem) {
        return am5.Bullet.new(root, {
            sprite: am5.Label.new(root, {
                text: "{task}",
                centerY: am5.p50,
                centerX: am5.p15,
                dx: dataItem.dataContext.taskalign,
                populateText: true,
                fontSize: 8.5,
                textAlign: "left",
                fontWeight: "bold",
            })
        });
    });
    series.bullets.push(function(root, series, dataItem) {
        if (dataItem.dataContext.taskid == 126 && dataItem.dataContext.task == null) {
            return am5.Bullet.new(root, {
                sprite: am5.Label.new(root, {
                    text: "Percent of children passing",
                    centerY: am5.p100,
                    centerX: am5.p50,
                    populateText: true,
                    fontSize: 9,
                    textAlign: "center",
                    fontWeight: "bold",
                    paddingBottom: 35,
                    paddingRight: 70
                })
            });
        }
    });
    series.bullets.push(function(root, series, dataItem) {
        if (dataItem.dataContext.taskid == 126 && dataItem.dataContext.task == null) {
            return am5.Bullet.new(root, {
                sprite: am5.Label.new(root, {
                    text: "May pass by report",
                    centerY: am5.p50,
                    centerX: am5.p100,
                    populateText: true,
                    fontSize: 9,
                    textAlign: "center",
                    fontWeight: "bold",
                    paddingBottom: 25,
                    paddingRight: 110
                })
            });
        }
    });
    series.bullets.push(function(root, series, dataItem) {
        if (dataItem.dataContext.taskid == 126 && dataItem.dataContext.task == null) {
            return am5.Bullet.new(root, {
                sprite: am5.Label.new(root, {
                    text: "→",
                    centerY: am5.p50,
                    centerX: am5.p100,
                    populateText: true,
                    fontSize: 24,
                    textAlign: "center",
                    fontWeight: "bold",
                    paddingBottom: 35,
                    paddingRight: 80
                })
            });
        }
    });
    series.bullets.push(function(root, series, dataItem) {
        if (dataItem.dataContext.taskid == 126 && dataItem.dataContext.task == null) {
            return am5.Bullet.new(root, {
                sprite: am5.Label.new(root, {
                    text: "Footnote no.\n(See back of form)",
                    centerY: am5.p50,
                    centerX: am5.p100,
                    populateText: true,
                    fontSize: 9,
                    fontWeight: "bold",
                    paddingTop: 35,
                    paddingRight: 110
                })
            });
        }
    });
    series.bullets.push(function(root, series, dataItem) {
        if (dataItem.dataContext.taskid == 126 && dataItem.dataContext.task == null) {
            return am5.Bullet.new(root, {
                sprite: am5.Label.new(root, {
                    text: "→",
                    centerY: am5.p50,
                    centerX: am5.p100,
                    populateText: true,
                    fontSize: 24,
                    textAlign: "center",
                    fontWeight: "bold",
                    paddingTop: 10,
                    paddingRight: 80
                })
            });
        }
    });
    series.bullets.push(function(root, series, dataItem) {
        if (dataItem.dataContext.taskid == 126 && dataItem.dataContext.task == null) {
            return am5.Bullet.new(root, {
                sprite: am5.Label.new(root, {
                    text: "25",
                    centerY: am5.p100,
                    centerX: am5.p100,
                    populateText: true,
                    fontSize: 9,
                    textAlign: "center",
                    fontWeight: "bold",
                    paddingBottom: 20,
                    paddingRight: 70
                })
            });
        }
    });
    series.bullets.push(function(root, series, dataItem) {
        if (dataItem.dataContext.taskid == 126 && dataItem.dataContext.task == null) {
            return am5.Bullet.new(root, {
                sprite: am5.Label.new(root, {
                    text: "50",
                    centerY: am5.p100,
                    centerX: am5.p100,
                    dx: -37,
                    populateText: true,
                    fontSize: 9,
                    textAlign: "center",
                    fontWeight: "bold",
                    paddingBottom: 20
                })
            });
        }
    });
    series.bullets.push(function(root, series, dataItem) {
        if (dataItem.dataContext.taskid == 126 && dataItem.dataContext.task == null) {
            return am5.Bullet.new(root, {
                sprite: am5.Label.new(root, {
                    text: "75",
                    centerY: am5.p100,
                    centerX: am5.p100,
                    dx: -10,
                    populateText: true,
                    fontSize: 9,
                    textAlign: "center",
                    fontWeight: "bold",
                    paddingBottom: 20
                })
            });
        }
    });
    series.bullets.push(function(root, series, dataItem) {
        if (dataItem.dataContext.taskid == 126 && dataItem.dataContext.task == null) {
            return am5.Bullet.new(root, {
                sprite: am5.Label.new(root, {
                    text: "90",
                    centerY: am5.p100,
                    centerX: am5.p100,
                    dx: 35,
                    populateText: true,
                    fontSize: 9,
                    textAlign: "center",
                    fontWeight: "bold",
                    paddingBottom: 20
                })
            });
        }
    });
    series.bullets.push(function(root, series, dataItem) {
        if (dataItem.dataContext.rrposition !== null) {
            return am5.Bullet.new(root, {
                sprite: am5.Label.new(root, {
                    text: "R",
                    centerY: am5.p50,
                    centerX: am5.p100,
                    populateText: true,
                    fontSize: 9,
                    textAlign: "center",
                    fontWeight: "bold",
                    paddingBottom: dataItem.dataContext.rbposition,
                    paddingRight: dataItem.dataContext.rrposition,
                    fill: '#7ED2E5'
                })
            });
        }
    });
    series.bullets.push(function(root, series, dataItem) {
        if (dataItem.dataContext.countno !== null) {
            return am5.Bullet.new(root, {
                sprite: am5.Label.new(root, {
                    text: "{countno}",
                    centerY: am5.p50,
                    centerX: am5.p100,
                    populateText: true,
                    fontSize: 9,
                    textAlign: "center",
                    fontWeight: "bold",
                    paddingTop: dataItem.dataContext.ctposition,
                    paddingRight: dataItem.dataContext.crposition,
                    fill: '#7ED2E5'
                })
            });
        }
    });
    series.bullets.push(function(root, series, dataItem) {
        if (dataItem.dataContext.nofill == true && (dataItem.dataContext.task != 'EQUAL\nMOVEMENTS' && dataItem.dataContext.task != 'LEFT\nHEAD' && dataItem.dataContext.task != 'RESPOND TO BELL' && dataItem.dataContext.task != 'VOCALIZES' && dataItem.dataContext.task != 'FOLLOW\nTO\nMIDLINE')) {
            var percentage = dataItem.dataContext.percentage; 
            var percentage_align = dataItem.dataContext.percentage_align; 
            if (percentage_align == 0) {
                percentage = percentage * -1;
            }
            percentage = parseFloat(percentage);
            if (dataItem.dataContext.rowsize == 1) {
                return am5.Bullet.new(root, {
                    sprite: am5.Rectangle.new(root, {
                        width: 1,
                        height: 6,
                        centerY: am5.percent(100),
                        centerX: am5.percent(100),
                        dx: percentage,
                        dy: -4,
                        fill: '#7ED2E5',
                        textAlign: "left",
                    })
                });
            }
            if (dataItem.dataContext.rowsize == 2) {
                return am5.Bullet.new(root, {
                    sprite: am5.Rectangle.new(root, {
                        width: 1,
                        height: 6,
                        centerY: am5.percent(100),
                        centerX: am5.percent(100),
                        dx: percentage,
                        dy: -9,
                        fill: '#7ED2E5',
                        textAlign: "left",
                    })
                });
            }
        }
    });
    // series.columns.template.set("interactive", true);
    series.columns.template.states.create("normalfill", {
        fill: '#47a447',
        stroke: '#47a447',
    });
    series.columns.template.states.create("dangerfill", {
        fill: '#d2322d',
        stroke: '#d2322d',
    });
    series.columns.template.states.create("infofill", {
        fill: '#3968c6',
        stroke: '#3968c6',
    });
    series.columns.template.states.create("warningfill", {
        fill: '#ed9c28',
        stroke: '#ed9c28',
    });
    series.columns.template.states.create("defaultfill", {
        fill: '#7ED2E5',
        stroke: '#7ED2E5',
    });
    series.columns.template.states.create("normal", {
        stroke: '#47a447',
    });
    series.columns.template.states.create("danger", {
        stroke: '#d2322d',
    });
    series.columns.template.states.create("info", {
        stroke: '#3968c6',
    });
    series.columns.template.states.create("warning", {
        stroke: '#ed9c28',
    });
    series.columns.template.states.create("default", {
        stroke: '#7ED2E5',
    });
    var series_column_array = [];
    series.columns.template.events.on("click", function(ev) {
        var current_series = 0;
        var i = 0;
        if (series_column_array.length == 0) {
            series.columns.each(function(column) {
                series_column_array[column.uid] = i;
                i++;
            });
        }

        var siblings = ev.target.dataItem.dataContext.siblings;
        var base_url = $("input[name='site_base_url']").val();

        if (typeof siblings != 'undefined') {
            var current_series = series_column_array[ev.target.uid];
            var nofill = ev.target.dataItem.dataContext.nofill;

            if (!nofill) {
                var fill_column = series.columns._values[current_series];
                var nofill_column = series.columns._values[current_series+siblings];
            } else {
                var nofill_column = series.columns._values[current_series];
                var fill_column = series.columns._values[current_series+siblings];
            }
            var status = '';
            var data_context = ev.target.dataItem.dataContext;
            var taskid = data_context.taskid;
            if (taskid != 126) {
                bootbox.dialog({
                    message: "<p>Status</p>",
                    size: 'small',
                    buttons: {
                        pass: {
                            label: "Pass",
                            className: 'btn-success',
                            callback: function() {
                                fill_column.states.apply("normalfill");
                                nofill_column.states.apply("normal");
                                status = 1;
                                $('input[name="ddst['+taskid+']"]').val(status);
                                fill_column_id = data_context.array_id;
                                unfill_column_id = fill_column_id + data_context.siblings;
                                current_task_id = taskid;
                                ddstinterpret();
                            }
                        },
                        fail: {
                            label: "Fail",
                            className: 'btn-danger',
                            callback: function() {
                                fill_column.states.apply("dangerfill");
                                nofill_column.states.apply("danger");
                                status = 2;
                                $('input[name="ddst['+taskid+']"]').val(status);
                                fill_column_id = data_context.array_id;
                                unfill_column_id = fill_column_id + data_context.siblings;
                                current_task_id = taskid;
                                ddstinterpret();
                            }
                        },
                        noopportunity: {
                            label: "No opportunity",
                            className: 'btn-info',
                            callback: function() {
                                fill_column.states.apply("infofill");
                                nofill_column.states.apply("info");
                                status = 3;
                                $('input[name="ddst['+taskid+']"]').val(status);
                                fill_column_id = data_context.array_id;
                                unfill_column_id = fill_column_id + data_context.siblings;
                                current_task_id = taskid;
                                ddstinterpret();
                            }
                        },
                        refusal: {
                            label: "Refusal",
                            className: 'btn-warning',
                            callback: function() {
                                fill_column.states.apply("warningfill");
                                nofill_column.states.apply("warning");
                                status = 4;
                                $('input[name="ddst['+taskid+']"]').val(status);
                                fill_column_id = data_context.array_id;
                                unfill_column_id = fill_column_id + data_context.siblings;
                                current_task_id = taskid;
                                ddstinterpret();
                            }
                        },
                        reset: {
                            label: "Reset",
                            className: 'btn-default',
                            callback: function() {
                                fill_column.states.apply("defaultfill");
                                nofill_column.states.apply("default");
                                status = 0;
                                $('input[name="ddst['+taskid+']"]').val(status);
                                fill_column_id = data_context.array_id;
                                unfill_column_id = fill_column_id + data_context.siblings;
                                current_task_id = taskid;
                                ddstinterpret();
                            }
                        },
                    },
                }).addClass('bootbox-chart');
            }
        }
    });

    // 1
    var range = xAxis.makeDataItem({});
    xAxis.createAxisRange(range);
    range.set("value", 1);
    var label = range.get("label");
    label.setAll({
        text: 'MONTHS',
        dy: 15,
        dx: -10,
        fill: '#000000',
        fontSize: 12
    });
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 2
    var range = xAxis.makeDataItem({});
    xAxis.createAxisRange(range);
    range.set("value", 2);
    var label = range.get("label");
    label.setAll({
        text: 2,
        dy: 15,
        fontWeight: "bold",
        fill: '#000000',
        fontSize: 12
    });
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 3
    var range = xAxis.makeDataItem({});
    xAxis.createAxisRange(range);
    range.set("value", 3);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 4
    var range = xAxis.makeDataItem({});
    xAxis.createAxisRange(range);
    range.set("value", 4);
    var label = range.get("label");
    label.setAll({
        text: 4,
        dy: 15,
        fontWeight: "bold",
        fill: '#000000',
        fontSize: 12
    });
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 5
    var range = xAxis.makeDataItem({});
    xAxis.createAxisRange(range);
    range.set("value", 5);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 6
    var range = xAxis.makeDataItem({});
    xAxis.createAxisRange(range);
    range.set("value", 6);
    var label = range.get("label");
    label.setAll({
        text: 6,
        dy: 15,
        fontWeight: "bold",
        fill: '#000000',
        fontSize: 12
    });
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 7
    var range = xAxis.makeDataItem({});
    xAxis.createAxisRange(range);
    range.set("value", 7);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 8
    var range = xAxis.makeDataItem({});
    xAxis.createAxisRange(range);
    range.set("value", 8);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 9
    var range = xAxis.makeDataItem({});
    xAxis.createAxisRange(range);
    range.set("value", 9);
    var label = range.get("label");
    label.setAll({
        text: 9,
        dy: 15,
        fontWeight: "bold",
        fill: '#000000',
        fontSize: 12
    });
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 10
    var range = xAxis.makeDataItem({});
    xAxis.createAxisRange(range);
    range.set("value", 10);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 11
    var range = xAxis.makeDataItem({});
    xAxis.createAxisRange(range);
    range.set("value", 11);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 12
    var range = xAxis.makeDataItem({});
    xAxis.createAxisRange(range);
    range.set("value", 12);
    var label = range.get("label");
    label.setAll({
        text: 12,
        dy: 15,
        fontWeight: "bold",
        fill: '#000000',
        fontSize: 12
    });
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 13
    var range = xAxis.makeDataItem({});
    xAxis.createAxisRange(range);
    range.set("value", 13);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 14
    var range = xAxis.makeDataItem({});
    xAxis.createAxisRange(range);
    range.set("value", 14);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 15
    var range = xAxis.makeDataItem({});
    xAxis.createAxisRange(range);
    range.set("value", 15);
    var label = range.get("label");
    label.setAll({
        text: 15,
        dy: 15,
        fontWeight: "bold",
        fill: '#000000',
        fontSize: 12
    });
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 16
    var range = xAxis.makeDataItem({});
    xAxis.createAxisRange(range);
    range.set("value", 16);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 17
    var range = xAxis.makeDataItem({});
    xAxis.createAxisRange(range);
    range.set("value", 17);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 18
    var range = xAxis.makeDataItem({});
    xAxis.createAxisRange(range);
    range.set("value", 18);
    var label = range.get("label");
    label.setAll({
        text: 18,
        dy: 15,
        fontWeight: "bold",
        fill: '#000000',
        fontSize: 12
    });
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 19
    var range = xAxis.makeDataItem({});
    xAxis.createAxisRange(range);
    range.set("value", 19);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 20
    var range = xAxis.makeDataItem({});
    xAxis.createAxisRange(range);
    range.set("value", 20);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 21
    var range = xAxis.makeDataItem({});
    xAxis.createAxisRange(range);
    range.set("value", 21);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 22
    var range = xAxis.makeDataItem({});
    xAxis.createAxisRange(range);
    range.set("value", 22);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 23
    var range = xAxis.makeDataItem({});
    xAxis.createAxisRange(range);
    range.set("value", 23);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 24
    var range = xAxis.makeDataItem({});
    xAxis.createAxisRange(range);
    range.set("value", 24);
    var label = range.get("label");
    label.setAll({
        text: 24,
        dy: 15,
        fontWeight: "bold",
        fill: '#000000',
        fontSize: 12
    });
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 25
    var range = xAxis.makeDataItem({});
    xAxis.createAxisRange(range);
    range.set("value", 25);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 26
    var range = xAxis.makeDataItem({});
    xAxis.createAxisRange(range);
    range.set("value", 26);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 20,
        location: 0
    });
    // 27
    var range = xAxis.makeDataItem({});
    xAxis.createAxisRange(range);
    range.set("value", 27);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 28
    var range = xAxis.makeDataItem({});
    xAxis.createAxisRange(range);
    range.set("value", 28);
    var label = range.get("label");
    label.setAll({
        text: 3,
        dy: 15,
        fontWeight: "bold",
        fill: '#000000',
        fontSize: 12
    });
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 29
    var range = xAxis.makeDataItem({});
    xAxis.createAxisRange(range);
    range.set("value", 29);
    var label = range.get("label");
    label.setAll({
        text: 'YEARS',
        dy: 18,
        fill: '#000000',
        fontSize: 12
    });
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 30
    var range = xAxis.makeDataItem({});
    xAxis.createAxisRange(range);
    range.set("value", 30);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 20,
        location: 0
    });
    // 31
    var range = xAxis.makeDataItem({});
    xAxis.createAxisRange(range);
    range.set("value", 31);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 32
    var range = xAxis.makeDataItem({});
    xAxis.createAxisRange(range);
    range.set("value", 32);
    var label = range.get("label");
    label.setAll({
        text: 4,
        dy: 18,
        fill: '#000000',
        fontWeight: "bold",
        fontSize: 12
    });
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 33
    var range = xAxis.makeDataItem({});
    xAxis.createAxisRange(range);
    range.set("value", 33);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 34
    var range = xAxis.makeDataItem({});
    xAxis.createAxisRange(range);
    range.set("value", 34);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 20,
        location: 0
    });
    // 35
    var range = xAxis.makeDataItem({});
    xAxis.createAxisRange(range);
    range.set("value", 35);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 36
    var range = xAxis.makeDataItem({});
    xAxis.createAxisRange(range);
    range.set("value", 36);
    var label = range.get("label");
    label.setAll({
        text: 5,
        dy: 18,
        fill: '#000000',
        fontWeight: "bold",
        fontSize: 12
    });
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 37
    var range = xAxis.makeDataItem({});
    xAxis.createAxisRange(range);
    range.set("value", 37);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 38
    var range = xAxis.makeDataItem({});
    xAxis.createAxisRange(range);
    range.set("value", 38);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 20,
        location: 0
    });
    // 39
    var range = xAxis.makeDataItem({});
    xAxis.createAxisRange(range);
    range.set("value", 39);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 40
    var range = xAxis.makeDataItem({});
    xAxis.createAxisRange(range);
    range.set("value", 40);
    var label = range.get("label");
    label.setAll({
        text: 6,
        dy: 18,
        fill: '#000000',
        fontWeight: "bold",
        fontSize: 12
    });


    // 1
    var range = xAxis2.makeDataItem({});
    xAxis2.createAxisRange(range);
    range.set("value", 1);
    var label = range.get("label");
    label.setAll({
        text: 'MONTHS',
        dy: -15,
        dx: -10,
        fill: '#000000',
        fontSize: 12
    });
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 2
    var range = xAxis2.makeDataItem({});
    xAxis2.createAxisRange(range);
    range.set("value", 2);
    var label = range.get("label");
    label.setAll({
        text: 2,
        dy: -15,
        fontWeight: "bold",
        fill: '#000000',
        fontSize: 12
    });
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 3
    var range = xAxis2.makeDataItem({});
    xAxis2.createAxisRange(range);
    range.set("value", 3);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 4
    var range = xAxis2.makeDataItem({});
    xAxis2.createAxisRange(range);
    range.set("value", 4);
    var label = range.get("label");
    label.setAll({
        text: 4,
        dy: -15,
        fontWeight: "bold",
        fill: '#000000',
        fontSize: 12
    });
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 5
    var range = xAxis2.makeDataItem({});
    xAxis2.createAxisRange(range);
    range.set("value", 5);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 6
    var range = xAxis2.makeDataItem({});
    xAxis2.createAxisRange(range);
    range.set("value", 6);
    var label = range.get("label");
    label.setAll({
        text: 6,
        dy: -15,
        fontWeight: "bold",
        fill: '#000000',
        fontSize: 12
    });
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 7
    var range = xAxis2.makeDataItem({});
    xAxis2.createAxisRange(range);
    range.set("value", 7);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 8
    var range = xAxis2.makeDataItem({});
    xAxis2.createAxisRange(range);
    range.set("value", 8);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 9
    var range = xAxis2.makeDataItem({});
    xAxis2.createAxisRange(range);
    range.set("value", 9);
    var label = range.get("label");
    label.setAll({
        text: 9,
        dy: -15,
        fontWeight: "bold",
        fill: '#000000',
        fontSize: 12
    });
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 10
    var range = xAxis2.makeDataItem({});
    xAxis2.createAxisRange(range);
    range.set("value", 10);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 11
    var range = xAxis2.makeDataItem({});
    xAxis2.createAxisRange(range);
    range.set("value", 11);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 12
    var range = xAxis2.makeDataItem({});
    xAxis2.createAxisRange(range);
    range.set("value", 12);
    var label = range.get("label");
    label.setAll({
        text: 12,
        dy: -15,
        fontWeight: "bold",
        fill: '#000000',
        fontSize: 12
    });
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 13
    var range = xAxis2.makeDataItem({});
    xAxis2.createAxisRange(range);
    range.set("value", 13);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 14
    var range = xAxis2.makeDataItem({});
    xAxis2.createAxisRange(range);
    range.set("value", 14);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 15
    var range = xAxis2.makeDataItem({});
    xAxis2.createAxisRange(range);
    range.set("value", 15);
    var label = range.get("label");
    label.setAll({
        text: 15,
        dy: -15,
        fontWeight: "bold",
        fill: '#000000',
        fontSize: 12
    });
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 16
    var range = xAxis2.makeDataItem({});
    xAxis2.createAxisRange(range);
    range.set("value", 16);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 17
    var range = xAxis2.makeDataItem({});
    xAxis2.createAxisRange(range);
    range.set("value", 17);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 18
    var range = xAxis2.makeDataItem({});
    xAxis2.createAxisRange(range);
    range.set("value", 18);
    var label = range.get("label");
    label.setAll({
        text: 18,
        dy: -15,
        fontWeight: "bold",
        fill: '#000000',
        fontSize: 12
    });
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 19
    var range = xAxis2.makeDataItem({});
    xAxis2.createAxisRange(range);
    range.set("value", 19);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 20
    var range = xAxis2.makeDataItem({});
    xAxis2.createAxisRange(range);
    range.set("value", 20);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 21
    var range = xAxis2.makeDataItem({});
    xAxis2.createAxisRange(range);
    range.set("value", 21);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 22
    var range = xAxis2.makeDataItem({});
    xAxis2.createAxisRange(range);
    range.set("value", 22);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 23
    var range = xAxis2.makeDataItem({});
    xAxis2.createAxisRange(range);
    range.set("value", 23);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 24
    var range = xAxis2.makeDataItem({});
    xAxis2.createAxisRange(range);
    range.set("value", 24);
    var label = range.get("label");
    label.setAll({
        text: 24,
        dy: -15,
        fontWeight: "bold",
        fill: '#000000',
        fontSize: 12
    });
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 25
    var range = xAxis2.makeDataItem({});
    xAxis2.createAxisRange(range);
    range.set("value", 25);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 26
    var range = xAxis2.makeDataItem({});
    xAxis2.createAxisRange(range);
    range.set("value", 26);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 20,
        location: 0
    });
    // 27
    var range = xAxis2.makeDataItem({});
    xAxis2.createAxisRange(range);
    range.set("value", 27);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 28
    var range = xAxis2.makeDataItem({});
    xAxis2.createAxisRange(range);
    range.set("value", 28);
    var label = range.get("label");
    label.setAll({
        text: 3,
        dy: -15,
        fontWeight: "bold",
        fill: '#000000',
        fontSize: 12
    });
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 29
    var range = xAxis2.makeDataItem({});
    xAxis2.createAxisRange(range);
    range.set("value", 29);
    var label = range.get("label");
    label.setAll({
        text: 'YEARS',
        dy: -18,
        fill: '#000000',
        fontSize: 12
    });
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 30
    var range = xAxis2.makeDataItem({});
    xAxis2.createAxisRange(range);
    range.set("value", 30);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 20,
        location: 0
    });
    // 31
    var range = xAxis2.makeDataItem({});
    xAxis2.createAxisRange(range);
    range.set("value", 31);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 32
    var range = xAxis2.makeDataItem({});
    xAxis2.createAxisRange(range);
    range.set("value", 32);
    var label = range.get("label");
    label.setAll({
        text: 4,
        dy: -18,
        fill: '#000000',
        fontWeight: "bold",
        fontSize: 12
    });
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 33
    var range = xAxis2.makeDataItem({});
    xAxis2.createAxisRange(range);
    range.set("value", 33);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 34
    var range = xAxis2.makeDataItem({});
    xAxis2.createAxisRange(range);
    range.set("value", 34);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 20,
        location: 0
    });
    // 35
    var range = xAxis2.makeDataItem({});
    xAxis2.createAxisRange(range);
    range.set("value", 35);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 36
    var range = xAxis2.makeDataItem({});
    xAxis2.createAxisRange(range);
    range.set("value", 36);
    var label = range.get("label");
    label.setAll({
        text: 5,
        dy: -18,
        fill: '#000000',
        fontWeight: "bold",
        fontSize: 12
    });
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 37
    var range = xAxis2.makeDataItem({});
    xAxis2.createAxisRange(range);
    range.set("value", 37);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 38
    var range = xAxis2.makeDataItem({});
    xAxis2.createAxisRange(range);
    range.set("value", 38);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 20,
        location: 0
    });
    // 39
    var range = xAxis2.makeDataItem({});
    xAxis2.createAxisRange(range);
    range.set("value", 39);
    var tick = range.get("tick");
    tick.setAll({
        visible: true,
        strokeOpacity: 1,
        length: 10,
        location: 0
    });
    // 40
    var range = xAxis2.makeDataItem({});
    xAxis2.createAxisRange(range);
    range.set("value", 40);
    var label = range.get("label");
    label.setAll({
        text: 6,
        dy: -18,
        fill: '#000000',
        fontWeight: "bold",
        fontSize: 12
    });

    // Age Marking Grid
    var rangeDataItem = xAxis.makeDataItem({
      value: ddst_age,
      above: true        
  });
    let axisrange = xAxis.createAxisRange(rangeDataItem);
    axisrange.get("grid").setAll({
        stroke: '#4D77CC',
        strokeWidth: 2,
        strokeOpacity: 1
    });

    series.data.setAll(data);

    // Make stuff animate on load
    // https://www.amcharts.com/docs/v5/concepts/animations/
    series.appear();
    chart.appear(1000, 100);

});

function printbtn() {
    let exporting = am5plugins_exporting.Exporting.new(root, {
        menu: am5plugins_exporting.ExportingMenu.new(root, {}),
        printOptions: {
            printMethod: "iframe"
        }
    });

    exporting.print();
}

function ddstinterpret() {
    var ddst_age = parseFloat($('input[name="ddst_age"]').val());

    var refusal_count_1 = refusal_count_2 = refusal_count_3 = refusal_count_4 = 0;
    var caution_count_1 = caution_count_2 = caution_count_3 = caution_count_4 = 0;
    var delay_count_1 = delay_count_2 = delay_count_3 = delay_count_4 = 0;

    var ddst_interpretation_1 = ddst_interpretation_2 = ddst_interpretation_3 = ddst_interpretation_4 = null;

    var refusal_count = 0;
    var caution_count = 0;
    var delay_count = 0;

    var ddst_interpretation = null;
    $.each($('input[name^="ddst["]'), function() {

        var task_id = $(this).attr('name');
            task_id = task_id.replace(/[a-z\[\]]/g, '');

        var task_value = $(this).val();
        
        if (current_task_id == task_id && unfill_column_id != null && fill_column_id != null) {
            var ddst_settings = JSON.parse($('input[name="ddst_settings"]').val());
            
            var color = '#7ED2E5';

            if (task_value == 1) {
                color = '#47a447';
            } else if (task_value == 2) {
                color = '#d2322d';
            } else if (task_value == 3) {
                color = '#3968c6';
            } else if (task_value == 4) {
                color = '#ed9c28';
            }

            ddst_settings[unfill_column_id].columnSettings.fill = '#FFFFFF';
            ddst_settings[unfill_column_id].columnSettings.stroke = color;

            ddst_settings[fill_column_id].columnSettings.fill = color;
            ddst_settings[fill_column_id].columnSettings.stroke = color;

            var updated_ddst_settings = JSON.stringify(ddst_settings);

            $('input[name="ddst_settings"]').val(updated_ddst_settings);
            unfill_column_id = null;
            fill_column_id = null;
        }

        if (task_value != '' && task_value != 0) {

            var status = parseInt(task_value);
            var x_start_value = parseFloat($(this).attr('data-x-start-value'));
            var x_end_value = parseFloat($(this).attr('data-x-end-value'));

            if (task_id < 33) {
                if ((x_start_value <= ddst_age || x_end_value <= ddst_age) && status == 4) {
                    refusal_count_1 += 1;
                } else if (ddst_age >= x_start_value && ddst_age <= x_end_value && status == 2) {
                    caution_count_1 += 1;
                } else if (x_start_value <= ddst_age && status == 2) {
                    delay_count_1 += 1;
                }
            } else if (task_id < 72) {
                if ((x_start_value <= ddst_age || x_end_value <= ddst_age) && status == 4) {
                    refusal_count_2 += 1;
                } else if (ddst_age >= x_start_value && ddst_age <= x_end_value && status == 2) {
                    caution_count_2 += 1;
                } else if (x_start_value <= ddst_age && status == 2) {
                    delay_count_2 += 1;
                }
            } else if (task_id < 101) {
                if ((x_start_value <= ddst_age || x_end_value <= ddst_age) && status == 4) {
                    refusal_count_3 += 1;
                } else if (ddst_age >= x_start_value && ddst_age <= x_end_value && status == 2) {
                    caution_count_3 += 1;
                } else if (x_start_value <= ddst_age && status == 2) {
                    delay_count_3 += 1;
                }            
            } else {
                if ((x_start_value <= ddst_age || x_end_value <= ddst_age) && status == 4) {
                    refusal_count_4 += 1;
                } else if (ddst_age >= x_start_value && ddst_age <= x_end_value && status == 2) {
                    caution_count_4 += 1;
                } else if (x_start_value <= ddst_age && status == 2) {
                    delay_count_4 += 1;
                }
            }

        }

        refusal_count = refusal_count_1 + refusal_count_2 + refusal_count_3 + refusal_count_4;
        caution_count = caution_count_1 + caution_count_2 + caution_count_3 + caution_count_4;
        delay_count = delay_count_1 + delay_count_2 + delay_count_3 + delay_count_4;

    });

    if (refusal_count_1 > 0) {
        ddst_interpretation_1 = 2;          
    } else if ((caution_count_1 >= 2 && caution_count_1 < 1) || delay_count_1 >= 1) {
        ddst_interpretation_1 = 1;
    } else if (caution_count_1 <= 1 && delay_count_1 == 0) {
        ddst_interpretation_1 = 0;
    }

    if (refusal_count_2 > 0) {
        ddst_interpretation_2 = 2;          
    } else if ((caution_count_2 >= 2 && caution_count_2 < 1) || delay_count_2 >= 1) {
        ddst_interpretation_2 = 1;
    } else if (caution_count_2 <= 1 && delay_count_2 == 0) {
        ddst_interpretation_2 = 0;
    }

    if (refusal_count_3 > 0) {
        ddst_interpretation_3 = 2;          
    } else if ((caution_count_3 >= 2 && caution_count_3 < 1) || delay_count_3 >= 1) {
        ddst_interpretation_3 = 1;
    } else if (caution_count_3 <= 1 && delay_count_3 == 0) {
        ddst_interpretation_3 = 0;
    }

    if (refusal_count_4 > 0) {
        ddst_interpretation_4 = 2;          
    } else if ((caution_count_4 >= 2 && caution_count_4 < 1) || delay_count_4 >= 1) {
        ddst_interpretation_4 = 1;
    } else if (caution_count_4 <= 1 && delay_count_4 == 0) {
        ddst_interpretation_4 = 0;
    }

    if (refusal_count > 0) {
        ddst_interpretation = 2;          
    } else if ((caution_count >= 2 && caution_count < 1) || delay_count >= 1) {
        ddst_interpretation = 1;
    } else if (caution_count <= 1 && delay_count == 0) {
        ddst_interpretation = 0;
    }
    
    $('input[name="ddst_gross_motor_interpretation_status"]').val(ddst_interpretation_1);
    $('input[name="ddst_language_interpretation_status"]').val(ddst_interpretation_2);
    $('input[name="ddst_fine_motor_interpretation_status"]').val(ddst_interpretation_3);
    $('input[name="ddst_personal_interpretation_status"]').val(ddst_interpretation_4);
    $('input[name="ddst_interpretation_status"]').val(ddst_interpretation);
    
    $('.status-btn').addClass('hide');
    if (ddst_interpretation == 0) {
        $('.status-btn.label-success').removeClass('hide');
        $('#ddst-arrow').removeClass('hide');
    } else if (ddst_interpretation == 1) {
        $('.status-btn.label-warning').removeClass('hide');
        $('#ddst-arrow').removeClass('hide');
    } else if (ddst_interpretation == 2) {
        $('.status-btn.label-info').removeClass('hide');
        $('#ddst-arrow').removeClass('hide');
    }

}
