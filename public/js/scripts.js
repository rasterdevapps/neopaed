// JavaScript Document
$(document).off('.datepicker.data-api');
$(".medi_add").click(function() {
    option_select = "<select name='Problems[]' class='input-width-xlarge form-control'>";
    option_select += $("select[name='temp_medi_probs']").html();
    option_select += "</select>";
    option = '<tr><td>' + option_select + '</td>';
    option += '<td><input type="text" name="Medications[]" class="input-width-xlarge form-control" /></td>';
    option += '<td><span class="fa fa-trash btn btn-danger btn-view remove-medi"></span></td>';
    option += '</tr>';
    $("table.medi tbody").append(option);
});
$(".gravida_add").click(function() {
    option = '<tr><td><input class="form-control input-width-small" name="G_sequence[]" type="text" value=""></td>';
    option += '<td><input class="form-control input-width-small" name="G_Value[]" type="text" value="0"></td></td>';
    option += '<td><input class="form-control input-width-small" name="P_Value[]" type="text" value="0"></td></td>';
    option += '<td><input class="form-control input-width-small" name="L_Value[]" type="text" value="0"></td></td>';
    option += '<td><input class="form-control input-width-small" name="A_Value[]" type="text" value="0"></td></td>';
    option += '<td><span class="fa fa-remove btn btn-danger remove btn-view-gravida"></span></td>';
    option += '</tr>';
    $("table.gravida tbody").append(option);
});
$(document).on('click', ".remove-medi", function() {
    $(this).parent('td').parent('tr').remove();
});
$(document).on('click', ".remove-gravida", function() {
    $(this).parent('td').parent('tr').remove();
});
$(document).on('click', ".remove-neon", function() {
    $(this).parent().parent().remove();
});
$(".doppler-scan-add").click(function() {
    option = '<tr><td><input type="text" class="form-control input-width-medium" name="dopplerdate[]" readonly  /></td>';
    option += '<td><input type="text" class="form-control input-width-medium" name="dopplergestations[]"  /></td>';
    option += '<td><input type="text" class="form-control input-width-large" name="dopplerfindings[]" /></td>';
    option += '<td><span class="fa fa-trash btn btn-danger btn-view remove-usg"></span></td>';
    option += '</tr>';
    $("table.doppler-scan tbody").append(option);

    $('input[name^="dopplerdate"]').datepicker({
    dateFormat: 'dd-mm-yy',
    yearRange: "-16:-0",
    changeMonth: true,
    changeYear: true,
    maxDate: '-0M',
});
});
$(".any-further-scan-add").click(function() {
    option = '<tr><td><input type="text" class="form-control input-width-medium" name="otherdate[]" readonly  /></td>';
    option += '<td><input type="text" class="form-control input-width-medium" name="othergestations[]"  /></td>';
    option += '<td><input type="text" class="form-control input-width-large" name="otherfindings[]" /></td>';
    option += '<td><span class="fa fa-trash btn btn-danger btn-view remove-usg"></span></td>';
    option += '</tr>';
    $("table.any-further-scan tbody").append(option);

    $('input[name^="otherdate"]').datepicker({
    dateFormat: 'dd-mm-yy',
    yearRange: "-16:-0",
    changeMonth: true,
    changeYear: true,
    maxDate: '-0M',
});
});
$(document).on('click', ".remove-usg", function() {
    $(this).parent('td').parent('tr').remove();
});
$("select[name^='M_Drugs']").each(function() {
    var id = $(this).data('id');
    $(".drug-list-name" + id).select2({
        allowClear: true,
        dropdownAutoWidth: false
    });
});
$("select[name^='T_Drugs']").each(function() {
    var id = $(this).data('id');
    $(".t-drug-list-name" + id).select2({
        allowClear: true,
        dropdownAutoWidth: false
    });
});

$(".drugs_add").click(function() {

    var l = $("select[name^='formulation']").last().attr('class');
        l = typeof l != 'undefined' ? parseInt(l.replace(/[^0-9]/g, '')) + 1 : 0;

    option_select = "<select name='M_Frequency[]' class='form-control'>";
    option_select += $("select[name='temp_frequency']").html();
    option_select += "</select>";
    drug_select = "<select name='M_Drugs[]' data-id=" + l + " class='drug-list-name" + l + " drugs-changes' style='width: 300px;'>";
    drug_select += $("select[name='temp_drugs']").html();
    drug_select += "</select>";
    duration_select = '<select name ="M_Duration[]" class="form-control  M_Duration' + l + '">';
    duration_select += $("select[name='temp_duration']").html();
    duration_select += "</select>";
    dose_select = '<select name ="M_Dose[]" class="form-control  M_Dose' + l + '">';
    dose_select += $("select[name='temp_does']").html();
    dose_select += '</select>';
    option = '<tr><td>' + drug_select + '</td>';
    option += ' <td><input type="text" name="m_generic_name[]" class="form-control generic_name' + l + '" value=""/></td>';
    option += ' <td><select name="formulation[]" class="form-control formulation' + l + ' "><option value="0"> N/A</option></td>';
    option += '<td class="input-width-medium">' + dose_select + '</td>';
    option += '<td class="input-width-medium">' + option_select + '</td>';
    option += '<td class="input-width-medium">' + duration_select + '</td>';
    option += '<td><textarea name="additional_instruction[]" class="form-control" rows="1"></textarea></td>';
    option += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>';
    option += '</tr>';
    $("table.drugs tbody").append(option);
    $(".drug-list-name" + l).select2({
        allowClear: true,
        dropdownAutoWidth: false
    });
    addFieldHighlighter();
});
$(".discharge_drugs_add").click(function() {

    //var l = $("input[name^='m_formulation']").last().attr('class');
    //l = typeof l != 'undefined' ? parseInt(l.replace(/[^0-9]/g, '')) + 1 : 0;
    var l = $('#dischargeform .discharge_drugs tbody tr').length;  
    option_select = "<select name='M_Frequency[]' class='form-control'>";
    option_select += $("select[name='temp_frequency']").html();
    option_select += "</select>";

    drug_select = "<select name='M_Drugs[]' data-id=" + l + " class='m-drug-list-name" + l + " m-drugs-changes' style='width: 300px;'>";
    drug_select += $("select[name='temp_drugs']").html();
    drug_select += "</select>";

    duration_select = '<select name ="M_Duration[]" class="form-control  M_Duration' + l + '    ">';
    duration_select += $("select[name='temp_duration']").html();
    duration_select += "</select>";

    dose_select = '<input type="text" name ="M_Dose[]" class="form-control  M_Dose' + l + '">';
    // dose_select += $("select[name='temp_does']").html();
    // dose_select += '</select>';

    option = '<tr><td>' + drug_select + '</td>';
    option += ' <td><input type="text" name="m_generic_name[]" class="form-control m_generic_name' + l + '" value=""/></td>';
    option += ' <td><input type="text" name="m_formulation[]" class="form-control m_formulation"></td>';
    option += '<td class="input-width-medium">' + dose_select + '</td>';
    option += '<td class="input-width-medium">' + option_select + '</td>';
    option += '<td class="input-width-medium">' + duration_select + '</td>';
    option += '<td><textarea name="M_additional_instruction[]" class="form-control textarea-need" rows="1"></textarea></td>';
    option += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>';
    option += '</tr>';
    $("table.discharge_drugs tbody").append(option);
    $(".m-drug-list-name" + l).select2({
        allowClear: true,
        dropdownAutoWidth: false
    });
    addFieldHighlighter();
});
$(".medi_drugs_add").click(function() {
    var l = $('#treatmentform .medi_drugs tbody tr').length;
//console.log(l)
//    var l = $("input[name^='t_formulation']").last().attr('class');
  //l = typeof l != 'undefined' ? parseInt(l.replace(/[^0-9]/g, '')) + 1 : 0;
    
    //console.log(l);
    option_select = "<select name='T_Frequency[]' class='form-control'>";
    option_select += $("select[name='temp_frequency']").html();
    option_select += "</select>";

    drug_select = "<select name='T_Drugs[]' data-id=" + l + " class='t-drug-list-name" + l + " t-drugs-changes' style='width: 300px;'>";
    drug_select += $("select[name='temp_drugs']").html();
    drug_select += "</select>";

    duration_select = '<select name ="T_Duration[]" class="form-control  T_Duration' + l + '">';
    duration_select += $("select[name='temp_duration']").html();
    duration_select += "</select>";

    dose_select = '<input type="text" name ="T_Dose[]" class="form-control  T_Dose' + l + '">';
    

    option = '<tr><td>' + drug_select + '</td>';
    option += ' <td><input type="text" name="t_generic_name[]" class="form-control t_generic_name' + l + '" value=""/></td>';
    option += ' <td><input type="text" name="t_formulation[]" class="form-control t_formulation"/></td>';
    option += '<td input type="text" class="input-width-medium">' + dose_select + '</td>';
    option += '<td class="input-width-medium">' + option_select + '</td>';
    option += '<td class="input-width-medium">' + duration_select + '</td>';
    option += '<td><textarea name="T_additional_instruction[]" class="form-control textarea-need" rows="1"></textarea></td>';
    option += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>';
    option += '</tr>';
    $("table.medi_drugs tbody").append(option);
    $(".t-drug-list-name" + l).select2({
        allowClear: true,
        dropdownAutoWidth: false
    });
    addFieldHighlighter();
});
$('.organizam_add').click(function() {
    option_select = "<select name='Organism[]' class='form-control'>";
    option_select += $("select[name='temp_organism']").html();
    option_select += "</select>";
    option = "<tr>";
    option += "<td class='full-width'>" + option_select + "</td>";
    option += "<td><span class='fa fa-trash btn btn-danger btn-view remove'></span></td>";
    option += "</tr>";
    $('table.organizam tbody').append(option);
});
$(".nicu_complication_add").click(function() {
    option_select = "<select name='Complication[]' class='form-control'>";
    option_select += $("select[name='temp_complications']").html();
    option_select += "</select>";
    option = '<tr><td class="half-width">' + option_select + '</td>';
    option += '<td class="half-width"><input type="text" name="Treatments[]" class="form-control" value="" /></td>';
    option += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>';
    option += '</tr>';
    $("table.complication tbody").append(option);
});
$(".complication_add").click(function() {
    var l = $('select[name="Complication[]"]').length + 1;
    option_select = "<select name='Complication[]' class='complication-disabled complication-search' id='complication-search-" + l + "'  style='width: 257px;'>";
    option_select += $("select[name='temp_complications']").html();
    option_select += "</select>";
    option = '<tr><td class="form-group">' + option_select + '</td>';
    option += '<td class="form-group"><input type="text" name="Treatments[]" class="form-control input-width-large" value="" /></td>';
    option += '<td class="form-group"><input type="text" name="duration_in_weeks[]" class="form-control input-width-medium" value="" /></td>';
    option += '<td class="form-group">';
    option += '<select name="duration_unit[]" class="form-control input-width-medium">';
    option += '<option value="">N/A</option>';
    option += '<option value="days">days</option>';
    option += '<option value="weeks">weeks</option>';
    option += '<option value="month">month</option>';
    option += '</select>';
    option += '</td>';
    option += '<td class="form-group"><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>';
    option += '</tr>';
    $("table.complication tbody").append(option);
    $("#complication-search-" + l).select2({
        allowClear: true,
        dropdownAutoWidth: false
    });
});
$(".delivery_add").click(function() {
    option = '<tr><td><input type="text" class="form-control input-width-mini" name="Year[]" value="" /></td>';
    option += '<td><input type="text" class="form-control" name="Place[]" value="" /></td>';
    option += '<td class="input-width-medium"><select class="form-control input-width-Delivery" name="Delivery[]">	<option value="">N/A</option><option value="Vaginal">Vaginal </option><option value="LSCS">LSCS </option><option value="Instrumental">Instrumental </option><option value="Breech">Breech </option></select></td>';
    option += '<td><input type="text" class="form-control" name="Complications[]" value="" /></td>';
    option += '<td class="input-width-medium"><select class="form-control input-width-Gender" name="Gender[]">	<option value="">N/A</option><option value="Male">Male</option><option value="Female">Female</option><option value="Indeterminate">Indeterminate</option></select></td>';
    option += '<td><input type="text" class="form-control input-width-mini" name="GA[]" value="" /></td>';
    option += '<td><input type="text" class="form-control input-width-mini" name="BW[]" value="" /></td>';
    option += '<td class="input-width-medium"><select class="form-control" name="Health[]"><option value="">N/A</option><option value="Alive">Alive</option><option value="Died">Died</option><option value="Unhealthy">Unhealthy</option></select></td>';
    option += '<td><input type="text" name="details[]" class="form-control input-width" value="" /></td>'
    option += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>';
    option += '</tr>';
    $("table.delivery tbody").append(option);
});
$(".antibiotic_add").click(function() {
    antibiotic_select = '<select name="A_Antibiotic[]" class="form-control sepsis-antibiotic" >';
    antibiotic_select += $("select[name='a_antibiotic_temp']").html();
    antibiotic_select += '</select>';
    option = '<tr><td class="full-width">' + antibiotic_select + '</td>';
    option += '<td><input type="text" class="input-width-mini form-control" name="A_Day[]" value="" /></td>';
    option += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>';
    option += '</tr>';
    $("table.antibiotic tbody").append(option);
});
$(".sep_drugs_add").click(function() {
    antibiotic_select = '<select name="drugs[]" class="form-control sepsis-non-antibiotic" >';
    antibiotic_select += $("select[name='a_nonantibiotic_temp']").html();
    antibiotic_select += '</select>';
    option = '<tr><td class="full-width">' + antibiotic_select + '</td>';
    option += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>';
    option += '</tr>';
    // option = '<tr><td class="full-width"><input type="text" class="form-control" name="drugs[]" value="" /></td>';
    // option += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>';
    // option += '</tr>';
    $("table.sep_drugs tbody").append(option);
});
$(".sites_add").click(function() {
    option = '<tr><td><input type="text" class="input-width-medium form-control" name="sites[]" value="" /></td>';
    option += '<td><span class="fa fa-remove btn btn-danger remove btn-view"></span></td>';
    option += '</tr>';
    $("table.sites tbody").append(option);
});
$(".master_antibiotic_add").click(function() {
    var ids = highestValueOf("table.master_antibiotic tr");
    option = '<tr data-len="' + ids + '"><td><input type="text" class="input-width-medium input-fields-shadow form-control name" name="Name[' + ids + ']" value="" /></td>';
    option += '<td><input type="text" class="input-width-medium input-fields-shadow form-control" name="Value[' + ids + ']" value="" /></td>';
    option += '<td><select name="Status[' + ids + ']" class="input-width-medium input-fields-shadow form-control"><option value="Active" selected="selected">Active</option><option value="Inactive">Inactive</option></select></td>';
    option += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>';
    option += '</tr>';
    $("table.master_antibiotic tbody").append(option);
});
$(".master_drugs_add").click(function() {
    var ids = $('input[name="Name[]"]').length;
    ids += ids;
    option = '<tr><td><input type="text" class="input-width-medium form-control" name="Name[]" value="" /></td>';
    option += '<td><input type="text" class="input-width-medium form-control" name="Value[]" value="" /></td>';
    option += '<td><select name="Status[]" class="input-width-medium form-control"><option value="Active" selected="selected">Active</option><option value="Inactive">Inactive</option></select></td>';
    option += '<td><a data-len="1" class="btn btn-default btn-basic-shadow add-values"><i class="fa fa-plus"></i></a></td>';
    option += '<td><a class="btn btn-basic-shadow btn-danger remove btn-view"><i class="fa fa-trash"></i></a></td>';
    option += '</tr>';
    $("table.master_drugs tbody").append(option);
});
$(".booking_place_add").click(function() {
    var ids = highestValueOf("table.booking_place tr");
    option = '<tr data-len="' + ids + '"><td><input type="text" class="input-width-medium form-control input-fields-shadow name" name="hospital_name[' + ids + ']" value="" /></td>';
    option += '<td><input type="text" class="input-width-medium form-control input-fields-shadow" name="hospital_email[' + ids + ']" value="" /></td>';
    option += '<td><input type="text" class="input-width-medium form-control input-fields-shadow" name="hospital_number[' + ids + ']" value="" /></td>';
    option += '<td><select name="status[' + ids + ']" class="input-width-medium form-control input-fields-shadow"><option value="Active" selected="selected">Active</option><option value="Inactive">Inactive</option></select></td>';
    option += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>';
    option += '</tr>';
    $("table.booking_place tbody").append(option);
});
$(".add-values").click(function() {
    var ids = highestValueOf("table.master_drugs tr");
    option = '<tr data-len="' + ids + '"><td></td><td></td>';
    option += '<td><input type="text" class="input-width-medium input-fields-shadow form-control valid" name="Value[' + ids + ']" value="" /></td>';
    option += '<td><select name="Status[' + ids + ']" class="input-width-medium input-fields-shadow form-control"><option value="Active" selected="selected">Active</option><option value="Inactive">Inactive</option></select></td>';
    option += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>';
    option += '</tr>';
    $("table.master_drugs tbody").append(option);
});
$(".master_indication_add").click(function() {
    var ids = highestValueOf("table.master_indication tr");
    option = '<tr data-len="' + ids + '"><td><input type="text" class="form-control input-fields-shadow input-width-medium name" name="indication_name[' + ids + ']" value="" /></td>';
    option += '<td><select name="indication_status[' + ids + ']" class="form-control input-fields-shadow input-width-medium"><option value="1" selected="selected">Active</option><option value="0">Inactive</option></select></td>';
    option += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>';
    option += '</tr>';
    $("table.master_indication tbody").append(option);
});
$(".master_doctors_add").click(function() {
    var ids = highestValueOf("table.master_doctors tr");
    option = ' <tr data-len="' + ids + '"><td><input type="text" name="name_prefix[' + ids + ']" value="Dr" readonly="true" class="form-control input-width-mini input-fields-shadow"/></td>'
    option += '<td><input type="text" class="input-width-large form-control input-fields-shadow name" name="Name[' + ids + ']" value="" /></td>';
    option += '<td><input type="text" class="input-width-large form-control input-fields-shadow" name="Qualification[' + ids + ']" value="" /></td>';
    option += '<td><input type="text" name="job_title[' + ids + ']" value="" class="form-control input-width-large input-fields-shadow"></td>';
    option += '<td><input type="text" name="register_no[' + ids + ']" value="" class="form-control input-width-medium input-fields-shadow"></td>';
    option += '<td><select name="type[' + ids + ']" class="input-width-small form-control input-fields-shadow"><option value="1" selected="selected">Doctor</option><option value="2">Surgeon</option></select></td>';
    option += '<td><select name="status[' + ids + ']" class="input-width-small form-control input-fields-shadow"><option value="1" selected="selected">Active</option><option value="0">Inactive</option></select></td>';
    option += '<td><a class="btn btn-danger remove btn-view btn-basic-shadow"><i class="fa fa-trash"></i></a></td>';
    option += '</tr>';
    $("table.master_doctors tbody").append(option);
});
$(".master_admission_add").click(function() {
    var ids = highestValueOf("table.master_admission_mode tr");
    option = '<tr data-len="' + ids + '"><td><input type="text" class="input-width-large form-control input-fields-shadow name" name="Mode_name[' + ids + ']" value="" /></td>';
    option += '<td><select name="Status[' + ids + ']" class="input-width-medium form-control input-fields-shadow"><option value="1">Active</option><option value="0">Inactive</option></select></td>';
    option += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>';
    option += '</tr>';
    $("table.master_admission_mode tbody").append(option);
});
$(".master_staff_add").click(function() {
    option = '<tr><td><input type="text" class="input-width-large form-control" name="name[]" value="" /></td>';
    option += '<td><input type="text" class="input-width-large form-control" name="qualification[]" value="" /></td>';
    option += '<td><input type="text" class="input-width-large form-control" name="designation[]" value="" /></td>';
    option += '<td><select name="status[]" class="input-width-medium form-control"><option selected="selected" value="">--select--</option><option value="1">Active</option><option value="0">Inactive</option></select></td>';
    option += '<td><span class="fa fa-remove btn btn-danger remove btn-view"></span></td>';
    option += '</tr>';
    $("table.master_admission_mode tbody").append(option);
});
$(".master_respiratory_add").click(function() {
    var ids = highestValueOf("table.master_respiratory_indication tr");
    option = '<tr data-len="' + ids + '"><td><input type="text" class="input-width-large form-control input-fields-shadow name" name="respiratory_name[' + ids + ']" value="" /></td>';
    option += '<td><select name="respiratory_status[' + ids + ']" class="input-width-medium form-control input-fields-shadow"><option value="1">Active</option><option value="0">Inactive</option></select></td>';
    option += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>';
    option += '</tr>';
    $("table.master_respiratory_indication tbody").append(option);
});
$(".master_surgeon_add").click(function() {
    option = '<tr><td><input type="text" class="input-width-large form-control" name="surgeon_name[]" value="" /></td>';
    option += '<td><select name="status[]" class="input-width-medium form-control"><option value="1">Active</option><option value="0">Inactive</option></select></td>';
    option += '<td><span class="fa fa-remove btn btn-danger remove btn-view"></span></td>';
    option += '</tr>';
    $("table.master_surgeon tbody").append(option);
});
$(".master_add").click(function() {
    var ids = highestValueOf("table.masters tr");
    option = '<tr data-len="' + ids + '"><td><input type="text" class="input-width-medium input-fields-shadow form-control name" name="Name[' + ids + ']" value="" /></td>';
    option += '<td><select name="Status[' + ids + ']" class="input-width-medium input-fields-shadow form-control"><option value="Active" selected="selected">Active</option><option value="Inactive">Inactive</option></select></td>';
    option += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>';
    option += '</tr>';
    $("table.masters tbody").append(option);
});
$(".MaternalAntibiotics_add").click(function() {
    option = '<tr><td class="full-width"><input type="text" class="form-control" name="MaternalAntibiotics[]" value="" /></td><td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td></tr>';
    $("table.MaternalAntibiotics tbody").append(option);
});
$(".neon_add").click(function() {
    option_select = $("select[name='neonatal_consultant_temp']").html();
    neo = '<select id="neonatal_consultant" class="form-control full-width valid" name="neonatal_consultant[]">';
    neo += '<option value=" "> N/A</option>';
    neo += option_select;
    neo += '</select>';
    option = '<tr><td>' + neo + '</td>';
    option += '<td><span class="fa fa-trash btn btn-danger btn-view remove-neon"></span></td></tr>';
    $(".neonatal-consultant-div").append(option);
});

$(".master_dasii_add").click(function() {
    var ids = highestValueOf("table.masters tr");
    option_select = $(".temp_dassi_question_type").html();
    var temp_clusters_content = $(".temp_dasii_content_cluster").html();

    option = '<tr data-len="' + ids + '"><td><textarea class="form-control valid" name="question[]" rows="2" cols="50"></textarea></td>';
    option += '<td><select name="question_type[]" class="form-control">'+ option_select +'</select></td>';
    option += '<td><select name="status[]" class="input-width-medium input-fields-shadow form-control"><option value="Active" selected="selected">Active</option><option value="Inactive">Inactive</option></select></td>';
    option += '<td><input type="text" name="fiftieth_percentile[]" class="form-control" required /></td>';
    option += '<td><input type="text" name="third_percentile[]" class="form-control" /></td>';
    option += '<td><input type="text" name="ninety_seventh_percentile[]" class="form-control" /></td>';
    option += '<td><select name="content_cluster[]" class="form-control">'+ temp_clusters_content +'</select></td>';
    option += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>';
    option += '</tr>';
    $("table.master_dasii_qestions_table tbody").append(option);

});
$('.pediatric_consultant_add').click(function() {
    option_select = $("select[name='pediatric_consultant_temp']").html();
    neo = '<select id="pediatric_consultant" class="form-control full-width valid" name="pediatric_consultant[]">';
    neo += '<option value=" "> N/A</option>';
    neo += option_select;
    neo += '</select>';
    option = '<tr><td>' + neo + '</td>';
    option += '<td><span class="fa fa-trash btn btn-danger btn-view remove-neon"></span></td></tr>';
    $(".neonatal-consultant-div").append(option);
});
$('.Indication_add_more').click(function() {
    option_select = $("select[name='temp_indication']").html();
    var i = $('select[name^="Indication"]').length;
    ind = '<select class="delivery-indications-search full-width" name="Indication[]" id="delivery-indications-search-' + i + '">';
    ind += '<option value=" "> N/A</option>';
    ind += option_select;
    ind += '</select>';
    option = '<tr>';
    option += '<td class="full-width">' + ind + '</td>';
    option += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>';
    option += '</tr>';
    $("table.indication-add tbody").append(option);
    $("#delivery-indications-search-" + i).select2({
        allowClear: true,
        dropdownAutoWidth: false,
        width: 'resolve'
    });
});
$(".vaccine_add").click(function() {
    var ids = $("select[name^='Vaccine']").last().attr('class');
        ids = typeof ids != 'undefined' ? parseInt(ids.replace(/[^0-9]/g, '')) + 1 : 0;
    option_select = '<tr>';
    option_select += '<td  class="form-group full-width">';
    option_select += '<select class="full-width vaccine-search' + ids + '" name="Vaccine[]">';
    option_select += $("select[name='temp_Vaccine']").html();
    option_select += '</select>';
    option_select += '</td>';
    option_select += '<td class="form-group">';
    option_select += '<input class="input-width-small form-control datepicker' + ids + ' VaccineDate" name="VaccineDate[]" type="text" readonly >';
    option_select += '</td>';
    option_select += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td></tr>';
    $("table.vaccine tbody").append(option_select);
    $('.datepicker' + ids).datepicker({
        dateFormat: 'dd-mm-yy',
        yearRange: "-60:+02",
        changeMonth: true,
        changeYear: true,
    });
    $(".vaccine-search" + ids).select2({
        allowClear: true,
        dropdownAutoWidth: false,
        width: 'resolve'
    });
});
$('.master_nurse_add').click(function() {
    var ids = highestValueOf(".master_nurse_tbody tr");
    var status = '<select name="status[' + ids + ']" class="form-control input-fields-shadow input-width-medium">';
    status += '<option selected="selected" value="Active">Active</option>';
    status += '<option value="Inactive">Inactive</option>';
    status += '</select>';
    var lists = '<td><input type="text" name="name[' + ids + ']"  class="form-control input-fields-shadow input-width-xlarge name" /></td>';
    lists += '<td><input type="text" name="register_no[' + ids + ']" class="form-control input-fields-shadow input-width-xlarge" /></td>';
    lists += '<td>' + status + '</td>';
    lists += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></i></a></td>';
    $('.master_nurse_tbody').append('<tr data-len="' + ids + '">' + lists + '</tr>');
});
$(document).on('click', '.master_ward_add', function() {
    var ids = highestValueOf("table.master_ward tbody tr");
    var gid = $(this).attr('data-id');
    // var id = $(this).data('id');
    // ids = typeof id != 'undefined' ? id : ids;
    // var wardName = $(this).parent().parent().find('.ward').attr('name'); 
    var option = '<tr data-len="' + ids + '" class="g-ward'+gid+'">';
    option += '<td></td>';
    option += '<td></td>';
    option += '<td></td>';
    option += '<td><input type="text" name="ward' + ids + '[]" value="" class="form-control ward input-fields-shadow ward'+gid+'" data-group-id="ward'+gid+'" /></td>';
    option += '<td><a class="master_ward_add btn btn-success btn-view btn_add" data-id="' + gid + '"><i class="fa fa-plus"></i></a></td>';
    option += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>';
    option += '</tr>';
    $(this).parent().parent().after(option);
});
$(document).on('click', '.master_drug_ivfluid_add', function() {
    // var groupNumber = $('.wardgroup').length+1;
    var ids = highestValueOf(".master_drug_ivfluid tr");
    var type_options = $('.temp_durgs_iv_fluid_types').html();
    var option = '<tr data-len="' + ids + '">';
    option += '<td><input type="text" name="brand_name[' + ids + ']" value="" class="form-control input-fields-shadow input-width-medium valid"/></td>';
    option += '<td><input type="text" name="generic_pharmacological_name[]" value="" class="form-control input-fields-shadow input-width-medium valid" /></td>';
    option += '<td><input type="text" name="value[]" value="" class="form-control input-fields-shadow input-width-medium" /></td>';
    option += '<td><select name="type[]" class="form-control input-fields-shadow input-width-medium valid">' + type_options + '</select></td>';
    option += '<td><select name="status[]" class="form-control input-fields-shadow input-width-medium"><option selected="selected" value="1">Active</option><option value="0">Inactive</option></select></td>';
    option += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>';
    option += '</tr>';
    $('.master_drug_ivfluid tbody').append(option);
});
$(document).on('click', '.master_ward_group_add', function() {
    // var groupNumber = $('.wardgroup').length+1;
    var ids = highestValueOf(".master_ward tr");
    var option = '<tr data-len="' + ids + '" class="g-ward'+ids+'">';
    option += '<td></td>';
    option += '<td><input type="text" name="wardgroup[' + ids + ']" value="" class="form-control wardgroup input-fields-shadow"/></td>';
    option += '<td><a class="master_ward_group_add btn btn-success btn-view btn_add"><i class="fa fa-plus"></i></a></td>';
    option += '<td><input type="text" name="ward' + ids + '[]" value="" class="form-control ward input-fields-shadow ward'+ids+'" data-group-id="ward'+ids+'" /></td>';
    option += '<td><a class="master_ward_add btn btn-success btn-view btn_add" data-id="' + ids + '"><i class="fa fa-plus"></i></a></td>';
    option += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>';
    option += '</tr>';
    $('.master_ward tbody').append(option);
});
$(document).on('click', '.master_ward_edit_add', function() {
    var ward_group_id = $(this).data('ward-group');
    var ward = $(this).data('ward') + 1;
    var ids = highestValueOf(".master_ward tr");
    ward_id = (typeof ward_group_id != 'undefined') ? ward_group_id : ids;
    ward_group_id = (typeof ward_group_id != 'undefined') ? ward_group_id + ':' + ids : '';
    ward = (typeof ward != '') ? ward : '';
    // var wardName = $(this).parent().parent().find('.ward').attr('name'); 

    var gid = $(this).attr('data-id');
    $('input[name="data_len"]').val(ids);

    var option = '<tr data-len="' + ids + '" class="g-ward'+gid+'">';
    option += '<td></td>';
    option += '<td></td>';
    option += '<td></td>';
    option += '<td><input type="text" name="ward' + gid + '[' + ward_group_id + ']" value="" class="form-control ward  input-fields-shadow input-width-medium ward'+gid+'" data-group-id="ward'+gid+'"/></td>';
    option += '<td><a class="master_ward_edit_add btn btn-success btn-view btn_add" data-id="' + gid + '"><i class="fa fa-plus"></i></a></td>';
    option += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>';
    option += '</tr>';
    $(this).parent().parent().after(option);
});
$(document).on('click', '.master_ward_group_edit_add', function() {
    // var groupNumber = $('.wardgroup').length+1;
    var ids = highestValueOf(".master_ward tr");
    $('input[name="data_len"]').val(ids);
    var option = '<tr data-len="' + ids + '" class="g-ward'+ids+'">';
    option += '<td></td><td><input type="text" name="wardgroup[' + ids + ']" value="" class="form-control wardgroup input-fields-shadow input-width-medium"/></td>';
    option += '<td><a class="master_ward_group_edit_add btn btn-success btn-view btn_add"><i class="fa fa-plus"></i></a></td>';
    option += '<td><input type="text" name="ward' + ids + '[]" value="" class="form-control ward input-fields-shadow input-width-medium ward'+ids+'" data-group-id="ward'+ids+'"/></td>';
    option += '<td><a class="master_ward_edit_add btn btn-success btn-view btn_add" data-id="' + ids + '"><i class="fa fa-plus"></i></a></td>';
    option += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>';
    option += '</tr>';
    $('.master_ward tbody').append(option);
});
$(document).on('click', '.bed_ward_add', function() {
    var ids = highestValueOf("table.bed_ward tbody tr");
    option_select = '<select name="status[' + ids + ']" class="input-width-medium form-control input-fields-shadow">';
    option_select += $("select[name='temp_bed_status']").html();
    option_select += '</select>';
    option = '<tr data-len="' + ids + '">';
    option += '<td></td>';
    option += '<td></td>';
    option += '<td><input type="text" name="bednumber[' + ids + ']" value="" class="form-control input-width-medium input-fields-shadow bednumbercount"/></td>';
    option += '<td>' + option_select + '</td>';
    option += '<td><select name="pump_type[' + ids + ']" class="input-width-medium form-control input-fields-shadow">';
    option += $("select[name='temp_pump_type']").html();
    option += '</select></td>';
    // option += '<td><a class="bed_ward_add btn btn-default btn-basic-shadow"><i class="fa fa-plus"></i></a></td>';
    option += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>';
    option += '</tr>';
    $("table.bed_ward tbody").append(option);
});
$('.master-add-collection-method').click(function() {
    var ids = highestValueOf("table.masters-collection-method tbody tr");
    var option = '<tr data-len="' + ids + '">';
    option += '<td><input type="text" name="Name[' + ids + ']" value="" class="form-control input-fields-shadow name" /></td>';
    option += '<td>';
    option += '<select name="Status[' + ids + ']" class="form-control input-fields-shadow">';
    option += '<option selected="selected" value="Active">Active</option>';
    option += '<option value="Inactive">Inactive</option>';
    option += '</select>';
    option += '</td>';
    option += '<td><a class="btn btn-danger remove btn-view btn-basic-shadow"><i class="fa fa-trash"></i></a></td>';
    option += '</tr>';
    $("table.masters-collection-method tbody").append(option);
});
$(".ivantibitic_add").click(function() {
    option = '<tr><td class="full-width"><select name="IVAntibiotic[]" class="full-width form-control">';
    option += $("select[name='IVAntibiotic']").html();
    option += '</select></td>';
    option += '</select></td><td><span class="fa fa-trash btn btn-danger btn-view remove-ivantibitic"></span></td></tr>';
    $("table.IVAntibiotic tbody").append(option);
});
$(".master_prescription_type_add").click(function() {
    var ids = highestValueOf("table.master_prescription_type tbody tr");
    option = '<tr data-len="' + ids + '"><td><input type="text" name="name[' + ids + ']" value="" class="form-control input-fields-shadow input-width-medium name"></td><td><input type="text" name="value[]" value="" class="form-control input-fields-shadow input-width-medium"></td><td><select name="status[]" class="form-control input-fields-shadow input-width-medium"><option selected="selected" value="1">Active</option><option value="0">Inactive</option></select></td><td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td></tr>';
    $("table.master_prescription_type tbody").append(option);
});
$(document).on('click', '.remove-ivantibitic', function() {
    $(this).parent('td').parent().remove();
});
$(".master_investigations_add").click(function() {
    var form_id = $(this).parents('form').attr('id');
    var ids = highestValueOf("table.master_investigations tr");
    option = '<tr data-len="' + ids + '">';
    // if (form_id == 'EditForm') {
    //     ids = 'e' + ids;
    // }
    option += '<td></td>';
    option += '<td></td>';
    option += '<td><input type="text" name="test_name[' + ids + ']" class="form-control input-width-medium input-fields-shadow checkvalid" value="" /></td>';
    option += '<td><select name="test_status[' + ids + ']" class="form-control input-fields-shadow input-width-medium"><option value="1">Active</option><option value="0">Inactive</option></select></td>';
    option += '<td><span class="fa fa-trash btn btn-danger btn-view remove-ivantibitic"></span></td>';
    option += '</tr>';
    var package_container_span = $('#package_container td').attr('rowspan');
    package_container_span = parseInt(package_container_span) + 1;
    $('#package_container td').attr('rowspan', package_container_span);
    $("table.master_investigations tbody").append(option);
});
$(".master_m_chat_questions_add").click(function() {
    var form_id = $(this).parents('form').attr('id');
    var ids = highestValueOf("table.master_m_chat_qestions tr");
    question = '<tr data-len="' + ids + '">';
    if (form_id == 'EditForm') {
        ids = 'e' + ids;
    }
    question += '<td><textarea class="form-control valid" name="question[' + ids + ']" rows="5" cols="50"></textarea></td>';
    question += '<td><input data-size="small" name="answer[' + ids + ']" data-off="No" data-on="Yes" data-width="100" data-toggle="toggle" class="form-control switch-input" type="checkbox" /></td>';
    question += '<td><select name="status[' + ids + ']" class="form-control input-fields-shadow input-width-medium"><option value="1">Active</option><option value="0">Inactive</option></select></td>';
    question += '<td><span class="fa fa-trash btn btn-danger btn-view remove-ivantibitic"></span></td>';
    question += '</tr>';
    $("table.master_m_chat_qestions tbody").append(question);
    $("input[data-toggle='toggle']").bootstrapToggle();
});

function addIvfluids() {
    var ids = highestValueOf("table.master_ivfluids tr");
    var ivfluids = '<td></td>';
    ivfluids += '<td><input name="name[' + ids + ']" type="text" class="form-control input-fields-shadow valid"/></td>';
    ivfluids += '<td><select name="status[' + ids + ']" class="form-control input-fields-shadow"><option selected="selected" value="Active">Active</option><option value="Inactive">Inactive</option></select></td>';
    ivfluids += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>';
    $('table.master_ivfluids tbody').append('<tr data-len="' + ids + '">' + ivfluids + '</tr>');
}
$(document).on('click', '.master_ivfluids_add', function() {
    addIvfluids();
});

function makeDisable(idList) {
    $.each(idList, function(key, value) {
        if ($('#' + value).attr('type') == 'text') {
            //$('#'+value).val('');
        }
        $('#' + value).attr('disabled', true).parent().parent().slideUp();
    });
}

function removeDisable(idList) {
    $.each(idList, function(key, value) {
        $('#' + value).removeAttr('disabled').parent().parent().slideDown();
    });
}
$(document).on('click', ".remove", function() {
    $(this).parent('td').parent('tr').remove();
});

function caluclateAge(source_id, desination_id) {
    var today = new Date(),
        birthday = $('#' + source_id).datepicker("getDate"),
        age = ((today.getMonth() > birthday.getMonth()) || (today.getMonth() == birthday.getMonth() && today.getDate() >= birthday.getDate())) ? today.getFullYear() - birthday.getFullYear() : today.getFullYear() - birthday.getFullYear() - 1;
    $('#' + desination_id).val(age).trigger('change');
}

function get_age(dob) {
    var today = new Date();
    arr = dob.split('-');
    birthday = new Date(arr[2], arr[1], arr[0]);
    age = ((today.getMonth() > birthday.getMonth()) || (today.getMonth() == birthday.getMonth() && today.getDate() >= birthday.getDate())) ? today.getFullYear() - birthday.getFullYear() : today.getFullYear() - birthday.getFullYear() - 1;
    return age;
}
$('.GetSNAPPE2Score').change(function() {
    var total = 0;
    $('.GetSNAPPE2Score').each(function() {
        var points = ($(this).val() == '') ? 0 : parseInt($(this).val());
        total = parseInt(total) + points;
    });
    $('#TotalSNAPPE2Score').val(total);
});
$('.GetSNAP2Score').change(function() {
    var total = 0;
    $('.GetSNAP2Score').each(function() {
        var points = ($(this).val() == '') ? 0 : parseInt($(this).val());
        total = parseInt(total) + points;
    });
    $('#TotalSNAP2Score').val(total);
});
$(".annual_compare_dates").click(function(e) {
    e.preventDefault();
    var option = "<tr><td>";
    option += "<div class='form-group'>";
    option += "<input type='text' name='compare_start_date[]' class='form-control input-fields-shadow datepicker ' readonly='true'>";
    option += "</div></td>";
    option += "<td><div class='form-group'>";
    option += "<input type='text' name='compare_end_date[]' class='form-control input-fields-shadow datepicker ' readonly='true'>";
    option += "</div>";
    option += "</td> <td><span class='fa fa-remove btn btn-default save-button-shadow remove'></span></td> </tr>";
    $("table.annual-reports-comparing tbody").append(option);
    $('.datepicker').datepicker({
        dateFormat: 'dd-mm-yy',
        yearRange: "-60:+02",
        changeMonth: true,
        changeYear: true,
    });
});

function MptypeNobabies(flag) {
    var id = $('#MultiplePregnancyType').val();
    switch (id) {
        case 'Twins':
            return numbers_serials(flag, 'Twin', 2);
            break;
        case 'Triplets':
            return numbers_serials(flag, 'Triplet', 3);
            break;
        case 'Quadruplets':
            return numbers_serials(flag, 'Quadruplet', 4);
            break;
        case 'Quintuplets':
            return numbers_serials(flag, 'Quintuplet', 5);
            break;
        case 'Sextuplets':
            return numbers_serials(flag, 'Sextuplet', 6);
            break;
        case 'Septuplets':
            return numbers_serials(flag, 'Septuplet', 7);
            break;
        case 'Octuplets':
            return numbers_serials(flag, 'Octuplet', 8);
            break;
        default:
            return numbers_serials(flag, 'Singleton', 1);
            break;
    }
}

function numbers_serials(flag, type, counts) {
    if (flag) {
        var comman = [];
        for (var i = 1; i <= counts; i++) {
            (type == 'Singleton') ? comman.push(type): comman.push(type + '-' + i);
        }
    } else {
        comman = counts;
    }
    return comman;
}

function GetAutogenValues() {
    var base_url = $("input[name='site_base_url']").val();
    $.ajax({
        type: 'GET',
        url: base_url + '/home/get-auto-gen-words',
        success: function(responseText) {
            return responseText.message;
        },
    });
}

function responseMessageajax(errorNo, message) {
    switch (errorNo) {
        case 200:
            return Showalert('success', message);
        case 201:
            return Showalert('warning', message);
        case 302:
            return Showalert('warning', 'You not have permission !');
            break;
        default:
            return Showalert('warning', 'Something went worng contact admin !');
            break;
    }
}

function calculateDays(startDate, endDate) {
    if ((typeof endDate != 'undefined' && endDate != null && Date.parse(endDate) > 0) && (typeof startDate != 'undefined' && startDate != null && Date.parse(startDate) > 0)) {
        return Math.floor((endDate.getTime() - startDate.getTime()) / 86400000);
    }
}

function hearingDependancy() {
    if ($('#discharge_hearing_screen').val() == 'Performed') {
        $('.hearing-screen-type').slideDown();
    } else {
        $('.hearing-screen-type-value').val('');
        $('.hearing-screen-type').slideUp();
    }
}

function ropDependancy() {
    if ($('#rop_screening_status').val() == 'Performed') {
        $('.rop-results').slideDown();
        $('#rop_treatment').parent().parent().slideDown();
        $('#rop_follow_up').parent().parent().slideDown();
    } else {
        $('.rop-results-type').val('');
        $('.rop-results').slideUp();
        $('#rop_treatment').parent().parent().slideUp();
        $('#rop_follow_up').parent().parent().slideUp();
    }
}

function ropTreatementDependancy() {
    if ($('#rop_treatment').val() == 'Yes' && $('#rop_screening_status').val() == 'Performed') {
        $('.rop_treatment').slideDown();
    } else {
        $('.rop_treatment-type').val('');
        $('.rop_treatment').slideUp();
    }
}

function malformationDependancy() {
    var list = ['malinformation_details'];
    ($('#discharge_malinformation').val() == 'No') ? makeDisable(list): removeDisable(list);
}

function addDieddate() {
    if ($('#discharge_status').val() == 'Died' || $('#discharge_status').val() == 'Died (OCNR)') {
        $('#discharge_date').siblings('label').text('Date of Died:');
        $('.DiedTime').show();
    } else {
        $('#discharge_date').siblings('label').text('Date of Discharge / Transfered:');
        $('.DiedTime').hide();
    }
}

function getSiteUrl() {
    return $('meta[name="site-orgin"]').attr('content');
}

function appoinmentStatus() {
    if ($('#appoinment_status').prop('checked') == true) {
        $('.next-appoinment-property').show();
    } else {
        $('.next-appoinment-property').hide();
    }
}

function echoCardiographyReport() {
    if ($('#echocardiography_status').val() == 'Not Indicated' || $('#echocardiography_status').val() == '') {
        $('#echocardiography').val('').parent().parent().slideUp();
    } else {
        $('#echocardiography').parent().parent().slideDown();
    }
}

function cranialUltrasoundReport() {
    if ($('#discharge_cuss').val() == 'Not Indicated' || $('#discharge_cuss').val() == '') {
        $('#cranial_ultrasound').val('').parent().parent().slideUp();
    } else {
        $('#cranial_ultrasound').parent().parent().slideDown();
    }
}
$('.datepicker').datepicker({
    dateFormat: 'dd-mm-yy',
    yearRange: "-60:+02",
    changeMonth: true,
    changeYear: true,
});
//show last one year only
$('.previous-one-year').datepicker({
    dateFormat: 'dd-mm-yy',
    yearRange: "-1:+00",
    changeMonth: true,
    changeYear: true,
    maxDate: '+0M',
    minDate: '-12M'
});
//show next one year only
$('.next-one-year').datepicker({
    dateFormat: 'dd-mm-yy',
    yearRange: "-1:+1",
    changeMonth: true,
    changeYear: true,
    maxDate: '+12M',
    minDate: '-6M'
});
$('.admission-date').datepicker({
    dateFormat: 'dd-mm-yy',
    yearRange: "-60:+02",
    changeMonth: true,
    changeYear: true,
    maxDate: '+0M',
});
$('.baby-dob-format').datepicker({
    dateFormat: 'dd-mm-yy',
    yearRange: "-16:-0",
    changeMonth: true,
    changeYear: true,
    maxDate: '-0M',
});
$('.discharge-date').datepicker({
    dateFormat: 'dd-mm-yy',
    yearRange: "-16:-0",
    changeMonth: true,
    changeYear: true,
    maxDate: '-0M',
});

function clearFlow(slug) {
    var url = getSiteUrl() + '/' + slug;
    $.ajax({
        type: "GET",
        url: url,
        success: function(response) {
            // Showalert(response.status,response.message);               
        },
        error: function(response) {
            // Showalert(response.status,response.message);               
        },
        complete: function(response) {
            // Showalert(response.status,response.message);               
        }
    });
}
$('.clear-flow-sesstion').click(function() {
    clearFlow('cancel-current-flow');
});
$('.canceled-flow').click(function() {
    clearFlow('complete-current-flow');
});
$(document).ready(function() {
    // $('.dataTables_paginate .pagination').addClass('table-view-shadow');
    $('.complication-search').each(function() {
        $("#" + $(this).attr('id')).select2({
            allowClear: true,
            dropdownAutoWidth: false
        });
    });
    $('.delivery-indications-search').each(function() {
        $("#" + $(this).attr('id')).select2({
            allowClear: true,
            dropdownAutoWidth: false,
        });
    });
    $('.option_add').click(function() {
        var limitId = $(this).data('limit');
        var addMoreCount = parseInt(limitId.split('-')[1], 10) + 1;
        $(this).data('limit', 'option-' + addMoreCount);
        var option = '<td class="form-group"><input class="form-control input-width-large" name="limit_option[]" type="text"></td>';
        option += '<td class="form-group"><a href="javascript:void(0);" class="btn btn-danger remove btn-view"><i class="fa fa-trash"></i></a></td>';
        option += '<td class="form-group pl-10 ptb-10"><input type="radio" name="default_limit"  value="' + addMoreCount + '"> Yes</td>';
        $('.limit-option-body').append('<tr data-test="option-' + addMoreCount + '" id="option-' + addMoreCount + '" class="mb-5">' + option + '</tr>');
    });
    $(".master_department_add").click(function() {
        option = '<tr><td><input type="text" name="Name[]" class="form-control input-width-large input-fields-shadow" /></td>';
        option += '<td><select name="Status[]" class="form-control input-fields-shadow"><option value="Active">Active</option><option value="Inactive">Inactive</option></select></td>';
        option += '<td><span class="fa fa-remove btn btn-default save-button-shadow remove"></span></td>';
        option += '</tr>';
        $("table.master_department tbody").append(option);
    });
    $(".master_investigation_add").click(function() {
        option = '<tr><td><input type="text" name="Name[]" class="form-control input-width-large input-fields-shadow" /></td>';
        option += '<td><select name="Status[]" class="form-control input-fields-shadow"><option value="Active">Active</option><option value="Inactive">Inactive</option></select></td>';
        option += '<td><span class="fa fa-remove btn btn-default save-button-shadow remove"></span></td>';
        option += '</tr>';
        $("table.master_investigation tbody").append(option);
    });
    $('.record-date').not('#OpDate').change(function() {
        calculateCorrectedGestation();
    });
});
$(".pediatric_drugs_add").click(function() {
    option_select = "<select name='M_Drugs[]' class='form-control'>";
    option_select += $("select[name='temp_drugs']").html();
    option_select += "</select>";
    select = "<select name='M_Frequency[]' class='form-control'>";
    select += $("select[name='temp_frequency']").html();
    select += "</select>";
    // option  = '<td>{!! Form::select('M_Drugs[]',$drug_master,$medi_data['Medication'],['class'=>"form-control"]) !!}</td>';
    option = '<td>' + option_select + '</td>';
    option += '<td><input type="text" name="M_Dose[]" class="form-control"/></td>';
    option += '<td>' + select + '</td>';
    option += '<td><input type="text" name="M_Duration[]" class="form-control"/></td>';
    option += '<td><span class="fa fa-remove btn btn-danger remove btn-view"></span></td>';
    $("table.drugs tbody").append('<tr>' + option + '</tr>');
});
//Align pagination
$(document).ready(function() {
    $('.dataTables_footer.clearfix .col-md-6').addClass('full-width-xs full-width-sm');
    $('#data-list_length label > span').addClass('hidden-xs');
    $('.dataTables_header .col-md-6:first-child').addClass('col-xs-4 col-sm-6');
    $('.dataTables_header .col-md-6:last-child').addClass('col-xs-8 col-sm-6 pull-right');
    $('.dataTables_header .col-md-4:last-child').addClass('col-xs-8 col-sm-6 pull-right');
});
// Adding scroll for dropdown menu
$('.navbar .nav').on('mouseover', function() {
    // $('.dropdown').removeClass('open');
    $('.navbar .nav').removeClass('addScroll');
    $(this).addClass('addScroll');
    // $(this).find('.dropdown').addClass('open');
    var height = $('.addScroll .dropdown-menu').height() - 20;
    var windowheight = $(window).height() - 61;
    if (windowheight < height) {
        $('.addScroll .dropdown-menu').css({
            'max-height': windowheight,
            'overflow-y': 'auto'
        });
    }
});

function highestValueOf(position) {
    var dataList = $(position).map(function() {
        return $(this).attr("data-len");
    }).get();
    ids = Math.max.apply(null, dataList) >= 0 ? Math.max.apply(null, dataList) + 1 : 0;
    return ids;
}
$(".master_frequency_add").click(function() {
    var ids = highestValueOf("table.master_frequency tr");
    option = '<tr data-len="' + ids + '"><td><input type="text" class="input-width-medium  input-fields-shadow form-control name" name="name[' + ids + ']" value="" /></td>';
    option += '<td><input type="text" class="input-width-medium input-fields-shadow form-control" name="value[' + ids + ']" value="" /></td>';
    option += '<td><select name="usage_type[' + ids + ']" class="form-control input-fields-shadow input-width-medium"><option value="IC">Intensive Care</option><option value="OP">OP</option></select></td>';
    option += '<td><select name="status[' + ids + ']" class="input-width-medium  input-fields-shadow form-control"><option value="1" selected="selected">Active</option><option value="0">Inactive</option></select></td>';
    option += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>';
    option += '</tr>';
    $("table.master_frequency tbody").append(option);
});
$(".master_referral_doctor_add").click(function() {
    var ids = highestValueOf("table.master_referral_doctor tr");
    option = '<tr data-len="' + ids + '"><td><input type="text" class="input-width-medium  input-fields-shadow form-control valid" name="doctor_name[' + ids + ']" value="" /></td>';
    option += '<td><input type="text" class="input-fields-shadow form-control valid input-width-medium valid" name="hospital[' + ids + ']" value="" /></td>';
    option += '<td><input type="text" class="input-width-medium input-fields-shadow form-control" name="mobile_no[' + ids + ']" value="" /></td>';
    option += '<td><input type="text" class="input-fields-shadow form-control input-width-medium" name="mail_id[' + ids + ']" value="" /></td>';
    option += '<td><select name="status[' + ids + ']" class="input-width-medium  input-fields-shadow form-control"><option value="1" selected="selected">Active</option><option value="0">Inactive</option></select></td>';
    option += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>';
    option += '</tr>';
    $("table.master_referral_doctor tbody").append(option);
});
$('.fahrenheit').on('input', function()
{
    this.value = this.value.replace(/[^0-9.+]/g, '');
    var temp_fahrenheit = $(this).val();
    var temp_celsius = (parseFloat(temp_fahrenheit) - 32) * 5 / 9;
    if (!isNaN(temp_celsius)) {
        if ($(this).parent().parent().find('.celsius').hasClass('celsius-type-2')) {
            if (temp_celsius > 0) {
                $(this).parent().parent().find('.celsius').val(temp_celsius.toFixed());
            } else {
                $(this).parent().parent().find('.celsius').val(0);
            }
        } else {
            $(this).parent().parent().find('.celsius').val(temp_celsius.toFixed(2));
        }
        $('.celsius').trigger('keyup');
        $('.celsius').trigger('focusout');
    }
    else
    {
        $(this).parent().parent().find('.celsius').val('');
    }
});
$('.celsius').on('input', function()
{
    this.value = this.value.replace(/[^0-9.+]/g, '');
    var temp_celsius = $(this).val();
    var temp_fahrenheit = (parseFloat(temp_celsius) * 9 / 5) + 32;
    if (!isNaN(temp_fahrenheit)) {
        $(this).parent().parent().find('.fahrenheit').val(temp_fahrenheit.toFixed(2));
    }
    else
    {
        $(this).parent().parent().find('.fahrenheit').val('');
    }
});

function correctedGestation(g_weeks, g_days, tempDays, module_type = '') {
    // var g_weeks = 40 - parseInt(g_weeks);
    var gestation = (g_weeks * 7) + parseInt(g_days);
    var corrected_gestation = tempDays + gestation;
    if (corrected_gestation > 0) {
        var corrected_weeks = parseInt(corrected_gestation / 7);
        var corrected_days = parseInt(corrected_gestation % 7);
    } else {
        var corrected_weeks = corrected_days = 0;
    }
    if (module_type == '') {
        $('input[name="cg_weeks"]').val(corrected_weeks);
        $('input[name="cg_days"]').val(corrected_days);
    } else {
        $('input[name="dcg_weeks"]').val(corrected_weeks);
        $('input[name="dcg_days"]').val(corrected_days);
    }
}

function stringToDate(_date, _format, _delimiter)
{
    var formatLowerCase = _format.toLowerCase();
    var formatItems = formatLowerCase.split(_delimiter);
    var dateItems = _date.split(_delimiter);
    var monthIndex = formatItems.indexOf("mm");
    var dayIndex = formatItems.indexOf("dd");
    var yearIndex = formatItems.indexOf("yyyy");
    var month = parseInt(dateItems[monthIndex]);
    month -= 1;
    var formatedDate = new Date(dateItems[yearIndex], month, dateItems[dayIndex]);
    return formatedDate;
}
$(".celsius").each(function() {
    this.value = this.value.replace(/[^0-9.+]/g, '');
    var temp_celsius = $(this).val();
    var temp_fahrenheit = (parseInt(temp_celsius) * 9 / 5) + 32;
    var fahrenheit_field = $(this).parent().parent().find('.fahrenheit');
    if (!isNaN(temp_fahrenheit)) {
        fahrenheit_field.val(temp_fahrenheit);
    }
    else
    {
        if(fahrenheit_field.val() == '' || fahrenheit_field.val() == null) {
            fahrenheit_field.val('');
        } else {
            fahrenheit_field.trigger('input');
        }
    }
});
$('#DayDate').on('change', function() {
    var dayDate = $('#DayDate').val();
    var dobDate = $('#DOB').val();
    dobDate = stringToDate(dobDate, 'dd-mm-yyyy', '-');
    dayDate = stringToDate(dayDate, 'dd-mm-yyyy', '-');
    var tempDays = calculateDays(dobDate, dayDate);
    if (isNaN(tempDays) || tempDays < 0) {
        tempDays = 0;
    }
    $('#DayOfLife').val(tempDays);
});
// $('.open-doc-editor').click(function(e) {
// 	e.preventDefault();
// 	var open_editor = $(this).attr('href');
// 	bootbox.confirm("If you edit this document, the changes will not be reflected in the main database and vice versa. Do you still want to continue?",function(confirmed){
// 	    if(confirmed){
// 	    	window.location = open_editor;
// 	    }
// 	});
// });
$(window).load(function() {
    // Animate loader off screen
    $("#page-loader").fadeOut();
    // setTimeout(function() { 
    // 	$("#page-loader").fadeOut();
    // }, 200);
});
var op_related_fields = '#baby_reg_form input[name="BMrNo"], #baby_reg_form input[name="BabyName"], #baby_reg_form input[name="DOB"], #baby_reg_form select[name="Sex"], #baby_reg_form input[name="g_weeks"], #baby_reg_form input[name="g_days"], #baby_reg_form input[name="BirthWeight"], #baby_reg_form select[name="BabyBloodGroup"]';
op_related_fields += ', #op-form input[name="BMrNo"], #op-form input[name="OpDate"], #op-form input[name="BabyName"], #op-form input[name="DOB"], #op-form input[name="g_weeks"], #op-form input[name="g_days"], #op-form input[name="chronological_year"], #op-form input[name="chronological_month"], #op-form input[name="chronological_days"], #op-form input[name="corrected_year"], #op-form input[name="corrected_month"], #op-form input[name="corrected_days"], #op-form input[name="total_chronological_weeks"], #op-form input[name="total_corrected_weeks"], #op-form select[name="BabyBloodGroup"], #op-form select[name="mother_blood_group"], #op-form select[name="Sex"], #op-form input[name="BirthWeight"], #op-form input[name="CurrentWt"], #op-form input[name="CurrentOFC"], #op-form input[name="CurrentLength"], #op-form textarea[name="baby_background"], #op-form textarea[name="Complaints"], #op-form textarea[name="Development"], #op-form textarea[name="Examination"], #op-form textarea[name="neurosonogram_report"], #op-form textarea[name="echocardiogram_report"], #op-form textarea[name="Diagnosis"], #op-form textarea[name="Advice"], #op-form input[name="Review"], #op-form select[name="review_time"], #op-form select[name="review_min"], #op-form select[name="review_session"], #op-form textarea[name="nextreviewindication"], #op-form select[name^="M_Drugs"], #op-form select[name^="M_Dose"], #op-form select[name^="M_Frequency"], #op-form select[name^="M_Duration"], #op-form select[name="Immunization"], #op-form select[name^="Vaccine"]';
op_related_fields += ', #neonatalPerforma-form input[name="BabyName"], #neonatalPerforma-form input[name="DOB"], #neonatalPerforma-form input[name="BirthWeight"], #neonatalPerforma-form input[name="g_weeks"], #neonatalPerforma-form input[name="g_days"], #neonatalPerforma-form select[name="BabyBloodGroup"], #neonatalPerforma-form select[name="Sex"], #neonatalPerforma-form input[name="OFC"], #neonatalPerforma-form select[name="MotherBloodGroup"], #neonatalPerforma-form textarea[name="Background"]';
var post_summary_related_fields = '#postnatal-admission-form input[name="BabyName"], #postnatal-admission-form input[name="BMrNo"], #postnatal-admission-form input[name="DOB"], #postnatal-admission-form input[name="BirthWeight"], #postnatal-admission-form select[name="BirthStatus"], #postnatal-admission-form input[name="g_weeks"], #postnatal-admission-form input[name="g_days"], #postnatal-admission-form select[name="Sex"], #admissionid input[name="cg_weeks"], #postnatal-admission-form input[name="cg_days"], #postnatal-admission-form input[name="admission_date"], #postnatal-admission-form input[name="ip_number"]';
post_summary_related_fields += ', #postnatal-admission-form input[name="discharge_date"], #postnatal-admission-form input[name="dcg_weeks"], #postnatal-admission-form input[name="dcg_days"], #postnatal-admission-form input[name="discharge_wt"], #postnatal-admission-form input[name="discharge_ofc"], #postnatal-admission-form input[name="discharge_length"], #postnatal-admission-form select[name="schedule"], #postnatal-admission-form select[name^="Vaccine"], #postnatal-admission-form input[name^="VaccineDate"], #postnatal-admission-form textarea[name="additional_information"], #postnatal-admission-form select[name="discharge_eyes"], #postnatal-admission-form input[name="postductal_spo2"], #postnatal-admission-form textarea[name="malinformation_details"], #postnatal-admission-form select[name="feeding_at_discharge"], #postnatal-admission-form input[name="appoinment_date"], #postnatal-admission-form select[name="appoinment_hrs"], #postnatal-admission-form select[name="appoinment_min"], #postnatal-admission-form select[name="appoinment_session"], #postnatal-admission-form select[name^="M_Drugs"], #postnatal-admission-form input[name^="m_generic_name"], #postnatal-admission-form select[name^="formulation"], #postnatal-admission-form select[name^="M_Dose"], #postnatal-admission-form select[name^="M_Frequency"], #postnatal-admission-form select[name^="M_Duration"], #postnatal-admission-form input[name="discharge_hb"], #postnatal-admission-form input[name="discharge_pcv"], #postnatal-admission-form input[name="discharge_dct"], #postnatal-admission-form input[name="discharge_tsb"], #postnatal-admission-form[name="dischargeserum_ca"], #postnatal-admission-form input[name="dischargeserum_po4"], #postnatal-admission-form input[name="dischargeserum_alp"], #postnatal-admission-form input[name="dischargeserum_na"], #postnatal-admission-form textarea[name="cranial_ultrasound"], #postnatal-admission-form textarea[name="echocardiography"], #postnatal-admission-form select[name="oae_left"], #postnatal-admission-form select[name="oae_right"], #postnatal-admission-form select[name="abr_left"], #postnatal-admission-form select[name="abr_right"], #postnatal-admission-form select[name="left_rop_left"], #postnatal-admission-form select[name="left_rop_right"], #postnatal-admission-form textarea[name="advice"], #postnatal-admission-form textarea[name="plan_follow_up"]';
post_summary_related_fields += ', .mother_registration_form input[name="MMrNo"], .mother_registration_form input[name="MotherName"], .mother_registration_form input[name="MothercYear"]';
post_summary_related_fields += ', #neonatalPerforma-form input[name="BabyName"], #neonatalPerforma-form input[name="DOB"], #neonatalPerforma-form select[name="TOB_TIME"], #neonatalPerforma-form select[name="TOB_MINS"], #neonatalPerforma-form select[name="TOB_AM"], #neonatalPerforma-form input[name="BirthWeight"], #neonatalPerforma-form input[name="g_weeks"], #neonatalPerforma-form input[name="g_days"], #neonatalPerforma-form select[name="BabyBloodGroup"], #neonatalPerforma-form select[name="BirthOrder"], #neonatalPerforma-form select[name="Sex"], #neonatalPerforma-form input[name="MotherName"], #neonatalPerforma-form input[name="MothercYear"], #neonatalPerforma-form select[name^="Problems"], #neonatalPerforma-form select[name^="Medications"], #neonatalPerforma-form input[name="G_Value"], #neonatalPerforma-form input[name="P_Value"], #neonatalPerforma-form input[name="L_Value"], #neonatalPerforma-form input[name="A_Value"], #neonatalPerforma-form select[name="Conception"], #neonatalPerforma-form input[name="LMP"], #neonatalPerforma-form input[name="EDDbyUSG"], #neonatalPerforma-form input[name="EDDbyDates"], #neonatalPerforma-form select[name="MotherBloodGroup"], #neonatalPerforma-form select[name^="Complication"], #neonatalPerforma-form input[name^="Treatments"], #neonatalPerforma-form input[name^="duration_in_weeks"], #neonatalPerforma-form input[name^="duration_unit"], #neonatalPerforma-form select[name="CommentOnLiquor"], #neonatalPerforma-form input[name="Apgars1min"], #neonatalPerforma-form input[name="Apgars5min"], #neonatalPerforma-form input[name="Apgars10min"], #neonatalPerforma-form select[name="ModeOfDelivery"], #neonatalPerforma-form select[name^="Indication"], #neonatalPerforma-form select[name="Presentation"]';
var post_summary_related_fields_type_2 = '#postnatal-admission-form select[name="discharge_immunization"], #postnatal-admission-form select[name="discharge_cardiac_murmur"], #postnatal-admission-form select[name="discharge_femorals"], #postnatal-admission-form select[name="discharge_hips"], #postnatal-admission-form select[name="discharge_gentila"], #postnatal-admission-form select[name="discharge_malinformation"], #postnatal-admission-form select[name="neourological_status"], #postnatal-admission-form select[name="discharge_new_born"], #postnatal-admission-form select[name="discharge_hearing_screen"], #postnatal-admission-form select[name="rop_screening_status"]';
post_summary_related_fields_type_2 += ', #neonatalPerforma-form input[name="BirthStatus"], #neonatalPerforma-form select[name="HIV"], #neonatalPerforma-form input[name="PregnancyComplications"], #neonatalPerforma-form input[name="AntenatalSteroids"], #neonatalPerforma-form input[name="PROM"], #neonatalPerforma-form select[name="delayed_cord_clamping"], #neonatalPerforma-form select[name="VitaminK"], #neonatalPerforma-form select[name="DoseVitK"], #neonatalPerforma-form select[name="RouteVitK"]';
var post_daycare_adm_related_fields = '#postnatal-admission-form input[name="BabyName"], #postnatal-admission-form input[name="BMrNo"], #postnatal-admission-form input[name="DOB"], #postnatal-admission-form input[name="g_weeks"], #postnatal-admission-form input[name="g_days"], #postnatal-admission-form select[name="Sex"], #postnatal-admission-form select[name="typeofcare"], #postnatal-admission-form input[name="ageonadmissionindays"]';
post_daycare_adm_related_fields += ', #postnatal_daycare_form input[name="BabyName"], #postnatal_daycare_form input[name="BMrNo"], #postnatal_daycare_form input[name="DOB"], #postnatal_daycare_form select[name="Sex"], #postnatal_daycare_form textarea[name="Background"], #postnatal_daycare_form input[name="DayDate"], #postnatal_daycare_form select[name="Dayhours"], #postnatal_daycare_form select[name="Daymins"], #postnatal_daycare_form select[name="Dayam_pm"], #postnatal_daycare_form input[name="DayOfLife"], #postnatal_daycare_form textarea[name="CurrentProblems"], #postnatal_daycare_form textarea[name="PreviousProblems"], #postnatal_daycare_form select[name="Activity"], #postnatal_daycare_form input[name="TCB"], #postnatal_daycare_form input[name="TSB"], #postnatal_daycare_form textarea[name="Notes"], #postnatal_daycare_form textarea[name="Plan"]';
var post_daycare_adm_related_fields_type_2 = '#postnatal_daycare_form select[name="AnteriorFontanelle"], #postnatal_daycare_form select[name="Cephalhematoma"], #postnatal_daycare_form select[name="Colour"], #postnatal_daycare_form select[name="EyeInfection"], #postnatal_daycare_form select[name="RespiratoryDistress"], #postnatal_daycare_form select[name="CardiacMurmur"], #postnatal_daycare_form select[name="Femorals"], #postnatal_daycare_form select[name="UmbilicalInfection"], #postnatal_daycare_form select[name="Genitalia"], #postnatal_daycare_form select[name="NeonatalJaundice"], #postnatal_daycare_form select[name="Hips"], #postnatal_daycare_form select[name="PassedUrine"], #postnatal_daycare_form select[name="BowelsOpen"], #postnatal_daycare_form select[name="Phototherapy"]';
var post_adm_related_fields = '#postnatal-admission-form input[name="BabyName"], #postnatal-admission-form input[name="BMrNo"], #postnatal-admission-form input[name="DOB"], #postnatal-admission-form input[name="g_weeks"], #postnatal-admission-form input[name="g_days"], #postnatal-admission-form select[name="Sex"], #postnatal-admission-form input[name="referredby"], #postnatal-admission-form input[name="referralreason"], #postnatal-admission-form input[name="cg_weeks"], #postnatal-admission-form input[name="cg_days"], #postnatal-admission-form input[name="admission_date"], #postnatal-admission-form select[name="admission_time_hour"], #postnatal-admission-form select[name="admission_time_mins"], #postnatal-admission-form select[name="admission_time_session"], #postnatal-admission-form select[name="typeofcare"], #postnatal-admission-form input[name="ageonadmissionindays"], #postnatal-admission-form select[name="admitted_from"], #postnatal-admission-form textarea[name="major_complaints"], #postnatal-admission-form input[name="pip"], #postnatal-admission-form input[name="fio2"], #postnatal-admission-form input[name="rr"], #postnatal-admission-form select[name="chest_movement"], #postnatal-admission-form input[name="hr"], #postnatal-admission-form input[name="systolic_bp"], #postnatal-admission-form input[name="mean_bp"], #postnatal-admission-form input[name="temperature"], #postnatal-admission-form select[name="tone"], #postnatal-admission-form select[name="initialbloodgas"], #postnatal-admission-form input[name="spo2"], #postnatal-admission-form input[name="rbs"], #postnatal-admission-form select[name="initialxray"], #postnatal-admission-form select[name="sepsisscreen"], #postnatal-admission-form input[name="indications"], #postnatal-admission-form select[name^="ivantibiotic"], #postnatal-admission-form input[name="investigations"], #postnatal-admission-form input[name="fluids"], #postnatal-admission-form select[name^="differentialdiagnosis"], #postnatal-admission-form input[name^="additional_diagnosis"], #postnatal-admission-form input[name="plan"], #postnatal-admission-form select[name="pdiscussion_hrs"], #postnatal-admission-form select[name="pdiscussion_min"], #postnatal-admission-form select[name="pdiscussion_session"], #postnatal-admission-form textarea[name="matters_discussed"]';
post_adm_related_fields += ', #baby_reg_form input[name="BMrNo"], #baby_reg_form input[name="BabyName"], #baby_reg_form input[name="DOB"], #baby_reg_form select[name="BirthOrder"], #baby_reg_form select[name="Sex"], #baby_reg_form input[name="g_weeks"], #baby_reg_form input[name="g_days"], #baby_reg_form input[name="BirthWeight"]';
post_adm_related_fields += ', .mother_registration_form input[name="MMrNo"], .mother_registration_form input[name="MotherName"], .mother_registration_form input[name="MothercYear"], .mother_registration_form input[name="Mobile"], .mother_registration_form input[name="MotherSpokenLanguages"], .mother_registration_form input[name="PartnerContact"], .mother_registration_form input[name="Address1"], .mother_registration_form input[name="Address2"], .mother_registration_form input[name="Address3"], .mother_registration_form input[name="Address4"]';
post_adm_related_fields += ', #neonatalPerforma-form input[name="BabyName"], #neonatalPerforma-form input[name="DOB"], #neonatalPerforma-form input[name="BirthWeight"], #neonatalPerforma-form input[name="g_weeks"], #neonatalPerforma-form input[name="g_days"], #neonatalPerforma-form select[name="BirthOrder"], #neonatalPerforma-form select[name="Sex"], #neonatalPerforma-form input[name="Length"], #neonatalPerforma-form input[name="OFC"], #neonatalPerforma-form input[name="MotherName"], #neonatalPerforma-form input[name="MothercYear"], #neonatalPerforma-form input[name="Mobile"], #neonatalPerforma-form input[name="MotherSpokenLanguages"], #neonatalPerforma-form input[name="Address1"], #neonatalPerforma-form input[name="Address2"], #neonatalPerforma-form input[name="Address3"], #neonatalPerforma-form input[name="Address4"], #neonatalPerforma-form input[name="PartnerContact"], #neonatalPerforma-form input[name="PartnerName"], #neonatalPerforma-form select[name^="Problems"], #neonatalPerforma-form input[name^="Medications"], #neonatalPerforma-form input[name="G_Value"], #neonatalPerforma-form input[name="P_Value"], #neonatalPerforma-form input[name="L_Value"], #neonatalPerforma-form input[name="A_Value"], #neonatalPerforma-form select[name="Conception"], #neonatalPerforma-form select[name="MotherBloodGroup"], #neonatalPerforma-form input[name="PlaceofSupervision"], #neonatalPerforma-form select[name^="Complication"], #neonatalPerforma-form input[name^="Treatments"], #neonatalPerforma-form input[name^="duration_in_weeks"], #neonatalPerforma-form select[name^="duration_unit"], #neonatalPerforma-form input[name="datinggestations"], #neonatalPerforma-form input[name="datingfindings"], #neonatalPerforma-form input[name="analoggestations"], #neonatalPerforma-form input[name="analogfindings"], #neonatalPerforma-form input[name^="othergestations"], #neonatalPerforma-form input[name^="otherfindings"], #neonatalPerforma-form input[name^="dopplergestations"], #neonatalPerforma-form input[name^="dopplerfindings"], #neonatalPerforma-form select[name="CommentOnLiquor"], #neonatalPerforma-form input[name="maternal_pyrexia_celsius"], #neonatalPerforma-form input[name="maternal_pyrexia_fahrenheit"], #neonatalPerforma-form select[name="DurationOfROM"], #neonatalPerforma-form select[name="Presentation"], #neonatalPerforma-form select[name="FoetalDistress"], #neonatalPerforma-form input[name="CTGDetails"], #neonatalPerforma-form select[name="CordBloodGas"], #neonatalPerforma-form input[name="CordpH"], #neonatalPerforma-form input[name="CordHCO3"], #neonatalPerforma-form input[name="CordBE"], #neonatalPerforma-form select[name="CordBE"], #neonatalPerforma-form select[name="GastricAspirate"]';
var post_adm_related_fields_type_2 = '#postnatal-admission-form input[name="ventilation"], #postnatal-admission-form input[name="uac_status"], #postnatal-admission-form input[name="uvc_status"], #postnatal-admission-form input[name="parents_spoken"]';
post_adm_related_fields_type_2 += ', #neonatalPerforma-form select[name="HIV"], #neonatalPerforma-form select[name="HepatitisB"], #neonatalPerforma-form select[name="VDRL"], #neonatalPerforma-form input[name="Supervised"], #neonatalPerforma-form input[name="PregnancyComplications"], #neonatalPerforma-form input[name="AntenatalSteroids"], #neonatalPerforma-form input[name="Labour"], #neonatalPerforma-form input[name="MaternalPyrexia"], #neonatalPerforma-form input[name="PROM"], #neonatalPerforma-form input[name="Resuscitation"], #neonatalPerforma-form input[name="FacialOxygen"], #neonatalPerforma-form input[name="Intubation"], #neonatalPerforma-form input[name="PPV"], #neonatalPerforma-form input[name="Drugs"], #neonatalPerforma-form input[name="VitaminK"]';
var nicu_pblmsummary_related_fields = '#nicu-admission-form input[name="BabyName"], #nicu-admission-form input[name="BMrNo"], #nicu-admission-form input[name="DOB"], #nicu-admission-form input[name="BirthWeight"], #nicu-admission-form input[name="g_weeks"], #nicu-admission-form input[name="g_days"], #nicu-admission-form input[name="BabyBloodGroup"], #nicu-admission-form select[name="Sex"], #nicu-admission-form input[name="cg_weeks"], #nicu-admission-form input[name="cg_days"], #nicu-admission-form input[name="AdmissionDate"], #nicu-admission-form input[name="ip_number"], #nicu-admission-form input[name="AdmissionWt"], #nicu-admission-form input[name="AgeOnAdmissioninDays"], #nicu-admission-form input[name="AgeOnAdmissionhour"], #nicu-admission-form input[name="DischargeDate"], #nicu-admission-form input[name="DOLatDischarge"], #nicu-admission-form input[name="dcg_days"], #nicu-admission-form input[name="dcg_weeks"], #nicu-admission-form input[name="DischargeWeight"], #nicu-admission-form input[name="Length"], #nicu-admission-form input[name="OFC"], #nicu-admission-form select[name^="Vaccine"], #nicu-admission-form input[name^="VaccineDate"], #nicu-admission-form select[name="Eyes"], #nicu-admission-form input[name="PostductalSaturation"], #nicu-admission-form textarea[name="nicu_malformation_details"], #nicu-admission-form select[name="FeedingAtDischarge"], #nicu-admission-form input[name="NextAppointment"], #nicu-admission-form select[name="NAT_TIME"], #nicu-admission-form select[name="NAT_MINS"], #nicu-admission-form select[name="NAT_AM"], #nicu-admission-form select[name^="M_Drugs"], #nicu-admission-form input[name^="m_generic_name"], #nicu-admission-form select[name^="formulation"], #nicu-admission-form select[name^="M_Dose"], #nicu-admission-form select[name^="M_Frequency"], #nicu-admission-form select[name^="M_Duration"], #nicu-admission-form input[name="DischargeHb"], #nicu-admission-form input[name="DischargePCV"], #nicu-admission-form input[name="DischargeTSB"], #nicu-admission-form input[name="DischargeSerumCa"], #nicu-admission-form input[name="DischargeSerumPo4"], #nicu-admission-form input[name="DischargeSerumALP"], #nicu-admission-form input[name="DischargeSerumNa"], #nicu-admission-form textarea[name="advice"], #nicu-admission-form textarea[name="plan_follow_up"]';
nicu_pblmsummary_related_fields += ', #baby_reg_form input[name="BMrNo"], #baby_reg_form input[name="BabyName"], #baby_reg_form input[name="DOB"], #baby_reg_form select[name="TOB_TIME"], #baby_reg_form select[name="TOB_MINS"], #baby_reg_form select[name="TOB_AM"], #baby_reg_form input[name="Sex"], #baby_reg_form input[name="g_weeks"], #baby_reg_form input[name="g_days"], #baby_reg_form input[name="BirthWeight"], #baby_reg_form select[name="BabyBloodGroup"]';
nicu_pblmsummary_related_fields += ', .mother_registration_form input[name="MMrNo"], .mother_registration_form input[name="MotherName"], .mother_registration_form input[name="MothercYear"]';
nicu_pblmsummary_related_fields += ', #neonatalPerforma-form input[name="BabyName"], #neonatalPerforma-form input[name="DOB"], #neonatalPerforma-form select[name="TOB_TIME"], #neonatalPerforma-form select[name="TOB_MINS"], #neonatalPerforma-form select[name="TOB_AM"], #neonatalPerforma-form input[name="BirthWeight"], #neonatalPerforma-form input[name="g_weeks"], #neonatalPerforma-form input[name="g_days"], #neonatalPerforma-form select[name="BabyBloodGroup"], #neonatalPerforma-form select[name="Sex"], #neonatalPerforma-form input[name="MotherName"], #neonatalPerforma-form input[name="MothercYear"], #neonatalPerforma-form input[name="G_Value"], #neonatalPerforma-form input[name="P_Value"], #neonatalPerforma-form input[name="L_Value"], #neonatalPerforma-form input[name="A_Value"], #neonatalPerforma-form select[name="Conception"], #neonatalPerforma-form input[name="LMP"], #neonatalPerforma-form input[name="EDDbyUSG"], #neonatalPerforma-form input[name="EDDbyDates"], #neonatalPerforma-form select[name="MotherBloodGroup"], #neonatalPerforma-form select[name="CommentOnLiquor"], #neonatalPerforma-form select[name="Maternal_antibiotics_status"], #neonatalPerforma-form input[name="Apgars1min"], #neonatalPerforma-form input[name="Apgars5min"], #neonatalPerforma-form input[name="Apgars10min"], #neonatalPerforma-form select[name="ModeOfDelivery"], #neonatalPerforma-form select[name^="Indication"], #neonatalPerforma-form select[name="Presentation"]';
var nicu_pblmsummary_related_fields_type_2 = '#nicu-admission-form input[name="BirthStatus"], #nicu-admission-form select[name="cardiacmurmur"], #nicu-admission-form select[name="Immunization"], #nicu-admission-form select[name="discharge_femoral_pulses"], #nicu-admission-form select[name="Hips"], #nicu-admission-form select[name="gentila"], #nicu-admission-form select[name="nicu_malformation"], #nicu-admission-form select[name="NeurologicalStatus"], #nicu-admission-form select[name="discharge_cuss"], #nicu-admission-form select[name="echocardiography_status"], #nicu-admission-form select[name="NicuNewBornScreen"], #nicu-admission-form select[name="HearingScreening"], #nicu-admission-form select[name="RopScreening"]';
nicu_pblmsummary_related_fields_type_2 += ', #neonatalPerforma-form input[name="BirthStatus"], #neonatalPerforma-form input[name="HIV"], #neonatalPerforma-form input[name="HepatitisB"], #neonatalPerforma-form input[name="VDRL"], #neonatalPerforma-form input[name="AntenatalSteroids"], #neonatalPerforma-form input[name="PROM"], #neonatalPerforma-form input[name="VitaminK"], #neonatalPerforma-form input[name="DoseVitK"], #neonatalPerforma-form input[name="RouteVitK"]';
var nicu_dsummary_related_fields = '#nicu-admission-form input[name="BabyName"], #nicu-admission-form input[name="BMrNo"], #nicu-admission-form input[name="DOB"], #nicu-admission-form input[name="BirthWeight"], #nicu-admission-form input[name="BabyBloodGroup"], #nicu-admission-form select[name="Sex"], #nicu-admission-form input[name="ReferredBy"], #nicu-admission-form input[name="ReferralReason"], #nicu-admission-form input[name="AdmissionDate"], #nicu-admission-form input[name="ip_number"], #nicu-admission-form select[name^="Problems"], #nicu-admission-form input[name^="Medications"], #nicu-admission-form select[name^="Complication"], #nicu-admission-form input[name^="Treatments"], #nicu-admission-form input[name="datinggestations"], #nicu-admission-form input[name="datingfindings"], #nicu-admission-form input[name="analoggestations"], #nicu-admission-form input[name="analogfindings"], #nicu-admission-form input[name^="nothergestations"], #nicu-admission-form input[name^="notherfindings"], #nicu-admission-form input[name^="othergestations"], #nicu-admission-form input[name^="otherfindings"], #nicu-admission-form input[name^="dopplergestations"], #nicu-admission-form input[name^="dopplerfindings"], #nicu-admission-form select[name="SurfactantGiven"], #nicu-admission-form input[name="Pip"], #nicu-admission-form select[name="InitialXray"], #nicu-admission-form input[name="xrayfindings"], #nicu-admission-form input[name="AgeofCXR"], #nicu-admission-form input[name="Investigations"], #nicu-admission-form select[name^="DifferentialDiagnosis"], #nicu-admission-form input[name^="additional_diagnosis"]';
nicu_dsummary_related_fields += ', #daycare-form input[name="BabyName"], #daycare-form input[name="BMrNo"], #daycare-form input[name="DOB"], #daycare-form input[name="DayOfLife"], #daycare-form input[name="cg_weeks"], #daycare-form input[name="cg_days"], #daycare-form select[name="Sex"], #daycare-form input[name="DayDate"], #daycare-form select[name^="ResICD"], #daycare-form select[name="ModeOfVentilation"], #daycare-form input[name="PIP"], #daycare-form input[name="FiO2"], #daycare-form input[name="OI"], #daycare-form select[name^="CarICD"], #daycare-form input[name="Dopamine"], #daycare-form input[name="Dobutamine"], #daycare-form input[name="Adrenaline"], #daycare-form input[name="Noradrenaline"], #daycare-form input[name="Milrinone"], #daycare-form textarea[name="DayEcho"], #daycare-form select[name^="GasICD"], #daycare-form input[name="Volume"], #daycare-form input[name="Protein"], #daycare-form input[name="Fat"], #daycare-form input[name="total_energy"], #daycare-form select[name="NECtreatment"], #daycare-form input[name="TSB"], #daycare-form select[name="BabyBloodGroup"], #daycare-form select[name="MotherBloodGroup"], #daycare-form textarea[name="ultrasoundkeyfindings"], #daycare-form select[name^="CenICD"], #daycare-form textarea[name="Cuss"], #daycare-form textarea[name="ultrasound_spine_report"], #daycare-form textarea[name="mri_ct_brain"], #daycare-form textarea[name="eeg_cfm_report"], #daycare-form select[name^="FluidICD"], #daycare-form input[name="CurrentWt"], #daycare-form textarea[name="renalultrasoundkeyfindings"], #daycare-form select[name^="F_Product"], #daycare-form input[name^="F_Volume"], #daycare-form select[name^="SepsisICD"], #daycare-form select[name="Sepsis"], #daycare-form select[name^="A_Antibiotic"], #daycare-form input[name^="A_Day"], #daycare-form input[name="CRP"], #daycare-form input[name="Platelets"], #daycare-form select[name^="Organism"], #daycare-form select[name="Meningitis"], #daycare-form select[name^="SkinICD"], #daycare-form select[name^="RopICD"], #daycare-form textarea[name="Rop"]';
nicu_dsummary_related_fields += ', #baby_reg_form input[name="BMrNo"], #baby_reg_form input[name="BabyName"], #baby_reg_form input[name="DOB"], #baby_reg_form select[name="TOB_TIME"], #baby_reg_form select[name="TOB_MINS"], #baby_reg_form select[name="TOB_AM"], #baby_reg_form select[name="BirthOrder"], #baby_reg_form select[name="Sex"], #baby_reg_form input[name="g_weeks"], #baby_reg_form input[name="g_days"], #baby_reg_form input[name="BirthWeight"], #baby_reg_form select[name="BabyBloodGroup"], #baby_reg_form select[name^="neonatal_consultant"], #baby_reg_form select[name="obstetric_consultant"], #baby_reg_form select[name="paediatric_surgeon"]';
nicu_dsummary_related_fields += ', .mother_registration_form select[name="MotherTitle"], .mother_registration_form input[name="MotherInitial"], .mother_registration_form input[name="MotherName"], .mother_registration_form input[name="MotherLastName"], .mother_registration_form input[name="MothercYear"]';
nicu_dsummary_related_fields += ', #neonatalPerforma-form input[name="BabyName"], #neonatalPerforma-form input[name="DOB"], #neonatalPerforma-form select[name="TOB_TIME"], #neonatalPerforma-form select[name="TOB_MINS"], #neonatalPerforma-form select[name="TOB_AM"], #neonatalPerforma-form input[name="BirthWeight"], #neonatalPerforma-form input[name="g_weeks"], #neonatalPerforma-form input[name="g_days"], #neonatalPerforma-form select[name="BabyBloodGroup"], #neonatalPerforma-form select[name="BirthOrder"], #neonatalPerforma-form select[name="Sex"], #neonatalPerforma-form input[name="Length"], #neonatalPerforma-form input[name="OFC"], #neonatalPerforma-form select[name^="Problems"], #neonatalPerforma-form input[name^="Medications"], #neonatalPerforma-form input[name="G_Value"], #neonatalPerforma-form input[name="P_Value"], #neonatalPerforma-form input[name="L_Value"], #neonatalPerforma-form input[name="A_Value"], #neonatalPerforma-form select[name="Conception"], #neonatalPerforma-form input[name="EDDbyUSG"], #neonatalPerforma-form input[name="EDDbyDates"], #neonatalPerforma-form select[name="MotherBloodGroup"], #neonatalPerforma-form select[name^="Complication"], #neonatalPerforma-form input[name^="Treatments"], #neonatalPerforma-form input[name^="duration_in_weeks"], #neonatalPerforma-form select[name^="duration_unit"], #neonatalPerforma-form input[name="datinggestations"], #neonatalPerforma-form input[name="datingfindings"], #neonatalPerforma-form input[name="analoggestations"], #neonatalPerforma-form input[name="analogfindings"], #neonatalPerforma-form input[name^="othergestations"], #neonatalPerforma-form input[name^="otherfindings"], #neonatalPerforma-form input[name^="dopplergestations"], #neonatalPerforma-form input[name^="dopplerfindings"], #neonatalPerforma-form select[name="ModeOfDelivery"], #neonatalPerforma-form select[name="ModeOfDelivery"], #neonatalPerforma-form select[name^="Indication"]';
var nicu_dsummary_related_fields_type_2 = '#nicu-admission-form input[name="BirthStatus"], #nicu-admission-form input[name="UAC"], #nicu-admission-form input[name="UVC"]';
nicu_dsummary_related_fields_type_2 += ', #daycare-form select[name="InvasiveVentilation"], #daycare-form select[name="NonInvasiveVentilation"], #daycare-form select[name="OtherRespiratorySupport"], #daycare-form input[name="Surfactant_therapy_nicu"], #daycare-form input[name="needlethoracentesis"], #daycare-form input[name="intercostaldrain"], #daycare-form input[name="chronic_lung"], #daycare-form select[name="Inotropes"], #daycare-form select[name="echo_status"], #daycare-form select[name="PDA"], #daycare-form select[name="PDATreatment"], #daycare-form select[name="pphn"], #daycare-form select[name="pphn_treatement"], #daycare-form input[name="directlybreastfeed"], #daycare-form select[name="FullEnteralFeeds"], #daycare-form select[name="Tpn"], #daycare-form select[name="NEC"], #daycare-form select[name="NNJTreatment"], #daycare-form input[name="ultrasoundabdominal"], #daycare-form select[name="TherapeuticHypothermia"], #daycare-form select[name="Seizures"], #daycare-form input[name="neuro_sonogram"], #daycare-form input[name="ultrasound_spine"], #daycare-form input[name="mrict_brain_status"], #daycare-form input[name="eeg_cfm"], #daycare-form input[name="renalultrasound"], #daycare-form input[name="Hypoglycemia"], #daycare-form input[name="Hyperglycemia"], #daycare-form input[name="InsulinTherapy"], #daycare-form input[name="Hyponatremia"], #daycare-form input[name="Hypernatremia"], #daycare-form input[name="Hypokalemia"], #daycare-form input[name="Hyperkalemia"], #daycare-form input[name="Hypocalcemia"], #daycare-form input[name="Hypercalcemia"], #daycare-form input[name="Transfusion"], #daycare-form select[name="lumbar_puncture"], #daycare-form input[name="viral_meningitis"], #daycare-form select[name="PeripheralCannula"], #daycare-form select[name="Picc"], #daycare-form select[name="Uvc"], #daycare-form select[name="Uac"], #daycare-form select[name="Pac"]';
nicu_dsummary_related_fields_type_2 += ', #daycare-form input[name="BirthStatus"], #daycare-form input[name="AntenatalSteroids"], #daycare-form input[name="Resuscitation"], #daycare-form input[name="Intubation"]';
var nicudaycare_print_related_fields = '#nicu-admission-form input[name="DOB"], #nicu-admission-form input[name="g_weeks"], #nicu-admission-form input[name="g_days"], #nicu-admission-form input[name="BabyBloodGroup"], #nicu-admission-form select[name="Sex"]';
nicudaycare_print_related_fields += ', #daycare-form input[name="BabyName"], #daycare-form input[name="BMrNo"], #daycare-form input[name="DOB"], #daycare-form input[name="DayOfLife"], #daycare-form input[name="cg_weeks"], #daycare-form input[name="cg_days"], #daycare-form select[name="Care"], #daycare-form select[name="Sex"], #daycare-form input[name="DayDate"], #daycare-form select[name="DayTime"], #daycare-form select[name="DayTime_MINS"], #daycare-form select[name="DayTime_AM"], #daycare-form select[name="Ventilation_choose"], #daycare-form select[name="ModeOfVentilation"], #daycare-form input[name="PIP"], #daycare-form input[name="PEEP"], #daycare-form input[name="MAP"], #daycare-form input[name="FiO2"], #daycare-form input[name="Rate"], #daycare-form input[name="IT"], #daycare-form select[name^="Indication"], #daycare-form input[name="RR"], #daycare-form input[name="DayCharacter"], #daycare-form textarea[name="CXRFindings"], #daycare-form select[name="TypeOfBloodGas"], #daycare-form select[name="LastBG_Time"], #daycare-form select[name="LastBG_Time_MINS"], #daycare-form select[name="LastBG_Time_AM"], #daycare-form input[name="Ph"], #daycare-form input[name="PaO2"], #daycare-form input[name="PaCo2"], #daycare-form input[name="HCO3"], #daycare-form input[name="BE"], #daycare-form input[name="Lactate"], #daycare-form select[name="Size"], #daycare-form input[name="Lips"], #daycare-form input[name="SaO2PostDuctal"], #daycare-form input[name="AaDO2"], #daycare-form input[name="OI"], #daycare-form textarea[name="RSFindings"], #daycare-form input[name="HR"], #daycare-form input[name="systolic_bp"], #daycare-form input[name="diastolic_bp"], #daycare-form input[name="MeanBP"], #daycare-form input[name="CharacterOfMurmur"], #daycare-form textarea[name="CVSFindings"], #daycare-form input[name="CentralTemperature"], #daycare-form input[name="PeripheralTemperature"], #daycare-form input[name="Dopamine"], #daycare-form input[name="Dobutamine"], #daycare-form input[name="Adrenaline"], #daycare-form input[name="Noradrenaline"], #daycare-form input[name="Milrinone"], #daycare-form textarea[name="DayEcho"], #daycare-form input[name="Volume"], #daycare-form select[name="Frequency"], #daycare-form input[name="Feeds"], #daycare-form input[name="Ivf"], #daycare-form input[name="AspirateVolume"], #daycare-form select[name="AspirateNature"], #daycare-form select[name="StoolNature"], #daycare-form input[name="AbdominalGirth"], #daycare-form input[name="PAFindings"], #daycare-form select[name="Umbilicus"], #daycare-form input[name="LiverSpan"], #daycare-form input[name="SpleenSpan"], #daycare-form select[name="Herina"], #daycare-form input[name="Genitalia"], #daycare-form input[name="TSB"], #daycare-form input[name="BabyBloodGroup"], #daycare-form input[name="MotherBloodGroup"], #daycare-form textarea[name="AxrFindings"], #daycare-form input[name="head_circumference"], #daycare-form select[name="Activity"], #daycare-form select[name="Tone"], #daycare-form select[name="Cry"], #daycare-form input[name="TypeOfSeizures"], #daycare-form textarea[name="CnsFindings"], #daycare-form textarea[name="Cuss"], #daycare-form input[name="TotalFluid"], #daycare-form input[name="PreviousWt"], #daycare-form input[name="CurrentWt"], #daycare-form input[name="WtChange"], #daycare-form input[name="PercentageChange"], #daycare-form input[name="length"], #daycare-form input[name="UO"], #daycare-form input[name="BloodOut"], #daycare-form input[name="DrainOutput"], #daycare-form input[name="RBS"], #daycare-form select[name="Sepsis"], #daycare-form select[name^="A_Antibiotic"], #daycare-form input[name^="A_Day"], #daycare-form input[name="CRP"], #daycare-form input[name="TLC"], #daycare-form input[name="Percentage"], #daycare-form input[name="ANC"], #daycare-form input[name="Platelets"], #daycare-form select[name^="drugs"], #daycare-form select[name^="Organism"], #daycare-form input[name="PositiveBlood"], #daycare-form select[name="Meningitis"], #daycare-form textarea[name="Skin"], #daycare-form textarea[name="Rop"], #daycare-form textarea[name="Plan"]';
nicudaycare_print_related_fields += ', #baby_reg_form input[name="BabyName"], #baby_reg_form input[name="DOB"], #baby_reg_form select[name="Sex"], #baby_reg_form input[name="g_weeks"], #baby_reg_form input[name="g_days"], #baby_reg_form select[name="BabyBloodGroup"]';
nicudaycare_print_related_fields += ', #neonatalPerforma-form input[name="BabyName"], #neonatalPerforma-form input[name="DOB"], #neonatalPerforma-form input[name="g_weeks"], #neonatalPerforma-form input[name="g_days"], #neonatalPerforma-form select[name="BabyBloodGroup"], #neonatalPerforma-form select[name="Sex"], #neonatalPerforma-form select[name="MotherBloodGroup"], #neonatalPerforma-form textarea[name="Background"]';
var nicudaycare_print_related_fields_type_2 = '#daycare-form select[name="InvasiveVentilation"], #daycare-form select[name="NonInvasiveVentilation"], #daycare-form select[name="OtherRespiratorySupport"], #daycare-form select[name="Spontaneouslyventilating"], #daycare-form select[name="Retractions"], #daycare-form select[name="AirEntry"], #daycare-form select[name="ChestMovement"], #daycare-form select[name="AddedSounds"], #daycare-form select[name="EtTube"], #daycare-form select[name="PulsePressure"], #daycare-form select[name="CentralPulses"], #daycare-form select[name="FemoralPulses"], #daycare-form select[name="PrecordialActivity"], #daycare-form select[name="S1S2"], #daycare-form select[name="Murmur"], #daycare-form select[name="CFT"], #daycare-form select[name="Color"], #daycare-form select[name="Inotropes"], #daycare-form select[name="Tpn"], #daycare-form select[name="Stools"], #daycare-form select[name="BowelSounds"], #daycare-form select[name="Hepatomegaly"], #daycare-form select[name="Splenomegaly"], #daycare-form select[name="NNJTreatment"], #daycare-form select[name="AnteriorFontanelle"], #daycare-form select[name="Seizures"], #daycare-form select[name="Transfusion"], #daycare-form select[name="BloodCulture"], #daycare-form select[name="PeripheralCannula"], #daycare-form select[name="Picc"], #daycare-form select[name="Uvc"], #daycare-form select[name="Uac"], #daycare-form select[name="Pac"]';
var nicu_print_related_fields = '#nicu-admission-form input[name="BabyName"], #nicu-admission-form input[name="BMrNo"], #nicu-admission-form input[name="DOB"], #nicu-admission-form input[name="BirthWeight"], #nicu-admission-form input[name="g_weeks"], #nicu-admission-form input[name="g_days"], #nicu-admission-form select[name="Sex"], #nicu-admission-form input[name="ReferredBy"], #nicu-admission-form input[name="ReferralReason"], #nicu-admission-form input[name="cg_weeks"], #nicu-admission-form input[name="cg_days"], #nicu-admission-form input[name="AdmissionDate"], #nicu-admission-form select[name="AdmissionTime"], #nicu-admission-form select[name="AdmissionTime_MINS"], #nicu-admission-form select[name="AdmissionTime_AM"], #nicu-admission-form select[name="TypeOfCare"], #nicu-admission-form input[name="AgeOnAdmissioninDays"], #nicu-admission-form input[name="AgeOnAdmissionhour"], #nicu-admission-form select[name="Surgeon"], #nicu-admission-form select[name^="Problems"], #nicu-admission-form input[name^="Medications"], #nicu-admission-form select[name="Smoking"], #nicu-admission-form select[name="Alcohol"], #nicu-admission-form select[name="Tobacco"], #nicu-admission-form select[name^="Complication"], #nicu-admission-form input[name^="Treatments"], #nicu-admission-form input[name="datinggestations"], #nicu-admission-form input[name="datingfindings"], #nicu-admission-form input[name="analoggestations"], #nicu-admission-form input[name="analogfindings"], #nicu-admission-form input[name^="nothergestations"], #nicu-admission-form input[name^="notherfindings"], #nicu-admission-form input[name^="othergestations"], #nicu-admission-form input[name^="otherfindings"], #nicu-admission-form input[name^="dopplergestations"], #nicu-admission-form input[name^="dopplerfindings"], #nicu-admission-form textarea[name="DescriptionOfResuscitation"], #nicu-admission-form select[name="SurfactantGiven"], #nicu-admission-form select[name="SurfactantType"], #nicu-admission-form input[name="Dose"], #nicu-admission-form select[name="TimeOfAdministration"], #nicu-admission-form select[name="TimeOfAdministration_MINS"], #nicu-admission-form select[name="TimeOfAdministration_AM"], #nicu-admission-form input[name="AgeAfterBirth", #nicu-admission-form input[name="oxgen_flow"], #nicu-admission-form input[name="TransferFiO2"], #nicu-admission-form select[name="AdmittedFrom"], #nicu-admission-form textarea[name="MajorComplaints"], #nicu-admission-form select[name="Mode"], #nicu-admission-form input[name="Pip"], #nicu-admission-form input[name="PEEP"], #nicu-admission-form input[name="Rate"], #nicu-admission-form input[name="IT"], #nicu-admission-form input[name="Fio2"], #nicu-admission-form input[name="RR"], #nicu-admission-form select[name="ChestMovement"], #nicu-admission-form input[name="HR"], #nicu-admission-form input[name="BP"], #nicu-admission-form input[name="MeanBP"], #nicu-admission-form select[name="CFT"], #nicu-admission-form input[name="Temperature"], #nicu-admission-form select[name="Tone"], #nicu-admission-form textarea[name="Abnormalities"], #nicu-admission-form select[name="InitialBloodGas"], #nicu-admission-form input[name="SpO2"], #nicu-admission-form input[name="pH"], #nicu-admission-form input[name="PaO2"], #nicu-admission-form input[name="PaCo2"], #nicu-admission-form input[name="HCO3"], #nicu-admission-form input[name="BE"], #nicu-admission-form input[name="RBS"], #nicu-admission-form input[name="Hct"], #nicu-admission-form select[name="InitialXray"], #nicu-admission-form input[name="xrayfindings"], #nicu-admission-form input[name="AgeofCXR"], #nicu-admission-form input[name="UACPosition"], #nicu-admission-form input[name="UVCPosition"], #nicu-admission-form select[name="SepsisScreen"], #nicu-admission-form input[name="Indications"], #nicu-admission-form select[name^="IVAntibiotic"], #nicu-admission-form input[name="Investigations"], #nicu-admission-form input[name="Fluids"], #nicu-admission-form select[name="NBM"], #nicu-admission-form input[name="TotalCRIB2Score"], #nicu-admission-form input[name="TotalSNAPPE2Score"], #nicu-admission-form select[name^="DifferentialDiagnosis"], #nicu-admission-form input[name^="additional_diagnosis"], #nicu-admission-form textarea[name="Plan"], #nicu-admission-form select[name="TimeOfDiscussion"], #nicu-admission-form select[name="TimeOfDiscussion_MINS"], #nicu-admission-form select[name="TimeOfDiscussion_AM"], #nicu-admission-form textarea[name="MattersDiscussed"]';
nicu_print_related_fields += ', #baby_reg_form input[name="BMrNo"], #baby_reg_form input[name="BabyName"], #baby_reg_form input[name="DOB"], #baby_reg_form select[name="TOB_TIME"], #baby_reg_form select[name="TOB_MINS"], #baby_reg_form select[name="TOB_AM"], #baby_reg_form select[name="BirthOrder"], #baby_reg_form select[name="Sex"], #baby_reg_form input[name="g_weeks"], #baby_reg_form input[name="g_days"], #baby_reg_form input[name="BirthWeight"], #baby_reg_form select[name^="neonatal_consultant"]';
nicu_print_related_fields += ', .mother_registration_form input[name="MMrNo"], .mother_registration_form input[name="MotherName"], .mother_registration_form input[name="MothercYear"], .mother_registration_form input[name="Mobile"], .mother_registration_form input[name="MotherSpokenLanguages"], .mother_registration_form input[name="PartnerContact"], .mother_registration_form input[name="Address1"], .mother_registration_form input[name="Address2"], .mother_registration_form input[name="Address3"], .mother_registration_form input[name="Address4"]';
nicu_print_related_fields += ', #neonatalPerforma-form input[name="BabyName"], #neonatalPerforma-form input[name="DOB"], #neonatalPerforma-form select[name="TOB_TIME"], #neonatalPerforma-form select[name="TOB_MINS"], #neonatalPerforma-form select[name="TOB_AM"], #neonatalPerforma-form input[name="BirthWeight"], #neonatalPerforma-form input[name="g_weeks"], #neonatalPerforma-form input[name="g_days"], #neonatalPerforma-form select[name="Sex"], #neonatalPerforma-form select[name^="Problems"], #neonatalPerforma-form input[name^="Medications"], #neonatalPerforma-form input[name="G_Value"], #neonatalPerforma-form input[name="P_Value"], #neonatalPerforma-form input[name="L_Value"], #neonatalPerforma-form input[name="A_Value"], #neonatalPerforma-form input[name^="Year"], #neonatalPerforma-form input[name^="Place"], #neonatalPerforma-form select[name^="Delivery"], #neonatalPerforma-form input[name^="Complications"], #neonatalPerforma-form select[name^="Gender"], #neonatalPerforma-form input[name^="GA"], #neonatalPerforma-form input[name^="BW"], #neonatalPerforma-form select[name^="Health"], #neonatalPerforma-form input[name^="details"], #neonatalPerforma-form select[name="Conception"], #neonatalPerforma-form input[name="LMP"], #neonatalPerforma-form input[name="EDDbyUSG"], #neonatalPerforma-form input[name="EDDbyDates"], #neonatalPerforma-form select[name="MotherBloodGroup"], #neonatalPerforma-form input[name="PlaceofSupervision"], #neonatalPerforma-form select[name^="Complication"], #neonatalPerforma-form input[name^="Treatments"], #neonatalPerforma-form input[name^="duration_in_weeks"], #neonatalPerforma-form select[name^="duration_unit"], #neonatalPerforma-form input[name="datinggestations"], #neonatalPerforma-form input[name="datingfindings"], #neonatalPerforma-form input[name="analoggestations"], #neonatalPerforma-form input[name="analogfindings"], #neonatalPerforma-form input[name^="othergestations"], #neonatalPerforma-form input[name^="otherfindings"], #neonatalPerforma-form input[name^="dopplergestations"], #neonatalPerforma-form input[name^="dopplerfindings"], #neonatalPerforma-form select[name="CommentOnLiquor"], #neonatalPerforma-form input[name="maternal_pyrexia_celsius"], #neonatalPerforma-form input[name="maternal_pyrexia_fahrenheit"], #nicu-admission-form select[name="DurationOfROM"], #nicu-admission-form select[name="TimeofLastDose"], #nicu-admission-form #apgarform .widget-content, #nicu-admission-form select[name="ModeOfDelivery"], #nicu-admission-form select[name^="Indication"], #nicu-admission-form select[name="Presentation"], #nicu-admission-form select[name="FoetalDistress"], #nicu-admission-form input[name="CTGDetails"], #nicu-admission-form select[name="CordBloodGas"], #nicu-admission-form input[name="CordpH"], #nicu-admission-form input[name="CordHCO3"], #nicu-admission-form input[name="CordBE"], #nicu-admission-form select[name="GastricAspirate"], #nicu-admission-form input[name="TimeOf1stGasp"], #nicu-admission-form input[name="RegularRespiration"], #nicu-admission-form input[name="DurationOfOxygen"], #nicu-admission-form input[name="DepthOfInsertion"], #nicu-admission-form input[name="DurationOfPPV"], #nicu-admission-form select[name="Malformation"], #nicu-admission-form textarea[name="MalformationType"]';
var nicu_print_related_fields_type_2 = '#nicu-admission-form input[name="VentilationRequired"], #nicu-admission-form input[name="Ventilation"], #nicu-admission-form input[name="UAC"], #nicu-admission-form input[name="UVC"], #nicu-admission-form input[name="ParentsSpokenTo"]';
nicu_print_related_fields_type_2 += ', #nicu-admission-form select[name="HIV"], #nicu-admission-form select[name="HepatitisB"], #nicu-admission-form select[name="VDRL"], #nicu-admission-form input[name="Supervised"], #nicu-admission-form input[name="PregnancyComplications"], #nicu-admission-form input[name="AntenatalSteroids"], #nicu-admission-form select[name="LastDoseDeliveryInterval"], #nicu-admission-form input[name="Labour"], #nicu-admission-form select[name="NatureofLabour"], #nicu-admission-form input[name="MaternalPyrexia"], #nicu-admission-form input[name="PROM"], #nicu-admission-form select[name="CTG"], #nicu-admission-form select[name="Resuscitation"], #nicu-admission-form input[name="FacialOxygen"], #nicu-admission-form input[name="Intubation"], #nicu-admission-form select[name="ETTSize"], #nicu-admission-form select[name="PPV"], #nicu-admission-form input[name="CPR"], #nicu-admission-form input[name="Drugs"], #nicu-admission-form input[name="VitaminK"], #nicu-admission-form input[name="DoseVitK"], #nicu-admission-form input[name="RouteVitK"]';
var neonatal_print_related_fields = '#baby_reg_form input[name="BMrNo"], #baby_reg_form input[name="BabyName"], #baby_reg_form input[name="DOB"], #baby_reg_form select[name="TOB_TIME"], #baby_reg_form select[name="TOB_MINS"], #baby_reg_form select[name="TOB_AM"], #baby_reg_form select[name="BirthOrder"], #baby_reg_form select[name="Sex"], #baby_reg_form input[name="g_weeks"], #baby_reg_form input[name="g_days"], #baby_reg_form input[name="BirthWeight"], #baby_reg_form select[name="BabyBloodGroup"], #baby_reg_form select[name^="neonatal_consultant"]';
neonatal_print_related_fields += ', .mother_registration_form input[name="MMrNo"], .mother_registration_form input[name="MotherName"], .mother_registration_form input[name="MothercYear"], .mother_registration_form input[name="Mobile"], .mother_registration_form input[name="PartnerContact"], .mother_registration_form input[name="Address1"], .mother_registration_form input[name="Address2"], .mother_registration_form input[name="Address3"], .mother_registration_form input[name="Address4"]';
neonatal_print_related_fields += ', #neonatalPerforma-form input[name="TestDate"], #neonatalPerforma-form input[name="BabyName"], #neonatalPerforma-form input[name="DOB"], #neonatalPerforma-form select[name="TOB_TIME"], #neonatalPerforma-form select[name="TOB_MINS"], #neonatalPerforma-form select[name="TOB_AM"], #neonatalPerforma-form input[name="BirthWeight"], #neonatalPerforma-form input[name="g_weeks"], #neonatalPerforma-form input[name="g_days"], #neonatalPerforma-form select[name="BabyBloodGroup"], #neonatalPerforma-form select[name="BirthOrder"], #neonatalPerforma-form select[name="Sex"], #neonatalPerforma-form input[name="Length"], #neonatalPerforma-form input[name="OFC"], #neonatalPerforma-form input[name="MotherName"], #neonatalPerforma-form input[name="MothercYear"], #neonatalPerforma-form input[name="Mobile"], #neonatalPerforma-form input[name="Address1"], #neonatalPerforma-form input[name="Address2"], #neonatalPerforma-form input[name="Address3"], #neonatalPerforma-form input[name="Address4"], #neonatalPerforma-form input[name="PartnerContact"], #neonatalPerforma-form select[name^="Problems"], #neonatalPerforma-form input[name^="Medications"], #neonatalPerforma-form input[name="G_Value"], #neonatalPerforma-form input[name="P_Value"], #neonatalPerforma-form input[name="L_Value"], #neonatalPerforma-form input[name="A_Value"], #neonatalPerforma-form input[name^="Year"], #neonatalPerforma-form input[name^="Place"], #neonatalPerforma-form select[name^="Delivery"], #neonatalPerforma-form input[name^="Complications"], #neonatalPerforma-form select[name^="Gender"], #neonatalPerforma-form input[name^="GA"], #neonatalPerforma-form input[name^="BW"], #neonatalPerforma-form select[name^="Health"], #neonatalPerforma-form input[name^="details"], #neonatalPerforma-form select[name="Conception"], #neonatalPerforma-form input[name="LMP"], #neonatalPerforma-form input[name="EDDbyUSG"], #neonatalPerforma-form input[name="EDDbyDates"], #neonatalPerforma-form select[name="MotherBloodGroup"], #neonatalPerforma-form input[name="PlaceofSupervision"], #neonatalPerforma-form input[name="OtherInvestigations"], #neonatalPerforma-form select[name^="Complication"], #neonatalPerforma-form input[name^="Treatments"], #neonatalPerforma-form input[name^="duration_in_weeks"], #neonatalPerforma-form select[name^="duration_unit"], #neonatalPerforma-form input[name="datinggestations"], #neonatalPerforma-form input[name="datingfindings"], #neonatalPerforma-form input[name="analoggestations"], #neonatalPerforma-form input[name="analogfindings"], #neonatalPerforma-form input[name^="othergestations"], #neonatalPerforma-form input[name^="otherfindings"], #neonatalPerforma-form input[name^="dopplergestations"], #neonatalPerforma-form input[name^="dopplerfindings"], #neonatalPerforma-form select[name="CommentOnLiquor"], #nicu-admission-form select[name="DurationOfROM"], #nicu-admission-form select[name="TimeofLastDose"], #nicu-admission-form #apgarform .widget-content,  #nicu-admission-form select[name="ModeOfDelivery"], #nicu-admission-form select[name^="Indication"], #nicu-admission-form select[name="Presentation"], #nicu-admission-form select[name="FoetalDistress"], #nicu-admission-form input[name="CTGDetails"], #nicu-admission-form select[name="CordBloodGas"], #nicu-admission-form input[name="CordpH"], #nicu-admission-form input[name="CordHCO3"], #nicu-admission-form input[name="CordBE"], #nicu-admission-form select[name="GastricAspirate"], #nicu-admission-form input[name="TimeOf1stGasp"], #nicu-admission-form input[name="RegularRespiration"], #nicu-admission-form input[name="DurationOfOxygen"], #nicu-admission-form input[name="DepthOfInsertion"], #nicu-admission-form input[name="DurationOfPPV"], #nicu-admission-form textarea[name="InitialExamination"], #nicu-admission-form select[name="Malformation"], #nicu-admission-form textarea[name="MalformationType"] #nicu-admission-form textarea[name="PLAN"]';
var neonatal_print_related_fields_type_2 = '#nicu-admission-form select[name="HIV"], #nicu-admission-form select[name="HepatitisB"], #nicu-admission-form select[name="VDRL"], #nicu-admission-form select[name="Supervised"], #nicu-admission-form input[name="PregnancyComplications"], #nicu-admission-form input[name="AntenatalSteroids"], #nicu-admission-form select[name="LastDoseDeliveryIn"], #nicu-admission-form input[name="Labour"], #nicu-admission-form select[name="NatureofLabour"], #nicu-admission-form input[name="MaternalPyrexia"], #nicu-admission-form input[name="PROM"], #nicu-admission-form input[name="Resuscitation"], #nicu-admission-form input[name="FacialOxygen"], #nicu-admission-form input[name="Intubation"], #nicu-admission-form select[name="ETTSize"], #nicu-admission-form input[name="PPV"], #nicu-admission-form input[name="CPR"], #nicu-admission-form input[name="Drugs"], #nicu-admission-form input[name="VitaminK"], #nicu-admission-form input[name="DoseVitK"], #nicu-admission-form input[name="RouteVitK"]';
addFieldHighlighter();

function addFieldHighlighter() {
    var high_light = $('#high_light').val();
    high_light = typeof high_light != 'undefined' ? JSON.parse($('#high_light').val()) : '';
    $.each(high_light, function(key, value) {
        if (value == 2) {
            switch (key) {
                case "neonatal_highlight":
                    $(neonatal_print_related_fields).addClass('print-highlighter');
                    $(neonatal_print_related_fields_type_2).parent().addClass('print-highlighter');
                    break;
                case "nicu_highlight":
                    $(nicu_print_related_fields).addClass('nicu-print-highlighter');
                    $(nicu_print_related_fields_type_2).parent().addClass('nicu-print-highlighter');
                    break;
                case "nicu_daycare_highlight":
                    $(nicudaycare_print_related_fields).addClass('nicudaycare-print-highlighter');
                    $(nicudaycare_print_related_fields_type_2).parent().addClass('nicudaycare-print-highlighter');
                    break;
                case "daycare_summary_highlight":
                    $(nicu_dsummary_related_fields).addClass('nicu-dsummary-highlighter');
                    $(nicu_dsummary_related_fields_type_2).parent().addClass('nicu-dsummary-highlighter');
                    break;
                case "prblm_summary_highlight":
                    $(nicu_pblmsummary_related_fields).addClass('nicu-pblmsummary-highlighter');
                    $(nicu_pblmsummary_related_fields_type_2).parent().addClass('nicu-pblmsummary-highlighter');
                    break;
                case "post_adm_highlight":
                    $(post_adm_related_fields).addClass('post-adm-highlighter');
                    $(post_adm_related_fields_type_2).parent().addClass('post-adm-highlighter');
                    break;
                case "post_daycare_adm_highlight":
                    $(post_daycare_adm_related_fields).addClass('post-daycare-adm-highlighter');
                    $(post_daycare_adm_related_fields_type_2).parent().addClass('post-daycare-adm-highlighter');
                    break;
                case "post_summary_highlight":
                    $(post_summary_related_fields).addClass('post-summary-highlighter');
                    $(post_summary_related_fields_type_2).parent().addClass('post-summary-highlighter');
                    break;
                case "op_highlight":
                    $(op_related_fields).addClass('op-highlighter');
                    break;
            }
        }
    });
}

function isNumber(evt, element) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if ((charCode != 46 || $(element).val().indexOf('.') != -1) && (charCode < 48 || charCode > 57)) return false;
    return true;
}

function ISNumber(e, element) {
    var code = (e.which) ? e.which : e.keyCode;
    if (code > 31 && (code < 48 || code > 57)) {
        e.preventDefault();
    }
}
$(document).on('click, mouseleave, focusout, focus', '.bs-tooltip, body', function()
{
    $('.tooltip').hide();
});
$(document).on('click', '.widget-header a:not(#add_vaccine_generic_name, .not-disabled, .btn-custom-pacs), .select-option-container .cancel-btn', function() {
    $(this).css({
        'cursor': 'not-allowed',
        'pointer-events': 'none',
        'opacity': 0.8
    });
    $(this).children('i').attr('class', 'fas fa-spinner fa-pulse');
});
$(document).on('click', 'td a.btn-warning, .view_baby_icon, .edit-content-link', function() {
    $(this).css({
        'cursor': 'not-allowed',
        'pointer-events': 'none',
        'opacity': 0.8
    });
});
$(document).on('click', '#search, #search-form .input-group a', function() {
    $(this).css({
        'cursor': 'not-allowed',
        'pointer-events': 'none',
        'opacity': 0.8
    });
});
// $(document).on('click', '.breadcrumb, .custom-logo-container, .nav.navbar-nav.navbar-left', function() {
//     $(this).css({'cursor' : 'not-allowed', 'pointer-events' : 'none', 'opacity' : 0.8});
// });
$(document).on('click', '.cancel-btn-opt', function() {
    $(this).children('i').attr('class', 'fas fa-spinner fa-pulse');
    $(this).css({
        'cursor': 'not-allowed',
        'pointer-events': 'none',
        'opacity': 0.8
    });
});
var base_url = $("input[name='site_base_url']").val();
var settings = [base_url + '/usergroups', base_url + '/users', base_url + '/site', base_url + '/problems-settings'];
var master_base_url = base_url + '/masters';
var masters = [master_base_url + '/antibiotics', master_base_url + '/complications', master_base_url + '/medicalproblems', master_base_url + '/nicu-procedures', master_base_url + '/medical-problems', master_base_url + '/vaccines', master_base_url + '/icd', master_base_url + '/indication', master_base_url + '/doctors-list', master_base_url + '/admission-mode', master_base_url + '/respiratory-indication', master_base_url + '/booking-place', master_base_url + '/nurse', master_base_url + '/referral-doctor', master_base_url + '/ward', master_base_url + '/bed', master_base_url + '/frequency', master_base_url + '/drugivfluid', master_base_url + '/prescriptiontype'];
$(".hover-fx").each(function() {
    if (this.href == window.location.href) {
        $(this).addClass("active-menu");
    }
    if ($.inArray(window.location.href, settings) >= 0) {
        $('.settings .hover-fx').addClass("active-menu");
    }
    if ($.inArray(window.location.href, masters) >= 0) {
        $('.masters .hover-fx').addClass("active-menu");
    }
});
$(".master-drop-down li a").each(function() {
    if (this.href == window.location.href) {
        $(this).addClass("top-active-menu");
    }
    if (base_url + '/profile' == window.location.href) {
        $('.admin-profile a').addClass("active-menu");
    }
});
$('input[onkeypress]').bind('paste', function(e)
{
    e.preventDefault();
});
var request_url_is_busy = false;
$('#notification-footer').css('display', 'none');
$('.notification-title-container').addClass('full-width')
$('.notification-content, .notification-icon').addClass('display-none-must');
$('#notification-footer-open').addClass('display-none-must');
var notification_is_closed = false;
// dsnStatus();
// setInterval(function() {
//     dsnStatus();
// }, 5000);

function dsnStatus() {
    if (!request_url_is_busy) {
        request_url_is_busy = true;
        $.ajax({
            type: "GET",
            url: base_url + '/dsn-current-status',
            success: function(response) {
                var results = response.result;
                var content = '';
                var results_count = 0;
                $('.card-pf').removeClass('connection-error');
                $('.card-pf .card-pf-item .fas').removeClass('text-error');
                $.each(results, function(key, value) {
                    var baby_mrn = value.BMrNo;
                    var baby_mrn = value.BMrNo;
                    var baby_name = value.BabyName;
                    var device_name = value.device_type;
                    var dsn_status_id = value.dsn_status_id;
                    var bed_id = value.bed_id;
                    var ward_id = value.ward_id;
                    var baby_id = value.baby_id;
                    var admiddion_id = value.AdmissionId;
                    if (results_count == 0) {
                        content += '<a id="bed-no-' + bed_id + '" class="text-captialize" data-bed-no="' + bed_id + '" data-ward-no="' + ward_id + '" data-id="' + dsn_status_id + '" data-mrn="' + baby_mrn + '" data-babyname="' + baby_name + '" data-baby-id="' + baby_id + '" data-admission-id="' + admiddion_id + '"><span class="bed-notification">' + bed_id + '</span>' + baby_name + '</a>';
                    } else {
                        content += '<a id="bed-no-' + bed_id + '" class="notification-strip text-captialize" data-bed-no="' + bed_id + '" data-ward-no="' + ward_id + '" data-id="' + dsn_status_id + '" data-mrn="' + baby_mrn + '" data-babyname="' + baby_name + '" data-baby-id="' + baby_id + '" data-admission-id="' + admiddion_id + '"><span class="bed-notification">' + bed_id + '</span>' + baby_name + '</a>';
                    }
                    results_count++;
                    $('#bed-layout-' + bed_id + ' .card-pf').addClass('connection-error');
                    if (device_name.indexOf('MINDRAY_N') > -1) {
                        $('#bed-layout-' + bed_id + ' .card-pf-item:first-child .fas').addClass('text-error');
                    } else if (device_name.indexOf('SLE') > -1) {
                        $('#bed-layout-' + bed_id + ' .card-pf-item:nth-child(2) .fas').addClass('text-error');
                        // } else if (device_name.indexOf('PUMP') > -1) {
                        // 	$('#bed-layout-'+bed_id+' .card-pf-item:last-child .fas').addClass('text-error');
                    }
                });
                if (results_count > 0 && !notification_is_closed) {
                    $('.notification-title-container').removeClass('full-width');
                    $('.notification-content, .notification-icon').removeClass('display-none-must');
                    $('#notification-text').html(content);
                    $('#notification-footer').addClass('notification-footer-display').css('display', 'flex');
                } else if (!notification_is_closed) {
                    $('#notification-footer').removeClass('notification-footer-display').css('display', 'none');
                }
            },
            complete: function() {
                request_url_is_busy = false;
            }
        });
    }
}
$(document).on('click', '#notification-text a', function() {
    var id = $(this).attr('data-id');
    var mrn = $(this).attr('data-mrn');
    var bedno = $(this).attr('data-bed-no');
    var wardno = $(this).attr('data-ward-no');
    var babyname = $(this).attr('data-babyname');
    var babyid = $(this).attr('data-baby-id');
    var admissionid = $(this).attr('data-admission-id');
    $('input[name="bed_no"]').val(bedno);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        data: {
            mrn: mrn
        },
        url: base_url + '/dsn-connect-device',
        success: function(response) {
            var results = response.result;
            var content = '<table class="table table-bordered table-striped">';
            content += '<thead>';
            content += '<tr>';
            content += '<td>Device Name</td>';
            content += '<td>Verify</td>';
            content += '</tr>';
            content += '</thead>';
            content += '<tbody>';
            $('input[name="device_count"]').val(results.length);
            $.each(results, function(key, value) {
                content += '<tr>';
                content += '<td>' + value + '</td>';
                content += '<td><input type="checkbox" name="' + value + '" value="' + mrn + '" /></td>';
                content += '</tr>';
            });
            content += '</tbody>';
            content += '</table>';
            $('#disconnect-post div.col-md-12').html(content);
            $('#dsn-modal .disconnect-baby-name').html('Baby Name : ' + babyname);
            $('#dsn-modal .disconnect-bed').html('Bed No : ' + bedno);
            $('#dsn-modal #baby-discharge').attr('data-bed-no', bedno);
            $('#dsn-modal #baby-discharge').attr('data-ward-no', wardno);
            $('#dsn-modal #baby-discharge').attr('data-baby-id', babyid);
            $('#dsn-modal #baby-discharge').attr('data-admission-id', admissionid);
            $('#dsn-modal').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
        }
    });
});
$(document).on('click', '#disconnect-post input[type="checkbox"]', function() {
    var checkbox_status = $(this).is(':checked');
    var device_name = $(this).attr('name');
    var mrn = $(this).val();
    var bed_no = $('#disconnect-post input[name="bed_no"]').val();
    var device_count = $('#disconnect-post input[name="device_count"]').val();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'PATCH',
        data: {
            mrn: mrn,
            device_name: device_name
        },
        url: base_url + '/disconnect-status-update',
        success: function(response) {
            if (response.messageType == 'success') {
                device_count = device_count - 1;
                $('#disconnect-post input[name="device_count"]').val(device_count);
                if (device_count == 0) {
                    dsnStatus();
                    if ($('#notification-text a').length == 0) {
                        $('#notification-footer').removeClass('notification-footer-display').css('display', 'none');
                    }
                    $('#dsn-modal').modal('toggle');
                }
            }
        }
    });
});
$('#notification-footer-close').on('click', function() {
    $('#notification-footer-close').addClass('display-none-must');
    $('#notification-footer').removeClass('notification-footer-display').toggle();
    $('#notification-footer-open').removeClass('display-none-must');
    notification_is_closed = true;
    $('#notification-text').html('');
});
$('#notification-footer-open').on('click', function() {
    $('#notification-footer-open').addClass('display-none-must');
    $('#notification-footer').toggle();
    $('#notification-footer-close').removeClass('display-none-must');
    notification_is_closed = false;
    dsnStatus();
});
window.addEventListener("pageshow", function(event) {
    var historyTraversal = event.persisted || (typeof window.performance != "undefined" && window.performance.navigation.type === 2);
    if (historyTraversal) {
        $('#content .widget-header a, #content .widget-header button').each(function() {
            $(this).css({
                'cursor': '',
                'pointer-events': '',
                'opacity': '1'
            });
            $(this).children('i').removeClass('class', 'fa-spinner');
            $(this).children('i').removeClass('class', 'fa-spin');
        });
        // var neonatal_create = window.location.href.indexOf('neonatal/create');
        // if (neonatal_create > 0) {
        // 	var table_name = 'neonatal_proforma';		
        // 	var column_name_to_compare = 'BabyId';	
        // 	var primary_column_name = 'NeonatalId';	
        // 	var id = window.location.href;
        // 		id = id.split('neonatal/create/')[1];
        // 	$.ajax({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         type: 'GET',
        //         data: {table_name: table_name, column_name_to_compare: column_name_to_compare, id: id, primary_column_name: primary_column_name},
        // 		url: base_url+'/check-record-is-exists',
        //         success: function(response) {
        //         	if (response.messageType == 'success') {
        //         		window.location.href = response.url;
        //         	}
        //         }
        //     });
        // }
    }
});
$(document).on('click', '#baby-discharge', function() {
    var babyId = $(this).attr('data-baby-id');
    var admissionId = $(this).attr('data-admission-id');
    var ward_id = $(this).attr('data-ward-no');
    var slug = 'REMOVE_BED_PUMP';
    babyDischarge(babyId, admissionId, ward_id);
});

function babyDischarge(babyId, admissionId, ward_id) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: "GET",
        url: base_url + "/discharge-baby",
        data: {
            babyId: babyId,
            admissionId: admissionId,
            ward_id: ward_id
        },
        success: function(response) {
            if (response.type == 'success') {
                window.location = response.url
            }
        },
        error: function(response) {
            response = JSON.parse(response.responseText);
            Showalert(response.type, response.message);
        }
    });
}
$(document).ready(function() {
    $('.corrected-gestation-wks').parents('.form-group').slideUp();
    if (window.location.href.indexOf("daycare-admission") === -1 || !(window.location.href.indexOf("daycare-admission") !== -1 && window.location.href.indexOf("edit") === -1)) {
        $('.record-date').trigger('change');
    }
});

function calculateCorrectedGestation(chronologicalage = false)
{
    var recordDate = $('.record-date').datepicker('getDate');
    var dobDate = $('.birth-date').datepicker('getDate');
    var gestationWeeks = $('.gestation-wks').val();
    var gestationDays = $('.gestation-days').val();
    gestationDays = gestationDays == '' ? 0 : gestationDays;
    if (typeof gestationWeeks != 'undefined' && typeof gestationDays != 'undefined' && chronologicalage) {
        if (gestationWeeks >= 37) {
            $('.corrected-gestation-wks').val('0');
            $('.corrected-gestation-days').val('0');
            $('input[name="corrected_year"]').val('0');
            $('input[name="corrected_month"]').val('0');
            $('input[name="corrected_days"]').val('0');
            $('.corrected_age').parent().parent().slideUp();
        } else {
            $('.corrected_age').parent().parent().slideDown();
        }
        var chronological_age = calculateDays(dobDate, recordDate);
        var corrected_age = (40 - parseInt(gestationWeeks)) * 7;
        corrected_age = corrected_age + parseInt(gestationDays);
        corrected_age_days = chronological_age - corrected_age;
        var corrected_age_weeks = parseInt(corrected_age_days / 7);
        var corrected_age_rem_days = corrected_age_days % 7;
        if (corrected_age_weeks > 0 || (corrected_age_weeks == 0 && corrected_age_rem_days > 0)) {
            $('.corrected-gestation-wks').val(corrected_age_weeks);
            $('.corrected-gestation-days').val(corrected_age_rem_days);
        } else {
            $('.corrected-gestation-wks').val(0);
            $('.corrected-gestation-days').val(0);
        }
        if (chronologicalage) {
            var correceted_formatted_values = getFormatedStringFromDays(corrected_age_days);
            var formated_corr_years = correceted_formatted_values[0];
            if (formated_corr_years != '') {
                $('input[name="corrected_year"]').val(formated_corr_years);
            } else {
                $('input[name="corrected_year"]').val(0);
            }
            var formated_corr_months = correceted_formatted_values[1];
            if (formated_corr_months != '') {
                $('input[name="corrected_month"]').val(formated_corr_months);
            } else {
                $('input[name="corrected_month"]').val(0);
            }
            var formated_corr_days = correceted_formatted_values[2];
            if (formated_corr_days != '') {
                $('input[name="corrected_days"]').val(formated_corr_days);
            } else {
                $('input[name="corrected_days"]').val(0);
            }
        }
    } else {
        var diff_age = calculateDays(dobDate, recordDate) + (parseInt(gestationWeeks) * 7) + parseInt(gestationDays);
        var diff_wks = parseInt(diff_age / 7);
        var diff_days = diff_age - (diff_wks * 7);
        diff_wks = diff_wks > 0 ? diff_wks : 0;
        diff_days = diff_days > 0 ? diff_days : 0;
        $('.corrected-gestation-wks').val(diff_wks);
        $('.corrected-gestation-days').val(diff_days);
        if (diff_wks < 37) {
            $('.corrected-gestation-wks').parents('.form-group').slideDown();
        }
    }
    var id = $('.record-date').attr('id');
    if (id == 'DischargeDate') {
        var days = calculateDays(dobDate, recordDate);
        days = days > 0 ? days : 0;
        $('#DOLatDischarge').val(days);
    }
}
$('.editer-required').each(function()
{
    var id = $(this).attr('id');
    if (id) {
        CKEDITOR.replace(id, {
            on:
            {
                instanceReady: function(ev)
                {
                    this.dataProcessor.writer.setRules('p',
                    {
                        indent: false,
                        breakBeforeOpen: false,
                        breakAfterOpen: false,
                        breakBeforeClose: false,
                        breakAfterClose: false
                    });
                }
            }
        });
    }
});
// $('.editable-content').blur(function()
// {
// 	$(this).find('li').each(function()
// 	{
// 		var list = $(this).html();
// 		if (!list.endsWith('.<br>')) {
// 			list = list.replace('<br>', '.<br>');
// 		}
// 	});
// });
$(".add_master_data").each(function() {
    var tooltip_title = $(this).find('i').attr('data-original-title');
    $(this).find('i').attr('data-original-title', tooltip_title + ' in masters.');
});
$('select[name="room_id"]').on('change', function() {
    var room_id = $(this).val();
    var temp_bed_id = $('#temp_bed_id').val();
    temp_bed_id = JSON.parse(temp_bed_id);
    var bed_list = [];
    if (typeof temp_bed_id[room_id] != 'undefined') {
        bed_list = temp_bed_id[room_id];
    }
    var old_bed_id = $('#bed_id_old').val();
    var old_bed_no = $('#bed_no_old').val();
    var old_room_id = $('#room_id_old').val();
    var old_status = 'Occupied';
    if (room_id == old_room_id && typeof old_bed_id != 'undefined' && typeof old_bed_no != 'undefined') {
        var old_bed_details = {
            id: old_bed_id,
            number: old_bed_no,
            room_id: old_room_id,
            status: old_status
        };
        bed_list.push(old_bed_details);
    }
    // $('select[name="bed_id"]').find('option').remove();
    // $('.nicu-admission-form select[name="bed_id"]').removeClass('form-control').addClass('full-width');
    // $('.nicu-admission-form select[name="bed_id"]').select2({
    //     placeholder: "Select",
    //     placeholderOption: 'first'
    // });
    if (typeof bed_list !== 'undefined') {
        bed_list.sort(function(a, b) {
            return a.id - b.id
        });
        var duplicate = false;
        $.each(bed_list, function(key, value) {
            var id = value.id;
            var number = value.number;
            if (!duplicate) {
                if (old_bed_id == id && old_bed_no == number) {
                    duplicate = true;
                }
                $('select[name="bed_id"]').append($("<option></option>").attr("value", id).text(number));
            } else {
                duplicate = false;
            }
        });
    }
    if (room_id == old_room_id && typeof old_bed_id != 'undefined' && typeof old_bed_no != 'undefined') {
        $('select[name="bed_id"] option[value="' + old_bed_id + '"]').attr("selected", true);
    }
});
$(".post_sep_drugs_add").click(function() {
    antibiotic_select = '<select name="postnatal_other_drugs[]" class="form-control sepsis-non-antibiotic" >';
    antibiotic_select += $("select[name='a_nonantibiotic_temp']").html();
    antibiotic_select += '</select>';
    option = '<tr><td class="full-width">' + antibiotic_select + '</td>';
    option += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>';
    option += '</tr>';
    // option = '<tr><td class="full-width"><input type="text" class="form-control" name="drugs[]" value="" /></td>';
    // option += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>';
    // option += '</tr>';
    $("table.sep_drugs tbody").append(option);
});
$(document).on("click", ".investigation_add_btn", function() {
    var html = '<tr><td class="text-right"><input type="text" name="test_name[]" value="" class="form-control input-fields-shadow master_required"></td><td width="5%"><button type="button" class="btn btn-danger investigation_remove_btn"><i class="fa fa-trash"></i></button></td></tr>';
    $("table.investigations_popup_table").append(html);
});
$(document).on("click", ".investigation_remove_btn", function() {
    $(this).parents("tr").remove();
});
$(document).ready(function() {
    var status_option = '<div class="status_badge">';
    status_option += '<span id="inpatient">Inpatient</span>';
    status_option += '<span id="discharge">Discharge</span>';
    status_option += '<span id="both">Both</span>';
    status_option += '</div>';
    // $('#search').parent('.input-group').parent('div').removeClass('col-md-4').removeClass('col-xs-4').addClass('display-flex').addClass('col-md-6').append(status_option).css('flex-direction', 'row-reverse');
    $('#inpatient').on('click', function() {
        var href = window.location.href;
        href = href.replace(window.location.search, '');
        var status = $(this).attr('id');
        $('.status_badge span').removeClass('active');
        $(this).addClass('active');
        window.location.href = href + '?status=' + status;
    });
    $('#discharge').on('click', function() {
        var href = window.location.href;
        href = href.replace(window.location.search, '');
        var status = $(this).attr('id');
        $('.status_badge span').removeClass('active');
        $(this).addClass('active');
        window.location.href = href + '?status=' + status;
    });
    $('#both').on('click', function() {
        var href = window.location.href;
        href = href.replace(window.location.search, '');
        var status = $(this).attr('id');
        $('.status_badge span').removeClass('active');
        $(this).addClass('active');
        window.location.href = href;
    });
});
$('#add-complaints').on('click', function() {
    $('#complaints').modal({
        backdrop: 'static',
        keyboard: false,
        show: true
    });
});

function openSideMenu(hero_type)
{
    var url = window.location.href;
    var arr = url.split("/");
    var result = arr[0] + "//" + arr[2];
    if (arr[2].includes('neo.skshospital') || arr[2] == '172.16.7.211') {
        var iframe_url = 'http://172.16.5.7/';
    }
    else
    {
        var iframe_url = 'http://skshospital.net:88/';
    }
    if (hero_type == 'hero') {
        iframe_url += 'hero/hero.html';
        $('.hero-plus-btn').html('HeRO +').hide();
    }
    else
    {
        iframe_url += 'dsn';
        $('.hero-btn').html('HeRO').hide();
    }
    var iframe_content = '<iframe src="' + iframe_url + '" width="100%" height="100%"></iframe>';
    $('#hero-score-div').html('<i class="fas fa-chevron-circle-right"></i>');
    $('#hero-score-div').append(iframe_content).addClass('drag-in');
}
$(document).on('click', '.drag-in i', function() {
    $('#hero-score-div').html('').removeClass('drag-in');
});

$(document).on('click', '#content', function() {
    $('.side-bar ul.sub-menu').hide();
});


// window.addEventListener("beforeunload", function() {
//     $('a, button').prop('disabled', false);
// });

window.onpageshow = function(load_event) {
    if (load_event.persisted) {
        window.location.reload() 
    }
};


$("#op_print_user_config").click(function() {
    var ids = highestValueOf("#op_print_user_config_table tr");
    option_select = "<select name='op_print_user_id["+ids+"]' class='form-control input-fields-shadow input-width-medium'>";
    option_select += $("select[name='temp_user']").html();
    option_select += "</select>";
    option = '<tr data-len="'+ids+'">';
    option += '<td>'+option_select+'</td>';
    option += '<td>';
    option += '<input class="form-control input-fields-shadow input-width-small" name="op_print_user_top_spacing['+ids+']" type="text">';
    option += '</td>';
    option += '<td>';
    option += '<input class="form-control input-fields-shadow input-width-small" name="op_print_user_right_spacing['+ids+']" type="text">';
    option += '</td>';
    option += '<td>';
    option += '<input class="form-control input-fields-shadow input-width-small" name="op_print_user_bottom_spacing['+ids+']" type="text">';
    option += '</td>';
    option += '<td>';
    option += '<input class="form-control input-fields-shadow input-width-small" name="op_print_user_left_spacing['+ids+']" type="text">';
    option += '</td>';
    option += '<td>';
    option += '<select class="form-control input-fields-shadow input-width-small" name="op_print_user_status['+ids+']"><option value="1">Active</option><option value="0">Inactive</option></select>';
    option += '</td>';
    option += '<td>';
    option += '<span class="fa fa-trash btn btn-danger btn-view remove ml-5"></span>';
    option += '</td>';
    option += '</tr>';
    $("#op_print_user_config_table tbody").append(option);
});

$("#op_print_ip_config").click(function() {
    var ids = highestValueOf("#op_print_ip_config_table tr");
    option = '<tr data-len="'+ids+'">';
    option += '<td>';
    option += '<input class="form-control input-fields-shadow input-width-medium" name="op_print_ip_address['+ids+']" type="text">';
    option += '</td>';
    option += '<td>';
    option += '<input class="form-control input-fields-shadow input-width-small" name="op_print_ip_top_spacing['+ids+']" type="text">';
    option += '</td>';
    option += '<td>';
    option += '<input class="form-control input-fields-shadow input-width-small" name="op_print_ip_right_spacing['+ids+']" type="text">';
    option += '</td>';
    option += '<td>';
    option += '<input class="form-control input-fields-shadow input-width-small" name="op_print_ip_bottom_spacing['+ids+']" type="text">';
    option += '</td>';
    option += '<td>';
    option += '<input class="form-control input-fields-shadow input-width-small" name="op_print_ip_left_spacing['+ids+']" type="text">';
    option += '</td>';
    option += '<td>';
    option += '<select class="form-control input-fields-shadow input-width-small" name="op_print_ip_status['+ids+']"><option value="1">Active</option><option value="0">Inactive</option></select>';
    option += '</td>';
    option += '<td><span class="fa fa-trash btn btn-danger btn-view remove ml-5"></span></td>';
    option += '</tr>';
    $("#op_print_ip_config_table tbody").append(option);
});

function getNeuroAge(opDate, dobDate)
{
    var monthDays = [];

    var tempDays = calculateDays(dobDate, opDate);
    var remainingDays = 0;

    if ((Date.parse(opDate) > 0 && Date.parse(dobDate) > 0) && opDate.getFullYear() > dobDate.getFullYear()) {
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
    } 
    else if ((Date.parse(opDate) > 0 && Date.parse(dobDate) > 0) && opDate.getFullYear() == dobDate.getFullYear()) {

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

    year = typeof year !== 'undefined' ? year : 0;
    month = typeof month !== 'undefined' ? month : 0;
    tempDays = typeof tempDays !== 'undefined' ? tempDays : 0;
    totalWeeks = typeof totalWeeks !== 'undefined' ? totalWeeks : 0;
    totalDays = typeof totalDays !== 'undefined' ? totalDays : 0;

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


$("#pediatric-op-form .op_pediatric_drugs_add").click(function() {
    var ids = highestValueOf("table.drugs tr");
    var l = ids;

    var option_select = "<select name='M_Frequency["+l+"]' class='form-control'>";
        option_select += $("select[name='temp_frequency']").html();
        option_select += "</select>";
    var drug_select = "<select name='M_Drugs["+l+"]' data-id=" + l + " class='drug-list-name" + l + " drugs-changes' style='width: 300px;'>";
        drug_select += $("select[name='temp_drugs']").html();
        drug_select += "</select>";
    var duration_select = '<select name ="M_Duration['+l+']" class="form-control  M_Duration' + l + '">';
        duration_select += $("select[name='temp_duration']").html();
        duration_select += "</select>";
    var dose_select = '<select name ="M_Dose['+l+']" class="form-control  M_Dose' + l + '">';
        dose_select += $("select[name='temp_does']").html();
        dose_select += '</select>';
    var route_select = '<select name ="M_Route['+l+']" class="form-control  M_Route' + l + '">';
        route_select += $("select[name='temp_route']").html();
        route_select += '</select>';
    var option = '<tr data-len="' + ids + '" class="standard_medication_' + ids + '">';    
        option += ' <td><input type="hidden" name="standard_dose['+l+']" value="0">' + drug_select + '</td>';
        option += ' <td><input type="text" name="m_generic_name['+l+']" class="form-control generic_name' + l + '" value=""/></td>';
        option += ' <td><select name="formulation['+l+']" class="form-control formulation' + l + ' "><option value="0"> N/A</option></td>';
        option += '<td class="input-width-medium">' + route_select + '</td>';
        option += '<td class="input-width-medium">' + dose_select + '</td>';
        option += '<td class="input-width-medium">' + option_select + '</td>';
        option += '<td class="input-width-medium">' + duration_select + '</td>';
        option += '<td><a class="btn btn-success btn-view standard_dose btn_add" href="javascript:void(0);" disabled="true" data-addid="'+ids+'"><b>Continue</b></a>';
        option += '<span class="fa fa-trash btn btn-danger btn-view standard_dose_remove"></span></td>';
        option += '</tr>';
    $("table.drugs tbody").append(option);
    $(".drug-list-name" + l).select2({
        allowClear: true,
        dropdownAutoWidth: false
    });
    addFieldHighlighter();
});

$(document).on('click', '#pediatric-op-form .standard_dose', function() {
    var ids = highestValueOf("table.drugs tr");
    var l = ids;
    var parent_id = $(this).attr('data-addid');

    var drug_select = $(this).parent().parent().find('td:first-child select').val();
    var generic_name = $(this).parent().parent().find('td:nth-child(2) input').val();
    var formulation = $(this).parent().parent().find('td:nth-child(3) select').val();
    var route_select = $(this).parent().parent().find('td:nth-child(4) select').val();
    
    var dose_select = '<select name ="M_Dose['+l+']" class="form-control  M_Dose' + l + '">';
        dose_select += $("select[name='temp_does']").html();
        dose_select += '</select>';
    var option_select = "<select name='M_Frequency["+l+"]' class='form-control'>";
        option_select += $("select[name='temp_frequency']").html();
        option_select += "</select>";
    var duration_select = '<select name ="M_Duration['+l+']" class="form-control  M_Duration' + l + '">';
        duration_select += $("select[name='temp_duration']").html();
        duration_select += "</select>";

    var option = '<tr data-len="' + ids + '" class="standard_medication_' + parent_id + '">';
        option += '<td><input type="hidden" name="standard_dose['+l+']" value="1">';
        option += '<input type="hidden" name="M_Drugs['+l+']" value="'+drug_select+'"></td>';
        option += '<td><input type="hidden" name="m_generic_name['+l+']" value="'+generic_name+'"></td>';
        option += '<td><input type="hidden" name="formulation['+l+']" value="'+formulation+'"></td>';
        option += '<td><input type="hidden" name="M_Route['+l+']" value="'+route_select+'"></td>';
        option += '<td class="input-width-medium">' + dose_select + '</td>';
        option += '<td class="input-width-medium">' + option_select + '</td>';
        option += '<td class="input-width-medium">' + duration_select + '</td>';
        option += '<td>';
        option += '<span class="fa fa-trash btn btn-danger btn-view remove pull-right"></span></td>';
        option += '</tr>';

    var latest_class_id = $(this).parent().parent().attr('class');


    // $(this).parent().parent().after(option);
$('.'+latest_class_id).last().after(option);

    addFieldHighlighter();
});
$("#op-form .op_drugs_add").click(function() {
    var ids = highestValueOf("table.drugs tr");
    var l = ids;

    var option_select = "<select name='M_Frequency["+l+"]' class='form-control'>";
        option_select += $("select[name='temp_frequency']").html();
        option_select += "</select>";
    var drug_select = "<select name='M_Drugs["+l+"]' data-id=" + l + " class='drug-list-name" + l + " drugs-changes' style='width: 300px;'>";
        drug_select += $("select[name='temp_drugs']").html();
        drug_select += "</select>";
    var duration_select = '<select name ="M_Duration['+l+']" class="form-control  M_Duration' + l + '">';
        duration_select += $("select[name='temp_duration']").html();
        duration_select += "</select>";
    var dose_select = '<select name ="M_Dose['+l+']" class="form-control  M_Dose' + l + '">';
        dose_select += $("select[name='temp_does']").html();
        dose_select += '</select>';
    var route_select = '<select name ="M_Route['+l+']" class="form-control  M_Route' + l + '">';
        route_select += $("select[name='temp_route']").html();
        route_select += '</select>';
    var option = '<tr data-len="' + ids + '" class="standard_medication_' + ids + '">';    
        option += ' <td><input type="hidden" name="standard_dose['+l+']" value="0">' + drug_select + '</td>';
        option += ' <td><input type="text" name="m_generic_name['+l+']" class="form-control generic_name' + l + '" value=""/></td>';
        option += ' <td><select name="formulation['+l+']" class="form-control formulation' + l + ' "><option value="0"> N/A</option></td>';
        option += '<td class="input-width-medium">' + route_select + '</td>';
        option += '<td class="input-width-medium">' + dose_select + '</td>';
        option += '<td class="input-width-medium">' + option_select + '</td>';
        option += '<td class="input-width-medium">' + duration_select + '</td>';
        option += '<td><a class="btn btn-success btn-view standard_dose btn_add" href="javascript:void(0);" disabled="true" data-addid="'+ids+'"><b>Continue</b></a>';
        option += '<span class="fa fa-trash btn btn-danger btn-view standard_dose_remove"></span></td>';
        option += '</tr>';
    $("table.drugs tbody").append(option);
    $(".drug-list-name" + l).select2({
        allowClear: true,
        dropdownAutoWidth: false
    });
    addFieldHighlighter();
});

$(document).on('click', '#op-form .standard_dose', function() {
    var ids = highestValueOf("table.drugs tr");
    var l = ids;
    var parent_id = $(this).attr('data-addid');

    var drug_select = $(this).parent().parent().find('td:first-child select').val();
    var generic_name = $(this).parent().parent().find('td:nth-child(2) input').val();
    var formulation = $(this).parent().parent().find('td:nth-child(3) select').val();
    var route_select = $(this).parent().parent().find('td:nth-child(4) select').val();
    
    var dose_select = '<select name ="M_Dose['+l+']" class="form-control  M_Dose' + l + '">';
        dose_select += $("select[name='temp_does']").html();
        dose_select += '</select>';
    var option_select = "<select name='M_Frequency["+l+"]' class='form-control'>";
        option_select += $("select[name='temp_frequency']").html();
        option_select += "</select>";
    var duration_select = '<select name ="M_Duration['+l+']" class="form-control  M_Duration' + l + '">';
        duration_select += $("select[name='temp_duration']").html();
        duration_select += "</select>";

    var option = '<tr data-len="' + ids + '" class="standard_medication_' + parent_id + '">';
        option += '<td><input type="hidden" name="standard_dose['+l+']" value="1">';
        option += '<input type="hidden" name="M_Drugs['+l+']" value="'+drug_select+'"></td>';
        option += '<td><input type="hidden" name="m_generic_name['+l+']" value="'+generic_name+'"></td>';
        option += '<td><input type="hidden" name="formulation['+l+']" value="'+formulation+'"></td>';
        option += '<td><input type="hidden" name="M_Route['+l+']" value="'+route_select+'"></td>';
        option += '<td class="input-width-medium">' + dose_select + '</td>';
        option += '<td class="input-width-medium">' + option_select + '</td>';
        option += '<td class="input-width-medium">' + duration_select + '</td>';
        option += '<td>';
        option += '<span class="fa fa-trash btn btn-danger btn-view remove pull-right"></span></td>';
        option += '</tr>';

    var latest_class_id = $(this).parent().parent().attr('class');


    // $(this).parent().parent().after(option);
$('.'+latest_class_id).last().after(option);

    addFieldHighlighter();
});

function medication_update(medication_ids) {
    $.each(medication_ids, function(key, value) {
        $('tr[data-len="' + key + '"]').attr('data-id', value);
        $('tr[data-len="' + key + '"]').find('input[name="standard_dose['+key+']"]').attr('name', 'standard_dose['+value+']');
        $('tr[data-len="' + key + '"]').find('select[name="M_Drugs['+key+']"]').attr('name', 'M_Drugs['+value+']');
        $('tr[data-len="' + key + '"]').find('input[name="M_Drugs['+key+']"]').attr('name', 'M_Drugs['+value+']');
        $('tr[data-len="' + key + '"]').find('input[name="m_generic_name['+key+']"]').attr('name', 'm_generic_name['+value+']');
        $('tr[data-len="' + key + '"]').find('select[name="formulation['+key+']"]').attr('name', 'formulation['+value+']');
        $('tr[data-len="' + key + '"]').find('input[name="formulation['+key+']"]').attr('name', 'formulation['+value+']');
        $('tr[data-len="' + key + '"]').find('select[name="M_Route['+key+']"]').attr('name', 'M_Route['+value+']');
        $('tr[data-len="' + key + '"]').find('input[name="M_Route['+key+']"]').attr('name', 'M_Route['+value+']');
        $('tr[data-len="' + key + '"]').find('select[name="M_Dose['+key+']"]').attr('name', 'M_Dose['+value+']');
        $('tr[data-len="' + key + '"]').find('select[name="M_Frequency['+key+']"]').attr('name', 'M_Frequency['+value+']');
        $('tr[data-len="' + key + '"]').find('select[name="M_Duration['+key+']"]').attr('name', 'M_Duration['+value+']');
    });
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

$("#baby_reg_form.edit-form #generate-mrn").hide();

$("#generate-mrn").on('click', function() {
    var mrn_field_name = $(this).attr("data-mrn-field");
    var form_id = $(this).attr("data-form-id");
    $.ajax({
        type: 'GET',
        url: base_url + '/get-saraswathi-mrn',
        success: function(responseText) {
            $("#"+form_id+" input[name='"+mrn_field_name+"']").val(responseText.mrn);
            // $(".neonatal-consultant-div tr[data-consultant-id='7']").remove();
        },
        error: function(response) {
            Showalert('error', 'Not able to generate MRN !');            
        }
    });
});

$("#generate-ip").on('click', function() {
    var ip_field_name = $(this).attr("data-ip-field");
    var form_id = $(this).attr("data-form-id");
    $.ajax({
        type: 'GET',
        url: base_url + '/get-saraswathi-ip',
        success: function(responseText) {
            $("#"+form_id+" input[name='"+ip_field_name+"']").val(responseText.ip);
        },
        error: function(response) {
            Showalert('error', 'Not able to generate IP Number !');            
        }
    });
});

var search_response = '';
var form_id = '';
$(document).on('keyup', '#BMrNo, #mrno', function() {
    var mrn = $(this).val();
    if (mrn.length == 6) {
        $('#search-baby-by-mr').attr('disabled', false);
        $('#mrn_no_error').html('').fadeIn(500);
    } else {
        $('#search-baby-by-mr').attr('disabled', true);
        $('#mrn_no_error').fadeOut(500);
    }
});

$('#search-baby-by-mr').click(function(e) {
    var mrn = $('#BMrNo, #mrno').val();
    var motherId = $('input[name="MotherId"]').val();
    form_id = $(this).parents('form').attr('id');
    getBabyDetails();
    if (search_response != null) {
        getBabyBackgroundDetails();
        if (window.location.href.indexOf("neuro-develop/create") !== -1 || window.location.href.indexOf("out-patient/create") !== -1) {
            getPreviousEligibilityDetails();
        }
        $('#' + form_id)[0].reset();
        $('#' + form_id + ' #BirthStatus').prop('checked', false).trigger('change');
        $('#' + form_id + ' input[name="BMrNo"], #' + form_id + ' input[name="mrno"]').val(search_response.BMrNo);
        $('#' + form_id + ' input[name="MotherId"]').val(motherId);
        if (search_response.MotherName != null) {
            $('#' + form_id + ' input[name="MotherName"], #' + form_id + ' input[name="mother_name"]').val(search_response.MotherName);
        }
        $('#' + form_id + ' input[name="BabyId"]').val(search_response.BabyId);
        $('#' + form_id + ' input[name="baby_id"]').val(search_response.BabyId);
        if (search_response.BabyName != null) {
            $('#' + form_id + ' #BabyName').val(search_response.BabyName);
        }
        if (search_response.DOB != null) {
            var dob = search_response.DOB.split('-');
            date = dob[2];
            month = dob[1];
            year = dob[0];
            dob = date + '-' + month + '-' + year;
            $('#' + form_id + ' #DOB').val(dob).trigger('change');
        }
        if (search_response.TOB_AM != null) {
            $('#' + form_id + ' select[name="TOB_AM"]').val(search_response.TOB_AM).trigger('change');
        }
        if (search_response.TOB_MINS != null) {
            $('#' + form_id + ' select[name="TOB_MINS"]').val(search_response.TOB_MINS).trigger('change');
        }
        if (search_response.TOB_TIME != null) {
            $('#' + form_id + ' select[name="TOB_TIME"]').val(search_response.TOB_TIME).trigger('change');
        }
        if (search_response.BirthWeight != null) {
            $('#' + form_id + ' #BirthWeight').val(search_response.BirthWeight).trigger('keyup');
        }
        if (search_response.BirthStatus != null) {
            if (search_response.BirthStatus == 'Inborn') {
                $('#' + form_id + ' #BirthStatus').prop('checked', true).trigger('change');
            }
        }
        if (search_response.g_weeks != null) {
            $('#' + form_id + ' input[name="g_weeks"]').val(search_response.g_weeks).trigger('change');
        }
        if (search_response.g_days != null) {
            $('#' + form_id + ' input[name="g_days"]').val(search_response.g_days);
        }
        if (search_response.BabyBloodGroup != null) {
            $('#' + form_id + ' select[name="BabyBloodGroup"]').val(search_response.BabyBloodGroup);
        }
        if (search_response.Sex != null) {
            $('#' + form_id + ' #Sex').val(search_response.Sex).trigger('change');
        }
        if (search_response.baby_background != null && search_response.baby_background != '') {
            tinymce.get('baby_background').setContent(search_response.baby_background);
        }
        var mobile_number = '';
        if (search_response.Mobile != null && search_response.Mobile != '') {
            mobile_number = search_response.Mobile;
        }
        if (search_response.LandLine != null && search_response.LandLine != '')  {
            if (mobile_number == '') {
                mobile_number = search_response.LandLine;
            } else {
                mobile_number = mobile_number + ',' + search_response.LandLine;
            }
        } 
        if (search_response.PartnerContact != null && search_response.PartnerContact != '') {
            if (mobile_number == '') {
                mobile_number = search_response.PartnerContact;
            } else {
                mobile_number = mobile_number + ',' + search_response.PartnerContact;
            }
        }
        if (search_response.PartnerMobile != null && search_response.PartnerMobile != '') {
            if (mobile_number == '') {
                mobile_number = search_response.PartnerMobile;
            } else {
                mobile_number = mobile_number + ',' + search_response.PartnerMobile;
            }
        }
        $('#' + form_id + ' #contact_no').val(mobile_number);
        search_response = '';
        $('#search-baby-by-mr').attr('disabled', true);
        $('#mrn_no_error').html('').fadeIn(500);
    } else {
        $('#' + form_id)[0].reset();
        console.log('#' + form_id + ' input[name="BMrNo"], #' + form_id + ' input[name="mrno"]');
        $('#' + form_id + ' input[name="BMrNo"], #' + form_id + ' input[name="mrno"]').val(mrn);
        $('#' + form_id + ' #BirthStatus').prop('checked', false).trigger('change');
    console.log(motherId, '#' + form_id + ' input[name="MotherId"]');
        $('#' + form_id + ' input[name="MotherId"]').val(motherId);
        $('#' + form_id + ' input[name="g_weeks"]').val('').trigger('change');
        $('#' + form_id + ' #Sex').select2();
        $('#' + form_id + ' #Sex').select2("val", "");
        getBabyDetailsFromHis();
    }
});

function getBabyDetails() {
    var mrn = $('#BMrNo, #mrno').val();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: base_url + "/get-baby-details/" + mrn,
        success: function(response) {
            search_response = response.results;
        },
        async: false
    });
}

function getBabyBackgroundDetails() {
    var mrn = $('#BMrNo, #mrno').val();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: base_url + "/get-baby-background-details/" + mrn,
        success: function(response) {
            search_response.baby_background = response.baby_background;
        },
        async: false
    });
}

function getPreviousEligibilityDetails() {
    var mrn = $('#BMrNo').val();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: base_url + "/get-previous-eligibility-details/" + mrn,
        success: function(response) {
            if (response.birth_weight_gestation_is_lesser) {
                $('input[name="birth_weight_gestation_is_lesser"]').attr('checked', response.birth_weight_gestation_is_lesser).parents('tr').addClass('bg-warning');
            }
            if (response.birth_weight_gestation_is_greater) {
                $('input[name="birth_weight_gestation_is_greater"]').attr('checked', response.birth_weight_gestation_is_greater).parents('tr').addClass('bg-warning');
            }
            if (response.intrauterine_growth) {
                $('input[name="intrauterine_growth"]').attr('checked', response.intrauterine_growth).parents('tr').addClass('bg-warning');
            }
            if (response.meningitis) {
                $('input[name="meningitis"]').attr('checked', response.meningitis).parents('tr').addClass('bg-warning');
            }
            if (response.mechanical_ventilation) {
                $('input[name="mechanical_ventilation"]').attr('checked', response.mechanical_ventilation).parents('tr').addClass('bg-warning');
            }
            if (response.encephalopathy_stage_2_more) {
                $('input[name="encephalopathy_stage_2_more"]').attr('checked', response.encephalopathy_stage_2_more).parents('tr').addClass('bg-warning');
            }
            if (response.major_malformation) {
                $('input[name="major_malformation"]').attr('checked', response.major_malformation).parents('tr').addClass('bg-warning');
            }
            if (response.inborn_errors) {
                $('input[name="inborn_errors"]').attr('checked', response.inborn_errors).parents('tr').addClass('bg-warning');
            }
            if (response.symptomatic_hypoglycemia) {
                $('input[name="symptomatic_hypoglycemia"]').attr('checked', response.symptomatic_hypoglycemia).parents('tr').addClass('bg-warning');
            }
            if (response.symptomatic_polycythemia) {
                $('input[name="symptomatic_polycythemia"]').attr('checked', response.symptomatic_polycythemia).parents('tr').addClass('bg-warning');
            }
            if (response.retrovirus_positive_mother) {
                $('input[name="retrovirus_positive_mother"]').attr('checked', response.retrovirus_positive_mother).parents('tr').addClass('bg-warning');
            }
            if (response.hyperbilirubinemia_transfusion_rh) {
                $('input[name="hyperbilirubinemia_transfusion_rh"]').attr('checked', response.hyperbilirubinemia_transfusion_rh).parents('tr').addClass('bg-warning');
            }
            if (response.abnormal_neuro_exam) {
                $('input[name="abnormal_neuro_exam"]').attr('checked', response.abnormal_neuro_exam).parents('tr').addClass('bg-warning');
            }
            if (response.major_morbidities) {
                $('input[name="major_morbidities"]').attr('checked', response.major_morbidities).parents('tr').addClass('bg-warning');
            }
            if (response.other_specify_is_present) {
                $('input[name="other_specify_is_present"]').attr('checked', response.other_specify_is_present).parents('tr').addClass('bg-warning');
            }
            if (response.general_checkup) {
                $('input[name="general_checkup"]').attr('checked', response.general_checkup).parents('tr').addClass('bg-warning');
            }
            $('textarea[name="other_specify"]').html(response.other_specify);
        },
        async: false
    });
}

function getBabyDetailsFromHis() {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        data: {
            mrn: $('#BMrNo, #mrno').val()
        },
        url: base_url + "/get-baby-details-from-his",
        success: function(response) {
            if (response != '0' && Object.keys(response).length > 2) {
                // $('#' + form_id + ' input[name="MotherId"]').val(response.mother_id);
                $('#' + form_id + ' input[name="MotherName"]:not(.pediatric-form-mother-field), #' + form_id + ' input[name="mother_name"]').val(response.mothername);
                $('#' + form_id + ' input[name="parter_name"]').val(response.partername);
                $('#' + form_id + ' input[name="mobile"]').val(response.mobile);
                $('#' + form_id + ' input[name="phone"]').val(response.phone);
                $('#' + form_id + ' input[name="address1"]').val(response.address1);
                $('#' + form_id + ' input[name="address2"]').val(response.address2);
                $('#' + form_id + ' input[name="address3"]').val(response.address3);
                $('#' + form_id + ' input[name="city"]').val(response.city);
                $('#' + form_id + ' input[name="pincode"]').val(response.pincode);
                $('#' + form_id + ' input[name="BabyId"]').val(response.baby_id);
                $('#' + form_id + ' #BabyName').val(response.name);
                $('#' + form_id + ' #DOB').val(response.dob).trigger('change');
                if (typeof response.sex != 'undefined') {
                    $('#' + form_id + ' #Sex').val(response.sex).trigger('change');
                }
                $('#' + form_id + ' #search_mrn_no_error').html('').fadeIn(500);
            } else {
                $('#' + form_id + ' #search_mrn_no_error').html('No Patient Found').fadeIn(500);
            }
        }
    });
}


$(document).on('focusout', '#MMrNo', function() {
    $('#search-mother-by-mr').attr('disabled', false);
});

$('#search-mother-by-mr').click(function(e) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        data: {
            mrn : $('#MMrNo').val()
        },
        url: base_url + "/get-mother-details-from-his",
        success: function(response) {
            if (response != '0') {
                $('#MotherTitle').val(response.dob);
                $('#MotherName').val(response.mothername);
                $('#DOB').val(response.dob);
                $('#BabyName').val(response.name);
                if (typeof response.sex != 'undefined') {
                    $('#Sex').val(response.sex).trigger('change');
                }
                if (typeof response.blood_group != 'undefined') {
                    $('#BabyBloodGroup').val(response.blood_group).trigger('change');
                }
                $('#PartnerName').val(response.partername);
                $('#Address1').val(response.address1);
                $('#Address2').val(response.address2);
                $('#Address3').val(response.city);
                $('#Address4').val(response.pincode);
                $('#Mobile').val(response.mobile);
                $('#PartnerContact').val(response.phone);
                $('#search_mrn_no_error').html('').fadeIn(500);              
            } else {
                $('#search_mrn_no_error').html('No Patient Found').fadeIn(500);              
            }
        }
    });
});

$(document).on('change', '#create-neuro #BMrNo, #create-neuro #visit_date, .op-create #op-form #BMrNo, .op-create #op-form #OpDate', function() {
    var form_id = $('form').attr('id');
    if (form_id == 'op-form') {
        var mrn = $('#op-form #BMrNo').val();
        var visit_date = $('#op-form #OpDate').val();
        var module_name = 'Neonatal';
    } else {
        var mrn = $('#create-neuro #BMrNo').val();
        var visit_date = $('#create-neuro #visit_date').val();
        var module_name = 'Neuro';
    }
    if (mrn != '' && visit_date != '') {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            data: {
                mrn: mrn,
                visit_date: visit_date,
                requested_from: module_name
            },
            url: base_url + '/get-physical-growth',
            success: function(response) {
                if (form_id == 'op-form') {
                    $('#'+form_id+' input[name="CurrentWt"]').val(response.current_weight_g).trigger('keyup');
                    $('#'+form_id+' input[name="CurrentOFC"]').val(response.current_ofc);
                    $('#'+form_id+' input[name="CurrentLength"]').val(response.current_length);
                } else {
                    $('#'+form_id+' input[name="current_weight_g"]').val(response.CurrentWt).trigger('keyup');
                    $('#'+form_id+' input[name="current_ofc"]').val(response.CurrentOFC);
                    $('#'+form_id+' input[name="current_length"]').val(response.CurrentLength);
                }
            }
        });
    }
});
$('#BMrNo, #mrno, #visit_date, #OpDate, #op_date, #neuro-form #visit_type, #admission_date, #AdmissionDate, select[name="visit_from"]').on('change', function(e) {
    var date_event_is_happens = $('#visit_date').hasClass('has-success');
    var date_event_is_happens1 = false;

    var mrn = $('#BMrNo').val();
    var visit_date = $('#visit_date').val();
    var visit_type = $('#visit_type').val();
    var module_name = $('input[name="visit_module_name"]').val();

    if (module_name == 'neonatal_op') {
        visit_date = $('#OpDate').val();
        mrn = $('#BMrNo').val();
        date_event_is_happens1 = $('#OpDate').hasClass('valid');
    } else if (module_name == 'pediatric_op') {
        visit_date = $('#op_date').val();
        mrn = $('#mrno').val();
        date_event_is_happens = $('#op_date').hasClass('has-success');
    }
    var visit_from = $('select[name="visit_from"]').val();

    if (visit_type == 'IP') {
        visit_date = $('#admission_date').val();
        date_event_is_happens = $('#admission_date').hasClass('has-success');
        date_event_is_happens1 = $('#admission_date').hasClass('valid');
        if ($(".row.row-spacing").attr('id') == 'nicu-admission-form') {
            visit_date = $('#AdmissionDate').val();
            date_event_is_happens1 = $('#AdmissionDate').hasClass('valid');            
        }
    }
        console.log(mrn, visit_date, module_name, date_event_is_happens,date_event_is_happens1, e.hasOwnProperty('originalEvent'));

    if (mrn != '' && visit_date != '' && module_name != '' && typeof module_name != 'undefined' && (date_event_is_happens || date_event_is_happens1 || e.hasOwnProperty('originalEvent'))) {
        console.log('>>>>>>');
        if (typeof $('.bootbox.modal').attr('id') == 'undefined') {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                data: {
                    mrn : mrn,
                    visit_date : visit_date,
                    visit_type : visit_type,
                    module_name : module_name,
                    visit_from : visit_from
                },
                url: base_url + "/get-visit-no-from-his",
                async: false,
                success: function(response) {
                    if (response.url != '' && response.url !== undefined) {
                        if (window.location.href.indexOf("edit") === -1) {
                            bootbox.confirm({
                                closeButton: false,
                                message: "This baby already have the visit entry for '" + visit_date + "'. Do you want to create again ?",
                                buttons: {
                                    confirm: {
                                        label: 'Yes',
                                        className: 'btn-success'
                                    },
                                    cancel: {
                                        label: 'Merge visit',
                                        className: 'btn-danger'
                                    }
                                },
                                callback: function (result) {
                                    if (!result) {
                                        window.location.href = response.url;
                                    } else {                                        
                                        if (typeof response.message === 'string') {
                                            var ip_number = response.message;
                                            if (ip_number.length > 0) {
                                                $('input[name="visit_number"], input[name="ip_number"]').val(response.message).attr('readonly', true);
                                            } else {
                                                $('input[name="visit_number"], input[name="ip_number"]').attr('readonly', false);
                                            }
                                        }
                                    }
                                }
                            }).attr('id', 'checkexist');
                        }
                    } else if (response.type == 'error') {
                        $('input[name="visit_number"], input[name="ip_number"]').val('').attr('readonly', false);
                    } else {
                        if (typeof response.message === 'string') {
                            var ip_number = response.message;
                            if (ip_number.length > 0) {
                                $('input[name="visit_number"], input[name="ip_number"]').val(response.message).attr('readonly', true);
                            } else {
                                $('input[name="visit_number"], input[name="ip_number"]').attr('readonly', false);
                            }
                        }
                    }
                },
                error: function(response) {
                    if (response.type == 'error') {
                        $('input[name="visit_number"], input[name="ip_number"]').val('').attr('readonly', true);
                    }
                }
            });
        }
    }
});

function bedList(select_id) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            url: base_url + '/get-bed-list',
            success: function(response) {
                var option_list = '<option value="" selected="selected">-- Select Bed for transfer --</option>';
                $.each(JSON.parse(response), function(key, value) {
                    option_list += '<option value="'+value.id+'" data-room-id="'+value.room_id+'" data-ward-id="'+value.ward_id+'" data-hms-ward-id="'+value.hms_ward_id+'" data-hms-room-id="'+value.hms_room_id+'" data-hms-bed-id="'+value.hms_bed_id+'">'+value.number+'</option>';
                });
                $("#"+select_id).html(option_list);
            }
        });
}

$(".seen_by_add").click(function() {
    option_select = $("select[name='neonatal_seen_by']").html();
    neo = '<select class="form-control full-width" name="seenby[]">';
    neo += option_select;
    neo += '</select>';
    option = '<tr><td>' + neo + '</td>';
    option += '<td><span class="fa fa-trash btn btn-danger btn-view remove-neon"></span></td></tr>';
    $(".seen-by-div").append(option);
});

$(document).on('click', '.reassessment_seen_by_add', function() {
    var len = $('.reassessment-seen-by-div').find('tbody tr:last-child').attr('data-len');
        len = parseInt(len) + 1;
    option_select = $("select[name='neonatal_seen_by']").html();
    neo = '<select class="full-width" name="reassessment_seen_by['+len+']">';
    neo += option_select;
    neo += '</select>';
    option = '<tr data-len="'+len+'"><td>' + neo + '</td>';
    option += '<td><span class="fa fa-trash btn btn-danger btn-view remove-neon"></span></td></tr>';
    $(".reassessment-seen-by-div").append(option);
    $('select[name="reassessment_seen_by['+len+']"]').select2();
    $('select[name="reassessment_seen_by['+len+']"]').select2("val", "");
});


$(".nicu_seen_by_add").click(function() {
    option_select = $("select[name='seen_by']").html();
    neo = '<select class="form-control full-width" name="SeenBy[]">';
    neo += option_select;
    neo += '</select>';
    option = '<tr><td>' + neo + '</td>';
    option += '<td><span class="fa fa-trash btn btn-danger btn-view remove-neon"></span></td></tr>';
    $(".seen-by-div").append(option);
});

$(document).on('click', '#live-chart-link', function() {
    var client_zone = Intl.DateTimeFormat().resolvedOptions().timeZone;
    var link = $(this).attr('data-url')+'&client_zone='+client_zone;
    window.location = link;
});

$(document).on('click', '.call-hms-2', function () {
    $('input[name="hms_call').val(false); 
    var baby_mrn = $('#baby-category #BMrNo').val();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        data: {
            mrn: baby_mrn
        },
        url: base_url + "/update-hms-reg",
        success: function(response) {
            $('input[name="hms_call').val(true); 
            if (JSON.parse(response).data != undefined && JSON.parse(response).data != null) {
                var result = JSON.parse(response).data;
                var baby_name = result.salutation + ' ' + result.patient_name;
                $('#baby-category #BabyName').val(baby_name);
                var sex = result.sex.toLowerCase();
                sex = sex.charAt(0).toUpperCase()+sex.slice(1);
                $('#baby-category #Sex').val(sex).trigger('change');
                var dob = result.birth_date;
                    dob = dob.split('-');
                    dob = dob[2] + '-' + dob[1] + '-' + dob[0];
                $('#baby-category #DOB').val(dob);
            } else {
                $('#baby-category #BabyName').val('');
                $('#baby-category #Sex').val('');
                $('#baby-category #DOB').val('');
            }
        }
    });
});

$(".master_issa_add").click(function() {
    var ids = highestValueOf("table.masters tr");
    option_select = $(".temp_issa_question_type").html();

    option = '<tr data-len="' + ids + '">';
    option += '<td>';
    option += '<textarea class="form-control valid input-width-medium" name="question[]" rows="2" cols="50"></textarea>';
    option += '</td>';
    option += '<td>';
    option += '<select name="category[]" class="form-control input-width-medium">'+ option_select +'</select>';
    option += '</td>';
    option += '<td>';
    option += '<select name="status[]" class="input-width-small input-fields-shadow form-control">';
    option += '<option value="1" selected="selected">Active</option>';
    option += '<option value="0">Inactive</option></select>';
    option += '</td>';
    option += '<td>';
    option += '<span class="fa fa-trash btn btn-danger btn-view remove"></span>';
    option += '</td>';
    option += '</tr>';
    $("table.master_issa_qestions_table tbody").append(option);

});
