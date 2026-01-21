<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NicuProblemBaseSummary extends Model
{
    protected $table = 'nicu_problem_based_discharge_edited';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['baby_id', 'admission_id','edited', 'edited_content', 'edited_time', 'interim_summary_content', 'interim_updated_at'];
  
 

}
