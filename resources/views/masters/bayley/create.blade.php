@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul class="breadcrumb" id="breadcrumbs">
		<li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
		<li><a href="{{ action('Masters\BayleyScaleController@index') }}">Bayley Scale</a></li>
		<li class="current"><a>Create</a></li>
	</ul>
</div>
<!-- /Breadcrumbs line -->	
<!-- <div class="page-header"></div> -->
<div class="row row-spacing select-container-main">
	<div class="master-layout">
		{{ Form::open(['url' => action('Masters\BayleyScaleController@store'),'id'=> 'checkform']) }}
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
					<tr data-len="0">
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
						<td>
							{!! Form::textarea('title[0]',null,['class'=>'form-control input-width-medium input-fields-shadow', 'rows'=>3] ) !!}	
						</td>
						<td>
							{!! Form::text('score[0]',null,['class'=>'form-control input-width-medium input-fields-shadow novalidation'] ) !!}	
						</td>
						<td>
							{!! Form::select('type[0]',$type, null,['class'=>'form-control input-width-medium input-fields-shadow'] ) !!}	
						</td>
						<td></td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="9">
							<div class="master-btn-layout">
								<button type="submit" class="btn btn-primary btn-basic-shadow form-control input-width-medium"><i class="fa fa-floppy-o"></i> Save</button>
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

			$('#checkform input:not(.novalidation)').each(function() {
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
