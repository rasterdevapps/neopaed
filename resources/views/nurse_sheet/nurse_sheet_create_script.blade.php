@section('scripts') 
<script type = "text/javascript">
$('#last_bg_time').mdtimepicker();
$('.drug-fluids-masters').click(function() {
    $('#iv-fluides-master-modal').modal('show');
    $('input[name="pharmacological_name[]"]').val('');
    $('input[name="name[]"]').val('');

});

$('#save-fluids-btn').click(function() {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        data: $("#ivfluids-post").serialize(),
        url: "{{ url('ivfluids-update-master') }}",
        success: function(response) {
            Showalert(response.messageType, response.message);
            var options1 = '<option value="' + response.data.id + '">' + response.data.pharmacological_name + '</option>';
            var options2 = '<option value="' + response.data.id + '">' + response.data.name + '</option>';
            //console.log(response.data);
            $('select[name="replacement_fluids_solution[]"]').each(function() {
                $(this).append(options2)
            });
            $('#iv-fluides-master-modal').modal('hide');
        }
    });

});

function addLeadingZero(name) {

    $('input[name="' + name + '"]').change(function() {
        var itRateSecound = $(this).val();
        if (itRateSecound.indexOf('.') == 0) {
            $(this).val('0' + $(this).val());
        }

    });

}


@foreach($dial_pade as $prperty)
addDiaelPad('{{ $prperty[0] }}', '{{ $prperty[0] }}', 'dial-pade-text-width', '{{ $prperty[1] }}', '{{ $prperty[2] }}', '{{ $prperty[3] }}', '{{ $prperty[4] }}');
addLeadingZero('{{ $prperty[0] }}');
@endforeach




function addOutputrunningTotal(keyid, keyvalue) {

    var keyid = keyid + '_total';
    $('#' + keyid).val(keyvalue);
}

@foreach($output_temp as $key => $value)

addOutputrunningTotal('{{ $key }}', '{{ $value }}');

@endforeach

$('.print-prescription').click(function() {

    var sheetDate = $('#sheet_date').val();
    var babyId = $('input[name="baby_id"]').val();
    var admissionId = $('input[name="admission_id"]').val();

    if (sheetDate != '' && babyId != '' && admissionId != '') {


        $.ajax({
            type: 'GET',
            url: "{{url('nicu-nurse-sheets-admission/get-prescription-url')}}",
            data: {
                sheetDate: sheetDate,
                babyId: babyId,
                admissionId: admissionId
            },
            success: function(responseText) {
                window.location = responseText.message;
            },
            error: function(responseText) {
                Showalert(responseText.type, responseText.message);
            }
        })
    } else {
        Showalert('warning', 'Please Select The date !');
    }

});

function getrunning_total(drugRate, drugId, drugName, targetId) {

    var sheetDate = $('#sheet_date').val();
    var babyId = $('input[name="baby_id"]').val();
    var admissionId = $('input[name="admission_id"]').val();
    var timeHour = $('select[name="time_hour"]').val();
    var timeMiniuts = $('select[name="time_min"]').val();
    var timeSession = $('select[name="time_session"]').val();

    if (sheetDate != '' && timeHour != '' && timeMiniuts != '' && timeSession != '' && drugName != '') {
        $.ajax({
            type: 'GET',
            url: "{{ action('Nurse\NurseSheetController@calculaterunningtotal') }}",
            data: {
                sheetDate: sheetDate,
                babyId: babyId,
                admissionId: admissionId,
                drugRate: drugRate,
                drugId,
                drugName: drugName
            },
            success: function(responseText) {

                $(targetId).val(responseText.total).trigger('change');
            },
            error: function(responseText) {
                Showalert(responseText.type, responseText.message);
            }
        });

    } else if (sheetDate == '' && timeHour == '' && timeMiniuts == '' && timeSession == '') {

        Showalert('warning', 'Please Select The date and time!');

    }

}

function getspoturine(currentUrine) {

    var sheetDate = $('#sheet_date').val();
    var babyId = $('input[name="baby_id"]').val();
    var admissionId = $('input[name="admission_id"]').val();
    var timeHour = $('select[name="time_hour"]').val();
    var timeMiniuts = $('select[name="time_min"]').val();
    var timeSession = $('select[name="time_session"]').val();


    if (sheetDate != '' && timeHour != '' && timeMiniuts != '' && timeSession != '' && currentUrine != '') {

        $.ajax({
            type: 'GET',
            url: "{{ action('Nurse\NurseSheetController@getsporturinetotal') }}",
            data: {
                sheetDate: sheetDate,
                babyId: babyId,
                admissionId: admissionId,
                currentUrine: currentUrine,
                timeHour: timeHour,
                timeMiniuts: timeMiniuts,
                timeSession: timeSession
            },
            success: function(responseText) {

                $('#urine_total_ml_kg').val(responseText.result);
                if (responseText.urineTotal != '') {
                    var workWeight = $('#working_weight').val();
                    responseText.urineTotal = workWeight / responseText.urineTotal;
                    $('#urine_total_full_day').val(responseText.urineTotal.toFixed(2));

                }

            },
            error: function(responseText) {

            }
        });

    } else if (sheetDate == '' && timeHour == '' && timeMiniuts == '' && timeSession == '') {

        Showalert('warning', 'Please Select The date and time!');
    }

}


function nurseSheetsave(saveUrl, nurseData, callType, flag = '') {
    console.log(nurseData);
    var check_size = $('#nurse-form .not_saved').serializeArray();
    if (callType == 'manual') {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: saveUrl,
            data: nurseData,
            beforeSend: function() {
                $('.save-nurse-sheet').attr('disabled', true);
                $('.save-nurse-sheet > i').removeClass('fa fa-floppy-o').addClass('fa fa-spinner fa-spin').prop('disabled', 'true');
            },
            success: function(responseText) {
                if (flag == 2) {
                    window.location.href = "{{ action('Nurse\NurseSheetController@GetDaylist', \SiteHelpers::encrypt_id($admission_id)) }}";
                } else {
                    Showalert(responseText.type, responseText.message);
                    $('.save-nurse-sheet > i').removeClass('fa fa-spinner fa-spin').addClass('fa fa-floppy-o');
                    $('.save-nurse-sheet').removeAttr('disabled');
                    $(".not_saved").removeClass("not_saved");
                    $(".permanant_saved").addClass("not_saved");
                }

            },
            error: function(responseText) {
                $('.save-nurse-sheet > i').removeClass('fa fa-spinner fa-spin').addClass('fa fa-floppy-o');
                $('.save-nurse-sheet').removeAttr('disabled');

            }

        });
    } else {
        if (check_size.length > 8) {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: saveUrl,
                data: nurseData,
                beforeSend: function() {

                },
                success: function(responseText) {
                    $(".not_saved").removeClass("not_saved");
                    $(".permanant_saved").addClass("not_saved");
                },
                error: function(responseText) {

                }

            });
        }
    }
}

$("#nurse-form").validate({
    rules: {
        sheet_date: "required"
    }
});

$('.save-nurse-sheet').click(function() {
    var flag = $(this).data('flag');

    if ($('input[name="current_weight"]').val() == '' || $('input[name="current_weight"]').val() == 0) {
        $('#current-weight-error').removeClass('hide');
        $('html, body').animate({scrollTop : 0},800);
        return false;
    } else {
        $('#current-weight-error').addClass('hide');
    }
    if ($('input[name="working_weight"]').val() == '' || $('input[name="working_weight"]').val() == 0) {
        $('#working-weight-error').removeClass('hide');
        $('html, body').animate({scrollTop : 0},800);
        return false;        
    } else {
        $('#working-weight-error').addClass('hide');
    }

    if ($('#nurse-form').valid() === true) {
        nurseSheetsave('{{ action("Nurse\NurseSheetController@store")}}', $('#nurse-form .not_saved').serialize(), 'manual', flag);
    }

});

var restForm = ['warmer', 'incubator', 'core_temp', 'peripheral_temp', 'rectal_temp', 'humidifier_temp',
    'milk_volume', 'milk_volume_total', 't1_t2', 'fio2', 'flow', 'gastric_aspirate_volume',
    'gastric_aspirate_volume_total', 'urine_output', 'urine_output_total', 'blood_volume_out',
    'drain_output_r', 'drain_output_l', 'stoma_output_hour', 'intravenous_fluids', 'oral_fluids',
    'other_drugs', 'total_intake_ml', 'total_intake_kg', 'i_o_balance', 'i_o_balance_ml_kg',
    'aspirate_ml', 'drains_ml', 'urine_total', 'urine_total_full_day', 'urine_total_ml_kg',
    'blood_out_total', 'stools_frequency', 'stoma_output', 'total_output', 'total_output_ml_day',
    'blood_gas_bilirubin', 'blood_sugar', 'blood_gas_ph', 'blood_gas_pao2', 'blood_gas_paco2',
    'blood_gas_hco3', 'blood_gas_etco2', 'blood_gas_be', 'blood_gas_na', 'blood_gas_k',
    'blood_gas_cl', 'blood_gas_hb', 'blood_gas_pcv', 'blood_gas_lactate', 'blood_gas_methemoglobin',
    'gluco_meter_calcium', 'gluco_meter_magnesium', 'gluco_meter_phosphorus', 'gluco_meter_bun',
    'gluco_meter_creatintine', 'gluco_meter_glucose', 'gluco_meter_creatinekinase', 'gluco_meter_ckmb',
    'gluco_meter_trop', 'gluco_meter_totalbilirubin', 'gluco_meter_directbilirubin', 'gluco_meter_sgot',
    'gluco_meter_sgpt', 'gluco_meter_alkalinephosphatase', 'gluco_meter_gamagtp', 'gluco_meter_ldh',
    'gluco_meter_amylase', 'gluco_meter_lipase', 'gluco_meter_totalprotein', 'gluco_meter_albumin',
    'gluco_meter_totalcholesterol', 'gluco_meter_hdl', 'gluco_meter_ldl', 'gluco_meter_vldl',
    'gluco_meter_triglycerides', 'gluco_meter_rbc', 'gluco_meter_haematocrit', 'gluco_meter_reticulocytecount',
    'gluco_meter_wbc', 'gluco_meter_dc', 'gluco_meter_lymph', 'gluco_meter_mono', 'gluco_meter_eos',
    'gluco_meter_baso', 'gluco_meter_platelets', 'gluco_meter_esr', 'gluco_meter_prothrombintime',
    'gluco_meter_aptt', 'gluco_meter_inr', 'gluco_meter_fibrinogen', 'gluco_meter_fdp',
    'blood_volume_out_total', 'drain_output_r_total', 'drain_output_l_total', 'interface_blood_gas_bilirubin',
    'interface_blood_sugar', 'interface_blood_gas_ph', 'interface_blood_gas_pao2', 'interface_blood_gas_paco2', 
    'interface_blood_gas_hco3', 'interface_blood_gas_etco2', 'interface_blood_gas_be', 'interface_blood_gas_na', 
    'interface_blood_gas_k','interface_blood_gas_cl','interface_blood_gas_hb', 'interface_blood_gas_pcv', 
    'interface_blood_gas_lactate', 'interface_blood_gas_methemoglobin', 'interface_blood_gas_calcium', 'tcpo2', 'tcpco2'
];

var restFormNotAvilable = ['type_of_care', 'color', 'activity', 'position', 'work_of_breathing'];

var restFormEmpty = ['cpap_interface_change', 'air_entry_right', 'air_entry_left', 'Transfusion',
    'replacement_fluids_status', 'blood_gas_type', 'route_of_feeds'
];

var buttonReset = ['therapeutic_hypothermia', 'phototherapy', 'phototherapy_eyes',
    'physiotherapy', 'suction', 'human_milk_fortification', 'bowels',
    'kmc', 'nns'
];

$('.reset-from').click(function() {

    bootbox.confirm({
        title: "Nurse Hour Wise Sheet Confirmation",
        message: "Are you sure want reset ?",
        className: "multiple-admission-confirmation",
        buttons: {
            cancel: {
                label: '<i class="fa fa-times"></i> Cancel',
                className: 'save-button-shadow'
            },
            confirm: {
                label: '<i class="fa fa-check"></i> Reset',
                className: 'save-button-shadow btn-success'
            }
        },
        callback: function(confirmed) {
            if (confirmed) {
                $.each(restForm, function(index, value) {
                    $('#' + value).val('');

                });
                $.each(restFormNotAvilable, function(restFormNotAvilableIndex, restFormNotAvilableValue) {
                    $('#' + restFormNotAvilableValue).val('N/A').trigger('change');
                });
                $.each(restFormEmpty, function(restFormEmptyIndex, restFormEmptyValue) {
                    $('#' + restFormEmptyValue).val('').trigger('change');
                });

                $.each(buttonReset, function(buttonResetIndex, buttonResetValue) {
                    $('#' + buttonResetValue).bootstrapToggle('off');
                });
            }
        }
    });
});
$(document).on('change', '.dial-pade-text-width, select, input, textarea', function(e) {
    var element = $(e.target)[0];

    if (!$(element).hasClass('not_saved')) {
        $(element).addClass('not_saved');
    }
    // if ($(element).hasClass('not_saved') && !$(element).val()) {
    //     $(element).removeClass('not_saved');
    // }
});
// setInterval(nurseSheetsave('{{ action("Nurse\NurseSheetController@store")}}', $('#nurse-form .not_saved').serialize()), 500);

// window.setInterval(function () {
//     nurseSheetsave('{{ action("Nurse\NurseSheetController@store")}}', $('#nurse-form .not_saved').serialize(), 'interval');
// }, 5000);

$(document).ready(function() {
    var indication = JSON.parse($('input[name="indication"]').val());
    var monitor = JSON.parse($('input[name="monitor"]').val());
    var ventilator = JSON.parse($('input[name="ventilator"]').val());

    // if (indication.infusion == 'active') {

    // } 
    if (indication.monitor == 'active') {
        $.each(monitor, function(index, value) {
            if (value != 'core_temp') {
                $('label[for="' + value + '"]').parent().hide();
            }
        });
        $('label[for="bp_method"]').parent().hide();
        $('label[for="bp_method"], label[for="t1_t2"], label[for="respiratory_rate"]').parent().hide();
    }
    if (indication.ventilator == 'active') {
        $.each(ventilator, function(index, value) {
            if (value != 'humidifier_temp' && value != 'air_entry_right' && value != 'air_entry_left') {
                $('label[for="' + value + '"]').parent().hide();
            }
        });
    }

    $('#sheet3 input').attr('readonly', true);
    /*Validate Future Time*/
    function validateTime() {
        var current_date_time = new Date();
        var dd = current_date_time.getDate();
        var mm = current_date_time.getMonth() + 1;

        var yyyy = current_date_time.getFullYear();
        if (dd < 10) {
            dd = '0' + dd;
        }
        if (mm < 10) {
            mm = '0' + mm;
        }
        var current_date = dd + '-' + mm + '-' + yyyy;
        var sheet_date = $('#sheet_date').val();
        if (current_date == sheet_date) {
            var hours = current_date_time.getHours();
            var minutes = current_date_time.getMinutes();
            var ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            minutes = minutes < 10 ? '0' + minutes : minutes;
            $("#time_hour option").each(function() {

                if (ampm == 'AM') {
                    if ($(this).val() > hours) {
                        $(this).attr('disabled', 'true');
                    }
                } else {
                    if ($(this).val() == hours) {
                        if ($("#time_hour").val() > hours) {
                            $("#time_hour").select2('val', hours);
                        }
                        $("#time_hour option[value='" + hours + "']").nextAll().attr('disabled', 'true');
                        $("#time_hour option[value='12']").removeAttr('disabled');
                    }

                }
            });
            var time_session = $("#time_session").val();
            if (time_session == 'AM' && ampm == 'PM') {
                $("#time_hour option").removeAttr('disabled');

            }

            if (ampm == 'AM') {
                $("#time_session option[value='PM']").attr('disabled', 'true');
            }
        } else {
            $("#time_hour option").removeAttr('disabled');
            $("#time_session option").removeAttr('disabled');
        }
    }
    validateTime();
    $('#sheet_date').change(function() {
        validateTime();
    });
    $('#time_session').change(function() {
        validateTime();
    });

});
$('.ventilator_properties').hide();
$('#ett_status').on('change', function() {
    if ($(this).prop("checked")) {
        $('.ett-enable').removeClass('display-none');
    } else {
        $('.ett-enable').addClass('display-none');
    }
});
$('#ngt_status').on('change', function() {
    if ($(this).prop("checked")) {
        $('.ngt-enable').removeClass('display-none');
    } else {
        $('.ngt-enable').addClass('display-none');
    }
});
// $('.save-nurse-sheet').click(function() {
//     var flag = $(this).data('flag');
//     nurseSheetsave('{{ action("Nurse\NurseSheetController@store")}}', $('#nurse-form .not_saved').serialize(), 'manual');
//     if (flag == 2) {
//         window.location.href = "{{ action('Nurse\NurseSheetController@GetDaylist', \SiteHelpers::encrypt_id($admission_id)) }}";
//     }
// });

// function nurseSheetsave(saveUrl, nurseData, callType) {
//     var check_size = $('#nurse-form .not_saved').serializeArray();
//     if (callType == 'manual') {
//         $.ajax({
//             headers: {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             },
//             type: 'POST',
//             url: saveUrl,
//             data: nurseData,
//             beforeSend: function() {
//                 $('.save-nurse-sheet').attr('disabled', true);
//                 $('.save-nurse-sheet > i').removeClass('fa fa-floppy-o').addClass('fa fa-spinner fa-spin').prop('disabled', 'true');
//             },
//             success: function(responseText) {
//                 // Showalert(responseText.type, responseText.message);
//                 $('.save-nurse-sheet > i').removeClass('fa fa-spinner fa-spin').addClass('fa fa-floppy-o');
//                 $('.save-nurse-sheet').removeAttr('disabled');
//                 // $(".not_saved").removeClass("not_saved");
//                 // $(".permanant_saved").addClass("not_saved");
//                 bootbox.alert({
//                     size: "small",
//                     title: "Below data stored successfully",
//                     message: responseText.stored_content,
//                     callback: function(){ /* your callback code */ }
//                 })

//             },
//             error: function(responseText) {
//                 $('.save-nurse-sheet > i').removeClass('fa fa-spinner fa-spin').addClass('fa fa-floppy-o');
//                 $('.save-nurse-sheet').removeAttr('disabled');
//             }
//         });
//     }
//     else
//     {
//         if (check_size.length > 8) {
//             $.ajax({
//                 headers: {
//                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                 },
//                 type: 'POST',
//                 url: saveUrl,
//                 data: nurseData,
//                 beforeSend: function() {},
//                 success: function(responseText) {
//                     // $(".not_saved").removeClass("not_saved");
//                     // $(".permanant_saved").addClass("not_saved");
//                 },
//                 error: function(responseText) {}
//             });
//         }
//     }
// }
</script>
@endsection
