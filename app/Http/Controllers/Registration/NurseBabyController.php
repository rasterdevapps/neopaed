<?php namespace App\Http\Controllers\Registration;

use Carbon\Carbon;
use App\Models\Mother;
use App\Models\Baby as Baby;
use App\Models\Settings\Settings;
use App\Models\Settings\DeleteApproval;
use Illuminate\Contracts\Auth\Guard;
use App\Models\IpNumber;
use App\Models\Neonatal;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\BabyRequest;
use App\Http\Controllers\Flow\FlowController;
use App\Http\Controllers\Errors\ErrorLogController;
use App\Models\Admission;
use App\Models\Ward\BedLog;
use App\Models\Masters\Ward;
use App\Models\Masters\Room;
use App\Models\Masters\Bed;
use App\Models\Nicu;
use App\Models\Postnatal;
use App\Models\PostnatalDischarge;
use App\Events\WardEvent;

class NurseBabyController extends Controller
{
   /**
    * 
    *@var  $baby_check 
    */
    public $baby_check ;

      /**
    * @var $custom_error type object
    */
    public $custom_error;
    
    /**
     *Class constructor 
     *
     */
    public function  __construct(Guard $auth, FlowController $flow, ErrorLogController $custom_error)
    {
        $this->middleware('role:BABY_REG,write', ['only' => ['store', 'update', 'edit', 'create', 'destory']]);
        $this->middleware('role:BABY_REG,read', ['only' => ['index', 'show']]);
        $this->auth = $auth; 
        $this->flow = $flow; 
        $this->custom_error = $custom_error;
        $this->time_zone = env('TIME_ZONE');

   
    }


    /**
     * Show the form for creating a new baby.
     *
     */
    public function create($id = 0)
    {
        $id = \SiteHelpers::decrypt_id($id);
        // Assing Menu section
        $navigate['main_nav'] = 'register';
        $navigate['sub_nav']  = 'baby';

        $multiple_pregnancy = 'No';
        $no_of_babies = '1';
        $MultiplePregnancyType = '';


        if ($id == 0 && \Session::has('nurse_entry_multiple_pregnancy') && \Session::get('nurse_entry_no_of_babies') != '0' && \Session::has('nurse_entry_baby_group_id')) {
           $baby = Baby::find(\Session::get('nurse_entry_baby_group_id'));

           if (isset($baby->MotherId) && count($baby) > 0) {

                $id = $baby->MotherId;
                $multiple_pregnancy = 'Yes';
                $MultiplePregnancyType = $baby->MultiplePregnancyType;
                $no_of_babies = $baby->Noofbabies;

           } else {
               $this->custom_error->emergencyLog('issue in no of babies with multiple pregnancy in baby create issue');
               throw new \InvalidInputException("Invalid baby count found");
           }

        } elseif (\Session::has('nurse_entry_multiple_pregnancy') && \Session::get('nurse_entry_no_of_babies') == '0') {
            $this->custom_error->emergencyLog('issue in no of babies with multiple pregnancy in baby create issue');
            throw new \InvalidInputException("Invalid baby count found");
        }

        // Get Mother data from mother models
        $mothers = Mother::GetData($id);
        // Prepare Baby name
        foreach ($mothers as $data) {
            $babyname = 'B/O ' . $data->MotherName . ' ' . $data->PartnerName;
        }

        // Prepare the time array
        $tob = \SiteHelpers::prepare_time();

        // Get Site config values
        $sitesetting = Settings::get_record();
        $sitesetting = $sitesetting[0];
      /*  do {
            $mrno = Settings::GenerateMMR();
        } while (Settings::ValidateMMR($mrno));*/
        $bmrno = '';
        $results = array();
        $results['BirthWeight'] = 0;
        $displaystyle = '';
        $ipNumber = '';
        $ip_id    = '';

        $results['TOB_TIME'] = (int)Carbon::now(env('TIME_ZONE'))->format('h');
        $results['TOB_MINS'] = (int)Carbon::now(env('TIME_ZONE'))->format('i');
        $results['TOB_AM']   = Carbon::now(env('TIME_ZONE'))->format('A');
        $previousNeonatal    = array();

        $ward_list =  Ward::admission_ward_list()->pluck('name', 'id')->toArray();
        $room_list = array();
        $bed_list  = array();


        // if (\Session::has('nurse_entry_multiple_pregnancy') == 'Yes' && \Session::has('nurse_entry_no_of_babies') && \Session::get('nurse_entry_no_of_babies') > 1) {

        //     $SubmitButtonText = 'Next Baby';
        // } elseif (\Session::has('nurse_entry_multiple_pregnancy') == 'Yes' && \Session::has('nurse_entry_no_of_babies') && \Session::get('nurse_entry_no_of_babies') == 1) {
        //     $SubmitButtonText = 'Finish';

        // } else {
             $SubmitButtonText = 'Save';
        // }
        
        return view('nurse_registration.baby_create', compact('mothers', 'bed_list','room_list','SubmitButtonText','no_of_babies','MultiplePregnancyType','multiple_pregnancy', 'previousNeonatal', 'sitesetting', 'navigate', 'id', 'babyname', 'tob', 'results', 'bmrno', 'displaystyle', 'ipNumber', 'ward_list','ip_id'));
    }

   
    /**
     * Store a newly created baby.
     *
     * @return Response
     */
    public function store(BabyRequest $request)
    {
        
        $input = $request->all();
        $previous_visit  = Baby::getbaby_admission($input['BMrNo'], $input['ip_number']);
        $previous_baby   = Baby::where('BMrNo',$input['BMrNo'])
                               ->where('IsDeleted', 0)
                               ->first();

        // if(!\Session::has('nurse_entry_multiple_pregnancy_status') && $input['MultiplePregnancy'] == "Yes" && $input['Noofbabies'] > 1) {
        //          \Session::put('nurse_entry_multiple_pregnancy_status', true);
        //          \Session::put('nurse_entry_multiple_pregnancy', true);
        //          \Session::put('nurse_entry_no_of_babies', $input['Noofbabies']-1);
        //          \Session::put('nurse_entry_baby_order', '1');
        // }    

        $input['DOB']            = (empty($input['DOB'])) ? null : date('Y-m-d', strtotime($input['DOB']));
        $input['DateAdded']      = Carbon::now();
        $input['UserAdded']      = $this->auth->user()->id;
        $input['DateModified']   = Carbon::now();
        $input['UserModified']   = $this->auth->user()->id;
        $input['Baby_group_id']  = null;
        $input['g_weeks'] = empty($input['g_weeks']) ? null : trim($input['g_weeks']);
        $input['g_days']  = empty($input['g_days']) ?  0 : trim($input['g_days']);
       
        $input['Gestation']           = json_encode(array('g_weeks'=>$input['g_weeks'],'g_days'=>$input['g_days']));
        $input['neonatal_consultant'] = isset($input['neonatal_consultant']) ? serialize($input['neonatal_consultant']) : serialize(array());
        $input['TOB_TIME']            = (isset($input['TOB_TIME']) && !empty($input['TOB_TIME']))  ? $input['TOB_TIME'] : null ;
        $input['TOB_MINS']            = (isset($input['TOB_MINS']) && !empty($input['TOB_MINS']))  ? $input['TOB_MINS'] : null ;

        // Baby details stored in DB
        $input['Noofbabies'] = (isset($input['Noofbabies']) && !empty(trim($input['Noofbabies']))) ? $input['Noofbabies']  : null ;

        if (isset($input['MultiplePregnancy']) && $input['MultiplePregnancy'] == 'Yes') {
                
            \Session::put('nurse_entry_registration_start', true);
            \Session::put('nurse_entry_multiple_pregnancy_status', true);
            \Session::put('nurse_entry_multiple_pregnancy', true);
            if (!\Session::has('nurse_entry_no_of_babies')) {
                \Session::put('nurse_entry_no_of_babies', $input['Noofbabies']);
                \Session::put('nurse_entry_baby_order', '1');
            } 

            if(\Session::has('nurse_entry_no_of_babies') && \Session::get('nurse_entry_no_of_babies') != '0') {

                $input['BabyName'] = $input['BabyName'].'-'.str_singular($input['MultiplePregnancyType']).'-'.\Session::get('nurse_entry_baby_order');
                $input['Baby_group_id'] = (\Session::has('nurse_entry_baby_group_id') && \Session::get('nurse_entry_baby_order') != '1') ? \Session::get('nurse_entry_baby_group_id') : null;
                $baby_id = $id = Baby::create($input)->BabyId; 
                $mbfelds['Baby_group_id'] = $id; 

                if(\Session::get('nurse_entry_baby_order') == '1') {
                    \Session::put('nurse_entry_baby_group_id',$id);
                    \Session::put('nurse_entry_mother_id',$input['MotherId']);
                }

                $baby_count   = \Session::get('nurse_entry_no_of_babies') - 1;
                $current_baby = \Session::get('nurse_entry_baby_order') + 1;
                \Session::put('nurse_entry_no_of_babies', $baby_count);
                \Session::put('nurse_entry_baby_order', $current_baby);
            }
                if (\Session::get('nurse_entry_no_of_babies') == '0') {

                    \Session::forget('nurse_entry_registration_start');
                    \Session::forget('nurse_entry_multiple_pregnancy');
                    \Session::forget('nurse_entry_multiple_pregnancy_status');
                    \Session::forget('nurse_entry_mother_id');
                    \Session::forget('nurse_entry_baby_group_id');
                    \Session::forget('nurse_entry_no_of_babies');
                    \Session::forget('nurse_entry_baby_order');
                    \Session::put('nurse_entry_set_nicu_menu', true);

                }

            // } 

        } else {
           //create singtone baby 
             $input['BirthOrder'] = $input['MultiplePregnancyType'] = 'Singleton';
            if(count($previous_visit) == 0 && count($previous_baby) == 0) {
               $baby_id = $id = Baby::create($input)->BabyId; 
            } else {
                $id = $baby_id = $previous_baby->BabyId;
            }
            \Session::forget('nurse_entry_registration_start');
                    \Session::forget('nurse_entry_multiple_pregnancy');
                    \Session::forget('nurse_entry_multiple_pregnancy_status');
                    \Session::forget('nurse_entry_mother_id');
                    \Session::forget('nurse_entry_baby_group_id');
                    \Session::forget('nurse_entry_no_of_babies');
                    \Session::forget('nurse_entry_baby_order');
                    \Session::put('nurse_entry_set_nicu_menu', true);
        }

        if (\Session::has('nurse_entry_registration_start') && \Session::get('nurse_entry_no_of_babies') != 0) {

            $multiple_pregnancy_status =(\Session::has('nurse_entry_multiple_pregnancy_status')) ? 'Yes' : 'No';

            $module_complete = false;
            $this->flow->flowlog('NURSE_BABY_REG', $id, $input['MotherId'], null, $module_complete, $multiple_pregnancy_status);

        } elseif (\Session::has('nurse_entry_registration_start') && \Session::get('nurse_entry_no_of_babies') == 0) {
            $multiple_pregnancy_status =(\Session::has('nurse_entry_multiple_pregnancy_status')) ? 'Yes' : 'No';
            
            if (\Session::has('nurse_entry_multiple_pregnancy_status')) {
                 \Session::forget('nurse_entry_multiple_pregnancy_status');
            } 

            $module_complete = true;
            $this->flow->flowlog('NURSE_BABY_REG_FINISHED', $id, $input['MotherId'], null, $module_complete, $multiple_pregnancy_status);
        }

        if(count($previous_visit) == 0 ) {
            if(count($previous_baby) > 0) {
                $id = $previous_baby->BabyId;
            }

            $episodes   = Admission::where('BabyId', $id)->count();
            $episodes  += 1;
            $baby_id    = $id;
            $admission_data = array(
                'BabyId'        => $id,
                'BMrNo'         => $input['BMrNo'],
                'MotherId'      => $input['MotherId'],
                'AdmissionDate' => date('Y-m-d', strtotime($input['admission_date'])),
                'AdmissionTime' => Carbon::now($this->time_zone)->format('h') . ':' . Carbon::now($this->time_zone)->format('i') . ':' . Carbon::now($this->time_zone)->format('a'),
                'InOrOut'       => 'In',
                'AdmissionType' => 'NICU',
                'Status'        => "Inpatient",
                'UserAdded'     => $this->auth->user()->id,
                'DateAdded'     => Carbon::now($this->time_zone)->format('Y-m-d'),
                'DateModified'  => Carbon::now($this->time_zone)->format('Y-m-d'),
                'episodes'      => 'Admission ' . $episodes,
            );

            $admission = Admission::create($admission_data)->AdmissionId;
            $baby_id   = $id;
            $id        = \SiteHelpers::encrypt_id($admission.'-'.$id);
        } 
        else {
            $admission = $previous_visit->AdmissionId;
        }
        if ($input['ward_name'] == '1') {
            
            $prev_nicu_admission = Nicu::where('AdmissionId', $admission)->where('BabyId', $baby_id)->orderBy('AdmissionId', 'desc')->first();
            if (count($prev_nicu_admission) == 0) {
                $input['AdmissionId'] = $admission;
                $input['status'] = 'Inpatient';
                $input['BabyId'] = $baby_id;
                $nicu = Nicu::create($input);
            } else {
                if (isset($prev_nicu_admission->status) && $prev_nicu_admission->status != 'Inpatient') {
                    Nicu::where('NicuId', $prev_nicu_admission->NicuId)->update(['status'=>'Inpatient']);
                }
            }
        }
                    
        $check_bed_log  = BedLog::where(['baby_id'=> $baby_id, 'status'=>'Occupied'])
                                            ->get();
        $ward['ward_id']      = $input['ward_name'];
        $ward['ward_name']    = \SiteHelpers::gettable_values('ward', 'name', 'id', $input['ward_name']) ;
        $ward['room_id']      = $input['room_no'];
        $ward['room_no']      = \SiteHelpers::gettable_values('room', 'number', 'id', $input['room_no']);
        $ward['bed_id']       = $input['bed_no'];
        $ward['bed_no']       = \SiteHelpers::gettable_values('bed', 'number', 'id', $input['bed_no']);;
        $ward['baby_id']      = $baby_id;
        $ward['admission_id'] = (isset($admission) && !empty($admission)) ? $admission : 0;
        $ward['DateAdded']    = Carbon::now($this->time_zone)->format('Y-m-d h:i a');
        $ward['UserAdded']    = $this->auth->user()->id;
        $ward['DateModified'] = Carbon::now($this->time_zone)->format('Y-m-d h:i a');
        $ward['UserModified'] = $this->auth->user()->id;
        $ward['IsDeleted']    = 0;
                   
        Bed::where('id', $input['bed_no'])->update(['status'=>'Occupied']);
        $ward['status']       = 'Occupied';
        if(count($check_bed_log) == 0) {
            $patient_bed_log = BedLog::create($ward);
        } else {
            BedLog::where(['baby_id'=> $baby_id, 'status'=>'Occupied'])->Update($ward);
        }
        
        if (isset($input['ip_number']) && !empty($input['ip_number'])) { 
            $ip_number['baby_id']      = $baby_id;
            $ip_number['ip_number']    = $input['ip_number'];
            $ip_number['status']       = 1;
            $ip_number['DateAdded']    = Carbon::now($this->time_zone)->format('Y-m-d');
            $ip_number['AdmissionId']  = $admission;
            $exist_ip_number = IpNumber::where('ip_number', $input['ip_number'])->where('baby_id', $baby_id)->first();
            if(count($exist_ip_number) == 0)
            {
                IpNumber::create($ip_number);
            }
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
            \DB::table('nurse_main_sheet')->insert($nurse_sheet);
        }
    	$event_input['admission_id'] = $admission;
    	$event_input['status'] = 'ADMISSION';
        ErrorLogController::emergencyLogStat('Nurse registration admission ' . json_encode($event_input));
        broadcast(new WardEvent($event_input))->toOthers();
        \SiteHelpers::updateDashboardAtFormUpdation($baby_id, 'Nurse Baby Registration');
            
        // if($input['MultiplePregnancy'] == "Yes" && $input['Noofbabies'] > 1) {
        //     return redirect(action('Registration\NurseBabyController@create', $input['MotherId']))->with('Success', 'Record saved successfully');
        // }

       if (isset($_COOKIE['motherMrn'])) {
            unset($_COOKIE['motherMrn']);
        }
        if (isset($_COOKIE['babyMrn'])) {
            unset($_COOKIE['babyMrn']);
        }
        if (isset($_COOKIE['babyCurrentWard'])) {
            unset($_COOKIE['babyCurrentWard']);
        }
        if (isset($_COOKIE['babyCurrentRoom'])) {
            unset($_COOKIE['babyCurrentRoom']);
        }
        if (isset($_COOKIE['babyCurrentBed'])) {
            unset($_COOKIE['babyCurrentBed']);
        }
        if (isset($_COOKIE['add_ward_id'])) {
            unset($_COOKIE['add_ward_id']);
        }
        if (isset($_COOKIE['add_room_id'])) {
            unset($_COOKIE['add_room_id']);
        }
        if (isset($_COOKIE['add_bed_id'])) {
            unset($_COOKIE['add_bed_id']);
        }
        // if (isset($_COOKIE['babyIpNumber'])) {
        //     unset($_COOKIE['babyIpNumber']);
        // }
        if (isset($_COOKIE['babyNurseUpdate'])) 
        {
            unset($_COOKIE['babyNurseUpdate']);
        }

        if (\Session::has('nurse_entry_multiple_pregnancy') && \Session::has('nurse_entry_no_of_babies') && \Session::get('nurse_entry_no_of_babies') > 0) {
            return redirect(action('Registration\NurseBabyController@create', \SiteHelpers::encrypt_id($input['MotherId'])))->with('Success', 'Record saved successfully');
        } else {
            $this->flow->clearFlow();
            return redirect(action('Ward\BabyWardController@index'))->with('Success', 'Record saved successfully');
            // return redirect(action('HomeController@index'))->with('Success', 'Record saved successfully');
        }
      
    }

     /**
     * Show the form for editing the specified baby.
     *
     * @param  int $id
     */
    public function edit($id, $search = '')
    {
        $id = \SiteHelpers::decrypt_id($id);

        // Assing Menu section
        $navigate['main_nav'] = 'register';
        $navigate['sub_nav']  = 'baby';
        $search_data          = $search;

        // Get Mother data
        $mother  = Mother::ListData();
        $mothers = array();

        foreach ($mother as $data) {
            $mothers[$data->MotherId] = $data->MotherName . ' - ' . $data->MMrNo;
        }

        // Get baby details using the id
        $results = Baby::findOrfail($id);
        $results['DOB'] = (date('Y', strtotime($results['DOB'])) != 1970) ?  date('d-m-Y', strtotime($results['DOB'])) : '';

        $multiple_pregnancy = $results['MultiplePregnancy']; 
        $MultiplePregnancyType = $results['MultiplePregnancyType'];
        $no_of_babies          = $results['Noofbabies'];

        $tob=\SiteHelpers::prepare_time();
       
        //Get ip details for baby
        $ip_details=IpNumber::getCurrent_ip($id);
        $ipNumber = (is_array($ip_details) && count($ip_details)>0)?$ip_details->ip_number:'';
        $ip_id    = (is_array($ip_details) && count($ip_details)>0)?$ip_details->id:'';

        $babyname = $results['BabyName'];
        $bmrno = $results['BMrNo'];
        $sitesetting = Settings::get_record();
        $sitesetting = $sitesetting[0];

        $temp    = json_decode($results['Gestation']);
        $temp = is_array($temp) ? $temp : (array)$temp;
        $results->g_weeks =  isset($temp['g_weeks']) ? $temp['g_weeks'] : '';  
        $results->g_days  =  isset($temp['g_days'])? $temp['g_days'] : ''; 
        
        if (\SiteHelpers::is_serialized($results->neonatal_consultant)) {
           $results->neonatal_consultant = unserialize($results->neonatal_consultant);
        } 

        $displaystyle = ($results['MultiplePregnancy'] == 'No') ? 'style = "display:none"' : '';

        $results['BirthWeight'] = !empty($results['BirthWeight']) ? $results['BirthWeight'] : 0;
        $previousNeonatal       = Neonatal::checkNeonatal($id);    

        $bed_logs = BedLog::where('baby_id', $id)->orderBy('id','desc')->first();
        // echo "<pre>"; print_r($bed_logs); exit;
        $ward_list = Ward::admission_ward_list()->pluck('name', 'id')
            ->toArray();
        $room_list = array();
        $bed_list = array();


        
        return view('nurse_registration.baby_edit', compact('results', 'no_of_babies','MultiplePregnancyType','multiple_pregnancy','mothers', 'previousNeonatal', 'navigate', 'sitesetting', 'search_data', 'id', 'babyname', 'tob', 'setting', 'bmrno', 'displaystyle', 'ipNumber', 'ip_id', 'ward_list', 'room_list', 'bed_list', 'bed_logs'));
        
    }


    /**
     * Update the specified baby in storage.
     *
     * @param  int $id
     */
    public function update($id, BabyRequest $request)
    {
        // echo "<pre>"; print_r($_COOKIE); exit;
        $results = Baby::findOrfail($id);
        $input = $request->all();
      
        $input['DOB'] = date('Y-m-d', strtotime($input['DOB']));
        $input['TOB_TIME'] = (isset($input['TOB_TIME']) && !empty(trim($input['TOB_TIME']))) ? $input['TOB_TIME'] : null;
        $input['TOB_MINS'] = (isset($input['TOB_MINS']) &&  $input['TOB_MINS'] != '') ? $input['TOB_MINS'] : null;

        $input['Noofbabies'] = (empty(trim(isset($input['Noofbabies']))))? null : $input['Noofbabies'];
        $input['DateModified'] = Carbon::now();
        $input['UserModified'] = $this->auth->user()->id;
        $input['g_weeks'] = empty($input['g_weeks']) ? null : trim($input['g_weeks']);
        $input['g_days']  = empty($input['g_days']) ?  0 : trim($input['g_days']);
        $input['Gestation'] = json_encode(array('g_weeks'=>$input['g_weeks'],'g_days'=>$input['g_days']));
        $input['neonatal_consultant'] =isset($input['neonatal_consultant']) ? serialize($input['neonatal_consultant']) : serialize(array());
        $results->update($input);

        $check_visit = \DB::table('baby_admission')->where('BabyId', $id)
                        ->where('Status', 'Inpatient')
                        ->orderBy('AdmissionId', 'desc')
                        ->first();
        $baby_id    = $id;
        if (count($check_visit) == 0) {
            $episodes   = Admission::where('BabyId', $id)->count();
            $episodes  += 1;
            $admission_data = array(
                'BabyId'        => $id,
                'BMrNo'         => $input['BMrNo'],
                'MotherId'      => $input['MotherId'],
                'AdmissionDate' => Carbon::now($this->time_zone)->format('Y-m-d'),
                'AdmissionTime' => Carbon::now($this->time_zone)->format('h') . ':' . Carbon::now($this->time_zone)->format('i') . ':' . Carbon::now($this->time_zone)->format('a'),
                'InOrOut'       => 'In',
                'AdmissionType' => 'NICU',
                'Status'        => "Inpatient",
                'UserAdded'     => $this->auth->user()->id,
                'DateAdded'     => Carbon::now($this->time_zone)->format('Y-m-d'),
                'DateModified'  => Carbon::now($this->time_zone)->format('Y-m-d'),
                'episodes'      => 'Admission '.$episodes,
            );

            $admission = Admission::create($admission_data)->AdmissionId;
        }
        else
        {
            $admission = $check_visit->AdmissionId;
        }
        if (isset($input['ward_name']) && $input['ward_name'] == '3') {
            $prev_postnatal_admission = \DB::table('postnatal_discharge')
                                        ->where('BabyId', $baby_id)
                                        ->where('discharge_status', 'Inpatient')
                                        ->orderBy('AdmissionId', 'desc')
                                        ->first();
            if (count($prev_postnatal_admission) == 0) {
                $input['AdmissionId'] = $admission;
                $input['discharge_status'] = 'Inpatient';
                $input['BabyId'] = $baby_id;
                $pid       = Postnatal::create($input)->pid;
                PostnatalDischarge::create($input);
                
            }
        }
        elseif (isset($input['ward_name']) && $input['ward_name'] == '1') {
            
            $prev_nicu_admission = Nicu::where('BabyId', $baby_id)->orderBy('NicuId', 'desc')->first();
            
            if (count($prev_nicu_admission) == 0) {
                $input['AdmissionId'] = $admission;
                $input['status'] = 'Inpatient';
                $input['BabyId'] = $baby_id;
                $input['DateAdded'] = Carbon::now();
                $input['UserAdded'] = $this->auth->user()->id;
                $nicu = Nicu::create($input);
            } else {
                $nicu = $prev_nicu_admission->NicuId;
                Nicu::where('NicuId', $nicu)->update(['status' => 'Inpatient', 'DateModified' => Carbon::now($this->zone), 'UserModified' => $this->auth->user()->id]);
            }
        }

        $check_bed_log  = BedLog::where(['baby_id'=> $baby_id, 'status'=>'Occupied'])->first();

        $ward['ward_id']      = $input['ward_name'];
        $ward['ward_name']    = \SiteHelpers::gettable_values('ward', 'name', 'id', $input['ward_name']) ;
        $ward['room_id']      = $input['room_no'];
        $ward['room_no']      = \SiteHelpers::gettable_values('room', 'number', 'id', $input['room_no']);
        $ward['bed_id']       = $input['bed_no'];
        $ward['bed_no']       = \SiteHelpers::gettable_values('bed', 'number', 'id', $input['bed_no']);;
        $ward['baby_id']      = $baby_id;
        $ward['admission_id'] = (isset($admission) && !empty($admission)) ? $admission : 0;
        $ward['DateAdded']    = Carbon::now($this->time_zone)->format('Y-m-d h:i a');
        $ward['UserAdded']    = $this->auth->user()->id;
        $ward['DateModified'] = Carbon::now($this->time_zone)->format('Y-m-d h:i a');
        $ward['UserModified'] = $this->auth->user()->id;
        $ward['IsDeleted']    = 0;        
        $ward['status']       = 'Occupied';
        
        if(count($check_bed_log) == 0) {
            $patient_bed_log = BedLog::create($ward);
            Bed::where('id', $input['bed_no'])->update(['status'=>'Occupied']);
        } else {
            BedLog::where(['baby_id'=> $baby_id, 'status'=>'Occupied'])->Update($ward);
            if ($check_bed_log->bed_no != $input['bed_no']) {
                Bed::where('id', $input['bed_no'])->update(['status'=>'Occupied']);
                Bed::where('id', $check_bed_log->bed_id)->update(['status'=>null]);
            }
        }
        
        if (isset($input['ip_number']) && !empty($input['ip_number'])) {

            $exist_ip_number = IpNumber::where('ip_number', $input['ip_number'])->where('baby_id', $baby_id)->first();
            
            $ip_number['baby_id']      = $baby_id;
            $ip_number['ip_number']    = $input['ip_number'];
            $ip_number['status']       = 1;
            $ip_number['DateAdded']    = Carbon::now($this->time_zone)->format('Y-m-d');
            $ip_number['AdmissionId']  = $admission;
            if(count($exist_ip_number) == 0)
            {
                IpNumber::create($ip_number);
            }
            else {
                IpNumber::where('ip_number', $input['ip_number'])->where('baby_id', $baby_id)->update($ip_number);
            }
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
            \DB::table('nurse_main_sheet')->insert($nurse_sheet);
        }
        
       if (isset($_COOKIE['motherMrn'])) {
            unset($_COOKIE['motherMrn']);
        }
        if (isset($_COOKIE['babyMrn'])) {
            unset($_COOKIE['babyMrn']);
        }
        if (isset($_COOKIE['babyCurrentWard'])) {
            unset($_COOKIE['babyCurrentWard']);
        }
        if (isset($_COOKIE['babyCurrentRoom'])) {
            unset($_COOKIE['babyCurrentRoom']);
        }
        if (isset($_COOKIE['babyCurrentBed'])) {
            unset($_COOKIE['babyCurrentBed']);
        }
        if (isset($_COOKIE['babyIpNumber'])) {
            unset($_COOKIE['babyIpNumber']);
        }
        if (isset($_COOKIE['babyNurseUpdate'])) {
            unset($_COOKIE['babyNurseUpdate']);
        }
        if (isset($_COOKIE['add_ward_id'])) {
            unset($_COOKIE['add_ward_id']);
        }
        if (isset($_COOKIE['add_room_id'])) {
            unset($_COOKIE['add_room_id']);
        }
        if (isset($_COOKIE['add_bed_id'])) {
            unset($_COOKIE['add_bed_id']);
        }

        if (!empty($input['savedhere'])) {
            return redirect(action('Registration\BabyController@edit', \SiteHelpers::encrypt_id($id)))->with('Success', 'Record updated successfully');
        } elseif (!empty($input['createneonate'])) {
            return redirect(action('Registration\NeonatalController@create').'/'.\SiteHelpers::encrypt_id($id))->with('Success', 'Baby record updated successfully');
        } elseif (!empty($input['createop'])) {
            return redirect(action('Registration\OpController@create').'/'.\SiteHelpers::encrypt_id($id))->with('Success', 'Baby record updated successfully');
        } else {
            // return redirect(action('Registration\BabyController@index'))->with('Success', 'Record updated successfully');
            // return redirect(action('Ward\BabyWardController@index'))->with('Success', 'Record saved successfully');
            return redirect(url('ward-dashboard#'.$ward['ward_name']))->with('Success', 'Record saved successfully');
        }
    }

    /**
     * Store a newly created baby.
     *
     * @return Response
     */
    public function readmissioncreation(Request $request)
    {
        
        $input = $request->all();
        
        $baby                 = baby::find($input['BabyId']);
        $baby->BabyName       = $input['BabyName'];
        $baby->BMrNo          = $input['BMrNo'];
        $baby->DOB            = (empty($input['DOB'])) ? null : date('Y-m-d', strtotime($input['DOB']));
        $baby->g_weeks        =  empty($input['g_weeks']) ? null : trim($input['g_weeks']);
        $baby->g_days         =  empty($input['g_days']) ?  null : trim($input['g_days']);
        $baby->DateModified   = Carbon::now();
        $baby->Gestation      = json_encode(array('g_weeks'=>$input['g_weeks'],'g_days'=>$input['g_days']));
        $baby->TOB_TIME       = (isset($input['TOB_TIME']) && !empty($input['TOB_TIME']))  ? $input['TOB_TIME'] : null ;
        $baby->TOB_MINS       = (isset($input['TOB_MINS']) && !empty($input['TOB_MINS']))  ? $input['TOB_MINS'] : null ;
        $baby->TOB_AM         = (isset($input['TOB_AM']) && !empty($input['TOB_AM']))  ? $input['TOB_AM'] : null ;
        $baby->save();

        $episodes   = Admission::where('BabyId', $input['BabyId'])->count();
        $episodes  += 1;
        $baby_id    = $input['BabyId'];
        $admission_data = array(
                'BabyId'        => $input['BabyId'],
                'BMrNo'         => $input['BMrNo'],
                'MotherId'      => $input['MotherId'],
                'AdmissionDate' => date('Y-m-d', strtotime($input['admission_date'])),
                'AdmissionTime' => Carbon::now($this->time_zone)->format('h') . ':' . Carbon::now($this->time_zone)->format('i') . ':' . Carbon::now($this->time_zone)->format('a'),
                'InOrOut'       => 'In',
                'AdmissionType' => 'NICU',
                'Status'        => "Inpatient",
                'UserAdded'     => $this->auth->user()->id,
                'DateAdded'     => Carbon::now($this->time_zone)->format('Y-m-d'),
                'DateModified'  => Carbon::now($this->time_zone)->format('Y-m-d'),
                'episodes'      => 'Admission ' . $episodes,
        );

        $admission = Admission::create($admission_data)->AdmissionId;
        $id        = $baby_id; 
        $id        = \SiteHelpers::encrypt_id($admission.'-'.$id);

        $ward['ward_id']      = $input['ward_name'];
        $ward['ward_name']    = \SiteHelpers::gettable_values('ward', 'name', 'id', $input['ward_name']) ;
        $ward['room_id']      = $input['room_no'];
        $ward['room_no']      = \SiteHelpers::gettable_values('room', 'number', 'id', $input['room_no']);
        $ward['bed_id']       = $input['bed_no'];
        $ward['bed_no']       = \SiteHelpers::gettable_values('bed', 'number', 'id', $input['bed_no']);;
        $ward['baby_id']      = $baby_id;
        $ward['admission_id'] = $admission;
        $ward['DateAdded']    = Carbon::now($this->time_zone)->format('Y-m-d h:i a');
        $ward['UserAdded']    = $this->auth->user()->id;
        $ward['DateModified'] = Carbon::now($this->time_zone)->format('Y-m-d h:i a');
        $ward['UserModified'] = $this->auth->user()->id;
        $ward['IsDeleted']    = 0;

        Bed::where('id', $input['bed_no'])->update(['status'=>'Occupied']);
        $ward['status']       = 'Occupied';
        $patient_bed_log = BedLog::create($ward);

        $ip_exist =  IpNumber::where('baby_id', $baby_id)->where('ip_number', $input['ip_number'])->first();
        $ip_insert = array(
            'baby_id' => $baby_id,
            'AdmissionId' => $admission,
            'status' => '1',
            'ip_number' => $input['ip_number'],
            'DateModified' => date('Y-m-d')
        );
        if (count($ip_exist) == 0) {
            $ip_insert['DateAdded'] = date('Y-m-d');
            IpNumber::insert($ip_insert);
        }
        else
        {
            IpNumber::where('baby_id', $baby_id)->where('AdmissionId', $admission)->update($ip_insert);
        }
        $nicu_admission_exist = \DB::table('nicu_admission')
        ->where('BabyId', $baby_id)
        ->where('AdmissionId', $admission)
        ->where('IsDeleted', '0')
        ->first();

        if (count($nicu_admission_exist) == 0) {
            $nicu_admission = array(
                'BabyId' => $baby_id,
                'BMrNo' => $input['BMrNo'],
                'AdmissionId' => $admission,
                'MotherId' => $input['MotherId'],
                'AdmissionDate' => date('Y-m-d'),
                'AdmissionTime' => date('h'),
                'AdmissionTime_MINS' => date('i'),
                'AdmissionTime_AM' => date('A'),
                'status' => 'Inpatient',
                'UserAdded' => $this->auth->user()->id,
                'DateAdded' => Carbon::now($this->time_zone)
            );
            \DB::table('nicu_admission')->insert($nicu_admission);
        } else {
            \DB::table('nicu_admission')->where('NicuId', $nicu_admission_exist->NicuId)->update(['status'=>'Inpatient', 'DateModified'=>Carbon::now($this->time_zone), 'UserModified'=>$this->auth->user()->id]);
        }

        $event_input['admission_id'] = $admission;
        $event_input['status'] = 'ADMISSION';
        ErrorLogController::emergencyLogStat('Nurse registration re-admission ' . json_encode($event_input));
        broadcast(new WardEvent($event_input))->toOthers();

        \SiteHelpers::updateDashboardAtFormUpdation($baby_id, 'Re-admission');

        return redirect(action('HomeController@index'))->with('Success', 'Record saved successfully');

    }



   /**
    * create multiple preganancy 
    *
    * @return type boolgen
    */

    public function MultipleBaby($feilds)
    {

        $babies = array();
        $noBaby =  $feilds['Noofbabies'] - 1;
        $babies[] = $feilds;
       for ($i=1; $i <= $noBaby ; $i++) { 
           $s=$i+1;
           $baby_temp = ['BabyName' =>$feilds['BabyName'].'-'.str_singular($feilds['MultiplePregnancyType']).'-'.$s, 
                         'MotherId' =>$feilds['MotherId'],
                         'MultiplePregnancy' =>$feilds['MultiplePregnancy'],
                         'MultiplePregnancyType' =>$feilds['MultiplePregnancyType'],
                         'Noofbabies' =>$feilds['Noofbabies'],
                         'BirthStatus' =>$feilds['BirthStatus'],
                         'DateAdded'   =>$feilds['DateAdded'],
                         'UserAdded'   =>$this->auth->user()->id,
                         'DateModified' =>$feilds['DateModified'],
                         'UserModified' =>$this->auth->user()->id,
                         'Baby_group_id' => $feilds['Baby_group_id'],
                         'Gestation'=>$feilds['Gestation'],
                       ];
          $baby_id = Baby::create($baby_temp)->BabyId;
         
       }

        return true;

    }


    /**
     * Update the specified baby in storage.
     *
     * @param  int $request
     */ 
    public function Create_mother_baby(Request $request)
    {
        $input = $request->all();
        $baby=Baby::where('BMrNo', $input['BMrNo'])
              ->where('IsDeleted', 0)
              ->count();
        if ($baby == 0) {
            $input['DateAdded']=$input['DateModified'] = Carbon::now();
            $input['UserAdded']=$input['UserModified'] = $this->auth->user()->id;
            $input['FatherAddress1'] = $input['Address1'];
            $input['FatherAddress2'] = $input['Address2'];
            $input['City']           = $input['Address3'];
            $input['Postcode']       = $input['Address4'];

            $mother_id = Mother::create($input)->MotherId;

            $input['DOB']       = date('Y-m-d', strtotime($input['DOB']));

            $dayoflife = \SiteHelpers::calculate_day_of_life($input['DOB']);

            $tempGestation = \SiteHelpers::calculate_gestation_dayoflife($dayoflife);
            

            $tempGestationtem = json_encode(array('g_weeks'=>'', 'g_days'=>''));

            if (is_array($tempGestation) && count($tempGestation) > 0) {

              $tempGestationtem = json_encode(array('g_weeks'=>$tempGestation[0], 'g_days'=>$tempGestation[0]));

            }

            $input['Gestation']           = $tempGestationtem;
            $input['neonatal_consultant'] = serialize(array());

            $input['MotherId']  = $mother_id; 
            // Baby details stored in DB
            $baby_id = Baby::create($input)->BabyId;
            
            // ip number details stored in DB
            $ipdata['baby_id']      = $baby_id;
            $ipdata['ip_number']    = $input['Ipnumber'];
            $ipdata['status']       = 1;
            $ipdata['DateAdded']    = Carbon::now();
            $ipdata['DateModified'] = Carbon::now(); 
            IpNumber::create($ipdata);
          return json_encode(['status'=>true]);
        } 
        else {
           return json_encode(['status'=>false,'message'=>'MRN already exists']);
        }  

    }

    /**
     * Calculate the age .
     *
     * @param  type date  $birthDate
     * @param  type date  $todayDate
     * @param  type int $preMatureDays
     * @return  json object
     */ 
    public function calculateAge($birthDate, $todayDate, $preMatureDays) 
    {
        if (isset($birthDate) && isset($todayDate)  && isset($preMatureDays)) {
         
         $birthDate           = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($birthDate)));
         $todayDate           = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($todayDate))); 

         $chronologicalAge['year']    = $birthDate->diff($todayDate)->format('%y');
         $chronologicalAge['month']   = $birthDate->diff($todayDate)->format('%m');
         $chronologicalAge['days']    = $birthDate->diff($todayDate)->format('%d');

         $correctedAge['year']     = $birthDate->copy()->addDays($preMatureDays)->diff($todayDate)->format('%y');
         $correctedAge['month']    = $birthDate->copy()->addDays($preMatureDays)->diff($todayDate)->format('%m');
         $correctedAge['days']     = $birthDate->copy()->addDays($preMatureDays)->diff($todayDate)->format('%d');
            
            return \Response::json(['status'=>'Success',
                                    'results'=>['chronologicalAge' =>$chronologicalAge,
                                                'correctedAge'     =>$correctedAge ]
                                    ], 200);
      
        } else {
            return \Response::json(['status'=>'error', 'results'=>'failed '], 500);

        }


    }

    /**
     * Readmission module for 
     * baby
     *
     * @param type date $baby_id
     */
    public function babylistnurse(Request $request) 
    {


        $babies_list  = Baby::baby_list_nicu();
        $babies = array();
        $babies  = collect($babies_list)->pluck('BabyName', 'BabyId')->toArray();
        $babies[0] = '- - Select from List - -';
        ksort($babies);

        $SubmitButtonText = 'Start';

        return view('nurse_registration.baby_select', compact('babies', 'SubmitButtonText'));

    }

    /**
     * Readmission module for 
     * baby
     *
     * @param type date $baby_id
     */
    public function babyreadmission($id, Request $request) 
    {
        if ($id == 0) {
            return redirect(action('Registration\NurseBabyController@babylistnurse'))->with('error', 'Please select the baby');
        }

        $baby                             =  Baby::GetReadmissionDetails($id);

        $ward_list                        =  Ward::admission_ward_list()->pluck('name', 'id')->toArray();

        $baby->DOB                        =  (date('Y', strtotime($baby->DOB)) == '1970') ? null : date('d-m-Y',strtotime($baby->DOB));

        if (!is_null($baby->DOB)) {

            $gestationIndays                  =  \SiteHelpers::convert_gestation_days($baby->Gestation);
            $baby->DOB   = date('Y-m-d',strtotime($baby->DOB));
            $dayoflife                        =  \SiteHelpers::calculate_day_of_life_two($baby->DOB, date('Y-m-d', time()));
            $corrected_gestation              =  \SiteHelpers::calculate_corrected_gestation($gestationIndays, $dayoflife);

            $baby->cg_weeks  =   isset($corrected_gestation['0']) ? $corrected_gestation['0'] : '';
            $baby->cg_days   =   isset($corrected_gestation['1']) ? $corrected_gestation['1'] : '';
        }
      
        $baby->DOB   = date('d-m-Y',strtotime($baby->DOB));

        return view('nurse_registration.readmission', compact('baby', 'ward_list'));

    }


    /**
     * This method get room list based on 
     * ward or bed based on room select  
     *
     * @param $id   type integer ward_id or room_id
     *
     * @param $slug type string ROOMLIST OR BEDLIST
     */
    public function getadmissionbedlist($id, $slug,$type='', Request $request)
    {
        $result = array();

        if ($slug == 'ROOMLIST')
        {
            $temp_result = Room::getroomlist($id);
        }
        elseif ($slug == 'BEDLIST')
        {
            if ($type != '') {
                
                $temp_result = Bed::getbeddetails($id, 'all');
            }
            else
            {
                $temp_result = Bed::getbeddetails($id);
            }
        }

        foreach ($temp_result as $key => $value)
        {
            $temp['name'] = $value->number;
            $temp['id'] = $value->id;
            $result[] = $temp;
        }

        return \Response::json(['results'=>$result]);

    }
     /**
     * This method get room list based on 
     * ward or bed based on room select  
     *
     * @param $id   type integer ward_id or room_id
     *
     * @param $slug type string ROOMLIST OR BEDLIST
     */
    public function getWardRoomBedDetails($id, $slug, Request $request)
    {
        $result = array();

        
        if (!is_numeric($id) && $slug == 'ROOMLIST') {
            if ($id == 'Postnatal Ward') {
                $id = 'Postnatal';
            }
            $result = \DB::table('room')
                    ->select('room.id', 'room.number')
                    ->join('ward', 'ward.id', '=', 'room.ward_id')
                    ->join('bed', 'bed.room_id', '=', 'room.id')
                    ->where('ward.name', $id)
                    ->where(function($q) {
                       $q->whereNull('bed.status')
                       ->orWhere('bed.status', 'Available');
                     })
                    ->orderBy('room.number', 'asc')
                    ->get()
                    ->unique('number')
                    // ->pluck('number', 'id')
                    ->toArray();
        }
        else
        {
            $result = \DB::table('bed')
                    ->select('bed.id', 'bed.number')
                    ->where('bed.room_id', $id)
                    ->where(function($q) {
                       $q->whereNull('bed.status')
                       ->orWhere('bed.status', 'Available');
                     })
                    ->orderBy('bed.id', 'asc')
                    ->get()
                    ->toArray();
        }
        return \Response::json(['results'=>$result]);

    }


}

