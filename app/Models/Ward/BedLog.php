<?php

namespace App\Models\Ward;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class BedLog extends Model
{
 protected $table      = 'patient_bed_log';
 protected $primaryKey = 'id';
 public    $timestamps    =  false;
 protected $fillable   = ['ward_id','ward_name','room_id','room_no','bed_no', 'bed_id','InOrOut','baby_id',
 'admission_id','DateAdded','UserAdded','DateModified','UserModified',
 'IsDeleted','is_syringe_pump_connected','is_infusion_pump_connected', 'is_monitor_connected',
 'is_ventilator_connected','status'];
   /**
    * This method to get 
    * not bed allocated baby
    *
    * need to change the join in final testing pharse 
    */
   public static function bedlog_unallocated_baby() 
   {
     $result =  \DB::table('baby')
     ->join('baby_admission', 'baby_admission.BabyId', '=', 'baby.BabyId')
     ->leftjoin('patient_bed_log','patient_bed_log.baby_id', '=','baby.BabyId')
    	               // ->whereIn('baby.BabyId', function($query) 
                    //    {
                    //         $query->select('baby_id')->from('patient_bed_log')
                    //               ->whereNull('status')
                    //               ->orwhere('status','!=' ,'Occupied');
                    //     })
     ->whereNull('patient_bed_log.status')
     ->orwhere('patient_bed_log.status','!=' ,'Occupied')
     ->get();
     return $result;
   }

    /**
     * This method to get baby bed log
     *
     * @param $admission_id type integer
     * @param $baby_id type integer
     * @return array of object  
     */
    public static function getBedDeatails($baby_id, $admission_id)
    {
     return self::where('admission_id', $admission_id)
     ->addSelect('bed.pump_type', 'patient_bed_log.bed_id','patient_bed_log.room_no','patient_bed_log.bed_no')
     ->join('bed', 'bed.id', '=', 'patient_bed_log.bed_id')
     ->where('baby_id', $baby_id)
                  //->where('status', 'Occupied')
     ->orderby('patient_bed_log.id', 'desc')
     ->first();

   }

   
   public static function  ListDatawithSearch($page = 1, $limit = 50, $condition, $order = array())
   {

    $limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
    $limitend = $limit;
    $search_txt = isset($condition) ? $condition : '';
    $checkdate = '';

    
    if (strpos($search_txt, '-') > 0) {
      $get_date      = strtotime($search_txt);
      $checkdate     = (!empty($get_date)) ? date('\'Y-m-d\'', $get_date):'';
      $search_txt    = '';
    }

    $results = DB::table( DB::raw("(SELECT DISTINCT ON (baby_id) id,baby_id,ward_name,room_no, bed_no, status FROM patient_bed_log Where status = 'discharged' ORDER BY baby_id desc) as bed_log"))
    ->join('baby','baby.BabyId','=','bed_log.baby_id')
    ->select('baby.BabyName', 'baby.BMrNo', 'baby.Sex', 'baby.DOB', 'baby.BabyBloodGroup', 'bed_log.baby_id', 'bed_log.ward_name', 'bed_log.room_no', 'bed_log.bed_no', 'bed_log.status', 'bed_log.id')
    ->where('baby.IsDeleted', '0')
    ->where(function ($query) use ($search_txt, $checkdate)
    {
      if (!empty($search_txt) && empty($checkdate)) {
        $query->orwhere('baby.BabyName', 'like', '%'.trim($search_txt).'%');
        $query->orWhere('baby.BMrNo', 'like', '%'.trim($search_txt).'%');
        $query->orWhere('baby.Sex', 'like', '%'.trim($search_txt).'%');
        $query->orWhere('baby.BabyBloodGroup', 'like', '%'.trim($search_txt).'%');
      }

      if (!empty($checkdate) && empty($search_txt)) {
        $query->whereRaw('"baby"."DOB"::date='.$checkdate);
      }
    });

    if (isset($order['sortby']) && isset($order['sortorder'])) {
      if($order['sortby'] == "room_no") {
        $order = "CAST(room_no AS INTEGER)" . $order['sortorder'];
        $results->orderByRaw($order);
      } else if($order['sortby'] == "bed_no") {
        $order = "CAST(bed_no AS INTEGER)" . $order['sortorder'];
        $results->orderByRaw($order);
      } else {
        $results->orderBy($order['sortby'], $order['sortorder']);            
      }
    }

    $result['total'] = $results->get()->count();  
    
    $result['result'] = $results->limit($limitend)->offset($limitstart)->get(); 

    return $result;
  }

   /**
  * This will get the number of babies register.
  *
  * @return array of object baby details. 
  */
   public static function GetTotal() 
   {
     $result = DB::table('patient_bed_log')->where('IsDeleted', '0')->get()->count();
     return $result;
   }
  /**
   *This method to get patient bed log 
   * based on id  
   *
   * @param 
   */
  public static function getPatinetLog($id)
  {
    return DB::table('patient_bed_log')
    ->join('baby','baby.BabyId','=','patient_bed_log.baby_id')
    ->where('patient_bed_log.id',$id)
    ->first();

  }

   /**
   *This method to get patient bed log 
   * based on id  
   *
   * @param 
   */
   public static function getPatientBedLog($baby_id, $admisssion_id)
   {
    return \DB::table('patient_bed_log')
    ->where('baby_id', $baby_id)
    ->where('admission_id', $admisssion_id)
    ->first();
  }

   /**
  * This will get the number of babies register.
  *
  * @return array of object baby details. 
  */
   public static function GetTotals() 
   {
     // $result = DB::table('patient_bed_log')
     //              ->join('baby','baby.BabyId','=','patient_bed_log.baby_id')
     //              ->where('baby.IsDeleted', '0')
     //              ->get()
     //              ->unique('BabyName')
     //              ->count();
    $result = DB::table('patient_bed_log')
    ->join('baby','baby.BabyId','=','patient_bed_log.baby_id')
    ->where('baby.IsDeleted', '0')
    ->get()
    ->count();

    return $result;
  }

  /**
   *This method to get patient bed log 
   * based on id  
   *
   * @param 
   */
  public static function isPatientExists($id)
  {
    return DB::table('patient_bed_log')
    ->where('patient_bed_log.baby_id', $id)
    ->get();

  }
  
  public static function getMachineStatus($baby_id, $admission_id, $start_time, $end_time)
  {
    $start_time    = $start_time->subMinute(90)->format('Y-m-d H:i:s');
    $end_time      = $end_time->format('Y-m-d H:i:s');
    
    $prescription_key_id =  \SiteHelpers::prescriptionKeyId();

    $result['infusion_status'] = \DB::table('prescription_dtl')
    ->select('prescription_dtl.id')
    ->leftjoin('prescription_hdr', 'prescription_hdr.id', 'prescription_dtl.pres_hdr_id')
    ->where('prescription_hdr.baby_id', $baby_id)
    ->where('is_send', 5)
    ->first();

    if (isset($result['infusion_status']->id)) {
      $result['infusion_status'] = 'active';      
    } else {
      $result['infusion_status'] = '';
    }  
    
    $result['pump_status'] = \DB::table('syringe_pump_admisson')
    ->where('baby_id', $baby_id)
    ->orderBy('id', 'desc')
    ->first();

    if (isset($result['pump_status']->admission_stauts) && ($result['pump_status']->admission_stauts == '0' || $result['pump_status']->admission_stauts == '1')) {
      $result['pump_status'] = 'active';      
    } else {
      $result['pump_status'] = 'inactive';
    }

    $results = \DB::table('emr_log_hdr')
    ->where('baby_id', $baby_id)
    ->pluck('id')->toArray();

    $result['monitor'] =  \DB::table('emr_moniter_values')
    ->whereIn('log_hdr_id', $results)
    ->whereBetween('result_date_time', array($start_time, $end_time))
    ->where('create_user_id', 2)
    ->orderBy('id', 'desc')                         
    ->first();
    $result['monitor'] = count($result['monitor']) > 0 ? 'active' : 'inactive';

    $result['ventilator'] =  \DB::table('emr_ventilator_values')
    ->whereIn('log_hdr_id', $results)
    ->whereBetween('result_date_time', array($start_time, $end_time))
    ->orderBy('id', 'desc')
    ->where('create_user_id', 3)
    ->first();
    $result['ventilator'] = count($result['ventilator']) > 0 ?'active' : 'inactive';

    return $result;
  }

  public static function getPatientStatus($baby_mrn) {
    $result = \DB::table('baby')
    ->leftjoin('patient_bed_log', 'baby.BabyId', 'patient_bed_log.baby_id')
    ->leftjoin('mother', 'baby.MotherId', 'mother.MotherId')
    ->where('baby.BMrNo', $baby_mrn)
    ->orderBy('patient_bed_log.id', 'desc')
    ->first();
    return $result;
  }


  public static function getDeviceStatus($admission_ids, $table_name)
  {
    return \DB::table($table_name)->selectRaw("min(".$table_name.".id) as id, emr_log_hdr.admission_id")
              ->join('emr_log_hdr', 'emr_log_hdr.id', '=', $table_name.'.log_hdr_id')
              ->whereIn('admission_id', $admission_ids)
              ->whereRaw($table_name.".result_date_time > NOW() - INTERVAL '90 minutes'")
              ->whereIn($table_name.'.create_user_id', ['2', '3'])
              ->groupBy('admission_id')
              ->get()
              ->pluck('id', 'admission_id')
              ->toArray();
  }

  public static function getPumpAdmissionStatus($admission_ids)
  {
    return \DB::table('syringe_pump_admisson')->selectRaw("distinct on (id) id, admission_id, admission_stauts")
              ->whereIn('admission_id', $admission_ids)
              ->orderBy('id', 'ASC')
              ->get()
              ->pluck('admission_stauts', 'admission_id')
              ->toArray();
  }

  public static function getPumpRunningStatus($admission_ids)
  {
    return \DB::table('prescription_dtl')
            ->select('prescription_dtl.id AS id', 'admission_id')
            ->leftjoin('prescription_hdr', 'prescription_hdr.id', 'prescription_dtl.pres_hdr_id')
            ->whereIn('prescription_hdr.admission_id', $admission_ids)
            ->where('is_send', 5)
            ->get()
            ->pluck('id', 'admission_id')
            ->toArray();
  }

  public static function getBedDetails($admission_id)
    {
     $results = self::select('patient_bed_log.baby_id', 'patient_bed_log.admission_id', 'ward_name', 'patient_bed_log.ward_id', 'patient_bed_log.room_id', 'room.number', 'bed_id', 'bed_no', 'hms_ward_id', 'hms_room_id', 'hms_bed_id', 'BMrNo', 'ip_number', 'BabyName', 'DOB as dob', 'Sex')
     ->leftjoin('baby', 'baby.BabyId', '=', 'patient_bed_log.baby_id')
     ->leftjoin('ip_numbers', 'ip_numbers.AdmissionId', '=', 'patient_bed_log.admission_id')
     ->leftjoin('bed', 'bed.id', '=', 'patient_bed_log.bed_id')
     ->leftjoin('room', 'room.id', '=', 'bed.room_id')
     ->leftjoin('ward', 'ward.id', '=', 'room.ward_id')
     ->where('admission_id', $admission_id)
     ->orderby('patient_bed_log.id', 'desc')
     ->first();

     if (isset($results->bed_id)) {
      return $results->toArray();
    } else {
      return [];
    }

   }
   public static function getNicuInpatientBabyList(){
    return \DB::table('patient_bed_log')
        ->join('baby', 'patient_bed_log.baby_id', '=', 'baby.BabyId')
        ->join('ip_numbers', 'patient_bed_log.baby_id', '=', 'ip_numbers.baby_id')
        ->select(
            'BMrNo as uhid',
            'ip_number as visitNumber',
            'BabyName as babyName',
            'Sex as gender',
            'DOB as birthDate',
            'room_no as roomNo',
            'bed_no as bedNo'
        )
        ->selectRaw("
            CASE 
                WHEN g_weeks IS NOT NULL 
                THEN CONCAT(g_weeks, ' + ', COALESCE(g_days, 0)) 
                ELSE NULL 
            END as gestation
        ")
        ->where('patient_bed_log.status', 'Occupied')
        ->distinct()
        ->orderBy('bed_no', 'asc')
        ->get();
   }

}
