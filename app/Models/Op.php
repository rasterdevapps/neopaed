<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Search\SearchQueryLog;


class Op extends Model 
{
	protected $table = 'op_details';
	protected $primaryKey = 'OpId';
	public $timestamps  =  false;
	
	protected $fillable = ['BMrNo','AdmissionId','BabyId','Advice','AllergyHistory','mother_blood_group',
	                      'AppointmentType','Complaints','CurrentLength','CurrentOFC','CurrentWt','Development',
	                      'Diagnosis','Examination','FamilyHistory','HPI','Immunization','Outcome','Review',
	                      'Schedule','TreatmentHistory','OpDate','OpTime','Vaccine','SeenBy','UserAdded','DateAdded',
	                      'DateModified','UserDeleted','IsDeleted','OpTime_AM','OpTime_MINS','HeadCircumference',
	                      'review_time','review_session','review_min','chronological_days','chronological_month',
	                      'chronological_weeks','chronological_year','corrected_days','corrected_month','corrected_weeks',
	                      'corrected_year','op_visite','total_chronological_weeks','total_chronological_days',
	                      'total_corrected_weeks','total_corrected_days','baby_background',
	                       'neurosonogram','neurosonogram_report','echocardiogram','fee_reason','echocardiogram_report',
	                       'fee_status','fee_amount','nextreviewindication', 'investigations', 'hospital_name', 'edited', 
	                       'edited_content', 'edited_time', 'screening_exist', 'assessment_exist', 'visit_number', 'need_neuro'];

	/** 
	 *get main baby
	 *
	 *@param $page integer
	 *@param $limit integer
	 *@param $condition array
	 *@return array of object 
	 */
	public static function get_lists($page = 1, $limit = 50, $condition = array(), $order = array(), $slug = '')
	{
        $limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend   = $limit;
        $search_txt = isset($condition['search_txt']) ? $condition['search_txt'] : '';         

		$results     = DB::table('op_details')
			            ->join('baby', 'op_details.BabyId', '=', 'baby.BabyId')
			            ->select('op_details.BabyId', 'baby.BabyName', 'baby.BMrNo', 'baby.DOB', 'op_details.OpId','op_details.OpDate','op_details.SeenBy')
			            ->where('op_details.IsDeleted', 0)
			            ->where('baby.IsDeleted', 0)
			            ->where(function ($query) use ($search_txt)
			            {

			                if ($search_txt) {

			                	if (empty(preg_replace('/[0-9]/', '', trim($search_txt)))) {

                                   $query->where('baby.BMrNo', '=', $search_txt);

                                } elseif (empty(preg_replace('/[0-9,-]/', '', trim($search_txt)))) {  

                                    $query->whereDate('baby.DOB', '=', date('Y-m-d', strtotime($search_txt)));
			                	} else {

			                		$query->where('baby.BabyName', 'ilike', '%'.$search_txt.'%');
			                	}

			                }			  

			            });
           if (isset($order['sortby']) && isset($order['sortorder'])) {
                $results->orderBy($order['sortby'], $order['sortorder']);  
            }

		// $results   = $results->orderBy('op_details.DateModified', 'desc');

        if ($slug) {
			$result['total']  = $results->get()->count();  
	        $result['result'] = $results->limit($limitend)->offset($limitstart)->get();
			// $result['result'] = \SiteHelpers::convert_obj_to_array($result['result']->toArray());
			// $result['result'] = \SiteHelpers::unique_multidim_array($result['result'], 'BabyId');
			// $result['result'] = \SiteHelpers::convert_array_to_object($result['result']);  
        } else {
	        $result = $results->limit($limitend)->offset($limitstart)->get();
			// $result = \SiteHelpers::convert_obj_to_array($result->toArray());
			// $result = \SiteHelpers::unique_multidim_array($result, 'BabyId');
			// $result = \SiteHelpers::convert_array_to_object($result);  
		}

		return $result;
	}

	/**
	*To get latest 5 record of op list for dashboard list
	*
	*@return op list in array of objects
	*/
	public static function GetDashboardList() 
	{

		return DB::table('op_details')
		       ->select('baby.BabyName', 'op_details.op_visite', 'baby.BMrNo', 'op_details.OpDate', 'op_details.OpId')
		   	   ->join('baby', 'op_details.BabyId', '=', 'baby.BabyId')
               ->where(['op_details.IsDeleted'=>0])
               ->orderBy('OpId', 'desc')
               ->take(5)
               ->get();

	}

	/**
	*To get op visit list based on baby id 
	*
	*@param $baby_id integer
	*@return op list in array of objects
	*/
	public static function GetOpvisitList($baby_id) 
	{

		return DB::table('op_details')
		       ->select('baby.BabyName', 'op_details.op_visite', 'baby.BMrNo', 'op_details.OpDate', 'op_details.OpDate as visit_date', 'op_details.OpId', 'op_details.edited', 'op_details.SeenBy', 'visit_number')
   			   ->addSelect(\DB::raw("'neonatal' as type"))
		   	   ->join('baby', 'op_details.BabyId', '=', 'baby.BabyId')
               ->where(['op_details.IsDeleted'=>0,'op_details.BabyId'=>$baby_id])
               ->orderBy('op_details.OpId', 'desc')
               ->get();


	}

	/**
	*To get op list count 
	*
	*@param $baby_id integer
	*@return op list count in integer
	*/

    public static function GetTotal() 
    {

        return  DB::table('op_details')
	            ->join('baby', 'op_details.BabyId', '=', 'baby.BabyId')
	            ->select('baby.BabyName', 'op_details.BMrNo', 'op_details.OpDate', 'op_details.OpId')
	            ->where('op_details.IsDeleted', 0)
	            ->get()->count();

    }

    /**
	*To get op record based on op id 
	*
	*@param id  integer
	*@return op record in array of objects
	*/


	public static function  get_oprecord($id) 
	{

		$results = DB::table('op_details')
            ->join('baby', 'op_details.BabyId', '=', 'baby.BabyId')
            ->join('mother', 'mother.MotherId', '=', 'baby.MotherId')
            ->where('OpId', $id)
            ->get();		
		return $results;

	}

	/**
	*To get This for search  
	*
	*@param baby_id integer
	*@return neonatal in array of object 
	*/
	public static function GetSearchDatas($value)
	{

		 $fillable = ['Advice','AllergyHistory','AppointmentType','Complaints','CurrentLength','CurrentOFC','CurrentWt','Development','Diagnosis','Examination','FamilyHistory','HPI','Immunization','Outcome','Review','Schedule','TreatmentHistory','OpDate','OpTime','Vaccine'];
		
		$query = DB::table('op_details')->join('baby', 'op_details.BabyId', '=', 'baby.BabyId')->select('*');
		
		foreach ($fillable as $column) {
		  $query->orWhere($column, 'like', '%'.$value.'%');
		}
		
		$models = $query->get();		

		return $models;
		
	}

	/**
	*To Get neonatal  list 
	*
	*@param baby_id integer
	*@return neonatal in array of object 
	*/
	public static function GetBabyNeonatalList($baby_id) 
	{

		return \DB::table('baby')
		        ->join('mother', 'mother.MotherId', '=', 'baby.MotherId')
		      //  ->leftjoin('neonatal_proforma','neonatal_proforma.BabyId','=','baby.BabyId')
		        ->where(['baby.IsDeleted'=>0, 'baby.BabyId'=>$baby_id])
		        ->first();

	}

	/**
	*To Get Nicu baby list 
	*
	*@param baby_id integer
	*@return nicu list in array of object 
	*/
	public static function GetBabyNicuList($baby_id) 
	{

		 return \DB::table('baby')
		         ->join('baby_admission', 'baby_admission.BabyId', '=', 'baby.BabyId')
		         ->join('nicu_admission', 'nicu_admission.BabyId', '=', 'baby_admission.BabyId') 
		         ->orderBy('nicu_admission.AdmissionId', 'desc')
		         ->where('baby.BabyId', $baby_id)
		         ->first();

	}

	/**
	*To Get previous  op list 
	*
	*@param baby_id integer
	*@return previous  op in array of object 
	*/

	public static function GetPreviousopRecord($baby_id) 
	{
		return \DB::table('op_details')
                ->where(['IsDeleted'=>0, 'BabyId'=>$baby_id])
                // ->orderBy('DateAdded', 'desc')
                ->orderBy('OpDate', 'desc')
                ->first();

	}


	/**
	*To Get previous  op list 
	*
	*@param baby_id integer
	*@return previous  op in array of object 
	*/

	public static function GetPreviousopAll($baby_id) 
	{
		return \DB::table('op_details')
                ->where(['IsDeleted'=>0, 'BabyId'=>$baby_id])
                ->orderBy('OpDate', 'desc')
                ->get();

	}

	/**
	 * This Method to get Op record  
	 * 
	 * @param $baby_id type integer
	 *
	 * @return array of objects
	 */
	public static function Opvisit_delete_approval($baby_id) 
	{

		return DB::table('op_details')
			   ->join('baby', 'op_details.BabyId', '=', 'baby.BabyId')
		       ->select('baby.BabyName', 'op_details.op_visite', 'baby.BMrNo', 'op_details.OpDate', 'op_details.OpId')
               ->where('op_details.BabyId', $baby_id)
               ->orderBy('op_details.OpId', 'desc')
               ->get();


	}

	/**
	 * This Method to get Neuro Developmental Record  
	 * 
	 * @param $request type array
	 *
	 * @return array of objects
	 */
	public static function checkNeuroRecord($request) 
	{
		if (count($request) > 0) {
			return DB::table('op_nuerodevelopment_report_mon_yr')
				   ->where('op_nuerodevelopment_report_mon_yr.baby_id', $request['baby_id'])
	               ->where('op_nuerodevelopment_report_mon_yr.baby_age', $request['selected_age'])
	               ->orderBy('op_date', 'desc')
	               ->first();
		}
		else
		{
			return array();
		}


	}
	/**
	 * This Method to get Neuro Developmental Record based on op_id 
	 * 
	 * @param $request type array
	 *
	 * @return array of objects
	 */
	public static function getNeuroDevelopmentalReport($op_id, $type='') 
	{
		if ($op_id != '') {
			if ($type == '') {
				return DB::table('op_nuerodevelopment_report_mon_yr')
					   ->where('op_nuerodevelopment_report_mon_yr.op_id', $op_id)
		               ->first();

			}
			else
			{
	            return DB::table('op_nuerodevelopment_report_mon_yr')
				   ->where('op_nuerodevelopment_report_mon_yr.op_id', $op_id)
	               ->get();

			}
		}
		else
		{
			return array();
		}


	}

	/**
	 * This Method to get Neuro Developmental Record based on op_id 
	 * 
	 * @param $request type array
	 *
	 * @return array of objects
	 */
	public static function getAllNeuroDevelopmentalReport($baby_id) 
	{

		return DB::table('op_nuerodevelopment_report_mon_yr')
					   ->where('op_nuerodevelopment_report_mon_yr.baby_id', $baby_id)
		               ->orderBy('op_date', 'asc')
		               ->get();
	}

	/**
	 * This Method to get M-CHAT-R answers for baby 
	 * 
	 * @param $baby_id type int
	 *
	 * @return array of objects
	 */
	public static function getMChatResults($baby_id) 
	{

		return DB::table('m_chat_r_screenings')
					   ->where('baby_id', $baby_id)
		               ->orderBy('question_id', 'asc')
		               ->get();
	}
    /**
	 * This Method to get M-CHAT-R answers for Visit 
	 * 
	 * @param $baby_id type int
	 *
	 * @return array of objects
	 */
	public static function getMChatResultsByVisit($visit_id) 
	{

		return DB::table('m_chat_r_screenings')
					   ->where('neuro_visit_id', $visit_id)
		               ->orderBy('question_id', 'asc')
		               ->get();
	}
	/**
	 * This Method to get Vaccine Chart for baby
	 * 
	 * @param $baby_id type Int
	 *
	 * @return array of objects
	 */
	public static function getBabyVaccineChart($baby_id) 
	{
		return \DB::table('baby_vaccine_details')
				->select('baby_vaccine_details.*', 'mas_vaccine_age.age', 'mas_vaccine_generic.name')
				->join('mas_vaccine_age', 'mas_vaccine_age.id', '=', 'baby_vaccine_details.age_id')
				->join('mas_vaccine_generic', 'mas_vaccine_generic.id', '=', 'baby_vaccine_details.vaccine_generic_id')
				->where('baby_id', $baby_id)
				->orderBy('age_sort_order', 'asc')
				->orderBy('vaccine_sort_order', 'asc')
				->get();
		       
	}

	/**
	 * This Method to get Vaccine Chart from master table
	 * 
	 * @param $baby_id type int
	 *
	 * @return array of objects
	 */
	public static function getVaccineChart() 
	{
		return \DB::table('mas_vaccine_generic')->select('mas_vaccine_generic.*', 'mas_vaccine_age.age' , 'mas_vaccine_age.sort_order as age_sort_order')
				->join('mas_vaccine_age', 'mas_vaccine_generic.vaccine_age_id', '=', 'mas_vaccine_age.id')
				->where('mas_vaccine_age.status', 'Active')
				->where('mas_vaccine_generic.status', 'Active')
				->where('mas_vaccine_age.is_deleted', 0)
				->where('mas_vaccine_generic.is_deleted', 0)
				->orderBy('mas_vaccine_age.sort_order', 'asc')
				->get();
		       
	}

	/**
	 * This Method to get baby weight, height and head circumference
	 * 
	 * @param $baby_mrn
	 * 
	 * @param $visit_date
	 *
	 * @return array of objects
	 */
	public static function getTodayPhysicalDetails($baby_mrn, $visit_date)
	{
		return self::select('CurrentWt', 'CurrentOFC', 'CurrentLength')
            ->where('BMrNo', $baby_mrn)
            ->where('OpDate', $visit_date)
            ->orderBy('OpId', 'desc')
            ->first();
	}

    // To get the previous and next day sheet id for the currently selected data
    public static function getPrevNextIds($baby_id)
    {
        return self::select('OpId')->where('BabyId', $baby_id)->orderBy('OpId', 'asc')->get();
    }


}
