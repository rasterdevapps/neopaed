@section('scripts')
<script type="text/javascript">

    var warning_text = "Do you want to approve this summary?";
    var version_unsupport = '<span class="error-message">This summary doesn\'t support E-sign. Please generate a new summary to approve.</span>';

    if (window.location.href.indexOf("nicu-discharge-summary") !== -1) {

        var ip_and_folder_name = window.location.href.split('nicu-discharge-summary')[0];

        $(document).on('click', '.printed-list-btn.unactive', function() {

            $('html, body').animate({scrollTop : 0},800);

            $('.container').addClass('half-page').addClass('original');

            $('.btn.back-close-btn').addClass('hide');

            $('.btn.print-btn[title="print"]').addClass('hide');
            $('.btn.back-discharge').addClass('hide');
            $('#discharge-edit-btn').addClass('hide');
            $(this).removeClass('unactive');
            $(this).addClass('active');
            $(this).find('i').addClass('fa').addClass('fa-times').removeClass('fas').removeClass('fa-list');
            $(this).addClass('close-btn');

            var baby_id = $('input[name="BabyId"]').val();

            $('.temp-row').addClass('disabled-content');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                data: {baby_id: baby_id},
                url: "{{ action('Reports\NicuDischargeController@getPrintedContent') }}",
                success: function(response) {
                    loadGeneratedList(response);
                }
            });

        });

        $(document).on('click', '.old-print', function() {
            var id = $(this).attr('data-id');
            if ($('.old-print').hasClass('btn-success')) {
                $('.old-print').addClass('btn-info').removeClass('btn-success');
            }
            $(this).addClass('btn-success').removeClass('btn-info');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                data: {id: id},
                url: "{{ action('Reports\NicuDischargeController@getPrintedHtmlContent') }}",
                async: false,
                success: function(response) {
                    loadGeneratedContent(response, id);
                }
            });
        });

        $(document).on('click', '.approve-print', function() {
            var id = $(this).attr('data-id');
            $('.old-print[data-id="'+id+'"]').trigger('click');
            if ($('.half-page:not(.original) .discharge-info table').find('span').hasClass('signature-tag')) {
                bootbox.dialog({
                    message: warning_text,
                    buttons: {
                        ok: {
                            label: "No",
                            className: "btn-default"
                        },
                        confirm: {
                            label: "Yes",
                            className: "btn-primary",
                            callback: function() {
                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    type: 'PATCH',
                                    data: {id: id},
                                    url: "{{ action('Reports\NicuDischargeController@summaryApproval') }}",
                                    success: function(response) {
                                        if (response.type == 'success') {
                                            $('.old-print[data-id="'+id+'"]').trigger('click');
                                            $('.printed-list .approve-print[data-id="'+id+'"]').removeClass('approve-print').addClass('already-approve').removeClass('btn-warning').addClass('btn-success').removeClass('approve-print').addClass('already-approve').find('i').removeClass('fa-shield').addClass('fa-check');
                                            $('.print-tool-bar1 .approve-print[data-id="'+id+'"]').remove();
                                            Showalert(response.type, response.msg);  
                                        }
                                    }
                                });
                            }
                        }
                    }
                });       
            } else {
                bootbox.dialog({
                    message: version_unsupport
                });
            }  
        });
    } else if (window.location.href.indexOf("problems-discharge-summary") !== -1) {

        var ip_and_folder_name = window.location.href.split('problems-discharge-summary')[0];

        $(document).on('click', '.printed-list-btn.unactive', function() {

            $('html, body').animate({scrollTop : 0},800);

            $('.container').addClass('half-page').addClass('original');

            $('.btn.close-btn').addClass('hide');

            $('.btn.print-btn[title="print"]').addClass('hide');
            $('.btn.back-discharge').addClass('hide');
            $(this).removeClass('unactive');
            $(this).addClass('active');
            $(this).find('i').addClass('fa').addClass('fa-times').removeClass('fas').removeClass('fa-list');
            $(this).addClass('close-btn');

            var baby_id = $('input[name="BabyId"]').val();
            var admission_id = $('input[name="AdmissionId"]').val();
            
            $('.temp-row').addClass('disabled-content');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                data: {baby_id: baby_id, admission_id: admission_id},
                url: "{{ action('Reports\ProblemDischargeController@getPrintedContent') }}",
                success: function(response) {
                    loadGeneratedList(response);
                }
            }); 

        });

        $(document).on('click', '.old-print', function() {
            var id = $(this).attr('data-id');
            if ($('.old-print').hasClass('btn-success')) {
                $('.old-print').addClass('btn-info').removeClass('btn-success');
            }
            $(this).addClass('btn-success').removeClass('btn-info');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                data: {id: id},
                url: "{{ action('Reports\ProblemDischargeController@getPrintedHtmlContent') }}",
                async: false,
                success: function(response) {
                    loadGeneratedContent(response, id);
                }
            });
        });

        $(document).on('click', '.approve-print', function() {
            var id = $(this).attr('data-id');
            $('.old-print[data-id="'+id+'"]').trigger('click');
            if ($('.half-page:not(.original) .summary-info table.full-width').find('span').hasClass('signature-tag')) {
                bootbox.dialog({
                    message: warning_text,
                    buttons: {
                        ok: {
                            label: "No",
                            className: "btn-default"
                        },
                        confirm: {
                            label: "Yes",
                            className: "btn-primary",
                            callback: function() {
                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    type: 'PATCH',
                                    data: {id: id},
                                    url: "{{ action('Reports\ProblemDischargeController@summaryApproval') }}",
                                    success: function(response) {
                                        if (response.type == 'success') {
                                            $('.old-print[data-id="'+id+'"]').trigger('click');
                                            $('.printed-list .approve-print[data-id="'+id+'"]').removeClass('approve-print').addClass('already-approve').removeClass('btn-warning').addClass('btn-success').find('i').removeClass('fa-shield').addClass('fa-check');
                                            $('.print-tool-bar1 .approve-print[data-id="'+id+'"]').remove();
                                            Showalert(response.type, response.msg);
                                        }
                                    }
                                });
                            }
                        }
                    }
                });
            } else {
                bootbox.dialog({
                    message: version_unsupport
                });
            }
        });

    } else if (window.location.href.indexOf("postproblem-systems-summary") !== -1) {

        var ip_and_folder_name = window.location.href.split('postproblem-systems-summary')[0];

        $(document).on('click', '.printed-list-btn.unactive', function() {

            $('html, body').animate({scrollTop : 0},800);
            
            $('.container').addClass('half-page').addClass('original');

            $('.btn.close-btn').addClass('hide');

            $('.btn.print-btn[title="print"]').addClass('hide');
            $('.btn.back-discharge').addClass('hide');
            $(this).removeClass('unactive');
            $(this).addClass('active');
            $(this).find('i').addClass('fa').addClass('fa-times').removeClass('fas').removeClass('fa-list');
            $(this).addClass('close-btn');

            var baby_id = $('input[name="baby_id"]').val();
            var admission_id = $('input[name="admission_id"]').val();
            
            $('.temp-row').addClass('disabled-content');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                data: {baby_id: baby_id, admission_id:admission_id},
                url: "{{ action('Reports\PostnatalDischargeSummary@getPrintedContent') }}",
                success: function(response) {
                    loadGeneratedList(response);
                }
            }); 

        });

        $(document).on('click', '.old-print', function() {
            var id = $(this).attr('data-id');
            if ($('.old-print').hasClass('btn-success')) {
                $('.old-print').addClass('btn-info').removeClass('btn-success');
            }
            $(this).addClass('btn-success').removeClass('btn-info');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                data: {id: id},
                url: "{{ action('Reports\PostnatalDischargeSummary@getPrintedHtmlContent') }}",
                async: false,
                success: function(response) {
                    loadGeneratedContent(response, id);
                }
            });
        });

        $(document).on('click', '.approve-print', function() {
            var id = $(this).attr('data-id');
            $('.old-print[data-id="'+id+'"]').trigger('click');
            if ($('.half-page:not(.original) .postnatal-summary-content > div:last-child > table > tbody > tr > td:last-child table.full-width').find('span').hasClass('signature-tag')) {
                bootbox.dialog({
                    message: warning_text,
                    buttons: {
                        ok: {
                            label: "No",
                            className: "btn-default"
                        },
                        confirm: {
                            label: "Yes",
                            className: "btn-primary",
                            callback: function() {
                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    type: 'PATCH',
                                    data: {id: id},
                                    url: "{{ action('Reports\PostnatalDischargeSummary@summaryApproval') }}",
                                    success: function(response) {
                                        if (response.type == 'success') {
                                            $('.old-print[data-id="'+id+'"]').trigger('click');
                                            $('.printed-list .approve-print[data-id="'+id+'"]').removeClass('approve-print').addClass('already-approve').removeClass('btn-warning').addClass('btn-success').find('i').removeClass('fa-shield').addClass('fa-check');
                                            $('.print-tool-bar1 .approve-print[data-id="'+id+'"]').remove();
                                            Showalert(response.type, response.msg);
                                        }
                                    }
                                });
                            }
                        }
                    }
                });       
            } else {
                bootbox.dialog({
                    message: version_unsupport
                });
            }    
        });
    }


    $(document).on('click', '.printed-list-btn.active', function() {
        $('.container.half-page:not(.original)').remove();
        $('.container').removeClass('half-page').removeClass('original');
        
        $('.btn.back-close-btn').removeClass('hide');
        $('#discharge-edit-btn').removeClass('hide');
        
        $('.btn.print-btn[title="print"]').removeClass('hide');
        $('.btn.back-discharge').removeClass('hide');
        $(this).removeClass('active');
        $(this).addClass('unactive');
        $(this).find('i').removeClass('fa').removeClass('fa-times').addClass('fas').addClass('fa-list');
        $(this).removeClass('close-btn');

        $('#printed-content').parents(".container").remove();
        
        $('.temp-row').removeClass('disabled-content');
    });

    $(document).on('click', '.old_print', function() {

        $('.printed-list').addClass('hide');

        $('#special-print .container.main.original').addClass('hide');

        $('#printed-content').removeClass('printed-content-design');
        $('#printed-content').parents('.container.main').removeClass('half-page');

        $('.old_print').addClass('hide');

        $('.slide-up-down').addClass('hide');

        $(this).parents('body').addClass('print-copy-body');

        window.print();
        
    });

    window.onafterprint = function() {

        $('.printed-list').removeClass('hide');

        $('#special-print .container.main.original').removeClass('hide');

        $('#printed-content').addClass('printed-content-design');
        $('#printed-content').parents('.container.main').addClass('half-page');

        $('.old_print').removeClass('hide');

        $('body').removeClass('print-copy-body');

    }

    $(document).on('click', '.slide-up', function() {

        $(this).removeClass('slide-up').addClass('slide-down');
        $(this).find('i').removeClass('fa-arrow-circle-o-up').addClass('fa-arrow-circle-o-down');
        $(this).attr('title', 'Show List');
        $('.printed-list').slideUp();

    });

    $(document).on('click', '.slide-down', function() {

        $(this).removeClass('slide-down').addClass('slide-up');
        $(this).find('i').removeClass('fa-arrow-circle-o-down').addClass('fa-arrow-circle-o-up');
        $(this).attr('title', 'Hide List');
        $('.printed-list').slideDown();

    });

    function savePrintedContent(baby_id, mrn, summary_text) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type    : "POST",
            url     : "{{ action('Reports\NicuDischargeController@savePrintedContent') }}",
            data    : {baby_id: baby_id, baby_mrn: mrn, summary_text: summary_text},
            success:function(response){
                window.location.reload();
            },
            error: function(response) {
                Showalert('error','Record Not Saved. Try after some time !');  
            }
        });
    }

    function savePrintedContent1(baby_id, admission_id, mrn, summary_text) {

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type    : "POST",
            url     : "{{ action('Reports\ProblemDischargeController@savePrintedContent') }}",
            data    : {baby_id: baby_id, admission_id: admission_id, baby_mrn: mrn, summary_text: summary_text},
            success:function(response){
                window.location.reload();
            },
            error: function(response) {
                Showalert('error','Record Not Saved. Try after some time !');  
            }
        });
    }

    function savePrintedContent2(baby_id, admission_id, mrn, summary_text) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type    : "POST",
            url     : "{{ action('Reports\PostnatalDischargeSummary@savePrintedContent') }}",
            data    : {baby_id: baby_id, admission_id: admission_id, baby_mrn: mrn, summary_text: summary_text},
            success:function(response){
                window.location.reload();
            },
            error: function(response) {
                Showalert('error','Record Not Saved. Try after some time !');  
            }
        });
    }

    function loadGeneratedList(response) {
        var printed_copy_list_temp = '';
        $.each(response.get_printed_content, function(key, value) {
            var formatdate = value.printed_date_time;
            formatdate = formatdate.split(' ');
            var date = formatdate[0].split('-');
            var time = formatdate[1].split(':');
            var day = date[2];
            var month = date[1];
            var year = date[0];
            var hours = time[0];
            var minutes = time[1];
            var ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12;
            hours = hours < 10 ? '0' + hours : hours;

            formatdate = day + '-' + month + '-' + year + ' ' + hours + ':' + minutes + ' ' + ampm;

            if (key == 0) {
                printed_copy_list_temp += '<tr class="bg-success">';
            } else {
                printed_copy_list_temp += '<tr>';
            }
            printed_copy_list_temp += '<td>';
            printed_copy_list_temp += formatdate;
            printed_copy_list_temp += '</td>';
            printed_copy_list_temp += '<td>';
            printed_copy_list_temp += value.name;
            printed_copy_list_temp += '</td>';
            printed_copy_list_temp += '<td>';
            printed_copy_list_temp += '<button class="btn btn-info old-print" data-id="'+value.id+'"><i class="fa fa-eye"></i></button>';
            printed_copy_list_temp += '</td>';
            var old_approved_user_ids = value.approved_user_ids;
            var approval_action = response.summary_approval;
            if (approval_action) {
                printed_copy_list_temp += '<td>';
                if (old_approved_user_ids != null && old_approved_user_ids.indexOf(response.user_id) > -1) {
                    printed_copy_list_temp += '<button class="btn btn-success already-approve" title="Approval completed"><i class="fa fa-check"></i></button>';
                } else {
                    printed_copy_list_temp += '<button class="btn btn-warning approve-print" title="Need your approval" data-id="'+value.id+'"><i class="fa fa-shield"></i></button>';                                
                }
                printed_copy_list_temp += '</td>';
            }
            printed_copy_list_temp += '</tr>';
        });
        var printed_copy_list = '<div class="container main half-page">';
        printed_copy_list += '<div class="printed-list">';
        printed_copy_list += '<table class="table table-striped table-bordered table-responsive" style="margin-bottom: 0px !important;">';
        printed_copy_list += '<thead>';
        printed_copy_list += '<tr>';
        printed_copy_list += '<th>';
        printed_copy_list += 'Generated Date';
        printed_copy_list += '</th>';
        printed_copy_list += '<th>';
        printed_copy_list += 'Generated By';
        printed_copy_list += '</th>';
        printed_copy_list += '<th>';
        printed_copy_list += 'Preview';
        printed_copy_list += '</th>';
        if (response.summary_approval) {
            printed_copy_list += '<th>';
            printed_copy_list += 'Approve';
            printed_copy_list += '</th>';
        }
        printed_copy_list += '</tr>';
        printed_copy_list += '</thead>';
        printed_copy_list += '<tbody>';
        printed_copy_list += printed_copy_list_temp;
        printed_copy_list += '</tbody>';
        printed_copy_list += '</table>';
        printed_copy_list += '</div>';
        printed_copy_list += '<div class="col-xs-12 mb-10 slide-up-down">';
        printed_copy_list += '<span class="slide-up pull-right" title="Hide List"><i class="fa fa-arrow-circle-o-up fa-2x" aria-hidden="true"></i></span>';
        printed_copy_list += '</div>';
        printed_copy_list += '<div id="printed-content" class="printed-content-design">';
        printed_copy_list += '</div>';
        printed_copy_list += '</div>';

        if ($('.container.main.half-page:not(.original)').html() == undefined) {
            $(printed_copy_list).insertAfter(".container.main.half-page.original");
        }
    } 

    function loadGeneratedContent(response, id) {

        var html = response.get_printed_html_content;

        html = html.replace('HOSTPATH', ip_and_folder_name);

        $('#printed-content').html(html);
        var btn = '<div class="print-tool-bar1">';
        btn += '<a href="javascript:void(0);" class="btn print-btn pull-right old_print" title="print">';
        btn += '<i class="fa fa-print fa-2x" aria-hidden="true"></i>';
        btn += '</a>';
        if ($('.approve-print[data-id="'+id+'"]').hasClass('btn-warning')) {
            btn += '<a href="javascript:void(0);" class="btn btn-default approve-print pull-right approve-status" title="Need your approval" data-id="'+id+'">';
            btn += '<i class="fa fa-shield fa-2x" aria-hidden="true"></i>';
            btn += '</a>';
        } else {
            // btn += '<a href="javascript:void(0);" class="btn btn-default pull-right approve-status" title="Approval completed" data-id="'+id+'">';
            // btn += '<i class="fa fa-check fa-2x" aria-hidden="true"></i>';
            // btn += '</a>';
        }
        btn += '</div>';
        $('#printed-content').prepend(btn);
        $('#printed-content .active-checkbox').each(function() {
            var id = $(this).find('input[type="checkbox"]').attr('id');
            $('#printed-content #'+id).trigger('click');
        });
        var signature_list = $('#printed-content').find('.signature-tag');
        $(signature_list).each(function() {
            if (typeof $(this).find('img').attr('src') != 'undefined') {
                $(this).parent().removeClass('mt-50');
            }
        });
    }

</script>
@endsection

