<?php

namespace App\Http\Controllers\Nurse;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Nurse\LabImportedTemporary;
use App\Models\Settings\Settings;
use Carbon\Carbon;
use App\Models\Machine\MachineData;
use App\Models\Nurse\NurseSheetMain;
use App\Http\Controllers\Fhir;
use App\Models\Baby;
use Illuminate\Contracts\Auth\Guard;
use App\Models\Nurse\EmrLogHeader;
use App\Models\Nurse\EmrLogDetails;
use App\Models\Nurse\NurseHourSheet;
use App\Http\Controllers\Fhir\ImportFhirController;
use App\Models\Nurse\ImportFhir;
use App\Models\Admission;
use App\Models\IpNumber;

/**
 * All method to get Important blood values & Gluco meter values
 *
 */
class LabImportedController extends Controller
{
    /**
     * This for site settings instance 
     * 
     * @var $site_settings
     */
    public $site_settings;

    /**
     * This set update value
     * 
     * @var $update
     */
    public $update;

    /**
     * This set update value
     * 
     * @var $update
     */
    public $response;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Guard $auth, Settings $site_settings, Request $request)
    {
        $this->site_settings       = $site_settings;  
        $this->auth = $auth;
        $this->loinc_values = json_decode(\SiteHelpers::getConfigSettings('LOINC_LOCAL_CODE'));
        $this->update = false;
        $this->lab_user = 4;
    }

    /**
     * This method to get lab value
     *
     * @param $request object of request
     */
    
    // public function labValues(Request $request) {

        // $auth  = false;

        // $machine_data['received'] = file_get_contents('php://input');

        // $machine_entry = (array)json_decode($machine_data['received']);
    public function labValues($machine_entry) {

        $auth  = false;        

        $machine_data['received'] = $machine_entry;        

        $machine_entry = (array)json_decode($machine_entry);

        // $machine_entry = (array)json_decode($machine_entry['data']);

        if (!isset($machine_entry['entry'])) {
            return \Response::json(['status'=>'failure','message'=>'Invalid json formate !'], 422);
        }

        $machine_entry = $machine_entry['entry'];

        foreach ($machine_entry as $machine_entry_key => $machine_entry_value) {

            if (isset($machine_entry_value->resource->resourceType) && $machine_entry_value->resource->resourceType == 'AuditEvent') {
                if (isset($machine_entry_value->resource->object)) {
                    foreach ($machine_entry_value->resource->object as $resource_key => $resource_value) {
                        if (isset($resource_value->securityLabel)) {
                            $securityLabel = collect($resource_value->securityLabel);
                            $api_key       = $securityLabel->where('code', 'api_key')->first();
                            $user_name     = $securityLabel->where('code', 'user_name')->first();
                            $user_password = $securityLabel->where('code', 'user_password')->first();

                            if (isset($api_key->display) && isset($user_name->display) &&  isset($user_password->display)) {
                                 
                                $input['api_key']       = $api_key->display;
                                $input['user_password'] = $user_password->display;
                                $input['user_name']     = $user_name->display;
                                $auth        = $this->getCheckAuth($input);

                            } else {

                                return \Response::json(['status'=>'failure','message'=>'Invalid json formate !'], 422);

                            }
                        }
                    }
                }
            }   
        }

        if (!$auth) {
            return \Response::json(['status'=>'failure','message'=>'Invalid api key or credentials !'], 401);
        } else {
            foreach ($machine_entry as $machine_entry_key => $machine_entry_value) {
                if ($machine_entry_value->resource->resourceType == 'Patient') {

                    $baby_details    = ImportFhir::get_baby_details($machine_entry_value->resource->identifier[0]->value);

                    $this->machineData($baby_details, $machine_entry);
                }
            }
        }
        
        $machine_data['received_time']  = Carbon::now();
        $machine_data['is_parsed']      = false;
        $machine_data['received_ip']    = $_SERVER['REMOTE_ADDR']; 
        $machine_data['received_date']  = Carbon::now()->format('Y-m-d');

        MachineData::create($machine_data);

        if ($this->update == false) {
            return \Response::json(['status'=>'success','message'=>'Content Added Successfully'], 200);
        } else {
            return \Response::json(['status'=>'success','message'=>'Content Updated Successfully'], 200);
        }

    }

    /**
     * This method to get check the credentials 
     *
     * @param  $input type array 
     *
     * @return type bool
     */ 
    private function getCheckAuth($input)
    {
        $input['api_key']       = \SiteHelpers::decrypt_id($input['api_key']);
        $input['user_password'] = \SiteHelpers::decrypt_id($input['user_password']);

        $settings               = $this->site_settings->find(1);
        $api_key                = \SiteHelpers::decrypt_id($settings->api_key);
        $user_name              =  $settings->api_user_name;
        $user_password          = \SiteHelpers::decrypt_id($settings->api_password);

        if (($input['api_key'] == $api_key) && ($input['user_name'] == $user_name) &&  ($input['user_password'] == $user_password)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * This method to adding data into the corresponding table
     *
     * @param  $baby_details type array 
     * 
     * @param  $machine_entry type array 
     */ 
    private function machineData($baby_details, $machine_entry) {

        foreach ($machine_entry as $machine_entry_key => $machine_entry_value) {

            if ($machine_entry_value->resource->resourceType != 'AuditEvent' && $machine_entry_value->resource->resourceType != 'Patient') {

                $baby_admission  = Baby::getInpatientBaby($baby_details->BabyId);
                $admissionId = $baby_admission->AdmissionId;
                foreach ($machine_entry_value->resource->identifier as $key => $value) {
                    foreach ($value as $identifierkey => $identifiervalue) {
                        if ($identifiervalue == 'createTime') {
                            $time_issued = $machine_entry_value->resource->identifier[$key]->value;
                        }
                    }
                }
                // $time_issued = $machine_entry_value->resource->effectivePeriod->start;

                $sheet_details  =  NurseSheetMain::GetNurseSheet($time_issued, $baby_details->BabyId, $admissionId);

                if (count($sheet_details) > 0) {

                    $sheet_id = $sheet_details->id;

                    $sheet_time = EmrLogHeader::getSenderTimeList($sheet_id);

                    foreach ($sheet_time as $key => $time) {
                        $entrySheetTime = date('H', strtotime($time->sender_time));

                        if ($entrySheetTime == date('H', strtotime($time_issued))) {
                            $this->update = true;
                            $sheetTime = $time->sender_time;
                        } 

                    }
                } else {

                    $dayCount = count(NurseSheetMain::GetNurseSheetCount($baby_details->BabyId,$admissionId));

                    $sheet_details['day_name']      = 'Day '.($dayCount + 1);
                    $sheet_details['sheet_date']   = date('Y-m-d', strtotime($time_issued));
                    $sheet_details['baby_id']      = $baby_details->BabyId;
                    $sheet_details['admission_id'] = $admissionId ;

                    $sheet_id =  NurseSheetMain::create($sheet_details)->id;
                }

                $labData = (array)$machine_entry_value->resource;

                $effectivePeriod['start'] = $time_issued;
                $effectivePeriod['end'] = $labData['issued'];

                $labValues = array(
                    'resourceType' => $labData['resourceType'],
                    // 'id' => $labData['id'],
                    // 'text' => json_encode($labData['text']),
                    'identifier' => json_encode($labData['identifier']),
                    'status' => $labData['status'],
                    'code' => json_encode($labData['code']),
                    'subject' => json_encode($labData['subject']),
                    // 'effectivePeriod' => json_encode($labData['effectivePeriod']),
                    // 'effectivePeriod' => json_encode((object)$effectivePeriod),
                    'issued' => $labData['issued'],
                    'performer' => json_encode($labData['performer']),
                    'valueQuantity' => json_encode($labData['valueQuantity']),
                    // 'interpretation' => json_encode($labData['interpretation']),
                    'referenceRange' => json_encode($labData['referenceRange'])
                );
                LabImportedTemporary::create($labValues);

                if ($this->update == false) {

                    $main_sheet = $this->EmrLogHeader($baby_details, $admissionId, $sheet_id, $time_issued);

                    $emr_log_head_id = EmrLogHeader::create($main_sheet);

                    foreach ($this->loinc_values as $key => $value) {

                        $result  = EmrLogHeader::getLoincReferenceDetail($value);

                        if (count($result) > 0) {
                            $result  = collect($result)->toArray();

                            $sub_sheet_values = $this->EmrLogDetails($emr_log_head_id['id'], $result, $labValues);

                            EmrLogDetails::create($sub_sheet_values);
                        }
                    }

                } else {

                    $emrLogId = EmrLogHeader::getEmrLogHdrId($sheet_id, $sheetTime);

                    $emrLogHdr = EmrLogHeader::findorfail($emrLogId->id);

                    $main_sheet = $this->EmrLogHeader($baby_details, $admissionId, $sheet_id, $time_issued);

                    $emrLogHdr->Update($main_sheet);

                    foreach ($this->loinc_values as $key => $value) {

                        $result  = EmrLogHeader::getLoincReferenceDetail($value);

                        if (count($result) > 0) {
                            $result  = collect($result)->toArray();

                            $emrLogDetailId = EmrLogDetails::emrLogId($emrLogId->id,$result['loinc_code']);

                            $emrLogDetailData = EmrLogDetails::findorfail($emrLogDetailId->id);

                            $sub_sheet_values = $this->EmrLogDetails($emrLogId->id, $result, $labValues, $value);

                            $emrLogDetailData->Update($sub_sheet_values);
                        }
                    }
                }break;
            }
        }
    }

    /**
     * This method to adding data into EmrLogHeader table
     *
     * @param  $baby_details type array 
     * 
     * @param  $admissionId type integer 
     *
     * @param  $sheet_id type integer 
     * 
     * @param  $time_issued type timestamp
     */ 
    private function EmrLogHeader($baby_details, $admissionId, $sheet_id, $time_issued) {

        $main_sheet['sender']         = env('APP_NAME');  
        $main_sheet['gender']         = $baby_details->Sex;
        $main_sheet['sender_time']    = date('Y-m-d H:i:s', strtotime($time_issued));
        $main_sheet['visit_date']     = date('Y-m-d H:i:s', strtotime($time_issued));
        $main_sheet['loinc_version']  = 2.63;
        $main_sheet['active_flag']    = 'Y';
        $main_sheet['create_user_id'] = $this->lab_user;
        $main_sheet['create_tstamp']  = date('Y-m-d H:i:s', time());
        $main_sheet['modify_user_id'] = $this->lab_user;
        $main_sheet['modify_tstamp']  = date('Y-m-d H:i:s', time());
        $main_sheet['day_id']         = isset($sheet_id) ? $sheet_id : null;
        $main_sheet['baby_id']        = isset($baby_details->BabyId) ? $baby_details->BabyId : null;
        $main_sheet['mother_id']      = isset($baby_details->MotherId) ? $baby_details->MotherId : null;
        $main_sheet['admission_id']   = isset($admissionid) ? $admissionid : null;
        $main_sheet['added_nurse']    = null;

        return $main_sheet;
    }

    /**
     * This method to adding data into EmrLogDetails table
     *
     * @param  $emr_log_head_id type id 
     * 
     * @param  $result type array 
     *
     * @param  $labValues type array 
     */ 
    private function EmrLogDetails($emr_log_head_id, $result, $labValues) {

        $sub_sheet_values["log_hdr_id"]         = $emr_log_head_id;
        $sub_sheet_values["loinc_local_map_id"] = $result['ref_loc_master_id'];
        $sub_sheet_values["loinc_code"]         = $result['loinc_code']; 
        $sub_sheet_values["loinc_version"]      = $result['loinc_version'];  
        $sub_sheet_values["intf_ref_name"]      = 'None'; 
        if ($result['loinc_code'] == json_decode($labValues['code'])->coding[0]->code) {
            $sub_sheet_values["intf_ref_value"]     = json_decode($labValues['valueQuantity'])->value;  //Doubt  
        }
        $sub_sheet_values["component"]          = $result['component']; 
        $sub_sheet_values["property"]           = $result['property']; 
        $sub_sheet_values["time"]               = date('H:i:s', time());
        $sub_sheet_values["system"]             = $result["system"];
        $sub_sheet_values["scale"]              = $result["scale_typ"];
        $sub_sheet_values["method"]             = $result["method_typ"];
        $sub_sheet_values["classtype"]          = $result["classtype"];
        $sub_sheet_values["active_flag"]        = $result["active_flag"];
        $sub_sheet_values["create_user_id"]     = $this->lab_user;
        $sub_sheet_values["create_tstamp"]      = date('Y-m-d H:i:s', time());
        $sub_sheet_values["modify_user_id"]     = $this->lab_user;
        $sub_sheet_values["modify_tstamp"]      = date('Y-m-d H:i:s', time());

        return $sub_sheet_values;
    }

    /**
     * This method to interact with lab interface
     *
     * @param  $admission_id type integer
     */
    public function labInvite($admission_id, $slug='') {
        // $temp = $admission_id;
        // $admission_id = $slug;
        // $slug = $temp;
        
        $admissionid =  \SiteHelpers::decrypt_id($admission_id);
        $baby = Admission::getBabyMrn($admissionid);
        // $ip_no = IpNumber::getCurrent_ip($baby->BabyId, $admissionid)->ip_number;
        $ip_no = '1908685';

        $paramattribute =['baby_mrn'=>$baby->BMrNo,
                            'ip_number'=>$ip_no,
                            'admission_id'=>$admissionid];  

        //Constructing the provider url
        // $uri ='http://localhost/neo_up_test/sample?'; 
        $uri = \SiteHelpers::getConfigSettings('LAB_REQUEST_URL').$ip_no;

        $i=0;
        // foreach ($paramattribute as $key => $value) {
        //     $uri .= ($i==0) ? $key.'='.$value : '&'.$key.'='.$value;
        //     $i++;
        // }

        // Get response from the requested uri
        $client  = new \GuzzleHttp\Client();
        $labrequest = new \GuzzleHttp\Psr7\Request('GET', $uri);
        $promise = $client->sendAsync($labrequest)->then(function ($labresponse) {
            $this->response =  $labresponse->getBody();
        });
        $promise->wait();

        $this->labValues($this->response);

        if ($slug == 'admission') {
            return redirect(action('Nurse\NurseSheetController@GetDaylist', \SiteHelpers::encrypt_id($admission_id)));
        } else {
            return redirect(action('Nurse\NurseSheetController@labValuePrint', ['admission_id'=>$admission_id, 'order' => 'asc']));
        }
        
    }
}
