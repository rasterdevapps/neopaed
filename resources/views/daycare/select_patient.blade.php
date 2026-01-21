@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
		<li><a href="{{ action('Admission\DaycareController@index') }}">Daycare</a></li>
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
                        {!! Form::Select('BabyId',$babies,null,['class'=>'select2-select-00 input-fields-shadow full-width-fix']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <span class="error-message error-admission"> Please Choose The Baby </span>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                    	{!! Form::label('Admission_id','Select Admission:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                    	{!! Form::Select('Admission_id',['0'=>'- - Select Admission - -'],null,['class'=>'select2-select-00 input-fields-shadow full-width-fix']) !!}
                    </div>
                </div>
			</div>
            <div class="col-md-12 mt-15">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <button type="submit"  class="btn btn-success submittbtn save-button-shadow form-control btn-block"><i class="fa fa-forward"></i> <span>{!! $SubmitButtonText !!}</span></button>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <a href="{{ action('Admission\DaycareController@index') }}" class="cancel-btn btn save-button-shadow btn-default form-control btn-block" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> <span>Cancel</span></a>
                </div>
            </div>                           
        </div>
	</div> <!-- /.col-md-12 -->
</div>
<!-- /Page Content -->                
@endsection
@section('scripts')
<script type="text/javascript">
$(".submittbtn").click(function(e) {
	e.preventDefault();
    var selectval = $("#Admission_id option:selected").val();
    if (selectval != '0') {
	    @if($module_type == 'problem-based')
	    	window.location = '{{ url("problem-systems-episodes") }}' + '/' + selectval;
	    @else
	    	window.location = $(".cancel-btn").attr('href') + '/' + selectval;
	    @endif
    }
});
$('#BabyId').change(function() {
    get_admissions();
});
// get_admissions();
function get_admissions() {
    var selectval = $("#BabyId option:selected").val();
    if (selectval != '') {
        var get_url = '';
        @if($module_type == 'problem-based')
        get_url = '{{ url("daycare-admission/admission-lists") }}' + '/' + selectval + '/problem-based';
        @else
        get_url = '{{ url("daycare-admission/admission-lists") }}' + '/' + selectval;
        @endif
        $.ajax({
            type: "GET",
            url: get_url,
            beforeSend: function() {
                $('.submittbtn').html('<i class="fa fa-forward "></i> <span>{!! $SubmitButtonText !!}</span><i class="fa fa-spinner fa-spin"></i>');
            },
            success: function(responseText) {
                var option_val = '';
                $.each(responseText.message, function(index, value) {
                    option_val += '<option value=' + index + '>' + value + '</option>';
                });
                $("#Admission_id").html(option_val);
            },
            complete: function() {
                $('.submittbtn').html('<i class="fa fa-forward "></i> <span>{!! $SubmitButtonText !!}').removeAttr('disabled');
            },
            error: function() {
                $('.submittbtn').attr('disabled', 'true');
            }
        });
    } else {
        $('.submittbtn').attr('disabled', 'true');
    }
}
</script>
@endsection
