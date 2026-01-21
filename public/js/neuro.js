$(document).on('click', '.full-tab-view', function(e)
{
    if ($(this).hasClass('check_gestation')) {
        var g_weeks = $('#g_weeks').val();
        if (g_weeks == '') {
            Showalert('warning', 'Baby Gestation is empty...!');
            $('#container-div').show();
        } else {
            var href = $(this).attr('data-href');
            $(href).addClass('active');
            $('#assessment').removeClass('active');
            $('#container-div').hide();
            if (href == '#ddst_form') {
                var gestation = $('#g_weeks').val();
                if (gestation >= 37) {
                    var year = typeof $('input[name="chronological_year"]').val() !== 'undefined' ? $('input[name="chronological_year"]').val() : 0;
                    var month = typeof $('input[name="chronological_month"]').val() !== 'undefined' ? $('input[name="chronological_month"]').val() : 0;
                    var days = typeof $('input[name="chronological_days"]').val() !== 'undefined' ? $('input[name="chronological_days"]').val() : 0;
                } else {
                    var year = typeof $('input[name="corrected_year"]').val() !== 'undefined' ? $('input[name="corrected_year"]').val() : 0;
                    var month = typeof $('input[name="corrected_month"]').val() !== 'undefined' ? $('input[name="corrected_month"]').val() : 0;
                    var days = typeof $('input[name="corrected_days"]').val() !== 'undefined' ? $('input[name="corrected_days"]').val() : 0;
                }
                var year = parseFloat(year) * 12;
                var days = parseFloat(days) / 30;
                var month_age = parseFloat(year) + parseFloat(month) + parseFloat(days);
                if (month_age > 24) {
                    var years = month_age - 24;
                    var plot_age = years / 3;
                    var age = 24 + plot_age;
                    age = parseFloat(age).toFixed(2);
                } else {
                    var age = parseFloat(month_age).toFixed(2);
                }
                $('input[name="ddst_age"]').val(age).trigger('change');
                setTimeout(function() {
                    $('.temp-chart-container').removeClass('temp-layer');
                }, 1000);
            } else if (href == '#dasii_form') {
                var gestation_weeks = $('#g_weeks').val();
                if (gestation_weeks && gestation_weeks < 37) {
                    var year = typeof $('input[name="corrected_year"]').val() !== 'undefined' ? $('input[name="corrected_year"]').val() : 0;
                    var month = typeof $('input[name="corrected_month"]').val() !== 'undefined' ? $('input[name="corrected_month"]').val() : 0;
                    var days = typeof $('input[name="corrected_days"]').val() !== 'undefined' ? $('input[name="corrected_days"]').val() : 0;
                } else {
                    var year = typeof $('input[name="chronological_year"]').val() !== 'undefined' ? $('input[name="chronological_year"]').val() : 0;
                    var month = typeof $('input[name="chronological_month"]').val() !== 'undefined' ? $('input[name="chronological_month"]').val() : 0;
                    var days = typeof $('input[name="chronological_days"]').val() !== 'undefined' ? $('input[name="chronological_days"]').val() : 0;
                }

                var total_month = (12 * parseInt(year)) + parseInt(month);
                var formatted_days = parseInt(parseInt(days) / 3);
                var dasii_age = total_month+'.'+ formatted_days;
                
                $('input[name="dasii_age"]').val(dasii_age).trigger('change');
                $('#dasii-age-label').html(dasii_age);
            } else if (href == '#bayley_form') {
                $('a[href="#bayleyOne"]').trigger('click');
                $('.category-block').addClass('hide');
                $('#cg-active-block').removeClass('hide');
            }
        }
    }
    else
    {
        $('#container-div').hide();
    }
});
$(document).on('click', '.back_to_screening', function(e)
{
    $('#container-div').show();
    $('#assessment').addClass('active');
    $('#hnne_form').removeClass('active');
    $('#hine_form').removeClass('active');
    $('#m-chat_form').removeClass('active');
    $('#dasii_form').removeClass('active');
    $('#ddst_form').removeClass('active');
    $('#cbcl_form').removeClass('active');
    $('#bayley_form').removeClass('active');
    $('#issa_form').removeClass('active');
    $('#cars_form').removeClass('active');
    $('#infants_form').removeClass('active');
    $('#preschoolers_form').removeClass('active');
    $('#pep3_form').removeClass('active');
    $('a[href="#bayleyOne"]').trigger('click');
    $('button.neuro_update_btn[data-flag="2"]').parent().show();
});
(function($) {
    $.fn.autoCompleteRaster = function(options) {
        //get the option value from parameter
        var autoCompleteSettings = $.extend({
            statements: null,
        }, options);
        // set the input suggestion to array 
        var statementsList = autoCompleteSettings.statements;
        var textid = $(this);
        var id = textid.attr('name');
        $.cookie(id, '');
        //trigger the list on key press event 
        textid.keypress(function(e) {
            if ((e.which > 96 && e.which < 123) || (e.which >= 32 && e.which < 91)) {
                // get the position top of the source  input container 
                var sourceTop = $(textid).position().top;
                // get the position left of the source  input container 
                var sourceLeft = $(textid).position().left;
                // get the height  of the source  input container 
                var sourceheight = $(textid).height();
                // get the width  of the source  input container 
                var sourceWidth = $(textid).width();
                //remove the already existing list in the document
                var searchText = $.cookie(id);
                searchText += e.key;
                $.cookie(id, searchText);
                $(document).find('.' + id).remove();
                var sugessionList = createSuggetionlist(statementsList, searchText);
                // calculate the source top to set the suggestion list 
                // sourceTop = ((sourceTop+$(textid).getCursorPosition()) > (sourceTop+sourceheight)) ? sourceTop +sourceheight - 5 : sourceTop+$(textid).getCursorPosition()+15;
                sourceTop = sourceTop + sourceheight;
                // set the parent div container for suggestion list  
                sugessionContainer = '<div  style="top:' + sourceTop + 'px; left:' + sourceLeft + 'px; z-index:1; height:' + sourceheight + 'px; width:' + sourceWidth + 'px; overflow:scroll;" class="complte-container ' + id + '">';
                sugessionContainer += '<ul data-sourcename="' + id + '" data-searchtext = ' + searchText + '>';
                sugessionContainer += sugessionList;
                sugessionContainer += '</ul>'
                sugessionContainer += '</div>';
                // append the list to the source container 
                $(textid).parent().append(sugessionContainer);
            } else if (e.which == 8) {
                var searchText = $.cookie(id);
                searchText = searchText.substring(0, searchText.length - 1);
                searchText = $.cookie(id, searchText);
            } else if (e.which == 0) {
                $.cookie(id, '');
            }
        });
        //remove the suggetion list form document when focus out 
        textid.blur(function() {
            setTimeout(function() {
                $('.' + id).remove();
            }, 300);
        });

        function createSuggetionlist(statementsList, searchText) {
            //create the suggestion list 
            var sugessionList = '';
            $.each(statementsList, function(index, value) {
                if (searchText != '' && typeof searchText != undefined) {
                    if (value.toUpperCase().indexOf(searchText.toUpperCase()) > -1) {
                        sugessionList += '<li class="complete-statement">' + value + '</li>';
                    }
                } else {
                    sugessionList += '<li class="complete-statement">' + value + '</li>';
                }
            });
            return (sugessionList != '') ? sugessionList : '<li class="">No Match found</li>';
        }
    }
    $(document).on('click', '.complete-statement', function() {
        var sourceName = $(this).parent().data('sourcename');
        var searchText = $(this).parent().data('searchtext');
        var previousText = $('textarea[name="' + sourceName + '"]').val();
        previousText = previousText.substring(0, (previousText.length - searchText.length));
        $('textarea[name="' + sourceName + '"]').val(previousText + $(this).text());
        $(this).parent().remove();
        $.cookie(sourceName, '');
    });
}(jQuery));

var site_base_url = $('input[name="site_base_url"]').val();
$(document).ready(function() {
    jQuery('#BirthWeight').keyup(function() {
        this.value = this.value.replace(/[^0-9]/g, '');
        $("#birth_weight").empty();
        var birth_weight = $('#BirthWeight').val() / 1000;
        $('#birth_weight').val(birth_weight);
    });
    $("#neuro-form").validate({
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
            // seen_by: {
                // required: true
            // },
            cbcl_interpretation: {
                required: true
            },
            examiner: {
                required: true
            }
            // visit_from: {
            //     required: true
            // }
        }
    });
    $('.neuro_save_btn').on('click', function(e) {
        e.preventDefault();
        if ($('#neuro-form').valid() === true) {
            $('.action-btn button').prop('disabled', true);
            $('input[name="print_flag"]').val(print_flag);
            if (print_flag == 1) {
                var next_tab = $('#neuro-form > .tabbable > .nav.nav-tabs > .active').next('li').find('a').attr('href');
                $('input[name="current_tab"]').val(next_tab);
            }
            var action_url = $("#neuro-form").attr('action');
            // $('#neuro-form').submit();
            var serial = $('#neuro-form input:not(.note-input), #neuro-form select, #neuro-form textarea:not(.note-input), .add-value').serializeArray();

            // if (typeof $('#basic_permission').val() !== 'undefined' && $('#basic_permission').val()) {
            //     var editor_content0 = {'name': 'baby_background', 'value': $('#baby_background').html() };
            //     serial.push(editor_content0);
            //     var editor_content1 = {'name': 'recommendation', 'value': $('#recommendation').html() };
            //     serial.push(editor_content1);
            //     var editor_content2 = {'name': 'baby_behavior', 'value': $('#baby_behavior').html() };
            //     serial.push(editor_content2);
            //     var editor_content3 = {'name': 'confidential_background_details', 'value': $('#confidential_background_details').html() };
            //     serial.push(editor_content3);
            //     var editor_content4 = {'name': 'diagnosis', 'value': $('#diagnosis').html() };
            //     serial.push(editor_content4);
            //     var editor_content6 = {'name': 'home_program', 'value': $('#home_program').html() };
            //     serial.push(editor_content6);
            //     var editor_content7 = {'name': 'cars', 'value': $('#cars').html() };
            //     serial.push(editor_content7);
            // }

            var current_clicked_element = $(this);
            var html_content = $(this).html();
            current_clicked_element.html('<i class="fas fa-spinner fa-pulse"></i> Loading...');
            var print_flag = current_clicked_element.attr('data-flag');

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
                        window.location.href = response.edit_url;
                    } else {
                        window.location.href = response.list_url;
                    }
                },
                error: function(response) {
                    var msg = JSON.parse(response.responseText);
                    if (typeof msg.message !== 'undefined') {
                        Showalert(msg.type, msg.message);
                    } else {
                        Showalert('error', 'Something went wrong, Please try again later...!');
                    }
                    current_clicked_element.html(html_content);
                    $('.neuro_save_btn').prop('disabled', false);
                }
            });
        }
    });
    $('.nav-tabs li a').click(function() {
        if ($("#neuro-form").valid() === false) {
            $("#neuro-form").valid();
            return false;
        }
    });
    $('#visit_date, #DOB, #g_weeks,#g_days').on('change', function() {
        getNeuroAge($('#visit_date').datepicker('getDate'), $('#DOB').datepicker('getDate'));
        calculateCorrectedGestation(true);
        customAge();
        var g_weeks = $('#g_weeks').val();
        if (g_weeks > 36) {
            $('#term').removeClass('hide');
            $('#preterm').addClass('hide');
            var chronological_year = $('input[name="chronological_year"]').val();
            var chronological_month = $('input[name="chronological_month"]').val();
            var chronological_days = $('input[name="chronological_days"]').val();
            if (chronological_year > 0) {
                $('#chronological_year_label').html(chronological_year + ' Y ');
            }
            if (chronological_month > 0) {
                $('#chronological_month_label').html(chronological_month + ' M ');
            }
            if (chronological_days > 0) {
                $('#chronological_days_label').html(chronological_days + ' D');
            }

            if (chronological_year == 0 && chronological_month == 0 && chronological_days == 0) {
                $('#corrected_days_label').html('0 D');                
            }
            $('input[name="chronological_month"]').trigger('change');

            if (chronological_year >= 2 || chronological_month > 18) {
                $('#m-chat_tab a').removeClass('not-active-btn');
            }
        } else {
            $('#preterm').removeClass('hide');
            $('#term').addClass('hide');
            var corrected_year = $('input[name="corrected_year"]').val();
            var corrected_month = $('input[name="corrected_month"]').val();
            var corrected_days = $('input[name="corrected_days"]').val();
            if (corrected_year > 0) {
                $('#corrected_year_label').html(corrected_year + ' Y ');
            }
            if (corrected_month > 0) {
                $('#corrected_month_label').html(corrected_month + ' M ');
            }
            if (corrected_days > 0) {
                $('#corrected_days_label').html(corrected_days + ' D');
            }

            if (corrected_year == 0 && corrected_month == 0 && corrected_days == 0) {
                $('#corrected_days_label').html('0 D');                
            }
            $('input[name="corrected_month"]').trigger('change');

            if (corrected_year >= 2 || corrected_month > 18) {
                $('#m-chat_tab a').removeClass('not-active-btn');
            }
        }
    });
    $('input[name="chronological_month"]').on('change', function() {
        var chronological_month = $(this).val();
        var chronological_year = $('input[name="chronological_year"]').val();
        var temp_assessment_date = new Date();
        day = temp_assessment_date.getDate();
        day = day > 9 ? day : '0' + day;
        month = temp_assessment_date.getMonth() + 1;
        month = month > 9 ? month : '0' + month;
        year = temp_assessment_date.getFullYear();
        var assessment_date = day + '-' + month + '-' + year;
        $('.assessment_date_0-3, .assessment_date_4-6, .assessment_date_7-9, .assessment_date_10-12').val('');
        $('input[name="pna_ca_assessment_0_3"], input[name="pna_ca_assessment_4_6"], input[name="pna_ca_assessment_7_9"], input[name="pna_ca_assessment_10_12"]').val('');
        $('.muscle-tone-norms table tbody > tr').addClass('display-none');
        if (chronological_year == 0) {
            if (chronological_month >= 0 && chronological_month <= 3) {
                $('.assessment_date_0-3').val(assessment_date);
                $('input[name="pna_ca_assessment_0_3"]').val(chronological_month + ' Months');
                $('.muscle-tone-norms table tbody > tr:first-child').removeClass('display-none');
            } else if (chronological_month >= 4 && chronological_month <= 6) {
                $('.assessment_date_4-6').val(assessment_date);
                $('input[name="pna_ca_assessment_4_6"]').val(chronological_month + ' Months');
                $('.muscle-tone-norms table tbody > tr:nth-child(2)').removeClass('display-none');
            } else if (chronological_month >= 7 && chronological_month <= 9) {
                $('.assessment_date_7-9').val(assessment_date);
                $('input[name="pna_ca_assessment_7_9"]').val(chronological_month + ' Months');
                $('.muscle-tone-norms table tbody > tr:nth-child(3)').removeClass('display-none');
            } else if (chronological_month >= 10 && chronological_month <= 12) {
                $('.assessment_date_10-12').val(assessment_date);
                $('input[name="pna_ca_assessment_10_12"]').val(chronological_month + ' Months');
                $('.muscle-tone-norms table tbody > tr:last-child').removeClass('display-none');
            }
        } else if (chronological_year == 1 && chronological_month == 0) {
            $('.assessment_date_10-12').val(assessment_date);
        } else {
            $('.assessment_date_10-12').val(assessment_date);
            // $('input[name="pna_ca_assessment_10_12"]').val(chronological_year + ' Years ' + chronological_month + ' Months');
            // $('.muscle-tone-norms table tbody > tr:last-child').removeClass('display-none');
        }
    })
    $('input[name="corrected_month"]').on('change', function() {
        var corrected_month = $(this).val();
        var corrected_year = $('input[name="corrected_year"]').val();
        var temp_assessment_date = new Date();
        day = temp_assessment_date.getDate();
        day = day > 9 ? day : '0' + day;
        month = temp_assessment_date.getMonth() + 1;
        month = month > 9 ? month : '0' + month;
        year = temp_assessment_date.getFullYear();
        var assessment_date = day + '-' + month + '-' + year;
        $('.assessment_date_0-3, .assessment_date_4-6, .assessment_date_7-9, .assessment_date_10-12').val('');
        $('input[name="pna_ca_assessment_0_3"], input[name="pna_ca_assessment_4_6"], input[name="pna_ca_assessment_7_9"], input[name="pna_ca_assessment_10_12"]').val('');
        $('.muscle-tone-norms table tbody > tr').addClass('display-none');
        if (corrected_year == 0) {
            if (corrected_month >= 0 && corrected_month <= 3) {
                $('.assessment_date_0-3').val(assessment_date);
                $('input[name="pna_ca_assessment_0_3"]').val(corrected_month + ' Months');
                $('.muscle-tone-norms table tbody > tr:first-child').removeClass('display-none');
            } else if (corrected_month >= 4 && corrected_month <= 6) {
                $('.assessment_date_4-6').val(assessment_date);
                $('input[name="pna_ca_assessment_4_6"]').val(corrected_month + ' Months');
                $('.muscle-tone-norms table tbody > tr:nth-child(2)').removeClass('display-none');
            } else if (corrected_month >= 7 && corrected_month <= 9) {
                $('.assessment_date_7-9').val(assessment_date);
                $('input[name="pna_ca_assessment_7_9"]').val(corrected_month + ' Months');
                $('.muscle-tone-norms table tbody > tr:nth-child(3)').removeClass('display-none');
            } else if (corrected_month >= 10 && corrected_month <= 12) {
                $('.assessment_date_10-12').val(assessment_date);
                $('input[name="pna_ca_assessment_10_12"]').val(corrected_month + ' Months');
                $('.muscle-tone-norms table tbody > tr:last-child').removeClass('display-none');
            }
        } else if (corrected_year == 1 && corrected_month == 0) {
            $('.assessment_date_10-12').val(assessment_date);
        } else {
            $('.assessment_date_10-12').val(assessment_date);
            $('input[name="pna_ca_assessment_10_12"]').val(corrected_year + ' Years ' + corrected_month + ' Months');
            $('.muscle-tone-norms table tbody > tr:last-child').removeClass('display-none');
        }
    });
    customAge();
    function customAge() {
        if ($('#g_weeks').val() > 36) {
            var years = parseInt($("input[name='chronological_year']").val());
            var months = parseInt($("input[name='chronological_month']").val());
            var days = parseInt($("input[name='chronological_days']").val());
        } else {
            var years = parseInt($("input[name='corrected_year']").val());
            var months = parseInt($("input[name='corrected_month']").val());
            var days = parseInt($("input[name='corrected_days']").val());
        }

        if (years > 0) {
            var temp_month = years * 12;
            months = months + temp_month;
        }
        $('#age-label').html(months + ' M ' + days + ' D');
        if (months > 0) {
            months = months * 30;
        }
        $('input[name="whole_days"]').val(months + days);

    }

    if ($('div').is('#edit-neuro')) {
        // $('#visit_date, #DOB').trigger('change');
        $('#visit_date').trigger('change');
        $('#BirthWeight').trigger('keyup');
    }
    if ($('input[name="BMrNo"]').hasClass('from-sub-list')) {
        // $('#visit_date, #DOB').trigger('change');
        $('#visit_date').trigger('change');
        $('#BirthWeight').trigger('keyup');
    }
    feeAmount();
    $('#fee_status').change(function() {
        feeAmount();
    });

    function feeAmount() {
       var listOne = ['fee_amount'];
       var listSecond = ['no_fee_reason'];
       if ($('#fee_status').prop('checked') == true) {
          removeDisable(listOne);
          makeDisable(listSecond);
      } else {
          makeDisable(listOne);
          removeDisable(listSecond);
      }
  }

  referral();
  $('#referral_status').change(function() {
    referral();
});

  function referral() {
    var listOne = ['referral_to'];
    var listSecond = [''];
    if ($('#referral_status').prop('checked') == true) {
        removeDisable(listOne);
        makeDisable(listSecond);
    } else {
        makeDisable(listOne);
        removeDisable(listSecond);
    }
}
tinymce.init({
    selector: '.tinymce-body',
    menubar: false,
    inline: true,
    plugins: 'preview powerpaste casechange importcss autolink link table lists tinymcespellchecker',
    toolbar: ['undo redo | bold italic underline strikethrough | fontfamily fontsize blocks |  numlist bullist | casechange | table'],
    content_style: '.tinymce-body { font-family: "times new roman", times, serif; font-size: 12pt; }',
});

$('#eligibility input[type="checkbox"]').on('click', function() {
    if ($(this).prop('checked') == true) {
        $(this).parents('tr').addClass('bg-warning');
    } else {
        $(this).parents('tr').removeClass('bg-warning');            
    }
});
});

$(document).on('click', '.neuro_update_btn', function(e) {
    e.preventDefault();
    if ($('#neuro-form').valid() === true) {
        var print_flag = $(this).data('flag');
        $('#print_flag').val(print_flag);
        if (print_flag != 6) {
            $(this).html('<i class="fas fa-spinner fa-pulse"></i> Loading...');
            $('.neuro_update_btn').prop('disabled', true);
        }
        // var serial = $($("#neuro-form")[0].elements).serializeArray();
        var serial = $('#neuro-form input:not(.note-input), #neuro-form select, #neuro-form textarea:not(.note-input), .add-value').serializeArray();
        var action_url = $("#neuro-form").attr('action');

        if (typeof $('#basic_permission').val() !== 'undefined' && $('#basic_permission').val()) {
            var editor_content0 = {'name': 'baby_background', 'value': $('#baby_background').html() };
            serial.push(editor_content0);
            var editor_content1 = {'name': 'recommendation', 'value': $('#recommendation').html() };
            serial.push(editor_content1);
            // var editor_content2 = {'name': 'baby_behavior', 'value': $('#baby_behavior').html() };
            var editor_content2 = {'name': 'baby_behavior', 'value': tinymce.get('baby_behavior').getContent() };
            console.log(tinymce.get('baby_behavior').getContent());
            serial.push(editor_content2);
            var editor_content3 = {'name': 'confidential_background_details', 'value': $('#confidential_background_details').html() };
            serial.push(editor_content3);
            var editor_content4 = {'name': 'diagnosis', 'value': $('#diagnosis').html() };
            serial.push(editor_content4);
            var editor_content6 = {'name': 'home_program', 'value': $('#home_program').html() };
            serial.push(editor_content6);
            var editor_content7 = {'name': 'cars', 'value': $('#cars').html() };
            serial.push(editor_content7);
        }
        console.log(serial);
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
                    $('.neuro_update_btn').prop('disabled', false);
                    var next_tab = $('#container-div.nav.nav-tabs > .active').next('li').find('a');
                    if (next_tab.length > 0) {
                        if (next_tab.attr('href') == '#media_tab') {
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
                    $('.neuro_update_btn').prop('disabled', false);
                } else if (print_flag == 3) {
                    window.location.href = response.print_url;
                } else if (print_flag == 5) {
                    window.location.href = response.assessment_print_url;
                }
            },
            error: function() {
                Showalert('error', 'Something went wrong, Please try again later...!');
            }
        });
    }
});
$('input[name="review_date"]').datepicker({
    dateFormat: 'dd-mm-yy',
    yearRange: "-0:-20",
    changeMonth: true,
    changeYear: true,
    minDate: '-0M',
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
$('#container-div.nav.nav-tabs li a').on('click', function() {
    var current_clicked_element = $(this).attr('href');
    if (current_clicked_element == '#media_tab') {
        $('.neuro_update_btn[data-flag="2"]').html('<i class="fa fa-floppy-o" aria-hidden="true"></i> <span>Finish & Close</span>');
    } else {
        $('.neuro_update_btn[data-flag="2"]').html('<i class="fa fa-floppy-o" aria-hidden="true"></i> <span>Update & Next</span>');
    }
});

jQuery('input[name="current_weight_g"]').keyup(function () {
    this.value = this.value.replace(/[^0-9]/g, '');
    $('input[name="current_weight_kg"]').empty();
    var birth_weight = $('input[name="current_weight_g"]').val() / 1000;
    $('input[name="current_weight_kg"]').val(birth_weight);
});

$('input[name="mental_development_quotient"]').trigger('change');
$('input[name="motor_development_quotient"]').trigger('change');

$(window).scroll(function(){
    if ($(this).scrollTop() > 100) {
        $('.back-to-screeening').addClass('fixed-nav');
    } else {
        $('.back-to-screeening').removeClass('fixed-nav');
    }
});

$('#hnne_form, #hine_form, #m-chat_form, #dasii_form, #ddst_form, #cbcl_form, #bayley_form, #issa_form, #cars_form,#infants_form, #preschoolers_form').on('click', function() {
    $('button.neuro_update_btn[data-flag="2"]').parent().hide();
});

issa();

$('input[name="srr"], input[name="er"], input[name="slc"], input[name="bp"], input[name="sa"], input[name="cc"]').on('change', function() {
    issa();    
});

function issa() {
    var srr = $('input[name="srr"]').val();
    if (typeof srr !== 'undefined') {
        srr = srr.length > 0 ? parseInt(srr) : 0;
    }
    var er = $('input[name="er"]').val();
    if (typeof er !== 'undefined') {
        er = er.length > 0 ? parseInt(er) : 0;
    }
    var slc = $('input[name="slc"]').val();
    if (typeof slc !== 'undefined') {
        slc = slc.length > 0 ? parseInt(slc) : 0;
    }
    var bp = $('input[name="bp"]').val();
    if (typeof bp !== 'undefined') {
        bp = bp.length > 0 ? parseInt(bp) : 0;
    }
    var sa = $('input[name="sa"]').val();
    if (typeof sa !== 'undefined') {
        sa = sa.length > 0 ? parseInt(sa) : 0;
    }
    var cc = $('input[name="cc"]').val();
    if (typeof cc !== 'undefined') {
        cc = cc.length > 0 ? parseInt(cc) : 0;
    }
    var total = srr + er + slc + bp + sa + cc;
    $('input[name="total"]').val(total);

    var issa_status = '';
    var status = '';
    if (total > 0 && total < 70) {
        issa_status = 'Normal';
        status = 'label-success';
    } else if (total >= 70 && total <= 106) {
        issa_status = 'Mild Autism';
        status = 'label-mild';
    } else if (total >= 107 && total <= 153) {
        issa_status = 'Moderate Autism';
        status = 'bg-warningg';
    } else if (total > 153) {
        issa_status = 'Severe Autism';
        status = 'label-danger';
    }

    if (total > 0) {
        $('.issa_status').html(total + ' - (' + issa_status + ')').removeClass('label-success').removeClass('label-mild').removeClass('bg-warningg').removeClass('label-danger').addClass(status);

        $('#issa_tab .total_score').parent().removeClass('hide');
        $('input[name="issa_status"]').val(issa_status);
        $('#issa_tab .total_score').html('(' + total + ') ' + issa_status).removeClass('label-success').removeClass('label-mild').removeClass('bg-warningg').removeClass('label-danger').addClass(status);
    }
}

cars();

$('input[name="relating_to_people"], input[name="imitation"], input[name="emotional_response"], input[name="body_use"], input[name="object_use"], input[name="adaptation_to_change"], input[name="visual_response"], input[name="listening_response"], input[name="tst_response_use"], input[name="fear_nervous"], input[name="verbal"], input[name="non_verbal"], input[name="activity_level"], input[name="intellectual_response"], input[name="general_imperssions"]').on('change', function() {
    cars();    
});

function cars() {
    var relating_to_people = $('input[name="relating_to_people"]').val();
    if (typeof relating_to_people !== 'undefined') {
        relating_to_people = relating_to_people.length > 0 ? parseFloat(relating_to_people) : 0;
    }
    var imitation = $('input[name="imitation"]').val();
    if (typeof imitation !== 'undefined') {
        imitation = imitation.length > 0 ? parseFloat(imitation) : 0;
    }
    var emotional_response = $('input[name="emotional_response"]').val();
    if (typeof emotional_response !== 'undefined') {
        emotional_response = emotional_response.length > 0 ? parseFloat(emotional_response) : 0;
    }
    var body_use = $('input[name="body_use"]').val();
    if (typeof body_use !== 'undefined') {
        body_use = body_use.length > 0 ? parseFloat(body_use) : 0;
    }
    var object_use = $('input[name="object_use"]').val();
    if (typeof object_use !== 'undefined') {
        object_use = object_use.length > 0 ? parseFloat(object_use) : 0;
    }
    var adaptation_to_change = $('input[name="adaptation_to_change"]').val();
    if (typeof adaptation_to_change !== 'undefined') {
        adaptation_to_change = adaptation_to_change.length > 0 ? parseFloat(adaptation_to_change) : 0;
    }
    var visual_response = $('input[name="visual_response"]').val();
    if (typeof visual_response !== 'undefined') {
        visual_response = visual_response.length > 0 ? parseFloat(visual_response) : 0;
    }
    var listening_response = $('input[name="listening_response"]').val();
    if (typeof listening_response !== 'undefined') {
        listening_response = listening_response.length > 0 ? parseFloat(listening_response) : 0;
    }
    var tst_response_use = $('input[name="tst_response_use"]').val();
    if (typeof tst_response_use !== 'undefined') {
        tst_response_use = tst_response_use.length > 0 ? parseFloat(tst_response_use) : 0;
    }
    var fear_nervous = $('input[name="fear_nervous"]').val();
    if (typeof fear_nervous !== 'undefined') {
        fear_nervous = fear_nervous.length > 0 ? parseFloat(fear_nervous) : 0;
    }
    var verbal = $('input[name="verbal"]').val();
    if (typeof verbal !== 'undefined') {
        verbal = verbal.length > 0 ? parseFloat(verbal) : 0;
    }
    var non_verbal = $('input[name="non_verbal"]').val();
    if (typeof non_verbal !== 'undefined') {
        non_verbal = non_verbal.length > 0 ? parseFloat(non_verbal) : 0;
    }
    var activity_level = $('input[name="activity_level"]').val();
    if (typeof activity_level !== 'undefined') {
        activity_level = activity_level.length > 0 ? parseFloat(activity_level) : 0;
    }
    var intellectual_response = $('input[name="intellectual_response"]').val();
    if (typeof intellectual_response !== 'undefined') {
        intellectual_response = intellectual_response.length > 0 ? parseFloat(intellectual_response) : 0;
    }
    var general_imperssions = $('input[name="general_imperssions"]').val();
    if (typeof general_imperssions !== 'undefined') {
        general_imperssions = general_imperssions.length > 0 ? parseFloat(general_imperssions) : 0;
    }

    var total = relating_to_people + imitation + emotional_response + body_use + object_use + adaptation_to_change + visual_response + listening_response + tst_response_use + fear_nervous + verbal + non_verbal + activity_level + intellectual_response + general_imperssions;

    $('input[name="cars_total"]').val(total);

    var cars_status = '';
    var status = '';
    if (total >= 15 && total <= 29.5) {
        cars_status = 'Minimal-to-No';
        status = 'label-success';
    } else if (total >= 30 && total <= 36.5) {
        cars_status = 'Mild-to-Moderate';
        status = 'label-mild';
    } else if (total >= 37) {
        cars_status = 'Severe';
        status = 'bg-warningg';
    }

    if (total > 0) {
        $('#cars_status').html('(' + cars_status + ')');
        $('#cars_tab .total_score').parent().removeClass('hide');
        $('input[name="cars_status"]').val(cars_status);
        $('#cars_tab .total_score').html('(' + total + ') ' + cars_status).removeClass('label-success').removeClass('label-mild').removeClass('bg-warningg').addClass(status);
    }
}

