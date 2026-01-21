<?php

namespace App\Models\Quality;

use Illuminate\Database\Eloquent\Model;

class RespiratoryDetails extends Model
{
    protected $table = 'res_details';
	protected $primaryKey = 'id';
	public    $timestamps  =  false;
	protected $fillable = ['primary_res_support', 'res_support_type','hhhnfc_duration','hhhnfc_failure','cpap_duration','cpap_failure',	
							'nippv_duration','nippv_failure','nasal_hfov_pduration','nasal_hfov_pfailure',	
							'nasal_hfov_sduration', 'nasal_hfov_sfailure', 'mechanical_cduration',	
							'mechanical_cfailure', 'mechanical_pduration', 'mechanical_pfailure',	
							'mechanical_rcduration', 'mechanical_rcfailure', 'oxygen_prongs_duration', 
							'oxygen_prongs_failure', 'mvc_total', 'hfov_total', 'hfov_mc_total', 'non_invasive_total',
							'hhhnfc_settings_liter', 'hhhnfc_settings_fio2', 'cpap_settings_peep',	'cpap_settings_fio2',	
							'nippv_settings', 'nasal_hfov_pduration_map', 'nasal_hfov_pduration_fio2', 'nasal_hfov_pduration_amp',	
							'nasal_hfov_pduration_hz', 'nasal_hfov_ssettings_map','nasal_hfov_ssettings_amp',	
							'nasal_hfov_ssettings_fio2', 'nasal_hfov_ssettings_hz',	'mechanical_csettings_vol',	
							'nmechanical_csettings_fio2', 'mechanical_csettings_fio2', 'mechanical_pressureduration','mechanical_pressure_map', 'mechanical_psettings_map',	
							'mechanical_psettings_fio2', 'mechanical_psettings_amp', 'mechanical_psettings_hz',	
							'mechanical_rcsettings_map', 'mechanical_rcsettings_fio2', 'mechanical_rcsettings_amp',	
							'mechanical_rcsettings_hz', 'oxygen_prongs_settings_fio2',	'tetracycline','mechanical_pressurefailure',
							'group_id','baby_id'];
}
