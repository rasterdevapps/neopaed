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
  <div class="col-md-12 col-sm-12 col-xs-12">
          <img src="{{ ValuelistHelpers::printPagelogo($hospital_name) }}" >
        </div>
  <div class="col-md-12 col-sm-12 col-xs-12">
          <h3 class="print-head">Newborn Report List</h3>
  </div>
	
		<div class="col-md-12 col-sm-12 col-xs-12 mt-15">
			<div class="nb-report overflow-auto">
       
        <table class="table table-striped col-md-12">
					<thead>
            <tr>
              <th>S.No.</th>
              <th>{{ Lang::get('home.mrn') }}</th>
              <th>Name</th>
              <th>Gestation</th>
              <th>Birth weight</th>
              <th>Sex</th>
              <th class="custom-date">DOB</th>
              <th>Newborn screen</th>                                
            </tr>
          </thead>
          <tbody>
          @for ($i = 0; $i <  @count($results); $i++)
            @if(isset($results[$i]))
            <tr>
              <td>{{ $i+1 }}</td>
              <td>{{ $results[$i]->BMrNo }}</td>
              <td>{{ $results[$i]->BabyName }}</td>
              <td>{{ SiteHelpers::decode_gestation($results[$i]->Gestation) }}</td>
              <td>{{ $results[$i]->BirthWeight }}</td>
              <td>{{ $results[$i]->Sex }}</td>
              <td>@if(date('Y',strtotime($results[$i]->DOB)) > 1970) {{ date('d-m-Y',strtotime($results[$i]->DOB)) }} @endif</td>                                
              <td>{{ $results[$i]->NewBornScreen }}</td>
            </tr>
            @endif
          @endfor
          </tbody>
					</table>
		  </div>        
      <div class="button-row hide">
        <div class="col-md-1">
    	     <a href="javascript:void(0);" onclick="window.print();" class="btn btn-primary hidden-print"><i class="fa fa-print"></i><span>Print</span></a>
        </div>
        <div class="col-md-1">
           <a href="{{ action('Reports\NbReportController@index') }}" class="btn btn-default hidden-print"><i class="fa fa-exclamation-circle"></i><span>Cancel</span></a>
        </div>
      </div>
  </div>
</div>
@endsection
