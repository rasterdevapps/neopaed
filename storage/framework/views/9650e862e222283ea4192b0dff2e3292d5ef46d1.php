<?php
$site_url = url('/').'/public';
$role_id = Auth::user()->RoleId;
?>
<div class="search-box">
    <button class="btn-search button-search-input" style="font-size: 18px !important;"><i class="fas fa-search"></i></button>
    <input type="text" class="input-search" id="search_input_text_field" placeholder="Search using <?php echo e(Lang::get('home.mrn'), false); ?>...">
</div>
<div role="tabpanel" class="tabbable tabbable-custom">
    <ul class="nav nav-tabs" role="tablist">
        <?php $i =0; ?>
        <?php $__currentLoopData = $ward_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ward_details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li role="<?php echo e($ward_details->ward_name, false); ?>" <?php if($i == 0): ?> class="active" <?php endif; ?>>
            <a href="#<?php echo e($ward_details->ward_name, false); ?>" <?php if($i == 0): ?> class="active" <?php endif; ?> aria-controls="<?php echo e($ward_details->ward_name, false); ?>" role="tab" data-toggle="tab"><?php echo e($ward_details->ward_name, false); ?></a>
        </li>
        <?php $i++; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <?php 
        $i =0; 
        $bed_details = [];
        ?>
        <div role="tabpanel" class="tab-pane" id="search_results_mrn" style="min-height: 200px;">
        </div>
        <?php $__currentLoopData = $ward_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ward_details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div role="tabpanel" class="tab-pane <?php if($i == 0): ?> active <?php endif; ?>" id="<?php echo e($ward_details->ward_name, false); ?>">
            <div class="col-md-12 col-sm-12 px-0">
                <div class="row mx-0 tab-content-row">
                    <?php 
                    $sub_room_list = collect($ward)
                    ->where('ward_id', $ward_details->ward_id)
                    ->sortBy('bed_id')
                    ->unique('room_id')
                    ->toArray();
                    ?>
                    <div class="pull-right room_filter_container d-inline">
                        <?php if(count($sub_room_list) > 0): ?>
                        <ul class="nav navbar-nav">
                            <li class="dropdown" title="Profile">
                                <a href="#" class="dropdown-toggle hover-fx" data-toggle="dropdown" title="Room Filter" style="padding: 6px 5px;margin-top: 11px !important;color: #1e1e2d;font-size: 20px;">
                                    <i class="fas fa-filter"></i>
                                </a> 
                                <ul class="dropdown-menu" style="background-color: #fbf6f9 !important;">
                                    <?php $__currentLoopData = $sub_room_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room_key => $room_value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <button type="button" class="btn btn-primary btn-circle room_filter_option" value="<?php echo e($room_value->ward_id.$room_value->room_id, false); ?>" data-ward_id="<?php echo e($room_value->ward_id, false); ?>"><?php echo e($room_value->room_name, false); ?></button>
                                    </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <button type="button" class="btn btn-primary btn-circle room_filter_option" value="All" data-ward_id="All">All</button>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <?php endif; ?>
                    </div>
                    <?php $__currentLoopData = $sub_room_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="row room-parent room-parent-<?php echo e($room_value->ward_id, false); ?> room_filter_id_<?php echo e($room->ward_id.$room->room_id, false); ?> px-0">
                        <h5 class="text-center col-xs-12 room_number_header"> Room Name/Number : <strong><?php echo e($room->room_name, false); ?></strong></h5>
                        <?php 
                        $bed_list = collect($ward)
                        ->where('room_id',$room->room_id)
                        ->where('ward_id',$ward_details->ward_id)
                        ->sortBy('bed_name')
                        ->toArray();  
                        ?>

                        <?php $__currentLoopData = $bed_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bed): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php 
                        $admitted_baby = $baby
                        ->where('bed_id', $bed->bed_id)
                        ->where('status','Occupied')
                        ->last(); 
                        $baby_details_available = (count($admitted_baby) > 0) ? 'baby-details' : 'no-baby-details'; 
                        $bed_details[$bed->bed_id] = isset($admitted_baby->baby_id) ? $admitted_baby->baby_id : null;
                        ?> 
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 bed-manager <?php if(isset($admitted_baby->Sex) && ($admitted_baby->Sex == 'Male' || $admitted_baby->Sex == 'MALE')): ?> male_baby <?php elseif(isset($admitted_baby->Sex) && ($admitted_baby->Sex == 'Female' || $admitted_baby->Sex == 'FEMALE')): ?> female_baby <?php endif; ?> bed-managerr px-0" id="bed-layout-<?php echo e($bed->bed_id, false); ?>">
                            <div class="card-pf card-pf-view card-pf-view-select card-pf-view-single-select">
                                <span class="badge badge-success ward-names"><?php echo e($ward_details->ward_name, false); ?></span>
                                <span class="badge badge-primary"><?php echo e($bed->bed_name, false); ?></span>
                                <?php 
                                $mrn = isset($admitted_baby->BMrNo) ? $admitted_baby->BMrNo : null ; 
                                // echo \SiteHelpers::menuList($mrn, 'ward');
                                ?>
                                <?php if($mrn != null && $mrn != ''): ?>
                                <ul class="nav navbar-nav pull-right nicu-ward-menu" data-mrn="<?php echo e($mrn, false); ?>">

                                </ul>
                                <?php endif; ?>

                                <div class="card-pf-body" style="height: 283px;">
                                    <div class="card-pf-top-element" data-bed-name="<?php echo e($bed->bed_name, false); ?>" data-ward-id="<?php echo e($bed->ward_id, false); ?>" data-room-id="<?php echo e($bed->room_id, false); ?>" data-bed-id="<?php echo e($bed->bed_id, false); ?>">

                                        <span class="card-pf-icon-circle bed-frame" id="bed-frame-<?php echo e($bed->bed_id, false); ?>">
                                            <?php if(isset($admitted_baby->Sex) && ($admitted_baby->Sex == 'Male' || $admitted_baby->Sex == 'MALE')): ?> 
                                            <img src="<?php echo e(url('/'), false); ?>/public/img/icons/baby-boy.png" alt="Male Baby" id="bed-manangement-<?php echo e($bed->bed_id, false); ?>" data-bed-name="<?php echo e($bed->bed_name, false); ?>" data-ward-id="<?php echo e($bed->ward_id, false); ?>" data-room-id="<?php echo e($bed->room_id, false); ?>" data-bed-id="<?php echo e($bed->bed_id, false); ?>" data-room-name="<?php echo e($bed->room_name, false); ?>" data-hms-ward-id="<?php echo e($bed->hms_ward_id, false); ?>" data-hms-room-id="<?php echo e($bed->hms_room_id, false); ?>" data-hms-bed-id="<?php echo e($bed->hms_bed_id, false); ?>" class="baby-warmer-icons bed-transfer" /> 

                                            <?php elseif(isset($admitted_baby->Sex) && ($admitted_baby->Sex == 'Female' || $admitted_baby->Sex == 'FEMALE')): ?> 
                                            <img src="<?php echo e(url('/'), false); ?>/public/img/icons/baby-girl.png" alt="Female Baby"  id="bed-manangement-<?php echo e($bed->bed_id, false); ?>" data-bed-name="<?php echo e($bed->bed_name, false); ?>" data-ward-id="<?php echo e($bed->ward_id, false); ?>" data-room-id="<?php echo e($bed->room_id, false); ?>" data-bed-id="<?php echo e($bed->bed_id, false); ?>" data-room-name="<?php echo e($bed->room_name, false); ?>" data-hms-ward-id="<?php echo e($bed->hms_ward_id, false); ?>" data-hms-room-id="<?php echo e($bed->hms_room_id, false); ?>" data-hms-bed-id="<?php echo e($bed->hms_bed_id, false); ?>" class="baby-warmer-icons bed-transfer" />

                                            <?php elseif(!isset($admitted_baby->baby_id)): ?>
                                            <img src="<?php echo e(url('/'), false); ?>/public/img/icons/ward-icon.png" alt="Ward Icon" width="40" height="40" class="baby-warmer-icons bed-transfer-restricted" data-bed-name="<?php echo e($bed->bed_name, false); ?>" data-ward-id="<?php echo e($bed->ward_id, false); ?>" data-room-id="<?php echo e($bed->room_id, false); ?>" data-bed-id="<?php echo e($bed->bed_id, false); ?>" data-room-name="<?php echo e($bed->room_name, false); ?>" data-hms-ward-id="<?php echo e($bed->hms_ward_id, false); ?>" data-hms-room-id="<?php echo e($bed->hms_room_id, false); ?>" data-hms-bed-id="<?php echo e($bed->hms_bed_id, false); ?>" class="baby-warmer-icons bed-transfer" id="bed-manangement-<?php echo e($bed->bed_id, false); ?>" width="40" height="40" />
                                            <?php endif; ?>
                                        </span>
                                    </div>
                                    <div class="bed-details-text-<?php echo e($bed->bed_id, false); ?>">
                                        <?php if(isset($admitted_baby->baby_id) && !empty($admitted_baby->baby_id) && isset($admitted_baby->admission_id)): ?>
                                        <h2 class="card-pf-title text-center details" data-baby-id="<?php echo e($admitted_baby->baby_id, false); ?>" data-admission-id="<?php echo e($admitted_baby->admission_id, false); ?>">
                                            <?php if(isset($admitted_baby->BMrNo)): ?>
                                            <?php if(!is_null($admitted_baby->BMrNo)): ?> 
                                            <?php echo e($admitted_baby->BMrNo, false); ?>

                                            <?php endif; ?>
                                            <?php endif; ?>
                                        </h2>
                                        <?php

                                        $moniter_active = (isset($monitor_status[$admitted_baby->admission_id])) ? 'text-success' : 'text-normal';
                                        
                                        $ventilator_active = (isset($ventilator_status[$admitted_baby->admission_id])) ? 'text-success' : 'text-normal';
                                        
                                        $pumb_active = (isset($pump_admission_status[$admitted_baby->admission_id]) && ($pump_admission_status[$admitted_baby->admission_id] == '0' || $pump_admission_status[$admitted_baby->admission_id] == '1')) ? 'text-success' : 'text-normal';
                                        
                                        $infusion_status = (isset($pump_running_status[$admitted_baby->admission_id])) ? 'text-success' : 'hide';
                                        
                                        ?>
                                        <div class="card-pf-items text-center baby-container-<?php echo e($admitted_baby->baby_id, false); ?>">
                                            <div class="card-pf-item bs-tooltip" data-title="Monitor">
                                                <a href="<?php echo e(url('list-monitor-values/').'/'.SiteHelpers::encrypt_id($admitted_baby->baby_id).'/'.SiteHelpers::encrypt_id($admitted_baby->admission_id), false); ?>">
                                                    <span class="fas fa-pager <?php echo e($moniter_active, false); ?>"></span>
                                                </a>
                                                <span class="card-pf-item-text"></span>
                                            </div>
                                            <div class="card-pf-item bs-tooltip" data-title="Ventilator">
                                                <a href="<?php echo e(url('list-vendilator-values/').'/'.SiteHelpers::encrypt_id($admitted_baby->baby_id).'/'.SiteHelpers::encrypt_id($admitted_baby->admission_id), false); ?>">
                                                    <span class="fas fa-lungs <?php echo e($ventilator_active, false); ?>"></span>
                                                </a>
                                                <span class="card-pf-item-text"></span>
                                            </div>
                                            <div class="card-pf-item bs-tooltip" data-title="Pump Connection Status">
                                                <a href="<?php echo e(url('list-infusion-values/').'/'.SiteHelpers::encrypt_id($admitted_baby->baby_id).'/'.SiteHelpers::encrypt_id($admitted_baby->admission_id), false); ?>">
                                                    <span class="fas fa-syringe <?php echo e($pumb_active, false); ?>"></span>
                                                </a>
                                            </div>
                                            <div class="card-pf-item bs-tooltip <?php echo e($infusion_status, false); ?> pump-status-block" data-title="Pump Execution Status">
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
                                            <?php if(isset($admitted_baby->BabyName)): ?>
                                            <?php if(stripos($admitted_baby->BabyName, "UNKNOWN") !== false): ?>
                                            <span class="text-danger call-hms" title="Get data from HMS" data-mrn="<?php echo e($admitted_baby->BMrNo, false); ?>"><?php echo e($admitted_baby->BabyName, false); ?> <i class="fa fa-refresh"></i></span>
                                            <?php else: ?>
                                            <span><?php echo e($admitted_baby->BabyName, false); ?></span>
                                            <?php endif; ?>
                                            <?php endif; ?>
                                        </p>
                                            <?php if(isset($admitted_baby->DOB)): ?>
                                            <?php if(!is_null($admitted_baby->DOB)): ?> 
                                        <p class="card-pf-info text-center dob-span"><strong>DOB : </strong> 
                                            <span><?php echo e(date('d-m-Y',strtotime($admitted_baby->DOB)), false); ?></span>
                                        </p>
                                            <?php endif; ?>
                                            <?php endif; ?>
                                        <p class="card-pf-info text-center"><strong><?php echo e(Lang::get('home.ip'), false); ?> : </strong> 
                                            <?php if(isset($admitted_baby->ip_number)): ?>
                                            <?php if(!is_null($admitted_baby->ip_number)): ?> 
                                            <span><?php echo e($admitted_baby->ip_number, false); ?></span>
                                            <?php endif; ?>
                                            <?php endif; ?>
                                        </p>
                                        <?php else: ?>
                                        <h2 class="card-pf-title text-center">
                                            <a href="javascript:void(0)" class="btn btn-success add-patient" data-add-ward-id="<?php echo e($bed->ward_id, false); ?>" data-add-room-id="<?php echo e($bed->room_id, false); ?>" data-add-ward-name="<?php echo e($bed->ward_name, false); ?>" data-add-room-name="<?php echo e($bed->room_name, false); ?>" data-add-bed-id="<?php echo e($bed->bed_id, false); ?>" data-add-bed-name="<?php echo e($bed->bed_name, false); ?>" data-hms-ward-id="<?php echo e($bed->hms_ward_id, false); ?>" data-hms-room-id="<?php echo e($bed->hms_room_id, false); ?>" data-hms-bed-id="<?php echo e($bed->hms_bed_id, false); ?>">
                                                Admit Baby
                                            </a>
                                        </h2>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <hr>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        <?php $i++; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php echo Form::hidden('bed_details', json_encode($bed_details)); ?>

        <?php echo Form::hidden('room_list', json_encode($ward)); ?>

    </div>
</div>
<script type="text/javascript">


    var pusher_app_key = '<?php echo e(env("PUSHER_APP_KEY"), false); ?>';
    var pusher_cluster = '<?php echo e(env("PUSHER_CLUSTER"), false); ?>';

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
            url: "<?php echo e(action('Ward\BabyWardController@updateView'), false); ?>",
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
