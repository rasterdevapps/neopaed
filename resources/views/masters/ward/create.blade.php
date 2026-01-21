@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul class="breadcrumb" id="breadcrumbs">
		<li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
		<li><a href="{{ action('Masters\WardController@index') }}">Ward</a></li>
		<li class="current"><a>Create</a></li>
	</ul>
</div>
<!-- /Breadcrumbs line -->	
<!-- <div class="page-header"></div> -->
<div class="row row-spacing select-container-main">
	<div class="master-layout">
		{{ Form::open(['url' => action('Masters\WardController@store'),'id'=> 'checkform']) }}
		<div class="col-md-12 overflow-auto">
			<table class="master_ward multi-row table table-add-more full-width-fix">
				<thead>
					<tr>
						<th>Block</th>
						<th colspan="2">Ward Group</th>
						<th>Ward</th>
						<th colspan="2"></th>
					</tr>
				</thead>
				<tbody>
					<tr data-len="1">
						<td>
							<input type="text" name="block" value="" class="form-control input-width-medium input-fields-shadow"/>
						</td>
						<td>
							<input type="text" name="wardgroup[1]" value="" class="form-control input-width-medium wardgroup input-fields-shadow"/>
						</td>
						<td>
							<a class="master_ward_group_add btn btn-success btn-view btn_add" data-id="1"><i class="fa fa-plus"></i></a>
						</td>
						<td>
							<input type="text" name="ward1[]" value="" class="form-control ward input-width-medium input-fields-shadow"/>
						</td>
						<td>
							<a class="master_ward_add btn btn-success btn-view btn_add" data-id="1"><i class="fa fa-plus"></i></a>
						</td>
								<!-- <td>
									<a class="btn btn-default btn-basic-shadow remove"><i class="fa fa-remove"></i></a>
								</td> -->
								<td></td>
								
							</tr>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="6">
									<div class="master-btn-layout">
										<button type="submit" class="btn btn-primary btn-basic-shadow form-control input-width-medium"><i class="fa fa-floppy-o"></i> Save</button>
										<a class="btn btn-default btn-basic-shadow form-control input-width-medium" href="{{ action('Masters\WardController@index') }}"><i class="fa fa-exclamation-circle"></i> Cancel</a>
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

				$('#checkform .btn.btn-primary').on('click', function(event) {

					var ids = highestValueOf(".master_ward tr");

					$('input[name="data_len"]').val(ids);

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
