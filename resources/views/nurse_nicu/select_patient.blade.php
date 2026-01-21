@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
		<li><a href="{{ action('Nurse\NicuNurseDaycareController@index') }}">Daycare</a></li>
        <li class="current"><a>Choose Baby</a></li>                                                
	</ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing select-container-main">
	<div class="col-md-6 col-sm-6 col-xs-6">
        <div class="row select-option-container">
            <div class="col-md-12">
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                    	{!! Form::label('BabyId','Select Baby:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                    	{!! Form::Select('BabyId',$babies,null,['class'=>'select2-select-00 full-width-fix input-fields-shadow']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                    	{!! Form::label('Admission_id','Select Admission:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                    	{!! Form::Select('Admission_id',['0'=>'-- Select Admission --'],null,['class'=>'select2-select-00 full-width-fix input-fields-shadow']) !!}
	                  	<span class="error-admission"></span>
                    </div>
                </div>
			</div>
            <div class="col-md-12 mt-15">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <button type="submit"  class="btn btn-success save-button-shadow submitbtn form-control btn-block">
                        <i class="fa fa-forward"></i> 
                        <span>{!! $SubmitButtonText !!}</span>
                    </button>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <a href="{{ action('Nurse\NicuNurseDaycareController@index') }}" class="cancel-btn save-button-shadow btn btn-default form-control btn-block" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> <span>Cancel</span></a>
                </div>
            </div>                           
        </div>
	</div> <!-- /.col-md-12 -->
</div> <!-- /.row -->
<!-- /Page Content -->     
@endsection
@section('scripts')
<script type="text/javascript">
$(".submitbtn").click(function(){
		selectval = $("#Admission_id option:selected").val();
		if(selectval!=0){
            $('.error-admission').html('Please Select Admission !').fadeOut('slow');

				window.location = $(".cancel-btn").attr('href')+'/'+selectval;

	     }else{

            $('.error-admission').html('Please Select Admission !').fadeIn('slow');

	     }			
			
});
  function get_admission(){
  	  	  var babyID = $('#BabyId').val();

	  if(babyID!=0){
	  	  $.ajax({
	               type:'GET',
	               url:"{{ url('nurse-nicu-daycare-admission') }}"+'/'+babyID,
	               beforeSend:function(){

	               	$('.submitbtn').html('<i class="fa fa-forward"></i><span>{!! $SubmitButtonText !!}</span><i class="fa fa-spinner fa-spin"></i>').attr('disabled',true);

	               },
	               success:function(responseText){
	                  var admissionOption='';
	                  $.each(responseText.data,function(index,value){
	                  	admissionOption +='<option value='+index+'>'+value+'</option>'; 
	                  });
	                 $('#Admission_id').html(admissionOption);
	                 $('.submitbtn').html('<i class="fa fa-forward"></i><span>{!! $SubmitButtonText !!}</span>').removeAttr('disabled');
	               },
	               error:function(){
	               	   $('.submitbtn').html('<i class="fa fa-forward"></i><span>{!! $SubmitButtonText !!}</span>').attr('disabled',true);
	               }   

	  	         });
	 }else{
	 	   $('.submitbtn').html('<i class="fa fa-forward"></i><span>{!! $SubmitButtonText !!}</span>').attr('disabled',true);

	 }

  }

  $('#BabyId').change(function(){
     get_admission();
  });
  get_admission();
</script>
@endsection



