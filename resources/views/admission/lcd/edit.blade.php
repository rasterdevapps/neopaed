@extends('app')
@section('content')
    <!-- Breadcrumbs line -->
    <div class="crumbs bread-crumbs-shadow">
        <ul id="breadcrumbs" class="breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="/">Dashboard</a>
            </li>
            <li>
                <a href="{{ action('Admission\IcdController@index') }}">ICD 10</a>
            </li>
            <li class="current">
                <a>Create</a>
            </li>
        </ul>
    </div>
    <!-- /Breadcrumbs line -->

    <!-- Page Header -->
    <div class="page-header">
    </div>
    <!-- /Page Header -->

    <!--=== Page Content ===-->
    <div class="row">
        <div class="col-md-9">
            {!! Form::open(['url' => action('Admission\IcdController@update')]) !!}
            {!! Form::hidden('Id',null,['class'=>'form-control','id'=>'Id']) !!}
            <div class="col-md-12 form-group">
                
                <div class="row">
    <div class="col-md-5 ">
        <div class="form-group">
            {!! Form::label('ICDCode','ICD Code:') !!}
            {!! Form::text('ICDCode',null,['class'=>'form-control input-fields-shadow']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('ICDDescription','ICD Description:') !!}
            {!! Form::text('ICDDescription',null,['class'=>'form-control input-fields-shadow']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('ICDFormat','ICD Format:') !!}
            {!! Form::text('ICDFormat',null,['class'=>'form-control input-fields-shadow']) !!}
        </div>
    </div>

</div> 
<div class="row">
    <div class="col-md-3 col-sm-4">
        <button type="submit" class="btn btn-primary form-control btn-basic-shadow"><i class="fa fa-floppy-o"></i> <span>Save</span>
        </button>
    </div>
    <div class="col-md-3 col-sm-4">
        <a href="{{ action('Admission\IcdController@index') }}" class="btn btn-default form-control btn-basic-shadow"
           onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> <span>Cancel</span></a>
    </div>
</div>

                
            </div>
            {!! Form::close() !!}
            @include('errors.list')
        </div>
        <!-- /.col-md-12 -->
    </div> <!-- /.row -->
    <!-- /Page Content -->
@endsection
