<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PediatricDischargeSummary extends Model
{
	protected $table = 'pediatric_discharge_summary';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['pediatric_id', 'created_by', 'created_date_time', 'modified_by', 'modified_date_time', 'deleted_by', 'is_deleted', 'medications'];
    
}
