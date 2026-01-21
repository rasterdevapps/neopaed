<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class DrugAndInfusion extends Model
{
   	protected $table = 'mas_drugs_and_insfusion';
	protected $primaryKey = 'Id';
	public $timestamps  =  false;
	protected $fillable = ['Name','Value','Status','UserAdded','UserModified','DateAdded','DateModified','UserDeleted','IsDeleted','generic_name','drug_group_id', 'concept_id'];

    /**
		FETCH RECORDS TO DISPLAY IN THE MASTERS LISTING.
	*/
	public static function  ListData()
	{
		$results = \DB::table('mas_drugs_and_insfusion')
            ->select('*')->where('IsDeleted', '0')
            ->get();		
		return $results;
	}
	/**
	 * get snomed medicine gendric name
	 *
	 * @return type array of object 
	 */
	 public static function getDrugList()
	 {
	 	// return $result = self::get()->unique('generic_name')
	 	// 					 ->pluck('generic_name','concept_id');

	 	return $result = self::get()->pluck('generic_name','concept_id');

	 }

	/**
	 * get snomed medicine brand name
	 *
	 * @param $generic
	 *
	 * @return type array of object 
	 */
	 public static function getBrandList($generic_id)
	 {
	 	return \DB::table('description_f')
	 	           ->whereIn('conceptid',function($query) use ($generic_id){
	 	           	     $query->select('sourceid')
	 	           	           ->from('relationship_f')
	 	           	           ->where('destinationid', $generic_id);
	 	           })
	 	           ->where('typeid', '900000000000003001')
	 	           ->get()->pluck('term','conceptid');
	 }

}
