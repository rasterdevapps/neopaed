<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BayleyScale extends Model
{
    protected $table = 'bayley_scale';
    protected $primaryKey = 'id';
    public $timestamps  =  false;
    
    protected $fillable = ['baby_id', 'cg', 'rc', 'ec', 'fm', 'gm', 'cg_scaled_score', 'rc_scaled_score', 'ec_scaled_score', 'fm_scaled_score', 'gm_scaled_score', 'cg_age_equivalent', 'rc_age_equivalent', 'ec_age_equivalent', 'fm_age_equivalent', 'gm_age_equivalent', 'cg_growth_scale', 'rc_growth_scale', 'ec_growth_scale', 'fm_growth_scale', 'gm_growth_scale', 'lang_scaled_score', 'mot_scaled_score', 'confidence_interval', 'cog_standard_score', 'lang_standard_score', 'mot_standard_score', 'cog_percentile_rank', 'lang_percentile_rank', 'mot_percentile_rank', 'cog_confidence_interval_start', 'cog_confidence_interval_end', 'lang_confidence_interval_start', 'lang_confidence_interval_end', 'mot_confidence_interval_start', 'mot_confidence_interval_end', 'se_raw_score', 'se_scaled_score', 'rec_raw_score', 'rec_scaled_score', 'exp_raw_score', 'exp_scaled_score', 'per_raw_score', 'per_scaled_score', 'ipr_raw_score', 'ipr_scaled_score', 'pla_raw_score', 'pla_scaled_score', 'start_point', 'user_added', 'date_added', 'date_modified', 'user_modified', 'custom_detail', 'neuro_visit_id', 'rec_age_equivalent', 'exp_age_equivalent', 'per_age_equivalent', 'ipr_age_equivalent', 'pla_age_equivalent', 'rec_growth_scale', 'exp_growth_scale', 'per_growth_scale', 'ipr_growth_scale', 'pla_growth_scale', 'com_scaled_score', 'soc_scaled_score', 'adbe_scaled_score', 'soem_standard_score', 'com_standard_score', 'dls_standard_score', 'soc_standard_score', 'adbe_standard_score', 'soem_percentile_rank', 'com_percentile_rank', 'dls_percentile_rank', 'soc_percentile_rank', 'adbe_percentile_rank', 'soem_confidence_interval_start', 'com_confidence_interval_start', 'dls_confidence_interval_start', 'soc_confidence_interval_start', 'adbe_confidence_interval_start', 'soem_confidence_interval_end', 'com_confidence_interval_end', 'dls_confidence_interval_end', 'soc_confidence_interval_end', 'adbe_confidence_interval_end'];
    
    public static function get_lists($page = 1, $limit = 50, $condition = array(), $order = array(), $slug = '')
    {
        $limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend   = $limit;
        $search_txt = isset($condition['search_txt']) ? $condition['search_txt'] : '';
        $results = \DB::table('baby')
                    ->distinct('BabyId','BabyName', 'BMrNo', 'DOB')
                    ->select('BabyId','BabyName', 'BMrNo', 'DOB', 'id')
                    ->leftJoin('bayley_scale', 'baby.BabyId', 'bayley_scale.baby_id')
                    ->where(function ($query) use ($search_txt) {
                        if ($search_txt) {

                            if (empty(preg_replace('/[0-9]/', '', trim($search_txt)))) {
                                $query->where('baby.BMrNo', '=', $search_txt);

                            } elseif (empty(preg_replace('/[0-9,-]/', '', trim($search_txt)))) {  
                                $query->whereDate('baby.DOB', '=', date('Y-m-d', strtotime($search_txt)));

                            } else {
                                $query->where('baby.BabyName', 'ilike', '%'.$search_txt.'%');
                            }
                        }
                    })
                    ->where('is_deleted', 0)
                    ->whereNotNull('id')
                    ->where('IsDeleted', '0')
                    ->orderBy($order['sortby'], $order['sortorder']);
        if ($slug) {
            $result_set = $results->get()->toArray();
            $result['total'] = count($result_set);  
            $result['result'] = array_slice($result_set, $limitstart, $limitend);  
        } else {
            $result = $results->limit($limitend)->offset($limitstart)->get();
        }
        return $result;
    }

    /**
    * To get op list count 
    *
    * @param $baby_id integer
    * @return op list count in integer
    */
    public static function GetTotal() 
    {

        return  self::join('baby', 'bayley_scale.baby_id', '=', 'baby.BabyId')
        ->where('bayley_scale.is_deleted', 0)
        ->get()->unique('BabyId')->count();

    }

    /**
    * To get op visit list based on baby id 
    *
    *  @param $baby_id integer
    * @return op list in array of objects
    */
    public static function getVisit($id) 
    {
        return self::select('*')
               // ->leftjoin('baby', 'bayley_scale.baby_id', 'baby.BabyId')
               // ->leftjoin('mother', 'baby.MotherId', 'mother.MotherId')
               ->where(['bayley_scale.neuro_visit_id'=>$id])
               ->first();

    }

    /**
    *To get op visit list based on baby id 
    *
    *@param $baby_id integer
    *@return op list in array of objects
    */
    public static function getVisitList($baby_id) 
    {

        return self::select('baby.BabyName', 'baby.BMrNo', 'visit_date', 'id', 'visit_number')
               ->join('baby', 'bayley_scale.baby_id', 'baby.BabyId')
               ->where(['bayley_scale.is_deleted'=>0,'bayley_scale.baby_id'=>$baby_id])
               ->orderBy('bayley_scale.id', 'desc')
               ->get();


    }



}
