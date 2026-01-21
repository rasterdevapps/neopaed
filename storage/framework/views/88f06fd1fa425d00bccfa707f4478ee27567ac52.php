<?php $__env->startSection('content'); ?>
<?php if(!Session::has('NeonatalDichargeList')): ?>
<?php $actionUrl = action('Registration\NeonatalController@index')  ?>
<?php else: ?>
<?php $actionUrl = action('Registration\NeonatalController@neonatalDichargelist')  ?>
<?php endif; ?>
<!-- Breadcrumbs line -->
<?php 
// if (!isset($_COOKIE['neonatal_proforma']) || empty($_COOKIE['neonatal_proforma'])) {
$_COOKIE['neonatal_proforma'] = 'babyform'; 
// } 
if(!isset($_COOKIE['neonatal_proforma_sub']) || empty($_COOKIE['neonatal_proforma_sub'])) {
$_COOKIE['neonatal_proforma_sub'] = 'vitals';
}
$frequency_list = ValuelistHelpers::drugFrequencyList();
?>
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="<?php echo e(url('/'), false); ?>">Dashboard</a>
        </li>
        <li>
            <?php if(!Session::has('NeonatalDichargeList')): ?>
            <a title="" href="<?php echo e(action('Registration\NeonatalController@index'), false); ?>">Neonatal Proforma</a>
            <?php else: ?>
            <a title="" href="<?php echo e(action('Registration\NeonatalController@neonatalDichargelist'), false); ?>">Neonatal Discharge Details</a>
            <?php endif; ?>
        </li>
        <li class="current">
            <a href="javascript:void(0);" title="">Edit <?php if(isset($results->BabyName) && !empty($results->BabyName)): ?> For <?php echo e($results->BabyName, false); ?> <?php endif; ?> <?php if(isset($results->BMrNo) && !empty($results->BMrNo)): ?>   <?php echo e($results->BMrNo, false); ?>  <?php endif; ?></a>
        </li>
    </ul>
    <div class="pull-right">
        <?php 
        $mmrn = $results->BMrNo; 
        echo \SiteHelpers::menuList($mmrn, 'neonatal_proforma');
        ?>
    </div>
</div>
<style type="text/css">
    .select-free-text2
    {
    z-index: 1;
    }
</style>
<!-- /Breadcrumbs line -->
<div class="row row-spacing">
    <div class="col-md-12 neonatal-edit">
        <?php echo Form::model($results,['method'=> 'PATCH','url' => action('Registration\NeonatalController@update',$results->NeonatalId),'id' => 'neonatalPerforma-form', 'class' => 'm-0']); ?>

        <?php echo $__env->make('errors.list', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <!-- Nav tabs -->
        <div role="tabpanel" class="tabbable tabbable-custom">
            <ul class="nav nav-tabs" role="tablist" id="neonate-next">
                <?php if(!Session::has('NeonatalDichargeList')): ?>
                <!-- <li role="presentation" <?php if($_COOKIE['neonatal_proforma'] == 'babyform'): ?> class="active" <?php endif; ?>> -->
                <li role="presentation" class="active">
                    <a class="tab-main-menu" href="#babyform" aria-controls="babyform" role="tab" data-toggle="tab">Baby Details</a>
                </li>
                <!--    <li role="presentation"  <?php if($_COOKIE['neonatal_proforma'] == 'motherform'): ?> class="active" <?php endif; ?>>
                    <a class="tab-main-menu" href="#motherform" aria-controls="motherform" role="tab" data-toggle="tab">Parental Details</a>
                    </li> -->
                <!-- <li role="presentation" <?php if($_COOKIE['neonatal_proforma'] == 'obform'): ?> class="active" <?php endif; ?>> -->
                <li role="presentation">
                    <a class="tab-main-menu" href="#obform" aria-controls="obform" role="tab" data-toggle="tab">Obstetric History</a>
                </li>
                <!-- <li role="presentation" <?php if($_COOKIE['neonatal_proforma'] == 'pgform'): ?> class="active" <?php endif; ?>> -->
                <li role="presentation">
                    <a class="tab-main-menu" href="#pgform" aria-controls="pgform" role="tab" data-toggle="tab">Pregnancy</a>
                </li>
                <!-- <li role="presentation" <?php if($_COOKIE['neonatal_proforma'] == 'pgcform'): ?> class="active" <?php endif; ?>> -->
                <li role="presentation">
                    <a class="tab-main-menu" href="#pgcform" aria-controls="pgcform" role="tab" data-toggle="tab">Pregnancy Contd</a>
                </li>
                <!-- <li role="presentation" <?php if($_COOKIE['neonatal_proforma'] == 'labform'): ?> class="active" <?php endif; ?>> -->
                <li role="presentation">
                    <a class="tab-main-menu" href="#labform" aria-controls="labform" role="tab" data-toggle="tab">Labour</a>
                </li>
                <!-- <li role="presentation" <?php if($_COOKIE['neonatal_proforma'] == 'delform'): ?> class="active" <?php endif; ?>> -->
                <li role="presentation">
                    <a class="tab-main-menu" href="#delform" aria-controls="delform" role="tab" data-toggle="tab">Delivery</a>
                </li>
                <!-- <li role="presentation" <?php if($_COOKIE['neonatal_proforma'] == 'apgarform'): ?> class="active" <?php endif; ?>> -->
                <li role="presentation">
                    <a class="tab-main-menu" href="#apgarform" aria-controls="apgarform" role="tab" data-toggle="tab">APGAR</a>
                </li>
                <!-- <li role="presentation" <?php if($_COOKIE['neonatal_proforma'] == 'resform'): ?> class="active" <?php endif; ?>> -->
                <li role="presentation">
                    <a class="tab-main-menu" href="#resform" aria-controls="resform" role="tab" data-toggle="tab">Resuscitation Details</a>
                </li>
                <!-- <li role="presentation" <?php if($_COOKIE['neonatal_proforma'] == 'essform'): ?> class="active" <?php endif; ?>> -->
                <li role="presentation">
                    <a class="tab-main-menu" href="#essform" aria-controls="essform" role="tab" data-toggle="tab">Essential Details</a>
                </li>
                <?php if($results->BirthStatus == 'Inborn'): ?>
                <!-- <li role="presentation" <?php if($_COOKIE['neonatal_proforma'] == 'newbornform'): ?> class="active" <?php endif; ?>> -->
                <li role="presentation">
                    <a class="tab-main-menu" href="#newbornform" aria-controls="newbornform" role="tab" data-toggle="tab">New Born Examination</a>
                </li>
                <?php endif; ?>
                <?php else: ?>
                <!-- <li role="presentation" <?php if($_COOKIE['neonatal_proforma'] == 'dischargeform'): ?> class="active" <?php endif; ?>> -->
                <li role="presentation">
                    <a class="tab-main-menu" href="#dischargeform" aria-controls="dischargeform" role="tab" data-toggle="tab">Discharge Details</a>
                </li>
                <!-- <li role="presentation" <?php if($_COOKIE['neonatal_proforma'] == 'summaryform'): ?> class="active" <?php endif; ?>> -->
                <li role="presentation">
                    <a class="tab-main-menu" href="#summaryform" aria-controls="summaryform" role="tab" data-toggle="tab">Summary</a>
                </li>
                <?php endif; ?>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content tab-curve tab-view-shadow">
                <!-- <div role="tabpanel" class="tab-pane <?php if($_COOKIE['neonatal_proforma'] == 'babyform'): ?> active <?php endif; ?>" id="babyform"> -->
                <div role="tabpanel" class="tab-pane active" id="babyform">
                    <div class="col-md-6 col-sm-6" id="baby-category">
                        <div class="widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <?php echo Form::hidden('BabyId',null); ?>

                                <?php echo Form::hidden('MotherId',null); ?>

                                <?php echo Form::hidden('AdmissionId',null); ?>

                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('TestDate','Data Entry Date:', ['class'=>'required-label']); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('TestDate',null,['class'=>'form-control baby-dob', 'readonly' => 'true']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('BabyName','Baby Name:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <div class="display-flex">
                                            <?php 
                                                $default_name = \Config::get('constants.HIS_QUICK_REG_BABY_NAME');
                                                $default_name = strtolower($default_name);
                                            ?>
                                            <?php echo Form::text('BabyName',null,['class'=>'form-control']); ?>

                                            <?php if(str_contains(strtolower($results->BabyName), $default_name)): ?>
                                                <?php echo Form::hidden('BMrNo', null,['id'=>'BMrNo']); ?>

                                                <?php echo Form::hidden('old_baby_name', $results->BabyName); ?>

                                                <?php echo Form::hidden('hms_call'); ?>

                                                <span class="text-danger call-hms-2 pl-15 pt-5" title="Get data from HMS"><i class="fa fa-refresh"></i></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('DOB','DOB:', ['class'=>'required-label']); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('DOB',null,['class'=>'form-control baby-dob', 'readonly' => 'true']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                        <?php echo Form::label('TOB','Time Of Birth:'); ?>

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
                                                <?php echo Form::select('TOB_TIME',$tob['time'],null,['class'=>'form-control']); ?>

                                            </div>
                                            <div class="col-xs-4">
                                                <?php echo Form::select('TOB_MINS',$tob['mins'],null,['class'=>'form-control']); ?>

                                            </div>
                                            <div class="col-xs-4">
                                                <?php echo Form::select('TOB_AM',['AM'=>'AM','PM'=>'PM'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('BirthStatus','Birth Status:', ['class'=>'required-label']); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <input id="BirthStatus" data-size="small" name="BirthStatus" data-off="Outborn" data-on="Inborn" data-width="100" data-toggle="toggle" class="form-control switch-input" type="checkbox" <?php if(isset($results->BirthStatus) && $results->BirthStatus == 'Inborn'): ?> checked="checked" <?php endif; ?>>
                                    </div>
                                </div>
                                <?php $birthweight = (isset($results->BirthWeight) && is_numeric($results->BirthWeight)) ?  $results->BirthWeight/1000 : '' ; ?>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                        <?php echo Form::label('BirthWeight','Birth Weight:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input clear-xs">
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <small>(In Grams)</small>
                                            </div>
                                            <div class="col-xs-6">
                                                <small>(In Kilo Grams)</small>
                                            </div>
                                            <div class="col-xs-6">
                                                <?php echo Form::input('text','BirthWeight',null,['class'=>'form-control']); ?>

                                            </div>
                                            <div class="col-xs-6">
                                                <?php echo Form::input('text','birth_weight',$results->BirthWeight / 1000,['class'=>'form-control','readonly'=>'true', 'id' => 'birth_weight']); ?>

                                            </div>
                                        </div>
                                        <label class="error help-block" for="BirthWeight" generated="true"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                        <?php echo Form::label('Gestation','Gestation:', ['class'=>'required-label']); ?>

                                    </div>
                                    <div class="col-md-9 custom-input clear-xs">
                                        <div class="row col-md-12 display-flex">
                                            <div>
                                                <small>(In Weeks)</small>
                                                <?php echo Form::text('g_weeks',null,['class'=>'form-control']); ?>

                                                <label class="error help-block" for="g_weeks" generated="true"></label> 
                                            </div>
                                            <div class="inbeween_two_fields">
                                                <span>+</span>
                                            </div>
                                            <div>
                                                <small>(In Days)</small>
                                                <?php echo Form::text('g_days',null,['class'=>'form-control']); ?>

                                                <label class="error help-block" for="g_days" generated="true"></label> 
                                            </div>
                                        </div>
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
                                        <?php echo Form::label('TestTime','Data Entry Time:', ['class'=>'required-label']); ?>

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
                                                <?php echo Form::select('TEST_TIME',$tob['time'],null,['class'=>'form-control ']); ?>

                                                <label class="error help-block" for="TEST_TIME" generated="true"></label>
                                            </div>
                                            <div class="col-xs-4">
                                                <?php echo Form::select('TEST_MINS',$tob['mins'],null,['class'=>'form-control']); ?>

                                                <label class="error help-block" for="TEST_MINS" generated="true"></label>
                                            </div>
                                            <div class="col-xs-4">
                                                <?php echo Form::select('TEST_AM',['AM'=>'AM','PM'=>'PM'],null,['class'=>'form-control ']); ?>

                                                <label class="error help-block" for="TEST_AM" generated="true"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <?php echo Form::label('BabyBloodGroup','Baby\'s Blood Group:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('BabyBloodGroup',ValuelistHelpers::Blood_groups(),null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('BirthOrder','Birth Order:'); ?> <i class="fa fa-info-circle bs-tooltip color-black-must" data-placement="right" data-original-title='To edit this field, go to baby registraion and change field "Multiple Pregnancy"'></i>
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('BirthOrder',[''=>'N/A']+ValuelistHelpers::mptypeNobabies(@$results->MultiplePregnancyType),null,['class'=>'form-control', 'readonly']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('Sex','Sex:', ['class'=>'required-label']); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('Sex',['Male'=>'Male','Female'=>'Female','Indeterminate'=>'Indeterminate'],null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('Length','Birth Length (cm):'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('Length',null,['class'=>'form-control','maxlength'=>'4']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <?php echo Form::label('OFC','Birth Head Circumference (cm):'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('OFC',null,['class'=>'form-control','maxlength'=>'4']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('Transfer Status','Transfer Status:', ['class'=>'required-label']); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php if(!isset($flow_wise_register) || empty($flow_wise_register) || $flow_wise_register != 'from-dashboard'): ?> 
                                        <?php if(Session::has('registration_start')): ?>
                                        <?php if(Session::has('admission_module') && \Session::get('admission_module') == 'NICU_ADMISSION'): ?>
                                        <?php echo Form::select('',['NICU'=>'NICU'],'NICU',['class'=>'form-control', 'disabled' => 'disabled']); ?>

                                        <input type="hidden" name="transfer_status" value="NICU" />
                                        <?php else: ?>
                                        <?php echo Form::select('transfer_status',ValuelistHelpers::getTransferstatus(),null,['class'=>'form-control', 'readonly', 'style'=>'pointer-events: none;', 'id'=>'transfer_status']); ?>

                                        <?php endif; ?>
                                        <?php else: ?>
                                        <?php echo Form::select('transfer_status',ValuelistHelpers::getTransferstatus(),$results->transfer_status,['class'=>'form-control', 'id'=>'transfer_status']); ?>

                                        <?php endif; ?>
                                        <?php else: ?>
                                        <?php echo Form::select('',ValuelistHelpers::getTransferstatus(),'NICU',['class'=>'form-control', 'readonly']); ?>

                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div role="tabpanel" class="tab-pane <?php if($_COOKIE['neonatal_proforma'] == 'motherform'): ?> active <?php endif; ?>" id="motherform"> -->
                <div role="tabpanel" class="tab-pane" id="motherform">
                    <div class="col-md-6 col-sm-6">
                        <?php echo Form::hidden('MotherId'); ?>

                        <div class="widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> Mother Details</h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3 text-right label-control">
                                            <?php echo Form::label('MotherTitle','Title:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::select('MotherTitle',[''=>'N/A','Ms.'=>'Ms.','Mrs.'=>'Mrs.','Miss.'=>'Miss.','Dr.'=>'Dr.'],null,['class'=>'form-control','tabindex'=>'1']); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3 text-right label-control">
                                            <?php echo Form::label('MotherInitial','Initial:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::text('MotherInitial',null,['class'=>'form-control text-convertion-upper','tabindex'=>'2']); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3 text-right label-control">
                                            <?php echo Form::label('MotherName','First Name:', ['class'=>'required-label']); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::text('MotherName',null,['class'=>'form-control text-convertion-title','tabindex'=>'3']); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('MotherLastName','Last Name:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('MotherLastName',null,['class'=>'form-control text-convertion-title','tabindex'=>'4']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('MotherDOB','DOB:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('MotherDOB',null,['class'=>'form-control parents-dob','readonly'=>true,'tabindex'=>'5']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('MothercYear','Completed Years:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('MothercYear',null,['class'=>'form-control ','tabindex'=>'6']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <?php echo Form::label('education_status','Mother\'s Education Level:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('education_status',ValuelistHelpers::getEducationstatus(),null,['class'=>'form-control','tabindex'=>'7']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('Occupation','Occupation Type:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('Occupation',null,['class'=>'form-control text-convertion-title','tabindex'=>'8']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <?php echo Form::label('occupation_status','Current Occupation Status:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('occupation_status',ValuelistHelpers::getOccupationstatus(),null,['class'=>'form-control','tabindex'=>'9']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('Mobile','Contact No 1 :'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('Mobile',null,['class'=>'form-control','tabindex'=>'10']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('LandLine','Contact No 2 :'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('LandLine',null,['class'=>'form-control','tabindex'=>'11']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('MotherEmail','Email :'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('MotherEmail',null,['class'=>'form-control','tabindex'=>'12']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right  label-control mt-0">
                                        <?php echo Form::label('MotherSpokenLanguages','Mother Spoken Languages:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('MotherSpokenLanguages',null,['class'=>'form-control text-convertion-title','tabindex'=>'13']); ?>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <p class="divider">&nbsp;</p>
                                </div>
                            </div>
                        </div>
                        <div class="widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> Permanent Address</h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <label for="Address1">Address Line 1 :<br><small class="input-small">(Door /Flat No /Home Name)</small></label>
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('Address1',null,['class'=>'form-control', 'id'=>'Address1','tabindex'=>'14']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <label for="Address2">Address Line 2 :<br><small class="input-small">(Street Name/Building Name)</small></label>
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('Address2',null,['class'=>'form-control', 'id'=>'Address2','tabindex'=>'15']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <label for="Address3">Address Line 3 :<br><small class="input-small">(City)</small></label>
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('Address3',null,['class'=>'form-control', 'id'=>'Address3','tabindex'=>'16']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <label for="Address4">Address Line 4 :<br><small class="input-small">(Pin code/Zip code)</small></label>
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('Address4',null,['class'=>'form-control', 'id'=>'Address4','tabindex'=>'17']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <label for="Address5">Address Line 5 :<br><small class="input-small">(Country)</small></label>
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('Address5',null,['class'=>'form-control', 'id'=>'Address5','tabindex'=>'18']); ?>

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
                                        <?php echo Form::label('PartnerTitle','Title:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('PartnerTitle',[''=>'N/A','Mr.'=>'Mr.','Dr.'=>'Dr.'],null,['class'=>'form-control','tabindex'=>'19']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('PartnerInitial','Initial:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('PartnerInitial',null,['class'=>'form-control text-convertion-upper','tabindex'=>'20']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('PartnerName','First Name:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('PartnerName',null,['class'=>'form-control text-convertion-title','tabindex'=>'21']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('PartnerLastName','Last Name:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('PartnerLastName',null,['class'=>'form-control text-convertion-title','tabindex'=>'22']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('PartnerDOB','DOB:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('PartnerDOB',null,['class'=>'form-control parents-dob','readonly'=>'true','tabindex'=>'23']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('PartnercYear','Completed Years:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('PartnercYear',null,['class'=>'form-control','tabindex'=>'24']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <?php echo Form::label('partner_education_status','Father\'s Education Level:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('partner_education_status',ValuelistHelpers::getEducationstatus(),null,['class'=>'form-control','tabindex'=>'25']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('PartnerOccupation','Occupation Type:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('PartnerOccupation',null,['class'=>'form-control','tabindex'=>'26']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <?php echo Form::label('partner_occupation_status','Current Occupation Status:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('partner_occupation_status',ValuelistHelpers::getOccupationstatus(),null,['class'=>'form-control','tabindex'=>'27']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('PartnerContact','Contact No 1:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('PartnerContact',null,['class'=>'form-control','tabindex'=>'28']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('PartnerMobile','Contact No 2 :'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('PartnerMobile',null,['class'=>'form-control','tabindex'=>'29']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('Email','Email:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('Email',null,['class'=>'form-control','tabindex'=>'30']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <?php echo Form::label('FatherSpokenLanguages','Father Spoken Languages:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('FatherSpokenLanguages',null,['class'=>'form-control','tabindex'=>'31']); ?>

                                    </div>
                                </div>
                                <div class="form-group partner_details_lables">
                                    <?php echo Form::checkbox('samecontacts', 1, null, ['class' => 'field samecontacts']); ?>

                                    <?php echo Form::label('samecontacts','Same as mother\'s contact details including languages'); ?>

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
                                        <!-- <?php echo Form::label('FatherAddress1','Address Line 1 :<small>(Door/Flat No./Home Name)</small>'); ?> -->
                                        <label for="FatherAddress1">Address Line 1 :<br><small class="input-small">(Door /Flat No /Home Name)</small></label>
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('FatherAddress1',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <label for="FatherAddress2">Address Line 2 :<br><small class="input-small">(Street Name/Building Name)</small></label>
                                        <!-- <?php echo Form::label('FatherAddress2','Address Line 2 (Street Name/Building Name):'); ?> -->
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('FatherAddress2',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <!-- <?php echo Form::label('City','Address Line 3 (City):'); ?> -->
                                        <label for="City">Address Line 3 :<br><small class="input-small">(City)</small></label>
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('City',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <label for="Postcode">Address Line 4 :<br><small class="input-small">(Pin code/Zip code)</small></label>
                                        <!-- <?php echo Form::label('Postcode','Address Line 4 (Pin code/Zip code):'); ?> -->
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('Postcode',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <label for="Country">Address Line 5 :<br><small class="input-small">(Country)</small></label>
                                        <!-- <?php echo Form::label('Country','Address Line 5 (Country):'); ?> -->
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('Country',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <?php echo Form::checkbox('sameasmailaddress', 1, null, ['class' => 'field sameasmailaddress']); ?>

                                    <?php echo Form::label('sameasmailaddress','Same as Current Address'); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div role="tabpanel" class="col-md-12 p-0 tab-pane <?php if($_COOKIE['neonatal_proforma'] == 'obform'): ?> active <?php endif; ?>" id="obform"> -->
                <div role="tabpanel" class="col-md-12 p-0 tab-pane" id="obform">
                    <div class="widget box">
                        <div class="widget-header">
                            <h4><i class="fa fa-reorder"></i> </h4>
                        </div>
                        <div class="widget-content row mx-0">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?php echo Form::label('Consanguinity','Consanguinity:'); ?>

                                    <input id="Consanguinity" data-size="small" name="Consanguinity" data-on="Yes" data-off="No" data-width="100" checked data-toggle="toggle" class="form-control switch-input" type="checkbox">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <div class="col-md-12 custom-input">
                                        <table class="medi table table-add-more full-width-fix">
                                            <thead>
                                                <tr class="master-add-header">
                                                    <th width="20%">
                                                        Medical Problems 
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
                                                    <?php echo Form::select('temp_medi_probs',$probs); ?>

                                                </div>
                                                <?php if(isset($pbm_data) && count($pbm_data) > 0): ?>
                                                <?php $__currentLoopData = $pbm_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pdm_key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo Form::select('Problems['.$pdm_key.']',$probs,$data['Problem'],["class"=>'form-control input-width-xlarge']); ?></td>
                                                    <td><input type="text" name="Medications[<?php echo e($pdm_key, false); ?>]" value="<?php echo $data['Medication'];; ?>" class="form-control input-width-xlarge" /></td>
                                                    <td><span class="fa fa-trash btn btn-danger btn-view remove-medi"></span></td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                <tr>
                                                    <td><?php echo Form::select('Problems[]',$probs,'',["class"=>"form-control input-width-xlarge"]); ?></td>
                                                    <td><input type="text" name="Medications[]" class="form-control input-width-xlarge" value="" /></td>
                                                    <td><span class="fa fa-trash btn btn-danger btn-view remove-medi"></span></td>
                                                </tr>
                                                <?php endif; ?>
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
                                                <td class="form-group"><?php echo Form::text('G_Value',null,['class'=>'form-control']); ?></td>
                                                <td class="form-group"><?php echo Form::text('P_Value',null,['class'=>'form-control']); ?></td>
                                                <td class="form-group"> <?php echo Form::text('L_Value',null,['class'=>'form-control']); ?></td>
                                                <td class="form-group"><?php echo Form::text('A_Value',null,['class'=>'form-control']); ?></td>
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
                                                <?php if(isset($delivery_details) && count($delivery_details) > 0): ?>
                                                <?php $__currentLoopData = $delivery_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $com_key => $com_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><input type="text" class="form-control input-width-mini" id="OH_YEAR" name="Year[<?php echo e($com_key, false); ?>]" value="<?php echo $com_data['Year'];; ?>" /></td>
                                                    <td><input type="text" class="form-control" name="Place[<?php echo e($com_key, false); ?>]" value="<?php echo $com_data['Place'];; ?>" /></td>
                                                    <td class="input-width-medium"><?php echo Form::select('Delivery['.$com_key.']',[''=>'N/A','Vaginal'=>'Vaginal','LSCS'=>'LSCS','Instrumental'=>'Instrumental','Breech'=>'Breech'], $com_data['Delivery'], ['class'=>'form-control']); ?></td>
                                                    <td><input type="text" class="form-control" name="Complications[<?php echo e($com_key, false); ?>]" value="<?php echo $com_data['Complications'];; ?>" /></td>
                                                    <td class="input-width-medium"><?php echo Form::select('Gender['.$com_key.']',[''=>'N/A','Male'=>'Male','Female'=>'Female','Indeterminate'=>'Indeterminate'], $com_data['Gender'], ['class'=>'form-control']); ?></td>
                                                    <td><input type="text" class="form-control input-width-mini" name="GA[<?php echo e($com_key, false); ?>]" value="<?php echo $com_data['GA'];; ?>" /></td>
                                                    <td><input type="text" class="form-control input-width-mini" name="BW[<?php echo e($com_key, false); ?>]" value="<?php echo $com_data['BW'];; ?>" /></td>
                                                    <td class="input-width-medium"><?php echo Form::select('Health['.$com_key.']',[''=>'N/A','Alive'=>'Alive','Died'=>'Died','Unhealthy'=>'Unhealthy'], $com_data['Health'], ['class'=>'form-control']); ?></td>
                                                    <td><input type="text" name="details[]" class="form-control input-width" value="<?php echo $com_data['details'];; ?>" /></td>
                                                    <td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?> 
                                                <tr>
                                                    <td><input type="text" class="form-control input-width-mini" id="OH_YEAR" name="Year[]" /></td>
                                                    <td><input type="text" class="form-control" name="Place[]" /></td>
                                                    <td><?php echo Form::select('Delivery[]',[''=>'N/A','Vaginal'=>'Vaginal','LSCS'=>'LSCS','Instrumental'=>'Instrumental','Breech'=>'Breech'], null, ['class'=>'form-control']); ?></td>
                                                    <td><input type="text" class="form-control" name="Complications[]" /></td>
                                                    <td><?php echo Form::select('Gender[]',[''=>'N/A','Male'=>'Male','Female'=>'Female','Indeterminate'=>'Indeterminate'], null, ['class'=>'form-control']); ?></td>
                                                    <td><input type="text" class="form-control input-width-mini" name="GA[]" /></td>
                                                    <td><input type="text" class="form-control input-width-mini" name="BW[]" /></td>
                                                    <td><?php echo Form::select('Health[]',[''=>'N/A','Alive'=>'Alive','Died'=>'Died','Unhealthy'=>'Unhealthy'], null, ['class'=>'form-control']); ?></td>
                                                    <td><input type="text" name="details[]" class="form-control input-width" /></td>
                                                    <td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>
                                                </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- <label for="OH_YEAR" generated="true" class="error help-block"></label>
                                    <label for="Year[]" generated="true" class="error help-block"></label>
                                    <label for="GA[]" generated="true" class="error help-block"></label>
                                    <label for="BW[]" generated="true" class="error help-block"></label> -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- PGform -->
                <!-- <div role="tabpanel" class="tab-pane <?php if($_COOKIE['neonatal_proforma'] == 'pgform'): ?> active <?php endif; ?>" id="pgform"> -->
                <div role="tabpanel" class="tab-pane" id="pgform">
                    <div class="col-md-6 col-sm-6">
                        <div class="widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('Conception','Conception:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('Conception',[''=>'N/A','Not Known'=>'Not Known','Spontaneous'=>'Spontaneous','Medical ART'=>'Medical ART','ART'=>'ART'],null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row" id="TypeofARTDiv">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('TypeofART','Type of ART:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('TypeofART',['Not Known'=>'Not Known', 'SO'=>'SO','CC10'=>'CC10','CC50'=>'CC50','CC100'=>'CC100','IUI'=>'IUI','SO/IUI'=>'SO/IUI','IVF'=>'IVF','ICSI'=>'ICSI','ICSI - DEP'=>'ICSI - DEP','ICSI - DOP'=>'ICSI - DOP','ICSI - Donor Sperm'=>'ICSI - Donor Sperm','GIFT'=>'GIFT','ZIFT'=>'ZIFT'], null, ['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row" id="EmbryoTransferDiv">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('EmbryoTransfer','Embryo Transfer:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('EmbryoTransfer',['Not Known'=>'Not Known','Not applicable'=>'Not applicable','Fresh Embryo Transfer'=>'Fresh Embryo Transfer','Frozen Embryo Transfer'=>'Frozen Embryo Transfer'], null, ['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row" id="PlaceofARTDiv">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('PlaceofART','Place of ART:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('PlaceofART',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('LMP','LMP:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('LMP',null,['class'=>'form-control previous-one-year', 'readonly' => 'true']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('EDDbyUSG','EDD by USG:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('EDDbyUSG',null,['class'=>'form-control next-one-year', 'readonly' => 'true']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('EDDbyDates','EDD by Dates:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('EDDbyDates',null,['class'=>'form-control next-one-year', 'readonly' => 'true']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('MotherBloodGroup',"Mother's Blood Group:"); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('MotherBloodGroup',ValuelistHelpers::Blood_groups(),null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="">
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control md-mt-30">
                                            <?php echo Form::label('HIV','HIV:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::select('HIV',['Non-reactive'=>'Non-reactive','Reactive'=>'Reactive','Unknown'=>'Unknown'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('reactive',4)]); ?>

                                            <!-- <input class="checkbox-tools" type="radio" name="HIV" id="non-reactive" value="Non-reactive" <?php if(isset($results->HIV) && $results->HIV == 'Non-reactive'): ?> checked <?php endif; ?>>
                                                <label class="for-checkbox-tools bg-successs" for="non-reactive">
                                                  <i></i>
                                                  Non Reactive
                                                </label>
                                                
                                                <input class="checkbox-tools" type="radio" name="HIV" id="reactive" value="Reactive" <?php if(isset($results->HIV) && $results->HIV == 'Reactive'): ?> checked <?php endif; ?>>
                                                <label class="for-checkbox-tools bg-dangerr" for="reactive">
                                                  <i></i>
                                                  Reactive
                                                </label>
                                                
                                                <input class="checkbox-tools" type="radio" name="HIV" id="Unknown" value="Unknown" <?php if(isset($results->HIV) && $results->HIV == 'Unknown'): ?> checked <?php endif; ?>>
                                                <label class="for-checkbox-tools bg-warningg" for="Unknown">
                                                  <i></i>
                                                  UNKNOWN
                                                </label> -->
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control md-mt-30">
                                            <?php echo Form::label('HepatitisB','HepatitisB:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::select('HepatitisB',['Negative'=>'Negative','Positive'=>'Positive','Unknown'=>'Unknown'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('reactive',4)]); ?>

                                            <!-- <input class="checkbox-tools" type="radio" name="HepatitisB" id="Negative" value="Negative" <?php if(isset($results->HepatitisB) && $results->HepatitisB == 'Negative'): ?> checked <?php endif; ?>>
                                                <label class="for-checkbox-tools bg-successs" for="Negative">
                                                  <i></i>
                                                  Negative
                                                </label>
                                                
                                                <input class="checkbox-tools" type="radio" name="HepatitisB" id="Positive" value="Positive" <?php if(isset($results->HepatitisB) && $results->HepatitisB == 'Positive'): ?> checked <?php endif; ?>>
                                                <label class="for-checkbox-tools bg-dangerr" for="Positive">
                                                  <i></i>
                                                  Positive
                                                </label>
                                                
                                                <input class="checkbox-tools" type="radio" name="HepatitisB" id="unknown" value="Unknown" <?php if(isset($results->HepatitisB) && $results->HepatitisB == 'Unknown'): ?> checked <?php endif; ?>>
                                                <label class="for-checkbox-tools bg-warningg" for="unknown">
                                                  <i></i>
                                                  UNKNOWN
                                                </label> -->
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control md-mt-30">
                                            <?php echo Form::label('VDRL','VDRL:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::select('VDRL',['Non-reactive'=>'Non-reactive','Reactive'=>'Reactive','Unknown'=>'Unknown'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('reactive',4)]); ?>

                                            <!-- <input class="checkbox-tools" type="radio" name="VDRL" id="Non-Reactive" value="Non-reactive" <?php if(isset($results->VDRL) && $results->VDRL == 'Non-reactive'): ?> checked <?php endif; ?>>
                                                <label class="for-checkbox-tools bg-successs" for="Non-Reactive">
                                                  <i></i>
                                                  Non Reactive
                                                </label>
                                                
                                                <input class="checkbox-tools" type="radio" name="VDRL" id="Reactive" value="Reactive" <?php if(isset($results->VDRL) && $results->VDRL == 'Reactive'): ?> checked <?php endif; ?>>
                                                <label class="for-checkbox-tools bg-dangerr" for="Reactive">
                                                  <i></i>
                                                  Reactive
                                                </label>
                                                
                                                <input class="checkbox-tools" type="radio" name="VDRL" id="Un-known" value="Un-known" <?php if(isset($results->VDRL) && $results->VDRL == 'Unknown'): ?> checked <?php endif; ?>>
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
                        <div class="widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('Booked','Booked:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <input checked data-toggle="toggle" data-width="100" data-size="small" class="form-control" id="Booked" name="Booked" data-on="Yes" data-off="No" 
                                            type="checkbox">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('Booking','Place of Booking:'); ?>

                                        <a href="javascript:void(0)" class="add_master_data" data-modal_header="Booking Place" data-destination_elements="Booking,PlaceofSupervision" data-option_value="id" data-option_text="hospital_name" data-mas_table="mas_referral">
                                        <i class="fa fa-info-circle bs-tooltip add-neo-consultant" data-placement="right" data-original-title="Add Booking Place"></i>
                                        </a>
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('Booking', [''=>'N/A']+ValuelistHelpers::mas_referral_list(), null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('Supervised','Supervised:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">   
                                        <input checked data-toggle="toggle" data-size="small" data-width="100" class="form-control" id="Supervised" height="5px" name="Supervised" data-on="Yes" data-off="No" type="checkbox">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <?php echo Form::label('PlaceofSupervision','Place of Supervision:'); ?>

                                        <a href="javascript:void(0)" class="add_master_data" data-modal_header="Supervision Place" data-destination_elements="Booking,PlaceofSupervision" data-option_value="id" data-option_text="hospital_name" data-mas_table="mas_referral">
                                        <i class="fa fa-info-circle bs-tooltip add-neo-consultant" data-placement="right" data-original-title="Add Supervision Place"></i>
                                        </a>
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('PlaceofSupervision', [''=>'N/A']+ValuelistHelpers::mas_referral_list(), null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <?php echo Form::label('adjustedtrisomies','Adjusted Risk for Trisomies available:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <input data-toggle="toggle" data-size="small" data-width="100" class="form-control" id="adjustedtrisomies" height="5px" name="adjustedtrisomies" data-on="Yes" data-off="No" type="checkbox">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <?php echo Form::label('AdjustedRiskForTrisomy21','Adjusted Risk For Trisomy21:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('AdjustedRiskForTrisomy21',null,['class'=>'form-control', 'readonly' => 'true']); ?>

                                    </div>
                                </div>
                                <div class="form-group row <?php if($results->AdjustedRiskForTrisomy21 != 'Others'): ?> display-none <?php endif; ?>">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <?php echo Form::label('another_adjusted_risk_for_trisomy21','Another Adjusted Risk For Trisomy21:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('another_adjusted_risk_for_trisomy21',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <?php echo Form::label('AdjustedRiskForTrisomy18','Adjusted Risk For Trisomy18:'); ?>  
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('AdjustedRiskForTrisomy18',null,['class'=>'form-control', 'readonly' => 'true']); ?>

                                    </div>
                                </div>
                                <div class="form-group row <?php if($results->AdjustedRiskForTrisomy18 != 'Others'): ?> display-none <?php endif; ?>">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <?php echo Form::label('another_adjusted_risk_for_trisomy18','Another Adjusted Risk For Trisomy18:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('another_adjusted_risk_for_trisomy18',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <?php echo Form::label('AdjustedRiskForTrisomy13','Adjusted Risk For Trisomy13:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('AdjustedRiskForTrisomy13',null,['class'=>'form-control', 'id'=> 'AdjustedRiskForTrisomy13', 'readonly' => 'true']); ?>

                                    </div>
                                </div>
                                <div class="form-group row <?php if($results->AdjustedRiskForTrisomy13 != 'Others'): ?> display-none <?php endif; ?>">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        <?php echo Form::label('another_adjusted_risk_for_trisomy13','Another Adjusted Risk For Trisomy13:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::text('another_adjusted_risk_for_trisomy13',null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('OtherInvestigations','Other Investigations:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::textarea('OtherInvestigations',null,['class'=>'form-control','rows'=>'5']); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Pregnancy Contd -->
                <!-- <div role="tabpanel" class="tab-pane <?php if($_COOKIE['neonatal_proforma'] == 'pgcform'): ?> active <?php endif; ?> plr-15" id="pgcform"> -->
                <div role="tabpanel" class="tab-pane plr-15" id="pgcform">
                    <div class="widget box col-md-12">
                        <div class="widget-header">
                            <h4><i class="fa fa-reorder"></i> </h4>
                        </div>
                        <div class="widget-content">
                            <div class="col-md-5 ">
                                <div class="form-group row">
                                    <div class="col-md-5 text-right label-control">
                                        <?php echo Form::label('MultiplePregnancy','MultiplePregnancy:'); ?>

                                    </div>
                                    <div class="col-md-7 custom-input"> 
                                        <input id="MultiplePregnancy" data-size="small" name="MultiplePregnancy" data-on="Yes" data-off="No" data-width="100" checked data-toggle="toggle"  class="form-control" type="checkbox">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-5 text-right label-control">
                                        <?php echo Form::label('PregnancyComplications','Pregnancy Complications:'); ?>

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
                                                    <?php echo Form::select('temp_complications',ValuelistHelpers::getMastercomplications(),null); ?>

                                                </div>
                                                <?php if(!$complication->isEmpty() && isset($complication) && count($complication) > 0): ?>
                                                <?php $l = 0; ?>
                                                <?php $__currentLoopData = $complication; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $com_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php $com_data['duration_in_weeks'] = isset($com_data['duration_in_weeks']) ? $com_data['duration_in_weeks'] : '';  ?>
                                                <tr>
                                                    <td class="form-group"><?php echo Form::select('Complication['.$key.']',ValuelistHelpers::getMastercomplications(),$com_data['Complication'],["class"=>"complication-disabled complication-search","id"=>"complication-search-".$l, "style"=>"width: 257px;"]); ?></td>
                                                    <td class="form-group"> <?php echo Form::text('Treatments['.$key.']',$com_data['Treatment'],['class'=>'form-control input-width-large complication-disabled']); ?></td>
                                                    <td class="form-group"> <?php echo Form::text('duration_in_weeks['.$key.']',$com_data['duration_in_weeks'],['class'=>'form-control input-width-medium complication-disabled','id' => 'duration_in_weeks']); ?></td>
                                                    <td class="form-group"> <?php echo Form::select('duration_unit['.$key.']',ValuelistHelpers::getdurationUnit(),$com_data['duration_unit'],['class'=>'form-control input-width-medium complication-disabled']); ?></td>
                                                    <td  class="form-group"><span class="fa fa-trash btn btn-danger btn-view remove-medi"></span></td>
                                                </tr>
                                                <?php $l++; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                <tr>
                                                    <td class="form-group"><?php echo Form::select('Complication[]',ValuelistHelpers::getMastercomplications(),null,["class"=>"complication-disabled complication-search","id"=>"complication-search-0", "style"=>"width: 257px;"]); ?></td>
                                                    <td class="form-group"> <?php echo Form::text('Treatments[]',null,['class'=>'form-control input-width-large complication-disabled']); ?></td>
                                                    <td class="form-group"> <?php echo Form::text('duration_in_weeks[]',null,['class'=>'form-control input-width-medium complication-disabled','id' => 'duration_in_weeks']); ?></td>
                                                    <td class="form-group"> <?php echo Form::select('duration_unit[]',ValuelistHelpers::getdurationUnit(),null,['class'=>'form-control input-width-medium complication-disabled']); ?></td>
                                                    <td><span class="fa fa-trash btn btn-danger btn-view remove-medi"></span></td>
                                                </tr>
                                                <?php endif; ?>
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
                                                    <th>
                                                        <h5><strong>Date</strong></h5>
                                                    </th>
                                                    <th>
                                                        <h5><strong>Gestation In Weeks</strong></h5>
                                                    </th>
                                                    <th>
                                                        <h5><strong>Findings</strong></h5>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="form-group"><input type="text" value="<?php echo e((isset($datingScan['date']) && !empty($datingScan['date']) && !is_null($datingScan['date'])) ? date('d-m-Y', strtotime($datingScan['date'])) : '', false); ?>" class="form-control input-width-medium"  name="datingdate" readonly /></td>
                                                    <td class="form-group"><input type="text" value="<?php echo e(@$datingScan['Gestation'], false); ?>" class="form-control input-width-medium"  name="datinggestations" /></td>
                                                    <td class="form-group"><input type="text" value="<?php echo e(@$datingScan['Finding'], false); ?>" name="datingfindings" class="form-control input-width-large"  /></td>
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
                                                    <th>
                                                        <h5><strong>Date</strong></h5>
                                                    </th>
                                                    <th>
                                                        <h5><strong>Gestation In Weeks</strong></h5>
                                                    </th>
                                                    <th>
                                                        <h5><strong>Findings</strong></h5>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td  class="form-group"><input type="text" name="analogdate" value="<?php echo e((isset($analogScan['date']) && !empty($analogScan['date']) && !is_null($analogScan['date'])) ? date('d-m-Y', strtotime($analogScan['date'])) : '', false); ?>" class="form-control input-width-medium" readonly /></td>
                                                    <td  class="form-group"><input type="text" name="analoggestations" value="<?php echo e(@$analogScan['Gestation'], false); ?>" class="form-control input-width-medium" /></td>
                                                    <td  class="form-group"><input type="text" name="analogfindings"   value="<?php echo e(@$analogScan['Finding'], false); ?>"  class="form-control input-width-large"  /></td>
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
                                            <td  class="form-group"><input type="text" name="analoggestations" value="<?php echo e(@$analogScan['Gestation'], false); ?>" class="form-control input-width-medium" /></td>
                                            <td  class="form-group"><input type="text" name="analogfindings"   value="<?php echo e(@$analogScan['Finding'], false); ?>"  class="form-control input-width-large"  /></td>
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
                                                        <a class="btn_add btn btn-success btn-view any-further-scan-add" href="javascript:void(0);">
                                                        <i class="fa fa-plus"></i></a>
                                                        </span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(isset($otherScan) && count($otherScan) > 0): ?>
                                                <?php $__currentLoopData = array_values($otherScan); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scanKey => $scanValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td  class="form-group"><input type="text" value="<?php echo e(@unserialize($scanValue['date']) !== false ? '' : ((isset($scanValue['date']) && !empty($scanValue['date']) && !is_null($scanValue['date'])) ? date('d-m-Y', strtotime($scanValue['date'])) : ''), false); ?>" class="form-control input-width-medium"  name="otherdate[<?php echo e($scanKey, false); ?>]" readonly /></td>
                                                    <td  class="form-group"><input type="text" value="<?php echo e(@unserialize($scanValue['Gestation']) !== false ? '' : $scanValue['Gestation'], false); ?>" class="form-control input-width-medium"  name="othergestations[<?php echo e($scanKey, false); ?>]" /></td>
                                                    <td  class="form-group"><input type="text" value="<?php echo e(@unserialize($scanValue['Finding']) !== false ? '' : $scanValue['Finding'], false); ?>" name="otherfindings[<?php echo e($scanKey, false); ?>]" class="form-control input-width-large"  /></td>
                                                    <td class="form-group"><span class="fa fa-trash btn btn-danger btn-view remove-usg"></span></td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                <tr>
                                                    <td  class="form-group"><input type="text" class="form-control input-width-medium"  name="otherdate[]" readonly /></td>
                                                    <td  class="form-group"><input type="text" class="form-control input-width-medium"  name="othergestations[]" /></td>
                                                    <td  class="form-group"><input type="text" name="otherfindings[]" class="form-control input-width-large"  /></td>
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
                                                <?php if(isset($dopplerScan) && count($dopplerScan) > 0): ?>
                                                <?php $__currentLoopData = array_values($dopplerScan); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dopplerKey => $dopplerValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td  class="form-group"><input type="text" value="<?php echo e((isset($dopplerValue['date']) && !empty($dopplerValue['date']) && !is_null($dopplerValue['date'])) ? date('d-m-Y', strtotime($dopplerValue['date'])) : '', false); ?>" class="form-control input-width-medium"  name="dopplerdate[<?php echo e($dopplerKey, false); ?>]" readonly /></td>
                                                    <td  class="form-group"><input type="text" value="<?php echo e($dopplerValue['Gestation'], false); ?>" class="form-control input-width-medium"  name="dopplergestations[<?php echo e($dopplerKey, false); ?>]"/></td>
                                                    <td  class="form-group"><input type="text"  value="<?php echo e($dopplerValue['Finding'], false); ?>" name="dopplerfindings[<?php echo e($dopplerKey, false); ?>]" class="form-control input-width-large"  /></td>
                                                    <td class="form-group"><span class="fa fa-trash btn btn-danger btn-view remove-usg"></span></td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                <tr>
                                                    <td  class="form-group"><input type="text" class="form-control input-width-medium"  name="dopplerdate[]" readonly /></td>
                                                    <td  class="form-group"><input type="text" class="form-control input-width-medium"  name="dopplergestations[]" /></td>
                                                    <td  class="form-group"><input type="text" name="dopplerfindings[]" class="form-control input-width-large"  /></td>
                                                    <td class="form-group"><span class="fa fa-trash btn btn-danger btn-view remove-usg"></span></td>
                                                </tr>
                                                <?php endif; ?>
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
                <!-- <div role="tabpanel" class="tab-pane <?php if($_COOKIE['neonatal_proforma'] == 'labform'): ?> active <?php endif; ?>" id="labform"> -->
                <div role="tabpanel" class="tab-pane" id="labform">
                    <div class="col-md-6 col-sm-6">
                        <div class="widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-4 text-right label-control">
                                        <?php echo Form::label('AntenatalSteroids','Antenatal Steroids:'); ?>

                                    </div>
                                    <div class="col-md-8 custom-input">
                                        <input id="AntenatalSteroids" data-size="small" data-width="100" name="AntenatalSteroids" data-on="Yes" data-off="No" checked data-toggle="toggle"  class="form-control" type="checkbox">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-30">
                                        <?php echo Form::label('antenatal_MgSO4','Antenatal MgSO4 For Neuroprotection:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('antenatal_MgSO4',['N/A'=>'N/A','No'=>'No','Yes'=>'Yes'],null,['class'=>'form-control']); ?>

                                        <!-- <input class="checkbox-tools" type="radio" name="antenatal_MgSO4" id="N/A" value="N/A" <?php if(isset($results->antenatal_MgSO4) && $results->antenatal_MgSO4 == 'N/A'): ?> checked <?php endif; ?>>
                                            <label class="for-checkbox-tools bg-primary" for="N/A">
                                              <i></i>
                                              N/A
                                            </label>
                                            
                                            <input class="checkbox-tools" type="radio" name="antenatal_MgSO4" id="No" value="No" <?php if(isset($results->antenatal_MgSO4) && $results->antenatal_MgSO4 == 'No'): ?> checked <?php endif; ?>>
                                            <label class="for-checkbox-tools bg-primary" for="No">
                                              <i></i>
                                              NO
                                            </label>
                                            
                                            <input class="checkbox-tools" type="radio" name="antenatal_MgSO4" id="Yes" value="Yes" <?php if(isset($results->antenatal_MgSO4) && $results->antenatal_MgSO4 == 'Yes'): ?> checked <?php endif; ?>>
                                            <label class="for-checkbox-tools bg-primary" for="Yes">
                                              <i></i>
                                              Yes
                                            </label> -->
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        <?php echo Form::label('typeofsteroids','Type of Steroids:',['class'=>'title']); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('typeofsteroids', ['N/A'=>'N/A','Dexa'=>'Dexa','Beta'=>'Beta'],null,['class'=>'form-control']); ?>

                                        <!-- <input class="checkbox-tools" type="radio" name="typeofsteroids" id="N-A" value="N/A" <?php if(isset($results->typeofsteroids) && $results->typeofsteroids == 'N/A'): ?> checked <?php endif; ?>>
                                            <label class="for-checkbox-tools bg-primary" for="N-A">
                                              <i></i>
                                              N/A
                                            </label>
                                            
                                            <input class="checkbox-tools" type="radio" name="typeofsteroids" id="Dexa" value="Dexa" <?php if(isset($results->typeofsteroids) && $results->typeofsteroids == 'Dexa'): ?> checked <?php endif; ?>>
                                            <label class="for-checkbox-tools bg-primary" for="Dexa">
                                              <i></i>
                                              Dexa
                                            </label>
                                            
                                            <input class="checkbox-tools" type="radio" name="typeofsteroids" id="Beta" value="Beta" <?php if(isset($results->typeofsteroids) && $results->typeofsteroids == 'Beta'): ?> checked <?php endif; ?>>
                                            <label class="for-checkbox-tools bg-primary" for="Beta">
                                              <i></i>
                                              Beta
                                            </label> -->
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        <?php echo Form::label('LastDoseDeliveryInterval','Last Dose Delivery Interval:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('LastDoseDeliveryInterval', [ "" => "N/A", "< 24 hrs" => '< 24 hrs','24 hrs - 7 days'=>'24 hrs - 7 days',  "> 7 days" => "> 7 days"],null,['class'=>'form-control']); ?>

                                        <!-- <input class="checkbox-tools" type="radio" name="LastDoseDeliveryInterval" id="LastDoseDeliveryIntervalN-A" value="N/A" <?php if(isset($results->LastDoseDeliveryInterval) && $results->LastDoseDeliveryInterval == 'N/A'): ?> checked <?php endif; ?>>
                                            <label class="for-checkbox-tools bg-primary" for="LastDoseDeliveryIntervalN-A">
                                              <i></i>
                                              N/A
                                            </label>
                                            
                                            <input class="checkbox-tools" type="radio" name="LastDoseDeliveryInterval" id="24-hrs" value="< 24 hrs" <?php if(isset($results->LastDoseDeliveryInterval) && $results->LastDoseDeliveryInterval == '< 24 hrs'): ?> checked <?php endif; ?>>
                                            <label class="for-checkbox-tools bg-primary" for="24-hrs">
                                              <i></i>
                                              < 24 Hrs
                                            </label>
                                            
                                            <input class="checkbox-tools" type="radio" name="LastDoseDeliveryInterval" id="24hrs-7" value="24 hrs - 7" <?php if(isset($results->LastDoseDeliveryInterval) && $results->LastDoseDeliveryInterval == '24 hrs - 7'): ?> checked <?php endif; ?>>
                                            <label class="for-checkbox-tools bg-primary" for="24hrs-7">
                                              <i></i>
                                              24 hrs <br>- 7 days
                                            </label>
                                            
                                            <input class="checkbox-tools" type="radio" name="LastDoseDeliveryInterval" id="7days" value="> 7 days" <?php if(isset($results->LastDoseDeliveryInterval) && $results->LastDoseDeliveryInterval == '> 7 days'): ?> checked <?php endif; ?>>
                                            <label class="for-checkbox-tools bg-primary" for="7days">
                                              <i></i>
                                              > 7 days
                                            </label> -->
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('SteroidCourse','Steroid Course:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('SteroidCourse',[''=>'N/A','Complete'=>'Complete','Partial/Incomplete'=>'Partial/Incomplete','Multiple'=>'Multiple'],null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('Labour','Labour:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <input id="Labour" data-size="small" data-width="100" name="Labour" data-on="Yes" data-off="No" checked data-toggle="toggle"  class="form-control" type="checkbox">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        <?php echo Form::label('NatureofLabour','Nature of Labour:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('NatureofLabour',[''=>'N/A','Spontaneous'=>'Spontaneous','Induced'=>'Induced'],null,['class'=>'form-control']); ?>

                                        <!-- <input class="checkbox-tools" type="radio" name="NatureofLabour" id="NatureofLabourN-A" value="N/A" <?php if(isset($results->NatureofLabour) && $results->NatureofLabour == 'N/A'): ?> checked <?php endif; ?>>
                                            <label class="for-checkbox-tools bg-primary" for="NatureofLabourN-A">
                                              <i></i>
                                              N/A
                                            </label>
                                            
                                            <input class="checkbox-tools" type="radio" name="NatureofLabour" id="Spontaneous" value="Spontaneous" <?php if(isset($results->NatureofLabour) && $results->NatureofLabour == 'Spontaneous'): ?> checked <?php endif; ?>>
                                            <label class="for-checkbox-tools bg-primary" for="Spontaneous">
                                              <i></i>
                                              Spont <br>-aneous
                                            </label>
                                            
                                            <input class="checkbox-tools" type="radio" name="NatureofLabour" id="Induced" value="Induced" <?php if(isset($results->NatureofLabour) && $results->NatureofLabour == 'Induced'): ?> checked <?php endif; ?>>
                                            <label class="for-checkbox-tools bg-primary" for="Induced">
                                              <i></i>
                                              Induced
                                            </label> -->
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        <?php echo Form::label('Syntocinon','Syntocinon:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('Syntocinon',ValuelistHelpers::getSyntocinon(),null,['class'=>'form-control']); ?>

                                        <!-- <input class="checkbox-tools" type="radio" name="Syntocinon" id="Syntocinon1" value="1" <?php if(isset($results->Syntocinon) && $results->Syntocinon == '1'): ?> checked <?php endif; ?>>
                                            <label class="for-checkbox-tools bg-primary" for="Syntocinon1">
                                              <i></i>
                                              Given
                                            </label>
                                            
                                            <input class="checkbox-tools" type="radio" name="Syntocinon" id="Syntocinon2" value="2" <?php if(isset($results->Syntocinon) && $results->Syntocinon == '2'): ?> checked <?php endif; ?>>
                                            <label class="for-checkbox-tools bg-primary" for="Syntocinon2">
                                              <i></i>
                                              Not Given
                                            </label>
                                            
                                            <input class="checkbox-tools" type="radio" name="Syntocinon" id="Syntocinon3" value="3" <?php if(isset($results->Syntocinon) && $results->Syntocinon == '3'): ?> checked <?php endif; ?>>
                                            <label class="for-checkbox-tools bg-primary" for="Syntocinon3">
                                              <i></i>
                                              Not known
                                            </label> -->
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('CommentOnLiquor','Comment On Liquor:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('CommentOnLiquor',[''=>'N/A','Clear'=>'Clear','Meconium Stained'=>'Meconium Stained','Blood Stained'=>'Blood Stained','Foul Smelling'=>'Foul Smelling'],null,['class'=>'form-control']); ?>

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
                                        <?php echo Form::label('sepsis_in_mother',' Risk Factors For Sepsis In Mothers:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('sepsis_in_mother', ['N/A'=>'N/A', 'No'=>'No', 'Yes'=>'Yes'],null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control"> 
                                        <?php echo Form::label('sepsis_in_mother_type','Risk Factors:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php $sepsis_in_mother_type = $results->sepsis_in_mother_type;  ?>  
                                        <?php $sepsis_in_mother_type1 = in_array('1', $sepsis_in_mother_type) ? true : false; ?>  
                                        <?php $sepsis_in_mother_type2 = in_array('2', $sepsis_in_mother_type) ? true : false; ?>  
                                        <?php $sepsis_in_mother_type3 = in_array('3', $sepsis_in_mother_type) ? true : false; ?>  
                                        <?php $sepsis_in_mother_type4 = in_array('4', $sepsis_in_mother_type) ? true : false; ?>  
                                        <?php $sepsis_in_mother_type5 = in_array('5', $sepsis_in_mother_type) ? true : false; ?>  
                                        <?php $sepsis_in_mother_type6 = in_array('6', $sepsis_in_mother_type) ? true : false; ?>  
                                        <div>
                                            <?php echo Form::checkbox('sepsis_in_mother_type[]','1',$sepsis_in_mother_type1); ?>

                                            <?php echo Form::label('chorioamnionitis','Chorioamnionitis',['class'=>'title']); ?>

                                        </div>
                                        <div>
                                            <?php echo Form::checkbox('sepsis_in_mother_type[]','2',$sepsis_in_mother_type2); ?>

                                            <?php echo Form::label('unclean_vaginal_examination','Unclean vaginal examination / > 3 PV examination',['class'=>'title']); ?>

                                        </div>
                                        <div>
                                            <?php echo Form::checkbox('sepsis_in_mother_type[]','3',$sepsis_in_mother_type3); ?>

                                            <?php echo Form::label('leaking_pv','Leaking PV > 18hours / pPROM',['class'=>'title']); ?>

                                        </div>
                                        <div>
                                            <?php echo Form::checkbox('sepsis_in_mother_type[]','4',$sepsis_in_mother_type4); ?>

                                            <?php echo Form::label('gbs_in_maternal_recto-vaginal_swab','GBS in maternal recto-vaginal swab',['class'=>'title']); ?>

                                        </div>
                                        <div>
                                            <?php echo Form::checkbox('sepsis_in_mother_type[]','5',$sepsis_in_mother_type5); ?>

                                            <?php echo Form::label('uti_in_mother','UTI in mother',['class'=>'title']); ?>

                                        </div>
                                        <div>
                                            <?php echo Form::checkbox('sepsis_in_mother_type[]','6',$sepsis_in_mother_type6); ?>

                                            <?php echo Form::label('maternal_fever','Maternal fever',['class'=>'title']); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('MaternalPyrexia','Maternal Pyrexia:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">   
                                        <input id="MaternalPyrexia" data-size="small" data-width="100" name="MaternalPyrexia" data-on="Yes" data-off="No" checked data-toggle="toggle"  class="form-control" type="checkbox">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('maternal_pyrexia_temp','Maternal Pyrexia Temperature:'); ?>

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
                                                <?php echo Form::text('maternal_pyrexia_fahrenheit',null,['class'=>'form-control fahrenheit']); ?>

                                            </div>
                                            <div class="col-xs-6">
                                                <?php echo Form::text('maternal_pyrexia_celsius',null,['class'=>'form-control celsius']); ?>

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
                                                <?php echo Form::text('maternal_pyrexia_celsius',null,['class'=>'form-control celsius']); ?>

                                            </div>
                                            <div class="col-xs-6">
                                                <?php echo Form::text('maternal_pyrexia_fahrenheit',null,['class'=>'form-control fahrenheit']); ?>

                                            </div>
                                        </div>
                                        <?php endif; ?>
                                        <label class="error help-block" for="BirthWeight" generated="true" style="display: none;"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('PROM','PROM:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">  
                                        <input id="PROM" data-size="small" data-width="100" name="PROM" data-on="Yes" data-off="No" checked data-toggle="toggle"  class="form-control" type="checkbox">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('DurationOfROM','Duration Of PROM:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">  
                                        <?php echo Form::select('DurationOfROM',['' => 'N/A','Less than 6 hrs' => 'Less than 6 hrs','6 - 12' => '6 - 12','12 - 18' => '12- 18','18 - 24' => '18 - 24','More than 24 ' => 'More than 24 ','Unknown' => 'Unknown'],null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <?php $maternal_status=['Not known'=>'Not known','No'=>'No','Yes'=>'Yes'] ?>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        <?php echo Form::label('Maternal_antibiotics_status','Maternal Antibiotics:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">  
                                        <?php echo Form::select('Maternal_antibiotics_status',$maternal_status,null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row Maternal_antibiotics_status">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('MaternalAntibiotics','Maternal Antibiotics Type:'); ?>

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
                                                <?php if(isset($maternalantibiotics) && count($maternalantibiotics) > 0): ?>
                                                <?php for($i = 0; $i < count($maternalantibiotics); $i++): ?>
                                                <tr>
                                                    <?php if(!empty($maternalantibiotics[$i])): ?>
                                                    <td class="form-group full-width"><?php echo Form::text('MaternalAntibiotics[]',$maternalantibiotics[$i],['class'=>'form-control ']); ?></td>
                                                    <?php else: ?>
                                                    <?php $results->MaternalAntibiotics = ''; ?>
                                                    <td class="form-group full-width"><?php echo Form::text('MaternalAntibiotics[]',null,['class'=>'form-control ']); ?></td>
                                                    <?php endif; ?> 
                                                    <td>
                                                        <span class="fa fa-trash btn btn-danger btn-view remove"></span> 
                                                    </td>
                                                </tr>
                                                <?php endfor; ?>
                                                <?php else: ?>
                                                <tr>
                                                    <td class="full-width"><?php echo Form::text('MaternalAntibiotics[]','',['class'=>'form-control ']); ?></td>
                                                    <td>
                                                        <span class="fa fa-trash btn btn-danger btn-view remove"></span> 
                                                    </td>
                                                </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('TimeofLastDose','Time of Last Dose:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('TimeofLastDose',['' => 'N/A','Less than 4 hours' => 'Less than 4 hours','More than 4 hours' => 'More than 4 hours','Unknown' => 'Unknown'],null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Apgar Form -->
                <!-- <div role="tabpanel" class="tab-pane <?php if($_COOKIE['neonatal_proforma'] == 'apgarform'): ?> active <?php endif; ?>" id="apgarform"> -->
                <div role="tabpanel" class="tab-pane" id="apgarform">
                    <div class="col-md-12 overflow-auto">
                        <div class="widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group">
                                    <?php echo Form::label('known_field','APGAR:', ['class' => 'control-label']); ?>

                                    <input id="known_field" data-size="small" data-width="100" name="known_field" data-on="Known" data-off="Unknown"  data-toggle="toggle"  class="form-control" type="checkbox">
                                    <br><br>
                                </div>
                                <div class="form-group dispaly_apgar"  <?php if($results->known_field == '2'): ?> style="display:none;" <?php endif; ?>>
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
                                        <td> <?php echo Form::select('Colour1',ValuelistHelpers::getApgarScore('colour'),null,['class'=>'form-control','id'=>'Colour1','type'=>'numeric','onchange'=>"Calculate(1);"]); ?></td>
                                        <td> <?php echo Form::select('Colour5',ValuelistHelpers::getApgarScore('colour'),null,['class'=>'form-control','id'=>'Colour5','onchange'=>"Calculate(5);"]); ?></td>
                                        <td> <?php echo Form::select('Colour10',ValuelistHelpers::getApgarScore('colour'),null,['class'=>'form-control','id'=>'Colour10','onchange'=>"Calculate(10);"]); ?></td>
                                        <td> <?php echo Form::select('Colour15',ValuelistHelpers::getApgarScore('colour'),null,['class'=>'form-control','id'=>'Colour15','onchange'=>"Calculate(15);"]); ?></td>
                                        <td> <?php echo Form::select('Colour20',ValuelistHelpers::getApgarScore('colour'),null,['class'=>'form-control','id'=>'Colour20','onchange'=>"Calculate(20);"]); ?></td>
                                    </tr>
                                    <tr>
                                        <td>HR</td>
                                        <td> <?php echo Form::select('HR1',ValuelistHelpers::getApgarScore('hr'),null,['class'=>'form-control','id'=>'HR1','onchange'=>"Calculate(1);"]); ?></td>
                                        <td> <?php echo Form::select('HR5',ValuelistHelpers::getApgarScore('hr'),null,['class'=>'form-control','id'=>'HR5','onchange'=>"Calculate(5);"]); ?></td>
                                        <td> <?php echo Form::select('HR10',ValuelistHelpers::getApgarScore('hr'),null,['class'=>'form-control','id'=>'HR10','onchange'=>"Calculate(10);"]); ?></td>
                                        <td> <?php echo Form::select('HR15',ValuelistHelpers::getApgarScore('hr'),null,['class'=>'form-control','id'=>'HR15','onchange'=>"Calculate(15);"]); ?></td>
                                        <td> <?php echo Form::select('HR20',ValuelistHelpers::getApgarScore('hr'),null,['class'=>'form-control','id'=>'HR20','onchange'=>"Calculate(20);"]); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Reflex</td>
                                        <td> <?php echo Form::select('Reflex1',ValuelistHelpers::getApgarScore('reflex'),null,['class'=>'form-control','id'=>'Reflex1','onchange'=>"Calculate(1);"]); ?></td>
                                        <td> <?php echo Form::select('Reflex5',ValuelistHelpers::getApgarScore('reflex'),null,['class'=>'form-control','id'=>'Reflex5','onchange'=>"Calculate(5);"]); ?></td>
                                        <td> <?php echo Form::select('Reflex10',ValuelistHelpers::getApgarScore('reflex'),null,['class'=>'form-control','id'=>'Reflex10','onchange'=>"Calculate(10);"]); ?></td>
                                        <td> <?php echo Form::select('Reflex15',ValuelistHelpers::getApgarScore('reflex'),null,['class'=>'form-control','id'=>'Reflex15','onchange'=>"Calculate(15);"]); ?></td>
                                        <td> <?php echo Form::select('Reflex20',ValuelistHelpers::getApgarScore('reflex'),null,['class'=>'form-control','id'=>'Reflex20','onchange'=>"Calculate(20);"]); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tone</td>
                                        <td> <?php echo Form::select('Tone1',ValuelistHelpers::getApgarScore('tone'),null,['class'=>'form-control','id'=>'Tone1','onchange'=>"Calculate(1);"]); ?></td>
                                        <td> <?php echo Form::select('Tone5',ValuelistHelpers::getApgarScore('tone'),null,['class'=>'form-control','id'=>'Tone5','onchange'=>"Calculate(5);"]); ?></td>
                                        <td> <?php echo Form::select('Tone10',ValuelistHelpers::getApgarScore('tone'),null,['class'=>'form-control','id'=>'Tone10','onchange'=>"Calculate(10);"]); ?></td>
                                        <td> <?php echo Form::select('Tone15',ValuelistHelpers::getApgarScore('tone'),null,['class'=>'form-control','id'=>'Tone15','onchange'=>"Calculate(15);"]); ?></td>
                                        <td> <?php echo Form::select('Tone20',ValuelistHelpers::getApgarScore('tone'),null,['class'=>'form-control','id'=>'Tone20','onchange'=>"Calculate(20);"]); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Respiration</td>
                                        <td> <?php echo Form::select('Respiration1',ValuelistHelpers::getApgarScore('respiration'),null,['class'=>'form-control','id'=>'Respiration1','onchange'=>"Calculate(1);"]); ?></td>
                                        <td> <?php echo Form::select('Respiration5',ValuelistHelpers::getApgarScore('respiration'),null,['class'=>'form-control','id'=>'Respiration5','onchange'=>"Calculate(5);"]); ?></td>
                                        <td> <?php echo Form::select('Respiration10',ValuelistHelpers::getApgarScore('respiration'),null,['class'=>'form-control','id'=>'Respiration10','onchange'=>"Calculate(10);"]); ?></td>
                                        <td> <?php echo Form::select('Respiration15',ValuelistHelpers::getApgarScore('respiration'),null,['class'=>'form-control','id'=>'Respiration15','onchange'=>"Calculate(15);"]); ?></td>
                                        <td> <?php echo Form::select('Respiration20',ValuelistHelpers::getApgarScore('respiration'),null,['class'=>'form-control','id'=>'Respiration20','onchange'=>"Calculate(20);"]); ?></td>
                                    </tr>
                                    <tr></tr>
                                    <tr>
                                        <td>Total</td>
                                        <td> <?php echo Form::text('Apgars1min',null,['class'=>'form-control Apgars1min total1min']); ?></td>
                                        <td> <?php echo Form::text('Apgars5min',null,['class'=>'form-control Apgars5min total5min']); ?></td>
                                        <td> <?php echo Form::text('Apgars10min',null,['class'=>'form-control Apgars10min total10min']); ?></td>
                                        <td> <?php echo Form::text('Apgars15min',null,['class'=>'form-control Apgars15min total15min']); ?></td>
                                        <td> <?php echo Form::text('Apgars20min',null,['class'=>'form-control Apgars20min total20min']); ?></td>
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
            <!-- <div role="tabpanel" class="tab-pane <?php if($_COOKIE['neonatal_proforma'] == 'delform'): ?> active <?php endif; ?>" id="delform"> -->
            <div role="tabpanel" class="tab-pane" id="delform">
                <div class="col-md-6 col-sm-6">
                    <div class="widget box">
                        <div class="widget-header">
                            <h4><i class="fa fa-reorder"></i> </h4>
                        </div>
                        <div class="widget-content">
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    <?php echo Form::label('ModeOfDelivery','Mode Of Delivery:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">
                                    <?php echo Form::select('ModeOfDelivery',[""=>"N/A","Normal Vaginal"=>"Normal Vaginal","Preterm Vaginal"=>"Preterm Vaginal","Forceps"=>"Forceps","Ventouse"=>"Ventouse","Assisted Breech"=>"Assisted Breech","Emergency Caesarian"=>"Emergency Caesarian","Elective Caesarian"=>"Elective Caesarian","Caesarian"=>"Caesarian"],null,['class'=>'form-control']); ?>

                                </div>
                            </div>
                            <div class="hidden">
                                <?php echo Form::select('temp_indication',$delivery_indications,null); ?>

                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    <?php echo Form::label('Indication','Indication:'); ?>

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
                                            <?php if(count($results->Indication) > 0 ): ?>
                                            <?php $i = 0; ?>
                                            <?php $__currentLoopData = $results->Indication; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $indication): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td class="full-width"><?php echo Form::select('Indication['.$key.']',['N/A'=>'N/A']+$delivery_indications,$indication,['class'=>'delivery-indications-search full-width', 'id'=>'delivery-indications-search-'.$i]); ?></td>
                                                <td>
                                                    <span class="fa fa-trash btn btn-danger btn-view remove"></span>
                                                </td>
                                            </tr>
                                            <?php $i++; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php else: ?>
                                            <tr>
                                                <td class="full-width"><?php echo Form::select('Indication[]',['N/A'=>'N/A']+$delivery_indications,null,['class'=>'delivery-indications-search full-width', 'id'=>'delivery-indications-search-0']); ?></td>
                                                <td>
                                                    <span class="fa fa-trash btn btn-danger btn-view remove"></span>
                                                </td>
                                            </tr>
                                            <?php endif; ?> 
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    <?php echo Form::label('Presentation','Presentation:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">
                                    <?php echo Form::select('Presentation',["Not Known"=>"Not Known","Cephalic"=>"Cephalic","Breech"=>"Breech","Twins"=>"Twins","Transverse Lie"=>"Transverse Lie","Other"=>"Other"],null,['class'=>'form-control']); ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    <?php echo Form::label('FoetalDistress','Fetal Distress:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">
                                    <?php echo Form::select('FoetalDistress',['Not Known'=>'Not Known','No'=>'No','Yes'=>'Yes'],null,['class'=>'form-control']); ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control md-mt-50">
                                    <?php echo Form::label('CTG','CTG:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">
                                    <?php echo Form::select('CTG',["Normal"=>"Normal","Abnormal"=>"Abnormal","Not Known"=>"Not Known"],null,['class'=>'form-control','id' => 'CTG','data-color'=>ValuelistHelpers::setColorvalue('reactive',4)]); ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    <?php echo Form::label('CTGDetails','CTG Details:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">
                                    <?php echo Form::text('CTGDetails',null,['class'=>'form-control','id' => 'CTGDetails']); ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    <?php echo Form::label('CordBloodGas','Cord Blood Gas:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">
                                    <?php echo Form::select('CordBloodGas',["Not done"=>"Not done","Not indicated"=>"Not indicated","Arterial"=>"Arterial","Venous"=>"Venous","Capillary"=>"Capillary"],null,['class'=>'form-control']); ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    <?php echo Form::label('CordpH','Cord pH:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">
                                    <?php echo Form::text('CordpH',null,['class'=>'form-control']); ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    <?php echo Form::label('CordHCO3','Cord HCO3:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">
                                    <?php echo Form::text('CordHCO3',null,['class'=>'form-control']); ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    <?php echo Form::label('CordBE','Cord BE:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">
                                    <?php echo Form::text('CordBE',null,['class'=>'form-control']); ?>

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
                                    <?php echo Form::label('TypeofAnesthesia','Type of Anesthesia:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">
                                    <?php echo Form::select('TypeofAnesthesia',["Local"=>"Local","Spinal"=>"Spinal","Epidural"=>"Epidural","General"=>"General","None"=>"None"],null,['class'=>'form-control']); ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    <?php echo Form::label('GastricAspirate','Gastric Aspirate:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">
                                    <?php echo Form::select('GastricAspirate',ValuelistHelpers::GastricAspirate(),null,['class'=>'form-control']); ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control md-mt-50">
                                    <?php echo Form::label('delayed_cord_clamping','Delayed Cord Clamping:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">
                                    <?php echo Form::select('delayed_cord_clamping',ValuelistHelpers::get_comman_options(),null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('Delayedcord',4)]); ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control mt-0">
                                    <?php echo Form::label('reason_dcc','Reason for No DCC:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">
                                    <?php echo Form::text('reason_dcc',null,['class'=>'form-control']); ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control mt-0">
                                    <?php echo Form::label('duration_dcc','Duration of DCC (seconds):'); ?>

                                </div>
                                <div class="col-md-9 custom-input">
                                    <?php echo Form::text('duration_dcc',null,['class'=>'form-control']); ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control md-mt-50">
                                    <?php echo Form::label('umbilicalcordmilking','Umbilical Cord Milking:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">
                                    <?php echo Form::select('umbilicalcordmilking',['N/A'=>'N/A','Yes'=>'Yes','No'=>'No'],null,['class'=>'form-control']); ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control md-mt-50">
                                    <?php echo Form::label('cutcordmilking','Cut Cord Milking:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">
                                    <?php echo Form::select('cutcordmilking',['N/A'=>'N/A','Yes'=>'Yes','No'=>'No'],null,['class'=>'form-control']); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Resuscitation Form -->
            <!-- <div role="tabpanel" class="tab-pane <?php if($_COOKIE['neonatal_proforma'] == 'resform'): ?> active <?php endif; ?>" id="resform"> -->
            <div role="tabpanel" class="tab-pane" id="resform">
                <div class="col-md-6 col-sm-6">
                    <div class="widget box">
                        <div class="widget-header">
                            <h4><i class="fa fa-reorder"></i> </h4>
                        </div>
                        <div class="widget-content">
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    <?php echo Form::label('FacialOxygen','Facial Oxygen:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">  
                                    <input id="FacialOxygen" data-size="small" data-width="100" name="FacialOxygen" data-on="Yes" data-off="No" checked data-toggle="toggle"  class="form-control" type="checkbox">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control mt-0">
                                    <?php echo Form::label('DurationOfOxygen','Duration of Oxygen (min):'); ?>

                                </div>
                                <div class="col-md-9 custom-input">  
                                    <?php echo Form::text('DurationOfOxygen',null,['class'=>'form-control']); ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control mt-0">
                                    <?php echo Form::label('maximum_fio2_required','Maximum FiO2 required (%):'); ?>

                                </div>
                                <div class="col-md-9 custom-input">  
                                    <?php echo Form::text('maximum_fio2_required',null,['class'=>'form-control']); ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    <?php echo Form::label('Resuscitation','Resuscitation:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">  
                                    <input id="Resuscitation" data-size="small" data-width="100" name="Resuscitation" data-on="Yes" data-off="No" checked data-toggle="toggle"  class="form-control" type="checkbox">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control md-mt-50">
                                    <?php echo Form::label('initial_steps', 'Initial Steps:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">  
                                    <?php echo Form::select('initial_steps',['N/A'=>'N/A','Yes'=>'Yes','No'=>'No'],null,['class'=>'form-control']); ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control mt-0">
                                    <?php echo Form::label('timeofgasp_status','Time of 1st Gasp:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">  
                                    <input id="timeofgasp_status" data-size="small" data-width="100" name="timeofgasp_status" data-on="Known" data-off="Unknown"  data-toggle="toggle"  class="form-control" type="checkbox">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control mt-0">
                                    <?php echo Form::label('TimeOf1stGasp','Time of 1st Gasp (min):'); ?>

                                </div>
                                <div class="col-md-9 custom-input">  
                                    <?php echo Form::text('TimeOf1stGasp',null,['class'=>'form-control']); ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control mt-0">
                                    <?php echo Form::label('regularrespiration_status','Regular Respiration:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">  
                                    <input id="regularrespiration_status" data-size="small" data-width="100" name="regularrespiration_status" data-on="Known" data-off="Unknown"  data-toggle="toggle"  class="form-control" type="checkbox">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control mt-0">
                                    <?php echo Form::label('RegularRespiration','Regular Respiration (min):'); ?>

                                </div>
                                <div class="col-md-9 custom-input">  
                                    <?php echo Form::text('RegularRespiration',null,['class'=>'form-control']); ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control mt-0">
                                    <?php echo Form::label('bag_mask_ventilator','Delivery Room CPAP:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">  
                                    <input id="delivery_room_cpap" data-size="small" data-width="100" name="delivery_room_cpap" data-on="Yes" data-off="No"  data-toggle="toggle"  class="form-control" type="checkbox">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control mt-0">
                                    <?php echo Form::label('bag_mask_ventilator','Bag Mask Ventilation:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">  
                                    <input id="bag_mask_ventilator" data-size="small" data-width="100" name="bag_mask_ventilator" data-on="Yes" data-off="No"  data-toggle="toggle"  class="form-control" type="checkbox">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control mt-0">
                                    <?php echo e(Form::label('bag_mask_ventilator_duration', 'Bag Mask Ventilation Duration:'), false); ?>

                                </div>
                                <div class="col-md-9 custom-input">  
                                    <input id="bag_mask_ventilator_duration" data-size="small" data-width="100" name="bag_mask_ventilator_duration" data-on="known" data-off="Unknown"  data-toggle="toggle"  class="form-control" type="checkbox">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control mt-0">
                                    <?php echo Form::label('bag_mask_ventilator_min','Bag Mask Ventilator Min:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">  
                                    <?php echo Form::text('bag_mask_ventilator_min',null,['class'=>'form-control', 'onkeypress' => 'return ISNumber(event);']); ?>

                                </div>
                            </div>
                            <div class="form-group row ">
                                <div class="col-md-3 text-right label-control">
                                    <?php echo Form::label('Intubation','Intubation:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">  
                                    <input id="Intubation" data-size="small" data-width="100" name="Intubation" data-on="Yes" data-off="No" checked data-toggle="toggle"  class="form-control" type="checkbox">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control md-mt-50">
                                    <?php echo Form::label('ETTSize','ETT Size (mm):'); ?>

                                </div>
                                <div class="col-md-9 custom-input">  
                                    <?php echo Form::select('ETTSize',['0'=>'None','2.0'=>'2.0','2.5'=>'2.5','3.0'=>'3.0','3.5'=>'3.5','4.0'=>'4.0'],null,['class'=>'form-control']); ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control mt-0">
                                    <?php echo Form::label('insertion_status','Depth Of Insertion:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">  
                                    <input id="insertion_status" data-size="small" data-width="100" name="insertion_status" data-on="known" data-off="Unknown" checked data-toggle="toggle"  class="form-control" type="checkbox">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control mt-0">
                                    <?php echo Form::label('DepthOfInsertion','Depth Of Insertion (cm):'); ?>

                                </div>
                                <div class="col-md-9 custom-input">  
                                    <?php echo Form::text('DepthOfInsertion',null,['class'=>'form-control']); ?>

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
                                    <?php echo Form::label('PPV','PPV (BTV):'); ?>

                                </div>
                                <div class="col-md-9 custom-input">  
                                    <input id="PPV" data-size="small" data-width="100" name="PPV" data-on="Yes" data-off="No" checked data-toggle="toggle"  class="form-control" type="checkbox">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    <?php echo Form::label('ppv_status','Duration of PPV:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">  
                                    <input id="ppv_status" data-size="small" data-width="100" name="ppv_status" data-on="known" data-off="Unknown" checked data-toggle="toggle"  class="form-control" type="checkbox">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control mt-0">
                                    <?php echo Form::label('DurationOfPPV','Duration of PPV (min):'); ?>

                                </div>
                                <div class="col-md-9 custom-input">  
                                    <?php echo Form::text('DurationOfPPV',null,['class'=>'form-control ', 'onkeypress' => 'return ISNumber(event);']); ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    <?php echo Form::label('CPR','CPR:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">  
                                    <input id="CPR" data-size="small" data-width="100" name="CPR" data-on="Yes" data-off="No" checked data-toggle="toggle"  class="form-control" type="checkbox">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    <?php echo Form::label('cpr_status','Duration of CPR:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">  
                                    <input id="cpr_status" data-size="small" data-width="100" name="cpr_status" data-on="known" data-off="Unknown" checked data-toggle="toggle"  class="form-control" type="checkbox">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control mt-0">
                                    <?php echo Form::label('duration_of_cpr','Duration of CPR (min):'); ?>

                                </div>
                                <div class="col-md-9 custom-input">  
                                    <?php echo Form::text('duration_of_cpr',null,['class'=>'form-control', 'onkeypress' => 'return ISNumber(event);']); ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    <?php echo Form::label('Drugs','Drugs:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">  
                                    <input id="Drugs" data-size="small" data-width="100" name="Drugs" data-on="Yes" data-off="No" checked data-toggle="toggle"  class="form-control" type="checkbox">
                                </div>
                            </div>
                            <div class="hidden">
                                <?php echo Form::select('temp_resusciatation_drugs',[''=>'N/A']+ValuelistHelpers::resuscitationMedication(),null); ?>

                            </div>
                            <div class="col-md-10 plr-0">
                                <div class="form-group row drug-main">
                                    <div class="col-md-3 text-right label-control">
                                        <?php echo Form::label('Drug','Drugs:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <table class="drugs table table-add-more full-width-fix">
                                            <thead>
                                                <tr class="master-add-header">
                                                    <th class="full-width">
                                                        <i class="fa fa-reorder"></i>Add More
                                                    </th>
                                                    <th>
                                                        <span>
                                                        <a class="btn_add btn btn-success btn-view resustation_drug_add" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                                                        </span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(isset($results->resusciatation_drugs) && count($results->resusciatation_drugs) > 0): ?>
                                                <?php $__currentLoopData = $results->resusciatation_drugs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td  class="form-group">
                                                        <?php echo Form::select('resusciatation_drugs['.$key.']',[''=>'N/A']+ValuelistHelpers::resuscitationMedication(),$data,["class"=>"form-control input-width-xlarge"]); ?>

                                                    </td>
                                                    <td>
                                                        <span class="fa fa-trash btn btn-danger btn-view remove-drug"></span>
                                                    </td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                <tr>
                                                    <td  class="form-group">
                                                        <?php echo Form::select('resusciatation_drugs[]',[''=>'N/A']+ValuelistHelpers::resuscitationMedication(),null,["class"=>"form-control input-width-xlarge"]); ?>

                                                    </td>
                                                    <td>
                                                        <span class="fa fa-trash btn btn-danger btn-view remove-drug"></span>
                                                    </td>
                                                </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <?php echo Form::label('OtherInformation','Resuscitation Details:'); ?>

                                </div>
                                <div class="col-md-12">
                                    <?php echo Form::textarea('OtherInformation',null,['class'=>'form-control','rows'=>'5']); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Essential Form -->
            <!-- <div role="tabpanel" class="tab-pane <?php if($_COOKIE['neonatal_proforma'] == 'essform'): ?> active <?php endif; ?>" id="essform"> -->
            <div role="tabpanel" class="tab-pane" id="essform">
                <div class="col-md-6 col-sm-6">
                    <div class="mt-10 widget box">
                        <div class="widget-header">
                            <h4><i class="fa fa-reorder"></i> </h4>
                        </div>
                        <div class="widget-content">
                            <div class="">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        <?php echo Form::label('VitaminK','VitaminK:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('VitaminK',['Not known'=>'Not known','No'=>'No','Yes'=>'Yes'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('vitamin_k',4)]); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        <?php echo Form::label('DoseVitK','Dose VitK:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('DoseVitK',[''=>'N/A','1 mg'=>'1 mg','0.5 mg'=>'0.5 mg'],null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control md-mt-50">
                                        <?php echo Form::label('RouteVitK','Route VitK:'); ?>

                                    </div>
                                    <div class="col-md-9 custom-input">
                                        <?php echo Form::select('RouteVitK',[''=>'N/A','IM'=>'IM','IV'=>'IV','Oral'=>'Oral'],null,['class'=>'form-control']); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control md-mt-30">
                                    <?php echo Form::label('InitialExamination','Summary of Initial Examination Following Birth:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">
                                    <?php echo Form::textarea('InitialExamination',null,['class'=>'form-control','rows'=>'5']); ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    <?php echo Form::label('Malformation','Malformation:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">
                                    <?php echo Form::select('Malformation',['No'=>'No','Yes'=>'Yes'],null,['class'=>'form-control']); ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control md-mt-30">
                                    <?php echo Form::label('MalformationType','Malformation Type:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">
                                    <?php echo Form::textarea('MalformationType',null,['class'=>'form-control','rows'=>'5']); ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control md-mt-50">
                                    <?php echo Form::label('ict','ICT:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">
                                    <?php echo Form::select('ict',ValuelistHelpers::Ict(),null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('ict',4)]); ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control md-mt-50">
                                    <?php echo Form::label('DCT','DCT:'); ?>

                                </div>
                                <div class="col-md-9 custom-input">
                                    <?php echo Form::select('DCT',ValuelistHelpers::Dct(),null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('dct',4)]); ?>

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
                                <div class="col-md-12">
                                    <?php echo Form::label('Background','Background:'); ?>

                                </div>
                                <div class="col-md-12">
                                    <?php echo Form::textarea('Background',null,['class'=>'form-control','rows'=>'5']); ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <?php echo Form::label('PLAN','PLAN:'); ?>

                                </div>
                                <div class="col-md-12">
                                    <?php echo Form::textarea('PLAN',null,['class'=>'form-control','rows'=>'5']); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Summary Form -->
            <div role="tabpanel" class="tab-pane" id="summaryform">
                <div class="mt-10 widget box">
                    <div class="widget-header">
                        <h4><i class="fa fa-reorder"></i> </h4>
                    </div>
                    <div class="widget-content">
                        <div class="form-group">
                            <?php echo Form::label('ConfidentialBackgroundDetails','Confidential Background Details:'); ?>

                            <?php echo Form::textarea('ConfidentialBackgroundDetails',null,['class'=>'form-control']); ?>

                        </div>
                        <div class="form-group">
                            <?php echo Form::label('Notes','Notes:'); ?>

                            <?php echo Form::textarea('Notes',null,['class'=>'form-control']); ?>

                        </div>
                    </div>
                </div>
            </div>
            <?php if(\Session::get('admission_module') != 'NICU_ADMISSION'): ?>
            <!-- New Born Examination -->
            <!-- <div role="tabpanel" class="tab-pane <?php if($_COOKIE['neonatal_proforma'] == 'newbornform'): ?> active <?php endif; ?>" id="newbornform"> -->
            <div role="tabpanel" class="tab-pane" id="newbornform">
                <div class="tabbable tabbable-custom">
                    <ul class="nav nav-tabs" role="tablist">
                        <!-- <li role="presentation" <?php if($_COOKIE['neonatal_proforma_sub'] == 'vitals'): ?> class="active" <?php endif; ?>> -->
                        <li role="presentation"class="active">
                            <a class="tab-sub-menu" href="#vitals" aria-controls="vitals" role="tab" data-toggle="tab">VITALS</a>
                        </li>
                        <!-- <li role="presentation" <?php if($_COOKIE['neonatal_proforma_sub'] == 'gpe'): ?> class="active" <?php endif; ?>> -->
                        <li role="presentation">
                            <a class="tab-sub-menu" href="#gpe" aria-controls="gpe" role="tab" data-toggle="tab">GPE</a>
                        </li>
                        <!-- <li role="presentation" <?php if($_COOKIE['neonatal_proforma_sub'] == 'cvs'): ?> class="active" <?php endif; ?>> -->
                        <li role="presentation">
                            <a class="tab-sub-menu" href="#cvs" aria-controls="cvs" role="tab" data-toggle="tab">CVS</a>
                        </li>
                        <!-- <li role="presentation" <?php if($_COOKIE['neonatal_proforma_sub'] == 'rs'): ?> class="active" <?php endif; ?>> -->
                        <li role="presentation">
                            <a class="tab-sub-menu" href="#rs" aria-controls="rs" role="tab" data-toggle="tab">RS</a>
                        </li>
                        <!-- <li role="presentation" <?php if($_COOKIE['neonatal_proforma_sub'] == 'abdomen'): ?> class="active" <?php endif; ?>> -->
                        <li role="presentation">
                            <a class="tab-sub-menu" href="#abdomen" aria-controls="abdomen" role="tab" data-toggle="tab">ABDOMEN</a>
                        </li>
                        <!-- <li role="presentation" <?php if($_COOKIE['neonatal_proforma_sub'] == 'cns'): ?> class="active" <?php endif; ?>> -->
                        <li role="presentation">
                            <a class="tab-sub-menu" href="#cns" aria-controls="cns" role="tab" data-toggle="tab">CNS</a>
                        </li>
                        <!-- <li role="presentation"><a href="#additional_details" aria-controls="cns" role="tab" data-toggle="tab">Additional Details</a></li> -->
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <!-- <div role="tabpanel" class="tab-pane <?php if($_COOKIE['neonatal_proforma_sub'] == 'vitals'): ?> active <?php endif; ?>" id="vitals"> -->
                        <div role="tabpanel" class="tab-pane active" id="vitals">
                            <div class=" col-md-6 col-sm-6">
                                <div class="mt-10 widget box">
                                    <div class="widget-header">
                                        <h4><i class="fa fa-reorder"></i> </h4>
                                    </div>
                                    <div class="widget-content">
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('NbHR','HR in bpm:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::text('NbHR',null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('NbRR','RR:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::text('NbRR',null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-8 text-right label-control">
                                                <?php echo Form::label('newbornStatus','Is the rest of the newborn examination normal ?'); ?>

                                            </div>
                                            <div class="col-md-3 custom-input">
                                                <input  data-toggle="toggle" data-size="small" data-width="100" class="form-control" id="newbornStatus" height="5px" name="newbornStatus" data-on="Yes" data-off="No" type="checkbox">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('CentralPulses','Central Pulses:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('CentralPulses',[''=>'N/A','Normal'=>'Normal','Bounding'=>'Bounding','Feeble/Weak'=>'Feeble/Weak','Absent'=>'Absent'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control md-mt-50">
                                                <?php echo Form::label('NbCFT','CFT:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('NbCFT',[''=>'N/A','< 3 Seconds' => "< 3 Seconds",'3-5 Seconds' => "3-5 Seconds",'>5 Seconds' => ">5 Seconds","Prolonged"=>"Prolonged"],null,['class'=>'form-control']); ?>

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
                                            <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                                <?php echo Form::label('TemperatureF','Temperature (F/C):'); ?>

                                            </div>
                                            <!-- <div class="col-md-9 custom-input">
                                                <?php echo Form::text('TemperatureF',null,['class'=>'form-control']); ?>

                                                </div> -->
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
                                                        <?php echo Form::text('','',['class'=>'form-control fahrenheit']); ?>

                                                    </div>
                                                    <div class="col-xs-6">
                                                        <?php echo Form::text('TemperatureF',null,['class'=>'form-control celsius']); ?>

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
                                                        <?php echo Form::text('TemperatureF',null,['class'=>'form-control celsius']); ?>

                                                    </div>
                                                    <div class="col-xs-6">
                                                        <?php echo Form::text('','',['class'=>'form-control fahrenheit']); ?>

                                                    </div>
                                                </div>
                                                <?php endif; ?>
                                                <label class="error help-block" for="BirthWeight" generated="true" style="display: none;"></label>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('NbSpO2','SpO2:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::text('NbSpO2',null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('PeripheralPulses','Peripheral Pulses:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('PeripheralPulses',[''=>'N/A','Normal'=>'Normal','Bounding'=>'Bounding','Feeble/Weak'=>'Feeble/Weak','Absent'=>'Absent'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control md-mt-50">
                                                <?php echo Form::label('Colour','Colour:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('Colour',['Yellow'=>'Yellow','Pink'=>'Pink','Acral Cyanosis'=>'Acral Cyanosis','Central Cyanosis'=>'Central Cyanosis'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div role="tabpanel" class="tab-pane <?php if($_COOKIE['neonatal_proforma_sub'] == 'gpe'): ?> active <?php endif; ?>" id="gpe"> -->
                        <div role="tabpanel" class="tab-pane" id="gpe">
                            <div class=" col-md-6 col-sm-6">
                                <div class="mt-10 widget box">
                                    <div class="widget-header">
                                        <h4><i class="fa fa-reorder"></i> </h4>
                                    </div>
                                    <div class="widget-content">
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control md-mt-50">
                                                <?php echo Form::label('Pallor','Pallor:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('Pallor',[''=>'N/A','Present'=>'Present','Absent'=>'Absent'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="hidden">
                                            <?php echo Form::select('tempscalp',[''=>'N/A','Normal'=>'Normal',"Caput Succedaneum"=>"Caput Succedaneum","Cephalhematoma"=>"Cephalhematoma","Bruises"=>"Bruises","Laceration"=>"Laceration"],null,['class'=>'form-control input-width-large']); ?>

                                        </div>
                                        <div class="form-group">
                                            <div class="form-group row">
                                                <div class="col-md-3 text-right label-control">
                                                    <?php echo Form::label('Scalp','Scalp:'); ?>

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
                                                            <?php if(isset($results->Scalp) && count($results->Scalp) > 0): ?>
                                                            <?php $__currentLoopData = $results->Scalp; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $scalpValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td class="full-width"><?php echo Form::select('Scalp[]',[''=>'N/A','Normal'=>'Normal',"Caput Succedaneum"=>"Caput Succedaneum","Cephalhematoma"=>"Cephalhematoma","Bruises"=>"Bruises","Laceration"=>"Laceration"],$scalpValue,['class'=>'form-control']); ?></td>
                                                                <td>
                                                                    <span class="fa fa-trash btn btn-danger btn-view remove-scalp"></span>
                                                                </td>
                                                            </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
                                                            <?php else: ?>
                                                            <tr>
                                                                <td class="full-width"><?php echo Form::select('Scalp[]',[''=>'N/A','Normal'=>'Normal',"Caput Succedaneum"=>"Caput Succedaneum","Cephalhematoma"=>"Cephalhematoma","Bruises"=>"Bruises","Laceration"=>"Laceration"],null,['class'=>'form-control']); ?></td>
                                                                <td>
                                                                    <span class="fa fa-trash btn btn-danger btn-view remove-scalp"></span>
                                                                </td>
                                                            </tr>
                                                            <?php endif; ?> 
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
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
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('Ears','Ears:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('Ears',[''=>'N/A','Normal'=>'Normal','Low Set'=>'Low Set','Preauricular tag Rt'=>'Preauricular tag Rt','Preauricular tag Lt'=>'Preauricular tag Lt','Preauricular tag Bilateral'=>'Preauricular tag Bilateral'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control md-mt-50">
                                                <?php echo Form::label('Nose','Nose:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('Nose',[''=>'N/A','Normal'=>'Normal','Depressed nasal bridge'=>'Depressed nasal bridge'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('Nostrils','Nostrils:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('Nostrils',[''=>'N/A','Patent'=>'Patent','Choanal Atresia Rt'=>'Choanal Atresia Rt','Choanal Atresia Rt'=>'Choanal Atresia Rt','Choanal Atresia Lt'=>'Choanal Atresia Lt','Choanal Atresia Bilateral'=>'Choanal Atresia Bilateral'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control md-mt-50">
                                                <?php echo Form::label('Lips','Lips:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('Lips',[''=>'N/A','Normal'=>'Normal','Cleft Lip'=>'Cleft Lip'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control md-mt-50">
                                                <?php echo Form::label('Palate','Palate:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('Palate',[''=>'N/A','Normal'=>'Normal','Cleft Palate'=>'Cleft Palate'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control md-mt-50">
                                                <?php echo Form::label('Neck','Neck:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('Neck',[''=>'N/A','Normal'=>'Normal','Cystic Hygroma'=>'Cystic Hygroma','Sternomastoid tumor'=>'Sternomastoid tumor'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control md-mt-50">
                                                <?php echo Form::label('Nipples','Nipples:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('Nipples',[''=>'N/A','Normal'=>'Normal','Supernumerary'=>'Supernumerary'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control md-mt-50">
                                                <?php echo Form::label('Esophagus','Esophagus:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('Esophagus',[''=>'N/A','Patent'=>'Patent','TEF/Atresia'=>'TEF/Atresia'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('Umbilicus','Umbilicus:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('Umbilicus',[''=>'N/A','Normal'=>'Normal','Omphalocele'=>'Omphalocele','Gastroschisis'=>'Gastroschisis','Hernia'=>'Hernia','Meconium Stained' => 'Meconium Stained','Large' => 'Large','Shrivelled' => 'Shrivelled'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control md-mt-50">
                                                <?php echo Form::label('UmbilicalCord','UmbilicalCord:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('UmbilicalCord',[''=>'N/A','Normal'=>'Normal','Single Umbilical Artery'=>'Single Umbilical Artery'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control md-mt-50">
                                                <?php echo Form::label('AnteriorFontanelle','Anterior Fontanelle:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('AnteriorFontanelle',[''=>'N/A','Normal'=>'Normal','Depressed'=>'Depressed','Bulging'=>'Bulging'],null,['class'=>'form-control']); ?>

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
                                                <?php echo Form::label('Jaundice','Jaundice:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('Jaundice',[''=>'N/A','Present'=>'Present','Absent'=>'Absent'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('HernialOrifices','Hernial Orifices:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('HernialOrifices',[''=>'N/A','No hernia'=>'No hernia','Right Inguinal hernia'=>'Right Inguinal hernia','Left Inguinal hernia'=>'Left Inguinal hernia','Umbilical/para umbilical hernia'=>'Umbilical/para umbilical hernia','Obstructed/strangulated'=>'Obstructed/strangulated'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('FemoralPulses','Femoral Pulses:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('FemoralPulses',[''=>'N/A','Normal'=>'Normal','Bounding'=>'Bounding','Feeble/Weak'=>'Feeble/Weak','Absent'=>'Absent'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('Genitalia','Genitalia:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('Genitalia',[''=>'N/A','Normal'=>'Normal','Clitoromegaly'=>'Clitoromegaly','Hypospadias'=>'Hypospadias','Cryptorchidism'=>'Cryptorchidism','Chordee'=>'Chordee','Ambiguous'=>'Ambiguous'],null,['class'=>'form-control']); ?>

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
                                                <?php echo Form::label('Anus','Anus:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('Anus',[''=>'N/A','Patent'=>'Patent','Imperforate'=>'Imperforate'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control md-mt-50">
                                                <?php echo Form::label('Spine','Spine:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('Spine',[''=>'N/A','Normal'=>'Normal','Kyphoscoliosis'=>'Kyphoscoliosis','Sacral dimple'=>'Sacral dimple'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('RtUL','Rt UL:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('RtUL',[''=>'N/A','Normal'=>'Normal','Polydactyly'=>'Polydactyly','Syndactyly'=>'Syndactyly','Clinodactyly'=>'Clinodactyly','Single Crease'=>'Single Crease'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('RtLL','Rt LL:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('RtLL',[''=>'N/A','Normal'=>'Normal','Polydactyly'=>'Polydactyly','Syndactyly'=>'Syndactyly','Positional tallipes'=>'Positional tallipes','Fixed tallipes'=>'Fixed tallipes'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('LtUL','Lt UL:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('LtUL',[''=>'N/A','Normal'=>'Normal','Polydactyly'=>'Polydactyly','Syndactyly'=>'Syndactyly','Clinodactyly'=>'Clinodactyly','Single Crease'=>'Single Crease'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('LtLL','Lt LL:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('LtLL',[''=>'N/A','Normal'=>'Normal','Polydactyly'=>'Polydactyly','Syndactyly'=>'Syndactyly','Positional tallipes'=>'Positional tallipes','Fixed tallipes'=>'Fixed tallipes'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('Skin','Skin:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('Skin',[''=>'N/A','Normal'=>'Normal','Blueberry muffin spots'=>'Blueberry muffin spots','Mongolian spots'=>'Mongolian spots','Erythema toxicum'=>'Erythema toxicum','Milia'=>'Milia','Miliaria'=>'Miliaria'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control md-mt-50">
                                                <?php echo Form::label('Hairs','Hairs:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('Hairs',[''=>'N/A','Normal'=>'Normal','Alopecia'=>'Alopecia'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-0">
                                                <?php echo Form::label('AnyOtherAbnormality','Any Other Abnormality:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::text('AnyOtherAbnormality',null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div role="tabpanel" class="tab-pane <?php if($_COOKIE['neonatal_proforma_sub'] == 'cvs'): ?> active <?php endif; ?>" id="cvs"> -->
                        <div role="tabpanel" class="tab-pane" id="cvs">
                            <div class=" col-md-6 col-sm-6">
                                <div class="mt-10 widget box">
                                    <div class="widget-header">
                                        <h4><i class="fa fa-reorder"></i> </h4>
                                    </div>
                                    <div class="widget-content">
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control md-mt-30">
                                                <?php echo Form::label('PrecordialActivity','Precordial Activity:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('PrecordialActivity',[''=>'N/A','Present'=>'Present','Absent'=>'Absent'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control md-mt-30">
                                                <?php echo Form::label('ApicalImpulse','Apical Impulse:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('ApicalImpulse',[''=>'N/A','Normal'=>'Normal','Right Side'=>'Right Side'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('BoundingPulses','Bounding Pulses:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('BoundingPulses',[''=>'N/A','Normal'=>'Normal','Bounding'=>'Bounding','Feeble/Weak'=>'Feeble/Weak','Absent'=>'Absent'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-0">
                                                <?php echo Form::label('other_cvs_findings','Other CVS findings:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::text('other_cvs_findings',null,['class'=>'form-control']); ?>

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
                                            <div class="col-md-3 text-right label-control md-mt-30">
                                                <?php echo Form::label('S1S2','S1S2:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('S1S2',[''=>'N/A','Normal'=>'Normal','Abnormal'=>'Abnormal'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control md-mt-30">
                                                <?php echo Form::label('Murmur','Murmur:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('Murmur',[''=>'N/A','Present'=>'Present','Absent'=>'Absent'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control mt-0">
                                                <?php echo Form::label('CharacterofMurmur','Character of Murmur:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::text('CharacterofMurmur',null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('SiteofMurmur','Site of Murmur:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('SiteofMurmur',['N/A'=>'Not applicable','Apical Area'=>'Apical Area','Aortic Area'=>'Aortic Area','Aortic Area'=>'Aortic Area','Pulmonary Area'=>'Pulmonary Area','Tricuspid Area'=>'Tricuspid Area','Rt Parasternal Area'=>'Rt Parasternal Area','Lt Parasternal Area'=>'Lt Parasternal Area'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div role="tabpanel" class="tab-pane <?php if($_COOKIE['neonatal_proforma_sub'] == 'rs'): ?> active <?php endif; ?>" id="rs"> -->
                        <div role="tabpanel" class="tab-pane" id="rs">
                            <div class=" col-md-6 col-sm-6">
                                <div class="mt-10 widget box">
                                    <div class="widget-header">
                                        <h4><i class="fa fa-reorder"></i> </h4>
                                    </div>
                                    <div class="widget-content">
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control md-mt-50">
                                                <?php echo Form::label('NbChestMovement','Chest Movement:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('NbChestMovement',[''=>'N/A','Symmetrical'=>'Symmetrical','Asymmetrical'=>'Asymmetrical'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-3 text-right label-control md-mt-50">
                                                <?php echo Form::label('BreathSounds','Breath Sounds:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('BreathSounds',[''=>'N/A','Normal Vesicular'=>'Normal Vesicular','Abnormal'=>'Abnormal'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control md-mt-50">
                                                <?php echo Form::label('AirEntry','Air Entry:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('AirEntry',[''=>'N/A','Equal'=>'Equal','Reduced Bilateral'=>'Reduced Bilateral','Reduced Rt'=>'Reduced Rt','Reduced Lt'=>'Reduced Lt'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('other_rs_findings','Other RS findings:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::text('other_rs_findings',null,['class'=>'form-control']); ?>

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
                                                <?php echo Form::label('AddedSounds','Added Sounds:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('AddedSounds',[''=>'N/A','Present'=>'Present','Absent'=>'Absent'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control m-0">
                                                <?php echo Form::label('CharacterOfAddedSounds','Character Of Added Sounds:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::text('CharacterOfAddedSounds',null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control m-0">
                                                <?php echo Form::label('SiteofAddedSounds','Site of Added Sounds:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::text('SiteofAddedSounds',null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div role="tabpanel" class="tab-pane <?php if($_COOKIE['neonatal_proforma_sub'] == 'abdomen'): ?> active <?php endif; ?>" id="abdomen"> -->
                        <div role="tabpanel" class="tab-pane" id="abdomen">
                            <div class=" col-md-6 col-sm-6">
                                <div class="mt-10 widget box">
                                    <div class="widget-header">
                                        <h4><i class="fa fa-reorder"></i> </h4>
                                    </div>
                                    <div class="widget-content">
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control md-mt-50">
                                                <?php echo Form::label('AbdomenShape','Abdomen Shape:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('AbdomenShape',[''=>'N/A','Normal'=>'Normal','Scaphoid'=>'Scaphoid','Distended'=>'Distended'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control md-mt-50">
                                                <?php echo Form::label('Hepatomegaly','Hepatomegaly:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('Hepatomegaly',[''=>'N/A','Present'=>'Present','Absent'=>'Absent'],null,['class'=>'form-control']); ?>

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
                                                <?php echo Form::label('Splenomegaly','Splenomegaly:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('Splenomegaly',[''=>'N/A','Present'=>'Present','Absent'=>'Absent'],null,['class'=>'form-control']); ?>

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
                                            <div class="col-md-3 text-right label-control md-mt-50">
                                                <?php echo Form::label('Flanks','Flanks:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('Flanks',[''=>'N/A','Normal'=>'Normal','Full'=>'Full'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('other_pa_findings','Other PA findings:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::text('other_pa_findings',null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div role="tabpanel" class="tab-pane <?php if($_COOKIE['neonatal_proforma_sub'] == 'cns'): ?> active <?php endif; ?>" id="cns"> -->
                        <div role="tabpanel" class="tab-pane" id="cns">
                            <div class=" col-md-6 col-sm-6">
                                <div class="mt-10 widget box">
                                    <div class="widget-header">
                                        <h4><i class="fa fa-reorder"></i> </h4>
                                    </div>
                                    <div class="widget-content">
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control">
                                                <?php echo Form::label('LevelOfConsciousness','Level Of Consciousness:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('LevelOfConsciousness',[''=>'N/A','Normal'=>'Normal','Drowsy'=>'Drowsy','Comatosed'=>'Comatosed','Hyperalert'=>'Hyperalert','Irritable'=>'Irritable'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3 text-right label-control md-mt-50">
                                                <?php echo Form::label('Seizures','Seizures:'); ?>

                                            </div>
                                            <div class="col-md-9 custom-input">
                                                <?php echo Form::select('Seizures',[''=>'N/A','Yes'=>'Yes','No'=>'No'],null,['class'=>'form-control']); ?>

                                            </div>
                                        </div>
                                        <div class="form-group row" id="TypeofSeizureDiv"  <?php echo $displaystyle; ?>>
                                        <div class="col-md-3 text-right label-control md-mt-50">
                                            <?php echo Form::label('TypeofSeizure','Type of Seizure:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::select('TypeofSeizure',[''=>'N/A','Subtle'=>'Subtle','Tonic'=>'Tonic','Clonic'=>'Clonic','Myoclonus'=>'Myoclonus'],null,['class'=>'form-control']); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control md-mt-30">
                                            <?php echo Form::label('GeneralBodyMovements','General Body Movements:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::select('GeneralBodyMovements',[''=>'N/A','Symmetrical'=>'Symmetrical','Asymmetrical'=>'Asymmetrical'],null,['class'=>'form-control']); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control mt-0">
                                            <?php echo Form::label('other_cns_findings','Other CNS findings:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::text('other_cns_findings',null,['class'=>'form-control']); ?>

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
                                            <?php echo Form::label('SpontaneousActivity','Spontaneous Activity:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::select('SpontaneousActivity',[''=>'N/A','Normal'=>'Normal','Decreased'=>'Decreased','Increased'=>'Increased'],null,['class'=>'form-control']); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control md-mt-50">
                                            <?php echo Form::label('Cry','Cry:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::select('Cry',[''=>'N/A','Normal consolable'=>'Normal consolable','Abnormal Inconsolable'=>'Abnormal Inconsolable'],null,['class'=>'form-control']); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control md-mt-50">
                                            <?php echo Form::label('NbTone','Tone:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::select('NbTone',[''=>'N/A','Normal'=>'Normal','Hypotonia'=>'Hypotonia','Hypertonia'=>'Hypertonia'],null,['class'=>'form-control']); ?>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control md-mt-50">
                                            <?php echo Form::label('NeonatalReflexes','Neonatal Reflexes:'); ?>

                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <?php echo Form::select('NeonatalReflexes',[''=>'N/A','Normal'=>'Normal','Suppressed'=>'Suppressed','Absent'=>'Absent','Exaggerated'=>'Exaggerated'],null,['class'=>'form-control']); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <?php if(isset($current_nicu_id) && $current_nicu_id != 0): ?>
        <input type="hidden" name="nicu_id" value="<?php echo e($current_nicu_id, false); ?>" />
        <?php endif; ?>
        <?php echo e(Form::hidden('formstatus', 1), false); ?>

        <div class="col-md-12 col-sm-12 col-xs-12 mt-10">
            <input type="hidden" name="print_flag" value="0" id="print_flag" />
            <?php if(isset($flow_wise_register) && $flow_wise_register == 'from-dashboard'): ?>
            <input type="hidden" name="flow" value="<?php echo e($flow_wise_register, false); ?>" />
            <?php endif; ?>
            <?php if(!isset($flow_wise_register) || empty($flow_wise_register) || $flow_wise_register != 'from-dashboard'): ?>  
            <?php if(!Session::has('registration_start')): ?>
            <div class="col-md-3 col-sm-4 col-xs-12">
                <button  type="submit" value="saveclose" name="saveclose"  class="btn save-button-shadow  btn-primary btn-block form-control neonatal_save_btn_create" data-flag="0">
                <i class="fa fa-floppy-o"></i> 
                <span><?php echo $SubmitButtonText; ?></span>
                </button>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-12">
                <button type="submit" value="savedhere" name="savedhere" class="btn save-button-shadow  btn-primary btn-block form-control neonatal_save_btn_create" data-flag="1">
                    <!-- <i class="fa fa-pencil-square-o" aria-hidden="true"></i> -->
                    <i class="fa fa-floppy-o" aria-hidden="true"></i>
                    <span><?php echo $SavedhereText; ?> & Next</span>
                </button>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-12">
                <a href="<?php echo e($actionUrl, false); ?>" class="btn save-button-shadow   btn-block form-control" onclick="$('form')[0].reset();">
                <i class="fa fa-exclamation-circle"></i> 
                <span>Cancel</span>
                </a>
            </div>
            <?php else: ?> 
            <?php if(\Session::get('admission_module') == 'NICU_ADMISSION'): ?>
            <div class="col-md-3 col-xs-12 col-sm-4 <?php if(isset($_COOKIE['neonatal_proforma']) && $_COOKIE['neonatal_proforma'] == 'essform'): ?> hide <?php endif; ?>">
                <button  type="button" name="savedhere" class="btn save-button-shadow saveNext  btn-info btn-block  form-control">
                <i class="fa fa-floppy-o"></i> 
                <span><?php echo $saveNext; ?></span>
                </button>
            </div>
            <?php else: ?>
            <div class="col-md-3 col-xs-12 col-sm-4 <?php if(isset($_COOKIE['neonatal_proforma']) && $_COOKIE['neonatal_proforma'] == 'essform'): ?> hide <?php endif; ?>">
                <button  type="button" name="savedhere" class="btn save-button-shadow saveNext  btn-info btn-block  form-control">
                <i class="fa fa-floppy-o"></i> 
                <span><?php echo $saveNext; ?></span>
                </button>
            </div>
            <?php endif; ?>
            <?php if(\Session::get('admission_module') == 'NICU_ADMISSION'): ?>
            <div class="col-md-3 col-sm-4 col-xs-12 <?php if(isset($_COOKIE['neonatal_proforma']) && $_COOKIE['neonatal_proforma'] != 'essform'): ?> hide <?php endif; ?>">
                <button <?php if(Session::get('admission_module') == 'NICU_ADMISSION'): ?> data-flag="4" <?php elseif(Session::get('admission_module') == 'POSTNATAL_ADMISSION'): ?> data-flag="5" <?php endif; ?>   class="btn save-button-shadow  btn-block btn-info nicu-admission form-control neonatal_save_btn_create">
                <i class="fa fa-floppy-o"></i>
                <span> <?php if(Session::get('admission_module') == 'NICU_ADMISSION'): ?> Nicu Admission <?php elseif(Session::get('admission_module') == 'POSTNATAL_ADMISSION'): ?> Postnatal Admission <?php endif; ?></span>
                </button>
            </div>
            <?php else: ?>
            <div class="col-md-3 col-sm-4 col-xs-12 <?php if(isset($_COOKIE['neonatal_proforma']) && $_COOKIE['neonatal_proforma'] != 'essform'): ?> hide <?php endif; ?>">
                <button  <?php if(Session::get('admission_module') == 'NICU_ADMISSION'): ?> data-flag="4" <?php elseif(Session::get('admission_module') == 'POSTNATAL_ADMISSION'): ?> data-flag="5" <?php endif; ?>   class="btn save-button-shadow  btn-block btn-info nicu-admission form-control neonatal_save_btn_create">
                <i class="fa fa-floppy-o"></i>
                <span> <?php if(Session::get('admission_module') == 'NICU_ADMISSION'): ?> Nicu Admission <?php elseif(Session::get('admission_module') == 'POSTNATAL_ADMISSION'): ?> Postnatal Admission <?php endif; ?></span>
                </button>
            </div>
            <?php endif; ?>  
            <?php if(\Session::get('admission_module') == 'NICU_ADMISSION'): ?>
            <div class="col-md-3 col-sm-4 col-xs-12 <?php if(isset($_COOKIE['neonatal_proforma']) && $_COOKIE['neonatal_proforma'] != 'essform'): ?> hide <?php endif; ?>">
                <button  data-flag="2" type="submit" class="btn save-button-shadow print-tag btn-info btn-block form-control neonatal_save_btn_create">
                <i class="fa fa-tag" aria-hidden="true"></i>
                <span>Print Tag</span>
                </button>
            </div>
            <?php else: ?>
            <div class="col-md-3 col-sm-4 col-xs-12 <?php if(isset($_COOKIE['neonatal_proforma']) && $_COOKIE['neonatal_proforma'] != 'newbornform'): ?> hide <?php endif; ?>">
                <button  data-flag="2" type="submit" class="btn save-button-shadow print-tag btn-info btn-block form-control neonatal_save_btn_create">
                <i class="fa fa-tag" aria-hidden="true"></i>
                <span>Print Tag</span>
                </button>
            </div>
            <?php endif; ?>
            <?php if(\Session::get('admission_module') == 'NICU_ADMISSION'): ?>
            <div class="col-md-3 col-sm-4 <?php if(isset($_COOKIE['neonatal_proforma']) && $_COOKIE['neonatal_proforma'] == 'essform'): ?> col-xs-12 <?php else: ?> col-xs-12 <?php endif; ?>">
                <a href="<?php echo e($actionUrl, false); ?>" class="btn save-button-shadow cancel-block btn-block form-control" onclick="$('form')[0].reset();">
                <i class="fa fa-exclamation-circle"></i> 
                <span>Cancel</span>
                </a>
            </div>
            <?php else: ?> 
            <div class="<?php if(isset($_COOKIE['neonatal_proforma']) && $_COOKIE['neonatal_proforma'] == 'newbornform'): ?> col-md-3 col-sm-4 col-xs-12 <?php else: ?> col-md-3 col-sm-4 col-xs-12 <?php endif; ?>">
                <a href="<?php echo e($actionUrl, false); ?>" class="btn save-button-shadow cancel-block btn-block form-control" onclick="$('form')[0].reset();">
                <i class="fa fa-exclamation-circle"></i> 
                <span>Cancel</span>
                </a>
            </div>
            <?php endif; ?>
            <?php endif; ?>
            <?php else: ?>
            <div class="col-md-3 col-sm-4 col-xs-12">
                <button type="submit" class="btn save-button-shadow  btn-primary btn-block form-control neonatal_save_btn_create" data-flag="3">
                    <!-- <i class="fa fa-pencil-square-o" aria-hidden="true"></i> -->
                    <i class="fa fa-floppy-o" aria-hidden="true"></i>
                    <span> Update</span>
                </button>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-12">
                <button type="submit" class="btn save-button-shadow flow-dashboard-next btn-info btn-block form-control neonatal_save_btn_create" data-flag="1">
                    <!-- <i class="fa fa-pencil-square-o" aria-hidden="true"></i> -->
                    <i class="fa fa-floppy-o" aria-hidden="true"></i>
                    <span> Next</span>
                </button>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-12 hide">
                <button  data-flag="4" class="btn save-button-shadow flow-dashboard-nicu-admission btn-block btn-primary form-control neonatal_save_btn_create">
                <i class="fa fa-floppy-o"></i>
                <span> NICU Admission</span>
                </button>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-12">
                <a href="<?php echo e($actionUrl, false); ?>" class="btn save-button-shadow cancel-block btn-block form-control" onclick="$('form')[0].reset();">
                <i class="fa fa-exclamation-circle"></i> 
                <span>Cancel</span>
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php echo Form::hidden('set_active','',['id'=>'set_active']); ?>

<?php echo Form::close(); ?>

</div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">
    <?php if(isset($flow_wise_register) && !empty($flow_wise_register) && $flow_wise_register == 'from-dashboard'): ?>
        var current_active_tab = $('#neonate-next li[class="active"]').children('a').attr('aria-controls');
        <?php if($results->BirthStatus == 'Inborn'): ?>
        if(current_active_tab == 'newbornform')
        <?php else: ?>
        if(current_active_tab == 'essform')
        <?php endif; ?>
        {
            $('.flow-dashboard-nicu-admission').parent().removeClass('hide');
            $('.flow-dashboard-next').parent().addClass('hide');
            $('input[name="formstatus"]').val(1);
        }
        $('#neonate-next li').click(function()
        {
            var current_active_tab = $(this).children('a').attr('aria-controls');
            <?php if($results->BirthStatus == 'Inborn'): ?>
            if(current_active_tab == 'newbornform')
            <?php else: ?>
            if(current_active_tab == 'essform')
            <?php endif; ?>
            {
                $('.flow-dashboard-nicu-admission').parent().removeClass('hide');
                $('.flow-dashboard-next').parent().addClass('hide');
                $('input[name="formstatus"]').val(2);
            }
            else
            {
                $('.flow-dashboard-nicu-admission').parent().addClass('hide');
                $('.flow-dashboard-next').parent().removeClass('hide');
                $('input[name="formstatus"]').val(1);
            }
        });
    <?php endif; ?>
    $( "form" ).sisyphus({  customKeySuffix: "neonatal", locationBased: true });
    
    $('input[name="G_Value"]').change(function() {
    
        if ($(this).val() == 1) {
            $('input[name="P_Value"], input[name="L_Value"], input[name="A_Value"]').val(0);   
            $('.delivery').children('tbody').empty();
        }
    });   
    
    $('.sameasmailaddress').click(function () {
    
        if ($('.sameasmailaddress').is(':checked')) {
            $('#FatherAddress1').val($('#Address1').val());
            $('#FatherAddress2').val($('#Address2').val());
            $('#City').val($('#Address3').val());
            $('#Postcode').val($('#Address4').val());
            $('#Country').val($('#Address5').val())
        } else {
         $('#FatherAddress1').val("");
         $('#City').val("");
         $('#FatherAddress2').val("");
         $('#Country').val("");
         $('#Postcode').val("");
     }
    
    });
    
    $('#test').attr('readonly', true);
    
    $('.tab-main-menu').click(function() {
        if ($("#neonatalPerforma-form").valid() === false) {
            $("#neonatalPerforma-form").valid();
            return false;
        }
        submitForm();
        setNextmenu($(this).attr('aria-controls'));
        <?php if(\Session::get('admission_module') != 'NICU_ADMISSION'): ?>
        setPrintflag($(this).attr('aria-controls'));
        <?php else: ?>
        setPostnatalPrintflag($(this).attr('aria-controls'))
        <?php endif; ?>
    });
    
    
    
    $('.tab-sub-menu').on('click',function() {
        submitForm();
        setNextSubMenu($(this).attr('aria-controls'));
    });
    
    
    function setPrintflag(currentMenu) {
    
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
        $('.cancel-block').parent().addClass("col-md-6").removeClass("col-md-3");
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
    
    
    
    <?php if(Session::has('registration_start')): ?>
    
    $('.saveNext').click(function(e) {
    
        e.preventDefault();
        var next_tab = $('.nav-tabs > .active').next('li').find('a');
        if(next_tab.length>0){
            next_tab.trigger('click');
        }
        else{                
            $('#neonatalPerforma-form').submit();
        }
            // $('#print_flag').val('1'); 
            // var nextMenu = $('#neonate-next li[class="active"]').next('li').children('a').attr('aria-controls');
            // setNextmenu(nextMenu);
            // if(nextMenu =='newbornform') {
            //     setNextSubMenu('vitals');
            // }
            // $('#neonatalPerforma-form').submit();
    
        });
    <?php endif; ?>
    
    jQuery('#DischargeWeight').keyup(function () {
        this.value = this.value.replace(/[^0-9]/g,'');
    
        $( "#discharge_weight_in_kg" ).empty();
        var birth_weight = $('#DischargeWeight').val()/1000;
        $('#discharge_weight_in_kg').val(birth_weight);
    });
    
    // var transfer_status = $('select[name="transfer_status"]').val();
    // if (transfer_status == 'NICU') {
    //     $('#bed_id').attr('required', true);
    //     $('#room_id').attr('required', true);
    // }
    // var transfer_statuss = $('select[name=transfer_status]').val();
    // if (transfer_statuss == 'NICU') {
    //     // getRoomsByWard(transfer_status);
    //     $('#room_id').attr('required', true);
    //     $('#room_id').parent().parent().show();
    //     $('#bed_id').attr('required', true);
    //     $('#bed_id').parent().parent().show();
    // }
    // else
    // {
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
    $(document).on('click', '.neonatal_save_btn_create', function(e){
        if ($('#neonatalPerforma-form').valid() === true) {
            e.preventDefault();
            var print_flag = $(this).data('flag');
            $('#print_flag').val(print_flag);
            $('.neonatal_save_btn_create').prop('disabled', true);
            var current_clicked_element = $(this); 
            var current_clicked_html = $(this).html();
            $(this).html('<i class="fas fa-spinner fa-pulse"></i> Loading...');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: $('#neonatalPerforma-form input, #neonatalPerforma-form select, #neonatalPerforma-form textarea').serialize(),
                url: "<?php echo e(action('Registration\NeonatalController@update',$results->NeonatalId), false); ?>",
                success: function (response) {
                    if (print_flag == 1) {
                        Showalert('success', 'Neonatal proforma saved successfully');
                        $('.neonatal_save_btn_create').prop('disabled', false);
                        current_clicked_element.html('<i class="fa fa-floppy-o" aria-hidden="true"></i><span> Next</span>');
    
                        var next_tab = $('#neonate-next > .active').next('li').find('a');

                        if(next_tab.length>0){
                            next_tab.trigger('click');
                        }else{
                            var sub_next_tab = $('#newbornform .nav-tabs > .active').next('li').find('a');
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
                    else if(print_flag == 3)
                    {
                        Showalert('success', 'Neonatal proforma saved successfully');
                        $('.neonatal_save_btn_create').prop('disabled', false);
                        current_clicked_element.html(current_clicked_html);
                    }
                    else if(print_flag == 4)
                    {
                        Showalert('success', 'Neonatal proforma saved successfully');
                        window.location.href = response.create_nicu_url;
                    }
                    else if(print_flag == 5)
                    {
                        Showalert('success', 'Neonatal proforma saved successfully');
                        window.location.href = response.create_postnatal_url;
                    }
                    else if(print_flag == 2)
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
    function submitForm()
    {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            data: $('#neonatalPerforma-form input, #neonatalPerforma-form select, #neonatalPerforma-form textarea').serialize(),
            url: "<?php echo e(action('Registration\NeonatalController@update',$results->NeonatalId), false); ?>",
            success: function (response) {
    
            },
            error: function()
            {
    
            }
        });
    }
</script>
<?php echo $__env->make('registration.neonatal.neonatal_scripts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>