@extends('app')
@section('content')
<style type="text/css">
    .ui-datepicker
    {
        z-index: 1050 !important;
    }
    .diagnosis-status-wrapper .diagnosis-status-option{
      background: #fff;
      height: 100%;
      width: 20%;
      display: inline-flex;
      align-items: center;
      justify-content: space-evenly;
      border-radius: 5px;
      cursor: pointer;
      padding: 0 10px;
      border: 2px solid lightgrey;
      transition: all 0.3s ease;
    }
    .diagnosis-status-wrapper .diagnosis-status-option.status-passive {
        margin: 0px 10px;
    }
    .diagnosis-status-wrapper .diagnosis-status-option .dot{
      height: 20px;
      width: 20px;
      background: #d9d9d9;
      border-radius: 50%;
      position: relative;
    }
    .diagnosis-status-wrapper .diagnosis-status-option .dot::before{
      position: absolute;
      content: "";
      top: 4px;
      left: 4px;
      width: 12px;
      height: 12px;
      background: #0069d9;
      border-radius: 50%;
      opacity: 0;
      transform: scale(1.5);
      transition: all 0.3s ease;
    }
    .diagnosis-status-wrapper .status-active .dot::before{
      background: #f7bd7e;
    }
    .diagnosis-status-wrapper .status-passive .dot::before{
      background: #58cc90;
    }
    .diagnosis-status-wrapper input[type="radio"]{
      display: none;
    }
    #status-active:checked:checked ~ .status-active
    {
        border-color: #f7bd7e;
        background: #f7bd7e;
    }
    #status-passive:checked:checked ~ .status-passive{
      border-color: #58cc90;
      background: #58cc90;
    }
    #status-active:checked:checked ~ .status-active .dot,
    #status-passive:checked:checked ~ .status-passive .dot{
      background: #fff;
    }
    #status-active:checked:checked ~ .status-active .dot::before,
    #status-passive:checked:checked ~ .status-passive .dot::before{
      opacity: 1;
      transform: scale(1);
    }
    .diagnosis-status-wrapper .diagnosis-status-option span{
      font-size: 20px;
      color: #808080;
    }
    #status-active:checked:checked ~ .status-active span,
    #status-passive:checked:checked ~ .status-passive span{
      color: #fff;
    }
    .select2.select2-container
    {
        width: 100% !important;
    }
    .clinical-event-list
    {
        list-style-type: none;
        padding: 0px !important;
    }
    .active-clinical-event-list .clinical-event-list li
    {
        background-color: #f7bd7e;
        padding: 10px 15px;
        margin-bottom: 2px !important;
    }
    .passive-clinical-event-list .clinical-event-list li
    {
        background-color: #58cc90;
        padding: 10px 15px;
        margin-bottom: 2px !important;
    }
    .clinical-event-list h5, .clinical-event-list table
    {
        margin: 0px !important;
    }
    .passive-clinical-event-list .clinical-event-list table td h5
    {
        color: #fff !important;
    }
    .active-clinical-event-list .clinical-event-list table td h5
    {
        color: #666 !important;
    }
    .clinical-event-list td
    {
        padding: 0px !important;
    }
    .clinical-event-list table td
    {
        vertical-align: middle !important;
        border-top: 0px !important;
    }
    .clinical-event-remove-btn
    {
        margin-left: 4px;
    }
    .pl-7 {
        padding-left: 7px;
    }
</style>
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li><i class="icon-home"></i><a href="{{url('/')}}">{{ Lang::get('home.daycare_dashboard') }}</a></li>
        <li>Clinical Event Markers</li>
        <li class="active text-captialize">{{ $baby->BabyName }}</li>
    </ul>
    <div class="pull-right mr-20">
        @php 
            $mrn = $baby->BMrNo; 
            echo \SiteHelpers::menuList($mrn, $admission_id, 'clinical_event_markers');
        @endphp
    </div>
</div>
<div class="row row-spacing">
    <div class="col-md-12">
        <div class="widget box table-view-shadow">
            <div class="widget-header">
                <h4>Event List</h4>
                <a href="javascript:void(0);" title="" class="btn btn-basic-shadow create-btn-spacing btn-info pull-right create-btn add-care-event not-disabled">
                    <i class="fa fa-plus"></i> <span>Add New Event</span>
                </a>
            </div>
            <div class="widget-content">
                <div class="row">
                    @php
                        $active_event_list = $clinical_events->where('diagnosis_status','active')->toArray();
                        $passive_event_list = $clinical_events->where('diagnosis_status','passive')->toArray();
                    @endphp

                    <div class="col-md-6 active-clinical-event-list">
                        <div class="widget box table-view-shadow">
                            <div class="widget-header">
                                <h4>Active Events</h4>
                            </div>
                            <div class="widget-content">
                                <ul class="clinical-event-list">
                                @if(count($active_event_list) > 0)
                                    @foreach($active_event_list as $active_key => $active_val)
                                    <li id="clinical-event_{{ $active_val['id'] }}">
                                        <table class="table table-responsive">
                                            <tr>
                                                <td valign="middle">
                                                    <h5>
                                                        <strong>
                                                            @if (!empty($active_val['diagnosis']))
                                                                {{ $active_val['ICDDescription'] }}
                                                            @else
                                                                {{ $active_val['other_diagnosis'] }}
                                                            @endif
                                                        </strong>
                                                    </h5>
                                                </td>
                                                <td class="text-right" width="60px">
                                                    <input type="hidden" id="clinical-event-diagnosis_{{ $active_val['id'] }}" value="{{ $active_val['diagnosis'] }}" />
                                                    <input type="hidden" id="clinical-event-other-diagnosis_{{ $active_val['id'] }}" value="{{ $active_val['other_diagnosis'] }}" />
                                                    <input type="hidden" id="clinical-event-date-of-diagnosis_{{ $active_val['id'] }}" value="{{ $active_val['date_of_diagnosis'] }}" />
                                                    <input type="hidden" id="clinical-event-time-of-diagnosis_{{ $active_val['id'] }}" value="{{ $active_val['time_of_diagnosis'] }}" />
                                                    <input type="hidden" id="clinical-event-min-of-diagnosis_{{ $active_val['id'] }}" value="{{ $active_val['min_of_diagnosis'] }}" />
                                                    <input type="hidden" id="clinical-event-session-of-diagnosis_{{ $active_val['id'] }}" value="{{ $active_val['session_of_diagnosis'] }}" />
                                                    <input type="hidden" id="clinical-event-date-of-resolution_{{ $active_val['id'] }}" value="{{ $active_val['date_of_resolution'] }}" />
                                                    <input type="hidden" id="clinical-event-time-of-resolution_{{ $active_val['id'] }}" value="{{ $active_val['time_of_resolution'] }}" />
                                                    <input type="hidden" id="clinical-event-min-of-resolution_{{ $active_val['id'] }}" value="{{ $active_val['min_of_resolution'] }}" />
                                                    <input type="hidden" id="clinical-event-session-of-resolution_{{ $active_val['id'] }}" value="{{ $active_val['session_of_resolution'] }}" />
                                                    <input type="hidden" id="clinical-event-diagnosis-status_{{ $active_val['id'] }}" value="{{ $active_val['diagnosis_status'] }}" />
                                                    <input type="hidden" id="clinical-event-comments_{{ $active_val['id'] }}" value="{{ $active_val['comments'] }}" />
                                                    <a href="javascript:void(0)" data-clinical_event_id="{{ $active_val['id'] }}" class="btn btn-primary btn-view clinical-event-edit-btn"><i class="fa fa-pencil-square-o"></i></a>
                                                    <a href="javascript:void(0)" data-clinical_event_id="{{ $active_val['id'] }}" class="btn btn-danger btn-view clinical-event-remove-btn"><i class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        </table>
                                    </li>
                                    @endforeach
                                @else
                                    <h6 class="text-center"><strong>No events found...</strong></h6>
                                @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 passive-clinical-event-list">
                        <div class="widget box table-view-shadow">
                            <div class="widget-header">
                                <h4>Passive Events</h4>
                            </div>
                            <div class="widget-content">
                                <ul class="clinical-event-list">
                                @if(count($passive_event_list) > 0)
                                    @foreach($passive_event_list as $passive_key => $passive_val)
                                    <li id="clinical-event_{{ $passive_val['id'] }}">
                                        <table class="table table-responsive">
                                            <tr>
                                                <td valign="middle">
                                                    <h5>
                                                        <strong>
                                                            @if (!empty($passive_val['diagnosis']))
                                                                {{ $passive_val['ICDDescription'] }}
                                                            @else
                                                                {{ $passive_val['other_diagnosis'] }}
                                                            @endif
                                                        </strong>
                                                    </h5>
                                                </td>
                                                <td class="text-right" width="60px">
                                                    <input type="hidden" id="clinical-event-diagnosis_{{ $passive_val['id'] }}" value="{{ $passive_val['diagnosis'] }}" />
                                                    <input type="hidden" id="clinical-event-other-diagnosis_{{ $passive_val['id'] }}" value="{{ $passive_val['other_diagnosis'] }}" />
                                                    <input type="hidden" id="clinical-event-date-of-diagnosis_{{ $passive_val['id'] }}" value="{{ $passive_val['date_of_diagnosis'] }}" />
                                                    <input type="hidden" id="clinical-event-time-of-diagnosis_{{ $passive_val['id'] }}" value="{{ $passive_val['time_of_diagnosis'] }}" />
                                                    <input type="hidden" id="clinical-event-min-of-diagnosis_{{ $passive_val['id'] }}" value="{{ $passive_val['min_of_diagnosis'] }}" />
                                                    <input type="hidden" id="clinical-event-session-of-diagnosis_{{ $passive_val['id'] }}" value="{{ $passive_val['session_of_diagnosis'] }}" />
                                                    <input type="hidden" id="clinical-event-date-of-resolution_{{ $passive_val['id'] }}" value="{{ $passive_val['date_of_resolution'] }}" />
                                                    <input type="hidden" id="clinical-event-time-of-resolution_{{ $passive_val['id'] }}" value="{{ $passive_val['time_of_resolution'] }}" />
                                                    <input type="hidden" id="clinical-event-min-of-resolution_{{ $passive_val['id'] }}" value="{{ $passive_val['min_of_resolution'] }}" />
                                                    <input type="hidden" id="clinical-event-session-of-resolution_{{ $passive_val['id'] }}" value="{{ $passive_val['session_of_resolution'] }}" />
                                                    <input type="hidden" id="clinical-event-diagnosis-status_{{ $passive_val['id'] }}" value="{{ $passive_val['diagnosis_status'] }}" />
                                                    <input type="hidden" id="clinical-event-comments_{{ $passive_val['id'] }}" value="{{ $passive_val['comments'] }}" />
                                                    <a href="javascript:void(0)" data-clinical_event_id="{{ $passive_val['id'] }}" class="btn btn-primary btn-view clinical-event-edit-btn"><i class="fa fa-pencil-square-o"></i></a>
                                                    <a href="javascript:void(0)" data-clinical_event_id="{{ $passive_val['id'] }}" class="btn btn-danger btn-view clinical-event-remove-btn"><i class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        </table>
                                    </li>
                                    @endforeach
                                @else
                                    <h6 class="text-center"><strong>No events found...</strong></h6>
                                @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade flow-control-modal" id="clinical-event-modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="text-center text-white event-title"><span id="form-type"></span> Event</h3>
                <button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true" style="color:white"><i class="fa fa-times"></i></button>
            </div>
            <div class="modal-body mt-20">
                <form id="clinical-event-form">
                    <input type="hidden" name="baby_id" value="{{ $baby_id }}">
                    <input type="hidden" name="admission_id" value="{{ $admission_id }}">
                    <div class="form-group row mx-0">
                        <div class="col-md-3 text-right label-control">
                            Select Diagnosis
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::Select('diagnosis',$ICD,null,['class'=> 'clinical-event-dropdown full-width-fix']) !!}
                        </div>
                    </div>
                    <div class="form-group row mx-0">
                        <div class="col-md-3 text-right label-control">
                            Other Diagnosis
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('other_diagnosis',null,['class'=>'form-control clinical-event-text']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                            Date of Diagnosis
                        </div>
                        <div class="col-md-9 custom-input clear-xs">
                                <div class="col-xs-3 pr-0 pl-7 text-center">
                                    <small>(Date)</small>
                                </div>
                                <div class="col-xs-6 plr-0 text-center">
                                    <small>(Time)</small>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-xs-3 pr-0 pl-7">
                                    {!! Form::text('date_of_diagnosis',null,['class'=>'form-control datepicker', 'readonly']) !!}
                                </div>
                                <div class="col-xs-9 plr-0">
                                    <div class="col-xs-3 pr-0 pl-5">{!! Form::select('time_of_diagnosis',$time['time'],null,['class'=>'form-control']) !!}</div>
                                    <div class="col-xs-3 pl-5 pr-0">{!! Form::select('min_of_diagnosis',$time['mins'],null,['class'=>'form-control']) !!}</div>
                                    <div class="col-xs-3 pl-5 pr-0">{!! Form::select('session_of_diagnosis',$time['session'],null,['class'=>'form-control']) !!}</div>
                                </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                            Date of Resolution
                        </div>
                        <div class="col-md-9 custom-input clear-xs">
                                <div class="col-xs-3 pr-0 pl-7 text-center">
                                    <small>(Date)</small>
                                </div>
                                <div class="col-xs-6 plr-0 text-center">
                                    <small>(Time)</small>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-xs-3 pr-0 pl-7">
                                    {!! Form::text('date_of_resolution',null,['class'=>'form-control datepicker', 'readonly']) !!}
                                </div>
                                <div class="col-xs-9 plr-0">
                                    <div class="col-xs-3 pr-0 pl-5">{!! Form::select('time_of_resolution',$time['time'],null,['class'=>'form-control']) !!}</div>
                                    <div class="col-xs-3 pl-5 pr-0">{!! Form::select('min_of_resolution',$time['mins'],null,['class'=>'form-control']) !!}</div>
                                    <div class="col-xs-3 pl-5 pr-0">{!! Form::select('session_of_resolution',$time['session'],null,['class'=>'form-control']) !!}</div>
                                </div>
                        </div>
                    </div>
                    <div class="form-group row mx-0">
                        <div class="col-md-3 text-right label-control">
                            Diagnosis Status
                        </div>
                        <div class="col-md-9 custom-input">
                            <div class="diagnosis-status-wrapper">
                                <input type="radio" name="diagnosis_status" id="status-active" value="active" />
                                <input type="radio" name="diagnosis_status" id="status-passive" value="passive" />
                                <label for="status-active" class="diagnosis-status-option status-active">
                                    <div class="dot"></div>
                                    <span>Active</span>
                                </label>
                                <label for="status-passive" class="diagnosis-status-option status-passive">
                                    <div class="dot"></div>
                                    <span>Passive</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mx-0">
                        <div class="col-md-3 text-right label-control">
                            Comments
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::textarea('comments',null,['class'=>'form-control', 'id'=>'diagnosis-comments']) !!}
                        </div>
                    </div>
                    <div class="row mx-0 mb-20">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-success mr-15" id="save-clinical-event-btn"><i class="fa fa-save"></i>&ensp; <span id="form-btn-type"></span> Event</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('.clinical-event-dropdown').select2(
        {
            dropdownParent: $('#clinical-event-modal'),
            placeholder: '-- Select --'
        });
    });

    $(document).on('submit', '#clinical-event-form', function(e){
        e.preventDefault();
        if($('select[name="diagnosis"]').val() || $('.clinical-event-text').val())
        {
            if ($('input[name="diagnosis_status"]:checked').length > 0) {

                var diagnosis_status = $('input[name="diagnosis_status"]:checked').val();
                var disgnosis_content = $('select[name=diagnosis] option:selected').text();
                if (disgnosis_content.length == 0 || disgnosis_content == null || disgnosis_content == '') {
                    disgnosis_content = $('input[name="other_diagnosis"]').val();
                }
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type:'POST',
                    url:'{{ action("ClinicalEventController@store") }}',
                    data: $('#clinical-event-form').serialize(),
                    beforeSend:function() {
                        $('#save-clinical-event-btn').prop('disabled', true).html('<i class="fas fa-spinner fa-pulse"></i>&ensp;Loading');
                    },
                    success:function(response) {
                        var id = response.id;
                        var append_html = '<table class="table table-responsive"><tr><td width="90%" valign="middle"><h5><strong>'+disgnosis_content+'</strong></h5></td><td class="text-right"><input type="hidden" id="clinical-event-diagnosis_'+id+'" value="'+$('select[name=diagnosis]').val()+'" /><input type="hidden" id="clinical-event-other-diagnosis_'+id+'" value="'+$('input[name="other_diagnosis"]').val()+'" /><input type="hidden" id="clinical-event-date-of-diagnosis_'+id+'" value="'+$('input[name="date_of_diagnosis"]').val()+'" /><input type="hidden" id="clinical-event-time-of-diagnosis_'+id+'" value="'+$('select[name="time_of_diagnosis"]').val()+'" /><input type="hidden" id="clinical-event-min-of-diagnosis_'+id+'" value="'+$('select[name="min_of_diagnosis"]').val()+'" /><input type="hidden" id="clinical-event-session-of-diagnosis_'+id+'" value="'+$('select[name="session_of_diagnosis"]').val()+'" /><input type="hidden" id="clinical-event-date-of-resolution_'+id+'" value="'+$('input[name="date_of_resolution"]').val()+'" /><input type="hidden" id="clinical-event-time-of-resolution_'+id+'" value="'+$('select[name="time_of_resolution"]').val()+'" /><input type="hidden" id="clinical-event-min-of-resolution_'+id+'" value="'+$('select[name="min_of_resolution"]').val()+'" /><input type="hidden" id="clinical-event-session-of-resolution_'+id+'" value="'+$('select[name="session_of_resolution"]').val()+'" /><input type="hidden" id="clinical-event-diagnosis-status_'+id+'" value="'+diagnosis_status+'" /><input type="hidden" id="clinical-event-comments_'+id+'" value="'+$('textarea[name="comments"]').val()+'" /><a href="javascript:void(0)" data-clinical_event_id="'+id+'" class="btn btn-primary btn-view clinical-event-edit-btn"><i class="fa fa-pencil-square-o"></i></a>&nbsp;<a href="javascript:void(0)" data-clinical_event_id="'+id+'" class="btn btn-danger btn-view clinical-event-remove-btn"><i class="fa fa-trash"></i></a></td></tr></table>';

                        $('#clinical-event_'+id).remove();
                        $('.clinical-event-list h6').remove();
                        var formatted_append_html = '<li id="clinical-event_'+id+'">'+append_html+'</li>';
                        if (diagnosis_status == 'active') {
                            $('.active-clinical-event-list .clinical-event-list').append(formatted_append_html);
                        }   
                        else
                        {
                            $('.passive-clinical-event-list .clinical-event-list').append(formatted_append_html);
                        }
                    },
                    complete:function(response) {
                        $('#save-clinical-event-btn').prop('disabled', false).html('<i class="fa fa-save"></i>&ensp;Save Event');
                        $('#clinical-event-modal').modal('hide');
                    },

                    error:function(response) {
                        if (typeof response.responseJSON.message != 'undefined') {
                            var message = response.responseJSON.message;
                            Showalert('error',message);
                        }
                    }

                });
            }
            else
            {
                Showalert('error','Please select diagnosis status...!');
            }

        }
        else
        {
            Showalert('error','Please select diagnosis...!');
        }
    });

    $(document).on('click', '.clinical-event-remove-btn', function()
    {
        if (confirm("Do you want to delete this clinical event?") == true) {
            var clinical_event_id = $(this).data('clinical_event_id');
            if (clinical_event_id != '' && clinical_event_id != null) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type:'POST',
                    url:'{{ url("remove-clinical-event") }}',
                    data: {id: clinical_event_id},
                    beforeSend:function() {

                    },
                    success:function(response) {
                        $('#clinical-event_'+clinical_event_id).remove();
                        Showalert('info', 'Event removed successfully');
                    },
                    complete:function(response) {

                    },

                    error:function(response) {
                        if (typeof response.responseJSON.message != 'undefined') {
                            var message = response.responseJSON.message;
                            Showalert('error',message);
                        }
                    }
                });
            }
        }
    });
    $(document).on('click', '.clinical-event-edit-btn', function()
    {
        $('#clinical-event-modal #form-type').text('Edit');
        $('#clinical-event-modal #form-btn-type').text('Update');
        var clinical_event_id = $(this).data('clinical_event_id');
        $('select[name="diagnosis"]').val($('#clinical-event-diagnosis_'+clinical_event_id).val()).trigger('change');
        $('input[name="other_diagnosis"]').val($('#clinical-event-other-diagnosis_'+clinical_event_id).val());
        $('input[name="date_of_diagnosis"]').val($('#clinical-event-date-of-diagnosis_'+clinical_event_id).val());
        $('select[name="time_of_diagnosis"]').val($('#clinical-event-time-of-diagnosis_'+clinical_event_id).val()).trigger('change');
        $('select[name="min_of_diagnosis"]').val($('#clinical-event-min-of-diagnosis_'+clinical_event_id).val()).trigger('change');
        $('select[name="session_of_diagnosis"]').val($('#clinical-event-session-of-diagnosis_'+clinical_event_id).val()).trigger('change');
        $('input[name="date_of_resolution"]').val($('#clinical-event-date-of-resolution_'+clinical_event_id).val());
        $('select[name="time_of_resolution"]').val($('#clinical-event-time-of-resolution_'+clinical_event_id).val()).trigger('change');
        $('select[name="min_of_resolution"]').val($('#clinical-event-min-of-resolution_'+clinical_event_id).val()).trigger('change');
        $('select[name="session_of_resolution"]').val($('#clinical-event-session-of-resolution_'+clinical_event_id).val()).trigger('change');
        $('textarea[name="comments"]').val($('#clinical-event-comments_'+clinical_event_id).val());
        $('input[name="diagnosis_status"][value="'+$('#clinical-event-diagnosis-status_'+clinical_event_id).val()+'"]').prop('checked', true);
        
        $('#clinical-event-form').append('<input type="hidden" name="id" value="'+clinical_event_id+'">');

        $('#clinical-event-modal').modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
    });
    $(document).on('click', '.add-care-event', function()
    {
        $('#clinical-event-modal #form-type').text('Add');
        $('#clinical-event-modal #form-btn-type').text('Save');
        $('#clinical-event-modal').modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
        $(this).prop('disabled', false);
        $('input[name="date_of_diagnosis"]').val(getFormattedDate());
        var d = new Date(),
        h = (d.getHours()<10?'0':'') + d.getHours(),
        m = (d.getMinutes()<10?'0':'') + d.getMinutes();
        session = 'AM';
        if (h > 12) {
            h = h - 12;
            session = 'PM';
        }
        $('select[name="time_of_diagnosis"]').val(h).trigger('change');
        $('select[name="min_of_diagnosis"]').val(m).trigger('change');
        $('select[name="session_of_diagnosis"]').val(session).trigger('change');
    });
    $('.event-datepicker').datepicker();
    $('#clinical-event-modal').on('hidden.bs.modal', function() {
        clearClinicalEventFormFields();
    });
    function clearClinicalEventFormFields()
    {
        $('input[name="other_diagnosis"], input[name="date_of_diagnosis"], select[name="time_of_diagnosis"], select[name="min_of_diagnosis"], select[name="session_of_diagnosis"], input[name="date_of_resolution"], select[name="time_of_resolution"], select[name="min_of_resolution"], select[name="session_of_resolution"], textarea[name="comments"]').val('');
        $('input[name="diagnosis_status"]').prop('checked', false);
        $('select[name="diagnosis"]').val('').trigger('change');
        $('#clinical-event-form input[name="id"]').remove();
    }

    function getFormattedDate()
    {
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();

        today = dd + '-' + mm + '-' + yyyy;
        return today;
    }
</script>
@endsection
