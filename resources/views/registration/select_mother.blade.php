@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<style type="text/css">
    #content
    {
        margin-left: 40px;
    }
</style>
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
		<li><a href="{{ action('Registration\OpController@index') }}">Baby Registration</a></li>
        <li class="current"><a>Choose Mother</a></li>                                                
    </ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing select-container-main">
    <div class="col-md-6 col-sm-6 col-xs-6">
        <div class="row select-option-container">
            <div class="col-md-12">
                {!! Form::hidden('action_url', action('Registration\BabyController@create')) !!}
                {!! Form::hidden('select_field_data', $mothers) !!}
                @include('select',  [
                    'label_name' => 'Select Mother:',
                    'placeholder' => '-- Select from List --',
                    'error_message' => 'Please Choose The Mother'
                ])
            </div>
            <div class="col-md-12 mt-15">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <button type="submit" class="btn btn-success save-button-shadow submitbtn form-control"><i class="fa fa-forward"></i> <span>{!! $SubmitButtonText !!}</span></button>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <a href="{{ action('Registration\BabyController@index') }}" class="cancel-btn save-button-shadow  btn btn-default form-control" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> <span>Cancel</span></a>
                </div>
            </div>                           
        </div>
    </div> <!-- /.col-md-12 -->
</div> <!-- /.row -->
<!-- /Page Content -->                
@endsection
