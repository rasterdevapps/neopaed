@extends('print')
@section('content')
<style>
  @media print{@page {size: landscape}
    .container{
    	width:100%;
    	margin:0;
    }
  }
@media only screen {
    .print .container {
        width: 90vw;     
        margin: auto;    
    }
}
</style>
<div class="temp-container">
    <div class="col-md-12 col-sm-12 col-xs-12">
          <img src="{{ ValuelistHelpers::printPagelogo($hospital_name) }}" >
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
          <h3 class="print-head">OP Activity List</h3>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 op-activity-report overflow-auto mt-15">
            <table class="table table-striped">
						  <thead>
                <tr>
                  <th>S.No</th>
                  <th class="custom-date">Date</th>
                  <th>{{ Lang::get('home.mrn') }}</th>
                  <th>Name</th>
                  <th>Age</th>
                  <th>Type</th>
                  <th>Diagnosis</th>
                  <th>Investigations</th>
                  <th>Treatment</th>
                  <th>Outcome</th>
                  <th>Additional Information</th>
                </tr>
              </thead>
              <tbody>
              @php $i = 1 @endphp 
              @foreach( $results as $opresults )  
                @php $doctorid = $opresults->unique('SeenBy')->pluck('SeenBy')->values()->first(); @endphp
                   <tr>
                    <td colspan="11" class="text-center">
                      <b>
                     @if($doctorid != '')  
                       {{ ValuelistHelpers::mas_doctors_list($doctorid) }}
                     @else 
                         N/A
                     @endif
                      </b>
                    </td>
                  </tr>
                @foreach ($opresults as $babies)
                  <tr>
                    <td>{{ $i }}</td>
                    <td>{{  date('d-m-Y',strtotime($babies->OpDate)) }}</td>
                    <td>{{  $babies->BMrNo }}</td>
                    <td>{{  $babies->BabyName }}</td>
                    <td>{{  $babies->chronological_year.'Y'.$babies->chronological_month.'M'.$babies->chronological_days.'D' }} </td>
                    <td>{{  $babies->AppointmentType }}</td>
                    <td>{{  $babies->Diagnosis }}</td>
                    <td>{{  $babies->investigations }}</td>
                    <td>{{ ValuelistHelpers::getOpMedicinelist($babies->BabyId, $babies->OpId) }}</td>
                    <td>{{ $babies->Outcome }}</td>
                    <td></td>
                  </tr>
                @php $i++ @endphp 
                @endforeach
              @endforeach
              </tbody>
					</table>
    </div>
</div>
@endsection
