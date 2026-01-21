<style type="text/css">    
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
{!! Form::hidden('BabyId',null) !!}
{!! Form::hidden('MotherId',null) !!}
{!! Form::hidden('parter_name') !!}
{!! Form::hidden('mobile') !!}
{!! Form::hidden('phone') !!}
{!! Form::hidden('address1') !!}
{!! Form::hidden('address2') !!}
{!! Form::hidden('address3') !!}
{!! Form::hidden('city') !!}
{!! Form::hidden('pincode') !!}
<div class="col-md-6 col-sm-6">
    <div class="mt-10 widget box">
        <div class="widget-header">
            <h4><i class="fa fa-reorder"></i> </h4>
        </div>
        <div class="widget-content">
            <div class="form-group row">
                <div class="col-md-3 text-right label-control">
                    {!! Form::label('BMrNo','Baby\'s '.Lang::get('home.mrn').'.:', ['class'=>'required-label']) !!}
                </div>
                @if(isset($id) && $id == 0)
                <div class="col-md-7 custom-input">
                    {!! Form::text('BMrNo',@$bmrno,['class'=>'form-control']) !!}
                </div>
                <div class="col-md-2">
                    <a class="btn btn-primary btn-basic-shadow pull-right" id="search-baby-by-mr" disabled="true">
                        <i class="fa fa-search"></i> <span>Search</span>
                    </a>
                    <br>
                    <label id="search_mrn_no_error" style="display: none; color: red"></label>                                        
                </div>
                @else 
                <div class="col-md-9 custom-input">
                    {!! Form::text('BMrNo',@$bmrno,['class'=>'form-control from-sub-list']) !!}
                </div>
                @endif
                <div class="col-md-offset-3">
                    <span id="mrn_no_error" style="display: none; color: red"></span>
                </div>
            </div>
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
                    {!! Form::text('MotherName',null,['class'=>'form-control']) !!}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3 text-right label-control">
                    {!! Form::label('DOB','DOB:', ['class'=>'required-label']) !!}
                </div>
                <div class="col-md-9 custom-input">
                    {!! Form::text('DOB',null,['class'=>'form-control baby-dob-format birth-date', 'readonly']) !!}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                    {!! Form::label('BirthWeight','Birth Weight:') !!}
                </div>
                <div class="col-md-9 custom-input clear-xs">
                    <div class="row">
                        <div class="col-xs-6">
                            <small>(In Grams)</small>
                        </div>
                        <div class="col-xs-6">
                            <small>(In Kilograms)</small>
                        </div>
                        <div class="col-xs-6">
                            {!! Form::text('BirthWeight',@$baby_detail->BirthWeight,['class'=>'form-control','maxlength'=>'4']) !!}
                            <label for="BirthWeight" generated="true" class="error help-block"></label>
                        </div>
                        <div class="col-xs-6">
                            @php $wt = (isset($baby_detail->BirthWeight) && !empty($baby_detail->BirthWeight) && !is_null($baby_detail->BirthWeight)) ? $baby_detail->BirthWeight/1000 : null; @endphp
                            {!! Form::text('birth_weight',$wt,['class'=>'form-control growth-weight','readonly'=>'true', 'id'=>'birth_weight']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3 text-right label-control mt-0">
                    {!! Form::label('head_circumference','Birth Head Circumference (cm):') !!}
                </div>
                <div class="col-md-9 custom-input">
                    {!! Form::text('head_circumference',null,['class'=>'form-control']) !!}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3 text-right label-control">
                    {!! Form::label('BirthStatus','Birth Status:') !!}
                </div>
                <div class="col-md-9 custom-input">
                    <input id="BirthStatus" data-size="small" name="BirthStatus" data-off="Outborn" data-on="Inborn" data-width="100" data-toggle="toggle" class="form-control switch-input" type="checkbox" @if(isset($results->BirthStatus) && $results->BirthStatus == 'Inborn') checked="checked" @endif>
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
                            {!! Form::text('g_weeks',null,['class'=>'form-control growth-weight gestation-wks','max'=>'43','id'=>'g_weeks']) !!}
                            <label class="error help-block" for="g_weeks" generated="true"></label> 
                        </div>
                        <div class="inbeween_two_fields">
                            <span>+</span>
                        </div>
                        <div>
                            <small>(In Days)</small>
                            {!! Form::text('g_days',null,['class'=>'form-control gestation-days','max'=>'6','id'=>'g_days']) !!}
                            <label class="error help-block" for="g_days" generated="true"></label> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                    {!! Form::label('Age','Chronological Age :') !!}
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
                            {!! Form::text('chronological_year',null,['class'=>'form-control ing-test']) !!}
                            <label for="chronological_year" generated="true" class="error help-block"></label>
                        </div>
                        <div class="col-xs-4">
                            {!! Form::text('chronological_month',null,['class'=>'form-control ing-test']) !!}
                            <label for="chronological_month" generated="true" class="error help-block"></label>
                        </div>
                        <div class="col-xs-4">
                            {!! Form::text('chronological_days',null,['class'=>'form-control ing-test']) !!}
                            <label for="chronological_days" generated="true" class="error help-block"></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                    {!! Form::label('Age','Corrected Age:') !!}
                </div>
                <div class="col-md-9 custom-input clear-xs">
                    <div class="row corrected_age">
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
                            {!! Form::text('corrected_year',null,['class'=>'form-control']) !!}
                            <label for="corrected_year" generated="true" class="error help-block"></label>
                        </div>
                        <div class="col-xs-4">
                            {!! Form::text('corrected_month',null,['class'=>'form-control']) !!}
                            <label for="corrected_month" generated="true" class="error help-block"></label>
                        </div>
                        <div class="col-xs-4">
                            {!! Form::text('corrected_days',null,['class'=>'form-control']) !!}
                            <label for="corrected_days" generated="true" class="error help-block"></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                    {!! Form::label('Chronological Age','Chronological Age:') !!}
                </div>
                <div class="col-md-9 custom-input clear-xs">
                    <div class="row">
                        <div class="col-xs-6">
                            <small>(Weeks)</small>
                        </div>
                        <div class="col-xs-6">
                            <small>(Days)</small>
                        </div>
                        <div class="col-xs-6">
                            {!! Form::text('total_chronological_weeks',null,['class'=>'form-control']) !!}
                            <label for="total_chronological_weeks" generated="true" class="error help-block"></label>
                        </div>
                        <div class="col-xs-6">
                            {!! Form::text('total_chronological_days',null,['class'=>'form-control ']) !!}
                            <label for="total_chronological_days" generated="true" class="error help-block"></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3 text-right label-control" style="margin-top: 25px">
                    {!! Form::label('Age In','Corrected Age:') !!}
                </div>
                <div class="col-md-9 custom-input clear-xs">
                    <div class="row corrected_age">
                        <div class="col-xs-6">
                            <small>(Weeks)</small>
                        </div>
                        <div class="col-xs-6">
                            <small>(Days)</small>
                        </div>
                        <div class="col-xs-6">
                            {!! Form::text('total_corrected_weeks',null,['class'=>'form-control corrected-gestation-wks']) !!}
                            <label for="total_corrected_weeks" generated="true" class="error help-block"></label>
                        </div>
                        <div class="col-xs-6">
                            {!! Form::text('total_corrected_days',null,['class'=>'form-control corrected-gestation-days']) !!}
                            <label for="total_corrected_days" generated="true" class="error help-block"></label>
                        </div>
                    </div>
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
                {!! Form::hidden('visit_type', 'OP', ['id'=>'visit_type']) !!}
                {!! Form::hidden('visit_module_name', 'neuro_op') !!}
                {!! Form::hidden('visit_number') !!}
                <div class="col-md-3 text-right label-control">
                    {!! Form::label('visit_date','Visit Date:', ['class'=>'required-label']) !!}
                </div>
                <div class="col-md-9 custom-input">
                    {!! Form::text('visit_date',@$current_date,['class'=>'form-control admission-date record-date','readonly'=>'true']) !!}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                    {!! Form::label('visit_time','Visit Time:') !!}
                </div>
                <div class="col-md-9 custom-input clear-xs">
                    <div class="col-xs-4 plr-0">
                        <small>(Hour)</small>
                        {!! Form::select('visit_time',$time['time'],@$current_time['hours'],['class'=>'select2-select-00 full-width-fix']) !!}
                    </div>
                    <div class="col-xs-4">
                        <small>(Minute)</small>
                        {!! Form::select('visit_min',$time['mins'],@$current_time['mins'],['class'=>'select2-select-00 full-width-fix']) !!}
                    </div>
                    <div class="col-xs-4 plr-0">
                        <small>(Session)</small>
                        {!! Form::select('visit_session',$time['session'],@$current_time['am'],['class'=>'select2-select-00 full-width-fix']) !!}
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3 text-right label-control">
                    {!! Form::label('BabyBloodGroup','Baby\'s Blood Group:') !!}
                </div>
                <div class="col-md-9 custom-input custom-select">
                    {!! Form::select('BabyBloodGroup',ValuelistHelpers::Blood_groups(),null,['class'=>'form-control']) !!}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3 text-right label-control">
                    {!! Form::label('Sex','Sex:') !!}
                </div>
                <div class="col-md-9 custom-input custom-select">
                    {!! Form::select('Sex',[''=>'Select','Male'=>'Male','Female'=>'Female','Indeterminate'=>'Indeterminate'],null,['class'=>'form-control']) !!}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                    {!! Form::label('CurrentWt','Current Weight:') !!}
                </div>
                <div class="col-md-9 custom-input clear-xs">
                    <div class="row">
                        <div class="col-xs-6">
                            <small>(In Grams)</small>
                        </div>
                        <div class="col-xs-6">
                            <small>(In Kilograms)</small>
                        </div>
                        <div class="col-xs-6">
                            {!! Form::input('text','current_weight_g',null,['class'=>'form-control mobile-']) !!}
                        </div>
                        <div class="col-xs-6">
                            @php $current_weight_kg = (isset($results->current_weight_g) && $results->current_weight_g > 0) ? $results->current_weight_g/1000 : null @endphp
                            {!! Form::input('text','current_weight_kg',$current_weight_kg,['class'=>'form-control ','readonly'=>'true','id'=>'CurrentWtInKilo']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3 text-right label-control mt-0">
                    {!! Form::label('current_ofc','Current OFC (Head Circumference in cm):') !!}
                </div>
                <div class="col-md-9 custom-input">
                    {!! Form::text('current_ofc',null,['class'=>'form-control']) !!}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3 text-right label-control mt-0">
                    {!! Form::label('current_length','Current Length / Height (cm) :') !!}
                </div>
                <div class="col-md-9 custom-input">
                    {!! Form::text('current_length',null,['class'=>'form-control']) !!}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3 text-right label-control">
                    {!! Form::label('baby_background','Background Details:') !!}
                </div>
                <div class="col-md-9 custom-input">
                    <div id="baby_background" class="tinymce-body">
                        {!! isset($results->baby_background) ? $results->baby_background : @$baby_detail->baby_background !!}
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3 text-right label-control">
                    {!! Form::label('diagnosis','Diagnosis:') !!}
                </div>
                <div class="col-md-9 custom-input">
                    <div id="diagnosis" class="tinymce-body">
                        {!! isset($results->diagnosis) ? $results->diagnosis : @$baby_detail->diagnosis !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12 col-sm-12">
    <div class="mt-10 widget box">
        <div class="widget-header">
            <h4><i class="fa fa-reorder"></i>Test Information</h4>
        </div>
        <div class="widget-content row">
            <div class="col-md-6 col-sm-6">
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control mt-0">
                        {!! Form::label('reason_referral','Reason for Referral:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('reason_referral',null,['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control mt-0">
                        {!! Form::label('referal_doctor','Referal Doctor:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('referal_doctor',null,['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('examiner','Examiner Name:', ['class'=>'required-label']) !!}
                        <a href="javascript:void(0)" class="add_master_data" data-modal_header="Examiner Name" data-destination_elements="seen_by, examiner" data-option_value="id" data-option_text="Name" data-mas_table="mas_doctors">
                            <i class="fa fa-info-circle bs-tooltip add-neo-consultant" data-placement="right" data-original-title="Add Doctor"></i>
                        </a>
                    </div>
                    <div class="col-md-9 custom-input custom-select">
                        {!! Form::select('examiner',[''=>'N/A']+$doctor_master,null,['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control mt-0">
                        {!! Form::label('caregiver_assessment','Caregiver in assessment:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('caregiver_assessment',null,['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control mt-0">
                        {!! Form::label('caregiver_name','Caregiver Name:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('caregiver_name',null,['class'=>'form-control']) !!}
                    </div>
                </div>      
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control mt-0">
                        {!! Form::label('relationship_to_child','Relationship to the child:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('relationship_to_child',null,['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control mt-0">
                        {!! Form::label('primary_caregiver_education','Primary Caregiver Education:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::select('primary_caregiver_education',[''=>'N/A', 'Less than primary'=>'Less than primary', 'Primary'=>'Primary', 'Secondary'=>'Secondary', 'College/University'=>'College/University'],null,['class'=>'form-control']) !!}
                    </div>
                </div>  
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control mt-0">
                        {!! Form::label('hour_of_intervention','Hours of Intervention:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('hour_of_intervention',null,['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control mt-0">
                        {!! Form::label('contact_no','Contact No:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('contact_no',null,['class'=>'form-control']) !!}
                    </div>
                </div>  
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control mt-0">
                        {!! Form::label('other_relationship','Others:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('other_relationship',null,['class'=>'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">  
                <div class="hidden">
                    {!! Form::select('seenby',[''=>'N/A']+$doctor_master,null,['class'=>'form-control']) !!}
                </div>                                     
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('seen_by','Seen By', ['class'=>'required-label']) !!}
                        <a href="javascript:void(0)" class="add_master_data" data-modal_header="Seen By" data-destination_elements="seen_by, examiner" data-option_value="id" data-option_text="Name" data-mas_table="mas_doctors">
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
                                            <a class="btn btn-success btn-view btn_add" id="seenby_add" href="javascript:void(0);">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($results->seen_by))
                                @php
                                $seen_by = json_decode($results->seen_by);
                                @endphp
                                @if(isset($seen_by) && is_array($seen_by) && count($seen_by) > 0)
                                @foreach($seen_by as $key => $seen_by)
                                <tr>
                                    <td>
                                        {!! Form::select('seen_by['.$key.']',[''=>'N/A']+$doctor_master,$seen_by,['class'=>'form-control full-width']) !!}
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
                                        {!! Form::select('seen_by[]',[''=>'N/A']+$doctor_master,null,['class'=>'form-control full-width']) !!}
                                    </td>
                                </tr>
                                @endif 
                                @else 
                                <tr>
                                    <td>
                                        {!! Form::select('seen_by[]',[''=>'N/A']+$doctor_master,null,['class'=>'form-control full-width']) !!}
                                    </td>
                                </tr>
                                @endif 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
