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
				<h3 class="print-head">Culture Registry List</h3>
				<div class="">
                       <div class="col-md-1 pull-right">
                           <a href="javascript:void(0);" onclick="window.print();" class="btn btn-primary hidden-print"><i class="fa fa-print"></i><span>Print</span></a>
                      </div>
                        <table class="table table-striped col-md-12">
						<thead>
                        	<tr>
                            	<th>S.No.</th>
                            	<th>{{ Lang::get('home.mrn') }}</th>
                            	<th>Name</th>
                            	<th>Wks</th>
                            	<th>B.Wt</th>
                            	<th>Sex</th>
                                <th>DOB</th>
                            	<th>Date of Collection</th>                                
                            	<th>Nature of Specimen</th>                                                                
                            	<th>Isolate</th>
                            </tr>
                        </thead>
                        <tbody>
                	    @for ($i = 0; $i <  @count($results); $i++)
                        	<tr>
                            	<td>{{ $i+1 }}</td>
                                <td>{{  $results[$i]->BMrNo }}</td>
                                <td>{{  $results[$i]->BabyName }}</td>
                                <td>{{  $results[$i]->Gestation }}</td>
                                <td>{{  $results[$i]->BirthWeight }}</td>
                                <td>{{  $results[$i]->Sex }}</td>
                                <td>{{  date('d-m-Y',strtotime($results[$i]->DOB)) }}</td>
                                <td>@if($results[$i] -> CollectionDate> '2000-01-01') {{ date('d-m-Y',strtotime($results[$i]->CollectionDate))  }} @endif</td>
                                <td>{{  $results[$i]->Specimen }}</td>
                                <td>{{  $results[$i]->Isolate }}</td>                                
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
        <a href="{{ action('Reports\CultureReportController@index') }}" class="btn btn-default hidden-print"><i class="fa fa-exclamation-circle"></i><span>Cancel</span></a>
      </div>
  </div>
  </div>
</div>
@endsection
