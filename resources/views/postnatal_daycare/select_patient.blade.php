@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
		<li><a href="{{ action('Admission\PostnatalDaycareController@index') }}">Postnatal Daycare</a></li>
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
                    	{!! Form::Select('BabyId',['0'=>'- - Select - -']+$babies,null,['class'=>'select2-select-00 full-width-fix input-fields-shadow']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                    	{!! Form::label('Baby_admission','Select Admission:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                    	{!! Form::Select('Baby_admission',['0'=>'- - Please select admission in admission list - -'],null,['class'=>'select2-select-00 full-width-fix input-fields-shadow']) !!}
                    </div>
                </div>
                <div class="form-group text-center">
                    <span class="error-message error-admission"> Please Choose The Admission </span>
                </div>
			</div>
            <div class="col-md-12 mt-15">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <button type="submit" class="btn btn-success submitbtn save-button-shadow form-control save btn-block" disabled="true">
                    	<i class="fa fa-forward "></i> 
                    	<span>{!! $SubmitButtonText !!}</span>
                    </button>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <a href="{{ action('Admission\PostnatalDaycareController@index') }}" class="cancel-btn save-button-shadow btn btn-default form-control btn-block" onclick="$('form')[0].reset();">
                    	<i class="fa fa-exclamation-circle"></i>
                    	<span>Cancel</span></a>
                </div>
            </div>                           
        </div>
	</div> <!-- /.col-md-12 -->
</div> <!-- /.row -->
<!-- /Page Content -->                
@endsection
    @section('scripts')
    <script type="text/javascript">

	function makeDisableAdmission(){

        if($("#BabyId option:selected").val()!='' && $("#BabyId option:selected").val()!=0){

            $('#Baby_admission').removeAttr('disabled');
            $('.save').removeAttr('disabled');

        }else{

           	$('#Baby_admission').attr('disabled',true);
           	$('.save').attr('disabled',true);

         }

	}
    makeDisableAdmission();

	$(".submitbtn").click(function(e){
		e.preventDefault();
		if($("#Baby_admission option:selected").data('flag')==0){
                    $('.error-message').fadeIn(1000);
			
		}else{
			selectval = $("#Baby_admission option:selected").val();
                    $('.error-message').fadeOut(1000);
				window.location = $(".cancel-btn").attr('href')+'/'+selectval;
		}	
	});

	$('#BabyId').change(function(){	
		 makeDisableAdmission();
		var neonatal_id = $("#BabyId option:selected").val();
      if(neonatal_id != '' && neonatal_id != 0){
		$.ajax({
			    type:'GET',
			    url:"{{ url('postnatal-daycare-admisson-list') }}"+'/'+neonatal_id,
			    beforeSend:function(){
			    $('.save').html('<i class="fa fa-forward "></i> <span>{!! $SubmitButtonText !!}</span><i class="fa fa-spinner fa-spin  "></i>');
			    },
			    success:function(responseText){
	                var results = responseText.data;
	                var option='';
	                	option+='<option  data-flag="0" value="0">- - Please select admission in admission list - -</option>';
	                $.each(results,function(index,value){
	                	option+='<option  data-flag="1" value="'+index+'">'+value+'</option>';
	                });
	                  $('#Baby_admission').html(option);
	                  makeDisableAdmission();
			    },
			    complete:function(){
                   $('.save').html('<i class="fa fa-forward "></i> <span>{!! $SubmitButtonText !!}</span>');

			    },
			    error:function(){
			    	Showalert('error','Please Try after some time !');
			      $('.save').html('<i class="fa fa-forward "></i> <span>{!! $SubmitButtonText !!}</span>').attr('disabled',true);
			       	$('#Baby_admission').attr('disabled',true)
			    },
		      });
       }
	});	
	</script>
@endsection
