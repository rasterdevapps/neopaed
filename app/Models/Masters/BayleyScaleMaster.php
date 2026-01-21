<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class BayleyScaleMaster extends Model
{
   /**
    * Define the table name
    *
    *@var $table
    */
    protected $table = 'mas_bayley_scale';

    /**
    * Define the table primary key 
    *
    *@var $primaryKey
    */
    protected $primaryKey = 'id';

    /**
    * Define the table timestamps
    *
    *@var $timestamps
    */
    public    $timestamps  =  false;

    /**
    * Define the table fillable columns 
    *
    *@var $fillable
    */
    protected $fillable = ['start_point', 'question_no', 'category', 'item', 'materials', 'user_added', 'user_modified', 'date_added', 'date_modified',
    'user_deleted', 'is_deleted'];

    public static function list($page = 1, $limit = 50, $condition, $order = array(), $slug = '')
    {

        $limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend   = $limit;
        $search_txt = isset($condition) ? trim($condition) : '';

        $results    = self::select('*')
        ->where('is_deleted', 0)
        ->where(function ($query) use ($search_txt) {
            if ($search_txt) {
                $query->orWhere('item', 'ilike', '%'.$search_txt.'%');
                $query->orWhere('materials', 'ilike', '%'.$search_txt.'%');
            }
        });

        if (isset($order['sortby']) && isset($order['sortorder'])) {
            $results->orderBy($order['sortby'], $order['sortorder']);  
        }

        if ($slug) {
            $result['total']  = $results->get()->count();  
            $result['result'] = $results->limit($limitend)->offset($limitstart)->get(); 
        } else {
            $result = $results->limit($limitend)->offset($limitstart)->get();           
        }

        return $result;
    }

    public static function GetTotal() 
    {
        $results = self::where('is_deleted', 0)
        ->get();    

        return count($results);     

    }

    public static function getData() 
    {
        $results = self::where('is_deleted', 0)
        ->select('mas_bayley_scale.id', 'mas_bayley_scale.category', 'mas_bayley_scale.start_point', 'mas_bayley_scale.question_no', 'mas_bayley_scale.item', 'mas_bayley_scale.materials', 'mas_bayley_scale_sub.id as sub_id', 'mas_bayley_scale_sub.title', 'mas_bayley_scale_sub.score', 'mas_bayley_scale_sub.type')
        ->leftJoin('mas_bayley_scale_sub', 'mas_bayley_scale.id', 'mas_bayley_scale_sub.bayley_id')
        ->orderBy('mas_bayley_scale.id', 'asc')
        ->orderBy('mas_bayley_scale_sub.id', 'asc')
        ->get();    

        return $results;     

    }
}
