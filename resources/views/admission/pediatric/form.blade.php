<?php 
    $site_url = url('/').'/public';
    $write_permission = session('write_permission');
?>
<style type="text/css">
    .tabbable-custom>.tab-content {
        margin-bottom: 0px;
    }
    .custom-input > div.tinymce-body {
        border: 1px solid #CCCCCC !important;
        min-height: 100px;
        border-radius: 0px !important;
        padding: 5px;
        background-color: white;
    }
    .custom-input > div.tinymce-body:focus {
        border-color: #4d7496 !important;
    }
    @media (min-width: 768px) and (max-width: 979px) {
        .custom-input {
            clear: both; 
        }
    }
    .add_master_data {
        position: relative !important;
    }
    .gcs-value-selection.active {
        background-color: #d4f5ff !important;
    }
    .pediatric_pupils_table tr td{
        vertical-align: middle;
    }
    .pupils-input-box{
        border-bottom: 1px solid #000 !important;
        border: none;
        background-color: unset !important;
    }

</style>
<div role="tabpanel" class="tabbable tabbable-custom">
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#basicform" aria-controls="basicform" role="tab" data-toggle="tab">Basics</a>
        </li>
        <li role="presentation">
            <a href="#historyform" aria-controls="historyform" role="tab" data-toggle="tab">History</a>
        </li>
        <li role="presentation">
            <a href="#examinationform" aria-controls="examinationform" role="tab" data-toggle="tab">Examination</a>
        </li>
        <li role="presentation">
            <a href="#planform" aria-controls="planform" role="tab" data-toggle="tab">Admission Plan</a>
        </li>
        <li role="presentation">
            <a href="#working-diagnosis-form" aria-controls="working-diagnosis-form" role="tab" data-toggle="tab">Working Diagnosis</a>
        </li>
        <li role="presentation">
            <a href="#discussionform" aria-controls="discussionform" role="tab" data-toggle="tab">Discussion / Course In Hospital</a>
        </li>
        <li role="presentation">
            <a href="#treatmentform" aria-controls="treatmentform" role="tab" data-toggle="tab">Treatment Given</a>
        </li>
        <li role="presentation">
            <a href="#dischargeform" aria-controls="dischargeform" role="tab" data-toggle="tab">Discharge Plan</a>
        </li>
        @if(in_array('LABREQUEST',$write_permission) && isset($baby_detail->id))   
            <a href="{{ action('Nurse\NurseSheetController@overallLabValuePrint', $baby_detail->BMrNo).'?visitid='.SiteHelpers::encrypt_id($baby_detail->id).'&closewinlink=pediatric-edit' }}" class="btn btn-primary pull-right ptb-5">
                <i class="fa fa-print"></i>
                <span>Lab Report</span>
            </a> 
        @endif
        @if (isset($baby_detail->id))
        <li role="presentation">
            <a href="#media_tab" aria-controls="#media_tab" role="tab" data-toggle="tab">Attachments</a>
        </li>
        @endif
    </ul>
    {!! Form::hidden('visit_module_name', 'pediatric') !!}
    {!! Form::hidden('visit_type', 'IP') !!}

    <!-- Tab panes -->
    <div class="tab-content tab-view-shadow">
        <!-- Basics Form -->
        <div role="tabpanel" class="tab-pane active" id="basicform">
            <div class="col-md-12">
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('BMrNo','Baby\'s '. Lang::get('home.mrn'). '.:', ['class'=>'required-label']) !!}
                    </div>
                    <div class="col-md-7 custom-input">
                        <div class="col-md-7 col-sm-8">
                            {!! Form::text('BMrNo',@$baby_detail->BMrNo,['class'=>'form-control']) !!}
                            <span id="mrn_no_error" style="display: none; color: red"></span>
                        </div>
                        <div class="col-md-5 col-sm-4">
                            @if(isset($id) && $id == 0)
                            <a class="btn btn-primary btn-basic-shadow" id="search-baby-by-mr" disabled="true">
                                <i class="fa fa-search"></i> <span>Search</span>
                            </a>
                            @endif
                            @if(!isset($baby_detail->BMrNo) || (isset($baby_detail->BMrNo) && $baby_detail->BMrNo == ''))
                            <a class="btn btn-warning btn-basic-shadow" id="generate-mrn" data-mrn-field="BMrNo" data-form-id="pediatric-form" title="{{Lang::get('home.mrn_generate_btn_title')}}">
                                <img src="{{$site_url}}/img/saraswathi_logo.png"> <span>{{Lang::get('home.mrn_generate_btn')}}</span>
                            </a>
                            @endif
                            <br>
                            <label id="search_mrn_no_error" style="display: none; color: red"></label>                                        
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="widget box mt-10">
                    <div class="widget-header">
                        <h4><i class="fa fa-reorder"></i> </h4>
                    </div>
                    <div class="widget-content">
                        {!! Form::hidden('id') !!}
                        {!! Form::hidden('mother_id', @$baby_detail->MotherId) !!}
                        {!! Form::hidden('baby_id', @$baby_detail->BabyId) !!}
                        {!! Form::hidden('admission_id') !!}
                        {!! Form::hidden('parter_name') !!}
                        {!! Form::hidden('mobile') !!}
                        {!! Form::hidden('phone') !!}
                        {!! Form::hidden('address1') !!}
                        {!! Form::hidden('address2') !!}
                        {!! Form::hidden('address3') !!}
                        {!! Form::hidden('city') !!}
                        {!! Form::hidden('pincode') !!}
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('BabyName','Baby Name:', ['class'=>'required-label']) !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('BabyName',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('MotherName','Mother Name:', ['class'=>'required-label']) !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('MotherName',null,['class'=>'form-control pediatric-form-mother-field']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('DOB','DOB:', ['class'=>'required-label']) !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('DOB',null,['class'=>'form-control datepicker', 'readonly']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                {!! Form::label('Age In','Age:') !!}
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
                                        {!! Form::text('chronological_year',@$baby_details->age_year,['class'=>'form-control']) !!}
                                        <label for="chronological_year" generated="true" class="error help-block"></label>
                                    </div>
                                    <div class="col-xs-4">
                                        {!! Form::text('chronological_month',@$baby_details->age_month,['class'=>'form-control']) !!}
                                        <label for="chronological_month" generated="true" class="error help-block"></label>
                                    </div>
                                    <div class="col-xs-4">
                                        {!! Form::text('chronological_days',@$baby_details->age_days,['class'=>'form-control']) !!}
                                        <label for="chronological_days" generated="true" class="error help-block"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="form-group row">
                            <div class="col-md-3 text-right label-control mt-0">
                                {!! Form::label('BirthWeight','Birth Weight (In grams):') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('BirthWeight',null,['class'=>'form-control']) !!}
                            </div>
                        </div> -->
                        <!-- <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('BirthStatus','Birth Status:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                <input id="BirthStatus" data-size="small" name="BirthStatus" data-off="Outborn" data-on="Inborn" data-width="100" data-toggle="toggle" class="form-control switch-input" type="checkbox" @if(isset($baby_detail->BirthStatus) && $baby_detail->BirthStatus == 'Inborn') checked="checked" @endif>
                            </div>
                        </div> -->
                        <!-- <div class="form-group row">
                            <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                {!! Form::label('Gestation','Gestation:') !!}
                            </div>
                            <div class="col-md-9 custom-input clear-xs">
                                <div class="row col-md-12 display-flex">
                                    <div>
                                        <small>(In Weeks)</small>
                                        {!! Form::text('g_weeks',null,['class'=>'form-control gestation-wks','max'=>'46']) !!}
                                    </div>
                                    <div class="inbeween_two_fields">
                                        <span>+</span>
                                    </div>
                                    <div>
                                        <small>(In Days)</small>
                                        {!! Form::text('g_days',null,['class'=>'form-control gestation-days','max'=>'6']) !!}
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <!-- <div class="form-group row">
                            <div class="col-md-3 text-right label-control mt-0">
                                {!! Form::label('BabyBloodGroup','Baby\'s Blood Group:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('BabyBloodGroup',ValuelistHelpers::Blood_groups(),null,['class'=>'full-width']) !!}
                            </div>
                        </div>c4 -->
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('Sex','Sex:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('Sex',[''=>'N/A','Male'=>'Male','Female'=>'Female','Indeterminate'=>'Indeterminate'],null,['class'=>'full-width']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('referred_by','Referred From:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('referred_by',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('referral_reason','Referral Reason:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('referral_reason',null,['class'=>'form-control text-convertion-lower']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="widget box mt-10">
                    <div class="widget-header">
                        <h4><i class="fa fa-reorder"></i> </h4>
                    </div>
                    <div class="widget-content">
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control mt-0">
                                <label for="Address1">Address Line 1 :<br><small class="input-small">(Door /Flat No /Home Name)</small></label>
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('Address1',null,['class'=>'form-control','id'=>'Address1']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control mt-0">
                                <label for="Address2">Address Line 2 :<br><small class="input-small">(Street Name/Building Name)</small></label>
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('Address2',null,['class'=>'form-control','id'=>'Address2']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control mt-0">
                                <label for="Address3">Address Line 3 :<br><small class="input-small">(City)</small></label>
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('Address3',null,['class'=>'form-control','id'=>'Address3']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control mt-0">
                                <label for="Address4">Address Line 4 :<br><small class="input-small">(Pin code/Zip code)</small></label>
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('Address4',null,['class'=>'form-control','id'=>'Address4']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control mt-0">
                                <label for="Address5">Address Line 5 :<br><small class="input-small">(Country)</small></label>
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('Address5',null,['class'=>'form-control','id'=>'Address5']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="widget box mt-10">
                    <div class="widget-header">
                        <h4><i class="fa fa-reorder"></i> </h4>
                    </div>
                    <div class="widget-content">
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('admission_date','Admission Date:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('admission_date',null,['class'=>'form-control admission-date record-date','readonly']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                {!! Form::label('AdmissionTime','Admission Time:') !!}
                            </div>
                            <div class="col-md-9 custom-input clear-xs">
                                <div class="row">
                                    <div class="col-xs-4 text-center">
                                        <small>(Hour)</small>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <small>(Minute)</small>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <small>(Session)</small>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        {!! Form::select('admission_time',$admission['time'],null,['class'=>'input-width-small']) !!}
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        {!! Form::select('admission_time_mins',$admission['mins'],null,['class'=>'input-width-small']) !!}
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        {!! Form::select('admission_time_am',['AM'=>'AM','PM'=>'PM'],null,['class'=>'input-width-small']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                {!! Form::label('InitialAssessmentDoneTime','Initial Assessment Done on:') !!}
                            </div>
                            <div class="col-md-9 custom-input clear-xs">
                                <div class="row">
                                    <div class="col-xs-4 text-center">
                                        <small>(Hour)</small>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <small>(Minute)</small>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <small>(Session)</small>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        {!! Form::select('assessment_time',$assessment_time['time'],null,['class'=>'input-width-small']) !!}
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        {!! Form::select('assessment_time_mins',$assessment_time['mins'],null,['class'=>'input-width-small']) !!}
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        {!! Form::select('assessment_time_am',['AM'=>'AM','PM'=>'PM'],null,['class'=>'input-width-small']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('type_of_care','Type Of Care:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('type_of_care',['Intensive Care'=>'Intensive Care','Special Care'=>'Special Care','Ward Admission'=>'Ward Admission','High Dependancy Care'=>'High Dependancy Care'],null,['class'=>'full-width']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            {!! Form::hidden('visit_type', 'IP', ['id'=>'visit_type']) !!}
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('ip_number', Lang::get('home.ip').':') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                @if (@$baby_detail->ip_number == '')
                                {!! Form::text('ip_number',null,['class'=>'form-control ip_number'])  !!}
                                <a class="btn btn-warning btn-basic-shadow input-width-medium pull-right" id="generate-ip" data-ip-field="ip_number" data-form-id="pediatric-form" title="Generate {{ Lang::get('home.ip') }}">
                                    <img src="{{$site_url}}/img/saraswathi_logo.png"> <span>Generate {{ Lang::get('home.ip') }}</span>
                                </a>
                                @else
                                {!! Form::text('ip_number',null,['class'=>'form-control ip_number', 'readonly'])  !!}
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('surgeon','Surgeon:') !!}
                                <a href="javascript:void(0)" class="add_master_data" data-modal_header="Surgeon" data-destination_elements="Surgeon,SeenBy" data-option_value="id" data-option_text="Name" data-mas_table="mas_doctors">
                                    <i class="fa fa-info-circle bs-tooltip add-neo-consultant" data-placement="right" data-original-title="Add Surgeon"></i>
                                </a>
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('surgeon',['0'=>'N/A']+ValuelistHelpers::get_surgeons_lists(),null,['class'=>'full-width']) !!}
                            </div>
                        </div>
                        <div class="hidden">
                            {!! Form::select('pediatric_consultant_temp',ValuelistHelpers::mas_doctors_list(),null,['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('pediatric_consultant','Pediatric Consultant:') !!}
                                <a href="javascript:void(0)" class="add_master_data" data-modal_header="Neonatal Consultant" data-destination_elements="pediatric_consultant_temp,pediatric_consultant[],paediatric_surgeon" data-option_value="id" data-option_text="Name,Qualification" data-mas_table="mas_doctors">
                                    <i class="fa fa-info-circle bs-tooltip add-neo-consultant" data-placement="right" data-original-title="Add Neonatal Consultant"></i>
                                </a>
                            </div>
                            <div class="col-md-9 custom-input">
                                <table class="neonatal-consultant-div table table-add-more full-width-fix">
                                    <thead>                                    
                                        <tr class="master-add-header">
                                            <th class="full-width">
                                                <i class="fa fa-reorder"></i>Add More
                                            </th>
                                            <th>
                                                <span>
                                                    <a class="btn btn-success btn-view pediatric_consultant_add btn_add" href="javascript:void(0);">
                                                        <i class="fa fa-plus"></i>
                                                    </a>
                                                </span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($baby_detail->pediatric_consultant) && !empty($baby_detail->pediatric_consultant) && count($baby_detail->pediatric_consultant) > 0)
                                        @foreach($baby_detail->pediatric_consultant as $key => $consultant)
                                        <tr>
                                            <td class="full-width">
                                                {!! Form::select('pediatric_consultant['.$key.']',[''=>'N/A']+ValuelistHelpers::mas_doctors_list(),$consultant,['class'=>'form-control full-width']) !!}
                                            </td>     
                                            @if ($key > 0)                                             
                                            <td>
                                                <span class="fa fa-trash btn btn-danger btn-view remove-neon"></span>
                                            </td>
                                            @else
                                            <td></td>
                                            @endif
                                        </tr>
                                        @endforeach
                                        @else 
                                        @php
                                        $res_pediatric_consultant = 'a:3:{i:0;s:1:"8";i:1;s:2:"33";i:2;s:3:"133";}';
                                        $pediatric_consultant = unserialize($res_pediatric_consultant);
                                        @endphp
                                        @foreach($pediatric_consultant as $key => $consultant)
                                        <tr data-consultant-id={{$consultant}}>
                                            <td class="full-width">
                                                {!! Form::select('pediatric_consultant[]',[''=>'N/A']+ValuelistHelpers::mas_doctors_list(),$consultant,['class'=>'form-control full-width']) !!}
                                            </td>     
                                            @if ($key > 0)                                             
                                            <td>
                                                <span class="fa fa-trash btn btn-danger btn-view remove-neon"></span>
                                            </td>
                                            @else
                                            <td></td>
                                            @endif
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('seen_by','Seen By:') !!}
                                <a href="javascript:void(0)" class="add_master_data" data-modal_header="SeenBy" data-destination_elements="SeenBy" data-option_value="id" data-option_text="Name" data-mas_table="mas_doctors">
                                    <i class="fa fa-info-circle bs-tooltip add-neo-consultant" data-placement="right" data-original-title="Add SeenBy"></i>
                                </a>
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('seen_by',['0'=>'N/A']+ValuelistHelpers::mas_doctors_list(),null,['class'=>'full-width']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('hospital_name','Hospital Name', ['class'=>'required-label']) !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('hospital_name',ValuelistHelpers::getHospitals(),null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- History Form -->
        <div role="tabpanel" class="tab-pane" id="historyform">
            <div class="col-md-6 col-sm-12">
                <div class="widget box mt-10">
                    <div class="widget-header">
                        <h4><i class="fa fa-reorder"></i> </h4>
                    </div>
                    <div class="widget-content">
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('complaints','Complaints:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                <div id="complaints" class="tinymce-body">
                                    {!! @$baby_detail->complaints !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('hopi','HOPI:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                <div id="hopi" class="tinymce-body">
                                    {!! @$baby_detail->hopi !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('treatment_history','Treatment History:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                <div id="treatment_history" class="tinymce-body">
                                    {!! @$baby_detail->treatment_history !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('past_history','Past History:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                <div id="past_history" class="tinymce-body">
                                    {!! @$baby_detail->past_history !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="widget box mt-10">
                    <div class="widget-header">
                        <h4><i class="fa fa-reorder"></i> </h4>
                    </div>
                    <div class="widget-content">
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('perinatal_history','Perinatal History:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                <div id="perinatal_history" class="tinymce-body">
                                    {!! @$baby_detail->perinatal_history !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('immunization','Immunization:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                <div id="immunization" class="tinymce-body">
                                    {!! @$baby_detail->immunization !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('development','Development:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                <div id="development" class="tinymce-body">
                                    {!! @$baby_detail->development !!}
                                </div>
                            </div>
                        </div>
                           <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('nutrition_history','Nutrition History:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                <div id="nutrition_history" class="tinymce-body">
                                    {!! @$baby_detail->nutrition_history !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('family_history','Family History:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                <div id="family_history" class="tinymce-body">
                                    {!! @$baby_detail->family_history !!}
                                </div>
                            </div>
                        </div>
                         <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('allergy_contact_history','Allergy / Contact History:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                <div id="allergy_contact_history" class="tinymce-body">
                                    {!! @$baby_detail->allergy_contact_history !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div role="tabpanel" class="tab-pane" id="examinationform">
            <!-- Examination Form -->
            <div class="col-md-12 col-sm-12">
                <div class="widget box mt-10">
                    <div class="widget-header">
                        <h4><i class="fa fa-reorder"></i> General Examination</h4>
                    </div>
                    <div class="widget-content row">
                        <div class="col-md-12 col-sm-12">
                            <div class="widget box mt-10">
                                <div class="widget-header">
                                    <h4><i class="fa fa-reorder"></i> </h4>
                                </div>
                                <div class="widget-content row">
                                    <div class="col-md-6 col-sm-12 border-right">
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('stage', 'Status:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('stage',['0'=>'N/A','1' => "Alert","2"=>"Awake"],null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('gpallor', 'Pallor:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('gpallor',$yes_or_no,null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('ihm', 'Icterus:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('ihm',$yes_or_no,null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('cyanosis', 'Cyanosis:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('cyanosis',$yes_or_no,null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('clubby', 'Clubbing:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('clubby',$yes_or_no,null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('glymphadenopathy', 'Lymphadenopathy:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('glymphadenopathy',$yes_or_no,null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('pedal_edema', 'Pedal edema:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('pedal_edema',$yes_or_no,null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('general_examination','Additional Findings:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <div id="general_examination" class="tinymce-body">
                                                    {!! @$baby_detail->general_examination !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Vitals Form -->
                        <div class="col-md-12 col-sm-12">
                            <div class="widget box mt-10">
                                <div class="widget-header">
                                    <h4><i class="fa fa-reorder"></i> Vitals</h4>
                                </div>
                                <div class="widget-content row">
                                    <div class="col-md-6 col-sm-12 border-right">
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('hr','Heart Rate (BPM):') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::text('hr',null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('pulse_volume','Volume Pulse:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::text('pulse_volume',null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('bp','Blood Pressure (mmHg):') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::text('bp',null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('temperature_f','Temperature (F/C):') !!}
                                            </div>
                                            @php $order_changed = \SiteHelpers::temperatureOrder(); @endphp
                                            <div class="col-md-9 custom-input clear-xs">
                                                @if ($order_changed)
                                                <div class="row">
                                                    <div class="col-xs-6">
                                                        <small>(In Fahrenheit)</small>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <small>(In Celsius)</small>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        {!! Form::text('temperature_f', @$baby_detail->temperature_f,['class'=>'form-control fahrenheit']) !!}
                                                    </div>
                                                    <div class="col-xs-6">
                                                        {!! Form::text('',null,['class'=>'form-control celsius']) !!}
                                                    </div>
                                                </div>
                                                @else
                                                <div class="row">
                                                    <div class="col-xs-6">
                                                        <small>(In Celsius)</small>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <small>(In Fahrenheit)</small>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        {!! Form::text('temperature_f',@$baby_detail->temperature_f,['class'=>'form-control celsius']) !!}
                                                    </div>
                                                    <div class="col-xs-6">
                                                        {!! Form::text('', null,['class'=>'form-control fahrenheit']) !!}
                                                    </div>
                                                </div>
                                                @endif
                                                <label class="error help-block" for="BirthWeight" generated="true" style="display: none;"></label>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('spo2','SpO2 (%):') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::text('spo2',null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('cft','Capillary Refill Time:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('cft',[''=>'N/A','< 3 Seconds' => "< 3 Seconds",'3-5 Seconds' => "3-5 Seconds",'>5 Seconds' => ">5 Seconds","Prolonged"=>"Prolonged"],null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('vitals_content','Additional Findings:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <div id="vitals_content" class="tinymce-body">
                                                    {!! @$baby_detail->vitals_content !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Anthropometry Form -->
                        <div class="col-md-12 col-sm-12">
                            <div class="widget box mt-10">
                                <div class="widget-header">
                                    <h4><i class="fa fa-reorder"></i> Anthropometry</h4>
                                </div>
                                <div class="widget-content row">
                                    <div class="col-md-6 col-sm-12 border-right">
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                                {!! Form::label('current_weight','Weight:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input clear-xs">
                                                @php $weight_kg = (isset($baby_detail->current_weight) && !empty($baby_detail->current_weight) && is_numeric($baby_detail->current_weight) && $baby_detail->current_weight > 0)? $baby_detail->current_weight/1000 : 0 ; @endphp
                                                <div class="row">
                                                    <div class="col-xs-6">
                                                        <small>(In Kilograms)</small>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        <small>(In Grams)</small>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        {!! Form::input('text','current_weight_kg',$weight_kg,['class'=>'form-control ','id'=>'current_weight_kgs']) !!}
                                                    </div>
                                                    <div class="col-xs-6">
                                                        {!! Form::input('text','current_weight',null,['class'=>'form-control mobile-','id'=>'current_weight']) !!}
                                                        <label for="current_weight" generated="true" class="error help-block"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('current_height','Length/Height (cm):') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::text('current_height',null,['class'=>'form-control','id'=>'current_length']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('current_head_circumference','Head Circumference (cm):') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::text('current_head_circumference',null,['class'=>'form-control','id'=>'current_hc']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('current_bmi','Body Mass Index:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::text('current_bmi',null,['class'=>'form-control', 'id'=>'current_bmi']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('current_bsa','Body Surface Area:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::text('current_bsa',null,['class'=>'form-control', 'id'=>'current_bsa']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
   <div class="form-group row">
                                            <div class="col-md-12">
                                                <table class="table table-bordered pediatric_pupils_table">
                                                    <tr>
                                                        <td rowspan="4" vertical-align="middle">Pupils</td>
                                                    </tr>
                                                    <tr>
                                                        <input type="hidden" name="pupils_right">
                                                        <td><strong>Right</strong></td>
                                                        <td><strong>Left</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input type="hidden" id="pupils_right_screening" name="pupils_right_screening" value="0"/>

                                                            <button type="button" onclick="updateScreening('pupils_right_screening', 1)" data-value="1" data-button_val="1" class="btn btn-secondary right_buttons {{ isset($baby_detail->pupils_right_screening) && $baby_detail->pupils_right_screening == 1 ? 'active' : '' }}">Equal</button>
                                                            <button type="button" onclick="updateScreening('pupils_right_screening', 0)"  data-value="0" data-button_val="0" class="btn btn-secondary right_buttons {{ isset($baby_detail->pupils_right_screening) && $baby_detail->pupils_right_screening == 0 ? 'active' : '' }}">Unequal</button>
                                                        </td>
                                                        <td>
                                                            <input type="hidden" id="pupils_left_screening" name="pupils_left_screening" value="0"/>

                                                            <button type="button" data-value="1" onclick="updateScreening('pupils_left_screening', 1)" data-button_val="1" class="btn btn-secondary left_buttons {{ isset($baby_detail->pupils_left_screening) && $baby_detail->pupils_left_screening == 1 ? 'active' : '' }}">Equal</button>

                                                            <button type="button"  data-value="0" onclick="updateScreening('pupils_left_screening', 0)" data-button_val="0"  class="btn btn-secondary left_buttons {{ isset($baby_detail->pupils_left_screening) && $baby_detail->pupils_left_screening == 0 ? 'active' : '' }}">Unequal</button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" name="pupils_right_length" class="pupils-input-box"  value="{{ isset($baby_detail->pupils_right_length) ? $baby_detail->pupils_right_length : '' }}"/> MM</td>
                                                        <td><input type="text" name="pupils_left_length" class="pupils-input-box" value="{{ isset($baby_detail->pupils_left_length) ? $baby_detail->pupils_left_length : '' }}" /> MM</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('anthropometry_content','Additional Findings:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <div id="anthropometry_content" class="tinymce-body">
                                                    {!! @$baby_detail->anthropometry_content !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Systematic Examination -->
            <div class="col-md-12 col-sm-12">
                <div class="widget box mt-10">
                    <div class="widget-header">
                        <h4><i class="fa fa-reorder"></i> Systematic Examination</h4>
                    </div>
                    <div class="widget-content row">
                        <!-- CVS Form -->
                        <div class="col-md-12 col-sm-12">
                            <div class="widget box mt-10">
                                <div class="widget-header">
                                    <h4><i class="fa fa-reorder"></i> Cardio Vascular System</h4>
                                </div>
                                <div class="widget-content row">
                                    <div class="col-md-6 col-sm-12 border-right">
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('cvs','Cardio Vascular System:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('cvs',[''=>'N/A','Normal'=>'Normal','Abnormal'=>'Abnormal','Not Indicated'=>'Not Indicated'], null,['class'=>'form-control', 'multiple']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('precordial_activity','Precordial Activity:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('precordial_activity',[''=>'N/A','Normal'=>'Normal','Present'=>'Present','Absent'=>'Absent'], null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('HearingScreening',2), 'multiple']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('s1s2','S1S2:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('s1s2',[''=>'N/A','Normal'=>'Normal','Abnormal'=>'Abnormal'], null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('apical_impulse','Apical Impulse:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('apical_impulse',[''=>'N/A','Normal'=>'Normal','Right Side'=>'Right Side'], null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <!-- <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('bounding_pulses','Bounding Pulses:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('bounding_pulses',[''=>'N/A','Present'=>'Present','Absent'=>'Absent'], null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('HearingScreening',2)]) !!}
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="col-md-6 col-sm-12">   
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('murmur','Murmur:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <input id="murmur" data-size="small" name="murmur" data-off="No" data-on="Yes" data-width="100" data-toggle="toggle" class="form-control switch-input" type="checkbox" @if(isset($baby_detail->murmur) && $baby_detail->murmur == 'yes') checked="checked" @endif>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('character_of_murmur','Character of Murmur:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('character_of_murmur',[''=>'N/A','Short Systolic Murmur'=>'Short Systolic Murmur','Ejection Systolic Murmur'=>'Ejection Systolic Murmur','Pan Systolic Murmur'=>'Pan Systolic Murmur','Early Diastolic Murmur'=>'Early Diastolic Murmur','End Diastolic Murmur'=>'End Diastolic Murmur','Continuous Murmur'=>'Continuous Murmur'], null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <!-- <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('site_of_murmur','Site of Murmur:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('site_of_murmur',[''=>'N/A','Apical Area'=>'Apical Area','Aortic Area'=>'Aortic Area','Aortic Area'=>'Aortic Area','Pulmonary Area'=>'Pulmonary Area','Tricuspid Area'=>'Tricuspid Area','Rt Parasternal Area'=>'Rt Parasternal Area','Lt Parasternal Area'=>'Lt Parasternal Area'], null,['class'=>'form-control']) !!}
                                            </div>
                                        </div> -->
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('cvs_findings','Other CVS Additional Findings:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <div id="cvs_findings" class="tinymce-body">
                                                    {!! @$baby_detail->cvs_findings !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- RS Form -->
                        <div class="col-md-12 col-sm-12">
                            <div class="widget box mt-10">
                                <div class="widget-header">
                                    <h4><i class="fa fa-reorder"></i> Respiratory System</h4>
                                </div>
                                <div class="widget-content row">
                                    <div class="col-md-6 col-sm-12 border-right">
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('rs','RS:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('rs',[''=>'N/A','Normal'=>'Normal','Abnormal'=>'Abnormal','Not Indicated'=>'Not Indicated'], null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('chest_movement','Chest Movement:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('chest_movement',[''=>'N/A','Symmetrical'=>'Symmetrical','Asymmetrical'=>'Asymmetrical'], null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('air_entry','Air Entry:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('air_entry',[''=>'N/A','Equal'=>'Equal','Reduced Bilateral'=>'Reduced Bilateral','Reduced Rt'=>'Reduced Rt','Reduced Lt'=>'Reduced Lt'], null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('AirEntry')]) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('breath_sounds','Breath Sounds:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('breath_sounds',[''=>'N/A','Normal Vesicular'=>'Normal Vesicular','Abnormal'=>'Abnormal'], null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">                                    
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('added_sounds','Added Sounds:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('added_sounds',[''=>'N/A','Present'=>'Present','Absent'=>'Absent'], null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('HearingScreening',2)]) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('character_of_added_sounds','Character Of Added Sounds:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::text('character_of_added_sounds',null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('site_of_added_sounds','Site of Added Sounds:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::text('site_of_added_sounds',null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('rs_findings','Other RS Additional Findings:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <div id="rs_findings" class="tinymce-body">
                                                    {!! @$baby_detail->rs_findings !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- CNS Form -->
                        <div class="col-md-12 col-sm-12">
                            <div class="widget box mt-10">
                                <div class="widget-header">
                                    <h4><i class="fa fa-reorder"></i> Central Nervous System</h4>
                                </div>
                                <div class="widget-content row">
                                    <div class="col-md-6 col-sm-12 border-right">
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('cns_stage','Status:') !!}
                                            </div>
                                            @php $cns_stage = []; @endphp
                                            @if(isset($baby_detail->cns_stage) && !empty($baby_detail->cns_stage))
                                            @php $cns_stage = json_decode($baby_detail->cns_stage); @endphp
                                            @endif

                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('cns_stage[]',['Alert'=>'Alert','Awake'=>'Awake', 'Concious'=>'Concious','Oriented'=>'Oriented','Playful'=>'Playful'], $cns_stage,['class'=>'select2-select-00 full-width-fix', 'multiple']) !!}
                                            </div>
                                        </div>
                                        <h3 class="text-center"><u>Glasgow Coma Scale</u></h3>
                                        <span class="full-width display-inline-block text-center mb-15">Note: Minor (13-15); Moderate (9-12); Severe (3-8);</span>
                                        <div class="form-group">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <td rowspan="4" class="vertical-align-center">
                                                            {!! Form::label('eye_opening', 'Eye Opening Response') !!}
                                                            {!! Form::hidden('eye_opening') !!}
                                                        </td>
                                                        <td class="eye_opening gcs-value-selection text-left @if(@$baby_detail->eye_opening == 4) active @endif" id="eye_opening_4" data-value="4">4 - Eyes open spontaneously</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="eye_opening gcs-value-selection text-left @if(@$baby_detail->eye_opening == 3) active @endif" id="eye_opening_3" data-value="3">3 - Eyes open to verbal command, speech or shout</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="eye_opening gcs-value-selection text-left @if(@$baby_detail->eye_opening == 2) active @endif" id="eye_opening_2" data-value="2">2 - Eyes open to pain (not applied to face)</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="eye_opening gcs-value-selection text-left @if(@$baby_detail->eye_opening == 1) active @endif" id="eye_opening_1" data-value="1">1 - No eye opening</td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="5" class="vertical-align-center">
                                                            {!! Form::label('verbal', 'Verbal Response') !!}
                                                            {!! Form::hidden('verbal') !!}
                                                        </td>
                                                        <td class="verbal gcs-value-selection text-left @if(@$baby_detail->verbal == 5) active @endif" id="verbal_5" data-value="5">5 - Oriented</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="verbal gcs-value-selection text-left @if(@$baby_detail->verbal == 4) active @endif" id="verbal_4" data-value="4">4 - Confused conversation, but able to answer questions</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="verbal gcs-value-selection text-left @if(@$baby_detail->verbal == 3) active @endif" id="verbal_3" data-value="3">3 - Inappropriate responses, words discernible</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="verbal gcs-value-selection text-left @if(@$baby_detail->verbal == 2) active @endif" id="verbal_2" data-value="2">2 - Incomprehensible sounds or speech</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="verbal gcs-value-selection text-left @if(@$baby_detail->verbal == 1) active @endif" id="verbal_1" data-value="1">1 - No verbal response</td>                                                        
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="6" class="vertical-align-center">
                                                            {!! Form::label('motor', 'Motor Response') !!}
                                                            {!! Form::hidden('motor') !!}
                                                        </td>
                                                        <td class="motor gcs-value-selection text-left @if(@$baby_detail->motor == 6) active @endif" id="motor_6" data-value="6">6 - Obeys commands for movement</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="motor gcs-value-selection text-left @if(@$baby_detail->motor == 5) active @endif" id="motor_5" data-value="5">5 - Purposeful movement to painful stimulus</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="motor gcs-value-selection text-left @if(@$baby_detail->motor == 4) active @endif" id="motor_4" data-value="4">4 - Withdraws from pain</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="motor gcs-value-selection text-left @if(@$baby_detail->motor == 3) active @endif" id="motor_3" data-value="3">3 - Abnormal (spastic) flexion, decorticate posture</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="motor gcs-value-selection text-left @if(@$baby_detail->motor == 2) active @endif" id="motor_2" data-value="2">2 - Extensor (rigid) response, decerebrate posture</td>                                                        
                                                    </tr>
                                                    <tr>
                                                        <td class="motor gcs-value-selection text-left @if(@$baby_detail->motor == 1) active @endif" id="motor_1" data-value="1">1 - No motor response</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h4>Total:</h4>
                                                        </td>
                                                        <td>
                                                            <h4 class="display-inline-block"><span id="gcs-total">-</span></h4>
                                                            <span class="btn btn-xs ml-5 mt-10 mb-15 pull-right" id="gcs-options-reset">Reset</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('cn_meningeal_signs','Meningeal signs:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('cn_meningeal_signs',['0'=>'N/A','1'=>'Yes','2'=>'No'], null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('cn_exam','Cranial nerve examination:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('cn_exam',['0'=>'N/A','1'=>'Normal','2'=>'Abnormal'], null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('ms_exam','Motor system examination:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('ms_exam',['0'=>'N/A','1'=>'Normal','2'=>'Abnormal'], null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('ms_findings','Motor System Findings:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <div id="ms_findings" class="tinymce-body">
                                                    {!! @$baby_detail->ms_findings !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('deep_tendon','Deep tendon reflex (DTR):') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('deep_tendon',['0'=>'N/A','1'=>'Normal','2'=>'Abnormal'], null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('deep_tendon_findings','DTR Additional Findings:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <div id="deep_tendon_findings" class="tinymce-body">
                                                    {!! @$baby_detail->deep_tendon_findings !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('cns_findings','Other CNS Additional Findings:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <div id="cns_findings" class="tinymce-body">
                                                    {!! @$baby_detail->cns_findings !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- GPE Form -->
                        <!-- <div class="col-md-12 col-sm-12">
                            <div class="widget box mt-10">
                                <div class="widget-header">
                                    <h4><i class="fa fa-reorder"></i> GPE</h4>
                                </div>
                                <div class="widget-content row">
                                    <div class="col-md-6 col-sm-12 border-right">
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('pallor','Pallor:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('pallor',[''=>'N/A','Present'=>'Present','Absent'=>'Absent'], null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('HearingScreening',2)]) !!} 
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('scalp','Scalp:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('scalp',[''=>'N/A','Normal'=>'Normal',"Caput Succedaneum"=>"Caput Succedaneum","Cephalhematoma"=>"Cephalhematoma","Bruises"=>"Bruises","Laceration"=>"Laceration"], null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('eyes','Eyes:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('eyes',[''=>'N/A','Normal with Red reflex'=>'Normal with Red reflex','Subconjunctival Hemorrhage'=>'Subconjunctival Hemorrhage','Cataract'=>'Cataract','Microophthalmos'=>'Microophthalmos'], null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('ears','Ears:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('ears',[''=>'N/A','Normal'=>'Normal','Low Set'=>'Low Set','Preauricular tag Rt'=>'Preauricular tag Rt','Preauricular tag Lt'=>'Preauricular tag Lt','Preauricular tag Bilateral'=>'Preauricular tag Bilateral'], null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('nose','Nose:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('nose',[''=>'N/A','Normal'=>'Normal','Depressed nasal bridge'=>'Depressed nasal bridge'], null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('nostrils','Nostrils:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('nostrils',[''=>'N/A','Patent'=>'Patent','Choanal Atresia Rt'=>'Choanal Atresia Rt','Choanal Atresia Rt'=>'Choanal Atresia Rt','Choanal Atresia Lt'=>'Choanal Atresia Lt','Choanal Atresia Bilateral'=>'Choanal Atresia Bilateral'], null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('lips','Lips:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('lips',[''=>'N/A','Normal'=>'Normal','Cleft Lip'=>'Cleft Lip'], null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('palate','Palate:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('palate',[''=>'N/A','Normal'=>'Normal','Cleft Palate'=>'Cleft Palate'], null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('neck','Neck:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('neck',[''=>'N/A','Normal'=>'Normal','Cystic Hygroma'=>'Cystic Hygroma','Sternomastoid tumor'=>'Sternomastoid tumor'], null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('nipples','Nipples:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('nipples',[''=>'N/A','Normal'=>'Normal','Supernumerary'=>'Supernumerary'], null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('lymphadenopathy','Lymphadenopathy:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('lymphadenopathy',[''=>'N/A','Localized'=>'Localized','Absent'=>'Absent','Generalized'=>'Generalized'], null,['class'=>'form-control']) !!} 
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('umbilicus','Umbilicus:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('umbilicus',[''=>'N/A','Normal'=>'Normal','Omphalocele'=>'Omphalocele','Gastroschisis'=>'Gastroschisis','Hernia'=>'Hernia'], null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('edema','Edema:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('edema',[''=>'N/A','Present'=>'Present','Absent'=>'Absent'], null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('anterior_fontanelle','Anterior Fontanelle:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('anterior_fontanelle',[''=>'N/A','Normal'=>'Normal','Depressed'=>'Depressed','Bulging'=>'Bulging'], null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('AnteriorFontanelle')]) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('jaundice','Jaundice:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('jaundice',[''=>'N/A','Present'=>'Present','Absent'=>'Absent'], null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('HearingScreening',2)]) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12"> 
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('hernial_orifices','Hernial Orifices:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('hernial_orifices',[''=>'N/A','No hernia'=>'No hernia','Right Inguinal hernia'=>'Right Inguinal hernia','Left Inguinal hernia'=>'Left Inguinal hernia','Umbilical/para umbilical hernia'=>'Umbilical/para umbilical hernia','Obstructed/strangulated'=>'Obstructed / strangulated'], null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('femoral_pulses','Femoral Pulses:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('femoral_pulses',[''=>'N/A','Well Palpable'=>'Well Palpable','Bounding'=>'Bounding','feeble'=>'feeble'], null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default_medium', 6)]) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('genitalia','Genitalia:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('genitalia',[''=>'N/A','Normal'=>'Normal','Clitoromegaly'=>'Clitoromegaly','Hypospadias'=>'Hypospadias','Cryptorchidism'=>'Cryptorchidism','Chordee'=>'Chordee','Ambiguous'=>'Ambiguous'], null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('gentila',2)]) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('hips','Hips:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('hips',[''=>'N/A','Normal'=>'Normal','DDH Rt'=>'DDH Rt','DDH Lt'=>'DDH Lt','DDH Bilateral'=>'DDH Bilateral'], null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('normal',3)]) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('anus','Anus:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('anus',[''=>'N/A','Patent'=>'Patent','Imperforate'=>'Imperforate'], null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('spine','Spine:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('spine',[''=>'N/A','Normal'=>'Normal','Kyphoscoliosis'=>'Kyphoscoliosis','Sacral dimple'=>'Sacral dimple'], null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('rt_ul','Rt UL:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('rt_ul',[''=>'N/A','Normal'=>'Normal','Polydactyly'=>'Polydactyly','Syndactyly'=>'Syndactyly','Clinodactyly'=>'Clinodactyly','Single Crease'=>'Single Crease'], null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('rt_ll','Rt LL:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('rt_ll',[''=>'N/A','Normal'=>'Normal','Polydactyly'=>'Polydactyly','Syndactyly'=>'Syndactyly','Positional tallipes'=>'Positional tallipes','Fixed tallipes'=>'Fixed tallipes'], null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('lt_ul','Lt UL:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('lt_ul',[''=>'N/A','Normal'=>'Normal','Polydactyly'=>'Polydactyly','Syndactyly'=>'Syndactyly','Clinodactyly'=>'Clinodactyly','Single Crease'=>'Single Crease'], null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('lt_ll','Lt LL:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('lt_ll',[''=>'N/A','Normal'=>'Normal','Polydactyly'=>'Polydactyly','Syndactyly'=>'Syndactyly','Positional tallipes'=>'Positional tallipes','Fixed tallipes'=>'Fixed tallipes'], null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('skin','Skin:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('skin',[''=>'N/A','Normal'=>'Normal','Blueberry muffin spots'=>'Blueberry muffin spots','Mongolian spots'=>'Mongolian spots','Erythema toxicum'=>'Erythema toxicum','Milia'=>'Milia','Miliaria'=>'Miliaria'], null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('hairs','Hairs:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('hairs',[''=>'N/A','Normal'=>'Normal','Alopecia'=>'Alopecia'], null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('any_other_abnormality','Any Other Abnormality:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <div id="any_other_abnormality" class="tinymce-body">
                                                    {!! @$baby_detail->any_other_abnormality !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <!-- Abdomen Form -->
                        <div class="col-md-12 col-sm-12">
                            <div class="widget box mt-10">
                                <div class="widget-header">
                                    <h4><i class="fa fa-reorder"></i> Abdomen</h4>
                                </div>
                                <div class="widget-content row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('abdomen_status','Status:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('abdomen_status', ['N/A', 'Distended', 'Not Distended'], null, ['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('skin_over_abdomen','Skin Over Abdomen:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('skin_over_abdomen', ['N/A', 'Normal', 'Visible Gastric Pinstalims', 'Umbilicus - Normal'], null, ['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('palpation','Palpation:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::radio('palpation_soft') !!}
                                                {!! Form::label('palpation_soft', 'Soft') !!} /
                                                {!! Form::radio('palpation_rigidity') !!}
                                                {!! Form::label('palpation_rigidity', 'Rigidity') !!}
                                                {!! Form::radio('palpation_guarding') !!}
                                                {!! Form::label('palpation_guarding', 'Guarding') !!}
                                                <br>
                                                {!! Form::radio('palpation_tender') !!}
                                                {!! Form::label('palpation_tender', 'Tender') !!} /
                                                {!! Form::radio('palpation_non_tender') !!}
                                                {!! Form::label('palpation_non_tender', 'Non Tender') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12 border-left">
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('liver','Liver:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <div>
                                                    {!! Form::select('liver', ['N/A', 'Palpable', 'Non-Palpable'], null, ['class'=>'form-control']) !!}
                                                </div>
                                                <div class="mt-15 @if(isset($baby_detail->liver) && $baby_detail->liver != 1) hide @endif" id="liver-palpation-value">
                                                    {!! Form::text('liver_palpation_value', null, ['class'=>'form-control input-width-small display-inline-block', 'onkeypress'=>'return isNumber(event, this);']) !!} <span class="display-inline-block mtb-6">cm below <i class="fa fa-right" aria-hidden="true"></i> sub costal margin</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('spleen','Spleen:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <div>
                                                    {!! Form::select('spleen', ['N/A', 'Palpable', 'Non-Palpable'], null, ['class'=>'form-control']) !!}
                                                </div>
                                                <div class="mt-15 @if(isset($baby_detail->spleen) && $baby_detail->spleen != 1) hide @endif" id="spleen-palpation-value">
                                                    {!! Form::text('spleen_palpation_value', null, ['class'=>'form-control input-width-small display-inline-block', 'onkeypress'=>'return isNumber(event, this);']) !!} <span class="display-inline-block mtb-6">cm below <i class="fa fa-left" aria-hidden="true"></i> sub costal margin</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('external_genitalia','External Genitalia:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('external_genitalia', ['N/A', 'Normal'], null, ['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 mt-15">
                                        <div class="form-group row">
                                            <div class="col-md-12 label-control">
                                                {!! Form::label('abdomen_findings','Additional Findings:') !!}
                                            </div>
                                            <div class="col-md-12 custom-input">
                                                <div id="abdomen_findings" class="tinymce-body">
                                                    {!! @$baby_detail->abdomen_findings !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>      

        <!-- Admission Plan Form -->
        <div role="tabpanel" class="tab-pane" id="planform">
            <div class="col-md-6 col-sm-12">
                <div class="widget box mt-10">
                    <div class="widget-header">
                        <h4><i class="fa fa-reorder"></i> </h4>
                    </div>
                    <div class="widget-content">
                     <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('biohazard','Biohazard:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                <input id="biohazard" data-size="small" name="biohazard" data-off="No" data-on="Yes" data-width="100" data-toggle="toggle" class="form-control switch-input" type="checkbox" @if(isset($baby_detail->biohazard) && $baby_detail->biohazard) checked="checked" @endif>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('investigations_test','Test:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::hidden('investigation_order', null) !!}
                                {!! Form::textarea('investigations_test', null,['class'=>'form-control', 'rows'=>3]) !!}                                        
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('admission_entered_by','Admission written by:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('admission_entered_by',['0'=>'N/A']+ValuelistHelpers::mas_doctors_list(),null,['class'=>'full-width']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="widget box mt-10">
                    <div class="widget-header">
                        <h4><i class="fa fa-reorder"></i> </h4>
                    </div>
                    <div class="widget-content">
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('treatment','Treatment:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                <div id="treatment" class="tinymce-body">
                                    {!! @$baby_detail->treatment !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Working Diagnosis Form -->
        <div role="tabpanel" class="tab-pane" id="working-diagnosis-form">
            <div class="widget box mt-10">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> </h4>
                </div>
                <div class="widget-content">
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('working_diagnosis','Working Diagnosis:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            <div id="working_diagnosis" class="tinymce-body">
                                {!! @$baby_detail->working_diagnosis !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Discussion / Course In Hospital Form -->
        <div role="tabpanel" class="tab-pane" id="discussionform">
            <div class="widget box mt-10">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> </h4>
                </div>
                <div class="widget-content">
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('discussion_findings','Course in Hospital:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            <div id="discussion_findings" class="tinymce-body">
                                {!! @$baby_detail->discussion_findings !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Treatment Given Form -->
        <div role="tabpanel" class="tab-pane" id="treatmentform">
            <div class="widget box mt-10">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> </h4>
                </div>
                <div class="widget-content">
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('treatment_specialist','Specialist Opinion Given:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            <input id="treatment_specialist" data-size="small" name="treatment_specialist" data-off="No" data-on="Yes" data-width="100" data-toggle="toggle" class="form-control switch-input" type="checkbox" @if(isset($baby_detail->treatment_specialist) && $baby_detail->treatment_specialist) checked="checked" @endif>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('specialist','Specialist:') !!}
                            <a href="javascript:void(0)" class="add_master_data" data-modal_header="specialist" data-destination_elements="specialist" data-option_value="id" data-option_text="Name" data-mas_table="mas_doctors">
                                <i class="fa fa-info-circle bs-tooltip add-neo-consultant" data-placement="right" data-original-title="Add Specialist"></i>
                            </a>
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('specialist',['0'=>'N/A']+ValuelistHelpers::mas_doctors_list(),null,['class'=>'full-width', 'id' => 'specialist-doctor']) !!}
                        </div>
                    </div>
                    <div  id="opinion-section"  class="form-group row"  style="display: none;">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('treatment_findings','Opinion:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            <div id="treatment_findings" class="tinymce-body">
                                {!! @$baby_detail->treatment_findings !!}
                            </div>
                        </div>
                    </div>

                     <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('surgery','Surgery:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                <input id="surgery" data-size="small" name="surgery" data-off="No" data-on="Yes" data-width="100" data-toggle="toggle" class="form-control switch-input" type="checkbox" @if(isset($baby_detail->surgery) && $baby_detail->surgery) checked="checked" @endif>
                            </div>
                        </div>
                        <div class="form-group row">
                            
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('surgery_date','Date:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('surgery_date',null,['class'=>'form-control surgery-date','readonly']) !!}
                            </div>
                        </div>
                        <div class="hidden">
                            {!! Form::select('surgeon_temp',ValuelistHelpers::get_surgeons_lists(),null,['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('surgeon','Surgeon:') !!}
                                <a href="javascript:void(0)" class="add_master_data" data-modal_header="Surgeon" data-destination_elements="surgeon,seen_by" data-option_value="id" data-option_text="Name" data-mas_table="mas_doctors">
                                    <i class="fa fa-info-circle bs-tooltip add-neo-consultant" data-placement="right" data-original-title="Add Surgeon"></i>
                                </a>
                            </div>
                            <div class="col-md-9 custom-input">
                                <table class="neonatal-surgeon-div table table-add-more full-width-fix" id="surgeon">
                                    <thead>                                    
                                        <tr class="master-add-header">
                                            <th class="full-width">
                                                <i class="fa fa-reorder"></i>Add More
                                            </th>
                                            <th>
                                                <span>
                                                    <a class="btn btn-success btn-view surgeon_add btn_add" href="javascript:void(0);">
                                                        <i class="fa fa-plus"></i>
                                                    </a>
                                                </span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($baby_detail->surgeon) && !empty($baby_detail->surgeon) && count(json_decode($baby_detail->surgeon)) > 0 && is_array($baby_detail->surgeon))
                                        @php $surgeon_list = json_decode($baby_detail->surgeon); @endphp
                                        @foreach($surgeon_list as $key => $surgeon)
                                        <tr>
                                            <td class="full-width">
                                                {!! Form::select('surgeon['.$key.']',['0'=>'N/A']+ValuelistHelpers::get_surgeons_lists(),$surgeon,['class'=>'form-control full-width']) !!}
                                            </td>     
                                            @if ($key > 0)                                             
                                            <td>
                                                <span class="fa fa-trash btn btn-danger btn-view remove-neon"></span>
                                            </td>
                                            @else
                                            <td> </td>
                                             
                                           @endif
                                        </tr>
                                      
                                       @endforeach
                                        
                                        @else 
                                        <tr data-surgeon-id=0>
                                            <td class="full-width">
                                                {!! Form::select('surgeon[]',['0'=>'N/A']+ValuelistHelpers::get_surgeons_lists(),null,['class'=>'form-control full-width']) !!}
                                            </td>   
                                            <td></td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('anaesthetist','Anaesthetist:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('anaesthetist',['0'=>'N/A']+ValuelistHelpers::mas_doctors_list(),null,['class'=>'full-width']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('surgery_notes','Surgery Notes:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                <div id="surgery_notes" class="tinymce-body">
                                    {!! @$baby_detail->surgery_notes !!}
                                </div>
                            </div>
                        </div>

                     <div class="row mx-0">
                        <div class="col-md-12 col-sm-12 overflow-auto">
                            <h3> Treament Medications
                                <a href="javascript:void(0)" class="add_master_data" data-modal_header="Drugs & Iv Fluids" data-destination_elements="temp_drugs,T_Drugs[]" data-option_value="id" data-option_text="brand_name" data-mas_table="mas_drugivfluid" data-drug_type="oral">
                                    <i class="fa fa-info-circle bs-tooltip" data-placement="right" data-original-title="Add Drugs & Iv Fluids"></i>
                                </a>
                            </h3>
                            <table class="medi_drugs table table-add-more full-width-fix">
                                <thead>
                                    <tr class="master-add-header">
                                        <th>Drug</th>
                                        <th>Generic Name</th>
                                        <th>Formulation/Strength</th>
                                        <th>Dose</th>
                                        <th>Frequency</th>
                                        <th>Duration</th>
                                        <th>Additional Instruction</th>
                                        <th>
                                            <span>
                                                <a class="btn btn-success btn-view medi_drugs_add pull-right" href="javascript:void(0);">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                            </span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $mas_frequency_list = ValuelistHelpers::drugFrequencyList(); @endphp
                                    <div class="hidden">
                                        {!! Form::select('temp_drugs',$drug_master,'') !!}
                                        {!! Form::select('temp_frequency',$mas_frequency_list,null) !!}
                                        <!-- {!! Form::select('temp_does',[''=>'N/A']+ValuelistHelpers::dose(),'') !!} -->
                                        {!! Form::select('temp_duration',[''=>'N/A']+ValuelistHelpers::medicationDuration(),'') !!} 
                                    </div>
                                    @if (isset($treatment_medications) && (count($treatment_medications) > 0))
                                    @php $l = 0; @endphp
                                    @foreach ($treatment_medications as $key => $medi_data)
                                    <tr>
                                        <td>{!! Form::select('T_Drugs['.$key.']',$drug_master,$medi_data['Medication'],['class'=>'t-drugs-changes t-drug-list-name'.$l,'data-id'=>$l, 'type'=>'treatment_medications', 'style'=>'width: 300px;']) !!}</td>
                                        <span id="type" data-value="treament_medication"></span>

                                        <td>{!! Form::text('t_generic_name['.$key.']',@$medi_data['genericname'],['class'=>'form-control t_generic_name'.$l]) !!}</td>
                                        <td>{!! Form::text('t_formulation['.$key.']',$medi_data['Formulation'],['class'=>'form-control t_formulation'.$l]) !!}</td>
                                        <td class="input-width-medium">{!! Form::text('T_Dose['.$key.']',@$medi_data['Dose'],['class'=>'form-control']) !!}</td>
                                        <td class="input-width-medium">{!! Form::select('T_Frequency['.$key.']',$mas_frequency_list,$medi_data['Frequency'],['class'=>'form-control']) !!}</td>
                                        <td class="input-width-medium">
                                            {!! Form::select('T_Duration['.$key.']',[''=>'N/A']+ValuelistHelpers::medicationDuration(),$medi_data['Duration'],['class'=>'form-control']) !!}
                                        </td>
                                        <td>
                                            {!! Form::textarea('T_additional_instruction['.$key.']', $medi_data['additional_instruction'],['class'=>'form-control textarea-need', 'rows'=>1]) !!}</td>                                        
                                        <td>
                                            <span class="fa fa-trash btn btn-danger btn-view remove"></span>
                                        </td>
                                    </tr>
                                    @php $l++; @endphp
                                    @endforeach
                                    @else
                                    <tr>
                                        <td>
                                            {!! Form::select('T_Drugs[]',$drug_master,'',['class'=>'t-drugs-changes t-drug-list-name0','data-id'=>'0', 'style'=>'width: 300px;']) !!}
                                        </td>
                                        <td>
                                            {!! Form::text('t_generic_name[]',null,['class'=>'form-control t_generic_name0']) !!}
                                        </td>
                                        <td class="input-width-medium">
                                            {!! Form::text('t_formulation[]',null,['class'=>'form-control t_formulation0']) !!}
                                        </td>
                                        <td class="input-width-medium">
                                            {!! Form::text('T_Dose[]',null,['class'=>'form-control']) !!}
                                        </td>
                                        <td class="input-width-medium">
                                            {!! Form::select('T_Frequency[]',$mas_frequency_list,null,['class'=>'form-control'])!!}
                                        </td>
                                        <td>{!! Form::select('T_Duration[]',[''=>'N/A']+ValuelistHelpers::medicationDuration(),null,['class'=>'form-control']) !!}</td>
                                        <td>{!! Form::textarea('T_additional_instruction[]', null,['class'=>'form-control textarea-need', 'rows'=>1]) !!}</td>
                                        <td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Discharge Plan Form -->
        <div role="tabpanel" class="tab-pane" id="dischargeform">
            <div class="widget box mt-10">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> </h4>
                </div>
                <div class="widget-content">
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('status','Status:') !!}
                        </div>
                        <div class="col-md-3 custom-input">
                            {!! Form::select('status',ValuelistHelpers::Discharge_Status(),null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('status_date','Date:') !!}
                        </div>
                        <div class="col-md-3 custom-input">
                            {!! Form::text('status_date',null,['class'=>'form-control datepicker', 'readonly']) !!}                                            
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('status_time','Time:') !!}
                        </div>
                        <div class="col-md-3 custom-input">
                            {!! Form::text('status_time',null,['class'=>'form-control']) !!}                                            
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('status_weight','Discharge Weight (In Kgs):') !!}
                        </div>
                        <div class="col-md-3 custom-input">
                            {!! Form::text('status_weight',null,['class'=>'form-control']) !!}                                            
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('condition_at_discharge','Condition at discharge:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            <div id="condition_at_discharge" class="tinymce-body">
                                @if(!empty($baby_detail->condition_at_discharge))
                                 {!! @$baby_detail->condition_at_discharge !!}
                                @else
                                {!! @$headerContent->condition_at_discharge !!}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('verified_by','Verified ?') !!}
                        </div>
                        <div class="col-md-9">
                            {!! Form::checkbox('verified_by',null,null) !!}
                        </div>
                    </div>


                    
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('review_details','Review Details:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            <div id="review_details" class="tinymce-body">
                            @if(!empty($baby_detail->review_details))
                               {!! @$baby_detail->review_details !!}

                            {{-- 
                            {!! Form::text('review_details',null,['class'=>'form-control']) !!}                                            
                            --}}
                            @else
                                {!! @$headerContent->review_details !!}
                            @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('discharge_findings','Additional Information:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            <div id="discharge_findings" class="tinymce-body">
                                 @if(!empty($baby_detail->discharge_findings))
                                  {!! @$baby_detail->discharge_findings !!}
                                 @else
                                 {!! @$headerContent->pediatric_discharge_summary !!}
                                @endif
                            </div>
                        </div>
                    </div>
                   <div class="row mx-0">
                        <div class="col-md-12 col-sm-12 overflow-auto">
                            <h3>Medications
                                <a href="javascript:void(0)" class="add_master_data" data-modal_header="Drugs & Iv Fluids" data-destination_elements="temp_drugs,M_Drugs[]" data-option_value="id" data-option_text="brand_name" data-mas_table="mas_drugivfluid" data-drug_type="oral">
                                    <i class="fa fa-info-circle bs-tooltip" data-placement="right" data-original-title="Add Drugs & Iv Fluids"></i>
                                </a>
                            </h3>
                            <table class="discharge_drugs table table-add-more full-width-fix">
                                <thead>
                                    <tr class="master-add-header">
                                        <th>Drug</th>
                                        <th>Generic Name</th>
                                        <th>Formulation/Strength</th>
                                        <th>Dose</th>
                                        <th>Frequency</th>
                                        <th>Duration</th>
                                        <th>Additional Instruction</th>
                                        <th>
                                            <span>
                                                <a class="btn btn-success btn-view discharge_drugs_add btn_add pull-right" href="javascript:void(0);">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                            </span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                     $mas_frequency_list = ValuelistHelpers::drugFrequencyList(); @endphp
                                    <div class="hidden">
                                        {!! Form::select('temp_drugs',$drug_master,'') !!}
                                        {!! Form::select('temp_frequency',$mas_frequency_list,null) !!}
                                        <!-- {!! Form::select('temp_does',[''=>'N/A']+ValuelistHelpers::dose(),'') !!} -->
                                        {!! Form::select('temp_duration',[''=>'N/A']+ValuelistHelpers::medicationDuration(),'') !!} 
                                    </div>

                                    @if (isset($discharge_medications) && (count($discharge_medications) > 0))
                                        @php $l = 0; @endphp
                                        @foreach ($discharge_medications as $key => $medi_data)
                                        <tr>
                                            @if(isset($medi_data['drug_name']))

                                            <td class="input-width-medium">{!! Form::text('drug_name['.$key.']',$medi_data['drug_name'] ?? $medi_data['drug_name'] ?? '',['class'=>'form-control']) !!}</td>
                                            <td>{!! Form::text('generic_name['.$key.']',$medi_data['generic_name'] ?? '',['class'=>'form-control m_generic_name'.$l]) !!}</td> 
                                            <td>{!! Form::text('formulation['.$key.']',$medi_data['formulation'] ?? '',['class'=>'form-control m_formulation'.$l]) !!}</td>
                                            <td class="input-width-medium">{!! Form::text('dose['.$key.']',$medi_data['dose'] ?? '',['class'=>'form-control']) !!}</td>
                                            <td class="input-width-medium">{!! Form::text('frequency['.$key.']',$medi_data['frequency'] ?? $medi_data['frequency'] ?? '',['class'=>'form-control']) !!}</td>
                                            <td class="input-width-medium">{!! Form::text('duration['.$key.']',$medi_data['duration'] ?? $medi_data['duration'] ?? '',['class'=>'form-control']) !!}</td>
                                            <td>{!! Form::textarea('M_additional_instruction['.$key.']', $medi_data['additional_instruction'] ?? '',['class'=>'form-control textarea-need', 'rows'=>1]) !!}</td>   
                                     
                                            @elseif(isset($medi_data['Medication']))
                                            <td>{!! Form::select('M_Drugs['.$key.']',$drug_master,$medi_data['Medication'] ?? '',['class'=>'m-drugs-changes m-drug-list-name'.$l,'data-id'=>$l, 'style'=>'width: 300px;']) !!}</td>
                                            <td>{!! Form::text('m_generic_name['.$key.']',$medi_data['GenericName'] ?? '',['class'=>'form-control m_generic_name'.$l]) !!}</td> 
                                            <td>{!! Form::text('m_formulation['.$key.']',$medi_data['Formulation'] ?? '',['class'=>'form-control m_formulation'.$l]) !!}</td>

                                            <td class="input-width-medium">{!! Form::text('M_Dose['.$key.']',$medi_data['dose'] ?? $medi_data['Dose'] ?? '',['class'=>'form-control']) !!}</td>
                                            <td class="input-width-medium">{!! Form::select('M_Frequency['.$key.']',$mas_frequency_list,$medi_data['Frequency'] ?? '',['class'=>'form-control']) !!}</td>
                                            <td class="input-width-medium">{!! Form::select('M_Duration['.$key.']',[''=>'N/A']+ValuelistHelpers::medicationDuration(),$medi_data['Duration'] ?? '',['class'=>'form-control']) !!}</td>
                                            <td>{!! Form::textarea('M_additional_instruction['.$key.']', $medi_data['additional_instruction'] ?? '',['class'=>'form-control textarea-need', 'rows'=>1]) !!}</td>

                                            @endif                             
                                            <td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>
                                        </tr>
                                      
                                        @php $l++; @endphp
                                        @endforeach
                                    @else
                                    <tr>
                                        <td>
                                            {!! Form::select('M_Drugs[]',$drug_master,'',['class'=>'m-drugs-changes m-drug-list-name0','data-id'=>'0', 'style'=>'width: 300px;']) !!}
                                        </td>
                                        <td>
                                            {!! Form::text('m_generic_name[]',null,['class'=>'form-control m_generic_name0']) !!}
                                        </td>
                                        <td class="input-width-medium">
                                            {!! Form::text('m_formulation[]',null,['class'=>'form-control m_formulation0']) !!}
                                        </td>
                                        <td class="input-width-medium">
                                            {!! Form::text('M_Dose[]',null,['class'=>'form-control']) !!}
                                        </td>
                                        <td class="input-width-medium">
                                            {!! Form::select('M_Frequency[]',$mas_frequency_list,null,['class'=>'form-control'])!!}
                                        </td>
                                        <td>{!! Form::select('M_Duration[]',[''=>'N/A']+ValuelistHelpers::medicationDuration(),null,['class'=>'form-control']) !!}</td>
                                        <td>{!! Form::textarea('M_additional_instruction[]', null,['class'=>'form-control textarea-need', 'rows'=>1]) !!}</td>
                                        <td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="media_tab">
            <input type="hidden" name="module_name" value="7">
            @include('registration.media')
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function () {
    tinymce.init({
        selector: '#treatment_findings',
        menubar: false,
        inline: true,
        plugins: 'preview powerpaste casechange importcss autolink link table lists tinymcespellchecker',
        toolbar: [
            'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks',
            'alignleft aligncenter alignright alignjustify | numlist bullist | forecolor backcolor casechange | preview | table'
        ],
        setup: function (editor) {
            // Add a keydown listener
            editor.on('keydown', function (e) {
                // Check if Ctrl+Enter or Ctrl+Space is pressed
                if (e.ctrlKey && (e.key === 'Enter' || e.key === ' ')) {
                    e.preventDefault(); 

                    var selection = editor.selection.getRng(); 
                    var containerText = selection.startContainer.textContent || ''; 
                    var cursorPosition = selection.startOffset; 

                    // Extract the word before the cursor
                    var textBeforeCursor = containerText.substring(0, cursorPosition);
                    var lastWordMatch = textBeforeCursor.match(/\b\w+\b$/); 

                    if (lastWordMatch && lastWordMatch[0]) {
                        var shortcode = lastWordMatch[0]; // Extracted last word
                        console.log('Shortcode:', shortcode);

                        $.ajax({
                            url: '{{ url("fetch-shortcode-description") }}',
                            method: 'POST',
                            data: {
                                shortcode: shortcode,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function (response) {
                                if (response.success) {

                                    var editorContent = editor.getContent();
                                    var lastIndex = editorContent.lastIndexOf(shortcode);
                                    if (lastIndex !== -1) {
                                        var updatedContent = editorContent.substring(0, lastIndex) + editorContent.substring(lastIndex).replace(shortcode, response.description);
                                        editor.setContent(updatedContent);
                                        editor.focus();
                                        editor.selection.select(editor.getBody(), true);
                                        editor.selection.collapse(false);
                                    }
                                } else {
                                    alert(response.message || 'No matching shortcode found.');
                                }
                            },
                            error: function () {
                                alert('Failed to fetch shortcode description.');
                            }
                        });
                    }
                }
            });
        }
    });
});

</script>
