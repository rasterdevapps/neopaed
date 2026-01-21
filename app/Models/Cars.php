<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Search\SearchQueryLog;

class Cars extends Model 
{
	protected $table = 'cars';
	protected $primaryKey = 'id';
	public $timestamps  =  false;
	
	protected $fillable = ['neuro_visit_id', 'relating_to_people', 'imitation', 'emotional_response', 'body_use', 'object_use', 'adaptation_to_change', 'visual_response', 'listening_response', 'tst_response_use', 'fear_nervous', 'verbal', 'non_verbal', 'activity_level', 'intellectual_response', 'general_imperssions', 'total', 'status', 'user_modified', 'date_modified', 'user_added', 'date_added', 'is_deleted', 'user_deleted', 'date_deleted'];

}
