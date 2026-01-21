<?php

namespace App\Models\Quality;

use Illuminate\Database\Eloquent\Model;

class OutcomeDetails extends Model
{
    protected $table       = 'outcomes';
	protected $primaryKey  = 'id';
	public    $timestamps  =  false;
	protected $fillable    = ['outcome_result', 'outcome_details', 'hospital_stay', 'eugr', 'congenital_heart_disease', 
	                          'rds', 'pneumothorax', 'pphn', 'intar_hommorrhage', 'max_grade_rt', 'max_grade_lt', 'nec', 
	                          'nec_max_stage', 'ppd', 'surgery', 'congenital_pneumonia', 'pulmonary_hemorrahge', 'rop', 
	                          'rt_eye_grade', 'lt_eye_grade', 'rop_treatment_required', 'pventricular_leukomalacia', 
	                          'cystic_pvl', 'bronchopulmonary_dysplasia', 'dysplasia_stage', 
	                          'dysplasia_details', 'acute_renal_failure', 'vap', 'vap_details', 'osteopenia_details', 
	                          'osteopenia_prematurity', 'case_death', 'others_case_death', 'group_id', 'baby_id'];
}
