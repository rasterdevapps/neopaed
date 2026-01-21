@extends('print')
@section('content')
<style>
@media print{@page {size: landscape}
  .container{
  	width:100%;
  	margin:0;
  }
}
.print table th, .print table td {
  padding: 5px 5px !important;
}

@media only screen {
    .print .container {
        width: 80vw;     
        margin: auto;    
    }
}


</style>
<div class="temp-container">
	<div class="temp-row">
    <div class="col-md-11 col-sm-12 col-xs-12">
          <img src="{{ ValuelistHelpers::printPagelogo($hospital_name) }}" >
        </div>
    <div class="col-md-11 col-sm-12 col-xs-12">
          <h3 class="print-head">OP Report List</h3>
    </div>
		<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="opreport overflow-auto">
           
            <table class="table table-striped col-md-12">
						  <thead>
                <tr>
                  <th>S.No.</th>
                  <th class="custom-date">Date</th>
                  <th>{{ Lang::get('home.mrn') }}</th>
                  <th>Name</th>
                  <th class="custom-date">DOB</th>
                  <th>Wks</th>
                  <th>B.Wt</th>
                  <th>Sex</th>
                  <th>Type</th>
                  <th>Outcome</th> 
                  <th>Fees</th>    
                  <th>Reason</th>                                                                                          
                </tr>
              </thead>
              <tbody>
              @php $i = 1 @endphp 
              @foreach( $results as $opresults )  
                @php $doctorid = $opresults->unique('SeenBy')->pluck('SeenBy')->values()->first(); @endphp
                   <tr>
                    <td colspan="12" class="text-center">
                      <b>
                     @if($doctorid != '')  
                       {{ ValuelistHelpers::mas_doctors_list($doctorid) }}
                     @else 
                         N/A
                     @endif
                      </b>
                    </td>
                  </tr>
                    @php $opdates = $opresults->unique('OpDate')->pluck('OpDate');@endphp
                  @foreach($opdates as $op_date) 
                    <tr><td colspan="12" class="text-center"><b>{{ date('d-m-Y', strtotime($op_date)) }}</b></td></tr> 
                    @php $op_results = $opresults->where('OpDate',$op_date)@endphp

                    @foreach ($op_results as $babies)
                      <tr>
                        <td>{{ $i }}</td>
                        <td>{{  date('d-m-Y',strtotime($babies->OpDate)) }}</td>
                        <td>{{  $babies->BMrNo }}</td>
                        <td>{{  $babies->BabyName }}</td>
                        <td>{{  date('d-m-Y',strtotime($babies->DOB)) }}</td>
                        <td>{{  SiteHelpers::decode_gestation($babies->Gestation) }}</td>
                        <td>{{  $babies->BirthWeight }}</td>
                        <td>{{  $babies->Sex }}</td>
                        <td>{{  $babies->AppointmentType }}</td>
                        <td>{{  $babies->Outcome }}</td>
                        <td>
                        @if(isset($babies->fee_status) && !empty($babies->fee_status) && $babies->fee_status == true)
                         &#8377; {{ $babies->fee_amount }}
                        @endif
                        </td> 
                        <td>
                          {{ $babies->fee_reason }}
                        </td>
                      </tr>
                    @php $i++ @endphp 
                    @endforeach
                  @endforeach  

              @endforeach
              @if($results->pluck('fee_amount')->sum() != 0)
              <tr class="font-bold">
                <td colspan="2">Total Fee:</td>
                <td colspan="9" class="text-right">&#8377;{{ $results->pluck('fee_amount')->sum() }}</td>
              </tr>
              @endif
              </tbody>
					</table>
		    </div>    
       
    </div>
</div>
@endsection
