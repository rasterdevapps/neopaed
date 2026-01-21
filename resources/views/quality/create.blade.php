@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<link rel="stylesheet" type="text/css" href="{{ url('/')}}/public/css/mdtimepicker.min.css">
<script src="{{ url('/') }}/public/js/mdtimepicker.min.js"></script>
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
		<li><a href="{{ action('Quality\QualityController@index') }}"> Quality Indicator</a></li>
        <li class="current"><a>Create Baby</a></li>                                                
	</ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row quality row-spacing">
	<div class="col-md-12">


	{!! Form::model(null,['method' => 'POST','action' => 'Quality\QualityController@store' ,'id'=> 'quality-indicator-form','class'=>'form-horizontal']) !!}
	  <div role="tabpanel" class="tabbable tabbable-custom">
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="active"> <a href="#form-1" role="tab" data-toggle="tab">Form 1</a></li>
          <li role="presentation"><a href="#form-2" role="tab" data-toggle="tab">Form 2</a></li>
          <li role="presentation"><a href="#form-3" role="tab" data-toggle="tab">Form 3</a></li>
        </ul>  

        <div class="tab-content tab-view-shadow">
          {!! Form::hidden('babyId', $baby_details->BabyId) !!}
          <div role="tabpanel" class="tab-pane active" id="form-1">
            @include('quality.quality_form_first')
          </div>
          <div role="tabpanel" class="tab-pane" id="form-2">
					  @include('quality.quality_form_second')
          </div>
          <div role="tabpanel" class="tab-pane" id="form-3">
					  @include('quality.quality_form_third')
          </div>
        <div class="col-md-12 pt-10">
  	        <input type="hidden" name="save_flag" id="save_flag" value="1">
  	        <input type="hidden" name="save_next" id="save_next" value="form-1">
  	        <div class="col-md-4 col-sm-4 pt-10">
  	            <button type="button" onclick="update();" class="btn btn-primary btn-shadow  save-next form-control"><i class="fa fa-floppy-o"> Save Next</i></button>
  	        </div> 
  	        <div class="col-md-4 col-sm-4 pt-10">
  	            <button type="button" onclick="completeForm();" class="btn btn-info btn-shadow form-control save-close"><i class="fa fa-floppy-o"> Save & Close</i></button>
  	        </div>
  	        <div class="col-md-4 col-sm-4 pt-10">
  	           <button  type="button" onclick="moveTobaby();" class="btn btn-warning btn-shadow form-control"><i class="fa fa-exclamation-circle"> Cancel</i></button>
  	        </div>
        </div>  
        </div> 

             
        {!! Form::close(); !!}             	
	 
	</div> <!-- /.col-md-12 -->
</div> <!-- /.row -->
<!-- /Page Content -->     
@endsection
@section('scripts')
<script type="text/javascript">
	$(".submitbtn").click(function(){
  		selectval = $("#BabyId option:selected").val();
  		window.location = $(".cancel-btn").attr('href')+'/'+selectval;	

   });

  function completeForm() {
    $('#save_next').val('form-1');
    $('#save_flag').val('1');
    if ($('#quality-indicator-form').valid() === true) {
              $('.save-close').prop('disabled', true);

              $('.save-close').html('<i class="fas fa-spinner fa-pulse"></i> Loading...');

      $('#quality-indicator-form').submit();
    }
  }
  function update() {

    var currentMenu = $('.nav.nav-tabs  .active').children('li').children('a').attr('href');
     if(currentMenu == '#form-3') {

          $('#save_flag').val('1');
          if ($('#quality-indicator-form').valid() === true) {
            $('#quality-indicator-form').submit();
          }

     } else {

          $('#save_next').val($('.nav.nav-tabs  .active').next('li').children('a').attr('href'));
          $('#save_flag').val('0');
          if ($('#quality-indicator-form').valid() === true) {

              $('.save-next').prop('disabled', true);

              $('.save-next').html('<i class="fas fa-spinner fa-pulse"></i> Loading...');

              $('#quality-indicator-form').submit();
          }
     }
  }

  $('.nav.nav-tabs li a').click(function() {

     if ($(this).attr('href') == '#form-3') {

      $('.save-next').text('Finish');

     } else {
       $('.save-next').text('Save Next');
     }

  });

 //hanldeRecorder();

    $('#dob').datepicker({
        dateFormat: 'dd-mm-yy'
    });


  function moveTobaby() {
      window.location = "{{ action('Quality\QualityController@index') }}";  
  }

  $('#quality-indicator-form').validate({
    rules: {
      mr_number: "required"
    }
  });

  $('#tob').mdtimepicker();

</script>
@endsection



 

