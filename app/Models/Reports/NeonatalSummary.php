<?php

namespace App\Models\Reports;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NeonatalSummary extends Model
{
   public function get_neonatal_baby_list()
   {

   	return DB::table('baby')
   	       ->select('baby.*')
   	       ->join('neonatal_proforma', 'neonatal_proforma.BabyId', '=', 'baby.BabyId')
   	       ->where('neonatal_proforma.Status', '<>', 'NICU Transfer')
   	       ->where('baby.IsDeleted', '0')
           ->where('neonatal_proforma.IsDeleted', '0')
   	       ->get();

   }

   public function get_neonatal_summary($BabyId)
   {

     return DB::table('baby')
            ->select('baby.*', 'neonatal_proforma.*', 'mother.MotherBloodGroup', 'baby.BMrNo')
            ->join('neonatal_proforma', 'neonatal_proforma.BabyId', '=', 'baby.BabyId') 
            ->join('mother', 'mother.MotherId', '=', 'baby.MotherId')
            ->where('neonatal_proforma.IsDeleted', '0')
            ->where(['baby.IsDeleted'=>'0', 'baby.BabyId'=>$BabyId])
            ->first();
             
   }
   public function get_medical_problems($BabyId)
   {
   	   return DB::table('medical_problems')
   	          ->join('mas_medical_problems', 'mas_medical_problems.Id', '=', 'medical_problems.Problem')
   	          ->where(['medical_problems.BabyId'=>$BabyId])
   	          ->groupby('mas_medical_problems.Name')
   	          ->pluck('mas_medical_problems.Name');


   }
   public function get_complications($BabyId)
   {

   	   return DB::table('complications')
   	          ->join('mas_complication', 'mas_complication.Id', '=', 'complications.Complication')
   	          ->where(['complications.BabyId'=>$BabyId])
   	          ->groupby('mas_complication.Name')
   	          ->pluck('mas_complication.Name');


   	
   }
   public function get_discharge_medicines($BabyId)
   {
      return DB::table('discharge_medications')
             ->join('mas_drugivfluid', 'mas_drugivfluid.id', '=', 'discharge_medications.Medication') 
             ->where('discharge_medications.flag', '=', 1)
             ->where('discharge_medications.BabyId', $BabyId)
             ->get();

   }
}
