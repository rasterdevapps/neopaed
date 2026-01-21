@php
$site_url = url('/').'/public';
@endphp
@extends('app')
@section('content')
<style type="text/css">
    body {
        color: black;
        overflow: hidden;
    }
    .theme-dark #content {
        background-color: #f5f5f5;
    }
    .drug-gen {
        display: flex;
        height: 90vh;
        overflow: hidden;
    }
    .drug-list-main {
        height: 90%;
        overflow-y: auto;
    }
    .drug-list-main span {
        border: 1px solid #3968c6;
        border-radius: 25px;
        padding: 8px 15px;
        white-space: nowrap;
        display: inline-table;
        margin: 5px 1px;
    }
    .drug-list-main span:hover {
        background-color: #3968c6;
        color: white;
        font-weight: bold;
    }
    .drug-title {
        margin-top: 10px; 
        margin-bottom: 10px; 
    }
    .input-icons i {
        position: absolute;
        right: 5px;
    }
    .input-icons {
        width: 100%;
        margin-bottom: 10px;
    }
    .icon {
        padding: 10px;
        color: grey;
        min-width: 50px;
        text-align: center;
    }
    .drug-list-hidden {
        display: none;
    }
    .card-layout {
        background: white;
        box-shadow: 0px 1px 3px #3f4444ba;
        padding: 10px;
    }
</style>
<div class="row row-spacing">
    <div class="col-md-12 drug-gen">
        <div class="col-md-6 col-sm-6">  
            <b>Brand / Pharmacological Name</b>
            <div class="input-icons">
                <i class="fa fa-times icon reset"></i>
                <input type="text" id="brandname" class="form-control mtb-15" placeholder="Search" />
            </div>
            @if (isset($drug_iv_fluid_name))
            <div class="drug-list-main">
                @php $i = 1; @endphp
                @foreach($drug_iv_fluid_name as $key => $value)
                <div class="drug-list" id="main-div-{{$i}}">
                    @php $group_name = explode(':', $key);  @endphp
                    <div class="drug-title"><b>{{$group_name[0]}}</b></div>
                    @foreach($value as $key1 => $value1)
                    <span data-drug="{{$group_name[1]}}:{{$key1}}" data-drugname="{{$value1}} / {{$drug_iv_fluid_phar_gen[$key][$key1]}}">{{$value1}} / {{$drug_iv_fluid_phar_gen[$key][$key1]}}</span>
                    @endforeach
                </div>
                @php $i++; @endphp
                @endforeach
            </div>
            <div class="drug-list-hidden">
            </div>
            @endif
        </div>
        <div class="col-md-6 col-sm-6 prescription-entry"> </div>
    </div>
</div>
@endsection 
@section('scripts')
<script type="text/javascript">
    var unit_grams = <?php echo json_encode(ValuelistHelpers::infusiondoesunitgrams()); ?>;
    var unit_kg = <?php echo json_encode(ValuelistHelpers::infusiondoeskilograms()); ?>;
    var duration_type = <?php echo json_encode(ValuelistHelpers::infusiondoesduration()); ?>;
    var qty_unit = <?php echo json_encode(ValuelistHelpers::infusionquantityunits()); ?>;
    var syringe_size = <?php echo json_encode(ValuelistHelpers::getsyringesize()); ?>;
    var unit_grams_oral = <?php echo json_encode(ValuelistHelpers::oraldoesunitgrams()); ?>;
    var freq_list = <?php echo json_encode($frequency_list); ?>;
    var doctors_list = <?php echo json_encode(ValuelistHelpers::mas_doctors_list()); ?>;
    var hours_list = <?php echo json_encode(SiteHelpers::prepare_time()['time']); ?>;
    var mins_list = <?php echo json_encode(SiteHelpers::prepare_time()['mins']); ?>;
    var session_list = <?php echo json_encode(SiteHelpers::prepare_time()['session']); ?>;

    var dose_unit_g = dose_unit_kg = dose_unit_duration = qty_units = syringe_type = '';

    $.each(unit_grams, function (index, value) {
        if (dose_unit_g == '') {
            dose_unit_g = '<option value="' + index + '">' + value + '</option>';
        } else {
            dose_unit_g += '<option value="' + index + '">' + value + '</option>';
        }
    });

    $.each(unit_kg, function (index, value) {
        if (dose_unit_kg == '') {
            dose_unit_kg = '<option value="' + index + '">' + value + '</option>';
        } else {
            dose_unit_kg += '<option value="' + index + '">' + value + '</option>';
        }
    });

    $.each(duration_type, function (index, value) {
        if (dose_unit_duration == '') {
            dose_unit_duration = '<option value="' + index + '">' + value + '</option>';
        } else {
            dose_unit_duration += '<option value="' + index + '">' + value + '</option>';
        }
    });

    $.each(qty_unit, function (index, value) {
        if (qty_units == '') {
            qty_units = '<option value="' + index + '">' + value + '</option>';
        } else {
            qty_units += '<option value="' + index + '">' + value + '</option>';
        }
    });

    $.each(syringe_size, function (index, value) {
        if (syringe_type == '') {
            syringe_type = '<option value="' + index + '">' + value + '</option>';
        } else {
            syringe_type += '<option value="' + index + '">' + value + '</option>';
        }
    });

    var dose_list = dose_list_oral = frequency_list = '';

    $.each(unit_grams, function (index, value) {
        if (dose_list == '') {
            dose_list = '<option value="' + index + '">' + value + '</option>';
        } else {
            dose_list += '<option value="' + index + '">' + value + '</option>';
        }
    });

    $.each(unit_grams_oral, function (index, value) {
        if (dose_list_oral == '') {
            dose_list_oral = '<option value="' + index + '">' + value + '</option>';
        } else {
            dose_list_oral += '<option value="' + index + '">' + value + '</option>';
        }
    });

    $.each(freq_list, function (index, value) {
        if (frequency_list == '') {
            frequency_list = '<option value="' + index + '">' + value + '</option>';
        } else {
            frequency_list += '<option value="' + index + '">' + value + '</option>';
        }
    });

    var other_infusions_durametnod_list = <?php echo json_encode(['min' => 'min', 'hr' => 'hr']); ?>;
    var durametnod_list = '';

    $.each(other_infusions_durametnod_list, function (index, value) {
        if (durametnod_list == '') {
            durametnod_list = '<option value="' + index + '">' + value + '</option>';
        } else {
            durametnod_list += '<option value="' + index + '">' + value + '</option>';
        }
    });

    var oral_route_list = <?php echo json_encode(ValuelistHelpers::getRoute()); ?>;
    var route_list = '';

    $.each(oral_route_list, function (index, value) {
        if (route_list == '') {
            route_list = '<option value="' + index + '">' + value + '</option>';
        } else {
            route_list += '<option value="' + index + '">' + value + '</option>';
        }
    });

    var doctor_name_list = '';
    $.each(doctors_list, function (index, value) {
        if (doctor_name_list == '') {
            doctor_name_list = '<option value="' + index + '">' + value + '</option>';
        } else {
            doctor_name_list += '<option value="' + index + '">' + value + '</option>';
        }
    });

    var hour_opt = '';
    $.each(hours_list, function (index, value) {
        if (hour_opt == '') {
            hour_opt = '<option value="' + index + '">' + value + '</option>';
        } else {
            hour_opt += '<option value="' + index + '">' + value + '</option>';
        }
    });

    var mins_opt = '';
    $.each(mins_list, function (index, value) {
        if (mins_opt == '') {
            mins_opt = '<option value="' + index + '">' + value + '</option>';
        } else {
            mins_opt += '<option value="' + index + '">' + value + '</option>';
        }
    });

    var session_opt = '';
    $.each(session_list, function (index, value) {
        if (session_opt == '') {
            session_opt = '<option value="' + index + '">' + value + '</option>';
        } else {
            session_opt += '<option value="' + index + '">' + value + '</option>';
        }
    });

    $('.drug-list-hidden').html($('.drug-list-main').html());

    $(document).on('click', '.reset', function () {
        $('#brandname').val('');
        $(".drug-list-main").html($(".drug-list-hidden").html());
        $(".prescription-entry").html('');
    });

    $.extend($.expr[":"], {
        "containsIN": function(elem, i, match, array) {
            return (elem.textContent || elem.innerText || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
        }
    });

    $("#brandname").keyup(function (){  
    $(".drug-list-main").html('');
        var filter = $(this).val();

        if (filter && filter.length > 0){
         console.log(filter);
         console.log(filter.length);
         $(".drug-list-hidden span:containsIN('"+filter+"')").each(function() {       
            $(".drug-list-main").append('<span data-drug="'+$(this).attr('data-drug')+'" data-drugname="'+$(this).html()+'">'+$(this).html()+'</span> ');
        });
     }
 });

    $(document).on('click', '.drug-list-main span', function () {
        var id = 0;
        var drugname = $(this).attr('data-drugname');
        $('#brandname').val(drugname);
        anotherfields($(this).attr('data-drug'), id);
    });

    function anotherfields(type, id) {
        infusion_type_id = type.split(':');
        console.log(type);
        $('.prescription').remove();
        $('.frequency_start_time_num').remove();
        $('.select-number-frequency_start_time_num').remove();

        var date = new Date();

        var default_date = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '-' + ((date.getMonth() > 9) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '-' + date.getFullYear();

        var hours = date.getHours();
        var minutes = date.getMinutes();
        var ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12;
        var hours_12 = hours;
        hours = hours < 10 ? '0'+hours : hours;
        minutes = minutes < 10 ? '0'+minutes : minutes;
        var default_time = hours + ':' + minutes + ' ' + ampm;

        var defaultdatetime = default_date + ' '  + default_time;

        switch (infusion_type_id[0]) {

            case 'IVDI':
            $('.prescription-entry').html('<div class="col-md-12 prescription mt-5 plr-0"><div class="col-md-12 form-group card-layout"><div class="col-md-4 plr-0">Dose / Units</div><div class="col-md-8 plr-0 display-flex"><input type="text" name="infusion_dose" class="form-control" id="infusion_dose-0" /><select name="infusion_dose_units_g" class="form-control input-width-small" id="infusion-dose-units-g-0">' + dose_unit_g + '</select><select name="infusion_dose_units_kg" class="form-control input-width-small" id="infusion-dose-units-kg-0">' + dose_unit_kg + '</select><select name="infusion_dose_units_time" class="form-control input-width-small" id="infusion-dose-units-time-0">' + dose_unit_duration + '</select></div></div><div class="col-md-12 form-group card-layout"><div class="col-md-4 plr-0">Qty / Unit</div><div class="col-md-8 plr-0 display-flex"><input type="text" name="infusion_quantity" class="form-control" id="infusion-quantity-0" /><select name="quantity_units" class="form-control input-width-small" id="quantity-units-0">' + qty_units + '</select></div></div><div class="col-md-12 form-group card-layout"><div class="col-md-4 plr-0">Syringe Size (ml)</div><div class="col-md-8 plr-0"><select name="infusion_syringe" class="form-control" id="infusion-syringe-0">' + syringe_type + '</select></div></div><div class="col-md-12 form-group card-layout"><div class="col-md-4 plr-0">Rate (ml/hr)</div><div class="col-md-8 plr-0"><input type="text" name="infusion_rate" class="form-control" id="infusion-rate-0" /></div></div><div class="col-md-12 card-layout"><div class="form-group"><div class="col-md-12 plr-0">Additional Instruction</div><div class="col-md-12 plr-0"><input type="text" name="infusion_instruction" class="form-control" id="infusion-instruction-0" /></div></div><div class="form-group"><div class="col-md-12 plr-0">Additional Drug Added</div><div class="col-md-12 plr-0"><input type="text" name="infusion_drug_added" class="form-control" id="infusion_drug_added-0"></div></div><div class="form-group"><div class="col-md-4 plr-0">Dose & Frequency Of Additional Drug</div><div class="col-md-8 plr-0"><input type="text" name="infusion_feq_addition" class="form-control" id="infusion_feq_addition-0"></div></div><div class="form-group"><div class="col-md-4 plr-0">Batch No</div><div class="col-md-8 plr-0"><input type="text" name="infusion_batch_no" class="form-control" id="infusion_batch_no-0"></div></div><div class="form-group"><div class="col-md-4 plr-0">Prescribed By (Doctor)</div><div class="col-md-8 plr-0"><select name="prescribed_by" class="form-control" id="prescribed_by-0">' + doctor_name_list + '</select></div></div><div class="form-group"><div class="col-md-4 plr-0">Prescribed Date & Time</div><div class="col-md-8 plr-0 display-flex"><input type="text" name="prescribed_date" class="form-control prescribed-date mr-10" id="drug-prescribed-date-0" readonly /><select name="prescribed_hours" class="form-control mr-10 input-width-small hours">' + hour_opt + '</select><select name="prescribed_mins" class="form-control mr-10 input-width-small minutes">' + mins_opt + '</select><select name="prescribed_session" class="form-control input-width-small session">' + session_opt + '</select></div></div><div class="form-group"><div class="col-md-4 plr-0">Start Date</div><div class="col-md-8 plr-0 display-flex"><input type="text" name="start_date" class="form-control start-date mr-10" id="start-date-0" readonly /><select name="start_hours" class="form-control mr-10 input-width-small hours">' + hour_opt + '</select><select name="start_mins" class="form-control mr-10 input-width-small minutes">' + mins_opt + '</select><select name="start_session" class="form-control input-width-small session">' + session_opt + '</select></div></div></div>');
            $("#infusion-dose-units-g-" + id + " option:last").attr("selected", "selected");
            $("#infusion-dose-units-kg-" + id + " option:last").attr("selected", "selected");
            $("#infusion-dose-units-time-" + id + " option:last").attr("selected", "selected");
            $("#quantity-units-" + id + " option:first").attr("selected", "selected");

            switch (infusion_type_id[1]) {
                case '1':
                $('#infusion_dose-' + id).val(5).removeAttr('readonly');
                $('#infusion-dose-units-g-' + id).val(4);
                $('#infusion-dose-units-kg-' + id).val(1);
                $('#infusion-dose-units-time-' + id).val(1);
                $('#infusion-quantity-' + id).val('');
                $('#quantity-units-' + id).val(2);
                $('#infusion-syringe-' + id).val(25);
                $('#infusion-rate-' + id).val(0.1).trigger('change');
                break;
                case '2':
                $('#infusion_dose-' + id).val(5).removeAttr('readonly');
                $('#infusion-dose-units-g-' + id).val(4);
                $('#infusion-dose-units-kg-' + id).val(1);
                $('#infusion-dose-units-time-' + id).val(1);
                $('#quantity-units-' + id).val(2);
                $('#infusion-syringe-' + id).val(25);
                $('#infusion-rate-' + id).val(0.1).trigger('change');
                $('#infusion-quantity-' + id).val('');
                break;
                case '3':
                $('#infusion_dose-' + id).val(50).removeAttr('readonly');
                $('#infusion-dose-units-g-' + id).val(5);
                $('#infusion-dose-units-kg-' + id).val(1);
                $('#infusion-dose-units-time-' + id).val(1);
                $('#quantity-units-' + id).val(2);
                $('#infusion-syringe-' + id).val(25);
                $('#infusion-rate-' + id).val(0.1).trigger('change');
                $('#infusion-quantity-' + id).val('');
                break;
                case '25':
                $('#infusion_dose-' + id).val(50).removeAttr('readonly');
                $('#infusion-dose-units-g-' + id).val(5);
                $('#infusion-dose-units-kg-' + id).val(1);
                $('#infusion-dose-units-time-' + id).val(1);
                $('#quantity-units-' + id).val(2);
                $('#infusion-syringe-' + id).val(25);
                $('#infusion-rate-' + id).val(0.1).trigger('change');
                $('#infusion-quantity-' + id).val('');
                break;
                case '4':
                $('#infusion_dose-' + id).val(30).removeAttr('readonly');
                $('#infusion-dose-units-g-' + id).val(4);
                $('#infusion-dose-units-kg-' + id).val(1);
                $('#infusion-dose-units-time-' + id).val(2);
                $('#quantity-units-' + id).val(2);
                $('#infusion-syringe-' + id).val(25);
                $('#infusion-rate-' + id).val(0.1).trigger('change');
                $('#infusion-quantity-' + id).val('');
                break;
                case '26':
                $('#infusion_dose-' + id).val(5).removeAttr('readonly');
                $('#infusion-dose-units-g-' + id).val(5);
                $('#infusion-dose-units-kg-' + id).val(1);
                $('#infusion-dose-units-time-' + id).val(1);
                $('#quantity-units-' + id).val(3);
                $('#infusion-syringe-' + id).val(25);
                $('#infusion-rate-' + id).val(0.1).trigger('change');
                $('#infusion-quantity-' + id).val('');
                break;
                case '16':
                $('#infusion_dose-' + id).val(5).removeAttr('readonly');
                $('#infusion-dose-units-g-' + id).val(4);
                $('#infusion-dose-units-kg-' + id).val(1);
                $('#infusion-dose-units-time-' + id).val(2);
                $('#quantity-units-' + id).val(2);
                $('#infusion-syringe-' + id).val(25);
                $('#infusion-rate-' + id).val(0.1).trigger('change');
                $('#infusion-quantity-' + id).val('');
                break;
                case '280':
                $('#infusion_dose-' + id).val(30).removeAttr('readonly');
                $('#infusion-dose-units-g-' + id).val(5);
                $('#infusion-dose-units-kg-' + id).val(1);
                $('#infusion-dose-units-time-' + id).val(2);
                $('#quantity-units-' + id).val(2);
                $('#infusion-syringe-' + id).val(25);
                $('#infusion-rate-' + id).val(0.1).trigger('change');
                $('#infusion-quantity-' + id).val('');
                break;
                case '271':
                $('#infusion_dose-' + id).val('').attr('readonly', true);
                $('#infusion-dose-units-g-' + id).val('');
                $('#infusion-dose-units-kg-' + id).val('');
                $('#infusion-dose-units-time-' + id).val('');
                $('#quantity-units-' + id).val(4);
                $('#infusion-quantity-' + id).val(25);
                $('#infusion-syringe-' + id).val(25);
                $('#infusion-rate-' + id).val(0.5).trigger('change');
                break;
                case '276':
                $('#infusion_dose-' + id).val('').attr('readonly', true);
                $('#infusion-dose-units-g-' + id).val('');
                $('#infusion-dose-units-kg-' + id).val('');
                $('#infusion-dose-units-time-' + id).val('');
                $('#quantity-units-' + id).val(4);
                $('#infusion-quantity-' + id).val(25);
                $('#infusion-syringe-' + id).val(25);
                $('#infusion-rate-' + id).val(0.5).trigger('change');
                break;
                case '281':
                $('#infusion_dose-' + id).val(0.01).removeAttr('readonly');
                $('#infusion-dose-units-g-' + id).val(6);
                $('#infusion-dose-units-kg-' + id).val(1);
                $('#infusion-dose-units-time-' + id).val(2);
                $('#quantity-units-' + id).val(4);
                $('#infusion-syringe-' + id).val(25);
                $('#infusion-rate-' + id).val(0.1).trigger('change');
                $('#infusion-quantity-' + id).val('');
                break;
                case '5':
                $('#infusion_dose-' + id).val(1.6).removeAttr('readonly');
                $('#infusion-dose-units-g-' + id).val(2);
                $('#infusion-dose-units-kg-' + id).val(1);
                $('#infusion-dose-units-time-' + id).val(3);
                $('#quantity-units-' + id).val(2);
                $('#infusion-syringe-' + id).val(7.5);
                $('#infusion-rate-' + id).val(0.2).trigger('change');
                $('#infusion-quantity-' + id).val('');
                break;
                case '6':
                $('#infusion_dose-' + id).val(15).removeAttr('readonly');
                $('#infusion-dose-units-g-' + id).val(2);
                $('#infusion-dose-units-kg-' + id).val(1);
                $('#infusion-dose-units-time-' + id).val(3);
                $('#quantity-units-' + id).val(2);
                $('#infusion-syringe-' + id).val(12.5);
                $('#infusion-rate-' + id).val(0.1).trigger('change');
                $('#infusion-quantity-' + id).val('');
                break;
                case '270':
                $('#infusion_dose-' + id).val(50);
                $('#infusion-dose-units-g-' + id).val(4);
                $('#infusion-dose-units-kg-' + id).val(1);
                $('#infusion-dose-units-time-' + id).val(2);
                $('#quantity-units-' + id).val(2);
                $('#infusion-syringe-' + id).val(25);
                $('#infusion-rate-' + id).val(0.1).trigger('change');
                $('#infusion-instruction-' + id).val('Via Central or Peripheral line');
                break;
                case '20':
                $('#infusion_dose-' + id).val(50).removeAttr('readonly');
                $('#infusion-dose-units-g-' + id).val(4);
                $('#infusion-dose-units-kg-' + id).val(1);
                $('#infusion-dose-units-time-' + id).val(2);
                $('#infusion-quantity-' + id).val('');
                $('#quantity-units-' + id).val(2);
                $('#infusion-syringe-' + id).val(25);
                $('#infusion-rate-' + id).val(0.1).trigger('change');
                break;
                case '27':
                $('#infusion_dose-' + id).val(30).removeAttr('readonly');
                $('#infusion-dose-units-g-' + id).val(4);
                $('#infusion-dose-units-kg-' + id).val(1);
                $('#infusion-dose-units-time-' + id).val(2);
                $('#infusion-quantity-' + id).val('');
                $('#quantity-units-' + id).val(2);
                $('#infusion-syringe-' + id).val(25);
                $('#infusion-rate-' + id).val(0.1).trigger('change');
                break;
                case '48':
                $('#infusion-dose-units-g-' + id).val(2);
                $('#infusion-dose-units-kg-' + id).val(1);
                $('#infusion-dose-units-time-' + id).val(3);
                break;
                case '24':
                $('#infusion-dose-units-g-' + id).val(4);
                $('#infusion-dose-units-kg-' + id).val(1);
                $('#infusion-dose-units-time-' + id).val(2);
                break;
                default:
                break;
            }

            $('#prescription-save-btn').attr('disabled', false);
            break;
            case 'OIVD':
            $('.prescription-entry').html('<div class="col-md-12 prescription mt-5 plr-0"><div class="col-md-12 form-group"><div class="col-md-4 plr-0">Dose / Required</div><div class="col-md-8 plr-0 display-flex"><input type="text" name="other_iv_drugs_dose_required" class="form-control" id="other_iv_drugs_dose_required-0" /><select name="drugs_dose_units" class="form-control input-width-small mr-15" id="drugs-dose-units-0">' + dose_list + '</select><input type="text" name="other_iv_drugs_alt_dose" class="form-control" id="other_iv_drugs_alt_dose-0" /><select name="drugs_alt_dose_units" class="form-control input-width-small" id="drugs-alt-dose-units-0">' + dose_list + '</select></div></div><div class="col-md-12 form-group"><div class="col-md-4 plr-0">Frequency</div><div class="col-md-8 plr-0"><select name="other_iv_drugs_frequency" class="full-width" id="other-iv-drugs-frequency-0">' + frequency_list + '</select></div></div><div class="col-md-12 form-group"><div class="col-md-4 plr-0">Vol / Dose (ml)</div><div class="col-md-8 plr-0"><input type="text" name="other_iv_drugs_syringe" class="form-control" id="other_iv_drugs_syringe-0"></div></div><div class="col-md-12 form-group"><div class="col-md-4 plr-0">Rate (ml/hr)</div><div class="col-md-8 plr-0"><input type="text" name="other_iv_drugs_rate" class="form-control" id="other_iv_drugs_rate-0" /></div></div><div class="col-md-12 form-group"><div class="col-md-4 plr-0">Additional Instruction</div><div class="col-md-8 plr-0"><input type="text" name="other_iv_drugs_additional" class="form-control other_iv_drugs_additional" id="other_iv_drugs_additional-0" /></div></div><div class="col-md-12 form-group"><div class="col-md-4 plr-0">Prescribed By (Doctor)</div><div class="col-md-8 plr-0"><select name="prescribed_by" class="form-control" id="prescribed_by-0">' + doctor_name_list + '</select></div></div><div class="col-md-12 form-group"><div class="col-md-4 plr-0">Prescribed Date & Time</div><div class="col-md-8 plr-0 display-flex"><input type="text" name="prescribed_date" class="form-control prescribed-date mr-10" id="drug-prescribed-date-0" readonly /><select name="prescribed_hours" class="form-control mr-10 input-width-small hours">' + hour_opt + '</select><select name="prescribed_mins" class="form-control mr-10 input-width-small minutes">' + mins_opt + '</select><select name="prescribed_session" class="form-control input-width-small session">' + session_opt + '</select></div></div><div class="col-md-12 form-group"><div class="col-md-4 plr-0">Start Date</div><div class="col-md-8 plr-0"><input type="text" name="start_date" class="form-control start-date" id="start-date-0" readonly /></div></div><div class="col-md-12 form-group start-hour-entry"><div class="col-md-4 plr-0">Starting hour</div><div class="col-md-8 plr-0" style="display: flex; align-items: center; white-space: nowrap;"><input type="text" id="frequency_start_time" class="form-control input-width-mini" name="frequency_start_time" readonly style="display: inline-block;"><span class="frequency_start_time_num"></span><div class="hour-session"><label class="display-inline"><input type="radio" name="starthour" value="am" id="starthour-am" /><span>AM</span></label><label class="display-inline"><input type="radio" name="starthour" value="pm" id="starthour-pm" /><span>PM</span></label></div></div></div><div class="col-md-12 form-group"><div class="col-md-4 plr-0">Review Date</div><div class="col-md-8 plr-0"><input type="text" name="other_iv_drugs_review_date" class="form-control review-date" id="drug-review-date-0" readonly /></div></div><div class="col-md-12 form-group display-flex prescription-type"><div class="col-md-4 plr-0">Prescription Type</div><div class="col-md-8 plr-0"><div class="pump-session"><label class="display-inline"><input type="radio" name="prescription_type" value="1" id="regular" /><span></span></label><span>Regular</span><label class="display-inline"><input type="radio" name="prescription_type" value="2" id="required" /><span></span></label><span class="required-width">As Required (PRN or SOS)</span><label class="display-inline"><input type="radio" name="prescription_type" value="4" id="stat" /><span></span></label><span class="stat-width">STAT / Once Only</span></div></div></div>');
            $("#drugs-dose-units-0 option:last").attr("selected", "selected");
            $("#other-iv-drugs-frequency-0").select2();

            $("#other-iv-drugs-frequency-0").val($('#other-iv-drugs-frequency-0 option:first-child').val()).trigger('change');

            $("#drugs-dose-units-0").val(2).trigger("change");
            $("#drugs-alt-dose-units-0").val(3).trigger("change");
            // $('#start-date-0, #drug-review-date-0').datepicker({
            //     dateFormat: 'dd-mm-yy',
            //     changeMonth: true,
            //     changeYear: true
            // });
            // $('#start-date-0, #drug-review-date-0').datepicker("setDate", new Date());

            $('#drug-review-date-0').datepicker({
                dateFormat: 'dd-mm-yy',
                changeMonth: true,
                changeYear: true
            }).val(default_date);
            
            @foreach($prescription_freq_dialpad as $property)
            addDiaelPad('{{ $property[0] }}', '{{ $property[0] }}', 'dial-pade-text-width', '{{ $property[1] }}', '{{ $property[2] }}', '{{ $property[3] }}', '{{ $property[4] }}');
            addLeadingZero('{{ $property[0] }}');
            @endforeach

            $('input#regular').prop('checked', true);

            $('#prescription-save-btn').attr('disabled', false);
            break;
            case 'OIVI':
            $('.prescription-entry').html('<div class="col-md-12 prescription mt-5 plr-0"><div class="col-md-12 form-group"><div class="col-md-4 plr-0">Volume To Be Infused (ml)</div><div class="col-md-8 plr-0"><input type="text" name="other_infusions_volume" class="form-control" id="other_infusions_volume-0" /></div></div><div class="col-md-12 form-group"><div class="col-md-4 plr-0">Rate (ml/hr)</div><div class="col-md-8 plr-0"><input type="text" name="other_infusions_rate" class="form-control" id="other_infusions_rate-0"></div></div><div class="col-md-12 form-group"><div class="col-md-4 plr-0">Duration</div><div class="col-md-8 plr-0 display-flex"><input type="text" name="other_infusions_duration" class="form-control" id="other_infusions_duration-0" /><select name="other_infusions_durametnod" class="form-control other-infusions-durametnod input-width-small" id="other_infusions_durametnod-0">' + durametnod_list + '</select></div></div><div class="col-md-12 form-group display-flex"><div class="col-md-4 plr-0" style="margin-top: 9px;">Syringe / Infusion Pump</div><div class="col-md-8 plr-0"><div class="pump-session"><label class="display-inline"><input type="radio" name="other_infusions_pump_type" value="IV" id="other_infusions_pump_type-IV" /><span></span></label><span>Infusion Pump</span><label class="display-inline"><input type="radio" name="other_infusions_pump_type" value="IVG" id="other_infusions_pump_type-IVG" /><span></span></label><span>Syringe Pump</span></div></div></div><div class="col-md-12 form-group"><div class="col-md-4 plr-0">Additional Instruction</div><div class="col-md-8 plr-0"><input type="text" name="other_infusions_instruction" class="form-control" id="other_infusions_instruction-0"></div></div><div class="col-md-12 form-group"><div class="col-md-4 plr-0">Additional Drug Added</div><div class="col-md-8 plr-0"><input type="text" name="other_infusions_drug_added" class="form-control" id="other_infusions_drug_added-0"></div></div><div class="col-md-12 form-group"><div class="col-md-4 plr-0">Dose & Frequency Of Additional Drug</div><div class="col-md-8 plr-0"><input type="text" name="other_infusions_dose_feq_addition" class="form-control" id="other_infusions_dose_feq_addition-0"></div></div><div class="col-md-12 form-group"><div class="col-md-4 plr-0">Batch No</div><div class="col-md-8 plr-0"><input type="text" name="other_infusions_batch_no" class="form-control" id="other_infusions_batch_no-0"></div></div><div class="col-md-12 form-group"><div class="col-md-4 plr-0">Prescribed By (Doctor)</div><div class="col-md-8 plr-0"><select name="prescribed_by" class="form-control" id="prescribed_by-0">' + doctor_name_list + '</select></div></div><div class="col-md-12 form-group"><div class="col-md-4 plr-0">Prescribed Date & Time</div><div class="col-md-8 plr-0 display-flex"><input type="text" name="prescribed_date" class="form-control prescribed-date mr-10" id="drug-prescribed-date-0" readonly /><select name="prescribed_hours" class="form-control mr-10 input-width-small hours">' + hour_opt + '</select><select name="prescribed_mins" class="form-control mr-10 input-width-small minutes">' + mins_opt + '</select><select name="prescribed_session" class="form-control input-width-small session">' + session_opt + '</select></div></div><div class="col-md-12 form-group"><div class="col-md-4 plr-0">Start Date</div><div class="col-md-8 plr-0 display-flex"><input type="text" name="start_date" class="form-control start-date mr-10" id="start-date-0" readonly /><select name="start_hours" class="form-control mr-10 input-width-small hours">' + hour_opt + '</select><select name="start_mins" class="form-control mr-10 input-width-small minutes">' + mins_opt + '</select><select name="start_session" class="form-control input-width-small session">' + session_opt + '</select></div></div>');
            $('input#other_infusions_pump_type-IV').prop('checked', true);
            $('#prescription-save-btn').attr('disabled', false);

            break;
            case 'ORAL':
            $('.prescription-entry').html('<div class="col-md-12 prescription mt-5 plr-0"><div class="col-md-12 form-group"><div class="col-md-4 plr-0">Dose Required</div><div class="col-md-8 plr-0 display-flex"><input type="text" name="oral_dose_required" class="form-control" id="oral_dose_required-0" /><select name="drugs_dose_units" class="form-control input-width-small mr-15" id="drugs-dose-units-0">' + dose_list_oral + '</select><input type="text" name="oral_alt_dose_required" class="form-control" id="oral_alt_dose_required-0" /><select name="drugs_alt_dose_units" class="form-control input-width-small" id="drugs-alt-dose-units-0">' + dose_list_oral + '</select></div></div><div class="col-md-12 form-group"><div class="col-md-4 plr-0">Frequency</div><div class="col-md-8 plr-0"><select name="oral_frequency" class="oral-frequency full-width" id="oral_frequency-0">' + frequency_list + '</select></div></div><div class="col-md-12 form-group"><div class="col-md-4 plr-0">Route</div><div class="col-md-8 plr-0"><select name="oral_route" class="form-control" id="oral_route-0">' + route_list + '</select></div></div><div class="col-md-12 form-group"><div class="col-md-4 plr-0">Additional Instruction</div><div class="col-md-8 plr-0"><input type="text" name="oral_additional" class="form-control" id="oral_additional-0" /></div></div><div class="col-md-12 form-group"><div class="col-md-4 plr-0">Prescribed By (Doctor)</div><div class="col-md-8 plr-0"><select name="prescribed_by" class="form-control" id="prescribed_by-0">' + doctor_name_list + '</select></div></div><div class="col-md-12 form-group"><div class="col-md-4 plr-0">Prescribed Date & Time</div><div class="col-md-8 plr-0 display-flex"><input type="text" name="prescribed_date" class="form-control prescribed-date mr-10" id="drug-prescribed-date-0" readonly /><select name="prescribed_hours" class="form-control mr-10 input-width-small hours">' + hour_opt + '</select><select name="prescribed_mins" class="form-control mr-10 input-width-small minutes">' + mins_opt + '</select><select name="prescribed_session" class="form-control input-width-small session">' + session_opt + '</select></div></div><div class="col-md-12 form-group"><div class="col-md-4 plr-0">Start Date</div><div class="col-md-8 plr-0"><input type="text" name="start_date" class="form-control start-date" id="start-date-0" readonly /></div></div><div class="col-md-12 form-group start-hour-entry"><div class="col-md-4 plr-0">Starting hour</div><div class="col-md-8 plr-0" style="display: flex; align-items: center; white-space: nowrap;"><input type="text" id="frequency_start_time" class="form-control input-width-mini" name="frequency_start_time" readonly style="display: inline-block;"><span class="frequency_start_time_num"></span><div class="hour-session"><label class="display-inline"><input type="radio" name="starthour" value="am" id="starthour-am" /><span>AM</span></label><label class="display-inline"><input type="radio" name="starthour" value="pm" id="starthour-pm" /><span>PM</span></label></div></div></div><div class="col-md-12 form-group"><div class="col-md-4 plr-0">Review Date</div><div class="col-md-8 plr-0"><input type="text" name="oral_review_date" class="form-control review-date" id="oral-review-date-0" readonly /></div></div><div class="col-md-12 form-group display-flex prescription-type"><div class="col-md-4 plr-0">Prescription Type</div><div class="col-md-8 plr-0"><div class="pump-session"><label class="display-inline"><input type="radio" name="prescription_type" value="1" id="regular" /><span></span></label><span>Regular</span><label class="display-inline"><input type="radio" name="prescription_type" value="2" id="required" /><span></span></label><span class="required-width">As Required (PRN or SOS)</span><label class="display-inline"><input type="radio" name="prescription_type" value="4" id="stat" /><span></span></label><span class="stat-width">STAT / Once Only</span></div></div></div>');
            $("#oral_frequency-0").select2();

            $("#oral_frequency-0").val($('#oral_frequency-0 option:first-child').val()).trigger('change');

            $('#oral-review-date-0').datepicker({
                dateFormat: 'dd-mm-yy',
                changeMonth: true,
                changeYear: true
            }).val(default_date);

            @foreach($prescription_freq_dialpad as $property)
            addDiaelPad('{{ $property[0] }}', '{{ $property[0] }}', 'dial-pade-text-width', '{{ $property[1] }}', '{{ $property[2] }}', '{{ $property[3] }}', '{{ $property[4] }}');
            addLeadingZero('{{ $property[0] }}');
            @endforeach

            $('input#required').prop('checked', true);

            $('#prescription-save-btn').attr('disabled', false);
            break;
            default:
            $('#prescription-save-btn').attr('disabled', true);
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
</script>
@endsection