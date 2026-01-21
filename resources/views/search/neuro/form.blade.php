@php
$site_url = url('/').'/public';
@endphp
<div role="tabpanel" class="tabbable tabbable-custom">
    <ul class="nav nav-tabs" role="tablist" id="container-div">
        <li role="presentation" class="active">
            <a href="#babyform" aria-controls="babyform" role="tab" data-toggle="tab">Baby Details</a>
        </li>
        <li role="presentation">
            <a href="#eligibility" aria-controls="eligibility" role="tab" data-toggle="tab">Eligibility</a>
        </li>
        <li role="presentation">
            <a href="#screening" aria-controls="screening" role="tab" data-toggle="tab">Screening</a>
        </li>
        <li role="presentation">
            <a href="#assessment" aria-controls="assessment" role="tab" data-toggle="tab">Screening / Assessment</a>
        </li>
    </ul>            
    <div class="tab-content tab-view-shadow">
        <div role="tabpanel" class="tab-pane active" id="babyform">
            <div class="col-md-6 col-sm-6">
                <div class="mt-10 widget box">
                    <div class="widget-header">
                        <h4><i class="fa fa-reorder"></i> </h4>
                    </div>
                    <div class="widget-content">
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('BMrNo','Baby\'s MR No.:') !!}
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
                                {!! Form::text('DOB',null,['class'=>'form-control', 'placeholder'=>'DD-MM-YYYY']) !!}
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
                                        {!! Form::text('BirthWeight',@$baby_detail->BirthWeight,['class'=>'form-control']) !!}
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
                                {!! Form::select('BirthStatus',[''=>'N/A','Inborn'=>'Inborn','Outborn'=>'Outborn'],null,['class'=>'form-control']) !!}
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
                            {!! Form::hidden('visit_number') !!}
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('visit_date','Visit Date:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('visit_date',@$current_date,['class'=>'form-control', 'placeholder'=>'DD-MM-YYYY']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                {!! Form::label('visit_time','Visit Time:') !!}
                            </div>
                            <div class="col-md-9 custom-input clear-xs">
                                <div class="col-xs-4 plr-0">
                                    <small>(Hour)</small>
                                    {!! Form::select('visit_time',[''=>'N/A']+$time['time'],@$current_time['hours'],['class'=>'form-control']) !!}
                                </div>
                                <div class="col-xs-4">
                                    <small>(Minute)</small>
                                    {!! Form::select('visit_min',[''=>'N/A']+$time['mins'],@$current_time['mins'],['class'=>'form-control']) !!}
                                </div>
                                <div class="col-xs-4 plr-0">
                                    <small>(Session)</small>
                                    {!! Form::select('visit_session',[''=>'N/A']+$time['session'],@$current_time['am'],['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('BabyBloodGroup','Baby\'s Blood Group:') !!}
                            </div>
                            <div class="col-md-9 custom-input custom-select">
                                {!! Form::select('BabyBloodGroup',[''=>'N/A']+ValuelistHelpers::Blood_groups(),null,['class'=>'form-control']) !!}
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
                                @if (isset($results->baby_background))
                                <div id="baby_background" class="tinymce-body">
                                    {!! isset($results->baby_background) ? $results->baby_background : @$baby_detail->baby_background !!}
                                </div>
                                @else
                                {!! Form::textarea('baby_background', null, ['class'=>'form-control', 'rows'=>3]) !!}
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('seen_by','Seen By:') !!}
                            </div>
                            <div class="col-md-9 custom-input custom-select">
                                {!! Form::select('seen_by',[''=>'N/A']+ValuelistHelpers::mas_doctors_list(),null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="eligibility">
            @php            
            $birth_weight_gestation_is_lesser = isset($results->birth_weight_gestation_is_lesser) ? $results->birth_weight_gestation_is_lesser : null;
            $birth_weight_gestation_is_greater = isset($results->birth_weight_gestation_is_greater) ? $results->birth_weight_gestation_is_greater : null;
            $intrauterine_growth = isset($results->intrauterine_growth) ? $results->intrauterine_growth : null;
            $meningitis = isset($results->meningitis) ? $results->meningitis : null;
            $mechanical_ventilation = isset($results->mechanical_ventilation) ? $results->mechanical_ventilation : null;
            $encephalopathy_stage_2_more = isset($results->encephalopathy_stage_2_more) ? $results->encephalopathy_stage_2_more : null;
            $major_malformation = isset($results->major_malformation) ? $results->major_malformation : null;
            $inborn_errors = isset($results->inborn_errors) ? $results->inborn_errors : null;
            $symptomatic_hypoglycemia = isset($results->symptomatic_hypoglycemia) ? $results->symptomatic_hypoglycemia : null;
            $symptomatic_polycythemia = isset($results->symptomatic_polycythemia) ? $results->symptomatic_polycythemia : null;
            $retrovirus_positive_mother = isset($results->retrovirus_positive_mother) ? $results->retrovirus_positive_mother : null;
            $hyperbilirubinemia_transfusion_rh = isset($results->hyperbilirubinemia_transfusion_rh) ? $results->hyperbilirubinemia_transfusion_rh : null;
            $abnormal_neuro_exam = isset($results->abnormal_neuro_exam) ? $results->abnormal_neuro_exam : null;
            $major_morbidities = isset($results->major_morbidities) ? $results->major_morbidities : null;
            $other_specify_is_present = isset($results->other_specify_is_present) ? $results->other_specify_is_present : null;
            $general_checkup = isset($results->general_checkup) ? $results->general_checkup : null;
            @endphp
            <div class="eligibility plr-15">
                <h5 class="text-center"><strong>Eligibility for enrolment in HRC (Tick as appropriate)</strong></h5>
                <div class="overflow-auto">
                    <table class="table table-bordered">
                        <tbody>
                            <tr class="{{ @$birth_weight_gestation_is_lesser ? 'bg-warning' : '' }}">
                                <td class="text-center">
                                    {{ Form::checkbox('birth_weight_gestation_is_lesser', null, $birth_weight_gestation_is_lesser, ['id'=>'birth_weight_gestation_is_lesser']) }}
                                </td>
                                <td>
                                    <div class="display-flex">
                                        <span class="bullets">1.</span>
                                        <p>Birth weight <1500 grams</p>
                                        </div>
                                        <div class="display-flex">
                                            <span class="bullets">2.</span>
                                            <p>Gestation <32weeks</p>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="{{ @$birth_weight_gestation_is_greater ? 'bg-warning' : '' }}">
                                        <td class="text-center">
                                            {{ Form::checkbox('birth_weight_gestation_is_greater', null, $birth_weight_gestation_is_greater, ['id'=>'birth_weight_gestation_is_greater']) }}
                                        </td>
                                        <td>
                                            <div class="display-flex">
                                                <span class="bullets">3.</span>
                                                <p>Infants with BW &#x2265; 1500 gm OR gestation &#x2265; 32 week <strong>AND</strong></p>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="sub-infants {{ @$intrauterine_growth ? 'bg-warning' : '' }}">
                                        <td class="text-center">
                                            {{ Form::checkbox('intrauterine_growth', null, $intrauterine_growth, ['id'=>'intrauterine_growth']) }}
                                        </td>
                                        <td>
                                            <div class="display-flex">
                                                <span class="bullets">a.</span>
                                                <p>Intrauterine growth centile <3<sup>rd</sup> centile</p>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="sub-infants {{ @$meningitis ? 'bg-warning' : '' }}">
                                            <td class="text-center">
                                                {{ Form::checkbox('meningitis', null, $meningitis, ['id'=>'meningitis']) }}                    
                                            </td>
                                            <td>
                                                <div class="display-flex">                    
                                                    <span class="bullets">b.</span>
                                                    <p>Meningitis</p>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="sub-infants {{ @$mechanical_ventilation ? 'bg-warning' : '' }}">
                                            <td class="text-center">
                                                {{ Form::checkbox('mechanical_ventilation', null, $mechanical_ventilation, ['id'=>'mechanical_ventilation']) }}                    
                                            </td>
                                            <td>
                                                <div class="display-flex">
                                                    <span class="bullets">c.</span>
                                                    <p>Received mechanical ventilation for 48 hours or more</p>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="sub-infants {{ @$encephalopathy_stage_2_more ? 'bg-warning' : '' }}">
                                            <td class="text-center">
                                                {{ Form::checkbox('encephalopathy_stage_2_more', null, $encephalopathy_stage_2_more, ['id'=>'encephalopathy_stage_2_more']) }}                    
                                            </td>
                                            <td>
                                                <div class="display-flex">
                                                    <span class="bullets">d.</span>
                                                    <p>Hypoxic ischemic encephalopathy stage 2 or higher</p>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="sub-infants {{ @$major_malformation ? 'bg-warning' : '' }}">
                                            <td class="text-center">
                                                {{ Form::checkbox('major_malformation', null, $major_malformation, ['id'=>'major_malformation']) }}                    
                                            </td>
                                            <td>
                                                <div class="display-flex">
                                                    <span class="bullets">e.</span>
                                                    <p>Major malformation</p>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="sub-infants {{ @$inborn_errors ? 'bg-warning' : '' }}">
                                            <td class="text-center">
                                                {{ Form::checkbox('inborn_errors', null, $inborn_errors, ['id'=>'inborn_errors']) }}                    
                                            </td>
                                            <td>
                                                <div class="display-flex">
                                                    <span class="bullets">f.</span>
                                                    <p>Inborn error of metabolism/chromosomal or genetic disorders/intrauterine infections</p>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="sub-infants {{ @$symptomatic_hypoglycemia ? 'bg-warning' : '' }}">
                                            <td class="text-center">
                                                {{ Form::checkbox('symptomatic_hypoglycemia', null, $symptomatic_hypoglycemia, ['id'=>'symptomatic_hypoglycemia']) }}                    
                                            </td>
                                            <td>
                                                <div class="display-flex">
                                                    <span class="bullets">g.</span>
                                                    <p>Symptomatic hypoglycemia</p>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="sub-infants {{ @$symptomatic_polycythemia ? 'bg-warning' : '' }}">
                                            <td class="text-center">
                                                {{ Form::checkbox('symptomatic_polycythemia', null, $symptomatic_polycythemia, ['id'=>'symptomatic_polycythemia']) }}                    
                                            </td>
                                            <td>
                                                <div class="display-flex">
                                                    <span class="bullets">h.</span>
                                                    <p>Symptomatic polycythemia</p>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="sub-infants {{ @$retrovirus_positive_mother ? 'bg-warning' : '' }}">
                                            <td class="text-center">
                                                {{ Form::checkbox('retrovirus_positive_mother', null, $retrovirus_positive_mother, ['id'=>'retrovirus_positive_mother']) }}                    
                                            </td>
                                            <td>
                                                <div class="display-flex">
                                                    <span class="bullets">i.</span>
                                                    <p>Retrovirus positive mother</p>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="sub-infants {{ @$hyperbilirubinemia_transfusion_rh ? 'bg-warning' : '' }}">
                                            <td class="text-center">
                                                {{ Form::checkbox('hyperbilirubinemia_transfusion_rh', null, $hyperbilirubinemia_transfusion_rh, ['id'=>'hyperbilirubinemia_transfusion_rh']) }}                    
                                            </td>
                                            <td>
                                                <div class="display-flex">
                                                    <span class="bullets">j.</span>
                                                    <p>Hyperbilirubinemia requiring exchange transfusion OR Rh isoimmunization/cholestasis</p>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="sub-infants {{ @$abnormal_neuro_exam ? 'bg-warning' : '' }}">
                                            <td class="text-center">
                                                {{ Form::checkbox('abnormal_neuro_exam', null, $abnormal_neuro_exam, ['id'=>'abnormal_neuro_exam']) }}                    
                                            </td>
                                            <td>
                                                <div class="display-flex">
                                                    <span class="bullets">k.</span>
                                                    <p>Abnormal neurological examination at discharge/seizures</p>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="sub-infants {{ @$major_morbidities ? 'bg-warning' : '' }}">
                                            <td class="text-center">
                                                {{ Form::checkbox('major_morbidities', null, $major_morbidities, ['id'=>'major_morbidities']) }}                    
                                            </td>
                                            <td>
                                                <div class="display-flex">
                                                    <span class="bullets">l.</span>
                                                    <p>Major morbidities such as chronic lung disease, IVH grade III or more (Papile's classification) and periventricular leucomalacia</p>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="{{ @$other_specify_is_present ? 'bg-warning' : '' }}">
                                            <td class="text-center">
                                                {{ Form::checkbox('other_specify_is_present', null, $other_specify_is_present, ['id'=>'other_specify_is_present']) }}                    
                                            </td>
                                            <td>
                                                <div class="display-flex">
                                                    <span class="bullets">4.</span>
                                                    <p>Other<br/>Specify</p>
                                                    {{ Form::textarea('other_specify', null, ['id'=>'other_specify', 'rows'=>1, 'cols'=>50, 'style'=>'margin-top:7px;']) }}
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="{{ @$general_checkup ? 'bg-warning' : '' }}">
                                            <td class="text-center">
                                                {{ Form::checkbox('general_checkup', null, $general_checkup, ['id'=>'general_checkup']) }}                    
                                            </td>
                                            <td>
                                                <div class="display-flex">
                                                    <span class="bullets">5.</span>
                                                    <p>General Developmental Checkup</p>                            
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <div role="tabpanel" class="tab-pane m-15" id="screening">
                        <div class="screening">
                            <div class="overflow-auto">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th colspan="2"></th>
                                            <th>Date</th>
                                            <th>Right</th>
                                            <th>Left</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>ROP screening</td>
                                            <td></td>
                                            <td class="rop rop_screening">{!! Form::text('rop_date', null, ['class'=>'form-control screening-date', 'placeholder'=>'DD-MM-YYYY']) !!}</td>
                                            <td class="rop rop_screening">{{ Form::text('rop_right_hand_side', null, ['class'=>'form-control']) }}</td>
                                            <td class="rop rop_screening">{{ Form::text('rop_left_hand_side', null, ['class'=>'form-control']) }}</td>
                                            <td class="rop rop_screening">{{ Form::text('rop_remarks', null, ['class'=>'form-control']) }}</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="2">Hearing screening</td>
                                            <td>(AABR)</td>
                                            <td class="aabr hearing_test_name">{!! Form::text('hearing_screen_aabr_date', null, ['class'=>'form-control screening-date', 'placeholder'=>'DD-MM-YYYY']) !!}</td>
                                            <td class="aabr hearing_test_name">{{ Form::select('hearing_screen_aabr_right_hand_side', $right_options, null, ['class'=>'form-control']) }}</td>
                                            <td class="aabr hearing_test_name">{{ Form::select('hearing_screen_aabr_left_hand_side', $left_options, null, ['class'=>'form-control']) }}</td>
                                            <td class="aabr hearing_test_name">{{ Form::text('hearing_screen_aabr_remarks', null, ['class'=>'form-control']) }}</td>
                                        </tr>
                                        <tr>
                                            <td>(OAE)</td>
                                            <td class="oae hearing_test_name">{!! Form::text('hearing_screen_oae_date', null, ['class'=>'form-control screening-date', 'placeholder'=>'DD-MM-YYYY']) !!}</td>
                                            <td class="oae hearing_test_name">{{ Form::select('hearing_screen_oae_right_hand_side', $right_options, null, ['class'=>'form-control']) }}</td>                    
                                            <td class="oae hearing_test_name">{{ Form::select('hearing_screen_oae_left_hand_side', $left_options, null, ['class'=>'form-control']) }}</td>                  
                                            <td class="oae hearing_test_name">{{ Form::text('hearing_screen_oae_remarks', null, ['class'=>'form-control']) }}</td>                  
                                        </tr>
                                        <tr>
                                            <td rowspan="2">Hearing Assessment</td>
                                            <td>Diagnostic ABR</td>
                                            <td class="abr diagnostic_test_name">{!! Form::text('diagnostic_abr_date', null, ['class'=>'form-control screening-date', 'placeholder'=>'DD-MM-YYYY']) !!}</td>
                                            <td class="abr diagnostic_test_name">{{ Form::text('diagnostic_abr_right_hand_side', null, ['class'=>'form-control']) }}</td>
                                            <td class="abr diagnostic_test_name">{{ Form::text('diagnostic_abr_left_hand_side', null, ['class'=>'form-control']) }}</td>
                                            <td class="abr diagnostic_test_name">{{ Form::text('diagnostic_abr_remarks', null, ['class'=>'form-control']) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Conditioning Play Audiometery</td>
                                            <td class="cpa diagnostic_test_name">{!! Form::text('diagnostic_cpa_date', null, ['class'=>'form-control screening-date', 'placeholder'=>'DD-MM-YYYY']) !!}</td>
                                            <td class="cpa diagnostic_test_name">{{ Form::select('diagnostic_cpa_right_hand_side', $right_options, null, ['class'=>'form-control']) }}</td>
                                            <td class="cpa diagnostic_test_name">{{ Form::select('diagnostic_cpa_left_hand_side', $left_options, null, ['class'=>'form-control']) }}</td>
                                            <td class="cpa diagnostic_test_name">{{ Form::text('diagnostic_cpa_remarks', null, ['class'=>'form-control']) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="head-screening">
                            <div class="overflow-auto">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Head Scan</th>
                                            <th>Date</th>
                                            <th>Impression</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>CT</td>
                                            <td class="ct">{!! Form::text('ct_date', null, ['class'=>'form-control screening-date', 'placeholder'=>'DD-MM-YYYY']) !!}</td>
                                            <td class="ct">{{ Form::text('ct_imperssion', null, ['class'=>'form-control']) }}</td>
                                        </tr>
                                        <tr>
                                            <td>USG</td>
                                            <td class="usg">{!! Form::text('usg_date', null, ['class'=>'form-control screening-date', 'placeholder'=>'DD-MM-YYYY']) !!}</td>
                                            <td class="usg">{{ Form::text('usg_imperssion', null, ['class'=>'form-control']) }}</td>
                                        </tr>
                                        <tr>
                                            <td>MRI</td>
                                            <td class="mri">{!! Form::text('mri_date', null, ['class'=>'form-control screening-date', 'placeholder'=>'DD-MM-YYYY']) !!}</td>
                                            <td class="mri">{{ Form::text('mri_imperssion', null, ['class'=>'form-control']) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="muscle-tone-norms">
                            <h6><strong>Muscle tone norms (Amiel Tison):</strong></h6>
                            <div class="overflow-auto">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th rowspan="3" class="vertical-align-center">Age<br/>(month)</th>
                                            <th rowspan="3" class="vertical-align-center">Date of<br/>assessment</th>
                                            <th rowspan="3" class="vertical-align-center">PNA/CA at<br/>assessment</th>
                                            <th rowspan="3" class="vertical-align-center">Adductor angle</th>
                                            <th colspan="2">As assessed</th>
                                            <th rowspan="3" class="vertical-align-center">Popliteal angle</th>
                                            <th colspan="2">As assessed</th>
                                            <th rowspan="3" class="vertical-align-center">Dorsiflexion angle</th>
                                            <th colspan="2">As assessed</th>
                                            <th colspan="6">Scarf sign (tick)</th>
                                        </tr>
                                        <tr>
                                            <th rowspan="2" class="vertical-align-center">Left</th>
                                            <th rowspan="2" class="vertical-align-center">Right</th>
                                            <th rowspan="2" class="vertical-align-center">Left</th>
                                            <th rowspan="2" class="vertical-align-center">Right</th>
                                            <th rowspan="2" class="vertical-align-center">Left</th>
                                            <th rowspan="2" class="vertical-align-center">Right</th>
                                            <th colspan="2" class="vertical-align-center">Elbow does not cross midline</th>
                                            <th colspan="2" class="vertical-align-center">Elbow crosses midline</th>
                                            <th colspan="2" class="vertical-align-center">Elbow goes beyond axillary line</th>
                                        </tr>
                                        <tr>
                                            <th>Left</th>
                                            <th>Right</th>
                                            <th>Left</th>
                                            <th>Right</th>
                                            <th>Left</th>
                                            <th>Right</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">0-3</td>
                                            <td class="text-center">{!! Form::text('date_of_assessment_0_3', null, ['class'=>'form-control assessment_date assessment_date_0-3']) !!}</td>
                                            <td class="text-center">{!! Form::text('pna_ca_assessment_0_3', null, ['class'=>'form-control']) !!}</td>
                                            <td class="text-center">40°-80°</td>
                                            <td class="text-center">{!! Form::text('adductor_as_assessed_left_0_3', null, ['class'=>'form-control']) !!}</td>
                                            <td class="text-center">{!! Form::text('adductor_as_assessed_right_0_3', null, ['class'=>'form-control']) !!}</td>
                                            <td class="text-center">80°-100°</td>
                                            <td class="text-center">{!! Form::text('popliteal_as_assessed_left_0_3', null, ['class'=>'form-control']) !!}</td>
                                            <td class="text-center">{!! Form::text('popliteal_as_assessed_right_0_3', null, ['class'=>'form-control']) !!}</td>
                                            <td class="text-center">60°-70°</td>
                                            <td class="text-center">{!! Form::text('dorsiflexion_as_assessed_left_0_3', null, ['class'=>'form-control']) !!}</td>
                                            <td class="text-center">{!! Form::text('dorsiflexion_as_assessed_right_0_3', null, ['class'=>'form-control']) !!}</td>
                                            <td class="text-center">{{ Form::checkbox('elbow_not_cross_midline_left_0_3', null) }}</td>
                                            <td class="text-center">{{ Form::checkbox('elbow_not_cross_midline_right_0_3', null) }}</td>
                                            <td class="text-center">{{ Form::checkbox('elbow_cross_midline_left_0_3', null) }}</td>
                                            <td class="text-center">{{ Form::checkbox('elbow_cross_midline_right_0_3', null) }}</td>
                                            <td class="text-center">{{ Form::checkbox('elbow_goes_beyond_axillary_line_left_0_3', null) }}</td>
                                            <td class="text-center">{{ Form::checkbox('elbow_goes_beyond_axillary_line_right_0_3', null) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">4-6</td>
                                            <td class="text-center">{!! Form::text('date_of_assessment_4_6', null, ['class'=>'form-control assessment_date assessment_date_4-6']) !!}</td>
                                            <td class="text-center">{!! Form::text('pna_ca_assessment_4_6', null, ['class'=>'form-control']) !!}</td>
                                            <td class="text-center">70°-110°</td>
                                            <td class="text-center">{!! Form::text('adductor_as_assessed_left_4_6', null, ['class'=>'form-control']) !!}</td>
                                            <td class="text-center">{!! Form::text('adductor_as_assessed_right_4_6', null, ['class'=>'form-control']) !!}</td>
                                            <td class="text-center">90°-120°</td>
                                            <td class="text-center">{!! Form::text('popliteal_as_assessed_left_4_6', null, ['class'=>'form-control']) !!}</td>
                                            <td class="text-center">{!! Form::text('popliteal_as_assessed_right_4_6', null, ['class'=>'form-control']) !!}</td>
                                            <td class="text-center">60°-70°</td>
                                            <td class="text-center">{!! Form::text('dorsiflexion_as_assessed_left_4_6', null, ['class'=>'form-control']) !!}</td>
                                            <td class="text-center">{!! Form::text('dorsiflexion_as_assessed_right_4_6', null, ['class'=>'form-control']) !!}</td>
                                            <td class="text-center">{{ Form::checkbox('elbow_not_cross_midline_left_4_6', null) }}</td>
                                            <td class="text-center">{{ Form::checkbox('elbow_not_cross_midline_right_4_6', null) }}</td>
                                            <td class="text-center">{{ Form::checkbox('elbow_cross_midline_left_4_6', null) }}</td>
                                            <td class="text-center">{{ Form::checkbox('elbow_cross_midline_right_4_6', null) }}</td>
                                            <td class="text-center">{{ Form::checkbox('elbow_goes_beyond_axillary_line_left_4_6', null) }}</td>
                                            <td class="text-center">{{ Form::checkbox('elbow_goes_beyond_axillary_line_right_4_6', null) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">7-9</td>
                                            <td class="text-center">{!! Form::text('date_of_assessment_7_9', null, ['class'=>'form-control assessment_date assessment_date_7-9']) !!}</td>
                                            <td class="text-center">{!! Form::text('pna_ca_assessment_7_9', null, ['class'=>'form-control']) !!}</td>
                                            <td class="text-center">110°-140°</td>
                                            <td class="text-center">{!! Form::text('adductor_as_assessed_left_7_9', null, ['class'=>'form-control']) !!}</td>
                                            <td class="text-center">{!! Form::text('adductor_as_assessed_right_7_9', null, ['class'=>'form-control']) !!}</td>
                                            <td class="text-center">110°-160°</td>
                                            <td class="text-center">{!! Form::text('popliteal_as_assessed_left_7_9', null, ['class'=>'form-control']) !!}</td>
                                            <td class="text-center">{!! Form::text('popliteal_as_assessed_right_7_9', null, ['class'=>'form-control']) !!}</td>
                                            <td class="text-center">60°-70°</td>
                                            <td class="text-center">{!! Form::text('dorsiflexion_as_assessed_left_7_9', null, ['class'=>'form-control']) !!}</td>
                                            <td class="text-center">{!! Form::text('dorsiflexion_as_assessed_right_7_9', null, ['class'=>'form-control']) !!}</td>
                                            <td class="text-center">{{ Form::checkbox('elbow_not_cross_midline_left_7_9', null) }}</td>
                                            <td class="text-center">{{ Form::checkbox('elbow_not_cross_midline_right_7_9', null) }}</td>
                                            <td class="text-center">{{ Form::checkbox('elbow_cross_midline_left_7_9', null) }}</td>
                                            <td class="text-center">{{ Form::checkbox('elbow_cross_midline_right_7_9', null) }}</td>
                                            <td class="text-center">{{ Form::checkbox('elbow_goes_beyond_axillary_line_left_7_9', null) }}</td>
                                            <td class="text-center">{{ Form::checkbox('elbow_goes_beyond_axillary_line_right_7_9', null) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">10-12</td>
                                            <td class="text-center">{!! Form::text('date_of_assessment_10_12', null, ['class'=>'form-control assessment_date assessment_date_10-12']) !!}</td>
                                            <td class="text-center">{!! Form::text('pna_ca_assessment_10_12', null, ['class'=>'form-control']) !!}</td>
                                            <td class="text-center">140°-160°</td>
                                            <td class="text-center">{!! Form::text('adductor_as_assessed_left_10_12', null, ['class'=>'form-control']) !!}</td>
                                            <td class="text-center">{!! Form::text('adductor_as_assessed_right_10_12', null, ['class'=>'form-control']) !!}</td>
                                            <td class="text-center">150°-170°</td>
                                            <td class="text-center">{!! Form::text('popliteal_as_assessed_left_10_12', null, ['class'=>'form-control']) !!}</td>
                                            <td class="text-center">{!! Form::text('popliteal_as_assessed_right_10_12', null, ['class'=>'form-control']) !!}</td>
                                            <td class="text-center">60°-70°</td>
                                            <td class="text-center">{!! Form::text('dorsiflexion_as_assessed_left_10_12', null, ['class'=>'form-control']) !!}</td>
                                            <td class="text-center">{!! Form::text('dorsiflexion_as_assessed_right_10_12', null, ['class'=>'form-control']) !!}</td>
                                            <td class="text-center">{{ Form::checkbox('elbow_not_cross_midline_left_10_12', null) }}</td>
                                            <td class="text-center">{{ Form::checkbox('elbow_not_cross_midline_right_10_12', null) }}</td>
                                            <td class="text-center">{{ Form::checkbox('elbow_cross_midline_left_10_12', null) }}</td>
                                            <td class="text-center">{{ Form::checkbox('elbow_cross_midline_right_10_12', null) }}</td>
                                            <td class="text-center">{{ Form::checkbox('elbow_goes_beyond_axillary_line_left_10_12', null) }}</td>
                                            <td class="text-center">{{ Form::checkbox('elbow_goes_beyond_axillary_line_right_10_12', null) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-12 mt-15">        
                                <div class="col-sm-12 col-md-6">        
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('tone_type','Tone:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::select('tone_type', $tone,null,['class'=>'form-control']) !!}
                                        </div>
                                    </div>        
                                </div>        
                                <div class="col-sm-12 col-md-6">        
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('others','Others:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::select('others',$others,null,['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row" id="others-asymmetric">
                                        <div class="col-md-offset-3 col-md-9 custom-input">
                                            {!! Form::textarea('others_asymmetric',null,['class'=>'form-control', 'rows'=>5]) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="assessment">
                        <div class="col-md-6 col-sm-6">
                            <div class="mt-10 widget box">
                                <div class="widget-header">
                                    <h4><i class="fa fa-reorder"></i></h4>
                                </div>
                                <div class="widget-content">
                                    <table class="table" style="margin: auto;">
                                        <tr id="hnne_tab">
                                            @if (count($neuroList) > 0)
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
                                            @else
                                            <td>
                                                <span>HNNE</span>
                                            </td>
                                            <td>
                                                {!! Form::text('total_hnne_score', null, ['class'=>'form-control']) !!}
                                            </td>
                                            @endif
                                        </tr>
                                        <tr id="hine_tab">
                                            @if (count($neuroList) > 0)
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
                                            @else
                                            <td>
                                                <span>HINE</span>
                                            </td>
                                            <td>
                                                {!! Form::text('total_hine_score', null, ['class'=>'form-control']) !!}
                                            </td>
                                            @endif
                                        </tr>
                                        <tr id="m-chat_tab">
                                            @if (count($neuroList) > 0)
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
                                            @else
                                            <td>
                                                <span>M-CHAT</span>
                                            </td>
                                            <td>
                                                <table class="table">
                                                    <tr>
                                                        <td>
                                                            <span>R</span>
                                                        </td>
                                                        <td>
                                                            {!! Form::text('m_chat_r_total', null, ['class'=>'form-control']) !!}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <span>Followup</span>
                                                        </td>
                                                        <td>
                                                            {!! Form::text('m_chat_followup_total', null, ['class'=>'form-control']) !!}
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            @endif
                                        </tr>
                                        <tr id="dasii_tab">
                                            @if (count($neuroList) > 0)
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
                                            @else
                                            <td>
                                                <span>DASII</span>
                                            </td>
                                            <td>
                                                <table class="table">
                                                    <tr>
                                                        <td>
                                                            <span>Me.DQ</span>
                                                        </td>
                                                        <td>
                                                            {!! Form::text('mental_development_quotient', null, ['class'=>'form-control']) !!}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <span>Mo.DQ</span>
                                                        </td>
                                                        <td>
                                                            {!! Form::text('motor_development_quotient', null, ['class'=>'form-control']) !!}
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            @endif
                                        </tr>
                                        <tr id="ddst_tab">
                                            @if (count($neuroList) > 0)
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
                                            @else
                                            <td>
                                                <span>DDST II</span>
                                            </td>
                                            <td>
                                                {{ Form::select('ddst_interpretation_status', [''=>'N/A']+$ddst_interpretation_result,null, ['class'=>'form-control']) }}
                                            </td>
                                            @endif
                                        </tr>
                                        <tr id="cbcl_tab">
                                            @if (count($neuroList) > 0)
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
                                            @else
                                            <td>
                                                <span>CBCL</span>
                                            </td>
                                            <td>
                                                {{ Form::select('cbcl_interpretation_status', [''=>'N/A', 0=>'Normal', 1=>'Borderline',2=>'Risk'], null, ['class'=>'form-control']) }}
                                            </td>
                                            @endif
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
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            @if (isset($results->baby_behavior))
                                            <div id="baby_behavior" class="tinymce-body">
                                                {!! @$results->baby_behavior !!}
                                            </div>
                                            @else
                                            {!! Form::textarea('baby_behavior', null, ['class'=>'form-control', 'rows'=>3]) !!}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('confidential_background_details','Confidential Background Details:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            @if (isset($results->confidential_background_details))
                                            <div id="confidential_background_details" class="tinymce-body">
                                                {!! @$results->confidential_background_details !!}
                                            </div>
                                            @else
                                            {!! Form::textarea('confidential_background_details', null, ['class'=>'form-control', 'rows'=>3]) !!}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('recommendation','Recommendation:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            @if (isset($results->recommendation))
                                            <div id="recommendation" class="tinymce-body">
                                                {!! @$results->recommendation !!}
                                            </div>
                                            @else
                                            {!! Form::textarea('recommendation', null, ['class'=>'form-control', 'rows'=>3]) !!}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('referral_status','Referral:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::select('referral_status',[''=>'N/A',0=>'No',1=>'Yes'],null,['class'=>'form-control']) !!}
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
                                            <div class="col-xs-5 pl-0">
                                                <small>(Date)</small>
                                            </div>
                                            <div class="col-xs-7 plr-0">
                                                <small>(Time)</small>
                                            </div>
                                            <div class="col-xs-5 pl-0">
                                                {!! Form::text('review',null,['class'=>'form-control']) !!}
                                            </div>
                                            <div class="col-xs-7 plr-0">
                                                <div class="col-xs-4 plr-0">{!! Form::select('review_time',[''=>'N/A']+$time['time'],null,['class'=>'form-control']) !!}</div>
                                                <div class="col-xs-4 pl-5 pr-0">{!! Form::select('review_min',[''=>'N/A']+$time['mins'],null,['class'=>'form-control']) !!}</div>
                                                <div class="col-xs-4 pl-5 pr-0">{!! Form::select('review_session',[''=>'N/A']+$time['session'],null,['class'=>'form-control']) !!}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            <label for="fee_status">Fee charges:</label>
                                        </div>
                                        <div class="col-md-9 custom-input"> 
                                            {!! Form::select('fee_status',[''=>'N/A',0=>'No',1=>'Yes'],null,['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                    @php
                                    $name_dvs = \ValuelistHelpers::mas_doctors_list(8);
                                    $name_rks = \ValuelistHelpers::mas_doctors_list(7);
                                    @endphp
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
                    @if (count($neuroList) > 0)
                    <div role="tabpanel" class="tab-pane" id="hnne_form">
                        @include('registration.neuro.hnne_report')
                    </div>
                    <div role="tabpanel" class="tab-pane" id="hine_form">
                        @include('registration.neuro.hine_report')
                    </div>
                    <div role="tabpanel" class="tab-pane" id="m-chat_form">
                        @include('registration.neuro.m_chat_report')
                    </div>
                    <div role="tabpanel" class="tab-pane" id="dasii_form">
                        @include('registration.neuro.dasii_report')
                    </div>
                    <div role="tabpanel" class="tab-pane" id="ddst_form">
                        {!! Form::hidden('age') !!}
                        @include('registration.neuro.ddst_chart')
                    </div>
                    <div role="tabpanel" class="tab-pane" id="cbcl_form">
                        @include('registration.neuro.cbcl_report')
                    </div>
                    @endif
                    <div class="col-md-12 col-sm-12 ptb-15">
                        @if(isset($neuroList) && count($neuroList) < 1)
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary save-button-shadow btn-block form-control">
                                <i class="fa fa-floppy-o"></i> 
                                <span>Search</span>
                            </button>
                        </div>
                        @endif
                        <div class="col-md-6">
                            <a href="{{ action('Registration\NeuroController@index') }}" class="btn btn-default save-button-shadow btn-block form-control" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> 
                                <span>Cancel</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>