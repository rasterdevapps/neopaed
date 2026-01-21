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
			<a href="{{ action('Masters\InvestigationsController@index') }}">Investigations</a>
		</li>
		<li class="current">
			<a>Create</a>
		</li>
	</ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing select-container-main">
	<div class="master-layout">
		{!! Form::model($results,['method'=> 'PATCH','url' => action('Masters\InvestigationsController@update', 0),'id'=>'EditForm']) !!}
		<div class="col-md-12 overflow-auto">
			<table class="master_investigations multi-row table table-add-more full-width-fix">
				<thead>
					<tr>
						<th>Package Name</th>
						<th>Package Status</th>
						<th>Test Name</th>
						<th>Test Status</th>
						<th>
							<span>
								<a class="btn btn-success master_investigations_add btn-view btn_add" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
							</span>                
						</th>
					</tr>
				</thead>
				<tbody>
					@php $test_name = ValuelistHelpers::get_test_investigations_master($results->id); @endphp

					@foreach ($test_name as $test_key => $test_value)
					<tr data-len="{{$test_key}}">
						@if ($test_key == 0)                	
						<td>
							<input type="hidden" name="package_id" value="{{$results->id}}" />
							<input type="hidden" name="test_id[{{$test_value->id}}]" value="{{$test_value->id}}" />
							<input type="text" name="package_name" value="{{$results->package_name}}" class="form-control input-fields-shadow input-width-large name"/>
						</td>
						<td>
							<select name="package_status" class="form-control input-fields-shadow input-width-medium">
								@php $package_status_active = ($results->package_status == 1) ? 'selected' : ''; @endphp
								@php $package_status_inactive = ($results->package_status == 0) ? 'selected' : ''; @endphp
								<option value="1" {{$package_status_active}}>Active</option>
								<option value="0" {{$package_status_inactive}}>Inactive</option>
							</select>
						</td>
						<td>
							<input type="text" name="test_name[{{$test_value->id}}]" value="{{$test_value->test_name}}" class="form-control input-fields-shadow input-width-medium name" />
						</td>
						<td>
							<select name="test_status[{{$test_value->id}}]" class="form-control input-fields-shadow input-width-medium">
								@php $test_status_active = ($test_value->test_status == 1) ? 'selected' : ''; @endphp
								@php $test_status_inactive = ($test_value->test_status == 0) ? 'selected' : ''; @endphp
								<option value="1" {{$test_status_active}}>Active</option>
								<option value="0" {{$test_status_inactive}}>Inactive</option>
							</select>
						</td>
						<td>
							<span class="fa fa-trash btn btn-danger btn-view remove"></span>
						</td>
						@else

						<td>
							<input type="hidden" name="test_id[{{$test_value->id}}]" value="{{$test_value->id}}" />
						</td>
						<td></td>
						<td>
							<input type="text" name="test_name[{{$test_value->id}}]" value="{{$test_value->test_name}}" class="form-control input-fields-shadow input-width-medium name" />
						</td>
						<td>
							<select name="test_status[{{$test_value->id}}]" class="form-control input-fields-shadow input-width-medium">
								@php $test_status_active = ($test_value->test_status == 1) ? 'selected' : ''; @endphp
								@php $test_status_inactive = ($test_value->test_status == 0) ? 'selected' : ''; @endphp
								<option value="1" {{$test_status_active}}>Active</option>
								<option value="0" {{$test_status_inactive}}>Inactive</option>
							</select>
						</td>
						<td>
							<span class="fa fa-trash btn btn-danger btn-view remove"></span>
						</td>
						@endif   
					</tr>
					@endforeach
				</tbody>
				<tfoot>
					<tr>
						<td colspan="5">
							<div class="master-btn-layout">
								<button type="submit" class="btn btn-primary btn-basic-shadow form-control input-width-medium"><i class="fa fa-floppy-o"></i> Update</button>
								<a href="{{ action('Masters\InvestigationsController@index') }}" class="btn btn-basic-shadow btn-default form-control input-width-medium" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> Cancel</a>
							</div>
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
		{!! Form::close() !!}
	</div>
	<!-- /.col-md-12 -->
</div>
<!-- /.row -->
<!-- /Page Content -->
@endsection
@section('scripts')
<script type="text/javascript">
	$(document).ready(function() {        
		$('.btn.btn-primary').on('click', function(event) {
			$('#EditForm input.name').each(function() {
				$(this).rules("add", {
					required: true
				});
			});

			if($('#EditForm').validate().form()) {
				return true;
			} else {
				return false;
			}
		});      
		$('#EditForm').validate();      
	});
</script>
@endsection