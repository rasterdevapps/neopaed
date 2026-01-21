@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li><i class="fa fa-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
		<li><a href="{{ action('Calculators\BallardController@index') }}">Ballard Score</a></li>
		<li class="current"><a title="">Create</a></li>                        
    </ul>
</div>
<!-- /Breadcrumbs line -->
<div class="row row-spacing mt-15">
	<div class="col-md-12">
        {!! Form::model($baby,['url' => action('Calculators\BallardController@store'), 'id'=>'ballard-form']) !!}
        <!-- Nav tabs -->
        <div role="tabpanel" class="tabbable tabbable-custom">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#basicform" aria-controls="basicform" role="tab" data-toggle="tab">Basic Details</a></li>
                <li role="presentation"><a href="#neuroform" aria-controls="historyform" role="tab" data-toggle="tab">Neurological Maturity</a></li>    
                <li role="presentation"><a href="#physcialform" aria-controls="physcialform" role="tab" data-toggle="tab">Physical Maturity</a></li>    
                <li role="presentation"><a href="#scoreform" aria-controls="babyform" role="tab" data-toggle="tab">Score</a></li>    			                     
            </ul>
            <!-- Tab panes -->
            <div class="tab-content tab-view-shadow">
                @include('calculators.ballard.form')
                <div class="col-md-11 col-sm-12">
                    <div class="col-md-3 col-sm-4">
                        <button type="submit" class="btn btn-primary save-button-shadow mb-10 form-control save-btn"><i class="fa fa-floppy-o"></i> <span>{!! $SubmitButtonText !!}</span></button>
                    </div>
                    <div class="col-md-3 col-sm-4">
                        <a href="{{ action('Calculators\BallardController@index') }}" class="btn btn-default save-button-shadow form-control" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> <span>Cancel</span></a>
                    </div>
                </div>  
            </div>
        </div>
        {!! Form::close() !!}
        @include('errors.list')
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    function UpdateScore(value,name){
     name1 =name;
     if(name=='FGenitals')
      name = 'Genitals';
  $("input[name="+name+"]").val(value);
  $("."+name).removeClass('active');	
  $("#"+name1+value).addClass('active');
  Posture = $("input[name='Posture']").val();
  SquareWindow = $("input[name='SquareWindow']").val();
  ArmRecoil = $("input[name='ArmRecoil']").val();
  PoplitealAngle = $("input[name='PoplitealAngle']").val();
  ScarfSign = $("input[name='ScarfSign']").val();
  HeelEar = $("input[name='HeelEar']").val();

  Skin = $("input[name='Skin']").val();
  Lanugo = $("input[name='Lanugo']").val();
  PlantarSurface = $("input[name='PlantarSurface']").val();
  Breast = $("input[name='Breast']").val();
  EyeEar = $("input[name='EyeEar']").val();
  Genitals = $("input[name='Genitals']").val();				

  NeuromuscularScore = parseInt(Posture) +  parseInt(SquareWindow) + parseInt(ArmRecoil) + parseInt(PoplitealAngle) + parseInt(ScarfSign) + parseInt(HeelEar);
  PhysicalScore = parseInt(Skin) + parseInt(Lanugo) + parseInt(PlantarSurface) + parseInt(Breast) + parseInt(EyeEar) + parseInt(Genitals);
  TotalScore = NeuromuscularScore + PhysicalScore;
  AssessedGestationalAge = .4 * TotalScore + 24;
  Weeks = parseInt(AssessedGestationalAge);
  Days =  parseInt((AssessedGestationalAge -Weeks) * 7);

  $("#NeuromuscularScore").val(NeuromuscularScore);
  $("#PhysicalScore").val(PhysicalScore);
  $("#TotalScore").val(TotalScore);
  $("#AssessedGestationalAge").val(AssessedGestationalAge);
  $("#Weeks").val(Weeks);
  $("#Days").val(Days);

}

$(document).on('click', '.save-btn', function(e){
    e.preventDefault();
    if ($('#ballard-form').valid() === true) {

        $(this).prop('disabled', true);

        $(this).html('<i class="fas fa-spinner fa-pulse"></i> Loading...');

        $('#ballard-form').submit();
    }
});
</script>
@endsection
