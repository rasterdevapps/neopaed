<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

/**
 * methods to retrive data from published problem settings 
 *
 * @author Manikandan M  
 */
class DaycareProblemsPublished extends Model
{

  /**
   * @var $table string
   */
  protected $table = 'pd_published';

  /**
   * @var $primaryKey string
   */
	protected $primaryKey = 'published_id';

  /**
   * @var $timestamps boolean
   */
	public    $timestamps  =  false;

  /**
   * @var $fillable array 
   */
	protected $fillable = ['problem_id','problem_name','problem_description','problem_fields','problem_status','problem_layout','IsDeleted','UserAdded','DateAdded','UserDeleted','UserModified','DateModified','published_id'];

  /**
   * create list view .
   *
   * @return array of problem_name and problem_id with order by date of modified
   */  
  public function GetProblemList() 
  {
   	  $results =  \DB::table('pd_published')
	   	         ->where('pd_published.IsDeleted', '0')
	   	         ->orderby('DateModified', 'desc')
	   	         ->groupby('problem_name', 'DateModified', 'problem_id')
	   	         ->pluck('problem_name', 'problem_id')
	   	         ->toArray();
      return $results;

  }

   /**
   * create list view .
   *
   * @param $problem_id int 
   *
   * @return array of problem_name and problem_id with order by date of modified
   */
  public function GetRecord($problem_id) 
  {

    	return \DB::table('pd_published')
    	        ->where('problem_id', $problem_id)
              ->orderby('DateModified', 'desc')
    	        ->first();

  }

   
}
