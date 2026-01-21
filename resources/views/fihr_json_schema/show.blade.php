@extends('app')
@section('content')
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="{{ url('/') }}">Dashboard</a>
		</li>
		<li>
			<a href="{{ action('Fhir\FhirJsonSchemaController@index') }}">Fihr Json Schema</a>
		</li>
		<li>
			<a href="{{ action('Fhir\FhirJsonSchemaController@create') }}">Show</a>
		</li>                                         
	</ul>
</div>
<div class="row-spacing">
    <div class="col-md-12 tab-view-shadow ptb-20">    	
    	<div class="col-md-12 plr-0">
    		<div class="col-md-6 form-group">
	    		{{ Form::label('resourcetype','Resource Type:') }}
	    		{{ Form::text('resourcetype',$fhirjsonschema->resource_type,['class'=>'form-control','readonly'=>'true']) }}</td>
	    	</div>
	    	<div class="col-md-6 form-group">
	    		{{ Form::label('version','Version:') }}
	    		{{ Form::text('version',$fhirjsonschema->version,['class'=>'form-control','readonly'=>'true']) }}</td>
	    	</div>
	    </div>
    	<div class="col-md-12 form-group">
    		{{ Form::label('resourceschema','Resource Schema') }}
    		{{ Form::textarea('resourceschema',$fhirjsonschema->resource_schema,['class'=>'form-control','rows'=>15,'readonly'=>'true']) }}</td>
    	</div>   
    	<div class="col-md-12 text-center">
    		<a href="{{ action('Fhir\FhirJsonSchemaController@index') }}" class="btn btn-default save-button-shadow">
	           	<i class="fa fa-exclamation-circle" aria-hidden="true"></i>
	            <span>Cancel</span>
	        </a>
    	</div>
    </div>
</div>
@endsection 
