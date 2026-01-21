@extends('app')
@section('content')
<!-- need to check -->
@php 
$site_url = url('/').'/public';
Session::forget('slug-nav');
@endphp
<!-- need to check -->
@php    
$admission_menu = ['basicform', 'historyform', 'pregform', 'babyform', 'admissform', 'Proform', 'Cribform', 'Snapform', 'Diagform'];
$discharge_menu = ['dischargeform', 'Checkform'];
if(Session::has('nicuform')) {
$_COOKIE['nicuform'] = Session::get('nicuform');
Session::forget('nicuform');
}
if(!Session::has('slug-nav') && isset($_COOKIE['nicuform']) && in_array($_COOKIE['nicuform'], $discharge_menu)) {
$active = 'basicform';
} 
elseif(Session::has('slug-nav')&&  isset($_COOKIE['nicuform']) && in_array($_COOKIE['nicuform'], $admission_menu)) {  
$active = 'dischargeform';
} 
elseif(!Session::has('slug-nav')) {
$active = 'basicform';
} 
elseif (isset($_COOKIE['nicuform'])) {
$active = $_COOKIE['nicuform'];
}  
else {
$active = 'dischargeform';
} 
@endphp
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="{{url('/')}}">Dashboard</a>
        </li>
        <li class="">
            <a title="" href="{{ action('Admission\NicuController@index') }}">NICU Admission</a>
        </li>
        <li class="current">
            <a title="">Create @if(isset($baby->BabyName) && !empty($baby->BabyName)) For {{ $baby->BabyName }} @endif</a>
        </li>
    </ul>
</div>
<!-- /Breadcrumbs line -->
@if(Session::has('_old_input'))
@php 
ValuelistHelpers::setOldinputs('nicu-admission'); 
@endphp
@endif
<div class="row row-spacing" id="nicu-admission-form">
    <div class="col-md-12 nicu-create">
        {!! Form::model($baby,['url' => action('Admission\NicuController@store'),'id' => 'admissionProforma-form', 'class'=>'nicu-admission-form']) !!}
        @include('errors.list')
        @if(\Session::get('set_nicu_menu'))
        @php  $active = 'basicform';
        \Session::forget('set_nicu_menu'); @endphp
        @endif
        {!! Form::hidden('MotherId') !!}
        {!! Form::hidden('BabyId') !!}
        {!! Form::hidden('AdmissionId',$admission_id) !!}
        {!! Form::hidden('visit_module_name','nicu_admission') !!}
        <!-- Nav tabs -->
        <div role="tabpanel" class="tabbable tabbable-custom">
            <ul class="nav nav-tabs" role="tablist">
                @if(!Session::has('slug-nav'))
                <li role="presentation" @if($active == 'basicform')  class="active" @endif>
                    <a href="#basicform" aria-controls="basicform" role="tab" data-toggle="tab">Basics</a>
                </li>
                <li role="presentation" @if($active == 'historyform')  class="active" @endif>
                    <a href="#historyform" aria-controls="historyform" role="tab" data-toggle="tab">Medical History</a>
                </li>
                <li role="presentation" @if($active == 'pregform')  class="active"  @endif>
                    <a href="#pregform" aria-controls="pregform" role="tab" data-toggle="tab">Pregnancy</a>
                </li>
                <li role="presentation" @if($active == 'babyform') class="active" @endif>
                    <a href="#babyform" aria-controls="babyform" role="tab" data-toggle="tab">Baby Details</a>
                </li>
                <li role="presentation" @if($active == 'admissform') class="active" @endif>
                    <a href="#admissform" aria-controls="admissform" role="tab" data-toggle="tab">Admission Details</a>
                </li>
                <li role="presentation" @if($active == 'Proform')  class="active"  @endif>
                    <a href="#Proform" aria-controls="Proform" role="tab" data-toggle="tab">Procedures</a>
                </li>
                <li role="presentation" @if($active == 'Cribform')  class="active"  @endif>
                    <a href="#Cribform" aria-controls="Cribform" role="tab" data-toggle="tab">CRIB II</a>
                </li>
                <li role="presentation" @if($active == 'Snapform')  class="active" @endif>
                    <a href="#Snapform" aria-controls="Snapform" role="tab" data-toggle="tab">SNAPPE II</a>
                </li>
                <li role="presentation" @if($active == 'Diagform')  class="active"  @endif>
                    <a href="#Diagform" aria-controls="Diagform" role="tab" data-toggle="tab">Diagnosis</a>
                </li>
                @endif 
                @if(Session::has('slug-nav'))
                <li role="presentation" @if($active == 'dischargeform')   class="active"  @endif>
                    <a href="#dischargeform" aria-controls="dischargeform" role="tab" data-toggle="tab">Discharge Details</a>
                </li>
                <li role="presentation" @if($active == 'Checkform')  class="active" @endif>
                    <a href="#Checkform" aria-controls="Checkform" role="tab" data-toggle="tab">Checklist</a>
                </li>
                @endif  
            </ul>
            <!-- Tab panes -->
            <div class="tab-content tab-view-shadow">
                <!-- Basics Form -->
                <div role="tabpanel" class="tab-pane @if($active == 'basicform') active @endif" id="basicform">
                    <div class="col-md-6 col-sm-6">
                        <div class="widget box mt-10">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                {!! Form::hidden('MotherId') !!}
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
                                        {!! Form::label('BMrNo',Lang::get('home.mrn').':') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('BMrNo',null,['class'=>'form-control','readonly']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('DOB','DOB:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('DOB',null,['class'=>'form-control datepicker dob_date birth-date','readonly']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('BirthWeight','Birth Weight (In grams):') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('BirthWeight',null,['class'=>'form-control','readonly']) !!}
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('BirthStatus','Birth Status:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input" style="pointer-events: none; cursor: not-allowed;">
                                        <!-- {!!
                                        Form::select('BirthStatus',['Inborn'=>'Inborn','Outborn'=>'Outborn'],null,['class'=>'form-control','readonly','disabled'=>'true'])
                                        !!} -->
                                        <input id="BirthStatus" data-size="small" name="BirthStatus" data-off="Outborn" data-on="Inborn" data-width="100" data-toggle="toggle" class="form-control switch-input" type="checkbox" @if(isset($baby->BirthStatus) && $baby->BirthStatus == 'Inborn') checked="checked" @endif>
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
                                                {!! Form::text('g_weeks',null,['class'=>'form-control gestation-wks','max'=>'46','readonly']) !!}
                                            </div>
                                            <div class="inbeween_two_fields">
                                                <span>+</span>
                                            </div>
                                            <div>
                                                <small>(In Days)</small>
                                                {!! Form::text('g_days',null,['class'=>'form-control gestation-days','max'=>'6','readonly']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('BabyBloodGroup','Baby\'s Blood Group:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('BabyBloodGroup',null,['class'=>'form-control','readonly']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Sex','Sex:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!!
                                            Form::select('Sex',['Male'=>'Male','Female'=>'Female','Indeterminate'=>'Indeterminate'],null,['class'=>'form-control','disabled'])
                                            !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('ReferredBy','Referred From:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::text('ReferredBy',null,['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('ReferralReason','Referral Reason:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::text('ReferralReason',null,['class'=>'form-control text-convertion-lower']) !!}
                                        </div>
                                    </div>
                                    @if ($baby->g_weeks < 36 && $baby->g_days <= 6)
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                            {!! Form::label('CorrectedGestation','Corrected Gestational Age:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input clear-xs">
                                            <div class="row col-md-12 display-flex">
                                                <div>
                                                    <small>(In Weeks)</small>
                                                    {!! Form::text('cg_weeks',null,['class'=>'form-control corrected-gestation-wks', 'readonly']) !!}
                                                    <label class="error help-block" for="cg_weeks" generated="true"></label>
                                                </div>
                                                <div class="inbeween_two_fields">
                                                    <span>+</span>
                                                </div>
                                                <div>
                                                    <small>(In Days)</small>
                                                    {!! Form::text('cg_days',null,['class'=>'form-control corrected-gestation-days', 'readonly']) !!}
                                                    <label class="error help-block" for="cg_days" generated="true"></label> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="widget box mt-10">
                                <div class="widget-header">
                                    <h4><i class="fa fa-reorder"></i> </h4>
                                </div>
                                <div class="widget-content">
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('AdmissionDate','Admission Date:', ['class'=>'required-label']) !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::text('AdmissionDate',null,['class'=>'form-control admission-date record-date','readonly']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                            {!! Form::label('AdmissionTime','Admission Time:', ['class'=>'required-label']) !!}
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
                                                <div class="col-xs-4">
                                                    {!! Form::select('AdmissionTime',$admission['time'],null,['class'=>'form-control input-width-small']) !!}
                                                </div>
                                                <div class="col-xs-4">
                                                    {!! Form::select('AdmissionTime_MINS',$admission['mins'],null,['class'=>'form-control input-width-small']) !!}
                                                </div>
                                                <div class="col-xs-4">
                                                    {!! Form::select('AdmissionTime_AM',['AM'=>'AM','PM'=>'PM'],null,['class'=>'form-control input-width-small']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('TypeOfCare','Type Of Care:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::select('TypeOfCare',['Intensive Care'=>'Intensive Care','Special Care'=>'Special Care','Ward Admission'=>'Ward Admission','High Dependancy Care'=>'High Dependancy Care'],null,['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::hidden('visit_type', 'IP', ['id'=>'visit_type']) !!}
                                            {!! Form::label('ip_number', Lang::get('home.ip').':') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::text('ip_number',null,['class'=>'form-control ip_number'])  !!}
                                            <a class="btn btn-warning btn-basic-shadow input-width-medium pull-right" id="generate-ip" data-ip-field="ip_number" data-form-id="admissionProforma-form" title="{{Lang::get('home.ip_generate_btn_title')}}">
                                                <img src="{{$site_url}}/img/saraswathi_logo.png"> <span>{{Lang::get('home.ip_generate_btn')}}</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('AdmissionWt','Admission Weight (In grams):', ['class'=>'required-label']) !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::text('AdmissionWt',null,['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('AgeOnAdmission','Age On Admission') !!}
                                        </div>
                                        <div class="col-md-9 custom-input clear-xs">
                                            <div class="row age_on_admission_days">
                                                <div class="col-md-10">
                                                    {!! Form::text('AgeOnAdmissioninDays',null,['class'=>'form-control', 'id'=> 'AgeOnAdmissioninDays']) !!}
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="label-control">
                                                        Days
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row age_on_admission_hours">
                                                <div class="col-md-10">
                                                    {!! Form::text('AgeOnAdmissionhour',null,['class'=>'form-control', 'id' => 'AgeOnAdmissionhour']) !!}
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="label-control">
                                                        Hours
                                                    </label>
                                                </div>
                                            </div>
                                            <!-- <div class="row">
                                                <div class="col-xs-6 text-center">
                                                    <small>(In Days)</small>
                                                </div>
                                                <div class="col-xs-6 text-center">
                                                    <small>(In hours only if < 96)</small>
                                                </div>
                                                <div class="col-xs-6">
                                                    {!! Form::text('AgeOnAdmissioninDays',null,['class'=>'form-control']) !!}
                                                </div>
                                                <div class="col-xs-6">
                                                    {!! Form::text('AgeOnAdmissionhour',null,['class'=>'form-control']) !!}
                                                </div>
                                            </div> -->
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('Surgeon','Surgeon:') !!}
                                            <a href="javascript:void(0)" class="add_master_data" data-modal_header="Surgeon" data-destination_elements="Surgeon,SeenBy" data-option_value="id" data-option_text="Name" data-mas_table="mas_doctors">
                                                <i class="fa fa-info-circle bs-tooltip add-neo-consultant" data-placement="right" data-original-title="Add Surgeon"></i>
                                            </a>
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::select('Surgeon',['Not applicable'=>'Not applicable']+ValuelistHelpers::get_surgeons_lists(),null,['class'=>'form-control']) !!}
                                        </div>
                                    </div>                                   
                                <div class="hidden">
                                    {!! Form::select('seen_by',$DoctorMaster,null,['class'=>'form-control']) !!}
                                </div>                                     
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('SeenBy','Seen By', ['class'=>'required-label']) !!}
                                        <a href="javascript:void(0)" class="add_master_data" data-modal_header="Seen By" data-destination_elements="Surgeon,SeenBy" data-option_value="id" data-option_text="Name" data-mas_table="mas_doctors">
                                            <i class="fa fa-info-circle bs-tooltip add-neo-consultant" data-placement="right" data-original-title="Add Doctor"></i>
                                        </a>
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <table class="seen-by-div table table-add-more full-width-fix">
                                            <thead>                                    
                                                <tr class="master-add-header">
                                                    <th class="full-width">
                                                        <i class="fa fa-reorder"></i>Add More
                                                    </th>
                                                    <th>
                                                        <span>
                                                            <a class="btn btn-success btn-view nicu_seen_by_add btn_add" href="javascript:void(0);">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                        </span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(isset($results->SeenBy) && !empty($results->SeenBy) && count($results->SeenBy) > 0)
                                                @foreach($results->SeenBy as $key => $seen_by)
                                                <tr>
                                                    <td>
                                                        {!! Form::select('SeenBy['.$key.']',$DoctorMaster,$seen_by,['class'=>'form-control full-width']) !!}
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
                                                <tr>
                                                    <td>
                                                        {!! Form::select('SeenBy[]',$DoctorMaster,null,['class'=>'form-control full-width']) !!}
                                                    </td>
                                                </tr>
                                                @endif 
                                            </tbody>
                                        </table>
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
                                    @if (isset($baby->room_id) && $baby->room_id != '' && isset($baby->bed_id) && $baby->bed_id != '')
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('room_id','Room No.', ['class'=>'required-label']) !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::text('room_id',null,['class'=>'form-control','readonly']) !!}
                                        </div>
                                    </div>
                                    <input type="hidden" value="{{ json_encode(ValuelistHelpers::getBed(1)) }}" id="temp_bed_id" />
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('bed_id','Bed No.', ['class'=>'required-label']) !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::text('bed_id',null,['class'=>'form-control','readonly']) !!}
                                        </div>
                                    </div>
                                    @else
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('room_id','Room No.', ['class'=>'required-label']) !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::select('room_id',[''=>'N/A']+ValuelistHelpers::getRoom(1),null,['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                    <input type="hidden" value="{{ json_encode(ValuelistHelpers::getBed(1)) }}" id="temp_bed_id" />
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('bed_id','Bed No.', ['class'=>'required-label']) !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::select('bed_id',[''=>'N/A'],null,['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- History Form -->
                    <div role="tabpanel" class="tab-pane  @if($active == 'historyform') active @endif" id="historyform">
                        <div class="widget box mt-10 row mx-0">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="col-md-6 form-group row">
                                    <div class="col-md-12 custom-input">
                                        <table class="medi table table-add-more full-width-fix">
                                            <thead>
                                                <tr class="master-add-header">
                                                    <th>
                                                        Medical Problems
                                                        <a href="javascript:void(0)" class="add_master_data" data-modal_header="Medical Problems" data-destination_elements="temp_medi_probs,Problems[]" data-option_value="id" data-option_text="Name" data-mas_table="mas_medical_problems">
                                                            <i class="fa fa-info-circle bs-tooltip add-neo-consultant" data-placement="right" data-original-title="Add Medical Problems"></i>
                                                        </a>
                                                    </th>
                                                    <th>Medications</th>
                                                    <th>
                                                        <span>
                                                            <a class="btn btn-success btn-view medi_add btn_add" href="javascript:void(0);">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                        </span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <div class="hidden">
                                                    {!! Form::select('temp_medi_probs',$medi_probs_master,'') !!}
                                                </div>
                                                <tr>
                                                    <td>{!! Form::select('Problems[]',$medi_probs_master,'',['class'=>'form-control input-width-xlarge']) !!}</td>
                                                    <td><input type="text" name="Medications[]" value="" class="form-control input-width-xlarge"/></td>
                                                    <td><span class="fa fa-trash btn btn-danger btn-view remove-medi"></span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-12 plr-0">
                                    <div class="col-md-5 col-sm-6">
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('Smoking','Smoking:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('Smoking',['No'=>'No','Yes'=>'Yes'],'No',['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('Alcohol','Alcohol:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('Alcohol',['No'=>'No','Yes'=>'Yes'],'No',['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sm-6">
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('Tobacco','Tobacco:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('Tobacco',['No'=>'No','Yes'=>'Yes'],'No',['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane @if($active == 'pregform') active @endif" id="pregform">
                        <div class="widget box mt-10 row mx-0">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="col-md-9 form-group">
                                    <div class="col-md-12 custom-input plr-0">
                                        <table class="complication table table-add-more full-width-fix">
                                            <thead>
                                                <tr class="master-add-header">
                                                    <th>
                                                        Complication
                                                        <a href="javascript:void(0)" class="add_master_data" data-modal_header="Complications" data-destination_elements="temp_complications,Complication[]" data-option_value="id" data-option_text="Name" data-mas_table="mas_complication">
                                                            <i class="fa fa-info-circle bs-tooltip add-neo-consultant" data-placement="right" data-original-title="Add Complications"></i>
                                                        </a>
                                                    </th>
                                                    <th>Treatment</th>
                                                    <th>
                                                        <span>
                                                            <a class="btn btn-success btn-view nicu_complication_add btn_add" href="javascript:void(0);">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                        </span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <div class="hidden">
                                                    {!! Form::select('temp_complications',$complication_master,'',["class"=>"form-control "]) !!}
                                                </div>
                                                <tr>
                                                    <td class="half-width">{!! Form::select('Complication[]',$complication_master,null,["class"=>"form-control"]) !!}</td>
                                                    <td class="half-width"><input type="text" class="form-control" name="Treatments[]" value="" /></td>
                                                    <td><span class="fa fa-trash btn btn-danger btn-view remove-medi"></span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <p><br><b>Antenatal Ultrasound Findings</b> </p>
                                </div>
                                <div class="col-md-9">
                                    <div class="col-md-7 plr-0 form-group row">
                                        <div class="col-md-12 custom-input">
                                            <table class="usg table table-add-more full-width-fix">
                                                <thead>
                                                    <tr>
                                                        <th colspan="3" class="bg-theme">Dating Scan</th>
                                                    </tr>
                                                    <tr>
                                                        <th><h5><strong>Date</strong></h5></th>
                                                        <th><h5><strong>Gestation In Weeks</strong></h5></th>
                                                        <th><h5><strong>Findings</strong></h5></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="form-group"><input type="text" value="{{ (isset($datingScan['date']) && !empty($datingScan['date']) && !is_null($datingScan['date'])) ? date('d-m-Y', strtotime($datingScan['date'])) : '' }}" class="form-control input-width-medium"  name="datingdate" @if(isset($datingScan['date']) && !empty($datingScan['date'])) disabled="true" @endif readonly /></td>
                                                        <td class="form-group"><input type="text" value="{{ @$datingScan['Gestation'] }}" class="form-control input-width-medium"  name="datinggestations" @if(isset($datingScan['Gestation']) && !empty($datingScan['Gestation'])) disabled="true" @endif /></td>
                                                        <td class="form-group"><input type="text" value="{{ @$datingScan['Finding'] }}" name="datingfindings" class="form-control input-width-large" @if(isset($datingScan['Gestation']) && !empty($datingScan['Gestation'])) disabled="true" @endif /></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2"><label for="datinggestations" generated="true" class="error help-block"></label></td>
                                                    </tr>
                                                </tbody>
                                            </table> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="col-md-7 plr-0 form-group row">
                                        <div class="col-md-12 custom-input">
                                            <table class="usg table table-add-more full-width-fix">
                                                <thead>
                                                    <tr>
                                                        <th colspan="3" class="bg-theme">Anomaly Scan</th>
                                                    </tr>
                                                    <tr>
                                                        <th><h5><strong>Date</strong></h5></th>
                                                        <th><h5><strong>Gestation In Weeks</strong></h5></th>
                                                        <th><h5><strong>Findings</strong></h5></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td  class="form-group"><input type="text" name="analogdate" value="{{ (isset($analogScan['date']) && !empty($analogScan['date']) && !is_null($analogScan['date'])) ? date('d-m-Y', strtotime($analogScan['date'])) : '' }}" class="form-control input-width-medium" @if(isset($analogScan['date']) && !empty($analogScan['date'])) disabled="true" @endif readonly /></td>
                                                        <td  class="form-group"><input type="text" name="analoggestations" value="{{ @$analogScan['Gestation'] }}" class="form-control input-width-medium" @if(isset($analogScan['Gestation']) && !empty($analogScan['Gestation'])) disabled="true" @endif /></td>
                                                        <td  class="form-group"><input type="text" name="analogfindings"   value="{{ @$analogScan['Finding'] }}"  class="form-control input-width-large" @if(isset($analogScan['Gestation']) && !empty($analogScan['Gestation'])) disabled="true" @endif /></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2"><label for="analoggestations" generated="true" class="error help-block"></label></td>
                                                    </tr>
                                                </tbody>
                                            </table> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="col-md-7 plr-0 form-group row">
                                        <div class="col-md-12 custom-input">
                                            <table class="any-further-scan usg table table-add-more full-width-fix">
                                                <thead>
                                                    <tr>
                                                        <th colspan="4" class="bg-theme">Any further scan ?</th>
                                                    </tr>
                                                    <tr class="master-add-header">
                                                        <th>Date</th>
                                                        <th>Gestation In Weeks</th>
                                                        <th>Findings</th>
                                                        <th>
                                                            <span>
                                                                <a class="btn_add btn btn-success btn-view any-further-scan-add" href="javascript:void(0);">
                                                                    <i class="fa fa-plus"></i></a>
                                                                </span>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if(isset($neonatalOtherscan) && count($neonatalOtherscan) > 0)
                                                        @foreach($neonatalOtherscan as $otherscanKey => $otherscanValue)
                                                        <tr>
                                                            <td  class="form-group"> <input type="text" value="{{ (isset($otherscanValue['date']) && !empty($otherscanValue['date']) && !is_null($otherscanValue['date'])) ? date('d-m-Y', strtotime($otherscanValue['date'])) : '' }}" class="form-control input-width-medium"  name="notherdate[]" @if(isset($otherscanValue['date']) && !empty($otherscanValue['date'])) disabled="true" @endif readonly/></td>
                                                            <td  class="form-group"> <input type="text" value="{{ $otherscanValue['Gestation'] }}" class="form-control input-width-medium"  name="nothergestations[]" id="gestations" disabled="true"/></td>
                                                            <td  class="form-group"> <input type="text"  value="{{ $otherscanValue['Finding']  }}" name="notherfindings[]" class="form-control input-width-large" disabled="true" /></td>
                                                            <td class="form-group">  </td>
                                                        </tr>
                                                        @endforeach
                                                        @endif    
                                                        @if(isset($otherScan) && count($otherScan) > 0)
                                                        @foreach($otherScan as $scanKey => $scanValue)
                                                        <tr>
                                                            <td  class="form-group"><input type="text" value="{{ (isset($scanValue['date']) && !empty($scanValue['date']) && !is_null($scanValue['date'])) ? date('d-m-Y', strtotime($scanValue['date'])) : '' }}" class="form-contro input-width-mediuml"  name="otherdate[]" readonly /></td>
                                                            <td  class="form-group"><input type="text" value="{{ $scanValue['Gestation'] }}" class="form-control input-width-medium"  name="othergestations[]" id="gestations" /></td>
                                                            <td  class="form-group"><input type="text"  value="{{ $scanValue['Finding']  }}" name="otherfindings[]" class="form-control input-width-large"  /></td>
                                                            <td class="form-group"><span class="fa fa-trash btn btn-danger btn-view remove-usg"></span></td>
                                                        </tr>
                                                        @endforeach
                                                        @else
                                                        <tr>
                                                            <td  class="form-group"><input type="text" class="form-control input-width-medium"  name="otherdate[]" readonly /></td>
                                                            <td  class="form-group"><input type="text" class="form-control input-width-medium"  name="othergestations[]" /></td>
                                                            <td  class="form-group"><input type="text" name="otherfindings[]" class="form-control input-width-large"  /></td>
                                                            <td class="form-group"><span class="fa fa-trash btn btn-danger btn-view remove-usg"></span></td>
                                                        </tr>
                                                        @endif
                                                    </tbody>
                                                </table> 
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>

                                        <span><label for="othergestations[]" generated="true" class="error help-block"></label></span>
                                    </div>
                                    <div class="col-md-9 bottom-specing">
                                        <div class="col-md-7 plr-0 form-group row">
                                            <div class="col-md-12 custom-input">
                                                <table class="doppler-scan usg table table-add-more full-width-fix">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="4" class="bg-theme">Doppler Scan</th>
                                                        </tr>
                                                        <tr class="master-add-header">
                                                            <th>Date</th>
                                                            <th>Gestation In Weeks</th>
                                                            <th>Findings</th>
                                                            <th>
                                                                <span>
                                                                    <a class="btn_add btn btn-success btn-view doppler-scan-add" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                                                                </span>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if(isset($neonatalDopplerscan) && count($neonatalDopplerscan) > 0)
                                                        @foreach($neonatalDopplerscan as $dopplerscanKey => $dopplerscanValue)
                                                        <tr>
                                                            <td  class="form-group"> <input type="text" value="{{ (isset($dopplerscanValue['date']) && !empty($dopplerscanValue['date']) && !is_null($dopplerscanValue['date'])) ? date('d-m-Y', strtotime($dopplerscanValue['date'])) : '' }}" class="form-control input-width-medium"  name="notherdate[]" @if(isset($dopplerscanValue['date']) && !empty($dopplerscanValue['date'])) disabled="true" @endif readonly/></td>
                                                            <td  class="form-group"> <input type="text" value="{{ $dopplerscanValue['Gestation'] }}" class="form-control input-width-medium"  name="nothergestations[]" id="gestations" disabled="true"/></td>
                                                            <td  class="form-group"> <input type="text"  value="{{ $dopplerscanValue['Finding']  }}" name="notherfindings[]" class="form-control input-width-large" disabled="true" /></td>
                                                            <td class="form-group"> </td>
                                                        </tr>
                                                        @endforeach
                                                        @endif    
                                                        @if (isset($dopplerScan) && count($dopplerScan) > 0)
                                                        @foreach($dopplerScan as $dopplerKey => $dopplerValue)
                                                        <tr>
                                                            <td  class="form-group"><input type="text" value="{{ (isset($dopplerValue['date']) && !empty($dopplerValue['date']) && !is_null($dopplerValue['date'])) ? date('d-m-Y', strtotime($dopplerValue['date'])) : '' }}" class="form-control input-width-medium"  name="dopplerdate[]" readonly/></td>
                                                            <td  class="form-group"><input type="text" value="{{ $dopplerValue['Gestation'] }}" class="form-control input-width-medium"  name="dopplergestations[]" id="gestations" /></td>
                                                            <td  class="form-group"><input type="text"  value="{{ $dopplerValue['Finding']  }}" name="dopplerfindings[]" class="form-control input-width-large"  /></td>
                                                            <td class="form-group"><span class="fa fa-trash btn btn-danger btn-view remove-usg"></span></td>
                                                        </tr>
                                                        @endforeach
                                                        @else
                                                        <tr>
                                                            <td  class="form-group"><input type="text" class="form-control input-width-medium"  name="dopplerdate[] input-width-medium" readonly /></td>
                                                            <td  class="form-group"><input type="text" class="form-control input-width-medium"  name="dopplergestations[] input-width-medium" /></td>
                                                            <td  class="form-group"><input type="text" name="dopplerfindings[]" class="form-control input-width-large"  /></td>
                                                            <td class="form-group"><span class="fa fa-trash btn btn-danger btn-view remove-usg"></span></td>
                                                        </tr>
                                                        @endif
                                                    </tbody>
                                                </table> 
                                                <div class="clearfix"></div>
                                                <span><label for="dopplergestations[]" generated="true" class="error help-block"></label></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Baby Details -->
                        <div role="tabpanel" class="tab-pane @if($active == 'babyform') active @endif" id="babyform">
                            <div class="col-md-6 col-sm-6">
                                <div class="widget box mt-10">
                                    <div class="widget-header">
                                        <h4><i class="fa fa-reorder"></i> </h4>
                                    </div>
                                    <div class="widget-content">
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('DescriptionOfResuscitation','Description Of Resuscitation:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::textarea('DescriptionOfResuscitation',null,['class'=>'form-control','rows' => 5]) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12 text-center">
                                                <h4><strong>Post Resuscitation Care</strong></h4>
                                                <!-- {!! Form::label('Post Resuscitation Care','Post Resuscitation Care') !!} -->
                                                <hr class="mt-0" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('VentilationRequired','Invasive Ventilation Required:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <input checked data-toggle="toggle" data-width="100" data-size="small" class="form-control" id="VentilationRequired" name="VentilationRequired" data-on="Yes" data-off="No" type="checkbox">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('SurfactantGiven','Surfactant Given In Labour Room / Theatre:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('SurfactantGiven',[''=>'N/A','Yes'=>'Yes','No'=>'No'],null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('SurfactantType','Surfactant Type:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('SurfactantType',[''=>'N/A','Curosurf'=>'Curosurf','Survanta'=>'Survanta','Neosurf'=>'Neosurf'],null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('Dose','Dose:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::text('Dose',null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('DateofAdministration','Date of Administration:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::text('DateofAdministration',null,['class'=>'form-control admission-date', 'readonly']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control" style="margin-top: 15px;">
                                                {!! Form::label('TimeOfAdministrations','Time Of Administration:') !!}
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
                                                    <div class="col-xs-4">
                                                        {!! Form::select('TimeOfAdministration',$admission['time'],null,['class'=>'form-control input-width-small','id'=>'TimeOfAdministration']) !!} 
                                                    </div>
                                                    <div class="col-xs-4">
                                                        {!!
                                                            Form::select('TimeOfAdministration_MINS',$admission['mins'],null,['class'=>'form-control
                                                            input-width-small','id'=>'TimeOfAdministration_MINS']) !!}
                                                        </div>
                                                        <div class="col-xs-4">
                                                            {!!
                                                                Form::select('TimeOfAdministration_AM',['AM'=>'AM','PM'=>'PM'],null,['class'=>'form-control
                                                                input-width-small','id'=>'TimeOfAdministration_AM']) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('AgeAfterBirth','Age After Birth:') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::text('AgeAfterBirth',null,['class'=>'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('delivery_cpap','Delivery room CPAP given ?:') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        <input checked data-toggle="toggle" data-width="100" data-size="small" class="form-control" id="delivery_cpap" name="delivery_cpap" data-on="Yes" data-off="No" type="checkbox">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="widget box mt-10 row mx-0">
                                            <div class="widget-header">
                                                <h4><i class="fa fa-reorder"></i> </h4>
                                            </div>
                                            <div class="widget-content">
                                                <div class="form-group row mx-0">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>{!! Form::label('air_flow','Air Flow During Transfer L/min:') !!}</th>
                                                                <th>{!! Form::label('oxgen_flow','Oxygen Flow During Transfer L/min:') !!}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>{!! Form::text('air_flow',null,['class'=>'form-control']) !!}</td>
                                                                <td>{!! Form::text('oxgen_flow',null,['class'=>'form-control']) !!}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <label for="air_flow" generated="true" class="error help-block"></label>
                                                <label for="oxgen_flow" generated="true" class="error help-block"></label>
                                                <div class="form-group row">
                                                    <div class="col-md-12">
                                                        {!! Form::label('TransferFiO2','Calculated / Actual FIO2% During Transfer:') !!}
                                                    </div>
                                                    <div class="col-md-12">
                                                        {!! Form::text('TransferFiO2',null,['class'=>'form-control']) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Admission Form -->
                                <div role="tabpanel" class="tab-pane @if($active == 'admissform') active @endif" id="admissform">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="widget box mt-10">
                                            <div class="widget-header">
                                                <h4><i class="fa fa-reorder"></i> </h4>
                                            </div>
                                            <div class="widget-content">
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('AdmittedFrom','Admitted From:') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::select('AdmittedFrom',[''=>'Select','Labour ward'=>'Labour ward','Postnatal ward'=>'Postnatal ward','OP'=>'OP','Outside Hospital'=>'Outside Hospital','Obstetric theatres'=>'Obstetric theatres'],null,['class'=>'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('MajorComplaints','Major Complaints:') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::textarea('MajorComplaints',null,['class'=>'form-control','rows' => 5]) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('Ventilation','Respiratory Support at the time of admission:') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        <input id="Ventilation" name="Ventilation" data-on="Yes" data-off="No" checked data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('Mode','Mode:') !!}
                                                        <a href="javascript:void(0)" class="add_master_data" data-modal_header="Mode" data-destination_elements="Mode" data-option_value="Id" data-option_text="Mode_name" data-mas_table="mas_admissionmode">
                                                            <i class="fa fa-info-circle bs-tooltip" data-placement="right" data-original-title="Add Mode"></i>
                                                        </a>
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::select('Mode',[''=>'N/A']+$admissionmode_master,null,['class'=>'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('pip_set','Pip (Set):') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::text('pip_set',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('Pip','Pip (Delivered):') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::text('Pip',null,['class'=>'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('PEEP','PEEP:') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::text('PEEP',null,['class'=>'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('amplitude_delta','Amplitude &delta; :') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::text('amplitude_delta',null,['class'=>'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('mean_airway_pressure','Mean Airway Pressure:') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::text('mean_airway_pressure',null,['class'=>'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('map','MAP:') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::text('map',null,['class'=>'form-control' , 'onkeypress' => 'return isNumber(event, this);']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('fio2_set','FIO2 % (Set):') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::text('fio2_set',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('Fio2','FIO2 % (Delivered):') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::text('Fio2',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('Rate','Rate\Frequency:') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::text('Rate',null,['class'=>'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('frequency','Frequency (Hz):') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::text('frequency',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('IT','IT:') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::text('IT',null,['class'=>'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('Flow_l_min','Flow (L/Min):') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::text('Flow_l_min',null,['class'=>'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('RR','RR:') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::text('RR',null,['class'=>'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('ratio','I:E ratio:') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::text('ratio',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('nicu_retractions','Retractions:') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::select('nicu_retractions',[''=>'N/A','No'=>'No','Mild'=>'Mild','Moderate'=>'Moderate','Severe'=>'Severe'],null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('Retractions')]) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('nicu_airentry','Air entry:') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::select('nicu_airentry',[''=>'N/A','Equal'=>'Equal','Reduced Bilateral'=>'Reduced Bilateral','Reduced Rt'=>'Reduced Right','Reduced Lt'=>'Reduced &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Left'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('AirEntry')]) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('ChestMovement','Chest Movement:') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::select('ChestMovement',[''=>'N/A','Symmetrical'=>'Symmetrical','Asymmetrical'=>'Asymmetrical'],null,['class'=>'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('HR','HR in bpm:') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::text('HR',null,['class'=>'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('BP','Systolic BP:') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::text('BP',null,['class'=>'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('diastolic_bp','Diastolic BP:') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::text('diastolic_bp',null,['class'=>'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('MeanBP','Mean BP:') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::text('MeanBP',null,['class'=>'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('nicu_central_pulses','Central Pulses:') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::select('nicu_central_pulses',[''=>'N/A','Normal'=>'Normal','Bounding'=>'Bounding','Feeble/Weak'=>'Feeble/Weak','Absent'=>'Absent'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('PeripheralPulses')]) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('nicu_peripheral_pulses','Peripheral Pulses:') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::select('nicu_peripheral_pulses',[''=>'N/A','Normal'=>'Normal','Bounding'=>'Bounding','Feeble/Weak'=>'Feeble/Weak','Absent'=>'Absent'],null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('PeripheralPulses')]) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('nicu_femoral_pulses','Femoral Pulses:') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::select('nicu_femoral_pulses',[''=>'N/A','Normal'=>'Normal','Bounding'=>'Bounding','Feeble/Weak'=>'Feeble/Weak','Absent'=>'Absent'],null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('PeripheralPulses')]) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('nicu_s1s2','S1S2:') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::select('nicu_s1s2',[''=>'N/A','Normal'=>'Normal','Abnormal'=>'Abnormal'],null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('nicu_murmur','Murmur:') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::select('nicu_murmur',[''=>'N/A','Absent'=>'Absent','Present'=>'Present'],null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('default')]) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('CFT','CFT:') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                {!! Form::select('CFT',[''=>'N/A','< 3 Seconds' => "< 3 Seconds",'3-5 Seconds' => "3-5 Seconds",'>5 Seconds' => ">5 Seconds","Prolonged"=>"Prolonged"],null,['class'=>'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('nicu_color','Color:') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::select('nicu_color',['Pink' => "Pink",'Yellow'=>'Yellow','Pale'=>'Pale',"Acral Cyanosis"=>"Acral Cyanosis","Central Cyanosis"=>"Central Cyanosis"],null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('Color')]) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="widget box mt-10">
                                            <div class="widget-header">
                                                <h4><i class="fa fa-reorder"></i> </h4>
                                            </div>
                                            <div class="widget-content">
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control" style="margin-top: 25px">
                                                        {!! Form::label('Temperature','Temperature:') !!}
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
                                                                {!! Form::text('',null,['class'=>'form-control fahrenheit']) !!}
                                                            </div>
                                                            <div class="col-xs-6">
                                                                {!! Form::text('Temperature',null,['class'=>'form-control celsius']) !!}
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
                                                                {!! Form::text('Temperature',null,['class'=>'form-control celsius']) !!}
                                                            </div>
                                                            <div class="col-xs-6">
                                                                {!! Form::text('',null,['class'=>'form-control fahrenheit']) !!}
                                                            </div>
                                                        </div>
                                                        @endif
                                                        <label class="error help-block" for="BirthWeight" generated="true" style="display: none;"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('nicu_abdomen','Abdomen:') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::select('nicu_abdomen',[''=>'N/A','Normal'=>'Normal','Scaphoid'=>'Scaphoid','Distended'=>'Distended'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('Abdomen')]) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('nicu_bowel_sounds','Bowel Sounds:') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::select('nicu_bowel_sounds',[''=>'N/A','Normal'=>"Normal","Increased"=>"Increased","Decreased"=>"Decreased","Absent"=>"Absent"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('BowelSounds')]) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('nicu_umbilicus','Umbilicus:') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::select('nicu_umbilicus',[''=>'N/A','Healthy' => "Healthy","Possible infection"=>"Possible infection","Omphalitis"=>"Omphalitis","Omphalocele"=>"Omphalocele","Gastroschisis"=>"Gastroschisis","Hernia"=>"Hernia",'Meconium Stained' => 'Meconium Stained','Large' => 'Large','Shrivelled' => 'Shrivelled'],null,['class'=>'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('nicu_hepatomegaly','Hepatomegaly:') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::select('nicu_hepatomegaly',[''=>'N/A','No' => "No","Yes"=>"Yes"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('nicu_splenomegaly','Splenomegaly:') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::select('nicu_splenomegaly',[''=>'N/A','No' =>"No","Yes"=>"Yes"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('nicu_herina','Hernia:') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::select('nicu_herina',[''=>'N/A','No hernia' => "No hernia","Right Inguinal hernia"=>"Right Inguinal hernia","Left Inguinal hernia"=>"Left Inguinal hernia","Umbilical/para umbilical hernia"=>"Umbilical/para umbilical hernia","Obstructed/strangulated"=>"Obstructed/strangulated"],null,['class'=>'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('nicu_genitalia','Genitalia:') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::select('nicu_genitalia',ValuelistHelpers::getGentila(),null,['class'=>'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('nicu_genitalia_findings', 'Genitalia Findings:') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::text('nicu_genitalia_findings',null,['class'=>'form-control'])!!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('nicu_pupils','Pupils:') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::select('nicu_pupils',ValuelistHelpers::getPupils(),null,['class'=>'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('nicu_pupils_findings','Pupils Findings:') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::text('nicu_pupils_findings',null,['class'=>'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control mt-0">
                                                        {!! Form::label('nicu_anteriorfontanelle','Anterior Fontanelle:') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::select('nicu_anteriorfontanelle',[''=>'N/A','Normal' =>"Normal","Depressed"=>"Depressed","Bulging"=>"Bulging"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('AnteriorFontanelle')]) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('nicu_activity','Activity:') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::select('nicu_activity',[''=>'N/A',"Normal" =>"Normal","Comatosed"=>"Comatosed","Decreased"=>"Decreased","Increased"=>"Increased","Irritable"=>"Irritable","Sedated/Paralysed"=>"Sedated/Paralysed"],null,['class'=>'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('Tone','Tone') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::select('Tone',[''=>'N/A','Normal' =>"Normal","Hypotonia"=>"Hypotonia","Hypertonia"=>"Hypertonia","Sedated/Paralysed"=>"Sedated/Paralysed"],null,['class'=>'form-control'])!!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('nicu_cry','Cry:') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::select('nicu_cry',ValuelistHelpers::cryValues(),null,['class'=>'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('nicu_seizures','Seizures:') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::select('nicu_seizures',[''=>'N/A','No' =>"No","Yes"=>"Yes"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('nicu_neonatalreflexes','Neonatal Reflexes:') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::select('nicu_neonatalreflexes',[''=>'N/A','Normal' =>"Normal","Suppressed"=>"Suppressed","Absent"=>"Absent","Exaggerated"=>"Exaggerated","Sedated/Paralysed"=>"Sedated/Paralysed"],null,['class'=>'form-control']) !!}
                                                    </div>
                                                </div>
                                    <!--   <div class="form-group row">
                                        {!! Form::label('Skin','Skin:') !!}
                                        {!! Form::text('Skin',null,['class'=>'form-control']) !!}
                                    </div> -->
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('Abnormalities','Additional Examination Findings:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::textarea('Abnormalities',null,['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('InitialBloodGas','Initial Blood Gas:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!!
                                                Form::select('InitialBloodGas',['Not done'=>'Not done','Not indicated'=>'Not indicated','Arterial'=>'Arterial','Venous'=>'Venous','Capillary'=>'Capillary'],null,['class'=>'form-control'])
                                                !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('AgeTaken','Age in hours at the time of blood gas:') !!}
                                            </div>
                                           <!--  <div class="col-md-9 custom-input">
                                                {!! Form::text('AgeTaken',null,['class'=>'form-control']) !!}
                                            </div> -->
                                            <div class="col-md-9 custom-input clear-xs">
                                                <!-- {!! Form::text('AgeTaken',null,['class'=>'form-control', 'onkeypress' => 'return ISNumber(event, this);']) !!} -->
                                                <div class="row">
                                                    <div class="col-xs-6 text-center">
                                                        <small>(Hours)</small>
                                                    </div>
                                                    <div class="col-xs-6 text-center">
                                                        <small>(Minutes)</small>
                                                    </div>
                                                    <div class="col-xs-6">
                                                        {!! Form::select('age_hours',['0'=>'00']+$admission['time'],null,['class'=>'form-control ']) !!}
                                                    </div>
                                                    <div class="col-xs-6">
                                                        {!! Form::select('age_mins',$admission['mins'],null,['class'=>'form-control ']) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('SpO2','SpO2 (%):') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::text('SpO2',null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('pH','pH:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::text('pH',null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('lab_lactate','Lactate:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::text('lab_lactate',null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('PaO2','PaO2:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::text('PaO2',null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('PaCo2','PaCo2:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::text('PaCo2',null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('HCO3','HCO3:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::text('HCO3',null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('BE','BE:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::text('BE',null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('RBS','RBS (mg/dl):') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::text('RBS',null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('Hct','Hct:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::text('Hct',null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-sm-12">
                                <div class="widget box mt-10">
                                    <div class="widget-header">
                                        <h4><i class="fa fa-reorder"></i>Initial assessment completed at:</h4>
                                    </div>
                                    <div class="widget-content">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group row" style="margin-top: 20px;">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('initial_assessment_completed_date','Date:', ['class'=>'required-label']) !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        {!! Form::text('initial_assessment_completed_date',null,['class'=>'form-control datepicker','readonly']) !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                                        {!! Form::label('initial_assessment_completed_time','Time:', ['class'=>'required-label']) !!}
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
                                                            <div class="col-xs-4">
                                                                {!! Form::select('initial_assessment_completed_hr',$admission['time'],null,['class'=>'form-control input-width-small']) !!}
                                                            </div>
                                                            <div class="col-xs-4">
                                                                {!! Form::select('initial_assessment_completed_min',$admission['mins'],null,['class'=>'form-control input-width-small']) !!}
                                                            </div>
                                                            <div class="col-xs-4">
                                                                {!! Form::select('initial_assessment_completed_session',['AM'=>'AM','PM'=>'PM'],null,['class'=>'form-control input-width-small']) !!}
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
                        <!-- Procedure Form-->
                        <div role="tabpanel" class="tab-pane @if($active == 'Proform') active @endif" id="Proform">
                            <div class="col-md-6 col-sm-6">
                                <div class="widget box mt-10">
                                    <div class="widget-header">
                                        <h4><i class="fa fa-reorder"></i> </h4>
                                    </div>
                                    <div class="widget-content">
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('InitialXray','Initial X ray:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('InitialXray',['Not done' => 'Not done','Not indicated' =>'Not indicated','Performed'=> 'Performed'],null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('xrayfindings','Chest X ray findings:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::text('xrayfindings',null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-0">
                                                {!! Form::label('AgeofCXR','Abdominal X Ray findings:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::text('AgeofCXR',null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('UAC','UAC:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <input id="UAC" name="UAC" data-on="Yes" data-off="No" checked data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('UACPosition','UACPosition:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::text('UACPosition',null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('UVC','UVC:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <input id="UVC" name="UVC" data-on="Yes" data-off="No" checked data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('UVCPosition','UVCPosition:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::text('UVCPosition',null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="widget box mt-10">
                                    <div class="widget-header">
                                        <h4><i class="fa fa-reorder"></i> </h4>
                                    </div>
                                    <div class="widget-content">
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('SepsisScreen','SepsisScreen:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('SepsisScreen',[''=>'N/A','Yes'=>'Yes','No'=>'No'],null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('Indications','Indications:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::text('Indications',null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="hidden">
                                            {!! Form::select('IVAntibiotic',[''=>'N/A']+ValuelistHelpers::getDrugIvFluidsAntibiotic(),null,['class'=>'form-control  input-width-large']) !!}
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('IVAntibiotic','IV Antibiotic:') !!}
                                                <a href="javascript:void(0)" class="add_master_data" data-modal_header="Drugs & Iv Fluids" data-destination_elements="IVAntibiotic,IVAntibiotic[]" data-option_value="id" data-option_text="generic_pharmacological_name" data-mas_table="mas_drugivfluid" data-drug_type="antibiotic">
                                                    <i class="fa fa-info-circle bs-tooltip" data-placement="right" data-original-title="Add Drugs & Iv Fluids"></i>
                                                </a>
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <table class="IVAntibiotic table table-add-more">
                                                    <thead>                                    
                                                        <tr class="master-add-header">
                                                            <th class="full-width">
                                                                <i class="fa fa-reorder"></i>Add More
                                                            </th>
                                                            <th>
                                                                <span>
                                                                    <a class="btn btn-success btn-view ivantibitic_add btn_add" href="javascript:void(0);">
                                                                        <i class="fa fa-plus"></i>
                                                                    </a>
                                                                </span>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="full-width">{!! Form::select('IVAntibiotic[]',[''=>'N/A']+ValuelistHelpers::getDrugIvFluidsAntibiotic(),'',['class'=>'form-control full-width']) !!}</td>
                                                            <td>
                                                                <span class="fa fa-trash btn btn-danger btn-view remove-neon"></span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('investigations_test','Investigations:') !!}
                                                <a href="javascript:void(0)" class="add_master_data" data-modal_header="Investigations" data-destination_elements="investigations_test" data-option_value="id" data-option_text="package_name" data-mas_table="mas_investigations_package">
                                                    <i class="fa fa-info-circle bs-tooltip" data-placement="right" data-original-title="Add Investigations"></i>
                                                </a>
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('investigations_test', ValuelistHelpers::get_package_investigations_master(), null,['class'=>'select2-select-00 full-width','multiple']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('Investigations','Test:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::hidden('investigation_order', null) !!}
                                                {!! Form::textarea('Investigations', null,['class'=>'form-control', 'rows'=>3]) !!}                                        
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('NBM','Enteral Feeding:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('NBM',[''=>'N/A','Yes'=>'Yes','No'=>'No'],null,['class'=>'form-control ']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-0">
                                                {!! Form::label('Fluids','Fluids/Feeds ml/kg/d:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::text('Fluids',null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- CRIB FORM -->
                        <div role="tabpanel" class="tab-pane @if($active == 'Cribform') active @endif" id="Cribform">
                            <div class="col-md-6 col-sm-6">
                                <div class="widget box mt-10">
                                    <div class="widget-header">
                                        <h4><i class="fa fa-reorder"></i> </h4>
                                    </div>
                                    <div class="widget-content">
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-0">
                                                {!! Form::label('SexBirthWtGestation','Sex,Birth Wt & Gestation:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::text('SexBirthWtGestation',null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                    <!-- <div class="form-group row">
                                        <div class="col-md-3 text-right label-control mt-0">
                                            {!! Form::label('TemperatureAtAdmission','Temperature At Admission:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::text('TemperatureAtAdmission',null,['class'=>'form-control']) !!}
                                        </div>
                                    </div> -->
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control" style="margin-top: 25px">
                                            {!! Form::label('TemperatureAtAdmission','Temperature At Admission:') !!}
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
                                                    {!! Form::text('',null,['class'=>'form-control fahrenheit']) !!}
                                                </div>
                                                <div class="col-xs-6">
                                                    {!! Form::text('TemperatureAtAdmission',null,['class'=>'form-control celsius celsius-type-2']) !!}
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
                                                    {!! Form::text('TemperatureAtAdmission',null,['class'=>'form-control celsius celsius-type-2']) !!}
                                                </div>
                                                <div class="col-xs-6">
                                                    {!! Form::text('',null,['class'=>'form-control fahrenheit']) !!}
                                                </div>
                                            </div>
                                            @endif
                                            <label class="error help-block" for="BirthWeight" generated="true" style="display: none;"></label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('BaseExcess','Base Excess:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::text('BaseExcess',null,['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control mt-0">
                                            {!! Form::label('TotalCRIB2Score','Total CRIB II Score:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::text('TotalCRIB2Score',null,['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="widget box mt-10">
                                <div class="widget-header">
                                    <h4><i class="fa fa-reorder"></i> </h4>
                                </div>
                                <div class="widget-content">
                                    <img src='{{ url("public/img/crib11.png") }}'/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--  SNAPPE II -->
                    <div role="tabpanel" class="tab-pane @if($active == 'Snapform') active @endif" id="Snapform">
                        <div class="col-md-6 col-sm-6">
                            <div class="widget box mt-10">
                                <div class="widget-header">
                                    <h4><i class="fa fa-reorder"></i> </h4>
                                </div>
                                <div class="widget-content">
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('MBP','MBP:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::select('MBP',[''=>'N/A','0'=>'0','9'=>'9','19'=>'19'],'',['class'=>'form-control GetSNAP2Score GetSNAPPE2Score']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control mt-0">
                                            {!! Form::label('LowestTemperature','Lowest Temperature:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::select('LowestTemperature',[''=>'N/A','0'=>'0','8'=>'8','15'=>'15'],'',['class'=>'form-control GetSNAP2Score GetSNAPPE2Score']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('Po2Fio2Ratio','Po2 Fio2 Ratio:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::select('Po2Fio2Ratio',[''=>'N/A','0'=>'0','5'=>'5','16'=>'16','28'=>'28'],'',['class'=>'form-control GetSNAP2Score GetSNAPPE2Score']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('LowestSerumPh','Lowest Serum Ph:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::select('LowestSerumPh',[''=>'N/A','0'=>'0','7'=>'7','16'=>'16'],'',['class'=>'form-control GetSNAP2Score GetSNAPPE2Score']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('MultipleSeizures','Multiple Seizures:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::select('MultipleSeizures',[''=>'N/A','0'=>'0','19'=>'19'],'',['class'=>'form-control GetSNAP2Score GetSNAPPE2Score']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('UrineOutput','Urine Output:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::select('UrineOutput',[''=>'N/A','0'=>'0','5'=>'5','18'=>'18'],'',['class'=>'form-control GetSNAP2Score GetSNAPPE2Score']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('BWeight','Birth Weight:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::select('BWeight',[''=>'N/A','0'=>'0','10'=>'10','17'=>'17'],'',['class'=>'form-control GetSNAPPE2Score']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control mt-0">
                                            {!! Form::label('SgaLessThan3rdPercentile','Small for Gestational Age:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::select('SgaLessThan3rdPercentile',[''=>'N/A','0'=>'0','12'=>'12'],'',['class'=>'form-control GetSNAPPE2Score']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('Apgar5Mins','Apgar5Mins:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::select('Apgar5Mins',[''=>'N/A','0'=>'0','18'=>'18'],'',['class'=>'form-control GetSNAPPE2Score']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control mt-0">
                                            {!! Form::label('TotalSNAP2Score','Total SNAP II Score:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::text('TotalSNAP2Score',null,['class'=>'form-control', 'readonly']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control mt-0">
                                            {!! Form::label('TotalSNAPPE2Score','Total SNAPPE II Score:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::text('TotalSNAPPE2Score',null,['class'=>'form-control', 'readonly']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="widget box mt-10">
                                <div class="widget-header">
                                    <h4><i class="fa fa-reorder"></i> </h4>
                                </div>
                                <div class="widget-content">
                                    <img src='{{ url("public/img/snapII.png") }}'/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Diagnosis -->
                    <div role="tabpanel" class="tab-pane @if($active == 'Diagform') active @endif" id="Diagform">
                        <div class="col-md-12 ">
                            <div class="form-group row mx-0">
                                <div class="mt-10 widget box col-md-12">
                                    <div class="widget-header">
                                        <h4><i class="fa fa-reorder"></i> Differential Diagnosis Details</h4>
                                    </div>
                                    <div class="widget-content form-group row mx-0">
                                        <div class="col-md-2 text-right label-control">
                                            {!! Form::label('DifferentialDiagnosis','Differential Diagnosis:') !!}
                                        </div>
                                        <div class="col-md-10 custom-input">
                                            {!! Form::Select('DifferentialDiagnosis[]',$ICD,null,['class'=>'select2-select-00 full-width-fix','multiple']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="widget box mt-10">
                                <div class="widget-header">
                                    <h4><i class="fa fa-reorder"></i> </h4>
                                </div>
                                <div class="widget-content">
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('additional_diagnosis','Additional Diagnosis:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <table class="additional_diagnosis table table-add-more full-width-fix">
                                                <thead>                                    
                                                    <tr class="master-add-header">
                                                        <th class="full-width">
                                                            <i class="fa fa-reorder"></i>Add More
                                                        </th>
                                                        <th>
                                                            <a class="btn btn-success btn-view additional_diagnosis_add btn_add" href="javascript:void(0);">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="full-width">
                                                            {!! Form::text('additional_diagnosis[]','',['class'=>'form-control full-width']) !!}
                                                        </td>
                                                        <td>
                                                            <span class="fa fa-trash btn btn-danger btn-view remove-neon"></span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table> 
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('Plan','Plan:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::textarea('Plan',null,['class'=>'form-control','rows'=>5]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('ParentsSpokenTo','Parents Spoken To:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <input id="ParentsSpokenTo" name="ParentsSpokenTo" data-on="Yes" data-off="No" checked data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control" style="margin-top: 20px;">
                                            {!! Form::label('DiscussionTime','Time of Discussion:') !!}
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
                                                <div class="col-xs-4">
                                                    {!! Form::select('TimeOfDiscussion',$NAT['time'],null,['class'=>'form-control']) !!}
                                                </div>
                                                <div class="col-xs-4">
                                                    {!! Form::select('TimeOfDiscussion_MINS',$NAT['mins'],null,['class'=>'form-control']) !!}
                                                </div>
                                                <div class="col-xs-4">
                                                    {!! Form::select('TimeOfDiscussion_AM',[''=>'N/A','AM'=>'AM','PM'=>'PM'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('MattersDiscussed','Matters Discussed:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::textarea('MattersDiscussed',null,['class'=>'form-control','rows'=>5]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('ParentsAddressedBy','Parents Addressed By:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::text('ParentsAddressedBy',null,['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="widget box mt-10">
                                <div class="widget-header">
                                    <h4><i class="fa fa-reorder"></i> </h4>
                                </div>
                                <div class="widget-content">
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('indication_of_admission','Indication For Admission:') !!}
                                            @php $indication_of_admission1 =  $indication_of_admission2 =  $indication_of_admission3 =  $indication_of_admission4 = $indication_of_admission5 = $indication_of_admission6 = $indication_of_admission7 =  false  @endphp
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <div>
                                                {!! Form::checkbox('indication_of_admission[]',1,$indication_of_admission1) !!}
                                                {!! Form::label('Prematurity','Prematurity',['class'=>'title']) !!}
                                            </div>
                                            <div>
                                                {!! Form::checkbox('indication_of_admission[]',2,$indication_of_admission2) !!}
                                                {!! Form::label('Low birth weight','Low birth weight',['class'=>'title']) !!}
                                            </div>
                                            <div>
                                                {!! Form::checkbox('indication_of_admission[]',3,$indication_of_admission3) !!}
                                                {!! Form::label('RD','Respiratory Distress',['class'=>'title']) !!}
                                            </div>
                                            <div>
                                                {!! Form::checkbox('indication_of_admission[]',4,$indication_of_admission4) !!}
                                                {!! Form::label('Delayed Perinatal','Delayed Perinatal',['class'=>'title']) !!}
                                            </div>
                                            <div>
                                                {!! Form::checkbox('indication_of_admission[]',5,$indication_of_admission5) !!}
                                                {!! Form::label('Sepsis','Sepsis',['class'=>'title']) !!}
                                            </div>
                                            <div>
                                                {!! Form::checkbox('indication_of_admission[]',6,$indication_of_admission6) !!}
                                                {!! Form::label('Shock','Shock',['class'=>'title']) !!}
                                            </div>
                                            <div>
                                                {!! Form::checkbox('indication_of_admission[]',7,$indication_of_admission7) !!}
                                                {!! Form::label('Jaundice','Jaundice',['class'=>'title']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('indication_of_admission_other','Others (specify):') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::text('indication_of_admission_other',null,['class'=>'form-control shadow']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- NewBorn Examination -->
                    <div class="col-md-11 col-sm-12">
                        <input type="hidden" name="print_flag" value="0" id="print_flag"/>
                        @if(!Session::has('registration_start'))
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <button type="submit" class="btn btn-primary save-button-shadow btn-block form-control nicu_admission_create">
                                <i class="fa fa-floppy-o"></i> 
                                <span>{!! $SubmitButtonText !!}</span>
                            </button>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <button type="button" class="btn btn-block save-button-shadow btn-info form-control nicu_admission_create" data-flag="2"> <i class="fa fa-floppy-o"></i>
                                <span>Save</span>
                            </button>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <button type="button" class="btn btn-block save-button-shadow btn-info form-control nicu_admission_create" data-flag="1"><i class="fa fa-print"></i>
                                <span>Print</span>
                            </button>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <a href="{{ action('Admission\NicuController@index') }}" class="btn btn-default save-button-shadow btn-block form-control" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> 
                                <span>Cancel</span>
                            </a>
                        </div>
                        @else
                        <div class="col-md-3 col-sm-4 col-xs-12">
                            {{-- <button type="button" class="btn btn-block save-next save-button-shadow btn-info form-control nicu_admission_create" onclick="$('#print_flag').val('2'); $('#neonatalPerforma-form').submit();"> <i class="fa fa-floppy-o"></i> --}}
                            <button type="button" class="btn btn-block save-next save-button-shadow btn-info form-control nicu_admission_create" data-flag="2"> <i class="fa fa-floppy-o"></i>
                                <span>Next</span>
                            </button>
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12">
                            <a href="{{ action('Admission\NicuController@index') }}" class="btn btn-default save-button-shadow btn-block form-control" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> 
                                <span>Cancel</span>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    @endsection
    @section('scripts')
    <script type="text/javascript">
        function calculateAgeonAdmissionHour() {

          var admissionDate    = $('input[name="AdmissionDate"]').val();
          console.log(admissionDate);
          var admissionTime    = $('select[name="AdmissionTime"]').val();
          var admissionMins    = $('select[name="AdmissionTime_MINS"]').val();
          var admissionSession = $('select[name="AdmissionTime_AM"]').val();
          var babyId = $('input[name="BabyId"]').val();

          $.ajax({
           Type:'GET',
           url :'{{ action("Admission\NicuController@getageonadmission") }}',
           data:{babyId:babyId, admissionDate:admissionDate, admissionTime:admissionTime, admissionMins:admissionMins , admissionSession:admissionSession },
           success: function(responseText) {
            console.log(responseText)
            if (responseText.age_on_admission < 96) {
                $('#AgeOnAdmissionhour').val(responseText.age_on_admission);
                $('.age_on_admission_hours').show();
                $('.age_on_admission_days').hide();
            }
            else
            {
                $('.age_on_admission_hours').hide();
                $('.age_on_admission_days').show();
            }
        },
        error:function(responseText) {

        }


    })

      }   

      $("form").sisyphus({customKeySuffix: "nicu", locationBased: true });

      $('.nav-tabs li a').click(function() {
        if ($("#admissionProforma-form").valid() === false) {
            $("#admissionProforma-form").valid();
            return false;
        }
        $.cookie('nicuform', $(this).attr('aria-controls'), { path: '/' });
        @if(Session::has('registration_start'))
        moveNext($(this).attr('aria-controls'));
        @endif
    });

      @if(Session::has('registration_start'))

      function moveNext(menuActive) {
       $.cookie('nicuform', menuActive, { path: '/' });

       if (menuActive == 'Diagform' || menuActive =='Checkform') {
          $('input[name="print_flag"]').val(0);

          $('.save-next > span').text('Finish');

      } else {
          $('input[name="print_flag"]').val(2);

          $('.save-next > span').text('Next');
      }
  }

  $('.save-next').click(function() {
    var menuActive = $('.nav-tabs li[class="active"]').next('li').children('a').attr('aria-controls');
    moveNext(menuActive);
    // $('#admissionProforma-form').submit();
});

  @endif

$('#ROPTreatment').on('change', function () {
    if ($("#ROPTreatment").val() == 'No' || $("#ROPTreatment").val() == 'Not performed' || $("#ROPTreatment").val() == 'Not indicated') {
        $("#TypeofTreatmenDiv").css("display", "none");
    } else {
        $("#TypeofTreatmenDiv").css("display", "block");
    }
});

$('#Pip').keyup(function () {
    this.value = this.value.replace(/[^0-9]/g, '');
});

$('.ward-name, .room-name').change(function() {

    var uri  = "{{ url('baby-bed-details') }}";
    var id   = $(this).val();
    var name = $(this).attr('name');
    var slug;
    var destinationName;

    if (name == 'ward_name') {

       slug            = 'ROOMLIST';
       destinationName = 'room_no';

   } else if(name =='room_no') {

       slug = 'BEDLIST';
       destinationName = 'bed_no';

   }


   $.ajax({
      type    :"GET",
      url     :uri+'/'+id+'/'+slug,
      success : function(response) {

          var wardOption = '<option value="">N/A</option>';
          $.each(response.results, function(index, value) {
              wardOption += '<option value="'+value.id+'">'+value.name+'</option>';
          });

          $('select[name="'+destinationName+'"]').html(wardOption);
      },
      complete: function(response) {

      }
  });


});

calculateAgeonadmission();

function calculateAgeonAdmissionHour() {
  var admissionDate    = $('input[name="AdmissionDate"]').val();
  var admissionTime    = $('select[name="AdmissionTime"]').val();
  var admissionMins    = $('select[name="AdmissionTime_MINS"]').val();
  var admissionSession = $('select[name="AdmissionTime_AM"]').val();
  var babyId = $('input[name="BabyId"]').val();

  $.ajax({
   Type:'GET',
   url :'{{ action("Admission\NicuController@getageonadmission") }}',
   data:{babyId:babyId, admissionDate:admissionDate, admissionTime:admissionTime, admissionMins:admissionMins , admissionSession:admissionSession },
   success: function(responseText) {

    if (responseText.age_on_admission < 96) {
        $('#AgeOnAdmissionhour').val(responseText.age_on_admission);
        $('.age_on_admission_hours').show();
        $('.age_on_admission_days').hide();
    }
    else
    {
        $('.age_on_admission_hours').hide();
        $('.age_on_admission_days').show();
    }
},
error:function(responseText) {

}


})

}
calculateAgeonAdmissionHour();
// $(document).on('click', '.nicu_admission_create', function(e)
// {
//     e.preventDefault();
//     if ($('#admissionProforma-form').valid() === true) {
//       var print_flag = $(this).data('flag');
//       $('#print_flag').val(print_flag);
//       $('.nicu_admission_create').prop('disabled', true);

//       $(this).html('<i class="fas fa-spinner fa-pulse"></i> Loading...');
//       $('#admissionProforma-form').submit();
//     }
// });
$(document).on('click', '.nicu_admission_create', function(e){
    if ($('#admissionProforma-form').valid() === true) {
        e.preventDefault();
        var print_flag = $(this).data('flag');
        $('#print_flag').val(print_flag);
        $('.nicu_admission_create').prop('disabled', true);
        var current_clicked_html = $(this).html();
        var current_clicked_element = $(this);
        $(this).html('<i class="fas fa-spinner fa-pulse"></i> Loading...');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            data: $('#admissionProforma-form input, #admissionProforma-form select, #admissionProforma-form textarea').serialize(),
            url: "{{ action('Admission\NicuController@store') }}",
            success: function (response) {
                if (print_flag == 1) {
                    Showalert('success', 'NICU admission created successfully');
                    window.location.href = response.print_url;
                }
                else if(print_flag == 2)
                {
                    Showalert('success', 'NICU admission created successfully');
                    window.location.href = response.edit_url;
                }
                else
                {
                    Showalert('success', 'NICU admission created successfully');
                    window.location.href = response.list_url; 
                }
            },
            error: function()
            {
                Showalert('error', 'Something went wrong, Please try again later...!');
                $('.nicu_admission_create').prop('disabled', false);
                current_clicked_element.html(current_clicked_html);
            }
        });
    }
});  
</script>
@include('admission.nicu.nicu_scripts')
<script type="text/javascript">
    calculateCorrectedGestation();
</script>
@endsection
