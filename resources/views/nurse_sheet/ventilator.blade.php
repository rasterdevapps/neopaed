<div class="col-md-12 px-0" id="ventilator-settings-content"></div>
<div class="col-md-2">
    <div class="form-group">
        <button value="Today" class="btn form-control hide periods-sort-ventilator">Today</button>
        <button value="Weeks" class="btn form-control hide periods-sort-ventilator">Last Weeks</button>
        <button value="Month" class="btn form-control hide periods-sort-ventilator">Last Month</button>
        <button value="All"   class="btn form-control hide periods-sort-ventilator active-flag">All</button>
    </div>
    <div class="form-group hide">
        <label>Start Date:</label>
        <input type="date" class="form-control" name="ventilator_start_date" id="ventilator_start_date" size="5">
    </div>
    <div class="form-group hide">
        <label>End Date:</label>
        <input type="date" class="form-control"  name="ventilator_end_date"  id="ventilator_end_date" size="5">
    </div>
    <div class="form-group hide">
        <label>Chart Type:</label>
        <select name="ventilator_flag" class="form-control">
            <option value="1" >Line Chart</option>
            <option value="3" selected="true" >Box whisker</option>
        </select>
    </div>
</div>
<div class="modal fade chart-vendilator-modal" id="chart-vendilator-model1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <h3 class="chart-fonts-style"  id="maximized-icons">Observation Chart</h3>
                </h5>
                <button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true" style="color:white"><i class="fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <div class="hide separate" id="single-unit-vendilator-1">
                </div>
                <div class="hide separate" id="single-unit-vendilator-2">
                </div>
                <div class="hide separate" id="single-unit-vendilator-3">
                </div>
                <div class="hide separate" id="single-unit-vendilator-4">
                </div>
                <div class="hide separate" id="single-unit-vendilator-5">
                </div>
                <div class="hide separate" id="single-unit-vendilator-6">
                </div>
            </div>
            <div class="modal-footer bg-white">
            </div>
        </div>
    </div>
</div>
<!-- <div id="single-ventilator-popups-container"> -->
    <div class="modal fade chart-vendilator-modal" id="chart-vendilator-model" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <h3 class="chart-fonts-style text-white" id="observe-name" style="margin-top: 10px; margin-bottom: 0px;">Observation Chart</h3>
                    </h5>
                    <button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true" style="color:white"><i class="fa fa-times"></i></button>
                    <div class="pull-right chart-cursor-settings" style="margin-top: -10px;color: #fff;">
                        <select class="form-control filterValuesByDates" style="width: 90px; float: left; margin-right: 7px;">
                            <option value="" selected="selected">-- Select --</option>
                            <option value="0">1 Day</option>
                            <option value="1">2 Days</option>
                            <option value="7">1 Week</option>
                            <option value="30">1 Month</option>
                            <option value="all">All</option>
                        </select>
                        <span><input type="radio" value="on" name="line_pointer_vendilator"> Pointer On</span>
                        <span><input type="radio" checked="true" value="off" name="line_pointer_vendilator"> Pointer Off</span>
                    </div>
                    <div class="pull-right join-line-settings" style="margin-top: -6px;color: #fff;">
                        <span><input type="checkbox" value="on" name="line_join_vendilator"> Line Join</span>
                        <span class="pl-15"><input type="checkbox" value="on" name="event"> Event</span>
                    </div>
                    <div class="pull-right join-line-settings" style="margin-top: -6px;color: #fff;">
                        <span class="vendilator-date-zoomed"></span>
                    </div>
                </div>
                <div class="modal-body">
                    <div id="single-unit-vendilator">
                    </div>
                </div>
                <div class="modal-footer bg-white">
                </div>
            </div>
        </div>
    </div>
    <!-- </div> -->
    <script type="text/javascript">
        var color_code = JSON.parse($('input[name="color_code"]').val());
        $('.separate').click(function () {
            getHideChart();
            $('#maximized-icons').html('Observation Chart  <span><i class="fa fa-search-minus fa-1x maximized" aria-hidden="true"></i></span>');
            $('#' + $(this).attr('id')).removeClass('hide').addClass('seprate-container').addClass('maximized-icon');
        });


        $(document).on('click', '.maximized', function () {
            $('.maximized-icon').removeClass('maximized-icon').removeClass('seprate-container');
            $('#maximized-icons').html('Observation Chart');
            getUnhideChart();
        });

        function getHideChart() {
            $('.separate').each(function () {
                $(this).addClass('hide');
            });
        }

        function getUnhideChart() {
            $('.separate').each(function () {
                $(this).removeClass('hide');
            });

        }

        function setchartsizeVentilator(count) {
            switch (count) {
                case 1:
                $("#single-unit-vendilator-1").addClass('chart-set-one-one').removeClass('hide').removeClass('seprate-container');
                break;

                case 2:
                $("#single-unit-vendilator-1").addClass('chart-set-two-one').removeClass('hide').removeClass('seprate-container');
                $("#single-unit-vendilator-2").addClass('chart-set-two-two').removeClass('hide').removeClass('seprate-container');
                break;

                case 3:
                $("#single-unit-vendilator-1").addClass('chart-set-three-one').removeClass('hide').removeClass('seprate-container');
                $("#single-unit-vendilator-2").addClass('chart-set-three-two').removeClass('hide').removeClass('seprate-container');
                $("#single-unit-vendilator-3").addClass('chart-set-three-three').removeClass('hide').removeClass('seprate-container');
                break;

                case 4:
                $("#single-unit-vendilator-1").addClass('chart-set-four-one').removeClass('hide').removeClass('seprate-container');
                $("#single-unit-vendilator-2").addClass('chart-set-four-two').removeClass('hide').removeClass('seprate-container');
                $("#single-unit-vendilator-3").addClass('chart-set-four-three').removeClass('hide').removeClass('seprate-container');
                $("#single-unit-vendilator-4").addClass('chart-set-four-four').removeClass('hide').removeClass('seprate-container');
                break;

                case 5:
                $("#single-unit-vendilator-1").addClass('chart-set-five-one').removeClass('hide').removeClass('seprate-container');
                $("#single-unit-vendilator-2").addClass('chart-set-five-two').removeClass('hide').removeClass('seprate-container');
                $("#single-unit-vendilator-3").addClass('chart-set-five-three').removeClass('hide').removeClass('seprate-container');
                $("#single-unit-vendilator-4").addClass('chart-set-five-four').removeClass('hide').removeClass('seprate-container');
                $("#single-unit-vendilator-5").addClass('chart-set-five-five').removeClass('hide').removeClass('seprate-container');
                break;
                case 6:
                $("#single-unit-vendilator-1").addClass('chart-set-six-one').removeClass('hide').removeClass('seprate-container');
                $("#single-unit-vendilator-2").addClass('chart-set-six-two').removeClass('hide').removeClass('seprate-container');
                $("#single-unit-vendilator-3").addClass('chart-set-six-three').removeClass('hide').removeClass('seprate-container');
                $("#single-unit-vendilator-4").addClass('chart-set-six-four').removeClass('hide').removeClass('seprate-container');
                $("#single-unit-vendilator-5").addClass('chart-set-six-five').removeClass('hide').removeClass('seprate-container');
                $("#single-unit-vendilator-6").addClass('chart-set-six-six').removeClass('hide').removeClass('seprate-container');
                break;

            }
        }


        function getremoveclassVentilator() {

            $("#single-unit-vendilator-1").removeAttr('class').addClass('hide');
            $("#single-unit-vendilator-2").removeAttr('class').addClass('hide');
            $("#single-unit-vendilator-3").removeAttr('class').addClass('hide');
            $("#single-unit-vendilator-4").removeAttr('class').addClass('hide');
            $("#single-unit-vendilator-5").removeAttr('class').addClass('hide');
            $("#single-unit-vendilator-6").removeAttr('class').addClass('hide');

        }

        $(document).on('click', '.ventilator-view, .ventilator-parameters, .ventilator-settings', function () {
            var parameter = $(this).data('parameter');
            var parameters = [];
            parameters.push(parameter);
            var flag = $('select[name="flag"]').val();
    // $('#' + parameter + '-model').modal({
    //     backdrop: 'static',
    //     show: true
    // });
    $('.filterValuesByDates').val('').change();
    if (flag == 1) {
        getVentilatorSingleUnit(parameters, 'single-view');
    } else if (flag == 3) {
        getVentilatorSingleUnit(parameters, 'single-view');
    }
});

        var ventilator_interfacing_status = $('input[name="ventilator_interfacing_status"]').val();

        function getVentilatorSingleUnit(parameters, viewType) {

            var periods = $('.periods-sort-ventilator.active-flag').val();
            var flag = $('select[name="ventilator_flag"]').val();
            var parameters = parameters;
            var dataFlage = 2;
            var parameter = parameters[0];

    var startDate = $('input[name="data_start_date"]').val();
    var endDate = $('input[name="data_end_date"]').val();


    $.ajax({
        type: 'GET',
        url: '{{ action("Nurse\NurseChartController@vendilatorgraphicaldata",[$baby_id, $admission_id])."?date=".$selected_date }}',
        data: {
            flag: flag,
            periods: periods,
            parameters: parameters,
            startDate: startDate,
            endDate: endDate,
            eventstartDate: startDate,
            eventendDate: endDate,
            viewType: viewType,
            dataFlage: dataFlage
        },
        beforeSend: function () {
            $('#page-loader').fadeIn();
            $('#ventilator-settings').html('<div class="loader"><i class="fa fa-spinner fa-pulse fa-5x fa-fw" aria-hidden="true"></i></div>');
        },
        success: function (data) {

            if (data.chart_type == 1) {
                $('input[name="event"]').attr('checked', false);
                $('input[name="line_join_vendilator"]').attr('checked', false);
                $('span:last-child input[value="off"]').prop('checked', true);
                $('input[name="line_join_vendilator"]').parent().removeClass('hide');
                // var label = $('input[value="' + value.parameter + '"]').parent().next('td').first().text();
                $('#observe-name').text(data.ventilator_label[parameter]);
                intiateLineChart(data.values, "single-unit-vendilator", data.ventilator_label[parameter], data.zoomPosition, '{{ $selected_date }}', null, color_code[parameter], data.mid_value);
            } else if (data.chart_type == 2) {

                $('input[name="event"]').attr('checked', false);
                $('input[name="line_join_vendilator"]').attr('checked', false);
                $('span:last-child input[value="off"]').prop('checked', true);
                // var label = $('input[value="' + value.parameter + '"]').parent().next('td').first().text();
                $('#observe-name').text(data.ventilator_label[parameter]);
                if (ventilator_interfacing_status) {
                    $('input[name="line_join_vendilator"]').parent().addClass('hide');
                    intiateBoxwhisker(data.values, "single-unit-vendilator", data.ventilator_label[parameter], data.zoomPosition, '{{ $selected_date }}', color_code[parameter], data.mid_value);
                } else {
                    $('input[name="line_join_vendilator"]').parent().removeClass('hide');
                    intiateLineChart(data.values, "single-unit-vendilator", data.ventilator_label[parameter], data.zoomPosition, '{{ $selected_date }}', null, color_code[parameter], data.mid_value, true);
                }
            }

            $('#page-loader').fadeOut();
            if (viewType == 'compare-view') {
                $('#chart-vendilator-model1').modal({
                    backdrop: 'static',
                    show: true
                });
            } else {
                $('#chart-vendilator-model').modal({
                    backdrop: 'static',
                    show: true
                });
            }

        },
        error: function (data) {
            $('#page-loader').fadeOut();
            Showalert('error', 'Your messsage failed to sent !');
        }
    });
}


function getVentilator(settings) {

    var periods = $('.periods-sort-ventilator.active-flag').val();
    var flag = $('select[name="ventilator_flag"]').val();
    var parameters = [];

    var startDate = $('input[name="data_start_date"]').val();
    var endDate = $('input[name="data_end_date"]').val();
    var dataFlage = 1;

    $.ajax({
        type: 'GET',
        url: '{{ action("Nurse\NurseChartController@vendilatorgraphicaldata",[$baby_id, $admission_id])."?date=".$selected_date }}',
        data: {
            flag: flag,
            periods: periods,
            parameters: parameters,
            startDate: startDate,
            endDate: endDate,
            eventstartDate: startDate,
            eventendDate: endDate,
            dataFlage: dataFlage,
            settings: settings
        },
        beforeSend: function () {
            $('#ventilator-settings').html('<div class="loader"><i class="fa fa-spinner fa-pulse fa-5x fa-fw" aria-hidden="true"></i></div>');
        },
        success: function (data) {
            var chartHtml = '';
            var chartIndex = 1;

            chartHtml += '<div class="row">';
            $.each(data.values, function (index, value) {
                var data_split = index.split(':');
                if (typeof data_split[1] != 'undefined') {
                    var parameter = data_split[0];
                    var plotting_value_name = data_split[1];
                    var color_code = data_split[2];
                    var chart_type = data_split[3];

                    var label = data.ventilator_label[parameter];

                    chartHtml += '<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 vital-signs-overlay">';
                    chartHtml += '<div class="card-pf card-pf-view card-pf-view-select card-pf-view-single-select ventilator-settings vital-signs-events px-0" data-parameter="' + label + '" data-highlighted="' + parameter + '" id="ventilator-parameters-' + chartIndex + '">';
                    chartHtml += '</div>';

                    chartHtml += '<div class="overlay overtext-ventilator view-button" data-parameter="' + label + '">';
                    chartHtml += '<span class="ventilator-view over-text-align" data-parameter="' + parameter + '"><a href="javascript:void(0)"><i class="fa fa-eye" aria-hidden="true"></i> view</a></span><br>';
                    chartHtml += '</div>';

                    chartHtml += '</div>';
                    chartIndex++;
                }
            });
            chartHtml += '</div>';
            $('#ventilator-settings-content').html(chartHtml);

            var labelNumber = 1;
            $.each(data.values, function (index, value) {
                var data_split = index.split(':');
                var parameter = data_split[0];
                if (typeof data_split[1] != 'undefined') {
                    var plotting_value_name = data_split[1];
                    var color_code = data_split[2];
                    var chart_type = data_split[3];

                    if (chart_type == 1) {
                        if (ventilator_interfacing_status) {
                            intiateBoxwhiskerMini(value, "ventilator-parameters-" + labelNumber, data.ventilator_label[parameter], color_code, plotting_value_name, labelNumber);
                        } else {    
                            intiateLineChartMini(value, "ventilator-parameters-" + labelNumber, data.ventilator_label[parameter], color_code, plotting_value_name, labelNumber, true);
                        }

                    } else {
                        intiateLineChartMini(value, "ventilator-parameters-" + labelNumber, data.ventilator_label[parameter], color_code, plotting_value_name, labelNumber);
                    }
                    labelNumber++;
                }
            });

            if (data.values.length == 0) {
                $('#ventilator-settings-content').html('<span class="text-center"> No Record Found ! </span>');
            }

        },
        error: function (data) {
            // Showalert('error', 'Your messsage failed to sent !');
        }
    });
}

var settings = [];
@foreach($vendilator_settings as $settings)
settings.push("{!! $settings !!}")
@endforeach


getVentilator(settings);
</script>
