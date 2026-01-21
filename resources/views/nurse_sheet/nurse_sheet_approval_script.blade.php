<script type = "text/javascript">
$(document).ready(function() {
    var baby_id = $('input[name="baby_id"]').val();
    var admission_id = $('input[name="admission_id"]').val();
    var start_time = $('input[name="start_time"]').val();
    var end_time = $('input[name="end_time"]').val();
    var approval_status = $('input[name="approval_status"]').val();
    $("#content").addClass('nurse-sheet-create');
    var target_spO2_range = <?php echo json_encode(SiteHelpers::ventilatorAutoO2TargetRange()); ?>;
    var target_spO2_range_flip = <?php echo json_encode(array_flip(SiteHelpers::ventilatorAutoO2TargetRange())) ?>;

    function triggerClick(elem) {
        $(elem).click();
        $('.tab-pane.active .tab-sub-content').removeClass('col-md-9').removeClass('col-sm-9');
        $('.tab-pane.active .edit-machine-data').removeClass('col-md-3').removeClass('col-sm-3').removeClass('edit-machine-data-design').html('');
    }
    var progressWizard = $('.stepper'),
        tab_active,
        tab_prev,
        tab_next,
        btn_prev = progressWizard.find('.prev-step'),
        btn_next = progressWizard.find('.next-step'),
        tab_toggle = progressWizard.find('[data-toggle="tab"]'),
        tooltips = progressWizard.find('[data-toggle="tab"][title]');
    tooltips.tooltip();
    btn_next.on('click', function() {
        tab_active = progressWizard.find('.active');
        tab_active.next().removeClass('disabled');
        tab_next = tab_active.next().find('a[data-toggle="tab"]');
        triggerClick(tab_next);
    });
    btn_prev.click(function() {
        tab_active = progressWizard.find('.active');
        tab_prev = tab_active.prev().find('a[data-toggle="tab"]');
        triggerClick(tab_prev);
    });
    var row_approval = false;
    var full_approval = false;
    var column_full_approval = false;

    function approve() {
        var emr_id = [];
        var table_name_list = [];
        var time_list = [];
        var slug = false;
        var current_tab = $('#approval-modal .tab-pane.active').attr('id');
        $('#' + current_tab + ' .machine-data-edit.waiting-approval').each(function() {
            var id = $(this).attr('data-drugid');
            var tablename = $(this).attr('data-tablename');
            var time = $(this).attr('data-time');
            emr_id.push(id);
            table_name_list.push(tablename);
            time_list.push(time);
        });
        if (full_approval) {
            $('.tab-pane.active').html('<div class="p-15 text-center no-data-msg">No pending data found</div>');
            if (approval_status == 1) {
                $('#approval-modal').modal('hide');
                $('#approval-screen').hide();
                $('.print-btn').removeClass('hide');
                $('.nurse-sheet td').removeClass('bg-warninggg');
            }
            if (current_tab == 'stepper-step-1') {
                $('.observation td').removeClass('bg-warninggg');
            } else if (current_tab == 'stepper-step-2') {
                $('.respiratory td').removeClass('bg-warninggg');
            } else if (current_tab == 'stepper-step-3') {
                $('.infusions td').removeClass('bg-warninggg');
            }
            $('input[name="approval_status"]').val(approval_status - 1);
            full_approval = false;
        }
        var table_name = '';
        var updated_column_name = '';
        if (emr_id.length > 0) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'PATCH',
                data: {
                    table_name: table_name_list,
                    emr_data_id: emr_id,
                    time: time_list,
                },
                url: "{{ action('Nurse\NurseSheetController@machineDataApproval') }}",
                beforeSend: function(response) {
                    $('.close-alt').attr('disabled', true);
                },
                success: function(response) {
                    if (response.messageType == 'success') {
                        slug = true;
                        notificationmsg(slug);
                        var display_slug = false;
                        if (display_slug) {
                            if ($('#approval-modal .tab-pane.active tbody tr').length < 1) {
                                var display = parseInt($('#approval-screen').attr('data-display'));
                                if (display > 0) {
                                    display = parseInt(display) - 1;
                                    if (display == 0) {
                                        $('#approval-screen').removeClass('btn-warning').addClass('btn-success');
                                        $('#approval-modal').modal('hide');
                                    }
                                    $('#approval-screen').attr('data-display', display);
                                } else {
                                    $('#approval-screen').removeClass('btn-warning').addClass('btn-success');
                                    $('#approval-modal').modal('hide');
                                }
                                $('#approval-modal .nav-tabs li.active').addClass('completed');
                                $('#approval-modal .nav-tabs li.active .round-tab').addClass('approval-done');
                                $('#approval-modal .nav-tabs li.active > a').addClass('cursor-disabled');
                                $('#approval-modal .tab-pane.active .tab-sub-content').addClass('empty-content').html('No Data Found');
                            }
                        }
                        $('.tab-pane.active .tab-sub-content').removeClass('col-md-9').removeClass('col-sm-9');
                        $('.tab-pane.active .edit-machine-data').removeClass('col-md-3').removeClass('col-sm-3').removeClass('edit-machine-data-design').html('');
                        $('.close-alt').attr('disabled', false);
                        $.each(emr_id, function(key, value) {
                            $('td[data-drugid="'+value+'"]').html('-');

                            var drug_time = $('.machine-data-edit[data-drugid="' + value + '"]').attr('data-time');
                            var drug_id_name = $('.machine-data-edit[data-drugid="' + value + '"]').attr('data-description');
                            var table_name = $('.machine-data-edit[data-drugid="' + value + '"]').attr('data-tablename');

                            if (typeof drug_time != 'undefined' && typeof drug_id_name != 'undefined' && (table_name == 'prescription_infused_calculation_discharged' || table_name == 'prescription_infused_calculation')) {
                                $('td[data-row-id="'+drug_id_name+'"][data-val-time="'+drug_time+'"]').removeClass('bg-warninggg-must');
                            } else {
                                $('td[data-id="'+value+'"]').removeClass('bg-warninggg');
                            }
                        });

                    }
                    if (row_approval) {
                        $('.machine-data-edit.waiting-approval').parents('tr').remove();
                        row_approval = false;
                    }
                    if (column_full_approval) {
                        $('th.active').remove();
                        $('.machine-data-edit.waiting-approval').remove();
                        column_full_approval = false;
                    }
                    $('.machine-data-edit.waiting-approval').removeClass('label-info').removeClass('label-danger').removeClass('label-success').removeClass('waiting-approval');
                }
            });
        }
    }

    function notificationmsg(slug) {
        if (slug) {
            Showalert('success', "Successfully");
        } else {
            Showalert('error', "Unsuccessfully");
        }
    }
    $(document).on('click', '.machine-data-edit', function() {
        $('.machine-data-edit').removeClass('active');
        $(this).addClass('active');
        var datetime = $(this).attr('data-time');
        var description = $(this).attr('data-description');
        var id = $(this).attr('data-drugid');
        var value = $(this).attr('data-val');
        var reason = $(this).attr('data-reason');
        var original = $(this).attr('data-original');
        var local_id = $(this).attr('data-localcodegroupid');
        var table_name = $(this).attr('data-tablename');
        $('.tab-pane.active .tab-sub-content').removeClass('col-md-12').addClass('col-md-7').addClass('col-sm-7');
        var content = '<h5 class="machine-data-title text-captialize"><b>' + description + ' @ ' + datetime + '</b></h5>';
        content += '<input type="hidden" name="edit_id" value="' + id + '">';
        content += '<input type="hidden" name="original_value" value="' + original + '">';
        content += '<input type="hidden" name="table_name" value="' + table_name + '">';
        content += '<span class="display-inline-block mtb-15 error-message">Original Value: <b>' + original + '</b></span><br/>';
        content += '<label class="mtb-15">Edit Value</label>';
        if (local_id == 113) {
            content += '<div class="display-block">';
            if (value == 'Yes') {
                content += '<input type="radio" name="edited_val" value="on" checked> Yes ';
                content += '<input type="radio" name="edited_val" value=""> No';
            } else {
                content += '<input type="radio" name="edited_val" value="on"> Yes ';
                content += '<input type="radio" name="edited_val" value="" checked> No';
            }
            content += '</div>';
        } else if (local_id == 295) {
            content += '<div class="display-block">';
            if (value == 'Yes') {
                content += '<input type="radio" name="edited_val" value="2" checked> Yes ';
                content += '<input type="radio" name="edited_val" value="1"> No';
            } else {
                content += '<input type="radio" name="edited_val" value="2"> Yes ';
                content += '<input type="radio" name="edited_val" value="1" checked> No';
            }
            content += '</div>';
        }  else if (local_id == 367) {
            content += '<div class="display-block">';
                content += '<select class="form-control" name="edited_val">';
                content += '<option value="1">'+target_spO2_range[1]+'</option>';
                content += '<option value="2">'+target_spO2_range[2]+'</option>';
                content += '<option value="3">'+target_spO2_range[3]+'</option>';
                content += '<option value="4">'+target_spO2_range[4]+'</option>';
                content += '</select>';
            content += '</div>';
        } else {
            content += '<input type="text" name="edited_val" value="' + value + '" class="form-control" />';
        }
        content += '<label class="mtb-15">Reason For Editing</label>';
        content += '<textarea name="edited_reason" class="form-control" rows="2" cols="5">' + reason + '</textarea>';
        content += '<a class="btn btn-primary mtb-15" id="edit-update">Update</a>';
        content += '<a class="btn btn-info m-5 mtb-15" id="edit-update-approve">Update & Approve</a>';
        content += '<a class="btn btn-success mtb-15" id="approve-only">Approve</a>';
        content += '<a class="btn btn-default mtb-15 pull-right" id="close-update">Close</a>';
        $('.tab-pane.active .edit-machine-data').addClass('col-md-3').addClass('col-sm-3').addClass('edit-machine-data-design').html(content);
    });
    $(document).on('click', '#close-update', function() {
        $('.tab-pane.active .tab-sub-content').removeClass('col-md-7').removeClass('col-sm-7');
        $('.tab-pane.active .edit-machine-data').removeClass('col-md-3').removeClass('col-sm-3').removeClass('edit-machine-data-design').html('');
        $('.machine-data-edit td').removeClass('active-color');
        $('.machine-data-edit').removeClass('active');
    });
    var edit_approval = false;
    $(document).on('click', '#edit-update', function() {
        var edit_id = $('.tab-pane.active .edit-machine-data input[name="edit_id"]').val();
        var type_edit_val = $('.tab-pane.active .edit-machine-data input[name="edited_val"]').attr('type');
        if (type_edit_val == 'radio') {
            var edit_val = $('.tab-pane.active .edit-machine-data input[name="edited_val"]:checked').val();
        } else if (typeof type_edit_val == 'undefined') {
            var edit_val = $('.tab-pane.active .edit-machine-data select[name="edited_val"]').val();
        } else {
            var edit_val = $('.tab-pane.active .edit-machine-data input[name="edited_val"]').val();
        }
        var reason = $('.tab-pane.active .edit-machine-data textarea[name="edited_reason"]').val();
        var original = $('.tab-pane.active .edit-machine-data input[name="original_value"]').val();
        var table_name = $('.tab-pane.active .edit-machine-data input[name="table_name"]').val();
        var current_tab = $('#approval-modal .tab-pane.active').attr('id');
        if (edit_val == '' && type_edit_val != 'radio') {
            $('.tab-pane.active .edit-machine-data input[name="edited_val"]').addClass('has-error');
        } else {
            var updated_column_name = '';
            var updated_column_name_1 = '';
            switch (current_tab) {
                case 'stepper-step-1':
                    updated_column_name = 'mean';
                    updated_column_name_1 = 'intf_ref_value';
                    break;
                case 'stepper-step-2':
                    updated_column_name = 'mean';
                    updated_column_name_1 = 'intf_ref_value';
                    break;
                case 'stepper-step-3':
                    updated_column_name = 'hour_infused';
                    break;
                case 'stepper-step-4':
                    updated_column_name = 'mean';
                    updated_column_name_1 = 'intf_ref_value';
                    break;
            }
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'PATCH',
                data: {
                    table_name: table_name,
                    column_name: updated_column_name,
                    column_name1: updated_column_name_1,
                    id: edit_id,
                    edit_val: edit_val,
                    edited_reason: reason
                },
                url: "{{ action('Nurse\NurseSheetController@machineDataUpdate') }}",
                success: function(response) {
                    if (response.messageType == 'success') {
                        var id = response.id;
                        var value = response.value;
                        var reason = response.reason;
                        var local_id = $('.machine-data-edit.active').attr('data-localcodegroupid');
                        if (local_id == 113) {
                            if (value == 'on') {
                                value = 'Yes';
                            } else {
                                value = 'No';
                            }
                        } else if (local_id == 295) {
                            if (value == 2 || value == 3 || value == 4) {
                                value = 'Yes';
                            } else {
                                value = 'No';
                            }
                        }
                        $('.machine-data-edit[data-drugid="' + id + '"]').attr('data-val', value);
                        $('.machine-data-edit[data-drugid="' + id + '"]').attr('data-reason', reason);
                        if (reason != '') {
                            var reason = ' (' + reason + ')';
                        } else {
                            var reason = '';
                        }
                        var original_value = $('.machine-data-edit[data-drugid="' + id + '"]').attr('data-original');
                        var edited_value = value;
                        if (local_id == 367) {
                            value = target_spO2_range[value];
                        }
                        var value = original_value + ' | ' + value;
                        $('.machine-data-edit[data-drugid="' + id + '"]').html(value);
                        $('.machine-data-' + id + ' .edited_reason').html(reason);
                        $('.tab-pane.active .tab-sub-content').removeClass('col-md-7').removeClass('col-sm-7');
                        $('.tab-pane.active .edit-machine-data').removeClass('col-md-3').removeClass('col-sm-3').removeClass('edit-machine-data-design').html('');
                        $('.machine-data-edit td').removeClass('active-color');
                        if (edit_approval) {
                            $('.machine-data-edit.active').addClass('waiting-approval').removeClass('active');
                            approve();
                            edit_approval = false;
                        } else {
                            $('.machine-data-edit[data-drugid="' + id + '"]').removeClass('active').removeClass('label-danger').addClass('label-info');

                            var drug_time = $('.machine-data-edit[data-drugid="' + id + '"]').attr('data-time');
                            var drug_id_name = $('.machine-data-edit[data-drugid="' + id + '"]').attr('data-description');

                            if (typeof drug_time != 'undefined' && typeof drug_id_name != 'undefined') {
                                $('td[data-row-id="'+drug_id_name+'"][data-val-time="'+drug_time+'"]').html(edited_value);
                            }
                            $('td[data-id="'+id+'"]').html(edited_value);

                        }
                    }
                }
            });
        }
    });
    $(document).on('click', '#edit-update-approve', function() {
        var type_edit_val = $('.tab-pane.active .edit-machine-data input[name="edited_val"]').attr('type');
        var edit_val = $('.tab-pane.active .edit-machine-data input[name="edited_val"]').val();
        if (edit_val == '' && type_edit_val != 'radio') {
            $('.tab-pane.active .edit-machine-data input[name="edited_val"]').addClass('has-error');
        } else {
            edit_approval = true;
            $('#edit-update').trigger('click');
        }
    });
    $(document).on('click', '#approve-only', function() {
        $('.machine-data-edit.active').addClass('waiting-approval').removeClass('active');
        approve();
        $('.tab-pane.active .tab-sub-content').removeClass('col-md-7').removeClass('col-sm-7');
        $('.tab-pane.active .edit-machine-data').removeClass('col-md-3').removeClass('col-sm-3').removeClass('edit-machine-data-design').html('');
    });
    var trigger_modal = false;
    setTimeout(function() {
        trigger_modal = true;
        $('#approval-screen').trigger('click');
    }, 5);

    function monitorData(trigger_modal_slug = false) {
        var monitor_data = $('input[name="monitor_data"]').val();
        var response = JSON.parse(monitor_data);
        if (trigger_modal_slug) {
            monitor_data_processing(response);
            data_processing();                    
            trigger_modal = false;
        }
        else {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                data: {
                    baby_id: baby_id,
                    admission_id: admission_id,
                    start_time: start_time,
                    end_time: end_time
                },
                url: "{{ action('Nurse\NurseSheetController@getMonitorData') }}",
                success: function(response) {
                    monitor_data_processing(response);
                },
                complete: function() {
                    data_processing();                    
                }
            });
        }
    }

    function data_processing() {       
        $("#approval-modal #modal-loader").addClass('display-none');
        $('.stepper .nav-tabs, .tab-footer').removeClass('display-none-must');
        $(".tab-content").css('overflow', 'auto');
        var status = parseInt($('#approval-screen').attr('data-display'));
        if (status > 0) {
            $('#approval-modal').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
            $('.close-alt').attr('disabled', false);
        } else {
            $('#approval-screen').removeClass('btn-warning').addClass('btn-success');
            $('.print-btn').removeClass('hidden');
            $('#approval-modal').modal('hide');
        }
        $('#approval-screen').children('i').removeClass('fa-spinner').removeClass('fa-spin').addClass('fa-shield');
        $('#approval-screen').removeClass('cursor-disabled');
    } 

    function monitor_data_processing(response) {
        if (response.approval_count > 0) {
            var monitor_data = '';
            monitor_data += '<div class="table-container">';
            monitor_data += '<table class="table table-bordered">';
            monitor_data += '<thead>';
            monitor_data += '<tr>';
            monitor_data += '<th class="text-center approve_all"><i class="fa fa-check" aria-hidden="true"></i></th>';
            monitor_data += '<th class="text-center">Parameter / Time</th>';
            var column_count = 0;
            $.each(response.un_apporved_time, function(key, item) {
                monitor_data += '<th class="text-center column_width" data-column-count="' + column_count + '"><div class="time_based_approve"><span class="column_approve pr-5 pull-left"><i class="fa fa-check" aria-hidden="true"></i></span><span class="pull-right">' + item.split(' ')[1] + '</span></div></th>';
                column_count++;
            });
            monitor_data += '</tr>';
            monitor_data += '</thead>';
            monitor_data += '<tbody>';
            var table_name = response.table_name;
            $.each(response.value, function(value_key, value_item) {
                var parameter_name = value_item[Object.keys(value_item)[0]][0].local_description;
                var monitor_data_cell = '';
                var approval_count_by_cell = 0;
                var total_count = response.un_apporved_time.length;
                var column_count = 0;
                $.each(response.un_apporved_time, function(key, item) {
                    if (typeof value_item[item] != 'undefined') {
                        var original_intf_ref_value = value_item[item][0].original_intf_ref_value;

                        var temp_original_value = original_intf_ref_value.split('.');

                        if (typeof temp_original_value[1] != 'undefined' && temp_original_value.length > 0) {
                            original_intf_ref_value = $.isNumeric(original_intf_ref_value) ? parseFloat(original_intf_ref_value).toFixed(2) : original_intf_ref_value;
                        }

                        var intf_ref_value = value_item[item][0].intf_ref_value;

                        var temp_intf_value = intf_ref_value.split('.');

                        if (typeof temp_intf_value[1] != 'undefined' && temp_intf_value[1].length > 0) {
                            intf_ref_value = $.isNumeric(intf_ref_value) ? parseFloat(intf_ref_value).toFixed(2) : intf_ref_value;
                        }

                        var local_description = value_item[item][0].local_description;
                        var monitor_id = value_item[item][0].monitor_id;
                        var reason = value_item[item][0].edited_reason;
                        reason = reason != null ? reason : '';
                        var result_date_time = value_item[item][0].temp_result_date_time;
                        if (value_item[item][0].is_approved != true) {
                            if (original_intf_ref_value != intf_ref_value) {
                                monitor_data_cell += '<td class="text-center label-info machine-data-edit column_width" data-column-count="' + column_count + '" data-time="' + result_date_time + '" data-description="' + local_description + '" data-drugid="' + monitor_id + '" data-original="' + original_intf_ref_value + '" data-val="' + intf_ref_value + '" data-reason="' + reason + '" data-tablename="' + table_name + '"><span class="pull-right">' + original_intf_ref_value + ' | ' + intf_ref_value + '</div></td>';
                            } else {
                                monitor_data_cell += '<td class="text-center label-danger machine-data-edit column_width" data-column-count="' + column_count + '" data-time="' + result_date_time + '" data-description="' + local_description + '" data-drugid="' + monitor_id + '" data-original="' + original_intf_ref_value + '" data-val="' + intf_ref_value + '" data-reason="' + reason + '" data-tablename="' + table_name + '"><span class="pull-right">' + original_intf_ref_value + '</div></td>';
                            }
                        } else {
                            monitor_data_cell += '<td class="text-center column_width" data-column-count="' + column_count + '">-</td>';
                            approval_count_by_cell++;
                        }
                    } else {
                        monitor_data_cell += '<td class="text-center column_width" data-column-count="' + column_count + '">-</td>';
                        approval_count_by_cell++;
                    }
                    column_count++;
                });
                if (total_count != approval_count_by_cell) {
                    monitor_data += '<tr>';
                    monitor_data += '<td class="text-center"><span class="approve_by_param"><i class="fa fa-check" aria-hidden="true"></i></span></td>';
                    monitor_data += '<td class="text-center">' + parameter_name + '</td>';
                    monitor_data += monitor_data_cell;
                    monitor_data += '</tr>';
                }
            });
            monitor_data += '</tbody>';
            monitor_data += '</table>';
            monitor_data += '</div>';
            $('#monitor-data').html(monitor_data);
            var display = parseInt($('#approval-screen').attr('data-display')) + 1;
            $('#approval-screen').attr('data-display', display);
            $('#approval-modal .stepper li').removeClass('active');
            $('#approval-modal .tab-pane').removeClass('active');
            $('#approval-modal .stepper li:first-child').addClass('active');
            $('#approval-modal #stepper-step-1').addClass('active').addClass('in');
        }
    }

    function ventilatorData(trigger_modal_slug = false) {
        var ventilator_data = $('input[name="ventilator_data"]').val();
        var response = JSON.parse(ventilator_data);
        if (trigger_modal_slug) {
            ventilator_data_processing(response);
            monitorData(trigger_modal_slug);
        }
        else {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                data: {
                    baby_id: baby_id,
                    admission_id: admission_id,
                    start_time: start_time,
                    end_time: end_time
                },
                url: "{{ action('Nurse\NurseSheetController@getVentilatorData') }}",
                success: function(response) {
                    ventilator_data_processing(response)
                },
                complete: function() {
                    monitorData();
                }
            });
        }
    }

    function ventilator_data_processing(response) {
        if (response.un_apporved_time != 0) {
            var ventilator_data = '';
            ventilator_data += '<div class="table-container">';
            ventilator_data += '<table class="table table-bordered">';
            ventilator_data += '<thead>';
            ventilator_data += '<tr>';
            ventilator_data += '<th class="text-center approve_all"><i class="fa fa-check" aria-hidden="true"></i></th>';
            ventilator_data += '<th class="text-center">Parameter / Time</th>';
            var column_count = 0;
            $.each(response.un_apporved_time, function(key, item) {
                ventilator_data += '<th class="text-center column_width" data-column-count="' + column_count + '"><div class="time_based_approve"><span class="column_approve pr-5 pull-left"><i class="fa fa-check" aria-hidden="true"></i></span><span class="pull-right">' + item.split(' ')[1] + '</span></div></th>';
                column_count++;
            });
            ventilator_data += '</tr>';
            ventilator_data += '</thead>';
            ventilator_data += '<tbody>';
            var table_name = response.table_name;
            $.each(response.value, function(value_key, value_item) {
                var parameter_name = value_item[Object.keys(value_item)[0]][0].local_description;
                var ventilator_data_cell = '';
                var approval_count_by_cell = 0;
                var total_count = response.un_apporved_time.length;
                var column_count = 0;
                $.each(response.un_apporved_time, function(key, item) {
                    if (typeof value_item[item] != 'undefined') {
                        var original_intf_ref_value = value_item[item][0].original_intf_ref_value;
                        var intf_ref_value = value_item[item][0].intf_ref_value;
                        var local_description = value_item[item][0].local_description;
                        var ventilator_id = value_item[item][0].ventilator_id;
                        var reason = value_item[item][0].edited_reason;
                        reason = reason != null ? reason : '';
                        var result_date_time = value_item[item][0].temp_result_date_time;
                        var local_code_group_id = value_item[item][0].local_code_group_id;
                        var ventilator_hr_data = '';
                        if (local_code_group_id != 60) {
                            if (local_code_group_id == 113 && original_intf_ref_value == 'on') {
                                original_intf_ref_value = 'Yes';
                            } else if (local_code_group_id == 113 && original_intf_ref_value != 'on') {
                                original_intf_ref_value = 'No';
                            }
                            if (local_code_group_id == 295 && (original_intf_ref_value == 2 || original_intf_ref_value == 3 || original_intf_ref_value == 4)) {
                                original_intf_ref_value = 'Yes';
                            } else if (local_code_group_id == 295) {
                                original_intf_ref_value = 'No';
                            }
                            if (local_code_group_id == 295 && (intf_ref_value == 2 || intf_ref_value == 3 || intf_ref_value == 4)) {
                                intf_ref_value = 'Yes';
                            } else if (local_code_group_id == 295) {
                                intf_ref_value = 'No';
                            }
                            if (local_code_group_id == 113 && intf_ref_value == 'on') {
                                intf_ref_value = 'Yes';
                            } else if (local_code_group_id == 113 && intf_ref_value != 'on') {
                                intf_ref_value = 'No';
                            }
                            if (intf_ref_value != '' && intf_ref_value != null && intf_ref_value != original_intf_ref_value && item.edited_by != null) {
                                var mean = ' | ' + intf_ref_value;
                            } else {
                                var mean = '';
                            }
                            var original_intf_ref_value = original_intf_ref_value + mean;
                            if (local_code_group_id == 367) {
                                var oxygenie = response.value['vk'][result_date_time][0].intf_ref_value;
                                if (oxygenie == '2' || oxygenie == '3' || oxygenie == '4') {
                                     original_intf_ref_value = target_spO2_range[original_intf_ref_value];
                                     intf_ref_value = target_spO2_range[intf_ref_value];
                                }
                            }
                            if (value_item[item][0].is_approved != true) {
                                if (original_intf_ref_value != intf_ref_value) {
                                    ventilator_data_cell += '<td class="text-center label-info machine-data-edit column_width" data-column-count="' + column_count + '" data-time="' + result_date_time + '" data-description="' + local_description + '" data-drugid="' + ventilator_id + '" data-original="' + original_intf_ref_value + '" data-val="' + intf_ref_value + '" data-reason="' + reason + '" data-tablename="' + table_name + '" data-localcodegroupid="' + local_code_group_id + '">' + original_intf_ref_value + ' | ' + intf_ref_value + '</td>';
                                } else {
                                    ventilator_data_cell += '<td class="text-center label-danger machine-data-edit column_width" data-column-count="' + column_count + '" data-time="' + result_date_time + '" data-description="' + local_description + '" data-drugid="' + ventilator_id + '" data-original="' + original_intf_ref_value + '" data-val="' + intf_ref_value + '" data-reason="' + reason + '" data-tablename="' + table_name + '" data-localcodegroupid="' + local_code_group_id + '">' + original_intf_ref_value + '</td>';
                                }
                            } else {
                                ventilator_data_cell += '<td class="text-center column_width" data-column-count="' + column_count + '">-</td>';
                                approval_count_by_cell++;
                            }
                        }
                    } else {
                        ventilator_data_cell += '<td class="text-center column_width" data-column-count="' + column_count + '">-</td>';
                        approval_count_by_cell++;
                    }
                    column_count++;
                });
                if (total_count != approval_count_by_cell) {
                    ventilator_data += '<tr>';
                    ventilator_data += '<td class="text-center"><span class="approve_by_param"><i class="fa fa-check" aria-hidden="true"></i></span></td>';
                    ventilator_data += '<td class="text-center">' + parameter_name + '</td>';
                    ventilator_data += ventilator_data_cell;
                    ventilator_data += '</tr>';
                }
            });
            ventilator_data += '</tbody>';
            ventilator_data += '</table>';
            $('#ventilator-data').html(ventilator_data);
            var display = parseInt($('#approval-screen').attr('data-display')) + 1;
            $('#approval-screen').attr('data-display', display);
            $('#approval-modal .stepper li').removeClass('active');
            $('#approval-modal .tab-pane').removeClass('active');
            $('#approval-modal .stepper li:nth-child(2)').addClass('active');
            $('#approval-modal #stepper-step-2').addClass('active').addClass('in');
        }
    }

    function pumpData(trigger_modal_slug = false) {
        var pump_data = $('input[name="pump_data"]').val();
        var response = JSON.parse(pump_data);
        if (trigger_modal_slug) {
            pump_data_processing(response);
            ventilatorData(trigger_modal_slug);
        }
        else {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                data: {
                    baby_id: baby_id,
                    admission_id: admission_id,
                    start_time: start_time,
                    end_time: end_time
                },
                url: "{{ action('Nurse\NurseSheetController@getPumpData') }}",
                success: function(response) {
                    pump_data_processing(response)
                },
                complete: function() {
                    ventilatorData();
                }
            });
        }
    }

    function pump_data_processing(response) {
        if (response.un_apporved_time != 0) {
            var pump_data = '';
            pump_data += '<div class="table-container">';
            pump_data += '<table class="table table-bordered">';
            pump_data += '<thead>';
            pump_data += '<tr>';
            pump_data += '<th class="text-center approve_all"><i class="fa fa-check" aria-hidden="true"></i></th>';
            pump_data += '<th class="text-center">Parameter / Time</th>';
            var column_count = 0;
            $.each(response.un_apporved_time, function(key, item) {
                pump_data += '<th class="text-center column_width" data-column-count="' + column_count + '"><div class="time_based_approve"><span class="column_approve pr-5 pull-left"><i class="fa fa-check" aria-hidden="true"></i></span><span class="pull-right">' + item.substring(3) + '</span></div></th>';
                column_count++;
            });
            pump_data += '</tr>';
            pump_data += '</thead>';
            pump_data += '<tbody>';
            var table_name = response.table_name;
            $.each(response.drugs_list, function(value_key, value_item) {
                var parameter_name = value_item[Object.keys(value_item)[0]].drug_name;
                    parameter_name = parameter_name.split(':')[1];
                var pump_data_cell = '';
                var approval_count_by_cell = 0;
                var total_count = response.un_apporved_time.length;
                var column_count = 0;
                $.each(response.un_apporved_time, function(key, item) {
                    if (typeof value_item[item] != 'undefined') {
                        var original_intf_ref_value = value_item[item].original_infused;
                        original_intf_ref_value = parseFloat(original_intf_ref_value).toFixed(2);
                        var intf_ref_value = value_item[item].infused;
                        intf_ref_value = parseFloat(intf_ref_value).toFixed(2);
                        var local_description = value_item[item].drug_name;
                        var pres_pump_id = value_item[item].pres_pump_id;
                        var reason = value_item[item].edited_reason;
                        reason = reason != null ? reason : '';
                        var result_date_time = value_item[item].temp_result_date_time;
                        if (value_item[item].is_approved == false) {
                            if (original_intf_ref_value != intf_ref_value) {
                                pump_data_cell += '<td class="text-center label-info machine-data-edit column_width" data-column-count="' + column_count + '" data-time="' + result_date_time + '" data-description="' + local_description + '" data-drugid="' + pres_pump_id + '" data-original="' + original_intf_ref_value + '" data-val="' + intf_ref_value + '" data-reason="' + reason + '" data-tablename="' + table_name + '">' + original_intf_ref_value + ' | ' + intf_ref_value + '</td>';
                            } else {
                                pump_data_cell += '<td class="text-center label-danger machine-data-edit column_width" data-column-count="' + column_count + '" data-time="' + result_date_time + '" data-description="' + local_description + '" data-drugid="' + pres_pump_id + '" data-original="' + original_intf_ref_value + '" data-val="' + intf_ref_value + '" data-reason="' + reason + '" data-tablename="' + table_name + '">' + original_intf_ref_value + '</td>';
                            }
                        } else {
                            pump_data_cell += '<td class="text-center column_width" data-column-count="' + column_count + '">-</td>';
                            approval_count_by_cell++;
                        }
                    } else {
                        pump_data_cell += '<td class="text-center column_width" data-column-count="' + column_count + '">-</td>';
                        approval_count_by_cell++;
                    }
                    column_count++;
                });
                if (total_count != approval_count_by_cell) {
                    pump_data += '<tr>';
                    pump_data += '<td class="text-center"><span class="approve_by_param"><i class="fa fa-check" aria-hidden="true"></i></span></td>';
                    pump_data += '<td class="text-center">' + parameter_name + '</td>';
                    pump_data += pump_data_cell;
                    pump_data += '</tr>';
                }
            });
            pump_data += '</tbody>';
            pump_data += '</table>';
            $('#pump-data').html(pump_data);
            var display = parseInt($('#approval-screen').attr('data-display')) + 1;
            $('#approval-screen').attr('data-display', display);
            $('#approval-modal .stepper li').removeClass('active');
            $('#approval-modal .tab-pane').removeClass('active');
            $('#approval-modal .stepper li:nth-child(3)').addClass('active');
            $('#approval-modal #stepper-step-3').addClass('active').addClass('in');
        }
    }

    function labData() {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            data: {
                baby_id: baby_id,
                admission_id: admission_id,
                start_time: start_time,
                end_time: end_time
            },
            url: "{{ action('Nurse\NurseSheetController@getLabData') }}",
            beforeSend: function() {
                $(".temp-row").show();
            },
            success: function(response) {
                if (response.approval_count > 0) {
                    var lab_data = '';
                    lab_data += '<div class="check-all-btn"><a class="btn btn-warning check_all pull-right"><i class="fa fa-check" aria-hidden="true"></i> Check All</a></div>';
                    lab_data += '<table class="table">';
                    lab_data += '<tbody>';
                    $.each(response.value, function(value_key, value_item) {
                        var approval_key = value_key.replace(/-/g, '');
                        approval_key = approval_key.replace(/:/g, '');
                        approval_key = approval_key.replace(/ /g, '');
                        lab_data += '<tr class="machine-data-edit machine-data-date">';
                        lab_data += '<th colspan="2" class="text-center"><input type="checkbox" name="approve_all" data-key="' + approval_key + '" /> <b>' + value_key + '</b></th>';
                        lab_data += '</tr>';
                        var i = 0;
                        $.each(value_item, function(key, item) {
                            var lab_hr_data = '';
                            var original_intf_ref_value = item.original_intf_ref_value != null ? item.original_intf_ref_value : '';
                            var mean = (item.intf_ref_value != '' && item.intf_ref_value != null && item.intf_ref_value != item.original_intf_ref_value) ? ' | ' + item.intf_ref_value : '';
                            var edited_reason = item.edited_reason != null && item.edited_reason != '' ? ' (' + item.edited_reason + ')' : '';
                            var value = (mean != '') ? mean.replace(' | ', '') : original_intf_ref_value;
                            var reason = edited_reason.replace(' (', '');
                            reason = reason.replace(')', '');
                            lab_hr_data += '<div class="col-xs-2"><input type="checkbox" name="approve_stime" data-drugid="' + item.lab_id + '" data-tablename="emr_lab_values" /></div>';
                            lab_hr_data += '<div class="col-xs-4">' + item.local_description + '</div>';
                            lab_hr_data += '<div class="col-xs-4 machine-data-' + item.lab_id + '"><span class="original_value">' + original_intf_ref_value + '</span><span class="edited_value">' + mean + '</span><span class="edited_reason">' + edited_reason + '</span></div>';
                            lab_hr_data += '<div class="col-xs-2 text-center machine-data machine-data-' + item.lab_id + '" data-time="' + value_key + '" data-description="' + item.local_description + '" data-drugid="' + item.lab_id + '" data-original="' + original_intf_ref_value + '" data-val="' + value + '" data-reason="' + reason + '" data-localcodegroupid = "' + local_code_group_id + '"><i class="fa fa-edit"></i></div>';
                            if (i % 2 == 0) {
                                lab_data += '<tr class="machine-data-edit approve-' + approval_key + '">';
                                lab_data += '<td class="col-xs-6 border-right">';
                                lab_data += lab_hr_data;
                                lab_data += '</td>';
                            } else {
                                lab_data += '<td class="col-xs-6">';
                                lab_data += '<span class="hide">' + value_key + '</span>';
                                lab_data += lab_hr_data;
                                lab_data += '</td>';
                                lab_data += '</tr>';
                            }
                            i++;
                        });
                    });
                    lab_data += '</tbody>';
                    lab_data += '</table>';
                    $('#lab-data').html(lab_data);
                    var display = parseInt($('#approval-screen').attr('data-display')) + 1;
                    $('#approval-screen').attr('data-display', display);
                    $('#approval-modal .stepper li').removeClass('active');
                    $('#approval-modal .tab-pane').removeClass('active');
                    $('#approval-modal .stepper li:last-child').addClass('active');
                    $('#approval-modal #stepper-step-4').addClass('active').addClass('in');
                }
                $(".temp-row").show();
            },
            complete: function() {
                pumpData();
            }
        });
    }
    $('#approval-screen').on('click', function() {
        $('#approval-screen').attr('data-display', 0);
        $(this).children('i').removeClass('fa-shield').addClass('fa-spinner').addClass('fa-spin');
        $(this).addClass('cursor-disabled');
        var baby_id = $('input[name="baby_id"]').val();
        var admission_id = $('input[name="admission_id"]').val();
        var start_time = $('input[name="start_time"]').val();
        var end_time = $('input[name="end_time"]').val();
        var approval_status = $('input[name="approval_status"]').val();
        // labData();
        pumpData(trigger_modal);
    });
    $('#approval-modal').on('hidden.bs.modal', function() {
        $('.tab-pane.active .tab-sub-content').removeClass('col-md-9').removeClass('col-sm-9');
        $('.tab-pane.active .edit-machine-data').removeClass('col-md-3').removeClass('col-sm-3').removeClass('edit-machine-data-design').html('');
    });
    $(document).on('click', '.approve_by_param', function() {
        row_approval = true;
        $(this).parents('tr').find('.machine-data-edit').addClass('waiting-approval');
        approve();
    });
    $(document).on('click', '.approve_all', function() {
        full_approval = true;
        $('.tab-pane.active').find('.machine-data-edit').addClass('waiting-approval');
        approve();
    });
    $(document).on('click', '.column_approve', function() {
        column_full_approval = true;
        $(this).parents('tr').find('th').removeClass('active');
        $(this).parents('th').addClass('active');
        $(this).addClass('active')
        var column_count = $(this).parents('th').attr('data-column-count');
        $('.tab-pane.active .machine-data-edit[data-column-count="' + column_count + '"]').addClass('waiting-approval');
        approve();
    });
});
</script>
