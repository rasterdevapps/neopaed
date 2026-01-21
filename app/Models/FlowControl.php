<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FlowControl extends Model
{
   
    protected $table      = 'flow_control';
	protected $primaryKey = 'fcid';
	public $timestamps    =  false;
	protected $fillable   = ['is_new_patient', 'admission_module', 'current_module', 'status', 'user_id', 'start_date',
	                          'complted_date', 'baby_id', 'mother_id', 'admission_id', 'menu_name', 'resource_id', 'multiple_pregnancy'];

    public static function incompletelist() 
    {

    	 return \DB::table('flow_control')
    	            ->where('status', false)
    	            ->get(); 
    }

}
