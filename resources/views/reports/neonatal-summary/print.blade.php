@extends('print')
@section('content')
<div class="temp-container neonatal-summary">
	<div class="temp-row">
	    <div class="col-md-5">
	      <span class="pull-left">	
          @if(env('LOGO_TYPE') == true)
              <img src="{{ ValuelistHelpers::printPagelogo() }}">
          @else
             <img src="{{ ValuelistHelpers::printPagelogo() }}">
          @endif 
          </span>
	    </div>
	    <div class="clearfix"></div>
        <h5 class="text-center"><strong>{{ $headerContent['hospital_name'] }} PHONE : {{ $headerContent['hospital_contact'] }}</strong> </h5>
            <div class="class">
                <div id="company">
                    <div><span class="discharge-report"> CONSULTANTS</span></div>
                    {!! $headerContent['discharge_report_right'] !!}          
                </div>
              	<div id="project ">
                      <div><span class="discharge-report">CONSULTANTS</span></div>
                        {!! $headerContent['discharge_report_left'] !!}           
                 </div>
            </div>  
	     	    <div class="col-md-12">
				    <h3 class="print-head">NEONATAL SUMMARY </h3>
                    	<div class="col-md-11 neomargin">
                    	   <div class="pull-left">
	                    	  <div>
		                            <span class="print-label">Name of the Consultant:</span> 
		                            {{ $consultant }}
		                      </div>                        		
                           </div>
                           <div class="pull-right">
                               <div>
		                            <span class="print-label">Status:</span> 
		                            {{ $results->Status }}
	                           </div>	
                           </div>
                       </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <div class="col-md-11">
                       	 <div class="pull-right">
                       	 	<div>
                       	 		<span class="print-label">Date of Discharge:</span>
                       	 		 @if(date('Y',strtotime($results->DateOfDischarge)) > 1970)
				                   {{  date('d-m-Y',strtotime($results->DateOfDischarge)) }}
						         @else 
						           N/A   
						         @endif
                       	 	</div>
                       	 </div>
                    </div>	
                </div>
                <!-- new born record start-->    
				 <div class="content-block">
				 <h4> Newborn Record </h4>
                    <div class="col-print-2 summary-content">
	                    <div class="form-group">
	                        <div>
	                            <span class="print-label">{{ Lang::get('home.mrn') }}:</span> 
	                            <span class="print-value">{{ $results->BMrNo }}</span>
	                        </div>
	                     </div>        	 

                        <div class="form-group">
	                        <div>
	                            <span class="print-label">Name:</span> 
	                            <span class="print-value">{{ $results->BabyName }}</span>
	                        </div>   
	                    </div>          	 

                        <div class="form-group">
	                        <div>
	                            <span class="print-label">DOB:</span> 
	                            <span class="print-value">{{ date('d-m-Y',strtotime($results->DOB)) }}</span>
	                        </div>   
	                    </div>          	 

                        <div class="form-group">
	                        <div>
	                            <span class="print-label">Sex:</span> 
	                            <span class="print-value">{{ $results->Sex }}</span>
	                        </div>   
	                    </div>          	 

                        <div class="form-group">
	                        <div>
	                            <span class="print-label">Birth Weight:</span> 
	                            <span class="print-value">{{ $results->BirthWeight }}</span>
	                        </div>   
	                    </div>   

	                     <div class="form-group">
	                        <div>
	                            <span class="print-label">Discharge Weight:</span> 
	                            <span class="print-value">{{ $results->DischargeWeight }}</span>
	                        </div>   
	                    </div>                	 

                        <div class="form-group">
	                        <div>
	                            <span class="print-label">OFC in cm :</span> 
	                            <span class="print-value">{{ $results->OFC }}</span>
	                        </div>   
	                    </div>          	 
			          @php $results->TOB_TIME = (strlen($results->TOB_TIME)==1) ? '0'.$results->TOB_TIME :$results->TOB_TIME ;@endphp
			          @php $results->TOB_MINS = (strlen($results->TOB_MINS)==1) ? '0'.$results->TOB_MINS :$results->TOB_MINS ;@endphp
                        <div class="form-group">
	                        <div>
	                            <span class="print-label">Time of Birth:</span> 
	                            <span class="print-value">{{ $results->TOB_TIME.' : '.$results->TOB_MINS.' : '.$results->TOB_AM  }}</span>
	                        </div>   
	                    </div>          	 

                        <div class="form-group">
	                        <div>
	                            <span class="print-label">Gestation:</span> 
	                            <span class="print-value">{{ $Gestation }}</span>
	                        </div>   
	                    </div>          	 
                    </div>  

                     <div class="col-print-2 summary-content">
	                    <div class="form-group">
	                        <div>
	                            <span class="print-label">Mode of delivery:</span> 
	                            <span class="print-value">{{ $results->ModeOfDelivery}}</span>
	                        </div>
	                     </div>        	 

                        <div class="form-group">
	                        <div>
	                            <span class="print-label">Length in cm:</span> 
	                            <span class="print-value">{{ $results->Length }}</span>
	                        </div>   
	                    </div>          	  	 

                        <div class="form-group">
	                        <div>
	                            <span class="print-label">Birth Status:</span> 
	                            <span class="print-value">{{ $results->BirthStatus }}</span>
	                        </div>   
	                    </div>          	 

                        <div class="form-group">
	                        <div>
	                            <span class="print-label">Apgars 1 min:</span> 
	                            <span class="print-value">{{ $results->Apgars1min }}</span>
	                        </div>   
	                    </div>          	 

                        <div class="form-group">
	                        <div>
	                            <span class="print-label">Apgars 5 min:</span> 
	                            <span class="print-value">{{ $results->Apgars5min }}</span>
	                        </div>   
	                    </div>          	 

                  
                        <div class="form-group">
	                        <div>
	                            <span class="print-label">Apgars 10 min:</span> 
	                            <span class="print-value">{{ $results->Apgars10min }}</span>
	                        </div>   
	                    </div>          	 

                        <div class="form-group">
	                        <div>
	                            <span class="print-label">Mother's blood group:</span> 
	                            <span class="print-value">{{ $results->MotherBloodGroup }}</span>
	                        </div>   
	                    </div>   
	                     <div class="form-group">
	                        <div>
	                            <span class="print-label">Baby's Blood Group:</span> 
	                            <span class="print-value">{{ $results->BabyBloodGroup }}</span>
	                        </div>   
	                    </div>           	 
                    </div>    

				</div>
				<!-- new born record end -->    
           <div class="page-break"></div>

                <!-- maternal details  start-->
				<div class="content-block">
					<h4> Maternal details</h4> 
					<div class="col-print-2 summary-content">
	                        <div class="form-group">
		                        <div>
		                            <span class="print-label">HIV:</span> 
		                            <span class="print-value">{{ $results->HIV }}</span>
		                        </div>   
		                    </div> 
		                    <div class="form-group">
		                        <div>
		                            <span class="print-label">Hepatitis B:</span> 
		                            <span class="print-value">{{ $results->HepatitisB }}</span>
		                        </div>   
		                    </div> 
		                    <div class="form-group">
		                        <div>
		                            <span class="print-label">VDRL:</span> 
		                            <span class="print-value">{{ $results->VDRL }}</span>
		                        </div>   
		                    </div> 
		                  @if(count($medical_problems) > 0)  
		                    @php  $i=1; @endphp
				    		<div class="form-group">
				             	<div>
				             	   <table>
					             	 <tr>
					             	   <th>Medical Problems:</th></tr>
							            @foreach($medical_problems as $mp)
				                        <tr><td>{{ $i++.') '. $mp }}</td></tr>
							            @endforeach
							       </table>    
					            </div>		  
				            </div>  
				          @endif       
	                </div>  
	              
	                <div class="col-print-2 summary-content">
	                        <div class="form-group">
		                        <div>
		                            <span class="print-label">LMP:</span> 
		                            <span class="print-value">@if((date('Y',strtotime($results->LMP))) > 1980) {{ date('d-m-Y',strtotime($results->LMP)) }} @else N/A @endif</span>
		                        </div>   
		                    </div> 
		                    <div class="form-group">
		                        <div>
		                            <span class="print-label">EDD by USG:</span> 
		                            <span class="print-value">@if((date('Y',strtotime($results->EDDbyUSG))) > 1980) {{ date('d-m-Y',strtotime($results->EDDbyUSG)) }} @else N/A @endif</span>
		                        </div>   
		                    </div> 
		                    <div class="form-group">
		                        <div>
		                            <span class="print-label">Pregnancy complication:</span> 
		                            <span class="print-value">{{ $results->PregnancyComplications }}</span>
		                        </div>   
		                    </div>  
		                    @if($results->PregnancyComplications !='No' && count($peganancy_complications) > 0)
		                    @php  $i=1; @endphp
		                    <div class="form-group">
		                       <div>
		                    	<table> 
		                    	  <tr>
		                    	    <th> Complications : </th></tr>
				             		@foreach($peganancy_complications as $pc)
	                                <tr><td>{{ $i++.') '.$pc }}</td></tr>
				             		@endforeach
				                </table>		  
				               </div>		 		                    	
		                    </div>  
		                   @endif 	 
	                </div> 
			    </div>
			    <!-- maternal details  end -->
           <div class="page-break"></div>

                <!-- maternal details start -->
				<div class="content-block">
					<h4> Discharge details</h4> 
						<div class="col-print-2 summary-content">
		                    <div class="form-group">
		                        <div>
		                            <span class="print-label">Vitamin K:</span> 
		                            <span class="print-value">{{ $results->VitaminK }}</span>
		                        </div>
		                     </div>        	 

	                        <div class="form-group">
		                        <div>
		                            <span class="print-label">Does Vit K:</span> 
		                            <span class="print-value">{{ $results->DoseVitK }}</span>
		                        </div>   
		                    </div>          	 

	                        <div class="form-group">
		                        <div>
		                            <span class="print-label">Route vit K:</span> 
		                            <span class="print-value">{{ $results->RouteVitK }}</span>
		                        </div>   
		                    </div>          	 

	                        <div class="form-group">
		                        <div>
		                            <span class="print-label">Newborn screen:</span> 
		                            <span class="print-value">{{ $results->NewBornScreen }}</span>
		                        </div>   
		                    </div>          	 
	                              	 
	                    </div>  

	                    <div class="col-print-2 summary-content">
		                    <div class="form-group">
		                        <div>
		                            <span class="print-label">Newborn examination:</span> 
		                            <span class="print-value">{{ $results->NewBornExamination }}</span>
		                        </div>
		                     </div>        	 
                           @php  $i = 1; @endphp
                           @php $mas_vaccine = ValuelistHelpers::Vaccine('',true); @endphp
                         @if(count($vaccines)>0)
	                        <div class="form-group">
		                       <div>
		                    	<table> 
		                    	  <tr>
		                    	    <th> Vaccines : </th></tr>
				             		@foreach($vaccines as $vc)
				             		@if(isset($mas_vaccine[$vc['vaccineid']]))
		                                <tr>
		                                   <td>{{ $i++.') '.$mas_vaccine[$vc['vaccineid']] }}</td>
		                                   <td>{{ $vc['vaccinedate'] }}</td>
		                                </tr>
	                                @endif
				             		@endforeach

				                </table>		  
				               </div>		 		                    	
		                    </div>  	 
	                    @endif
          	 
	                    </div>  
			    </div>
			    <!-- maternal details end -->
           <div class="page-break"></div>

               <!-- discharge medications start -->
				<div class="content-block">
					<h4> Discharge medications</h4> 
					<div class="col-print-1">
		                <table>
			                 <thead>
			                 	<th> Brand Name </th>
                                <th> Generic Name </th>
                                <th> Formulation/Strength </th>
                                <th> Dose </th>
                                <th> Frequency </th>
                                <th> Duration </th>
			                 </thead>
		                     <tbody>

		                     @forelse($discharge_medications as $medications)  
		                     	<tr>
		                     	   <td>{{ $medications->Name }}</td>
		                     	   <td>{{ $medications->genericname }}</td>
		                     	   <td>{{ $medications->Value }}</td>
		                     	   <td>{{ $medications->Dose }}</td>
		                     	   <td>{{ $medications->Frequency }}</td>
		                     	   <td>{{ $medications->Duration }}</td>

		                     	</tr>	
		                     @empty 	 
		                      <tr class="text-center">
		                      	<td> Nil</td>
		                      	<td> Nil</td>
		                      	<td> Nil</td>
		                      	<td> Nil</td>
		                      	<td> Nil</td>
		                      	<td> Nil</td>

		                      </tr>
                             @endforelse
		                     </tbody>	                  
			                 	
			            </table>   
	                </div>  
			    </div>
			    <!-- discharge medications end -->
           <div class="page-break"></div>

 				<!-- Additional information start -->
				<div class="content-block">
					<h4> Additional information</h4> 
					<div class="col-print-1">
	                    <div class="text-justify m-ten">
	                   	 {{  $results->AdditionalInformation }}
	                   </div>     	 
	                </div>  
			    </div>
			    <!-- Additional information end -->
           <div class="page-break"></div>

            <div class="content-block">
				<div class="form-group">
			        <div>
			            <span class="print-label">Outpatient appoinment:</span> 
                         @if(date('Y',strtotime($results->OpAppointment)) > 1970)
				            <span class="print-value font-bold">
				              {{  date('d-m-Y',strtotime($results->OpAppointment)) }}
				               @php $ophours = (strlen($results->Outpatient_TIME) == 1 ) ? '0'.$results->Outpatient_TIME : $results->Outpatient_TIME; @endphp
				               @php $opmin = (strlen($results->Outpatient_MINS) == 1 ) ? '0'.$results->Outpatient_MINS : $results->Outpatient_MINS; @endphp
				               {{ $ophours.':'.$opmin.':'.$results->Outpatient_AM }}
				            </span>
				         @else    
                            N/A
				         @endif   
			        </div>   
		        </div>
		       
			</div>
			<div class="content-block">
				<div class="form-group">
					 <h4>Routine Instructions:</h4> 
					 <div>
						{!! $headerContent['discharge_instraction']  !!}
					 </div>
				</div>
			</div>

           <div class="page-break"></div>

              <div class="col-md-3 pull-left neofooterm">
               <a href="javascript:void(0);" onclick="window.print();" class="btn btn-primary form-control hidden-print">Print</a>
              </div>

		</div>
	</div>
</div>				


@endsection
