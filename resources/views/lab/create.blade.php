@extends('app')
@section('content')

<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
		<li><a href="{{ action('Lab\LabRequestController@index') }}">Lab Request</a></li>       
		<li class="current"><a>Create</a></li>                                                 
	</ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row-spacing">
	<div class="col-md-12 pt-15 plr-0 tab-view-shadow">
    {!! Form::model($baby,['url' =>  action('Lab\LabRequestController@store'),'id' => 'lab-request-form']) !!}            		
    <div class="col-md-4">
      {!! Form::hidden('baby_id', $baby->BabyId) !!}  
        <div class="form-group">
            {!! Form::label('test_date','Request Date:') !!}
            {!! Form::text('test_date',date('d-m-Y'),['class'=>'form-control datepicker']) !!}
        </div> 
        <div class="form-group">
            {!! Form::label('baby_mrn', Lang::get('home.mrn').':') !!}
            {!! Form::text('baby_mrn',$baby->BMrNo,['class'=>'form-control','readonly']) !!}
        </div> 
        <div class="form-group">
            {!! Form::label('ip_number', Lang::get('home.ip') !!}
            {!! Form::text('ip_number',@$ip_number->ip_number,['class'=>'form-control'])!!}
        </div>                          
        <div class="form-group">
          {!! Form::label('baby_name','Baby Name:') !!}
          {!! Form::text('baby_name',$baby->BabyName,['class'=>'form-control','readonly']) !!}
        </div>
                                           
        <div class="form-group">
            {!! Form::label('sex','Sex:') !!}
            {!! Form::select('sex',['Male'=>'Male','Female'=>'Female','Indeterminate'=>'Indeterminate'],$baby->Sex,['class'=>'form-control','disabled']) !!}
        </div>                                              
        <div class="form-group">
            {!! Form::label('dob','DOB:') !!}
            {!! Form::text('dob',$baby->DOB,['class'=>'form-control datepicker']) !!}
        </div> 
         
         <div class="form-group">
            {!! Form::label('department', 'Department:') !!}    
            {!! Form::select('department',['N/A'=>'N/A']+$master_department, null,['class'=>'select2-select-00 full-width']) !!}
        </div>
         <div class="form-group">
            {!! Form::label('order_physician','Ordering Physician:') !!}
           <span class="master-icons mas-order-physician hide" href="javascript:void(0);">M</span>
           <br/>
            {!! Form::select('order_physician',['N/A'=>'N/A']+$master_doctor,null,['class'=>'select2-select-00 full-width']) !!}
        </div>  
                                      
    </div>
    <div class="col-md-4">
       
        <div class="form-group">
            {!! Form::label('AdmissionTime','Request Time:') !!}
            <table>
                <tr>
                   <td> 
                       {!! Form::select('admission_time',$admission['time'],$time['admission_time'],['class'=>'form-control input-width-small mr-15']) !!}
                   </td>
                   <td class="padding-rl"> 
                       {!! Form::select('admissiontime_mins',$admission['mins'],$time['admissiontime_mins'],['class'=>'form-control input-width-small mr-15']) !!}
                   </td>
                   <td> 
                       {!! Form::select('admissiontime_sesstion',$admission['session'],$time['admissiontime_sesstion'],['class'=>'form-control input-width-small']) !!}
                   </td>
               </tr>
            </table>
        </div>
        <div class="form-group">
            {!! Form::label('credit', 'Credit:') !!}
            {!! Form::checkbox('credit', 'Yes'); !!}
        </div>

        <div class="form-group">
            {!! Form::label('stat', 'STAT:') !!}
            {!! Form::checkbox('stat', 'Yes'); !!}
        </div>

        <div class="form-group">
            {!! Form::label('scheduled', 'Scheduled:') !!}
            {!! Form::checkbox('scheduled', 'Yes'); !!}
        </div>   
        <div class="form-group">
            {!! Form::label('scheduled_date','Scheduled Date:') !!}
            {!! Form::text('scheduled_date',null,['class'=>'form-control datepicker']) !!}
        </div>   

        <div class="form-group scheduled_times">
            {!! Form::label('scheduled_time','Scheduled Time:') !!}
            <table>
                <tr>
                   <td> 
                       {!! Form::select('scheduled_time',$admission['time'],null,['class'=>'form-control input-width-small mr-15']) !!}
                   </td>
                   <td class="padding-rl"> 
                       {!! Form::select('scheduled_mins',$admission['mins'],null,['class'=>'form-control input-width-small mr-15']) !!}
                   </td>
                   <td> 
                       {!! Form::select('scheduled_sesstion',$admission['session'],null,['class'=>'form-control input-width-small']) !!}
                   </td>
               </tr>
            </table>
        </div>                              

        <div class="form-group">
        	{!! Form::label('collection_site', 'Collection Site:') !!}	
            <span class="master-icons mas-collecton-site" href="javascript:void(0);">M</span>
            <br/>
        	{!! Form::select('collection_site',[''=>'N/A']+$collection_sites,null,['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
        	{!! Form::label('collection_method', 'Collection Method:') !!}
           <span class="master-icons mas-collecton-method" href="javascript:void(0);">M</span>
        	{!! Form::select('collection_method',[''=>'N/A']+$collection_method,null,['class'=>'form-control']) !!}
        </div>

         <div class="col-md-6 col-sm-6 col-xs-6">
            <ul class="lab-package-title" data-short-code="8112">
                 <li><u>Vit D Package</u></li>
            </ul> 
             <ul class="lab-package-content"> 
                 <li>Vit D(25 OH D3)</li>
                 <li>PTH</li>
                 <li>CA</li>
                 <li>ALP</li>
                 <li>Phosphorus</li>
             </ul>
             <ul class="lab-package-title" data-short-code="8119">
                 <li><u>Thyroid</u></li>
             </ul> 
              <ul class="lab-package-content"> 
                 <li>TSH</li>
                 <li>Free T4</li>
                 <li>Free T3</li>
              </ul>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-6">
             <ul class="lab-package-title" data-short-code="8111">
                <li><u>TPN Package</u></li>
             </ul> 
             <ul class="lab-package-content">
                 <li>Na</li>
                 <li>K</li>
                 <li>Urea</li>
                 <li>Creatinine</li>
                 <li>Calcium</li>
             </ul>
        </div>

                                          
    </div>
    <div class="col-md-4 col-sm-12 col-xs-12">
        <div class="col-md-6 col-sm-6 col-xs-6">
            <ul class="lab-package-title" data-short-code="2">
              <li><u>Admission Package</u></li>
            </ul>
            <ul class="lab-package-content">
                 <li>CBC</li>
                 <li>CRP</li>
                 <li>Blood Culture</li>
                 <li>Blood Group</li>
             </ul>
            <ul class="lab-package-title" data-short-code="3">
              <li><u>Sepsis Package</u></li>
            </ul>
            <ul class="lab-package-content">
                <li>CBC</li>
                <li>CRP</li>
                <li>Blood Culture</li>
            </ul>

             <ul class="lab-package-title" data-short-code="8114">
                <li><u>Coltting</u></li>
            </ul> 
            <ul class="lab-package-content">
                <li>APTT</li>
                <li>PT</li>
                <li>INR</li>
            </ul> 

            
        </div>
        <div class="col-md-6 col-sm-6 col-xs-6">
            <ul class="lab-package-title" data-short-code="8116">
               <li><u>Advanced jaundice Package</u></li>
            </ul>
            <ul class="lab-package-content">
             <li>LFT</li>
             <li>PS</li>
             <li>CBC</li>
             <li>Reticulocyte</li>
             <li>DCT</li>
            </ul>
           
            <ul class="lab-package-title" data-short-code="8117">
              <li><u>Bone Profile</u></li>
            </ul>
            <ul class="lab-package-content">
             <li>Cal</li>
             <li>Phosphorus</li>
             <li>ALP</li>
            </ul> 
             <ul class="lab-package-title" data-short-code="8118">
               <li><u> Full Blood Gas</u></li>
            </ul>
            <ul class="lab-package-content">
                <li>PH</li>
                <li>Pao2</li>
                <li>PaCo2</li>
                <li>HCo3</li>
                <li>BE</li>
                <li>Na</li>
                <li>K</li>
                <li>Calcium</li>
                <li>Cl<sup>-</sup></li>
                <li>HB</li>
                <li>PCV</li>
                <li>Lactate</li>
                <li>Bilirubin</li>
                <li>Sugar</li>
                <li>Methemoglobin</li>
            </ul> 
        </div>
    </div> 

    <div class="col-md-12">
        <div class="form-group full-width display-inline-block">
            {!! Form::label('diagnosis', 'Diagnosis:') !!}  
           <span class="master-icons mas-diagnosis-add" href="javascript:void(0);">M</span>

            {!! Form::Select('diagnosis[]',['0'=>'N/A']+$diagnosis,null,['class'=>'select2-select-00 full-width-fix','multiple']) !!}
        </div> 
    </div>
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('symptoms', 'Symptoms:') !!}    
            {!! Form::text('symptoms', null,['class'=>'form-control']) !!}
        </div> 
    </div>
    <div class="col-md-12">
        <div class="form-group">
           {!! Form::label('investigations', 'Investigations:') !!} 
           {!! Form::select('investigations[]',['0'=>'N/A']+$master_investigations,null,['class'=>'select2-select-00 full-width-fix','multiple']) !!}
        </div>
    </div>
    <div class="col-md-12">
       <div class="form-group">
            {!! Form::label('associate_doctor','Associate Doctor') !!}
            {!! Form::select('associate_doctor',[''=>'N/A']+$associate_doctors,null,['class'=>'select2-select-00 col-md-12 full-width-fix']) !!}
       </div>  
    </div>
    
    

    <div class="row col-md-11 ptb-20">
        <input type="hidden" name="print_flag" value="0" id="print_flag"/>

      <div class="col-md-3 col-sm-4 col-xs-12 hide">
         <button type="button" onclick="$('#print_flag').val('1'); $('#lab-request-form').submit();"   class="btn btn-primary btn-block save-button-shadow form-control">
            <i class="fa fa-floppy-o"></i> <span>Save</span>
          </button>
      </div>
      <div class="col-md-3 col-sm-4 col-xs-12">
           <button type="button"  onclick="$('#print_flag').val('2'); $('#lab-request-form').submit();"  class="btn btn-primary btn-block save-button-shadow form-control">
            <i class="fa fa-floppy-o"></i> <span>Save</span>
          </button>
      </div>                   
      <div class="col-md-3 col-sm-4 col-xs-12">
          <a href="{{ action('Lab\LabRequestController@index') }}" class="btn btn-default save-button-shadow btn-block form-control" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> <span>Cancel</span></a>
      </div>
    </div>                           
     {!! Form::close() !!}
	</div> <!-- /.col-md-12 -->                    
</div> <!-- /.row -->
				<!-- /Page Content -->
@endsection
@include('lab.lab_master')
@section('scripts')
@include('lab.lab_master_script')
<script type="text/javascript">
$('#department').change(function() {
    var departmentId = $(this).val();
     $.ajax({
            type:'GET',
            url:'{{ url("lab-request-investigation") }}'+'/'+departmentId,
            beforeSend:function() {

            },
            success:function(responseText) {
                  var options = '';
                $.each(responseText.data,function(index, value) {
                    options += '<option value="'+index+'">'+value+'</option>';
                });
                $('select[name="investigations[]"]').html(options);
            },
            complete:function(responseText) {

            },
            error:function(responseText) {

            }

          });
});

// $('select[name="department"]').val('3').trigger('change');

$('.lab-package-title').dblclick(function() {
    var testValue = $('select[name="investigations[]"]').val();

      if(testValue == null) {
        testValue = []
        testValue.push($(this).data('short-code'));
        $('select[name="investigations[]"]').select2("val", testValue).trigger('change');    
      } else {
        testValue.push($(this).data('short-code'));
         $('select[name="investigations[]"]').select2("val", testValue).trigger('change');    

      } 


});

function schdeuledLabTest() {

   if($('input[name="scheduled"]').prop('checked') == true) {
    $('#scheduled_date').attr('disabled',false).parent().slideDown();

    $('.scheduled_times').slideDown();
   } else {
    $('#scheduled_date').attr('disabled', true).parent().slideUp();
    $('.scheduled_times').slideUp();
   }
}

$('input[name="scheduled"]').click(function() {
    schdeuledLabTest();
});
schdeuledLabTest();
    
$('.container').addClass('lab-request');

</script>
@endsection
