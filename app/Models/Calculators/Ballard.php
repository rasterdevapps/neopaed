<?php namespace App\Models\Calculators;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ballard extends Model 
{
	protected $table = 'ballard_score';
	protected $primaryKey = 'BallardId';
	public $timestamps  =  false;
	protected $fillable = ['BabyId','MotherId','AssessmentAge','ArmRecoil','AssessedGestationalAge','Breast','TestDate','Days','Examiner','EyeEar','Genitals','HeelEar','Lanugo','PlantarSurface','PoplitealAngle','Posture','ScarfSign','Skin','SquareWindow','TestTime','NeuromuscularScore','PhysicalScore','TotalScore','Weeks','UserAdded', 'UserDeleted','IsDeleted', 'DateAdded','DateModified'];

	/**
	* USED TO DISPLAY THE BABY INFORMATION AND SCORE INFORMATION IN THE LISTING PAGE
	*/
	public static function  get_lists($page=1, $limit=50, $condition = array(), $order=array(), $slug = '')
	{
		
		$limitstart    = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
		$limitend      = $limit;
		$search_txt    = isset($condition['search_txt']) ? trim($condition['search_txt']) : '';
		$score_check   = is_numeric($search_txt) ? $search_txt : null;

		$results = DB::table('ballard_score')
						->join('baby', 'baby.BabyId', '=', 'ballard_score.BabyId')
						->select('BabyName', 'BMrNo', 'ballard_score.TestDate', 'ballard_score.BallardId', 'ballard_score.TotalScore')
						->where('ballard_score.IsDeleted', 0)
						->where(function ($query) use ($search_txt, $score_check) {
							if ($search_txt) {
								$query->whereRaw('LOWER("BabyName") like '."'%".strtolower($search_txt)."%'");
								$query->orWhereRaw('LOWER("BMrNo") like '."'%".strtolower($search_txt)."%'");
								$query->orwhere('ballard_score.TotalScore', $score_check);
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
	* USED IN THE BALLARD SCORE CREATION.
	*/
	public static function  get_baby($id)
	{
		$results = DB::table('baby')
						->where('BabyId', $id)->get();		
		return $results;
	}
	/**
	* FETCH RECORD FOR THE EDIT FORM OPERATION
	*/
	public static function  get_record($id)
	{
		$results = DB::table('ballard_score')
						->join('baby', 'ballard_score.BabyId', '=', 'baby.BabyId')
						->where('BallardId', $id)->get();		
		return $results;
	}
  
    /**
     * FETCH NON DELETED DATA RECORD COUNT
     *
     * @return integer
     */	
	public static function GetTotal() 
    {
		$result = DB::table('ballard_score')->where('IsDeleted', '0')->get()->count();
		return $result;
	}
}
