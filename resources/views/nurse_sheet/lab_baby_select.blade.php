@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
		<li><a href="javascript:void(0);">Lab Report</a></li>
        <li class="current"><a>Choose Baby</a></li>                                                
	</ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
@if($type == '')
<div class="row row-spacing select-container-main">
	<div class="col-md-6 col-sm-6 col-xs-6">
        <div class="row select-option-container">
            <div class="col-md-12">
                {!! Form::hidden('select_field_data', $babies) !!}
                @include('select',  [
                    'label_name' => 'Select Baby:',
                    'placeholder' => '-- Select patient --'
                ])
			</div>
            <div class="col-md-12 ">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <button type="submit"  class="btn btn-success submittbtn save-button-shadow form-control btn-block">
                        <i class="fa fa-forward"></i> 
                        <span>{!! $SubmitButtonText !!}</span>
                    </button>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <a href="{{ action('Nurse\NurseSheetController@labBabySelect') }}" class="cancel-btn btn save-button-shadow btn-default form-control btn-block" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> <span>Cancel</span></a>
                </div>
            </div>                           
        </div>
	</div> <!-- /.col-md-12 -->
</div> <!-- /.row -->
<!-- /Page Content -->     
<script type="text/javascript">
$(document).ready(function() {
	$(".submittbtn").click(function() {
		var baby_id = $("#ssearch").val();
		if(baby_id != 0) {	    
	    	$('.error-admission').fadeOut('slow');
	    	window.location = "{{ url('lab-value-print/') }}?mrn=" +baby_id+ "&closewinlink=main&admission_id=0";
		} else {
			$('.error-admission').html('Please Select Admission !').fadeIn('slow');
		}				
	});
});
</script>
@else
<style type="text/css">
	#select-container > span:last-child {
		display: none;
	}
	#select_baby {
		display: none;
	}
	.select2-hidden-accessible {
	     -webkit-clip-path: unset !important; 
	     clip-path: unset !important; 
	     height: unset !important; 
	     position: unset !important; 
	     width: 103% !important; 
	     padding: 0px !important;
	}
</style>
<div class="row row-spacing select-container-main">
	<div class="col-md-6 col-sm-6 col-xs-6">
        <div class="row select-option-container">
            <div class="col-md-12">
                {!! Form::hidden('select_field_data', $babies) !!}
                {!! Form::hidden('tags', true) !!}
                @include('select',  [
                    'label_name' => 'Select Baby:',
                    'placeholder' => '-- Select patient --'
                ])
			</div>
            <div class="col-md-12 mt-20">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <button type="submit"  class="btn btn-success overallsubmitbtn save-button-shadow form-control btn-block">
                        <i class="fa fa-forward"></i> 
                        <span>{!! $SubmitButtonText !!}</span>
                    </button>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <a href="{{ action('Nurse\NurseSheetController@labBabySelect') }}" class="cancel-btn btn save-button-shadow btn-default form-control btn-block" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> <span>Cancel</span></a>
                </div>
            </div>                           
        </div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$(".overallsubmitbtn").click(function() {
			var selectval = $('#ssearch').val();
			if(selectval != 0) {	    
		    	$('.error-admission').fadeOut('slow');
		    	window.location = "{{ url('overall-lab-value-print/') }}/" +selectval+ "?closewinlink=main";
			} else {
				$('.error-admission').html('Please Select Baby !').fadeIn('slow');
			}				
		});
	});
</script>
@endif
@endsection



