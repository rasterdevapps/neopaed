<?php $__env->startSection('content'); ?>
<?php 
$permission = session('menu_permission');
$specialPermission = \Session::get('specialPermissions');
$permissions=session('menu_permission');
$read_permission = session('read_permission');
$write_permission = session('write_permission');
?>
<style type="text/css">
    .widget-content.no-padding table
    {
        text-align: left; 
    }
</style>
<?php if(!isset($_GET['seperate']) || (isset($_GET['seperate']) && !$_GET['seperate'])): ?>
<div class="row row-spacing">
    <div class="page-header">
        <?php if(in_array('NICU_FORM',$write_permission) || in_array('POST_FORM',$write_permission) || in_array('OP_REG',$write_permission)): ?>                                
            <div class="col-md-3 col-sm-4">
                <a href="javascript:void(0);" id="new-patinent-home" class="btn btn-primary input-block-level homepage-banner">
                    <i class="fa fa-plus fa-2x"></i>
                    <div><?php echo e(Lang::get('menu.card_admission_registration'), false); ?></div>
                </a>
            </div>
        <?php endif; ?>
        <?php if(in_array('NICU_DAY',$write_permission) || in_array('POST_DAY',$write_permission)): ?>                                
            <div class="col-md-3 col-sm-4">
                <a href="javascript:void(0);" id="daily-care-home" class="btn btn-info input-block-level homepage-banner">
                    <i class="fas fa-notes-medical fa-2x"></i>
                    <div><?php echo e(Lang::get('menu.card_daily_entry'), false); ?></div>
                </a>
            </div>
        <?php endif; ?>
        <?php if(in_array('NICU_MODULE_SHEET',$write_permission)): ?>                                
        <div class="col-md-3 col-sm-4">
            <a href="javascript:void(0);" id="nurse-by-registration" class="btn btn-info input-block-level homepage-banner">
                <i class="fas fa-user-nurse fa-2x"></i>
                <div><?php echo e(Lang::get('menu.card_registartion_by_nurse'), false); ?></div>
            </a>
        </div>
        <?php endif; ?>
        <?php if(in_array('NICU_NURSE_DAY',$write_permission)): ?>                                
            <div class="col-md-3 col-sm-4">
                <a href="<?php echo e(action('Nurse\NicuNurseDaycareController@create'), false); ?>" id="nurse-daily-care-home" class="btn btn-info input-block-level homepage-banner">
                    <i class="fas fa-user-nurse fa-2x"></i>
                    <div> <?php echo e(Lang::get('menu.card_nurse_daily_entry'), false); ?></div>
                </a>
            </div>
        <?php endif; ?>
        <!-- <div class="clearfix"></div> -->
        <!-- Flow Control -->
        <?php if(in_array('NICU_MODULE_SHEET',$write_permission)): ?>                                
            <?php if(env('MONITOR_INTERFACE') || env('VENTILATOR_MACHINE') || env('LAB_INTERFACE')): ?>
                <div class="col-md-3 col-sm-4">
                    <a href="<?php echo e(action('Nurse\NurseSheetController@create'), false); ?>"  class="btn btn-alert input-block-level homepage-banner" id="nurse-hour-wise">
                        <i class="fas fa-user-nurse fa-2x"></i>
                        <div><?php echo e(Lang::get('menu.card_nurse_hour_wise'), false); ?></div>
                    </a>
                </div>
            <?php else: ?>
                <div class="col-md-3 col-sm-4">
                    <a href="<?php echo e(action('NurseManual\NurseManualController@create'), false); ?>"  class="btn btn-alert input-block-level homepage-banner" id="nurse-hour-wise">
                        <i class="fas fa-user-nurse fa-2x"></i>
                        <div><?php echo e(Lang::get('menu.card_nurse_hour_wise'), false); ?></div>
                    </a>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        <?php if(in_array('NICU_DISCHARGE',$write_permission) || in_array('POST_DISCHARGE',$write_permission)): ?>                                
            <div class="col-md-3 col-sm-4">
                <a href="javascript:void(0);" id="discharge-home" class="btn btn-alert input-block-level homepage-banner">
                    <i class="fas fa-clinic-medical fa-2x"></i>
                    <div><?php echo e(Lang::get('menu.card_discharge_transfer'), false); ?></div>
                </a>
            </div>
        <?php endif; ?>
        <?php if(in_array('CALENDAR',$permission) || Auth::user()->id == env('CALENDAR_SEEN_BY_ID')): ?>                                
        <div class="col-md-3 col-sm-4">
            <a href="<?php echo e(action('HomeController@calendar'), false); ?>" class="btn btn-alert input-block-level homepage-banner" id="home-calendar">
                <i class="fa fa-calendar fa-2x"></i>
                <div><?php echo e(Lang::get('menu.card_home_calendar'), false); ?></div>
            </a>
        </div>
        <?php endif; ?>
        <!-- <div class="clearfix"></div> -->
        <!-- /Flow Control -->
        <!--=== Page Content ===-->
        <?php if(in_array('CALCULATOR',$permission)): ?>
            <div class="col-md-3 col-sm-4">
                <a href="<?php echo e(action('Calculators\BallardController@index'), false); ?>" class="btn btn-primary input-block-level homepage-banner" id="ballard-score">
                    <i class="fa fa-tachometer fa-2x"></i>
                    <div><?php echo e(Lang::get('menu.card_ballard_score'), false); ?></div>
                </a>
            </div>
            <div class="col-md-3 col-sm-4">
                <a href="<?php echo e(action('Calculators\GlucoseController@index'), false); ?>" class="btn btn-info input-block-level homepage-banner" id="glucose-rate">
                    <i class="fa fa-calculator fa-2x"></i>
                    <div><?php echo e(Lang::get('menu.card_glucose_rate'), false); ?></div>
                </a>
            </div>
            <div class="col-md-3 col-sm-4">
                <a href="<?php echo e(action('Calculators\AgeController@index'), false); ?>" class="btn btn-success input-block-level homepage-banner" id="age-calculator">
                    <i class="fas fa-weight fa-2x"></i>
                    <div><?php echo e(Lang::get('menu.card_age_calculator'), false); ?></div>
                </a>
            </div>
            <div class="col-md-3 col-sm-4">
                <a href="<?php echo e(action('Calculators\TpnCalculatorController@index'), false); ?>" class="btn btn-success input-block-level homepage-banner" id="tpn-calculator">
                    <i class="fas fa-balance-scale fa-2x"></i>
                    <div><?php echo e(Lang::get('menu.side_menu_tpn_calculator'), false); ?></div>
                </a>
            </div>
        <?php endif; ?>
        <?php if(is_array($permissions) && in_array('DELETE_ACCESS',$permissions)): ?>   
            <div class="col-md-3 col-sm-4">
                <a href="javascript:void(0);" class="btn btn-alert input-block-level homepage-banner" id="remove-record">
                    <i class="fa fa-eraser fa-2x"></i>
                    <div><?php echo e(Lang::get('menu.card_remove_record'), false); ?></div>
                </a>
            </div>
        <?php endif; ?>
        <?php if(is_array($permissions) && in_array('WARD_MANAGEMENT',$permissions)): ?>   
            <div class="col-md-3 col-sm-4">
                <a href="<?php echo e(action('Ward\BabyWardController@index'), false); ?>" class="btn btn-success input-block-level homepage-banner" id="ward-management">
                    <i class="fas fa-bed"></i>
                    <div><?php echo e(Lang::get('menu.card_ward_mangagement'), false); ?></div>
                </a>
            </div>
        <?php endif; ?>
        <?php if(is_array($permissions) && in_array('HERO',$permissions)): ?>   
        <div class="col-md-3 col-sm-4">
            <a href="javascript:void(0)" class="btn btn-success input-block-level homepage-banner side-nav-btn hero-btn" id="hero-score" onclick="openSideMenu('hero')">
                <img src="<?php echo e(url('public/bed-image/monitor-wave.png'), false); ?>" >
                <div>
                    <?php echo e(Lang::get('menu.card_hero'), false); ?>

                </div>
            </a>
            <a href="<?php echo e(action('Nurse\NurseSheetController@getHeroScore'), false); ?>" class="btn btn-default" id="hero-export-btn" title="Export"><i class="fa fa-download" aria-hidden="true"></i></a>
        </div>
        <?php endif; ?>
        <?php if(is_array($permissions) && in_array('NSOFA',$permissions)): ?>   
        <div class="col-md-3 col-sm-4">
            <a href="<?php echo e(action('Reports\NsofaController@index'), false); ?>" class="btn btn-success input-block-level homepage-banner side-nav-btn nsofa-btn" id="nsofa-score">
                <!-- <img src="<?php echo e(url('public/img/nsofa.png'), false); ?>" > -->
                <i class="fa fa-stethoscope" aria-hidden="true"></i>
                <div><?php echo e(Lang::get('menu.card_nsofa_score'), false); ?></div>
            </a>
        </div>
        <?php endif; ?>
        <?php if(is_array($permissions) && in_array('MSNS',$permissions)): ?>   
        <div class="col-md-3 col-sm-4">
            <a href="<?php echo e(action('Reports\MSNSController@index'), false); ?>" class="btn btn-success input-block-level homepage-banner side-nav-btn msns-btn" id="msns-score">
                <i class="fa fa-tasks" aria-hidden="true"></i>
                <div><?php echo e(Lang::get('menu.card_msns_score'), false); ?></div>
            </a>
        </div>
        <?php endif; ?>
        <?php if(is_array($permissions) && in_array('NICU_TIME_LINE',$read_permission)): ?>   
        <div class="col-md-3 col-sm-4">
            <a href="<?php echo e(action('HomeController@getNICUTimelinePage'), false); ?>" class="btn btn-success input-block-level homepage-banner" id="nicu-time-line">
                <i class="fas fa-history fa-2x"></i>
                <div><?php echo e(Lang::get('menu.card_nicu_time_line'), false); ?></div>
            </a>
        </div>
        <?php endif; ?>
        <?php if(is_array($permissions) && in_array('NUTRITION_CHART',$permissions)): ?>   
        <div class="col-md-3 col-sm-4">
            <a href="<?php echo e(action('Reports\NutritionChartController@index'), false); ?>" class="btn btn-success input-block-level homepage-banner side-nav-btn nutrition-btn" id="nutrition-score">
                <i class="fa fa-heartbeat" aria-hidden="true"></i>
                <div>
                    <?php echo e(Lang::get('menu.card_nutrition_chart'), false); ?>

                </div>
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php echo $__env->make('search.report', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>     
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">
    $('.fa-angle-down').click();
    
    $(".hover-fx").each(function() {   
        if (this.href == window.location.href) {
            $(this).addClass("active-menu");
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>