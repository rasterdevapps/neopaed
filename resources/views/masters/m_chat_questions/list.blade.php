@extends('app')
@section('content')
	<?php $write_permission = session('write_permission'); ?>
<?php $delete_permission = session('delete_permission'); ?>
	<!-- Breadcrumbs line -->
	<div class="crumbs bread-crumbs-shadow">
		<ul id="breadcrumbs" class="breadcrumb">
			<li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
			<li class="current"><a href="{{ action('Masters\MchatquestionsController@index') }}">M-CHAT-R Questions</a></li>
		</ul>
	</div>
	<!-- /Breadcrumbs line -->
	<div class="row row-spacing">
		<div class="col-md-12">
			<div class="widget box table-view-shadow">
				<div class="widget-header">
					<h4>Investigation</h4>
					<a href="{{ action('Masters\MchatquestionsController@create') }}" class="btn btn-basic-shadow btn-info pull-right create-btn-spacing"><i class="fa fa-plus"></i><span>Create New</span></a>
				</div>
				<div class="widget-content inherittable">
					<table class="table table-striped table-bordered table-responsive datatable dataTable" id="data-list">
						<thead>
							<tr>
								<th>S.No.</th>
								<th>Question</th>
								<th>Answer</th>
								<th>Status</th>
	                            @if(in_array('MAS_M_CHAT_R_QUESTIONS',$write_permission))
									<th>Edit</th>
					                @endif
	                            @if(in_array('MAS_M_CHAT_R_QUESTIONS',$delete_permission))
									<th>Delete</th>
								@endif
							</tr>
						</thead>
						<tbody>
							@for ($i = 0; $i < @count($results); $i++)
								<tr>
									<td>{{ $i + 1 }}</td>
					                <td>{{ $results[$i]->question }}</td>
					                <td>{{ $results[$i]->correct_answer }}</td>
					                <td>{{ isset($results[$i]->status) && $results[$i]->status == '1' ? 'Active' : 'Inactive' }}</td>
					                @if(in_array('MAS_M_CHAT_R_QUESTIONS',$write_permission))
						                <td class="center-align-phone">
											<a class="btn btn-info btn-view" href="{{ action('Masters\MchatquestionsController@edit',SiteHelpers::encrypt_id($results[$i]->id) ) }}" title="Edit Record">
												<i class="fa fa-edit"></i>
											</a>
						                </td>
					                @endif
	                            	@if(in_array('MAS_M_CHAT_R_QUESTIONS',$delete_permission))
						                <td class="center-align-phone">
						                	<a class="icon btn btn-danger btn-remove" href="javascript:" onclick="Delete({{ $results[$i]->id }})" title="Delete Record">
                  								<i class="fa fa-trash"></i> 
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
              	$("#DeleteForm").attr('action',"{{ action('Masters\MchatquestionsController@index') }}/"+id);
        		$("#DeleteForm").submit();
      		}
    	});
	}
</script>
@endsection
