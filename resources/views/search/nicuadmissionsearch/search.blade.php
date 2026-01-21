@extends('app')
@section('content')
@php
$admission_menu = ['basicform', 'historyform', 'pregform', 'babyform', 'admissform', 'Proform', 'Cribform', 'Snapform', 'Diagform'];
$discharge_menu = ['dischargeform', 'Checkform'];
if(Session::has('nicuform')) {
$_COOKIE['nicuform'] = Session::get('nicuform');
Session::forget('nicuform');
}
if(!Session::has('slug-nav') && isset($_COOKIE['nicuform']) && in_array($_COOKIE['nicuform'], $discharge_menu)) {
$active = 'basicform';
} elseif(Session::has('slug-nav')&&  isset($_COOKIE['nicuform']) && in_array($_COOKIE['nicuform'], $admission_menu)) {  
$active = 'dischargeform';
} elseif(!Session::has('slug-nav')) {
$active = 'basicform';
} elseif (isset($_COOKIE['nicuform'])) {
$active = $_COOKIE['nicuform'];
}  else {
$active = 'dischargeform';
} 
@endphp
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="{{ url('/') }}">Dashboard</a>
        </li>
        <li class="">
            <a title="" href="{{ action('Admission\NicuController@index') }}">NICU Admission</a>
        </li>
        <li class="current">
            <a title="">Search</a>
        </li>
    </ul>
    <div class="pull-right">
        @if(isset($nicu_last) && is_array($nicu_last))
        <table class="table">
            <tr>
                <td> @if(isset($nicu_last['first']) &&  !empty($nicu_last['first']))<a class="forward-boot-class" href="{{ $nicu_last['first'] }}"><i class="fa fa-fast-backward fa-2x" title="Previous Page" aria-hidden="true"></i></a>@endif </td>
                <td> @if(isset($nicu_last[0]) &&  !empty($nicu_last[0]))<a class="forward-boot-class"  href="{{ $nicu_last[0] }}"><i class="fa fa-backward fa-2x" title="Previous Page"  aria-hidden="true"></i></a>@endif</td>
                <td> @if(isset($nicu_last[1]) &&  !empty($nicu_last[1]))<a class="forward-boot-class" href="{{ $nicu_last[1] }}"><i class="fa fa-forward fa-2x" title="Next Page" aria-hidden="true"></i></a>@endif </td>
                <td> @if(isset($nicu_last['last']) &&  !empty($nicu_last['last']))<a class="forward-boot-class"  href="{{ $nicu_last['last'] }}"><i class="fa fa-fast-forward fa-2x" title="Next Page"  aria-hidden="true"></i></a>@endif</td>
            </tr>
        </table>
        @endif    
    </div>
    <div class="pull-right reset-search">
        <table>
            <tr>
                <!--   @if(Session::has('nicu_record'))
                    <td class="p-10">Record : {{ Session::get('nicu_record') }}</td>
                    @endif -->
                    <!-- @if(isset($nicuList) && count($nicuList) > 0) -->
                    <!-- @endif -->
                    @if(Session::has('nicu_count'))
                    <td class="p-10">No.Record : {{ Session::get('nicu_count') }}</td>
                    <td> <a class="btn btn-info btn-basic-shadow reset-btn" href="{{ action('Search\SearchNicuadmissionController@create') }}"> Reset </a></td>
                    <td><a class="btn btn-info btn-basic-shadow export margin-btn" href="{{ action('Search\SearchNicuadmissionController@NicuListdownload') }}"> Export </a></td>
                    @endif
                </tr>
            </table>
        </div>
    </div>
</div>
<!-- /Breadcrumbs line -->
@if(Session::has('_old_input'))
@php 
ValuelistHelpers::setOldinputs('nicu-admission'); 
@endphp
@endif
<div class="row mt-10 col-md-9 col-sm-9 col-xs-9 pr-0">
    <div class="col-md-12 pr-0">
        {!! Form::model($results,['method'=>'GET','url' => action('Search\SearchNicuadmissionController@index', 0),'id' => 'admissionProforma-form']) !!}
        @include('errors.list')
        @if(\Session::get('set_nicu_menu'))
        @php  $active = 'basicform';
        \Session::forget('set_nicu_menu'); @endphp
        @endif
        <!-- Nav tabs -->
        <div role="tabpanel" class="tabbable tabbable-custom">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" @if($active == 'basicform')  class="active" @endif>
                    <a href="#basicform" aria-controls="basicform" role="tab" data-toggle="tab">Basics</a>
                </li>
                <li role="presentation" @if($active == 'historyform')  class="active" @endif>
                    <a href="#historyform" aria-controls="historyform" role="tab" data-toggle="tab">Medical History</a>
                </li>
                <li role="presentation" @if($active == 'pregform')  class="active"  @endif>
                    <a href="#pregform" aria-controls="pregform" role="tab" data-toggle="tab">Pregnancy</a>
                </li>
                <li role="presentation" @if($active == 'babyform') class="active" @endif>
                    <a href="#babyform" aria-controls="babyform" role="tab" data-toggle="tab">Baby Details</a>
                </li>
                <li role="presentation" @if($active == 'admissform') class="active" @endif>
                    <a href="#admissform" aria-controls="admissform" role="tab" data-toggle="tab">Admission Details</a>
                </li>
                <li role="presentation" @if($active == 'Proform')  class="active"  @endif>
                    <a href="#Proform" aria-controls="Proform" role="tab" data-toggle="tab">Procedures</a>
                </li>
                <li role="presentation" @if($active == 'Cribform')  class="active"  @endif>
                    <a href="#Cribform" aria-controls="Cribform" role="tab" data-toggle="tab">CRIB II</a>
                </li>
                <li role="presentation" @if($active == 'Snapform')  class="active" @endif>
                    <a href="#Snapform" aria-controls="Snapform" role="tab" data-toggle="tab">SNAPPE II</a>
                </li>
                <li role="presentation" @if($active == 'Diagform')  class="active"  @endif>
                    <a href="#Diagform" aria-controls="Diagform" role="tab" data-toggle="tab">Diagnosis</a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content tab-view-shadow">
                <!-- Basics Form -->
                <div role="tabpanel" class="tab-pane top-specing @if($active == 'basicform') active @endif" id="basicform">
                    <div class="col-md-6 col-sm-6">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content row mx-0">
                                <div class="form-group">
                                    {!! Form::label('BabyName','Baby Name:') !!}
                                    {!! Form::text('BabyName',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('BMrNo', Lang::get('home.mrn').':') !!}
                                    {!! Form::text('BMrNo',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('DOB','DOB: (DD-MM-YYYY)') !!}
                                    {!! Form::text('DOB',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('BirthWeight','Birth Weight (In grams):') !!}
                                    {!! Form::text('BirthWeight',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('BirthStatus','Birth Status:') !!}
                                    {!! Form::select('BirthStatus',[''=>'N/A','Inborn'=>'Inborn','Outborn'=>'Outborn'],null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Gestation','Gestation:') !!}
                                    <table>
                                        <tr>
                                            <td>{!! Form::label('g_weeks','Weeks:') !!}</td>
                                            <td></td>
                                            <td>{!! Form::label('g_days','Days:') !!}</td>
                                        </tr>
                                        <tr>
                                            <td>{!! Form::text('g_weeks',null,['class'=>'form-control input-width-medium','max'=>'46']) !!}</td>
                                            <td>+</td>
                                            <td>{!! Form::text('g_days',null,['class'=>'form-control  input-width-medium','max'=>'6']) !!}</td>
                                        </tr>
                                    </table>
                                    <label class="error help-block" for="g_weeks" generated="true"></label> 
                                    <label class="error help-block" for="g_days" generated="true"></label> 
                                </div>
                                <div class="form-group">
                                    {!! Form::label('BabyBloodGroup','Baby\'s Blood Group:') !!}
                                    {!! Form::select('BabyBloodGroup',[''=>'N/A']+ValuelistHelpers::Blood_groups(),null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Sex','Sex:') !!}
                                    {!! Form::select('Sex',[''=>'N/A','Male'=>'Male','Female'=>'Female','Indeterminate'=>'Indeterminate'],null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('ReferredBy','Referred From:') !!}
                                    {!! Form::text('ReferredBy',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('ReferralReason','Referral Reason:') !!}
                                    {!! Form::text('ReferralReason',null,['class'=>'form-control text-convertion-lower']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('CorrectedGestation','Corrected Gestational Age:') !!}
                                    <table>
                                        <tr>
                                            <td>{!! Form::label('cg_weeks','Weeks:') !!}</td>
                                            <td></td>
                                            <td>{!! Form::label('cg_days','Days:') !!}</td>
                                        </tr>
                                        <tr>
                                            <td>{!! Form::text('cg_weeks',null,['class'=>'form-control input-width-medium']) !!}</td>
                                            <td>+</td>
                                            <td>{!! Form::text('cg_days',null,['class'=>'form-control  input-width-medium']) !!}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"><label class="error help-block" for="cg_weeks" generated="true"></label></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"><label class="error help-block" for="cg_days" generated="true"></label> </td>
                                        </tr>
                                    </table>
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
                                <div class="form-group">
                                    {!! Form::label('AdmissionDate','Admission Date: (DD-MM-YYYY)') !!}
                                    {!! Form::text('AdmissionDate',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('admission_time','Admission Time: (HH:MM:AM or PM)') !!}
                                    {!! Form::text('admission_time',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('TypeOfCare','Type Of Care:') !!}
                                    {!! Form::select('TypeOfCare',['' => 'N/A','Intensive Care'=>'Intensive Care','Special Care'=>'Special Care','Ward Admission'=>'Ward Admission','High Dependancy Care'=>'High Dependancy Care'],null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('IP Number',  Lang::get('home.ip').':') !!}
                                    {!! Form::text('ip_number',null,['class'=>'form-control ip_number','id'=>'ip_number'])  !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('AdmissionWt','Admission Weight (In grams):') !!}
                                    {!! Form::text('AdmissionWt',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    <table class="table age-on-admission">
                                        <thead>
                                            <tr>
                                                <th>{!! Form::label('AgeOnAdmission','Age On Admission (In days):') !!}</th>
                                                <th>{!! Form::label('AgeOnAdmissionhour','(In hours only if < 96):') !!}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{!! Form::text('AgeOnAdmissioninDays',null,['class'=>'form-control']) !!}</td>
                                                <td>{!! Form::text('AgeOnAdmissionhour',null,['class'=>'form-control']) !!}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Surgeon','Surgeon:') !!}
                                    {!! Form::select('Surgeon',[''=>'N/A']+ValuelistHelpers::get_surgeons_lists(),null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('SeenBy','Seen By:') !!}
                                    {!! Form::select('SeenBy',[''=>'N/A']+$doctor_master,null,['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- History Form -->
                <div role="tabpanel" class="tab-pane top-specing @if($active == 'historyform') active @endif" id="historyform">
                    <div class="col-md-12 col-sm-12">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content row mx-0">
                                <div class="col-md-12">
                                    <table class="medi">
                                        <thead>
                                            <tr>
                                                <th>Medical Problems</th>
                                                <th>Medications</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <div class="hidden">
                                                {!! Form::select('temp_medi_probs',[''=>'N/A']+$medi_probs_master,'') !!}
                                            </div>
                                            @if (isset($pbm_data) && count($pbm_data) > 0)
                                            @foreach ($pbm_data as $data)
                                            @php $data = (array)$data; @endphp
                                            <tr>
                                                <td>{!! Form::select('Problems[]',[''=>'N/A']+$medi_probs_master,$data['Problem'],['class'=>'form-control input-width-xlarge']) !!} </td>
                                                <td><input type="text" class="form-control input-width-xlarge" name="Medications[]" value="{!! $data['Medication']; !!}"/></td>
                                                <td><span class="fa fa-remove btn btn-default remove-medi hide"></span></td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td>{!! Form::select('Problems[]',[''=>'N/A']+$medi_probs_master,null,['class'=>'form-control input-width-xlarge']) !!} </td>
                                                <td><input type="text" name="Medications[]" value="" class="form-control input-width-xlarge"/></td>
                                                <td><span class="fa fa-remove btn btn-default remove-medi hide"></span></td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    <a class="btn medi_add btn_add hide" href="javascript:void(0);"><i class="fa fa-plus"></i>
                                        <span>Add More</span>
                                    </a>
                                </div>
                                <div class="row col-md-12">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            {!! Form::label('Smoking','Smoking:') !!}
                                            {!! Form::select('Smoking',[''=>'N/A','No'=>'No','Yes'=>'Yes'],null,['class'=>'form-control']) !!}
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('Alcohol','Alcohol:') !!}
                                            {!! Form::select('Alcohol',[''=>'N/A','No'=>'No','Yes'=>'Yes'],null,['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-5 ">
                                        <div class="form-group">
                                            {!! Form::label('Tobacco','Tobacco:') !!}
                                            {!! Form::select('Tobacco',[''=>'N/A','No'=>'No','Yes'=>'Yes'],null,['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane top-specing @if($active == 'pregform') active @endif" id="pregform">
                    <div class="col-md-12 col-sm-12">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content row mx-0">
                                <div class="col-md-9 form-group">
                                    <table class="complication">
                                        <thead>
                                            <tr>
                                                <th>Complication</th>
                                                <th>Treatment</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <div class="hidden">
                                                {!! Form::select('temp_complications',[''=>'N/A']+$complication_master,null,["class"=>"form-control input-width-small"]) !!}
                                            </div>
                                            @if (isset($neonatal_complication) && count($neonatal_complication) > 0)
                                            @foreach ($neonatal_complication as $com_data)
                                            <tr>
                                                <td>{!! Form::select('Complication[]',[''=>'N/A']+$complication_master,$com_data->Complication,["class"=>"form-control input-width-large"]) !!}</td>
                                                <td><input type="text" class="input-width-medium form-control" name="Treatments[]" value="{!! $com_data->Treatment !!}" /></td>
                                                <td><span class="fa fa-remove btn btn-default remove-medi hide"></span></td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td>{!! Form::select('Complication[]',[''=>'N/A']+$complication_master,null,["class"=>"form-control input-width-large"]) !!}</td>
                                                <td><input type="text" class="input-width-medium form-control" name="Treatments[]" value=""/></td>
                                                <td><span class="fa fa-remove btn btn-default remove-medi hide"></span></td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    <a class="btn_add btn nicu_complication_add hide" href="javascript:void(0);"><i class="fa fa-plus"></i> <span>Add More</span></a>
                                </div>
                                <div class="col-md-9">
                                    <p class="ml-5"><br><b>Antenatal Ultrasound Findings</b> </p>
                                </div>
                                <div class="col-md-9">
                                    <table class="usg">
                                        <thead>
                                            <tr>
                                                <th colspan="3">Dating Scan</th>
                                            </tr>
                                            <tr>
                                                <th>Gestation In Weeks</th>
                                                <th>Findings</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="form-group"><input type="text" value="{{ @$dating_scan->Gestation }}" class="form-control input-width-medium"  name="datinggestations" @if(isset($datingScan['Gestation']) && !empty($datingScan['Gestation'])) readonly="true" @endif /></td>
                                                <td class="form-group"><input type="text" value="{{ @$dating_scan->Finding }}" name="datingfindings" class="form-control input-width-large" @if(isset($datingScan['Gestation']) && !empty($datingScan['Gestation'])) readonly="true" @endif /></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <label for="datinggestations" generated="true" class="error help-block"></label>
                                </div>
                                <div class="col-md-9">
                                    <table class="usg">
                                        <thead>
                                            <tr>
                                                <th colspan="3">Anomaly Scan</th>
                                            </tr>
                                            <tr>
                                                <th>Gestation In Weeks</th>
                                                <th>Findings</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td  class="form-group"><input type="text" name="analoggestations" value="{{ @$anomaly_scan->Gestation }}" class="form-control input-width-medium" @if(isset($analogScan['Gestation']) && !empty($analogScan['Gestation'])) readonly="true" @endif/></td>
                                                <td  class="form-group"><input type="text" name="analogfindings"   value="{{ @$anomaly_scan->Finding }}"  class="form-control input-width-large" @if(isset($analogScan['Gestation']) && !empty($analogScan['Gestation'])) readonly="true" @endif /></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <label for="analoggestations" generated="true" class="error help-block"></label>
                                </div>
                                <div class="col-md-9">
                                    <table class="any-further-scan usg">
                                        <thead>
                                            <tr>
                                                <th colspan="3">Any further scan ?</th>
                                            </tr>
                                            <tr>
                                                <th>Gestation In Weeks</th>
                                                <th>Findings</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($further_scan) && count($further_scan) > 0)
                                            @foreach($further_scan as $scanKey => $scanValue)
                                            <tr>
                                                <td  class="form-group"><input type="text" value="{{ $scanValue->Gestation }}" class="form-control input-width-medium"  name="othergestations[]" id="gestations" /></td>
                                                <td  class="form-group"><input type="text"  value="{{ $scanValue->Finding  }}" name="otherfindings[]" class="form-control input-width-large"  /></td>
                                                <td class="form-group"><span class="fa fa-remove btn btn-default remove-usg hide"></span></td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td  class="form-group"><input type="text" class="form-control input-width-medium"  name="othergestations[]" /></td>
                                                <td  class="form-group"><input type="text" name="otherfindings[]" class="form-control input-width-large"  /></td>
                                                <td class="form-group"><span class="fa fa-remove btn btn-default remove-usg hide"></span></td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    <label for="othergestations[]" generated="true" class="error help-block"></label>
                                    <a class="btn_add btn any-further-scan-add hide" href="javascript:void(0);"><i class="fa fa-plus"></i> <span>Add More</span></a>
                                </div>
                                <div class="col-md-9">
                                    <table class="doppler-scan usg">
                                        <thead>
                                            <tr>
                                                <th colspan="3">Doppler Scan</th>
                                            </tr>
                                            <tr>
                                                <th>Gestation In Weeks</th>
                                                <th>Findings</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($doppler_scan) && count($doppler_scan) > 0)
                                            @foreach($doppler_scan as $dopplerKey => $dopplerValue)
                                            <tr>
                                                <td  class="form-group"><input type="text" value="{{ $dopplerValue->Gestation }}" class="form-control input-width-medium"  name="dopplergestations[]" id="gestations" /></td>
                                                <td  class="form-group"><input type="text"  value="{{  $dopplerValue->Finding  }}" name="dopplerfindings[]" class="form-control input-width-large"  /></td>
                                                <td class="form-group"><span class="fa fa-remove btn btn-default remove-usg hide"></span></td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td  class="form-group"><input type="text" class="form-control input-width-medium"  name="dopplergestations[]" /></td>
                                                <td  class="form-group"><input type="text" name="dopplerfindings[]" class="form-control input-width-large"  /></td>
                                                <td class="form-group"><span class="fa fa-remove btn btn-default remove-usg hide"></span></td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    <label for="dopplergestations[]" generated="true" class="error help-block"></label>
                                    <a class="btn_add btn doppler-scan-add hide" href="javascript:void(0);"><i class="fa fa-plus"></i> <span>Add More</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Baby Details -->
                <div role="tabpanel" class="tab-pane top-specing @if($active == 'babyform') active @endif" id="babyform">
                    <div class="col-md-6 col-sm-6">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content row mx-0">
                                <div class="form-group">
                                    {!! Form::label('DescriptionOfResuscitation','Description Of Resuscitation:') !!}
                                    {!! Form::textarea('DescriptionOfResuscitation',null,['class'=>'form-control','rows' =>5]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Post Resuscitation Care','Post Resuscitation Care') !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('VentilationRequired','Invasive Ventilation Required:') !!}
                                    {!! Form::select('VentilationRequired', [''=>'N/A', 'No'=>'No', 'Yes'=>'Yes'], null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('SurfactantGiven','Surfactant Given In Labour Room / Theatre:') !!}
                                    {!! Form::select('SurfactantGiven',[''=>'N/A','Yes'=>'Yes','No'=>'No'],null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('SurfactantType','Surfactant Type:') !!}
                                    {!! Form::select('SurfactantType',[''=>'N/A','Curosurf'=>'Curosurf','Survanta'=>'Survanta','Neosurf'=>'Neosurf'],null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Dose','Dose:') !!}
                                    {!! Form::text('Dose',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('DateofAdministration','Date of Administration: (DD-MM-YYYY)') !!}
                                    {!! Form::text('DateofAdministration',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('time_of_adminstration','Time Of Administration: (HH:MM:AM or PM)') !!}
                                    {!! Form::text('time_of_adminstration',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('AgeAfterBirth','Age After Birth:') !!}
                                    {!! Form::text('AgeAfterBirth',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('delivery_cpap','Delivery room CPAP given ?:') !!}
                                    {!! Form::select('delivery_cpap', [''=>'N/A','No'=>'No', 'Yes'=>'Yes'],null, ['class'=>'form-control']) !!}
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
                                <div class="form-group">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>{!! Form::label('air_flow','Air Flow During Transfer L/min:') !!}</th>
                                                <th>{!! Form::label('oxgen_flow','Oxygen Flow During Transfer L/min:') !!}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{!! Form::text('air_flow',null,['class'=>'form-control input-width-medium']) !!}</td>
                                                <td>{!! Form::text('oxgen_flow',null,['class'=>'form-control input-width-medium']) !!}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><label for="air_flow" generated="true" class="error help-block"></label></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><label for="oxgen_flow" generated="true" class="error help-block"></label></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('TransferFiO2','Calculated / Actual FIO2% During Transfer:') !!}
                                    {!! Form::text('TransferFiO2',null,['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Admission Form -->
                <div role="tabpanel" class="tab-pane top-specing @if($active == 'admissform') active @endif" id="admissform">
                    <div class="col-md-6 col-sm-6">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content row mx-0">
                                <div class="form-group">
                                    {!! Form::label('AdmittedFrom','Admitted From:') !!}
                                    {!! Form::select('AdmittedFrom',[''=>'N/A','Labour ward'=>'Labour ward','Postnatal ward'=>'Postnatal ward','OP'=>'OP','Outside Hospital'=>'Outside Hospital','Obstetric theatres'=>'Obstetric theatres'], null, ['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('MajorComplaints','Major Complaints:') !!}
                                    {!! Form::textarea('MajorComplaints',null,['class'=>'form-control','rows' => 5]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Ventilation','Respiratory Support at the time of admission:') !!}
                                    {!! Form::select('Ventilation', [''=>'N/A','No'=>'No','Yes'=>'Yes'], null, ['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Mode','Mode:') !!}
                                    {!! Form::select('Mode',[''=>'N/A']+$admissionmode_master,null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Pip','Pip:') !!}
                                    {!! Form::text('Pip',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('PEEP','PEEP:') !!}
                                    {!! Form::text('PEEP',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('amplitude_delta','Amplitude &delta; :') !!}
                                    {!! Form::text('amplitude_delta',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('mean_airway_pressure','Mean Airway Pressure:') !!}
                                    {!! Form::text('mean_airway_pressure',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Rate','Rate\Frequency:') !!}
                                    {!! Form::text('Rate',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('IT','IT:') !!}
                                    {!! Form::text('IT',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Fio2','FIO2 %:') !!}
                                    {!! Form::text('Fio2',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Flow_l_min','Flow (L/Min):') !!}
                                    {!! Form::text('Flow_l_min',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('RR','RR:') !!}
                                    {!! Form::text('RR',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('nicu_retractions','Retractions:') !!}
                                    {!! Form::select('nicu_retractions',[''=>'N/A','No'=>'No','Mild'=>'Mild','Moderate'=>'Moderate','Severe'=>'Severe'],null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('Retractions')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('nicu_airentry','Air entry:') !!}
                                    {!! Form::select('nicu_airentry',[''=>'N/A','Equal'=>'Equal','Reduced Bilateral'=>'Reduced Bilateral','Reduced Rt'=>'Reduced Right','Reduced Lt'=>'Reduced Left'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('AirEntry')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('ChestMovement','Chest Movement:') !!}
                                    {!! Form::select('ChestMovement',[''=>'N/A','Symmetrical'=>'Symmetrical','Asymmetrical'=>'Asymmetrical'],null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('HR','HR in bpm:') !!}
                                    {!! Form::text('HR',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('BP','Systolic BP:') !!}
                                    {!! Form::text('BP',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('diastolic_bp','Diastolic BP:') !!}
                                    {!! Form::text('diastolic_bp',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('MeanBP','Mean BP:') !!}
                                    {!! Form::text('MeanBP',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('nicu_central_pulses','Central Pulses:') !!}
                                    {!! Form::select('nicu_central_pulses',[''=>'N/A','Normal'=>'Normal','Bounding'=>'Bounding','Feeble/Weak'=>'Feeble/Weak','Absent'=>'Absent'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('PeripheralPulses')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('nicu_peripheral_pulses','Peripheral Pulses:') !!}
                                    {!! Form::select('nicu_peripheral_pulses',[''=>'N/A','Normal'=>'Normal','Bounding'=>'Bounding','Feeble/Weak'=>'Feeble/Weak','Absent'=>'Absent'],null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('PeripheralPulses')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('nicu_femoral_pulses','Femoral Pulses:') !!}
                                    {!! Form::select('nicu_femoral_pulses',[''=>'N/A','Normal'=>'Normal','Bounding'=>'Bounding','Feeble/Weak'=>'Feeble/Weak','Absent'=>'Absent'],null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('PeripheralPulses')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('nicu_s1s2','S1S2:') !!}
                                    {!! Form::select('nicu_s1s2',[''=>'N/A','Normal'=>'Normal','Abnormal'=>'Abnormal'],null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('nicu_murmur','Murmur:') !!}
                                    {!! Form::select('nicu_murmur',[''=>'N/A','Present'=>'Present','Absent'=>'Absent'],null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('default')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('CFT','CFT:') !!}
                                    {!! Form::select('CFT',[''=>'N/A','< 3 Seconds' => "< 3 Seconds",'3-5 Seconds' => "3-5 Seconds",'>5 Seconds' => ">5 Seconds","Prolonged"=>"Prolonged"],null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('nicu_color','Color:') !!}
                                    {!! Form::select('nicu_color',[''=>'N/A','Yellow'=>'Yellow','Pale'=>'Pale','Pink' => "Pink","Acral Cyanosis"=>"Acral Cyanosis","Central Cyanosis"=>"Central Cyanosis"],null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('Color')]) !!}
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
                                <div class="form-group">
                                    {!! Form::label('Temperature','Temperature (F/C):') !!}
                                    {!! Form::text('Temperature',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('nicu_abdomen','Abdomen:') !!}
                                    {!! Form::select('nicu_abdomen',[''=>'N/A','Normal'=>'Normal','Scaphoid'=>'Scaphoid','Distended'=>'Distended'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('Abdomen')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('nicu_bowel_sounds','Bowel Sounds:') !!}
                                    {!! Form::select('nicu_bowel_sounds',[''=>'N/A','Normal'=>"Normal","Increased"=>"Increased","Decreased"=>"Decreased","Absent"=>"Absent"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('BowelSounds')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('nicu_umbilicus','Umbilicus:') !!}
                                    {!! Form::select('nicu_umbilicus',[''=>'N/A','Healthy' => "Healthy","Possible infection"=>"Possible infection","Omphalitis"=>"Omphalitis","Omphalocele"=>"Omphalocele","Gastroschisis"=>"Gastroschisis","Hernia"=>"Hernia","Meconium Stained" => "Meconium Stained","Large" => "Large","Shrivelled" => "Shrivelled"],null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('nicu_hepatomegaly','Hepatomegaly:') !!}
                                    {!! Form::select('nicu_hepatomegaly',[''=>'N/A','No' => "No","Yes"=>"Yes"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('nicu_splenomegaly','Splenomegaly:') !!}
                                    {!! Form::select('nicu_splenomegaly',[''=>'N/A','No' =>"No","Yes"=>"Yes"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('nicu_herina','Hernia:') !!}
                                    {!! Form::select('nicu_herina',[''=>'N/A','No hernia' => "No hernia","Right Inguinal hernia"=>"Right Inguinal hernia","Left Inguinal hernia"=>"Left Inguinal hernia","Umbilical/para umbilical hernia"=>"Umbilical/para umbilical hernia","Obstructed/strangulated"=>"Obstructed/strangulated"],null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('nicu_genitalia','Genitalia:') !!}
                                    {!! Form::select('nicu_genitalia',[''=>'N/A']+ValuelistHelpers::getGentila(),null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('nicu_genitalia_findings', 'Genitalia Findings:') !!}
                                    {!! Form::text('nicu_genitalia_findings',null,['class'=>'form-control'])!!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('nicu_pupils','Pupils:') !!}
                                    {!! Form::select('nicu_pupils', [''=>'N/A']+ValuelistHelpers::getPupils(), null, ['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('nicu_pupils_findings','Pupils Findings:') !!}
                                    {!! Form::text('nicu_pupils_findings',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('nicu_anteriorfontanelle','Anterior Fontanelle:') !!}
                                    {!! Form::select('nicu_anteriorfontanelle',[''=>'N/A','Normal' =>"Normal","Depressed"=>"Depressed","Bulging"=>"Bulging"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('AnteriorFontanelle')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('nicu_activity','Activity:') !!}
                                    {!! Form::select('nicu_activity',[''=>'N/A',"Normal" =>"Normal","Comatosed"=>"Comatosed","Decreased"=>"Decreased","Increased"=>"Increased","Irritable"=>"Irritable","Sedated/Paralysed"=>"Sedated/Paralysed"],null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Tone','Tone') !!}
                                    {!! Form::select('Tone',[''=>'N/A','Normal' =>"Normal","Hypotonia"=>"Hypotonia","Hypertonia"=>"Hypertonia","Sedated/Paralysed"=>"Sedated/Paralysed"],null,['class'=>'form-control'])!!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('nicu_cry','Cry:') !!}
                                    {!! Form::select('nicu_cry',[''=>'N/A',"Normal consolable"=>"Normal consolable", "Abnormal Inconsolable" => "Abnormal Inconsolable", "High pitched cry"=>"High pitched cry", "Weak Cry"=>"Weak Cry", "Sedated/Paralysed"=>"Sedated/Paralysed"],null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('nicu_seizures','Seizures:') !!}
                                    {!! Form::select('nicu_seizures',[''=>'N/A','No' =>"No","Yes"=>"Yes"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('nicu_neonatalreflexes','Neonatal Reflexes:') !!}
                                    {!! Form::select('nicu_neonatalreflexes',[''=>'N/A','Normal' =>"Normal","Suppressed"=>"Suppressed","Absent"=>"Absent","Exaggerated"=>"Exaggerated","Sedated/Paralysed"=>"Sedated/Paralysed"],null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Skin','Skin:') !!}
                                    {!! Form::text('Skin',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Abnormalities','Admission Examination Findings:') !!}
                                    {!! Form::textarea('Abnormalities',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('InitialBloodGas','Initial Blood Gas:') !!}
                                    {!! Form::select('InitialBloodGas',[''=>'N/A','Not done'=>'Not done','Not indicated'=>'Not indicated','Arterial'=>'Arterial','Venous'=>'Venous','Capillary'=>'Capillary'],null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('AgeTaken','Age in hours at the time of blood gas:') !!}
                                    {!! Form::text('AgeTaken',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('SpO2','SpO2:') !!}
                                    {!! Form::text('SpO2',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('pH','pH:') !!}
                                    {!! Form::text('pH',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('PaO2','PaO2:') !!}
                                    {!! Form::text('PaO2',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('PaCo2','PaCo2:') !!}
                                    {!! Form::text('PaCo2',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('HCO3','HCO3:') !!}
                                    {!! Form::text('HCO3',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('BE','BE:') !!}
                                    {!! Form::text('BE',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('RBS','RBS:') !!}
                                    {!! Form::text('RBS',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Hct','Hct:') !!}
                                    {!! Form::text('Hct',null,['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Procedure Form-->
                <div role="tabpanel" class="tab-pane top-specing @if($active == 'Proform') active @endif" id="Proform">
                    <div class="col-md-6 col-sm-6">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content row mx-0">
                                <div class="form-group">
                                    {!! Form::label('InitialXray','Initial X ray:') !!}
                                    {!! Form::select('InitialXray',[''=>'N/A','Not done' => 'Not done','Not indicated' =>'Not indicated','Performed'=> 'Performed'],null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('xrayfindings','Chest X ray findings:') !!}
                                    {!! Form::text('xrayfindings',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('AgeofCXR','Abdominal X Ray findings:') !!}
                                    {!! Form::text('AgeofCXR',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('UAC','UAC:') !!}
                                    {!! Form::select('UAC', [''=>'N/A', 'No'=>'No', 'Yes'=>'Yes'],null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('UACPosition','UACPosition:') !!}
                                    {!! Form::text('UACPosition',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('UVC','UVC:') !!}
                                    {!! Form::select('UVC',[''=>'N/A', 'No'=>'No', 'Yes'=>'Yes'],null, ['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('UVCPosition','UVCPosition:') !!}
                                    {!! Form::text('UVCPosition',null,['class'=>'form-control']) !!}
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
                                <div class="form-group">
                                    {!! Form::label('SepsisScreen','SepsisScreen:') !!}
                                    {!! Form::select('SepsisScreen',[''=>'N/A','Yes'=>'Yes','No'=>'No'],null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Indications','Indications:') !!}
                                    {!! Form::text('Indications',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="hidden">
                                    {!! Form::select('IVAntibiotic',[''=>'N/A']+ValuelistHelpers::getDrugIvFluidsAntibiotic(),null,['class'=>'form-control  input-width-large']) !!}
                                </div>
                                <div class="form-group">
                                    <table class="IVAntibiotic table table-add-more">
                                        <tr>
                                            <td>{!! Form::label('IVAntibiotic','IV Antibiotic:') !!}</td>
                                        </tr>
                                        @if(isset($antibiotic) && count($antibiotic) > 0 && $antibiotic != '')
                                        @foreach($antibiotic as $antibiotic_values)
                                        <tr>
                                            <td class="full-width">{!! Form::select('IVAntibiotic[]',[''=>'N/A']+ValuelistHelpers::getDrugIvFluidsAntibiotic(),$antibiotic_values,['class'=>'form-control full-width']) !!}</td>
                                            <td><span class="fa fa-remove btn btn-default remove-ivantibitic hide"></span></td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td class="full-width">{!! Form::select('IVAntibiotic[]',[''=>'N/A']+ValuelistHelpers::getDrugIvFluidsAntibiotic(),null,['class'=>'form-control full-width']) !!}</td>
                                            <td><span class="fa fa-remove btn btn-default remove-ivantibitic hide"></span></td>
                                        </tr>
                                        @endif
                                    </table>
                                    <a class="btn ivantibitic_add btn_add hide" href="javascript:void(0);">
                                        <i class="fa fa-plus"></i>
                                        <span>Add More</span>
                                    </a>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Investigations','Investigations:') !!}
                                    {!! Form::text('Investigations',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Fluids','Fluids/Feeds ml/kg/d:') !!}
                                    {!! Form::text('Fluids',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('NBM','Enteral Feeding:') !!}
                                    {!! Form::select('NBM',[''=>'N/A','Yes'=>'Yes','No'=>'No'],null,['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- CRIB FORM -->
                <div role="tabpanel" class="tab-pane top-specing @if($active == 'Cribform') active @endif" id="Cribform">
                    <div class="col-md-6 col-sm-6">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content row mx-0">
                                <div class="form-group">
                                    {!! Form::label('SexBirthWtGestation','Sex,Birth Wt & Gestation:') !!}
                                    {!! Form::text('SexBirthWtGestation',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('TemperatureAtAdmission','Temperature At Admission:') !!}
                                    {!! Form::text('TemperatureAtAdmission',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('BaseExcess','Base Excess:') !!}
                                    {!! Form::text('BaseExcess',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('TotalCRIB2Score','Total CRIB II Score:') !!}
                                    {!! Form::text('TotalCRIB2Score',null,['class'=>'form-control']) !!}
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
                                <img src='{{ url("public/img/crib11.png") }}'/>
                            </div>
                        </div>
                    </div>
                </div>
                <!--  SNAPPE II -->
                <div role="tabpanel" class="tab-pane top-specing @if($active == 'Snapform') active @endif" id="Snapform">
                    <div class="col-md-6 col-sm-6">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content row mx-0">
                                <div class="form-group">
                                    {!! Form::label('MBP','MBP:') !!}
                                    {!! Form::select('MBP',[''=>'N/A','0'=>'0','9'=>'9','19'=>'19'],null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('LowestTemperature','Lowest Temperature:') !!}
                                    {!! Form::select('LowestTemperature',[''=>'N/A','0'=>'0','8'=>'8','15'=>'15'],null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Po2Fio2Ratio','Po2 Fio2 Ratio:') !!}
                                    {!! Form::select('Po2Fio2Ratio',[''=>'N/A','0'=>'0','5'=>'5','16'=>'16','28'=>'28'],null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('LowestSerumPh','Lowest Serum Ph:') !!}
                                    {!! Form::select('LowestSerumPh',[''=>'N/A','0'=>'0','7'=>'7','16'=>'16'],null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('MultipleSeizures','Multiple Seizures:') !!}
                                    {!! Form::select('MultipleSeizures',[''=>'N/A','0'=>'0','19'=>'19'],null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('UrineOutput','Urine Output:') !!}
                                    {!! Form::select('UrineOutput',[''=>'N/A','0'=>'0','5'=>'5','18'=>'18'],null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('BWeight','Birth Weight:') !!}
                                    {!! Form::select('BWeight',[''=>'N/A','0'=>'0','10'=>'10','17'=>'17'],null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('SgaLessThan3rdPercentile','Small for Gestational Age:') !!}
                                    {!! Form::select('SgaLessThan3rdPercentile',[''=>'N/A','0'=>'0','12'=>'12'],null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Apgar5Mins','Apgar5Mins:') !!}
                                    {!! Form::select('Apgar5Mins',[''=>'N/A','0'=>'0','18'=>'18'],null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('TotalSNAP2Score','Total SNAP II Score:') !!}
                                    {!! Form::text('TotalSNAP2Score',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('TotalSNAPPE2Score','Total SNAPPE II Score:') !!}
                                    {!! Form::text('TotalSNAPPE2Score',null,['class'=>'form-control']) !!}
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
                                <img src='{{ url("public/img/snapII.png") }}'/>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Diagnosis -->
                <div role="tabpanel" class="tab-pane top-specing @if($active == 'Diagform') active @endif" id="Diagform">
                    <div class="col-md-12 col-sm-12">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content row mx-0">
                                <div class="form-group">
                                    {!! Form::label('DifferentialDiagnosis','Differential Diagnosis:') !!}
                                    @if(isset($differential_diagnosis) && count($differential_diagnosis))
                                    {!! Form::Select('DifferentialDiagnosis[]',$icd_code,$differential_diagnosis,['class'=>'select2-select-00 full-width-fix','multiple']) !!}
                                    @else 
                                    {!! Form::Select('DifferentialDiagnosis[]',$icd_code,null,['class'=>'select2-select-00 full-width-fix','multiple']) !!}
                                    @endif 
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
                                <div class="form-group">
                                    <table class="additional_diagnosis table">
                                        <tr>
                                            <td>{!! Form::label('additional_diagnosis','Additional Diagnosis:') !!}</td>
                                        </tr>
                                        @if(isset($additional_diagnosis) && count($additional_diagnosis) > 0)
                                        @foreach($additional_diagnosis as $additional)
                                        <tr>
                                            <td class="full-width"><input type="text" name="additional_diagnosis[]" value="{{ $additional }}" class="form-control full-width"></td>
                                            <td><span class="fa fa-remove btn btn-default remove-additional-diagnosis hide"></span></td>
                                        </tr>
                                        @endforeach 
                                        @else
                                        <tr>
                                            <td class="full-width"><input type="text" name="additional_diagnosis[]" value="" class="form-control full-width"></td>
                                            <td><span class="fa fa-remove btn btn-default remove-additional-diagnosis hide"></span></td>
                                        </tr>
                                        @endif   
                                    </table>
                                </div>
                                <a class="btn additional_diagnosis_add btn_add hide" href="javascript:void(0);">
                                    <i class="fa fa-plus"></i>
                                    <span>Add More</span>
                                </a>    
                                <div class="form-group">
                                    {!! Form::label('Plan','Plan:') !!}
                                    {!! Form::textarea('Plan',null,['class'=>'form-control','rows'=>5]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('ParentsSpokenTo','Parents Spoken To:') !!}
                                    {!! Form::select('ParentsSpokenTo', [''=>'N/A', 'No'=>'No', 'Yes'=>'Yes'],null, ['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('discussion_time','Time of Discussion: (HH:MM:AM or PM)') !!}
                                    {!! Form::text('discussion_time',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('MattersDiscussed','Matters Discussed:') !!}
                                    {!! Form::textarea('MattersDiscussed',null,['class'=>'form-control','rows'=>5]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('ParentsAddressedBy','Parents Addressed By:') !!}
                                    {!! Form::text('ParentsAddressedBy',null,['class'=>'form-control']) !!}
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
                                <div class="form-group">
                                    {!! Form::label('indication_of_admission','Indication For Admission:') !!}
                                    <div>
                                        {!! Form::checkbox('indication_of_admission[]',1,false) !!}
                                        {!! Form::label('Prematurity','Prematurity',['class'=>'title']) !!}
                                    </div>
                                    <div>
                                        {!! Form::checkbox('indication_of_admission[]',2,false) !!}
                                        {!! Form::label('Low birth weight','Low birth weight',['class'=>'title']) !!}
                                    </div>
                                    <div>
                                        {!! Form::checkbox('indication_of_admission[]',3,false) !!}
                                        {!! Form::label('RD','RD',['class'=>'title']) !!}
                                    </div>
                                    <div>
                                        {!! Form::checkbox('indication_of_admission[]',4,false) !!}
                                        {!! Form::label('Birth asphyxia','Birth asphyxia',['class'=>'title']) !!}
                                    </div>
                                    <div>
                                        {!! Form::checkbox('indication_of_admission[]',5,false) !!}
                                        {!! Form::label('Sepsis','Sepsis',['class'=>'title']) !!}
                                    </div>
                                    <div>
                                        {!! Form::checkbox('indication_of_admission[]',6,false) !!}
                                        {!! Form::label('Shock','Shock',['class'=>'title']) !!}
                                    </div>
                                    <div>
                                        {!! Form::checkbox('indication_of_admission[]',7,false) !!}
                                        {!! Form::label('Jaundice','Jaundice',['class'=>'title']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('indication_of_admission_other','Others (specify):') !!}
                                    {!! Form::text('indication_of_admission_other',null,['class'=>'form-control shadow']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- NewBorn Examination -->
                <div class="row bottom-specing col-md-12">
                    @if(isset($nicuList) && count($nicuList) < 1)
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary save-button-shadow btn-block form-control">
                            <i class="fa fa-floppy-o"></i> 
                            <span>{!! $SubmitButtonText !!}</span>
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
        {!! Form::close() !!}
    </div>
</div>
<div class="col-md-3 col-sm-3 col-xs-3 custom-fields-search-list-sidebar @if(isset($nicuList) && count($nicuList) > 0) sidebar-scroll-enable @endif nicu-advance-search ml-10">
    <table class="table table-striped table-bordered  table-responsive"  id="data-list">
        <thead>
            <tr class="hide">
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @if(isset($nicuList) && count($nicuList) > 0)
            @foreach($nicuList as $babyid => $admissionList)
            <tr>
                <td>
                    <div class="fields-search-list baby-name-list">
                        {{ ValuelistHelpers::getValuebykey($tempResults,'BabyId','BabyName',$babyid) }} - {{ ValuelistHelpers::getValuebykey(collect($tempResults),'BabyId','BMrNo',$babyid) }}
                        <a href="javascript:void(0)" class="search-sidebar">
                            <i class="fa fa-chevron-down" aria-hidden="true"></i>
                        </a>
                    </div>
                    <div class="display-none">
                        @foreach($admissionList as $admissionId)
                        <div class="fields-search-list baby-admission-list @if(Request::segment(2) == $admissionId) search-list-active @endif"" >
                            <a href="{{ action('Search\SearchNicuadmissionController@nicuadmissionSearchview',SiteHelpers::encrypt_id($admissionId)) }}">
                                {!! ValuelistHelpers::getValuebykey($tempResults,'NicuId','episodes',$admissionId) !!}  
                            </a>
                        </div>
                        @endforeach
                    </div>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td>
                    <div class="fields-search-list">
                        <div class="text-center"> No Records Found </div>
                    </div>
                </td>
            </tr>
            @endif  
        </div>
    </tbody>
</table>
<?php 
if (isset($nicuList)) {
    $getTotal = count($nicuList);
    $total = \Session::get('nicu_count');
    $page = \Session::get('nicucurrentpage');
    $limit = 10;
    $pagecount = ceil($total / $limit);
    $pagination['total'] = $total;
    $pagination['start'] = (($page - 2) < 1) ? 1 : ($page - 2);
    $pagination['end'] = ($pagecount < ($page + 3)) ? $pagecount : ($page + 3);
    $pagestart = $total != 0 ? ($page <= 1) ? $page : ($page - 1) * $limit + 1 : 0;
    $pagerecords = ($page == $pagination['end'] || $pagination['total'] == 0) ? $pagination['total'] : $page * $limit;
    $pagination['limit'] = array(
        $pagestart,
        $pagerecords
    );
    $pagination['limits'] = $limit;
    $pagination['previous'] = (($page - 1) < 1) ? 1 : ($page - 1);
    $pagination['next'] = ($pagecount < ($page + 1)) ? $pagecount : ($page + 1);
}
$page = isset($page) ? $page : 1;
?>
<div class="dataTables_footer clearfix">
    <div class="col-md-12 col-sm-12 col-xs-12 pagination-xs">
        <div class="dataTables_paginate paging_bootstrap pagination_footer">
            <ul class="pagination">
                <li class="prev @if($page == '' || $page == @$pagination['start']) disabled @endif">
                    <a class="@if($page != @$pagination['start'] &&  $page != '') sort_with_page @endif" href="@if($page == @$pagination['start'] || $page == '') javascript:void(0); @else {{url('nicu-search?page='.@$pagination['previous'])}}@endif">&#8592; {{ Lang::get('home.neonatal_previous') }}</a>
                </li>
                @if (@$getTotal > 0)
                @for ($i = @$pagination['start']; $i <= @$pagination['end']; $i++) 
                <li class="@if($i == $page) active @elseif($page == '' && $i == @$pagination['start']) active @endif">
                    <a class='sort_with_page' href="{{url('nicu-search?page='.$i)}}">{{$i}}</a>
                </li>
                @endfor
                @endif
                <li class="next @if($page == @$pagination['end'] || @$pagination['total'] <= @$pagination['limits']) disabled @endif">
                    <a class="@if($page != @$pagination['end'] && @$pagination['start'] != @$pagination['end']) sort_with_page @endif" href="@if($page == @$pagination['end'] || @$pagination['total'] <= @$pagination['limits']) javascript:void(0); @else {{url('nicu-search?page='.@$pagination['next'])}}@endif">{{ Lang::get('home.neonatal_next') }} → </a>  
                </li>
            </ul>
        </div>
    </div>
</div>
@php $nicu = Config('exportfields.nicu'); @endphp
<div class="modal fade" id="exportModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <h3 class="text-center text-white">Choose Fields To Be Export</h3>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="close-font">&times;</span>
                </button>
            </div>
            <div class="modal-body row">
                {{ Form::open(['url'=>action('Search\SearchNicuadmissionController@NicuListdownload'),'method'=>'post','id'=>'export-sheet']) }}
                <div class="col-md-12">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('file_name','Save As Name') }}
                            {{ Form::text('file_name','nicu-search-list',['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group ">
                            {{ Form::label('file_format','Save As Format') }}
                            {{ Form::select('file_format',['xlsx'=>'xlsx','xlsm'=>'xlsm','csv'=>'csv'],null,['class'=>'form-control']) }}
                        </div>
                    </div>
                </div>
                {{ Form::hidden('nicu_export_list') }}
                <div class="col-md-12 plr-30">
                    <select multiple="multiple" size="10" id="nicu-options" name="nicu-options">
                        @foreach($nicu as $listkey => $listvalue)
                        <option value="{{ $listkey }}">{{ $listvalue }}</option>
                        @endforeach                   
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-info btn-basic-shadow pull-right export-fields">Export</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    $('.search-sidebar').click(function(){

        $(this).parent().next('div').slideToggle('fast');

        if($(this).children('i').hasClass('fa-chevron-down')) {

           $(this).children('i').removeClass('fa-chevron-down').addClass('fa-chevron-up');

       }else{

           $(this).children('i').removeClass('fa-chevron-up').addClass('fa-chevron-down');
       }
   });   

    $('.search-list-active').parent().prev('div').children('a').click();
    $('.search-list-active').parent().parent().prev('div').children('a').click();   

    $('.nav-tabs li a').click(function(){
     $('#set_active').val($(this).attr('aria-controls'));
     $.cookie('nicuform', $(this).attr('aria-controls'));
 });

    var acive_id=$.cookie('nicuform');
    if(acive_id!='' && acive_id!=null ){

      $('.nav-tabs li').each(function(){
          if($(this).hasClass('active')){
              $(this).removeClass('active');
          }
      });
      $('.tab-pane').each(function(){
        if($(this).hasClass('active')){
          $(this).removeClass('active');
      }

  });

      $('a[href="#'+acive_id+'"]').parent().addClass('active');
      $('#'+acive_id).addClass('active');
  }

  $('.export').click(function(e){
    e.preventDefault();           
    $('#exportModal').modal('show');
});

  $(document).ready(function(){
    new DualListbox("#nicu-options", {
        availableTitle: "Available numbers",
        selectedTitle: "Selected numbers",
        addButtonText: ">",
        removeButtonText: "<",
        addAllButtonText: ">>",
        removeAllButtonText: "<<",
        searchPlaceholder: "search numbers",
        enableDoubleClick: true,
    });
});

  $('.export-fields').click(function(e) {
    e.preventDefault();
    var value_list = [];
    $('.dual-listbox__selected li').each(function(){
        value_list.push($(this).attr('data-id'));
    });

    var validate   =  false;

    $('.error-export').remove();

    $('input[name="nicu_export_list"]').val(JSON.stringify(value_list));

    if ($('input[name="file_name"]').val() == '') {
        validate = true;
        $('input[name="file_name"]').after('<span class="error-export"> This fields required</span>');
    }
    if (value_list.length == 0) {
        validate = true;
        $('select[name="nicu-options_helper2"]').after('<span class="error-export"> Please Choose The Fields required</span>');
    }

    if (!validate) {
        $('#export-sheet').submit();
        $('#exportModal').modal('hide');
    }
});

  $('.container').addClass('advance-search');
  $('#container').addClass('advance-search');

</script>
@endsection
