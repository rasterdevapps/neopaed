<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Culture extends Model 
{
	protected $table = 'culture_registry';
	protected $primaryKey = 'CultureId';
	public $timestamps  =  false;
	
	protected $fillable = ['AdmissionId','BabyId','CollectionDate','EntryDate','DayOfLife','Specimen','Isolate','Amikacin','AmoxycillinClavulanate','AmpicillinSulbactum','Azithromycin','Cefazolin','Cefepime','Cefotaxime','Cefoxitin','Cefpodoxime','Ceftriaxone','Cefuroxime','Chloramphenicol','Ciprofloxation','Clindamycin','CoTrimoxazole','Doxycycline','Gentamicin','Levofloxacin','Linezolid','Methicillin','Netillin','Ofloxacin','Teicoplanin','Tetracycline','Tobramycin','Vancomycin','Aztreonam','Carbenicillin','Cefaclor','Cefipime','Cefixime','Cefoperazone','Ceftazidime','Faropenem','Meropenem','Imipenem','Ertapenem','PiperacillinTazobactum','Colistin','PolymyxinB','NalidixicAcid','Nitrofurantoin','Norfloxacin','Erythromycin','PenicillinG','Tigecycline','SeenBy','UserAdded','UserModified','DateAdded','DateModified','UserDeleted','IsDeleted'];

	/**
	 * FETCH NON DELETED DATA FOR LISTING WITH SEACRCH AND LIMIT
     *
     * @param $page integer
     * @param $limit integer
     * @param $condition array
     * @param $order array
     * @return array of objects 
	 */
	public static function get_lists($page=1, $limit=50, $condition = array(), $order=array(), $slug = '')
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
		$results = DB::table('culture_registry')
            			->join('baby', 'culture_registry.BabyId', '=', 'baby.BabyId')
            			->select('baby.BabyName', 'baby.BMrNo', 'culture_registry.EntryDate', 'culture_registry.CultureId', 'culture_registry.Specimen', 'culture_registry.Isolate', 'culture_registry.CollectionDate')
            			->where('culture_registry.IsDeleted', 0)
						->where(function ($query) use ($search_txt, $checkdate) {
							if ($search_txt) {
								$query->whereRaw('LOWER("BabyName") like '."'%".strtolower($search_txt)."%'");
								$query->orWhereRaw('LOWER("BMrNo") like '."'%".strtolower($search_txt)."%'");
								$query->orWhereRaw('LOWER("Isolate") like '."'%".strtolower($search_txt)."%'");
								$query->orWhereRaw('LOWER("Specimen") like '."'%".strtolower($search_txt)."%'");
							} elseif ($checkdate) {
	                          	$query->whereRaw('"EntryDate"::date='.$checkdate);
	                        }
						});

		if (isset($order['sortby']) && isset($order['sortorder'])) {
			$results->orderBy($order['sortby'], $order['sortorder']);  
		}
		if ($slug) {
			return $results;
		} else {
			$result = $results->limit($limitend)->offset($limitstart)->get();           
		}

		return $result;
	}

	/**
	 * FETCH THE DATA FOR CULTURE EDIT FORM
	 */		
	public static function  get_record($id)
	{
		$results = DB::table('culture_registry')
            ->join('baby', 'culture_registry.BabyId', '=', 'baby.BabyId')
            ->where('CultureId', $id)->get();		
		return $results;
	}

  /**
   * FETCH NON DELETED DATA RECORD COUNT
   *
   * @return integer
   */	
	public static function GetTotal() 
    {
		$result = DB::table('culture_registry')->where('IsDeleted', 0)->get()->count();
		return $result;
	}

}
