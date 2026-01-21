<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DrugIvFluidMaster extends Model
{
   /**
  * Define the table name
  *
    *@var $table
  */
  protected $table = 'mas_drugivfluid';

  /**
  * Define the table primary key 
  *
    *@var $primaryKey
  */
  protected $primaryKey = 'id';

  /**
  * Define the table timestamps
  *
    *@var $timestamps
  */
  public $timestamps  =  false;

  /**
  * Define the table fillable columns 
  *
    *@var $fillable
  */
  protected $fillable = ['brand_name', 'generic_pharmacological_name', 'value', 'type', 
  'status', 'user_added', 'user_modified', 'date_added', 'date_modified', 'user_deleted',
  'is_deleted', 'dose', 'dose_range', 'dose_units', 'dose_duration', 'quantity', 
  'quantity_units', 'syringe_size', 'rate', 'instruction', 'added_drug', 'added_dose', 
  'dose_alt', 'dose_alt_range', 'frequency', 'route', 'batch_no', 'default_option', 'anti_status', 'usage_type'];


  public static function list($page = 1, $limit = 50, $condition, $order = array(), $slug = '')
  {

    $limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
    $limitend   = $limit;
    $search_txt = isset($condition) ? trim($condition) : '';

    $results    = DB::table('mas_drugivfluid')
    ->select('*', 'mas_drugivfluid.value as drug_value', 'mas_drugivfluid.status as drug_status')
    ->leftjoin('mas_prescription_type', 'mas_prescription_type.value','=','mas_drugivfluid.type')
    ->where('mas_drugivfluid.is_deleted', 0)
    ->where(function ($query) use ($search_txt) {
      if ($search_txt) {
        $query->orWhere('brand_name', 'ilike', '%'.$search_txt.'%');
        $query->orWhere('generic_pharmacological_name', 'ilike', '%'.$search_txt.'%');
        $query->orWhere('mas_drugivfluid.value', 'ilike', '%'.$search_txt.'%');
        $query->orWhere('mas_prescription_type.name', 'ilike', '%'.$search_txt.'%');
      }
    });

    if (isset($order['sortby']) && isset($order['sortorder'])) {
      $results->orderBy($order['sortby'], $order['sortorder']);  
    }

    if ($slug) {
      $result['total']  = $results->get()->count();  
      $result['result'] = $results->limit($limitend)->offset($limitstart)->get(); 
    } else {
      $result = $results->limit($limitend)->offset($limitstart)->get();           
    }

    return $result;
  }

  public static function GetTotal() 
  {
    $results = DB::table('mas_drugivfluid')
    ->where('is_deleted', 0)
    ->get();  

    return count($results);   

  }
  
    /**
     * This method to get drug name
     */
    public static function getDrugName($id)
    {
      $results = \DB::table('mas_drugivfluid')
               ->select('generic_pharmacological_name')
               ->where('id',$id)
               ->first();
      return $results;
    }

    /**
     * This method to get drug name
     */
    public static function getDrugFluidName($id)
    {
      $results = \DB::table('mas_drugivfluid')
               ->select('*')
               ->where('id',$id)
               ->first();
      return $results;
    }

    /**
     * This method to get fluid list as an array
     */
    public static function getFieldvalue()
    {
      $results = \DB::table('mas_drugivfluid')
               ->where(['is_deleted'=>0,'status'=>1])
               ->pluck('brand_name', 'id')->toArray();
      return $results;
    }

    /**
     * This method to get drug list as an array
     */
    public static function getOralDrug()
    {
      $results = \DB::table('mas_drugivfluid')
            ->select('id as Id', 'brand_name as Name', 'generic_pharmacological_name as generic_name', 'value as Value')
               ->where(['is_deleted'=>0, 'status'=>1, 'type'=>'ORAL'])
              ->get();
      return $results;
    }

  public static function ListData()
  {
    $results = DB::table('mas_drugivfluid')
            ->select('*')->where('is_deleted', '0')->where('type', 'ORAL')
            ->get();    
    return $results;
  }

    /**
     * This method to get drug name
     */
    public static function getBrandDrugName($id)
    {
      $results = DB::table('mas_drugivfluid')
               ->selectRaw('mas_drugivfluid.brand_name|| \' / \' ||mas_drugivfluid.generic_pharmacological_name as name')
               // ->select('brand_name as name')
               ->where('id',$id)
               ->first();
      return $results;
    }

    /**
     * This method to get fluid list as an array
     */
    public static function getFluidValue()
    {
      $results = \DB::table('mas_drugivfluid')
               ->select('mas_drugivfluid.*', 'brand_name as name')
               ->where('type', '<>','ORAL')
               ->where(['is_deleted'=>'0','status'=>1])
               ->pluck('name', 'id')->toArray();
      return $results;
    }

    /**
     * This method to get master id.
     */
    public static function getDrugID($meanvalue) {
      return \DB::table('mas_drugivfluid')
              ->select('id')
              ->where('type', '<>','ORAL')
              ->where('brand_name',$meanvalue)
              ->first();
    }

    /**
     * This method to get drugs.
     */
    public static function getDrugsList() {
        // $antibiotic = \DB::table('mas_drugivfluid')
        //     ->select('id', 'generic_pharmacological_name as Name')
        //     ->where('anti_status', 1)
        //     ->where('is_deleted', 0)
        //     ->orderby('id', 'asc')
        //     ->pluck('Name', 'id')
        //     ->toArray();
        $antibiotic = \ValuelistHelpers::getDrugIvFluidsAntibiotic();
        return $antibiotic;
    }

}
