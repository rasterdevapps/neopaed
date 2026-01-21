<?php

namespace App\Http\Controllers\Nurse;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DialpadSupportProperty
{
   const DAILPAD_PROPERTY = [   ['humidifier_temp', '#2FC7D3', false, false,false],
                     			['core_temp', '#801FCF', false, false,false],
                     			['flow', '#3188C8', false, false,false],
                     			['it_rate', '#5FC831', false, false,false],
                     			['rate', '#C8B631', false, false,false],
                     			['pip_set', '#C83186', false, false,false],
                                ['pip_delivered', '#C83186', false, false,false],
                     			['peep', '#C85631', false, false,false],
                     			['fio2', '#C29516', false, false,false],
                     			['map', '#164FC2', false, false,false],
                     			['preductal_sao2', '#2FC7D3', false, false,false],
                                ['postductal_sao2', '#5FC831', false, false,false],
                     			['hr_rate', '#801FCF', false, false,false],
                     			['drain_output_l', '#3188C8', false, true,false],
                     			['blood_out', '#5FC831', false, false,false],
                     			['drain_output_r', '#C8B631', false, true,false],
                     			['rectal_temp', '#C83186', false, false,false],
                     			['peripheral_temp', '#C85631', false, false,false],
                     			['urine_output', '#C29516', false, true,false],
                     			['respiratory_rate', '#164FC2', false, false,false],
                                ['respiratory_rate_measured', '#164FC2', false, false,false],
                      			['cuff_systalic_bp', '#C83186', false, false,false],
                     			['cuff_diastolic_bp', '#C85631', false, false,false],
                     			['cuff_mean_bp', '#C29516', false, false,false],
                     			['arterial_systalic_bp', '#164FC2', false, false,false],
                     			['arterial_diastolic_bp', '#2FC7D3', false, false,false],
                     			['arterial_mean_bp', '#801FCF', false, false,false],
                     			['gastric_asprit', '#3188C8', false, true,false],
                     			['warmer', '#5FC831', false, false,false],
                     			['incubator', '#C8B631', false, false,false],
                     			['p_amplitude', '#C83186', false, false,false],
                     			['frequency', '#C85631', false, false,false],
                     			['it_rate_secound', '#C29516', false, false,false],
                     			['blood_sugar', '#C29516', false, false,false],
                     			['ie_r', '#C29516', true, false,false],
                                ['targeted_tidal_volume','#C8B631',false,false,false],
                                ['delivered_tidal_volume','#C29516',false,false,false],
                                ['gastric_aspirate_volume','#C85631',false,true,false],
                                ['blood_volume_out','#2FC7D3', false, true,false],
                                ['t1_t2', '#C83186', false, false,false],
                                ['bowels_count','#e19069',false,true,false],
                                ['stoma_output_hour','#C8B631',false,true,false],
                                ['blood_gas_ph','#0e7a00',false,false,false],
                                ['blood_gas_pao2','#009ab2',false,false,false],
                                ['blood_gas_paco2','#ba32bc',false,false,false],
                                ['blood_gas_hco3','#afb200',false,false,false],
                                ['blood_gas_be','#f2a900',false,false,true],
                                ['blood_gas_na','#ea0075',false,false,false],
                                ['blood_gas_k','#b73000',false,false,false],
                                ['blood_gas_cl','#0e7a00',false,false,false],
                                ['blood_gas_hb','#851f95',false,false,false],
                                ['blood_gas_pcv','#37bfdd',false,false,false],
                                ['blood_gas_lactate','#009307',false,false,false],
                                ['blood_gas_bilirubin','#0018f4',false,false,false],
                                ['blood_gas_methemoglobin','#e00000',false,false,false],
                                ['blood_gas_etco2','#C85631',false,false,false],
                                ['perfusion_index','#2FC7D3',false,false,false],
                                ['gluco_meter_calcium','#FFA07A',false,false,false],
                                ['gluco_meter_magnesium','#FF7F50',false,false,false],
                                ['gluco_meter_phosphorus','#7CFC00',false,false,false],
                                ['gluco_meter_bun','#00FFFF',false,false,false],
                                ['gluco_meter_creatintine','#307D7E',false,false,false],
                                ['gluco_meter_glucose','#DDA0DD',false,false,false],
                                ['gluco_meter_creatinekinase','#FF69B4',false,false,false],
                                ['gluco_meter_ckmb','#DEB887',false,false,false],
                                ['gluco_meter_trop','#FA8072',false,false,false],
                                ['gluco_meter_totalbilirubin','#FF6347',false,false,false],
                                ['gluco_meter_directbilirubin','#7FFF00',false,false,false],
                                ['gluco_meter_sgot','#E9967A',false,false,false],
                                ['gluco_meter_sgpt','#FFD700',false,false,false],
                                ['gluco_meter_alkalinephosphatase','#BDB76B',false,false,false],
                                ['gluco_meter_gamagtp','#228B22',false,false,false],
                                ['gluco_meter_ldh','#808000',false,false,false],
                                ['gluco_meter_amylase','#00CED1',false,false,false],
                                ['gluco_meter_lipase','#0000CD',false,false,false],
                                ['gluco_meter_totalprotein','#FF00FF',false,false,false],
                                ['gluco_meter_albumin','#FF1493',false,false,false],
                                ['gluco_meter_totalcholesterol','#708090',false,false,false],
                                ['gluco_meter_hdl','#BC8F8F',false,false,false],
                                ['gluco_meter_ldl','#8B4513',false,false,false],
                                ['gluco_meter_vldl','#DC143C',false,false,false],
                                ['gluco_meter_triglycerides','#FFA500',false,false,false],
                                ['gluco_meter_rbc','#6B8E23',false,false,false],
                                ['gluco_meter_haematocrit','#008B8B',false,false,false],
                                ['gluco_meter_reticulocytecount','#191970',false,false,false],
                                ['gluco_meter_wbc','#8A2BE2',false,false,false],
                                ['gluco_meter_dc','#C71585',false,false,false],
                                ['gluco_meter_lymph','#A0522D',false,false,false],
                                ['gluco_meter_mono','#B22222',false,false,false],
                                ['gluco_meter_eos','#FF8C00',false,false,false],
                                ['gluco_meter_baso','#3CB371',false,false,false],
                                ['gluco_meter_platelets','#6A5ACD',false,false,false],
                                ['gluco_meter_esr','#4B0082',false,false,false],
                                ['gluco_meter_prothrombintime','#F08080',false,false,false],
                                ['gluco_meter_aptt','#98FB98',false,false,false],
                                ['gluco_meter_inr','#000080',false,false,false],
                                ['gluco_meter_fibrinogen','#FF4141',false,false,false],
                                ['gluco_meter_fdp','#7AE845',false,false,false],
                                ['fio2_measured','#7AE845',false,false,false],
                                ['interface_blood_gas_ph','#0e7a00',false,false,false],
                                ['interface_blood_gas_pao2','#009ab2',false,false,false],
                                ['interface_blood_gas_paco2','#ba32bc',false,false,false],
                                ['interface_blood_gas_hco3','#afb200',false,false,false],
                                ['interface_blood_gas_be','#f2a900',false,false,true],
                                ['interface_blood_gas_na','#ea0075',false,false,false],
                                ['interface_blood_gas_k','#b73000',false,false,false],
                                ['interface_blood_gas_cl','#0e7a00',false,false,false],
                                ['interface_blood_gas_hb','#851f95',false,false,false],
                                ['interface_blood_gas_pcv','#37bfdd',false,false,false],
                                ['interface_blood_gas_lactate','#009307',false,false,false],
                                ['interface_blood_gas_bilirubin','#0018f4',false,false,false],
                                ['interface_blood_gas_methemoglobin','#e00000',false,false,false],
                                ['interface_blood_gas_etco2','#C85631',false,false,false],
                                ['interface_blood_sugar', '#C29516', false, false,false],
                                ['interface_blood_gas_calcium', '#3bb4ff', false, false,false],
                                ['tcpo2', '#795548', false, false,false],
                                ['tcpco2', '#ff7600', false, false,false],
                            ];

        const TOGGLE_VALUSE    = ['therapeutic_hypothermia',
                                  'volume_targeting',
                                  'physiotherapy',
                                  'suction',
                                  'human_milk_fortification',
                                  'kmc',
                                  'nns',
                                  'bowels'];                         


         const LOINC_LOCAL_CODE = ['type_of_feeds', 
                                    'rectal_temp',
                                    'type_of_care', 
                                    'warmer',
                                    'work_of_breathing', 
                                    'core_temp',
                                    'peripheral_temp', 
                                    'hr_rate',
                                    'respiratory_rate', 
                                    'bp_method',
                                    'cuff_systalic_bp', 
                                    'cuff_diastolic_bp',
                                    'cuff_mean_bp', 
                                    'arterial_systalic_bp',
                                    'arterial_diastolic_bp', 
                                    'arterial_mean_bp',
                                    'preductal_sao2', 
                                    'postductal_sao2',
                                    'color', 
                                    'mode_of_ventilation',
                                    'p_amplitude', 
                                    'pip_set',
                                    'pip_delivered',
                                    'peep', 
                                    'map', 
                                    'fio2', 
                                    'flow', 
                                    'rate', 
                                    'it_rate', 
                                    'frequency',
                                    'it_rate_secound',
                                    'ie_r', 
                                    'cpap_interface_change', 
                                    'humidifier_temp', 
                                    'physiotherapy', 
                                    'suction',
                                    'route_of_feeds',
                                    'respiratory_rate',
                                    'urine_output',
                                    'bowels',
                                    'gastric_aspirate_volume',
                                    'gastric_aspirate',
                                    'drain_output_r',
                                    'drain_output_l',
                                    'drains_ml',
                                    'blood_volume_out',
                                    'et_size',
                                    'incubator',
                                    'blood_sugar',
                                    'current_weight',
                                    'working_weight',
                                    'activity',
                                    'targeted_tidal_volume',
                                    'delivered_tidal_volume',
                                    'human_milk_fortification',
                                    'milk_volume',
                                    'Transfusion',
                                    'stools_nature',
                                    'intravenous_fluids',
                                    'oral_fluids',
                                    'other_drugs',
                                    'total_intake_ml',
                                    'total_intake_kg',
                                    'aspirate_ml',
                                    'urine_total',
                                    'urine_total_ml_kg',
                                    'blood_out_total',
                                    'stools_frequency',
                                    'stoma_output',
                                    'i_o_balance',
                                    'i_o_balance_ml_kg',
                                    'air_entry_right',
                                    'air_entry_left',
                                    'volume_targeting',
                                    'physiotherapy',
                                    'suction',
                                    'human_milk_fortification',
                                    'kmc',
                                    'nns',
                                    'bowels',
                                    'position',
                                    'et_length',
                                    'ngt_size',
                                    'ngt_length',
                                    'milk_feeds',
                                    'milk_volume_total',
                                    'stoma_output_hour_total',
                                    'stoma_output_hour',
                                    'blood_gas_type',
                                    'last_bg_time',
                                    'blood_gas_ph',
                                    'blood_gas_pao2',
                                    'blood_gas_paco2',
                                    'blood_gas_hco3',
                                    'blood_gas_be',
                                    'blood_gas_na',
                                    'blood_gas_k',
                                    'blood_gas_cl',
                                    'blood_gas_hb',
                                    'blood_gas_pcv',
                                    'blood_gas_lactate',
                                    'blood_gas_bilirubin',
                                    'blood_gas_methemoglobin',
                                    'therapeutic_hypothermia',
                                    'gastric_aspirate_volume_total',
                                    'urine_output_total',
                                    'blood_volume_out_total',
                                    'drain_output_r_total',
                                    'drain_output_l_total',
                                    'mode_of_ventilation_invasive',
                                    'it_measured',
                                    'trigger_count',
                                    'rso2_one',
                                    'rso2_two',
                                    'baseline_rso2_one',
                                    'baseline_rso2_two',
                                    'o2_status',
                                    'delivered_fio2',
                                    'respiratory_rate_measured',
                                    'tcpco2',
                                    'tcpo2',
                                    'interface_blood_gas_etco2',
                                    'ventilator_saturation',
                                    'set_auto_o2_target_range'
                                  ];  


    const DRUG_FLUIDS_SOLUTION     = 'drug_solution';
    const DRUG_FLUIDS_RATE         = 'drug_rate';
    const DRUG_FLUIDS_TOTAL        = 'drug_total';   
    const PRESCRIBED_DRUG_SOLUTION = 'drug_name';
    const PRESCRIBED_DRUGS_RATE    = 'running_rate';
    const PRESCRIBED_DRUG_TOTAL    = 'total_volume';   


    const INTRAVENOUS_FLUIDS       = 'intravenous_fluids';
    const ORAL_FLUIDS              = 'oral_fluids';
    const ORAL_DRUGS               = 'other_drugs'; 
    const TOTAL_INTAKE_ML          = 'total_intake_ml';
    const TOTAL_INTAKE_KG          = 'total_intake_kg';
    const TOTAL_OUTPUT_ML          = 'total_output';
    const TOTAL_OUTPUT_KG          = 'total_output_ml_day';

    const ASPIRATE_ML              = 'aspirate_ml';
    const DRAINS_ML                = 'drains_ml';
    const URINE_TOTAL              = 'urine_total'; 
    const URINE_TOTAL_FULL_DAY     = 'urine_total_full_day'; 
    const URINE_TOTAL_ML_KG        = 'urine_total_ml_kg';
    const BLOOD_OUT_TOTAL          = 'blood_out_total';
 
    const TOTAL_OUTPUT             = 'total_output'; 
    const TOTAL_OUTPUT_ML_DAY      = 'total_output_ml_day'; 
    const STOMA_OUTPUT             = 'stoma_output'; 
    const STOOLS_FREQUENCY         = 'stools_frequency';
    const I_O_BALANCE              = 'i_o_balance';
    const I_O_BALANCE_ML_KG        = 'i_o_balance_ml_kg';
    const OTHER_DRUGS              = 'drugs';
    const A_ANTIBIOTIC             = 'A_Antibiotic';
    const A_DAY                    = 'A_Day';

    const PHOTOTHERAPY             = 'phototherapy';
    const PHOTOTHERAPY_EYES        = 'phototherapy_eyes';

    const F_PRODUCT                = 'F_Product';                                 
    const F_VOLUME                 = 'F_Volume'; 
    


    const REPLACMENT_FLUIDS_SOLUTION     = 'replacement_fluids_solution';
    const REPLACMENT_FLUIDS_RATE         = 'replacement_fluids_rate';
    const REPLACMENT_FLUIDS_TOTAL        = 'replacement_fluids_total';  
    const REPLACMENT_FLUIDS_STATUS       = 'replacement_fluids';

     // Infuion drugs columns 
     const INFUSION_DAY             = 'infusion_day';
     const INFUSION_BRANDNAME       = 'infusion_brandname'; 
     const INFUSION_PHARMACOLOGICAL = 'infusion_pharmacological';
     const INFUSION_DOSE            = 'infusion_dose';
     const INFUSION_DOSE_UNITS      = 'infusion_dose_units';
     const INFUSION_QUANTITY        = 'infusion_quantity';
     const INFUSION_QUANTITY_UNITS  = 'infusion_quantity_units';
     const INFUSION_SYRINGE         = 'infusion_syringe';
     const INFUSION_RATE            = 'infusion_rate';
     const INFUSION_INSTRUCTION     = 'infusion_instruction';
   
     const INFUSION_DATE_PRESCRIBED = 'infusion_date_prescribed';
     const INFUSION_TIME_PRESCRIBED = 'infusion_time_prescribed';
     const INFUSION_DATE_STOPPED    = 'infusion_date_stopped';
     const INFUSION_TIME_STOPPED    = 'infusion_time_stopped';


     // Infuion drugs columns for output
     const INFUSION_ID            = 'infusion_id';
     const INFUSION_NAME          = 'infusion_name';
     const INFUSION_VAlUE         = 'infusion_value';

     // Special iv columns 
     const SPEICAL_IV_DAY            = 'speical_iv_day';
     const SPEICAL_IV_NAME_ONE       = 'speical_iv_fluid_name_one';
     const SPEICAL_IV_NAME_TWO       = 'speical_iv_fluid_name_two';
     const SPEICAL_IV_VOL_ONE        = 'speical_fluid_vol_one';
     const SPEICAL_IV_VOL_TWO        = 'speical_fluid_vol_two';
     const SPEICAL_IV_SYRINGE        = 'speical_iv_syringe';
     const SPEICAL_IV_DEXTROSE       = 'speical_iv_dextrose';
     const SPEICAL_IV_GLUCOSE        = 'speical_iv_glucose';
     const SPEICAL_IV_RATE           = 'speical_iv_infusion_rate';
     const SPEICAL_IV_INSTRUCTION    = 'speical_iv_instruction';
   
     const SPEICAL_IV_DATE_PRESCRIBED  = 'speical_iv_date_prescribed';
     const SPEICAL_IV_TIME_PRESCRIBED  = 'speical_iv_time_prescribed';
     const SPEICAL_IV_DATE_STOPPED     = 'speical_iv_date_stopped';
     const SPEICAL_IV_TIME_STOPPED     = 'speical_iv_time_stopped';

     // speical iv drugs columns for output
     const SPEICAL_ID            = 'speical_id';
     const SPEICAL_NAME          = 'speical_name';
     const SPEICAL_VAlUE         = 'speical_value';

     //other iv infusion
     const OTHER_IV_INFU_DAY          = 'other_infusions_day';
     const OTHER_IV_INFU_PHARAM       = 'other_infusions_pharmacological';
     const OTHER_IV_INFU_VOL          = 'other_infusions_volume';
     const OTHER_IV_INFU_DURATION     = 'other_infusions_duration';
     const OTHER_IV_INFU_DURA_METHOD  = 'other_infusions_durametnod';
     const OTHER_IV_INFU_RATE         = 'other_infusions_rate';
     const OTHER_IV_INSTRUCTION       = 'other_infusions_instruction';
   
     const OTHER_IV_DATE_PRESCRIBED   = 'other_infusions_date_prescribed';
     const OTHER_IV_TIME_PRESCRIBED   = 'other_infusions_time_prescribed';
     const OTHER_IV_DATE_STOPPED      = 'other_infusions_date_stopped';
     const OTHER_IV_TIME_STOPPED      = 'other_infusions_time_stopped';

     //other iv infusion columns for output
     const OTHER_INFUTION_ID            = 'other_infustion_id';
     const OTHER_INFUTION_NAME          = 'other_infustion_name';
     const OTHER_INFUTION_VAlUE         = 'other_infustion_value';

     //other iv drugs 
     const OTHER_IV_DRUGS_DAY             = 'other_iv_drugs_day';
     const OTHER_IV_DRUGS_BARAND          = 'other_iv_drugs_brandname';
     const OTHER_IV_DRUGS_PHARAM          = 'other_iv_drugs_pharmacological';
     const OTHER_IV_DRUGS_DOSE_REQUIRED   = 'other_iv_drugs_dose_required';
     const OTHER_IV_DRUGS_FREQUENCY       = 'other_iv_drugs_frequency';
     const OTHER_IV_DRUGS_VOL_DOSE        = 'other_iv_drugs_volume_dose';
     const OTHER_IV_DRUGS_ADDITIONAL      = 'other_iv_drugs_additional';
   
     const OTHER_IV_DRUGS_DATE_PRESCRIBED = 'other_iv_drugs_date_prescribed';
     const OTHER_IV_DRUGS_TIME_PRESCRIBED = 'other_iv_drugs_time_prescribed';
     const OTHER_IV_DRUGS_DATE_STOPPED    = 'other_iv_drugs_date_stopped';
     const OTHER_IV_DRUGS_TIME_STOPPED    = 'other_iv_drugs_time_stopped';

      // other iv drugs columns for output
     const OTHER_IV_ID            = 'other_iv_id';
     const OTHER_IV_NAME          = 'other_iv_name';
     const OTHER_IV_VAlUE         = 'other_iv_value';


     //oral drugs
     const ORALDRUG_DAY          = 'oral_days';
     const ORALDRUG_BRANDNAME    = 'oral_brandname';
     const ORALDRUG_GENERICNAME  = 'oral_pharmacological';
     const ORALDRUG_DOSE         = 'oral_dose_required';
     const ORALDRUG_FREQUENCY    = 'oral_frequency';
     const ORALDRUG_ROUTE        = 'oral_route';
     const ORALDRUG_ADDITIONAL   = 'oral_additional';

     const ORALDRUG_DATE_PRESCRIBED   = 'oral_date_prescribed';
     const ORALDRUG_TIME_PRESCRIBED   = 'oral_time_prescribed';
     const ORALDRUG_DATE_STOPPED      = 'oral_date_stopped';
     const ORALDRUG_TIME_STOPPED      = 'oral_time_stopped';

    // iv drugs columns for output
     const ORALDRUG_ID            = 'oral_id';
     const ORALDRUG_NAME          = 'oral_name';
     const ORALDRUG_VAlUE         = 'oral_value';

     //common property 
     const ID                     = 'id';
     const LOCAL_CODE             = 'local_code';
     const INTF_REF_VALUE         = 'intf_ref_value';

     
     //iv Infusion drug group

     const INFUSION_GROUP        = [ self::INFUSION_DAY,
                                     self::INFUSION_BRANDNAME,
                                     self::INFUSION_PHARMACOLOGICAL,
                                     self::INFUSION_DOSE,
                                     self::INFUSION_DOSE_UNITS,
                                     self::INFUSION_QUANTITY,
                                     self::INFUSION_QUANTITY_UNITS,
                                     self::INFUSION_SYRINGE,
                                     self::INFUSION_RATE,
                                     self::INFUSION_INSTRUCTION,
                                     self::INFUSION_DATE_PRESCRIBED,
                                     self::INFUSION_TIME_PRESCRIBED,
                                     self::INFUSION_DATE_STOPPED,
                                     self::INFUSION_TIME_STOPPED]; 


     // Special iv group 

     const SPEICAL_IV_GROUP       = [ self::SPEICAL_IV_DAY,
                                      self::SPEICAL_IV_NAME_ONE,
                                      self::SPEICAL_IV_NAME_TWO,
                                      self::SPEICAL_IV_VOL_ONE,
                                      self::SPEICAL_IV_VOL_TWO,
                                      self::SPEICAL_IV_SYRINGE,
                                      self::SPEICAL_IV_DEXTROSE,
                                      self::SPEICAL_IV_GLUCOSE,
                                      self::SPEICAL_IV_RATE,
                                      self::SPEICAL_IV_INSTRUCTION,
                                      self::SPEICAL_IV_DATE_PRESCRIBED,
                                      self::SPEICAL_IV_TIME_PRESCRIBED,
                                      self::SPEICAL_IV_DATE_STOPPED,
                                      self::SPEICAL_IV_TIME_STOPPED]; 


     // other iv infustion group
     
     const OTHER_INFUTION_GROUP  = [ self::OTHER_IV_INFU_DAY,
                                     self::OTHER_IV_INFU_PHARAM,
                                     self::OTHER_IV_INFU_VOL,
                                     self::OTHER_IV_INFU_DURATION,
                                     self::OTHER_IV_INFU_DURA_METHOD,
                                     self::OTHER_IV_INFU_RATE,
                                     self::OTHER_IV_INSTRUCTION, 
                                     self::OTHER_IV_DATE_PRESCRIBED,
                                     self::OTHER_IV_TIME_PRESCRIBED,
                                     self::OTHER_IV_DATE_STOPPED,
                                     self::OTHER_IV_TIME_STOPPED];                               

    
     
     const OTHER_IV_DRUGS_GROUP  = [ self::OTHER_IV_DRUGS_DAY,
                                     self::OTHER_IV_DRUGS_BARAND,
                                     self::OTHER_IV_DRUGS_PHARAM,
                                     self::OTHER_IV_DRUGS_DOSE_REQUIRED,
                                     self::OTHER_IV_DRUGS_FREQUENCY,
                                     self::OTHER_IV_DRUGS_VOL_DOSE,
                                     self::OTHER_IV_DRUGS_ADDITIONAL,
                                     self::OTHER_IV_DRUGS_DATE_PRESCRIBED,
                                     self::OTHER_IV_DRUGS_TIME_PRESCRIBED,
                                     self::OTHER_IV_DRUGS_DATE_STOPPED,
                                     self::OTHER_IV_DRUGS_TIME_STOPPED];                                 

     const ORALDRUG_GROUP        =  [ self::ORALDRUG_DAY,
                                      self::ORALDRUG_BRANDNAME,
                                      self::ORALDRUG_GENERICNAME,
                                      self::ORALDRUG_DOSE,
                                      self::ORALDRUG_FREQUENCY,
                                      self::ORALDRUG_ROUTE,
                                      self::ORALDRUG_ADDITIONAL,
                                      self::ORALDRUG_DATE_PRESCRIBED,
                                      self::ORALDRUG_TIME_PRESCRIBED,
                                      self::ORALDRUG_DATE_STOPPED,
                                      self::ORALDRUG_TIME_STOPPED];   

    const REPLACMENT_FLUIDS      = [ self::REPLACMENT_FLUIDS_SOLUTION,
                                     self::REPLACMENT_FLUIDS_RATE,
                                     self::REPLACMENT_FLUIDS_TOTAL ];  

  

    const DRUG_FLUIDS            = [ self::DRUG_FLUIDS_SOLUTION,
                                     self::DRUG_FLUIDS_RATE,
                                     self::DRUG_FLUIDS_TOTAL ]; 

    const PRESCRIBED_DRUG_FLUIDS = [ self::PRESCRIBED_DRUG_SOLUTION,
                                     self::PRESCRIBED_DRUGS_RATE,
                                     self::PRESCRIBED_DRUG_TOTAL ]; 

    const A_ANTIBIOTIC_GROUP     = [ self::A_ANTIBIOTIC,
                                     self::A_DAY ];                                

    const BLOOD_PRODUCT_GROUP    = [ self::F_PRODUCT,
                                     self::F_VOLUME ];  
   
    const LOINC_LOCAL_CODE_GROUP = [ 'F_Product',
                                     'F_Volume']; 




    const BASIC_DETAILS          = [ 'current_weight',
                                     'working_weight',
                                     'et_size',
                                     'et_length',
                                     'ngt_size',
                                     'ngt_length'];



   



    const BABY_OBSERVATIONS        = [ self::LOINC_LOCAL_CODE[2],
                                       self::LOINC_LOCAL_CODE[3],
                                       self::LOINC_LOCAL_CODE[47],
                                       self::LOINC_LOCAL_CODE[5],
                                       self::LOINC_LOCAL_CODE[6],
                                       self::LOINC_LOCAL_CODE[1],
                                       self::LOINC_LOCAL_CODE[7],
                                       self::LOINC_LOCAL_CODE[8],
                                       self::LOINC_LOCAL_CODE[9],
                                       self::LOINC_LOCAL_CODE[10],
                                       self::LOINC_LOCAL_CODE[11],
                                       self::LOINC_LOCAL_CODE[12],
                                       self::LOINC_LOCAL_CODE[13],
                                       self::LOINC_LOCAL_CODE[14],
                                       self::LOINC_LOCAL_CODE[15],
                                       self::LOINC_LOCAL_CODE[16],
                                       self::LOINC_LOCAL_CODE[17],
                                       self::LOINC_LOCAL_CODE[18],
                                       self::LOINC_LOCAL_CODE[51],
                                       self::LOINC_LOCAL_CODE[118],
                                       self::LOINC_LOCAL_CODE[119],
                                       self::LOINC_LOCAL_CODE[120]];

    const RESPIRATORY_SUPPORT      = [ self::LOINC_LOCAL_CODE[4],
                                       self::LOINC_LOCAL_CODE[19],
                                       self::LOINC_LOCAL_CODE[74],
                                       self::LOINC_LOCAL_CODE[52],
                                       self::LOINC_LOCAL_CODE[20],
                                       self::LOINC_LOCAL_CODE[21],
                                       self::LOINC_LOCAL_CODE[22],
                                       self::LOINC_LOCAL_CODE[23],
                                       self::LOINC_LOCAL_CODE[24],
                                       self::LOINC_LOCAL_CODE[25],
                                       self::LOINC_LOCAL_CODE[26],
                                       self::LOINC_LOCAL_CODE[53],
                                       self::LOINC_LOCAL_CODE[27],
                                       self::LOINC_LOCAL_CODE[29],
                                       self::LOINC_LOCAL_CODE[28],
                                       self::LOINC_LOCAL_CODE[30],
                                       self::LOINC_LOCAL_CODE[31],
                                       self::LOINC_LOCAL_CODE[32],
                                       self::LOINC_LOCAL_CODE[75],
                                       self::LOINC_LOCAL_CODE[33],
                                       self::LOINC_LOCAL_CODE[71],
                                       self::LOINC_LOCAL_CODE[72],
                                       self::LOINC_LOCAL_CODE[73],
                                       self::LOINC_LOCAL_CODE[34],
                                       self::LOINC_LOCAL_CODE[35],
                                       self::LOINC_LOCAL_CODE[110],
                                       self::LOINC_LOCAL_CODE[111],
                                       self::LOINC_LOCAL_CODE[112],
                                       self::LOINC_LOCAL_CODE[113],
                                       self::LOINC_LOCAL_CODE[114],
                                       self::LOINC_LOCAL_CODE[115],
                                       self::LOINC_LOCAL_CODE[109],
                                       self::LOINC_LOCAL_CODE[116],
                                       self::LOINC_LOCAL_CODE[117],
                                       self::LOINC_LOCAL_CODE[122],
                                       self::LOINC_LOCAL_CODE[123]
                                     ];   

    const MILK_FEEDS               =  [self::LOINC_LOCAL_CODE[55],
                                       self::LOINC_LOCAL_CODE[84],
                                       self::LOINC_LOCAL_CODE[0],
                                       self::LOINC_LOCAL_CODE[36],
                                       self::LOINC_LOCAL_CODE[54],
                                       self::LOINC_LOCAL_CODE[85], 
                                       self::LOINC_LOCAL_CODE[86]
                                   ];  

    const GLUCO_METER               = [ 'gluco_meter_calcium',
                                        'gluco_meter_magnesium',
                                        'gluco_meter_phosphorus',
                                        'gluco_meter_bun',
                                        'gluco_meter_creatintine',
                                        'gluco_meter_glucose',
                                        'gluco_meter_creatinekinase',
                                        'gluco_meter_ckmb',
                                        'gluco_meter_trop',
                                        'gluco_meter_totalbilirubin',
                                        'gluco_meter_directbilirubin',
                                        'gluco_meter_sgot',
                                        'gluco_meter_sgpt',
                                        'gluco_meter_alkalinephosphatase',
                                        'gluco_meter_gamagtp',
                                        'gluco_meter_ldh',
                                        'gluco_meter_amylase',
                                        'gluco_meter_lipase',
                                        'gluco_meter_totalprotein',
                                        'gluco_meter_albumin',
                                        'gluco_meter_totalcholesterol',
                                        'gluco_meter_hdl',
                                        'gluco_meter_ldl',
                                        'gluco_meter_vldl',
                                        'gluco_meter_triglycerides',
                                        'gluco_meter_rbc',
                                        'gluco_meter_haematocrit',
                                        'gluco_meter_reticulocytecount',
                                        'gluco_meter_wbc',
                                        'gluco_meter_dc',
                                        'gluco_meter_lymph',
                                        'gluco_meter_mono',
                                        'gluco_meter_eos',
                                        'gluco_meter_baso',
                                        'gluco_meter_platelets',
                                        'gluco_meter_esr',
                                        'gluco_meter_prothrombintime',
                                        'gluco_meter_aptt',
                                        'gluco_meter_inr',
                                        'gluco_meter_fibrinogen',
                                        'gluco_meter_fdp',
                                        'blood_gas_na',
                                        'blood_gas_k',
                                        'blood_gas_cl',
                                        'blood_gas_hco3',
                                        'blood_gas_hb',
                                       self::LOINC_LOCAL_CODE[121],
                                        'gluco_meter_tsh',
                                     ];

    const OUTPUT_GROUPS            =  ['gastric_aspirate_volume',
                                       'gastric_aspirate',
                                       'gastric_aspirate_volume_total',
                                       'urine_output',
                                       'urine_output_total',
                                       'blood_volume_out',
                                       'blood_volume_out_total',
                                       'drain_output_r',
                                       'drain_output_r_total',
                                       'drain_output_l',
                                       'drain_output_l_total',
                                       'bowels',
                                       'stools_nature',
                                       'kmc',
                                       'nns',
                                       'blood_sugar',
                                       self::LOINC_LOCAL_CODE[68]];


    const OUTPUT_RUNNING_TOTAL    = [ self::LOINC_LOCAL_CODE[40], 
                                      self::LOINC_LOCAL_CODE[38],
                                      self::LOINC_LOCAL_CODE[45],
                                      self::LOINC_LOCAL_CODE[42],
                                      self::LOINC_LOCAL_CODE[43],
                                      self::LOINC_LOCAL_CODE[48],
                                      'stoma_output_hour_total'];                                   
                                
                                  
    
    const VITALS_BOX_WHISKER_PROPERTY = [ ['coreName'   => 'core_temp',
                                    'high'       => 'coretemphigh',
                                    'open'       => 'coretempopen',
                                    'mid'        => 'coretempmid',
                                    'close'      => 'coretempclose',
                                    'low'        => 'coretemplow',
                                    'fillColors' => '#ffffff',
                                    'lineColors' => '#e50d0d',
                                    'label'      => 'T1',
                                    'id'         => 'g1',
                                    'boxcolor'   => '#e50d0d',
                                    'lineone'    => '0.2',
                                    'linetwo'    => '0.2',
                                    'linethree'  => '0.4'],

                                    ['coreName'   => 'peripheral_temp',
                                    'high'       => 'peripheraltemphigh',
                                    'open'       => 'peripheraltempopen',
                                    'mid'        => 'peripheraltempmid',
                                    'close'      => 'peripheraltempclose',
                                    'low'        => 'peripheraltemplow',
                                    'fillColors' => '#ffffff',
                                    'lineColors' => '#d509f4',
                                    'label'      => 'T2',
                                    'id'         => 'g2',
                                    'boxcolor'   => '#d509f4',
                                    'lineone'    => '0.2',
                                    'linetwo'    => '0.2',
                                    'linethree'  => '0.4'],

                                    ['coreName'   => 'rectal_temp',
                                    'high'       => 'rectaltemphigh',
                                    'open'       => 'rectaltempopen',
                                    'mid'        => 'rectaltempmid',
                                    'close'      => 'rectaltempclose',
                                    'low'        => 'rectaltemplow',
                                    'fillColors' => '#ffffff',
                                    'lineColors' => '#0c32f4',
                                    'label'      => 'RT',
                                    'id'         => 'g3',
                                    'boxcolor'   => '#0c32f4',
                                    'lineone'    => '0.2',
                                    'linetwo'    => '0.2',
                                    'linethree'  => '0.4'],

                                    ['coreName'   => 'hr_rate',
                                    'high'       => 'hrratehigh',
                                    'open'       => 'hrrateopen',
                                    'mid'        => 'hrratemid',
                                    'close'      => 'hrrateclose',
                                    'low'        => 'hrratelow',
                                    'fillColors' => '#ffffff',
                                    'lineColors' => '#236d1b',
                                    'label'      => 'HR',
                                    'id'         => 'g4',
                                    'boxcolor'   => '#236d1b',
                                    'lineone'    => '0.2',
                                    'linetwo'    => '0.2',
                                    'linethree'  => '0.4'],

                                    ['coreName'  => 'respiratory_rate', 
                                    'high'       => 'respiratoryratehigh',
                                    'open'       => 'respiratoryrateopen',
                                    'mid'        => 'respiratoryratemid', 
                                    'close'      => 'respiratoryrateclose',
                                    'low'        => 'respiratoryratelow',
                                    'fillColors' => '#ffffff',
                                    'lineColors' => '#0a0000',
                                    'label'      => 'RR',
                                    'id'         => 'g5',
                                    'boxcolor'   => '#0a0000',
                                    'lineone'    => '0.2',
                                    'linetwo'    => '0.2',
                                    'linethere'  =>' 0.4'],

                                    ['coreName'  => 'cuff_systalic_bp', 
                                    'high'       => 'cuffsystalicbphigh',
                                    'open'       => 'cuffsystalicbpopen',
                                    'mid'        => 'cuffsystalicbpmid', 
                                    'close'      => 'cuffsystalicbpclose',
                                    'low'        => 'cuffsystalicbplow',
                                    'fillColors' => '#ffffff',
                                    'lineColors' => '#dadd11',
                                    'label'      => 'Cuff Systolic BP',
                                    'id'         => 'g6',
                                    'boxcolor'   => '#dadd11',
                                    'lineone'    => '0.2',
                                    'linetwo'    => '0.2',
                                    'linethere'  =>' 0.4'],

                                    ['coreName'  => 'cuff_diastolic_bp', 
                                    'high'       => 'cuffsystalicbphigh',
                                    'open'       => 'cuffsystalicbpopen',
                                    'mid'        => 'cuffsystalicbpmid', 
                                    'close'      => 'cuffsystalicbpclose',
                                    'low'        => 'cuffsystalicbplow',
                                    'fillColors' => '#ffffff',
                                    'lineColors' => '#1edbcb',
                                    'label'      => 'Cuff Diastolic BP',
                                    'id'         => 'g6',
                                    'boxcolor'   => '#1edbcb',
                                    'lineone'    => '0.2',
                                    'linetwo'    => '0.2',
                                    'linethere'  =>' 0.4'],

                                   ['coreName'   => 'cuff_mean_bp', 
                                    'high'       => 'cuffmeanbphigh',
                                    'open'       => 'cuffmeanbpopen',
                                    'mid'        => 'cuffmeanbpmid', 
                                    'close'      => 'cuffmeanbpclose',
                                    'low'        => 'cuffmeanbplow',
                                    'fillColors' => '#ffffff',
                                    'lineColors' => '#7c2d9e',
                                    'label'      => 'Cuff Mean BP',
                                    'id'         => 'g7',
                                    'boxcolor'   => '#7c2d9e',
                                    'lineone'    => '0.2',
                                    'linetwo'    => '0.2',
                                    'linethere'  =>' 0.4'],

                                   ['coreName'   => 'arterial_systalic_bp', 
                                    'high'       => 'arterialsystalicbphigh',
                                    'open'       => 'arterialsystalicbpopen',
                                    'mid'        => 'arterialsystalicbpmid', 
                                    'close'      => 'arterialsystalicbpclose',
                                    'low'        => 'arterialsystalicbplow',
                                    'fillColors' => '#ffffff',
                                    'lineColors' => '#1c99d8',
                                    'label'      => 'Arterial Systolic BP',
                                    'id'         => 'g7',
                                    'boxcolor'   => '#1c99d8',
                                    'lineone'    => '0.2',
                                    'linetwo'    => '0.2',
                                    'linethere'  =>' 0.4'],

                                   ['coreName'   => 'arterial_diastolic_bp', 
                                    'high'       => 'arterialdiastolicbphigh',
                                    'open'       => 'arterialdiastolicbpopen',
                                    'mid'        => 'arterialdiastolicbpmid', 
                                    'close'      => 'arterialdiastolicbpclose',
                                    'low'        => 'arterialdiastolicbplow',
                                    'fillColors' => '#ffffff',
                                    'lineColors' => '#4420ad',
                                    'label'      => 'Arterial Diastolic BP',
                                    'id'         => 'g7',
                                    'boxcolor'   => '#4420ad',
                                    'lineone'    => '0.2',
                                    'linetwo'    => '0.2',
                                    'linethere'  =>' 0.4'],

                                   ['coreName'   => 'arterial_mean_bp', 
                                    'high'       => 'arterialmeanbphigh',
                                    'open'       => 'arterialmeanbpopen',
                                    'mid'        => 'arterialmeanbpmid', 
                                    'close'      => 'arterialmeanbpclose',
                                    'low'        => 'arterialmeanbplow',
                                    'fillColors' => '#ffffff',
                                    'lineColors' => '#c46b1d',
                                    'label'      => 'Arterial Mean BP',
                                    'id'         => 'g7',
                                    'boxcolor'   => '#c46b1d',
                                    'lineone'    => '0.2',
                                    'linetwo'    => '0.2',
                                    'linethere'  =>' 0.4']];

    const VITALS_CANDLE_CHART_PROPERTY =  [[
                                     'coreName'  => 'core_temp',
                                     'id'        => 'g1',
                                     'open'      => 'coretempopen',
                                     'high'      => 'coretemphigh',
                                     'low'       => 'coretemplow',
                                     'close'     => 'coretempclose',
                                     'fillColor' => '#e50d0d',
                                     'lineColor' => '#e50d0d',
                                     'title'     => 'T1'
                                    ],[
                                     'coreName'  => 'peripheral_temp',
                                     'id'        => 'g2',
                                     'open'      => 'peripheraltempopen',
                                     'high'      => 'peripheraltemphigh',
                                     'low'       => 'peripheraltemplow',
                                     'close'     => 'coretempclose',
                                     'fillColor' => '#d509f4',
                                     'lineColor' => '#d509f4',
                                     'title'     => 'T2' 
                                     ],[
                                     'coreName'  => 'rectal_temp',
                                     'id'        => 'g3',
                                     'open'      => 'rectaltempopen',
                                     'high'      => 'rectaltemphigh',
                                     'low'       => 'rectaltemplow',
                                     'close'     => 'rectaltempclose',
                                     'fillColor' => '#0c32f4',
                                     'lineColor' => '#0c32f4',
                                     'title'     => 'RT' 
                                     ],[
                                     'coreName'  => 'hr_rate',
                                     'id'        => 'g4',
                                     'open'      => 'hrrateopen',
                                     'high'      => 'hrratehigh',
                                     'low'       => 'hrratelow',
                                     'close'     => 'hrrateclose',
                                     'fillColor' => '#236d1b',
                                     'lineColor' => '#236d1b',
                                     'title'     => 'HR' 
                                     ],[
                                     'coreName'  => 'respiratory_rate',
                                     'id'        => 'g5',
                                     'open'      => 'respiratoryrateopen',
                                     'high'      => 'respiratoryratehigh',
                                     'low'       => 'respiratoryratelow',
                                     'close'     => 'respiratoryrateclose',
                                     'fillColor' => '#0a0000',
                                     'lineColor' => '#0a0000',
                                     'title'     => 'RR' 
                                     ]
                                 ];                               

    const VITALS_LINE_CHART_PROPERTY  = [['column'           => 'core_temp',
                                      'drop'              => true,
                                      'adjustBorderColor' => true,
                                      'BorderColor'       => '#0a0000',
                                      'fillColor'         => '#e50d0d',
                                      'propertyName'      => 'T1',
                                      'valueField'        => 'coretemp',
                                      'bulletType'        => 'round'
                                      ],[
                                      'column'            => 'peripheral_temp',
                                      'drop'              => true,
                                      'adjustBorderColor' => true,
                                      'BorderColor'       => '#0a0000',
                                      'fillColor'         => '#d509f4',
                                      'propertyName'      => 'T2',
                                      'valueField'        => 'peripheraltemp',
                                      'bulletType'        => 'square'
                                     ],[
                                      'column'            => 'rectal_temp',
                                      'drop'              => true,
                                      'adjustBorderColor' => true,
                                      'BorderColor'       => '#0a0000',
                                      'fillColor'         => '#0c32f4',
                                      'propertyName'      => 'RT',
                                      'valueField'        => 'rectaltemp',
                                      'bulletType'        => 'triangleUp'
                                    ],[
                                      'column'            => 'hr_rate',
                                      'drop'              => true,
                                      'adjustBorderColor' => true,
                                      'BorderColor'       => '#0a0000',
                                      'fillColor'         => '#236d1b',
                                      'propertyName'      => 'HR',
                                      'valueField'        => 'hrrate',
                                      'bulletType'        => 'triangleDown'
                                    ], [
                                      'column'            => 'respiratory_rate',
                                      'drop'              => true,
                                      'adjustBorderColor' => true,
                                      'BorderColor'       => '#0a0000',
                                      'fillColor'         => '#0a0000',
                                      'propertyName'      => 'RR',
                                      'valueField'        => 'respiratoryrate',
                                      'bulletType'        => 'round'
                                    ],[
                                      'column'            => 'cuff_systalic_bp',
                                      'drop'              => true,
                                      'adjustBorderColor' => true,
                                      'BorderColor'       => '#0a0000',
                                      'fillColor'         => '#dadd11',
                                      'propertyName'      => 'Cuff Systolic BP',
                                      'valueField'        => 'cuffsystalicbp',
                                      'bulletType'        => 'square'
                                    ],[
                                      'column'            => 'cuff_diastolic_bp',
                                      'drop'              => true,
                                      'adjustBorderColor' => true,
                                      'BorderColor'       => '#0a0000',
                                      'fillColor'         => '#1edbcb',
                                      'propertyName'      => 'Cuff Diastolic BP',
                                      'valueField'        => 'cuffdiastolicbp',
                                      'bulletType'        => 'triangleUp'
                                    ],[
                                      'column'            => 'cuff_mean_bp',
                                      'drop'              => true,
                                      'adjustBorderColor' => true,
                                      'BorderColor'       => '#0a0000',
                                      'fillColor'         => '#7c2d9e',
                                      'propertyName'      => 'Cuff Mean BP',
                                      'valueField'        => 'cuffmeanbp',
                                      'bulletType'        => 'triangleDown'
                                    ],[
                                      'column'            => 'arterial_systalic_bp',
                                      'drop'              => true,
                                      'adjustBorderColor' => true,
                                      'BorderColor'       => '#0a0000',
                                      'fillColor'         => '#1c99d8',
                                      'propertyName'      => 'Arterial Systolic BP',
                                      'valueField'        => 'arterialsystalicbp',
                                      'bulletType'        => 'round'
                                    ],[
                                      'column'            => 'arterial_diastolic_bp',
                                      'drop'              => true,
                                      'adjustBorderColor' => true,
                                      'BorderColor'       => '#0a0000',
                                      'fillColor'         => '#4420ad',
                                      'propertyName'      => 'Arterial Diastolic BP',
                                      'valueField'        => 'arterialdiastolicbp',
                                      'bulletType'        => 'triangleUp'
                                    ],[
                                      'column'            => 'arterial_mean_bp',
                                      'drop'              => true,
                                      'adjustBorderColor' => true,
                                      'BorderColor'       => '#0a0000',
                                      'fillColor'         => '#c46b1d',
                                      'propertyName'      => 'Arterial Mean BP',
                                      'valueField'        => 'arterialmeanbp',
                                      'bulletType'        => 'bubble'
                                    ]];

    const VITALS_PARAMETERS  = [
                                ['parameter'       => 'core_temp',
                                 'parameter_title' => 'Core Temperature (T1)',
                                 'parameter_color' => '#e50d0d',
                                 'parameter_checked' => true],

                                ['parameter'       => 'peripheral_temp',
                                 'parameter_title' => 'Peripheral Temperature (T2)',
                                 'parameter_color' => '#d509f4',
                                 'parameter_checked' => false],

                                ['parameter'       => 'rectal_temp',
                                 'parameter_title' => 'Rectal Temperature',
                                 'parameter_color' => '#0c32f4',
                                 'parameter_checked' => false],

                                ['parameter'       => 'hr_rate',
                                 'parameter_title' => 'Heart Rate',
                                 'parameter_color' => '#236d1b',
                                 'parameter_checked' => false],

                                ['parameter'       => 'respiratory_rate',
                                 'parameter_title' => 'Baby\'s Respiratory Rate',
                                 'parameter_color' => '#0a0000',
                                 'parameter_checked' => false],

                                ['parameter'       => 'cuff_systalic_bp',
                                 'parameter_title' => 'Cuff Systolic BP',
                                 'parameter_color' => '#dadd11',
                                 'parameter_checked' => false],

                                ['parameter'       => 'cuff_diastolic_bp',
                                 'parameter_title' => 'Cuff Diastolic BP',
                                 'parameter_color' => '#1edbcb',
                                 'parameter_checked' => false], 

                                ['parameter'       => 'cuff_mean_bp',
                                 'parameter_title' => 'Cuff Mean BP',
                                 'parameter_color' => '#7c2d9e',
                                 'parameter_checked' => false],

                                ['parameter'       => 'arterial_systalic_bp',
                                 'parameter_title' => 'Arterial Systolic BP',
                                 'parameter_color' => '#1c99d8',
                                 'parameter_checked' => false],

                                ['parameter'       => 'arterial_diastolic_bp',
                                 'parameter_title' => 'Arterial Diastolic BP',
                                 'parameter_color' => '#4420ad',
                                 'parameter_checked' => false],

                                ['parameter'       => 'arterial_mean_bp',
                                 'parameter_title' => 'Arterial Mean BP',
                                 'parameter_color' => '#c46b1d',
                                 'parameter_checked' => false]  
                                ];     

 const VENTILATOR_PARAMETERS  = [['parameter'       => 'targeted_tidal_volume',
                                 'parameter_title' => 'Targeted Tidal Volume',
                                 'parameter_color' => '#ea1212',
                                 'parameter_checked' => true],

                                ['parameter'       => 'p_amplitude',
                                 'parameter_title' => 'ΔP/Amplitude',
                                 'parameter_color' => '#ea0be6',
                                 'parameter_checked' => false],

                                ['parameter'       => 'pip_set',
                                 'parameter_title' => 'PIP (set)',
                                 'parameter_color' => '#2620e5',
                                 'parameter_checked' => false],

                                ['parameter'       => 'pip_delivered',
                                 'parameter_title' => 'PIP (delivered)',
                                 'parameter_color' => '#10edd3',
                                 'parameter_checked' => false],

                                ['parameter'       => 'peep',
                                 'parameter_title' => 'PEEP',
                                 'parameter_color' => '#b7b7b7',
                                 'parameter_checked' => false],

                                ['parameter'       => 'map',
                                 'parameter_title' => 'MAP',
                                 'parameter_color' => '#e5e514',
                                 'parameter_checked' => false],

                                ['parameter'       => 'fio2',
                                 'parameter_title' => 'FiO2 %',
                                 'parameter_color' => '#1edbcb',
                                 'parameter_checked' => false], 

                                ['parameter'       => 'flow',
                                 'parameter_title' => 'FLOW',
                                 'parameter_color' => '#7c2d9e',
                                 'parameter_checked' => false],

                                ['parameter'       => 'delivered_tidal_volume',
                                 'parameter_title' => 'Delivered Tidal Volume',
                                 'parameter_color' => '#1c99d8',
                                 'parameter_checked' => false],

                                ['parameter'       => 'rate',
                                 'parameter_title' => 'RATE/V (Set Ventilator Rate)',
                                 'parameter_color' => '#4420ad',
                                 'parameter_checked' => false],

                                ['parameter'       => 'frequency',
                                 'parameter_title' => 'Frequency (H2)',
                                 'parameter_color' => '#d6a206',
                                 'parameter_checked' => false],

                                ['parameter'       => 'it_rate',
                                 'parameter_title' => 'IT(%)',
                                 'parameter_color' => '#007a0a',
                                 'parameter_checked' => false],

                                ['parameter'       => 'it_rate_secound',
                                 'parameter_title' => 'IT(S)',
                                 'parameter_color' => '#5b001e',
                                 'parameter_checked' => false] 

                                ]; 

const BLOOD_GAS_PARAMETERS    = [
                               ['parameter'      => 'blood_gas_ph',
                               'parameter_title' => 'pH',
                               'parameter_color' => '#ed5615',
                               'parameter_checked' => true],

                               ['parameter'      => 'blood_gas_pao2',
                               'parameter_title' => 'Pao2',
                               'parameter_color' => '#bf18a3',
                               'parameter_checked' => false],

                               ['parameter'      => 'blood_gas_paco2',
                               'parameter_title' => 'PaCo2',
                               'parameter_color' => '#4211c6',
                               'parameter_checked' => false],

                               ['parameter'      => 'blood_gas_hco3',
                               'parameter_title' => 'HCO3',
                               'parameter_color' => '#32d1b3',
                               'parameter_checked' => false],

                               ['parameter'      => 'blood_gas_be',
                               'parameter_title' => 'BE',
                               'parameter_color' => '#5b001e',
                               'parameter_checked' => false],

                               ['parameter'      => 'blood_gas_na',
                               'parameter_title' => 'Na (sodium) (mmol/L)',
                               'parameter_color' => '#4db213',
                               'parameter_checked' => false],

                               ['parameter'      => 'blood_gas_k',
                               'parameter_title' => 'K (potassium) (mmol/L)',
                               'parameter_color' => '#b2a31a',
                               'parameter_checked' => false],

                               ['parameter'      => 'blood_gas_cl',
                               'parameter_title' => 'cl (Chloride) (mmol/L)',
                               'parameter_color' => '#dbc418',
                               'parameter_checked' => false],

                               ['parameter'      => 'blood_gas_hb',
                               'parameter_title' => 'HB (g/dL)',
                               'parameter_color' => '#5b001e',
                               'parameter_checked' => false],

                               ['parameter'      => 'blood_gas_pcv',
                               'parameter_title' => 'PCV (%)',
                               'parameter_color' => '#e52253',
                               'parameter_checked' => false],

                               ['parameter'      => 'blood_gas_lactate',
                               'parameter_title' => 'Lactate',
                               'parameter_color' => '#20c2db',
                               'parameter_checked' => false],

                               ['parameter'      => 'blood_gas_bilirubin',
                               'parameter_title' => 'Bilirubin',
                               'parameter_color' => '#e08f16',
                               'parameter_checked' => false],

                               ['parameter'      => 'blood_sugar',
                               'parameter_title' => 'Blood Sugar (mg/dl)',
                               'parameter_color' => '#c4c4c4',
                               'parameter_checked' => false],

                               ['parameter'      => 'blood_gas_methemoglobin',
                               'parameter_title' => 'Methemoglobin',
                               'parameter_color' => '#d61b1b',
                               'parameter_checked' => false]


                            ];                                
  

const VENDILATOR_BOX_WHISKER_PROPERTY = [  ['coreName'   => 'targeted_tidal_volume',
                                            'high'       => 'targetedtidalvolumehigh',
                                            'open'       => 'targetedtidalvolumeopen',
                                            'mid'        => 'targetedtidalvolumemid',
                                            'close'      => 'targetedtidalvolumeclose',
                                            'low'        => 'targetedtidalvolumelow',
                                            'fillColors' => '#ffffff',
                                            'lineColors' => '#ea1212',
                                            'label'      => 'Targeted Tidal Volume',
                                            'id'         => 'v1',
                                            'boxcolor'   => '#ea1212',
                                            'lineone'    => '0.2',
                                            'linetwo'    => '0.2',
                                            'linethree'  => '0.4'],

                                            ['coreName'   => 'p_amplitude',
                                            'high'       => 'pamplitudehigh',
                                            'open'       => 'pamplitudeopen',
                                            'mid'        => 'pamplitudemid',
                                            'close'      => 'pamplitudeclose',
                                            'low'        => 'pamplitudelow',
                                            'fillColors' => '#ffffff',
                                            'lineColors' => '#ea0be6',
                                            'label'      => 'ΔP/Amplitude',
                                            'id'         => 'v2',
                                            'boxcolor'   => '#ea0be6',
                                            'lineone'    => '0.2',
                                            'linetwo'    => '0.2',
                                            'linethree'  => '0.4'],

                                            ['coreName'   => 'pip_set',
                                            'high'       => 'pipsethigh',
                                            'open'       => 'pipsetopen',
                                            'mid'        => 'pipsetmid',
                                            'close'      => 'pipsetclose',
                                            'low'        => 'pipsetlow',
                                            'fillColors' => '#ffffff',
                                            'lineColors' => '#2620e5',
                                            'label'      => 'PIP (set)',
                                            'id'         => 'v3',
                                            'boxcolor'   => '#2620e5',
                                            'lineone'    => '0.2',
                                            'linetwo'    => '0.2',
                                            'linethree'  => '0.4'],

                                            ['coreName'   => 'pip_delivered',
                                             'high'       => 'pipdeliveredhigh',
                                             'open'       => 'pipdeliveredopen',
                                             'mid'        => 'pipdeliveredmid',
                                             'close'      => 'pipdeliveredclose',
                                             'low'        => 'pipdeliveredlow',
                                             'fillColors' => '#ffffff',
                                             'lineColors' => '#10edd3',
                                             'label'      => 'PIP (delivered)',
                                             'id'         => 'v4',
                                             'boxcolor'   => '#10edd3',
                                             'lineone'    => '0.2',
                                             'linetwo'    => '0.2',
                                             'linethree'  => '0.4'],

                                            ['coreName'  => 'peep', 
                                            'high'       => 'peephigh',
                                            'open'       => 'peepopen',
                                            'mid'        => 'peepmid', 
                                            'close'      => 'peepclose',
                                            'low'        => 'peeplow',
                                            'fillColors' => '#ffffff',
                                            'lineColors' => '#b7b7b7',
                                            'label'      => 'PEEP',
                                            'id'         => 'v5',
                                            'boxcolor'   => '#b7b7b7',
                                            'lineone'    => '0.2',
                                            'linetwo'    => '0.2',
                                            'linethere'  =>' 0.4'],

                                            ['coreName'  => 'map', 
                                            'high'       => 'maphigh',
                                            'open'       => 'mapopen',
                                            'mid'        => 'mapmid', 
                                            'close'      => 'mapclose',
                                            'low'        => 'maplow',
                                            'fillColors' => '#ffffff',
                                            'lineColors' => '#e5e514',
                                            'label'      => 'MAP',
                                            'id'         => 'v5',
                                            'boxcolor'   => '#e5e514',
                                            'lineone'    => '0.2',
                                            'linetwo'    => '0.2',
                                            'linethere'  =>' 0.4'],

                                            ['coreName'  => 'fio2', 
                                            'high'       => 'fio2high',
                                            'open'       => 'fio2open',
                                            'mid'        => 'fio2mid', 
                                            'close'      => 'fio2close',
                                            'low'        => 'fio2low',
                                            'fillColors' => '#ffffff',
                                            'lineColors' => '#1edbcb',
                                            'label'      => 'FiO2 %',
                                            'id'         => 'v6',
                                            'boxcolor'   => '#1edbcb',
                                            'lineone'    => '0.2',
                                            'linetwo'    => '0.2',
                                            'linethere'  =>' 0.4'],

                                           ['coreName'   => 'flow', 
                                            'high'       => 'flowhigh',
                                            'open'       => 'flowopen',
                                            'mid'        => 'flowmid', 
                                            'close'      => 'flowclose',
                                            'low'        => 'flowlow',
                                            'fillColors' => '#ffffff',
                                            'lineColors' => '#7c2d9e',
                                            'label'      => 'FLOW',
                                            'id'         => 'v7',
                                            'boxcolor'   => '#7c2d9e',
                                            'lineone'    => '0.2',
                                            'linetwo'    => '0.2',
                                            'linethere'  =>' 0.4'],

                                           ['coreName'   => 'delivered_tidal_volume', 
                                            'high'       => 'deliveredtidalvolumehigh',
                                            'open'       => 'deliveredtidalvolumeopen',
                                            'mid'        => 'deliveredtidalvolumemid', 
                                            'close'      => 'deliveredtidalvolumeclose',
                                            'low'        => 'deliveredtidalvolumelow',
                                            'fillColors' => '#ffffff',
                                            'lineColors' => '#1c99d8',
                                            'label'      => 'Delivered Tidal Volume',
                                            'id'         => 'v8',
                                            'boxcolor'   => '#1c99d8',
                                            'lineone'    => '0.2',
                                            'linetwo'    => '0.2',
                                            'linethere'  =>' 0.4'],

                                           ['coreName'   => 'rate', 
                                            'high'       => 'ratephigh',
                                            'open'       => 'ratepopen',
                                            'mid'        => 'ratepmid', 
                                            'close'      => 'ratepclose',
                                            'low'        => 'rateplow',
                                            'fillColors' => '#ffffff',
                                            'lineColors' => '#4420ad',
                                            'label'      => 'RATE/V (Set Ventilator Rate)',
                                            'id'         => 'v9',
                                            'boxcolor'   => '#4420ad',
                                            'lineone'    => '0.2',
                                            'linetwo'    => '0.2',
                                            'linethere'  =>' 0.4'],

                                           ['coreName'   => 'frequency', 
                                            'high'       => 'frequencyhigh',
                                            'open'       => 'frequencyopen',
                                            'mid'        => 'frequencymid', 
                                            'close'      => 'frequencyclose',
                                            'low'        => 'frequencylow',
                                            'fillColors' => '#ffffff',
                                            'lineColors' => '#d6a206',
                                            'label'      => 'Frequency (H2)',
                                            'id'         => 'v10',
                                            'boxcolor'   => '#d6a206',
                                            'lineone'    => '0.2',
                                            'linetwo'    => '0.2',
                                            'linethere'  =>' 0.4'],

                                            ['coreName'   => 'it_rate', 
                                             'high'       => 'itratehigh',
                                             'open'       => 'itrateopen',
                                             'mid'        => 'itratemid', 
                                             'close'      => 'itrateclose',
                                             'low'        => 'itratelow',
                                             'fillColors' => '#ffffff',
                                             'lineColors' => '#007a0a',
                                             'label'      => 'IT(%)',
                                             'id'         => 'v11',
                                             'boxcolor'   => '#007a0a',
                                             'lineone'    => '0.2',
                                             'linetwo'    => '0.2',
                                             'linethere'  =>' 0.4'],

                                            ['coreName'   => 'it_rate_secound', 
                                             'high'       => 'itratesecoundhigh',
                                             'open'       => 'itratesecoundopen',
                                             'mid'        => 'itratesecoundmid', 
                                             'close'      => 'itratesecoundclose',
                                             'low'        => 'itratesecoundlow',
                                             'fillColors' => '#ffffff',
                                             'lineColors' => '#5b001e',
                                             'label'      => 'IT(S)',
                                             'id'         => 'v12',
                                             'boxcolor'   => '#5b001e',
                                             'lineone'    => '0.2',
                                             'linetwo'    => '0.2',
                                             'linethere'  =>' 0.4']];

const VENTILATOR_LINE_CHART_PROPERTY  = [
                                         ['column'           => 'targeted_tidal_volume',
                                          'drop'              => true,
                                          'adjustBorderColor' => true,
                                          'BorderColor'       => '#0a0000',
                                          'fillColor'         => '#ea1212',
                                          'propertyName'      => 'Targeted Tidal Volume',
                                          'valueField'        => 'targetedtidalvolume',
                                          'bulletType'        => 'round'
                                          ],[
                                          'column'            => 'p_amplitude',
                                          'drop'              => true,
                                          'adjustBorderColor' => true,
                                          'BorderColor'       => '#0a0000',
                                          'fillColor'         => '#ea0be6',
                                          'propertyName'      => 'ΔP/Amplitude',
                                          'valueField'        => 'pamplitude',
                                          'bulletType'        => 'square'
                                         ],[
                                          'column'            => 'pip_set',
                                          'drop'              => true,
                                          'adjustBorderColor' => true,
                                          'BorderColor'       => '#0a0000',
                                          'fillColor'         => '#2620e5',
                                          'propertyName'      => 'PIP (set)',
                                          'valueField'        => 'pipset',
                                          'bulletType'        => 'triangleUp'
                                        ],[
                                          'column'            => 'pip_delivered',
                                          'drop'              => true,
                                          'adjustBorderColor' => true,
                                          'BorderColor'       => '#0a0000',
                                          'fillColor'         => '#10edd3',
                                          'propertyName'      => 'PIP (delivered)',
                                          'valueField'        => 'pipdelivered',
                                          'bulletType'        => 'triangleDown'
                                        ], [
                                          'column'            => 'peep',
                                          'drop'              => true,
                                          'adjustBorderColor' => true,
                                          'BorderColor'       => '#0a0000',
                                          'fillColor'         => '#b7b7b7',
                                          'propertyName'      => 'PEEP',
                                          'valueField'        => 'peep',
                                          'bulletType'        => 'bubble'
                                       ], [
                                          'column'            => 'map',
                                          'drop'              => true,
                                          'adjustBorderColor' => true,
                                          'BorderColor'       => '#0a0000',
                                          'fillColor'         => '#e5e514',
                                          'propertyName'      => 'MAP',
                                          'valueField'        => 'map',
                                          'bulletType'        => 'bubble'
                                       ], [
                                          'column'            => 'fio2',
                                          'drop'              => true,
                                          'adjustBorderColor' => true,
                                          'BorderColor'       => '#0a0000',
                                          'fillColor'         => '#1edbcb',
                                          'propertyName'      => 'FiO2 %',
                                          'valueField'        => 'fio2',
                                          'bulletType'        => 'bubble'
                                       ], [
                                          'column'            => 'flow',
                                          'drop'              => true,
                                          'adjustBorderColor' => true,
                                          'BorderColor'       => '#0a0000',
                                          'fillColor'         => '#7c2d9e',
                                          'propertyName'      => 'FLOW',
                                          'valueField'        => 'flow',
                                          'bulletType'        => 'bubble'
                                       ], [
                                          'column'            => 'delivered_tidal_volume',
                                          'drop'              => true,
                                          'adjustBorderColor' => true,
                                          'BorderColor'       => '#0a0000',
                                          'fillColor'         => '#1c99d8',
                                          'propertyName'      => 'FLOW',
                                          'valueField'        => 'deliveredtidalvolume',
                                          'bulletType'        => 'bubble'
                                       ], [
                                          'column'            => 'frequency',
                                          'drop'              => true,
                                          'adjustBorderColor' => true,
                                          'BorderColor'       => '#0a0000',
                                          'fillColor'         => '#d6a206',
                                          'propertyName'      => 'Frequency (H2)',
                                          'valueField'        => 'frequency',
                                          'bulletType'        => 'bubble'
                                       ], [
                                          'column'            => 'it_rate',
                                          'drop'              => true,
                                          'adjustBorderColor' => true,
                                          'BorderColor'       => '#0a0000',
                                          'fillColor'         => '#007a0a',
                                          'propertyName'      => 'IT(%)',
                                          'valueField'        => 'itrate',
                                          'bulletType'        => 'bubble'
                                       ], [
                                          'column'            => 'it_rate_secound',
                                          'drop'              => true,
                                          'adjustBorderColor' => true,
                                          'BorderColor'       => '#0a0000',
                                          'fillColor'         => '#4420ad',
                                          'propertyName'      => 'IT(S)',
                                          'valueField'        => 'itratesecound',
                                          'bulletType'        => 'bubble'
                                       ]];  

 const BLOOD_GAS_BOX_WHISKER_PROPERTY = [ ['coreName'    => 'blood_gas_ph',
                                            'high'       => 'bloodgasphhigh',
                                            'open'       => 'bloodgasphopen',
                                            'mid'        => 'bloodgasphmid',
                                            'close'      => 'bloodgasphclose',
                                            'low'        => 'bloodgasphlow',
                                            'fillColors' => '#ffffff',
                                            'lineColors' => '#ed5615',
                                            'label'      => 'pH',
                                            'id'         => 'b1',
                                            'boxcolor'   => '#ed5615',
                                            'lineone'    => '0.2',
                                            'linetwo'    => '0.2',
                                            'linethree'  => '0.4'],

                                           ['coreName'   => 'blood_gas_pao2',
                                            'high'       => 'bloodgaspao2high',
                                            'open'       => 'bloodgaspao2open',
                                            'mid'        => 'bloodgaspao2mid',
                                            'close'      => 'bloodgaspao2close',
                                            'low'        => 'bloodgaspao2low',
                                            'fillColors' => '#ffffff',
                                            'lineColors' => '#bf18a3',
                                            'label'      => 'Pao2',
                                            'id'         => 'b2',
                                            'boxcolor'   => '#bf18a3',
                                            'lineone'    => '0.2',
                                            'linetwo'    => '0.2',
                                            'linethree'  => '0.4'],

                                           ['coreName'   => 'blood_gas_paco2',
                                            'high'       => 'bloodgaspaco2high',
                                            'open'       => 'bloodgaspaco2open',
                                            'mid'        => 'bloodgaspaco2mid',
                                            'close'      => 'bloodgaspaco2close',
                                            'low'        => 'bloodgaspaco2low',
                                            'fillColors' => '#ffffff',
                                            'lineColors' => '#4211c6',
                                            'label'      => 'PaCo2',
                                            'id'         => 'b3',
                                            'boxcolor'   => '#4211c6',
                                            'lineone'    => '0.2',
                                            'linetwo'    => '0.2',
                                            'linethree'  => '0.4'],

                                           ['coreName'   => 'blood_gas_hco3',
                                            'high'       => 'bloodgashco3high',
                                            'open'       => 'bloodgashco3open',
                                            'mid'        => 'bloodgashco3mid',
                                            'close'      => 'bloodgashco3close',
                                            'low'        => 'bloodgashco3low',
                                            'fillColors' => '#ffffff',
                                            'lineColors' => '#32d1b3',
                                            'label'      => 'HCO3',
                                            'id'         => 'b4',
                                            'boxcolor'   => '#32d1b3',
                                            'lineone'    => '0.2',
                                            'linetwo'    => '0.2',
                                            'linethree'  => '0.4'],

                                           ['coreName'   => 'blood_gas_be',
                                            'high'       => 'bloodgasbehigh',
                                            'open'       => 'bloodgasbeopen',
                                            'mid'        => 'bloodgasbemid',
                                            'close'      => 'bloodgasbeclose',
                                            'low'        => 'bloodgasbelow',
                                            'fillColors' => '#ffffff',
                                            'lineColors' => '#5b001e',
                                            'label'      => 'BE',
                                            'id'         => 'b5',
                                            'boxcolor'   => '#5b001e',
                                            'lineone'    => '0.2',
                                            'linetwo'    => '0.2',
                                            'linethree'  => '0.4'],

                                            ['coreName'   => 'blood_gas_na',
                                            'high'       => 'bloodgasnahigh',
                                            'open'       => 'bloodgasnaopen',
                                            'mid'        => 'bloodgasnamid',
                                            'close'      => 'bloodgasnaclose',
                                            'low'        => 'bloodgasnalow',
                                            'fillColors' => '#ffffff',
                                            'lineColors' => '#4db213',
                                            'label'      => 'Na (sodium) (mmol/L)',
                                            'id'         => 'b6',
                                            'boxcolor'   => '#4db213',
                                            'lineone'    => '0.2',
                                            'linetwo'    => '0.2',
                                            'linethree'  => '0.4'],

                                            ['coreName'   => 'blood_gas_k',
                                            'high'       => 'bloodgaskhigh',
                                            'open'       => 'bloodgaskopen',
                                            'mid'        => 'bloodgaskmid',
                                            'close'      => 'bloodgaskclose',
                                            'low'        => 'bloodgasklow',
                                            'fillColors' => '#ffffff',
                                            'lineColors' => '#b2a31a',
                                            'label'      => 'K (potassium) (mmol/L)',
                                            'id'         => 'b7',
                                            'boxcolor'   => '#b2a31a',
                                            'lineone'    => '0.2',
                                            'linetwo'    => '0.2',
                                            'linethree'  => '0.4'],

                                            ['coreName'   => 'blood_gas_cl',
                                            'high'       => 'bloodgasclhigh',
                                            'open'       => 'bloodgasclopen',
                                            'mid'        => 'bloodgasclmid',
                                            'close'      => 'bloodgasclclose',
                                            'low'        => 'bloodgascllow',
                                            'fillColors' => '#ffffff',
                                            'lineColors' => '#dbc418',
                                            'label'      => 'cl (Chloride) (mmol/L)',
                                            'id'         => 'b8',
                                            'boxcolor'   => '#dbc418',
                                            'lineone'    => '0.2',
                                            'linetwo'    => '0.2',
                                            'linethree'  => '0.4'],

                                            ['coreName'   => 'blood_gas_hb',
                                            'high'       => 'bloodgashbhigh',
                                            'open'       => 'bloodgashbopen',
                                            'mid'        => 'bloodgashbmid',
                                            'close'      => 'bloodgashbclose',
                                            'low'        => 'bloodgashblow',
                                            'fillColors' => '#ffffff',
                                            'lineColors' => '#5b001e',
                                            'label'      => 'HB (g/dL)',
                                            'id'         => 'b9',
                                            'boxcolor'   => '#5b001e',
                                            'lineone'    => '0.2',
                                            'linetwo'    => '0.2',
                                            'linethree'  => '0.4'],

                                            ['coreName'   => 'blood_gas_pcv',
                                            'high'       => 'bloodgaspcvhigh',
                                            'open'       => 'bloodgaspcvopen',
                                            'mid'        => 'bloodgaspcvmid',
                                            'close'      => 'bloodgaspcvclose',
                                            'low'        => 'bloodgaspcvlow',
                                            'fillColors' => '#ffffff',
                                            'lineColors' => '#e52253',
                                            'label'      => 'PCV (%)',
                                            'id'         => 'b11',
                                            'boxcolor'   => '#e52253',
                                            'lineone'    => '0.2',
                                            'linetwo'    => '0.2',
                                            'linethree'  => '0.4'],

                                            ['coreName'   => 'blood_gas_lactate',
                                            'high'       => 'bloodgaslactatehigh',
                                            'open'       => 'bloodgaslactateopen',
                                            'mid'        => 'bloodgaslactatemid',
                                            'close'      => 'bloodgaslactateclose',
                                            'low'        => 'bloodgaslactatelow',
                                            'fillColors' => '#ffffff',
                                            'lineColors' => '#20c2db',
                                            'label'      => 'Lactate',
                                            'id'         => 'b12',
                                            'boxcolor'   => '#20c2db',
                                            'lineone'    => '0.2',
                                            'linetwo'    => '0.2',
                                            'linethree'  => '0.4'],

                                            ['coreName'   => 'blood_gas_bilirubin',
                                            'high'       => 'bloodgasbilirubinhigh',
                                            'open'       => 'bloodgasbilirubinopen',
                                            'mid'        => 'bloodgasbilirubinmid',
                                            'close'      => 'bloodgasbilirubinclose',
                                            'low'        => 'bloodgasbilirubinlow',
                                            'fillColors' => '#ffffff',
                                            'lineColors' => '#e08f16',
                                            'label'      => 'Bilirubin',
                                            'id'         => 'b13',
                                            'boxcolor'   => '#e08f16',
                                            'lineone'    => '0.2',
                                            'linetwo'    => '0.2',
                                            'linethree'  => '0.4'],

                                            ['coreName'   => 'blood_sugar',
                                            'high'       => 'bloodsugarhigh',
                                            'open'       => 'bloodsugaropen',
                                            'mid'        => 'bloodsugarmid',
                                            'close'      => 'bloodsugarclose',
                                            'low'        => 'bloodsugarlow',
                                            'fillColors' => '#ffffff',
                                            'lineColors' => '#c4c4c4',
                                            'label'      => 'Blood Sugar (mg/dl)',
                                            'id'         => 'b14',
                                            'boxcolor'   => '#c4c4c4',
                                            'lineone'    => '0.2',
                                            'linetwo'    => '0.2',
                                            'linethree'  => '0.4'],

                                            ['coreName'   => 'blood_gas_methemoglobin',
                                            'high'       => 'bloodgasmethemoglobinhigh',
                                            'open'       => 'bloodgasmethemoglobinopen',
                                            'mid'        => 'bloodgasmethemoglobinmid',
                                            'close'      => 'bloodgasmethemoglobinclose',
                                            'low'        => 'bloodgasmethemoglobinlow',
                                            'fillColors' => '#ffffff',
                                            'lineColors' => '#d61b1b',
                                            'label'      => 'Methemoglobin',
                                            'id'         => 'b15',
                                            'boxcolor'   => '#d61b1b',
                                            'lineone'    => '0.2',
                                            'linetwo'    => '0.2',
                                            'linethree'  => '0.4']
                                        ];   

const BLOOD_GAS_LINE_CHART_PROPERTY  = [['column'           => 'blood_gas_ph',
                                          'drop'              => true,
                                          'adjustBorderColor' => true,
                                          'BorderColor'       => '#0a0000',
                                          'fillColor'         => '#ed5615',
                                          'propertyName'      => 'pH',
                                          'valueField'        => 'bloodgasph',
                                          'bulletType'        => 'round'
                                          ],[
                                          'column'            => 'blood_gas_pao2',
                                          'drop'              => true,
                                          'adjustBorderColor' => true,
                                          'BorderColor'       => '#0a0000',
                                          'fillColor'         => '#bf18a3',
                                          'propertyName'      => 'Pao2',
                                          'valueField'        => 'bloodgaspao2',
                                          'bulletType'        => 'square'
                                         ],[
                                          'column'            => 'blood_gas_paco2',
                                          'drop'              => true,
                                          'adjustBorderColor' => true,
                                          'BorderColor'       => '#0a0000',
                                          'fillColor'         => '#4211c6',
                                          'propertyName'      => 'PaCo2',
                                          'valueField'        => 'bloodgaspaco2',
                                          'bulletType'        => 'triangleUp'
                                        ],[
                                          'column'            => 'blood_gas_hco3',
                                          'drop'              => true,
                                          'adjustBorderColor' => true,
                                          'BorderColor'       => '#0a0000',
                                          'fillColor'         => '#32d1b3',
                                          'propertyName'      => 'HCO3',
                                          'valueField'        => 'bloodgashco3',
                                          'bulletType'        => 'triangleDown'
                                        ], [
                                          'column'            => 'blood_gas_be',
                                          'drop'              => true,
                                          'adjustBorderColor' => true,
                                          'BorderColor'       => '#0a0000',
                                          'fillColor'         => '#5b001e',
                                          'propertyName'      => 'BE',
                                          'valueField'        => 'bloodgasbe',
                                          'bulletType'        => 'bubble'
                                       ], [
                                          'column'            => 'blood_gas_na',
                                          'drop'              => true,
                                          'adjustBorderColor' => true,
                                          'BorderColor'       => '#0a0000',
                                          'fillColor'         => '#4db213',
                                          'propertyName'      => 'Na (sodium) (mmol/L)',
                                          'valueField'        => 'bloodgasna',
                                          'bulletType'        => 'bubble'
                                       ], [
                                          'column'            => 'blood_gas_k',
                                          'drop'              => true,
                                          'adjustBorderColor' => true,
                                          'BorderColor'       => '#0a0000',
                                          'fillColor'         => '#b2a31a',
                                          'propertyName'      => 'K (potassium) (mmol/L)',
                                          'valueField'        => 'bloodgask',
                                          'bulletType'        => 'bubble'
                                       ], [
                                          'column'            => 'blood_gas_cl',
                                          'drop'              => true,
                                          'adjustBorderColor' => true,
                                          'BorderColor'       => '#0a0000',
                                          'fillColor'         => '#dbc418',
                                          'propertyName'      => 'cl (Chloride) (mmol/L)',
                                          'valueField'        => 'bloodgascl',
                                          'bulletType'        => 'bubble'
                                       ], [
                                          'column'            => 'blood_gas_hb',
                                          'drop'              => true,
                                          'adjustBorderColor' => true,
                                          'BorderColor'       => '#0a0000',
                                          'fillColor'         => '#5b001e',
                                          'propertyName'      => 'HB (g/dL)',
                                          'valueField'        => 'bloodgashb',
                                          'bulletType'        => 'bubble'
                                       ], [
                                          'column'            => 'blood_gas_pcv',
                                          'drop'              => true,
                                          'adjustBorderColor' => true,
                                          'BorderColor'       => '#0a0000',
                                          'fillColor'         => '#e52253',
                                          'propertyName'      => 'PCV (%)',
                                          'valueField'        => 'bloodgaspcv',
                                          'bulletType'        => 'bubble'
                                       ], [
                                          'column'            => 'blood_gas_lactate',
                                          'drop'              => true,
                                          'adjustBorderColor' => true,
                                          'BorderColor'       => '#0a0000',
                                          'fillColor'         => '#20c2db',
                                          'propertyName'      => 'Lactate',
                                          'valueField'        => 'bloodgaslactate',
                                          'bulletType'        => 'bubble'
                                       ], [
                                          'column'            => 'blood_gas_bilirubin',
                                          'drop'              => true,
                                          'adjustBorderColor' => true,
                                          'BorderColor'       => '#0a0000',
                                          'fillColor'         => '#e08f16',
                                          'propertyName'      => 'Bilirubin',
                                          'valueField'        => 'bloodgasbilirubin',
                                          'bulletType'        => 'bubble'
                                       ],[
                                          'column'            => 'blood_sugar',
                                          'drop'              => true,
                                          'adjustBorderColor' => true,
                                          'BorderColor'       => '#0a0000',
                                          'fillColor'         => '#c4c4c4',
                                          'propertyName'      => 'Blood Sugar (mg/dl)',
                                          'valueField'        => 'bloodsugar',
                                          'bulletType'        => 'bubble'
                                       ],[
                                          'column'            => 'blood_gas_methemoglobin',
                                          'drop'              => true,
                                          'adjustBorderColor' => true,
                                          'BorderColor'       => '#0a0000',
                                          'fillColor'         => '#d61b1b',
                                          'propertyName'      => 'Methemoglobin',
                                          'valueField'        => 'bloodgasmethemoglobin',
                                          'bulletType'        => 'bubble'
                                       ]];                                                                                                                       

  const EMR_NURSE_HEADER_VALUES = ['added_nurse'];
  
  const EMR_MONITER_VALUES = [
                                  'core_temp',
                                  'peripheral_temp',
                                  'hr_rate',
                                  'cuff_systalic_bp',
                                  'cuff_diastolic_bp',
                                  'cuff_mean_bp',
                                  'arterial_systalic_bp',
                                  'arterial_diastolic_bp',
                                  'arterial_mean_bp',
                                  'preductal_sao2',
                                  'postductal_sao2',
                                  'perfusion_index',
                                  'rso2_one',
                                  'rso2_two',
                                  'baseline_rso2_one',
                                  'baseline_rso2_two',
                                  'respiratory_rate',
                                  'tcpo2',
                                  'tcpco2'
                              ];

  const EMR_VENTILATOR_VALUES = [
                                    'respiratory_rate',
                                    'mode_of_ventilation',
                                    'mode_of_ventilation_invasive',
                                    'targeted_tidal_volume',
                                    'p_amplitude',
                                    'pip_set',
                                    'pip_delivered',
                                    'peep',
                                    'map',
                                    'fio2',
                                    'flow',
                                    'delivered_tidal_volume',
                                    'rate',
                                    'frequency',
                                    'it_rate',
                                    'it_rate_secound',
                                    'ie_r',
                                    'cpap_interface_change',
                                    'humidifier_temp',
                                    'air_entry_right',
                                    'air_entry_left',
                                    'volume_targeting',
                                    'it_measured',
                                    'trigger_count',
                                    'o2_status',
                                    'delivered_fio2',
                                    'fio2_measured',
                                    'ventilator_saturation',
                                    'set_auto_o2_target_range'
                                ];

  const EMR_NURSE_MANUAL_VALUES = [
                                    'type_of_care',
                                    'warmer',
                                    'incubator',
                                    'core_temp',
                                    't1_t2',
                                    'therapeutic_hypothermia',
                                    'rectal_temp',
                                    'respiratory_rate',
                                    'bp_method',
                                    'arterial_systalic_bp',
                                    'arterial_diastolic_bp',
                                    'arterial_mean_bp',
                                    'color',
                                    'activity',
                                    'position',
                                    'work_of_breathing',
                                    'physiotherapy',
                                    'suction',
                                    'type_of_feeds',
                                    'human_milk_fortification',
                                    'milk_volume',
                                    'kmc',
                                    'nns',
                                    'gastric_aspirate_volume',
                                    'gastric_aspirate_volume_total',
                                    'gastric_aspirate',
                                    'urine_output',
                                    'blood_volume_out',
                                    'drain_output_r',
                                    'drain_output_l',
                                    'bowels',
                                    'bowels_count',
                                    'bowels_count_total',
                                    'stools_nature',
                                    'intravenous_fluids',
                                    'oral_fluids',
                                    'other_drugs',
                                    'total_intake_ml',
                                    'total_intake_kg',
                                    'Transfusion',
                                    'f_product_temp',
                                    'aspirate_ml',
                                    'drains_ml',
                                    'urine_total',
                                    'urine_total_full_day',
                                    'urine_total_ml_kg',
                                    'blood_out_total',
                                    'stools_frequency',
                                    'stoma_output',
                                    'total_output',
                                    'total_output_ml_day',
                                    'i_o_balance',
                                    'i_o_balance_ml_kg',
                                    'blood_gas_type',
                                    'last_bg_time',
                                    'current_weight',
                                    'working_weight',
                                    'et_size',
                                    'et_length',
                                    'ngt_size',
                                    'ngt_length',
                                    'route_of_feeds',
                                    'milk_volume_total',
                                    'urine_output_total',
                                    'blood_volume_out_total',
                                    'drain_output_r_total',
                                    'drain_output_l_total',
                                    'stoma_output_hour_total',
                                    'stoma_output_hour',
                                    'milk_feeds',
                                    'respiratory_rate_measured',
                                    'ward_rounds_instruction'
                                ];
  const EMR_LAB_VALUES = [
                            'blood_gas_ph',
                            'blood_gas_pao2',
                            'blood_gas_paco2',
                            'blood_gas_hco3',
                            'blood_gas_be',
                            'blood_gas_na',
                            'blood_gas_k',
                            'blood_gas_cl',
                            'blood_gas_hb',
                            'blood_gas_pcv',
                            'blood_gas_lactate',
                            'blood_gas_bilirubin',
                            'blood_sugar',
                            'blood_gas_methemoglobin',
                            'blood_gas_calcium',

                            'interface_blood_gas_ph',
                            'interface_blood_gas_pao2',
                            'interface_blood_gas_paco2',
                            'interface_blood_gas_hco3',
                            'interface_blood_gas_be',
                            'interface_blood_gas_na',
                            'interface_blood_gas_k',
                            'interface_blood_gas_cl',
                            'interface_blood_gas_hb',
                            'interface_blood_gas_pcv',
                            'interface_blood_gas_lactate',
                            'interface_blood_gas_bilirubin',
                            'interface_blood_gas_blood_sugar',
                            'interface_blood_gas_methemoglobin',
                            'interface_blood_gas_calcium',
                            'gluco_meter_calcium',
                            'gluco_meter_magnesium',
                            'gluco_meter_phosphorus',
                            'gluco_meter_bun',
                            'gluco_meter_creatintine',
                            'gluco_meter_glucose',
                            'gluco_meter_creatinekinase',
                            'gluco_meter_ckmb',
                            'gluco_meter_trop',
                            'gluco_meter_totalbilirubin',
                            'gluco_meter_directbilirubin',
                            'gluco_meter_sgot',
                            'gluco_meter_sgpt',
                            'gluco_meter_alkalinephosphatase',
                            'gluco_meter_gamagtp',
                            'gluco_meter_ldh',
                            'gluco_meter_amylase',
                            'gluco_meter_lipase',
                            'gluco_meter_totalprotein',
                            'gluco_meter_albumin',
                            'gluco_meter_totalcholesterol',
                            'gluco_meter_hdl',
                            'gluco_meter_ldl',
                            'gluco_meter_vldl',
                            'gluco_meter_triglycerides',
                            'gluco_meter_rbc',
                            'gluco_meter_haematocrit',
                            'gluco_meter_reticulocytecount',
                            'gluco_meter_wbc',
                            'gluco_meter_dc',
                            'gluco_meter_lymph',
                            'gluco_meter_mono',
                            'gluco_meter_eos',
                            'gluco_meter_baso',
                            'gluco_meter_platelets',
                            'gluco_meter_esr',
                            'gluco_meter_prothrombintime',
                            'gluco_meter_aptt',
                            'gluco_meter_inr',
                            'gluco_meter_fibrinogen',
                            'gluco_meter_fdp',
                            'interface_blood_gas_etco2',
                        ];

  const INVASIVE_VENTILATION = ["CMV",
          "IMV",
          "SIMV",
          "PSV",
          "PTV",
          "HFOV",
          "HFOV + CMV"
      ];
  const NON_INVASIVE_VENTILATION = ["CPAP",
          "High Flow O2", 
          "NIPPV (D)",
          "NIPPV Tr",
          "nippv tr",
          "NHFOV (D)",
          "NCPAP (S)", 
          "DUOPAP",
          "NCPAP (D)",
          "nCPAP (D)"];
  const ABG_TEST_LIST = [
    "blood_gas_type",
          "last_bg_time", 
          "interface_blood_gas_ph",
          "interface_blood_gas_pao2",
          self::LOINC_LOCAL_CODE[120],
          "interface_blood_gas_paco2",
          self::LOINC_LOCAL_CODE[119],
          "interface_blood_gas_etco2",
          "interface_blood_gas_hco3",
          "interface_blood_gas_be",
          "interface_blood_gas_na",
          "interface_blood_gas_k",
          "interface_blood_gas_calcium",
          "interface_blood_gas_cl",
          "interface_blood_gas_hb",
          "interface_blood_gas_pcv",
          "interface_blood_gas_lactate",
          "interface_blood_gas_bilirubin",
          "interface_blood_gas_blood_sugar",
          "blood_sugar",
          "interface_blood_gas_methemoglobin"
        ];


}
