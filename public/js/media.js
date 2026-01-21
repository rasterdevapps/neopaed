$(document).ready(function() {

    if ((window.location.href.indexOf("out-patient") !== -1 && window.location.href.indexOf("visite-list") !== -1) || (window.location.href.indexOf("neuro-develop") !== -1 && window.location.href.indexOf("visite-list") !== -1) || (window.location.href.indexOf("nicu-nurse-sheets") !== -1 && window.location.href.indexOf("nicu-nurse-sheet-day") !== -1) || (window.location.href.indexOf("nicu-admission") !== -1 && window.location.href.indexOf("sub-nicu-list") !== -1) || (window.location.href.indexOf("daycare-admission") !== -1 && window.location.href.indexOf("daycare-admission-daylist") !== -1) || (window.location.href.indexOf("pediatric-admission") !== -1 && window.location.href.indexOf("sub-list") !== -1)) {

        $('.preview-block').on('click', function() {
            var type = $(this).attr('data-type');
            var parent_element = $(this).parents('td').find('a');
            var edit_link = parent_element.attr('href');
            edit_link = edit_link.split('?')[0];
            edit_link = $.trim(edit_link);
            edit_link = edit_link + '?filter='+type;
            parent_element.attr('href', edit_link);
            window.location.href = edit_link;
        });

    } else {

        var urlParams = new URLSearchParams(window.location.search);
        var filter_given = urlParams.has('filter');
        var filter_file_type = urlParams.get('filter');

        if (filter_given) {
            $('ul[role="tablist"] li').removeClass('active');
            $('a[href="#media_tab"]').parent().addClass('active');

            $('.tab-pane').removeClass('active');
            $('#media_tab').addClass('active');
        } else {
            filter_file_type = 'All';
        }

        var file_list = temp_file_name = file_size = '';
        var module_name = $("input[name='module_name']").val();
        var site_base_url = $("input[name='site_base_url']").val();
        var file_path = '';
        var file_name = [];
        var error_list = '';
        var modal_close = true;
        var allow_close = false;
        var every_first = true;
        var modal_count = 1;

        $(window).load(function() {
            setTimeout(function() {
                processFiles();     
                getUploadedFiles();
            }, 1000);
        });
        $('label.media-label').on('click', function() {
            filter_file_type = $(this).attr('for');
            $('.media-label').attr('attr-option', 0);
            $('#empty-loading').removeClass('hide');
            $('#upload-loading').addClass('hide');
            getUploadedFiles();
        });

        function getUploadedFiles() {
            $('label[for="'+filter_file_type+'"]').attr('attr-option', 1);
            var visit_id = $("input[name='visit_id']").val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                data: {
                    id: visit_id,
                    module_name: module_name,
                    attachment_type: filter_file_type,
                },
                url: site_base_url + "/get-uploaded-files",
                success: function(response) {
                    $("input[name='file_list']").val(response.file_list);
                    $("input[name='file_name']").val(response.file_name);
                    $("input[name='file_size']").val(response.file_size);
                    var uploaded_count = response.file_count;
                    if (uploaded_count > 0) {
                        $('a[href="#media_tab"]').append('<span id="uploaded-count">'+uploaded_count+'</span>');
                    }
                    file_path = response.base_file_path;
                    file_name = [];
                    assignUploadedFiles();
                    processFiles();
                }
            });
            setTimeout(function() {
                var image_count = 1;
                $('.file-preview-frame[data-template="image"]:not([title]) .kv-file-download').each(function() {
                    $(this).parent().prepend('<a class="btn btn-default btn-kv print-image" data-path="' + $(this).attr('href') + '" id="image_count_' + image_count + '"><i class="fa fa-print"></i></a>');
                    image_count++;
                });
            }, 500);
        }

        function assignUploadedFiles() {
            var u_file_list = $("input[name='file_list']").val();
            if (typeof u_file_list !== 'undefined') {
                file_list = JSON.parse(u_file_list);
            }
            var u_temp_file_name = $("input[name='file_name']").val();
            if (typeof u_temp_file_name !== 'undefined') {
                temp_file_name = JSON.parse(u_temp_file_name);
            }
            var u_file_size = $("input[name='file_size']").val();
            if (typeof u_file_size !== 'undefined') {
                file_size = JSON.parse(u_file_size);
            }
            $.each(temp_file_name, function(key, value) {
                var attachment_type = value.split('.');
                var type = attachment_type;
                var filetype = '';
                if (type[1] == 'mp4' || type[1] == 'webm') {
                    type = 'video';
                    filetype = 'video/mp4';
                } else if (type[1] == 'mp3' || type[1] == 'wav') {
                    type = 'audio';
                } else if (type[1] == 'pdf') {
                    type = 'pdf';
                // } else if (type[1] == 'doc' || type[1] == 'docx' || type[1] == 'xls' || type[1] == 'xlsx') {
                    // type = 'office';
                } else {
                    type = 'image';
                }
                var temp = {
                    caption: value,
                    type: type,
                    filetype: filetype,
                    downloadUrl: file_path + value,
                    size: file_size[value]
                };
                file_name.push(temp);
            });
            return true;
        }

        function processFiles() {
            var $el1 = $("#file-1");
            var temp_error = false;
            if (!every_first) {
                $el1.fileinput('destroy');
                $('#empty-loading').addClass('hide');
                $('#upload-loading').removeClass('hide');
            } else {
                every_first = false;
            }

            var allowed_file_extensions = ['jpg', 'jpeg', 'png', 'svg', 'doc', 'docx', 'pdf', 'xls', 'xlsx', 'csv', 'mp3', 'mp4', 'wmv', 'avi', 'mkv', 'webm', 'mpg', 'mpeg', 'mov', 'wav']; 
            
            if (filter_file_type == 'Image') {
                allowed_file_extensions = ['jpg', 'jpeg', 'png', 'svg']; 
            } else if (filter_file_type == 'Document') {
                allowed_file_extensions = ['doc', 'docx']; 
            } else if (filter_file_type == 'pdf') {
                allowed_file_extensions = ['pdf']; 
            } else if (filter_file_type == 'Excel') {
                allowed_file_extensions = ['xls', 'xlsx', 'csv']; 
            } else if (filter_file_type == 'Video') {
                allowed_file_extensions = ['mp4', 'wmv', 'avi', 'mkv', 'webm', 'mpg', 'mpeg', 'mov', 'wav']; 
            } else if (filter_file_type == 'Audio') {
                allowed_file_extensions = ['mp3']; 
            }

            $el1.fileinput({
                initialPreview: file_list,
                initialPreviewAsData: true,
                initialPreviewConfig: file_name,
                allowedFileExtensions: allowed_file_extensions,
                previewFileIconSettings: { // configure your icon file extensions
                    'doc': '<i class="fas fa-file-word text-primary"></i>',
                    'txt': '<i class="fas fa-file-alt text-info"></i>',
                    'mov': '<i class="fas fa-file-video text-warning"></i>',
                    'xls': '<i class="fas fa-file-excel text-success"></i>',
                },
                previewFileExtSettings: { // configure the logic for determining icon file extensions
                    'doc': function(ext) {
                        return ext.match(/(doc|docx)$/i);
                    },
                    'mp3': function(ext) {
                        return ext.match(/(wav)$/i);
                    },
                    'mov': function(ext) {
                        return ext.match(/(avi|wmv|mpg|mpeg|mov|mkv)$/i);
                    },
                    'xls': function(ext) {
                        return ext.match(/(xls|xlsx)$/i);
                    },
                    'txt': function(ext) {
                        return ext.match(/(csv)$/i);
                    },
                },
                preferIconicPreview: true, // this will force thumbnails to display icons for following file extensions
                uploadUrl: site_base_url + "/image-upload",
                uploadExtraData: function() {
                    return {
                        _token: $("input[name='_token']").val(),
                        module_name: module_name,
                        visit_id: $("input[name='visit_id']").val(),
                    };
                },
                uploadAsync: true,
                showUpload: false, // hide upload button
                overwriteInitial: false, // append files to initial preview
                browseOnZoneClick: true,
                initialPreviewAsData: true,
            }).on('filebrowse', function(event) {
                if ($("#file-1").val() != '') {
                    $("#file-1").val('').trigger('change');
                }
            }).on("filebatchselected", function(e, file) {
                var overwritted_file_list = 'Already exist. "';
                var duplicate = 0;
                $.each(file, function(key, value) {
                    temp_error = true;
                    var iterate = 0;
                    var file_name = value.name;
                    file_name = file_name.replace(/[\[\]\/\{}:;#%=\(\)\*\+\?\\\^\$\|<>&"']/g, "_");
                    var old_file = $('div.file-footer-caption[title="' + file_name + '"]');
                    var length = old_file.length - 2;
                    $(old_file).each(function() {
                        var file_id = $(this).parents('.file-preview-frame.kv-preview-thumb').attr('id');
                        if (typeof file_id !== 'undefined' && length != iterate) {
                            var zoom_file_id = 'zoom-' + file_id;
                            $('#' + zoom_file_id).parent().remove();
                            $('#' + file_id).remove();
                            if (iterate == 0 && duplicate != 0) {
                                overwritted_file_list += ', ';
                            }
                            overwritted_file_list += file_name;
                            duplicate++;
                        }
                        iterate++;
                    });
                });
                if (file.length == 1) {
                    overwritted_file_list += '" file is replaced.</ul>';
                } else {
                    overwritted_file_list += '" file(s) are replaced.</ul>';
                }
                if (typeof file[0] !== 'undefined') {
                    $el1.fileinput("upload");
                    if (duplicate > 0) {
                        error_list += '<li>' + overwritted_file_list + '</li>';
                    }
                }
                if ($('.file-preview-frame').hasClass('file-preview-error')) {
                    $('.file-preview-frame.file-preview-error').remove();
                }
            }).on('fileerror', function(event, data, msg) {
                errorDisplay(msg);
            }).on('fileuploaderror', function(event, data, msg) {
                errorDisplay(msg);
            }).on('filebatchuploaderror', function(event, data, msg) {
                if (error_list.indexOf(msg) === -1) {
                    error_list += '<li>' + msg + '</li>';
                }
            }).on('filefoldererror', function(event, data, msg) {
                errorDisplay(msg);
            }).on('filebatchuploadcomplete', function(event, preview, config, tags, extraData) {
                if (!modal_close) {
                    $('#fileinput-error .bootbox-body').find('ul').html(error_list);
                } else {
                    var errors = '<ul>' + error_list + '</ul>';
                    if (temp_error && error_list != '') {
                        errorModal(errors);
                        temp_error = false;
                    }
                }
            });
            return true;
        }

        function errorDisplay(msg) {
            if (error_list.indexOf(msg) === -1) {
                error_list += '<li>' + msg + '</li>';
            }
            if (!modal_close) {
                $('#fileinput-error .bootbox-body').find('ul').html(error_list);
            } else {
                var errors = '<ul>' + error_list + '</ul>';
                errorModal(errors);
                modal_close = false;
            }
        }

        function errorModal(errors) {
            if (modal_count == 1) {
                bootbox.dialog({
                    title: '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Attention',
                    message: errors
                }).attr('id', 'fileinput-error');
            }
            modal_count++;
        }

        $(document).on("hidden.bs.modal", "#fileinput-error", function(e) {
            error_list = '';
            modal_close = true;
            modal_count = 1;
        });
        $(document).on("click", '.kv-file-remove', function() {
            var file_name = $(this).parents('.file-thumbnail-footer').find('.file-caption-info').html();
            var current_element = $(this).parents('.file-preview-frame.krajee-default.file-preview-initial.file-sortable.kv-preview-thumb');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: {
                    file_name: file_name,
                    module_name: module_name,
                    visit_id: $("input[name='visit_id']").val(),
                },
                url: site_base_url + "/image-delete",
                success: function(response) {
                    current_element.remove();
                }
            });
        });
        $(document).on('click', '.print-image', function() {
            var image_path = $(this).attr('data-path');
            var newWin = window.open('', 'Print-Window');
            newWin.document.open();
            newWin.document.write('<html><body onload="window.print()"><div style="max-width:100%;"><img style="max-width:100%;" src="' + image_path + '"/></div></body></html>');
            newWin.document.close();
            setTimeout(function() {
                newWin.close();
            }, 500);
        });

    }
    
});

