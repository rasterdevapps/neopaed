<?php namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Drug extends Model 
{

	protected $table = 'mas_drugs';
	protected $primaryKey = 'Id';
	public $timestamps  =  false;
	protected $fillable = ['Name','Value','Status','UserAdded','UserModified','DateAdded','DateModified','UserDeleted','IsDeleted','generic_name','drug_group_id', 'concept_id'];
	/**
		FETCH RECORDS TO DISPLAY IN THE MASTERS LISTING.
	*/
	public static function  ListData()
	{
		$results = DB::table('mas_drugs')
            ->select('*')
            ->get();		
		return $results;
	}

	public static function  list($page = 1, $limit = 50, $condition, $order = array(), $slug = '')
	{
		$limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend   = $limit;
        $search_txt =  isset($condition) ? trim($condition) : '';
        
        $results    = DB::table('mas_drugs')
	                    ->select('*')
	                    ->where('IsDeleted', '0')
	                    ->where(function ($query) use ($search_txt) {
	                        if ($search_txt) {
			                    $query->where('Name', 'ilike', '%'.$search_txt.'%');
			                    $query->orwhere('Status', $search_txt);
			                    $query->orwhere('Value', $search_txt);
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
	/**
		FETCH RECORDS TO DISPLAY IN THE DROPDOWN OF ADMISSION MODULES(Only active records).
	*/
	public static function  get_lists()
	{
		$results = DB::table('mas_drugs')
            ->select('Id', 'Name', 'Value', 'drug_group_id')
            ->where('Status', 'Active')
            ->where('IsDeleted', '0')
            ->get();		
		return $results;
	}
	/**
		get strength values
	*/	
	public static function get_strength_drung($id)
	{

		// $results = self::find($id);
       
  //       if (isset($results->drug_group_id) && !empty($results->drug_group_id)) {

  //       	return DB::table('mas_drugs')
		// 	       ->where('drug_group_id', $results->drug_group_id)
		// 	       ->get();

  //       } 


		return \DB::table('mas_drugivfluid')
		->select('*', 'generic_pharmacological_name as generic_name', 'id as Id', 'value as Value')
		->where('id', $id)
		->get();

        return 0;
	}

    /**
     * This method to get drug & generic name
     */
    public static function getDrugName($id, $name)
    {
      $results = \DB::table('mas_drugs')
               ->select($name)
               ->where('Id', $id)
               ->where('Status', 'Active')
               ->first();
      return $results;
    }
	

}
