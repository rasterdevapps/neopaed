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
        width: 80vw;     
        margin: auto;    
    }
}
</style>
<div class="temp-container">
    <div class="col-md-12 col-xs-12 pl-must-0">
          <img src="{{ ValuelistHelpers::printPagelogo($hospital_name) }}">
        </div>
    <div class="col-md-12 col-xs-12 pl-must-0">
          <h3 class="print-head">NICU Report List</h3>
        </div>
	<div class="temp-row nicu-report col-md-12 overflow-auto mt-20">
      <table class="table table-striped">
				<thead>
          <tr>
            <th>S.No.</th>
            <th>{{ Lang::get('home.mrn') }}</th>
            <th>Name</th>
            <th>Birth status</th>
            <th>Wks</th>
            <th>B.Wt</th>
            <th>Sex</th>
            <th class="custom-date">DOB</th>
            <th class="custom-date">DOA</th>
            <th class="custom-date">DOL</th>
            <th>Status</th>
            <th>D.Wt</th>                                
            <th class="custom-date">DOD</th> 
          </tr>
        </thead>
        <tbody>
        @for ($i = 0; $i <  @count($results); $i++)
          <tr>
            <td>{{  $i+1 }}</td>
            <td>{{  $results[$i]->BMrNo }}</td>
            <td>{{  $results[$i]->BabyName }}</td>
            <td>{{  $results[$i]->BirthStatus }}</td>
            <td>{{  ValuelistHelpers::formateGestation($results[$i]->Gestation) }}</td>
            <td>{{  $results[$i]->BirthWeight }}</td>
            <td>{{  $results[$i]->Sex }}</td>
            <td>{{  date('d-m-Y',strtotime($results[$i]->DOB)) }}<br />{{  date('H:i:s',strtotime($results[$i]->TOB)) }}</td>
            <td>{{  date('d-m-Y',strtotime($results[$i]->AdmissionDate)) }}</td>
            <td>{{  $results[$i]->DOLatDischarge }}</td>
            <td>{{  $results[$i]->status }}</td>
            <td>{{  $results[$i]->DischargeWeight }}</td>
            <td>{{  date('Y', strtotime($results[$i]->DischargeDate)) > 1970 ? date('d-m-Y',strtotime($results[$i]->DischargeDate)) : '' }}</td>                                                                                                                                
          </tr>
        @endfor
        </tbody>
			</table>         
	</div> 
</div>         
@endsection
@section('scripts')
<script type="text/javascript">
    var container_ht = $('.container').height();
    console.log($('body').height());
</script>
@endsection
