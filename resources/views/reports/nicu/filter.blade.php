@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
		<li class="current"><a href="{{ action('Reports\NicuReportController@index') }}">NICU Report</a></li>       
	</ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing select-container-main">
	<div class="master-btn-layout">
    <div class="row select-option-container">
    {!! Form::open(['url' => action('Reports\NicuReportController@index'), 'id'=>'nicu-report']) !!}
    <div class="col-md-5 col-sm-6">
      <div class="form-group row">
        <div class="col-md-3 text-right label-control">
          {!! Form::label('StartDate','Start Date:') !!}
        </div>
        <div class="col-md-9 custom-input">
          {!! Form::text('StartDate',null,['class'=>'form-control datepicker input-fields-shadow input-width-xlarge','readonly']) !!}
        </div>
      </div>    
      <div class="form-group row">
        <div class="col-md-3 text-right label-control">
          {!! Form::label('Sex','Sex:') !!}
        </div>
        <div class="col-md-9 custom-input">
          {!! Form::select('Sex',[''=>'N/A','Male'=>'Male','Female'=>'Female','Indeterminate'=>'Indeterminate'],'',['class'=>'input-fields-shadow form-control input-width-xlarge']) !!}
        </div>
      </div>     
      <div class="form-group row">
        <div class="col-md-3 text-right label-control">
          {!! Form::label('TypeOfCare','Type Of Care:') !!}
        </div>
        <div class="col-md-9 custom-input">
          {!! Form::select('TypeOfCare',[''=>'N/A','Intensive Care'=>'Intensive Care','Special Care'=>'Special Care','Ward Admission'=>'Ward Admission'],'',['class'=>'form-control input-fields-shadow input-width-xlarge']) !!}
        </div>
      </div>  
      <div class="form-group row">
        <div class="col-md-3 text-right label-control">
          {!! Form::label('birth_status', 'Birth Status:') !!}
        </div>
        <div class="col-md-9 custom-input">
          {!! Form::select('birth_status', [''=>'Inborn & Outborn', 'Inborn'=>'Inborn', 'Outborn'=>'Outborn'], null, ['class'=>'form-control input-fields-shadow input-width-xlarge']) !!}
        </div>
      </div>                                                                                      
    </div>
    <div class="col-md-offset-1 col-md-5 col-sm-6">
      <div class="form-group row">
        <div class="col-md-3 text-right label-control">
          {!! Form::label('EndDate','End Date:') !!}
        </div>
        <div class="col-md-9 custom-input">
          {!! Form::text('EndDate',null,['class'=>'form-control input-fields-shadow input-width-xlarge datepicker','readonly']) !!}
        </div>
      </div>      
      <div class="form-group row">
        <div class="col-md-3 text-right label-control">
          {!! Form::label('SeenBy','Seen By:') !!}
        </div>
        <div class="col-md-9 custom-input">
          {!! Form::select('SeenBy',[''=>'N/A']+$doctors,'',['class'=>'form-control input-fields-shadow input-width-xlarge']) !!}
        </div>
      </div>  
      <div class="form-group row">
        <div class="col-md-3 text-right label-control">
          {!! Form::label('Status','Status:') !!}
        </div>
        <div class="col-md-9 custom-input">
          {!! Form::select('Status',[""=>"N/A","Inpatient" => "Inpatient","Discharged" => "Discharged","Discharge at Request" => "Discharge at Request","Discharge Against Medical Advice" => "Discharge Against Medical Advice","Transferred" => "Transferred","Died" => "Died","Died (OCNR)" => "Died (OCNR)"],"",['class'=>'input-fields-shadow form-control input-width-xlarge']) !!}
        </div>
      </div>   
      @if (count(\ValuelistHelpers::getHospitals()) > 1)
      <div class="form-group row">
        <div class="col-md-3 text-right label-control">
          {!! Form::label('hospital_name','Hospital Name:') !!}
        </div>
        <div class="col-md-9 custom-input">          
          {!! Form::select('hospital_name', \ValuelistHelpers::getHospitals(), null, ['class'=>'input-fields-shadow form-control input-width-xlarge']) !!}
        </div>
      </div>                                        
      @endif
    </div>
    <div class="col-md-12 select-container-main">
      <div class="col-md-2 col-sm-4 col-xs-6">
        <button type="submit" class="btn btn-primary save-button-shadow form-control btn-block"><i class="fa fa-filter"></i> <span>{!! $SubmitButtonText !!}</span></button>
      </div>

      <div class="col-md-2 col-sm-4 col-xs-6">
        <a href="javascript:void(0);" class="btn btn-default save-button-shadow form-control btn-block" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i><span>Clear</span></a> 	                          </div>
      </div>
      {!! Form::close() !!}
    </div>
    </div> <!-- /.col-md-12 -->
  </div> <!-- /.row -->
  <!-- /Page Content -->
  @endsection
