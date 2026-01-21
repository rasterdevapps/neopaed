@extends('app')
@section('content')
<?php $write_permission = session('write_permission'); ?>
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li><i class="fa fa-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
        <li class=""><a title="" href="{{ action('Nurse\NicuNurseDaycareController@index') }}">Daycare</a></li>
        <li class="current"><a title="">Edit {{ $baby->BabyName }}</a></li>
    </ul>
</div>
<div class="row row-spacing">
    <div class="col-md-12 nurse-sheet-daily-entry">
        {!! Form::model($baby,['method' => 'PATCH','url' => action('Nurse\NicuNurseDaycareController@update',$dayid),'id'=>'nurse-daycare']) !!}
        @include('errors.list')
        <div role="tabpanel" class="tabbable tabbable-custom">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#sheet1" role="tab" data-toggle="tab">Sheet 1</a></li>
                <li role="presentation" ><a href="#sheet2" role="tab" data-toggle="tab">Sheet 2</a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content tab-view-shadow">
                <!-- General Form -->
                <div role="tabpanel" class="tab-pane active" id="sheet1">
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="widget box mt-10">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <!-- baby information -->
                                {!! Form::hidden('BabyId'); !!}
                                {!! Form::hidden('AdmissionId'); !!}
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
                                        {!! Form::label('DOB','DOB:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('DOB',null,['class'=>'form-control birth-date datepicker','readonly']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('DayOfLife','Day Of Life:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::number('DayOfLife',null,['class'=>'form-control','readonly']) !!}
                                    </div>
                                </div>

                                {!! Form::hidden('g_weeks', null, ['class'=>'gestation-wks']) !!}
                                {!! Form::hidden('g_days', null, ['class'=>'gestation-days']) !!}

                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control" style="margin-top: 5px;">
                                        {!! Form::label('CorrectedGestation','Corrected Gestational Age:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input clear-xs">
                                        <div class="row col-md-12 display-flex">
                                            <div>
                                                <small>(In Weeks)</small>
                                                {!! Form::number('cg_weeks',null,['class'=>'form-control corrected-gestation-wks','readonly']) !!}
                                                <label class="error help-block" for="cg_weeks" generated="true"></label>
                                            </div>
                                            <div class="inbeween_two_fields">
                                                <span>+</span>
                                            </div>
                                            <div>
                                                <small>(In Days)</small>
                                                {!! Form::number('cg_days',null,['class'=>'form-control corrected-gestation-days','readonly']) !!}
                                                <label class="error help-block" for="cg_days" generated="true"></label> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Resipratory system -->
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('FiO2','FiO2:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::number('FiO2',null,['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('RR','Baby\'s Respiratory Rate:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::number('RR',null,['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Flow','Flow (L/min):') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::number('Flow',null,['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('SaO2PostDuctal','SaO2 Post Ductal:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::number('SaO2PostDuctal',null,['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('EtTube','ET Tube:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::checkbox('EtTube',null,null,['data-on'=>'Yes','data-off'=>'No','data-toggle'=>'toggle','data-width'=>'100','data-size'=>'small','class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Size','Size in cm:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Size',[''=>'N/A','None'=>'None','2.0'=>'2.0','2.5'=>'2.5','3.0'=>'3.0','3.5'=>'3.5','4.0'=>'4.0'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Lips','Cm at Lips:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::number('Lips',null,['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}
                                    </div>
                                </div>
                                <div class="hidden">
                                    @if(isset($antibiotic) && count($antibiotic) > 0)
                                    @foreach ($antibiotic as $data)
                                    <tr>
                                        <td>{!! Form::select('A_Antibiotic[]',[''=>'N/A']+ValuelistHelpers::getAntibiotic(),$data['Antibiotic'],['class'=>"input-width-medium form-control"]) !!}</td>
                                        <td><input type="text" class="input-width-mini form-control" name="A_Day[]" value="{!! $data['Day']; !!}"/></td>
                                        <td><span class="fa fa-remove btn btn-default remove"></span></td>
                                    </tr>
                                    @endforeach
                                    @endif
                                    @if (isset($drugs) && count($drugs) > 0)
                                    @foreach ($drugs as $data)
                                    <tr>
                                        <td><input class="input-width-medium form-control" type="text" name="drugs[]" value="{!! $data; !!}"/></td>
                                        <td><span class="fa fa-remove btn btn-default remove"></span></td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </div>
                                <!-- cardio -->
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('HR','HR:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::number('HR',null,['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('systolic_bp','Systolic BP:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::number('systolic_bp',null,['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('diastolic_bp','Diastolic BP:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::number('diastolic_bp',null,['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('MeanBP','Mean BP') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::number('MeanBP',null,['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('CentralTemperature','Central Temperature:') !!}
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
                                                {!! Form::text('CentralTemperature',null,['class'=>'form-control celsius']) !!}
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
                                                {!! Form::text('CentralTemperature',null,['class'=>'form-control celsius']) !!}
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
                                        {!! Form::label('PeripheralTemperature','Peripheral Temperature:') !!}
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
                                                {!! Form::text('PeripheralTemperature',null,['class'=>'form-control celsius']) !!}
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
                                                {!! Form::text('PeripheralTemperature',null,['class'=>'form-control celsius']) !!}
                                            </div>
                                            <div class="col-xs-6">
                                                {!! Form::text('','',['class'=>'form-control fahrenheit']) !!}
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-12 col-xs-12">
                        <div class="widget box mt-10">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('DayDate','Date of Record:', ['class'=>'required-label']) !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('DayDate',null,['class'=>'form-control datepicker record-date','readonly'=>'true']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                        {!! Form::label('DayTime','Time of Record:', ['class'=>'required-label']) !!}
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
                                                {!! Form::select('DayTime',$time['time'],null,['class'=>'form-control input-width-small']) !!}
                                            </div>
                                            <div class="col-xs-4">
                                                {!! Form::select('DayTime_MINS',$time['mins'],null,['class'=>'form-control input-width-small']) !!}
                                            </div>
                                            <div class="col-xs-4">
                                                {!! Form::select('DayTime_AM',['AM'=>'AM','PM'=>'PM'],null,['class'=>'form-control input-width-small']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--  Gastrointestinal -->
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        {!! Form::label('Care','Care:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Care',[''=>'N/A','Intensive Care'=>'Intensive Care','Special Care'=>'Special Care','Ward Admission'=>'Ward Admission','High Dependancy Care'=>'High Dependancy Care'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('care',5)]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Surfactant_therapy_nicu','Surfactant therapy in the NICU:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <input id="Surfactant_therapy_nicu" name="Surfactant_therapy_nicu" data-on="Yes" data-off="No" data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Volume','Feed Volume:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::number('Volume',null,['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        {!! Form::label('Frequency','Feed Frequency:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Frequency',ValuelistHelpers::frequencyList(),null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('feed_frequency',5)]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        {!! Form::label('TypeofFeeds','Type of Feeds:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('TypeofFeeds',[""=>"N/A","Maternal Expressed Breast Milk (MEBM)" =>"Maternal Expressed Breast Milk (MEBM)","Donor Expressed Breast Milk (DEBM)"=>"Donor Expressed Breast Milk (DEBM)", "Formula Milk" => "Formula &nbsp;&nbsp;&nbsp; Milk", "Fortified MEBM" =>"Fortified MEBM", "Fortified DEBM" => "Fortified DEBM"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('AspirateVolume','Aspirate Volume:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::number('AspirateVolume',null,['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        {!! Form::label('AspirateNature','AspirateNature:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('AspirateNature',[''=>'N/A','Nil' =>"Nil","Milky"=>"Milky","Yellow"=>"Yellow","Light green"=>"Light &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; green","Dark green"=>"Dark &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; green","Bloody"=>"Bloody","Altered brown"=>"Altered &nbsp; &nbsp; brown","Clear"=>"Clear"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('AspirateNature',5)]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Stools','Stools:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::checkbox('Stools',null,null,['data-on'=>'Bowels opened','data-off'=>'Bowels not opened','data-toggle'=>'toggle','data-width'=>'200','data-size'=>'small','class'=>'form-control','id'=>'Stools']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        {!! Form::label('StoolNature','Stool Nature:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('StoolNature',ValuelistHelpers::stoolNature(),null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('AbdominalGirth','Abdominal Girth:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::number('AbdominalGirth',null,['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('TSB','Maximum Bilirubin (in last 24 hours):') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::number('TSB',null,['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('NNJTreatment','NNJ Treatment:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('NNJTreatment',[''=>'N/A','None'=>'None','Phototherapy' => "Photo &#8478;","Exchange transfusion"=>"Exchange &#8478;"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorValue('NNJTreatment')]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Immunoglobulins','Immunoglobulins:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Immunoglobulins',[''=>'N/A','Yes'=>'Yes','No'=>'No'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorValue('default')]) !!}
                                    </div>
                                </div>
                                <!-- Fluid Balance  -->
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('PreviousWt','Previous Weight (Yesterday\'s):') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::number('PreviousWt',null,['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('CurrentWt','Current Weight (Today\'s):') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::number('CurrentWt',null,['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('WtChange','Weight Change:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::number('WtChange',null,['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('workingWeight','Working Weight:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::number('workingWeight',null,['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}
                                    </div>
                                </div>
                                {!! Form::hidden('PercentageChange',null,['class'=>'form-control']) !!}
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        {!! Form::label('UrineOutput','Urine Output:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('UrineOutput',[''=>'N/A','Passed' => "Passed","Not Passed"=>"Not Passed","Unmeasurable"=>"Unmeasurable"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('urine_output',5)]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('urine_output_day',' UO ml (in 24 hours):') !!} 
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::number('urine_output_day',null,['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}                                
                                    </div>
                                </div>
                                {!! Form::hidden('UO',null,['class'=>'form-control']) !!}
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('BloodOut','Blood Out:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::number('BloodOut',null,['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('DrainOutput','Drain Output:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::number('DrainOutput',null,['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('RBS','RBS:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::number('RBS',null,['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="sheet2">
                    <div class="col-md-6 col-sm-6">
                        <div class="widget box mt-10">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                {!! Form::hidden('TotalFluid',null,['class'=>'form-control']) !!}
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Feeds','Feeds ml/kg/d:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::number('Feeds',null,['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}
                                    </div>
                                </div>   
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                        {!! Form::label('iv_fluids','IV fluids +/- PN:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input clear-xs">
                                        <div class="row">
                                            <div class="col-xs-5">
                                                <small>(ml/hour)</small>
                                            </div>
                                            <div class="col-xs-offset-2 col-xs-5">
                                                <small>(ml/day)</small>
                                            </div>
                                            <div class="col-xs-5">
                                                {!! Form::number('iv_fluids',null,['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}
                                                <label class="error help-block" for="iv_fluids" generated="true"></label> 
                                            </div>
                                            <div class="col-xs-2">
                                                =
                                            </div>
                                            <div class="col-xs-5">
                                                {!! Form::number('iv_fluids_ml_day',null,['class'=>'form-control', 'id'=>'iv_fluids_ml_day','readonly'=>true]) !!}
                                                <label class="error help-block" for="iv_fluids_ml_day" generated="true"></label> 
                                            </div>
                                        </div>
                                    </div>
                                </div>      
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                        {!! Form::label('drug_infusions','Drug Infusions:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input clear-xs">
                                        <div class="row">
                                            <div class="col-xs-5">
                                                <small>(ml/hour)</small>
                                            </div>
                                            <div class="col-xs-offset-2 col-xs-5">
                                                <small>(ml/day)</small>
                                            </div>
                                            <div class="col-xs-5">
                                                {!! Form::number('drug_infusions',null,['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}
                                                <label class="error help-block" for="g_weeks" generated="true"></label> 
                                            </div>
                                            <div class="col-xs-2">
                                                =
                                            </div>
                                            <div class="col-xs-5">
                                                {!! Form::number('drug_infusions_ml_day',null,['class'=>'form-control', 'id'=>'drug_infusions_ml_day','readonly'=>true]) !!}
                                                <label class="error help-block" for="g_days" generated="true"></label> 
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('other_drugs','Other Drugs ml/day:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::number('other_drugs',null,['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('Ivf','IV fluids +/- PN ml/kg/d:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::number('Ivf',null,['class'=>'form-control','readonly'=>true]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('Tpn','TPN:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Tpn',[""=>"N/A","No" =>"No","Yes"=>"Yes"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('Transfusion','Transfusion:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Transfusion',[''=>'N/A','No' =>"No","Yes"=>"Yes"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('Transfusion')]) !!}
                                    </div>
                                </div>                             
                                <div class="form-group row">
                                    <div class="col-md-12 custom-input">
                                        <table class="product table table-add-more full-width-fix">
                                            <thead>
                                                <tr class="master-add-header">
                                                    <th>
                                                        Product
                                                    </th>
                                                    <th>
                                                        Volume ml/kg
                                                    </th>
                                                    <th>
                                                        <span>
                                                            <a class="btn btn-success btn-view product_add btn_add" href="javascript:void(0);">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                        </span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(isset($products) && count($products) > 0)
                                                @foreach ($products as $data)
                                                <tr>
                                                    <td class="full-width">
                                                        {!! Form::select('F_Product[]',ValuelistHelpers::BloodProducts(),$data['Product'],['class'=>'form-control']) !!}
                                                    </td>
                                                    <td>
                                                        <input type="number" class="input-width-mini form-control" name="F_Volume[]" value="{!! $data['Volume']; !!}" onkeypress="return isNumber(event, this)" />
                                                    </td>
                                                    <td>
                                                        <span class="fa fa-trash btn btn-danger btn-view remove"></span>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @else
                                                <tr>
                                                    <td class="full-width">
                                                        {!! Form::select('F_Product[]',ValuelistHelpers::BloodProducts(),null,['class'=>'form-control']) !!}
                                                    </td>
                                                    <td>
                                                        <input type="number" class="input-width-mini form-control" name="F_Volume[]" value="" onkeypress="return isNumber(event, this)" />
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
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Sepsis','SEPSIS:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Sepsis',[''=>'N/A','No sepsis' => "No sepsis","Suspect"=>"Suspect","Probable"=>"Probable","Proven"=>"Proven","Severe"=>"Severe"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('SEPSIS')]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('CRP','CRP mg per L:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::number('CRP',null,['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('TLC','TLC per cu.mm:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::number('TLC',null,['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Percentage','Percentage N:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::number('Percentage',null,['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('ANC','ANC per cu.mm:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::number('ANC',null,['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Platelets','Platelets per cu.mm:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::number('Platelets',null,['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}
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
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('lumbar_puncture','Lumbar puncture:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('lumbar_puncture',["Not Indicated"=>"Not Indicated",'Performed'=>'Performed','Not Performed' => "Not Performed"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('BloodCulture')]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('PeripheralCannula','Peripheral Cannula:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('PeripheralCannula',[''=>'N/A','No' =>"No","Yes"=>"Yes"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('pvc_number','PVC Number:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::number('pvc_number',null,['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('PvcComplication','Pvc Complication:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('PvcComplication',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('Picc','Picc:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Picc',[''=>'N/A','No' =>"No","Yes"=>"Yes"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('PiccSite','Picc Site:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('PiccSite',ValuelistHelpers::PiccSite(),null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('PiccDay','Picc Day:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::number('PiccDay',null,['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('PiccComplication','Picc Complication:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('PiccComplication',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('Uvc','UVC:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Uvc',[''=>'N/A','No' =>"No","Yes"=>"Yes"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('UvcPosition','UVC Position:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('UvcPosition',[''=>'N/A','High' =>"High","Low"=>"Low"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default')]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('UvcDay','UVC Day:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::number('UvcDay',null,['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('UvcComplication','UVC Complication:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('UvcComplication',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('Uac','UAC:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Uac',[''=>'N/A','No' =>"No","Yes"=>"Yes"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('UacPosition','UAC Position:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('UacPosition',[''=>'N/A','High' =>"High","Low"=>"Low"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default')]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('UacDay','UAC Day:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::number('UacDay',null,['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('UacComplication','UAC Complication:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('UacComplication',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('Pac','PAC:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Pac',[''=>'N/A','No' =>"No","Yes"=>"Yes"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('PacSite','PAC Site:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('PacSite',ValuelistHelpers::PacSite(),null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('PacDay','PAC Day:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::number('PacDay',null,['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('PacComplication','PAC Complication:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('PacComplication',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="print_flag" value="0" id="print_flag"/>
                <div class="col-md-11 col-sm-12">
                    <div class="col-md-3 col-sm-4 col-xs-12">
                        <button type="submit" class="btn btn-block btn-primary save-button-shadow form-control daycare_save_btn" data-flag="1">
                            <i class="fa fa-floppy-o"></i>
                            <span>{!! $SubmitButtonText !!}</span></button>
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12">
                            <button type="button" class="btn btn-block save-button-shadow btn-info form-control daycare_save_btn" data-flag="2">
                                <i class="fa fa-floppy-o"></i>
                                <span>Update</span>
                            </button>
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12">
                            <a href="{{ action('Nurse\NicuNurseDaycareController@index') }}" class="btn btn-block save-button-shadow btn-default form-control" onclick="$('form')[0].reset();">
                                <i class="fa fa-exclamation-circle"></i> 
                                <span>Cancel</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close(); !!}
        @endsection
        @section('scripts')
        <script type="text/javascript">
            @if(@$baby->Stools == 'Bowels not opened')
            $('#Stools').bootstrapToggle('on');
            @endif

            @if(@$baby->Surfactant_therapy_nicu =='Yes')
            $('#Surfactant_therapy_nicu').bootstrapToggle('on');
            @elseif(@$baby->Surfactant_therapy_nicu =='No') 
            $('#Surfactant_therapy_nicu').bootstrapToggle('off');   
            @endif

            @if(@$baby->EtTube  =='No')
            $('#EtTube').bootstrapToggle('off');
            @endif


            var input = $('[name="PreviousWt"],[name="CurrentWt"]'),
            input1 = $('[name="PreviousWt"]'),
            input2 = $('[name="CurrentWt"]'),
            input3 = $('[name="WtChange"]'),
            input4 = $('[name="PercentageChange"]');

            input.change(function () {
              // if (input1.val() == "") {
              //     input1.val(0);
              // }
              // if (input2.val() == "") {
              //     input2.val(0);
              // }
              input4.val('');
              input3.val('');
              if(input2.val().trim() != '' && input1.val().trim()!=''){ 

                var WeightChange = parseInt(input2.val())-parseInt(input1.val());
                input3.val(WeightChange);
                var PercentageChange = (parseInt(WeightChange) / parseInt(input1.val())) * 100;
                input4.val(PercentageChange.toFixed(1));

            }    

        });

            nurseEtube();
            $(document).on('click', '.daycare_save_btn', function(e){
                if ($('#nurse-daycare').valid() === true) {
                    e.preventDefault();
                    var print_flag = $(this).data('flag');
                    $('#print_flag').val(print_flag);
                    $('.daycare_save_btn').prop('disabled', true);

                    var current_clicked_element = $(this);
                    current_clicked_html = $(this).html();
                    $(this).html('<i class="fas fa-spinner fa-pulse"></i> Loading...');
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        data: $('#nurse-daycare input, #nurse-daycare select, #nurse-daycare textarea').serialize(),
                        url: "{{ action('Nurse\NicuNurseDaycareController@update',$dayid) }}",
                        success: function (response) {
                            if (print_flag == 1) {
                                Showalert('success', 'Nurse daycare details updated successfully');
                                window.location.href = response.list_url;
                            }
                            else if(print_flag == 2)
                            {
                                Showalert('success', 'Nurse daycare details updated successfully');
                    // window.location.href = response.edit_url;
                    $('.daycare_save_btn').prop('disabled', false);
                    current_clicked_element.html(current_clicked_html);
                }
            },
            error: function()
            {
                Showalert('error', 'Something went wrong, Please try again later...!');
                $('.daycare_save_btn').prop('disabled', false);
                current_clicked_element.html(current_clicked_html);
            }
        });
                }
            });

        </script>
        @endsection
