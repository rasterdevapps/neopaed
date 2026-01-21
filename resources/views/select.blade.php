@php
$site_url = url('/').'/public';
$required = (isset($error_message) && !empty($error_message)) ? ['class'=>'required-label'] : [];
@endphp
<div class="form-group row">
    <div class="col-md-3 text-right label-control">
        {!! Form::label('select', $label_name, $required) !!}
    </div>
    <div class="col-md-9 custom-input">
        <input id="ssearch" class="full-width" placeholder="{{$placeholder}}" />
        @if (isset($error_message))
        <div class="text-center">
            <span class="error-message error-admission">{{$error_message}}</span>
        </div>
        @endif
    </div>
</div>
<script type="text/javascript" src="{{ $site_url }}/js/select2_pagination.js"></script>
<script type="text/javascript">
    $(document).on("click", ".submitbtn", function(e) {
        e.preventDefault();
        var selectval = $("#ssearch").val();
        var action_url = $('input[name="action_url"]').val();
        var type = $('input[name="type"]').val();
        if (action_url != 'undefined') {
            if (selectval == 0) {
                if ($('.error-message').html() != '') {
                    $('.error-message').fadeIn(1000).fadeOut(1000);
                } else {
                    bootbox.confirm("Are you sure want to create new baby registration ?", function(confirmed) {
                        if (confirmed) {
                            window.location = action_url;
                        }
                    });
                }
            } else {
                if (typeof type !== 'undefined') {
                    window.location = action_url + '/' + selectval + '-$-' + type;
                } else {
                    window.location = action_url + '/' + selectval;
                }
            }
        }
    });
</script>
