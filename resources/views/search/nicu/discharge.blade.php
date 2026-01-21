<!-- Nav tabs -->
<div role="tabpanel" class="tabbable tabbable-custom">
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#dischargeform" aria-controls="dischargeform" role="tab" data-toggle="tab">Discharge Details</a>
        </li>
        <li role="presentation">
            <a href="#Checkform" aria-controls="Checkform" role="tab" data-toggle="tab">Checklist</a>
        </li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content tab-view-shadow nicu-table">
        <!-- Discharge -->
        <div role="tabpanel" class="tab-pane active" id="dischargeform">
            <div class="col-md-6 col-sm-6">
                <div class="mt-10 widget box">
                    <div class="widget-header">
                        <h4><i class="fa fa-reorder"></i> </h4>
                    </div>
                    <div class="widget-content">
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('status','Status:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('status',[''=>'N/A']+ValuelistHelpers::Discharge_Status(),@$results->patientStatus,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control mt-0">
                                {!! Form::label('DischargeDate','Date of Discharge / Transfered:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('DischargeDate',null,['class'=>'form-control datepicker record-date', 'readonly']) !!}
                            </div>
                        </div>
                        <div class="form-group row DiedTime">
                            <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                {!! Form::label('DiedTime','Time Of Death:') !!}
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
                                    {!! Form::select('diedTime',$NAT['time'],null,['class'=>'form-control']) !!}
                                </div>
                                <div class="col-xs-4">
                                    {!! Form::select('diedMins',$NAT['mins'],null,['class'=>'form-control']) !!}
                                </div>
                                <div class="col-xs-4">
                                    {!! Form::select('diedAm',[''=>'N/A','AM'=>'AM','PM'=>'PM'],null,['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('DOLatDischarge','DOL at Discharge:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('DOLatDischarge',null,['class'=>'form-control']) !!}
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
                                    {!! Form::text('g_weeks',null,['class'=>'form-control','max'=>'46',]) !!}
                                </div>
                                <div class="inbeween_two_fields">
                                    <span>+</span>
                                </div>
                                <div>
                                    <small>(In Days)</small>
                                    {!! Form::text('g_days',null,['class'=>'form-control','max'=>'6']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control" style="margin-top: 5px;">
                            {!! Form::label('CorrectedGestation','Corrected Gestation at discharge:') !!}
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
                        <div class="col-md-3 text-right label-control mt-0">
                            {!! Form::label('DischargeWeight','Discharge Weight (In grams):') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('DischargeWeight',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('OFC','OFC in cm:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('OFC',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('Length','Length in cm:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('Length',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('Immunization','Immunization:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('Immunization',[''=>'N/A','Due'=>'Due','Given'=>'Given'],null,['class'=>'form-control','rows'=> 4,'data-color'=>ValuelistHelpers::setColorvalue('Immunization',2)]) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('Schedule','Schedule:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('Schedule',[''=>'N/A','At birth'=>'At birth','6 wks'=>'6 wks','10 wks'=>'10 wks','14 wks'=>'14 wks','6 mths'=>'6 mths','9 mths'=>'9 mths','1 year'=> '1 year','15 mths'=>'15 mths','16-18 mths'=>'16-18 mths','18 mths'=>'18 mths','2 years'=>'2 years','5 years'=>'5 years','Optional'=>'Optional','Catch Up'=>'Catch Up'],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="hidden">
                        {!! Form::select('temp_Vaccine',['N/A'=>'N/A']+ValuelistHelpers::Vaccine(),'',["class"=>"form-control "]) !!}
                    </div>
                    <div class="form-group row mx-0">
                        <table class="vaccine table table-add-more full-width-fix">
                            <thead class="master-add-header">
                                <tr>
                                    <th>
                                        Vaccine
                                    </th>
                                    <th>Date <i class="fa fa-info-circle bs-tooltip color-white-must" data-placement="right"
                                        data-original-title="Date Format DD-MM-YYYY"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($vaccine) && count($vaccine) > 0)
                                    @php 
                                    $vaccine = \SiteHelpers::arrayKeyConversion($vaccine);
                                    $vaccine_date = \SiteHelpers::arrayKeyConversion($vaccine_date);
                                    @endphp
                                    @foreach($vaccine as $key => $value)
                                    <tr>
                                        <td class="form-group full-width">{!! Form::select('Vaccine['.$key.']',['N/A'=>'N/A']+ValuelistHelpers::Vaccine(),$vaccine[$key],['class'=>'select2-select-00 full-width']) !!}
                                        </td>
                                        @php $vaccine_date[$key] = (isset($vaccine_date[$key]) && !empty($vaccine_date[$key]) && $vaccine_date[$key] != 'null' && $vaccine_date[$key] != null && !@unserialize($vaccine_date[$key]) !== false) ? $vaccine_date[$key] : '' @endphp
                                        <td class="form-group"> {!! Form::text('VaccineDate['.$key.']',$vaccine_date[$key],['class'=>'input-width-small form-control datepicker ', 'readonly']) !!}
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td class="form-group full-width"> {!! Form::select('Vaccine[]',['N/A'=>'N/A']+ValuelistHelpers::Vaccine(),null,['class'=>'select2-select-00 full-width']) !!}
                                        </td>
                                        @php $results->VaccineDate = (isset($results->VaccineDate) && $results->VaccineDate != 'null' && $results->VaccineDate != null && !@unserialize($results->VaccineDate) !== false) ? $results->VaccineDate : '' @endphp
                                        <td class="form-group"> {!! Form::text('VaccineDate[]',null,['class'=>'input-width-small form-control datepicker ', 'readonly']) !!}
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('additional_information', 'Additional Information:') !!}
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
                        <div class="form-group row">
                            <h3 class="mt-0 text-center">
                                <strong>
                                    Discharge Examination
                                </strong>
                            </h3>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('Eyes','Eyes:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('Eyes',[''=>'N/A','Normal with Red reflex'=>'Normal with Red reflex','Subconjunctival Hemorrhage'=>'Subconjunctival Hemorrhage','Cataract'=>'Cataract','Microophthalmos'=>'Microophthalmos'],null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('cardiacmurmur', 'Cardiac Murmur') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('cardiacmurmur',[''=>'N/A','Absent'=>'Absent','Present'=>'Present'], null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('HearingScreening',2)]) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control mt-0">
                                {!! Form::label('PostductalSaturation','Postductal(SPO2 %):') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('PostductalSaturation',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('discharge_femoral_pulses','Femoral:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('discharge_femoral_pulses',[''=>'N/A','Normal'=>'Normal','Bounding'=>'Bounding','Feeble/Weak'=>'Feeble/Weak','Absent'=>'Absent'],null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('Hips','Hips:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('Hips',[''=>'N/A','Normal'=>'Normal','DDH Rt'=>'DDH Rt','DDH Lt'=>'DDH Lt','DDH Bilateral'=>'DDH Bilateral'],null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('gentila','Genitalia:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('gentila',[''=>'N/A']+ValuelistHelpers::getGentila(),null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('gentila',2)]) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('gentila_findings', 'Genitalia Findings:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('gentila_findings',null,['class'=>'form-control'])!!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('nicu_malformation','Malformation:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('nicu_malformation',[''=>'N/A','No'=>'No','Yes'=>'Yes'],null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('nicu_malformation_details','Malformation Details:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::textarea('nicu_malformation_details',null,['class'=>'form-control','rows'=>'5']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control mt-0">
                                {!! Form::label('FeedingAtDischarge','Feeding At Discharge:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('FeedingAtDischarge',ValuelistHelpers::feedingDischarge(),null,['class'=>'form-control','rows' => 4])
                                !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('NeurologicalStatus','Neurological Status:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('NeurologicalStatus',[''=>'N/A','Normal'=>'Normal','Suspect'=>'Suspect','Abnormal'=>'Abnormal'],null,['class'=>'form-control','rows'=>5,'data-color'=>ValuelistHelpers::setColorvalue('NeurologicalStatus',2)]) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control mt-0">
                                {!! Form::label('NextAppointmentStatus','Next Appointment:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('NextAppointmentStatus',[''=>'N/A','Yes'=>'Yes','No'=>'No'],null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control mt-0">
                                {!! Form::label('NextAppointment','Next Appointment Date:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('NextAppointment',null,['class'=>'form-control datepicker', 'readonly']) !!}
                            </div>
                        </div>
                        <div class="form-group row NextAppointmentTime">
                            <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                {!! Form::label('NextAppointmentTime','Next Appointment Time:') !!}
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
                                        {!! Form::select('NAT_TIME',$NAT['time'],null,['class'=>'form-control']) !!}
                                    </div>
                                    <div class="col-xs-4">
                                        {!! Form::select('NAT_MINS',$NAT['mins'],null,['class'=>'form-control']) !!}
                                    </div>
                                    <div class="col-xs-4">
                                        {!! Form::select('NAT_AM',[''=>'N/A','AM'=>'AM','PM'=>'PM'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mx-0">
                <div class="col-md-12 col-sm-12 overflow-auto">
                    <h3>Medications
                    </h3>
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
                            @php $mas_frequency_list = ValuelistHelpers::drugFrequencyList(); @endphp
                            @if (isset($medications) && (count($medications) > 0))
                            @php $l = 0; @endphp
                            @foreach ($medications as $key => $medi_data)
                            @php $medi_data = (array)$medi_data; @endphp
                            <tr>
                                <td>{!! Form::select('M_Drugs['.$key.']',$drug_master,$medi_data['Medication'],['class'=>'drugs-changes drug-list-name'.$l,'data-id'=>$l, 'style'=>'width: 300px;']) !!}</td>
                                <td>{!! Form::text('m_generic_name['.$key.']',$medi_data['genericname'],['class'=>'form-control generic_name'.$l]) !!}</td>
                                <td>{!! Form::select('formulation['.$key.']',ValuelistHelpers::formulationStrength($medi_data['formulation']),$medi_data['formulation'],['class'=>'form-control formulation'.$l]) !!}</td>
                                <td class="input-width-medium">{!! Form::select('M_Dose['.$key.']',[''=>'N/A']+ValuelistHelpers::dose(),$medi_data['Dose'],['class'=>'form-control']) !!}</td>
                                <td class="input-width-medium">{!! Form::select('M_Frequency['.$key.']',[''=>'N/A']+$mas_frequency_list,$medi_data['Frequency'],['class'=>'form-control']) !!}</td>
                                <td class="input-width-medium">
                                    {!! Form::select('M_Duration['.$key.']',[''=>'N/A']+ValuelistHelpers::medicationDuration(),$medi_data['Duration'],['class'=>'form-control']) !!}
                                </td>
                                <td>{!! Form::textarea('additional_instruction['.$key.']',$medi_data['additional_instruction'],['class'=>'form-control', 'rows'=>1]) !!}</td>                                        
                            </tr>
                            @php $l++; @endphp
                            @endforeach
                            @else
                            <tr>
                                <td>
                                    {!! Form::select('M_Drugs[]',[' '=>'N/A']+$drug_master,null,['class'=>'drugs-changes drug-list-name0','data-id'=>'0', 'style'=>'width: 300px;']) !!}
                                </td>
                                <td>
                                    {!! Form::text('m_generic_name[]',null,['class'=>'form-control generic_name0']) !!}
                                </td>
                                <td class="input-width-medium">
                                    {!! Form::select('formulation[]',[''=>'N/A'],null,['class'=>'form-control formulation0']) !!}
                                </td>
                                <td class="input-width-medium">
                                    {!! Form::select('M_Dose[]',[''=>'N/A']+ValuelistHelpers::dose(),null,['class'=>'form-control']) !!}
                                </td>
                                <td class="input-width-medium">
                                    {!! Form::select('M_Frequency[]',[''=>'N/A']+$mas_frequency_list,null,['class'=>'form-control'])!!}
                                </td>
                                <td>{!! Form::select('M_Duration[]',[''=>'N/A']+ValuelistHelpers::medicationDuration(),null,['class'=>'form-control']) !!}</td>
                                <td>{!! Form::textarea('additional_instruction[]',null,['class'=>'form-control', 'rows'=>1]) !!}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="Checkform">
            <div class="col-md-6 col-sm-6">
                <div class="mt-10 widget box">
                    <div class="widget-header">
                        <h4><i class="fa fa-reorder"></i> </h4>
                    </div>
                    <div class="widget-content">
                        <div class="form-group row mx-0">
                            <h3 class="mt-0 text-center">Discharge Blood Tests</h3>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('DischargeHb','Hb(g/dl):') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('DischargeHb',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('DischargePCV','PCV:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('DischargePCV',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('NicuDCT','DCT:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('NicuDCT',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control mt-0">
                                {!! Form::label('DischargeTSB','Total Serum Bilirubin (mg/dl):') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('DischargeTSB',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control mt-0">
                                {!! Form::label('direct_bilirubin','Direct Bilirubin (mg/dl):') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('direct_bilirubin',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('DischargeSerumCa','Ca (mg/dl):') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('DischargeSerumCa',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('DischargeSerumPo4','Po4 (mg/dl):') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('DischargeSerumPo4',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('DischargeSerumALP','ALP (IU/L):') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('DischargeSerumALP',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('DischargeSerumNa','Na (mmol/l):') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('DischargeSerumNa',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('HomeOxygen','Home Oxygen:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('HomeOxygen',[''=>'N/A','Yes'=>'Yes','No'=>'No'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('HomeOxygen',2)]) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('discharge_cuss','Cranial Ultrasound:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('discharge_cuss',[''=>'N/A','Normal'=>'Normal','Abnormal'=>'Abnormal','Not Indicated'=>'Not Indicated'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('DischargeCUSS',2)]) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('cranial_ultrasound', 'Cranial Ultrasound:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::textarea('cranial_ultrasound', null,['class'=>'form-control editer-required','rows'=>'5','cols'=>'5']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('echocardiography_status','Echo Cardiography:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('echocardiography_status',[''=>'N/A','Normal'=>'Normal','Abnormal'=>'Abnormal','Not Indicated'=>'Not Indicated'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('DischargeCUSS',2)]) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('echocardiography', 'Echo Cardiography:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::textarea('echocardiography', null,['class'=>'form-control editer-required','rows'=>'5','cols'=>'5']) !!}
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
                                {!! Form::label('NicuNewBornScreen','Newborn Screen:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('NicuNewBornScreen',[""=>"N/A",'Sent' => 'Sent','Not Sent'=>'Not
                                Sent','Normal'=>'Normal','Abnormal'=>'Abnormal'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('NicuNewBornScreen',2)]) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('HearingScreening','Hearing Screening:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('HearingScreening',[''=>'N/A','Performed' => 'Performed','To be performed as outpatient' => 'To be performed as outpatient','Not Indicated' => 'Not Indicated'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('HearingScreening',2)]) !!}
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
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('RopScreening','ROP Screening:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('RopScreening',[""=>"N/A",'Performed' => 'Performed','To be performed as outpatient' => 'To be performed as outpatient','Not Indicated' => 'Not Indicated'],null,['class'=>'form-control']) !!}
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
                                            <td>{!! Form::select('result_rop_left',ValuelistHelpers::RopScreening(),null,['class'=>'form-control rop-results-type']) !!}</td>
                                            <td>{!! Form::select('result_rop_right',ValuelistHelpers::RopScreening(),null,['class'=>'form-control rop-results-type']) !!}</td>
                                        </tr>
                                    </tbody>
                                </table> 
                            </div>
                        </div> 
                        <div class="form-group rop-results">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('ROPTreatment','ROP Treatment:') !!}
                            </div>
                            <div class="col-md-9 custom-input mb-15">
                                {!! Form::select('ROPTreatment',[''=>'N/A']+ValuelistHelpers::commonValues(),null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('ROPTreatment',2)]) !!}
                            </div>
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
                                    @php $results->typeoftreatment_left = isset($results->typeoftreatment_left) ? json_decode($results->typeoftreatment_left) : null ;  @endphp
                                    @php $results->typeoftreatment_right = isset($results->typeoftreatment_right) ? json_decode($results->typeoftreatment_right) : null ;  @endphp
                                    <tbody>
                                        @if(count($results->typeoftreatment_left) > 0)  
                                        @php $rop = 0; @endphp
                                        @foreach($results->typeoftreatment_left as $key => $typeoftreatment_left)
                                        <tr>
                                            <td>{!! Form::select('typeoftreatment_left['.$key.']',[''=>'N/A','Laser'=>'Laser','Cryotherapy'=>'Cryotherapy','Surgical'=>'Surgical'],$typeoftreatment_left,['class'=>'form-control rop_treatment-type','id'=>'typeoftreatment_left','data-color'=>ValuelistHelpers::setColorvalue('TypeofTreatmen',2)]) !!} </td>
                                            <td>{!! Form::select('typeoftreatment_right['.$key.']',[''=>'N/A','Laser'=>'Laser','Cryotherapy'=>'Cryotherapy','Surgical'=>'Surgical'],$results->typeoftreatment_right[$rop],['class'=>'form-control rop_treatment-type','id'=>'typeoftreatment_right','data-color'=>ValuelistHelpers::setColorvalue('TypeofTreatmen',2)]) !!}</td>
                                        </tr>
                                        @php $rop++; @endphp
                                        @endforeach
                                        @else
                                        <tr>
                                            <td>{!! Form::select('typeoftreatment_left[]',[''=>'N/A','Laser'=>'Laser','Cryotherapy'=>'Cryotherapy','Surgical'=>'Surgical'],null,['class'=>'form-control rop_treatment-type','id'=>'typeoftreatment_left','data-color'=>ValuelistHelpers::setColorvalue('TypeofTreatmen',2)]) !!} </td>
                                            <td>{!! Form::select('typeoftreatment_right[]',[''=>'N/A','Laser'=>'Laser','Cryotherapy'=>'Cryotherapy','Surgical'=>'Surgical'],null,['class'=>'form-control rop_treatment-type','id'=>'typeoftreatment_right','data-color'=>ValuelistHelpers::setColorvalue('TypeofTreatmen',2)]) !!}</td>
                                        </tr>
                                        @endif 
                                    </tbody>
                                </table> 
                            </div>
                        </div>
                        <div class="form-group row rop-results">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('rop_follow_up','ROP Follow Up:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('rop_follow_up',[''=>'N/A','1'=>'No','2'=>'Yes'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('rop_follow',2)]) !!}
                            </div>
                        </div>
                        <div class="hidden">
                            {!! Form::select('temp_procedures', [''=>'N/A']+$procedure_master, null,['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
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
                                        @if (isset($results->procedures))
                                        @php 
                                        $procedures_list = json_decode($results->procedures);
                                        $procedures_list = (array)$procedures_list;
                                        @endphp
                                        @if(count($procedures_list) > 0)
                                        @foreach($procedures_list as $key => $procedures)   
                                        <tr>
                                            <td>{!! Form::select('procedures['.$key.']', [''=>'N/A']+$procedure_master, $procedures,['class'=>'form-control']) !!}</td>
                                        </tr>
                                        @endforeach    
                                        @else
                                        <tr>
                                            <td>{!! Form::select('procedures[]', [''=>'N/A']+$procedure_master, null,['class'=>'form-control']) !!}</td>
                                        </tr>
                                        @endif 
                                        @else
                                        <tr>
                                            <td>{!! Form::select('procedures[]', [''=>'N/A']+$procedure_master, null,['class'=>'form-control']) !!}</td>
                                        </tr>
                                        @endif 
                                    </tbody>
                                </table> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('hospital_acquired_infection', 'Hospital acquired infection:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('hospital_acquired_infection', [''=>'-- Please Select --','Yes'=>'Yes','No'=>'No'],null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('ventilator_associated_pneumonia', 'Ventilator associated pneumonia:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('ventilator_associated_pneumonia', [''=>'-- Please Select --','Yes'=>'Yes','No'=>'No'],null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('blood_stream_infections','Blood stream infections:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('blood_stream_infections',[''=>'-- Please Select --','Yes'=>'Yes','No'=>'No'],null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12">
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('advice', 'Advice:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::textarea('advice', null,['class'=>'form-control','rows'=>'5','cols'=>'5']) !!}
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12">
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('plan_follow_up', 'Plan For Follow Up:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::textarea('plan_follow_up', null,['class'=>'form-control','rows'=>'5','cols'=>'5']) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-15">
            @if(isset($nicuList) && count($nicuList) < 1)
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary save-button-shadow btn-block form-control">
                    <i class="fa fa-floppy-o"></i> 
                    <span>Search</span>
                </button>
            </div>
            @endif
            <div class="col-md-6">
                <a href="{{ action('Admission\NicuController@dischargeList') }}" class="btn btn-default save-button-shadow btn-block form-control" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> 
                    <span>Cancel</span>
                </a>
            </div>
        </div>
    </div>
</div>
