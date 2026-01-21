<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active">
        <a href="#dischargeform" aria-controls="dischargeform" role="tab" data-toggle="tab">Discharge Details</a>
    </li>
    <li role="presentation">
        <a href="#Checkform" aria-controls="Checkform" role="tab" data-toggle="tab">Checklist</a>
    </li>
</ul>
<!-- Tab panes -->
<div class="tab-content tab-view-shadow post-table ptb-15">
    <!-- Discharge -->
    <div role="tabpanel" class="tab-pane active discharge-margin" id="dischargeform">
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
                            {!! Form::select('discharge_status',[''=>'N/A']+ValuelistHelpers::Discharge_Status(),null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('discharge_date','Date of Discharge / Transfered:') !!}
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
                                    {!! Form::select('diedTime',[''=>'N/A']+$timeList['time'],null,['class'=>'form-control input-width-small']) !!}
                                </div>
                                <div class="col-xs-4">
                                    {!! Form::select('diedMins',[''=>'N/A']+$timeList['mins'],null,['class'=>'form-control input-width-small']) !!}
                                </div>
                                <div class="col-xs-4">
                                    {!! Form::select('diedAm',[''=>'N/A']+$timeList['session'],null,['class'=>'form-control input-width-small']) !!}
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
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                            {!! Form::label('CorrectedGestation','Corrected Gestational Age:') !!}
                        </div>
                        <div class="col-md-9 custom-input clear-xs">
                            <div class="row col-md-12 display-flex">
                                <div>
                                    <small>(In Weeks)</small>
                                    {!! Form::text('dcg_weeks',null,['class'=>'form-control']) !!}
                                    <label class="error help-block" for="dcg_weeks" generated="true"></label> 
                                </div>
                                <div class="inbeween_two_fields">
                                    <span>+</span>
                                </div>
                                <div>
                                    <small>(In Days)</small>
                                    {!! Form::text('dcg_days',null,['class'=>'form-control']) !!}
                                    <label class="error help-block" for="dcg_days" generated="true"></label> 
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="form-group row">
                        <div class="col-md-3 label-control text-right">
                            {!! Form::label('discharge_wt','Discharge Weight (In grams):') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('discharge_wt',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 label-control text-right">
                            {!! Form::label('discharge_ofc','OFC in cm:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('discharge_ofc',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 label-control text-right">
                            {!! Form::label('discharge_length','Length in cm:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('discharge_length',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 label-control text-right">
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
                                        </th>
                                        <th>
                                            {!! Form::label('VaccineDate','Day') !!}
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
                        <div class="col-md-3 label-control text-right">
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
                        <div class="col-md-3 label-control text-right">
                            {!! Form::label('discharge_femorals','Femoral:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('discharge_femorals',[''=>'N/A','Normal'=>'Normal','Bounding'=>'Bounding','Feeble/Weak'=>'Feeble/Weak','Absent'=>'Absent'],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 label-control text-right">
                            {!! Form::label('discharge_hips','Hips:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('discharge_hips',[''=>'N/A','Normal'=>'Normal','DDH Rt'=>'DDH Rt','DDH Lt'=>'DDH Lt','DDH Bilateral'=>'DDH Bilateral'],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 label-control text-right">
                            {!! Form::label('discharge_gentila','Gentila:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('discharge_gentila',[''=>'N/A']+ValuelistHelpers::getGentila(),null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('gentila',2)]) !!}
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
                        <div class="col-md-3 label-control text-right">
                            {!! Form::label('discharge_malinformation','Malformation:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('discharge_malinformation',[''=>'N/A','No'=>'No','Yes'=>'Yes'],null,['class'=>'form-control']) !!}
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
                        <div class="col-md-3 label-control text-right">
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
                            {!! Form::select('appoinment_status',[''=>'N/A', 1=>'Yes', 0=>'No'],null,['class'=>'form-control']) !!}
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
                                    {!! Form::select('appoinment_hrs',[''=>'N/A']+$timeList['time'],null,['class'=>'form-control input-width-small']) !!}
                                </div>
                                <div class="col-xs-4">
                                    {!! Form::select('appoinment_min',[''=>'N/A']+$timeList['mins'],null,['class'=>'form-control input-width-small']) !!}
                                </div>
                                <div class="col-xs-4">
                                    {!! Form::select('appoinment_session',[''=>'N/A']+$timeList['session'],null,['class'=>'form-control input-width-small']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 overflow-auto">      
            <h3>Medications
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
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($medications) && (count($medications) > 0))
                            @php $l = 0; @endphp
                            @foreach ($medications as $key => $medi_data)
                            @php $medi_data = (array)$medi_data; @endphp
                            <tr>
                                <td>{!! Form::select('M_Drugs['.$key.']',['0'=>'N/A']+$drungList1,$medi_data['Medication'],['class'=>'drugs-changes drug-list-name'.$l,'data-id'=>$l, 'style'=>'min-width:300px;']) !!}</td>
                                <td>{!! Form::text('m_generic_name['.$key.']',$medi_data['genericname'],['class'=>'form-control generic_name'.$l]) !!}</td>
                                <td>{!! Form::select('formulation['.$key.']',ValuelistHelpers::formulationStrength($medi_data['formulation']),$medi_data['formulation'],['class'=>'form-control formulation'.$l]) !!}</td>
                                <td class="input-width-medium">{!! Form::select('M_Dose['.$key.']',[''=>'N/A']+ValuelistHelpers::dose(),$medi_data['Dose'],['class'=>'form-control']) !!}</td>
                                <td class="input-width-medium">{!! Form::select('M_Frequency['.$key.']',[''=>'N/A']+ValuelistHelpers::frequency(),$medi_data['Frequency'],['class'=>'form-control']) !!}</td>
                                <td class="input-width-medium">{!! Form::select('M_Duration['.$key.']',[''=>'N/A']+ValuelistHelpers::medicationDuration(),$medi_data['Duration'],['class'=>'form-control']) !!} </td>
                                <td>{!! Form::textarea('additional_instruction['.$key.']',$medi_data['additional_instruction'],['class'=>'form-control', 'rows'=>1]) !!}</td>                                        
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
                            </tr>
                            @endif
                        </tbody>
                    </table> 
                </div>
            </div>   
        </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="Checkform">
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
                        <div class="col-md-3 label-control text-right">
                            {!! Form::label('discharge_home_oxygen','Home Oxygen:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('discharge_home_oxygen',[''=>'N/A','Yes'=>'Yes','No'=>'No'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('HomeOxygen',2)]) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 label-control text-right">
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
                        <div class="col-md-3 label-control text-right">
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
                        <div class="col-md-3 label-control text-right">
                            {!! Form::label('discharge_new_born','Newborn Screen:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('discharge_new_born',[""=>"N/A",'Sent' => 'Sent','Not Sent'=>'Not Sent','Normal'=>'Normal','Abnormal'=>'Abnormal'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('NicuNewBornScreen',2)]) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 label-control text-right">
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
                        <div class="col-md-3 label-control text-right">
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
                        <div class="col-md-3 label-control text-right">
                            {!! Form::label('rop_treatment','ROP Treatment:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('rop_treatment',[''=>'N/A']+ValuelistHelpers::commonValues(),null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('ROPTreatment',2)]) !!}
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
                                    </tr>
                                </tbody>
                            </table> 
                        </div>
                    </div>  
                    <div class="form-group row">
                        <div class="col-md-3 label-control text-right">
                            {!! Form::label('rop_follow_up','ROP Follow Up:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('rop_follow_up',[''=>'N/A','1'=>'No','2'=>'Yes'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('rop_follow',2)]) !!}
                        </div>
                    </div>
                    <div class="hidden">
                        {!! Form::select('temp_procedures', $procedure_master, null,['class'=>'form-control']) !!}
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
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($dischargeList['procedures']) && is_array($dischargeList['procedures']) && count($dischargeList['procedures']) > 0)  
                                    @foreach($dischargeList['procedures'] as $key => $procedure)
                                    <tr>
                                        <td>
                                            {!! Form::select('procedures['.$key.']', $procedure_master, $procedure,['class'=>'form-control']) !!}
                                        </td>
                                    </tr>
                                    @endforeach   
                                    @else
                                    <tr>
                                        <td>
                                            {!! Form::select('procedures[]', $procedure_master, null,['class'=>'form-control']) !!}
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
    <div class="col-md-12 mt-15">
        @if(isset($postntallist) && count($postntallist) < 1)
        <div class="col-md-6">
            <button type="submit" class="btn btn-primary save-button-shadow btn-block form-control">
                <i class="fa fa-floppy-o"></i> 
                <span>Search</span>
            </button>
        </div>
        @endif
        <div class="col-md-6">
            <a href="{{ action('Admission\PostnatalDischargeController@index') }}" class="btn btn-default save-button-shadow btn-block form-control" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> 
                <span>Cancel</span>
            </a>
        </div>
    </div>
</div>