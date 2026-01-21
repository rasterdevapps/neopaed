$(document).ready(function() {
    var client_zone = Intl.DateTimeFormat().resolvedOptions().timeZone;

    var site_base_url = $('input[name="site_base_url"]').val();
    var g_weeks = $('input[name="g_weeks"]').val();
    var public_url = site_base_url + '/public';
    // $('#chart-loader').hide();
    var event_color = JSON.parse($('input[name="event_color"]').val());
    var all_parameter = JSON.parse($('#all_parameter').val());
    var mrn = $('#mrn').val();
    var baby_details = $('#baby_details').val();
    var baby_name = $('#baby_name').val();
    var live_data_updation = true;
    var interval = parseInt($('#display_time').val());
    var display_time = interval * 60;
    var raise_request = true;
    var apply_range = false;
    var whole_data = [];
    var initial_height = 100;
    var param_field_height = 80;
    var page_height = $(window).height() - 300;
    var individual_height;
    var whole_height;
    var label_hidden = true;
    var display_event_status = true;
    var display_x_axis_label = false;
    var global_observation_parameter = [];
    var chart_data = [];
    var chart_datetime = [];
    var data_list = [];
    var date_list = [];
    var event_info = [];
    var chart_starting_time = $('#startfrom').val();
    var width = $('#chartdiv').width() - 72;
    $('#live-param-modal').modal({
        backdrop: 'static',
        keyboard: false,
        show: true
    });
    $('#all').on('click', function() {
        var active = $(this).hasClass('active');
        if (active) {
            $('input[name="active_param"]').each(function() {
                $(this).prop('checked', true);
            });
            $('#generate-btn').attr('disabled', false);
            $(this).removeClass('active');
            $(this).addClass('unactive');
            $(this).attr('title', 'Uncheck All');
        } else {
            $('input[name="active_param"]').each(function() {
                $(this).prop('checked', false);
            });
            $('#generate-btn').attr('disabled', true);
            $(this).addClass('active');
            $(this).removeClass('unactive');
            $(this).attr('title', 'Check All');
        }
    });
    $(document).on('click', 'input[type="checkbox"]', function() {
        var is_checked = $(this).is(':checked');
        var code = $(this).val();
        if (code.indexOf('bp') != -1) {
            if (code.indexOf('cuff') != -1) {
                $('#cuff_systalic_bp').prop('checked', is_checked);
                $('#cuff_diastolic_bp').prop('checked', is_checked);
                $('#cuff_mean_bp').prop('checked', is_checked);
            } else {
                $('#arterial_systalic_bp').prop('checked', is_checked);
                $('#arterial_diastolic_bp').prop('checked', is_checked);
                $('#arterial_mean_bp').prop('checked', is_checked);
            }
        }
        if (!is_checked) {
            $('input[name="active_param"]').each(function() {
                if ($(this).is(':checked')) {
                    is_checked = true;
                }
            });
        }
        $('#generate-btn').attr('disabled', !is_checked);
    });
    var color = {};
    var acronym = {};
    var start_at = {};
    var end_at = {};
    var chart_time;
    
    $('#generate-btn').on('click', function() {
        $('#chart-loader').removeClass('display-none');
        old_range = [];
        var max_range = $('#selected-range').attr('max');
        $('#selected-range').val(max_range).trigger('input');
        var generate_parameter = {};
        var generate_observation = [];
        var observation_parameter = {};
        $('input[name="active_param"]:checked').each(function() {
            var key = this.value;
            var value = $('label[for="' + key + '"]').text();
            var observation_value = $('input[name="' + key + '"]').val();
            var temp_color = $('label[for="' + key + '"]').attr('data-color');
            var temp_acronym = $('label[for="' + key + '"]').attr('data-acronym');
            var start_range = $('label[for="' + key + '"]').attr('data-start-at');
            var end_range = $('label[for="' + key + '"]').attr('data-end-at');
            generate_parameter[key] = value;
            observation_parameter[key] = observation_value;
            color[key] = temp_color;
            acronym[key] = temp_acronym;
            start_at[key] = start_range;
            end_at[key] = end_range;
            generate_observation.push(observation_value);
        });
        generate_parameter = JSON.stringify(generate_parameter);
        generate_observation = JSON.stringify(generate_observation);
        $('#parameter').val(generate_parameter);
        $('#observation').val(generate_observation);
        global_observation_parameter = observation_parameter;
        var from = new Date();
        from.setMinutes(from.getMinutes() - interval);
        from.setSeconds(from.getSeconds() + 1);
        var to = new Date();
        var from_date_time = formatDate(from);
        var to_date_time = formatDate(to);
        gatherChartData(from_date_time, to_date_time);
        live_data_updation = true;
        $('#reset').parent().removeClass('reset-bg');
        setTimeout(function() {
            $('#chart-loader').addClass('display-none');
        }, 500);
    });
    $('#reset').on('click', function() {
        old_range = [];
        $('button, input[type="range"]').attr('disabled', true);
        $('input[name="active_param"]').each(function() {
            $(this).prop('checked', false);
        });
        $('#all').addClass('active').removeClass('unactive');
        $('#all').attr('title', 'Check All');
        var range_value_max = $('#selected-range').attr('max');
        var range_value = $('#selected-range').val();
        // $('#selected-range').val(range_value_max).trigger('input');
        display_event_status = false;
        apply_range = false;
        live_data_updation = false;
        $('#range-filter').removeClass('active').addClass('unactive');
        $('#display-event').removeClass('unactive').addClass('active');
        $('#add-xlabel').removeClass('active').addClass('unactive');
        $('.close').attr('data-reset', 1);
        getParameter();
    });
    $('#fast-backward').on('click', function() {
        old_range = [];
        var range_value = $('#selected-range').val();
        var range_value_min = $('#selected-range').attr('min');
        $('#selected-range').val(range_value_min).trigger('input');
        $('#old-range').val(range_value);
        if (range_value != range_value_min) {
            $('#chart-loader').removeClass('display-none');
            var starttime = chart_starting_time;
            var from = formatDate2(starttime);
            var to = formatDate2(starttime);
            from.setMinutes(from.getMinutes());
            from.setSeconds(from.getSeconds() + 1);
            to.setMinutes(to.getMinutes() + interval);
            var from_date_time = formatDate(from);
            var to_date_time = formatDate(to);
            gatherChartDataChange(from_date_time, to_date_time);
            resetRange(range);
            generateRange(from_date_time, to_date_time, xAxis);
            var chartfrom = formatDate2(from_date_time);
            chartfrom = formatDate4(chartfrom);
            var chartto = formatDate2(to_date_time);
            chartto = formatDate4(chartto);
            chart_time.set('text', chartfrom + ' to ' + chartto);
            setTimeout(function() {
                $('#chart-loader').addClass('display-none');
            }, 500);
        }
    });
    $('#step-backward').on('click', function() {
        old_range = [];
        var range_value = parseInt($('#selected-range').val()) - 1;
        $('#old-range').val(range_value);
        var range_value_min = $('#selected-range').attr('min');
        var range_value_max = $('#selected-range').attr('max');
        if (range_value > range_value_min) {
            $('#chart-loader').removeClass('display-none');
            $('#selected-range').val(range_value).trigger('input');
            var current_range = range_value_max - range_value;
            var from_range = (current_range + 1) * interval;
            var to_range = ((current_range + 1) * interval) - interval;
            var endtime = $('#endto').val();
            var from = formatDate2(endtime);
            var to = formatDate2(endtime);
            from.setMinutes(from.getMinutes() - from_range);
            from.setSeconds(from.getSeconds() + 1);
            to.setMinutes(to.getMinutes() - to_range);
            var from_date_time = formatDate(from);
            var to_date_time = formatDate(to);
            gatherChartDataChange(from_date_time, to_date_time);
            resetRange(range);
            generateRange(from_date_time, to_date_time, xAxis);
            var chartfrom = formatDate2(from_date_time);
            chartfrom = formatDate4(chartfrom);
            var chartto = formatDate2(to_date_time);
            chartto = formatDate4(chartto);
            chart_time.set('text', chartfrom + ' to ' + chartto);
            setTimeout(function() {
                $('#chart-loader').addClass('display-none');
            }, 500);
        } else {
            $('#fast-backward').trigger('click');
        }
    });
    $('#step-forward').on('click', function() {
        old_range = [];
        var range_value = parseInt($('#selected-range').val()) + 1;
        $('#old-range').val(range_value);
        var range_value_max = $('#selected-range').attr('max');
        if (range_value < range_value_max) {
            $('#chart-loader').removeClass('display-none');
            $('#selected-range').val(range_value).trigger('input');
            var current_range = range_value_max - range_value;
            var from_range = (current_range + 1) * interval;
            var to_range = ((current_range + 1) * interval) - interval;
            var endtime = $('#endto').val();
            var from = formatDate2(endtime);
            var to = formatDate2(endtime);
            from.setMinutes(from.getMinutes() - from_range);
            from.setSeconds(from.getSeconds() + 1);
            to.setMinutes(to.getMinutes() - to_range);
            var from_date_time = formatDate(from);
            var to_date_time = formatDate(to);
            gatherChartDataChange(from_date_time, to_date_time);
            resetRange(range);
            generateRange(from_date_time, to_date_time, xAxis);
            var chartfrom = formatDate2(from_date_time);
            chartfrom = formatDate4(chartfrom);
            var chartto = formatDate2(to_date_time);
            chartto = formatDate4(chartto);
            chart_time.set('text', chartfrom + ' to ' + chartto);
            setTimeout(function() {
                $('#chart-loader').addClass('display-none');
            }, 500);
        } else if (range_value == range_value_max) {
            $('#fast-forward').trigger('click');
        }
    });
    $('#fast-forward').on('click', function() {
        old_range = [];
        var range_value_max = $('#selected-range').attr('max');
        var range_value = $('#selected-range').val();
        $('#old-range').val(range_value);
        $('#selected-range').val(range_value_max).trigger('input');
        if (range_value != range_value_max) {
            $('#chart-loader').removeClass('display-none');
            var from = new Date();
            from.setMinutes(from.getMinutes() - interval);
            from.setSeconds(from.getSeconds() + 1);
            var from_date_time = formatDate(from);
            var to = new Date();
            var to_date_time = formatDate(to);
            gatherChartDataChange(from_date_time, to_date_time);
            resetRange(range);
            generateRange(from_date_time, to_date_time, xAxis);
            var chartfrom = formatDate2(from_date_time);
            chartfrom = formatDate4(chartfrom);
            var chartto = formatDate2(to_date_time);
            chartto = formatDate4(chartto);
            chart_time.set('text', chartfrom + ' to ' + chartto);
            setTimeout(function() {
                $('#chart-loader').addClass('display-none');
            }, 500);
        }
    });
    $('#selected-range').on('click', function() {
        old_range = [];
        var current_value = $(this).val();
        var old_range = $('#old-range').val();
        if (old_range != current_value) {
            if (old_range > current_value) {
                $('#step-forward').trigger('click');
            } else {
                $('#step-backward').trigger('click');
            }
        }
        $('.bubble').hide();
    });
    $("#selected-range").on("input", function() {
        $('.bubble').show();
        var val = $(this).val();
        const min = $(this).attr('min');
        const max = $(this).attr('max');
        const newVal = Number(((val - min) * 100) / (max - min));
        var endtime = $('#endto').val();
        var from = formatDate2(endtime);
        if (max == val) {
            from.setMinutes(from.getMinutes() - interval);
        } else if (min == val) {
            var starttime = chart_starting_time;
            var from = formatDate2(starttime);
        } else {
            var current_range = max - val;
            val = (current_range + 1) * interval;
            from.setMinutes(from.getMinutes() - val);
        }
        from = formatDate4(from);
        $('.bubble').html(from);
        var position_1 = 7 - (newVal * 0.15);
        $('.bubble').css({
            'left': 'calc(' + newVal + '% + ' + position_1 + 'px)'
        });
        setTimeout(function() {
            $('.bubble').hide();
        }, 100);
    });
    $('#custom-date-time-filter').on('click', function() {
        old_range = [];
        $('button, input[type="range"]').attr('disabled', true);
        $('#filter-modal button').attr('disabled', false);
        $('#filter-modal').modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
        var from_time = chart_starting_time;
        from_time = formatDate2(from_time);
        $('#from-date, #to-date').datepicker({
            dateFormat: 'dd-mm-yy',
            minDate: from_time,
            maxDate: new Date()
        });
        var from_date = new Date();
        from_date.setMinutes(from_date.getMinutes() - interval);
        var hours = from_date.getHours();
        var session = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        var mins = from_date.getMinutes();
        var secs = from_date.getSeconds();
        $('#from-date').datepicker('setDate', from_date);
        $('select[name="from_hours"]').val(hours);
        $('select[name="from_mins"]').val(mins);
        $('select[name="from_secs"]').val(secs);
        $('select[name="from_session"]').val(session);
        var to_date = new Date();
        var hours = to_date.getHours();
        var session = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        var mins = to_date.getMinutes();
        var secs = to_date.getSeconds();
        $('#to-date').datepicker('setDate', to_date);
        $('select[name="to_hours"]').val(hours);
        $('select[name="to_mins"]').val(mins);
        $('select[name="to_secs"]').val(secs);
        $('select[name="to_session"]').val(session);
        live_data_updation = false;
    });
    $('input[name="from_date"], select[name="from_hours"], select[name="from_mins"], select[name="from_secs"], select[name="from_session"]').on('change', function() {
        var date = $('input[name="from_date"]').val();
        var hours = $('select[name="from_hours"]').val();
        var mins = $('select[name="from_mins"]').val();
        var secs = $('select[name="from_secs"]').val();
        var session = $('select[name="from_session"]').val();
        if (session == 'PM') {
            if (parseInt(hours) == 12) {
                hours = 12;
            } else {
                hours = parseInt(hours) + 12;
            }
        }
        date = date.split('-');
        var new_date = new Date(date[2], (date[1] - 1), date[0], hours, mins, secs);
        if (formatDate2(chart_starting_time).getTime() > new_date.getTime()) {
            alert('Invalid date');
            $('#apply-btn').attr('disabled', true);
        } else {
            $('#apply-btn').attr('disabled', false);            
        }
        new_date.setMinutes(new_date.getMinutes() + interval);
        var day = new_date.getDate();
        day = (day > 9) ? day : '0' + day;
        var month = new_date.getMonth() + 1;
        month = (month > 9) ? month : ('0' + month);
        var year = new_date.getFullYear();
        var date = day + '-' + month + '-' + year;
        var hours = new_date.getHours();
        var session = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        var mins = new_date.getMinutes();
        var secs = new_date.getSeconds();
        $('input[name="to_date"]').val(date);
        $('select[name="to_hours"]').val(hours);
        $('select[name="to_mins"]').val(mins);
        $('select[name="to_secs"]').val(secs);
        $('select[name="to_session"]').val(session);
    });
    $('input[name="to_date"], select[name="to_hours"], select[name="to_mins"], select[name="to_secs"], select[name="to_session"]').on('change', function() {
        var date = $('input[name="to_date"]').val();
        var hours = $('select[name="to_hours"]').val();
        var mins = $('select[name="to_mins"]').val();
        var secs = $('select[name="to_secs"]').val();
        var session = $('select[name="to_session"]').val();
        if (session == 'PM') {
            if (parseInt(hours) == 12) {
                hours = 12;
            } else {
                hours = parseInt(hours) + 12;
            }
        }
        date = date.split('-');
        var new_date = new Date(date[2], (date[1] - 1), date[0], hours, mins, secs);
        new_date.setMinutes(new_date.getMinutes() - interval);
        var day = new_date.getDate();
        day = (day > 9) ? day : '0' + day;
        var month = new_date.getMonth() + 1;
        month = (month > 9) ? month : ('0' + month);
        var year = new_date.getFullYear();
        var date = day + '-' + month + '-' + year;
        var hours = new_date.getHours();
        var session = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        var mins = new_date.getMinutes();
        var secs = new_date.getSeconds();
        if (formatDate2(chart_starting_time).getTime() > new_date.getTime()) {
            alert('Invalid date');
            $('#apply-btn').attr('disabled', true);
        } else {
            $('#apply-btn').attr('disabled', false);            
        }
        $('input[name="from_date"]').val(date);
        $('select[name="from_hours"]').val(hours);
        $('select[name="from_mins"]').val(mins);
        $('select[name="from_secs"]').val(secs);
        $('select[name="from_session"]').val(session);
    });
    $('#live-param-modal').on('hidden.bs.modal', function() {
        $('#all').prop('checked', false);
    });
    $('#filter-modal').on('hidden.bs.modal', function() {
        $('button, input[type="range"]').attr('disabled', false);
    });
    $('#apply-btn').on('click', function() {
        var from_date = $('input[name="from_date"]').val();
        from_date = from_date.split('-');
        var from_hours = $('select[name="from_hours"]').val();
        var from_mins = $('select[name="from_mins"]').val();
        var from_secs = $('select[name="from_secs"]').val();
        var from_session = $('select[name="from_session"]').val();
        if (from_session == 'PM') {
            if (parseInt(from_hours) == 12) {
                from_hours = 12;
            } else {
                from_hours = parseInt(from_hours) + 12;
            }
        }
        from_hours = from_hours > 9 ? from_hours : '0' + from_hours;
        from_mins = from_mins > 9 ? from_mins : '0' + from_mins;
        from_secs = from_secs > 9 ? from_secs : '0' + from_secs;
        var from_date_time = from_date[2] + '-' + from_date[1] + '-' + from_date[0] + ' ' + from_hours + ':' + from_mins + ':' + from_secs;
        var to_date = $('input[name="to_date"]').val();
        to_date = to_date.split('-');
        var to_hours = $('select[name="to_hours"]').val();
        var to_mins = $('select[name="to_mins"]').val();
        var to_secs = $('select[name="to_secs"]').val();
        var to_session = $('select[name="to_session"]').val();
        if (to_session == 'PM') {
            if (parseInt(to_hours) == 12) {
                to_hours = 12;
            } else {
                to_hours = parseInt(to_hours) + 12;
            }
        }
        to_hours = to_hours > 9 ? to_hours : '0' + to_hours;
        to_mins = to_mins > 9 ? to_mins : '0' + to_mins;
        to_secs = to_secs > 9 ? to_secs : '0' + to_secs;
        var to_date_time = to_date[2] + '-' + to_date[1] + '-' + to_date[0] + ' ' + to_hours + ':' + to_mins + ':' + to_secs;
        var from_time = chart_starting_time;
        from_time = formatDate2(from_time);
        var from_time = Date.parse(from_time) / 1000;
        var to_time = Date.parse(new Date(to_date[2], to_date[1] - 1, to_date[0], to_hours, to_mins, to_secs)) / 1000;
        var range_value_max = Math.round((Math.abs(to_time - from_time) / 60) / interval);
        var range_value = $('#selected-range').val();
        $('#old-range').val(range_value);
        $('#selected-range').val(range_value_max).trigger('input');
        if (range_value != range_value_max) {
            $('#chart-loader').removeClass('display-none');
            gatherChartDataChange(from_date_time, to_date_time);
            resetRange(range);
            generateRange(from_date_time, to_date_time, xAxis);
            var chartfrom = formatDate2(from_date_time);
            chartfrom = formatDate4(chartfrom);
            var chartto = formatDate2(to_date_time);
            chartto = formatDate4(chartto);
            chart_time.set('text', chartfrom + ' to ' + chartto);
            setTimeout(function() {
                $('#chart-loader').addClass('display-none');
            }, 500);
        }
        $("#filter-modal").modal('hide');
    });
    var temp_array = [];
    var chart;
    var root;
    var series = [];
    var xAxis = [];
    var yAxis = [];
    var stockChart;
    var range_completed = false;
    var file_name = $("#file_name").val();

    function getParameter() {
        var from = new Date();
        from.setMinutes(from.getMinutes() - interval);
        var to = new Date();
        var from_date_time = formatDate(from);
        var to_date_time = formatDate(to);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            data: {
                mrn: mrn
            },
            url: site_base_url + '/get-interface-parameter',
            success: function(response) {
                $('#live-param-modal tbody').html(response[0]);
                $('#live-param-modal').modal({
                    backdrop: 'static',
                    keyboard: false,
                    show: true
                });
                $('button, input[type="range"]').attr('disabled', false);
                $('#generate-btn').attr('disabled', true);
            }
        });
    }
    var active_parameter = '';
    var temp_parameter = '';

    function interfaceDetails(mrn, temp_parameter, from_date_time, to_date_time, slug = '') {
        var response_data = '';
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            data: {
                mrn: mrn,
                parameter: temp_parameter,
                from_time: from_date_time,
                to_time: to_date_time,
                interval: interval,
                slug: slug,
                client_zone: client_zone
            },
            async: false,
            url: site_base_url + '/get-interface-details',
            success: function(response) {
                response_data = response;
            }
        });
        return response_data;
    }

    function gatherChartData(from_date_time, to_date_time) {
        temp_parameter = $('#observation').val();
        temp_parameter = JSON.parse(temp_parameter);
        active_parameter = JSON.parse($('#parameter').val());
        var response = interfaceDetails(mrn, temp_parameter, from_date_time, to_date_time);
        var response_result = response.results;
        data_list = response_result;
        $("#live-param-modal").modal('hide');
        resetChart();
        setTimeout(generateChart(from_date_time, to_date_time), 500);
    }
    var last;

    function generateChart(start_date_time, end_date_time) {
        if (Object.keys(series).length > 0) {
            chart = '';
            root = '';
            series = [];
            xAxis = [];
            yAxis = [];
            range_completed = false;
        }
        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        root = am5.Root.new("chartdiv");
        // Set themes
        //https: //www.amcharts.com/docs/v5/concepts/themes/
        var myTheme = am5.Theme.new(root);
        myTheme.rule("Label").setAll({
            fill: am5.color(0xFFFFFF)
        });
        myTheme.rule("Grid").setAll({
            stroke: "#1b1b1b",
            strokeWidth: 0.4,
        });
        root.setThemes([
            // am5themes_Animated.new(root),
            am5themes_Responsive.new(root),
            myTheme
        ]);
        // Create a stock chart
        // https://www.amcharts.com/docs/v5/charts/stock-chart/#Instantiating_the_chart
        stockChart = root.container.children.push(am5stock.StockChart.new(root, {}));
        var easing = am5.ease.linear;
        var colorSet = am5.ColorSet.new(root, {});
        var p = 1;
        $('#chartdiv').css('height', 0);
        var parameters = Object.keys(active_parameter);
        var parameter_count = parameters.length;
        var height_approx = parameter_count * param_field_height;
        var calc_height = param_field_height;
        if (height_approx < page_height) {
            calc_height = page_height / parameter_count;
        }
        last = parameters[parameter_count - 1];
        var setheight = initial_height;
        $.each(active_parameter, function(key, value) {
            var current_observation = global_observation_parameter[key];
            setheight = setheight + calc_height;
            createSeries(value, key, current_observation, p, setheight);
            $('#chartdiv').css('height', setheight);
            p++;
        });

        individual_height = calc_height;
        whole_height = setheight - initial_height;
        // Add titles
        stockChart.children.unshift(am5.Label.new(root, {
            text: baby_details + "[/]",
            fontSize: 14,
            textAlign: "center",
            x: am5.percent(50),
            centerX: am5.percent(50),
            paddingTop: 0,
            paddingBottom: 30
        }));
        stockChart.children.unshift(am5.Label.new(root, {
            text: baby_name,
            fontSize: 20,
            fontWeight: "bold",
            textAlign: "center",
            x: am5.percent(50),
            centerX: am5.percent(50),
            paddingTop: 0,
            paddingBottom: 0
        }));
        // Make stuff animate on load
        // https://www.amcharts.com/docs/v5/concepts/animations/
        chart.appear(1000, 100);
        // Set up export and annotation
        var exporting = am5plugins_exporting.Exporting.new(root, {
            dataSource: whole_data,
            pageOrigin: false,
            menu: am5plugins_exporting.ExportingMenu.new(root, {}),
            filePrefix: file_name,
            pdfOptions: {
                addURL: false
            }
        });
        var annotator = am5plugins_exporting.Annotator.new(root, {});
        exporting.get("menu").set("items", [{
            label: "Export"
        }, {
            type: "separator"
        }, {
            type: "format",
            format: "png",
            label: "PNG"
        }, {
            type: "format",
            format: "jpg",
            label: "JPG"
        }, {
            type: "format",
            format: "pdf",
            label: "PDF"
            // }, {
            //     type: "separator"
            // }, {
            //     type: "format",
            //     format: "csv",
            //     label: "CSV"
            // }, {
            //     type: "format",
            //     format: "xlsx",
            //     label: "XLSX"
            // }, {
            //     type: "format",
            //     format: "json",
            //     label: "JSON"
        }, {
            type: "separator"
        }, {
            type: "format",
            format: "print",
            label: "PRINT"
        }, {
            type: "separator"
        }, {
            type: "custom",
            label: "Annotate",
            callback: function() {
                this.close();
                annotator.toggle();
            }
        }]);
        chart.zoomOutButton.set("forceHidden", true);
        setTimeout(function() {
            $('.chartdatetime').removeClass('display-none');
            $('.chartrange').removeClass('display-none-must');
            $('#reset').removeClass('display-none');
            $('#custom-date-time-filter').removeClass('display-none');
            $('#range-filter').removeClass('display-none');
            $('#display-event').removeClass('display-none');
            // $('#display-event').trigger('click');
            $('#add-xlabel').removeClass('display-none');
            generateRange(start_date_time, end_date_time, xAxis);
            var chartfrom = formatDate2(start_date_time);
            chartfrom = formatDate4(chartfrom);
            var chartto = formatDate2(end_date_time);
            chartto = formatDate4(chartto);
            chart_time = stockChart.children.push(am5.Label.new(root, {
                text: chartfrom + ' to ' + chartto,
                fontSize: 14,
                fontWeight: "bold",
                textAlign: "center",
                x: am5.percent(50),
                centerX: am5.percent(50),
                y: am5.percent(98),
                paddingBottom: 15
            }));
        }, 100);
        setTimeout(function() {
            $('#chart-loader').addClass('display-none');
        }, 500);
    }

    function getEventList(mrn, from_date_time, to_date_time) {
        var response_result = '';
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            data: {
                mrn: mrn,
                from_time: from_date_time,
                to_time: to_date_time,
                client_zone : client_zone
            },
            async: false,
            url: site_base_url + '/get-event-list',
            success: function(response) {
                response_result = response;
            }
        });
        return response_result;
    }

    function generateRange(from_date_time, to_date_time, xAxis) {
        var response = getEventList(mrn, from_date_time, to_date_time);
        var temp_event = [];
        var temp_event_name = [];
        event_info = [];
        $.each(response, function(event_index, event_details) {
            var event_start_date_time = event_details.start;
            var event_stop_date_time = temp_event_stop_date_time = event_details.stop;

            var event_time_details = formatDate4(new Date(event_start_date_time.replace(/\s/, 'T'))).split(' ')[1] + ' to ' + (event_stop_date_time == '' || event_stop_date_time == null ? '...' : (formatDate4(new Date(temp_event_stop_date_time.replace(/\s/, 'T'))).split(' ')[1]));
            
            var eventname = event_details.event + '_' + event_details.event_code + '_' + event_index;
            if (event_start_date_time == '' || event_start_date_time == null) {
                event_start_date_time = formatDate2(from_date_time).getTime();
            } else {
                event_start_date_time = formatDate2(event_start_date_time).getTime();
            }
            if (event_stop_date_time == '' || event_stop_date_time == null) {
                event_stop_date_time = formatDate2(to_date_time).getTime();
            } else {
                event_stop_date_time = formatDate2(event_stop_date_time).getTime();
            }
            var event_img_name = event_details.event_code;
            var event_name = event_details.event_code + '_' + event_start_date_time;
            var event_start_date = formatDate2(to_date_time).getTime() - interval * 60 * 1000;
            var event_end_date = formatDate2(to_date_time).getTime();
            if (jQuery.inArray(event_name, temp_event) === -1 && !((event_start_date >= event_stop_date_time) && (event_stop_date_time <= event_end_date))) {
                temp_event.push(event_name);
                temp_event_name.push(event_img_name);
                event_info[event_img_name] = typeof event_info[event_img_name] != 'undefined' ? (event_info[event_img_name] + '<br/>' + event_time_details) : event_time_details;
                if (event_start_date >= event_start_date_time) {
                    event_start_date_time = event_start_date;
                }
                createRange(event_start_date_time, event_stop_date_time, Object.keys(series)[0], xAxis, 0, eventname, event_img_name, from_date_time);
            }
        });
        $('input[name="current_event_list"]').val(JSON.stringify(temp_event));
        $('input[name="current_event_name"]').val(JSON.stringify(temp_event_name));
        var event_name_list = $('input[name="event_name"]').val();
        event_name_list = JSON.parse(event_name_list);
        var active_event_list = '';
        $.each(event_name_list, function(key, value) {
            if (jQuery.inArray(key, temp_event_name) !== -1) {
                var img_name = key.toLowerCase().replace(/ /g, '-').replace(/[-]+/g, '-').replace(/[^\w-]+/g, '');
                active_event_list += '<li><img src="' + public_url + '/img/event_icons/icons/' + img_name + '.svg"> ' + value + '<br/><span class="event-info">'+event_info[key]+'<span></li>';
            }
        });
        if (active_event_list != '') {
            $('#event-name-list').removeClass('display-none').find('ul').html(active_event_list);
            $('.control-container').removeClass('default');
            $('.btn-container').addClass('btn-container2');
        } else {
            $('#event-name-list').addClass('display-none').find('ul').html('');
            $('.control-container').addClass('default');
            $('.btn-container').removeClass('btn-container2');
        }
    }

    function createSeries(name, field, current_observation, count, height) {
        // Create a main stock panel (chart)
        // https://www.amcharts.com/docs/v5/charts/stock-chart/#Adding_panels
        chart = stockChart.panels.push(am5stock.StockPanel.new(root, {
            focusable: true,
            panX: false,
            panY: false,
            paddingTop: 0,
        }));
        chart.plotsContainer.set("background", am5.Rectangle.new(root, {
            fill: "#000000",
            stroke: "#1b1b1b",
            // strokeOpacity: 1
        }));
        chart.panelControls.downButton.set("forceHidden", true);
        chart.panelControls.upButton.set("forceHidden", true);
        chart.panelControls.closeButton.set("forceHidden", true);

        // Create axes
        // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
        let tool_tip = am5.Tooltip.new(root, {});
        var active_parameter = JSON.parse($('#parameter').val());
        xAxis[field] = chart.xAxes.push(am5xy.DateAxis.new(root, {
            width: am5.p75,
            maxDeviation: 0.5,
            groupData: false,
            baseInterval: {
                timeUnit: "second",
                count: 1
            },
            renderer: am5xy.AxisRendererX.new(root, {
                fixedWidthGrid: true,
                minGridDistance: parseInt(width/6),
                // maxGridDistance: parseInt(width/6),
            }),
            tooltip: am5.Tooltip.new(root, {}),
            fillRule: function(dataItem) {
                var axisFill = dataItem.get("axisFill");
                axisFill.setPrivate("visible", true);
            },
        }));
        xAxis[field].get("periodChangeDateFormats")["second"] = "HH:mm";
        xAxis[field].get("renderer").labels.template.set("fontWeight", "bold");

        // xAxis[field].setAll({
        //   background: am5.Rectangle.new(root, {
        //     fill: '#000000',
        //     fillOpacity: 0.2
        //   })
        // });

        yAxis[field] = chart.yAxes.push(am5xy.ValueAxis.new(root, {
            height: am5.percent(100),
            x: am5.percent(100),
            centerX: am5.percent(100),
            renderer: am5xy.AxisRendererY.new(root, {
                fixedWidthGrid: true,
                minGridDistance: 30,
                maxGridDistance: 30,
            }),
        }));
        // Add series
        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
        var connect_option = false;
        series[field] = chart.series.push(am5xy.LineSeries.new(root, {
            name: acronym[field],
            connect: connect_option,
            xAxis: xAxis[field],
            yAxis: yAxis[field],
            valueYField: "value",
            valueXField: "date",
            calculateAggregates: true,
            legendLabelText: "[bold {stroke}]{name}[/] [bold " + color[field] + "]{valueY}[/]",
            legendRangeLabelText: "[bold {stroke}]{name}[/] [bold " + color[field] + "]{valueYClose}[/]",
            // legendLabelText: "[bold {stroke}]{name}[/] [bold #FFFFFF]{valueY}[/]",
            // legendRangeLabelText: "[bold {stroke}]{name}[/] [bold #FFFFFF]{valueYClose}[/]",
            stroke: color[field],
        }));

        // Add a stock legend
        // https://www.amcharts.com/docs/v5/charts/stock-chart/stock-legend/
        var valueLegend = chart.plotContainer.children.push(am5stock.StockLegend.new(root, {
            stockChart: stockChart,
            clickTarget: "none",
            x: -15,
        }));
        valueLegend.labels.template.setAll({
            fontSize: 18,
        });
        valueLegend.itemContainers.template.setAll({
            width: 0,
            height: 0
        });
        // valueLegend.itemContainers.template.setAll({
        //     paddingTop: 0,
        //     paddingBottom: 0,
        //     paddingLeft: 0,
        //     paddingRight: 0
        // });
        valueLegend.markers.template.setAll({
            width: 0,
            height: 0
        });
        valueLegend.settingsButtons.template.set("forceHidden", true);
        valueLegend.data.setAll([series[field]]);
        if (current_observation == 'MDC_PRESS_CUFF_DIA' || current_observation == 'MDC_PRESS_CUFF_MEAN' || current_observation == 'MDC_PRESS_CUFF_SYS') {
            // Add bullet
            // https://www.amcharts.com/docs/v5/charts/xy-chart/series/#Bullets
            series[field].bullets.push(function() {
                return am5.Bullet.new(root, {
                    sprite: am5.Circle.new(root, {
                        radius: 2,
                        fill: color[field]
                    })
                });
            });
        }
        series[field].strokes.template.setAll({
            templateField: "strokeSettings",
            strokeWidth: 2
        });
        var tooltip = am5.Tooltip.new(root, {
            getFillFromSprite: false,
            autoTextColor: false,
            textAlign: "center",
            labelText: "[bold]{valueY}[/][100]"
        });
        tooltip.label.setAll({
            fill: am5.color(0xFFFFFF),
            fontWeight: "800"
        });
        tooltip.get("background").setAll({
            fill: am5.color(0x000000)
        });
        var observation_data = data_list;
        whole_data.push(observation_data);
        series[field].data.setAll(observation_data[current_observation]);
        // Set main value series
        // https://www.amcharts.com/docs/v5/charts/stock-chart/#Setting_main_series
        stockChart.set("stockSeries", series[field]);
        // Add cursor
        // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
        var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {
            behavior: "none",
            xAxis: xAxis[field]
        }));
        cursor.lineY.set("visible", false);
        if (field != last) {
            xAxis[field].set("tooltip", false);
            xAxis[field].get("renderer").labels.template.set("fill", '#898989');
            xAxis[field].get("renderer").labels.template.set("forceHidden", true);
        }
        yAxis[field].get("renderer").labels.template.set("fill", color[field]);
        series[field].set("tooltip", tooltip);
        chart.panelControls.expandButton.current_param = field;
        chart.panelControls.expandButton.events.on("click", function(ev) {
            if (label_hidden) {
                xAxis[field].get("renderer").labels.template.set("fill", '#FFFFFF');
                xAxis[field].get("renderer").labels.template.set("forceHidden", false);
                yAxis[field].get("renderer").labels.template.set("fontWeight", "bold");
                yAxis[field].get("renderer").labels.template.set("fontSize", 14);
                yAxis[field].get("renderer").labels.template.set("forceHidden", false);
                $.each(active_parameter, function(key, value) {
                    if (ev.target.current_param != key) {
                        series[key].get("tooltip").set("forceHidden", true);
                    }
                });
                var event_icon_height = whole_height - 50;
                eventIconConfig(ev.target.current_param, event_icon_height);
                $('#custom-date-time-filter, #display-event, #add-xlabel').addClass('display-none');
                label_hidden = false;
            } else {
                xAxis[field].get("renderer").labels.template.set("fill", '#898989');
                if (!display_x_axis_label) {
                    xAxis[field].get("renderer").labels.template.set("forceHidden", true);
                }
                yAxis[field].get("renderer").labels.template.set("fontSize", 10);
                $.each(active_parameter, function(key, value) {
                    if (ev.target.current_param != key) {
                        series[key].get("tooltip").set("forceHidden", false);
                    }
                });
                var event_icon_height = individual_height - 20;
                eventIconConfig(ev.target.current_param, event_icon_height, true);
                $('#custom-date-time-filter, #display-event, #add-xlabel').removeClass('display-none');
                label_hidden = true;
            }
        });
    }

    function eventIconConfig(current_param, height, display = false) {
        var first_param = Object.keys(global_observation_parameter)[0];
        $.each(Object.keys(rangeDataItem), function(r_key, value) {
            var param_name = value.split('|')[0];
            if (param_name != first_param && typeof bullet[value] !== 'undefined') {
                bullet[value].set("forceHidden", display);
            }
            if (current_param == param_name && typeof bullet[value] !== 'undefined' && typeof rangeDataItem[value] !== 'undefined') {
                bullet[value].adapters.add("y", function(y, target) {
                    if (!display_x_axis_label) {
                        return -1 * height;
                    } else {
                        return -1 * (height - 20);
                    }
                });
                rangeDataItem[value].set("bullet", am5xy.AxisBullet.new(root, {
                    sprite: bullet[value]
                }));
            }
        });
    }
    var rangeDataItem = [];
    var range = [];
    var old_range = [];
    var bullet = [];
    var range_names = [];
    // Create axis ranges
    // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/axis-ranges/
    function createRange(start_value, end_value, field, xAxis, count, display_event, event_img_name, start_from) {
        var temp_event_img_name = event_img_name;
        var event_img_name = event_img_name.toLowerCase().replace(/ /g, '-').replace(/[-]+/g, '-').replace(/[^\w-]+/g, '');
        var event_name = display_event.split('_')[0];
        $.each(Object.keys(series), function(key, value) {
            var display_event_name = display_event.replace(/[ ]/g, '');
            display_event_name = value + '|' + display_event_name;
            if (typeof xAxis[value] !== 'undefined' && typeof display_event_name !== 'undefined') {
                rangeDataItem[display_event_name] = xAxis[value].makeDataItem({
                    value: start_value,
                    endValue: end_value
                });
                range[display_event_name] = xAxis[value].createAxisRange(rangeDataItem[display_event_name]);
                rangeDataItem[display_event_name].get("axisFill").setAll({
                    fill: event_color[temp_event_img_name],
                    fillOpacity: 0.2,
                });
                rangeDataItem[display_event_name].get("grid").set("visible", false);
                bullet[display_event_name] = am5.Picture.new(root, {
                    width: 40,
                    height: 40,
                    centerX: am5.percent(50),
                    centerY: am5.percent(100),
                    src: public_url + "/img/event_icons/icons/" + event_img_name + ".svg",
                    fill: am5.color(0xFFFFFF),
                    stroke: root.interfaceColors.get("background"),
                    strokeWidth: 2,
                    tooltipText: event_name,
                    showTooltipOn: "hover",
                    tooltip: am5.Tooltip.new(root, {})
                });
                var timing = start_value + ':' + end_value;
                var count = {};
                old_range.forEach(function(i) {
                    count[i] = (count[i] || 0) + 1;
                });
                var event_position = eventPosition(end_value, start_value, formatDate2(start_from).getTime());
                bullet[display_event_name].adapters.add("x", function(x, target) {
                    return event_position;
                });
                bullet[display_event_name].adapters.add("y", function(y, target) {
                    if (!display_x_axis_label) {
                        return -1 * individual_height;
                    } else {
                        return -1 * (individual_height - 20);
                    }
                });
                rangeDataItem[display_event_name].set("bullet", am5xy.AxisBullet.new(root, {
                    sprite: bullet[display_event_name]
                }));
                if (display_event_status) {
                    rangeDataItem[display_event_name].get("axisFill").set('visible', true);
                    if (field != value) {
                        bullet[display_event_name].set("forceHidden", true);
                    }
                } else {
                    rangeDataItem[display_event_name].get("axisFill").set('visible', false);
                    bullet[display_event_name].set("forceHidden", true);
                }
                range_names.push(display_event_name);
                old_range.push(timing);
            }
        });
    }

    function drawNormalRange(field) {
        if (apply_range) {
            var chart_min_value = parseFloat(yAxis[field]._minReal);
            var chart_max_value = parseFloat(yAxis[field]._maxReal);
            var temp_array = [];
            if ($.isNumeric(chart_min_value)) {
                temp_array.push(chart_min_value);
            }
            if ($.isNumeric(chart_max_value)) {
                temp_array.push(chart_max_value);
            }
            var normal_start_at = parseFloat(start_at[field]);
            if ($.isNumeric(normal_start_at)) {
                temp_array.push(normal_start_at);
            }
            var normal_end_at = parseFloat(end_at[field]);
            if ($.isNumeric(normal_end_at)) {
                temp_array.push(normal_end_at);
            }
            temp_array.sort(function(a, b) {
                return a - b
            });
            var min_range = temp_array[0];
            var max_range = temp_array[temp_array.length - 1];
            yAxis[field].set('min', parseFloat(min_range));
            yAxis[field].set('max', parseFloat(max_range));
        } else {
            yAxis[field].set('min', 'undefined');
            yAxis[field].set('max', 'undefined');
        }
    }

    function resetChart() {
        if (typeof root !== 'undefined') {
            root.dispose();
            chart.dispose();
            $('.chartdatetime').addClass('display-none');
            $('#reset').addClass('display-none');
            var active_parameter = JSON.parse($('#parameter').val());
            var active_parameter_count = Object.keys(active_parameter).length;
            var height_approx = active_parameter_count * param_field_height;
            var calc_height = param_field_height;
            if (height_approx < page_height) {
                calc_height = page_height / active_parameter_count;
            }
            var setheight = active_parameter_count * calc_height;
            // $('#chart-loader').css('height', setheight + 100);
            individual_height = calc_height;
            whole_height = setheight;
            $('#chart-loader').removeClass('display-none');
        }
    }

    function formatDate(formatdate) {
        var date = (formatdate.getDate() > 9) ? formatdate.getDate() : '0' + formatdate.getDate();
        var month = ((formatdate.getMonth() + 1) > 9) ? (formatdate.getMonth() + 1) : ('0' + (formatdate.getMonth() + 1));
        var year = formatdate.getFullYear();
        var hours = (formatdate.getHours() > 9) ? formatdate.getHours() : '0' + formatdate.getHours();
        var minutes = (formatdate.getMinutes() > 9) ? formatdate.getMinutes() : '0' + formatdate.getMinutes();
        var seconds = (formatdate.getSeconds() > 9) ? formatdate.getSeconds() : '0' + formatdate.getSeconds();
        var date_time = year + '-' + month + '-' + date + ' ' + hours + ':' + minutes + ':' + seconds;
        return date_time;
    }

    function formatDate2(formatdate) {
        var formatdate = formatdate.split(' ');
        var date = formatdate[0].split('-');
        var time = formatdate[1].split(':');
        var day = date[2];
        var month = date[1] - 1;
        var year = date[0];
        var hours = time[0];
        var minutes = time[1];
        var seconds = time[2];
        var formatted_date = new Date(year, month, day, hours, minutes, seconds);
        return formatted_date;
    }

    function formatDate3(formatdate) {
        var date = (formatdate.getDate() > 9) ? formatdate.getDate() : '0' + formatdate.getDate();
        var month = (formatdate.getMonth() > 9) ? formatdate.getMonth() : ('0' + formatdate.getMonth());
        var year = formatdate.getFullYear();
        var hours = formatdate.getHours();
        var minutes = formatdate.getMinutes();
        var seconds = formatdate.getSeconds();
        var formatted_date = new Date(year, month, date, hours, minutes, seconds);
        return formatted_date;
    }

    function formatDate4(formatdate) {
        var date = (formatdate.getDate() > 9) ? formatdate.getDate() : '0' + formatdate.getDate();
        var month = ((formatdate.getMonth() + 1) > 9) ? (formatdate.getMonth() + 1) : ('0' + (formatdate.getMonth() + 1));
        var year = formatdate.getFullYear();
        var hours = (formatdate.getHours() > 9) ? formatdate.getHours() : '0' + formatdate.getHours();
        var minutes = (formatdate.getMinutes() > 9) ? formatdate.getMinutes() : '0' + formatdate.getMinutes();
        var seconds = (formatdate.getSeconds() > 9) ? formatdate.getSeconds() : '0' + formatdate.getSeconds();
        var date_time = date + '-' + month + '-' + year + ' ' + hours + ':' + minutes + ':' + seconds;
        return date_time;
    }

    function gatherChartDataChange(from_date_time, to_date_time) {
        $('button, input[type="range"]').attr('disabled', true);
        temp_parameter = $('#observation').val();
        temp_parameter = JSON.parse(temp_parameter);
        var response = interfaceDetails(mrn, temp_parameter, from_date_time, to_date_time);
        var response_result = response.results;
        $.each(active_parameter, function(parameter_key, parameter_value) {
            var observation_name = global_observation_parameter[parameter_key];
            $.each(response_result[observation_name], function(key, value) {
                series[parameter_key].data.removeIndex(0);
                series[parameter_key].data.push(value);
            });
            final_parameter_key = parameter_key;
        });
        $('button, input[type="range"]').attr('disabled', false);
    }

    function addDataPoint(mrn, temp_parameter, from_date_time, to_date_time) {
        var response = interfaceDetails(mrn, temp_parameter, from_date_time, to_date_time, 'add');
        var add_response_result = response.results;
        var final_parameter_key = '';
        $.each(active_parameter, function(parameter_key, parameter_value) {
            var observation_name = global_observation_parameter[parameter_key];
            $.each(add_response_result[observation_name], function(key, value) {
                var found_index = series[parameter_key].data._values.findIndex(x => x.date === value.date);
                if (found_index > 0) {
                    if (series[parameter_key].data._values[found_index].value == null && value.value != null) {
                        series[parameter_key].data.removeIndex(found_index);
                        series[parameter_key].data.push(value);
                    }
                } else {
                    series[parameter_key].data.removeIndex(0);
                    series[parameter_key].data.push(value);
                }
            });
            final_parameter_key = parameter_key;
        });
        var from_datetime = series[final_parameter_key].data._values[0].date;
        var to_datetime = series[final_parameter_key].data._values[series[final_parameter_key].data._values.length - 1].date;
        var chartfrom = formatDate4(new Date(from_datetime));
        var chartto = formatDate4(new Date(to_datetime));
        $('#endto').val(formatDate(new Date(to_datetime)));
        $('#rangeend').html(chartto);
        chart_time.set('text', chartfrom + ' to ' + chartto);
    }

    function addEvent(mrn, from_date_time, to_date_time) {
        var response = getEventList(mrn, from_date_time, to_date_time);
        var temp_event = JSON.parse($('input[name="current_event_list"]').val());
        var temp_event_name = JSON.parse($('input[name="current_event_name"]').val());
        event_info = [];
        $.each(response, function(event_index, event_details) {
            var event_start_date_time = event_details.start;
            var event_stop_date_time = temp_event_stop_date_time = event_details.stop;
            var eventname = event_details.event + '_' + event_details.event_code + '_' + event_index;

            var event_time_details = formatDate4(new Date(event_start_date_time.replace(/\s/, 'T'))).split(' ')[1] + ' to ' + (event_stop_date_time == '' || event_stop_date_time == null ? '...' : (formatDate4(new Date(temp_event_stop_date_time.replace(/\s/, 'T'))).split(' ')[1]));

            if (event_start_date_time == '' || event_start_date_time == null) {
                event_start_date_time = formatDate2(from_date_time).getTime();
            } else {
                event_start_date_time = formatDate2(event_start_date_time).getTime();
            }
            if (event_stop_date_time == '' || event_stop_date_time == null) {
                event_stop_date_time = formatDate2(to_date_time).getTime();
            } else {
                event_stop_date_time = formatDate2(event_stop_date_time).getTime();
            }
            var event_img_name = event_details.event_code;
            var event_name = event_details.event_code + '_' + event_start_date_time;
            var event_start_date = formatDate2(to_date_time).getTime() - interval * 60 * 1000;
            var event_end_date = formatDate2(to_date_time).getTime();
            if (jQuery.inArray(event_name, temp_event) === -1) {
                if (event_start_date <= event_start_date_time && event_stop_date_time <= event_end_date) {
                    temp_event.push(event_name);
                    temp_event_name.push(event_img_name);
                    event_info[event_img_name] = typeof event_info[event_img_name] != 'undefined' ? (event_info[event_img_name] + '<br/>' + event_time_details) : event_time_details;
                    createRange(event_start_date_time, event_stop_date_time, Object.keys(series)[0], xAxis, 0, eventname, event_img_name, from_date_time);
                }
            } else {
                var range_value_max = $('#selected-range').attr('max');
                var range_value = $('#selected-range').val();
                $.each(Object.keys(series), function(key, value) {
                    var display_event_name = eventname.replace(/[ ]/g, '');
                    var custom_eventname = value + '|' + display_event_name;
                    if (typeof event_info[event_img_name] != 'undefined') {
                        if (event_info[event_img_name].indexOf(event_time_details) == -1) {
                            event_info[event_img_name] = event_info[event_img_name] + '<br/>' + event_time_details;
                        }
                    } else {
                        event_info[event_img_name] = event_time_details;                            
                    }

                    if (event_stop_date_time != '' && event_stop_date_time != null && typeof rangeDataItem[custom_eventname] != 'undefined') {
                        if ((event_details.stop == '' || event_details.stop == null) && (range_value_max == 0 || range_value_max == range_value) && temp_parameter.toString().length > 0) {
                            rangeDataItem[custom_eventname].set("endValue", event_stop_date_time);
                        }
                        var from_datetime = formatDate2(from_date_time).getTime();
                        if (event_start_date_time < from_datetime) {
                            event_start_date_time = series[value].data._values[0].date;
                            from_datetime = event_start_date_time;
                        }
                        var event_position = eventPosition(event_stop_date_time, event_start_date_time, from_datetime);
                        bullet[custom_eventname].adapters.add("x", function(x, target) {
                            return event_position;
                        });
                    }
                });
            }
        });

        $('input[name="current_event_list"]').val(JSON.stringify(temp_event));
        $('input[name="current_event_name"]').val(JSON.stringify(temp_event_name));
        var event_name_list = $('input[name="event_name"]').val();
        event_name_list = JSON.parse(event_name_list);
        var active_event_list = '';
        $.each(event_name_list, function(key, value) {
            if (jQuery.inArray(key, temp_event_name) !== -1) {
                var img_name = key.toLowerCase().replace(/ /g, '-').replace(/[-]+/g, '-').replace(/[^\w-]+/g, '');
                active_event_list += '<li><img src="' + public_url + '/img/event_icons/icons/' + img_name + '.svg"> ' + value + '<br/><span class="event-info">'+event_info[key]+'</span></li>';
            }
        });
        if (active_event_list != '') {
            $('#event-name-list').removeClass('display-none').find('ul').html(active_event_list);
            $('.control-container').removeClass('default');
            $('.btn-container').addClass('btn-container2');
        } else {
            $('#event-name-list').addClass('display-none').find('ul').html('');
            $('.control-container').addClass('default');
            $('.btn-container').removeClass('btn-container2');
        }
    }

    function eventPosition(event_stop_date_time, event_start_date_time, from_datetime) {
        var range_filled_count = event_stop_date_time - event_start_date_time;
        range_filled_count = range_filled_count / 1000;
        var chart_start_value = from_datetime;
        chart_start_value = chart_start_value / 1000;
        var range_diff = (event_start_date_time / 1000) - chart_start_value;
        range_diff = range_diff + (range_filled_count / 2);
        var micro_data = display_time;
        var single_position = micro_data / width;
        var event_position = range_diff / single_position;
        return event_position;
    }

    // Update data every 5 second
    setInterval(function() {
        $('#chart-data2').val('');
        var patient_status = $('#patient_status').val();
        var range_value_max = $('#selected-range').attr('max');
        var range_value = $('#selected-range').val();
        if (live_data_updation && !$('#login-modal').hasClass('in') && patient_status == 'Inpatient') {
            if ((range_value_max == 0 || range_value_max == range_value) && temp_parameter.toString().length > 0) {
                var from = new Date();
                from.setMinutes(from.getMinutes() - 5);
                var to = new Date();
                var endto = $('#endto').val();
                var endto = formatDate2(endto);
                if (endto.getTime() < from) {
                    from = endto;
                }
                var from_date_time = formatDate(from);
                var to_date_time = formatDate(to);
                var temp = new Date();
                var temp = formatDate3(temp);
                temp.setMinutes(temp.getMinutes() - 5);
                temp_array = [];
                temp_array1 = [];
                for (var i = 0; i < 300; i++) {
                    if (i > 0) {
                        temp.setSeconds(temp.getSeconds() + 1);
                    }
                    temp_array[i] = temp.getTime();
                    temp_array1[i] = new Date(temp.getTime());
                }
                addDataPoint(mrn, temp_parameter, from_date_time, to_date_time);
                var from_date_time = new Date(formatDate2(from_date_time));
                from_date_time.setMinutes(from_date_time.getMinutes() - (interval - 5));
                var from_date_time = formatDate(from_date_time);
                addEvent(mrn, from_date_time, to_date_time);
            }
        }
        width = $('#chartdiv').width() - 72;
    }, 5000);
    $('.close').on('click', function() {
        var modal_status = $(this).attr('data-reset');
        if (modal_status == 0) {
            $('#reset').removeClass('display-none');
            $('#reset').parent().addClass('reset-bg');
        } else {
            $('#live-param-modal').hide();
            live_data_updation = true;
        }
    });
    // Draw the normal range
    var normalRangeStartDataItem = [];
    var normalRangeEndDataItem = [];
    $('#range-filter').on('click', function() {
        $('#range-filter').attr('disabled', true);
        var params_list = Object.keys(yAxis);
        if (!apply_range) {
            $(this).removeClass('unactive').addClass('active');
            $.each(params_list, function(index, field) {
                var custom_field_name = field + '_c';
                if (field == 'cuff_systalic_bp' || field == 'cuff_diastolic_bp' || field == 'cuff_mean_bp' || field == 'arterial_systalic_bp' || field == 'arterial_mean_bp' || field == 'arterial_diastolic_bp') {
                    start_at[field] = 0;
                    end_at[field] = g_weeks;
                }
                var normal_start_at = '';
                if (!(field == 'oxygen_saturation_index' && g_weeks <= 34)) {
                    normal_start_at = start_at[field];
                }
                var normal_end_at = '';
                normal_end_at = end_at[field];
                if (normal_start_at != '') {
                    normalRangeStartDataItem[custom_field_name] = yAxis[field].makeDataItem({
                        value: normal_start_at
                    });
                    var start_range = yAxis[field].createAxisRange(normalRangeStartDataItem[custom_field_name]);
                    start_range.get("grid").setAll({
                        stroke: '#FFFFFF',
                        // strokeOpacity: 1,
                        // strokeWidth: 1,
                    });
                }
                if (normal_end_at != '') {
                    normalRangeEndDataItem[custom_field_name] = yAxis[field].makeDataItem({
                        value: normal_end_at
                    });
                    var end_range = yAxis[field].createAxisRange(normalRangeEndDataItem[custom_field_name]);
                    end_range.get("grid").setAll({
                        stroke: '#FFFFFF',
                        // strokeOpacity: 1,
                        // strokeWidth: 1,
                    });
                }
                if (typeof normalRangeStartDataItem[custom_field_name] != 'undefined') {
                    normalRangeStartDataItem[custom_field_name].get("grid").set("visible", true);
                }
                if (typeof normalRangeEndDataItem[custom_field_name] != 'undefined') {
                    normalRangeEndDataItem[custom_field_name].get("grid").set("visible", true);
                }
                apply_range = true;
                drawNormalRange(field);
            });
        } else {
            $(this).addClass('unactive').removeClass('active');
            $.each(params_list, function(index, field) {
                var custom_field_name = field + '_c';
                if (typeof normalRangeStartDataItem[custom_field_name] != 'undefined') {
                    normalRangeStartDataItem[custom_field_name].get("grid").set("visible", false);
                }
                if (typeof normalRangeEndDataItem[custom_field_name] != 'undefined') {
                    normalRangeEndDataItem[custom_field_name].get("grid").set("visible", false);
                }
                apply_range = false;
                drawNormalRange(field);
            });
        }
        $('#range-filter').attr('disabled', false);
    });
    $('#display-event').on('click', function() {
        var first_param = Object.keys(global_observation_parameter)[0];
        if (!display_event_status) {
            display_event_status = true;
            $(this).removeClass('unactive').addClass('active');
            $.each(Object.keys(rangeDataItem), function(r_key, value) {
                var param_name = value.split('|')[0];
                if (param_name == first_param) {
                    bullet[value].set("forceHidden", false);
                }
                rangeDataItem[value].get("axisFill").set('visible', true);
            });
        } else {
            $(this).addClass('unactive').removeClass('active');
            display_event_status = false;
            $.each(Object.keys(rangeDataItem), function(r_key, value) {
                bullet[value].set("forceHidden", true);
                rangeDataItem[value].get("axisFill").set('visible', false);
            });
        }
    });

    $('#add-xlabel').on('click', function() {
        if (!display_x_axis_label) {
            $(this).removeClass('unactive').addClass('active');
            display_x_axis_label = true;
            $.each(active_parameter, function(key, value) {
                xAxis[key].get("renderer").labels.template.set("forceHidden", false);
            });
        } else {
            $(this).addClass('unactive').removeClass('active');
            display_x_axis_label = false;
            $.each(active_parameter, function(key, value) {
                if (key != last) {
                    xAxis[key].get("renderer").labels.template.set("forceHidden", true);
                }
            });
        }
    });

    function resetRange(range) {
        $.each(Object.keys(range), function(key, value) {
            var series_value = value.split('|')[0];
            if (typeof xAxis[series_value] != 'undefined') {
                xAxis[series_value].axisRanges.removeValue(range[value]);
            }
            if (typeof rangeDataItem[value].get("bullet") != 'undefined') {
                rangeDataItem[value].get("bullet").dispose();
            }
        });
        width = $('#chartdiv').width() - 72;
    }

    $('#event-with-time').on('click', function() {
        $(this).toggleClass('transform-180');
        $('#event-name-list').toggleClass('hide-event-time');
    });

    $('#time-interval').on('click', function() {
        var selected_interval = $(this).val();
        interval = parseInt(selected_interval / 60);
        $('#display_time').val(interval);
        display_time = interval * 60;

        var temp_from_time = chart_starting_time;
            temp_from_time = formatDate2(temp_from_time);
        var temp_to_time = $('#endto').val();
        var to_date_time = temp_to_time;
            temp_to_time = formatDate2(temp_to_time);

        var millisBetween = temp_to_time.getTime() - temp_from_time.getTime();  
      
        var seconds = millisBetween / 1000;  

        var temp = parseInt((seconds / 60) / interval);

        $("#selected-range").attr("max", temp);
        $('#selected-range').val(temp).trigger('input');
        $('#old-range').val(temp);

        var from = temp_to_time;
        from.setMinutes(from.getMinutes() - interval);
        from.setSeconds(from.getSeconds() + 1);
        var from_date_time = formatDate(from);

        var response = interfaceDetails(mrn, temp_parameter, from_date_time, to_date_time);
        var response_result = response.results;
        data_list = response_result;
        resetChart();
        setTimeout(generateChart(from_date_time, to_date_time), 500);
    });
});