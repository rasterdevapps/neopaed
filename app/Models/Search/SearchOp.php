<?php

namespace App\Models\Search;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Search\SearchQueryLog;

class SearchOp extends Model
{
    /**
	*To Get previous  op list 
	*
	*@param baby_id integer
	*@return previous  op in array of object 
	*/

	public static function getadvancedsearch($page = 1, $limit = 5, $search, $mode) 
	{
        $limitstart    = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend      = $limit;
        
		$opsummary = ['Advice', 'AllergyHistory', 'FamilyHistory', 'TreatmentHistory', 'baby_background', 
		'ConfidentialBackgroundDetails', 'Complaints', 'HPI', 'Development', 'Examination', 
		'Diagnosis', 'investigations', 'nextreviewindication'];  

		$ad_search    =  preg_replace('/[:,_,+,(,),\t\n\r,%,=,?,˜,@,#,$,ˆ,*,"]/', '', trim($search));

		\DB::enableQueryLog();

		$results = \DB::table('op_details')
        ->join('baby','baby.BabyId', '=', 'op_details.BabyId')
		->select('op_details.BabyId', 'OpId', 'BabyName', 'DOB', 'op_details.BMrNo', 'op_visite', 'hospital_name')
		->where('op_details.IsDeleted', 0)
		->where('baby.IsDeleted', 0);
		if ($mode) {

			$results = $results->where(function($query) use ($opsummary, $ad_search) {
				foreach ($opsummary as $summary_key => $summary_value) {
					$query->orwhere($summary_value, 'like','%'.$ad_search.'%');
				}
			});

		} else {

			$results = $results->where(function($query) use ($opsummary, $ad_search) {
				foreach ($opsummary as $summary_key => $summary_value) {
					$query->orWhereRaw('to_tsvector("'.$summary_value.'") @@ to_tsquery('."'".$ad_search."'".')');
				}
			});
		}         

		$results = $results->limit($limitend)->offset($limitstart)->get();

		$query_log                 = \DB::getQueryLog();
		$last_log                  = end($query_log);
		$last_log['bindings']      = implode(', ', $last_log['bindings']);
		$last_log['search_module'] = 4;
		SearchQueryLog::create($last_log);

		\DB::flushQueryLog();

		return $results;


	}


	/**
	*To get op record based on op id 
	*
	*@param id  integer
	*@return op record in array of objects
	*/


	public static function  get_oprecord_highlight($id, $search_text, $search_mode) 
	{

		$opsummary     = [ 'Advice', 'AllergyHistory', 'FamilyHistory', 'TreatmentHistory', 'baby_background', 
		'ConfidentialBackgroundDetails', 'Complaints', 'HPI', 'Development', 'Examination', 
		'Diagnosis', 'investigations', 'nextreviewindication'];  

		$op_select     =  ['OpId', 'mother_blood_group','AppointmentType','CurrentLength','CurrentOFC','CurrentWt',
		'Immunization','Outcome','Review','Schedule','OpDate','OpTime','Vaccine','SeenBy','OpTime_AM','OpTime_MINS','HeadCircumference',
		'review_time','review_session','review_min','chronological_days','chronological_month', 'chronological_weeks','chronological_year',
		'corrected_days','corrected_month','corrected_weeks', 'corrected_year','op_visite','total_chronological_weeks','total_chronological_days',
		'total_corrected_weeks','total_corrected_days', 'neurosonogram','neurosonogram_report','echocardiogram','fee_reason','echocardiogram_report', 'hospital_name'];

		$baby_select   = ['BabyName','BirthOrder','BirthStatus','BirthWeight','Gestation','Sex','ConfidentialBackgroundDetails','DOB',
		'TOB','Background','BirthCity','BabyBloodGroup','TOB_TIME','TOB_MINS','TOB_AM','MultiplePregnancy',
		'MultiplePregnancyType','neonatal_consultant','paediatric_surgeon','Noofbabies','g_weeks','g_days',
		'Baby_group_id'];

		$mother_select = ['MotherName','partner_occupation_status','partner_education_status','MotherLastName','education_status',
		'occupation_status','MotherInitial','MotherTitle','PartnerTitle','PartnerInitial','Email','Address1',
		'Address2','Address3','Address4','Mobile','MotherDOB','City','State','Country','PartnerName',
		'PartnerContact','PartnerDOB','PartnerOccupation','LandLine','Occupation','G_Value','P_Value',
		'L_Value','A_Value','G_sequence','MMrNo','MothercYear','MotherEmail','PartnerMobile','PartnercYear',
		'PartnerLastName','Postcode','Address5','FatherAddress1','FatherAddress2','MotherBloodGroup',
		'FatherSpokenLanguages','MotherSpokenLanguages'];


		if ($search_mode != 'advanced') {
			$search    =  preg_replace('/[:,-,_,+,(,),\t\n\r,%,=,?,˜,@,#,$,ˆ,*]/', '', trim($search_text));
			$search    =  preg_replace('/[&,|,!]/', ' ', trim($search_text));
			$search    =  str_replace('AND', '', trim($search));
			$search    =  str_replace('OR', '', trim($search));
			$search    =  str_replace('NOT', '', trim($search));
		} else {
			$search    =  preg_replace('/[&,|,!]/', ' ', trim($search_text));
			$search    =  str_replace('AND', '', trim($search));
			$search    =  str_replace('OR', '', trim($search));
			$search    =  str_replace('NOT', '', trim($search));
			$search    = explode(' ', $search);

		}





		\DB::enableQueryLog();


		$results = DB::table('op_details');
		$tags = array();


		foreach ($opsummary as $key => $text) {
			if ($search_mode =='advanced') {

				foreach ($search as $search_key => $search_value) {
					if (!empty($search_value)) {
						$start_tag = '<'.strtolower($text).'>';
						$end_tag   = '</'.strtolower($text).'>';
						$results   = $results->selectRaw('ts_headline("'.$text.'",to_tsquery(\''.$search_value.'\'),\'StartSel ='.$start_tag.', StopSel = '.$end_tag.'\') as '.$text);
						$tags[]    = strtolower($text); 
					}

				}

			} else {
				$start_tag = '<'.strtolower($text).'>';
				$end_tag   = '</'.strtolower($text).'>';
				$results   = $results->selectRaw('ts_headline("'.$text.'",to_tsquery(\''.$search_text.'\'),\'StartSel ='.$start_tag.', StopSel = '.$end_tag.'\') as '.$text);
				$tags[]    = strtolower($text); 
			}


		}

		$results = $results->addselect($baby_select)
		->addSelect($mother_select)
		->addSelect($op_select)
		->addSelect('baby.BabyId', 'baby.BMrNo')
		->join('baby', 'op_details.BabyId', '=', 'baby.BabyId')
		->join('mother', 'mother.MotherId', '=', 'baby.MotherId')
		->where('OpId', $id)
		->get();	

		$query_log                 = \DB::getQueryLog();
		$last_log                  = end($query_log);
		$last_log['bindings']      = implode(', ', $last_log['bindings']);
		$last_log['search_module'] = 4;
		SearchQueryLog::create($last_log);

		\DB::flushQueryLog();
		$results[0]->tags= $tags;


		return $results;



	}
}
