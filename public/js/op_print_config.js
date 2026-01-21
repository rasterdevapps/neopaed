$(document).on('click', '#btn-op-page-custom .dropdown-menu, body', function (e) {
    e.stopPropagation();
});
$(document).on('click', '#btn-op-page-custom button[type="button"]', function (e) {
    $('.dropdown').removeClass('open');
});
$(document).on('click', 'input[name="config"]', function() {
    var selected = $(this).val();
    if (selected == 'user') {
        $('.user_based').removeClass('hide');
        $('.ip_based').addClass('hide');        
    } else {
        $('.user_based').addClass('hide');
        $('.ip_based').removeClass('hide');        
    }
});
$(document).on('click', '#btn-op-page-custom a', function() {
    var selected = $('input[name="config"]:checked').val();
    selected = (typeof selected != 'undefined') ? selected : 'user';
    $('input[name="config"][value="'+selected+'"]').prop('checked', true);
    $('input[name="config"][value="'+selected+'"]').trigger('click');
});
$(document).on('click', '#page-spacing-config button[type="submit"]', function(e) {
    e.preventDefault();
    var action_url = $("#page-spacing-config").attr('action');
    $.ajax({
        type: "PATCH",
        url: action_url,
        data: $('#page-spacing-config').serialize(),
        success: function(response) {
            $('.dropdown').removeClass('open');
            Showalert(response.status, response.message);
            location.reload();
        },
        error: function(response) {
            Showalert('error', 'Please select "User" or "Ip address"!');
        }
    });
});