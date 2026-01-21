var site_base_url = $('input[name="site_base_url"]').val();
$(document).ready(function() {
    tinymce.init({
        selector: '.tinymce-body',
        menubar: false,
        inline: true,
        plugins: 'preview powerpaste casechange importcss autolink link table lists tinymcespellchecker',
        toolbar: ['undo redo | bold italic underline strikethrough | fontfamily fontsize blocks |  numlist bullist | casechange | table'],
        content_style: '.tinymce-body { font-family: "times new roman", times, serif; font-size: 12pt; }',
    });

    $('.feeding_save_btn').on('click', function(e) {
        e.preventDefault();
        if ($('#feeding-form').valid() === true) {
            $('.action-btn button').prop('disabled', true);
            $(this).html('<i class="fas fa-spinner fa-pulse"></i> Loading...');
            var print_flag = $(this).attr('data-flag');
            $('input[name="print_flag"]').val(print_flag);
            if (print_flag == 1) {
                var next_tab = $('#feeding-form > .tabbable > .nav.nav-tabs > .active').next('li').find('a').attr('href');
                $('input[name="current_tab"]').val(next_tab);
            }
            var action_url = $("#feeding-form").attr('action');
            var serial = $('#feeding-form input, #feeding-form select').serializeArray();
            var editor_content0 = {'name': 'background_details', 'value': $('#background_details').html() };
            serial.push(editor_content0);
            var editor_content1 = {'name': 'development', 'value': $('#development').html() };
            serial.push(editor_content1);
            var editor_content2 = {'name': 'parent_concerns', 'value': $('#parent_concerns').html() };
            serial.push(editor_content2);
            var editor_content3 = {'name': 'current_feeding', 'value': $('#current_feeding').html() };
            serial.push(editor_content3);
            var editor_content4 = {'name': 'oral_motor_assessment', 'value': $('#oral_motor_assessment').html() };
            serial.push(editor_content4);
            var editor_content6 = {'name': 'cranial_nerve_assesment', 'value': $('#cranial_nerve_assesment').html() };
            serial.push(editor_content6);
            var editor_content7 = {'name': 'feeding_assesment', 'value': $('#feeding_assesment').html() };
            serial.push(editor_content7);
            var editor_content8 = {'name': 'mothers_examination', 'value': $('#mothers_examination').html() };
            serial.push(editor_content8);
            var editor_content9 = {'name': 'interpretation', 'value': $('#interpretation').html() };
            serial.push(editor_content9);
            var editor_content10 = {'name': 'recommendation', 'value': $('#recommendation').html() };
            serial.push(editor_content10);

            var current_clicked_element = $(this);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: serial,
                url: action_url,
                success: function(response) {
                    Showalert(response.type, response.message);
                    if (print_flag == 1) {
                        window.location.href = response.edit_url + '?active_tab=form';
                    } else {
                        window.location.href = response.list_url;
                    }
                },
                error: function() {
                    Showalert('error', 'Something went wrong, Please try again later...!');
                }
            });
        }
    });

    $('.feeding_update_btn').on('click', function(e) {
        e.preventDefault();
        if ($('#feeding-form').valid() === true) {
            var print_flag = $(this).data('flag');
            $('#print_flag').val(print_flag);
            if (print_flag > 0) {
                $(this).html('<i class="fas fa-spinner fa-pulse"></i> Loading...');
                $('.feeding_update_btn').prop('disabled', true);
            }
            var action_url = $("#feeding-form").attr('action');
            var serial = $('#feeding-form input, #feeding-form select').serializeArray();

            var editor_content0 = {'name': 'background_details', 'value': $('#background_details').html() };
            serial.push(editor_content0);
            var editor_content1 = {'name': 'development', 'value': $('#development').html() };
            serial.push(editor_content1);
            var editor_content2 = {'name': 'parent_concerns', 'value': $('#parent_concerns').html() };
            serial.push(editor_content2);
            var editor_content3 = {'name': 'current_feeding', 'value': $('#current_feeding').html() };
            serial.push(editor_content3);
            var editor_content4 = {'name': 'oral_motor_assessment', 'value': $('#oral_motor_assessment').html() };
            serial.push(editor_content4);
            var editor_content6 = {'name': 'cranial_nerve_assesment', 'value': $('#cranial_nerve_assesment').html() };
            serial.push(editor_content6);
            var editor_content7 = {'name': 'feeding_assesment', 'value': $('#feeding_assesment').html() };
            serial.push(editor_content7);
            var editor_content8 = {'name': 'mothers_examination', 'value': $('#mothers_examination').html() };
            serial.push(editor_content8);
            var editor_content9 = {'name': 'interpretation', 'value': $('#interpretation').html() };
            serial.push(editor_content9);
            var editor_content10 = {'name': 'recommendation', 'value': $('#recommendation').html() };
            serial.push(editor_content10);

            var current_clicked_element = $(this);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: serial,
                url: action_url,
                success: function(response) {
                    Showalert(response.type, response.message);
                    if (print_flag == 2) {
                        $('.feeding_update_btn').prop('disabled', false);
                        var next_tab = $('.nav.nav-tabs > .active').next('li').find('a');
                        if (next_tab.length > 0) {
                            if (next_tab.attr('href') == '#form') {
                                next_tab.trigger('click');
                                current_clicked_element.html('<i class="fa fa-floppy-o" aria-hidden="true"></i> <span>Finish & Close</span>');
                            } else {
                                current_clicked_element.html('<i class="fa fa-floppy-o" aria-hidden="true"></i> <span>Update & Next</span>');
                                next_tab.trigger('click');
                            }
                        } else {
                            window.location.href = response.list_url;
                        }
                    } else if (print_flag == 1) {
                        current_clicked_element.html('<i class="fa fa-floppy-o" aria-hidden="true"></i> <span>Update</span>');
                        $('.feeding_update_btn').prop('disabled', false);
                    } else if (print_flag == 3) {
                        window.location.href = response.print_url;
                    }
                },
                error: function() {
                    Showalert('error', 'Something went wrong, Please try again later...!');
                }
            });
        }
    });

    $('.nav-tabs li a').click(function() {
        if ($("#feeding-form").valid() === false) {
            $("#feeding-form").valid();
            return false;
        }
    });

    jQuery('#current_weight').keyup(function() {
        this.value = this.value.replace(/[^0-9]/g, '');
        $("#c_weight").empty();
        var current_weight = $('#current_weight').val() / 1000;
        $('#c_weight').val(current_weight);
    });

    $("#seenby_add").click(function() {
        option_select = $("select[name='seenby']").html();
        neo = '<select class="form-control full-width" name="seen_by[]">';
        neo += option_select;
        neo += '</select>';
        option = '<tr><td>' + neo + '</td>';
        option += '<td><span class="fa fa-trash btn btn-danger btn-view remove-neon"></span></td></tr>';
        $(".seen-by-div").append(option);
    });

});

visitFrom();
$(document).on('change', '#visit_from', function() {
    visitFrom();
});

function visitFrom() {

    var visit_from = $('#visit_from').val();

    if (visit_from == 'Others') {
        $('#visit_from_more').parent().parent().removeClass('hide');
    } else {
        $('#visit_from_more').parent().parent().addClass('hide');        
    }

}

parentConcerns();
$(document).on('change', '#is_parent_concerns', function() {
    parentConcerns();
});
function parentConcerns() {
    var is_parent_concerns = $('#is_parent_concerns').prop('checked');
    if (is_parent_concerns) {
        $('#parent_concerns').parent().parent().show();        
    } else {
        $('#parent_concerns').parent().parent().hide();
    }
}

currentFeeding();
$(document).on('change', '#is_current_feeding', function() {
    currentFeeding();
});
function currentFeeding() {
    var is_current_feeding = $('#is_current_feeding').prop('checked');
    if (is_current_feeding) {
        $('#current_feeding').parent().parent().show();        
    } else {
        $('#current_feeding').parent().parent().hide();
    }
}

oralMotorAssessment();
$(document).on('change', '#is_oral_motor_assessment', function() {
    oralMotorAssessment();
});
function oralMotorAssessment() {
    var is_oral_motor_assessment = $('#is_oral_motor_assessment').prop('checked');
    if (is_oral_motor_assessment) {
        $('#oral_motor_assessment').parent().parent().show();        
    } else {
        $('#oral_motor_assessment').parent().parent().hide();
    }
}

cranialNerveAssesment();
$(document).on('change', '#is_cranial_nerve_assesment', function() {
    cranialNerveAssesment();
});
function cranialNerveAssesment() {
    var is_cranial_nerve_assesment = $('#is_cranial_nerve_assesment').prop('checked');
    if (is_cranial_nerve_assesment) {
        $('#cranial_nerve_assesment').parent().parent().show();        
    } else {
        $('#cranial_nerve_assesment').parent().parent().hide();
    }
}

feedingAssesment();
$(document).on('change', '#is_feeding_assesment', function() {
    feedingAssesment();
});
function feedingAssesment() {
    var is_feeding_assesment = $('#is_feeding_assesment').prop('checked');
    if (is_feeding_assesment) {
        $('#feeding_assesment').parent().parent().show();        
    } else {
        $('#feeding_assesment').parent().parent().hide();
    }
}

mothersExamination();
$(document).on('change', '#is_mothers_examination', function() {
    mothersExamination();
});
function mothersExamination() {
    var is_mothers_examination = $('#is_mothers_examination').prop('checked');
    if (is_mothers_examination) {
        $('#mothers_examination').parent().parent().show();        
    } else {
        $('#mothers_examination').parent().parent().hide();
    }
}

interpretation();
$(document).on('change', '#is_interpretation', function() {
    interpretation();
});
$(document).on('input', 'input[name="BirthWeight"]', function() {
    if ($(this).val() && !isNaN($(this).val())) {
        $('input[name="birth_weight"]').val(parseInt($(this).val()) / 1000);
    } else {
        $('input[name="birth_weight"]').val('');
    }
});
$(document).on('input', 'input[name="discharge_weight"]', function() {
    if ($(this).val() && !isNaN($(this).val())) {
        $('input[name="d_weight"]').val(parseInt($(this).val()) / 1000);
    } else {
        $('input[name="d_weight"]').val('');
    }
});
$(document).on('input', 'input[name="current_weight"]', function() {
    if ($(this).val() && !isNaN($(this).val())) {
        $('input[name="c_weight"]').val(parseInt($(this).val()) / 1000);
    } else {
        $('input[name="c_weight"]').val('');
    }
});
function interpretation() {
    var is_interpretation = $('#is_interpretation').prop('checked');
    if (is_interpretation) {
        $('#interpretation').parent().parent().show();        
    } else {
        $('#interpretation').parent().parent().hide();
    }
}

$('#visit_date,#DOB,#g_weeks,#g_days').change(function () {
    if ($('#DOB').val() != '' && $('#visit_date').val() != '') {
        calculateOpage();
        calculateCorrectedage();
    }
});

$('input[name="review_days"]').blur(function() {
    var reviewDays = $(this).val();
    getReviewdays(reviewDays);
});

function getReviewdays(reviewDays) {
    $.ajax({
        Type: 'GET',
        url: site_base_url + '/out-patient-review' + '/' + reviewDays,
        success: function(responseText) {
            $('input[name="review"]').val(responseText.next_review);
        },
        error: function(responseText) {}
    });
}

function calculateOpage() {
    var monthDays = [];

    var visit_date = $('#visit_date').datepicker('getDate');
    var dobDate = $('#DOB').datepicker('getDate');

    var tempDays = calculateDays(dobDate, visit_date);

    var remainingDays = 0;

    if (visit_date.getFullYear() > dobDate.getFullYear()) {


        for (var i = dobDate.getMonth() + 1; i <= 12; i++) {

            if (getNumberDaysInmonth(dobDate.getFullYear(), i) == 31 && dobDate.getMonth() + 1 != i) {

                remainingDays++;

            }

        }

        for (var i = 1; i < visit_date.getMonth() + 1; i++) {

            if (getNumberDaysInmonth(visit_date.getFullYear(), i) == 31 && visit_date.getMonth() + 1 != i) {

                remainingDays++;

            }

        }

    } else if (visit_date.getFullYear() == dobDate.getFullYear()) {


        for (var i = dobDate.getMonth() + 2; i <= visit_date.getMonth() + 1; i++) {

            if (getNumberDaysInmonth(dobDate.getFullYear(), i) == 31) {

                remainingDays++;

            }

        }

    }


    totalWeeks = (tempDays / 7) > 0 ? (tempDays / 7) : 0;
    totalDays = (tempDays % 7) > 0 ? (tempDays % 7) : 0;

    year = ((tempDays / 365) > 0) ? tempDays / 365 : 0;
    tempDays = ((tempDays % 365) >= 0) ? tempDays % 365 : tempDays;

    month = ((tempDays / 30) > 0) ? tempDays / 31 : 0;
    tempDays = ((tempDays % 30) >= 0) ? tempDays % 31 : tempDays;


    $('input[name="chronological_year"]').val(parseInt(year));
    $('input[name="chronological_month"]').val(parseInt(month));
    $('input[name="chronological_days"]').val(parseInt(tempDays));


    $('input[name="total_chronological_weeks"]').val(parseInt(totalWeeks));
    $('input[name="total_chronological_days"]').val(parseInt(totalDays));


}
function calculateCorrectedage() {
    calculateCorrectedGestation(true);
}