@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li><i class="icon-home"></i>
			<a href="{{ url('/') }}">Dashboard</a>
		</li>
		<li>
			<a href="{{ action('Masters\AntibioticController@index') }}">Antibiotics</a>
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
		{!! Form::model($results,['method'=> 'PATCH','url' => action('Masters\AntibioticController@update',$results->Id),'id'=>'EditForm']) !!}
	      @include('masters.antibiotic.form',['SubmitButtonText'=>'Update'])
	    {!! Form::close() !!}
	    @include('errors.list')
	</div> <!-- /.col-md-12 -->
    <div class="sidebar-right panel panel-default hidden">
        <div class="">
            <h3>Search</h3>
            <div class="form-group">
                {!! Form::text('SearchField',null,['class'=>'form-control','id'=>'SearchField']) !!}
            </div>
            <div class="form-group">
               <a href="javascript:void(0);" class="btn btn-primary form-control search-list">Search</a>
            </div>
            <ul class="search-results list-group">
            </ul>
        </div>
    </div>                    
</div> <!-- /.row -->

@endsection
@section('scripts')
<script type="text/javascript">
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

