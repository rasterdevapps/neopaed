<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Search\SearchQueryLog;

class Issa extends Model 
{
	protected $table = 'issa';
	protected $primaryKey = 'id';
	public $timestamps  =  false;
	
	protected $fillable = ['neuro_visit_id', 'srr', 'er', 'slc', 'bp', 'sa', 'cc', 'total', 'status', 'user_modified', 'date_modified', 'user_added', 'date_added', 'is_deleted', 'user_deleted', 'date_deleted', 'answer'];

}
