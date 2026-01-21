@extends('print')
@section('content')
@php $browser = strpos($_SERVER['HTTP_USER_AGENT'],'Firefox') @endphp

<style type="text/css">
  @media print {
    html, body, div, .container{
      width: 1024px !important;
    }
  }  
</style>
<div class="print table-view annual-report-print">
    <div class="temp-row">
          <!-- first page -->
        	<div class="col-md-12 col-sm-12 col-xs-12 print-width">
            	<div class="header-text-content text-center">
	                   <h3 class="print-head">NEONATAL UNIT REPORT</h3>
	                   <h4 class="print-head">({!! $headStartdate  !!} to {!! $headEnddate !!})</h4>
                </div> 
        	</div>

          <!-- <div class="col-md-12 col-sm-12 col-xs-12" style="@if( $browser >0)height:50em ; @else height:80em ;  @endif "></div>
        	<div class="col-md-12 col-sm-12 col-xs-12" style="@if( $browser >0)height:50em ; @else height:92em ;  @endif "></div> -->
          <div class="col-md-12 col-sm-12 col-xs-12" style="@if( $browser >0)height:50em ; @else height:110em ;  @endif "></div>

        	<div class="col-md-12 col-sm-6 col-xs-12">
             <img src="{{ ValuelistHelpers::printPagelogo() }}">
          </div>

          <div class=" col-md-12 col-sm-12 col-xs-12 annual-report-content">
               <span><i>Prepared by</i> </span> <br/>
			          <span>{{ $presentedBy }}</span>    
          </div>

          <!--  End first page -->


          <!-- abbreviations page start -->

          <div class="col-md-6 col-sm-6 col-xs-12  annual-page-break-confirm " style="align:left">
                <h4><u style="align:center">ABBREVIATIONS</u></h4>
          <div class="format-content annualreports-abbreviations center"> 
                  
                <div class="form-group">               
                  <span class="print-label">  {{ Lang::get('annualreports.art') }}</span>
                  <span class="print-value">  {{ Lang::get('annualreports.art_def') }}</span>
                  </div>                 
                  <div class="form-group"> 
                  <div>               
                <span class="print-label">{{ Lang::get('annualreports.cons') }}</span>
                  <span class="print-value"> {{ Lang::get('annualreports.cons_def') }}</span>
                </div>
                </div>
                <div class="form-group">
                <div>
                <span class="print-label">{{ Lang::get('annualreports.cpap') }}</span>
                <span class="print-value">{{ Lang::get('annualreports.cpap_def') }}</span>
              </div>
              </div>
               <div class="form-group">
               <div>
                    <span class="print-label">{{ Lang::get('annualreports.ct') }}</span>
                   <span class="print-value">{{ Lang::get('annualreports.ct_def') }}</span>
               </div>
               </div>
               <div class="form-group">
               <div>
                    <span class="print-label">{{ Lang::get('annualreports.ecg') }}</span>
                    <span class="print-value">{{ Lang::get('annualreports.ecg_def') }}</span>
              </div>
              </div>
              <div class="form-group">
              <div>
                  <span class="print-label">{{ Lang::get('annualreports.eeg') }}</span>
                  <span class="print-value"> {{ Lang::get('annualreports.eeg_def') }}</span>
               </div>
              </div>
              <div class="form-group">
              <div>
               <span class="print-label">{{ Lang::get('annualreports.hhhfnc') }}</span>
               <span class="print-value">{{ Lang::get('annualreports.hhhfnc_def') }}</span>
              </div>
              </div>
              <div class="form-group">
              <div>
              <span class="print-label">{{ Lang::get('annualreports.hmd') }}</span>
              <span class="print-value">{{ Lang::get('annualreports.hmd_def') }}</span>
               </div>
               </div>
               <div class="form-group">
              <div>
                   <span class="print-label">{{ Lang::get('annualreports.icsi') }}</span>
                   <span class="print-value">{{ Lang::get('annualreports.icsi_def') }}</span>
               </div>
               </div>
               <div class="form-group">
              <div>
                   <span class="print-label">{{ Lang::get('annualreports.iui') }}</span>
                   <span class="print-value">{{ Lang::get('annualreports.iui_def') }}</span>
               </div>
               </div>
               <div class="form-group">
              <div>
                    <span class="print-label">{{ Lang::get('annualreports.ivf') }}</span>
                    <span class="print-value">{{ Lang::get('annualreports.ivf_def') }}</span>
               </div>
               </div>
               <div class="form-group">
              <div>
                   <span class="print-label">{{ Lang::get('annualreports.lscs') }}</span>
                   <span class="print-value">{{ Lang::get('annualreports.lscs_def') }}</span>
              </div>
              </div>
              <div class="form-group">
              <div>
                   <span class="print-label">{{ Lang::get('annualreports.mri') }}</span>
                   <span class="print-value">{{ Lang::get('annualreports.mri_def') }}</span>
                </div>
                </div>
                <div class="form-group">
              <div>
                   <span class="print-label">{{ Lang::get('annualreports.mrsa') }}</span>
                   <span class="print-value">{{ Lang::get('annualreports.mrsa_def') }}</span>
                </div>
                </div>
                <div class="form-group">
              <div>
                    <span class="print-label">{{ Lang::get('annualreports.nec') }}</span>
                    <span class="print-value">{{ Lang::get('annualreports.nec_def') }}</span>
                </div>
                </div>
                <div class="form-group">
              <div>
                    <span class="print-label">{{ Lang::get('annualreports.nicu') }}</span>
                    <span class="print-value">{{ Lang::get('annualreports.nicu_def') }}</span>
                </div>
                </div>
                <div class="form-group">
              <div>
                    <span class="print-label">{{ Lang::get('annualreports.nippv') }}</span>
                    <span class="print-value">{{ Lang::get('annualreports.nippv_def') }}</span>
                 </div>
                 </div>
                 <div class="form-group">
              <div>
                   <span class="print-label">{{ Lang::get('annualreports.ocnr') }}</span>
                   <span class="print-value">{{ Lang::get('annualreports.ocnr_def') }}</span>
                </div>
                </div>
                <div class="form-group">
              <div>
                   <span class="print-label">{{ Lang::get('annualreports.op') }}</span>
                   <span class="print-value">{{ Lang::get('annualreports.op_def') }}</span>
               </div>
               </div>
               <div class="form-group">
              <div>
                    <span class="print-label">{{ Lang::get('annualreports.pda') }}</span>
                    <span class="print-value">{{ Lang::get('annualreports.pda_def') }}</span>
               </div>
               </div>
               <div class="form-group">
              <div>
                   <span class="print-label">{{ Lang::get('annualreports.picc') }}</span>
                   <span class="print-value">{{ Lang::get('annualreports.picc_def') }}</span>
               </div>
               </div>
               <div class="form-group">
              <div>
                   <span class="print-label">{{ Lang::get('annualreports.pphn') }}</span>
                   <span class="print-value">{{ Lang::get('annualreports.pphn_def') }}</span>
               </div>
               </div>
               <div class="form-group">
              <div>
                   <span class="print-label">{{ Lang::get('annualreports.prbc') }}</span>
                   <span class="print-value">{{ Lang::get('annualreports.prbc_def') }}</span>
               </div>
               </div>
               <div class="form-group">
              <div>
                   <span class="print-label">{{ Lang::get('annualreports.rop') }}</span>
                   <span class="print-value">{{ Lang::get('annualreports.rop_def') }}</span>
               </div>
               </div> 
               <div class="form-group">
              <div>
                   <span class="print-label">{{ Lang::get('annualreports.simv') }}</span>
                   <span class="print-value">{{ Lang::get('annualreports.simv_def') }}</span>
               </div>
               </div>
               <div class="form-group">
              <div>
                   <span class="print-label">{{ Lang::get('annualreports.tpn') }}</span>
                   <span class="print-value">{{ Lang::get('annualreports.tpn_def') }}</span>
               </div> 
                </div> 
                <div class="form-group">
              <div>
                   <span class="print-label">{{ Lang::get('annualreports.uac') }}</span>
                   <span class="print-value">{{ Lang::get('annualreports.uac_def') }}</span>
               </div>
               </div>
               <div class="form-group">
              <div>
                   <span class="print-label">{{ Lang::get('annualreports.uvc') }}</span>
                   <span class="print-value">{{ Lang::get('annualreports.uvc_def') }}</span>
               </div>
               </div>
               <div class="form-group">
              <div>
                   <span class="print-label">{{ Lang::get('annualreports.vd') }}</span>
                   <span class="print-value">{{ Lang::get('annualreports.vd_def') }}</span>
               </div>
               
            </div>    
            </div>
          </div>
          <!-- End abbreviations page start -->

          <!-- TABLES index page -->

            <div class="col-xs-12 col-sm-12 col-md-12 annual-page-break-confirm annual-report-content">
              <h4><u>CONTENTS – LIST OF TABLES</u></h4>
                <table class="index-table ">
                    <tr>
                      <td><a class="table-index" data-id = "table-list-1">Table 1:</a>Total Live Births</td>
                     
                    </tr>
                    <tr>
                      <td><a class="table-index" data-id = "table-list-2">Table 2:</a> Sex Distribution</td>
                    </tr>
                    <tr>
                      <td><a class="table-index" data-id = "table-list-3">Table 3:</a> Mode Of Conception   </td>
                    </tr> 
                    <tr>
                      <td><a class="table-index" data-id = "table-list-4">Table 4:</a> Mode Of Delivery  </td>
                    </tr>
                    <tr>
                      <td><a class="table-index" data-id = "table-list-5">Table 5:</a> Gestation At Birth   </td>
                    </tr>
                    <tr>
                      <td><a class="table-index" data-id = "table-list-6">Table 6:</a> Birth Weight Distribution  </td>
                    </tr>
                    <tr>
                      <td><a class="table-index" data-id = "table-list-7">Table 7:</a> NICU Admissions  </td>
                    </tr>
                    <tr>
                      <td><a class="table-index" data-id = "table-list-8">Table 8:</a> NICU Admissions Category  </td>
                    </tr>
                    <tr>
                      <td><a class="table-index" data-id = "table-list-9">Table 9:</a> Patient-Days Of NICU Admissions  </td>
                    </tr>
                    <tr>
                      <td><a class="table-index" data-id = "table-list-10">Table 10:</a> Admissions By Gestation  </td>
                    </tr>
                    <tr>
                      <td><a class="table-index" data-id = "table-list-11">Table 11:</a> Admissions By Birth Weight  </td>
                    </tr>
                    <tr>
                      <td><a class="table-index" data-id = "table-list-12">Table 12:</a> Chronic Lung Disease  </td>
                    </tr>
                    <tr>
                      <td><a class="table-index" data-id = "table-list-13">Table 13:</a> Types Of Respiratory Therapy  </td>
                    </tr>
                    <tr>
                      <td><a class="table-index" data-id = "table-list-14">Table 14:</a> Indications For Surfactant Therapy  </td>
                    </tr>
                    <tr>
                      <td><a class="table-index" data-id = "table-list-15">Table 15:</a> Cardiovascular Morbidites  </td>
                    </tr>
                    <tr>
                      <td><a class="table-index" data-id = "table-list-16">Table 16:</a> Gastrointestinal Morbidity  </td>
                    </tr>
                    <tr>
                      <td><a class="table-index" data-id = "table-list-17">Table 17:</a> Retinopathy Of Prematurity  </td>
                    </tr>
                    <tr>
                      <td><a class="table-index" data-id = "table-list-18">Table 18:</a> Sepsis Organisms In Blood  </td>
                    </tr>
                    <tr>
                      <td><a class="table-index" data-id = "table-list-19">Table 19:</a> Survival To Discharge By Gestation  </td>
                    </tr>
                    <tr>
                      <td><a class="table-index" data-id = "table-list-20">Table 20:</a> Survival To Discharge By Birth Weight  </td>
                    </tr>
                    <tr>
                      <td><a class="table-index" data-id = "table-list-21">Table 21:</a> Characteristics Of Babies Who Died  </td>
                    </tr>
                    <tr>
                      <td><a class="table-index" data-id = "table-list-22">Table 22:</a> Procedures Performed  </td>
                    </tr>
                    <tr>
                      <td><a class="table-index" data-id = "table-list-23">Table 23:</a> Outside Referrals By Gestation  </td>
                    </tr>






                   
                </table>
            </div>
           <!--  End TABLES index page  -->
            <!-- FIGURES index page  -->
            <div class="col-md-12 col-sm-12 col-xs-12 annual-page-break-confirm annual-report-content">
                <table class="index-table ">
                   <h4><u>CONTENTS – LIST OF FIGURES</u></h4>
                       <tr><td><a class="table-index" data-id = "figure-list-1">Figure 1:  </a> Total Live Births </td></tr>  
                       <tr><td><a class="table-index" data-id = "figure-list-2">Figure 2:  </a> Sex Distribution  </td></tr>
                       <tr><td><a class="table-index" data-id = "figure-list-3">Figure 3:  </a> Mode Of Conception</td></tr> 
                       <tr><td><a class="table-index" data-id = "figure-list-4">Figure 4:  </a> Mode Of Delivery</td></tr> 
                       <tr><td><a class="table-index" data-id = "figure-list-5">Figure 5:  </a> Gestation At Birth </td></tr> 
                       <tr><td><a class="table-index" data-id = "figure-list-6">Figure 6:  </a> Birth Weight Distribution</td></tr>
                       <tr><td><a class="table-index" data-id = "figure-list-7">Figure 7:  </a> NICU Admissions</td></tr>
                       <tr><td><a class="table-index" data-id = "figure-list-8">Figure 8:  </a> NICU Admissions Category</td></tr>
                       <tr><td><a class="table-index" data-id = "figure-list-9">Figure 9:  </a> Patient-Days Of NICU Admissions</td></tr>
                       <tr><td><a class="table-index" data-id = "figure-list-10">Figure 10: </a>  Admissions By Gestation</td></tr>
                       <tr><td><a class="table-index" data-id = "figure-list-11">Figure 11: </a>  Admissions By Birth Weight</td></tr>
                       <tr><td><a class="table-index" data-id = "figure-list-12">Figure 12: </a>  Chronic Lung Disease</td></tr>
                       <tr><td><a class="table-index" data-id = "figure-list-13">Figure 13: </a>  Types Of Respiratory Therapy</td></tr>
                       <tr><td><a class="table-index" data-id = "figure-list-14">Figure 14: </a>  Indications For Surfactant Therapy</td></tr>
                       <tr><td><a class="table-index" data-id = "figure-list-15">Figure 15: </a>  Survival To Discharge By Gestation</td></tr>
                       <tr><td><a class="table-index" data-id = "figure-list-16">Figure 16: </a>  Survival To Discharge By Birth Weight</td></tr>
                       <tr><td><a class="table-index" data-id = "figure-list-17">Figure 17: </a>  Outside Referrals By Gestation</td></tr>


                     
                </table>
            </div>
            <!--  End FIGURES index page  -->

             <!--  Start In born babies count -->
            <div class="col-md-12 col-sm-12 col-xs-12 page-break-page table-list-1 annual-report-content">
                    <h4><u>Table 1: Total Live Births {!! Lang::get('annualreports.report_titles_inborn') !!}</u></h4>
                <div class="block-table overflow-auto">    
                    <table class="annual-report-table-common">
                        <thead>
                          <tr>
                              <th>Month</th>
                              <th>Singleton</th>
                              <th>Twins</th>
                              <th>Triplets</th>
                              <th>Quadruplets</th>
                              <th>Quintuplets</th>
                              <th>Sextuplets</th>
                              <th>Septuplets</th>  
                              <th>Octuplets</th>
                              <th>Total</th>
                           </tr>    
                        </thead>
                        <tbody>
                        @foreach($mpType as $key => $value) 
                          @if($value['Total'] != 0)  
                           <tr>
                               <td>{{ $key }}</td>
                               <td>{{ $value['singleTone'] }}</td>
                               <td>{{ $value['Twins'] }}</td>
                               <td>{{ $value['TripLets'] }}</td>
                               <td>{{ $value['QuadrupLets'] }}</td>
                               <td>{{ $value['QuintupLets'] }}</td>
                               <td>{{ $value['SextupLets'] }}</td>
                               <td>{{ $value['SeptupLets'] }}</td>
                               <td>{{ $value['OctupLets'] }}</td>
                               <td>{{ $value['Total'] }}</td>
                           </tr>  
                          @endif  
                         @endforeach   
                            
                        </tbody>
                    </table>

                </div>
            </div>
             <!--  End In born babies count -->

             <!--  Start In born babies chart -->
             <div class="col-md-12 col-sm-12 col-xs-12 page-break-page annual-report-graph figure-list-1">
               <h4><u>Figure 1: Total Live Births {!! Lang::get('annualreports.report_titles_inborn') !!}</u></h4>
                 <div id="inborn-baby-compare-charts" class="charts-width-height">  
                 </div>
             </div>
              <!--  End In born babies chart -->

             <!--  Start In born Sex distribution count -->
            <div class="col-md-12 col-sm-12 col-xs-12 page-break-page table-list-2 annual-report-content">
                    <h4><u>Table 2: Sex Distribution {!! Lang::get('annualreports.report_titles_inborn') !!}</u></h4>
                <div class="block-table">    
                    <table class="annual-report-table-common">
                        <thead>
                          <tr>
                              <th>Month</th>
                              <th>Male</th>
                              <th>Female</th>
                              <th>Indeterminate</th>
  
                           </tr>    
                        </thead>
                        <tbody>
                        @foreach($sexDistribution as $key => $value)   
                         @if(($value['Male'] != 0) || ($value['Female'] !=0) || ($value['Indeterminate'] !=0))
                           <tr>
                               <td>{{ $key }}</td>
                               <td>{{ $sexDistributioncount[$key]['Male'] }} ({{ $value['Male'] }} %)</td>
                               <td>{{ $sexDistributioncount[$key]['Female'] }} ({{ $value['Female'] }} %)</td>
                               <td>{{ $sexDistributioncount[$key]['Indeterminate'] }} ({{ $value['Indeterminate'] }} %)</td>
                           </tr> 
                          @endif
                        @endforeach   
                        </tbody>
                    </table>

                </div>
            </div>
             <!--  End In born Sex distribution count -->

             <!--  Start In born Sex distribution chart -->
             <div class="col-md-12 col-sm-12 col-xs-12 page-break-page annual-report-graph figure-list-2">
               <h4><u>Figure 2: Sex Distribution {!! Lang::get('annualreports.report_titles_inborn') !!}</u></h4>
              
                <div id="sex-distribution-charts" class="charts-width-height">
                  
                </div>
                
            </div>
             <!--  end In born Sex distribution chart -->

             <!--  start In born Mode of conception count -->
              <div class="col-md-12  col-sm-12 col-xs-12 page-break-page annual-page-break-confirm annual-report-content table-list-3">
                    <h4><u>Table 3: Mode Of Conception {!! Lang::get('annualreports.report_titles_inborn') !!}</u></h4>
                <div class="block-table overflow-auto">    
                    <table class="annual-report-table-common">
                        <thead>
                          <tr>
                              <th>Month</th>
                              <th>Spontaneous</th>
                              <th>Medical ART</th>
                              <th>ART</th>
                              <th>IVF</th>
                              <th>ICSI</th>
  
                           </tr>    
                        </thead>
                        <tbody>
                        @foreach($inbornConception as $key => $value)   
                           <tr>
                               <td>{{ $key }}</td>
                               <td>{{ $inbornConceptioncount[$key]['spontaneous'] }} ({{ $value['spontaneous'] }} %)</td>
                               <td>{{ $inbornConceptioncount[$key]['medicalArt'] }} ({{ $value['medicalArt'] }} %)</td>
                               <td>{{ $inbornConceptioncount[$key]['art'] }} ({{ $value['art'] }} %)</td>
                               <td>{{ $inbornConceptioncount[$key]['IVF'] }} ({{ $value['IVF'] }} %)</td>
                               <td>{{ $inbornConceptioncount[$key]['ICSI'] }} ({{ $value['ICSI'] }} %)</td>
                           </tr> 
                        @endforeach   
                        </tbody>
                    </table>

                </div>
            </div>
            <!--  end In born Mode of conception count -->

             <!--  start In born Mode of conception chart -->

             <div class="col-md-12 col-sm-12 col-xs-12 page-break-page annual-report-graph figure-list-3">
               <h4><u>Figure 3: Mode Of Conception {!! Lang::get('annualreports.report_titles_inborn') !!}</u></h4>
              
                <div id="mode-conception-charts" class="charts-width-height">
                  
                </div>
                
            </div>

             <!--  end In born Mode of conception chart -->

           

             <!--  start In born Mode of delivery count -->

            <div class="col-md-12 col-sm-12 col-xs-12 page-break-page  annual-report-content table-list-4">
                    <h4><u>Table 4: Mode Of Delivery {!! Lang::get('annualreports.report_titles_inborn') !!}</u></h4>
                <div class="block-table overflow-auto">    
                    <table class="annual-report-table-common">
                        <thead>
                          <tr>
                              <th>Month</th>
                              <th>Vaginal</th>                           
                              <th>Caesarian Section</th>
                              <th>Instrumental(forceps + ventouse)</th>
  
                           </tr>    
                        </thead>
                        <tbody>
                        @foreach($modeofDelivery as $key => $value)   
                           <tr>
                               <td>{{ $key }}</td>
                               <td>{{ $modeofDeliverycount[$key]['Vaginal'] }} ({{ $value['Vaginal'] }} %)</td>
                             
                               <td>{{ $modeofDeliverycount[$key]['Caesarian_section'] }}  ({{ $value['Caesarian_section']  }} %)</td>
                        
                               <td>{{ $modeofDeliverycount[$key]['Instrumental'] }} ({{ $value['Instrumental'] }} %)</td>
                           </tr> 
                        @endforeach   
                        </tbody>
                    </table>

                </div>
            </div>

                          <!--  end In born Mode of delivery count -->

               <!--  start In born Mode of delivery chart -->

             <div class="col-md-12 col-sm-12 col-xs-12 page-break-page  annual-report-graph figure-list-4">
               <h4><u>Figure 4: Mode Of Delivery {!! Lang::get('annualreports.report_titles_inborn') !!}</u></h4>
              
                <div id="mode-delivery-charts" class="charts-width-height">
                  
                </div>
                
            </div>
               <!--  end In born Mode of delivery chart -->

            <!--  start In born gestation count -->

            <div class="col-md-12 col-sm-12 col-xs-12 page-break-page annual-report-content anual-page-break-confirm table-list-5">
                    <h4><u>Table 5: Gestation At Birth {!! Lang::get('annualreports.report_titles_inborn') !!}</u></h4>
                <div class="block-table overflow-auto">    
                    <table class="annual-report-table-common">
                        <thead>
                          <tr>
                              <th>Month</th>
                              <th>< 28</th>
                              <th>28 – 30</th>
                              <th>31 - 32</th>
                              <th>33 - 36</th>
                              <th>37 - 38</th>
                              <th>39 - 40</th>
                              <th>41 - 42</th>
                              <th> > 42</th>

  
                           </tr>    
                        </thead>
                        <tbody>
                        @foreach($inbornGestation as $key => $value)   
                           <tr>
                               <td>{{ $key }}</td>
                               <td>{{ $inbornGestationcount[$key]["greater28"] }} ({{ $value['greater28'] }} %)</td>
                               <td>{{ $inbornGestationcount[$key]['28–30'] }} ({{ $value['28–30'] }} %)</td>
                               <td>{{ $inbornGestationcount[$key]['31-32'] }} ({{ $value['31-32'] }} %)</td>
                               <td>{{ $inbornGestationcount[$key]['33-36'] }} ({{ $value['33-36'] }} %)</td>
                               <td>{{ $inbornGestationcount[$key]['37-38'] }} ({{ $value['37-38'] }} %)</td>
                               <td>{{ $inbornGestationcount[$key]['39-40'] }} ({{ $value['39-40'] }} %)</td>
                               <td>{{ $inbornGestationcount[$key]['41-42'] }} ({{ $value['41-42'] }} %)</td>
                               <td>{{ $inbornGestationcount[$key]['less42'] }} ({{ $value['less42'] }} %)</td>

                           </tr> 
                        @endforeach   
                        </tbody>
                    </table>

                </div>
            </div>

               <!--  end In born gestation count -->

               <!--  start In born gestation chart -->

             <div class="col-md-12 col-sm-12 col-xs-12 page-break-page annual-page-break-confirm annual-report-graph figure-list-5">
               <h4><u>Figure 5: Gestation At Birth {!! Lang::get('annualreports.report_titles_inborn') !!}</u></h4>
              
                <div id="inborn-gestation-charts" class="charts-width-height">
                  
                </div>
                
            </div>
               <!--  end In born gestation chart -->

             <!--  start In born Birth weight count -->

            <div class="col-md-12 col-sm-12 col-xs-12 page-break-page annual-report-content table-list-6">
                    <h4><u>Table 6: Birth Weight Distribution {!! Lang::get('annualreports.report_titles_inborn') !!}</u></h4>
                <div class="block-table overflow-auto">    
                    <table class="annual-report-table-common">
                        <thead>
                          <tr>
                              <th>Month</th>
                              <th> < 1000</th>
                              <th>1001 – 1500</th>
                              <th>1501 - 2000</th>
                              <th>2001 - 2500</th>
                              <th>2501 - 3000</th>
                              <th>3001 - 3500</th>
                              <th>3501 - 4000</th>
                              <th> ≥ 4001</th>

  
                           </tr>    
                        </thead>
                        <tbody>
                        @foreach($inbornbirthWeight as $key => $value)   
                           <tr>
                               <td>{{ $key }}</td>
                               <td>{{ $inbornbirthWeightcount[$key]["0000-1000"] }} ({{ $value['0000-1000'] }} %)</td>
                               <td>{{ $inbornbirthWeightcount[$key]['1000-1499'] }} ({{ $value['1000-1499'] }} %)</td>
                               <td>{{ $inbornbirthWeightcount[$key]['1500-1999'] }} ({{ $value['1500-1999'] }} %)</td>
                               <td>{{ $inbornbirthWeightcount[$key]['2000-2499'] }} ({{ $value['2000-2499'] }} %)</td>
                               <td>{{ $inbornbirthWeightcount[$key]['2500-2999'] }} ({{ $value['2500-2999'] }} %)</td>
                               <td>{{ $inbornbirthWeightcount[$key]['3000-3499'] }} ({{ $value['3000-3499'] }} %)</td>
                               <td>{{ $inbornbirthWeightcount[$key]['3500-3999'] }} ({{ $value['3500-3999'] }} %)</td>
                               <td> {{ $inbornbirthWeightcount[$key]['4000-9999'] }}     ({{ $value['4000-9999'] }} %)</td>

                           </tr> 
                        @endforeach   
                        </tbody>
                    </table>

                </div>
            </div>

               <!--  end In born Birth weight count -->

               <!--  start In born Birth weight chart -->

             <div class="col-md-12 col-sm-12 col-xs-12 page-break-page annual-report-graph figure-list-6">
               <h4><u>Figure 6: Birth Weight Distribution {!! Lang::get('annualreports.report_titles_inborn') !!}</u></h4>
              
                <div id="inborn-birthweight-charts" class="charts-width-height">
                  
                </div>
                
            </div>
               <!--  end In born Birth weight chart -->   

              <!--  start In  NICU admissions inborn out born count -->


            <div class="col-md-12 col-sm-12 col-xs-12  page-break-page annual-report-content anual-page-break-confirm table-list-7">
                    <h4><u>Table 7: NICU Admissions {!! Lang::get('annualreports.report_titles_inborn_outborn') !!}</u></h4>
                <div class="block-table">    
                    <table class="annual-report-table-common">
                        <thead>
                          <tr>
                              <th>Month</th>
                              <th>Inborn</th>
                              <th>Outborn</th>
                              <th>Total</th>
                             

  
                           </tr>    
                        </thead>
                        <tbody>
                        @foreach($outborninbornNicuadmission as $key => $value)   
                           <tr>
                               <td>{{ $key }}</td>
                               <td>{{ $outborninbornNicuadmissioncount[$key]["Inborn"] }} ({{ $value['Inborn'] }} %)</td>
                               <td>{{ $outborninbornNicuadmissioncount[$key]['Outborn'] }} ({{ $value['Outborn'] }} %)</td>
                               <td>{{ $outborninbornNicuadmissioncount[$key]['Inborn'] + $outborninbornNicuadmissioncount[$key]['Outborn']  }} ({{ $value['Inborn']+$value['Outborn'] }} %)</td>
                           </tr> 
                        @endforeach   
                        </tbody>
                    </table>

                </div>
            </div>

               <!--  end NICU admissions inborn out born count -->

               <!--  start NICU admissions inborn out born chart -->

             <div class="col-md-12 col-sm-12 col-xs-12 page-break-page annual-page-break-confirm annual-report-graph figure-list-7">
               <h4><u>Figure 7: NICU Admissions {!! Lang::get('annualreports.report_titles_inborn_outborn') !!}</u></h4>
              
                <div id="inborn-nicuadmission-inout-charts" class="charts-width-height">
                  
                </div>
                
            </div>
               <!--  end  NICU admissions inborn out born chart -->    
               


            <!--  start In  NICU admissions category count -->

            <div class="col-md-12 col-sm-12 col-xs-12 page-break-page annual-report-content table-list-8">
                    <h4><u>Table 8: NICU Admissions Category {!! Lang::get('annualreports.report_titles_inborn_outborn') !!}</u></h4>
                <div class="block-table overflow-auto">    
                    <table class="annual-report-table-common">
                        <thead>
                          <tr>
                              <th>Month</th>
                              <th>Intensive Care</th>
                              <th>Special Care</th>
                              <th>High Dependancy Care</th>
                              <th>Total</th>
                             

  
                           </tr>    
                        </thead>
                        <tbody>
                        @foreach($inbornNicuadmission as $key => $value)   
                           <tr>
                               <td>{{ $key }}</td>
                               <td>{{ $inbornNicuadmissioncount[$key]["intensive_care"] }} ({{ $value['intensive_care'] }} %)</td>
                               <td>{{ $inbornNicuadmissioncount[$key]['special_care'] }} ({{ $value['special_care'] }} %)</td>
                               <td>{{ $inbornNicuadmissioncount[$key]['high_dependancy_care'] }} ({{ $value['high_dependancy_care'] }} %)</td>
                               <td>{{ $inbornNicuadmissioncount[$key]['intensive_care'] + $inbornNicuadmissioncount[$key]['special_care'] + $inbornNicuadmissioncount[$key]['high_dependancy_care']  }} ({{ $value['intensive_care']+$value['special_care']+$value['high_dependancy_care'] }} %)</td>
                           </tr> 
                        @endforeach   
                        </tbody>
                    </table>

                </div>
            </div>

               <!--  end  NICU admissions category count -->

               <!--  start  NICU admissions category chart -->

             <div class="col-md-12 col-sm-12 col-xs-12 page-break-page annual-report-graph figure-list-8">
               <h4><u>Figure 8: NICU Admissions Category {!! Lang::get('annualreports.report_titles_inborn_outborn') !!}</u></h4>
              
                <div id="inborn-nicuadmission-charts" class="charts-width-height">
                  
                </div>
                
            </div>
               <!--  end  NICU admissions category chart -->    


                <!-- start patient days of nicu admissions count -->
             <div class="col-md-12 col-sm-12 col-xs-12 page-break-page annual-report-content anual-page-break-confirm table-list-9">
                 <h4><u>Table 9 : Patient-Days Of NICU Admissions {!! Lang::get('annualreports.report_titles_inborn_outborn') !!}</u></h4>
                 <div class="block-table">
                   <table  class="annual-report-table-common">
                     <thead>
                       <th>Month</th>
                       <th>Patient Days</th>
                     </thead>
                     <tbody>
                      @foreach($patientDayscount as $key => $value) 
                      <tr>
                       <td>{{ $key }}</td>
                       <td>{{ $value['patient_days'] }} </td>
                      </tr> 
                      @endforeach   


                     </tbody>
                   </table>
                 </div>
            </div>  
                <!-- end patient days of nicu admissions count -->
 
                <!-- start patient days of nicu admissions chart -->

             <div class="col-md-12 col-sm-12 col-xs-12 page-break-page annual-page-break-confirm annual-report-graph figure-list-9">
               <h4><u>Figure 9: Patient-Days Of NICU Admissions {!! Lang::get('annualreports.report_titles_inborn_outborn') !!}</u></h4>
                <div id="patient-days-charts" class="charts-width-height">
                </div>
            </div>
                <!-- end patient days of nicu admissions chart -->

            <!-- start Admissions by gestation of niuc admission count -->
             <div class="col-md-12 col-sm-12 col-xs-12  page-break-page annual-report-content table-list-10">
                <h4><u> Table 10: Admissions By Gestation</u></h4>
                <div class="block-table overflow-auto">
                    <table class="annual-report-table-common">
                      <thead>
                        <tr>
                        <th>Month</th>
                        <th> < 28 </th>
                        <th>28 - 30</th>
                        <th>31 - 32</th>
                        <th>33 - 36</th>
                        <th>37 - 38</th>
                        <th>39 - 40</th>
                        <th>41 - 42</th>
                        <th> > 42 </th>
                       </tr>
                      </thead>
                      <tbody>
                       @foreach($nicuGestation as $key => $value)
                        <tr>
                          <td>{{ $key }}</td>
                          <td>{{ $nicuGestationcount[$key]["greater28"] }} ({{ $value['greater28'] }} %)</td>
                          <td>{{ $nicuGestationcount[$key]["28–30"] }} ({{ $value['28–30'] }} %)</td>
                          <td>{{ $nicuGestationcount[$key]["31-32"] }} ({{ $value['31-32'] }} %)</td>
                          <td>{{ $nicuGestationcount[$key]["33-36"] }} ({{ $value['33-36'] }} %)</td>
                          <td>{{ $nicuGestationcount[$key]["37-38"] }} ({{ $value['37-38'] }} %)</td>
                          <td>{{ $nicuGestationcount[$key]["39-40"] }} ({{ $value['39-40'] }} %)</td>
                          <td>{{ $nicuGestationcount[$key]["41-42"] }} ({{ $value['41-42'] }} %)</td>
                          <td>{{ $nicuGestationcount[$key]["less42"] }} ({{ $value['less42'] }} %)</td>

                        </tr>
                       @endforeach
                      </tbody>
                    </table>
                </div>
              </div>
               <!-- end Admissions by gestation of niuc admission count -->

                <!-- start Admissions by gestation of niuc admission chart -->
                 <div class="col-md-12 col-sm-12 col-xs-12 page-break-page annual-report-graph figure-list-10">
                   <h4><u>Figure 10: Admissions By Gestation</u></h4>
                    <div id="nicu-gestation-charts" class="charts-width-height">
                    </div>
                </div>
                <!-- end Admissions by gestation of niuc admission chart -->



            <!-- start Admissions By Birth Weight count -->
             <div class="col-md-12 col-sm-12 col-xs-12 page-break-page annual-report-content annual-page-break-confirm table-list-11">
                <h4><u> Table 11: Admissions By Birth Weight</u></h4>
                <div class="block-table overflow-auto">
                    <table class="annual-report-table-common">
                      <thead>
                        <th>Month</th>
                        <th> < 1000 </th>
                        <th>1001 - 1500</th>
                        <th>1501 - 2000</th>
                        <th>2001 - 2500</th>
                        <th>2501 - 3000</th>
                        <th>3001 - 3500</th>
                        <th>3501 - 4000</th>
                        <th> > 4001 </th>
                      </thead>
                      <tbody>
                       @foreach($nicuBirthweight as $key => $value)
                        <tr>
                          <td>{{ $key }}</td>
                          <td>{{ $nicuBirthweightcount[$key]["0000-1000"] }} ({{ $value['0000-1000'] }} %)</td>
                          <td>{{ $nicuBirthweightcount[$key]["1000-1499"] }} ({{ $value['1000-1499'] }} %)</td>
                          <td>{{ $nicuBirthweightcount[$key]["1500-1999"] }} ({{ $value['1500-1999'] }} %)</td>
                          <td>{{ $nicuBirthweightcount[$key]["2000-2499"] }} ({{ $value['2000-2499'] }} %)</td>
                          <td>{{ $nicuBirthweightcount[$key]["2500-2999"] }} ({{ $value['2500-2999'] }} %)</td>
                          <td>{{ $nicuBirthweightcount[$key]["3000-3499"] }} ({{ $value['3000-3499'] }} %)</td>
                          <td>{{ $nicuBirthweightcount[$key]["3500-3999"] }} ({{ $value['3500-3999'] }} %)</td>
                          <td>{{ $nicuBirthweightcount[$key]["4000-9999"] }} ({{ $value['4000-9999'] }} %)</td>

                        </tr>
                       @endforeach
                      </tbody>
                    </table>
                </div>
              </div>
               <!-- end Admissions By Birth Weight count -->

                <!-- start Admissions By Birth Weight chart -->
                 <div class="col-md-12 col-sm-12 col-xs-12 page-break-page annual-report-graph figure-list-11">
                   <h4><u>Figure 11: Admissions By Birth Weight</u></h4>
                    <div id="nicu-birthweight-charts" class="charts-width-height">
                    </div>
                </div>
                <!-- end Admissions By Birth Weight chart -->


                 <!-- start Chronic lung disease count -->
             <div class="col-md-12 col-sm-12 col-xs-12  page-break-page annual-report-content table-list-12">
                <h4><u> Table 12: Chronic Lung Disease {!! Lang::get('annualreports.report_titles_inborn_outborn') !!} </u></h4>
                <div class="block-table overflow-auto">
                    <table class="annual-report-table-common">
                      <thead>
                        <th>Month</th>
                        <th> O2 requirement at day 28 </th>
                        <th> O2 requirement at 36 wks corrected age</th>
                        <th> Home oxygen therapy</th>
                      </thead>
                      <tbody>
                       @foreach($chronicLung as $key => $value)
                        <tr>
                          <td>{{ $key }}</td>
                          <td>{{ $value['o2_requirement_day_28'] }}</td>
                          <td>{{ $value['o2_requirement_week_36'] }}</td>
                          <td>{{ $value['homeOxygen'] }}</td>
                        </tr>
                       @endforeach
                      </tbody>
                    </table>
                </div>
              </div>
               <!-- end Chronic lung disease count -->

                <!-- start Chronic lung disease chart -->
                 <div class="col-md-12 col-sm-12 col-xs-12 page-break-page annual-report-graph figure-list-12">
                   <h4><u>Figure 12: Chronic Lung Disease {!! Lang::get('annualreports.report_titles_inborn_outborn') !!}</u></h4>
                    <div id="nicu-chronic-charts" class="charts-width-height">
                    </div>
                </div>
                <!-- end Chronic lung disease chart -->



                 <!-- start Chronic lung disease count -->
             <div class="col-md-12 col-sm-12 col-xs-12 page-break-page annual-report-content annual-page-break-confirm table-list-13">
                <h4><u> Table 13: Types Of Respiratory Therapy {!! Lang::get('annualreports.report_titles_inborn_outborn') !!}</u></h4>
                <div class="block-table overflow-auto">
                    <table class="annual-report-table-common">
                      <thead>
                        <th>Month</th>
                        <th>Surfactant</th>
                        <th>Invasive ventilation (days)</th>
                        <th>CPAP (days)</th>
                        <th>NIPPV (days)</th>
                        <th>HHHFNC (days)</th>
                        <th>Nasal Prongs O2 (days)</th>
                        <th>Head Box O2 (days)</th>
                      </thead>
                      <tbody>
                       @foreach($respiratoryTherapy as $key => $value)
                        <tr>
                          <td class="respiratory-therapy-year-width">{{ $key }}</td>
                          <td>{{ $value['surfactant'] }}</td>
                          <td>{{ $value['Invasive_ventilation_days'] }}</td>
                          <td>{{ $value['CPAP'] }}</td>
                          <td>{{ $value['NIPPV'] }}</td>
                          <td>{{ $value['HHHFNC'] }}</td>
                          <td>{{ $value['nasal_prongs'] }}</td>
                          <td>{{ $value['head_box'] }}</td>
                        </tr>
                       @endforeach
                      </tbody>
                    </table>
                </div>
              </div>
               <!-- end Chronic lung disease count -->

                <!-- start Chronic lung disease chart -->
                 <div class="col-md-12 col-sm-12 col-xs-12 page-break-page  annual-report-graph anual-page-break-confirm figure-list-13">
                   <h4><u>Figure 13: Types Of Respiratory Therapy {!! Lang::get('annualreports.report_titles_inborn_outborn') !!}</u></h4>
                    <div id="nicu-respiratory-charts" class="charts-width-height">
                    </div>
                </div>
                <!-- end Chronic lung disease chart -->


            <!-- start Indications for surfactant therapy count -->
             <div class="col-md-12 col-sm-12 col-xs-12 page-break-page annual-report-content table-list-14">
               <h4> <u>Table 14: Indications For Surfactant Therapy {!! Lang::get('annualreports.report_titles_inborn_outborn') !!}</u></h4> 
                 <div class="block-table">
                   <table class="annual-report-table-common">
                     <thead>
                         <th>Month</th>
                       @foreach($surfactantKey as $surfactantName)
                          <th>{{ str_replace('_',' ',$surfactantName) }}</th>
                       @endforeach 
                     </thead>
                     <tbody>
                       @foreach($surfactantTherapy as $surfactantYear => $surfactantList)
                        <tr>
                           <td>{{ $surfactantYear }}</td>
                           @foreach($surfactantKey as $surfactantValue)
                            <td> {{ (isset($surfactantTherapy[$surfactantYear][$surfactantValue]) ? $surfactantTherapy[$surfactantYear][$surfactantValue] : 0 )  }} </td> 
                            @endforeach
                         </tr>   
                       @endforeach 
                     </tbody> 
                   </table>
                 </div>
             </div>  
               <!-- end Indications for surfactant therapy count -->
 

             <!-- start Indications for surfactant therapy chart -->
                 <div class="col-md-12 col-sm-12 col-xs-12 page-break-page annual-report-graph figure-list-14">
                   <h4><u>Figure 14: Indications For Surfactant Therapy {!! Lang::get('annualreports.report_titles_inborn_outborn') !!}</u></h4>
                    <div id="nicu-surfactant-charts" class="charts-width-height">
                    </div>
                </div>
                <!-- end Indications for surfactant therapy chart -->   


                <!-- start Cardiovascular morbidities count -->
                <div class="col-md-12 col-sm-12 col-xs-12 page-break-page annual-report-content annual-page-break-confirm table-list-15">
                  <h4> <u> Table 15: Cardiovascular Morbidites {!! Lang::get('annualreports.report_titles_inborn_outborn') !!}</u></h4>
                   <div class="block-table overflow-auto">
                     <table class="annual-report-table-common">
                        <thead>
                          <th> Month</th>
                          <th> Hypotension</th>
                          <th> PDA Treatment Medical</th>
                          <th> PDA Treatment Surgical</th>
                          <th> PPHN</th>
                        </thead>
                        <tbody>
                          @foreach($cardiovascular as $period => $cardiovascularList)
                           <tr>
                               <td>{{ $period }}</td>
                               <td>{{ $cardiovascularList['inotropes'] }}</td>
                               <td>{{ $cardiovascularList['medical_pda'] }}</td>
                               <td>{{ $cardiovascularList['surgical_pda'] }}</td>
                               <td>{{ $cardiovascularList['pphn'] }}</td>
                           </tr>
                          @endforeach 
                        </tbody>
                     </table>
                   </div>             
                </div>
              <!--   end Cardiovascular morbidities count -->
              
              <div class="col-md-12 col-sm-12 col-xs-12 page-break-page annual-report-content table-list-16">
                <h4><u>Table 16: Gastrointestinal Morbidity {!! Lang::get('annualreports.report_titles_inborn_outborn') !!}</u></h4>
                 <div class="block-table">
                   <table class="annual-report-table-common">
                     <thead>
                       <th>Month</th>
                       <th>Necrotizing Enterocolitis</th>
                       <th>TPN days</th>
                     </thead>
                     <tbody>
                       @foreach($gastrointestinal as $period => $gastrointestinalList)
                       <tr>
                         <td>{{ $period }}</td>
                         <td>{{ $gastrointestinalList['Nec'] }}</td>
                         <td>{{ $gastrointestinalList['Tpn'] }}</td>
                       </tr>  
                       @endforeach
                     </tbody> 
                   </table> 
                 </div>
              </div>

              <div class="col-md-12 col-sm-12 col-xs-12 page-break-page annual-report-content anual-page-break-confirm table-list-17">
                <h4><u> Table 17: Retinopathy Of Prematurity {!! Lang::get('annualreports.report_titles_inborn_outborn') !!}</u></h4>
                <div class="block-table">
                  <table class="annual-report-table-common">
                     <thead>
                       <th>Month</th>
                       <th>ROP Screening</th>
                       <th>ROP</th>
                       <th>ROP Treatment</th>
                     </thead>
                     <tbody>
                       @foreach($ROP as $period  => $ropList)
                        <tr>
                           <td>{{ $period }}</td>
                           <td>{{ $ropList['rop_screening'] }}</td>
                           <td>{{ $ropList['rop_treatment'] }}</td>
                           <td>{{ $ropList['rop_findings'] }}</td>
                        </tr>
                       @endforeach
                     </tbody>
                  </table>
                </div>
              </div>

                         <!-- start Sepsis organisms in blood  -->
               <div class="col-md-12 col-sm-12 col-xs-12 page-break-page annual-report-content table-list-18">
                 <h4><u> Table 18: Sepsis Organisms In Blood {!! Lang::get('annualreports.report_titles_inborn_outborn') !!}</u></h4>
                 <div class="block-table">
                    <table class="annual-report-table-common">
                      <thead>
                         <th>Month</th>
                        @foreach($organizam_titles as $period)
                         <th>{{ $period }}</th>
                        @endforeach 
                      </thead> 
                      <tbody>
                        @foreach($organizamList as $key => $organizamNames )
                          <tr>
                            <td>{{ $key }}</td>
                            @foreach($organizamNames as $value)
                            <td>{{ $value }}</td>
                            @endforeach
                          </tr>
                        @endforeach
                      
                      </tbody>                  
                    </table>
                 </div>
                </div>
                         <!-- end Sepsis organisms in blood  -->

              <div class="col-md-12 col-sm-12 col-xs-12 page-break-page annual-report-content table-list-19">
                <h4><u> Table 19: Survival To Discharge By Gestation  {!! Lang::get('annualreports.report_titles_inborn_outborn') !!}</u></h4>
                <div class="block-table overflow-auto">
                  <table class="annual-report-table-common">
                     <thead>
                        <th>Month</th>
                        <th> < 28 </th>
                        <th>28 - 30</th>
                        <th>31 - 32</th>
                        <th>33 - 36</th>
                        <th>37 - 38</th>
                        <th>39 - 40</th>
                        <th>41 - 42</th>
                        <th> > 42 </th>
                      </thead>
                      <tbody>
                       @foreach($survivalList as $key => $value)
                        <tr>
                          <td>{{ $key }}</td>
                          <td>{{ $survivalcount[$key]["greater28"] }} ({{ $value['greater28'] }} %)</td>
                          <td>{{ $survivalcount[$key]["28–30"] }} ({{ $value['28–30'] }} %)</td>
                          <td>{{ $survivalcount[$key]["31-32"] }} ({{ $value['31-32'] }} %)</td>
                          <td>{{ $survivalcount[$key]["33-36"] }} ({{ $value['33-36'] }} %)</td>
                          <td>{{ $survivalcount[$key]["37-38"] }} ({{ $value['37-38'] }} %)</td>
                          <td>{{ $survivalcount[$key]["39-40"] }} ({{ $value['39-40'] }} %)</td>
                          <td>{{ $survivalcount[$key]["41-42"] }} ({{ $value['41-42'] }} %)</td>
                          <td>{{ $survivalcount[$key]["less42"] }} ({{ $value['less42'] }} %)</td>

                        </tr>
                       @endforeach
                      </tbody>
                  </table>
                </div>
                
              </div>

              <!-- start Indications for surfactant therapy chart -->
               <!--   <div class="col-md-12 col-sm-6 col-xs-12 page-break-page annual-report-content figure-list-15">
                   <h4><u>Figure 15: Survival To Discharge By Gestation {!! Lang::get('annualreports.report_titles_inborn_outborn') !!}</u></h4>
                    <div id="nicu-survival-charts" class="charts-width-height">
                    </div>
                </div> -->
                <!-- end Indications for surfactant therapy chart --> 


                <!-- start Survival to discharge (by birth weight) count -->
             <div class="col-md-12 col-sm-12 col-xs-12 page-break-page annual-report-content table-list-20">
                <h4><u> Table 20: Survival To Discharge By Birth Weight {!! Lang::get('annualreports.report_titles_inborn_outborn') !!}</u></h4>
                <div class="block-table overflow-auto">
                    <table class="annual-report-table-common">
                      <thead>
                        <th>Month</th>
                        <th> < 1000 </th>
                        <th>1001 - 1500</th>
                        <th>1501 - 2000</th>
                        <th>2001 - 2500</th>
                        <th>2501 - 3000</th>
                        <th>3001 - 3500</th>
                        <th>3501 - 4000</th>
                        <th> > 4001 </th>
                      </thead>
                      <tbody>
                       @foreach($survivalWeightlist as $key => $value)
                        <tr>
                          <td>{{ $key }}</td>
                          <td>{{ $survivalWeightcount[$key]["1000"] }} ({{ $value['1000'] }} %)</td>
                          <td>{{ $survivalWeightcount[$key]["1000-1499"] }} ({{ $value['1000-1499'] }} %)</td>
                          <td>{{ $survivalWeightcount[$key]["1500-1999"] }} ({{ $value['1500-1999'] }} %)</td>
                          <td>{{ $survivalWeightcount[$key]["2000-2499"] }} ({{ $value['2000-2499'] }} %)</td>
                          <td>{{ $survivalWeightcount[$key]["2500-2999"] }} ({{ $value['2500-2999'] }} %)</td>
                          <td>{{ $survivalWeightcount[$key]["3000-3499"] }} ({{ $value['3000-3499'] }} %)</td>
                          <td>{{ $survivalWeightcount[$key]["3500-3999"] }} ({{ $value['3500-3999'] }} %)</td>
                          <td>{{ $survivalWeightcount[$key]["4000"] }} ({{ $value['4000'] }} %)</td>

                        </tr>
                       @endforeach
                      </tbody>
                    </table>
                </div>
              </div>
               <!-- end Survival to discharge (by birth weight) count -->

                <!-- start Survival to discharge (by birth weight) chart -->
                <!--  <div class="col-md-12 col-sm-6 col-xs-12 page-break-page annual-report-content figure-list-16">
                   <h4><u>Figure 16: Survival To Discharge By Birth Weight {!! Lang::get('annualreports.report_titles_inborn_outborn') !!}</u></h4>
                    <div id="nicu-survival-weight-charts" class="charts-width-height">
                    </div>
                </div> -->
                <!-- end Survival to discharge (by birth weight) chart -->


                @if(count($characterofdiedbaby) > 0)     
                    <!-- start Characteristics of babies who died -->
                <div class="col-md-12 col-sm-12 col-xs-12 page-break-page annual-report-content table-list-21">
                <h4><u> Table 21: Characteristics Of Babies Who Died {!! Lang::get('annualreports.report_titles_inborn_outborn') !!}</u></h4>
                  <div class="block-table">
                    <table class="character-table">
                       <thead>
                         <th class="character-table-head">Gestation (wks)</th>
                         <th class="character-table-head">Birth weight (gms)</th>
                         <th>Cause of death</th>
                       </thead>
                       <tbody>

                         @foreach($characterofdiedbaby as $period  => $diedBabyList)
                          <tr>
                             <td>{!! $diedBabyList['gestation'] !!}</td>
                             <td>{!! $diedBabyList['birthweight'] !!}</td>
                             <td>{!! $diedBabyList['causeofdeath'] !!}</td>
                          </tr>
                         @endforeach
                       </tbody>
                    </table>
                  </div>
                </div>
                    <!-- end Characteristics of babies who died -->
                @endif  

                         <!-- start procedures performed  -->
               <div class="col-md-12 col-sm-12 col-xs-12 page-break-page annual-report-content table-list-22">
                 <h4><u> Table 22: Procedures Performed {!! Lang::get('annualreports.report_titles_inborn_outborn') !!}</u></h4>
                 <div class="block-table">
                    <table class="annual-report-table-common">
                      <thead>
                         <th>Month</th>
                        @foreach($proceduresDetails['dates'] as $period)
                         <th>{{ $period }}</th>
                        @endforeach 
                      </thead> 
                      @php unset($proceduresDetails['dates']);   @endphp 
                      <tbody>
                        @foreach($proceduresDetails as $period =>$procedures)
                         <tr>
                          <td>{{ str_replace('_',' ',$period) }}</td>
                          @foreach($procedures as $value )
                           <td>{{ $value }}</td>
                          @endforeach
                         </tr>
                        @endforeach
                      </tbody>                  
                    </table>
                 </div>
                </div>
                         <!-- end procedures performed  -->
              
               <div class="col-md-12 col-sm-12 col-xs-12 page-break-page annual-report-content text-center">
                 <span><b>Total No. Of Outside Referrals : {{ $outborncount }}</b></span>
               </div>
         
              <div class="col-md-12 col-sm-12 col-xs-12 page-break-page annual-report-content table-list-23">
                <h4><u> Table 23: Outside Referrals By Gestation {!! Lang::get('annualreports.report_titles_inborn_outborn') !!} </u></h4>
                <div class="block-table overflow-auto">
                  <table class="annual-report-table-common">
                     <thead>
                        <th>Month</th>
                        <th> < 28 </th>
                        <th>28 - 30</th>
                        <th>31 - 32</th>
                        <th>33 - 36</th>
                        <th>37 - 38</th>
                        <th>39 - 40</th>
                        <th>41 - 42</th>
                        <th> > 42 </th>
                      </thead>
                      <tbody>
                       @foreach($outBournbabies as $key => $value)
                        <tr>
                          <td>{{ $key }}</td>
                          <td>{{ $outBournbabiescount[$key]["greater28"] }} ({{ $value['greater28'] }} %)</td>
                          <td>{{ $outBournbabiescount[$key]["28–30"] }} ({{ $value['28–30'] }} %)</td>
                          <td>{{ $outBournbabiescount[$key]["31-32"] }} ({{ $value['31-32'] }} %)</td>
                          <td>{{ $outBournbabiescount[$key]["33-36"] }} ({{ $value['33-36'] }} %)</td>
                          <td>{{ $outBournbabiescount[$key]["37-38"] }} ({{ $value['37-38'] }} %)</td>
                          <td>{{ $outBournbabiescount[$key]["39-40"] }} ({{ $value['39-40'] }} %)</td>
                          <td>{{ $outBournbabiescount[$key]["41-42"] }} ({{ $value['41-42'] }} %)</td>
                          <td>{{ $outBournbabiescount[$key]["less42"] }} ({{ $value['less42'] }} %)</td>

                        </tr>
                       @endforeach
                      </tbody>
                  </table>
                </div>
              </div>

              <!-- start out born chart -->
                 <div class="col-md-12 col-sm-12 col-xs-12 page-break-page annual-report-graph figure-list-17">
                   <h4><u>Figure 17: Outside Referrals By Gestation {!! Lang::get('annualreports.report_titles_inborn_outborn') !!}</u></h4>
                    <div id="nicu-outborn-charts" class="charts-width-height">
                    </div>
                </div>
              <!-- end out born chart -->


              
    <div>
</div>  
<div class="clearfix"></div>
  <div class="copyright-content">
      <span>copyrights {{ date('Y') }}@RasterImages</span>
      <br/>
      <span><img src="{{ url('public/img/raster_logo.svg') }}" width="120px" height="25px"></span>  

  </div>       


@endsection
@section('scripts')

<script>
$(document).ready(function(){

      var sexDistributiondata = sexDistributionprop =  modeConceptiondata = modeConceptionprop  =  inbornBaby = 
      modeDeliveryprop = modeDeliverydata = inbornGestationdata = inbornGestationprop = inbornBirthweightdata = 
      inbornBirthweightprop = inbornNicuadmissiondata = inbornNicuadmissionprop = inbornoutbornNicuadmissiondata = 
      inbornoutbornNicuadmissionprop = patientData = patientProp = nicuGestationdata = nicuGestationProp = 
      nicubirthWeightdata = nicubirthWeightprop = chronicData = chronicProp = respiratorytherapyData = 
      respiratorytherapyProp =  surfactantData = surfactantProp = survivalData = survivalProp = survivalWeightdata = 
      survivalWeightprop = outbornData = [];

      // inborn charts


      inbornBabydata = JSON.parse('{!! $inbornBabieschart !!}');
      
      inbornBabyprop = JSON.parse('{!! $inbornProperty !!}'); 




      //  sex distribution charts 

      sexDistributiondata     = JSON.parse('{!! $sexDistributioncharts !!}');

      sexDistributionprop     = JSON.parse('{!! $sexChartsproperty !!}');

     


      // mode of conception 

      modeConceptiondata      = JSON.parse('{!! $inbornConceptioncharts !!}');

      modeConceptionprop      = JSON.parse('{!! $inbornConceptionsproperty !!}');

      // mode of delievery 
      

      modeDeliverydata        = JSON.parse('{!! $modeofDeliverycharts !!}');

      modeDeliveryprop        = JSON.parse('{!! $modeofDeliveryproperty !!}');

     


       // inborn Gestation 

      inbornGestationdata        = JSON.parse('{!! $inbornGestationcharts !!}');

      inbornGestationprop        = JSON.parse('{!! $inbornGestationproperty !!}');



       // inborn Gestation 

      inbornBirthweightdata        = JSON.parse('{!! $inbornbirthWeightcharts !!}');

      inbornBirthweightprop        = JSON.parse('{!! $inbornbirthWeightproperty !!}');

     


       // inborn outborn 

      inbornoutbornNicuadmissiondata      = JSON.parse('{!! $outborninbornNicuadmissioncharts !!}');

      inbornoutbornNicuadmissionprop      = JSON.parse('{!! $outborninbornNicuadmissionproperty !!}');

   


      // inborn category  

      inbornNicuadmissiondata      = JSON.parse('{!! $inbornNicuadmissionCharts !!}');

      inbornNicuadmissionprop      = JSON.parse('{!! $inbornNicuadmissionproperty !!}');


      // patient days

       patientData      = JSON.parse('{!! $patientDayscharts !!}');

       patientProp      = JSON.parse('{!! $patientDaysproperties !!}');

       //nicu admission gestation 
       
       nicuGestationdata      = JSON.parse('{!! $nicuGestationcharts !!}');

       nicuGestationProp      = JSON.parse('{!! $nicuGestationproperties !!}');

       // birth wieght list

       nicubirthWeightdata    = JSON.parse('{!! $nicuBirthweightcharts !!}');

       nicubirthWeightprop    = JSON.parse('{!! $nicuBirthweightproperties !!}');


        // birth wieght list

       nicubirthWeightdata    = JSON.parse('{!! $nicuBirthweightcharts !!}');

       nicubirthWeightprop    = JSON.parse('{!! $nicuBirthweightproperties !!}');


       chronicData            = JSON.parse('{!! $chronicLungchart !!}'); 
       chronicProp            = JSON.parse('{!! $nicuchronicproperties !!}');  

       respiratorytherapyData = JSON.parse('{!! $respiratoryTherapychart !!}');
       respiratorytherapyProp = JSON.parse('{!! $respirataryProperties !!}');

       surfactantData         = JSON.parse('{!! $surfactantTherapychart !!}');
       surfactantProp         = JSON.parse('{!! $surfactantProperties !!}');

       survivalData           = JSON.parse('{!! $survivalChart !!}');
       survivalProp           = JSON.parse('{!! $inbornGestationproperty !!}');

       survivalWeightdata     = JSON.parse('{!! $survivalWeightchart !!}');
       survivalWeightprop     = JSON.parse('{!! $inbornbirthWeightproperty !!}');

       outbornData            = JSON.parse('{!! $outBournbabieschart !!}');
       outbornProp            = JSON.parse('{!! $inbornGestationproperty !!}');




       

       







       @if($chartType == 1)

         var inborn                   = mixedBarchart(inbornBabydata,inbornBabyprop,'inborn-baby-compare-charts');  

         var sexDistribution          = mixedBarchart(sexDistributiondata,sexDistributionprop,'sex-distribution-charts');

         var modeConception           = mixedBarchart(modeConceptiondata,modeConceptionprop,'mode-conception-charts');

         var modeDelivery             = mixedBarchart(modeDeliverydata,modeDeliveryprop,'mode-delivery-charts');

         var inbornGestation          = mixedBarchart(inbornGestationdata,inbornGestationprop,'inborn-gestation-charts');

         var inbornBirthweight        = mixedBarchart(inbornBirthweightdata,inbornBirthweightprop,'inborn-birthweight-charts');

         var inbornoutborn            = mixedBarchart(inbornoutbornNicuadmissiondata,inbornoutbornNicuadmissionprop,'inborn-nicuadmission-inout-charts');

         var inbornNicuadmission      = mixedBarchart(inbornNicuadmissiondata,inbornNicuadmissionprop,'inborn-nicuadmission-charts');
     
         var patientDay               = mixedBarchart(patientData,patientProp,'patient-days-charts'); 

         var nicuGestation            = mixedBarchart(nicuGestationdata,nicuGestationProp,'nicu-gestation-charts'); 

         var nicuBirthweight          = mixedBarchart(nicubirthWeightdata,nicubirthWeightprop,'nicu-birthweight-charts'); 

         var nicuChronic              = mixedBarchart(chronicData,chronicProp,'nicu-chronic-charts'); 

         var respiratory              = mixedBarchart(respiratorytherapyData,respiratorytherapyProp,'nicu-respiratory-charts');

         var surfactant               = mixedBarchart(surfactantData,surfactantProp,'nicu-surfactant-charts');

        // var survival                 = mixedBarchart(survivalData,survivalProp,'nicu-survival-charts');

        // var survivalWeight           = mixedBarchart(survivalWeightdata,survivalWeightprop,'nicu-survival-weight-charts');

         var outbornlist              = mixedBarchart(outbornData,outbornProp,'nicu-outborn-charts');
         


       @elseif($chartType == 2)

           var inborn                   = multipleBarchart(inbornBabydata,inbornBabyprop,'inborn-baby-compare-charts');  

           var sexDistribution          = multipleBarchart(sexDistributiondata,sexDistributionprop,'sex-distribution-charts');

           var modeConception           = multipleBarchart(modeConceptiondata,modeConceptionprop,'mode-conception-charts');

           var modeDelivery             = multipleBarchart(modeDeliverydata,modeDeliveryprop,'mode-delivery-charts');

           var inbornGestation          = multipleBarchart(inbornGestationdata,inbornGestationprop,'inborn-gestation-charts');

           var inbornBirthweight        = multipleBarchart(inbornBirthweightdata,inbornBirthweightprop,'inborn-birthweight-charts');

           var inbornoutborn            = multipleBarchart(inbornoutbornNicuadmissiondata,inbornoutbornNicuadmissionprop,'inborn-nicuadmission-inout-charts');

           var inbornNicuadmission      = multipleBarchart(inbornNicuadmissiondata,inbornNicuadmissionprop,'inborn-nicuadmission-charts');

           var patientDay               = multipleBarchart(patientData,patientProp,'patient-days-charts'); 

           var nicuGestation            = multipleBarchart(nicuGestationdata,nicuGestationProp,'nicu-gestation-charts'); 

           var nicuBirthweight          = multipleBarchart(nicubirthWeightdata,nicubirthWeightprop,'nicu-birthweight-charts'); 
          
           var nicuChronic              = multipleBarchart(chronicData,chronicProp,'nicu-chronic-charts'); 

           var respiratory              = multipleBarchart(respiratorytherapyData,respiratorytherapyProp,'nicu-respiratory-charts');

           var surfactant               = multipleBarchart(surfactantData,surfactantProp,'nicu-surfactant-charts');

           //var survival                 = multipleBarchart(survivalData,survivalProp,'nicu-survival-charts');

          // var survivalWeight           = multipleBarchart(survivalWeightdata,survivalWeightprop,'nicu-survival-weight-charts');

           var outbornlist              = multipleBarchart(outbornData,outbornProp,'nicu-outborn-charts');
 
       @endif







      setTimeout(function(){
          $('.amcharts-chart-div').children('a').hide();
      },300);

      $('.table-index').click(function(e){
        e.preventDefault();
         var id = $(this).data('id');
         var position = $('.'+id).position().top;
          $('html, body').animate({
              scrollTop: position
          }, 300);
      });
});



</script>

@endsection
