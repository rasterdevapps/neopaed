@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li><i class="icon-home"></i>
			<a href="{{ url('/') }}">Dashboard</a>
		</li>
		<li>
			<a href="{{ action('Masters\DoseController@index') }}">Dose</a>
		</li>       
		<li class="current">
			<a>Edit</a>
		</li>                                              
	</ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing select-container-main">
	<div class="master-btn-layout">
		{!! Form::model($results,['method'=> 'PATCH','url' => action('Masters\DoseController@update',$results->id),'id'=>'EditForm']) !!}
		<input type="hidden" name="tablename" value="mas_dose" />
		<input type="hidden" name="columnname" value="volume" />
        <input type="hidden" name="deletecolumnname" value="is_deleted" />
        <input type="hidden" name="sortcolumnname" value="id" />
        <input type="hidden" name="currentId" value="{{$results->id}}" />
		<div class="row select-option-container">
			<div class="col-md-12">
				<div class="form-group row">
					<div class="col-md-3 text-right label-control">
						{!! Form::label('volume','Volume:') !!}
					</div>
					<div class="col-md-9 custom-input">
						{!! Form::text('volume',null,['class'=>'form-control input-fields-shadow']) !!}
					</div>                             
				</div>  
				<div class="form-group row">
					<div class="col-md-3 text-right label-control">
						{!! Form::label('status','Status:') !!}
					</div>
					<div class="col-md-9 custom-input">
						{!! Form::select('status',['1'=>'Active','0'=>'Inactive'],null,['class'=>'form-control input-fields-shadow']) !!}
					</div>                     		
				</div>
			</div>
		<div class="col-md-12 select-container-main">
				<button type="submit" class="btn btn-primary btn-basic-shadow form-control input-width-medium">
					<i class="fa fa-floppy-o"></i><span>Update</span>
				</button>
				<a href="{{ action('Masters\DoseController@index') }}" class="btn btn-default btn-basic-shadow form-control input-width-medium" onclick="$('form')[0].reset();">
					<i class="fa fa-exclamation-circle"></i> <span>Cancel</span>
				</a>
		</div>

		{!! Form::close() !!}
		@include('errors.list')
	</div> <!-- /.col-md-12 -->                  
</div> <!-- /.row -->

@endsection
@section('scripts')
<script type="text/javascript">
	$(document).ready(function() {
		$('#EditForm .btn.btn-primary').on('click', function(event) {
			$("#EditForm").validate({
				onfocusout: false,
				onkeyup: false,
				rules: {
		            volume: {
		                required: true,
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

