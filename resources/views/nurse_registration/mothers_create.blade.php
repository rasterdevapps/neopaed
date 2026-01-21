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
		{!! Form::open(['url' => action('Registration\NurseMotherController@store'), 'class'=>'mother_registration_form']) !!}
		{!! Form::hidden('MotherId',null,['class'=>'form-horizontal row-border','id'=>'MotherId']) !!}
		<!-- <div class="form-group row" style="display: none;">
			<div class="col-md-3 text-right label-control">
				{!! Form::label('test','test') !!}
			</div>
			<div class="col-md-9 custom-input">
				{!! Form::text('test',null,['class'=>'form-control input-fields-shadow','maxlength'=>6, 'required']) !!}
			</div>
		</div> -->
			@include('nurse_registration.mothers_form',['SubmitButtonText'=>'Save & Close','SavedhereText'=>'Save','createBaby'=>'Register Baby'])

		</div>
		{!! Form::close() !!}
	</div> <!-- End col-md-12 -->
</div> <!-- End row -->
<!-- End Page Content -->

@endsection
@section('scripts')
<script type="text/javascript">

	/* PLUGIN USED FOR FORM LOCAL STORAGE */
	$( "form" ).sisyphus({  customKeySuffix: "mother", locationBased: true });

	$('#search').click(function(e){

		var mr_no = $('#MMrNo').val();
		e.preventDefault();
		$('#mr_no_error').html('').fadeIn(500);

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


$(document).on('click', '.save-btn', function(e){
    e.preventDefault();
    if ($('.mother_registration_form').valid() === true) {
        $('.save-btn').prop('disabled', true);

        $(this).html('<i class="fas fa-spinner fa-pulse"></i> Loading...');
        $('.mother_registration_form').submit();
    }
});

</script>
@endsection
