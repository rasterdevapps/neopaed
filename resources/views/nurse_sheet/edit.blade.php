@extends('app')
@section('content')
<!-- <link rel="stylesheet" type="text/css" href="{{ url('/') }}/public/css/number_pad.css"> -->
<?php $write_permission = session('write_permission'); ?>
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="{{ url('/') }}">Dashboard</a>
        </li>
        <li class="current">
            <a href="{{ action('Nurse\NurseSheetController@index') }}">Nurse Sheets</a>
        </li>
        <li>
            <a href="javascript:void(0);">{{ $baby_details->BabyName.' - '. $baby_details->BMrNo }}  &nbsp;<i class="fa fa-info-circle baby-info-modal hidden-lg"></i></a>
        </li>
    </ul>
        <div class="pull-right">
            @if (!is_null($prev_id))
                @php
                    $prev_id = explode('||', $prev_id);
                    $previd = $prev_id[0];
                    $prev_day_name = $prev_id[1];
                @endphp
                <a href="{{ action('Nurse\NurseSheetController@edit', \SiteHelpers::encrypt_id($previd)) }}" class="btn nurse-day-nav" title="Day {{$prev_day_name}}">
                    <i class="fa fa-chevron-left" aria-hidden="true"></i>
                </a>
            @endif
            @if (!is_null($next_id))
                @php
                    $next_id = explode('||', $next_id);
                    $nextid = $next_id[0];
                    $next_day_name = $next_id[1];
                @endphp
                <a href="{{ action('Nurse\NurseSheetController@edit', \SiteHelpers::encrypt_id($nextid)) }}" class="btn nurse-day-nav" title="Day {{$next_day_name}}">
                    <i class="fa fa-chevron-right" aria-hidden="true"></i>
                </a>
            @endif
            @php 
                $mrn = $baby_details->BMrNo; 

                echo \SiteHelpers::menuList($mrn, $baby_admission_id, 'nurse_sheet_edit');
            @endphp
      </div>
    <div class="pull-right nurse-sheet-dialpad-control">
        <label>Dialpad</label>
        <input id="dialpad_option" data-on="Yes" data-off="No" data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
    </div>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
{!! Form::model($baby_details,['method' => 'PATCH','url' => action('Nurse\NurseSheetController@update',$id),'id'=> 'nurse-form']) !!}
<div class="row row-spacing">
    @include('nurse_sheet.baby_basic')
</div>
{{ Form::hidden('formid',$id) }}
{{ Form::hidden('admission_id',$baby_admission_id) }}
<div class="row">
    <div class="col-md-12 pl-0">
        <div class="col-md-6">
            <div class="pull-left">
                <table class="table">
                    <tbody>
                        <tr>
                            <td class="border-replacement">{!! Form::label('sheet_date','Date:') !!}</td>
                            <td class="border-replacement"><label>{!! @$date !!}</label></td>
                            <td class="border-replacement">{!! Form::hidden('sheet_date',@$sheet_date,['class'=>'form-control daycare-date input-fields-shadow']) !!}</td>
                        <tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <div class="pull-right">
                <table class="table">
                    <tbody>
                        <tr>
                            <td class="border-replacement">{!! Form::label('dcp','DCT:') !!}</td>
                            <td class="border-replacement">{!! Form::select('dcp',["N/A"=>"N/A","Positive"=>"Positive","Negative"=>"Negative"],$nurse_details_sheet['dcp'],['class'=>'form-control input-width-medium', 'id'=>'dcp']) !!} </td>
                            <td class="border-replacement">{!! Form::label('hemolysis','Hemolysis:') !!}</td>
                            <td class="border-replacement">{!! Form::select('hemolysis',["N/A"=>"N/A","Yes"=>"Yes","No"=>"No"],$nurse_details_sheet['hemolysis'],['class'=>'form-control input-width-medium', 'id'=>'hemolysis']) !!} </td>
                        <tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row row-spacing">
    <div class="col-md-12">
        {{ Form::hidden('BabyId', $baby_details->BabyId) }}
        @include('nurse_sheet.nurse_form',['SubmitButtonText' => 'Update','SubmitClose'=>'Update & Close'])
    </div>
</div>
{!! Form::close() !!}

<div class="modal fade flow-control-modal" id="baby-info-modal-popup" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <h3 class="text-center text-white">Baby Info</h3>
                </h5>
                <button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true" style="color:white"><i class="fa fa-times"></i></button>  
            </div>
            <div class="modal-body">
                <div class="row mx-0">
                    <div class="col-xs-12">
                        <table class="table">
                            <tr>
                                <td width="20%" align="right">
                                    Baby Name : 
                                </td>
                                <td width="30%">
                                    {!! $baby_details->BabyName !!}
                                </td>
                                <td align="right" width="20%">
                                    Baby {{ Lang::get('home.mrn') }} :
                                </td>
                                <td>
                                    {!! $baby_details->BMrNo !!}
                                </td>
                            </tr>
                            <tr>
                                <td align="right">
                                    {{ Lang::get('home.ip') }}:
                                </td>
                                <td>
                                    {!! isset($ip_details->ip_number) ? $ip_details->ip_number : '' !!} 
                                </td>
                                <td align="right">
                                    Sex :
                                </td>
                                <td>
                                    {!! $baby_details->Sex !!}
                                </td>
                            </tr>
                            <tr>
                                <td align="right">
                                    DOB :
                                </td>
                                <td>
                                    @if(!is_null($baby_details->DOB)) 
                    {!! date('d-m-Y',strtotime($baby_details->DOB)) !!} @endif
                                </td>
                                <td align="right">
                                    Gestation :
                                </td>
                                <td>
                                    {!! SiteHelpers::decode_gestation($baby_details->Gestation) !!}
                                </td>
                            </tr>
                            <tr>
                                <td align="right">
                                    Corrected Gestational Age :
                                </td>
                                <td>
                                    {!! $corrected_gestation !!}
                                </td>
                                <td align="right">
                                    Birth Weight :
                                </td>
                                <td>
                                    {!! $baby_details->BirthWeight !!}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="dialog_box">
    <div class="dialog-title-container">
        <h5 class="dialog-title">Edit Value</h5>
        <button class="close-dialog-box"><i class="fa fa-times"></i></button>
    </div>
    <div class="dialog-content-container">
        <label id="input-info-dialpad"></label>
        <input type="text" readonly="true" name="sample" id="dialog-input-field" class="form-control">
        <table class="number-pad-table">
            <tr>
                <td><button value="1" class="number-pad-dialpad-buttons">1</button></td>
                <td><button value="2" class="number-pad-dialpad-buttons">2</button></td>
                <td><button value="3" class="number-pad-dialpad-buttons">3</button></td>
            </tr>
            <tr>
                <td><button value="4" class="number-pad-dialpad-buttons">4</button></td>
                <td><button value="5" class="number-pad-dialpad-buttons">5</button></td>
                <td><button value="6" class="number-pad-dialpad-buttons">6</button></td>
            </tr>
            <tr>
                <td><button value="7" class="number-pad-dialpad-buttons">7</button></td>
                <td><button value="8" class="number-pad-dialpad-buttons">8</button></td>
                <td><button value="9" class="number-pad-dialpad-buttons">9</button></td>
            </tr>
            <tr>
                <td><button value="." class="number-pad-dialpad-buttons">.</button></td>
                <td><button value="0" class="number-pad-dialpad-buttons">0</button></td>
                <td><button value="back" class="number-pad-dialpad-buttons"><i class="fa fa-arrow-left"></i></button></td>
            </tr>
        </table>
        <div class="row mx-0">
            <div class="col-xs-6">
                <button class="btn btn-success form-control save-result-to-input">SAVE</button>
            </div>
            <div class="col-xs-6">
                <button class="btn btn-danger form-control close-dialog-box">CANCEL</button>
            </div>
        </div>
    </div>
    <input type="hidden" id="store_current_clicked_element" value="">
</div>


<div class="modal fade prescription-modal-up flow-control-modal" id="edit-data-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close modal-close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <h3 class="text-center text-white">Edit</h3>
                </h5>
            </div>
            <div class="modal-body row m-10">
                <form id="nurse-edit-post">
                    {{ Form::hidden('data_id', @$drug_list) }}
                    <div class="col-md-12 mt-20 plr-0">
                        <div class="col-md-12 form-group plr-0">
                            <div class="col-md-3 plr-0">Original Value</div>
                            <div class="col-md-9 pr-0 display-flex">
                                {{ Form::text('original_val', null, ['class'=>'form-control input-fields-shadow', 'readonly']) }}
                            </div>
                        </div>
                        <div class="col-md-12 form-group plr-0">
                            <div class="col-md-3 plr-0">New Value</div>
                            <div class="col-md-9 pr-0 display-flex">
                                {{ Form::text('edited_val', null, ['class'=>'form-control input-fields-shadow']) }}
                            </div>
                        </div>
                        <div class="col-md-12 form-group plr-0">
                            <div class="col-md-3 plr-0">Reason For Editing</div>
                            <div class="col-md-9 pr-0 display-flex">
                                {{ Form::textarea('edited_reason', null, ['class'=>'form-control input-fields-shadow', 'rows'=>'5']) }}
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="update-btn" class="btn btn-default btn-primary save-button-shadow"><b>Update</b></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade prescription-modal-up flow-control-modal" id="edit-info-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close modal-close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <h3 class="text-center text-white">Info</h3>
                </h5>
            </div>
            <div class="modal-body row m-10">
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>
<!-- /Page Content -->      
@endsection
@section('scripts')
<!-- <script type="text/javascript" src="{{ url('/') }}/public/js/jquery_mobile.js"></script> -->
<!-- <script type="text/javascript" src="{{ url('/') }}/public/js/number_pad.js"></script> -->


<script type = "text/javascript">
    $(document).on('click', '.save-result-to-input', function()
    {
        var numberpad_result = $('#dialog-input-field').val();
        $('input[name="'+$('#store_current_clicked_element').val()+'"').val($('#dialog-input-field').val());
        $('.number_pad').removeClass('highlight-box-dialpad-on');
        $('.dialog_box').dialog('close');
    });
    $(document).on('click', '.number-pad-dialpad-buttons', function()
    {
        var button_value = $(this).val();
        var exist_value = $('#dialog-input-field').val();
        if (button_value == 'back') {
            $('#dialog-input-field').val(exist_value.slice(0, -1));
        }
        else if(button_value == '.')
        {
            if(exist_value.indexOf(button_value) == -1){
                $('#dialog-input-field').val(exist_value + button_value);
            }
        }
        else
        {
            $('#dialog-input-field').val(exist_value + button_value);
        }
    });
    $(document).on('click', '.close-dialog-box', function()
    {
        $('.dialog_box').dialog("close");
        $('.number_pad').removeClass('highlight-box-dialpad-on');
    });
    $(document).on('click', '.number_pad', function()
    {
        $('#store_current_clicked_element').val('');
        var field_value = $(this).val();
        $('.number_pad').removeClass('highlight-box-dialpad-on');
        $(this).addClass('highlight-box-dialpad-on');
        var current_numberpad_element = $(this).attr('name');
        $('#store_current_clicked_element').val(current_numberpad_element);
        $('#input-info-dialpad').text($(this).data('info'));
        $('#dialog-input-field').val(field_value);
        var target_element = $(this);
        $(".dialog_box").dialog("open").position({
           my: 'left',
           at: 'right',
           of: target_element,
           appendTo: target_element
        });
    });
    $(document).ready(function () {

        $('.dialog_box').dialog(
        {
            autoOpen: false,
        });
        $('.baby-info-modal').click(function()
        {
            $('#baby-info-modal-popup').modal('show');
        });
        if ($('#dialpad_option').prop('checked') == false) {

            $('.number_pad').removeAttr('readonly');
            $('.number_pad').removeClass('number_pad');
        }
        $('#dialpad_option').change(function()
        {
            if ($(this).prop('checked') == true) {
                $('.need_dialpad').addClass('number_pad');
                $('.number_pad').attr('readonly', 'true');
            }
            else
            {
                $('.number_pad').removeAttr('readonly');
                $('.number_pad').removeClass('number_pad');
            }
        }); 
        
        $('.ivdrug_brandname').each(function () {
            $("#" + $(this).attr('id')).select2({
                allowClear: true,
                dropdownAutoWidth: false,
                placeholderOption: 'first'
            });
        });

        $('.infusion_brandname').each(function () {
            $("#" + $(this).attr('id')).select2({
                allowClear: true,
                dropdownAutoWidth: false,
                placeholderOption: 'first'
            });
        });

        $('.oral_brandname').each(function () {
            $("#" + $(this).attr('id')).select2({
                allowClear: true,
                dropdownAutoWidth: false,
                placeholderOption: 'first'
            });
        });

        $(document).on('change', '.phototherapy_toggle', function () {
            var pho_id = $(this).attr('id');
            var id = pho_id.replace('phototherapy', '');
            if (!$(this).is(':checked')) {
                $('#phototherapy_eyes' + id).val('').trigger('change');
            }
        });
        $(document).on('change', '.eyes_covered_toggle', function () {
            var pho_id = $(this).attr('id');
            var pho_val = $(this).find('option').filter(':selected').val();
            var id = pho_id.replace('phototherapy_eyes', '');
            if (pho_val == 'Yes') {
                $('#phototherapy' + id).bootstrapToggle('on');
            }
        });
    });

    $(document).on('focusout', '#nurse-form input:not(#drug_rate, .drug_total, .select2-focusser, .replacement_fluids_rate, .replacement_fluids_total, .product input, .antibiotic input)', function () {

        var fieldname = $(this).attr('name');
        var fieldval = $(this).val().trim();
        var formid = $('input[name="formid"]').val();
        $('input[name="print_flag"]').val(1);
        // if (fieldval != '' && fieldval.length > 0) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'PATCH',
                data: $('input[name="' + fieldname + '"], input[name="print_flag"], input[name="formid"], input[name="sheet_date"], input[name="BabyId"], #nurse-form input[name="admission_id"], select[name="temp_time_hour"], select[name="temp_time_min"], select[name="temp_time_session"], select[name="dcp"], select[name="hemolysis"], input[name="current_weight"], input[name="working_weight"], input[name="ett_status"], input[name="et_size"], input[name="et_length"], input[name="ngt_status"], input[name="ngt_size"], input[name="ngt_length"]').serialize(),
                url: "{{ url('nicu-nurse-sheets') }}/" + formid,
                success: function (response) {
                },
                error: function()
                {
                    $('input[name="'+fieldname+'"]').addClass('not_saved');
                }
            });
        // }
    });
    $(document).on('focusout', '#nurse-form textarea', function () {

        var fieldname = $(this).attr('name');
        var fieldval = $(this).val().trim();
        var formid = $('input[name="formid"]').val();
        $('textarea[name="print_flag"]').val(1);
        // if (fieldval != '' && fieldval.length > 0) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'PATCH',
                data: $('textarea[name="' + fieldname + '"], input[name="print_flag"], input[name="formid"], input[name="sheet_date"], input[name="BabyId"],  #nurse-form input[name="admission_id"], select[name="temp_time_hour"], select[name="temp_time_min"], select[name="temp_time_session"], select[name="dcp"], select[name="hemolysis"], input[name="current_weight"], input[name="working_weight"], input[name="ett_status"], input[name="et_size"], input[name="et_length"], input[name="ngt_status"], input[name="ngt_size"], input[name="ngt_length"]').serialize(),
                url: "{{ url('nicu-nurse-sheets') }}/" + formid,
                success: function (response) {
                },
                error: function()
                {
                    $('textarea[name="'+fieldname+'"]').addClass('not_saved');
                }
            });
        // }
    });
    $(document).on('change', '#nurse-form select:not(.drug-solution, .replacement-fluids-solution, .product select, .antibiotic select, .other_drugs)', function () {

        var fieldname = $(this).attr('name');
        var fieldval = $(this).val();

        if (fieldname.indexOf('type_of_feeds') != -1) {
            var cell_name = $(this).parent('td').attr('class');
                cell_name = cell_name.replace('typeoffeeds', 'milkfeeds');
            $('.'+cell_name).find('input').val('Yes').trigger('focusout');
        }

        var formid = $('input[name="formid"]').val(); 
        $('input[name="print_flag"]').val(1);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'PATCH',
            data: $('select[name="' + fieldname + '"], input[name="print_flag"], input[name="formid"], input[name="sheet_date"], input[name="BabyId"],  #nurse-form input[name="admission_id"], select[name="temp_time_hour"], select[name="temp_time_min"], select[name="temp_time_session"], select[name="dcp"], select[name="hemolysis"], input[name="current_weight"], input[name="working_weight"], input[name="ett_status"], input[name="et_size"], input[name="et_length"], input[name="ngt_status"], input[name="ngt_size"], input[name="ngt_length"]').serialize(),
            url: "{{ url('nicu-nurse-sheets') }}/" + formid,
            success: function (response) {
            },
            error: function()
            {
                $('select[name="'+fieldname+'"]').addClass('not_saved');
            }
        });
    });
    $(document).on('click', '.submit-btn', function (e) {
        e.preventDefault();
        var current_element = $(this);
        current_clicked_html = $(this).html();
        var print_flag = $(this).data('flag');
        if ($('input[name="current_weight"]').val() == '' || $('input[name="current_weight"]').val() == 0) {
            $('#current-weight-error').removeClass('hide');
            $('html, body').animate({scrollTop : 0},800);
            return false;
        } else {
            $('#current-weight-error').addClass('hide');
        }
        if ($('input[name="working_weight"]').val() == '' || $('input[name="working_weight"]').val() == 0) {
            $('#working-weight-error').removeClass('hide');
            $('html, body').animate({scrollTop : 0},800);
            return false;        
        } else {
            $('#working-weight-error').addClass('hide');
        }
        if ($(".not_saved").length == 0) {
            Showalert('success', "Nurse Sheet Updated Successfully...");
            return false;
        }
        $('.submit-btn').prop('disabled', true);
        $(this).html('<i class="fas fa-spinner fa-pulse"></i> Loading...');
        
        $('input:not(.not_saved), select:not(.not_saved)').attr('disabled', "true");
        $('input[type="hidden"], select[name="temp_time_hour"], select[name="temp_time_min"], select[name="temp_time_session"], select[name="dcp"], select[name="hemolysis"], input[name="sheet_date"]').removeAttr('disabled');
        // $('input[type="checkbox"]').each(function() {
            // $('input[name="'+$(this).attr('name')+'"]').remove();
        // });       
        var formid = $('input[name="formid"]').val();
        $('#print_flag').val(print_flag);
        
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'PATCH',
            data: $('input.not_saved, select.not_saved, input[name="print_flag"], input[name="formid"], input[name="sheet_date"], input[name="BabyId"],  #nurse-form input[name="admission_id"], select[name="temp_time_hour"], select[name="temp_time_min"], select[name="temp_time_session"], select[name="dcp"], select[name="hemolysis"], textarea.not_saved').serialize(),
            url: "{{ url('nicu-nurse-sheets') }}/" + formid,
            success: function (response) {
                if (print_flag == 1) {
                    Showalert('success', 'Nurse Sheet Updated Successfully');
                    current_element.html('<i class="fa fa-floppy-o"></i><span>Update</span>');
                    $('.submit-btn').prop('disabled', false);
                }
                else if(print_flag == 2)
                {
                    Showalert('success', 'Nurse Sheet Updated Successfully');
                    window.location.href = "{{ action('Nurse\NurseSheetController@GetDaylist', \SiteHelpers::encrypt_id($baby_admission_id)) }}";
                }
                else if(print_flag == 3)
                {
                    Showalert('success', 'Nurse Sheet Updated Successfully');
                    window.location.href = "{{ action('Nurse\NurseSheetController@print', \SiteHelpers::encrypt_id($id)) }}";
                }
            },
            error: function()
            {
                $('.submit-btn').prop('disabled', false);
                current_element.html(current_clicked_html);
                Showalert('error', 'Something went wrong...!');
            }
        });
        // $('#nurse-form').submit();
        $('input, select').removeAttr('disabled');
    });

    $(document).on('change', '#nurse-form .toggle.btn', function () {

        var fieldname = $(this).children('input').attr('name');
        if ($(this).hasClass('off')) {
            fieldval = 'off';
        }
        else
        {
            fieldval = 'on';
        }
        var formid = $('input[name="formid"]').val();
        $('input[name="print_flag"]').val(1);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'PATCH',
            data: $('input[name="print_flag"], input[name="formid"], input[name="sheet_date"], input[name="BabyId"],  #nurse-form input[name="admission_id"], select[name="temp_time_hour"], select[name="temp_time_min"], select[name="temp_time_session"], select[name="dcp"], select[name="hemolysis"], input[name="current_weight"], input[name="working_weight"], input[name="ett_status"], input[name="et_size"], input[name="et_length"], input[name="ngt_status"], input[name="ngt_size"], input[name="ngt_length"]').serialize()+'&'+fieldname+'='+fieldval,
            url: "{{ url('nicu-nurse-sheets') }}/" + formid,
            success: function (response) {
            }
            ,
            error: function()
            {
                $('input[name="'+fieldname+'"]').addClass('not_saved');
            }
        });
    });
    // $(document).on('change', '#nurse-form .drug-solution', function () {

    //     var drugsolution, drugrate;

    //     $('#pn_drugs').find('select').each(function (index, elm) {
    //         if (typeof drugsolution == 'undefined') {
    //             drugsolution = 'select[name="' + elm.name + '"],';
    //         } else {
    //             drugsolution += 'select[name="' + elm.name + '"],';
    //         }
    //     });
    //     $('#pn_drugs').find('input.form-control').each(function (index, elm) {
    //         if (typeof drugrate == 'undefined') {
    //             drugrate = 'input[name="' + elm.name + '"],';
    //         } else {
    //             drugrate += 'input[name="' + elm.name + '"],';
    //         }
    //     });

    //     var currentdrugname = $(this).parents('tr').find('select').val();
    //     var currentdrugrate = $(this).parents('tr').find('input#drug_rate').val();
    //     var currentdrugtotal = $(this).parents('tr').find('input.drug_total').val();

    //     if (currentdrugname != '' && currentdrugrate != '' && currentdrugtotal != '') {

    //         var formid = $('input[name="formid"]').val();
    //         $('input[name="print_flag"]').val(1);
    //         $.ajax({
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             },
    //             type: 'PATCH',
    //             data: $(drugsolution + drugrate + ' input[name="print_flag"], input[name="formid"], input[name="sheet_date"], input[name="BabyId"],  #nurse-form input[name="admission_id"], select[name="temp_time_hour"], select[name="temp_time_min"], select[name="temp_time_session"], select[name="dcp"], select[name="hemolysis"]').serialize(),
    //             url: "{{ url('nicu-nurse-sheets') }}/" + formid,
    //             success: function (response) {
    //                 if (response.messageType == 'success') {
    //                     Showalert(response.messageType, response.message);
    //                 } else {
    //                     Showalert(response.messageType, response.message);
    //                 }
    //             }
    //         });
    //     }
    // });
    // $(document).on('focusout', '#nurse-form #drug_rate, #nurse-form .drug_total', function () {

    //     var drugsolution, drugrate;

    //     $('#pn_drugs').find('select').each(function (index, elm) {
    //         if (typeof drugsolution == 'undefined') {
    //             drugsolution = 'select[name="' + elm.name + '"],';
    //         } else {
    //             drugsolution += 'select[name="' + elm.name + '"],';
    //         }
    //     });
    //     $('#pn_drugs').find('input.form-control').each(function (index, elm) {
    //         if (typeof drugrate == 'undefined') {
    //             drugrate = 'input[name="' + elm.name + '"],';
    //         } else {
    //             drugrate += 'input[name="' + elm.name + '"],';
    //         }
    //     });

    //     var currentdrugname = $(this).parents('tr').find('select').val();
    //     var currentdrugrate = $(this).parents('tr').find('input#drug_rate').val();
    //     var currentdrugtotal = $(this).parents('tr').find('input.drug_total').val();

    //     if (currentdrugname != '' && currentdrugrate != '' && currentdrugtotal != '') {

    //         var formid = $('input[name="formid"]').val();
    //         $('input[name="print_flag"]').val(1);
    //         $.ajax({
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             },
    //             type: 'PATCH',
    //             data: $(drugsolution + drugrate + ' input[name="print_flag"], input[name="formid"], input[name="sheet_date"], input[name="BabyId"],  #nurse-form input[name="admission_id"], select[name="temp_time_hour"], select[name="temp_time_min"], select[name="temp_time_session"], select[name="dcp"], select[name="hemolysis"]').serialize(),
    //             url: "{{ url('nicu-nurse-sheets') }}/" + formid,
    //             success: function (response) {
    //                 if (response.messageType == 'success') {
    //                     Showalert(response.messageType, response.message);
    //                 } else {
    //                     Showalert(response.messageType, response.message);
    //                 }
    //             }
    //         });
    //     }

    // });
    // $(document).on('change', '#nurse-form .replacement-fluids-solution', function () {

    //     var drugsolution, drugrate;

    //     $('#replacement_fluids').find('select').each(function (index, elm) {
    //         if (typeof drugsolution == 'undefined') {
    //             drugsolution = 'select[name="' + elm.name + '"],';
    //         } else {
    //             drugsolution += 'select[name="' + elm.name + '"],';
    //         }
    //     });
    //     $('#replacement_fluids').find('input.form-control').each(function (index, elm) {
    //         if (typeof drugrate == 'undefined') {
    //             drugrate = 'input[name="' + elm.name + '"],';
    //         } else {
    //             drugrate += 'input[name="' + elm.name + '"],';
    //         }
    //     });

    //     var currentdrugname = $(this).parents('tr').find('select').val();
    //     var currentdrugrate = $(this).parents('tr').find('input.replacement_fluids_rate').val();
    //     var currentdrugtotal = $(this).parents('tr').find('input.replacement_fluids_total').val();

    //     if (currentdrugname != '' && currentdrugrate != '' && currentdrugtotal != '') {

    //         var formid = $('input[name="formid"]').val();
    //         $('input[name="print_flag"]').val(1);
    //         $.ajax({
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             },
    //             type: 'PATCH',
    //             data: $(drugsolution + drugrate + ' input[name="print_flag"], input[name="formid"], input[name="sheet_date"], input[name="BabyId"],  #nurse-form input[name="admission_id"], select[name="temp_time_hour"], select[name="temp_time_min"], select[name="temp_time_session"], select[name="dcp"], select[name="hemolysis"]').serialize(),
    //             url: "{{ url('nicu-nurse-sheets') }}/" + formid,
    //             success: function (response) {
    //                 if (response.messageType == 'success') {
    //                     Showalert(response.messageType, response.message);
    //                 } else {
    //                     Showalert(response.messageType, response.message);
    //                 }
    //             }
    //         });
    //     }
    // });
    // $(document).on('focusout', '#nurse-form .replacement_fluids_rate, #nurse-form .replacement_fluids_total', function () {

    //     var drugsolution, drugrate;

    //     $('#replacement_fluids').find('select').each(function (index, elm) {
    //         if (typeof drugsolution == 'undefined') {
    //             drugsolution = 'select[name="' + elm.name + '"],';
    //         } else {
    //             drugsolution += 'select[name="' + elm.name + '"],';
    //         }
    //     });
    //     $('#replacement_fluids').find('input.form-control').each(function (index, elm) {
    //         if (typeof drugrate == 'undefined') {
    //             drugrate = 'input[name="' + elm.name + '"],';
    //         } else {
    //             drugrate += 'input[name="' + elm.name + '"],';
    //         }
    //     });

    //     var currentdrugname = $(this).parents('tr').find('select').val();
    //     var currentdrugrate = $(this).parents('tr').find('input.replacement_fluids_rate').val();
    //     var currentdrugtotal = $(this).parents('tr').find('input.replacement_fluids_total').val();

    //     if (currentdrugname != '' && currentdrugrate != '' && currentdrugtotal != '') {

    //         var formid = $('input[name="formid"]').val();
    //         $('input[name="print_flag"]').val(1);
    //         $.ajax({
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             },
    //             type: 'PATCH',
    //             data: $(drugsolution + drugrate + ' input[name="print_flag"], input[name="formid"], input[name="sheet_date"], input[name="BabyId"],  #nurse-form input[name="admission_id"], select[name="temp_time_hour"], select[name="temp_time_min"], select[name="temp_time_session"], select[name="dcp"], select[name="hemolysis"]').serialize(),
    //             url: "{{ url('nicu-nurse-sheets') }}/" + formid,
    //             success: function (response) {
    //                 if (response.messageType == 'success') {
    //                     Showalert(response.messageType, response.message);
    //                 } else {
    //                     Showalert(response.messageType, response.message);
    //                 }
    //             }
    //         });
    //     }

    // });
    $(document).on('focusout', '#nurse-form .product select, #nurse-form .product input', function () {

        var drugsolution, drugrate;

        $('.product').find('select').each(function (index, elm) {
            if (typeof drugsolution == 'undefined') {
                drugsolution = 'select[name="' + elm.name + '"],';
            } else {
                drugsolution += 'select[name="' + elm.name + '"],';
            }
        });
        $('.product').find('input.form-control').each(function (index, elm) {
            if (typeof drugrate == 'undefined') {
                drugrate = 'input[name="' + elm.name + '"],';
            } else {
                drugrate += 'input[name="' + elm.name + '"],';
            }
        });

        var currentdrugname = $(this).parents('tr').find('select').val();
        var currentdrugrate = $(this).parents('tr').find('input').val();

        if (currentdrugname != '' && currentdrugrate != '') {

            var formid = $('input[name="formid"]').val();
            $('input[name="print_flag"]').val(1);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'PATCH',
                data: $(drugsolution + drugrate + ' input[name="print_flag"], input[name="formid"], input[name="sheet_date"], input[name="BabyId"],  #nurse-form input[name="admission_id"], select[name="temp_time_hour"], select[name="temp_time_min"], select[name="temp_time_session"], select[name="dcp"], select[name="hemolysis"], input[name="current_weight"], input[name="working_weight"], input[name="ett_status"], input[name="et_size"], input[name="et_length"], input[name="ngt_status"], input[name="ngt_size"], input[name="ngt_length"]').serialize(),
                url: "{{ url('nicu-nurse-sheets') }}/" + formid,
                success: function (response) {
                    if (response.messageType == 'success') {
                        Showalert(response.messageType, response.message);
                    } else {
                        Showalert(response.messageType, response.message);
                    }
                }
            });
        }

    });
    $(document).on('change', '#nurse-form .antibiotic select', function () {

        var drugsolution, drugrate;

        $('.antibiotic').find('select').each(function (index, elm) {
            if (typeof drugsolution == 'undefined') {
                drugsolution = 'select[name="' + elm.name + '"],';
            } else {
                drugsolution += 'select[name="' + elm.name + '"],';
            }
        });
        $('.antibiotic').find('input.form-control').each(function (index, elm) {
            if (typeof drugrate == 'undefined') {
                drugrate = 'input[name="' + elm.name + '"],';
            } else {
                drugrate += 'input[name="' + elm.name + '"],';
            }
        });

        var currentdrugname = $(this).parents('tr').find('select').val();
        var currentdrugrate = $(this).parents('tr').find('input.form-control').val();

        if (currentdrugname != '' && currentdrugrate != '') {

            var formid = $('input[name="formid"]').val();
            $('input[name="print_flag"]').val(1);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'PATCH',
                data: $(drugsolution + drugrate + ' input[name="print_flag"], input[name="formid"], input[name="sheet_date"], input[name="BabyId"],  #nurse-form input[name="admission_id"], select[name="temp_time_hour"], select[name="temp_time_min"], select[name="temp_time_session"], select[name="dcp"], select[name="hemolysis"], input[name="current_weight"], input[name="working_weight"], input[name="ett_status"], input[name="et_size"], input[name="et_length"], input[name="ngt_status"], input[name="ngt_size"], input[name="ngt_length"]').serialize(),
                url: "{{ url('nicu-nurse-sheets') }}/" + formid,
                success: function (response) {
                    if (response.messageType == 'success') {
                        Showalert(response.messageType, response.message);
                    } else {
                        Showalert(response.messageType, response.message);
                    }
                }
            });
        }

    });
    $(document).on('focusout', '#nurse-form .antibiotic input', function () {

        var drugsolution, drugrate;

        $('.antibiotic').find('select').each(function (index, elm) {
            if (typeof drugsolution == 'undefined') {
                drugsolution = 'select[name="' + elm.name + '"],';
            } else {
                drugsolution += 'select[name="' + elm.name + '"],';
            }
        });
        $('.antibiotic').find('input.form-control').each(function (index, elm) {
            if (typeof drugrate == 'undefined') {
                drugrate = 'input[name="' + elm.name + '"],';
            } else {
                drugrate += 'input[name="' + elm.name + '"],';
            }
        });

        var currentdrugname = $(this).parents('tr').find('select').val();
        var currentdrugrate = $(this).parents('tr').find('input.form-control').val();

        if (currentdrugname != '' && currentdrugrate != '') {

            var formid = $('input[name="formid"]').val();
            $('input[name="print_flag"]').val(1);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'PATCH',
                data: $(drugsolution + drugrate + ' input[name="print_flag"], input[name="formid"], input[name="sheet_date"], input[name="BabyId"],  #nurse-form input[name="admission_id"], select[name="temp_time_hour"], select[name="temp_time_min"], select[name="temp_time_session"], select[name="dcp"], select[name="hemolysis"], input[name="current_weight"], input[name="working_weight"], input[name="ett_status"], input[name="et_size"], input[name="et_length"], input[name="ngt_status"], input[name="ngt_size"], input[name="ngt_length"]').serialize(),
                url: "{{ url('nicu-nurse-sheets') }}/" + formid,
                success: function (response) {
                    if (response.messageType == 'success') {
                        Showalert(response.messageType, response.message);
                    } else {
                        Showalert(response.messageType, response.message);
                    }
                }
            });
        }

    });
    $(document).on('change', '#nurse-form .other_drugs', function () {

        var drugsolution;

        $('.other-drug-table').find('select').each(function (index, elm) {
            if (typeof drugsolution == 'undefined') {
                drugsolution = 'select[name="' + elm.name + '"],';
            } else {
                drugsolution += 'select[name="' + elm.name + '"],';
            }
        });

        // var fieldname = $(this).attr('name');
        // var fieldval = $(this).val();

        var formid = $('input[name="formid"]').val();
        $('input[name="print_flag"]').val(1);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'PATCH',
            data: $(drugsolution+' input[name="print_flag"], input[name="formid"], input[name="sheet_date"], input[name="BabyId"],  #nurse-form input[name="admission_id"], select[name="temp_time_hour"], select[name="temp_time_min"], select[name="temp_time_session"], select[name="dcp"], select[name="hemolysis"], input[name="current_weight"], input[name="working_weight"], input[name="ett_status"], input[name="et_size"], input[name="et_length"], input[name="ngt_status"], input[name="ngt_size"], input[name="ngt_length"]').serialize(),
            url: "{{ url('nicu-nurse-sheets') }}/" + formid,
            success: function (response) {
            }
        });

    });
    // $('#input-output input, #input-output select').prop('disabled', true);
    // $('#input-output .add-blood-product-list, #input-output .add-antibio-list, #input-output .add-other-drugs-list').off('click')

    // $('input[name="approve_all"]').click(function() {
    //     var check_val = $(this).is(':checked');
    //     $('input[name="approve_stime"]').each(function() {
    //         $(this).prop('checked', check_val);
    //     });
    // }); 

    // $('input[name="approve_stime"]').click(function() {
    //     var time = $(this).attr('id');
    //         time = time.replace('approve-stime-', '');
    //     var pump_id = [];
    //     if ($(this).is(':checked')) {
    //         bootbox.confirm("Are you approving all infusing data of `"+time+"` ?", function(confirmed) {
    //             if (confirmed) {
    //                 time = time.replace(':00', '');
    //                     console.log('#row-time-'+time);
    //                 $('#row-time-'+time+' input[name^="pump_drug_total"]').each(function() {
    //                     var id = $(this).attr('name');
    //                         id = id.replace('pump_drug_total[', '');
    //                         id = id.replace(']', '');
    //                     pump_id.push(id);
    //                 });
    //                 console.log(pump_id);
    //                 $.ajax({
    //                     headers: {
    //                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //                     },
    //                     type: 'PATCH',
    //                     data: {prescription_id: pump_id},
    //                     url: "{{ url('pump-data-approval') }}",
    //                     success: function (response) {
    //                         if (response.messageType == 'success') {
    //                             Showalert(response.messageType, response.message);
    //                         }
    //                     }
    //                 });
    //             }
    //         });
    //     }
    // }); 

    // $(document).on('click', '.row-time', function() {
    //     var field_name = $(this).children().attr('name');
    //     var original = $(this).children().attr('data-original');
    //     var newval = $(this).children().attr('data-new');
    //     var reason = $(this).children().attr('data-reason');
    //     var id = field_name;
    //         id = id.replace('pump_drug_total[', '');
    //         id = id.replace(']', '');

    //     $('#edit-data-modal').modal({
    //         backdrop: 'static',
    //         keyboard: false,
    //         show: true
    //     });

    //     $('input[name="data_id"]').val(id);
    //     $('input[name="original_val"]').val(original);
    //     if (original == newval) {
    //         newval = '';
    //     }
    //     $('input[name="edited_val"]').val(newval);
    //     $('textarea[name="edited_reason"]').val(reason);
    // });

    // $(document).on('click', '#update-btn', function() {
    //     var data_id = $("input[name='data_id']").val();
    //     var updated_val = $("input[name='edited_val']").val();
    //     $.ajax({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         type: 'PATCH',
    //         data: $("#nurse-edit-post").serialize(),
    //         url: "{{ url('pump-data-update') }}",
    //         success: function(response) {
    //             if (response.messageType == 'success') {
    //                 $('input[name="pump_drug_total['+data_id+']"]').val(updated_val);
    //                 $('#edit-data-modal').modal('hide');
    //                 Showalert(response.messageType, response.message);
    //             }
    //         }
    //     });
    // });

    // $('.approve-edit').on('click', function() {
    //     var id = $(this).attr('data-id');
    //     $('#edit-info-modal').modal({
    //         backdrop: 'static',
    //         keyboard: false,
    //         show: true
    //     });
    //     $.ajax({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         type: 'GET',
    //         data: {data_id: id},
    //         url: "{{ url('pump-data-info') }}",
    //         success: function(response) {
    //             if (response.messageType == 'success') {
    //                 var info = response.info;

    //                 var original_val = info.original_infused;
    //                 var approved_by = info.approved_by;
    //                 var approved_date_time = info.approved_date_time;
    //                 var edited_by = info.edited_by;
    //                 var edited_date_time = info.edited_date_time;
    //                 var edited_reason = info.edited_reason;

    //                 var approved_dtl = edited_dtl = '';

    //                 if (approved_date_time != null) {
    //                     var approved_date = approved_date_time.split('-');
    //                     var approved_day = approved_date[2].split(' ')[0];
    //                     var approved_time = approved_date[2].split(' ')[1].split(':');
    //                     approved_date_time = new Date(approved_date[0], (approved_date[1] - 1), approved_day, approved_time[0], approved_time[1]);

    //                     var date = (approved_date_time.getDate() > 9) ? approved_date_time.getDate() : '0' + approved_date_time.getDate();
    //                     var month = ((approved_date_time.getMonth() + 1) > 9) ? (approved_date_time.getMonth() + 1) : ('0' + (approved_date_time.getMonth() + 1));
    //                     var year = approved_date_time.getFullYear();

    //                     var hours = approved_date_time.getHours();
    //                     var ampm = (hours >= 12) ? "PM" : "AM";
    //                     var hours = (hours > 12) ? (hours - 12) : ((hours == 0) ? "12" : hours);
    //                     var minutes = approved_date_time.getMinutes();
    //                     var approved_date_time = date + '-' + month + '-' + year + ' ' + hours + ':' + minutes + ' ' + ampm;

    //                     approved_dtl = '<tr><td><b>Approved By:</b></td><td>'+approved_by+'</td></tr><tr><td><b>Approved Date & Time:</b></td><td>'+approved_date_time+'</td></tr>';
    //                 }

    //                 if (edited_date_time != null) {
    //                     var edited_date = edited_date_time.split('-');
    //                     var edited_day = edited_date[2].split(' ')[0];
    //                     var edited_time = edited_date[2].split(' ')[1].split(':');
    //                     edited_date_time = new Date(edited_date[0], (edited_date[1] - 1), edited_day, edited_time[0], edited_time[1]);

    //                     var date = (edited_date_time.getDate() > 9) ? edited_date_time.getDate() : '0' + edited_date_time.getDate();
    //                     var month = ((edited_date_time.getMonth() + 1) > 9) ? (edited_date_time.getMonth() + 1) : ('0' + (edited_date_time.getMonth() + 1));
    //                     var year = edited_date_time.getFullYear();

    //                     var hours = edited_date_time.getHours();
    //                     var ampm = (hours >= 12) ? "PM" : "AM";
    //                     var hours = (hours > 12) ? (hours - 12) : ((hours == 0) ? "12" : hours);
    //                     var minutes = edited_date_time.getMinutes();
    //                     var edited_date_time = date + '-' + month + '-' + year + ' ' + hours + ':' + minutes + ' ' + ampm;

    //                     edited_dtl = '<tr><td><b>Edited By:</b></td><td>'+edited_by+'</td></tr><tr><td><b>Edited Date & Time:</b></td><td>'+edited_date_time+'</td></tr><tr><td><b>Edited Reason:</b></td><td>'+edited_reason+'</td></tr>';
    //                 }

    //                 $('.modal-body').html('<table><tr><td><b>Original Value:</b></td><td>'+original_val+'</td></tr>'+approved_dtl+edited_dtl+'</table>');
    //             }
    //         }
    //     });
    // });

    
  $('#ett_status').on('change', function() {
      if ($(this).prop("checked")) {
          $('.ett-enable').removeClass('display-none');
      } else {
          $('.ett-enable').addClass('display-none');
      }
  });
  $('#ngt_status').on('change', function() {
      if ($(this).prop("checked")) {
          $('.ngt-enable').removeClass('display-none');
      } else {
          $('.ngt-enable').addClass('display-none');
      }
  });
  

  $('.add-instruction').on('click', function() {
    var id = $(this).attr('data-header-id');
    $(this).remove();
    $('textarea[name="ward_rounds_instruction['+id+']"]').removeClass('display-none');
  });
</script>
@endsection
