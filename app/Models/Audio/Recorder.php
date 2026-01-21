<?php

namespace App\Models\Audio;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Recorder extends Model
{
	protected $table      = 'recorded_audio_history';
	protected $primaryKey = 'id';
	public $timestamps    =  false;
	protected $fillable   = ['baby_id', 'module_id', 'admission_id', 'audio_file', 'audio_file_name', 'field_id', 'UserAdded', 'DateAdded', 'converted_text', 'module_slug', 'files_zipped', 'file_opened', 'file_opened_by'];

    /**
     * Get Audio list for view
     *
     * @param $page type integer for page nation
     * 
     * @param $limit type integer for record limit 
     *
     * @param $condition type search text 
     *
     * @param $order refer list asc or desc 
     *
     * @return type array of objects
     */
    public static function getlist($page = 1, $limit = 50, $condition = array(), $order = array())
    {

        $limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend = $limit;
        $search_txt = isset($condition['search_txt']) ? $condition['search_txt'] : '';
        
         $checkdate     ='';
         if (strpos($search_txt, '-') > 0) {
            $get_date      = strtotime($search_txt);
            $checkdate     = (!empty($get_date)) ? date('\'Y-m-d\'', $get_date):'';
            $search_txt    = '';
          }
  
        $results =  DB::table('baby')
                 ->join('recorded_audio_history', 'recorded_audio_history.baby_id', '=', 'baby.BabyId')
                 ->whereNotNull('module_slug')
                 ->where(function ($query) use ($search_txt, $checkdate)
                    {
                        if (!empty($search_txt) && empty($checkdate)) {
                            $query->where('baby.BabyName', 'like', '%'.ucfirst(trim($search_txt)).'%');
                            $query->orwhere('baby.BMrNo', $search_txt);
                        }

                        if (!empty($checkdate) && empty($search_txt)) {

                            $query->whereRaw('"baby"."DOB"::date='.$checkdate);  
                        }
                });
                       
                if (isset($order['sortby']) && isset($order['sortorder'])) {
                    
                    $results->orderBy($order['sortby'], $order['sortorder']);
                        
                }

                
        $result = $results->limit($limitend)->offset($limitstart)
                                  ->get();  
        // return $result->unique('BabyId');                          
        return $result;                          


    }

    /**
     * Get The total records count 
     * 
     * @return list count
     */
    public static function GetTotal()
    {
        return DB::table('recorded_audio_history')
                  ->whereNotNull('module_slug')
                  ->count();
    }  

    /**
     * Get Audio List for unzip the files
     * 
     * @param $baby_id type integer
     * 
     * @return type array of object 
     */
    public static function getmodulelist($baby_id)
    {
    	return  DB::table('recorded_audio_history')
    	          ->where('baby_id', $baby_id)
    	          ->whereNotNull('module_slug')
    	          ->get();
    }

    /**
     * To check the file zipped 
     *
     * @param type $baby_id
     * 
     */
    public static function getcompressstatus($baby_id)
    {
        return  DB::table('recorded_audio_history')
                  ->where('baby_id', $baby_id)
                  ->whereNotNull('module_slug')
                  ->where('files_zipped', true)
                  ->get();

    }



}
