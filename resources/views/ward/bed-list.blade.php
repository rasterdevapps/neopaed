@php
$site_url = url('/').'/public';
$role_id = Auth::user()->RoleId;
@endphp
<div class="search-box">
    <button class="btn-search button-search-input" style="font-size: 18px !important;"><i class="fas fa-search"></i></button>
    <input type="text" class="input-search" id="search_input_text_field" placeholder="Search using {{ Lang::get('home.mrn') }}...">
</div>
<div role="tabpanel" class="tabbable tabbable-custom">
    <ul class="nav nav-tabs" role="tablist">
        @php $i =0; @endphp
        @foreach($ward_list as $ward_details)
        <li role="{{ $ward_details->ward_name }}" @if($i == 0) class="active" @endif>
            <a href="#{{ $ward_details->ward_name }}" @if($i == 0) class="active" @endif aria-controls="{{ $ward_details->ward_name }}" role="tab" data-toggle="tab">{{ $ward_details->ward_name }}</a>
        </li>
        @php $i++; @endphp
        @endforeach
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        @php 
        $i =0; 
        $bed_details = [];
        @endphp
        <div role="tabpanel" class="tab-pane" id="search_results_mrn" style="min-height: 200px;">
        </div>
        @foreach($ward_list as $ward_details)
        <div role="tabpanel" class="tab-pane @if($i == 0) active @endif" id="{{ $ward_details->ward_name }}">
            <div class="col-md-12 col-sm-12 px-0">
                <div class="row mx-0 tab-content-row">
                    @php 
                    $sub_room_list = collect($ward)
                    ->where('ward_id', $ward_details->ward_id)
                    ->sortBy('bed_id')
                    ->unique('room_id')
                    ->toArray();
                    @endphp
                    <div class="pull-right room_filter_container d-inline">
                        @if(count($sub_room_list) > 0)
                        <ul class="nav navbar-nav">
                            <li class="dropdown" title="Profile">
                                <a href="#" class="dropdown-toggle hover-fx" data-toggle="dropdown" title="Room Filter" style="padding: 6px 5px;margin-top: 11px !important;color: #1e1e2d;font-size: 20px;">
                                    <i class="fas fa-filter"></i>
                                </a> 
                                <ul class="dropdown-menu" style="background-color: #fbf6f9 !important;">
                                    @foreach($sub_room_list as $room_key => $room_value)
                                    <li>
                                        <button type="button" class="btn btn-primary btn-circle room_filter_option" value="{{ $room_value->ward_id.$room_value->room_id }}" data-ward_id="{{ $room_value->ward_id }}">{{ $room_value->room_name }}</button>
                                    </li>
                                    @endforeach
                                    <li>
                                        <button type="button" class="btn btn-primary btn-circle room_filter_option" value="All" data-ward_id="All">All</button>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        @endif
                    </div>
                    @foreach($sub_room_list as $room)
                    <div class="row room-parent room-parent-{{ $room_value->ward_id }} room_filter_id_{{$room->ward_id.$room->room_id}} px-0">
                        <h5 class="text-center col-xs-12 room_number_header"> Room Name/Number : <strong>{{ $room->room_name }}</strong></h5>
                        @php 
                        $bed_list = collect($ward)
                        ->where('room_id',$room->room_id)
                        ->where('ward_id',$ward_details->ward_id)
                        ->sortBy('bed_name')
                        ->toArray();  
                        @endphp

                        @foreach($bed_list as $bed)
                        @php 
                        $admitted_baby = $baby
                        ->where('bed_id', $bed->bed_id)
                        ->where('status','Occupied')
                        ->last(); 
                        $baby_details_available = (count($admitted_baby) > 0) ? 'baby-details' : 'no-baby-details'; 
                        $bed_details[$bed->bed_id] = isset($admitted_baby->baby_id) ? $admitted_baby->baby_id : null;
                        @endphp 
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 bed-manager @if(isset($admitted_baby->Sex) && ($admitted_baby->Sex == 'Male' || $admitted_baby->Sex == 'MALE')) male_baby @elseif(isset($admitted_baby->Sex) && ($admitted_baby->Sex == 'Female' || $admitted_baby->Sex == 'FEMALE')) female_baby @endif bed-managerr px-0" id="bed-layout-{{ $bed->bed_id }}">
                            <div class="card-pf card-pf-view card-pf-view-select card-pf-view-single-select">
                                <span class="badge badge-success ward-names">{{ $ward_details->ward_name }}</span>
                                <span class="badge badge-primary">{{ $bed->bed_name }}</span>
                                @php 
                                $mrn = isset($admitted_baby->BMrNo) ? $admitted_baby->BMrNo : null ; 
                                // echo \SiteHelpers::menuList($mrn, 'ward');
                                @endphp
                                @if($mrn != null && $mrn != '')
                                <ul class="nav navbar-nav pull-right nicu-ward-menu" data-mrn="{{ $mrn }}">

                                </ul>
                                @endif

                                <div class="card-pf-body" style="height: 283px;">
                                    <div class="card-pf-top-element" data-bed-name="{{ $bed->bed_name}}" data-ward-id="{{ $bed->ward_id }}" data-room-id="{{ $bed->room_id }}" data-bed-id="{{ $bed->bed_id }}">

                                        <span class="card-pf-icon-circle bed-frame" id="bed-frame-{{ $bed->bed_id }}">
                                            @if(isset($admitted_baby->Sex) && ($admitted_baby->Sex == 'Male' || $admitted_baby->Sex == 'MALE')) 
                                            <img src="{{ url('/') }}/public/img/icons/baby-boy.png" alt="Male Baby" id="bed-manangement-{{ $bed->bed_id }}" data-bed-name="{{ $bed->bed_name }}" data-ward-id="{{ $bed->ward_id }}" data-room-id="{{ $bed->room_id }}" data-bed-id="{{ $bed->bed_id }}" data-room-name="{{ $bed->room_name }}" data-hms-ward-id="{{ $bed->hms_ward_id }}" data-hms-room-id="{{ $bed->hms_room_id }}" data-hms-bed-id="{{ $bed->hms_bed_id }}" class="baby-warmer-icons bed-transfer" /> 

                                            @elseif(isset($admitted_baby->Sex) && ($admitted_baby->Sex == 'Female' || $admitted_baby->Sex == 'FEMALE')) 
                                            <img src="{{ url('/') }}/public/img/icons/baby-girl.png" alt="Female Baby"  id="bed-manangement-{{ $bed->bed_id }}" data-bed-name="{{ $bed->bed_name }}" data-ward-id="{{ $bed->ward_id }}" data-room-id="{{ $bed->room_id }}" data-bed-id="{{ $bed->bed_id }}" data-room-name="{{ $bed->room_name }}" data-hms-ward-id="{{ $bed->hms_ward_id }}" data-hms-room-id="{{ $bed->hms_room_id }}" data-hms-bed-id="{{ $bed->hms_bed_id }}" class="baby-warmer-icons bed-transfer" />

                                            @elseif(!isset($admitted_baby->baby_id))
                                            <img src="{{ url('/') }}/public/img/icons/ward-icon.png" alt="Ward Icon" width="40" height="40" class="baby-warmer-icons bed-transfer-restricted" data-bed-name="{{ $bed->bed_name }}" data-ward-id="{{ $bed->ward_id }}" data-room-id="{{ $bed->room_id }}" data-bed-id="{{ $bed->bed_id }}" data-room-name="{{ $bed->room_name }}" data-hms-ward-id="{{ $bed->hms_ward_id }}" data-hms-room-id="{{ $bed->hms_room_id }}" data-hms-bed-id="{{ $bed->hms_bed_id }}" class="baby-warmer-icons bed-transfer" id="bed-manangement-{{ $bed->bed_id }}" width="40" height="40" />
                                            @endif
                                        </span>
                                    </div>
                                    <div class="bed-details-text-{{ $bed->bed_id }}">
                                        @if(isset($admitted_baby->baby_id) && !empty($admitted_baby->baby_id) && isset($admitted_baby->admission_id))
                                        <h2 class="card-pf-title text-center details" data-baby-id="{{ $admitted_baby->baby_id }}" data-admission-id="{{ $admitted_baby->admission_id }}">
                                            @if(isset($admitted_baby->BMrNo))
                                            @if(!is_null($admitted_baby->BMrNo)) 
                                            {{ $admitted_baby->BMrNo }}
                                            @endif
                                            @endif
                                        </h2>
                                        @php

                                        $moniter_active = (isset($monitor_status[$admitted_baby->admission_id])) ? 'text-success' : 'text-normal';
                                        
                                        $ventilator_active = (isset($ventilator_status[$admitted_baby->admission_id])) ? 'text-success' : 'text-normal';
                                        
                                        $pumb_active = (isset($pump_admission_status[$admitted_baby->admission_id]) && ($pump_admission_status[$admitted_baby->admission_id] == '0' || $pump_admission_status[$admitted_baby->admission_id] == '1')) ? 'text-success' : 'text-normal';
                                        
                                        $infusion_status = (isset($pump_running_status[$admitted_baby->admission_id])) ? 'text-success' : 'hide';
                                        
                                        @endphp
                                        <div class="card-pf-items text-center baby-container-{{ $admitted_baby->baby_id }}">
                                            <div class="card-pf-item bs-tooltip" data-title="Monitor">
                                                <a href="{{ url('list-monitor-values/').'/'.SiteHelpers::encrypt_id($admitted_baby->baby_id).'/'.SiteHelpers::encrypt_id($admitted_baby->admission_id) }}">
                                                    <span class="fas fa-pager {{ $moniter_active }}"></span>
                                                </a>
                                                <span class="card-pf-item-text"></span>
                                            </div>
                                            <div class="card-pf-item bs-tooltip" data-title="Ventilator">
                                                <a href="{{ url('list-vendilator-values/').'/'.SiteHelpers::encrypt_id($admitted_baby->baby_id).'/'.SiteHelpers::encrypt_id($admitted_baby->admission_id) }}">
                                                    <span class="fas fa-lungs {{ $ventilator_active }}"></span>
                                                </a>
                                                <span class="card-pf-item-text"></span>
                                            </div>
                                            <div class="card-pf-item bs-tooltip" data-title="Pump Connection Status">
                                                <a href="{{ url('list-infusion-values/').'/'.SiteHelpers::encrypt_id($admitted_baby->baby_id).'/'.SiteHelpers::encrypt_id($admitted_baby->admission_id) }}">
                                                    <span class="fas fa-syringe {{ $pumb_active }}"></span>
                                                </a>
                                            </div>
                                            <div class="card-pf-item bs-tooltip {{ $infusion_status }} pump-status-block" data-title="Pump Execution Status">
                                                <a>
                                                    <div id="arrowAnim">
                                                        <div class="arrowSliding">
                                                            <div class="arrow"></div>
                                                        </div>
                                                        <div class="arrowSliding delay1">
                                                            <div class="arrow"></div>
                                                        </div>
                                                        <div class="arrowSliding delay2">
                                                            <div class="arrow"></div>
                                                        </div>
                                                        <div class="arrowSliding delay3">
                                                            <div class="arrow"></div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <p class="card-pf-info text-center text-captialize"> 
                                            @if(isset($admitted_baby->BabyName))
                                            @if(stripos($admitted_baby->BabyName, "UNKNOWN") !== false)
                                            <span class="text-danger call-hms" title="Get data from HMS" data-mrn="{{$admitted_baby->BMrNo}}">{{ $admitted_baby->BabyName}} <i class="fa fa-refresh"></i></span>
                                            @else
                                            <span>{{ $admitted_baby->BabyName}}</span>
                                            @endif
                                            @endif
                                        </p>
                                            @if(isset($admitted_baby->DOB))
                                            @if(!is_null($admitted_baby->DOB)) 
                                        <p class="card-pf-info text-center dob-span"><strong>DOB : </strong> 
                                            <span>{{ date('d-m-Y',strtotime($admitted_baby->DOB)) }}</span>
                                        </p>
                                            @endif
                                            @endif
                                        <p class="card-pf-info text-center"><strong>{{ Lang::get('home.ip') }} : </strong> 
                                            @if(isset($admitted_baby->ip_number))
                                            @if(!is_null($admitted_baby->ip_number)) 
                                            <span>{{ $admitted_baby->ip_number }}</span>
                                            @endif
                                            @endif
                                        </p>
                                        @else
                                        <h2 class="card-pf-title text-center">
                                            <a href="javascript:void(0)" class="btn btn-success add-patient" data-add-ward-id="{{ $bed->ward_id }}" data-add-room-id="{{ $bed->room_id }}" data-add-ward-name="{{ $bed->ward_name }}" data-add-room-name="{{ $bed->room_name }}" data-add-bed-id="{{ $bed->bed_id }}" data-add-bed-name="{{ $bed->bed_name }}" data-hms-ward-id="{{ $bed->hms_ward_id }}" data-hms-room-id="{{ $bed->hms_room_id }}" data-hms-bed-id="{{ $bed->hms_bed_id }}">
                                                Admit Baby
                                            </a>
                                        </h2>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <hr>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @php $i++; @endphp
        @endforeach
        {!! Form::hidden('bed_details', json_encode($bed_details)) !!}
        {!! Form::hidden('room_list', json_encode($ward)) !!}
    </div>
</div>
<script type="text/javascript">


    var pusher_app_key = '{{ env("PUSHER_APP_KEY") }}';
    var pusher_cluster = '{{ env("PUSHER_CLUSTER") }}';

    $(document).on('click', '.btn-edit-baby', function() {
        var mother_mrn = $(this).data('mother_mrn');
        var baby_mrn = $(this).data('baby_mrn');
        var baby_ward = $(this).data('ward');
        var baby_room = $(this).data('room');
        var baby_bed = $(this).data('bed');
        var ip_number = $(this).data('ip_number');
        if (ip_number == '' || ip_number == null) {
            ip_number = 'IP/';
        }
        var baby_id = $(this).data('baby_id_nurse');
        $.cookie("motherMrn", mother_mrn);
        $.cookie("babyMrn", baby_mrn);
        $.cookie("babyCurrentWard", baby_ward);
        $.cookie("babyCurrentRoom", baby_room);
        $.cookie("babyCurrentBed", baby_bed);
        $.cookie("babyIpNumber", ip_number);
        $.cookie("babyNurseUpdate", baby_id);
        return true;
    });
    $(document).on('click', '.create-neonatal', function() {
        var mother_mrn = $(this).data('mother_mrn');
        var baby_mrn = $(this).data('baby_mrn');
        var baby_ward = $(this).data('ward');
        var baby_room = $(this).data('room');
        var baby_bed = $(this).data('bed');
        var ip_number = $(this).data('ip_number');
        if (ip_number == '' || ip_number == null) {
            ip_number = 'IP/';
        }
        var baby_id = $(this).data('baby_id_nurse');
        $.cookie("motherMrn", mother_mrn);
        $.cookie("babyMrn", baby_mrn);
        $.cookie("babyCurrentWard", baby_ward);
        $.cookie("babyCurrentRoom", baby_room);
        $.cookie("babyCurrentBed", baby_bed);
        $.cookie("babyIpNumber", ip_number);
        $.cookie("babyNurseUpdate", baby_id);
        return true;
    });
    $('.chart-display-view > a').click(function() {
        if ($(".chart-display-view > a > i").hasClass("fa-angle-down")) {
            $(".chart-display-view > a > i").removeClass("fa-angle-down");
            $(".chart-display-view > a > i").addClass("fa-angle-up");
            $(".dropdown-menu-chart").css("display", "block");
        } else {
            $(".chart-display-view > a > i").removeClass("fa-angle-up");
            $(".chart-display-view > a > i").addClass("fa-angle-down");
            $(".dropdown-menu-chart").css("display", "none");
        }
        return false;
    });
    $(".chart-display-view").on("mouseover", function() {
        $(".dropdown-menu-chart").css("display", "block");
        $(".chart-display-view > a > i").removeClass("fa-angle-down");
        $(".chart-display-view > a > i").addClass("fa-angle-up");
    });
    $(".chart-display-view").on("mouseleave", function() {
        $(".dropdown-menu-chart").css("display", "none");
        $(".chart-display-view > a > i").removeClass("fa-angle-up");
        $(".chart-display-view > a > i").addClass("fa-angle-down");
    });

    var request_url_is_busy = false;

    setInterval(function() {
        if (!request_url_is_busy) {
            request_url_is_busy = true;
            // updateWardView();
        }
    }, 10000);

    function updateWardView() {

        var bed_details = $('input[name="bed_details"]').val();
        var room_list = $('input[name="room_list"]').val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            data: {
                bed_details: bed_details,
                room_list: room_list,
            },
            url: "{{ action('Ward\BabyWardController@updateView') }}",
            success: function(response) {
                var detail_content = response.detail_content;
                var infusion_status = response.infusion_status;
                $.each(detail_content, function(key, value) {
                    var baby_info = key.split(':');
                    var bed_id = baby_info[0];
                    var gender = baby_info[1];

                    if (typeof gender != 'undefined') {
                        $('#bed-layout-'+bed_id).removeClass('female_baby').removeClass('male_baby').addClass(gender).html(value);
                    } else {
                        $('#bed-layout-'+bed_id).removeClass('female_baby').removeClass('male_baby').html(value);                        
                    }

                });
                $('.pump-status-block').addClass('hide');
                if (infusion_status.length > 0) {
                    $.each(infusion_status, function(key, value) {
                        var baby_id = value;
                        $('.baby-container-'+baby_id+' .card-pf-item').eq(3).removeClass('hide');
                    });
                }
                $('input[name="bed_details"]').val(response.bed_details);
                $('input[name="room_list"]').val(response.ward);
                if (!$('#discharge-details-nav').is(':visible')) {
                    $('#transfer-option #bed_no').html(response.bed_list_content);
                }
            }, 
            complete: function() {
                request_url_is_busy = false;
            }
        });
    }
</script>
