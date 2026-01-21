<?php

namespace App\Models\Reports;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NsofaScore extends Model
{
   
   protected $table      = "n_sofa_score";
   protected $primaryKey = "id";
   public    $timestamps  = false;
   protected $fillable   =['respiratory_score', 'hematology_score', 'cardiovuscular_score', 'created_date_time', 'modified_date_time', 'log_hdr_id', 'total_nsofa_score'];


   public static function getRecord($log_hdr_id) 
   {

   	 return \DB::table('n_sofa_score')
   	         ->where('log_hdr_id', $log_hdr_id)
   	         ->first(); 
   }

   public static function getLastHematologyScoreForThatBaby($log_hdr_id) 
   {
      $previousScoreRecord = DB::table('n_sofa_score AS nsc')
          ->select('nsc.hematology_score AS previous_hematology_score', 'nsc.platelet_count AS previous_platelet_count')
          ->join('emr_log_hdr AS elh', 'elh.id', '=', 'nsc.log_hdr_id')
          ->where('elh.baby_id', function ($query) use ($log_hdr_id) {
              $query->select('baby_id')
                    ->from('emr_log_hdr')
                    ->where('id', $log_hdr_id)
                    ->limit(1);
          })
          ->where('elh.id', '<', $log_hdr_id)
          ->orderByDesc('elh.sender_time')
          ->limit(1)
          ->first();

      return $previousScoreRecord ?? null;
   }
}
