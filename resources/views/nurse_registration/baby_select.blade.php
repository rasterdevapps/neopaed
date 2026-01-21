@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
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
                        {!! Form::Select('BabyId',[0=>'- - Select from List - -']+$babies,null,['class'=>'select2-select-00 input-fields-shadow full-width-fix']) !!}
                    </div>
                </div>
			</div>
            <div class="col-md-12 mt-15">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <button type="submit" class="btn btn-success submitbtn save-button-shadow form-control btn-block"><i class="fa fa-forward"></i> <span>{!! $SubmitButtonText !!}</span></button>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <a href="{{ action('HomeController@index') }}" class="cancel-btn clear-flow-sesstion save-button-shadow btn btn-default form-control btn-block" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> <span>Cancel</span></a>
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
					window.location = "{{ url('baby-readmission/nurse/nicu-admission') }}"+'/'+selectval;
			
		});
	</script>
@endsection
