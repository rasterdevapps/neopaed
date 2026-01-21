<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class DdstMaster extends Model
{
    protected $table = 'ddst_settings';
    protected $primaryKey = 'id';
    public $timestamps  =  false;
    protected $fillable = ['task_id', 'name', 'x_value', 'x_end_value', 'y_value', 'y_end_value', 'siblings', 'nofill', 'rowsize', 'rrposition', 'rbposition', 'countno', 'ctposition', 'crposition', 'align', 'fill', 'stroke', 'percentage',' create_user_id', 'create_tstamp', 'modify_user_id', 'modify_tstamp', 'percentage_align'];

    public static function list()
    {
        $result = self::whereNotNull('stroke')->whereNotNull('task_id')->whereNotNull('name')->orderBy('id', 'asc')->get();
        return $result;
    }
}
