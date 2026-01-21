<?php

namespace App\Models\Nurse;

use Illuminate\Database\Eloquent\Model;

class LoincCodeGroup extends Model
{
     protected $table = 'local_code_group';
	 protected $primaryKey = 'id';
	 public    $timestamps  =  false;
	 protected $fillable = ['local_code', 'local_description' , 'active_flag', 'create_user_id', 'create_tstamp', 'modify_user_id', 'modify_tstamp', 'local_code_parent_id'];

}
