<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class DischargeSummary extends Model
{
	protected $table = 'discharge_summary';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['NameoftheConsultant','Birth','Problems','RespiratorySystem','CardiovascularSystem','GastrointestinalSystem','Communicationwithparents','Investigations','DischargeInstructions','Procedures','Summarybirth','AntenatalUltrasoundScanFindings','CentralNervousSystem','Sepsis','Ophthalmology','Hematology','NewbornScreening','vaccine','Followup','admission_id','baby_id','flag','status','DischargeMedications','UserAdded','UserDeleted','UserModified','DateAdded','DateModified','is_completed', 'is_send', 'interim_summary_content', 'interim_updated_at', 'edited_content', 'edited_time', 'newdiagnosis', 'newproblem', 'additional_information', 'summary'];
  
 

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model)
        {
            $model->set_values();
        });
    }

    public function set_values()
    {
    	$this->attributes['UserAdded']      = 	\Auth::user()->id;
        $this->attributes['UserModified']   = 	\Auth::user()->id;
        $this->attributes['DateAdded']      = 	Carbon::now();
        $this->attributes['DateModified']   = 	Carbon::now();  
        return true;
    }


    /**
     *get the discharge summary for op backgroud 
     *
     *@param babyid integer 
     *@return summayfileds array of objects 
     */
    public static function getSummaryCompleted($baby_id)
    {

        return self::where(['baby_id'=>$baby_id])
                    ->orderBy('admission_id', 'desc')
                    ->pluck('Problems')->toArray();

    }
    
    
}
