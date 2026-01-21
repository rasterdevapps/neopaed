/*
    This script will load at the time of neonatal performa  sheet only 
    */
function facialOxygenchange() {
    if ($('#FacialOxygen').prop('checked') == false) {
        $('#DurationOfOxygen').attr('readonly', true).val('').parent().parent().slideUp();
        $('#maximum_fio2_required').attr('readonly', true).val('').parent().parent().slideUp();
    } else {
        $('#DurationOfOxygen').removeAttr('readonly', true).parent().parent().slideDown();
        $('#maximum_fio2_required').removeAttr('readonly', true).parent().parent().slideDown();
    }
}

function Calculate(id) {
    var col1 = Number($("#Colour" + id).val());
    var hr1 = Number($("#HR" + id).val());
    var ref1 = Number($("#Reflex" + id).val());
    var tone1 = Number($("#Tone" + id).val());
    var res1 = Number($("#Respiration" + id).val());
    var value1 = col1 + hr1 + ref1 + tone1 + res1;
    $(".Apgars" + id + "min").val(value1);
    if (value1 != 0) {
        $(".Apgars" + id + "min").attr('readonly', true);
    } else {
        $(".Apgars" + id + "min").attr('readonly', false);
    }
}

function drugsChanges() {
    if ($('#Drugs').prop('checked') == false) {
        $(".drug-main,.resustation_drug_add").slideUp();
    } else {
        $(".drug-main,.resustation_drug_add").slideDown();
    }
}

function AntenatalsteroidsChanges() {
    var idList = ['LastDoseDeliveryInterval', 'SteroidCourse','typeofsteroids'];
    ($('#AntenatalSteroids').prop('checked') == false) ? makeDisable(idList): removeDisable(idList);
}
function MaternalPyrexiaChanges() {
    // var idList = ['maternal_pyrexia_celsius', 'maternal_pyrexia_fahrenheit'];
    // ($('#MaternalPyrexia').prop('checked') == false) ? makeDisable(idList): removeDisable(idList);
    if ($('#MaternalPyrexia').prop('checked') == false) {
        $('label[for="maternal_pyrexia_temp"]').parent().parent().hide();
    } else {
        $('label[for="maternal_pyrexia_temp"]').parent().parent().show();
    }
}

function LabourChanges() {
    var idList = ['NatureofLabour'];
    ($('#Labour').prop('checked') == false) ? makeDisable(idList): removeDisable(idList);
    // if ($('#Labour').prop('checked') == false) {
    //     $('#Syntocinon').val('Not known');
        $('label[for="Syntocinon"]').parent().parent().hide();
    // } else {
    //     $('label[for="Syntocinon"]').parent().parent().show();
    // }
}

function cordBloodgas() {
    var idList = ['CordpH', 'CordHCO3', 'CordBE'];
    ($('#CordBloodGas').val() == 'Not done' || $('#CordBloodGas').val() == 'Not indicated') ? makeDisable(idList): removeDisable(idList);
}

function maternal_antibiotics() {
    var idList = ['TimeofLastDose'];
    if ($('#Maternal_antibiotics_status').val() == 'No' || $('#Maternal_antibiotics_status').val() == 'Not known') {
        $('.Maternal_antibiotics_status,.MaternalAntibiotics_add').attr('disabled', true).slideUp();
        makeDisable(idList);
    } else {
        $('.Maternal_antibiotics_status ,.MaternalAntibiotics_add').removeAttr('disabled').slideDown();
        removeDisable(idList);
    }
}

function preganacyComplications() {
    if ($('#PregnancyComplications').prop('checked') == false) {
        $('select[name="Complication[]"]').each(function() {
            // $(this).val('').trigger('change');
        });
        $('.complication-disable').attr('disabled', true);
        $('.complication-disable').hide();
    } else {
        $('.complication-disable').removeAttr('disabled');
        $('.complication-disable').show();
    }
}

function conceptionField() {
    var idList = ['TypeofART', 'EmbryoTransfer', 'PlaceofART'];
    ($("#Conception").val() == 'Spontaneous' || $("#Conception").val() == 'Not Known' || $("#Conception").val() == '') ? makeDisable(idList): removeDisable(idList);
}

function bookedField() {
    var idList = ['Booking'];
    ($("#Booked").prop('checked') == true) ? removeDisable(idList): makeDisable(idList);
}

function supervisedField() {
    var idList = ['PlaceofSupervision'];
    ($("#Supervised").prop('checked') == true) ? removeDisable(idList): makeDisable(idList);
}

function VitaminKChange() {
    var idList = ['DoseVitK', 'RouteVitK'];
    ($("#VitaminK").val() == 'Yes') ? removeDisable(idList): makeDisable(idList);
}

function delayed_cord_clamping() {
    var idList = ['duration_dcc'];
    var idListalter = ['reason_dcc'];
    ($("#delayed_cord_clamping").val() == 'No' || $("#delayed_cord_clamping").val() == 'Unknown') ? makeDisable(idList): removeDisable(idList);
    ($("#delayed_cord_clamping").val() == 'No') ? removeDisable(idListalter): makeDisable(idListalter);
}

function Prom() {
    var idList = ['DurationOfROM'];
    ($("#PROM").prop('checked') == false) ? makeDisable(idList): removeDisable(idList);
}

function Vaccine_status() {
    if ($('#Vaccine_status').val() == 'Not given') {
        $('.Vaccine_status').slideUp();
    } else {
        $('.Vaccine_status').slideDown();
    }
}

function timeofGaspstatus() {
    var idList = ['TimeOf1stGasp'];
    ($("#timeofgasp_status").prop('checked') == false) ? makeDisable(idList): removeDisable(idList);
}

function regularRespirationstatus() {
    var idList = ['RegularRespiration'];
    ($("#regularrespiration_status").prop('checked') == false) ? makeDisable(idList): removeDisable(idList);
}

function trisomiesRisk() {
    var idList = ['AdjustedRiskForTrisomy21', 'AdjustedRiskForTrisomy18', 'AdjustedRiskForTrisomy13'];
    ($("#adjustedtrisomies").prop('checked') == false) ? makeDisable(idList): removeDisable(idList);
}

function ctgDetails() {
    var idList = ['CTGDetails'];
    ($("#CTG").val() == 'Not Known' || $("#CTG").val() == 'Normal') ? makeDisable(idList): removeDisable(idList);
}

function malFormation() {
    var idList = ['MalformationType'];
    ($("#Malformation").val() == "No") ? makeDisable(idList): removeDisable(idList);
}

function echoStatus() {
    var idList = ['wb_echo_report'];
    ($('#wb_echo_status').val() === 'Yes') ? removeDisable(idList): makeDisable(idList);
}

function depthInsertion() {
    var idList = ['DepthOfInsertion'];
    $('#insertion_status').prop('checked') == false ? makeDisable(idList) : removeDisable(idList);
}
Vaccine_status();
Prom();
delayed_cord_clamping();
supervisedField();
bookedField();
conceptionField();
preganacyComplications();
maternal_antibiotics();
facialOxygenchange();
cordBloodgas();
AntenatalsteroidsChanges();
LabourChanges();
trisomiesRisk();
ctgDetails();
malFormation();
echoStatus();
drugsChanges();
VitaminKChange();
natureoflabour();
riskfactors();

$('#wb_echo_status').change(function() {
    echoStatus();
});

$('#VitaminK').change(function() {
    VitaminKChange();
});
$("#Malformation").on('change', function() {
    malFormation();
});
$('#timeofgasp_status').on('change', function() {
    timeofGaspstatus();
});
$('#regularrespiration_status').on('change', function() {
    regularRespirationstatus();
});
$('#adjustedtrisomies').on('change', function() {
    trisomiesRisk();
});
$('#PROM').on('change', function() {
    Prom();
});
$('#Vaccine_status').on('change', function() {
    Vaccine_status();
});
$('#delayed_cord_clamping').on('change', function() {
    delayed_cord_clamping();
});
$('#Booked').on('change', function() {
    bookedField();
});
$('#Supervised').on('change', function() {
    supervisedField();
});
$('#Conception').on('change', function() {
    conceptionField();
});
$('#PregnancyComplications').change(function() {
    preganacyComplications();
});
$('#FacialOxygen').change(function() {
    facialOxygenchange();
});
$('#Maternal_antibiotics_status').change(function() {
    maternal_antibiotics();
});
$('#CordBloodGas').change(function() {
    cordBloodgas();
});
$('#AntenatalSteroids').change(function() {
    AntenatalsteroidsChanges();
});
$('#Labour').change(function() {
    LabourChanges();
});
$('#CTG').on('change', function() {
    ctgDetails();
});
$('#Drugs').change(function() {
    drugsChanges();
});
$('#MaternalPyrexia').change(function() {
    MaternalPyrexiaChanges();
});

function natureoflabour() {
    var idList = ['Syntocinon'];
    if ($('#NatureofLabour').val() != 'Induced') {
        makeDisable(idList);
    } else {
        removeDisable(idList);
    }
}
$('#NatureofLabour').change(function() {
    natureoflabour();
});

function riskfactors() {
    if ($('#sepsis_in_mother').val() != 'Yes') {
        $('input[name^="sepsis_in_mother_type"]').parents('.form-group.row').slideUp();
    } else {
        $('input[name^="sepsis_in_mother_type"]').parents('.form-group.row').slideDown();
    }
}
$('#sepsis_in_mother').change(function() {
    riskfactors();
});


$(".add-scalp").on('click', function() {
    var optionValues = $('select[name="tempscalp"]').html();
    var option = '<tr>';
    option += '<td class="full-width"><select class="form-control" name="Scalp[]">';
    option += optionValues;
    option += '</select> </td>';
    option += '<td><span class="fa fa-trash btn btn-danger btn-view remove-scalp"></span></td> </tr>';
    $('.scalp-content tbody').append(option);
});
$('#AdjustedRiskForTrisomy21').selectwithfreetext({
    mainclass: 'select-free1',
    list: ['Not Done', 'Not Indicated', 'Others']
});
$('#AdjustedRiskForTrisomy18').selectwithfreetext({
    mainclass: 'select-free2',
    list: ['Not Done', 'Not Indicated', 'Others']
});
$('#AdjustedRiskForTrisomy13').selectwithfreetext({
    mainclass: 'select-free3',
    list: ['Not Done', 'Not Indicated', 'Others']
});
$('#PlaceofART').selectwithfreetext({
    mainclass: 'select-free4',
    list: ['Not known']
});
$('.add-drug').click(function() {
    var medicinevalues = $('select[name="temp_medicine"]').html();
    var doesvalues = $('select[name="temp_does"]').html();
    var frequencyvalues = $('select[name="temp_frequency"]').html();
    var durationvalues = $('select[name="temp_duration"]').html();
    var ids = $('select[name="brand_name[]"]').length;
    option = '<tr>';
    option += '<td class="p-5"><select class="form-control drugs-changes" data-id="' + ids + '" name="brand_name[]">' + medicinevalues + '</select></td>';
    option += '<td class="p-5"><input class="form-control" id="generic_name' + ids + '" name="generic_name[]" type="text"></td>';
    option += '<td class="p-5"><select class="form-control" id="formulation' + ids + '"  name="formulation[]"><option value="">N/A</option></select></td>';
    option += '<td class="p-5"><select class="form-control" name="dose[]">' + doesvalues + '</select></td>';
    option += '<td class="p-5"><select class="form-control" name="frequency[]">' + frequencyvalues + '<select></td>';
    option += '<td class="p-5"><select class="form-control" name="duration[]">' + durationvalues + '</select></td>';
    option += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>';
    option += '</tr>';
    $('.discharge-medication').append(option);
});
$(document).on('click', '.remove-scalp', function() {
    $(this).parent().parent().remove();
});
$('.resustation_drug_add').click(function() {
    var optionValue = $('select[name="temp_resusciatation_drugs"]').html();
    var option = '<tr>';
    option += '<td><select class="form-control input-width-xlarge" name="resusciatation_drugs[]">' + optionValue + '</select></td>';
    option += '<td><span class="fa fa-trash btn btn-danger btn-view remove-drug"></span></td>';
    option += '</tr>';
    $('.drugs tbody').append(option);
});
$(document).on('click', ".remove-drug", function() {
    $(this).parent('td').parent('tr').remove();
});
$('#MotherDOB').change(function() {
    var today = new Date(),
        birthday = $('#MotherDOB').datepicker("getDate"),
        age = (
            (today.getMonth() > birthday.getMonth()) ||
            (today.getMonth() == birthday.getMonth() && today.getDate() >= birthday.getDate())
        ) ? today.getFullYear() - birthday.getFullYear() : today.getFullYear() - birthday.getFullYear() - 1;
    $('#MothercYear').val(age);
});
$('#PartnerDOB').change(function() {
    var today = new Date(),
        birthday1 = $('#PartnerDOB').datepicker("getDate"),
        age1 = (
            (today.getMonth() > birthday1.getMonth()) ||
            (today.getMonth() == birthday1.getMonth() && today.getDate() >= birthday1.getDate())
        ) ? today.getFullYear() - birthday1.getFullYear() : today.getFullYear() - birthday1.getFullYear() - 1;
    $('#PartnercYear').val(age1);
});
jQuery('#BirthWeight').keyup(function() {
    this.value = this.value.replace(/[^0-9]/g, '');
    $("#birth_weight").empty();
    var birth_weight = $('#BirthWeight').val() / 1000;
    $('#birth_weight').val(birth_weight);
});
jQuery('#DischargeWeight').keyup(function() {
    this.value = this.value.replace(/[^0-9]/g, '');
    $("#discharge_weight").empty();
    var discharge_weight = $('#DischargeWeight').val() / 1000;
    $('#discharge_weight').val(discharge_weight);
});
jQuery('#Gestation').keyup(function() {
    this.value = this.value.replace(/[^0-9]/g, '');
});
jQuery('#gestations').keyup(function() {
    this.value = this.value.replace(/[^0-9]/g, '');
});
jQuery('#OFC').keyup(function() {
    this.value = this.value.replace(/[^0-9. ]/g, '');
});
jQuery('#Length').keyup(function() {
    this.value = this.value.replace(/[^0-9. ]/g, '');
});
jQuery('#OH_YEAR').keyup(function() {
    this.value = this.value.replace(/[^0-9. ]/g, '');
});
// jQuery('input[name="duration_in_weeks[]"]').keyup(function() {
//     this.value = this.value.replace(/[^0-9. ]/g, '');
// });
$(document).on('keyup', 'input[name="duration_in_weeks[]"]', function()
{
    this.value = this.value.replace(/[^0-9.]/g, '');
});
jQuery('.total1min').keyup(function() {
    this.value = this.value.replace(/[^0-9]/g, '');
    $("#Apgars1min").empty();
    var Apgars1min = $('.total1min').val();
    $('#Apgars1min').val(Apgars1min);
});
jQuery('.total5min').keyup(function() {
    this.value = this.value.replace(/[^0-9]/g, '');
    $("#Apgars5min").empty();
    var Apgars5min = $('.total5min').val();
    $('#Apgars5min').val(Apgars5min);
});
jQuery('.total10min').keyup(function() {
    this.value = this.value.replace(/[^0-9]/g, '');
    $("#Apgars10min").empty();
    var Apgars10min = $('.total10min').val();
    $('#Apgars10min').val(Apgars10min);
});
jQuery('.total20min').keyup(function() {
    this.value = this.value.replace(/[^0-9]/g, '');
    $("#Apgars20min").empty();
    var Apgars20min = $('.total20min').val();
    $('#Apgars20min').val(Apgars20min);
});
jQuery('#Seizures').on('change', function() {
    if ($("#Seizures").val() == 'No') {
        $("#TypeofSeizureDiv").css("display", "none");
    } else {
        $("#TypeofSeizureDiv").css("display", "block");
    }
});

function ResetData(id) {
    bootbox.confirm("Do you want to erase all values for this column?", function(confirmed) {
        if (confirmed) {
            if (id == '1min_reset') {
                $('#Colour1').val('0');
                $('#HR1').val('0');
                $('#Reflex1').val('0');
                $('#Tone1').val('0');
                $('#Respiration1').val('0');
                $('.Apgars1min').val('0');
                $(".total1min").attr('readonly', false);
            }
            if (id == '5min_reset') {
                $('#Colour5').val('0');
                $('#HR5').val('0');
                $('#Reflex5').val('0');
                $('#Tone5').val('0');
                $('#Respiration5').val('0');
                $('.Apgars5min').val('0');
                $(".total5min").attr('readonly', false);
            }
            if (id == '10min_reset') {
                $('#Colour10').val('0');
                $('#HR10').val('0');
                $('#Reflex10').val('0');
                $('#Tone10').val('0');
                $('#Respiration10').val('0');
                $('.Apgars10min').val('0');
                $(".total10min").attr('readonly', false);
            }
            if (id == '15min_reset') {
                $('#Colour15').val('0');
                $('#HR15').val('0');
                $('#Reflex15').val('0');
                $('#Tone15').val('0');
                $('#Respiration15').val('0');
                $('.Apgars15min').val('0');
                $(".total15min").attr('readonly', false);
            }
            if (id == '20min_reset') {
                $('#Colour20').val('0');
                $('#HR20').val('0');
                $('#Reflex20').val('0');
                $('#Tone20').val('0');
                $('#Respiration20').val('0');
                $('.Apgars20min').val('0');
                $(".total20min").attr('readonly', false);
            }
        }
    });
}
$('#known_field').change(function() {
    if ($('#known_field').prop('checked') == true) {
        $('.dispaly_apgar').css('display', 'block');
    } else {
        bootbox.confirm("Do you want to erase all values?", function(confirmed) {
            if (confirmed) {
                $('#Colour1').val('0');
                $('#HR1').val('0');
                $('#Reflex1').val('0');
                $('#Tone1').val('0');
                $('#Respiration1').val('0');
                $('.total1min').val('0');
                $(".total1min").attr('readonly', false);
                $('#Colour5').val('0');
                $('#HR5').val('0');
                $('#Reflex5').val('0');
                $('#Tone5').val('0');
                $('#Respiration5').val('0');
                $('.total5min').val('0');
                $(".total5min").attr('readonly', false);
                $('#Colour10').val('0');
                $('#HR10').val('0');
                $('#Reflex10').val('0');
                $('#Tone10').val('0');
                $('#Respiration10').val('0');
                $('.total10min').val('0');
                $(".total10min").attr('readonly', false);
                $('#Colour20').val('0');
                $('#HR20').val('0');
                $('#Reflex20').val('0');
                $('#Tone20').val('0');
                $('#Respiration20').val('0');
                $('.total20min').val('0');
                $(".total20min").attr('readonly', false);

                $('#Colour15').val('0');
                $('#HR15').val('0');
                $('#Reflex15').val('0');
                $('#Tone15').val('0');
                $('#Respiration15').val('0');
                $('.total15min').val('0');
                $(".total15min").attr('readonly', false);
                $('.dispaly_apgar').css('display', 'none');
            } else {
                $('#known_field').bootstrapToggle('on');
            }
        });
    }
});
$('.samecontacts').click(function() {
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
//validation for Neonatal_Performa 
$("#neonatalPerforma-form").validate({
    rules: {
        //Baby Details
        BabyName: {
            characterwithslash: true
        },
        TestDate: {
            required: true
        },
        DOB: {
            required: true
        },
        g_weeks: {
            digits: true,
            max: 43,
            min: 23,
            required: true
        },
        g_days: {
            digits: true,
            max: 6,
            min: 0
        },
        Length: {
            digitstwodecimalone: true
        },
        OFC: {
            digitstwodecimalone: true
        },
        BirthWeight: {
            digits: true,
            maxlength: 4,
            minlength: 3,
            required: true
        },
        transfer_status: {
            required: true
        },
        TEST_TIME: {
            required: true
        },
        TEST_MINS: {
            required: true
        },
        TEST_AM: {
            required: true
        },
        Sex: {
            required: true
        },
        Length: {
            // required: true
        },
        OFC: {
            // required: true
        },
        //parent
        MotherInitial: {
            maxlength: 5,
            characteronly: true
        },
        MotherName: {
            characteronly: true,
            required: true
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
            minlength: 9
        },
        LandLine: {
            digits: true,
            maxlength: 11,
            minlength: 9
        },
        MotherEmail: {
            email: true
        },
        MotherSpokenLanguages: {
            charactercomma: true,
            characteronly: true
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
            maxlength: 5
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
            minlength: 9
        },
        PartnerMobile: {
            digits: true,
            maxlength: 11,
            minlength: 9
        },
        Email: {
            email: true
        },
        FatherSpokenLanguages: {
            charactercomma: true,
            characteronly: true
        },
        Postcode: {
            digits: true,
            maxlength: 6,
            minlength: 6
        },
        Country: {
            characteronly: true
        },
        //Obstetric History
        'Medications[]': {
            charactersformedication: true
        },
        G_Value: {
            digits: true,
            min: 0,
            max: 9
        },
        P_Value: {
            digits: true,
            min: 0,
            max: 9
        },
        L_Value: {
            digits: true,
            min: 0,
            max: 9
        },
        A_Value: {
            digits: true,
            min: 0,
            max: 9
        },
        //Pragnacy Condt
        gestations: {
            digits: true
        },
        //New Born Examination
        'Year[]': {
            digits: true,
            maxlength: 4,
            minlength: 4,
            min: parseInt(new Date().getFullYear() - 100),
            max: new Date().getFullYear()
        },
        'Place[]': {
            // lettersonly: true
        },
        'Complications[]': {
            characteronly: true
        },
        'GA[]': {
            digits: true,
            max: 43,
            min: 0
        },
        'BW[]': {
            digits: true,
            maxlength: 4,
            minlength: 4
        },
        'details[]': {
            characteronly: true
        },
        // Booking: {
        //     characteronly: true,
        //     lettersonly: true
        // },
        // PlaceofSupervision: {
        //     characteronly: true,
        //     lettersonly: true
        // },
        'duration_in_weeks[]': {
            digits: true,
            min: 0,
            max: 43
        },
        datinggestations: {
            gestationweeksdays: true,
        },
        analoggestations: {
            gestationweeksdays: true,
        },
        'othergestations[]': {
            gestationweeksdays: true,
        },
        'dopplergestations[]': {
            gestationweeksdays: true,
        },
        CordpH: {
            digitonedecimaltwo: true,
            min: 6,
            max: 8
        },
        CordHCO3: {
            digitstwodecimalone: true,
            min: 0,
            max: 40
        },
        CordBE: {
            digitstwodecimaloneplus: true,
            min: -50,
            max: 50
        },
        duration_dcc: {
            digits: true,
            min: 0,
            max: 120
        },
        maximum_fio2_required: {
            digits: true,
            min: 0,
            max: 100
        },
        Apgars1min: {
            digits: true,
            min: 0,
            max: 10
        },
        Apgars5min: {
            digits: true,
            min: 0,
            max: 10
        },
        Apgars10min: {
            digits: true,
            min: 0,
            max: 10
        },
        Apgars15min: {
            digits: true,
            min: 0,
            max: 10
        },
        Apgars20min: {
            digits: true,
            min: 0,
            max: 10
        },
        TimeOf1stGasp: {
            digitstwodecimalone: true,
            min: 0,
            max: 40
        },
        RegularRespiration: {
            digitstwodecimalone: true,
            min: 0,
            max: 40
        },
        DurationOfOxygen: {
            digitstwodecimalone: true,
            min: 0,
            max: 40
        },
        DepthOfInsertion: {
            digitstwodecimalone: true,
            min: 5,
            max: 15
        },
        DurationOfPPV: {
            digitstwodecimalone: true,
            min: 0,
            max: 40
        },
        duration_of_cpr: {
            digitstwodecimalone: true,
            min: 0,
            max: 40
        },
        NbHR: {
            threeDigits: true
        },
        NbRR: {
            threeDigits: true
        },
        TemperatureF: {
            decimal_range_two: true,
            max: 120,
            min: 10,
        },
        NbSpO2: {
            digits: true,
            min: 0,
            max: 100
        },
        DischargeWeight: {
            digits: true,
            minlength: 3,
            maxlength: 4
        },
        discharge_length: {
            digitstwodecimalone: true,
            min: 0,
            max: 99
        },
        discharge_ofc: {
            digitstwodecimalone: true,
            min: 0,
            max: 99
        },
        PostductalSaturation: {
            digits: true,
            min: 0,
            max: 100
        },
        room_id: {
            required:$("#transfer_status").val() == "NICU" 
        },
        bed_id: {
            required: $("#transfer_status").val() == "NICU"
        }
    },
    messages: {
        BabyName: {
            characterwithslash: 'Please enter a baby name without special characters.',
        },
        TestDate: {
            required: 'Please select data entry date.'
        },
        g_weeks: {
            digits: 'Please enter weeks in digits.',
            max: 'Please enter  weeks in lessthan or equal 43.',
            min: 'Please enter weeks in greaterthan or equal 23.'
        },
        g_days: {
            digits: 'Please enter gestation days in digits.',
            max: 'Please enter days in lessthan or equal 6.',
            min: 'Please enter days in greaterthan or equal 0.'
        },
        Length: {
            digitstwodecimalone: 'Length can be 2 digits 1 decimal.'
        },
        OFC: {
            digitstwodecimalone: 'Head Circumference can be 2 digits 1 decimal.'
        },
        BirthWeight: {
            digits: 'Enter only digits.',
            maxlength: 'Enter a number lessthan or equal 4 digits.',
            minlength: 'Enter a number greaterthan or equal 4 digits.'
        },
        transfer_status: {
            required: "Select transfer status."
        },
        TEST_TIME: {
            required: "Select  data entry time."
        },
        TEST_MINS: {
            required: "Select  data entry time."
        },
        TEST_AM: {
            required: "Select  data entry time."
        },
        //parent
        MotherInitial: {
            maxlength: 'Enter upto 5 characters.',
            characteronly: 'Enter only alphabets.'
        },
        MotherName: {
            characteronly: 'Enter only alphabets.'
        },
        MotherLastName: {
            characteronly: 'Enter only alphabets.'
        },
        MothercYear: {
            digits: 'Enter only digits.',
            maxlength: 'Enter only 2 digits.',
            minlength: 'Enter only 2 digits.'
        },
        Occupation: {
            characteronly: 'Enter only alphabets.'
        },
        Mobile: {
            digits: 'Enter digits only.',
            maxlength: 'Enter maximum 11 digits only.',
            minlength: 'Enter minimum 9 digits only.'
        },
        LandLine: {
            digits: 'Enter digits only.',
            maxlength: 'Enter maximum 11 digits only.',
            minlength: 'Enter minimum 9 digits only.'
        },
        MotherEmail: {
            email: 'Enter valid email.'
        },
        MotherSpokenLanguages: {
            charactercomma: 'Enter only alphabets and special characters ","',
            characteronly: 'Enter only alphabets.'
        },
        Address4: {
            digits: 'Enter digits only.',
            maxlength: 'Enter only 6 digits.',
            minlength: 'Enter only 6 digits.'
        },
        Address5: {
            characteronly: 'Enter only alphabets.'
        },
        PartnerInitial: {
            maxlength: 'Enter only 5 characters.'
        },
        PartnerName: {
            characteronly: 'Enter only alphabets.'
        },
        PartnerLastName: {
            characteronly: 'Enter only alphabets.'
        },
        PartnerOccupation: {
            characteronly: 'Enter only alphabets.'
        },
        PartnerContact: {
            digits: 'Enter digits only.',
            maxlength: 'Enter maximum 11 digits only.',
            minlength: 'Enter minimum 9 digits only.'
        },
        PartnerMobile: {
            digits: 'Enter digits only.',
            maxlength: 'Enter maximum 11 digits only.',
            minlength: 'Enter minimum 9 digits only.'
        },
        Email: {
            email: 'Enter valid email.'
        },
        FatherSpokenLanguages: {
            charactercomma: 'Enter only alphabets and special characters ","',
            characteronly: 'Enter only alphabets.'
        },
        Postcode: {
            digits: 'Enter digits only.',
            maxlength: 'Enter only 6 digits.',
            minlength: 'Enter only 6 digits.'
        },
        Country: {
            characteronly: 'Enter only alphabets.'
        },
        //Obstetric History
        'Medications[]': {
            charactersformedication: 'Enter alpha numeric and " / ", " . ", " - " only.'
        },
        G_Value: {
            digits: 'Gravida must be digits.',
            min: 'Enter Gravida greaterthan or equalto 1  only.',
            max: 'Enter Gravida lessthan or equalto 9  only.'
        },
        P_Value: {
            digits: 'Para must be digits.',
            min: 'Enter Para greaterthan or equalto 1  only.',
            max: 'Enter Para lessthan or equalto 9  only.'
        },
        L_Value: {
            digits: 'Livebirth must be digits..',
            min: 'Enter Livebirth greaterthan or equalto 1  only.',
            max: 'Enter Livebirth lessthan or equalto 9  only.'
        },
        A_Value: {
            digits: 'Abortion must be digits.',
            min: 'Enter  Abortion greaterthan or equalto 1  only.',
            max: 'Enter  Abortion lessthan or equalto 9  only.'
        },
        'Year[]': {
            digits: 'Year digits only.',
            maxlength: 'Enter maximum 4 digits.',
            minlength: 'Enter minimum 4 digits.',
            min: 'Please enter after '+parseInt(new Date().getFullYear() - 100)+ ' Year',
            max: 'Enter Valid Year'
            
        },
        'Place[]': {
            lettersonly: 'Enter valid place'
        },
        'Complications[]': {
            characteronly: 'Enter valid Complications'
        },
        'GA[]': {
            digits: 'GA must be digits.',
            max: 'GA must be lessthan or equal 43.',
            min: 'GA must be greaterthan or equal 23.'
        },
        'BW[]': {
            digits: 'B.Wt must be in digits',
            maxlength: 'B.Wt must be 4 digits.',
            minlength: 'B.Wt must be 4 digits.'
        },
        'details[]': {
            characteronly: 'Enter valid details'
        },
        Booking: {
            characteronly: 'Enter only alphabets.',
            lettersonly: 'Enter only alphabets.',
        },
        PlaceofSupervision: {
            lettersonly: 'Enter only alphabets.',
            characteronly: 'Enter only alphabets.',
        },
        'duration_in_weeks[]': {
            digits: 'Duration  must be in digits.',
            min: 'Duration  must greaterthan or equalto 0.',
            max: 'Duration  must lessthan or equalto 43.'
        },
        datinggestations: {
            digits: 'Dating Scan Gestation must be in digits.',
            min: 'Dating Scan Gestation greaterthan or equalto 0.',
            max: 'Dating Scan Gestation lessthan or equalto 43.'
        },
        analoggestations: {
            digits: 'Anomaly Scan Gestation must be in digits.',
            min: 'Anomaly Scan Gestation greaterthan or equalto 0.',
            max: 'Anomaly Scan Gestation lessthan or equalto 24.'
        },
        'othergestations[]': {
            digits: 'Scan Gestation must be in digits.',
            min: 'Scan Gestation greaterthan or equalto 0.',
            max: 'Scan Gestation lessthan or equalto 43.'
        },
        'dopplergestations[]': {
            digits: 'Doppler Scan Gestation must be in digits.',
            min: 'Doppler Scan Gestation greaterthan or equalto 0.',
            max: 'Doppler Scan Gestation lessthan or equalto 43.'
        },
        CordpH: {
            digitonedecimaltwo: 'Cord pH may include 1 digits 2 decimal places.',
            min: 'Cord pH must be greaterthan or equalto 6.',
            max: 'Cord pH lessthan or equalto 8.'
        },
        CordHCO3: {
            digitstwodecimalone: 'Cord HCO3 may include 2 digits 1 decimal .',
            min: 'Cord HCO3 must be greaterthan or equalto 0.',
            max: 'Cord HCO3 must be lessthan or equalto 40.'
        },
        CordBE: {
            digitstwodecimaloneplus: 'Cord BE may include 2 digits 1 decimal with +/- .',
            min: 'Cord BE must be greaterthan or equalto -50.',
            max: 'Cord BE must be lessthan or equalto 50.'
        },
        duration_dcc: {
            digits: 'Duration of DCC must be in digits.',
            min: 'Duration of DCC must greaterthan or equalto 0.',
            max: 'Duration of DCC must lessthan or equalto 120.'
        },
        Apgars1min: {
            digits: 'Total must be in digits.',
            min: 'Total must greaterthan or equalto or equalto 0.',
            max: 'Total must lessthan or equalto 10.'
        },
        Apgars5min: {
            digits: 'Total must be in digits.',
            min: 'Total must greaterthan or equalto 0.',
            max: 'Total must lessthan or equalto 10.'
        },
        Apgars10min: {
            digits: 'Total must be in digits.',
            min: 'Total must greaterthan or equalto 0.',
            max: 'Total must lessthan or equalto 10.'
        },
        Apgars15min: {
            digits: 'Total must be in digits.',
            min: 'Total must greaterthan or equalto 0.',
            max: 'Total must lessthan or equalto 10.'
        },
        Apgars20min: {
            digits: 'Total must be in digits.',
            min: 'Total must greaterthan or equalto 0.',
            max: 'Total must lessthan or equalto 10.'
        },
        TimeOf1stGasp: {
            digitstwodecimalone: 'Time of 1st Gasp can be  2 digits and 1 decimal places.',
            min: 'Time of 1st Gasp must greaterthan or equalto 0.',
            max: 'Time of 1st Gasp must lessthan or equalto 40.'
        },
        RegularRespiration: {
            digitstwodecimalone: 'Regular Respiration can be 2 digits 1 decimal places.',
            min: 'Regular Respiration must greaterthan or equalto 0.',
            max: 'Regular Respiration must lessthan or equalto 40.'
        },
        DurationOfOxygen: {
            RegularRespiration: 'Duration of Oxygen can be 2 digits 1 decimal places.',
            min: 'Duration of Oxygen must greaterthan or equalto 0.',
            max: 'Duration of Oxygen must lessthan or equalto 40.'
        },
        DepthOfInsertion: {
            RegularRespiration: 'Depth Of Insertion can be 2 digits 1 decimal places.',
            min: 'Depth Of Insertion must greaterthan or equalto 5.',
            max: 'Depth Of Insertion must lessthan or equalto 15.'
        },
        DurationOfPPV: {
            RegularRespiration: 'Duration of PPV can be 2 digits 1 decimal places.',
            min: 'Duration of PPV must greaterthan or equalto 0.',
            max: 'Duration of PPV must lessthan or equalto 40.'
        },
        duration_of_cpr: {
            RegularRespiration: 'Duration of CPR  can be 2 digits 1 decimal places.',
            min: 'Duration of CPR  must greaterthan or equalto 0.',
            max: 'Duration of CPR  must lessthan or equalto 40.'
        },
        NbHR: {
            threeDigits: 'HR in bpm may include 3 digits.'
        },
        NbRR: {
            threeDigits: 'RR in bpm may include 3 digits.'
        },
        TemperatureF: {
            decimal_range_one: 'Temperature may include 3 digits with 1 decimal.',
            min: 'Temperature must greaterthan or equalto 10.',
            max: 'Temperature must lessthan or equalto 120.'
        },
        NbSpO2: {
            digits: 'SpO2 must be digits.',
            min: 'SpO2 must greaterthan or equalto 0.',
            max: 'SpO2 must lessthan or equalto 100.'
        },
        DischargeWeight: {
            digits: 'Discharge Weight must be digits.',
            minlength: 'Discharge Weight must be greaterthan or equalto 3 digits.',
            maxlength: 'Discharge Weight must be lessthan or equalto 4 digits.'
        },
        discharge_length: {
            digitstwodecimalone: 'Discharge Length can be 2 digits and 1 decimal places.',
            min: 'Discharge Length greaterthan or equalto 0.',
            max: 'Discharge Length lessthan or equalto 99.'
        },
        discharge_ofc: {
            digitstwodecimalone: 'Discharge OFC can be 2 digits and 1 decimal places.',
            min: 'Discharge OFC greaterthan or equalto 0.',
            max: 'Discharge OFC lessthan or equalto 99.'
        },
        PostductalSaturation: {
            digits: 'Postductal Saturation must be digits.',
            min: 'Postductal Saturation must be greaterthan or equalto 0.',
            max: 'Postductal Saturation must be lessthan or equalto 100.'
        },
        room_id: {
            required: 'Please Select Room No in NICU'
        },
        bed_id: {
            required: 'Please Select Bed No in NICU'
        },
    },
    showErrors: function(errorMap, errorList) {
        if (typeof errorList[0] !== "undefined") {
            var position = $(errorList[0].element).position().top;
            var ingnoreName = $(errorList[0].element).attr('name');
            if (ingnoreName != 'Address5' && ingnoreName != 'Address4' && ingnoreName != 'Postcode' && ingnoreName != 'Postcode') {
                $('html, body').animate({
                    scrollTop: position
                }, 300);
            }
        }
        this.defaultShowErrors();
    }
});
// baby dob birth 
$('.baby-dob').datepicker({
    dateFormat: 'dd-mm-yy',
    yearRange: "-16:-0",
    changeMonth: true,
    changeYear: true,
    maxDate: '-0M',
});

var today = new Date();
$('.parents-dob').datepicker({
    dateFormat: 'dd-mm-yy',
    // yearRange: "-40:-15",
    yearRange: "-40:-0",
    changeMonth : true,
    changeYear :true,
    maxDate: today,
    viewMode: "years", 
  minViewMode: "years",
  updateViewDate: true,

});

if ($('select[name="transfer_status"]').val() != 'NICU') {
    $('.nicu_bed_reg').hide();
} else {
    var id = 1;
    var name = 'transfer_status';
    getBedAvailList(id, name);
}
$('select[name="transfer_status"]').on('change', function() {
    if ($(this).val() == 'NICU') {
        var id = 1;
        var name = $(this).attr('name');
        // $('.nicu_bed_reg').show();
        // getBedAvailList(id, name);
    } else {
        $('.nicu_bed_reg').hide();
    }
});
$(document).on('change', 'select[name="room_id"]', function() {
    var id = $(this).val();
    var name = $(this).attr('name');
    getBedAvailList(id, name);
});

function getBedAvailList(id, name) {
    var current_room_id = 0;
    var current_bed_id = 0;
    var slug, url;
    var destinationName;
    var getUrl = window.location;
    var baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
    
    if (name == 'transfer_status') {
        slug = 'ROOMLIST';
        destinationName = 'room_id';
    } 
    else if (name == 'room_id') {
        id = (id == null) ? room_id : id;
        slug = 'BEDLIST';
        destinationName = 'bed_id';
    }
        url = baseUrl + '/baby-bed-details' + '/' + id + '/' + slug;
        
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: url,
        success: function(response) {
            var wardOption = '';
            $.each(response.results, function(index, value) {
                if (slug == 'ROOMLIST') {
                    if (value.id == current_room_id) {
                        wardOption += '<option value="' + value.id + '" selected="selected">' + value.name + '</option>';
                    }
                     else {
                        wardOption += '<option value="' + value.id + '">' + value.name + '</option>';
                    }
                }
                if (slug == 'BEDLIST') {
                    if (value.id == current_bed_id) {
                        wardOption += '<option value="' + value.id + '" selected="selected">' + value.name + '</option>';
                    }
                     else {
                        wardOption += '<option value="' + value.id + '">' + value.name + '</option>';
                    }
                }
            });
            $('select[name="' + destinationName + '"]').html(wardOption);
        },
    });
}

$('#MotherDOB').change(function () {
        caluclateAge('MotherDOB','MothercYear');
    });

    $('#PartnerDOB').change(function () {
        caluclateAge('PartnerDOB','PartnercYear');
    });

    $('.samecontacts').click(function(){
         if($('.samecontacts').is(':checked')){

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

                $('#FatherAddress1').val("");
                $('#City').val("");
                $('#FatherAddress2').val("");
                $('#Country').val("");
                $('#Postcode').val("");
            }
            

    });
    $('.sameascurrentaddress').click(function () {
            if ($('.sameascurrentaddress').is(':checked')) {

                $('#Address1').val($('#Street').val());
                $('#Address1').val($('#City').val());
                $('#Address2').val($('#State').val());
                $('#Address3').val($('#Country').val());
                $('#Address4').val($('#Postcode').val());

            } else {

                $('#Address1').val("");
                $('#Address2').val("");
                $('#Address3').val("");
                $('#Address4').val("");
                
            }
            

    });
    function getRoomsByWard(transfer_status)
    {
        var getUrl = window.location;
        var baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
        var current_room_id = $('select[name=room_id]').val();
        $.ajax({
            type: "GET",
            url: baseUrl + '/baby-ward-room-bed-list' + '/' + transfer_status + '/ROOMLIST',
            success: function(response) {
                var wardOption = '';
                var i = 0;
                var results = response.results;
                if (results.length != 0) {
                    wardOption += '<option value="" selected="selected">N/A</option>';
                    $.each(response.results, function(index, value) {
                        if (current_room_id != 0 && current_room_id !== undefined && current_room_id == value.id) {
                            wardOption += '<option value="' + value.id + '" selected="selected">' + value.number + '</option>';
                        }
                        else
                        {
                            wardOption += '<option value="' + value.id + '">' + value.number + '</option>';
                        }
                        if (i == 0 && (current_room_id == 0 || current_room_id === undefined)) {
                            getBedsByRoom(value.id);
                        }
                        i++;
                    });
                }
                else
                {
                    if ($('#transfer_status').val() == 'NICU') {
                        $('select[name=room_id]').attr('required', true);
                    }
                }
                $('select[name=room_id]').html(wardOption);
            },
            complete: function(response) {}
        });
    }
    function getBedsByRoom(room_id)
    {
        var getUrl = window.location;
        var baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
        $.ajax({
            type: "GET",
            url: baseUrl + '/baby-ward-room-bed-list' + '/' + room_id + '/BEDLIST',
            success: function(response) {
                var wardOption = '';
                var results = response.results;
                if (results.length != 0) {
                    $.each(response.results, function(index, value) {
                        wardOption += '<option value="' + value.id + '">' + value.number + '</option>';
                    });
                }
                else
                {
                    if ($('#transfer_status').val() == 'NICU') {
                        $('select[name=bed_id]').attr('required', true);
                    }
                }
                $('select[name=bed_id]').html(wardOption);
            },
            complete: function(response) {}
        });
    }
    
    $('input[name="datingdate"], input[name="analogdate"], input[name^="otherdate"], input[name^="dopplerdate"]').datepicker({
    dateFormat: 'dd-mm-yy',
    yearRange: "-60:+02",
    changeMonth: true,
    changeYear: true,
    maxDate: '-0M',
});