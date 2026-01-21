<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PostDaycare extends Model 
{
	protected $table      = 'postnatal_daycare';
	protected $primaryKey = 'PDayId';
	public    $timestamps =  false;
	protected $gaurded    = ['PDayId'];
	protected $fillable   = ['DateAdded','AdmissionId','BabyId','SeenBy','NeonatalId','MotherId','DateModified','examination_normal','Notes','DayDate','DayTime','DayOfLife','PreviousProblems','CurrentProblems','Plan','AnteriorFontanelle','Activity','Cephalhematoma','Color','EyeInfection','RespiratoryDistress','CardiacMurmur','Femorals','UmbilicalInfection','Hips','Genitalia','NeonatalJaundice','TCB','TSB','Phototherapy','PassedUrine','BowelsOpen','UserAdded','UserDeleted','IsDeleted','OtherFindings', 'additional_diagnosis', 'differentialdiagnosis', 'postnatal_sepsis', 'postnatal_antiboitic','postnatal_other_drugs','blood_culture','postnatal_organism', 'edited', 'edited_content', 'edited_time', 'PreviousWt', 'CurrentWt', 'WtChange', 'WtChangeBirth', 'hb', 'Background'];
	
	/**
	* GET DATA FOR POSTNATAL DAYCARE LISTING 
	*/
	public static function get_lists($page = 1, $limit = 10, $condition = array(), $order=array(), $slug = '', $status = '')
	{
		 $limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
         $limitend   = $limit;
         $search_txt = isset($condition['search_txt']) ? $condition['search_txt'] : '';

          $checkdate     ='';
         if (strpos($search_txt, '-') > 0) {
            $get_date      = strtotime($search_txt);
            $checkdate     = (!empty($get_date)) ? date('\'Y-m-d\'', $get_date):'';
            $search_txt    = (!empty($checkdate)) ? '' : $search_txt;
          }

		$results = DB::table('postnatal_daycare')
            ->join('baby', 'postnatal_daycare.BabyId', '=', 'baby.BabyId')
            ->leftjoin('postnatal_discharge', 'postnatal_discharge.BabyId', '=', 'baby.BabyId')
            ->leftjoin('neonatal_proforma', 'neonatal_proforma.BabyId', '=', 'postnatal_daycare.BabyId')
            ->select('baby.BabyName', 'baby.BMrNo', 'baby.DOB', 'baby.BabyId')
            ->where('neonatal_proforma.IsDeleted', 0)
            ->where('postnatal_daycare.IsDeleted', 0)
            ->where(function ($query) use ($status) {
                if ($status == 'inpatient') {
                    $query->where('discharge_status', 'Inpatient');
                }
                elseif ($status == 'discharged') {
                    $query->where('discharge_status', '!=', 'Inpatient');
                }
            })
            ->where(function ($query) use ($search_txt, $checkdate) {
                if (!empty($search_txt) && empty($checkdate)) {
                    $query->where('baby.BabyName', 'ilike', '%'.trim($search_txt).'%');
                    $query->orwhere('baby.BMrNo', $search_txt);
                }

                if (!empty($checkdate) && empty($search_txt)) {


                    $query->whereRaw('"baby"."DOB"::date='.$checkdate);  
                }
                // if (empty($checkdate) && empty($search_txt)) {

                //             $query->whereIn('discharge_status',['Inpatient']);
                //         }

            })
            ->where('baby.IsDeleted', 0);
           if (isset($order['sortby']) && isset($order['sortorder'])) {
              $results->orderBy($order['sortby'], $order['sortorder']);
            }
            
        if ($slug) {
          $result['total'] = $results->groupby('baby.BabyId', 'neonatal_proforma.NeonatalId')->get()->count();
          $result['result'] = $results->groupby('baby.BabyId', 'neonatal_proforma.NeonatalId')->limit($limitend)->offset($limitstart)->get();
          // $result['result'] = \SiteHelpers::convert_obj_to_array($result['result']->toArray());
          // $result['result'] = \SiteHelpers::unique_multidim_array($result['result'], 'BabyId');
          // $result['result'] = \SiteHelpers::convert_array_to_object($result['result']);  
        } else {
          $result = $results->groupby('baby.BabyId', 'neonatal_proforma.NeonatalId')->limit($limitend)->offset($limitstart)->get();
          // $result = \SiteHelpers::convert_obj_to_array($result->toArray());
          // $result = \SiteHelpers::unique_multidim_array($result, 'BabyId');
          // $result = \SiteHelpers::convert_array_to_object($result);  
        }

         return $result;
	}

	public function get_postanatal_sublist($BabyId)
	{
		$result = DB::table('baby')
		        ->select('baby_admission.AdmissionId', 'ip_numbers.ip_number', 'baby_admission.episodes', 'baby.*', 'postnatal_daycare.DayDate', 'postnatal_admission.admission_date')
                ->leftjoin('postnatal_admission', 'postnatal_admission.BabyId', '=', 'baby.BabyId')
		        ->leftjoin('postnatal_daycare', 'postnatal_daycare.BabyId', '=', 'baby.BabyId')
		        ->join('baby_admission', 'baby_admission.AdmissionId', '=', 'postnatal_daycare.AdmissionId')
		        ->leftjoin('ip_numbers', 'ip_numbers.AdmissionId', '=', 'postnatal_daycare.AdmissionId')
		        ->where('postnatal_daycare.IsDeleted', 0)
		        ->where('baby.BabyId', $BabyId)
              	// ->orderBy('postnatal_daycare.DayDate', 'desc')
		        ->get();
		    $result=\SiteHelpers::convert_obj_to_array($result->toArray());
            $result=\SiteHelpers::unique_multidim_array($result, 'AdmissionId');
            $result=\SiteHelpers::convert_array_to_object($result);  

        return $result;    

	}
	public function get_postanatal_day_list($admission_id, $babyId)
	{
		return DB::table('postnatal_daycare')
		       ->select('postnatal_daycare.*', 'baby.BabyName', 'baby_admission.episodes')
		       ->join('baby', 'baby.BabyId', '=', 'postnatal_daycare.BabyId')
		       ->join('baby_admission', 'baby_admission.AdmissionId', '=', 'postnatal_daycare.AdmissionId')
		       ->where(['postnatal_daycare.BabyId'=>$babyId, 'postnatal_daycare.AdmissionId'=>$admission_id, 'postnatal_daycare.IsDeleted'=>0])
		       ->orderBy('postnatal_daycare.DayDate', 'desc')
		       ->get();

	}
	public static function getTotal()
	{

		$result = DB::table('postnatal_daycare')
            ->join('baby', 'postnatal_daycare.BabyId', '=', 'baby.BabyId')
            ->select('baby.BabyName', 'baby.BMrNo', 'baby.DOB', 'postnatal_daycare.*')
            ->where('postnatal_daycare.IsDeleted', 0)
            ->get();

        $result = \SiteHelpers::convert_obj_to_array($result->toArray());
        $result = \SiteHelpers::unique_multidim_array($result, 'BabyId');
        $result = \SiteHelpers::convert_array_to_object($result);  
        return count($result);  

	}
	/**
	* GET DATA FOR POSTNATAL DAYCARE EDIT FORM
	*/	
	public static function  get_record($id)
	{
		$results = DB::table('postnatal_daycare')
			->select('*', 'baby.Background as baby_bg', 'postnatal_daycare.Background as Background')
            ->join('baby', 'postnatal_daycare.BabyId', '=', 'baby.BabyId')
            ->join('mother', 'mother.MotherId', '=', 'baby.MotherId')
            ->where('PDayId', $id)->first();		
		return $results;
	}	

	public static function get_previous_daycare($id)
	{
	     return DB::table('postnatal_daycare')
	                ->where(['AdmissionId'=>$id, 'IsDeleted'=>0])
	                ->orderby('PDayId', 'desc')
	                ->first();
	}

	/*
	* GET RECORDS FOR SEARCH FORM FILTERS
	*/		
	public static function GetSearchDatas($value)
	{
		
		$fillable = ['Notes','PreviousProblems','CurrentProblems','Plan','AnteriorFontanelle','Activity','Cephalhematoma','Color','EyeInfection','RespiratoryDistress','CardiacMurmur','Femorals','UmbilicalInfection','Hips','Genitalia','NeonatalJaundice','TCB','TSB','Phototherapy','PassedUrine','BowelsOpen','OtherFindings','baby.BabyName','baby.BMrNo'];
		
		$query = DB::table('postnatal_daycare')->join('baby', 'postnatal_daycare.BabyId', '=', 'baby.BabyId')->select('*');
		
		foreach ($fillable as $column) {
			
		  $query->orWhere($column, 'like', '%'.$value.'%');
		}
		
		$models = $query->get();		

		return $models;
		
	}

	public static function getPostnataldailydetails($babyId, $admission_id)
	{
       return self::where(['BabyId'=>$babyId, 'AdmissionId'=>$admission_id, 'IsDeleted'=>0])
                   ->orderby('PDayId','dsec')
                   ->first();

	}

  /**
   * This method used to fetch all daycare record 
   * 
   * @param $baby_id type integer
   *
   * @return array of objects
   */ 
	public static function daycare_delete_approval($baby_id)
	{
        $result =  DB::table('postnatal_daycare')
                    ->join('baby_admission', 'baby_admission.AdmissionId', '=', 'postnatal_daycare.AdmissionId')
                    ->where('postnatal_daycare.BabyId', $baby_id)
                    ->select('baby_admission.episodes')
                    ->addSelect('postnatal_daycare.BabyId', 'postnatal_daycare.AdmissionId', 'postnatal_daycare.PDayId')
                    ->orderby('baby_admission.episodes','asc')
                    ->orderby('postnatal_daycare.PDayId','asc')
                    ->get();
        return $result;
	}

	/**
     * This method to check whether the daycare entry is deleted or not.
     * 
     * @return array of objects
     */
	  public static function daycare_delete($post_id, $PDayId)
	  {
	    $result =  DB::table('postnatal_daycare')
	                    ->join('postnatal_admission', 'postnatal_admission.AdmissionId', '=', 'postnatal_daycare.AdmissionId')
	                    ->leftjoin('delete_approval', 'delete_approval.ModuleId', '=', 'postnatal_daycare.PDayId')                    
	                    ->where('delete_approval.Status', 'Approved')
	                    ->where('postnatal_admission.pid', $post_id)
	                    ->where('postnatal_daycare.PDayId', $PDayId)
	                    ->where('delete_approval.ModuleName', 'Postnatal Daycare Sheet')
	                    ->orderby('delete_approval.Id','desc')
	                    ->first();
	    return $result;
	  }
	/**
     * This method to get baby details by admission ID 
     * 
     * @return array of objects
     */
	  public static function getBabyDetails($admission_id)
	  {
	    $result =  DB::table('baby_admission')
	                    ->select('baby_admission.AdmissionId','baby_admission.BabyId','baby_admission.episodes','baby.BMrNo','baby.BabyName','neonatal_proforma.NeonatalId')
	                    ->join('baby', 'baby.BabyId', '=', 'baby_admission.BabyId')
	                    ->join('neonatal_proforma', 'neonatal_proforma.BabyId', '=', 'baby_admission.BabyId')
	                    ->where('baby_admission.AdmissionId', $admission_id)
	                    ->first();
	    return $result;
	  }

	public static function getPostnatalBabyDates($baby_id, $admission_id)
	{

	    return DB::table('postnatal_daycare')->select('DayDate')
	        ->where(['BabyId' => $baby_id, 'AdmissionId' => $admission_id])->where('postnatal_daycare.IsDeleted', 0)
	        ->pluck('DayDate')
	        ->unique()
	        ->toArray();
	}
}
