@extends('app')
@section('content')
<!-- Breadcrumbs line -->
  <div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
	   	<li>
		   <i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a>
		</li>
		<li>
			<a href="{{ action('Masters\DoctorController@index') }}">Doctors & Surgeons</a>
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
  <div class="row row-spacing select-container-main">
	<div class="master-btn-layout">
       {!! Form::model($results,['method'=> 'PATCH','url' => action('Masters\DoctorController@update',$results->id),'id'=>'EditForm']) !!}
        @include('masters.Doctors.form',['SubmitButtonText'=>'Update'])
       {!! Form::close() !!}
        @include('errors.list')
	</div> <!-- /.col-md-12 -->
   
</div> <!-- /.row -->
				<!-- /Page Content -->
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


