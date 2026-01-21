@extends('app')
@section('content')
<!-- Breadcrumbs line -->
	<div class="crumbs bread-crumbs-shadow">
		<ul id="breadcrumbs" class="breadcrumb">
			<li>
				<i class="icon-home"></i>
				<a href="{{ url('/') }}">Dashboard</a>
			</li>
			<li>
				<a href="{{ action('Admission\NicuController@index') }}">NICU Admission</a>
			</li>
            <li class="current">
                <a>Choose Baby</a>
            </li>                                                
		</ul>
	</div>
<!-- /Breadcrumbs line -->

<!--=== Page Content ===-->
<div class="row row-spacing select-container-main">
	<div class="col-md-6 col-sm-6 col-xs-6">
        <div class="row select-option-container">
            <div class="col-md-12">
                {!! Form::hidden('select_field_data', $babies) !!}
                @include('select', [
                    'label_name' => 'Select Baby:',
                    'placeholder' => '-- Select from List --'
                ])
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                    	{!! Form::label('Baby_admission','Select Admission:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                    	{!! Form::Select('Baby_admission',['0'=>'- - Please select baby in baby list - -'],null,['class'=>'select2-select-00 input-fields-shadow full-width-fix']) !!}
                    </div>
                </div>
			</div>
            <div class="col-md-12 mt-15">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <button type="submit" class="btn btn-success submittbtn save-button-shadow  save form-control btn-block"><i class="fa fa-forward"></i> <span>{!! $SubmitButtonText !!}</span></button>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <a href="{{ action('Admission\NicuController@index') }}" class="cancel-btn btn save-button-shadow  btn-default form-control btn-block" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> <span>Cancel</span></a>
                </div>
            </div>                           
        </div>
	</div> <!-- /.col-md-12 -->
</div> <!-- /.row -->
<!-- /Page Content -->                
@endsection
@section('scripts')
<script type="text/javascript">
function nicuAdmissionbabyDisable() {
    var babyId = $("#ssearch").val();
    if (babyId != '') {
        $.ajax({
            type: 'GET',
            url: '{{ url("nicu-admission/get-baby-lists") }}' + '/' + babyId,
            beforeSend: function() {
                $('.save').html('<i class="fa fa-forward "></i> <span>{!! $SubmitButtonText !!}</span><i class="fa fa-spinner fa-spin"></i>');
            },
            success: function(responseText) {
                var options = '';
                $.each(responseText.message, function(index, value) {
                    if (value == 0) {
                        options += '<option data-flag="0" value="' + index + '">- - Create New Admission - -</option>';
                    } else {
                        options += '<option data-flag="1" value="' + index + '">' + value + '</option>';
                    }
                });
                $('#Baby_admission').html(options);
            },
            complete: function() {
                $('.save').html('<i class="fa fa-forward "></i> <span>{!! $SubmitButtonText !!}</span>');
                $('#Baby_admission').removeAttr('disabled');
                $('.submittbtn').removeAttr('disabled');
            },
            error: function() {
                Showalert('error', 'Please try after some time !');
                $('.save').html('<i class="fa fa-forward "></i> <span>{!! $SubmitButtonText !!}</span>');
            }
        });
    } else {
        $('#Baby_admission').attr('disabled', true);
        $('.submittbtn').attr('disabled', true);
    }
}
// nicuAdmissionbabyDisable();
$('#ssearch').on('change', function() {
    nicuAdmissionbabyDisable();
});
$(".submittbtn").click(function(e) {
	e.preventDefault();
    var selectval = $("#Baby_admission option:selected").val();
    if($("#Baby_admission option:selected").data('flag') == '0'){
        bootbox.confirm("Are you sure want to create new admission ?", function(confirmed) {
            if (confirmed) {
                window.location = $(".cancel-btn").attr('href') + '/create/' + selectval;
            }
        });
    } else {
		window.location = $(".cancel-btn").attr('href')+'/create/'+selectval;
	}
});
</script>
@endsection
