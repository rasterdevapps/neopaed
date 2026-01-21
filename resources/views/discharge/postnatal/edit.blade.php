@extends('app')
@section('content')
<!-- Breadcrumbs line -->
@php
if(!isset($temp_acive_menu)) {
$temp_acive_menu =  'dischargeform';
}
@endphp
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="{{ url('/') }}">Dashboard</a>
        </li>
        <li class="">
            <a title="Discharge Details" href="{{ action('Admission\PostnatalDischargeController@index') }}">
             Postnatal Discharge Details            
         </a>
     </li>
     <li class="current">
        <a title="">Edit {{ $babyIdentification }}</a>
    </li>
</ul>
</div>
<!-- /Breadcrumbs line -->
<div class="row row-spacing">
    <div class="col-md-12 postnatal">
        {!! Form::model($dischargeList,['method' => 'PATCH','url' => action('Admission\PostnatalDischargeController@update',$id),'id' => 'admissionProforma-form', 'class'=>'postnatal-discharge-form']) !!}
        {!! Form::hidden('BabyId') !!}
        {!! Form::hidden('MotherId') !!}
        {!! Form::hidden('AdmissionId') !!}
        {!! Form::hidden('next_module',@$next_module) !!}
        {!! Form::hidden('bed_id',@$bed_id) !!}
        {!! Form::hidden('temp_dob', date('d-m-Y', strtotime($baby->DOB)),['id'=>'temp_dob', 'class'=>'datepicker birth-date']) !!}
        {!! Form::hidden('temp_gestation',$baby->Gestation) !!}
        {!! Form::hidden('temp_acive_menu', $temp_acive_menu) !!}
        <!-- Nav tabs -->
        <div role="tabpanel" class="tabbable tabbable-custom">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" @if($temp_acive_menu =='dischargeform') class="active" @endif>
                    <a class="discharge-menu" href="#dischargeform" aria-controls="dischargeform" role="tab"  data-toggle="tab">Discharge Details</a>
                </li>
                <li role="presentation" @if($temp_acive_menu =='Checkform') class="active" @endif>
                    <a class="discharge-menu" href="#Checkform" aria-controls="Checkform" role="tab" data-toggle="tab">Checklist</a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content tab-view-shadow">                
                <!-- Discharge -->
                <div role="tabpanel" class="tab-pane @if($temp_acive_menu =='dischargeform') active @endif discharge-margin" id="dischargeform">
                    <div class="col-md-6 col-sm-6">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('discharge_status','Status:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('discharge_status',ValuelistHelpers::Discharge_Status(),null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('discharge_date','Date of Discharge / Transfered:', ['class'=>'required-label'], ['class'=>'required-label']) !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('discharge_date',null,['class'=>'form-control discharge-date record-date', 'readonly']) !!}
                                    </div>
                                </div>  
                                <div class="form-group row DiedTime">
                                    <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                        {!! Form::label('DiedTime','Time Of Died:') !!}
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
                                                {!! Form::select('diedTime',$timeList['time'],null,['class'=>'form-control input-width-small']) !!}
                                            </div>
                                            <div class="col-xs-4">
                                                {!! Form::select('diedMins',$timeList['mins'],null,['class'=>'form-control input-width-small']) !!}
                                            </div>
                                            <div class="col-xs-4">
                                                {!! Form::select('diedAm',$timeList['session'],null,['class'=>'form-control input-width-small']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('discharge_dol','DOL at Discharge:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('discharge_dol',null,['class'=>'form-control ']) !!}
                                    </div>
                                </div>
                                {!! Form::hidden('g_weeks', $baby->g_weeks, ['class'=>'gestation-wks']) !!}
                                {!! Form::hidden('g_days', (empty($baby->g_days)  && is_null($baby->g_days)  ? 0 : $baby->g_days), ['class'=>'gestation-days']) !!}
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                        {!! Form::label('CorrectedGestation','Corrected Gestational Age:', ['class'=>'required-label']) !!}
                                    </div>
                                    <div class="col-md-9 custom-input clear-xs">
                                        <div class="row col-md-12 display-flex">
                                            <div>
                                                <small>(In Weeks)</small>
                                                {!! Form::text('dcg_weeks',null,['class'=>'form-control corrected-gestation-wks', 'readonly']) !!}
                                                <label class="error help-block" for="dcg_weeks" generated="true"></label> 
                                            </div>
                                            <div class="inbeween_two_fields">
                                                <span>+</span>
                                            </div>
                                            <div>
                                                <small>(In Days)</small>
                                                {!! Form::text('dcg_days',null,['class'=>'form-control corrected-gestation-days', 'readonly']) !!}
                                                <label class="error help-block" for="dcg_days" generated="true"></label> 
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <div class="form-group row">
                                    <div class="col-md-3 label-control text-right">
                                        {!! Form::label('discharge_wt','Discharge Weight (In grams):', ['class'=> 'required-label']) !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('discharge_wt',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 label-control text-right">
                                        {!! Form::label('discharge_ofc','OFC in cm:', ['class'=> isset($hospital_name) && $hospital_name == 'Saraswathi Nursing Home' ? '' : 'required-label']) !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('discharge_ofc',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 label-control text-right">
                                        {!! Form::label('discharge_length','Length in cm:', ['class'=> isset($hospital_name) && $hospital_name == 'Saraswathi Nursing Home' ? '' : 'required-label']) !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('discharge_length',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 label-control text-right md-mt-50">
                                        {!! Form::label('discharge_immunization','Immunization:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('discharge_immunization',[''=>'N/A','Due'=>'Due','Given'=>'Given'],null,['class'=>'form-control','rows'=> 4,'data-color'=>ValuelistHelpers::setColorvalue('Immunization',2)]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 label-control text-right">
                                        {!! Form::label('schedule','Schedule:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('schedule',[''=>'N/A','At birth'=>'At birth','6 wks'=>'6 wks','10 wks'=>'10 wks','14 wks'=>'14 wks','6 mths'=>'6 mths','9 mths'=>'9 mths','1 year'=> '1 year','15 mths'=>'15 mths','16-18 mths'=>'16-18 mths','18 mths'=>'18 mths','2 years'=>'2 years','5 years'=>'5 years','Optional'=>'Optional','Catch Up'=>'Catch Up'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="hidden">
                                    {!! Form::select('temp_Vaccine',['N/A'=>'N/A']+ValuelistHelpers::Vaccine(),'',["class"=>"form-control input-width-small"]) !!}
                                </div>                        
                                <div class="form-group row">
                                    <div class="col-md-12 custom-input">
                                        <table class="vaccine table table-add-more full-width-fix">
                                            <thead>
                                                <tr class="master-add-header">
                                                    <th>
                                                        {!! Form::label('Vaccine','Vaccine') !!}
                                                        <a href="javascript:void(0)" class="add_master_data" data-modal_header="Vaccine" data-destination_elements="temp_Vaccine,Vaccine[]" data-option_value="id" data-option_text="Name" data-mas_table="mas_vaccine">
                                                            <i class="fa fa-info-circle bs-tooltip add-neo-consultant" data-placement="right" data-original-title="Add Vaccine"></i>
                                                        </a>
                                                    </th>
                                                    <th>
                                                        {!! Form::label('VaccineDate','Day') !!}
                                                    </th>
                                                    <th>
                                                        <span>
                                                            <a class="btn btn-success btn-view vaccine_add btn_add" href="javascript:void(0);">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                        </span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(isset($vaccine) && count($vaccine) > 0)
                                                @for ($i = 0; $i < count($vaccine); $i++)
                                                <tr>
                                                    <td class="form-group row full-width">
                                                        {!! Form::select('Vaccine['.$i.']',['N/A'=>'N/A']+ValuelistHelpers::Vaccine(),$vaccine[$i]['vaccine'],['class'=>'full-width select2-select-00 vaccine-search'.$i]) !!}
                                                    </td>
                                                    <td class="form-group row">
                                                        @php $vaccine[$i]['vaccinedate'] = (isset($vaccine[$i]['vaccinedate']) && !empty($vaccine[$i]['vaccinedate']) && $vaccine[$i]['vaccinedate'] != 'null' && $vaccine[$i]['vaccinedate'] != null && !@unserialize($vaccine[$i]['vaccinedate']) !== false) ? $vaccine[$i]['vaccinedate'] : '' @endphp
                                                        {!! Form::text('VaccineDate['.$i.']',$vaccine[$i]['vaccinedate'],['class'=>'form-control datepicker input-width-small', 'readonly']) !!}
                                                    </td>
                                                    <td>
                                                        <span class="fa fa-trash btn btn-danger btn-view remove"></span>
                                                    </td>
                                                </tr>
                                                @endfor
                                                @else
                                                <tr>
                                                    <td class="form-group row full-width">
                                                        {!! Form::select('Vaccine[]',['N/A'=>'N/A']+ValuelistHelpers::Vaccine(),null,['class'=>'full-width select2-select-00 vaccine-search0']) !!}
                                                    </td>
                                                    <td class="form-group row">
                                                        {!! Form::text('VaccineDate[]',null,['class'=>'form-control datepicker input-width-small', 'readonly']) !!}
                                                    </td>
                                                    <td>
                                                        <span class="fa fa-trash btn btn-danger btn-view remove"></span>
                                                    </td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table> 
                                    </div>
                                </div>       
                                <div class="form-group row">
                                    <div class="col-md-3 label-control text-right">
                                        {!! Form::label('diagnosis', 'Diagnosis:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::textarea('diagnosis', null, ['class'=>'form-control', 'rows'=>'8']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 label-control text-right">
                                        {!! Form::label('additional_information', 'Postnatal Course:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::textarea('additional_information', null, ['class'=>'form-control', 'rows'=>'8']) !!}
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
                                <div class="form-group">
                                    <h3 class="mt-0">Discharge Examination </h3>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 label-control text-right">
                                        {!! Form::label('discharge_eyes','Eyes:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('discharge_eyes',[''=>'N/A','Normal with Red reflex'=>'Normal with Red reflex','Subconjunctival Hemorrhage'=>'Subconjunctival Hemorrhage','Cataract'=>'Cataract','Microophthalmos'=>'Microophthalmos'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 label-control text-right md-mt-50">
                                        {!! Form::label('discharge_cardiac_murmur', 'Cardiac Murmur:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('discharge_cardiac_murmur',[''=>'N/A','Present'=>'Present','Absent'=>'Absent'], null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('HearingScreening',2)]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 label-control text-right mt-0">
                                        {!! Form::label('postductal_spo2','Postductal (SPO2 %):') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('postductal_spo2',null,['class'=>'form-control']) !!}
                                    </div>
                                </div> 
                                <div class="form-group row">
                                    <div class="col-md-3 label-control text-right md-mt-50">
                                        {!! Form::label('discharge_femorals','Femoral:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('discharge_femorals',[''=>'N/A','Normal'=>'Normal','Bounding'=>'Bounding','Feeble/Weak'=>'Feeble/Weak','Absent'=>'Absent'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 label-control text-right md-mt-50">
                                        {!! Form::label('discharge_hips','Hips:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('discharge_hips',[''=>'N/A','Normal'=>'Normal','DDH Rt'=>'DDH Rt','DDH Lt'=>'DDH Lt','DDH Bilateral'=>'DDH Bilateral'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 label-control text-right md-mt-50">
                                        {!! Form::label('discharge_gentila','Gentila:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('discharge_gentila',ValuelistHelpers::getGentila(),null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('gentila',2)]) !!}
                                    </div>
                                </div>                     
                                <div class="form-group row">
                                    <div class="col-md-3 label-control text-right">
                                        {!! Form::label('discharge_gentila_findings', 'Gentila Findings:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('discharge_gentila_findings',null,['class'=>'form-control'])!!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 label-control text-right md-mt-50">
                                        {!! Form::label('discharge_malinformation','Malformation:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('discharge_malinformation',['No'=>'No','Yes'=>'Yes'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 label-control text-right">
                                        {!! Form::label('malinformation_details','Malformation Details:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::textarea('malinformation_details',null,['class'=>'form-control','rows'=>'5']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 label-control text-right mt-0">
                                        {!! Form::label('feeding_at_discharge','Feeding At Discharge:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('feeding_at_discharge',ValuelistHelpers::feedingDischarge(),null,['class'=>'form-control','rows' => 4]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 label-control text-right md-mt-50">
                                        {!! Form::label('neourological_status','Neurological Status:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('neourological_status',[''=>'N/A','Normal'=>'Normal','Suspect'=>'Suspect','Abnormal'=>'Abnormal'],null,['class'=>'form-control','rows'=>5,'data-color'=>ValuelistHelpers::setColorvalue('NeurologicalStatus',2)]) !!}
                                    </div>
                                </div>                        
                                <div class="form-group row">
                                    <div class="col-md-3 label-control text-right mt-0">
                                        {!! Form::label('appoinment_status','Next Appointment:') !!}
                                    </div> 
                                    <div class="col-md-9 custom-input">
                                        <input id="appoinment_status" name="appoinment_status" data-on="Yes" data-off="No" data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                                    </div> 
                                </div>
                                <div class="form-group row next-appoinment-property">
                                    <div class="col-md-3 label-control text-right mt-0">
                                        {!! Form::label('appoinment_date','Next Appointment Date:') !!}
                                    </div> 
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('appoinment_date',null,['class'=>'form-control datepicker', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="form-group row next-appoinment-property">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('NextAppointmentTime','Next Appointment Time:') !!}
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
                                                {!! Form::select('appoinment_hrs',$timeList['time'],null,['class'=>'form-control input-width-small']) !!}
                                            </div>
                                            <div class="col-xs-4">
                                                {!! Form::select('appoinment_min',$timeList['mins'],null,['class'=>'form-control input-width-small']) !!}
                                            </div>
                                            <div class="col-xs-4">
                                                {!! Form::select('appoinment_session',$timeList['session'],null,['class'=>'form-control input-width-small']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 overflow-auto">      
                        <h3>Medications
                            <a href="javascript:void(0)" class="add_master_data" data-modal_header="Drugs & Iv Fluids" data-destination_elements="temp_drugs,M_Drugs[]" data-option_value="id" data-option_text="brand_name" data-mas_table="mas_drugivfluid" data-drug_type="oral">
                                <i class="fa fa-info-circle bs-tooltip" data-placement="right" data-original-title="Add Drugs & Iv Fluids"></i>
                            </a>
                        </h3>                    
                        <div class="form-group row">
                            <div class="col-md-12 custom-input">
                                <table class="drugs table table-add-more full-width-fix">
                                    <thead>
                                        <tr class="master-add-header">
                                            <th>Drug</th>
                                            <th>Generic Name</th>
                                            <th>Formulation/Strength</th>
                                            <th>Dose</th>
                                            <th>Frequency</th>
                                            <th>Duration</th>
                                            <th>Additional Instruction</th>
                                            <th><span><a class="btn btn-success btn-view drugs_add btn_add" href="javascript:void(0);"><i class="fa fa-plus"></i></a></span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <div class="hidden">
                                            {!! Form::select('temp_drugs',['N/A'=>'N/A']+$drungList,null) !!}
                                            {!! Form::select('temp_frequency', [''=>'N/A']+ValuelistHelpers::frequency(),'') !!}
                                            {!! Form::select('temp_does',[''=>'N/A']+ValuelistHelpers::dose(),'') !!}
                                            {!! Form::select('temp_duration',[''=>'N/A']+ValuelistHelpers::medicationDuration(),'') !!} 
                                        </div>
                                        @if (isset($medications) && (count($medications) > 0))
                                        @php $l = 0; @endphp
                                        @foreach ($medications as $key => $medi_data)
                                        <tr>
                                            <td>{!! Form::select('M_Drugs['.$key.']',['0'=>'N/A']+$drungList1,$medi_data['Medication'],['class'=>'drugs-changes drug-list-name'.$l,'data-id'=>$l, 'style'=>'min-width:300px;']) !!}</td>
                                            <td>{!! Form::text('m_generic_name['.$key.']',$medi_data['genericname'],['class'=>'form-control generic_name'.$l]) !!}</td>
                                            <td>{!! Form::select('formulation['.$key.']',ValuelistHelpers::formulationStrength($medi_data['formulation']),$medi_data['formulation'],['class'=>'form-control formulation'.$l]) !!}</td>
                                            <td class="input-width-medium">{!! Form::select('M_Dose['.$key.']',[''=>'N/A']+ValuelistHelpers::dose(),$medi_data['Dose'],['class'=>'form-control']) !!}</td>
                                            <td class="input-width-medium">{!! Form::select('M_Frequency['.$key.']',[''=>'N/A']+ValuelistHelpers::frequency(),$medi_data['Frequency'],['class'=>'form-control']) !!}</td>
                                            <td class="input-width-medium">{!! Form::select('M_Duration['.$key.']',[''=>'N/A']+ValuelistHelpers::medicationDuration(),$medi_data['Duration'],['class'=>'form-control']) !!} </td>
                                            <td>{!! Form::textarea('additional_instruction['.$key.']',$medi_data['additional_instruction'],['class'=>'form-control', 'rows'=>1]) !!}</td>                                        
                                            <td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>                                                        
                                        </tr>
                                        @php $l++; @endphp
                                        @endforeach
                                        @else
                                        <tr>
                                            <td>{!! Form::select('M_Drugs[]',['0'=>'N/A']+$drungList,'',['class'=>'drugs-changes drug-list-name0','data-id'=>'0', 'style'=>'min-width:300px;']) !!}</td>
                                            <td>{!! Form::text('m_generic_name[]',null,['class'=>'form-control generic_name0']) !!}</td>
                                            <td>{!! Form::select('formulation[]',[''=>'N/A'],null,['class'=>'form-control formulation0']) !!}</td>
                                            <td class="input-width-medium">{!! Form::select('M_Dose[]',[''=>'N/A']+ValuelistHelpers::dose(),null,['class'=>'form-control']) !!}</td>
                                            <td class="input-width-medium">{!! Form::select('M_Frequency[]',[''=>'N/A']+ValuelistHelpers::frequency(),null,['class'=>'form-control'])!!}</td>
                                            <td class="input-width-medium">{!! Form::select('M_Duration[]',[''=>'N/A']+ValuelistHelpers::medicationDuration(),null,['class'=>'form-control']) !!}</td> 
                                            <td>{!! Form::textarea('additional_instruction[]',null,['class'=>'form-control', 'rows'=>1]) !!}</td>
                                            <td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table> 
                            </div>
                        </div>   
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane @if($temp_acive_menu =='Checkform') active @endif" id="Checkform">
                    <div class="col-md-6 col-sm-6">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> 
                                    Discharge Blood Tests
                                </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 label-control text-right">
                                        {!! Form::label('discharge_hb','Hb(g/dl):') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('discharge_hb',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 label-control text-right">
                                        {!! Form::label('discharge_pcv','PCV:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('discharge_pcv',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 label-control text-right">
                                        {!! Form::label('discharge_dct','DCT:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('discharge_dct',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 label-control text-right">
                                        {!! Form::label('discharge_tsb','Total Serum Bilirubin (mg/dl):') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('discharge_tsb',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 label-control text-right">
                                        {!! Form::label('direct_bilirubin','Direct Bilirubin (mg/dl):') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('direct_bilirubin',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 label-control text-right">
                                        {!! Form::label('dischargeserum_ca','Ca (mg/dl):') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('dischargeserum_ca',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 label-control text-right">
                                        {!! Form::label('dischargeserum_po4','Po4 (mg/dl):') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('dischargeserum_po4',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 label-control text-right">
                                        {!! Form::label('dischargeserum_alp','ALP (IU/L):') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('dischargeserum_alp',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 label-control text-right">
                                        {!! Form::label('dischargeserum_na','Na (mmol/l):') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('dischargeserum_na',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 label-control text-right md-mt-50">
                                        {!! Form::label('discharge_home_oxygen','Home Oxygen:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('discharge_home_oxygen',[''=>'N/A','Yes'=>'Yes','No'=>'No'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('HomeOxygen',2)]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 label-control text-right md-mt-50">
                                        {!! Form::label('discharge_cuss','Cranial Ultrasound:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('discharge_cuss',[''=>'N/A','Normal'=>'Normal','Abnormal'=>'Abnormal','Not Indicated'=>'Not Indicated'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('DischargeCUSS',2)]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 label-control text-right">
                                        {!! Form::label('cranial_ultrasound', 'Cranial Ultrasound:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::textarea('cranial_ultrasound', null,['class'=>'form-control','rows'=>'5','cols'=>'5']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 label-control text-right md-mt-50">
                                        {!! Form::label('echocardiography_status','Echo Cardiography:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('echocardiography_status',[''=>'N/A','Normal'=>'Normal','Abnormal'=>'Abnormal','Not Indicated'=>'Not Indicated'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('DischargeCUSS',2)]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 label-control text-right">
                                        {!! Form::label('echocardiography', 'Echo Cardiography:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::textarea('echocardiography', null,['class'=>'form-control','rows'=>'5','cols'=>'5']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 label-control text-right">
                                        {!! Form::label('background', 'Background:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::textarea('background', null,['class'=>'form-control','rows'=>'5','cols'=>'5']) !!}
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> 
                                    Discharge Screening Tests
                                </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 label-control text-right md-mt-50">
                                        {!! Form::label('discharge_new_born','Newborn Screen:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('discharge_new_born',[""=>"N/A",'Sent' => 'Sent','Not Sent'=>'Not Sent','Normal'=>'Normal','Abnormal'=>'Abnormal'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('NicuNewBornScreen',2)]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 label-control text-right md-mt-50">
                                        {!! Form::label('discharge_hearing_screen','Hearing Screening:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('discharge_hearing_screen',[''=>'N/A','Performed' => 'Performed','To be performed as outpatient' => 'To be performed as outpatient','Not Indicated' => 'Not Indicated'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('HearingScreening',2)]) !!}
                                    </div>
                                </div>
                                <div class="form-group row hearing-screen-type">
                                    <div class="col-md-12 custom-input">
                                        <table class="postnatal-organizam table table-add-more full-width-fix">
                                            <thead>
                                                <tr> 
                                                    <th>OAE Left:</th>
                                                    <th>OAE Right:</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{!! Form::select('oae_left', [''=>'N/A', 'Normal'=>'Normal', 'Suspect'=>'Suspect'],null,['class'=>'form-control hearing-screen-type-value']) !!}</td>
                                                    <td>{!! Form::select('oae_right', [''=>'N/A', 'Normal'=>'Normal', 'Suspect'=>'Suspect'],null,['class'=>'form-control hearing-screen-type-value']) !!}</td>
                                                </tr>
                                            </tbody>
                                        </table> 
                                    </div>
                                </div>   
                                <div class="form-group row hearing-screen-type">
                                    <div class="col-md-12 custom-input">
                                        <table class="postnatal-organizam table table-add-more full-width-fix">
                                            <thead>
                                                <tr> 
                                                    <th>ABR Left:</th>
                                                    <th>ABR Right:</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{!! Form::select('abr_left', [''=>'N/A', 'Normal'=>'Normal', 'Suspect'=>'Suspect'],null,['class'=>'form-control hearing-screen-type-value']) !!}</td>
                                                    <td>{!! Form::select('abr_right', [''=>'N/A', 'Normal'=>'Normal', 'Suspect'=>'Suspect'],null,['class'=>'form-control hearing-screen-type-value']) !!}</td>
                                                </tr>
                                            </tbody>
                                        </table> 
                                    </div>
                                </div>  
                                <div class="form-group row">
                                    <div class="col-md-3 label-control text-right md-mt-50">
                                        {!! Form::label('rop_screening_status','ROP Screening:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('rop_screening_status',[""=>"N/A",'Performed' => 'Performed','To be performed as outpatient' => 'To be performed as outpatient','Not Indicated' => 'Not Indicated'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>  
                                <div class="form-group row rop-results">
                                    <div class="col-md-12 custom-input">
                                        <table class="postnatal-organizam table table-add-more full-width-fix">
                                            <thead>
                                                <tr> 
                                                    <th>ROP Screening Result Left:</th>
                                                    <th>ROP Screening Result Right:</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{!! Form::select('left_rop_left',ValuelistHelpers::RopScreening(),null,['class'=>'form-control rop-results-type','id'=>'Rop']) !!}</td>
                                                    <td>{!! Form::select('left_rop_right',ValuelistHelpers::RopScreening(),null,['class'=>'form-control rop-results-type','id'=>'Rop']) !!}</td>
                                                </tr>
                                            </tbody>
                                        </table> 
                                    </div>
                                </div>  
                                <div class="form-group row">
                                    <div class="col-md-3 label-control text-right md-mt-50">
                                        {!! Form::label('rop_treatment','ROP Treatment:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('rop_treatment',ValuelistHelpers::commonValues(),null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('ROPTreatment',2)]) !!}
                                    </div>
                                </div>
                                <div class="hidden">
                                    {!! Form::select('TypeofTreatmentemp',[''=>'N/A','Laser'=>'Laser','Cryotherapy'=>'Cryotherapy','Surgical'=>'Surgical'],null) !!}
                                </div> 
                                <div class="form-group row rop_treatment">
                                    <div class="col-md-12 custom-input">
                                        <table class="TypeofTreatmenDiv table table-add-more full-width-fix">
                                            <thead>
                                                <tr class="master-add-header"> 
                                                    <th>Type of Treatment Left:</th>
                                                    <th>Type of Treatment Right:</th>
                                                    <th>
                                                        <span>
                                                            <a class="btn btn-success btn-view typeoftreatment_add btn_add" href="javascript:void(0);">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                        </span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        {!! Form::select('typeoftreatment_left[]',[''=>'N/A','Laser'=>'Laser','Cryotherapy'=>'Cryotherapy','Surgical'=>'Surgical'],null,['class'=>'form-control rop_treatment-type','id'=>'typeoftreatment_left','data-color'=>ValuelistHelpers::setColorvalue('TypeofTreatmen',2)]) !!}
                                                    </td> 
                                                    <td>
                                                        {!! Form::select('typeoftreatment_right[]',[''=>'N/A','Laser'=>'Laser','Cryotherapy'=>'Cryotherapy','Surgical'=>'Surgical'],null,['class'=>'form-control rop_treatment-type','id'=>'typeoftreatment_right','data-color'=>ValuelistHelpers::setColorvalue('TypeofTreatmen',2)]) !!}
                                                    </td>
                                                    <td>
                                                        <span class="fa fa-trash btn btn-danger btn-view remove"></span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table> 
                                    </div>
                                </div>  
                                <!-- <div class="form-group row rop_treatment">
                                    <div class="col-md-3 label-control text-right">
                                        {!! Form::label('TypeofTreatment','Type of Treatment:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <table class="TypeofTreatmenDiv table">
                                            <thead>
                                                <tr> 
                                                    <th>{!! Form::label('typeoftreatment_left','Left:') !!} </th> 
                                                    <th>{!! Form::label('typeoftreatment_right','Right:') !!} </th> 

                                                </tr> 
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{!! Form::select('typeoftreatment_left[]',[''=>'N/A','Laser'=>'Laser','Cryotherapy'=>'Cryotherapy','Surgical'=>'Surgical'],null,['class'=>'form-control rop_treatment-type','id'=>'typeoftreatment_left','data-color'=>ValuelistHelpers::setColorvalue('TypeofTreatmen',2)]) !!} </td> 
                                                    <td>{!! Form::select('typeoftreatment_right[]',[''=>'N/A','Laser'=>'Laser','Cryotherapy'=>'Cryotherapy','Surgical'=>'Surgical'],null,['class'=>'form-control rop_treatment-type','id'=>'typeoftreatment_right','data-color'=>ValuelistHelpers::setColorvalue('TypeofTreatmen',2)]) !!}</td>
                                                    <td><span class="fa fa-remove btn btn-default remove"></span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <a class="btn_add btn typeoftreatment_add" href="javascript:void(0);"><i class="fa fa-plus"></i> <span>Add More</span></a>
                                    </div>
                                </div> -->
                                <div class="form-group row">
                                    <div class="col-md-3 label-control text-right md-mt-50">
                                        {!! Form::label('rop_follow_up','ROP Follow Up:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('rop_follow_up',['1'=>'No','2'=>'Yes'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('rop_follow',2)]) !!}
                                    </div>
                                </div>
                                <div class="hidden">
                                    {!! Form::select('temp_procedures', $procedure_master, null,['class'=>'form-control']) !!}
                                    <a href="javascript:void(0)" class="add_master_data" data-modal_header="Procedures" data-destination_elements="temp_procedures,procedures[]" data-option_value="Id" data-option_text="Name" data-mas_table="mas_procedures">
                                        <i class="fa fa-info-circle bs-tooltip" data-placement="right" data-original-title="Add Procedures"></i>
                                    </a>
                                </div>                              
                                <div class="form-group row">
                                    <div class="col-md-3 label-control text-right">
                                        {!! Form::label('procedures', 'Procedures :') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <table class="procedure-list table table-add-more full-width-fix">
                                            <thead>                                    
                                                <tr class="master-add-header">
                                                    <th class="full-width">
                                                        <i class="fa fa-reorder"></i>Add More
                                                    </th>
                                                    <th>
                                                        <span>
                                                            <a class="btn btn-success btn-view procedure_add btn_add" href="javascript:void(0);">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                        </span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(isset($dischargeList['procedures']) && is_array($dischargeList['procedures']) && count($dischargeList['procedures']) > 0)  
                                                @foreach($dischargeList['procedures'] as $key => $procedure)
                                                <tr>
                                                    <td>
                                                        {!! Form::select('procedures['.$key.']', $procedure_master, $procedure,['class'=>'form-control']) !!}
                                                    </td>
                                                    <td>
                                                        <span class="fa fa-trash btn btn-danger btn-view remove"></span>
                                                    </td>
                                                </tr>
                                                @endforeach   
                                                @else
                                                <tr>
                                                    <td>
                                                        {!! Form::select('procedures[]', $procedure_master, null,['class'=>'form-control']) !!}
                                                    </td>
                                                    <td>
                                                        <span class="fa fa-trash btn btn-danger btn-view remove"></span>
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
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group row">
                            <div class="col-md-3 label-control text-right">
                                {!! Form::label('advice', 'Advice:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::textarea('advice', null,['class'=>'form-control','rows'=>'5','cols'=>'5']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group row">
                            <div class="col-md-3 label-control text-right">
                                {!! Form::label('plan_follow_up', 'Plan For Follow Up:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::textarea('plan_follow_up', null,['class'=>'form-control','rows'=>'5','cols'=>'5']) !!}
                            </div>
                        </div>
                    </div>    
                </div>
                <!-- NewBorn Examination -->
                <div class="col-md-11 col-sm-12">
                 <input type="hidden" name="print_flag" value="0" id="print_flag"/>

                 @if(!Session::has('registration_start'))
                 <div class="col-md-3 col-sm-4 col-xs-12">
                    <button type="button" class="btn btn-primary btn-block save-button-shadow form-control postnatal_discharge_btn" data-flag="1">
                        <i class="fa fa-floppy-o"></i> 
                        <span>{!! $SubmitButtonText !!}</span>
                    </button>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <button type="button" class="btn btn-block btn-info save-button-shadow form-control postnatal_discharge_btn" data-flag="2">
                        <i class="fa fa-floppy-o"></i>
                        <span>Update & Close</span>
                    </button>
                </div>

                <div class="col-md-3 col-sm-4 col-xs-12 hide">
                    <button type="button" class="btn btn-block btn-info save-button-shadow form-control postnatal_discharge_btn" data-flag="3">
                       <i class="fa fa-print"></i>
                       <span>Print</span>
                   </button>
               </div>
               <div class="col-md-3 col-sm-4 col-xs-12">
                <a href="{{ action('Admission\PostnatalDischargeController@index') }}" class="btn btn-default save-button-shadow btn-block form-control" onclick="$('form')[0].reset();">
                    <i class="fa fa-exclamation-circle"></i> 
                    <span>Cancel</span>
                </a>
            </div>
            @else 
            <div class="col-md-3 col-sm-4 col-xs-12">
                <button type="button" class="btn btn-block save-next save-button-shadow btn-info form-control"> 
                    <i class="fa fa-floppy-o"></i>
                    <span> 
                        @if(isset($temp_acive_menu) && $temp_acive_menu == 'Checkform' && isset($next_module) && $next_module == 'transfertonicu') 
                        Nicu Admission 
                        @elseif(isset($temp_acive_menu) && $temp_acive_menu == 'Checkform') 
                        Finish 
                        @else 
                        Next 
                        @endif
                    </span>
                </button>
            </div> 
            @if (isset($next_module) && $next_module != 'transfertonicu')
            <div class="col-md-3 col-sm-4 col-xs-12 @if(isset($temp_acive_menu) && $temp_acive_menu != 'Checkform') hide @endif print-tag">
             <a type="button" href="{{ $summaryLink }}" class="btn btn-block save-button-shadow btn-info form-control"> 
                <i class="fa fa-print"></i>
                <span> 
                    Print Summary 
                </span>
            </a>
        </div>
            @endif
        <div class="col-md-3 col-sm-4 col-xs-12">
            <a href="{{ action('Admission\PostnatalDischargeController@index') }}" class="btn btn-default save-button-shadow btn-block form-control" onclick="$('form')[0].reset();">
                <i class="fa fa-exclamation-circle"></i> 
                <span>Cancel</span>
            </a>
        </div>
        @endif 
    </div>
</div>
</div>
{!! Form::hidden('set_active','',['id'=>'set_active']) !!}
{!! Form::hidden('hospital_name',$hospital_name) !!}

{!! Form::close() !!}
</div>
</div>
@include('discharge.postnatal.postnatal_script')
@endsection
@section('scripts')
<script type="text/javascript">
        var next_module = $('input[name="next_module"]').val();
        var hospital_name = $('input[name="hospital_name"]').val();
        var required_status = (hospital_name == 'Saraswathi Nursing Home') ? false : true;
        console.log(required_status);
$( "#admissionProforma-form" ).validate({
  rules: {

      discharge_date:"required",
      dcg_weeks:"required",
      dcg_days:"required",
      discharge_wt: {
        required : true,
        omitZeros : true,
      },
      discharge_ofc: {
        required : required_status,
        omitZeros : true,
      },
      discharge_length: {
        required : required_status,
        omitZeros : true,
      }
   },
   messages:{
      discharge_wt:{
        omitZeros: 'Invalid Weight'
      },
      discharge_ofc:{
        omitZeros: 'Invalid OFC'
      },
      discharge_length:{
        omitZeros: 'Invalid Length'
      }
   },
    showErrors: function (errorMap, errorList) {

      if (typeof errorList[0] != "undefined") {
          var position = $(errorList[0].element).position().top;
          $('html, body').animate({
              scrollTop: position
          }, 300);
      }
      this.defaultShowErrors();
   }     
 });

    $("form").sisyphus({customKeySuffix: "nicu", locationBased: true});

    $('select[name="Vaccine[]"]').each(function() {
     $("."+$(this).attr('class')).select2({
        allowClear: true,
        dropdownAutoWidth : false,
        width: 'resolve' 
    });     
 });




    $('#discharge_date').on('change', function() {
        var dischargeDate = $(this).datepicker("getDate");
        var dob = $('#temp_dob').datepicker('getDate');
        var days = calculateDays(dob, dischargeDate);
        var g_weeks = $('input[name="g_weeks"]').val();
        var g_days = $('input[name="g_days"]').val();

        // correctedGestation(g_weeks, g_days, days, 'discharge');
        calculateCorrectedGestation();

        if (dischargeDate != null) {
            if (days >= 0) {
                $('#discharge_dol').val(days);
            } else {
                Showalert('error','Invalid Date of Discharge Please Check!');
            }
        }

    });

    $('.save-next').click(function() {
     var activeMenu  = $('.tabbable li[class="active"]').next('li').children('a').attr('aria-controls'); 
     setActiveMenu(activeMenu);
     var currentMenu = $('.tabbable li[class="active"]').children('a').attr('aria-controls');
     saveNext(currentMenu); 
        if (currentMenu =='Checkform' && next_module == 'transfertonicu') {
            $('.save-next span').text('Nicu Admission'); 
            $('input[name="print_flag"]').val(20);
        }
       $('input[name="temp_acive_menu"]').val(activeMenu);
     $('#admissionProforma-form').submit();

 });  

    $('.discharge-menu').click(function() {
        saveNext($(this).attr('aria-controls'));
    });  

    function setActiveMenu(activeMenu) {
     if (typeof activeMenu != 'undefined') {
       $('input[name="temp_acive_menu"]').val(activeMenu);
   }  
}

function saveNext(currentMenu) {

    if (typeof currentMenu != 'undefined') {
        if (currentMenu =='dischargeform') {

          $('.save-next span').text('Next');
          $('input[name="print_flag"]').val(1);

          if(!$('.print-tag').hasClass()){
             $('.print-tag').addClass('hide');
         }

     } else if(currentMenu =='Checkform') { 

        var next_module = $('input[name="next_module"]').val();
        if (next_module == 'transfertonicu') {
            $('.save-next span').text('Nicu Admission'); 
            $('input[name="print_flag"]').val(20);
        } else {
            $('.save-next span').text('Finish'); 
            $('input[name="print_flag"]').val(2);
        }

      if($('.print-tag').hasClass()){
         $('.print-tag').removeClass('hide');
     }

 }
}
}  

function getGentilafindings() {

   var list=['discharge_gentila_findings'];
   ($('#discharge_gentila').val() == 'Normal') ? makeDisable(list) : removeDisable(list); 
}

$('#discharge_gentila').change(function() {
   getGentilafindings();
});

getGentilafindings();

function typeofTreatements() {
  var l = $('select[name="TypeofTreatmen[]"]').length;
  var option  ='<tr>';
  option +='<td><select name="typeoftreatment_left[]" class="form-control" id="typeoftreatment_left'+l+'">';
  option +=$("select[name='TypeofTreatmentemp']").html();
  option +='</select></td>';
  option +='<td><select name="typeoftreatment_right[]" class="form-control" id="typeoftreatment_right'+l+'">';
  option +=$("select[name='TypeofTreatmentemp']").html();
  option +='</select></td>';
  option +='<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td></tr>';
  $("table.TypeofTreatmenDiv tbody").append(option);
}

$('.typeoftreatment_add').click(function() {
   typeofTreatements();

});
$(document).on('click', '.postnatal_discharge_btn', function(e){
    if ($('#admissionProforma-form').valid() === true) {
        e.preventDefault();
        var print_flag = $(this).data('flag');
        $('#print_flag').val(print_flag);
        $('.postnatal_discharge_btn').prop('disabled', true);
        var current_clicked_element = $(this);
        $(this).html('<i class="fas fa-spinner fa-pulse"></i> Loading...');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            data: $('#admissionProforma-form input, #admissionProforma-form select, #admissionProforma-form textarea').serialize(),
            url: "{{ action('Admission\PostnatalDischargeController@update',$id) }}",
            success: function (response) {
                if (print_flag == 3) {
                    Showalert('success', 'Postnatal discharge details updated successfully');
                    window.location.href = response.print_url;
                }
                else if(print_flag == 2)
                {
                    Showalert('success', 'Postnatal discharge details updated successfully');
                    window.location.href = response.list_url;
                }
                else
                {
                    Showalert('success', 'Postnatal Discharge details updated successfully');
                    current_clicked_element.html('<i class="fa fa-floppy-o" aria-hidden="true"></i> <span>Update</span>');
                    $('.postnatal_discharge_btn').prop('disabled', false);
                }
            },
            error: function()
            {
                Showalert('error', 'Something went wrong, Please try again later...!');
            }
        });
    }
});
</script>
@endsection

