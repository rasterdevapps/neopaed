<?php

namespace App\Http\Controllers\Search;

use Carbon\Carbon;
use App\Models\Search\SearchOp;
use App\Models\Baby;
use App\Models\Mother;
use App\Models\Medications;
use App\Models\Settings\DeleteApproval;
// use App\Models\Masters\Drug as Drug;
use App\Models\Masters\DrugIvFluidMaster;
use App\Models\Masters\Vaccine as Vaccine;
use App\Models\AutoCompleteWords;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\OpRequest;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Controllers\Controller;
use App\Models\Settings\Settings;
use App\Models\Neonatal;
use App\Models\DischargeSummary;
use App\Http\Controllers\Flow\FlowController;
use App\Models\PostDaycare;
use App\Models\Postnatal;
use App\Models\Icd;


class SearchOpController extends Controller
{
    /**
     * This method Op report search 
     *  
     * @param $request Illuminate\Http\Request
     *
     */
    public function OpReportSearch(Request $request)
	{
    $navigate['main_nav'] = 'op';
    $navigate['sub_nav']  = 'op';

		 $input = $request->all();

         $list_details   = array();

         $search_statement = '';
         $search_query     = '';
         $baby_name        = '';

          if (isset($input['advanced_search'])) {
             for ($searchIndex = 0; $searchIndex < count($input['advanced_search']) ; $searchIndex++) { 

               if (isset($input['advanced_search'][$searchIndex]) && isset($input['search_operator'][$searchIndex]) && !empty($input['advanced_search'][$searchIndex]) && !empty($input['search_operator'][$searchIndex])) {

                    $temp_statement = $input['advanced_search'][$searchIndex];
                    if ($temp_statement[0] =='"' && $temp_statement[strlen($temp_statement)-1] == '"') {
                       $input['advanced_search'][$searchIndex] = str_replace(' ', '<1>', trim($input['advanced_search'][$searchIndex]));
                    } else {
                       $input['advanced_search'][$searchIndex] = str_replace(' ', '|', trim($input['advanced_search'][$searchIndex]));
                    } 

                   $search_statement = $search_statement.$input['advanced_search'][$searchIndex].''.$this->operatorbuilder($input['search_operator'][$searchIndex]);
                   $search_query     = $search_query.$input['advanced_search'][$searchIndex].' '.$input['search_operator'][$searchIndex].' ';

               } elseif(isset($input['advanced_search'][$searchIndex]) && !isset($input['search_operator'][$searchIndex]) && !empty($input['advanced_search'][$searchIndex])) {

                    $temp_statement = $input['advanced_search'][$searchIndex];
                    if ($temp_statement[0] =='"' && $temp_statement[strlen($temp_statement)-1] == '"') {
                       $input['advanced_search'][$searchIndex] = str_replace(' ', '<1>', trim($input['advanced_search'][$searchIndex]));
                    } else {
                       $input['advanced_search'][$searchIndex] = str_replace(' ', '|', trim($input['advanced_search'][$searchIndex]));
                    } 
                   
                   $search_statement = $search_statement.$input['advanced_search'][$searchIndex];
                   $search_query     = $search_query.$input['advanced_search'][$searchIndex];

               }
             }
          } 


         if ($search_statement !='' && ($search_statement[strlen($search_statement)-1] == '&' || $search_statement[strlen($search_statement)-1] == '|')) {
	             $search_statement = str_replace('&', '', $search_statement);
	             $search_statement = str_replace('|', '', $search_statement);
         }


         $search_txt     = (isset($search_statement) && $search_statement != '') ? $search_statement : '';
         $search_status  = false;
         $search_mode    = false;

         $search_mode    = strpos($search_txt, '<1>') > 0 ? true : $search_mode;
         $search_txt     = str_replace('<1>', ' ', $search_txt);

          $page = !empty($request->input('page')) ? $request->input('page') : 1;

         if (isset($search_txt) && !empty($search_txt)) {
            
            $limit = 10;

           $list_details  = SearchOp::getadvancedsearch($page, $limit, $search_txt, $search_mode); 
           $search_status = true;
         }

         if (count($list_details) > 0) {

            $baby_name        = $list_details->first()->BabyName.' - '.$list_details->first()->BMrNo;
            $temp_baby_ids   = $list_details->unique('BabyId')->pluck('BabyId')->toArray();

	        foreach ($temp_baby_ids as $list_details_key => $list_details_value) {
	        	$baby_id_list[$list_details_value] = collect($list_details)->where('BabyId', $list_details_value);
	        }

         } 

         $search_txt = str_replace('"','', $search_txt);
         $search_query = str_replace('"','', $search_query);

         $search_mode = ($search_mode == true) ? 'advanced' : 'normal';


        return view('search.opsummary.search', compact('search_status', 'search_mode','baby_id_list','search_query','list_details', 'search_txt', 'baby_name', 'navigate'));
	}

	/**
	 * PRINT DISPLAY
	 *
	 * @param  int  $id
	 */
	public function searchreport($id, $search_text, $search_mode, Request $request) 
	{

		$result = SearchOp::get_oprecord_highlight($id, $search_text, $search_mode);

		$tags    = $result[0]->tags;


		$results = $result[0];

		$headerContent = Settings::findorfail(1);

		$drugs                = DrugIvFluidMaster::getOralDrug();
		$Vaccines             = Vaccine::get_lists();

		$drug_data[0] = 'Select';

		foreach ($drugs as $drug) {

			$drug_data[$drug->Id] = $drug->Name;

		}

		$vaccine[0] = 'Select';
		foreach ($Vaccines as $vac) {
			$vaccine[$vac->Id] = $vac->Name;
		}
         $closewinlink = action('Registration\OpController@OpsubList', \SiteHelpers::encrypt_id($results->BabyId));
		
		$results->Vaccine   = json_decode($results->Vaccine);
		$medications        = Medications::where(['BabyId'=>$results->BabyId,'AdmissionId'=>0,'source_id'=>$id,'flag'=>3])->get();
        $results->Gestation = \SiteHelpers::decode_gestation($results->Gestation);

        $results->review_time = strlen($results->review_time) == 1 ? '0'.$results->review_time : $results->review_time ;
        $results->review_min  = strlen($results->review_min) == 1 ? '0'.$results->review_min : $results->review_min ;
		$doctors = \ValuelistHelpers::mas_doctors_list();

		$results->Complaints  = $results->complaints;
		$results->Development = $results->development;

		$results->Examination = $results->examination; 
		$results->Diagnosis   = $results->diagnosis;
		$results->Advice      = $results->advice;
    if ($request->ajax()) {

		   $op_report = view('registration.op_print', compact('results', 'tags','medications', 'headerContent', 'vaccine', 'drug_data', 'closewinlink','doctors'))->render();
		   return \Response::json(['op_report'=>$op_report, 'babyName'=>$results->BabyName.' - '.$results->BMrNo], 200);

		 }

		return view('registration.op_print', compact('results', 'medications', 'headerContent', 'tags','vaccine', 'drug_data', 'closewinlink','doctors'));
	}

	/**
      * This method to get 
      * condition
      *
      */
     private function operatorbuilder($operator)
     {
        $operatorSet = [ 'AND' => '&',
                         'OR'  => '|',
                         'NOT' => '&!' ]; 

        return isset($operatorSet[$operator]) ? $operatorSet[$operator] : '';


     }
}
