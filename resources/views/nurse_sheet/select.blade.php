@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
		<li><a href="{{ action('Nurse\NurseSheetController@index') }}"> Nurse Sheet</a></li>
        <li class="current"><a>Choose Baby</a></li>                                                
	</ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing select-container-main">
	<div class="col-md-6">
        <div class="row select-option-container">
            <div class="col-md-12">
                	{!! Form::hidden('select_field_data', $babies) !!}
	                @include('select', [
	                    'label_name' => 'Select Baby:',
	                    'placeholder' => '-- Select patient --'
	                ])
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                    	{!! Form::label('Admission_id','Select Admission:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                    	{!! Form::Select('Admission_id',['0'=>'-- Select Admission --'],null,['class'=>'select2-select-00 full-width-fix input-fields-shadow']) !!}
	                  	<span class="error-admission"> </span>
                    </div>
                </div>
			</div>
			<div class="col-md-12 hide">
				<div class="col-md-6">
				    <div class="form-group">
	                    {!! Form::label('sheet_date','Select Date:') !!}
	                    <p class="sheet-border"><br/></p>
	                    {!! Form::text('sheet_date',$currrent_time['today'],['class'=>'form-control sheet_date']) !!}
		            </div>
				</div>
				<div class="col-md-6">
				    <div class="form-group">
	                    <table class="table">
	                    	<thead>
	                    		<th colspan="3">{!! Form::label('sheet_date','Select Time:') !!}</th>
	                    	</thead>
	                    	<tbody>
	                    		<td>{!! Form::select('time_hour',$time_master['time'],$currrent_time['hour'],['class'=>'form-control']) !!} </td>
	                    		<td>{!! Form::select('time_min',$time_master['mins'],$currrent_time['mins'],['class'=>'form-control']) !!}  </td>
	                    		<td>{!! Form::select('time_session',$time_master['session'],$currrent_time['session'],['class'=>'form-control']) !!}  </td>
	                    	</tbody>
	                    </table>
		            </div>
				</div>
			</div>
            <div class="col-md-12  mt-15">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <button type="submit"  class="btn btn-success submittbtn save-button-shadow form-control btn-block">
                        <i class="fa fa-forward"></i> 
                        <span>{!! $SubmitButtonText !!}</span>
                    </button>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <a href="{{ action('Nurse\NurseSheetController@index') }}" class="cancel-btn btn save-button-shadow btn-default form-control btn-block" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> <span>Cancel</span></a>
                </div>
            </div>                           
        </div>
	</div> <!-- /.col-md-12 -->
</div> <!-- /.row -->
<!-- /Page Content -->     
@endsection
@section('scripts')
<script type="text/javascript">
$(document).ready(function() {
    $('.sheet_date').datepicker({
        dateFormat: 'dd-mm-yy',
        yearRange: "-16:-0",
        changeMonth: true,
        changeYear: true,
        maxDate: '-0M',
    });
});
$(".submittbtn").click(function() {
    selectval = $("#Admission_id option:selected").val();
    if (selectval != 0) {
        $('.error-admission').html('Please Select Admission !').fadeOut('slow');
        window.location = $(".cancel-btn").attr('href') + '/' + selectval;
    } else {
        $('.error-admission').html('Please Select Admission !').fadeIn('slow');
    }
});

function get_admission() {
    var babyID = $('#ssearch').val();
    if (babyID != 0) {
        $.ajax({
            type: 'GET',
            url: "{{ url('nicu-nurse-admission-list') }}" + '/' + babyID,
            beforeSend: function() {
                $('.submittbtn').html('<i class="fa fa-forward"></i><span>{!! $SubmitButtonText !!}</span><i class="fa fa-spinner fa-spin"></i>').attr('disabled', true);
            },
            success: function(responseText) {
                var admissionOption = '';
                $.each(responseText.data, function(index, value) {
                    admissionOption += '<option value=' + index + '>' + value + '</option>';
                });
                $('#Admission_id').html(admissionOption);
                $('.submittbtn').html('<i class="fa fa-forward"></i><span>{!! $SubmitButtonText !!}</span>').removeAttr('disabled');
            },
            error: function() {
                $('.submittbtn').html('<i class="fa fa-forward"></i><span>{!! $SubmitButtonText !!}</span>').attr('disabled', true);
            }
        });
    } else {
        $('.submittbtn').html('<i class="fa fa-forward"></i><span>{!! $SubmitButtonText !!}</span>').attr('disabled', true);
    }
}
$('#ssearch').change(function() {
    get_admission();
});
// get_admission();
</script>
@endsection



