@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul class="breadcrumb" id="breadcrumbs">
		<li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
		<li><a href="{{ action('Masters\BedController@index') }}">Bed</a></li>
		<li class="current"><a>Create</a></li>
	</ul>
</div>
<!-- /Breadcrumbs line -->	
<!-- <div class="page-header"></div> -->
<div class="row row-spacing select-container-main">
	<div class="master-layout">
		{{ Form::open(['url' => action('Masters\BedController@store'),'id'=> 'checkform']) }}
		<div class="col-md-12">
			<table class="table bed_ward multi-row mb-20 table-add-more full-width-fix">
				<thead>
					<tr>
						<th>Ward</th>
						<th>Room Number</th>
						<th>Bed Number</th>                    
						<th>Room Status</th>
                        <th>Pump Type</th>
            <th>
              <span>
                <a class="btn btn-success bed_ward_add btn-view btn_add" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
              </span>                
            </th>                                                        
					</tr>
				</thead>
				<tbody>
					<div class="hidden">
						{!! Form::select('temp_bed_status',\ValuelistHelpers::roomStatus(),'') !!}
                        {!! Form::select('temp_pump_type',\ValuelistHelpers::pumptype(),'') !!}
					</div>
					<tr data-len="0">
						<td>
							{!! Form::select('ward',$ward,null,['class'=>'form-control input-width-medium input-fields-shadow'] ) !!}	
						</td>
						<td>
							<input type="text" name="roomnumber" value="" class="form-control input-width-medium input-fields-shadow"/>
						</td>
						<td>
							<input type="text" name="bednumber[]" value="" class="form-control input-width-medium input-fields-shadow"/>
						</td>
						<td>
							{!! Form::select('status[]',\ValuelistHelpers::roomStatus(),null,['class'=>'form-control input-width-medium input-fields-shadow'] ) !!}	
						</td>
                        <td>
                            {!! Form::select('pump_type[]',\ValuelistHelpers::pumptype(),null,['class'=>'form-control input-width-medium input-fields-shadow'] ) !!} 
                        </td>
								<!-- <td>
									<a class="btn-basic-shadow btn btn-default remove"><i class="fa fa-remove"></i></a>
								</td> -->
          <td></td>
							</tr>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="6">
									<div class="master-btn-layout">
										<button type="submit" class="btn btn-primary btn-basic-shadow form-control input-width-medium"><i class="fa fa-floppy-o"></i> Save</button>
										<a class="btn btn-default btn-basic-shadow form-control input-width-medium" href="{{ action('Masters\BedController@index') }}"><i class="fa fa-exclamation-circle"></i> Cancel</a>
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
