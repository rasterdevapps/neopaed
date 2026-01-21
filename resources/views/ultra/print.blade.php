@extends('print')
@section('content')
<div class="temp-container carnial-ultra">
	<div class="temp-row">
    <div class="col-md-12">
          <img src="{{ ValuelistHelpers::printPagelogo() }}" >
        </div>
    <div class="col-md-12 mt-10">
          <h3 class="print-head temp">Carnial Ultrasonography</h3>
    </div>
		<div class="col-md-12">
			  <div class="content-block mt-must-0 plr-must-0 carnial">
          <div class="section-set">
  				  <div class="col-xs-12 col-sm-6 col-md-4 carnial">                          
              <div class="form-group">
                  <span class="print-label">Name:</span>
                  <span class="print-value"> {!! $results->BabyName; !!}</span>
              </div>                            
              <div class="form-group">
                  <span class="print-label">DOB:</span>
                  <span class="print-value"> {!! date("d-m-Y",strtotime($results->DOB)); !!}</span>
              </div>                                     
              <div class="form-group">
                  <span class="print-label">{{ Lang::get('home.mrn') }}:</span>
                  <span class="print-value"> {!! $results->BMrNo; !!}</span>
              </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4 carnial">          
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
                  <span class="print-value"> {!! date("d-m-Y",strtotime($results->TestDate)); !!} </span>                           
              </div>
            </div>
            <div class="col-xs-12 col-sm-6 user-id col-md-4 carnial">                        
              <div class="form-group">
                  <span class="print-label">Sex:</span>
                  <span class="print-value"> {!! $results->Sex; !!}</span>                            
              </div>    
              <div class="form-group">
                  <span class="print-label">Age:</span>
                  <span class="print-value"> {!! $results->Age; !!}</span>
              </div>
              <div class="form-group">
                  <span class="print-label">Birth Status:</span>
                  <span class="print-value"> {!! $results->BirthStatus; !!}</span>
              </div>                                                             
            </div>

				    <div class="col-xs-12 col-sm-12 col-md-12 clear">
              <div class="form-group">
    	            <h4>Indication</h4>
                  <div class="print-label-value">{!! $results->Indication; !!}</div>
              </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 clear">
                <h4>USG Findings Rt Side</h4>
                <div class="form-group">
                  <div class="print-label-value">{!! $results->UsgRt; !!}</div>
                </div> 
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 clear">
                <h4>USG Findings Lt Side</h4>
                <div class="form-group">
                  <div class="print-label-value">{!! $results->UsgLt; !!}</div>
                </div> 
            </div>
            
            <div class="col-xs-12 col-sm-12 col-md-12 clear">
                <h4>USG Findings General</h4>
                <div class="form-group">
                    <div class="print-label-value">{!! $results->UsgGeneral; !!}</div>
                </div> 
            </div>  

            <div class="col-xs-12 col-sm-12 col-md-12 clear">
                <h4>Impression</h4>
                <div class="form-group">
                    <div class="print-label-value">{!! $results->Impression; !!}</div>
                </div> 
            </div>
			   	</div>
          <div class="col-xs-12 col-sm-12 col-md-11">
                <br /><br />
               <h4 class="pull-right">Signature</h4> 
          </div>            
        </div>       
  <!-- <div class="button-row"> -->
      

 <!--  </div> -->
   </div>
  </div>
</div>
@endsection
