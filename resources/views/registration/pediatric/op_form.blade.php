<?php 
$site_url = url('/').'/public';
?>
<style type="text/css">
    #suggestion-box-modal .modal-body > div {
        margin: 15px auto;
    }
    #suggestion-box-modal .modal-body > div table td {
        font-size: 12px;
    }
    .table-bordered {
        border: 0px;
    }
    #suggestion-box-modal .modal-body table thead th {
        position: sticky;
        top: 0px;
        background: #1e1e2d;
        color: white;
    } 
    .custom-input > div.tinymce-body {
        border: 1px solid #CCCCCC !important;
        min-height: 100px;
        border-radius: 0px !important;
        padding: 5px;
        background-color: white;
        overflow: auto;
        max-height: 500px;
    }
    .custom-input > div.tinymce-body:focus {
        border-color: #4d7496 !important;
    }
    .tox .tox-tbtn {
        width: auto;
    }
    .tox button[title="Font sizes"].tox-tbtn--select {
        width: 75px;
    }
    .tox button[title="Blocks"].tox-tbtn--select {
        width: 75px;
    }
    .tox .tox-toolbar, .tox .tox-toolbar__overflow, .tox .tox-toolbar__primary {
        background-color: #efead2;
    }
</style>

{!! Form::hidden('baby_id',@$baby_detail->BabyId) !!}
{!! Form::hidden('BabyId',@$baby_detail->BabyId) !!}
{!! Form::hidden('mother_id',@$baby_detail->MotherId) !!}

{!! Form::hidden('parter_name') !!}
{!! Form::hidden('mobile') !!}
{!! Form::hidden('phone') !!}
{!! Form::hidden('address1') !!}
{!! Form::hidden('address2') !!}
{!! Form::hidden('address3') !!}
{!! Form::hidden('city') !!}
{!! Form::hidden('pincode') !!}

{!! Form::hidden('visit_type', 'OP', ['id'=>'visit_type']) !!}
{!! Form::hidden('visit_module_name', 'pediatric_op') !!}
{!! Form::hidden('visit_number') !!}
<div class="col-md-12">        
    <div class="form-group row">
        <div class="col-md-3 col-md-2 text-right label-control">
            {!! Form::label('mrno','Baby\'s '.Lang::get('home.mrn').'.:') !!}
        </div>
        <div class="col-md-9 col-sm-12 custom-input">
            <div class="col-md-7 col-sm-8">
                {!! Form::text('mrno',@$baby_detail->BMrNo,['class'=>'form-control']) !!}
                <span id="mrn_no_error" style="display: none; color: red"></span>
            </div>
            @if((!isset($baby_detail->BMrNo) && empty($baby_detail->BMrNo)) || $id == 0)
            <div class="col-md-5 col-sm-4">
                <a class="btn btn-primary btn-basic-shadow" id="search-baby-by-mr" disabled="true">
                    <i class="fa fa-search"></i> <span>Search</span>
                </a>
                <a class="btn btn-warning btn-basic-shadow" id="generate-mrn" data-mrn-field="mrno" data-form-id="pediatric-op-form" title="{{Lang::get('home.mrn_generate_btn_title')}}">
                    <img src="{{$site_url}}/img/saraswathi_logo.png"> <span>{{Lang::get('home.mrn_generate_btn')}}</span>
                </a>           
                <br>
                <label id="search_mrn_no_error" style="display: none; color: red"></label>       
            </div>
            @endif
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
                    {!! Form::label('op_date','OP Date:', ['class'=>'required-label']) !!}
                </div>
                <div class="col-md-9 custom-input">
                    @php $current_date = isset($baby_detail->op_date) ? date('d-m-Y', strtotime($baby_detail->op_date)) : $current_date; @endphp
                    {!! Form::text('op_date',$current_date,['class'=>'form-control admission-date record-date','readonly'=>'true']) !!}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                    {!! Form::label('OpTime','OP Time:') !!}
                </div>
                <div class="col-md-9 custom-input clear-xs">
                    <div class="row">
                        <div class="col-xs-4">
                            <small>(Hour)</small>
                        </div>
                        <div class="col-xs-4">
                            <small>(Minute)</small>
                        </div>
                        <div class="col-xs-4">
                            <small>(Session)</small>
                        </div>
                        <div class="col-xs-4">
                            {!! Form::select('op_hours',$time['time'],@$current_time['hours'],['class'=>'form-control input-width-small']) !!}
                        </div>
                        <div class="col-xs-4">
                            {!! Form::select('op_mins',$time['mins'],@$current_time['mins'],['class'=>'form-control input-width-small']) !!}
                        </div>
                        <div class="col-xs-4">
                            {!! Form::select('op_session',$time['session'],@$current_time['am'],['class'=>'form-control input-width-small']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3 text-right label-control">
                    {!! Form::label('BabyName','Baby Name:', ['class'=>'required-label']) !!}
                </div>
                <div class="col-md-9 custom-input">
                    {!! Form::text('BabyName',@$baby_detail->BabyName,['class'=>'form-control']) !!}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3 text-right label-control">
                    {!! Form::label('mother_name','Mother Name:', ['class'=>'required-label']) !!}
                </div>
                <div class="col-md-9 custom-input">
                    {!! Form::text('mother_name',@$baby_detail->MotherName,['class'=>'form-control']) !!}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3 text-right label-control">
                    {!! Form::label('DOB','DOB:', ['class'=>'required-label']) !!}
                </div>
                <div class="col-md-9 custom-input">
                    @php $dob = isset($baby_detail->DOB) ? date('d-m-Y', strtotime($baby_detail->DOB)) : null; @endphp
                    {!! Form::text('DOB',$dob,['class'=>'form-control baby-dob-format birth-date', 'readonly']) !!}
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
            <div class="form-group row">
                <div class="col-md-3 text-right label-control">
                    {!! Form::label('Sex','Sex:') !!}
                </div>
                <div class="col-md-9 custom-input">
                    {!! Form::select('Sex',[''=>'Select','Male'=>'Male','Female'=>'Female','Indeterminate'=>'Indeterminate'],@$baby_detail->Sex,['class'=>'form-control']) !!}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                    {!! Form::label('CurrentWeight','Current Weight:') !!}
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
                            {!! Form::text('current_weight_kgs',@$baby_detail->current_weight/1000,['class'=>'form-control growth-weight', 'id'=>'current_weight_kgs']) !!}
                        </div>
                        <div class="col-xs-6">
                            {!! Form::text('current_weight',null,['class'=>'form-control', 'id' => 'current_weight']) !!}
                            <label for="CurrentWeight" generated="true" class="error help-block"></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3 text-right label-control mt-0">
                    {!! Form::label('current_ofc','Head Circumference (cm):') !!}
                </div>
                <div class="col-md-9 custom-input">
                    {!! Form::text('current_ofc',null,['class'=>'form-control']) !!}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3 text-right label-control mt-0">
                    {!! Form::label('current_length','Length / Height (cm) :') !!}
                </div>
                <div class="col-md-9 custom-input">
                    {!! Form::text('current_length',null,['class'=>'form-control']) !!}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3 text-right label-control mt-0">
                    {!! Form::label('current_bmi','BMI :') !!}
                </div>
                <div class="col-md-9 custom-input">
                    {!! Form::text('current_bmi',null,['class'=>'form-control', 'id'=>'current_bmi']) !!}
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
            <div class="form-group row">
                <div class="col-md-3 text-right label-control">
                    {!! Form::label('seen_by','Seen By:', ['class'=>'required-label']) !!}
                </div>
                <div class="col-md-9 custom-input">
                    {!! Form::select('seen_by',[''=>'N/A']+ValuelistHelpers::mas_doctors_list(),null,['class'=>'form-control']) !!}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                    {!! Form::label('review','Review SOS:') !!}
                </div>
                <div class="col-md-9 custom-input clear-xs">
                    <div class="row">
                        <div class="col-xs-3 pr-0">
                            <small>(Date)</small>
                        </div>
                        <div class="col-xs-3">
                            <small>(Days)</small>
                        </div>
                        <div class="col-xs-6 plr-0">
                            <small>(Time)</small>
                        </div>
                        <div class="col-xs-3 pr-0">
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
            </div>
            <div class="form-group row">
                <div class="col-md-3 text-right label-control mt-0">
                    {!! Form::label('allegries','Allergies :') !!}
                </div>
                <div class="col-md-9 custom-input">
                    {!! Form::text('allegries',@$baby_detail->allegries,['class'=>'form-control']) !!}
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
                    {!! Form::label('current_status','Presenting complaints:') !!}
                </div>
                <div class="col-md-9 custom-input">
                    <div id="current_status" class="tinymce-body">
                        {!! @$baby_detail->current_status !!}
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
                    {!! Form::label('immunization_content','Immunization:') !!}
                </div>
                <div class="col-md-9 custom-input">
                    <div id="immunization_content" class="tinymce-body">
                        {!! @$baby_detail->immunization_content !!}
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3 text-right label-control">
                    {!! Form::label('examination','Examination:') !!}
                </div>
                <div class="col-md-9 custom-input">
                    <div id="examination" class="tinymce-body">
                        {!! @$baby_detail->examination !!}
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3 text-right label-control">
                    {!! Form::label('impression','Impression:') !!}
                </div>
                <div class="col-md-9 custom-input">
                    <div id="impression" class="tinymce-body">
                        {!! @$baby_detail->impression !!}
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3 text-right label-control">
                    {!! Form::label('advice','Advice:') !!}
                </div>
                <div class="col-md-9 custom-input">
                    <div id="advice" class="tinymce-body">
                        {!! @$baby_detail->advice !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12 col-sm-12 overflow-auto">
    <div class="form-group row">
        <div class="col-md-12 custom-input">
            <h3>Medications
                <a href="javascript:void(0)" class="add_master_data" data-modal_header="Drugs & Iv Fluids" data-destination_elements="temp_drugs,M_Drugs[]" data-option_value="id" data-option_text="brand_name" data-mas_table="mas_drugivfluid" data-drug_type="oral">
                    <i class="fa fa-info-circle bs-tooltip" data-placement="right" data-original-title="Add Drugs & Iv Fluids"></i>
                </a>
            </h3>
            <table class="drugs table table-add-more full-width-fix">
                <thead>
                    <tr class="master-add-header">
                        <th>Drug</th>
                        <th>Generic Name</th>
                        <th>Formulation/Strength</th>
                        <th>Route</th>
                        <th>
                            Dose
                            <a href="javascript:void(0)" class="add_master_data" data-modal_header="Dose" data-destination_elements="temp_does,M_Dose[]" data-option_value="volume" data-option_text="volume" data-mas_table="mas_dose">
                                <i class="fa fa-info-circle bs-tooltip" data-placement="right" data-original-title="Add Dose"></i>
                            </a>
                        </th>
                        <th>
                            Frequency
                            <a href="javascript:void(0)" class="add_master_data" data-modal_header="Frequency" data-destination_elements="temp_frequency,M_Frequency[]" data-option_value="value" data-option_text="name" data-mas_table="mas_frequency">
                                <i class="fa fa-info-circle bs-tooltip" data-placement="right" data-original-title="Add Frequency"></i>
                            </a>
                        </th>
                        <th>Duration</th>
                        <th>
                            <span>
                                <a class="btn btn-success btn-view op_pediatric_drugs_add btn_add" href="javascript:void(0);">
                                    <b>Add Drugs</b> <i class="fa fa-plus"></i>
                                </a>
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php $mas_frequency_list = ValuelistHelpers::drugFrequencyList(); @endphp
                    <div class="hidden">
                        {!! Form::select('temp_drugs',$drug_data,'') !!}
                        {!! Form::select('temp_frequency',$mas_frequency_list,'') !!}
                        {!! Form::select('temp_route',ValuelistHelpers::route(),'') !!}
                        {!! Form::select('temp_does',[''=>'N/A']+ValuelistHelpers::dose(),'') !!}
                        {!! Form::select('temp_duration',[''=>'N/A']+ValuelistHelpers::medicationDuration(),'') !!}                 
                    </div>
                    @if (isset($medications) && (count($medications) > 0))
                    @php 
                    $l = 0; 
                    $medication_ids = json_encode(collect($medications)->pluck('Id')->toArray());
                    $medications = collect($medications)->groupBy('Medication');
                    @endphp
                    @foreach ($medications as $temp_key => $temp_medi_data)
                    @php $standard_medication_id = $l; @endphp
                    @foreach ($temp_medi_data as $key => $medi_data)
                    @php $temp_l = $medi_data['Id']; @endphp
                    <tr data-len="{{$l}}" class="standard_medication_{{$standard_medication_id}}" data-id="{{@$medi_data['Id']}}">
                        <td>
                            <div class="@if($key > 0) hidden @endif">{!! Form::hidden('standard_dose['.$temp_l.']', @$medi_data['standard_dose']) !!}{!! Form::select('M_Drugs['.$temp_l.']',$drug_data,$medi_data['Medication'],['class'=>'drugs-changes1 drug-list-name'.$l,'data-id'=>$l, 'style'=>'min-width:300px;']) !!}</div>
                        </td>
                        <td>
                            <div class="@if($key > 0) hidden @endif">{!! Form::text('m_generic_name['.$temp_l.']',$medi_data['genericname'],['class'=>'form-control generic_name'.$l]) !!}</div>
                        </td>
                        <td>
                            <div class="@if($key > 0) hidden @endif">{!! Form::select('formulation['.$temp_l.']',ValuelistHelpers::formulationStrength($medi_data['formulation']),$medi_data['formulation'],['class'=>'form-control formulation'.$l]) !!}</div>
                        </td>
                        <td class="input-width-medium">
                            <div class="@if($key > 0) hidden @endif">
                                {!! Form::select('M_Route['.$temp_l.']',ValuelistHelpers::route(),@$medi_data['route'],['class'=>'form-control']) !!}
                            </div>
                        </td>
                        <td class="input-width-medium">{!! Form::select('M_Dose['.$temp_l.']',[''=>'N/A']+ValuelistHelpers::dose(),$medi_data['Dose'],['class'=>'form-control']) !!}</td>
                        <td class="input-width-medium">{!! Form::select('M_Frequency['.$temp_l.']',$mas_frequency_list,$medi_data['Frequency'],['class'=>'form-control']) !!}</td>
                        <td class="input-width-medium">{!! Form::select('M_Duration['.$temp_l.']',ValuelistHelpers::medicationDuration(),$medi_data['Duration'],['class'=>'form-control']) !!}</td>
                        <td>
                            @if($key == 0)
                            <a class="btn btn-success standard_dose btn-view btn_add" href="javascript:void(0);" data-addid="{{$standard_medication_id}}">
                                <!-- <i class="fa fa-plus"></i> -->
                                <b>Continue</b>
                            </a>
                            <span class="fa fa-trash btn btn-danger btn-view standard_dose_remove"></span>
                            @else
                            <span class="fa fa-trash btn btn-danger btn-view medication_remove"></span>
                            @endif
                        </td>
                    </tr>
                    @php $l++; @endphp
                    @endforeach  
                    @endforeach  
                    @else
                    <tr data-len="0" class="standard_medication_0">
                        <td>{!! Form::hidden('standard_dose[]', 0) !!}{!! Form::select('M_Drugs[]',$drug_data,null,['class'=>'drugs-changes drug-list-name0','data-id'=>'0', 'style'=>'min-width:300px;']) !!}</td>
                        <td>{!! Form::text('m_generic_name[]',null,['class'=>'form-control generic_name0']) !!}</td>
                        <td>{!! Form::select('formulation[]',[''=>'N/A'],null,['class'=>'form-control formulation0']) !!}</td>
                        <td class="input-width-medium">{!! Form::select('M_Route[]',ValuelistHelpers::route(),null,['class'=>'form-control']) !!}</td>
                        <td class="input-width-medium">{!! Form::select('M_Dose[]',[''=>'N/A']+ValuelistHelpers::dose(),null,['class'=>'form-control']) !!}</td>
                        <td class="input-width-medium">{!! Form::select('M_Frequency[]',$mas_frequency_list,null,['class'=>'form-control']) !!}</td>
                        <td class="input-width-medium">{!! Form::select('M_Duration[]',ValuelistHelpers::medicationDuration(),null,['class'=>'form-control']) !!}</td>
                        <td>
                            <a class="btn btn-success standard_dose btn-view btn_add" href="javascript:void(0);" disabled="true" data-addid="0">
                                <!-- <i class="fa fa-plus"></i> -->
                                <b>Continue</b>
                            </a>
                            <span class="fa fa-trash btn btn-danger btn-view standard_dose_remove"></span>
                        </td>
                    </tr>
                    @endif  
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="col-md-12 col-sm-12 plr-0">
    <div class="col-md-5">
        <div class="form-group row">
            <div class="col-md-3 text-right label-control">
                {!! Form::label('immunization','Immunization:') !!}
            </div>
            <div class="col-md-9 custom-input">
                {!! Form::select('immunization',[''=>'N/A','Due'=>'Due','Given'=>'Given','Complete'=>'Complete'],null,['class'=>'form-control']) !!}
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3 text-right label-control">
                {!! Form::label('schedule','Schedule:') !!}
            </div>
            <div class="col-md-9 custom-input">
                {!! Form::select('schedule',[''=>'N/A','At birth'=>'At birth','6 wks'=>'6 wks','10 wks'=>'10 wks','14 wks'=>'14 wks','6 mths'=>'6 mths','9 mths'=>'9 mths','1 year'=>'1 year','15 mths'=>'15 mths','16-18 mths'=>'16-18 mths','18 mths'=>'18 mths','2 years'=>'2 years','5 years'=>'5 years','10 years'=>'10 years','Optional'=>'Optional','Catch Up'=>'Catch Up'],null,['class'=>'form-control']) !!}
            </div>
        </div>
    </div>
    <div class="hidden">
        {!! Form::select('temp_vaccines',$vaccine,null,['class'=>'form-control']) !!}
    </div>
    <div class="col-md-5">
        <div class="form-group row">
            <div class="col-md-12 custom-input">
                <table class="op_vaccine table table-add-more full-width-fix">
                    <thead>
                        <tr class="master-add-header">
                            <th>
                                {!! Form::label('Vaccine','Vaccine:') !!}
                                <a href="javascript:void(0)" class="add_master_data" data-modal_header="Vaccine" data-destination_elements="temp_vaccines,Vaccine[],vaccine_brand_name[]" data-option_value="Id" data-option_text="Name" data-mas_table="mas_vaccine">
                                    <i class="fa fa-info-circle bs-tooltip" data-placement="right" data-original-title="Add Vaccine"></i>
                                </a>
                            </th>
                            <th>
                                <span>
                                    <a class="btn btn-success btn-view op_vaccine_add btn_add" href="javascript:void(0);">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($baby_detail->vaccine) && is_array($baby_detail->vaccine) && count($baby_detail->vaccine) > 0)
                        @foreach($baby_detail->vaccine as $vaccine_code) 
                        <tr>
                            <td class="full-width">{!! Form::select('Vaccine[]',$vaccine,$vaccine_code,['class'=>'form-control']) !!}</td>
                            <td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>
                        </tr>
                        @endforeach   
                        @else    
                        <tr>
                            <td class="full-width">{!! Form::select('Vaccine[]',$vaccine,null,['class'=>'form-control']) !!}</td>
                            <td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
