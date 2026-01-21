@extends('app')
@section('content')
<!-- Breadcrumbs line -->
@php $actionUrl = action('Registration\NeonatalController@index')  @endphp
@php
//if(!isset($_COOKIE['neonatal_proforma']) || !isset($_COOKIE['neonatal_proforma_sub'])) {
$_COOKIE['neonatal_proforma']     =  'babyform';
$_COOKIE['neonatal_proforma_sub'] =  'vitals';
//}
@endphp
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li>
            <i class="fa fa-home"></i><a href="{{ url('/') }}">Dashboard</a>
        </li>
        <li>
            <a title="" href="{{ action('Registration\NeonatalController@index') }}">Neonatal Proforma</a>
        </li>
        <li class="current">
            <a title="">Create @if(isset($baby_detail->BabyName) && !empty($baby_detail->BabyName)) For {{ $baby_detail->BabyName }} @endif</a>
        </li>
    </ul>
</div>
<style type="text/css">
    .select-free-text2
    {
        z-index: 1;
    }

</style>
<!-- /Breadcrumbs line -->
<div class="row row-spacing">
    <div class="col-md-12 neonatal-create">
        {!! Form::model($baby_detail,['url' => action('Registration\NeonatalController@store'),'id' => 'neonatalPerforma-form']) !!}
        @include('errors.list')
        <!-- Nav tabs -->
        <div role="tabpanel" class="tabbable tabbable-custom">
            <ul class="nav nav-tabs" role="tablist" id="neonate-next">
                @if(!Session::has('NeonatalDichargeList'))
                    <li role="presentation" @if($_COOKIE['neonatal_proforma'] == 'babyform') class="active" @endif>
                        <a class="tab-main-menu" href="#babyform" aria-controls="babyform" role="tab" data-toggle="tab">Baby Details</a>
                    </li>
                   <!--  <li role="presentation" @if($_COOKIE['neonatal_proforma'] == 'motherform') class="active" @endif>
                        <a class="tab-main-menu" href="#motherform" aria-controls="motherform" role="tab" data-toggle="tab">Parental Details</a>
                    </li> -->
                    <li role="presentation" @if($_COOKIE['neonatal_proforma'] == 'obform') class="active" @endif>
                        <a class="tab-main-menu" href="#obform" aria-controls="obform" role="tab" data-toggle="tab">Obstetric History</a>
                    </li>
                    <li role="presentation"  @if($_COOKIE['neonatal_proforma'] == 'pgform') class="active" @endif>
                        <a class="tab-main-menu" href="#pgform" aria-controls="pgform" role="tab" data-toggle="tab">Pregnancy</a>
                    </li>
                    <li role="presentation" @if($_COOKIE['neonatal_proforma'] == 'pgcform') class="active" @endif>
                        <a class="tab-main-menu" href="#pgcform" aria-controls="pgcform" role="tab" data-toggle="tab">Pregnancy Contd</a>
                    </li>
                    <li role="presentation" @if($_COOKIE['neonatal_proforma'] == 'labform') class="active" @endif>
                        <a class="tab-main-menu" href="#labform" aria-controls="labform" role="tab" data-toggle="tab">Labour</a>
                    </li>
                    <li role="presentation" @if($_COOKIE['neonatal_proforma'] == 'Delform') class="active" @endif>
                        <a class="tab-main-menu" href="#delform" aria-controls="Delform" role="tab" data-toggle="tab">Delivery</a>
                    </li>
                    <li role="presentation" @if($_COOKIE['neonatal_proforma'] == 'apgarform') class="active" @endif>
                        <a class="tab-main-menu" href="#apgarform" aria-controls="apgarform" role="tab" data-toggle="tab">APGAR</a>
                    </li>
                    <li role="presentation" @if($_COOKIE['neonatal_proforma'] == 'resform') class="active" @endif>
                        <a class="tab-main-menu" href="#resform" aria-controls="resform" role="tab" data-toggle="tab">Resuscitation Details</a>
                    </li>
                    <li role="presentation" @if($_COOKIE['neonatal_proforma'] == 'essform') class="active" @endif>
                        <a class="tab-main-menu" href="#essform" aria-controls="essform" role="tab" data-toggle="tab">Essential Details</a>
                    </li>
                    @if($baby_detail->BirthStatus == 'Inborn')
                    <li role="presentation" @if($_COOKIE['neonatal_proforma'] == 'newbornform') class="active" @endif>
                        <a class="tab-main-menu" href="#newbornform" aria-controls="newbornform" role="tab" data-toggle="tab">New Born Examination</a>
                    </li>
                    @endif
                @else
                    <li role="presentation"  @if($_COOKIE['neonatal_proforma'] == 'dischargeform') class="active" @endif>
                        <a class="tab-main-menu" href="#dischargeform" aria-controls="dischargeform" role="tab" data-toggle="tab">Discharge Details</a>
                    </li>
                    <li role="presentation" @if($_COOKIE['neonatal_proforma'] == 'summaryform') class="active" @endif>
                        <a class="tab-main-menu" href="#summaryform" aria-controls="summaryform" role="tab" data-toggle="tab">Summary</a>
                    </li>
                @endif
            </ul>
            <!-- Tab panes -->
            <div class="tab-content tab-curve tab-view-shadow">
                <div role="tabpanel" class="tab-pane @if($_COOKIE['neonatal_proforma'] == 'babyform') active @endif" id="babyform">
                    {!! Form::hidden('BabyId',null) !!}
                    {!! Form::hidden('MotherId',null) !!}
                    <div class="col-md-6 col-sm-6" id="baby-category">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content row mx-0">
                                <div class="form-group row">
                                    <div class="col-md-3 label-control text-right">
                                        {!! Form::label('TestDate','Data Entry Date:', ['class'=>'required-label']) !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('TestDate',$current_date,['class'=>'form-control baby-dob', 'readonly' => 'true']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 label-control text-right">
                                        {!! Form::label('BabyName','Baby Name:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <div class="display-flex">
                                            @php 
                                                $default_name = \Config::get('constants.HIS_QUICK_REG_BABY_NAME');
                                                $default_name = strtolower($default_name);
                                            @endphp
                                            {!! Form::text('BabyName',null,['class'=>'form-control']) !!}
                                            @if (str_contains(strtolower($baby_detail->BabyName), $default_name))
                                                {!! Form::hidden('BMrNo', null,['id'=>'BMrNo']) !!}
                                                {!! Form::hidden('old_baby_name', $baby_detail->BabyName) !!}
                                                {!! Form::hidden('hms_call') !!}
                                                <span class="text-danger call-hms-2 pl-15 pt-5" title="Get data from HMS"><i class="fa fa-refresh"></i></span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 label-control text-right">
                                        {!! Form::label('DOB','DOB:', ['class'=>'required-label']) !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('DOB',null,['class'=>'form-control baby-dob', 'readonly' => 'true']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                        {!! Form::label('TOB','Time Of Birth:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input clear-xs">
                                        <div class="row">
                                            <div class="col-xs-3 text-center">
                                                <small>(Hour)</small>
                                            </div>
                                            <div class="col-xs-4 text-center">
                                                <small>(Minute)</small>
                                            </div>
                                            <div class="col-xs-4 text-center">
                                                <small>(Session)</small>
                                            </div>
                                            <div class="col-xs-4">
                                                {!! Form::select('TOB_TIME',$tob['time'],null,['class'=>'form-control']) !!}
                                            </div>
                                            <div class="col-xs-4">
                                                {!! Form::select('TOB_MINS',$tob['mins'],null,['class'=>'form-control']) !!}
                                            </div>
                                            <div class="col-xs-4">
                                                {!! Form::select('TOB_AM',['AM'=>'AM','PM'=>'PM'],null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('BirthStatus','Birth Status:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <input id="BirthStatus" data-size="small" name="BirthStatus" data-off="Outborn" data-on="Inborn" data-width="100" data-toggle="toggle" class="form-control switch-input" type="checkbox" @if(isset($baby_detail->BirthStatus) && $baby_detail->BirthStatus == 'Inborn') checked="checked" @endif>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                        {!! Form::label('BirthWeight','Birth Weight:', ['class'=>'required-label']) !!}
                                    </div>
                                    <div class="col-md-9 custom-input clear-xs">
                                        <div class="row">
                                            <div class="col-xs-6 text-center">
                                                <small>(In Grams)</small>
                                            </div>
                                            <div class="col-xs-6 text-center">
                                                <small>(In Kilo Grams)</small>
                                            </div>
                                            <div class="col-xs-6">
                                                {!! Form::input('text','BirthWeight',null,['class'=>'form-control']) !!}
                                            </div>
                                            <div class="col-xs-6">
                                                {!! Form::input('text','birth_weight',$baby_detail->BirthWeight_in_kilo,['class'=>'form-control','readonly'=>'true', 'id' => 'birth_weight']) !!}
                                            </div>
                                        </div>
                                        <label class="error help-block" for="BirthWeight" generated="true"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                        {!! Form::label('Gestation','Gestation:', ['class'=>'required-label']) !!}
                                    </div>
                                    <div class="col-md-9 custom-input clear-xs">
                                        <div class="row col-md-12 display-flex">
                                            <div>
                                                <small>(In Weeks)</small>
                                                {!! Form::text('g_weeks',null,['class'=>'form-control']) !!}
                                                <label class="error help-block" for="g_weeks" generated="true"></label> 
                                            </div>
                                            <div class="inbeween_two_fields">
                                                <span>+</span>
                                            </div>
                                            <div>
                                                <small>(In Days)</small>
                                                {!! Form::text('g_days',null,['class'=>'form-control']) !!}
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
                            <div class="widget-content row mx-0">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                        {!! Form::label('TestTime','Data Entry Time:', ['class'=>'required-label']) !!}
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
                                                {!! Form::select('TEST_TIME',$tob['time'],null,['class'=>'form-control ']) !!}
                                            </div>
                                            <div class="col-xs-4">
                                                {!! Form::select('TEST_MINS',$tob['mins'],null,['class'=>'form-control ']) !!}
                                            </div>
                                            <div class="col-xs-4">
                                                {!! Form::select('TEST_AM',['AM'=>'AM','PM'=>'PM'],null,['class'=>'form-control ']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('BabyBloodGroup','Baby\'s Blood Group:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('BabyBloodGroup',ValuelistHelpers::Blood_groups(),null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('BirthOrder','Birth Order:') !!} <i class="fa fa-info-circle bs-tooltip color-black-must" data-placement="right" data-original-title='To edit this field, go to baby registraion and change field "Multiple Pregnancy"'></i>
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('BirthOrder',[''=>'N/A']+ValuelistHelpers::mptypeNobabies(@$baby_detail->MultiplePregnancyType),null,['class'=>'form-control', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Sex','Sex:', ['class'=>'required-label']) !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Sex',['Male'=>'Male','Female'=>'Female','Indeterminate'=>'Indeterminate'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Length','Birth Length (cm):') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('Length',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('OFC','Birth Head Circumference (cm):') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('OFC',null,['class'=>'form-control','maxlength'=>'4']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Transfer Status','Transfer Status:', ['class'=>'required-label']) !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        @if(!isset($flow_wise_register) || empty($flow_wise_register) || $flow_wise_register != 'from-dashboard')  
                                            @if(Session::has('registration_start'))
                                                @if(Session::has('admission_module') && \Session::get('admission_module') == 'NICU_ADMISSION')
                                                    {!! Form::select('',['NICU'=>'NICU'],'NICU',['class'=>'form-control', 'disabled' => 'disabled']) !!}
                                                    <input type="hidden" name="transfer_status" value="NICU" />
                                                @else
                                                    {!! Form::select('transfer_status',ValuelistHelpers::getTransferstatus(),null,['class'=>'form-control', 'readonly', 'style'=>'pointer-events: none;', 'id'=>'transfer_status']) !!}
                                                @endif
                                            
                                            @elseif(isset($bed_logs['ward_name']) && $bed_logs['ward_name'] != '')
                                                @if($bed_logs['ward_name'] == 'Postnatal')
                                                @php
                                                    $bed_logs['ward_name'] = 'Postnatal Ward';
                                                @endphp
                                                @endif
                                                {!! Form::select('transfer_status',ValuelistHelpers::getTransferstatus(),$bed_logs['ward_name'],['class'=>'form-control','readonly', 'id'=>'transfer_status']) !!}
                                            
                                            @else
                                            
                                                {!! Form::select('transfer_status',ValuelistHelpers::getTransferstatus(),null,['class'=>'form-control']) !!}
                                            @endif
                                        @else
                                            {!! Form::select('',['NICU'=>'NICU'],'NICU',['class'=>'form-control', 'disabled' => 'disabled']) !!}
                                            <input type="hidden" name="transfer_status" value="NICU" />
                                        @endif
                                    </div>
                                </div>

                            {{--     <!-- <div class="form-group row nicu_bed_reg">
                                    <div class="col-md-3 text-right label-control">
                                        <label for="room_no">Room No:</label>
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <select class="form-control room-name" id="room_no" name="room_no">
                                            <option value="0" selected="selected">N/A</option>
                                        </select>
                                    </div>
                                </div> -->
                                <div class="form-group row nicu_bed_reg">
                                    <div class="col-md-3 text-right label-control">
                                        <label for="room_no">Room No:</label>
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        @if(isset($bed_logs['room_id']) && $bed_logs['room_id'] != '')
                                        {{ Form::text('room_id', $bed_logs['room_no'], ['class'=>'form-control room-name', 'id'=>'room_id', 'readonly']) }}
                                        <!-- <select class="form-control" name="room_id" readonly>
                                            <option value="{{ $bed_logs['room_id'] }}" selected="selected">{{ $bed_logs['room_no'] }}</option>
                                        </select> -->
                                        @else
                                        <!-- {{ Form::text('room_id', null, ['class'=>'form-control room-name', 'id'=>'room_id', 'readonly']) }} -->
                                        <select class="form-control room-name" id="room_no" name="room_id">
                                            @if(isset($room_list) && !empty($room_list))
                                            @foreach($room_list as $room_key => $room_val)
                                            <option value="{{ $room_key }}">{{ $room_val }}</option>
                                            @endforeach
                                            @else
                                            <option value="" selected="selected">N/A</option>
                                            @endif
                                        </select>
                                        @endif
                                    </div>
                                </div>
                                
                                @if(isset($bed_logs['bed_id']) && $bed_logs['bed_id'] != '')
                                <div class="form-group row nicu_bed_reg">
                                    <div class="col-md-3 text-right label-control">
                                        <label for="bed_id">Bed No:</label>
                                    </div>
                                    <div class="col-md-9 custom-input">
                                       <!--  <select class="form-control" name="bed_id" readonly>
                                            <option value="{{ $bed_logs['bed_id'] }}" selected="selected">{{ $bed_logs['bed_no'] }}</option>
                                        </select> -->
                                        {{ Form::text('bed_id', $bed_logs['bed_no'], ['class'=>'form-control bed-name', 'id'=>'bed_id', 'readonly']) }}
                                    </div>
                                </div>
                                @else
                                <div class="form-group row nicu_bed_reg">
                                    <div class="col-md-3 text-right label-control">
                                        <label for="bed_id">Bed No:</label>
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <select class="form-control bed-name" id="bed_id" name="bed_id">
                                            <option value="" selected="selected">N/A</option>
                                        </select>
                                        <!-- {{ Form::text('bed_id', null, ['class'=>'form-control bed-name', 'id'=>'bed_id', 'readonly']) }} -->
                                    </div>
                                </div>
                                @endif --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane @if($_COOKIE['neonatal_proforma'] == 'motherform') active @endif" id="motherform">
                    <div class="col-md-6 col-sm-6">
                        <div class="widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> Mother Details</h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('MotherTitle','Title:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::select('MotherTitle',[''=>'N/A','Ms.'=>'Ms.','Mrs.'=>'Mrs.','Miss.'=>'Miss.','Dr.'=>'Dr.'],null,['class'=>'form-control','tabindex'=>'1']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('MotherInitial','Initial:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::text('MotherInitial',null,['class'=>'form-control text-convertion-upper','tabindex'=>'2']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('MotherName','First Name:', ['class'=>'required-label']) !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::text('MotherName',null,['class'=>'form-control text-convertion-title','tabindex'=>'3']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('MotherLastName','Last Name:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('MotherLastName',null,['class'=>'form-control text-convertion-title','tabindex'=>'4']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('MotherDOB','DOB:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('MotherDOB',null,['class'=>'form-control parents-dob','readonly'=>true,'tabindex'=>'5']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('MothercYear','Completed Years:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('MothercYear',null,['class'=>'form-control','tabindex'=>'6']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('education_status','Mother\'s Education Level:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('education_status',ValuelistHelpers::getEducationstatus(),null,['class'=>'form-control','tabindex'=>'7']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Occupation','Occupation Type:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('Occupation',null,['class'=>'form-control text-convertion-title','tabindex'=>'8']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('occupation_status','Current Occupation Status:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('occupation_status',ValuelistHelpers::getOccupationstatus(),null,['class'=>'form-control','tabindex'=>'9']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Mobile','Contact No 1 :') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('Mobile',null,['class'=>'form-control','tabindex'=>'10']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('LandLine','Contact No 2 :') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('LandLine',null,['class'=>'form-control','tabindex'=>'11']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('MotherEmail','Email :') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('MotherEmail',null,['class'=>'form-control','tabindex'=>'12']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right  label-control mt-0">
                                        {!! Form::label('MotherSpokenLanguages','Mother Spoken Languages:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('MotherSpokenLanguages',null,['class'=>'form-control text-convertion-title','tabindex'=>'13']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <p class="divider">&nbsp;</p>
                                </div>
                            </div>
                        </div>
                        <div class="widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> Current Address</h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <!-- {!! Form::label('Address1','Address Line 1 (Door/Flat No./Home Name) :') !!} -->
                                        <label for="Address1">Address Line 1 :<br><small class="input-small">(Door /Flat No /Home Name)</small></label>
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('Address1',null,['class'=>'form-control','id'=>'Address1','tabindex'=>'14']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <!-- {!! Form::label('Address2','Address Line 2 (Street Name/Building Name):') !!} -->
                                        <label for="Address2">Address Line 2 :<br><small class="input-small">(Street Name/Building Name)</small></label>
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('Address2',null,['class'=>'form-control','id'=>'Address2','tabindex'=>'15']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <!-- {!! Form::label('Address3','Address Line 3 (City):') !!} -->
                                        <label for="Address3">Address Line 3 :<br><small class="input-small">(City)</small></label>
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('Address3',null,['class'=>'form-control','id'=>'Address3','tabindex'=>'16']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <!-- {!! Form::label('Address4','Address Line 4 (Pin code/Zip code):') !!} -->
                                        <label for="Address4">Address Line 4 :<br><small class="input-small">(Pin code/Zip code)</small></label>
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('Address4',null,['class'=>'form-control','id'=>'Address4','tabindex'=>'17']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <!-- {!! Form::label('Address5','Address Line 5 (Country):') !!} -->
                                        <label for="Address5">Address Line 5 :<br><small class="input-small">(Country)</small></label>
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('Address5',null,['class'=>'form-control','id'=>'Address5','tabindex'=>'18']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <p class="divider">&nbsp;</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" col-md-6 col-sm-6">
                        <div class="widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> Father Details</h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right  label-control mt-0">
                                        {!! Form::label('PartnerTitle','Title:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('PartnerTitle',[''=>'N/A','Mr.'=>'Mr.','Dr.'=>'Dr.'],null,['class'=>'form-control','tabindex'=>'19']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('PartnerInitial','Initial:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('PartnerInitial',null,['class'=>'form-control text-convertion-upper','tabindex'=>'20']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('PartnerName','First Name:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('PartnerName',null,['class'=>'form-control text-convertion-title','tabindex'=>'21']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('PartnerLastName','Last Name:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('PartnerLastName',null,['class'=>'form-control text-convertion-title','tabindex'=>'22']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('PartnerDOB','DOB:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('PartnerDOB',null,['class'=>'form-control parents-dob','readonly'=>'true','tabindex'=>'23']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('PartnercYear','Completed Years:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('PartnercYear',null,['class'=>'form-control','tabindex'=>'24']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('partner_education_status','Father\'s Education Level:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('partner_education_status',ValuelistHelpers::getEducationstatus(),null,['class'=>'form-control','tabindex'=>'25']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('PartnerOccupation','Occupation Type:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('PartnerOccupation',null,['class'=>'form-control','tabindex'=>'26']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('partner_occupation_status','Current Occupation Status:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('partner_occupation_status',ValuelistHelpers::getOccupationstatus(),null,['class'=>'form-control','tabindex'=>'27']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('PartnerContact','Contact No 1:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('PartnerContact',null,['class'=>'form-control','tabindex'=>'28']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('PartnerMobile','Contact No 2 :') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('PartnerMobile',null,['class'=>'form-control','tabindex'=>'29']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Email','Email:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('Email',null,['class'=>'form-control','tabindex'=>'30']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('FatherSpokenLanguages','Father Spoken Languages:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('FatherSpokenLanguages',null,['class'=>'form-control','tabindex'=>'31']) !!}
                                    </div>
                                </div>
                                <div class="form-group partner_details_lables">
                                    {!! Form::checkbox('samecontacts', 1, null, ['class' => 'field samecontacts']) !!}
                                    {!! Form::label('samecontacts','Same as mother\'s contact details including languages') !!}
                                </div>
                            </div>
                        </div>
                        <div class="widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> Mailing Address</h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <!-- {!! Form::label('FatherAddress1','Address Line 1 :<small>(Door/Flat No./Home Name)</small>') !!} -->
                                        <label for="FatherAddress1">Address Line 1 :<br><small class="input-small">(Door /Flat No /Home Name)</small></label>
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('FatherAddress1',null,['class'=>'form-control', 'id'=>'FatherAddress1']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <label for="FatherAddress2">Address Line 2 :<br><small class="input-small">(Street Name/Building Name)</small></label>
                                        <!-- {!! Form::label('FatherAddress2','Address Line 2 (Street Name/Building Name):') !!} -->
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('FatherAddress2',null,['class'=>'form-control', 'id'=>'FatherAddress2']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <!-- {!! Form::label('City','Address Line 3 (City):') !!} -->
                                        <label for="City">Address Line 3 :<br><small class="input-small">(City)</small></label>
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('City',null,['class'=>'form-control', 'id'=>'City']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <label for="Postcode">Address Line 4 :<br><small class="input-small">(Pin code/Zip code)</small></label>
                                        <!-- {!! Form::label('Postcode','Address Line 4 (Pin code/Zip code):') !!} -->
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('Postcode',null,['class'=>'form-control', 'id'=>'Postcode']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <label for="Country">Address Line 5 :<br><small class="input-small">(Country)</small></label>
                                        <!-- {!! Form::label('Country','Address Line 5 (Country):') !!} -->
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('Country',null,['class'=>'form-control', 'id'=>'Country']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::checkbox('sameasmailaddress', 1, null, ['class' => 'field sameasmailaddress']) !!}
                                    {!! Form::label('sameasmailaddress','Same as Current Address') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="col-md-12 p-0 tab-pane @if($_COOKIE['neonatal_proforma'] == 'obform') active @endif" id="obform">
                    <div class="widget box">
                        <div class="widget-header">
                            <h4><i class="fa fa-reorder"></i> </h4>
                        </div>
                        <div class="widget-content row mx-0">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('Consanguinity','Consanguinity:') !!}
                                    <input id="Consanguinity" data-size="small" name="Consanguinity" data-on="Yes" data-off="No" data-width="100" checked data-toggle="toggle" class="form-control switch-input" type="checkbox">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <div class="col-md-12 custom-input">
                                        <table class="medi table table-add-more full-width-fix">
                                            <thead>
                                                <tr class="master-add-header">
                                                    <th width="20%">Medical Problems
                                                        <a href="javascript:void(0)" class="add_master_data" data-modal_header="Medical Problems" data-destination_elements="temp_medi_probs,Problems[]" data-option_value="id" data-option_text="Name" data-mas_table="mas_medical_problems">
                                                            <i class="fa fa-info-circle bs-tooltip add-neo-consultant" data-placement="right" data-original-title="Add Medical Problems"></i>
                                                        </a>
                                                    </th>
                                                    <th width="20%">Medications/Dose/Frequency</th>
                                                    <th>
                                                        <span>
                                                            <a class="btn_add btn btn-success btn-view medi_add" href="javascript:void(0);"><i class="fa fa-plus"></i> <span></span></a>
                                                        </span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <div class="hidden">
                                                    {!! Form::select('temp_medi_probs',$probs) !!}
                                                </div>
                                                @if (isset($pbm_data) && count($pbm_data) > 0)
                                                @foreach ($pbm_data as $data)
                                                <tr>
                                                    <td>{!! Form::select('Problems[]',$probs,$data['Problem'],["class"=>'form-control input-width-xlarge']) !!}</td>
                                                    <td><input type="text" name="Medications[]" value="{!! $data['Medication']; !!}" class="form-control input-width-xlarge" /></td>
                                                    <td><span class="fa fa-trash btn btn-danger btn-view remove-medi"></span></td>
                                                </tr>
                                                @endforeach
                                                @else
                                                <tr>
                                                    <td>{!! Form::select('Problems[]',$probs,'',["class"=>"form-control input-width-xlarge"]) !!}</td>
                                                    <td><input type="text" name="Medications[]" class="form-control input-width-xlarge" value="" /></td>
                                                    <td><span class="fa fa-trash btn btn-danger btn-view remove-medi"></span></td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td></td>
                                                    <td><label for="Medications[]" generated="true" class="error help-block"></label></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-5 pl-0">
                                    <table class="gravida col-md-7 text-center">
                                        <thead>
                                            <tr>
                                                <th>Gravida</th>
                                                <th>Para</th>
                                                <th>Livebirth</th>
                                                <th>Abortion</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="form-group">{!! Form::text('G_Value',null,['class'=>'form-control']) !!}</td>
                                                <td class="form-group">{!! Form::text('P_Value',null,['class'=>'form-control']) !!}</td>
                                                <td class="form-group"> {!! Form::text('L_Value',null,['class'=>'form-control']) !!}</td>
                                                <td class="form-group">{!! Form::text('A_Value',null,['class'=>'form-control ']) !!}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-5">
                                    <label class="error help-block" for="G_Value" generated="true"></label>
                                    <label class="error help-block" for="P_Value" generated="true"></label>
                                    <label class="error help-block" for="L_Value" generated="true"></label>
                                    <label class="error help-block" for="A_Value" generated="true"></label>   
                                </div>
                            </div>
                            <div class="col-md-12 overflow-auto">
                                <div class="form-group row">
                                    <div class="col-md-12 custom-input">
                                        <table class="delivery table table-add-more full-width-fix">
                                            <thead>
                                                <tr class="master-add-header">
                                                    <th>Year</th>
                                                    <th>Place</th>
                                                    <th>Delivery</th>
                                                    <th>Complications</th>
                                                    <th>Gender</th>
                                                    <th>GA (wks)</th>
                                                    <th>B.Wt (grams)</th>
                                                    <th>Health</th>
                                                    <th class="input-width">Details</th>
                                                    <th>
                                                        <span>
                                                            <a class="btn_add btn btn-success btn-view delivery_add" href="javascript:void(0);"><i class="fa fa-plus"></i> <span></span></a>
                                                        </span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (isset($delivery_details) && count($delivery_details) > 0)
                                                @foreach ($delivery_details as $com_data)
                                                <tr>
                                                    <td><input type="text" class="form-control input-width-mini" id="OH_YEAR" name="Year[]" value="{!! $com_data['Year']; !!}" /></td>
                                                    <td><input type="text" class="form-control" name="Place[]" value="{!! $com_data['Place']; !!}" /></td>
                                                    <td class="input-width-medium">{!! Form::select('Delivery[]',[''=>'N/A','Vaginal'=>'Vaginal','LSCS'=>'LSCS','Instrumental'=>'Instrumental','Breech'=>'Breech'], $com_data['Delivery'], ['class'=>'form-control']) !!}</td>
                                                    <td><input type="text" class="form-control" name="Complications[]" value="{!! $com_data['Complications']; !!}" /></td>
                                                    <td class="input-width-medium">{!! Form::select('Gender[]',[''=>'N/A','Male'=>'Male','Female'=>'Female','Indeterminate'=>'Indeterminate'], $com_data['Gender'], ['class'=>'form-control']) !!}</td>
                                                    <td><input type="text" class="form-control input-width-mini" name="GA[]" value="{!! $com_data['GA']; !!}" /></td>
                                                    <td><input type="text" class="form-control input-width-mini" name="BW[]" value="{!! $com_data['BW']; !!}" /></td>
                                                    <td class="input-width-medium">{!! Form::select('Health[]',[''=>'N/A','Alive'=>'Alive','Died'=>'Died','Unhealthy'=>'Unhealthy'], $com_data['Health'], ['class'=>'form-control']) !!}</td>
                                                    <td><input type="text" name="details[]" class="form-control input-width" value="{!! @$com_data['details']; !!}" /></td>
                                                    <td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <label for="OH_YEAR" generated="true" class="error help-block"></label>
                                <label for="Year[]" generated="true" class="error help-block"></label>
                                <label for="GA[]" generated="true" class="error help-block"></label>
                                <label for="BW[]" generated="true" class="error help-block"></label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- PGform -->
                <div role="tabpanel" class="tab-pane @if($_COOKIE['neonatal_proforma'] == 'pgform') active @endif" id="pgform">
                    <div class="col-md-6 col-sm-6">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Conception','Conception:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Conception',[''=>'N/A','Not Known'=>'Not Known','Spontaneous'=>'Spontaneous','Medical ART'=>'Medical ART','ART'=>'ART'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row" id="TypeofARTDiv">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('TypeofART','Type of ART:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('TypeofART',['Not Known'=>'Not Known', 'SO'=>'SO','CC10'=>'CC10','CC50'=>'CC50','CC100'=>'CC100','IUI'=>'IUI','SO/IUI'=>'SO/IUI','IVF'=>'IVF','ICSI'=>'ICSI','ICSI - DEP'=>'ICSI - DEP','ICSI - DOP'=>'ICSI - DOP','ICSI - Donor Sperm'=>'ICSI - Donor Sperm','GIFT'=>'GIFT','ZIFT'=>'ZIFT'], null, ['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row" id="EmbryoTransferDiv">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('EmbryoTransfer','Embryo Transfer:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('EmbryoTransfer',['Not Known'=>'Not Known','Not applicable'=>'Not applicable','Fresh Embryo Transfer'=>'Fresh Embryo Transfer','Frozen Embryo Transfer'=>'Frozen Embryo Transfer'], null, ['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row" id="PlaceofARTDiv">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('PlaceofART','Place of ART:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('PlaceofART',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('LMP','LMP:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('LMP',null,['class'=>'form-control previous-one-year', 'readonly' => 'true']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('EDDbyUSG','EDD by USG:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('EDDbyUSG',null,['class'=>'form-control next-one-year', 'readonly' => 'true']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('EDDbyDates','EDD by Dates:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('EDDbyDates',null,['class'=>'form-control next-one-year', 'readonly' => 'true']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('MotherBloodGroup',"Mother's Blood Group:") !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('MotherBloodGroup',ValuelistHelpers::Blood_groups(),null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control md-mt-30">
                                            {!! Form::label('HIV','HIV:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::select('HIV',['Non-reactive'=>'Non-reactive','Reactive'=>'Reactive','Unknown'=>'Unknown'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('reactive',4)]) !!}
                                        <!-- <input class="checkbox-tools" type="radio" name="HIV" id="non-reactive" value="Non-reactive" @if(isset($results->HIV) && $results->HIV == 'Non-reactive') checked @endif>
                                            <label class="for-checkbox-tools bg-successs" for="non-reactive">
                                              <i></i>
                                              Non Reactive
                                            </label>
                                            
                                            <input class="checkbox-tools" type="radio" name="HIV" id="reactive" value="Reactive" @if(isset($results->HIV) && $results->HIV == 'Reactive') checked @endif>
                                            <label class="for-checkbox-tools bg-dangerr" for="reactive">
                                              <i></i>
                                              Reactive
                                            </label>
                                            
                                            <input class="checkbox-tools" type="radio" name="HIV" id="Unknown" value="Unknown" @if(isset($results->HIV) && $results->HIV == 'Unknown') checked @endif>
                                            <label class="for-checkbox-tools bg-warningg" for="Unknown">
                                              <i></i>
                                              UNKNOWN
                                          </label> -->
                                      </div>
                                  </div>
                                  <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-30">
                                        {!! Form::label('HepatitisB','HepatitisB:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('HepatitisB',['Negative'=>'Negative','Positive'=>'Positive','Unknown'=>'Unknown'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('reactive',4)]) !!}
                                        <!-- <input class="checkbox-tools" type="radio" name="HepatitisB" id="Negative" value="Negative" @if(isset($results->HepatitisB) && $results->HepatitisB == 'Negative') checked @endif>
                                            <label class="for-checkbox-tools bg-successs" for="Negative">
                                              <i></i>
                                              Negative
                                            </label>
                                            
                                            <input class="checkbox-tools" type="radio" name="HepatitisB" id="Positive" value="Positive" @if(isset($results->HepatitisB) && $results->HepatitisB == 'Positive') checked @endif>
                                            <label class="for-checkbox-tools bg-dangerr" for="Positive">
                                              <i></i>
                                              Positive
                                            </label>
                                            
                                            <input class="checkbox-tools" type="radio" name="HepatitisB" id="unknown" value="Unknown" @if(isset($results->HepatitisB) && $results->HepatitisB == 'Unknown') checked @endif>
                                            <label class="for-checkbox-tools bg-warningg" for="unknown">
                                              <i></i>
                                              UNKNOWN
                                          </label> -->
                                      </div>
                                  </div>
                                  <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-30">
                                        {!! Form::label('VDRL','VDRL:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('VDRL',['Non-reactive'=>'Non-reactive','Reactive'=>'Reactive','Unknown'=>'Unknown'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('reactive',4)]) !!}
                                        <!-- <input class="checkbox-tools" type="radio" name="VDRL" id="Non-Reactive" value="Non-reactive" @if(isset($results->VDRL) && $results->VDRL == 'Non-reactive') checked @endif>
                                            <label class="for-checkbox-tools bg-successs" for="Non-Reactive">
                                              <i></i>
                                              Non Reactive
                                            </label>
                                            
                                            <input class="checkbox-tools" type="radio" name="VDRL" id="Reactive" value="Reactive" @if(isset($results->VDRL) && $results->VDRL == 'Reactive') checked @endif>
                                            <label class="for-checkbox-tools bg-dangerr" for="Reactive">
                                              <i></i>
                                              Reactive
                                            </label>
                                            
                                            <input class="checkbox-tools" type="radio" name="VDRL" id="Un-known" value="Un-known" @if(isset($results->VDRL) && $results->VDRL == 'Unknown') checked @endif>
                                            <label class="for-checkbox-tools bg-warningg" for="Un-known">
                                              <i></i>
                                              UNKNOWN
                                          </label> -->
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
                                    {!! Form::label('Booked','Booked:') !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    <input checked data-toggle="toggle" data-width="100" data-size="small" class="form-control" id="Booked" name="Booked" data-on="Yes" data-off="No" 
                                    type="checkbox">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label('Booking','Place of Booking:') !!}
                                    <a href="javascript:void(0)" class="add_master_data" data-modal_header="Booking Place" data-destination_elements="Booking,PlaceofSupervision" data-option_value="id" data-option_text="hospital_name" data-mas_table="mas_referral">
                                        <i class="fa fa-info-circle bs-tooltip add-neo-consultant" data-placement="right" data-original-title="Add Booking Place"></i>
                                    </a>
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::select('Booking', [''=>'N/A']+ValuelistHelpers::mas_referral_list(), null,['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label('Supervised','Supervised:') !!}
                                </div>
                                <div class="col-md-9 custom-input">   
                                    <input checked data-toggle="toggle" data-size="small" data-width="100" class="form-control" id="Supervised" height="5px" name="Supervised" data-on="Yes" data-off="No" type="checkbox">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control mt-0">
                                    {!! Form::label('PlaceofSupervision','Place of Supervision:') !!}
                                    <a href="javascript:void(0)" class="add_master_data" data-modal_header="Supervision Place" data-destination_elements="Booking,PlaceofSupervision" data-option_value="id" data-option_text="hospital_name" data-mas_table="mas_referral">
                                        <i class="fa fa-info-circle bs-tooltip add-neo-consultant" data-placement="right" data-original-title="Add Supervision Place"></i>
                                    </a>
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::select('PlaceofSupervision', [''=>'N/A']+ValuelistHelpers::mas_referral_list(), null,['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control mt-0">
                                    {!! Form::label('adjustedtrisomies','Adjusted Risk for Trisomies available:') !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    <input data-toggle="toggle" data-size="small" data-width="100" class="form-control" id="adjustedtrisomies" height="5px" name="adjustedtrisomies" data-on="Yes" data-off="No" type="checkbox">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control mt-0">
                                    {!! Form::label('AdjustedRiskForTrisomy21','Adjusted Risk For Trisomy21:') !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::text('AdjustedRiskForTrisomy21',null,['class'=>'form-control', 'id'=> 'AdjustedRiskForTrisomy21', 'readonly' => 'true']) !!}
                                </div>
                            </div>
                            <div class="form-group row display-none">
                                <div class="col-md-3 text-right label-control mt-0">
                                    {!! Form::label('another_adjusted_risk_for_trisomy21','Another Adjusted Risk For Trisomy21:') !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::text('another_adjusted_risk_for_trisomy21',null,['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control mt-0">
                                    {!! Form::label('AdjustedRiskForTrisomy18','Adjusted Risk For Trisomy18:') !!}  
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::text('AdjustedRiskForTrisomy18',null,['class'=>'form-control', 'id'=> 'AdjustedRiskForTrisomy18', 'readonly' => 'true']) !!}
                                </div>
                            </div>
                            <div class="form-group row display-none">
                                <div class="col-md-3 text-right label-control mt-0">
                                    {!! Form::label('another_adjusted_risk_for_trisomy18','Another Adjusted Risk For Trisomy18:') !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::text('another_adjusted_risk_for_trisomy18',null,['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control mt-0">
                                    {!! Form::label('AdjustedtedRiskForTrisomy13','Adjusted Risk For Trisomy13:') !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::text('AdjustedRiskForTrisomy13',null,['class'=>'form-control', 'id'=> 'AdjustedRiskForTrisomy13', 'readonly' => 'true']) !!}
                                </div>
                            </div>
                            <div class="form-group row display-none">
                                <div class="col-md-3 text-right label-control mt-0">
                                    {!! Form::label('another_adjusted_risk_for_trisomy13','Another Adjusted Risk For Trisomy13:') !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::text('another_adjusted_risk_for_trisomy13',null,['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label('OtherInvestigations','Other Investigations:') !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::textarea('OtherInvestigations',null,['class'=>'form-control','rows'=>'5']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Pregnancy Contd -->
            <div role="tabpanel" class="tab-pane @if($_COOKIE['neonatal_proforma'] == 'pgcform') active @endif plr-15" id="pgcform">
                <div class="widget box col-md-12">
                    <div class="widget-header">
                        <h4><i class="fa fa-reorder"></i> </h4>
                    </div>
                    <div class="widget-content row mx-0">
                        <div class="col-md-5 ">
                            <div class="form-group row">
                                <div class="col-md-5 text-right label-control">
                                    {!! Form::label('MultiplePregnancy','MultiplePregnancy:') !!}
                                </div>
                                <div class="col-md-7 custom-input"> 
                                    <input id="MultiplePregnancy" data-size="small" name="MultiplePregnancy" data-on="Yes" data-off="No" data-width="100" checked data-toggle="toggle"  class="form-control" type="checkbox">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-5 text-right label-control">
                                    {!! Form::label('PregnancyComplications','Pregnancy Complications:') !!}
                                </div>
                                <div class="col-md-7 custom-input">
                                    <input id="PregnancyComplications" data-size="small" name="PregnancyComplications" data-on="Yes" data-off="No" data-width="100" checked data-toggle="toggle"  class="form-control" type="checkbox">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 complication-disable overflow-auto">
                            <div class="col-md-7 form-group row">
                                <div class="col-md-12 custom-input">
                                    <table class="complication table table-add-more full-width-fix">
                                        <thead>
                                            <tr class="master-add-header">
                                                <th>Complication
                                                    <a href="javascript:void(0)" class="add_master_data" data-modal_header="Complications" data-destination_elements="temp_complications,Complication[]" data-option_value="id" data-option_text="Name" data-mas_table="mas_complication">
                                                        <i class="fa fa-info-circle bs-tooltip add-neo-consultant" data-placement="right" data-original-title="Add Complications"></i>
                                                    </a>
                                                </th>
                                                <th>Treatment</th>
                                                <th colspan="2">Duration </th>
                                                <th>
                                                    <span>
                                                        <a class="btn_add btn btn-success btn-view complication_add" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                                                    </span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <div class="hidden">
                                                {!! Form::select('temp_complications',ValuelistHelpers::getMastercomplications(),null) !!}
                                            </div>
                                            <tr>
                                                <td class="form-group">{!! Form::select('Complication[]',ValuelistHelpers::getMastercomplications(),null,["class"=>"complication-disabled complication-search","id"=>"complication-search-0", "style"=>"width: 257px;"]) !!}</td>
                                                <td class="form-group"> {!!Form::text('Treatments[]',null,['class'=>'form-control input-width-large complication-disabled']) !!}</td>
                                                <td class="form-group"> {!!Form::text('duration_in_weeks[]',null,['class'=>'form-control input-width-medium complication-disabled','id' => 'duration_in_weeks']) !!}</td>
                                                <td class="form-group"> {!!Form::select('duration_unit[]',ValuelistHelpers::getdurationUnit(),null,['class'=>'form-control input-width-medium complication-disabled']) !!}</td>
                                                <td><span class="fa fa-trash btn btn-danger btn-view remove-medi"></span></td>
                                            </tr>
                                        </tbody>
                                    </table> 
                                    <table>
                                        <tbody>                                        
                                            <tr>
                                                <td colspan="4"><label for="duration_in_weeks" generated="true" class="error help-block"></label></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
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
                                                <td class="form-group"><input type="text" value="{{ @$datingScan['date'] }}" class="form-control input-width-medium"  name="datingdate" readonly /></td>
                                                <td class="form-group"><input type="text" value="{{ @$datingScan['Gestation'] }}" class="form-control input-width-medium"  name="datinggestations" /></td>
                                                <td class="form-group"><input type="text" value="{{ @$datingScan['Finding'] }}" name="datingfindings" class="form-control input-width-large"  /></td>
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
                                                <td  class="form-group"><input type="text" name="analogdate" value="{{ @$analogScan['date'] }}" class="form-control input-width-medium" readonly /></td>
                                                <td  class="form-group"><input type="text" name="analoggestations" value="{{ @$analogScan['Gestation'] }}" class="form-control input-width-medium" /></td>
                                                <td  class="form-group"><input type="text" name="analogfindings"   value="{{ @$analogScan['Finding'] }}"  class="form-control input-width-large"  /></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><label for="analoggestations" generated="true" class="error help-block"></label></td>
                                            </tr>
                                        </tbody>
                                    </table> 
                                </div>
                            </div>
                        </div>
                            <!-- <div class="col-md-5">
                                <table class="col-md-12 plr-0 usg table-add-more">
                                    <thead>
                                        <tr>
                                            <th colspan="3"><u>Anomaly Scan</u></th>
                                        </tr>
                                        <tr>
                                            <th><h5><strong>Gestation In Weeks</strong></h5></th>
                                            <th><h5><strong>Findings</strong></h5></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td  class="form-group"><input type="text" name="analoggestations" value="{{ @$analogScan['Gestation'] }}" class="form-control input-width-medium" /></td>
                                            <td  class="form-group"><input type="text" name="analogfindings"   value="{{ @$analogScan['Finding'] }}"  class="form-control input-width-large"  /></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><label for="analoggestations" generated="true" class="error help-block"></label></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div> -->
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
                                                    <th>
                                                        <span>
                                                            <a class="btn_add btn btn-success btn-view any-further-scan-add" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                                                        </span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td  class="form-group"><input type="text" class="form-control input-width-medium"  name="otherdate[]" readonly /></td>
                                                    <td  class="form-group"><input type="text" class="form-control input-width-medium"  name="othergestations[]" /></td>
                                                    <td  class="form-group"><input type="text" name="otherfindings[]" class="form-control input-width-large"  /></td>
                                                    <td class="form-group"><span class="fa fa-trash btn btn-danger btn-view remove-usg"></span></td>
                                                </tr>
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
                                                    <th>
                                                        <span>
                                                            <a class="btn_add btn btn-success btn-view doppler-scan-add" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                                                        </span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td  class="form-group"><input type="text" class="form-control input-width-medium"  name="dopplerdate[]" readonly /></td>
                                                    <td  class="form-group"><input type="text" class="form-control input-width-medium"  name="dopplergestations[]" /></td>
                                                    <td  class="form-group"><input type="text" name="dopplerfindings[]" class="form-control input-width-large"  /></td>
                                                    <td class="form-group"><span class="fa fa-trash btn btn-danger btn-view remove-usg"></span></td>
                                                </tr>
                                            </tbody>
                                        </table> 
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                
                                <span><label for="dopplergestations[]" generated="true" class="error help-block"></label></span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Labour Form -->
                <div role="tabpanel" class="tab-pane @if($_COOKIE['neonatal_proforma'] == 'labform') active @endif" id="labform">
                    <div class="col-md-6 col-sm-6">
                        <div class="widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content row mx-0">
                                <div class="form-group row">
                                    <div class="col-md-4 text-right label-control">
                                        {!! Form::label('AntenatalSteroids','Antenatal Steroids:') !!}
                                    </div>
                                    <div class="col-md-8 custom-input">
                                        <input id="AntenatalSteroids" data-size="small" data-width="100" name="AntenatalSteroids" data-on="Yes" data-off="No" checked data-toggle="toggle"  class="form-control" type="checkbox">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-30">
                                        {!! Form::label('antenatal_MgSO4','Antenatal MgSO4 For Neuroprotection:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('antenatal_MgSO4',['N/A'=>'N/A','No'=>'No','Yes'=>'Yes'],null,['class'=>'form-control']) !!}
                                        <!-- <input class="checkbox-tools" type="radio" name="antenatal_MgSO4" id="N/A" value="N/A" @if(isset($results->antenatal_MgSO4) && $results->antenatal_MgSO4 == 'N/A') checked @endif>
                                            <label class="for-checkbox-tools bg-primary" for="N/A">
                                              <i></i>
                                              N/A
                                            </label>
                                            
                                            <input class="checkbox-tools" type="radio" name="antenatal_MgSO4" id="No" value="No" @if(isset($results->antenatal_MgSO4) && $results->antenatal_MgSO4 == 'No') checked @endif>
                                            <label class="for-checkbox-tools bg-primary" for="No">
                                              <i></i>
                                              NO
                                            </label>
                                            
                                            <input class="checkbox-tools" type="radio" name="antenatal_MgSO4" id="Yes" value="Yes" @if(isset($results->antenatal_MgSO4) && $results->antenatal_MgSO4 == 'Yes') checked @endif>
                                            <label class="for-checkbox-tools bg-primary" for="Yes">
                                              <i></i>
                                              Yes
                                          </label> -->
                                      </div>
                                  </div>
                                  <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        {!! Form::label('typeofsteroids','Type of Steroids:',['class'=>'title']) !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('typeofsteroids', ['N/A'=>'N/A','Dexa'=>'Dexa','Beta'=>'Beta'],null,['class'=>'form-control']) !!}
                                        <!-- <input class="checkbox-tools" type="radio" name="typeofsteroids" id="N-A" value="N/A" @if(isset($results->typeofsteroids) && $results->typeofsteroids == 'N/A') checked @endif>
                                            <label class="for-checkbox-tools bg-primary" for="N-A">
                                              <i></i>
                                              N/A
                                            </label>
                                            
                                            <input class="checkbox-tools" type="radio" name="typeofsteroids" id="Dexa" value="Dexa" @if(isset($results->typeofsteroids) && $results->typeofsteroids == 'Dexa') checked @endif>
                                            <label class="for-checkbox-tools bg-primary" for="Dexa">
                                              <i></i>
                                              Dexa
                                            </label>
                                            
                                            <input class="checkbox-tools" type="radio" name="typeofsteroids" id="Beta" value="Beta" @if(isset($results->typeofsteroids) && $results->typeofsteroids == 'Beta') checked @endif>
                                            <label class="for-checkbox-tools bg-primary" for="Beta">
                                              <i></i>
                                              Beta
                                          </label> -->
                                      </div>
                                  </div>
                                  <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        {!! Form::label('LastDoseDeliveryInterval','Last Dose Delivery Interval:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('LastDoseDeliveryInterval', [ "" => "N/A", "< 24 hrs" => '< 24 hrs','24 hrs - 7 days'=>'24 hrs - 7 days',  "> 7 days" => "> 7 days"],null,['class'=>'form-control']) !!}
                                        <!-- <input class="checkbox-tools" type="radio" name="LastDoseDeliveryInterval" id="LastDoseDeliveryIntervalN-A" value="N/A" @if(isset($results->LastDoseDeliveryInterval) && $results->LastDoseDeliveryInterval == 'N/A') checked @endif>
                                            <label class="for-checkbox-tools bg-primary" for="LastDoseDeliveryIntervalN-A">
                                              <i></i>
                                              N/A
                                            </label>
                                            
                                            <input class="checkbox-tools" type="radio" name="LastDoseDeliveryInterval" id="24-hrs" value="< 24 hrs" @if(isset($results->LastDoseDeliveryInterval) && $results->LastDoseDeliveryInterval == '< 24 hrs') checked @endif>
                                            <label class="for-checkbox-tools bg-primary" for="24-hrs">
                                              <i></i>
                                              < 24 Hrs
                                            </label>
                                            
                                            <input class="checkbox-tools" type="radio" name="LastDoseDeliveryInterval" id="24hrs-7" value="24 hrs - 7" @if(isset($results->LastDoseDeliveryInterval) && $results->LastDoseDeliveryInterval == '24 hrs - 7') checked @endif>
                                            <label class="for-checkbox-tools bg-primary" for="24hrs-7">
                                              <i></i>
                                              24 hrs <br>- 7 days
                                            </label>
                                            
                                            <input class="checkbox-tools" type="radio" name="LastDoseDeliveryInterval" id="7days" value="> 7 days" @if(isset($results->LastDoseDeliveryInterval) && $results->LastDoseDeliveryInterval == '> 7 days') checked @endif>
                                            <label class="for-checkbox-tools bg-primary" for="7days">
                                              <i></i>
                                              > 7 days
                                          </label> -->
                                      </div>
                                  </div>
                                  <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('SteroidCourse','Steroid Course:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('SteroidCourse',[''=>'N/A','Complete'=>'Complete','Partial/Incomplete'=>'Partial/Incomplete','Multiple'=>'Multiple'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Labour','Labour:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <input id="Labour" data-size="small" data-width="100" name="Labour" data-on="Yes" data-off="No" checked data-toggle="toggle"  class="form-control" type="checkbox">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        {!! Form::label('NatureofLabour','Nature of Labour:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('NatureofLabour',[''=>'N/A','Spontaneous'=>'Spontaneous','Induced'=>'Induced'],null,['class'=>'form-control']) !!}
                                        <!-- <input class="checkbox-tools" type="radio" name="NatureofLabour" id="NatureofLabourN-A" value="N/A" @if(isset($results->NatureofLabour) && $results->NatureofLabour == 'N/A') checked @endif>
                                            <label class="for-checkbox-tools bg-primary" for="NatureofLabourN-A">
                                              <i></i>
                                              N/A
                                            </label>
                                            
                                            <input class="checkbox-tools" type="radio" name="NatureofLabour" id="Spontaneous" value="Spontaneous" @if(isset($results->NatureofLabour) && $results->NatureofLabour == 'Spontaneous') checked @endif>
                                            <label class="for-checkbox-tools bg-primary" for="Spontaneous">
                                              <i></i>
                                              Spont <br>-aneous
                                            </label>
                                            
                                            <input class="checkbox-tools" type="radio" name="NatureofLabour" id="Induced" value="Induced" @if(isset($results->NatureofLabour) && $results->NatureofLabour == 'Induced') checked @endif>
                                            <label class="for-checkbox-tools bg-primary" for="Induced">
                                              <i></i>
                                              Induced
                                          </label> -->
                                      </div>
                                  </div>
                                  <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        {!! Form::label('Syntocinon','Syntocinon:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Syntocinon',ValuelistHelpers::getSyntocinon(),null,['class'=>'form-control']) !!}
                                        <!-- <input class="checkbox-tools" type="radio" name="Syntocinon" id="Syntocinon1" value="1" @if(isset($results->Syntocinon) && $results->Syntocinon == '1') checked @endif>
                                            <label class="for-checkbox-tools bg-primary" for="Syntocinon1">
                                              <i></i>
                                              Given
                                            </label>
                                            
                                            <input class="checkbox-tools" type="radio" name="Syntocinon" id="Syntocinon2" value="2" @if(isset($results->Syntocinon) && $results->Syntocinon == '2') checked @endif>
                                            <label class="for-checkbox-tools bg-primary" for="Syntocinon2">
                                              <i></i>
                                              Not Given
                                            </label>
                                            
                                            <input class="checkbox-tools" type="radio" name="Syntocinon" id="Syntocinon3" value="3" @if(isset($results->Syntocinon) && $results->Syntocinon == '3') checked @endif>
                                            <label class="for-checkbox-tools bg-primary" for="Syntocinon3">
                                              <i></i>
                                              Not known
                                          </label> -->
                                      </div>
                                  </div>
                                  <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('CommentOnLiquor','Comment On Liquor:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('CommentOnLiquor',[''=>'N/A','Clear'=>'Clear','Meconium Stained'=>'Meconium Stained','Blood Stained'=>'Blood Stained','Foul Smelling'=>'Foul Smelling'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        {!! Form::label('sepsis_in_mother',' Risk Factors For Sepsis In Mothers:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('sepsis_in_mother', ['N/A'=>'N/A', 'No'=>'No', 'Yes'=>'Yes'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="text-right col-md-3 label-control">
                                        {!! Form::label('sepsis_in_mother_type','Risk Factors:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        @php $sepsis_in_mother_type1 = $sepsis_in_mother_type2 = $sepsis_in_mother_type3 = $sepsis_in_mother_type4 = $sepsis_in_mother_type5 = $sepsis_in_mother_type6 = false; @endphp  
                                        <div>
                                            {!! Form::checkbox('sepsis_in_mother_type[]','1',$sepsis_in_mother_type1) !!}
                                            {!! Form::label('chorioamnionitis','Chorioamnionitis',['class'=>'title']) !!}
                                        </div>
                                        <div>
                                            {!! Form::checkbox('sepsis_in_mother_type[]','2',$sepsis_in_mother_type2) !!}
                                            {!! Form::label('unclean_vaginal_examination','Unclean vaginal examination / > 3 PV examination',['class'=>'title']) !!}
                                        </div>
                                        <div>
                                            {!! Form::checkbox('sepsis_in_mother_type[]','3',$sepsis_in_mother_type3) !!}
                                            {!! Form::label('leaking_pv','Leaking PV > 18hours / pPROM',['class'=>'title']) !!}
                                        </div>
                                        <div>
                                            {!! Form::checkbox('sepsis_in_mother_type[]','4',$sepsis_in_mother_type4) !!}
                                            {!! Form::label('gbs_in_maternal_recto-vaginal_swab','GBS in maternal recto-vaginal swab',['class'=>'title']) !!}
                                        </div>
                                        <div>
                                            {!! Form::checkbox('sepsis_in_mother_type[]','5',$sepsis_in_mother_type5) !!}
                                            {!! Form::label('uti_in_mother','UTI in mother',['class'=>'title']) !!}
                                        </div>
                                        <div>
                                            {!! Form::checkbox('sepsis_in_mother_type[]','6',$sepsis_in_mother_type6) !!}
                                            {!! Form::label('maternal_fever','Maternal fever',['class'=>'title']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('MaternalPyrexia','Maternal Pyrexia:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">   
                                        <input id="MaternalPyrexia" data-size="small" data-width="100" name="MaternalPyrexia" data-on="Yes" data-off="No" checked data-toggle="toggle"  class="form-control" type="checkbox">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('maternal_pyrexia_temp','Maternal Pyrexia Temperature:') !!}
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
                                                {!! Form::text('maternal_pyrexia_fahrenheit',null,['class'=>'form-control fahrenheit','id'=>'maternal_pyrexia_fahrenheit']) !!}
                                            </div>
                                            <div class="col-xs-6">
                                                {!! Form::text('maternal_pyrexia_celsius',null,['class'=>'form-control celsius','id'=>'maternal_pyrexia_celsius']) !!}
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
                                                {!! Form::text('maternal_pyrexia_celsius',null,['class'=>'form-control celsius','id'=>'maternal_pyrexia_celsius']) !!}
                                            </div>
                                            <div class="col-xs-6">
                                                {!! Form::text('maternal_pyrexia_fahrenheit',null,['class'=>'form-control fahrenheit','id'=>'maternal_pyrexia_fahrenheit']) !!}
                                            </div>
                                        </div>
                                        @endif
                                        <label class="error help-block" for="BirthWeight" generated="true" style="display: none;"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('PROM','PROM:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">  
                                        <input id="PROM" data-size="small" data-width="100" name="PROM" data-on="Yes" data-off="No" checked data-toggle="toggle"  class="form-control" type="checkbox">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('DurationOfROM','Duration Of PROM:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">  
                                        {!! Form::select('DurationOfROM',['' => 'N/A','Less than 6 hrs' => 'Less than 6 hrs','6 - 12' => '6 - 12','12 - 18' => '12- 18','18 - 24' => '18 - 24','More than 24 ' => 'More than 24 ','Unknown' => 'Unknown'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                @php $maternal_status=['Not known'=>'Not known','No'=>'No','Yes'=>'Yes'] @endphp
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        {!! Form::label('Maternal_antibiotics_status','Maternal Antibiotics:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">  
                                        {!! Form::select('Maternal_antibiotics_status',$maternal_status,null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row Maternal_antibiotics_status">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('MaternalAntibiotics','Maternal Antibiotics Type:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <table class="MaternalAntibiotics table table-add-more full-width-fix">
                                            <thead>
                                                <tr class="master-add-header">
                                                    <th class="full-width">
                                                        <i class="fa fa-reorder"></i>Add More
                                                    </th>
                                                    <th>
                                                        <span>
                                                            <a class="btn_add btn btn-success btn-view MaternalAntibiotics_add " href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                                                        </span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (isset($maternalantibiotics) && count($maternalantibiotics) > 0)
                                                @for ($i = 0; $i < count($maternalantibiotics); $i++)
                                                <tr>
                                                    @if (!empty($maternalantibiotics[$i]))
                                                    <td class="form-group full-width">{!! Form::text('MaternalAntibiotics[]',$maternalantibiotics[$i],['class'=>'form-control ']) !!}</td>
                                                    @else
                                                    <td class="form-group full-width">{!!  Form::text('MaternalAntibiotics[]',null,['class'=>'form-control ']) !!}</td>
                                                    @endif 
                                                    <td>
                                                        <span class="fa fa-trash btn btn-danger btn-view remove"></span> 
                                                    </td>
                                                </tr>
                                                @endfor
                                                @else
                                                <tr>
                                                    <td class="full-width">{!! Form::text('MaternalAntibiotics[]',null,['class'=>'form-control ']) !!}</td>                                            
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
                                        {!! Form::label('TimeofLastDose','Time of Last Dose:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('TimeofLastDose',['' => 'N/A','Less than 4 hours' => 'Less than 4 hours','More than 4 hours' => 'More than 4 hours','Unknown' => 'Unknown'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Apgar Form -->
                <div role="tabpanel" class="tab-pane @if($_COOKIE['neonatal_proforma'] == 'apgarform') active @endif" id="apgarform">
                    <div class="col-md-12 overflow-auto">
                        <div class="widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group">
                                    {!! Form::label('known_field','APGAR:', ['class' => 'control-label']) !!}
                                    <input id="known_field" data-size="small" data-width="100" name="known_field" data-on="Known" data-off="Unknown"  data-toggle="toggle"  class="form-control" type="checkbox">
                                    <br><br>
                                </div>
                                <div class="form-group dispaly_apgar display-none">
                                    <table>
                                        <tr>
                                            <td></td>
                                            <td><strong>1 minute</strong></td>
                                            <td><strong>5 minutes</strong></td>
                                            <td><strong>10 minutes</strong></td>
                                            <td><strong>15 minutes</strong></td>
                                            <td><strong>20 minutes</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Colour</td>
                                            <td> {!! Form::select('Colour1',ValuelistHelpers::getApgarScore('colour'),null,['class'=>'form-control','id'=>'Colour1','type'=>'numeric','onchange'=>"Calculate(1);"]) !!}</td>
                                            <td> {!! Form::select('Colour5',ValuelistHelpers::getApgarScore('colour'),null,['class'=>'form-control','id'=>'Colour5','onchange'=>"Calculate(5);"]) !!}</td>
                                            <td> {!! Form::select('Colour10',ValuelistHelpers::getApgarScore('colour'),null,['class'=>'form-control','id'=>'Colour10','onchange'=>"Calculate(10);"]) !!}</td>
                                            <td> {!! Form::select('Colour15',ValuelistHelpers::getApgarScore('colour'),null,['class'=>'form-control','id'=>'Colour15','onchange'=>"Calculate(15);"]) !!}</td>
                                            <td> {!! Form::select('Colour20',ValuelistHelpers::getApgarScore('colour'),null,['class'=>'form-control','id'=>'Colour20','onchange'=>"Calculate(20);"]) !!}</td>
                                        </tr>
                                        <tr>
                                            <td>HR</td>
                                            <td> {!! Form::select('HR1',ValuelistHelpers::getApgarScore('hr'),null,['class'=>'form-control','id'=>'HR1','onchange'=>"Calculate(1);"]) !!}</td>
                                            <td> {!! Form::select('HR5',ValuelistHelpers::getApgarScore('hr'),null,['class'=>'form-control','id'=>'HR5','onchange'=>"Calculate(5);"]) !!}</td>
                                            <td> {!! Form::select('HR10',ValuelistHelpers::getApgarScore('hr'),null,['class'=>'form-control','id'=>'HR10','onchange'=>"Calculate(10);"]) !!}</td>
                                            <td> {!! Form::select('HR15',ValuelistHelpers::getApgarScore('hr'),null,['class'=>'form-control','id'=>'HR15','onchange'=>"Calculate(15);"]) !!}</td>
                                            <td> {!! Form::select('HR20',ValuelistHelpers::getApgarScore('hr'),null,['class'=>'form-control','id'=>'HR20','onchange'=>"Calculate(20);"]) !!}</td>
                                        </tr>
                                        <tr>
                                            <td>Reflex</td>
                                            <td> {!! Form::select('Reflex1',ValuelistHelpers::getApgarScore('reflex'),null,['class'=>'form-control','id'=>'Reflex1','onchange'=>"Calculate(1);"]) !!}</td>
                                            <td> {!! Form::select('Reflex5',ValuelistHelpers::getApgarScore('reflex'),null,['class'=>'form-control','id'=>'Reflex5','onchange'=>"Calculate(5);"]) !!}</td>
                                            <td> {!! Form::select('Reflex10',ValuelistHelpers::getApgarScore('reflex'),null,['class'=>'form-control','id'=>'Reflex10','onchange'=>"Calculate(10);"]) !!}</td>
                                            <td> {!! Form::select('Reflex15',ValuelistHelpers::getApgarScore('reflex'),null,['class'=>'form-control','id'=>'Reflex15','onchange'=>"Calculate(15);"]) !!}</td>
                                            <td> {!! Form::select('Reflex20',ValuelistHelpers::getApgarScore('reflex'),null,['class'=>'form-control','id'=>'Reflex20','onchange'=>"Calculate(20);"]) !!}</td>
                                        </tr>
                                        <tr>
                                            <td>Tone</td>
                                            <td> {!! Form::select('Tone1',ValuelistHelpers::getApgarScore('tone'),null,['class'=>'form-control','id'=>'Tone1','onchange'=>"Calculate(1);"]) !!}</td>
                                            <td> {!! Form::select('Tone5',ValuelistHelpers::getApgarScore('tone'),null,['class'=>'form-control','id'=>'Tone5','onchange'=>"Calculate(5);"]) !!}</td>
                                            <td> {!! Form::select('Tone10',ValuelistHelpers::getApgarScore('tone'),null,['class'=>'form-control','id'=>'Tone10','onchange'=>"Calculate(10);"]) !!}</td>
                                            <td> {!! Form::select('Tone15',ValuelistHelpers::getApgarScore('tone'),null,['class'=>'form-control','id'=>'Tone15','onchange'=>"Calculate(15);"]) !!}</td>
                                            <td> {!! Form::select('Tone20',ValuelistHelpers::getApgarScore('tone'),null,['class'=>'form-control','id'=>'Tone20','onchange'=>"Calculate(20);"]) !!}</td>
                                        </tr>
                                        <tr>
                                            <td>Respiration</td>
                                            <td> {!! Form::select('Respiration1',ValuelistHelpers::getApgarScore('respiration'),null,['class'=>'form-control','id'=>'Respiration1','onchange'=>"Calculate(1);"]) !!}</td>
                                            <td> {!! Form::select('Respiration5',ValuelistHelpers::getApgarScore('respiration'),null,['class'=>'form-control','id'=>'Respiration5','onchange'=>"Calculate(5);"]) !!}</td>
                                            <td> {!! Form::select('Respiration10',ValuelistHelpers::getApgarScore('respiration'),null,['class'=>'form-control','id'=>'Respiration10','onchange'=>"Calculate(10);"]) !!}</td>
                                            <td> {!! Form::select('Respiration15',ValuelistHelpers::getApgarScore('respiration'),null,['class'=>'form-control','id'=>'Respiration15','onchange'=>"Calculate(15);"]) !!}</td>
                                            <td> {!! Form::select('Respiration20',ValuelistHelpers::getApgarScore('respiration'),null,['class'=>'form-control','id'=>'Respiration20','onchange'=>"Calculate(20);"]) !!}</td>
                                        </tr>
                                        <tr></tr>
                                        <tr>
                                            <td>Total</td>
                                            <td> {!! Form::text('Apgars1min',null,['class'=>'form-control Apgars1min total1min']) !!}</td>
                                            <td> {!! Form::text('Apgars5min',null,['class'=>'form-control Apgars5min total5min']) !!}</td>
                                            <td> {!! Form::text('Apgars10min',null,['class'=>'form-control Apgars10min total10min']) !!}</td>
                                            <td> {!! Form::text('Apgars15min',null,['class'=>'form-control Apgars15min total15min']) !!}</td>
                                            <td> {!! Form::text('Apgars20min',null,['class'=>'form-control Apgars20min total20min']) !!}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td><label for="Apgars1min" generated="true" class="error help-block"></label></td>
                                            <td><label for="Apgars5min" generated="true" class="error help-block"></label></td>
                                            <td><label for="Apgars10min" generated="true" class="error help-block"></label></td>
                                            <td><label for="Apgars15min" generated="true" class="error help-block"></label></td>
                                            <td><label for="Apgars20min" generated="true" class="error help-block"></label></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td align="left"><span class="btn btn-xs 1min_reset" onclick="ResetData('1min_reset')">Reset</span></td>
                                            <td align="left"><span class="btn btn-xs  5min_reset" onclick="ResetData('5min_reset')">Reset</span></td>
                                            <td align="left"><span class="btn btn-xs 10min_reset" onclick="ResetData('10min_reset')">Reset</span></td>
                                            <td align="left"><span class="btn btn-xs 15min_reset" onclick="ResetData('15min_reset')">Reset</span></td>
                                            <td align="left"><span class="btn btn-xs  20min_reset" onclick="ResetData('20min_reset')">Reset</span></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Delivery Form -->
                <div role="tabpanel" class="tab-pane @if($_COOKIE['neonatal_proforma'] == 'delform') active @endif" id="delform">
                    <div class="col-md-6 col-sm-6">
                        <div class="widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('ModeOfDelivery','Mode Of Delivery:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('ModeOfDelivery',[""=>"N/A","Normal Vaginal"=>"Normal Vaginal","Preterm Vaginal"=>"Preterm Vaginal","Forceps"=>"Forceps","Ventouse"=>"Ventouse","Assisted Breech"=>"Assisted Breech","Emergency Caesarian"=>"Emergency Caesarian","Elective Caesarian"=>"Elective Caesarian","Caesarian"=>"Caesarian"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="hidden">
                                    {!! Form::select('temp_indication',$delivery_indications,null) !!}
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Indication','Indication:') !!}
                                        <a href="javascript:void(0)" class="add_master_data" data-modal_header="Indications" data-destination_elements="temp_indication,Indication[]" data-option_value="Id" data-option_text="indication_name" data-mas_table="mas_indication">
                                            <i class="fa fa-info-circle bs-tooltip add-neo-consultant" data-placement="right" data-original-title="Add Indication"></i>
                                        </a>
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <table class="indication-add table table-add-more add-border-bottom">                                            
                                            <thead>
                                                <tr class="master-add-header">
                                                    <th class="full-width">
                                                        <i class="fa fa-reorder"></i>Add More
                                                    </th>
                                                    <th>
                                                        <span>
                                                            <a class="btn_add btn btn-success btn-view Indication_add_more" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                                                        </span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="full-width">{!! Form::select('Indication[]',['N/A'=>'N/A']+$delivery_indications,null,['class'=>'delivery-indications-search full-width', 'id'=>'delivery-indications-search-0']) !!}</td>                                            
                                                    <td>
                                                        <span class="fa fa-trash btn btn-danger btn-view remove"></span> 
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Presentation','Presentation:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Presentation',["Not Known"=>"Not Known","Cephalic"=>"Cephalic","Breech"=>"Breech","Twins"=>"Twins","Transverse Lie"=>"Transverse Lie","Other"=>"Other"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('FoetalDistress','Fetal Distress:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('FoetalDistress',['Not Known'=>'Not Known','No'=>'No','Yes'=>'Yes'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        {!! Form::label('CTG','CTG:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('CTG',["Normal"=>"Normal","Abnormal"=>"Abnormal","Not Known"=>"Not Known"],null,['class'=>'form-control','id' => 'CTG','data-color'=>ValuelistHelpers::setColorvalue('reactive',4)]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('CTGDetails','CTG Details:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('CTGDetails',null,['class'=>'form-control','id' => 'CTGDetails']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('CordBloodGas','Cord Blood Gas:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('CordBloodGas',["Not done"=>"Not done","Not indicated"=>"Not indicated","Arterial"=>"Arterial","Venous"=>"Venous","Capillary"=>"Capillary"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('CordpH','Cord pH:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('CordpH',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('CordHCO3','Cord HCO3:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('CordHCO3',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('CordBE','Cord BE:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('CordBE',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        {!! Form::label('TypeofAnesthesia','Type of Anesthesia:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('TypeofAnesthesia',["Local"=>"Local","Spinal"=>"Spinal","Epidural"=>"Epidural","General"=>"General","None"=>"None"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('GastricAspirate','Gastric Aspirate:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('GastricAspirate',ValuelistHelpers::GastricAspirate(),null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        {!! Form::label('delayed_cord_clamping','Delayed Cord Clamping:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('delayed_cord_clamping',ValuelistHelpers::get_comman_options(),null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('Delayedcord',4)]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('reason_dcc','Reason for No DCC:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('reason_dcc',null,['class'=>'form-control'])!!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('duration_dcc','Duration of DCC (seconds):') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('duration_dcc',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        {!! Form::label('umbilicalcordmilking','Umbilical Cord Milking:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('umbilicalcordmilking',['N/A'=>'N/A','Yes'=>'Yes','No'=>'No'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        {!! Form::label('cutcordmilking','Cut Cord Milking:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('cutcordmilking',['N/A'=>'N/A','Yes'=>'Yes','No'=>'No'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Resuscitation Form -->
                <div role="tabpanel" class="tab-pane @if($_COOKIE['neonatal_proforma'] == 'resform') active @endif" id="resform">
                    <div class="col-md-6 col-sm-6">
                        <div class="widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('FacialOxygen','Facial Oxygen:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">  
                                        <input id="FacialOxygen" data-size="small" data-width="100" name="FacialOxygen" data-on="Yes" data-off="No" checked data-toggle="toggle"  class="form-control" type="checkbox">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('DurationOfOxygen','Duration of Oxygen (min):') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">  
                                        {!! Form::text('DurationOfOxygen',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('maximum_fio2_required','Maximum FiO2 required (%):') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">  
                                        {!! Form::text('maximum_fio2_required',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Resuscitation','Resuscitation:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">  
                                        <input id="Resuscitation" data-size="small" data-width="100" name="Resuscitation" data-on="Yes" data-off="No" checked data-toggle="toggle"  class="form-control" type="checkbox">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        {!! Form::label('initial_steps', 'Initial Steps:')!!}
                                    </div>
                                    <div class="col-md-9 custom-input">  
                                        {!! Form::select('initial_steps',['N/A'=>'N/A','Yes'=>'Yes','No'=>'No'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('timeofgasp_status','Time of 1st Gasp:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">  
                                        <input id="timeofgasp_status" data-size="small" data-width="100" name="timeofgasp_status" data-on="Known" data-off="Unknown"  data-toggle="toggle"  class="form-control" type="checkbox">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('TimeOf1stGasp','Time of 1st Gasp (min):') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">  
                                        {!! Form::text('TimeOf1stGasp',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('regularrespiration_status','Regular Respiration:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">  
                                        <input id="regularrespiration_status" data-size="small" data-width="100" name="regularrespiration_status" data-on="Known" data-off="Unknown"  data-toggle="toggle"  class="form-control" type="checkbox">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('RegularRespiration','Regular Respiration (min):') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">  
                                        {!! Form::text('RegularRespiration',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('bag_mask_ventilator','Delivery Room CPAP:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">  
                                        <input id="delivery_room_cpap" data-size="small" data-width="100" name="delivery_room_cpap" data-on="Yes" data-off="No"  data-toggle="toggle"  class="form-control" type="checkbox">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('bag_mask_ventilator','Bag Mask Ventilation:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">  
                                        <input id="bag_mask_ventilator" data-size="small" data-width="100" name="bag_mask_ventilator" data-on="Yes" data-off="No"  data-toggle="toggle"  class="form-control" type="checkbox">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {{ Form::label('bag_mask_ventilator_duration', 'Bag Mask Ventilation Duration:') }}
                                    </div>
                                    <div class="col-md-9 custom-input">  
                                        <input id="bag_mask_ventilator_duration" data-size="small" data-width="100" name="bag_mask_ventilator_duration" data-on="known" data-off="Unknown"  data-toggle="toggle"  class="form-control" type="checkbox">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('bag_mask_ventilator_min','Bag Mask Ventilator Min:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">  
                                        {!! Form::text('bag_mask_ventilator_min',null,['class'=>'form-control', 'onkeypress' => 'return ISNumber(event);']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Intubation','Intubation:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">  
                                        <input id="Intubation" data-size="small" data-width="100" name="Intubation" data-on="Yes" data-off="No" checked data-toggle="toggle"  class="form-control" type="checkbox">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        {!! Form::label('ETTSize','ETT Size (mm):') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">  
                                        {!! Form::select('ETTSize',['0'=>'None','2.0'=>'2.0','2.5'=>'2.5','3.0'=>'3.0','3.5'=>'3.5','4.0'=>'4.0'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('insertion_status','Depth Of Insertion:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">  
                                        <input id="insertion_status" data-size="small" data-width="100" name="insertion_status" data-on="known" data-off="Unknown" checked data-toggle="toggle"  class="form-control" type="checkbox">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('DepthOfInsertion','Depth Of Insertion (cm):') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">  
                                        {!! Form::text('DepthOfInsertion',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('PPV','PPV (BTV):') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">  
                                        <input id="PPV" data-size="small" data-width="100" name="PPV" data-on="Yes" data-off="No" checked data-toggle="toggle"  class="form-control" type="checkbox">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('ppv_status','Duration of PPV:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">  
                                        <input id="ppv_status" data-size="small" data-width="100" name="ppv_status" data-on="known" data-off="Unknown" checked data-toggle="toggle"  class="form-control" type="checkbox">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('DurationOfPPV','Duration of PPV (min):') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">  
                                        {!! Form::text('DurationOfPPV',null,['class'=>'form-control', 'onkeypress' => 'return ISNumber(event);']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('CPR','CPR:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">  
                                        <input id="CPR" data-size="small" data-width="100" name="CPR" data-on="Yes" data-off="No" checked data-toggle="toggle"  class="form-control" type="checkbox">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('cpr_status','Duration of CPR:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">  
                                        <input id="cpr_status" data-size="small" data-width="100" name="cpr_status" data-on="known" data-off="Unknown" checked data-toggle="toggle"  class="form-control" type="checkbox">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('duration_of_cpr','Duration of CPR (min):') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">  
                                        {!! Form::text('duration_of_cpr',null,['class'=>'form-control', 'onkeypress' => 'return ISNumber(event);']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Drugs','Drugs:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">  
                                        <input id="Drugs" data-size="small" data-width="100" name="Drugs" data-on="Yes" data-off="No" checked data-toggle="toggle"  class="form-control" type="checkbox">
                                    </div>
                                </div>
                                <div class="hidden">
                                    {!! Form::select('temp_resusciatation_drugs',[''=>'N/A']+ValuelistHelpers::resuscitationMedication(),null) !!}
                                </div>
                                <div class="col-md-10 plr-0">
                                    <div class="form-group row drug-main">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('Drug','Drugs:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">  
                                            <table class="drugs table table-add-more full-width-fix">
                                                <thead>
                                                    <tr class="master-add-header">
                                                        <th class="full-width">
                                                            <i class="fa fa-reorder"></i>Add More
                                                        </th>
                                                        <th><a class="btn_add btn btn-success btn-view resustation_drug_add" href="javascript:void(0);"><i class="fa fa-plus"></i></a></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (isset($results->resusciatation_drugs) && count($results->resusciatation_drugs) > 0)
                                                    @foreach ($results->resusciatation_drugs as $key => $data)
                                                    <tr>
                                                        <td  class="form-group">
                                                            {!! Form::select('resusciatation_drugs[]',[''=>'N/A']+ValuelistHelpers::resuscitationMedication(),null,["class"=>"form-control input-width-xlarge"]) !!}
                                                        </td>
                                                        <td><span class="fa fa-trash btn btn-danger btn-view remove-drug"></span></td>
                                                    </tr>
                                                    @endforeach
                                                    @else
                                                    <tr>
                                                        <td  class="form-group">
                                                            {!! Form::select('resusciatation_drugs[]',[''=>'N/A']+ValuelistHelpers::resuscitationMedication(),null,["class"=>"form-control input-width-xlarge"]) !!}
                                                        </td>
                                                        <td><span class="fa fa-trash btn btn-danger btn-view remove-drug"></span></td>
                                                    </tr>
                                                    @endif
                                                </tbody>
                                            </table> 
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        {!! Form::label('OtherInformation','Resuscitation Details:') !!}
                                    </div>
                                    <div class="col-md-12">
                                        {!! Form::textarea('OtherInformation',null,['class'=>'form-control','rows'=>'5']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Essential Form -->
                <div role="tabpanel" class="tab-pane @if($_COOKIE['neonatal_proforma'] == 'essform') active @endif" id="essform">
                    <div class="col-md-6 col-sm-6">
                        <div class="widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="">
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control md-mt-50">
                                            {!! Form::label('VitaminK','VitaminK:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::select('VitaminK',['Not known'=>'Not known','No'=>'No','Yes'=>'Yes'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('vitamin_k',4)]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control md-mt-50">
                                            {!! Form::label('DoseVitK','Dose VitK:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::select('DoseVitK',[''=>'N/A','1 mg'=>'1 mg','0.5 mg'=>'0.5 mg'],null,['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control md-mt-50">
                                            {!! Form::label('RouteVitK','Route VitK:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            {!! Form::select('RouteVitK',[''=>'N/A','IM'=>'IM','IV'=>'IV','Oral'=>'Oral'],null,['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-30">
                                        {!! Form::label('InitialExamination','Summary of Initial Examination Following Birth:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::textarea('InitialExamination',null,['class'=>'form-control','rows'=>'5']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Malformation','Malformation:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Malformation',['No'=>'No','Yes'=>'Yes'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-30">
                                        {!! Form::label('MalformationType','Malformation Type:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::textarea('MalformationType',null,['class'=>'form-control','rows'=>'5']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        {!! Form::label('ict','ICT:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('ict',ValuelistHelpers::Ict(),null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('ict',4)]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        {!! Form::label('DCT','DCT:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('DCT',ValuelistHelpers::Dct(),null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('dct',4)]) !!}
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        {!! Form::label('Background','Background:') !!}
                                    </div>
                                    <div class="col-md-12">
                                        {!! Form::textarea('Background',null,['class'=>'form-control','rows'=>'5']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        {!! Form::label('PLAN','PLAN:') !!}
                                    </div>
                                    <div class="col-md-12">
                                        {!! Form::textarea('PLAN',null,['class'=>'form-control','rows'=>'5']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Discharge Form -->
                <div role="tabpanel" class="tab-pane @if($_COOKIE['neonatal_proforma'] == 'dischargeform') active @endif" id="dischargeform">
                    <div class="col-md-6">
                        <div class="widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Status','Status:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Status',[""=>"N/A","NICU Transfer" => "NICU Transfer","Discharged" => "Discharged","Discharge at Request" => "Discharge at Request"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('DateOfDischarge','Date Of Discharge:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('DateOfDischarge',null,['class'=>'form-control datepicker']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                        {!! Form::label('DischargeWeight','Discharge Weight') !!}
                                    </div>
                                    <div class="col-md-6 custom-input clear-xs">
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <small>(In Grams)</small>
                                            </div>
                                            <div class="col-xs-6">
                                                <small>(In Kilo Grams)</small>
                                            </div>
                                            <div class="col-xs-6">
                                                {!! Form::input('text','DischargeWeight',null,['class'=>'form-control']) !!}
                                            </div>
                                            <div class="col-xs-6">
                                                {!! Form::input('text','discharge_weight',null,['class'=>'form-control','readonly'=>'true', 'id' => 'discharge_weight_in_kg']) !!}
                                            </div>
                                        </div>
                                        <label for="DischargeWeight" generated="true" class="error help-block"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('discharge_length','Discharge Length(cm):') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('discharge_length',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('discharge_ofc','Discharge OFC(cm):') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('discharge_ofc',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Vaccine_status','Vaccine Status:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Vaccine_status',['Not given'=>'Not given','Given'=>'Given'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group Vaccine_status row mx-0">
                                    <table class="vaccine">
                                        <thead>
                                            {!! Form::select('temp_Vaccine',[''=>'N/A']+ValuelistHelpers::Vaccine('',true),null,['class'=>'form-control hide']) !!}
                                            <tr>
                                                <th>Vaccine</th>
                                                <th>Date <i class="fa fa-info-circle bs-tooltip" data-placement="right" data-original-title="Date Format DD-MM-YYYY"></i></th>
                                                <th>
                                                    <a class="btn_add btn btn-success btn-view vaccine_add" href="javascript:void(0);"><i class="fa fa-plus"></i> </a>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td  class="form-group"> {!! Form::select('Vaccine[]',[''=>'N/A']+ValuelistHelpers::Vaccine('',true),null,['class'=>'form-control ']) !!}</td>
                                                <td  class="form-group" colspan="2"> {!! Form::text('VaccineDate[]',null,['class'=>'form-control datepicker']) !!}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('NewBornScreen','Newborn Screen:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('NewBornScreen',['Sent' => 'Sent','Not Sent'=>'Not Sent','Normal'=>'Normal','Abnormal'=>'Abnormal'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('NewBornExamination','Newborn Examination:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('NewBornExamination',['Normal'=>'Normal','See Below'=>'See Below'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('PostductalSaturation','Postductal Saturation (SPO2 %):') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('PostductalSaturation',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        {!! Form::label('wb_echo_status','ECHO:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('wb_echo_status',[''=>'N/A','No'=>'No','Yes'=>'Yes'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default')]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        {!! Form::label('wb_echo_report','ECHO Report:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('wb_echo_report',[''=>'N/A','Normal'=>'Normal','Referred'=>'Referred'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default')]) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('HearingScreen','Hearing Screen:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('HearingScreen',['Normal'=>'Normal','Suspect'=>'Suspect','Abnormal'=>'Abnormal', 'Not Performed'=>'Not Performed', 'Not Indicated'=> 'Not Indicated'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('AdditionalInformation','Additional Information:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::textarea('AdditionalInformation',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Outpatient Appointment','Appointment Date & Time:') !!}
                                    <table>
                                        <tr>
                                            <td>  {!! Form::text('OpAppointment',null,['class'=>'form-control datepicker ','']) !!}</td>
                                            <td> {!! Form::select('Outpatient_TIME',$tob['time'],null,['class'=>'form-control ' ]) !!}</td>
                                            <td class="form-group-spacing"> {!! Form::select('Outpatient_MINS',$tob['mins'],null,['class'=>'form-control  ']) !!}</td>
                                            <td> {!! Form::select('Outpatient_AM',['AM' => 'AM','PM' => 'PM'],null,['class'=>'form-control ']) !!}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Summary Form -->
                <div role="tabpanel" class="tab-pane @if($_COOKIE['neonatal_proforma'] == 'summaryform') active @endif" id="summaryform">
                    <div class="widget box">
                        <div class="widget-header">
                            <h4><i class="fa fa-reorder"></i> </h4>
                        </div>
                        <div class="widget-content">
                            <div class="form-group">
                                {!! Form::label('ConfidentialBackgroundDetails','Confidential Background Details:') !!}
                                {!! Form::textarea('ConfidentialBackgroundDetails',null,['class'=>'form-control']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('Notes','Notes:') !!}
                                {!! Form::textarea('Notes',null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                    </div> 
                </div>
                @if(\Session::get('admission_module') != 'NICU_ADMISSION')
                <!-- New Born Examination -->
                <div role="tabpanel" class="tab-pane @if($_COOKIE['neonatal_proforma'] == 'newbornform') active @endif" id="newbornform">
                    <div class="tabbable tabbable-custom">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation"  class="@if($_COOKIE['neonatal_proforma_sub'] == 'vitals') active @endif">
                                <a class="tab-sub-menu" href="#vitals" aria-controls="vitals" role="tab" data-toggle="tab">VITALS</a>
                            </li>
                            <li role="presentation" class="@if($_COOKIE['neonatal_proforma_sub'] == 'gpe') active @endif">
                                <a class="tab-sub-menu" href="#gpe" aria-controls="gpe" role="tab" data-toggle="tab">GPE</a>
                            </li>
                            <li role="presentation" class="@if($_COOKIE['neonatal_proforma_sub'] == 'cvs') active @endif">
                                <a class="tab-sub-menu" href="#cvs" aria-controls="cvs" role="tab" data-toggle="tab">CVS</a>
                            </li>
                            <li role="presentation" class="@if($_COOKIE['neonatal_proforma_sub'] == 'rs') active @endif">
                                <a class="tab-sub-menu" href="#rs" aria-controls="rs" role="tab" data-toggle="tab">RS</a>
                            </li>
                            <li role="presentation" class="@if($_COOKIE['neonatal_proforma_sub'] == 'abdomen') active @endif">
                                <a class="tab-sub-menu" href="#abdomen" aria-controls="abdomen" role="tab" data-toggle="tab">ABDOMEN</a>
                            </li>
                            <li role="presentation" class="@if($_COOKIE['neonatal_proforma_sub'] == 'cns') active @endif">
                                <a class="tab-sub-menu" href="#cns" aria-controls="cns" role="tab" data-toggle="tab">CNS</a>
                            </li>
                            <!--  <li role="presentation"><a href="#additional_details" aria-controls="cns" role="tab" data-toggle="tab">Additional Details</a></li> -->
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane @if($_COOKIE['neonatal_proforma_sub'] == 'vitals') active @endif" id="vitals">
                                <div class=" col-md-6 col-sm-6">
                                    <div class="widget box">
                                        <div class="widget-header">
                                            <h4><i class="fa fa-reorder"></i> </h4>
                                        </div>
                                        <div class="widget-content">
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control">
                                                    {!! Form::label('NbHR','HR in bpm:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::text('NbHR',null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control">
                                                    {!! Form::label('NbRR','RR:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::text('NbRR',null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-8 text-right label-control">
                                                    {!! Form::label('newbornStatus','Is the rest of the newborn examination normal ?') !!}
                                                </div>
                                                <div class="col-md-3 custom-input">
                                                    <input  data-toggle="toggle" data-size="small" data-width="100" class="form-control" id="newbornStatus" height="5px" name="newbornStatus" data-on="Yes" data-off="No" type="checkbox">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control">
                                                    {!! Form::label('CentralPulses','Central Pulses:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('CentralPulses',[''=>'N/A','Normal'=>'Normal','Bounding'=>'Bounding','Feeble/Weak'=>'Feeble/Weak','Absent'=>'Absent'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control md-mt-50">
                                                    {!! Form::label('NbCFT','CFT:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('NbCFT',[''=>'N/A','< 3 Seconds' => "< 3 Seconds",'3-5 Seconds' => "3-5 Seconds",'>5 Seconds' => ">5 Seconds","Prolonged"=>"Prolonged"],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="widget box">
                                        <div class="widget-header">
                                            <h4><i class="fa fa-reorder"></i> </h4>
                                        </div>
                                        <div class="widget-content">
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                                    {!! Form::label('TemperatureF','Temperature (F/C):') !!}
                                                </div>
                                                <!-- <div class="col-md-9 custom-input">
                                                    {!! Form::text('TemperatureF',null,['class'=>'form-control']) !!}
                                                </div> -->
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
                                                            {!! Form::text('','',['class'=>'form-control fahrenheit']) !!}
                                                        </div>
                                                        <div class="col-xs-6">
                                                            {!! Form::text('TemperatureF',null,['class'=>'form-control celsius']) !!}
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
                                                            {!! Form::text('TemperatureF',null,['class'=>'form-control celsius']) !!}
                                                        </div>
                                                        <div class="col-xs-6">
                                                            {!! Form::text('','',['class'=>'form-control fahrenheit']) !!}
                                                        </div>
                                                    </div>
                                                    @endif
                                                    <label class="error help-block" for="BirthWeight" generated="true" style="display: none;"></label>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control">
                                                    {!! Form::label('NbSpO2','SpO2:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::text('NbSpO2',null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control">
                                                    {!! Form::label('PeripheralPulses','Peripheral Pulses:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('PeripheralPulses',[''=>'N/A','Normal'=>'Normal','Bounding'=>'Bounding','Feeble/Weak'=>'Feeble/Weak','Absent'=>'Absent'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control md-mt-50">
                                                    {!! Form::label('Colour','Colour:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('Colour',['Yellow'=>'Yellow','Pink'=>'Pink','Acral Cyanosis'=>'Acral Cyanosis','Central Cyanosis'=>'Central Cyanosis'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane @if($_COOKIE['neonatal_proforma_sub'] == 'gpe') active @endif" id="gpe">
                                <div class=" col-md-6 col-sm-6">
                                    <div class="widget box">
                                        <div class="widget-header">
                                            <h4><i class="fa fa-reorder"></i> </h4>
                                        </div>
                                        <div class="widget-content">
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control md-mt-50">
                                                    {!! Form::label('Pallor','Pallor:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('Pallor',[''=>'N/A','Present'=>'Present','Absent'=>'Absent'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="hidden">
                                                {!! Form::select('tempscalp',[''=>'N/A','Normal'=>'Normal',"Caput Succedaneum"=>"Caput Succedaneum","Cephalhematoma"=>"Cephalhematoma","Bruises"=>"Bruises","Laceration"=>"Laceration"],null,['class'=>'form-control input-width-large']) !!}
                                            </div>
                                            <div class="form-group">
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        {!! Form::label('Scalp','Scalp:') !!}
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        <table class="scalp-content table table-add-more full-width-fix">                                                            
                                                            <thead>
                                                                <tr class="master-add-header">
                                                                    <th class="full-width">
                                                                        <i class="fa fa-reorder"></i>Add More
                                                                    </th>
                                                                    <th>
                                                                        <span>
                                                                            <a class="btn btn-success btn-view add-scalp btn_add" href="javascript:void(0);"> <i class="fa fa-plus"></i></a>
                                                                        </span>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td class="full-width">{!! Form::select('Scalp[]',[''=>'N/A','Normal'=>'Normal',"Caput Succedaneum"=>"Caput Succedaneum","Cephalhematoma"=>"Cephalhematoma","Bruises"=>"Bruises","Laceration"=>"Laceration"],null,['class'=>'form-control']) !!}</td>
                                                                    <td>
                                                                        <span class="fa fa-trash btn btn-danger btn-view remove-scalp"></span>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table> 
                                                    </div>
                                                </div>
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
                                                    {!! Form::label('Ears','Ears:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('Ears',[''=>'N/A','Normal'=>'Normal','Low Set'=>'Low Set','Preauricular tag Rt'=>'Preauricular tag Rt','Preauricular tag Lt'=>'Preauricular tag Lt','Preauricular tag Bilateral'=>'Preauricular tag Bilateral'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control md-mt-50">
                                                    {!! Form::label('Nose','Nose:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('Nose',[''=>'N/A','Normal'=>'Normal','Depressed nasal bridge'=>'Depressed nasal bridge'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control">
                                                    {!! Form::label('Nostrils','Nostrils:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('Nostrils',[''=>'N/A','Patent'=>'Patent','Choanal Atresia Rt'=>'Choanal Atresia Rt','Choanal Atresia Rt'=>'Choanal Atresia Rt','Choanal Atresia Lt'=>'Choanal Atresia Lt','Choanal Atresia Bilateral'=>'Choanal Atresia Bilateral'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control md-mt-50">
                                                    {!! Form::label('Lips','Lips:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('Lips',[''=>'N/A','Normal'=>'Normal','Cleft Lip'=>'Cleft Lip'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control md-mt-50">
                                                    {!! Form::label('Palate','Palate:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('Palate',[''=>'N/A','Normal'=>'Normal','Cleft Palate'=>'Cleft Palate'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control md-mt-50">
                                                    {!! Form::label('Neck','Neck:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('Neck',[''=>'N/A','Normal'=>'Normal','Cystic Hygroma'=>'Cystic Hygroma','Sternomastoid tumor'=>'Sternomastoid tumor'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control md-mt-50">
                                                    {!! Form::label('Nipples','Nipples:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('Nipples',[''=>'N/A','Normal'=>'Normal','Supernumerary'=>'Supernumerary'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control md-mt-50">
                                                    {!! Form::label('Esophagus','Esophagus:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('Esophagus',[''=>'N/A','Patent'=>'Patent','TEF/Atresia'=>'TEF/Atresia'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control">
                                                    {!! Form::label('Umbilicus','Umbilicus:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('Umbilicus',[''=>'N/A','Normal'=>'Normal','Omphalocele'=>'Omphalocele','Gastroschisis'=>'Gastroschisis','Hernia'=>'Hernia','Meconium Stained' => 'Meconium Stained','Large' => 'Large','Shrivelled' => 'Shrivelled'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control md-mt-50">
                                                    {!! Form::label('UmbilicalCord','UmbilicalCord:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('UmbilicalCord',[''=>'N/A','Normal'=>'Normal','Single Umbilical Artery'=>'Single Umbilical Artery'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control md-mt-50">
                                                    {!! Form::label('AnteriorFontanelle','Anterior Fontanelle:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('AnteriorFontanelle',[''=>'N/A','Normal'=>'Normal','Depressed'=>'Depressed','Bulging'=>'Bulging'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="widget box">
                                        <div class="widget-header">
                                            <h4><i class="fa fa-reorder"></i> </h4>
                                        </div>
                                        <div class="widget-content">
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control md-mt-50">
                                                    {!! Form::label('Jaundice','Jaundice:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('Jaundice',[''=>'N/A','Present'=>'Present','Absent'=>'Absent'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control">
                                                    {!! Form::label('HernialOrifices','Hernial Orifices:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('HernialOrifices',[''=>'N/A','No hernia'=>'No hernia','Right Inguinal hernia'=>'Right Inguinal hernia','Left Inguinal hernia'=>'Left Inguinal hernia','Umbilical/para umbilical hernia'=>'Umbilical/para umbilical hernia','Obstructed/strangulated'=>'Obstructed/strangulated'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control">
                                                    {!! Form::label('FemoralPulses','Femoral Pulses:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('FemoralPulses',[''=>'N/A','Normal'=>'Normal','Bounding'=>'Bounding','Feeble/Weak'=>'Feeble/Weak','Absent'=>'Absent'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control">
                                                    {!! Form::label('Genitalia','Genitalia:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('Genitalia',[''=>'N/A','Normal'=>'Normal','Clitoromegaly'=>'Clitoromegaly','Hypospadias'=>'Hypospadias','Cryptorchidism'=>'Cryptorchidism','Chordee'=>'Chordee','Ambiguous'=>'Ambiguous'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control md-mt-50">
                                                    {!! Form::label('Hips','Hips:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('Hips',[''=>'N/A','Normal'=>'Normal','DDH Rt'=>'DDH Rt','DDH Lt'=>'DDH Lt','DDH Bilateral'=>'DDH Bilateral'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control md-mt-50">
                                                    {!! Form::label('Anus','Anus:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('Anus',[''=>'N/A','Patent'=>'Patent','Imperforate'=>'Imperforate'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control md-mt-50">
                                                    {!! Form::label('Spine','Spine:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('Spine',[''=>'N/A','Normal'=>'Normal','Kyphoscoliosis'=>'Kyphoscoliosis','Sacral dimple'=>'Sacral dimple'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control">
                                                    {!! Form::label('RtUL','Rt UL:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('RtUL',[''=>'N/A','Normal'=>'Normal','Polydactyly'=>'Polydactyly','Syndactyly'=>'Syndactyly','Clinodactyly'=>'Clinodactyly','Single Crease'=>'Single Crease'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control">
                                                    {!! Form::label('RtLL','Rt LL:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('RtLL',[''=>'N/A','Normal'=>'Normal','Polydactyly'=>'Polydactyly','Syndactyly'=>'Syndactyly','Positional tallipes'=>'Positional tallipes','Fixed tallipes'=>'Fixed tallipes'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control">
                                                    {!! Form::label('LtUL','Lt UL:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('LtUL',[''=>'N/A','Normal'=>'Normal','Polydactyly'=>'Polydactyly','Syndactyly'=>'Syndactyly','Clinodactyly'=>'Clinodactyly','Single Crease'=>'Single Crease'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control">
                                                    {!! Form::label('LtLL','Lt LL:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('LtLL',[''=>'N/A','Normal'=>'Normal','Polydactyly'=>'Polydactyly','Syndactyly'=>'Syndactyly','Positional tallipes'=>'Positional tallipes','Fixed tallipes'=>'Fixed tallipes'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control">
                                                    {!! Form::label('Skin','Skin:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('Skin',[''=>'N/A','Normal'=>'Normal','Blueberry muffin spots'=>'Blueberry muffin spots','Mongolian spots'=>'Mongolian spots','Erythema toxicum'=>'Erythema toxicum','Milia'=>'Milia','Miliaria'=>'Miliaria'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control md-mt-50">
                                                    {!! Form::label('Hairs','Hairs:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('Hairs',[''=>'N/A','Normal'=>'Normal','Alopecia'=>'Alopecia'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control mt-0">
                                                    {!! Form::label('AnyOtherAbnormality','Any Other Abnormality:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::text('AnyOtherAbnormality',null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane @if($_COOKIE['neonatal_proforma_sub'] == 'cvs') active @endif" id="cvs">
                                <div class=" col-md-6 col-sm-6">
                                    <div class="widget box">
                                        <div class="widget-header">
                                            <h4><i class="fa fa-reorder"></i> </h4>
                                        </div>
                                        <div class="widget-content">
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control md-mt-30">
                                                    {!! Form::label('PrecordialActivity','Precordial Activity:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('PrecordialActivity',[''=>'N/A','Present'=>'Present','Absent'=>'Absent'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control md-mt-30">
                                                    {!! Form::label('ApicalImpulse','Apical Impulse:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('ApicalImpulse',[''=>'N/A','Normal'=>'Normal','Right Side'=>'Right Side'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control">
                                                    {!! Form::label('BoundingPulses','Bounding Pulses:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('BoundingPulses',[''=>'N/A','Normal'=>'Normal','Bounding'=>'Bounding','Feeble/Weak'=>'Feeble/Weak','Absent'=>'Absent'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control mt-0">
                                                    {!! Form::label('other_cvs_findings','Other CVS findings:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::text('other_cvs_findings',null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="widget box">
                                        <div class="widget-header">
                                            <h4><i class="fa fa-reorder"></i> </h4>
                                        </div>
                                        <div class="widget-content">
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control md-mt-30">
                                                    {!! Form::label('S1S2','S1S2:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('S1S2',[''=>'N/A','Normal'=>'Normal','Abnormal'=>'Abnormal'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control md-mt-30">
                                                    {!! Form::label('Murmur','Murmur:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('Murmur',[''=>'N/A','Present'=>'Present','Absent'=>'Absent'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control mt-0">
                                                    {!! Form::label('CharacterofMurmur','Character of Murmur:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::text('CharacterofMurmur',null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control">
                                                    {!! Form::label('SiteofMurmur','Site of Murmur:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('SiteofMurmur',['N/A'=>'Not applicable','Apical Area'=>'Apical Area','Aortic Area'=>'Aortic Area','Aortic Area'=>'Aortic Area','Pulmonary Area'=>'Pulmonary Area','Tricuspid Area'=>'Tricuspid Area','Rt Parasternal Area'=>'Rt Parasternal Area','Lt Parasternal Area'=>'Lt Parasternal Area'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane @if($_COOKIE['neonatal_proforma_sub'] == 'rs') active @endif" id="rs">
                                <div class=" col-md-6 col-sm-6">
                                    <div class="widget box">
                                        <div class="widget-header">
                                            <h4><i class="fa fa-reorder"></i> </h4>
                                        </div>
                                        <div class="widget-content">
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control md-mt-50">
                                                    {!! Form::label('NbChestMovement','Chest Movement:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('NbChestMovement',[''=>'N/A','Symmetrical'=>'Symmetrical','Asymmetrical'=>'Asymmetrical'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-3 text-right label-control md-mt-50">
                                                    {!! Form::label('BreathSounds','Breath Sounds:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('BreathSounds',[''=>'N/A','Normal Vesicular'=>'Normal Vesicular','Abnormal'=>'Abnormal'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control md-mt-50">
                                                    {!! Form::label('AirEntry','Air Entry:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('AirEntry',[''=>'N/A','Equal'=>'Equal','Reduced Bilateral'=>'Reduced Bilateral','Reduced Rt'=>'Reduced Rt','Reduced Lt'=>'Reduced Lt'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control">
                                                    {!! Form::label('other_rs_findings','Other RS findings:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::text('other_rs_findings',null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="widget box">
                                        <div class="widget-header">
                                            <h4><i class="fa fa-reorder"></i> </h4>
                                        </div>
                                        <div class="widget-content">
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control md-mt-50">
                                                    {!! Form::label('AddedSounds','Added Sounds:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('AddedSounds',[''=>'N/A','Present'=>'Present','Absent'=>'Absent'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control m-0">
                                                    {!! Form::label('CharacterOfAddedSounds','Character Of Added Sounds:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::text('CharacterOfAddedSounds',null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control m-0">
                                                    {!! Form::label('SiteofAddedSounds','Site of Added Sounds:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::text('SiteofAddedSounds',null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane @if($_COOKIE['neonatal_proforma_sub'] == 'abdomen') active @endif" id="abdomen">
                                <div class=" col-md-6 col-sm-6">
                                    <div class="widget box">
                                        <div class="widget-header">
                                            <h4><i class="fa fa-reorder"></i> </h4>
                                        </div>
                                        <div class="widget-content">
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control md-mt-50">
                                                    {!! Form::label('AbdomenShape','Abdomen Shape:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('AbdomenShape',[''=>'N/A','Normal'=>'Normal','Scaphoid'=>'Scaphoid','Distended'=>'Distended'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control md-mt-50">
                                                    {!! Form::label('Hepatomegaly','Hepatomegaly:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('Hepatomegaly',[''=>'N/A','Present'=>'Present','Absent'=>'Absent'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control">
                                                    {!! Form::label('LiverSpan','Liver Span:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::text('LiverSpan',null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="widget box">
                                        <div class="widget-header">
                                            <h4><i class="fa fa-reorder"></i> </h4>
                                        </div>
                                        <div class="widget-content">
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control md-mt-50">
                                                    {!! Form::label('Splenomegaly','Splenomegaly:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('Splenomegaly',[''=>'N/A','Present'=>'Present','Absent'=>'Absent'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control">
                                                    {!! Form::label('SpleenSpan','Spleen Span:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::text('SpleenSpan',null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control md-mt-50">
                                                    {!! Form::label('Flanks','Flanks:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('Flanks',[''=>'N/A','Normal'=>'Normal','Full'=>'Full'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control">
                                                    {!! Form::label('other_pa_findings','Other PA findings:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::text('other_pa_findings',null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane @if($_COOKIE['neonatal_proforma_sub'] == 'cns') active @endif" id="cns">
                                <div class=" col-md-6 col-sm-6">
                                    <div class="widget box">
                                        <div class="widget-header">
                                            <h4><i class="fa fa-reorder"></i> </h4>
                                        </div>
                                        <div class="widget-content">
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control">
                                                    {!! Form::label('LevelOfConsciousness','Level Of Consciousness:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('LevelOfConsciousness',[''=>'N/A','Normal'=>'Normal','Drowsy'=>'Drowsy','Comatosed'=>'Comatosed','Hyperalert'=>'Hyperalert','Irritable'=>'Irritable'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control md-mt-50">
                                                    {!! Form::label('Seizures','Seizures:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('Seizures',[''=>'N/A','Yes'=>'Yes','No'=>'No'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row" id="TypeofSeizureDiv" style="display: none">
                                                <div class="col-md-3 text-right label-control md-mt-50">
                                                    {!! Form::label('TypeofSeizure','Type of Seizure:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('TypeofSeizure',[''=>'N/A','Subtle'=>'Subtle','Tonic'=>'Tonic','Clonic'=>'Clonic','Myoclonus'=>'Myoclonus'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control md-mt-30">
                                                    {!! Form::label('GeneralBodyMovements','General Body Movements:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('GeneralBodyMovements',[''=>'N/A','Symmetrical'=>'Symmetrical','Asymmetrical'=>'Asymmetrical'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control mt-0">
                                                    {!! Form::label('other_cns_findings','Other CNS findings:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::text('other_cns_findings',null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="widget box">
                                        <div class="widget-header">
                                            <h4><i class="fa fa-reorder"></i> </h4>
                                        </div>
                                        <div class="widget-content">
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control md-mt-50">
                                                    {!! Form::label('SpontaneousActivity','Spontaneous Activity:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('SpontaneousActivity',[''=>'N/A','Normal'=>'Normal','Decreased'=>'Decreased','Increased'=>'Increased'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control md-mt-50">
                                                    {!! Form::label('Cry','Cry:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('Cry',[''=>'N/A','Normal consolable'=>'Normal consolable','Abnormal Inconsolable'=>'Abnormal Inconsolable'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control md-mt-50">
                                                    {!! Form::label('NbTone','Tone:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('NbTone',[''=>'N/A','Normal'=>'Normal','Hypotonia'=>'Hypotonia','Hypertonia'=>'Hypertonia'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control md-mt-50">
                                                    {!! Form::label('NeonatalReflexes','Neonatal Reflexes:') !!}
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    {!! Form::select('NeonatalReflexes',[''=>'N/A','Normal'=>'Normal','Suppressed'=>'Suppressed','Absent'=>'Absent','Exaggerated'=>'Exaggerated'],null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if(isset($current_nicu_id) && $current_nicu_id != 0)
                <input type="hidden" name="nicu_id" value="{{ $current_nicu_id }}" />
                @endif
                @if(isset($flow_wise_register) && !empty($flow_wise_register) && $flow_wise_register == 'from-dashboard')  
                <input type="hidden" name="flow_wise_register" value="{{ $flow_wise_register }}" />
                @endif
                <div class="col-md-12 col-sm-12 col-xs-12 mt-10">
                    <input type="hidden" name="print_flag" value="0" id="print_flag" />
                    @if(!isset($flow_wise_register) || empty($flow_wise_register) || $flow_wise_register != 'from-dashboard')  
                    @if(!Session::has('registration_start'))
                    <div class="col-md-3 col-sm-4 col-xs-12">
                        <button data-flag="0" class="btn btn-primary save-button-shadow  btn-block form-control neonatal_save_btn_create">
                            <i class="fa fa-floppy-o"></i> 
                            <span>{!! $SubmitButtonText !!}</span>
                        </button>
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-12">
                        <button data-flag="1" name="savedhere" class="btn save-button-shadow   btn-info btn-block  form-control neonatal_save_btn_create">
                            <i class="fa fa-floppy-o"></i> 
                            <span>{!! $SavedhereText !!}</span>
                        </button>
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-12">
                        <a href="{{ url('/neonatal') }}" class="btn btn-default btn-block save-button-shadow form-control" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> <span>Cancel</span></a>
                    </div>
                    @else 
                    @if(\Session::get('admission_module') == 'NICU_ADMISSION')
                    <div class="col-md-3 col-xs-12 col-sm-4 @if(isset($_COOKIE['neonatal_proforma']) && $_COOKIE['neonatal_proforma'] == 'essform') hide @endif">
                        <button  type="button" name="savedhere" class="btn save-button-shadow saveNext  btn-info btn-block  form-control" onclick="$('#print_flag').val('1'); $('#neonatalPerforma-form').submit();">
                            <i class="fa fa-floppy-o"></i> 
                            <span>{!! $saveNext !!}</span>
                        </button>
                    </div>
                    @else
                    <div class="col-md-3 col-xs-12 col-sm-4 @if(isset($_COOKIE['neonatal_proforma']) && $_COOKIE['neonatal_proforma'] == 'newbornform') hide @endif">
                        <button  type="button" name="savedhere" class="btn save-button-shadow saveNext  btn-info btn-block  form-control" onclick="$('#print_flag').val('1'); $('#neonatalPerforma-form').submit();">
                            <i class="fa fa-floppy-o"></i> 
                            <span>{!! $saveNext !!}</span>
                        </button>
                    </div>
                    @endif
                    @if(\Session::get('admission_module') == 'NICU_ADMISSION')
                    <div class="col-md-3 @if(isset($_COOKIE['neonatal_proforma']) && $_COOKIE['neonatal_proforma'] != 'essform') hide @endif">
                        <button  @if(Session::get('admission_module') == 'NICU_ADMISSION') data-flag="4" @elseif(Session::get('admission_module') == 'POSTNATAL_ADMISSION') data-flag="5" @endif class="btn save-button-shadow  btn-block btn-info nicu-admission form-control neonatal_save_btn_create">
                            <i class="fa fa-floppy-o"></i>
                            <span> @if(Session::get('admission_module') == 'NICU_ADMISSION') Nicu Admission @elseif(Session::get('admission_module') == 'POSTNATAL_ADMISSION') Postnatal Admission @endif</span>
                        </button>
                    </div>
                    @else
                    <div class="col-md-3 @if(isset($_COOKIE['neonatal_proforma']) && $_COOKIE['neonatal_proforma'] != 'newbornform') hide @endif">
                        <button  @if(Session::get('admission_module') == 'NICU_ADMISSION') data-flag="4" @elseif(Session::get('admission_module') == 'POSTNATAL_ADMISSION') data-flag="5" @endif class="btn save-button-shadow  btn-block btn-info nicu-admission form-control neonatal_save_btn_create">
                            <i class="fa fa-floppy-o"></i>
                            <span> @if(Session::get('admission_module') == 'NICU_ADMISSION') Nicu Admission @elseif(Session::get('admission_module') == 'POSTNATAL_ADMISSION') Postnatal Admission @endif</span>
                        </button>
                    </div>
                    @endif  
                    @if(\Session::get('admission_module') == 'NICU_ADMISSION')
                    <div class="col-md-3 @if(isset($_COOKIE['neonatal_proforma']) && $_COOKIE['neonatal_proforma'] != 'essform') hide @endif">
                        <button data-flag="2" type="submit" class="btn save-button-shadow  print-tag btn-info btn-block form-control neonatal_save_btn_create">
                            <i class="fa fa-tag" aria-hidden="true"></i>
                            <span>Print Tag</span>
                        </button>
                    </div>
                    @else
                    <div class="col-md-3 @if(isset($_COOKIE['neonatal_proforma']) && $_COOKIE['neonatal_proforma'] != 'newbornform') hide @endif">
                        <button data-flag="2" type="submit" class="btn save-button-shadow  print-tag btn-info btn-block form-control neonatal_save_btn_create">
                            <i class="fa fa-tag" aria-hidden="true"></i>
                            <span>Print Tag</span>
                        </button>
                    </div>
                    @endif
                    <div class="@if(isset($_COOKIE['neonatal_proforma']) && $_COOKIE['neonatal_proforma'] == 'newbornform') col-md-3 @else col-md-3 col-xs-12 col-sm-4 @endif">
                        <a href="{{ $actionUrl }}" class="btn save-button-shadow cancel-block btn-block form-control" onclick="$('form')[0].reset();">
                            <i class="fa fa-exclamation-circle"></i> 
                            <span>Cancel</span>
                        </a>
                    </div>
                    @endif
                    @else
                        <div class="col-md-3 col-sm-4 col-xs-12">
                            <button data-flag="1" class="btn save-button-shadow btn-primary btn-block form-control neonatal_save_btn_create">
                                <i class="fa fa-floppy-o"></i> 
                                <span>Update</span>
                            </button>
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12">
                            <button data-flag="2" class="btn save-button-shadow flow-dashboard-next btn-info btn-block form-control neonatal_save_btn_create">
                                <i class="fa fa-floppy-o"></i> 
                                <span>Next</span>
                            </button>
                        </div>
                        <div class="col-md-3 hide">
                            <button data-flag="3" class="btn save-button-shadow flow-dashboard-nicu-admission btn-block btn-primary form-control neonatal_save_btn_create">
                                <i class="fa fa-floppy-o"></i>
                                <span>NICU Admission</span>
                            </button>
                        </div>
                        <div class="@if(isset($_COOKIE['neonatal_proforma']) && $_COOKIE['neonatal_proforma'] == 'newbornform') col-md-3 @else col-md-3 col-xs-12 col-sm-4 @endif">
                            <a href="{{ $actionUrl }}" class="btn save-button-shadow cancel-block btn-block form-control" onclick="$('form')[0].reset();">
                                <i class="fa fa-exclamation-circle"></i> 
                                <span>Cancel</span>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">

    @if(isset($flow_wise_register) && !empty($flow_wise_register) && $flow_wise_register == 'from-dashboard')
        var current_active_tab = $('#neonate-next li[class="active"]').children('a').attr('aria-controls');

        @if($baby_detail->BirthStatus == 'Inborn')
        if(current_active_tab == 'newbornform')
        @else
        if(current_active_tab == 'essform')
        @endif
        {
            $('.flow-dashboard-nicu-admission').parent().removeClass('hide');
            $('.flow-dashboard-next').parent().addClass('hide');
        }
        $('#neonate-next li').click(function()
        {
            var current_active_tab = $(this).children('a').attr('aria-controls');
            @if($baby_detail->BirthStatus == 'Inborn')
            if(current_active_tab == 'newbornform')
            @else
            if(current_active_tab == 'essform')
            @endif
            {
                $('.flow-dashboard-nicu-admission').parent().removeClass('hide');
                $('.flow-dashboard-next').parent().addClass('hide');
            }
            else
            {
                $('.flow-dashboard-nicu-admission').parent().addClass('hide');
                $('.flow-dashboard-next').parent().removeClass('hide');
            }
        });
    @endif

    /* PLUGIN USED FOR FORM LOCAL STORAGE */
    $( "form" ).sisyphus({  customKeySuffix: "neonatal", locationBased: true });
    $('.sameasmailaddress').click(function () {
        if ($('.sameasmailaddress').is(':checked')) {
            $('#FatherAddress1').val($('#Address1').val());
            $('#FatherAddress2').val($('#Address2').val());
            $('#City').val($('#Address3').val());
            $('#Postcode').val($('#Address4').val());
            $('#Country').val($('#Address5').val())
        } 
        else {
            //Clear on uncheck
            $('#FatherAddress1').val("");
            $('#City').val("");
            $('#FatherAddress2').val("");
            $('#Country').val("");
            $('#Postcode').val("");
        }

    });
    
    $('.known_field').click(function () {
        $('.dispaly_apgar').css('display','block');
    });
    
    $('.unknown_field').click(function () {
        $('.dispaly_apgar').css('display','none');
    });
    
    $('input[name="G_Value"]').change(function() {

      if ($(this).val() == 1) {
        $('input[name="P_Value"], input[name="L_Value"], input[name="A_Value"]').val(0);   
        $('.delivery').children('tbody').empty();
    }

}); 
    
    $('.tab-main-menu').click(function() {
        if ($("#neonatalPerforma-form").valid() === false) {
            $("#neonatalPerforma-form").valid();
            return false;
        }
        // submitForm();
        setNextmenu($(this).attr('aria-controls'));
        @if(\Session::get('admission_module') != 'NICU_ADMISSION')
        setPrintflag($(this).attr('aria-controls'));
        @else
        setPostnatalPrintflag($(this).attr('aria-controls'))
        @endif

    });
    
    $('.tab-sub-menu').on('click',function() {
        // submitForm();
        setNextSubMenu($(this).attr('aria-controls'));
    });
    
    function setPrintflag(currentMenu) {

        if (currentMenu == 'newbornform') {
            $('.saveNext').parent().addClass('hide');
            $('.nicu-admission').parent().removeClass('hide');
            $('.print-tag').parent().removeClass('hide');
            $('.cancel-block').parent().addClass("col-md-3").removeClass("col-md-6");

        } else {

            $('.saveNext').parent().removeClass('hide');
            $('.nicu-admission').parent().addClass('hide');
            $('.print-tag').parent().addClass('hide');
            // $('.cancel-block').parent().addClass("col-md-6").removeClass("col-md-3");
        }

    }

    function setPostnatalPrintflag(currentMenu) {

        if (currentMenu == 'essform') {
           $('.saveNext').parent().addClass('hide');
           $('.nicu-admission').parent().removeClass('hide');
           $('.print-tag').parent().removeClass('hide');
           $('.cancel-block').parent().addClass("col-md-3").removeClass("col-md-6");

       } 
       else {

          $('.saveNext').parent().removeClass('hide');
          $('.nicu-admission').parent().addClass('hide');
          $('.print-tag').parent().addClass('hide');
                // $('.cancel-block').parent().addClass("col-md-6").removeClass("col-md-3");
            }

        }

        function setNextmenu(currentMenu) {
          $.cookie('neonatal_proforma', currentMenu ,{path:'/'});
      }

      function setNextSubMenu(currentMenu) {
          $.cookie('neonatal_proforma_sub',currentMenu, {path:'/'});
      }



      @if(Session::has('registration_start'))

      $('.saveNext').click(function() {

        if ($('#neonatalPerforma-form').valid() === true) {
            $('#print_flag').val('1'); 
            $(this).prop('disabled', 'true');
            var nextMenu = $('#neonate-next li[class="active"]').next('li').children('a').attr('aria-controls');
            setNextmenu(nextMenu);
            if(nextMenu =='newbornform') {
                setNextSubMenu('vitals');
            }
            $(this).children('i').attr('class', '<i class="fas fa-spinner fa-pulse"></i>');
            $('#neonatalPerforma-form').submit();
        }

    });

      @endif
// $(document).on('click', '.neonatal_save_btn_create', function(e)
// {
//     e.preventDefault();
//     if ($('#neonatalPerforma-form').valid() === true) {
//       var print_flag = $(this).data('flag');
//       $('#print_flag').val(print_flag);
//       $('.neonatal_save_btn_create').prop('disabled', true);

//       $(this).html('<i class="fas fa-spinner fa-pulse"></i> Loading...');
//       $('#neonatalPerforma-form').submit();
//     }
// });


    // @if(!isset($bed_logs['bed_id']))
    //     // var first_room_id = '{{ collect(@$room_list) }}';

    // var first_room_id = $('#room_id').find("option:first-child").val();
    // if (first_room_id != '') {
    //     var getUrl = window.location;
    //     var baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
    //     $.ajax({
    //         type: "GET",
    //         url: baseUrl + '/baby-bed-details' + '/' + first_room_id + '/BEDLIST',
    //         success: function(response) {
    //             var wardOption = '';
    //             var results = response.results;
    //             if (results.length != 0) {
    //                 $.each(response.results, function(index, value) {
    //                     wardOption += '<option value="' + value.id + '">' + value.name + '</option>';
    //                 });
    //             }
    //             else
    //             {
    //                 // wardOption += '<option>N/A</option>';
    //                 if ($('#transfer_status').val() == 'NICU') {
    //                     $('#bed_id').attr('required', true);
    //                 }
    //             }
    //             // var bed_input = '<input type="hidden" name="bed_no" value="' + bed_id + '" />';
    //             $('#bed_id').html(wardOption);
    //             // $(bed_input).insertAfter('.bed-name');
    //         },
    //         complete: function(response) {}
    //     });
    // }
    // @endif

    $(document).ready(function()
    {
        // var transfer_status = $('select[name=transfer_status]').val();
        // if (transfer_status != 'NICU') {
        //     $('#room_id').removeAttr('required');
        //     $('#room_id').parent().parent().hide();
        //     $('#bed_id').removeAttr('required');
        //     $('#bed_id').parent().parent().hide();
        // }
        // $('select[name=transfer_status]').change(function()
        // {
        //     var transfer_status = $(this).val();
        //     if (transfer_status == 'NICU') {
        //         // getRoomsByWard(transfer_status);
        //         $('#room_id').attr('required', true);
        //         $('#room_id').parent().parent().show();
        //         $('#bed_id').attr('required', true);
        //         $('#bed_id').parent().parent().show();
        //     }
        //     else
        //     {
        //         $('#room_id').removeAttr('required');
        //         $('#room_id').parent().parent().hide();
        //         $('#bed_id').removeAttr('required');
        //         $('#bed_id').parent().parent().hide();
        //     }   

        // });

        // $('#room_id').change(function()
        // {
        //     var room_id = $(this).val();
        //     if (room_id != null && room_id != '') {
        //         getBedsByRoom(room_id);
        //     }
        // });
    });

    // $(document).on('change', '#baby_reg_form input, #baby_reg_form select', function()
    // {
    //     $(this).addClass('not_saved');
    // });

    $(document).on('click', '.neonatal_save_btn_create', function(e){
        if ($('#neonatalPerforma-form').valid() === true) {
            e.preventDefault();
            var print_flag = $(this).data('flag');
            $('#print_flag').val(print_flag);
            $('.neonatal_save_btn_create').prop('disabled', true);
            var current_clicked_html = $(this).html();
            var current_clicked_element = $(this);

            $(this).html('<i class="fas fa-spinner fa-pulse"></i> Loading...');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: $('#neonatalPerforma-form input, #neonatalPerforma-form select, #neonatalPerforma-form textarea').serialize(),
                url: "{{ action('Registration\NeonatalController@store') }}",
                success: function (response) {
                    if (print_flag == 1) {
                        Showalert('success', 'Neonatal proforma saved successfully');
                        window.location.href = response.edit_url;
                    }
                    else if (print_flag == 2) {
                        Showalert('success', 'Neonatal proforma saved successfully');
                        window.location.href = response.edit_next_url;
                    }
                    else if(print_flag == 3)
                    {
                        Showalert('success', 'Neonatal proforma saved successfully');
                        window.location.href = response.create_nicu_url;
                    }
                    else if(print_flag == 4)
                    {
                        Showalert('success', 'Neonatal proforma saved successfully');
                        window.location.href = response.create_postnatal_url;
                    }
                    else if(print_flag == 5)
                    {
                        Showalert('success', 'Neonatal proforma saved successfully');
                        window.location.href = response.tag_print_url;
                    }
                    else
                    {
                        Showalert('success', 'Neonatal proforma saved successfully');
                        window.location.href = response.list_url; 
                    }
                },
                error: function()
                {
                    Showalert('error', 'Something went wrong, Please try again later...!');
                    $('.neonatal_save_btn_create').prop('disabled', false);
                    current_clicked_element.html(current_clicked_html);

                    
                }
            });
        }
    }); 
    // function submitForm()
    // {
    //     $.ajax({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         type: 'POST',
    //         data: $('#neonatalPerforma-form input, #neonatalPerforma-form select, #neonatalPerforma-form textarea').serialize(),
    //         url: "{{ action('Registration\NeonatalController@store') }}",
    //         success: function (response) {

    //         },
    //         error: function()
    //         {

    //         }
    //     });
    // }
</script>
@include('registration.neonatal.neonatal_scripts')
@endsection
