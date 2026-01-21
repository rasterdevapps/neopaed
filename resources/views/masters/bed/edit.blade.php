@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul class="breadcrumb" id="breadcrumbs">
		<li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
		<li><a href="{{ action('Masters\BedController@index') }}">Bed</a></li>
		<li class="current"><a>Edit</a></li>
	</ul>
</div>
<!-- /Breadcrumbs line -->	
<!-- <div class="page-header"></div> -->
<div class="row row-spacing select-container-main">
	<div class="master-btn-layout">
		{{ Form::open(['method'=>'PATCH', 'url' => action('Masters\BedController@update', $room_details->id), 'id' => 'EditForm']) }}
		<div class="row p-0">
			<table class="table bed_ward multi-row table-add-more full-width-fix">
				<thead>
					<tr>
						<th>Ward</th>
						<th>Room Number</th>
						<th>Bed Number</th>
						<th>Room Status</th>
                        <th>Pump Type</th>
						<th>
							<a class="bed_ward_add btn btn-success btn-view btn_add"><i class="fa fa-plus"></i></a>
						</th>
					</tr>
				</thead>
				<tbody>
					<div class="hidden">
						{!! Form::select('temp_bed_status',\ValuelistHelpers::roomStatus(),'') !!}
                        {!! Form::select('temp_pump_type',\ValuelistHelpers::pumptype(),'') !!}
					</div>
					@php $i = 0; @endphp
					@foreach($bed_details as $key => $bed_detail)
					<tr data-len="{{ $bed_detail->id }}">
						@if($i == 0)
						<td>{!! Form::select('ward',$ward,$room_details->ward_id,['class'=>'form-control input-width-medium input-fields-shadow'] ) !!}	</td>
						<td><input type="text" name="roomnumber" value="{{ $room_details->number }}" class="form-control input-width-medium input-fields-shadow"/></td>
						@else
						<td></td>
						<td></td>
						@endif
						<td><input type="text" name="bednumber[{{ $bed_detail->id }}]" value="{{ $bed_detail->number }}" class="form-control input-width-medium bed-number-count input-fields-shadow"/></td>
						<td>
							<select name="status[{{ $bed_detail->id }}]" class="form-control input-fields-shadow input-width-medium bed-number-count">
								@php $status = $bed_detail->status @endphp
								@foreach(\ValuelistHelpers::roomStatus() as $key => $value)
								<option value="{{ $value }}" @if($value == $status) selected="selected" @endif>{{ $value }}</option>
								@endforeach
							</select>
						</td>
						<td>
							<select name="pump_type[{{ $bed_detail->id }}]" class="form-control input-fields-shadow input-width-medium">
								@php $pump_type = $bed_detail->pump_type; @endphp
								@foreach(\ValuelistHelpers::pumptype() as $key => $value)
								<option value="{{ $key }}" @if($key == $pump_type) selected="selected" @endif>{{ $value }}</option>
								@endforeach
							</select>
						</td>
						<td></td>
					</tr>
					@php $i++; @endphp
					@endforeach
				</tbody>
				<tfoot>
					<tr>
						<td colspan="5">
							<div class="master-btn-layout"> 
								<button type="submit" class="btn btn-primary btn-basic-shadow input-width-medium">
									<i class="fa fa-floppy-o"></i>
									Update
								</button>
								<a class="btn btn-default btn-basic-shadow input-width-medium" href="{{ action('Masters\BedController@index') }}">
									<i class="fa fa-exclamation-circle"></i>
									Cancel
								</a>	
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

		$('.btn.btn-primary').on('click', function(event) {

			$('#EditForm input').each(function() {
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


