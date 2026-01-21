@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
		<li class="current"><a>Baby Registration</a></li>                                                
	</ul>		
</div>
{!! Form::model($baby,['method'=> 'post','url' => action('Registration\NurseBabyController@readmissioncreation'), 'id' => 'baby_reg_form']) !!}

{!! Form::hidden('BabyId') !!}
{!! Form::hidden('MotherId') !!}

<!-- /Breadcrumbs line -->
<div class="row row-spacing">
	<div class="col-md-12">
		<div class="widget box">
			<div class="widget-header">
				<h4><i class="fa fa-reorder"></i> Baby Details</h4>
			</div>
			<div class="widget-content row mx-0">
				<div class="mt-10 widget box col-md-6 px-15">
					<div class="widget-header">
						<h4><i class="fa fa-reorder"></i> </h4>
					</div>
					<div class="widget-content row mx-0">
						<div class="col-md-12">
							<div class="form-group row">
								<div class="col-md-3 text-right label-control">
									{{ Form::label('BMrNo', Lang::get('home.mrn').':', ['class'=>'required-label']) }}
								</div>
								<div class="col-md-9 custom-input">
									{{ Form::text('BMrNo',null,['class'=>'form-control']) }}
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-3 text-right label-control">
									{{ Form::label('DOB','DOB:') }}
								</div>
								<div class="col-md-9 custom-input">
									{{ Form::text('DOB',null,['class'=>'form-control', 'readonly']) }}
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-3 text-right label-control" style="margin-top: 25px;">
									{{ Form::label('tob','TOB:') }}
								</div>
								<div class="col-md-9 custom-input clear-xs">
									<div class="row">
										<div class="col-xs-4 text-center">
											<small>(Hour)</small>
										</div>
										<div class="col-xs-4 text-center">
											<small>(Minute)</small>
										</div>
										<div class="col-xs-4 text-center">
											<small>(Session)</small>
										</div>
										<div class="col-xs-4">
											{{ Form::select('TOB_TIME',ValuelistHelpers::timeEngine()['time'],null,['class'=>'form-control plr-sm-0']) }}
										</div>
										<div class="col-xs-4">
											{{ Form::select('TOB_MINS',ValuelistHelpers::timeEngine()['mins'],null,['class'=>'form-control plr-sm-0']) }}
										</div>
										<div class="col-xs-4">
											{{ Form::select('TOB_AM',ValuelistHelpers::timeEngine()['period'],null,['class'=>'form-control plr-sm-0']) }}
										</div>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-3 text-right label-control">
									{{ Form::label('Sex','Sex:') }}
								</div>
								<div class="col-md-9 custom-input">
									{{ Form::select('Sex',['N/A'=>'N/A','Male'=>'Male','Female'=>'Female','Indeterminate'=>'Indeterminate'],null,['class'=>'form-control']) }}
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-3 text-right label-control">
									{{ Form::label('BirthStatus','Birth Status:') }}
								</div>
								<div class="col-md-9 custom-input">
									{{ Form::select('BirthStatus',['Inborn'=>'Inborn','Outborn'=>'Outborn'],null,['class'=>'form-control']) }}
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-3 text-right label-control" style="margin-top: 25px;">
									{!! Form::label('Gestation','Gestation:') !!}
								</div>
								<div class="col-md-9 custom-input clear-xs">
									<div class="row">
										<div class="col-xs-6">
											<small>(In Weeks)</small>
										</div>
										<div class="col-xs-6">
											<small>(In Days)</small>
										</div>
										<div class="col-xs-6">
											{{ Form::text('g_weeks',null,['class'=>'form-control']) }}
										</div>
										<div class="col-xs-6">
											{{ Form::text('g_days',null,['class'=>'form-control']) }}
										</div>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-3 text-right label-control">
									{{ Form::label('BabyBloodGroup','Baby Blood Group:') }}
								</div>
								<div class="col-md-9 custom-input">
									{{ Form::select('BabyBloodGroup',ValuelistHelpers::Blood_groups(),null,['class'=>'form-control']) }}
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-3 text-right label-control">
									{{ Form::label('MotherBloodGroup','Mother Blood Group:') }}
								</div>
								<div class="col-md-9 custom-input">
									{{ Form::select('MotherBloodGroup',ValuelistHelpers::Blood_groups(),null,['class'=>'form-control']) }}
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-3 text-right label-control">
									{{ Form::label('ip_number', Lang::get('home.ip')) }}
								</div>
								<div class="col-md-9 custom-input">
									{{ Form::text('ip_number',null,['class'=>'form-control']) }}
								</div>
							</div>
						</div>
					</div>
				</div>
                                {!! Form::hidden('visit_type', 'IP', ['id'=>'visit_type']) !!}
				<div class="col-md-6 mt-10 widget box px-15">
					<div class="widget-header">
						<h4><i class="fa fa-reorder"></i> </h4>
					</div>
					<div class="widget-content">
						<div class="form-group row">
							<div class="col-md-3 text-right label-control">
								{{ Form::label('BabyName','Baby Name:') }}
							</div>
							<div class="col-md-9 custom-input">
								{{ Form::text('BabyName',null,['class'=>'form-control']) }}
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-3 text-right label-control">
								{{ Form::label('admission_date','Admission Date:') }}
							</div>
							<div class="col-md-9 custom-input">
								{{ Form::text('admission_date',date('d-m-Y'),['class'=>'form-control baby-dob', 'readonly']) }}
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-3 text-right label-control">
								{{ Form::label('BirthWeight','Birth Weight:') }}
							</div>
							<div class="col-md-9 custom-input">
								{{ Form::text('BirthWeight',null,['class'=>'form-control']) }}
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-3 text-right label-control">
								{{ Form::label('AdmissionWt','Admission Weight:') }}
							</div>
							<div class="col-md-9 custom-input">
								{{ Form::text('AdmissionWt',null,['class'=>'form-control']) }}
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-3 text-right label-control" style="margin-top: 25px;">
								{{ Form::label('correctedgestation','Corrected Gestational Age:') }}
							</div>
							<div class="col-md-9 custom-input clear-xs">
								<div class="row">
									<div class="col-xs-6">
										<small>(In Weeks)</small>
									</div>
									<div class="col-xs-6">
										<small>(In Days)</small>
									</div>
									<div class="col-xs-6">
										{{ Form::text('cg_weeks',null,['class'=>'form-control']) }}
									</div>
									<div class="col-xs-6">
										{{ Form::text('cg_days',null,['class'=>'form-control']) }}
									</div>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-3 text-right label-control">
								{!! Form::label('ward_name', 'Ward Name:', ['class'=>'required-label']) !!}
							</div>
							<div class="col-md-9 custom-input">
								{!! Form::select('ward_name', [''=>'N/A']+$ward_list, null, ['class'=>'form-control ward-name']) !!}
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-3 text-right label-control">
								{!! Form::label('room_no', 'Room No:', ['class'=>'required-label']) !!}
							</div>
							<div class="col-md-9 custom-input">
								{!! Form::select('room_no',[''=>'N/A'] ,null, ['class'=>'form-control room-name']) !!}
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-3 text-right label-control">
								{!! Form::label('bed_no', 'Bed No:', ['class'=>'required-label']) !!}
							</div>
							<div class="col-md-9 custom-input">
								{!! Form::select('bed_no',[''=>'N/A'], null,['class'=>'form-control']) !!}
							</div>
						</div>
					</div>
				</div>
                <div class="col-md-12 col-sm-12 col-xs-12 mtb-20">
                    <div class="col-md-6 col-sm-6 col-xs-12">
						<button type="submit" class="btn btn-primary save-button-shadow btn-block save-btn"><i class="fa fa-floppy-o"></i> Save</button>
					</div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
						<a href="{{ url('/') }}" class="btn btn-default save-button-shadow btn-block"><i class="fa fa-exclamation-circle"></i> Cancel</a>
					</div>
				</div>
			</div>
		</div>
		{!! Form::close() !!}

		@endsection
		@section('scripts')
		<script type="text/javascript">

			$(document).ready(function() {
				$('#AdmissionDate, #DOB').datepicker({
					dateFormat: 'dd-mm-yy',
					changeMonth : true,
					changeYear : true,
				});
			});
			$('.ward-name, .room-name').change(function() {

				var uri  = "{{ url('baby-bed-details') }}";
				var id   = $(this).val();
				var name = $(this).attr('name');
				var slug;
				var destinationName;

				if (name == 'ward_name') {

					slug            = 'ROOMLIST';
					destinationName = 'room_no';

				} else if(name =='room_no') {

					slug = 'BEDLIST';
					destinationName = 'bed_no';

				}


				$.ajax({
					type    :"GET",
					url     :uri+'/'+id+'/'+slug,
					success : function(response) {

						var wardOption = '<option value="">N/A</option>';
						$.each(response.results, function(index, value) {
							wardOption += '<option value="'+value.id+'">'+value.name+'</option>';
						});

						$('select[name="'+destinationName+'"]').html(wardOption);
					},
					complete: function(response) {

					}
				});

			});
$(document).on('click', '.save-btn', function(e){
    e.preventDefault();
    if ($('#baby_reg_form').valid() === true) {

        $(this).prop('disabled', true);

        $(this).html('<i class="fas fa-spinner fa-pulse"></i> Loading...');

        $('#baby_reg_form').submit();
    }
});
		</script>
		@endsection
