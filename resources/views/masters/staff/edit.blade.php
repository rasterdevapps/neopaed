@extends('app')
@section('content')
<!-- Breadcrumbs line -->
  <div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
	   	<li>
		   <i class="icon-home"></i><a href="/">Dashboard</a>
		</li>
		<li>
			<a href="{{ action('Masters\StaffController@index') }}">Staff</a>
		</li>       
		<li class="current">
			<a>Edit</a>
		</li>                                              
	</ul>
  </div>
 <!-- /Breadcrumbs line -->
 <!-- Page Header -->
  <!-- <div class="page-header">
  </div> -->
 <!-- /Page Header -->
 <!--=== Page Content ===-->
  <div class="row row-spacing">
	<div class="col-md-9">
       {!! Form::model($results,['method'=> 'PATCH','url' => action('Masters\StaffController@update',$results->staff_id),'id'=>'EditForm']) !!}
        @include('masters.staff.form',['SubmitButtonText'=>'Update'])
       {!! Form::close() !!}
        @include('errors.list')
	</div> <!-- /.col-md-12 -->
   
</div> <!-- /.row -->
				<!-- /Page Content -->
@endsection
