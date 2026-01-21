<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BayleyScaleScore extends Model
{
    protected $table = 'bayley_scale_score';
    protected $primaryKey = 'id';
    public $timestamps  =  false;
    
    protected $fillable = ['hdr_id', 'category_id', 'question_id', 'sub_question_id', 'value', 'user_added', 'user_deleted', 'date_added', 'date_modified', 'is_deleted', 'user_modified', 'is_manual'];


    public static function getData($id) 
    {
        return self::select('category_id', 'question_id', 'sub_question_id', 'value', 'type', 'bayley_scale_score.id', 'is_manual')
                ->leftJoin('bayley_scale', 'bayley_scale_score.hdr_id', 'bayley_scale.id')
                ->leftJoin('mas_bayley_scale_sub', 'sub_question_id', 'mas_bayley_scale_sub.id')
               ->where(['is_deleted' => 0,'neuro_visit_id' => $id])
               ->get();

    }

    public static function getPassData($id, $value) 
    {
        return self::select('question_id', 'item', 'category_id')
                ->leftJoin('mas_bayley_scale_sub', 'sub_question_id', 'mas_bayley_scale_sub.id')
                ->leftJoin('mas_bayley_scale', 'bayley_id', 'mas_bayley_scale.id')
               ->where(['hdr_id' => $id,'value' => $value])
               ->orderBy('mas_bayley_scale_sub.id', 'asc')
               ->get();

    }

}
