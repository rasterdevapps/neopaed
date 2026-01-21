<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MirthQuery extends Model
{
	protected $table = 'mirth_query_answer';
	protected $primaryKey = 'id';
	public $timestamps  =  false;

	protected $fillable = ['mr_no','query_values','answer_values','request_date'];
    
}
