<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Neonatal extends Model 
{

  /**
   * This will refer the table name 
   * @var $table type string
   */ 
	protected $table = 'neonatal_proforma';

  /**
   * This will refer the table primarykey  
   * @var $primaryKey type string 
   */ 
	protected $primaryKey = 'NeonatalId';

  /**
   * This will refer the table timestamps  
   * @var $timestamps type boolean 
   */ 
	public $timestamps  =  false;

  /**
   * This will refer the table fillable column  
   * @var $fillable type array 
   */ 
	 protected $fillable = ['BMrNo','AdmissionId','BabyId','Booked','PlaceBooked','AdditionalInformation','AdjustedRiskForTrisomy13','AdjustedRiskForTrisomy18','AdjustedRiskForTrisomy21','AntenatalSteroids','CommentOnLiquor','SteroidCourse','BCG','SeenBy','CordBE','CordBloodGas','CordHCO3','CordpH','CPR','CTG','CTGDetails','DCT','DepthOfInsertion','DischargeMedications','DischargeWeight','DoseVitK','Drugs','OtherInformation','DurationOfOxygen','DurationOfPPV','PPV','DurationOfROM','EDDbyDates','EDDbyUSG','EmbryoTransfer','ETTSize','FacialOxygen','FoetalDistress','GastricAspirate','HepatitisB','HepatitisBVaccine','HIV','HR1','HR10','HR20','HR5','Indication','Presentation','InitialExamination','Intubation','Labour','LastDoseDeliveryInterval','Length','LMP','Malformation','MalformationType','MaternalAntibiotics','MaternalPyrexia','ModeOfDelivery','PregnancyComplications','MultiplePregnancy','NatureofLabour','NewBornExamination','NewBornScreen','Notes','OFC','OralPolio','OtherInvestigations','OpAppointment','PlaceofART','PlaceofSupervision','PLAN','PROM','Reflex1','Reflex10','Reflex20','Reflex5','RegularRespiration','Respiration1','Respiration10','Respiration20','Respiration5','Resuscitation','RouteVitK','Status','Supervised','TimeOf1stGasp','TimeofLastDose','Tone1','Tone10','Tone20','Tone5','TypeofAnesthesia','TypeofART','VDRL','VitaminK','Apgars1min','Apgars10min','Apgars20min','Apgars5min','Colour1','Colour10','Colour20','Colour5','Conception','TestDate','TestTime','DateOfDischarge','UserAdded','DateAdded','DateModified','IsDeleted','UserDeleted','TEST_TIME','TEST_MINS','TEST_AM','Booking','Vaccine','VaccineDate','HearingScreen','PostductalSaturation','AdditionalDetails','Outpatient_TIME','Outpatient_MINS','Outpatient_AM','known_field','transfer_status','Maternal_antibiotics_status','delayed_cord_clamping','duration_dcc','Vaccine_status','mp_common_status','Syntocinon','Colour15','HR15','Reflex15',
    'Tone15','Respiration15','Apgars15min','newbornStatus','adjustedtrisomies','SteroidCourse','Consanguinity','maximum_fio2_required','duration_of_cpr','resusciatation_drugs','discharge_length','discharge_ofc','wb_echo_report','wb_echo_status','timeofgasp_status','regularrespiration_status','insertion_status','ppv_status','cpr_status','reason_dcc', 'antenatal_MgSO4', 'typeofsteroids', 'sepsis_in_mother', 'sepsis_in_mother_type', 'umbilicalcordmilking', 'cutcordmilking', 'bag_mask_ventilator','bag_mask_ventilator_duration', 'bag_mask_ventilator_min', 'initial_steps', 'maternal_pyrexia_fahrenheit', 'maternal_pyrexia_celsius', 'edited', 'edited_content', 'edited_time', 'delivery_room_cpap', 'ict', 'another_adjusted_risk_for_trisomy21', 'another_adjusted_risk_for_trisomy18', 'another_adjusted_risk_for_trisomy13', 'form_status', 'UserModified'];
    
  /**
   * parmeter options
   * @param Syntocinon 1 - Not given ,2 - Given
   * @param known_field 1 - apgar known 2 - Apgar unknown
   */

 /**
	* GET NON DELETED RECORDS FOR LISTING PAGE
  *
  * @param $page type integer
  * @param $limit type integer
  * @param $conditions type array 
  * @param $order type array 
  * @return neonatal list in array of object 
	*/
	public static function  get_lists($page = 1, $limit = 50, $condition = array(), $order = array(), $slug = '')
  {

        $limitstart    = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend      = $limit;
        $search_txt    = isset($condition['search_txt']) ? $condition['search_txt'] : '';
        $status    = isset($condition['status']) ? $condition['status'] : '';
        $checkdate     = '';

        if (strpos($search_txt, '-') > 0) {
            $get_date      = strtotime($search_txt);
            $checkdate     = (!empty($get_date)) ? date('\'Y-m-d\'', $get_date):'';
            $search_txt    = '';
        }

	    	$results = DB::table('baby')
                    ->join('neonatal_proforma', 'baby.BabyId', '=', 'neonatal_proforma.BabyId')
                    ->select('neonatal_proforma.BabyId', 'baby.BabyName', 'baby.DOB', 'baby.BMrNo', 'neonatal_proforma.TestDate', 'neonatal_proforma.TestTime', 'neonatal_proforma.NeonatalId', 'neonatal_proforma.Status', 'neonatal_proforma.edited')
                    ->where('neonatal_proforma.IsDeleted', 0)
                    ->where('baby.IsDeleted', 0)
                    ->where(function ($query) use ($search_txt, $checkdate, $status)
                    {
                        if (!empty($search_txt) && empty($checkdate)) {
                            $query->where('baby.BabyName', 'ilike', '%'.trim($search_txt).'%');
                            $query->orwhere('baby.BMrNo', $search_txt);
                        }

                        if (!empty($checkdate) && empty($search_txt)) {

                           $query->whereRaw('"neonatal_proforma"."TestDate"::date='.$checkdate.' or "DOB"::date='.$checkdate);
                        }

                        if (!empty($status) && empty($search_txt) && empty($checkdate)) {
                          if ($status == 'discharge') {

                            $query->where('neonatal_proforma.Status', 'ilike', '%Discharge%');
                          } else {
                            $query->where('neonatal_proforma.Status', 'not like', '%Discharge%');
                          }
                        }

                    });
           if (isset($order['sortby']) && isset($order['sortorder'])) {
        			      $results->orderBy($order['sortby'], $order['sortorder']);
            }

               // $results=\SiteHelpers::convert_obj_to_array($results);
               // $results=\SiteHelpers::unique_multidim_array($results,'BabyId');
               // $results=\SiteHelpers::convert_array_to_object($results);

        if ($slug) {
          $result['total']  = $results->get()->count();  
          $result['result'] = $results->limit($limitend)->offset($limitstart)->get(); 
        } else {
          $result = $results->limit($limitend)->offset($limitstart)->get(); 
        }

		  return $result;
	}

  /**
  * GET NON DELETED RECORDS COUNT 
  *
  * @return neonatal count in integer
  */
  public static function GetTotal() 
  {
        $result = DB::table('neonatal_proforma')
                  ->join('baby', 'neonatal_proforma.BabyId', '=', 'baby.BabyId')
                  ->where('neonatal_proforma.IsDeleted', 0)
                  ->get()->count();
        return $result;
  }

  /**
   * Get List Based on admission 
   *
   * @param $id integer
   * @return admission list in array of object 
   */

  public static function getSinglebabyList($id)
  {
    	$results = DB::table('neonatal_proforma')
                  ->join('baby', 'neonatal_proforma.BabyId', '=', 'baby.BabyId')
                  ->select('baby.BabyName', 'baby.BMrNo', 'neonatal_proforma.TestDate', 'neonatal_proforma.TestTime', 'neonatal_proforma.NeonatalId', 'neonatal_proforma.Status')
                  ->where('neonatal_proforma.IsDeleted', 0)
      		        ->where('neonatal_proforma.BabyId', $id)
                  ->get();
        return $results;    
  }
  
	/*
	* GET NON DELETED RECORDS FOR LISTING PAGE
	*/	
	public static function  get_record($id)
  {
		$results = DB::table('neonatal_proforma')
            ->leftjoin('newborn_examination', 'newborn_examination.BabyId', '=', 'neonatal_proforma.BabyId')						
            ->join('baby', 'neonatal_proforma.BabyId', '=', 'baby.BabyId')
            ->join('mother', 'mother.MotherId', '=', 'baby.MotherId')			

            ->where('NeonatalId', $id)->get();		
		return $results;
	}
	/**
	* FETCH DATA FOR SEARCH FORM RESULTS
	*/
	public static function GetSearchDatas($value)
  {
			$fillable = ['neonatal_proforma.BMrNo','Booked','PlaceBooked','AdditionalInformation','AdjustedRiskForTrisomy13','AdjustedRiskForTrisomy18','AdjustedRiskForTrisomy21','AntenatalSteroids','CommentOnLiquor','BCG','SeenBy','CordBE','CordBloodGas','CordHCO3','CordpH','CPR','CTG','CTGDetails','DCT','DepthOfInsertion','DischargeMedications','DischargeWeight','DoseVitK','Drugs','OtherInformation','DurationOfOxygen','DurationOfPPV','PPV','DurationOfROM','EDDbyDates','EDDbyUSG','EmbryoTransfer','ETTSize','FacialOxygen','FoetalDistress','GastricAspirate','HepatitisB','HepatitisBVaccine','HIV','Indication','Presentation','InitialExamination','Intubation','Labour','LastDoseDeliveryInterval','Length','LMP','Malformation','MalformationType','MaternalAntibiotics','MaternalPyrexia','ModeOfDelivery','PregnancyComplications','MultiplePregnancy','NatureofLabour','NewBornExamination','NewBornScreen','Notes','OFC','OralPolio','OtherInvestigations','OpAppointment','PlaceofART','PlaceofSupervision','PLAN','PROM','RegularRespiration','Resuscitation','RouteVitK','Status','Supervised','TimeOf1stGasp','TimeofLastDose','TypeofAnesthesia','TypeofART','VDRL','VitaminK','Conception','TestDate','TestTime','DateOfDischarge','Maternal_antibiotics_status'];
		
		$query = DB::table('neonatal_proforma')
    ->join('baby', 'neonatal_proforma.BabyId', '=', 'baby.BabyId')->select('*')->where('neonatal_proforma.IsDeleted', 0);
		
		foreach ($fillable as $column) {
		  $query->orWhere($column, 'like', '%'.$value.'%');
		}
		
		$models = $query->get();		

		return $models;
		
	}
	/**
	* GET POSTNATAL INPATIENTS LIST FOR DAYCARE SHEETS
	*/
	public static function  getInpatients()
  {

		$results = DB::table('neonatal_proforma')
            ->join('baby', 'neonatal_proforma.BabyId', '=', 'baby.BabyId')

            ->select('baby.BabyName', 'baby.BMrNo', 'baby.BabyId', 'neonatal_proforma.TestDate', 'neonatal_proforma.TestTime', 'neonatal_proforma.NeonatalId', 'neonatal_proforma.Status')->where('neonatal_proforma.IsDeleted', 0)
            ->whereIn('baby.BabyId', function ($query) {

                    $query->from('postnatal_discharge')
                          ->select('postnatal_discharge.BabyId') 
                          ->join('postnatal_admission', 'postnatal_admission.BabyId', '=', 'postnatal_discharge.BabyId')
                          ->where('postnatal_admission.IsDeleted', 0)
                          ->where('postnatal_discharge.IsDeleted', 0)
                          ->where('postnatal_discharge.discharge_status', '=', 'Inpatient')
                          ->groupby('postnatal_discharge.BabyId')
                          ->get()->toArray();   

            })
            ->where('neonatal_proforma.IsDeleted', 0)
            ->where('baby.IsDeleted', 0)
            ->orderBy('neonatal_proforma.BabyId', 'desc')
            ->get();		

           
		return $results;
	}
  public static function getNeonatalmp($MotherId, $id)
  {
        return \DB::table('baby')
           ->join('mother', 'mother.MotherId', '=', 'baby.MotherId')
           ->join('neonatal_proforma', 'neonatal_proforma.BabyId', '=', 'baby.BabyId')
           ->where(['baby.MotherId'=>$MotherId, 'neonatal_proforma.mp_common_status'=>0])
           ->where('neonatal_proforma.NeonatalId', '!=', $id)
           ->pluck('NeonatalId');
  }

  public static function getSlibingsdata($baby_id)
  {
    return DB::table('baby')
           ->select('neonatal_proforma.*')  
           ->join('neonatal_proforma', 'neonatal_proforma.BabyId', '=', 'baby.BabyId')
           ->where('baby.BabyId', $baby_id)
           ->first();
   }

  public function usg_findings()
  {

    return $this->hasMany('App\Models\Usg', 'BabyId', 'BabyId');

  }

  public static function checkNeonatal($baby_id) 
  {
     return \DB::table('baby')
            ->join('neonatal_proforma', 'neonatal_proforma.BabyId', '=', 'baby.BabyId')
            ->where('baby.BabyId', $baby_id)
            ->where('neonatal_proforma.IsDeleted', 0)
            ->orderBy('NeonatalId', 'desc')
            ->get();
  
  }
  /**
   * This method to check neonatal proforma has
   * nicu admission or postnatal admission 
   *
   * @param  $baby_id type int
   * @param  $type type int  
   * @return type array of object 
   */
  public static function getNeonatalDependancy($baby_id, $type = 1)
  {

     if ($type == 1) {
        return \DB::table('neonatal_proforma')
                  ->join('nicu_admission', 'nicu_admission.BabyId', '=', 'neonatal_proforma.BabyId')
                  ->where('neonatal_proforma.IsDeleted', '0')
                  ->where('nicu_admission.IsDeleted', '0')
                  ->where('neonatal_proforma.BabyId', $baby_id)
                  ->get();
     } elseif($type == 2) {

        return \DB::table('neonatal_proforma')
                  ->join('postnatal_admission', 'postnatal_admission.BabyId', '=', 'neonatal_proforma.BabyId')
                  ->where('neonatal_proforma.IsDeleted', '0')
                  ->where('postnatal_admission.IsDeleted', '0')
                  ->where('neonatal_proforma.BabyId', $baby_id)
                  ->get();

     }

  }

 /**
  * This method used to fetch all neonatal record
  * 
  * @param $id type integer
  *
  * @return array of objects
  */
  public static function neonatal_delete_approval($id)
  {
      $results = DB::table('neonatal_proforma')
                  ->join('baby', 'neonatal_proforma.BabyId', '=', 'baby.BabyId')
                  ->select('baby.BabyName', 'baby.BMrNo', 'neonatal_proforma.TestDate', 'neonatal_proforma.TestTime', 'neonatal_proforma.NeonatalId', 'neonatal_proforma.Status')
                  ->where('neonatal_proforma.BabyId', $id)
                  ->get();
        return $results;    
  }

 /**
  * This method to check whether the neonatal is deleted or not.
  * 
  * @param $id type integer
  *
  * @return array of objects
  */
public static function neonatal_delete($baby_id, $id = '') 
{
      $results = DB::table('neonatal_proforma')
                  ->leftjoin('delete_approval', 'delete_approval.ModuleId', '=', 'neonatal_proforma.NeonatalId')
                  ->where(function($query) use ($baby_id, $id) {
                        $query->where('delete_approval.Status', 'Approved')                    
                          ->where('delete_approval.ModuleName', 'Neonatal Proforma')                    
                          ->where('neonatal_proforma.BabyId', $baby_id)
                          ->where('neonatal_proforma.NeonatalId', $id);
                    })
                        ->orderBy('delete_approval.Id','desc')
                        ->first();
        return $results; 
}



}
