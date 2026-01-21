$(document).ready(function () {
    var baby_id = $('input[name="baby_id"]').val();
    var admission_id = $('input[name="admission_id"]').val();
    var prescription_list = JSON.parse($('input[name="prescription_list"]').val());
    var intravenous_prescription_list = JSON.parse($('input[name="intravenous_prescription_list"]').val());
    var prescribed_date_list = $('input[name="prescribed_date_list"]').val();
    var user_role = $('input[name="user_role"]').val();
    var super_admin_role = $('input[name="super_admin_role"]').val();
    var admin_role = $('input[name="admin_role"]').val();
    var doctor_id = $('input[name="doctor_id"]').val();
    var site_url = $('input[name="site_base_url"]').val();
    var site_url_public = site_url + '/public';
    var pump_interface = $('input[name="pump_interface"]').val();
    var prescription_freq = JSON.parse($('input[name="prescription_freq"]').val());
    var no_img_file_name = 'no-image.png';
    var alt_img = '<img src="' + site_url_public + '/img/' + no_img_file_name + '" class="alt-image-user" />';
    var device_interval_function_call = false;
    var getDeviceDetailsByInterval = '';
    var event_time_row_1 = ['00', '01', '02', '03'];
    var event_time_row_2 = ['04', '05', '06', '07'];
    var event_time_row_3 = ['08', '09', '10', '11'];
    var event_time_row_4 = ['12', '13', '14', '15'];
    var event_time_row_5 = ['16', '17', '18', '19'];
    var event_time_row_6 = ['20', '21', '22', '23'];
    var status_initial = 'syringe-pump-status-conformation';
    var status_sent = 'syringe-pump-status-send-pump';
    var status_queue = 'syringe-pump-status-queue';
    var status_pause = 'syringe-pump-status-pause';
    var status_execute = 'syringe-pump-status-executing';
    var status_complete = 'syringe-pump-status-completed';
    var status_cancel = 'syringe-pump-status-cancel';
    var status_stop = 'syringe-pump-status-stop';
    var regular_default_frame = 12;
    var required_stat_default_frame = 6;
    var intravenous_default_frame = 18;
    var check_box_selected_count = 0;
    var check_box_already_done = 'Status has been changed !';
    var review_date_already_done = 'Review data has been changed !';
    var edit_already_done = 'Prescription has been changed !';
    var terminate_already_done = 'Drug has been terminated !';
    $('.drug-fluids-masters').click(function () {
        openModal('iv-fluids-master-modal');
        $('#save-fluiddrug-btn').attr('disabled', false);
        $('input[name="pharmacological_name[]"]').val('');
        $('input[name="name[]"]').val('');
    });
    $('#save-fluiddrug-btn').click(function () {
        $('#save-fluiddrug-btn').attr('disabled', true);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            data: $("#fluiddrug-post").serialize(),
            url: site_url + '/masters/drugivfluid',
            success: function (response) {
                Showalert(response.messageType, response.message);
                if (response.messageType == "success") {
                    var options1 = '<option value="' + response.data.type + ':' + response.data.id + '">' + response.data.generic_pharmacological_name + '</option>';
                    var options2 = '<option value="' + response.data.type + ':' + response.data.id + '">' + response.data.brand_name + '</option>';
                    $('select[name="brandname"] #' + response.data.type).each(function () {
                        $(this).append(options2)
                    });
                    $('select[name="pharmacological"] #' + response.data.type).each(function () {
                        $(this).append(options1)
                    });
                    closeModal('iv-fluids-master-modal');
                }
            }
        });
    });
    $('.frequency-masters').click(function () {
        openModal('frequency-master-modal');
        $('#save-frequency-btn').attr('disabled', false);
        $('input[name="name[]"]').val('');
        $('input[name="value[]"]').val('');
    });
    $('#save-frequency-btn').click(function () {
        $('#save-frequency-btn').attr('disabled', true);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            data: $("#frequency-post").serialize(),
            url: site_url + '/masters/frequency',
            success: function (response) {
                Showalert(response.messageType, response.message);
                if (response.messageType == "success") {
                    var option = '<option value="' + response.data.value + '">' + response.data.name + '</option>';
                    $('select[name="other_iv_drugs_frequency"] option').each(function () {
                        $(this).append(option)
                    });
                    $('select[name="oral_frequency"] option').each(function () {
                        $(this).append(option)
                    });
                    closeModal('frequency-master-modal');
                }
            }
        });
    });
    $("#drug_names").select2();
    $('.create-drug').click(function () {
        var working_wgt = $('input[name="working_wgt"]').val();
        if (working_wgt == '' || working_wgt == null || working_wgt.length < 3) {
            Showalert('warning', 'Please Enter Working Weight To Continue...');
            return false;
        }
        openModal('create-drug-modal');
        $('#prescription-save-btn').attr('disabled', false);
        $('#prescription-update-btn').attr('disabled', false);
        prescription_default_set = true;
        $('#post-working-weight').val(working_wgt);
        $('#create-drug-modal').find('.modal-footer button').attr('id', 'prescription-save-btn').html('Save');
    });
    $('#create-drug-modal').on('shown.bs.modal', function (e) {
        $("#drug_names").select2("open");
        $(".select2-result-label:contains(--Select option--)").parent().css("display", "none");
    });
    $("#drug_names").on("select2-open", function () {
        $(".select2-result-label:contains(--Select option--)").parent().css("display", "none");
        $(".select2-result-label").parents(".select2-results").addClass('custom-design');
    });
    $(".select2-search input").on("keyup", function () {
        $(".select2-result-label:contains(--Select option--)").parent().css("display", "none");
    });
    $('#create-drug-modal').on('hidden.bs.modal', function () {
        $('#drug_names').val('--Select option--').trigger('change.select2').attr('disabled', false);
        $('#create-drug-modal .add-drug').remove();
        $('input[name="day"]').attr('disabled', false);
        $('#pres-set-default').addClass('display-none');
        $('#pres-clear').addClass('display-none');
        $('#prescription-post .prescription').html('');
    });
    if ($('input[name="working_wgt"]').val() != '') {
        $('input[name="working_wgt"]').attr('readonly', true);
    } else {
        $('input[name="working_wgt"]').attr('readonly', false).addClass('active');
    }
    $('input[name="working_wgt"]').focusin(function () {
        if (!$(this).hasClass('active') && $(this).val() != '') {
            bootbox.confirm("Are you sure you want to change the working weight?", function (confirmed) {
                if (confirmed) {
                    $('input[name="working_wgt"]').attr('readonly', false).addClass('active');
                }
            });
        }
    });
    $('input[name="working_wgt"]').focusout(function () {
        if ($(this).hasClass('active')) {
            var working_weight = $(this).val();
            $('#post-working-weight').val(working_weight);
            if (working_weight.length < 3) {
                $('.working_wgt').css('display', 'block');
            } else {
                $('.working_wgt').css('display', 'none');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        baby_id: baby_id,
                        admission_id: admission_id,
                        working_weight: working_weight
                    },
                    type: 'PATCH',
                    url: site_url + '/store-working-weight',
                    success: function (response) {
                        Showalert(response.type, response.message);
                        $('input[name="working_wgt"]').val(working_weight).attr('readonly', true).removeClass('active');
                    },
                    error: function (responseText) { }
                });
            }
        }
    });
    $('textarea[name="allegries"]').focusout(function () {
        var allegries = $(this).val();
        $('#post-allegries').val(allegries);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                baby_id: baby_id,
                allegries: allegries
            },
            type: 'PATCH',
            url: site_url + '/save-allegries',
            success: function (response) {
                Showalert(response.type, response.message);
                $('textarea[name="allegries"]').val(allegries);
            },
            error: function (responseText) { }
        });
    });
    $(document).on('change', '#drug_prepartion #drug_names', function () {
        var id = 0;
        if ($(this).hasClass('brandname')) {
            $('#pharmacological-name-' + id).select2('val', $(this).val());
        } else {
            $('#brand-name-' + id).select2('val', $(this).val());
        }
        if ($(this).val() != null) {
            $('#pres-set-default').removeClass('display-none');
            $('#pres-clear').removeClass('display-none');
            var selectedOption = $(this).find('option:selected');
            console.log("SELECTED FIELDS" + selectedOption.data('is-gir') + " " + selectedOption.data('is-gc'));
            var isGir = selectedOption.data('is-gir');
            var isGc = selectedOption.data('is-gc');
            var infusion_type_id = $(this).val().split(':');
            anotherfields($(this).val(), id, isGir, isGc);
            if (prescription_default_set) {
                setDefaultValue(id, infusion_type_id[1], infusion_type_id[0]);
            }
        } else {
            $('#pres-set-default').addClass('display-none');
            $('#pres-clear').addClass('display-none');
        }
    });

    function anotherfields(type, id, isGir = false, isGc = false) {
        var infusion_type_id = type.split(':');
        console.log("isGir" + isGir);
        console.log("isGc" + isGc);
        $('.prescription').remove();
        $('.frequency_start_time_num').remove();
        $('.select-number-frequency_start_time_num').remove();
        var date = new Date();
        var default_date = dateFormatter(date) + '-' + monthFormatter(date) + '-' + date.getFullYear();
        var hours_12 = hourFormatter(date, false);
        var minutes = minuteFormatter(date, false);
        var ampm = sessionFormatter(date);

        var glucoseFields = '';
        if (isGir) {
            glucoseFields += '<div class="col-md-6 form-group"><div class="col-md-4">Glucose Infusion Rate (Mg/Kg/Min)</div><div class="col-md-8"><input type="text" name="glucose_infusion_rate" class="form-control numeric-only" id="glucose_infusion_rate-' + id + '" /></div><label id="glucose_infusion_rate_error" style="display: none; color: red;"></label></div>';
        }
        if (isGc) {
            glucoseFields += '<div class="col-md-6 form-group"><div class="col-md-4">Glucose Concentration (%)</div><div class="col-md-8"><input type="text" name="glucose_concentration" class="form-control numeric-only" id="glucose_concentration-' + id + '" /></div><label id="glucose_concentration_error" style="display: none; color: red;"></label></div>';
        }

        switch (infusion_type_id[0]) {
            case 'IVDI':

                console.log(glucoseFields);
                $('#drug_prepartion').after('<div class="col-md-12 prescription mt-5"><div class="col-md-6 form-group"><div class="col-md-4">Dose / Units</div><div class="col-md-8 display-flex"><input type="text" name="infusion_dose" class="form-control" id="infusion_dose-0" /><select name="infusion_dose_units_g" class="form-control input-width-small" id="infusion-dose-units-g-0">' + dose_unit_g + '</select><select name="infusion_dose_units_kg" class="form-control input-width-small" id="infusion-dose-units-kg-0">' + dose_unit_kg + '</select><select name="infusion_dose_units_time" class="form-control input-width-small" id="infusion-dose-units-time-0">' + dose_unit_duration + '</select></div><label id="infusion_dose_error" style="display: none; color: red;"></label></div><div class="col-md-6 form-group"><div class="col-md-4">Qty / Unit</div><div class="col-md-8 display-flex"><input type="text" name="infusion_quantity" class="form-control" id="infusion-quantity-0" /><select name="quantity_units" class="form-control input-width-small" id="quantity-units-0">' + qty_units + '</select></div><label id="infusion_quantity_error" style="display: none; color: red;"></label></div><div class="col-md-6 form-group"><div class="col-md-4">Syringe Size (ml)</div><div class="col-md-8"><select name="infusion_syringe" class="form-control" id="infusion-syringe-0">' + syringe_type + '</select></div></div><div class="col-md-6 form-group"><div class="col-md-4">Rate (ml/hr)</div><div class="col-md-8"><input type="text" name="infusion_rate" class="form-control" id="infusion-rate-0" /></div><label id="infusion_rate_error" style="display: none; color: red;"></label></div><div class="col-md-6 form-group"><div class="col-md-4">Additional Instruction</div><div class="col-md-8"><input type="text" name="infusion_instruction" class="form-control" id="infusion-instruction-0" /></div></div><div class="col-md-6 form-group"><div class="col-md-4">Additional Drug Added</div><div class="col-md-8"><input type="text" name="infusion_drug_added" class="form-control" id="infusion_drug_added-0"></div></div><div class="col-md-6 form-group"><div class="col-md-4">Dose & Frequency Of Additional Drug</div><div class="col-md-8"><input type="text" name="infusion_feq_addition" class="form-control" id="infusion_feq_addition-0"></div></div><div class="col-md-6 form-group"><div class="col-md-4">Batch No</div><div class="col-md-8"><input type="text" name="infusion_batch_no" class="form-control" id="infusion_batch_no-0"></div></div>' + glucoseFields + '<div class="col-md-6 form-group"><div class="col-md-4">Prescribed By (Doctor)</div><div class="col-md-8"><select name="prescribed_by" class="full-width" id="prescribed_by-0">' + doctor_name_list + '</select></div></div><div class="col-md-6 form-group pres-date-align"><div class="col-md-4">Prescribed Date & Time</div><div class="col-md-8 display-flex"><input type="text" name="prescribed_date" class="form-control prescribed-date mr-10" id="drug-prescribed-date-0" readonly /><select name="prescribed_hours" class="form-control mr-10 input-width-small hours">' + hour_opt + '</select><select name="prescribed_mins" class="form-control mr-10 input-width-small minutes">' + mins_opt + '</select><select name="prescribed_session" class="form-control input-width-small session">' + session_opt + '</select></div></div><div class="col-md-6 form-group pres-date-align"><div class="col-md-4">Start Date & Time</div><div class="col-md-8 display-flex"><input type="text" name="start_date" class="form-control start-date mr-10" id="start-date-0" readonly /><select name="start_hours" class="form-control mr-10 input-width-small hours">' + hour_opt + '</select><select name="start_mins" class="form-control mr-10 input-width-small minutes">' + mins_opt + '</select><select name="start_session" class="form-control input-width-small session">' + session_opt + '</select></div></div>');
                if ((user_role == super_admin_role || user_role == admin_role) && doctor_id != '') {
                    $("#prescribed_by-0").select2().val(doctor_id).trigger('change');
                } else {
                    $("#prescribed_by-0").select2();
                }
                break;
            case 'OIVD':
                $('#drug_prepartion').after('<div class="col-md-12 prescription mt-5"><div class="col-md-6 form-group dose-required-field"><div class="col-md-4">Dose / Required</div><div class="col-md-8 display-flex"><input type="text" name="other_iv_drugs_dose_required" class="form-control" id="other_iv_drugs_dose_required-0" /><select name="drugs_dose_units" class="form-control input-width-small mr-15" id="drugs-dose-units-0">' + dose_list + '</select><input type="text" name="other_iv_drugs_alt_dose" class="form-control" id="other_iv_drugs_alt_dose-0" /><select name="drugs_alt_dose_units" class="form-control input-width-small" id="drugs-alt-dose-units-0">' + dose_list + '</select></div><label id="other_iv_drugs_dose_error" style="display: none; color: red;"></label></div><div class="col-md-6 form-group"><div class="col-md-4">Frequency</div><div class="col-md-8"><select name="other_iv_drugs_frequency" class="full-width" id="other-iv-drugs-frequency-0">' + frequency_list + '</select></div></div><div class="col-md-6 form-group"><div class="col-md-4">Vol / Dose (ml)</div><div class="col-md-8"><input type="text" name="other_iv_drugs_syringe" class="form-control" id="other_iv_drugs_syringe-0"></div><label id="other_iv_drugs_syringe_error" style="display: none; color: red;"></label></div><div class="col-md-6 form-group"><div class="col-md-4">Rate (ml/hr)</div><div class="col-md-8"><input type="text" name="other_iv_drugs_rate" class="form-control" id="other_iv_drugs_rate-0" /></div><label id="other_iv_drugs_rate_error" style="display: none; color: red;"></label></div><div class="col-md-6 form-group"><div class="col-md-4">Additional Instruction</div><div class="col-md-8"><input type="text" name="other_iv_drugs_additional" class="form-control other_iv_drugs_additional" id="other_iv_drugs_additional-0" /></div></div><div class="col-md-6 form-group"><div class="col-md-4">Prescribed By (Doctor)</div><div class="col-md-8"><select name="prescribed_by" class="full-width" id="prescribed_by-0">' + doctor_name_list + '</select></div></div><div class="col-md-6 form-group pres-date-align"><div class="col-md-4">Prescribed Date & Time</div><div class="col-md-8 display-flex"><input type="text" name="prescribed_date" class="form-control prescribed-date mr-10" id="drug-prescribed-date-0" readonly /><select name="prescribed_hours" class="form-control mr-10 input-width-small hours">' + hour_opt + '</select><select name="prescribed_mins" class="form-control mr-10 input-width-small minutes">' + mins_opt + '</select><select name="prescribed_session" class="form-control input-width-small session">' + session_opt + '</select></div></div><div class="col-md-6 form-group pres-date-align"><div class="col-md-4">Start Date</div><div class="col-md-8"><input type="text" name="start_date" class="form-control start-date" id="start-date-0" readonly /></div></div><div class="col-md-6 form-group pres-date-align"><div class="col-md-4">Review Date</div><div class="col-md-8"><input type="text" name="other_iv_drugs_review_date" class="form-control review-date" id="drug-review-date-0" readonly /></div></div><div class="col-md-12 form-group start-hour-entry"><div class="col-md-4">Starting hour</div><div class="col-md-8" style="display: flex; align-items: center; white-space: nowrap;"><input type="text" id="frequency_start_time" class="form-control input-width-mini" name="frequency_start_time" readonly style="display: inline-block;"><span class="frequency_start_time_num"></span><div class="hour-session"><label class="display-inline"><input type="radio" name="starthour" value="am" id="starthour-am" /><span>AM</span></label><label class="display-inline"><input type="radio" name="starthour" value="pm" id="starthour-pm" /><span>PM</span></label></div></div><label id="frequency_start_hour_error" style="display: none; color: red"></label><label id="frequency_start_time_error" style="display: none; color: red"></label></div><div class="col-md-12 form-group display-flex prescription-type"><div class="col-md-4">Prescription Type</div><div class="col-md-8"><div class="pump-session"><label class="display-inline"><input type="radio" name="prescription_type" value="1" id="regular" /><span></span></label><span>Regular</span><label class="display-inline"><input type="radio" name="prescription_type" value="2" id="required" /><span></span></label><span class="required-width">As Required (PRN or SOS)</span><label class="display-inline"><input type="radio" name="prescription_type" value="4" id="stat" /><span></span></label><span class="stat-width">STAT / Once Only</span></div></div></div>');
                $("#other-iv-drugs-frequency-0").select2();
                $('#drug-review-date-0').datepicker({
                    dateFormat: 'dd-mm-yy',
                    changeMonth: true,
                    changeYear: true
                }).val(default_date);
                addDiaelPad(prescription_freq[0], prescription_freq[0], 'dial-pade-text-width', prescription_freq[1], prescription_freq[2], prescription_freq[3], prescription_freq[4]);
                addLeadingZero(prescription_freq[0]);
                $('input#regular').prop('checked', true);
                if ((user_role == super_admin_role || user_role == admin_role) && doctor_id != '') {
                    $("#prescribed_by-0").select2().val(doctor_id).trigger('change');
                } else {
                    $("#prescribed_by-0").select2();
                }
                break;
            case 'OIVI':
                console.log("OIVI");
                $('#drug_prepartion').after('<div class="col-md-12 prescription mt-5"><div class="col-md-6 form-group"><div class="col-md-4">Volume To Be Infused (ml)</div><div class="col-md-8"><input type="text" name="other_infusions_volume" class="form-control" id="other_infusions_volume-0" /></div><label id="other_infusions_volume_error" style="display: none; color: red;"></label></div><div class="col-md-6 form-group"><div class="col-md-4">Rate (ml/hr)</div><div class="col-md-8"><input type="text" name="other_infusions_rate" class="form-control" id="other_infusions_rate-0"></div><label id="other_infusions_rate_error" style="display: none; color: red;"></div><div class="col-md-6 form-group"><div class="col-md-4">Duration</div><div class="col-md-8 display-flex"><input type="text" name="other_infusions_duration" class="form-control" id="other_infusions_duration-0" /><select name="other_infusions_durametnod" class="form-control other-infusions-durametnod input-width-small" id="other_infusions_durametnod-0">' + durametnod_list + '</select></div></div><div class="col-md-6 form-group display-flex"><div class="col-md-4" style="margin-top: 9px;">Syringe / Infusion Pump</div><div class="col-md-8"><div class="pump-session"><label class="display-inline"><input type="radio" name="other_infusions_pump_type" value="IVG" id="other_infusions_pump_type-IVG" checked /><span></span></label><span>Infusion Pump</span><label class="display-inline"><input type="radio" name="other_infusions_pump_type" value="IV" id="other_infusions_pump_type-IV" /><span></span></label><span>Syringe Pump</span></div></div></div><div class="col-md-6 form-group"><div class="col-md-4">Additional Instruction</div><div class="col-md-8"><input type="text" name="other_infusions_instruction" class="form-control" id="other_infusions_instruction-0"></div></div><div class="col-md-6 form-group"><div class="col-md-4">Additional Drug Added</div><div class="col-md-8"><input type="text" name="other_infusions_drug_added" class="form-control" id="other_infusions_drug_added-0"></div></div><div class="col-md-6 form-group"><div class="col-md-4">Dose & Frequency Of Additional Drug</div><div class="col-md-8"><input type="text" name="other_infusions_dose_feq_addition" class="form-control" id="other_infusions_dose_feq_addition-0"></div></div><div class="col-md-6 form-group"><div class="col-md-4">Batch No</div><div class="col-md-8"><input type="text" name="other_infusions_batch_no" class="form-control" id="other_infusions_batch_no-0"></div></div>' + glucoseFields + '<div class="col-md-6 form-group"><div class="col-md-4">Prescribed By (Doctor)</div><div class="col-md-8"><select name="prescribed_by" class="full-width" id="prescribed_by-0">' + doctor_name_list + '</select></div></div><div class="col-md-6 form-group pres-date-align"><div class="col-md-4">Prescribed Date & Time</div><div class="col-md-8 display-flex"><input type="text" name="prescribed_date" class="form-control prescribed-date mr-10" id="drug-prescribed-date-0" readonly /><select name="prescribed_hours" class="form-control mr-10 input-width-small hours">' + hour_opt + '</select><select name="prescribed_mins" class="form-control mr-10 input-width-small minutes">' + mins_opt + '</select><select name="prescribed_session" class="form-control input-width-small session">' + session_opt + '</select></div></div><div class="col-md-6 form-group pres-date-align"><div class="col-md-4">Start Date & Time</div><div class="col-md-8 display-flex"><input type="text" name="start_date" class="form-control start-date mr-10" id="start-date-0" readonly /><select name="start_hours" class="form-control mr-10 input-width-small hours">' + hour_opt + '</select><select name="start_mins" class="form-control mr-10 input-width-small minutes">' + mins_opt + '</select><select name="start_session" class="form-control input-width-small session">' + session_opt + '</select></div></div>');
                if ((user_role == super_admin_role || user_role == admin_role) && doctor_id != '') {
                    $("#prescribed_by-0").select2().val(doctor_id).trigger('change');
                } else {
                    $("#prescribed_by-0").select2();
                }
                break;
            case 'ORAL':
                $('#drug_prepartion').after('<div class="col-md-12 prescription mt-5"><div class="col-md-6 form-group dose-required-field"><div class="col-md-4">Dose / Required</div><div class="col-md-8 display-flex"><input type="text" name="oral_dose_required" class="form-control" id="oral_dose_required-0" /><select name="drugs_dose_units" class="form-control input-width-small mr-15" id="drugs-dose-units-0">' + dose_list_oral + '</select><input type="text" name="oral_alt_dose_required" class="form-control" id="oral_alt_dose_required-0" /><select name="drugs_alt_dose_units" class="form-control input-width-small" id="drugs-alt-dose-units-0">' + dose_list_oral + '</select></div></div><div class="col-md-6 form-group"><div class="col-md-4">Frequency</div><div class="col-md-8"><select name="oral_frequency" class="oral-frequency full-width" id="oral_frequency-0">' + frequency_list + '</select></div></div><div class="col-md-6 form-group"><div class="col-md-4">Route</div><div class="col-md-8"><select name="oral_route" class="form-control" id="oral_route-0">' + route_list + '</select></div></div><div class="col-md-6 form-group"><div class="col-md-4">Additional Instruction</div><div class="col-md-8"><input type="text" name="oral_additional" class="form-control" id="oral_additional-0" /></div></div><div class="col-md-6 form-group"><div class="col-md-4">Prescribed By (Doctor)</div><div class="col-md-8"><select name="prescribed_by" class="full-width" id="prescribed_by-0">' + doctor_name_list + '</select></div></div><div class="col-md-6 form-group pres-date-align"><div class="col-md-4">Prescribed Date & Time</div><div class="col-md-8 display-flex"><input type="text" name="prescribed_date" class="form-control prescribed-date mr-10" id="drug-prescribed-date-0" readonly /><select name="prescribed_hours" class="form-control mr-10 input-width-small hours">' + hour_opt + '</select><select name="prescribed_mins" class="form-control mr-10 input-width-small minutes">' + mins_opt + '</select><select name="prescribed_session" class="form-control input-width-small session">' + session_opt + '</select></div></div><div class="col-md-6 form-group pres-date-align"><div class="col-md-4">Start Date</div><div class="col-md-8"><input type="text" name="start_date" class="form-control start-date" id="start-date-0" readonly /></div></div><div class="col-md-6 form-group pres-date-align"><div class="col-md-4">Review Date</div><div class="col-md-8"><input type="text" name="oral_review_date" class="form-control review-date" id="oral-review-date-0" readonly /></div></div><div class="col-md-12 form-group start-hour-entry"><div class="col-md-4">Starting hour</div><div class="col-md-8" style="display: flex; align-items: center; white-space: nowrap;"><input type="text" id="frequency_start_time" class="form-control input-width-mini" name="frequency_start_time" readonly style="display: inline-block;"><span class="frequency_start_time_num"></span><div class="hour-session"><label class="display-inline"><input type="radio" name="starthour" value="am" id="starthour-am" /><span>AM</span></label><label class="display-inline"><input type="radio" name="starthour" value="pm" id="starthour-pm" /><span>PM</span></label></div></div><label id="frequency_start_hour_error" style="display: none; color: red"></label><label id="frequency_start_time_error" style="display: none; color: red"></label></div><div class="col-md-12 form-group display-flex prescription-type"><div class="col-md-4">Prescription Type</div><div class="col-md-8"><div class="pump-session"><label class="display-inline"><input type="radio" name="prescription_type" value="1" id="regular" /><span></span></label><span>Regular</span><label class="display-inline"><input type="radio" name="prescription_type" value="2" id="required" /><span></span></label><span class="required-width">As Required (PRN or SOS)</span><label class="display-inline"><input type="radio" name="prescription_type" value="4" id="stat" /><span></span></label><span class="stat-width">STAT / Once Only</span></div></div></div>');
                if ((user_role == super_admin_role || user_role == admin_role) && doctor_id != '') {
                    $("#prescribed_by-0").select2().val(doctor_id).trigger('change');
                } else {
                    $("#prescribed_by-0").select2();
                }
                $("#oral_frequency-0").select2();
                $('#oral-review-date-0').datepicker({
                    dateFormat: 'dd-mm-yy',
                    changeMonth: true,
                    changeYear: true
                }).val(default_date);
                addDiaelPad(prescription_freq[0], prescription_freq[0], 'dial-pade-text-width', prescription_freq[1], prescription_freq[2], prescription_freq[3], prescription_freq[4]);
                addLeadingZero(prescription_freq[0]);
                $('input#required').prop('checked', true);
                break;
            default:
                break;
        }
        $('.prescribed-date').datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
        }).val(default_date);
        $('.hours').val(hours_12);
        $('.minutes').val(minutes);
        $('.session').val(ampm);
        $('.start-date').datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
        }).val(default_date);
    }

    function addLeadingZero(name) {
        $('input[name="' + name + '"]').change(function () {
            var itRateSecound = $(this).val();
            if (itRateSecound.indexOf('.') == 0) {
                $(this).val('0' + $(this).val());
            }
        });
    }

    function addDiaelPad(Selectorclass, InputName, inputboxClass, panelColor, ratioOption, totalBox, pluseMinus) {
        selector_class = Selectorclass;
        var ratioClass = (ratioOption) ? 'ratio-pad' : '';
        var dialPade = '<table class="daile-pade-box ' + ratioClass + '" data-source="' + Selectorclass + '">';
        dialPade += '<tbody>';
        dialPade += '<tr class="hole-number">';
        if (pluseMinus) {
            dialPade += '<td class="odd-parent-node un-bind"><span style="background:' + panelColor + ';" class="odd-server btn select-number-' + Selectorclass + ' save-button-shadow" data-value="+">+</span></td>';
            dialPade += '<td class="even-parent-node"><span class="even-server">-</span></td>';
            dialPade += '<td class="odd-parent-node un-bind"><span style="background:' + panelColor + ';" class="odd-server btn select-number-' + Selectorclass + ' save-button-shadow" data-value="-">-</span></td>';
            dialPade += '<td class="even-parent-node"><span class="even-server">-</span></td>';
        }
        for (var i = 1; i < 10; i++) {
            dialPade += '<td class="odd-parent-node un-bind"><span style="background:' + panelColor + ';" class="odd-server btn select-number-' + Selectorclass + ' save-button-shadow" data-value="' + i + '">' + i + '</span></td>';
            dialPade += '<td class="even-parent-node"><span class="even-server">-</span></td>';
        }
        dialPade += '<td class="odd-parent-node un-bind"><span style="background:' + panelColor + ';" class="odd-server btn select-number-' + Selectorclass + ' save-button-shadow" data-value="0">0</span></td>';
        dialPade += '<td class="even-parent-node"><span class="even-server">-</span></td>';
        dialPade += '<td class="dot-node un-bind"><span style="background:' + panelColor + ';" class="odd-server backspace-option btn save-button-shadow select-number-' + Selectorclass + '" data-value="<-"><i class="fa fa-arrow-left" aria-hidden="true"></i></span></td>';
        dialPade += '<td class="even-parent-node"><span class="even-server">-</span></td>';
        dialPade += '<td class="dot-node un-bind"><span style="background:' + panelColor + ';" class="odd-server delete-option btn save-button-shadow select-number-' + Selectorclass + '" data-value="<-"><i class="fa fa-times" aria-hidden="true"></i></span></td>';
        if (ratioOption) {
            dialPade += '<td class="even-parent-node"><span class="even-server">-</span></td>';
            dialPade += '<td class="dot-node un-bind"><span style="background:' + panelColor + ';" class="odd-server  ratio-option btn save-button-shadow select-number-' + Selectorclass + '" data-value=":">:</span></td>';
        }
        if (totalBox) {
            dialPade += '<td>&nbsp; &nbsp;</td>'
            dialPade += '<td><input style="border-color:' + panelColor + ';" class="form-control input-fields-shadow ' + inputboxClass + '"  name="' + InputName + '_total" id="' + InputName + '_total" style="margin-bottom:10px;" type="text"> </td>'
        }
        dialPade += '</tr>';
        dialPade += '</tbody>';
        dialPade += '</table>';
        $('.' + Selectorclass).html(dialPade);
    }
    $(document).on('click', '.select-number-frequency_start_time_num', function () {
        var Id = 'frequency_start_time';
        if ($(this).hasClass('dot-option')) {
            var value = $('#' + Id).val() + '.';
            $('#' + Id).val(value).trigger('change');
        } else if ($(this).hasClass('backspace-option')) {
            var value = $('#' + Id).val();
            value = value.substring(0, value.length - 1);
            $('#' + Id).val(value).trigger('change');
        } else if ($(this).hasClass('ratio-option')) {
            var value = $('#' + Id).val() + ':';
            $('#' + Id).val(value).trigger('change');
        } else if ($(this).hasClass('delete-option')) {
            $('#' + Id).val('').trigger('change');
        } else {
            var value = $('#' + Id).val() + $(this).attr('data-value');
            $('#' + Id).val(value).trigger('change');
        }
        if ($('#frequency_start_time').val() > 12) {
            var value = $('#' + Id).val();
            value = value.substring(0, value.length - 1);
            $('#' + Id).val(value).trigger('change');
        }
    });
    $(document).on('click', '#pres-set-default', function () {
        var brandname = $('select[name="brandname"]').val();
        var infusion_type_id = brandname.split(':');
        var id = 0;
        setDefaultValue(id, infusion_type_id[1], infusion_type_id[0]);
    });

    function setDefaultValue(id, drugid, type) {
        if (typeof drugid !== 'undefined') {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "GET",
                data: {
                    drugid: drugid,
                    type: type
                },
                url: site_url + '/prescription-default-value-fetch',
                success: function (response) {
                    if (response.messageType == 'success') {
                        var result = response.result;
                        switch (result.type) {
                            case 'IVDI':
                                if (result.dose != '' && result.dose != null) {
                                    var dose = result.dose;
                                    if (dose > 0) {
                                        $('#infusion_dose-' + id).val(dose);
                                    }
                                }
                                if (result.dose_range != '' && result.dose_range != null) {
                                    var dose_range = result.dose_range;
                                    if (dose > 0) {
                                        $('#infusion-dose-units-g-' + id).val(dose_range);
                                    }
                                }
                                if (result.dose_units != '' && result.dose_units != null) {
                                    var dose_units = result.dose_units;
                                    if (dose > 0) {
                                        $('#infusion-dose-units-kg-' + id).val(dose_units);
                                    }
                                }
                                if (result.dose_duration != '' && result.dose_duration != null) {
                                    var dose_duration = result.dose_duration;
                                    if (dose > 0) {
                                        $('#infusion-dose-units-time-' + id).val(dose_duration);
                                    }
                                }
                                if (result.quantity != '' && result.quantity != null) {
                                    var quantity = result.quantity;
                                    if (quantity > 0) {
                                        $('#infusion-quantity-' + id).val(quantity);
                                    }
                                }
                                if (result.quantity_units != '' && result.quantity_units != null) {
                                    var quantity_units = result.quantity_units;
                                    if (quantity > 0) {
                                        $('#quantity-units-' + id).val(quantity_units);
                                    }
                                }
                                if (result.syringe_size != '' && result.syringe_size != null) {
                                    var syringe_size = result.syringe_size;
                                    $('#infusion-syringe-' + id).val(syringe_size);
                                }
                                if (result.rate != '' && result.rate != null) {
                                    var rate = result.rate;
                                    if (rate > 0) {
                                        $('#infusion-rate-' + id).val(rate);
                                    }
                                }
                                if (result.instruction != '' && result.instruction != null) {
                                    var instruction = result.instruction;
                                    $('#infusion-instruction-' + id).val(instruction);
                                }
                                if (result.added_drug != '' && result.added_drug != null) {
                                    var added_drug = result.added_drug;
                                    $('#infusion_drug_added-' + id).val(added_drug);
                                }
                                if (result.added_dose != '' && result.added_dose != null) {
                                    var added_dose = result.added_dose;
                                    $('#infusion_feq_addition-' + id).val(added_dose);
                                }
                                if (result.glucose_infusion_rate != '' && result.glucose_infusion_rate != null) {
                                    $('#glucose_infusion_rate-' + id).val(result.glucose_infusion_rate);
                                }
                                if (result.glucose_concentration != '' && result.glucose_concentration != null) {
                                    $('#glucose_concentration-' + id).val(result.glucose_concentration);
                                }
                                break;
                            case 'OIVD':
                                if (result.dose != '' && result.dose != null) {
                                    var dose = result.dose;
                                    if (dose > 0) {
                                        $('#other_iv_drugs_dose_required-' + id).val(dose);
                                    }
                                }
                                if (result.dose_range != '' && result.dose_range != null) {
                                    var dose_range = result.dose_range;
                                    if (dose > 0) {
                                        $('#drugs-dose-units-' + id).val(dose_range);
                                    }
                                }
                                if (result.dose_alt != '' && result.dose_alt != null) {
                                    var dose_alt = result.dose_alt;
                                    if (dose_alt > 0) {
                                        $('#other_iv_drugs_alt_dose-' + id).val(dose_alt);
                                    }
                                }
                                if (result.dose_alt_range != '' && result.dose_alt_range != null) {
                                    var dose_alt_range = result.dose_alt_range;
                                    if (dose_alt > 0) {
                                        $('#drugs-alt-dose-units-' + id).val(dose_alt_range);
                                    }
                                }
                                if (result.frequency != '' && result.frequency != null) {
                                    var frequency = result.frequency;
                                    if (typeof frequency != 'undefined' && frequency != null) {
                                        $('#other-iv-drugs-frequency-' + id).val(frequency).trigger('change');
                                    }
                                }
                                if (result.syringe_size != '' && result.syringe_size != null) {
                                    var syringe_size = result.syringe_size;
                                    $('#other_iv_drugs_syringe-' + id).val(syringe_size);
                                }
                                if (result.rate != '' && result.rate != null) {
                                    var rate = result.rate;
                                    if (rate > 0) {
                                        $('#other_iv_drugs_rate-' + id).val(rate);
                                    }
                                }
                                if (result.instruction != '' && result.instruction != null) {
                                    var instruction = result.instruction;
                                    $('#other_iv_drugs_additional-' + id).val(instruction);
                                }
                                break;
                            case 'OIVI':
                                if (result.syringe_size != '' && result.syringe_size != null) {
                                    var syringe_size = result.syringe_size;
                                    if (syringe_size > 0) {
                                        $('#other_infusions_volume-' + id).val(syringe_size);
                                    }
                                }
                                if (result.rate != '' && result.rate != null) {
                                    var rate = result.rate;
                                    if (rate > 0) {
                                        $('#other_infusions_rate-' + id).val(rate).trigger('change');
                                    }
                                }
                                if (result.route != '' && result.route != null) {
                                    var route = result.route;
                                    $('#other_infusions_pump_type-' + route).prop('checked', true);
                                }
                                if (result.instruction != '' && result.instruction != null) {
                                    var instruction = result.instruction;
                                    $('#other_infusions_instruction-' + id).val(instruction);
                                }
                                if (result.added_drug != '' && result.added_drug != null) {
                                    var added_drug = result.added_drug;
                                    $('#other_infusions_drug_added-' + id).val(added_drug);
                                }
                                if (result.added_dose != '' && result.added_dose != null) {
                                    var added_dose = result.added_dose;
                                    $('#other_infusions_dose_feq_addition-' + id).val(added_dose);
                                }
                                break;
                            case 'ORAL':
                                if (result.dose != '' && result.dose != null) {
                                    var dose = result.dose;
                                    if (dose > 0) {
                                        $('#oral_dose_required-' + id).val(dose);
                                    }
                                }
                                if (result.dose_range != '' && result.dose_range != null) {
                                    var dose_range = result.dose_range;
                                    if (dose > 0) {
                                        $('#drugs-dose-units-' + id).val(dose_range);
                                    }
                                }
                                if (result.dose_alt != '' && result.dose_alt != null) {
                                    var dose_alt = result.dose_alt;
                                    if (dose_alt > 0) {
                                        $('#oral_alt_dose_required-' + id).val(dose_alt);
                                    }
                                }
                                if (result.dose_alt_range != '' && result.dose_alt_range != null) {
                                    var dose_alt_range = result.dose_alt_range;
                                    if (dose_alt > 0) {
                                        $('#drugs-alt-dose-units-' + id).val(dose_alt_range);
                                    }
                                }
                                if (result.frequency != '' && result.frequency != null) {
                                    var frequency = result.frequency;
                                    if (typeof frequency != 'undefined' && frequency != null) {
                                        $('#oral_frequency-' + id).val(frequency).trigger('change');
                                    }
                                }
                                if (result.route != '' && result.route != null) {
                                    var route = result.route;
                                    $('#oral_route-' + id).val(route);
                                }
                                if (result.instruction != '' && result.instruction != null) {
                                    var instruction = result.instruction;
                                    $('#oral_additional-' + id).val(instruction);
                                }
                                break;
                        }
                    }
                }
            });
            $('.infusion_dose_units_kg #pills-1').addClass('active');
        }
    }
    $(document).on('click', '#pres-clear', function () {
        var brandname = $('select[name="brandname"]').val();
        $('#prescription-post').trigger('reset');
        $('select[name="brandname"]').val(brandname);
        $('#other-iv-drugs-frequency-0').val($('#other-iv-drugs-frequency-0 option:first-child').val()).trigger('change');
        $('#oral_frequency-0').val($('#oral_frequency-0 option:first-child').val()).trigger('change');
        var date = new Date();
        var default_date = dateFormatter(date) + '-' + monthFormatter(date) + '-' + date.getFullYear();
        var hours_12 = hourFormatter(date);
        var minutes = minuteFormatter(date);
        var ampm = sessionFormatter(date);
        $('.prescribed-date').datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
        }).val(default_date);
        $('.hours').val(hours_12);
        $('.minutes').val(minutes);
        $('.session').val(ampm);
        $('.start-date').datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
        }).val(default_date);
    });
    $(document).on('change', 'input[name="other_infusions_volume"], input[name="other_infusions_rate"]', function () {
        var volumeToinfusion = $('input[name="other_infusions_volume"]').val();
        var infusionRate = $('input[name="other_infusions_rate"]').val();
        var duration = volumeToinfusion / infusionRate;
        if (duration != 'Infinity') {
            if (duration >= 1) {
                $('input[name="other_infusions_duration"]').val(parseFloat(duration).toFixed(1));
                $('select[name="other_infusions_durametnod"]').val('hr');
            } else {
                $('input[name="other_infusions_duration"]').val(parseFloat(duration * 60).toFixed(1));
                $('select[name="other_infusions_durametnod"]').val('min');
            }
        }
    });
    $(document).on('click', '#prescription-save-btn', function (e) {
        e.preventDefault();
        $('#prescription-save-btn').attr('disabled', true);
        $('#infusion_dose_error, #infusion_quantity_error, #infusion_rate_error, #other_iv_drugs_dose_error, #other_iv_drugs_syringe_error, #other_iv_drugs_rate_error, #other_infusions_volume_error, #other_infusions_rate_error, #frequency_start_hour_error, #frequency_start_time_error, #glucose_infusion_rate_error, #glucose_concentration_error').css({
            'display': 'none',
            'padding-left': 'unset'
        });
        var brandtype = $("#drug_names").val().split(":")[0];
        switch (brandtype) {
            case "IVDI":
                if ($("#infusion_dose-0").val() == '') {
                    $('#infusion_dose_error').css({
                        'display': 'block',
                        'padding-left': '15px'
                    }).html('Dose field is required !');
                    $(this).attr('disabled', false);
                    return false;
                }
                if ($("#infusion-quantity-0").val() == '') {
                    $('#infusion_quantity_error').css({
                        'display': 'block',
                        'padding-left': '15px'
                    }).html('Quantity field is required !');
                    $(this).attr('disabled', false);
                    return false;
                }
                if ($("#infusion-rate-0").val() == '') {
                    $('#infusion_rate_error').css({
                        'display': 'block',
                        'padding-left': '15px'
                    }).html('Rate field is required !');
                    $(this).attr('disabled', false);
                    return false;
                }
                if ($('#glucose_infusion_rate-0').length > 0 && $('#glucose_infusion_rate-0').val() == '') {
                    $('#glucose_infusion_rate_error').css({
                        'display': 'block',
                        'padding-left': '15px'
                    }).html('Glucose Infusion Rate is required');
                    $(this).attr('disabled', false);
                    return false;
                }
                if ($('#glucose_concentration-0').length > 0 && $('#glucose_concentration-0').val() == '') {
                    $('#glucose_concentration_error').css({
                        'display': 'block',
                        'padding-left': '15px'
                    }).html('Glucose Concentration is required');
                    $(this).attr('disabled', false);
                    return false;
                }
                break;
            case "OIVD":
                if ($("#other_iv_drugs_dose_required-0").val() == '') {
                    $('#other_iv_drugs_dose_error').css({
                        'display': 'block',
                        'padding-left': '15px'
                    }).html('Dose field is required !');
                    $(this).attr('disabled', false);
                    return false;
                }
                if ($("#other_iv_drugs_syringe-0").val() == '') {
                    $('#other_iv_drugs_syringe_error').css({
                        'display': 'block',
                        'padding-left': '15px'
                    }).html('Volume field is required !');
                    $(this).attr('disabled', false);
                    return false;
                }
                if ($("#other_iv_drugs_rate-0").val() == '') {
                    $('#other_iv_drugs_rate_error').css({
                        'display': 'block',
                        'padding-left': '15px'
                    }).html('Rate field is required !');
                    $(this).attr('disabled', false);
                    return false;
                }
                if ($("#prescription-post input[name='frequency_start_time']").val() == '') {
                    $('#frequency_start_hour_error').css({
                        'display': 'block',
                        'padding-left': '15px'
                    }).html('Starting hour field is required !');
                    $(this).attr('disabled', false);
                    return false;
                }
                if (!$('input#starthour-am').prop('checked') && !$('input#starthour-pm').prop('checked')) {
                    $('#frequency_start_time_error').css({
                        'display': 'block',
                        'padding-left': '15px'
                    }).html('Starting Session field is required !');
                    $(this).attr('disabled', false);
                    return false;
                }
                break;
            case "OIVI":
                if ($("#other_infusions_volume-0").val() == '') {
                    $('#other_infusions_volume_error').css({
                        'display': 'block',
                        'padding-left': '15px'
                    }).html('Volume field is required !');
                    $(this).attr('disabled', false);
                    return false;
                }
                if ($("#other_infusions_rate-0").val() == '') {
                    $('#other_infusions_rate_error').css({
                        'display': 'block',
                        'padding-left': '15px'
                    }).html('Rate field is required !');
                    $(this).attr('disabled', false);
                    return false;
                }
                if ($('#glucose_infusion_rate-0').length > 0 && $('#glucose_infusion_rate-0').val() == '') {
                    $('#glucose_infusion_rate_error').css({
                        'display': 'block',
                        'padding-left': '15px'
                    }).html('Glucose Infusion Rate is required');
                    $(this).attr('disabled', false);
                    return false;
                }
                if ($('#glucose_concentration-0').length > 0 && $('#glucose_concentration-0').val() == '') {
                    $('#glucose_concentration_error').css({
                        'display': 'block',
                        'padding-left': '15px'
                    }).html('Glucose Concentration is required');
                    $(this).attr('disabled', false);
                    return false;
                }
                break;
            case "ORAL":
                if ($("#prescription-post input[name='frequency_start_time']").val() == '') {
                    $('#frequency_start_hour_error').css({
                        'display': 'block',
                        'padding-left': '15px'
                    }).html('Starting hour field is required !');
                    $(this).attr('disabled', false);
                    return false;
                }
                if (!$('input#starthour-am').prop('checked') && !$('input#starthour-pm').prop('checked')) {
                    $('#frequency_start_time_error').css({
                        'display': 'block',
                        'padding-left': '15px'
                    }).html('Starting Session field is required !');
                    $(this).attr('disabled', false);
                    return false;
                }
                break;
        }
        $('#prescription-save-btn').attr('disabled', true);
        var serial = $($("#prescription-post")[0].elements).serializeArray();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            data: serial,
            url: site_url + '/prescription',
            success: function (response) {
                if (response.messageType == 'success') {
                    updatePrescriptionBlock(response.data);
                    closeModal('create-drug-modal');
                    var tab_type = response.data.prescription_type;
                    $('#prescription-data-list .tabbable ul li').removeClass('active');
                    $('#prescription-data-list #prescription-tab .tab-pane').removeClass('active');
                    switch (tab_type) {
                        case 1:
                            $('a[href="#regulardrug"]').parent().addClass('active');
                            $('#regulardrug').addClass('active');
                            break;
                        case 2:
                            $('a[href="#requireddrug"]').parent().addClass('active');
                            $('#requireddrug').addClass('active');
                            break;
                        case 3:
                            $('a[href="#intravenous"]').parent().addClass('active');
                            $('#intravenous').addClass('active');
                            break;
                        case 4:
                            $('a[href="#statdrug"]').parent().addClass('active');
                            $('#statdrug').addClass('active');
                            break;
                    }
                }
                Showalert(response.messageType, response.message);
            }
        });
    });
    $(document).on('click', '.create-prescription', function () {
        var hdr_id = $(this).parents('tbody').attr('id');
        hdr_id = hdr_id.replace(/[a-zA-z-]/g, '');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            data: {
                hdr_id: hdr_id
            },
            url: site_url + '/prescription-edit',
            success: function (response) {
                if (response.messageType == 'success') {
                    openModal('create-drug-modal');
                    $('#prescription-save-btn').attr('disabled', false);
                    $('#prescription-update-btn').attr('disabled', false);
                    $('#create-drug-modal').find('.modal-footer button').attr('id', 'prescription-save-btn').html('Save');
                    prescription_default_set = false;
                    var hdr = response.result_hdr;
                    var dtl = response.result_dtl;
                    var patt1 = /[0-9]/g;
                    var type = dtl.prescription_id;
                    type = type.replace(patt1, '');
                    $('input[name="id"]').val(type, hdr_id);
                    setFieldValues(type, hdr);
                    var date = new Date();
                    var default_date = dateFormatter(date) + '-' + monthFormatter(date) + '-' + date.getFullYear();
                    var hours_12 = hourFormatter(date, false);
                    var minutes = minuteFormatter(date, false);
                    var ampm = sessionFormatter(date);
                    var start_session = (date.getHours() > 12) ? 'pm' : 'am';
                    $('.prescribed-date').datepicker({
                        dateFormat: 'dd-mm-yy',
                        changeMonth: true,
                        changeYear: true,
                    }).val(default_date);
                    $('select[name="prescribed_hours"]').val(hours_12);
                    $('select[name="prescribed_mins"]').val(minutes);
                    $('select[name="prescribed_session"]').val(ampm);
                    $('.start-date').datepicker({
                        dateFormat: 'dd-mm-yy',
                        changeMonth: true,
                        changeYear: true,
                    }).val(default_date);
                    $('select[name="start_hours"]').val(hours_12);
                    $('select[name="start_mins"]').val(minutes);
                    $('select[name="start_session"]').val(ampm);
                    $('input#oral-start-datestart_date-0').datepicker({
                        dateFormat: 'dd-mm-yy',
                        changeMonth: true,
                        changeYear: true,
                    }).val(default_date);
                    $('.review-date').datepicker({
                        dateFormat: 'dd-mm-yy',
                        changeMonth: true,
                        changeYear: true,
                    }).val(default_date);
                    $('input#oral-review-date-0').datepicker({
                        dateFormat: 'dd-mm-yy',
                        changeMonth: true,
                        changeYear: true,
                    }).val(default_date);
                    $('input#frequency_start_time').val(hours_12);
                    $('input#starthour-' + start_session).prop('checked', true);
                }
            }
        });
    });
    $(document).on('click', '.edit-prescription', function () {
        var hdr_id = $(this).parents('tbody.prescription-border-top').attr('id');
        hdr_id = hdr_id.replace(/[a-zA-z-]/g, '');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            data: {
                hdr_id: hdr_id
            },
            url: site_url + '/prescription-edit',
            success: function (response) {
                if (response.messageType == 'success') {
                    openModal('create-drug-modal');
                    $('#prescription-save-btn').attr('disabled', false);
                    $('#prescription-update-btn').attr('disabled', false);
                    $('#create-drug-modal').find('.modal-footer button').attr('id', 'prescription-update-btn').html('Update');
                    prescription_default_set = false;
                    var hdr = response.result_hdr;
                    var dtl = response.result_dtl;
                    var patt1 = /[0-9]/g;
                    var type = dtl.prescription_id;
                    type = type.replace(patt1, '');
                    $('input[name="id"]').val(hdr_id);
                    setFieldValues(type, hdr);
                    $('input[name="prescribed_date"]').attr('disabled', true);
                    $('input#oral-start-date-0').attr('disabled', true);
                    var prescription_date = (hdr.prescription_date).replace(/\s/, 'T');
                    var date = new Date(prescription_date);
                    var default_date = dateFormatter(date) + '-' + monthFormatter(date) + '-' + date.getFullYear();
                    var hours = hourFormatter(date, false);
                    var minutes = minuteFormatter(date, false);
                    var ampm = sessionFormatter(date);
                    $('.prescribed-date').datepicker({
                        dateFormat: 'dd-mm-yy',
                        changeMonth: true,
                        changeYear: true,
                    }).val(default_date);
                    $('select[name="prescribed_hours"]').val(hours).attr('disabled', true);
                    $('select[name="prescribed_mins"]').val(minutes).attr('disabled', true);
                    $('select[name="prescribed_session"]').val(ampm).attr('disabled', true);
                    var start_date = (hdr.start_date).replace(/\s/, 'T');
                    var date = new Date(start_date);
                    var start_date = dateFormatter(date) + '-' + monthFormatter(date) + '-' + date.getFullYear();
                    var hours = hourFormatter(date, false);
                    var minutes = minuteFormatter(date, false);
                    var ampm = sessionFormatter(date);
                    var start_session = (date.getHours() > 12) ? 'pm' : 'am';
                    $('#start-date-0').datepicker({
                        dateFormat: 'dd-mm-yy',
                        changeMonth: true,
                        changeYear: true,
                        minDate: start_date
                    }).val(start_date);
                    $('#oral-start-date-0').datepicker({
                        dateFormat: 'dd-mm-yy',
                        changeMonth: true,
                        changeYear: true,
                        minDate: start_date
                    }).val(start_date);
                    $('select[name="start_hours"]').val(hours);
                    $('select[name="start_mins"]').val(minutes);
                    $('select[name="start_session"]').val(ampm);
                    if (hdr.review_date != null) {
                        var review_date = (hdr.review_date).replace(/\s/, 'T');
                        var date = new Date(review_date);
                        var review_date = dateFormatter(date) + '-' + monthFormatter(date) + '-' + date.getFullYear();
                        $('#drug-review-date-0').datepicker({
                            dateFormat: 'dd-mm-yy',
                            changeMonth: true,
                            changeYear: true,
                            minDate: review_date
                        }).val(review_date);
                        $('#oral-review-date-0').datepicker({
                            dateFormat: 'dd-mm-yy',
                            changeMonth: true,
                            changeYear: true,
                            minDate: review_date
                        }).val(review_date);
                    }
                    $('input#frequency_start_time').val(hours);
                    $('input#starthour-' + start_session).prop('checked', true);
                    var old_prescription_type = $('input[name="prescription_type"]:checked').val();
                    $('.added_info').remove();
                    var old_data = '<div class="added_info"><input type="hidden" name="pres_id" value="' + hdr_id + '" /><input type="hidden" name="frequency_old" id="frequency_old" value="' + hdr.frequency + '" /><input type="hidden" name="start_date_old" id="start_date_old" value="' + start_date + '" /><input type="hidden" name="start_hours_old" id="start_hours_old" value="' + hours + '" /><input type="hidden" name="start_session_old" id="start_session_old" value="' + start_session + '" /><input type="hidden" name="review_date_old" id="review_date_old" value="' + review_date + '" /><input type="hidden" name="old_prescription_type" value="' + old_prescription_type + '" /></div>';
                    $('#create-drug-modal #prescription-post').append(old_data);
                }
            }
        });
        $('input[name="pres_id"]').remove();
    });
    $(document).on('click', '#prescription-update-btn', function () {
        $('#prescription-update-btn').attr('disabled', true);
        var pres_id = $('input[name="pres_id"]').val();
        var old_prescription_type = $('input[name="old_prescription_type"]').val();
        var serial = $($("#prescription-post")[0].elements).serializeArray();
        var added_content1 = {
            'name': 'old_prescription_type',
            'value': old_prescription_type
        };
        serial.push(added_content1);
        var edit_modal_id = {
            'name': 'edit_modal_id',
            'value': $('#create-drug-modal input[name="pres_id"]').val()
        };
        serial.push(edit_modal_id);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'PATCH',
            data: serial,
            url: site_url + '/prescription/' + pres_id,
            async: true,
            success: function (response) {
                if (response.messageType == 'success') {
                    updatePrescriptionBlock(response.data);
                }
                closeModal('create-drug-modal');
                Showalert(response.messageType, response.message);
            }
        });
    });

    function setFieldValues(type, hdr) {
        $('#drug_names').val(type + ':' + hdr.brand_name).trigger('change').attr('disabled', true);
        $('#pharmacological-name-0').val(type + ':' + hdr.brand_name).trigger('change').attr('disabled', true);
        var dose = hdr.dose == 0 ? '' : hdr.dose;
        var quantity = hdr.quantity == 0 ? '' : hdr.quantity;
        var rate = hdr.rate == 0 ? '' : hdr.rate;
        $('#infusion_dose-0').val(dose);
        $('#infusion-dose-units-g-0').removeAttr('selected');
        $('#infusion-dose-units-g-0 option[value="' + hdr.dose_units_g + '"]').prop("selected", true);
        $('#infusion-dose-units-kg-0').removeAttr('selected');
        $('#infusion-dose-units-kg-0 option[value="' + hdr.dose_units_kg + '"]').prop("selected", true);
        $('#infusion-dose-units-time-0').removeAttr('selected');
        $('#infusion-dose-units-time-0 option[value="' + hdr.dose_units_time + '"]').prop("selected", true);
        $('#infusion-quantity-0').val(quantity);
        $('#quantity-units-0').removeAttr('selected');
        $('#quantity-units-0 option[value="' + hdr.quantity_units + '"]').prop("selected", true);
        $('#infusion-syringe-0').removeAttr('selected');
        $('#infusion-syringe-0 option[value="' + hdr.syringe_size + '"]').prop("selected", true);
        $('#infusion-rate-0').val(rate);
        $('#infusion-instruction-0').val(hdr.instruction);
        $('#infusion_drug_added-0').val(hdr.drug_added);
        $('#infusion_feq_addition-0').val(hdr.dose_feq_addition);
        $('#infusion_batch_no-0').val(hdr.batch_no);
        $('#prescribed_by-0').removeAttr('selected');
        $('#prescribed_by-0 option[value="' + hdr.prescribed_by + '"]').prop("selected", true);
        var dose = hdr.dose == 0 ? '' : hdr.dose;
        var alt_dose = hdr.alt_dose == 0 ? '' : hdr.alt_dose;
        var syringesize = hdr.syringe_size == 0 ? '' : hdr.syringe_size;
        var rate = hdr.rate == 0 ? '' : hdr.rate;
        $('#other_iv_drugs_dose_required-0').val(dose);
        $('#drugs-dose-units-0').removeAttr('selected');
        $('#drugs-dose-units-0 option[value="' + hdr.dose_units_g + '"]').prop("selected", true);
        $('#other_iv_drugs_alt_dose-0').val(alt_dose);
        $('#drugs-alt-dose-units-0').removeAttr('selected');
        $('#drugs-alt-dose-units-0 option[value="' + hdr.alt_dose_units_g + '"]').prop("selected", true);
        $('#other-iv-drugs-frequency-0').val(hdr.frequency).trigger('change');
        $('#other_iv_drugs_syringe-0').val(syringesize);
        $('#other_iv_drugs_rate-0').val(rate);
        $('#other_iv_drugs_additional-0').val(hdr.instruction);
        if (hdr.prescription_type == 1) {
            $('#regular').prop('checked', true);
        } else if (hdr.prescription_type == 2) {
            $('#required').prop('checked', true);
        } else {
            $('#stat').prop('checked', true);
        }
        var volume = hdr.volume == 0 ? '' : hdr.volume;
        var rate = hdr.rate == 0 ? '' : hdr.rate;
        var duration = hdr.duration == 0 ? '' : hdr.duration;
        $('#other_infusions_volume-0').val(volume);
        $('#other_infusions_rate-0').val(rate);
        $('#other_infusions_duration-0').val(duration);
        $('#other_infusions_durametnod-0').removeAttr('selected');
        $('#other_infusions_durametnod-0 option[value="' + hdr.duration_time + '"]').prop("selected", true);
        $('#other_infusions_pump_type-' + hdr.infusion_type).prop('checked', true);
        $('#other_infusions_instruction-0').val(hdr.instruction);
        $('#other_infusions_drug_added-0').val(hdr.drug_added);
        $('#other_infusions_dose_feq_addition-0').val(hdr.dose_feq_addition);
        $('#other_infusions_batch_no-0').val(hdr.batch_no);
        var dose = hdr.dose == 0 ? '' : hdr.dose;
        var alt_dose = hdr.alt_dose == 0 ? '' : hdr.alt_dose;
        $('#oral_dose_required-0').val(dose);
        $('#drugs-dose-units-0').val(hdr.dose_units_g).trigger('change');
        $('#oral_alt_dose_required-0').val(alt_dose);
        $('#drugs-alt-dose-units-0').removeAttr('selected');
        $('#drugs-alt-dose-units-0 option[value="' + hdr.alt_dose_units_g + '"]').prop("selected", true);
        $('#oral_frequency-0').val(hdr.frequency).trigger('change');
        $('#oral_additional-0').val(hdr.instruction);
        $('#oral_route-0').removeAttr('selected');
        $('#oral_route-0 option[value="' + hdr.oral_route + '"]').prop("selected", true);

        // For edit, we need to re-trigger the check for the selected drug to show/hide fields
        var selectedDrugOption = $('#drug_names option[value="' + (type + ':' + hdr.brand_name) + '"]');
        if (selectedDrugOption.length > 0) {
            var isGir = selectedDrugOption.data('is-gir');
            var isGc = selectedDrugOption.data('is-gc');
            // Re-render if fields are missing but required (though typical flow re-renders form on drug change)
            // However, setFieldValues is called after form html might be reset.
            // Ideally anotherfields logic handles structure, here we populate.
            // But wait, setFieldValues populates existing fields.
            // If we are in "Edit Prescription" (loading existing data), the form might not be built yet?
            // Actually anotherfields builds the form structure.
            // Let's just set the values.
            if ((isGir || isGc) && $('#glucose_infusion_rate-0').length == 0) {
                // If attributes say yes, but fields don't exist... reconstruction might be needed
                // But typically anotherfields is called when modal opens or drug selected.
                // Let's just set the values.
            }
        }

        $('#glucose_infusion_rate-0').val(hdr.glucose_infusion_rate);
        $('#glucose_concentration-0').val(hdr.glucose_concentration);
        var drugname = '<input type="hidden" name="brandname" class="add-drug" value="' + (type + ':' + hdr.brand_name) + '" /> <input type="hidden" name="pharmacological" class="add-drug" value="' + (type + ':' + hdr.brand_name) + '" />';
        $('#create-drug-modal #prescription-post').append(drugname);
    }
    // Date processing
    var fromdate = $('input[name="admission_date"]').val().split('-');
    if (fromdate.length > 1) {
        from_date = fromdate[2] + '-' + fromdate[1] + '-' + fromdate[0];
        fromdate = new Date(fromdate[0], (fromdate[1] - 1), fromdate[2]);
    } else {
        fromdate = new Date();
        fromdates = dateFormatter(fromdate);
        from_month = monthFormatter(fromdate);
        from_date = fromdates + '-' + from_month + '-' + fromdate.getFullYear();
    }
    if (typeof prescribed_date_list[0] == 'undefined') {
        var todate = new Date();
    } else {
        var todate = prescribed_date_list.split('-');
        todate = new Date(todate[2], (todate[0] - 1), todate[1]);
        var diff = new Date(todate - fromdate);
        var warning = diff / 1000 / 60 / 60 / 24;
        if (!(warning > 0)) {
            var todate = new Date(fromdate);
        }
    }
    todate.setDate(todate.getDate() + 17);
    date = dateFormatter(todate);
    month = monthFormatter(todate);
    year = todate.getFullYear();
    to_date = date + '-' + month + '-' + year;
    $('input[name="fromdate"]').datepicker({
        dateFormat: 'dd-mm-yy'
    }).val(from_date);
    $('input[name="todate"]').datepicker({
        dateFormat: 'dd-mm-yy'
    }).val(to_date);
    $('input[name="fromdateipad"]').datepicker({
        dateFormat: 'dd-mm-yy'
    }).val(from_date);
    $('input[name="todateipad"]').datepicker({
        dateFormat: 'dd-mm-yy'
    }).val(to_date);
    $('.prescription-print').attr('data-selected-date', from_date);
    var prescription_sheet_date = [];
    var pres_sheet_date = [];
    var hdr_date_list_type_1 = '';
    var hdr_date_list_type_2 = '';
    var yesterday = new Date();
    yesterday.setDate(yesterday.getDate() - 1);
    var yesterday_month = monthFormatter(yesterday);
    var yesterday_date = dateFormatter(yesterday);
    yesterday = yesterday_date + '/' + yesterday_month;
    dateChoosen(from_date, to_date);

    function monthFormatter(item) {
        var month = item.getMonth() + 1;
        return month > 9 ? month : '0' + month;
    }

    function dateFormatter(item) {
        var date = item.getDate();
        return date > 9 ? date : '0' + date;
    }

    function railwayHourFormatter(item, formatter = true) {
        var hour = item.getHours();
        if (!formatter) {
            return hour;
        }
        return hour > 9 ? hour : '0' + hour;
    }

    function hourFormatter(item, formatter = true) {
        var hour = item.getHours();
        if (!formatter) {
            return (hour > 12) ? (hour - 12) : (hour == 0 ? "12" : hour);
        }
        return (hour > 12) ? (hour - 12) : ((hour == 0) ? "12" : railwayHourFormatter(item));
    }

    function minuteFormatter(item, formatter = true) {
        var mins = item.getMinutes();
        if (!formatter) {
            return mins;
        }
        return mins > 9 ? mins : '0' + mins;
    }

    function sessionFormatter(item) {
        return (item.getHours() >= 12) ? "PM" : "AM";
    }

    function dbDateToJsDate(item) {
        var datetime = item.split('-');
        var year = datetime[0];
        var month = datetime[1] - 1;
        var date = datetime[2].split(' ');
        var hour = date[1].split(':')[0];
        var date = datetime[2].split(' ')[0];
        return new Date(year, month, date, hour);
    }
    $('input[name="fromdate"], input[name="todate"]').on('change', function () {
        fromdate = $('input[name="fromdate"]').val();
        todate = $('input[name="todate"]').val();
        $('input[name="fromdateipad"]').val(fromdate);
        $('input[name="todateipad"]').val(todate);
        dateChoosen(fromdate, todate);
    });
    $('input[name="fromdateipad"], input[name="todateipad"]').on('change', function () {
        fromdate = $('input[name="fromdateipad"]').val();
        todate = $('input[name="todateipad"]').val();
        $('input[name="fromdate"]').val(fromdate);
        $('input[name="todate"]').val(todate);
        dateChoosen(fromdate, todate);
    });

    function dateChoosen(fromdate, todate) {
        var currenttab = $('li.active a[role="tab"]').attr('href');
        $('.prescription-print').attr('data-selected-date', fromdate);
        fromdate = fromdate.split('-');
        var from_date = new Date(fromdate[2], (fromdate[1] - 1), fromdate[0]);
        fromdate = fromdate[1] + '-' + fromdate[0] + '-' + fromdate[2];
        todate = todate.split('-');
        var to_date = new Date(todate[2], (todate[1] - 1), todate[0]);
        todate = todate[1] + '-' + todate[0] + '-' + todate[2];
        $('.date-selection .error-message').remove();
        if (to_date > from_date) {
            dateFilter(from_date, to_date);
            wholeLayout();
            if (typeof currenttab != 'undefined') {
                $('li a[role="tab"]').parent().removeClass('active');
                $('.tab-pane').removeClass('active');
                $('li a[href="' + currenttab + '"]').parent().addClass('active');
                $(currenttab).addClass('active');
            }
        } else {
            $('.date-sub-div').after('<span class="error-message" style="display: inline-block; float: right;">To date must be greater than from date.</span>');
            $('.date-selection-error').html('<span class="error-message full-width" style="display: inline-block; float: right;">To date must be greater than from date.</span>');
        }
    }

    function dateFilter(fromdate, todate) {
        prescription_sheet_date = [];
        pres_sheet_date = [];
        var start = new Date(fromdate),
            end = new Date(todate),
            currentDate = start;
        var sheet_date = [];
        var sheet_date1 = [];
        while (currentDate <= end) {
            var date_list = currentDate;
            date = dateFormatter(date_list);
            month = monthFormatter(date_list);
            year = date_list.getFullYear();
            hours = railwayHourFormatter(date_list);
            minutes = minuteFormatter(date_list);
            date_list = date + '/' + month;
            date_list1 = month + '-' + date + '-' + year;
            prescription_sheet_date.push(date_list);
            pres_sheet_date.push(date_list1);
            currentDate.setDate(currentDate.getDate() + 1);
        }
        var date_list_type_1 = '';
        var time_list_type_1 = '';
        var date_list_type_2 = '<th class="prescription-border-left prescription-border-right"></th>';
        var time_list_type_2 = '<th class="prescription-border-left prescription-border-right"></th>';
        for (var j = 0; j < prescription_sheet_date.length; j++) {
            if (typeof prescription_sheet_date[j] === "undefined") {
                var strDate = '';
            } else {
                var strDate = prescription_sheet_date[j];
            }
            var scroll = yesterday == strDate ? 'cursor_position' : '';
            var date_list = '<th class="time-font ' + scroll + '" id="date-' + j + '"><b>' + strDate + '</b></th>';
            date_list_type_1 += date_list;
            date_list_type_2 += date_list;
            var time_list = '<th class="prescription-box"></th>';
            time_list_type_1 += time_list;
            time_list_type_2 += time_list;
        }
        var hdr_part_1 = '<thead>';
        hdr_part_1 += '<tr>';
        hdr_part_1 += '<th class="text-center time-font">';
        hdr_part_1 += '<b>S.No</b>';
        hdr_part_1 += '</th>';
        hdr_part_1 += '<th colspan="4">';
        hdr_part_1 += '<b>DATE AND MONTH</b>';
        hdr_part_1 += '</th>';
        hdr_part_1 += '<th class="prescription-border-left prescription-border-right"></th>';
        var hdr_part_2 = '</tr>';
        hdr_part_2 += '<tr>';
        hdr_part_2 += '<th class="time-font"></th>';
        hdr_part_2 += '<th colspan="4">';
        hdr_part_2 += '<b>TICK TIMES OR ENTER VARIABLE TIME</b>';
        hdr_part_2 += '</th>';
        hdr_part_2 += '<th class="prescription-border-left prescription-border-right"></th>';
        var hdr_part_3 = '</tr>';
        hdr_part_3 += '</thead>';
        hdr_date_list_type_1 = hdr_part_1;
        hdr_date_list_type_1 += date_list_type_1;
        hdr_date_list_type_1 += hdr_part_2;
        hdr_date_list_type_1 += time_list_type_1;
        hdr_date_list_type_1 += hdr_part_3;
        hdr_date_list_type_2 = hdr_part_1;
        hdr_date_list_type_2 += date_list_type_2;
        hdr_date_list_type_2 += hdr_part_2;
        hdr_date_list_type_2 += time_list_type_2;
        hdr_date_list_type_2 += hdr_part_3;
    }

    function wholeLayout() {
        var layout_of_Regular = '<div role="tabpanel" class="tab-pane active" id="regulardrug">' + tableLayoutOfRegular() + '</div>';
        var layout_of_Required = '<div role="tabpanel" class="tab-pane" id="requireddrug">' + tableLayoutOfRequired() + '</div>';
        var layout_of_Stat = '<div role="tabpanel" class="tab-pane" id="statdrug">' + tableLayoutOfStat() + '</div>';
        var layout_of_Intravenous = '<div role="tabpanel" class="tab-pane" id="intravenous">' + tableLayoutOfIntravenous() + '</div>';
        var whole_layout_list = '<ul class="nav nav-tabs" role="tablist">';
        whole_layout_list += '<li role="presentation" class="active"><a href="#regulardrug" role="tab" data-toggle="tab">Regular <span class="ipad-none">Prescriptions</span></a></li>';
        whole_layout_list += '<li role="presentation"><a href="#requireddrug" role="tab" data-toggle="tab">As Required <span class="ipad-none">Prescriptions</span> (PRN/SOS)</a></li>';
        whole_layout_list += '<li role="presentation"><a href="#statdrug" role="tab" data-toggle="tab">STAT / Once Only <span class="ipad-none">Prescriptions</span></a></li>';
        whole_layout_list += '<li role="presentation"><a href="#intravenous" role="tab" data-toggle="tab">Intravenous Infusion Therapy</a></li></ul>';
        var whole_layout_content = '<div class="tab-content tab-view-shadow" id="prescription-tab">' + layout_of_Regular + layout_of_Required + layout_of_Stat + layout_of_Intravenous + '</div>';
        var whole_layout = '<div role="tabpanel" class="tabbable tabbable-custom">' + whole_layout_list + whole_layout_content + '</div>';
        $('#prescription-data-list').html(whole_layout);
    }

    function tableLayoutOfRegular() {
        var whole_regular_list = typeof prescription_list[1] !== "undefined" ? prescription_list[1] : [];
        var regular_content = '<table class="table table-responsive">';
        regular_content += hdr_date_list_type_1;
        var non_terminate_list = typeof whole_regular_list[0] !== "undefined" ? whole_regular_list[0] : [];
        var terminate_list = typeof whole_regular_list[1] !== "undefined" ? whole_regular_list[1] : [];
        var non_terminate_content = '';
        var terminate_content = '';
        var empty_content = '';
        var sno = 1;
        var empty_block = true;
        for (var ntc = 0; ntc <= non_terminate_list.length; ntc++) {
            if (typeof non_terminate_list[ntc] != 'undefined') {
                var ntc_value = non_terminate_list[ntc];
                var regular_val = updateRegularPrescriptionList(ntc_value, sno);
                non_terminate_content += '<tbody id="regular-' + ntc_value.hdr_id + '" class="prescription-border-top" data-start-date="' + ntc_value.start_date + '" data-sno="' + sno + '">';
                non_terminate_content += regular_val;
                non_terminate_content += '</tbody>';
                sno++;
            }
        }
        for (var tc = 0; tc <= terminate_list.length; tc++) {
            if (typeof terminate_list[tc] != 'undefined') {
                var tc_value = terminate_list[tc];
                var regular_val = updateRegularPrescriptionList(tc_value, sno, true);
                terminate_content += '<tbody id="regular-' + tc_value.hdr_id + '" class="prescription-border-top terminate-prescription" data-start-date="' + tc_value.start_date + '" data-sno="' + sno + '">';
                terminate_content += regular_val;
                terminate_content += '</tbody>';
                sno++;
            }
        }
        if (empty_block && sno > regular_default_frame) {
            regular_default_frame = sno;
            empty_block = false;
        }
        if (sno <= regular_default_frame) {
            for (var e = sno; e <= regular_default_frame; e++) {
                var regular_val = updateRegularPrescriptionList([], sno);
                empty_content += '<tbody id="regular-' + sno + '" class="prescription-border-top" data-start-date="">';
                empty_content += regular_val;
                empty_content += '</tbody>';
                sno++;
            }
        }
        regular_content += non_terminate_content;
        regular_content += terminate_content;
        regular_content += empty_content;
        regular_content += '</table>';
        return regular_content;
    }

    function tableLayoutOfRequired() {
        var tab_name = 'required';
        var whole_required_list = typeof prescription_list[2] !== "undefined" ? prescription_list[2] : [];
        var non_terminate_list = typeof whole_required_list[0] !== "undefined" ? whole_required_list[0] : [];
        var terminate_list = typeof whole_required_list[1] !== "undefined" ? whole_required_list[1] : [];
        return requiredStatPrescription(non_terminate_list, terminate_list, tab_name);
    }

    function tableLayoutOfStat() {
        var tab_name = 'stat';
        var whole_required_list = typeof prescription_list[4] !== "undefined" ? prescription_list[4] : [];
        var non_terminate_list = typeof whole_required_list[0] !== "undefined" ? whole_required_list[0] : [];
        var terminate_list = typeof whole_required_list[1] !== "undefined" ? whole_required_list[1] : [];
        return requiredStatPrescription(non_terminate_list, terminate_list, tab_name);
    }

    function requiredStatPrescription(non_terminate_list, terminate_list, tab_name) {
        var required_content = '<table class="table table-responsive">';
        required_content += hdr_date_list_type_2;
        var non_terminate_content = '';
        var terminate_content = '';
        var empty_content = '';
        var sno = 1;
        var empty_block = true;
        for (var ntc = 0; ntc <= non_terminate_list.length; ntc++) {
            if (typeof non_terminate_list[ntc] != 'undefined') {
                var ntc_value = non_terminate_list[ntc];
                var required_val = updateRequiredStatPrescriptionList(ntc_value, sno);
                non_terminate_content += '<tbody id="' + tab_name + '-' + ntc_value.hdr_id + '" class="prescription-border-top" data-start-date="' + ntc_value.start_date + '" data-sno="' + sno + '">';
                non_terminate_content += required_val;
                non_terminate_content += '</tbody>';
                sno++;
            }
        }
        for (var tc = 0; tc <= terminate_list.length; tc++) {
            if (typeof terminate_list[tc] != 'undefined') {
                var tc_value = terminate_list[tc];
                var required_val = updateRequiredStatPrescriptionList(tc_value, sno, true);
                terminate_content += '<tbody id="' + tab_name + '-' + tc_value.hdr_id + '" class="prescription-border-top terminate-prescription" data-start-date="' + tc_value.start_date + '" data-sno="' + sno + '">';
                terminate_content += required_val;
                terminate_content += '</tbody>';
                sno++;
            }
        }
        if (empty_block && sno > required_stat_default_frame) {
            required_stat_default_frame = sno;
            empty_block = false;
        }
        if (sno <= required_stat_default_frame) {
            for (var e = sno; e <= required_stat_default_frame; e++) {
                var required_val = updateRequiredStatPrescriptionList([], sno);
                empty_content += '<tbody id="' + tab_name + '-' + sno + '" class="prescription-border-top" data-start-date="">';
                empty_content += required_val;
                empty_content += '</tbody>';
                sno++;
            }
        }
        required_content += non_terminate_content;
        required_content += terminate_content;
        required_content += empty_content;
        required_content += '</table>';
        return required_content;
    }

    function tableLayoutOfIntravenous() {
        var whole_intravenous_list = typeof intravenous_prescription_list !== "undefined" ? intravenous_prescription_list : [];
        var intravenous_content = '<table class="table table-responsive">';
        intravenous_content += '<thead>';
        intravenous_content += '<tr class="intravenous-list prescription-border-bottom">';
        intravenous_content += '<th class="text-center serial-no time-font"><b>S.No</th>';
        intravenous_content += '<th class="text-center date-fluid"><b>Date</b></th>';
        intravenous_content += '<th class="text-center time-fluid"><b>Time</b></th>';
        intravenous_content += '<th class="text-center"><b>Intravenous<br/>Fluid / Drug Name</b></th>';
        intravenous_content += '<th class="text-center"><b>Volume</b></th>';
        intravenous_content += '<th class="text-center"><b>Drug<br/>Added</b></th>';
        intravenous_content += '<th class="text-center"><b>Dose Of Main Drug</b></th>';
        intravenous_content += '<th class="text-center"><b>Rate (ml/hr)</b></th>';
        intravenous_content += '<th class="text-center"><b>Running<br/>Duration</b></th>';
        intravenous_content += '<th class="text-center"><b>Doctor\'s<br/>Initials</b></th>';
        intravenous_content += '<th class="text-center"><b>Batch<br/>Number</b></th>';
        intravenous_content += '<th class="text-center"><b>Status</b></th>';
        intravenous_content += '</tr>';
        intravenous_content += '</thead>';
        var sno = 1;
        var empty_block = true;
        for (var i = 0; i < whole_intravenous_list.length; i++) {
            if (typeof whole_intravenous_list[i] != 'undefined') {
                var intravenous_value = whole_intravenous_list[i];
                var intravenous_val = updateIntravenousPrescriptionList(intravenous_value, sno);
                intravenous_content += '<tbody id="intravenous-' + intravenous_value.pres_hdr_id + '" class="prescription-border-top" data-sno="' + sno + '">';
                intravenous_content += intravenous_val;
                intravenous_content += '</tbody>';
                sno++;
            }
        }
        if (empty_block && sno > intravenous_default_frame) {
            intravenous_default_frame = sno;
            empty_block = false;
        }
        if (sno <= intravenous_default_frame) {
            for (var e = sno; e <= intravenous_default_frame; e++) {
                var intravenous_value = whole_intravenous_list[i];
                var intravenous_val = updateIntravenousPrescriptionList([], sno);
                intravenous_content += '<tbody id="intravenous-' + sno + '" class="prescription-border-top">';
                intravenous_content += intravenous_val;
                intravenous_content += '</tbody>';
                sno++;
            }
        }
        intravenous_content += '</table></div>';
        return intravenous_content;
    }

    function updateRegularPrescriptionList(regular_value, sno = '', terminate_slug = false) {
        var prescription_sheet_date = pres_sheet_date;
        var pres_detail = regular_value.pres_dtl;
        var active_id = regular_value.active_id;
        var eventtime = typeof regular_value.events_hour != 'undefined' ? regular_value.events_hour : [];
        var regular_data = prescriptionDataCollection(regular_value);
        var id = regular_data.id;
        var drug_name = regular_data.drug_name;
        var dose = regular_data.dose;
        var creamicon = regular_data.creamicon;
        var infusion_type = regular_data.infusion_type;
        var start_date = regular_data.start_date;
        var start_time = regular_data.start_time;
        var review_warning = regular_data.review_warning;
        var review_date = regular_data.review_date;
        var created_user = regular_data.created_user;
        var prescription_date = regular_data.prescription_date;
        var instruction = regular_data.instruction;
        var frequency = regular_data.frequency;
        var drug_start_date = regular_data.drug_start_date;
        var terminate = regular_data.terminate;
        var event_time = [];
        var status_basic = '';
        if (eventtime.length > 0) {
            var regular_info1, regular_info2, regular_info3, regular_info4, regular_info5, regular_info6 = '';
            for (var i = 0; i < 6; i++) {
                var empty_cell_info = eventContent();
                var pres_value = prescriptionTime(eventtime, i);
                var regular_info = formatPrescriptionTime(pres_value);
                for (var j = 0; j < prescription_sheet_date.length; j++) {
                    var action_content = actionBlock(id, j, pres_detail, prescription_sheet_date[j], terminate, pres_value, drug_start_date, active_id, terminate_slug);
                    regular_info += action_content.info_block;
                    empty_cell_info += action_content.empty_cell_info;
                    if (status_basic == '') {
                        status_basic = action_content.status_basic;
                    }
                }
                if (jQuery.inArray(pres_value, event_time_row_1) !== -1) {
                    regular_info1 = regular_info;
                }
                if (jQuery.inArray(pres_value, event_time_row_2) !== -1) {
                    regular_info2 = regular_info;
                }
                if (jQuery.inArray(pres_value, event_time_row_3) !== -1) {
                    regular_info3 = regular_info;
                }
                if (jQuery.inArray(pres_value, event_time_row_4) !== -1) {
                    regular_info4 = regular_info;
                }
                if (jQuery.inArray(pres_value, event_time_row_5) !== -1) {
                    regular_info5 = regular_info;
                }
                if (jQuery.inArray(pres_value, event_time_row_6) !== -1) {
                    regular_info6 = regular_info;
                }
            }
            if (typeof user_role != 'undefined' && (user_role == super_admin_role || user_role == admin_role)) {
                if (status_basic || terminate_slug) {
                    var moreoption = menu();
                } else {
                    var moreoption = menus();
                }
            }
            var regular_block = '<tr>';
            regular_block += regularRow1(id, sno, moreoption, drug_name);
            regular_block += (regular_info1 != '' && typeof regular_info1 != 'undefined') ? regular_info1 : empty_cell_info;
            regular_block += '</tr>';
            regular_block += '<tr>';
            regular_block += regularRow2(id, sno, dose, creamicon, infusion_type, start_date, start_time, review_warning, review_date);
            regular_block += (regular_info2 != '' && typeof regular_info2 != 'undefined') ? regular_info2 : empty_cell_info;
            regular_block += '</tr>';
            var username = '';
            if (created_user != '' && user_sign[created_user] != null) {
                var usersign = createdBy(user_sign[created_user]);
                username = user_name[created_user];
            } else {
                var usersign = alt_img;
            }
            regular_block += '<tr>';
            regular_block += regularRow3(id, usersign, prescription_date, terminate, username);
            regular_block += (regular_info3 != '' && typeof regular_info3 != 'undefined') ? regular_info3 : empty_cell_info;
            regular_block += '</tr>';
            regular_block += '<tr>';
            regular_block += regularRow4(instruction, frequency);
            regular_block += (regular_info4 != '' && typeof regular_info4 != 'undefined') ? regular_info4 : empty_cell_info;
            regular_block += '</tr>';
            regular_block += '<tr>' + ((regular_info5 != '' && typeof regular_info5 != 'undefined') ? regular_info5 : empty_cell_info) + '</tr>';
            regular_block += '<tr>' + ((regular_info6 != '' && typeof regular_info6 != 'undefined') ? regular_info6 : empty_cell_info) + '</tr>';
        } else {
            var regular_block = emptyRegularPrescription(prescription_sheet_date, sno, id);
        }
        return regular_block;
    }

    function emptyRegularPrescription(prescription_sheet_date, sno, id) {
        var empty_box = emptyBox(prescription_sheet_date);
        var empty_regular_box = '<tr>';
        empty_regular_box += regularRow1(id, sno);
        empty_regular_box += empty_box;
        empty_regular_box += '</tr>';
        empty_regular_box += '<tr>';
        empty_regular_box += regularRow2(id, sno);
        empty_regular_box += empty_box;
        empty_regular_box += '</tr>';
        empty_regular_box += '<tr>';
        empty_regular_box += regularRow3(id);
        empty_regular_box += empty_box;
        empty_regular_box += '</tr>';
        empty_regular_box += '<tr>';
        empty_regular_box += regularRow4();
        empty_regular_box += empty_box;
        empty_regular_box += '</tr>';
        empty_regular_box += '<tr>';
        empty_regular_box += empty_box;
        empty_regular_box += '</tr>';
        empty_regular_box += '<tr>';
        empty_regular_box += empty_box;
        empty_regular_box += '</tr>';
        return empty_regular_box;
    }

    function updateRequiredStatPrescriptionList(required_value, sno = '', terminate_slug = false) {
        var prescription_sheet_date = pres_sheet_date;
        var pres_detail = required_value.pres_dtl;
        var active_id = required_value.active_id;
        var eventtime = typeof required_value.events_hour != 'undefined' ? required_value.events_hour : [];
        var required_data = prescriptionDataCollection(required_value);
        var id = required_data.id;
        var drug_name = required_data.drug_name;
        var dose = required_data.dose;
        var creamicon = required_data.creamicon;
        var infusion_type = required_data.infusion_type;
        var start_date = required_data.start_date;
        var start_time = required_data.start_time;
        var review_warning = required_data.review_warning;
        var review_date = required_data.review_date;
        var created_user = required_data.created_user;
        var prescription_date = required_data.prescription_date;
        var instruction = required_data.instruction;
        var frequency = required_data.frequency;
        var drug_start_date = required_data.drug_start_date;
        var terminate = required_data.terminate;
        var oral_route = required_data.oral_route;
        var event_time = [];
        var status_basic = '';
        if (eventtime.length > 0) {
            var required_info1, required_info2, required_info3, required_info4, required_info5, required_info6 = '';
            for (var i = 0; i < 6; i++) {
                var empty_cell_info = eventContent();
                var pres_value = prescriptionTime(eventtime, i);
                var required_info = formatPrescriptionTime(pres_value);
                for (var j = 0; j < prescription_sheet_date.length; j++) {
                    var action_content = actionBlock(id, j, pres_detail, prescription_sheet_date[j], terminate, pres_value, drug_start_date, active_id, terminate_slug);
                    required_info += action_content.info_block;
                    empty_cell_info += action_content.empty_cell_info;
                    if (status_basic == '') {
                        status_basic = action_content.status_basic;
                    }
                }
                if (jQuery.inArray(pres_value, event_time_row_1) !== -1) {
                    required_info1 = required_info;
                }
                if (jQuery.inArray(pres_value, event_time_row_2) !== -1) {
                    required_info2 = required_info;
                }
                if (jQuery.inArray(pres_value, event_time_row_3) !== -1) {
                    required_info3 = required_info;
                }
                if (jQuery.inArray(pres_value, event_time_row_4) !== -1) {
                    required_info4 = required_info;
                }
                if (jQuery.inArray(pres_value, event_time_row_5) !== -1) {
                    required_info5 = required_info;
                }
                if (jQuery.inArray(pres_value, event_time_row_6) !== -1) {
                    required_info6 = required_info;
                }
            }
            if (typeof user_role != 'undefined' && (user_role == super_admin_role || user_role == admin_role)) {
                if (status_basic || terminate_slug) {
                    var moreoption = menu();
                } else {
                    var moreoption = menus();
                }
            }
            var required_block = '<tr class="required-list prescription-border-top">';
            required_block += requiredStatRow1(id, sno, moreoption, drug_name);
            required_block += (required_info1 != '' && typeof required_info1 != 'undefined') ? required_info1 : empty_cell_info;
            required_block += '</tr>';
            required_block += '<tr class="required-list">';
            required_block += requiredStatRow2(dose, creamicon, frequency, oral_route, start_date);
            required_block += (required_info2 != '' && typeof required_info2 != 'undefined') ? required_info2 : empty_cell_info;
            required_block += '</tr>';
            var username = '';
            if (created_user != '' && user_sign[created_user] != null) {
                var usersign = createdBy(user_sign[created_user]);
                username = user_name[created_user];
            } else {
                var usersign = alt_img;
            }
            required_block += '<tr class="required-list">';
            required_block += requiredStatRow3(id, sno, usersign, prescription_date, review_warning, review_date, start_date, start_time, terminate, username);
            required_block += (required_info3 != '' && typeof required_info3 != 'undefined') ? required_info3 : empty_cell_info;
            required_block += '</tr>';
            required_block += '<tr class="required-list">';
            required_block += requiredStatRow4(instruction);
            required_block += (required_info4 != '' && typeof required_info4 != 'undefined') ? required_info4 : empty_cell_info;
            required_block += '</tr>';
            required_block += '<tr>' + ((required_info5 != '' && typeof required_info5 != 'undefined') ? required_info5 : empty_cell_info) + '</tr>';
            required_block += '<tr>' + ((required_info6 != '' && typeof required_info6 != 'undefined') ? required_info6 : empty_cell_info) + '</tr>';
        } else {
            var required_block = emptyRequiredStatPrescription(prescription_sheet_date, sno, id);
        }
        return required_block;
    }

    function emptyRequiredStatPrescription(prescription_sheet_date, sno, id) {
        var empty_box = emptyBox(prescription_sheet_date);
        var empty_required_box = '<tr>';
        empty_required_box += requiredStatRow1(id, sno);
        empty_required_box += empty_box;
        empty_required_box += '</tr>';
        empty_required_box += '<tr>';
        empty_required_box += requiredStatRow2();
        empty_required_box += empty_box;
        empty_required_box += '</tr>';
        empty_required_box += '<tr>';
        empty_required_box += requiredStatRow3(id, sno);
        empty_required_box += empty_box;
        empty_required_box += '</tr>';
        empty_required_box += '<tr>';
        empty_required_box += requiredStatRow4();
        empty_required_box += empty_box;
        empty_required_box += '</tr>';
        empty_required_box += '<tr>';
        empty_required_box += empty_box;
        empty_required_box += '</tr>';
        empty_required_box += '<tr>';
        empty_required_box += empty_box;
        empty_required_box += '</tr>';
        return empty_required_box;
    }

    function updateIntravenousPrescriptionList(intravenous_value, sno = '') {
        var prescription_sheet_date = pres_sheet_date;
        var intravenous_data = prescriptionDataCollection(intravenous_value);
        var drug_name = intravenous_data.drug_name;
        var dose = intravenous_data.dose;
        var start_date = intravenous_data.start_date;
        var start_time = intravenous_data.start_time;
        var created_user = intravenous_data.created_user;
        var instruction = intravenous_data.instruction;
        var qty_values = intravenous_data.qty_values;
        var volume_val = intravenous_data.volume_val;
        var duration = intravenous_data.duration;
        var drug_added = intravenous_data.drug_added;
        var dose_feq_addition = intravenous_data.dose_feq_addition;
        var rate = intravenous_data.rate;
        var batch_no = intravenous_data.batch_no;
        var event_time = [];
        var status_basic = '';
        var doctor_sign_content = '';
        var action_content = '';
        var username = '';
        if (created_user != '') {
            if (user_initial[created_user] != null && user_initial[created_user] != '') {
                var userInitial = '<img src="' + site_url_public + '/img/users/' + user_initial[created_user] + '" alt="Created By" />';
                username = user_name[created_user];
            } else {
                var userInitial = alt_img;
            }
            var action_response = intravenousActionBlock(intravenous_value);
            var action_content = action_response.info_block;
            if (status_basic == '') {
                status_basic = action_response.status_basic;
            }
        }
        if (typeof user_role != 'undefined' && (user_role == super_admin_role || user_role == admin_role) && drug_name != '') {
            if (status_basic) {
                var moreoption = menu();
            } else {
                var moreoption = menus();
            }
        }
        var intravenous_block = '<tr class="intravenous-list">';
        intravenous_block += intravenousRow(sno, moreoption, start_date, start_time, drug_name, instruction, volume_val, drug_added, dose_feq_addition, dose, rate, duration, userInitial, batch_no, action_content, qty_values, username);
        intravenous_block += '</tr>';
        return intravenous_block;
    }

    function emptyintravenousStatPrescription(sno) {
        return intravenousRow(sno);
    }

    function emptyBox(sheet_date) {
        var empty_box = '';
        for (var j = 0; j < sheet_date.length; j++) {
            var box_color = ((j + 1) % 2 == 0) ? ' even-box' : '';
            if (j == 0) {
                empty_box += '<td class="width-10 text-center time-font prescription-border-left prescription-border-right"><b></b><br><span class="indian-time"></span></td>';
            }
            empty_box += '<td data-col-date="' + sheet_date[j] + '" class="' + box_color + ' ' + j + ':0"></td>';
        }
        return empty_box;
    }

    function prescriptionDataCollection(regular_value) {
        var id = (typeof regular_value.hdr_id !== "undefined" && regular_value.hdr_id != null) ? regular_value.hdr_id : '';
        var brand_name = (typeof regular_value.brand_name !== "undefined" && regular_value.brand_name != null) ? regular_value.brand_name : '';
        var generic_pharmacological_name = (typeof regular_value.generic_pharmacological_name !== "undefined" && regular_value.generic_pharmacological_name != null) ? regular_value.generic_pharmacological_name : '';
        var drug_name = (typeof brand_name !== "undefined" && brand_name != "" && brand_name != null) ? (brand_name + "/" + generic_pharmacological_name) : '';
        drug_name = drug_name.replace(/[/]/g, ' / ');
        drug_name = drug_name.replace(/[(]/g, ' ( ');
        drug_name = drug_name.replace(/[)]/g, ' ) ');
        var dose_val = (typeof regular_value.dose !== "undefined" && regular_value.dose != null) ? regular_value.dose : '';
        var alt_dose_val = (typeof regular_value.alt_dose !== "undefined" && regular_value.alt_dose != null) ? regular_value.alt_dose : '';
        var infusion_type = (typeof regular_value.infusion_type !== "undefined" && regular_value.infusion_type != null) ? regular_value.infusion_type : '';
        var oral_route = (typeof regular_value.oral_route !== "undefined" && regular_value.oral_route != null) ? regular_value.oral_route : '';
        var creamicon = '';
        if (oral_route == '') {
            var dose_units_g = (typeof regular_value.dose_units_g !== "undefined" && regular_value.dose_units_g != null) ? unit_grams[regular_value.dose_units_g] : '';
            var alt_dose_units_g = (typeof regular_value.alt_dose_units_g !== "undefined" && regular_value.alt_dose_units_g != null) ? unit_grams[regular_value.alt_dose_units_g] : '';
        } else {
            var dose_units_g = (typeof regular_value.dose_units_g !== "undefined" && regular_value.dose_units_g != null) ? unit_grams_oral[regular_value.dose_units_g] : '';
            var alt_dose_units_g = (typeof regular_value.alt_dose_units_g !== "undefined" && regular_value.alt_dose_units_g != null) ? unit_grams_oral[regular_value.alt_dose_units_g] : '';
            if (dose_units_g == 'topical' || alt_dose_units_g == 'topical') {
                creamicon = '<i class="fas fa-highlighter"></i>';
            }
            infusion_type = oral_route;
        }
        var dose = (typeof dose_val !== "undefined" && dose_val != '' && dose_val != null && dose_val > 0) ? (dose_val + " " + dose_units_g) : '';
        var altdose = (typeof alt_dose_val !== "undefined" && alt_dose_val != '' && alt_dose_val != null && alt_dose_val > 0) ? (alt_dose_val + " " + alt_dose_units_g) : '';
        if (dose != '' && altdose != '') {
            var dose = dose + ' / ' + altdose;
        } else if (dose != '') {
            var dose = dose;
        } else if (altdose != '') {
            var dose = altdose;
        } else {
            var dose = '';
        }
        var start_date = (typeof regular_value.start_date !== "undefined" && regular_value.start_date != null) ? regular_value.start_date : '';
        var review_date = (typeof regular_value.review_date !== "undefined" && regular_value.review_date != null) ? regular_value.review_date : '';
        var prescription_date = (typeof regular_value.prescription_date !== "undefined" && regular_value.prescription_date != null) ? regular_value.prescription_date : '';
        var instruction = (typeof regular_value.instruction !== "undefined" && regular_value.instruction != null) ? regular_value.instruction : '';
        var terminate = (typeof regular_value.terminate !== "undefined" && regular_value.terminate != null) ? regular_value.terminate : '';
        var created_user = (typeof regular_value.hdr_created_user !== "undefined" && regular_value.hdr_created_user != null) ? regular_value.hdr_created_user : '';
        var frequency = (typeof regular_value.frequency !== "undefined" && regular_value.frequency != null) ? regular_value.frequency : '';
        if (start_date != '') {
            start_date = start_date.replace(/\s/, 'T');
            var date = new Date(start_date);
            start_date = dateFormatter(date) + '/' + monthFormatter(date) + '/' + date.getFullYear();
            var start_time = railwayHourFormatter(date) + ':' + minuteFormatter(date);
            var drug_start_date = date;
        }
        if (review_date != '') {
            review_date = review_date.replace(/\s/, 'T');
            var date = new Date(review_date);
            review_date = dateFormatter(date) + '/' + monthFormatter(date) + '/' + date.getFullYear();
        }
        var current_date = new Date();
        var diff = new Date(date - current_date);
        var review_warning = diff / 1000 / 60 / 60 / 24;
        if (review_warning < 0 && (terminate == '' || terminate == null)) {
            review_warning = 'review_warning';
        } else {
            review_warning = '';
        }
        if (prescription_date != '') {
            prescription_date = prescription_date.replace(/\s/, 'T');
            var date = new Date(prescription_date);
            prescription_date = dateFormatter(date) + '/' + monthFormatter(date) + '/' + date.getFullYear();
            prescription_date = prescription_date + ' ' + railwayHourFormatter(date) + ':' + minuteFormatter(date);
        }
        var qty = (typeof regular_value.quantity !== "undefined" && regular_value.quantity != null) ? regular_value.quantity : '';
        var qtyunit = (typeof regular_value.quantity_units !== "undefined" && regular_value.quantity_units != null) ? regular_value.quantity_units : '';
        var qty_values = '';
        if (qty != '' && qty_unit != '') {
            qty_values = ' ( ' + qty + ' ' + qty_unit[qtyunit] + ' )';
        }
        var volume_val = (typeof regular_value.volume !== "undefined" && regular_value.volume != null && regular_value.volume > 0) ? regular_value.volume + " ml" : '';
        var syringe_size_val = (typeof regular_value.syringe_size !== "undefined" && regular_value.syringe_size != null) ? (regular_value.syringe_size + " ml") : '';
        if (volume_val != '' && syringe_size_val != '') {
            volume_val = volume_val + ',' + syringe_size_val;
        } else if (volume_val != '') {
            volume_val = volume_val;
        } else if (syringe_size_val != '') {
            volume_val = syringe_size_val;
        } else {
            volume_val = '';
        }
        var duration = (typeof regular_value.duration !== "undefined" && regular_value.duration != null && regular_value.duration > 0) ? regular_value.duration : "";
        if (duration != '') {
            duration = duration + " " + regular_value.duration_time;
        }
        var drug_added = (typeof regular_value.drug_added !== "undefined" && regular_value.drug_added != null) ? regular_value.drug_added : '';
        var dose_feq_addition = (typeof regular_value.dose_feq_addition !== "undefined" && regular_value.dose_feq_addition != null && regular_value.dose_feq_addition != '') ? (regular_value.drug_added != '' ? ', ' : '') + regular_value.dose_feq_addition : '';
        var rate = (typeof regular_value.rate !== "undefined" && regular_value.rate != '' && regular_value.rate != null && regular_value.rate > 0) ? regular_value.rate : '';
        var batch_no = (typeof regular_value.batch_no !== "undefined" && regular_value.batch_no != null) ? regular_value.batch_no : '';
        return {
            id: id,
            drug_name: drug_name,
            dose: dose,
            creamicon: creamicon,
            start_date: start_date,
            start_time: start_time,
            review_warning: review_warning,
            review_date: review_date,
            prescription_date: prescription_date,
            instruction: instruction,
            frequency: frequency,
            terminate: terminate,
            created_user: created_user,
            drug_start_date: drug_start_date,
            oral_route: oral_route,
            qty_values: qty_values,
            volume_val: volume_val,
            duration: duration,
            drug_added: drug_added,
            dose_feq_addition: dose_feq_addition,
            rate: rate,
            batch_no: batch_no,
            infusion_type: infusion_type
        }
    }

    function prescriptionTime(eventtimelist, i) {
        if (eventtimelist.length == 2 && i == 1) {
            eventtimelist[2] = eventtimelist[i];
            var value = '';
        } else {
            var value = eventtimelist[i];
        }
        return value;
    }

    function formatPrescriptionTime(eventtime) {
        if (typeof eventtime != 'undefined' && eventtime != '') {
            if (eventtime > 12) {
                var eventtime_half = (eventtime - 12) + ' PM';
            } else if (eventtime == 12) {
                var eventtime_half = eventtime + ' PM';
            } else {
                if (eventtime > 9) {
                    var eventtime_half = eventtime + ' AM';
                } else {
                    var eventtime_half = eventtime + ' AM';
                }
            }
            return eventContent(eventtime, eventtime_half);
        }
        return eventContent();
    }

    function eventContent(eventtime = '', eventtime_half = '') {
        var content = '<td class="width-10 text-center time-font prescription-border-left prescription-border-right">';
        content += '<b>' + eventtime + '</b>';
        content += '<br />';
        if (eventtime_half != '') {
            content += '<span class="indian-time">( ' + eventtime_half + ' )</span>';
        } else {
            content += '<span class="indian-time"></span>';
        }
        content += '</td>';
        return content;
    }

    function actionBlock(id, j, pres_detail, ps_date, terminate, pres_value, drug_start_date, active_id, terminate_slug) {
        var info_block = '';
        var terminatecolor = '';
        var time_info, status_icon = '';
        var box_color = ((j + 1) % 2 == 0) ? 'even-box' : 'odd-box';
        var pdate = ps_date.split('-');
        var terminate_datetime;
        var status_basic = false;
        if (terminate_slug) {
            terminate_datetime = dbDateToJsDate(terminate);
            var event_time = new Date(pdate[2], (pdate[0] - 1), pdate[1], pres_value);
            if (event_time >= terminate_datetime && event_time >= drug_start_date) {
                terminatecolor = 'terminate-bg';
            }
        }
        if (typeof ps_date !== "undefined") {
            date = new Date(pdate[2], (pdate[0] - 1), pdate[1]);
            var strDate = dateFormatter(date) + '-' + monthFormatter(date) + '-' + date.getFullYear();
            if (typeof pres_detail !== "undefined" && typeof pres_detail[strDate] !== "undefined" && typeof pres_detail[strDate][pres_value] !== "undefined" && typeof pres_detail[strDate][pres_value][0] !== "undefined") {
                time_info = pres_detail[strDate][pres_value][0];
                var send_status = time_info.is_send;
                if (send_status != 0 && !status_basic) {
                    status_basic = true;
                    terminatecolor = '';
                }
                info_block = statusBlock(time_info, active_id, ps_date, box_color, terminatecolor);
            } else {
                info_block += '<td data-col-date="' + ps_date + '" class="' + box_color + ' ' + terminatecolor + ' ' + pres_value + ':0"></td>';
            }
        } else {
            info_block += '<td data-col-date="' + ps_date + '" class="' + box_color + ' ' + terminatecolor + ' ' + pres_value + ':0"></td>';
        }
        var empty_cell_info = '<td data-col-date="' + ps_date + '" class="' + box_color + ' ' + terminatecolor + ' e:0"></td>';
        return {
            info_block: info_block,
            empty_cell_info: empty_cell_info,
            status_basic: status_basic
        }
    }

    function intravenousActionBlock(values_info) {
        var send_status = values_info.is_send;
        var info_block = statusBlock(values_info);
        var status_basic = false;
        if (send_status != 0 && !status_basic) {
            status_basic = true;
        }
        return {
            info_block: info_block,
            status_basic: status_basic
        };
    }

    function menu() {
        var moreoption = '<div class="pdropdown pull-right one-more">';
        moreoption += '<button class="pdropbtn">';
        moreoption += '<i class="fa fa-bars"></i>';
        moreoption += '</button>';
        moreoption += '<div class="pdropdown-content">';
        moreoption += '<a href="#" class="create-prescription">Copy</a>';
        moreoption += '</div>';
        moreoption += '</div>';
        moreoption += '</div>';
        return moreoption;
    }

    function menus() {
        var moreoption = '<div class="pdropdown pull-right">';
        moreoption += '<button class="pdropbtn">';
        moreoption += '<i class="fa fa-bars"></i>';
        moreoption += '</button>';
        moreoption += '<div class="pdropdown-content">';
        moreoption += '<a href="#" class="create-prescription">Copy</a>';
        moreoption += '<a href="#" class="edit-prescription">Edit</a>';
        moreoption += '</div>';
        moreoption += '</div>';
        moreoption += '</div>';
        return moreoption;
    }

    function regularRow1(id, sno, moreoption = '', drug_name = '') {
        var row_content = '<td class="text-center time-font" rowspan="6">';
        row_content += '<strong>' + sno + '</strong>';
        row_content += '</td>';
        row_content += '<td class="drug-content" colspan="4">';
        row_content += '<span class="hide">' + id + '</span>';
        row_content += '<div data-id="' + id + '">Drug&nbsp' + moreoption + '</div>';
        row_content += '<span class="main-text over-dose-highlighter">' + drug_name + '</span>';
        row_content += '</td>';
        return row_content;
    }

    function regularRow2(id, sno, dose = '', creamicon = '', infusion_type = '', start_date = '', start_time = '', review_warning = '', review_date = '') {
        var row_content = '<td class="dose">';
        row_content += '<span>Dose</span>';
        row_content += '<div class="main-text white-space-nowrap">' + dose + creamicon + '</div>';
        row_content += '</td>';
        row_content += '<td class="route">';
        row_content += '<span>Route</span>';
        row_content += '<div class="main-text">' + infusion_type + '</div>';
        row_content += '</td>';
        row_content += '<td class="startdate">';
        row_content += '<span class="avoid-wrap">Start Date</span>';
        row_content += '<div class="avoid-wrap main-text">' + start_date + '</div>';
        row_content += '</td>';
        row_content += '<td class="review-date-update reviewdate ' + review_warning + '" data-review-date="' + review_date + ' ' + start_time + '" data-start-date="' + start_date + ' ' + start_time + '" data-hdr-id="' + id + '" data-sno="' + sno + '">';
        row_content += '<span class="avoid-wrap">Review Date</span>';
        row_content += '<div class="avoid-wrap main-text review-val">';
        row_content += '<b>' + review_date + '</b>';
        row_content += '</div>';
        row_content += '</td>';
        return row_content;
    }

    function regularRow3(id, usersign = '', prescription_date = '', terminate = '', username = '') {
        var row_content = '<td class="signature" colspan="3" title="' + username + '">';
        row_content += '<span>Signature</span><br/>';
        row_content += '<span>' + usersign + '</span><br/>';
        row_content += '<span class="avoid-wrap main-text pull-right">' + prescription_date + '</span>';
        row_content += '</td>';
        var pres_alt_span = emptyBlock(id);
        if (prescription_date != '') {
            if (terminate != '' && terminate != null) {
                pres_alt_span = cancelBlock();
            } else if (typeof user_role != 'undefined' && (user_role == super_admin_role || user_role == admin_role)) {
                pres_alt_span = discontinueBlock(id);
            }
        }
        row_content += pres_alt_span;
        return row_content;
    }

    function regularRow4(instruction = '', frequency = '') {
        var row_content = '<td class="prescription-border-bottom vertical-align-top instruction" rowspan="3" colspan="3">';
        row_content += '<div>Additional Instructions</div>';
        row_content += '<div class="main-text">' + instruction + '</div>';
        row_content += '</td>';
        row_content += '<td class="regfrequency" rowspan="3">';
        row_content += '<div>Frequency</div>';
        row_content += '<div class="main-text">' + frequency + '</div>';
        row_content += '</td>';
        return row_content;
    }

    function cancelBlock() {
        var row_content = '<td class="text-center vertical-align-middle reviewdate terminate-imgicon">';
        row_content += '<img src="' + site_url_public + '/img/cancelled-stamp.png" alt="Cancelled By" class="cancelled_icon" />';
        row_content += '</td>';
        return row_content;
    }

    function discontinueBlock(id) {
        var row_content = '<td class="discontinue-drug text-center reviewdate" data-id="' + id + '">';
        row_content += '<div>Discontinue</div>';
        row_content += '</td>';
        return row_content;
    }

    function emptyBlock(id) {
        var row_content = '<td class="text-center reviewdate" data-id="' + id + '"></td>';
        return row_content;
    }

    function createdBy(user_sign_file_name) {
        return '<img src="' + site_url_public + '/img/users/' + user_sign_file_name + '" alt="Created By" class="user-sign" />';
    }

    function requiredStatRow1(id, sno, moreoption = '', drug_name = '') {
        var row_content = '<td class="text-center time-font" rowspan="6">';
        row_content += '<strong>' + sno + '</strong>';
        row_content += '</td>';
        row_content += '<td class="main-drug" colspan="4">';
        row_content += '<span class="hide">' + id + '</span>';
        row_content += '<div data-id="' + id + '">Drug &nbsp</i>' + moreoption + '</div>';
        row_content += '<span class="main-text over-dose-highlighter">' + drug_name + '</span>';
        row_content += '</td>';
        row_content += '<td class="prescription-border-right dose-time">Date</td>';
        return row_content;
    }

    function requiredStatRow2(dose = '', creamicon = '', frequency = '', oral_route = '', start_date = '') {
        var row_content = '<td class="dose">';
        row_content += '<span>Dose</span>';
        row_content += '<div class="main-text white-space-nowrap ">' + dose + creamicon + '</div>';
        row_content += '</td>';
        row_content += '<td class="frequency">';
        row_content += '<span>Max. Frequency</span>';
        row_content += '<div class="main-text">' + frequency + '</div>';
        row_content += '</td>';
        row_content += '<td class="route">';
        row_content += '<span>Route</span>';
        row_content += '<div class="main-text">' + oral_route + '</div>';
        row_content += '</td>';
        row_content += '<td class="prescription-border-right startdate">';
        row_content += '<span class="avoid-wrap">Start Date</span>';
        row_content += '<div class="avoid-wrap main-text">' + start_date + '</div>';
        row_content += '</td>';
        row_content += '<td class="prescription-border-right dosetime dose-time">Time</td>';
        return row_content;
    }

    function requiredStatRow3(id, sno, usersign = '', prescription_date = '', review_warning = '', review_date = '', start_date = '', start_time = '', terminate = '', username = '') {
        var row_content = '<td class="signature" colspan="2" title="' + username + '">';
        row_content += '<span>Signature</span><br/>';
        row_content += '<span>' + usersign + '</span><br/>';
        row_content += '<span class="avoid-wrap main-text pull-right">' + prescription_date + '</span>';
        row_content += '</td>';
        row_content += '<td class="review-date-update reviewdate ' + review_warning + '" data-review-date="' + review_date + ' ' + start_time + '" data-start-date="' + start_date + ' ' + start_time + '" data-hdr-id="' + id + '" data-sno="' + sno + '">';
        row_content += '<span class="avoid-wrap">Review date</span>';
        row_content += '<div class="avoid-wrap main-text review-val">';
        row_content += '<b>' + review_date + '</b>';
        row_content += '</div>';
        row_content += '</td>';
        var pres_alt_span = emptyBlock(id);
        if (prescription_date != '') {
            if (terminate != '' && terminate != null) {
                pres_alt_span = cancelBlock();
            } else {
                if (typeof user_role != 'undefined' && (user_role == super_admin_role || user_role == admin_role)) {
                    pres_alt_span = discontinueBlock(id);
                }
            }
        }
        row_content += pres_alt_span;
        row_content += '<td class="remove-padding prescription-border-right dosetime dose-time vertical-align-middle">';
        row_content += '<div class="plr-5" style="padding-right: 30px">Dose</div>';
        row_content += '<div class="cross-bottom"></div>';
        row_content += '<div class="pull-right plr-5" style="padding-left: 30px">Route</div>';
        row_content += '</td>';
        return row_content;
    }

    function requiredStatRow4(instruction = '') {
        var row_content = '<td rowspan="3" colspan="4" class="prescription-border-right vertical-align-top main-drug add-ins" style="padding-top: 0px; padding-bottom: 0px;">';
        row_content += '<div>Additional Instructions</div>';
        row_content += '<div class="main-text">' + instruction + '</div>';
        row_content += '</td>';
        row_content += '<td rowspan="3" class="prescription-border-right vertical-align-top dose-time" style="padding-top: 0px; padding-bottom: 0px;">';
        row_content += '<div class="avoid-wrap">Given by</div>';
        row_content += '<div>&nbsp</div>';
        row_content += '</td>';
        return row_content;
    }

    function intravenousRow(sno, moreoption = '', start_date = '', start_time = '', drug_name = '', instruction = '', volume_val = '', drug_added = '', dose_feq_addition = '', dose = '', rate = '', duration = '', userInitial = '', batch_no = '', doctor_sign = '', qty_values = '', username = '') {
        var row_content = '<td class="text-center serial-no time-font"><strong>' + sno + '</strong>' + moreoption + '</td>';
        row_content += '<td class="text-center avoid-wrap main-text date-fluid">' + start_date + '</td>';
        row_content += '<td class="text-center avoid-wrap main-text time-fluid">' + start_time + '</td>';
        row_content += '<td class="text-center main-text intra-instruction"><span class="over-dose-highlighter">' + drug_name + '</span><div class="white-space-nowrap">' + qty_values + '</div>' + '<div class="additional-instruction">' + ((instruction != "" && instruction != undefined) ? '(' + instruction + ')' : "") + '</div></td>';
        row_content += '<td class="text-center main-text">' + volume_val + '</td>';
        row_content += '<td class="text-center main-text">' + drug_added + dose_feq_addition + '</td>';
        row_content += '<td class="text-center main-text">' + dose + '</td>';
        row_content += '<td class="text-center main-text">' + rate + '</td>';
        row_content += '<td class="text-center main-text">' + duration + '</td>';
        row_content += '<td class="text-center main-text" title="' + username + '">' + userInitial + '</td>';
        row_content += '<td class="text-center main-text">' + batch_no + '</td>';
        if (doctor_sign != '') {
            row_content += doctor_sign;
        } else {
            row_content += '<td class="text-center"><br/></td>';
        }
        return row_content;
    }

    function checkBoxView(id, drug_type, send_status) {
        var box_view = '<input type="checkbox" name="send_list[]" data-drug-type="' + drug_type + '" value="' + id + '" class="form-control syringe-checkbox-' + id + ' margin-auto" data-send-status="' + send_status + '">';
        box_view += '<label for="roundedTwo"></label>';
        return box_view;
    }

    function startSignBlock(user_sign_file_name, user_namee) {
        var user_sign_file_name = (user_sign_file_name == no_img_file_name) ? user_sign_file_name : ('users/' + user_sign_file_name);
        return '<div class="confirm-sign" title="' + user_namee + '">' + '<img src="' + site_url_public + '/img/' + user_sign_file_name + '" alt="Started By" />' + '</div>';
    }

    function startDateBlock(start_date, start_hour_12, start_minute_12, start_session, confirm_time) {
        return '<div class="confirm-date avoid-wrap" data-date="' + start_date + '" data-hour="' + start_hour_12 + '" data-minute="' + start_minute_12 + '" data-session="' + start_session + '" ><b>' + confirm_time + '</b></div>';
    }

    function cancelSignBlock(user_sign_file_name, user_namee) {
        var user_sign_file_name = (user_sign_file_name == no_img_file_name) ? user_sign_file_name : ('users/' + user_sign_file_name);
        return '<div class="stop-sign" title="' + user_namee + '">' + '<img src="' + site_url_public + '/img/' + user_sign_file_name + '" alt="Cancelled By" />' + '</div>';
    }

    function cancelDateBlock(cancel_date, cancel_hour_12, cancel_minute_12, cancel_session, cancel_reason, cancel_time) {
        return '<div class="cancel-date avoid-wrap" data-date="' + cancel_date + '" data-hour="' + cancel_hour_12 + '" data-minute="' + cancel_minute_12 + '" data-session="' + cancel_session + '" data-reason="' + cancel_reason + '"><b>' + cancel_time + '</b></div>';
    }

    function stopSignBlock(user_sign_file_name, user_namee) {
        var user_sign_file_name = (user_sign_file_name == no_img_file_name) ? user_sign_file_name : ('users/' + user_sign_file_name);
        return '<div class="stop-sign" title="' + user_namee + '">' + '<img src="' + site_url_public + '/img/' + user_sign_file_name + '" alt="Stopped By" />' + '</div>';
    }

    function stopDateBlock(stop_date, stop_hour_12, stop_minute_12, stop_session, stopby_reason, stopby_total_vol, stop_time) {
        return '<div class="stop-date avoid-wrap" data-date="' + stop_date + '" data-hour="' + stop_hour_12 + '" data-minute="' + stop_minute_12 + '" data-session="' + stop_session + '" data-reason="' + stopby_reason + '" data-infused="' + stopby_total_vol + '"><b>' + stop_time + '</b></div>';
    }

    function createOrModifyDateTimeFormatter(created_date, modified_date, created_user, modified_user) {
        var datetime = (typeof modified_date != 'undefined' && modified_date != null) ? modified_date : created_date;
        var user = (typeof modified_user != 'undefined' && modified_user != null) ? modified_user : created_user;
        var date_time = datetime.split(' ');
        var sdate = date_time[0].split('-');
        var stime = date_time[1].split(':');
        var at = new Date(sdate[0], (sdate[1] - 1), sdate[2], stime[0], stime[1]);
        var date = dateFormatter(at) + '-' + monthFormatter(at) + '-' + at.getFullYear();
        var hour = railwayHourFormatter(at);
        var hour_display = railwayHourFormatter(at);
        var hour_12 = hourFormatter(at, false);
        var minute = minuteFormatter(at, false);
        var minute_display = minuteFormatter(at);
        var minute_12 = minute;
        var session = sessionFormatter(at);
        var display_time = hour_display + ':' + minute_display;
        return {
            user: user,
            date: date,
            hour_12: hour_12,
            minute_12: minute_12,
            session: session,
            display_time: display_time
        }
    }

    function statusBlock(block_info, active_id = '', ps_date = '', box_color = '', terminatecolor = '') {
        var id = block_info.id;
        var send_status = block_info.is_send;
        var drug_type = block_info.prescription_id.replace(/[0-9]/g, '');
        var prescription_id = block_info.prescription_id;
        var started_date = block_info.started_date;
        var modified_started_date = block_info.modified_started_date;
        var started_user = block_info.started_user;
        var modified_started_user = block_info.modified_started_user;
        var status_content = '';
        var info_block = '';
        var action_type = '';
        if (active_id == id || ps_date == '') {
            action_type = 'addAction';
        }
        if (send_status == 0) {
            var build_block = '<div class="roundedTwo ' + action_type + '">';
            build_block += checkBoxView(id, drug_type, send_status);
            build_block += '</div>';
            status_content = {
                status_name: status_initial,
                action_block: build_block,
                title: ''
            };
        } else if (send_status == 1 || send_status == 9 || send_status == 2 || send_status == 4 || send_status == 5 || send_status == 7) {
            var build_block_left = statusBlockLeft(started_date, modified_started_date, started_user, modified_started_user);
            var build_block_right_center = '<div class="roundedTwo checkbox-align-center ' + action_type + '">';
            build_block_right_center += checkBoxView(id, drug_type, send_status);
            build_block_right_center += '</div>';
            var build_block_right = '<div class="sign-align1">' + build_block_right_center + '</div>';
            if (send_status == 1) {
                var status_name = status_sent;
            } else if (send_status == 9 || send_status == 2) {
                var status_name = status_queue;
            } else if (send_status == 4) {
                var status_name = status_pause;
            } else if (send_status == 5) {
                var status_name = status_execute;
            } else {
                var status_name = status_complete;
            }
            status_content = {
                status_name: status_name,
                action_block: build_block_left + build_block_right,
                title: ''
            };
        } else if (send_status == 3 || send_status == 8 || send_status == 10 || send_status == 11) {
            var only_cancel = 'full-sign';
            var build_block_left = '';
            if (started_date != null) {
                build_block_left = statusBlockLeft(started_date, modified_started_date, started_user, modified_started_user);
                only_cancel = '';
            }
            var ended_date = block_info.cancel_datetime;
            var modified_ended_date = block_info.modified_cancel_datetime;
            var ended_user = block_info.cancelled_user;
            var modified_ended_user = block_info.modified_cancelled_user;
            var ended_reason = (typeof block_info.modified_cancel_reason != 'undefined' && block_info.modified_cancel_reason != null) ? block_info.modified_cancel_reason : block_info.cancel_reason;
            var ended_info = createOrModifyDateTimeFormatter(ended_date, modified_ended_date, ended_user, modified_ended_user);
            var ended_user = ended_info.user;
            var ended_date = ended_info.date;
            var ended_hour_12 = ended_info.hour_12;
            var ended_minute_12 = ended_info.minute_12;
            var ended_session = ended_info.session;
            var ended_display_time = ended_info.display_time;
            var ended_reason = (typeof block_info.modified_cancel_reason != 'undefined' && block_info.modified_cancel_reason != null) ? block_info.modified_cancel_reason : block_info.cancel_reason;
            var ended_user_sign = (ended_user != null && user_initial[ended_user] != null && user_initial[ended_user] != '') ? user_initial[ended_user] : no_img_file_name;
            var ended_user_name = (ended_user != null && user_name[ended_user] != null && user_name[ended_user] != '') ? user_name[ended_user] : '';
            var build_block_right_top = cancelSignBlock(ended_user_sign, ended_user_name);
            var build_block_right_bottom = cancelDateBlock(ended_date, ended_hour_12, ended_minute_12, ended_session, ended_reason, ended_display_time);
            var build_block_right = '<div class="sign-align1 ' + only_cancel + '">' + build_block_right_top + build_block_right_bottom + '</div>';
            status_content = {
                status_name: status_cancel,
                action_block: build_block_left + build_block_right,
                title: ended_reason
            };
        } else if (send_status == 20 || send_status == 21) {
            var build_block_left = '';
            if (started_date != null) {
                build_block_left = statusBlockLeft(started_date, modified_started_date, started_user, modified_started_user);
            }
            var ended_date = block_info.stopped_date;
            var modified_ended_date = block_info.modified_stopped_date;
            var ended_user = block_info.stopped_user;
            var modified_ended_user = block_info.modified_stopped_user;
            var ended_reason = (typeof block_info.modified_stop_reason != 'undefined' && block_info.modified_stop_reason != null) ? block_info.modified_stop_reason : block_info.stop_reason;
            var ended_total_infused = (typeof block_info.modified_total_infused != 'undefined' && block_info.modified_total_infused != null) ? block_info.modified_total_infused : block_info.total_infused;
            var ended_info = createOrModifyDateTimeFormatter(ended_date, modified_ended_date, ended_user, modified_ended_user);
            var ended_user = ended_info.user;
            var ended_date = ended_info.date;
            var ended_hour_12 = ended_info.hour_12;
            var ended_minute_12 = ended_info.minute_12;
            var ended_session = ended_info.session;
            var ended_display_time = ended_info.display_time;
            var ended_user_sign = (user_initial[ended_user] != null && user_initial[ended_user] != '' && ended_user != null) ? user_initial[ended_user] : no_img_file_name;
            var ended_user_name = (user_name[ended_user] != null && user_name[ended_user] != '' && ended_user != null) ? user_name[ended_user] : '';
            var build_block_right_top = stopSignBlock(ended_user_sign, ended_user_name);
            var build_block_right_bottom = stopDateBlock(ended_date, ended_hour_12, ended_minute_12, ended_session, ended_reason, ended_total_infused, ended_display_time);
            var build_block_right = '<div class="sign-align1">' + build_block_right_top + build_block_right_bottom + '</div>';
            status_content = {
                status_name: status_stop,
                action_block: build_block_left + build_block_right,
                title: ended_reason
            };
        }
        var info = '<div class="sign-block">' + status_content.action_block + '</div>';
        var infused = typeof ended_total_infused != 'undefined' ? ended_total_infused : block_info.infused;
        var title_content = 'title="' + status_content.title + '"';
        if (box_color == '') {
            info_block = '<td ' + title_content + ' class="' + status_content.status_name + ' text-center syringe-pump-status" id="drug-id-' + id + '" data-pres="' + id + '" data-advice-id="' + prescription_id + '"  data-drug-infused="' + infused + '">' + info + '</td>';
        } else {
            info_block = '<td ' + title_content + ' data-col-date="' + ps_date + '" ' + title_content + ' class="' + status_content.status_name + ' ' + box_color + ' ' + terminatecolor + ' text-center syringe-pump-status" id="drug-id-' + id + '" data-pres="' + id + '" data-advice-id="' + prescription_id + '" data-drug-infused="' + infused + '">' + info + '</td>';
        }
        return info_block;
    }

    function statusBlockLeft(started_date, modified_started_date, started_user, modified_started_user) {
        var started_info = createOrModifyDateTimeFormatter(started_date, modified_started_date, started_user, modified_started_user);
        var started_user = started_info.user;
        var started_date = started_info.date;
        var started_hour_12 = started_info.hour_12;
        var started_minute_12 = started_info.minute_12;
        var started_session = started_info.session;
        var started_display_time = started_info.display_time;
        var started_user_sign = (user_initial[started_user] != null && user_initial[started_user] != '' && started_user != null) ? user_initial[started_user] : no_img_file_name;
        var started_user_name = (user_name[started_user] != null && user_name[started_user] != '' && started_user != null) ? user_name[started_user] : '';
        var build_block_left_top = startSignBlock(started_user_sign, started_user_name);
        var build_block_left_bottom = startDateBlock(started_date, started_hour_12, started_minute_12, started_session, started_display_time);
        return '<div class="sign-align">' + build_block_left_top + build_block_left_bottom + '</div>';
    }
    $(window).load(function () {
        $('li.active a').trigger('click');
    });
    $(document).on('click', 'li a[role="tab"]', function () {
        if ($(this).attr('href') == '#intravenous') {
            $('.date-selection input').attr('disabled', true);
        } else {
            $('.date-selection input').attr('disabled', false);
            if ($(this).attr('href') == '#regulardrug') {
                if (typeof $("#regulardrug .cursor_position").offset() != 'undefined') {
                    $('#regulardrug').animate({
                        scrollLeft: $("#regulardrug .cursor_position").offset().left - $('#regulardrug #date-0').offset().left
                    }, 500);
                }
            } else if ($(this).attr('href') == '#requireddrug') {
                if (typeof $("#requireddrug .cursor_position").offset() != 'undefined') {
                    $('#requireddrug').animate({
                        scrollLeft: $("#requireddrug .cursor_position").offset().left - $('#requireddrug #date-0').offset().left
                    }, 500);
                }
            } else if ($(this).attr('href') == '#statdrug') {
                if (typeof $("#statdrug .cursor_position").offset() != 'undefined') {
                    $('#statdrug').animate({
                        scrollLeft: $("#statdrug .cursor_position").offset().left - $('#statdrug #date-0').offset().left
                    }, 500);
                }
            }
        }
    });
    $('#prescription-content .resend-prescription, #prescription-content-ipad .resend-prescription').hide();
    $('.nav-tabs > li > a').on("click", function (e) {
        e.preventDefault();
        $('input[name="send_list[]"]').prop('checked', false);
        disableOrderBtn();
    });
    $(document).on('click', '.roundedTwo.addAction', function () {
        var check_box_element = $(this).find('input');
        var id = check_box_element.val();
        var interface_status = pump_interface;
        if (!check_box_element.prop('checked')) {
            check_box_selected_count++;
            if (check_box_selected_count > 1) {
                Showalert('warning', 'Unable to select multiple order');
                check_box_selected_count--;
            } else {
                check_box_element.prop('checked', true);
                var status = check_box_element.attr("data-send-status");
                if ($('#prescription-body').hasClass('prescription-interface')) {
                    $('#prescription-content .send-to-pump, #prescription-content-ipad .send-to-pump').show();
                    $('#prescription-content .resend-prescription, #prescription-content-ipad .resend-prescription').hide();
                    if (status == 0) {
                        $('#prescription-content .send-to-pump, #prescription-content-ipad .send-to-pump, #prescription-content .cancel-order, #prescription-content-ipad .cancel-order').attr('disabled', false);
                        $('#prescription-content .stop-order, #prescription-content-ipad .stop-order').attr('disabled', true);
                    } else if ((status == 1 || status == 2 || status == 9) && interface_status) {
                        $('#prescription-content .cancel-order, #prescription-content-ipad .cancel-order, #prescription-content .stop-order, #prescription-content-ipad .stop-order, #prescription-content .send-to-pump, #prescription-content-ipad .send-to-pump').attr('disabled', false);
                        if (check_box_element.attr("data-drug-type") != 'ORAL') {
                            $('#prescription-content .send-to-pump, #prescription-content-ipad .send-to-pump').hide();
                            $('#prescription-content .resend-prescription, #prescription-content-ipad .resend-prescription').show();
                            $('#prescription-content .resend-prescription, #prescription-content-ipad .resend-prescription').attr('disabled', false);
                            $('#prescription-content .resend-prescription, #prescription-content-ipad .resend-prescription').attr('data-resend-id', id);
                        } else {
                            $('#prescription-content .send-to-pump, #prescription-content-ipad .send-to-pump, #prescription-content .resend-prescription, #prescription-content-ipad .resend-prescription').attr('disabled', true);
                            $('#prescription-content .stop-order, #prescription-content-ipad .stop-order, #prescription-content .cancel-order, #prescription-content-ipad .cancel-order').attr('disabled', false);
                        }
                    } else if (status == 1 && !interface_status) {
                        $('#prescription-content .cancel-order, #prescription-content-ipad .cancel-order, #prescription-content .stop-order, #prescription-content-ipad .stop-order, #prescription-content .send-to-pump, #prescription-content-ipad .send-to-pump').attr('disabled', false);
                    } else if (status == 4) {
                        $('#prescription-content .send-to-pump, #prescription-content-ipad .send-to-pump').attr('disabled', true);
                        $('#prescription-content .stop-order, #prescription-content-ipad .stop-order, #prescription-content .cancel-order, #prescription-content-ipad .cancel-order').attr('disabled', false);
                    } else if (status == 5) {
                        $('#prescription-content .send-to-pump, #prescription-content-ipad .send-to-pump').attr('disabled', true);
                        $('#prescription-content .stop-order, #prescription-content-ipad .stop-order, #prescription-content .cancel-order, #prescription-content-ipad .cancel-order').attr('disabled', false);
                    } else if (status == 7) {
                        $('#prescription-content .send-to-pump, #prescription-content-ipad .send-to-pump').attr('disabled', true);
                        $('#prescription-content .stop-order, #prescription-content-ipad .stop-order, #prescription-content .cancel-order, #prescription-content-ipad .cancel-order').attr('disabled', false);
                    } else if (status == 8) {
                        $('#prescription-content .cancel-order, #prescription-content-ipad .cancel-order').attr('disabled', false);
                        $('#prescription-content .send-to-pump, #prescription-content-ipad .send-to-pump, #prescription-content .stop-order, #prescription-content-ipad .stop-order').attr('disabled', true);
                    }
                } else {
                    if (status == 0) {
                        $('#prescription-content .send-to-pump, #prescription-content-ipad .send-to-pump, #prescription-content .cancel-order, #prescription-content-ipad .cancel-order').attr('disabled', false);
                        $('#prescription-content .stop-order, #prescription-content-ipad .stop-order').attr('disabled', true);
                    } else if (status == 1 || status == 9) {
                        $('#prescription-content .stop-order, #prescription-content-ipad .stop-order, #prescription-content .cancel-order, #prescription-content-ipad .cancel-order').attr('disabled', false);
                        $('#prescription-content .send-to-pump, #prescription-content-ipad .send-to-pump').attr('disabled', true);
                    } else if (status == 7) {
                        $('#prescription-content .stop-order, #prescription-content-ipad .stop-order, #prescription-content .cancel-order, #prescription-content-ipad .cancel-order').attr('disabled', false);
                        $('#prescription-content .send-to-pump, #prescription-content-ipad .send-to-pump').attr('disabled', true);
                    }
                }
            }
        } else {
            check_box_element.prop('checked', false);
            check_box_selected_count--;
            disableOrderBtn();
        }
    });
    $(document).on('click', '#prescription-content .send-to-pump, #prescription-content-ipad .send-to-pump', function () {
        var status_type = 'SENDTOPUMP';
        var working_weight = $('input[name="working_wgt"]').val();
        var selected_box = $('.addAction > input[name="send_list[]"]:checked');
        var pres_dtl = selected_box.val();
        var drug_type = selected_box.attr("data-drug-type");
        var drug_list = pres_dtl + ':' + drug_type;
        var col_date = selected_box.parents('.syringe-pump-status').attr("data-col-date");
        var drug_hdr_id = selected_box.parents('tbody').attr('id').replace(/[a-zA-z-]/g, '');
        if (drug_type == 'ORAL') {
            $('#confirm-modal #pump-type-selection').addClass('hide').removeClass('active');
        } else {
            getPumpDetails();
            activateDeviceInterval();
            $('#confirm-modal #pump-type-selection').removeClass('hide').addClass('active');
        }
        $('input[name="drug_list"]').val(drug_list);
        $('input[name="hdr_id"]').val(drug_hdr_id);
        $('input[name="status_type"]').val(status_type);
        $('input[name="working_weight"]').val(working_weight);
        var date_content = modalOrderDate(col_date);
        var current_date = date_content.current_date;
        var hours = date_content.hours;
        var minutes = date_content.minutes;
        var session = date_content.session;
        $('input[name="confirm_datetime"]').datepicker('destroy');
        $('input[name="confirm_datetime"]').datepicker({
            dateFormat: "dd-mm-yy",
            minDate: current_date
        }).val(current_date);
        $('select[name="confirm_time"]').val(hours);
        $('select[name="confirm_mins"]').val(minutes);
        $('select[name="confirm_session"]').val(session);
        $('#pres-cross-verify-content').removeClass('display-none-must');
        $('#pres-cross-verify').removeClass('display-none-must');
        var prescription_hdr_id = drug_hdr_id;
        var tab_name = $(".tab-pane.active").attr('id');
        if (tab_name == 'regulardrug' || tab_name == 'requireddrug' || tab_name == 'statdrug') {
            if (tab_name == 'regulardrug') {
                var element_body = $('#regular-' + prescription_hdr_id);
                var frequency = element_body.find('.regfrequency .main-text').html();
                var instruction = element_body.find('.instruction .main-text').html();
            } else if (tab_name == 'requireddrug') {
                var element_body = $('#required-' + prescription_hdr_id);
                var frequency = element_body.find('.frequency .main-text').html();
                var instruction = element_body.find('.add-ins .main-text').html();
            } else if (tab_name == 'statdrug') {
                var element_body = $('#stat-' + prescription_hdr_id);
                var frequency = element_body.find('.frequency .main-text').html();
                var instruction = element_body.find('.add-ins .main-text').html();
            }
            var drug = element_body.find('.main-text.over-dose-highlighter').html();
            var dose = element_body.find('.dose .main-text').html();
            var route = element_body.find('.route .main-text').html();
        } else if (tab_name == 'intravenous') {
            var element_body = $('#intravenous-' + prescription_hdr_id);
            var drug = element_body.find('.over-dose-highlighter').html();
            var volume = element_body.find('.intravenous-list td:nth-child(5)').html();
            var drug_added = element_body.find('.intravenous-list td:nth-child(6)').html();
            var dose = element_body.find('.intravenous-list td:nth-child(7)').html();
            var rate = element_body.find('.intravenous-list td:nth-child(8)').html();
            var instruction = element_body.find('.additional-instruction').html();
        }
        var template = prescriptionCrossVerifyTemplate(drug, dose, route, instruction, frequency, volume, drug_added, rate);
        $('#pres-cross-verify').html(template);
        openModal('confirm-modal');
        $('#confirm-btn').attr('disabled', false);
        $('#update-confirm-btn').attr('disabled', false);
        $('#confirm-modal .modal-footer button.btn-primary').attr('id', 'confirm-btn');
    });
    $(document).on('click', '#prescription-content .stop-order, #prescription-content-ipad .stop-order', function () {
        var status_type = 'STOP_ORDER';
        var working_weight = $('input[name="working_wgt"]').val();
        var selected_box = $('.addAction > input[name="send_list[]"]:checked');
        var pres_dtl = selected_box.val();
        var drug_type = selected_box.attr("data-drug-type");
        var drug_list = pres_dtl + ':' + drug_type;
        var col_date = selected_box.parents('.syringe-pump-status').attr("data-col-date");
        var infused = selected_box.parents('.syringe-pump-status').attr("data-drug-infused");
        var drug_hdr_id = selected_box.parents('tbody').attr('id').replace(/[a-zA-z-]/g, '');
        $('input[name="drug_list"]').val(drug_list);
        $('input[name="hdr_id"]').val(drug_hdr_id);
        $('input[name="status_type"]').val(status_type);
        $('input[name="working_weight"]').val(working_weight);
        var date_content = modalOrderDate(col_date);
        var current_date = date_content.current_date;
        var hours = date_content.hours;
        var minutes = date_content.minutes;
        var session = date_content.session;
        $('input[name="stop_datetime"]').datepicker('destroy');
        $('input[name="stop_datetime"]').datepicker({
            dateFormat: "dd-mm-yy",
            minDate: current_date
        }).val(current_date);
        $('select[name="stop_time"]').val(hours);
        $('select[name="stop_mins"]').val(minutes);
        $('select[name="stop_session"]').val(session);
        $('textarea[name="stop_reason"]').val('');
        infused = (typeof infused != 'undefined' && infused != null) ? infused : "";
        var infusedtype = (infused == "") ? "" : 1;
        $('input[name="total_ml"]').val(infused);
        $('select[name="total_type"]').val(infusedtype);
        openModal('stop-modal');
        $('#stop-btn').attr('disabled', false);
        $('#update-stop-btn').attr('disabled', false);
        $('#stop-modal .modal-footer button').attr('id', 'stop-btn');
    });
    $(document).on('click', '#prescription-content .cancel-order, #prescription-content-ipad .cancel-order', function () {
        var status_type = 'CANCEL_ORDER';
        var working_weight = $('input[name="working_wgt"]').val();
        var selected_box = $('.addAction > input[name="send_list[]"]:checked');
        var pres_dtl = selected_box.val();
        var drug_type = selected_box.attr("data-drug-type");
        var drug_list = pres_dtl + ':' + drug_type;
        var col_date = selected_box.parents('.syringe-pump-status').attr("data-col-date");
        var drug_hdr_id = selected_box.parents('tbody').attr('id').replace(/[a-zA-z-]/g, '');
        $('input[name="drug_list"]').val(drug_list);
        $('input[name="hdr_id"]').val(drug_hdr_id);
        $('input[name="status_type"]').val(status_type);
        $('input[name="working_weight"]').val(working_weight);
        var date_content = modalOrderDate(col_date);
        var current_date = date_content.current_date;
        var hours = date_content.hours;
        var minutes = date_content.minutes;
        var session = date_content.session;
        $('input[name="cancel_datetime"]').datepicker('destroy');
        $('input[name="cancel_datetime"]').datepicker({
            dateFormat: "dd-mm-yy",
            minDate: current_date
        }).val(current_date);
        $('select[name="cancel_time"]').val(hours);
        $('select[name="cancel_mins"]').val(minutes);
        $('select[name="cancel_session"]').val(session);
        $('textarea[name="cancel_reason"]').val('');
        openModal('cancel-modal');
        $('#cancel-btn').attr('disabled', false);
        $('#update-cancel-btn').attr('disabled', false);
        $('#cancel-modal .modal-footer button').attr('id', 'cancel-btn');
    });
    $(document).on('click', '#prescription-content .resend-prescription, #prescription-content-ipad .resend-prescription', function () {
        var drugId = $(this).attr('data-resend-id');
        var selected_box = $('.addAction > input[name="send_list[]"]:checked');
        var col_date = selected_box.parents('.syringe-pump-status').attr("data-col-date");
        var drug_hdr_id = selected_box.parents('tbody').attr('id').replace(/[a-zA-z-]/g, '');
        $('input[name="hdr_id"]').val(drug_hdr_id);
        var date_content = modalOrderDate(col_date);
        var current_date = date_content.current_date;
        var hours = date_content.hours;
        var minutes = date_content.minutes;
        var session = date_content.session;
        $('input[name="resend_datetime"]').datepicker('destroy');
        $('input[name="resend_datetime"]').datepicker({
            dateFormat: "dd-mm-yy",
            minDate: current_date
        }).val(current_date);
        $('select[name="resend_time"]').val(hours);
        $('select[name="resend_mins"]').val(minutes);
        $('select[name="resend_session"]').val(session);
        openModal('resend-modal');
        $("#resend-order-btn").attr('disabled', false);
        $("#resend-modal input[name='resend_id']").val(drugId);
        deactivateDeviceInterval();
        activateDeviceInterval();
        $('#resend-modal #pump-type-selection').removeClass('hide').addClass('active');
    });
    $(document).on('click', '.sign-align .confirm-date', function () {
        var pres_id = '<input type="hidden" name="pres_id" value="' + $(this).parents('.syringe-pump-status').attr('data-pres') + '" />';
        $('#confirm-modal form').append(pres_id);
        var col_date = $(this).parents('.syringe-pump-status').attr("data-col-date");
        var confirm_date = $(this).attr('data-date');
        var confirm_hour = $(this).attr('data-hour');
        var confirm_minute = $(this).attr('data-minute');
        var confirm_session = $(this).attr('data-session');
        var date_content = modalOrderDate(col_date);
        var current_date = date_content.current_date;
        var hours = date_content.hours;
        var minutes = date_content.minutes;
        var session = date_content.session;
        if (confirm_date != null && typeof confirm_date != 'undefined') {
            var session = confirm_session;
            var hours = confirm_hour;
            var minutes = confirm_minute;
            var current_date = confirm_date;
        }
        $('input[name="confirm_datetime"]').datepicker('destroy');
        $('input[name="confirm_datetime"]').datepicker({
            dateFormat: "dd-mm-yy",
            minDate: current_date
        }).val(current_date);
        $('select[name="confirm_time"]').val(hours);
        $('select[name="confirm_mins"]').val(minutes);
        $('select[name="confirm_session"]').val(session);
        openModal('confirm-modal');
        $('#confirm-btn').attr('disabled', false);
        $('#update-confirm-btn').attr('disabled', false);
        $('#confirm-modal .modal-footer button.btn-primary').attr('id', 'update-confirm-btn');
        $('#pres-cross-verify').addClass('display-none-must');
        $('#pres-cross-verify-content').addClass('display-none-must');
    });
    $(document).on('click', '.sign-align1 .cancel-date', function () {
        var pres_id = '<input type="hidden" name="pres_id" value="' + $(this).parents('.syringe-pump-status').attr('data-pres') + '" />';
        $('#cancel-modal form').append(pres_id);
        var col_date = $(this).parents('.syringe-pump-status').attr("data-col-date");
        var cancel_date = $(this).attr('data-date');
        var cancel_hour = $(this).attr('data-hour');
        var cancel_minute = $(this).attr('data-minute');
        var cancel_session = $(this).attr('data-session');
        var date_content = modalOrderDate(col_date);
        var current_date = date_content.current_date;
        var hours = date_content.hours;
        var minutes = date_content.minutes;
        var session = date_content.session;
        if (cancel_date != null && typeof cancel_date != 'undefined') {
            var session = cancel_session;
            var hours = cancel_hour;
            var minutes = cancel_minute;
            var current_date = cancel_date;
        }
        $('input[name="cancel_datetime"]').datepicker('destroy');
        $('input[name="cancel_datetime"]').datepicker({
            dateFormat: "dd-mm-yy",
            minDate: current_date
        }).val(current_date);
        $('select[name="cancel_time"]').val(hours);
        $('select[name="cancel_mins"]').val(minutes);
        $('select[name="cancel_session"]').val(session);
        openModal('cancel-modal');
        $('#cancel-btn').attr('disabled', false);
        $('#update-cancel-btn').attr('disabled', false);
        $('#cancel-modal .modal-footer button').attr('id', 'update-cancel-btn');
    });
    $(document).on('click', '.sign-align1 .stop-date', function () {
        var pres_id = '<input type="hidden" name="pres_id" value="' + $(this).parents('.syringe-pump-status').attr('data-pres') + '" />';
        $('#stop-modal form').append(pres_id);
        var col_date = $(this).parents('.syringe-pump-status').attr("data-col-date");
        var infused = $(this).attr('data-infused');
        infused = infused.split(' ');
        $('textarea[name="stop_reason"]').val($(this).attr('data-reason'));
        $('input[name="total_ml"]').val(infused[0]);
        $('select[name="total_type"]').val(infused[1]);
        var stop_date = $(this).attr('data-date');
        var stop_hour = $(this).attr('data-hour');
        var stop_minute = $(this).attr('data-minute');
        var stop_session = $(this).attr('data-session');
        var date_content = modalOrderDate(col_date);
        var current_date = date_content.current_date;
        var hours = date_content.hours;
        var minutes = date_content.minutes;
        var session = date_content.session;
        if (stop_date != null && typeof stop_date != 'undefined') {
            var session = stop_session;
            var hours = stop_hour;
            var minutes = stop_minute;
            var current_date = stop_date;
        }
        $('input[name="stop_datetime"]').datepicker('destroy');
        $('input[name="stop_datetime"]').datepicker({
            dateFormat: "dd-mm-yy",
            minDate: current_date
        }).val(current_date);
        $('select[name="stop_time"]').val(hours);
        $('select[name="stop_mins"]').val(minutes);
        $('select[name="stop_session"]').val(session);
        openModal('stop-modal');
        $('#stop-btn').attr('disabled', false);
        $('#update-stop-btn').attr('disabled', false);
        $('#stop-modal .modal-footer button').attr('id', 'update-stop-btn');
    });

    function modalOrderDate(col_date) {
        var currentDate = new Date();
        if (typeof col_date !== 'undefined') {
            col_date = col_date.split('-');
            var date = col_date[1];
            var month = col_date[0];
            var year = col_date[2];
        } else {
            var date = dateFormatter(currentDate);
            var month = monthFormatter(currentDate);
            var year = currentDate.getFullYear();
        }
        var hours = hourFormatter(currentDate, false);
        var minutes = minuteFormatter(currentDate, false);
        var session = sessionFormatter(currentDate);
        var current_date = date + '-' + month + '-' + year;
        return {
            current_date: current_date,
            hours: hours,
            minutes: minutes,
            session: session
        }
    }

    function prescriptionCrossVerifyTemplate(drug, dose, route = '', instruction = '', frequency = '', volume = '', drug_added = '', rate = '') {
        var template = '<table class="table table-bordered table-responsive">';
        template += '<tbody>';
        template += '<tr>';
        template += '<td colspan="4">';
        template += '<div>Drug</div>';
        template += '<div class="pl-15">' + drug + '</div>';
        template += '</td>';
        template += '</tr>';
        template += '<tr>';
        template += '<td>';
        template += '<div>Dose / Required</div>';
        template += '<div class="pl-15">' + dose + '</div>';
        template += '</td>';
        if (frequency != '' || route != '') {
            template += '<td>';
            template += '<div>Frequency</div>';
            template += '<div class="pl-15">' + frequency + '</div>';
            template += '</td>';
            template += '<td>';
            template += '<div>Route</div>';
            template += '<div class="pl-15">' + route + '</div>';
            template += '</td>';
        } else if (volume != '' && rate != '') {
            template += '<td>';
            template += '<div>Volume</div>';
            template += '<div class="pl-15">' + volume + '</div>';
            template += '</td>';
            template += '<td>';
            template += '<div>Rate (ml/hr)</div>';
            template += '<div class="pl-15">' + rate + '</div>';
            template += '</td>';
        }
        template += '</tr>';
        if (drug_added != '') {
            template += '<tr>';
            template += '<td colspan="4">';
            template += '<div>Drug Added</div>';
            template += '<div class="pl-15">' + drug_added + '</div>';
            template += '</td>';
            template += '</tr>';
        }
        template += '<tr>';
        template += '<td colspan="4">';
        template += '<div>Additional Instructions</div>';
        template += '<div class="pl-15">' + instruction + '</div>';
        template += '</td>';
        template += '</tr>';
        template += '</tbody>';
        template += '</table>';
        return template;
    }
    $(document).on('click', '#confirm-btn', function () {
        $('#confirm-btn').attr('disabled', true);
        deactivateDeviceInterval();
        if (!$('#confirm-modal #pump-type-selection').hasClass('hide')) {
            if ($('#confirm-modal #pump_device_ids').val() == '' || $('#confirm-modal #pump_device_ids').val() == '-- Select pump --' || $('#confirm-modal #pump_device_ids').val() == '0') {
                $('#confirm-modal select[name="order_pump_device_id"]').addClass('error');
                $('#confirm-modal select[name="order_pump_device_id"]').parents('#confirm-modal #pump-type-selection').find('span').html('Please select pump').addClass('error-message');
                $('#confirm-modal .btn i').remove();
                return false;
            }
        }
        var serial = $($("#confirm-post")[0].elements).serializeArray();
        var modal_id = {
            'name': 'modal_id',
            'value': $('input[name="drug_list"]').val()
        };
        serial.push(modal_id);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            data: serial,
            url: site_url + '/prescription-status-changes',
            success: function (response) {
                if (response.messageType != 'error') {
                    updateStatusBlock(response.data);
                    closeModal('confirm-modal');
                    removeChecked();
                }
                Showalert(response.type, response.message);
            }
        });
        disableOrderBtn();
    });
    $(document).on('click', '#stop-btn', function () {
        $('#stop-btn').attr('disabled', true);
        var serial = $($("#stop-post")[0].elements).serializeArray();
        var modal_id = {
            'name': 'modal_id',
            'value': $('input[name="drug_list"]').val()
        };
        serial.push(modal_id);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            data: serial,
            url: site_url + '/prescription-status-changes',
            success: function (response) {
                if (response.messageType != 'error') {
                    updateStatusBlock(response.data);
                    closeModal('stop-modal');
                    removeChecked();
                } else {
                    $('#stop-btn').attr('disabled', false);
                }
                Showalert(response.messageType, response.message);
            }
        });
        disableOrderBtn();
    });
    $(document).on('click', '#cancel-btn', function () {
        $('#cancel-btn').attr('disabled', true);
        var serial = $($("#cancel-post")[0].elements).serializeArray();
        var modal_id = {
            'name': 'modal_id',
            'value': $('input[name="drug_list"]').val()
        };
        serial.push(modal_id);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            data: serial,
            url: site_url + '/prescription-status-changes',
            success: function (response) {
                if (response.messageType != 'error') {
                    updateStatusBlock(response.data);
                    closeModal('cancel-modal');
                    removeChecked();
                }
                Showalert(response.type, response.message);
            }
        });
        disableOrderBtn();
    });
    $(document).on('click', '#resend-order-btn', function () {
        $("#resend-order-btn").attr('disabled', true);
        deactivateDeviceInterval();
        if (!$('#resend-modal #pump-type-selection').hasClass('hide')) {
            if ($('#resend-modal #pump_device_ids').val() == '' || $('#resend-modal #pump_device_ids').val() == '-- Select pump --' || $('#resend-modal #pump_device_ids').val() == '0') {
                $('#resend-modal select[name="order_pump_device_id"]').addClass('error');
                $('#resend-modal select[name="order_pump_device_id"]').parents('#resend-modal #pump-type-selection').find('span').html('Please select pump').addClass('error-message');
                $('#resend-modal .btn i').remove();
                return false;
            }
        }
        var serial = $($("#resend-post")[0].elements).serializeArray();
        var modal_id = {
            'name': 'modal_id',
            'value': $('input[name="resend_id"]').val()
        };
        serial.push(modal_id);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            data: serial,
            url: site_url + '/resend',
            success: function (response) {
                if (response.type == 'success') {
                    Showalert(response.type, response.message);
                    $('#prescription-content .resend-prescription, #prescription-content-ipad .resend-prescription').attr('data-resend-id', response.new_id);
                    $('#drug-id-' + response.old_id).attr('data-pres', response.new_id);
                    $('#drug-id-' + response.old_id).attr('data-advice-id', response.advice_id);
                    $('#drug-id-' + response.old_id).attr('data-device_id', response.order_pump_device_id);
                    $('#drug-id-' + response.old_id).attr('id', 'drug-id-' + response.new_id);
                    $('.syringe-checkbox-' + response.old_id).addClass('syringe-checkbox-' + response.new_id).removeClass('syringe-checkbox-' + response.old_id);
                    $('.syringe-checkbox-' + response.new_id).val(response.new_id);
                    $('#prescription-content .send-to-pump, #prescription-content-ipad .send-to-pump').show();
                    $('#prescription-content .resend-prescription, #prescription-content-ipad .resend-prescription').hide();
                    disableOrderBtn();
                    removeChecked();
                    closeModal('resend-modal');
                    $('#resend-modal select[name="order_pump_device_id"]').removeClass('error');
                    $('#resend-modal select[name="order_pump_device_id"]').parents('#resend-modal #pump-type-selection').find('span').html('').removeClass('error-message');
                } else {
                    bootbox.confirm("Prescription resending is failed. Please, reload the page.", function (confirmed) {
                        if (confirmed) {
                            location.reload();
                        }
                        $('input[name="send_list[]"]').attr('checked', false);
                    });
                }
            }
        });
    });
    $(document).on('click', '#update-confirm-btn', function () {
        $('#update-confirm-btn').attr('disabled', true);
        var serial = $($("#confirm-post")[0].elements).serializeArray();
        var added_content = {
            'name': 'admission_id',
            'value': admission_id
        };
        serial.push(added_content);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            data: serial,
            url: site_url + '/change-prescription-time',
            success: function (response) {
                if (response.type == 'success') {
                    editStatusBlock(response.data);
                    closeModal('confirm-modal');
                }
            }
        });
        disableOrderBtn();
    });
    $(document).on('click', '#update-stop-btn', function () {
        $('#update-stop-btn').attr('disabled', true);
        var serial = $($("#stop-post")[0].elements).serializeArray();
        var added_content = {
            'name': 'admission_id',
            'value': admission_id
        };
        serial.push(added_content);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            data: serial,
            url: site_url + '/change-prescription-time',
            success: function (response) {
                if (response.type == 'success') {
                    editStatusBlock(response.data);
                    closeModal('stop-modal');
                }
            }
        });
        disableOrderBtn();
    });
    $(document).on('click', '#update-cancel-btn', function () {
        $('#update-cancel-btn').attr('disabled', true);
        var serial = $($("#cancel-post")[0].elements).serializeArray();
        var added_content = {
            'name': 'admission_id',
            'value': admission_id
        };
        serial.push(added_content);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            data: serial,
            url: site_url + '/change-prescription-time',
            success: function (response) {
                if (response.type == 'success') {
                    editStatusBlock(response.data);
                    closeModal('cancel-modal');
                }
            }
        });
        disableOrderBtn();
    });

    function getPumpDetails() {
        if (!device_interval_function_call) {
            device_interval_function_call = true;
            var pump_type = $('input[name="order_pump_type"]').val();
            var admission_id = $('input[name="admission_id"]').val();
            if (pump_type && admission_id && admission_id != '' && pump_type == 'e-n-series') {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "GET",
                    data: {
                        admission_id: admission_id
                    },
                    url: site_url + '/get-pump-list',
                    success: function (response) {
                        var device_html = '<option value="0">-- Select pump --</option>';
                        var selectedDevice = $('#pump-type-selection.active #pump_device_ids').val();
                        if (typeof response.results != 'undefined' && response.results.length > 0) {
                            $.each(response.results, function (index, value) {
                                var device_id = value.device_id;
                                device_id = device_id.match(/.{1,2}/g);
                                if ($.isArray(device_id) && device_id.length > 0) {
                                    device_id = device_id.join('-');
                                } else {
                                    device_id = [];
                                }
                                if (device_id == selectedDevice) {
                                    device_html += '<option value="' + device_id + '" selected>' + value.pump_order + '</option>';
                                }
                                else {
                                    device_html += '<option value="' + device_id + '">' + value.pump_order + '</option>';
                                }
                            });
                            $('#pump-type-selection.active #pump_device_ids').html(device_html);
                        }
                        else {
                            $('#pump-type-selection.active #pump_device_ids').html('<option value="0">-- Select pump --</option>');
                            Showalert(response.type, response.message);
                        }
                        device_interval_function_call = false;
                    },
                    error: function () {
                        device_interval_function_call = false;
                    },
                    complete: function () {
                        device_interval_function_call = false;
                    }
                });
            }
        }
    }

    function activateDeviceInterval() {
        getDeviceDetailsByInterval = setInterval(function () {
            getPumpDetails();
        }, 2000);
    }

    function deactivateDeviceInterval() {
        clearInterval(getDeviceDetailsByInterval);
    }
    $(document).on('click', '.confirm-sign, .stop-sign', function () {
        var infused = $(this).parents('.syringe-pump-status').find('.stop-date').attr('data-infused');
        if (typeof infused != 'undefined') {
            infused = infused.split(' ')[0];
        }
        var advice_id = $(this).parents('.syringe-pump-status').attr('data-advice-id');
        statusList(advice_id, infused);
    });

    function statusList(adviceid, manualinfused = '') {
        var bmrno = $('#BMrNo').val();
        if ($('#ip_number').val() != '') {
            var ip_number = $('#ip_number').val();
        } else {
            var ip_number = 0;
        }
        $('#export-excel').attr('data-export-id', adviceid);
        $('#export-excel').attr('data-bmr-no', bmrno);
        $('#export-excel').attr('data-ip-number', ip_number);
        $('#export-excel').attr('data-baby-id', baby_id);
        $('#export-excel').attr('data-admission-id', admission_id);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            url: site_url + '/prescription-log',
            data: {
                advice_id: adviceid,
                BMrNo: bmrno,
                ip_number: ip_number,
                baby_id: baby_id,
                admission_id: admission_id
            },
            beforeSend: function () { },
            success: function (responseText) {
                $('.status_log').html('');
                var j = 1;
                var k = 1;
                var rate_compare = date_compare = log = '';
                var changeStatus = [];
                var resource_value = [];
                var totalinfused;
                var log_value = [];
                var response_data = responseText.resource.data;
                if (typeof response_data != 'undefined') {
                    $.each(response_data, function (key, value) {
                        if (typeof value == "object") {
                            drug_name = responseText.resource.drug_name;
                            vtbi = responseText.resource.vtbi;
                            infused = value.infused;
                            remaining = value.remain_volume;
                            rate = value.rate;
                            dateTime = value.result_time.replace(/\s/, 'T');
                            dateTime = new Date(dateTime);
                            date = dateFormatter(dateTime);
                            month = monthFormatter(dateTime);
                            year = dateTime.getFullYear();
                            hours = dateTime.getHours();
                            hours = hours > 9 ? hours : '0' + hours;
                            minutes = minuteFormatter(dateTime);
                            dateTime = date + '-' + month + '-' + year + ' ' + hours + ':' + minutes;
                            if (typeof (value.status) !== "undefined") {
                                if (rate_compare == '' || rate_compare == rate) {
                                    date_compare = dateTime;
                                    rate_compare = value.rate;
                                } else {
                                    changeStatus.push(date_compare);
                                    date_compare = dateTime;
                                    rate_compare = value.rate;
                                }
                            }
                            running_pressure = value.pressure;
                            programme_pressure = value.pressure_level;
                            if (value.status == 0) {
                                infusion_status = 'Infusing';
                            } else if (value.status == 1) {
                                infusion_status = 'Pause';
                            } else if (value.status == 2 || value.status == 3) {
                                infusion_status = 'Stop';
                            }
                            totalinfused = infused;
                            $('#drugName').html(drug_name + " <span style='font-size: 10px; font-weight: bold;'></span>");
                            var prescriptionlog = '<td class="text-center">' + dateTime + '</td>';
                            prescriptionlog += '<td class="text-center"><strong>' + parseFloat(infused).toFixed(2) + '</strong></td>';
                            prescriptionlog += '<td class="text-center"><strong>' + parseFloat(remaining).toFixed(2) + '</strong></td>';
                            prescriptionlog += '<td class="text-center">' + parseFloat(rate).toFixed(2) + '</td>';
                            prescriptionlog += '<td class="text-center">' + running_pressure + '</td>';
                            log += '<tr data-rate-change="' + dateTime + '" id="widget-collapse-' + j + '">' + prescriptionlog + '</tr>';
                            $('.status_log').prepend('<tr data-rate-change="' + dateTime + '" id="widget-collapse-' + j + '">' + prescriptionlog + '</tr>');
                            j++;
                        }
                    });
                    if (log != '') {
                        openModal('status-modal');
                    }
                    totalinfused = totalinfused != '' ? parseFloat(totalinfused).toFixed(2) : '';
                    $('.machine-val').html(totalinfused);
                    manualinfused = manualinfused != '' ? parseFloat(manualinfused).toFixed(2) : '';
                    $('.manual-val').html(manualinfused);
                    $.each(changeStatus, function (key, value) {
                        for (var i = 1; i < j; i++) {
                            var log_rate = $('#widget-collapse-' + i).attr("data-rate-change");
                            if (log_rate == value) {
                                $('#widget-collapse-' + i + ' td').addClass('error');
                            }
                        }
                    });
                }
            }
        });
    }
    $('#export-excel').click(function () {
        var babyMrn = $(this).attr('data-bmr-no');
        var babyIpNumber = $(this).attr('data-ip-number');
        var baseId = $(this).attr('data-export-id');
        var babyId = $(this).attr('data-baby-id');
        var admissionId = $(this).attr('data-admission-id');
        window.location = site_url + '/downloads-prescription' + '/' + babyMrn + '/' + baseId + '/' + babyId + '/' + admissionId;
    });
    $(document).on('click', '.review-date-update', function () {
        if (typeof user_role != 'undefined' && (user_role == super_admin_role || user_role == admin_role)) {
            var old_review_date = $(this).attr('data-review-date');
            var prescription_hdr_id = $(this).attr('data-hdr-id');
            var sno = $(this).attr('data-sno');
            $('input[name="prescription_hdr_id"]').val(prescription_hdr_id);
            $('input[name="old_review_date"]').val(old_review_date);
            $('input[name="sno"]').val(sno);
            var mindate = (old_review_date.split(' ')[0]).replace(/\//g, "-");
            $('input[name="review_date"]').datepicker('destroy');
            $('input[name="review_date"]').datepicker({
                dateFormat: "dd-mm-yy",
                minDate: mindate
            }).val(mindate);
            if (old_review_date != '') {
                openModal('review-update-modal');
                $('#review-update-btn').attr('disabled', false);
            }
        }
    });
    $(document).on('click', '#review-update-btn', function () {
        $('#review-update-btn').attr('disabled', true);
        var serial = $($("#review-post")[0].elements).serializeArray();
        var modal_id = {
            'name': 'review_modal_id',
            'value': $('#review-update-modal input[name="prescription_hdr_id"]').val()
        };
        serial.push(modal_id);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            data: serial,
            url: site_url + '/review-date-update',
            success: function (response) {
                updatePrescriptionBlock(response.data);
                closeModal('review-update-modal');
                Showalert(response.messageType, response.message);
            }
        });
    });
    $(document).on('click', '.discontinue-drug', function () {
        var id = $(this).attr('data-id');
        $('input[name="drug_id"]').val(id);
        var drug_date = new Date();
        var date = dateFormatter(drug_date);
        var month = monthFormatter(drug_date);
        var year = drug_date.getFullYear();
        var hours = hourFormatter(drug_date, false);
        var minutes = minuteFormatter(drug_date, false);
        var ampm = sessionFormatter(drug_date);
        var drugdate = date + '-' + month + '-' + year;
        $('input[name="terminate_datetime"]').val(drugdate);
        $('input[name="terminate_datetime"]').datepicker({
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
            minDate: drug_date
        }).val(drugdate);
        $('select[name="terminate_time"]').val(hours);
        $('select[name="terminate_mins"]').val(minutes);
        $('select[name="terminate_session"]').val(ampm);
        $('textarea[name="terminate_reason"]').val('');
        openModal('terminate-modal');
        $('#terminate-btn').attr('disabled', false);
    });
    $(document).on('click', '#terminate-btn', function () {
        $('#terminate-btn').attr('disabled', true);
        var drug_id = $('input[name="drug_id"]').val();
        var serial = $($("#terminate-post")[0].elements).serializeArray();
        var terminate_modal_id = {
            'name': 'terminate_modal_id',
            'value': $('#terminate-modal input[name="drug_id"]').val()
        };
        serial.push(terminate_modal_id);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            data: serial,
            url: site_url + '/terminate-prescription',
            success: function (response) {
                if (response.type == 'success') {
                    updatePrescriptionBlock(response.data);
                    closeModal('terminate-modal');
                }
            }
        });
    });

    function disableOrderBtn() {
        $('#prescription-content .stop-order, #prescription-content-ipad .stop-order, #prescription-content .cancel-order, #prescription-content-ipad .cancel-order, #prescription-content .send-to-pump, #prescription-content-ipad .send-to-pump, #prescription-content .resend-prescription, #prescription-content-ipad .resend-prescription').attr('disabled', true);
        check_box_selected_count = 0;
    }

    function removeChecked() {
        $('input[name="send_list[]"]').attr('checked', false);
    }

    function openModal(id) {
        $('#' + id).modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
    }

    function closeModal(id) {
        $('#' + id).modal('hide');
        $('input[name="drug_list"]').val('');
        $('input[name="status_type"]').val('');
    }
    $(document).on('click', '#baby-info-more', function () {
        $('#baby-info').modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
    });
    $(document).on('click', '#pump-info-more', function () {
        $('#pump-info').modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
    });
    $('#close-btn, #resend-close-btn, .close').on('click', function () {
        var modal_id = $(this).parents('.modal.in').attr('id');
        closeModal(modal_id);
        removeChecked();
        disableOrderBtn();
    });
    $(document).on("click", ".prescription-print", function () {
        $(this).attr("disabled", true);
        if ($(this).attr('data-closewinlink') == '') {
            var closewinlink = 'prescription';
        } else {
            var closewinlink = $(this).attr('data-closewinlink');
        }
        window.location.href = site_url + '/prescription-print/' + $(this).attr('data-baby-id') + '/' + $(this).attr('data-admission-id') + '/' + $(this).attr('data-selected-date') + '/' + closewinlink;
    });
    $(document).on('click', '.discharge-patient', function () {
        var babyId = $(this).attr('data-patient-baby-id');
        var admissionId = $(this).attr('data-patient-admission-id');
        var bedId = $(this).attr('data-patient-bed-id');
        var slug = 'REMOVE_PUMP';
        bootbox.confirm("Are you sure you want to disconnect the pump ?", function (confirmed) {
            if (confirmed) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'PATCH',
                    data: {
                        babyId: babyId,
                        admissionId: admissionId,
                        slug: slug,
                        bedId: bedId
                    },
                    url: site_url + '/syrange-pump-request/0',
                    success: function (response) {
                        $('#prescription-content .discharge-patient').addClass('connect-patient').removeClass('discharge-patient').text('Connect Pump');
                        $('#prescription-content-ipad .discharge-patient').addClass('connect-patient').removeClass('discharge-patient').text('Connect');
                    }
                });
            }
        });
    });
    $(document).on('click', '.connect-patient', function () {
        var babyId = $(this).attr('data-patient-baby-id');
        var admissionId = $(this).attr('data-patient-admission-id');
        var bedId = $(this).attr('data-patient-bed-id')
        var slug = 'CONNECT_PUMP';
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'PATCH',
            data: {
                babyId: babyId,
                admissionId: admissionId,
                slug: slug,
                bedId: bedId
            },
            url: site_url + '/syrange-pump-request/0',
            success: function (response) {
                $('#prescription-content .connect-patient').addClass('discharge-patient').removeClass('connect-patient').text('Disconnect Pump');
                $('#prescription-content-ipad .connect-patient').addClass('discharge-patient').removeClass('connect-patient').text('Disconnect');
            }
        });
    });
    //
    //
    //
    //
    //
    //
    if (!$('.navbar-fixed-top > .container > .navbar-nav.navbar-left > li:last-child > a > i').hasClass('fa-plug')) {
        window.Echo.channel('prescription-update-' + admission_id).listen('PrescriptionEvent', function (data) {
            console.log(data);
            var data = data.prescription_log_update;
            switch (data.prescription_from) {
                case 1:
                    updateStatusBlock(data);
                    var received_modal_id = data.modal_id;
                    modalCheckBoxHandling(received_modal_id);
                    break;
                case 2:
                    editStatusBlock(data);
                    break;
                case 3:
                    updatePrescriptionBlock(data);
                    var received_modal_id = data.review_modal_id;
                    if (received_modal_id != undefined) {
                        modalReviewHandling(received_modal_id);
                    }
                    var edit_modal_id = data.edit_modal_id;
                    if (edit_modal_id != undefined) {
                        modalEditHandling(edit_modal_id);
                    }
                    break;
                case 4:
                    updatePrescriptionBlock(data);
                    var terminate_modal_id = data.terminate_modal_id;
                    modalDiscontinueHandling(terminate_modal_id);
                    break;
                case 5:
                    updatePrescriptionBlock(data);
                    break;
                case 7:
                    $('#prescription-content .resend-prescription, #prescription-content-ipad .resend-prescription').attr('data-resend-id', data.new_id);
                    $('#drug-id-' + data.old_id).attr('data-pres', data.new_id);
                    $('#drug-id-' + data.old_id).attr('data-advice-id', data.advice_id);
                    $('#drug-id-' + data.old_id).attr('data-device_id', data.order_pump_device_id);
                    $('#drug-id-' + data.old_id).attr('id', 'drug-id-' + data.new_id);
                    $('.syringe-checkbox-' + data.old_id).addClass('syringe-checkbox-' + data.new_id).removeClass('syringe-checkbox-' + data.old_id);
                    $('.syringe-checkbox-' + data.new_id).val(data.new_id);
                    break;
                default:
                    var working_weight = $('input[name="working_wgt"]').val();
                    if (working_weight != '') {
                        $('input[name="working_wgt"]').val(data.working_weight);
                    }
                    break;
            }
            disableOrderBtn();
            removeChecked();
        });
    }

    function modalCheckBoxHandling(received_modal_id) {
        var modal_attr = $('.prescription-modal-up.in').attr('id');
        if (modal_attr == 'resend-modal') {
            var modal_id = $('.prescription-modal-up.in input[name="resend_id"]').val();
        } else {
            var modal_id = $('.prescription-modal-up.in input[name="drug_list"]').val();
        }
        if (received_modal_id != null && modal_id != null && received_modal_id.replace(/[a-zA-z-]/g, '') == modal_id.replace(/[a-zA-z-]/g, '')) {
            alreadyHappenedAction(modal_attr, check_box_already_done);
        }
    }

    function modalReviewHandling(received_modal_id) {
        if ($('#review-update-modal').hasClass('in')) {
            var modal_id = $('#review-update-modal input[name="prescription_hdr_id"]').val();
            if (received_modal_id != null && received_modal_id == modal_id) {
                alreadyHappenedAction('review-update-modal', review_date_already_done);
            }
        }
    }

    function modalEditHandling(received_modal_id) {
        if ($('#create-drug-modal').hasClass('in')) {
            var modal_id = $('#create-drug-modal input[name="pres_id"]').val();
            if (received_modal_id != null && received_modal_id == modal_id) {
                alreadyHappenedAction('create-drug-modal', edit_already_done);
            }
        }
        if ($('#confirm-modal').hasClass('in')) {
            var modal_id = $('#confirm-modal input[name="hdr_id"]').val();
            if (received_modal_id != null && received_modal_id == modal_id) {
                alreadyHappenedAction('confirm-modal', edit_already_done);
            }
        }
    }

    function modalDiscontinueHandling(received_modal_id) {
        if ($('#terminate-modal').hasClass('in')) {
            var modal_id = $('#terminate-modal input[name="drug_id"]').val();
            if (received_modal_id != null && received_modal_id == modal_id) {
                alreadyHappenedAction('terminate-modal', terminate_already_done);
            }
        }
        modalEditHandling(received_modal_id);
        modalReviewHandling(received_modal_id);
        if ($('#resend-modal').hasClass('in')) {
            var modal_id = $('#resend-modal input[name="hdr_id"]').val();
            if (received_modal_id != null && received_modal_id == modal_id) {
                alreadyHappenedAction('resend-modal', terminate_already_done);
            }
        }
        if ($('#stop-modal').hasClass('in')) {
            var modal_id = $('#stop-modal input[name="hdr_id"]').val();
            if (received_modal_id != null && received_modal_id == modal_id) {
                alreadyHappenedAction('stop-modal', terminate_already_done);
            }
        }
        if ($('#cancel-modal').hasClass('in')) {
            var modal_id = $('#cancel-modal input[name="hdr_id"]').val();
            if (received_modal_id != null && received_modal_id == modal_id) {
                alreadyHappenedAction('cancel-modal', terminate_already_done);
            }
        }
    }

    function alreadyHappenedAction(modal_name, content) {
        closeModal(modal_name);
        if ($("#already-done").hasClass("in")) {
            closeModal('already-done');
        } else {
            $("#already-done").find('h2').html(content);
            openModal('already-done');
        }
    }

    function updateStatusBlock(data) {
        var current_active_id = data.id;
        var active_id = data.active_id;
        var ps_date = $("#drug-id-" + current_active_id).attr('data-col-date');
        var box_color = $("#drug-id-" + current_active_id).hasClass('even-box') ? 'even-box' : ($("#drug-id-" + current_active_id).hasClass('odd-box') ? 'odd-box' : '');
        var terminatecolor = $("#drug-id-" + current_active_id).hasClass('terminate-bg') ? 'terminate-bg' : '';
        var status_content = statusBlock(data, current_active_id, ps_date, box_color, terminatecolor);
        $("#drug-id-" + current_active_id).replaceWith(status_content);
        var action_found = $("#drug-id-" + current_active_id).find('.roundedTwo').hasClass('addAction');
        if (!action_found) {
            $("#drug-id-" + active_id).find('.roundedTwo').addClass('addAction');
        }
        $("#drug-id-" + current_active_id).parents('tbody').find('.pdropdown-content .edit-prescription').addClass('hide');
    }

    function editStatusBlock(data) {
        var element = $('#drug-id-' + data.dtl_id);
        switch (data.stage) {
            case 1:
                element.find('.confirm-date').attr('data-date', data.modified_started_date);
                element.find('.confirm-date').attr('data-hour', data.modified_started_hour);
                element.find('.confirm-date').attr('data-minute', data.modified_started_min);
                element.find('.confirm-date').attr('data-session', data.modified_started_session);
                element.find('.confirm-date b').html(data.modified_started_24hour);
                var user_sign = (user_initial[data.modified_started_user] != null && user_initial[data.modified_started_user] != '' && data.modified_started_user != null) ? user_initial[data.modified_started_user] : no_img_file_name;
                var user_namee = (user_name[data.modified_started_user] != null && user_name[data.modified_started_user] != '' && data.modified_started_user != null) ? user_name[data.modified_started_user] : '';
                element.find('.confirm-sign').replaceWith(startSignBlock(user_sign, user_namee));
                break;
            case 2:
                element.find('.cancel-date').attr('data-date', data.modified_cancel_date);
                element.find('.cancel-date').attr('data-hour', data.modified_cancel_hour);
                element.find('.cancel-date').attr('data-minute', data.modified_cancel_min);
                element.find('.cancel-date').attr('data-session', data.modified_cancel_session);
                element.find('.cancel-date').attr('data-reason', data.modified_cancel_reason);
                element.attr('title', data.modified_cancel_reason);
                element.find('.cancel-date b').html(data.modified_cancel_24hour);
                var user_sign = (user_initial[data.modified_cancelled_user] != null && user_initial[data.modified_cancelled_user] != '' && data.modified_cancelled_user != null) ? user_initial[data.modified_cancelled_user] : no_img_file_name;
                var user_namee = (user_name[data.modified_cancelled_user] != null && user_name[data.modified_cancelled_user] != '' && data.modified_cancelled_user != null) ? user_name[data.modified_cancelled_user] : '';
                element.find('.stop-sign').replaceWith(cancelSignBlock(user_sign, user_namee));
                break;
            case 3:
                element.find('.stop-date').attr('data-date', data.modified_stopped_date);
                element.find('.stop-date').attr('data-hour', data.modified_stopped_hour);
                element.find('.stop-date').attr('data-minute', data.modified_stopped_min);
                element.find('.stop-date').attr('data-session', data.modified_stopped_session);
                element.find('.stop-date').attr('data-reason', data.modified_stop_reason);
                element.attr('title', data.modified_stop_reason);
                element.find('.stop-date').attr('data-infused', data.modified_total_infused);
                element.find('.stop-date b').html(data.modified_stopped_24hour);
                var user_sign = (user_initial[data.modified_stopped_user] != null && user_initial[data.modified_stopped_user] != '' && data.modified_stopped_user != null) ? user_initial[data.modified_stopped_user] : no_img_file_name;
                var user_namee = (user_name[data.modified_stopped_user] != null && user_name[data.modified_stopped_user] != '' && data.modified_stopped_user != null) ? user_name[data.modified_stopped_user] : '';
                element.find('.stop-sign').replaceWith(stopSignBlock(user_sign, user_namee));
                break;
        }
    }

    function updatePrescriptionBlock(data) {
        var tab_type = data.prescription_type;
        var old_tab_type = parseInt(data.old_prescription_type);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            data: {
                baby_id: data.baby_id,
                admission_id: data.admission_id,
                pres_hdr: data.hdr_id
            },
            url: site_url + '/prescription-data',
            success: function (response) {
                if (typeof data.hdr_id != 'undefined' && data.hdr_id != '') {
                    if (tab_type == 3) {
                        var received_data = response.intravenous_prescription_list;
                        var values = received_data[0];
                        var id = values.pres_hdr_id;
                    } else {
                        var received_data = response.prescription_list;
                        var values = received_data[tab_type][0][0];
                        var id = values.hdr_id;
                        var start_date = values.start_date;
                    }
                    var tab_name = '';
                    reloadContentBlock(tab_type, id, values);
                    if (typeof old_tab_type != 'undefined' && old_tab_type != '' && $.isNumeric(old_tab_type) && old_tab_type != tab_type) {
                        reloadTab(response, tab_type);
                        reloadTab(response, old_tab_type);
                    }
                } else {
                    reloadTab(response, tab_type);
                }
            }
        });
    }

    function reloadContentBlock(tab_type, id, values, start_date) {
        switch (tab_type) {
            case 1:
                tab_name = 'regular';
                var sno = $("#" + tab_name + "-" + id + " tr > td:first-child").find('strong').html();
                var regular_val = updateRegularPrescriptionList(values, sno);
                var content = '<tbody id="' + tab_name + '-' + id + '" class="prescription-border-top" data-start-date="' + start_date + '">';
                content += regular_val;
                content += '</tbody>';
                $("#" + tab_name + "-" + id).replaceWith(content);
                break;
            case 2:
                tab_name = 'required';
                var sno = $("#" + tab_name + "-" + id + " tr > td:first-child").find('strong').html();
                var required_val = updateRequiredStatPrescriptionList(values, sno);
                var content = '<tbody id="' + tab_name + '-' + id + '" class="prescription-border-top" data-start-date="' + start_date + '">';
                content += required_val;
                content += '</tbody>';
                $("#" + tab_name + "-" + id).replaceWith(content);
                break;
            case 3:
                tab_name = 'intravenous';
                var sno = $("#" + tab_name + "-" + id + " tr > td:first-child").find('strong').html();
                var intravenous_val = updateIntravenousPrescriptionList(values, sno);
                var content = '<tbody id="' + tab_name + '-' + id + '" class="prescription-border-top">';
                content += intravenous_val;
                content += '</tbody>';
                $("#" + tab_name + "-" + id).replaceWith(content);
                break;
            case 4:
                tab_name = 'stat';
                var sno = $("#" + tab_name + "-" + id + " tr > td:first-child").find('strong').html();
                var required_val = updateRequiredStatPrescriptionList(values, sno);
                var content = '<tbody id="' + tab_name + '-' + id + '" class="prescription-border-top" data-start-date="' + start_date + '">';
                content += required_val;
                content += '</tbody>';
                $("#" + tab_name + "-" + id).replaceWith(content);
                break;
        }
    }

    function reloadTab(data, tab_type) {
        prescription_list = data.prescription_list;
        intravenous_prescription_list = data.intravenous_prescription_list;
        switch (tab_type) {
            case 1:
                $('#regulardrug').html(tableLayoutOfRegular());
                break;
            case 2:
                $('#requireddrug').html(tableLayoutOfRequired());
                break;
            case 3:
                $('#intravenous').html(tableLayoutOfIntravenous());
                break;
            case 4:
                $('#statdrug').html(tableLayoutOfStat());
                break;
        }
    }
});

// Enforce numeric input for fields with 'numeric-only' class
$(document).on('input', '.numeric-only', function () {
    this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');
});
