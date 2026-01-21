<style type="text/css">
    #assessment .row {
        display: flex;
        justify-content: center;
    }
    #assessment .table {
        width: fit-content;
    }
    #assessment .table>tbody>tr>td {
        border: 0px;
        vertical-align: middle;
    }
    #assessment .label-danger, #assessment .label-success {
        padding: 5px;
        color: white;
    }
    #assessment .m_chat_name {
        font-size: 14;
        font-weight: bold;
    }
    .import_data i:before {
        content: 'Import';
        color: black;
        background-color: #ff9600;
        border-radius: 5%;
        font-size: 10px;
        padding: 5px 3px 5px 3px;
        font-weight: bold;
        box-shadow: 0 0 3px black;
    }
</style>
<div class="row">
    <div class="col-md-6 col-sm-6">
        <div class="mt-10 widget box">
            <div class="widget-header">
                <h4><i class="fa fa-reorder"></i></h4>
                <button type="button" class="btn save-button-shadow btn-info neuro_update_btn pull-right" data-flag="5" style="margin-top: 1px;">
                    <i class="fa fa-print"></i> 
                    <span>Print - Assessments</span>
                </button>
            </div>
            <div class="widget-content">
                <table class="table" style="margin: auto;">
                    <tr id="hnne_tab">
                        <td>
                            <a href="#" data-href="#hnne_form" aria-controls="hnne_form" role="tab" data-toggle="tab" class="btn btn-primary full-tab-view input-width-small check_gestation">
                                <span>HNNE</span>
                            </a>
                        </td>
                        <td>
                            <div class="hide">
                                <i class="fa  fa-long-arrow-right" aria-hidden="true"></i>
                                <span class="total_score">0</span>
                            </div>
                        </td>
                    </tr>
                    <tr id="hine_tab">
                        <td>
                            <a href="#" data-href="#hine_form" aria-controls="hine_form" role="tab" data-toggle="tab" class="btn btn-primary full-tab-view input-width-small check_gestation">
                                <span>HINE</span>
                            </a>
                        </td>
                        <td>
                            <div class="hide">
                                <i class="fa  fa-long-arrow-right" aria-hidden="true"></i>
                                <span class="total_score">0</span>
                            </div>
                        </td>
                    </tr>
                    <tr id="m-chat_tab">
                        <td>
                            <a href="#m-chat_form" aria-controls="m-chat_form" role="tab" data-toggle="tab" class="btn btn-primary full-tab-view input-width-small not-active-btn">
                                <span>M-CHAT</span>
                            </a>
                        </td>
                        <td>
                            <table class="table">
                                <tr id="r_total_score" class="hide">
                                    <td>
                                        <span class="m_chat_name">R</span>
                                    </td>
                                    <td>
                                        <span><i class="fa fa-long-arrow-right" aria-hidden="true"></i></span>
                                    </td>
                                    <td>
                                        <span class="r_total_score">0</span>
                                    </td>
                                    <td>
                                        <span class="r_status p-5"></span>
                                    </td>
                                </tr>
                                <tr id="f_total_score" class="hide">
                                    <td>
                                        <span class="m_chat_name">Followup</span>
                                    </td>
                                    <td>
                                        <span><i class="fa fa-long-arrow-right" aria-hidden="true"></i></span>
                                    </td>
                                    <td>
                                        <span class="f_total_score">0</span>
                                    </td>
                                    <td>
                                        <span class="f_status p-5"></span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr id="dasii_tab">
                        <td>
                            <a href="#" data-href="#dasii_form" aria-controls="dasii_form" role="tab" data-toggle="tab" class="btn btn-primary full-tab-view input-width-small check_gestation">
                                <span>DASII</span>
                            </a>
                        </td>
                        <td>
                            <table class="table">
                                <tr id="mental-quotient" class="{{ @$results->mental_development_quotient != '' ? '' : 'hide' }}">
                                    <td>
                                        <span>Me.DQ</span>
                                    </td>
                                    <td>
                                        <span><i class="fa fa-long-arrow-right" aria-hidden="true"></i></span>
                                    </td>
                                    <td>
                                        <b><span class="quotient">{{@$results->mental_development_quotient}}</span></b>
                                    </td>
                                </tr>
                                <tr id="motor-quotient" class="{{ @$results->motor_development_quotient != '' ? '' : 'hide' }}">
                                    <td>
                                        <span>Mo.DQ</span>
                                    </td>
                                    <td>
                                        <span><i class="fa fa-long-arrow-right" aria-hidden="true"></i></span>
                                    </td>
                                    <td>
                                        <b><span class="quotient">{{@$results->motor_development_quotient}}</span></b>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr id="ddst_tab">
                        <td>
                            <a href="#" data-href="#ddst_form" aria-controls="ddst_form" role="tab" data-toggle="tab" class="btn btn-primary full-tab-view input-width-small check_gestation">
                                <span>DDST II</span>
                            </a>
                        </td>
                        <td>
                            <i class="fa fa-long-arrow-right {{(@$results->ddst_interpretation_status == null) ? 'hide' : ''}}" id="ddst-arrow" aria-hidden="true"></i>
                            <span class="status-btn label-success {{(@$results->ddst_interpretation_status != null && @$results->ddst_interpretation_status == 0) ? '' : 'hide'}} p-5">
                                <b>{!! $ddst_interpretation_result[0] !!}</b>
                            </span>
                            <span class="status-btn label-warning {{(@$results->ddst_interpretation_status != null && @$results->ddst_interpretation_status == 1) ? '' : 'hide'}} p-5">
                                <b>{!! $ddst_interpretation_result[1] !!}</b>
                            </span>
                            <span class="status-btn label-info {{(@$results->ddst_interpretation_status != null && @$results->ddst_interpretation_status == 2) ? '' : 'hide'}} p-5">
                                <b>{!! $ddst_interpretation_result[2] !!}</b>
                            </span>
                        </td>
                    </tr>
                    <tr id="cbcl_tab">
                        <td>
                            <a href="#" data-href="#cbcl_form" aria-controls="cbcl_form" role="tab" data-toggle="tab" class="btn btn-primary full-tab-view input-width-small check_gestation">
                                <span>CBCL</span>
                            </a>
                        </td>
                        <td>
                            <i class="fa fa-long-arrow-right {{(@$results->cbcl_interpretation_status != '' && @$results->cbcl_interpretation_status >= 0) ? '' : 'hide'}}" id="cbcl-arrow" aria-hidden="true"></i>
                            <span class="cbcl-status-btn label-success p-5 {{(@$results->cbcl_interpretation_status != '' && @$results->cbcl_interpretation_status == 0) ? '' : 'hide'}}"><b>Normal</b></span>
                            <span class="cbcl-status-btn label-info p-5 {{(@$results->cbcl_interpretation_status == 1) ? '' : 'hide'}}"><b>Borderline</b></span>
                            <span class="cbcl-status-btn label-warning p-5 {{(@$results->cbcl_interpretation_status == 2) ? '' : 'hide'}}"><b>Risk</b></span>
                        </td>
                    </tr>
                    <tr id="bayley_tab">
                        <td>
                            <a href="#" data-href="#bayley_form" aria-controls="bayley_form" role="tab" data-toggle="tab" class="btn btn-primary full-tab-view input-width-small check_gestation">
                                <span>Bayley</span>
                            </a>
                        </td>
                    </tr>
                    <tr id="issa_tab">
                        <td>
                            <a href="#" data-href="#issa_form" aria-controls="issa_form" role="tab" data-toggle="tab" class="btn btn-primary full-tab-view input-width-small check_gestation">
                                <span>ISSA</span>
                            </a>
                        </td>
                        <td>
                            <div class="hide">
                                <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                                <span class="total_score">0</span>
                            </div>
                        </td>
                    </tr>
                    <tr id="cars_tab">
                        <td>
                            <a href="#" data-href="#cars_form" aria-controls="cars_form" role="tab" data-toggle="tab" class="btn btn-primary full-tab-view input-width-small check_gestation">
                                <span>CARS</span>
                            </a>
                        </td>
                    </tr>

                    <tr id="infants_tab">
                        <td>
                            <a href="#" data-href="#infants_form" aria-controls="infants_form" role="tab" data-toggle="tab" class="btn btn-primary full-tab-view input-width-small check_gestation">
                                <span>Infants</span>
                            </a>
                        </td>
                        <td>
                            <div class="hide">
                                <i class="fa  fa-long-arrow-right" aria-hidden="true"></i>
                                <span class="total_score">0</span>
                            </div>
                        </td>
                    </tr>
                    <tr id="preschoolers_tab">
                        <td>
                            <a href="#" data-href="#preschoolers_form" aria-controls="preschoolers_form" role="tab" data-toggle="tab" class="btn btn-primary full-tab-view input-width-small check_gestation">
                                <span>Preschoolers</span>
                            </a>
                        </td>
                        <td>
                            <div class="hide">
                                <i class="fa  fa-long-arrow-right" aria-hidden="true"></i>
                                <span class="total_score">0</span>
                            </div>
                        </td>
                    </tr>
                </table>
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
                        {!! Form::label('baby_behavior','Baby behavior during testing:') !!}
                        <a href="javascript:void(0)" class="import_data">
                            <i class="fa fa-info-circle bs-tooltip"></i>
                        </a>
                    </div>
                    <div class="col-md-9 custom-input">
                        <div id="baby_behavior" class="tinymce-body">
                            {!! @$results->baby_behavior !!}
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('confidential_background_details','Confidential Background Details:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        <div id="confidential_background_details" class="tinymce-body">
                            {!! @$results->confidential_background_details !!}
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('recommendation','Recommendation:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        <div id="recommendation" class="tinymce-body">
                            {!! @$results->recommendation !!}
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('home_program','Home Program:') !!}
                        <a href="javascript:void(0)" class="import_data">
                            <i class="fa fa-info-circle bs-tooltip"></i>
                        </a>
                    </div>
                    <div class="col-md-9 custom-input">
                        <div id="home_program" class="tinymce-body">
                            {!! @$results->home_program !!}
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('referral_status','Referral:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        <input id="referral_status" data-size="small" name="referral_status" data-off="No" data-on="Yes" data-width="100" data-toggle="toggle" class="form-control switch-input" type="checkbox" @if(isset($results->referral_status) && $results->referral_status == 'Yes') checked="checked" @endif>
                    </div>
                </div>                
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('referral_to','Referred To:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('referral_to',null,['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('appointment_type','Current Appointment Type:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::select('appointment_type',[' '=>'N/A']+ValuelistHelpers::appointmentType(),null,['class'=>'select2-select-00 full-width']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                        {!! Form::label('Review','Review:') !!}
                    </div>
                    <div class="col-md-9 custom-input clear-xs">
                        <div class="col-xs-3 plr-0">
                            <small>(Date)</small>
                        </div>
                        <div class="col-xs-3">
                            <small>(Days)</small>
                        </div>
                        <div class="col-xs-6 plr-0">
                            <small>(Time)</small>
                        </div>
                        <div class="col-xs-3 plr-0">
                            {!! Form::text('review',null,['class'=>'form-control datepicker', 'readonly']) !!}
                        </div>
                        <div class="col-xs-3">
                            {!! Form::text('review_days',null,['class'=>'form-control']) !!}
                        </div>
                        <div class="col-xs-6 plr-0">
                            <div class="col-xs-4 plr-0">{!! Form::select('review_time',$time['time'],null,['class'=>'form-control']) !!}</div>
                            <div class="col-xs-4 pl-5 pr-0">{!! Form::select('review_min',$time['mins'],null,['class'=>'form-control']) !!}</div>
                            <div class="col-xs-4 pl-5 pr-0">{!! Form::select('review_session',$time['session'],null,['class'=>'form-control']) !!}</div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        <label for="fee_status">Fee charges:</label>
                    </div>
                    <div class="col-md-9 custom-input"> 
                        <input id="fee_status" data-size="small" name="fee_status" data-off="No" data-on="Yes" data-width="100" data-toggle="toggle" class="form-control switch-input" type="checkbox" @if(isset($results->fee_status) && $results->fee_status == 'Yes') checked="checked" @endif>
                    </div>
                </div>
                @php
                    $name_dvs = \ValuelistHelpers::mas_doctors_list(8);
                    $name_rks = \ValuelistHelpers::mas_doctors_list(7);
                    $name_neuro_consultant =  \ValuelistHelpers::mas_doctors_list(52);
                    $name_pvs =  \ValuelistHelpers::mas_doctors_list(80);
                @endphp
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('visit_from','Visit From:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::select('visit_from', [''=>'-- Select --', 'ip'=>'IP', $dvs=>$name_dvs, $rks=>$name_rks, $neuro_consultant_id=>$name_neuro_consultant, $pvs =>$name_pvs], null,['class'=>'form-control']) !!}
                    </div>
                </div>
                {!! Form::hidden('visit_number',null,['class'=>'form-control']) !!}
                
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('no_fee_reason','Reason:') !!}
                    </div>
                    <div class="col-md-9 custom-input"> 
                        {!! Form::text('no_fee_reason',null,['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('fee_amount','Fee Amount: (&#8377;)') !!}
                    </div>
                    <div class="col-md-9 custom-input"> 
                        {!! Form::text('fee_amount',null,['class'=>'form-control']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
