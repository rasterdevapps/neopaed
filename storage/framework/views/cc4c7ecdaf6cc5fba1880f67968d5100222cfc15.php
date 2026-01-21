<style type="text/css">
    .eligibility .table-bordered > tbody > tr > td {
        text-align: left !important;
        vertical-align: middle;
        padding: 0px 8px;
    }
    .eligibility .bullets {
        padding-right: 15px;
    }
    .eligibility .sub-infants .bullets {
        padding-left: 50px;
        padding-right: 15px;
    }
    .eligibility .table-bordered tbody:first-child tr > td.text-center {
        text-align: center !important;
    }
    .eligibility input[type="checkbox"] {
        width: 20px;
        height: 20px;
    }
    .eligibility textarea {
        height: 34px;
    }
    .eligibility textarea {
        border: none;
        box-shadow: unset;
        background-color: unset !important;
        margin-bottom: unset;
        border-radius: 0px;
        resize: none;
        border-bottom: 1px solid #1e1e2d;
    }
    .eligibility textarea:focus {
        border: none;
        outline: none;
        box-shadow: unset;
        border-bottom: 1px solid #1e1e2d;
    }
    .eligibility .sub-infants .display-flex {
        align-items: center;
    }
    .eligibility p {
        margin: 0px;
    }
</style>
<?php
    $birth_weight_gestation_is_lesser = (isset($birth_weight_gestation_is_lesser) && $birth_weight_gestation_is_lesser) ? true : false;
    $birth_weight_gestation_is_greater = (isset($birth_weight_gestation_is_greater) && $birth_weight_gestation_is_greater) ? true : false;
    $intrauterine_growth = (isset($intrauterine_growth) && $intrauterine_growth) ? true : false;
    $meningitis = (isset($meningitis) && $meningitis) ? true : false;
    $mechanical_ventilation = (isset($mechanical_ventilation) && $mechanical_ventilation) ? true : false;
    $encephalopathy_stage_2_more = (isset($encephalopathy_stage_2_more) && $encephalopathy_stage_2_more) ? true : false;
    $major_malformation = (isset($major_malformation) && $major_malformation) ? true : false;
    $inborn_errors = (isset($inborn_errors) && $inborn_errors) ? true : false;
    $symptomatic_hypoglycemia = (isset($symptomatic_hypoglycemia) && $symptomatic_hypoglycemia) ? true : false;
    $symptomatic_polycythemia = (isset($symptomatic_polycythemia) && $symptomatic_polycythemia) ? true : false;
    $retrovirus_positive_mother = (isset($retrovirus_positive_mother) && $retrovirus_positive_mother) ? true : false;
    $hyperbilirubinemia_transfusion_rh = (isset($hyperbilirubinemia_transfusion_rh) && $hyperbilirubinemia_transfusion_rh) ? true : false;
    $abnormal_neuro_exam = (isset($abnormal_neuro_exam) && $abnormal_neuro_exam) ? true : false;
    $major_morbidities = (isset($major_morbidities) && $major_morbidities) ? true : false;
    $other_specify_is_present = (isset($other_specify_is_present) && $other_specify_is_present) ? true : false;
    $general_checkup = (isset($general_checkup) && $general_checkup) ? true : false;
?>
<div class="eligibility">
    <h5 class="text-center"><strong>Eligibility for enrolment in HRC (Tick as appropriate)</strong></h5>
    <div class="overflow-auto">
        <table class="table table-bordered">
            <tbody>
                <tr class="<?php echo e(@$birth_weight_gestation_is_lesser ? 'bg-warning' : '', false); ?>">
                    <td class="text-center">
                        <?php echo e(Form::checkbox('birth_weight_gestation_is_lesser', null, $birth_weight_gestation_is_lesser, ['id'=>'birth_weight_gestation_is_lesser']), false); ?>

                    </td>
                    <td>
                        <div class="display-flex">
                            <span class="bullets">1.</span>
                            <p>Birth weight <1500 grams</p>
                        </div>
                        <div class="display-flex">
                            <span class="bullets">2.</span>
                            <p>Gestation <32weeks</p>
                        </div>
                    </td>
                </tr>
                <tr class="<?php echo e(@$birth_weight_gestation_is_greater ? 'bg-warning' : '', false); ?>">
                    <td class="text-center">
                        <?php echo e(Form::checkbox('birth_weight_gestation_is_greater', null, $birth_weight_gestation_is_greater, ['id'=>'birth_weight_gestation_is_greater']), false); ?>

                    </td>
                    <td>
                        <div class="display-flex">
                            <span class="bullets">3.</span>
                            <p>Infants with BW &#x2265; 1500 gm OR gestation &#x2265; 32 week <strong>AND</strong></p>
                        </div>
                    </td>
                </tr>
                <tr class="sub-infants <?php echo e(@$intrauterine_growth ? 'bg-warning' : '', false); ?>">
                    <td class="text-center">
                        <?php echo e(Form::checkbox('intrauterine_growth', null, $intrauterine_growth, ['id'=>'intrauterine_growth']), false); ?>

                    </td>
                    <td>
                        <div class="display-flex">
                            <span class="bullets">a.</span>
                            <p>Intrauterine growth centile <3<sup>rd</sup> centile</p>
                        </div>
                    </td>
                </tr>
                <tr class="sub-infants <?php echo e(@$meningitis ? 'bg-warning' : '', false); ?>">
                    <td class="text-center">
                        <?php echo e(Form::checkbox('meningitis', null, $meningitis, ['id'=>'meningitis']), false); ?>                    
                    </td>
                    <td>
                        <div class="display-flex">                    
                            <span class="bullets">b.</span>
                            <p>Meningitis</p>
                        </div>
                    </td>
                </tr>
                <tr class="sub-infants <?php echo e(@$mechanical_ventilation ? 'bg-warning' : '', false); ?>">
                    <td class="text-center">
                        <?php echo e(Form::checkbox('mechanical_ventilation', null, $mechanical_ventilation, ['id'=>'mechanical_ventilation']), false); ?>                    
                    </td>
                    <td>
                        <div class="display-flex">
                            <span class="bullets">c.</span>
                            <p>Received mechanical ventilation for 48 hours or more</p>
                        </div>
                    </td>
                </tr>
                <tr class="sub-infants <?php echo e(@$encephalopathy_stage_2_more ? 'bg-warning' : '', false); ?>">
                    <td class="text-center">
                        <?php echo e(Form::checkbox('encephalopathy_stage_2_more', null, $encephalopathy_stage_2_more, ['id'=>'encephalopathy_stage_2_more']), false); ?>                    
                    </td>
                    <td>
                        <div class="display-flex">
                            <span class="bullets">d.</span>
                            <p>Hypoxic ischemic encephalopathy stage 2 or higher</p>
                        </div>
                    </td>
                </tr>
                <tr class="sub-infants <?php echo e(@$major_malformation ? 'bg-warning' : '', false); ?>">
                    <td class="text-center">
                        <?php echo e(Form::checkbox('major_malformation', null, $major_malformation, ['id'=>'major_malformation']), false); ?>                    
                    </td>
                    <td>
                        <div class="display-flex">
                            <span class="bullets">e.</span>
                            <p>Major malformation</p>
                        </div>
                    </td>
                </tr>
                <tr class="sub-infants <?php echo e(@$inborn_errors ? 'bg-warning' : '', false); ?>">
                    <td class="text-center">
                        <?php echo e(Form::checkbox('inborn_errors', null, $inborn_errors, ['id'=>'inborn_errors']), false); ?>                    
                    </td>
                    <td>
                        <div class="display-flex">
                            <span class="bullets">f.</span>
                            <p>Inborn error of metabolism/chromosomal or genetic disorders/intrauterine infections</p>
                        </div>
                    </td>
                </tr>
                <tr class="sub-infants <?php echo e(@$symptomatic_hypoglycemia ? 'bg-warning' : '', false); ?>">
                    <td class="text-center">
                        <?php echo e(Form::checkbox('symptomatic_hypoglycemia', null, $symptomatic_hypoglycemia, ['id'=>'symptomatic_hypoglycemia']), false); ?>                    
                    </td>
                    <td>
                        <div class="display-flex">
                            <span class="bullets">g.</span>
                            <p>Symptomatic hypoglycemia</p>
                        </div>
                    </td>
                </tr>
                <tr class="sub-infants <?php echo e(@$symptomatic_polycythemia ? 'bg-warning' : '', false); ?>">
                    <td class="text-center">
                        <?php echo e(Form::checkbox('symptomatic_polycythemia', null, $symptomatic_polycythemia, ['id'=>'symptomatic_polycythemia']), false); ?>                    
                    </td>
                    <td>
                        <div class="display-flex">
                            <span class="bullets">h.</span>
                            <p>Symptomatic polycythemia</p>
                        </div>
                    </td>
                </tr>
                <tr class="sub-infants <?php echo e(@$retrovirus_positive_mother ? 'bg-warning' : '', false); ?>">
                    <td class="text-center">
                        <?php echo e(Form::checkbox('retrovirus_positive_mother', null, $retrovirus_positive_mother, ['id'=>'retrovirus_positive_mother']), false); ?>                    
                    </td>
                    <td>
                        <div class="display-flex">
                            <span class="bullets">i.</span>
                            <p>Retrovirus positive mother</p>
                        </div>
                    </td>
                </tr>
                <tr class="sub-infants <?php echo e(@$hyperbilirubinemia_transfusion_rh ? 'bg-warning' : '', false); ?>">
                    <td class="text-center">
                        <?php echo e(Form::checkbox('hyperbilirubinemia_transfusion_rh', null, $hyperbilirubinemia_transfusion_rh, ['id'=>'hyperbilirubinemia_transfusion_rh']), false); ?>                    
                    </td>
                    <td>
                        <div class="display-flex">
                            <span class="bullets">j.</span>
                            <p>Hyperbilirubinemia requiring exchange transfusion OR Rh isoimmunization/cholestasis</p>
                        </div>
                    </td>
                </tr>
                <tr class="sub-infants <?php echo e(@$abnormal_neuro_exam ? 'bg-warning' : '', false); ?>">
                    <td class="text-center">
                        <?php echo e(Form::checkbox('abnormal_neuro_exam', null, $abnormal_neuro_exam, ['id'=>'abnormal_neuro_exam']), false); ?>                    
                    </td>
                    <td>
                        <div class="display-flex">
                            <span class="bullets">k.</span>
                            <p>Abnormal neurological examination at discharge/seizures</p>
                        </div>
                    </td>
                </tr>
                <tr class="sub-infants <?php echo e(@$major_morbidities ? 'bg-warning' : '', false); ?>">
                    <td class="text-center">
                        <?php echo e(Form::checkbox('major_morbidities', null, $major_morbidities, ['id'=>'major_morbidities']), false); ?>                    
                    </td>
                    <td>
                        <div class="display-flex">
                            <span class="bullets">l.</span>
                            <p>Major morbidities such as chronic lung disease, IVH grade III or more (Papile's classification) and periventricular leucomalacia</p>
                        </div>
                    </td>
                </tr>
                <tr class="<?php echo e(@$other_specify_is_present ? 'bg-warning' : '', false); ?>">
                    <td class="text-center">
                        <?php echo e(Form::checkbox('other_specify_is_present', null, $other_specify_is_present, ['id'=>'other_specify_is_present']), false); ?>                    
                    </td>
                    <td>
                        <div class="display-flex">
                            <span class="bullets">4.</span>
                            <p>Other<br/>Specify</p>
                            <?php echo e(Form::textarea('other_specify', null, ['id'=>'other_specify', 'rows'=>1, 'cols'=>50, 'style'=>'margin-top:7px;']), false); ?>

                        </div>
                    </td>
                </tr>
                <tr class="<?php echo e(@$general_checkup ? 'bg-warning' : '', false); ?>">
                    <td class="text-center">
                        <?php echo e(Form::checkbox('general_checkup', null, $general_checkup, ['id'=>'general_checkup']), false); ?>                    
                    </td>
                    <td>
                        <div class="display-flex">
                            <span class="bullets">5.</span>
                            <p>General Developmental Checkup</p>                            
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
