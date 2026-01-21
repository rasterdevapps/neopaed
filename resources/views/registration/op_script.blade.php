<script type="text/javascript">
var currentStatus = [];
var development = [];
var examination = [];
var diagnosis = [];
var advice =[];

@if(isset($ac_current_status) && !empty($ac_current_status))
 @foreach($ac_current_status as $status)

     currentStatus.push('{{ $status }}');

 @endforeach

@endif


@if(isset($ac_current_status) && !empty($ac_current_status))
  @foreach($ac_development as $status)

     development.push('{{ $status }}');

 @endforeach
@endif


@if(isset($ac_current_status) && !empty($ac_current_status))
 @foreach($ac_examination as $status)

     examination.push('{{ $status }}');

 @endforeach
@endif

@if(isset($ac_current_status) && !empty($ac_current_status))
 @foreach($ac_diagnosis as $status)

     diagnosis.push('{{ $status }}');

 @endforeach
@endif

@if(isset($ac_current_status) && !empty($ac_current_status))
  @foreach($ac_advice as $status)

     advice.push('{{ $status }}');

 @endforeach
@endif



 $('#Complaints').autoCompleteRaster({
    statements:currentStatus,
 }); 

 $('#Development').autoCompleteRaster({
    statements:development,
 }); 

 $('#Examination').autoCompleteRaster({
    statements:examination,
 });

 $('#Diagnosis').autoCompleteRaster({
    statements:diagnosis,
 });
  
 $('#Advice').autoCompleteRaster({
    statements:advice,
 }); 

@if(@$results->neurosonogram == 2)

   $('#neurosonogram').bootstrapToggle('on');

@endif

@if(@$results->echocardiogram == 2)

   $('#echocardiogram').bootstrapToggle('on');

@endif

@if(@$results->fee_status == 1)
   
   $('#fee_status').bootstrapToggle('on');
   
@endif

@if(@$results->need_neuro == 1)
   
   $('#need_neuro').bootstrapToggle('on');
   
@endif
</script>
