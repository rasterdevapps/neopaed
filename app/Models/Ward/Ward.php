<?php

namespace App\Models\Ward;

use Illuminate\Database\Eloquent\Model;
use App\Models\Masters\Bed;

class Ward extends Model
{
   /**
    * This method to get 
    * all the room and bed
    *
    */
   public function getward_room($id)
   {
   	  $result =  \DB::table('ward')
   	             ->select('ward.name as ward_name', 'room.number as room_name', 'bed.number as bed_name')
   	             ->addSelect('ward.id as ward_id', 'room.id as room_id', 'bed.id as bed_id')
                   ->addSelect('bed.status as bed_status')
   	             ->addSelect('hms_ward_id', 'hms_room_id', 'hms_bed_id')
   	             ->join('room', 'room.ward_id', '=', 'ward.id')
                 ->join('bed', 'bed.room_id', '=', 'room.id')
   	             ->orderBy('ward.id', 'asc')
                 ->where('ward.active', true);
      if ($id != 0) {
             $result = $result->where('room_id', $id);
      }           
   	  $result = $result->get();
      return $result;
   }

   /**
    * This method to get all baby bed
    *
    */
   public function getbaby()
   {
   	  return \DB::table('patient_bed_log')
                 ->select('patient_bed_log.id', 'ward_id', 'ward_name', 'patient_bed_log.room_id', 'room_no', 'bed_no', 'patient_bed_log.baby_id', 'MMrNo','ip_number', 'AdmissionDate')
                 ->addSelect('bed_id', 'baby.BMrNo', 'baby.MotherId', 'BabyName', 'BirthOrder', 'BirthWeight')
                 ->addSelect('DOB', 'TOB', 'Gestation', 'Sex', 'BabyBloodGroup', 'TOB_TIME', 'TOB_MINS', 'TOB_AM')
                 ->addSelect('g_weeks', 'g_days', 'baby_admission.AdmissionId as admission_id')
                 ->addSelect('patient_bed_log.status')
                 ->addSelect('is_syringe_pump_connected', 'is_infusion_pump_connected', 'is_monitor_connected', 'is_ventilator_connected')
   	             ->join('baby','baby.BabyId', '=', 'patient_bed_log.baby_id')
                 ->join('mother','mother.MotherId', '=', 'baby.MotherId')
                 ->join('baby_admission','baby_admission.AdmissionId', '=','patient_bed_log.admission_id')
                 ->leftJoin('ip_numbers','baby_admission.AdmissionId', '=','ip_numbers.AdmissionId')
                //need to check bed management baby start
                 ->join('bed','bed.id', '=', 'patient_bed_log.bed_id')
                 //end 
                 ->where('patient_bed_log.status', 'Occupied')
                 ->where('baby_admission.Status', 'Inpatient')
                 ->orderBy('patient_bed_log.id', 'desc')
   	             ->get();

   }
   /**
    * This method to get baby based on baby_id and admission_id 
    *
    * @param $baby_id
    * @param $admission_id
    *
    * @return array of object 
    */
   public static function getbabyadmission($baby_id, $admission_id, $need_admission = '')
   {
      if ($need_admission == '') {
         
         $result = \DB::table('patient_bed_log')
                    ->select('bed.id', 'ward_id', 'ward_name', 'bed.room_id', 'room_no', 'bed_no', 'baby_id', 'pump_type')
                    ->addSelect('bed_id', 'baby.BMrNo', 'baby.MotherId', 'BabyName', 'BirthOrder', 'BirthWeight')
                    ->addSelect('DOB', 'TOB', 'Gestation', 'Sex', 'BabyBloodGroup', 'TOB_TIME', 'TOB_MINS', 'TOB_AM')
                    ->addSelect('g_weeks', 'g_days', 'baby_admission.AdmissionId as admission_id')
                    ->join('bed','patient_bed_log.bed_id', '=', 'bed.id')
                    ->join('baby','baby.BabyId', '=', 'patient_bed_log.baby_id')
                    ->join('baby_admission','baby_admission.BabyId', '=','patient_bed_log.baby_id')
                    ->where('baby.BabyId', $baby_id)
                    //->where('admission_id', $admission_id)
                    ->first();
      }
      else
      {
         $result = \DB::table('patient_bed_log')
                    ->select('bed.id', 'ward_id', 'ward_name', 'bed.room_id', 'room_no', 'bed_no', 'baby_id', 'pump_type')
                    ->addSelect('bed_id', 'baby.BMrNo', 'baby.MotherId', 'BabyName', 'BirthOrder', 'BirthWeight')
                    ->addSelect('DOB', 'TOB', 'Gestation', 'Sex', 'BabyBloodGroup', 'TOB_TIME', 'TOB_MINS', 'TOB_AM')
                    ->addSelect('g_weeks', 'g_days', 'baby_admission.AdmissionId as admission_id')
                    ->join('bed','patient_bed_log.bed_id', '=', 'bed.id')
                    ->join('baby','baby.BabyId', '=', 'patient_bed_log.baby_id')
                    ->join('baby_admission','baby_admission.BabyId', '=','patient_bed_log.baby_id')
                    ->where('baby.BabyId', $baby_id)
                    ->where('admission_id', $admission_id)
                    ->first();         
      }
    return $result;
   }
}
