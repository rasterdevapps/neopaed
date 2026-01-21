@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
        <li class="current"><a href="{{ action('Calculators\AgeController@index') }}">Age Calculator</a></li>
    </ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
    <div class="col-md-12 col-sm-12">
        {!! Form::open(['url' => '']) !!}                               
        <div class="col-md-6 col-sm-6">
            <div class="mt-10 widget box">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> </h4>
                </div>
                <div class="widget-content">
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('Date','Date:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('Date',null,['class'=>'form-control datepicker input-vals','readonly']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('DOB','DOB:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('DOB',null,['class'=>'form-control datepicker input-vals','readonly']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('GestationWk','Gestation Weeks:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('GestationWk',null,['class'=>'form-control input-vals']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('GestationD','Gestation Days:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('GestationD',null,['class'=>'form-control input-vals']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="mt-10 widget box row mx-0">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> </h4>
                </div>
                <div class="widget-content">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            {!! Form::label('ChroAge','Chronological Age (Days):') !!}
                            <span class="ChroAge"></span>
                        </div>
                        <div class="form-group">
                            <span class="ChroWeeks"></span> Weeks
                        </div>
                        <div class="form-group">
                            <span class="ChroDays"></span> Days
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 corrected_age_column">
                        <div class="form-group">
                            {!! Form::label('CorrectAge','Corrected Age (Days):') !!}
                            <span class="CorrectAge"></span>
                        </div>
                        <div class="form-group">
                            <span class="CorrectWeeks"></span> Weeks
                        </div>
                        <div class="form-group">
                            <span class="CorrectDays"></span> Days
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 clear">
            <a href="javascript:void(0);" class="btn btn-default btn-basic-shadow form-control" onclick="$('form')[0].reset(); ClearValues();"><i class="fa fa-exclamation-circle"></i> <span>Clear</span></a>
        </div>
        {!! Form::close() !!}
    </div>
    <!-- /.col-md-12 -->                    
</div>
<!-- /.row -->
<!-- /Page Content -->
@endsection
@section('scripts') 
<script type="text/javascript">   
function ClearValues() {

    $(".CorrectDays").html('');
    $(".ChroDays").html('');
    $(".CorrectAge").html('');
    $(".ChroAge").html('');
    $(".CorrectWeeks").html('');
    $(".ChroWeeks").html('');

}
// $(".input-vals").on('change',function() {
//    date1 = $("#Date").val().split("-");
//    dob = $("#DOB").val().split("-");
//    date1 = date1[1] + "-" + date1[0] + "-" + date1[2];
//    dob = dob[1] + "-" + dob[0] + "-" + dob[2];
//    var diff = Date.parse( date1 ) - Date.parse( dob ); 
//    ChroAge = isNaN( diff ) ? 0 :  Math.floor( diff / 86400000);
//    geswk = parseInt($("#GestationWk").val());
//    gesd = parseInt($("#GestationD").val());     
//    ChroWeeks = parseInt(ChroAge / 7);
//    ChroDays = ChroAge % 7;
//    CorrectAge = ChroAge - 280 + (geswk*7 + gesd);
//    CorrectWeeks = parseInt(CorrectAge /7);
//    CorrectDays = CorrectAge % 7;    
//    $(".CorrectAge").html(CorrectAge);
//    $(".ChroAge").html(ChroAge);
//    $(".ChroDays").html(ChroDays);
//    $(".ChroWeeks").html(ChroWeeks);
//    $(".CorrectWeeks").html(CorrectWeeks);
//    $(".CorrectDays").html(CorrectDays);     
// });

$('.input-vals').on('change', function () {
    var opDate = $('#Date').datepicker('getDate');
    var dobDate = $('#DOB').datepicker('getDate');
    var gestationWeeks = $('input[name="GestationWk"]').val();
    var gestationDays = $('input[name="GestationD"]').val();
    if (opDate != null && dobDate != null) {
        var chronological_age = calculateDays(dobDate, opDate);
        var tempDays = chronological_age; 
        console.log(tempDays);
        if (tempDays > 0) {
            $('.ChroAge').text(tempDays);
        }
        else
        {
            $('.ChroAge').text('0');
        }
        if (gestationWeeks >= 37) {
            $('.CorrectAge').text('0');
            $('.CorrectWeeks').text('0');
            $('.CorrectDays').text('0');
            $('.corrected_age_column').slideUp();
        } else {
            $('.corrected_age_column').slideDown();
            var corrected_age = (40 - parseInt(gestationWeeks)) * 7;
            corrected_age = corrected_age + parseInt(gestationDays);
            corrected_age_days = chronological_age - corrected_age;
            if (corrected_age_days > 0) {
                $('.CorrectAge').text(corrected_age_days);
            }
            else{
                $('.CorrectAge').text('0');
            }
            var corrected_age_weeks = parseInt(corrected_age_days / 7);
            if (corrected_age_weeks > 0) {
                $('.CorrectWeeks').text(corrected_age_weeks);

            } else {
                $('.CorrectWeeks').text('0');
            }
            var corrected_age_rem_days = corrected_age_days % 7;
            if (corrected_age_weeks > 0) {
                $('.CorrectDays').text(corrected_age_rem_days);

            } else {
                $('.CorrectDays').text('0');
            }

            // var chronological_formatted_values = getFormatedStringFromDays(chronological_age);
            // var correceted_formatted_values = getFormatedStringFromDays(corrected_age_days);

            // var formated_corr_years = correceted_formatted_values[0];
            // if (formated_corr_years != '') {
            //     $('input[name=corrected_year').val(formated_corr_years);
            // }
            // else
            // {
            //     $('input[name=corrected_year').val(0);
            // }


            // var formated_corr_months = correceted_formatted_values[1];
            // if (formated_corr_months != '') {
            //     $('input[name=corrected_month').val(formated_corr_months);
            // }
            // else
            // {
            //     $('input[name=corrected_month').val(0);
            // }

            // var formated_corr_days = correceted_formatted_values[2];
            // if (formated_corr_days != '') {
            //     $('input[name=corrected_days').val(formated_corr_days);
            // }
            // else
            // {
            //     $('input[name=corrected_days').val(0);
            // }
        }


        // var opDate = $('#OpDate').datepicker('getDate');
        // var dobDate = $('#DOB').datepicker('getDate');


        // var tempDays = calculateDays(dobDate, opDate);

        var remainingDays = 0;

        if (opDate.getFullYear() > dobDate.getFullYear()) {


            for (var i = dobDate.getMonth() + 1; i <= 12; i++) {

                if (getNumberDaysInmonth(dobDate.getFullYear(), i) == 31 && dobDate.getMonth() + 1 != i) {

                    remainingDays++;

                }

            }

            for (var i = 1; i < opDate.getMonth() + 1; i++) {

                if (getNumberDaysInmonth(opDate.getFullYear(), i) == 31 && opDate.getMonth() + 1 != i) {

                    remainingDays++;

                }

            }

        } else if (opDate.getFullYear() == dobDate.getFullYear()) {


            for (var i = dobDate.getMonth() + 2; i <= opDate.getMonth() + 1; i++) {

                if (getNumberDaysInmonth(dobDate.getFullYear(), i) == 31) {

                    remainingDays++;

                }

            }

        }


        totalWeeks = (tempDays / 7) > 0 ? (tempDays / 7) : 0;
        totalDays = (tempDays % 7) > 0 ? (tempDays % 7) : 0;

        // year = ((tempDays / 365) > 0) ? tempDays / 365 : 0;
        // tempDays = ((tempDays % 365) >= 0) ? tempDays % 365 : tempDays;

        // month = ((tempDays / 30) > 0) ? tempDays / 31 : 0;
        // tempDays = ((tempDays % 30) >= 0) ? tempDays % 31 : tempDays;


        // $('input[name="chronological_year"]').val(parseInt(year));
        // $('input[name="chronological_month"]').val(parseInt(month));
        // $('input[name="chronological_days"]').val(parseInt(tempDays));


        $('.ChroWeeks').text(parseInt(totalWeeks));
        $('.ChroDays').text(parseInt(totalDays));
    }
});

function getFormatedStringFromDays(numberOfDays) {
    var years = Math.floor(numberOfDays / 365);
    var months = Math.floor(numberOfDays % 365 / 30);
    var days = Math.floor(numberOfDays % 365 % 30);

    var yearsDisplay = years > 0 ? years + (years == 1 ? "" : "") : "";
    var monthsDisplay = months > 0 ? months + (months == 1 ? "" : "") : "";
    var daysDisplay = days > 0 ? days + (days == 1 ? "" : "") : "";
    var formatted_values = [yearsDisplay, monthsDisplay, daysDisplay];
    return formatted_values;
}

function getNumberDaysInmonth(sourceYear, sourceMonth) {

    var date = new Date(sourceYear, sourceMonth, 0);

    return date.getDate();

}
</script>
@endsection
