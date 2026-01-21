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
            @if (!$type)
            <div class="form-group row">
                <div class="col-md-3 text-right label-control">
                    {!! Form::label('MMrNo','Mother\'s '.Lang::get('home.mrn').'.:') !!}
                </div>
                @if(isset($id) && $id == 0)
                <div class="col-md-7 custom-input">
                    {!! Form::text('MMrNo',@$mmrno,['class'=>'form-control']) !!}
                </div>
                <div class="col-md-2">
                    <a class="btn btn-primary btn-basic-shadow pull-right" id="search-mother-by-mr" disabled="true">
                        <i class="fa fa-search"></i> <span>Search</span>
                    </a>
                    <br>
                    <label id="search_mrn_no_error" style="display: none; color: red"></label>                                        
                </div>
                @else 
                <div class="col-md-9 custom-input">
                    {!! Form::text('MMrNo',@$mmrno,['class'=>'form-control from-sub-list']) !!}
                </div>
                @endif
                <div class="col-md-offset-3">
                    <span id="mrn_no_error" style="display: none; color: red"></span>
                </div>
            </div>
            @else
            <div class="form-group row">
                <div class="col-md-3 text-right label-control">
                    {!! Form::label('BMrNo','Baby\'s '.Lang::get('home.mrn').'.:') !!}
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
            @endif
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
                    {!! Form::text('DOB',null,['class'=>'form-control datepicker birth-date', 'readonly']) !!}
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
            <div class="form-group row">
                <div class="col-md-3 text-right label-control">
                    {!! Form::label('referred_by','Referred By:') !!}
                </div>
                <div class="col-md-9 custom-input">
                    {!! Form::text('referred_by',null,['class'=>'form-control']) !!}
                </div>
            </div>
            <div class="hidden">
                {!! Form::select('seenby',[''=>'N/A']+$doctor_master,null,['class'=>'form-control']) !!}
            </div>                                     
            <div class="form-group row">
                <div class="col-md-3 text-right label-control">
                    {!! Form::label('seen_by','Seen By', ['class'=>'required-label']) !!}
                    <a href="javascript:void(0)" class="add_master_data" data-modal_header="Seen By" data-destination_elements="seen_by" data-option_value="id" data-option_text="Name" data-mas_table="mas_doctors">
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
<div class="col-md-6 col-sm-6">
    <div class="mt-10 widget box">
        <div class="widget-header">
            <h4><i class="fa fa-reorder"></i> </h4>
        </div>
        <div class="widget-content">
            <div class="form-group row">
                {!! Form::hidden('visit_type', 'OP', ['id'=>'visit_type']) !!}
                {!! Form::hidden('visit_module_name', 'feeding_op') !!}
                {!! Form::hidden('visit_number') !!}
                <div class="col-md-3 text-right label-control">
                    {!! Form::label('visit_date','Visit Date:') !!}
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
            @php
            $name_dvs = \ValuelistHelpers::mas_doctors_list(8);
            $name_rks = \ValuelistHelpers::mas_doctors_list(7);
            $name_neuro_consultant =  \ValuelistHelpers::mas_doctors_list(52);
            @endphp
            <div class="form-group row">
                <div class="col-md-3 text-right label-control">
                    {!! Form::label('visit_from','Visit From:') !!}
                </div>
                <div class="col-md-9 custom-input">
                    {!! Form::select('visit_from', [''=>'-- Select --', $dvs=>$name_dvs, $rks=>$name_rks, $neuro_consultant_id=>$name_neuro_consultant, 'Others'=>'Others'],null,['class'=>'form-control expect']) !!}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3 text-right label-control">
                    {!! Form::label('visit_from_more','Visit From:') !!}
                </div>
                <div class="col-md-9 custom-input">
                    {!! Form::text('visit_from_more',null,['class'=>'form-control']) !!}
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
                            {!! Form::input('text','BirthWeight',null,['class'=>'form-control mobile-','maxlength'=>'4']) !!}
                            <label for="BirthWeight" generated="true" class="error help-block"></label>
                        </div>
                        <div class="col-xs-6">                            
                            @php $weight = (isset($results->BirthWeight) && !empty($results->BirthWeight) && !is_null($results->BirthWeight)) ? $results->BirthWeight/1000 : null; @endphp
                            {!! Form::input('text','birth_weight',$weight,['class'=>'form-control ','readonly'=>'true']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                    {!! Form::label('discharge_weight','Discharge Weight (In grams):') !!}
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
                            {!! Form::input('text','discharge_weight',null,['class'=>'form-control mobile-','maxlength'=>'4']) !!}
                            <label for="discharge_weight" generated="true" class="error help-block"></label>
                        </div>
                        <div class="col-xs-6">                            
                            @php $dweight = (isset($results->discharge_weight) && !empty($results->discharge_weight) && !is_null($results->discharge_weight)) ? $results->discharge_weight/1000 : null; @endphp
                            {!! Form::input('text','d_weight',$dweight,['class'=>'form-control ','readonly'=>'true']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                    {!! Form::label('current_weight','Current Weight (In grams):') !!}
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
                            {!! Form::input('text','current_weight',null,['class'=>'form-control mobile-']) !!}
                            <label for="current_weight" generated="true" class="error help-block"></label>
                        </div>
                        <div class="col-xs-6">                            
                            @php $cweight = (isset($results->current_weight) && !empty($results->current_weight) && !is_null($results->current_weight)) ? $results->current_weight/1000 : null; @endphp
                            {!! Form::input('text','c_weight',$cweight,['class'=>'form-control ','readonly'=>'true','id'=>'c_weight']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3 text-right label-control">
                    {!! Form::label('background_details','Background Details:') !!}
                </div>
                <div class="col-md-9 custom-input">
                    <div id="background_details" class="tinymce-body">
                        {!! isset($results->background_details) ? $results->background_details : @$baby_detail->background_details !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>