@extends('print')
@section('content')
<style>
@media print{
	     @page {size: landscape}
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
  <div class="temp-row">
    <div class="col-md-12 col-sm-12 col-xs-12">
          <img src="{{ ValuelistHelpers::printPagelogo($hospital_name) }}" >
        </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
          <h3 class="print-head">Live Birth Report</h3>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 mt-15">
		  <div class="birth-report overflow-auto">
				  <div class="">
            <!-- <div class="col-md-1 pull-right">
              <a href="javascript:void(0);" onclick="window.print();" class="btn btn-primary hidden-print"><i class="fa fa-print"></i><span>Print</span></a>
            </div> -->
            <table class="table table-striped col-md-12">
						  <thead>
                <tr>
                  <th>S.No.</th>
                  <th>{{ Lang::get('home.mrn') }}</th>
                  <th>Name</th>
                  <th>Wks</th>
                  <th>B.Wt</th>
                  <th>Sex</th>
                  <th class="custom-date">DOB</th>
                  <th>Conception</th>
                  <th>Mode of Delivery</th>                                
                  <th>Status</th>                                
                  <th>D.Wt</th>
                  <th class="custom-date">DOD</th>                                                                
                </tr>
              </thead>
              <tbody>
              @for ($i = 0; $i <  @count($results); $i++)
                @php $tob_time = is_null($results[$i]->TOB_TIME) ? 00 : (strlen($results[$i]->TOB_TIME) == 1) ? '0'.$results[$i]->TOB_TIME : $results[$i]->TOB_TIME ; @endphp
                @php $tob_mins = is_null($results[$i]->TOB_MINS) ? 00 : (strlen($results[$i]->TOB_MINS) == 1) ? '0'.$results[$i]->TOB_MINS : $results[$i]->TOB_MINS ; @endphp
                @php $tob_am   = is_null($results[$i]->TOB_AM)   ? 'N/A' : $results[$i]->TOB_AM; @endphp
                <tr>
                  <td>{{ $i+1 }}</td>
                    <td>{{  $results[$i]->BMrNo }}<br />{{  $results[$i]->BirthStatus }}</td>
                    <td>{{  $results[$i]->BabyName }}</td>
                    <td>{{  SiteHelpers::decode_gestation($results[$i]->Gestation) }}</td>
                    <td>{{  $results[$i]->BirthWeight }}</td>                                
                    <td>{{  $results[$i]->Sex }}</td>
                    <td>{{  date('d-m-Y',strtotime($results[$i]->DOB)) }}<br />{{  $tob_time.':'.$tob_mins.' '.$tob_am  }}</td>                                
                    <td>{{  $results[$i]->Conception }}</td>
                    <td>{{  $results[$i]->ModeOfDelivery }}</td>
                    <td>{{  $results[$i]->Status }}</td>
                    <td>{{  $results[$i]->DischargeWeight }}</td>
                    <td>@if($results[$i]->DateOfDischarge > '2010:10:10') {{ date('d-m-Y',strtotime($results[$i]->DateOfDischarge)) }} @endif</td>                                
                </tr>
              @endfor
              </tbody>
					  </table>
		      </div>        
          <!-- <div class="button-row">
            <div class="col-md-1">
        	    <a href="javascript:void(0);" onclick="window.print();" class="btn btn-primary hidden-print"><i class="fa fa-print"></i><span>Print</span></a>
            </div>
            <div class="col-md-1">
              <a href="{{ action('Reports\BirthReportController@index') }}" class="btn btn-default hidden-print"><i class="fa fa-exclamation-circle"></i><span>Cancel</span></a>
            </div>
          </div> -->
      </div>
    </div>
@endsection
