@extends('app')
@section('content')
<!-- Breadcrumbs line -->
	<div class="crumbs bread-crumbs-shadow">
		<ul id="breadcrumbs" class="breadcrumb">
			<li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
			<li><a href="{{ action('Registration\MotherController@index') }}">Mother Registration</a></li>       
			<li class="current"><a>Create</a></li>                                                 
		</ul>
    </div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
    <div class="row row-spacing">
		<div class="col-md-12">
                {!! Form::open(['url' => action('Registration\MotherController@store'), 'id' => 'mother-reg-form', 'class'=>'mother_registration_form']) !!}
                {!! Form::hidden('MotherId',null,['class'=>'form-horizontal row-border','id'=>'MotherId']) !!}
                @include('registration.mothers_form',['SubmitButtonText'=>'Save & Close','SavedhereText'=>'Save','createBaby'=>'Register Baby'])
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
// 		$('#mother-reg-form').submit();

// 	}
// });
$('#search').click(function(e){

	var mr_no = $('#MMrNo').val();
    $('#mr_no_error').html('').fadeIn(500);
	$(this).prop('disabled', 'disabled');
	$(this).html('<i class="fas fa-spinner fa-pulse"></i> Please Wait...');
	e.preventDefault();
	
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

@if(\Auth::check())
	   $.ajax({
			  type    :"POST",
			  url     :"{{ url('patient-details') }}",
			  data    :{mr_no:mr_no},
			  complete: sent_mirth(),
			  success :function(response){
	 		  },
		});
$(this).removeAttr('disabled');
$(this).html('<i class="fa fa-search"></i> Search');
function sent_mirth(){
	$.ajax({
			  type    :"POST",
			  url     :"{{ url('get-patient') }}",
			  data    :{mr_no:mr_no},
			  success :function(response){

			  	var overall =JSON.parse(response);
			  	if(overall.status==true){
                  var Details = overall.result;
                  $('#MotherName').val(Details.Name[0]);
                  $('#MotherLastName').val(Details.Name[1]);
                  $("#MotherDOB").datepicker("setDate", Details.Dob);
                  if(Details.Dob!=''){
                    caluclateAge('MotherDOB','MothercYear');
                  }
                  $('#Mobile').val(Details.PhoneNumber[1]);
                  $('#LandLine').val(Details.PhoneNumber[0])
                  $('#Address1').val(Details.Address[0]);
                  $('#Address2').val(Details.Address[1] + Details.Address[2]);
                  $('#Address3').val(Details.Address[4]);
                  $('#Address4').val(Details.Address[5]);
                  $('#Address5').val(Details.Address[7]);

                }else{
                	$('#mr_no_error').html(overall.message).fadeIn(500);
                }
  
	 		  }
			  
		});
}	
@endif	

});


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
            type: 'POST',
            data: $('.mother_registration_form input.not_saved, .mother_registration_form select.not_saved, input[name="MotherId"]').serialize(),
            url: "{{ action('Registration\MotherController@store') }}",
            success: function (response) {
                if (print_flag == 2) {
                    Showalert('success', 'Mother Registered Successfully');
                    window.location.href = response.edit_url;
                }
                else if(print_flag == 3)
                {
                    Showalert('success', 'Mother Registered Successfully');
                    window.location.href = response.create_baby_url;
                }
                else
                {
                    Showalert('success', 'Mother Registered Successfully');
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