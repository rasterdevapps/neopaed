<?php $__env->startSection('content'); ?>
<?php
$site_url = url('/').'/public';
if(Session::has('nicuform')) {
    $_COOKIE['nicuform'] = Session::get('nicuform');
    Session::forget('nicuform');
}
$admission_menu = ['basicform', 'historyform', 'pregform', 'babyform', 'admissform', 'Proform', 'Cribform', 'Snapform', 'Diagform'];
$discharge_menu = ['dischargeform', 'Checkform'];

// if(isset($_COOKIE['nicuformedit']) && !empty($_COOKIE['nicuformedit'])) {
//     $active = 'basicform';

//     setcookie('nicuformedit', null, -1, '/');
//     Session::forget('slug-nav');
// }
// elseif(!Session::has('slug-nav') && isset($_COOKIE['nicuform']) && in_array($_COOKIE['nicuform'], $discharge_menu)) {
//     $active = 'basicform';
// } elseif(Session::has('slug-nav')&&  isset($_COOKIE['nicuform']) && in_array($_COOKIE['nicuform'], $admission_menu)) {  
//     $active = 'dischargeform';
// } elseif (isset($_COOKIE['nicuform'])) {
//     $active = $_COOKIE['nicuform'];
// } 
// // elseif(!Session::has('slug-nav')) {
//     // echo "basic3";
//     // $active = 'basicform';
// // } 
// else {
//     $active = 'dischargeform';
// }
    $active = 'basicform';
?>
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li>
            
            <a href="<?php echo e(url('/'), false); ?>"><i class="fa fa-home"></i></a>
        </li>
        <li class="">
            <a title="" href="<?php echo e(action('Admission\NicuController@index'), false); ?>">
                NICU Admission
            </a>  
        </li>
        <li class="">
            <a title="" href="<?php echo e(url('nicu-admission/sub-nicu-list/'.SiteHelpers::encrypt_id($results->BabyId)), false); ?>">
                Admission list
            </a>  
        </li>
        <li class="current">
            <a title="">Edit <?php if(isset($results->BabyName) && !empty($results->BabyName)): ?> For <?php echo e($results->BabyName, false); ?> <?php endif; ?> <?php if(isset($results->BMrNo) && !empty($results->BMrNo)): ?>  <?php echo e($results->BMrNo, false); ?>   <?php endif; ?></a>
        </li>
    </ul>
    <div class="pull-right">
        <?php 
        $mmrn = $results->BMrNo; 

        echo \SiteHelpers::menuList($mmrn, $results->AdmissionId, 'nicu_admission');
        ?>
    </div>
</div>

<!-- /Breadcrumbs line -->
<?php if(Session::has('_old_input')): ?>
<?php ValuelistHelpers::setOldinputs('nicu-admission') ?>
<?php endif; ?>
<div class="row row-spacing" id ="nicu-admission-form">
    <div class="col-md-12 nicu-edit">
        <?php echo Form::hidden('temp_gestation',@$temp_gestation); ?>

        <?php echo Form::model($results,['method' => 'PATCH','url' => action('Admission\NicuController@update',$results->NicuId),'id' => 'admissionProforma-form', 'class'=>'nicu-admission-form']); ?>

        <?php echo Form::hidden('visit_module_name','nicu_admission'); ?>

        <?php echo $__env->make('errors.list', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <!-- Nav tabs -->
        <div role="tabpanel" class="tabbable tabbable-custom">
            <ul class="nav nav-tabs" role="tablist">
                <?php if(!Session::has('slug-nav')): ?>
                <li role="presentation" <?php if($active == 'basicform'): ?> class="active" <?php endif; ?>>
                    <a href="#basicform" aria-controls="basicform" role="tab" data-toggle="tab">Basics</a>
                </li>
                <li role="presentation" <?php if($active == 'historyform'): ?> class="active" <?php endif; ?>>
                    <a href="#historyform" aria-controls="historyform" role="tab" data-toggle="tab">Medical History</a>
                </li>
                <li role="presentation" <?php if($active == 'pregform'): ?> class="active" <?php endif; ?>>
                    <a href="#pregform" aria-controls="pregform" role="tab" data-toggle="tab">Pregnancy</a>
                </li>
                <li role="presentation" <?php if($active == 'babyform'): ?> class="active" <?php endif; ?>>
                    <a href="#babyform" aria-controls="babyform" role="tab" data-toggle="tab">Baby Details</a>
                </li>
                <li role="presentation" <?php if($active == 'admissform'): ?> class="active" <?php endif; ?>>
                    <a href="#admissform" aria-controls="admissform" role="tab" data-toggle="tab">Admission Details</a>
                </li>
                <li role="presentation" <?php if($active == 'Proform'): ?>  class="active" <?php endif; ?>>
                    <a href="#Proform" aria-controls="Proform" role="tab" data-toggle="tab">Procedures</a>
                </li>
                <li role="presentation" <?php if($active == 'Cribform'): ?>  class="active"  <?php endif; ?>>
                    <a href="#Cribform" aria-controls="Cribform" role="tab" data-toggle="tab">CRIB II</a>
                </li>
                <li role="presentation" <?php if($active == 'Snapform'): ?>  class="active" <?php endif; ?>>
                    <a href="#Snapform" aria-controls="Snapform" role="tab" data-toggle="tab">SNAPPE II</a>
                </li>
                <li role="presentation" <?php if($active == 'Diagform'): ?>  class="active" <?php endif; ?>>
                    <a href="#Diagform" aria-controls="Diagform" role="tab" data-toggle="tab">Diagnosis</a>
                </li>
                <li role="presentation">
                    <a href="#media_tab" aria-controls="#media_tab" role="tab" data-toggle="tab">Attachments</a>
                </li>
                <?php endif; ?>  
                <?php if(Session::has('slug-nav')): ?>
                <li role="presentation" <?php if($active == 'dischargeform'): ?>  class="active" <?php endif; ?>>
                    <a href="#dischargeform" aria-controls="dischargeform" role="tab" data-toggle="tab">Discharge Details</a></li>
                    <li role="presentation" <?php if($active == 'Checkform'): ?>  class="active" <?php endif; ?>>
                        <a href="#Checkform" aria-controls="Checkform" role="tab" data-toggle="tab">Checklist</a>
                    </li>
                    <?php endif; ?> 
                </ul>
                <!-- Tab panes -->

                <div class="tab-content tab-view-shadow nicu-table">
                    <!-- Basics Form -->
                    <div role="tabpanel" class="tab-pane <?php if($active == 'basicform'): ?> active <?php endif; ?>" id="basicform">
                        <div class="col-md-6 col-sm-6">
                            <div class="mt-10 widget box">
                                <div class="widget-header">
                                    <h4><i class="fa fa-reorder"></i> </h4>
                                </div>
                                <div class="widget-content">
                                    <?php echo Form::hidden('MotherId'); ?>

                                    <?php echo Form::hidden('BabyId'); ?>

                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            <?php echo Form::label('BabyName','Baby Name:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::text('BabyName',null,['class'=>'form-control','readonly']); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            <?php echo Form::label('BMrNo', Lang::get('home.mrn').':'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::text('BMrNo',null,['class'=>'form-control','readonly']); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            <?php echo Form::label('DOB','DOB:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::text('DOB',null,['class'=>'form-control datepicker dob_date birth-date','readonly']); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control mt-0">
                                            <?php echo Form::label('BirthWeight','Birth Weight (In grams):'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::text('BirthWeight',null,['class'=>'form-control','readonly']); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            <?php echo Form::label('BirthStatus','Birth Status:'); ?>

                                        </div>
                                        
                                        <div class="col-md-9 custom-input" style="pointer-events: none; cursor: not-allowed;">
                                            <input id="BirthStatus" data-size="small" name="BirthStatus" data-off="Outborn" data-on="Inborn" data-width="100" data-toggle="toggle" class="form-control switch-input" type="checkbox" <?php if(isset($results->BirthStatus) && $results->BirthStatus == 'Inborn'): ?> checked="checked" <?php endif; ?>>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                            <?php echo Form::label('Gestation','Gestation:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input clear-xs">
                                            <div class="row col-md-12 display-flex">
                                                <div>
                                                    <small>(In Weeks)</small>
                                                    <?php echo Form::text('g_weeks',null,['class'=>'form-control gestation-wks','max'=>'46','readonly']); ?>

                                                </div>
                                                <div class="inbeween_two_fields">
                                                    <span>+</span>
                                                </div>
                                                <div>
                                                    <small>(In Days)</small>
                                                    <?php echo Form::text('g_days',null,['class'=>'form-control gestation-days','max'=>'6','readonly']); ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control mt-0">
                                            <?php echo Form::label('BabyBloodGroup','Baby\'s Blood Group:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::text('BabyBloodGroup',null,['class'=>'form-control','readonly']); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            <?php echo Form::label('Sex','Sex:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::select('Sex',['Male'=>'Male','Female'=>'Female','Indeterminate'=>'Indeterminate'],null,['class'=>'form-control','disabled']); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            <?php echo Form::label('ReferredBy','Referred From:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::text('ReferredBy',null,['class'=>'form-control']); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            <?php echo Form::label('ReferralReason','Referral Reason:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::text('ReferralReason',null,['class'=>'form-control text-convertion-lower']); ?>

                                        </div>
                                    </div>
                                    <?php if($results->g_weeks < 36 && $results->g_days <= 6): ?>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control" style="margin-top: 5px;">
                                            <?php echo Form::label('CorrectedGestation','Corrected Gestational Age:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input clear-xs">
                                            <div class="row col-md-12 display-flex">
                                                <div>
                                                    <small>(In Weeks)</small>
                                                    <?php if($active != 'dischargeform'): ?>
                                                    <?php echo Form::text('cg_weeks',null,['class'=>'form-control corrected-gestation-wks', 'onkeypress' => 'return ISNumber(event, this);', 'readonly']); ?>

                                                    <?php else: ?>
                                                    <?php echo Form::text('cg_weeks',null,['class'=>'form-control', 'onkeypress' => 'return ISNumber(event, this);', 'readonly']); ?>

                                                    <?php endif; ?>
                                                    <label class="error help-block" for="cg_weeks" generated="true"></label>
                                                </div>
                                                <div class="inbeween_two_fields">
                                                    <span>+</span>
                                                </div>
                                                <div>
                                                    <small>(In Days)</small>
                                                    <?php if($active != 'dischargeform'): ?>
                                                    <?php echo Form::text('cg_days',null,['class'=>'form-control corrected-gestation-days', 'onkeypress' => 'return ISNumber(event, this);', 'readonly']); ?>

                                                    <?php else: ?>
                                                    <?php echo Form::text('cg_days',null,['class'=>'form-control', 'onkeypress' => 'return ISNumber(event, this);', 'readonly']); ?>

                                                    <?php endif; ?>
                                                    <label class="error help-block" for="cg_days" generated="true"></label> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
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
                                            <?php echo Form::label('AdmissionDate','Admission Date:', ['class'=>'required-label']); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php if($active != 'dischargeform'): ?>
                                            <?php echo Form::text('AdmissionDate',null,['class'=>'form-control admission-date record-date', 'readonly' => 'true']); ?>

                                            <?php else: ?>
                                            <?php echo Form::text('AdmissionDate',null,['class'=>'form-control admission-date', 'readonly' => 'true']); ?>                                            
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                            <?php echo Form::label('AdmissionTime','Admission Time:', ['class'=>'required-label']); ?>

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
                                                    <?php echo Form::select('AdmissionTime',$admission['time'],null,['class'=>'form-control ']); ?>

                                                </div>
                                                <div class="col-xs-4">
                                                    <?php echo Form::select('AdmissionTime_MINS',$admission['mins'],null,['class'=>'form-control ']); ?>

                                                </div>
                                                <div class="col-xs-4">
                                                    <?php echo Form::select('AdmissionTime_AM',['AM'=>'AM','PM'=>'PM'],null,['class'=>'form-control ']); ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            <?php echo Form::label('TypeOfCare','Type Of Care:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::select('TypeOfCare',['Intensive Care'=>'Intensive Care','Special Care'=>'Special Care','Ward Admission'=>'Ward Admission','High Dependancy Care'=>'High Dependancy Care'],null,['class'=>'form-control']); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            <?php echo Form::hidden('visit_type', 'IP', ['id'=>'visit_type']); ?>

                                            <?php echo Form::label('ip_number', Lang::get('home.ip').':'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::text('ip_number',$results->ip_number,['class'=>'form-control ip_number']); ?>

                                            <?php if($results->ip_number == ''): ?>
                                            <a class="btn btn-warning btn-basic-shadow input-width-medium pull-right" id="generate-ip" data-ip-field="ip_number" data-form-id="admissionProforma-form" title="<?php echo e(Lang::get('home.ip_generate_btn_title'), false); ?>">
                                                <img src="<?php echo e($site_url, false); ?>/img/saraswathi_logo.png"> <span><?php echo e(Lang::get('home.ip_generate_btn'), false); ?></span>
                                            </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            <?php echo Form::label('AdmissionWt','Admission Weight (In grams):', ['class'=>'required-label']); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::text('AdmissionWt',null,['class'=>'form-control']); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            <?php echo Form::label('AgeOnAdmission','Age On Admission'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input clear-xs">
                                            <div class="row age_on_admission_days">
                                                <div class="col-md-10">
                                                    <?php echo Form::text('AgeOnAdmissioninDays',null,['class'=>'form-control', 'id'=> 'AgeOnAdmissioninDays', 'onkeypress' => 'return ISNumber(event, this);']); ?>

                                                </div>
                                                <div class="col-md-2">
                                                    <label class="label-control">
                                                        Days
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row age_on_admission_hours">
                                                <div class="col-md-10">
                                                    <?php echo Form::text('AgeOnAdmissionhour',null,['class'=>'form-control', 'id' => 'AgeOnAdmissionhour', 'onkeypress' => 'return ISNumber(event, this);']); ?>

                                                </div>
                                                <div class="col-md-2">
                                                    <label class="label-control">
                                                        Hours
                                                    </label>
                                                </div>
                                            </div>
                                            <!-- <div class="row">
                                                <div class="col-xs-6 text-center">
                                                    <small>(In Days)</small>
                                                </div>
                                                <div class="col-xs-6 text-center">
                                                    <small>(In hours only if < 96)</small>
                                                </div>
                                                <div class="col-xs-6">
                                                    <?php echo Form::text('AgeOnAdmissioninDays',null,['class'=>'form-control age-on-admission-days']); ?>

                                                </div>
                                                <div class="col-xs-6">
                                                    <?php echo Form::text('AgeOnAdmissionhour',null,['class'=>'form-control', 'id'=>'AgeOnAdmissionhour']); ?>

                                                </div>
                                            </div> -->
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            <?php echo Form::label('Surgeon','Surgeon:'); ?>

                                            <a href="javascript:void(0)" class="add_master_data" data-modal_header="Surgeon" data-destination_elements="Surgeon,SeenBy" data-option_value="id" data-option_text="Name" data-mas_table="mas_doctors">
                                                <i class="fa fa-info-circle bs-tooltip add-neo-consultant" data-placement="right" data-original-title="Add Surgeon"></i>
                                            </a>
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::select('Surgeon',['Not applicable'=>'Not applicable']+ValuelistHelpers::get_surgeons_lists(),null,['class'=>'form-control']); ?>

                                        </div>
                                    </div>
                                    <div class="hidden">
                                        <?php echo Form::select('seen_by',$doctor_master,null,['class'=>'form-control']); ?>

                                    </div>                                     
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            <?php echo Form::label('SeenBy','Seen By', ['class'=>'required-label']); ?>

                                            <a href="javascript:void(0)" class="add_master_data" data-modal_header="Seen By" data-destination_elements="Surgeon,SeenBy" data-option_value="id" data-option_text="Name" data-mas_table="mas_doctors">
                                                <i class="fa fa-info-circle bs-tooltip add-neo-consultant" data-placement="right" data-original-title="Add Doctor"></i>
                                            </a>
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <table class="seen-by-div table table-add-more full-width-fix">
                                                <thead>                                    
                                                    <tr class="master-add-header">
                                                        <th class="full-width">
                                                            <i class="fa fa-reorder"></i>Add More
                                                        </th>
                                                        <th>
                                                            <span>
                                                                <a class="btn btn-success btn-view nicu_seen_by_add btn_add" href="javascript:void(0);">
                                                                    <i class="fa fa-plus"></i>
                                                                </a>
                                                            </span>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $seen_by = json_decode($results->SeenBy);
                                                    ?>
                                                    <?php if(isset($seen_by) && !empty($seen_by) && count($seen_by) > 0): ?>
                                                    <?php $__currentLoopData = $seen_by; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $seen_by): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo Form::select('SeenBy['.$key.']',$doctor_master,$seen_by,['class'=>'form-control full-width']); ?>

                                                        </td>
                                                        <?php if($key > 0): ?>                                             
                                                        <td>
                                                            <span class="fa fa-trash btn btn-danger btn-view remove-neon"></span>
                                                        </td>
                                                        <?php else: ?>                                                    
                                                        <td></td>
                                                        <?php endif; ?>
                                                    </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php else: ?> 
                                                    <tr>
                                                        <td>
                                                            <?php echo Form::select('SeenBy[]',$doctor_master,null,['class'=>'form-control full-width']); ?>

                                                        </td>
                                                    </tr>
                                                    <?php endif; ?> 
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            <?php echo Form::label('hospital_name','Hospital Name', ['class'=>'required-label']); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::select('hospital_name',ValuelistHelpers::getHospitals(),null,['class'=>'form-control']); ?>

                                        </div>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- History Form -->
                    <div role="tabpanel" class="tab-pane <?php if($active == 'historyform'): ?> active <?php endif; ?>" id="historyform">
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
                                                        <a href="javascript:void(0)" class="add_master_data" data-modal_header="Medical Problems" data-destination_elements="temp_medi_probs,Problems[]" data-option_value="id" data-option_text="Name" data-mas_table="mas_medical_problems">
                                                            <i class="fa fa-info-circle bs-tooltip add-neo-consultant" data-placement="right" data-original-title="Add Medical Problems"></i>
                                                        </a>
                                                    </th>
                                                    <th>Medications</th>
                                                    <th>
                                                        <span>
                                                            <a class="btn btn-success btn-view medi_add btn_add" href="javascript:void(0);">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                        </span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <div class="hidden">
                                                    <?php echo Form::select('temp_medi_probs',$medi_probs_master,''); ?>

                                                </div>
                                                <?php if(isset($pbm_data) && count($pbm_data) > 0): ?>
                                                <?php $__currentLoopData = $pbm_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pdm_key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo Form::select('Problems['.$pdm_key.']',$medi_probs_master,$data['Problem'],['class'=>'form-control input-width-xlarge']); ?></td>
                                                    <td><input type="text" class="form-control input-width-xlarge" name="Medications[<?php echo e($pdm_key, false); ?>]" value="<?php echo $data['Medication'];; ?>"/></td>
                                                    <td><span class="fa fa-trash btn btn-danger btn-view remove-medi"></span></td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                <tr>
                                                    <td><?php echo Form::select('Problems[]',$medi_probs_master,'',['class'=>'form-control input-width-xlarge']); ?></td>
                                                    <td><input type="text" name="Medications[]" value="" class="form-control input-width-xlarge"/></td>
                                                    <td><span class="fa fa-trash btn btn-danger btn-view remove-medi"></span></td>
                                                </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-12 plr-0">
                                    <div class="col-md-5 col-sm-6">
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('Smoking','Smoking:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('Smoking',['No'=>'No','Yes'=>'Yes'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('Alcohol','Alcohol:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('Alcohol',['No'=>'No','Yes'=>'Yes'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sm-6">
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('Tobacco','Tobacco:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('Tobacco',['No'=>'No','Yes'=>'Yes'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane <?php if($active == 'pregform'): ?> active <?php endif; ?>" id="pregform">
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
                                                        <a href="javascript:void(0)" class="add_master_data" data-modal_header="Complications" data-destination_elements="temp_complications,Complication[]" data-option_value="id" data-option_text="Name" data-mas_table="mas_complication">
                                                            <i class="fa fa-info-circle bs-tooltip add-neo-consultant" data-placement="right" data-original-title="Add Complications"></i>
                                                        </a>
                                                    </th>
                                                    <th>Treatment</th>
                                                    <th>
                                                        <span>
                                                            <a class="btn btn-success btn-view nicu_complication_add btn_add" href="javascript:void(0);">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                        </span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <div class="hidden">
                                                    <?php echo Form::select('temp_complications',$complication_master,'',["class"=>"form-control "]); ?>

                                                </div>
                                                <?php if(isset($neonatal_complication) && count($neonatal_complication) > 0): ?>
                                                <?php $__currentLoopData = $neonatal_complication; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $neo_comp_key => $neonatal_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if(!empty($neonatal_data['Complication'])): ?>
                                                <tr>
                                                    <td class="half-width"><?php echo Form::select('Complication['.$neo_comp_key.']',$complication_master,$neonatal_data['Complication'],["class"=>"form-control","disabled"=>"true"]); ?></td>
                                                    <td class="half-width"><input type="text" class="form-control" name="Treatments[<?php echo e($neo_comp_key, false); ?>]" value="<?php echo $neonatal_data['Treatment'];; ?>" disabled="true" /></td>
                                                    <td><span class="fa fa-trash btn btn-danger btn-view remove-medi"></span></td>
                                                </tr>
                                                <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>  
                                                <?php if(isset($complication) && count($complication) > 0): ?>
                                                <?php $__currentLoopData = $complication; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comp_key => $com_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td class="half-width"><?php echo Form::select('Complication['.$comp_key.']',$complication_master,$com_data['Complication'],["class"=>"form-control"]); ?></td>
                                                    <td class="half-width"><input type="text" class="form-control" name="Treatments[<?php echo e($comp_key, false); ?>]" value="<?php echo $com_data['Treatment'];; ?>"/></td>
                                                    <td><span class="fa fa-trash btn btn-danger btn-view remove-medi"></span></td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                                <?php if(isset($complication) && count($complication) == 0 && isset($neonatal_complication) && count($neonatal_complication) == 0): ?>
                                                <tr>
                                                    <td class="half-width"><?php echo Form::select('Complication[]',$complication_master,'',["class"=>"form-control"]); ?></td>
                                                    <td class="half-width"><input type="text" class="form-control" name="Treatments[]" value=""/></td>
                                                    <td><span class="fa fa-trash btn btn-danger btn-view remove-medi"></span></td>
                                                </tr>
                                                <?php endif; ?>
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
                                                        <td class="form-group"><input type="text" value="<?php echo e((isset($datingScan['date']) && !empty($datingScan['date']) && !is_null($datingScan['date'])) ? date('d-m-Y', strtotime($datingScan['date'])) : '', false); ?>" class="form-control input-width-medium"  name="datingdate" <?php if(isset($datingScan['date']) && !empty($datingScan['date'])): ?> disabled="true" <?php endif; ?> readonly /></td>
                                                        <td class="form-group"><input type="text" value="<?php echo e(@$datingScan['Gestation'], false); ?>" class="form-control input-width-medium"  name="datinggestations" <?php if(isset($datingScan['Gestation']) && !empty($datingScan['Gestation'])): ?> disabled="true" <?php endif; ?> /></td>
                                                        <td class="form-group"><input type="text" value="<?php echo e(@$datingScan['Finding'], false); ?>" name="datingfindings" class="form-control input-width-large" <?php if(isset($datingScan['Gestation']) && !empty($datingScan['Gestation'])): ?> disabled="true" <?php endif; ?> /></td>
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
                                                        <td  class="form-group"><input type="text" name="analogdate" value="<?php echo e((isset($analogScan['date']) && !empty($analogScan['date']) && !is_null($analogScan['date'])) ? date('d-m-Y', strtotime($analogScan['date'])) : '', false); ?>" class="form-control input-width-medium" <?php if(isset($analogScan['date']) && !empty($analogScan['date'])): ?> disabled="true" <?php endif; ?> readonly /></td>
                                                        <td  class="form-group"><input type="text" name="analoggestations" value="<?php echo e(@$analogScan['Gestation'], false); ?>" class="form-control input-width-medium" <?php if(isset($analogScan['Gestation']) && !empty($analogScan['Gestation'])): ?> disabled="true" <?php endif; ?> /></td>
                                                        <td  class="form-group"><input type="text" name="analogfindings"   value="<?php echo e(@$analogScan['Finding'], false); ?>"  class="form-control input-width-large" <?php if(isset($analogScan['Gestation']) && !empty($analogScan['Gestation'])): ?> disabled="true" <?php endif; ?> /></td>
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
                                                        <th>
                                                            <span>
                                                                <a class="btn_add btn btn-success btn-view any-further-scan-add" href="javascript:void(0);">
                                                                    <i class="fa fa-plus"></i></a>
                                                                </span>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if(isset($neonatalOtherscan) && count($neonatalOtherscan) > 0): ?>
                                                        <?php $__currentLoopData = array_values($neonatalOtherscan); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $otherscanKey => $otherscanValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td  class="form-group"> <input type="text" value="<?php echo e(@unserialize($otherscanValue['date']) !== false ? '' : ((isset($otherscanValue['date']) && !empty($otherscanValue['date']) && !is_null($otherscanValue['date'])) ? date('d-m-Y', strtotime($otherscanValue['date'])) : ''), false); ?>" class="form-control input-width-medium"  name="notherdate[<?php echo e($otherscanKey, false); ?>]" <?php if(isset($otherscanValue['date']) && !empty($otherscanValue['date'])): ?> disabled="true" <?php endif; ?> readonly/></td>
                                                            <td  class="form-group"> <input type="text" value="<?php echo e(@unserialize($otherscanValue['Gestation']) !== false ? '' : $otherscanValue['Gestation'], false); ?>" class="form-control input-width-medium"  name="nothergestations[<?php echo e($otherscanKey, false); ?>]" id="gestations" disabled="true"/></td>
                                                            <td  class="form-group"> <input type="text"  value="<?php echo e(@unserialize($otherscanValue['Finding']) !== false ? '' : $otherscanValue['Finding'], false); ?>" name="notherfindings[<?php echo e($otherscanKey, false); ?>]" class="form-control input-width-large" disabled="true" /></td>
                                                            <td class="form-group">  </td>
                                                        </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>    
                                                        <?php if(isset($otherScan) && count($otherScan) > 0): ?>
                                                        <?php $__currentLoopData = array_values($otherScan); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scanKey => $scanValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td  class="form-group"><input type="text" value="<?php echo e(@unserialize($scanValue['date']) !== false ? '' : ((isset($scanValue['date']) && !empty($scanValue['date']) && !is_null($scanValue['date'])) ? date('d-m-Y', strtotime($scanValue['date'])) : ''), false); ?>" class="form-control input-width-medium"  name="otherdate[<?php echo e($scanKey, false); ?>]" readonly /></td>
                                                            <td  class="form-group"><input type="text" value="<?php echo e(@unserialize($scanValue['Gestation']) !== false ? '' : $scanValue['Gestation'], false); ?>" class="form-control input-width-medium"  name="othergestations[<?php echo e($scanKey, false); ?>]" id="gestations" /></td>
                                                            <td  class="form-group"><input type="text"  value="<?php echo e(@unserialize($scanValue['Finding']) !== false ? '' : $scanValue['Finding'], false); ?>" name="otherfindings[<?php echo e($scanKey, false); ?>]" class="form-control input-width-large"  /></td>
                                                            <td class="form-group"><span class="fa fa-trash btn btn-danger btn-view remove-usg"></span></td>
                                                        </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                                        <?php if(isset($neonatalOtherscan) && count($neonatalOtherscan) == 0 && isset($otherScan) && count($otherScan) == 0): ?>
                                                        <tr>
                                                            <td  class="form-group"><input type="text" class="form-control input-width-medium"  name="otherdate[]" readonly /></td>
                                                            <td  class="form-group"><input type="text" class="form-control input-width-medium"  name="othergestations[]" /></td>
                                                            <td  class="form-group"><input type="text" name="otherfindings[]" class="form-control input-width-large" /></td>
                                                            <td class="form-group"><span class="fa fa-trash btn btn-danger btn-view remove-usg"></span></td>
                                                        </tr>
                                                        <?php endif; ?>
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
                                                        <?php if(isset($neonatalDopplerscan) && count($neonatalDopplerscan) > 0): ?>
                                                        <?php $__currentLoopData = $neonatalDopplerscan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dopplerscanKey => $dopplerscanValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td  class="form-group"> <input type="text" value="<?php echo e((isset($dopplerscanValue['date']) && !empty($dopplerscanValue['date']) && !is_null($dopplerscanValue['date'])) ? date('d-m-Y', strtotime($dopplerscanValue['date'])) : '', false); ?>" class="form-control input-width-medium"  name="nodate[<?php echo e($dopplerscanKey, false); ?>]" <?php if(isset($dopplerscanValue['date']) && !empty($dopplerscanValue['date'])): ?> disabled="true" <?php endif; ?> readonly/></td>
                                                            <td  class="form-group"> <input type="text" value="<?php echo e($dopplerscanValue['Gestation'], false); ?>" class="form-control input-width-medium"  name="nothergestations[<?php echo e($dopplerscanKey, false); ?>]" id="gestations" disabled="true"/></td>
                                                            <td  class="form-group"> <input type="text"  value="<?php echo e($dopplerscanValue['Finding'], false); ?>" name="notherfindings[<?php echo e($dopplerscanKey, false); ?>]" class="form-control input-width-large" disabled="true" /></td>
                                                            <td class="form-group"> </td>
                                                        </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>    
                                                        <?php if(isset($dopplerScan) && count($dopplerScan) > 0): ?>
                                                        <?php $__currentLoopData = $dopplerScan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dopplerKey => $dopplerValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td  class="form-group"><input type="text" value="<?php echo e((isset($dopplerValue['date']) && !empty($dopplerValue['date']) && !is_null($dopplerValue['date'])) ? date('d-m-Y', strtotime($dopplerValue['date'])) : '', false); ?>" class="form-control input-width-medium"  name="dopplerdate[<?php echo e($dopplerKey, false); ?>]" readonly /></td>
                                                            <td  class="form-group"><input type="text" value="<?php echo e($dopplerValue['Gestation'], false); ?>" class="form-control input-width-medium"  name="dopplergestations[<?php echo e($dopplerKey, false); ?>]" /></td>
                                                            <td  class="form-group"><input type="text"  value="<?php echo e($dopplerValue['Finding'], false); ?>" name="dopplerfindings[<?php echo e($dopplerKey, false); ?>]" class="form-control input-width-large"  /></td>
                                                            <td class="form-group"><span class="fa fa-trash btn btn-danger btn-view remove-usg"></span></td>
                                                        </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                                        <?php if(isset($neonatalDopplerscan) && count($neonatalDopplerscan) == 0 && isset($dopplerScan) && count($dopplerScan) == 0): ?>
                                                        <tr>
                                                            <td  class="form-group"><input type="text" class="form-control input-width-medium"  name="dopplerdate[]" readonly /></td>
                                                            <td  class="form-group"><input type="text" class="form-control input-width-medium"  name="dopplergestations[]" /></td>
                                                            <td  class="form-group"><input type="text" name="dopplerfindings[]" class="form-control input-width-large"  /></td>
                                                            <td class="form-group"><span class="fa fa-trash btn btn-danger btn-view remove-usg"></span></td>
                                                        </tr>
                                                        <?php endif; ?>
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
                        <div role="tabpanel" class="tab-pane <?php if($active == 'babyform'): ?> active <?php endif; ?>" id="babyform">
                            <div class="col-md-6 col-sm-6">
                                <div class="mt-10 widget box">
                                    <div class="widget-header">
                                        <h4><i class="fa fa-reorder"></i> </h4>
                                    </div>
                                    <div class="widget-content">
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('DescriptionOfResuscitation','Description Of Resuscitation:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::textarea('DescriptionOfResuscitation',null,['class'=>'form-control','rows' => 5]); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12 text-center">
                                                <h4><strong>Post Resuscitation Care</strong></h4>
                                                <!-- <?php echo Form::label('Post Resuscitation Care','Post Resuscitation Care'); ?> -->
                                                <hr class="mt-0" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('VentilationRequired','Invasive Ventilation Required:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <input checked data-toggle="toggle" data-width="100" data-size="small" class="form-control" id="VentilationRequired" name="VentilationRequired" data-on="Yes" data-off="No" type="checkbox">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('SurfactantGiven','Surfactant Given In Labour Room / Theatre:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('SurfactantGiven',[''=>'N/A','Yes'=>'Yes','No'=>'No'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('SurfactantType','Surfactant Type:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('SurfactantType',[''=>'N/A','Curosurf'=>'Curosurf','Survanta'=>'Survanta','Neosurf'=>'Neosurf'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('Dose','Dose:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::text('Dose',null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('DateofAdministration','Date of Administration:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::text('DateofAdministration',null,['class'=>'form-control admission-date', 'readonly' => 'true']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control" style="margin-top: 15px;">
                                                <?php echo Form::label('TimeOfAdministrations','Time Of Administration:'); ?>

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
                                                        <?php echo Form::select('TimeOfAdministration',$admission['time'],null,['class'=>'form-control ','id'=>'TimeOfAdministration']); ?> 
                                                    </div>
                                                    <div class="col-xs-4">
                                                        <?php echo Form::select('TimeOfAdministration_MINS',$admission['mins'],null,['class'=>'form-control
                                                            ','id'=>'TimeOfAdministration_MINS']); ?>

                                                        </div>
                                                        <div class="col-xs-4">
                                                            <?php echo Form::select('TimeOfAdministration_AM',['AM'=>'AM','PM'=>'PM'],null,['class'=>'form-control
                                                                ','id'=>'TimeOfAdministration_AM']); ?>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        <?php echo Form::label('AgeAfterBirth','Age After Birth:'); ?>

                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        <?php echo Form::text('AgeAfterBirth',null,['class'=>'form-control']); ?>

                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        <?php echo Form::label('delivery_cpap','Delivery room CPAP given ?:'); ?>

                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        <input checked data-toggle="toggle" data-width="100" data-size="small" class="form-control" id="delivery_cpap" name="delivery_cpap" data-on="Yes" data-off="No" type="checkbox">
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
                                                                <th><?php echo Form::label('air_flow','Air Flow During Transfer L/min:'); ?></th>
                                                                <th><?php echo Form::label('oxgen_flow','Oxygen Flow During Transfer L/min:'); ?></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><?php echo Form::text('air_flow',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']); ?></td>
                                                                <td><?php echo Form::text('oxgen_flow',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']); ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <label for="air_flow" generated="true" class="error help-block"></label>
                                                <label for="oxgen_flow" generated="true" class="error help-block"></label>
                                                <div class="form-group row mx-0">
                                                    <div class="col-md-12">
                                                        <?php echo Form::label('TransferFiO2','Calculated / Actual FIO2% During Transfer:'); ?>

                                                    </div>
                                                    <div class="col-md-12">
                                                        <?php echo Form::text('TransferFiO2',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Admission Form -->
                                <div role="tabpanel" class="tab-pane <?php if($active == 'admissform'): ?> active <?php endif; ?>" id="admissform">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="mt-10 widget box">
                                            <div class="widget-header">
                                                <h4><i class="fa fa-reorder"></i> </h4>
                                            </div>
                                            <div class="widget-content">
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        <?php echo Form::label('AdmittedFrom','Admitted From:'); ?>

                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        <?php echo Form::select('AdmittedFrom',[''=>'Select','Labour ward'=>'Labour ward','Postnatal ward'=>'Postnatal ward','OP'=>'OP','Outside Hospital'=>'Outside Hospital','Obstetric theatres'=>'Obstetric theatres'],null,['class'=>'form-control']); ?>

                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        <?php echo Form::label('MajorComplaints','Major Complaints:'); ?>

                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        <?php echo Form::textarea('MajorComplaints',null,['class'=>'form-control','rows' => 5]); ?>

                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        <?php echo Form::label('Ventilation','Respiratory Support at the time of admission:'); ?>

                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        <input id="Ventilation" name="Ventilation" data-on="Yes" data-off="No" checked data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        <?php echo Form::label('Mode','Mode:'); ?>

                                                        <a href="javascript:void(0)" class="add_master_data" data-modal_header="Mode" data-destination_elements="Mode" data-option_value="Id" data-option_text="Mode_name" data-mas_table="mas_admissionmode">
                                                            <i class="fa fa-info-circle bs-tooltip" data-placement="right" data-original-title="Add Mode"></i>
                                                        </a>
                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        <?php echo Form::select('Mode',[''=>'N/A']+$admissionmode_master,null,['class'=>'form-control']); ?>

                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        <?php echo Form::label('pip_set','Pip (Set):'); ?>

                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        <?php echo Form::text('pip_set',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']); ?>

                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        <?php echo Form::label('Pip','Pip (Delivered):'); ?>

                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        <?php echo Form::text('Pip',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']); ?>

                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        <?php echo Form::label('PEEP','PEEP:'); ?>

                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        <?php echo Form::text('PEEP',null,['class'=>'form-control' , 'onkeypress' => 'return isNumber(event, this);']); ?>

                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        <?php echo Form::label('amplitude_delta','Amplitude &delta; :'); ?>

                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        <?php echo Form::text('amplitude_delta',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']); ?>

                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        <?php echo Form::label('mean_airway_pressure','Mean Airway Pressure:'); ?>

                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        <?php echo Form::text('mean_airway_pressure',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']); ?>

                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        <?php echo Form::label('map','MAP:'); ?>

                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        <?php echo Form::text('map',null,['class'=>'form-control' , 'onkeypress' => 'return isNumber(event, this);']); ?>

                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        <?php echo Form::label('fio2_set','FIO2 % (Set):'); ?>

                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        <?php echo Form::text('fio2_set',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']); ?>

                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        <?php echo Form::label('Fio2','FIO2 % (Delivered):'); ?>

                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        <?php echo Form::text('Fio2',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']); ?>

                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        <?php echo Form::label('Rate','Rate\Frequency:'); ?>

                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        <?php echo Form::text('Rate',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']); ?>

                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        <?php echo Form::label('frequency','Frequency (Hz):'); ?>

                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        <?php echo Form::text('frequency',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']); ?>

                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        <?php echo Form::label('IT','IT:'); ?>

                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        <?php echo Form::text('IT',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']); ?>

                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        <?php echo Form::label('Flow_l_min','Flow (L/Min):'); ?>

                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        <?php echo Form::text('Flow_l_min',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']); ?>

                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        <?php echo Form::label('RR','RR:'); ?>

                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        <?php echo Form::text('RR',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']); ?>

                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        <?php echo Form::label('ratio','I:E ratio:'); ?>

                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        <?php echo Form::text('ratio',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']); ?>

                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        <?php echo Form::label('nicu_retractions','Retractions:'); ?>

                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        <?php echo Form::select('nicu_retractions',[''=>'N/A','No'=>'No','Mild'=>'Mild','Moderate'=>'Moderate','Severe'=>'Severe'],null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('Retractions')]); ?>

                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        <?php echo Form::label('nicu_airentry','Air entry:'); ?>

                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        <?php echo Form::select('nicu_airentry',[''=>'N/A','Equal'=>'Equal','Reduced Bilateral'=>'Reduced Bilateral','Reduced Rt'=>'Reduced Right','Reduced Lt'=>'Reduced &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Left'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('AirEntry')]); ?>

                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        <?php echo Form::label('ChestMovement','Chest Movement:'); ?>

                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        <?php echo Form::select('ChestMovement',[''=>'N/A','Symmetrical'=>'Symmetrical','Asymmetrical'=>'Asymmetrical'],null,['class'=>'form-control']); ?>

                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        <?php echo Form::label('HR','HR in bpm:'); ?>

                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        <?php echo Form::text('HR',null,['class'=>'form-control']); ?>

                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        <?php echo Form::label('BP','Systolic BP:'); ?>

                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        <?php echo Form::text('BP',null,['class'=>'form-control']); ?>

                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        <?php echo Form::label('diastolic_bp','Diastolic BP:'); ?>

                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        <?php echo Form::text('diastolic_bp',null,['class'=>'form-control']); ?>

                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        <?php echo Form::label('MeanBP','Mean BP:'); ?>

                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        <?php echo Form::text('MeanBP',null,['class'=>'form-control']); ?>

                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        <?php echo Form::label('nicu_central_pulses','Central Pulses:'); ?>

                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        <?php echo Form::select('nicu_central_pulses',[''=>'N/A','Normal'=>'Normal','Bounding'=>'Bounding','Feeble/Weak'=>'Feeble/Weak','Absent'=>'Absent'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('PeripheralPulses')]); ?>

                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        <?php echo Form::label('nicu_peripheral_pulses','Peripheral Pulses:'); ?>

                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        <?php echo Form::select('nicu_peripheral_pulses',[''=>'N/A','Normal'=>'Normal','Bounding'=>'Bounding','Feeble/Weak'=>'Feeble/Weak','Absent'=>'Absent'],null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('PeripheralPulses')]); ?>

                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        <?php echo Form::label('nicu_femoral_pulses','Femoral Pulses:'); ?>

                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        <?php echo Form::select('nicu_femoral_pulses',[''=>'N/A','Normal'=>'Normal','Bounding'=>'Bounding','Feeble/Weak'=>'Feeble/Weak','Absent'=>'Absent'],null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('PeripheralPulses')]); ?>

                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        <?php echo Form::label('nicu_s1s2','S1S2:'); ?>

                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        <?php echo Form::select('nicu_s1s2',[''=>'N/A','Normal'=>'Normal','Abnormal'=>'Abnormal'],null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]); ?>

                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        <?php echo Form::label('nicu_murmur','Murmur:'); ?>

                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        <?php echo Form::select('nicu_murmur',[''=>'N/A','Absent'=>'Absent','Present'=>'Present'],null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('default')]); ?>

                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        <?php echo Form::label('CFT','CFT:'); ?>

                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        <?php echo Form::select('CFT',[''=>'N/A','< 3 Seconds' => "< 3 Seconds",'3-5 Seconds' => "3-5 Seconds",'>5 Seconds' => ">5 Seconds","Prolonged"=>"Prolonged"],null,['class'=>'form-control']); ?>

                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3 text-right label-control">
                                                        <?php echo Form::label('nicu_color','Color:'); ?>

                                                    </div>
                                                    <div class="col-md-9 custom-input">
                                                        <?php echo Form::select('nicu_color',['Pink' => "Pink",'Yellow'=>'Yellow','Pale'=>'Pale',"Acral Cyanosis"=>"Acral Cyanosis","Central Cyanosis"=>"Central Cyanosis"],null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('Color')]); ?>

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
                            <!-- <div class="form-group row">
                                <div class="col-md-3 text-right label-control mt-0">
                                    <?php echo Form::label('Temperature','Temperature (F/C):'); ?>

                                </div>
                                <div class="col-md-9 custom-input">
                                    <?php echo Form::text('Temperature',null,['class'=>'form-control']); ?>

                                </div>
                            </div> -->

                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control" style="margin-top: 25px">
                                    <?php echo Form::label('Temperature','Temperature:'); ?>

                                </div>
                                <?php $order_changed = \SiteHelpers::temperatureOrder(); ?>
                                <div class="col-md-9 custom-input clear-xs">
                                    <?php if($order_changed): ?>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <small>(In Fahrenheit)</small>
                                        </div>
                                        <div class="col-xs-6">
                                            <small>(In Celsius)</small>
                                        </div>
                                        <div class="col-xs-6">
                                            <?php echo Form::text('',null,['class'=>'form-control fahrenheit']); ?>

                                        </div>
                                        <div class="col-xs-6">
                                            <?php echo Form::text('Temperature',null,['class'=>'form-control celsius']); ?>

                                        </div>
                                    </div>
                                    <?php else: ?>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <small>(In Celsius)</small>
                                        </div>
                                        <div class="col-xs-6">
                                            <small>(In Fahrenheit)</small>
                                        </div>
                                        <div class="col-xs-6">
                                            <?php echo Form::text('Temperature',null,['class'=>'form-control celsius']); ?>

                                        </div>
                                        <div class="col-xs-6">
                                            <?php echo Form::text('',null,['class'=>'form-control fahrenheit']); ?>

                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <label class="error help-block" for="BirthWeight" generated="true" style="display: none;"></label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    <?php echo Form::label('nicu_abdomen','Abdomen:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">
                                    <?php echo Form::select('nicu_abdomen',[''=>'N/A','Normal'=>'Normal','Scaphoid'=>'Scaphoid','Distended'=>'Distended'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('Abdomen')]); ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    <?php echo Form::label('nicu_bowel_sounds','Bowel Sounds:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">
                                    <?php echo Form::select('nicu_bowel_sounds',[''=>'N/A','Normal'=>"Normal","Increased"=>"Increased","Decreased"=>"Decreased","Absent"=>"Absent"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('BowelSounds')]); ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    <?php echo Form::label('nicu_umbilicus','Umbilicus:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">
                                    <?php echo Form::select('nicu_umbilicus',[''=>'N/A','Healthy' => "Healthy","Possible infection"=>"Possible infection","Omphalitis"=>"Omphalitis","Omphalocele"=>"Omphalocele","Gastroschisis"=>"Gastroschisis","Hernia"=>"Hernia",'Meconium Stained' => 'Meconium Stained','Large' => 'Large','Shrivelled' => 'Shrivelled'],null,['class'=>'form-control']); ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    <?php echo Form::label('nicu_hepatomegaly','Hepatomegaly:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">
                                    <?php echo Form::select('nicu_hepatomegaly',[''=>'N/A','No' => "No","Yes"=>"Yes"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]); ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    <?php echo Form::label('nicu_splenomegaly','Splenomegaly:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">
                                    <?php echo Form::select('nicu_splenomegaly',[''=>'N/A','No' =>"No","Yes"=>"Yes"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]); ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    <?php echo Form::label('nicu_herina','Hernia:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">
                                    <?php echo Form::select('nicu_herina',[''=>'N/A','No hernia' => "No hernia","Right Inguinal hernia"=>"Right Inguinal hernia","Left Inguinal hernia"=>"Left Inguinal hernia","Umbilical/para umbilical hernia"=>"Umbilical/para umbilical hernia","Obstructed/strangulated"=>"Obstructed/strangulated"],null,['class'=>'form-control']); ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    <?php echo Form::label('nicu_genitalia','Genitalia:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">
                                    <?php echo Form::select('nicu_genitalia',ValuelistHelpers::getGentila(),null,['class'=>'form-control']); ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    <?php echo Form::label('nicu_genitalia_findings', 'Genitalia Findings:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">
                                    <?php echo Form::text('nicu_genitalia_findings',null,['class'=>'form-control']); ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    <?php echo Form::label('nicu_pupils','Pupils:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">
                                    <?php echo Form::select('nicu_pupils',ValuelistHelpers::getPupils(),null,['class'=>'form-control']); ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    <?php echo Form::label('nicu_pupils_findings','Pupils Findings:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">
                                    <?php echo Form::text('nicu_pupils_findings',null,['class'=>'form-control']); ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control mt-0">
                                    <?php echo Form::label('nicu_anteriorfontanelle','Anterior Fontanelle:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">
                                    <?php echo Form::select('nicu_anteriorfontanelle',[''=>'N/A','Normal' =>"Normal","Depressed"=>"Depressed","Bulging"=>"Bulging"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('AnteriorFontanelle')]); ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    <?php echo Form::label('nicu_activity','Activity:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">
                                    <?php echo Form::select('nicu_activity',[''=>'N/A',"Normal" =>"Normal","Comatosed"=>"Comatosed","Decreased"=>"Decreased","Increased"=>"Increased","Irritable"=>"Irritable","Sedated/Paralysed"=>"Sedated/Paralysed"],null,['class'=>'form-control']); ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    <?php echo Form::label('Tone','Tone'); ?>

                                </div>
                                <div class="col-md-9 custom-input">
                                    <?php echo Form::select('Tone',[''=>'N/A','Normal' =>"Normal","Hypotonia"=>"Hypotonia","Hypertonia"=>"Hypertonia","Sedated/Paralysed"=>"Sedated/Paralysed"],null,['class'=>'form-control']); ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    <?php echo Form::label('nicu_cry','Cry:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">
                                    <?php echo Form::select('nicu_cry',ValuelistHelpers::cryValues(),null,['class'=>'form-control']); ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    <?php echo Form::label('nicu_seizures','Seizures:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">
                                    <?php echo Form::select('nicu_seizures',[''=>'N/A','No' =>"No","Yes"=>"Yes"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]); ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    <?php echo Form::label('nicu_neonatalreflexes','Neonatal Reflexes:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">
                                    <?php echo Form::select('nicu_neonatalreflexes',[''=>'N/A','Normal' =>"Normal","Suppressed"=>"Suppressed","Absent"=>"Absent","Exaggerated"=>"Exaggerated","Sedated/Paralysed"=>"Sedated/Paralysed"],null,['class'=>'form-control']); ?>

                                </div>
                            </div>
                            <!--   <div class="form-group row">
                                <?php echo Form::label('Skin','Skin:'); ?>

                                <?php echo Form::text('Skin',null,['class'=>'form-control']); ?>

                            </div> -->
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    <?php echo Form::label('Abnormalities','Additional Examination Findings:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">
                                    <?php echo Form::textarea('Abnormalities',null,['class'=>'form-control']); ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    <?php echo Form::label('InitialBloodGas','Initial Blood Gas:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">
                                    <?php echo Form::select('InitialBloodGas',['Not done'=>'Not done','Not indicated'=>'Not indicated','Arterial'=>'Arterial','Venous'=>'Venous','Capillary'=>'Capillary'],null,['class'=>'form-control ']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                        <?php echo Form::label('AgeTaken','Age in hours at the time of blood gas:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input clear-xs">
                                        <!-- <?php echo Form::text('AgeTaken',null,['class'=>'form-control', 'onkeypress' => 'return ISNumber(event, this);']); ?> -->
                                        <div class="row">
                                            <div class="col-xs-6 text-center">
                                                <small>(Hours)</small>
                                            </div>
                                            <div class="col-xs-6 text-center">
                                                <small>(Minutes)</small>
                                            </div>
                                            <div class="col-xs-6">
                                                <?php echo Form::select('age_hours',['0'=>'00']+$admission['time'],null,['class'=>'form-control ']); ?>

                                            </div>
                                            <div class="col-xs-6">
                                                <?php echo Form::select('age_mins',$admission['mins'],null,['class'=>'form-control ']); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('SpO2','SpO2 (%):'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('SpO2',null,['class'=>'form-control', 'onkeypress' => 'return ISNumber(event, this);']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('pH','pH:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('pH',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('lab_lactate','Lactate:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('lab_lactate',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('PaO2','PaO2:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('PaO2',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('PaCo2','PaCo2:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('PaCo2',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('HCO3','HCO3:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('HCO3',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('BE','BE:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('BE',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('RBS','RBS (mg/dl):'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('RBS',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('Hct','Hct:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('Hct',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12">
                        <div class="widget box mt-10">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i>Initial assessment completed at:</h4>
                            </div>
                            <div class="widget-content">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group row" style="margin-top: 20px;">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('initial_assessment_completed_date','Date:', ['class'=>'required-label']); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::text('initial_assessment_completed_date',null,['class'=>'form-control datepicker','readonly']); ?>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                                <?php echo Form::label('initial_assessment_completed_time','Time:', ['class'=>'required-label']); ?>

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
                                                        <?php echo Form::select('initial_assessment_completed_hr',$admission['time'],null,['class'=>'form-control input-width-small']); ?>

                                                    </div>
                                                    <div class="col-xs-4">
                                                        <?php echo Form::select('initial_assessment_completed_min',$admission['mins'],null,['class'=>'form-control input-width-small']); ?>

                                                    </div>
                                                    <div class="col-xs-4">
                                                        <?php echo Form::select('initial_assessment_completed_session',['AM'=>'AM','PM'=>'PM'],null,['class'=>'form-control input-width-small']); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Procedure Form-->
                <div role="tabpanel" class="tab-pane <?php if($active == 'Proform'): ?> active <?php endif; ?>" id="Proform">
                    <div class="col-md-6 col-sm-6">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('InitialXray','Initial X ray:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('InitialXray',['Not done' => 'Not done','Not indicated' =>'Not indicated','Performed'=> 'Performed'],null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('xrayfindings','Chest X ray findings:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('xrayfindings',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <?php echo Form::label('AgeofCXR','Abdominal X Ray findings:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('AgeofCXR',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('UAC','UAC:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <input id="UAC" name="UAC" data-on="Yes" data-off="No" checked data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('UACPosition','UACPosition:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('UACPosition',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('UVC','UVC:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <input id="UVC" name="UVC" data-on="Yes" data-off="No" checked data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('UVCPosition','UVCPosition:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('UVCPosition',null,['class'=>'form-control']); ?>

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
                                        <?php echo Form::label('SepsisScreen','SepsisScreen:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('SepsisScreen',[''=>'N/A','Yes'=>'Yes','No'=>'No'],null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('Indications','Indications:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('Indications',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="hidden">
                                    <?php echo Form::select('IVAntibiotic',[''=>'N/A']+ValuelistHelpers::getDrugIvFluidsAntibiotic(),null,['class'=>'form-control  input-width-large']); ?>

                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('IVAntibiotic','IV Antibiotic:'); ?>

                                        <a href="javascript:void(0)" class="add_master_data" data-modal_header="Drugs & Iv Fluids" data-destination_elements="IVAntibiotic,IVAntibiotic[]" data-option_value="id" data-option_text="generic_pharmacological_name" data-mas_table="mas_drugivfluid" data-drug_type="antibiotic">
                                            <i class="fa fa-info-circle bs-tooltip" data-placement="right" data-original-title="Add Drugs & Iv Fluids"></i>
                                        </a>
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <table class="IVAntibiotic table table-add-more">
                                            <thead>                                    
                                                <tr class="master-add-header">
                                                    <th class="full-width">
                                                        <i class="fa fa-reorder"></i>Add More
                                                    </th>
                                                    <th>
                                                        <span>
                                                            <a class="btn btn-success btn-view ivantibitic_add btn_add" href="javascript:void(0);">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                        </span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(count($results->IVAntibiotic)>1): ?>
                                                <?php $__currentLoopData = $results->IVAntibiotic; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $iv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td class="full-width"><?php echo Form::select('IVAntibiotic[]',[''=>'N/A']+ValuelistHelpers::getDrugIvFluidsAntibiotic(),$iv,['class'=>'form-control full-width']); ?></td>
                                                    <td><span class="fa fa-trash btn btn-danger btn-view remove-ivantibitic"></span></td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                                <?php else: ?>
                                                <tr>
                                                    <td class="full-width"><?php echo Form::select('IVAntibiotic[]',[''=>'N/A']+ValuelistHelpers::getDrugIvFluidsAntibiotic(),'',['class'=>'form-control full-width']); ?></td>
                                                    <td><span class="fa fa-trash btn btn-danger btn-view remove-ivantibitic"></span></td>
                                                </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('investigations_test','Investigations:'); ?>

                                                <a href="javascript:void(0)" class="add_master_data" data-modal_header="Investigations" data-destination_elements="investigations_test" data-option_value="id" data-option_text="package_name" data-mas_table="mas_investigations_package">
                                                    <i class="fa fa-info-circle bs-tooltip" data-placement="right" data-original-title="Add Drugs & Iv Fluids"></i>
                                                </a>
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('investigations_test', ValuelistHelpers::get_package_investigations_master(), null,['class'=>'select2-select-00 full-width','multiple']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('Investigations','Test:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::hidden('investigation_order', null); ?>

                                        <?php echo Form::textarea('Investigations', null,['class'=>'form-control', 'rows'=>3]); ?>                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('NBM','Enteral Feeding:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('NBM',[''=>'N/A','Yes'=>'Yes','No'=>'No'],null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <?php echo Form::label('Fluids','Fluids/Feeds ml/kg/d:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('Fluids',null,['class'=>'form-control', 'onkeypress' => 'return isNumber(event, this);']); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- CRIB FORM -->
                <div role="tabpanel" class="tab-pane <?php if($active == 'Cribform'): ?> active <?php endif; ?>" id="Cribform">
                    <div class="col-md-6 col-sm-6">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <?php echo Form::label('SexBirthWtGestation','Sex,Birth Wt & Gestation:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('SexBirthWtGestation',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control" style="margin-top: 25px">
                                        <?php echo Form::label('TemperatureAtAdmission','Temperature At Admission:'); ?>

                                    </div>
                                    <?php $order_changed = \SiteHelpers::temperatureOrder(); ?>
                                    <div class="col-md-9 custom-input clear-xs">
                                        <?php if($order_changed): ?>
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <small>(In Fahrenheit)</small>
                                            </div>
                                            <div class="col-xs-6">
                                                <small>(In Celsius)</small>
                                            </div>
                                            <div class="col-xs-6">
                                                <?php echo Form::text('',null,['class'=>'form-control fahrenheit']); ?>

                                            </div>
                                            <div class="col-xs-6">
                                                <?php echo Form::text('TemperatureAtAdmission',null,['class'=>'form-control celsius celsius-type-2']); ?>

                                            </div>
                                        </div>
                                        <?php else: ?>
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <small>(In Celsius)</small>
                                            </div>
                                            <div class="col-xs-6">
                                                <small>(In Fahrenheit)</small>
                                            </div>
                                            <div class="col-xs-6">
                                                <?php echo Form::text('TemperatureAtAdmission',null,['class'=>'form-control celsius celsius-type-2']); ?>

                                            </div>
                                            <div class="col-xs-6">
                                                <?php echo Form::text('',null,['class'=>'form-control fahrenheit']); ?>

                                            </div>
                                        </div>
                                        <?php endif; ?>
                                        <label class="error help-block" for="BirthWeight" generated="true" style="display: none;"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('BaseExcess','Base Excess:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('BaseExcess',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <?php echo Form::label('TotalCRIB2Score','Total CRIB II Score:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('TotalCRIB2Score',null,['class'=>'form-control']); ?>

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
                                <img src='<?php echo e(url("public/img/crib11.png"), false); ?>'/>
                            </div>
                        </div>
                    </div>
                </div>
                <!--  SNAPPE II -->
                <div role="tabpanel" class="tab-pane <?php if($active == 'Snapform'): ?> active <?php endif; ?>" id="Snapform">
                    <div class="col-md-6 col-sm-6">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('MBP','MBP:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('MBP',[''=>'N/A','0'=>'0','9'=>'9','19'=>'19'],null,['class'=>'form-control GetSNAP2Score GetSNAPPE2Score']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <?php echo Form::label('LowestTemperature','Lowest Temperature:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('LowestTemperature',[''=>'N/A','0'=>'0','8'=>'8','15'=>'15'],null,['class'=>'form-control GetSNAP2Score GetSNAPPE2Score']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('Po2Fio2Ratio','Po2 Fio2 Ratio:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('Po2Fio2Ratio',[''=>'N/A','0'=>'0','5'=>'5','16'=>'16','28'=>'28'],null,['class'=>'form-control GetSNAP2Score GetSNAPPE2Score']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('LowestSerumPh','Lowest Serum Ph:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('LowestSerumPh',[''=>'N/A','0'=>'0','7'=>'7','16'=>'16'],null,['class'=>'form-control GetSNAP2Score GetSNAPPE2Score']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('MultipleSeizures','Multiple Seizures:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('MultipleSeizures',[''=>'N/A','0'=>'0','19'=>'19'],null,['class'=>'form-control GetSNAP2Score GetSNAPPE2Score']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('UrineOutput','Urine Output:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('UrineOutput',[''=>'N/A','0'=>'0','5'=>'5','18'=>'18'],null,['class'=>'form-control GetSNAP2Score GetSNAPPE2Score']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('BWeight','Birth Weight:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('BWeight',[''=>'N/A','0'=>'0','10'=>'10','17'=>'17'],null,['class'=>'form-control GetSNAPPE2Score']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <?php echo Form::label('SgaLessThan3rdPercentile','Small for Gestational Age:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('SgaLessThan3rdPercentile',[''=>'N/A','0'=>'0','12'=>'12'],null,['class'=>'form-control GetSNAPPE2Score']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('Apgar5Mins','Apgar5Mins:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('Apgar5Mins',[''=>'N/A','0'=>'0','18'=>'18'],null,['class'=>'form-control GetSNAPPE2Score']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <?php echo Form::label('TotalSNAP2Score','Total SNAP II Score:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('TotalSNAP2Score',null,['class'=>'form-control', 'onkeypress' => 'return ISNumber(event, this);', 'readonly']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <?php echo Form::label('TotalSNAPPE2Score','Total SNAPPE II Score:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('TotalSNAPPE2Score',null,['class'=>'form-control', 'onkeypress' => 'return ISNumber(event, this);', 'readonly']); ?>

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
                                <img src='<?php echo e(url("public/img/snapII.png"), false); ?>'/>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Diagnosis -->
                <div role="tabpanel" class="tab-pane <?php if($active == 'Diagform'): ?> active <?php endif; ?>" id="Diagform">
                    <div class="col-md-12 ">
                        <div class="form-group row mx-0">
                            <div class="mt-10 widget box col-md-12">
                                <div class="widget-header">
                                    <h4><i class="fa fa-reorder"></i> Differential Diagnosis Details</h4>
                                </div>
                                <div class="widget-content form-group row mx-0">
                                    <div class="col-md-2 text-right label-control">
                                        <?php echo Form::label('DifferentialDiagnosis','Differential Diagnosis:'); ?>

                                    </div>
                                    <div class="col-md-10 custom-input">
                                        <?php echo Form::Select('DifferentialDiagnosis[]',$ICD,null,['class'=>'select2-select-00 full-width-fix ','multiple']); ?>

                                    </div>
                                </div>
                                </div><!-- 
                                <div class="col-md-3 text-right label-control">
                                    <?php echo Form::label('DifferentialDiagnosis','Differential Diagnosis:'); ?>

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
                                            <?php echo Form::label('additional_diagnosis','Additional Diagnosis:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <table class="additional_diagnosis table table-add-more full-width-fix">
                                                <thead>                                    
                                                    <tr class="master-add-header">
                                                        <th class="full-width">
                                                            <i class="fa fa-reorder"></i>Add More
                                                        </th>
                                                        <th>
                                                            <span>
                                                                <a class="btn btn-success btn-view additional_diagnosis_add btn_add" href="javascript:void(0);">
                                                                    <i class="fa fa-plus"></i>
                                                                </a>
                                                            </span>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if(json_decode($results->additional_diagnosis) && count(json_decode($results->additional_diagnosis)) > 0): ?>
                                                    <?php $__currentLoopData = json_decode($results->additional_diagnosis); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $ad_diagnosis): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td class="full-width">
                                                            <?php echo Form::text('additional_diagnosis[]',$ad_diagnosis,['class'=>'form-control full-width']); ?>

                                                        </td>
                                                        <td><span class="fa fa-trash btn btn-danger btn-view remove-additional-diagnosis"></span></td>
                                                    </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php else: ?>                
                                                    <tr>
                                                        <td class="full-width">
                                                            <?php echo Form::text('additional_diagnosis[]','',['class'=>'form-control full-width']); ?>

                                                        </td>
                                                        <td><span class="fa fa-trash btn btn-danger btn-view remove-additional-diagnosis"></span></td>
                                                    </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            <?php echo Form::label('Plan','Plan:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::textarea('Plan',null,['class'=>'form-control editer-required','rows'=>5, 'id'=>'plan-text-box']); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control mt-0">
                                            <?php echo Form::label('ParentsSpokenTo','Parents Spoken To:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <input id="ParentsSpokenTo" name="ParentsSpokenTo" data-on="Yes" data-off="No" checked data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control" style="margin-top: 20px;">
                                            <?php echo Form::label('DiscussionTime','Time of Discussion:'); ?>

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
                                                    <?php echo Form::select('TimeOfDiscussion',$NAT['time'],(int)$results->TimeOfDiscussion,['class'=>'form-control ']); ?>

                                                </div>
                                                <div class="col-xs-4">
                                                    <?php echo Form::select('TimeOfDiscussion_MINS',$NAT['mins'],(int)$results->TimeOfDiscussion_MINS,['class'=>'form-control ']); ?>

                                                </div>
                                                <div class="col-xs-4">
                                                    <?php echo Form::select('TimeOfDiscussion_AM',[''=>'N/A','AM'=>'AM','PM'=>'PM'],$results->TimeOfDiscussion_AM,['class'=>'form-control ']); ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            <?php echo Form::label('MattersDiscussed','Matters Discussed:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::textarea('MattersDiscussed',null,['class'=>'form-control','rows'=>5]); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control mt-0">
                                            <?php echo Form::label('ParentsAddressedBy','Parents Addressed By:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::text('ParentsAddressedBy',null,['class'=>'form-control']); ?>

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
                                            <?php echo Form::label('indication_of_admission','Indication For Admission:'); ?>

                                        </div>
                                        <?php $indication_of_admission =  $results->indication_of_admission  ?>
                                        <?php $indication_of_admission1 =  in_array('1',$results->indication_of_admission) ? true : false  ?>
                                        <?php $indication_of_admission2 =  in_array('2',$results->indication_of_admission) ? true : false  ?>
                                        <?php $indication_of_admission3 =  in_array('3',$results->indication_of_admission) ? true : false  ?>
                                        <?php $indication_of_admission4 =  in_array('4',$results->indication_of_admission) ? true : false  ?>
                                        <?php $indication_of_admission5 =  in_array('5',$results->indication_of_admission) ? true : false  ?>
                                        <?php $indication_of_admission6 =  in_array('6',$results->indication_of_admission) ? true : false  ?>
                                        <?php $indication_of_admission7 =  in_array('7',$results->indication_of_admission) ? true : false  ?>
                                        <div class="col-md-9 custom-input">
                                            <div>
                                                <?php echo Form::checkbox('indication_of_admission[]',1,$indication_of_admission1); ?>

                                                <?php echo Form::label('Prematurity','Prematurity',['class'=>'title']); ?>

                                            </div>
                                            <div>
                                                <?php echo Form::checkbox('indication_of_admission[]',2,$indication_of_admission2); ?>

                                                <?php echo Form::label('Low birth weight','Low birth weight',['class'=>'title']); ?>

                                            </div>
                                            <div>
                                                <?php echo Form::checkbox('indication_of_admission[]',3,$indication_of_admission3); ?>

                                                <?php echo Form::label('RD','Respiratory Distress',['class'=>'title']); ?>

                                            </div>
                                            <div>
                                                <?php echo Form::checkbox('indication_of_admission[]',4,$indication_of_admission4); ?>

                                                <?php echo Form::label('Delayed Perinatal','Delayed Perinatal',['class'=>'title']); ?>

                                            </div>
                                            <div>
                                                <?php echo Form::checkbox('indication_of_admission[]',5,$indication_of_admission5); ?>

                                                <?php echo Form::label('Sepsis','Sepsis',['class'=>'title']); ?>

                                            </div>
                                            <div>
                                                <?php echo Form::checkbox('indication_of_admission[]',6,$indication_of_admission6); ?>

                                                <?php echo Form::label('Shock','Shock',['class'=>'title']); ?>

                                            </div>
                                            <div>
                                                <?php echo Form::checkbox('indication_of_admission[]',7,$indication_of_admission7); ?>

                                                <?php echo Form::label('Jaundice','Jaundice',['class'=>'title']); ?>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('indication_of_admission_other','Others (specify):'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::text('indication_of_admission_other',null,['class'=>'form-control shadow']); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                                  
                <div role="tabpanel" class="tab-pane" id="media_tab">
                    <input type="hidden" name="module_name" value="3">
                    <?php echo $__env->make('registration.media', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
                    <!-- Discharge -->
                    <div role="tabpanel" class="tab-pane <?php if($active == 'dischargeform'): ?> active <?php endif; ?>" id="dischargeform">
                        <div class="col-md-6 col-sm-6">
                            <div class="mt-10 widget box">
                                <div class="widget-header">
                                    <h4><i class="fa fa-reorder"></i> </h4>
                                </div>
                                <div class="widget-content">
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            <?php echo Form::label('status','Status:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::select('status',ValuelistHelpers::Discharge_Status(),null,['class'=>'form-control']); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control mt-0">
                                            <?php echo Form::label('DischargeDate','Date of Discharge / Transfered:', ['class'=>'required-label']); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php if($active == 'dischargeform'): ?>
                                            <?php echo Form::text('DischargeDate',null,['class'=>'form-control datepicker record-date', 'readonly']); ?>

                                            <?php else: ?>
                                            <?php echo Form::text('DischargeDate',null,['class'=>'form-control datepicker', 'readonly']); ?>                                            
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group row DiedTime">
                                        <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                            <?php echo Form::label('DiedTime','Time Of Death:'); ?>

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
                                                <?php echo Form::select('diedTime',$NAT['time'],null,['class'=>'form-control']); ?>

                                            </div>
                                            <div class="col-xs-4">
                                                <?php echo Form::select('diedMins',$NAT['mins'],null,['class'=>'form-control']); ?>

                                            </div>
                                            <div class="col-xs-4">
                                                <?php echo Form::select('diedAm',[''=>'N/A','AM'=>'AM','PM'=>'PM'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('DOLatDischarge','DOL at Discharge:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('DOLatDischarge',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                        <?php echo Form::label('Gestation','Gestation:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input clear-xs">
                                        <div class="row col-md-12 display-flex">
                                            <div>
                                                <small>(In Weeks)</small>
                                                <?php echo Form::text('g_weeks',null,['class'=>'form-control','max'=>'46','readonly']); ?>

                                            </div>
                                            <div class="inbeween_two_fields">
                                                <span>+</span>
                                            </div>
                                            <div>
                                                <small>(In Days)</small>
                                                <?php echo Form::text('g_days',null,['class'=>'form-control','max'=>'6','readonly']); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control" style="margin-top: 5px;">
                                        <?php echo Form::label('CorrectedGestation','Gestation at discharge (Corrected Gestational Age):'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input clear-xs">
                                        <div class="row col-md-12 display-flex">
                                            <div>
                                                <small>(In Weeks)</small>
                                                <?php if($active == 'dischargeform'): ?>
                                                <?php echo Form::text('dcg_weeks',null,['class'=>'form-control corrected-gestation-wks', 'readonly']); ?>

                                                <?php else: ?>
                                                <?php echo Form::text('dcg_weeks',null,['class'=>'form-control', 'readonly']); ?>

                                                <?php endif; ?>
                                                <label class="error help-block" for="dcg_weeks" generated="true"></label>
                                            </div>
                                            <div class="inbeween_two_fields">
                                                <span>+</span>
                                            </div>
                                            <div>
                                                <small>(In Days)</small>
                                                <?php if($active == 'dischargeform'): ?>
                                                <?php echo Form::text('dcg_days',null,['class'=>'form-control corrected-gestation-days', 'readonly']); ?>

                                                <?php else: ?>
                                                <?php echo Form::text('dcg_days',null,['class'=>'form-control', 'readonly']); ?>

                                                <?php endif; ?>
                                                <label class="error help-block" for="dcg_days" generated="true"></label> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <?php echo Form::label('DischargeWeight','Discharge Weight (In grams):', ['class'=>'required-label']); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('DischargeWeight',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('OFC','OFC in cm:', ['class'=>'required-label']); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('OFC',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('Length','Length in cm:', ['class'=>'required-label']); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('Length',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        <?php echo Form::label('Immunization','Immunization:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('Immunization',[''=>'N/A','Due'=>'Due','Given'=>'Given'],null,['class'=>'form-control','rows'=> 4,'data-color'=>ValuelistHelpers::setColorvalue('Immunization',2)]); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('Schedule','Schedule:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('Schedule',[''=>'N/A','At birth'=>'At birth','6 wks'=>'6 wks','10 wks'=>'10 wks','14 wks'=>'14 wks','6 mths'=>'6 mths','9 mths'=>'9 mths','1 year'=> '1 year','15 mths'=>'15 mths','16-18 mths'=>'16-18 mths','18 mths'=>'18 mths','2 years'=>'2 years','5 years'=>'5 years','Optional'=>'Optional','Catch Up'=>'Catch Up'],null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="hidden">
                                    <?php echo Form::select('temp_Vaccine',['N/A'=>'N/A']+ValuelistHelpers::Vaccine(),'',["class"=>"form-control "]); ?>

                                </div>
                                <div class="form-group row mx-0">
                                    <table class="vaccine table table-add-more full-width-fix">
                                        <thead class="master-add-header">
                                            <tr>
                                                <th>
                                                    Vaccine
                                                    <a href="javascript:void(0)" class="add_master_data" data-modal_header="Vaccine" data-destination_elements="temp_Vaccine,Vaccine[]" data-option_value="id" data-option_text="Name" data-mas_table="mas_vaccine">
                                                        <i class="fa fa-info-circle bs-tooltip add-neo-consultant" data-placement="right" data-original-title="Add Vaccine"></i>
                                                    </a>
                                                </th>
                                                <th>Date <i class="fa fa-info-circle bs-tooltip color-white-must" data-placement="right"
                                                    data-original-title="Date Format DD-MM-YYYY"></i></th>
                                                    <th>
                                                        <a class="btn_add btn btn-success btn-view vaccine_add" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(isset($vaccine) && count($vaccine) > 0): ?>
                                                <?php for($i = 0; $i < count($vaccine); $i++): ?>
                                                <tr>
                                                    <td class="form-group full-width"><?php echo Form::select('Vaccine[]',['N/A'=>'N/A']+ValuelistHelpers::Vaccine(),$vaccine[$i],['class'=>'select2-select-00 full-width']); ?>

                                                    </td>
                                                    <?php $vaccine_date[$i] = ($vaccine_date[$i] != 'null' && $vaccine_date[$i] != null && !@unserialize($vaccine_date[$i]) !== false) ? $vaccine_date[$i] : '' ?>
                                                    <td class="form-group"> <?php echo Form::text('VaccineDate[]',$vaccine_date[$i],['class'=>'input-width-small form-control datepicker ', 'readonly']); ?>

                                                    </td>
                                                    <td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>
                                                </tr>
                                                <?php endfor; ?>
                                                <?php else: ?>
                                                <tr>
                                                    <td class="form-group full-width"> <?php echo Form::select('Vaccine[]',['N/A'=>'N/A']+ValuelistHelpers::Vaccine(),null,['class'=>'select2-select-00 full-width']); ?>

                                                    </td>
                                                    <?php $results->VaccineDate = ($results->VaccineDate != 'null' && $results->VaccineDate != null && !@unserialize($results->VaccineDate) !== false) ? $results->VaccineDate : '' ?>
                                                    <td class="form-group" colspan="2"> <?php echo Form::text('VaccineDate[]',null,['class'=>'input-width-small form-control datepicker ', 'readonly']); ?>

                                                    </td>
                                                </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            <?php echo Form::label('additional_information', 'Additional Information:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::textarea('additional_information', null, ['class'=>'form-control', 'rows'=>'8']); ?>

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
                                            <?php echo Form::label('Eyes','Eyes:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::select('Eyes',[''=>'N/A','Normal with Red reflex'=>'Normal with Red reflex','Subconjunctival Hemorrhage'=>'Subconjunctival Hemorrhage','Cataract'=>'Cataract','Microophthalmos'=>'Microophthalmos'],null,['class'=>'form-control']); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control md-mt-50">
                                            <?php echo Form::label('cardiacmurmur', 'Cardiac Murmur'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::select('cardiacmurmur',[''=>'N/A','Absent'=>'Absent','Present'=>'Present'], null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('HearingScreening',2)]); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control mt-0">
                                            <?php echo Form::label('PostductalSaturation','Postductal(SPO2 %):'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::text('PostductalSaturation',null,['class'=>'form-control']); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            <?php echo Form::label('discharge_femoral_pulses','Femoral:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::select('discharge_femoral_pulses',[''=>'N/A','Normal'=>'Normal','Bounding'=>'Bounding','Feeble/Weak'=>'Feeble/Weak','Absent'=>'Absent'],null,['class'=>'form-control']); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control md-mt-50">
                                            <?php echo Form::label('Hips','Hips:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::select('Hips',[''=>'N/A','Normal'=>'Normal','DDH Rt'=>'DDH Rt','DDH Lt'=>'DDH Lt','DDH Bilateral'=>'DDH Bilateral'],null,['class'=>'form-control']); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control md-mt-50">
                                            <?php echo Form::label('gentila','Genitalia:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::select('gentila',ValuelistHelpers::getGentila(),null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('gentila',2)]); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            <?php echo Form::label('gentila_findings', 'Genitalia Findings:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::text('gentila_findings',null,['class'=>'form-control']); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control md-mt-50">
                                            <?php echo Form::label('nicu_malformation','Malformation:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::select('nicu_malformation',['No'=>'No','Yes'=>'Yes'],null,['class'=>'form-control']); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            <?php echo Form::label('nicu_malformation_details','Malformation Details:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::textarea('nicu_malformation_details',null,['class'=>'form-control','rows'=>'5']); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control mt-0">
                                            <?php echo Form::label('FeedingAtDischarge','Feeding At Discharge:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::select('FeedingAtDischarge',ValuelistHelpers::feedingDischarge(),null,['class'=>'form-control','rows' => 4]); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control md-mt-50">
                                            <?php echo Form::label('NeurologicalStatus','Neurological Status:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::select('NeurologicalStatus',[''=>'N/A','Normal'=>'Normal','Suspect'=>'Suspect','Abnormal'=>'Abnormal'],null,['class'=>'form-control','rows'=>5,'data-color'=>ValuelistHelpers::setColorvalue('NeurologicalStatus',2)]); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control mt-0">
                                            <?php echo Form::label('NextAppointmentStatus','Next Appointment:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <input id="NextAppointmentStatus" name="NextAppointmentStatus" data-on="Yes" data-off="No" checked data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control mt-0">
                                            <?php echo Form::label('NextAppointment','Next Appointment Date:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::text('NextAppointment',null,['class'=>'form-control datepicker', 'readonly']); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row NextAppointmentTime">
                                        <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                            <?php echo Form::label('NextAppointmentTime','Next Appointment Time:'); ?>

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
                                                    <?php echo Form::select('NAT_TIME',$NAT['time'],null,['class'=>'form-control']); ?>

                                                </div>
                                                <div class="col-xs-4">
                                                    <?php echo Form::select('NAT_MINS',$NAT['mins'],null,['class'=>'form-control']); ?>

                                                </div>
                                                <div class="col-xs-4">
                                                    <?php echo Form::select('NAT_AM',[''=>'N/A','AM'=>'AM','PM'=>'PM'],null,['class'=>'form-control']); ?>

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
                                    <a href="javascript:void(0)" class="add_master_data" data-modal_header="Drugs & Iv Fluids" data-destination_elements="temp_drugs,M_Drugs[]" data-option_value="id" data-option_text="brand_name" data-mas_table="mas_drugivfluid" data-drug_type="oral">
                                        <i class="fa fa-info-circle bs-tooltip" data-placement="right" data-original-title="Add Drugs & Iv Fluids"></i>
                                    </a>
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
                                            <th>
                                                <span>
                                                    <a class="btn btn-success btn-view drugs_add btn_add pull-right" href="javascript:void(0);">
                                                        <i class="fa fa-plus"></i>
                                                    </a>
                                                </span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $mas_frequency_list = ValuelistHelpers::drugFrequencyList(); ?>
                                        <div class="hidden">
                                            <?php echo Form::select('temp_drugs',$drug_master,''); ?>

                                            <?php echo Form::select('temp_frequency',$mas_frequency_list,null); ?>

                                            <?php echo Form::select('temp_does',[''=>'N/A']+ValuelistHelpers::dose(),''); ?>

                                            <?php echo Form::select('temp_duration',[''=>'N/A']+ValuelistHelpers::medicationDuration(),''); ?> 
                                        </div>
                                        <?php if(isset($medications) && (count($medications) > 0)): ?>
                                        <?php $l = 0; ?>
                                        <?php $__currentLoopData = $medications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $medi_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo Form::select('M_Drugs[]',$drug_master,$medi_data['Medication'],['class'=>'drugs-changes drug-list-name'.$l,'data-id'=>$l, 'style'=>'width: 300px;']); ?></td>
                                            <td><?php echo Form::text('m_generic_name[]',$medi_data['genericname'],['class'=>'form-control generic_name'.$l]); ?></td>
                                            <td><?php echo Form::select('formulation[]',ValuelistHelpers::formulationStrength($medi_data['formulation']),$medi_data['formulation'],['class'=>'form-control formulation'.$l]); ?></td>
                                            <td class="input-width-medium"><?php echo Form::select('M_Dose[]',[''=>'N/A']+ValuelistHelpers::dose(),$medi_data['Dose'],['class'=>'form-control']); ?></td>
                                            <td class="input-width-medium"><?php echo Form::select('M_Frequency[]',$mas_frequency_list,$medi_data['Frequency'],['class'=>'form-control']); ?></td>
                                            <td class="input-width-medium">
                                                <?php echo Form::select('M_Duration[]',[''=>'N/A']+ValuelistHelpers::medicationDuration(),$medi_data['Duration'],['class'=>'form-control']); ?>

                                            </td>
                                            <td>
                                                <span class="fa fa-trash btn btn-danger btn-view remove"></span>
                                            </td>
                                        </tr>
                                        <?php $l++; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                        <tr>
                                            <td>
                                                <?php echo Form::select('M_Drugs[]',$drug_master,'',['class'=>'drugs-changes drug-list-name0','data-id'=>'0', 'style'=>'width: 300px;']); ?>

                                            </td>
                                            <td>
                                                <?php echo Form::text('m_generic_name[]',null,['class'=>'form-control generic_name0']); ?>

                                            </td>
                                            <td class="input-width-medium">
                                                <?php echo Form::select('formulation[]',$drug_value,null,['class'=>'form-control formulation0']); ?>

                                            </td>
                                            <td class="input-width-medium">
                                                <?php echo Form::select('M_Dose[]',[''=>'N/A']+ValuelistHelpers::dose(),null,['class'=>'form-control']); ?>

                                            </td>
                                            <td class="input-width-medium">
                                                <?php echo Form::select('M_Frequency[]',$mas_frequency_list,null,['class'=>'form-control']); ?>

                                            </td>
                                            <td><?php echo Form::select('M_Duration[]',[''=>'N/A']+ValuelistHelpers::medicationDuration(),null,['class'=>'form-control']); ?></td>
                                            <td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>
                                        </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane <?php if($active == 'Checkform'): ?> active <?php endif; ?>" id="Checkform">
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
                                            <?php echo Form::label('DischargeHb','Hb(g/dl):'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::text('DischargeHb',null,['class'=>'form-control']); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            <?php echo Form::label('DischargePCV','PCV:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::text('DischargePCV',null,['class'=>'form-control']); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            <?php echo Form::label('NicuDCT','DCT:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::text('NicuDCT',null,['class'=>'form-control']); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control mt-0">
                                            <?php echo Form::label('DischargeTSB','Total Serum Bilirubin (mg/dl):'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::text('DischargeTSB',null,['class'=>'form-control']); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control mt-0">
                                            <?php echo Form::label('direct_bilirubin','Direct Bilirubin (mg/dl):'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::text('direct_bilirubin',null,['class'=>'form-control']); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            <?php echo Form::label('DischargeSerumCa','Ca (mg/dl):'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::text('DischargeSerumCa',null,['class'=>'form-control']); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            <?php echo Form::label('DischargeSerumPo4','Po4 (mg/dl):'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::text('DischargeSerumPo4',null,['class'=>'form-control']); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            <?php echo Form::label('DischargeSerumALP','ALP (IU/L):'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::text('DischargeSerumALP',null,['class'=>'form-control']); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            <?php echo Form::label('DischargeSerumNa','Na (mmol/l):'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::text('DischargeSerumNa',null,['class'=>'form-control']); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control md-mt-50">
                                            <?php echo Form::label('HomeOxygen','Home Oxygen:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::select('HomeOxygen',[''=>'N/A','Yes'=>'Yes','No'=>'No'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('HomeOxygen',2)]); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control md-mt-50">
                                            <?php echo Form::label('discharge_cuss','Cranial Ultrasound:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::select('discharge_cuss',[''=>'N/A','Normal'=>'Normal','Abnormal'=>'Abnormal','Not Indicated'=>'Not Indicated'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('DischargeCUSS',2)]); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control md-mt-50">
                                            <?php echo Form::label('cranial_ultrasound', 'Cranial Ultrasound:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::textarea('cranial_ultrasound', null,['class'=>'form-control','rows'=>'5','cols'=>'5']); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            <?php echo Form::label('echocardiography_status','Echo Cardiography:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::select('echocardiography_status',[''=>'N/A','Normal'=>'Normal','Abnormal'=>'Abnormal','Not Indicated'=>'Not Indicated'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('DischargeCUSS',2)]); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            <?php echo Form::label('echocardiography', 'Echo Cardiography:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::textarea('echocardiography', null,['class'=>'form-control','rows'=>'5','cols'=>'5']); ?>

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
                                        <div class="col-md-3 text-right label-control md-mt-50">
                                            <?php echo Form::label('NicuNewBornScreen','Newborn Screen:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::select('NicuNewBornScreen',[""=>"N/A",'Sent' => 'Sent','Not Sent'=>'Not
                                            Sent','Normal'=>'Normal','Abnormal'=>'Abnormal'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('NicuNewBornScreen',2)]); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control md-mt-50">
                                            <?php echo Form::label('HearingScreening','Hearing Screening:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::select('HearingScreening',[''=>'N/A','Performed' => 'Performed','To be performed as outpatient' => 'To be performed as outpatient','Not Indicated' => 'Not Indicated'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('HearingScreening',2)]); ?>

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
                                                        <td><?php echo Form::select('oae_left', [''=>'N/A', 'Normal'=>'Normal', 'Suspect'=>'Suspect'],null,['class'=>'form-control hearing-screen-type-value']); ?></td>
                                                        <td><?php echo Form::select('oae_right', [''=>'N/A', 'Normal'=>'Normal', 'Suspect'=>'Suspect'],null,['class'=>'form-control hearing-screen-type-value']); ?></td>
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
                                                        <td><?php echo Form::select('abr_left', [''=>'N/A', 'Normal'=>'Normal', 'Suspect'=>'Suspect'],null,['class'=>'form-control hearing-screen-type-value']); ?></td>
                                                        <td><?php echo Form::select('abr_right', [''=>'N/A', 'Normal'=>'Normal', 'Suspect'=>'Suspect'],null,['class'=>'form-control hearing-screen-type-value']); ?></td>
                                                    </tr>
                                                </tbody>
                                            </table> 
                                        </div>
                                    </div> 
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control md-mt-50">
                                            <?php echo Form::label('RopScreening','ROP Screening:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::select('RopScreening',[""=>"N/A",'Performed' => 'Performed','To be performed as outpatient' => 'To be performed as outpatient','Not Indicated' => 'Not Indicated'],null,['class'=>'form-control']); ?>

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
                                                        <td><?php echo Form::select('result_rop_left',ValuelistHelpers::RopScreening(),null,['class'=>'form-control rop-results-type']); ?></td>
                                                        <td><?php echo Form::select('result_rop_right',ValuelistHelpers::RopScreening(),null,['class'=>'form-control rop-results-type']); ?></td>
                                                    </tr>
                                                </tbody>
                                            </table> 
                                        </div>
                                    </div> 
                                    <div class="form-group rop-results">
                                        <div class="col-md-3 text-right label-control md-mt-50">
                                            <?php echo Form::label('ROPTreatment','ROP Treatment:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::select('ROPTreatment',ValuelistHelpers::commonValues(),null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('ROPTreatment',2)]); ?>

                                        </div>
                                    </div>
                                    <div class=" hidden">
                                        <?php echo Form::select('TypeofTreatmentemp',[''=>'N/A','Laser'=>'Laser','Cryotherapy'=>'Cryotherapy','Surgical'=>'Surgical'],null); ?>

                                    </div>
                                    <div class="form-group row rop_treatment">
                                        <div class="col-md-12 custom-input">
                                            <table class="TypeofTreatmenDiv table table-add-more full-width-fix">
                                                <thead>
                                                    <tr class="master-add-header"> 
                                                        <th>Type of Treatment Left:</th>
                                                        <th>Type of Treatment Right:</th>
                                                        <th>
                                                            <span>
                                                                <a class="btn_add btn btn-success btn-view typeoftreatment_add" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                                                            </span>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <?php $results->typeoftreatment_left = isset($results->typeoftreatment_left) ? json_decode($results->typeoftreatment_left) : null ;  ?>
                                                <?php $results->typeoftreatment_right = isset($results->typeoftreatment_right) ? json_decode($results->typeoftreatment_right) : null ;  ?>
                                                <tbody>
                                                    <?php if(count($results->typeoftreatment_left) > 0): ?>  
                                                    <?php $rop = 0; ?>
                                                    <?php $__currentLoopData = $results->typeoftreatment_left; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $typeoftreatment_left): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo Form::select('typeoftreatment_left['.$key.']',[''=>'N/A','Laser'=>'Laser','Cryotherapy'=>'Cryotherapy','Surgical'=>'Surgical'],$typeoftreatment_left,['class'=>'form-control rop_treatment-type','id'=>'typeoftreatment_left','data-color'=>ValuelistHelpers::setColorvalue('TypeofTreatmen',2)]); ?> </td>
                                                        <td><?php echo Form::select('typeoftreatment_right['.$key.']',[''=>'N/A','Laser'=>'Laser','Cryotherapy'=>'Cryotherapy','Surgical'=>'Surgical'],$results->typeoftreatment_right[$rop],['class'=>'form-control rop_treatment-type','id'=>'typeoftreatment_right','data-color'=>ValuelistHelpers::setColorvalue('TypeofTreatmen',2)]); ?></td>
                                                        <td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>
                                                    </tr>
                                                    <?php $rop++; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php else: ?>
                                                    <tr>
                                                        <td><?php echo Form::select('typeoftreatment_left[]',[''=>'N/A','Laser'=>'Laser','Cryotherapy'=>'Cryotherapy','Surgical'=>'Surgical'],null,['class'=>'form-control rop_treatment-type','id'=>'typeoftreatment_left','data-color'=>ValuelistHelpers::setColorvalue('TypeofTreatmen',2)]); ?> </td>
                                                        <td><?php echo Form::select('typeoftreatment_right[]',[''=>'N/A','Laser'=>'Laser','Cryotherapy'=>'Cryotherapy','Surgical'=>'Surgical'],null,['class'=>'form-control rop_treatment-type','id'=>'typeoftreatment_right','data-color'=>ValuelistHelpers::setColorvalue('TypeofTreatmen',2)]); ?></td>
                                                        <td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>
                                                    </tr>
                                                    <?php endif; ?> 
                                                </tbody>
                                            </table> 
                                        </div>
                                    </div>
                                    <div class="form-group row rop-results">
                                        <div class="col-md-3 text-right label-control md-mt-50">
                                            <?php echo Form::label('rop_follow_up','ROP Follow Up:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::select('rop_follow_up',['1'=>'No','2'=>'Yes'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('rop_follow',2)]); ?>

                                        </div>
                                    </div>
                                    <div class="hidden">
                                        <?php echo Form::select('temp_procedures', [''=>'N/A']+$procedure_master, null,['class'=>'form-control']); ?>

                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            <?php echo Form::label('procedures', 'Procedures :'); ?>

                                            <a href="javascript:void(0)" class="add_master_data" data-modal_header="Procedures" data-destination_elements="temp_procedures,procedures[]" data-option_value="Id" data-option_text="Name" data-mas_table="mas_procedures">
                                                <i class="fa fa-info-circle bs-tooltip" data-placement="right" data-original-title="Add Procedures"></i>
                                            </a>
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <table class="procedure-list table table-add-more full-width-fix">
                                                <thead>                                    
                                                    <tr class="master-add-header">
                                                        <th class="full-width">
                                                            <i class="fa fa-reorder"></i>Add More
                                                        </th>
                                                        <th>
                                                            <span>
                                                                <a class="btn btn-success btn-view procedure_add btn_add" href="javascript:void(0);">
                                                                    <i class="fa fa-plus"></i>
                                                                </a>
                                                            </span>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if(json_decode($results->procedures) > 0): ?>  
                                                    <?php $__currentLoopData = json_decode($results->procedures); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $procedures): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>   
                                                    <tr>
                                                        <td><?php echo Form::select('procedures[]', [''=>'N/A']+$procedure_master, $procedures,['class'=>'form-control']); ?></td>
                                                        <td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>
                                                    </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>    
                                                    <?php else: ?>
                                                    <tr>
                                                        <td><?php echo Form::select('procedures[]', [''=>'N/A']+$procedure_master, null,['class'=>'form-control']); ?></td>
                                                        <td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>
                                                    </tr>
                                                    <?php endif; ?> 
                                                </tbody>
                                            </table> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    <?php echo Form::label('advice', 'Advice:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">
                                    <?php echo Form::textarea('advice', null,['class'=>'form-control','rows'=>'5','cols'=>'5']); ?>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    <?php echo Form::label('plan_follow_up', 'Plan For Follow Up:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">
                                    <?php echo Form::textarea('plan_follow_up', null,['class'=>'form-control','rows'=>'5','cols'=>'5']); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo e(Form::hidden('module', @$active), false); ?>

                    <?php echo e(Form::hidden('formstatus', 1), false); ?>

                    <!-- NewBorn Examination -->
                    <div class="col-md-11 col-sm-12 col-xs-12">
                        <input type="hidden" name="print_flag" value="0" id="print_flag"/>
                        <?php if(!isset($flow_wise_register) || empty($flow_wise_register) || $flow_wise_register != 'from-dashboard'): ?>  
                            <?php if(!Session::has('registration_start')): ?>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <button type="submit" class="btn btn-primary btn-block save-button-shadow form-control nicu_admission_create">
                                    <i class="fa fa-floppy-o"></i> 
                                    <span><?php echo $SubmitButtonText; ?></span>
                                </button>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <button type="button" class="btn btn-block btn-info save-button-shadow form-control nicu_admission_create" data-flag="2">
                                    <i class="fa fa-floppy-o"></i>
                                    <span>Update</span>
                                </button>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <button type="button" class="btn btn-info btn-block save-button-shadow form-control nicu_admission_create" data-flag="1">
                                    <i class="fa fa-print"></i>
                                    <span>Print</span>
                                </button>
                                   <!--  <button type="button" class="btn btn-info save-button-shadow" onclick="$('#print_flag').val('11'); $(form).submit();">
                                        <i class="fa fa-print"></i>
                                        <span>Problem Print</span>
                                    </button> -->
                            </div>
                            <?php else: ?>
                            
                            <input type="hidden" name="admission_tag" value="0" id="admission_tag"/>
                            <?php if(\Session::has('multiple_pregnancy')): ?>
                            <input type="hidden" name="multiple_pregnancy" value="<?php echo e(\Session::has('multiple_pregnancy'), false); ?>">
                            <?php endif; ?>
                            <div class="col-md-3 col-sm-4 col-xs-12">
                                <button type="button" class="btn btn-block save-next save-button-shadow btn-info form-control">
                                <i class="fa fa-floppy-o"></i><span> Next</span>
                                </button>
                            </div>
                            <div class="col-md-3 col-sm-4 col-xs-12 print-summary  <?php if(isset($_COOKIE['nicuform']) && $_COOKIE['nicuform'] != 'Checkform'): ?> hide <?php endif; ?>">
                                <button type="button" class="btn btn-block go-to-summary  save-button-shadow btn-info form-control"> <i class="fa fa-floppy-o"></i>
                                    <span>  Print Summary</span>
                                </button>
                            </div>
                            <?php endif; ?>
                            <?php if($active == 'dischargeform' || $active == 'Checkform'): ?> 
                            <div class="col-md-3 <?php if(!Session::has('registration_start')): ?> col-sm-6 col-xs-12 <?php else: ?> col-sm-4 col-xs-12 <?php endif; ?>">
                                <a href="<?php echo e(action('Admission\NicuController@dischargeList'), false); ?>/discharged" class="btn btn-default save-button-shadow btn-block form-control" onclick="$('form')[0].reset();">
                                    <i class="fa fa-exclamation-circle"></i> 
                                    <span>Cancel</span>
                                </a>
                            </div>
                            <?php else: ?>
                            <div class="col-md-3 <?php if(!Session::has('registration_start')): ?> col-sm-6 col-xs-12 <?php else: ?> col-sm-4 col-xs-12 <?php endif; ?>">
                                <a href="<?php echo e(action('Admission\NicuController@index'), false); ?>" class="btn btn-default save-button-shadow btn-block form-control" onclick="$('form')[0].reset();">
                                    <i class="fa fa-exclamation-circle"></i> 
                                    <span>Cancel</span>
                                </a>
                            </div>
                            <?php endif; ?> 
                        <?php else: ?>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <button type="button" class="btn btn-block btn-primary save-button-shadow form-control nicu_admission_create" data-flag="2">
                                    <i class="fa fa-floppy-o"></i>
                                    <span> Update</span>
                                </button>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <button type="button" class="btn btn-block btn-info flow-next-btn save-button-shadow form-control nicu_admission_create" data-flag="8">
                                    <i class="fa fa-floppy-o"></i>
                                    <span> Next</span>
                                </button>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12 hide">
                                <button type="button" class="btn btn-block btn-primary flow-finish-btn save-button-shadow form-control nicu_admission_create" data-flag="9">
                                    <i class="fas fa-bed"></i>
                                    <span>Finish</span>
                                </button>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <a href="<?php echo e(action('Admission\NicuController@index'), false); ?>" class="btn btn-default save-button-shadow btn-block form-control" onclick="$('form')[0].reset();">
                                    <i class="fa fa-exclamation-circle"></i> 
                                    <span>Cancel</span>
                                </a>
                            </div>
                        <?php endif; ?>  
                    </div>
                </div>
            </div>
            <?php echo Form::close(); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">
    <?php if(isset($flow_wise_register) && !empty($flow_wise_register) && $flow_wise_register == 'from-dashboard'): ?>
        var current_tab = $('#admissionProforma-form .nav.nav-tabs li[class="active"]').children('a').attr('aria-controls');
        if (current_tab == 'Diagform') {
            $('.flow-finish-btn').parent().removeClass('hide');
            $('.flow-next-btn').parent().addClass('hide');
            $('input[name="formstatus"]').val(1);
        }
        $('#admissionProforma-form .nav.nav-tabs li').click(function()
        {
            var current_tab = $(this).children('a').attr('aria-controls');
            if (current_tab == 'Diagform') {
                $('.flow-finish-btn').parent().removeClass('hide');
                $('.flow-next-btn').parent().addClass('hide');
                $('input[name="formstatus"]').val(2);
            }
            else
            {
                $('.flow-finish-btn').parent().addClass('hide');
                $('.flow-next-btn').parent().removeClass('hide');
                $('input[name="formstatus"]').val(1);
            }
        });
    <?php endif; ?>
$(document).ready(function () {
    $('.multiple-preg').click(function () {
        $('.multiple-preg').each(function () {
            if ($(this).hasClass('btn-success')) {
                $(this).removeClass('btn-success').addClass('btn-primary');
            }
        });
        var wardAdmission = $(this).text();
        var buttonClass = $(this);

        $(this).addClass('btn-success');
        $('#multiple-preg-admission').modal('hide');
        $('input[name="admission_tag"]').val($(this).val());


        bootbox.confirm({
            title: "Multiple Admission Confirmation",
            message: "Are you sure want admit in " + wardAdmission + "?",
            className: "multiple-admission-confirmation",
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> Cancel',
                    className: 'save-button-shadow'
                },
                confirm: {
                    label: '<i class="fa fa-check"></i> Confirm',
                    className: 'save-button-shadow btn-success'
                }
            },
            callback: function (confirmed) {
                if (confirmed) {
                    $('#admissionProforma-form').submit();
                } else {
                    $('#multiple-preg-admission').modal({
                        backdrop: 'static',
                        show: true
                    });
                }
            }
        });
    });

});


$("form").sisyphus({
    customKeySuffix: "nicu",
    locationBased: true
});

$('.save-next').click(function (e) {
    if ($('#admissionProforma-form').valid() === true) {
        e.preventDefault();

        var next_tab = $('.nav-tabs > .active').next('li').find('a');

        if (next_tab.length > 0) {
            next_tab.trigger('click');
        } else {
            if ($('.save-next').hasClass('next-baby')) {
                $('input[name="print_flag"]').val(8);
                $('#multiple-preg-admission').modal({
                    backdrop: 'static',
                    show: true
                });
            } else {
                $('#admissionProforma-form').submit();
            }
        }

        var tab_id = $('.tab-pane.active').attr('id');
        var multiple_pregnancy = $('input[name="multiple_pregnancy"]').val();

        if (multiple_pregnancy && typeof multiple_pregnancy != 'undefined' && (tab_id == 'Diagform' || tab_id == 'Checkform')) {
            $('.save-next').addClass('next-baby');
            $('.save-next').html('<i class="fa fa-floppy-o"></i><span> Next Baby</span>');
        } else if (!multiple_pregnancy && typeof multiple_pregnancy == 'undefined' && (tab_id == 'Diagform' || tab_id == 'Checkform')) {
            $('.save-next').html('<i class="fa fa-floppy-o"></i><span> Finish</span>');
        } else {
            $('.save-next').html('<i class="fa fa-floppy-o"></i><span> Next</span>');
        }
    }

   
    // var menuActive = $('.nav-tabs li[class="active"]').next('li').children('a').attr('aria-controls');
    // moveNext($('.nav-tabs li[class="active"]').children('a').attr('aria-controls'));
    // setNextmenu(menuActive);

    // if ($('.save-next').hasClass('next-baby')) {
    //     $('input[name="print_flag"]').val(8);
    //     $('#multiple-preg-admission').modal({backdrop: 'static', show: true });
    // } else {
    //     $('#admissionProforma-form').submit();
    // }

});

$('.nav-tabs li a').click(function (e) {
    if ($("#admissionProforma-form").valid() === false) {
        $("#admissionProforma-form").valid();
        return false;
    }
    // submitForm();
    // var inputs = $("#" + current_form).find("select, textarea, input").checkValidity();
    $("#admissionProforma-form").validate({
        submitHandler: function (form) {
            form.submit();
        }
    });
    // var inputs = $("#admissionProforma-form").checkValidity();
    // if (input) {
    //     alert('sdgdf');
    // }
    // else
    // {
    //     alert('lkdghldhb');
    //     return false;
    // }

    $.cookie('nicuform', $(this).attr('aria-controls'), {
        path: '/'
    });

    <?php if(Session::has('registration_start')): ?>
    setNextmenu($(this).attr('aria-controls'));
    moveNext($(this).attr('aria-controls'));
    <?php endif; ?>
});

<?php if(Session::has('registration_start')): ?>

function setNextmenu(menuActive) {
    $.cookie('nicuform', menuActive, {
        path: '/'
    });
}

function moveNext(menuActive) {

    if (menuActive == 'Diagform' || menuActive == 'Checkform') {

        if (menuActive == 'Checkform') {
            $('.print-summary').removeClass('hide');
        }

        $('input[name="print_flag"]').val(0);
        $('.save-next > span').text('Finish');
        $.cookie("nicuform", '', {
            expires: -1
        });

    } else {
        $('input[name="print_flag"]').val(2);
        $('.save-next > span').text('Next');
        $('.print-summary').addClass('hide');
    }
}

$('.go-to-summary').click(function () {
    var menuActive = $('.nav-tabs li[class="active"]').next('li').children('a').attr('aria-controls');
    moveNext($('.nav-tabs li[class="active"]').children('a').attr('aria-controls'));
    setNextmenu(menuActive);

    $('input[name="print_flag"]').val(7);
    $('#admissionProforma-form').submit();

});

<?php endif; ?>


<?php if(Session::has('slug-nav')): ?>
$('#DischargeDate').change(function () {
    // dischargeCorrectedGestation()
});
// function dischargeCorrectedGestation()
// {
//     var dischargeDate = $('#DischargeDate').datepicker("getDate");
//     var dob = $('#DOB').datepicker('getDate');
//     var days = calculateDays(dob, dischargeDate);

//     var gestationWeeks = $('input[name="g_weeks"]').val();
//     var gestationDays = $('input[name="g_days"]').val();
//     $('#DOLatDischarge').val(days);
//     if (gestationWeeks < 37) {

//         if (gestationDays == '' || !gestationDays) {
//             gestationDays = 0;
//         }
//         var corrected_gestation_days = ((40 - parseInt(gestationWeeks)) * 7) + parseInt(gestationDays);
//         corrected_gestation_days = days - corrected_gestation_days;
//         if (corrected_gestation_days > 0) {
//             var correctedWeeks = parseInt(parseInt(corrected_gestation_days) / 7);
//             var correctedDays = parseInt(parseInt(corrected_gestation_days) % 7);
//             if (!isNaN(correctedWeeks) && !isNaN(correctedDays)) {
//                 $('input[name=dcg_weeks]').val(correctedWeeks);
//                 $('input[name=dcg_days]').val(correctedDays);
//             }
//         }
//         else
//         {
//             $('input[name=dcg_weeks]').val('');
//             $('input[name=dcg_days]').val('');
//         }
//     }
//     else
//     {
//         $('input[name=dcg_weeks]').val('');
//         $('input[name=dcg_days]').val('');
//     }
// }
$('#DischargeDate').trigger('change');
<?php endif; ?>

// var check_age_on_admission = $('.age-on-admission-days').val();
// if (check_age_on_admission == '' || check_age_on_admission == null) {
//     var baby_dob = $('#DOB').val();
//     var admission_date = $('.admission-date').val();
//     console.log(baby_dob + " DOB");

//     var date1 = new Date(baby_dob);
//     var date2 = new Date(admission_date);
//     const oneDay = 24 * 60 * 60 * 1000;
//     // var diffTime = Math.abs(date2 - date1);
//     var diffDays = Math.round(Math.abs((date2 - date1) / oneDay));
//     // var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
//     // console.log(diffTime + " milliseconds");
//     console.log(diffDays + " days");
// }


$(document).on('click', '.dob_date', function (e) {
    e.preventDefault();
    return false;
});
calculateAgeonadmission();

function calculateAgeonAdmissionHour() {
    var admissionDate = $('input[name="AdmissionDate"]').val();
    var admissionTime = $('select[name="AdmissionTime"]').val();
    var admissionMins = $('select[name="AdmissionTime_MINS"]').val();
    var admissionSession = $('select[name="AdmissionTime_AM"]').val();
    var babyId = $('input[name="BabyId"]').val();

    $.ajax({
        Type: 'GET',
        url: '<?php echo e(action("Admission\NicuController@getageonadmission"), false); ?>',
        data: {
            babyId: babyId,
            admissionDate: admissionDate,
            admissionTime: admissionTime,
            admissionMins: admissionMins,
            admissionSession: admissionSession
        },
        success: function (responseText) {

            if (responseText.age_on_admission < 96) {
                $('#AgeOnAdmissionhour').val(responseText.age_on_admission);
                $('.age_on_admission_hours').show();
                $('.age_on_admission_days').hide();
            } else {
                // calculateAgeonadmission();
                $('.age_on_admission_hours').hide();
                $('.age_on_admission_days').show();
            }
        },
        error: function (responseText) {

        }


    })

}
// calculateAgeonAdmissionHour();
$(document).on('click', '.nicu_admission_create', function (e) {
    if ($('#admissionProforma-form').valid() === true) {
        e.preventDefault();
        var print_flag = $(this).data('flag');
        $('#print_flag').val(print_flag);
        $('.nicu_admission_create').prop('disabled', true);
        var current_clicked_element = $(this);
        var current_clicked_html = $(this).html();
        $(this).html('<i class="fas fa-spinner fa-pulse"></i> Loading...');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            data: $('#admissionProforma-form input, #admissionProforma-form select, #admissionProforma-form textarea').serialize(),
            url: "<?php echo e(action('Admission\NicuController@update', $results->NicuId), false); ?>",
            success: function (response) {
                if (print_flag == 1) {
                    Showalert('success', 'NICU admission updated successfully');
                    window.location.href = response.print_url;
                }
                else if (print_flag == 2) {
                    $('.nicu_admission_create').prop('disabled', false);
                    Showalert('success', 'NICU admission details updated successfully');
                    // window.location.href = response.edit_url;
                    current_clicked_element.html('<i class="fa fa-floppy-o" aria-hidden="true"></i> <span>Update</span>');
                }
                else if (print_flag == 8) {
                    Showalert('success', 'NICU admission updated successfully');
                    $('.nicu_admission_create').prop('disabled', false);
                    current_clicked_element.html('<i class="fa fa-floppy-o" aria-hidden="true"></i><span> Next</span>');

                    var next_tab = $('#admissionProforma-form > .active').next('li').find('a');
                    if(next_tab.length>0){
                        next_tab.trigger('click');
                    }else{
                        var sub_next_tab = $('#admissionProforma-form .nav-tabs > .active').next('li').find('a');
                        if(sub_next_tab.length>0){
                            sub_next_tab.trigger('click');
                            current_clicked_element.css('opacity', '1');
                        }
                        else
                        {
                            current_clicked_element.css('opacity', '0.5');
                        }

                    }
                    $("html, body").animate({ scrollTop: 0 }, 500);
                }
                else if (print_flag == 9) {
                    Showalert('success', 'NICU admission updated successfully');
                    window.location.href = response.ward_dashboard_url;
                }
                else {
                    Showalert('success', 'NICU admission updated successfully');
                    window.location.href = response.list_url;
                }


            },
            error: function () {
                Showalert('error', 'Something went wrong, Please try again later...!');
                $('.nicu_admission_create').prop('disabled', false);
                current_clicked_element.html(current_clicked_html);
            }
        });
    }
});


function submitForm() {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: $('#admissionProforma-form input, #admissionProforma-form select, #admissionProforma-form textarea').serialize(),
        url: "<?php echo e(action('Admission\NicuController@update', $results->NicuId), false); ?>",
        success: function (response) {

        },
        error: function () {

        }
    });
}
$('select[name="room_id"]').trigger('change');
</script>
<?php echo $__env->make('admission.nicu.nicu_scripts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<script type="text/javascript">
    // calculateCorrectedGestation();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>