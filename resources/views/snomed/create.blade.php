@extends('app')
@section('content')
<?php $write_permission = session('write_permission'); ?>
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="{{ url('/') }}">Dashboard</a>
		</li>
		<li>
			<a href="{{ action('Snomed\SnomedCodeController@index') }}">Snomed Map Local</a>
		</li>  
		<li class="current">
			<a href="{{ action('Snomed\SnomedCodeController@create') }}">Create</a>			
		</li>                                   
	</ul>
</div>
<div class="row-spacing">
    <div class="col-md-12 tab-view-shadow plr-0 pb-15">
		<div class="form-group">
		    @include('errors.list')
		</div>
    	{{ Form::open(['method'=>'POST','url' => action('Snomed\SnomedCodeController@store')]) }}
	    	<div class="col-md-12 form-group">
		    	{{ Form::label('table_name','Table Name') }}
		    	{{ Form::text('table_name',null,['class'=>'form-control']) }}
		    </div>
		    <div class="col-md-12 plr-0">
		    	<div class="col-md-6 form-group">
		    		{{ Form::label('schema','Schema') }}
		    		{{ Form::text('schema',null,['class'=>'form-control']) }}
		    	</div>
		    	<div class="col-md-6 form-group">
		    		{{ Form::label('column_name','Column Name') }}
		    		{{ Form::text('column_name',null,['class'=>'form-control']) }}
		    	</div>
		    	<div class="col-md-6 form-group">
		    		{{ Form::label('snomed_code','Snomed Code') }}
		    		{{ Form::text('snomed_code',null,['class'=>'form-control']) }}
		    	</div>
		    	<div class="col-md-6 form-group">
		    		{{ Form::label('loinc_code','Lonic Code') }}
		    		{{ Form::text('loinc_code',null,['class'=>'form-control']) }}
		    	</div>
		    </div>
		    <div class="col-md-12">
	            <div class="col-md-offset-3 col-md-3">
	                <button type="submit" class="btn btn-block btn-info save-button-shadow form-control">
	                    <i class="fa fa-floppy-o"></i>
	                    <span>Save</span>
	                </button>
	            </div>
	            <div class="col-md-3">
	                <a href="{{ action('Snomed\SnomedCodeController@index') }}" class="btn btn-default save-button-shadow btn-block form-control">
	                    <i class="fa fa-exclamation-circle"></i> 
	                    <span>Cancel</span>
	                </a>
	            </div>
	        </div>
	    {{ Form::close() }}
	</div>
</div>
@endsection
