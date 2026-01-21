@extends('print')
@section('content')

<div class="temp-container mt-40">
	<div class="temp-row nurse-chart-sheet">
		<div class="col-md-12">
			<div class="col-md-3">
	              <img src="{{ ValuelistHelpers::printPagelogo() }}">
	         </div>
	         <div class="col-md-9">
				<div class="col-md-3">
					<div>
					  <b>Baby Name : {{ $baby_details->BabyName }} </b>
					</div>
					<div>
					  <b>DOB : {{ date('d-m-Y', strtotime($baby_details->DOB)) }} </b>
					</div>
				</div>
				<div class="col-md-3">
					<div>
					  <b>B{{ Lang::get('home.mrn') }} : {{ $baby_details->BMrNo }} </b>
					</div>
					<div>
						<b>Birth Weight : {{ $baby_details->BirthWeight }} </b>
					</div>
				</div>
				<div class="col-md-3">
				     <div>
						<b>Gestation : {{ SiteHelpers::decode_gestation($baby_details->Gestation) }} </b>
					</div>
					 
				</div>
			</div>
		</div>

		<div class="col-md-12 chart-fonts-style text-center">
			<h3> <u>{{ title_case("Nurse Observation Chart") }}</u> </h3>
		</div>
		

		@foreach($venitlator_details as $v_details)
		<div class="col-md-12">
			@foreach($v_details as $value)
			<button class="col-md-3 chart-snop btn btn-primary btn-nurse-observation chart-vendilator" data-snomed="{{ $value->parameter_snomed }}" data-parameter-id="{{ $value->parameter }}" data-baby-id="{{ $baby_details->BMrNo }}" data-ipnumber="0">
			  	{!! $value->parameter_title !!}
			</button>
			@endforeach
		</div>
		@endforeach
			
			
		
	</div>
</div>	

@endsection
@section('scripts')
<script type="text/javascript">
 $(document).ready(function() {

   $('.chart-vendilator').click(function() {
	   	var snomed          = $(this).data('snomed');
	   	var observationName = $(this).data('parameter-id');
	   	var mrn          = $(this).data('baby-id');
	   	var ipNumber        = $(this).data('ipnumber');

	   	$.ajax({
		    type:'GET',
		    url:'{{ url("get-chart-observation") }}/'+mrn+'/'+snomed+'/'+ipNumber+'/'+observationName,
		    beforeSend:function() {
	            $('#ventilator-settings').html('<div class="loader"><i class="fa fa-spinner fa-pulse fa-5x fa-fw" aria-hidden="true"></i></div>');
		    },
		    success:function(data) {

		    },
		    error:function(data) {
		              Showalert('error','Your messsage failed to sent !');
		    }
		});
	});

  });	
</script>


@endsection
