@extends('app')
@section('content')

<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
		<li><a href="{{ action('Lab\LabRequestController@index') }}">Lab Request</a></li>                                                
		<li class="current"><a>Choose Baby</a></li>                                                
    </ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
	<div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('BabyId','Select Baby:') !!}
                    {!! Form::Select('BabyId',['0'=>'---Select---']+$babies,null,['class'=>'select2-select-00 input-fields-shadow full-width-fix']) !!}
                </div>
                <div class="form-group">
                    <span class="error-message error-admission"> Please Choose The Baby </span>
                </div>
			</div>
            <div class="col-md-12">
                <div class="col-md-3 col-sm-4 col-xs-6">
                    <button type="submit" class="btn btn-success save-button-shadow submitbtn form-control btn-block"><i class="fa fa-forward"></i> <span>{!! $SubmitButtonText !!}</span></button>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-6">
                    <a href="{{ action('Lab\LabRequestController@index') }}" class="cancel-btn btn save-button-shadow btn-default form-control btn-block" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> <span>Cancel</span></a>
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

            if(selectval != 0) {
                window.location =  $(".cancel-btn").attr('href')+'/'+selectval;
            } else {
                $('.error-message').fadeIn(1000).fadeOut(1000);
            }
			
		});
	</script>
@endsection
