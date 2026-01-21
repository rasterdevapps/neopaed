<?php

namespace App\Http\Controllers\Fhir;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Nurse\ImportFhir;
use GuzzleHttp\Exception;
use App\Models\IpNumber;
use App\Http\Controllers\Errors\ErrorLogController;

class LabCultureImportController extends Controller
{
   
   /**
	* This for site settings instance 
	* 
	* @var $site_settings
	*/
    public $site_settings;

    /**
	* This for fhir formate
	* 
	* @var $fhir_formate
	*/
    public $fhir_formate;

    /**
     * This for import values into nurse sheet 
     *
     * @var $import_values type instance  
     */
     public $import_values;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
        $this->time_zone           = env('TIME_ZONE');
        $this->custom_error = new ErrorLogController();

	}

	/**
	 * This method to get 
	 * fhir resource 
	 *
	 * @param  $request instance of Illuminate\Http\Request
	 *
	 * @return type json 
	 */
    public function getfhirjsondata(Request $request) 
    {
    	// $lab_request_list = ImportFhir::getLabRequestList();
     //    $lab_culture_result_url = \SiteHelpers::getConfigSettings('GET_LIS_LAB_CULTURE_RESULT');

     //    if (count($lab_request_list) > 0) {
     //        foreach ($lab_request_list as $lab_req_key => $lab_req_value) {
     //            $baby_id = $lab_req_value->baby_id;
     //            $admission_id = $lab_req_value->admission_id;
     //            $ip_number = IpNumber::getCurrent_ip($lab_req_value->baby_id)->ip_number;
     //            if (substr($ip_number, 0, 3) !== 'IP/') {
     //                $this->custom_error->emergencyLog('Error on getting results for IP number :'.$ip_number.' Baby ID : '.$lab_req_value->baby_id);
     //                continue;
     //            }
     //            $client = new \GuzzleHttp\Client();
     //            $response = $client->request('GET', $lab_culture_result_url.$ip_number, ['http_errors' => false]);
     //            // $response = $client->request('GET', 'http://172.17.1.33:8909/getItem?visitnumber='.$ip_number, ['http_errors' => false]);
     //            $status_code = $response->getStatusCode();
     //            if ($status_code != 200) {
     //                $this->custom_error->emergencyLog('HTTP ERROR for IP number :'.$ip_number.' Baby ID : '.$lab_req_value->baby_id);
     //                continue;
     //            }
     //            $culture_result = $response->getBody();
     //            $culture_result = $culture_result->getContents();
				$machine_data['received'] = file_get_contents('php://input'); 
				// $this->custom_error->emergencyLog('Culture report received = '.$machine_data['received']);
				$this->custom_error->emergencyLog('CULTURE REPORT:' . file_get_contents('php://input'));
				if ($this->isJson($machine_data['received'])) {
					$result = json_decode($machine_data['received']);
					if (count($result) > 0) {
						if(isset($result) && !empty($result) && isset($result->labNumber) && isset($result->specimen) && trim($result->labNumber) != '' && trim($result->specimen) != '' && isset($result->visitNumber) && trim($result->visitNumber) != '')
						{
							$baby_details = \DB::table('ip_numbers')->select('baby_id', 'AdmissionId')->where('ip_number', $result->visitNumber)->first();
							if (isset($baby_details->baby_id) && isset($baby_details->AdmissionId) && !empty($baby_details->baby_id) && !empty($baby_details->AdmissionId)) {
								$baby_id = $baby_details->baby_id;
								$admission_id = $baby_details->AdmissionId;
								$report = $this->checkReportExist($result->labNumber, strtolower($result->specimen));
								$this->custom_error->emergencyLog('Microbiology culture report received for Visit= '.$result->visitNumber. '  and lab Number = '.$result->labNumber.' with specimen = '.$result->specimen.' package_name = '.$result->packageName);
								if (isset($report->id) && !empty($report->id)) {
									
									\DB::table('emr_microbiology_report_items')->where('report_id', $report->id)->update(['display_status' => false]);
									
									$update_microbiology_report = array(
										'lab_sample_number' => isset($result->labSampleNumber) && !empty($result->labSampleNumber) ? $result->labSampleNumber : '',
										'package_name' => isset($result->packageName) && !empty($result->packageName) ? $result->packageName : '',
										'test_name' => isset($result->testName) && !empty($result->testName) ? $result->testName : '',
										'gram_stain' => isset($result->gramStain) && !empty($result->gramStain) ? $result->gramStain : '',
										'culture' => isset($result->culture) && !empty($result->culture) ? $result->culture : '',
										'isolate_one_result' => isset($result->isolate1R) && !empty($result->isolate1R) ? $result->isolate1R : '',
										'colony_count_one' => isset($result->colonyCount1) && !empty($result->colonyCount1) ? $result->colonyCount1 : '',
										'isolate_two_result' => isset($result->isolate2R) && !empty($result->isolate2R) ? $result->isolate2R : '',
										'colony_count_two' => isset($result->colonyCount2) && !empty($result->colonyCount2) ? $result->colonyCount2 : '',
										'modify_user_id' => 'LIS Inetrfacing',
										'modify_tstamp' => date('Y-m-d H:i:s')
									);
									if(isset($result->reportTime) && !empty($result->reportTime))
									{
										$update_microbiology_report['result_report_time'] = date('Y-m-d H:i:s', (int) ($result->reportTime / 1000) );
									}

									if(isset($result->createtime) && !empty($result->createtime))
									{
										$update_microbiology_report['result_collect_time'] = date('Y-m-d H:i:s', (int) ($result->createtime / 1000) );
									}
									\DB::table('emr_microbiology_report')->where('id', $report->id)->update($update_microbiology_report);

									if (isset($result->reportItems) && count($result->reportItems) > 0) {
										$this->custom_error->emergencyLog('This microbiology culture report has '.count($result->reportItems).' result items');
										foreach ($result->reportItems as $item_key => $item_value) {
											if (isset($item_value->drugId) &&  !empty($item_value->drugId)) {
												$check_report_items_exist = \DB::table('emr_microbiology_report_items')->where('report_id', $report->id)->where('lis_drug_id', $item_value->drugId)->first();
												if (isset($check_report_items_exist->id)) {
													$report_items = array(
														'report_id' => $report->id,
														'drug_name' => $item_value->drugName,
														'isolate_one' => $item_value->isolate1,
														'result_one' => $item_value->result1,
														'result_one_unit' => $item_value->result1_unit,
														'isolate_two' => $item_value->isolate2,
														'result_two' => $item_value->result2,
														'result_two_unit' => $item_value->result2_unit,
														'display_status' => true,
														'modify_user_id' => 'LIS Inetrfacing',
														'modify_tstamp' => date('Y-m-d H:i:s')
													);

													\DB::table('emr_microbiology_report_items')->where('id', $check_report_items_exist->id)->update($report_items);
												}
												else
												{
													$report_items = array(
														'report_id' => $report->id,
														'drug_name' => $item_value->drugName,
														'isolate_one' => $item_value->isolate1,
														'result_one' => $item_value->result1,
														'result_one_unit' => $item_value->result1_unit,
														'isolate_two' => $item_value->isolate2,
														'result_two' => $item_value->result2,
														'result_two_unit' => $item_value->result2_unit,
														'lis_drug_id' => $item_value->drugId,
														'display_status' => true,
														'create_user_id' => 'LIS Inetrfacing',
														'create_tstamp' => date('Y-m-d H:i:s')
													);

													\DB::table('emr_microbiology_report_items')->insert($report_items);
												}
											}
										}
									}

								}

								else
								{
									$this->custom_error->emergencyLog('Microbiology culture report received for Visit= '.$result->visitNumber. '  and lab Number = '.$result->labNumber.' with specimen = '.$result->specimen.' package_name = '.$result->packageName);
									$microbiology_report = array(
										'lab_number' => $result->labNumber,
										'lab_sample_number' => isset($result->labSampleNumber) && !empty($result->labSampleNumber) ? $result->labSampleNumber : '',
										'specimen' => isset($result->specimen) && !empty($result->specimen) ? strtolower($result->specimen) : '',
										'package_name' => isset($result->packageName) && !empty($result->packageName) ? $result->packageName : '',
										'test_name' => isset($result->testName) && !empty($result->testName) ? $result->testName : '',
										'gram_stain' => isset($result->gramStain) && !empty($result->gramStain) ? $result->gramStain : '',
										'culture' => isset($result->culture) && !empty($result->culture) ? $result->culture : '',
										'isolate_one_result' => isset($result->isolate1R) && !empty($result->isolate1R) ? $result->isolate1R : '',
										'colony_count_one' => isset($result->colonyCount1) && !empty($result->colonyCount1) ? $result->colonyCount1 : '',
										'isolate_two_result' => isset($result->isolate2R) && !empty($result->isolate2R) ? $result->isolate2R : '',
										'colony_count_two' => isset($result->colonyCount2) && !empty($result->colonyCount2) ? $result->colonyCount2 : '',
										'create_user_id' => 'LIS Inetrfacing',
										'create_tstamp' => date('Y-m-d H:i:s'),
										'baby_id' => $baby_id,
										'admission_id' => $admission_id
									);
									if(isset($result->reportTime) && !empty($result->reportTime))
									{
										$microbiology_report['result_report_time'] = date('Y-m-d H:i:s', (int) ($result->reportTime / 1000) );
									}
									if(isset($result->createtime) && !empty($result->createtime))
									{
										$microbiology_report['result_collect_time'] = date('Y-m-d H:i:s', (int) ($result->createtime / 1000) );
									}
									$report_id = \DB::table('emr_microbiology_report')->insertGetId($microbiology_report);
									
									if (isset($result->reportItems) && count($result->reportItems) > 0) {
										$this->custom_error->emergencyLog('This microbiology culture report has '.count($result->reportItems).' result items');
										foreach ($result->reportItems as $item_key => $item_value) {
											if (isset($item_value->drugId) &&  !empty($item_value->drugId)) {
												$report_items = array(
													'report_id' => $report_id,
													'drug_name' => $item_value->drugName,
													'isolate_one' => $item_value->isolate1,
													'result_one' => $item_value->result1,
													'result_one_unit' => $item_value->result1_unit,
													'isolate_two' => $item_value->isolate2,
													'result_two' => $item_value->result2,
													'result_two_unit' => $item_value->result2_unit,
													'lis_drug_id' => $item_value->drugId,
													'display_status' => true,
													'create_user_id' => 'LIS Inetrfacing',
													'create_tstamp' => date('Y-m-d H:i:s')
												);
											}
											\DB::table('emr_microbiology_report_items')->insert($report_items);
										}
									}
								}
								$this->custom_error->emergencyLog('Microbiology culture report received for Visit= '.$result->visitNumber. '  and lab Number = '.$result->labNumber);
		 						return \Response::json(['status'=>'success','message'=>'Report added successfully'], 200);
							}
							else
							{
	 							return \Response::json(['status'=>'failure','message'=>'Baby not exist for lab number'.$result->labNumber], 200);
	 							$this->custom_error->emergencyLog('Baby doesn\'t exist for IP number = '.$result->visitNumber.' in microbiology report');
							}

						}
						else
						{
	 						return \Response::json(['status'=>'failure','message'=>'Lab Number not exist'], 200);
	 						$this->custom_error->emergencyLog('Required information are empty in microbiology report= '.$result->visitNumber);
						}
					}
					else
					{
		  	 			return \Response::json(['status'=>'failure','message'=>'Empty response'], 200);
	 					$this->custom_error->emergencyLog('ERROR : Empty response in microbiology report');
					}
				}
				else
				{
		  	 		return \Response::json(['status'=>'failure','message'=>'Invalid response'], 200);
	 				$this->custom_error->emergencyLog('ERROR : Invalid json response in microbiology report');
				}
		// 	}
		// }
    }

    /**
	 * This method to check request string is JSON or not 
	 * 
	 *
	 * @param  $string JSON string
	 *
	 * @return type json 
	 */
    public function isJson($string) {
	   json_decode($string);
	   return json_last_error() === JSON_ERROR_NONE;
	}

	/**
	 * This method to check microbiology report is exist or not. 
	 * 
	 *
	 * @param  $string JSON string
	 *
	 * @return type json 
	 */
    public function checkReportExist($lab_number, $specimen) {
	   return \DB::table('emr_microbiology_report')->where('lab_number', $lab_number)->where('specimen', $specimen)->first();
	}

	
}
