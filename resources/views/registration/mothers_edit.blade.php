@extends('app')
@section('content')
<!-- Breadcrumbs line -->
	<div class="crumbs bread-crumbs-shadow">
		<ul id="breadcrumbs" class="breadcrumb">
			<li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
			<li><a href="{{ action('Registration\MotherController@index') }}">Mother Registration</a></li>       
			<li class="current"><a>Edit</a></li>                                                 
		</ul>
        <div class="pull-right">
            @php 
                $mmrn = $results->MotherId; 

                echo \SiteHelpers::menuList($mmrn, 'mother_registration');
            @endphp
      </div>
    </div>
<!-- Breadcrumbs line -->
<!-- Page Content -->
	<div class="row row-spacing">
		<div class="col-md-12">
		    @include('errors.list')
		    {!! Form::model($results,['method'=> 'PATCH','url' => action('Registration\MotherController@update',$results->MotherId),'id'=>'EditForm', 'class'=>'mother_registration_form']) !!}
            {!! Form::hidden('MotherId',null,['class'=>'form-control','id'=>'MotherId']) !!}
            @include('registration.mothers_form',['SubmitButtonText'=>'Update & Close','SavedhereText'=>'Update','createBaby'=>'Register Baby'])
            {!! Form::close() !!}
        </div> <!-- End col-md-12 -->
	</div> <!-- End row -->
<!-- End Page Content -->
@endsection
@section('scripts')
<script type="text/javascript">
/* PLUGIN USED FOR FORM LOCAL STORAGE */
$( "form" ).sisyphus({  customKeySuffix: "mother", locationBased: true });
// $(document).on('click', '.save_close_btn, .save_btn, .create_btn', function(){
// 	if($('form').valid() === true)
// 	{
//     	$('.save_close_btn, .save_btn, .create_btn').css({'cursor' : 'not-allowed', 'pointer-events' : 'none', 'opacity' : 0.8});
// 		$(this).children('i').attr('class', 'fas fa-spinner fa-pulse');
// 		// $('#EditForm').submit();


// 	}
// });

$(document).on('click', '.save_close_btn, .save_btn, .create_btn', function(e){
    e.preventDefault();
    if ($('.mother_registration_form').valid() === true) {
        var print_flag = $(this).data('flag');
        $('#form-flag').val(print_flag);
        $('.save_close_btn, .save_btn, .create_btn').prop('disabled', true);

        $(this).html('<i class="fas fa-spinner fa-pulse"></i> Loading...');
        // $('#mother_registration_form').submit();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'PATCH',
            data: $('.mother_registration_form input.not_saved, .mother_registration_form select.not_saved, input[name="MotherId"], input[name="flow"], input[name="mother_based_baby_id"]').serialize(),
            url: "{{ action('Registration\MotherController@update',$results->MotherId ) }}",
            success: function (response) {
                if (print_flag == 2) {
                    Showalert('success', 'Mother details updated successfully');
        			$('.save_close_btn, .save_btn, .create_btn').prop('disabled', false);
        			$('.save_btn').html('<i class="fa fa-floppy-o"></i> <span>Update</span>');
                    // window.location.href = response.edit_url;
                }
                else if(print_flag == 3)
                {
                    Showalert('success', 'Mother details updated successfully');
                    window.location.href = response.create_baby_url;
                }
                else
                {
                    Showalert('success', 'Mother details updated successfully');
                    window.location.href = response.list_url; 
                }
            },
            error: function()
            {
                // $('input[name="'+fieldname+'"]').addClass('not_saved');
            }
        }); 
    }
});
</script>
@endsection
