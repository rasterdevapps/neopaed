var getUrl = window.location;
var baseUrl = getUrl.protocol + "//" + getUrl.host + getUrl.pathname.split("nicu-discharge-summary")[0];
url = baseUrl + 'nicu-discharge-reports';
var list = ["Birth", "Problems", "RespiratorySystem", "CardiovascularSystem", "GastrointestinalSystem",
    "Communicationwithparents", "Investigations",
    "DischargeInstructions", "CentralNervousSystem", "Sepsis", "Ophthalmology", "Hematology",
    "NewbornScreening", "Followup", 'DischargeMedications', 'Procedures', 'Summarybirth', 'vaccine'
];
$.each(list, function (index, value) {
    if ($('div').hasClass(value.toLowerCase() + '-report-editor')) {
        var options = $('.' + value.toLowerCase() + '-report-editor').html().trim();
        $('input[name="' + value + '"]').val(options);
    }
});

var contentCheckbox = '<input class="hidden-print" title="Remove from the print" checked="checked" name="printstatus" type="checkbox" value="">';

var editor_content_name = ['problems-report-editing', 'summary-report-editing', 'Procedures-report-editing', 'Summarybirth-report-editing', 'birth-report-editing', 'respiratorysystem-report-editing', 'cardiovascularsystem-report-editing', 'gastrointestinalsystem-report-editing', 'centralnervoussystem-report-editing', 'sepsis-report-editing', 'ophthalmology-report-editing', 'hematology-report-editing', 'newbornscreening-report-editing', 'communicationwithparents-report-editing', 'investigations-report-editing', 'dischargemedications-report-editing', 'vaccine-report-editing', 'dischargeinstructions-report-editing', 'followup-report-editing', 'addedinfo-report-editing'];

var report_edition_done = ['problems-report-done', 'summary-report-done', 'Procedures-report-done', 'Summarybirth-report-done', 'birth-report-done', 'respiratorysystem-report-done', 'cardiovascularsystem-report-done', 'gastrointestinalsystem-report-done', 'centralnervoussystem-report-done', 'sepsis-report-done', 'ophthalmology-report-done', 'hematology-report-done', 'newbornscreening-report-done', 'communicationwithparents-report-done', 'investigations-report-done', 'dischargemedications-report-done', 'vaccine-report-done', 'dischargeinstructions-report-done', 'followup-report-done', 'addedinfo-report-done'];

var content_name = ['problems-report-editor', 'summary-report-editor', 'procedures-report-editor', 'summarybirth-report-editor', 'birth-report-editor', 'respiratorysystem-report-editor', 'cardiovascularsystem-report-editor', 'gastrointestinalsystem-report-editor', 'centralnervoussystem-report-editor', 'sepsis-report-editor', 'ophthalmology-report-editor', 'hematology-report-editor', 'newbornscreening-report-editor', 'communicationwithparents-report-editor', 'investigations-report-editor', 'dischargemedications-report-editor', 'vaccine-report-editor', 'dischargeinstructions-report-editor', 'followup-report-editor', 'addedinfo-report-editor'];

var textarea_name = ['problems_temp', 'summary_temp', 'Procedures_temp', 'Summarybirth_temp', 'birth_temp', 'respiratorysystem_temp', 'cardiovascularsystem_temp', 'gastrointestinalsystem_temp', 'centralnervoussystem_temp', 'sepsis_temp', 'ophthalmology_temp', 'hematology_temp', 'newbornscreening_temp', 'communicationwithparents_temp', 'investigations_temp', 'dischargemedications_temp', 'vaccine_temp', 'dischargeinstructions_temp', 'addedinfo_temp', 'followup_temp'];

var input_name = ['Problems', 'summary', 'Procedures', 'Summarybirth', 'Birth', 'RespiratorySystem', 'CardiovascularSystem', 'GastrointestinalSystem', 'CentralNervousSystem', 'Sepsis', 'Ophthalmology', 'Hematology', 'NewbornScreening', 'Communicationwithparents', 'Investigations', 'DischargeMedications', 'vaccine', 'DischargeInstructions', 'Followup', 'additional_information'];

var checkbox_name = ['problem-status', 'problem-status', 'problem-status', 'problem-status', 'problem-status', 'problem-status', 'problem-status', 'problem-status', 'problem-status', 'problem-status', 'problem-status', 'problem-status', 'problem-status', 'problem-status', 'problem-status', 'problem-status', 'problem-status', 'problem-status', 'problem-status', 'problem-status'];

var checkbox_id = ['modified-problem', 'modified-summary', 'proceduresSystem-modified', 'summary-modified', 'birth-report-modified', 'problem-status-modified', 'cardiovascularsystem-details', 'gastrointestinalsystem-modified', 'centralnervoussystem-modified', 'sepsis-modified', 'ophthalmology-modified', 'hematology-modified', 'newbornscreening-modified', 'communicationwithparents-modified', 'investigation-modified', 'DischargeMedications', 'vaccine-modified', 'dischargeinstruction-modified', 'NextAppointment-modified', 'addedinfo-modified'];

var copy_btn_clicked = false;
$.each(editor_content_name, function(key, value) {
    $(document).on('click', '.' + value, function(e) {
        e.preventDefault();
        $(this).parent().attr('title', 'Done').html('<i class="fa fa-check ' + report_edition_done[key] + '" aria-hidden="true"></i><i class="fas fa-copy ' + editor_content_name[key] + '_copy" aria-hidden="true"></i>');
        var problemcontent = $('.' + content_name[key] + ' .editor-align-content').html().trim();
        $('.' + content_name[key]).removeClass('hide');
        var options = '<div class="form-group">';
        options += '<textarea id="' + textarea_name[key] + '" class="form-control" rows="5" name="' + textarea_name[key] + '" cols="50">' + problemcontent + '</textarea>';
        options += '</div>';
        $('.' + content_name[key]).html(options);
        CKEDITOR.replace(textarea_name[key]);
        // setStatus();
        CKEDITOR.instances[textarea_name[key]].on('blur', function() {
            setStatus();
            var problemContentfields = CKEDITOR.instances[textarea_name[key]].getData();
            $('input[name="' + input_name[key] + '"]').parent().find('a.checkingtest').attr('title', 'Edit').html('<i class="fa fa-pencil ' + value + '" aria-hidden="true"></i>');
            
            var problem_content_fields = '<div class="editor-align-checkbox-div">';
            problem_content_fields += '<input type="checkbox" name="' + checkbox_name[key] + '" class="hidden-print" id="' + checkbox_id[key] + '" title="Remove from the print" checked />';
            problem_content_fields += '<label for="' + checkbox_id[key] + '"><span class="hidden-print"></span></label>';
            problem_content_fields += '</div>';
            problem_content_fields += '<div class="editor-align-content">';
            problem_content_fields += problemContentfields;
            problem_content_fields += '</div>';

            var html_content = $.parseHTML(problemContentfields); //parseHTML return HTMLCollection
            var filtered_content = $(html_content).text().trim();
            
            if (copy_btn_clicked) {
                var editor = CKEDITOR.instances[textarea_name[key]];
                editor.focus();
                var s = editor.getSelection();
                var selected_ranges = s.getRanges();
                var node = selected_ranges[0].startContainer;
                var parents = node.getParents(true);
                node = parents[parents.length - 2].getFirst();
                while (true) {
                    var x = node.getNext();
                    if (x == null) {
                        break;
                    }
                    node = x;
                }
                s.selectElement(node);
                selected_ranges = s.getRanges();
                selected_ranges[0].collapse(false);
                s.selectRanges(selected_ranges);
                $('.' + value).parent().attr('title', 'Done').html('<i class="fa fa-check ' + report_edition_done[key] + '" aria-hidden="true"></i><i class="fas fa-copy ' + editor_content_name[key] + '_copy" aria-hidden="true"></i>');
            }  else {
                if (filtered_content.length > 0) {
                    $('.' + content_name[key]).html(contentCheckbox + problem_content_fields);
                    $('input[name="' + input_name[key] + '"]').val(problemContentfields);
                } else {
                    $('.' + content_name[key]).html(problem_content_fields);
                    $('.' + content_name[key]).addClass('hide');
                    $('input[name="' + input_name[key] + '"]').val('');
                }
            }
            copy_btn_clicked = false;
            updateDaycareReport();
        });
        CKEDITOR.on('instanceReady', function(ev) {
            ev.editor.focus();
            var s = ev.editor.getSelection();
            var selected_ranges = s.getRanges();
            var node = selected_ranges[0].startContainer;
            var parents = node.getParents(true);
            node = parents[parents.length - 2].getFirst();
            while (true) {
                var x = node.getNext();
                if (x == null) {
                    break;
                }
                node = x;
            }
            s.selectElement(node);
            selected_ranges = s.getRanges();
            selected_ranges[0].collapse(false);
            s.selectRanges(selected_ranges);
        });
    });
$(document).on('click', '.' + report_edition_done[key], function(e) {
    e.preventDefault();
    var problemContentfields = CKEDITOR.instances[textarea_name[key]].getData();
    $(this).parent().attr('title', 'Edit').html('<i class="fa fa-pencil ' + value + '" aria-hidden="true"></i>');
    var problem_content_fields = '<div class="editor-align-checkbox-div">';
    problem_content_fields += '<input type="checkbox" name="' + checkbox_name[key] + '" class="hidden-print" id="' + checkbox_id[key] + '" title="Remove from the print" checked />';
    problem_content_fields += '<label for="' + checkbox_id[key] + '"><span class="hidden-print"></span></label>';
    problem_content_fields += '</div>';
    problem_content_fields += '<div class="editor-align-content">';
    problem_content_fields += problemContentfields;
    problem_content_fields += '</div>';
        var html_content = $.parseHTML(problemContentfields); //parseHTML return HTMLCollection
        var filtered_content = $(html_content).text().trim();
        if (filtered_content.length > 0) {
            $('.' + content_name[key]).html(contentCheckbox + problem_content_fields);
            $('input[name="' + input_name[key] + '"]').val(problemContentfields);
        } else {
            $('.' + content_name[key]).html(problem_content_fields);
            $('.' + content_name[key]).addClass('hide');
            $('input[name="' + input_name[key] + '"]').val('');
        }
        // setStatus();
    });
$(document).on('click', '.' + value + '_copy', function(e) {
    copy_btn_clicked = true;
    e.preventDefault();
    var generated_content = $(this).parents('h6').next().find('.generated-content').html();
    var add_bg = '<div style="background-color: yellow;">' + generated_content + '</div>';
    var peviousConent = CKEDITOR.instances[textarea_name[key]].getData();
    if (generated_content === undefined || generated_content == '') {

    } else if (peviousConent == '' || peviousConent == null) {
        var problemContentfields = CKEDITOR.instances[textarea_name[key]].setData(generated_content);
    } else {
            // if (confirm('Do you want to remove the updated content in editor?')) {
                var problemContentfields = CKEDITOR.instances[textarea_name[key]].setData(peviousConent + add_bg);
            // }
        }
    });
});
$(document).on('change', '#is_completed', function() {
    if (!$(this).parents('.hidden-print').hasClass('hide')) {
        $('input[name="status"]').val(1);
        $('.savebtn').removeClass('hide');
    }
});

function setStatus() {
    if (checkChanges()) {
        $('input[name="status"]').val(1);
        $('.savebtn').removeClass('hide');
    }
}
$(document).on('click', '.neonatal-intensive-care-save', function() {
    if (checkActiveeditor()) {
        var summary_text = $('.container.main .temp-container').html();
        var baby_id = $('input[name="BabyId"]').val();
        var mrn = $('input[name="BMrNo"]').val();
        var ip_and_folder_name = window.location.href.split('nicu-discharge-summary')[0];
        summary_text = summary_text.replace(ip_and_folder_name, 'HOSTPATH');
        savePrintedContent(baby_id, mrn, summary_text);
        $('form').submit();
    }
});

function checkActiveeditor() {
    var flag = true;
    $('.checkingtest').each(function() {
        if ($(this).children().hasClass('fa-check')) {
            var position = $(this).position().top;
            $('html, body').animate({
                scrollTop: position
            }, 300);
            return flag = false;
        }
    });
    return flag;
}

function checkChanges() {
    var isDirty = false;
    for (var i in CKEDITOR.instances) {
        if (CKEDITOR.instances[i].checkDirty()) {
            return isDirty = true;
        }
    }
}
$(document).on('click', '.problem-editing', function(e) {
    var id = $(this).data('problem-id');
    e.preventDefault();
    $(this).parent().attr('title', 'Done').html('<i class="fa fa-check problem-done" data-problem-id="' + id + '" aria-hidden="true"></i>');
    var problemcontent = $('.problem-editor-' + id).html().trim();
    var options = '<div class="form-group">';
    options += '<textarea id="problem_temp_' + id + '" class="form-control" rows="5" name="problem_temp_' + id + '" cols="50">' + problemcontent + '</textarea>';
    options += '</div>';
    $('.problem-editor-' + id).html(options);
    CKEDITOR.replace('problem_temp_' + id);
    setStatus();
});
$(document).on('click', '.problem-done', function(e) {
    var id = $(this).data('problem-id');
    e.preventDefault();
    var problemContentfields = CKEDITOR.instances['problem_temp_' + id].getData();
    $(this).parent().attr('title', 'Edit').html('<i class="fa fa-pencil problem-editing" data-problem-id=' + id + ' aria-hidden="true"></i>');
    $('input[name="problem-' + id + '"]').val(problemContentfields);
    $('.problem-editor-' + id).html(problemContentfields);
    setStatus();
});

function updateDaycareReport() {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: url,
        data: $('#nicu-discharge').serialize(),
        cache: false,
        dataType: "json",
        success: function(response) {
            $('.neonatal-intensive-care-default').parent().removeClass('hide');
            $('.neonatal-intensive-care-default').removeClass('hide');
            setStatus();
        },
        error: function(response) {
            Showalert('error', 'Record Not Saved. Try after some time !');
        }
    });
}
$(document).on('click', '#nicu-discharge  h6 .check-box-div > input[type="checkbox"]', function() {
    if ($(this).prop('checked') == false) {
        $(this).parent().parent().parent().addClass('hidden-print').addClass('active-checkbox');
        $('.savebtn').removeClass('hide');
    } else {
        $(this).parent().parent().parent().removeClass('hidden-print').removeClass('active-checkbox');
    }
});
$(document).on('click', '#nicu-discharge .generated-content-container input[type="checkbox"]', function() {
    if ($(this).prop('checked') == false) {
        $(this).parents('.generated-content-container').addClass('hidden-print').addClass('active-checkbox');
        $('.savebtn').removeClass('hide');
    } else {
        $(this).parents('.generated-content-container').removeClass('hidden-print').removeClass('active-checkbox');
    }
});
$(document).on('click', '#nicu-discharge .editor-align input[type="checkbox"]', function() {
    if ($(this).prop('checked') == false) {
        $(this).parents('.editor-align').addClass('hidden-print').addClass('active-checkbox');
        $('.savebtn').removeClass('hide');
    } else {
        $(this).parents('.editor-align').removeClass('hidden-print').removeClass('active-checkbox');
    }
});
$(document).on('click', '.add-diagnosis', function() {
    var generateDiagnosis = [];

    var diagnosisSub = {};

    var new_diagnosis = prompt("Enter Your New Diagnosis:");

    if (new_diagnosis != null && new_diagnosis != '') {
        var dataList = $(".created_fields a").map(function() {
            return $(this).attr("data-count");
        }).get();

        var count = Math.max.apply(null, dataList) >= 0 ? Math.max.apply(null, dataList) + 1 : 0;

        var dependency = $(this).parents('h6').find('input').attr('name');
        var add_diagnosis = "<div class='created_fields'>";
        add_diagnosis += "<h6>";
        add_diagnosis += "<span class='check-box-div'>";
        add_diagnosis += "<input type='checkbox' name='new-diagnosis-" + count + "' class='hidden-print new-diagnosis' title='Remove from the print' id='new-diagnosis-" + count + "' checked/>";
        add_diagnosis += "<label for='new-diagnosis-" + count + "'><span class='hidden-print'></span></label>";
        add_diagnosis += "</span>";
        add_diagnosis += "<span class='custom-heading'>" + new_diagnosis + "</span>";
        add_diagnosis += "<input type='hidden' name='diagnosis-" + count + "'/>";
        add_diagnosis += "<a href='javascript:' class='hidden-print' style='cursor: pointer;' title='Edit' data-count='" + count + "'>";
        add_diagnosis += "<i class='fa fa-pencil new-report-editing' aria-hidden='true'></i>";
        add_diagnosis += "</a>";
        add_diagnosis += "</h6>";
        add_diagnosis += "<div class='new-report-editor new-report-editor-" + count + "'>";
        add_diagnosis += "</div>";
        add_diagnosis += "</div>";


        var content = dependency + '||' + add_diagnosis + '++';

        var existing_content = $("input[name='newdiagnosis']").val();

        $("input[name='newdiagnosis']").val(content + existing_content);

        $(this).parent().parent().parent().after(add_diagnosis);
    }

});
$(document).on('click', '.new-report-editing', function(e) {
    e.preventDefault();
    var editor_count = $(this).parent().data('count');

    $(this).parent().attr('title', 'Done').html('<i class="fa fa-check new-report-done" aria-hidden="true"></i>');

    var problemcontent = $('.new-report-editor-' + editor_count).html().trim();
    var options = '<div class="form-group">';
    options += '<textarea id="new_temp' + editor_count + '" class="form-control" rows="5" name="new_temp' + editor_count + '" cols="50">' + problemcontent + '</textarea>';
    options += '</div>';
    $('.new-report-editor-' + editor_count).html(options);
    CKEDITOR.replace('new_temp' + editor_count);
    var old_content = CKEDITOR.instances['new_temp' + editor_count].getData().replace(/<hr>/g, '<hr />');
    old_content = old_content.replace(/<br>/g, '<br />');
    // setStatus();
    CKEDITOR.instances["new_temp" + editor_count].on('blur', function() {
        setStatus();
        var problemContentfields = CKEDITOR.instances['new_temp' + editor_count].getData();
        $('input[name="diagnosis-' + editor_count + '"]').parent().find('a').attr('title', 'Edit').html('<i class="fa fa-pencil new-report-editing" aria-hidden="true"></i>');

        var html_content = $.parseHTML(problemContentfields); //parseHTML return HTMLCollection
        var filtered_content = $(html_content).text().trim();

        if (!filtered_content.length > 0) {
            problemContentfields = '';
        }

        $('input[name="diagnosis-' + editor_count + '"]').val(problemContentfields);
        $('.new-report-editor-' + editor_count).html(problemContentfields);

        var diagnosis_content = $('input[name="newdiagnosis"]').val();
        var old_diagnosis_content = "new-report-editor-" + editor_count + "'>" + old_content;
        var new_diagnosis_content = "new-report-editor-" + editor_count + "'>" + problemContentfields;

        $('input[name="newdiagnosis"]').val(diagnosis_content.replace(old_diagnosis_content, new_diagnosis_content));

        updateDaycareReport();
    });
});
// new report
$(document).on('click', '.new-report-done', function(e) {
    e.preventDefault();
    var editor_count = $(this).parent().data('count');
    var problemContentfields = CKEDITOR.instances['new_temp' + editor_count].getData();
    var old_content = CKEDITOR.instances['new_temp' + editor_count].getData().replace(/<hr>/g, '<hr />');
    old_content = old_content.replace(/<br>/g, '<br />');
    $(this).parent().attr('title', 'Edit').html('<i class="fa fa-pencil new-report-editing" aria-hidden="true"></i>');

    var html_content = $.parseHTML(problemContentfields); //parseHTML return HTMLCollection
    var filtered_content = $(html_content).text().trim();

    if (!filtered_content.length > 0) {
        problemContentfields = '';
    }

    $('input[name="diagnosis-' + editor_count + '"]').val(problemContentfields);
    $('.new-report-editor-' + editor_count).html(problemContentfields);

    var diagnosis_content = $('input[name="newdiagnosis"]').val();
    var old_diagnosis_content = "new-report-editor-" + editor_count + "'>" + old_content;
    var new_diagnosis_content = "new-report-editor-" + editor_count + "'>" + problemContentfields;

    $('input[name="newdiagnosis"]').val(diagnosis_content.replace(old_diagnosis_content, new_diagnosis_content));
    // setStatus();
});
$(document).ready(function() {
    if ($('body div').hasClass('nicu-discharge-report')) {
        CKEDITOR.config.removeButtons = 'HorizontalRule,Smiley';
        CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
        // CKEDITOR.config.startupFocus = true;
    }
    $('.check-box-div input[type="checkbox"], .generated-content-container input[type="checkbox"], .editor-align input[type="checkbox"]').prop('checked', true);
});
