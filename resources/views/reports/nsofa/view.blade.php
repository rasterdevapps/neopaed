@extends('app')
@section('content')
<style type="text/css">
    #score-data-container #score-block {
        display: inline-block;
        background: black;
        font-size: 24px;
        color: white;
        padding: 15px;
        margin: 15px;
    }
    th.active, td.active {
        background-color: #ffb3b3 !important;
    }
</style>
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li><i class="icon-home"></i><a href="{{url('/')}}">Dashboard</a></li>
		<li class="current"><a href="{{ action('Reports\NsofaController@index') }}">nSOFA Report</a></li>       
	</ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing" id="nsofa-block">
    <div class="col-md-12">
        <div class="widget box">
            <div class="widget-header">
                <h4>nSOFA</h4> 
            </div>
            <div class="widget-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row mb-15">
                            {!! Form::model(null, ['method'=>'GET', 'id'=>'nsofa-filter']) !!}
                            <div class="col-md-6">
                                {!! Form::select('baby', ['N/A' => '-- Select Admission --']+$babies, null, ['class'=>'full-width', 'required']) !!}
                                <p class="error-message hide" id="baby-error">Baby name is required !</p>
                            </div>
                            <div class="col-md-2">
                                {!! Form::text('date', null, ['class'=>'form-control', 'readonly', 'required']) !!}
                                <p class="error-message hide" id="date-error">Date field is required !</p>
                            </div>
                            <div class="col-md-2">
                                {!! Form::select('time_hour', ['N/A' => 'N/A']+$hour_24, null, ['class'=>'form-control', 'required']) !!}
                                <p class="error-message hide" id="hour-error">Hour field is required !</p>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-primary" id="generate-score">Generate Score</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="col-md-12 display-flex">
                        <div class="col-md-12" id="respiratory-data-container">
                        </div>
                        <div class="col-md-12" id="cardiovascular-data-container">
                        </div>
                        <div class="col-md-12" id="hematologic-data-container">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="widget box">
            <div class="widget-content">
                <div class="row">
                    <div class="col-md-12" id="nsofa-container">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="avoid-wrap">Respiratory Score</th>
                                    <th class="rs-0">0</th>
                                    <th class="rs-2">2</th>
                                    <th class="rs-4">4</th>
                                    <th class="rs-6">6</th>
                                    <th class="rs-8">8</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Criteria</td>
                                    <td class="rs-0">Not intubated or intubated <br> SpO2/FiO2 ≥ 300</td>
                                    <td class="rs-2">Intubated <br> SpO2/FiO2 < 300</td>
                                    <td class="rs-4">Intubated <br> SpO2/FiO2 < 200</td>
                                    <td class="rs-6">Intubated <br> SpO2/FiO2 < 150</td>
                                    <td class="rs-8">Intubated <br> SpO2/FiO2 < 100</td>
                                </tr>
                            </tbody>
                            <thead>
                                <tr>
                                    <th class="avoid-wrap">Cardiovascular Score</th>
                                    <th class="c-0">0</th>
                                    <th class="c-1">1</th>
                                    <th class="c-2">2</th>
                                    <th class="c-3">3</th>
                                    <th class="c-4">4</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Criteria</td>
                                    <td class="c-0">No inotropes, no systemic steroids</td>
                                    <td class="c-1">No inotropes, systemic steroid treatment</td>
                                    <td class="c-2">One inotrope, no systemic steroids</td>
                                    <td class="c-3">At least two inotropes or one inotrope and systemic steroids</td>
                                    <td class="c-4">At least two inotropes and systemic steroids</td>
                                </tr>
                            </tbody>
                            <thead>
                                <tr>
                                    <th class="avoid-wrap">Hematologic Score</th>
                                    <th class="h-0">0</th>
                                    <th class="h-1">1</th>
                                    <th class="h-2">2</th>
                                    <th class="h-3">3</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Criteria</td>
                                    <td class="h-0">Platelet count ≥ 1,50,000</td>
                                    <td class="h-1">Platelet count 1,00,001 - 1,49,999</td>
                                    <td class="h-2">Platelet count 50,001 - 1,00,000</td>
                                    <td class="h-3">Platelet count <= 50,000</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="widget box">
                <div class="widget-content">
                    <div class="row">
                        <div class="col-md-12" id="score-data-container">
                            <div class="row text-center"> 
                                <div id="score-block">nSOFA Score: <span></span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            var room_oxygen = 0.21 * 100;
            var non_invasive_list = [];
            $('#score-data-container').addClass('hide');
            $('input[name="date"]').datepicker({
                dateFormat: 'dd-mm-yy',
                changeMonth : true,
                changeYear : true,
                maxDate: new Date()
            });
            $('select[name="baby"]').select2();
            var lab_selected_date = '';
            $('#generate-score').on('click', function() {
                $('th').removeClass('active');
                $('td').removeClass('active');

                var id = $('select[name="baby"]').val();
                var selected_date = $('input[name="date"]').val();
                var selected_hour = $('select[name="time_hour"]').val();

                var validate_fail = false;

                if (id == 'N/A') {
                    validate_fail = true;
                    $('#baby-error').removeClass('hide');
                } else {
                    $('#baby-error').addClass('hide');                
                }
                if (selected_date == '') {
                    validate_fail = true;
                    $('#date-error').removeClass('hide');
                } else {
                    $('#date-error').addClass('hide');                
                }
                if (selected_hour == 'N/A') {
                    validate_fail = true;
                    $('#hour-error').removeClass('hide');
                } else {
                    $('#hour-error').addClass('hide');                
                }

                if (!validate_fail) {
                    var button_content = $('#generate-score').html();
                    var site_url = $('input[name="site_base_url"]').val();
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'GET',
                        data: {
                            id: id,
                            date: selected_date,
                            hour: selected_hour
                        },
                        url: site_url + '/nsofa-report-view',
                        beforeSend: function() {
                            $('#generate-score').html('<i class="fa fa-spinner fa-spin"></i> ' + button_content);
                        },
                        success: function(response) {
                            var ventilator_result = response.ventilator_result;
                            ventilator_result.ventilator_type = response.ventilator_type;
                            ventilator_result.ventilator_hour_list = response.ventilator_hour_list;
                            non_invasive_list = response.non_invasive_list;
                            template('Respiratory', ventilator_result);

                            var drug_list = [];
                            drug_list['inotropes'] = response.inotropes_drug_list;
                            drug_list['non_steroid'] = response.non_steroid_drug_list;
                            drug_list['drug_hour_list'] = response.drug_hour_list;
                            template('Cardiovascular', drug_list);

                            var lab_result = response.lab_result;
                            lab_result.lab_hour_list = response.lab_hour_list;

                            if (selected_date != response.lab_selected_date) {
                                var date = response.lab_selected_date;
                                date = date.split('-');
                                lab_selected_date = date[2] + '-' + date[1] + '-' + date[0] + ' ';
                            }
                            template('Hematologic', lab_result);

                            $('#score-data-container').removeClass('hide');
                            $('#score-data-container #score-block span').html(score(response.score_hour));
                        },
                        complete: function() {
                            $('#generate-score').html(button_content);
                        }
                    });
                }
            });

            var empty_content = '<td>';
            empty_content += '-';
            empty_content += '</td>';


            var no_content = '<td>';
            no_content += 'N/A';
            no_content += '</td>';

            var respiratory_score_list = [];
            var cardiovascular_score_list = [];
            var hematologic_score_list = [];

            function template(item, result) {
                var data = '<table class="table table-bordered">';
                data += '<thead>';
                data += '<tr>';
                data += '<th colspan="25">' + item + '</th>';
                data += '</tr>';
                data += '<tr>';
                data += '<th></th>';
                if (item == 'Respiratory') {
                    data += respiratoryHeaderCell(result);
                } else if (item == 'Cardiovascular') {
                    data += cardiovascularHeaderCell(result);
                } else if (item == 'Hematologic') {
                    data += hematologicHeaderCell(result);
                }
                data += '</tr>';
                data += '</thead>';
                data += '<tbody>';
                if (item == 'Respiratory') {
                    data += respiratoryCell(result);
                } else if (item == 'Cardiovascular') {
                    data += cardiovascularCell(result);
                } else if (item == 'Hematologic') {
                    data += hematologicCell(result);
                }
                data += '</tbody>';
                data += '</table>';

                if (item == 'Respiratory') {
                    $('#respiratory-data-container').html(data);
                } else if (item == 'Cardiovascular') {
                    $('#cardiovascular-data-container').html(data);
                } else if (item == 'Hematologic') {
                    $('#hematologic-data-container').html(data);
                }
            }

            function respiratoryHeaderCell(result) {
                var hr_cell = '';
                if (Object.keys(result.ventilator_hour_list).length > 0) {
                    $.each(result.ventilator_hour_list, function(index, time) {
                        hr_cell += '<th>';
                        hr_cell += time;
                        hr_cell += '</th>';
                    });
                } else {
                    hr_cell += '<th>';
                    hr_cell += '';
                    hr_cell += '</th>';
                }
                return hr_cell;
            }

            function cardiovascularHeaderCell(result) {
                var hr_cell = '';
                if (result['drug_hour_list'].length > 0) {
                    $.each(result['drug_hour_list'], function(index, time) {
                        hr_cell += '<th>';
                        hr_cell += time;
                        hr_cell += '</th>';
                    });
                } else {
                    hr_cell += '<th colspan="2">';
                    hr_cell += '</th>';
                }
                return hr_cell;
            }

            function hematologicHeaderCell(result) {
                var hr_cell = '';
                if (result['lab_hour_list'].length > 0) {
                    $.each(result['lab_hour_list'], function(index, time) {
                        hr_cell += '<th>';
                        hr_cell += lab_selected_date + time;
                        hr_cell += '</th>';
                    });
                } else {
                    hr_cell += '<th>';
                    hr_cell += '';
                    hr_cell += '</th>';
                }
                return hr_cell;
            }

            function scoreHeaderCell(hour_list) {
                var hr_cell = '';
                if (hour_list.length > 0) {
                    $.each(hour_list, function(index, time) {
                        hr_cell += '<th>';
                        hr_cell += time;
                        hr_cell += '</th>';
                    });
                } else {
                    hr_cell += '<th>';
                    hr_cell += '';
                    hr_cell += '</th>';
                }
                return hr_cell;
            }

            function respiratoryCell(ventilator_result) {
                var ventilator_type = ventilator_result['ventilator_type'];
                var ventilator_hour_list = ventilator_result['ventilator_hour_list'];
                var invasive_data = ventilator_result[47];
                var non_invasive_data = ventilator_result[225];
                if (typeof invasive_data != 'undefined') {
                    var mode_data = invasive_data;
                } else {
                    var mode_data = non_invasive_data;
                }
                if (ventilator_type == 'Invasive') {
                    var data = cellContent(mode_data, 'Invasive', ventilator_hour_list);
                } else {
                    var data = cellContent(mode_data, 'Non-Invasive', ventilator_hour_list);
                }
                var spo2_data = ventilator_result[44];
                data += cellContent(spo2_data, 'Monitor SpO2 (%)', ventilator_hour_list);
                var fio2_data = ventilator_result[52];
            // data += cellContent(fio2_data, 'Fio2', ventilator_hour_list);
                var delivered_fio2_data = ventilator_result[296];
                data += fio2CellContent(delivered_fio2_data, fio2_data, 'Fio2 (%)', ventilator_hour_list);
                var fio2 = [];
                if (typeof fio2_data != 'undefined') {
                    if (Object.keys(fio2_data).length > 0) {
                        fio2 = fio2_data;
                    }
                }
                if (typeof delivered_fio2_data != 'undefined') {
                    if (Object.keys(delivered_fio2_data).length > 0) {
                        fio2 = delivered_fio2_data;
                    }
                }
                data += respiratoryScoreCell(spo2_data, fio2, ventilator_hour_list, ventilator_type, mode_data);
                return data;
            }

            function cellContent(value, param_name, hour_list) {
                var data = '<tr>';
                data += '<td>';
                data += param_name;
                data += '</td>';
                if (Object.keys(hour_list).length > 0) {
                    $.each(hour_list, function(index, time) {
                        if (typeof value != 'undefined') { 
                            var param_val = value[time];
                            if (typeof param_val != 'undefined') { 
                                data += '<td>';
                                data += param_val.intf_ref_value;
                                data += '</td>';
                            } else {
                                data += empty_content;
                            }
                        } else {
                            data += empty_content;
                        }
                    });
                } else {
                    data += empty_content;
                }
                data += '</tr>';
                return data;
            }

            function fio2CellContent(value_1, value_2, param_name, hour_list) {
                var data = '<tr>';
                data += '<td>';
                data += param_name;
                data += '</td>';
                if (Object.keys(hour_list).length > 0) {
                    $.each(hour_list, function(index, time) {
                        if (typeof value_1 != 'undefined') { 
                            var param_val = value_1[time];
                            if (typeof param_val != 'undefined') { 
                                data += '<td>';
                                data += param_val.intf_ref_value;
                                data += '</td>';
                            } else {
                                data += empty_content;
                            }
                        } else if (typeof value_2 != 'undefined') { 
                            var param_val = value_2[time];
                            if (typeof param_val != 'undefined') { 
                                data += '<td>';
                                data += param_val.intf_ref_value;
                                data += '</td>';
                            } else {
                                data += empty_content;
                            }
                        } else {
                            var param_val = room_oxygen;
                            if (typeof param_val != 'undefined') { 
                                data += '<td>';
                                data += param_val + '<br/>(Room Oxygen)';
                                data += '</td>';
                            } else {
                                data += empty_content;
                            }
                        }
                    });
                } else {
                    data += empty_content;
                }
                data += '</tr>';
                return data;
            }

            function respiratoryScoreCell(spo2_data, fio2_data, hour_list, ventilator_type, mode_data) {
                var data = '<tr>';
                data += '<td>';
                data += '<b>SpO2 / Fio2 (%)</b>';
                data += '</td>';

                var data1 = '<tr>';
                data1 += '<td>';
                data1 += '<b>Score</b>';
                data1 += '</td>';

                var respiratory_score = 'N/A';
                if (Object.keys(hour_list).length > 0) {
                    $.each(hour_list, function(index, time) {
                        if (typeof spo2_data != 'undefined' && typeof fio2_data != 'undefined') { 
                            if (typeof spo2_data[time] != 'undefined') { 
                                data += '<td>';
                                var fio2_value = 'N/A';
                                if ($.inArray(mode_data[time].intf_ref_value, non_invasive_list) > -1 && !(mode_data[time].intf_ref_value == 'SV' || mode_data[time].intf_ref_value == 'SVA')) {
                                    respiratory_score = 0;
                                } else {
                                    if (mode_data[time].intf_ref_value == 'SV' || mode_data[time].intf_ref_value == 'SVA') {
                                        fio2_value = room_oxygen;
                                    }
                                    if (typeof fio2_data[time] != 'undefined') {
                                        fio2_value = fio2_data[time].intf_ref_value;
                                    }
                                    var cal = spo2_data[time].intf_ref_value / (fio2_value / 100);
                                    data += '<b>' + cal.toFixed(2) + '</b>';
                                    data += '</td>';
                                    if (cal >= 301) {
                                        respiratory_score = 0;
                                    } else if ((cal >= 201 && cal <= 300) && ventilator_type == 'Invasive') {
                                        respiratory_score = 2;
                                    } else if ((cal >= 151 && cal <= 200) && ventilator_type == 'Invasive') {
                                        respiratory_score = 4;
                                    } else if ((cal >= 101 && cal <= 150) && ventilator_type == 'Invasive') {
                                        respiratory_score = 6;
                                    } else if ((cal <= 100) && ventilator_type == 'Invasive') {
                                        respiratory_score = 8;
                                    }
                                }
                                if (respiratory_score >= 0) {
                                    $('.rs-' + respiratory_score).addClass('active');
                                }
                                if (respiratory_score != '-') {
                                    respiratory_score_list[time] = respiratory_score;
                                }
                                data1 += '<td>';
                                data1 += '<b>' + respiratory_score + '</b>';
                                data1 += '</td>';
                            } else {
                                data += empty_content;
                            }
                        } else {
                            data += empty_content;
                        }
                    });
                } else {
                    data += no_content;
                    data1 += no_content;
                }
                data1 += '</tr>';

                data += '</tr>';
                return data + data1;
            }

            function cardiovascularCell(drug_list) {
                var inotropes_drug_list = drug_list['inotropes'];
                var non_steroid_drug_list = drug_list['non_steroid'];
                var hour_list = drug_list['drug_hour_list'];
                var inotropes_data = '<tr>';
                inotropes_data += '<td>';
                inotropes_data += 'Inotropes';
                inotropes_data += '</td>';

                var non_steroid_data = '<tr>';
                non_steroid_data += '<td>';
                non_steroid_data += 'Steroid';
                non_steroid_data += '</td>';

                var cardiovascular_data = '<tr>';
                cardiovascular_data += '<td>';
                cardiovascular_data += '<b>Score</b>';
                cardiovascular_data += '</td>';

                if (hour_list.length > 0) {
                    $.each(hour_list, function(index, time) {
                        var cardiovascular_score = inotropes_drug_count = non_steroid_drug_count = 0;

                        if (typeof inotropes_drug_list != 'undefined' && typeof inotropes_drug_list[time] != 'undefined') {
                            inotropes_drug_count = inotropes_drug_list[time];
                            inotropes_data += '<td>';
                            inotropes_data += inotropes_drug_count;
                            inotropes_data += '</td>';
                        } else {
                            inotropes_data += empty_content;
                        }
                        if (typeof non_steroid_drug_list != 'undefined' && typeof non_steroid_drug_list[time] != 'undefined') {
                            non_steroid_drug_count = non_steroid_drug_list[time];
                            non_steroid_data += '<td>';
                            non_steroid_data += non_steroid_drug_count;
                            non_steroid_data += '</td>';
                        } else {
                            non_steroid_data += empty_content;
                        }

                        if (inotropes_drug_count == 0 && non_steroid_drug_count == 0) {
                            cardiovascular_score = 0;
                        } else if (inotropes_drug_count == 0 && non_steroid_drug_count == 1) {
                            cardiovascular_score = 1;
                        } else if (inotropes_drug_count == 1 && non_steroid_drug_count == 0) {
                            cardiovascular_score = 2;
                        } else if (inotropes_drug_count >= 2 || (inotropes_drug_count == 1 && non_steroid_drug_count == 1)) {
                            cardiovascular_score = 3;
                        } else if (inotropes_drug_count >= 2 && non_steroid_drug_count > 0) {
                            cardiovascular_score = 4;
                        }

                        if (cardiovascular_score >= 0) {
                            $('.c-' + cardiovascular_score).addClass('active');
                        }

                        cardiovascular_data += '<td><b>';
                        cardiovascular_data += cardiovascular_score;
                        cardiovascular_data += '</b></td>';

                        cardiovascular_score_list[time] = cardiovascular_score;
                    });
                } else {
                    inotropes_data += '<td>';
                    inotropes_data += 'Drug not found';
                    inotropes_data += '</td>';

                    non_steroid_data += '<td>';
                    non_steroid_data += 'Drug not found';
                    non_steroid_data += '</td>';

                    cardiovascular_data += '<td>';
                    cardiovascular_data += '<b>0</b>';
                    cardiovascular_data += '</td>';
                }
                inotropes_data += '</tr>';
                non_steroid_data += '</tr>';
                cardiovascular_data += '</tr>';
                var data = inotropes_data + non_steroid_data + cardiovascular_data;
                return data;
            }

            function hematologicCell(result) {
                var platelet_data = '<tr>';
                platelet_data += '<td>';
                platelet_data += 'Platelet';
                platelet_data += '</td>';
                var hematologic_data = '<tr>';
                hematologic_data += '<td>';
                hematologic_data += '<b>Score</b>';
                hematologic_data += '</td>';

                var hour_list = result['lab_hour_list'];
                var platelet_result = result[245];

                if (hour_list.length > 0) {
                    $.each(hour_list, function(index, time) {
                        if (typeof platelet_result != 'undefined') { 
                            if (typeof platelet_result[time] != 'undefined') { 
                                platelet_data += '<td>';
                                var cal = platelet_result[time].intf_ref_value;
                                platelet_data += cal;
                                platelet_data += '</td>';

                                var hematologic_score = '-';

                                hematologic_data += '<td><b>';
                                if (cal >= 150000) {
                                    hematologic_score = 0;
                                } else if (cal >= 100001 && cal <= 149999) {
                                    hematologic_score = 1;
                                } else if (cal >= 50001 && cal <= 100000) {
                                    hematologic_score = 2;
                                } else if (cal <= 50000) {
                                    hematologic_score = 3;
                                }
                                hematologic_data += hematologic_score;
                                hematologic_data += '</b></td>';

                                if (hematologic_score >= 0) {
                                    $('.h-' + hematologic_score).addClass('active');
                                }
                                
                                hematologic_score_list[time] = hematologic_score;
                            } else {
                                platelet_data += empty_content;
                                hematologic_data += empty_content;
                            }
                        } else {
                            platelet_data += empty_content;
                            hematologic_data += empty_content;
                        }
                    });
                }
                platelet_data += '</tr>';
                hematologic_data += '</tr>';
                var data = platelet_data + hematologic_data;
                return data;
            }

            function score(hour_list) {
                if (hour_list.length > 0) {
                    var score = '-';
                    $.each(hour_list, function(index, time) {
                        if (typeof respiratory_score_list != 'undefined' && typeof respiratory_score_list[time] != 'undefined') {
                            if (score != '-') {
                                score = score + parseInt(respiratory_score_list[time]);
                            } else {
                                score = parseInt(respiratory_score_list[time]);
                            }
                        } else {
                            if (Object.keys(respiratory_score_list).length == 0) {
                                score = 'N/A';
                                // $('.rs-0').addClass('active');
                            }
                        }
                        if (typeof cardiovascular_score_list != 'undefined' && typeof cardiovascular_score_list[time] != 'undefined') {
                            if (score != '-') {
                                if (score == 'N/A') {
                                } else {
                                    score = score + parseInt(cardiovascular_score_list[time]);
                                }
                            } else {
                                score = parseInt(cardiovascular_score_list[time]);
                            }
                        } else {
                            if (Object.keys(cardiovascular_score_list).length == 0) {
                                $('.c-0').addClass('active');
                            }
                        }
                        if (typeof hematologic_score_list != 'undefined' && typeof hematologic_score_list[time] != 'undefined') {
                            if (score != '-') {
                                if (score == 'N/A') {
                                } else {
                                    score = score + parseInt(hematologic_score_list[time]);
                                }
                            } else {
                                score = parseInt(hematologic_score_list[time]);
                            }
                        } else {
                            if (Object.keys(hematologic_score_list).length == 0) {
                                $('.h-0').addClass('active');
                            }
                        }

                    });
                }
                return score;
            }
        });
    </script>
    @endsection
