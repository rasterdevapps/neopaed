<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Baby extends Model 
{

	protected $table = 'baby';
	protected $primaryKey = 'BabyId';
	public $timestamps  =  false;
	protected $fillable = ['BabyName','obstetric_consultant','BirthOrder','BirthStatus','BirthWeight','Gestation','Sex','ConfidentialBackgroundDetails','DOB','TOB','Background','BirthCity','BabyBloodGroup','BMrNo','MotherId','UserAdded','DateAdded','DateModified','UserDeleted','IsDeleted','TOB_TIME','TOB_MINS','TOB_AM','MultiplePregnancy','MultiplePregnancyType','neonatal_consultant','paediatric_surgeon','Noofbabies','g_weeks','g_days','Baby_group_id','UserModified', 'allegries'];

  /**
   * This will check babyname, bloodgroup , sex and birthweight is empty 
   *
   * @return array of baby id 
   */
  public static function check_empty()
  {
    return  DB::table('baby')
              ->orwhere('BabyName', null)
              ->orwhere('BabyBloodGroup', 'Not Known')
              ->orwhere('Sex', null)
              ->orwhere('BirthWeight', null)
              ->pluck('BabyId');
  }

  /**
  * This will get the mother & baby details.
  *
  * @param $id integer 
  *
  * @return array of object  mother & baby details. 
  */
	public static function  get_data($id)
  {
		return  DB::table('baby')
              ->select('mother.*', 'baby.*')
              ->leftjoin('mother', 'baby.MotherId', '=', 'mother.MotherId')
              ->where('baby.IsDeleted', '0')
              ->where('baby.BabyId', $id)
              ->get();		
	}

  /**
  * This will get the all the baby details.
  *
  * @return array of object baby details. 
  */
	public static function  ListData()
  {
		return DB::table('baby')
                  ->select('baby.*')
                  ->where('IsDeleted', '0')
                  ->orderBy('BabyId', 'desc')
                  ->get();	
		
	}

    /**
   *This will return the baby's those who has a neonatal performa.
   *
   *@return babylist array of collection object 
   */
  public static function babyListData()
  {

        $results = DB::table('baby')      
            ->select('BabyId', 'BabyName', 'BMrNo')
            ->selectRaw('"baby"."BabyName"|| \' - \' ||"baby"."BMrNo" as baby_name_mrn')
            ->where('baby.IsDeleted', '0')
            ->orderBy('baby.BabyId', 'desc')
            ->get();
         return $results;

  }

  /**
   *This will return the baby's those who not have a neonatal performa.  
   *
   *@return babylist array of collection object 
   */
	public static function  baby_list_neonatal()
  {

  	return DB::table('baby')
              ->select('BabyId', 'BMrNo', 'BabyName')
              ->where('baby.IsDeleted', '0')
              ->whereNotIn('BabyId', function ($baby_list) {
                  $baby_list->select('BabyId')
                            ->from('neonatal_proforma') 
                            ->where('neonatal_proforma.IsDeleted', '0');
              })
              ->orderBy('BabyId', 'desc')
              ->get();	

	}

  /**
   *This will return the baby's those who has a neonatal performa.
   *
   *@return babylist array of collection object 
   */
    public static function baby_list_nicu()
    {

		    $results = DB::table('baby')      
            ->select('baby.BabyId', 'baby.BMrNo', 'baby.BabyName')
            ->join('neonatal_proforma', 'neonatal_proforma.BabyId', '=', 'baby.BabyId')
            ->leftJoin('baby_admission', 'baby_admission.BabyId', '=', 'baby.BabyId')
            ->whereNotIn('baby.BabyId', function ($query) {
                $query->from('baby_admission')
                        ->select('baby_admission.BabyId')
                        ->where('baby_admission.Status', '=', 'Inpatient')
                        ->get()
                        ->toArray();  
            })
            ->where('baby.IsDeleted', '0')
            ->where(function($query){
                $query->where('baby_admission.Status', '!=', 'Inpatient');
                $query->orWhere('baby_admission.Status', '=', '');
                $query->orWhere('baby_admission.Status', '=', NULL);
                $query->orWhereNull('baby_admission.AdmissionId');
            })
            // ->where('baby_admission.Status', '<>', 'Inpatient')
            ->orderBy('BabyId', 'desc')
            ->get();
         $results=\SiteHelpers::convert_obj_to_array($results->toArray());
         $results=\SiteHelpers::unique_multidim_array($results, 'BabyId');
         $results=\SiteHelpers::convert_array_to_object($results);


         return $results ;

	}/**
   *This will return the baby's those who has a neonatal performa.
   *
   *@return babylist array of collection object 
   */
  public static function baby_list_op()
  {

        $results = DB::table('baby')      
            ->select('BabyId', 'BabyName', 'BMrNo')
            // ->leftJoin('baby_admission', 'baby_admission.BabyId', '=', 'baby.BabyId')
            ->where('baby.IsDeleted', '0')
            // ->where(function($query){
            //     $query->where('baby_admission.Status', '!=', 'Inpatient');
            //     $query->orWhere('baby_admission.Status', '=', '');
            //     $query->orWhere('baby_admission.Status', '=', NULL);
            //     $query->orWhereNull('baby_admission.AdmissionId');
            //     // $query->orWhereNotIn('baby.BabyId', function($query) {
            //     //     $query->select('baby_admission.BabyId')
            //     //           ->from('baby_admission');
            //     // });
            // })
            // ->where('baby_admission.Status', '<>', 'Inpatient')
            ->orderBy('baby.BabyId', 'desc')
            ->get();
         // $results=\SiteHelpers::convert_obj_to_array($results->toArray());
         // $results=\SiteHelpers::unique_multidim_array($results, 'BabyId');
         // $results=\SiteHelpers::convert_array_to_object($results);  
         return $results ;

  }
  
  /**
  * This will get the all the baby details to daycare create .
  *
  * @return array of object baby details. 
  */
  public static function baby_list_daycare()
  {
         // $results=DB::table('baby')
         //          ->join('neonatal_proforma', 'neonatal_proforma.BabyId', '=', 'baby.BabyId') 
         //          ->join('nicu_admission', 'nicu_admission.BabyId', '=', 'baby.BabyId')
         //          ->where(['nicu_admission.IsDeleted'=>0, 'nicu_admission.status'=>'Inpatient'])
         //          ->get(); 

          $results = DB::table('baby')
                        ->distinct('BabyId')
                        // ->select('baby.BabyId', 'baby.BabyName', 'baby.BMrNo', 'AdmissionId')
                        ->select('baby.BabyId', 'baby.BabyName', 'baby.BMrNo')
                        ->selectRaw('"baby"."BabyName"|| \' - \' ||"baby"."BMrNo" as baby_name_mrn')
                        ->leftjoin('baby_admission', 'baby_admission.BabyId', '=', 'baby.BabyId') 
                        ->where('baby.IsDeleted', 0)
                        ->orderBy('BabyId', 'desc')
                        ->get();    

         // $results=\SiteHelpers::convert_obj_to_array($results->toArray());
         // $results=\SiteHelpers::unique_multidim_array($results, 'BabyId');
         // $results=\SiteHelpers::convert_array_to_object($results);  

		return $results;
  } /**
  * This will get the all the baby details to daycare create .
  *
  * @return array of object baby details. 
  */
  public static function baby_list_nurse_sheet()
  {
         // $results=DB::table('baby')
         //          ->join('neonatal_proforma', 'neonatal_proforma.BabyId', '=', 'baby.BabyId') 
         //          ->join('nicu_admission', 'nicu_admission.BabyId', '=', 'baby.BabyId')
         //          ->where(['nicu_admission.IsDeleted'=>0, 'nicu_admission.status'=>'Inpatient'])
         //          ->get(); 

          $results = DB::table('baby')
                        ->join('baby_admission', 'baby_admission.BabyId', '=', 'baby.BabyId') 
                        ->join('nicu_admission', 'baby_admission.AdmissionId', '=', 'nicu_admission.AdmissionId')
                        ->where('nicu_admission.status', 'Inpatient') 
                        ->where('baby.IsDeleted', 0)
                        ->get();    
                  

         // $results=\SiteHelpers::convert_obj_to_array($results->toArray());
         // $results=\SiteHelpers::unique_multidim_array($results, 'BabyId');
         // $results=\SiteHelpers::convert_array_to_object($results);  

    return $results;
  }

  /**
  * This will get the all the baby admission list.
  *
  * @param $daycarebabyid integer
  *
  * @return array of object baby details. 
  */
  public static function daycare_eposide_list($daycarebabyid)
  {

    	// $results1=DB::table('daycare')->where('BabyId',$daycarebabyid)->pluck('daycare.AdmissionId');

    	// $results=DB::table('baby_admission')
    	//           ->select('baby_admission.*', 'baby.BabyName','nicu_admission.status as nicu_status', 'NicuId')
    	//           ->join('baby', 'baby.BabyId', '=', 'baby_admission.BabyId')
     //            ->join('nicu_admission', 'nicu_admission.AdmissionId', '=', 'baby_admission.AdmissionId')
     //            ->where('baby.IsDeleted', 0)
     //            ->where('nicu_admission.IsDeleted', 0)
     //            ->where('nicu_admission.status', 'Inpatient')
    	//           ->where('baby_admission.BabyId', $daycarebabyid)
     //            ->get();

        $results=DB::table('baby_admission')
                ->join('baby', 'baby.BabyId', '=', 'baby_admission.BabyId')
                ->where('baby.IsDeleted', 0)
                ->where('baby_admission.BabyId', $daycarebabyid)
                ->get()->unique('AdmissionId');         

         // $results=\SiteHelpers::convert_obj_to_array($results->toArray());
         // $results=\SiteHelpers::unique_multidim_array($results, 'AdmissionId');
         // $results=\SiteHelpers::convert_array_to_object($results);          

    	return $results;
    	         
  }

  /**
  * This will get the all the baby details with sorting,pagenation.
  *
  * @param $page integer
  *
  * @param $limit integer
  *
  * @param $condition array
  *   
  * @param $order array 
  *
  * @return array of object baby details. 
  */
  public static function  ListDatawithSearch($page = 1, $limit = 50, $condition = array(), $order = array(), $slug = '')
  {


        $limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend = $limit;
        $search_txt = isset($condition['search_txt']) ? $condition['search_txt'] : '';
        $checkdate = '';
        $mother_id = '';
      
        if (strpos($search_txt, '-') > 0) {
            $get_date      = strtotime($search_txt);
            $checkdate     = (!empty($get_date)) ? date('\'Y-m-d\'', $get_date):'';
            $search_txt    = '';
        }
        if (is_numeric($search_txt)) {
          $mother_id = $search_txt;
          $search_txt    = '';
        }

        $results = DB::table('baby')
            ->select('baby.*')
            ->where('IsDeleted', '0')
            // ->leftjoin('neonatal_proforma', 'neonatal_proforma.BabyId', '=', 'baby.BabyId')
            // ->where('neonatal_proforma.IsDeleted', '0')
            ->where(function ($query) use ($search_txt, $checkdate, $mother_id)
            {
                if (!empty($search_txt) && empty($checkdate)) {

                    $query->orwhere('BabyName', 'ilike', '%'.trim($search_txt).'%');
                    $query->orwhere('baby.BMrNo', $search_txt);
                    $query->orWhere('Sex', 'ilike', '%'.trim($search_txt).'%');
                    $query->orWhere('BabyBloodGroup', 'ilike', '%'.trim($search_txt).'%');
                }

                if (!empty($checkdate) && empty($search_txt)) {

                    $query->whereRaw('"baby"."DOB"::date='.$checkdate);
                }
                if (!empty($mother_id) && empty($checkdate) && empty($search_txt)) {
                    $query->where('baby.MotherId', $mother_id);
                    $query->orWhere('baby.BMrNo', $mother_id);
                }
            });
            if (isset($order['sortby']) && isset($order['sortorder'])) {
              $results->orderBy($order['sortby'], $order['sortorder']);
            }

      if ($slug) {
        // $result['total'] = $results->get()->unique('BabyId')->count();  
        // $result['result'] = $results->limit($limitend)->offset($limitstart)->get()->unique('BabyId'); 


        $result['total'] = $results->get()->count();  
        $result['result'] = $results->limit($limitend)->offset($limitstart)->get(); 
      } else {
        $result = $results->limit($limitend)->offset($limitstart)->get(); 
      }
      
        return $result;
  }
  /**
  * This will get the all the baby details with sorting,pagenation.
  *
  * @param $page integer
  *
  * @param $limit integer
  *
  * @param $condition array
  *   
  * @param $order array 
  *
  * @return array of object baby details. 
  */
  public static function  ListDatawithSearchAndAdmissionDate($page = 1, $limit = 50, $condition = array(), $order = array(), $slug = '')
  {


        $limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend = $limit;
        $search_txt = isset($condition['search_txt']) ? $condition['search_txt'] : '';
        $checkdate = '';
        $mother_id = '';
      
        if (strpos($search_txt, '-') > 0) {
            $get_date      = strtotime($search_txt);
            $checkdate     = (!empty($get_date)) ? date('\'Y-m-d\'', $get_date):'';
            $search_txt    = '';
        }
        if (is_numeric($search_txt)) {
          $mother_id = $search_txt;
          $search_txt    = '';
        }

        $results = DB::table('baby')
            ->select(\DB::raw('DISTINCT ON("baby"."BabyId") "baby"."BabyId"'),'baby.*', \DB::raw('"emr_log_hdr"."visit_date"::date as sheet_date'), 'emr_log_hdr.admission_id')->where('baby.IsDeleted', '0')
            ->leftjoin('neonatal_proforma', 'neonatal_proforma.BabyId', '=', 'baby.BabyId')
            ->join('emr_log_hdr', 'emr_log_hdr.baby_id', '=', 'baby.BabyId')
            // ->where('neonatal_proforma.IsDeleted', '0')
            ->where(function ($query) use ($search_txt, $checkdate, $mother_id)
            {
                if (!empty($search_txt) && empty($checkdate)) {

                    $query->orwhere('BabyName', 'ilike', '%'.trim($search_txt).'%');
                    $query->orwhere('baby.BMrNo', $search_txt);
                    $query->orWhere('Sex', 'ilike', '%'.trim($search_txt).'%');
                    $query->orWhere('BabyBloodGroup', 'ilike', '%'.trim($search_txt).'%');
                }

                if (!empty($checkdate) && empty($search_txt)) {

                    $query->whereRaw('"baby"."DOB"::date='.$checkdate);
                }
                if (!empty($mother_id) && empty($checkdate) && empty($search_txt)) {
                    $query->where('baby.MotherId', $mother_id);
                    $query->orWhere('baby.BMrNo', $mother_id);
                }
            });
            // if (isset($order['sortby']) && isset($order['sortorder'])) {
            //   $results->orderBy($order['sortby'], $order['sortorder']);
            // }

      if ($slug) {
        // $result['total'] = $results->get()->unique('BabyId')->count();  
        // $result['result'] = $results->limit($limitend)->offset($limitstart)->get()->unique('BabyId'); 


        $result['total'] = $results->get()->unique()->count();  
        $result['result'] = $results->limit($limitend)->offset($limitstart)->get(); 
      } else {
        $result = $results->limit($limitend)->offset($limitstart)->get(); 
      }
      
        return $result;
  }

  /**
  * This will get the number of babies register.
  *
  * @return array of object baby details. 
  */
  public static function GetTotal() 
  {
     $result = DB::table('baby')
                  ->where('baby.IsDeleted', '0')
                  // ->leftjoin('neonatal_proforma', 'neonatal_proforma.BabyId', '=', 'baby.BabyId')
                  // ->where('neonatal_proforma.IsDeleted', '0')
                  ->get()->count();
     return $result;
  }

  /**
  * This will get multiple babies choosen in filter for baby tag printing.
  *   
  * @param $baby_list array 
  *
  * @return array of object baby details. 
  */
  public static function  GetData($baby_list)
  {
  		// $result = DB::table('baby')
    //              ->leftjoin('neonatal_proforma', 'neonatal_proforma.BabyId', '=', 'baby.BabyId')
    //              ->select('baby.BabyName', 'baby.BMrNo', 'baby.DOB','baby.obstetric_consultant', 'baby.neonatal_consultant', 'baby.TOB', 'baby.TOB_TIME', 'baby.TOB_MINS', 'baby.TOB_AM', 'baby.Sex', 'baby.BirthWeight', 'baby.Gestation', 'baby.Gestation', 'neonatal_proforma.ModeOfDelivery')
  		//            ->where('baby.IsDeleted', '0')
    //              ->where('neonatal_proforma.IsDeleted', '0');

                 $result = DB::table('baby')
                 ->select('baby.BabyName', 'baby.BMrNo', 'baby.DOB','baby.obstetric_consultant', 'baby.neonatal_consultant', 'baby.TOB', 'baby.TOB_TIME', 'baby.TOB_MINS', 'baby.TOB_AM', 'baby.Sex', 'baby.BirthWeight', 'baby.Gestation', 'baby.Gestation', 'neonatal_proforma.ModeOfDelivery')
                 ->leftjoin('neonatal_proforma', 'neonatal_proforma.BabyId', '=', 'baby.BabyId')
                 ->where('baby.IsDeleted', '0');
      if ($baby_list) {
  			$result = 	$result->whereIn('baby.BabyId', $baby_list);
      }

  		$results = $result->get();		
  		return $results;
  }	
   
  /**
  * This will search the baby and mother form .
  *   
  * @param $value string  
  *
  * @return array of object baby and mother details. 
  */
  public static function GetSearchDatas($value)
  {
  		 $fillable = ['BabyName', 'BirthOrder', 'BirthStatus', 'BirthWeight', 'Gestation', 'Sex', 'ConfidentialBackgroundDetails', 'DOB', 'TOB', 'Background', 'BirthCity', 'BabyBloodGroup', 'FatherSpokenLanguages', 'MotherSpokenLanguages', 'BMrNo'];
  		
  		$query = DB::table('baby')->join('mother', 'mother.MotherId', '=', 'baby.MotherId')->select('*');
  		
  		foreach ($fillable as $column) {
  		  $query->orWhere($column, 'ilike', '%'.$value.'%');
  		}
  		
  		$models = $query->get();		

  		return $models;
  		
  }

  /**
  * This get the baby with neonatal performa details .
  *   
  * @param $NeonatalId integer  
  *
  * @return array of object baby with neonatal performa details. 
  */
  public static function getBabyadmissionList($NeonatalId)
  {
         return DB::table('baby_admission')
                ->select('baby_admission.*')
                ->join('baby', 'baby.BabyId', '=', 'baby_admission.BabyId')
                ->join('neonatal_proforma', 'neonatal_proforma.BabyId', '=', 'baby_admission.BabyId')
                ->where('neonatal_proforma.NeonatalId', $NeonatalId)
                ->get();


  }

  /**
  * This get the no of mother register count.
  *   
  * @param $MotherId integer  
  *
  * @return integer mother register count. 
  */
  public static function getOldbabies($MotherId)
  {
     return \DB::table('baby')->where('MotherId', $MotherId)->count();
  }
  /*
  * This get the baby id , baby name and baby mr no.
  *
  * @return array of object baby with neonatal performa details. 
  */
  public static function  BabyList($limit, $offset)
  {
        $results = DB::table('baby')
                  ->select('baby.*')
                  ->where('IsDeleted', '0')
                  ->orderBy('BabyId', 'desc')
                  ->offset($offset)
                  ->limit($limit)
                  ->get();    
        return $results;
  }

  /**
  * This method to get baby list for postnatal form
  * @return baby list in array of object 
  */
  public static function getPostnatalBabyList($search = '')
  {
      $results = DB::table('baby')
                ->selectRaw('baby."BabyName" || \' - \' || baby."BMrNo" as baby_name')
                ->addSelect('baby.BabyName', 'baby.BabyId', 'baby.BMrNo')
                ->join('neonatal_proforma', 'neonatal_proforma.BabyId', '=', 'baby.BabyId')
                ->where('neonatal_proforma.IsDeleted', '0')
                ->whereNotNull('baby.BabyName')
                ->whereNotNull('baby.BMrNo')
                ->where('baby.IsDeleted', 0)
                ->whereNotIn('baby.BabyId', function ($query) {

                    $query->from('nicu_admission')
                          ->select('BabyId') 
                          ->where('IsDeleted', 0)
                          ->where('status', '=', 'Inpatient')
                          ->groupby('BabyId')
                          ->get()->toArray();   

                })
                ->whereNotIn('baby.BabyId', function ($query) {

                    $query->from('postnatal_discharge')
                          ->select('postnatal_discharge.BabyId') 
                          ->where('postnatal_discharge.IsDeleted', 0)
                          ->where('postnatal_discharge.discharge_status', '=', 'Inpatient')
                          ->groupby('postnatal_discharge.BabyId')
                          ->get()->toArray();   

                })
                ->orderBy('BabyId', 'desc')
                ->get();
     return $results;           
  }

   /**
  * This method to get baby list for postnatal form
  * @return baby list in array of object 
  */
  public static function getHomeBabyList()
  {
     $results = DB::table('baby')
                ->selectRaw('"BabyName" || \' - \' || "BMrNo" as baby_name')
                ->addSelect('baby.BabyId')
                ->where('IsDeleted', '0')
                ->whereNotNull('BabyName')
                ->whereNotNull('BMrNo')
                ->orderBy('BabyId', 'desc')
                ->pluck('baby_name', 'BabyId')
                ->toArray();

     return $results;           

  }

   /**
   * This Method To Set Relationship Between 
   * baby and baby admission 
   * @return array of object
   */
   public function getBabyAdmisison() 
   {

      return $this->hasMany('App\Models\Admission', 'BabyId', 'BabyId')
                  ->select('AdmissionDate', 'AdmissionTime', 'AdmissionId');

   }

   /**
   * This Method To Set Relationship Between 
   * baby and neonatal performa
   * @return array of object
   */ 
   public function getNeonatal()
   {
       return $this->hasOne('App\Models\Neonatal', 'BabyId', 'BabyId');
   }

   /**
    * This Method to check baby has   
    * a neonatal proforma or op record
    *
    * @param $baby_id
    *
    * @return array of object
    */
    public static function GetBabyDependency($baby_id, $type = 1) 
    {
        if ($type == 1) {
            return \DB::table('baby')
                      ->join('neonatal_proforma', 'neonatal_proforma.BabyId', '=', 'baby.BabyId')
                      ->where('neonatal_proforma.IsDeleted', '0')
                      ->where('baby.BabyId', $baby_id)
                      ->get();

        } elseif ($type == 2) {
            return \DB::table('baby')
                      ->join('op_details','op_details.BabyId', '=', 'baby.BabyId')
                      ->where('op_details.IsDeleted', '0')
                      ->where('baby.BabyId', $baby_id)
                      ->get();
        }
       
    }

    /**
     * This Method to get readmission details
     * 
     * @param $baby_id
     *
     * @return array of object
     */
     public static function GetReadmissionDetails($baby_id)
     {
       return \DB::table('baby')
                 ->select('mother.*', 'baby.*')
                 ->where('baby.BabyId', $baby_id)
                 ->join('mother', 'mother.MotherId', '=', 'baby.MotherId')
                 ->leftjoin('neonatal_proforma', 'neonatal_proforma.BabyId', '=', 'baby.BabyId')
                 ->first();

     }



   
  /**
  * This method used to fetch baby record
  *
  * @param $id
  *
  * @return array of object
  */   
  public static function  get_record($id)
  {
    $results = DB::table('baby')
                ->where('BabyId', $id)
                ->select('BabyName', 'BMrNo')
                ->get();   
    return $results;
  }

  /**
  * This method used to fetch all baby record
  *
  * @return array of object
  */   
  public static function  baby_list()
  {
    $results = DB::table('baby')
                ->select('mother.*', 'baby.*')
                ->leftjoin('mother', 'baby.MotherId', '=', 'mother.MotherId')
                ->leftjoin('delete_approval', 'delete_approval.ModuleId', '=', 'mother.MotherId')
                ->where(function($q) {
                    $q->where('mother.IsDeleted', 0)
                      ->orWhere('delete_approval.Status','Pending');
                })
                ->whereNotNull('MotherName')
                ->selectRaw('"BabyName" || \' - \' || "BMrNo" as baby_name')
                ->orderBy('BabyId', 'desc')
                ->pluck('baby_name', 'BabyId')
                ->toArray();   
    return $results;
  }

  /**
  * This method used to fetch all baby record
  *
  * @return array of object
  */   
  public static function  baby_list_delete()
  {
    $results = DB::table('baby')
                ->select('mother.*', 'baby.*', 'delete_approval.*')
                ->leftjoin('mother', 'baby.MotherId', '=', 'mother.MotherId')
                ->leftjoin('delete_approval', function ($join)
                {
                     $join->on('mother.MotherId', '=', 'delete_approval.ModuleId');
                })
                ->where(function($q) {
                    $q->where('mother.IsDeleted', '<>',1);
                })
                ->whereNotNull('MotherName')
                ->selectRaw('"BabyName" || \' - \' || "BMrNo" as baby_name')
                ->orderBy('BabyId', 'desc')
                ->pluck('baby_name', 'BabyId')
                ->toArray();   
    return $results;
  }

/**
  * This method used to fetch all baby record
  * 
  * @param $baby_id type integer
  *
  * @return array of objects
  */
  public static function baby_delete_approval($baby_id) 
  {
    $results = DB::table('baby')
                ->select('baby.*')
                ->where('BabyId', $baby_id)
                ->get();
    return $results;
  }

/**
  * This method to check whether the mother have more then one baby or not.
  * 
  * @param $id type integer
  *
  * @return array of objects
  */
  public static function multiple_baby_check($id) 
  {
    $results = DB::table('baby')
                    ->join('mother', 'mother.MotherId', '=', 'baby.MotherId')
                    ->where('baby.MotherId', $id)
                    ->get();
    return $results;
  }

  /**
    * This method to get the inpatient
    * 
    * @param $id type integer
    *
    * @return array of objects
    */
    public static function getInpatientBaby($BabyId) 
    {
      $results = DB::table('baby_admission')
                  ->where('BabyId', $BabyId)
                  ->where('Status', 'Inpatient')
                  ->first();
      return $results;
    }

  /**
  * This method to check whether the baby is deleted or not.
  * 
  * @param $id type integer
  *
  * @return array of objects
  */
    public static function baby_delete($id) 
    {
          $results = DB::table('baby')
                      ->leftjoin('delete_approval', 'delete_approval.ModuleId', '=', 'baby.BabyId')
                      ->where(function($query) use ($id) {
                            $query->where('delete_approval.Status', 'Approved')                    
                              ->where('delete_approval.ModuleName', 'Baby Registration')
                              ->where('baby.BabyId', $id);               
                        })
                            ->orderBy('delete_approval.Id','desc')
                            ->first();
            return $results; 
    }
    /**
     * This method get baby admission with ip number
     *
     *@param $baby_mrn
     *
     *@param $baby_ip_number
     */
     public static function getbaby_admission($baby_mrn, $baby_ip_number)
     {
          return $results = DB::table('baby')
                              ->join('ip_numbers','ip_numbers.baby_id', '=', 'baby.BabyId')
                              ->where('baby.BMrNo',$baby_mrn)
                              ->where('ip_number', $baby_ip_number)
                              ->where('IsDeleted', 0)
                              ->first();

     }
    /**
     * This method get babies by mother id
     *
     *@param $id
     */
     public static function getBabiesByMother($id)
     {
          return $results = DB::table('baby')
                              ->where('baby.MotherId',$id)
                              ->where('IsDeleted', 0)
                              ->orderBy('BabyId', 'desc')
                              ->get();

     }/**
  * This will get the all the baby details with sorting,pagenation.
  *
  * @param $page integer
  *
  * @param $limit integer
  *
  * @param $condition array
  *   
  * @param $order array 
  *
  * @return array of object baby details. 
  */
  public static function  ListDataTag($page = 1, $limit = 50, $condition = array(), $order = array(), $slug = '', $hospital_name)
  {


        $limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend = $limit;
        $search_txt = isset($condition['search_txt']) ? $condition['search_txt'] : '';
        $checkdate = '';
        $mother_id = '';
      
        if (strpos($search_txt, '-') > 0) {
            $get_date      = strtotime($search_txt);
            $checkdate     = (!empty($get_date)) ? date('\'Y-m-d\'', $get_date):'';
            $search_txt    = '';
        }
        if (is_numeric($search_txt)) {
          $mother_id = $search_txt;
          $search_txt    = '';
        }
        $results = DB::table('baby')
            ->select('baby.*', 'nicu_admission.hospital_name as nicu_hospital_name', 'postnatal_admission.hospital_name as post_hospital_name', 'pediatric_admission.hospital_name as pediatric_hospital_name')
            ->leftjoin('nicu_admission', function ($join) {
                $join->on('baby.BabyId', '=', 'nicu_admission.BabyId')->where('nicu_admission.IsDeleted', '0');
            })
            ->leftjoin('postnatal_admission', function ($join) {
                $join->on('baby.BabyId', '=', 'postnatal_admission.BabyId')->where('postnatal_admission.IsDeleted', '0');
            })
            ->leftjoin('pediatric_admission', function ($join) {
                $join->on('baby.BabyId', '=', 'pediatric_admission.baby_id')->where('pediatric_admission.is_deleted', 0);
            })
            ->where('baby.IsDeleted', '0')
            ->where(function ($query) use ($search_txt, $checkdate, $mother_id, $hospital_name)
            {
                if (!empty($search_txt) && empty($checkdate)) {
                    $query->orwhere('BabyName', 'ilike', '%'.trim($search_txt).'%');
                    $query->orWhere('Sex', 'ilike', '%'.trim($search_txt).'%');
                    $query->orWhere('BabyBloodGroup', 'ilike', '%'.trim($search_txt).'%');
                }

                if (!empty($checkdate) && empty($search_txt)) {
                    $query->whereRaw('"baby"."DOB"::date='.$checkdate);
                }
                if (!empty($mother_id) && empty($checkdate) && empty($search_txt)) {
                    $query->where('baby.BMrNo', $mother_id);
                }
            })
            ->where(function ($query) use ($search_txt, $checkdate, $mother_id, $hospital_name)
            {
                if (!empty($hospital_name)) {
                    $query->orwhere('nicu_admission.hospital_name', $hospital_name)
                            ->orwhere('postnatal_admission.hospital_name', $hospital_name)
                            ->orwhere('pediatric_admission.hospital_name', $hospital_name);
                }
            });
            if (isset($order['sortby']) && isset($order['sortorder'])) {
              $results->orderBy($order['sortby'], $order['sortorder']);
            }

      if ($slug) {
        // $result['total'] = $results->get()->unique('BabyId')->count();  
        // $result['result'] = $results->limit($limitend)->offset($limitstart)->get()->unique('BabyId'); 


        $result['total'] = $results->get()->count();  
        $result['result'] = $results->limit($limitend)->offset($limitstart)->get(); 
      } else {
        $result = $results->limit($limitend)->offset($limitstart)->get(); 
      }
        return $result;
  }
  
    /**
    * This will get the all the baby admission based on month.
    *
    * @return array of object baby details. 
    */
    public static function comparse_year_wise_count()
    {

        $nicu_admission = \DB::select('SELECT count( DISTINCT ("BabyId")), to_char("AdmissionDate", \'YYYY-MM\') as year_month, to_char("AdmissionDate", \'Mon / YY\') as label, to_char("AdmissionDate", \'YYYY\') as year, to_char("AdmissionDate", \'MM\') as month FROM ( select distinct ON (nicu_admission."BabyId", nicu_admission."BMrNo", nicu_admission."AdmissionDate") nicu_admission."BabyId", nicu_admission."AdmissionDate", baby."BabyName" from nicu_admission JOIN baby ON nicu_admission."BabyId" = baby."BabyId" where nicu_admission."IsDeleted" = \'0\' and baby."BabyName" not like  \'%test%\' and baby."IsDeleted" = \'0\' and nicu_admission."AdmissionDate" >= \'2022-04-01\' ) admisions GROUP BY to_char("AdmissionDate", \'Mon / YY\'), to_char("AdmissionDate", \'YYYY-MM\'), to_char("AdmissionDate", \'YYYY\'), to_char("AdmissionDate", \'MM\') order by year_month asc');

        $results['count'] = 0;
        $results['year'] = [];
        $results['data'] = collect($nicu_admission)->groupBy('month')->map(function($item, $index) use (&$results) {
            $list = $item->pluck('count', 'year')->toArray();
            $list['month'] = (int)$index;
            $results['count'] += array_sum($item->pluck('count')->toArray());
            $results['year'] = array_unique(array_merge($results['year'], $item->pluck('year')->toArray()));
            return $list;
        })->toArray();

        if (count($nicu_admission) > 0) {
            return $results;
        }
        else
        {
            return array();
        }
    }
  
    /**
    * This will get the all the baby admission based on month.
    *
    * @return array of object baby details. 
    */
    public static function comparse_year_wise_count_2()
    {

        $nicu_admission = \DB::select('SELECT count( DISTINCT ("BabyId")), to_char("AdmissionDate", \'YYYY-MM\') as year_month, to_char("AdmissionDate", \'Mon / YY\') as label, to_char("AdmissionDate", \'YYYY\') as year, to_char("AdmissionDate", \'MM\') as month FROM ( select distinct ON (nicu_admission."BabyId", nicu_admission."BMrNo", nicu_admission."AdmissionDate") nicu_admission."BabyId", nicu_admission."AdmissionDate", baby."BabyName" from nicu_admission JOIN baby ON nicu_admission."BabyId" = baby."BabyId" where nicu_admission."IsDeleted" = \'0\' and baby."BabyName" not like  \'%test%\' and baby."IsDeleted" = \'0\' and nicu_admission."AdmissionDate" < \'2022-04-01\' ) admisions GROUP BY to_char("AdmissionDate", \'Mon / YY\'), to_char("AdmissionDate", \'YYYY-MM\'), to_char("AdmissionDate", \'YYYY\'), to_char("AdmissionDate", \'MM\') order by year_month asc');

        $results['count'] = 0;
        $results['year'] = [];
        $results['data'] = collect($nicu_admission)->groupBy('month')->map(function($item, $index) use (&$results) {
            $list = $item->pluck('count', 'year')->toArray();
            $list['month'] = (int)$index;
            $results['count'] += array_sum($item->pluck('count')->toArray());
            $results['year'] = array_unique(array_merge($results['year'], $item->pluck('year')->toArray()));
            return $list;
        })->toArray();

        if (count($nicu_admission) > 0) {
            return $results;
        }
        else
        {
            return array();
        }
    }
  
    /**
    * This will get the all the baby admission based on month.
    *
    * @return array of object baby details. 
    */
    public static function year_wise_count()
    {
        // $baby_registration = \DB::select('SELECT to_char("DateAdded", \'YYYY-MM\') as year_month, to_char("DateAdded", \'Mon / YY\') as month, count(*) FROM baby WHERE "DateAdded" > date_trunc(\'month\', CURRENT_DATE) - INTERVAL \'12 months\' and "IsDeleted" = \'0\' GROUP BY to_char("DateAdded", \'Mon / YY\'), to_char("DateAdded", \'YYYY-MM\') ORDER BY year_month ASC');

        $nicu_admission = \DB::select('SELECT count( DISTINCT ("BabyId")),  to_char("AdmissionDate", \'YYYY-MM\') as year_month, to_char("AdmissionDate", \'Mon / YY\') as month FROM ( select distinct ON (nicu_admission."BabyId", nicu_admission."BMrNo", nicu_admission."AdmissionDate") nicu_admission."BabyId", nicu_admission."AdmissionDate", baby."BabyName" from nicu_admission JOIN baby ON nicu_admission."BabyId" = baby."BabyId" where nicu_admission."IsDeleted" = \'0\' and baby."BabyName" not like  \'%test%\' and baby."IsDeleted" = \'0\' and nicu_admission."AdmissionDate" > date_trunc(\'month\', CURRENT_DATE) - INTERVAL \'14 months\' ) admisions GROUP BY to_char("AdmissionDate", \'Mon / YY\'), to_char("AdmissionDate", \'YYYY-MM\')order by year_month asc');

        if (count($nicu_admission) > 0) {
            return $nicu_admission;
        }
        else
        {
            return array();
        }
    }

    /**
    * This will get the all the baby admission based on various wards.
    *
    * @return array of object baby details. 
    */
    public static function ward_wise_count()
    {
        $results = array();
        $nicu_admission = \DB::select('SELECT COUNT(DISTINCT "nicu_admission"."NicuId") as total_admission FROM nicu_admission LEFT JOIN emr_log_hdr ON "nicu_admission"."AdmissionId" = "emr_log_hdr"."admission_id" WHERE "AdmissionDate" >=  CURRENT_DATE - INTERVAL \'30 days\' and "IsDeleted" = \'0\'');

        if (isset($nicu_admission[0]->total_admission)) {
            $results['nicu'] = $nicu_admission[0]->total_admission;
        }
        else
        {
            $results['nicu'] = 0;
        }

        $postnatal_admission = \DB::select('SELECT count(*) as total_admission FROM postnatal_admission WHERE admission_date >=  CURRENT_DATE - INTERVAL \'30 days\' and "IsDeleted" = \'0\'');

        if (isset($postnatal_admission[0]->total_admission)) {
            $results['postnatal'] = $postnatal_admission[0]->total_admission;
        }
        else
        {
            $results['postnatal'] = 0;
        }

        $neonatal_op_admission = \DB::select('SELECT count(*) as total_admission FROM op_details WHERE "OpDate" >=  CURRENT_DATE - INTERVAL \'30 days\' and "IsDeleted" = \'0\'');

        if (isset($neonatal_op_admission[0]->total_admission)) {
            $results['op'] = $neonatal_op_admission[0]->total_admission;
        }
        else
        {
            $results['op'] = 0;
        }

        $pediatric_op_admission = \DB::select('SELECT count(*) as total_admission FROM op_pediatric_details WHERE "op_date" >=  CURRENT_DATE - INTERVAL \'30 days\' and "is_deleted" = \'0\'');

        if (isset($pediatric_op_admission[0]->total_admission)) {
            $results['op'] += $pediatric_op_admission[0]->total_admission;
        }
        else
        {
            $results['op'] += 0;
        }
        
        $results['total_admission'] = $results['nicu'] + $results['postnatal'] + $results['op'];
        return $results;
    }

  /**
  * This will get the mother & baby details.
  *
  * @param $id integer 
  *
  * @return array of object  mother & baby details. 
  */
  public static function  get_baby_by_mrn($mrn)
  {
    return  DB::table('baby')
              ->leftjoin('mother', 'baby.MotherId', 'mother.MotherId', 'baby.BabyName')
              ->where('baby.IsDeleted', '0')
              ->where('baby.BMrNo', $mrn)
              ->orderBy('BabyId', 'desc')
              ->first();    
  }

  /**
  * This will get the baby id.
  *
  * @param $id integer 
  *
  * @return array of object  mother & baby details. 
  */
  public static function getBabyId($mrn)
  {
    return  DB::table('baby')
                ->select('BabyId')
              ->where('BMrNo', $mrn)
              ->first();    
  }

    /**
   *This will return the baby's those who has a neonatal performa.
   *
   *@return babylist array of collection object 
   */
  public static function babyCustomDetails()
  {

        $results = DB::table('baby')      
            ->select('BabyId', 'BabyName')
            ->selectRaw('"baby"."BMrNo"|| \' [\' ||to_char("DOB", \'DD/MM/YYYY\')||\'] \' as "BMrNo"')
            ->where('baby.IsDeleted', '0')
            ->orderBy('baby.BabyId', 'desc')
            ->get();
         return $results;

  }

}















