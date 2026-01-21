<?php

namespace App\Http\Controllers\Fhir;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Settings\Settings;
use App\Http\Controllers\Errors\ErrorLogController;
use Carbon\Carbon;
use App\Models\Mother;
use App\Models\Baby;
use App\Models\Admission;
use App\Models\Masters\Bed;
use App\Models\Ward\BedLog;
use App\Models\IpNumber;
use App\Models\Nicu;
use App\Models\Nurse\NurseSheetMain;
use App\Models\Nurse\DayWisePatientBedLog;
use App\Models\Nurse\SyringePumpAdmisson;
use App\Events\WardEvent;
use App\Http\Controllers\Fhir\PrescriptionToMirthController;

class HmsInterfacingController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Settings $site_settings)
    {
        $this->site_settings = $site_settings;  
        $this->time_zone = env('TIME_ZONE');
        $this->custom_error = new ErrorLogController();

    }
    
    /**
     * This method to get HMS token
     * it will valid for 24 hours
     */
    public function getHMSToken() {

        $settings = $this->site_settings->find(1);

        $get_baby_details_from_his = \SiteHelpers::getConfigSettings('GET_HMS_TOKEN');
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $get_baby_details_from_his, [
            'json' => [
                'username' => 'nicu',
                'password' => 'nicu@123',
                'branchId' => $settings->hms_branch_id,
                'organizationId' => $settings->hms_organization_id,
            ]
        ]);        

        $response_data = $response->getBody();
        $response_data = $response_data->getContents();

        $response_data = json_decode($response_data);

        if (isset($response_data->token)) {
            $token_updated_time = Carbon::now($this->time_zone);
            \DB::table('site_settings')->where('SiteId', 1)->update(['hms_token'=> $response_data->token, 'hms_token_modify_tstamp'=> $token_updated_time]);
            $this->custom_error->emergencyLog('HMS Token updated at : ' . $token_updated_time);            
        } else {
            $this->custom_error->emergencyLog('ERROR: HMS Token not updated at : ' . $token_updated_time);
        }

    }
    
    /**
     * This method to register patient HMS
     * We send the ward, room and bed details
     * If patient is already register we send the MRN
     */
    public function registerPatientInHMS(Request $request) {

        $input = $request->all();

        if (isset($input['hward_name']) && isset($input['hroom_name']) && isset($input['hbed_name'])) {

            $mrn = (isset($input['baby_mrn']) && !empty($input['baby_mrn'])) ? $input['baby_mrn'] : null;

            $gender = (isset($input['gender']) && !empty($input['gender'])) ? $input['gender'] : null;
            $age = (isset($input['age']) && !empty($input['age'])) ? $input['age'] : 0;

            $get_baby_details_from_his = \SiteHelpers::getConfigSettings('HMS_PATIENT_REGISTRATION');

            $client = new \GuzzleHttp\Client();

            $settings = Settings::find(1);

            if (isset($settings->hms_token) && isset($settings->hms_primary_consultant_id) && $settings->hms_secondary_consultant_id) {

                $json_content = [
                    'wardId' => $input['hward_name'],
                    'roomId' => $input['hroom_name'],
                    'bedId' => $input['hbed_name'] > 9 ? $input['hbed_name'] : '0'.$input['hbed_name'],
                    'mrn' => $mrn,
                    'gender' => $gender, 
                    'age' => $age,
                    'primaryConsultantId' => $settings->hms_primary_consultant_id,
                    'secondaryConsultantId' => $settings->hms_secondary_consultant_id,
                ];

                $this->custom_error->emergencyLog('HMS Patient Registration JSON content - ' . json_encode($json_content) . ' at ' . Carbon::now($this->time_zone));

                $header_content = [
                    'Content-Type' => 'application/json',
                    'token' => $settings->hms_token,
                ];

                $response = $client->post($get_baby_details_from_his, [
                    'json' => $json_content,
                    'headers' => $header_content,
                    'http_errors' => false
                ]);

                $response_data = $response->getBody();
                $response_data = $response_data->getContents();
                $response_data = json_decode($response_data);

                $this->custom_error->emergencyLog('HMS Patient Registration received response - ' . json_encode($response_data) . ' at ' . Carbon::now($this->time_zone));

                if ($response_data == null) {
                    return \Response::json(['type' => 'error', 'message' => 'Contact Admin.'], 200);                    
                }

                if (isset($response_data->type)) {
                    return \Response::json(['type' => $response_data->type, 'message' => $response_data->message], 200);
                } else {

                    if (isset($response_data->mrn) && !empty($response_data->mrn) && isset($response_data->visitNumber) && !empty($response_data->visitNumber)) {

                        $check_mrn = Baby::get_baby_by_mrn($response_data->mrn);

                        if (!isset($check_mrn->BabyId)) {

                            $mother['MotherName'] = isset($response_data->name) ? $response_data->name : null;
                            $mother['DateAdded'] = Carbon::now($this->time_zone);
                            $mother['UserAdded'] = 0;
                            $mother_id = Mother::create($mother)->MotherId;

                            $this->custom_error->emergencyLog('At the time of "HMS Patient Registration" - Mother id :' . $mother_id);

                            if (isset($mother_id)) {

                                $baby['MotherId'] = $mother_id;
                                $baby['BMrNo'] = (isset($response_data->mrn) && !empty($response_data->mrn)) ? $response_data->mrn : null;
                                $baby['BabyName'] = (isset($response_data->name) && !empty($response_data->name)) ? $response_data->name : null;
                                $baby['DOB'] = (isset($response_data->dob) && !empty($response_data->dob)) ? date('Y-m-d', strtotime($response_data->dob)) : null;
                                $baby['Sex'] = (isset($response_data->gender) && !empty($response_data->gender)) ? $response_data->gender : null;
                                $baby['DateAdded'] = Carbon::now($this->time_zone);
                                $baby['UserAdded'] = 0;

                                $baby_id = Baby::create($baby)->BabyId; 

                                $this->custom_error->emergencyLog('At the time of "HMS Patient Registration" - Baby id :' . $baby_id);

                            }
                            $mrn = $baby['BMrNo'];

                        } else {

                            $mother_id = $check_mrn->MotherId;
                            $baby_id = $check_mrn->BabyId;
                            $mrn = $check_mrn->BMrNo;

                        }

                        if (isset($baby_id) && isset($mrn) && isset($mother_id)) {

                            $episodes   = Admission::where('BabyId', $baby_id)->count();
                            $episodes  += 1;
                            $admission_data = array(
                                'BabyId'        => $baby_id,
                                'BMrNo'         => $mrn,
                                'MotherId'      => $mother_id,
                                'AdmissionDate' => Carbon::now($this->time_zone)->format('Y-m-d'),
                                'AdmissionTime' => Carbon::now($this->time_zone)->format('h') . ':' . Carbon::now($this->time_zone)->format('i') . ':' . Carbon::now($this->time_zone)->format('a'),
                                'InOrOut'       => 'In',
                                'AdmissionType' => 'NICU',
                                'Status'        => "Inpatient",
                                'UserAdded'     => 0,
                                'DateAdded'     => Carbon::now($this->time_zone)->format('Y-m-d'),
                                'DateModified'  => Carbon::now($this->time_zone)->format('Y-m-d'),
                                'episodes'      => 'Admission ' . $episodes,
                            );

                            $admission = Admission::create($admission_data)->AdmissionId;

                            $this->custom_error->emergencyLog('At the time of "HMS Patient Registration" - Admission id :' . $admission);

                        }

                        if ($input['ward_name'] == '1' && isset($baby_id)) {                        
                            $input['BabyId'] = $baby_id;
                            $input['BMrNo'] = $mrn;
                            $input['AdmissionId'] = $admission;
                            $input['MotherId'] = $mother_id;
                            $input['AdmissionDate'] = Carbon::now($this->time_zone)->format('Y-m-d');
                            $input['AdmissionTime'] = Carbon::now($this->time_zone)->format('h');
                            $input['AdmissionTime_MINS'] = Carbon::now($this->time_zone)->format('i');
                            $input['AdmissionTime_AM'] = Carbon::now($this->time_zone)->format('A');
                            $input['status'] = 'Inpatient';
                            $input['UserAdded'] = '0';
                            $input['DateAdded'] = Carbon::now($this->time_zone)->format('Y-m-d');
                            $nicu = Nicu::create($input)->NicuId;

                            $this->custom_error->emergencyLog('At the time of "HMS Patient Registration" - NICU id :' . $nicu);

                        }

                        if (isset($input['ward_name']) && isset($input['room_no']) && isset($input['bed_no']) && isset($baby_id)) {

                            $ward['ward_id']      = $input['ward_name'];
                            $ward['ward_name']    = \SiteHelpers::gettable_values('ward', 'name', 'id', $input['ward_name']) ;
                            $ward['room_id']      = $input['room_no'];
                            $ward['room_no']      = \SiteHelpers::gettable_values('room', 'number', 'id', $input['room_no']);
                            $ward['bed_id']       = $input['bed_no'];
                            $ward['bed_no']       = \SiteHelpers::gettable_values('bed', 'number', 'id', $input['bed_no']);;
                            $ward['baby_id']      = $baby_id;
                            $ward['admission_id'] = (isset($admission) && !empty($admission)) ? $admission : 0;
                            $ward['DateAdded']    = Carbon::now($this->time_zone)->format('Y-m-d h:i a');
                            $ward['UserAdded']    = 0;
                            $ward['DateModified'] = Carbon::now($this->time_zone)->format('Y-m-d h:i a');
                            $ward['UserModified'] = 0;
                            $ward['IsDeleted']    = 0;

                            Bed::where('id', $input['bed_no'])->update(['status'=>'Occupied']);
                            $ward['status']       = 'Occupied';

                            $patient_bed_log = BedLog::create($ward)->id;

                            $this->custom_error->emergencyLog('At the time of "HMS Patient Registration" - Patient Bed Log id :' . $patient_bed_log);

                        }

                        if (isset($response_data->visitNumber) && !empty($response_data->visitNumber)) {

                            $ip_number['baby_id']      = $baby_id;
                            $ip_number['ip_number']    = $response_data->visitNumber;
                            $ip_number['status']       = 1;
                            $ip_number['DateAdded']    = Carbon::now($this->time_zone)->format('Y-m-d');
                            $ip_number['AdmissionId']  = $admission;

                            $ip_id = IpNumber::create($ip_number)->id;

                            $this->custom_error->emergencyLog('At the time of "HMS Patient Registration" - IP number table primary key id :' . $ip_id);

                        }

                        $nurse_sheet = array(
                            'day_name' => 'Day 1',
                            'sheet_date' => date('Y-m-d'),
                            'baby_id' => $baby_id,
                            'admission_id' => $admission,
                        );

                        $check_main_sheet = \DB::table('nurse_main_sheet')
                        ->where('baby_id', $baby_id)
                        ->where('admission_id', $admission)
                        ->where('sheet_date', date('Y-m-d'))
                        ->count();

                        if ($check_main_sheet == 0) {

                            $main_sheet_id = NurseSheetMain::create($nurse_sheet)->id;
                            
                            $this->custom_error->emergencyLog('At the time of "HMS Patient Registration" - Nurse main sheet primary key id :' . $main_sheet_id);

                            $patient_log['day_id'] = $main_sheet_id;
                            $patient_log['bed_id'] = $input['bed_no'];
                            $patient_log['created_date_time'] = Carbon::now($this->time_zone);
                            $patient_log['created_by'] = 0;

                            $day_wise_patient_bed_log = DayWisePatientBedLog::create($patient_log)->id;

                            $this->custom_error->emergencyLog('At the time of "HMS Patient Registration" - Day wise patient bed log primary key id :' . $day_wise_patient_bed_log);

                        }

                        \SiteHelpers::updateDashboardAtFormUpdation($baby_id, 'Quick Registration');

                        $event_input['admission_id'] = $admission;
                        $event_input['status'] = 'QADMISSION';
                        ErrorLogController::emergencyLogStat('HMS q admission ' . json_encode($event_input));
                        broadcast(new WardEvent($event_input))->toOthers();

                        return \Response::json(['type' => 'success', 'message' => 'Registration successfully completed.', 'admission_id' => $admission], 200);

                    }

                }

            } else {
                $this->custom_error->emergencyLog('Qiuck Reg - Problem in site settings table at ' . Carbon::now($this->time_zone));
            }

        } else {
            $this->custom_error->emergencyLog('Invalid date at ' . Carbon::now($this->time_zone));
        }

    }

    /**
     * This method to transfer patient HMS
     * We send the mrn, ip_number, ward, room and bed details
     */
    public static function transferPatientInHMS(Request $request) {

        $input = $request->all();

        if (isset($input['bed_mrno']) && isset($input['bed_ipnumber']) && isset($input['hms_bed_id']) && isset($input['hms_room_id']) && isset($input['hms_ward_id'])) {

            $get_baby_details_from_his = \SiteHelpers::getConfigSettings('HMS_PATIENT_TRANSFER');
            $client = new \GuzzleHttp\Client();

            $settings = Settings::find(1);

            if (isset($settings->hms_token)) {

                $json_content = [
                    'mrn' => $input['bed_mrno'],
                    'ipNumber' => $input['bed_ipnumber'],
                    'transferBedId' => $input['hms_bed_id'] > 9 ? $input['hms_bed_id'] : '0'.$input['hms_bed_id'],
                    'transferRoomId' => $input['hms_room_id'],
                    'transferWardId' => $input['hms_ward_id']
                ];

                ErrorLogController::emergencyLogStat('HMS Patient Transfer JSON content - ' . json_encode($json_content) . ' at ' . Carbon::now());

                $header_content = [
                    'Content-Type' => 'application/json',
                    'token' => $settings->hms_token
                ];

                $response = $client->post($get_baby_details_from_his, [
                    'json' => $json_content,
                    'headers' => $header_content,
                    'http_errors' => false
                ]);

                $response_data = $response->getBody();
                $response_data = $response_data->getContents();
                $response_data = json_decode($response_data);

                ErrorLogController::emergencyLogStat('HMS Patient Transfer received response - ' . json_encode($response_data) . ' at ' . Carbon::now());

                if (isset($input['manually']) && $input['manually']) {
                    return \Response::json(['type' => 'success', 'message' => 'Transfer successfully completed.'], 200);
                }

            } else {
                $this->custom_error->emergencyLog('Patient Transfer - Problem in site settings table at ' . Carbon::now($this->time_zone));
                if (isset($input['manually']) && $input['manually']) {
                    return \Response::json(['type' => 'error', 'message' => 'Transfer Failed.'], 200);
                }
            }

        } else {
            ErrorLogController::emergencyLogStat('Transfer Failed - ' . json_encode($input) . ' at ' . Carbon::now());
            if (isset($input['manually']) && $input['manually']) {
                return \Response::json(['type' => 'error', 'message' => 'Transfer Failed.'], 200);
            }
        }

        return true;

    }

    /**
     * This method to get unknown baby details
     * We send the mrn
     */
    public static function updateQuickRegBabyDetails(Request $request)
    {
        $baby_details  = $request->input('mrn');

        ErrorLogController::emergencyLogStat('HMS Patient Details BabyId - ' . $baby_details . ' at ' . Carbon::now());

        $get_baby_details_from_his = \SiteHelpers::getConfigSettings('GET_PATIENT_INFO_FROM_HIS');
        $client = new \GuzzleHttp\Client();
        $settings = Settings::find(1);

        if (isset($settings->hms_token)) {

            $header_content = [
                'Content-Type' => 'application/json',
                'token' => $settings->hms_token,
            ];

            $response = $client->get($get_baby_details_from_his, [
                'headers' => $header_content,
                'query' => ['uhid' => trim($baby_details)],
                'http_errors' => false
            ]);

            $patient_response = $response->getBody();
            $patient_response = $patient_response->getContents();


            ErrorLogController::emergencyLogStat('HMS - Get Baby Details received response - ' . json_encode($patient_response) . ' at ' . Carbon::now());

            $patient_response = collect(json_decode($patient_response))->toArray();

            $result = [];

            $baby_info = Baby::get_baby_by_mrn($baby_details);
            $result['baby_id'] = isset($baby_info->BabyId) ? $baby_info->BabyId : null;
            $result['mother_id'] = isset($baby_info->MotherId) ? $baby_info->MotherId : null;
            $result['baby_name'] = isset($baby_info->BabyName) ? $baby_info->BabyName : null;

            if (!isset($patient_response->data) && $patient_response['message'] != 'success') {
                return '0';
            }
            else
            { 
                $data = $patient_response['data'];

                if (isset($data->salutation) && !empty($data->salutation)) {
                    $baby_details_found = strtolower(substr($data->salutation, 0, 1)) === "b";
                    if (! $baby_details_found) {
                        $baby_details_found = strtolower(substr($data->salutation, 0, 1)) === "m";
                    }
                    if ($baby_details_found) {

                        $patient_data = $data;

                        $baby = Baby::findOrfail($result['baby_id']);

                        // $baby_detail['BabyName'] = $patient_data->salutation . ' ' . $patient_data->patient_name;
                        $salutation = $patient_data->salutation;
                        if ($salutation == 'BABY OF.') {
                            $salutation = 'B/O';
                        }
                        $baby_detail['BabyName'] = $salutation . ' ' .ucfirst(strtolower($patient_data->patient_name)).' '.ucfirst(strtolower(str_replace(["S/O.", "S/O", "D/O.", "D/O"], "", $patient_data->surname)));

                        $default_name = \Config::get('constants.HIS_QUICK_REG_BABY_NAME');
                        $default_name = strtolower($default_name);

                        if (str_contains(strtolower($result['baby_name']), $default_name) && $result['baby_name'] != $baby_detail['BabyName']) {

                            $baby_admission_details = Admission::select('MotherId', 'BabyId', 'AdmissionId')->where('BabyId', $result['baby_id'])->orderBy('AdmissionId', 'desc')->first();

                            $patient_bed_log = BedLog::where('baby_id', $baby_admission_details->BabyId)->where('admission_id', $baby_admission_details->AdmissionId)->where('status', 'Occupied')->orderBy('id', 'desc')->first();

                            ErrorLogController::emergencyLogStat('HMS Patient Details - Patient bed details - ' . json_encode($patient_bed_log) . ' at ' . Carbon::now());

                            if (isset($patient_bed_log->bed_id)) {
                                $syringepump['baby_id']          = $baby_admission_details->BabyId;
                                $syringepump['mother_id']        = $baby_admission_details->MotherId;
                                $syringepump['admission_id']     = $baby_admission_details->AdmissionId;
                                $syringepump['admission_stauts'] = 0;
                                $syringepump['pump_modal'] = $patient_bed_log->pump_type;
                                SyringePumpAdmisson::create($syringepump);
                                PrescriptionToMirthController::admission();
                                ErrorLogController::emergencyLogStat('HMS Patient Details - Pump admission created at ' . Carbon::now());
                            }
                            
                        }

                        $baby_detail['DOB'] = $patient_data->birth_date != '' ? date('Y-m-d', strtotime($patient_data->birth_date)) : null;
                        $baby_detail['Sex'] = ucwords(strtolower($patient_data->sex));
                        $blood_group = $patient_data->blood_group;

                        if (strpos($blood_group, "+") || strpos($blood_group, "P") || strpos($blood_group, "p")) {
                            $group = explode('+', $blood_group)[0];
                            if (strlen($group) <= 3) {
                                $baby_detail['BabyBloodGroup'] = strtoupper($group) . ' Positive';
                            }
                        }
                        if (strpos($blood_group, "-") || strpos($blood_group, "N") || strpos($blood_group, "n")) {
                            $group = explode('-', $blood_group)[0];
                            if (strlen($group) <= 3) {
                                $baby_detail['BabyBloodGroup'] = strtoupper($group) . ' Negative';
                            }
                        }
                        $baby_detail['UserModified'] = 0;
                        $baby_detail['DateModified'] = Carbon::now();

                        ErrorLogController::emergencyLogStat('HMS Patient Details - Baby details updated content - ' . json_encode($baby_detail) . ' at ' . Carbon::now());

                        $baby->update($baby_detail);

                        $mother = Mother::findOrfail($result['mother_id']);

                        $mother_details['MotherName'] = $patient_data->patient_name;
                        $mother_details['PartnerName'] = $patient_data->surname;
                        $mother_details['Address1'] = $patient_data->address1;
                        $mother_details['Address2'] = $patient_data->address2;
                        $mother_details['Address3'] = $patient_data->address3;
                        $mother_details['City'] = $patient_data->city;
                        $mother_details['Address4'] = $patient_data->pincode;
                        $mother_details['Mobile'] = $patient_data->mobile;
                        $mother_details['PartnerMobile'] = $patient_data->phone;
                        $mother_details['UserModified'] = 0;
                        $mother_details['DateModified'] = Carbon::now();

                        ErrorLogController::emergencyLogStat('HMS Patient Details - Mother details updated content - ' . json_encode($mother_details) . ' at ' . Carbon::now());

                        $mother->update($mother_details);

                        $baby_detail['DOB'] = $baby_detail['DOB'] != null ? date('d-m-Y' , strtotime($baby_detail['DOB'])) : '00-00-0000';

                        $event_input['baby_name'] = $baby_detail['BabyName'];
                        $event_input['baby_mrn'] = $baby_info->BMrNo;
                        $event_input['status'] = 'EDIT';
                        ErrorLogController::emergencyLogStat('Baby Details update ' . json_encode($event_input));
                        broadcast(new WardEvent($event_input))->toOthers();
                        \SiteHelpers::updateDashboardAtFormUpdation($result['baby_id'], 'Quick Reg Baby Details - update');

                        return \Response::json(['type' => 'success', 'message' => 'Updated successfully.', 'baby_name' => $baby_detail['BabyName'], 'baby_mrn' => $baby_info->BMrNo], 200);
                    }
                }

            }
        } else {
            $this->custom_error->emergencyLog('Quick Reg Baby Details Fetching - Problem in site settings table at ' . Carbon::now($this->time_zone));
        }

    }

    /**
     * This method to get baby details
     * We send the mrn
     */
    public static function getBabyDetails(Request $request)
    {
        $baby_details  = $request->input('mrn');

        ErrorLogController::emergencyLogStat('HMS - Get Baby Details MRN - ' . $baby_details . ' at ' . Carbon::now());

        $get_baby_details_from_his = \SiteHelpers::getConfigSettings('GET_PATIENT_INFO_FROM_HIS');
        $client = new \GuzzleHttp\Client();

        $settings = Settings::find(1);
        
        if (isset($settings->hms_token)) {

            $header_content = [
                'Content-Type' => 'application/json',
                'token' => $settings->hms_token,
            ];

            $response = $client->get($get_baby_details_from_his, [
                'headers' => $header_content,
                'query' => ['uhid' => trim($baby_details)],
                'http_errors' => false
            ]);

            $patient_response = $response->getBody();
            $patient_response = $patient_response->getContents();

            ErrorLogController::emergencyLogStat('HMS - Get Baby Details received response - ' . json_encode($patient_response) . ' at ' . Carbon::now());

            $patient_response = collect(json_decode($patient_response))->toArray();

            $result = [];

            $baby_info = Baby::get_baby_by_mrn($baby_details);
            $result['baby_id'] = isset($baby_info->BabyId) ? $baby_info->BabyId : null;
            $result['mother_id'] = isset($baby_info->MotherId) ? $baby_info->MotherId : null;

            if (!isset($patient_response->data) && $patient_response['message'] != 'success') {
                return '0';
            }
            else
            { 
                $data = $patient_response['data'];

                if (isset($data->salutation) && !empty($data->salutation)) {
                    $baby_details_found = strtolower(substr($data->salutation, 0, 1)) === "b";
                    if (! $baby_details_found) {
                        $baby_details_found = strtolower(substr($data->salutation, 0, 1)) === "m";
                    }
                    if ($baby_details_found) {
                        $patient_data = $data;

                        $result['name'] = $patient_data->salutation . ' ' . $patient_data->patient_name . ' ' .$patient_data->surname;
                        $result['dob'] = date('d-m-Y' , strtotime($patient_data->birth_date));
                        $result['sex'] = ucwords(strtolower($patient_data->sex));
                        $blood_group = $patient_data->blood_group;

                        if (strpos($blood_group, "+") || strpos($blood_group, "P") || strpos($blood_group, "p")) {
                            $group = explode('+', $blood_group)[0];
                            if (strlen($group) <= 3) {
                                $result['blood_group'] = strtoupper($group) . ' Positive';
                            }
                        }
                        if (strpos($blood_group, "-") || strpos($blood_group, "N") || strpos($blood_group, "n")) {
                            $group = explode('-', $blood_group)[0];
                            if (strlen($group) <= 3) {
                                $result['blood_group'] = strtoupper($group) . ' Negative';
                            }
                        }
                        $result['mothername'] = $patient_data->patient_name;
                        $result['partername'] = $patient_data->surname;
                        $result['address1'] = $patient_data->address1;
                        $result['address2'] = $patient_data->address2;
                        $result['address3'] = $patient_data->address3;
                        $result['city'] = $patient_data->city;
                        $result['pincode'] = $patient_data->pincode;
                        $result['mobile'] = $patient_data->mobile;
                        $result['phone'] = $patient_data->phone;
                    }
                }

                return $result;
            }

        } else {
            $this->custom_error->emergencyLog('Baby Details - Problem in site settings table at ' . Carbon::now($this->time_zone));
        }

    }

    /**
     * This method to get mother details
     * We send the mrn
     */
    public function getMotherDetails(Request $request)
    {
        $baby_details  = $request->input('mrn');

        ErrorLogController::emergencyLogStat('HMS - Get Mother Details MRN - ' . $baby_details . ' at ' . Carbon::now());

        $get_baby_details_from_his = \SiteHelpers::getConfigSettings('GET_PATIENT_INFO_FROM_HIS');
        $client = new \GuzzleHttp\Client();

        $settings = Settings::find(1);
        
        if (isset($settings->hms_token)) {

            $header_content = [
                'Content-Type' => 'application/json',
                'token' => $settings->hms_token,
            ];

            $response = $client->get($get_baby_details_from_his, [
                'headers' => $header_content,
                'query' => ['uhid' => trim($baby_details)],
                'http_errors' => false
            ]);

            $patient_response = $response->getBody();
            $patient_response = $patient_response->getContents();

            ErrorLogController::emergencyLogStat('HMS - Get Mother Details received response - ' . json_encode($patient_response) . ' at ' . Carbon::now());

            $patient_response = collect(json_decode($patient_response))->toArray();

            $result = [];

            if (!isset($patient_response->data) && $patient_response['message'] != 'success') {
                return '0';
            }
            else
            { 
                $data = $patient_response['data'];

                if (isset($data->salutation) && !empty($data->salutation)) {
                    $baby_details_found = strtolower(substr($data->salutation, 0, 1)) === "b";
                    $patient_data = $data;                    
                    $result['mothername'] = $patient_data->patient_name;
                    $result['address1'] = $patient_data->address1;
                    $result['address2'] = $patient_data->address2;
                    $result['address3'] = $patient_data->address3;
                    $result['address3'] = $patient_data->address3;
                    $result['city'] = $patient_data->city;
                    $result['pincode'] = $patient_data->pincode;
                    $result['mobile'] = $patient_data->mobile;
                    $result['phone'] = $patient_data->phone;
                    if (!$baby_details_found) {
                        $result['mothertitle'] = $patient_data->salutation;
                        $result['partername'] = $patient_data->surname;
                        $result['dob'] = date('d-m-Y' , strtotime($patient_data->birth_date));
                        $result['sex'] = ucwords(strtolower($patient_data->sex));
                        $blood_group = $patient_data->blood_group;

                        if (strpos($blood_group, "+") || strpos($blood_group, "P") || strpos($blood_group, "p")) {
                            $group = explode('+', $blood_group)[0];
                            if (strlen($group) <= 3) {
                                $result['blood_group'] = strtoupper($group) . ' Positive';
                            }
                        }
                        if (strpos($blood_group, "-") || strpos($blood_group, "N") || strpos($blood_group, "n")) {
                            $group = explode('-', $blood_group)[0];
                            if (strlen($group) <= 3) {
                                $result['blood_group'] = strtoupper($group) . ' Negative';
                            }
                        }
                    }
                }
                return $result;
            }
        } else {
            $this->custom_error->emergencyLog('Mother Details - Problem in site settings table at ' . Carbon::now($this->time_zone));
        }

    }


    /*This method is used for testing INtegration with HIS*/
    public function liveBabyIntegrationTest()
    {
        $visit_number_url = \SiteHelpers::getConfigSettings('GET_CURRENT_VISIT_NUMBER');
        
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $visit_number_url.'552670');
        $visit_response = $response->getBody();
        $visit_response = $visit_response->getContents();
        $visit_response = collect(json_decode($visit_response)->data)->toArray();

        if ($visit_response[0]->visit_type == 'IP') {
            $ip_number = $visit_response[0]->visit_no;
            $admission_time = $visit_response[0]->admission_time;
        }

        if ($ip_number != '' && !is_null($ip_number)) {

            // $admission_old = Admission::where('BabyId', $baby_id)->count();
            // $admission_old = $admission_old + 1;
            // $admission["BMrNo"] = $bmr_no;
            // $admission["MotherId"] = $mother_id;
            // $admission["BabyId"] = $baby_id;
            if (isset($admission_time) && !empty($admission_time)) {
                $admission["AdmissionDate"] = date('Y-m-d', strtotime($admission_time));
                $admission["AdmissionTime"] = date('H:i:s', strtotime($admission_time));
            }
            else
            {
                $admission["AdmissionDate"] = Carbon::now()->format('Y-m-d');
                $admission["AdmissionTime"] = Carbon::now()->format('H:i:s');
            }
            $admission["InOrOut"] = 'In';
            $admission["AdmissionType"] = 'NICU';
            $admission["Status"] = 'Inpatient';
            $admission["UserAdded"] = '8';
            $admission["DateAdded"] = Carbon::now();
            $admission["DateModified"] = Carbon::now();
            $nicu_admission = array(
                // 'BabyId' => $baby_id,
                // 'BMrNo' => $bmr_no,
                // 'AdmissionId' => $admission_id,
                // 'MotherId' => $mother_id,
                'AdmissionDate' => (isset($admission_time) && !empty($admission_time)) ? date('Y-m-d', strtotime($admission_time)) : date('Y-m-d'),
                'AdmissionTime' => (isset($admission_time) && !empty($admission_time)) ? date('h', strtotime($admission_time)) : date('h'),
                'AdmissionTime_MINS' => (isset($admission_time) && !empty($admission_time)) ? date('i', strtotime($admission_time)) : date('i'),
                'AdmissionTime_AM' => (isset($admission_time) && !empty($admission_time)) ? date('A', strtotime($admission_time)) : date('A'),
                'status' => 'Inpatient'
            );
            echo "<pre>"; print_r($admission);
            echo "<pre>"; print_r($nicu_admission); exit;
        }
        // return $admission_id;
    }

    /**
     * This method to get visit number for hms     
     */
    public function getVisitNumber(Request $request)
    {
        $input = $request->all();
        $url = '';

        if (!isset($input['visit_from']) || (isset($input['visit_from']) && $input['visit_from'] == '')) {
            // Check if the baby already have the visit entry for the selected date
            if ($input['visit_type'] == 'OP') {
                if ($input['module_name'] == 'neonatal_op') {
                    $result = \DB::table('op_details')->select('OpId as id')->where('BMrNo', $input['mrn'])->where('OpDate', date('Y-m-d', strtotime($input['visit_date'])))->where('IsDeleted', 0)->first();
                    if (isset($result->id)) {
                        return ['url' => action('Registration\OpController@edit', \SiteHelpers::encrypt_id($result->id))];
                    }
                } elseif ($input['module_name'] == 'neuro_op') {
                    $result = \DB::table('neuro_visit_details')->select('id')->where('mrn', $input['mrn'])->where('visit_date', date('Y-m-d', strtotime($input['visit_date'])))->where('is_deleted', 0)->first();
                    if (isset($result->id)) {
                        return ['url' => action('Registration\NeuroController@edit', \SiteHelpers::encrypt_id($result->id))];
                    }
                } elseif ($input['module_name'] == 'pediatric_op') {
                    $result = \DB::table('op_pediatric_details')->select('id')->leftjoin('baby', 'baby_id', 'BabyId')->where('BMrNo', $input['mrn'])->where('op_date', date('Y-m-d', strtotime($input['visit_date'])))->where('is_deleted', 0)->first();
                    if (isset($result->id)) {
                        return ['url' => action('Registration\PediatricOpController@edit', \SiteHelpers::encrypt_id($result->id))];
                    }
                }
            } else {
                if ($input['module_name'] == 'postnatal_admission') {
                    $result = \DB::table('postnatal_admission')->select('pid as id', 'ip_numbers.ip_number')->leftjoin('ip_numbers', 'postnatal_admission.AdmissionId', 'ip_numbers.AdmissionId')->where('BMrNo', $input['mrn'])->where('admission_date', date('Y-m-d', strtotime($input['visit_date'])))->where('IsDeleted', 0)->first();
                    if (isset($result->id) && !empty($result->ip_number)) {
                        $url = action('Admission\PostnatalController@edit', \SiteHelpers::encrypt_id($result->id));
                    }
                } else if ($input['module_name'] == 'nicu_admission') {
                    $result = \DB::table('nicu_admission')->select('NicuId as id')->where('BMrNo', $input['mrn'])->where('AdmissionDate', date('Y-m-d', strtotime($input['visit_date'])))->where('IsDeleted', 0)->first();
                    if (isset($result->id)) {
                        $url = action('Admission\NicuController@edit', \SiteHelpers::encrypt_id($result->id));
                    }
                }
            }
        }

        if (isset($input['mrn']) && isset($input['visit_date']) && isset($input['visit_type']) && ($input['module_name'] != 'neuro_op' || ($input['module_name'] == 'neuro_op' && $input['visit_from'] != '')) && $input['module_name'] != 'bayley_op') {

            $settings = Settings::find(1);
            $visit_number_url = \SiteHelpers::getConfigSettings('GET_HMS_PATIENT_VISIT_NUMBER');
            $client = new \GuzzleHttp\Client();
            $header_content = [
                'Content-Type' => 'application/json',
                'token' => $settings->hms_token,
            ];

            // OP
            $pediatric_consultant_id = $settings->hms_primary_consultant_id;
            $neonatal_consultant_id = $settings->hms_secondary_consultant_id;
            $neuro_consultant_id = $settings->hms_neuro_consultant_id;

            $header_content = [
                'Content-Type' => 'application/json',
                'token' => $settings->hms_token,
            ];

            $json_content = [
                'uhid' => trim($input['mrn']),
                'date' => date('Y-m-d', strtotime($input['visit_date'])),
                'visitType' => $input['visit_type']
            ];

            if ($input['visit_type'] == 'OP') {
                if ($input['module_name'] == 'neonatal_op') {
                    $json_content['doctorId'] = $neonatal_consultant_id;
                } elseif ($input['module_name'] == 'neuro_op') {
                    if ($input['visit_from'] == 'ip') {
                        $json_content['visitType'] = 'IP';
                    } else {
                        $json_content['doctorId'] = $input['visit_from'];
                    }

                } elseif ($input['module_name'] == 'pediatric_op') {
                    $json_content['doctorId'] = $pediatric_consultant_id;
                }
            }

            $this->custom_error->emergencyLog('HMS Visit Number JSON content - ' . json_encode($json_content) . ' at ' . Carbon::now($this->time_zone));

            $response = $client->post($visit_number_url, [
                'json' => $json_content,
                'headers' => $header_content,
                'http_errors' => false
            ]);

            $response_data = $response->getBody();
            $response_data = $response_data->getContents();
            $status_code = $response->getStatusCode();

            if ($response_data == null) {
                return \Response::json(['type' => 'error', 'message' => 'Contact Admin.', 'url'=>$url], 200);                    
            }
            if ($status_code != 200) {
                $response_data = json_decode($response_data);
                $this->custom_error->emergencyLog('HTTP ERROR for quering visit info from web HIS for MRN :'.$input['mrn'].'add received response - ' . json_encode($response_data));
                return \Response::json(['type' => 'error', 'message' => 'Contact Admin.', 'url'=>$url], $status_code);                    
            } else {
                $this->custom_error->emergencyLog('HMS Visit Number received response - ' . $response_data . ' at ' . Carbon::now($this->time_zone));
            }
            return \Response::json(['type' => 'success', 'message' => $response_data, 'url'=>$url], 200);

        }
        return null;

    }

    public static function updateQuickReg(Request $request)
    {
        $baby_details  = $request->input('mrn');

        ErrorLogController::emergencyLogStat('HMS Patient Details BabyId - ' . $baby_details . ' at ' . Carbon::now());

        $get_baby_details_from_his = \SiteHelpers::getConfigSettings('GET_PATIENT_INFO_FROM_HIS');
        $client = new \GuzzleHttp\Client();
        $settings = Settings::find(1);

        if (isset($settings->hms_token)) {

            $header_content = [
                'Content-Type' => 'application/json',
                'token' => $settings->hms_token,
            ];

            $response = $client->get($get_baby_details_from_his, [
                'headers' => $header_content,
                'query' => ['uhid' => trim($baby_details)],
                'http_errors' => false
            ]);

            $patient_response = $response->getBody();
            $patient_response = $patient_response->getContents();

            ErrorLogController::emergencyLogStat('HMS - Get Baby Details received response - ' . json_encode($patient_response) . ' at ' . Carbon::now());
            return $patient_response;

        }

    }
}
