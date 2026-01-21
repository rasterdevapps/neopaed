$(document).ready(function() {

	var site_base_url = $('input[name="site_base_url"]').val();
	
	$(document).on('change', '#DOB, #op_date', function() {
		if (($('#op_date').datepicker('getDate') != '' && $('#op_date').datepicker('getDate') != null && typeof $('#op_date').datepicker('getDate') != 'undefined') && ($('#DOB').datepicker('getDate') != '' && $('#DOB').datepicker('getDate') != null && typeof $('#DOB').datepicker('getDate') !=  'undefined')) {
			getNeuroAge($('#op_date').datepicker('getDate'), $('#DOB').datepicker('getDate'));
		}
	});

	if ($('form').is('#pediatric-op-form')) {
		if (($('#op_date').datepicker('getDate') != '' && $('#op_date').datepicker('getDate') != null && typeof $('#op_date').datepicker('getDate') != 'undefined') && ($('#DOB').datepicker('getDate') != '' && $('#DOB').datepicker('getDate') != null && typeof $('#DOB').datepicker('getDate') !=  'undefined')) {
			getNeuroAge($('#op_date').datepicker('getDate'), $('#DOB').datepicker('getDate'));
		}
	}
	function immunizationStatus() {
		if ($('#immunization').val() == 'Due' || $('#immunization').val() == '' || $('#immunization').val() == 'Complete') {
			$('.op_vaccine').parent().hide();
		} else {
			$('.op_vaccine').parent().show();
		}
	}
	$('#immunization').on('change', function () {
		immunizationStatus();

	});
	immunizationStatus();
	function drugsStrength(drug_id, id) {
		if (drug_id == null || !(drug_id > 0)) {
			Showalert('error', 'Please select valid drug');
			$('.formulation' + id).html('');
			$('.generic_name' + id).val('');
		} else {
			$.ajax({
				Type: 'GET',
				url: site_base_url+'/masters/drugs-strength/'+ drug_id,
				success: function (responseText) {
					var option = '<option value="">N/A</option>';
					var generic_name = '';
					var selectedTag = (responseText.length == 1) ? 'selected' : '';
					$.each(responseText, function (index, values) {
						if (values.Value != '' && values.Value != null) {
							option += '<option value="' + values.Id + '" ' + selectedTag + '>' + values.Value + '</option>';
							generic_name = values.generic_name;
						}
					});
					$('.formulation' + id).html(option);
					$('.generic_name' + id).val(generic_name);
				},
				error: function (responseText) {
					var option = '<option value="">No data found</option>';
					var generic_name = 'No data found';
					$('.formulation' + id).html(option);
					$('.generic_name' + id).val(generic_name);
				}
			});
		}
	}
	$(document).on('change', '.drugs-changes', function () {
		var drug_id = $(this).val();
		var id = $(this).data('id');
		drugsStrength(drug_id, id);
		$(this).parent().parent().find('td .standard_dose').attr('disabled', false);
	});
	$('.drugs-changes1').change(function () {
		var drug_id = $(this).val();
		var id = $(this).data('id');
		drugsStrength(drug_id, id);
	});
	$('.op_vaccine_add').click(function () {
		var list = $('select[name="temp_vaccines"]').html();
		var option = '<tr>';
		option += '<td class="full-width"><select name="Vaccine[]" class="form-control">' + list + '</select></td>';
		option += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>';
		option += '</tr>';
		$('.op_vaccine tbody').append(option);
	});
	$('#pediatric-op-form .save-button-shadow').on('click', function(e) {
		e.preventDefault();
		var flag = $(this).attr('data-flag');
		$('#print_flag').val(flag);
		if ($('#pediatric-op-form').valid() === true) {
			$('.save-button-shadow').attr('disabled', true);
			$('#pediatric-op-form').submit();
		}
	});
	$('.edit-button-shadow:not(.custom-submit)').on('click', function(e) {
		e.preventDefault();
		var flag = $(this).attr('data-flag');
		$('#print_flag').val(flag);
		$('#pediatric-op-form').submit();
	});
	jQuery('#current_weight').keyup(function() {
		this.value = this.value.replace(/[^0-9]/g, '');
		$("#current_weight_kgs").empty();
		var Current_Wt = $('#current_weight').val() / 1000;
		$('#current_weight_kgs').val(Current_Wt);
	});
	jQuery('#current_weight_kgs').keyup(function() {
		$("#current_weight").empty();
		var Current_Wt = $('#current_weight_kgs').val() * 1000;
		$('#current_weight').val(Current_Wt);
	});

	$('#current_weight_kgs, #current_length').focusout(function() {
		var wt = $('#current_weight_kgs').val();
		var length = $('#current_length').val();
		if  (wt != '' && length != '') {
			length = length / 100;
			var bmi = wt / (length * length);
			bmi = bmi.toFixed(2);
			if (bmi != 'Infinity') {
				$('#current_bmi').val(bmi);
			}
		}
	});


	$("#pediatric-op-form").validate({
		rules: {
			op_date: {
				required: true,
			},
			BabyName: {
				required: true
			},
			mother_name: {
				required: true
			},
			DOB: {
				required: true
			},
			hospital_name: {
				required: true
			},
			seen_by: {
				required: true
			},
		},

		showErrors: function (errorMap, errorList) {

			this.defaultShowErrors();
			if (typeof errorList[0] != "undefined") {
				var errorDiv = $('.has-error:visible').first();
				var position = errorDiv.offset().top;
	            // var position = $(errorList[0].element).position().top;
				$('html, body').animate({
					scrollTop: position
				}, 300);
			}
		}
	});

	var vaccine_chart_link = $('.vaccine-chart-print-btn').attr('href');
	vaccine_chart_link = vaccine_chart_link + '?module=pediatric';
	$('.vaccine-chart-print-btn').attr('href', vaccine_chart_link);

	$('.custom-submit').on('click', function(e) {
		e.preventDefault();
		var id = $('input[name="id"]').val();
		if ($('#pediatric-op-form').valid() === true) {
			var flag = $(this).attr('data-flag');
			$('#print_flag').val(flag);
			$('.edit-button-shadow').prop('disabled', true);

			var serial = $($("#pediatric-op-form")[0].elements).not("textarea").serializeArray();

			var editor_content0 = {'name': 'current_status', 'value': $('#current_status').html() };
			serial.push(editor_content0);
			var editor_content1 = {'name': 'hopi', 'value': $('#hopi').html() };
			serial.push(editor_content1);
			var editor_content2 = {'name': 'development', 'value': $('#development').html() };
			serial.push(editor_content2);
			var editor_content3 = {'name': 'immunization_content', 'value': $('#immunization_content').html() };
			serial.push(editor_content3);
			var editor_content4 = {'name': 'examination', 'value': $('#examination').html() };
			serial.push(editor_content4);
			var editor_content5 = {'name': 'impression', 'value': $('#impression').html() };
			serial.push(editor_content5);
			var editor_content6 = {'name': 'advice', 'value': $('#advice').html() };
			serial.push(editor_content6);

			$(this).html('<i class="fas fa-spinner fa-pulse"></i> Loading...');
			var current_element = $(this);
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				type: 'POST',
				data: serial,
				url: site_base_url+"/pediatric-out-patient/"+id,
				success: function (response) {
					if (flag == 2) {
						Showalert(response.type, response.message);
						$('.edit-button-shadow').prop('disabled', false);
						current_element.html('<i class="fa fa-floppy-o"></i> <span>Update</span>');
						var medication_ids = response.medication_id;
						medication_update(medication_ids);
					}
				},
				error: function()
				{
					Showalert('error', 'Something went wrong, Please try again later...!');
				}
			});
		}
	});

	$(document).on('click', '.standard_dose_remove', function() {
		var standard_dose_class = $(this).parents('tr').attr('class');
		$('.'+standard_dose_class).remove();
	});

	$(document).on('click', '.medication_remove', function() {
		var standard_dose_class = $(this).parents('tr').attr('data-id');
		$(this).parents('tr').remove();
	});
	
	tinymce.init({
		selector: '.tinymce-body',
		menubar: false,
		inline: true,
		plugins: 'preview powerpaste casechange importcss autolink link table lists tinymcespellchecker',
		toolbar: ['undo redo | bold italic underline strikethrough | fontfamily fontsize blocks |  numlist bullist | casechange | table'],
		content_style: '.tinymce-body { font-family: "times new roman", times, serif; font-size: 12pt; }',
	});
	
	$('input[name="review_days"]').blur(function () {
		var reviewDays = $(this).val();
		getReviewdays(reviewDays);
	});

	function getReviewdays(reviewDays) {
		$.ajax({
			Type: 'GET',
			url: site_base_url+"/out-patient-review/"+reviewDays,
			success: function (responseText) {
				$('input[name="review"]').val(responseText.next_review);
			},
			error: function (responseText) {}
		});
	}
});
