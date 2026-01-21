@extends('app')
@section('content')
	<!-- Breadcrumbs line -->
	<div class="crumbs bread-crumbs-shadow">
		<ul id="breadcrumbs" class="breadcrumb">
			<li>
				<i class="icon-home"></i>
				<a href="{{ url('/') }}">Dashboard</a>
			</li>
			<li>
				<a href="{{ action('Masters\DepartmentController@index') }}">Department</a>
			</li>
			<li class="current">
				<a>Edit</a>
			</li>
		</ul>
	</div>
	<!-- /Breadcrumbs line -->
	<!--=== Page Content ===-->
	<div class="row row-spacing">
		<div class="col-md-9">
			{{ Form::model($results, ['method'=>'PATCH', 'url' => action('Masters\DepartmentController@update',$results->Id),'id'=>'EditForm']) }}
				<div class="row">
					<div class="col-md-5">
						<div class="form-group">
							{{ Form::label('Name', 'Name') }}
							{{ Form::text('Name', $results->Name, ['class'=>'form-control input-fields-shadow']) }}
						</div>
						<div class="form-group">
							{{ Form::label('Status', 'Status') }}
							{{ Form::select('Status',['Active'=>'Active', 'Inactive'=>'Inactive'], $results->Status, ['class'=>'form-control input-fields-shadow']) }}
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">
						<button type="submit" class="btn btn-primary save-button-shadow form-control"><i class="fa fa-floppy-o"></i> <span>Update</span></button>
					</div>
					<div class="col-md-3">
						<a href="{{ action('Masters\DepartmentController@index') }}" class="btn btn-default save-button-shadow form-control"><i class="fa fa-exclamation-circle"></i> <span>Cancel</span></a>
					</div>
				</div>
			{{ Form::close() }}
		</div>
	</div>
	<!--=== /Page Content ===-->
@endsection