@extends('app')
@section('content')
@php 
	$value_type = explode(':', $value_type);
@endphp
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="{{ url('/') }}">Dashboard</a>
		</li>
		<li>
			@if($value_type[0] == 'monitor') 
			<a href="{{ action('Fhir\FhirFormattedValuesController@monitordata') }}">Monitor 
			@elseif($value_type[0] == 'ventilator')
			<a href="{{ action('Fhir\FhirFormattedValuesController@ventilatordata') }}">Ventilator 
			@else
			<a href="{{ action('Fhir\FhirFormattedValuesController@pumpdata') }}">Pump 
			@endif
			Values</a>
		</li>
		<li class="current">
			<a href="{{ action('Fhir\FhirFormattedValuesController@show',$fhirdata->id) }}">Show</a>
		</li>                                         
	</ul>
</div>
@if($value_type[0] != 'pump')
<div class="row row-spacing plr-15">
	<div class="col-md-12 tab-view-shadow p-0 pt-20">
		<div class="col-md-6 col-sm-6 width-sm-50">
			<div class="form-group">
				{{ Form::label('mrno', Lang::get('home.mrn').':') }}
				{{ Form::text('mrno',$fhirdata->mrn,['class'=>'form-control','readonly'=>'true']) }}
			</div>
			<div class="form-group">
				{{ Form::label('patientname','Patient Name') }}
				{{ Form::text('patientname',$fhirdata->name,['class'=>'form-control','readonly'=>'true']) }}</td>
			</div>
			<div class="form-group">
				{{ Form::label('parameter','Parameter Name') }}
				{{ Form::text('parameter',$fhirdata->local_description,['class'=>'form-control','readonly'=>'true']) }}</td>
			</div>
			<div class="form-group">
				{{ Form::label('receivedtime','Received Time') }}
				{{ Form::text('receivedtime',date('d-m-Y h:m a',strtotime($fhirdata->issued)),['class'=>'form-control','readonly'=>'true']) }}</td>
			</div>
			<div class="form-group">
				{{ Form::label('first_quartile','Open') }}
				{{ Form::text('first_quartile',$fhirdata->first_quartile,['class'=>'form-control','readonly'=>'true']) }}</td>
			</div>
			<div class="form-group">
				{{ Form::label('close','Close') }}
				{{ Form::text('close',$fhirdata->close,['class'=>'form-control','readonly'=>'true']) }}</td>
			</div>
		</div>	
		<div class="col-md-6 col-sm-6 width-sm-50">
			<div class="form-group">
				{{ Form::label('ip', Lang::get('home.ip')) }}
				{{ Form::text('ip',$fhirdata->ip_number,['class'=>'form-control','readonly'=>'true']) }}</td>
			</div>
			<div class="form-group">
				{{ Form::label('dob','DOB') }}
				{{ Form::text('dob',date('d-m-Y', strtotime($fhirdata->birthdate)),['class'=>'form-control','readonly'=>'true']) }}</td>
			</div>
			<div class="form-group">
				{{ Form::label('model','Device Name') }}
				{{ Form::text('model',$fhirdata->model,['class'=>'form-control','readonly'=>'true']) }}</td>
			</div>
			<div class="form-group">
				{{ Form::label('low','Low') }}
				{{ Form::text('low',$fhirdata->low,['class'=>'form-control','readonly'=>'true']) }}</td>
			</div>
			<div class="form-group">
				{{ Form::label('mean','Mid') }}
				{{ Form::text('mean',$fhirdata->mean,['class'=>'form-control','readonly'=>'true']) }}</td>
			</div>
			<div class="form-group">
				{{ Form::label('last_quartile','High') }}
				{{ Form::text('last_quartile',$fhirdata->last_quartile,['class'=>'form-control','readonly'=>'true']) }}</td>
			</div>
		</div>
		@if($value_type[0] == 'monitor')
		<div class="col-md-12 text-center">
			<a href="{{ action('Fhir\FhirFormattedValuesController@monitordata') }}" class="btn btn-default save-button-shadow mb-20">
				<i class="fa fa-times" aria-hidden="true"></i>
				<span>Close</span>
			</a>
		</div>
		@else
		<div class="col-md-12 text-center">
			<a href="{{ action('Fhir\FhirFormattedValuesController@ventilatordata') }}" class="btn btn-default save-button-shadow mb-20">
				<i class="fa fa-times" aria-hidden="true"></i>
				<span>Close</span>
			</a>
		</div>
		@endif
	</div>
</div>
@else

<div class="row row-spacing plr-15">
	<div class="col-md-12 tab-view-shadow p-0 pt-20">
		<div class="col-md-6 col-sm-6 width-sm-50">
			<div class=" form-group">
				{{ Form::label('mrno', Lang::get('home.mrn').':') }}
				{{ Form::text('mrno',$fhirdata->BMrNo,['class'=>'form-control','readonly'=>'true']) }}
			</div>
			<div class="form-group">
				{{ Form::label('patientname','Patient Name') }}
				{{ Form::text('patientname',$fhirdata->BabyName,['class'=>'form-control','readonly'=>'true']) }}</td>
			</div>
			<div class="form-group">
				{{ Form::label('drug','Brand / Pharmacological Name') }}
				{{ Form::text('drug',$fhirdata->brand_name . ' / ' . $fhirdata->generic_pharmacological_name,['class'=>'form-control','readonly'=>'true']) }}</td>
			</div>
			<div class="form-group">
				{{ Form::label('infused','Infused') }}
				{{ Form::text('infused',$fhirdata->infused,['class'=>'form-control','readonly'=>'true']) }}</td>
			</div>
			<div class="form-group">
				{{ Form::label('remain_volume','Remaining Volume') }}
				{{ Form::text('remain_volume',$fhirdata->remain_volume,['class'=>'form-control','readonly'=>'true']) }}</td>
			</div>
			<div class="form-group">
				{{ Form::label('pressure','Running Pressure') }}
				{{ Form::text('pressure',$fhirdata->pressure,['class'=>'form-control','readonly'=>'true']) }}</td>
			</div>
		</div>	
		<div class="col-md-6 col-sm-6 width-sm-50">
			<div class="form-group">
				{{ Form::label('ip', Lang::get('home.ip')) }}
				{{ Form::text('ip',$fhirdata->ip_number,['class'=>'form-control','readonly'=>'true']) }}</td>
			</div>
			<div class="form-group">
				{{ Form::label('dob','DOB') }}
				{{ Form::text('dob',date('d-m-Y', strtotime($fhirdata->DOB)),['class'=>'form-control','readonly'=>'true']) }}</td>
			</div>
			<div class="form-group">
				{{ Form::label('receivedtime','Received Time') }}
				{{ Form::text('receivedtime',date('d-m-Y h:m a',strtotime($fhirdata->result_time)),['class'=>'form-control','readonly'=>'true']) }}</td>
			</div>
			<div class="form-group">
				{{ Form::label('pump_rate','Rate') }}
				{{ Form::text('pump_rate',$fhirdata->pump_rate,['class'=>'form-control','readonly'=>'true']) }}</td>
			</div>
			<div class="form-group">
				{{ Form::label('remain_time','Remain Time') }}
				{{ Form::text('remain_time',$fhirdata->remain_time,['class'=>'form-control','readonly'=>'true']) }}</td>
			</div>
			<div class="form-group">
				{{ Form::label('pressure_level','Pressure Level') }}
				{{ Form::text('pressure_level',$fhirdata->pressure_level,['class'=>'form-control','readonly'=>'true']) }}</td>
			</div>
			<div class="form-group">
				@if ($fhirdata->status == 0)
				@php $status = 'Executing' @endphp
				@elseif ($fhirdata->status == 1)
				@php $status = 'Pause' @endphp
				@elseif ($fhirdata->status == 2)
				@php $status = 'Completed' @endphp
				@elseif ($fhirdata->status == 3)
				@php $status = 'Cancel' @endphp
				@elseif ($fhirdata->status == 4)
				@php $status = 'Queue' @endphp
				@endif
				{{ Form::label('status','Status') }}
				{{ Form::text('status',$status,['class'=>'form-control','readonly'=>'true']) }}</td>
			</div>
		</div>
		<div class="col-md-12 text-center">
			<a href="{{ action('Fhir\FhirFormattedValuesController@pumpdata') }}" class="btn btn-default save-button-shadow mb-20">
				<i class="fa fa-times" aria-hidden="true"></i>
				<span>Close</span>
			</a>
		</div>
	</div>
</div>
@endif
@endsection                   
