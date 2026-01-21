@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
        <li><a href="{{ action('Extras\CardioController@index') }}">Echocardiography</a></li>
        <li class="current"><a>Create</a></li>
    </ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing mlr-0">
    <div class="col-md-12 col-sm-12 col-xs-12 tab-view-shadow plr-0 ptb-15">
        @include('errors.list')
        {!! Form::model($baby,['url' =>  action('Extras\CardioController@store'),'id' => 'echocardiography']) !!}               
        <div class="col-md-6 col-sm-6">
            <div class="mt-10 widget box">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> </h4>
                </div>
                <div class="widget-content">
                    {!! Form::hidden('BabyId') !!}                            
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('BabyName','Baby Name:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('BabyName',null,['class'=>'form-control','readonly']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control mt-0">
                            {!! Form::label('BirthWeight','Birth Weight (In Gms):') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('BirthWeight',null,['class'=>'form-control','readonly']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                            {!! Form::label('Gestation','Gestation:') !!}
                        </div>
                        <div class="col-md-9 custom-input clear-xs">
                            <div class="row col-md-12 display-flex">
                                <div>
                                    <small>(In Weeks)</small>
                                    {!! Form::text('g_weeks',null,['class'=>'form-control','readonly']) !!}
                                </div>
                                <div class="inbeween_two_fields">
                                    <span>+</span>
                                </div>
                                <divx>
                                    <small>(In Days)</small>
                                    {!! Form::text('g_days',null,['class'=>'form-control','readonly']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('Sex','Sex:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('Sex',['Male'=>'Male','Female'=>'Female','Indeterminate'=>'Indeterminate'],null,['class'=>'form-control','disabled']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('BirthStatus','Birth Status:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('BirthStatus',null,['class'=>'form-control','readonly']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('DOB','DOB:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('DOB',null,['class'=>'form-control','readonly']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="mt-10 widget box">
                    <div class="widget-header">
                        <h4><i class="fa fa-reorder"></i> </h4>
                    </div>
                    <div class="widget-content">
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('BMrNo', Lang::get('home.mrn').':') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('BMrNo',null,['class'=>'form-control','readonly']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('TestDate','Date:', ['class'=>'required-label']) !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('TestDate',date('d-m-Y'),['class'=>'form-control datepicker', 'readonly']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                {!! Form::label('Age','Age', ['class'=>'required-label']) !!}
                            </div>
                            <div class="col-md-9 custom-input clear-xs">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <small>(Year)</small>
                                    </div>
                                    <div class="col-xs-4">
                                        <small>(Month)</small>
                                    </div>
                                    <div class="col-xs-4">
                                        <small>(Days)</small>
                                    </div>
                                    <div class="col-xs-4">
                                        {!! Form::number('age_year',null,['class'=>'form-control']) !!}
                                    </div>
                                    <div class="col-xs-4">
                                        {!! Form::number('age_month',null,['class'=>'form-control']) !!}
                                    </div>
                                    <div class="col-xs-4">
                                        {!! Form::number('age_days',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('SeenBy','Echo Done By:', ['class'=>'required-label']) !!}
                                <a href="javascript:void(0)" class="add_master_data" data-modal_header="Done By" data-destination_elements="SeenBy" data-option_value="id" data-option_text="Name" data-mas_table="mas_doctors">
                                    <i class="fa fa-info-circle bs-tooltip add-neo-consultant" data-placement="right" data-original-title="Add Done By"></i>
                                </a>
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('SeenBy',[''=>'N/A']+ValuelistHelpers::mas_doctors_list(),null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('Outcome','Outcome:', ['class'=>'required-label']) !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('Outcome',[''=>'N/A','Normal'=>'Normal','Abnormal'=>'Abnormal'],null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12">
                <div class="mt-10 widget box">
                    <div class="widget-header">
                        <h4><i class="fa fa-reorder"></i> </h4>
                    </div>
                    <div class="widget-content">
                        <div class="form-group row">
                            <div class="col-md-1 col-sm-12 text-right label-control md-mt-50">
                                {!! Form::label('Findings','Echo Findings:', ['class'=>'required-label']) !!}
                            </div>
                            <div class="col-md-11 col-sm-12 custom-input">
                                {!! Form::textarea('Findings',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-1 col-sm-12 text-right label-control md-mt-50">
                                {!! Form::label('Impression','Impression:', ['class'=>'required-label']) !!}
                            </div>
                            <div class="col-md-11 col-sm-12 custom-input">
                                {!! Form::textarea('Impression',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-11 col-sm-12">
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <button type="submit"  class="btn btn-primary btn-block save-button-shadow form-control echo-save-button"><i class="fa fa-floppy-o"></i> <span>{!! $SubmitButtonText !!}</span></button>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <input type="hidden" name="print_flag" value="0" id="print_flag" />
                    <button type="button" class="btn btn-block save-button-shadow btn-info form-control echo-save-button" data-flag="1"><i class="fa fa-print"></i> <span>Print</span></button>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <a href="{{ action('Extras\CardioController@index') }}" class="btn btn-default save-button-shadow btn-block form-control" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> <span>Cancel</span></a>
                </div>
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
        CKEDITOR.replace('Findings');
        CKEDITOR.replace('Impression');
        /* PLUGIN USED FOR FORM LOCAL STORAGE */
        $( "form" ).sisyphus({  customKeySuffix: "cardio", locationBased: true });
    // $(document).on('click', '.echo-save-button', function(e)
    // {
    //     e.preventDefault();
    //     if ($('#echocardiography').valid() === true) {
    //       var print_flag = $(this).data('flag');
    //       $('#print_flag').val(print_flag);
    //       $('.echo-save-button').prop('disabled', true);
    
    //       $(this).html('<i class="fas fa-spinner fa-pulse"></i> Loading...');
    //       $('#echocardiography').submit();
    //     }
    // });
    $(document).on('click', '.echo-save-button', function(e){
        if ($('#echocardiography').valid() === true) {
            e.preventDefault();
            var findings = $("#cke_Findings iframe").contents().find("body").text();
            var impression = $("#cke_Impression iframe").contents().find("body").text();
            if (findings == '' || findings == null) {
                Showalert('warning', 'Please enter Echo Findings');
                return  false;
            }
            if (impression == '' || impression == null) {
                Showalert('warning', 'Please enter Impression');
                return  false;
            }
            var print_flag = $(this).data('flag');
            $('#print_flag').val(print_flag);
            $('.echo-save-button').prop('disabled', true);
            var current_clicked_element = $(this);
            $(this).html('<i class="fas fa-spinner fa-pulse"></i> Loading...');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: $('#echocardiography input, #echocardiography select, #echocardiography textarea').serialize(),
                url: "{{ action('Extras\CardioController@store') }}",
                success: function (response) {
                    if (print_flag == 1) {
                        Showalert('success', 'Echo Details Stored Successfully');
                        window.location.href = response.print_url;
                    }
                    else
                    {
                        Showalert('success', 'Echo Details Stored Successfully');
                        window.location.href = response.list_url;
                    }
                },
                error: function()
                {
                    Showalert('error', 'Something went wrong, Please try again later...!');
                    $('.echo-save-button').prop('disabled', false);
                }
            });
        }
    });
</script>
@endsection
