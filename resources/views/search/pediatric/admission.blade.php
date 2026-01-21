<?php 
$site_url = url('/').'/public';
$write_permission = session('write_permission');
$user_id = \Auth::user()['RoleId'];
$master_icon_access_user_id = env('ADMIN_ROLE');
$access_master_icon = false;
if ($user_id == $master_icon_access_user_id) {
    $access_master_icon = true;
}

$discharge_status = ValuelistHelpers::Discharge_Status();
$admission_session = ['AM'=>'AM','PM'=>'PM'];
$type_of_care = ['Intensive Care'=>'Intensive Care','Special Care'=>'Special Care','Ward Admission'=>'Ward Admission','High Dependancy Care'=>'High Dependancy Care'];
$temp = [''=>'N/A'];
$type_of_care = array_merge($temp, $type_of_care);
$weight_kg = (!empty($results->current_weight))? $results->current_weight/1000 : '';
$discharge_status = array_merge($temp, $discharge_status);
$admission_session = array_merge($temp, $admission_session);

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
    .mlr-15 {
        margin-left: 15px;
        margin-right: 15px;
    }
    .mt-50 {
        margin-top: 50px;
    }
    .tab-view-shadow {
        margin: 15px;
    }
    #edit-pediatric {
        padding: 15px;
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
    </ul>
    <!-- Tab panes -->
    <div class="tab-content pt-15-must">
        <!-- Basics Form -->
        <div role="tabpanel" class="tab-pane active" id="basicform">
            <div class="col-md-12">
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('BMrNo','Mr No') !!}
                    </div>
                    <div class="col-md-7 custom-input">
                        <div class="col-md-7 col-sm-8">
                            {!! Form::text('BMrNo',@$results->BMrNo,['class'=>'form-control']) !!}
                            <span id="mrn_no_error" style="display: none; color: red"></span>
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
                        {!! Form::hidden('mother_id', @$results->MotherId) !!}
                        {!! Form::hidden('baby_id', @$results->BabyId) !!}
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
                                {!! Form::label('BabyName','Baby Name:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('BabyName',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('MotherName','Mother Name:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('MotherName',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('DOB','DOB:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('DOB',null,['class'=>'form-control datepicker', 'readonly']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                {!! Form::label('Age','Age :') !!}
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
                                        {!! Form::text('year',null,['class'=>'form-control']) !!}
                                    </div>
                                    <div class="col-xs-4">
                                        {!! Form::text('month',null,['class'=>'form-control']) !!}
                                    </div>
                                    <div class="col-xs-4">
                                        {!! Form::text('days',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                        {!! Form::select('admission_time_am',$admission_session,null,['class'=>'input-width-small']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('type_of_care','Type Of Care:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('type_of_care',$type_of_care,null,['class'=>'full-width']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            {!! Form::hidden('visit_type', 'IP', ['id'=>'visit_type']) !!}
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('ip_number', 'IP Number:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('ip_number',null,['class'=>'form-control ip_number'])  !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('surgeon','Surgeon:') !!}
                                @if ($access_master_icon)
                                <a href="javascript:void(0)" class="add_master_data" data-modal_header="Surgeon" data-destination_elements="surgeon" data-option_value="id" data-option_text="Name" data-mas_table="mas_doctors">
                                    <i class="fa fa-info-circle bs-tooltip add-neo-consultant" data-placement="right" data-original-title="Add Surgeon"></i>
                                </a>
                                @endif
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
                            </div>
                            <div class="col-md-9 custom-input">
                                <table class="neonatal-consultant-div table table-add-more full-width-fix">
                                    <thead>                                    
                                        <tr class="master-add-header">
                                            <th class="full-width">
                                                <i class="fa fa-reorder"></i>Add More
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($results->pediatric_consultant) && !empty($results->pediatric_consultant) && count($results->pediatric_consultant) > 0)
                                        @foreach($results->pediatric_consultant as $key => $consultant)
                                        <tr>
                                            <td class="full-width">
                                                {!! Form::select('pediatric_consultant['.$key.']',[''=>'N/A']+ValuelistHelpers::mas_doctors_list(),$consultant,['class'=>'form-control full-width']) !!}
                                            </td>  
                                        </tr>
                                        @endforeach
                                        @else 
                                        <tr data-consultant-id="0">
                                            <td class="full-width">
                                                {!! Form::select('pediatric_consultant[]',[''=>'N/A']+ValuelistHelpers::mas_doctors_list(),null,['class'=>'form-control full-width']) !!}
                                            </td>     
                                        </tr>
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
                                {!! Form::label('hospital_name','Hospital Name') !!}
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
                                @if (!isset($results->complaints))
                                <div id="complaints" class="tinymce-body">
                                    {!! @$results->complaints !!}
                                </div>
                                @else
                                {!! Form::textarea('complaints', null, ['class'=>'form-control', 'rows'=>3]) !!}
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('hopi','HOPI:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                @if (!isset($results->hopi))
                                <div id="hopi" class="tinymce-body">
                                    {!! @$results->hopi !!}
                                </div>
                                @else
                                {!! Form::textarea('hopi', null, ['class'=>'form-control', 'rows'=>3]) !!}
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('treatment_history','Treatment History:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                @if (!isset($results->treatment_history))
                                <div id="treatment_history" class="tinymce-body">
                                    {!! @$results->treatment_history !!}
                                </div>
                                @else
                                {!! Form::textarea('treatment_history', null, ['class'=>'form-control', 'rows'=>3]) !!}
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('past_history','Past History:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                @if (!isset($results->past_history))
                                <div id="past_history" class="tinymce-body">
                                    {!! @$results->past_history !!}
                                </div>
                                @else
                                {!! Form::textarea('past_history', null, ['class'=>'form-control', 'rows'=>3]) !!}
                                @endif
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
                                @if (!isset($results->perinatal_history))
                                <div id="perinatal_history" class="tinymce-body">
                                    {!! @$results->perinatal_history !!}
                                </div>
                                @else
                                {!! Form::textarea('perinatal_history', null, ['class'=>'form-control', 'rows'=>3]) !!}
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('immunization','Immunization:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                @if (!isset($results->immunization))
                                <div id="immunization" class="tinymce-body">
                                    {!! @$results->immunization !!}
                                </div>
                                @else
                                {!! Form::textarea('immunization', null, ['class'=>'form-control', 'rows'=>3]) !!}
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('development','Development:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                @if (!isset($results->development))
                                <div id="development" class="tinymce-body">
                                    {!! @$results->development !!}
                                </div>
                                @else
                                {!! Form::textarea('development', null, ['class'=>'form-control', 'rows'=>3]) !!}
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('family_history','Family History:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                @if (!isset($results->family_history))
                                <div id="family_history" class="tinymce-body">
                                    {!! @$results->family_history !!}
                                </div>
                                @else
                                {!! Form::textarea('family_history', null, ['class'=>'form-control', 'rows'=>3]) !!}
                                @endif
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
                                                @if (!isset($results->general_examination))
                                                <div id="general_examination" class="tinymce-body">
                                                    {!! @$results->general_examination !!}
                                                </div>
                                                @else
                                                {!! Form::textarea('general_examination', null, ['class'=>'form-control', 'rows'=>3]) !!}
                                                @endif
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
                                                {!! Form::label('hr','Heart Rate (bpm):') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::text('hr',null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('pulse_volume','Pulse Volume:') !!}
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
                                                        {!! Form::text('temperature_f', @$results->temperature_f,['class'=>'form-control fahrenheit']) !!}
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
                                                        {!! Form::text('temperature_f',@$results->temperature_f,['class'=>'form-control celsius']) !!}
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
                                                {!! Form::select('cft',[''=>'N/A','< 3 Seconds' => "< 3 Seconds",'3-5 Seconds' => "3-5 Seconds",'>5 Seconds' => ">5 Seconds","Prolonged"=>"Prolonged","Prolonged"=>"Prolonged"],null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('vitals_content','Additional Findings:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                @if (!isset($results->vitals_content))
                                                <div id="vitals_content" class="tinymce-body">
                                                    {!! @$results->vitals_content !!}
                                                </div>
                                                @else
                                                {!! Form::textarea('vitals_content', null, ['class'=>'form-control', 'rows'=>3]) !!}
                                                @endif
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
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('anthropometry_content','Additional Findings:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                @if (!isset($results->anthropometry_content))
                                                <div id="anthropometry_content" class="tinymce-body">
                                                    {!! @$results->anthropometry_content !!}
                                                </div>
                                                @else
                                                {!! Form::textarea('anthropometry_content', null, ['class'=>'form-control', 'rows'=>3]) !!}
                                                @endif
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
                                                @if (!isset($pediatricList))
                                                <input id="murmur" data-size="small" name="murmur" data-off="No" data-on="Yes" data-width="100" data-toggle="toggle" class="form-control switch-input" type="checkbox" @if(isset($results->murmur) && $results->murmur == 'yes') checked="checked" @endif>
                                                @else
                                                {!! Form::select('murmur',[''=>'N/A','yes'=>'Yes','no'=>'No'], null,['class'=>'form-control']) !!}
                                                @endif
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
                                                @if (!isset($results->cvs_findings))
                                                <div id="cvs_findings" class="tinymce-body">
                                                    {!! @$results->cvs_findings !!}
                                                </div>
                                                @else
                                                {!! Form::textarea('cvs_findings', null, ['class'=>'form-control', 'rows'=>3]) !!}
                                                @endif
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
                                                @if (!isset($results->rs_findings))
                                                <div id="rs_findings" class="tinymce-body">
                                                    {!! @$results->rs_findings !!}
                                                </div>
                                                @else
                                                {!! Form::textarea('rs_findings', null, ['class'=>'form-control', 'rows'=>3]) !!}
                                                @endif
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
                                            @if(isset($results->cns_stage) && !empty($results->cns_stage))
                                            @php $cns_stage = json_decode($results->cns_stage); @endphp
                                            @endif

                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('cns_stage[]',['Alert'=>'Alert','Awake'=>'Awake', 'Concious'=>'Concious','Oriented'=>'Oriented','Playful'=>'Playful'], $cns_stage,['class'=>'select2-select-00 full-width-fix', 'multiple']) !!}
                                            </div>
                                        </div>
                                        <h3 class="text-center"><u>Glasgow Coma Scale</u></h3>
                                        <span class="full-width display-inline-block text-center mb-15">Note: Minor (13-15); Moderate (9-12); Severe (3-8);</span>
                                        @if (!isset($pediatricList))
                                        <div class="form-group">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <td rowspan="4" class="vertical-align-center">
                                                            {!! Form::label('eye_opening', 'Eye Opening Response') !!}
                                                            {!! Form::hidden('eye_opening') !!}
                                                        </td>
                                                        <td class="eye_opening gcs-value-selection text-left @if(@$results->eye_opening == 4) active @endif" id="eye_opening_4" data-value="4">4 - Eyes open spontaneously</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="eye_opening gcs-value-selection text-left @if(@$results->eye_opening == 3) active @endif" id="eye_opening_3" data-value="3">3 - Eyes open to verbal command, speech or shout</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="eye_opening gcs-value-selection text-left @if(@$results->eye_opening == 2) active @endif" id="eye_opening_2" data-value="2">2 - Eyes open to pain (not applied to face)</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="eye_opening gcs-value-selection text-left @if(@$results->eye_opening == 1) active @endif" id="eye_opening_1" data-value="1">1 - No eye opening</td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="5" class="vertical-align-center">
                                                            {!! Form::label('verbal', 'Verbal Response') !!}
                                                            {!! Form::hidden('verbal') !!}
                                                        </td>
                                                        <td class="verbal gcs-value-selection text-left @if(@$results->verbal == 5) active @endif" id="verbal_5" data-value="5">5 - Oriented</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="verbal gcs-value-selection text-left @if(@$results->verbal == 4) active @endif" id="verbal_4" data-value="4">4 - Confused conversation, but able to answer questions</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="verbal gcs-value-selection text-left @if(@$results->verbal == 3) active @endif" id="verbal_3" data-value="3">3 - Inappropriate responses, words discernible</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="verbal gcs-value-selection text-left @if(@$results->verbal == 2) active @endif" id="verbal_2" data-value="2">2 - Incomprehensible sounds or speech</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="verbal gcs-value-selection text-left @if(@$results->verbal == 1) active @endif" id="verbal_1" data-value="1">1 - No verbal response</td>                                                        
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="6" class="vertical-align-center">
                                                            {!! Form::label('motor', 'Motor Response') !!}
                                                            {!! Form::hidden('motor') !!}
                                                        </td>
                                                        <td class="motor gcs-value-selection text-left @if(@$results->motor == 6) active @endif" id="motor_6" data-value="6">6 - Obeys commands for movement</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="motor gcs-value-selection text-left @if(@$results->motor == 5) active @endif" id="motor_5" data-value="5">5 - Purposeful movement to painful stimulus</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="motor gcs-value-selection text-left @if(@$results->motor == 4) active @endif" id="motor_4" data-value="4">4 - Withdraws from pain</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="motor gcs-value-selection text-left @if(@$results->motor == 3) active @endif" id="motor_3" data-value="3">3 - Abnormal (spastic) flexion, decorticate posture</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="motor gcs-value-selection text-left @if(@$results->motor == 2) active @endif" id="motor_2" data-value="2">2 - Extensor (rigid) response, decerebrate posture</td>                                                        
                                                    </tr>
                                                    <tr>
                                                        <td class="motor gcs-value-selection text-left @if(@$results->motor == 1) active @endif" id="motor_1" data-value="1">1 - No motor response</td>
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
                                        @else
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('eye_opening','Eye Opening Response :') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::text('eye_opening',null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('verbal','Verbal Response:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::text('verbal',null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-50">
                                                {!! Form::label('motor','Motor Response:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::text('motor',null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        @endif
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
                                                @if (!isset($results->ms_findings))
                                                <div id="ms_findings" class="tinymce-body">
                                                    {!! @$results->ms_findings !!}
                                                </div>
                                                @else
                                                {!! Form::textarea('ms_findings', null, ['class'=>'form-control', 'rows'=>3]) !!}
                                                @endif
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
                                                @if (!isset($results->deep_tendon_findings))
                                                <div id="deep_tendon_findings" class="tinymce-body">
                                                    {!! @$results->deep_tendon_findings !!}
                                                </div>
                                                @else
                                                {!! Form::textarea('deep_tendon_findings', null, ['class'=>'form-control', 'rows'=>3]) !!}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('cns_findings','Other CNS Additional Findings:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                @if (!isset($results->cns_findings))
                                                <div id="cns_findings" class="tinymce-body">
                                                    {!! @$results->cns_findings !!}
                                                </div>
                                                @else
                                                {!! Form::textarea('cns_findings', null, ['class'=>'form-control', 'rows'=>3]) !!}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                                <div class="mt-15 @if(isset($results->liver) && $results->liver != 1) display-none @endif" id="liver-palpation-value">
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
                                                <div class="mt-15 @if(isset($results->spleen) && $results->spleen != 1) display-none @endif" id="spleen-palpation-value">
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
                                                @if (!isset($results->abdomen_findings))
                                                <div id="abdomen_findings" class="tinymce-body">
                                                    {!! @$results->abdomen_findings !!}
                                                </div>
                                                @else
                                                {!! Form::textarea('abdomen_findings', null, ['class'=>'form-control', 'rows'=>3]) !!}
                                                @endif
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
                                {!! Form::label('investigations','Investigations:') !!}
                                @if ($access_master_icon)
                                <a href="javascript:void(0)" class="add_master_data" data-modal_header="Investigations" data-destination_elements="investigations_test" data-option_value="id" data-option_text="package_name" data-mas_table="mas_investigations_package">
                                    <i class="fa fa-info-circle bs-tooltip" data-placement="right" data-original-title="Add Investigations"></i>
                                </a>
                                @endif
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('investigations[]', ValuelistHelpers::get_package_investigations_master(), null,['class'=>'select2-select-00 full-width','multiple']) !!}
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
                                @if (!isset($results->treatment))
                                <div id="treatment" class="tinymce-body">
                                    {!! @$results->treatment !!}
                                </div>
                                @else
                                {!! Form::textarea('treatment', null, ['class'=>'form-control', 'rows'=>3]) !!}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Working Diagnosis Form -->
        <div role="tabpanel" class="tab-pane" id="working-diagnosis-form">
            <div class="widget box mt-10 mlr-15">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> </h4>
                </div>
                <div class="widget-content">
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('working_diagnosis','Working Diagnosis:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            @if (!isset($results->working_diagnosis))
                            <div id="working_diagnosis" class="tinymce-body">
                                {!! @$results->working_diagnosis !!}
                            </div>
                            @else
                            {!! Form::textarea('working_diagnosis', null, ['class'=>'form-control', 'rows'=>3]) !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Discussion / Course In Hospital Form -->
        <div role="tabpanel" class="tab-pane" id="discussionform">
            <div class="widget box mt-10 mlr-15">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> </h4>
                </div>
                <div class="widget-content">
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('discussion_findings','Course in Hospital:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            @if (!isset($results->discussion_findings))
                            <div id="discussion_findings" class="tinymce-body">
                                {!! @$results->discussion_findings !!}
                            </div>
                            @else
                            {!! Form::textarea('discussion_findings', null, ['class'=>'form-control', 'rows'=>3]) !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Treatment Given Form -->
        <div role="tabpanel" class="tab-pane" id="treatmentform">
            <div class="widget box mt-10 mlr-15">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> </h4>
                </div>
                <div class="widget-content">
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('treatment_findings','Notes:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            @if (!isset($results->treatment_findings))
                            <div id="treatment_findings" class="tinymce-body">
                                {!! @$results->treatment_findings !!}
                            </div>
                            @else
                            {!! Form::textarea('treatment_findings', null, ['class'=>'form-control', 'rows'=>3]) !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Discharge Plan Form -->
        <div role="tabpanel" class="tab-pane" id="dischargeform">
            <div class="widget box mt-10 mlr-15">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> </h4>
                </div>
                <div class="widget-content">
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('status','Status:') !!}
                        </div>
                        <div class="col-md-3 custom-input">
                            {!! Form::select('status',$discharge_status,null,['class'=>'form-control']) !!}
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
                            @if (!isset($results->condition_at_discharge))
                            <div id="condition_at_discharge" class="tinymce-body">
                                {!! @$results->condition_at_discharge !!}
                            </div>
                            @else
                            {!! Form::textarea('condition_at_discharge', null, ['class'=>'form-control', 'rows'=>3]) !!}
                            @endif
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
                    <table class="table table-bordered discharge-medications-table">
                        <thead>
                            <tr>
                                <th>S. NO</th>
                                <th>Drug Name</th>
                                <th>Dose</th>
                                <th>Route</th>
                                <th>Frequency</th>
                                <th>Duration </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($results->discharge_medications) && !empty($results->discharge_medications))
                            @foreach(json_decode($results->discharge_medications) as $med_key => $med_val)
                            <tr>
                                <td style="vertical-align: middle;">{{ ++$med_key }}. </td>
                                <td><input class="input-with-bottom-border form-control" name="drug_name[]" type="text" value="{{ $med_val->drug_name }}" /></td>
                                <td><input class="input-with-bottom-border form-control" name="dose[]" type="text" value="{{ $med_val->dose }}" /></td>
                                <td><input class="input-with-bottom-border form-control" name="route[]" type="text" value="{{ $med_val->route }}" /></td>
                                <td><input class="input-with-bottom-border form-control" name="frequency[]" type="text" value="{{ $med_val->frequency }}" /></td>
                                <td>
                                    <input class="input-with-bottom-border form-control" name="duration[]" type="text" value="{{ $med_val->duration }}" /> 
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td style="vertical-align: middle;">1. </td>
                                <td><input class="input-with-bottom-border form-control" name="drug_name[]" type="text" /></td>
                                <td><input class="input-with-bottom-border form-control" name="dose[]" type="text" /></td>
                                <td><input class="input-with-bottom-border form-control" name="route[]" type="text" /></td>
                                <td><input class="input-with-bottom-border form-control" name="frequency[]" type="text" /></td>
                                <td>
                                    <input class="input-with-bottom-border form-control" name="duration[]" type="text" /> 
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('review_details','Review Details:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            @if (!isset($results->review_details))
                            <div id="review_details" class="tinymce-body">
                                {!! @$results->review_details !!}
                            </div>
                            @else
                            {!! Form::textarea('review_details', null, ['class'=>'form-control', 'rows'=>3]) !!}
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('discharge_findings','Additional Information:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            @if (!isset($results->discharge_findings))
                            <div id="discharge_findings" class="tinymce-body">
                                {!! @$results->discharge_findings !!}
                            </div>
                            @else
                            {!! Form::textarea('discharge_findings', null, ['class'=>'form-control', 'rows'=>3]) !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
