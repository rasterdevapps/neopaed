<?php

namespace App\Models\Search;

use Illuminate\Database\Eloquent\Model;

class SearchQueryLog extends Model
{

	protected $table      = 'search_log';
	protected $primaryKey = 'id';
	public $timestamps    =  false;
	protected $gaurded    = ['id'];
	protected $fillable   = ['query','bindings','time','search_module'];
	
    
}
