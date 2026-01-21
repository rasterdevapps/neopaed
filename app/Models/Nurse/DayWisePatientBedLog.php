<?php

namespace App\Models\Nurse;

use Illuminate\Database\Eloquent\Model;

class DayWisePatientBedLog extends Model
{
   protected $table = 'day_wise_patient_bed_log';
   protected $primaryKey = 'id';
   public $timestamps =  false;
   protected $fillable = ['day_id', 'bed_id', 'created_date_time', 'modified_date_time', 'created_by', 'modified_by'];

   public static function getRoomDetails($id)
   {
      return self::select('bed.number as bed_name', 'room.number as room_name')
      ->leftjoin('bed', 'day_wise_patient_bed_log.bed_id', 'bed.id')
      ->leftjoin('room', 'bed.room_id', 'room.id')
      ->where('day_id', $id)
      ->orderBy('day_wise_patient_bed_log.id', 'desc')
      ->first();
   }

}
