@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb ">
		<li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
		<li><a href="{{ action('Admission\PediatricController@index') }}">Pediatric Admission</a></li>
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
                <div class="form-group text-center">
                    <span class="error-message error-admission"> Please Choose The Baby </span>
				</div>
                <div class="form-group hide">
                    {!! Form::label('Baby_admission','Select Admission:') !!}
                    {!! Form::Select('Baby_admission',[''=>'Please select baby in baby list'],null,['class'=>'input-fields-shadow form-control']) !!}
                </div>
			</div>
            <div class="col-md-12 mt-15">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <button type="submit" class="btn btn-success save-button-shadow submitbtn form-control btn-block">
                    	<i class="fa fa-forward"></i> <span>{!! $SubmitButtonText !!}</span>
                    </button>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <a href="{{ action('Admission\PediatricController@index') }}" class="cancel-btn save-button-shadow btn btn-default form-control btn-block" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> <span>Cancel</span></a>
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
			selectval = $("#BabyId option:selected").val();
			if($("#BabyId option:selected").html() == '- - Create New Baby Registration - -'){
			   bootbox.confirm("Are you sure want to create new baby registration ?",function(confirmed){
                    if(confirmed){
				      window.location = "{{ action('Admission\PediatricController@index') }}"+'/'+selectval;
				    }  

			   });
			} else {

				window.location = "{{ action('Admission\PediatricController@index') }}"+'/'+selectval;

			}
			
		});
	
	// $('select[name="BabyId"]').change(function() {
	// 	var babyId = $(this).val();
	// 	if(babyId != '') {
	// 		$.ajax({
	//     		  type:'GET',
	//     		  url:'{{ url("pediatric-admission/get-baby-lists") }}'+'/'+babyId,
 //                  beforeSend:function(){
 //                  	$('.save').html('<i class="fa fa-forward"></i> <span>{!! $SubmitButtonText !!}</span><i class="fa fa-spinner fa-spin"></i>');
 //                  },
	//     		  success:function(responseText){
               		  
	//     		  },
	//     		  complete:function() {
	    		  
	//     		  },
	//     		  error:function() {
	    		  
	//     		  }
	//     	});     
	// 	}
	    	
 //     });
</script>
@endsection
