@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul class="breadcrumb" id="breadcrumbs">
		<li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
		<li><a href="{{ action('Masters\BayleyScaleController@index') }}">Bayley Scale</a></li>
		<li class="current"><a>Edit</a></li>
	</ul>
</div>
<!-- /Breadcrumbs line -->	
<!-- <div class="page-header"></div> -->
<div class="row row-spacing select-container-main">
	<div class="master-layout">
		{{ Form::model($bayley, ['method'=>'PATCH', 'url' => action('Masters\BayleyScaleController@update', $bayley->id), 'id' => 'EditForm']) }}
		<div class="col-md-12">
			<table class="table bayley multi-row mb-20 table-add-more full-width-fix">
				<thead>
					<tr>
						<th>Start Point</th>
						<th>Question No.</th>
						<th>Category</th>
						<th>Item</th>
						<th>Materials</th>                    
						<th>Scoring criteria</th>
						<th>Score</th>
						<th>Type</th>
						<th>
							<span>
								<a class="btn btn-success bayley_add btn-view btn_add" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
							</span>                
						</th>                                                        
					</tr>
				</thead>
				<tbody>
						@foreach($sub_list as $key => $value)
					<tr data-len="{{$key}}">
						@if ($key == 0)
						<td>
							{!! Form::text('start_point',null,['class'=>'form-control input-width-medium input-fields-shadow'] ) !!}	
						</td>
						<td>
							{!! Form::text('question_no',null,['class'=>'form-control input-width-medium input-fields-shadow'] ) !!}	
						</td>
						<td>
							{!! Form::select('category', $category,null,['class'=>'form-control input-width-medium input-fields-shadow'] ) !!}	
						</td>
						<td>
							{!! Form::text('item',null,['class'=>'form-control input-width-medium input-fields-shadow'] ) !!}	
						</td>
						<td>
							{!! Form::text('materials',null,['class'=>'form-control input-width-medium input-fields-shadow'] ) !!}	
						</td>
						@else
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						@endif
						{!! Form::hidden('sub_id['.$key.']',$value->id) !!}	
						<td>
							{!! Form::textarea('title['.$key.']',$value->title,['class'=>'form-control input-width-medium input-fields-shadow', 'rows'=>3] ) !!}	
						</td>
						<td>
							{!! Form::text('score['.$key.']',$value->score,['class'=>'form-control input-width-medium input-fields-shadow'] ) !!}	
						</td>
						<td>
							{!! Form::select('type['.$key.']', $type, $value->type,['class'=>'form-control input-width-medium input-fields-shadow'] ) !!}	
						</td>
						@if ($key != 0)
        				<td>
        					<span class="fa fa-trash btn btn-danger btn-view remove"></span>
        				</td>
						@endif
					</tr>
						@endforeach
				</tbody>
				<tfoot>
					<tr>
						<td colspan="9">
							<div class="master-btn-layout">
								<button type="submit" class="btn btn-primary btn-basic-shadow form-control input-width-medium"><i class="fa fa-floppy-o"></i> Update</button>
								<a class="btn btn-default btn-basic-shadow form-control input-width-medium" href="{{ action('Masters\BayleyScaleController@index') }}"><i class="fa fa-exclamation-circle"></i> Cancel</a>
							</div>
						</td>
					</tr>
				</tfoot>
			</table>

		</div>
		{{ Form::close() }}
	</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
	$(document).ready(function() {

		$('#checkform .btn.btn-primary').on('click', function(event) {

			$('#checkform input').each(function() {
				$(this).rules("add", {
					required: true
				});
			});

			if($('#checkform').validate().form()) {
				$(this).prop('disabled', true);

				$(this).html('<i class="fas fa-spinner fa-pulse"></i> Loading...');
				$('#checkform').submit();
				return true;
			} else {
				return false;
			}
		});

		$('#checkform').validate();

	});
</script>
@endsection
