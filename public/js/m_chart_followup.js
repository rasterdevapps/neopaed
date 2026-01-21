var reset_click = false;
$(document).ready(function() {
    for (var i = 1; i <= 20; i++) {
        var input_value = $('input[name="answer[' + i + ']"]').val();
        if (input_value != '' && typeof input_value !== 'undefined') {
            $('#mchatscreening1 .box-selection[data-ques_id="' + i + '"][data-option="' + input_value + '"]').trigger('click');
        }
    }

    for (var i = 1; i <= 181; i++) {
        var input_value = $('input[name="followupanswer[' + i + ']"]').attr('data-val-copy');
        if (input_value != '' && typeof input_value !== 'undefined') {
            $('.box-selection[data-question-id="followupanswer[' + i + ']"][data-option="' + input_value + '"]').addClass('selection-highlighter').removeClass('hide').trigger('click');
        }
    }
    $('.m-chat-r.box-selection').on('click', function() {
        var selected_value = $(this).attr('data-option');
        var ques_id = $(this).attr('data-ques_id');
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.m-chat-r.box-selection').removeClass('selection-highlighter');
        $(this).parent().find('.selected-' + temp_selected_value).addClass('selection-highlighter');
        $('input[name="answer[' + ques_id + ']"]').val(selected_value);
        calculateMChatScore();
    });

    function calculateMChatScore() {
        var i = 0;
        $('.m-chat-r.box-selection.selection-highlighter').each(function() {
            var answer = $(this).attr('data-option');
            var correct_answer = $(this).attr('data-answer');
            if (answer != correct_answer) {
                i++;
                $('#r_total_score').removeClass('hide');
            }
        });
        $('.total_m_chat_score').text(i);
        var r_chat_val = parseInt($('#total_m_chat_score').text());
        var r_chat_followup_val = parseInt($('#total_m_chat_followup_score').text());
        $('#m-chat_tab .r_total_score').html(r_chat_val);
        $('#m-chat_tab .r_status').html('Normal').removeClass('label-danger').removeClass('label-warning').addClass('label-success');
        $('#mchatscreening1 .total-score-m-chat label').removeClass('label-danger').removeClass('label-warning').addClass('label-success');
        $('#f_total_score').addClass('hide');
        $('#m-chat-followup-tab').addClass('hide');
        if (r_chat_val < 3) {
            $('#m-chat_tab .f_total_score').html(r_chat_followup_val);
            $('#m-chat_tab .r_status').html('Low Risk').addClass('label-success').removeClass('label-danger').removeClass('label-warning');
            $('#m-chat_tab #f_total_score td span').addClass('display-none');
            $('#mchatscreening1 .total-score-m-chat label').addClass('label-success').removeClass('label-danger').removeClass('label-warning');
        } else if (r_chat_val >= 3 && r_chat_val <= 7) {
            $('#m-chat_tab #f_total_score td span').removeClass('display-none');
            $('#m-chat_tab .f_total_score').html(r_chat_followup_val);
            $('#m-chat-followup-tab').removeClass('hide');
            $('#f_total_score').removeClass('hide');
            $('#m-chat_tab .r_status').html('Medium Risk').removeClass('label-success').removeClass('label-danger').addClass('label-warning');
            $('#mchatscreening1 .total-score-m-chat label').removeClass('label-success').removeClass('label-danger').addClass('label-warning');
            if (r_chat_followup_val > 1) {
                $('#m-chat_tab .f_status').html('Higher Risk').removeClass('label-success').removeClass('label-warning').addClass('label-danger');
                $('#mchatscreening2 .total-score-m-chat label').removeClass('label-success').removeClass('label-warning').addClass('label-danger');
            } else {
                $('#m-chat_tab .f_status').html('Normal').removeClass('label-danger').removeClass('label-warning').addClass('label-success');
                $('#mchatscreening2 .total-score-m-chat label').removeClass('label-danger').removeClass('label-warning').addClass('label-success');
            }
        } else {
            $('#m-chat_tab .r_status').html('High Risk').removeClass('label-success').removeClass('label-warning').addClass('label-danger');
            $('#mchatscreening1 .total-score-m-chat label').removeClass('label-success').removeClass('label-warning').addClass('label-danger');
            $('#m-chat_tab #f_total_score td span').addClass('display-none');
        }
    }
    calculateMChatScore();

    function calculateMChatFollowUpScore() {
        var i = 0;
        $('input[name^="final_answer"]').each(function() {
            if ($(this).val() != '' && $(this).val() == 1 && ($(this).attr('name') == 'final_answer[2]' || $(this).attr('name') == 'final_answer[5]' || $(this).attr('name') == 'final_answer[12]')) {
                i++;
            }
            if ($(this).val() != '' && $(this).val() == 0 && ($(this).attr('name') != 'final_answer[2]' && $(this).attr('name') != 'final_answer[5]' && $(this).attr('name') != 'final_answer[12]')) {
                i++;
            }
        });
        $('.total_m_chat_followup_score').text(i);
        var r_chat_val = parseInt($('#total_m_chat_score').text());
        var r_chat_followup_val = parseInt($('#total_m_chat_followup_score').text());
        $('#m-chat_tab .r_total_score').html(r_chat_val);
        $('#m-chat_tab .r_status').html('Normal').removeClass('label-danger').removeClass('label-warning').addClass('label-success');
        $('#mchatscreening1 .total-score-m-chat label').removeClass('label-danger').removeClass('label-warning').addClass('label-success');
        if (r_chat_val < 3) {
            $('#m-chat_tab #f_total_score td span').removeClass('display-none');
            $('#m-chat_tab .f_total_score').html(r_chat_followup_val);
            $('#m-chat_tab .r_status').html('Low Risk').addClass('label-success').removeClass('label-danger').removeClass('label-warning');
            $('#mchatscreening1 .total-score-m-chat label').addClass('label-success').removeClass('label-danger').removeClass('label-warning');
            $('#m-chat_tab #f_total_score td span').addClass('display-none');
        } else if (r_chat_val >= 3 && r_chat_val <= 7) {
            $('#m-chat_tab #f_total_score td span').removeClass('display-none');
            $('#m-chat_tab .f_total_score').html(r_chat_followup_val);
            $('#m-chat_tab .r_status').html('Medium Risk').removeClass('label-success').removeClass('label-danger').addClass('label-warning');
            $('#mchatscreening1 .total-score-m-chat label').removeClass('label-success').removeClass('label-danger').addClass('label-warning');
            if (r_chat_followup_val > 1) {
                $('#m-chat_tab .f_status').html('Higher Risk').removeClass('label-success').removeClass('label-warning').addClass('label-danger');
                $('#mchatscreening2 .total-score-m-chat label').removeClass('label-success').removeClass('label-warning').addClass('label-danger');
            } else {
                $('#m-chat_tab .f_status').html('Normal').removeClass('label-danger').removeClass('label-warning').addClass('label-success');
                $('#mchatscreening2 .total-score-m-chat label').removeClass('label-danger').removeClass('label-warning').addClass('label-success');
            }
        } else {
            $('#m-chat_tab .r_status').html('High Risk').removeClass('label-success').removeClass('label-warning').addClass('label-danger');
            $('#mchatscreening1 .total-score-m-chat label').removeClass('label-success').removeClass('label-warning').addClass('label-danger');
            $('#m-chat_tab #f_total_score td span').addClass('display-none');
        }
    }
    calculateMChatFollowUpScore();
    $(document).on('change', 'input[name^="final_answer"]', function() {
        calculateMChatFollowUpScore();
    });
    $('#mchatscreening2 .reset').on('click', function() {
        reset_click = true;
        $(this).parents('tr').find('input').val('');
        var question_name = $(this).parents('tr').find('span:last-child').attr('data-question-id');
        var question_id = question_name.replace(/[a-z\[\]]/g, '');
        $('#description_' + question_id).addClass('display-none');
        $('#description_' + question_id).find('textarea').val('');
        $(this).parents('tr').find('span:last-child').removeClass('selection-highlighter').trigger('click');
        if (reset_click) {
            reset_click = false;
        }
    });
});
$(document).on('click', '#mchatscreening1 .box-selection', function() {
    var current_question_id = $(this).attr('data-ques_id');
    var current_question_answer = $(this).attr('data-option');
    current_question_answer = current_question_answer.toLowerCase();
    $('#question' + current_question_id + ' .main-question.selected-' + current_question_answer).trigger('click');
});
// question1
$(document).on('click', '#question1 .main-question', function() {
    var selected_value = $(this).attr('data-option');
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    var temp_selected_value = selected_value.toLowerCase();
    $(this).parents('li').find('.main-question').removeClass('selection-highlighter');
    $(this).parents('li').find('.main-question').addClass('hide');
    $(this).parents('li').find('.main-question.selected-' + temp_selected_value).addClass('selection-highlighter').removeClass('hide');
    $('#followupanswer1-pass').addClass('display-none');
    $('#followupanswer1-fail').addClass('display-none');
    $('#followupanswer1-Parital').addClass('display-none');
    $('#followupanswer1-No').addClass('display-none');
    $('#followupanswer1-Yes').addClass('display-none');
    $('#question1 .sub-question').removeClass('selection-highlighter');
    $('#followupanswer1-Parital .sub-question-2').removeClass('selection-highlighter');
    $('#question1 .sub-question-2').removeClass('selection-highlighter');
    $('input[name="final_answer[1]"]').val(0).trigger('change');
    
    $('input[name="followupanswer[23]"]').val('');
    $('input[name="followupanswer[24]"]').val('');
    $('input[name="followupanswer[25]"]').val('');
    $('input[name="followupanswer[26]"]').val('');
    $('input[name="followupanswer[27]"]').val('');
    $('input[name="followupanswer[28]"]').val('');
    $('input[name="followupanswer[29]"]').val('');
    $('input[name="followupanswer[30]"]').val('');

    if (selected_value != '') {
        $('#followupanswer1-Yes').removeClass('display-none');
        $('#followupanswer1-No').removeClass('display-none');
    }
});
$(document).on('click', '#question1 #followupanswer1-Yes .sub-question, #question1 #followupanswer1-No .sub-question', function() {
    var selected_value = '';
    if (!reset_click) {
        selected_value = $(this).attr('data-option');
    }
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    $(this).parent().find('.sub-question').removeClass('selection-highlighter');
    if (typeof selected_value != 'undefined' && selected_value != '') {
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.sub-question.selected-' + temp_selected_value).addClass('selection-highlighter');
    }
    $('#followupanswer1-Parital').addClass('display-none');
    $('#followupanswer1-pass').addClass('display-none');
    $('#followupanswer1-fail').addClass('display-none');
    $('#question1 .sub-question-2').removeClass('selection-highlighter');
    $('#followupanswer1-Parital .sub-question-2').removeClass('selection-highlighter');
    $('input[name="final_answer[1]"]').val(0).trigger('change');

    $('input[name="followupanswer[30]"]').val('');

    var question = 0;
    var score = 0;
    var score_no_2 = 0;
    var score_2 = 0;
    var score_no_2_2 = 0;
    $('#question1 #followupanswer1-Yes .sub-question.selection-highlighter').each(function() {
        var sub_selected_value = $(this).attr('data-option');
        if (sub_selected_value == 'Yes') {
            score += 1;
        }
        if (sub_selected_value == 'No') {
            score_no_2 += 1;
        }
        question += 1;
    });
    $('#question1 #followupanswer1-No .sub-question.selection-highlighter').each(function() {
        var sub_selected_value = $(this).attr('data-option');
        if (sub_selected_value == 'Yes') {
            score_2 += 1;
        }
        if (sub_selected_value == 'No') {
            score_no_2_2 += 1;
        }
        question += 1;
    });
    if (score > 0 && score_2 == 0) {
        $('#followupanswer1-pass').removeClass('display-none');
        $('input[name="final_answer[1]"]').val(1).trigger('change');
    } else if (score_2 > 0 && score == 0) {
        $('#followupanswer1-fail').removeClass('display-none');
    } else if ((score > 0 && score_2 > 0) || (score == 0 && score_no_2 > 0 && score_2 == 0 && score_no_2_2 > 0)) {
        $('#followupanswer1-Parital').removeClass('display-none');
    }
});
$(document).on('click', '#question1 #followupanswer1-Parital .sub-question-2', function() {
    var sub_selected_value_2 = $(this).attr('data-option');
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(sub_selected_value_2);
    sub_selected_value_2 = sub_selected_value_2.toLowerCase();
    $(this).parents('.followupanswer1').find('.sub-question-2').removeClass('selection-highlighter');
    $(this).parents('.followupanswer1').find('.sub-question-2.selected-' + sub_selected_value_2).addClass('selection-highlighter');
    $('#followupanswer1-fail').addClass('display-none');
    $('#followupanswer1-pass').addClass('display-none');
    $('input[name="final_answer[1]"]').val(0).trigger('change');
    if (sub_selected_value_2 == 'yes') {
        $('#followupanswer1-pass').removeClass('display-none');
        $('input[name="final_answer[1]"]').val(1).trigger('change');
    } else {
        $('#followupanswer1-fail').removeClass('display-none');
    }
});
// question2
$(document).on('click', '#question2 .main-question', function() {
    var selected_value = $(this).attr('data-option');
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    var temp_selected_value = selected_value.toLowerCase();
    $(this).parents('li').find('.main-question').removeClass('selection-highlighter');
    $(this).parents('li').find('.main-question').addClass('hide');
    $(this).parents('li').find('.main-question.selected-' + temp_selected_value).addClass('selection-highlighter').removeClass('hide');
    $('#followupanswer2-pass').addClass('display-none');
    $('#followupanswer2-fail').addClass('display-none');
    $('#followupanswer2-2').addClass('display-none');
    $('#followupanswer2-2-Yes').addClass('display-none');
    $('#followupanswer2-Yes').addClass('display-none');
    $('#question2 #followupanswer2-Yes .sub-question').removeClass('selection-highlighter');
    $('#question2 #followupanswer2-2 .sub-question').removeClass('selection-highlighter');

    $('input[name="followupanswer[33]"]').val('');
    $('input[name="followupanswer[34]"]').val('');
    $('input[name="followupanswer[35]"]').val('');
    $('input[name="followupanswer[37]"]').val('');
    $('input[name="followupanswer[38]"]').val('');
    $('input[name="followupanswer[39]"]').val('');

    $('input[name="final_answer[2]"]').val(0).trigger('change');
    if (selected_value == 'Yes') {
        $('#followupanswer2-Yes').removeClass('display-none');
    } else {
        $('#followupanswer2-pass').removeClass('display-none');
        $('input[name="final_answer[2]"]').val(1).trigger('change');
    }
});
$(document).on('click', '#question2 #followupanswer2-Yes .sub-question', function() {
    var selected_value = '';
    if (!reset_click) {
        selected_value = $(this).attr('data-option');
    }
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    $(this).parent().find('.sub-question').removeClass('selection-highlighter');
    if (typeof selected_value != 'undefined' && selected_value != '') {
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.sub-question.selected-' + temp_selected_value).addClass('selection-highlighter');
    }
    var score = 0;
    var score_yes = 0;
    var question = 0;
    $('#question2 #followupanswer2-Yes .sub-question.selection-highlighter').each(function() {
        var sub_selected_value = $(this).attr('data-option');
        if (sub_selected_value == 'No') {
            score += 1;
        }
        if (sub_selected_value == 'Yes') {
            score_yes += 1;
        }
        question += 1;
    });
    $('#followupanswer2-pass').addClass('display-none');
    $('#followupanswer2-fail').addClass('display-none');
    $('#followupanswer2-2').addClass('display-none');
    $('#followupanswer2-2-Yes').addClass('display-none');
    $('#followupanswer2-answer').addClass('display-none');
    $('input[name="final_answer[2]"]').val(0).trigger('change');

    $('input[name="followupanswer[35]"]').val('');
    $('input[name="followupanswer[37]"]').val('');
    $('input[name="followupanswer[38]"]').val('');
    $('input[name="followupanswer[39]"]').val('');

    if (score_yes > 0) {
        $('#followupanswer2-fail').removeClass('display-none');
        $('#followupanswer2-2').removeClass('display-none');
        $('#question2 #followupanswer2-2 .sub-question').removeClass('selection-highlighter');
        $('#followupanswer2-answer').removeClass('display-none');
        $('#question2 #followupanswer2-2-Yes .sub-question').removeClass('selection-highlighter');
    } else if (score == 2) {
        $('#followupanswer2-pass').removeClass('display-none');
        $('input[name="final_answer[2]"]').val(1).trigger('change');
        $('#followupanswer2-2').removeClass('display-none');
        $('#question2 #followupanswer2-2 .sub-question').removeClass('selection-highlighter');
        $('#followupanswer2-answer').removeClass('display-none');
        $('#question2 #followupanswer2-2-Yes .sub-question').removeClass('selection-highlighter');
    }
});
$(document).on('click', '#question2 #followupanswer2-2 .sub-question', function() {
    var selected_value = '';
    if (!reset_click) {
        selected_value = $(this).attr('data-option');
    }
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    $(this).parent().find('.sub-question').removeClass('selection-highlighter');
    if (typeof selected_value != 'undefined' && selected_value != '') {
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.sub-question.selected-' + temp_selected_value).addClass('selection-highlighter');
    }
    $('#question2 #followupanswer2-2-Yes .sub-question').removeClass('selection-highlighter');

    $('input[name="followupanswer[37]"]').val('');
    $('input[name="followupanswer[38]"]').val('');
    $('input[name="followupanswer[39]"]').val('');

    var sub_selected_value_2 = '';
    if (!reset_click) {
        var sub_selected_value_2 = $(this).attr('data-option');
    }
    $('#followupanswer2-2-Yes').addClass('display-none');
    if (sub_selected_value_2 != '') {
        if (sub_selected_value_2 == 'Yes') {
            $('#followupanswer2-2-Yes').removeClass('display-none');
        } else {
            $('#followupanswer2-2-Yes').addClass('display-none');
        }
    }
});
$(document).on('click', '#question2 #followupanswer2-2-Yes .sub-question', function() {
    var selected_value = '';
    if (!reset_click) {
        selected_value = $(this).attr('data-option');
    }
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    $(this).parent().find('.sub-question').removeClass('selection-highlighter');
    if (typeof selected_value != 'undefined' && selected_value != '') {
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.sub-question.selected-' + temp_selected_value).addClass('selection-highlighter');
    }
});
// question3
$(document).on('click', '#question3 .main-question', function() {
    var selected_value = $(this).attr('data-option');
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    var temp_selected_value = selected_value.toLowerCase();
    $(this).parents('li').find('.main-question').removeClass('selection-highlighter');
    $(this).parents('li').find('.main-question').addClass('hide');
    $(this).parents('li').find('.main-question.selected-' + temp_selected_value).addClass('selection-highlighter').removeClass('hide');
    $('#followupanswer3-pass').addClass('display-none');
    $('#followupanswer3-fail').addClass('display-none');

    $('#description_51').addClass('display-none');
    
    $('#question3 .sub-question').removeClass('selection-highlighter');

    $('textarea[name="description[51]"]').val('');

    $('input[name="followupanswer[41]"]').val('');
    $('input[name="followupanswer[42]"]').val('');
    $('input[name="followupanswer[43]"]').val('');
    $('input[name="followupanswer[44]"]').val('');
    $('input[name="followupanswer[45]"]').val('');
    $('input[name="followupanswer[46]"]').val('');
    $('input[name="followupanswer[47]"]').val('');
    $('input[name="followupanswer[48]"]').val('');
    $('input[name="followupanswer[49]"]').val('');
    $('input[name="followupanswer[50]"]').val('');
    $('input[name="followupanswer[51]"]').val('');

    $('input[name="final_answer[3]"]').val(0).trigger('change');
    if (selected_value == 'Yes') {
        $('#followupanswer3-question').removeClass('display-none');
    } else {
        $('#followupanswer3-question').removeClass('display-none');
    }
});
$(document).on('click', '#question3 #followupanswer3-question .sub-question', function() {
    var selected_value = '';
    if (!reset_click) {
        selected_value = $(this).attr('data-option');
    }
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    $(this).parent().find('.sub-question').removeClass('selection-highlighter');
    $('input[name="final_answer[3]"]').val(0).trigger('change');
    if (typeof selected_value != 'undefined' && selected_value != '') {
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.sub-question.selected-' + temp_selected_value).addClass('selection-highlighter');
    }
    if (question_id == 'followupanswer[51]') {
        $('textarea[name="description[51]"]').val('');
        if (selected_value == 'Yes') {
            $('#description_51').removeClass('display-none');
        } else {
            $('#description_51').addClass('display-none');
        }
    }
    var score = 0;
    var score_no = 0;
    var question = 0;
    $('#question3 #followupanswer3-question .sub-question.selection-highlighter').each(function() {
        var sub_selected_value = $(this).attr('data-option');
        if (sub_selected_value == 'Yes') {
            score += 1;
        }
        if (sub_selected_value == 'No') {
            score_no += 1;
        }
        question += 1;
    });
    $('#followupanswer3-fail').addClass('display-none');
    $('#followupanswer3-pass').addClass('display-none');
    if (score > 0) {
        $('#followupanswer3-pass').removeClass('display-none');
        $('input[name="final_answer[3]"]').val(1).trigger('change');
    } else if (score_no == 11) {
        $('#followupanswer3-fail').removeClass('display-none');
    }
});
// question4
$(document).on('click', '#question4 .main-question', function() {
    var selected_value = $(this).attr('data-option');
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    var temp_selected_value = selected_value.toLowerCase();
    $(this).parents('li').find('.main-question').removeClass('selection-highlighter');
    $(this).parents('li').find('.main-question').addClass('hide');
    $(this).parents('li').find('.main-question.selected-' + temp_selected_value).addClass('selection-highlighter').removeClass('hide');
    $('#followupanswer4-pass').addClass('display-none');
    $('#followupanswer4-fail').addClass('display-none');
    $('#question4 .sub-question').removeClass('selection-highlighter');
    $('input[name="followupanswer[52]"]').val('');
    $('input[name="final_answer[4]"]').val(0).trigger('change');
    
    $('input[name="followupanswer[53]"]').val('');
    $('input[name="followupanswer[54]"]').val('');
    $('input[name="followupanswer[55]"]').val('');
    $('input[name="followupanswer[56]"]').val('');

    if (selected_value == 'Yes') {
        $('#followupanswer4-question').removeClass('display-none');
    } else {
        $('#followupanswer4-question').removeClass('display-none');
    }
});
$(document).on('click', '#question4 #followupanswer4-question .sub-question', function() {
    var selected_value = '';
    if (!reset_click) {
        selected_value = $(this).attr('data-option');
    }
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    $(this).parent().find('.sub-question').removeClass('selection-highlighter');
    if (typeof selected_value != 'undefined' && selected_value != '') {
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.sub-question.selected-' + temp_selected_value).addClass('selection-highlighter');
    }
    $('input[name="final_answer[4]"]').val(0).trigger('change');
    var score = 0;
    var score_yes = 0;
    var question = 0;
    $('#question4 #followupanswer4-question .sub-question.selection-highlighter').each(function() {
        var sub_selected_value = $(this).attr('data-option');
        if (sub_selected_value == 'No') {
            score += 1;
        }
        if (sub_selected_value == 'Yes') {
            score_yes += 1;
        }
        question += 1;
    });
    $('#followupanswer4-pass').addClass('display-none');
    $('#followupanswer4-fail').addClass('display-none');
    if (score == 4) {
        $('#followupanswer4-fail').removeClass('display-none');
        $('input[name="final_answer[4]"]').val(0).trigger('change');
    } else if (score_yes > 0) {
        $('#followupanswer4-pass').removeClass('display-none');
        $('input[name="final_answer[4]"]').val(1).trigger('change');
    }
});
// question5
$(document).on('click', '#question5 .main-question', function() {
    var selected_value = $(this).attr('data-option');
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    var temp_selected_value = selected_value.toLowerCase();
    $(this).parents('li').find('.main-question').removeClass('selection-highlighter');
    $(this).parents('li').find('.main-question').addClass('hide');
    $(this).parents('li').find('.main-question.selected-' + temp_selected_value).addClass('selection-highlighter').removeClass('hide');
    $('#followupanswer5-pass').addClass('display-none');
    $('#followupanswer5-fail').addClass('display-none');
    $('#followupanswer5-question-pass').addClass('display-none');
    $('#followupanswer5-question-fail').addClass('display-none');
    $('#followupanswer5-question-fail-2').addClass('display-none');

    $('#description_64').addClass('display-none');

    $('#question5 .sub-question').removeClass('selection-highlighter');
    $('#followupanswer5-question-fail-2 .sub-question').removeClass('selection-highlighter');
    $('input[name="final_answer[5]"]').val(0).trigger('change');

    $('textarea[name="description[64]"]').val('');

    $('input[name="followupanswer[58]"]').val('');
    $('input[name="followupanswer[59]"]').val('');
    $('input[name="followupanswer[60]"]').val('');
    $('input[name="followupanswer[61]"]').val('');
    $('input[name="followupanswer[62]"]').val('');
    $('input[name="followupanswer[63]"]').val('');
    $('input[name="followupanswer[64]"]').val('');
    $('input[name="followupanswer[65]"]').val('');

    if (selected_value == 'Yes') {
        $('#followupanswer5-question-pass').removeClass('display-none');
        $('#followupanswer5-question-fail').removeClass('display-none');
    } else {
        $('#followupanswer5-pass').removeClass('display-none');
        $('input[name="final_answer[5]"]').val(1).trigger('change');
    }
});
$(document).on('click', '#question5 #followupanswer5-question-pass .sub-question, #question5 #followupanswer5-question-fail .sub-question', function() {
    var selected_value = '';
    if (!reset_click) {
        selected_value = $(this).attr('data-option');
    }
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    $(this).parent().find('.sub-question').removeClass('selection-highlighter');
    if (typeof selected_value != 'undefined' && selected_value != '') {
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.sub-question.selected-' + temp_selected_value).addClass('selection-highlighter');
    }
    $('#followupanswer5-pass').addClass('display-none');
    $('#followupanswer5-fail').addClass('display-none');
    $('#followupanswer5-question-fail-2').addClass('display-none');
    $('#followupanswer5-question-fail-2 .sub-question').removeClass('selection-highlighter');
    $('input[name="final_answer[5]"]').val(0).trigger('change');

    $('input[name="followupanswer[65]"]').val('');

    if (question_id == 'followupanswer[64]') {
        $('textarea[name="description[64]"]').val('');
        if (selected_value == 'Yes') {
            $('#description_64').removeClass('display-none');
        } else {
            $('#description_64').addClass('display-none');
        }
    }

    var question = 0;
    var score = 0;
    var score_no = 0;
    var score_2 = 0;
    var score_no_2 = 0;
    $('#question5 #followupanswer5-question-pass .sub-question.selection-highlighter').each(function() {
        var sub_selected_value = $(this).attr('data-option');
        if (sub_selected_value == 'Yes') {
            score += 1;
        }
        if (sub_selected_value == 'No') {
            score_no += 1;
        }
        question += 1;
    });
    $('#question5 #followupanswer5-question-fail .sub-question.selection-highlighter').each(function() {
        var sub_selected_value = $(this).attr('data-option');
        if (sub_selected_value == 'Yes') {
            score_2 += 1;
        }
        if (sub_selected_value == 'No') {
            score_no_2 += 1;
        }
        question += 1;
    });
    if (score > 0 && score_2 == 0) {
        $('#followupanswer5-pass').removeClass('display-none');
        $('input[name="final_answer[5]"]').val(1).trigger('change');
    } else if (score_2 > 0) {
        $('#followupanswer5-question-fail-2').removeClass('display-none');
    } else if (score_no_2 == 5) {
        $('#followupanswer5-pass').removeClass('display-none');
        $('input[name="final_answer[5]"]').val(1).trigger('change');
    } else if (score > 0 || score_no > 0 || score_2 > 0 || score_no_2 > 0) {
        $('#followupanswer5-fail').removeClass('display-none');
    }
});
$(document).on('click', '#question5 #followupanswer5-question-fail-2 .sub-question', function() {
    var selected_value = '';
    if (!reset_click) {
        selected_value = $(this).attr('data-option');
    }
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    $(this).parent().find('.sub-question').removeClass('selection-highlighter');
    if (typeof selected_value != 'undefined' && selected_value != '') {
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.sub-question.selected-' + temp_selected_value).addClass('selection-highlighter');
    }
    $('#followupanswer5-pass').addClass('display-none');
    $('#followupanswer5-fail').addClass('display-none');
    $('input[name="final_answer[5]"]').val(0).trigger('change');
    if (selected_value != '') {
        if (selected_value == 'Yes') {
            $('#followupanswer5-fail').removeClass('display-none');
        } else {
            $('#followupanswer5-pass').removeClass('display-none');
            $('input[name="final_answer[5]"]').val(1).trigger('change');
        }
    }
});
// question6
$(document).on('click', '#question6 .main-question', function() {
    var selected_value = $(this).attr('data-option');
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    var temp_selected_value = selected_value.toLowerCase();
    $(this).parents('li').find('.main-question').removeClass('selection-highlighter');
    $(this).parents('li').find('.main-question').addClass('hide');
    $(this).parents('li').find('.main-question.selected-' + temp_selected_value).addClass('selection-highlighter').removeClass('hide');
    $('#followupanswer6-question').addClass('display-none');
    $('#followupanswer6-pass').addClass('display-none');
    $('#followupanswer6-fail').addClass('display-none');
    $('#followupanswer6-question-2').addClass('display-none');
    $('input[name="final_answer[6]"]').val(0).trigger('change');

    $('input[name="followupanswer[67]"]').val('');
    $('input[name="followupanswer[68]"]').val('');
    $('input[name="followupanswer[69]"]').val('');
    $('input[name="followupanswer[70]"]').val('');
    $('input[name="followupanswer[71]"]').val('');

    if (selected_value == 'Yes') {
        $('#followupanswer6-pass').removeClass('display-none');
        $('input[name="final_answer[6]"]').val(1).trigger('change');
    } else {
        $('#followupanswer6-question').removeClass('display-none');
    }
});
$(document).on('click', '#question6 #followupanswer6-question .sub-question', function() {
    var selected_value = '';
    if (!reset_click) {
        selected_value = $(this).attr('data-option');
    }
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    $(this).parent().find('.sub-question').removeClass('selection-highlighter');
    if (typeof selected_value != 'undefined' && selected_value != '') {
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.sub-question.selected-' + temp_selected_value).addClass('selection-highlighter');
    }
    $('#question6 #followupanswer6-question-2 .sub-question').removeClass('selection-highlighter');
    $('input[name="final_answer[6]"]').val(0).trigger('change');

    $('input[name="followupanswer[71]"]').val('');

    var score = 0;
    var score_yes = 0;
    var question = 0;
    $('#question6 #followupanswer6-question .sub-question.selection-highlighter').each(function() {
        var sub_selected_value = $(this).attr('data-option');
        if (sub_selected_value == 'No') {
            score += 1;
        }
        if (sub_selected_value == 'Yes') {
            score_yes += 1;
        }
        question += 1;
    });
    $('#followupanswer6-question-2').addClass('display-none');
    $('#followupanswer6-pass').addClass('display-none');
    $('#followupanswer6-fail').addClass('display-none');
    if (score == 4) {
        $('#followupanswer6-fail').removeClass('display-none');
    } else if (score_yes > 0) {
        $('#followupanswer6-question-2').removeClass('display-none');
    }
});
$(document).on('click', '#question6 #followupanswer6-question-2 .sub-question', function() {
    var selected_value = '';
    if (!reset_click) {
        selected_value = $(this).attr('data-option');
    }
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    $(this).parent().find('.sub-question').removeClass('selection-highlighter');
    if (typeof selected_value != 'undefined' && selected_value != '') {
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.sub-question.selected-' + temp_selected_value).addClass('selection-highlighter');
    }
    $('#followupanswer6-fail').addClass('display-none');
    $('#followupanswer6-pass').addClass('display-none');
    $('input[name="final_answer[6]"]').val(0).trigger('change');
    if (selected_value != '') {
        if (selected_value == 'Yes') {
            $('#followupanswer6-pass').removeClass('display-none');
            $('input[name="final_answer[6]"]').val(1).trigger('change');
        } else {
            $('#followupanswer6-fail').removeClass('display-none');
        }
    }
});
// question7
$(document).on('click', '#question7 .main-question', function() {
    var selected_value = $(this).attr('data-option');
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    var temp_selected_value = selected_value.toLowerCase();
    $(this).parents('li').find('.main-question').removeClass('selection-highlighter');
    $(this).parents('li').find('.main-question').addClass('hide');
    $(this).parents('li').find('.main-question.selected-' + temp_selected_value).addClass('selection-highlighter').removeClass('hide');
    $('#followupanswer7-question-2').addClass('display-none');
    $('#followupanswer7-question-3').addClass('display-none');
    $('#followupanswer7-pass-content').addClass('display-none');
    $('#followupanswer7-pass').addClass('display-none');
    $('#followupanswer7-fail').addClass('display-none');
    $('#question7 .sub-question').removeClass('selection-highlighter');
    $('input[name="final_answer[7]"]').val(0).trigger('change');
    
    $('input[name="followupanswer[73]"]').val('');
    $('input[name="followupanswer[74]"]').val('');
    $('input[name="followupanswer[75]"]').val('');
    $('input[name="followupanswer[76]"]').val('');
    $('input[name="followupanswer[77]"]').val('');
    $('input[name="followupanswer[78]"]').val('');

    if (selected_value == 'Yes') {
        $('#followupanswer7-question').removeClass('display-none');
    } else {
        $('#followupanswer7-question').removeClass('display-none');
    }
});
$(document).on('click', '#question7 #followupanswer7-question .sub-question', function() {
    var selected_value = '';
    if (!reset_click) {
        selected_value = $(this).attr('data-option');
    }
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    $(this).parent().find('.sub-question').removeClass('selection-highlighter');
    if (typeof selected_value != 'undefined' && selected_value != '') {
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.sub-question.selected-' + temp_selected_value).addClass('selection-highlighter');
    }
    var score = 0;
    var score_yes = 0;
    var question = 0;
    $('#question7 #followupanswer7-question .sub-question.selection-highlighter').each(function() {
        var sub_selected_value = $(this).attr('data-option');
        if (sub_selected_value == 'No') {
            score += 1;
        }
        if (sub_selected_value == 'Yes') {
            score_yes += 1;
        }
        question += 1;
    });
    $('#followupanswer7-question-2').addClass('display-none');
    $('#followupanswer7-question-3').addClass('display-none');
    $('#followupanswer7-pass-content').addClass('display-none');
    $('#followupanswer7-fail').addClass('display-none');
    $('#followupanswer7-pass').addClass('display-none');
    $('#followupanswer7-question-2').addClass('display-none');
    $('#followupanswer7-fail').addClass('display-none');
    $('input[name="final_answer[7]"]').val(0).trigger('change');
    $('#followupanswer7-question-2 .sub-question').removeClass('selection-highlighter');
    $('#followupanswer7-question-3 .sub-question').removeClass('selection-highlighter');

    $('input[name="followupanswer[77]"]').val('');
    $('input[name="followupanswer[78]"]').val('');

    if (score == 4) {
        $('#followupanswer7-fail').removeClass('display-none');
    } else if (score_yes > 0) {
        $('#followupanswer7-question-2').removeClass('display-none');
    }
    $('#question7 #followupanswer7-question-2 .sub-question').removeClass('selection-highlighter');
    $('input[name="followupanswer[77]"]').val('');
});
$(document).on('click', '#question7 #followupanswer7-question-2 .sub-question', function() {
    var selected_value = '';
    if (!reset_click) {
        selected_value = $(this).attr('data-option');
    }
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    $(this).parent().find('.sub-question').removeClass('selection-highlighter');
    if (typeof selected_value != 'undefined' && selected_value != '') {
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.sub-question.selected-' + temp_selected_value).addClass('selection-highlighter');
    }
    $('#followupanswer7-fail').addClass('display-none');
    $('#followupanswer7-pass-content').addClass('display-none');
    $('#followupanswer7-question-3').addClass('display-none');
    $('#followupanswer7-pass').addClass('display-none');
    $('input[name="final_answer[7]"]').val(0).trigger('change');

    $('input[name="followupanswer[78]"]').val('');

    if (selected_value != '') {
        if (selected_value == 'No') {
            $('#followupanswer7-fail').removeClass('display-none');
        } else {
            $('#followupanswer7-question-3').removeClass('display-none');
        }
    }
    $('#question7 #followupanswer7-question-3 .sub-question').removeClass('selection-highlighter');
});
$(document).on('click', '#question7 #followupanswer7-question-3 .sub-question', function() {
    var selected_value = '';
    if (!reset_click) {
        selected_value = $(this).attr('data-option');
    }
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    $(this).parent().find('.sub-question').removeClass('selection-highlighter');
    if (typeof selected_value != 'undefined' && selected_value != '') {
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.sub-question.selected-' + temp_selected_value).addClass('selection-highlighter');
    }
    $('#followupanswer7-pass').addClass('display-none');
    $('#followupanswer7-pass-content').addClass('display-none');
    $('#followupanswer7-fail').addClass('display-none');
    $('input[name="final_answer[7]"]').val(0).trigger('change');
    if (selected_value != '') {
        if (selected_value == 'No') {
            $('#followupanswer7-fail').removeClass('display-none');
        } else {
            $('#followupanswer7-pass').removeClass('display-none');
            $('#followupanswer7-pass-content').removeClass('display-none');
            $('input[name="final_answer[7]"]').val(1).trigger('change');
        }
    }
});
// question8
$(document).on('click', '#question8 .main-question', function() {
    var selected_value = $(this).attr('data-option');
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    var temp_selected_value = selected_value.toLowerCase();
    $(this).parents('li').find('.main-question').removeClass('selection-highlighter');
    $(this).parents('li').find('.main-question').addClass('hide');
    $(this).parents('li').find('.main-question.selected-' + temp_selected_value).addClass('selection-highlighter').removeClass('hide');
    $('#followupanswer8-Yes-question').addClass('display-none');
    $('#followupanswer8-question-2').addClass('display-none');
    $('#followupanswer8-question-3').addClass('display-none');
    $('#followupanswer8-pass').addClass('display-none');
    $('#followupanswer8-fail').addClass('display-none');
    $('#followupanswer8-question').addClass('display-none');
    $('#followupanswer8-no-question').addClass('display-none');
    $('#question8 .sub-question').removeClass('selection-highlighter');
    $('#question8 .followupanswer8 textarea').val('');
    $('input[name="final_answer[8]"]').val(0).trigger('change');

    $('input[name="followupanswer[79]"]').val('');
    $('input[name="followupanswer[80]"]').val('');
    $('input[name="followupanswer[82]"]').val('');
    $('input[name="followupanswer[83]"]').val('');
    $('input[name="followupanswer[84]"]').val('');
    $('input[name="followupanswer[85]"]').val('');
    $('input[name="followupanswer[86]"]').val('');
    $('input[name="followupanswer[87]"]').val('');
    $('input[name="followupanswer[88]"]').val('');
    $('input[name="followupanswer[89]"]').val('');

    if (selected_value == 'Yes') {
        $('#followupanswer8-question').removeClass('display-none');
    } else {
        $('#followupanswer8-no-question').removeClass('display-none');
    }
});
$(document).on('click', '#question8 #followupanswer8-question .sub-question', function() {
    var selected_value = '';
    if (!reset_click) {
        selected_value = $(this).attr('data-option');
    }
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    $(this).parent().find('.sub-question').removeClass('selection-highlighter');
    if (typeof selected_value != 'undefined' && selected_value != '') {
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.sub-question.selected-' + temp_selected_value).addClass('selection-highlighter');
    }
    $('#followupanswer8-Yes-question').addClass('display-none');
    $('#followupanswer8-question-2').addClass('display-none');
    $('#followupanswer8-question-3').addClass('display-none');
    $('#followupanswer8-fail').addClass('display-none');
    $('#followupanswer8-no-question').addClass('display-none');
    $('#followupanswer8-pass').addClass('display-none');
    $('#followupanswer8-no-question .sub-question').removeClass('selection-highlighter');
    $('#followupanswer8-Yes-question .sub-question').removeClass('selection-highlighter');
    $('#followupanswer8-question-2 .sub-question').removeClass('selection-highlighter');
    $('#followupanswer8-question-3 .sub-question').removeClass('selection-highlighter');

    $('input[name="final_answer[8]"]').val(0).trigger('change');

    $('input[name="followupanswer[80]"]').val('');
    $('input[name="followupanswer[82]"]').val('');
    $('input[name="followupanswer[83]"]').val('');
    $('input[name="followupanswer[84]"]').val('');
    $('input[name="followupanswer[85]"]').val('');
    $('input[name="followupanswer[86]"]').val('');
    $('input[name="followupanswer[87]"]').val('');
    $('input[name="followupanswer[88]"]').val('');
    $('input[name="followupanswer[89]"]').val('');

    if (selected_value != '') {
        if (selected_value == 'Yes') {
            $('#followupanswer8-pass').removeClass('display-none');
            $('input[name="final_answer[8]"]').val(1).trigger('change');
        } else {
            $('#followupanswer8-no-question').removeClass('display-none');
        }
    }
});
$(document).on('click', '#question8 #followupanswer8-no-question .sub-question', function() {
    var selected_value = '';
    if (!reset_click) {
        selected_value = $(this).attr('data-option');
    }
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    $(this).parent().find('.sub-question').removeClass('selection-highlighter');
    if (typeof selected_value != 'undefined' && selected_value != '') {
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.sub-question.selected-' + temp_selected_value).addClass('selection-highlighter');
    }
    $('#followupanswer8-pass').addClass('display-none');
    $('#followupanswer8-question-3').addClass('display-none');
    $('#followupanswer8-question-2').addClass('display-none');
    $('#followupanswer8-fail').addClass('display-none');
    $('#followupanswer8-question-3 .sub-question').removeClass('selection-highlighter');
    $('#followupanswer8-question-2 .sub-question').removeClass('selection-highlighter');
    $('input[name="final_answer[8]"]').val(0).trigger('change');

    $('input[name="followupanswer[82]"]').val('');
    $('input[name="followupanswer[83]"]').val('');
    $('input[name="followupanswer[84]"]').val('');
    $('input[name="followupanswer[85]"]').val('');
    $('input[name="followupanswer[86]"]').val('');
    $('input[name="followupanswer[87]"]').val('');
    $('input[name="followupanswer[88]"]').val('');
    $('input[name="followupanswer[89]"]').val('');

    if (selected_value != '') {
        if (selected_value == 'No') {
            $('#followupanswer8-fail').removeClass('display-none');
        } else {
            $('#followupanswer8-question-2').removeClass('display-none');
        }
    }
});
$(document).on('click', '#question8 #followupanswer8-question-2 .sub-question', function() {
    var selected_value = '';
    if (!reset_click) {
        selected_value = $(this).attr('data-option');
    }
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    $(this).parent().find('.sub-question').removeClass('selection-highlighter');
    if (typeof selected_value != 'undefined' && selected_value != '') {
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.sub-question.selected-' + temp_selected_value).addClass('selection-highlighter');
    }
    $('#followupanswer8-pass').addClass('display-none');
    $('#followupanswer8-question-3 .sub-question').removeClass('selection-highlighter');
    $('input[name="final_answer[8]"]').val(0).trigger('change');

    $('input[name="followupanswer[89]"]').val('');

    var score = 0;
    var score_yes = 0;
    var question = 0;
    $('#question8 #followupanswer8-question-2 .sub-question.selection-highlighter').each(function() {
        var sub_selected_value = $(this).attr('data-option');
        if (sub_selected_value == 'No') {
            score += 1;
        }
        if (sub_selected_value == 'Yes') {
            score_yes += 1;
        }
        question += 1;
    });
    $('#followupanswer8-fail').addClass('display-none');
    $('#followupanswer8-question-3').addClass('display-none');
    if (score == 7) {
        $('#followupanswer8-fail').removeClass('display-none');
    } else if (score_yes > 0) {
        $('#followupanswer8-question-3').removeClass('display-none');
    }
});
$(document).on('click', '#question8 #followupanswer8-question-3 .sub-question', function() {
    var selected_value = '';
    if (!reset_click) {
        selected_value = $(this).attr('data-option');
    }
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    $(this).parent().find('.sub-question').removeClass('selection-highlighter');
    if (typeof selected_value != 'undefined' && selected_value != '') {
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.sub-question.selected-' + temp_selected_value).addClass('selection-highlighter');
    }
    $('input[name="final_answer[8]"]').val(0).trigger('change');
    $('#followupanswer8-fail').addClass('display-none');
    $('#followupanswer8-pass').addClass('display-none');
    if (selected_value != '') {
        if (selected_value == 'Yes') {
            $('#followupanswer8-pass').removeClass('display-none');
            $('input[name="final_answer[8]"]').val(1).trigger('change');
        } else {
            $('#followupanswer8-fail').removeClass('display-none');
        }
    }
});
// question9
$(document).on('click', '#question9 .main-question', function() {
    var selected_value = $(this).attr('data-option');
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    var temp_selected_value = selected_value.toLowerCase();
    $(this).parents('li').find('.main-question').removeClass('selection-highlighter');
    $(this).parents('li').find('.main-question').addClass('hide');
    $(this).parents('li').find('.main-question.selected-' + temp_selected_value).addClass('selection-highlighter').removeClass('hide');
    $('#followupanswer9-Yes').addClass('display-none');
    $('#followupanswer9-pass').addClass('display-none');
    $('#followupanswer9-fail').addClass('display-none');
    $('#followupanswer9-question').addClass('display-none');
    $('#followupanswer9-question-2').addClass('display-none');
    $('#description_96').addClass('display-none');
    $('textarea[name="description[96]"]').val('');
    $('.followupanswer9 .sub-question').removeClass('selection-highlighter');
    $('input[name="final_answer[9]"]').val(0).trigger('change');

    $('input[name="followupanswer[91]"]').val('');
    $('input[name="followupanswer[92]"]').val('');
    $('input[name="followupanswer[93]"]').val('');
    $('input[name="followupanswer[94]"]').val('');
    $('input[name="followupanswer[95]"]').val('');
    $('input[name="followupanswer[96]"]').val('');
    $('input[name="followupanswer[97]"]').val('');

    if (selected_value == 'Yes') {
        $('#followupanswer9-question').removeClass('display-none');
    } else {
        $('#followupanswer9-question').removeClass('display-none');
    }
});
$(document).on('click', '#question9 #followupanswer9-question .sub-question', function() {
    var selected_value = '';
    if (!reset_click) {
        selected_value = $(this).attr('data-option');
    }
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    $(this).parent().find('.sub-question').removeClass('selection-highlighter');
    if (typeof selected_value != 'undefined' && selected_value != '') {
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.sub-question.selected-' + temp_selected_value).addClass('selection-highlighter');
    }
    $('#followupanswer9-fail').addClass('display-none');
    $('#followupanswer9-pass').addClass('display-none');
    $('#followupanswer9-question-2').addClass('display-none');
    $('#followupanswer9-question-2 .sub-question').removeClass('selection-highlighter');
    $('input[name="final_answer[9]"]').val(0).trigger('change');

    $('input[name="followupanswer[97]"]').val('');

    var score = 0;
    var score_yes = 0;
    var question = 0;
    $('#question9 #followupanswer9-question .sub-question.selection-highlighter').each(function() {
        var sub_selected_value = $(this).attr('data-option');
        if (sub_selected_value == 'No') {
            score += 1;
        }
        if (sub_selected_value == 'Yes') {
            score_yes += 1;
        }
        question += 1;
    });
    if (score == 6) {
        $('#followupanswer9-fail').removeClass('display-none');
    } else if (score_yes > 0) {
        $('#followupanswer9-question-2').removeClass('display-none');
    }

    if (question_id == 'followupanswer[96]') {
        $('textarea[name="description[96]"]').val('');
        if (selected_value == 'Yes') {
            $('#description_96').removeClass('display-none');
        } else {
            $('#description_96').addClass('display-none');
        }
    }
});
$(document).on('click', '#question9 #followupanswer9-question-2 .sub-question', function() {
    var selected_value = '';
    if (!reset_click) {
        selected_value = $(this).attr('data-option');
    }
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    $(this).parent().find('.sub-question').removeClass('selection-highlighter');
    if (typeof selected_value != 'undefined' && selected_value != '') {
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.sub-question.selected-' + temp_selected_value).addClass('selection-highlighter');
    }
    $('input[name="final_answer[9]"]').val(0).trigger('change');
    $('#followupanswer9-pass').addClass('display-none');
    $('#followupanswer9-fail').addClass('display-none');
    if (selected_value != '') {
        if (selected_value == 'Yes') {
            $('#followupanswer9-pass').removeClass('display-none');
            $('input[name="final_answer[9]"]').val(1).trigger('change');
        } else {
            $('#followupanswer9-fail').removeClass('display-none');
        }
    }
});
// question10
$(document).on('click', '#question10 .main-question', function() {
    var selected_value = $(this).attr('data-option');
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    var temp_selected_value = selected_value.toLowerCase();
    $(this).parents('li').find('.main-question').removeClass('selection-highlighter');
    $(this).parents('li').find('.main-question').addClass('hide');
    $(this).parents('li').find('.main-question.selected-' + temp_selected_value).addClass('selection-highlighter').removeClass('hide');
    $('.followupanswer10').addClass('display-none');
    $('#followupanswer10-pass').addClass('display-none');
    $('#followupanswer10-fail').addClass('display-none');
    $('#followupanswer10-No-question').addClass('display-none');
    $('.followupanswer10 .sub-question').removeClass('selection-highlighter');
    $('input[name="final_answer[10]"]').val(0).trigger('change');

    $('input[name="followupanswer[100]"]').val('');
    $('input[name="followupanswer[101]"]').val('');
    $('input[name="followupanswer[102]"]').val('');
    $('input[name="followupanswer[103]"]').val('');
    $('input[name="followupanswer[104]"]').val('');
    $('input[name="followupanswer[105]"]').val('');
    $('input[name="followupanswer[106]"]').val('');
    $('input[name="followupanswer[107]"]').val('');

    if (selected_value == 'Yes') {
        $('#followupanswer10-Yes-question').removeClass('display-none');
    } else {
        $('#followupanswer10-Yes-question').removeClass('display-none');
        $('#followupanswer10-No-question').removeClass('display-none');
    }
});
$(document).on('click', '#question10 #followupanswer10-Yes-question .sub-question, #question10 #followupanswer10-No-question .sub-question', function() {
    var selected_value = '';
    if (!reset_click) {
        selected_value = $(this).attr('data-option');
    }
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    $(this).parent().find('.sub-question').removeClass('selection-highlighter');
    if (typeof selected_value != 'undefined' && selected_value != '') {
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.sub-question.selected-' + temp_selected_value).addClass('selection-highlighter');
    }
    $('#question10 #followupanswer10-question').addClass('display-none');
    $('#followupanswer10-pass').addClass('display-none');
    $('#followupanswer10-fail').addClass('display-none');
    $('#question10 #followupanswer10-question .sub-question').removeClass('selection-highlighter');
    $('input[name="final_answer[10]"]').val(0).trigger('change');

    $('input[name="followupanswer[107]"]').val('');

    var question = 0;
    var score = 0;
    var no_score = 0;
    var score_2 = 0;
    var score_no_2 = 0;
    $('#question10 #followupanswer10-Yes-question .sub-question.selection-highlighter').each(function() {
        var sub_selected_value = $(this).attr('data-option');
        if (sub_selected_value == 'Yes') {
            score += 1;
        }
        if (sub_selected_value == 'No') {
            no_score += 1;
        }
        question += 1;
    });
    $('#question10 #followupanswer10-No-question .sub-question.selection-highlighter').each(function() {
        var sub_selected_value = $(this).attr('data-option');
        if (sub_selected_value == 'Yes') {
            score_2 += 1;
        }
        if (sub_selected_value == 'No') {
            score_no_2 += 1;
        }
        question += 1;
    });
    if ($('#question10 .main-question.selection-highlighter').attr('data-option') == 'Yes') {
        if (score > 0) {
            $('#followupanswer10-pass').removeClass('display-none');
            $('input[name="final_answer[10]"]').val(1).trigger('change');
        } else {
            $('#followupanswer10-fail').removeClass('display-none');
        }
    } else {
        if (score > 0 && score_2 == 0) {
            $('#followupanswer10-pass').removeClass('display-none');
            $('input[name="final_answer[10]"]').val(1).trigger('change');
        } else if (score_2 > 0 && score == 0) {
            $('#followupanswer10-fail').removeClass('display-none');
        } else if ((score > 0 && score_2 > 0) || (score == 0 && no_score > 0 && score_2 == 0 && score_no_2 > 0)) {
            $('#followupanswer10-question').removeClass('display-none');
        }
    }
});
$(document).on('click', '#question10 #followupanswer10-question .sub-question', function() {
    var selected_value = '';
    if (!reset_click) {
        selected_value = $(this).attr('data-option');
    }
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    $(this).parent().find('.sub-question').removeClass('selection-highlighter');
    if (typeof selected_value != 'undefined' && selected_value != '') {
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.sub-question.selected-' + temp_selected_value).addClass('selection-highlighter');
    }
    $('#followupanswer10-pass').addClass('display-none');
    $('#followupanswer10-fail').addClass('display-none');
    $('input[name="final_answer[10]"]').val(0).trigger('change');
    if (selected_value != '') {
        if (selected_value == 'Yes') {
            $('#followupanswer10-pass').removeClass('display-none');
            $('input[name="final_answer[10]"]').val(1).trigger('change');
        } else {
            $('#followupanswer10-fail').removeClass('display-none');
        }
    }
});
// question11
$(document).on('click', '#question11 .main-question', function() {
    var selected_value = $(this).attr('data-option');
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    var temp_selected_value = selected_value.toLowerCase();
    $(this).parents('li').find('.main-question').removeClass('selection-highlighter');
    $(this).parents('li').find('.main-question').addClass('hide');
    $(this).parents('li').find('.main-question.selected-' + temp_selected_value).addClass('selection-highlighter').removeClass('hide');
    $('#followupanswer11-pass').addClass('display-none');
    $('#followupanswer11-fail').addClass('display-none');
    $('#followupanswer11-No').addClass('display-none');
    $('#question11 #followupanswer11-No').addClass('display-none');
    $('#followupanswer11-pass-question').addClass('display-none');
    $('#followupanswer11-fail-question').addClass('display-none');
    $('#followupanswer11-question').addClass('display-none');
    $('#question11 #followupanswer11-pass-question .sub-question').removeClass('selection-highlighter');
    $('#question11 #followupanswer11-fail-question .sub-question').removeClass('selection-highlighter');
    $('#question11 #followupanswer11-No .sub-question').removeClass('selection-highlighter');
    $('input[name="final_answer[11]"]').val(0).trigger('change');

    $('input[name="followupanswer[109]"]').val('');
    $('input[name="followupanswer[110]"]').val('');
    $('input[name="followupanswer[111]"]').val('');
    $('input[name="followupanswer[112]"]').val('');
    $('input[name="followupanswer[113]"]').val('');
    $('input[name="followupanswer[114]"]').val('');
    $('input[name="followupanswer[115]"]').val('');

    if (selected_value == 'Yes') {
        $('#followupanswer11-pass').removeClass('display-none');
        $('input[name="final_answer[11]"]').val(1).trigger('change');
    } else {
        $('#followupanswer11-pass-question').removeClass('display-none');
        $('#followupanswer11-fail-question').removeClass('display-none');
    }
});
$(document).on('click', '#question11 #followupanswer11-pass-question .sub-question, #question11 #followupanswer11-fail-question .sub-question', function() {
    var selected_value = '';
    if (!reset_click) {
        selected_value = $(this).attr('data-option');
    }
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    $(this).parent().find('.sub-question').removeClass('selection-highlighter');
    if (typeof selected_value != 'undefined' && selected_value != '') {
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.sub-question.selected-' + temp_selected_value).addClass('selection-highlighter');
    }
    $('#followupanswer11-pass').addClass('display-none');
    $('#followupanswer11-fail').addClass('display-none');
    $('#followupanswer11-question').addClass('display-none');
    $('#followupanswer11-question .sub-question').removeClass('selection-highlighter');
    $('input[name="final_answer[11]"]').val(0).trigger('change');

    $('input[name="followupanswer[115]"]').val('');

    var score = 0;
    var score_no = 0;
    var score_2 = 0;
    var score_no_2 = 0;
    var question = 0;
    $('#question11 #followupanswer11-pass-question .sub-question.selection-highlighter').each(function() {
        var sub_selected_value = $(this).attr('data-option');
        if (sub_selected_value == 'Yes') {
            score += 1;
        }
        if (sub_selected_value == 'No') {
            score_no += 1;
        }
        question += 1;
    });
    $('#question11 #followupanswer11-fail-question .sub-question.selection-highlighter').each(function() {
        var sub_selected_value = $(this).attr('data-option');
        if (sub_selected_value == 'Yes') {
            score_2 += 1;
        }
        if (sub_selected_value == 'No') {
            score_no_2 += 1;
        }
        question += 1;
    });
    if (score > 0 && score_2 == 0) {
        $('#followupanswer11-pass').removeClass('display-none');
        $('input[name="final_answer[11]"]').val(1).trigger('change');
    } else if (score_2 > 0 && score == 0) {
        $('#followupanswer11-fail').removeClass('display-none');
    } else if ((score > 0 && score_2 > 0) || (score == 0 && score_no > 0 && score_2 == 0 && score_no_2 > 0)) {
        $('#followupanswer11-question').removeClass('display-none');
    }
});
$(document).on('click', '#question11 #followupanswer11-question .sub-question', function() {
    var selected_value = '';
    if (!reset_click) {
        selected_value = $(this).attr('data-option');
    }
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    $(this).parent().find('.sub-question').removeClass('selection-highlighter');
    if (typeof selected_value != 'undefined' && selected_value != '') {
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.sub-question.selected-' + temp_selected_value).addClass('selection-highlighter');
    }
    $('#followupanswer11-pass').addClass('display-none');
    $('#followupanswer11-fail').addClass('display-none');
    $('input[name="final_answer[11]"]').val(0).trigger('change');
    if (selected_value != '') {
        if (selected_value == 'Yes') {
            $('#followupanswer11-pass').removeClass('display-none');
            $('input[name="final_answer[11]"]').val(1).trigger('change');
        } else {
            $('#followupanswer11-fail').removeClass('display-none');
        }
    }
});
// question12
$(document).on('click', '#question12 .main-question', function() {
    var selected_value = $(this).attr('data-option');
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    var temp_selected_value = selected_value.toLowerCase();
    $(this).parents('li').find('.main-question').removeClass('selection-highlighter');
    $(this).parents('li').find('.main-question').addClass('hide');
    $(this).parents('li').find('.main-question.selected-' + temp_selected_value).addClass('selection-highlighter').removeClass('hide');
    $('.followupanswer12').addClass('display-none');
    $('#followupanswer12-pass').addClass('display-none');
    $('#followupanswer12-fail').addClass('display-none');
    $('#description_126').addClass('display-none');
    $('.followupanswer12 .sub-question').removeClass('selection-highlighter');
    $('textarea[name="description[126]"]').val('');
    $('input[name="final_answer[12]"]').val(0).trigger('change');

    $('input[name="followupanswer[116]"]').val('');
    $('input[name="followupanswer[117]"]').val('');
    $('input[name="followupanswer[118]"]').val('');
    $('input[name="followupanswer[119]"]').val('');
    $('input[name="followupanswer[120]"]').val('');
    $('input[name="followupanswer[121]"]').val('');
    $('input[name="followupanswer[122]"]').val('');
    $('input[name="followupanswer[123]"]').val('');
    $('input[name="followupanswer[124]"]').val('');
    $('input[name="followupanswer[125]"]').val('');
    $('input[name="followupanswer[126]"]').val('');
    $('input[name="followupanswer[128]"]').val('');
    $('input[name="followupanswer[129]"]').val('');
    $('input[name="followupanswer[130]"]').val('');
    $('input[name="followupanswer[131]"]').val('');
    $('input[name="followupanswer[132]"]').val('');
    $('input[name="followupanswer[133]"]').val('');

    if (selected_value == 'No') {
        $('#followupanswer12-pass').removeClass('display-none');
        $('input[name="final_answer[12]"]').val(1).trigger('change');
    } else {
        $('#followupanswer12-yes-question').removeClass('display-none');
    }
});
$(document).on('click', '#question12 #followupanswer12-yes-question .sub-question', function() {
    var selected_value = '';
    if (!reset_click) {
        selected_value = $(this).attr('data-option');
    }
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    $(this).parent().find('.sub-question').removeClass('selection-highlighter');
    if (typeof selected_value != 'undefined' && selected_value != '') {
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.sub-question.selected-' + temp_selected_value).addClass('selection-highlighter');
    }
    $('#followupanswer12-pass').addClass('display-none');
    $('#followupanswer12-fail').addClass('display-none');
    $('#followupanswer12-pass-question').addClass('display-none');
    $('#followupanswer12-fail-question').addClass('display-none');
    $('#followupanswer12-question').addClass('display-none');
    $('#followupanswer12-pass-question .sub-question').removeClass('selection-highlighter');
    $('#followupanswer12-fail-question .sub-question').removeClass('selection-highlighter');
    $('#followupanswer12-question .sub-question').removeClass('selection-highlighter');
    $('input[name="final_answer[12]"]').val(0).trigger('change');

    $('input[name="followupanswer[128]"]').val('');
    $('input[name="followupanswer[129]"]').val('');
    $('input[name="followupanswer[130]"]').val('');
    $('input[name="followupanswer[131]"]').val('');
    $('input[name="followupanswer[132]"]').val('');
    $('input[name="followupanswer[133]"]').val('');

    var score = 0;
    var question = 0;
    $('#question12 #followupanswer12-yes-question .sub-question.selection-highlighter').each(function() {
        var sub_selected_value = $(this).attr('data-option');
        if (sub_selected_value == 'Yes') {
            score += 1;
        }
        question += 1;
    });
    if (score > 1) {
        $('#followupanswer12-pass-question').removeClass('display-none');
        $('#followupanswer12-fail-question').removeClass('display-none');
        $(this).parent().find('.sub-question.selected-more').addClass('selection-highlighter');
    } else {
        $('#followupanswer12-fail').removeClass('display-none');
    }

    if (question_id == 'followupanswer[126]') {
        $('textarea[name="description[126]"]').val('');
        if (selected_value == 'Yes') {
            $('#description_126').removeClass('display-none');
        } else {
            $('#description_126').addClass('display-none');
        }
    }
});
$(document).on('click', '#question12 #followupanswer12-pass-question .sub-question, #question12 #followupanswer12-fail-question .sub-question', function() {
    var selected_value = '';
    if (!reset_click) {
        selected_value = $(this).attr('data-option');
    }
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    $(this).parent().find('.sub-question').removeClass('selection-highlighter');
    if (typeof selected_value != 'undefined' && selected_value != '') {
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.sub-question.selected-' + temp_selected_value).addClass('selection-highlighter');
    }
    $('#followupanswer12-pass').addClass('display-none');
    $('#followupanswer12-fail').addClass('display-none');
    $('#followupanswer12-question').addClass('display-none');
    $('#followupanswer12-question .sub-question').removeClass('selection-highlighter');
    $('input[name="final_answer[12]"]').val(0).trigger('change');

    $('input[name="followupanswer[133]"]').val('');

    var score = 0;
    var score_no = 0;
    var score_2 = 0;
    var score_no_2 = 0;
    var question = 0;
    $('#question12 #followupanswer12-pass-question .sub-question.selection-highlighter').each(function() {
        var sub_selected_value = $(this).attr('data-option');
        if (sub_selected_value == 'Yes') {
            score += 1;
        }
        if (sub_selected_value == 'No') {
            score_no += 1;
        }
        question += 1;
    });
    $('#question12 #followupanswer12-fail-question .sub-question.selection-highlighter').each(function() {
        var sub_selected_value = $(this).attr('data-option');
        if (sub_selected_value == 'Yes') {
            score_2 += 1;
        }
        if (sub_selected_value == 'No') {
            score_no_2 += 1;
        }
        question += 1;
    });
    if (score > 0 && score_2 == 0) {
        $('#followupanswer12-pass').removeClass('display-none');
        $('input[name="final_answer[12]"]').val(1).trigger('change');
    } else if (score_2 > 0 && score == 0) {
        $('#followupanswer12-fail').removeClass('display-none');
    } else if ((score > 0 && score_2 > 0) || (score == 0 && score_no > 0 && score_2 == 0 && score_no_2 > 0)) {
        $('#followupanswer12-question').removeClass('display-none');
    }
});
$(document).on('click', '#question12 #followupanswer12-question .sub-question', function() {
    var selected_value = '';
    if (!reset_click) {
        selected_value = $(this).attr('data-option');
    }
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    $(this).parent().find('.sub-question').removeClass('selection-highlighter');
    if (typeof selected_value != 'undefined' && selected_value != '') {
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.sub-question.selected-' + temp_selected_value).addClass('selection-highlighter');
    }
    $('#followupanswer12-pass').addClass('display-none');
    $('#followupanswer12-fail').addClass('display-none');
    $('input[name="final_answer[12]"]').val(0).trigger('change');
    if (selected_value != '') {
        if (selected_value == 'Yes') {
            $('#followupanswer12-pass').removeClass('display-none');
            $('input[name="final_answer[12]"]').val(1).trigger('change');
        } else {
            $('#followupanswer12-fail').removeClass('display-none');
        }
    }
});
// question13
$(document).on('click', '#question13 .main-question', function() {
    var selected_value = $(this).attr('data-option');
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    var temp_selected_value = selected_value.toLowerCase();
    $(this).parents('li').find('.main-question').removeClass('selection-highlighter');
    $(this).parents('li').find('.main-question').addClass('hide');
    $(this).parents('li').find('.main-question.selected-' + temp_selected_value).addClass('selection-highlighter').removeClass('hide');
    $('#question13 #followupanswer13-question').addClass('display-none');
    $('#followupanswer13-pass').addClass('display-none');
    $('#followupanswer13-fail').addClass('display-none');
    $('#question13 #followupanswer13-question .sub-question').removeClass('selection-highlighter');
    $('input[name="final_answer[13]"]').val(0).trigger('change');

    $('input[name="followupanswer[134]"]').val('');

    if (selected_value == 'No') {
        $('#followupanswer13-fail').removeClass('display-none');
    } else {
        $('#question13 #followupanswer13-question').removeClass('display-none');
    }
});
$(document).on('click', '#question13 #followupanswer13-question .sub-question', function() {
    var selected_value = '';
    if (!reset_click) {
        selected_value = $(this).attr('data-option');
    }
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    $(this).parent().find('.sub-question').removeClass('selection-highlighter');
    if (typeof selected_value != 'undefined' && selected_value != '') {
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.sub-question.selected-' + temp_selected_value).addClass('selection-highlighter');
    }
    $('#followupanswer13-pass').addClass('display-none');
    $('#followupanswer13-fail').addClass('display-none');
    $('input[name="final_answer[13]"]').val(0).trigger('change');
    if (selected_value != '') {
        if (selected_value == 'Yes') {
            $('#followupanswer13-pass').removeClass('display-none');
            $('input[name="final_answer[13]"]').val(1).trigger('change');
        } else {
            $('#followupanswer13-fail').removeClass('display-none');
        }
    }
});
// question14
$(document).on('click', '#question14 .main-question', function() {
    var selected_value = $(this).attr('data-option');
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    var temp_selected_value = selected_value.toLowerCase();
    $(this).parents('li').find('.main-question').removeClass('selection-highlighter');
    $(this).parents('li').find('.main-question').addClass('hide');
    $(this).parents('li').find('.main-question.selected-' + temp_selected_value).addClass('selection-highlighter').removeClass('hide');
    $('#followupanswer14-question').addClass('display-none');
    $('#followupanswer14-question-2').addClass('display-none');
    $('#followupanswer14-question-3').addClass('display-none');
    $('#followupanswer14-fail').addClass('display-none');
    $('#followupanswer14-pass').addClass('display-none');
    $('#followupanswer14-yes-question').addClass('display-none');
    $('.followupanswer14 .sub-question').removeClass('selection-highlighter');
    $('input[name="final_answer[14]"]').val(0).trigger('change');

    $('input[name="followupanswer[135]"]').val('');
    $('input[name="followupanswer[136]"]').val('');
    $('input[name="followupanswer[137]"]').val('');
    $('input[name="followupanswer[138]"]').val('');
    $('input[name="followupanswer[139]"]').val('');
    $('input[name="followupanswer[140]"]').val('');
    $('input[name="followupanswer[141]"]').val('');
    $('input[name="followupanswer[142]"]').val('');
    $('input[name="followupanswer[143]"]').val('');

    if (selected_value == 'Yes') {
        $('#followupanswer14-yes-question').removeClass('display-none');
    } else {
        $('#followupanswer14-question').removeClass('display-none');
    }
});
$(document).on('click', '#question14 #followupanswer14-yes-question .sub-question', function() {
    var selected_value = '';
    if (!reset_click) {
        selected_value = $(this).attr('data-option');
    }
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    $(this).parent().find('.sub-question').removeClass('selection-highlighter');
    if (typeof selected_value != 'undefined' && selected_value != '') {
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.sub-question.selected-' + temp_selected_value).addClass('selection-highlighter');
    }
    $('#followupanswer14-question').addClass('display-none');
    $('#followupanswer14-question-2').addClass('display-none');
    $('#followupanswer14-question-3').addClass('display-none');
    $('#followupanswer14-fail').addClass('display-none');
    $('#followupanswer14-pass').addClass('display-none');
    $('#followupanswer14-question').addClass('display-none');
    $('#followupanswer14-question .sub-question').removeClass('selection-highlighter');
    $('#followupanswer14-question-2 .sub-question').removeClass('selection-highlighter');
    $('#followupanswer14-question-3 .sub-question').removeClass('selection-highlighter');
    $('input[name="final_answer[14]"]').val(0).trigger('change');

    $('input[name="followupanswer[136]"]').val('');
    $('input[name="followupanswer[137]"]').val('');
    $('input[name="followupanswer[138]"]').val('');
    $('input[name="followupanswer[139]"]').val('');
    $('input[name="followupanswer[140]"]').val('');
    $('input[name="followupanswer[141]"]').val('');
    $('input[name="followupanswer[142]"]').val('');
    $('input[name="followupanswer[143]"]').val('');

    if (selected_value != '') {
        if (selected_value == 'Yes') {
            $('#followupanswer14-pass').removeClass('display-none');
            $('input[name="final_answer[14]"]').val(1).trigger('change');
        } else {
            $('#followupanswer14-question').removeClass('display-none');
        }
    }
});
$(document).on('click', '#question14 #followupanswer14-question .sub-question', function() {
    var selected_value = '';
    if (!reset_click) {
        selected_value = $(this).attr('data-option');
    }
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    $(this).parent().find('.sub-question').removeClass('selection-highlighter');
    if (typeof selected_value != 'undefined' && selected_value != '') {
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.sub-question.selected-' + temp_selected_value).addClass('selection-highlighter');
    }
    $('#followupanswer14-question-2').addClass('display-none');
    $('#followupanswer14-question-3').addClass('display-none');
    $('#followupanswer14-fail').addClass('display-none');
    $('#followupanswer14-pass').addClass('display-none');
    $('#followupanswer14-question-2 .sub-question').removeClass('selection-highlighter');
    $('#followupanswer14-question-3 .sub-question').removeClass('selection-highlighter');
    $('input[name="final_answer[14]"]').val(0).trigger('change');

    $('input[name="followupanswer[142]"]').val('');
    $('input[name="followupanswer[143]"]').val('');

    var score = 0;
    var question = 0;
    var no_score = 0;
    $('#question14 #followupanswer14-question .sub-question.selection-highlighter').each(function() {
        var sub_selected_value = $(this).attr('data-option');
        if (sub_selected_value == 'Yes') {
            score += 1;
        }
        if (sub_selected_value == 'No') {
            no_score += 1;
        }
        question += 1;
    });
    if (score == 1) {
        $('#followupanswer14-question-2').removeClass('display-none');
    } else if (score >= 2) {
        $('#followupanswer14-pass').removeClass('display-none');
        $('input[name="final_answer[14]"]').val(1).trigger('change');
    } else {
        $('#followupanswer14-fail').removeClass('display-none');
    }
});
$(document).on('click', '#question14 #followupanswer14-question-2 .sub-question', function() {
    var selected_value = '';
    if (!reset_click) {
        selected_value = $(this).attr('data-option');
    }
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    $(this).parent().find('.sub-question').removeClass('selection-highlighter');
    if (typeof selected_value != 'undefined' && selected_value != '') {
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.sub-question.selected-' + temp_selected_value).addClass('selection-highlighter');
    }
    $('#followupanswer14-question-3').addClass('display-none');
    $('#followupanswer14-fail').addClass('display-none');
    $('#followupanswer14-pass').addClass('display-none');
    $('#followupanswer14-question-3 .sub-question').removeClass('selection-highlighter');
    $('input[name="final_answer[14]"]').val(0).trigger('change');

    $('input[name="followupanswer[143]"]').val('');

    if (selected_value != '') {
        if (selected_value == 'Yes') {
            $('#followupanswer14-question-3').removeClass('display-none');
        } else {
            $('#followupanswer14-fail').removeClass('display-none');
        }
    }
});
$(document).on('click', '#question14 #followupanswer14-question-3 .sub-question', function() {
    var selected_value = '';
    if (!reset_click) {
        selected_value = $(this).attr('data-option');
    }
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    $(this).parent().find('.sub-question').removeClass('selection-highlighter');
    if (typeof selected_value != 'undefined' && selected_value != '') {
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.sub-question.selected-' + temp_selected_value).addClass('selection-highlighter');
    }
    $('#followupanswer14-pass').addClass('display-none');
    $('#followupanswer14-fail').addClass('display-none');
    $('input[name="final_answer[14]"]').val(0).trigger('change');
    if (selected_value != '') {
        if (selected_value == 'Yes') {
            $('#followupanswer14-pass').removeClass('display-none');
            $('input[name="final_answer[14]"]').val(1).trigger('change');
        } else {
            $('#followupanswer14-fail').removeClass('display-none');
        }
    }
});
// question15
$(document).on('click', '#question15 .main-question', function() {
    var selected_value = $(this).attr('data-option');
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    var temp_selected_value = selected_value.toLowerCase();
    $(this).parents('li').find('.main-question').removeClass('selection-highlighter');
    $(this).parents('li').find('.main-question').addClass('hide');
    $(this).parents('li').find('.main-question.selected-' + temp_selected_value).addClass('selection-highlighter').removeClass('hide');
    $('#followupanswer15-yes-question').addClass('display-none');
    $('#followupanswer15-question').addClass('display-none');
    $('#followupanswer15-pass').addClass('display-none');
    $('#followupanswer15-fail').addClass('display-none');
    $('#description_151').addClass('display-none');
    $('.followupanswer15 .sub-question').removeClass('selection-highlighter');
    $('input[name="description[151]"]').val('');
    $('input[name="final_answer[15]"]').val(0).trigger('change');

    $('input[name="followupanswer[145]"]').val('');
    $('input[name="followupanswer[146]"]').val('');
    $('input[name="followupanswer[147]"]').val('');
    $('input[name="followupanswer[148]"]').val('');
    $('input[name="followupanswer[149]"]').val('');
    $('input[name="followupanswer[150]"]').val('');
    $('input[name="followupanswer[151]"]').val('');

    if (selected_value == 'Yes') {
        $('#followupanswer15-pass').addClass('display-none');
        $('#followupanswer15-question').removeClass('display-none');
    } else {
        $('#followupanswer15-pass').addClass('display-none');
        $('#followupanswer15-question').removeClass('display-none');
    }
});
$(document).on('click', '#question15 #followupanswer15-question .sub-question', function() {
    var selected_value = '';
    if (!reset_click) {
        selected_value = $(this).attr('data-option');
    }
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    $(this).parent().find('.sub-question').removeClass('selection-highlighter');
    if (typeof selected_value != 'undefined' && selected_value != '') {
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.sub-question.selected-' + temp_selected_value).addClass('selection-highlighter');
    }
    $('#followupanswer15-pass').addClass('display-none');
    $('#followupanswer15-fail').addClass('display-none');
    $('input[name="final_answer[15]"]').val(0).trigger('change');
    var score = 0;
    var question = 0;
    $('#question15 #followupanswer15-question .sub-question.selection-highlighter').each(function() {
        var sub_selected_value = $(this).attr('data-option');
        if (sub_selected_value == 'Yes') {
            score += 1;
        }
        question += 1;
    });
    if (score >= 2) {
        $('#followupanswer15-pass').removeClass('display-none');
        $('input[name="final_answer[15]"]').val(1).trigger('change');
    } else {
        $('#followupanswer15-fail').removeClass('display-none');
    }

    if (question_id == 'followupanswer[151]') {
        $('textarea[name="description[151]"]').val('');
        if (selected_value == 'Yes') {
            $('#description_151').removeClass('display-none');
        } else {
            $('#description_151').addClass('display-none');
        }
    }
});
// question16
$(document).on('click', '#question16 .main-question', function() {
    var selected_value = $(this).attr('data-option');
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    var temp_selected_value = selected_value.toLowerCase();
    $(this).parents('li').find('.main-question').removeClass('selection-highlighter');
    $(this).parents('li').find('.main-question').addClass('hide');
    $(this).parents('li').find('.main-question.selected-' + temp_selected_value).addClass('selection-highlighter').removeClass('hide');
    $('#followupanswer16-pass').addClass('display-none');
    $('#followupanswer16-fail').addClass('display-none');
    $('#followupanswer16-no-question').addClass('display-none');
    $('#followupanswer16-pass-question').addClass('display-none');
    $('#followupanswer16-fail-question').addClass('display-none');
    $('#followupanswer16-question').addClass('display-none');
    $('.followupanswer16 .sub-question').removeClass('selection-highlighter');
    $('input[name="final_answer[16]"]').val(0).trigger('change');

    $('input[name="followupanswer[168]"]').val('');
    $('input[name="followupanswer[169]"]').val('');
    $('input[name="followupanswer[170]"]').val('');
    $('input[name="followupanswer[171]"]').val('');
    $('input[name="followupanswer[172]"]').val('');
    $('input[name="followupanswer[173]"]').val('');

    if (selected_value == 'Yes') {
        $('#followupanswer16-pass').removeClass('display-none');
        $('input[name="final_answer[16]"]').val(1).trigger('change');
    } else {
        $('#followupanswer16-pass-question').removeClass('display-none');
        $('#followupanswer16-fail-question').removeClass('display-none');
    }
});
$(document).on('click', '#question16 #followupanswer16-pass-question .sub-question, #question16 #followupanswer16-fail-question .sub-question', function() {
    var selected_value = '';
    if (!reset_click) {
        selected_value = $(this).attr('data-option');
    }
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    $(this).parent().find('.sub-question').removeClass('selection-highlighter');
    if (typeof selected_value != 'undefined' && selected_value != '') {
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.sub-question.selected-' + temp_selected_value).addClass('selection-highlighter');
    }
    $('#followupanswer16-pass').addClass('display-none');
    $('#followupanswer16-fail').addClass('display-none');
    $('#followupanswer16-question').addClass('display-none');
    $('#followupanswer16-question .sub-question').removeClass('selection-highlighter');
    $('input[name="final_answer[16]"]').val(0).trigger('change');

    $('input[name="followupanswer[173]"]').val('');

    var score = 0;
    var score_no = 0;
    var score_2 = 0;
    var score_no_2 = 0;
    var question = 0;
    $('#question16 #followupanswer16-pass-question .sub-question.selection-highlighter').each(function() {
        var sub_selected_value = $(this).attr('data-option');
        if (sub_selected_value == 'Yes') {
            score += 1;
        }
        if (sub_selected_value == 'No') {
            score_no += 1;
        }
        question += 1;
    });
    $('#question16 #followupanswer16-fail-question .sub-question.selection-highlighter').each(function() {
        var sub_selected_value = $(this).attr('data-option');
        if (sub_selected_value == 'Yes') {
            score_2 += 1;
        }
        if (sub_selected_value == 'No') {
            score_no_2 += 1;
        }
        question += 1;
    });
    if (score > 0 && score_2 == 0) {
        $('#followupanswer16-pass').removeClass('display-none');
        $('input[name="final_answer[16]"]').val(1).trigger('change');
    } else if (score_2 > 0 && score == 0) {
        $('#followupanswer16-fail').removeClass('display-none');
    } else if ((score > 0 && score_2 > 0) || (score == 0 && score_no > 0 && score_2 == 0 && score_no_2 > 0)) {
        $('#followupanswer16-question').removeClass('display-none');
    }
});
$(document).on('click', '#question16 #followupanswer16-question .sub-question', function() {
    var selected_value = '';
    if (!reset_click) {
        selected_value = $(this).attr('data-option');
    }
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    $(this).parent().find('.sub-question').removeClass('selection-highlighter');
    if (typeof selected_value != 'undefined' && selected_value != '') {
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.sub-question.selected-' + temp_selected_value).addClass('selection-highlighter');
    }
    $('#followupanswer16-fail').addClass('display-none');
    $('#followupanswer16-pass').addClass('display-none');
    $('input[name="final_answer[16]"]').val(0).trigger('change');
    if (selected_value != '') {
        if (selected_value == 'Yes') {
            $('#followupanswer16-pass').removeClass('display-none');
            $('input[name="final_answer[16]"]').val(1).trigger('change');
        } else {
            $('#followupanswer16-fail').removeClass('display-none');
        }
    }
});
// question17
$(document).on('click', '#question17 .main-question', function() {
    var selected_value = $(this).attr('data-option');
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    var temp_selected_value = selected_value.toLowerCase();
    $(this).parents('li').find('.main-question').removeClass('selection-highlighter');
    $(this).parents('li').find('.main-question').addClass('hide');
    $(this).parents('li').find('.main-question.selected-' + temp_selected_value).addClass('selection-highlighter').removeClass('hide');
    $('#followupanswer17-fail').addClass('display-none');
    $('#followupanswer17-pass').addClass('display-none');
    $('#followupanswer17-question').addClass('display-none');
    $('#followupanswer17-yes-question').addClass('display-none');
    $('#description_157').addClass('display-none');
    $('#followupanswer17-yes-question .sub-question').removeClass('selection-highlighter');
    $('#followupanswer17-question .sub-question').removeClass('selection-highlighter');
    $('textarea[name="description[157]"]').val('');
    $('input[name="final_answer[17]"]').val(0).trigger('change');

    $('input[name="followupanswer[153]"]').val('');
    $('input[name="followupanswer[154]"]').val('');
    $('input[name="followupanswer[155]"]').val('');
    $('input[name="followupanswer[156]"]').val('');
    $('input[name="followupanswer[157]"]').val('');

    if (selected_value == 'Yes') {
        $('#followupanswer17-question').removeClass('display-none');
    } else {
        $('#followupanswer17-question').removeClass('display-none');
    }
});
$(document).on('click', '#question17 #followupanswer17-question .sub-question', function() {
    var selected_value = '';
    if (!reset_click) {
        selected_value = $(this).attr('data-option');
    }
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    $(this).parent().find('.sub-question').removeClass('selection-highlighter');
    if (typeof selected_value != 'undefined' && selected_value != '') {
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.sub-question.selected-' + temp_selected_value).addClass('selection-highlighter');
    }
    $('#followupanswer17-fail').addClass('display-none');
    $('#followupanswer17-pass').addClass('display-none');
    $('input[name="final_answer[17]"]').val(0).trigger('change');
    var score = 0;
    var question = 0;
    var score_no = 0;
    $('#question17 #followupanswer17-question .sub-question.selection-highlighter').each(function() {
        var sub_selected_value = $(this).attr('data-option');
        if (sub_selected_value == 'Yes') {
            score += 1;
        }
        if (sub_selected_value == 'No') {
            score_no += 1;
        }
        question += 1;
    });
    if (score > 0) {
        $('#followupanswer17-pass').removeClass('display-none');
        $('input[name="final_answer[17]"]').val(1).trigger('change');
    } else if (score_no > 0) {
        $('#followupanswer17-fail').removeClass('display-none');
    }

    if (question_id == 'followupanswer[157]') {
        $('textarea[name="description[157]"]').val('');
        if (selected_value == 'Yes') {
            $('#description_157').removeClass('display-none');
        } else {
            $('#description_157').addClass('display-none');
        }
    }
});
// question18
$(document).on('click', '#question18 .main-question', function() {
    var selected_value = $(this).attr('data-option');
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    var temp_selected_value = selected_value.toLowerCase();
    $(this).parents('li').find('.main-question').removeClass('selection-highlighter');
    $(this).parents('li').find('.main-question').addClass('hide');
    $(this).parents('li').find('.main-question.selected-' + temp_selected_value).addClass('selection-highlighter').removeClass('hide');
    $('#followupanswer18-yes-question').addClass('display-none');
    $('#followupanswer18-no-question').addClass('display-none');
    $('#followupanswer18-pass').addClass('display-none');
    $('#followupanswer18-fail').addClass('display-none');
    $('.followupanswer18').addClass('display-none');
    $('.followupanswer18 .sub-question').removeClass('selection-highlighter');
    $('input[name="final_answer[18]"]').val(0).trigger('change');

    $('input[name="followupanswer[174]"]').val('');
    $('input[name="followupanswer[177]"]').val('');
    $('input[name="followupanswer[178]"]').val('');
    $('input[name="followupanswer[179]"]').val('');
    $('input[name="followupanswer[180]"]').val('');
    $('input[name="followupanswer[181]"]').val('');

    if (selected_value == 'Yes') {
        $('#followupanswer18-yes-question').removeClass('display-none');
    } else {
        $('#followupanswer18-no-question').removeClass('display-none');
    }
});
$(document).on('click', '#question18 #followupanswer18-yes-question .sub-question', function() {
    var selected_value = '';
    if (!reset_click) {
        selected_value = $(this).attr('data-option');
    }
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    $(this).parents('.followupanswer18').find('.sub-question').removeClass('selection-highlighter');
    if (typeof selected_value != 'undefined' && selected_value != '') {
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.sub-question.selected-' + temp_selected_value).addClass('selection-highlighter');
    }
    $('#followupanswer18-pass').addClass('display-none');
    $('#followupanswer18-fail').addClass('display-none');
    $('#followupanswer18-no-question').addClass('display-none');
    $('#followupanswer18-no-question-2').addClass('display-none');
    $('#followupanswer18-no-question-1').addClass('display-none');
    $('input[name="final_answer[18]"]').val(0).trigger('change');
    $('#followupanswer18-no-question .sub-question').removeClass('selection-highlighter');
    $('#followupanswer18-no-question-2 .sub-question').removeClass('selection-highlighter');
    $('#followupanswer18-no-question-1 .sub-question').removeClass('selection-highlighter');

    $('input[name="followupanswer[177]"]').val('');
    $('input[name="followupanswer[178]"]').val('');
    $('input[name="followupanswer[179]"]').val('');
    $('input[name="followupanswer[180]"]').val('');
    $('input[name="followupanswer[181]"]').val('');

    if (selected_value != '') {
        if (selected_value == 'Yes') {
            $('#followupanswer18-pass').removeClass('display-none');
            $('input[name="final_answer[18]"]').val(1).trigger('change');
        } else {
            $('#followupanswer18-no-question').removeClass('display-none');
        }
    }
});
$(document).on('click', '#question18 #followupanswer18-no-question .sub-question', function() {
    var selected_value = '';
    if (!reset_click) {
        selected_value = $(this).attr('data-option');
    }
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    $(this).parent().find('.sub-question').removeClass('selection-highlighter');
    if (typeof selected_value != 'undefined' && selected_value != '') {
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.sub-question.selected-' + temp_selected_value).addClass('selection-highlighter');
    }
    $('#followupanswer18-pass').addClass('display-none');
    $('#followupanswer18-fail').addClass('display-none');
    $('#followupanswer18-no-question-2').addClass('display-none');
    $('#followupanswer18-no-question-1').addClass('display-none');
    $('input[name="final_answer[18]"]').val(0).trigger('change');
    $('#followupanswer18-no-question-2 .sub-question').removeClass('selection-highlighter');
    $('#followupanswer18-no-question-1 .sub-question').removeClass('selection-highlighter');

    $('input[name="followupanswer[177]"]').val('');
    $('input[name="followupanswer[178]"]').val('');
    $('input[name="followupanswer[179]"]').val('');
    $('input[name="followupanswer[180]"]').val('');
    $('input[name="followupanswer[181]"]').val('');
    
    if (selected_value != '') {
        if (selected_value == 'Yes') {
            $('#followupanswer18-no-question-2').removeClass('display-none');
        } else {
            $('#followupanswer18-no-question-1').removeClass('display-none');
        }
    }
});
$(document).on('click', '#question18 #followupanswer18-no-question-1 .sub-question', function() {
    var selected_value = '';
    if (!reset_click) {
        selected_value = $(this).attr('data-option');
    }
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    $(this).parent().find('.sub-question').removeClass('selection-highlighter');
    if (typeof selected_value != 'undefined' && selected_value != '') {
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.sub-question.selected-' + temp_selected_value).addClass('selection-highlighter');
    }
    $('#followupanswer18-pass').addClass('display-none');
    $('#followupanswer18-fail').addClass('display-none');
    $('#followupanswer18-no-question-2').addClass('display-none');
    $('#followupanswer18-no-question-2 .sub-question').removeClass('selection-highlighter');
    $('input[name="final_answer[18]"]').val(0).trigger('change');

    $('input[name="followupanswer[179]"]').val('');
    $('input[name="followupanswer[180]"]').val('');
    $('input[name="followupanswer[181]"]').val('');
    if (selected_value != '') {
        if (selected_value == 'No') {
            $('#followupanswer18-fail').removeClass('display-none');
        } else {
            $('#followupanswer18-no-question-2').removeClass('display-none');
        }
    }
});
$(document).on('click', '#question18 #followupanswer18-no-question-2 .sub-question', function() {
    var selected_value = '';
    if (!reset_click) {
        selected_value = $(this).attr('data-option');
    }
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    $(this).parent().find('.sub-question').removeClass('selection-highlighter');
    if (typeof selected_value != 'undefined' && selected_value != '') {
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.sub-question.selected-' + temp_selected_value).addClass('selection-highlighter');
    }
    $('#followupanswer18-fail').addClass('display-none');
    $('#followupanswer18-pass').addClass('display-none');
    $('input[name="final_answer[18]"]').val(0).trigger('change');
    var score = 0;
    var question = 0;
    $('#question18 #followupanswer18-no-question-2 .sub-question.selection-highlighter').each(function() {
        var sub_selected_value = $(this).attr('data-option');
        if (sub_selected_value == 'Yes') {
            score += 1;
        }
        question += 1;
    });
    if (score > 0) {
        $('#followupanswer18-pass').removeClass('display-none');
        $('input[name="final_answer[18]"]').val(1).trigger('change');
    } else {
        $('#followupanswer18-fail').removeClass('display-none');
    }
});
// question19
$(document).on('click', '#question19 .main-question', function() {
    var selected_value = $(this).attr('data-option');
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    var temp_selected_value = selected_value.toLowerCase();
    $(this).parents('li').find('.main-question').removeClass('selection-highlighter');
    $(this).parents('li').find('.main-question').addClass('hide');
    $(this).parents('li').find('.main-question.selected-' + temp_selected_value).addClass('selection-highlighter').removeClass('hide');
    $('#followupanswer19-pass').addClass('display-none');
    $('#followupanswer19-question').addClass('display-none');
    $('#followupanswer19-question-2').addClass('display-none');
    $('#followupanswer19-question-3').addClass('display-none');
    $('#followupanswer19-fail').addClass('display-none');
    $('#followupanswer19-question-2 .sub-question').removeClass('selection-highlighter');
    $('#followupanswer19-question-3 .sub-question').removeClass('selection-highlighter');
    $('#followupanswer19-question .sub-question').removeClass('selection-highlighter');
    $('input[name="final_answer[19]"]').val(0).trigger('change');

    $('input[name="followupanswer[158]"]').val('');
    $('input[name="followupanswer[159]"]').val('');
    $('input[name="followupanswer[160]"]').val('');

    if (selected_value == 'Yes') {
        $('#followupanswer19-pass').removeClass('display-none');
        $('input[name="final_answer[19]"]').val(1).trigger('change');
    } else {
        $('#followupanswer19-question').removeClass('display-none');
    }
});
$(document).on('click', '#question19 #followupanswer19-question .sub-question', function() {
    var selected_value = '';
    if (!reset_click) {
        selected_value = $(this).attr('data-option');
    }
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    $(this).parent().find('.sub-question').removeClass('selection-highlighter');
    if (typeof selected_value != 'undefined' && selected_value != '') {
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.sub-question.selected-' + temp_selected_value).addClass('selection-highlighter');
    }
    $('#followupanswer19-pass').addClass('display-none');
    $('#followupanswer19-question-2').addClass('display-none');
    $('#followupanswer19-question-3').addClass('display-none');
    $('#followupanswer19-fail').addClass('display-none');
    $('#followupanswer19-question-2 .sub-question').removeClass('selection-highlighter');
    $('#followupanswer19-question-3 .sub-question').removeClass('selection-highlighter');
    $('input[name="final_answer[19]"]').val(0).trigger('change');

    $('input[name="followupanswer[159]"]').val('');
    $('input[name="followupanswer[160]"]').val('');

    if (selected_value != '') {
        if (selected_value == 'Yes') {
            $('#followupanswer19-pass').removeClass('display-none');
            $('input[name="final_answer[19]"]').val(1).trigger('change');
        } else {
            $('#followupanswer19-question-2').removeClass('display-none');
        }
    }
});
$(document).on('click', '#question19 #followupanswer19-question-2 .sub-question', function() {
    var selected_value = '';
    if (!reset_click) {
        selected_value = $(this).attr('data-option');
    }
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    $(this).parent().find('.sub-question').removeClass('selection-highlighter');
    if (typeof selected_value != 'undefined' && selected_value != '') {
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.sub-question.selected-' + temp_selected_value).addClass('selection-highlighter');
    }
    $('#followupanswer19-pass').addClass('display-none');
    $('#followupanswer19-question-3').addClass('display-none');
    $('#followupanswer19-fail').addClass('display-none');
    $('#followupanswer19-question-3 .sub-question').removeClass('selection-highlighter');
    $('input[name="final_answer[19]"]').val(0).trigger('change');

    $('input[name="followupanswer[160]"]').val('');

    if (selected_value != '') {
        if (selected_value == 'Yes') {
            $('#followupanswer19-pass').removeClass('display-none');
            $('input[name="final_answer[19]"]').val(1).trigger('change');
        } else {
            $('#followupanswer19-question-3').removeClass('display-none');
        }
    }
});
$(document).on('click', '#question19 #followupanswer19-question-3 .sub-question', function() {
    var selected_value = '';
    if (!reset_click) {
        selected_value = $(this).attr('data-option');
    }
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    $(this).parent().find('.sub-question').removeClass('selection-highlighter');
    if (typeof selected_value != 'undefined' && selected_value != '') {
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.sub-question.selected-' + temp_selected_value).addClass('selection-highlighter');
    }
    $('#followupanswer19-pass').addClass('display-none');
    $('#followupanswer19-fail').addClass('display-none');
    $('input[name="final_answer[19]"]').val(0).trigger('change');
    if (selected_value != '') {
        if (selected_value == 'Yes') {
            $('#followupanswer19-pass').removeClass('display-none');
            $('input[name="final_answer[19]"]').val(1).trigger('change');
        } else {
            $('#followupanswer19-fail').removeClass('display-none');
        }
    }
});
// question20
$(document).on('click', '#question20 .main-question', function() {
    var selected_value = $(this).attr('data-option');
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    var temp_selected_value = selected_value.toLowerCase();
    $(this).parents('li').find('.main-question').removeClass('selection-highlighter');
    $(this).parents('li').find('.main-question').addClass('hide');
    $(this).parents('li').find('.main-question.selected-' + temp_selected_value).addClass('selection-highlighter').removeClass('hide');
    $('#question20 #followupanswer20-yes-question').addClass('display-none');
    $('#question20 #followupanswer20-no-question-2').addClass('display-none');
    $('#description_166').addClass('display-none');
    $('#followupanswer20-pass').addClass('display-none');
    $('#followupanswer20-fail').addClass('display-none');
    $('#question20 #followupanswer20-yes-question .sub-question').removeClass('selection-highlighter');
    $('#question20 #followupanswer20-no-question-2 .sub-question').removeClass('selection-highlighter');
    $('textarea[name="description[166]"]').val('');
    $('input[name="final_answer[20]"]').val(0).trigger('change');

    $('input[name="followupanswer[161]"]').val('');
    $('input[name="followupanswer[163]"]').val('');
    $('input[name="followupanswer[164]"]').val('');
    $('input[name="followupanswer[165]"]').val('');
    $('input[name="followupanswer[166]"]').val('');

    if (selected_value == 'Yes') {
        $('#followupanswer20-yes-question').removeClass('display-none');
    } else {
        $('#followupanswer20-no-question-2').removeClass('display-none');
    }
});
$(document).on('click', '#question20 #followupanswer20-yes-question .sub-question', function() {
    var selected_value = '';
    if (!reset_click) {
        selected_value = $(this).attr('data-option');
    }
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    $(this).parent().find('.sub-question').removeClass('selection-highlighter');
    if (typeof selected_value != 'undefined' && selected_value != '') {
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.sub-question.selected-' + temp_selected_value).addClass('selection-highlighter');
    }
    $('#question20 #followupanswer20-no-question-2').addClass('display-none');
    $('#followupanswer20-pass').addClass('display-none');
    $('#followupanswer20-fail').addClass('display-none');
    $('#description_166').addClass('display-none');
    $('#question20 #followupanswer20-no-question-2 .sub-question').removeClass('selection-highlighter');
    $('textarea[name="description[166]"]').val('');
    $('input[name="final_answer[20]"]').val(0).trigger('change');

    $('input[name="followupanswer[163]"]').val('');
    $('input[name="followupanswer[164]"]').val('');
    $('input[name="followupanswer[165]"]').val('');
    $('input[name="followupanswer[166]"]').val('');

    if (selected_value != '') {
        if (selected_value == 'Yes') {
            $('#followupanswer20-pass').removeClass('display-none');
            $('input[name="final_answer[20]"]').val(1).trigger('change');
        } else {
            $('#followupanswer20-no-question-2').removeClass('display-none');
        }
    }
});
$(document).on('click', '#question20 #followupanswer20-no-question-2 .sub-question', function() {
    var selected_value = '';
    if (!reset_click) {
        selected_value = $(this).attr('data-option');
    }
    var question_id = $(this).attr('data-question-id');
    $('input[name="' + question_id + '"]').val(selected_value);
    $(this).parent().find('.sub-question').removeClass('selection-highlighter');
    if (typeof selected_value != 'undefined' && selected_value != '') {
        var temp_selected_value = selected_value.toLowerCase();
        $(this).parent().find('.sub-question.selected-' + temp_selected_value).addClass('selection-highlighter');
    }
    $('#followupanswer20-pass').addClass('display-none');
    $('#followupanswer20-fail').addClass('display-none');
    $('input[name="final_answer[20]"]').val(0).trigger('change');
    var score = 0;
    var question = 0;
    $('#question20 #followupanswer20-no-question-2 .sub-question.selection-highlighter').each(function() {
        var sub_selected_value = $(this).attr('data-option');
        if (sub_selected_value == 'Yes') {
            score += 1;
        }
        question += 1;
    });
    if (score > 0) {
        $('#followupanswer20-pass').removeClass('display-none');
        $('input[name="final_answer[20]"]').val(1).trigger('change');
    } else {
        $('#followupanswer20-fail').removeClass('display-none');
    }
    if (question_id == 'followupanswer[166]') {
        $('textarea[name="description[166]"]').val('');
        if (selected_value == 'Yes') {
            $('#description_166').removeClass('display-none');
        } else {
            $('#description_166').addClass('display-none');
        }
    }
});
