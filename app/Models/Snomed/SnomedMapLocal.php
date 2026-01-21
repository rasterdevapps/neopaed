<?php

namespace App\Models\Snomed;

use Illuminate\Database\Eloquent\Model;

class SnomedMapLocal extends Model
{

    protected $table      = 'snomed_map_local_column';
    protected $primaryKey = 'id';
    public $timestamps    =  false;
    protected $fillable   = ['table_name','schema','column_name','snomed_code','lonic_code'];

    /**
     * Method to get list of snomed local code
     *
     * @param $page type integer
     *
     * @param $limit type integer
     *
     * @param $search_txt type string
     *
     * @param $order type array
     *
     * @return snomed local code list
     */
    public static function  GetList($page = 1, $limit = 50, $search_txt, $order = array())
    {

        $limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend = $limit;
        $search_txt = isset($search_txt) ? $search_txt : '';
        $checkdate = '';     

        $results = \DB::table('snomed_map_local_column')
		            ->where(function ($query) use ($search_txt, $checkdate)
		            {
		                if (!empty($search_txt) && empty($checkdate)) {

		                    $query->orwhere('table_name', 'like', '%'.trim($search_txt).'%');
		                    $query->orwhere('schema', $search_txt);
		                    $query->orWhere('column_name', 'like', '%'.trim($search_txt).'%');
		                    $query->orWhere('snomed_code', 'like', '%'.trim($search_txt).'%');
		                }

		            });

        if (isset($order['sortby']) && isset($order['sortorder'])) {
		    $results->orderBy($order['sortby'], $order['sortorder']);
        }

        $result['total']  = $results->get()->count();  
        $result['result'] = $results->limit($limitend)->offset($limitstart)->get();

        return $result;
    }

    public static function GetTotal()
    {
        return \DB::table('snomed_map_local_column')->get()->count();
    }
}
