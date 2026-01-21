@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
		<li><a href="{{ action('Registration\BabyController@index') }}">Baby Registration</a></li>       
		<li class="current"><a>Edit</a></li>                                                 
	</ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
	<div class="col-md-12">
	    @include('errors.list')
	        {!! Form::model($results,['method'=> 'PATCH','url' => action('Registration\NurseBabyController@update',$results->BabyId), 'id' => 'baby_reg_form']) !!}
	        {!! Form::hidden('MotherId',null) !!}
		@include('nurse_registration.baby_form',['SubmitButtonText'=>'Update & Close','SavedhereText'=>'Update'])
        {!! Form::close() !!}
    </div> <!-- /.col-md-12 -->    
</div> <!-- /.row -->
<!-- /Page Content -->
              
@endsection
@section('scripts')
<script type="text/javascript">
/* PLUGIN USED FOR FORM LOCAL STORAGE */
$( "form" ).sisyphus({  customKeySuffix: "baby", locationBased: true });

$(document).on('change', '#baby_reg_form input, #baby_reg_form select', function()
{
    $(this).addClass('not_saved');
});
$(document).on('click', '.baby_save_btn', function(e){
    e.preventDefault();
    if ($('#baby_reg_form').valid() === true) {
        var print_flag = $(this).data('flag');
        $('#form-flag').val(print_flag);
        $('.baby_save_btn').prop('disabled', true);

        $(this).html('<i class="fas fa-spinner fa-pulse"></i> Loading...');
        var current_element = $(this);
        // $('#mother_registration_form').submit();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            data: $('#baby_reg_form input.not_saved, #baby_reg_form select.not_saved, #BabyName').serialize(),
            url: "{{ action('Registration\BabyController@store') }}",
            success: function (response) {
                if (print_flag == 2) {
                    Showalert('success', 'Baby Registered Successfully');
        			$('.baby_save_btn').prop('disabled', false);
        			current_element.html('<i class="fa fa-floppy-o"></i> <span>Update</span>');
                    // window.location.href = response.edit_url;
                }
                else if(print_flag == 3)
                {
                    Showalert('success', 'Baby Registered Successfully');
                    window.location.href = response.create_baby_url;
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
            error: function()
            {
                Showalert('error', 'Something went wrong, Please try again later...!');
            }
        });
    }
});

</script>
@endsection