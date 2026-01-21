@extends('print')
@section('content')
<div class="temp-container nurse-sheet" id="lab-print">
    <div class="temp-row mb-0">
        <div class="col-md-12 plr-must-0">
            <div class="col-md-4 col-sm-4 col-xs-12 plr-must-0">
                <img src="{{ ValuelistHelpers::printPagelogo() }}">
            </div>
            <div class="col-md-4 col-sm-4 col-xs-4 plr-must-0">
                <div class="text-center">
                    <h4 class="m-0"><b>Form No. 2</b></h4>
                    <h4>INVESTIGATION CHART</h4>
                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-4 plr-must-0 barcode text-center">
                @if(!empty($ip_details->ip_number) && !is_null($ip_details->ip_number))
                <table>
                    <tr>
                        <td style="padding: 0px !important"></td>
                        <td style="padding: 0px 0px 0px 5px !important;">
                            <div class="col-md-6 plr-must-0">
                                <b style="font-size: 16px;" class="pull-left">{{$ip_details->ip_number}}</b>
                            </div>
                            <div class="col-md-6 plr-must-0">
                                <span class="baby-mrn">{{ $baby->BMrNo }}</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><b class="hosptial-name">SKSH</b></td>
                        <td>
                            <span class="barcode-content">
                                @php $ipnumber = str_replace('IP/', '01', $ip_details->ip_number); @endphp
                                <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($ipnumber, 'C128', 2, 38)}}" alt="barcode" />
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding-bottom: 0px !important">{{ str_replace('B/O ', 'Baby of.', $baby->BabyName) }}&nbsp/&nbsp{{ substr($baby->Sex, 0, 1) }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="padding-bottom: 0px !important">
                            <!-- {{ \SiteHelpers::get_doctors_name($baby->neonatal_consultant) }} -->
                        </td>
                    </tr>
                </table>
                @else
                <span class="empty">Affix Barcode Label Here</span>
                @endif
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12 basic-detail plr-must-0">
            <h4 class="mt-0">Basic Details</h4>
            <div class="content-block">
                <table class="table-layout-fixed">
                    <tbody>
                        <tr>
                            <td><strong>Name:</strong> <span class="font-normal">{{ $baby->BabyName }}</span></td>
                            <td><strong>{{ Lang::get('home.mrn') }}:</strong> <span class="font-normal">{{ $baby->BMrNo }}</span></td>
                            <td><strong>{{ Lang::get('home.ip') }}:</strong> <span class="font-normal">{{ (!empty($ip_details->ip_number) && !is_null($ip_details->ip_number)) ? $ip_details->ip_number : null }}</span></td>
                        </tr>
                        <tr>
                            <td><strong>DOB:</strong> <span class="font-normal">{{ empty($baby->DOB) ? '' : date('d-m-Y', strtotime($baby->DOB)) }}</span></td>
                            <td><strong>Sex:</strong> <span class="font-normal">{{ $baby->Sex }}</span></td>
                        </tr>
                        <tr>
                            <td colspan="5"><strong>Consultant:</strong> <span class="font-normal">{{ \SiteHelpers::get_doctors_name($baby->neonatal_consultant) }}</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="sort-btn-lab">
                <label class="mt-10">Sort By</label>
                <input id="sort_order" data-on="Desc" data-off="Asc" data-toggle="toggle" data-width="70" data-size="small" class="form-control" type="checkbox" @if(isset($order) && $order == 'desc') checked @endif>
            </div>
        </div>
        <div role="tabpanel" class="tabbable tabbable-custom">
            <ul class="nav nav-tabs hidden-print" role="tablist">
                <li role="presentation" class="active">
                    <a href="#hb" role="tab" data-toggle="tab">Haematology and Biochemistry</a>
                </li>
                <li role="presentation">
                    <a href="#ucs" role="tab" data-toggle="tab">Urine, CSF, Stool</a>
                </li>
                <li role="presentation">
                    <a href="#microbiology" role="tab" data-toggle="tab">Microbiology</a>
                </li>
                <li role="presentation">
                    <a href="#pending-requests" role="tab" data-toggle="tab">Requested Lab Test</a>
                    <span @if($pending_results_count > 0) class="request-count" @endif>@if($pending_results_count > 0) {{ $pending_results_count }} @endif</span>
                </li>
                <li role="presentation">
                    <a href="#abg" role="tab" data-toggle="tab">ABG Test</a>
                </li>
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
                                    @foreach($first_tab_sheet_id as $key => $day_id)
                                    @php
                                    $date = date('d-m-Y H:i', strtotime($day_id));
                                    $tooltip_text = '';
                                    if (isset($material_name[$key]) && !empty($material_name[$key]) && count($material_name[$key]) > 0) {
                                        $tooltip_text =implode("<br/>",$material_name[$key]);
                                    }
                                    @endphp
                                    <th class="{{ str_slug(date('d-m-YHi', strtotime($day_id))) }}">{{ date('d-m-Y', strtotime($day_id)) }} <br><small>({{ date('H:i', strtotime($day_id)) }})</small> @if($tooltip_text != '' )<i class="material-name fa fa-info-circle bs-tooltip color-black-must hidden-print" data-toggle="tooltip" data-placement="right" data-html="true" data-title="{{ $tooltip_text }}"></i>@endif</th>
                                    @endforeach     
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Create All values and display items  -->
                                <?php
                                $sodium_display_content = $potassium_display_content = $chloride_display_content = $bicarbonate_display_content = $magnesium_display_content = $bun_urea_display_content = $creatintine_display_content = $phosphorus_display_content = $glucose_display_content = $creatine_kinase_display_content = $ck_mb_display_content = $direct_bilirubin_display_content = $total_bilirubin_display_content = $trop_display_content = $sgot_display_content = $calcium_display_content = $sgpt_display_content = $alkaline_phosphatase_display_content = $ldh_display_content = $gama_gtp_display_content = $amylase_display_content = $lipase_display_content = $total_protein_display_content = $albumin_display_content = $total_cholesterol_display_content = $hdl_display_content = $ldl_display_content = $vldl_display_content = $rbc_display_content = $haemoglobin_display_content = $tri_glycerides_display_content = $haematocrit_display_content = $reticulocyte_count_display_content = $wbc_total_count_display_content = $dc_poly_display_content = $lymph_display_content = $mono_display_content = $eos_display_content = $baso_display_content = $esr_display_content = $platelets_display_content = $prothrombin_time_display_content = $aptt_display_content = $inr_display_content = $fibrinogen_display_content = $fdp_display_content = $crp_display_content = $tsh_display_content = $blood_group_display_content = $vitamin_d3_display_content = $parathormone_display_content = '';

                                    // $specific_gravity_content = $osmolality_content = $urine_glucose_content = $protein_content = $salts_content = $pigments_content = $puscells_content = $rbc_content = $blood_content = $heamoglobin_content = $casts_content = $sodium_content = $fena_content = $potassium_content = $chloride_content = $creatintine_content = $clearance_content = $sputum_content = $urine_content = $bloodstain_content = $catheter_content = $widal_content =  '';

                                $urine_specific_gravity_display_content = $urine_ph_display_content = $urine_protein_display_content = $urine_glucose_display_content = $urine_bilirubin_display_content = $urine_urobilinogen_display_content = $urine_ketones_display_content = $urine_nitrate_display_content = $urine_pus_cells_display_content = $urine_rbc_display_content = $urine_epithelial_cells_display_content = $urine_crystals_display_content = $urine_casts_display_content = $urine_osmolality_display_content = $urine_bile_salts_display_content = $urine_bile_pigments_display_content = $urine_blood_display_content = $urine_heamoglobin_display_content = $urine_spot_sodium_display_content = $urine_fena_display_content = $urine_spot_potassium_display_content = $urine_spot_chloride_display_content = $urine_spot_creatinine_display_content = $urine_creatinine_clearance_display_content = $urine_others_display_content = $csf_proteins_display_content = $csf_glucose_display_content = $csf_cell_count_display_content = $csf_gram_stain_display_content = $afbstain_content = $miscellaneous_content = $stool_wbc_display_content = $stool_occult_blood_display_content = $stool_ova_parasites_display_content = $miscellaneous_display_content = $afbstain_display_content = $urnine_leukocytes_esterases_display_content = $csf_rbc_display_content = $csf_neutrophils_display_content = $csf_lymphocytes_display_content = $csf_eosinophils_display_content = '';

                                $ft4_display_content = $ft3_display_content = $ammonia_display_content = $lactate_display_content = $dct_display_content = $procalcitonin_display_content = '';

                                $empty_content = $second_tab_empty_content = '';

                                /*FOR First tab results ( BIOCHEMISTRY AND HAEMATOLOGY)*/
                                foreach ($first_tab_sheet_id as $key=>$day_id)
                                {
                                    $date = $key;
                                    if (isset($result[$date]))
                                    {

                                        $temp_data = $result[$date];
                                        $sodium_values = collect($temp_data)->where('local_code', $lab_report_observe[41])->first();
                                        $potassium_values = collect($temp_data)->where('local_code', $lab_report_observe[42])->first();
                                        $chloride_values = collect($temp_data)->where('local_code', $lab_report_observe[43])->first();
                                        $bicarbonate_values = collect($temp_data)->where('local_code', $lab_report_observe[44])->first();
                                        $calcium_values = collect($temp_data)->where('local_code', $lab_report_observe[0])->first();
                                        $magnesium_values = collect($temp_data)->where('local_code', $lab_report_observe[1])->first();
                                        $phosphorus_values = collect($temp_data)->where('local_code', $lab_report_observe[2])->first();
                                        $bun_urea_values = collect($temp_data)->where('local_code', $lab_report_observe[3])->first();
                                        $creatintine_values = collect($temp_data)->where('local_code', $lab_report_observe[4])->first();
                                        $glucose_values = collect($temp_data)->where('local_code', $lab_report_observe[5])->first();
                                        $creatine_kinase_values = collect($temp_data)->where('local_code', $lab_report_observe[6])->first();
                                        $ck_mb_values = collect($temp_data)->where('local_code', $lab_report_observe[7])->first();
                                        $trop_values = collect($temp_data)->where('local_code', $lab_report_observe[8])->first();
                                        $total_bilirubin_values = collect($temp_data)->where('local_code', $lab_report_observe[9])->first();
                                        $direct_bilirubin_values = collect($temp_data)->where('local_code', $lab_report_observe[10])->first();
                                        $sgot_values = collect($temp_data)->where('local_code', $lab_report_observe[11])->first();
                                        $sgpt_values = collect($temp_data)->where('local_code', $lab_report_observe[12])->first();
                                        $alkaline_phosphatase_values = collect($temp_data)->where('local_code', $lab_report_observe[13])->first();
                                        $gama_gtp_values = collect($temp_data)->where('local_code', $lab_report_observe[14])->first();
                                        $ldh_values = collect($temp_data)->where('local_code', $lab_report_observe[15])->first();
                                        $amylase_values = collect($temp_data)->where('local_code', $lab_report_observe[16])->first();
                                        $lipase_values = collect($temp_data)->where('local_code', $lab_report_observe[17])->first();
                                        $total_protein_values = collect($temp_data)->where('local_code', $lab_report_observe[18])->first();
                                        $albumin_values = collect($temp_data)->where('local_code', $lab_report_observe[19])->first();
                                        $total_cholesterol_values = collect($temp_data)->where('local_code', $lab_report_observe[20])->first();
                                        $hdl_values = collect($temp_data)->where('local_code', $lab_report_observe[21])->first();
                                        $ldl_values = collect($temp_data)->where('local_code', $lab_report_observe[22])->first();
                                        $vldl_values = collect($temp_data)->where('local_code', $lab_report_observe[23])->first();
                                        $tri_glycerides_values = collect($temp_data)->where('local_code', $lab_report_observe[24])->first();
                                        $tsh_values = collect($temp_data)->where('local_code', $lab_report_observe[47])->first();

                                        $rbc_values = collect($temp_data)->where('local_code', $lab_report_observe[25])->first();
                                        $haemoglobin_values = collect($temp_data)->where('local_code', $lab_report_observe[45])->first();
                                        $haematocrit_values = collect($temp_data)->where('local_code', 'blood_gas_pcv')->first();
                                        $reticulocyte_count_values = collect($temp_data)->where('local_code', $lab_report_observe[27])->first();
                                        $wbc_total_count_values = collect($temp_data)->where('local_code', $lab_report_observe[28])->first();
                                        $dc_poly_values = collect($temp_data)->where('local_code', $lab_report_observe[29])->first();
                                        $lymph_values = collect($temp_data)->where('local_code', $lab_report_observe[30])->first();
                                        $mono_values = collect($temp_data)->where('local_code', $lab_report_observe[31])->first();
                                        $eos_values = collect($temp_data)->where('local_code', $lab_report_observe[32])->first();
                                        $baso_values = collect($temp_data)->where('local_code', $lab_report_observe[33])->first();
                                        $platelets_values = collect($temp_data)->where('local_code', $lab_report_observe[34])->first();
                                        $esr_values = collect($temp_data)->where('local_code', $lab_report_observe[35])->first();
                                        $prothrombin_time_values = collect($temp_data)->where('local_code', 'gluco_meter_prothrombintime')->first();
                                        $prothrombin_test_values = collect($temp_data)->where('local_code', 'gluco_meter_prothrombintime_test')->first();
                                        $aptt_values = collect($temp_data)->where('local_code', $lab_report_observe[37])->first();
                                        $aptt_control_values = collect($temp_data)->where('local_code', 'gluco_meter_aptt_control')->first();
                                        $inr_values = collect($temp_data)->where('local_code', $lab_report_observe[38])->first();
                                        $fibrinogen_values = collect($temp_data)->where('local_code', $lab_report_observe[39])->first();
                                        $fdp_values = collect($temp_data)->where('local_code', $lab_report_observe[40])->first();
                                        $crp_values = collect($temp_data)->where('local_code', 'gluco_meter_crp')->first();
                                        $blood_group_values = collect($temp_data)->where('local_code', 'blood_group')->first();
                                        $blood_rh_type_values = collect($temp_data)->where('local_code', 'blood_rh_type')->first();
                                        $vitamin_d3_values = collect($temp_data)->where('local_code', 'vitamin_d3')->first();
                                        $parathormone_values = collect($temp_data)->where('local_code', 'parathormone')->first();

                                        $date = str_slug(date('d-m-YHi', strtotime($day_id)));

                                        if (!empty($blood_group_values->intf_ref_value) && !empty($blood_rh_type_values->intf_ref_value))
                                        {
                                            $blood_group_display_content .= '<td class="' . $date . '">' . $blood_group_values->intf_ref_value . ' ' . ucfirst(strtolower($blood_rh_type_values->intf_ref_value)) . '</td>';
                                        }
                                        else
                                        {
                                            $blood_group_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($parathormone_values->intf_ref_value))
                                        {
                                            if (isset($parathormone_values->result_status) && $parathormone_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $parathormone_display_content .= '<td class="' . $date . ' ' . $status . '">' . $parathormone_values->intf_ref_value . '</td>';
                                        } else {
                                            $parathormone_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($vitamin_d3_values->intf_ref_value))
                                        {
                                            if (isset($vitamin_d3_values->result_status) && $vitamin_d3_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $vitamin_d3_display_content .= '<td class="' . $date . ' ' . $status . '">' . $vitamin_d3_values->intf_ref_value . '</td>';
                                        } else {
                                            $vitamin_d3_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($tsh_values->intf_ref_value))
                                        {
                                            if (isset($tsh_values->result_status) && $tsh_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $tsh_display_content .= '<td class="' . $date . ' ' . $status . '">' . $tsh_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $tsh_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($crp_values->intf_ref_value))
                                        {
                                            if (isset($crp_values->result_status) && $crp_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $crp_display_content .= '<td class="' . $date . ' ' . $status . ' crp-values">' . str_replace(array('NEGATIVE', 'POSITIVE'), array('-', '+'), $crp_values->intf_ref_value) . '</td>';
                                        }
                                        else
                                        {
                                            $crp_display_content .= '<td class="' . $date . ' crp-values">-</td>';
                                        }

                                        if (!empty($fdp_values->intf_ref_value))
                                        {
                                            if (isset($fdp_values->result_status) && $fdp_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $fdp_display_content .= '<td class="' . $date . ' ' . $status . '">' . $fdp_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $fdp_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($fibrinogen_values->intf_ref_value))
                                        {
                                            if (isset($fibrinogen_values->result_status) && $fibrinogen_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $fibrinogen_display_content .= '<td class="' . $date . ' ' . $status . '">' . $fibrinogen_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $fibrinogen_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($inr_values->intf_ref_value))
                                        {
                                            if (isset($inr_values->result_status) && $inr_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $inr_display_content .= '<td class="' . $date . ' ' . $status . '">' . $inr_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $inr_display_content .= '<td class="' . $date . '">-</td>';
                                        }
                                        if (!empty($aptt_values->intf_ref_value))
                                        {
                                            if (isset($aptt_values->result_status) && $aptt_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }

                                            $aptt_control_display = '';
                                            if (isset($aptt_control_values->intf_ref_value) && !empty($aptt_control_values->intf_ref_value)) {
                                                $aptt_control_display = $aptt_control_values->intf_ref_value;
                                            }

                                            if ($aptt_control_display != '') {
                                                $aptt_display_content .= '<td class="' . $date . ' ' . $status . '">' . $aptt_values->intf_ref_value . ' ('. $aptt_control_display.')</td>';
                                            } else {
                                                $aptt_display_content .= '<td class="' . $date . ' ' . $status . '">' . $aptt_values->intf_ref_value . '</td>';
                                            }

                                        }
                                        else
                                        {
                                            $aptt_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($prothrombin_time_values->intf_ref_value))
                                        {
                                            if (isset($prothrombin_time_values->result_status) && $prothrombin_time_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $parathormone_test_display = '';
                                            if (isset($prothrombin_test_values->intf_ref_value) && !empty($prothrombin_test_values->intf_ref_value)) {
                                                $parathormone_test_display = $prothrombin_test_values->intf_ref_value;
                                            }

                                            if ($parathormone_test_display != '') {
                                                $prothrombin_time_display_content .= '<td class="' . $date . ' ' . $status . '">' . $parathormone_test_display .' ('.$prothrombin_time_values->intf_ref_value . ')</td>';
                                            } else {
                                                $prothrombin_time_display_content .= '<td class="' . $date . ' ' . $status . '">' . $prothrombin_time_values->intf_ref_value . '</td>';
                                            }
                                        }
                                        else
                                        {
                                            $prothrombin_time_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($esr_values->intf_ref_value))
                                        {
                                            if (isset($esr_values->result_status) && $esr_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $esr_display_content .= '<td class="' . $date . ' ' . $status . '">' . $esr_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $esr_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($platelets_values->intf_ref_value))
                                        {
                                            if (isset($platelets_values->result_status) && $platelets_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $platelets_display_content .= '<td class="' . $date . ' ' . $status . '">' . $platelets_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $platelets_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($baso_values->intf_ref_value))
                                        {
                                            if (isset($baso_values->result_status) && $baso_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $baso_display_content .= '<td class="' . $date . ' ' . $status . '">' . $baso_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $baso_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($eos_values->intf_ref_value))
                                        {
                                            if (isset($eos_values->result_status) && $eos_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $eos_display_content .= '<td class="' . $date . ' ' . $status . '">' . $eos_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $eos_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($mono_values->intf_ref_value))
                                        {
                                            if (isset($mono_values->result_status) && $mono_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $mono_display_content .= '<td class="' . $date . ' ' . $status . '">' . $mono_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $mono_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($lymph_values->intf_ref_value))
                                        {
                                            if (isset($lymph_values->result_status) && $lymph_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $lymph_display_content .= '<td class="' . $date . ' ' . $status . '">' . $lymph_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $lymph_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($dc_poly_values->intf_ref_value))
                                        {
                                            if (isset($dc_poly_values->result_status) && $dc_poly_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $dc_poly_display_content .= '<td class="' . $date . ' ' . $status . '">' . $dc_poly_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $dc_poly_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($wbc_total_count_values->intf_ref_value))
                                        {
                                            if (isset($wbc_total_count_values->result_status) && $wbc_total_count_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $wbc_total_count_display_content .= '<td class="' . $date . ' ' . $status . '">' . $wbc_total_count_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $wbc_total_count_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($reticulocyte_count_values->intf_ref_value))
                                        {
                                            if (isset($reticulocyte_count_values->result_status) && $reticulocyte_count_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $reticulocyte_count_display_content .= '<td class="' . $date . ' ' . $status . '">' . $reticulocyte_count_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $reticulocyte_count_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($haematocrit_values->intf_ref_value))
                                        {
                                            if (isset($haematocrit_values->result_status) && $haematocrit_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $haematocrit_display_content .= '<td class="' . $date . ' ' . $status . '">' . $haematocrit_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $haematocrit_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($haemoglobin_values->intf_ref_value))
                                        {
                                            if (isset($haemoglobin_values->result_status) && $haemoglobin_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $haemoglobin_display_content .= '<td class="' . $date . ' ' . $status . '">' . $haemoglobin_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $haemoglobin_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($rbc_values->intf_ref_value))
                                        {
                                            if (isset($rbc_values->result_status) && $rbc_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $rbc_display_content .= '<td class="' . $date . ' ' . $status . '">' . $rbc_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $rbc_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($tri_glycerides_values->intf_ref_value))
                                        {
                                            if (isset($tri_glycerides_values->result_status) && $tri_glycerides_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $tri_glycerides_display_content .= '<td class="' . $date . ' ' . $status . '">' . $tri_glycerides_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $tri_glycerides_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($vldl_values->intf_ref_value))
                                        {
                                            if (isset($vldl_values->result_status) && $vldl_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $vldl_display_content .= '<td class="' . $date . ' ' . $status . '">' . $vldl_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $vldl_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($ldl_values->intf_ref_value))
                                        {
                                            if (isset($ldl_values->result_status) && $ldl_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $ldl_display_content .= '<td class="' . $date . ' ' . $status . '">' . $ldl_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $ldl_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($hdl_values->intf_ref_value))
                                        {
                                            if (isset($hdl_values->result_status) && $hdl_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $hdl_display_content .= '<td class="' . $date . ' ' . $status . '">' . $hdl_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $hdl_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($total_cholesterol_values->intf_ref_value))
                                        {
                                            if (isset($total_cholesterol_values->result_status) && $total_cholesterol_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $total_cholesterol_display_content .= '<td class="' . $date . ' ' . $status . '">' . $total_cholesterol_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $total_cholesterol_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($albumin_values->intf_ref_value))
                                        {
                                            if (isset($albumin_values->result_status) && $albumin_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $albumin_display_content .= '<td class="' . $date . ' ' . $status . '">' . $albumin_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $albumin_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($total_protein_values->intf_ref_value))
                                        {
                                            if (isset($total_protein_values->result_status) && $total_protein_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $total_protein_display_content .= '<td class="' . $date . ' ' . $status . '">' . $total_protein_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $total_protein_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($lipase_values->intf_ref_value))
                                        {
                                            if (isset($lipase_values->result_status) && $lipase_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $lipase_display_content .= '<td class="' . $date . ' ' . $status . '">' . $lipase_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $lipase_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($amylase_values->intf_ref_value))
                                        {
                                            if (isset($amylase_values->result_status) && $amylase_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $amylase_display_content .= '<td class="' . $date . ' ' . $status . '">' . $amylase_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $amylase_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($ldh_values->intf_ref_value))
                                        {
                                            if (isset($ldh_values->result_status) && $ldh_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $ldh_display_content .= '<td class="' . $date . ' ' . $status . '">' . $ldh_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $ldh_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($gama_gtp_values->intf_ref_value))
                                        {
                                            if (isset($gama_gtp_values->result_status) && $gama_gtp_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $gama_gtp_display_content .= '<td class="' . $date . ' ' . $status . '">' . $gama_gtp_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $gama_gtp_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($alkaline_phosphatase_values->intf_ref_value))
                                        {
                                            if (isset($alkaline_phosphatase_values->result_status) && $alkaline_phosphatase_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $alkaline_phosphatase_display_content .= '<td class="' . $date . ' ' . $status . '">' . $alkaline_phosphatase_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $alkaline_phosphatase_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($sgpt_values->intf_ref_value))
                                        {
                                            if (isset($sgpt_values->result_status) && $sgpt_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $sgpt_display_content .= '<td class="' . $date . ' ' . $status . '">' . $sgpt_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $sgpt_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($sgot_values->intf_ref_value))
                                        {
                                            if (isset($sgot_values->result_status) && $sgot_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $sgot_display_content .= '<td class="' . $date . ' ' . $status . '">' . $sgot_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $sgot_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($direct_bilirubin_values->intf_ref_value))
                                        {
                                            if (isset($direct_bilirubin_values->result_status) && $direct_bilirubin_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $direct_bilirubin_display_content .= '<td class="' . $date . ' ' . $status . '">' . $direct_bilirubin_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $direct_bilirubin_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($total_bilirubin_values->intf_ref_value))
                                        {
                                            if (isset($total_bilirubin_values->result_status) && $total_bilirubin_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $total_bilirubin_display_content .= '<td class="' . $date . ' ' . $status . '">' . $total_bilirubin_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $total_bilirubin_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($trop_values->intf_ref_value))
                                        {
                                            if (isset($trop_values->result_status) && $trop_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $trop_display_content .= '<td class="' . $date . ' ' . $status . '">' . $trop_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $trop_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($ck_mb_values->intf_ref_value))
                                        {
                                            if (isset($ck_mb_values->result_status) && $ck_mb_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $ck_mb_display_content .= '<td class="' . $date . ' ' . $status . '">' . $ck_mb_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $ck_mb_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($creatine_kinase_values->intf_ref_value))
                                        {
                                            if (isset($creatine_kinase_values->result_status) && $creatine_kinase_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $creatine_kinase_display_content .= '<td class="' . $date . ' ' . $status . '">' . $creatine_kinase_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $creatine_kinase_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($glucose_values->intf_ref_value))
                                        {
                                            if (isset($glucose_values->result_status) && $glucose_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $glucose_display_content .= '<td class="' . $date . ' ' . $status . '">' . $glucose_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $glucose_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($creatintine_values->intf_ref_value))
                                        {
                                            if (isset($creatintine_values->result_status) && $creatintine_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $creatintine_display_content .= '<td class="' . $date . ' ' . $status . '">' . $creatintine_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $creatintine_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($bun_urea_values->intf_ref_value))
                                        {
                                            if (isset($bun_urea_values->result_status) && $bun_urea_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $bun_urea_display_content .= '<td class="' . $date . ' ' . $status . '">' . $bun_urea_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $bun_urea_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($phosphorus_values->intf_ref_value))
                                        {
                                            if (isset($phosphorus_values->result_status) && $phosphorus_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $phosphorus_display_content .= '<td class="' . $date . ' ' . $status . '">' . $phosphorus_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $phosphorus_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($sodium_values->intf_ref_value))
                                        {
                                            if (isset($sodium_values->result_status) && $sodium_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $sodium_display_content .= '<td class="' . $date . ' ' . $status . '">' . $sodium_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $sodium_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($potassium_values->intf_ref_value))
                                        {
                                            if (isset($potassium_values->result_status) && $potassium_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $potassium_display_content .= '<td class="' . $date . ' ' . $status . '">' . $potassium_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $potassium_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($chloride_values->intf_ref_value))
                                        {
                                            if (isset($chloride_values->result_status) && $chloride_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $chloride_display_content .= '<td class="' . $date . ' ' . $status . '">' . $chloride_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $chloride_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($bicarbonate_values->intf_ref_value))
                                        {
                                            if (isset($bicarbonate_values->result_status) && $bicarbonate_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $bicarbonate_display_content .= '<td class="' . $date . ' ' . $status . '">' . $bicarbonate_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $bicarbonate_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($calcium_values->intf_ref_value))
                                        {
                                            if (isset($calcium_values->result_status) && $calcium_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $calcium_display_content .= '<td class="' . $date . ' ' . $status . '">' . $calcium_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $calcium_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($magnesium_values->intf_ref_value))
                                        {
                                            if (isset($magnesium_values->result_status) && $magnesium_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $magnesium_display_content .= '<td class="' . $date . ' ' . $status . '">' . $magnesium_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $magnesium_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        $empty_content .= '<td class="' . $date . '">-</td>';

                                        $ft4_value = collect($temp_data)->where('local_code', 'free_t4')->first();
                                        $ft3_value = collect($temp_data)->where('local_code', 'free_t3')->first();
                                        $ammonia_value = collect($temp_data)->where('local_code', 'ammonia')->first();
                                        $lactate_value = collect($temp_data)->where('local_code', 'lactate')->first();
                                        $dct_value = collect($temp_data)->where('local_code', 'direct_cooms')->first();
                                        $procalcitonin_value = collect($temp_data)->where('local_code', 'procalcitonin')->first();

                                        if (!empty($ft4_value->intf_ref_value))
                                        {
                                            if (isset($ft4_value->result_status) && $ft4_value->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $ft4_display_content .= '<td class="' . $date . ' ' . $status . '">' . $ft4_value->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $ft4_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($ft3_value->intf_ref_value))
                                        {
                                            if (isset($ft3_value->result_status) && $ft3_value->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $ft3_display_content .= '<td class="' . $date . ' ' . $status . '">' . $ft3_value->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $ft3_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($ammonia_value->intf_ref_value))
                                        {
                                            if (isset($ammonia_value->result_status) && $ammonia_value->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $ammonia_display_content .= '<td class="' . $date . ' ' . $status . '">' . $ammonia_value->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $ammonia_display_content .= '<td class="' . $date . '">-</td>';
                                        }
                                        
                                        if (!empty($lactate_value->intf_ref_value))
                                        {
                                            if (isset($lactate_value->result_status) && $lactate_value->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $lactate_display_content .= '<td class="' . $date . ' ' . $status . '">' . $lactate_value->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $lactate_display_content .= '<td class="' . $date . '">-</td>';
                                        }
                                        
                                        if (!empty($dct_value->intf_ref_value))
                                        {
                                            if (isset($dct_value->result_status) && $dct_value->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $dct_display_content .= '<td class="' . $date . ' ' . $status . '">' . $dct_value->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $dct_display_content .= '<td class="' . $date . '">-</td>';
                                        }
                                        
                                        if (!empty($procalcitonin_value->intf_ref_value))
                                        {
                                            if (isset($procalcitonin_value->result_status) && $procalcitonin_value->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $procalcitonin_display_content .= '<td class="' . $date . ' ' . $status . '">' . $procalcitonin_value->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $procalcitonin_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                    }
                                }
                                foreach ($second_tab_sheet_id as $day_id)
                                {
                                    $date = $day_id;
                                    if (isset($second_tab_result[$date]))
                                    {

                                        $temp_data = $second_tab_result[$date];
                                        $urine_specific_gravity_values = collect($temp_data)->where('local_code', 'urine_specific_gravity')->first();
                                        $urine_ph_values = collect($temp_data)->where('local_code', 'urine_ph')->first();
                                        $urine_protein_values = collect($temp_data)->where('local_code', 'urine_protein')->first();
                                        $urine_glucose_values = collect($temp_data)->where('local_code', 'urine_glucose')->first();
                                        $urine_bilirubin_values = collect($temp_data)->where('local_code', 'urine_bilirubin')->first();
                                        $urine_urobilinogen_values = collect($temp_data)->where('local_code', 'urine_urobilinogen')->first();
                                        $urine_ketones_values = collect($temp_data)->where('local_code', 'urine_ketones')->first();
                                        $urine_nitrate_values = collect($temp_data)->where('local_code', 'urine_nitrate')->first();
                                        $urine_pus_cells_values = collect($temp_data)->where('local_code', 'urine_pus_cells')->first();
                                        $urine_rbc_values = collect($temp_data)->where('local_code', 'urine_rbc')->first();
                                        $urine_epithelial_cells_values = collect($temp_data)->where('local_code', 'urine_epithelial_cells')->first();
                                        $urine_crystals_values = collect($temp_data)->where('local_code', 'urine_crystals')->first();
                                        $urine_casts_values = collect($temp_data)->where('local_code', 'urine_casts')->first();
                                        $urine_osmolality_values = collect($temp_data)->where('local_code', 'urine_osmolality')->first();
                                        $urine_bile_salts_values = collect($temp_data)->where('local_code', 'urine_bile_salts')->first();
                                        $urine_bile_pigments_values = collect($temp_data)->where('local_code', 'urine_bile_pigments')->first();
                                        $urine_blood_values = collect($temp_data)->where('local_code', 'urine_blood')->first();
                                        $urine_heamoglobin_values = collect($temp_data)->where('local_code', 'urine_heamoglobin')->first();
                                        $urine_spot_sodium_values = collect($temp_data)->where('local_code', 'urine_spot_sodium')->first();
                                        $urine_fena_values = collect($temp_data)->where('local_code', 'urine_fe_na')->first();
                                        $urine_spot_potassium_values = collect($temp_data)->where('local_code', 'urine_spot_potassium')->first();
                                        $urine_spot_chloride_values = collect($temp_data)->where('local_code', 'urine_spot_chloride')->first();
                                        $urine_spot_creatinine_values = collect($temp_data)->where('local_code', 'urine_spot_creatinine')->first();
                                        $urine_creatinine_clearance_values = collect($temp_data)->where('local_code', 'urine_creatinine_clearance')->first();
                                        $urine_others_values = collect($temp_data)->where('local_code', 'urine_others')->first();
                                        $urnine_leukocytes_esterases_values = collect($temp_data)->where('local_code', 'urnine_leukocytes_esterases')->first();

                                        $csf_proteins_values = collect($temp_data)->where('local_code', 'csf_proteins')->first();
                                        $csf_glucose_values = collect($temp_data)->where('local_code', 'csf_glucose')->first();
                                        $csf_cell_count_values = collect($temp_data)->where('local_code', 'csf_cell_count')->first();
                                        $csf_gram_stain_values = collect($temp_data)->where('local_code', 'csf_gram_stain')->first();
                                        $csf_rbc_values = collect($temp_data)->where('local_code', 'csf_rbc')->first();
                                        $csf_neutrophils_values = collect($temp_data)->where('local_code', 'csf_neutrophils')->first();
                                        $csf_lymphocytes_values = collect($temp_data)->where('local_code', 'csf_lymphocytes')->first();
                                        $csf_eosinophils_values = collect($temp_data)->where('local_code', 'csf_eosinophils')->first();

                                        $afbstain_values = collect($temp_data)->where('local_code', $lab_report_observe[46])->first();
                                        $miscellaneous_values = collect($temp_data)->where('local_code', $lab_report_observe[46])->first();

                                        $stool_wbc_values = collect($temp_data)->where('local_code', 'stool_wbc')->first();
                                        $stool_occult_blood_values = collect($temp_data)->where('local_code', 'stool_occult_blood')->first();
                                        $stool_ova_parasites_values = collect($temp_data)->where('local_code', 'stool_ova_parasites')->first();

                                        $date = str_slug(date('d-m-YHi', strtotime($day_id)));

                                        if (!empty($csf_eosinophils_values->intf_ref_value))
                                        {
                                            if (isset($csf_eosinophils_values->result_status) && $csf_eosinophils_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $csf_eosinophils_display_content .= '<td class="' . $date . ' ' . $status . '">' . $csf_eosinophils_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $csf_eosinophils_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($csf_lymphocytes_values->intf_ref_value))
                                        {
                                            if (isset($csf_lymphocytes_values->result_status) && $csf_lymphocytes_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $csf_lymphocytes_display_content .= '<td class="' . $date . ' ' . $status . '">' . $csf_lymphocytes_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $csf_lymphocytes_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($csf_neutrophils_values->intf_ref_value))
                                        {
                                            if (isset($csf_neutrophils_values->result_status) && $csf_neutrophils_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $csf_neutrophils_display_content .= '<td class="' . $date . ' ' . $status . '">' . $csf_neutrophils_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $csf_neutrophils_display_content .= '<td class="' . $date . '">-</td>';
                                        }
                                        if (!empty($csf_rbc_values->intf_ref_value))
                                        {
                                            if (isset($csf_rbc_values->result_status) && $csf_rbc_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $csf_rbc_display_content .= '<td class="' . $date . ' ' . $status . '">' . $csf_rbc_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $csf_rbc_display_content .= '<td class="' . $date . '">-</td>';
                                        }
                                        if (!empty($urnine_leukocytes_esterases_values->intf_ref_value))
                                        {
                                            if (isset($urnine_leukocytes_esterases_values->result_status) && $urnine_leukocytes_esterases_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $urnine_leukocytes_esterases_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urnine_leukocytes_esterases_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $urnine_leukocytes_esterases_display_content .= '<td class="' . $date . '">-</td>';
                                        }
                                        if (!empty($stool_ova_parasites_values->intf_ref_value))
                                        {
                                            if (isset($stool_ova_parasites_values->result_status) && $stool_ova_parasites_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $stool_ova_parasites_display_content .= '<td class="' . $date . ' ' . $status . '">' . $stool_ova_parasites_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $stool_ova_parasites_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($stool_occult_blood_values->intf_ref_value))
                                        {
                                            if (isset($stool_occult_blood_values->result_status) && $stool_occult_blood_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $stool_occult_blood_display_content .= '<td class="' . $date . ' ' . $status . '">' . $stool_occult_blood_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $stool_occult_blood_display_content .= '<td class="' . $date . '">-</td>';
                                        }
                                        if (!empty($stool_wbc_values->intf_ref_value))
                                        {
                                            if (isset($stool_wbc_values->result_status) && $stool_wbc_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $stool_wbc_display_content .= '<td class="' . $date . ' ' . $status . '">' . $stool_wbc_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $stool_wbc_display_content .= '<td class="' . $date . '">-</td>';
                                        }
                                        if (!empty($miscellaneous_values->intf_ref_value))
                                        {
                                            if (isset($miscellaneous_values->result_status) && $miscellaneous_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $miscellaneous_display_content .= '<td class="' . $date . ' ' . $status . '">' . $miscellaneous_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $miscellaneous_display_content .= '<td class="' . $date . '">-</td>';
                                        }
                                        if (!empty($afbstain_values->intf_ref_value))
                                        {
                                            if (isset($afbstain_values->result_status) && $afbstain_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $afbstain_display_content .= '<td class="' . $date . ' ' . $status . '">' . $afbstain_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $afbstain_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($csf_gram_stain_values->intf_ref_value))
                                        {
                                            if (isset($csf_gram_stain_values->result_status) && $csf_gram_stain_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $csf_gram_stain_display_content .= '<td class="' . $date . ' ' . $status . '">' . $csf_gram_stain_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $csf_gram_stain_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($csf_cell_count_values->intf_ref_value))
                                        {
                                            if (isset($csf_cell_count_values->result_status) && $csf_cell_count_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $csf_cell_count_display_content .= '<td class="' . $date . ' ' . $status . '">' . $csf_cell_count_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $csf_cell_count_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($csf_glucose_values->intf_ref_value))
                                        {
                                            if (isset($csf_glucose_values->result_status) && $csf_glucose_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $csf_glucose_display_content .= '<td class="' . $date . ' ' . $status . '">' . $csf_glucose_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $csf_glucose_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($csf_proteins_values->intf_ref_value))
                                        {
                                            if (isset($csf_proteins_values->result_status) && $csf_proteins_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $csf_proteins_display_content .= '<td class="' . $date . ' ' . $status . '">' . $csf_proteins_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $csf_proteins_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($urine_others_values->intf_ref_value))
                                        {
                                            if (isset($urine_others_values->result_status) && $urine_others_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $urine_others_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_others_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $urine_others_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($urine_creatinine_clearance_values->intf_ref_value))
                                        {
                                            if (isset($urine_creatinine_clearance_values->result_status) && $urine_creatinine_clearance_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $urine_creatinine_clearance_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_creatinine_clearance_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $urine_creatinine_clearance_display_content .= '<td class="' . $date . '">-</td>';
                                        }
                                        if (!empty($urine_spot_creatinine_values->intf_ref_value))
                                        {
                                            if (isset($urine_spot_creatinine_values->result_status) && $urine_spot_creatinine_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $urine_spot_creatinine_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_spot_creatinine_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $urine_spot_creatinine_display_content .= '<td class="' . $date . '">-</td>';
                                        }
                                        if (!empty($urine_spot_chloride_values->intf_ref_value))
                                        {
                                            if (isset($urine_spot_chloride_values->result_status) && $urine_spot_chloride_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $urine_spot_chloride_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_spot_chloride_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $urine_spot_chloride_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($urine_spot_potassium_values->intf_ref_value))
                                        {
                                            if (isset($urine_spot_potassium_values->result_status) && $urine_spot_potassium_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $urine_spot_potassium_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_spot_potassium_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $urine_spot_potassium_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($urine_spot_sodium_values->intf_ref_value))
                                        {
                                            if (isset($urine_spot_sodium_values->result_status) && $urine_spot_sodium_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $urine_spot_sodium_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_spot_sodium_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $urine_spot_sodium_display_content .= '<td class="' . $date . '">-</td>';
                                        }
                                        if (!empty($urine_heamoglobin_values->intf_ref_value))
                                        {
                                            if (isset($urine_heamoglobin_values->result_status) && $urine_heamoglobin_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $urine_heamoglobin_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_heamoglobin_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $urine_heamoglobin_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($urine_blood_values->intf_ref_value))
                                        {
                                            if (isset($urine_blood_values->result_status) && $urine_blood_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $urine_blood_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_blood_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $urine_blood_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($urine_bile_pigments_values->intf_ref_value))
                                        {
                                            if (isset($urine_bile_pigments_values->result_status) && $urine_bile_pigments_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $urine_bile_pigments_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_bile_pigments_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $urine_bile_pigments_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($urine_bile_salts_values->intf_ref_value))
                                        {
                                            if (isset($urine_bile_salts_values->result_status) && $urine_bile_salts_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $urine_bile_salts_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_bile_salts_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $urine_bile_salts_display_content .= '<td class="' . $date . '">-</td>';
                                        }
                                        if (!empty($urine_osmolality_values->intf_ref_value))
                                        {
                                            if (isset($urine_osmolality_values->result_status) && $urine_osmolality_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $urine_osmolality_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_osmolality_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $urine_osmolality_display_content .= '<td class="' . $date . '">-</td>';
                                        }
                                        if (!empty($urine_casts_values->intf_ref_value))
                                        {
                                            if (isset($urine_casts_values->result_status) && $urine_casts_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $urine_casts_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_casts_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $urine_casts_display_content .= '<td class="' . $date . '">-</td>';
                                        }
                                        if (!empty($urine_crystals_values->intf_ref_value))
                                        {
                                            if (isset($urine_crystals_values->result_status) && $urine_crystals_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $urine_crystals_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_crystals_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $urine_crystals_display_content .= '<td class="' . $date . '">-</td>';
                                        }
                                        if (!empty($urine_epithelial_cells_values->intf_ref_value))
                                        {
                                            if (isset($urine_epithelial_cells_values->result_status) && $urine_epithelial_cells_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $urine_epithelial_cells_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_epithelial_cells_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $urine_epithelial_cells_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($urine_rbc_values->intf_ref_value))
                                        {
                                            if (isset($urine_rbc_values->result_status) && $urine_rbc_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $urine_rbc_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_rbc_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $urine_rbc_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($urine_pus_cells_values->intf_ref_value))
                                        {
                                            if (isset($urine_pus_cells_values->result_status) && $urine_pus_cells_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $urine_pus_cells_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_pus_cells_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $urine_pus_cells_display_content .= '<td class="' . $date . '">-</td>';
                                        }
                                        if (!empty($urine_nitrate_values->intf_ref_value))
                                        {
                                            if (isset($urine_nitrate_values->result_status) && $urine_nitrate_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $urine_nitrate_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_nitrate_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $urine_nitrate_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($urine_ketones_values->intf_ref_value))
                                        {
                                            if (isset($urine_ketones_values->result_status) && $urine_ketones_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $urine_ketones_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_ketones_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $urine_ketones_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($urine_urobilinogen_values->intf_ref_value))
                                        {
                                            if (isset($urine_urobilinogen_values->result_status) && $urine_urobilinogen_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $urine_urobilinogen_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_urobilinogen_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $urine_urobilinogen_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($urine_bilirubin_values->intf_ref_value))
                                        {
                                            if (isset($urine_bilirubin_values->result_status) && $urine_bilirubin_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $urine_bilirubin_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_bilirubin_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $urine_bilirubin_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($urine_glucose_values->intf_ref_value))
                                        {
                                            if (isset($urine_glucose_values->result_status) && $urine_glucose_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $urine_glucose_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_glucose_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $urine_glucose_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($urine_protein_values->intf_ref_value))
                                        {
                                            if (isset($urine_protein_values->result_status) && $urine_protein_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $urine_protein_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_protein_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $urine_protein_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($urine_ph_values->intf_ref_value))
                                        {
                                            if (isset($urine_ph_values->result_status) && $urine_ph_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $urine_ph_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_ph_values->intf_ref_value . '</td>';
                                        }
                                        else
                                        {
                                            $urine_ph_display_content .= '<td class="' . $date . '">-</td>';
                                        }

                                        if (!empty($urine_specific_gravity_values->intf_ref_value))
                                        {
                                            if (isset($urine_specific_gravity_values->result_status) && $urine_specific_gravity_values->result_status == 'final')
                                            {
                                                $status = 'bg-successsss';
                                            }
                                            else
                                            {
                                                $status = 'bg-warninggg';
                                            }
                                            $urine_specific_gravity_display_content .= '<td class="' . $date . ' ' . $status . '">' . $urine_specific_gravity_values->intf_ref_value . '</td>';
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
                        <table class="table hour-wise-table fixed" id="urine-report-table">
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
                                    {!! $urine_urobilinogen_display_content !!}
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
                @include('nurse_sheet.microbiology_report')
                <div role="tabpanel" class="tab-pane hidden-print" id="pending-requests">
                    @if(count($pending_results_count) > 0)
                    <ul class="pending-request-list">
                        @foreach($pending_results as $key => $req_val)
                        <h4 style="display: inline-block; float: left">Number - <strong>{{ $key }}</strong></h4>
                        <h4 style="display: inline-block; float: right">Date - <strong>{{ date('d-m-Y H:i' ,strtotime($req_val[0]->createTime)) }}</strong></h4>
                        <div class="clearfix"></div>
                        @foreach($req_val as $key => $req_val)
                        <li>{{ $req_val->name }}</li>
                        @endforeach
                        @endforeach
                    </ul>
                    @endif
                </div>
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
            </div>
        </div>
    </div>
</div>
@endsection
