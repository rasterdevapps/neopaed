<?php
namespace App\Models\Nurse;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

//This models for only fetch data

class NicuNurseDaycare extends Model
{
   protected $table = 'daycare';
   protected $primaryKey = 'DayId';
   public $timestamps  =  false;


   public function getMainlist($page=1, $limit=50, $condition = array(), $order=array(), $slug = '')
    {
        $limitstart    = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend      = $limit;
        $search_txt    = isset($condition['search_txt']) ? trim($condition['search_txt']) : '';
        $checkdate     = '';

        if (strpos($search_txt, '-') > 0) {
            $get_date      = strtotime($search_txt);
            $checkdate     = (!empty($get_date)) ? date('\'Y-m-d\'', $get_date):'';
            $search_txt    = '';
        }

   	    $results= DB::table('daycare')
             	         ->select('baby.BabyName', 'baby.BabyId', 'baby.DOB', 'baby.BMrNo', 'daycare.DayDate', 'daycare.AdmissionId', 'daycare.DayId', 'daycare.Care')
             	         ->join('baby', 'baby.BabyId', '=', 'daycare.BabyId')
             	         ->join('nicu_admission', 'nicu_admission.BabyId', '=', 'daycare.BabyId')
             	         ->where(['daycare.IsDeleted'=>0, 'nicu_admission.status'=>'Inpatient', 'nicu_admission.IsDeleted'=>0])
                       ->where(function ($query) use ($search_txt, $checkdate) {
                            if ($search_txt) {
                                $query->whereRaw('LOWER("baby"."BabyName") like '."'%".strtolower($search_txt)."%'");
                                $query->orWhereRaw('LOWER("baby"."BMrNo") like '."'%".strtolower($search_txt)."%'");
                            } elseif ($checkdate) {
                                $query->whereRaw('"baby"."DOB"::date='.$checkdate);
                            }
                        });

        if (isset($order['sortby']) && isset($order['sortorder'])) {
            $results->orderBy($order['sortby'], $order['sortorder']);  
        }

        if ($slug) {  
          $result[]= $results->get()->unique('BabyId')->count();
          $result[] = $results->limit($limitend)->offset($limitstart)->get()->unique('BabyId');
          // echo "<pre>"; print_r($result); exit;
          // $results=\SiteHelpers::convert_obj_to_array($results->toArray());
          // $results=\SiteHelpers::unique_multidim_array($results, 'BabyId');
          // $result[]=\SiteHelpers::convert_array_to_object($results);
          return $result;   
        } else {
          $results= $results->limit($limitend)->offset($limitstart)->get();
          // $results=\SiteHelpers::convert_obj_to_array($results->toArray());
          // $results=\SiteHelpers::unique_multidim_array($results, 'BabyId');
          // $results=\SiteHelpers::convert_array_to_object($results);
          return $results;   
        }   
      

   }

    public function getSublist($babyid)
    {

      $results = DB::table('daycare')
    	 ->select('baby.BabyName', 'baby.BabyId', 'baby.DOB', 'baby.BMrNo', 'daycare.DayDate', 'daycare.AdmissionId', 'daycare.DayId', 'daycare.Care', 'ip_numbers.ip_number', 'baby_admission.episodes', 'nicu_admission.AdmissionDate', 'nicu_admission.DischargeDate')
            ->join('baby', 'daycare.BabyId', '=', 'baby.BabyId')
            ->join('baby_admission', 'baby_admission.AdmissionId', '=', 'daycare.AdmissionId')
            ->join('nicu_admission', 'nicu_admission.AdmissionId', '=', 'daycare.AdmissionId')   
            ->leftjoin('ip_numbers', function ($join)
				{
   					 $join->on('daycare.AdmissionId', '=', 'ip_numbers.AdmissionId');
   					 $join->on('daycare.BabyId', '=', 'ip_numbers.baby_id');
				})    
            // ->where(['nicu_admission.status'=>'Inpatient', 'daycare.IsDeleted'=>0, 'baby.BabyId'=>$babyid])
            ->where('baby.BabyId', $babyid)
            ->orderBy('daycare.DayId', 'desc')
            ->get()->unique('AdmissionId');	

         // $results=\SiteHelpers::convert_obj_to_array($results->toArray());
         // $results=\SiteHelpers::unique_multidim_array($results, 'AdmissionId');
         // $results=\SiteHelpers::convert_array_to_object($results); 
            // echo "<pre>"; print_r($results); exit;
         return $results;

    }

    public function getAdmissiondayList($babyid, $admissionid)
    {

		$results = DB::table('daycare')
            ->join('baby', 'daycare.BabyId', '=', 'baby.BabyId')
            ->select('baby.BabyName', 'baby.BabyId', 'baby.DOB', 'baby.BMrNo', 'daycare.DayDate', 'daycare.AdmissionId', 'daycare.DayId', 'daycare.Care', 'ip_numbers.ip_number', 'baby_admission.episodes')
            ->where('daycare.IsDeleted', 0)
            ->join('nicu_admission', 'nicu_admission.AdmissionId', '=', 'daycare.AdmissionId')
            ->leftjoin('baby_admission', 'baby_admission.AdmissionId', '=', 'daycare.AdmissionId')   
            ->leftjoin('ip_numbers', function ($join)
				      {
   					 $join->on('daycare.AdmissionId', '=', 'ip_numbers.AdmissionId');
   					 $join->on('daycare.BabyId', '=', 'ip_numbers.baby_id');
			       	})
            ->where(['nicu_admission.status'=>'Inpatient', 'daycare.IsDeleted'=>0, 'baby.BabyId'=>$babyid, 'daycare.AdmissionId'=>$admissionid])
            ->orderBy('daycare.DayId', 'asc')
            ->get();


         $results=\SiteHelpers::convert_obj_to_array($results->toArray());
         $results=\SiteHelpers::unique_multidim_array($results, 'DayId');
         $results=\SiteHelpers::convert_array_to_object($results); 
         return $results;

      }
      
   /**
    * FETCH NON DELETED DATA RECORD COUNT
    *
    * @return integer
    */   
    public static function GetTotal() 
    {
        $results = DB::table('daycare')
                        ->select('baby.BabyName', 'baby.BabyId', 'baby.DOB', 'baby.BMrNo', 'daycare.DayDate', 'daycare.AdmissionId', 'daycare.DayId', 'daycare.Care')
                        ->join('baby', 'baby.BabyId', '=', 'daycare.BabyId')
                        ->join('nicu_admission', 'nicu_admission.BabyId', '=', 'daycare.BabyId')
                        ->where(['daycare.IsDeleted'=>0, 'nicu_admission.status'=>'Inpatient', 'nicu_admission.IsDeleted'=>0])
                        ->get()->unique('BabyId');
        // $results = \SiteHelpers::convert_obj_to_array($results->toArray());
        // $results = \SiteHelpers::unique_multidim_array($results, 'BabyId');
        // $results = \SiteHelpers::convert_array_to_object($results);
        return count($results);
    }

}

























