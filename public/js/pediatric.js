$(document).ready(function() {

	var seletorArray = ['colour', 'cft', 'central_pulses', 'peripheral_pulses', 'cns', 'level_of_consciousness', 'seizures', 'type_of_seizure', 'general_body_movements', 'spontaneous_activity', 'cry', 'neonatal_reflexes', 'cranial_nerves', 'motor_system', 'sensory_system', 'meningeal_signs', 'cerebellar_signs', 'spine_cranium', 'rs', 'chest_movement', 'breath_sounds', 'air_entry', 'added_sounds', 'cvs', 'precordial_activity', 's1s2', 'apical_impulse', 'bounding_pulses', 'murmur', 'character_of_murmur', 'site_of_murmur', 'pallor', 'scalp', 'eyes', 'ears', 'nose', 'nostrils', 'lips', 'palate', 'neck', 'nipples', 'lymphadenopathy', 'umbilicus', 'edema', 'anterior_fontanelle', 'jaundice', 'hernial_orifices', 'femoral_pulses', 'genitalia', 'hips', 'anus', 'spine', 'rt_ul', 'rt_ll', 'lt_ul', 'lt_ll', 'skin', 'hairs', 'stage', 'gpallor', 'ihm', 'cyanosis', 'clubby', 'glymphadenopathy', 'pedal_edema', 'perculosis', 'cns_type', 'cn_meningeal_signs', 'cn_exam', 'ms_exam', 'deep_tendon', 'abdomen_status', 'skin_over_abdomen', 'liver', 'spleen', 'external_genitalia'];

	$.each(seletorArray,function(index,value){

		buildSelector(value);

	});

	$('.non-search-baby .by-search').attr('tabindex', '-1');

	var site_base_url = $('input[name="site_base_url"]').val();

	$("#pediatric-form").validate({
		rules: {
			BMrNo: {
				required: true,
			},
			BabyName: {
				required: true,
			},
			MotherName: {
				required: true
			},
			DOB: {
				required: true
			},
			BirthWeight: {
				// required: true
			},
			g_weeks: {
				// required: true,
				digits: true,
				max: 43
			},
			g_days: {
				// digits: true,
				min: 0,
				max: 6
			},
			Sex: {
				// required: true
			},
			admission_date: {
				// required: true
			},
			admission_weight: {
				// required: true
			},
			seen_by: {
				// required: true
			},
			hospital_name: {
				required: true
			}
		}
	});
      
      $(document).on('change', '#DOB, #admission_date', function() {
		if (($('#admission_date').datepicker('getDate') != '' && $('#admission_date').datepicker('getDate') != null && typeof $('#admission_date').datepicker('getDate') != 'undefined') && ($('#DOB').datepicker('getDate') != '' && $('#DOB').datepicker('getDate') != null && typeof $('#DOB').datepicker('getDate') !=  'undefined')) {
			getNeuroAge($('#admission_date').datepicker('getDate'), $('#DOB').datepicker('getDate'));
		}
	});

	if ($('form').is('#pediatric-form')) {
		if (($('#admission_date').datepicker('getDate') != '' && $('#admission_date').datepicker('getDate') != null && typeof $('#admission_date').datepicker('getDate') != 'undefined') && ($('#DOB').datepicker('getDate') != '' && $('#DOB').datepicker('getDate') != null && typeof $('#DOB').datepicker('getDate') !=  'undefined')) {
			getNeuroAge($('#admission_date').datepicker('getDate'), $('#DOB').datepicker('getDate'));
		}
	}

    
	$('.pediatric-save').on('click', function(e) {
		e.preventDefault();
		if ($('#pediatric-form').valid() === true) {
			$('.action-btn button').prop('disabled', true);
			$(this).html('<i class="fas fa-spinner fa-pulse"></i> Loading...');
			var print_flag = $(this).attr('data-flag');
			$('input[name="print_flag"]').val(print_flag);
			$('#create-pediatric form').submit();
		}
	});

	$('.pediatric-update').on('click', function(e) {
		e.preventDefault();
		if ($('#pediatric-form').valid() === true) {
			$('.action-btn button').prop('disabled', true);
			$(this).html('<i class="fas fa-spinner fa-pulse"></i> Loading...');
			var print_flag = $(this).attr('data-flag');
			$('input[name="print_flag"]').val(print_flag);
			var current_clicked_element = $(this);
			if (print_flag == 1 || print_flag == 2) {

				var serial = $($("#pediatric-form")[0].elements).not("textarea:not(.textarea-need)").serializeArray();

				// var editor_content0 = {'name': 'complaints', 'value': CKEDITOR.instances['complaints'].getData() };
				// serial.push(editor_content0);
				// var editor_content1 = {'name': 'hopi', 'value': CKEDITOR.instances['hopi'].getData() };
				// serial.push(editor_content1);
				// var editor_content2 = {'name': 'treatment_history', 'value': CKEDITOR.instances['treatment_history'].getData() };
				// serial.push(editor_content2);
				// var editor_content3 = {'name': 'past_history', 'value': CKEDITOR.instances['past_history'].getData() };
				// serial.push(editor_content3);
				// var editor_content4 = {'name': 'perinatal_history', 'value': CKEDITOR.instances['perinatal_history'].getData() };
				// serial.push(editor_content4);
				// var editor_content5 = {'name': 'immunization', 'value': CKEDITOR.instances['immunization'].getData() };
				// serial.push(editor_content5);
				// var editor_content6 = {'name': 'development', 'value': CKEDITOR.instances['development'].getData() };
				// serial.push(editor_content6);
				// var editor_content7 = {'name': 'family_history', 'value': CKEDITOR.instances['family_history'].getData() };
				// serial.push(editor_content7);
				// var editor_content8 = {'name': 'general_examination', 'value': CKEDITOR.instances['general_examination'].getData() };
				// serial.push(editor_content8);
				// var editor_content9 = {'name': 'vitals_content', 'value': CKEDITOR.instances['vitals_content'].getData() };
				// serial.push(editor_content9);
				// var editor_content10 = {'name': 'anthropometry_content', 'value': CKEDITOR.instances['anthropometry_content'].getData() };
				// serial.push(editor_content10);
				// var editor_content11 = {'name': 'cns_findings', 'value': CKEDITOR.instances['cns_findings'].getData() };
				// serial.push(editor_content11);
				// var editor_content12 = {'name': 'rs_findings', 'value': CKEDITOR.instances['rs_findings'].getData() };
				// serial.push(editor_content12);
				// var editor_content13 = {'name': 'cvs_findings', 'value': CKEDITOR.instances['cvs_findings'].getData() };
				// serial.push(editor_content13);
				// var editor_content14 = {'name': 'any_other_abnormality', 'value': CKEDITOR.instances['any_other_abnormality'].getData() };
				// serial.push(editor_content14);
				// var editor_content15 = {'name': 'treatment', 'value': CKEDITOR.instances['treatment'].getData() };
				// serial.push(editor_content15);
				// var editor_content16 = {'name': 'discussion_findings', 'value': CKEDITOR.instances['discussion_findings'].getData() };
				// serial.push(editor_content16);
				// var editor_content17 = {'name': 'treatment_findings', 'value': CKEDITOR.instances['treatment_findings'].getData() };
				// serial.push(editor_content17);
				// var editor_content18 = {'name': 'discharge_findings', 'value': CKEDITOR.instances['discharge_findings'].getData() };
				// serial.push(editor_content18);

				var editor_content0 = {'name': 'complaints', 'value': $('#complaints').html() };
				serial.push(editor_content0);
				var editor_content1 = {'name': 'hopi', 'value': $('#hopi').html() };
				serial.push(editor_content1);
				var editor_content2 = {'name': 'treatment_history', 'value': $('#treatment_history').html() };
				serial.push(editor_content2);
				var editor_content3 = {'name': 'past_history', 'value': $('#past_history').html() };
				serial.push(editor_content3);
				var editor_content4 = {'name': 'perinatal_history', 'value': $('#perinatal_history').html() };
				serial.push(editor_content4);
				var editor_content5 = {'name': 'immunization', 'value': $('#immunization').html() };
				serial.push(editor_content5);
				var editor_content6 = {'name': 'development', 'value': $('#development').html() };
				serial.push(editor_content6);
				var editor_content7 = {'name': 'family_history', 'value': $('#family_history').html() };
				serial.push(editor_content7);
				var editor_content8 = {'name': 'general_examination', 'value': $('#general_examination').html() };
				serial.push(editor_content8);
				var editor_content9 = {'name': 'vitals_content', 'value': $('#vitals_content').html() };
				serial.push(editor_content9);
				var editor_content10 = {'name': 'anthropometry_content', 'value': $('#anthropometry_content').html() };
				serial.push(editor_content10);
				var editor_content11 = {'name': 'cns_findings', 'value': $('#cns_findings').html() };
				serial.push(editor_content11);
				var editor_content12 = {'name': 'rs_findings', 'value': $('#rs_findings').html() };
				serial.push(editor_content12);
				var editor_content13 = {'name': 'cvs_findings', 'value': $('#cvs_findings').html() };
				serial.push(editor_content13);
				var editor_content14 = {'name': 'any_other_abnormality', 'value': $('#any_other_abnormality').html() };
				serial.push(editor_content14);
				var editor_content15 = {'name': 'treatment', 'value': $('#treatment').html() };
				serial.push(editor_content15);
				var editor_content16 = {'name': 'discussion_findings', 'value': $('#discussion_findings').html() };
				serial.push(editor_content16);
				var editor_content17 = {'name': 'treatment_findings', 'value': $('#treatment_findings').html() };
				serial.push(editor_content17);
				var editor_content18 = {'name': 'discharge_findings', 'value': $('#discharge_findings').html() };
				serial.push(editor_content18);

				var editor_content19 = {'name': 'investigations_test', 'value': $('textarea[name="investigations_test"]').val() };
				serial.push(editor_content19);

				var editor_content20 = {'name': 'ms_findings', 'value': $('#ms_findings').html() };
				serial.push(editor_content20);
				var editor_content21 = {'name': 'deep_tendon_findings', 'value': $('#deep_tendon_findings').html() };
				serial.push(editor_content21);
				var editor_content22 = {'name': 'abdomen_findings', 'value': $('#abdomen_findings').html() };
				serial.push(editor_content22);
				var editor_content23 = {'name': 'working_diagnosis', 'value': $('#working_diagnosis').html() };
				serial.push(editor_content23);
				var editor_content24 = {'name': 'condition_at_discharge', 'value': $('#condition_at_discharge').html() };
				serial.push(editor_content24);
				var editor_content25 = {'name': 'review_details', 'value': $('#review_details').html() };
				serial.push(editor_content25);
                var editor_content26 = {'name': 'surgery_notes', 'value': $('#surgery_notes').html() };
				serial.push(editor_content26);
				var editor_content27 = {'name': 'nutrition_history', 'value': $('#nutrition_history').html() };
				serial.push(editor_content27);
				var editor_content28 = {'name': 'allergy_contact_history', 'value': $('#allergy_contact_history').html() };
				serial.push(editor_content28);

				$.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type: 'POST',
					data: serial,
					url: site_base_url+"/pediatric-admission/"+$('input[name="id"]').val(),
					success: function(response) {
						Showalert(response.type, response.message);

						if (print_flag == 1) {
							$('.action-btn button').prop('disabled', false);
							var next_tab = $('.nav.nav-tabs > .active').next('li').find('a');
							if (next_tab.length > 0) {
								if (next_tab.attr('href') == '#dischargeform') {
									current_clicked_element.html('<i class="fa fa-floppy-o" aria-hidden="true"></i> <span>Finish & Close</span>');
								} else {
									current_clicked_element.html('<i class="fa fa-floppy-o" aria-hidden="true"></i> <span>Update & Next</span>');
								}
								$('#admission-print').addClass('hide');
								$('#summary-print').addClass('hide');

								if (next_tab.attr('href') == '#working-diagnosis-form') {
									$('#admission-print').removeClass('hide');
								}
								if (next_tab.attr('href') == '#dischargeform') {
									$('#summary-print').removeClass('hide');
								}
								next_tab.trigger('click');
							} else {
								window.location.href = response.list_url;
							}

						} else if (print_flag == 2) {
							current_clicked_element.html('<i class="fa fa-floppy-o" aria-hidden="true"></i> <span>Update</span>');
							$('.action-btn button').prop('disabled', false);
						} 
					},
					error: function () {
						Showalert('error', 'Something went wrong, Please try again later...!');
					}
				});
			} else {
				$('#edit-pediatric form').submit();
			}
		}
	});

	$('.nav-tabs li a').click(function() {
		var current_tab = $(this);
		if ($("#pediatric-form").valid() === false) {
			$("#pediatric-form").valid();
			return false;
		}
		$('#admission-print').addClass('hide');
		$('#summary-print').addClass('hide');

		if (current_tab.attr('href') == '#working-diagnosis-form') {
				$('#admission-print').removeClass('hide');
		}
		if (current_tab.attr('href') == '#dischargeform') {
			$('#summary-print').removeClass('hide');
		}
	});

	$('select[name^="investigations"]').on('change', function(e) {
        if (typeof e.added != 'undefined') {
            var package_id = e.added.id;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                data: {
                    package_id: package_id
                },
				url: site_base_url+"/get-test-names",
                success: function(response) {
                    var result = response.results;
                    var package_id = '';
                    var test_name = '';
                    $.each(result, function(key, value) {
                        $.each(value, function(test_key, test_value) {
                            $('#investigations_test').tagsinput('add', test_value.test_name);
                        });
                    });
                }
            });
        }
    });

	$('select[name^="investigations"]').on("removed", function(e) {
	    var removed_value = e.val;
	    $.ajax({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        },
	        type: 'GET',
	        data: {
	            package_id: removed_value
	        },
			url: site_base_url+"/get-test-names",
	        success: function(response) {
	            var result = response.results;
	            $.each(result, function(key, value) {
	                $.each(value, function(test_key, test_value) {
	                    $('#investigations_test').tagsinput('remove', test_value.test_name);
	                });
	            });
	        }
	    });
	});

	$('#investigations_test').tagsinput({
        allowDuplicates: false
    });

    if($('#investigations_test').val() && $('#investigations_test').val() != '' && $('#investigations_test').val() != null)
    {
        var investigation_values = $('#investigations_test').val().split(',');
        if (investigation_values.length > 0) {
            $.each(investigation_values, function(index, value)
            {
                $('#investigations_test').tagsinput('add', value);
            });
        }
    }

	tinymce.init({
	  	selector: '.tinymce-body',
		menubar: false,
		inline: true,
	 	plugins: 'preview powerpaste casechange importcss autolink link table lists tinymcespellchecker',
		toolbar: ['undo redo | bold italic underline strikethrough | fontfamily fontsize blocks', 'alignleft aligncenter alignright alignjustify |  numlist bullist | forecolor backcolor casechange | preview | table']
	});

	$('input[name="current_weight"]').keyup(function() {
	    this.value = this.value.replace(/[^0-9]/g, '');
	    $("input[name='current_weight_kg']").empty();
	    var birth_weight = $('input[name="current_weight"]').val() / 1000;
	    $("input[name='current_weight_kg']").val(birth_weight);
	});

	gcsTotal();
	
	function gcsTotal() {
		var temp_eye_opening = $('.eye_opening.active').attr('data-value');
		var eye_opening = typeof temp_eye_opening !== 'undefined' ? temp_eye_opening : 0;
		var temp_verbal = $('.verbal.active').attr('data-value');
		var verbal = typeof temp_verbal !== 'undefined' ? temp_verbal : 0;
		var temp_motor = $('.motor.active').attr('data-value');
		var motor = typeof temp_motor !== 'undefined' ? temp_motor : 0;

		var gcs_total = parseInt(eye_opening) + parseInt(verbal) + parseInt(motor);

		if (gcs_total > 0) {
			$('#gcs-total').html(gcs_total + ' Points');
		} else {
			$('#gcs-total').html('');			
		}
	}

	$('#gcs-options-reset').on('click', function() {
		$('.eye_opening').removeClass('active');
		$('.verbal').removeClass('active');
		$('.motor').removeClass('active');
		gcsTotal();		
	});

	$('.eye_opening').on('click', function() {
		$('.eye_opening').removeClass('active');
		$(this).addClass('active');
		$('input[name="eye_opening"]').val($(this).attr('data-value'));
		gcsTotal();
	});
	$('.verbal').on('click', function() {
		$('.verbal').removeClass('active');
		$(this).addClass('active');
		$('input[name="verbal"]').val($(this).attr('data-value'));
		gcsTotal();		
	});
	$('.motor').on('click', function() {
		$('.motor').removeClass('active');
		$(this).addClass('active');
		$('input[name="motor"]').val($(this).attr('data-value'));
		gcsTotal();		
	});

	$('input[name="palpation_soft"]').on('click', function() {
		$('input[name="palpation_rigidity"]').prop('checked', false);
		$('input[name="palpation_guarding"]').prop('checked', false);
	});
	var palpation_rigidity;
	$('input[name="palpation_rigidity"]').on('click', function() {
		palpation_rigidity = !palpation_rigidity;
		$(this).prop('checked', palpation_rigidity);
		$('input[name="palpation_soft"]').prop('checked', false);
	});
	var palpation_guarding;
	$('input[name="palpation_guarding"]').on('click', function() {
		palpation_guarding = !palpation_guarding;
		$(this).prop('checked', palpation_guarding);
		$('input[name="palpation_soft"]').prop('checked', false);
	});
	$('input[name="palpation_tender"]').on('click', function() {
		$('input[name="palpation_non_tender"]').prop('checked', false);
	});
	$('input[name="palpation_non_tender"]').on('click', function() {
		$('input[name="palpation_tender"]').prop('checked', false);
	});
	liver();
	$('select[name="liver"]').on('change', function() {
		liver();
	});
	function liver() {
		var liver = $('select[name="liver"]').val();
		if (liver == 1) {
			$('#liver-palpation-value').slideDown();
		} else {
			$('#liver-palpation-value').slideUp();
		}
	}
	spleen();
	$('select[name="spleen"]').on('change', function() {
		spleen();
	});
	function spleen() {		
		var spleen = $('select[name="spleen"]').val();
		if (spleen == 1) {
			$('#spleen-palpation-value').slideDown();
		} else {
			$('#spleen-palpation-value').slideUp();
		}
	}
	
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
	var height = $('#current_length').val();
	var length = height;
	if  (wt != '' && length != '') {
		length = length / 100;
		var bmi = wt / (length * length);
		bmi = bmi.toFixed(2);
		if (bmi != 'Infinity') {
			$('#current_bmi').val(bmi);
		}

		var bsa = Math.sqrt((wt * height) / 3600);
		bsa = bsa.toFixed(2);
		if (bsa != 'NaN') {
			$('#current_bsa').val(bsa);
		}
	}
});

$('#character_of_murmur').parent().parent().hide();
if($('#murmur').prop('checked') === false)
{
	$('#character_of_murmur').parent().parent().slideUp();
}
else
{
	$('#character_of_murmur').parent().parent().slideDown();
}

$('#murmur').change(function()
{
	if($(this).prop('checked') === false)
	{
		$('#character_of_murmur').parent().parent().slideUp();
	}
	else
	{
		$('#character_of_murmur').parent().parent().slideDown();
	}
});
$('#cvs').change(function()
{
	if($(this).val() == "Normal")
	{
		$('#precordial_activity').val('Normal').trigger('change');
		$('#s1s2').val('Normal').trigger('change');
		$('#apical_impulse').val('Normal').trigger('change');
	}
	else
	{
		$('#precordial_activity').val('').trigger('change');
		$('#s1s2').val('').trigger('change');
		$('#apical_impulse').val('').trigger('change');
	}
});

$('#rs').change(function()
{
	if($(this).val() == "Normal")
	{
		$('#chest_movement').val('Symmetrical').trigger('change');
		$('#breath_sounds').val('Normal Vesicular').trigger('change');
		$('#air_entry').val('Equal').trigger('change');
	}
	else
	{
		$('#chest_movement').val('').trigger('change');
		$('#breath_sounds').val('').trigger('change');
		$('#air_entry').val('').trigger('change');
	}
});
$(document).on('click', '.remove-discharge-medications-pediatric', function()
{
	$(this).closest('tr').remove();
	updateSno();
});
$('.add-discharge-medications-pediatric').click(function()
{
	var added_row = '<tr><td style="vertical-align: middle;"></td><td><input class="input-with-bottom-border" name="drug_name[]" type="text" /></td><td><input class="input-with-bottom-border" name="dose[]" type="text" /></td><td><input class="input-with-bottom-border" name="route[]" type="text" /></td><td><input class="input-with-bottom-border" name="frequency[]" type="text" /></td><td><div class="col-md-11 col-xs-10 px-0"><input class="input-with-bottom-border" name="duration[]" type="text" /> </div><div class="col-md-1 col-xs-2 px-0"><a href="javascript:void(0);" class="btn btn-danger btn-view pull-right remove-discharge-medications-pediatric"><i class="fa fa-trash"></i></a></div></td></tr>';
	$('.discharge-medications-table tbody').append(added_row);
	updateSno();
});


function updateSno()
{
	var index = 1;
	$('.discharge-medications-table tbody tr').each(function()
	{
		var sno = index++;
		$(this).children().eq(0).text(sno+'.');
	});
}

surgery();

$('#surgery').change(function() {
	surgery();
});

function surgery(){
	var list = ['surgery_date', 'surgeon', 'anaesthetist', 'surgery_notes'];
	($('#surgery').prop('checked')== false)? makeDisableFade(list) : removeDisableFade(list);
}


function makeDisableFade(idList) {
	$.each(idList,function(key,value){
		$('#'+value).attr('disabled',true).parent().parent().hide();
	});
}

function removeDisableFade(idList){
	$.each(idList,function(key,value){
		$('#'+value).removeAttr('disabled').parent().parent().show();
	});
}
$('.surgery-date').datepicker({
	dateFormat: 'dd-mm-yy',
	yearRange: "-60:+02",
	changeMonth: true,
	changeYear: true,
	maxDate: '+0M',
});

treatmentSpecialist();

$('#treatment_specialist').change(function() {
	treatmentSpecialist();
});

function treatmentSpecialist(){
	var list = ['treatment_findings', 'specialist-doctor'];
	($('#treatment_specialist').prop('checked')== false)? makeDisableFade(list) : removeDisableFade(list);
}

$(document).on('click', '.right_buttons', function () {
	$('.right_buttons').addClass('btn-secondary').removeClass('btn-primary');
	$(this).removeClass('btn-secondary').addClass('btn-primary');
	$('#pupils_right_screening').val($(this).data('button_val'));
});
$(document).on('click', '.left_buttons', function () {
	$('.left_buttons').addClass('btn-secondary').removeClass('btn-primary');
	$(this).removeClass('btn-secondary').addClass('btn-primary');
	$('#pupils_left_screening').val($(this).data('button_val'));
});
$(document).on('change', '.drugs-changes', function () {
	var drug_id = $(this).val();
	var id = $(this).data('id');
	drugsStrength(drug_id, id);
});
$(document).on('change', '.m-drugs-changes', function () {
	var drug_id = $(this).val();
	var id = $(this).data('id');
	pediatricDrugsStrength(drug_id, id);
});
$(document).on('change', '.t-drugs-changes', function () {
	var drug_id = $(this).val();
	var id = $(this).data('id');

	pediatricDrugsStrength(drug_id, id,'treament_medication');
});

var site_url = $('input[name="site_base_url"]').val();
function drugsStrength(drug_id, id,type='') {
	if (drug_id == null || !(drug_id > 0)) {
		Showalert('error', 'Please select valid drug');
		$('.m_formulation' + id).html('');
		$('.m_generic_name' + id).val('');
		$('.t_formulation' + id).html('');
		$('.t_generic_name' + id).val('');
	} else {
		$.ajax({
			Type: 'GET',
            url: site_url + '/masters/drugs-strength' + '/' + drug_id,
			success: function (responseText) {
             
				var option = '<option value="">N/A</option>';
				var generic_name = '';
				var formulation = '';

				$.each(responseText, function (index, values) {
					if (values.Value != '' && values.Value != null) {
						option += '<option value="' + values.Id + '">' + values.Value + '</option>';
						generic_name = values.generic_name;
						formulation = values.Id;
					}
				});
                if(type =='treament_medication'){
                
	                $('.t_formulation' + id).html(option);
					$('.t_generic_name' + id).val(generic_name);
					$('.t_formulation' + id).val(formulation);
	            } else{
					$('.m_formulation' + id).html(option);
					$('.m_generic_name' + id).val(generic_name);
					$('.m_formulation' + id).val(formulation);
			   }
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

function pediatricDrugsStrength(drug_id, id,type='') {
	if (drug_id == null || !(drug_id > 0)) {
		Showalert('error', 'Please select valid drug');
		$('.m_formulation' + id).val('');
		$('.m_generic_name' + id).val('');
		$('.t_formulation' + id).val('');
		$('.t_generic_name' + id).val('');
	} else {
		$.ajax({
			Type: 'GET',
            url: site_url + '/masters/drugs-strength' + '/' + drug_id,
			success: function (responseText) {
             
				var option = '<option value="">N/A</option>';
				var generic_name = '';
				//var formulation = '';

				$.each(responseText, function (index, values) {
					if (values.Value != '' && values.Value != null) {
						option += '<option value="' + values.Id + '">' + values.Value + '</option>';
						generic_name = values.generic_name;
						//formulation = values.Id;
					}
				});
                if(type =='treament_medication'){
                
	                //$('.t_formulation' + id).html(option);
					$('.t_generic_name' + id).val(generic_name);
					//$('.t_formulation' + id).val(formulation);
	            } else{
					//$('.m_formulation' + id).html(option);
					$('.m_generic_name' + id).val(generic_name);
					//$('.m_formulation' + id).val(formulation);
			   }
			},
			error: function (responseText) {
				var option = '<option value="">No data found</option>';
				var generic_name = 'No data found';
				//$('.formulation' + id).html(option);
				$('.generic_name' + id).val(generic_name);
			}

		});
	}
}
