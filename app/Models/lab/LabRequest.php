<?php

namespace App\Models\lab;

use Illuminate\Database\Eloquent\Model;

class LabRequest extends Model
{
    protected  $table       = 'lab_request';
	protected  $primaryKey  = 'id';
	public     $timestamps  =  false;
	protected  $fillable = ['baby_id','department','collection_site','collection_method','test_date',
	                       'symptoms','diagnosis', 'credit', 'stat', 'scheduled', 'scheduled_date',
                         'scheduled_time','scheduled_mins','scheduled_sesstion', 'order_physician', 
                         'investigations', 'procedure_name', 'admission_time', 'admissiontime_mins', 
                         'admissiontime_sesstion', 'is_send', 'IsDeleted', 'associate_doctor', 
                         'is_send_mirth', 'is_processed', 'request_id'];
 
    /**
     * This method to get lab request
     * 
     * @param $page type integer
     * @param $limit type integer
     * @param $conditon type array
     * @param $order type array
     *
     */
    public static function getList($page=1, $limit=50, $condition, $order=array(), $slug = '')
    {
        $limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend = $limit;
        $search_txt = isset($search_txt) ? $search_txt : '';
 
        $checkdate     ='';
        if (strpos($search_txt, '-') > 0) {
            $get_date      = strtotime($search_txt);
            $checkdate     = (!empty($get_date)) ? date('\'Y-m-d\'', $get_date):'';
            $search_txt    = '';
        }

    	$results = \DB::table('lab_request')
    	             ->join('baby', 'baby.BabyId', '=', 'lab_request.baby_id')
                     ->where(function ($query) use ($search_txt, $checkdate)
                        {
                            if (!empty($search_txt) && empty($checkdate)) {

                                $query->orwhere('BabyName', 'like', '%'.trim($search_txt).'%');
                                $query->orwhere('BMrNo', $search_txt);
                                $query->orWhere('Sex', 'like', '%'.trim($search_txt).'%');
                            }

                            if (!empty($checkdate) && empty($search_txt)) {

                                $query->whereRaw('"baby"."DOB"::date='.$checkdate);
                                $query->orwhereRaw('"lab_request"."test_date"::date='.$checkdate);

                            }



                        })
                     ->where('lab_request.IsDeleted', false);

        if (isset($order['sortby']) && isset($order['sortorder'])) {
            $results->orderBy($order['sortby'], $order['sortorder']); 
        }

        if ($slug) {
          $result['total'] = $results->get()->count();  
          $result['result'] = $results->limit($limitend)->offset($limitstart)->get(); 
        } else {
          $result = $results->limit($limitend)->offset($limitstart)->get();           
        }

    	return $result;             
    }
    /**
     * This method to get total 
     * number of records
     *  
     *
     */
    public static function GetTotal()
    {
        $result =  \DB::table('lab_request')
                      ->join('baby', 'baby.BabyId', '=', 'lab_request.baby_id')
                      ->where('lab_request.IsDeleted', false)
                      ->get();
       return count($result);               
    }

    /**
     * To get data to hms applciation 
     *
     * @return array of object 
     */
    public static function getLabReocrd()
    {
        return \DB::table('lab_request')
                   ->join('baby', 'baby.BabyId', '=', 'lab_request.baby_id')
                   ->where('lab_request.is_send', false)
                   ->orderby('lab_request.id', 'desc')
                   ->first();
    }

    /**
     * This method to get an lab request
     * record
     *
     * @param type $id 
     */
     public static function get_record($id)
     {
        return \DB::table('lab_request')
                  ->where('id',$id)
                  ->get();

     } 

     /**
      * This method to get ip number
      *
      * @param $baby_id
      */
     public static function getVisitNumber($baby_id) 
     {
       $result =  \DB::table('ip_numbers')
                    ->where('baby_id', $baby_id)
                    ->get();
       return $result->last();
     }

     /**
      * This method to get admission id 
      * 
      * @param $baby_id
      */
     public static function getAdmissionNumber($baby_id)
     {
        $result = \DB::table('baby_admission')
                      ->where('BabyId', $baby_id)
                      ->get();
        return $result->last();              

     }
     /**
      * This method to get ip number  
      * 
      * @param $baby_id
      */
      public static function getIpnumberLabRequest()
      {
          return \DB::table('lab_request')
                    ->join('ip_numbers', 'ip_numbers.baby_id', '=', 'lab_request.baby_id')
                    ->where('is_send_mirth', false)
                    ->where('ip_numbers.ip_number', '<>', '')
                    ->where('lab_request.IsDeleted', false)
                    ->get();
      }

     /**
      * This method to get ip number  
      * 
      * @param $baby_id
      */
      public static function getIpNumber($ip_number)
      {
          return \DB::table('ip_numbers')
                    ->select('baby_id')
                    ->where('ip_number', $ip_number)
                    ->orderby('id', 'desc')
                    ->first();
      }

      /**
      * This method to update the lan request table
      * 
      * @param $baby_id type integer
      *
      * @param $lab_request type array
      */
      public static function updateLabData($baby_id, $lab_request)
      {
          \DB::table('lab_request')
             ->where('baby_id', $baby_id)
             ->update($lab_request);

      }

    /**
     * To get deleted lab request - ip number
     *
     * @return array of object 
     */
    public static function getLabDeletedRecord()
    {
        return \DB::table('lab_request')
                  ->select('ip_number')
                  ->join('ip_numbers', 'ip_numbers.baby_id', '=', 'lab_request.baby_id')
                  ->where('lab_request.IsDeleted', true)
                  ->where('lab_request.is_processed', true)
                  ->orderby('lab_request.id', 'desc')
                  ->get();
    }



}
