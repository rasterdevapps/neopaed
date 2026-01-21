$(document).ready(function() {
    $("#initial-image").change(function(){
        readURL(this,'initial');
        $('.initial-image-show-div').removeClass('hide');
    });
    $("#signature-image").change(function(){
        readURL(this,'signature');
        $('.signature-image-show-div').removeClass('hide');
    });
    function readURL(input, type) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                if (type == 'initial') {
                    $('#initial-image-show').attr('src', e.target.result);
                }
                else
                {
                    $('#signature-image-show').attr('src', e.target.result);
                }
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
});