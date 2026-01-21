@extends('print')
@section('content')
<div class="temp-container nurse-sheet" id="overall-lab-print">
    <div class="temp-row mb-0">
        <div class="col-md-12 plr-must-0">
            <div class="col-md-4 col-sm-4 col-xs-12 plr-must-0">
                <img src="{{ ValuelistHelpers::printPagelogo() }}">
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12 basic-detail plr-must-0">
            <h4 class="mt-0 text-center">Lab Report</h4>
            <div class="content-block">
                <table class="table-layout-fixed">
                    <tbody>
                        <tr>
                            <td><strong>Name:</strong> <span class="font-normal input-width-small display-inline-block">{{ @$baby->BabyName }}</span></td>
                            <td><strong>{{ Lang::get('home.mrn') }}:</strong> <span class="font-normal input-width-small display-inline-block">{{ @$baby->BMrNo }}</span></td>
                            <td><strong>DOB:</strong> <span class="font-normal input-width-small display-inline-block">{{ (isset($baby->DOB) && !empty($baby->DOB)) ? date('d-m-Y', strtotime($baby->DOB)) : '' }}</span></td>
                            <td><strong>Sex:</strong> <span class="font-normal input-width-small display-inline-block">{{ @$baby->Sex }}</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="clearfix"></div>
        <div role="tabpanel" class="tabbable tabbable-custom mt-15">
            <ul class="nav nav-tabs hidden-print" role="tablist">
                <li role="presentation" class="active">
                    <a href="#hb" role="tab" data-toggle="tab">Haematology and Biochemistry</a>
                </li>
                <li role="presentation">
                    <a href="#ucs" role="tab" data-toggle="tab">Urine, CSF, Stool</a>
                </li>
                @if (isset($abg_values))
                <li role="presentation">
                    <a href="#abg" role="tab" data-toggle="tab">ABG Test</a>
                </li>
                @endif
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active avoid-break" id="hb">
                    <div role="tabpanel" class="tabbable tabbable-custom pull-right hidden-print">
                        <ul class="nav nav-tabs column_list_tab" role="tablist">
                        </ul>
                    </div>
                    <span class="clearfix"></span>      
                    <div class="table-border">
                        <table class="table hour-wise-table fixed" id="lab-report-table">
                            <thead>
                                <tr>
                                    <th colspan="2" class="text-center">Field Name</th>
                                    @php $j = 0;$k = 1; @endphp
                                    @foreach($sheet_id as $day_id)
                                    @php
                                    $date = date('d-m-Y H:i', strtotime($day_id));
                                    @endphp
                                    <th class="{{ str_slug(date('d-m-YHi', strtotime($day_id))) }}">{{ date('d-m-Y', strtotime($day_id)) }} <br><small>({{ date('H:i', strtotime($day_id)) }})</small></th>
                                    @endforeach     
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Create All values and display items  -->
                                <?php
                                    $sodium_display_content = $potassium_display_content = $chloride_display_content = $bicarbonate_display_content = $magnesium_display_content = $bun_urea_display_content = $creatintine_display_content = $phosphorus_display_content = $glucose_display_content = $creatine_kinase_display_content = $ck_mb_display_content = $direct_bilirubin_display_content = $total_bilirubin_display_content = $trop_display_content = $sgot_display_content = $calcium_display_content = $sgpt_display_content = $alkaline_phosphatase_display_content = $ldh_display_content = $gama_gtp_display_content = $amylase_display_content = $lipase_display_content = $total_protein_display_content = $albumin_display_content = $total_cholesterol_display_content = $hdl_display_content = $ldl_display_content = $vldl_display_content = $rbc_display_content = $haemoglobin_display_content = $tri_glycerides_display_content = $haematocrit_display_content = $reticulocyte_count_display_content = $wbc_total_count_display_content = $dc_poly_display_content = $lymph_display_content = $mono_display_content = $eos_display_content = $baso_display_content = $esr_display_content = $platelets_display_content = $prothrombin_time_display_content = $aptt_display_content = $inr_display_content = $fibrinogen_display_content = $fdp_display_content = $crp_display_content = $tsh_display_content = $blood_group_display_content = $vitamin_d3_display_content = $parathormone_display_content = '';

                                    $ft4_display_content = $ft3_display_content = $ammonia_display_content = $lactate_display_content = $retics_display_content = $dct_display_content = $procalcitonin_display_content = '';
                                    // $specific_gravity_content = $osmolality_content = $urine_glucose_content = $protein_content = $salts_content = $pigments_content = $puscells_content = $rbc_content = $blood_content = $heamoglobin_content = $casts_content = $sodium_content = $fena_content = $potassium_content = $chloride_content = $creatintine_content = $clearance_content = $sputum_content = $urine_content = $bloodstain_content = $catheter_content = $widal_content =  '';
                                    
                                    $urine_specific_gravity_display_content = $urine_ph_display_content = $urine_protein_display_content = $urine_glucose_display_content = $urine_bilirubin_display_content = $urine_urobilinogen_display_content = $urine_ketones_display_content = $urine_nitrate_display_content = $urine_pus_cells_display_content = $urine_rbc_display_content = $urine_epithelial_cells_display_content = $urine_crystals_display_content = $urine_casts_display_content = $urine_osmolality_display_content = $urine_bile_salts_display_content = $urine_bile_pigments_display_content = $urine_blood_display_content = $urine_heamoglobin_display_content = $urine_spot_sodium_display_content = $urine_fena_display_content = $urine_spot_potassium_display_content = $urine_spot_chloride_display_content = $urine_spot_creatinine_display_content = $urine_creatinine_clearance_display_content = $urine_others_display_content = $csf_proteins_display_content = $csf_glucose_display_content = $csf_cell_count_display_content = $csf_gram_stain_display_content = $afbstain_content = $miscellaneous_content = $stool_wbc_display_content = $stool_occult_blood_display_content = $stool_ova_parasites_display_content = $miscellaneous_display_content = $afbstain_display_content = $urnine_leukocytes_esterases_display_content = $csf_rbc_display_content = $csf_neutrophils_display_content = $csf_lymphocytes_display_content = $csf_eosinophils_display_content = '';
                                    
                                    $empty_content = $second_tab_empty_content = '';

                                    /*FOR First tab results ( BIOCHEMISTRY AND HAEMATOLOGY)*/
                                    foreach ($sheet_id as $day_id)
                                    {
                                        $date = $day_id;
                                        if (isset($result[$date]))
                                        {
                                    
                                            $temp_data = $result[$date];
                                            $sodium_values = collect($temp_data)->where('testId', '37')->first();
                                            $potassium_values = collect($temp_data)->where('testId', '38')->first();
                                            $chloride_values = collect($temp_data)->where('testId', '39')->first();
                                            $bicarbonate_values = collect($temp_data)->where('testId', '468')->first();
                                            $calcium_values = collect($temp_data)->where('testId', '56')->first();
                                            $magnesium_values = collect($temp_data)->where('testId', '228')->first();
                                            $phosphorus_values = collect($temp_data)->where('testId', '55')->first();
                                            $bun_urea_values = collect($temp_data)->where('testId', '11')->first();
                                            $creatintine_values = collect($temp_data)->where('testId', '12')->first();
                                            $glucose_values = collect($temp_data)->where('testId', '168')->first();
                                            $creatine_kinase_values = collect($temp_data)->where('testId', '17')->first();
                                            $ck_mb_values = collect($temp_data)->where('testId', '57')->first();
                                            $trop_values = collect($temp_data)->where('testId', '232')->first();
                                            $total_bilirubin_values = collect($temp_data)->where('testId', '33')->first();
                                            $direct_bilirubin_values = collect($temp_data)->where('testId', '34')->first();
                                            $sgot_values = collect($temp_data)->where('testId', '14')->first();
                                            $sgpt_values = collect($temp_data)->where('testId', '15')->first();
                                            $alkaline_phosphatase_values = collect($temp_data)->where('testId', '13')->first();
                                            $gama_gtp_values = collect($temp_data)->where('testId', '16')->first();
                                            $ldh_values = collect($temp_data)->where('testId', '21')->first();
                                            $amylase_values = collect($temp_data)->where('testId', '58')->first();
                                            $lipase_values = collect($temp_data)->where('testId', '59')->first();
                                            $total_protein_values = collect($temp_data)->where('testId', '29')->first();
                                            $albumin_values = collect($temp_data)->where('testId', '30')->first();
                                            $total_cholesterol_values = collect($temp_data)->where('testId', '22')->first();
                                            $hdl_values = collect($temp_data)->where('testId', '24')->first();
                                            $ldl_values = collect($temp_data)->where('testId', '25')->first();
                                            $vldl_values = collect($temp_data)->where('testId', '26')->first();
                                            $tri_glycerides_values = collect($temp_data)->where('testId', '23')->first();
                                            $tsh_values = collect($temp_data)->where('testId', '116')->first();
                                            
                                            $rbc_values = collect($temp_data)->where('testId', '107')->first();
                                            $haemoglobin_values = collect($temp_data)->where('testId', '98')->first();
                                            $haematocrit_values = collect($temp_data)->where('testId', '106')->first();
                                            $reticulocyte_count_values = collect($temp_data)->where('testId', '76')->first();
                                            $wbc_total_count_values = collect($temp_data)->where('testId', '99')->first();
                                            $dc_poly_values = collect($temp_data)->where('testId', '100')->first();
                                            $lymph_values = collect($temp_data)->where('testId', '101')->first();
                                            $mono_values = collect($temp_data)->where('testId', '102')->first();
                                            $eos_values = collect($temp_data)->where('testId', '103')->first();
                                            $baso_values = collect($temp_data)->where('testId', '104')->first();
                                            $platelets_values = collect($temp_data)->where('testId', '108')->first();
                                            $esr_values = collect($temp_data)->where('testId', '105')->first();
                                            $prothrombin_time_values = collect($temp_data)->where('testId', '218')->first();
                                            $prothrombin_time_values_1 = collect($temp_data)->where('testId', '219')->first();
                                            $aptt_values = collect($temp_data)->where('testId', '222')->first();
                                            $aptt_values_1 = collect($temp_data)->where('testId', '223')->first();
                                            $inr_values = collect($temp_data)->where('testId', '220')->first();
                                            $fibrinogen_values = collect($temp_data)->where('testId', '0')->first();
                                            $fdp_values = collect($temp_data)->where('testId', '0')->first();
                                            $crp_values = collect($temp_data)->where('testId', '191')->first();
                                            $blood_group_values = collect($temp_data)->where('testId', '233')->first();
                                            $blood_rh_type_values = collect($temp_data)->where('testId', '987')->first();
                                            $vitamin_d3_values = collect($temp_data)->where('testId', '421')->first();
                                            $parathormone_values = collect($temp_data)->where('testId', '296')->first();
                                            $ft4_value = collect($temp_data)->where('testId', '113')->first();
                                            $ft3_value = collect($temp_data)->where('testId', '112')->first();
                                            $ammonia_value = collect($temp_data)->where('testId', '229')->first();
                                            $lactate_value = collect($temp_data)->where('testId', '230')->first();
                                            $retics_value = collect($temp_data)->where('testId', '76')->first();
                                            $dct_value = collect($temp_data)->where('testId', '240')->first();
                                            $procalcitonin_value = collect($temp_data)->where('testId', '747')->first();

                                    
                                            $date = str_slug(date('d-m-YHi', strtotime($day_id)));
                                            $status = 'bg-successsss';

                                            if (!empty($ft4_value->rawResult))
                                            {
                                                if (isset($ft4_value->result_status) && $ft4_value->result_status == 'final')
                                                {
                                                    $status = 'bg-successsss';
                                                }
                                                else
                                                {
                                                    $status = 'bg-warninggg';
                                                }
                                                $ft4_display_content .= '<td class="' . $date . ' ' . $status . '">' . $ft4_value->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $ft4_display_content .= '<td class="' . $date . '">-</td>';
                                            }

                                            if (!empty($ft3_value->rawResult))
                                            {
                                                if (isset($ft3_value->result_status) && $ft3_value->result_status == 'final')
                                                {
                                                    $status = 'bg-successsss';
                                                }
                                                else
                                                {
                                                    $status = 'bg-warninggg';
                                                }
                                                $ft3_display_content .= '<td class="' . $date . ' ' . $status . '">' . $ft3_value->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $ft3_display_content .= '<td class="' . $date . '">-</td>';
                                            }

                                            if (!empty($ammonia_value->rawResult))
                                            {
                                                if (isset($ammonia_value->result_status) && $ammonia_value->result_status == 'final')
                                                {
                                                    $status = 'bg-successsss';
                                                }
                                                else
                                                {
                                                    $status = 'bg-warninggg';
                                                }
                                                $ammonia_display_content .= '<td class="' . $date . ' ' . $status . '">' . $ammonia_value->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $ammonia_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                            
                                            if (!empty($lactate_value->rawResult))
                                            {
                                                if (isset($lactate_value->result_status) && $lactate_value->result_status == 'final')
                                                {
                                                    $status = 'bg-successsss';
                                                }
                                                else
                                                {
                                                    $status = 'bg-warninggg';
                                                }
                                                $lactate_display_content .= '<td class="' . $date . ' ' . $status . '">' . $lactate_value->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $lactate_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                            
                                            if (!empty($retics_value->rawResult))
                                            {
                                                if (isset($retics_value->result_status) && $retics_value->result_status == 'final')
                                                {
                                                    $status = 'bg-successsss';
                                                }
                                                else
                                                {
                                                    $status = 'bg-warninggg';
                                                }
                                                $retics_display_content .= '<td class="' . $date . ' ' . $status . '">' . $retics_value->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $retics_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                            
                                            if (!empty($dct_value->rawResult))
                                            {
                                                if (isset($dct_value->result_status) && $dct_value->result_status == 'final')
                                                {
                                                    $status = 'bg-successsss';
                                                }
                                                else
                                                {
                                                    $status = 'bg-warninggg';
                                                }
                                                $dct_display_content .= '<td class="' . $date . ' ' . $status . '">' . $dct_value->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $dct_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                            
                                            if (!empty($procalcitonin_value->rawResult))
                                            {
                                                if (isset($procalcitonin_value->result_status) && $procalcitonin_value->result_status == 'final')
                                                {
                                                    $status = 'bg-successsss';
                                                }
                                                else
                                                {
                                                    $status = 'bg-warninggg';
                                                }
                                                $procalcitonin_display_content .= '<td class="' . $date . ' ' . $status . '">' . $procalcitonin_value->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $procalcitonin_display_content .= '<td class="' . $date . '">-</td>';
                                            }

                                            if (!empty($parathormone_values->rawResult))
                                            {
                                                if (isset($parathormone_values->result_status) && $parathormone_values->result_status == 'final')
                                                {
                                                    $status = 'bg-successsss';
                                                }
                                                else
                                                {
                                                    $status = 'bg-warninggg';
                                                }
                                                $parathormone_display_content .= '<td class="' . $date . ' ' . $status . '">' . $parathormone_values->rawResult . '</td>';
                                            } else {
                                                $parathormone_display_content .= '<td class="' . $date . '">-</td>';
                                            }

                                            if (!empty($vitamin_d3_values->rawResult))
                                            {
                                                if (isset($vitamin_d3_values->result_status) && $vitamin_d3_values->result_status == 'final')
                                                {
                                                    $status = 'bg-successsss';
                                                }
                                                else
                                                {
                                                    $status = 'bg-warninggg';
                                                }
                                                $vitamin_d3_display_content .= '<td class="' . $date . ' ' . $status . '">' . $vitamin_d3_values->rawResult . '</td>';
                                            } else {
                                                $vitamin_d3_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                            

                                            if (!empty($blood_group_values->rawResult) && !empty($blood_rh_type_values->rawResult))
                                            {
                                                $blood_group_display_content .= '<td class="' . $date . '">' . $blood_group_values->rawResult . ' ' . ucfirst(strtolower($blood_rh_type_values->rawResult)) . '</td>';
                                            }
                                            else
                                            {
                                                $blood_group_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                            
                                            if (!empty($tsh_values->rawResult))
                                            {
                                                $tsh_display_content .= '<td class="' . $date . ' ' . $status . '">' . $tsh_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $tsh_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($crp_values->rawResult))
                                            {
                                                $crp_display_content .= '<td class="' . $date . ' ' . $status . ' crp-values">' . str_replace(array('NEGATIVE', 'POSITIVE'), array('-', '+'), $crp_values->rawResult) . '</td>';
                                            }
                                            else
                                            {
                                                $crp_display_content .= '<td class="' . $date . ' crp-values">-</td>';
                                            }
                                    
                                            if (!empty($fdp_values->rawResult))
                                            {
                                                $fdp_display_content .= '<td class="' . $date . ' ' . $status . '">' . $fdp_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $fdp_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($fibrinogen_values->rawResult))
                                            {
                                                $fibrinogen_display_content .= '<td class="' . $date . ' ' . $status . '">' . $fibrinogen_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $fibrinogen_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($inr_values->rawResult))
                                            {
                                                $inr_display_content .= '<td class="' . $date . ' ' . $status . '">' . $inr_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $inr_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                            if (!empty($aptt_values->rawResult))
                                            {
                                                $aptt_display_content .= '<td class="' . $date . ' ' . $status . '">' . $aptt_values->rawResult . (!empty($aptt_values_1->rawResult) ? ' (' . $aptt_values_1->rawResult . ')' : '') . '</td>';
                                            }
                                            else
                                            {
                                                $aptt_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($prothrombin_time_values->rawResult))
                                            {
                                                $prothrombin_time_display_content .= '<td class="' . $date . ' ' . $status . '">' . $prothrombin_time_values->rawResult . (!empty($prothrombin_time_values_1->rawResult) ? ' (' . $prothrombin_time_values_1->rawResult . ')' : '') . '</td>';
                                            }
                                            else
                                            {
                                                $prothrombin_time_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($esr_values->rawResult))
                                            {
                                                $esr_display_content .= '<td class="' . $date . ' ' . $status . '">' . $esr_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $esr_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($platelets_values->rawResult))
                                            {
                                                $platelets_display_content .= '<td class="' . $date . ' ' . $status . '">' . $platelets_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $platelets_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($baso_values->rawResult))
                                            {
                                                $baso_display_content .= '<td class="' . $date . ' ' . $status . '">' . $baso_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $baso_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($eos_values->rawResult))
                                            {
                                                $eos_display_content .= '<td class="' . $date . ' ' . $status . '">' . $eos_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $eos_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($mono_values->rawResult))
                                            {
                                                $mono_display_content .= '<td class="' . $date . ' ' . $status . '">' . $mono_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $mono_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($lymph_values->rawResult))
                                            {
                                                $lymph_display_content .= '<td class="' . $date . ' ' . $status . '">' . $lymph_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $lymph_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($dc_poly_values->rawResult))
                                            {
                                                $dc_poly_display_content .= '<td class="' . $date . ' ' . $status . '">' . $dc_poly_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $dc_poly_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($wbc_total_count_values->rawResult))
                                            {
                                                $wbc_total_count_display_content .= '<td class="' . $date . ' ' . $status . '">' . $wbc_total_count_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $wbc_total_count_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($reticulocyte_count_values->rawResult))
                                            {
                                                $reticulocyte_count_display_content .= '<td class="' . $date . ' ' . $status . '">' . $reticulocyte_count_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $reticulocyte_count_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($haematocrit_values->rawResult))
                                            {
                                                $haematocrit_display_content .= '<td class="' . $date . ' ' . $status . '">' . $haematocrit_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $haematocrit_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($haemoglobin_values->rawResult))
                                            {
                                                $haemoglobin_display_content .= '<td class="' . $date . ' ' . $status . '">' . $haemoglobin_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $haemoglobin_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($rbc_values->rawResult))
                                            {
                                                $rbc_display_content .= '<td class="' . $date . ' ' . $status . '">' . $rbc_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $rbc_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($tri_glycerides_values->rawResult))
                                            {
                                                $tri_glycerides_display_content .= '<td class="' . $date . ' ' . $status . '">' . $tri_glycerides_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $tri_glycerides_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($vldl_values->rawResult))
                                            {
                                                $vldl_display_content .= '<td class="' . $date . ' ' . $status . '">' . $vldl_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $vldl_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($ldl_values->rawResult))
                                            {
                                                $ldl_display_content .= '<td class="' . $date . ' ' . $status . '">' . $ldl_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $ldl_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($hdl_values->rawResult))
                                            {
                                                $hdl_display_content .= '<td class="' . $date . ' ' . $status . '">' . $hdl_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $hdl_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($total_cholesterol_values->rawResult))
                                            {
                                                $total_cholesterol_display_content .= '<td class="' . $date . ' ' . $status . '">' . $total_cholesterol_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $total_cholesterol_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($albumin_values->rawResult))
                                            {
                                                $albumin_display_content .= '<td class="' . $date . ' ' . $status . '">' . $albumin_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $albumin_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($total_protein_values->rawResult))
                                            {
                                                $total_protein_display_content .= '<td class="' . $date . ' ' . $status . '">' . $total_protein_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $total_protein_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($lipase_values->rawResult))
                                            {
                                                $lipase_display_content .= '<td class="' . $date . ' ' . $status . '">' . $lipase_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $lipase_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($amylase_values->rawResult))
                                            {
                                                $amylase_display_content .= '<td class="' . $date . ' ' . $status . '">' . $amylase_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $amylase_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($ldh_values->rawResult))
                                            {
                                                $ldh_display_content .= '<td class="' . $date . ' ' . $status . '">' . $ldh_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $ldh_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($gama_gtp_values->rawResult))
                                            {
                                                $gama_gtp_display_content .= '<td class="' . $date . ' ' . $status . '">' . $gama_gtp_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $gama_gtp_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($alkaline_phosphatase_values->rawResult))
                                            {
                                                $alkaline_phosphatase_display_content .= '<td class="' . $date . ' ' . $status . '">' . $alkaline_phosphatase_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $alkaline_phosphatase_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($sgpt_values->rawResult))
                                            {
                                                $sgpt_display_content .= '<td class="' . $date . ' ' . $status . '">' . $sgpt_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $sgpt_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($sgot_values->rawResult))
                                            {
                                                $sgot_display_content .= '<td class="' . $date . ' ' . $status . '">' . $sgot_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $sgot_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($direct_bilirubin_values->rawResult))
                                            {
                                                $direct_bilirubin_display_content .= '<td class="' . $date . ' ' . $status . '">' . $direct_bilirubin_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $direct_bilirubin_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($total_bilirubin_values->rawResult))
                                            {
                                                $total_bilirubin_display_content .= '<td class="' . $date . ' ' . $status . '">' . $total_bilirubin_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $total_bilirubin_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($trop_values->rawResult))
                                            {
                                                $trop_display_content .= '<td class="' . $date . ' ' . $status . '">' . $trop_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $trop_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($ck_mb_values->rawResult))
                                            {
                                                $ck_mb_display_content .= '<td class="' . $date . ' ' . $status . '">' . $ck_mb_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $ck_mb_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($creatine_kinase_values->rawResult))
                                            {
                                                $creatine_kinase_display_content .= '<td class="' . $date . ' ' . $status . '">' . $creatine_kinase_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $creatine_kinase_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($glucose_values->rawResult))
                                            {
                                                $glucose_display_content .= '<td class="' . $date . ' ' . $status . '">' . $glucose_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $glucose_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($creatintine_values->rawResult))
                                            {
                                                $creatintine_display_content .= '<td class="' . $date . ' ' . $status . '">' . $creatintine_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $creatintine_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($bun_urea_values->rawResult))
                                            {
                                                $bun_urea_display_content .= '<td class="' . $date . ' ' . $status . '">' . $bun_urea_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $bun_urea_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($phosphorus_values->rawResult))
                                            {
                                                $phosphorus_display_content .= '<td class="' . $date . ' ' . $status . '">' . $phosphorus_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $phosphorus_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($sodium_values->rawResult))
                                            {
                                                $sodium_display_content .= '<td class="' . $date . ' ' . $status . '">' . $sodium_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $sodium_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($potassium_values->rawResult))
                                            {
                                                $potassium_display_content .= '<td class="' . $date . ' ' . $status . '">' . $potassium_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $potassium_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($chloride_values->rawResult))
                                            {
                                                $chloride_display_content .= '<td class="' . $date . ' ' . $status . '">' . $chloride_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $chloride_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($bicarbonate_values->rawResult))
                                            {
                                                $bicarbonate_display_content .= '<td class="' . $date . ' ' . $status . '">' . $bicarbonate_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $bicarbonate_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                                // echo "<pre>"; print_r($calcium_values); exit;
                                            if (!empty($calcium_values->rawResult))
                                            {
                                                $calcium_display_content .= '<td class="' . $date . ' ' . $status . '">' . $calcium_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $calcium_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($magnesium_values->rawResult))
                                            {
                                                $magnesium_display_content .= '<td class="' . $date . ' ' . $status . '">' . $magnesium_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $magnesium_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            $empty_content .= '<td class="' . $date . '">-</td>';
                                    
                                        }
                                    }

                                    foreach ($second_tab_sheet_id as $day_id)
                                    {
                                        $date = $day_id;
                                        if (isset($second_tab_result[$date]))
                                        {
                                    
                                            $temp_data = $second_tab_result[$date];
                                            $urine_specific_gravity_values = collect($temp_data)->where('testId', '89')->first();
                                            $urine_ph_values = collect($temp_data)->where('testId', '91')->first();
                                            $urine_protein_values = collect($temp_data)->where('testId', '79')->first();
                                            $urine_glucose_values = collect($temp_data)->where('testId', '521')->first();
                                            $urine_bilirubin_values = collect($temp_data)->where('testId', '786')->first();
                                            $urine_urobilinogen_values = collect($temp_data)->where('testId', '93')->first();
                                            $urine_ketones_values = collect($temp_data)->where('testId', '90')->first();
                                            $urine_nitrate_values = collect($temp_data)->where('testId', '202')->first();
                                            $urine_pus_cells_values = collect($temp_data)->where('testId', '83')->first();
                                            $urine_rbc_values = collect($temp_data)->where('testId', '84')->first();
                                            $urine_epithelial_cells_values = collect($temp_data)->where('testId', '85')->first();
                                            $urine_crystals_values = collect($temp_data)->where('testId', '86')->first();
                                            $urine_casts_values = collect($temp_data)->where('testId', '87')->first();
                                            $urine_osmolality_values = collect($temp_data)->where('testId', '256')->first();
                                            $urine_bile_salts_values = collect($temp_data)->where('testId', '81')->first();
                                            $urine_bile_pigments_values = collect($temp_data)->where('testId', '82')->first();
                                            $urine_blood_values = collect($temp_data)->where('testId', '200')->first();
                                            $urine_heamoglobin_values = collect($temp_data)->where('testId', '267')->first();
                                            $urine_spot_sodium_values = collect($temp_data)->where('testId', '175')->first();
                                            $urine_fena_values = collect($temp_data)->where('testId', '0')->first();
                                            $urine_spot_potassium_values = collect($temp_data)->where('testId', '176')->first();
                                            $urine_spot_chloride_values = collect($temp_data)->where('testId', '1062')->first();
                                            $urine_spot_creatinine_values = collect($temp_data)->where('testId', '178')->first();
                                            $urine_creatinine_clearance_values = collect($temp_data)->where('testId', '186')->first();
                                            $urine_others_values = collect($temp_data)->where('testId', '88')->first();
                                            $urnine_leukocytes_esterases_values = collect($temp_data)->where('testId', '513')->first();
                                            
                                            $csf_proteins_values = collect($temp_data)->where('testId', '358')->first();
                                            $csf_glucose_values = collect($temp_data)->where('testId', '357')->first();
                                            $csf_cell_count_values = collect($temp_data)->where('testId', '351')->first();
                                            $csf_gram_stain_values = collect($temp_data)->where('testId', '627')->first();
                                            $csf_rbc_values = collect($temp_data)->where('testId', '355')->first();
                                            $csf_neutrophils_values = collect($temp_data)->where('testId', '352')->first();
                                            $csf_lymphocytes_values = collect($temp_data)->where('testId', '353')->first();
                                            $csf_eosinophils_values = collect($temp_data)->where('testId', '354')->first();
                                            
                                            $afbstain_values = collect($temp_data)->where('testId', '0')->first();
                                            $miscellaneous_values = collect($temp_data)->where('testId', '0')->first();
                                            
                                            $stool_wbc_values = collect($temp_data)->where('testId', '361')->first();
                                            $stool_occult_blood_values = collect($temp_data)->where('testId', '166')->first();
                                            $stool_ova_parasites_values = collect($temp_data)->where('testId', '161')->first();
                                    
                                            $date = str_slug(date('d-m-YHi', strtotime($day_id)));
                                            $status = 'bg-successsss';

                                            if (!empty($csf_eosinophils_values->rawResult))
                                            {
                                                $csf_eosinophils_display_content .= '<td class="' . $date . ' ' . $status . '">' . $csf_eosinophils_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $csf_eosinophils_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($csf_lymphocytes_values->rawResult))
                                            {
                                                $csf_lymphocytes_display_content .= '<td class="' . $date . ' ' . $status . '">' . $csf_lymphocytes_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $csf_lymphocytes_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($csf_neutrophils_values->rawResult))
                                            {
                                                $csf_neutrophils_display_content .= '<td class="' . $date . ' ' . $status . '">' . $csf_neutrophils_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $csf_neutrophils_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                            if (!empty($csf_rbc_values->rawResult))
                                            {
                                                $csf_rbc_display_content .= '<td class="' . $date . ' ' . $status . '">' . $csf_rbc_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $csf_rbc_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                            if (!empty($urnine_leukocytes_esterases_values->rawResult))
                                            {
                                                $urnine_leukocytes_esterases_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urnine_leukocytes_esterases_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $urnine_leukocytes_esterases_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                            if (!empty($stool_ova_parasites_values->rawResult))
                                            {
                                                $stool_ova_parasites_display_content .= '<td class="' . $date . ' ' . $status . '">' . $stool_ova_parasites_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $stool_ova_parasites_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                            
                                            if (!empty($stool_occult_blood_values->rawResult))
                                            {
                                                $stool_occult_blood_display_content .= '<td class="' . $date . ' ' . $status . '">' . $stool_occult_blood_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $stool_occult_blood_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                            if (!empty($stool_wbc_values->rawResult))
                                            {
                                                $stool_wbc_display_content .= '<td class="' . $date . ' ' . $status . '">' . $stool_wbc_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $stool_wbc_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                            if (!empty($miscellaneous_values->rawResult))
                                            {
                                                $miscellaneous_display_content .= '<td class="' . $date . ' ' . $status . '">' . $miscellaneous_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $miscellaneous_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                            if (!empty($afbstain_values->rawResult))
                                            {
                                                $afbstain_display_content .= '<td class="' . $date . ' ' . $status . '">' . $afbstain_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $afbstain_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                            
                                            if (!empty($csf_gram_stain_values->rawResult))
                                            {
                                                $csf_gram_stain_display_content .= '<td class="' . $date . ' ' . $status . '">' . $csf_gram_stain_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $csf_gram_stain_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                            
                                            if (!empty($csf_cell_count_values->rawResult))
                                            {
                                                $csf_cell_count_display_content .= '<td class="' . $date . ' ' . $status . '">' . $csf_cell_count_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $csf_cell_count_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                            
                                            if (!empty($csf_glucose_values->rawResult))
                                            {
                                                $csf_glucose_display_content .= '<td class="' . $date . ' ' . $status . '">' . $csf_glucose_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $csf_glucose_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                            
                                            if (!empty($csf_proteins_values->rawResult))
                                            {
                                                $csf_proteins_display_content .= '<td class="' . $date . ' ' . $status . '">' . $csf_proteins_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $csf_proteins_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($urine_others_values->rawResult))
                                            {
                                                $urine_others_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_others_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $urine_others_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($urine_creatinine_clearance_values->rawResult))
                                            {
                                                $urine_creatinine_clearance_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_creatinine_clearance_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $urine_creatinine_clearance_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                            if (!empty($urine_spot_creatinine_values->rawResult))
                                            {
                                                $urine_spot_creatinine_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_spot_creatinine_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $urine_spot_creatinine_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                            if (!empty($urine_spot_chloride_values->rawResult))
                                            {
                                                $urine_spot_chloride_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_spot_chloride_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $urine_spot_chloride_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($urine_spot_potassium_values->rawResult))
                                            {
                                                $urine_spot_potassium_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_spot_potassium_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $urine_spot_potassium_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($urine_spot_sodium_values->rawResult))
                                            {
                                                $urine_spot_sodium_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_spot_sodium_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $urine_spot_sodium_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($urine_fena_values->rawResult))
                                            {
                                                $urine_fena_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_fena_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $urine_fena_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                            if (!empty($urine_heamoglobin_values->rawResult))
                                            {
                                                $urine_heamoglobin_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_heamoglobin_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $urine_heamoglobin_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                            
                                            if (!empty($urine_blood_values->rawResult))
                                            {
                                                $urine_blood_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_blood_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $urine_blood_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                            
                                            if (!empty($urine_bile_pigments_values->rawResult))
                                            {
                                                $urine_bile_pigments_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_bile_pigments_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $urine_bile_pigments_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($urine_bile_salts_values->rawResult))
                                            {
                                                $urine_bile_salts_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_bile_salts_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $urine_bile_salts_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                            if (!empty($urine_osmolality_values->rawResult))
                                            {
                                                $urine_osmolality_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_osmolality_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $urine_osmolality_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                            if (!empty($urine_casts_values->rawResult))
                                            {
                                                $urine_casts_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_casts_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $urine_casts_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                            if (!empty($urine_crystals_values->rawResult))
                                            {
                                                $urine_crystals_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_crystals_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $urine_crystals_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                            if (!empty($urine_epithelial_cells_values->rawResult))
                                            {
                                                $urine_epithelial_cells_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_epithelial_cells_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $urine_epithelial_cells_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($urine_rbc_values->rawResult))
                                            {
                                                $urine_rbc_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_rbc_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $urine_rbc_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($urine_pus_cells_values->rawResult))
                                            {
                                                $urine_pus_cells_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_pus_cells_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $urine_pus_cells_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                            if (!empty($urine_nitrate_values->rawResult))
                                            {
                                                $urine_nitrate_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_nitrate_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $urine_nitrate_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($urine_ketones_values->rawResult))
                                            {
                                                $urine_ketones_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_ketones_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $urine_ketones_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($urine_urobilinogen_values->rawResult))
                                            {
                                                $urine_urobilinogen_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_urobilinogen_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $urine_urobilinogen_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($urine_bilirubin_values->rawResult))
                                            {
                                                $urine_bilirubin_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_bilirubin_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $urine_bilirubin_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($urine_glucose_values->rawResult))
                                            {
                                                $urine_glucose_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_glucose_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $urine_glucose_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($urine_protein_values->rawResult))
                                            {
                                                $urine_protein_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_protein_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $urine_protein_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($urine_ph_values->rawResult))
                                            {
                                                $urine_ph_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_ph_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $urine_ph_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                    
                                            if (!empty($urine_specific_gravity_values->rawResult))
                                            {
                                                $urine_specific_gravity_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_specific_gravity_values->rawResult . '</td>';
                                            }
                                            else
                                            {
                                                $urine_specific_gravity_display_content .= '<td class="' . $date . '">-</td>';
                                            }
                                            $second_tab_empty_content .= '<td class="' . $date . '">-</td>';
                                    
                                        }
                                    }
                                    ?>
                                <tr>
                                    <td rowspan="31" class="text-center biochemisty-cell">    <b style="writing-mode: vertical-lr;text-orientation: upright;">BIOCHEMISTRY</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Sodium <span class="print-small">(135-145 mmol/L)</span></td>
                                    {!! $sodium_display_content !!}         
                                </tr>
                                <tr>
                                    <td>Potassium <span class="print-small">(3.2-5 mmol/L)</span></td>
                                    {!! $potassium_display_content !!}
                                </tr>
                                <tr>
                                    <td>Chloride <span class="print-small">(96-106 mmol/L)</span></td>
                                    {!! $chloride_display_content !!}           
                                </tr>
                                <tr>
                                    <td>Bicarbonate <span class="print-small">(22-26 mmol/L)</span></td>
                                    {!! $bicarbonate_display_content !!}
                                </tr>
                                <tr>
                                    <td>Calcium <span class="print-small">(8.5-10.5 mg/dl)</span></td>
                                    {!! $calcium_display_content !!}
                                </tr>
                                <tr>
                                    <td>Magnesium <span class="print-small">(0.6-1.1 nmol/L)</span></td>
                                    {!! $magnesium_display_content !!}
                                </tr>
                                <tr>
                                    <td>Phosphorus <span class="print-small">(2.7-4.5 mg/dl)</span></td>
                                    {!! $phosphorus_display_content !!}
                                </tr>
                                <tr>
                                    <td>BUN (urea) <span class="print-small">(6-20 mg/dl)</span></td>
                                    {!! $bun_urea_display_content !!}
                                </tr>
                                <tr>
                                    <td>Creatintine <span class="print-small">(0.6-1.4 mg/dl)</span></td>
                                    {!! $creatintine_display_content !!}
                                </tr>
                                <tr>
                                    <td>Glucose <span class="print-small">(70-110 mg/dl)</span></td>
                                    {!! $glucose_display_content !!}
                                </tr>
                                <tr>
                                    <td>Creatine Kinase (CK) <span class="print-small">(26-174 U/L)</span></td>
                                    {!! $creatine_kinase_display_content !!}
                                </tr>
                                <tr>
                                    <td>CK - MB <span class="print-small">(<\6% of Total CK)</span></td>
                                    {!! $ck_mb_display_content !!}
                                </tr>
                                <tr>
                                    <td>Trop. T</td>
                                    {!! $trop_display_content !!}
                                </tr>
                                <tr>
                                    <td>Total bilirubin <span class="print-small">(< 1 mg/dl)</span></td>
                                    {!! $total_bilirubin_display_content !!}
                                </tr>
                                <tr>
                                    <td>Direct bilirubin <span class="print-small">(< 0.4 mg/dl)</span></td>
                                    {!! $direct_bilirubin_display_content !!}
                                </tr>
                                <tr>
                                    <td>SGOT (AST) <span class="print-small">(< 0-40 U/L)</span></td>
                                    {!! $sgot_display_content !!}
                                </tr>
                                <tr>
                                    <td>SGPT (AST) <span class="print-small">(< 0-40 U/L)</span></td>
                                    {!! $sgpt_display_content !!}
                                </tr>
                                <tr>
                                    <td>Alkaline Phosphatase <span class="print-small">(30-115 U/L)</span></td>
                                    {!! $alkaline_phosphatase_display_content !!}
                                </tr>
                                <tr>
                                    <td>Gama GTP <span class="print-small">(F5-55, M15-85 U/L)</span></td>
                                    {!! $gama_gtp_display_content !!}
                                </tr>
                                <tr>
                                    <td>LDH <span class="print-small">(90-220 U/L)</span></td>
                                    {!! $ldh_display_content !!}
                                </tr>
                                <tr>
                                    <td>Amylase <span class="print-small">(31-123 U/L)</span></td>
                                    {!! $amylase_display_content !!}
                                </tr>
                                <tr>
                                    <td>Lipase</td>
                                    {!! $lipase_display_content !!}
                                </tr>
                                <tr>
                                    <td>Total Protein <span class="print-small">(6-8.4 gm/dl)</span></td>
                                    {!! $total_protein_display_content !!}
                                </tr>
                                <tr>
                                    <td>Albumin <span class="print-small">(3.5-5.3 gm/dl)</span></td>
                                    {!! $albumin_display_content !!}
                                </tr>
                                <tr>
                                    <td>Total Cholesterol</td>
                                    {!! $total_cholesterol_display_content !!}
                                </tr>
                                <tr>
                                    <td>HDL</td>
                                    {!! $hdl_display_content !!}
                                </tr>
                                <tr>
                                    <td>LDL</td>
                                    {!! $ldl_display_content !!}
                                </tr>
                                <tr>
                                    <td>VLDL</td>
                                    {!! $vldl_display_content !!}
                                </tr>
                                <tr>
                                    <td>Tri Glycerides</td>
                                    {!! $tri_glycerides_display_content !!}
                                </tr>
                                <tr>
                                    <td>TSH</td>
                                    {!! $tsh_display_content !!}
                                </tr>
                                @php $colcount = 2 @endphp
                                @foreach($sheet_id as $day_id)
                                @php $date = date('d-m-Y', strtotime($day_id)); @endphp
                                @if (isset($result[$date]))
                                @php $temp_data = $result[$date]; @endphp
                                @php $colcount = $colcount + count($temp_data); @endphp
                                @endif
                                @endforeach
                                <!--  <tr>
                                    <td colspan="{{ $colcount }}" style="padding: 10px !important;"></td>
                                    </tr> -->
                                <tr>
                                    <td rowspan="29" class="text-center haematology-cell">
                                        <b style="writing-mode: vertical-lr;text-orientation: upright;">HAEMATOLOGY</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Blood Group</td>
                                    {!! $blood_group_display_content !!}
                                </tr>
                                <tr>
                                    <td>RBC <span class="print-small">(3.5-5.5 106/ul)</span></td>
                                    {!! $rbc_display_content !!}
                                </tr>
                                <tr>
                                    <td>Haemoglobin <span class="print-small">(11-17 gm%)</span></td>
                                    {!! $haemoglobin_display_content !!}
                                </tr>
                                <tr>
                                    <td>Haematocrit (PCV) <span class="print-small">(35-55)</span></td>
                                    {!! $haematocrit_display_content !!}
                                </tr>
                                <tr>
                                    <td>Reticulocyte count <span class="print-small">(0.5-1.5 %)</span></td>
                                    {!! $reticulocyte_count_display_content !!}
                                </tr>
                                <tr>
                                    <td>WBC : Total <span class="print-small">(4.000-11.0000/ul)</span></td>
                                    {!! $wbc_total_count_display_content !!}
                                </tr>
                                <tr>
                                    <td>DC : Poly <span class="print-small">(40-75 %)</span></td>
                                    {!! $dc_poly_display_content !!}
                                </tr>
                                <tr>
                                    <td>Lymph <span class="print-small">(0-75 %)</span></td>
                                    {!! $lymph_display_content !!}
                                </tr>
                                <tr>
                                    <td>Mono <span class="print-small">(2-10 %)</span></td>
                                    {!! $mono_display_content !!}
                                </tr>
                                <tr>
                                    <td>Eos <span class="print-small">(1-6 %)</span></td>
                                    {!! $eos_display_content !!}
                                </tr>
                                <tr>
                                    <td>Baso <span class="print-small">(0-1 %)</span></td>
                                    {!! $baso_display_content !!}
                                </tr>
                                <tr>
                                    <td>Platelets <span class="print-small">(1,50,000-4,50,000)</span></td>
                                    {!! $platelets_display_content !!}
                                </tr>
                                <tr>
                                    <td>ESR <span class="print-small">(M: 3-10; F: 5-20)</span></td>
                                    {!! $esr_display_content !!}
                                </tr>
                                <tr>
                                    <td>Prothrombin Time</td>
                                    {!! $prothrombin_time_display_content !!}
                                </tr>
                                <tr>
                                    <td>APTT</td>
                                    {!! $aptt_display_content !!}
                                </tr>
                                <tr>
                                    <td>INR</td>
                                    {!! $inr_display_content !!}
                                </tr>
                                <tr>
                                    <td>Fibrinogen</td>
                                    {!! $fibrinogen_display_content !!}
                                </tr>
                                <tr>
                                    <td>FDP</td>
                                    {!! $fdp_display_content !!}
                                </tr>
                                <tr>
                                    <td>CRP</td>
                                    {!! $crp_display_content !!}
                                </tr>
                                <tr>
                                    <td>FT4</td>
                                    {!! $ft4_display_content !!}
                                </tr>
                                <tr>
                                    <td>FT3</td>
                                    {!! $ft3_display_content !!}
                                </tr>
                                <tr>
                                    <td>Ammonia</td>
                                    {!! $ammonia_display_content !!}
                                </tr>
                                <tr>
                                    <td>Lactate</td>
                                    {!! $lactate_display_content !!}
                                </tr>
                                <tr>
                                    <td>Retics</td>
                                    {!! $retics_display_content !!}
                                </tr>
                                <tr>
                                    <td>DCT</td>
                                    {!! $dct_display_content !!}
                                </tr>
                                <tr>
                                    <td>Procalcitonin</td>
                                    {!! $procalcitonin_display_content !!}
                                </tr>
                                <tr>
                                    <td>Vitamin D3</td>
                                    {!! $vitamin_d3_display_content !!}
                                </tr>
                                <tr>
                                    <td>Parathormone</td>
                                    {!! $parathormone_display_content !!}
                                </tr>
                            </tbody>
                        </table>
                        <div class=""><b>INVESTIGATION CHART / Version - 1 / 27-07-2021 / SKS India (P) Ltd., Salem, TN.</b></div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="ucs">
                    <div role="tabpanel" class="tabbable tabbable-custom pull-right hidden-print">
                        <ul class="nav nav-tabs column_list_second_tab" role="tablist">
                        </ul>
                    </div>
                    <span class="clearfix"></span>      
                    <div class="table-border">
                        <table class="table hour-wise-table fixed" id="-report-table">
                            <thead>
                                <tr>
                                    <th colspan="2" class="text-center">Field Name</th>
                                    @php $j = 0;$k = 1; @endphp
                                    @foreach($second_tab_sheet_id as $day_id)
                                    @php
                                    $date = date('d-m-Y H:i', strtotime($day_id));
                                    @endphp
                                    <th class="{{ str_slug(date('d-m-YHi', strtotime($day_id))) }}">{{ date('d-m-Y', strtotime($day_id)) }} <br><small>({{ date('H:i', strtotime($day_id)) }})</small></th>
                                    @endforeach     
                                </tr>
                            </thead>
                            <tbody style="vertical-align: middle;">
                                <!-- Create All values and display items  -->
                                <?php
                                    ?>
                                <tr>
                                    <td rowspan="28" class="text-center urine-cell"><b style="writing-mode: vertical-lr;text-orientation: upright;">URINE</b></td>
                                </tr>
                                <tr>
                                    <td>Color</td>
                                    {!! $second_tab_empty_content !!}
                                </tr>
                                <tr>
                                    <td>Specific Gravity</td>
                                    {!! $urine_specific_gravity_display_content !!}
                                </tr>
                                <tr>
                                    <td>pH</td>
                                    {!! $urine_ph_display_content !!}
                                </tr>
                                <tr>
                                    <td>Protein</td>
                                    {!! $urine_protein_display_content !!}
                                </tr>
                                <tr>
                                    <td>Glucose</td>
                                    {!! $urine_glucose_display_content !!}
                                </tr>
                                <tr>
                                    <td>Bilirubin</td>
                                    {!! $urine_bilirubin_display_content !!}
                                </tr>
                                <tr>
                                    <td>Urobilinogen</td>
                                    {!! $urine_glucose_display_content !!}
                                </tr>
                                <tr>
                                    <td>Ketones</td>
                                    {!! $urine_ketones_display_content !!}
                                </tr>
                                <tr>
                                    <td>Nitrate</td>
                                    {!! $urine_nitrate_display_content !!}
                                </tr>
                                <tr>
                                    <td>Pus Cells</td>
                                    {!! $urine_pus_cells_display_content !!}
                                </tr>
                                <tr>
                                    <td>RBC<sub>s</sub></td>
                                    {!! $urine_rbc_display_content !!}
                                </tr>
                                <tr>
                                    <td>Epithelial Cells</td>
                                    {!! $urine_epithelial_cells_display_content !!}
                                </tr>
                                <tr>
                                    <td>Crystals</td>
                                    {!! $urine_crystals_display_content !!}
                                </tr>
                                <tr>
                                    <td>Casts</td>
                                    {!! $urine_casts_display_content !!}
                                </tr>
                                <tr>
                                    <td>Osmolality</td>
                                    {!! $urine_osmolality_display_content !!}
                                </tr>
                                <tr>
                                    <td>Bile Salts</td>
                                    {!! $urine_bile_salts_display_content !!}
                                </tr>
                                <tr>
                                    <td>Bile Pigments</td>
                                    {!! $urine_bile_pigments_display_content !!}
                                </tr>
                                <tr>
                                    <td>Blood</td>
                                    {!! $urine_blood_display_content !!}
                                </tr>
                                <tr>
                                    <td>Heamoglobin</td>
                                    {!! $urine_heamoglobin_display_content !!}
                                </tr>
                                <tr>
                                    <td>Spot Sodium</td>
                                    {!! $urine_spot_sodium_display_content !!}
                                </tr>
                                <tr>
                                    <td>FE Na</td>
                                    {!! $urine_fena_display_content !!}
                                </tr>
                                <tr>
                                    <td>Spot Potassium</td>
                                    {!! $urine_spot_potassium_display_content !!}
                                </tr>
                                <tr>
                                    <td>Spot Chloride</td>
                                    {!! $urine_spot_chloride_display_content !!}
                                </tr>
                                <tr>
                                    <td>Spot Creatinine</td>
                                    {!! $urine_spot_creatinine_display_content !!}
                                </tr>
                                <tr>
                                    <td>Creatinine Clearance</td>
                                    {!! $urine_creatinine_clearance_display_content !!}
                                </tr>
                                <tr>
                                    <td>Leukocytes Esterases</td>
                                    {!! $urnine_leukocytes_esterases_display_content !!}
                                </tr>
                                <tr>
                                    <td>Others</td>
                                    {!! $urine_others_display_content !!}
                                </tr>
                                <tr>
                                    <td rowspan="16" class="text-center cap-cell"><b style="writing-mode: vertical-lr;text-orientation: upright; letter-spacing: 0.5px;">CSF / ASCITES / PLEURAL</b></td>
                                </tr>
                                <tr>
                                    <td>Proteins (CSF 20-45 mg/dl)</td>
                                    {!! $csf_proteins_display_content !!}
                                </tr>
                                <tr>
                                    <td>Glucose (CSF 50-75 mg/dl)</td>
                                    {!! $csf_glucose_display_content !!}
                                </tr>
                                <tr>
                                    <td>&nbsp</td>
                                    {!! $second_tab_empty_content !!}
                                </tr>
                                <tr>
                                    <td>&nbsp</td>
                                    {!! $second_tab_empty_content !!}
                                </tr>
                                <tr>
                                    <td>Cell Count</td>
                                    {!! $csf_cell_count_display_content !!}
                                </tr>
                                <tr>
                                    <td>Neutrophils (%)</td>
                                    {!! $csf_neutrophils_display_content !!}
                                </tr>
                                <tr>
                                    <td>Lymphocytes (%)</td>
                                    {!! $csf_lymphocytes_display_content !!}
                                </tr>
                                <tr>
                                    <td>Eosinophils (%)</td>
                                    {!! $csf_eosinophils_display_content !!}
                                </tr>
                                <tr>
                                    <td>RBC</td>
                                    {!! $csf_rbc_display_content !!}
                                </tr>
                                <tr>
                                    <td>Gram Stain</td>
                                    {!! $csf_gram_stain_display_content !!}
                                </tr>
                                <tr>
                                    <td>AFB Stain</td>
                                    {!! $second_tab_empty_content !!}
                                </tr>
                                <tr>
                                    <td>Miscellaneous</td>
                                    {!! $second_tab_empty_content !!}
                                </tr>
                                <tr>
                                    <td>&nbsp</td>
                                    {!! $second_tab_empty_content !!}
                                </tr>
                                <tr>
                                    <td>&nbsp</td>
                                    {!! $second_tab_empty_content !!}
                                </tr>
                                <tr>
                                    <td>&nbsp</td>
                                    {!! $second_tab_empty_content !!}
                                </tr>
                                <tr>
                                    <td rowspan="5" class="text-center stool-cell"><b style="writing-mode: vertical-lr;text-orientation: upright;">STOOL</b></td>
                                </tr>
                                <tr>
                                    <td>WBC</td>
                                    {!! $stool_wbc_display_content !!}
                                </tr>
                                <tr>
                                    <td>Occult Blood</td>
                                    {!! $stool_occult_blood_display_content !!}
                                </tr>
                                <tr>
                                    <td>Ova & Parasites</td>
                                    {!! $stool_ova_parasites_display_content !!}
                                </tr>
                                <tr>
                                    <td>&nbsp</td>
                                    {!! $second_tab_empty_content !!}
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                @if (isset($abg_values))
                <div role="tabpanel" class="tab-pane" id="abg">

                    <div role="tabpanel" class="tabbable tabbable-custom pull-right hidden-print">
                        <ul class="nav nav-tabs column_list_tab" role="tablist">
                        </ul>
                    </div>
                    <span class="clearfix"></span>      

                    @php
                    $abg_date = $type_of_blood_gas = $last_bg_at = $ph = $pao2 = $tcpo2 = $paco2 = $tcpco2 = $etco2 = $hco3 = $be = $na = $k = $calcium = $cl = $hb = $pcv = $lactate = $bilirubin = $blood_sugar = $blood_sugar_gm = $methemoglobin = '';
                    @endphp

                    @foreach($abg_values as $key => $value)
                    @php
                    $date_time = explode(' ', $key);
                    $abg_date .= '<th class="'.date('d-m-YHi', strtotime($key)).'">'.$date_time[0] .'<span class="display-block mt-5">('.$date_time[1].')</span></th>';
                    $type_of_blood_gas .= '<td class="'.date('d-m-YHi', strtotime($key)).'">'.(isset($value[$abg_test_list[0]]) ? $value[$abg_test_list[0]][0]->intf_ref_value : '-').'</td>';
                    $last_bg_at .= '<td class="'.date('d-m-YHi', strtotime($key)).'">'.(isset($value[$abg_test_list[1]]) ? $value[$abg_test_list[1]][0]->intf_ref_value : '-').'</td>';
                    $ph .= '<td class="'.date('d-m-YHi', strtotime($key)).'">'.(isset($value[$abg_test_list[2]]) ? $value[$abg_test_list[2]][0]->intf_ref_value : '-').'</td>';
                    $pao2 .= '<td class="'.date('d-m-YHi', strtotime($key)).'">'.(isset($value[$abg_test_list[3]]) ? $value[$abg_test_list[3]][0]->intf_ref_value : '-').'</td>';
                    $tcpo2 .= '<td class="'.date('d-m-YHi', strtotime($key)).'">'.(isset($value[$abg_test_list[4]]) ? $value[$abg_test_list[4]][0]->intf_ref_value : '-').'</td>';
                    $paco2 .= '<td class="'.date('d-m-YHi', strtotime($key)).'">'.(isset($value[$abg_test_list[5]]) ? $value[$abg_test_list[5]][0]->intf_ref_value : '-').'</td>';
                    $tcpco2 .= '<td class="'.date('d-m-YHi', strtotime($key)).'">'.(isset($value[$abg_test_list[6]]) ? $value[$abg_test_list[6]][0]->intf_ref_value : '-').'</td>';
                    $etco2 .= '<td class="'.date('d-m-YHi', strtotime($key)).'">'.(isset($value[$abg_test_list[7]]) ? $value[$abg_test_list[7]][0]->intf_ref_value : '-').'</td>';
                    $hco3 .= '<td class="'.date('d-m-YHi', strtotime($key)).'">'.(isset($value[$abg_test_list[8]]) ? $value[$abg_test_list[8]][0]->intf_ref_value : '-').'</td>';
                    $be .= '<td class="'.date('d-m-YHi', strtotime($key)).'">'.(isset($value[$abg_test_list[9]]) ? $value[$abg_test_list[9]][0]->intf_ref_value : '-').'</td>';
                    $na .= '<td class="'.date('d-m-YHi', strtotime($key)).'">'.(isset($value[$abg_test_list[10]]) ? $value[$abg_test_list[10]][0]->intf_ref_value : '-').'</td>';
                    $k .= '<td class="'.date('d-m-YHi', strtotime($key)).'">'.(isset($value[$abg_test_list[11]]) ? $value[$abg_test_list[11]][0]->intf_ref_value : '-').'</td>';
                    $calcium .= '<td class="'.date('d-m-YHi', strtotime($key)).'">'.(isset($value[$abg_test_list[12]]) ? $value[$abg_test_list[12]][0]->intf_ref_value : '-').'</td>';
                    $cl .= '<td class="'.date('d-m-YHi', strtotime($key)).'">'.(isset($value[$abg_test_list[13]]) ? $value[$abg_test_list[13]][0]->intf_ref_value : '-').'</td>';
                    $hb .= '<td class="'.date('d-m-YHi', strtotime($key)).'">'.(isset($value[$abg_test_list[14]]) ? $value[$abg_test_list[14]][0]->intf_ref_value : '-').'</td>';
                    $pcv .= '<td class="'.date('d-m-YHi', strtotime($key)).'">'.(isset($value[$abg_test_list[15]]) ? $value[$abg_test_list[15]][0]->intf_ref_value : '-').'</td>';
                    $lactate .= '<td class="'.date('d-m-YHi', strtotime($key)).'">'.(isset($value[$abg_test_list[16]]) ? $value[$abg_test_list[16]][0]->intf_ref_value : '-').'</td>';
                    $bilirubin .= '<td class="'.date('d-m-YHi', strtotime($key)).'">'.(isset($value[$abg_test_list[17]]) ? $value[$abg_test_list[17]][0]->intf_ref_value : '-').'</td>';
                    $blood_sugar .= '<td class="'.date('d-m-YHi', strtotime($key)).'">'.(isset($value[$abg_test_list[18]]) ? $value[$abg_test_list[18]][0]->intf_ref_value : '-').'</td>';
                    $blood_sugar_gm .= '<td class="'.date('d-m-YHi', strtotime($key)).'">'.(isset($value[$abg_test_list[19]]) ? $value[$abg_test_list[19]][0]->intf_ref_value : '-').'</td>';
                    $methemoglobin .= '<td class="'.date('d-m-YHi', strtotime($key)).'">'.(isset($value[$abg_test_list[20]]) ? $value[$abg_test_list[20]][0]->intf_ref_value : '-').'</td>';
                    @endphp
                    @endforeach

                    <table class="table hour-wise-table fixed" id="abg-table">
                        <thead>
                            <tr>
                                <th class="text-center">Field Name</th>
                                {!! $abg_date !!}
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Type Of Blood Gas</td>
                                {!! $type_of_blood_gas !!}
                            </tr>
                            <tr>
                                <td>Last BG at</td>
                                {!! $last_bg_at !!}
                            </tr>
                            <tr>
                                <td>pH</td>
                                {!! $ph !!}
                            </tr>
                            <tr>
                                <td>Pao2</td>
                                {!! $pao2 !!}
                            </tr>
                            <tr>
                                <td>TcPO2</td>
                                {!! $tcpo2 !!}
                            </tr>
                            <tr>
                                <td>PaCo2</td>
                                {!! $paco2 !!}
                            </tr>
                            <tr>
                                <td>TcPCO2</td>
                                {!! $tcpco2 !!}
                            </tr>
                            <tr>
                                <td>ETCO2</td>
                                {!! $etco2 !!}
                            </tr>
                            <tr>
                                <td>HCO3</td>
                                {!! $hco3 !!}
                            </tr>
                            <tr>
                                <td>BE</td>
                                {!! $be !!}
                            </tr>
                            <tr>
                                <td>Na (sodium) (mmol/L)</td>
                                {!! $na !!}
                            </tr>
                            <tr>
                                <td>K (potassium) (mmol/L)</td>
                                {!! $k !!}
                            </tr>
                            <tr>
                                <td>Calcium</td>
                                {!! $calcium !!}
                            </tr>
                            <tr>
                                <td>Cl (Chloride) (mmol/L)</td>
                                {!! $cl !!}
                            </tr>
                            <tr>
                                <td>HB (g/dL)</td>
                                {!! $hb !!}
                            </tr>
                            <tr>
                                <td>PCV (%)</td>
                                {!! $pcv !!}
                            </tr>
                            <tr>
                                <td>Lactate (mmol/L)</td>
                                {!! $lactate !!}
                            </tr>
                            <tr>
                                <td>Bilirubin (mg/dl)</td>
                                {!! $bilirubin !!}
                            </tr>
                            <tr>
                                <td>Blood Sugar (mg/dl)(Blood Gas)</td>
                                {!! $blood_sugar !!}
                            </tr>
                            <tr>
                                <td>Blood Sugar (mg/dl)(Glucometer)</td>
                                {!! $blood_sugar_gm !!}
                            </tr>
                            <tr>
                                <td>Methemoglobin</td>
                                {!! $methemoglobin !!}
                            </tr>
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

