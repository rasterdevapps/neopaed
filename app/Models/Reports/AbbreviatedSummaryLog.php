<?php

namespace App\Models\Reports;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AbbreviatedSummaryLog extends Model
{
   
   protected $table      = "abbreviated_summary_log";
   protected $primaryKey = "summary_id";
   public    $timestamps  = false;
   protected $fillable   =['filename','record_folder_name','baby_mr_no','DateAdded','DateModified','UserDeleted','UserModified','UserAdded','IsDeleted','baby_id','admission_id'];


   public static function getRecord($baby_id, $admission_id) 
   {

   	 return \DB::table('abbreviated_summary_log')
   	         ->where(['baby_id'=>$baby_id,'admission_id'=>$admission_id])
   	         ->orderBy('summary_id', 'desc')
   	         ->first(); 

   }

   public static function getPatientList($baby_id) 
   {

      return \DB::table('abbreviated_summary_log')
              ->where('baby_id', $baby_id)
              ->get();
   }



}
