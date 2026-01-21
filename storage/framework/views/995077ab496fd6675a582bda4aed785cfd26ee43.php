<style type="text/css">
    .page-header .col-md-4 {
        margin:15px 0px;
    }
    .wizard-nav {
        background: #azure;
        margin: 0px 140px;
    }
    .center-window {
        text-align: center;
        margin: 30px 0px;
    }
    .question-option {
        margin: 0px 40px;
    }
    /*.flow-control-modal .modal-header {
    border-top-left-radius: 15px;
    border-top-right-radius: 15px;
    }
    */
    /*.flow-control-modal .modal-content {
    border-top-left-radius: 15px;
    border-top-right-radius: 15px;
    border-bottom-left-radius: 15px !important;
    border-bottom-right-radius: 15px !important;
    }*/
    /*
    .flow-control-modal .modal-footer {
    border-bottom-left-radius: 15px !important;
    border-bottom-right-radius: 15px;
    }
    */
    .flow-control-modal .modal-header .close {
    margin-top: -23px;
    font-size: 19px !important;
    margin-right: 23px;
    }
    .flow-control-modal h3{
    margin: 0px;
    font-weight: 500;
    }
    .finish-btn {
    margin: 10px;
    border-radius: 5px;
    }
    .daily-care-option {
    text-align: center;
    margin: 30px 50px;
    }
    .daily-discharge-option {
    text-align: center;
    margin: 30px 50px;
    }
    .daily-option {
    margin: 10px 50px;
    }
    .discharge-option {
    margin: 7px 5px;
    }
    .new-register {
    /* margin-left: 100px !important;*/
    }
    .flow-con > li > a {
        color: #000000 !important;
    }
    .flow-con {
        background-color:white;
    }
    .multiple-preg {
        padding: 10px 10px;
        text-align: center;
        margin: 10px 10px;
    }
    .multiple-preg-btn {
    margin: 12px 238px;
    padding: 10px;
    }
    .btnn{
    display: inline-block;
    text-decoration: none;
    color: #444;
    width: 120px;
    height: 120px;
    line-height: 20px;
    border-radius: 50%;
    text-align: center;
    vertical-align: middle;
    overflow: hidden;
    font-weight: bold;
    background-image: -webkit-linear-gradient(#fed6e3 0%, #ffaaaa 100%);
    background-image: linear-gradient(#fed6e3 0%, #ffaaaa 100%);
    text-shadow: 1px 1px 1px rgba(255, 255, 255, 0.66);
    box-shadow: 0px 0px 11px rgba(0, 0, 0, 0.28);
    border-color: transparent !important;
    font-size: 15px !important;
    }
    .btnn:active, .btnn:focus, .btnn:hover{
    box-shadow: inset 17px 16px 13px rgba(128, 128, 128, 0.32);
    background-image: -webkit-linear-gradient(#fed6e3 0%, #ffcfcf 100%);
    background-image: linear-gradient(#fed6e3 0%, #ffcfcf 100%);
    border-color: transparent !important;
    color: #444 !important;
    }
    .modal-divider
    {
    margin-top: 20px;
    }
    #flow-control-discharge .close
    {
    z-index: 1;
    opacity: 1;
    color: #fff;
    font-weight: 600;
    }
    .previous.disabled, .next.disabled
    {
    opacity: 0.6;
    }
    .previous a, .next a
    {
    position: relative;
    /*border: none !important;*/
    }
    #flow-control .previous a i, #flow-control .next a i, #discharge-flow .previous a i, #discharge-flow .next a i
    {
    width: 40px;
    height: 40px;
    line-height: 40px;
    background-color: #434468;
    color: #fff;
    border-radius: 50%;
    }
    #nurse-flow-model .close, #remove-record-nav .modal-header .close {
    margin-top: 0px
    }
    #nurse-flow-model .mtb-50 {
        margin: 50px 0px;
    }
    .daily-option:hover {
    text-decoration: none;
    }
    .multiple-admission-confirmation .modal-header {
    height: 50px;
    }
    .multiple-admission-confirmation .modal-title {
    color: #fff;
    text-align: center;
    margin: 0px;
    font-weight: 600;
    }
    .multiple-admission-confirmation .modal-footer {
    background-color: white;
    }
    .multiple-admission-confirmation .close {
    margin-top: -23px;
    font-size: 19px !important;
    color: white;
    }
    .modal-footer
    {
    border-top: none !important;
    }
    #discharge-flow .discharge-wizard .next {
        display: none;
    }
</style>

<div class="modal fade flow-control-modal" id="flow-model" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="text-center text-white">Welcome To Neopaed</h3>
                <button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true" style="color:white"><i class="fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <?php echo Form::open(['url'=>action('Flow\FlowController@flowControl'), 'method'=>'GET','id'=>'flow-control']); ?>

                <div  id="registration-flow">
                    <div class="">
                        <div class="">
                            <ul>
                                <li class="wizard-nav btn-shadow-special hide">
                                    <a href="#tab2" data-toggle="tab">Step 2</a>
                                </li>
                                <li class="wizard-nav btn-shadow-special hide">
                                    <a href="#tab3" data-toggle="tab">Step 3</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane" id="tab2">
                            <div class="col-md-12 center-window">
                                <button  value="NEW_REGISTRATION" class="btnn btn-primary step2 btn-shadow-special question-option" type="button">
                                New Registration
                                </button>
                                <button value="OLD_REGISTRATION"  class="btnn btn-primary step2 btn-shadow-special question-option" type="button">
                                Already Registered
                                </button>
                                <?php echo Form::hidden('registration',null,['id'=>'registration']); ?>

                            </div>
                        </div>
                        <div class="tab-pane" id="tab3">
                            <div class="col-md-12 center-window">
                                <div>
                                    <?php if(in_array('NICU_FORM', \Session::get('write_permission'))): ?>
                                    <button  value="NICU_ADMISSION" class="btnn btn-primary step3 btn-shadow-special question-option register_complete" type="button">
                                    NICU Admission
                                    </button>
                                    <?php endif; ?>
                                    <?php if(in_array('POST_FORM', \Session::get('write_permission'))): ?>
                                    <button value="POSTNATAL_ADMISSION"  class="btnn btn-primary step3 btn-shadow-special register_complete question-option" type="button">
                                    Postnatal Admission
                                    </button>
                                    <?php endif; ?>
                                    <?php if(in_array('PEDI_FORM', \Session::get('write_permission'))): ?>
                                    <button value="PEDIATRIC_ADMISSION"  class="btnn btn-primary step3 btn-shadow-special register_complete question-option" type="button">
                                    Pediatric Admission
                                    </button>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <?php if(in_array('NEONATAL_OP_BASIC', \Session::get('write_permission'))): ?>
                                    <?php if(in_array('OP_REG', \Session::get('write_permission'))): ?>
                                    <button value="OP_REGISTARATION"  class="btnn btn-primary step3 btn-shadow-special register_complete question-option" type="button">Neonatal OP
                                    </button>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                    <?php if(in_array('PEDIATRICS_OP_REG', \Session::get('write_permission'))): ?>
                                    <button value="PEDIATRIC_OP_REGISTARATION"  class="btnn btn-primary step3 btn-shadow-special register_complete question-option" type="button">
                                    Pediatric OP
                                    </button>
                                    <?php endif; ?>
                                    <?php if(in_array('NEURO_DEVELOPMENT', \Session::get('write_permission'))): ?>
                                    <button value="NEURO_OP_REGISTARATION"  class="btnn btn-primary step3 btn-shadow-special register_complete question-option" type="button">
                                    Neuro OP
                                    </button>
                                    <?php endif; ?>
                                </div>
                                <?php if(!in_array('NICU_FORM', \Session::get('write_permission')) && !in_array('POST_FORM', \Session::get('write_permission')) && !in_array('OP_REG', \Session::get('write_permission')) && !in_array('PEDI_FORM', \Session::get('write_permission')) && !in_array('PEDIATRICS_OP_REG', \Session::get('write_permission')) && !in_array('NEURO_DEVELOPMENT', \Session::get('write_permission'))): ?>
                                <h1>Permission Denied</h1>
                                <?php endif; ?>
                                <?php echo Form::hidden('admission',null,['id'=>'admission']); ?>

                            </div>
                            <!-- <div class="col-md-12">
                                <button class="btn finish-btn btn-success pull-right" type="button">
                                    Start >> 
                                </button>
                                </div> -->
                        </div>
                        <ul class="pager wizard">
                            <li class="previous">
                                <a href="javascript:void(0);"><i class="fa fa-angle-double-left"></i></a>
                            </li>
                            <li class="next ">
                                <a href="javascript:void(0);"><i class="fa fa-angle-double-right"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php echo Form::close(); ?>

            </div>
            <div class="modal-footer" style="background-color: white;">
            </div>
        </div>
    </div>
</div>
<div class="modal fade flow-control-modal" id="daily-care-nav" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <h3 class="text-center text-white">Welcome To Neopaed</h3>
                </h5>
                <button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true" style="color:white"><i class="fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <?php echo Form::open(['url'=>action('Flow\FlowController@flowControl'), 'method'=>'GET','id'=>'flow-control-dailycare']); ?>

                <?php echo Form::hidden('registration',null,['id'=>'daily-care-registration']); ?>

                <?php echo Form::hidden('admission',null,['id'=>'daily-care-admission']); ?>

                <div class="daily-care-option">
                    <h3>Do You Want Add The Daily Sheet In ?</h3>
                    <div class="modal-divider">
                        <?php if(in_array('NICU_DAY',\Session::get('write_permission'))): ?>
                        <button  type="button" value="NICU_DAILY_CARE" class="btnn btn-primary daily-care-sheet daily-option btn-shadow-special"> 
                        NICU 
                        </button>
                        <?php endif; ?>
                        <?php if(in_array('POST_DAY',\Session::get('write_permission'))): ?>
                        <button  type="button" value="POSTNATAL_DAILY_CARE" class="btnn btn-primary daily-care-sheet daily-option btn-shadow-special"> 
                        Postnatal
                        </button>
                        <?php endif; ?>
                    </div>
                </div>
                <?php echo Form::close();; ?>

            </div>
            <div class="modal-footer" style="background-color: white;">
            </div>
        </div>
    </div>
</div>
<div class="modal fade flow-control-modal" id="problem-based-entry-nav" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <h3 class="text-center text-white">Welcome To Neopaed</h3>
                </h5>
                <button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true" style="color:white"><i class="fa fa-times"></i></button>  
            </div>
            <div class="modal-body">
                <div class="daily-care-option">
                    <h3>Do You Want Add The Problems In ?</h3>
                    <div class="modal-divider">
                        <?php if(in_array('NICU_PROBLEM_DAY',\Session::get('write_permission'))): ?>
                        <a href="<?php echo e(url('daycare-admission/create/problem-based'), false); ?>" class="btnn btn-primary daily-option btn-shadow-special lh-120"> 
                        NICU </a>
                        <?php endif; ?> 
                        <?php if(in_array('POST_PROBLEM_SYSTEM',\Session::get('write_permission'))): ?>
                        <a href="<?php echo e(url('problem-systems-postnatal'), false); ?>" class="btnn btn-primary daily-option btn-shadow-special lh-120"> 
                        Postnatal</a>
                        <?php endif; ?> 
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background-color: white;">
            </div>
        </div>
    </div>
</div>
<div class="hidden">
    <?php echo Form::select('nicu_discharge_baby_id',[''=>'N/A']+SiteHelpers::getNicuBabyies(),null); ?>

    <?php echo Form::select('postanatal_discharge_baby_id',[''=>'N/A']+SiteHelpers::getPostnatalBabyies(),null); ?>

</div>
<div class="modal flow-control-modal fade" id="discharge-details-nav" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <h5 class="modal-title">
                    </h5> -->
                <h3 class="text-center text-white">Discharge / Transfer</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="fa fa-times"></i>
                </button> 
            </div>
            <div class="modal-body">
                <?php echo Form::hidden('baby_id',null); ?>

                <?php echo Form::hidden('admission_id',null); ?>

                <?php echo Form::hidden('ward_id',null); ?>

                <?php echo Form::hidden('ward_name',null); ?>

                <?php echo Form::hidden('room_id',null); ?>

                <?php echo Form::hidden('room_name',null); ?>

                <?php echo Form::hidden('bed_id',null); ?>

                <?php echo Form::hidden('bed_name',null); ?>

                <?php echo Form::hidden('bed_mrn',null); ?>

                <?php echo Form::hidden('bed_ip',null); ?>

                <div id="discharge-flow">
                    <div class="">
                        <div class="">
                            <ul>
                                <li class="wizard-nav btn-shadow-special hide">
                                    <a href="#discharge-step1" data-toggle="tab">Step 2</a>
                                </li>
                                <li class="wizard-nav btn-shadow-special hide">
                                    <a href="#discharge-step2" data-toggle="tab">Step 3</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane" id="discharge-step1">
                            <div class="daily-discharge-option">
                                <h3>Do You Want <span class="discharge-text">Discharge/</span><span class="transfer-text">Transfer</span> The Baby From ?</h3>
                                <div class="modal-divider">
                                    <?php if(in_array('NICU_DISCHARGE', \Session::get('write_permission'))): ?>
                                    <button  value="NICU_DISCHARGE" class="btnn btn-primary btn-shadow-special discharge-option discharge-module" type="button">
                                        NICU Discharge 
                                    </button>
                                    <?php endif; ?>
                                    <?php if(in_array('POST_DISCHARGE', \Session::get('write_permission'))): ?>
                                    <button value="POSTNATAL_DISCHARGE" class="btnn btn-primary discharge-option discharge-module btn-shadow-special" type="button"> 
                                        Postnatal Discharge
                                    </button>
                                    <?php endif; ?> 
                                    <?php if(in_array('NICU_DISCHARGE', \Session::get('write_permission'))): ?>
                                    <button value="NICU_TRANSFER_DISCHARGE" class="btnn btn-primary discharge-option discharge-module btn-shadow-special" type="button"> 
                                        Nicu To Postnatal Transfer 
                                    </button>
                                    <?php endif; ?>
                                    <?php if(in_array('POST_DISCHARGE', \Session::get('write_permission'))): ?>
                                    <button value="POSTNATAL_TRANSFER_DISCHARGE" class="btnn btn-primary discharge-option discharge-module btn-shadow-special" type="button"> 
                                        Postnatal To Nicu Transfer 
                                    </button>
                                    <?php endif; ?>
                                    <?php if(in_array('NICU_DISCHARGE', \Session::get('write_permission'))): ?>
                                    <button value="NICU_BED_TRANSFER" class="btnn btn-primary discharge-option discharge-module btn-shadow-special" type="button" id="transfer-patient"> 
                                        Bed Transfer
                                    </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="discharge-step2">
                                <div class="col-md-12" id="default-option">
                            <?php echo Form::open(['url'=>action('Flow\FlowController@flowControl'), 'method'=>'GET','id'=>'flow-control-discharge', 'style' => 'margin:0px;']); ?>

                                <?php echo Form::hidden('registration',null,['id'=>'discharge-registration']); ?>

                                <?php echo Form::hidden('admission',null,['id'=>'discharge-admission']); ?>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php echo Form::label('baby_id','Baby\'s Name:'); ?>

                                            <?php echo Form::select('baby_id',['0'=>'N/A']+SiteHelpers::getNicuBabyies(),null,['class'=>'full-width-must', 'id'=>'discharge-baby-nicu']); ?>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php echo Form::label('admission_id','Admission:'); ?>

                                            <?php echo Form::select('admission_id',[''=>'N/A'],null,['class'=>'form-control','id'=>'admission_id']); ?>


                                        </div>
                                        <div class="form-group row">
                                            <div class="nicu_bed_details col-md-7" style="display:none;">
                                                <?php echo Form::label('nicu_bed','NICU Bed No:'); ?>

                                                <select name="nicu_bed" class="form-control" id="nicu_bed_id">
                                                </select>
                                            </div>
                                            <button type="button" class="btn btn-primary discharge-baby btn-shadow-special pull-right col-md-3" style="margin-bottom:20px;">Start</button>
                                        </div>
                                    </div>
                            <?php echo Form::close();; ?>

                                </div>
                            <div class="col-md-12" id="transfer-option">
                                <?php echo Form::open(['url'=>action('Ward\BabyWardController@getupdatebedlog'), 'method'=>'POST','id'=>'bed-transfer']); ?>

                                    <div class="col-md-12 plr-30 pb-25">
                                        <div class="form-group text-center">
                                            <span class="badge badge-success" id="current-ward-name-span"></span>&ensp;
                                            <span class="badge badge-danger" id="current-room-name-span"></span>&ensp;
                                            <span class="badge badge-primary" id="current-bed-name-span"></span>&ensp;
                                        </div>
                                    </div>
                                    <div class="col-md-offset-3 col-md-6 plr-30">
                                        <div class="form-group row">
                                            <?php echo Form::label('bed_no','Bed No:'); ?>

                                            <select name="bed_no" class="form-control bed-name" id="bed_no">
                                            </select>
                                        </div>
                                    </div>
                                    <input type="hidden" name="wardId">
                                    <input type="hidden" name="roomId">
                                    <input type="hidden" name="bedId">
                                    <input type="hidden" name="oldBedId">
                                    <input type="hidden" name="babyId">
                                    <input type="hidden" name="admissionId">
                                    <?php echo Form::hidden('bed_mrno',null); ?>

                                    <?php echo Form::hidden('bed_ipnumber',null); ?>

                                    <?php echo Form::hidden('tbed_name',null); ?>

                                    <?php echo Form::hidden('hms_ward_id',null); ?>

                                    <?php echo Form::hidden('hms_room_id',null); ?>

                                    <?php echo Form::hidden('hms_bed_id',null); ?>

                                    <div class="modal-footer bg-white">
                                        <div class="col-md-12 plr-0">
                                            <button type="button" class="btn btn-primary btn-shadow-special baby-tranfer pull-right"> Apply Transfer </button>
                                        </div>
                                    </div>
                                    <?php echo Form::close(); ?>

                            </div>
                        </div>
                        <ul class="pager wizard discharge-wizard">
                            <li class="previous">
                                <a href="javascript:void(0);"><i class="fa fa-angle-double-left"></i></a>
                            </li>
                            <li class="next">
                                <a href="javascript:void(0);"><i class="fa fa-angle-double-right"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background-color: white;">
            </div>
        </div>
    </div>
</div>
<div class="modal flow-control-modal fade" id="multiple-preg-admission" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <h3 class="text-center text-white">Multiple Admission</h3>
                </h5>
                <button type="button" class="close modal-close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>  
            </div>
            <div class="modal-body">
                <div class="col-md-offset-2 col-md-8 text-center mt-15">
                    <h3> Where you want admit the next baby ? </h3>
                </div>
                <div class="col-md-12 center-window">
                    <button type="button" value="NICU_MULTIPLE_PREGANANCY" class="btnn btn-primary multiple-preg btn-shadow-special">Nicu Admission</button>
                    <button type="button" value="POSTNATAL_MULTIPLE_PREGANANCY"  class="btnn btn-primary  multiple-preg btn-shadow-special">Postnatal Admission</button>
                </div>
            </div>
            <div class="modal-footer" style="background-color: white; border-top: 0px solid #e5e5e5;">
            </div>
        </div>
    </div>
</div>
<div class="modal flow-control-modal fade" id="nurse-hour-wise-sheet-modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: white;">
                <h5 class="modal-title">
                    <h3>Nurse Sheet Creation </h3>
                </h5>
                <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>  
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php echo Form::label('baby_id','Baby\'s Name:'); ?>

                            <?php echo Form::select('baby_id',[''=>'N/A']+SiteHelpers::getNicuBabyies(),null,['class'=>'form-control', 'id'=>'nurse-sheet-baby']); ?>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php echo Form::label('admission_id','Admission:'); ?>

                            <?php echo Form::select('admission_id',[''=>'N/A'],null,['class'=>'form-control','id'=>'nurse-sheet-admission-id']); ?>

                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-primary btn-shadow-special pull-right" style="margin-bottom:20px;">Start</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background-color: white; border-top: 0px solid #e5e5e5;">
            </div>
        </div>
    </div>
</div>
<div class="modal fade flow-control-modal" id="nurse-flow-model" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true" style="color:white"><i class="fa fa-times"></i></button>
                <h5 class="modal-title">
                    <h3 class="text-center text-white">Welcome To Neopaed Nurse</h3>
                </h5>
            </div>
            <div class="modal-body">
                <div class="row mtb-50">
                    <?php echo Form::open(['url'=>action('Flow\FlowController@nurseFlowcontrol'), 'method'=>'GET','id'=>'nurse-registration']); ?>

                    <div class="col-md-12 center-window">
                        <button  value="NEW_NURSE_REGISTRATION" class="btnn btn-primary nurse-step-1 btn-shadow-special question-option" type="button">
                        New Registration
                        </button>
                        <button value="OLD_NURSE_REGISTRATION"  class="btnn btn-primary nurse-step-1 btn-shadow-special question-option" type="button">
                        Already Registered
                        </button>
                        <?php echo Form::hidden('nurse_registration',null,['id'=>'nurse_registration']); ?>

                        <?php echo Form::hidden('nurse_admission',null,['id'=>'nurse_admission']); ?>

                    </div>
                    <!--  <div class="col-md-12">
                        <button type="button" class="btn btn-shadow-special start-registration pull-right mb-10 mr-10"> Start </button>
                        </div> -->
                    <?php echo Form::close(); ?>

                </div>
            </div>
            <!-- <div class="modal-footer color-white">
            </div>  -->
        </div>
    </div>
</div>

<div class="modal flow-control-modal fade" id="remove-record-nav" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close modal-close" data-dismiss="modal" aria-label="close" style="margin-right: 0px !important">
                <span aria-hidden="true">&times;</span>                    
                </button>
                <h5 class="modal-title">
                    <h3 class="text-center text-white">Remove Record</h3>
                </h5>
            </div>
            <div class="modal-body row mt-20">
                <?php echo e(Form::open(['url' => action('Search\RemoveBabyRecordController@index', 0), 'method'=>'get']), false); ?>

                <div class="record col-md-12">
                    <div class="form-group col-md-12">
                        <?php echo e(Form::label('baby_name','Baby\'s Name:'), false); ?>

                        <?php $baby_list = isset($active_baby_list) ? $active_baby_list : ['N/A'=>'N/A']; ?>
                        <?php echo e(Form::select('baby_name',[0=>'- - Select - -']+$baby_list, null, ['class'=>'select2-select-00 input-fields-shadow full-width-fix']), false); ?>

                    </div>
                    <div class="text-right col-md-12">
                        <button type="submit" class="btn btn-primary btn-shadow-special pull-right delete-record mb-15">Start</button>
                    </div>
                </div>
                <?php echo e(Form::close(), false); ?>

            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>


<!-- <div class="modal fade flow-control-modal" id="transfer-patient-model" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="text-center text-white">Transfer</h3>
                <button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true" style="color:white"><i class="fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php echo Form::open(['url'=>action('Ward\BabyWardController@getupdatebedlog'), 'method'=>'POST','id'=>'bed-transfer']); ?>

                    <div class="col-md-12 plr-30 pt-25">
                        <div class="form-group text-center">
                            <span class="badge badge-success" id="current-ward-name-span"></span>&ensp;
                            <span class="badge badge-danger" id="current-room-name-span"></span>&ensp;
                            <span class="badge badge-primary" id="current-bed-name-span"></span>&ensp;
                        </div>
                    </div>
                    <div class="col-md-6 plr-30">
                        <div class="form-group">
                            Room:
                            <select class="form-control room-name" id="room_id" name="roomId">
                                <option value="" selected="selected">-- Select Room for transfer --</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 plr-30">
                        <div class="form-group">
                            Bed:
                            <select class="form-control bed-name" id="bed_id" name="bedId">
                                <option value="" selected="selected">-- Select Bed for transfer --</option>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="wardId">
                    <input type="hidden" name="oldBedId">
                    <input type="hidden" name="babyId">
                    <input type="hidden" name="admissionId">
                    <?php echo Form::close(); ?>

                </div>
            </div>
            <div class="modal-footer bg-white">
                <div class="col-md-12 plr-0">
                    <button type="button" class="btn btn-primary btn-shadow-special baby-tranfer pull-right"> Apply Transfer </button>
                </div>
            </div>
        </div>
    </div>
</div> -->
<script type="text/javascript">
    $(document).ready(function() {
    
       $('#nurse-hour-wise-sheet').click(function() {
    
         $('#nurse-hour-wise-sheet-modal').modal({backdrop: 'static', show: true });
    
       });
    
       function nicuNursesheet(babyId) {
    
            $.ajax({
                    type:'GET',
                    url:'<?php echo e(url("nicu-admission-discharge"), false); ?>'+'/'+babyId,
                    beforeSend:function() {
    
                    },
                    success:function(responseText) {
                      var option ='';
                      $.each(responseText.results, function(index, value) {
    
                        option +='<option value="'+index+'">'+value+'</option>';
    
                      });
                      $('#nurse-sheet-admission-id').html(option);
                       
                    },
                    complete:function(responseText) {
                    
    
                    },
                    error:function(responseText) {
    
                      if (typeof responseText.responseJSON.message != 'undefined') {
                        var message = responseText.responseJSON.message;
                        Showalert('error',message);
                      }
    
                    }
    
              });
    
        }
    
    
        function nicuDischarge(babyId) {
    
            $.ajax({
                    type:'GET',
                    url:'<?php echo e(url("nicu-admission-discharge"), false); ?>'+'/'+babyId,
                    beforeSend:function() {
    
                    },
                    success:function(responseText) {
                      var option ='';
                      $.each(responseText.results, function(index, value) {
    
                        option +='<option value="'+index+'">'+value+'</option>';
    
                      });
                      $('#admission_id').html(option);
                       
                    },
                    complete:function(responseText) {
                    
    
                    },
                    error:function(responseText) {
    
                      if (typeof responseText.responseJSON.message != 'undefined') {
                        var message = responseText.responseJSON.message;
                        Showalert('error',message);
                      }
    
                    }
    
              });
    
        }
    
        function postnatalDischarge(babyId) {
    
    
            $.ajax({
                    type:'GET',
                    url:'<?php echo e(url("postanatal-admission-discharge"), false); ?>'+'/'+babyId,
                    beforeSend:function() {
    
                    },
                    success:function(responseText) {
                      var option ='';
                      $.each(responseText.results, function(index, value) {
    
                        option +='<option value="'+index+'">'+value+'</option>';
    
                      });
                      $('#admission_id').html(option);
                       
                    },
                    complete:function(responseText) {
                    
    
                    },
                    error:function(responseText) {
    
                      if (typeof responseText.responseJSON.message != 'undefined') {
                        var message = responseText.responseJSON.message;
                        Showalert('error',message);
                      }
    
                    }
    
              });
    
        }
    
    
        $('#nurse-sheet-baby').change(function() {
             nicuNursesheet($(this).val());
        });
    
    
    
        $('#discharge-baby-nicu').change(function() {
    
            if ($('#discharge-admission').val() == 'NICU_DISCHARGE' || $('#discharge-admission').val() == 'NICU_TRANSFER_DISCHARGE' ) {
               
               nicuDischarge($(this).val());
         
            } else if($('#discharge-admission').val() == 'POSTNATAL_DISCHARGE' || $('#discharge-admission').val() == 'POSTNATAL_TRANSFER_DISCHARGE' ) {  
            
               postnatalDischarge($(this).val());
    
            } 
        });
    
       
    
        $('.discharge-module').click(function() {
             $('#discharge-admission').val($(this).val());
             $('#discharge-registration').val('OLD_REGISTRATION');
             if ($(this).val() == 'NICU_DISCHARGE' || $(this).val() == 'NICU_TRANSFER_DISCHARGE') {
                 var babyList = $('select[name="nicu_discharge_baby_id"]').html();
                 $('#discharge-baby-nicu').html(babyList);
             } else if($(this).val() == 'POSTNATAL_DISCHARGE' || $(this).val() == 'POSTNATAL_TRANSFER_DISCHARGE') {
    
                var babyList = $('select[name="postanatal_discharge_baby_id"]').html();
                 $('#discharge-baby-nicu').html(babyList);
             }
            if ($(this).val() == 'POSTNATAL_TRANSFER_DISCHARGE') {
                $('.nicu_bed_details').show();
               bedList('nicu_bed_id');
            } else {
                $('.nicu_bed_details').hide();
            }
            if ($(this).val() == 'NICU_BED_TRANSFER') {
                $('#transfer-option').show().trigger('click');
                $('#default-option').hide();
               bedList('bed_no');
            } else {
                $('#transfer-option').hide();
            }
             $('.discharge-wizard li.next').trigger('click');
             $('.discharge-module').removeClass('btn-success');
             $(this).removeClass('btn-primary').addClass('btn-success');         
        });
    
        $('.discharge-baby').click(function() {
    
            if ($('#discharge-admission').val() == 'NICU_DISCHARGE' || $('#discharge-admission').val() == 'NICU_TRANSFER_DISCHARGE') {
              if ($('#discharge-baby-nicu').val() !='' && $('#admission_id').val()!='') {
                  $('#flow-control-discharge').submit();
              }
            } else if($('#discharge-admission').val() == 'POSTNATAL_DISCHARGE' || $('#discharge-admission').val() == 'POSTNATAL_TRANSFER_DISCHARGE') {
              if ($('#discharge-baby-nicu').val() !='' && $('#admission_id').val()!='') {
                  $('#flow-control-discharge').submit();
              }
            }
            
        });
    
        $('#new-patinent,#new-patinent-home').click(function() {
    
           $('#flow-model').modal({backdrop: 'static', show: true });
           $('#tab2').addClass('active');
           $('#tab3').removeClass('active');
           $('.wizard li.previous').trigger('click');
    
    
        });
    
        $('#daily-care,#daily-care-home').click(function() {
          
            $('#daily-care-nav').modal({backdrop: 'static', show: true });
        });
    
        $('#problem-based-entry,#problem-sheet-home').click(function() {
    
            $('#problem-based-entry-nav').modal({backdrop: 'static', show: true });
        });
        
        $(document).on('click','#discharge-details,#discharge-home', function() {
    
            if ($(this).hasClass('ward')) {
                $('.discharge-option:nth-child(2)').hide();
                $('.discharge-option:nth-child(4)').hide();

                var babyId = $(this).data('baby-id');
                var admissionId = $(this).data('admission-id');
                var wardId = $(this).data('add-ward-id');
                var wardName = $(this).data('add-ward-name');
                var roomId = $(this).data('add-room-id');
                var roomName = $(this).data('add-room-name');
                var bedId = $(this).data('add-bed-id');
                var bedName = $(this).data('add-bed-name');
                var mrn = $(this).data('baby-mrn');
                var ip = $(this).data('ip-number');

                $('input[name="baby_id"]').val(babyId);
                $('input[name="admission_id"]').val(admissionId);

                $('input[name="ward_id"]').val(wardId);
                $('input[name="ward_name"]').val(wardName);
                $('input[name="room_id"]').val(roomId);
                $('input[name="room_name"]').val(roomName);
                $('input[name="bed_id"]').val(bedId);
                $('input[name="bed_name"]').val(bedName);
                $('input[name="bed_mrn"]').val(mrn);
                $('input[name="bed_ip"]').val(ip);

                if ($(this).attr('data-neonatal-found') == 'true') {
                    $('.discharge-option:nth-child(1)').hide();
                    $('.discharge-option:nth-child(3)').hide();
                    $('.discharge-text').hide();
                }

            } else {
                $('.discharge-option:nth-child(5)').hide();                
            }
            $('#discharge-flow .discharge-wizard .previous').trigger('click');
            $('#discharge-details-nav').modal({backdrop: 'static', show: true });
    
        });

        $('#discharge-details-nav').on('hidden.bs.modal', function () {
            $('.discharge-option').show();
            $('#default-option').show();
            $('#transfer-option').show();
        });

        $('.discharge-wizard .previous').on('click', function () {
            $('#default-option').show();
            $('#transfer-option').show();
        });

        $('#nurse-by-registration').click(function() {
            $('#nurse-flow-model').modal({backdrop: 'static', show: true });
        });
    
        $('.daily-care-sheet').click(function() {
            $('#daily-care-registration').val('OLD_REGISTRATION');
            $('#daily-care-admission').val($(this).val());
            $('#flow-control-dailycare').submit();
        });
    
        $('#remove-record').click(function() {
            $('#remove-record-nav').modal({backdrop: 'static', show: true });
        });
    
        // $('.step1').click(function() {
    
        //     $('.step1').removeClass('btn-success').addClass('btn-primary');
    
        //     $('#patient').val($(this).val());
    
        //     $(this).removeClass('btn-primary').addClass('btn-success');
    
        //        if ($('#patient').val() == 1) {
    
        //         $('.wizard li.next').trigger('click');
    
        //        } else if($('#patient').val() == 2) {
    
        //           $('.step1').removeClass('btn-success').addClass('btn-primary');
        //           $('#flow-model').modal('hide');
    
        //        } 
    
        // }); 
    
        $('.step2').click(function() {
    
            $('.step2').removeClass('btn-success').addClass('btn-primary');
            $('#registration').val($(this).val());
            $(this).removeClass('btn-primary').addClass('btn-success');
    
            if ($('#registration').val() == 'NEW_REGISTRATION') {
    
                 $('.wizard li.next').trigger('click');
            } else {
                 $('.wizard li.next').trigger('click');
            } 
        });
    
          $('.step3').click( function() {
    
               $('.step3').removeClass('btn-success').addClass('btn-primary');
               $('#admission').val($(this).val());
               $(this).removeClass('btn-primary').addClass('btn-success');
               $('.finish-btn').addClass('btn-success');
    
              
          });
    
    
          $('.register_complete').click(function() {
              $('#admission').val($(this).val());
              $('#flow-control').submit();
          });
          $('.finish-btn').click(function() {
             if($('#admission').val() == '') {
                alert('choose admission');
             } else {
                 $('#flow-control').submit();
             }
    
          });
    
    
          $('#registration-flow').bootstrapWizard({
           
            onNext : function(tab, navigation, index) {
              
              if(index == 1 && $('#patient').val() == '') {
                   return false;
              }
    
              if(index == 2 && $('#registration').val() == '') {
                   return false;
              }
    
            }
         
          });
    
          $('#discharge-flow').bootstrapWizard({});
    
    
        //  $('.nurse-step-1').click(function() {
    
        //      // $('.nurse-step-1').removeClass('btn-success').addClass('btn-primary');
        //      $('#nurse_registration').val($(this).val());
        //      $('#nurse_admission').val('NURSE_NICU_ADMISSION');
        //      $(this).removeClass('btn-primary').addClass('btn-success');
        //      // $('.start-registration').addClass('btn-success');
        // });
        // $('.next').addClass('disabled');
        // $('.next a').attr('disabled', 'disabled');
    
        $('.nurse-step-1').click(function() {
            if ($(this).val() == "NEW_NURSE_REGISTRATION"); {
                $.cookie("babyMrn", '');
            }
            $('#nurse_registration').val($(this).val());
            $('#nurse_admission').val('NURSE_NICU_ADMISSION');
            $('#nurse-registration').submit();
        });
    
        $('.delete-record').click(function(e) {
                e.preventDefault();
                if ($('#baby_name').val() != 'N/A') {
                    var babyId = $('select[name="baby_name"]').val();
                    var searchUrl = '<?php echo e(url("search-baby-reports"), false); ?>'+'/'+babyId;
                    window.location.href = searchUrl;
                }
                else {
                    alert('Please select the baby!');
                }
            });
    
        $('#discharge-baby-nicu').select2();
        
    });        
</script>
