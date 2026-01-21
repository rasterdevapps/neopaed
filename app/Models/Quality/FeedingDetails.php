<?php

namespace App\Models\Quality;

use Illuminate\Database\Eloquent\Model;

class FeedingDetails extends Model
{
    protected $table       = 'feeding';
	protected $primaryKey  = 'id';
	public    $timestamps  =  false;
	protected $fillable    = ['feeding_start_hours', 'feeding_start_dof', 'feeding_amount_start', 'full_feed_time', 
	                          'regain_birth_weight', 'probiotics', 'probiotics_val', 'probiotics_usage', 'total_pn', 
	                          'total_pn_duration', 'hyperbilirubinemia', 'phototherapy_hours', 'dvet', 'max_bilirubin', 
	                          'seizures', 'seizures_details','anticonvulsants','anticonvulsants_details' ,'seizures_duration', 'patent_ductus_arteriosus', 'pda_medicine', 
	                          'surgical_ligation', 'centeralline', 'central_line_type', 'total_duration_of_line', 
	                          'hearing_screen_done', 'hearscreen_result', 'caffeine_use', 'caffeine_use_val', 'received_prbc', 
	                          'total_prbc_transfusions', 'receivedplatelet', 'brand_name','freshfrozenplasma',
	                          'probiotics_stopped','group_id', 'baby_id', 'expired_prior_event_full_feed', 'expired_prior_event_regain_weight'];
}
