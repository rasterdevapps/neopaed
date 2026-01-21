@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li><i class="icon-home"></i>
			<a href="{{ url('/') }}">Dashboard</a>
		</li>
		<li>
			<a href="{{ action('Masters\ReferralController@index') }}">Referral Doctor</a>
		</li>       
		<li class="current">
			<a>Edit</a>
		</li>                                              
	</ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing select-container-main">
	<div class="master-btn-layout">
		{!! Form::model($results,['method'=> 'PATCH','url' => action('Masters\ReferralController@update',$results->id),'id'=>'EditForm']) !!}
		<div class="row select-option-container">
			<div class="col-md-12">
				<div class="form-group row">
					<div class="col-md-3 text-right label-control">
						{!! Form::label('doctor_name','Doctor Name:') !!}
					</div>
					<div class="col-md-9 custom-input">
						{!! Form::text('doctor_name',null,['class'=>'form-control input-fields-shadow']) !!}
					</div>
				</div>
				<div class="form-group row">
					<div class="col-md-3 text-right label-control">
						{!! Form::label('hospital_name','Hospital:') !!}
					</div>
					<div class="col-md-9 custom-input">
						{!! Form::text('hospital_name',null,['class'=>'form-control input-fields-shadow']) !!}
					</div>
				</div>  
				<div class="form-group row">
					<div class="col-md-3 text-right label-control">
						{!! Form::label('hospital_number','Mobile No:') !!}
					</div>
					<div class="col-md-9 custom-input">
						{!! Form::text('hospital_number',null,['class'=>'form-control input-fields-shadow']) !!}
					</div>
				</div>  
				<div class="form-group row">
					<div class="col-md-3 text-right label-control">
						{!! Form::label('hospital_email','Mail Id:') !!}
					</div>
					<div class="col-md-9 custom-input">
						{!! Form::text('hospital_email',null,['class'=>'form-control input-fields-shadow']) !!}
					</div>
				</div>                               
				<div class="form-group row">
					<div class="col-md-3 text-right label-control">
						{!! Form::label('status','Status:') !!}
					</div>
					<div class="col-md-9 custom-input">
						{!! Form::select('status',['1'=>'Active','0'=>'Inactive'],null,['class'=>'form-control input-fields-shadow']) !!}
					</div>
				</div>                     		
			</div>
			<div class="col-md-12 select-container-main">
				<button type="submit" class="btn btn-primary btn-basic-shadow form-control input-width-medium">
					<i class="fa fa-floppy-o"></i><span>Update</span>
				</button>
				<a href="{{ action('Masters\ReferralController@index') }}" class="btn btn-default btn-basic-shadow form-control input-width-medium" onclick="$('form')[0].reset();">
					<i class="fa fa-exclamation-circle"></i> <span>Cancel</span>
				</a>
			</div>
		</div>

		{!! Form::close() !!}
		@include('errors.list')
	</div> <!-- /.col-md-12 -->
	<div class="sidebar-right panel panel-default hidden">
		<div class="">
			<h3>Search</h3>
			<div class="form-group">
				{!! Form::text('SearchField',null,['class'=>'form-control','id'=>'SearchField']) !!}
			</div>
			<div class="form-group">
				<a href="javascript:void(0);" class="btn btn-primary form-control search-list">Search</a>
			</div>
			<ul class="search-results list-group">
			</ul>
		</div>
	</div>                    
</div> <!-- /.row -->

@endsection
@section('scripts')
<script type="text/javascript">
	$(document).ready(function() {
		$('#EditForm').validate({
			rules: {
				Name: {
					required: true
				}
			}
		});
	});
</script>
@endsection

