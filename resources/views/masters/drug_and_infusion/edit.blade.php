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
			<a href="{{ action('Masters\DrugAndInfusionController@index') }}">Drugs And Infusion</a>
		</li>       
		<li class="current">
			<a>Edit</a>
		</li>                                                 
	</ul>
</div>
<!-- /Breadcrumbs line -->
				<!--=== Page Content ===-->
<div class="row row-spacing">
    <div class="col-md-9">
    {!! Form::model($results,['method'=> 'PATCH','url' => action('Masters\DrugAndInfusionController@update',$results->Id),'id'=>'EditForm']) !!}
        {!! Form::hidden('Id',null,['class'=>'form-control','id'=>'Id']) !!}
        @include('masters.drug_and_infusion.form',['SubmitButtonText'=>'Save'])
    {!! Form::close() !!}
        @include('errors.list')
	</div> <!-- /.col-md-12 -->
</div> <!-- /.row -->
				<!-- /Page Content -->

@endsection
@section('scripts')
<script type="text/javascript">
$( "form" ).sisyphus({  customKeySuffix: "mother", locationBased: true });
</script>
@endsection