function flowComplete(opMenu) {

    if (opMenu == 'opform') {

        $('.next > span').html('Finish & Close');
        $('.normal-print').removeClass('hide');
        $('.opbtnaction').removeClass('col-sm-4').addClass('col-sm-6');

    } else {

        $('.next > span').html('Next');
        $('.opbtnaction').removeClass('col-sm-6').addClass('col-sm-4');

        if (!$('.normal-print').hasClass('hide')) {
            $('.normal-print').addClass('hide');
        }

    }
}

function calculateOpage() {
    var monthDays = [];

    var opDate = $('#OpDate').datepicker('getDate');
    var dobDate = $('#DOB').datepicker('getDate');

    var tempDays = calculateDays(dobDate, opDate);

    var remainingDays = 0;

    if (opDate.getFullYear() > dobDate.getFullYear()) {


        for (var i = dobDate.getMonth() + 1; i <= 12; i++) {

            if (getNumberDaysInmonth(dobDate.getFullYear(), i) == 31 && dobDate.getMonth() + 1 != i) {

                remainingDays++;

            }

        }

        for (var i = 1; i < opDate.getMonth() + 1; i++) {

            if (getNumberDaysInmonth(opDate.getFullYear(), i) == 31 && opDate.getMonth() + 1 != i) {

                remainingDays++;

            }

        }

    } else if (opDate.getFullYear() == dobDate.getFullYear()) {


        for (var i = dobDate.getMonth() + 2; i <= opDate.getMonth() + 1; i++) {

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

function getNumberDaysInmonth(sourceYear, sourceMonth) {

    var date = new Date(sourceYear, sourceMonth, 0);

    return date.getDate();

}


// function calculateCorrectedage() {

//     var opDate = $('#OpDate').datepicker('getDate');
//     var dobDate = $('#DOB').datepicker('getDate');
//     var gestationWeeks = $('input[name="g_weeks"]').val();
//     var gestationDays = $('input[name="g_days"]').val();
//     if (gestationWeeks >= 37) {
//         $('input[name=total_corrected_weeks').val('0');
//         $('input[name=total_corrected_days').val('0');
//         $('input[name=corrected_year').val('0');
//         $('input[name=corrected_month').val('0');
//         $('input[name=corrected_days').val('0');
//         $('.corrected_age').parent().parent().slideUp();
//     }
//     else
//     {
//         $('.corrected_age').parent().parent().slideDown();
//     }
//     var preMeturedays = 0;

//     // if (gestationWeeks != '' && (40 - gestationWeeks) > 0 && gestationDays > 0) {

//     //     var preMeturedays = ((40 - (parseInt(gestationWeeks) + 1)) * 7) + (7 - parseInt(gestationDays));


//     // } else if (gestationWeeks != '' && (40 - gestationWeeks) > 0) {

//     //     var preMeturedays = ((40 - parseInt(gestationWeeks)) * 7) + parseInt(gestationDays);

//     // }



//     var chronological_age = calculateDays(dobDate, opDate);

//     var corrected_age = (40 - parseInt(gestationWeeks)) * 7;
//     corrected_age = corrected_age + parseInt(gestationDays);
//     corrected_age_days = chronological_age - corrected_age;

//     var corrected_age_weeks = parseInt(corrected_age_days/7);
//     if (corrected_age_weeks > 0) {
//         $('input[name=total_corrected_weeks').val(corrected_age_weeks);

//     }
//     else
//     {
//         $('input[name=total_corrected_weeks').val(0);
//     }
//     var corrected_age_rem_days = corrected_age_days%7;
//     if (corrected_age_weeks > 0) {
//         $('input[name=total_corrected_days').val(corrected_age_rem_days);

//     }
//     else
//     {
//         $('input[name=total_corrected_days').val(0);
//     }

//     var chronological_formatted_values = getFormatedStringFromDays(chronological_age);
//     var correceted_formatted_values = getFormatedStringFromDays(corrected_age_days);


//     // var total_corrected_weeks =  parseInt(corrected_age_days / 7);
//     // var total_corrected_days =  corrected_age_days % 7;

//     var formated_corr_years = correceted_formatted_values[0];
//     if (formated_corr_years != '') {
//         $('input[name=corrected_year').val(formated_corr_years);
//     }
//     else
//     {
//         $('input[name=corrected_year').val(0);
//     }


//     var formated_corr_months = correceted_formatted_values[1];
//     if (formated_corr_months != '') {
//         $('input[name=corrected_month').val(formated_corr_months);
//     }
//     else
//     {
//         $('input[name=corrected_month').val(0);
//     }

//     var formated_corr_days = correceted_formatted_values[2];
//     if (formated_corr_days != '') {
//         $('input[name=corrected_days').val(formated_corr_days);
//     }
//     else
//     {
//         $('input[name=corrected_days').val(0);
//     }


//     var formated_chro_years = chronological_formatted_values[0];
//     var formated_chro_months = chronological_formatted_values[1];
//     var formated_chro_days = chronological_formatted_values[2];


//     // var corrected_age = chronological_age - (((40 - parseInt(gestationWeeks)) * 7) + gestationDays);



//     // var remainingDays = 0;
//     // var ageUrl = $('input[name="op_age_calculater"]').val() + '/' + dobDate + '/' + opDate + '/' + preMeturedays;

//     // if (gestationWeeks < 37) {
//     //     $('input[name="total_corrected_weeks"]').val(parseInt(tempDays / 7));
//     //     $('input[name="total_corrected_days"]').val(parseInt(tempDays % 7));

//     // }

//     // // subtract the difference gestation from total days 
//     // tempDays = tempDays - preMeturedays;

//     // //temp solution need to verify
//     // year = parseInt(tempDays / 365);
//     // tempyear = tempDays % 365;
//     // month = parseInt(tempyear / 31);
//     // tempDays = parseInt(tempyear % 31);

//     // //temp solution need to verify

//     // $.ajax({
//     //     type: 'GET',
//     //     url: ageUrl,
//     //     success: function (data) {

//     //         $('input[name="chronological_year"]').val(parseInt(data.results.chronologicalAge.year));
//     //         $('input[name="chronological_month"]').val(parseInt(data.results.chronologicalAge.month));
//     //         $('input[name="chronological_days"]').val(parseInt(data.results.chronologicalAge.days));

//     //         // $('input[name="corrected_year"]').val(parseInt(data.results.correctedAge.year));
//     //         // $('input[name="corrected_month"]').val(parseInt(data.results.correctedAge.month));
//     //         // $('input[name="corrected_days"]').val(parseInt(data.results.correctedAge.days));
//     //         if (gestationWeeks < 37) {
//     //             // $('input[name="corrected_year"]').val(parseInt(year));
//     //             // $('input[name="corrected_month"]').val(parseInt(month));
//     //             // $('input[name="corrected_days"]').val(Math.abs(tempDays));
//     //         } else {
//     //             $('input[name="corrected_year"]').val(parseInt(data.results.chronologicalAge.year));
//     //             $('input[name="corrected_month"]').val(parseInt(data.results.chronologicalAge.month));
//     //             $('input[name="corrected_days"]').val(parseInt(data.results.chronologicalAge.days));
//     //         }


//     //     },
//     //     error: function (data) {
//     //         Showalert('error', 'Your messsage failed to sent !');

//     //     }
//     // });


//     // //star age in weeks and days like gestation
//     // totalWeeks = (tempDays / 7) > 0 ? (tempDays / 7) : 0;
//     // totalDays = (tempDays % 7) > 0 ? (tempDays % 7) : 0;
//     // // totalWeeks = totalWeeks - preMetureweeks;
//     // // totalDays  = gestationDays >  totalDays  ? gestationDays - totalDays : 0 ; 


//     // year = ((tempDays / 365) > 0) ? tempDays / 365 : 0;
//     // tempDays = ((tempDays % 365) >= 0) ? tempDays % 365 : tempDays;
//     // month = ((tempDays / 30) > 0) ? tempDays / 31 : 0;
//     // tempDays = ((tempDays % 30) >= 0) ? tempDays % 31 : tempDays;
//     // days = (tempDays > 0) ? tempDays : 0;


//     // if (gestationWeeks < 37) {
//     //     $('input[name="corrected_year"]').val(parseInt(year));
//     //     $('input[name="corrected_month"]').val(parseInt(month));
//     //     $('input[name="corrected_days"]').val(parseInt(days));

//     //     $('input[name="total_corrected_weeks"]').val(parseInt(totalWeeks));
//     //     $('input[name="total_corrected_days"]').val(parseInt(totalDays));
//     // }


// }


function calculateCorrectedage() {
    calculateCorrectedGestation(true);
}

if ( typeof $('#DOB').val() != 'undefined' && $('#DOB').val() != '' && typeof $('#OpDate').val() != 'undefined' && $('#OpDate').val() != '') {

    calculateOpage();
    calculateCorrectedage();

}


$('#OpDate,#DOB,#g_weeks,#g_days').change(function () {
    if ($('#DOB').val() != '' && $('#OpDate').val() != '') {
        calculateOpage();
        calculateCorrectedage();
    }
});

(function ($, undefined) {
    $.fn.getCursorPosition = function () {
        var el = $(this).get(0);
        var pos = 0;
        if ('selectionStart' in el) {
            pos = el.selectionStart;
        } else if ('selection' in document) {
            el.focus();
            var Sel = document.selection.createRange();
            var SelLength = document.selection.createRange().text.length;
            Sel.moveStart('character', -el.value.length);
            // console.log(Sel.text.length);
            pos = Sel.text.length - SelLength;
        }
        return pos;
    }
})(jQuery);


(function ($) {

    $.fn.autoCompleteRaster = function (options) {

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
        textid.keypress(function (e) {

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
        textid.blur(function () {

            setTimeout(function () {

                $('.' + id).remove();

            }, 300);

        });

        function createSuggetionlist(statementsList, searchText) {

            //create the suggestion list 
            var sugessionList = '';

            $.each(statementsList, function (index, value) {

                if (searchText != '' && typeof searchText != undefined) {

                    if (value.toUpperCase().indexOf(searchText.toUpperCase()) > -1) {

                        sugessionList += '<li class="complete-statement">' + value + '</li>';

                    }

                } else {

                    sugessionList += '<li class="complete-statement">' + value + '</li>';
                }

            });
            // console.log(searchText);

            return (sugessionList != '') ? sugessionList : '<li class="">No Match found</li>';


        }


    }

    $(document).on('click', '.complete-statement', function () {
        var sourceName = $(this).parent().data('sourcename');
        var searchText = $(this).parent().data('searchtext');
        var previousText = $('textarea[name="' + sourceName + '"]').val();
        previousText = previousText.substring(0, (previousText.length - searchText.length));

        $('textarea[name="' + sourceName + '"]').val(previousText + $(this).text());
        $(this).parent().remove();

        $.cookie(sourceName, '');


    });


}(jQuery));

function neruosonogramChange() {


    var list = ['neurosonogram_report'];
    if ($('#neurosonogram').prop('checked') == false) {

        makeDisable(list);

    } else {

        removeDisable(list);

    }

}

function echoCardiogram() {

    var list = ['echocardiogram_report'];
    if ($('#echocardiogram').prop('checked') == false) {
        makeDisable(list);
        $('#echocardiogram_report').val('');

    } else {

        removeDisable(list);

    }

}

function feeAmount() {
    var listOne = ['fee_amount'];
    var listSecond = ['fee_reason'];
    if ($('#fee_status').prop('checked') == false) {
        makeDisable(listOne);
        removeDisable(listSecond);
    } else {
        removeDisable(listOne);
        makeDisable(listSecond);

    }

}

function immunizationStatus() {
    if ($('#Immunization').val() == 'Due' || $('#Immunization').val() == '' || $('#Immunization').val() == 'Complete') {
        $('.op_vaccine').parent().hide();
    } else {
        $('.op_vaccine').parent().show();
    }
}


$(document).ready(function () {

    neruosonogramChange();
    echoCardiogram();
    feeAmount();
    immunizationStatus();

});


$('#neurosonogram').change(function () {

    neruosonogramChange();

});


$('#Immunization').change(function () {

    immunizationStatus();

});

$('#echocardiogram').change(function () {

    echoCardiogram();

});

$('#fee_status').change(function () {
    feeAmount();
});


$('.op-growth-chart-add').click(function () {

    var l = $('.growth-chart-gestation tbody tr').length + 1;
    var option = '<tr>';
    option += '<td><input class="form-control input-width-small chart_date datepicker" id="chart_date' + l + '" name="chart_date[]" type="text"></td>';
    option += '<td><input class="form-control input-width-small chart_gestation" id="chart_gestation' + l + '" name="chart_gestation[]" type="text"></td>';
    option += '<td><input class="form-control input-width-small chart_weigth" id="chart_weigth' + l + '" name="chart_weigth[]" type="text"></td>';
    option += '<td><span class="fa fa-remove btn btn-default weight-remove"></span></td>';
    option += '</tr>';

    $('.growth-chart-gestation tbody').append(option);

    $('.datepicker').datepicker({
        dateFormat: 'dd-mm-yy',
        yearRange: "-60:+02",
        changeMonth: true,
        changeYear: true,

    });

});


$('.samecontacts').click(function () {
    if ($('.samecontacts').is(':checked')) {

        $('#PartnerContact').val($('#Mobile').val());
        $('#PartnerMobile').val($('#LandLine').val());
        $('#Email').val($('#MotherEmail').val());
        $('#FatherSpokenLanguages').val($('#MotherSpokenLanguages').val());

    } else {

        $('#PartnerContact').val('');
        $('#PartnerMobile').val('');
        $('#Email').val('');
        $('#FatherSpokenLanguages').val('');

    }
});


$('.sameasmailaddress').click(function () {

    if ($('.sameasmailaddress').is(':checked')) {
        $('#FatherAddress1').val($('#Address1').val());
        $('#FatherAddress2').val($('#Address2').val());
        $('#City').val($('#Address3').val());
        $('#Postcode').val($('#Address4').val());
        $('#Country').val($('#Address5').val());
    } else {
        //Clear on uncheck
        $('#FatherAddress1').val("");
        $('#City').val("");
        $('#FatherAddress2').val("");
        $('#Country').val("");
        $('#Postcode').val("");
    }

});
$('.sameascurrentaddress').click(function () {

    if ($('.sameascurrentaddress').is(':checked')) {
        $('#Address1').val($('#City').val());
        $('#Address2').val($('#State').val());
        $('#Address3').val($('#Country').val());
        $('#Address4').val($('#Postcode').val());
    } else {
        //Clear on uncheck
        $('#Address1').val("");
        $('#Address2').val("");
        $('#Address3').val("");
        $('#Address4').val("");
    }

});


$("#op-form").validate({
    rules: {
        BMrNo: {
            // required: true,
        },
        OpDate: {
            required: true,
        },
        BabyName: {
            required: true
        },
        DOB: {
            required: true
        },
        g_weeks: {
            digits: true,
            // min:23,
            max: 43
        },
        g_days: {
            digits: true,
            min: 0,
            max: 6
        },
        BirthWeight: {
            digits: true,
            minlength: 3,
            maxlength: 4
        },
        HeadCircumference: {
            digitstwodecimalone: true,
            min: 0,
            max: 99
        },
        chronological_year: {
            digits: true,
            min: 0,
            max: 16

        },
        chronological_month: {
            digits: true,
            min: 0,
            max: 12

        },
        chronological_days: {
            digits: true,
            min: 0,
            max: 30
        },
        corrected_year: {
            digits: true,
            min: 0,
            max: 16

        },
        corrected_month: {
            digits: true,
            min: 0,
            max: 12

        },
        corrected_days: {
            digits: true,
            min: 0,
            max: 30
        },
        total_chronological_weeks: {
            digits: true,
            min: 0,
            max: 999
        },
        total_chronological_days: {
            digits: true,
            min: 0,
            max: 6
        },
        total_corrected_weeks: {
            digits: true,
            min: 0,
            max: 999,
            // required: true
        },
        total_corrected_days: {
            digits: true,
            min: 0,
            max: 6,
            // required: true
        },
        CurrentWt: {
            digits: true,
            minlength: 3,
            maxlength: 5,
            // required: true
        },
        CurrentOFC: {
            digitstwodecimalone: true,
            min: 0,
            max: 150,
            // required: true

        },
        CurrentLength: {
            digitstwodecimalone: true,
            min: 0,
            max: 150,
            // required: true

        },
        fee_amount: {
            digits: true,
            min: 0,
            max: 1500
        },
        MMrNo: {
            mrnumber: true,
        },
        MotherInitial: {
            maxlength: 5,
            characteronly: true
        },
        MotherName: {
            required: true,
            characteronly: true
        },
        MotherLastName: {
            characteronly: true
        },
        MothercYear: {
            digits: true,
            maxlength: 2,
            minlength: 2
        },
        Occupation: {
            characteronly: true
        },
        Mobile: {
            digits: true,
            maxlength: 11,
            minlength: 10
        },
        LandLine: {
            digits: true,
            maxlength: 11,
            minlength: 10
        },
        MotherEmail: {
            email: true
        },
        MotherSpokenLanguages: {
            charactercomma: true
        },
        Address4: {
            digits: true,
            maxlength: 6,
            minlength: 6
        },
        Address5: {
            characteronly: true
        },
        PartnerInitial: {
            maxlength: 5,
            characteronly: true

        },
        PartnerName: {
            characteronly: true
        },
        PartnerLastName: {
            characteronly: true
        },
        PartnerOccupation: {
            characteronly: true
        },
        PartnerContact: {
            digits: true,
            maxlength: 11,
            minlength: 10
        },
        PartnerMobile: {
            digits: true,
            maxlength: 11,
            minlength: 10
        },
        Email: {
            email: true
        },
        FatherSpokenLanguages: {
            charactercomma: true
        },
        Postcode: {
            digits: true,
            maxlength: 6,
            minlength: 6
        },
        Country: {
            characteronly: true
        },
        SeenBy: {
            required: true,
        },
        hospital_name: "required",


    },
    messages: {
        OpDate: {
            required: "Op Date is mandatory.",
        },
        g_weeks: {
            digits: 'Weeks must be in digits.',
            // min:'Weeks must be greater than or equalto 23.',
            // max:'Weeks must be less than or equalto 43.'
        },
        g_days: {
            digits: 'Days must be in digits.',
            min: 'Days must be greater than or equalto 0.',
            max: 'Days must be less than or equalto 6.'
        },
        BirthWeight: {
            digits: 'Birth Weight must be digits.',
            minlength: 'Birth Weight can be greater than or equalto 3 digits.',
            maxlength: 'Birth Weight can be less than or equalto 4 digits.'
        },
        HeadCircumference: {
            digitstwodecimalone: 'Birth Head Circumference can be 2 digits and 1 decimal places.',
            min: 'Birth Head Circumference must be greater than or equalto 0.',
            max: 'Birth Head Circumference must be less than or equalto 99.'
        },
        chronological_year: {
            digits: 'Year must be in digits.',
            min: 'Year must be greater than or equalto 0.',
            max: 'Year must be less than or equalto 16.'

        },
        chronological_month: {
            digits: 'Month must be in digits.',
            min: 'Month must be greater than or equalto 0.',
            max: 'Month must be less than or equalto 12.'

        },
        chronological_days: {
            digits: 'Days must be digits.',
            min: 'Days must be greater than or equalto 0.',
            max: 'Days must be less than or equalto 30.'
        },
        corrected_year: {
            digits: 'Year must be in digits.',
            min: 'Year must be greater than or equalto 0.',
            max: 'Year must be less than or equalto 16.'

        },
        corrected_month: {
            digits: 'Month must be in digits.',
            min: 'Month must be greater than or equalto 0.',
            max: 'Month must be less than or equalto 12.'

        },
        corrected_days: {
            digits: 'Days must be digits.',
            min: 'Days must be greater than or equalto 0.',
            max: 'Days must be less than or equalto 30.'
        },
        total_chronological_weeks: {
            digits: 'Weeks must be digits.',
            min: 'Weeks must be greater than or equalto 0.',
            max: 'Weeks must be less than or equalto 999.'
        },
        total_chronological_days: {
            digits: 'Days must be digits.',
            min: 'Days must be greater than or equalto 0.',
            max: 'Days must be less than or equalto 6.'
        },
        total_corrected_weeks: {
            digits: 'Weeks must be digits.',
            min: 'Weeks must be greater than or equalto 0.',
            max: 'Weeks must be less than or equalto 999.'
        },
        total_corrected_days: {
            digits: 'Days must be digits.',
            min: 'Days must be greater than or equalto 0.',
            max: 'Days must be less than or equalto 6.'
        },
        CurrentWt: {
            digits: 'Current Weight must be digits.',
            minlength: 'Current Weight must be greater than or equalto 3 digits.',
            maxlength: 'Current Weight must be less than or equalto 5 digits.',
        },
        CurrentOFC: {
            digitstwodecimalone: 'Current OFC can be 3 digits and 1 decimal places.',
            min: 'Current OFC must be greater than or equalto 0.',
            max: 'Current OFC must be less than or equalto 150.'
        },
        CurrentLength: {
            digitstwodecimalone: 'Current Length can be 3 digits and 1 decimal places.',
            min: 'Current Length must be greater than or equalto 0.',
            max: 'Current Length must be less than or equalto 150.'
        },
        fee_amount: {
            digits: 'Fee Amount must be digits.',
            min: 'Fee Amount must be greater than or equalto 0.',
            max: 'Fee Amount must be less than or equalto 1500.'
        },

        MMrNo: {
            mrnumber: 'Enter only alpha numeric and special character "/" '
        },
        MotherInitial: {
            maxlength: 'Enter upto 5 characters !'
        },
        MotherName: {
            characteronly: 'Enter only alphabets !'
        },
        MotherLastName: {
            characteronly: 'Enter only alphabets !'
        },
        MothercYear: {
            digits: 'Enter only digits !',
            maxlength: 'Enter only 2 digits !',
            minlength: 'Enter only 2 digits !'
        },
        Occupation: {
            characteronly: 'Enter only alphabets !'
        },
        Mobile: {
            digits: 'Enter digits only !',
            maxlength: 'Enter maximum 11 digits only !',
            minlength: 'Enter minimum 10 digits only !'
        },
        LandLine: {
            digits: 'Enter digits only !',
            maxlength: 'Enter maximum 11 digits only !',
            minlength: 'Enter minimum 10 digits only !'
        },
        MotherEmail: {
            email: 'Enter valid email !'
        },
        MotherSpokenLanguages: {
            charactercomma: 'Enter only alphabets and special characters ","'
        },
        Address4: {
            digits: 'Enter digits only !',
            maxlength: 'Enter only 6 digits !',
            minlength: 'Enter only 6 digits !'
        },
        Address5: {
            characteronly: 'Enter only alphabets !'
        },
        PartnerInitial: {
            maxlength: 'Enter only 5 characters !'
        },
        PartnerName: {
            characteronly: 'Enter only alphabets !'
        },
        PartnerLastName: {
            characteronly: 'Enter only alphabets !'
        },
        PartnerOccupation: {
            characteronly: 'Enter only alphabets !'
        },
        PartnerContact: {
            digits: 'Enter digits only !',
            maxlength: 'Enter maximum 11 digits only !',
            minlength: 'Enter minimum 10 digits only !'
        },
        PartnerMobile: {
            digits: 'Enter digits only !',
            maxlength: 'Enter maximum 11 digits only !',
            minlength: 'Enter minimum 10 digits only !'
        },
        Email: {
            email: 'Enter valid email !'
        },
        FatherSpokenLanguages: {
            charactercomma: 'Enter only alphabets and special characters ","'
        },
        Postcode: {
            digits: 'Enter digits only !',
            maxlength: 'Enter only 6 digits !',
            minlength: 'Enter only 6 digits !'
        },
        Country: {
            characteronly: 'Enter only alphabets !'
        },
        SeenBy: {
            required: "Select Doctor...",
        },

    },

    showErrors: function (errorMap, errorList) {

        this.defaultShowErrors();
        if (typeof errorList[0] != "undefined") {
            var errorDiv = $('.error:visible').first();
            var position = errorDiv.offset().top;
            // var position = $(errorList[0].element).position().top;
            $('html, body').animate({
                scrollTop: position
            }, 300);
        }
    }

});


// function setSpeechcontrol(Id) {

//     var id     = Id;

//     var playid = id+'_play';

//     var stopid = id+'_stop';

//     var icons  = '<i class="fa fa-play-circle fa-lg speech-record-play" id="'+playid+'"  aria-hidden="true"></i>';

//         icons += '<i class="fa fa-stop fa-lg speech-record-stop" id="'+stopid+'" aria-hidden="true"></i>';

//         $('#'+id).after(icons);

//         $(document).on('click', '#'+playid, function() {

//           $('#'+id).addClass('recordEnable');

//           Fr.voice.record(false, function() {
//              Showalert('success','Recording Started');
//           });

//         });

//         $(document).on('click', '#'+stopid, function() {

//            Fr.voice.export(upload, "blob");
//            Fr.voice.stop();
//            Showalert('success','Recording Stoped Please Wait For few second !');


//         });

// }


function setSpeechcontrol(Id) {

    var id = Id;

    var playid = id + '_play';

    var stopid = id + '_stop';

    var icons = '<i class="fa fa-play-circle fa-lg speech-record-play" id="' + playid + '"  aria-hidden="true"></i>';

    icons += '<i class="fa fa-stop fa-lg speech-record-stop" id="' + stopid + '" aria-hidden="true"></i>';

    $('#' + id).after(icons);


    window.URL = window.URL || window.webkitURL;
    /** 
     * Detecte the correct AudioContext for the browser 
     * */
    window.AudioContext = window.AudioContext || window.webkitAudioContext;
    navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;

    let context;
    let startBtn = '#' + playid;
    let stopBtn = '#' + stopid;
    let tracks;
    var recorder = new RecordVoiceAudios();

    startBtn.onclick = recorder.startRecord;
    stopBtn.onclick = recorder.stopRecord;

    function RecordVoiceAudios() {

        let audioElement = document.querySelector('audio');
        let encoder = null;
        let microphone;
        let isRecording = false;
        var audioContext;
        let processor;
        let config = {
            bufferLen: 4096,
            numChannels: 2,
            mimeType: 'audio/mpeg'
        };

        this.startRecord = function () {
            audioContext = new AudioContext();
            /** 
             * Create a ScriptProcessorNode with a bufferSize of 
             * 4096 and two input and output channel 
             * */
            if (audioContext.createJavaScriptNode) {
                processor = audioContext.createJavaScriptNode(config.bufferLen, config.numChannels, config.numChannels);
            } else if (audioContext.createScriptProcessor) {
                processor = audioContext.createScriptProcessor(config.bufferLen, config.numChannels, config.numChannels);
            } else {
                console.log('WebAudio API has no support on this browser.');
            }

            processor.connect(audioContext.destination);
            /**
             *  ask permission of the user for use microphone or camera  
             * */
            navigator.mediaDevices.getUserMedia({
                    audio: true,
                    video: false
                })
                .then(gotStreamMethod)
                .catch(logError);
        };

        let getBuffers = (event) => {
            var buffers = [];
            for (var ch = 0; ch < 2; ++ch)
                buffers[ch] = event.inputBuffer.getChannelData(ch);
            return buffers;
        }

        let gotStreamMethod = (stream) => {
            startBtn.setAttribute('disabled', true);
            stopBtn.removeAttribute('disabled');
            audioElement.src = "";
            config = {
                bufferLen: 4096,
                numChannels: 2,
                mimeType: 'audio/mpeg'
            };
            isRecording = true;

            let tracks = stream.getTracks();
            /** 
             * Create a MediaStreamAudioSourceNode for the microphone 
             * */
            microphone = audioContext.createMediaStreamSource(stream);
            /** 
             * connect the AudioBufferSourceNode to the gainNode 
             * */
            microphone.connect(processor);
            encoder = new Mp3LameEncoder(audioContext.sampleRate, 160);
            /** 
             * Give the node a function to process audio events 
             */
            processor.onaudioprocess = function (event) {
                encoder.encode(getBuffers(event));
            };

            stopBtnRecord = () => {
                console.log('stopBtnRecord');
                isRecording = false;
                startBtn.removeAttribute('disabled');
                stopBtn.setAttribute('disabled', true);
                audioContext.close();
                processor.disconnect();
                tracks.forEach(track => track.stop());
                //  recorder.exportWAV(function(s) {
                //    audio.src = window.URL.createObjectURL(s);
                // });
                audioElement.src = URL.createObjectURL(encoder.finish());
            };

        }

        this.stopRecord = function () {
            stopBtnRecord();
        };


        let logError = (error) => {
            alert(error);
            console.log(error);
        }


    }

}
function getFormatedStringFromDays(numberOfDays) {
    var years = Math.floor(numberOfDays / 365);
    var months = Math.floor(numberOfDays % 365 / 30);
    var days = Math.floor(numberOfDays % 365 % 30);

    var yearsDisplay = years > 0 ? years + (years == 1 ? "" : "") : "";
    var monthsDisplay = months > 0 ? months + (months == 1 ? "" : "") : "";
    var daysDisplay = days > 0 ? days + (days == 1 ? "" : "") : "";
    var formatted_values = [yearsDisplay, monthsDisplay, daysDisplay];
    return formatted_values; 
}
// $(document).on('click', '.op_save_btn', function(e)
// {
//     e.preventDefault();
//     if ($('#op-form').valid() === true) {
//       var print_flag = $(this).data('flag');
//       $('#print_flag').val(print_flag);
//       $('.op_save_btn').prop('disabled', 'true');
//       $(this).html('<i class="fas fa-spinner fa-pulse"></i> Loading...');
//       $('#op-form').submit();
//     }
    
// });

function changeFieldsWithBabyAge(baby_age)
{
    if (baby_age == '') {
        $('.report-left').addClass('half-width');
        $('.report-right').addClass('display-none');

        $('.month_wise_report, .year_wise_report').hide();
        $('#baby-month-span').text('');
    }
    else if (baby_age == '18m') {

        $('.report-left').removeClass('half-width');
        $('.report-right').removeClass('display-none');

        $('.month_wise_report').slideDown();
        $('.year_wise_report').slideUp();
        $('.only_for_18m').slideDown();
        $('#baby-month-span').text('18 MONTHS');
        // $('.term-corrected-tabs').hide();

    }
    else if(/m/.test(baby_age) && (baby_age.length == 2 || baby_age.length == 3))
    {
        $('.report-left').removeClass('half-width');
        $('.report-right').removeClass('display-none');

        $('.month_wise_report').slideDown();
        $('.year_wise_report').slideUp();
        $('.only_for_18m').slideUp();
        var baby_age_formatted = baby_age.replace('m', '');
        $('#baby-month-span').text(baby_age_formatted+' MONTHS');
        // $('.term-corrected-tabs').hide();
    }
    else if(/y/.test(baby_age))
    {
        $('.report-left').removeClass('half-width');
        $('.report-right').removeClass('display-none');

        $('.month_wise_report').slideUp();
        $('.year_wise_report').slideDown();
        $('.only_for_18m').slideUp();
        var baby_age_formatted = baby_age.replace('y', '');
        $('#baby-month-span').text(baby_age_formatted+' YEARS');
        // $('.term-corrected-tabs').hide();
    }
    else if(baby_age == 'term_corrected')
    {
        $('.report-left').removeClass('half-width');
        $('.report-right').removeClass('display-none');

        $('.month_wise_report').slideDown();
        $('.year_wise_report').slideUp();
        $('.only_for_18m').slideUp();
        $('#baby-month-span').text('TERM CORRECTED');
        // $('.term-corrected-tabs').show();

    }
}
function checkAbnormalMovements()
{
    if($("#is_abnormal_movements").prop('checked'))
    {
        $('#abnormal_movements_info').parent().parent().slideDown();
        $('.abnormal_movements').slideDown();
    }
    else
    {
        $('.abnormal_movements').slideUp();
        $('#abnormal_movements_info').parent().parent().slideUp();
    }
}

function checkNormalMovements()
{
    if($("#is_normal_movements").prop('checked'))
    {
        // console.log(this);
        $('.normal_movements').slideUp();
    }
    else
    {
        // console.log('this');
        $('.normal_movements').slideDown();
    }
}


function isInt(value) {
  return !isNaN(value) && 
         parseInt(Number(value)) == value && 
         !isNaN(parseInt(value, 10));
}
$(document).on('click', '.full-tab-view', function(e)
{
    $('.nav.nav-tabs').hide();
    $('.tab-pane').removeClass('active');
    $('#neuroform').addClass('active');
    $('#'+$(this).data('tab_name')).addClass('active');

});
$(document).on('click', '.back_to_screening', function(e)
{
    $('.nav.nav-tabs').show();
    $('#neuroform .tab-pane').removeClass('active');
    $('#neuroform #screeningform').addClass('active');

});
$(document).on('click', '.standard_dose_remove', function() {
    var standard_dose_class = $(this).parents('tr').attr('class');
    // var removed_ids = $('input[name="removed_medication_ids"]').val();
        // removed_ids = removed_ids != '' && typeof removed_ids != 'undefined' ? JSON.parse(removed_ids) : [];
    // var ids = removed_ids;
    // $('.'+standard_dose_class).each(function(){
    //     ids.push($(this).attr('data-id'));
    // });
    // var ids = JSON.stringify(ids);
    // $('input[name="removed_medication_ids"]').val(ids);
    $('.'+standard_dose_class).remove();
});

$(document).on('click', '.medication_remove', function() {
    var standard_dose_class = $(this).parents('tr').attr('data-id');
    // var removed_ids = $('input[name="removed_medication_ids"]').val();
        // removed_ids = removed_ids != '' && typeof removed_ids != 'undefined' ? JSON.parse(removed_ids) : [];
    // var ids = removed_ids;
        // ids.push(standard_dose_class);
    // var ids = JSON.stringify(ids);
    // $('input[name="removed_medication_ids"]').val(ids);

    $(this).parents('tr').remove();
});




    $('#eligibility input[type="checkbox"]').on('click', function() {
        if ($(this).prop('checked') == true) {
            $(this).parents('tr').addClass('bg-warning');
        } else {
            $(this).parents('tr').removeClass('bg-warning');            
        }
    });
