<?php

namespace App\Models\Ward;

use Illuminate\Database\Eloquent\Model;

class WaitingList extends Model
{
   protected   $table       = 'waiting_list';
   protected   $primaryKey  = 'id';
   public      $timestamps  =  false;
   protected   $fillable    = ['patientid', 'genderBased', 'specialitywise', 'desired_room_type_id', 'current_ward_id', 'roomstatus'];
}
