@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li>
			<i class="fa fa-home"></i>
			<a href="{{url('/')}}">Dashboard</a>                
		</li>
		<li>
			<a href="{{ action('Calculators\BallardController@index') }}">Ballard Score</a>
		</li>
		<li class="current">
			<a title="">Edit</a>
		</li>                        
	</ul>
</div>
<!-- /Breadcrumbs line -->
<div class="row mt-15">
	<div class="col-md-12">
        {!! Form::model($results,['method' => 'PATCH','url' => action('Calculators\BallardController@update',$results->BallardId), 'id'=>'ballard-form']) !!}
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
                <div class="col-md-11">
                    <input type="hidden" name="print_flag" value="0" id="print_flag" />
                    <div class="col-md-3">
                        <button type="button" class="btn btn-primary save-button-shadow mb-10 form-control ballard-btn" data-flag="1"><i class="fa fa-floppy-o"></i> <span>{!! $SubmitButtonText !!}</span></button>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-info save-button-shadow mb-10 form-control ballard-btn" data-flag="2"><i class="fa fa-print"></i> <span>Print</span></button>
                    </div>
                    <div class="col-md-3">
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

$('.ballard-btn').on('click', function(e) {
    e.preventDefault();
    var flag = $(this).attr('data-flag');
    $('input[name="print_flag"]').val(flag);

    var action_url = $("#ballard-form").attr('action');
    var serial = $($("#ballard-form")[0].elements).serializeArray();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: serial,
        url: action_url,
        success: function(response) {
         console.log(response);
         if (flag == 1) {
            window.location.href = response.edit_url;
        } else if (flag == 2) {
            window.location.href = response.print_url;                    
        }
    },
    error: function() {
        Showalert('error', 'Something went wrong, Please try again later...!');
    }
});
});
</script>
@endsection
