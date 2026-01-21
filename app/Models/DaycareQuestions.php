<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DaycareQuestions extends Model
{
   protected $table='daycare_questions';
   protected $primaryKey = 'dayquestionid';
   public $timestamps=false;
   protected $gaurded = ['dayquestionid'];
   protected $fillable=['respiratory_problem','Cardiovascular_problem','isDeleted','UserAdded','UserModified',
                        'DateAdded','DateModified','DayId','BabyId','AdmissionId','directlybreastfeed','othertypefeed',
                        'workingWeight','iv_fluids','drug_infusions','other_drugs','Carbohydrates','Protein','Fat',
                        'gastrointestinal_problem','Pupils','central_problem','sedation_paralysis','urine_output_day',
                        'drug_infusions_ml_day','iv_fluids_ml_day','total_energy','neuro_sonogram','gir','needlethoracentesis',
                        'intercostaldrain','ultrasoundabdominal','ultrasoundkeyfindings','renalultrasound','renalultrasoundkeyfindings',
                         'mri_ct_brain','mrict_brain_status','viral_meningitis','lumbar_puncture','ultrasound_spine','ultrasound_spine_report','dilution_exchange'];


   public static function get_record($dayid)
   {
   	  return DB::table('daycare_questions')
   	          ->where('DayId', $dayid)
   	          ->first();

   }

   public static function getPreviousWorkingWeight($baby_id)
   {
        return self::select('workingWeight')
                ->where('BabyId', $baby_id)
                ->whereNotNull('workingWeight')
                ->where('workingWeight', '<>', '')
                ->orderBy('DayId', 'desc')
                ->first();

   }

 
}
