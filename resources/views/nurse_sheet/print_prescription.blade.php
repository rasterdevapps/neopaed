@extends('print')
@section('content')
<div class="temp-container prescription-print-sheet permission-module-main-div">
	<div class="chart-header col-md-12 col-xs-12 col-sm-12 remove-padding">
		<div class="col-md-8 col-xs-8 col-sm-8 border-right remove-padding">
			<div><img src="{{ ValuelistHelpers::printPagelogo() }}"></div>
			<div class="center fs"><b>Form No.4</b></div>
			<div class="center fs"><b>MEDICATION CHART</b></div>
		</div>
		<div class="col-md-4 col-xs-4 col-sm-4 content-center">
		    <div class="col-md-12 col-xs-12 col-sm-12 center">
		      <b>{{ $ip_numbers }}</b>
		    </div>
		    <div class="col-md-12 col-xs-12 col-sm-12">
		      @if(!is_null($ip_numbers) && is_numeric($ip_numbers))
		      <div >
	            {!! '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($ip_numbers, "C128",2,33,array(1,1,1), true) . '" alt="barcode"   />' !!}
		      </div>
		      @endif
		    </div>
		    <div class="col-md-12  col-xs-12 col-sm-12 center font-mname">
		     {{ $baby->BabyName }} <span>{{ $corrected_gestation }}</span> / <span>@if($baby->Sex == 'Female') F @elseif($baby->Sex =='Male') M @endif</span>
		    </div>
		    <div class="col-md-12  col-xs-12 col-sm-12 font-dr">
                {{ SiteHelpers::get_doctors_name($baby->neonatal_consultant) }}
		        {{ $baby->BMrNo }}
		    </div>
		 </div>
	</div>
	<div class="col-md-12 col-xs-12 col-sm-12 ward-room remove-padding">
		<div class="col-md-4 col-xs-4 col-sm-4 remove-padding"><b>Ward :</b></div>
		<div class="col-md-4 col-xs-4 col-sm-4 remove-padding"><b>Room No. :</b></div>
		<div class="col-md-offset-2 col-md-2 col-xs-4 col-sm-4 remove-padding"><b>Date : {{ date('d-m-Y', strtotime($prescription_date)) }}</b></div>		
	</div>
		 <!-- main medication start -->
		<div class="col-md-12 col-xs-12 col-sm-12">
      	  <table class="table prescription-module">
      	  	<thead>
      	  		<tr>
      	  			<th>NO.</th>
      	  			<th>DAY</th>
      	  			<th>NAME <br/> [BRAND / PHARMACOLOGICAL]</th>
      	  			<th>DOSE/UNIT</th>
      	  			<th>DESCRIPTION</th>
      	  			<th>RATE (ml/h)</th>
      	  			<th>ADDITIONAL INSTRUCTIONS</th>
      	  			<th>DATE & TIME PRESCRIBED</th>
      	  			<th>DATE & TIME STOPPED</th>
      	  		</tr>
      	  	</thead>
      	  	<tbody>
      	  		@php $i = 1; @endphp
      	  	    @if(isset($iv_drugs_infusion) &&  count($iv_drugs_infusion) > 0)	
	      	  		@foreach($iv_drugs_infusion as $iv_drugs_infusion_list)
	      	  		   @php $infusion_dose_units_g = ValuelistHelpers::infusiondoesunitgrams($iv_drugs_infusion_list['infusion_dose_units_g']) @endphp
		      	  	   @php $infusion_dose_units_kg = ValuelistHelpers::infusiondoeskilograms($iv_drugs_infusion_list['infusion_dose_units_kg']) @endphp
		      	  	   @php $infusion_dose_units_time = ValuelistHelpers::infusiondoesduration($iv_drugs_infusion_list['infusion_dose_units_time']) @endphp
		      	  		@php $does_units_text = $infusion_dose_units_g.' / '.$infusion_dose_units_kg.' / '.$infusion_dose_units_time @endphp
		      	  		  <tr>
		      	  		  	 <td>{{ $i }}</td>
		      	  		  	 <td>{{ $iv_drugs_infusion_list['infusion_day'] }}</td>
		      	  		  	 <td>
		      	  		  	 @if($iv_drugs_infusion_list['infusion_brandname'] != '' && isset($ivfluids[$iv_drugs_infusion_list['infusion_brandname']]) && isset($ivfluids_gen[$iv_drugs_infusion_list['infusion_pharmacological']]) && $iv_drugs_infusion_list['infusion_pharmacological'] != '')  	
		      	  		  	 
		      	  		  	 {{ $ivfluids[$iv_drugs_infusion_list['infusion_brandname']].' / '.$ivfluids_gen[$iv_drugs_infusion_list['infusion_pharmacological']] }}
		      	  		     
		      	  		     @elseif($iv_drugs_infusion_list['infusion_brandname'] != '' && isset($ivfluids[$iv_drugs_infusion_list['infusion_brandname']]) && $iv_drugs_infusion_list['infusion_pharmacological'] == '')

		      	  		  	 {{ $ivfluids[$iv_drugs_infusion_list['infusion_brandname']] }}

		      	  		  	 @elseif($iv_drugs_infusion_list['infusion_brandname'] == '' && isset($ivfluids_gen[$iv_drugs_infusion_list['infusion_pharmacological']]) && $iv_drugs_infusion_list['infusion_pharmacological'] != '')
		      	  		  
		      	  		  	 {{ $ivfluids_gen[$iv_drugs_infusion_list['infusion_pharmacological']] }}
		      	  		    
		      	  		     @endif
		      	  		     </td>

		                     @if($iv_drugs_infusion_list['infusion_dose'] != '')
		      	  		  	 <td class="white-wrap">
                               {{ $iv_drugs_infusion_list['infusion_dose'].' '.$does_units_text }}
                             </td>  
		      	  		  	 @else 
		      	  		  	 <td class="text-center">  N/A  </td>
		      	  		  	 @endif 

		                     @if($iv_drugs_infusion_list['infusion_syringe'] != '' && $iv_drugs_infusion_list['infusion_quantity'] != '')
		      	  		  	 <td>{{ $iv_drugs_infusion_list['infusion_quantity'].' '. ValuelistHelpers::infusionquantityunits($iv_drugs_infusion_list['infusion_quantity_units']).' in '.$iv_drugs_infusion_list['infusion_syringe'].' ml syringe'  }}</td>
		      	  		  	 @else 
		      	  		  	 <td class="text-center">  N/A </td> 
		      	  		  	 @endif
		      	  		  	 <td>{{ $iv_drugs_infusion_list['infusion_rate'] }}</td>
		      	  		  	 <td>
		      	  		  	 @if($iv_drugs_infusion_list['infusion_instruction'] != '') 	
		      	  		  	 {{ $iv_drugs_infusion_list['infusion_instruction'] }}
		      	  		  	 @else
		      	  		  	  N/A
		      	  		  	 @endif
		      	  		  	 </td>
		      	  		  	 <td class="white-wrapim">
		      	  		  	 @if($iv_drugs_infusion_list['infusion_date_prescribed'] != '' && $iv_drugs_infusion_list['infusion_time_prescribed'] != '') 	
		      	  		  	 {{ $iv_drugs_infusion_list['infusion_date_prescribed'].' '.$iv_drugs_infusion_list['infusion_time_prescribed'] }}
		      	  		  	 @else
		      	  		  	  N/A
		      	  		  	 @endif
		      	  		  	 </td>
		      	  		  	 <td class="white-wrapim">
		      	  		  	 @if($iv_drugs_infusion_list['infusion_date_stopped'] != '' && $iv_drugs_infusion_list['infusion_time_stopped'] != '') 	
		      	  		  	 {{ $iv_drugs_infusion_list['infusion_date_stopped'].' '.$iv_drugs_infusion_list['infusion_time_stopped'] }}
		      	  		  	 @else
		      	  		  	  N/A
		      	  		  	 @endif
		      	  		  	 </td>

		      	  		  </tr>
		      	  		 @php $i++; @endphp
	      	  		@endforeach
                @endif

                @if(isset($special_fluids_list) && count($special_fluids_list) > 0)
                  @foreach($special_fluids_list as $fluids_list)
                   @if($fluids_list['speical_fluid_vol_one'] != '' && $fluids_list['speical_fluid_vol_two'] != '')
                   <tr>
                   	 <td>{{ $i }}</td>
                   	 <td>{{ $fluids_list['speical_iv_day'] }}</td>
                   	 <td>{{ $fluids_list['speical_iv_fluid_name_one'].'% Dextrose '.$fluids_list['speical_fluid_vol_one'].' ml and '.$fluids_list['speical_iv_fluid_name_two'].'% Dextrose '.$fluids_list['speical_fluid_vol_two'].' ml' }}</td>
                   	 <td class="text-center">  N/A </td>
                   	 <td>{!! '% Dextrose '.$fluids_list['speical_iv_dextrose'].'.<br/> GIR '.$fluids_list['speical_iv_glucose'].' mg / kg / min' !!}</td>
                   	 <td>{{ $fluids_list['speical_iv_infusion_rate'] }}</td>
                   	 @if($fluids_list['speical_iv_instruction'] != '')
                   	 <td>{{ $fluids_list['speical_iv_instruction'] }}</td>
                   	 @else
                   	 <td>N/A</td>
                   	 @endif
                   	 <td class="white-wrapim">
		      	  	 @if($fluids_list['speical_iv_date_prescribed'] != '' && $fluids_list['speical_iv_time_prescribed'] != '') 	
		      	  	 {{ $fluids_list['speical_iv_date_prescribed'].' '.$fluids_list['speical_iv_time_prescribed'] }}
		      	  	 @else
		      	  	  N/A
		      	  	 @endif
		      	  	 </td>
		      	  	 <td class="white-wrapim">
		      	  	 @if($fluids_list['speical_iv_date_stopped'] != '' && $fluids_list['speical_iv_time_stopped'] != '') 	
		      	  	 {{ $fluids_list['speical_iv_date_stopped'].' '.$fluids_list['speical_iv_time_stopped'] }}
		      	  	 @else
		      	  	  N/A
		      	  	 @endif
		      	  	 </td>

                   </tr>
                    @php $i++; @endphp
                    @endif 
                    
                  @endforeach
                @endif

                @if(isset($other_iv_infusion_lists) &&  count($other_iv_infusion_lists) > 0) 
                  @foreach($other_iv_infusion_lists as $other_iv_infusions)
                    <tr>
                    	<td>{{ $i }}</td>
                    	<td>{{ $other_iv_infusions['other_infusions_day'] }}</td>
                    	<td>{{ isset($ivfluids_gen[$other_iv_infusions['other_infusions_pharmacological']]) ? $ivfluids_gen[$other_iv_infusions['other_infusions_pharmacological']] : '' }}</td>
                    	<td class="white-wrap">{{ $other_iv_infusions['other_infusions_volume'].' ml' }}</td>
                    	<td>{{ 'over '.$other_iv_infusions['other_infusions_duration'].' '.$other_iv_infusions['other_infusions_durametnod'] }}</td>
                        <td>{{ $other_iv_infusions['other_infusions_rate'] }}</td>
                        @if($other_iv_infusions['other_infusions_instruction'] != '')
                        <td>{{ $other_iv_infusions['other_infusions_instruction'] }}</td>
                        @else
                        <td>N/A</td>
                        @endif
                        <td class="white-wrapim">
			      	  	 @if($other_iv_infusions['other_infusions_date_prescribed'] != '' && $other_iv_infusions['other_infusions_time_prescribed'] != '') 	
			      	  	 {{ $other_iv_infusions['other_infusions_date_prescribed'].' '.$other_iv_infusions['other_infusions_time_prescribed'] }}
			      	  	 @else
			      	  	  N/A
			      	  	 @endif
			      	  	</td>
			      	  	<td class="white-wrapim">
			      	  	 @if($other_iv_infusions['other_infusions_date_stopped'] != '' && $other_iv_infusions['other_infusions_time_stopped'] != '') 	
			      	  	 {{ $other_iv_infusions['other_infusions_date_stopped'].' '.$other_iv_infusions['other_infusions_time_stopped'] }}
			      	  	 @else
			      	  	  N/A
			      	  	 @endif
			      	  	</td>
                    </tr>
                    @php $i++; @endphp
                  @endforeach 
                @endif

                @if(isset($other_iv_drugs_list) &&  count($other_iv_drugs_list) > 0) 
	              @foreach($other_iv_drugs_list as $other_iv_drugs)
                   <tr>
                   	<td>{{ $i }}</td>
                   	<td>{{ $other_iv_drugs['other_iv_drugs_day'] }}</td>

                   	<td>{{ $ivfluids[$other_iv_drugs['other_iv_drugs_brandname']].' / '. $ivfluids_gen[$other_iv_drugs['other_iv_drugs_pharmacological']]  }}</td>
                   
                   	<td class="white-wrap">{{ $other_iv_drugs['other_iv_drugs_dose_required']  }}</td>
                   	<td>{{ $other_iv_drugs['other_iv_drugs_frequency'].' [ VOLUME PER DOSE = '.$other_iv_drugs['other_iv_drugs_volume_dose'].' ml]' }}</td>
                   	<td> N/A</td>
                    @if($other_iv_drugs['other_iv_drugs_additional'] != '')
                   	<td>{{ $other_iv_drugs['other_iv_drugs_additional'] }}</td>
                   	@else
                   	<td>N/A</td>
                   	@endif

                   	<td class="white-wrapim">
			      	@if($other_iv_drugs['other_iv_drugs_date_prescribed'] != '' && $other_iv_drugs['other_iv_drugs_time_prescribed'] != '') 	
			      	{{ $other_iv_drugs['other_iv_drugs_date_prescribed'].' '.$other_iv_drugs['other_iv_drugs_time_prescribed'] }}
			      	@else
			      	 N/A
			      	@endif
			      	</td>
			      	<td class="white-wrapim">
			      	 @if($other_iv_drugs['other_iv_drugs_date_stopped'] != '' && $other_iv_drugs['other_iv_drugs_time_stopped'] != '') 	
			      	 {{ $other_iv_drugs['other_iv_drugs_date_stopped'].' '.$other_iv_drugs['other_iv_drugs_time_stopped'] }}
			      	 @else
			      	  N/A
			      	 @endif
			      	</td>
                   </tr>
                   @php $i++  @endphp
	              @endforeach
                @endif 

                @if(isset($oral_drugs) &&  count($oral_drugs) > 0)
                  @foreach($oral_drugs as $oral_drug)
                    <tr>
                    	<td>{{ $i }}</td>
                    	<td>{{ $oral_drug['oral_days'] }}</td>
                    	<td>{{ $drugs_brand_names[$oral_drug['oral_brandname']].' / '.$drugs_generic_name[$oral_drug['oral_pharmacological']] }} </td>
                    	<td class="white-wrap">{{ $oral_drug['oral_dose_required'] }}</td>
                    	<td>{{ $oral_drug['oral_frequency'].' '.$oral_drug['oral_route'] }}</td>
                    	<td> N/A </td>
                        @if($oral_drug['oral_additional'] != '')
                    	<td>{{ $oral_drug['oral_additional'] }}</td>
                    	@else
                    	 <td>N/A</td>
                    	@endif
                    	<td class="white-wrapim">
				      	@if($oral_drug['oral_date_prescribed'] != '' && $oral_drug['oral_time_prescribed'] != '') 	
				      	{{ $oral_drug['oral_date_prescribed'].' '.$oral_drug['oral_time_prescribed'] }}
				      	@else
				      	 N/A
				      	@endif
				      	</td>
				      	<td class="white-wrapim">
				      	 @if($oral_drug['oral_date_stopped'] != '' && $oral_drug['oral_time_stopped'] != '') 	
				      	 {{ $oral_drug['oral_date_stopped'].' '.$oral_drug['oral_time_stopped'] }}
				      	 @else
				      	  N/A
				      	 @endif
				      	</td>
                    </tr>
                    @php $i++  @endphp
                  @endforeach
                @endif
      	  	</tbody>
      	  </table>
		</div>
		<!-- main medication end -->

		<div class="col-md-12 col-xs-12 col-sm-12 remove-padding">
			<div class="col-md-9 col-xs-9 col-sm-9 remove-padding">
				<div class="remove-margin allergy"><b>ALLERGY:</b></div>
				<div class="col-md-12 col-xs-12 col-sm-12 remove-padding">
					<div class="col-md-1 col-xs-2 col-sm-2 remove-padding">
						<b>N.B. :</b>
					</div>
					<div class="col-md-10 col-xs-10 col-sm-10">
						<div>
							<b>The above medication chart should be signed by physician.</b>
						</div>
						<div>
							<b>The above chart should have medication entries for one day only.</b>
						</div>
					</div>
				</div>
				<div class="mt-60">
					<b>Medication Chart Version-3 / 10-04-2017 SKSH India (P) Ltd., Salem, TN.</b>
				</div>
			</div>
			<div class="col-md-3 col-xs-3 col-sm-3"></div>
		</div>
	</div>
@endsection
