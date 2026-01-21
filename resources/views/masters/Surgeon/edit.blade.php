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
                <a href="{{ action('Masters\SurgeonController@index') }}">Surgeon</a>
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
         {!! Form::model($results,['method'=> 'PATCH','url' => action('Masters\SurgeonController@update',$results->id),'id'=>'EditForm']) !!}

            <div class="row">
				    <div class="col-md-5 form-group ">
				        <div class="form-group">
				            {!! Form::label('surgeon_name','Surgeon Name:') !!}
				            {!! Form::text('surgeon_name',null,['class'=>'form-control']) !!}
				        </div>
				      
				        <div class="form-group">
				            {!! Form::label('status','Surgeon Status:') !!}
				            {!! Form::select('status',['1'=>'Active','0'=>'Inactive'],null,['class'=>'form-control']) !!}
				        </div>
				    </div>
				</div>
				<div class="row">
				    <div class="col-md-3">
				        <button type="submit" class="btn btn-primary form-control"><i class="fa fa-floppy-o"></i> <span>Update</span>
				        </button>
				    </div>
				    <div class="col-md-3">
				        <a href="{{ action('Masters\SurgeonController@index') }}" class="btn btn-default form-control"
				           onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> <span>Cancel</span></a>
				    </div>
				</div>
            {!! Form::close() !!}
            @include('errors.list')
        </div>
    </div>  
    
@endsection
