<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feeding extends Model
{
    protected $table = 'feeding';
    protected $primaryKey = 'id';
    public $timestamps  =  false;
    
    protected $fillable = ['baby_id', 'mother_id', 'reg_type', 'visit_date', 'visit_time', 'visit_min', 'visit_session', 'visit_from', 'background_details', 'is_parent_concerns', 'parent_concerns', 'is_current_feeding', 'current_feeding', 'is_oral_motor_assessment', 'oral_motor_assessment', 'is_cranial_nerve_assesment', 'cranial_nerve_assesment', 'is_feeding_assesment', 'feeding_assesment', 'is_mothers_examination', 'mothers_examination', 'is_interpretation', 'interpretation', 'recommendation', 'created_by', 'created_at', 'modified_by', 'modified_at', 'is_deleted', 'deleted_by', 'deleted_at', 'chronological_days', 'chronological_month', 'chronological_weeks', 'chronological_year', 'corrected_days', 'corrected_month', 'corrected_weeks', 'corrected_year', 'discharge_weight', 'current_weight', 'seen_by', 'appointment_type', 'review', 'review_days', 'review_time', 'review_min', 'review_session', 'fee_status', 'no_fee_reason', 'fee_amount'];

    public static function get_lists($page = 1, $limit = 50, $condition = array(), $order = array(), $slug = '')
    {
        $limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend   = $limit;
        $search_txt = isset($condition['search_txt']) ? $condition['search_txt'] : '';
        $results = \DB::table('feeding')
        ->Select('DOB', 'BMrNo', 'BabyName', 'id', 'baby.BabyId', 'visit_date', 
            'MMrNo', 'MotherName', 'mother.MotherId')
        ->leftjoin('baby', 'baby.BabyId', 'feeding.baby_id')
        ->leftjoin('mother', 'mother.MotherId', 'feeding.mother_id')
        ->where(function ($query) use ($search_txt) {
            if ($search_txt) {

                if (empty(preg_replace('/[0-9]/', '', trim($search_txt)))) {
                    $query->orWhere('mother.MMrNo', '=', $search_txt);
                    $query->orWhere('baby.BMrNo', '=', $search_txt);

                } elseif (empty(preg_replace('/[0-9,-]/', '', trim($search_txt)))) {  
                    $query->whereDate('baby.DOB', '=', date('Y-m-d', strtotime($search_txt)));

                } else {
                    $query->orWhere('baby.BabyName', 'ilike', '%'.$search_txt.'%');
                    $query->orWhere('mother.MotherName', 'ilike', '%'.$search_txt.'%');
                }
            }
        })
        ->where('is_deleted', 0)
        ->whereNotNull('id')
        ->where(function($query){
            $query->orWhereNotNull('mother.MotherId')
            ->orWhereNotNull('baby.BabyId');
        })
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
    *To get op list count 
    *
    *@param $baby_id integer
    *@return op list count in integer
    */
    public static function GetTotal() 
    {

        return  self::join('baby', 'feeding.baby_id', '=', 'baby.BabyId')
        ->where('feeding.is_deleted', 0)
        ->get()->unique('BabyId')->count();

    }

    /**
    *To Get previous feeding list 
    *
    *@param baby_id integer
    *@return previous  op in array of object 
    */

    public static function GetPreviousFeedingRecord($baby_id) 
    {
        return \DB::table('feeding')
        ->where(['is_deleted'=>0, 'baby_id'=>$baby_id])
        ->orderBy('visit_date', 'desc')
        ->first();

    }

    /**
    *To Get all previous feeding list 
    *
    *@param baby_id integer
    *@return previous  op in array of object 
    */

    public static function GetAllPreviousFeedingRecord($baby_id) 
    {
        return \DB::table('feeding')
        ->where(['is_deleted'=>0, 'baby_id'=>$baby_id])
        ->orderBy('visit_date', 'desc')
        ->get();

    }

}
