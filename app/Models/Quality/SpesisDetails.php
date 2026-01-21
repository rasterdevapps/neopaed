<?php

namespace App\Models\Quality;

use Illuminate\Database\Eloquent\Model;

class SpesisDetails extends Model
{
    protected $table = 'spesis_details';
	protected $primaryKey = 'id';
	public    $timestamps  =  false;
	protected $fillable = ['sclerema', 'meningitis', 'developedshock', 'spesis_type', 'postnatalsteriodused', 
	                       'steriod_type', 'max_cumulative_dose', 'gram_positive_culture1', 'gram_negative_culture1',
	                       'fungus_culture1','gram_positive_culture2', 'gram_negative_culture2',
	                       'fungus_culture2','gram_positive_culture3', 'gram_negative_culture3',
	                       'fungus_culture3', 'ext_spectrum', 'carbapenems', 'aminoglycosides', 'fluoroquinolones',
	                       'piperacillin_tazobactam', 'first_antibotics', 'second_antibotics', 'third_antibotics', 
	                       'total_antibiotics_days', 'eonsclinicalsepsis','eonssuspectsepsis', 
	                       'eonsculturepositive_sepsis','lonsclinical_sepsis',  'lonssuspect_sepsis',
	                       'lonsculture_sepsis','cumulative_antibiotic', 'anti_prophylaxis',
	                       'baby_id', 'group_id', 'sepsis'];
}
