@extends('print')
@section('content')
<div class="temp-container cardiac-assessment">
  <div class="temp-row">
   <div class="col-md-12">
          <img src="{{ ValuelistHelpers::printPagelogo() }}" >
        </div>
   <div class="col-md-12 mt-10">
          <h3 class="print-head mt-0 temp">Neonatal Cardiac Assessment</h3>
        </div>
  <div class="col-md-12">
    <div class="content-block mt-must-0">
      <div class="section-set">   
        <div class="col-xs-12 col-sm-6 col-md-4 text">
          <div class="form-group">
            <span class="print-label">Name:</span>
            <span class="print-value">{!! $results->BabyName; !!}</span>
          </div>              
          <div class="form-group">
            <span class="print-label">DOB:</span>
            <span class="print-value"> {!! date("d-m-Y",strtotime($results->DOB)); !!}</span>
          </div>                
          <div class="form-group">
            <span class="print-label ">{{ Lang::get('home.mrn') }}:</span>
            <span class="print-value"> {!! $results->BMrNo; !!}</span>
          </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4 text">                       
          <div class="form-group">
            <span class="print-label">Gestation (wks):</span>
            <span class="print-value"> {!! $results->Gestation; !!}</span>
          </div>              
          <div class="form-group">
            <span class="print-label">Birth Weight(In Gms):</span>
            <span class="print-value"> {!! $results->BirthWeight; !!}</span>
          </div> 
          <div class="form-group">
            <span class="print-label">Date:</span>
            <span class="print-value"> {!! date("d-m-Y",strtotime($results->TestDate)); !!}</span>
          </div>
        </div> 
        <div class="col-xs-12 col-sm-6 col-md-4 text user-id">                                
          <div class="form-group">
            <span class="print-label">Sex:</span>
            <span class="print-value"> {!! $results->Sex; !!}</span>                            
          </div>    
          <div class="form-group">
            <span class="print-label">Age:</span>
            <span class="print-value"> <b>Y</b>{!! $results->age_year; !!} <b>M</b>{!! $results->age_month; !!} <b>D</b>{!! $results->age_days; !!}</span>
          </div>                                
        </div>          
        <div class="clearfix"></div>  <br>      
        <div class="col-xs-12 col-sm-12 col-md-12 clear">
          <div class="form-group custom-class">
              <h4>Echo Findings</h4>
              <div class="print-label-value">{!! $results->Findings; !!}</div>
          </div>
        </div>
        <div class="clearfix"></div>  <br>
        <div class="col-xs-12 col-sm-12 col-md-12 clear">  
          <div class="form-group custom-class">
              <h4>Impression</h4>
              <div class="print-label-value">{!! $results->Impression; !!}</div>
          </div>           
        </div>
        <div class="clearfix"></div> 
        <div class="col-xs-12 col-sm-12 col-md-12 custom-class">
          <br /><br />
           <h4 class="pull-right">Signature</h4>
          <br />
          <h5>Notes</h5>
          <p class="print-label-value">This is a screening echocardiography performed and reported by neonatologists before discharge from the hospital to pick up major congenital heart defects in asymptomatic babies. The baby may require repeat echocardiography and consultation from pediatric cardiologists if baby becomes symptomatic and/or clinically warranted.</p>
        </div>
        <div class="button-row button-height">
        </div>
      </div>
    </div>
  </div>
</div> 
@endsection
       


  
