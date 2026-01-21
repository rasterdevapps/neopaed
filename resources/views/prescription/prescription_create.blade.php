@php
$site_url = url('/').'/public';
@endphp
@extends('app')
@section('content')
@if(env('PUMP_INTERFACE'))
@php $start = 'Send'; @endphp
@else
@php $start = 'Start'; @endphp
@endif
<div class="col-md-12 @if(env('PUMP_INTERFACE')) prescription-interface @endif @if(@$is_discharged == 1) patient_is_discharge @endif plr-0" id="prescription-body">
    <div class="row">
        <!-- Breadcrumbs line -->
        <div class="col-md-12 col-sm-12 xs-mb-10 plr-0">
            <div class="crumbs bread-crumbs-shadow nature-nav">
                <ul id="breadcrumbs" class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="{{ url('/') }} ">Dashboard</a>
                    </li>
                    <li class="current">
                        <a href="{{ url('prescription/create') }}">Back To Sheet</a>
                    </li>
                </ul>
                <div class="pull-right mr-20">
                    @php 
                        $mrn = $baby_details->BMrNo; 

                        echo \SiteHelpers::menuList($mrn, 'prescription');
                    @endphp
                </div>
                <ul class="pull-right prescription-nav-header discharge-color-code display-flex list-none pr-30">
                    <li><span class="syringe-pump-status-1"></span> 
                        <b>Waiting For Confirmation</b>
                    </li>
                    <li><span class="syringe-pump-status-2"></span> 
                        <b>Confirmed</b>
                    </li>
                    <li><span class="syringe-pump-status-3"></span> 
                        <b>In Pump Queue / Resend</b>
                    </li>
                    <li><span class="syringe-pump-status-5"></span> 
                        <b>Executing / Running</b>
                    </li>
                    <li><span class="syringe-pump-status-4"></span> 
                        <b>Pump in pause</b>
                    </li>
                    <li><span class="syringe-pump-status-20"></span> 
                        <b>Stop / Cancel</b>
                    </li>
                </ul>
            </div>
            <div class="crumbs bread-crumbs-shadow changed-nav">
                <ul id="breadcrumbs" class="breadcrumb">
                    <li style="padding-top: 5px;">
                        <b style="font-size: 20px;" class="text-captialize">{!! isset($baby_details->BabyName) ? $baby_details->BabyName :''  !!} - {!! isset($baby_details->BMrNo) ? $baby_details->BMrNo : '' !!}</b>
                        <i class="fa fa-info-circle" id="baby-info-more" aria-hidden="true"></i>
                    </li>
                </ul>
                <div class="pull-right">
                    @php 
                        $mrn = $baby_details->BMrNo; 

                        echo \SiteHelpers::menuList($mrn, 'prescription');
                    @endphp
                </div>
                <ul class="list-none pull-right">
                    <li>
                        @if (isset($user_role) && ($user_role == env('SUPER_ADMIN_ROLE') || $user_role == env('ADMIN_ROLE')))
                        <button type="button" class="btn btn-primary save-button-shadow drug-fluids-masters action-btn" style="margin-top: 3px;margin-bottom: 3px;"><i class="fas fa-briefcase-medical" style="font-size: 11px"></i>&nbsp;Med.</button>&nbsp;
                        <button type="button" class="btn btn-primary save-button-shadow frequency-masters action-btn" style="margin-top: 3px;margin-bottom: 3px;"><i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;Freq.</button>&nbsp;
                        @endif
                        @if(isset($closelink) && !empty($closelink)) 
                        <a href="{{ url($closelink) }}" class="btn btn-danger save-button-shadow pull-right" style="margin: 2px 0px 0px 0px !important; padding: 7px 9px;">
                            <i class="fa fa-times fa-lg"></i>
                        </a>
                        @endif
                        <button class="btn btn-primary save-button-shadow master-icons prescription-print bs-tooltip pull-right" style="margin: 4px 15px 0px 15px !important;" data-baby-id={{\SiteHelpers::encrypt_id($baby_id)}} data-admission-id={{\SiteHelpers::encrypt_id($admission_id)}} data-closewinlink="{{$closewinlink}}" data-original-title="Print" data-selected-date="0"><i class="fa fa-print fa-lg"></i></button>
                        <i class="fa fa-question-circle fa-2x pull-right" id="pump-info-more" style="margin: 6px 0px 0px 10px;" aria-hidden="true"></i>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Breadcrumbs line -->
    {!! Form::hidden('prescription_list', json_encode($prescription_list)) !!}
        {!! Form::hidden('intravenous_prescription_list', json_encode($intravenous_prescription_list)) !!}
        {!! Form::hidden('prescribed_date_list', $prescribed_date_list) !!}
        {!! Form::hidden('is_discharged', $is_discharged) !!}
        {!! Form::hidden('baby_id',$baby_id) !!}
        {!! Form::hidden('admission_id',$admission_id) !!}
        {!! Form::hidden('BMrNo', $baby_details->BMrNo, ['id'=>'BMrNo']) !!}
        @php $ip_number = isset($ip_details) ? $ip_details->ip_number : ''; @endphp
        {!! Form::hidden('ip_number', $ip_number, ['id'=>'ip_number']) !!}
        {!! Form::hidden('pump_interface', env('PUMP_INTERFACE')) !!}
        {!! Form::hidden('user_role', @$user_role) !!}
        {!! Form::hidden('super_admin_role', env('SUPER_ADMIN_ROLE')) !!}
        {!! Form::hidden('admin_role', env('ADMIN_ROLE')) !!}
        {!! Form::hidden('baby_bed_id', @$bed_id) !!}
        {!! Form::hidden('doctor_id', @$doctor_id) !!}
        {!! Form::hidden('prescription_freq', json_encode($prescription_freq_dialpad)) !!}
        @php 
        $c_dtl = $baby_details->BabyName . '(' . $baby_details->BMrNo . ')' . '^' . $baby_id . '^' .$admission_id;
        $temp = \Session::get('over_due_list');
        $over_due_list = [];
        @endphp
        @if (isset($temp[$c_dtl]))
        @php $over_due_list = array_values($temp[$c_dtl]); @endphp
        @endif
        {!! Form::hidden('over_dose_list', json_encode($over_due_list)) !!}
    <div id="prescription-content">
        <div class="col-md-12 col-sm-12 prescription-info plr-0">
            <div class="col-md-4 col-sm-5 col-xs-12 plr-0">
                <div class="col-md-12 custom-padding">
                    <table class="table basic-details">
                        <tbody>
                            <tr>
                                <td class="text-wrap-none">
                                    <b>Baby's Name:</b> <span class="text-captialize">{!! isset($baby_details->BabyName) ? $baby_details->BabyName :''  !!}</span>
                                </td>
                                <td>
                                    <b>{{ Lang::get('home.mrn') }}:</b> <span>{!! isset($baby_details->BMrNo) ? $baby_details->BMrNo : '' !!} </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <b>{{ Lang::get('home.ip') }}:</b> <span>{!! isset($ip_details->ip_number) ? $ip_details->ip_number : '' !!} </span>
                                </td>
                                <td>
                                    <b>DOB:</b> <span>{!! isset($baby_details->DOB) ?  date('d-m-Y',strtotime($baby_details->DOB)) : '' !!}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Sex:</b> <span>{!! isset($baby_details->Sex) ? $baby_details->Sex : '' !!}</span>
                                </td>
                                <td>
                                    <b>Gestation:</b> <span>{!! isset($baby_details->Gestation) ?  SiteHelpers::decode_gestation($baby_details->Gestation) : '' !!}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Corrected Gestational Age:</b> <span>{!! isset($corrected_gestation) ? $corrected_gestation : '' !!}</span>
                                </td>
                                <td>
                                    <b>Birth Weight:</b> <span>{!! isset($baby_details->BirthWeight) ? $baby_details->BirthWeight : '' !!}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @if (isset($user_role) && ($user_role == env('SUPER_ADMIN_ROLE') || $user_role == env('ADMIN_ROLE')))
                <div class="col-md-12 action-btn">
                    <a href="javascript:void(0);" data-patient-baby-id="{{ $baby_id }}" data-patient-admission-id="{{ $admission_id }}" data-patient-bed-id="{{ $bed_id }}" class="btn btn-success save-button-shadow mtb-5 create-drug"><b><i class="fas fa-file-prescription"></i>&nbsp;Prescribe</b></a>&nbsp;
                    <button type="button" class="btn btn-primary save-button-shadow drug-fluids-masters mtb-5"><i class="fas fa-briefcase-medical" style="font-size: 11px"></i>&nbsp;Medicine</button>&nbsp;
                    <button type="button" class="btn btn-primary save-button-shadow frequency-masters mtb-5"><i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;Frequency</button>&nbsp;
                </div>
                @endif
            </div>
            <div class="col-md-8 col-sm-7 col-xs-12 pr-0">
                <div class="col-md-12 baby-entry">
                    <div class="col-md-6 plr-0">
                        <div class="col-md-12 plr-0 form-group">
                            <div class="col-md-6 plr-0 mt-5 text-wrap-none-res">
                                {!! Form::label('working_wgt','Working Weight: ', ['style'=>'font-weight: bold;']) !!} <span class="required-label">(in grams)</span>
                            </div>
                            <div class="col-md-6 plr-0">
                                {!! Form::text('working_wgt',@$working_weight,['class'=>'form-control input-fields-shadow input-width-medium working_weight', 'onkeypress'=>'return isNumber(event, this);']) !!}                
                                <span class="working_wgt error-message display-none">Weight must be in 3 digits</span>
                            </div>
                        </div>
                        <div class="col-md-12 plr-0 form-group">
                            <div class="col-md-6 plr-0 mt-5">
                                {!! Form::label('allegries', 'Allegries:', ['style'=>'font-weight: bold;']) !!}
                            </div>
                            <div class="col-md-6 plr-0">
                                {!! Form::textarea('allegries', @$baby_details->allegries, ['class'=>'form-control input-width-medium input-fields-shadow', 'rows'=>2, 'cols'=>15]) !!}                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 date-selection plr-0">             
                        @if(env('PUMP_INTERFACE'))
                        @if ($user_role == env('SUPER_ADMIN_ROLE') || $user_role == env('ADMIN_ROLE'))
                        @if(count($syringe_pump) > 0 && ($syringe_pump->admission_stauts == 0 || $syringe_pump->admission_stauts == 1 || $syringe_pump->admission_stauts== 3))
                            <a href="javascript:void(0);" data-patient-baby-id="{{ $baby_id }}" data-patient-admission-id="{{ $admission_id }}" data-patient-bed-id="{{ $bed_id }}" class="btn btn-primary save-button-shadow discharge-patient order-btn pull-right">Disconnect Pump</a>&nbsp;
                            <span class="pull-right plr-15"><b>Bed No. {{$bed_no}}</b></span>
                            <span class="pull-right"><b>Room No. {{$room_no}}</b></span>
                        @else
                        <a href="javascript:void(0);" data-patient-baby-id="{{ $baby_id }}" data-patient-admission-id="{{ $admission_id }}" data-patient-bed-id="{{ $bed_id }}" class="btn btn-primary save-button-shadow connect-patient order-btn pull-right">Connect Pump</a>&nbsp;
                        @endif
                        @else
                        <a href="javascript:void(0);" data-patient-baby-id="{{ $baby_id }}" data-patient-admission-id="{{ $admission_id }}" data-patient-bed-id="{{ $bed_id }}" class="btn btn-primary save-button-shadow connect-patient order-btn pull-right">Connect Pump</a>&nbsp;
                        @endif
                        @endif
                        <div class="date-sub-div pull-right">
                            <div class="pull-left pl-15 mtb-5">
                                <div class="pull-left mt-5 pr-5">{!! Form::label('fromdate', 'From:') !!}</div>
                                <div class="pull-left pl-0">{!! Form::hidden('admission_date', @$ip_details->DateAdded) !!} {!! Form::text('fromdate', null, ['class'=>'form-control input-fields-shadow','readonly']) !!}</div>
                            </div>
                            <div class="pull-left pl-15 mtb-5">
                                <div class="pull-left mt-5 pr-5">{!! Form::label('todate', 'To:') !!}</div>
                                <div class="pull-left plr-0">{!! Form::text('todate', null, ['class'=>'form-control input-fields-shadow','readonly']) !!}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 plr-0" style="display: flex; align-items: center;">
                    <div class="col-md-11 pr-0">    
                        <a href="javascript:void(0);" class="btn btn-success save-button-shadow send-to-pump order-btn action-btn"><b><i class="fa fa-play" aria-hidden="true">&nbsp;@php echo $start @endphp <span class="order-span">Order</span></i></b></a>
                        <a href="javascript:void(0);" class="btn btn-success save-button-shadow resend-prescription order-btn action-btn" data-resend-id="0"><b><i class="fa fa-play" aria-hidden="true">&nbsp;Send <span class="order-span">Order</span></i></b></a>
                        &nbsp;<a href="javascript:void(0);" class="btn btn-warning save-button-shadow stop-order order-btn action-btn"><b><i class="fa fa-stop" aria-hidden="true">&nbsp;Stop Selected <span class="order-span">Order</span></i></b></a>&nbsp;
                        <a href="javascript:void(0);" class="btn btn-danger save-button-shadow cancel-order order-btn action-btn"><b><i class="fa fa-times" aria-hidden="true">&nbsp;Cancel / Omit Selected <span class="order-span">Order</span></i></b></a>&nbsp;
                    </div>
                    <div class="col-md-2 plr-0">
                        @if(isset($closelink) && !empty($closelink)) 
                        <a href="{{ url($closelink) }}" class="btn btn-danger save-button-shadow pull-right" style="margin: 4px 6px 0px 6px !important;padding: 6px 7px;">
                            <i class="fa fa-times fa-lg"></i>
                        </a>
                        @endif
                        <button class="btn btn-primary save-button-shadow master-icons prescription-print bs-tooltip pull-right" data-baby-id={{\SiteHelpers::encrypt_id($baby_id)}} data-admission-id={{\SiteHelpers::encrypt_id($admission_id)}} data-closewinlink="{{$closewinlink}}" data-selected-date="0" data-original-title="Print"><i class="fa fa-print fa-lg"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="prescription-content-ipad">
        <div class="col-md-12 plr-0" style="display: flex; align-items: center;">
            <div class="col-md-6 col-sm-6 plr-0 mt-5">
                <div class="col-md-6 col-sm-6 plr-0 form-group">
                    {!! Form::label('working_wgt','Working') !!} Wgt :<span class="required-label"> (gms)</span>
                    {!! Form::text('working_wgt',@$working_weight,['class'=>'form-control input-fields-shadow input-width-medium working_weight']) !!}                
                    <span class="working_wgt error display-none">Weight must be in 4 digits</span>
                </div>
                <div class="col-md-6 col-sm-6 plr-0 form-group">
                    {!! Form::label('allegries', 'Allegries: ') !!}<br>
                    {!! Form::textarea('allegries', @$baby_details->allegries, ['class'=>'form-control input-width-medium input-fields-shadow', 'rows'=>1, 'cols'=>20]) !!}                
                </div>
            </div>
            <div class="col-md-6 col-sm-6 date-selection plr-0">
                <div class="col-md-8 col-sm-8 plr-0">
                    <div class="pull-left">
                        {!! Form::label('fromdate', 'From:') !!}<br>
                        {!! Form::text('fromdateipad', null, ['class'=>'form-control input-fields-shadow input-width-small','readonly']) !!}
                    </div>
                    <div class="pull-left pl-15">
                        {!! Form::label('todate', 'To:') !!}<br>
                        {!! Form::text('todateipad', null, ['class'=>'form-control input-fields-shadow input-width-small','readonly']) !!}
                    </div>
                    <div class="date-selection-error"></div>
                </div>
                <div class="pull-right col-md-4 col-sm-4 plr-0">
                    <br>
                    @if(env('PUMP_INTERFACE'))
                    @if ($user_role == env('SUPER_ADMIN_ROLE') || $user_role == env('ADMIN_ROLE'))
                    @if(count($syringe_pump) > 0 && ($syringe_pump->admission_stauts == 0 || $syringe_pump->admission_stauts == 1 || $syringe_pump->admission_stauts== 3))
                    <a href="javascript:void(0);" data-patient-baby-id="{{ $baby_id }}" data-patient-admission-id="{{ $admission_id }}" data-patient-bed-id="{{ $bed_id }}" class="btn btn-primary discharge-patient order-btn pull-right mr-5">Disconnect</a>&nbsp;
                    @else
                    <a href="javascript:void(0);" data-patient-baby-id="{{ $baby_id }}" data-patient-admission-id="{{ $admission_id }}" data-patient-bed-id="{{ $bed_id }}" class="btn btn-primary connect-patient order-btn pull-right mr-5">Connect</a>&nbsp;
                    @endif
                    @else
                    <a href="javascript:void(0);" data-patient-baby-id="{{ $baby_id }}" data-patient-admission-id="{{ $admission_id }}" data-patient-bed-id="{{ $bed_id }}" class="btn btn-primary connect-patient order-btn pull-right mr-5">Connect</a>&nbsp;
                    @endif
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 order action-btn plr-must-0">
            @if (isset($user_role) && ($user_role == env('SUPER_ADMIN_ROLE') || $user_role == env('ADMIN_ROLE')))
            <a href="javascript:void(0);" data-patient-baby-id="{{ $baby_id }}" data-patient-admission-id="{{ $admission_id }}" data-patient-bed-id="{{ $bed_id }}" class="btn btn-success save-button-shadow mb-5 create-drug"><b><i class="fas fa-file-prescription"></i>&nbsp;Prescribe</b></a>&nbsp;
            @endif
            <a href="javascript:void(0);" class="btn btn-danger cancel-order order-btn pull-right mr-5 mt-0"><i class="fa fa-times" aria-hidden="true">&nbsp;Cancel / Omit</i></a>&nbsp;                    
            <a href="javascript:void(0);" class="btn btn-warning stop-order order-btn pull-right mr-5"><i class="fa fa-stop" aria-hidden="true">&nbsp;Stop</i></a>&nbsp;
            <a href="javascript:void(0);" class="btn btn-success send-to-pump order-btn pull-right mr-5"><i class="fa fa-play" aria-hidden="true">&nbsp;@php echo $start @endphp</i></a>&nbsp;
            <a href="javascript:void(0);" class="btn btn-success resend-prescription order-btn pull-right mr-5" data-resend-id="0"><b><i class="fa fa-play" aria-hidden="true">&nbsp;Send</i></b></a>&nbsp;
        </div>
    </div>
    <div class="col-md-12 col-sm-12 plr-0" id="prescription-data-list"></div>
</div>
@include('prescription.prescription_master') 
@endsection 
@include('prescription.prescription_script')
