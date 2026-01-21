<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocalCodeGroup extends Model
{
	protected $table = 'local_code_group';
	protected $primaryKey = 'id';
	public $timestamps  =  false;
	protected $fillable = ['local_code','local_description','active_flag','create_user_id','create_tstamp','modify_user_id','modify_tstamp','local_code_parent_id','observation_name', 'parameter_priority', 'color_code', 'acronym', 'chart_status', 'interfacing_chart', 'manual_chart', 'chart_type', 'module_type', 'approval_parameter_priority'];

    public static function list()
    {
    	$result = self::orderBy('id', 'asc')->get();
    	return $result;
    }
}
