<?php

use Illuminate\Database\Seeder;

class ConfigSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('config_settings')->delete();

        \DB::table('config_settings')->insert(array(
        	0 => 
            array (
	        	'slug_code'		=>	'VITALS_GROUP_ONE',
	        	'code_values' 	=> 	'["core_temp","peripheral_temp","t1_t2"]',
	        	'status' 		=>	true
	        ),
        	1 => 
            array (
	        	'slug_code'		=>	'VITALS_LABEL',
	        	'code_values' 	=> 	'{"core_temp": "Core Temp (T1)","peripheral_temp": "Peripheral Temp (T2)", "t1_t2": "T1 - T2", "hr_rate": "Heart Rate", "respiratory_rate": "Baby\'s Respiratory Rate", "cuff_systalic_bp": "Cuff Systolic BP", "cuff_diastolic_bp": "Cuff Diastolic BP", "cuff_mean_bp": "Cuff Mean BP", "arterial_systalic_bp": "Arterial Systolic BP", "arterial_diastolic_bp": "Arterial Diastolic BP", "arterial_mean_bp": "Arterial Mean BP", "preductal_sao2": "Sao2" }',
	        	'status' 		=>	true
	        ),
        	2 => 
            array (
	        	'slug_code'		=>	'VITALS_PARAMETERS',
	        	'code_values' 	=> 	'[[{"parameter": "core_temp", "parameter_color": "#e50d0d", "parameter_title": "Core Temp (T1)", "parameter_checked": true, "parameter_charttype": "2" }, { "parameter": "peripheral_temp", "parameter_color": "#d509f4", "parameter_title": "Peripheral Temp (T2)", "parameter_checked": true, "parameter_charttype": "2"}, {"parameter": "t1_t2", "parameter_color": "#2d2d2d", "parameter_title": "T1 - T2", "parameter_checked": true, "parameter_charttype": "2" }, {"parameter": "hr_rate", "parameter_color": "#236d1b", "parameter_title": "Heart Rate", "parameter_checked": true, "parameter_charttype": "2"}, {"parameter": "respiratory_rate", "parameter_color": "#0a0000", "parameter_title": "Baby\'s Respiratory Rate", "parameter_checked": true, "parameter_charttype": "2"}, {"parameter": "cuff_systalic_bp", "parameter_color": "#dadd11", "parameter_title": "Cuff Systolic BP", "parameter_checked": true, "parameter_charttype": "1"}, {"parameter": "cuff_diastolic_bp", "parameter_color": "#1edbcb", "parameter_title": "Cuff Diastolic BP", "parameter_checked": true, "parameter_charttype": "1" }, {"parameter": "cuff_mean_bp", "parameter_color": "#8e0517", "parameter_title": "Cuff Mean BP", "parameter_checked": true, "parameter_charttype": "1" }, {"parameter": "arterial_systalic_bp", "parameter_color": "#1c99d8", "parameter_title": "Arterial Systolic BP", "parameter_checked": true, "parameter_charttype": "2"}, {"parameter": "arterial_diastolic_bp", "parameter_color": "#4420ad", "parameter_title": "Arterial Diastolic BP", "parameter_checked": true, "parameter_charttype": "2" }, {"parameter": "arterial_mean_bp", "parameter_color": "#c46b1d", "parameter_title": "Arterial Mean BP", "parameter_checked": true, "parameter_charttype": "2"}, {"parameter": "preductal_sao2", "parameter_color": "#c46b1d", "parameter_title": "Sao2", "parameter_checked": true, "parameter_charttype": "2"}]]',
	        	'status' 		=>	true
	        ),
        	3 => 
            array (
	        	'slug_code'		=>	'VITALS_GROUP_TWO',
	        	'code_values' 	=> 	'["hr_rate","respiratory_rate"]',
	        	'status' 		=>	true
	        ),
        	4 => 
            array (
	        	'slug_code'		=>	'VENTILATOR_PARAMETERS',
	        	'code_values' 	=> 	'[{"parameter": "targeted_tidal_volume", "parameter_color": "#ea1212", "parameter_title": "Targeted Tidal Volume", "parameter_checked": true, "parameter_chattype": 1, "parameter_decimal_range": null, "parameter_valueaxis_min":null, "parameter_valueaxis_max":null, "parameter_includeAllValues":false, "parameter_strictMinMax":false}, {"parameter": "delivered_tidal_volume", "parameter_color": "#1c99d8", "parameter_title": "Delivered Tidal Volume", "parameter_checked": false, "parameter_chattype": 1, "parameter_decimal_range": null, "parameter_valueaxis_min":null, "parameter_valueaxis_max":null, "parameter_includeAllValues":false, "parameter_strictMinMax":false}, {"parameter": "p_amplitude", "parameter_color": "#ea0be6", "parameter_title": "ΔP/Amplitude", "parameter_checked": false, "parameter_chattype": 1, "parameter_decimal_range": null, "parameter_valueaxis_min":null, "parameter_valueaxis_max":null, "parameter_includeAllValues":false, "parameter_strictMinMax":false}, {"parameter": "pip_set", "parameter_color": "#2620e5", "parameter_title": "PIP (set)", "parameter_checked": false, "parameter_chattype": 2, "parameter_decimal_range": null, "parameter_valueaxis_min":null, parameter_valueaxis_max":null, "parameter_includeAllValues":false, "parameter_strictMinMax":false}, {"parameter": "pip_delivered", "parameter_color": "#10edd3", "parameter_title": "PIP (delivered)", "parameter_checked": false, "parameter_chattype": 1, "parameter_decimal_range": null, "parameter_valueaxis_min":null, "parameter_valueaxis_max":null, "parameter_includeAllValues":false, "parameter_strictMinMax":false}, { "parameter": "peep", "parameter_color": "#b7b7b7", "parameter_title": "PEEP", "parameter_checked": false, "parameter_chattype": 2, "parameter_decimal_range": null, "parameter_valueaxis_min":null, "parameter_valueaxis_max":null, "parameter_includeAllValues":false, "parameter_strictMinMax":false}, {"parameter": "map", "parameter_color": "#e5e514", "parameter_title": "MAP", "parameter_checked": false, "parameter_chattype": 1, "parameter_decimal_range": null, "parameter_valueaxis_min":null, "parameter_valueaxis_max":null, "parameter_includeAllValues":false, "parameter_strictMinMax":false}, {"parameter": "fio2", "parameter_color": "#1edbcb", "parameter_title": "FiO2 %", "parameter_checked": false, "parameter_chattype": 2, "parameter_decimal_range": null, "parameter_valueaxis_min":null, "parameter_valueaxis_max":null, "parameter_includeAllValues":false, "parameter_strictMinMax":false}, {"parameter": "flow", "parameter_color": "#7c2d9e", "parameter_title": "FLOW", "parameter_checked": false, "parameter_chattype": 1, "parameter_decimal_range": null, "parameter_valueaxis_min":null, "parameter_valueaxis_max":null, "parameter_includeAllValues":false, "parameter_strictMinMax":false}, {"parameter": "rate", "parameter_color": "#4420ad", "parameter_title": "RATE/V (Set Ventilator Rate)", "parameter_checked": false, "parameter_chattype": 2, "parameter_decimal_range": null, "parameter_valueaxis_min":null, "parameter_valueaxis_max":null, "parameter_includeAllValues":false, "parameter_strictMinMax":false}, {"parameter": "frequency", "parameter_color": "#d6a206", "parameter_title": "Frequency (H2)", "parameter_checked": false, "parameter_chattype": 2, "parameter_decimal_range": null, "parameter_valueaxis_min":null, "parameter_valueaxis_max":null, "parameter_includeAllValues":false, "parameter_strictMinMax":false}, {"parameter": "it_rate", "parameter_color": "#007a0a", "parameter_title": "IT(%)", "parameter_checked": false, "parameter_chattype": 2, "parameter_decimal_range": null, "parameter_valueaxis_min":null, "parameter_valueaxis_max":null, "parameter_includeAllValues":false, "parameter_strictMinMax":false}, {"parameter": "it_rate_secound", "parameter_color": "#5b001e", "parameter_title": "IT(S)", "parameter_checked": false, "parameter_chattype": 2, "parameter_decimal_range":2, "parameter_valueaxis_min":0.2, "parameter_valueaxis_max":1.5, "parameter_includeAllValues":true, "parameter_strictMinMax":true}, {"parameter": "respiratory_rate", "parameter_color": "#0a0000", "parameter_title": "Baby\'s Respiratory Rate", "parameter_checked": true, "parameter_chattype": 1, "parameter_decimal_range": null, "parameter_valueaxis_min":null, "parameter_valueaxis_max":null, "parameter_includeAllValues":false, "parameter_strictMinMax":false}]',
	        	'status' 		=>	true
	        ),
        	5 => 
            array (
	        	'slug_code'		=>	'VITALS_GROUP_THREE',
	        	'code_values' 	=> 	'["cuff_systalic_bp","cuff_diastolic_bp","cuff_mean_bp"]',
	        	'status' 		=>	true
	        ),
        	6 => 
            array (
	        	'slug_code'		=>	'BLOOD_GAS_PARAMETERS',
	        	'code_values' 	=> 	'[{"parameter":"blood_gas_ph","parameter_title":"pH","parameter_color":"#ed5615","parameter_checked":true},{"parameter":"blood_gas_pao2","parameter_title":"Pao2","parameter_color":"#bf18a3","parameter_checked":false},{"parameter":"blood_gas_paco2","parameter_title":"PaCo2","parameter_color":"#4211c6","parameter_checked":false},{"parameter":"blood_gas_hco3","parameter_title":"HCO3","parameter_color":"#32d1b3","parameter_checked":false},{"parameter":"blood_gas_be","parameter_title":"BE","parameter_color":"#5b001e","parameter_checked":false},{"parameter":"blood_gas_na","parameter_title":"Na (sodium) (mmol\/L)","parameter_color":"#4db213","parameter_checked":false},{"parameter":"blood_gas_k","parameter_title":"K (potassium) (mmol\/L)","parameter_color":"#b2a31a","parameter_checked":false},{"parameter":"blood_gas_cl","parameter_title":"cl (Chloride) (mmol\/L)","parameter_color":"#dbc418","parameter_checked":false},{"parameter":"blood_gas_hb","parameter_title":"HB (g\/dL)","parameter_color":"#5b001e","parameter_checked":false},{"parameter":"blood_gas_pcv","parameter_title":"PCV (%)","parameter_color":"#e52253","parameter_checked":false},{"parameter":"blood_gas_lactate","parameter_title":"Lactate","parameter_color":"#20c2db","parameter_checked":false},{"parameter":"blood_gas_bilirubin","parameter_title":"Bilirubin","parameter_color":"#e08f16","parameter_checked":false},{"parameter":"blood_sugar","parameter_title":"Blood Sugar (mg\/dl)","parameter_color":"#c4c4c4","parameter_checked":false},{"parameter":"blood_gas_methemoglobin","parameter_title":"Methemoglobin","parameter_color":"#d61b1b","parameter_checked":false}]',
	        	'status' 		=>	true
	        ),
        	7 => 
            array (
	        	'slug_code'		=>	'LOINC_LOCAL_CODE',
	        	'code_values' 	=> 	'["type_of_feeds","rectal_temp","type_of_care","warmer","work_of_breathing","core_temp","peripheral_temp","hr_rate","respiratory_rate","bp_method","cuff_systalic_bp","cuff_diastolic_bp","cuff_mean_bp","arterial_systalic_bp","arterial_diastolic_bp","arterial_mean_bp","preductal_sao2","postductal_sao2","color","mode_of_ventilation","p_amplitude","pip_set","pip_delivered","peep","map","fio2","flow","rate","it_rate","frequency","it_rate_secound","ie_r","cpap_interface_change","humidifier_temp","physiotherapy","suction","route_of_feeds","respiratory_rate","urine_output","bowels","gastric_aspirate_volume","gastric_aspirate","drain_output_r","drain_output_l","drains_ml","blood_volume_out","et_size","incubator","blood_sugar","current_weight","working_weight","activity","targeted_tidal_volume","delivered_tidal_volume","human_milk_fortification","milk_volume","Transfusion","stools_nature","intravenous_fluids","oral_fluids","other_drugs","total_intake_ml","total_intake_kg","aspirate_ml","urine_total","urine_total_ml_kg","blood_out_total","stools_frequency","stoma_output","i_o_balance","i_o_balance_ml_kg","air_entry_right","air_entry_left","volume_targeting","hhhfnc","physiotherapy","suction","human_milk_fortification","kmc","nns","bowels","position","et_length","ngt_size","ngt_length","milk_feeds","milk_volume_total","stoma_output_hour_total","stoma_output_hour","blood_gas_type","last_bg_time","blood_gas_ph","blood_gas_pao2","blood_gas_paco2","blood_gas_hco3","blood_gas_be","blood_gas_na","blood_gas_k","blood_gas_cl","blood_gas_hb","blood_gas_pcv","blood_gas_lactate","blood_gas_bilirubin","blood_gas_methemoglobin","therapeutic_hypothermia","gastric_aspirate_volume_total","urine_output_total","blood_volume_out_total","drain_output_r_total","drain_output_l_total","mode_of_ventilation_invasive"]',
	        	'status' 		=>	true
	        ),
        	8 => 
            array (
	        	'slug_code'		=>	'VITALS_GROUP_FOUR',
	        	'code_values' 	=> 	'["arterial_systalic_bp","arterial_diastolic_bp","arterial_mean_bp"]',
	        	'status' 		=>	true
	        ),
        	9 => 
            array (
	        	'slug_code'		=>	'BASIC_DETAILS',
	        	'code_values' 	=> 	'["current_weight","working_weight","et_size","et_length","ngt_size","ngt_length"]',
	        	'status' 		=>	true
	        ),
        	10 => 
            array (
	        	'slug_code'		=>	'VENTILATOR_GROUP_ONE',
	        	'code_values' 	=> 	'["targeted_tidal_volume","delivered_tidal_volume"]',
	        	'status' 		=>	true
	        ),
        	11 => 
            array (
	        	'slug_code'		=>	'VENTILATOR_GROUP_TWO',
	        	'code_values' 	=> 	'["pip_set","pip_delivered","p_amplitude"]',
	        	'status' 		=>	true
	        ),
        	12 => 
            array (
	        	'slug_code'		=>	'OUTPUT_GROUPS',
	        	'code_values' 	=> 	'["gastric_aspirate_volume","gastric_aspirate","urine_output","blood_volume_out","drain_output_r","drain_output_l","bowels","stools_nature","nns","bowels","blood_sugar"]',
	        	'status' 		=>	true
	        ),
        	13 => 
            array (
	        	'slug_code'		=>	'VENTILATOR_GROUP_THREE',
	        	'code_values' 	=> 	'["peep","map"]',
	        	'status' 		=>	true
	        ),
        	14 => 
            array (
	        	'slug_code'		=>	'MILK_FEEDS',
	        	'code_values' 	=> 	'["milk_feeds","type_of_feeds","route_of_feeds","human_milk_fortification","milk_volume","milk_volume_total"]',
	        	'status' 		=>	true
	        ),
        	15 => 
            array (
	        	'slug_code'		=>	'OUTPUT_RUNNING_TOTAL',
	        	'code_values' 	=> 	'["gastric_aspirate_volume","urine_output","blood_volume_out","drain_output_r","drain_output_l","blood_sugar"]',
	        	'status' 		=>	true
	        ),
        	16 => 
            array (
	        	'slug_code'		=>	'VENTILATOR_GROUP_FOUR',
	        	'code_values' 	=> 	'["fio2","flow"]',
	        	'status' 		=>	true
	        ),
        	17 => 
            array (
	        	'slug_code'		=>	'VENDILATOR_BOX_WHISKER_PROPERTY',
	        	'code_values' 	=> 	'[{"coreName":"targeted_tidal_volume","high":"targetedtidalvolumehigh","open":"targetedtidalvolumeopen","mid":"targetedtidalvolumemid","close":"targetedtidalvolumeclose","low":"targetedtidalvolumelow","fillColors":"#ffffff","lineColors":"#ea1212","label":"Targeted Tidal Volume","id":"v1","boxcolor":"#ea1212","lineone":"0.2","linetwo":"0.2","linethree":"0.4"},{"coreName":"p_amplitude","high":"pamplitudehigh","open":"pamplitudeopen","mid":"pamplitudemid","close":"pamplitudeclose","low":"pamplitudelow","fillColors":"#ffffff","lineColors":"#ea0be6","label":"\u0394P\/Amplitude","id":"v2","boxcolor":"#ea0be6","lineone":"0.2","linetwo":"0.2","linethree":"0.4"},{"coreName":"pip_set","high":"pipsethigh","open":"pipsetopen","mid":"pipsetmid","close":"pipsetclose","low":"pipsetlow","fillColors":"#ffffff","lineColors":"#2620e5","label":"PIP (set)","id":"v3","boxcolor":"#2620e5","lineone":"0.2","linetwo":"0.2","linethree":"0.4"},{"coreName":"pip_delivered","high":"pipdeliveredhigh","open":"pipdeliveredopen","mid":"pipdeliveredmid","close":"pipdeliveredclose","low":"pipdeliveredlow","fillColors":"#ffffff","lineColors":"#10edd3","label":"PIP (delivered)","id":"v4","boxcolor":"#10edd3","lineone":"0.2","linetwo":"0.2","linethree":"0.4"},{"coreName":"peep","high":"peephigh","open":"peepopen","mid":"peepmid","close":"peepclose","low":"peeplow","fillColors":"#ffffff","lineColors":"#b7b7b7","label":"PEEP","id":"v5","boxcolor":"#b7b7b7","lineone":"0.2","linetwo":"0.2","linethere":" 0.4"},{"coreName":"map","high":"maphigh","open":"mapopen","mid":"mapmid","close":"mapclose","low":"maplow","fillColors":"#ffffff","lineColors":"#e5e514","label":"MAP","id":"v5","boxcolor":"#e5e514","lineone":"0.2","linetwo":"0.2","linethere":" 0.4"},{"coreName":"fio2","high":"fio2high","open":"fio2open","mid":"fio2mid","close":"fio2close","low":"fio2low","fillColors":"#ffffff","lineColors":"#1edbcb","label":"FiO2 %","id":"v6","boxcolor":"#1edbcb","lineone":"0.2","linetwo":"0.2","linethere":" 0.4"},{"coreName":"flow","high":"flowhigh","open":"flowopen","mid":"flowmid","close":"flowclose","low":"flowlow","fillColors":"#ffffff","lineColors":"#7c2d9e","label":"FLOW","id":"v7","boxcolor":"#7c2d9e","lineone":"0.2","linetwo":"0.2","linethere":" 0.4"},{"coreName":"delivered_tidal_volume","high":"deliveredtidalvolumehigh","open":"deliveredtidalvolumeopen","mid":"deliveredtidalvolumemid","close":"deliveredtidalvolumeclose","low":"deliveredtidalvolumelow","fillColors":"#ffffff","lineColors":"#1c99d8","label":"Delivered Tidal Volume","id":"v8","boxcolor":"#1c99d8","lineone":"0.2","linetwo":"0.2","linethere":" 0.4"},{"coreName":"rate","high":"ratehigh","open":"rateopen","mid":"ratemid","close":"rateclose","low":"ratelow","fillColors":"#ffffff","lineColors":"#4420ad","label":"RATE\/V (Set Ventilator Rate)","id":"v9","boxcolor":"#4420ad","lineone":"0.2","linetwo":"0.2","linethere":" 0.4"},{"coreName":"frequency","high":"frequencyhigh","open":"frequencyopen","mid":"frequencymid","close":"frequencyclose","low":"frequencylow","fillColors":"#ffffff","lineColors":"#d6a206","label":"Frequency (H2)","id":"v10","boxcolor":"#d6a206","lineone":"0.2","linetwo":"0.2","linethere":" 0.4"},{"coreName":"it_rate","high":"itratehigh","open":"itrateopen","mid":"itratemid","close":"itrateclose","low":"itratelow","fillColors":"#ffffff","lineColors":"#007a0a","label":"IT(%)","id":"v11","boxcolor":"#007a0a","lineone":"0.2","linetwo":"0.2","linethere":" 0.4"},{"coreName":"it_rate_secound","high":"itratesecoundhigh","open":"itratesecoundopen","mid":"itratesecoundmid","close":"itratesecoundclose","low":"itratesecoundlow","fillColors":"#ffffff","lineColors":"#5b001e","label":"IT(S)","id":"v12","boxcolor":"#5b001e","lineone":"0.2","linetwo":"0.2","linethere":" 0.4"},{"coreName": "respiratory_rate", "high": "respiratoryratehigh","open": "respiratoryrateopen","mid": "respiratoryratemid","close": "respiratoryrateclose","low": "respiratoryratelow","fillColors": "#ffffff","lineColors": "#0a0000","label": "RR","id": "g6","boxcolor": "#0a0000","lineone": "0.2","linetwo": "0.2","linethere": " 0.4"}]',
	        	'status' 		=>	true
	        ),
        	18 => 
            array (
	        	'slug_code'		=>	'VENTILATOR_GROUP_FIVE',
	        	'code_values' 	=> 	'["it_rate","it_rate_secound"]',
	        	'status' 		=>	true
	        ),
        	19 => 
            array (
	        	'slug_code'		=>	'VENTILATOR_LINE_CHART_PROPERTY',
	        	'code_values' 	=> 	'[{ "drop": true, "column": "targeted_tidal_volume", "fillColor": "#ea1212", "bulletType": "round", "valueField": "targetedtidalvolume", "BorderColor": "#0a0000", "propertyName": "Targeted Tidal Volume", "adjustBorderColor": true}, {"drop": true, "column": "p_amplitude", "fillColor": "#ea0be6", "bulletType": "square", "valueField": "pamplitude", "BorderColor": "#0a0000", "propertyName": "ΔP/Amplitude", "adjustBorderColor": true}, {"drop": true, "column": "pip_set", "fillColor": "#2620e5", "bulletType": "triangleUp", "valueField": "pipset", "BorderColor": "#0a0000", "propertyName": "PIP (set)", "adjustBorderColor": true}, {"drop": true, "column": "pip_delivered", "fillColor": "#10edd3", "bulletType": "triangleDown", "valueField": "pipdelivered", "BorderColor": "#0a0000", "propertyName": "PIP (delivered)", "adjustBorderColor": true}, {"drop": true, "column": "peep", "fillColor": "#b7b7b7", "bulletType": "bubble", "valueField": "peep", "BorderColor": "#0a0000", "propertyName": "PEEP", "adjustBorderColor": true}, {"drop": true, "column": "map", "fillColor": "#e5e514", "bulletType": "bubble", "valueField": "map", "BorderColor": "#0a0000", "propertyName": "MAP", "adjustBorderColor": true}, {"drop": true, "column": "fio2", "fillColor": "#1edbcb", "bulletType": "bubble", "valueField": "fio2", "BorderColor": "#0a0000", "propertyName": "FiO2 %", "adjustBorderColor": true}, {"drop": true, "column": "flow", "fillColor": "#7c2d9e", "bulletType": "bubble", "valueField": "flow", "BorderColor": "#0a0000", "propertyName": "FLOW", "adjustBorderColor": true}, {"drop": true, "column": "delivered_tidal_volume", "fillColor": "#1c99d8", "bulletType": "bubble", "valueField": "deliveredtidalvolume", "BorderColor": "#0a0000", "propertyName": "FLOW", "adjustBorderColor": true}, {"drop": true, "column": "frequency", "fillColor": "#d6a206", "bulletType": "bubble", "valueField": "frequency", "BorderColor": "#0a0000", "propertyName": "Frequency (H2)", "adjustBorderColor": true}, {"drop": true, "column": "it_rate", "fillColor": "#007a0a", "bulletType": "bubble", "valueField": "itrate", "BorderColor": "#0a0000", "propertyName": "IT(%)", "adjustBorderColor": true}, {"drop": true, "column": "it_rate_secound", "fillColor": "#4420ad", "bulletType": "bubble", "valueField": "itratesecound", "BorderColor": "#0a0000", "propertyName": "IT(S)", "adjustBorderColor": true}, {"drop": true, "column": "respiratory_rate", "fillColor": "#0a0000", "bulletType": "round", "valueField": "respiratoryrate", "BorderColor": "#0a0000", "propertyName": "RR", "adjustBorderColor": true}, {"drop": true, "column": "rate", "fillColor": "#0a0000", "bulletType": "round", "valueField": "rate", "BorderColor": "#0a0000", "propertyName": "RR", "adjustBorderColor": true}]',
	        	'status' 		=>	true
	        ),
        	20 => 
            array (
	        	'slug_code'		=>	'VENTILATOR_GROUP_SIX',
	        	'code_values' 	=> 	'["rate","frequency","respiratory_rate"]',
	        	'status' 		=>	true
	        ),
        	21 => 
            array (
	        	'slug_code'		=>	'VENTILATOR_GROUP',
	        	'code_values' 	=> 	'[{"param":"targeted_tidal_volume","name":"targeted"},{"param":"delivered_tidal_volume","name":"delivered tidal volume"},{"param":"pip_set","name":"pip (set) "},{"param":"pip_delivered","name":" (delivered)"},{"param":"p_amplitude","name":"p\/amplitude"},{"param":"peep","name":"peep"},{"param":"map","name":"map"},{"param":"fio2","name":"fio2"},{"param":"flow","name":"flow"},{"param":"it_rate","name":"it rate (%)"},{"param":"it_rate_secound","name":"secound"},{"param":"rate","name":"rate"},{"param":"frequency","name":"frequency"},{"param":"respiratory_rate","name":"Baby\'s RR"}]',
	        	'status' 		=>	true
	        ),
        	22 => 
            array (
	        	'slug_code'		=>	'BLOOD_GAS_BOX_WHISKER_PROPERTY',
	        	'code_values' 	=> 	'[{"coreName":"blood_gas_ph","high":"bloodgasphhigh","open":"bloodgasphopen","mid":"bloodgasphmid","close":"bloodgasphclose","low":"bloodgasphlow","fillColors":"#ffffff","lineColors":"#ed5615","label":"pH","id":"b1","boxcolor":"#ed5615","lineone":"0.2","linetwo":"0.2","linethree":"0.4"},{"coreName":"blood_gas_pao2","high":"bloodgaspao2high","open":"bloodgaspao2open","mid":"bloodgaspao2mid","close":"bloodgaspao2close","low":"bloodgaspao2low","fillColors":"#ffffff","lineColors":"#bf18a3","label":"Pao2","id":"b2","boxcolor":"#bf18a3","lineone":"0.2","linetwo":"0.2","linethree":"0.4"},{"coreName":"blood_gas_paco2","high":"bloodgaspaco2high","open":"bloodgaspaco2open","mid":"bloodgaspaco2mid","close":"bloodgaspaco2close","low":"bloodgaspaco2low","fillColors":"#ffffff","lineColors":"#4211c6","label":"PaCo2","id":"b3","boxcolor":"#4211c6","lineone":"0.2","linetwo":"0.2","linethree":"0.4"},{"coreName":"blood_gas_hco3","high":"bloodgashco3high","open":"bloodgashco3open","mid":"bloodgashco3mid","close":"bloodgashco3close","low":"bloodgashco3low","fillColors":"#ffffff","lineColors":"#32d1b3","label":"HCO3","id":"b4","boxcolor":"#32d1b3","lineone":"0.2","linetwo":"0.2","linethree":"0.4"},{"coreName":"blood_gas_be","high":"bloodgasbehigh","open":"bloodgasbeopen","mid":"bloodgasbemid","close":"bloodgasbeclose","low":"bloodgasbelow","fillColors":"#ffffff","lineColors":"#5b001e","label":"BE","id":"b5","boxcolor":"#5b001e","lineone":"0.2","linetwo":"0.2","linethree":"0.4"},{"coreName":"blood_gas_na","high":"bloodgasnahigh","open":"bloodgasnaopen","mid":"bloodgasnamid","close":"bloodgasnaclose","low":"bloodgasnalow","fillColors":"#ffffff","lineColors":"#4db213","label":"Na (sodium) (mmol\/L)","id":"b6","boxcolor":"#4db213","lineone":"0.2","linetwo":"0.2","linethree":"0.4"},{"coreName":"blood_gas_k","high":"bloodgaskhigh","open":"bloodgaskopen","mid":"bloodgaskmid","close":"bloodgaskclose","low":"bloodgasklow","fillColors":"#ffffff","lineColors":"#b2a31a","label":"K (potassium) (mmol\/L)","id":"b7","boxcolor":"#b2a31a","lineone":"0.2","linetwo":"0.2","linethree":"0.4"},{"coreName":"blood_gas_cl","high":"bloodgasclhigh","open":"bloodgasclopen","mid":"bloodgasclmid","close":"bloodgasclclose","low":"bloodgascllow","fillColors":"#ffffff","lineColors":"#dbc418","label":"cl (Chloride) (mmol\/L)","id":"b8","boxcolor":"#dbc418","lineone":"0.2","linetwo":"0.2","linethree":"0.4"},{"coreName":"blood_gas_hb","high":"bloodgashbhigh","open":"bloodgashbopen","mid":"bloodgashbmid","close":"bloodgashbclose","low":"bloodgashblow","fillColors":"#ffffff","lineColors":"#5b001e","label":"HB (g\/dL)","id":"b9","boxcolor":"#5b001e","lineone":"0.2","linetwo":"0.2","linethree":"0.4"},{"coreName":"blood_gas_pcv","high":"bloodgaspcvhigh","open":"bloodgaspcvopen","mid":"bloodgaspcvmid","close":"bloodgaspcvclose","low":"bloodgaspcvlow","fillColors":"#ffffff","lineColors":"#e52253","label":"PCV (%)","id":"b11","boxcolor":"#e52253","lineone":"0.2","linetwo":"0.2","linethree":"0.4"},{"coreName":"blood_gas_lactate","high":"bloodgaslactatehigh","open":"bloodgaslactateopen","mid":"bloodgaslactatemid","close":"bloodgaslactateclose","low":"bloodgaslactatelow","fillColors":"#ffffff","lineColors":"#20c2db","label":"Lactate","id":"b12","boxcolor":"#20c2db","lineone":"0.2","linetwo":"0.2","linethree":"0.4"},{"coreName":"blood_gas_bilirubin","high":"bloodgasbilirubinhigh","open":"bloodgasbilirubinopen","mid":"bloodgasbilirubinmid","close":"bloodgasbilirubinclose","low":"bloodgasbilirubinlow","fillColors":"#ffffff","lineColors":"#e08f16","label":"Bilirubin","id":"b13","boxcolor":"#e08f16","lineone":"0.2","linetwo":"0.2","linethree":"0.4"},{"coreName":"blood_sugar","high":"bloodsugarhigh","open":"bloodsugaropen","mid":"bloodsugarmid","close":"bloodsugarclose","low":"bloodsugarlow","fillColors":"#ffffff","lineColors":"#c4c4c4","label":"Blood Sugar (mg\/dl)","id":"b14","boxcolor":"#c4c4c4","lineone":"0.2","linetwo":"0.2","linethree":"0.4"},{"coreName":"blood_gas_methemoglobin","high":"bloodgasmethemoglobinhigh","open":"bloodgasmethemoglobinopen","mid":"bloodgasmethemoglobinmid","close":"bloodgasmethemoglobinclose","low":"bloodgasmethemoglobinlow","fillColors":"#ffffff","lineColors":"#d61b1b","label":"Methemoglobin","id":"b15","boxcolor":"#d61b1b","lineone":"0.2","linetwo":"0.2","linethree":"0.4"}]',
	        	'status' 		=>	true
	        ),
        	23 => 
            array (
	        	'slug_code'		=>	'BLOOD_GAS_LINE_CHART_PROPERTY',
	        	'code_values' 	=> 	'[{"column":"blood_gas_ph","drop":true,"adjustBorderColor":true,"BorderColor":"#0a0000","fillColor":"#ed5615","propertyName":"pH","valueField":"bloodgasph","bulletType":"round"},{"column":"blood_gas_pao2","drop":true,"adjustBorderColor":true,"BorderColor":"#0a0000","fillColor":"#bf18a3","propertyName":"Pao2","valueField":"bloodgaspao2","bulletType":"square"},{"column":"blood_gas_paco2","drop":true,"adjustBorderColor":true,"BorderColor":"#0a0000","fillColor":"#4211c6","propertyName":"PaCo2","valueField":"bloodgaspaco2","bulletType":"triangleUp"},{"column":"blood_gas_hco3","drop":true,"adjustBorderColor":true,"BorderColor":"#0a0000","fillColor":"#32d1b3","propertyName":"HCO3","valueField":"bloodgashco3","bulletType":"triangleDown"},{"column":"blood_gas_be","drop":true,"adjustBorderColor":true,"BorderColor":"#0a0000","fillColor":"#5b001e","propertyName":"BE","valueField":"bloodgasbe","bulletType":"bubble"},{"column":"blood_gas_na","drop":true,"adjustBorderColor":true,"BorderColor":"#0a0000","fillColor":"#4db213","propertyName":"Na (sodium) (mmol\/L)","valueField":"bloodgasna","bulletType":"bubble"},{"column":"blood_gas_k","drop":true,"adjustBorderColor":true,"BorderColor":"#0a0000","fillColor":"#b2a31a","propertyName":"K (potassium) (mmol\/L)","valueField":"bloodgask","bulletType":"bubble"},{"column":"blood_gas_cl","drop":true,"adjustBorderColor":true,"BorderColor":"#0a0000","fillColor":"#dbc418","propertyName":"cl (Chloride) (mmol\/L)","valueField":"bloodgascl","bulletType":"bubble"},{"column":"blood_gas_hb","drop":true,"adjustBorderColor":true,"BorderColor":"#0a0000","fillColor":"#5b001e","propertyName":"HB (g\/dL)","valueField":"bloodgashb","bulletType":"bubble"},{"column":"blood_gas_pcv","drop":true,"adjustBorderColor":true,"BorderColor":"#0a0000","fillColor":"#e52253","propertyName":"PCV (%)","valueField":"bloodgaspcv","bulletType":"bubble"},{"column":"blood_gas_lactate","drop":true,"adjustBorderColor":true,"BorderColor":"#0a0000","fillColor":"#20c2db","propertyName":"Lactate","valueField":"bloodgaslactate","bulletType":"bubble"},{"column":"blood_gas_bilirubin","drop":true,"adjustBorderColor":true,"BorderColor":"#0a0000","fillColor":"#e08f16","propertyName":"Bilirubin","valueField":"bloodgasbilirubin","bulletType":"bubble"},{"column":"blood_sugar","drop":true,"adjustBorderColor":true,"BorderColor":"#0a0000","fillColor":"#c4c4c4","propertyName":"Blood Sugar (mg\/dl)","valueField":"bloodsugar","bulletType":"bubble"},{"column":"blood_gas_methemoglobin","drop":true,"adjustBorderColor":true,"BorderColor":"#0a0000","fillColor":"#d61b1b","propertyName":"Methemoglobin","valueField":"bloodgasmethemoglobin","bulletType":"bubble"}]',
	        	'status' 		=>	true
	        ),
        	24 => 
            array (
	        	'slug_code'		=>	'VENTILATOR_LABELS',
	        	'code_values' 	=> 	'{"targeted_tidal_volume":"Targeted Tidal Volume","delivered_tidal_volume":"Delivered Tidal Volume ","pip_set":"PIP (set)","pip_delivered":"PIP (delivered)","p_amplitude":"\u0394P\/Amplitude","peep":"PEEP","map":"MAP","fio2":"FiO2 %","flow":"FLOW","it_rate":"IT(%)","it_rate_secound":"IT(S)","rate":"RATE\/V (Set Ventilator Rate)","frequency":"Frequency (H2)","respiratory_rate":"Baby\'s RR"}',
	        	'status' 		=>	true
	        ),
        	25 => 
            array (
	        	'slug_code'		=>	'VITALS_BOX_WHISKER_PROPERTY',
	        	'code_values' 	=> 	'[{"coreName": "core_temp", "high": "coretemphigh", "open": "coretempopen", "mid": "coretempmid", "close": "coretempclose", "low": "coretemplow", "fillColors": "#ffffff", "lineColors": "#e50d0d", "label": "T1", "id": "g1", "boxcolor": "#e50d0d", "lineone": "0.2", "linetwo": "0.2", "linethree": "0.4"}, {"coreName": "peripheral_temp", "high": "peripheraltemphigh", "open": "peripheraltempopen", "mid": "peripheraltempmid", "close": "peripheraltempclose", "low": "peripheraltemplow", "fillColors": "#ffffff", "lineColors": "#d509f4", "label": "T2", "id": "g2", "boxcolor": "#d509f4", "lineone": "0.2", "linetwo": "0.2", "linethree": "0.4"},{"coreName": "t1_t2", "high": "t1t2high", "open": "t1t2open", "mid": "t1t2mid", "close": "t1t2close", "low": "t1t2low", "fillColors": "#ffffff", "lineColors": "#2d2d2d", "label": "T1-T2", "id": "g3", "boxcolor": "#2d2d2d", "lineone": "0.2", "linetwo": "0.2", "linethree": "0.4"}, { "coreName": "hr_rate", "high": "hrratehigh", "open": "hrrateopen", "mid": "hrratemid", "close": "hrrateclose", "low": "hrratelow", "fillColors": "#ffffff", "lineColors": "#236d1b", "label": "HR", "id": "g5", "boxcolor": "#236d1b", "lineone": "0.2", "linetwo": "0.2", "linethree": "0.4"}, {"coreName": "respiratory_rate", "high": "respiratoryratehigh", "open": "respiratoryrateopen", "mid": "respiratoryratemid", "close": "respiratoryrateclose", "low": "respiratoryratelow", "fillColors": "#ffffff", "lineColors": "#0a0000", "label": "RR", "id": "g6", "boxcolor": "#0a0000", "lineone": "0.2", "linetwo": "0.2", "linethere": " 0.4"}, { "coreName": "cuff_systalic_bp", "high": "cuffsystalicbphigh", "open": "cuffsystalicbpopen", "mid": "cuffsystalicbpmid", "close": "cuffsystalicbpclose", "low": "cuffsystalicbplow", "fillColors": "#ffffff", "lineColors": "#dadd11", "label": "Cuff Systolic BP", "id": "g7", "boxcolor": "#dadd11", "lineone": "0.2", "linetwo": "0.2", "linethere": " 0.4"}, {"coreName": "cuff_diastolic_bp", "high": "cuffdiastolicbphigh", "open": "cuffdiastolicbpopen", "mid": "cuffdiastolicbpmid", "close": "cuffdiastolicbpclose", "low": "cuffdiastolicbplow", "fillColors": "#ffffff", "lineColors": "#1edbcb", "label": "Cuff Diastolic BP", "id": "g8", "boxcolor": "#1edbcb", "lineone": "0.2", "linetwo": "0.2", "linethere": " 0.4"}, {"coreName": "cuff_mean_bp", "high": "cuffmeanbphigh", "open": "cuffmeanbpopen", "mid": "cuffmeanbpmid", "close": "cuffmeanbpclose", "low": "cuffmeanbplow", "fillColors": "#ffffff", "lineColors": "#8e0517", "label": "Cuff Mean BP", "id": "g9", "boxcolor": "#8e0517", "lineone": "0.2", "linetwo": "0.2", "linethere": " 0.4"}, {"coreName": "arterial_systalic_bp", "high": "arterialsystalicbphigh", "open": "arterialsystalicbpopen", "mid": "arterialsystalicbpmid", "close": "arterialsystalicbpclose", "low": "arterialsystalicbplow", "fillColors": "#ffffff", "lineColors": "#1c99d8", "label": "Arterial Systolic BP", "id": "g10", "boxcolor": "#1c99d8", "lineone": "0.2", "linetwo": "0.2", "linethere": " 0.4"}, {"coreName": "arterial_diastolic_bp", "high": "arterialdiastolicbphigh", "open": "arterialdiastolicbpopen", "mid": "arterialdiastolicbpmid", "close": "arterialdiastolicbpclose", "low": "arterialdiastolicbplow", "fillColors": "#ffffff", "lineColors": "#4420ad", "label": "Arterial Diastolic BP", "id": "g11", "boxcolor": "#4420ad", "lineone": "0.2", "linetwo": "0.2", "linethere": " 0.4"}, {"coreName": "arterial_mean_bp", "high": "arterialmeanbphigh", "open": "arterialmeanbpopen", "mid": "arterialmeanbpmid", "close": "arterialmeanbpclose", "low": "arterialmeanbplow", "fillColors": "#ffffff", "lineColors": "#c46b1d", "label": "Arterial Mean BP", "id": "g12", "boxcolor": "#c46b1d", "lineone": "0.2", "linetwo": "0.2", "linethere": " 0.4"}, {"coreName": "preductal_sao2", "high": "preductalsao2high", "open": "preductalsao2open", "mid": "preductalsao2mid", "close": "preductalsao2close", "low": "preductalsao2low", "fillColors": "#ffffff", "lineColors": "#c46b1d", "label": "Sao2", "id": "g12", "boxcolor": "#c46b1d", "lineone": "0.2", "linetwo": "0.2", "linethere": " 0.4"}]',
	        	'status' 		=>	true
	        ),
        	26 => 
            array (
	        	'slug_code'		=>	'VITALS_CANDLE_CHART_PROPERTY',
	        	'code_values' 	=> 	'[{"coreName":"core_temp","id":"g1","open":"coretempopen","high":"coretemphigh","low":"coretemplow","close":"coretempclose","fillColor":"#e50d0d","lineColor":"#e50d0d","title":"T1"},{"coreName":"peripheral_temp","id":"g2","open":"peripheraltempopen","high":"peripheraltemphigh","low":"peripheraltemplow","close":"coretempclose","fillColor":"#d509f4","lineColor":"#d509f4","title":"T2"},{"coreName":"rectal_temp","id":"g3","open":"rectaltempopen","high":"rectaltemphigh","low":"rectaltemplow","close":"rectaltempclose","fillColor":"#0c32f4","lineColor":"#0c32f4","title":"RT"},{"coreName":"hr_rate","id":"g4","open":"hrrateopen","high":"hrratehigh","low":"hrratelow","close":"hrrateclose","fillColor":"#236d1b","lineColor":"#236d1b","title":"HR"},{"coreName":"respiratory_rate","id":"g5","open":"respiratoryrateopen","high":"respiratoryratehigh","low":"respiratoryratelow","close":"respiratoryrateclose","fillColor":"#0a0000","lineColor":"#0a0000","title":"RR"}]',
	        	'status' 		=>	true
	        ),
        	27 => 
            array (
	        	'slug_code'		=>	'VITALS_LINE_CHART_PROPERTY',
	        	'code_values' 	=> 	'[{"drop": true, "column": "core_temp", "fillColor": "#e50d0d", "bulletType": "round", "valueField": "coretemp", "BorderColor": "#0a0000", "propertyName": "T1", "adjustBorderColor": true}, {"drop": true, "column": "peripheral_temp", "fillColor": "#d509f4", "bulletType": "square", "valueField": "peripheraltemp", "BorderColor": "#0a0000", "propertyName": "T2", "adjustBorderColor": true}, {"drop": true, "column": "rectal_temp", "fillColor": "#0c32f4", "bulletType": "triangleUp", "valueField": "rectaltemp", "BorderColor": "#0a0000", "propertyName": "RT", "adjustBorderColor": true}, {"drop": true, "column": "hr_rate", "fillColor": "#236d1b", "bulletType": "triangleDown", "valueField": "hrrate", "BorderColor": "#0a0000", "propertyName": "HR", "adjustBorderColor": true}, {"drop": true, "column": "respiratory_rate", "fillColor": "#0a0000", "bulletType": "round", "valueField": "respiratoryrate", "BorderColor": "#0a0000", "propertyName": "RR", "adjustBorderColor": true},{"drop": true, "column": "cuff_systalic_bp", "fillColor": "#dadd11", "bulletType": "square", "valueField": "cuffsystalicbp", "BorderColor": "#0a0000", "propertyName": "Cuff Systolic BP", "adjustBorderColor": true}, {"drop": true, "column": "cuff_diastolic_bp", "fillColor": "#1edbcb", "bulletType": "triangleUp", "valueField": "cuffdiastolicbp", "BorderColor": "#0a0000", "propertyName": "Cuff Diastolic BP", "adjustBorderColor": true}, {"drop": true, "column": "cuff_mean_bp", "fillColor": "#7c2d9e", "bulletType": "triangleDown", "valueField": "cuffmeanbp", "BorderColor": "#0a0000", "propertyName": "Cuff Mean BP", "adjustBorderColor": true}, {"drop": true, "column": "arterial_systalic_bp", "fillColor": "#1c99d8", "bulletType": "round", "valueField": "arterialsystalicbp", "BorderColor": "#0a0000", "propertyName": "Arterial Systolic BP", "adjustBorderColor": true},{"drop": true, "column": "arterial_diastolic_bp", "fillColor": "#4420ad", "bulletType": "triangleUp", "valueField": "arterialdiastolicbp", "BorderColor": "#0a0000", "propertyName": "Arterial Diastolic BP", "adjustBorderColor": true}, {"drop": true, "column": "arterial_mean_bp", "fillColor": "#c46b1d", "bulletType": "bubble", "valueField": "arterialmeanbp", "BorderColor": "#0a0000", "propertyName": "Arterial Mean BP", "adjustBorderColor": true}, {"drop": true, "column": "preductal_sao2", "fillColor": "#c46b1d", "bulletType": "bubble", "valueField": "preductalsao2", "BorderColor": "#0a0000", "propertyName": "Sao2", "adjustBorderColor": true}]',
	        	'status' 		=>	true
	        ),
        	28 => 
            array (
	        	'slug_code'		=>	'INFUSION_GROUP',
	        	'code_values' 	=> 	'["infusion_day","infusion_brandname","infusion_pharmacological","infusion_dose","infusion_dose_units","infusion_quantity","infusion_quantity_units","infusion_syringe","infusion_rate","infusion_instruction","infusion_date_prescribed","infusion_time_prescribed","infusion_date_stopped","infusion_time_stopped"]',
	        	'status' 		=>	true
	        ),
        	29 => 
            array (
	        	'slug_code'		=>	'SPEICAL_IV_GROUP',
	        	'code_values' 	=> 	'["speical_iv_day","speical_iv_fluid_name_one","speical_iv_fluid_name_two","speical_fluid_vol_one","speical_fluid_vol_two","speical_iv_syringe","speical_iv_dextrose","speical_iv_glucose","speical_iv_infusion_rate","speical_iv_instruction","speical_iv_date_prescribed","speical_iv_time_prescribed","speical_iv_date_stopped","speical_iv_time_stopped"]',
	        	'status' 		=>	true
	        ),
        	30 => 
            array (
	        	'slug_code'		=>	'OTHER_INFUTION_GROUP',
	        	'code_values' 	=> 	'["other_infusions_day","other_infusions_pharmacological","other_infusions_volume","other_infusions_duration","other_infusions_durametnod","other_infusions_rate","other_infusions_instruction","other_infusions_date_prescribed","other_infusions_time_prescribed","other_infusions_date_stopped","other_infusions_time_stopped"]',
	        	'status' 		=>	true
	        ),
        	31 => 
            array (
	        	'slug_code'		=>	'OTHER_IV_DRUGS_GROUP',
	        	'code_values' 	=> 	'["other_iv_drugs_day","other_iv_drugs_brandname","other_iv_drugs_pharmacological","other_iv_drugs_dose_required","other_iv_drugs_frequency","other_iv_drugs_volume_dose","other_iv_drugs_additional","other_iv_drugs_date_prescribed","other_iv_drugs_time_prescribed","other_iv_drugs_date_stopped","other_iv_drugs_time_stopped"]',
	        	'status' 		=>	true
	        ),
        	32 => 
            array (
	        	'slug_code'		=>	'ORALDRUG_GROUP',
	        	'code_values' 	=> 	'["oral_days","oral_brandname","oral_pharmacological","oral_dose_required","oral_frequency","oral_route","oral_additional","oral_date_prescribed","oral_time_prescribed","oral_date_stopped","oral_time_stopped"]',
	        	'status' 		=>	true
	        ),
        	33 => 
            array (
	        	'slug_code'		=>	'REPLACMENT_FLUIDS',
	        	'code_values' 	=> 	'["replacement_fluids_solution","replacement_fluids_rate","replacement_fluids_total"]',
	        	'status' 		=>	true
	        ),
        	34 => 
            array (
	        	'slug_code'		=>	'DRUG_FLUIDS',
	        	'code_values' 	=> 	'["drug_solution","drug_rate","drug_total"]',
	        	'status' 		=>	true
	        ),
        	35 => 
            array (
	        	'slug_code'		=>	'BABY_OBSERVATIONS',
	        	'code_values' 	=> 	'["type_of_care","warmer","incubator","core_temp","peripheral_temp","rectal_temp","hr_rate","respiratory_rate","bp_method","cuff_systalic_bp","cuff_diastolic_bp","cuff_mean_bp","arterial_systalic_bp","arterial_diastolic_bp","arterial_mean_bp","preductal_sao2","postductal_sao2","color","activity"]',
	        	'status' 		=>	true
	        ),
        	36 => 
            array (
	        	'slug_code'		=>	'RESPIRATORY_SUPPORT',
	        	'code_values' 	=> 	'["work_of_breathing","mode_of_ventilation","hhhfnc","targeted_tidal_volume","p_amplitude","pip_set","pip_delivered","peep","map","fio2","flow","delivered_tidal_volume","rate","frequency","it_rate","it_rate_secound","ie_r","cpap_interface_change","physiotherapy","humidifier_temp","air_entry_right","air_entry_left","volume_targeting","physiotherapy","suction"]',
	        	'status' 		=>	true
	        ),
        	37 => 
            array (
	        	'slug_code'		=>	'TOGGLE_VALUSE',
	        	'code_values' 	=> 	'["volume_targeting","hhhfnc","physiotherapy","suction","human_milk_fortification","kmc","nns","bowels"]',
	        	'status' 		=>	true
	        ),
        	38 => 
            array (
	        	'slug_code'		=>	'CLEAR_VIEWS',
	        	'code_values' 	=> 	'/framework/views/*',
	        	'status' 		=>	true
	        ),
        	39 => 
            array (
	        	'slug_code'		=>	'CLEAR_CACHE',
	        	'code_values' 	=> 	'/framework/cache/*',
	        	'status' 		=>	true
	        ),
        	40 => 
            array (
	        	'slug_code'		=>	'OP_MODULE',
	        	'code_values' 	=> 	'OP MODULE',
	        	'status' 		=>	true
	        ),
        	41 => 
            array (
	        	'slug_code'		=>	'baby_background',
	        	'code_values' 	=> 	'Background Details',
	        	'status' 		=>	true
	        ),
        	42 => 
            array (
	        	'slug_code'		=>	'Development',
	        	'code_values' 	=> 	'Development',
	        	'status' 		=>	true
	        ),
        	43 => 
            array (
	        	'slug_code'		=>	'ConfidentialBackgroundDetails',
	        	'code_values' 	=> 	'ConfidentialBackgroundDetails',
	        	'status' 		=>	true
	        ),
        	44 => 
            array (
	        	'slug_code'		=>	'Examination',
	        	'code_values' 	=> 	'Examination',
	        	'status' 		=>	true
	        ),
        	45 => 
            array (
	        	'slug_code'		=>	'Complaints',
	        	'code_values' 	=> 	'Complaints',
	        	'status' 		=>	true
	        ),
        	46 => 
            array (
	        	'slug_code'		=>	'HPI',
	        	'code_values' 	=> 	'HPI',
	        	'status' 		=>	true
	        ),
        	47 => 
            array (
	        	'slug_code'		=>	'Diagnosis',
	        	'code_values' 	=> 	'Diagnosis',
	        	'status' 		=>	true
	        ),
        	48 => 
            array (
	        	'slug_code'		=>	'Advice',
	        	'code_values' 	=> 	'Advice',
	        	'status' 		=>	true
	        ),
        	49 => 
            array (
	        	'slug_code'		=>	'investigations',
	        	'code_values' 	=> 	'investigations',
	        	'status' 		=>	true
	        ),
        	50 => 
            array (
	        	'slug_code'		=>	'AUDIO_FILE_PATH',
	        	'code_values' 	=> 	'/var/www/html/neo_up_prescription/public/audio/',
	        	'status' 		=>	true
	        ),
        	51 => 
            array (
	        	'slug_code'		=>	'AUDIO_ZIPPED_PATH',
	        	'code_values' 	=> 	'/var/www/html/neo_up_prescription/public/audio/zip_files/',
	        	'status' 		=>	true
	        ),
        	52 => 
            array (
	        	'slug_code'		=>	'VITAL_LABEL_GROUP',
	        	'code_values' 	=> 	'[{"param":"core_temp","name":"T1"},{"param":"peripheral_temp","name":"T2"},{"param":"t1_t2","name":"T1-T2"},{"param":"hr_rate","name":"HR"},{"param":"respiratory_rate","name":"Baby\'s RR"},{"param":"cuff_systalic_bp","name":"Cuff Systalic BP"},{"param":"cuff_diastolic_bp","name":"Diastolic BP"},{"param":"cuff_mean_bp","name":"Mean BP"},{"param":"arterial_systalic_bp","name":"Art Systalic BP"},{"param":"arterial_diastolic_bp","name":"Diastolic BP"},{"param":"arterial_mean_bp","name":" Mean BP"}]',
	        	'status' 		=>	true
	        ),
        ));
    }
}
