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
   <div class="col-md-12 col-xs-12">
          <img src="{{ ValuelistHelpers::printPagelogo() }}" >
        </div>  
   <div class="col-md-12 col-xs-12">
          <h3 class="print-head">Cranial Ultrasonography List</h3>
    </div>
  <div class="temp-row col-md-12 carnial-ultrasound-report overflow-auto mt-15">
    
      <table class="table table-striped">
        <thead>
                <tr>
                  <th>S.No.</th>
                  <th>{{ Lang::get('home.mrn') }}</th>
                  <th>Name</th>
                  <th>Wks</th>
                  <th>B.Wt</th>
                  <th>Sex</th>
                  <th class="custom-date">DOB</th>
                  <th class="custom-date">Date of cranial</th>                                
                  <th>Impression</th>                                                                
                  <th>Done by consultant</th>
                </tr>
        </thead>
        <tbody>
                @for ($i = 0; $i <  @count($results); $i++)
                  <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{  $results[$i]->BMrNo }}</td>
                    <td>{{  $results[$i]->BabyName }}</td>
                    <td>{{  SiteHelpers::decode_gestation($results[$i]->Gestation) }}</td>
                    <td>{{  $results[$i]->BirthWeight }}</td>
                    <td>{{  $results[$i]->Sex }}</td>
                    <td>{{  date('d-m-Y', strtotime($results[$i]->DOB)) }}</td>
                    <td>{{  date('d-m-Y', strtotime($results[$i]->TestDate)) }}</td>
                    <td>{!!  strip_tags($results[$i]->Impression) !!}</td>
                    <td>{{  isset($doctorsMaster[$results[$i]->SeenBy]) ?  $doctorsMaster[$results[$i]->SeenBy] : ''  }}</td>                                
                  </tr>
                @endfor
        </tbody>
      </table>
 </div>
</div>
@endsection
