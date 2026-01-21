<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active">
        <a href="#basicform" aria-controls="basicform" role="tab" data-toggle="tab">Basics</a>
    </li>
    <li role="presentation">
        <a href="#admissform" aria-controls="admissform" role="tab" data-toggle="tab">Admission Details</a>
    </li>

    <li role="presentation">
        <a href="#Proform" aria-controls="Proform" role="tab" data-toggle="tab">Procedures</a>
    </li>

    <li role="presentation">
        <a href="#Diagform" aria-controls="Diagform" role="tab" data-toggle="tab">Diagnosis</a>
    </li>
</ul>
<!-- Tab panes -->
<div class="tab-content tab-view-shadow ptb-15">
    <!-- Basics Form -->
    <div role="tabpanel" class="tab-pane active" id="basicform">
        <div class="col-md-6 col-sm-6">
            <div class="mt-10 widget box">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> </h4>
                </div>
                <div class="widget-content">
                    <div class="form-group row">
                        <div class="col-md-3 label-control text-right">
                            {!! Form::label('BabyName','Baby Name:') !!}
                        </div>
                        <div class="col-md-9 custom-input" >
                            {!! Form::text('BabyName',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 label-control text-right">
                            {!! Form::label('BMrNo', Lang::get('home.mrn').':') !!}
                        </div>
                        <div class="col-md-9 custom-input" >
                            {!! Form::text('BMrNo',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 label-control text-right">
                            {!! Form::label('DOB','DOB:') !!}
                        </div>
                        <div class="col-md-9 custom-input" >
                            {!! Form::text('DOB',null,['class'=>'form-control datepicker birth-date','readonly']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 label-control text-right">
                            {!! Form::label('BirthWeight','Birth Weight (In grams):') !!}
                        </div>
                        <div class="col-md-9 custom-input" >
                            {!! Form::text('BirthWeight',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 label-control text-right">
                            {!! Form::label('BirthStatus','Birth Status:') !!}
                        </div>
                        <div class="col-md-9 custom-input" >
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
                                    <label class="error help-block" for="g_weeks" generated="true"></label> 
                                </div>
                                <div class="inbeween_two_fields">
                                    <span>+</span>
                                </div>
                                <div>
                                    <small>(In Days)</small>
                                    {!! Form::text('g_days',null,['class'=>'form-control gestation-days','max'=>'6']) !!}
                                    <label class="error help-block" for="g_days" generated="true"></label> 
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="form-group row">
                        <div class="col-md-3 label-control text-right mt-0">
                            {!! Form::label('BabyBloodGroup','Baby\'s Blood Group:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('BabyBloodGroup',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 label-control text-right">
                            {!! Form::label('Sex','Sex:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('Sex',[''=>'N/A','Male'=>'Male','Female'=>'Female','Indeterminate'=>'Indeterminate'],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 label-control text-right">
                            {!! Form::label('referredby','Referred From:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('referredby',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 label-control text-right">
                            {!! Form::label('referralreason','Referral Reason:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('referralreason',null,['class'=>'form-control text-convertion-lower']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('admission_cg','Corrected Gestational Age:') !!}
                        </div>
                        <div class="col-md-9 custom-input clear-xs">
                            <div class="row col-md-12 display-flex">
                                <div>
                                    <small>(In Weeks)</small>
                                    {!! Form::text('cg_weeks',null,['class'=>'form-control']) !!}
                                    <label class="error help-block" for="cg_weeks" generated="true"></label> 
                                </div>
                                <div class="inbeween_two_fields">
                                    <span>+</span>
                                </div>
                                <div>
                                    <small>(In Days)</small>
                                    {!! Form::text('cg_days',null,['class'=>'form-control']) !!}
                                    <label class="error help-block" for="cg_days" generated="true"></label> 
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
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('admission_date','Admission Date:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('admission_date',null,['class'=>'form-control admission-date record-date', 'readonly'=> 'true']) !!}
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
                                    {!! Form::select('admission_time_hour',[''=>'N/A']+$timeList['time'],null,['class'=>'form-control full-width']) !!}
                                </div>
                                <div class="col-xs-4">
                                    {!! Form::select('admission_time_mins',[''=>'N/A']+$timeList['mins'],null,['class'=>'form-control full-width']) !!}
                                </div>
                                <div class="col-xs-4">
                                    {!! Form::select('admission_time_session',[''=>'N/A']+$timeList['session'],null,['class'=>'form-control full-width']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('typeofcare','Type Of Care:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('typeofcare',['' => 'N/A','Intensive Care'=>'Intensive Care','Special Care'=>'Special Care','Ward Admission'=>'Ward Admission','High Dependancy Care'=>'High Dependancy Care'],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('ip_number', Lang::get('home.ip').':') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('ip_number',null,['class'=>'form-control ip_number'])  !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('admission_wt','Admission Weight (In grams):') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('admission_wt',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('ageonadmissionindays','Age On Admission (In days):') !!}                                
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('ageonadmissionindays',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('surgeon','Surgeon:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('surgeon',[''=>'N/A', '0'=>'Not applicable']+ValuelistHelpers::get_surgeons_lists(),null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('seenby','Seen By:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('seenby',[''=>'N/A']+$doctorsList,null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('hospital_name','Hospital Name') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('hospital_name',[''=>'N/A']+ValuelistHelpers::getHospitals(),null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('admission_examination','Summary of Admission Examination:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::textarea('admission_examination',null,['class'=>'form-control resize-none']) !!}
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
                            {!! Form::label('admitted_from','AdmittedFrom:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('admitted_from',[''=>'Select','Labour ward'=>'Labour ward','Nicu'=>'Nicu','OP'=>'OP','Outside Hospital'=>'Outside Hospital','Obstetric theatres'=>'Obstetric theatres'],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('major_complaints','Major Complaints:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::textarea('major_complaints',null,['class'=>'form-control','rows' => 5]) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('ventilation','Respiratory Support at the time of admission:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('ventilation', [''=>'N/A', '1'=>'No', '2'=>'Yes'],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('mode','Mode:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('mode',[''=>'N/A']+$admissionmodeList,null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('pip','Pip:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('pip',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('peep','PEEP:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('peep',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('amplitude','Amplitude &delta; :') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('amplitude',null,['class'=>'form-control']) !!}
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
                            {!! Form::label('rate','Rate\Frequency:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('rate',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('it','IT:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('it',null,['class'=>'form-control']) !!}
                        </div>                    
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('fio2','FIO2 %:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('fio2',null,['class'=>'form-control']) !!}
                        </div>                    
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('flow','Flow (L/Min):') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('flow',null,['class'=>'form-control']) !!}
                        </div>                    
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('rr','RR:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('rr',null,['class'=>'form-control']) !!}
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
                            {!! Form::label('chest_movement','Chest Movement:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('chest_movement',[''=>'N/A','Symmetrical'=>'Symmetrical','Asymmetrical'=>'Asymmetrical'],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('hr','HR in bpm:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('hr',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('systolic_bp','Systolic BP:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('systolic_bp',null,['class'=>'form-control']) !!}
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
                            {!! Form::label('mean_bp','Mean BP:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('mean_bp',null,['class'=>'form-control']) !!}
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
                            {!! Form::label('s1s2','S1S2:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('s1s2',[''=>'N/A','Normal'=>'Normal','Abnormal'=>'Abnormal'],null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('nicu_murmur','Murmur:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('nicu_murmur',[''=>'N/A','Present'=>'Present','Absent'=>'Absent'],null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('default')]) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('cft','CFT:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('cft',[''=>'N/A','< 3 Seconds' => "< 3 Seconds",'3-5 Seconds' => "3-5 Seconds",'>5 Seconds' => ">5 Seconds","Prolonged"=>"Prolonged"],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('nicu_color','Color:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('nicu_color',[''=>'N/A','Pale'=>'Pale','Pink' => "Pink","Acral Cyanosis"=>"Acral Cyanosis","Central Cyanosis"=>"Central Cyanosis"], null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('Color')]) !!}
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
                            {!! Form::label('temperature','Temperature (F/C):') !!}
                        </div>
                        @php $order_changed = \SiteHelpers::temperatureOrder(); @endphp
                        <div class="col-md-9 custom-input">
                            @if ($order_changed)
                            <div class="row">
                                <div class="col-xs-6">
                                    <small>(In Fahrenheit)</small>
                                </div>
                                <div class="col-xs-6">
                                    <small>(In Celsius)</small>
                                </div>
                                <div class="col-xs-6">
                                    {!! Form::text('','',['class'=>'form-control fahrenheit']) !!}
                                </div>
                                <div class="col-xs-6">
                                    {!! Form::text('temperature',null,['class'=>'form-control celsius']) !!}
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
                                    {!! Form::text('temperature',null,['class'=>'form-control celsius']) !!}
                                </div>
                                <div class="col-xs-6">
                                    {!! Form::text('','',['class'=>'form-control fahrenheit']) !!}
                                </div>
                            </div>
                            @endif
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
                            {!! Form::select('nicu_umbilicus',[''=>'N/A','Healthy' => "Healthy","Possible infection"=>"Possible infection","Omphalitis"=>"Omphalitis","Omphalocele"=>"Omphalocele","Gastroschisis"=>"Gastroschisis","Hernia"=>"Hernia","Meconium Stained" => "Meconium Stained","Large" => "Large","Shrivelled" => "Shrivelled"],null,['class'=>'form-control']) !!}
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
                            {!! Form::label('genitalia','Genitalia:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('genitalia',[''=>'N/A']+ValuelistHelpers::getGentila(),null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('genitalia_findings', 'Genitalia Findings:')!!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('genitalia_findings', null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('nicu_pupils','Pupils:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('nicu_pupils', [''=>'N/A']+ValuelistHelpers::getPupils(), null, ['class'=>'form-control']) !!}
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
                        <div class="col-md-3 text-right label-control">
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
                            {!! Form::label('tone','Tone') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('tone',[''=>'N/A','Normal' =>"Normal","Hypotonia"=>"Hypotonia","Hypertonia"=>"Hypertonia","Sedated/Paralysed"=>"Sedated/Paralysed"],null,['class'=>'form-control'])!!}
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
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('abnormalities','Admission Examination Findings:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::textarea('abnormalities',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('initialbloodgas','Initial Blood Gas:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('initialbloodgas',[''=>'N/A','Not done'=>'Not done','Not indicated'=>'Not indicated','Arterial'=>'Arterial','Venous'=>'Venous','Capillary'=>'Capillary'],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('agetaken','Age in hours at the time of blood gas:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('agetaken',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('spo2','SpO2:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('spo2',null,['class'=>'form-control']) !!}
                        </div>
                    </div> 
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('ph','pH:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('ph',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('pao2','PaO2:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('pao2',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('paco2','PaCo2:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('paco2',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('hco3','HCO3:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('hco3',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('be','BE:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('be',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('rbs','RBS:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('rbs',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('hct','Hct:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('hct',null,['class'=>'form-control']) !!}
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
                            {!! Form::label('initialxray','Initial X ray:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('initialxray',[''=>'N/A','Not done' => 'Not done','Not indicated' =>'Not indicated','Performed'=> 'Performed'],null,['class'=>'form-control']) !!}
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
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('ageofcxr','Abdominal X Ray findings:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('ageofcxr',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('uac_status','UAC:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('uac_status', [''=>'N/A', '1'=>'No', '2'=>'Yes'],null,['class'=>'form-control']) !!}
                        </div> 
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('uac_position','UACPosition:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('uac_position',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('uvc_status','UVC:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('uvc_status', [''=>'N/A', '1'=>'No', '2'=>'Yes'],null,['class'=>'form-control']) !!}
                        </div> 
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('uvc_position','UVCPosition:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('uvc_position',null,['class'=>'form-control']) !!}
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
                            {!! Form::label('sepsisscreen','SepsisScreen:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('sepsisscreen',[''=>'N/A','Yes'=>'Yes','No'=>'No'],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('indications','Indications:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('indications',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="hidden">
                        {!! Form::select('IVAntibiotic',[''=>'N/A']+ValuelistHelpers::getDrugIvFluidsAntibiotic(),null,['class'=>'form-control  input-width-large']) !!}
                    </div>                                
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('ivantibiotic','IV Antibiotic:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            <table class="IVAntibiotic table table-add-more full-width-fix">
                                <thead>                                    
                                    <tr class="master-add-header">
                                        <th class="full-width">
                                            <i class="fa fa-reorder"></i>Add More
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($postnatal->ivantibiotic))
                                    @php  $antibio = json_decode($postnatal->ivantibiotic); @endphp
                                    @if(count($antibio) > 0)
                                    @foreach($antibio as $key => $antibioValues)
                                    <tr>
                                        <td>
                                            {!! Form::select('ivantibiotic[]',[''=>'N/A']+ValuelistHelpers::getDrugIvFluidsAntibiotic(),$antibioValues,['class'=>'form-control']) !!}
                                        </td>
                                    </tr>
                                    @endforeach   
                                    @else
                                    <tr>
                                        <td>
                                            {!! Form::select('ivantibiotic[]',[''=>'N/A']+ValuelistHelpers::getDrugIvFluidsAntibiotic(),null,['class'=>'form-control']) !!}
                                        </td>
                                    </tr>
                                    @endif  
                                    @else
                                    <tr>
                                        <td>
                                            {!! Form::select('ivantibiotic[]',[''=>'N/A']+ValuelistHelpers::getDrugIvFluidsAntibiotic(),null,['class'=>'form-control']) !!}
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table> 
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('investigations','Investigations:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('investigations',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('enteral_feeding','Enteral Feeding:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('enteral_feeding',[''=>'N/A','Yes'=>'Yes','No'=>'No'],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control mt-0">
                            {!! Form::label('fluids','Fluids/Feeds ml/kg/d:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('fluids',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Diagnosis -->
    <div role="tabpanel" class="tab-pane" id="Diagform">
        <div class="mt-10 widget box col-md-12">
            <div class="widget-header">
                <h4><i class="fa fa-reorder"></i> </h4>
            </div>
            <div class="widget-content row mx-0">
                <div class="col-md-12 ">
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('differentialdiagnosis','Differential Diagnosis:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::Select('differentialdiagnosis[]',$icdList,null,['class'=>'select2-select-00 full-width-fix','multiple']) !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12">    
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
                                    @if (isset($postnatal->additional_diagnosis))
                                    @php $additionalDiagnosis = json_decode($postnatal->additional_diagnosis)  @endphp
                                    @if(count($additionalDiagnosis) > 0)
                                    @foreach($additionalDiagnosis as $key => $diagnosis)
                                    <tr>
                                        <td>
                                            <input type="text" name="additional_diagnosis[]" value="{{ $diagnosis }}" class=" form-control full-width">
                                        </td>
                                    </tr>
                                    @endforeach   
                                    @else
                                    <tr>
                                        <td>
                                            <input type="text" name="additional_diagnosis[]" value="" class="form-control">                                                    
                                        </td>  
                                    </tr>
                                    @endif
                                    @else
                                    <tr>
                                        <td>
                                            <input type="text" name="additional_diagnosis[]" value="" class="form-control">                                                    
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table> 
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('plan','Plan:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::textarea('plan',null,['class'=>'form-control','rows'=>5]) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('parents_spoken','Parents Spoken To:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('parents_spoken', [''=>'N/A', '1'=>'No', '2'=>'Yes'],null, ['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('DiscussionTime','Time of Discussion:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            <table>
                                <tr>
                                    <td> {!! Form::select('pdiscussion_hrs',[''=>'N/A']+$timeList['time'],null,['class'=>'form-control']) !!} </td>
                                    <td class="form-group-spacing"> {!! Form::select('pdiscussion_min',[''=>'N/A']+$timeList['mins'],null,['class'=>'form-control']) !!} </td>
                                    <td> {!! Form::select('pdiscussion_session',[''=>'N/A']+$timeList['session'],null,['class'=>'form-control']) !!} </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('matters_discussed','Matters Discussed:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::textarea('matters_discussed',null,['class'=>'form-control','rows'=>5]) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('parents_addressed_by','Parents Addressed By:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('parents_addressed_by',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                </div>
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
