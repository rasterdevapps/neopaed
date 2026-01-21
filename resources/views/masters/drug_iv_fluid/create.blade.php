@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="{!! url('/') !!}">Dashboard</a>
        </li>
        <li>
            <a href="{!! action('Masters\DrugIvFluidController@index') !!}">Drug & Iv Fluid</a>
        </li>
        <li class="current">
            <a>Create</a>
        </li>
    </ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
{!! Form::open(['url' => action('Masters\DrugIvFluidController@store'),'id'=> 'checkform']) !!}
<div class="row row-spacing select-container-main">
    <div class="master-layout table-add-more">
        {!! Form::hidden('Id',null,['class'=>'form-control','id'=>'Id']) !!}
        <div class="hide">
            <select class="temp_durgs_iv_fluid_types">
                <option>N/A</option>
                @foreach($prescription_type as $key => $value)
                <option value="{!!$key!!}">{!!$value!!}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-12 overflow-auto plr-0">
            <table class="master_drug_ivfluid multi-row table full-width-fix">
                <thead>
                    <tr>
                        <th>Brand Name</th>
                        <th>Generic / Pharmacological Name</th>
                        <th>Value</th>
                        <th>Antibiotic / Antifungal / Antiviral</th>
                        <th>Drug Type</th>
                        @if ($role_id == env('SUPER_ADMIN_ROLE'))
                            <th>Type</th>
                        @endif
                        <th>Status</th>
                        <!-- <th>
                            <span>
                                <a class="btn btn-success master_drug_ivfluid_add btn-view btn_add" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                            </span>                
                        </th> -->
                    </tr>
                </thead>
                <tbody>
                    <tr data-len="0">
                        <td><input type="text" name="brand_name[]" value="" class="form-control input-fields-shadow input-width-medium valid"/></td>
                        <td><input type="text" name="generic_pharmacological_name[]" value="" class="form-control input-fields-shadow input-width-medium valid" /></td>
                        <td><input type="text" name="value[]" value="" class="form-control input-fields-shadow input-width-medium" /></td>
                        <td><input id="anti_status" data-size="small" name="anti_status[]" data-off="No" data-on="Yes" data-width="100" data-toggle="toggle" class="form-control switch-input" type="checkbox" @if(isset($results->anti_status) && $results->anti_status == 1) checked="checked" @endif></td>
                        <td>
                            <select name="type[]" class="form-control input-fields-shadow input-width-medium valid">
                                <option value="">N/A</option>
                                @foreach($prescription_type as $key => $value)
                                <option value="{!!$key!!}">{!!$value!!}</option>
                                @endforeach
                            </select>
                        </td>
                        @if ($role_id == 1)
                            <td>
                                <select name="usage_type" class="form-control input-fields-shadow input-width-medium">
                                    <option value="IC">Intensive Care</option>
                                    <option value="OP">OP</option>
                                </select>
                            </td>
                        @endif
                        <td>
                            <select name="status[]" class="form-control input-fields-shadow input-width-medium">
                                <option selected="selected" value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </td>
                        <!-- <td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td> -->
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-12 overflow-auto plr-0 set-default default-layout"></div>
        <div class="col-md-12 overflow-auto plr-0">
            <table class="multi-row table full-width-fix">
                <tfoot>
                    <tr>
                        <td colspan="6">
                            <div class="master-btn-layout">
                                <button type="submit" class="btn btn-primary btn-basic-shadow form-control input-width-medium"><i class="fa fa-floppy-o"></i> Save</button>
                                <a href="{!! action('Masters\DrugIvFluidController@index') !!}" class="btn btn-basic-shadow btn-default form-control input-width-medium" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> Cancel</a>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
{!! Form::close() !!}
<!-- /Page Content -->
@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        var unit_grams = <?php echo json_encode(ValuelistHelpers::infusiondoesunitgrams()) ?>;
        var unit_kg = <?php echo json_encode(ValuelistHelpers::infusiondoeskilograms()) ?>;
        var duration_type = <?php echo json_encode(ValuelistHelpers::infusiondoesduration()) ?>;
        var qty_unit = <?php echo json_encode(ValuelistHelpers::infusionquantityunits()) ?>;
        var syringe_size = <?php echo json_encode(ValuelistHelpers::getsyringesize()) ?>;
        var freq_list = <?php echo json_encode(ValuelistHelpers::drugFrequencyList()) ?>;
        var pump_type = <?php echo json_encode(['IV' => 'Syringe Pump', 'IVG' => 'Infusion Pump']) ?>;
        var unit_grams_oral = <?php echo json_encode(ValuelistHelpers::oraldoesunitgrams()) ?>;
        var oral_route_list = <?php echo json_encode(ValuelistHelpers::getRoute()) ?>;

        var dose_unit_g = dose_unit_kg = dose_unit_duration = qty_units = syringe_type = frequency_list = dose_list_oral = route_list = '';

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
        $.each(freq_list, function(index, value) {
            if (frequency_list == '') {
                frequency_list = '<option value="' + index + '">' + value + '</option>';
            } else {
                frequency_list += '<option value="' + index + '">' + value + '</option>';
            }
        });
        $.each(unit_grams_oral, function(index, value) {
            if (dose_list_oral == '') {
                dose_list_oral = '<option value="' + index + '">' + value + '</option>';
            } else {
                dose_list_oral += '<option value="' + index + '">' + value + '</option>';
            }
        });

        $.each(oral_route_list, function(index, value) {
            if (route_list == '') {
                route_list = '<option value="' + index + '">' + value + '</option>';
            } else {
                route_list += '<option value="' + index + '">' + value + '</option>';
            }
        });

        pump_type_list = '<option value="IV">Syringe Pump</option>';
        pump_type_list += '<option value="IVG">Infusion Pump</option>';

        var defaulttitle = '<div class="text-center border-top-light-grey"><b>SET DEFAULT VALUE</b></div>';

        $('select[name="type[]"]').on('change', function () {
            var drugtype = $('select[name="type[]"]').val();
            if (drugtype != '') {

                switch(drugtype) {
                    case 'IVDI':
                    var setfields = '<div class="prescription-default-setting"><div class="col-md-6"><div class="form-group"><label for="dose">Dose / Units</label><div class="display-flex"><input class="form-control input-fields-shadow" name="dose" type="text" id="dose"><select class="form-control input-fields-shadow input-width-small" name="dose_range">'+dose_unit_g+'</select><select class="form-control input-fields-shadow input-width-small" name="dose_units">'+dose_unit_kg+'</select><select class="form-control input-fields-shadow input-width-small" name="dose_duration">'+dose_unit_duration+'</select></div></div><div class="form-group"><label for="quantity">Qty / Unit</label><div class="display-flex"><input class="form-control input-fields-shadow" name="quantity" type="text" id="quantity"><select class="form-control input-fields-shadow input-width-small" name="quantity_units">'+qty_units+'</select></div></div><div class="form-group"><label for="syringe_size">Syringe Size (ml)</label><select class="form-control input-fields-shadow" id="syringe_size" name="syringe_size">'+syringe_type+'</select></div><div class="form-group"><label for="rate">Rate (ml/hr)</label><input class="form-control input-fields-shadow" name="rate" type="text" id="rate"></div></div><div class="col-md-6"><div class="form-group"><label for="instruction">Additional Instruction</label><textarea class="form-control" rows="4" name="instruction" cols="50" id="instruction"></textarea></div><div class="form-group"><label for="added_drug">Additional Drug Added</label><input class="form-control input-fields-shadow" name="added_drug" type="text" id="added_drug"></div><div class="form-group"><label for="added_dose">Dose &amp; Frequency Of Additional Drug</label><input class="form-control input-fields-shadow" name="added_dose" type="text" id="added_dose"></div></div></div>';
                    break;
                    case 'OIVD':
                    var setfields = '<div class="prescription-default-setting"><div class="col-md-6"><div class="form-group"><label for="dose">Dose / Required</label><div class="display-flex"><input class="form-control input-fields-shadow" name="dose" type="text" id="dose"><select class="form-control input-fields-shadow input-width-small" name="dose_range">'+dose_unit_g+'</select><input class="form-control input-fields-shadow" name="dose_alt" type="text"><select class="form-control input-fields-shadow input-width-small" name="dose_alt_range">'+dose_unit_g+'</select></div></div><div class="form-group"><label for="frequency">Frequency</label><select class="form-control input-fields-shadow" id="frequency" name="frequency">'+frequency_list+'</select></div><div class="form-group"><label for="syringe_size">Vol / Dose (ml)</label><input class="form-control input-fields-shadow" name="syringe_size" type="text" id="syringe_size"></div></div><div class="col-md-6"><div class="form-group"><label for="rate">Rate (ml/hr)</label><input class="form-control input-fields-shadow" name="rate" type="text" id="rate"></div><div class="form-group"><label for="instruction">Additional Instruction</label><textarea class="form-control" rows="4" name="instruction" cols="50" id="instruction"></textarea></div></div></div>';
                    break;
                    case 'OIVI':
                    var setfields = '<div class="prescription-default-setting"><div class="col-md-6"><div class="form-group"><label for="syringe_size">Volume To Be Infused (ml)</label><input class="form-control input-fields-shadow" name="syringe_size" type="text" id="syringe_size"></div><div class="form-group"><label for="rate">Rate (ml/hr)</label><input class="form-control input-fields-shadow" name="rate" type="text" id="rate"></div><div class="form-group"><label for="route">Pump Mode</label><select class="form-control input-fields-shadow" id="route" name="route">'+pump_type_list+'</select></div></div><div class="col-md-6"><div class="form-group"><label for="instruction">Additional Instruction</label><input class="form-control input-fields-shadow" name="instruction" type="text" id="instruction"></div><div class="form-group"><label for="added_drug">Additional Drug Added</label><input class="form-control input-fields-shadow" name="added_drug" type="text" id="added_drug"></div><div class="form-group"><label for="added_dose">Dose &amp; Frequency Of Additional Drug</label><input class="form-control input-fields-shadow" name="added_dose" type="text" id="added_dose"></div></div></div>';
                    break;
                    case 'ORAL':
                    var setfields = '<div class="prescription-default-setting"><div class="col-md-6"><div class="form-group"><label for="dose">Dose / Required</label><div class="display-flex"><input class="form-control input-fields-shadow" name="dose" type="text" id="dose"><select class="form-control input-fields-shadow input-width-small" name="dose_range">'+dose_list_oral+'</select><input class="form-control input-fields-shadow" name="dose_alt" type="text"><select class="form-control input-fields-shadow input-width-small" name="dose_alt_range">'+dose_list_oral+'</select></div></div><div class="form-group"><label for="frequency">Frequency</label><select class="form-control input-fields-shadow" id="frequency" name="frequency">'+frequency_list+'</select></div></div><div class="col-md-6"><div class="form-group"><label for="route">Route</label><select class="form-control input-fields-shadow" id="route" name="route">'+route_list+'</select></div><div class="form-group"><label for="instruction">Additional Instruction</label><textarea class="form-control" rows="4" name="instruction" cols="50" id="instruction"></textarea></div></div></div>';
                    break;
                }

                $('.default-layout').html(defaulttitle+setfields);
            } else {
                $('.default-layout').html('');
            }
        });

        $('#checkform tfoot .btn.btn-primary').on('click', function (event) {

            $('#checkform .valid').each(function () {
                $(this).rules("add", {
                    required: true
                });
            });

            if ($('#checkform').validate().form()) {
                $(this).prop('disabled', true);

                $(this).html('<i class="fas fa-spinner fa-pulse"></i> Loading...');
                $('#checkform').submit();
                return true;
            } else {
                return false;
            }
        });

        $('#checkform').validate();

        $(document).on('keyup', 'input[name="dose"], input[name="quantity"], input[name="rate"], input[name="dose_alt"], input[name="syringe_size"]', function() {
            $(this).val(this.value.replace(/[^0-9,.]/g, ''));
        });

    });
</script>
@endsection
