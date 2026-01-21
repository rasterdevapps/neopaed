$(document).ready(function() {

	$('#issa_form .reset').on('click', function() {
		$(this).parent().parent().parent().find('.box-selection').removeClass('selection-highlighter');
		$(this).parent().parent().parent().find('input').val('');
		$(this).parent().parent().parent().find('.textarea-container').addClass('hide');
		$(this).parent().parent().parent().find('textarea').val('');
		var problem_type = $(this).find('.answer-input').attr('data-problem');
		if (problem_type > 0) {
			issaScoreIterator(problem_type);
		}
	});
});

$(document).on('click', '#issa_form .box-selection', function(e) {
	var current_element = $(this);
	var parent_current_element = current_element.parent();

	parent_current_element.find('span').removeClass('selection-highlighter');
	current_element.addClass('selection-highlighter');
	var ques_id = parent_current_element.attr('data-ques_id');
	var answer = current_element.attr('data-option');

	if (typeof e.originalEvent !== 'undefined') {
		var category_type = parent_current_element.attr('data-category');
		$('input[name="issa_answer['+ques_id+']"]').val(answer);
		if (category_type > 0) {
			issaScoreIterator(category_type);
		}
	}
});

function issaScoreIterator(category_type) {
	var current_category_value = 0;
	$('#issa_form .answer-input[data-category="'+category_type+'"]').each(function() {
		var value = $(this).find('input').val();
		value = parseInt(value);
		if (value >= 0) {
			current_category_value = current_category_value + value;
		}
	});
	if (current_category_value > 0) {
		if (category_type == 1) {
			$('input[name="srr"]').val(current_category_value).trigger('change');
			$('#srr-data').html(current_category_value);
		} else if (category_type == 2) {
			$('input[name="er"]').val(current_category_value).trigger('change');
			$('#er-data').html(current_category_value);
		} else if (category_type == 3) {
			$('input[name="slc"]').val(current_category_value).trigger('change');
			$('#slc-data').html(current_category_value);
		} else if (category_type == 4) {
			$('input[name="bp"]').val(current_category_value).trigger('change');
			$('#bp-data').html(current_category_value);
		} else if (category_type == 5) {
			$('input[name="sa"]').val(current_category_value).trigger('change');
			$('#sa-data').html(current_category_value);
		} else if (category_type == 6) {
			$('input[name="cc"]').val(current_category_value).trigger('change');
			$('#cc-data').html(current_category_value);
		}
	}
}

$(window).load(function(){
	setTimeout(function() {
		for (var ques_id = 1; ques_id <= 40; ques_id++) {
			var answer = $('input[name="issa_answer['+ques_id+']"]').val();
			if (!(answer != '' && answer != 0)) {
				$('input[name="issa_answer['+ques_id+']"]').val(0);
			}
			$("#issa_form .answer-input[data-ques_id="+ques_id+"] .box-selection.selected-" + answer).trigger('click');
		}
		for (var category_id = 1; category_id <= 6; category_id++) {
			issaScoreIterator(category_id);
		}
	}, 15);
});
