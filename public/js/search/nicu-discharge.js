$(document).ready(function() {
    var nicuarray = ['Immunization', 'NicuNewBornScreen', 'HearingScreening', 'HomeOxygen', 'DischargeCUSS', 'ROPTreatment', 'NeurologicalStatus', 'rop_follow_up', 'cardiacmurmur', 'FemoralPulses', 'Hips', 'gentila', 'nicu_malformation', 'RopScreening', 'discharge_cuss', 'echocardiography_status'];
    $.each(nicuarray, function(index, value) {
        buildSelector(value);
    });
    $('.procedure_add').click(function() {
        var procedure = '<tr>';
        procedure += '<td>';
        procedure += '<select name="procedures[]" class="form-control">';
        procedure += $('select[name="temp_procedures"]').html();
        procedure += '</select>';
        procedure += '</td>';
        procedure += '<td>';
        procedure += '<span class="fa fa-trash btn btn-danger btn-view remove"></span>';
        procedure += '</td>';
        procedure += '</tr>';
        $('.procedure-list tbody').append(procedure);
    });
    new DualListbox("#nicu-options", {
        availableTitle: "Available numbers",
        selectedTitle: "Selected numbers",
        addButtonText: ">",
        removeButtonText: "<",
        addAllButtonText: ">>",
        removeAllButtonText: "<<",
        searchPlaceholder: "search numbers",
        enableDoubleClick: true,
    });
    $('.export').click(function(e) {
        e.preventDefault();
        $('#exportModal').modal('show');
    });
    $('.export-fields').click(function(e) {
        e.preventDefault();
        var value_list = [];
        $('.dual-listbox__selected li').each(function(){
            value_list.push($(this).attr('data-id'));
        });
        var validate = false;
        $('.error-export').remove();
        $('input[name="nicu_export_list"]').val(JSON.stringify(value_list));
        if ($('input[name="file_name"]').val() == '') {
            validate = true;
            $('input[name="file_name"]').after('<span class="error-export"> This fields required</span>');
        }
        if (value_list.length == 0) {
            validate = true;
            $('select[name="nicu-options_helper2"]').after('<span class="error-export"> Please Choose The Fields required</span>');
        }
        if (!validate) {
            $('#export-sheet').submit();
            $('#exportModal').modal('hide');
        }
    });
});
