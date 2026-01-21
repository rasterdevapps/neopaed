@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li><i class="icon-home"></i>
			<a href="{{ url('/') }}">Dashboard</a>
		</li>
		<li>
			<a href="{{ action('Masters\DrugIvFluidController@index') }}">Drug & Iv Fluid</a>
		</li>       
		<li class="current">
			<a>Edit</a>
		</li>                                              
	</ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
@php 
$unit_grams = ValuelistHelpers::infusiondoesunitgrams();
$unit_kg = ValuelistHelpers::infusiondoeskilograms();
$duration_type = ValuelistHelpers::infusiondoesduration();
$qty_unit = ValuelistHelpers::infusionquantityunits();
$syringe_size = ValuelistHelpers::getsyringesize();
$freq_list = ValuelistHelpers::drugFrequencyList();
$pump_type = ['IV' => 'Syringe Pump', 'IVG' => 'Infusion Pump'];
$unit_grams_oral = ValuelistHelpers::oraldoesunitgrams();
$oral_route_list = ValuelistHelpers::getRoute();
@endphp
<div class="row row-spacing">
	<div class="col-md-8 col-md-offset-2 col-sm-12 col-xs-12 table-add-more ptb-15">
		{!! Form::hidden('pres_default', $results) !!}
		{!! Form::model($results,['method'=> 'PATCH','url' => action('Masters\DrugIvFluidController@update',$results->id),'id'=>'EditForm', 'class'=>'m-0']) !!}
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
							{!! Form::label('brand_name','Name:') !!}
							{!! Form::text('brand_name',null,['class'=>'form-control input-fields-shadow']) !!}
						</div>
						<div class="form-group">
							{!! Form::label('value','Value:') !!}
							{!! Form::text('value',null,['class'=>'form-control input-fields-shadow']) !!}
						</div>                      
						<div class="form-group">
							{!! Form::label('anti_status','Antibiotic / Antifungal / Antiviral:') !!}
							<div>
								<input id="anti_status" data-size="small" name="anti_status" data-off="No" data-on="Yes" data-width="100" data-toggle="toggle" class="form-control switch-input" type="checkbox" @if(isset($results->anti_status) && $results->anti_status == 1) checked="checked" @endif>
							</div>
						</div>   
                        @if ($role_id == env('SUPER_ADMIN_ROLE'))
							<div class="form-group">
								{!! Form::label('usage_type','Type:') !!}
								{!! Form::select('usage_type',['IC'=>'Intensive Care', 'OP'=>'OP'],null,['class'=>'form-control input-fields-shadow']) !!}
							</div>    
                        @endif                  		
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
							{!! Form::label('generic_pharmacological_name','Generic / Pharmacological Name:') !!}
							{!! Form::text('generic_pharmacological_name',null,['class'=>'form-control input-fields-shadow']) !!}
						</div>
						<div class="form-group">
							{!! Form::label('type','Drug Type:') !!}
							{!! Form::select('type',$prescription_type,null,['class'=>'form-control input-fields-shadow']) !!}
						</div>                    
						<div class="form-group">
							{!! Form::label('status','Status:') !!}
							{!! Form::select('status',['1'=>'Active','0'=>'Inactive'],null,['class'=>'form-control input-fields-shadow']) !!}
						</div>   
					</div>
				</div>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12 set-default default-layout plr-0 prescription-default-setting"></div>
			<div class="col-md-12 col-sm-12 col-xs-12 border-top-light-grey pt-15 master-btn-layout mlr-must-0">
				<div class="col-md-3 col-sm-4">
					<button type="submit" class="btn btn-primary btn-basic-shadow form-control btn-block">
						<i class="fa fa-floppy-o"></i><span>Update</span>
					</button>
				</div>
				<div class="col-md-3 col-sm-4">
					<a href="{{ action('Masters\DrugIvFluidController@index') }}" class="btn btn-default btn-basic-shadow form-control btn-block" onclick="$('form')[0].reset();">
						<i class="fa fa-exclamation-circle"></i> <span>Cancel</span>
					</a>
				</div>
			</div>
		</div>

		{!! Form::close() !!}
		@include('errors.list')
	</div> <!-- /.col-md-12 -->
	<div class="sidebar-right panel panel-default hidden">
		<div class="">
			<h3>Search</h3>
			<div class="form-group">
				{!! Form::text('SearchField',null,['class'=>'form-control','id'=>'SearchField']) !!}
			</div>
			<div class="form-group">
				<a href="javascript:void(0);" class="btn btn-primary form-control search-list">Search</a>
			</div>
			<ul class="search-results list-group">
			</ul>
		</div>
	</div>                    
</div> <!-- /.row -->

@endsection
@section('scripts')
<script type="text/javascript">
	$(document).ready(function () {
		var result = JSON.parse($('input[name="pres_default"]').val());

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

		$(document).on('change', 'select[name="type"]', function () {
			var drugtype = $('select[name="type"]').val();
			if (drugtype != '') {

				switch(drugtype) {
					case 'IVDI':
					var setfields = '<div class="border-top-light-grey pt-15" id="prescription-1"><div class="col-md-6"><div class="form-group"><label for="dose">Dose / Units</label><div class="display-flex"><input class="form-control input-fields-shadow" name="dose" type="text" id="dose"><select class="form-control input-fields-shadow input-width-small" name="dose_range">'+dose_unit_g+'</select><select class="form-control input-fields-shadow input-width-small" name="dose_units">'+dose_unit_kg+'</select><select class="form-control input-fields-shadow input-width-small" name="dose_duration">'+dose_unit_duration+'</select></div></div><div class="form-group"><label for="quantity">Qty / Unit</label><div class="display-flex"><input class="form-control input-fields-shadow" name="quantity" type="text" id="quantity"><select class="form-control input-fields-shadow input-width-small" name="quantity_units">'+qty_units+'</select></div></div><div class="form-group"><label for="syringe_size">Syringe Size (ml)</label><select class="form-control input-fields-shadow" id="syringe_size" name="syringe_size">'+syringe_type+'</select></div><div class="form-group"><label for="rate">Rate (ml/hr)</label><input class="form-control input-fields-shadow" name="rate" type="text" id="rate"></div></div><div class="col-md-6"><div class="form-group"><label for="instruction">Additional Instruction</label><textarea class="form-control" rows="4" name="instruction" id="instruction"></textarea></div><div class="form-group"><label for="added_drug">Additional Drug Added</label><input class="form-control input-fields-shadow" name="added_drug" type="text" id="added_drug"></div><div class="form-group"><label for="added_dose">Dose &amp; Frequency Of Additional Drug</label><input class="form-control input-fields-shadow" name="added_dose" type="text" id="added_dose"></div></div></div>';

					$('.default-layout').html(defaulttitle+setfields);
					$('#prescription-1 input[name="dose"]').val(result.dose);
					$('#prescription-1 select[name="dose_range"]').val(result.dose_range);
					$('#prescription-1 select[name="dose_units"]').val(result.dose_units);
					$('#prescription-1 select[name="dose_duration"]').val(result.dose_duration);
					$('#prescription-1 input[name="quantity"]').val(result.quantity);
					$('#prescription-1 select[name="quantity_units"]').val(result.quantity_units);
					$('#prescription-1 select[name="syringe_size"]').val(result.syringe_size);
					$('#prescription-1 input[name="rate"]').val(result.rate);
					$('#prescription-1 textarea[name="instruction"]').val(result.instruction);
					$('#prescription-1 input[name="added_drug"]').val(result.added_drug);
					$('#prescription-1 input[name="added_dose"]').val(result.added_dose);
					break;
					case 'OIVD':
					var setfields = '<div class="border-top-light-grey pt-15" id="prescription-2"><div class="col-md-6"><div class="form-group"><label for="dose">Dose / Required</label><div class="display-flex"><input class="form-control input-fields-shadow" name="dose" type="text" id="dose"><select class="form-control input-fields-shadow input-width-small" name="dose_range">'+dose_unit_g+'</select><input class="form-control input-fields-shadow" name="dose_alt" type="text"><select class="form-control input-fields-shadow input-width-small" name="dose_alt_range">'+dose_unit_g+'</select></div></div><div class="form-group"><label for="frequency">Frequency</label><select class="form-control input-fields-shadow" id="frequency" name="frequency">'+frequency_list+'</select></div><div class="form-group"><label for="syringe_size">Vol / Dose (ml)</label><input class="form-control input-fields-shadow" name="syringe_size" type="text" id="syringe_size"></div></div><div class="col-md-6"><div class="form-group"><label for="rate">Rate (ml/hr)</label><input class="form-control input-fields-shadow" name="rate" type="text" id="rate"></div><div class="form-group"><label for="instruction">Additional Instruction</label><textarea class="form-control" rows="4" name="instruction" id="instruction"></textarea></div></div></div>';

					$('.default-layout').html(defaulttitle+setfields);
					$('#prescription-2 input[name="dose"]').val(result.dose);
					$('#prescription-2 select[name="dose_range"]').val(result.dose_range);
					$('#prescription-2 input[name="dose_alt"]').val(result.dose_alt);
					$('#prescription-2 select[name="dose_alt_range"]').val(result.dose_alt_range);
					$('#prescription-2 select[name="frequency"]').val(result.frequency);
					$('#prescription-2 input[name="syringe_size"]').val(result.syringe_size);
					$('#prescription-2 input[name="rate"]').val(result.rate);
					$('#prescription-2 textarea[name="instruction"]').val(result.instruction);
					break;
					case 'OIVI':
					var setfields = '<div class="border-top-light-grey pt-15" id="prescription-3"><div class="col-md-6"><div class="form-group"><label for="syringe_size">Volume To Be Infused (ml)</label><input class="form-control input-fields-shadow" name="syringe_size" type="text" id="syringe_size"></div><div class="form-group"><label for="rate">Rate (ml/hr)</label><input class="form-control input-fields-shadow" name="rate" type="text" id="rate"></div><div class="form-group"><label for="route">Pump Mode</label><select class="form-control input-fields-shadow" id="route" name="route">'+pump_type_list+'</select></div></div><div class="col-md-6"><div class="form-group"><label for="instruction">Additional Instruction</label><textarea class="form-control" rows="4" name="instruction" id="instruction"></textarea></div><div class="form-group"><label for="added_drug">Additional Drug Added</label><input class="form-control input-fields-shadow" name="added_drug" type="text" id="added_drug"></div><div class="form-group"><label for="added_dose">Dose &amp; Frequency Of Additional Drug</label><input class="form-control input-fields-shadow" name="added_dose" type="text" id="added_dose"></div></div></div>';

					$('.default-layout').html(defaulttitle+setfields);
					$('#prescription-3 input[name="syringe_size"]').val(result.syringe_size);
					$('#prescription-3 input[name="rate"]').val(result.rate);
					$('#prescription-3 select[name="route"]').val(result.route);
					$('#prescription-3 input[name="rate"]').val(result.rate);
					$('#prescription-3 textarea[name="instruction"]').val(result.instruction);
					$('#prescription-3 input[name="added_drug"]').val(result.added_drug);
					$('#prescription-3 input[name="added_dose"]').val(result.added_dose);
					break;
					case 'ORAL':
					var setfields = '<div class="border-top-light-grey pt-15" id="prescription-4"><div class="col-md-6"><div class="form-group"><label for="dose">Dose / Required</label><div class="display-flex"><input class="form-control input-fields-shadow" name="dose" type="text" id="dose"><select class="form-control input-fields-shadow input-width-small" name="dose_range">'+dose_list_oral+'</select><input class="form-control input-fields-shadow" name="dose_alt" type="text"><select class="form-control input-fields-shadow input-width-small" name="dose_alt_range">'+dose_list_oral+'</select></div></div><div class="form-group"><label for="frequency">Frequency</label><select class="form-control input-fields-shadow" id="frequency" name="frequency">'+frequency_list+'</select></div></div><div class="col-md-6"><div class="form-group"><label for="route">Route</label><select class="form-control input-fields-shadow" id="route" name="route">'+route_list+'</select></div><div class="form-group"><label for="instruction">Additional Instruction</label><textarea class="form-control" rows="4" name="instruction" id="instruction"></textarea></div></div></div>';

					$('.default-layout').html(defaulttitle+setfields);
					$('#prescription-4 input[name="dose"]').val(result.dose);
					$('#prescription-4 select[name="dose_range"]').val(result.dose_range);
					$('#prescription-4 input[name="dose_alt"]').val(result.dose_alt);
					$('#prescription-4 select[name="dose_alt_range"]').val(result.dose_alt_range);
					$('#prescription-4 select[name="frequency"]').val(result.frequency);
					$('#prescription-4 select[name="route"]').val(result.route);
					$('#prescription-4 textarea[name="instruction"]').val(result.instruction);
					break;
				}
			} else {
				$('.default-layout').html('');
			}
		});

		$('#EditForm').validate({
			rules: {
				brand_name: {
					required: true
				},
				generic_pharmacological_name: {
					required: true
				}
			}
		});

        $(document).on('keyup', 'input[name="dose"], input[name="quantity"], input[name="rate"], input[name="dose_alt"], input[name="syringe_size"]', function() {
            $(this).val(this.value.replace(/[^0-9,.]/g, ''));
        });

		loadWindowSystem();

	});

	function loadWindowSystem(){
		$('select[name="type"]').trigger('change');
	}
</script>
@endsection

