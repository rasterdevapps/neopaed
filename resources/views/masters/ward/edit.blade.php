@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul class="breadcrumb" id="breadcrumbs">
		<li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
		<li><a href="{{ action('Masters\WardController@index') }}">Ward</a></li>
		<li class="current"><a>Edit</a></li>
	</ul>
</div>
<!-- /Breadcrumbs line -->	
<!-- <div class="page-header"></div> -->
<div class="row row-spacing select-container-main">
	<div class="master-layout">
		{{ Form::open(['method'=>'PATCH','url' => action('Masters\WardController@update', $id), 'id' => 'EditForm']) }}
			    <!-- <div class="col-md-12">
                    <div class="col-md-6">
				    	<div class="form-group">
				    		{!! Form::label('block', 'Block Name:') !!}
				    		{!! Form::text('block', $block->name, ['class'=>'form-control input-fields-shadow']) !!}
				    	</div>
			    	</div>
			    </div> -->
			    <div class="col-md-12">
			    	<table class="master_ward multi-row table table-add-more full-width-fix" style="table-layout: fixed;">
			    		<thead>
			    			<tr>
			    				<th class="custom-table-padding1">Block Name</th>
			    				<th class="custom-table-padding1" colspan="2">Ward Group</th>
			    				<th class="custom-table-padding1">Ward</th>
			    				<th class="custom-table-padding1" colspan=""></th>
			    				<th class="custom-table-padding1">Status</th>
			    			</tr>
			    		</thead>
			    		<tbody>
			    			@php $i = 1; @endphp
			    			@foreach($ward_group_details as $group_detail_key => $group_detail_value)
			    			@php $ward_last_id = collect($ward_group_details)->first()->id @endphp
			    			<input type="hidden" name="len" value="{{ $ward_last_id }}" />
			    			@php $temp_ward = $group_detail_value->getward; @endphp
			    			@foreach($temp_ward as $key => $ward)
			    			<tr data-len="{{ $group_detail_value->id }}">
			    				@if($key == 0)
			    				<td class="custom-table-padding1">
			    					{!! Form::text('block', $block->name, ['class'=>'form-control input-fields-shadow input-width-medium']) !!}
			    				</td>
			    				<td class="custom-table-padding1">
			    					<input type="text" name="wardgroup[{{ $group_detail_value->id }}]" value="{{ $group_detail_value->name }}" class="form-control input-width-medium wardgroup input-fields-shadow"/>
			    				</td>
			    				@else
			    				<td class="custom-table-padding1"></td>
			    				<td class="custom-table-padding1"></td>
			    				@endif
			    				<td class="custom-table-padding1">
			    					<a class="master_ward_group_edit_add btn btn-success btn-view btn_add" data-ward-group="{{ $group_detail_value->id }}" data-ward="{{ $ward->id }}"><i class="fa fa-plus"></i></a>
			    				</td>
			    				<td class="custom-table-padding1">
			    					<input type="text" name="ward{{$group_detail_value->id}}[{{ $group_detail_value->id.'-'.$ward->id }}]" value="{{ $ward->name }}" class="form-control ward input-width-medium input-fields-shadow"/>
			    				</td>
			    				<td class="custom-table-padding1">
			    					<a class="master_ward_edit_add btn btn-success btn-view btn_add" data-ward-group="{{ $group_detail_value->id }}" data-ward="{{ $ward->id }}"><i class="fa fa-plus"></i></a>
			    				</td>
			    				<td class="custom-table-padding1" align="center">
			    					<input type="checkbox" name="status{{ $group_detail_value->id }}[{{ $group_detail_value->id.'-'.$ward->id }}]" value="1" @if(isset($ward->active) && !empty($ward->active)) checked @endif>
			    				</td>
			    				<td class="custom-table-padding1"></td>
			    			</tr>
			    			@endforeach
			    			@php $i++; @endphp
			    			@endforeach		
			    		</tbody>
			    		<tfoot>
			    			<tr>
			    				<td colspan="6">
			    					<div class="master-btn-layout">
			    						<button type="submit" class="btn btn-primary btn-basic-shadow form-control input-width-medium">
			    							<i class="fa fa-floppy-o"></i>
			    							Update
			    						</button>
			    						<a class="btn btn-default btn-basic-shadow form-control input-width-medium" href="{{ action('Masters\WardController@index') }}">
			    							<i class="fa fa-exclamation-circle"></i>
			    							Cancel
			    						</a>
			    					</div>
			    				</td>
			    			</tr>
			    		</tfoot>
			    	</table>
			    	<input type="hidden" name="data_len" />
			    </div>
			    {{ Form::close() }}
			</div>
		</div>
		@endsection


		@section('scripts')
		<script type="text/javascript">
			$(document).ready(function() {

				$('.btn.btn-primary').on('click', function(event) {

					var ids = highestValueOf(".master_ward tr");

					$('input[name="data_len"]').val(ids);

					$('#EditForm input').each(function() {
						if ($(this).attr('type') != 'checkbox') {
							$(this).rules("add", {
								required: true
							});
						}
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
