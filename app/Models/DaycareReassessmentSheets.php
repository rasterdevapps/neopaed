<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DaycareReassessmentSheets extends Model
{
   	protected $table = 'daycare_reassessment';
	protected $primaryKey = 'id';
	public $timestamps  =  false;
	protected $gaurded = ['id'];
	protected $fillable = ['day_id','reassessment_date','reassessment_time','reassessment_ventilater','reassessment_nc','reassessment_cpap','reassesment_room_air','reassessment_systalic_bp','reassessment_diastolic_bp','reassessment_bp','reassessment_rr','reassessment_spo2','reassemant_rs','reassemant_cns','reassemant_cvs','reassemant_gi','reassessment_hr','baby_id','admission_id', 'additional_assessment', 'reassessment_seen_by'];

}
