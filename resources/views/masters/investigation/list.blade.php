@extends('app')
@section('content')
	<?php $write_permission = session('write_permission'); ?>
<?php $delete_permission = session('delete_permission'); ?>
	<!-- Breadcrumbs line -->
	<div class="crumbs bread-crumbs-shadow">
		<ul id="breadcrumbs" class="breadcrumb">
			<li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
			<li class="current"><a href="{{ action('Masters\InvestigationController@index') }}">Investigation</a></li>
		</ul>
	</div>
	<!-- /Breadcrumbs line -->
	<div class="row row-spacing">
		<div class="col-md-12">
			<div class="widget box table-view-shadow">
				<div class="widget-header">
					<h4>Investigation</h4>
					<a href="{{ action('Masters\InvestigationController@create') }}" class="btn btn-basic-shadow btn-info pull-right create-btn-spacing"><i class="fa fa-plus"></i><span>Create New</span></a>
				</div>
				<div class="widget-content inherittable">
					<table class="table table-striped table-bordered table-responsive datatable dataTable" id="data-list">
						<thead>
							<tr>
								<th>S.No.</th>
								<th>Investigation Name</th>
								<th>Status</th>
	                            @if(in_array('MAS_INVESTIGATION',$write_permission))
									<th>Edit</th>
					                @endif
	                            @if(in_array('MAS_INVESTIGATION',$delete_permission))
									<th>Delete</th>
								@endif
							</tr>
						</thead>
						<tbody>
							@for ($i = 0; $i < @count($results); $i++)
								<tr>
									<td>{{ $i + 1 }}</td>
					                <td>{{  $results[$i]->Name }}</td>
					                <td>{{  $results[$i]->Status }}</td>
					                @if(in_array('MAS_INVESTIGATION',$write_permission))
						                <td class="center-align-phone">
						                  <a class="icon" href="{{ action('Masters\InvestigationController@edit',$results[$i]->Id ) }}">
						                    <i class="fa fa-pencil"></i>
						                    <span class="hidden-phone">Edit</span>
						                  </a>
						                </td>
					                @endif
	                            @if(in_array('MAS_INVESTIGATION',$delete_permission))
						                <td class="center-align-phone">
						                  <a class="icon" href="javascript:void(0);" onclick="Delete({{ $results[$i]->Id }})">
						                    <i class="fa fa-remove"></i>
						                    <span class="hidden-phone">Delete</span>
						                  </a>
						                </td>
					                @endif
								</tr>
							@endfor
						</tbody>						
					</table>
				</div>
			</div>
		</div>
	</div>
{!! Form::open(['method'=> 'DELETE','url' => '','id'=>'DeleteForm']) !!}
{!! Form::close() !!}
@endsection
@section('scripts')
<script type="text/javascript">
	function Delete(id) {
		bootbox.confirm("Are you sure?",function(confirmed) {
      		if(confirmed) {
              	$("#DeleteForm").attr('action',"{{ action('Masters\InvestigationController@index') }}/"+id);
        		$("#DeleteForm").submit();
      		}
    	});
	}
</script>
@endsection
