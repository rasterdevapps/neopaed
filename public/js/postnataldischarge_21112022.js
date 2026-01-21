var getUrl = window.location;
var baseUrl = getUrl.protocol + "//" + getUrl.host + getUrl.pathname.split("postproblem-systems-summary")[0];
var url1 = baseUrl + 'postnatal-summary-reports-editors';
var url2 = baseUrl + 'postproblem-systems-summary';
$('.open-editor').click(function () {
    bootbox.confirm("If you edit this document, the changes will not be reflected in the main database and vice versa. Do you still want to continue?", function (confirmed) {
        if (confirmed) {
            var requestUrl = "{{ url('postnatal-summary-abbreviated/'.Request::segment(2)) }}";
            $.ajax({
                type: "GET",
                url: url1,
                data: {
                    dataUrl: requestUrl
                },
                cache: false,
                dataType: "json",
                success: function (responseText) {
                    window.location = requestUrl;
                },
                error: function (response) {}
            });
        }
    });
});
$(document).ready(function () {
    if ($('body div').hasClass('postnatal-summary')) {
        CKEDITOR.config.removeButtons = 'HorizontalRule,Smiley';
        CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
    }
    $('.input[type="checkbox"]').prop('checked', true);
    CKEDITOR.on('instanceReady', function (ev) {
        ev.editor.focus();
        var s = ev.editor.getSelection(); // getting selection
        var selected_ranges = s.getRanges(); // getting ranges
        var node = selected_ranges[0].startContainer; // selecting the starting node
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
        selected_ranges[0].collapse(false); //  false collapses the range to the end of the selected node, true before the node.
        s.selectRanges(selected_ranges); // putting the current selection there
    });
});

$(document).on('click', '.postnatal-summary h5 > .check-box-div > input[type="checkbox"]', function () {
    if ($(this).prop('checked') == false) {
        $(this).parent().parent().parent().addClass('hidden-print').addClass('active-checkbox');
        $('.savebtn').removeClass('hide');
    } else {
        $(this).parent().parent().parent().removeClass('hidden-print').removeClass('active-checkbox');
    }
});
$(document).on('click', '.postnatal-summary .generated-content-checkbox-div input[type="checkbox"]', function () {
    if ($(this).prop('checked') == false) {
        $(this).parents('.generated-content-container').addClass('hidden-print').addClass('active-checkbox');
        $('.savebtn').removeClass('hide');
    } else {
        $(this).parents('.generated-content-container').removeClass('hidden-print').removeClass('active-checkbox');
    }
});
$(document).on('click', '.postnatal-summary .editor-align input[type="checkbox"]', function () {
    if ($(this).prop('checked') == false) {
        $(this).parents('.editor-align').addClass('hidden-print').addClass('active-checkbox');
        $('.savebtn').removeClass('hide');
    } else {
        $(this).parents('.editor-align').removeClass('hidden-print').removeClass('active-checkbox');
    }
});
$(document).on('click', '.postnatal-summary .parent-generated-content-checkbox-div input[type="checkbox"]', function () {
    if ($(this).prop('checked') == false) {
        $(this).parents('.parent-generated-content-container').addClass('hidden-print').addClass('active-checkbox');
    } else {
        $(this).parents('.parent-generated-content-container').removeClass('hidden-print').removeClass('active-checkbox');
    }
});

var copy_btn_clicked = false;
$(document).on('click', '.post-report-editing', function (e) {
    e.preventDefault();
    var post_report_id = $(this).attr("data-post-report");
    var problem = $(this).attr("data-post-problem");
    var episode = $(this).attr("data-post-episode");

    $(this).parent().attr('title', 'Done').html('<i class="fa fa-check post-report-done" id="problems-post-report-' + post_report_id + '" data-post-report-done="' + post_report_id + '" data-post-report="' + post_report_id + '" aria-hidden="true" data-problem="' + problem + '" data-episode="' + episode + '"></i><i class="fas fa-copy new-report-done_copy" data-post-report-done="' + post_report_id + '" data-post-report="' + post_report_id + '" aria-hidden="true" data-problem="' + problem + '" data-episode="' + episode + '"></i>');
    $('form').prepend('<input type="hidden" name="editor_val[' + problem + '][' + episode + ']" />');
    var problemcontent = $('#post-report-editor-' + post_report_id + ' .editor-align-content').html().trim();
    $('#post-report-editor-' + post_report_id).removeClass('hide');
    
    var options = '<div class="form-group">';
    options += '<textarea id="post_report_temp_' + post_report_id + '" class="form-control" rows="5" name="post_report_temp" cols="50">' + problemcontent + '</textarea>';
    options += '</div>';
    
    $('#post-report-editor-' + post_report_id).html(options);
    CKEDITOR.replace('post_report_temp_' + post_report_id);

    CKEDITOR.instances["post_report_temp_" + post_report_id].on('blur', function () {
        setStatus();
        var problemContentfields = CKEDITOR.instances['post_report_temp_' + post_report_id].getData();

        $("#problems-post-report-" + post_report_id).parent().parent().find('a').attr('title', 'Edit').html('<i class="fa fa-pencil post-report-editing" data-post-report="' + post_report_id + '" id="problems-post-report-editing-' + post_report_id + '" aria-hidden="true"></i>');

        var problemContentCheckbox = '<input class="hidden-print" title="Remove from the print" checked="checked" name="printstatus" type="checkbox" value="">';

        var problem_content_fields = '<div class="editor-align-checkbox-div">';
        problem_content_fields += '<input class="hidden-print" title="Remove from the print" id="post-report-editor-' + post_report_id + '-checkbox" checked="checked" name="printstatus" type="checkbox" value="">';
        problem_content_fields += '<label for="post-report-editor-' + post_report_id + '-checkbox"><span class="hidden-print"></span></label>';
        problem_content_fields += '</div>';
        problem_content_fields += '<div class="editor-align-content">';
        problem_content_fields += problemContentfields;
        problem_content_fields += '</div>';

        var html_content = $.parseHTML(problemContentfields); //parseHTML return HTMLCollection
        var filtered_content = $(html_content).text().trim();

        if (copy_btn_clicked) {
            var editor = CKEDITOR.instances['post_report_temp_' + post_report_id];
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
            $("#post-problems-report-" + post_report_id).parent().parent().find('a').attr('title', 'Done').html('<i class="fa fa-check post-report-done" id="problems-post-report-' + post_report_id + '" data-post-report-done="' + post_report_id + '" data-post-report="' + post_report_id + '" aria-hidden="true" data-problem="' + problem + '" data-episode="' + episode + '"></i><i class="fas fa-copy new-report-done_copy" data-post-report-done="' + post_report_id + '" data-post-report="' + post_report_id + '" aria-hidden="true" data-problem="' + problem + '" data-episode="' + episode + '"></i>');
        } else {
            if (filtered_content.length > 0) {
                $('#post-report-editor-' + post_report_id).html(problemContentCheckbox + problem_content_fields);
                $("input[name='editor_val[" + problem + "][" + episode + "]']").val(problemContentfields);
            } else {
                $('#post-report-editor-' + post_report_id).html(problem_content_fields);
                $('#post-report-editor-' + post_report_id).addClass('hide');
                $("input[name='editor_val[" + problem + "][" + episode + "]']").val('');
            }
        }

        copy_btn_clicked = false;
        updateProblemReport();
    });
});
$(document).on('click', '.post-report-done', function (e) {
    e.preventDefault();
    var post_report_id = $(this).attr("data-post-report-done");
    var problem = $(this).attr("data-post-problem");
    var episode = $(this).attr("data-post-episode");
    var problemContentfields = CKEDITOR.instances['post_report_temp_' + post_report_id].getData();
    $(this).parent().attr('title', 'Edit').html('<i class="fa fa-pencil post-report-editing" id="problems-post-report-editing-' + post_report_id + '" data-post-report="' + post_report_id + '" data-problem="' + problem + '" data-episode="' + episode + '" aria-hidden="true"></i>');

    var problemContentCheckbox = '<input class="hidden-print" title="Remove from the print" checked="checked" name="printstatus" type="checkbox" value="">';

    var problem_content_fields = '<div class="editor-align-checkbox-div">';
    problem_content_fields += '<input class="hidden-print" title="Remove from the print" id="post-report-editor-' + post_report_id + '-checkbox" checked="checked" name="printstatus" type="checkbox" value="">';
    problem_content_fields += '<label for="post-report-editor-' + post_report_id + '-checkbox"><span class="hidden-print"></span></label>';
    problem_content_fields += '</div>';
    problem_content_fields += '<div class="editor-align-content">';
    problem_content_fields += problemContentfields;
    problem_content_fields += '</div>';

    var html_content = $.parseHTML(problemContentfields); //parseHTML return HTMLCollection
    var filtered_content = $(html_content).text().trim();

    if (filtered_content.length > 0) {
        $('#post-report-editor-' + post_report_id).html(problemContentCheckbox + problem_content_fields);
        $('input[name="problems"]').val('');
    } else {
        $('#post-report-editor-' + post_report_id).html(problem_content_fields);
        $('#post-report-editor-' + post_report_id).addClass('hide');
        $('input[name="problems"]').val('');
    }

});

function updateProblemReport() {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: url2,
        data: $('#post-problem-summary').serialize(),
        cache: false,
        dataType: "json",
        success: function (response) {},
        error: function (response) {
            Showalert('error', 'Record Not Saved. Try after some time !');
        }
    });
}
$(document).on('click', '.new-preport-editing', function (e) {
    e.preventDefault();
    var editor_count = $(this).parent().data('count');

    $(this).parent().attr('title', 'Done').html('<i class="fa fa-check new-preport-done" aria-hidden="true"></i><i class="fas fa-copy new-preport-done_copy" aria-hidden="true"></i>');

    var problemcontent = $('#new-problem-report-editor-' + editor_count + ' .editor-align-content').html().trim();
    $('#new-problem-report-editor-' + editor_count).removeClass('hide');
    var options = '<div class="form-group">';
    options += '<textarea id="new_ptemp' + editor_count + '" class="form-control" rows="5" name="new_ptemp' + editor_count + '" cols="50">' + problemcontent + '</textarea>';
    options += '</div>';
    $('#new-problem-report-editor-' + editor_count).html(options);
    CKEDITOR.replace('new_ptemp' + editor_count);
    var old_content = CKEDITOR.instances['new_ptemp' + editor_count].getData().replace(/<hr>/g, '<hr />');
    CKEDITOR.instances["new_ptemp" + editor_count].on('blur', function () {
        setStatus();
        var problemContentfields = CKEDITOR.instances['new_ptemp' + editor_count].getData();

        $("#report-" + editor_count).attr('title', 'Edit').html('<i class="fa fa-pencil new-preport-editing" aria-hidden="true"></i>');

        var problemContentCheckbox = '<input class="hidden-print" title="Remove from the print" checked="checked" name="printstatus" type="checkbox" value="">';

        var problem_content_fields = '<div class="editor-align-checkbox-div">';
        problem_content_fields += '<input class="hidden-print" title="Remove from the print" id="edited-checkbox-' + editor_count + '" checked="checked" name="printstatus" type="checkbox" value="">';
        problem_content_fields += '<label for="edited-checkbox-' + editor_count + '"><span class="hidden-print"></span></label>';
        problem_content_fields += '</div>';
        problem_content_fields += '<div class="editor-align-content">';
        problem_content_fields += problemContentfields;
        problem_content_fields += '</div>';

        var html_content = $.parseHTML(problemContentfields); //parseHTML return HTMLCollection
        var filtered_content = $(html_content).text().trim();


        if (copy_btn_clicked) {
            var editor = CKEDITOR.instances['new_ptemp' + editor_count];
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
            $("#report-" + editor_count).attr('title', 'Done').html('<i class="fa fa-check new-preport-done" aria-hidden="true"></i><i class="fas fa-copy new-preport-done_copy" aria-hidden="true"></i>');
        } else {
            if (filtered_content.length > 0) { 
                $("#new-problem-report-editor-" + editor_count).html(problemContentCheckbox + problem_content_fields);
                $("input[name='editor_val[" + editor_count + "][0]']").val(problemContentfields);
            } else {
                $("#new-problem-report-editor-" + editor_count).html(problem_content_fields);
                $('#new-problem-report-editor-' + editor_count).addClass('hide');
                $("input[name='editor_val[" + editor_count + "][0]']").val('');
            }

        }

        copy_btn_clicked = false;
        updateProblemReport();
    });
});
$(document).on('click', '.new-preport-done', function (e) {
    e.preventDefault();
    var editor_count = $(this).parent().data('count');
    setStatus();
    var problemContentfields = CKEDITOR.instances['new_ptemp' + editor_count].getData();
    $(this).parent().attr('title', 'Edit').html('<i class="fa fa-pencil new-preport-editing" aria-hidden="true"></i>');

    var problemContentCheckbox = '<input class="hidden-print" title="Remove from the print" checked="checked" name="printstatus" type="checkbox" value="">';

    var problem_content_fields = '<div class="editor-align-checkbox-div">';
    problem_content_fields += '<input class="hidden-print" title="Remove from the print" id="edited-checkbox-' + editor_count + '" checked="checked" name="printstatus" type="checkbox" value="">';
    problem_content_fields += '<label for="edited-checkbox-' + editor_count + '"><span class="hidden-print"></span></label>';
    problem_content_fields += '</div>';
    problem_content_fields += '<div class="editor-align-content">';
    problem_content_fields += problemContentfields;
    problem_content_fields += '</div>';

    var html_content = $.parseHTML(problemContentfields); //parseHTML return HTMLCollection
    var filtered_content = $(html_content).text().trim();

    if (filtered_content.length > 0) {
        $("#new-problem-report-editor-" + editor_count).html(problemContentCheckbox + problem_content_fields);
        $("input[name='editor_val[" + editor_count + "][0]']").val('');
    } else {
        $("#new-problem-report-editor-" + editor_count).html(problem_content_fields);
        $('#new-problem-report-editor-' + editor_count).addClass('hide');
        $("input[name='editor_val[" + editor_count + "][0]']").val('');
    }

});

function setStatus() {
    if (checkChanges()) {
        $('input[name="status"]').val(1);
        $('.savebtn').removeClass('hide');
    }
}

function checkChanges() {
    var isDirty = false;
    for (var i in CKEDITOR.instances) {
        if (CKEDITOR.instances[i].checkDirty()) {
            return isDirty = true;
        }
    }
}
$(document).on('click', '.new-preport-done_copy', function (e) {
    copy_btn_clicked = true;
    e.preventDefault();
    var generated_content = $(this).parents('h5').next().find('.generated-content').html();
    var textarea_name = 'new_ptemp' + $(this).parent().attr('data-count');
    var peviousConent = CKEDITOR.instances[textarea_name].getData();
    if (generated_content === undefined || generated_content == '') {

    } else if (peviousConent == '' || peviousConent == null) {
        var problemContentfields = CKEDITOR.instances[textarea_name].setData(generated_content);
    } else {
        // if (confirm('Do you want to remove the updated content in editor?')) {
            var problemContentfields = CKEDITOR.instances[textarea_name].setData(peviousConent + generated_content);
        // }
    }
});

$(document).on('click', '.new-report-done_copy', function (e) {
    copy_btn_clicked = true;
    e.preventDefault();
    var generated_content = $(this).parents('h6').next().find('.generated-content').html();
    var textarea_name = 'post_report_temp_' + $(this).attr('data-post-report-done');
    var peviousConent = CKEDITOR.instances[textarea_name].getData();
    if (generated_content === undefined || generated_content == '') {

    } else if (peviousConent == '' || peviousConent == null) {
        var problemContentfields = CKEDITOR.instances[textarea_name].setData(generated_content);
    } else {
        // if (confirm('Do you want to remove the updated content in editor?')) {
            var problemContentfields = CKEDITOR.instances[textarea_name].setData(peviousConent + generated_content);
        // }
    }
});

$(document).on('click', '.neonatal-intensive-care-save', function () {

    var ip_and_folder_name = window.location.href.split('postproblem-systems-summary')[0];

    var summary_text = $('.container.main .temp-container').html();
    var baby_id = $('input[name="baby_id"]').val();
    var admission_id = $('input[name="admission_id"]').val();
    var mrn = $('input[name="BMrNo"]').val();

    summary_text = summary_text.replace(ip_and_folder_name, 'HOSTPATH');

    savePrintedContent2(baby_id, admission_id, mrn, summary_text);

    location.reload();
});
