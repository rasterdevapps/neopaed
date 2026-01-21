@extends('print')
@section('content')
<div class="temp-container lab-request">
	<div class="temp-row">
	   <div class="col-md-11">
	        <img src="{{ ValuelistHelpers::printPagelogo() }}">
	  </div>
	  <div class="col-md-11">
	  	<h3 class="print-head temp">Lab Request</h3>

	  	<div class="content-block">
           <div class="section-set"> 
           	    <div class="col-md-11 plr-must-0">
 		            <div class="col-xs-12 col-sm-4 col-md-4">
		             	<div class="form-group">
				            <span class="print-label">Name:</span>
				            <span class="print-value">{!! $baby->BabyName; !!}</span>
				        </div>  
				        <div class="form-group">
				            <span class="print-label">DOB:</span>
				            <span class="print-value">{!! date('d-m-Y',strtotime($baby->DOB)); !!} </span>
				        </div> 
				        <div class="form-group">
				            <span class="print-label">{{ Lang::get('home.mrn') }}:</span>
				            <span class="print-value">{!! $baby->BMrNo; !!}</span>
				        </div> 
		             </div> 
		             <div class="col-xs-12 col-sm-4 col-md-4">
		             	<div class="form-group">
				            <span class="print-label">Gestation:</span>
				            <span class="print-value">{!! $baby->Gestation; !!}</span>
				        </div>
				        <div class="form-group">
				            <span class="print-label">TOB:</span>
				            <span class="print-value">{!! $baby->TOB_TIME.':'.$baby->TOB_MINS.' '.$baby->TOB_AM  !!}</span>
				        </div> 
				        <div class="form-group">
				            <span class="print-label">Collection Site:</span>
				            <span class="print-value">{!! isset($collection_sites[$results->collection_site]) ? $collection_sites[$results->collection_site] : ''; !!}</span>
				        </div>  
		             </div>  
		             <div class="col-xs-12 col-sm-4 col-md-4">
		             	<div class="form-group">
				            <span class="print-label">Sex:</span>
				            <span class="print-value">{!! $baby->Sex; !!}</span>
				        </div>
				        <div class="form-group">
				            <span class="print-label">Birth Weight:</span>
				            <span class="print-value">{!! $baby->BirthWeight; !!}</span>
				        </div> 


				        <div class="form-group">
				        	<span class="print-label">Collection Method</span>
				        	<span class="print-value">{!! isset($collection_method[$results->collection_method]) ? $collection_method[$results->collection_method] : ''; !!}</span>
				        </div> 
		             </div>
	            </div>
	             <div class="col-md-11">
	            	<div class="form-group">
				       <b>Diagnosis:</b>
				       <br/>
                       @if(!is_null($results->diagnosis))
				       @foreach($results->diagnosis as $diagnosis)
				        @if(isset($diagnosis_master[$diagnosis])) 
						  {!! $diagnosis_master[$diagnosis] !!} <br/>
				        @endif
				       @endforeach
				       @endif
				    </div>
	            </div>
	            <div class="col-md-11">
	            	<div class="form-group">
				       <b>Investigations:</b>
				       <br/>
                       @if(!is_null($results->investigations))
				       @foreach($results->investigations as $investigations)
				        @if(isset($master_investigations[$investigations])) 
						  {!! $master_investigations[$investigations] !!} <br/>
				        @endif
				       @endforeach
				       @endif
				    </div>
	            </div>
             	
             </div>       	

           </div>
           
	    </div>
	</div>
</div>	  
@endsection
