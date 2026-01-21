@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
		<li><a href="{{ action('Reports\InpatientListController@index') }}">Inpatient List Report</a></li>       
	</ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
	<div class="col-md-12">
        {!! Form::open(['url' => action('Reports\InpatientListController@index')]) !!}
		<div class="col-md-5 ">
            <div class="form-group">
                {!! Form::label('StartDate','Start Date:') !!}
                {!! Form::text('StartDate',null,['class'=>'form-control datepicker input-fields-shadow','readonly']) !!}
            </div>    
            <div class="form-group">
                {!! Form::label('Sex','Sex:') !!}
                {!! Form::select('Sex',[''=>'N/A','Male'=>'Male','Female'=>'Female','Indeterminate'=>'Indeterminate'],'',['class'=>'form-control input-fields-shadow']) !!}
            </div>                                       
        </div>
        <div class="col-md-offset-1 col-md-5">
            <div class="form-group">
                {!! Form::label('EndDate','End Date:') !!}
                {!! Form::text('EndDate',null,['class'=>'form-control input-fields-shadow datepicker','readonly']) !!}
            </div>      
            <div class="form-group">
                {!! Form::label('SeenBy','Seen By:') !!}
                {!! Form::select('SeenBy',[''=>'N/A']+$doctors,'',['class'=>'form-control input-fields-shadow']) !!}
            </div>  
        </div>
        <div class="button-row">
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary save-button-shadow  form-control">
                    <i class="fa fa-filter"></i> 
                    <span>{!! $SubmitButtonText !!}</span>
                </button>
            </div>
            <div class="col-md-2">
                <a href="javascript:void(0);" class="btn btn-default save-button-shadow  form-control" onclick="$('form')[0].reset();">
                    <i class="fa fa-exclamation-circle"></i><span>Clear</span>
                </a>
            </div>
        </div>
        {!! Form::close() !!}
	</div> <!-- /.col-md-12 -->
</div> <!-- /.row -->
<!-- /Page Content -->
@endsection
