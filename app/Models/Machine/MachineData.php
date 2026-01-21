<?php

namespace App\Models\Machine;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Fhir\FhirFormateController;
use App\Events\FhirParseEvent;

class MachineData extends Model
{
	protected $table      = 'interface_machine';
	protected $primaryKey = 'id';
	public $timestamps    =  false;
	protected $fillable   = ['received', 'received_time', 'is_parsed', 'received_ip', 'received_date', 'device_type', 'is_lab_value'];

 //    public static function boot() {

	//     parent::boot();

	//     static::created(function($machine_data) {
 //          $fhir_formate = new FhirFormateController($machine_data);
	//       event(new FhirParseEvent($fhir_formate));


	//     });
	// }

	/**
	 * This get list of interface machine 
	 *
	 * @param $limit type number 
	 * 
	 * @return array of object list 
	 */
	public static function get_list($page=1, $limit=50, $search_txt, $order=array()) 
    {
		$limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend = $limit;
		$search_txt = isset($search_txt) ? $search_txt : '';
        $checkdate = '';
      
        if (strpos($search_txt, '-') > 0) {
          	if (preg_match('/^(\d{2})-(\d{2})-(\d{4})$/', date('d-m-Y', strtotime($search_txt)))) {
	            $get_date      = strtotime($search_txt);
	            $checkdate     = (!empty($get_date)) ? date('\'Y-m-d\'', $get_date):'';
	            $search_txt    = '';
	        }
        }

		$results = \DB::table('interface_machine')
						->select('*')
						->where(function ($query) use ($search_txt, $checkdate)
		            	{
			                if (!empty($search_txt) && empty($checkdate)) {
			                	$query->whereRaw('trim("received_ip") like '."'%".trim($search_txt)."%'");
							}
							if (!empty($checkdate) && empty($search_txt)) {
			                	$query->whereRaw('"received_date"::date='.$checkdate);
			               	}
						});

		if (isset($order['sortby']) && isset($order['sortorder'])) {
            $results->orderBy($order['sortby'], $order['sortorder']);
        }
        $result['total']  = $results->get()->count();  
        $result['result'] = $results->limit($limitend)->offset($limitstart)->get(); 
		return $result;
	}

	/**
	 * This get find particular id 
	 *
	 * @param $id type integer
	 *
	 */
	public static function get_record($id)
	{
		return \DB::table('interface_machine')
		          ->selectRaw('jsonb_pretty(received) as received')
		          ->addSelect('id', 'received_time', 'is_parsed', 'received_ip', 'received_date')
		          ->where('id', $id)
		          ->first();

	}

	/**
     * Get The total records count 
     * 
     * @return list count
     */
	public static function getTotal() {
		return \DB::table('interface_machine')->get()->count();
	}



}
