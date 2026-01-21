@section('scripts') 
<script type = "text/javascript">  
    var unit_grams = <?php echo json_encode(ValuelistHelpers::infusiondoesunitgrams()); ?>;
    var unit_kg = <?php echo json_encode(ValuelistHelpers::infusiondoeskilograms()); ?>;
    var duration_type = <?php echo json_encode(ValuelistHelpers::infusiondoesduration()); ?>;
    var qty_unit = <?php echo json_encode(ValuelistHelpers::infusionquantityunits()); ?>;
    var syringe_size = <?php echo json_encode(ValuelistHelpers::getsyringesize()); ?>;
    var freq_list = <?php echo json_encode(ValuelistHelpers::drugFrequencyList()); ?>;
    var brand_name = <?php echo json_encode(ValuelistHelpers::getBrandName()); ?>;
    var unit_grams_oral = <?php echo json_encode(ValuelistHelpers::oraldoesunitgrams()); ?>;
    var doctors_list = <?php echo json_encode(ValuelistHelpers::mas_doctors_list()); ?>;
    var user_initial = <?php echo json_encode(ValuelistHelpers::getUserInitial()); ?>;
    var user_sign = <?php echo json_encode(ValuelistHelpers::getUserSign()); ?>;
    var user_name = <?php echo json_encode(ValuelistHelpers::getUserName()); ?>;
    var hours_list = <?php echo json_encode(SiteHelpers::prepare_time()['time']); ?>;
    var mins_list = <?php echo json_encode(SiteHelpers::prepare_time()['mins']); ?>;
    var session_list = <?php echo json_encode(SiteHelpers::prepare_time()['session']); ?>;
    var dose_unit_g = dose_unit_kg = dose_unit_duration = qty_units = syringe_type = '';
    $.each(unit_grams, function(index, value) {
        if (dose_unit_g == '') {
            dose_unit_g = '<option value="' + index + '">' + value + '</option>';
        } else {
            dose_unit_g += '<option value="' + index + '">' + value + '</option>';
        }
    });
    $.each(unit_kg, function(index, value) {
        if (dose_unit_kg == '') {
            dose_unit_kg = '<option value="' + index + '">' + value + '</option>';
        } else {
            dose_unit_kg += '<option value="' + index + '">' + value + '</option>';
        }
    });
    $.each(duration_type, function(index, value) {
        if (dose_unit_duration == '') {
            dose_unit_duration = '<option value="' + index + '">' + value + '</option>';
        } else {
            dose_unit_duration += '<option value="' + index + '">' + value + '</option>';
        }
    });
    $.each(qty_unit, function(index, value) {
        if (qty_units == '') {
            qty_units = '<option value="' + index + '">' + value + '</option>';
        } else {
            qty_units += '<option value="' + index + '">' + value + '</option>';
        }
    });
    $.each(syringe_size, function(index, value) {
        if (syringe_type == '') {
            syringe_type = '<option value="' + index + '">' + value + '</option>';
        } else {
            syringe_type += '<option value="' + index + '">' + value + '</option>';
        }
    });
    var dose_list = dose_list_oral = frequency_list = '';
    $.each(unit_grams, function(index, value) {
        if (dose_list == '') {
            dose_list = '<option value="' + index + '">' + value + '</option>';
        } else {
            dose_list += '<option value="' + index + '">' + value + '</option>';
        }
    });
    $.each(unit_grams_oral, function(index, value) {
        if (dose_list_oral == '') {
            dose_list_oral = '<option value="' + index + '">' + value + '</option>';
        } else {
            dose_list_oral += '<option value="' + index + '">' + value + '</option>';
        }
    });
    $.each(freq_list, function(index, value) {
        if (frequency_list == '') {
            frequency_list = '<option value="' + index + '">' + value + '</option>';
        } else {
            frequency_list += '<option value="' + index + '">' + value + '</option>';
        }
    });
    var other_infusions_durametnod_list = <?php echo json_encode(['min' => 'min', 'hr' => 'hr']); ?>;
    var durametnod_list = '';
    $.each(other_infusions_durametnod_list, function(index, value) {
        if (durametnod_list == '') {
            durametnod_list = '<option value="' + index + '">' + value + '</option>';
        } else {
            durametnod_list += '<option value="' + index + '">' + value + '</option>';
        }
    });
    var oral_route_list = <?php echo json_encode(ValuelistHelpers::getRoute()); ?>;
    var route_list = '';
    $.each(oral_route_list, function(index, value) {
        if (route_list == '') {
            route_list = '<option value="' + index + '">' + value + '</option>';
        } else {
            route_list += '<option value="' + index + '">' + value + '</option>';
        }
    });
    var doctor_name_list = '';
    $.each(doctors_list, function(index, value) {
        if (doctor_name_list == '') {
            doctor_name_list = '<option value="' + index + '">' + value + '</option>';
        } else {
            doctor_name_list += '<option value="' + index + '">' + value + '</option>';
        }
    });
    var hour_opt = '';
    $.each(hours_list, function(index, value) {
        if (hour_opt == '') {
            hour_opt = '<option value="' + index + '">' + value + '</option>';
        } else {
            hour_opt += '<option value="' + index + '">' + value + '</option>';
        }
    });
    var mins_opt = '';
    $.each(mins_list, function(index, value) {
        if (mins_opt == '') {
            mins_opt = '<option value="' + index + '">' + value + '</option>';
        } else {
            mins_opt += '<option value="' + index + '">' + value + '</option>';
        }
    });
    var session_opt = '';
    $.each(session_list, function(index, value) {
        if (session_opt == '') {
            session_opt = '<option value="' + index + '">' + value + '</option>';
        } else {
            session_opt += '<option value="' + index + '">' + value + '</option>';
        }
    })
    var pusher_app_key = '{{ env("PUSHER_APP_KEY") }}';
    var pusher_cluster = '{{ env("PUSHER_CLUSTER") }}';
</script>
@endsection