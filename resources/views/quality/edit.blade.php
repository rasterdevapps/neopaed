@extends('app')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ url('/')}}/public/css/mdtimepicker.min.css">
<script src="{{ url('/') }}/public/js/mdtimepicker.min.js"></script>
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
		<li><a href="{{ action('Quality\QualityController@index') }}"> Quality Indicator</a></li>
        <li class="current"><a>Edit Baby</a></li>                                                
	</ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row quality row-spacing">
	<div class="col-md-12">
	{!! Form::model($baby_basic,['method' => 'PATCH','url' => action('Quality\QualityController@update',$id) ,'id'=> 'quality-indicator-form','class'=>'form-horizontal']) !!}
	  <div role="tabpanel" class="tabbable tabbable-custom">
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation"  class="@if($menu == '#form-1') active @endif" > <a href="#form-1" role="tab" data-toggle="tab">Form 1</a></li>
          <li role="presentation"  class="@if($menu == '#form-2') active @endif" ><a href="#form-2" role="tab" data-toggle="tab">Form 2</a></li>
          <li role="presentation"  class="@if($menu == '#form-3') active @endif" ><a href="#form-3" role="tab" data-toggle="tab">Form 3</a></li>
        </ul>    
        <div class="tab-content tab-view-shadow">
          <div role="tabpanel" class="tab-pane @if($menu == '#form-1') active @endif" id="form-1">
            @include('quality.quality_form_first')
          </div>
          <div role="tabpanel" class="tab-pane @if($menu == '#form-2') active @endif" id="form-2">
					  @include('quality.quality_form_second')
          </div>
          <div role="tabpanel" class="tab-pane @if($menu == '#form-3') active @endif" id="form-3">
					  @include('quality.quality_form_third')
          </div>
        <div class="col-md-12 pt-10">
          <input type="hidden" name="save_flag" id="save_flag" value="0">
          <input type="hidden" name="save_next" id="save_next" value="form-1">
          <div class="col-md-4 col-sm-4 pt-10">
              <button type="button" onclick="update();" class="btn btn-primary update-next btn-shadow form-control">
                <i class="fa fa-floppy-o">
                  @if($menu == '#form-3')  
                   Finish
                  @else
                   Update Next
                  @endif
                </i>
              </button>
          </div>
          <div class="col-md-4 col-sm-4 pt-10">
              <button type="button" onclick="$('#save_next').val('form-step1');$('#save_flag').val('1');$('#quality-indicator-form').submit();" class="btn btn-info btn-shadow form-control"><i class="fa fa-floppy-o"> Update & Close</i></button>
          </div>
          <div class="col-md-4 col-sm-4 pt-10">
             <a  type="button" href="{{ action('Quality\QualityController@index') }}" class="btn btn-warning btn-shadow form-control"><i class="fa fa-exclamation-circle"> Cancel</i></a>
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
  function update() {

    var currentMenu = $('.nav.nav-tabs  .active').children('a').attr('href');     
     if(currentMenu == '#form-3') {

          $('#save_flag').val('1');
          $('#quality-indicator-form').submit();

     } else {

          $('#save_next').val($('.nav.nav-tabs  .active').next('li').children('a').attr('href'));
          $('#save_flag').val('0');
          $('#quality-indicator-form').submit();
     }
    
 

  }

  $('.nav.nav-tabs li a').click(function() {

     if ($(this).attr('href') == '#form-3') {

      $('.update-next').text('Finish');

     } else {
       $('.update-next').text('Update Next');
     }

  });

  $('#dob').datepicker({
    dateFormat: 'dd-mm-yy'
  });
  $('#tob').mdtimepicker();

</script>
@endsection



 

