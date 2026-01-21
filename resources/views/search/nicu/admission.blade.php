        <!-- Nav tabs -->
        <div role="tabpanel" class="tabbable tabbable-custom">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#basicform" aria-controls="basicform" role="tab" data-toggle="tab">Basics</a>
                </li>
                <li role="presentation">
                    <a href="#historyform" aria-controls="historyform" role="tab" data-toggle="tab">Medical History</a>
                </li>
                <li role="presentation">
                    <a href="#pregform" aria-controls="pregform" role="tab" data-toggle="tab">Pregnancy</a>
                </li>
                <li role="presentation">
                    <a href="#babyform" aria-controls="babyform" role="tab" data-toggle="tab">Baby Details</a>
                </li>
                <li role="presentation">
                    <a href="#admissform" aria-controls="admissform" role="tab" data-toggle="tab">Admission Details</a>
                </li>
                <li role="presentation">
                    <a href="#Proform" aria-controls="Proform" role="tab" data-toggle="tab">Procedures</a>
                </li>
                <li role="presentation">
                    <a href="#Cribform" aria-controls="Cribform" role="tab" data-toggle="tab">CRIB II</a>
                </li>
                <li role="presentation">
                    <a href="#Snapform" aria-controls="Snapform" role="tab" data-toggle="tab">SNAPPE II</a>
                </li>
                <li role="presentation">
                    <a href="#Diagform" aria-controls="Diagform" role="tab" data-toggle="tab">Diagnosis</a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content tab-view-shadow ptb-15">
                <div class="tab-content tab-view-shadow nicu-table">
                    <!-- Basics Form -->
                    <div role="tabpanel" class="tab-pane active" id="basicform">
                        <div class="col-md-6 col-sm-6">
                            <div class="mt-10 widget box">
                                <div class="widget-header">
                                    <h4><i class="fa fa-reorder"></i> </h4>
                                </div>
                                <div class="widget-content">
                                    <!-- {!! Form::hidden('MotherId') !!} -->
                                    <!-- {!! Form::hidden('BabyId') !!} -->
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
                                            {!! Form::label('BMrNo', Lang::get('home.mrn').':') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::text('BMrNo',null,['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('DOB','DOB:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::text('DOB',null,['class'=>'form-control datepicker  birth-date', 'readonly']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control mt-0">
                                            {!! Form::label('BirthWeight','Birth Weight (In grams):') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::text('BirthWeight',null,['class'=>'form-control']) !!}
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
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control mt-0">
                                            {!! Form::label('BabyBloodGroup','Baby\'s Blood Group:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::text('BabyBloodGroup',null,['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('Sex','Sex:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::select('Sex',[''=>'N/A','Male'=>'Male','Female'=>'Female','Indeterminate'=>'Indeterminate'],null,['class'=>'form-control']) !!}
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
                                    @if (isset($results->g_weeks) && $results->g_weeks < 36 && $results->g_days <= 6)
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control" style="margin-top: 5px;">
                                            {!! Form::label('CorrectedGestation','Corrected Gestational Age:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input clear-xs">
                                            <div class="row col-md-12 display-flex">
                                                <div>
                                                    <small>(In Weeks)</small>
                                                    {!! Form::text('cg_weeks',null,['class'=>'form-control corrected-gestation-wks', 'onkeypress' => 'return ISNumber(event, this);']) !!}
                                                    <label class="error help-block" for="cg_weeks" generated="true"></label>
                                                </div>
                                                <div class="inbeween_two_fields">
                                                    <span>+</span>
                                                </div>
                                                <div>
                                                    <small>(In Days)</small>
                                                    {!! Form::text('cg_days',null,['class'=>'form-control corrected-gestation-days', 'onkeypress' => 'return ISNumber(event, this);']) !!}
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
                            <div class="mt-10 widget box">
                                <div class="widget-header">
                                    <h4><i class="fa fa-reorder"></i> </h4>
                                </div>
                                <div class="widget-content">
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('AdmissionDate','Admission Date:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::text('AdmissionDate',null,['class'=>'form-control']) !!}
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
                                                <div class="col-xs-4">
                                                    {!! Form::select('AdmissionTime',$NAT['time'],null,['class'=>'form-control ']) !!}
                                                </div>
                                                <div class="col-xs-4">
                                                    {!! Form::select('AdmissionTime_MINS',$NAT['mins'],null,['class'=>'form-control ']) !!}
                                                </div>
                                                <div class="col-xs-4">
                                                    {!! Form::select('AdmissionTime_AM',[''=>'N/A','AM'=>'AM','PM'=>'PM'],null,['class'=>'form-control ']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('TypeOfCare','Type Of Care:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::select('TypeOfCare',[''=>'N/A', 'Intensive Care'=>'Intensive Care','Special Care'=>'Special Care','Ward Admission'=>'Ward Admission','High Dependancy Care'=>'High Dependancy Care'],null,['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            <!-- {!! Form::hidden('visit_type', 'IP', ['id'=>'visit_type']) !!} -->
                                            {!! Form::label('ip_number', Lang::get('home.ip').':') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::text('ip_number',@$results->ip_number,['class'=>'form-control ip_number'])  !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('AdmissionWt','Admission Weight (In grams):') !!}
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
                                                    {!! Form::text('AgeOnAdmissioninDays',null,['class'=>'form-control', 'id'=> 'AgeOnAdmissioninDays', 'onkeypress' => 'return ISNumber(event, this);']) !!}
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="label-control">
                                                        Days
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row age_on_admission_hours">
                                                <div class="col-md-10">
                                                    {!! Form::text('AgeOnAdmissionhour',null,['class'=>'form-control', 'id' => 'AgeOnAdmissionhour', 'onkeypress' => 'return ISNumber(event, this);']) !!}
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="label-control">
                                                        Hours
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('Surgeon','Surgeon:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::select('Surgeon',[''=>'N/A','Not applicable'=>'Not applicable']+ValuelistHelpers::get_surgeons_lists(),null,['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                    <!-- <div class="hidden">
                                        {!! Form::select('seen_by',$doctor_master,null,['class'=>'form-control']) !!}
                                    </div>    -->                                  
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('SeenBy','Seen By:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <table class="seen-by-div table table-add-more full-width-fix">
                                                <thead>                                    
                                                    <tr class="master-add-header">
                                                        <th class="full-width">
                                                            <i class="fa fa-reorder"></i>Add More
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (isset($results->SeenBy))
                                                    @php
                                                    $seen_by = json_decode($results->SeenBy);
                                                    @endphp
                                                    @if(isset($seen_by) && !empty($seen_by) && count($seen_by) > 0)
                                                    @foreach($seen_by as $key => $seen_by)
                                                    <tr>
                                                        <td>
                                                            {!! Form::select('SeenBy['.$key.']',[''=>'N/A']+$doctor_master,$seen_by,['class'=>'form-control full-width']) !!}
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    @else 
                                                    <tr>
                                                        <td>
                                                            {!! Form::select('SeenBy[]',[''=>'N/A']+$doctor_master,null,['class'=>'form-control full-width']) !!}
                                                        </td>
                                                    </tr>
                                                    @endif 
                                                    @else 
                                                    <tr>
                                                        <td>
                                                            {!! Form::select('SeenBy[]',[''=>'N/A']+$doctor_master,null,['class'=>'form-control full-width']) !!}
                                                        </td>
                                                    </tr>
                                                    @endif 
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('hospital_name','Hospital Name:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::select('hospital_name',[''=>'N/A']+ValuelistHelpers::getHospitals(),null,['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                    {{--  @if ($results->status == 'NULL' || $results->status == 'Inpatient')
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('room_id','Room No.') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::select('room_id',[''=>'N/A']+ValuelistHelpers::getRoom(1),null,['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                    <input type="hidden" value="{{ json_encode(ValuelistHelpers::getBed(1)) }}" id="temp_bed_id" />
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('bed_id','Bed No.') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <input type="hidden" id="bed_id_old" value="{{ $results->bed_id }}" />
                                            <input type="hidden" id="bed_no_old" value="{{ $results->bed_no }}" />
                                            <input type="hidden" id="room_id_old" value="{{ $results->room_id }}" />
                                            {!! Form::select('bed_id',[''=>'N/A'],null,['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                    @endif --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- History Form -->
                    <div role="tabpanel" class="tab-pane" id="historyform">
                        <div class="mt-10 widget box row mx-0">
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
                                                    </th>
                                                    <th>Medications</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- <div class="hidden">
                                                    {!! Form::select('temp_medi_probs',$medi_probs_master,'') !!}
                                                </div> -->
                                                @if (isset($pbm_data) && count($pbm_data) > 0)
                                                @foreach ($pbm_data as $pdm_key => $data)
                                                <tr>
                                                    <td>{!! Form::select('Problems['.$pdm_key.']',[''=>'N/A']+$medi_probs_master,$data['Problem'],['class'=>'form-control input-width-xlarge']) !!}</td>
                                                    <td><input type="text" class="form-control input-width-xlarge" name="Medications[{{ $pdm_key }}]" value="{!! $data['Medication']; !!}"/></td>
                                                </tr>
                                                @endforeach
                                                @else
                                                <tr>
                                                    <td>{!! Form::select('Problems[]',[''=>'N/A']+$medi_probs_master,'',['class'=>'form-control input-width-xlarge']) !!}</td>
                                                    <td><input type="text" name="Medications[]" value="" class="form-control input-width-xlarge"/></td>
                                                </tr>
                                                @endif
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
                                                {!! Form::select('Smoking',[''=>'N/A','No'=>'No','Yes'=>'Yes'],null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('Alcohol','Alcohol:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('Alcohol',[''=>'N/A','No'=>'No','Yes'=>'Yes'],null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sm-6">
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                {!! Form::label('Tobacco','Tobacco:') !!}
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                {!! Form::select('Tobacco',[''=>'N/A','No'=>'No','Yes'=>'Yes'],null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="pregform">
                        <div class="mt-10 widget box row mx-0">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="col-md-9 form-group">
                                    <div class="col-md-12 custom-input">
                                        <table class="complication table table-add-more full-width-fix">
                                            <thead>
                                                <tr class="master-add-header">
                                                    <th>
                                                        Complication
                                                    </th>
                                                    <th>Treatment</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $complication_found = false; @endphp
                                                <!-- <div class="hidden">
                                                    {!! Form::select('temp_complications',$complication_master,'',["class"=>"form-control "]) !!}
                                                </div> -->
                                                @if (isset($neonatal_complication) && count($neonatal_complication) > 0)
                                                @foreach ($neonatal_complication as $neo_comp_key => $neonatal_data)
                                                @if(!empty($neonatal_data['Complication']))
                                                <tr>
                                                    <td class="half-width">{!! Form::select('Complication['.$neo_comp_key.']',[''=>'N/A']+$complication_master,$neonatal_data['Complication'],["class"=>"form-control","disabled"=>"true"]) !!}</td>
                                                    <td class="half-width"><input type="text" class="form-control" name="Treatments[{{ $neo_comp_key }}]" value="{!! $neonatal_data['Treatment']; !!}" disabled="true" /></td>
                                                </tr>
                                                @php $complication_found = true; @endphp
                                                @endif
                                                @endforeach
                                                @endif  
                                                @if (isset($complication) && count($complication) > 0)
                                                @foreach ($complication as $comp_key => $com_data)
                                                <tr>
                                                    <td class="half-width">{!! Form::select('Complication['.$comp_key.']',[''=>'N/A']+$complication_master,$com_data['Complication'],["class"=>"form-control"]) !!}</td>
                                                    <td class="half-width"><input type="text" class="form-control" name="Treatments[{{ $comp_key }}]" value="{!! $com_data['Treatment']; !!}"/></td>
                                                </tr>
                                                @endforeach
                                                @php $complication_found = true; @endphp
                                                @endif
                                                @if (isset($complication) && count($complication) == 0 && isset($neonatal_complication) && count($neonatal_complication) == 0)
                                                <tr>
                                                    <td class="half-width">{!! Form::select('Complication[]',[''=>'N/A']+$complication_master,'',["class"=>"form-control"]) !!}</td>
                                                    <td class="half-width"><input type="text" class="form-control" name="Treatments[]" value=""/></td>
                                                </tr>
                                                @php $complication_found = true; @endphp
                                                @endif
                                                @if (!$complication_found)
                                                <tr>
                                                    <td class="half-width">{!! Form::select('Complication',[''=>'N/A']+$complication_master,'',["class"=>"form-control"]) !!}</td>
                                                    <td class="half-width"><input type="text" class="form-control" name="Treatments" value=""/></td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <h3><br><u><b>Antenatal Ultrasound Findings</b></u> </h3>
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
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $further_found = false; @endphp
                                                    @if(isset($neonatalOtherscan) && count($neonatalOtherscan) > 0)
                                                    @foreach(array_values($neonatalOtherscan) as $otherscanKey => $otherscanValue)
                                                    <tr>
                                                        <td  class="form-group"> <input type="text" value="{{ @unserialize($otherscanValue['date']) !== false ? '' : ((isset($otherscanValue['date']) && !empty($otherscanValue['date']) && !is_null($otherscanValue['date'])) ? date('d-m-Y', strtotime($otherscanValue['date'])) : '') }}" class="form-control input-width-medium"  name="notherdate[{{ $otherscanKey }}]" @if(isset($otherscanValue['date']) && !empty($otherscanValue['date'])) disabled="true" @endif readonly/></td>
                                                        <td  class="form-group"> <input type="text" value="{{ @unserialize($otherscanValue['Gestation']) !== false ? '' : $otherscanValue['Gestation'] }}" class="form-control input-width-medium"  name="nothergestations[{{ $otherscanKey }}]" id="gestations" disabled="true"/></td>
                                                        <td  class="form-group"> <input type="text"  value="{{ @unserialize($otherscanValue['Finding']) !== false ? '' : $otherscanValue['Finding'] }}" name="notherfindings[{{ $otherscanKey }}]" class="form-control input-width-large" disabled="true" /></td>
                                                    </tr>
                                                    @endforeach
                                                    @php $further_found = true; @endphp
                                                    @endif    
                                                    @if(isset($otherScan) && count($otherScan) > 0)
                                                    @foreach(array_values($otherScan) as $scanKey => $scanValue)
                                                    <tr>
                                                        <td  class="form-group"><input type="text" value="{{ @unserialize($scanValue['date']) !== false ? '' : ((isset($scanValue['date']) && !empty($scanValue['date']) && !is_null($scanValue['date'])) ? date('d-m-Y', strtotime($scanValue['date'])) : '') }}" class="form-control input-width-medium"  name="otherdate[{{ $scanKey }}]" readonly /></td>
                                                        <td  class="form-group"><input type="text" value="{{ @unserialize($scanValue['Gestation']) !== false ? '' : $scanValue['Gestation'] }}" class="form-control input-width-medium"  name="othergestations[{{ $scanKey }}]" id="gestations" /></td>
                                                        <td  class="form-group"><input type="text"  value="{{ @unserialize($scanValue['Finding']) !== false ? '' : $scanValue['Finding'] }}" name="otherfindings[{{ $scanKey }}]" class="form-control input-width-large"  /></td>
                                                    </tr>
                                                    @endforeach
                                                    @php $further_found = true; @endphp
                                                    @endif
                                                    @if (isset($neonatalOtherscan) && count($neonatalOtherscan) == 0 && isset($otherScan) && count($otherScan) == 0)
                                                    <tr>
                                                        <td  class="form-group"><input type="text" class="form-control input-width-medium"  name="otherdate[]" readonly /></td>
                                                        <td  class="form-group"><input type="text" class="form-control input-width-medium"  name="othergestations[]" /></td>
                                                        <td  class="form-group"><input type="text" name="otherfindings[]" class="form-control input-width-large" /></td>
                                                    </tr>
                                                    @php $further_found = true; @endphp
                                                    @endif
                                                    @if (!$further_found)
                                                    <tr>
                                                        <td  class="form-group"><input type="text" class="form-control input-width-medium"  name="otherdate" readonly /></td>
                                                        <td  class="form-group"><input type="text" class="form-control input-width-medium"  name="othergestations" /></td>
                                                        <td  class="form-group"><input type="text" name="otherfindings" class="form-control input-width-large" /></td>
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
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $doppler_found = false; @endphp
                                                    @if(isset($neonatalDopplerscan) && count($neonatalDopplerscan) > 0)
                                                    @foreach($neonatalDopplerscan as $dopplerscanKey => $dopplerscanValue)
                                                    <tr>
                                                        <td  class="form-group"> <input type="text" value="{{ (isset($dopplerscanValue['date']) && !empty($dopplerscanValue['date']) && !is_null($dopplerscanValue['date'])) ? date('d-m-Y', strtotime($dopplerscanValue['date'])) : '' }}" class="form-control input-width-medium"  name="nodate[{{ $dopplerscanKey }}]" @if(isset($dopplerscanValue['date']) && !empty($dopplerscanValue['date'])) disabled="true" @endif readonly/></td>
                                                        <td  class="form-group"> <input type="text" value="{{ $dopplerscanValue['Gestation'] }}" class="form-control input-width-medium"  name="nothergestations[{{ $dopplerscanKey }}]" id="gestations" disabled="true"/></td>
                                                        <td  class="form-group"> <input type="text"  value="{{ $dopplerscanValue['Finding']  }}" name="notherfindings[{{ $dopplerscanKey }}]" class="form-control input-width-large" disabled="true" /></td>
                                                    </tr>
                                                    @endforeach
                                                    @php $doppler_found = true; @endphp
                                                    @endif    
                                                    @if (isset($dopplerScan) && count($dopplerScan) > 0)
                                                    @foreach($dopplerScan as $dopplerKey => $dopplerValue)
                                                    <tr>
                                                        <td  class="form-group"><input type="text" value="{{ (isset($dopplerValue['date']) && !empty($dopplerValue['date']) && !is_null($dopplerValue['date'])) ? date('d-m-Y', strtotime($dopplerValue['date'])) : '' }}" class="form-control input-width-medium"  name="dopplerdate[{{$dopplerKey}}]" readonly /></td>
                                                        <td  class="form-group"><input type="text" value="{{ $dopplerValue['Gestation'] }}" class="form-control input-width-medium"  name="dopplergestations[{{$dopplerKey}}]" /></td>
                                                        <td  class="form-group"><input type="text"  value="{{ $dopplerValue['Finding']  }}" name="dopplerfindings[{{$dopplerKey}}]" class="form-control input-width-large"  /></td>
                                                    </tr>
                                                    @endforeach
                                                    @php $doppler_found = true; @endphp
                                                    @endif
                                                    @if (isset($neonatalDopplerscan) && count($neonatalDopplerscan) == 0 && isset($dopplerScan) && count($dopplerScan) == 0)
                                                    <tr>
                                                        <td  class="form-group"><input type="text" class="form-control input-width-medium"  name="dopplerdate[]" readonly /></td>
                                                        <td  class="form-group"><input type="text" class="form-control input-width-medium"  name="dopplergestations[]" /></td>
                                                        <td  class="form-group"><input type="text" name="dopplerfindings[]" class="form-control input-width-large"  /></td>
                                                    </tr>
                                                    @php $doppler_found = true; @endphp
                                                    @endif
                                                    @if (!$doppler_found)
                                                    <tr>
                                                        <td  class="form-group"><input type="text" class="form-control input-width-medium"  name="dopplerdate" readonly /></td>
                                                        <td  class="form-group"><input type="text" class="form-control input-width-medium"  name="dopplergestations" /></td>
                                                        <td  class="form-group"><input type="text" name="dopplerfindings" class="form-control input-width-large"  /></td>
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
                    <div role="tabpanel" class="tab-pane" id="babyform">
                        <div class="col-md-6 col-sm-6">
                            <div class="mt-10 widget box">
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
                                            <hr class="mt-0" />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('VentilationRequired','Invasive Ventilation Required:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::select('VentilationRequired', [''=>'N/A', 'No'=>'No', 'Yes'=>'Yes'], null,['class'=>'form-control']) !!}
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
                                            {!! Form::text('DateofAdministration',null,['class'=>'form-control admission-date', 'readonly' => 'true']) !!}
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
                                                    {!! Form::select('TimeOfAdministration',$NAT['time'],null,['class'=>'form-control ','id'=>'TimeOfAdministration']) !!} 
                                                </div>
                                                <div class="col-xs-4">
                                                    {!!
                                                    Form::select('TimeOfAdministration_MINS',$NAT['mins'],null,['class'=>'form-control
                                                    ','id'=>'TimeOfAdministration_MINS']) !!}
                                                </div>
                                                <div class="col-xs-4">
                                                    {!!
                                                    Form::select('TimeOfAdministration_AM',[''=>'N/A','AM'=>'AM','PM'=>'PM'],null,['class'=>'form-control
                                                    ','id'=>'TimeOfAdministration_AM']) !!}
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
                                            {!! Form::select('delivery_cpap', [''=>'N/A','No'=>'No', 'Yes'=>'Yes'],null, ['class'=>'form-control']) !!}
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
                                                    <td>{!! Form::text('air_flow',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']) !!}</td>
                                                    <td>{!! Form::text('oxgen_flow',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']) !!}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <label for="air_flow" generated="true" class="error help-block"></label>
                                    <label for="oxgen_flow" generated="true" class="error help-block"></label>
                                    <div class="form-group row mx-0">
                                        <div class="col-md-12">
                                            {!! Form::label('TransferFiO2','Calculated / Actual FIO2% During Transfer:') !!}
                                        </div>
                                        <div class="col-md-12">
                                            {!! Form::text('TransferFiO2',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Admission Form -->
                    <div role="tabpanel" class="tab-pane" id="admissform">
                        <div class="col-md-6 col-sm-6">
                            <div class="mt-10 widget box">
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
                                            {!! Form::select('Ventilation', [''=>'N/A','No'=>'No','Yes'=>'Yes'], null, ['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('Mode','Mode:') !!}
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
                                            {!! Form::text('Pip',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('PEEP','PEEP:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::text('PEEP',null,['class'=>'form-control' , 'onkeypress' => 'return isNumber(event, this);']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('amplitude_delta','Amplitude &delta; :') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::text('amplitude_delta',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('mean_airway_pressure','Mean Airway Pressure:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::text('mean_airway_pressure',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']) !!}
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
                                            {!! Form::text('Rate',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']) !!}
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
                                            {!! Form::text('IT',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('Flow_l_min','Flow (L/Min):') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::text('Flow_l_min',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('RR','RR:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::text('RR',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']) !!}
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
                                            {!! Form::select('nicu_color',[''=>'N/A','Pink' => "Pink",'Yellow'=>'Yellow','Pale'=>'Pale',"Acral Cyanosis"=>"Acral Cyanosis","Central Cyanosis"=>"Central Cyanosis"],null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('Color')]) !!}
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
                                            {!! Form::select('nicu_genitalia',[''=>'N/A']+ValuelistHelpers::getGentila(),null,['class'=>'form-control']) !!}
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
                                            {!! Form::select('nicu_pupils',[''=>'N/A']+ValuelistHelpers::getPupils(),null,['class'=>'form-control']) !!}
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
                                            {!! Form::select('nicu_cry',["" => "N/A","Normal consolable" => "Normal consolable","Abnormal Inconsolable" => "Abnormal Inconsolable","High pitched cry" => "High pitched cry","Weak Cry" => "Weak Cry","Sedated/Paralysed" => "Sedated/Paralysed"],null,['class'=>'form-control']) !!}
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
                                            Form::select('InitialBloodGas',[''=>'N/A','Not done'=>'Not done','Not indicated'=>'Not indicated','Arterial'=>'Arterial','Venous'=>'Venous','Capillary'=>'Capillary'],null,['class'=>'form-control '])
                                            !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                            {!! Form::label('AgeTaken','Age in hours at the time of blood gas:') !!}
                                        </div>
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
                                                    {!! Form::select('age_hours',$NAT['time'],null,['class'=>'form-control ']) !!}
                                                </div>
                                                <div class="col-xs-6">
                                                    {!! Form::select('age_mins',$NAT['mins'],null,['class'=>'form-control ']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('SpO2','SpO2 (%):') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::text('SpO2',null,['class'=>'form-control', 'onkeypress' => 'return ISNumber(event, this);']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('pH','pH:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::text('pH',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('PaO2','PaO2:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::text('PaO2',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('PaCo2','PaCo2:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::text('PaCo2',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('HCO3','HCO3:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::text('HCO3',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']) !!}
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
                                            {!! Form::text('RBS',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('Hct','Hct:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::text('Hct',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Procedure Form-->
                    <div role="tabpanel" class="tab-pane" id="Proform">
                        <div class="col-md-6 col-sm-6">
                            <div class="mt-10 widget box">
                                <div class="widget-header">
                                    <h4><i class="fa fa-reorder"></i> </h4>
                                </div>
                                <div class="widget-content">
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('InitialXray','Initial X ray:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::select('InitialXray',[''=>'N/A','Not done' => 'Not done','Not indicated' =>'Not indicated','Performed'=> 'Performed'],null,['class'=>'form-control']) !!}
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
                                            {!! Form::select('UAC', [''=>'N/A', 'No'=>'No', 'Yes'=>'Yes'],null,['class'=>'form-control']) !!}
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
                                            {!! Form::select('UVC',[''=>'N/A', 'No'=>'No', 'Yes'=>'Yes'],null, ['class'=>'form-control']) !!}
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
                            <div class="mt-10 widget box">
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
                                    <!-- <div class="hidden">
                                        {!! Form::select('IVAntibiotic',[''=>'N/A']+ValuelistHelpers::getDrugIvFluidsAntibiotic(),null,['class'=>'form-control  input-width-large']) !!}
                                    </div> -->
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('IVAntibiotic','IV Antibiotic:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <table class="IVAntibiotic table table-add-more">
                                                <thead>                                    
                                                    <tr class="master-add-header">
                                                        <th class="full-width">
                                                            <i class="fa fa-reorder"></i>Add More
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(isset($results->IVAntibiotic) && count($results->IVAntibiotic)>1)
                                                    @foreach($results->IVAntibiotic as $key => $iv)
                                                    <tr>
                                                        <td class="full-width">{!! Form::select('IVAntibiotic[]',[''=>'N/A']+ValuelistHelpers::getDrugIvFluidsAntibiotic(),$iv,['class'=>'form-control full-width']) !!}</td>
                                                    </tr>
                                                    @endforeach 
                                                    @else
                                                    <tr>
                                                        <td class="full-width">{!! Form::select('IVAntibiotic[]',[''=>'N/A']+ValuelistHelpers::getDrugIvFluidsAntibiotic(),'',['class'=>'form-control full-width']) !!}</td>
                                                    </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('investigations_test','Investigations:') !!}
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
                                            <!-- {!! Form::hidden('investigation_order', null) !!} -->
                                            {!! Form::textarea('Investigations', null,['class'=>'form-control', 'rows'=>3]) !!}                                        
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('NBM','Enteral Feeding:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::select('NBM',[''=>'N/A','Yes'=>'Yes','No'=>'No'],null,['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control mt-0">
                                            {!! Form::label('Fluids','Fluids/Feeds ml/kg/d:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::text('Fluids',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- CRIB FORM -->
                    <div role="tabpanel" class="tab-pane" id="Cribform">
                        <div class="col-md-6 col-sm-6">
                            <div class="mt-10 widget box">
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
                    <div role="tabpanel" class="tab-pane" id="Snapform">
                        <div class="col-md-6 col-sm-6">
                            <div class="mt-10 widget box">
                                <div class="widget-header">
                                    <h4><i class="fa fa-reorder"></i> </h4>
                                </div>
                                <div class="widget-content">
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('MBP','MBP:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::select('MBP',[''=>'N/A','0'=>'0','9'=>'9','19'=>'19'],null,['class'=>'form-control GetSNAP2Score GetSNAPPE2Score']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control mt-0">
                                            {!! Form::label('LowestTemperature','Lowest Temperature:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::select('LowestTemperature',[''=>'N/A','0'=>'0','8'=>'8','15'=>'15'],null,['class'=>'form-control GetSNAP2Score GetSNAPPE2Score']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('Po2Fio2Ratio','Po2 Fio2 Ratio:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::select('Po2Fio2Ratio',[''=>'N/A','0'=>'0','5'=>'5','16'=>'16','28'=>'28'],null,['class'=>'form-control GetSNAP2Score GetSNAPPE2Score']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('LowestSerumPh','Lowest Serum Ph:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::select('LowestSerumPh',[''=>'N/A','0'=>'0','7'=>'7','16'=>'16'],null,['class'=>'form-control GetSNAP2Score GetSNAPPE2Score']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('MultipleSeizures','Multiple Seizures:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::select('MultipleSeizures',[''=>'N/A','0'=>'0','19'=>'19'],null,['class'=>'form-control GetSNAP2Score GetSNAPPE2Score']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('UrineOutput','Urine Output:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::select('UrineOutput',[''=>'N/A','0'=>'0','5'=>'5','18'=>'18'],null,['class'=>'form-control GetSNAP2Score GetSNAPPE2Score']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('BWeight','Birth Weight:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::select('BWeight',[''=>'N/A','0'=>'0','10'=>'10','17'=>'17'],null,['class'=>'form-control GetSNAPPE2Score']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control mt-0">
                                            {!! Form::label('SgaLessThan3rdPercentile','Small for Gestational Age:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::select('SgaLessThan3rdPercentile',[''=>'N/A','0'=>'0','12'=>'12'],null,['class'=>'form-control GetSNAPPE2Score']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('Apgar5Mins','Apgar5Mins:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::select('Apgar5Mins',[''=>'N/A','0'=>'0','18'=>'18'],null,['class'=>'form-control GetSNAPPE2Score']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control mt-0">
                                            {!! Form::label('TotalSNAP2Score','Total SNAP II Score:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::text('TotalSNAP2Score',null,['class'=>'form-control', 'onkeypress' => 'return ISNumber(event, this);', 'readonly']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control mt-0">
                                            {!! Form::label('TotalSNAPPE2Score','Total SNAPPE II Score:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::text('TotalSNAPPE2Score',null,['class'=>'form-control', 'onkeypress' => 'return ISNumber(event, this);', 'readonly']) !!}
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
                                    <img src='{{ url("public/img/snapII.png") }}'/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Diagnosis -->
                    <div role="tabpanel" class="tab-pane" id="Diagform">
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
                                            {!! Form::Select('DifferentialDiagnosis[]',$ICD,null,['class'=>'select2-select-00 full-width-fix ','multiple']) !!}
                                        </div>
                                    </div>
                                </div><!-- 
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label('DifferentialDiagnosis','Differential Diagnosis:') !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                </div> -->
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="mt-10 widget box row mx-0">
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
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(isset($results->additional_diagnosis) && json_decode($results->additional_diagnosis) && count(json_decode($results->additional_diagnosis)) > 0)
                                                    @foreach(json_decode($results->additional_diagnosis) as $key => $ad_diagnosis)
                                                    <tr>
                                                        <td class="full-width">
                                                            {!! Form::text('additional_diagnosis[]',$ad_diagnosis,['class'=>'form-control full-width']) !!}
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    @else                
                                                    <tr>
                                                        <td class="full-width">
                                                            {!! Form::text('additional_diagnosis[]','',['class'=>'form-control full-width']) !!}
                                                        </td>
                                                    </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('Plan','Plan:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::textarea('Plan',null,['class'=>'form-control editer-required','rows'=>5, 'id'=>'plan-text-box']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control mt-0">
                                            {!! Form::label('ParentsSpokenTo','Parents Spoken To:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::select('ParentsSpokenTo', [''=>'N/A', 'No'=>'No', 'Yes'=>'Yes'],null, ['class'=>'form-control']) !!}
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
                                                    {!! Form::select('TimeOfDiscussion',$NAT['time'],null,['class'=>'form-control ']) !!}
                                                </div>
                                                <div class="col-xs-4">
                                                    {!! Form::select('TimeOfDiscussion_MINS',[''=>'N/A']+$NAT['mins'],null,['class'=>'form-control ']) !!}
                                                </div>
                                                <div class="col-xs-4">
                                                    {!! Form::select('TimeOfDiscussion_AM',[''=>'N/A','AM'=>'AM','PM'=>'PM'],null,['class'=>'form-control ']) !!}
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
                                        <div class="col-md-3 text-right label-control mt-0">
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
                                        </div>
                                        @php $indication_of_admission1 = $indication_of_admission2 = $indication_of_admission3 = $indication_of_admission4 = $indication_of_admission5 = $indication_of_admission6 = $indication_of_admission7 = '';  @endphp
                                        @if (isset($results->indication_of_admission))
                                        @php $indication_of_admission =  json_decode($results->indication_of_admission);  @endphp
                                        @if (is_array($indication_of_admission))
                                        @php $indication_of_admission1 =  in_array('1',$indication_of_admission) ? true : false  @endphp
                                        @php $indication_of_admission2 =  in_array('2',$indication_of_admission) ? true : false  @endphp
                                        @php $indication_of_admission3 =  in_array('3',$indication_of_admission) ? true : false  @endphp
                                        @php $indication_of_admission4 =  in_array('4',$indication_of_admission) ? true : false  @endphp
                                        @php $indication_of_admission5 =  in_array('5',$indication_of_admission) ? true : false  @endphp
                                        @php $indication_of_admission6 =  in_array('6',$indication_of_admission) ? true : false  @endphp
                                        @php $indication_of_admission7 =  in_array('7',$indication_of_admission) ? true : false  @endphp
                                        @endif
                                        @endif
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
                    <div class="row bottom-specing col-md-12">
                        @if(isset($nicuList) && count($nicuList) < 1)
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary save-button-shadow btn-block form-control">
                                <i class="fa fa-floppy-o"></i> 
                                <span>Search</span>
                            </button>
                        </div>
                        @endif
                        <div class="col-md-6">
                            <a href="{{ action('Admission\NicuController@index') }}" class="btn btn-default save-button-shadow btn-block form-control" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> 
                                <span>Cancel</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
