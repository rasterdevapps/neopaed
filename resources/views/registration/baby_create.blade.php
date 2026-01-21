@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
		<li><a href="{{ action('Registration\BabyController@index') }}">Baby Registration</a></li>       
		<li class="current"><a>Create</a></li>                                                 
	</ul>
</div>
<!--=== Page Content ===-->
<div class="row row-spacing">
	<div class="col-md-12 plr-25">
        @include('errors.list')
	        {!! Form::open(['url' => action('Registration\BabyController@index'), 'id' => 'baby_reg_form']) !!}
	        {!! Form::hidden('MotherId',$id) !!}
			@include('registration.baby_form',['SubmitButtonText'=>'Save & Close','SavedhereText'=>'Save','neonatalPerforma'=>'NEONATE - Basic entry form (for all babies)','opRegister'=>'Create Op'])
        {!! Form::close() !!}
    </div> <!-- /.col-md-9 -->  
</div> <!-- /.row -->       
<script type="text/javascript">
$(document).on('change', '#baby_reg_form input, #baby_reg_form select', function()
{
    $(this).addClass('not_saved');
});
$(document).on('click', '.baby_save_btn', function(e){
    e.preventDefault();
    if ($('#baby_reg_form').valid() === true) {
        var print_flag = $(this).data('flag');
        // console.log(print_flag)
        $('#baby_form_print_flag').val(print_flag);
        $('.baby_save_btn').prop('disabled', true);

        var current_clicked_element = $(this);
        var current_clicked_element_html = $(this).html();
        $(this).html('<i class="fas fa-spinner fa-pulse"></i> Loading...');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            data: $('#baby_reg_form input, #baby_reg_form select').serialize(),
            url: "{{ action('Registration\BabyController@store') }}",
            success: function (response) {
                if (print_flag == 2) {
                    Showalert('success', 'Baby Registered Successfully');
                    window.location.href = response.edit_url;
                }
                else if(print_flag == 3)
                {
                    Showalert('success', 'Baby Registered Successfully');
                    window.location.href = response.create_proforma_url;
                }
                else if(print_flag == 5)
                {
                    Showalert('success', 'Baby Registered Successfully');
                    window.location.href = response.op_create_url;
                }
                else
                {
                    Showalert('success', 'Baby Registered Successfully');
                    window.location.href = response.list_url; 
                }
            },
            error: function(xhr, data)
            {
                if (xhr.responseJSON.message !== undefined && xhr.responseJSON.message != '') {
                    Showalert('error', xhr.responseJSON.message);
                }
                else
                {
                    Showalert('error', "Something went wrong, Please try after some times...!");

                }
                current_clicked_element.html(current_clicked_element_html);
                $('.baby_save_btn').prop('disabled', false);
            }
        });
    }
});
</script>                      
@endsection

@section('scripts')
<script type="text/javascript">
/* PLUGIN USED FOR FORM LOCAL STORAGE */
$( "form" ).sisyphus({  customKeySuffix: "baby", locationBased: true });



</script>
@endsection