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
			<a href="{{ action('Masters\MchatfollowupquestionsController@index') }}">M-CHAT-R Followup Questions</a>
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
		{!! Form::model($results,['method'=> 'PATCH','url' => action('Masters\MchatfollowupquestionsController@update', 0),'id'=>'EditForm']) !!}
		<div class="col-md-12 overflow-auto">
			<table class="master_investigations multi-row table table-add-more full-width-fix">
				<thead>
					<tr>
						<th>Question</th>
						<th>Answer</th>
						<th>come from which answer</th>
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
							<input data-size="small" name="answer_based_type" data-off="No" data-on="Yes" data-width="100" data-toggle="toggle" class="form-control switch-input" type="checkbox" @if(isset($results->answer_based_type) && $results->answer_based_type == 'Yes') checked @endif />
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
								<a href="{{ action('Masters\MchatfollowupquestionsController@index') }}" class="btn btn-basic-shadow btn-default form-control input-width-medium" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> Cancel</a>
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