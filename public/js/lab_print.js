var col_limit_per_page = 7;
var sub_dates = [];
var dates = [];
var active_tab_id = 'hb';
var already_active = false;

function columnLimitPerPage() {
    if (window.screen.width > 1369) {
        col_limit_per_page = 7;
    } else if (window.screen.width > 1024) {
        col_limit_per_page = 5;
    } else if (window.screen.width > 768) {
        col_limit_per_page = 4;
    } else {
        col_limit_per_page = 3;
    }
}

function columnView() {
    sub_dates[active_tab_id] = [];
    dates[active_tab_id] = [];
    if (active_tab_id == 'hb') {
        var active_table_id = 'lab-report-table';
    } else if (active_tab_id == 'abg') {
        var active_table_id = 'abg-table';
    }
    /* For tab to display column values */
    var first_row = $('#' + active_table_id + ' thead tr:eq(0) th').toArray();
    $.each(first_row, function(key, value) {
        var th_date = value.innerText;
        th_date = th_date.replace(/([.*+?^$|(){}:\s\n\[\]])/mg, "");
        dates[active_tab_id].push(th_date);
    });
    dates[active_tab_id].shift();
    var dates_length = dates[active_tab_id].length;
    if (dates_length > col_limit_per_page) {
        var tabs_count = parseInt(dates_length / col_limit_per_page);
        var remaining = parseInt(dates_length % col_limit_per_page);
        if (remaining > 0) {
            tabs_count++;
        }
    }
    /*Push dates into another array => Each index has max 7 value into it (Based on viewport width)*/
    for (var i = 0; i <= tabs_count; i++) {
        var start = i * col_limit_per_page;
        var end = start + col_limit_per_page;
        sub_dates[active_tab_id].push(dates[active_tab_id].slice(start, end));
    }
    var index = 1;
    var tab_html = '';
    var exist = null;
    $.each(sub_dates[active_tab_id], function(key, value) {
        var current_date = '{{ date("d-m-Y", strtotime($admission_date)) }}';
        if (value.length > 0) {
            for (var i = 0; i < value.length; i++) {
                if (value[i].substring(0, 10) == current_date) {
                    if (exist == null) {
                        exist = key;
                    }
                }
            }
            /*Check admission date exist in sub array*/
            if (exist != null && already_active == false) {
                makeactivetab(key);
                already_active = true;
                tab_html = '<li class="active" role="presentation"><a class="tab_change_link" href="javascript:void(0)" data-tab-filter-key="' + key + '" role="tab">Sheet ' + index + '</a></li>';
            } else {
                makeinactivetab(key);
                var tab_status = 'active';
                if (key != 0) {
                    tab_status = '';
                }
                tab_html = '<li class="'+tab_status+'" role="presentation"><a class="tab_change_link" href="javascript:void(0)" data-tab-filter-key="' + key + '" role="tab">Sheet ' + index + '</a></li>';
            }
            $('#' + active_tab_id + ' .column_list_tab').append(tab_html);
            index++;
        }
    });
}
/*Get the array value as class and make it as show => Active class*/
function makeactivetab(key) {
    var active_array = sub_dates[active_tab_id][key];
    if (active_array !== undefined) {
        $.each(active_array, function(sub_key, sub_value) {
            $('.' + sub_value).show();
        });
    } else {
        $.each(dates[active_tab_id], function(date_key, date_value) {
            $('.' + date_value).show();
        });
    }
}
/*Get the array value as class and make it as hide => In Active class*/
function makeinactivetab(key) {
    var in_active_array = sub_dates[active_tab_id][key];
    $.each(in_active_array, function(in_active_sub_key, in_active_sub_value) {
        $('.' + in_active_sub_value).hide();
    });
}
$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
    if (window.location.href.indexOf("/lab-value-print") !== -1) {
        var order;
        $('#sort_order').change(function() {
            if ($(this).prop("checked") == true) {
                order = 'desc';
            } else {
                order = 'asc';
            }
            var url_string = window.location.href;
            var url = new URL(url_string);
            var closewinlink = url.searchParams.get("closewinlink");
            var mrn = url.searchParams.get("mrn");
            var admission_id = url.searchParams.get("admission_id");
            var base_url = $("input[name='site_base_url']").val();
            window.location = base_url + '/lab-value-print?mrn=' + mrn + '&closewinlink=' + closewinlink + '&order=' + order + '&admission_id=' + admission_id;
        });
    }
    tabChange('hb');
    tabChange('abg');
});

function tabChange(tab_name) {
    active_tab_id = tab_name;
    columnLimitPerPage();
    columnView();
    if (already_active == false) {
        makeactivetab(0);
    }
}
$(document).on('click', '.tab_change_link, .tab_change_link_resize', function() {
    var array_key = $(this).data('tab-filter-key');
    active_tab_id = $(this).parents('.tab-pane').attr('id');
    $('#' + active_tab_id + ' .column_list_tab li').removeClass('active');
    $(this).parent().addClass('active');
    $.each(sub_dates[active_tab_id], function(key, values) {
        if (key == array_key) {
            makeactivetab(key);
        } else {
            makeinactivetab(key);
        }
    });
});
var previous_window_width = 0;
$(window).on("resize", function(event) {
    var window_width = $(this).width();
    if (previous_window_width == window_width) {
        return false;
    }
    previous_window_width = window_width;
    $('#' + active_tab_id + ' .column_list_tab').html('');
    columnLimitPerPage();
    columnView();
    if (already_active == false) {
        makeactivetab(0);
    }
});

$(document).on('click', '#btn-refresh-lab-report', function() {
    var base_url = $("input[name='site_base_url']").val();
    var baby_id = $(this).attr('data-baby-id');
    var closewinlink = $(this).attr('data-closewinlink');
    $('.btn').addClass('disabled-property');
    $(this).find('i').addClass('fa-pulse');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        data: {
            baby_id: baby_id,
            closewinlink: closewinlink
        },
        url: base_url + '/lab-report-import',
        success: function(response) {
            Showalert(response.type, response.message);
            if (response.type == 'success') {
                location.reload();
            }
        }
    });
});

if (window.location.href.indexOf("overall-lab-value-print") !== -1) {
    $(document).on('click', '#btn-export', function() {
        var base_url = $("input[name='site_base_url']").val();
        var mrn = $(this).attr('data-mrn');
        window.location  = base_url + '/export-lab-report-live?mrn='+mrn;
    }); 
} else if (window.location.href.indexOf("/lab-value-print") !== -1) {
    $(document).on('click', '#btn-export', function() {
        var base_url = $("input[name='site_base_url']").val();
        var mrn = $(this).attr('data-mrn');
        var baby_name = $(this).attr('data-baby-name');
        window.location = base_url + "/export-lab-report?mrn=" + mrn + "&baby_name=" + baby_name;
    });
}
