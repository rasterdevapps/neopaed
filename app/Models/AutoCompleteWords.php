<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AutoCompleteWords extends Model
{
    

  protected $table = 'auto_complete_suggestion_word';
	protected $primaryKey = 'id';
	public $timestamps  =  false;
    
	protected $fillable = ['statement','type','flag','UserAdded','DateAdded','UserModified','DateModified','UserDeleted','IsDeleted'];
 
    //OP Current status flag is 1
    //OP Development flag is 2
    //OP Examination flag is 3
    //OP diagnosis flag is 4
    //OP Advice flag is 5

  public static function getList() 
  {

    $results = DB::table('auto_complete_suggestion_word')
                ->where('IsDeleted', 0)
                ->select('*')
                ->get();    
      return $results;

   }

}


