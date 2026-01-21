<?php $__env->startSection('content'); ?>
<!-- Breadcrumbs line -->
<?php $active = 'dischargeform'; ?>
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li>
            <a href="<?php echo e(url('/'), false); ?>"><i class="fa fa-home"></i></a>
        </li>
        <li class="">
            <a title="" href="<?php echo e(action('Admission\NicuController@dischargeList'), false); ?>">
                Discharge Details
            </a>
        </li>
        <li class="">
            <a title="" href="<?php echo e(action('Admission\NicuController@dischargeSublist',\SiteHelpers::encrypt_id($results->BabyId)), false); ?>">
                Admission List
            </a>
        </li>
        <li class="current">
            <a title="">Discharge <?php if(isset($results->BabyName) && !empty($results->BabyName)): ?> For <?php echo e($results->BabyName, false); ?> <?php endif; ?> <?php if(isset($results->BMrNo) && !empty($results->BMrNo)): ?>  <?php echo e($results->BMrNo, false); ?>   <?php endif; ?></a>
        </li>
    </ul>
    <div class="pull-right">
        <?php 
        $mrn = $results->BMrNo; 

        echo \SiteHelpers::menuList($mrn, $results->AdmissionId, 'nicu_discharge');
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

        <?php echo Form::model($results,['method' => 'PATCH','url' => action('Admission\NicuController@dischargeupdate',$results->NicuId),'id' => 'admissionProforma-form', 'class'=>'nicu-admission-form']); ?>

        <?php echo $__env->make('errors.list', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <!-- Nav tabs -->
        <div role="tabpanel" class="tabbable tabbable-custom">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" <?php if($active == 'dischargeform'): ?>  class="active" <?php endif; ?>>
                    <a href="#dischargeform" aria-controls="dischargeform" role="tab" data-toggle="tab">Discharge Details</a>
                </li>
                <li role="presentation" <?php if($active == 'Checkform'): ?>  class="active" <?php endif; ?>>
                    <a href="#Checkform" aria-controls="Checkform" role="tab" data-toggle="tab">Checklist</a>
                </li>
            </ul>
            <!-- Tab panes -->

            <div class="tab-content tab-view-shadow nicu-table">
                <!-- Discharge -->
                <div role="tabpanel" class="tab-pane <?php if($active == 'dischargeform'): ?> active <?php endif; ?>" id="dischargeform">
                    <div class="col-md-6 col-sm-6">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <?php echo Form::hidden('BabyId'); ?>

                                    <?php echo Form::hidden('MotherId'); ?>

                                            <?php echo Form::hidden('ip_number',$results->ip_number,['class'=>'form-control ip_number']); ?>

                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('status','Status:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php
                                            $nicu_status = $results->patient_log_status == 'discharged' ? '' : ' custom-disabled cursor-not-allowed ';
                                            $nicu_tab_index = $results->patient_log_status == 'discharged' ? '' : '-1';
                                        ?>
                                        <?php echo Form::select('status',ValuelistHelpers::Discharge_Status(),null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <?php echo Form::label('DischargeDate','Date of Discharge / Transfered:', ['class'=>'required-label']); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::hidden('DOB',null,['class'=>'form-control datepicker dob_date birth-date','readonly']); ?>

                                        <?php echo Form::hidden('AdmissionDate',null,['class'=>'form-control admission-date', 'readonly' => 'true']); ?>                                            
                                        <?php echo Form::text('DischargeDate',null,['class'=>'form-control datepicker record-date', 'readonly']); ?>

                                    </div>
                                </div>
                                <div class="form-group row DischargeTransferedTime">
                                    <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                        <?php echo Form::label('DischargeTransferedTime','Time of Discharge / Transfered:'); ?>

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
                                                <?php echo Form::select('DischargeTransferedTime',$NAT['time'],null,['class'=>'form-control ']); ?>

                                            </div>
                                            <div class="col-xs-4">
                                                <?php echo Form::select('DischargeTransferedTime_MINS',$NAT['mins'],null,['class'=>'form-control ']); ?>

                                            </div>
                                            <div class="col-xs-4">
                                                <?php echo Form::select('DischargeTransferedTime_AM',[''=>'N/A','AM'=>'AM','PM'=>'PM'],null,['class'=>'form-control ']); ?>

                                            </div>
                                        </div>
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
                                    <!-- <?php echo Form::label('CorrectedGestation','Gestation at discharge (Corrected Gestational Age):'); ?> -->
                                    <?php echo Form::label('CorrectedGestation','Corrected Gestation at discharge:'); ?>

                                </div>
                                <div class="col-md-9 custom-input clear-xs">
                                    <div class="row col-md-12 display-flex">
                                        <div>
                                            <?php echo Form::hidden('g_weeks',null,['class'=>'form-control gestation-wks','max'=>'46','readonly']); ?>

                                            <?php echo Form::hidden('g_days',null,['class'=>'form-control gestation-days','max'=>'6','readonly']); ?>

                                            <small>(In Weeks)</small>
                                            <?php echo Form::text('dcg_weeks',null,['class'=>'form-control corrected-gestation-wks', 'readonly']); ?>

                                            <label class="error help-block" for="dcg_weeks" generated="true"></label>
                                        </div>
                                        <div class="inbeween_two_fields">
                                            <span>+</span>
                                        </div>
                                        <div>
                                            <small>(In Days)</small>
                                            <?php echo Form::text('dcg_days',null,['class'=>'form-control corrected-gestation-days', 'readonly']); ?>

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
                                                <?php 
                                                    $vaccine = \SiteHelpers::arrayKeyConversion($vaccine);
                                                    $vaccine_date = \SiteHelpers::arrayKeyConversion($vaccine_date);
                                                ?>
                                                <?php $__currentLoopData = $vaccine; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td class="form-group full-width"><?php echo Form::select('Vaccine['.$key.']',['N/A'=>'N/A']+ValuelistHelpers::Vaccine(),$vaccine[$key],['class'=>'select2-select-00 full-width']); ?>

                                                    </td>
                                                    <?php $vaccine_date[$key] = (isset($vaccine_date[$key]) && !empty($vaccine_date[$key]) && $vaccine_date[$key] != 'null' && $vaccine_date[$key] != null && !@unserialize($vaccine_date[$key]) !== false) ? $vaccine_date[$key] : '' ?>
                                                    <td class="form-group"> <?php echo Form::text('VaccineDate['.$key.']',$vaccine_date[$key],['class'=>'input-width-small form-control datepicker ', 'readonly']); ?>

                                                    </td>
                                                    <td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                        <th>Additional Instruction</th>
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
                                    <?php $__currentLoopData = $medications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $medi_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo Form::select('M_Drugs['.$key.']',$drug_master,$medi_data['Medication'],['class'=>'drugs-changes drug-list-name'.$l,'data-id'=>$l, 'style'=>'width: 300px;']); ?></td>
                                        <td><?php echo Form::text('m_generic_name['.$key.']',$medi_data['genericname'],['class'=>'form-control generic_name'.$l]); ?></td>
                                        <td><?php echo Form::select('formulation['.$key.']',ValuelistHelpers::formulationStrength($medi_data['formulation']),$medi_data['formulation'],['class'=>'form-control formulation'.$l]); ?></td>
                                        <td class="input-width-medium"><?php echo Form::select('M_Dose['.$key.']',[''=>'N/A']+ValuelistHelpers::dose(),$medi_data['Dose'],['class'=>'form-control']); ?></td>
                                        <td class="input-width-medium"><?php echo Form::select('M_Frequency['.$key.']',$mas_frequency_list,$medi_data['Frequency'],['class'=>'form-control']); ?></td>
                                        <td class="input-width-medium">
                                            <?php echo Form::select('M_Duration['.$key.']',[''=>'N/A']+ValuelistHelpers::medicationDuration(),$medi_data['Duration'],['class'=>'form-control']); ?>

                                        </td>
                                        <td><?php echo Form::textarea('additional_instruction['.$key.']',$medi_data['additional_instruction'],['class'=>'form-control', 'rows'=>1]); ?></td>                                        
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
                                        <td><?php echo Form::textarea('additional_instruction[]',null,['class'=>'form-control', 'rows'=>1]); ?></td>
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
                                        <?php echo Form::textarea('cranial_ultrasound', null,['class'=>'form-control editer-required','rows'=>'5','cols'=>'5']); ?>

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
                                        <?php echo Form::textarea('echocardiography', null,['class'=>'form-control editer-required','rows'=>'5','cols'=>'5']); ?>

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
                                                <?php 
                                                    $procedures_list = json_decode($results->procedures);
                                                    $procedures_list = (array)$procedures_list;
                                                ?>
                                                <?php if(count($procedures_list) > 0): ?>
                                                    <?php $__currentLoopData = $procedures_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $procedures): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>   
                                                    <tr>
                                                        <td><?php echo Form::select('procedures['.$key.']', [''=>'N/A']+$procedure_master, $procedures,['class'=>'form-control']); ?></td>
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
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('hospital_acquired_infection', 'Hospital acquired infection:', ['class'=>'required-label']); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('hospital_acquired_infection', [''=>'-- Please Select --','Yes'=>'Yes','No'=>'No'],null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('ventilator_associated_pneumonia', 'Ventilator associated pneumonia:', ['class'=>'required-label']); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('ventilator_associated_pneumonia', [''=>'-- Please Select --','Yes'=>'Yes','No'=>'No'],null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('blood_stream_infections','Blood stream infections:', ['class'=>'required-label']); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('blood_stream_infections',[''=>'-- Please Select --','Yes'=>'Yes','No'=>'No'],null,['class'=>'form-control']); ?>

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

                        <?php echo e(Form::hidden('next_module', @$next_module), false); ?>


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
                        
                        <div class="col-md-3 col-sm-4 col-xs-12 print-summary hide">
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
                        <div class="col-md-3 col-sm-4 col-xs-12 hide">
                            <button type="button" class="btn btn-block flow-finish-btn save-button-shadow btn-info form-control nicu_admission_create" data-flag="1"> <i class="fa fa-floppy-o"></i>
                            <span>  Print Summary</span>
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
             $(document).ready(function () {

                <?php if(isset($flow_wise_register) && !empty($flow_wise_register) && $flow_wise_register == 'from-dashboard'): ?>
                    var current_tab = $('#admissionProforma-form .nav.nav-tabs li[class="active"]').children('a').attr('aria-controls');
                    console.log(current_tab);
                    if (current_tab == 'Checkform') {
                        $('.flow-finish-btn').parent().removeClass('hide');
                        $('.flow-next-btn').parent().addClass('hide');
                    }
                    $('#admissionProforma-form .nav.nav-tabs li').click(function()
                    {
                        var current_tab = $(this).children('a').attr('aria-controls');
                        if (current_tab == 'Checkform') {
                            $('.flow-finish-btn').parent().removeClass('hide');
                            $('.flow-next-btn').parent().addClass('hide');
                        }
                        else
                        {
                            $('.flow-finish-btn').parent().addClass('hide');
                            $('.flow-next-btn').parent().removeClass('hide');
                        }
                    });
                <?php endif; ?>
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
                    var next_module = $('input[name="next_module"]').val();

                    var next_tab = $('.nav-tabs > .active').next('li').find('a');

                    if (next_tab.length > 0) {
                        next_tab.trigger('click');
                        if (next_tab == 'Checkform' && next_module != 'transfertopostnatal') {
                            $('.print-summary').removeClass('hide');
                        }
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

                    if (multiple_pregnancy && typeof multiple_pregnancy != 'undefined' && (tab_id == 'Diagform' || tab_id == 'Checkform') && next_module != 'transfertopostnatal') {
                        $('.save-next').addClass('next-baby');
                        $('.save-next').html('<i class="fa fa-floppy-o"></i><span> Next Baby</span>');
                    } else if (!multiple_pregnancy && typeof multiple_pregnancy == 'undefined' && (tab_id == 'Diagform' || tab_id == 'Checkform') && next_module != 'transfertopostnatal') {
                        $('.save-next').html('<i class="fa fa-floppy-o"></i><span> Finish</span>');
                    } else if (next_module == 'transfertopostnatal') {
                        $('input[name="print_flag"]').val(15);
                        $('.save-next').html('<i class="fa fa-floppy-o"></i><span> Postnatal Admission</span>');                       
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
    // if ($("#admissionProforma-form").valid() === false) {
    //     $("#admissionProforma-form").valid();
    //     return false;
    // }
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
                    var next_module = $('input[name="next_module"]').val();

                    if (menuActive == 'Checkform' && next_module != 'transfertopostnatal') {
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



function drugsStrength(drug_id, id) {
        if (drug_id == null || !(drug_id > 0)) {
            Showalert('error', 'Please select valid drug');
            $('.formulation' + id).html('');
            $('.generic_name' + id).val('');
        } else {
            $.ajax({
                Type: 'GET',
                url: '<?php echo e(url("masters/drugs-strength/"), false); ?>' + '/' + drug_id,
                success: function (responseText) {

                    var option = '<option value="">N/A</option>';
                    var generic_name = '';
                    var formulation = '';

                    $.each(responseText, function (index, values) {
                        if (values.Value != '' && values.Value != null) {
                            option += '<option value="' + values.Id + '">' + values.Value + '</option>';
                            generic_name = values.generic_name;
                            formulation = values.Id;

                        }
                    });

                    $('.formulation' + id).html(option);
                    $('.generic_name' + id).val(generic_name);
                    $('.formulation' + id).val(formulation);
                },
                error: function (responseText) {

                    var option = '<option value="">No data found</option>';
                    var generic_name = 'No data found';
                    $('.formulation' + id).html(option);
                    $('.generic_name' + id).val(generic_name);
                }

            });
        }
}

$(document).on('change', '.drugs-changes', function () {
    var drug_id = $(this).val();
    var id = $(this).data('id');
    drugsStrength(drug_id, id);
});


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
            url: "<?php echo e(action('Admission\NicuController@dischargeupdate', $results->NicuId), false); ?>",
            success: function (response) {
                if (print_flag == 1) {
                   Showalert('success', 'NICU discharge details updated successfully');
                   window.location.href = response.daycare_summary_url;
                }
                else if (print_flag == 2) {
                   $('.nicu_admission_create').prop('disabled', false);
                   Showalert('success', 'NICU discharge details updated successfully');
                   // window.location.href = response.edit_url;
                   current_clicked_element.html('<i class="fa fa-floppy-o" aria-hidden="true"></i> <span>Update</span>');
                }
                else if (print_flag == 8) {
                    Showalert('success', 'NICU discharge details updated successfully');
                    $('.nicu_admission_create').prop('disabled', false);
                    current_clicked_element.html('<i class="fa fa-floppy-o" aria-hidden="true"></i><span> Next</span>');

                    var next_tab = $('#admissionProforma-form .nav-tabs .active').next('li').find('a');
                    console.log(next_tab);
                    if(next_tab.length>0){
                        next_tab.trigger('click');
                    }
                }
                else if (print_flag == 9) {
                    Showalert('success', 'NICU discharge details updated successfully');
                    window.location.href = response.ward_dashboard_url;
                }
                else {
                   Showalert('success', 'NICU discharge details updated successfully');
                   window.location.href = response.discharge_list_url;
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
        url: "<?php echo e(action('Admission\NicuController@dischargeupdate', $results->NicuId), false); ?>",
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