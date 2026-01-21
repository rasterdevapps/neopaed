@extends('app')
@section('content')
<!-- Breadcrumbs line -->
	<div class="crumbs bread-crumbs-shadow">
		<ul id="breadcrumbs" class="breadcrumb">
			<li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
			<li><a href="{{ action('Registration\MotherController@index') }}">Mother Registration</a></li>       
			<li class="current"><a>Edit</a></li>                                                 
		</ul>
    </div>
<!-- Breadcrumbs line -->
<!-- Page Content -->
	<div class="row row-spacing">
		<div class="col-md-12">
		    @include('errors.list')
		    {!! Form::model($results,['method'=> 'PATCH','url' => action('Registration\NurseMotherController@update',$results->MotherId),'id'=>'EditForm', 'class'=>'mother_registration_form']) !!}
            {!! Form::hidden('MotherId',null,['class'=>'form-control','id'=>'MotherId']) !!}
            @include('nurse_registration.mothers_form',['SubmitButtonText'=>'Update & Close','SavedhereText'=>'Update','createBaby'=>'Register Baby'])
            {!! Form::close() !!}
        </div> <!-- End col-md-12 -->
	</div> <!-- End row -->
<!-- End Page Content -->
@endsection
@section('scripts')
<script type="text/javascript">
/* PLUGIN USED FOR FORM LOCAL STORAGE */
$( "form" ).sisyphus({  customKeySuffix: "mother", locationBased: true });
</script>
@endsection
