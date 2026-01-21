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
			<a href="{{ action('Masters\DrugController@index') }}">Drugs</a>
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
    {!! Form::model($results,['method'=> 'PATCH','url' => action('Masters\DrugController@update',$results->Id),'id'=>'EditForm']) !!}
        {!! Form::hidden('Id',null,['class'=>'form-control','id'=>'Id']) !!}
        @include('masters.drug.form',['SubmitButtonText'=>'Update'])
    {!! Form::close() !!}
        @include('errors.list')
	</div> <!-- /.col-md-12 -->
</div> <!-- /.row -->
				<!-- /Page Content -->

@endsection
@section('scripts')
<script type="text/javascript">
    $( "form" ).sisyphus({  customKeySuffix: "mother", locationBased: true });
    $(document).ready(function() {
        $('#EditForm').validate({
            rules: {
                Name: {
                    required: true
                }
            }
        });
   });
</script>
@endsection
