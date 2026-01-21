<?php $__env->startSection('content'); ?>
<?php
$specialPermission = \Session::get('specialPermissions');
// if (!isset($_COOKIE['daycare'])) {
    $_COOKIE['daycare'] ='generalform';
    // }
    ?>
    <!-- Breadcrumbs line -->
    <div class="crumbs bread-crumbs-shadow">
        <ul id="breadcrumbs" class="breadcrumb">
            <li>
                <a href="<?php echo e(url('/'), false); ?>"><i class="fa fa-home"></i></a>
            </li>
            <li class="">
                <a title="" href="<?php echo e(action('Admission\DaycareController@index'), false); ?>">Daycare</a>
            </li>
            <li class="">
                <a title="" href="<?php echo e(url('daycare-admission/daycare-baby-admissionlist/'.\SiteHelpers::encrypt_id($results->BabyId)), false); ?>">Admission List</a>
            </li>
            <li class="">
                <a title="" href="<?php echo e(url('daycare-admission/daycare-admission-daylist/'.\SiteHelpers::encrypt_id($results->AdmissionId)), false); ?>">Day List</a>
            </li>
            <li class="current">
                <a title="">Edit <?php if(isset($results->BabyName) && !empty($results->BabyName)): ?> For <?php echo e($results->BabyName, false); ?> <?php endif; ?>  <?php if(isset($results->BMrNo) && !empty($results->BMrNo)): ?>  <?php echo e($results->BMrNo, false); ?>   <?php endif; ?></a>
            </li>
        </ul>
        <div class="pull-right">
            <?php 
            $mmrn = $results->BMrNo; 

            echo \SiteHelpers::menuList($mmrn, $results->AdmissionId, 'daycare_edit');
            ?>
        </div>
        <div class="pull-right">
            <?php if(is_array($silabingsdays)): ?>
            <table class="table">
                <tr>
                    <td> <?php if(isset($silabingsdays['first']) &&  !empty($silabingsdays['first'])): ?><a class="forward-boot-class" href="<?php echo e($silabingsdays['first'], false); ?>"><i class="fa fa-fast-backward fa-2x" title="Previous Page" aria-hidden="true"></i></a><?php endif; ?> </td>
                    <td> <?php if(isset($silabingsdays[0]) &&  !empty($silabingsdays[0])): ?><a class="forward-boot-class" href="<?php echo e($silabingsdays[0], false); ?>"><i class="fa fa-backward fa-2x" title="Previous Page" aria-hidden="true"></i></a><?php endif; ?> </td>
                    <td> <?php if(isset($silabingsdays[1]) &&  !empty($silabingsdays[1])): ?><a class="forward-boot-class"  href="<?php echo e($silabingsdays[1], false); ?>"><i class="fa fa-forward fa-2x" title="Next Page"  aria-hidden="true"></i></a><?php endif; ?></td>
                    <td> <?php if(isset($silabingsdays['last']) &&  !empty($silabingsdays['last'])): ?><a class="forward-boot-class"  href="<?php echo e($silabingsdays['last'], false); ?>"><i class="fa fa-fast-forward fa-2x" title="Next Page"  aria-hidden="true"></i></a><?php endif; ?></td>
                </tr>
            </table>
            <?php endif; ?>    
        </div>
    </div>
    <style type="text/css">

    </style>
    <!-- /Breadcrumbs line -->
    <!-- Page Header -->
<!-- <div class="page-header">
</div> -->
<!-- /Page Header -->
<!--     //silabingsdays
-->
<style type="text/css">
    .problems-container{
        -moz-user-select: none !important;
        -webkit-user-select: none !important;
        -user-select: none !important;
    }
    .select-free-text2
    {
        z-index: 1;
    }
</style>
<div class="row row-spacing">
    <div class="col-md-12">
        <?php echo Form::model($results,['method' => 'PATCH','url' => action('Admission\DaycareController@update', $results->DayId),'id'=> 'daycare-form']); ?>

        <?php echo $__env->make('errors.list', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <!-- Nav tabs -->
        <div role="tabpanel" class="tabbable tabbable-custom">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation"  <?php if($_COOKIE['daycare'] == 'generalform'): ?> class="active" <?php endif; ?>>
                    <a href="#generalform" aria-controls="generalform" role="tab" data-toggle="tab">General Information</a>
                </li>
                <li role="presentation"  <?php if($_COOKIE['daycare'] == 'resform'): ?> class="active" <?php endif; ?>>
                    <a href="#resform" aria-controls="resform" role="tab" data-toggle="tab">Respiratory System</a>
                </li>
                <li role="presentation" <?php if($_COOKIE['daycare'] == 'cardioform'): ?> class="active" <?php endif; ?>>
                    <a href="#cardioform" aria-controls="cardioform" role="tab" data-toggle="tab">Cardiovascular System</a>
                </li>
                <li role="presentation" <?php if($_COOKIE['daycare'] == 'gasform'): ?> class="active" <?php endif; ?>>
                    <a href="#gasform" aria-controls="gasform" role="tab" data-toggle="tab">Gastrointestinal System</a>
                </li>
                <li role="presentation" <?php if($_COOKIE['daycare'] == 'centralform'): ?> class="active" <?php endif; ?>>
                    <a href="#centralform" aria-controls="centralform" role="tab" data-toggle="tab">Central Nervous System</a>
                </li>
                <li role="presentation" <?php if($_COOKIE['daycare'] == 'fluidform'): ?> class="active" <?php endif; ?>>
                    <a href="#fluidform" aria-controls="fluidform" role="tab" data-toggle="tab">Renal, Fluid Balance & Bloods</a> 
                </li>
                <li role="presentation" <?php if($_COOKIE['daycare'] == 'sepsisform'): ?> class="active" <?php endif; ?>>
                    <a href="#sepsisform" aria-controls="sepsisform" role="tab" data-toggle="tab">Sepsis & Drugs</a>
                </li>
                <li role="presentation" <?php if($_COOKIE['daycare'] == 'invasform'): ?> class="active" <?php endif; ?>>
                    <a href="#invasform" aria-controls="invasform" role="tab" data-toggle="tab">Invasive Lines</a>
                </li>
                <li role="presentation" <?php if($_COOKIE['daycare'] == 'skinform'): ?> class="active" <?php endif; ?>>
                    <a href="#skinform" aria-controls="skinform" role="tab" data-toggle="tab">Skin</a>
                </li>
                <li role="presentation" <?php if($_COOKIE['daycare'] == 'ropform'): ?> class="active" <?php endif; ?>>
                    <a href="#ropform" aria-controls="ropform" role="tab" data-toggle="tab">ROP & Plan</a>
                </li>
                <li role="presentation" <?php if($_COOKIE['daycare'] == 'notesform'): ?> class="active" <?php endif; ?>>
                    <a href="#notesform" aria-controls="notesform" role="tab" data-toggle="tab">Notes</a>
                </li>
                <li role="presentation" <?php if($_COOKIE['daycare'] == 'reassessment'): ?> class="active" <?php endif; ?>>
                    <a href="#reassessment" aria-controls="reassessment" role="tab" data-toggle="tab">Reassessment Sheet</a>
                </li>
                <li role="presentation">
                    <a href="#media_tab" aria-controls="#media_tab" role="tab" data-toggle="tab">Attachments</a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content tab-view-shadow">
                <!-- General Form -->
                <div role="tabpanel" class="tab-pane <?php if($_COOKIE['daycare'] == 'generalform'): ?> active <?php endif; ?>" id="generalform">
                    <div class="col-md-6 col-sm-6">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <?php echo Form::hidden('MotherId'); ?>

                                <?php echo Form::hidden('BabyId'); ?>

                                <?php echo Form::hidden('AdmissionId'); ?>

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
                                        <?php echo Form::label('BMrNo', Lang::get('home.mrn') .':'); ?>

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
                                        <?php echo Form::text('DOB',null,['class'=>'form-control datepicker birth-date','readonly']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('DayOfLife','Day of Life:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('DayOfLife',null,['class'=>'form-control','readonly']); ?>

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
                                                <?php echo Form::text('g_weeks',null,['class'=>'form-control input-width-medium gestation-wks', 'readonly']); ?>

                                                <label class="error help-block" for="g_weeks" generated="true"></label> 
                                            </div>
                                            <div class="inbeween_two_fields">
                                                <span>+</span>
                                            </div>
                                            <div>
                                                <small>(In Days)</small>
                                                <?php echo Form::text('g_days',null,['class'=>'form-control input-width-medium gestation-days', 'readonly']); ?>

                                                <label class="error help-block" for="g_days" generated="true"></label> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                        <?php echo Form::label('CorrectedGestation','Corrected Gestational Age:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input clear-xs">
                                        <div class="row col-md-12 display-flex">
                                            <div>
                                                <small>(In Weeks)</small>
                                                <?php echo Form::text('cg_weeks',null,['class'=>'form-control input-width-medium corrected-gestation-wks','readonly']); ?>

                                                <label class="error help-block" for="cg_weeks" generated="true"></label>
                                            </div>
                                            <div class="inbeween_two_fields">
                                                <span>+</span>
                                            </div>
                                            <div>
                                                <small>(In Days)</small>
                                                <?php echo Form::text('cg_days',null,['class'=>'form-control input-width-medium corrected-gestation-days','readonly']); ?>

                                                <label class="error help-block" for="cg_days" generated="true"></label> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('Care','Care:', ['class'=>'required-label']); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('Care',[''=>'N/A','Intensive Care'=>'Intensive Care','Special Care'=>'Special Care','Ward Admission'=>'Ward Admission','High Dependancy Care'=>'High Dependancy Care'],null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('Care')]); ?>

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
                                <div class="hidden">
                                    <?php echo Form::select('neonatal_seen_by',$DoctorMaster,null,['class'=>'form-control']); ?>

                                </div>                                     
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('seenby','Seen By', ['class'=>'required-label']); ?>

                                        <a href="javascript:void(0)" class="add_master_data" data-modal_header="Seen By" data-destination_elements="Surgeon,seenby" data-option_value="id" data-option_text="Name" data-mas_table="mas_doctors">
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
                                                            <a class="btn btn-success btn-view seen_by_add btn_add" href="javascript:void(0);">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                        </span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $seen_by = json_decode($results->seenby);
                                                ?>
                                                <?php if(isset($seen_by) && !empty($seen_by) && count($seen_by) > 0): ?>
                                                <?php $__currentLoopData = $seen_by; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $seen_by): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td>
                                                        <?php echo Form::select('seenby['.$key.']',$DoctorMaster,$seen_by,['class'=>'form-control full-width']); ?>

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
                                                        <?php echo Form::select('seenby[]',$DoctorMaster,null,['class'=>'form-control full-width']); ?>

                                                    </td>
                                                </tr>
                                                <?php endif; ?> 
                                            </tbody>
                                        </table>
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
                                        <?php echo Form::label('DayDate','Date of Record:', ['class'=>'required-label']); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('DayDate',null,['class'=>'form-control daycare-date record-date', 'readonly']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                        <?php echo Form::label('DayTime','Time of Record:', ['class'=>'required-label']); ?>

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
                                                <?php echo Form::select('DayTime',$admission['time'],null,['class'=>'form-control']); ?>

                                                <label for="DayTime" generated="true" class="error help-block"></label>
                                            </div>
                                            <div class="col-xs-4">
                                                <?php echo Form::select('DayTime_MINS',$admission['mins'],null,['class'=>'form-control']); ?>

                                                <label for="DayTime_MINS" generated="true" class="error help-block"></label>
                                            </div>
                                            <div class="col-xs-4">
                                                <?php echo Form::select('DayTime_AM',[''=>'N/A','AM'=>'AM','PM'=>'PM'],null,['class'=>'form-control']); ?>

                                                <label for="DayTime_AM" generated="true" class="error help-block"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mx-0 problems-container">
                                    <div class="col-md-12">
                                        <?php echo Form::label('CurrentProblems','Current Problems:'); ?>

                                        <a href="javascript:void(0)" class="btn btn-success btn-view" id="add_cur_problem"><i class="fa fa-plus"></i></a>
                                        <!-- NOTE ====== DON'T GIVE Any SPACES IN THIS LIST -->
                                        <input type="hidden" name="CurrentProblems" id="hidden_current_problem" value="<?php echo e($results->CurrentProblems, false); ?>">
                                        <ul class="connected-sortable droppable-area1">
                                            <?php 
                                            if (preg_match("/<ol>/i", $results->CurrentProblems)){
                                                $converted = str_replace(['<ol>', '</ol>'], '', $results->CurrentProblems);
                                                $problems_explode = explode('<li>', $converted);
                                                if (count($problems_explode) > 0) {
                                                    foreach ($problems_explode as $key => $value) {
                                                        $value = str_replace('</li>', '', $value);
                                                        if (trim($value) != '') {        
                                                            echo '<li class="draggable-item">'.$value.'<a class="btn btn-default btn-view"><i class="fas fa-arrows-alt"></i></a><a class="btn btn-info btn-view edit_problem"><i class="fa fa-edit"></i></a><a class="btn btn-danger btn-view remove_problems"><i class="fa fa-trash"></i></a></li>';
                                                        }
                                                    }
                                                }
                                            }
                                            else { ?>
                                                <?php if(isset($results->CurrentProblems) && !empty($results->CurrentProblems)): ?>
                                                <?php 
                                                $cur_problem = explode('||', $results->CurrentProblems);
                                                if (count($cur_problem) != 0) {
                                                    foreach ($cur_problem as $key => $cur_prob_value) {

                                                        echo '<li class="draggable-item">'.$cur_prob_value.'<a class="btn btn-default btn-view"><i class="fas fa-arrows-alt"></i></a><a class="btn btn-info btn-view edit_problem"><i class="fa fa-edit"></i></a><a class="btn btn-danger btn-view remove_problems"><i class="fa fa-trash"></i></a></li>';
                                                    }
                                                }
                                                ?>
                                                <?php endif; ?>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                                <!-- NOTE ====== DON'T GIVE Any SPACES IN THIS LIST -->
                                <div class="form-group row mx-0 problems-container">
                                    <div class="col-md-12">
                                        <?php echo Form::label('PreviousProblems','Previous Problems:'); ?>

                                        <a href="javascript:void(0)" class="btn btn-success btn-view" id="add_prev_problem"><i class="fa fa-plus"></i></a>
                                        <input type="hidden" name="PreviousProblems" id="hidden_prev_problem" value="<?php echo e($results->PreviousProblems, false); ?>">
                                        <ul class="connected-sortable droppable-area2">
                                            <?php 
                                            if (preg_match("/<ol>/i", $results->PreviousProblems)){
                                                $converted = str_replace(['<ol>', '</ol>'], '', $results->PreviousProblems);
                                                $problems_explode = explode('<li>', $converted);
                                                if (count($problems_explode) > 0) {
                                                    foreach ($problems_explode as $key => $value) {
                                                        $value = str_replace('</li>', '', $value);
                                                        if (trim($value) != '') {        
                                                            echo '<li class="draggable-item">'.$value.'<a class="btn btn-default btn-view"><i class="fas fa-arrows-alt"></i></a><a class="btn btn-info btn-view edit_problem"><i class="fa fa-edit"></i></a><a class="btn btn-danger btn-view remove_problems"><i class="fa fa-trash"></i></a></li>';
                                                        }
                                                    }
                                                }
                                            }
                                            else { ?>
                                                <?php if(isset($results->PreviousProblems) && !empty($results->PreviousProblems)): ?>
                                                <?php 
                                                $prev_problem = explode('||', $results->PreviousProblems);
                                                if (count($prev_problem) != 0) {
                                                    foreach ($prev_problem as $prob_key => $prev_prob_value) {

                                                        echo '<li class="draggable-item">'.$prev_prob_value.'<a class="btn btn-default btn-view"><i class="fas fa-arrows-alt"></i></a><a class="btn btn-info btn-view edit_problem"><i class="fa fa-edit"></i></a><a class="btn btn-danger btn-view remove_problems"><i class="fa fa-trash"></i></a></li>';
                                                    }
                                                }
                                                ?>
                                                <?php endif; ?>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('Background','Background:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::textarea('Background',null,['class'=>'form-control','rows'=>5]); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Respiratory Form -->
                <div role="tabpanel" class="tab-pane <?php if($_COOKIE['daycare'] == 'resform'): ?> active <?php endif; ?>" id="resform">
                    <div class="col-md-11 ">
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control mt-0">
                                <?php echo Form::label('ResICD','Respiratory ICD:'); ?>

                            </div>
                            <div class="col-md-9 custom-input">
                                <?php echo Form::Select('ResICD[]',$ICD,null,['class'=>'select2-select-00 full-width-fix','multiple']); ?>

                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control mt-0">
                                <?php echo Form::label('additional_res_icd','Additional Respiratory ICD:'); ?>

                            </div>
                            <div class="col-md-9 custom-input">
                                <?php echo Form::textarea('additional_res_icd',null,['class'=>'form-control', 'rows'=>2]); ?>

                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control mt-0">
                                <?php echo Form::label('respiratory_problem','Are there any positive examination findings ?'); ?>

                            </div>
                            <div class="col-md-9 custom-input">
                                <?php echo Form::select('respiratory_problem',[''=>'N/A','0'=>'No','1'=>'Yes'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]); ?>  
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
                                        <?php echo Form::label('InvasiveVentilation','Invasive Ventilation:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('InvasiveVentilation',[''=>'N/A','Yes'=>'Yes','No'=>'No'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('InvasiveVentilation')]); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('Ventilation_choose','Ventilation Choose:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('Ventilation_choose',[''=>'N/A','NonInvasiveVentilation'=>'NonInvasive Ventilation','OtherRespiratorySupport'=>'OtherRespiratory Support','Spontaneouslyventilating'=>'Spontaneously Ventilating in air'],null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('ModeOfVentilation','Invasive Ventilation Type:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('ModeOfVentilation',[''=>'N/A','CMV'=>'CMV','IMV'=>'IMV','SIMV'=>'SIMV','PSV'=>'PSV','A/C or PTV'=>'A/C or PTV','HFO'=>'HFOV'],null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('NonInvasiveVentilation','Non-Invasive Ventilation:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('NonInvasiveVentilation',[''=>'N/A','CPAP'=>'CPAP','NIMV/NIPPV'=>'NIMV/NIPPV','HHHFNC'=>'HHHFNC','nHFOV'=>'nHFOV'],null,['class'=>' form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('OtherRespiratorySupport','Other Respiratory Support:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('OtherRespiratorySupport',[''=>'N/A','NPO2'=>'NPO2','HBO2'=>'HBO2','Face mask oxygen'=>'Face mask oxygen'],null,['class'=>' form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('Spontaneouslyventilating','Spontaneously Ventilating:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('Spontaneouslyventilating',[''=>'N/A','Yes'=>'Yes','No'=>'No'],null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('sp_ven')]); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('volume_targeting','Volume Targeting:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <input id="volume_targeting" name="volume_targeting" data-on="Yes" data-off="No"  data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox" <?php if(isset($results->volume_targeting) && $results->volume_targeting == 1): ?> checked <?php endif; ?>>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('claco','CLACO:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <input id="claco" name="claco" data-on="Yes" data-off="No"  data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox" <?php if(isset($results->claco) && $results->claco == 1): ?> checked <?php endif; ?>>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('pip_set','PIP Settings:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('pip_set',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('pip_delivered','PIP Delivered:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('pip_delivered',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('PEEP','PEEP'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('PEEP',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('MAP','MAP:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('MAP',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('fio2_set','FiO2 % (Set):'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('fio2_set',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('fio2_delivered','FiO2 % (Delivered)  :'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('fio2_delivered',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('Rate','Ventilator Rate:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('Rate',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('frequency_rep','Frequency (Hz):'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('frequency_rep',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('IT','IT in sec:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('IT',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('i_e_ratio','I:E ratio:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('i_e_ratio',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('Flow','Flow (L/min):'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('Flow',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('amplitude','Amplitude &Delta;P:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('amplitude',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('Indication','Respiratory Indication:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('Indication[]',ValuelistHelpers::Indications(),null,['class'=>'select2-select-00 full-width','multiple','id'=>'Indication']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('Surfactant_therapy_nicu','Surfactant therapy in the NICU:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <input id="Surfactant_therapy_nicu" name="Surfactant_therapy_nicu" data-on="Yes" data-off="No"  data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox" <?php if(isset($results->Surfactant_therapy_nicu) && $results->Surfactant_therapy_nicu == 'Yes'): ?> checked <?php endif; ?>>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('surfactant_indication','Indication For Surfactant:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('surfactant_indication[]',ValuelistHelpers::surfactant_indications(),null,['class'=>'select2-select-00 full-width','multiple','id'=>'surfactant_indication']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('RR','Baby\'s Respiratory Rate:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('RR',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control  md-mt-50">
                                        <?php echo Form::label('Retractions','Retractions:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('Retractions',[''=>'N/A','No'=>'No','Mild'=>'Mild','Moderate'=>'Moderate','Severe'=>'Severe'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('Retractions')]); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control  md-mt-50">
                                        <?php echo Form::label('AirEntry','Air entry:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('AirEntry',[''=>'N/A','Equal'=>'Equal','Reduced Bilateral'=>'Reduced Bilateral','Reduced Rt'=>'Reduced &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Right','Reduced Lt'=>'Reduced &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Left'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('AirEntry')]); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control  md-mt-50">
                                        <?php echo Form::label('ChestMovement','Chest Movement:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('ChestMovement',[''=>'N/A','Symmetrical'=>'Symmetrical','Asymmetrical'=>'Asymmetrical'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('ChestMovement')]); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control  md-mt-50">
                                        <?php echo Form::label('AddedSounds','Added Sounds:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('AddedSounds',[''=>'N/A','Present'=>'Present','Absent'=>'Absent'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('AddedSounds')]); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('DayCharacter','Character:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('DayCharacter',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('CXRFindings','CXR Findings:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::textarea('CXRFindings',null,['class'=>'form-control','rows'=>5]); ?>

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
                                        <?php echo Form::label('TypeOfBloodGas','Type Of Blood Gas:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('TypeOfBloodGas',[''=>'N/A','Not done'=>'Not done','Arterial'=>'Arterial','Venous'=>'Venous','Capillary'=>'Capillary','Not indicated'=>'Not indicated'],null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                        <?php echo Form::label('LastBG','Last BG at:'); ?>

                                    </div>
                                    <?php $times=ValuelistHelpers::timeEngine(); ?>
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
                                                <?php echo Form::select('LastBG_Time',$times['time'],null,['class'=>'form-control ']); ?>

                                            </div>
                                            <div class="col-xs-4">
                                                <?php echo Form::select('LastBG_Time_MINS',$times['mins'],null,['class'=>'form-control ']); ?>

                                            </div>
                                            <div class="col-xs-4">
                                                <?php echo Form::select('LastBG_Time_AM',$times['period'],null,['class'=>'form-control ']); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('Ph','pH:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('Ph',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('PaO2','PaO2:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('PaO2',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('PaCo2','PaCo2:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('PaCo2',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('HCO3','HCO3:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('HCO3',null,['class'=>'form-control']); ?>

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
                                        <?php echo Form::label('Lactate','Lactate:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('Lactate',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        <?php echo Form::label('EtTube','ET Tube:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('EtTube',[''=>'N/A','Yes'=>'Yes','No'=>'No'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default')]); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('Size','Size in cm:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('Size',[''=>'N/A','None'=>'None','2.0'=>'2.0','2.5'=>'2.5','3.0'=>'3.0','3.5'=>'3.5','4.0'=>'4.0'],null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('Lips','Cm at Lips:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('Lips',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('SaO2PostDuctal','SaO2 PostDuctal:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('SaO2PostDuctal',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('AaDO2','AaDO2:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('AaDO2',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('OI','OI:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('OI',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('RSFindings','Other RS Findings:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::textarea('RSFindings',null,['class'=>'form-control','rows'=>5]); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('needlethoracentesis','Needle Thoracocentesis:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <input id="needlethoracentesis" name="needlethoracentesis" data-on="Yes" data-off="No"  data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox" <?php if(isset($results->needlethoracentesis) && $results->needlethoracentesis == '2'): ?> checked <?php endif; ?>>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('intercostaldrain','Intercostal Drain:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <input id="intercostaldrain" name="intercostaldrain" data-on="Yes" data-off="No"  data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox" <?php if(isset($results->intercostaldrain) && $results->intercostaldrain == '2'): ?> checked <?php endif; ?>>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('chronic_lung','Chronic Lung Disease:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <input id="chronic_lung" name="chronic_lung" data-on="Yes" data-off="No"  data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox" <?php if(isset($results->chronic_lung) && $results->chronic_lung == '2'): ?> checked <?php endif; ?>>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Cardiovascular Form -->
                <div role="tabpanel" class="tab-pane <?php if($_COOKIE['daycare'] == 'cardioform'): ?> active <?php endif; ?>" id="cardioform">
                    <div class="col-md-11 ">
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                <?php echo Form::label('CarICD','Cardiovascular ICD:'); ?>

                            </div>
                            <div class="col-md-9 custom-input">
                                <?php echo Form::Select('CarICD[]',$ICD,null,['class'=>'select2-select-00 full-width-fix','multiple']); ?>

                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control mt-0">
                                <?php echo Form::label('additional_car_icd','Additional Cardiovascular ICD:'); ?>

                            </div>
                            <div class="col-md-9 custom-input">
                                <?php echo Form::textarea('additional_car_icd',null,['class'=>'form-control', 'rows'=>2]); ?>

                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                <?php echo Form::label('Cardiovascular_problem','Are there any positive examination findings ?'); ?>

                            </div>
                            <div class="col-md-9 custom-input">
                                <?php echo Form::select('Cardiovascular_problem',[''=>'N/A','0'=>'No','1'=>'Yes'],null,["class"=>"form-control"]); ?>  
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
                                        <?php echo Form::label('HR','HR:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('HR',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('systolic_bp','Systolic BP:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('systolic_bp',null,['class'=>'form-control']); ?>

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
                                        <?php echo Form::label('MeanBP','Mean BP'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('MeanBP',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        <?php echo Form::label('PulsePressure','Pulse Pressure:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('PulsePressure',[''=>'N/A','Normal'=>'Normal','Wide'=>'Wide'],null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('PulsePressure')]); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('CentralPulses','Central Pulses'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('CentralPulses',[''=>'N/A','Normal'=>'Normal','Bounding'=>'Bounding','Feeble/Weak'=>'Feeble/Weak','Absent'=>'Absent'],null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('PeripheralPulses')]); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('PeripheralPulses','Peripheral Pulses:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('PeripheralPulses',[''=>'N/A','Normal'=>'Normal','Bounding'=>'Bounding','Feeble/Weak'=>'Feeble/Weak','Absent'=>'Absent'],null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('PeripheralPulses')]); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('FemoralPulses','Femoral Pulses:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('FemoralPulses',[''=>'N/A','Normal'=>'Normal','Bounding'=>'Bounding','Feeble/Weak'=>'Feeble/Weak','Absent'=>'Absent'],null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('PeripheralPulses')]); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        <?php echo Form::label('PrecordialActivity','Precordial Activity:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('PrecordialActivity',[''=>'N/A','Present'=>'Present','Absent'=>'Absent'],null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('default')]); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        <?php echo Form::label('S1S2','S1S2:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('S1S2',[''=>'N/A','Normal'=>'Normal','Abnormal'=>'Abnormal'],null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        <?php echo Form::label('Murmur','Murmur:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('Murmur',[''=>'N/A','Present'=>'Present','Absent'=>'Absent'],null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('default')]); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <?php echo Form::label('CharacterOfMurmur','Character Of Murmur:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('CharacterOfMurmur',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('CVSFindings','Other CVS Findings:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::textarea('CVSFindings',null,['class'=>'form-control','rows'=>5]); ?>

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
                                        <?php echo Form::label('CFT','CFT:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('CFT',[''=>'N/A','< 3 Seconds' => "< 3 Seconds",'3-5 Seconds' => "3-5 Seconds",'>5 Seconds' => ">5 Seconds","Prolonged"=>"Prolonged"],null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('sp_ven')]); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control" style="margin-top: 25px">
                                        <?php echo Form::label('CentralTemperature','Central Temperature:'); ?>

                                    </div>
                                    <?php $order_changed = \SiteHelpers::temperatureOrder(); ?>
                                    <div class="col-md-9 custom-input">
                                        <?php if($order_changed): ?>
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <small>(In Fahrenheit)</small>
                                            </div>
                                            <div class="col-xs-6">
                                                <small>(In Celsius)</small>
                                            </div>
                                            <div class="col-xs-6">
                                                <?php echo Form::text('central_temp_farenheit',null,['class'=>'form-control fahrenheit']); ?>

                                            </div>
                                            <div class="col-xs-6">
                                                <?php echo Form::text('CentralTemperature',null,['class'=>'form-control celsius']); ?>

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
                                                <?php echo Form::text('CentralTemperature',null,['class'=>'form-control celsius']); ?>

                                            </div>
                                            <div class="col-xs-6">
                                                <?php echo Form::text('central_temp_farenheit',null,['class'=>'form-control fahrenheit']); ?>

                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control" style="margin-top: 25px">
                                        <?php echo Form::label('PeripheralTemperature','Peripheral Temperature:'); ?>

                                    </div>
                                    <?php $order_changed = \SiteHelpers::temperatureOrder(); ?>
                                    <div class="col-md-9 custom-input">
                                        <?php if($order_changed): ?>
                                        <!-- <?php echo Form::text('PeripheralTemperature',null,['class'=>'form-control']); ?> -->
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <small>(In Fahrenheit)</small>
                                            </div>
                                            <div class="col-xs-6">
                                                <small>(In Celsius)</small>
                                            </div>
                                            <div class="col-xs-6">
                                                <?php echo Form::text('peripheral_fahrenheit',null,['class'=>'form-control fahrenheit']); ?>

                                            </div>
                                            <div class="col-xs-6">
                                                <?php echo Form::text('PeripheralTemperature',null,['class'=>'form-control celsius']); ?>

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
                                                <?php echo Form::text('PeripheralTemperature',null,['class'=>'form-control celsius']); ?>

                                            </div>
                                            <div class="col-xs-6">
                                                <?php echo Form::text('peripheral_fahrenheit',null,['class'=>'form-control fahrenheit']); ?>

                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        <?php echo Form::label('Color','Color:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('Color',[''=>'N/A','Pale'=>'Pale','Pink' => "Pink","Acral Cyanosis"=>"Acral Cyanosis","Central Cyanosis"=>"Central Cyanosis"],null,['class'=>' form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        <?php echo Form::label('Inotropes','Inotropes:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('Inotropes',[''=>'N/A','No' =>"No","Yes"=>"Yes"],null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('Inotropes')]); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <?php echo Form::label('Dopamine','Dopamine (mcg/kg/min):'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('Dopamine',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <?php echo Form::label('Dobutamine','Dobutamine (mcg/kg/min):'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('Dobutamine',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <?php echo Form::label('Adrenaline','Adrenaline (ng/kg/min):'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('Adrenaline',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <?php echo Form::label('Noradrenaline','Nor adrenaline (ng/kg/min):'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('Noradrenaline',null,['class'=>'form-control','id'=>'Noradrenaline']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <?php echo Form::label('Milrinone','Milrinone (mcg/kg/hour):'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('Milrinone',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        <?php echo Form::label('echo_status','ECHO:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('echo_status',[''=>'N/A','No'=>'No','Yes'=>'Yes'],null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('DayEcho','ECHO Report:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::textarea('DayEcho',null,['class'=>'form-control','rows'=>5]); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        <?php echo Form::label('PDA','PDA:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('PDA',[""=>"N/A","Yes" =>"Yes","No"=>"No"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default')]); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        <?php echo Form::label('PDATreatment','PDA Treatment:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('PDATreatment',[""=>"N/A","None" =>"None","Medical"=>"Medical","Surgical"=>"Surgical"],null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        <?php echo Form::label('pphn','PAH:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('pphn',[""=>"N/A","Yes"=>"Yes","No"=>"No"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default')]); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        <?php echo Form::label('pphn_treatement','PAH Treatment:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('pphn_treatement',ValuelistHelpers::getPphntreatement(),null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('PDATreatment')]); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Gastrointestinal System -->
                <div role="tabpanel" class="tab-pane <?php if($_COOKIE['daycare'] == 'gasform'): ?> active <?php endif; ?>" id="gasform">
                    <div class="col-md-11 ">
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                <?php echo Form::label('GasICD','Gastrointestinal ICD:'); ?>

                            </div>
                            <div class="col-md-9 custom-input">
                                <?php echo Form::Select('GasICD[]',$ICD,null,['class'=>'select2-select-00 full-width-fix','multiple']); ?>

                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control mt-0">
                                <?php echo Form::label('additional_gas_icd','Additional Gastrointestinal ICD:'); ?>

                            </div>
                            <div class="col-md-9 custom-input">
                                <?php echo Form::textarea('additional_gas_icd',null,['class'=>'form-control', 'rows'=>2]); ?>

                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                <?php echo Form::label('gastrointestinal_problem','Are there any positive examination findings ?'); ?>

                            </div>
                            <div class="col-md-9 custom-input">
                                <?php echo Form::select('gastrointestinal_problem',[''=>'N/A','0'=>'No','1'=>'Yes'],null,['class'=>'form-control']); ?>

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
                                    <div class="col-md-3 text-right label-control" style="padding-left: 9px;">
                                        <?php echo Form::label('directlybreastfeed','Directly breast feed ?:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?php echo Form::checkbox('directlybreastfeed',null,null,['data-on'=>'Yes','data-off'=>'No','data-toggle'=>'toggle','data-width'=>'100','data-size'=>'small','class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control" style="padding-left: 7px;">
                                        <?php echo Form::label('othertypefeed','Other Type Of Feeds ?'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        &nbsp;
                                        <i class="fa fa-info-circle bs-tooltip color-black-must" data-placement="top" data-original-title="including top up feeds"></i>
                                        &nbsp;
                                        <?php echo Form::checkbox('othertypefeed',null,null,['data-on'=>'Yes','data-off'=>'No','data-toggle'=>'toggle','data-width'=>'100','data-size'=>'small','class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('Volume','Volume:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('Volume',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('Frequency','Frequency:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('Frequency',ValuelistHelpers::frequencyList(),null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('workingWeight','Working Weight: (in grams)'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('workingWeight',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('Feeds','Feeds ml/kg/d:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('Feeds',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('TypeofFeeds','Type of Feeds:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('TypeofFeeds',ValuelistHelpers::feedingDischarge(),null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        <?php echo Form::label('FullEnteralFeeds','Full Enteral Feeds:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('FullEnteralFeeds',[''=>'N/A','Reached' => "Reached","Not Reached"=>"Not Reached"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('FullEnteralFeeds')]); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('iv_fluids','IV fluids +/- PN & Drug Infusions:'); ?>

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
                                                <?php echo Form::text('iv_fluids',null,['class'=>'form-control']); ?>

                                                <label class="error help-block" for="iv_fluids" generated="true"></label>
                                            </div>
                                            <div class="col-xs-2">
                                                =
                                            </div>
                                            <div class="col-xs-5">
                                                <?php echo Form::text('iv_fluids_ml_day',null,['class'=>'form-control', 'id'=>'iv_fluids_ml_day']); ?>

                                                <label class="error help-block" for="iv_fluids_ml_day" generated="true"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                        <!-- <div class="form-group row">
                                            <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                                <?php echo Form::label('drug_infusions','Drug Infusions:'); ?>

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
                                                        <?php echo Form::text('drug_infusions',null,['class'=>'form-control']); ?>

                                                        <label class="error help-block" for="drug_infusions" generated="true"></label>
                                                    </div>
                                                    <div class="col-xs-2">
                                                        =
                                                    </div>
                                                    <div class="col-xs-5">
                                                        <?php echo Form::text('drug_infusions_ml_day',null,['class'=>'form-control','id'=>'drug_infusions_ml_day']); ?>

                                                        <label class="error help-block" for="drug_infusions_ml_day" generated="true"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('other_drugs','Other IV Drugs ml/day:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::text('other_drugs',null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-0">
                                                <?php echo Form::label('Ivf','IV fluids +/- PN ml/kg/day:'); ?>

                                                <i class="fa fa-info-circle bs-tooltip color-black-must" data-placement="right" data-original-title="" title="(IV fluids +/- PN & Drug Infusions + Other IV Drugs ml/day) / (Working Weight/1000)"></i>
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::text('Ivf',null,['class'=>'form-control', 'id'=>'ivf']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control md-mt-50">
                                                <?php echo Form::label('Tpn','TPN:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('Tpn',[''=>'N/A','No' =>"No","Yes"=>"Yes"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-0">
                                                <?php echo Form::label('Carbohydrates','Carbohydrates (g/kg/day):'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::text('Carbohydrates',null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('Protein','Amino Acid  (g/kg/day):'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::text('Protein',null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('Fat','Fat(g/kg/day):'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::text('Fat',null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-0">
                                                <?php echo Form::label('total_energy','Total Energy (kcal/kg/day):'); ?>

                                                <i class="fa fa-info-circle bs-tooltip" data-placement="right" data-original-title="" title="(Carbohydrates (g/kg/day) * 4) + (Fat (g/kg/day) * 10)"></i>
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::text('total_energy',null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('AspirateVolume','Aspirate Volume:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::text('AspirateVolume',null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('AspirateNature','AspirateNature:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('AspirateNature',[''=>'N/A','Nil' =>"Nil","Milky"=>"Milky","Yellow"=>"Yellow","Light green"=>"Light green","Dark green"=>"Dark green","Bloody"=>"Bloody","Altered brown"=>"Altered brown","Clear"=>"Clear"],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('Stools','Stools:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::checkbox('Stools',null,null,['data-on'=>'Bowels opened','data-off'=>'Bowels not opened','data-toggle'=>'toggle','data-width'=>'200','data-size'=>'small','class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('StoolNature','Stool Nature:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('StoolNature',ValuelistHelpers::stoolNature(),null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control md-mt-50">
                                                <?php echo Form::label('Abdomen','Abdomen:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('Abdomen',[''=>'N/A','Normal'=>'Normal','Scaphoid'=>'Scaphoid','Distended'=>'Distended'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('Abdomen')]); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control md-mt-50">
                                                <?php echo Form::label('BowelSounds','Bowel Sounds:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('BowelSounds',[''=>'N/A','Normal'=>"Normal","Increased"=>"Increased","Decreased"=>"Decreased","Absent"=>"Absent"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('BowelSounds')]); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('AbdominalGirth','Abdominal Girth:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::text('AbdominalGirth',null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-0">
                                                <?php echo Form::label('PAFindings','Other PA Findings:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::text('PAFindings',null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control md-mt-50">
                                                <?php echo Form::label('NEC','NEC:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('NEC',[''=>'N/A','Yes' =>"Yes","No"=>"No"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default')]); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row" id="NECtreatmentDiv">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('NECtreatment','NEC treatment:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('NECtreatment',[''=>'N/A','Medical' =>"Medical","Surgical"=>"Surgical"],null,['class'=>'form-control']); ?>

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
                                                <?php echo Form::label('Umbilicus','Umbilicus:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('Umbilicus',[''=>'N/A','Healthy' => "Healthy","Possible infection"=>"Possible infection","Omphalitis"=>"Omphalitis","Omphalocele"=>"Omphalocele","Gastroschisis"=>"Gastroschisis","Hernia"=>"Hernia","Meconium Stained" => "Meconium Stained","Large" => "Large","Shrivelled" => "Shrivelled"],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control md-mt-50">
                                                <?php echo Form::label('Hepatomegaly','Hepatomegaly:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('Hepatomegaly',[""=>"N/A","No" =>"No","Yes"=>"Yes"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('LiverSpan','Liver Span:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::text('LiverSpan',null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control md-mt-50">
                                                <?php echo Form::label('Splenomegaly','Splenomegaly:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('Splenomegaly',[""=>"N/A","No" =>"No","Yes"=>"Yes"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('SpleenSpan','Spleen Span:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::text('SpleenSpan',null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('Herina','Hernia:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('Herina',[''=>'N/A','No hernia' => "No hernia","Right Inguinal hernia"=>"Right Inguinal hernia","Left Inguinal hernia"=>"Left Inguinal hernia","Umbilical/para umbilical hernia"=>"Umbilical/para umbilical hernia","Obstructed/strangulated"=>"Obstructed/strangulated"],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('Genitalia','Genitalia:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::text('Genitalia',null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-0">
                                                <?php echo Form::label('TSB','Maximum Bilirubin (in last 24 hours):'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::text('TSB',null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control md-mt-50">
                                                <?php echo Form::label('NNJTreatment','NNJ Treatment:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('NNJTreatment',[''=>'N/A','None'=>'None','Phototherapy' => "Photo &#9767;","Exchange transfusion"=>"Exchange &#9767;"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorValue('NNJTreatment')]); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control md-mt-50">
                                                <?php echo Form::label('Immunoglobulins','Immunoglobulins:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('Immunoglobulins',[''=>'N/A','Yes' => "Yes","No"=>"No"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorValue('default')]); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-0">
                                                <?php echo Form::label('BabyBloodGroup','Baby\'s Blood Group:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('BabyBloodGroup',ValuelistHelpers::Blood_groups(),null,['class'=>'form-control','disabled']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-0">
                                                <?php echo Form::label('MotherBloodGroup','Mother Blood Group:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('MotherBloodGroup',ValuelistHelpers::Blood_groups(),$mother['MotherBloodGroup'],['class'=>'form-control','disabled']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('AxrFindings','AXR Findings:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::textarea('AxrFindings',null,['class'=>'form-control','rows'=>4]); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-0">
                                                <?php echo Form::label('ultrasoundabdominal','Ultrasound Abdomen:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <input id="ultrasoundabdominal" name="ultrasoundabdominal" data-on="Yes" data-off="No"  data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox" <?php if(isset($results->ultrasoundabdominal) && $results->ultrasoundabdominal == '2'): ?> checked <?php endif; ?>>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('ultrasoundkeyfindings','Key Findings:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::textarea('ultrasoundkeyfindings',null,['class'=>'form-control','rows'=>5]); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Central Form -->
                        <div role="tabpanel" class="tab-pane <?php if($_COOKIE['daycare'] == 'centralform'): ?> active <?php endif; ?>" id="centralform">
                            <div class="col-md-11 ">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('CenICD','Central Nervous ICD:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::Select('CenICD[]',$ICD,null,['class'=>'select2-select-00 full-width-fix','multiple']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <?php echo Form::label('additional_cen_icd','Additional Central Nervous ICD:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::textarea('additional_cen_icd',null,['class'=>'form-control', 'rows'=>2]); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <?php echo Form::label('central_problem','Are there any positive examination findings ?'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('central_problem',[''=>'N/A','0'=>'No','1'=>'Yes'],null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <?php echo Form::label('sedation_paralysis','Is the baby under the influence of sedation/Paralysis ?'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('sedation_paralysis',[''=>'N/A','0'=>'No','1'=>'Yes'],null,['class'=>'form-control']); ?>

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
                                                <?php echo Form::label('TherapeuticHypothermia','Therapeutic Hypothermia:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('TherapeuticHypothermia',[""=>"N/A","No"=>"No","Yes" =>"Yes"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('Pupils','Pupils:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::text('Pupils',null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control md-mt-50">
                                                <?php echo Form::label('AnteriorFontanelle','Anterior Fontanelle:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('AnteriorFontanelle',[""=>"N/A","Normal" =>"Normal","Depressed"=>"Depressed","Bulging"=>"Bulging"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('AnteriorFontanelle')]); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('head_circumference','Head Circumference:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::text('head_circumference',null,['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);', 'data-growthchart'=>json_encode(\SiteHelpers::getDaysForChart())]); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('Activity','Activity:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('Activity',[""=>"N/A","Normal" =>"Normal","Comatosed"=>"Comatosed","Decreased"=>"Decreased","Increased"=>"Increased","Irritable"=>"Irritable","Sedated/Paralysed"=>"Sedated/Paralysed"],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('Tone','Tone'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('Tone',[""=>"N/A",'Normal' =>"Normal","Hypotonia"=>"Hypotonia","Hypertonia"=>"Hypertonia","Sedated/Paralysed"=>"Sedated/Paralysed"],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('Cry','Cry:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('Cry',ValuelistHelpers::cryValues(),null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control md-mt-50">
                                                <?php echo Form::label('Seizures','Seizures:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('Seizures',[""=>"N/A",'No' =>"No","Yes"=>"Yes"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('TypeOfSeizures','Type Of Seizures:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::text('TypeOfSeizures',null,['class'=>'form-control']); ?>

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
                                                <?php echo Form::label('NeonatalReflexes','Neonatal Reflexes:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('NeonatalReflexes',[""=>"N/A",'Normal' =>"Normal","Suppressed"=>"Suppressed","Absent"=>"Absent","Exaggerated"=>"Exaggerated","Sedated/Paralysed"=>"Sedated/Paralysed"],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('CnsFindings','Other CNS Findings:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::textarea('CnsFindings',null,['class'=>'form-control','rows'=>5]); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('neuro_sonogram','Neuro Sonogram:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <input id="neuro_sonogram" name="neuro_sonogram"  data-on="performed" data-off="Not performed"  data-toggle="toggle" data-width="200" data-size="small" class="form-control" type="checkbox" <?php if(isset($results->neuro_sonogram) && $results->neuro_sonogram == 'performed'): ?> checked <?php endif; ?>>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('Cuss','Neuro Sonogram Report:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::textarea('Cuss',null,['class'=>'form-control','rows'=>4]); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('ultrasound_spine','Ultrasound Spine:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <input id="ultrasound_spine" name="ultrasound_spine"  data-on="performed" data-off="Not performed"  data-toggle="toggle" data-width="200" data-size="small" class="form-control" type="checkbox" <?php if(isset($results->ultrasound_spine) && $results->ultrasound_spine == '2'): ?> checked <?php endif; ?>>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('ultrasound_spine_report','Ultrasound Spine Report:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::textarea('ultrasound_spine_report',null,['class'=>'form-control','rows'=>5]); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('mrict_brain_status','MRI/CT Brain:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <input id="mrict_brain_status" name="mrict_brain_status"  data-on="Yes" data-off="No"  data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox" <?php if(isset($results->mri_ct_brain) && $results->mrict_brain_status == '2'): ?> checked <?php endif; ?>>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('mri_ct_brain','Key Findings:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::textarea('mri_ct_brain',null,['class'=>'form-control','rows'=>4]); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('eeg_cfm','EEG/CFM:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <input id="eeg_cfm" name="eeg_cfm"  data-on="Performed"  data-off="Not Performed"  data-toggle="toggle" data-width="200" data-size="small" class="form-control" type="checkbox" <?php if(isset($results->eeg_cfm) && $results->eeg_cfm == '2'): ?> checked <?php endif; ?>>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('eeg_cfm_report','EEG/CFM Report:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::textarea('eeg_cfm_report',null,['class'=>'form-control','rows'=>'5']); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Fluid Balance Form -->
                        <div role="tabpanel" class="tab-pane <?php if($_COOKIE['daycare'] == 'fluidform'): ?> active <?php endif; ?>" id="fluidform">
                            <div class="col-md-11 ">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('FluidICD','Fluid Balance ICD:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::Select('FluidICD[]',$ICD,null,['class'=>'select2-select-00 full-width-fix','multiple']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <?php echo Form::label('additional_fluid_icd','Additional Fluid Balance ICD:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::textarea('additional_fluid_icd',null,['class'=>'form-control', 'rows'=>2]); ?>

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
                                            <div class="col-md-3 text-right label-control mt-0">
                                                <?php echo Form::label('TotalFluid','Total Fluid ml/kg/d:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::text('TotalFluid',null,['class'=>'form-control', 'id'=>'total-fluid']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-0">
                                                <?php echo Form::label('PreviousWt','Previous Weight (grams):'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::text('PreviousWt',null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-0">
                                                <?php echo Form::label('CurrentWt','Current Weight (grams):'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::text('CurrentWt',null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-0">
                                                <?php echo Form::label('WtChange','Weight Change (grams):'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::text('WtChange',null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-0">
                                                <?php echo Form::label('PercentageChange','Percentage Change:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::text('PercentageChange',null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-0">
                                                <?php echo Form::label('length','Length:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::text('length',null,['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control md-mt-50">
                                                <?php echo Form::label('UrineOutput','Urine Output:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('UrineOutput',[''=>'N/A','Passed' => "Passed","Not Passed"=>"Not Passed","Unmeasurable"=>"Unmeasurable"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('UrineOutput')]); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-0">
                                                <?php echo Form::label('urine_output_day','UO ml (in 24 hours):'); ?> 
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::text('urine_output_day',null,['class'=>'form-control']); ?>                                
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('UO','UO ml/kg/h:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::text('UO',null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('BloodOut','Blood Out:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::text('BloodOut',null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('DrainOutput','Drain Output:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::text('DrainOutput',null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('renalultrasound','Renal Ultrasound:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <input id="renalultrasound" name="renalultrasound" data-on="Yes" data-off="No"  data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox" <?php if(isset($results->renalultrasound) && $results->renalultrasound == '2'): ?> checked <?php endif; ?>>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('renalultrasoundkeyfindings','Key Findings:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::textarea('renalultrasoundkeyfindings',null,['class'=>'form-control','row'=>5]); ?>

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
                                                <?php echo Form::label('RBS','RBS:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::text('RBS',null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12 label-control">
                                                <?php echo Form::label('ElectrolyteAbnormalities','Glucose & Electrolyte Abnormalities:'); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-center label-control">
                                                <label class="control-label text-center glucose_label mr-4">Hypoglycemia: </label>
                                            </div>
                                            <div class="col-md-9 row">
                                                <div class="col-md-4 custom-input">
                                                    <input id="Hypoglycemia" name="Hypoglycemia" data-on="Yes" data-off="No" checked data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                                                </div>
                                                <div class="col-md-3 text-right label-control">
                                                    <?php echo Form::label('gir','GIR:', ['class' => 'mlr-10']); ?>

                                                </div>
                                                <div class="col-md-4 custom-input">
                                                    <?php echo Form::text('gir',null,['class'=>'mlr-10 form-control ']); ?>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-center label-control">
                                                <label class="control-label glucose_label">Hyperglycemia: </label>
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <input id="Hyperglycemia" name="Hyperglycemia" data-on="Yes" data-off="No"  data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox" <?php if(isset($results->Hyperglycemia) && $results->Hyperglycemia == '1'): ?> checked <?php endif; ?>>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-center label-control">
                                                <label class="control-label glucose_label">Insulin Therapy: </label>
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <input id="InsulinTherapy" name="InsulinTherapy" data-on="Yes" data-off="No"  data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox" <?php if(isset($results->InsulinTherapy) && $results->InsulinTherapy == '1'): ?> checked <?php endif; ?>>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-center label-control">
                                                <label class="control-label glucose_label">Hyponatremia: </label>
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <input id="Hyponatremia" name="Hyponatremia" data-on="Yes" data-off="No"  data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox" <?php if(isset($results->Hyponatremia) && $results->Hyponatremia == '1'): ?> checked <?php endif; ?>>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-center label-control">
                                                <label class="control-label glucose_label">Hypernatremia: </label>
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <input id="Hypernatremia" name="Hypernatremia" data-on="Yes" data-off="No"  data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox" <?php if(isset($results->Hypernatremia) && $results->Hypernatremia == '1'): ?> checked <?php endif; ?>>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-center label-control">
                                                <label class="control-label glucose_label">Hypokalemia: </label>
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <input id="Hypokalemia" name="Hypokalemia" data-on="Yes" data-off="No"  data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox" <?php if(isset($results->Hypokalemia) && $results->Hypokalemia == '1'): ?> checked <?php endif; ?>>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-center label-control">
                                                <label class="control-label glucose_label">Hyperkalemia: </label>
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <input id="Hyperkalemia" name="Hyperkalemia" data-on="Yes" data-off="No"  data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox" <?php if(isset($results->Hyperkalemia) && $results->Hyperkalemia == '1'): ?> checked <?php endif; ?>>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-center label-control">
                                                <label class="control-label glucose_label">Hypocalcemia: </label>
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <input id="Hypocalcemia" name="Hypocalcemia" data-on="Yes" data-off="No"  data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox" <?php if(isset($results->Hypocalcemia) && $results->Hypocalcemia == '1'): ?> checked <?php endif; ?>>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-center label-control">
                                                <label class="control-label glucose_label">Hypercalcemia: </label>
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <input id="Hypercalcemia" name="Hypercalcemia" data-on="Yes" data-off="No"  data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox" <?php if(isset($results->Hypercalcemia) && $results->Hypercalcemia == '1'): ?> checked <?php endif; ?>>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-center label-control">
                                                <label class="control-label glucose_label"> Dilution Exchange: </label>
                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <input id="dilution_exchange" name="dilution_exchange" data-on="Yes" data-off="No" data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox" <?php if(isset($results->InsulinTherapy) && $results->InsulinTherapy == '1'): ?> checked <?php endif; ?>>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control md-mt-50">
                                                <?php echo Form::label('Transfusion','Transfusion:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('Transfusion',[''=>'N/A','No' =>"No","Yes"=>"Yes"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('Transfusion')]); ?>

                                            </div>
                                        </div>
                                        <div class="form-group product-hidden">
                                            <table class="product table table-add-more full-width-fix">
                                                <thead>
                                                    <tr class="master-add-header">
                                                        <th>Product</th>
                                                        <th>Volume ml/kg</th>
                                                        <th>
                                                            <span>
                                                                <a class="btn btn-success btn-view product_add btn_add" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                                                            </span>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if(isset($products) && count($products) > 0): ?>
                                                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td class="full-width"><?php echo Form::select('F_Product['.$key.']',[''=>'N/A','Packed RBC'=>'Packed RBC','Whole Blood'=>'Whole Blood','Platelet Concentrate'=>'Platelet Concentrate','Fresh Frozen Plasma'=>'Fresh Frozen Plasma','Cryoprecipitate'=>'Cryoprecipitate','Washed maternal platelets'=>'Washed maternal platelets','NAIT - special platelets'=>'NAIT - special platelets','Immunoglobulin'=>'Immunoglobulin'],$data['Product'],['class'=>'form-control']); ?>

                                                        </td>
                                                        <td><input type="text" class="input-width-mini form-control" name="F_Volume[<?php echo e($key, false); ?>]" value="<?php echo $data['Volume'];; ?>"/></td>
                                                        <td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>
                                                    </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php else: ?>
                                                    <tr>
                                                        <td class="full-width"><?php echo Form::select('F_Product[]',[''=>'N/A','Packed RBC'=>'Packed RBC','Whole
                                                            Blood'=>'Whole Blood','Platelet Concentrate'=>'Platelet
                                                            Concentrate','Fresh Frozen Plasma'=>'Fresh Frozen
                                                            Plasma','Cryoprecipitate'=>'Cryoprecipitate','Washed maternal
                                                            platelets'=>'Washed maternal platelets','NAIT - special
                                                            platelets'=>'NAIT - special
                                                            platelets','Immunoglobulin'=>'Immunoglobulin'],null,['class'=>'form-control']); ?>

                                                        </td>
                                                        <td><input type="text" class="input-width-mini form-control" name="F_Volume[]" value=""/></td>
                                                        <td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>
                                                    </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td colspan="3"><label for="F_Volume[]" generated="true" class="error help-block"></label></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Sepsis Form -->
                        <div role="tabpanel" class="tab-pane <?php if($_COOKIE['daycare'] == 'sepsisform'): ?> active <?php endif; ?>" id="sepsisform">
                            <div class="col-md-11 ">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('SepsisICD','Sepsis ICD:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::Select('SepsisICD[]',$ICD,null,['class'=>'select2-select-00 full-width-fix','multiple']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <?php echo Form::label('additional_spesis_icd','Additional Sepsis ICD:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::textarea('additional_spesis_icd',null,['class'=>'form-control', 'rows'=>2]); ?>

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
                                                <?php echo Form::label('Sepsis','SEPSIS:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('Sepsis',[''=>'N/A','No sepsis' => "No sepsis","Suspect"=>"Suspect","Probable"=>"Probable","Proven"=>"Proven","Severe"=>"Severe"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('SEPSIS')]); ?>

                                            </div>
                                        </div>
                                        <div class="hidden">
                                            <?php echo Form::select('a_antibiotic_temp',['0'=>'N/A']+ValuelistHelpers::getDrugIvFluidsAntibiotic(),'',['class'=>"input-width-medium  form-control"]); ?>

                                        </div>
                                        <div class="form-group row mx-0">
                                            <table class="antibiotic table table-add-more full-width-fix table-layout-fixed">
                                                <thead>
                                                    <tr class="master-add-header">
                                                        <th>Antibiotic
                                                            <a href="javascript:void(0)" class="add_master_data" data-modal_header="Drugs & Iv Fluids" data-destination_elements="a_antibiotic_temp,A_Antibiotic[]" data-option_value="id" data-option_text="generic_pharmacological_name" data-mas_table="mas_drugivfluid" data-drug_type="antibiotic">
                                                                <i class="fa fa-info-circle bs-tooltip" data-placement="right" data-original-title="Add Drugs & Iv Fluids"></i>
                                                            </a>
                                                        </th>
                                                        <th class="input-width-mini">Day</th>
                                                        <th class="input-width-mini">
                                                            <span>
                                                                <a class="btn btn-success btn-view antibiotic_add btn_add" href="javascript:void(0);"><i
                                                                    class="fa fa-plus"></i></a>
                                                                </span>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if(isset($antibiotics) && count($antibiotics) > 0): ?>
                                                        <?php $__currentLoopData = $antibiotics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td class="full-width"><?php echo Form::select('A_Antibiotic['.$key.']',['0'=>'N/A']+ValuelistHelpers::getDrugIvFluidsAntibiotic(),$data['Antibiotic'],['class'=>"form-control sepsis-antibiotic"]); ?></td>
                                                            <td class="input-width-mini"><input type="text" class="input-width-mini form-control" name="A_Day[<?php echo e($key, false); ?>]" value="<?php echo $data['Day'];; ?>"/></td>
                                                            <td class="input-width-mini"><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>
                                                        </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php else: ?>
                                                        <tr>
                                                            <td class="full-width"><?php echo Form::select('A_Antibiotic[]',['0'=>'N/A']+ValuelistHelpers::getDrugIvFluidsAntibiotic(),'',['class'=>"form-control sepsis-antibiotic"]); ?></td>
                                                            <td class="input-width-mini"><input type="text" class="input-width-mini form-control" name="A_Day[]"  value=""/></td>
                                                            <td class="input-width-mini"><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>
                                                        </tr>
                                                        <?php endif; ?>
                                                    </tbody>
                                                </table>
                                                <table>
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="3"><label for="A_Day[]" generated="true" class="error help-block"></label></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control">
                                                    <?php echo Form::label('CRP','CRP mg per L:'); ?>

                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    <?php echo Form::text('CRP',null,['class'=>'form-control']); ?>

                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control">
                                                    <?php echo Form::label('TLC','TLC per cu.mm:'); ?>

                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    <?php echo Form::text('TLC',null,['class'=>'form-control']); ?>

                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control">
                                                    <?php echo Form::label('Percentage','Percentage N:'); ?>

                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    <?php echo Form::text('Percentage',null,['class'=>'form-control']); ?>

                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control">
                                                    <?php echo Form::label('ANC','ANC per cu.mm:'); ?>

                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    <?php echo Form::text('ANC',null,['class'=>'form-control']); ?>

                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control mt-0">
                                                    <?php echo Form::label('Platelets','Platelets per cu.mm:'); ?>

                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    <?php echo Form::text('Platelets',null,['class'=>'form-control']); ?>

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
                                                    <?php echo Form::label('other_drugs','Other Drugs:'); ?>

                                                    <a href="javascript:void(0)" class="add_master_data" data-modal_header="Drugs & Iv Fluids" data-destination_elements="a_nonantibiotic_temp,drugs[]" data-option_value="id" data-option_text="generic_pharmacological_name" data-mas_table="mas_drugivfluid">
                                                        <i class="fa fa-info-circle bs-tooltip" data-placement="right" data-original-title="Add Drugs & Iv Fluids"></i>
                                                    </a>
                                                </div>
                                                <div class="hidden">
                                                 <?php echo Form::select('a_nonantibiotic_temp',['0'=>'N/A']+ValuelistHelpers::getDrugIvFluidsNonAntibiotic(),'',['class'=>"input-width-medium  form-control"]); ?>

                                             </div>
                                             <div class="col-md-9 custom-input">
                                                <table class="sep_drugs table table-add-more full-width-fix table-layout-fixed">
                                                    <thead>                                    
                                                        <tr class="master-add-header">
                                                            <th class="full-width">
                                                                <i class="fa fa-reorder"></i>Add More
                                                            </th>
                                                            <th class="input-width-mini">
                                                                <span>
                                                                    <a class="btn btn-success btn-view sep_drugs_add btn_add" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                                                                </span>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if(isset($drugs) && count($drugs) > 0): ?>
                                                        <?php $__currentLoopData = $drugs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if(preg_match('/[a-zA-Z]/', $data)): ?>
                                                        <tr>
                                                            <td class="full-width"><?php echo Form::text('drugs['.$key.']',$data,['class'=>"form-control sepsis-non-antibiotic"]); ?></td>
                                                            <td class="input-width-mini"><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>
                                                        </tr>
                                                        <?php else: ?>
                                                        <tr>
                                                            <td class="full-width"><?php echo Form::select('drugs['.$key.']',['0'=>'N/A']+ValuelistHelpers::getDrugIvFluidsNonAntibiotic(),$data,['class'=>"form-control sepsis-non-antibiotic"]); ?></td>
                                                            <td class="input-width-mini"><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>
                                                        </tr>
                                                        <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php else: ?>
                                                        <tr>
                                                            <td class="full-width"><?php echo Form::select('drugs[]',['0'=>'N/A']+ValuelistHelpers::getDrugIvFluidsNonAntibiotic(),'',['class'=>"form-control sepsis-non-antibiotic"]); ?></td>
                                                            <td class="input-width-mini"><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>
                                                        </tr>
                                                        <?php endif; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control md-mt-50">
                                                <?php echo Form::label('BloodCulture','Blood Culture:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('BloodCulture',[''=>'N/A','Not sent' => "Not sent","Awaited"=>"Awaited","Negative"=>"Negative","Positive"=>"Positive"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('BloodCulture')]); ?>

                                            </div>
                                        </div>
                                        <div class="hidden">
                                            <?php echo Form::select('temp_organism',[''=>'N/A']+ValuelistHelpers::organizam(),'',['class'=>"input-width-medium  form-control"]); ?>

                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('Organism','Organism:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <table class="organizam table table-add-more full-width-fix">
                                                    <thead>                                    
                                                        <tr class="master-add-header">
                                                            <th class="full-width">
                                                                <i class="fa fa-reorder"></i>Add More
                                                            </th>
                                                            <th>
                                                                <span>
                                                                    <a class="btn btn-success btn-view organizam_add btn_add" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                                                                </span>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if(isset($results->Organism) && is_array($results->Organism) && count($results->Organism) > 0): ?>
                                                        <?php $__currentLoopData = $results->Organism; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td class="full-width"><?php echo Form::select('Organism['.$key.']',ValuelistHelpers::organizam(),$data,['class'=>'form-control']); ?></td>
                                                            <td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>
                                                        </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php else: ?>
                                                        <tr>
                                                            <td class="full-width"><?php echo Form::select('Organism[]',ValuelistHelpers::organizam(),null,['class'=>'form-control']); ?></td>
                                                            <td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>
                                                        </tr>
                                                        <?php endif; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-0">
                                                <?php echo Form::label('PositiveBlood','Positive Blood Culture DOL:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::text('PositiveBlood',null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control md-mt-50">
                                                <?php echo Form::label('lumbar_puncture','Lumbar puncture:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('lumbar_puncture',['Performed'=>'Performed','Not Performed' => "Not Performed","Not Indicated"=>"Not Indicated"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('BloodCulture')]); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('Meningitis','Meningitis:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('Meningitis',ValuelistHelpers::meningitisValue(),null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('Meningitis')]); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('viral_meningitis','Viral Meningitis/Encephalitis:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <input id="viral_meningitis" name="viral_meningitis"  data-on="Yes" data-off="No"  data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Invasive Form -->
                        <div role="tabpanel" class="tab-pane <?php if($_COOKIE['daycare'] == 'invasform'): ?> active <?php endif; ?>" id="invasform">
                            <div class="col-md-6 col-sm-6">
                                <div class="mt-10 widget box">
                                    <div class="widget-header">
                                        <h4><i class="fa fa-reorder"></i> </h4>
                                    </div>
                                    <div class="widget-content">
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control md-mt-50">
                                                <?php echo Form::label('PeripheralCannula','Peripheral Cannula:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('PeripheralCannula',[''=>'N/A','No' => "No","Yes"=>"Yes"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]); ?>

                                            </div>
                                        </div>
                                <!-- <div class="form-group row">
                                    <table class="form-group sites col-md-12">
                                        <thead>
                                        <tr>
                                            <th>PVC SITES</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(isset($sites) && is_array($sites) && count($sites) > 0): ?>
                                            <?php $__currentLoopData = $sites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><input class="input-width-medium form-control" type="text"
                                                               name="sites[]" value="<?php echo $data;; ?>"/></td>
                                                    <td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            <tr>
                                                <td><input class="input-width-medium form-control" type="text"
                                                           name="sites[]" value=""/></td>
                                                <td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>
                                            </tr>
                                        <?php endif; ?>
                                        </tbody>
                                    </table>
                                    <a class="btn sites_add btn_add" href="javascript:void(0);"><i class="fa fa-plus"></i><span>Add More</span></a>
                                    </div>
                                    
                                    
                                    <div class="form-group row">
                                    <?php echo Form::label('PvcDay','Pvc Day:'); ?>

                                    <?php echo Form::text('PvcDay',null,['class'=>'form-control']); ?>

                                    </div>
                                    <div class="form-group row">
                                    <?php echo Form::label('DayChange','Change:'); ?>

                                    <?php echo Form::select('DayChange',[''=>'N/A',"0" =>"0","1"=>"1","2"=>"2","3"=>"3","4"=>"4"],'',['class'=>'form-control']); ?>

                                </div> -->
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('pvc_number','PVC Number:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('pvc_number',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('PvcComplication','Pvc Complication:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('PvcComplication',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        <?php echo Form::label('Picc','PICC:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('Picc',[''=>'N/A','No' =>"No","Yes"=>"Yes"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('PiccSite','PICC Site:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('PiccSite',[''=>'N/A',"Rt Cubital" => "Rt Cubital","Lt Cubital"=>"Lt Cubital","Rt Subclavian"=>"Rt Subclavian","Lt Subclavian"=>"Lt Subclavian","Rt Saphenous"=>"Rt Saphenous","Lt Saphenous"=>"Lt Saphenous","Rt Femoral"=>"Rt Femoral","Lt Femoral"=>"Lt Femoral","Rt External Jugular"=>"Rt External Jugular","Lt External Jugular"=>"Lt External Jugular"],null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('PiccDay','PICC Day:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('PiccDay',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('PiccComplication','PICC Complication:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('PiccComplication',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        <?php echo Form::label('Uvc','UVC:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('Uvc',[""=>"N/A","No" =>"No","Yes"=>"Yes"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        <?php echo Form::label('UvcPosition','UVC Position:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('UvcPosition',[""=>"N/A","High" =>"High","Low"=>"Low"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default')]); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('UvcDay','UVC Day:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('UvcDay',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('UvcComplication','UVC Complication:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('UvcComplication',null,['class'=>'form-control']); ?>

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
                                        <?php echo Form::label('Uac','UAC:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('Uac',[''=>'N/A','No' =>"No","Yes"=>"Yes"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        <?php echo Form::label('UacPosition','UAC Position:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('UacPosition',[''=>'N/A','High' =>"High","Low"=>"Low"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default')]); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('UacDay','UAC Day:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('UacDay',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('UacComplication','UAC Complication:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('UacComplication',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        <?php echo Form::label('Pac','PAC:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('Pac',[''=>'N/A','No' =>"No","Yes"=>"Yes"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('PacSite','PAC Site:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('PacSite',[''=>'N/A',"Rt Radial" => "Rt Radial","Lt Radial"=>"Lt Radial","Rt Ulnar"=>"Rt Ulnar","Lt Ulnar"=>"Lt Ulnar","Rt Posterior Tibial"=>"Rt Posterior Tibial","Lt Posterior Tibial"=>"Lt Posterior Tibial","Rt Dorsalis Pedis"=>"Rt Dorsalis Pedis","Lt Dorsalis Pedis"=>"Lt Dorsalis Pedis"],null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('PacDay','PAC Day:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('PacDay',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('PacComplication','PAC Complication:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('PacComplication',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Notes Form -->
                <div role="tabpanel" class="tab-pane <?php if($_COOKIE['daycare'] == 'skinform'): ?> active <?php endif; ?>" id="skinform">
                    <div class="col-md-11 ">
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                <?php echo Form::label('SkinICD','Skin ICD:'); ?>

                            </div>
                            <div class="col-md-9 custom-input">
                                <?php echo Form::Select('SkinICD[]',$ICD,null,['class'=>'select2-select-00 full-width-fix','multiple']); ?>

                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control mt-0">
                                <?php echo Form::label('additional_skin_icd','Additional Skin ICD:'); ?>

                            </div>
                            <div class="col-md-9 custom-input">
                                <?php echo Form::textarea('additional_skin_icd',null,['class'=>'form-control', 'rows'=>2]); ?>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 ">
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                <?php echo Form::label('Skin','Skin:'); ?>

                            </div>
                            <div class="col-md-9 custom-input">
                                <?php echo Form::textarea('Skin',null,['class'=>'form-control','rows'=>5]); ?>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- Notes Form -->
                <div role="tabpanel" class="tab-pane <?php if($_COOKIE['daycare'] == 'ropform'): ?> active <?php endif; ?>" id="ropform">
                    <div class="col-md-11 ">
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                <?php echo Form::label('RopICD','Rop ICD:'); ?>

                            </div>
                            <div class="col-md-9 custom-input">
                                <?php echo Form::Select('RopICD[]',$ICD,null,['class'=>'select2-select-00 full-width-fix','multiple']); ?>

                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control mt-0">
                                <?php echo Form::label('additional_rop_icd','Additional Rop ICD:'); ?>

                            </div>
                            <div class="col-md-9 custom-input">
                                <?php echo Form::textarea('additional_rop_icd',null,['class'=>'form-control', 'rows'=>2]); ?>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 ">
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                <?php echo Form::label('Rop','ROP:'); ?>

                            </div>
                            <div class="col-md-9 custom-input">
                                <?php echo Form::textarea('Rop',null,['class'=>'form-control','rows'=>5]); ?>

                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                <?php echo Form::label('Plan','PLAN:'); ?>

                            </div>
                            <div class="col-md-9 custom-input">
                                <?php echo Form::textarea('Plan',null,['class'=>'form-control editer-required','rows'=>6, 'id'=>'plan']); ?>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 <?php if(!in_array('SMS_SENT',$specialPermission)): ?>  <?php endif; ?>" >
                        <table class="table">
                         <tr><th colspan="3"><?php echo Form::label('send_message','Message To Referal Doctor:'); ?></th></tr>
                         <tr>
                             <td colspan="2"><?php echo Form::text('phone',null,['class'=>'form-control','placeholder'=>'Enter Referal Doctor phone number','rows'=>6]); ?></td>
                             <td><?php echo Form::button('Send',['class'=>'btn btn-primary form-control send_message']); ?></td>
                         </tr>
                     </table>
                     <div class="form-group">   
                        <?php echo Form::textarea('send_message',null,['class'=>'form-control','placeholder'=>'Enter your message','rows'=>6]); ?>

                    </div>
                </div>
            </div>
            <!-- Notes Form -->
            <div role="tabpanel" class="tab-pane <?php if($_COOKIE['daycare'] == 'notesform'): ?> active <?php endif; ?>" id="notesform">
                <div class="col-md-8 ">
                    <div class="form-group row">
                        <?php echo Form::label('Notes','Notes:'); ?>

                        <?php echo Form::textarea('Notes',null,['class'=>'form-control','rows'=>8]); ?>

                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane <?php if($_COOKIE['daycare'] == 'reassessment'): ?> active <?php endif; ?> reassessment-class" id="reassessment">
                <div class="col-md-12" id="reassessmentsheet">
                    <div class="col-md-12 col-sm-12 col-xs-12 <?php if(count($daycare_reassessment) == 0): ?> hide <?php endif; ?>">
                        <button type="button" class="btn btn-block btn-theme-warning save-button-shadow form-control input-width-large pull-right" onclick="$('#print_flag').val('4'); $(form).submit();">
                            <i class="fa fa-print"></i>
                            <span>Print Reassessment</span>
                        </button>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                    <?php if(count($daycare_reassessment) > 0): ?>
                    <?php $assesment_number = 1;
                     ?>
                    <?php $__currentLoopData = $daycare_reassessment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assessment_key => $assessment_values): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo Form::hidden('reassessment_id_old['.$assessment_key.']',$assessment_values['id']); ?>

                    <div class="reassment-sheet-group row">
                        <div class="mt-10 widget box row mx-0">
                            <div class="widget-header">
                                <h4>
                                    <i class="fa fa-reorder"></i> Assessment <?php echo e($assesment_number, false); ?> 
                                </h4>
                                <button type="button" class="btn btn-danger btn-view pull-right remove-sheet-group mt-5">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                            <div class="widget-content">
                                <div class="col-md-6 col-sm-6">
                                    <div class="mt-10 widget box">
                                        <div class="widget-header">
                                            <h4><i class="fa fa-reorder"></i> </h4>
                                        </div>
                                        <div class="widget-content">
                                            <div class="form-group row">
                                                <?php $assesment_date = date('Y',strtotime($assessment_values['reassessment_date'])) > 1970 ? date('d-m-Y',strtotime($assessment_values['reassessment_date'])) : '' ; ?> 
                                                <div class="col-md-3 text-right label-control">
                                                    <?php echo Form::label("reassessment_date","Date:"); ?> 
                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    <?php echo Form::hidden('reassessment_id['.$assessment_key.']',$assessment_values['id']); ?>

                                                    <?php echo Form::text("reassessment_date[".$assessment_key."]",$assesment_date,["class"=>"form-control", "readonly"]); ?>

                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                                    <?php echo Form::label("reassessment_time","Time:"); ?>

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
                                                        <?php
                                                        $time = explode(':', $assessment_values['reassessment_time']);
                                                        $hour = $time[0];
                                                        $mins = $time[1];
                                                        $session = $time[2];
                                                        ?>
                                                        <div class="col-xs-4">
                                                            <?php echo Form::select("reassessment_time[".$assessment_key."]",$times["time"],$hour,["class"=>"form-control"]); ?>

                                                        </div>
                                                        <div class="col-xs-4">                                        
                                                            <?php echo Form::select("reassessment_min[".$assessment_key."]",$times["mins"],$mins,["class"=>"form-control"]); ?>

                                                        </div>
                                                        <div class="col-xs-4">
                                                            <?php echo Form::select("reassessment_am[".$assessment_key."]",$times["period"],$session,["class"=>"form-control"]); ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                 
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control">
                                                    <?php echo Form::label('reassessment_seen_by','Seen By', ['class'=>'required-label']); ?>

                                                    <a href="javascript:void(0)" class="add_master_data" data-modal_header="Seen By" data-destination_elements="Surgeon,seenby" data-option_value="id" data-option_text="Name" data-mas_table="mas_doctors">
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
                                                                        <a class="btn btn-success btn-view seen_by_add btn_add" href="javascript:void(0);">
                                                                            <i class="fa fa-plus"></i>
                                                                        </a>
                                                                    </span>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $reassessment_seen_by = json_decode($assessment_values['reassessment_seen_by']);
                                                            ?>
                                                            <?php if(isset($reassessment_seen_by) && !empty($reassessment_seen_by) && count($reassessment_seen_by) > 0): ?>
                                                            <?php $__currentLoopData = $reassessment_seen_by; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $reassessment_seen_by): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td>
                                                                    <?php echo Form::select('reassessment_seen_by['.$key.']',$DoctorMaster,$reassessment_seen_by,['class'=>'form-control full-width']); ?>

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
                                                                    <?php echo Form::select('reassessment_seen_by[]',$DoctorMaster,null,['class'=>'form-control full-width']); ?>

                                                                </td>
                                                            </tr>
                                                            <?php endif; ?> 
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control">
                                                    <?php echo Form::label("reassessment_ventilater","Ventilator Support:"); ?>

                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    <?php echo Form::select("reassessment_ventilater[".$assessment_key."]",[" "=>"- - N/A - -","No"=>"No","Yes"=>"Yes"],$assessment_values['reassessment_ventilater'],["class"=>"form-control"]); ?>

                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control">
                                                    <?php echo Form::label("reassessment_cpap","CPAP / HHHFNC:"); ?>

                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    <?php echo Form::select("reassessment_cpap[".$assessment_key."]",[" "=>"- - N/A - -","No"=>"No","Yes"=>"Yes"],$assessment_values['reassessment_cpap'],["class"=>"form-control"]); ?>

                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control">
                                                    <?php echo Form::label("reassessment_nc","NC:"); ?>

                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    <?php echo Form::select("reassessment_nc[".$assessment_key."]",[" "=>"- - N/A - -","No"=>"No","Yes"=>"Yes"],$assessment_values['reassessment_nc'],["class"=>"form-control"]); ?>

                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control">
                                                    <?php echo Form::label("reassesment_room_air","Room air:"); ?>

                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    <?php echo Form::select("reassesment_room_air[".$assessment_key."]",[" "=>"- - N/A - -","No"=>"No","Yes"=>"Yes"],$assessment_values['reassesment_room_air'],["class"=>"form-control"]); ?>

                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control">
                                                    <?php echo Form::label("reassessment_rr","RR:"); ?>

                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    <?php echo Form::text("reassessment_rr[".$assessment_key."]",$assessment_values['reassessment_rr'],["class"=>"form-control"]); ?>

                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control">
                                                    <?php echo Form::label("reassessment_spo2","SPO2:"); ?>

                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    <?php echo Form::text("reassessment_spo2[".$assessment_key."]",$assessment_values['reassessment_spo2'],["class"=>"form-control"]); ?>

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
                                                    <?php echo Form::label("reassemant_cvs","CVS:"); ?>

                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    <?php echo Form::text("reassemant_cvs[".$assessment_key."]",$assessment_values['reassemant_cvs'],["class"=>"form-control"]); ?>

                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control">
                                                    <?php echo Form::label("reassessment_systalic_bp","Systolic BP:"); ?>

                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    <?php echo Form::text("reassessment_systalic_bp[".$assessment_key."]",$assessment_values['reassessment_systalic_bp'],["class"=>"form-control"]); ?>

                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control">
                                                    <?php echo Form::label("reassessment_diastolic_bp","Diastolic BP:"); ?>

                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    <?php echo Form::text("reassessment_diastolic_bp[".$assessment_key."]",$assessment_values['reassessment_diastolic_bp'],["class"=>"form-control"]); ?>

                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control">
                                                    <?php echo Form::label("reassessment_bp","Mean BP:"); ?>

                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    <?php echo Form::text("reassessment_bp[".$assessment_key."]",$assessment_values['reassessment_bp'],["class"=>"form-control"]); ?>

                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control">
                                                    <?php echo Form::label("reassessment_hr","HR:"); ?>

                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    <?php echo Form::text("reassessment_hr[".$assessment_key."]",$assessment_values['reassessment_hr'],["class"=>"form-control"]); ?>

                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control">
                                                    <?php echo Form::label("reassemant_rs","RS:"); ?>

                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    <?php echo Form::text("reassemant_rs[".$assessment_key."]",$assessment_values['reassemant_rs'],["class"=>"form-control"]); ?>

                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control">
                                                    <?php echo Form::label("reassemant_gi","GI:"); ?>

                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    <?php echo Form::text("reassemant_gi[".$assessment_key."]",$assessment_values['reassemant_gi'],["class"=>"form-control"]); ?>

                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control">
                                                    <?php echo Form::label("reassemant_cns","CNS:"); ?>

                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    <?php echo Form::text("reassemant_cns[".$assessment_key."]",$assessment_values['reassemant_cns'],["class"=>"form-control"]); ?>

                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control">
                                                    <?php echo Form::label("additional_assessment","Additional Information:"); ?>

                                                </div>
                                                <div class="col-md-9 custom-input">
                                                    <?php echo Form::textarea("additional_assessment[".$assessment_key."]",$assessment_values['additional_assessment'],["class"=>"form-control"]); ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $assesment_number++; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>               
                    <?php endif; ?>  
                    </div>
                </div> 
                <div class="col-md-12">
                    <span>
                        <a class="btn btn-success reassessment-add remove-episode pull-right mb-15 btn_add" href="javascript:void(0);"><i class="fa fa-plus-circle"></i> Add Assessment</a>
                    </span> 
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="media_tab">
                <input type="hidden" name="module_name" value="4">
                <?php echo $__env->make('registration.media', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
            <?php echo e(Form::hidden('formstatus', 1), false); ?>

            <div class="col-md-11 col-sm-12">
                <input type="hidden" name="print_flag" <?php if($_COOKIE['daycare'] == 'ropform' || $_COOKIE['daycare'] == 'notesform' || $_COOKIE['daycare'] == 'reassessment'): ?> value="0" <?php else: ?> value="2" <?php endif; ?> id="print_flag"/>
                <?php if(!isset($flow_wise_register) || empty($flow_wise_register) || $flow_wise_register != 'from-dashboard'): ?>  
                <?php if(!Session::has('registration_start')): ?>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <button type="submit" class="btn btn-primary btn-block save-button-shadow form-control daycare_save_btn" data-flag="0"><i class="fa fa-floppy-o"></i>
                        <span><?php echo $SubmitButtonText; ?></span>
                    </button>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <button type="button" class="btn  btn-block save-button-shadow btn-primary form-control daycare_save_btn" data-flag="2"><i class="fa fa-floppy-o"></i>
                        <span>Update</span>
                    </button>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <button type="button" class="btn btn-block btn-info  save-button-shadow form-control daycare_save_btn" data-flag="1"><i class="fa fa-print"></i>
                        <span>Print</span>
                    </button>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <a href="<?php echo e(action('Admission\DaycareController@index'), false); ?>" class="btn btn-block btn-default save-button-shadow form-control" onclick="$('form')[0].reset();">
                        <i class="fa fa-exclamation-circle"></i> 
                        <span>Cancel</span>
                    </a>
                </div>
                <?php else: ?>
                <div class="<?php if($_COOKIE['daycare'] == 'ropform' || $_COOKIE['daycare'] == 'notesform' || $_COOKIE['daycare'] == 'reassessment'): ?> col-md-3 col-sm-4 col-xs-12 <?php else: ?> col-md-6 col-sm-4 <?php endif; ?> set-column">
                    <button type="button" class="btn btn-block btn-info save-next save-button-shadow form-control"><i class="fa fa-floppy-o"></i>
                        <span><?php if($_COOKIE['daycare'] == 'ropform' || $_COOKIE['daycare'] == 'notesform' || $_COOKIE['daycare'] == 'reassessment'): ?> Finish <?php else: ?> Next <?php endif; ?></span>
                    </button>
                </div>
                <div class="<?php if($_COOKIE['daycare'] == 'ropform' || $_COOKIE['daycare'] == 'notesform' || $_COOKIE['daycare'] == 'reassessment'): ?> col-md-3 col-sm-4 col-xs-12 <?php else: ?> hide <?php endif; ?> print-tag">
                    <button type="button"  onclick="$('#print_flag').val('1'); $(form).submit();" class="btn btn-block btn-info  save-button-shadow form-control"><i class="fa fa-print"></i>
                        <span> Print</span>
                    </button>
                </div>
                <div class="<?php if($_COOKIE['daycare'] == 'ropform' || $_COOKIE['daycare'] == 'notesform' || $_COOKIE['daycare'] == 'reassessment'): ?> col-md-3 col-sm-4 col-xs-12 <?php else: ?> col-md-6 col-sm-4 col-xs-12 <?php endif; ?> set-column">
                    <a href="<?php echo e(action('Admission\DaycareController@index'), false); ?>" class="btn btn-default btn-block save-button-shadow form-control" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> <span>Cancel</span></a>
                </div>
                <?php endif; ?>  

                <?php else: ?>  
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <button type="button" class="btn btn-block btn-info save-button-shadow form-control daycare_save_btn" data-flag="2"><i class="fa fa-floppy-o"></i>
                        <span>Update</span>
                    </button>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <button type="button" class="btn btn-block btn-primary save-button-shadow form-control daycare_create_next_btn daycare_save_btn" data-flag="8">
                        <i class="fas fa-bed"></i>
                        <span>Next</span>
                    </button>
                </div>
                <div class=" col-md-3 col-sm-4 col-xs-12 hide">
                    <button type="button" class="btn btn-block btn-info  save-button-shadow form-control daycare_create_finish_btn daycare_save_btn" data-flag="1"><i class="fa fa-print"></i>
                        <span> Print</span>
                    </button>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12 hide">
                    <button type="button" class="btn btn-block btn-primary save-button-shadow form-control daycare_create_finish_btn daycare_save_btn" data-flag="9">
                        <i class="fas fa-bed"></i>
                        <span>Ward Dashboard</span>
                    </button>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-12 set-column">
                    <a href="<?php echo e(action('Admission\DaycareController@index'), false); ?>" class="btn btn-default btn-block save-button-shadow form-control" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> <span>Cancel</span></a>
                </div>
                <?php endif; ?>    
            </div>
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
    var current_active_tab = $('#daycare-form li[class="active"]').children('a').attr('aria-controls');
    if(current_active_tab == 'reassessment')
    {
        $('.daycare_create_finish_btn').parent().removeClass('hide');
        $('.daycare_create_next_btn').parent().addClass('hide');
    }
    $('#daycare-form li').click(function()
    {
        var current_active_tab = $(this).children('a').attr('aria-controls');
        if(current_active_tab == 'reassessment')
        {
            $('.daycare_create_finish_btn').parent().removeClass('hide');
            $('.daycare_create_next_btn').parent().addClass('hide');
        }
        else
        {
            $('.daycare_create_finish_btn').parent().addClass('hide');
            $('.daycare_create_next_btn').parent().removeClass('hide');
        }
    });
    <?php endif; ?>

    /* PLUGIN USED FOR FORM LOCAL STORAGE */
    $("form").sisyphus({customKeySuffix: "pediatric", locationBased: true});
    jQuery('#CGA').keyup(function () {
    //this.value = this.value.replace(/[^0-9]/g, '');
    });
    
    jQuery('#UO').keyup(function () {

        this.value = this.value.replace(/[^0-9.]/g, '');

    });
    
    // $('#PreviousWt').keyup(function () {
    //     this.value = this.value.replace(/[^0-9]/g, '');
    // });
    // $('#CurrentWt').keyup(function () {
    //     this.value = this.value.replace(/[^0-9]/g, '');
    // });
    // $('#WtChange').keyup(function () {
    //     this.value = this.value.replace(/[^0-9]/g, '');
    // });
    // $('#PercentageChange').keyup(function () {
    //     this.value = this.value.replace(/[^0-9]/g, '');
    // });
    
    var input  = $('[name="PreviousWt"],[name="CurrentWt"]'),
    input1 = $('[name="PreviousWt"]'),
    input2 = $('[name="CurrentWt"]'),
    input3 = $('[name="WtChange"]'),
    input4 = $('[name="PercentageChange"]');
    input.change(function () {
        input4.val('');
        input3.val('');
        if(input2.val().trim() != '' && input1.val().trim()!=''){ 
            var WeightChange = parseInt(input2.val())-parseInt(input1.val());
            input3.val(WeightChange);
            var PercentageChange = (parseInt(WeightChange) / parseInt(input1.val())) * 100;
            input4.val(PercentageChange.toFixed(1));
        }    
    });
    // $('#MAP').keyup(function () {
    //    this.value = this.value.replace(/[^0-9]/g, '');
    // });
    // $('#FiO2').keyup(function () {
    //   this.value = this.value.replace(/[^0-9]/g, '');
    // });
    // $('#PaO2').keyup(function () {
    //  this.value = this.value.replace(/[^0-9]/g, '');
    // });
    //$('#OI').keyup(function () {
    //   this.value = this.value.replace(/[^0-9]/g, '');
    // });
    // var OI = $('[name="MAP"],[name="FiO2"],[name="PaO2"]'),
    //         MAP = $('[name="MAP"]'),
    //         FiO2 = $('[name="FiO2"]'),
    //         PaO2 = $('[name="PaO2"]'),
    //         OIVAL = $('[name="OI"]');
    // OI.change(function () {
    //     if (MAP.val() == "") {
    //     }
    //     if (FiO2.val() == "") {
    //     }
    //     if (PaO2.val() == "") {
    //     }
    //     var Total_ol = (parseInt(MAP.val()) * parseInt(FiO2.val())) / parseInt(PaO2.val());
    //     OIVAL.val(Total_ol.toFixed(1));
    // });
    
    //active class 
    <?php if(!Session::has('registration_start')): ?>   
    $('.nav-tabs li a').click(function() {
            // $('#set_active').val($(this).attr('aria-controls'));
        if ($("#daycare-form").valid() === false) {
          $("#daycare-form").valid();
          return false;
      }
      submitForm();
      $.cookie('daycare', $(this).attr('href').replace('#',''));
      var not_flow_menu = $(this).attr('href').replace('#','');
      if (not_flow_menu == 'ropform' || not_flow_menu == 'notesform' || not_flow_menu =='reassessment') {
        $('input[name="formstatus"]').val(2);
    } else {
        $('input[name="formstatus"]').val(1);
    }
});
    <?php else: ?> 
    
    $('.nav-tabs li a').click(function() {
            // $('#set_active').val($(this).attr('aria-controls'));
        if ($("#daycare-form").valid() === false) {
          $("#daycare-form").valid();
          return false;
      }
      submitForm();
      setactiveMenu($(this).attr('href').replace('#','')); 
      setFinish($(this).attr('href').replace('#',''));
      setprintOption($(this).attr('href').replace('#',''));
  });

    $('.save-next').click(function(e) {

        e.preventDefault();
        var next_tab = $('.nav-tabs > .active').next('li').find('a');
        if(next_tab.length>0){
            next_tab.trigger('click');
        }
        else{                
            $('#daycare-form').submit();
        }

       //  if ($(this).text().trim() !='Finish' ) {

       //     var daycareId = $('.nav-tabs li[class="active"]').next('li').children('a').attr('href').replace('#','');

       //     if (daycareId != 'ropform' || daycareId != 'notesform' || daycareId !='reassessment') {
       //         setactiveMenu(daycareId);
       //     }
       //  }

       // $('#daycare-form').submit();  
    });

    function setactiveMenu(menu) {
        $.cookie('daycare', menu);
    }

    function setFinish(daycareId) {

       // if (daycareId == 'ropform' || daycareId == 'notesform' || daycareId =='reassessment') {
     if (daycareId =='reassessment') {

         $('.save-next span').text('Finish');
         $('input[name="print_flag"]').val(0);

     } else {
         $('.save-next span').text('Next');
         $('input[name="print_flag"]').val(2);
     }
 }
 function setprintOption(menu) {

  if (menu == 'ropform' || menu == 'notesform' || menu =='reassessment') {

     $('.print-tag').addClass('col-md-3').removeClass('hide');
     $('.set-column').removeClass('col-md-6').addClass('col-md-3')
     $('input[name="formstatus"]').val(2);

 } else {

     $('.print-tag').removeClass('col-md-3').addClass('hide');
     $('.set-column').removeClass('col-md-3').addClass('col-md-6');
     $('input[name="formstatus"]').val(1);

 }

}  
<?php endif; ?>

$(document).ready(function(){
    var pageHeight = $('.container').height() + $('.crumbs').height() + $('.page-header').height() + $('.nav-tabs').height();
    $('#reassessment').css('min-height',$(window).height()-(pageHeight+85));
    
    $('.reassessment-add').click(function(){
        // var reassessmentCount = ($('#reassessmentsheet .col-md-6').length/2)+1;
        var reassessmentCount = $('input[name^="reassessment_date"]').last().attr('name');
        if (typeof reassessmentCount != 'undefined') {
            reassessmentCount = reassessmentCount.replace(/[^0-9]/g,'');
            reassessmentCount = parseInt(reassessmentCount) + 1;
        } else {
            reassessmentCount = 0;
        }

        var reassessmentFields  = '<div class="reassment-sheet-group row">';
        reassessmentFields += '<div class="mt-10 widget box row mx-0">';
        reassessmentFields += '<div class="widget-header">';
        reassessmentFields += '<h4>';
        reassessmentFields += '<i class="fa fa-reorder"></i> Assessment '+(reassessmentCount + 1)+' ';
        reassessmentFields += '</h4>';
        reassessmentFields += '<button type="button" class="btn btn-danger btn-view pull-right remove-sheet-group mt-5">';
        reassessmentFields += '<i class="fa fa-trash"></i>';
        reassessmentFields += '</button>';
        reassessmentFields += '</div>';
        reassessmentFields += '<div class="widget-content">';
        reassessmentFields += '<div class="col-md-6 col-sm-6">';
        reassessmentFields += '<div class="mt-10 widget box">';
        reassessmentFields += '<div class="widget-header">';
        reassessmentFields += '<h4><i class="fa fa-reorder"></i> </h4>';
        reassessmentFields += '</div>';
        reassessmentFields += '<div class="widget-content">';
        reassessmentFields += '<div class="form-group row">';
        reassessmentFields += '<div class="col-md-3 text-right label-control">';
        reassessmentFields += '<label for="reassessment_date">Date:</label> ';
        reassessmentFields += '</div>';
        reassessmentFields += '<div class="col-md-9 custom-input">';
        reassessmentFields += '<input class="form-control"  readonly name="reassessment_date['+reassessmentCount+']" type="text">';
        reassessmentFields += '</div>';
        reassessmentFields += '</div>';
        reassessmentFields += '<div class="form-group row">';
        reassessmentFields += '<div class="col-md-3 text-right label-control" style="margin-top: 25px;">';
        reassessmentFields += '<label for="reassessment_time">Time:</label>';
        reassessmentFields += '</div>';
        reassessmentFields += '<div class="col-md-9 custom-input clear-xs">';
        reassessmentFields += '<div class="row">';
        reassessmentFields += '<div class="col-xs-4 text-center">';
        reassessmentFields += '<small>(Hour)</small>';
        reassessmentFields += '</div>';
        reassessmentFields += '<div class="col-xs-4 text-center">';
        reassessmentFields += '<small>(Minute)</small>';
        reassessmentFields += '</div>';
        reassessmentFields += '<div class="col-xs-4 text-center">';
        reassessmentFields += '<small>(Session)</small>';
        reassessmentFields += '</div>';
        reassessmentFields += '<div class="col-xs-4">';
        reassessmentFields += '<select name="reassessment_time['+reassessmentCount+']" class="form-control"><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option></select>';
        reassessmentFields += '</div>';
        reassessmentFields += '<div class="col-xs-4">';
        reassessmentFields += '<select name="reassessment_min['+reassessmentCount+']" class="form-control"><option value="00">00</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option><option value="32">32</option><option value="33">33</option><option value="34">34</option><option value="35">35</option><option value="36">36</option><option value="37">37</option><option value="38">38</option><option value="39">39</option><option value="40">40</option><option value="41">41</option><option value="42">42</option><option value="43">43</option><option value="44">44</option><option value="45">45</option><option value="46">46</option><option value="47">47</option><option value="48">48</option><option value="49">49</option><option value="50">50</option><option value="51">51</option><option value="52">52</option><option value="53">53</option><option value="54">54</option><option value="55">55</option><option value="56">56</option><option value="57">57</option><option value="58">58</option><option value="59">59</option></select>';
        reassessmentFields += '</div>';
        reassessmentFields += '<div class="col-xs-4">';
        reassessmentFields += '<select name="reassessment_am['+reassessmentCount+']" class="form-control"><option value="AM">AM</option><option value="PM">PM</option></select>';
        reassessmentFields += '</div>';
        reassessmentFields += '</div>';
        reassessmentFields += '</div>';
        reassessmentFields += '</div>';
        reassessmentFields += '<div class="form-group row">';
        reassessmentFields += '<div class="col-md-3 text-right label-control">';
        reassessmentFields += '<label for="seenby" class="required-label">Seen By</label>';
        reassessmentFields += '<a href="javascript:void(0)" class="add_master_data" data-modal_header="Seen By" data-destination_elements="Surgeon,seenby" data-option_value="id" data-option_text="Name" data-mas_table="mas_doctors">';
        reassessmentFields += '<i class="fa fa-info-circle bs-tooltip add-neo-consultant" data-placement="right" data-original-title="Add Doctor in masters."></i>';
        reassessmentFields += '</a>';
        reassessmentFields += '</div>';
        var option_select = $("select[name='neonatal_seen_by']").html();
        reassessmentFields += '<div class="col-md-9 custom-input">';
        reassessmentFields += '<table class="reassessment-seen-by-div table table-add-more full-width-fix">';
        reassessmentFields += '<thead>';
        reassessmentFields += '<tr class="master-add-header">';
        reassessmentFields += '<th class="full-width">';
        reassessmentFields += '<i class="fa fa-reorder"></i>Add More';
        reassessmentFields += '</th>';
        reassessmentFields += '<th>';
        reassessmentFields += '<span>';
        reassessmentFields += '<a class="btn btn-success btn-view reassessment_seen_by_add btn_add" href="javascript:void(0);">';
        reassessmentFields += '<i class="fa fa-plus"></i>';
        reassessmentFields += '</a>';
        reassessmentFields += '</span>';
        reassessmentFields += '</th>';
        reassessmentFields += '</tr>';
        reassessmentFields += '</thead>';
        reassessmentFields += '<tbody>';
        reassessmentFields += '<tr data-len="0">';
        reassessmentFields += '<td>';
        reassessmentFields += '<select class="form-control full-width" name="reassessment_seen_by['+reassessmentCount+']">';
        reassessmentFields += option_select;
        reassessmentFields += '</select>';
        reassessmentFields += '</td>';
        reassessmentFields += '<td>';
        reassessmentFields += '</td>';
        reassessmentFields += '</tr>';
        reassessmentFields += '</tbody>';
        reassessmentFields += '</table>';
        reassessmentFields += '</div>';
        reassessmentFields += '</div>';
        reassessmentFields += '<div class="form-group row">';
        reassessmentFields += '<div class="col-md-3 text-right label-control">';
        reassessmentFields += '<label for="reassessment_ventilater">Ventilator Support:</label>';
        reassessmentFields += '</div>';
        reassessmentFields += '<div class="col-md-9 custom-input">';
        reassessmentFields += '<select name="reassessment_ventilater['+reassessmentCount+']" class="form-control"><option value=" ">- - N/A - -</option><option value="No">No</option><option value="Yes">Yes</option></select>';
        reassessmentFields += '</div>';
        reassessmentFields += '</div>';
        reassessmentFields += '<div class="form-group row">';
        reassessmentFields += '<div class="col-md-3 text-right label-control">';
        reassessmentFields += '<label for="reassessment_cpap">CPAP / HHHFNC:</label>';
        reassessmentFields += '</div>';
        reassessmentFields += '<div class="col-md-9 custom-input">';
        reassessmentFields += '<select name="reassessment_cpap['+reassessmentCount+']" class="form-control"><option value=" ">- - N/A - -</option><option value="No">No</option><option value="Yes">Yes</option></select>';
        reassessmentFields += '</div>';
        reassessmentFields += '</div>';
        reassessmentFields += '<div class="form-group row">';
        reassessmentFields += '<div class="col-md-3 text-right label-control">';
        reassessmentFields += '<label for="reassessment_nc">NC:</label>';
        reassessmentFields += '</div>';
        reassessmentFields += '<div class="col-md-9 custom-input">';
        reassessmentFields += '<select name="reassessment_nc['+reassessmentCount+']" class="form-control"><option value=" ">- - N/A - -</option><option value="No">No</option><option value="Yes">Yes</option></select>';
        reassessmentFields += '</div>';
        reassessmentFields += '</div>';
        reassessmentFields += '<div class="form-group row">';
        reassessmentFields += '<div class="col-md-3 text-right label-control">';
        reassessmentFields += '<label for="reassesment_room_air">Room air:</label>';
        reassessmentFields += '</div>';
        reassessmentFields += '<div class="col-md-9 custom-input">';
        reassessmentFields += '<select name="reassesment_room_air['+reassessmentCount+']" class="form-control"><option value=" ">- - N/A - -</option><option value="No">No</option><option value="Yes">Yes</option></select>';
        reassessmentFields += '</div>';
        reassessmentFields += '</div>';
        reassessmentFields += '<div class="form-group row">';
        reassessmentFields += '<div class="col-md-3 text-right label-control">';
        reassessmentFields += '<label for="reassessment_rr">RR:</label>';
        reassessmentFields += '</div>';
        reassessmentFields += '<div class="col-md-9 custom-input">';
        reassessmentFields += '<input class="form-control" name="reassessment_rr['+reassessmentCount+']" type="text">';
        reassessmentFields += '</div>';
        reassessmentFields += '</div>';
        reassessmentFields += '<div class="form-group row">';
        reassessmentFields += '<div class="col-md-3 text-right label-control">';
        reassessmentFields += '<label for="reassessment_spo2">SPO2:</label>';
        reassessmentFields += '</div>';
        reassessmentFields += '<div class="col-md-9 custom-input">';
        reassessmentFields += '<input class="form-control" name="reassessment_spo2['+reassessmentCount+']" type="text">';
        reassessmentFields += '</div>';
        reassessmentFields += '</div>';
        reassessmentFields += '</div>';
        reassessmentFields += '</div>';
        reassessmentFields += '</div>';
        reassessmentFields += '<div class="col-md-6 col-sm-6">';
        reassessmentFields += '<div class="mt-10 widget box">';
        reassessmentFields += '<div class="widget-header">';
        reassessmentFields += '<h4><i class="fa fa-reorder"></i> </h4>';
        reassessmentFields += '</div>';
        reassessmentFields += '<div class="widget-content">';
        reassessmentFields += '<div class="form-group row">';
        reassessmentFields += '<div class="col-md-3 text-right label-control">';
        reassessmentFields += '<label for="reassemant_cvs">CVS:</label>';
        reassessmentFields += '</div>';
        reassessmentFields += '<div class="col-md-9 custom-input">';
        reassessmentFields += '<input class="form-control" name="reassemant_cvs['+reassessmentCount+']" type="text">';
        reassessmentFields += '</div>';
        reassessmentFields += '</div>';
        reassessmentFields += '<div class="form-group row">';
        reassessmentFields += '<div class="col-md-3 text-right label-control">';
        reassessmentFields += '<label for="reassessment_systalic_bp">Systolic BP:</label>';
        reassessmentFields += '</div>';
        reassessmentFields += '<div class="col-md-9 custom-input">';
        reassessmentFields += '<input class="form-control" name="reassessment_systalic_bp['+reassessmentCount+']" type="text">';
        reassessmentFields += '</div>';
        reassessmentFields += '</div>';
        reassessmentFields += '<div class="form-group row">';
        reassessmentFields += '<div class="col-md-3 text-right label-control">';
        reassessmentFields += '<label for="reassessment_diastolic_bp">Diastolic BP:</label>';
        reassessmentFields += '</div>';
        reassessmentFields += '<div class="col-md-9 custom-input">';
        reassessmentFields += '<input class="form-control" name="reassessment_diastolic_bp['+reassessmentCount+']" type="text">';
        reassessmentFields += '</div>';
        reassessmentFields += '</div>';
        reassessmentFields += '<div class="form-group row">';
        reassessmentFields += '<div class="col-md-3 text-right label-control">';
        reassessmentFields += '<label for="reassessment_bp">Mean BP:</label>';
        reassessmentFields += '</div>';
        reassessmentFields += '<div class="col-md-9 custom-input">';
        reassessmentFields += '<input class="form-control" name="reassessment_bp['+reassessmentCount+']" type="text">';
        reassessmentFields += '</div>';
        reassessmentFields += '</div>';
        reassessmentFields += '<div class="form-group row">';
        reassessmentFields += '<div class="col-md-3 text-right label-control">';
        reassessmentFields += '<label for="reassessment_hr">HR:</label>';
        reassessmentFields += '</div>';
        reassessmentFields += '<div class="col-md-9 custom-input">';
        reassessmentFields += '<input class="form-control" name="reassessment_hr['+reassessmentCount+']" type="text">';
        reassessmentFields += '</div>';
        reassessmentFields += '</div>';
        reassessmentFields += '<div class="form-group row">';
        reassessmentFields += '<div class="col-md-3 text-right label-control">';
        reassessmentFields += '<label for="reassemant_rs">RS:</label>';
        reassessmentFields += '</div>';
        reassessmentFields += '<div class="col-md-9 custom-input">';
        reassessmentFields += '<input class="form-control" name="reassemant_rs['+reassessmentCount+']" type="text">';
        reassessmentFields += '</div>';
        reassessmentFields += '</div>';
        reassessmentFields += '<div class="form-group row">';
        reassessmentFields += '<div class="col-md-3 text-right label-control">';
        reassessmentFields += '<label for="reassemant_gi">GI:</label>';
        reassessmentFields += '</div>';
        reassessmentFields += '<div class="col-md-9 custom-input">';
        reassessmentFields += '<input class="form-control" name="reassemant_gi['+reassessmentCount+']" type="text">';
        reassessmentFields += '</div>';
        reassessmentFields += '</div>';
        reassessmentFields += '<div class="form-group row">';
        reassessmentFields += '<div class="col-md-3 text-right label-control">';
        reassessmentFields += '<label for="reassemant_cns">CNS:</label>';
        reassessmentFields += '</div>';
        reassessmentFields += '<div class="col-md-9 custom-input">';
        reassessmentFields += '<input class="form-control" name="reassemant_cns['+reassessmentCount+']" type="text">';
        reassessmentFields += '</div>';
        reassessmentFields += '</div>';
        reassessmentFields += '<div class="form-group row">';
        reassessmentFields += '<div class="col-md-3 text-right label-control">';
        reassessmentFields += '<label for="additional_assessment">Additional Information:</label>';
        reassessmentFields += '</div>';
        reassessmentFields += '<div class="col-md-9 custom-input">';
        reassessmentFields += '<textarea class="form-control" name="additional_assessment['+reassessmentCount+']" cols="50" rows="10"></textarea>';
        reassessmentFields += '</div>';
        reassessmentFields += '</div>';
        reassessmentFields += '</div>';
        reassessmentFields += '</div>';
        reassessmentFields += '</div>';
        reassessmentFields += '</div>';
        reassessmentFields += '</div>';
        reassessmentFields += '</div>';

        $('#reassessmentsheet .col-md-12:last-child').append(reassessmentFields);
        $('.datepicker').datepicker();
        var current_time = new Date();
        var date = current_time.getDate();
        var month = current_time.getMonth() + 1;
        var year = current_time.getFullYear();
        var hour = current_time.getHours();
        var session = 'AM';
        if (hour > 12) {
            hour = hour - 12;
            session = 'PM'
        } else {
            hour = hour == 0 ? "12" : hour;
        }
        var mins = current_time.getMinutes();
        hour = hour > 9 ? hour : '0' + hour; 
        mins = mins > 9 ? mins : '0' + mins; 
        $('select[name="reassessment_time['+reassessmentCount+']"]').val(hour).trigger('change');
        $('select[name="reassessment_min['+reassessmentCount+']"]').val(mins).trigger('change');
        $('select[name="reassessment_am['+reassessmentCount+']"]').val(session).trigger('change');
        var query_date = year + '-' + month + '-' + date + ' ' + hour + ':' + mins + ' ' + session;
        getReassessmentMachineRecords(query_date, reassessmentCount);
        $('#reassessmentsheet').find('.btn-theme-warning').parent().removeClass('hide');
    });
    
});

function getReassessmentMachineRecords(select_date_time, field_sub_name) {
    
    var baby_id = $('input[name="BabyId"]').val();
    var admission_id = $('input[name="AdmissionId"]').val();
    
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        data: {baby_id: baby_id, admission_id: admission_id, select_date_time: select_date_time, reassessment: true},
        url: "<?php echo e(action('Admission\DaycareController@getTodayMachineRecords'), false); ?>",
        success: function (response) {
            var results = response.results;
            var daycare_id = response.daycare_id;
            
            $.each(daycare_id, function(index, value) {
                $('input[name="' +value + '[' + field_sub_name + ']"]').val(results[value]);
            });
        }
    });
}

$(document).on('click','.remove-sheet-group',function(){

    $(this).parents('.reassment-sheet-group').remove();
    if ($('.reassment-sheet-group').length == 0) {        
        $('#reassessmentsheet').find('.btn-theme-warning').parent().addClass('hide');
    }
    
});  

$( drag_init );

function drag_init() {
  $( ".droppable-area1, .droppable-area2" ).sortable({
      connectWith: ".connected-sortable",
      stack: '.connected-sortable ul',
      update: function( event, ui ) {
        update_problems();            
    },
});
  $( ".droppable-area1, .droppable-area2" ).disableSelection();
} 
function update_problems()
{
    // var cur_problems = [];
    var cur_problems = $('.droppable-area1').find('li').filter(function() {
        return $(this).find('ul').length === 0;
    }).map(function(i, e) {
        return $(this).text().replace('\n', '');
    }).get().join('||');
    $('#hidden_current_problem').val(cur_problems);

    var prev_problems = $('.droppable-area2').find('li').filter(function() {
        return $(this).find('ul').length === 0;
    }).map(function(i, e) {
        return $(this).text().replace('\n', '');
    }).get().join('||');
    $('#hidden_prev_problem').val(prev_problems);


}

$("#add_cur_problem").click(function() {
    var cur_prob = prompt("Enter Current Problem:");
    if (cur_prob) {
        var $delete_cur_prob = $("<a />", {"class": "btn btn-danger btn-view remove_problems"})
        .html("<i class='fa fa-trash'>")
        .click(deleteHandler);
        var $drag_cur_prob = $("<a />", {"class": "btn btn-default btn-view"}).html("<i class='fas fa-arrows-alt'></i>");

        var $edit_cur_prob = $("<a />", {"class": "btn btn-info btn-view edit_problem"}).html("<i class='fa fa-edit'></i>");


        $("<li />", {"class": "draggable-item"})
        .text(cur_prob)
        .append($delete_cur_prob)
        .append($edit_cur_prob)
        .append($drag_cur_prob)
        .appendTo(".droppable-area1");
    }
    
    update_problems();            
    return false;
});
$("#add_prev_problem").click(function() {
    var cur_prob = prompt("Enter Previous Problem:");
    if (cur_prob) {
        var $delete_cur_prob = $("<a />", {"class": "btn btn-danger btn-view remove_problems"})
        .html("<i class='fa fa-trash'>")
        .click(deleteHandler);
        var $drag_cur_prob = $("<a />", {"class": "btn btn-default btn-view"}).html("<i class='fas fa-arrows-alt'></i>");
        
        var $edit_cur_prob = $("<a />", {"class": "btn btn-info btn-view edit_problem"}).html("<i class='fa fa-edit'></i>");

        $("<li />", {"class": "draggable-item"})
        .text(cur_prob)
        .append($delete_cur_prob)
        .append($edit_cur_prob)
        .append($drag_cur_prob)
        .appendTo(".droppable-area2");
    }
    
    update_problems();            
    return false;
});
function deleteHandler() {

}
$(document).on('click', '.remove_problems', function()
{
    var element = $(this);
    var yes =  confirm("Are you confirm to delete this problem ?");
    if(yes)
    {
        element.parent().remove();
        update_problems();            
    }
});

$(document).on('click', '.edit_problem', function()
{
    var element = $(this).parent().text();

    var cur_prob = prompt("Enter Previous Problem:", element);

    if (cur_prob) {
        var prob = $(this).parent().html();
        prob = prob.replace(element, cur_prob);
        $(this).parent().html(prob);
        update_problems();            
    }
});
<?php if(isset($already_filled_days) && !empty($already_filled_days)): ?>

var exclude = [<?php echo '"'.implode('","',  $already_filled_days ).'"' ?>];

<?php else: ?>

var exclude = [];
<?php endif; ?>
function unavailable(date) {
    var tempoMonth = (date.getMonth()+1);
    var tempoDate = (date.getDate());
    if (tempoMonth < 10) tempoMonth = '0' + tempoMonth;
    if (tempoDate < 10) tempoDate = '0' + tempoDate;
    var dmy = date.getFullYear() + '-' + tempoMonth + '-' + tempoDate;
    if ($.inArray(dmy, exclude) == -1) {
        return [true, ""];
    } else {
        return [false, "", "Unavailable"];
    }
}


$('.daycare-date').datepicker({
    beforeShowDay: unavailable,
    dateFormat: 'dd-mm-yy',
    yearRange: "-01:+00",
    changeMonth : true,
    changeYear : true,  
    maxDate:'+0M',
    minDate:'-12M'
});
$(document).on('click', '.daycare_save_btn', function(e){
    if ($('#daycare-form').valid() === true) {
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
            data: $('#daycare-form input, #daycare-form select, #daycare-form textarea').serialize(),
            url: "<?php echo e(action('Admission\DaycareController@update', $results->DayId), false); ?>",
            success: function (response) {
                if (print_flag == 1) {
                    Showalert('success', 'Daycare details updated successfully');
                    window.location.href = response.print_url;
                }
                else if(print_flag == 2)
                {
                    Showalert('success', 'Daycare details updated successfully');
                    // window.location.href = response.edit_url;
                    $('.daycare_save_btn').prop('disabled', false);
                    current_clicked_element.html('<i class="fa fa-floppy-o" aria-hidden="true"></i> <span>Update</span>');
                }
                else if(print_flag == 8)
                {
                    Showalert('success', 'Daycare details updated successfully');
                    $('.daycare_save_btn').prop('disabled', false);
                    current_clicked_element.html('<i class="fa fa-floppy-o" aria-hidden="true"></i><span>Next</span>');

                    var next_tab = $('#daycare-form .nav-tabs .active').next('li').find('a');
                    if(next_tab.length>0){
                        next_tab.trigger('click');
                    }else{

                    }
                    $("html, body").animate({ scrollTop: 0 }, 500);
                }
                else if(print_flag == 9)
                {
                    Showalert('success', 'Daycare details updated successfully');
                    window.location.href = response.ward_dashboard_url;
                }
                else
                {
                    Showalert('success', 'Daycare details updated successfully');
                    window.location.href = response.list_url; 
                }
            },
            error: function(response)
            {
                console.log(response.responseText);
                Showalert('error', 'Something went wrong, Please try again later...!');
                $('.daycare_save_btn').prop('disabled', false);
                current_clicked_element.html(current_clicked_html);
            }
        });
    }
});   
function submitForm()
{
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: $('#daycare-form input, #daycare-form select, #daycare-form textarea').serialize(),
        url: "<?php echo e(action('Admission\DaycareController@update', $results->DayId), false); ?>",
        success: function (response) {

        },
        error: function()
        {

        }
    });
} 
</script>
<?php echo $__env->make('daycare.daycare_scripts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>  
<script type="text/javascript">
    // calculateCorrectedGestation();
    // $('#DayDate').change(function(){
    //     calculateCorrectedGestation();
    // });
    $('#DayDate').trigger('change');

    $(document).ready(function() {

        if ($('#ModeOfVentilation').val() != '') {
          $('#ModeOfVentilation').trigger('change');
      }

      $('input[name^=reassessment_date]').datepicker({
        dateFormat: 'dd-mm-yy'
    });

  });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>