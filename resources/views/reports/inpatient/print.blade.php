@extends('print')
@section('content')
@php $display = true; @endphp
<div class="temp-container in-patient-print">
  @if (count(\ValuelistHelpers::getHospitals()) > 1 )
    <div class="col-md-12 col-xs-12 pl-must-0 hidden-print text-center hospital_selection_container">
      <h3 class="error">Please choose "Hospital Name"</h3>
      {!! Form::select('hospital_name', [''=>'- - Select Hospital - -']+\ValuelistHelpers::getHospitals(), @$_GET['hospital_name'], ['class'=>'form-control input-width-medium display-inline-block-must mt-5 ml-15', 'id'=>'hospital-filter']) !!}
      <button class="btn btn-primary display-inline-block" id="inpatient-submit">Apply</button>
    </div>
  @endif
    <div class="col-md-12 col-xs-12 pl-must-0">
        <div class="col-md-4 col-sm-4 col-xs-4">
          <img src="{{ ValuelistHelpers::printPagelogo($hospital_name) }}" >
        </div>  
    </div>
    <div class="col-md-12 col-xs-12 pl-must-0">
        <div class="col-md-offset-3 col-md-5 col-sm-offset-3 col-sm-5 col-xs-offset-3 col-xs-5 plr-must-0 text-center">
              <h2 class="mt-0">NEONATAL UNIT</h2>
              <h3 class="print-head">Inpatient List</h3>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-4">
          <h3 class="pull-right">{!! date('M d, Y') !!}</h3>
        </div>
    </div>
    <div class="temp-row">
    <div class="">
         <div class="">
            
            <div class="col-md-12 col-xs-12">
              <div class="col-md-1 col-sm-1 col-xs-1 inpatient-list-head plr-must-0">
                <h3>R.No</h3>
              </div>
              <div class="col-md-5 col-sm-5 col-xs-5 inpatient-list-head">
                <h3>Baby Details</h3>
              </div>
              <div class="col-md-3 col-sm-3 col-xs-3 inpatient-list-head">
                <h3>Weight</h3>
              </div>
              <div class="col-md-3 col-sm-3 col-xs-3 inpatient-list-head">
                <h3>Instructions</h3>
              </div>
            </div>
            <div class="col-md-12 col-xs-12">
              <hr class="inpatient-header-line">
            </div>
            @if(count($results) > 0)  
              @for ($i = 0; $i <  @count($results); $i++)
                @php $tob_time = is_null($results[$i]->TOB_TIME) ? 00 : (strlen($results[$i]->TOB_TIME) == 1) ? '0'.$results[$i]->TOB_TIME : $results[$i]->TOB_TIME ; @endphp
                @php $tob_mins = is_null($results[$i]->TOB_MINS) ? 00 : (strlen($results[$i]->TOB_MINS) == 1) ? '0'.$results[$i]->TOB_MINS : $results[$i]->TOB_MINS ; @endphp
                @php $tob_am   = is_null($results[$i]->TOB_AM)   ? 'N/A' : $results[$i]->TOB_AM; @endphp
                <div class="col-md-12 col-xs-12 inpatient-list">
                  <div class="col-md-1 col-sm-1 col-xs-1 inpatient-list-inner-first">
                    <span> {{ $i+1 }} </span>
                  </div> 
                  <div class="col-md-5 col-sm-5 col-xs-5 inpatient-list-inner">
                        <div><h5>{{  $results[$i]->BabyName }}</h5></div>
                        <div>{{  $results[$i]->BMrNo }}</div>
                        @php $gestation = SiteHelpers::decode_gestation($results[$i]->Gestation) ; @endphp
                        <div>{{  ($gestation == '') ? 'N/A' : $gestation }} / {{ $results[$i]->BirthWeight }} / {{ $results[$i]->Sex }} </div>
                        <div>{{  date('d-m-Y', strtotime($results[$i]->DOB)) }} / {{ $tob_time.':'.$tob_mins.' '.$tob_am }} </div>
                        <div>{{  $results[$i]->ModeOfDelivery }}</div>
                  </div>
                  <div class="col-md-3 col-sm-3 col-xs-3 inpatient-list-inner">
                    
                  </div>
                  <div class="col-md-3 col-sm-3 col-xs-3 inpatient-list-inner">
                    
                  </div>
                </div>   
                @endfor
            @else 
             <div class="col-md-12 col-xs-12 inpatient-list-head">
                <h3> No Record Found</h3>
             </div>
            @endif   
          </div>        
      </div>
    </div>
@endsection
@section('scripts')
<script type="text/javascript">
  $(document).ready(function() {
    $('#inpatient-submit').on('click', function() {
      var hospital_name = $('#hospital-filter').val();
      window.location = window.location.href.split('?')[0] + '?hospital_name='+hospital_name;
    });
  });
</script>
@endsection
