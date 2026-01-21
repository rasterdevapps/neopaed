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
			<a href="{{ action('Masters\MchatquestionsController@index') }}">M-CHAT-R Questions</a>
		</li>
		<li class="current">
			<a>Edit</a>
		</li>
	</ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing select-container-main">
	<div class="master-layout">
		{!! Form::model($results,['method'=> 'PATCH','url' => action('Masters\MchatquestionsController@update', 0),'id'=>'EditForm']) !!}
		<input type="hidden" name="tablename" value="m_chat_r_questions" />
		<input type="hidden" name="columnname" value="question" />
        <input type="hidden" name="deletecolumnname" value="is_deleted" />
        <input type="hidden" name="sortcolumnname" value="id" />
        <input type="hidden" name="currentId" value="{{$results->id}}" />
		<input type="hidden" name="columnname_5" value="correct_answer" />
		<div class="col-md-12 overflow-auto">
			<table class="master_investigations multi-row table table-add-more full-width-fix">
				<thead>
					<tr>
						<th>Question</th>
						<th>Answer</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<input type="hidden" name="id" value="{{$results->id}}" />
							<textarea class="form-control" name="question" rows="10" cols="50">{{ $results->question }}</textarea>
						</td>
						<td>
							<input data-size="small" name="correct_answer" data-off="No" data-on="Yes" data-width="100" data-toggle="toggle" class="form-control switch-input" type="checkbox" @if(isset($results->correct_answer) && $results->correct_answer == 'Yes') checked @endif />
						</td>
						<td>
							<select name="status" class="form-control input-fields-shadow input-width-medium">
								@php $status_active = ($results->status == 1) ? 'selected' : ''; @endphp
								@php $status_inactive = ($results->status == 0) ? 'selected' : ''; @endphp
								<option value="1" {{$status_active}}>Active</option>
								<option value="0" {{$status_inactive}}>Inactive</option>
							</select>
						</td>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="5">
							<div class="master-btn-layout">
								<button type="submit" class="btn btn-primary btn-basic-shadow form-control input-width-medium"><i class="fa fa-floppy-o"></i> Update</button>
								<a href="{{ action('Masters\MchatquestionsController@index') }}" class="btn btn-basic-shadow btn-default form-control input-width-medium" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> Cancel</a>
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
		$('#EditForm .btn.btn-primary').on('click', function(event) {
			$("#EditForm").validate({
				onfocusout: false,
				onkeyup: false,
				rules: {
		            question: {
		                required: true,
						edit_alreadyexists: true,
		            }
		        },
				submitHandler: function(form) {
					$(this).prop('disabled', true);
					$(this).html('<i class="fas fa-spinner fa-pulse"></i> Loading...');
					form.submit();
				}
			});			
		});
   });
</script>
@endsection