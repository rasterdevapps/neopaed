@extends('print')
@section('content')
<style>
@media print{@page {size: landscape}
.container{
	width:100%;
	margin:0;
}
}
</style>
<div class="temp-container">
	<div class="temp-row">
		<div class="">
				<h3 class="print-head">Pediatric Report List</h3>
				<div class="">
                       <div class="col-md-3 pull-right">
                           <a href="javascript:void(0);" onclick="window.print();" class="btn btn-primary hidden-print"><i class="fa fa-print"></i><span>Print</span></a>
                      </div>
                        <table class="table table-striped col-md-12">
						<thead>
                        	<tr>
                            	<th>S.No.</th>
                            	<th>{{ Lang::get('home.mrn') }}</th>
                            	<th>Name</th>
                                <th>Age</th>
                            	<th>Sex</th>
                            	<th>DOA</th>
                            	<th>Final Diagnosis</th>
                            	<th>Status</th>                                
                            	<th>D.Wt</th>
                            	<th>DOD</th>                                                                
                                                                                                
                            </tr>
                        </thead>
                        <tbody>
                	    @for ($i = 0; $i <  @count($results); $i++)
                        	<tr>
                            	<td>{{ $i+1 }}</td>
                                <td>{{  $results[$i]->BMrNo }}</td>
                                <td>{{  $results[$i]->BabyName }}</td>
                                <td>{{  $results[$i]->AgeOnAdmission }}</td>
                                <td>{{  $results[$i]->Sex }}</td>
                                <td>{{  date('d-m-Y',strtotime($results[$i]->AdmissionDate)) }}</td>                                <td>{{  $results[$i]->FinalDiagnosis }}</td>
                                <td>{{  $results[$i]->Status }}</td>
                                <td>{{  $results[$i]->DischargeWeight }}</td>
                                <td>@if($results[$i]->DischargeDate > '2010:10:10') {{ date('d-m-Y',strtotime($results[$i]->DischargeDate)) }} @endif</td>                                
                            </tr>
                		@endfor
                        </tbody>
					</table>
           
		    </div>        
  <div class="button-row">
       <div class="col-md-1">
    	   <a href="javascript:void(0);" onclick="window.print();" class="btn btn-primary hidden-print"><i class="fa fa-print"></i><span>Print</span></a>
      </div>
      <div class="col-md-1">
        <a href="{{ action('Reports\PediatricReportController@index') }}" class="btn btn-default hidden-print"><i class="fa fa-exclamation-circle"></i><span>Cancel</span></a>
      </div>
  </div>
  </div>
</div>
@endsection
