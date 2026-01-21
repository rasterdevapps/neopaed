$(document).ready(function() {

    var base_url = $("input[name='site_base_url']").val();
    var baby_id = $('input[name="baby_id"]').val();
    var admission_date = $('input[name="admission_date"]').val();
    admission_date = admission_date.split('-');
    date = admission_date[2];
    month = admission_date[1] - 1;
    year = admission_date[0];
    admission_date = new Date(year, month, date);
    var colors = [];
    colors['Heart Rate (BPM)'] = ['#E13600', '#FF5D2B', '#42E51C', '#256112', '#42E51C', '#FF5D2B', '#FF3D00', '#E13600'];
    colors['Monitor Oxygen Saturation (%)'] = ['#256112', '#39C219', '#42E51C', '#FFDA55', '#FFC712', '#FF922F', '#FF5D2B', '#FF3D00', '#E13600'];
    colors['Ventilator Oxygen Saturation (%)'] = ['#256112', '#39C219', '#42E51C', '#FFDA55', '#FFC712', '#FF922F', '#FF5D2B', '#FF3D00', '#E13600'];
    var root = [];
    var chart = [];
    var comparsion_view = false;

    function levelComparison(chartid, data, chartname, compare_view) {
        chartname = chartname.replace(' Trend', '');
        if (chartname == 'Ventilator SpO2 (%)') {
            chartname = 'Ventilator Oxygen Saturation (%)';
        }
        if (chartname == 'Oxygen Saturation (%)') {
            chartname = 'Monitor Oxygen Saturation (%)';
        }
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
        root[chartid] = am5.Root.new(chartid);
        // Set themes
        // https://www.amcharts.com/docs/v5/concepts/themes/
        root[chartid].setThemes([
            am5themes_Animated.new(root[chartid]),
            ]);
        // Create chart
        // https://www.amcharts.com/docs/v5/charts/xy-chart/
        chart[chartid] = root[chartid].container.children.push(am5xy.XYChart.new(root[chartid], {
            panX: false,
            panY: false,
            layout: root[chartid].verticalLayout,
            paddingTop: 50
        }));
        chart[chartid].set("background", am5.Rectangle.new(root[chartid], {
            stroke: '#FFB3B3',
            strokeOpacity: 0.5,
            strokeWidth: 5,
            fill: '#000000',
            fillOpacity: 1
        }));
        // We don't want zoom-out button to appear while animating, so we hide it
        chart[chartid].zoomOutButton.set("forceHidden", true);
        // Create axes
        // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
        var xRenderer = am5xy.AxisRendererX.new(root[chartid], {
            minGridDistance: 30
        });
        xRenderer.labels.template.setAll({
            fill: root[chartid].interfaceColors.get("alternativeText")
        });
        xRenderer.grid.template.setAll({
            stroke: '#BDBBBC',
        });
        if (!compare_view) {
            xRenderer.grid.template.set("visible", false);
        }
        var xAxis = chart[chartid].xAxes.push(am5xy.CategoryAxis.new(root[chartid], {
            categoryField: "range",
            paddingTop: 10,
            renderer: xRenderer
        }));
        xAxis.children.push(am5.Label.new(root[chartid], {
            text: chartname,
            x: am5.p50,
            centerX: am5.p50,
            fontSize: 18,
            paddingTop: 10,
            paddingBottom: 0,
            fill: root[chartid].interfaceColors.get("alternativeText")
        }));
        var range = xAxis.makeDataItem({
            value: 0,
        });
        xAxis.createAxisRange(range);
        var grid = range.get("grid");
        grid.setAll({
            stroke: '#FFFFFF',
            strokeOpacity: 1,
            strokeWidth: 1,
            visible: true
        });
        xAxis.data.setAll(data);
        var yRenderer = am5xy.AxisRendererY.new(root[chartid], {
            minGridDistance: 30            
        });
        yRenderer.labels.template.setAll({
            fill: root[chartid].interfaceColors.get("alternativeText")
        });
        yRenderer.grid.template.set("visible", false);
        var yAxis = chart[chartid].yAxes.push(am5xy.ValueAxis.new(root[chartid], {
            min: 0,
            max: 100,
            numberFormat: "#.'%'",
            renderer: yRenderer
        }));
        var range = yAxis.makeDataItem({
            value: 0,
        });
        yAxis.createAxisRange(range);
        var grid = range.get("grid");
        grid.setAll({
            stroke: '#FFFFFF',
            strokeOpacity: 1,
            strokeWidth: 1,
            visible: true
        });
        makeSeries(chartid, xAxis, yAxis, compare_view, data, "D1", "percentage", chartname);
        if (compare_view) {
            makeSeries(chartid, xAxis, yAxis, compare_view, data, "D2", "percentage_2", chartname);
        }
        chart[chartid].appear(1000, 100);
    }

    function makeSeries(chartid, xAxis, yAxis, compareview, data, name, fieldName, chartname) {
        // Add series
        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
        var series = chart[chartid].series.push(am5xy.ColumnSeries.new(root[chartid], {
            name: name,
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: fieldName,
            categoryXField: "range",
            maskBullets: false
        }));
        // Rounded corners for columns
        series.columns.template.setAll({
            cornerRadiusTL: 5,
            cornerRadiusTR: 5,
            strokeOpacity: 0
        });
        // Make each column to be of a different color
        series.columns.template.adapters.add("fill", function(fill, target) {
            return colors[chartname][series.columns.indexOf(target)];
        });
        // Add Label bullet
        var position = 1;
        var padding_bottom = 20;
        var padding_top = 0;
        var padding_left = 10;
        var angle = 0;
        if (compareview) {
            angle = -90;
            padding_bottom = 0;
            padding_left = 55;
        }
        series.bullets.push(function() {
            return am5.Bullet.new(root[chartid], {
                locationX: 0.5,
                locationY: position,
                sprite: am5.Label.new(root[chartid], {
                    text: "[bold]{valueY} %",
                    centerX: am5.percent(50),
                    centerY: am5.percent(50),
                    textAlign: "center",
                    rotation: angle,
                    populateText: true,
                    fill: '#FFFFFF',
                    paddingBottom: padding_bottom,
                    paddingLeft: padding_left,
                    paddingTop: padding_top
                })
            });
        });
        if (compareview) {
            // series.columns.template.setAll({
            //     tooltipText: "[bold]" + name,
            //     tooltipY: 0
            // });
            series.bullets.push(function() {
                return am5.Bullet.new(root[chartid], {
                    locationX: 0.5,
                    locationY: 0,
                    sprite: am5.Label.new(root[chartid], {
                        text: name,
                        centerX: am5.percent(50),
                        centerY: am5.percent(50),
                        textAlign: "center",
                        populateText: true,
                        fill: '#FFFFFF',
                        paddingTop: 20,
                        fontSize: 10,
                    })
                });
            });
        }
        series.columns.template.set("interactive", true);
        series.columns.template.states.create("hover", {
            stroke: '#FFFFFF',
            strokeWidth: 5,
        });
        series.data.setAll(data);
        // Make stuff animate on load
        // https://www.amcharts.com/docs/v5/concepts/animations/
        series.appear(1000);
    }

    $('#dtfrom-date, #dtto-date, #dfrom-date, #dto-date, #bdtfrom-date, #bdtto-date, #cdtfrom-date, #cdtto-date').datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: admission_date,
        maxDate: new Date()
    });

    function valueFormater(value) {
        return value < 10 ? '0' + value : value;
    }

    function dateFormater(date) {
        var temp_date = date.split('-');
        var date = temp_date[0];
        var month = temp_date[1];
        var year = temp_date[2].split(' ')[0];
        return new Date(year, month, date);
    }

    var date_1 = admission_date;
    var date_2 = new Date();
    date_2.setDate(date_2.getDate() - 6);
    if ((date_1.getTime() - date_2.getTime()) > 0) {
        $('#dfrom-date').val(valueFormater(date_1.getDate()) + '-' + valueFormater(date_1.getMonth() + 1) + '-' + date_1.getFullYear());
    } else {
        $('#dfrom-date').val(valueFormater(date_2.getDate()) + '-' + valueFormater(date_2.getMonth() + 1) + '-' + date_2.getFullYear());
    }

    applyRangeFilter();
    $('#dtfrom-date, #dtfrom-hour, #dtfrom-mins, #dtfrom-session, #dtto-date, #dtto-hour, #dtto-mins, #dtto-session').on('change', function() {
        comparsion_view = false;
        applyRangeFilter();
    });

    $('#apply-btn').on('click', function() {
        applyRangeFilter();
    });

    function applyRangeFilter() {
        var compare = false;
        if ($('#date-range').hasClass('default')) {
            var selected_start_date = $('#dtfrom-date').val() + ' ' + valueFormater($('#dtfrom-hour').val()) + ':' + valueFormater($('#dtfrom-mins').val()) + ' ' + $('#dtfrom-session').val();
            var selected_end_date = $('#dtto-date').val() + ' ' + valueFormater($('#dtto-hour').val()) + ':' + valueFormater($('#dtto-mins').val()) + ' ' + $('#dtto-session').val();
            $('#range-chart').html('Chart for <strong>' + selected_start_date + ' to ' + selected_end_date + '</strong>');
            var start_from = selected_start_date;
            var end_to = selected_end_date;
        } else if ($('#comparison-date-range').hasClass('custom')) {
            var base_start_date = $('#bdtfrom-date').val() + ' ' + valueFormater($('#bdtfrom-hour').val()) + ':' + valueFormater($('#bdtfrom-mins').val()) + ' ' + $('#bdtfrom-session').val();
            var base_end_date = $('#bdtto-date').val() + ' ' + valueFormater($('#bdtto-hour').val()) + ':' + valueFormater($('#bdtto-mins').val()) + ' ' + $('#bdtto-session').val();
            var compare_start_date = $('#cdtfrom-date').val() + ' ' + valueFormater($('#cdtfrom-hour').val()) + ':' + valueFormater($('#cdtfrom-mins').val()) + ' ' + $('#cdtfrom-session').val();
            var compare_end_date = $('#cdtto-date').val() + ' ' + valueFormater($('#cdtto-hour').val()) + ':' + valueFormater($('#cdtto-mins').val()) + ' ' + $('#cdtto-session').val();
            $('#range-chart').html('Chart comparison between <strong>(' + base_start_date + ' to ' + base_end_date + ') and (' + compare_start_date + ' to ' + compare_end_date + ')</strong>');
            var start_from = base_start_date;
            var end_to = base_end_date;
            var set_2_start_from = compare_start_date;
            var set_2_end_to = compare_end_date;
            comparsion_view = true;
        }
        if (start_from != '' && end_to != '' && start_from != 'undefined' && end_to != 'undefined') {
            if ((dateFormater(start_from).getTime() - dateFormater(end_to).getTime()) <= 0) {
                $.ajax({
                    type: "GET",
                    url: base_url + "/range-comparison-charts",
                    data: {
                        baby_id: baby_id,
                        start_from: start_from,
                        end_to: end_to,
                        set_2_start_from: set_2_start_from,
                        set_2_end_to: set_2_end_to
                    },
                    beforeSend: function() {
                        $('#range-loader').removeClass('display-none');
                    },
                    success: function(response) {
                        var parameters = response.parameters;
                        parameters = JSON.parse(parameters);
                        var results = response.results;
                        results = JSON.parse(results);
                        if (parameters.length > 0) {
                            removeEmptyView();
                            
                            if (typeof root !== 'undefined') {
                                $('.comparison-chart').each(function() {
                                    var ids = $(this).attr('id');
                                    if (typeof root[ids] !== 'undefined') {
                                        root[ids].dispose();
                                        chart[ids].dispose();
                                    }
                                });
                            }

                            $.each(parameters, function(key, value) {
                                levelComparison('range-view-' + key, Object.values(results[value]), value, comparsion_view);
                            });
                        } else {
                            emptyView();
                        }
                    },
                    complete: function() {
                        $('#range-loader').addClass('display-none');
                    }
                });
            } else {
                Showalert('error', 'To date must be greater than from date !');
            }
        }
    }

    function emptyView() {
        $("#range-container").addClass("empty-container");
        $(".comparison-chart").html('');
    }

    function removeEmptyView() {
        $("#range-container").removeClass("empty-container");
    }

    $(document).on("click", "#comparison-icon", function() {
        $('#comparison-date-range').addClass('custom');
        $('#date-range').removeClass('default');
        $('#reset-icon').removeClass('display-none');
        $('#comparison-icon').addClass('display-none');
        emptyView();
    });

    $("#reset-icon").on("click", function() {
        $('#comparison-date-range').removeClass('custom');
        $('#date-range').addClass('default');
        $('#reset-icon').addClass('display-none');
        $('#comparison-icon').removeClass('display-none');
        emptyView();
        comparsion_view = false;
        applyRangeFilter();
    });

    applyDateFilter();
    $('#dfrom-date, #dto-date').on('change', function() {
        applyDateFilter();
    });

    function applyDateFilter() {
        var compare = false;
        var selected_start_date = $('#dfrom-date').val();
        var selected_end_date = $('#dto-date').val();
        $('#table-chart').html('Table for <strong>' + selected_start_date + ' to ' + selected_end_date + '</strong>');
        var start_from = selected_start_date;
        var end_to = selected_end_date;
        if (start_from != '' && end_to != '' && start_from != 'undefined' && end_to != 'undefined') {
            if ((dateFormater(start_from).getTime() - dateFormater(end_to).getTime()) <= 0) {
                $.ajax({
                    type: "GET",
                    url: base_url + "/table-comparison-charts",
                    data: {
                        baby_id: baby_id,
                        start_from: start_from,
                        end_to: end_to
                    },
                    beforeSend: function() {
                        $('#table-loader').removeClass('display-none');
                    },
                    success: function(response) {
                        var date_list = response.date_list;
                        var nav_tab = '<ul class="nav nav-tabs" role="tablist">';
                        var tab_content = '<div class="tab-content tab-view-shadow">';
                        $.each(date_list, function(key, value) {
                            nav_tab += '<li role="presentation">'
                            nav_tab += '<a href="#' + value + '" aria-controls="' + value + '" role="tab" data-toggle="tab" data-filter="' + key + '">' + value + '</a>'
                            nav_tab += '</li>';
                            tab_content += '<div role="tabpanel" class="tab-pane" id="' + value + '">';
                            tab_content += '<div id="table-loader-' + value + '" class="loader-view display-none"></div>';
                            tab_content += '<table class="table table-bordered">';
                            tab_content += '</table>';
                            tab_content += '</div>';
                        });
                        nav_tab += '</ul>';
                        tab_content += '</div>';
                        $("#table-container .tabbable").html(nav_tab + tab_content);
                        $('#table-container li:last-child').trigger('click').addClass('active');
                        $('#table-container .tab-pane:last-child').addClass('active');
                    },
                    complete: function() {
                        $('#table-loader').addClass('display-none');
                    }
                });
            } else {
                Showalert('error', 'To date must be greater than from date !');
            }
        }
    }

    $(document).on('click', '#table-container li', function() {
        var element = $(this);
        var selected_date = element.find('a').attr('data-filter');
        if (selected_date != 'done') {
            selected_date = selected_date.split(' - ');
            var start_from = selected_date[0];
            var end_to = selected_date[1];
            $.ajax({
                type: "GET",
                url: base_url + "/hour-wise-range-data",
                data: {
                    baby_id: baby_id,
                    start_from: start_from,
                    end_to: end_to
                },
                beforeSend: function() {
                    $('#table-loader-' + start_from.split(' ')[0]).removeClass('display-none');
                },
                success: function(response) {
                    var data = response.data;
                    var time_list = response.time_list;
                    var hero_data = response.hero_data;
                    var first_day_column_count = response.first_day_column_count
                    var content = '';
                    content += '<thead>';
                    content += '<tr>';
                    content += '<th></th>';
                    content += '<th colspan="' + first_day_column_count + '">' + start_from.split(' ')[0] + '</th>';
                    content += '<th colspan="' + (24 - first_day_column_count) + '">' + end_to.split(' ')[0] + '</th>';
                    content += '</tr>';
                    content += '<tr>';
                    content += '<th class="time-bg">';
                    content += 'Range';
                    content += '</th>';
                    $.each(time_list, function(index, time) {
                        content += '<th class="time-bg">';
                        content += time.split(' ')[1];
                        content += '</th>';
                    });
                    content += '</tr>';
                    content += '</thead>';
                    $.each(data, function(key, value) {
                        content += '<thead>';
                        content += '<tr>';
                        key = key.replace('Trend', '');
                        content += '<th colspan="25">' + key + '</th>';
                        content += '</tr>';
                        content += '<tr>';
                        content += '</tr>';
                        content += '</thead>';
                        content += '<tbody>';
                        $.each(value, function(key1, value1) {
                            content += '<tr>';
                            content += '<td>';
                            content += key1;
                            content += '</td>';
                            $.each(time_list, function(index, time) {
                                content += '<td>';
                                content += typeof value1[time] != 'undefined' ? value1[time] : '-';
                                content += '</td>';
                            });
                            content += '</tr>';
                        });
                        content += '</tbody>';
                    });
                    content += '<thead>';
                    content += '<tr>';
                    content += '<th colspan="25">HeRO Score</th>';
                    content += '</tr>';
                    content += '<tr>';
                    content += '</tr>';
                    content += '</thead>';
                    content += '<tbody>';
                    content += '<tr>';
                    content += '<td>';
                    content += '</td>';
                    $.each(time_list, function(index, time) {
                        content += '<td>';
                        content += typeof hero_data[time] != 'undefined' ? hero_data[time] : '-';
                        content += '</td>';
                    });
                    content += '</tr>';
                    content += '</tbody>';
                    $('#table-container .tab-pane.active table').html(content);
                    element.find('a').attr('data-filter', 'done');
                },
                complete: function() {
                    $('#table-loader-' + start_from.split(' ')[0]).addClass('display-none');
                }
            });
        }
    });

});
