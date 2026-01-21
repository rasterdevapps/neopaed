<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Mother extends Model 
{

	protected $table = 'mother';
	protected $primaryKey = 'MotherId';
	public $timestamps  =  false;
	protected $fillable = ['MotherName','partner_occupation_status','UserModified','partner_education_status','MotherLastName','education_status','occupation_status','MotherInitial','MotherTitle','PartnerTitle','PartnerInitial','Email','Address1','Address2','Address3','Address4','Mobile','MotherDOB','City','State','Country','PartnerName','PartnerContact','PartnerDOB','PartnerOccupation','LandLine','Occupation','G_Value','P_Value','L_Value','A_Value','G_sequence','MMrNo','UserAdded','DateAdded','DateModified','UserDeleted','IsDeleted','MothercYear','MotherEmail','PartnerMobile','PartnercYear','PartnerLastName','Postcode','Address5','FatherAddress1','FatherAddress2','MotherBloodGroup','FatherSpokenLanguages','MotherSpokenLanguages'];
  


  /**
  * FETCH NON DELETED DATA FOR LISTING
  *
  *@return array of object
  */
  public static function  ListData() 
  {
        $results = DB::table('mother')
            ->select('MotherId', 'MMrNo', 'MotherName', 'MotherLastName')
            ->where('IsDeleted', '0')
            ->orderBy('MotherId', 'desc')
            ->get();
        return $results;
  }

  /**
	* FETCH NON DELETED DATA FOR LISTING WITH SEACRCH AND LIMIT
  *
  *@param $page integer
  *@param $limit integer
  *@param $condition array
  *@param $order array
  *@return array of objects 
	*/
	public static function ListDatawithSearch($page=1, $limit=50, $condition = array(), $order=array(), $slug = '') 
  {
		
       $limitstart    = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
  		 $limitend      = $limit;
       $search_txt    =  isset($condition['search_txt']) ? trim($condition['search_txt']) : '';
       $contact_check = is_numeric($search_txt) ? $search_txt : '';
       $checkdate     ='';
        if (strpos($search_txt, '-') > 0) {
              $get_date      = strtotime($search_txt);
              $checkdate     = (!empty($get_date)) ? date('\'Y-m-d\'', $get_date):'';
              $search_txt    = '';
        }
		    $results = DB::table('mother')
                    ->select('mother.*')
                    ->where('mother.IsDeleted', '0')
                    ->where(function ($query) use ($search_txt, $contact_check, $checkdate) {
                        if ($search_txt) {
                            $query->whereRaw('LOWER("MotherName") ilike '."'%".strtolower($search_txt)."%'");
                            if ($contact_check) {
                                $query->orWhere('mother.MMrNo', $contact_check);
                                $query->orwhere('mother.Mobile', $contact_check);
                                $query->orwhere('mother.LandLine', $contact_check);
                                $query->orwhere('mother.PartnerMobile', $contact_check);
                             }   
                        } elseif ($checkdate) {
                          $query->whereRaw('"mother"."DateAdded"::date='.$checkdate);
                          $query->orWhereRaw('"mother"."DateModified"::date='.$checkdate);
                        }

                    });

           if (isset($order['sortby']) && isset($order['sortorder'])) {
                    $results->orderBy('mother.'.$order['sortby'], $order['sortorder']);  
            }
            $results->groupBy('mother.MotherId');  

        if ($slug) {
          $result['total'] = $results->get()->count();  
          $result['result'] = $results->limit($limitend)->offset($limitstart)->get(); 
        } else {
          $result = $results->limit($limitend)->offset($limitstart)->get();           
        }

          
     return $result;
  }

  /**
  * FETCH NON DELETED DATA RECORD COUNT
  *
  *@return integer
  */	
	public static function GetTotal() 
  {
		$result = DB::table('mother')->where('IsDeleted', '0')->get()->count();
		return $result;
	}

  /**
  * FETCH NON DELETED DATA BASED ON MOTHER ID 
  *
  *@param $mother_id_list array
  *@return array of objects 
  */
  public static function GetData($mother_id_list) 
  {
        $result = Mother::select('*');

        if ($mother_id_list) {
            $result = 	$result->where('MotherId', $mother_id_list);

        }    

        $results = $result->get();
        return $results;
  }
	/**
	* FETCH DATA FOR SEARCH FORM RESULTS
	*/		
	public static function GetSearchDatas($value) 
  {
		$fillable = ['MotherName','Email','Address1','Address2','Address3','Address4','Mobile','MotherDOB','City','State','Country','PartnerName','PartnerContact','PartnerDOB','PartnerOccupation','LandLine','Occupation','MMrNo','MotherTitle','MotherInitial','PartnerInitial'];
		$query = Mother::select('*');
		foreach ($fillable as $column) {
		  $query->orWhere($column, 'ilike', '%'.$value.'%');
		}
		$models = $query->get();		
		return $models;
	}

  /**
   * This Method to check mother has baby
   * 
   * @param $mother_id type integer
   *
   * @return array of objects
   */
  public static function GetMotherDependency($mother_id) 
  {
     return DB::table('baby')
               ->where('MotherId', $mother_id)
               ->where('IsDeleted', 0)
               ->get();
  }

  /**
   * This method used to fetch all mother record
   * 
   * @param $id type integer
   *
   * @return array of objects
   */  
  public static function mother_delete_approval($id)
  {
    $results = DB::table('mother')
                ->select('MotherId', 'MotherName')
                ->where('MotherId', $id)
                ->get();  
    return $results;
  }

}
