<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * All the curd of problem base daycare goes here
 *
 * @author Manikandan M
 */
class ProblemDaycareEpisode extends Model
{

   /**
    *@var $table string
    */
   protected $table = 'pb_episodes_list';

   /**
    *@var $primaryKey string  
    */
   protected $primaryKey = 'episode_id';

   /**
    *@var $timestamps 
    */
    public $timestamps  =  false;

    /**
    *@var $fillable array
    */
    protected $fillable =['mother_id', 'baby_id', 'admission_id', 'problem_id', 'problems_parameters', 
                         'episode_name', 'pp_id', 'pb_day_id', 'start_date', 'end_date', 'IsDeleted', 
                         'UserDeleted', 'DateDeleted', 'UserModified', 'DateModified', 'UserAdded', 'DateAdded', 
                         'dtl_edit', 'problem_edit'];

}
