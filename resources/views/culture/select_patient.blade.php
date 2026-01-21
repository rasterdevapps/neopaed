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
			<a href="{{ action('Extras\CultureController@index') }}">Culture Registry</a>
		</li>
		<li class="current">
			<a>Choose Baby</a>
		</li>                                                
	</ul>

</div>
<!-- /Breadcrumbs line -->

<!-- Page Header -->
<div class="page-header">
</div>
<!-- /Page Header -->

<!--=== Page Content ===-->
<div class="row select-container-main">
	<div class="col-md-6 col-sm-6 col-xs-6">
		<div class="row select-option-container">
			<div class="col-md-12">
                {!! Form::hidden('action_url', action('Extras\CultureController@index')) !!}
                {!! Form::hidden('select_field_data', $babies) !!}
                @include('select',  [
                    'label_name' => 'Select Baby:',
                    'placeholder' => '-- Select from List --',
                    'error_message' => 'Please Choose The Baby'
                ])
			</div>
			<div class="col-md-12 mt-15">
				<div class="col-md-6 col-sm-6 col-xs-6">
					<button type="submit" class="btn btn-success submitbtn form-control save-button-shadow btn-block"><i class="fa fa-forward"></i> <span>{!! $SubmitButtonText !!}</span></button>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-6">
					<a href="{{ action('Extras\CultureController@index') }}" class="cancel-btn btn btn-default form-control save-button-shadow btn-block" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> <span>Cancel</span></a>
				</div>
			</div>                           
		</div>
	</div> <!-- /.col-md-12 -->
</div> <!-- /.row -->
<!-- /Page Content -->                
@endsection
