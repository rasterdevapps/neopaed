// ALTER TABLE "neuro_visit_details"
// ADD "affective_problem" smallint NULL,
// ADD "anxiety_problem" smallint NULL,
// ADD "pervasive_developmental_problem" smallint NULL,
// ADD "attention_deficit_hyperactivity_problem" smallint NULL,
// ADD "oppositional_defiant_problem" smallint NULL;

var normal_range_text = 'Normal';
var medium_range_text = 'Borderline clinical range';
var risk_range_text = 'clinical range';

$(window).load(function(){
	var edited_answer = 0;
	setTimeout(function() {
		for (var ques_id = 1; ques_id < 25; ques_id++) {
			var answer = $('input[name="cbcl_answer['+ques_id+']"]').val();
			if (!(answer != '' && answer != 0)) {
				$('input[name="cbcl_answer['+ques_id+']"]').val(0);
			}
			$(".answer-input[data-ques_id="+ques_id+"]").find('.box-selection.selected-'+answer).trigger('click');
			edited_answer++;
		}
		setTimeout(function() {
			for (var ques_id = 25; ques_id < 50; ques_id++) {
				var answer = $('input[name="cbcl_answer['+ques_id+']"]').val();
				if (!(answer != '' && answer != 0)) {
					$('input[name="cbcl_answer['+ques_id+']"]').val(0);
				}
				$(".answer-input[data-ques_id="+ques_id+"]").find('.box-selection.selected-'+answer).trigger('click');
				edited_answer++;
			}
			setTimeout(function() {
				for (var ques_id = 50; ques_id < 75; ques_id++) {
					var answer = $('input[name="cbcl_answer['+ques_id+']"]').val();
					if (!(answer != '' && answer != 0)) {
						$('input[name="cbcl_answer['+ques_id+']"]').val(0);
					}
					$(".answer-input[data-ques_id="+ques_id+"]").find('.box-selection.selected-'+answer).trigger('click');
					edited_answer++;
				}
				setTimeout(function() {
					for (var ques_id = 75; ques_id <= 100; ques_id++) {
						var answer = $('input[name="cbcl_answer['+ques_id+']"]').val();
						if (!(answer != '' && answer != 0)) {
							$('input[name="cbcl_answer['+ques_id+']"]').val(0);
						}
						$(".answer-input[data-ques_id="+ques_id+"]").find('.box-selection.selected-'+answer).trigger('click');
						edited_answer++;
					}
					if (edited_answer > 0) {
						problemScoreIterator(1);
						problemScoreIterator(2);
						problemScoreIterator(3);
						problemScoreIterator(4);
						problemScoreIterator(5);
						overallstatus();
					}
				}, 10);
			}, 10);
		}, 10);
	}, 10);
});
$(document).ready(function() {

	$('#cbcl_form .reset').on('click', function() {
		$(this).parent().parent().parent().find('.box-selection').removeClass('selection-highlighter');
		$(this).parent().parent().parent().find('input').val('');
		$(this).parent().parent().parent().find('.textarea-container').addClass('hide');
		$(this).parent().parent().parent().find('textarea').val('');
		var problem_type = $(this).find('.answer-input').attr('data-problem');
		if (problem_type > 0) {
			problemScoreIterator(problem_type);
		}
	});
});

$(document).on('click', '#cbcl_form .box-selection', function(e) {
	var current_element = $(this);
	var parent_current_element = current_element.parent();

	parent_current_element.find('span').removeClass('selection-highlighter');
	current_element.addClass('selection-highlighter');
	var ques_id = parent_current_element.attr('data-ques_id');
	var answer = current_element.attr('data-option');
	var describe_status = parent_current_element.attr('data-describe-status');

	if (typeof e.originalEvent !== 'undefined') {
		$('textarea[name="cbcl_describe['+ques_id+']"]').val('');
		var problem_type = parent_current_element.attr('data-problem');
		$('input[name="cbcl_answer['+ques_id+']"]').val(answer);
		if (problem_type > 0) {
			problemScoreIterator(problem_type);
		}
	}

	if (describe_status == 1 && (answer == 1 || answer == 2)) {
		$('#describe-'+ques_id).removeClass('hide');
	} else {
		$('#describe-'+ques_id).addClass('hide');			
	}
});

function problemScoreIterator(problem_type) {
	var current_problem_value = 0;
	$('.answer-input[data-problem="'+problem_type+'"]').each(function() {
		var value = $(this).find('input').val();
		value = parseInt(value);
		if (value >= 0) {
			current_problem_value = current_problem_value + value;
		}
	});
	var status = normal_range_text;
	var status_number = 0;
	if (problem_type == 1) {
		if (current_problem_value == 6) {
			status = medium_range_text;
			status_number = 1;
		} else if (current_problem_value > 6) {
			status = risk_range_text;
			status_number = 2;
		} else {
			status = normal_range_text;
			status_number = 0;
		}
	} else if (problem_type == 2) {
		if (current_problem_value == 8) {
			status = medium_range_text;
			status_number = 1;
		} else if (current_problem_value > 8) {
			status = risk_range_text;
			status_number = 2;
		} else {
			status = normal_range_text;
			status_number = 0;
		}		
	} else if (problem_type == 3) {
		if (current_problem_value == 7 || current_problem_value == 8) {
			status = medium_range_text;
			status_number = 1;
		} else if (current_problem_value > 8) {
			status = risk_range_text;
			status_number = 2;
		} else {
			status = normal_range_text;
			status_number = 0;
		}		
	} else if (problem_type == 4) {
		if (current_problem_value == 10) {
			status = medium_range_text;
			status_number = 1;
		} else if (current_problem_value > 10) {
			status = risk_range_text;
			status_number = 2;
		} else {
			status = normal_range_text;
			status_number = 0;
		}		
	} else if (problem_type == 5) {
		if (current_problem_value == 8) {
			status = medium_range_text;
			status_number = 1;
		} else if (current_problem_value > 8) {
			status = risk_range_text;
			status_number = 2;
		} else {
			status = normal_range_text;
			status_number = 0;
		}		
	}
	$('#problem_type_'+problem_type).attr('data-status-code', status_number).val(current_problem_value+'||'+status_number);
	$('#problem_range_'+problem_type).html(current_problem_value + ' - ' + status);
	overallstatus();
}

function overallstatus() {
	var problem_type_1 = $('#problem_type_1').attr('data-status-code');
	var problem_type_2 = $('#problem_type_2').attr('data-status-code');
	var problem_type_3 = $('#problem_type_3').attr('data-status-code');
	var problem_type_4 = $('#problem_type_4').attr('data-status-code');
	var problem_type_5 = $('#problem_type_5').attr('data-status-code');

	var cbcl_interpretation = $('input[name="cbcl_interpretation"]').val();
	
	$('.cbcl-status-btn').addClass('hide');

	if (problem_type_1 == 2 || problem_type_2 == 2 || problem_type_3 == 2 || problem_type_4 == 2 || problem_type_5 == 2) {
		if (cbcl_interpretation != '') {
			$('.cbcl-status-btn.label-warning').removeClass('hide');
		}
		$('#problem-container .cbcl-status-btn.label-warning').removeClass('hide');
		$('input[name="cbcl_interpretation_status"]').val(2);
	} else if (problem_type_1 == 1 || problem_type_2 == 1 || problem_type_3 == 1 || problem_type_4 == 1 || problem_type_5 == 1) {
		if (cbcl_interpretation != '') {
			$('.cbcl-status-btn.label-info').removeClass('hide');
		}
		$('#problem-container .cbcl-status-btn.label-info').removeClass('hide');
		$('input[name="cbcl_interpretation_status"]').val(1);
	} else {
		if (cbcl_interpretation != '') {
			$('.cbcl-status-btn.label-success').removeClass('hide');
		}
		$('#problem-container .cbcl-status-btn.label-success').removeClass('hide');
		$('input[name="cbcl_interpretation_status"]').val(0);
	}
	if (cbcl_interpretation != '') {
		$('#cbcl-arrow').removeClass('hide');
	}
}

$('input[name="cbcl_interpretation"]').on('change', function() {
	overallstatus();
});
