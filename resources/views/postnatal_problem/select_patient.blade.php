@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
		<li><a href="{{ action('ProblemBaseDaycare\ProblemDaycareController@index') }}">Problem Base Daycare</a></li>
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
                     {!! Form::label('problem_id','Select Baby:') !!}

                     {!! Form::Select('problem_id',$problemLists,null,['class'=>'select2-select-00 full-width-fix']) !!}
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-3 col-sm-4 col-xs-6">
                    <button type="submit"  class="btn btn-success submitbtn save-button-shadow form-control"><i class="fa fa-forward"></i> <span>{!! $SubmitButtonText !!}</span></button>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-6">
                    <a href="{{ action('ProblemBaseDaycare\ProblemDaycareController@index') }}" class="cancel-btn save-button-shadow btn btn-default form-control" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> <span>Cancel</span></a>
                </div>
            </div>                           
        </div>
	</div> <!-- /.col-md-12 -->
</div> <!-- /.row -->
<!-- /Page Content -->                
@endsection
@section('scripts')
<script type="text/javascript">


   $('#BabyId').change(function() {
      get_admissions();
   });

	$(".submitbtn").click(function(){
		selectval = $("#Admission_id option:selected").val();
        
		window.location = $(".cancel-btn").attr('href')+'/'+selectval;
		
	});

</script>

@endsection
   
