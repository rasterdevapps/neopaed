var postnatalArray = ['AnteriorFontanelle', 'Cephalhematoma', 'Colour', 'EyeInfection', 'RespiratoryDistress',
    'CardiacMurmur', 'Femorals', 'UmbilicalInfection', 'Genitalia', 'NeonatalJaundice', 'Hips', 'Phototherapy',
    'PassedUrine', 'BowelsOpen', 'blood_culture'

];

$.each(postnatalArray, function (index, values) {
    buildSelector(values);
});


$(document).on('click', ".additional_diagnosis_add", function () {
    option = '<tr>';
    option += '<td><input type="text" class="form-control full-width" name="additional_diagnosis[]"/></td>';
    option += '<td><span class="fa fa-trash btn btn-danger btn-view remove-additional-diagnosis"></span></td>';
    option += '</tr>';
    $("table.additional_diagnosis tbody").append(option);
});

$(document).on('click', '.post_antibiotic_add', function () {

    var antibiotic = $('select[name="temp_antibiotic"]').html();
    var len = $('table.antibiotic tbody tr').length;
    var option = '<tr>';
    option += '<td class="full-width"><select class="postnatal_antiboitic full-width" id="antibiotic-sepsis-' + len + '" name="postnatal_antiboitic[]">' + antibiotic + '</select></td>';
    option += '<td><input class="form-control input-width-mini" name="postnatal_antiboitic_day[]" type="text"></td>';
    option += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>';
    option += '</tr>';

    $('table.antibiotic tbody').append(option);

    $('#antibiotic-sepsis-' + len).select2({
        allowClear: true,
        dropdownAutoWidth: false,
        width: 'resolve'
    });

});

$(document).on('click', '.postnatal_organizam_add', function () {
    var organizam = $('select[name="temp_organism"]').html();
    var option = '<tr>';
    option += '<td class="full-width"><select class="postnatal_organism form-control full-width" name="postnatal_organism[]">' + organizam + '</select></td>';
    option += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>';
    option += '</tr>';
    $('table.postnatal-organizam tbody').append(option);
});

$(document).on('click', '.postnatal_other_drugs_add', function () {

    var postnatalDrugs = '<tr><td class="full-width"><input class="form-control full-width" name="postnatal_other_drugs[]" type="text"></td>';
    postnatalDrugs += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>';

    $('table.sep_drugs tbody').append(postnatalDrugs);

});

$(document).on('click', ".remove-additional-diagnosis", function () {
    $(this).parent('td').parent('tr').remove();
});


$("#postnatal_daycare_form").validate({
    rules: {
        SeenBy: {
            required: true
        },
        DayDate: {
            required: true
        },
        Dayhours: {
            required: true
        },
        Daymins: {
            required: true
        },
        Dayam_pm: {
            required: true
        },
        TCB: {
            twodigitstwodecimal: true,
            min: 0,
            max: 50
        },
        TSB: {
            twodigitstwodecimal: true,
            min: 0,
            max: 50
        }
    },
    messages: {
        SeenBy: {
            required: 'SeenBy is mandatory.'
        },
        DayDate: {
            required: 'Date is mandatory.'
        },
        Dayhours: {
            required: 'Hour is mandatory in time fields.'
        },
        Daymins: {
            required: 'Minutes is mandatory in time fields.'
        },
        Dayam_pm: {
            required: 'Time is mandatory.'
        },
        TCB: {
            twodigitstwodecimal: 'TcB may include 2 digits and 2 decimals.',
            min: 'TcB must be greaterthan or equalto 0',
            max: 'TcB must be lessthan or equalto 50'
        },
        TSB: {
            twodigitstwodecimal: 'TSB may include 2 digits and 2 decimals.',
            min: 'TSB must be greaterthan or equalto 0',
            max: 'TSB must be lessthan or equalto 50'
        }
    }

});

$('#examination_normal').change(function () {

    if ($(this).prop('checked')) {

        $('#AnteriorFontanelle, #Activity, #Femorals, #Genitalia, #Hips').val('Normal').trigger('change');

        $('#Cephalhematoma, #EyeInfection, #RespiratoryDistress, #CardiacMurmur, #UmbilicalInfection, #NeonatalJaundice').val('No').trigger('change');

        $('#Colour').val('Pink').trigger('change');

        $('#PassedUrine, #BowelsOpen').val('Yes').trigger('change');

    } else {

        $('#AnteriorFontanelle, #Activity, #Femorals, #Genitalia, #Hips, #Cephalhematoma, #EyeInfection, #RespiratoryDistress, #CardiacMurmur, #UmbilicalInfection, #NeonatalJaundice, #Colour, #PassedUrine, #BowelsOpen').val('').trigger('change');

    }

});

function sepsisScreen() {

    if ($('#postnatal_sepsis').val() == 'No sepsis' || $('#postnatal_sepsis').val() == '') {


        $('select[name="postnatal_antiboitic[]"]').attr('disabled', true);
        $('select[name="blood_culture"]').attr('disabled', true);
        $('select[name="postnatal_organism[]"]').attr('disabled', true);
        $('.antibiotic').parent().parent().slideUp();
        $('#blood_culture').parent().parent().slideUp();
        $('.postnatal-organizam').parent().parent().slideUp();

    } else {


        $('select[name="postnatal_antiboitic[]"]').removeAttr('disabled');
        $('select[name="blood_culture"]').removeAttr('disabled');
        $('select[name="postnatal_organism[]"]').removeAttr('disabled');
        $('.antibiotic').parent().parent().slideDown();
        $('#blood_culture').parent().parent().slideDown();
        $('.postnatal-organizam').parent().parent().slideDown();

    }

}

$('#postnatal_sepsis').change(function () {
    sepsisScreen();

});
    sepsisScreen();
// $('#DayDate').on('change', function () {
//     var dayDate = $('#DayDate').val();
//     var dobDate = $('#DOB').val();

//     dobDate = stringToDate(dobDate, 'dd-mm-yyyy', '-');
//     dayDate = stringToDate(dayDate, 'dd-mm-yyyy', '-');

//     var tempDays = calculateDays(dobDate, dayDate);
//     $('#DayOfLife').val(tempDays);

// });
