<?php
namespace App\Models\Reports;

use Illuminate\Database\Eloquent\Model;

/**
 * Methods to Nicu problem based discharge summary
 *
 * @author Manikandan M  
 */
class ProblemDischarge extends Model
{
    
  /**
  * This Method to retive the  Nicu baby list 
  *
  * @return list of babies in array of object 
  */
  public static function getList($page=1, $limit=50, $condition = array(), $order=array(), $slug = '', $summary_type = '', $status = '')
  {

    $limitstart    = ((empty($page) || $page == 1) && !is_numeric($page)) ? 1 : (($page-1)*$limit);

    $limitend      = $limit;
    $search_txt    = isset($condition['search_txt']) ? trim($condition['search_txt']) : '';
    $checkdate     = '';

    if (strpos($search_txt, '-') > 0) {
      $get_date      = strtotime($search_txt);
      $checkdate     = (!empty($get_date)) ? date('\'Y-m-d\'', $get_date):'';
      $search_txt    = '';
    }

    $results = \DB::table('baby')
    ->select('baby.*', 'neonatal_proforma.NeonatalId')
    ->leftjoin('neonatal_proforma', 'baby.BabyId', 'neonatal_proforma.BabyId')
                  ->whereIn('baby.BabyId', function ($query) use ($summary_type, $status) {
                     $query->select('BabyId')
                           ->from('nicu_admission')
                           ->where('IsDeleted', '0');
                           if ($summary_type != '') {
                           if ($summary_type == 'interim') {
                            $query->where('status', '=', 'Inpatient');
                           }
                           else{
                            $query->where('status', '<>', 'Inpatient');

                           }
                         }
                if ($status == 'inpatient') {
                    $query->where('status', 'Inpatient');
                }
                elseif ($status == 'discharged') {
                    $query->where('status', '!=', 'Inpatient');
                }
                           $query->groupby('BabyId')
                           ->get()
                           ->toArray();
                  })
                  ->where('baby.IsDeleted', '0')
                  ->where('neonatal_proforma.IsDeleted', '0')
                  // ->orderby('baby.BabyId', 'desc')
                  ->where(function ($query) use ($search_txt, $checkdate) {
                      if ($search_txt) {
                        $query->whereRaw('LOWER("baby"."BabyName") like '."'%".strtolower($search_txt)."%'");
                        $query->orWhereRaw('LOWER("baby"."BMrNo") like '."'%".strtolower($search_txt)."%'");
                      } elseif ($checkdate) {
                        $query->whereRaw('"DOB"::date='.$checkdate);
                      }
                    });

    if (isset($order['sortby']) && isset($order['sortorder'])) {
      $results->orderBy($order['sortby'], $order['sortorder']);  
    }
    if ($slug) {
      return $results;
    } else {
      $result = $results->limit($limitend)->offset($limitstart)->get();           
    }
    return $result;      
  }

  /**
  * This Method to retive the  Nicu baby admission list 
  *
  * @param   $id type integer baby id 
  * @return list of babies in array of object 
  */
  public static function getAdmissionlist($id) 
  {
     $results = \DB::table('baby')
                ->select('baby.*', 'baby_admission.*', 'nicu_admission.DischargeDate', 'nicu_admission.AdmissionId', 'nicu_problem_based_discharge_edited.edited', 'nicu_problem_based_discharge_edited.interim_updated_at', 'ip_numbers.ip_number', 'ip_numbers.status')
                ->join('nicu_admission', 'nicu_admission.BabyId', '=', 'baby.BabyId')
                ->join('baby_admission', 'baby_admission.AdmissionId', '=', 'nicu_admission.AdmissionId')
                ->leftjoin('nicu_problem_based_discharge_edited', 'nicu_problem_based_discharge_edited.baby_id', '=', 'baby.BabyId')
                ->leftjoin('ip_numbers', 'ip_numbers.AdmissionId', '=', 'nicu_admission.AdmissionId')
                ->where('nicu_admission.IsDeleted', '0')
                ->where('baby.BabyId', $id)
                ->get();
                // echo "<pre>"; print_r($results); exit;
     return $results;           

  }

  /**
   * This Method to retrive the discharge summary 
   *
   * @param $baby_id type integer  
   *
   * @return baby details in array of object 
   */
   public static function getNewbornDetails($baby_id)
   {
        $results = \DB::table('baby')
                   ->selectRaw('case when char_length("TOB_TIME"::text) = 1 then \'0\'|| "TOB_TIME"::text
                                     when char_length("TOB_TIME"::text) = 2 then "TOB_TIME"::text
                                end 
                                || \':\' ||
                                case when char_length("TOB_MINS"::text) = 1 then \'0\'|| "TOB_MINS"::text
                                     when char_length("TOB_MINS"::text) = 2 then "TOB_MINS"::text
                                end     
                               || \':\' || "TOB_AM"::text as tob, to_char("DOB", \'DD - MM - YYYY \') as dateofbirth')

                    ->addSelect('baby.BMrNo as mrno', 'baby.BabyName', 'baby.Gestation', 'baby.Sex', 'baby.BirthWeight', 'baby.BabyBloodGroup')
                    ->addSelect('baby.neonatal_consultant')
                    ->addSelect('neonatal_proforma.ModeOfDelivery', 'baby.BirthOrder', 'baby.BirthStatus', 'mother.MotherBloodGroup')
                    ->addSelect('neonatal_proforma.Apgars1min', 'neonatal_proforma.Apgars5min', 'neonatal_proforma.Apgars10min')
                    ->addSelect('neonatal_proforma.DischargeWeight as discharge_wt', 'neonatal_proforma.discharge_length', 'neonatal_proforma.discharge_ofc')
                    ->addSelect('neonatal_proforma.*', 'mother.*')
                    ->join('neonatal_proforma', 'neonatal_proforma.BabyId', '=', 'baby.BabyId')
                    ->join('mother', 'mother.MotherId', '=', 'baby.MotherId')
                    ->where(['baby.IsDeleted'=>'0', 'neonatal_proforma.IsDeleted'=>'0'])
                    ->where(['baby.BabyId'=>$baby_id])
                    ->first();
        

       return $results;
   }

   /**
    * This Method to retrive the admission details for summary
    *
    * @param $baby_id type integer
    *
    * @param $admission_id type integer
    *
    * @return baby admission details in array of object
    */
   public static function getAdmissionDetails($baby_id, $admission_id) 
   {

      $results = \DB::table('baby')
                 ->selectRaw('case when to_char("nicu_admission"."AdmissionDate",  \'YYYY \') = \'1970\' then \'N/A\'
                                   else to_char("nicu_admission"."AdmissionDate",  \'DD-MM-YYYY \') 
                                   end as admission_date')
                 ->selectRaw('case when to_char("nicu_admission"."DischargeDate",  \'YYYY\') = \'1970\' then \'N/A\'
                                   else to_char("nicu_admission"."DischargeDate",  \'DD-MM-YYYY \') 
                                   end as discharge_date')
                 ->addSelect('nicu_admission.*')
                 ->addSelect('nicu_admission.CorrectedGestation as admission_cga', 'nicu_admission.corrected_gestation as discharge_cga')
                 ->addSelect('nicu_admission.DischargeWeight as discharge_wt', 'nicu_admission.OFC as discharge_ofc', 'nicu_admission.Length as discharge_length')
                 ->addSelect('ip_numbers.ip_number')
                 ->join('baby_admission', 'baby_admission.BabyId', '=', 'baby.BabyId')
                 ->join('nicu_admission', 'nicu_admission.AdmissionId', '=', 'baby_admission.AdmissionId')
                 ->leftjoin('ip_numbers', 'ip_numbers.AdmissionId', '=', 'nicu_admission.AdmissionId')
                 ->where(['baby.BabyId'=>$baby_id, 'baby_admission.AdmissionId'=>$admission_id])
                 ->where(['baby.IsDeleted'=>'0', 'nicu_admission.IsDeleted'=>'0'])
                 ->first();

      return $results;            

   }

   /**
   * This Method to retrive the mother's medical problems
   * 
   * @param $baby_id type integer
   *
   * @return medical problems in array 
   */ 
   public static function getMotherMedicalProblems($baby_id) 
   {
      $results = \DB::table('medical_problems')
                  ->join('mas_medical_problems', 'mas_medical_problems.Id', '=', 'medical_problems.Problem')
                  ->where('medical_problems.BabyId', $baby_id)
                  ->get()->pluck('Name')->toArray();
       return $results;           
   }

  /**
  * This Method to retrive the pregnancy complications
  *
  * @param $baby_id type integer
  *
  * @return pregnancy complications in array 
  */
  public static function getMotherPregnancyComplications($baby_id)
  {
     $results = \DB::table('complications')
                ->join('mas_complication', 'mas_complication.Id', '=', 'complications.Complication')
                ->where('complications.BabyId', $baby_id)
                ->get()->pluck('Name')->toArray();

      return $results;          


  }

  /**
   * This Method to retrive the usg findings
   *
   * @param $baby_id type integer
   *
   * @return usg findings in array 
   */
   public static function getUsgFindings($baby_id) 
   {
     $results = \DB::table('usg_finding')
                ->where('BabyId', $baby_id)
                ->get(); 
       //  echo '<pre>';print_r($results);exit;       
      return $results;          

   }

   /**
    * This Method to retrive the delivery indications
    *
    * @param $indication type json
    *
    */ 
   public static function getDeliveryIndication($indication)
   {

      $results = '';
      $indication = collect(json_decode($indication))->toArray();
        $indication = array_filter($indication);
      if (count($indication) > 0) {

         $results = \DB::table('mas_indication')
                     ->whereIn('Id', $indication)
                     ->get()
                     ->pluck('indication_name')
                     ->toArray();
      }

     return $results;

   }

   /**
    *This method to retrive the discharge medications 
    * 
    * @param $baby_id
    * @param $admission_id
    * @return discharge medications based on admission in array 
    */
   public static function getDischargeMedications($baby_id, $admission_id, $flag) 
   {
      $results = \DB::table('discharge_medications')
                     ->select('mas_drugivfluid.brand_name as Name', 'discharge_medications.genericname', 'discharge_medications.Dose')
                     ->addSelect('discharge_medications.Frequency', 'discharge_medications.Duration', 'mas_drugivfluid.value as Value')
                     ->join('mas_drugivfluid', 'mas_drugivfluid.id', '=', 'discharge_medications.Medication')
                     ->where(['discharge_medications.BabyId' => $baby_id, 'discharge_medications.AdmissionId' => $admission_id])
                     ->where('discharge_medications.flag', $flag)
                     ->get();
      return $results;

   }

   /**
    *This method to retrive the problems form problem based system
    *
    * @param $baby_id  
    * @param $admission_id
    * @return problem in array 
    */
   public static function getNeonatalProblems($baby_id, $admission_id)
   {

      $results = \DB::table('pb_daycare_list as pbd')
                     ->join('pb_episodes_list as pbe', 'pbe.pb_day_id', '=', 'pbd.pb_day_id')
                     ->join('pd_published', function($join)
                       {
                            $join->on('pd_published.published_id', '=', 'pbe.pp_id')
                            ->on('pd_published.problem_id', '=', 'pbe.problem_id');

                       })
                     ->where('pbd.IsDeleted', 0)
                     ->where('pbe.IsDeleted', 0)
                     ->where(['pbd.baby_id'=> $baby_id, 'pbd.admission_id'=> $admission_id])
                     ->get();
      return $results; 

   }

   /**
    * This method procedure list  
    *
    * @param $procedures type json 
    * @return procedure list 
    */
    public static function getProcedureList($procedures)
    {
        $results = '';
        $temp_procedures = json_decode($procedures);
        $procedures = is_array($temp_procedures) ? array_filter($temp_procedures) : [];

        if (count($procedures) > 0) {

            $results = \DB::table('mas_procedures')
                        ->whereIn('Id', $procedures)
                        ->get()
                        ->pluck('Name')
                        ->toArray();
        }                
        return  $results;

    }

  /**
   * FETCH NON DELETED DATA RECORD COUNT
   *
   * @return integer
   */ 
  public static function GetTotal() 
  {
    $result = \DB::table('baby')
                  ->whereIn('baby.BabyId', function ($query) {
                     $query->select('BabyId')
                           ->from('nicu_admission')
                           ->where('IsDeleted', '0')
                           ->where('status', '<>', 'Inpatient')
                           ->groupby('BabyId')
                           ->get()
                           ->toArray();
                  })
                  ->where('baby.IsDeleted', '0')
                  ->orderby('baby.BabyId', 'desc')
                  ->get()->count();
    return $result;
  }


   



}












