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
            <a href="{{ action('Extras\UltraController@index') }}">Carnial Ultrasonography</a>
        </li>
        <li class="current">
            <a>Edit</a>
        </li>
    </ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing mlr-0">
    <div class="col-md-12 col-sm-12 tab-view-shadow plr-0 ptb-15">
        @include('errors.list')
        {!! Form::model($results,['method' => 'PATCH','url' =>  action('Extras\UltraController@update',$results->UltraId), 'id'=>'ultrasonography-form']) !!}
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
                        <div class="col-md-3 text-right label-control">
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
                                    {!! Form::text('g_weeks',null,['class'=>'form-control input-width-medium','readonly']) !!}
                                    <label class="error help-block" for="g_weeks" generated="true"></label> 
                                </div>
                                <div class="inbeween_two_fields">
                                    <span>+</span>
                                </div>
                                <div>
                                    <small>(In Days)</small>
                                    {!! Form::text('g_days',null,['class'=>'form-control  input-width-medium','readonly']) !!}
                                    <label class="error help-block" for="g_days" generated="true"></label> 
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
                            {!! Form::label('DOB','DOB:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('DOB',null,['class'=>'form-control','readonly']) !!}
                        </div>
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
                            {!! Form::label('BirthStatus','Birth Status:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('BirthStatus',null,['class'=>'form-control','readonly']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('TestDate','Date:', ['class'=>'required-label']) !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('TestDate',null,['class'=>'form-control datepicker', 'readonly']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('Age','Age :', ['class'=>'required-label']) !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('Age',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('SeenBy','CUSS Done By:', ['class'=>'required-label']) !!}
                            <a href="javascript:void(0)" class="add_master_data" data-modal_header="Done By" data-destination_elements="SeenBy" data-option_value="id" data-option_text="Name" data-mas_table="mas_doctors">
                                <i class="fa fa-info-circle bs-tooltip add-neo-consultant" data-placement="right" data-original-title="Add Done By"></i>
                            </a>
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('SeenBy',[''=>'N/A']+ValuelistHelpers::mas_doctors_list(),null,['class'=>'form-control']) !!}
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
                        <div class="col-md-3 col-sm-12 text-right label-control">
                            {!! Form::label('Indication','Indication:', ['class'=>'required-label']) !!}
                        </div>
                        <div class="col-md-9 col-sm-12 custom-input">
                            {!! Form::textarea('Indication',null,['class'=>'form-control', 'rows'=>2]) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 col-sm-12 text-right label-control">
                            {!! Form::label('UsgRt','USG Findings Rt Side:', ['class'=>'required-label']) !!}
                        </div>
                        <div class="col-md-9 col-sm-12 custom-input">
                            {!! Form::textarea('UsgRt',null,['class'=>'form-control', 'rows'=>4]) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 col-sm-12 text-right label-control">
                            {!! Form::label('UsgLt','USG Findings Lt Side:', ['class'=>'required-label']) !!}
                        </div>
                        <div class="col-md-9 col-sm-12 custom-input">
                            {!! Form::textarea('UsgLt',null,['class'=>'form-control', 'rows'=>4]) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 col-sm-12 text-right label-control">
                            {!! Form::label('UsgGeneral','USG Findings General:', ['class'=>'required-label']) !!}
                        </div>
                        <div class="col-md-9 col-sm-12 custom-input">
                            {!! Form::textarea('UsgGeneral',null,['class'=>'form-control', 'rows'=>4]) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 col-sm-12 text-right label-control">
                            {!! Form::label('Impression','Impression:', ['class'=>'required-label']) !!}
                        </div>
                        <div class="col-md-9 col-sm-12 custom-input">
                            {!! Form::textarea('Impression',null,['class'=>'form-control', 'rows'=>2]) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row col-md-11 col-sm-12">
            <div class="col-md-3 col-sm-4 col-xs-12">
                <button type="submit" class="btn btn-primary btn-block save-button-shadow  form-control ultra-save-btn"><i class="fa fa-floppy-o"></i> <span>{!! $SubmitButtonText !!}</span></button>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-12">
                <input type="hidden" name="print_flag" value="0" id="print_flag" />
                <button type="button" class="btn btn-block btn-info save-button-shadow  form-control ultra-save-btn" data-flag="1"><i class="fa fa-print"></i> <span>Print</span></button>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-12">
                <a href="{{ action('Extras\UltraController@index') }}" class="btn btn-default save-button-shadow  btn-block form-control" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> <span>Cancel</span></a>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <!-- /.col-md-12 -->                    
</div>
<!-- /.row -->
<!-- /Page Content -->
<div class="row mt-20">
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    /* PLUGIN USED FOR FORM LOCAL STORAGE */
    CKEDITOR.replace('Indication');
    CKEDITOR.replace('UsgRt');
    CKEDITOR.replace('UsgLt');
    CKEDITOR.replace('UsgGeneral');
    CKEDITOR.replace('Impression');
    $( "form" ).sisyphus({  customKeySuffix: "ultra", locationBased: true });
    $(document).on('click', '.ultra-save-btn', function(e){
        if ($('#ultrasonography-form').valid() === true) {
            e.preventDefault();
            var indication = $("#cke_Indication iframe").contents().find("body").text();
            var UsgRt = $("#cke_UsgRt iframe").contents().find("body").text();
            var UsgLt = $("#cke_UsgLt iframe").contents().find("body").text();
            var UsgGeneral = $("#cke_UsgGeneral iframe").contents().find("body").text();
            var impression = $("#cke_Impression iframe").contents().find("body").text();
            if (indication == '' || indication == null) {
                Showalert('warning', 'Please enter Indications');
                return  false;
            }
            if (UsgRt == '' || UsgRt == null) {
                Showalert('warning', 'Please enter USG Findings Right Side Details');
                return  false;
            }
            if (UsgLt == '' || UsgLt == null) {
                Showalert('warning', 'Please enter USG Findings Left Side Details');
                return  false;
            }
            if (UsgGeneral == '' || UsgGeneral == null) {
                Showalert('warning', 'Please enter USG Findings General Details');
                return  false;
            }
            if (impression == '' || impression == null) {
                Showalert('warning', 'Please enter Impression');
                return  false;
            }
            var print_flag = $(this).data('flag');
            $('#print_flag').val(print_flag);
            $('.ultra-save-btn').prop('disabled', true);
            var current_clicked_element = $(this);
            $(this).html('<i class="fas fa-spinner fa-pulse"></i> Loading...');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: $('#ultrasonography-form input, #ultrasonography-form select, #ultrasonography-form textarea').serialize(),
                url: "{{ action('Extras\UltraController@update',$results->UltraId) }}",
                success: function (response) {
                    if (print_flag == 1) {
                        Showalert('success', 'Ultrasonography details updated successfully');
                        window.location.href = response.print_url;
                    }
                    else
                    {
                        Showalert('success', 'Ultrasonography details updated successfully');
                        window.location.href = response.list_url;
                    }
                },
                error: function()
                {
                    Showalert('error', 'Something went wrong, Please try again later...!');
                    $('.ultra-save-btn').prop('disabled', false);
                }
            });
        }
    });
</script>
@endsection
