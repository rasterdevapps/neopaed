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
				<a href="{{ action('Masters\InvestigationController@index') }}">Investigation</a>
			</li>
			<li class="current">
				<a>Create</a>
			</li>
		</ul>
	</div>
	<!-- /Breadcrumbs line -->
	<!--=== Page Content ===-->
	<div class="row row-spacing">
		<div class="col-md-9">
			{{ Form::open(['url' => action('Masters\InvestigationController@store')]) }}
				<div class="col-md-12 form-group">
					<table class="master_investigation multi-row col-md-12">
						<thead>
							<tr>
								<th>Name</th>
								<th>Status</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									{{ Form::text('Name[]', null, ['class'=>'form-control input-fields-shadow input-width-large']) }}
								</td>
								<td>
									{{ Form::select('Status[]',['Active'=>'Active', 'Inactive'=>'Inactive'], 'Active', ['class'=>'form-control input-fields-shadow input-width-medium']) }}
								</td>
								<td><span class="fa fa-remove btn btn-default save-button-shadow remove"></span></td>
							</tr>
						</tbody>
					</table>
					<a class="btn save-button-shadow btn_add master_investigation_add"><i class="fa fa-plus"></i><span>Add More</span></a>
					<div class="row">
						<div class="col-md-3">
							<button type="submit" class="btn btn-primary save-button-shadow form-control"><i class="fa fa-floppy-o"></i> <span>Save</span></button>
						</div>
						<div class="col-md-3">
							<a href="{{ action('Masters\InvestigationController@index') }}" class="btn btn-default save-button-shadow form-control"><i class="fa fa-exclamation-circle"></i> <span>Cancel</span></a>
						</div>
					</div>
				</div>
			{{ Form::close() }}
		</div>
	</div>
	<!--=== /Page Content ===-->
@endsection