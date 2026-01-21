$(document).ready(function() {
    var postnatalarray = ['discharge_immunization', 'discharge_cardiac_murmur', 'discharge_femorals', 
                                  'discharge_hips', 'discharge_malinformation', 'neourological_status', 'discharge_home_oxygen',
                                  'discharge_cuss', 'discharge_new_born', 'discharge_hearing_screen',
                                  'rop_screening_status', 'rop_follow_up', 'rop_treatment','echocardiography_status','discharge_gentila'];
    $.each(postnatalarray, function(index, value) {
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
    new DualListbox("#post-options", {
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
        $('input[name="post_export_list"]').val(JSON.stringify(value_list));
        if ($('input[name="file_name"]').val() == '') {
            validate = true;
            $('input[name="file_name"]').after('<span class="error-export"> This fields required</span>');
        }
        if (value_list.length == 0) {
            validate = true;
            $('select[name="post-options_helper2"]').after('<span class="error-export"> Please Choose The Fields required</span>');
        }
        if (!validate) {
            $('#export-sheet').submit();
            $('#exportModal').modal('hide');
        }
    });
});
