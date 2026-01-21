<div class="row" id="vital-signs-chart-content"></div>
<div class="col-md-2">
    <div class="form-group">
        <button value="compare" class="btn form-control compare hide">Compare</button>
        <button value="Today"   class="btn form-control periods-sort hide">Today</button>
        <button value="Weeks"   class="btn form-control periods-sort hide">Last Weeks</button>
        <button value="Month"   class="btn form-control periods-sort hide">Last Month</button>
        <button value="All"     class="btn form-control periods-sort hide active-flag">All</button>
    </div>
    <div class="form-group hide">
        <label class="chart-fonts-style">Start Date:</label>
        <input type="date" class="form-control" name="start_date" id="start_date" size="5">
    </div>
    <div class="form-group hide">
        <label class="chart-fonts-style">End Date:</label>
        <input type="date"class="form-control"  name="end_date"  id="end_date" size="5">
    </div>
    <div class="form-group hide">
        <label class="chart-fonts-style">Chart Type:</label>
        <select name="flag" class="form-control">
            <option value="1" >Line Chart</option>
            <!-- <option value="2">Candlesticks</option> -->		
            <option value="3" selected="true">Box whisker</option>
        </select>
    </div>
</div>
<div class="modal fade chart-observation-modal flow-control-modal" id="chart-observation-model1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <h3 class="chart-fonts-style" id="maximized-icons-vitals"></h3>
                </h5>
                <button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true" style="color:white"><i class="fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <div class="hide separate-view" id="single-unit-observetion-1">
                </div>
                <div class="hide separate-view" id="single-unit-observetion-2">
                </div>
                <div class="hide separate-view" id="single-unit-observetion-3">
                </div>
                <div class="hide separate-view" id="single-unit-observetion-4">
                </div>
                <div class="hide separate-view" id="single-unit-observetion-5">
                </div>
            </div>
            <div class="modal-footer bg-white">
            </div>
        </div>
    </div>
</div>
<!-- <div id="single-vital-popups-container"> -->
    <div class="modal fade chart-observation-modal flow-control-modal" id="chart-observation-model" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <h3 class="chart-fonts-style" id="chart-title">Observation Chart</h3>
                    </h5>
                    <button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true" style="color:white"><i class="fa fa-times"></i></button>
                    <div class="pull-right chart-cursor-settings" style="margin-top: -6px;">
                        <select class="form-control filterValuesByDates" style="width: 90px; float: left; margin-right: 7px;">
                            <option value="" selected="selected">-- Select --</option>
                            <option value="0">1 Day</option>
                            <option value="1">2 Days</option>
                            <option value="7">1 Week</option>
                            <option value="30">1 Month</option>
                            <option value="all">All</option>
                        </select>
                        <span><input type="radio" value="on" name="pointer"> Pointer On</span>
                        <span><input type="radio" checked="true" value="off" name="pointer"> Pointer Off</span>
                    </div>
                    <div class="pull-right join-line-settings">
                        <span><input type="checkbox" value="on" name="line_join"> Line Join</span>
                        <span class="pl-15"><input type="checkbox" value="on" name="event"> Event</span>
                    </div>
                    <div class="pull-right join-line-settings hide">
                        <span class="vendilator-date-zoomed"></span>
                    </div>
                </div>
                <div class="modal-body">
                    <div id="single-unit-observetion">
                    </div>
                </div>
                <div class="modal-footer bg-white">
                </div>
            </div>
        </div>
    </div>
    <!-- </div> -->
    <div class="multiple-popup-create-container">
    </div>
    <script type="text/javascript">
        var color_code = JSON.parse($('input[name="color_code"]').val());
        $('.separate-view').click(function () {
            getHideChartVitals();
            $('#maximized-icons-vitals').html('Observation Chart  <span><i class="fa fa-search-minus fa-1x maximized-vital-icon" aria-hidden="true"></i></span>');
            $('#' + $(this).attr('id')).removeClass('hide').addClass('separate-view-container').addClass('maximized-icon-vital');
        });


        $(document).on('click', '.maximized-vital-icon', function () {
            $('.maximized-icon-vital').removeClass('maximized-icon-vital').removeClass('separate-view-container');
            $('#maximized-icons-vitals').html('Observation Chart');

            getUnhideChartVitals();
        });

        function getHideChartVitals() {
            $('.separate-view').each(function () {
                $(this).addClass('hide');
            });
        }

        function getUnhideChartVitals() {
            $('.separate-view').each(function () {
                $(this).removeClass('hide');
            });

        }

        function setchartsize(count) {

            switch (count) {
                case 1:
                $("#single-unit-observetion-1").addClass('chart-set-one-one').removeClass('hide');
                break;

                case 2:
                $("#single-unit-observetion-1").addClass('chart-set-two-one').removeClass('hide');
                $("#single-unit-observetion-2").addClass('chart-set-two-two').removeClass('hide');
                break;

                case 3:
                $("#single-unit-observetion-1").addClass('chart-set-three-one').removeClass('hide');
                $("#single-unit-observetion-2").addClass('chart-set-three-two').removeClass('hide');
                $("#single-unit-observetion-3").addClass('chart-set-three-three').removeClass('hide');
                break;

                case 4:
                $("#single-unit-observetion-1").addClass('chart-set-four-one').removeClass('hide');
                $("#single-unit-observetion-2").addClass('chart-set-four-two').removeClass('hide');
                $("#single-unit-observetion-3").addClass('chart-set-four-three').removeClass('hide');
                $("#single-unit-observetion-4").addClass('chart-set-four-four').removeClass('hide');
                break;

                case 5:
                $("#single-unit-observetion-1").addClass('chart-set-five-one').removeClass('hide');
                $("#single-unit-observetion-2").addClass('chart-set-five-two').removeClass('hide');
                $("#single-unit-observetion-3").addClass('chart-set-five-three').removeClass('hide');
                $("#single-unit-observetion-4").addClass('chart-set-five-four').removeClass('hide');
                $("#single-unit-observetion-5").addClass('chart-set-five-five').removeClass('hide');
                break;
            }
        }

        function getremoveclass() {

            $("#single-unit-observetion-1").removeAttr('class').addClass('hide');
            $("#single-unit-observetion-2").removeAttr('class').addClass('hide');
            $("#single-unit-observetion-3").removeAttr('class').addClass('hide');
            $("#single-unit-observetion-4").removeAttr('class').addClass('hide');
            $("#single-unit-observetion-5").removeAttr('class').addClass('hide');

        }


        $('.compare').click(function () {
            var parameters = [];

            $('.parameters').each(function () {
                parameters.push($(this).val());
            });
            getVitalSingleUnit(parameters, 'compare-view');

        });


        $(document).on('click', '.vital-signs, .view', function () {
            var parameter = $(this).data('parameter');
            var parameters = [];
            parameters.push(parameter);

            var flag = $('select[name="flag"]').val();
    // $('#' + parameter + '-model').modal({
    //     backdrop: 'static',
    //     show: true
    // });
    $('.filterValuesByDates').val('').change();

    if (flag ==1) {
        getVitalSingleUnit(parameters, 'single-view');
    } else if(flag == 3) {

    	getVitalSingleUnit(parameters, 'single-view');
    }


});

        var monitor_interfacing_status = $('input[name="monitor_interfacing_status"]').val();

        function getVitalSingleUnit(parameters, viewType) {

            var flag = $('select[name="flag"]').val();
            var periods = $('.periods-sort.active-flag').val();
            var parameters = parameters;
            var startDate = $('input[name="data_start_date"]').val();
            var endDate = $('input[name="data_end_date"]').val();
            var dataFlag = 2;
            var parameter = parameters[0];

            $.ajax({
                type: 'GET',
                url: '{{ action("Nurse\NurseChartController@graphicaldata",[$baby_id, $admission_id])."?date=".$selected_date }}',
                data: {
                    flag: flag,
                    periods: periods,
                    parameters: parameters,
                    startDate: startDate,
                    endDate: endDate,
                    eventstartDate: startDate,
                    eventendDate: endDate,
                    dataFlag: dataFlag,
                    viewType: viewType
                },
                beforeSend: function () {
                    $('#page-loader').fadeIn();
                    $('#vital-signs').html('<div class="loader"><i class="fa fa-spinner fa-pulse fa-5x fa-fw" aria-hidden="true"></i></div>');
                },
                success: function (data) {
                    $('.date-list').text(data.date_text);
                    $('.maximized-icon-vital').removeClass('maximized-icon-vital').removeClass('separate-view-container');
                    $('#maximized-icons-vitals').html('Observation Chart');

                    if (flag == 3) {
                        if (data.chart_type == 1) {
                            $('input[name="event"]').attr('checked', false);
                            $('input[name="line_join"]').attr('checked', false);
                            $('input[name="line_join"]').parent().removeClass('hide');
                            $('span:last-child input[value="off"]').prop('checked', true);
                            // var label = $('input[value="' + parameter + '"]').parent().next('td').first().text();
                            $('#chart-title').text(data.vitals_label[parameter]);
                            intiateLineChart(data.values, "single-unit-observetion", data.vitals_label[parameter],data.zoomPosition, '{{ $selected_date }}', data.event_list, color_code[parameter], data.mid_value);

                        } else if (data.chart_type == 2) {
                            $('input[name="event"]').attr('checked', false);
                            $('input[name="line_join"]').attr('checked', false);
                            $('span:last-child input[value="off"]').prop('checked', true);
                            // var label = $('input[value="' + parameter + '"]').parent().next('td').first().text();
                            $('#chart-title').text(data.vitals_label[parameter]);
                            if (monitor_interfacing_status) {
                                $('input[name="line_join"]').parent().addClass('hide');
                                intiateBoxwhisker(data.values, "single-unit-observetion", data.vitals_label[parameter],data.zoomPosition, '{{ $selected_date }}', color_code[parameter], data.mid_value);
                            } else {
                                $('input[name="line_join"]').parent().removeClass('hide');
                                intiateLineChart(data.values, "single-unit-observetion", data.vitals_label[parameter],data.zoomPosition, '{{ $selected_date }}', null, color_code[parameter], data.mid_value, true);
                            }

                        }

                    }
                    $('#page-loader').fadeOut();
                    $('#chart-observation-model').modal({backdrop: 'static', show: true });
                },
                error: function (data) {
                    Showalert('error','Data Missing Please Contact Admin !');
                    $('#page-loader').fadeOut();
                }
            });
        }


        function getVitaldata() {

            var flag = $('select[name="flag"]').val();

            var periods = $('.periods-sort.active-flag').val();
            var parameters = [];

            var startDate = $('input[name="data_start_date"]').val();
            var endDate = $('input[name="data_end_date"]').val();
            var dataFlag = 1;
            $.ajax({
                type: 'GET',
                url: '{{ action("Nurse\NurseChartController@graphicaldata",[$baby_id, $admission_id]) }}?date={{ $selected_date }}',
                data: {
                    flag: flag,
                    periods: periods,
                    parameters: parameters,
                    startDate: startDate,
                    endDate: endDate,
                    eventstartDate: startDate,
                    eventendDate: endDate,
                    dataFlag: dataFlag
                },
                beforeSend: function () {
                    $('#page-loader').fadeIn();
                    $('#vital-signs-chart-content').html('<div class="col-md-12"><div class="vitals-loader"><i class="fa fa-spinner fa-pulse fa-5x fa-fw" aria-hidden="true"></i></div></div>');
                },
                success: function (data) {
                    var chartHtml = '';
                    var chartIndex = 1;
                    var labelNumber = 1;
                    chartHtml += '<div class="row mx-0">';
                    $.each(data.vitals_label, function (index, value) {
                        chartHtml += '<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 vital-signs-overlay">';
                        chartHtml += '<div class="vital-signs vital-signs-events card-pf card-pf-view card-pf-view-select card-pf-view-single-select vital-signs px-0" data-parameter="' + value + '" id="vital-signs-' + chartIndex + '">';
                        chartHtml += '</div>';

                        chartHtml += '<div class="overlay" data-parameter="' + value + '">';
                        chartHtml += '<span class="view over-text-align view-button" data-parameter="' + index + '"><a href="javascript:void(0)"><i class="fa fa-eye" aria-hidden="true"></i> view</a></span><br>';
                        chartHtml += '</div>';

                        chartHtml += '</div>';
                        chartIndex++;
                    });
                    chartHtml += '</div>';
                    $('#vital-signs-chart-content').html(chartHtml);

                    $.each(data.vitals_label, function (label_index, label_value) {
                        var property = data.map_param[label_index];
                        var value = data.values[property];

                        var data_split = property.split(':');
                        if (typeof data_split[1] != 'undefined') {
                                var parameter = data_split[0];
                                var plotting_value_name = data_split[1];
                                var color_code = data_split[2];
                                var chart_type = data_split[3];

                                if (chart_type == 1) {
                                    if (monitor_interfacing_status) {
                                        intiateBoxwhiskerMini(value, "vital-signs-" + labelNumber, data.vitals_label[parameter], color_code, plotting_value_name, labelNumber);
                                    } else {
                                        intiateLineChartMini(value, "vital-signs-" + labelNumber, data.vitals_label[parameter], color_code, plotting_value_name, labelNumber, true);
                                    }
                                } else {
                                    intiateLineChartMini(value, "vital-signs-" + labelNumber, data.vitals_label[parameter], color_code, plotting_value_name, labelNumber);
                                }
                                labelNumber++;
                            }
                    });

                    if (data.values.length == 0) {
                        $('#vital-signs-chart-content').html('<span class="text-center"> No Record Found ! </span>');
                    }

                },
                error: function (data) {
                    Showalert('error', 'No data found!');
                }
            });
            $('#page-loader').fadeOut();
        }

        $('.periods-sort').click(function () {
            $('.periods-sort').removeClass('active-flag');
            $(this).addClass('active-flag');
            getVitaldata();

        });

        $('select[name="flag"]').change(function () {
            getVitaldata();
        });

        $('.parameters').click(function () {
            getVitaldata();
        });

        $('.periods-sort').click(function () {
            getVitaldata();
        });

        getVitaldata();
        setInterval(function () {
            getVitaldata();
        }, 300000);
</script>
