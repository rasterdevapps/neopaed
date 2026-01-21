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
use App\Models\Masters\Ward;
use App\Models\Masters\Room;
use App\Models\Masters\Bed;
use App\Models\Ward\BedLog;
use App\Models\Nicu;
use App\Models\Admission;
use App\Models\Nurse\SyringePumpAdmisson;
class BabyController extends Controller
{
   /**
    * 
    *@var  $baby_check 
    */
   public $baby_check;

   /**
    * @var $custom_error type object
    */
   public $custom_error;

    /**
    * This for site settings instance 
    * 
    * @var $site_settings
    */
    public $site_settings;
    
    /**
     *Class constructor 
     *
     */
    public function  __construct(Guard $auth, FlowController $flow, ErrorLogController $custom_error, Settings $site_settings)
    {
        $this->middleware('role:BABY_REG,write', ['only' => ['store', 'update', 'edit', 'create', 'destory']]);
        $this->middleware('role:BABY_REG,read', ['only' => ['index', 'show']]);
        $this->auth = $auth; 
        $this->flow = $flow; 
        $this->custom_error = $custom_error;
        $this->time_zone = env('TIME_ZONE');
        $this->site_settings = $site_settings;

    }

    /**
     * Display baby listing.
     *
     */
    public function index(Request $request)
    {
        $limit = 50; // Assign the Page limitation
        if (!empty($request->input('limit'))) {
            $request->session()->put('limit', $request->input('limit'));
            $limit = $request->session()->get('limit');
        } elseif ($request->session()->has('limit')) {
            $limit = $request->session()->get('limit');
        }


        $order['sortby']    = 'BabyId';
        $order['sortorder'] = 'desc';

        if (!empty($request->input('sortby')) && !empty($request->input('sortorder'))) {
            $order['sortby']     =\SiteHelpers::decrypt_id($request->input('sortby'));
            $order['sortorder']  = $request->input('sortorder');
        }

        $sitesetting = Settings::get_record();
        $sitesetting = $sitesetting[0];


        $search = array();
        $search['search_txt']='';
        if (!empty($request->input('search_txt'))) {
            $search['search_txt'] = $request->input('search_txt');
        }
        // Assing Menu section
        $navigate['main_nav'] = 'register';
        $navigate['sub_nav']  = 'baby';
        // Get Baby list using Baby models
        $result     = Baby::ListDatawithSearch($request->input('page'), $limit, $search, $order, 1); //Baby->mothers()->get->toArray();
        // Get Total For baby list.
        
        $results    = $result['result'];

        foreach ($results as &$value) {

            $neonatal_details = Baby::GetBabyDependency($value->BabyId, 1);
            $op_details       = Baby::GetBabyDependency($value->BabyId, 2);
            $value->hasChild  = false;

            if (count($neonatal_details) > 0 || count($op_details) > 0) {
             $value->hasChild  = true;
         } 

     }


     $getTotal   = Baby::GetTotal();
     $total      = $result['total']; 

     $page                   = !empty($request->input('page')) ? $request->input('page') : 1;
     $pagecount              = (!empty($search['search_txt'])) ? ceil($total/$limit) : ceil($total/$limit);
     $pagination['total']    = $total;
     $pagination['start']    = (($page-2) < 1) ? 1 : ($page-2);
     $pagination['end']      = ($pagecount < ($page+3)) ? $pagecount :   ($page+3);
     $pagestart              = $total != 0 ? ($page <= 1) ? $page : ($page-1)*$limit + 1 : 0;
     $pagerecords            = ($page == $pagination['end'] || $pagination['total'] == 0) ? $pagination['total'] : $page*$limit;
     $pagination['limit']    = array($pagestart, $pagerecords);
     $pagination['limits']   = $limit;
     $pagination['previous'] = (($page-1) < 1) ? 1 : ($page-1);
     $pagination['next']     = ($pagecount < ($page+1)) ? $pagecount :   ($page+1);

     $tob['time'] = array();
     for ($i = 0; $i <= 12; $i++) {
        $tob['time'][$i] = $i;
    }

    $tob['mins'] = array();
    for ($i = 0; $i <= 59; $i++) {
        $tob['mins'][$i] = (strlen($i) == 1) ? '0' . $i : $i;
    }

    $incomplete_baby = Baby::check_empty();
        // Assing data to View & define the blade file
    $this->flow->clearFlow();

    return view('registration.baby_list', compact('results', 'sitesetting', 'navigate', 'pagination', 'search', 'order', 'tob', 'incomplete_baby', 'getTotal'));
}

    /**
     * Show the form for creating a new baby.
     *
     */
    public function create($id = 0)
    {
        if (!is_numeric($id) &&  $id != 'undefined') {
            $id = \SiteHelpers::decrypt_id($id);
        } elseif (($id != 0 || $id != '0') && $id === 'undefined') {
            return redirect()->back()->with('error', 'Something went wrong. try after some time!');
        }
        // Assing Menu section
        $navigate['main_nav'] = 'register';
        $navigate['sub_nav']  = 'baby';

        $multiple_pregnancy = 'No';
        $no_of_babies = '1';
        $MultiplePregnancyType = '';

        if (\Session::has('multiple_pregnancy') && \Session::get('no_of_babies') != '0' && \Session::has('baby_group_id')) {

         $baby = Baby::find(\Session::get('baby_group_id'));

         if (isset($baby->MotherId) && count($baby) > 0) {

            $id = $baby->MotherId;
            $multiple_pregnancy = 'Yes';
            $MultiplePregnancyType = $baby->MultiplePregnancyType;
            $no_of_babies = $baby->Noofbabies;

        } else {
         $this->custom_error->emergencyLog('issue in no of babies with multiple pregnancy in baby create issue');
         throw new \InvalidInputException("Invalid baby count found");
     }

 } elseif (\Session::has('multiple_pregnancy') && \Session::get('no_of_babies') == '0') {
    $this->custom_error->emergencyLog('issue in no of babies with multiple pregnancy in baby create issue');
    throw new \InvalidInputException("Invalid baby count found");
}

        // Get Mother data from mother models
$mothers = Mother::GetData($id);
$count_of_preg_type = array('Twins'=>2,
 'Triplets'=>3,
 'Quadruplets'=>4,
 'Quintuplets'=>5,
 'Sextuplets'=>6,
 'Septuplets'=>7,
 'Octuplets'=>8);
$babies = Baby::getBabiesByMother($id);

/*For Multiple Pregnancy*/

$disabled_birthorder        = array();
$pending_babies             = 0;
$multiple_pregnancy_type    = '';

if (count($babies) > 0) {
    $baby_value = collect($babies)->first();
    if (isset($baby_value->MultiplePregnancyType)) {
        $pregnancy_type = $baby_value->MultiplePregnancyType;
        if ($pregnancy_type != 'Singleton' && $pregnancy_type != '') {
            $total_babies = $count_of_preg_type[$pregnancy_type];
            $dateadded = Carbon::parse($baby_value->DateAdded);
            $current_date = Carbon::now();
            $diff = $dateadded->diffInDays($current_date);
            if ($diff < 30) {
                $multiple_pregnancy_type = $baby_value->MultiplePregnancyType;
                $disabled_birthorder = collect($babies)->pluck('BirthOrder', 'BabyName')->toArray();
                $pending_babies = $total_babies - count($disabled_birthorder);
            }

        }
    }
}
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
        $ip_number = '';
        $ip_id    = '';

        $results['TOB_TIME'] = (int)Carbon::now(env('TIME_ZONE'))->format('h');
        $results['TOB_MINS'] = (int)Carbon::now(env('TIME_ZONE'))->format('i');
        $results['TOB_AM']   = Carbon::now(env('TIME_ZONE'))->format('A');
        $previousNeonatal    = array();

        $room_list =  $ward_list = array();
        $bed_list  = array();


        // Assing data to View & define the blade file
        return view('registration.baby_create', compact('mothers', 'ward_list','room_list','bed_list','no_of_babies','MultiplePregnancyType','multiple_pregnancy', 'previousNeonatal', 'sitesetting', 'navigate', 'id', 'babyname', 'tob', 'results', 'bmrno', 'displaystyle', 'ip_number', 'ip_id', 'multiple_pregnancy_type','disabled_birthorder', 'pending_babies'));
    }

    /**
     * Select Mother name in baby registration form.
     *
     */
    public function chooseMother()
    {
        $navigate['main_nav'] = 'register';
        $navigate['sub_nav'] = 'baby';
        $mother = Mother::ListData();
        
        $mothers = \ValuelistHelpers::select2DataFormater($mother);

        $SubmitButtonText = "Start";

        return view('registration.select_mother', compact('SubmitButtonText', 'mothers', 'navigate'));
    }

    /**
     * Store a newly created baby.
     *
     * @return Response
     */
    public function store(BabyRequest $request)
    {

        $input = $request->all();

        if (isset($input['BMrNo']) && !empty($input['BMrNo']) && !is_null($input['BMrNo'])) {
            $exist_mrn = Baby::where('BMrNo', $input['BMrNo'])->where('IsDeleted', 0)->count();
            if ($exist_mrn != 0) {
                // return redirect()->back()->with('error', 'Baby MRN number already exist!');
                return \Response::json(['type' => 'error', 'message' => 'MRN number already exist...!'], 500);
            }
        }
        $print_flag = $input['print_flag'];
        unset($input['print_flag']);
        $input['BirthStatus']    = (isset($input['BirthStatus']) && $input['BirthStatus'] == 'on') ? 'Inborn' : 'Outborn';
        $input['DOB']            = (empty($input['DOB'])) ? null : date('Y-m-d', strtotime($input['DOB']));
        $input['DateAdded']      = Carbon::now();
        $input['UserAdded']      = $this->auth->user()->id;
        $input['UserModified']   = $this->auth->user()->id;
        $input['DateModified']   = Carbon::now();
        $input['Baby_group_id']  = null;
        $input['g_weeks']        = empty($input['g_weeks']) ? null : trim($input['g_weeks']);
        $input['g_days']         = empty($input['g_days']) ?  0 : trim($input['g_days']);


        $input['Gestation']           = json_encode(array('g_weeks'=>$input['g_weeks'],'g_days'=>$input['g_days']));
        $input['neonatal_consultant'] = isset($input['neonatal_consultant']) ? serialize($input['neonatal_consultant']) : serialize(array());
        $input['TOB_TIME']            = (isset($input['TOB_TIME']) && !empty($input['TOB_TIME']))  ? $input['TOB_TIME'] : null ;
        $input['TOB_MINS']            = (isset($input['TOB_MINS']) && !empty($input['TOB_MINS']))  ? $input['TOB_MINS'] : null ;

        // Baby details stored in DB
        $input['Noofbabies'] = (!empty(trim(isset($input['Noofbabies']))))? $input['Noofbabies']  : null ;
        if (isset($input['MultiplePregnancy']) && $input['MultiplePregnancy'] == 'Yes' && !\Session::has('registration_start')) {
            //create Multiple pregnancy data
            $mbfelds = $input;
            if (!empty($input['BirthOrder'])) {

                $pregnancy_type = preg_replace('/[0-9-]/', '', $input['BirthOrder']);
                $pregnancy_type = strtolower($pregnancy_type);
                $temp_baby_name = strtolower($input['BabyName']);
                
                if (strpos($temp_baby_name, $pregnancy_type) === false) {
                    // $input['BabyName'] = $input['BabyName'].'-'.str_singular($input['BirthOrder']);
                    $input['BabyName'] = $input['BabyName'].'-'.$input['BirthOrder'];
                }


                $mbfelds['current_birth_order'] = substr($input['BirthOrder'], -1);
            }
            else
            {

                $pregnancy_type = preg_replace('/[0-9-]/', '', $input['BirthOrder']);
                $pregnancy_type = strtolower($pregnancy_type);
                $temp_baby_name = strtolower($input['BabyName']);
                
                if (strpos($temp_baby_name, $pregnancy_type) === false) {
                    // $input['BabyName'] = $input['BabyName'].'-'.$input['BirthOrder'];
                    $input['BabyName'] = $input['BabyName'].'-'.str_singular($input['MultiplePregnancyType']).'-1';
                }
                $mbfelds['current_birth_order'] = 0;
            }
            $id = Baby::create($input)->BabyId; 
            $mbfelds['Baby_group_id'] = $id;


            /*For Multiple Pregnancy*/
            $babies = Baby::getBabiesByMother($input['MotherId']);

            

            $count_of_preg_type = array('Twins'=>2,
             'Triplets'=>3,
             'Quadruplets'=>4,
             'Quintuplets'=>5,
             'Sextuplets'=>6,
             'Septuplets'=>7,
             'Octuplets'=>8);

            $mbfelds['already_resgister'] = array();

            if (count($babies) > 0) {
                $baby_value = collect($babies)->first();
                $pregnancy_type = $baby_value->MultiplePregnancyType;
                if ($pregnancy_type != 'Singleton') {
                    $total_babies = $count_of_preg_type[$pregnancy_type];
                    $dateadded = Carbon::parse($baby_value->DateAdded);
                    $current_date = Carbon::now();
                    $diff = $dateadded->diffInDays($current_date);
                    $check_date = Carbon::now()->subDays(30);

                    if ($diff < 30) {

                        $current_babies = collect($babies)->where('DOB','>',$check_date)->pluck('BirthOrder')->toArray();
                        
                        $mbfelds['already_resgister'] = $current_babies;

                        // $multiple_pregnancy_type = $baby_value->MultiplePregnancyType;
                        // $disabled_birthorder = collect($babies)->pluck('BirthOrder', 'BabyName')->toArray();
                        // $pending_babies = $total_babies - count($disabled_birthorder);
                    }

                }
            }


            // if () {

            // }
            $babies = $this->MultipleBaby($mbfelds);

        } elseif(isset($input['MultiplePregnancy']) && $input['MultiplePregnancy'] == 'Yes' && \Session::has('registration_start')) {
            \Session::put('multiple_pregnancy', true);

            if (!\Session::has('no_of_babies')) {

                \Session::put('no_of_babies', $input['Noofbabies']);
                \Session::put('baby_order', '1');
            } 

            if(\Session::has('no_of_babies') && \Session::get('no_of_babies') != '0') {
                 // $input['BabyName'] = $input['BabyName'].'-'.str_singular($input['MultiplePregnancyType']).'-'.\Session::get('baby_order');
               $input['BabyName'] = $input['BabyName'].'-'.$input['BirthOrder'];
               $input['Baby_group_id'] = (\Session::has('baby_group_id') && \Session::get('baby_order') != '1') ? \Session::get('baby_group_id') : null;
               $id = Baby::create($input)->BabyId; 
               $mbfelds['Baby_group_id'] = $id; 

               if(\Session::get('baby_order') == '1') {
                   \Session::put('baby_group_id',$id);
                   \Session::put('mother_id',$input['MotherId']);

               }

               $baby_count   = \Session::get('no_of_babies') - 1;
               $current_baby = \Session::get('baby_order') + 1;
               \Session::put('no_of_babies', $baby_count);
               \Session::put('baby_order', $current_baby);

               if (\Session::get('no_of_babies') == '0') {

                \Session::forget('multiple_pregnancy');
                \Session::forget('mother_id');
                \Session::forget('baby_group_id');
                \Session::forget('no_of_babies');
                \Session::forget('baby_order');
                \Session::put('set_nicu_menu', true);

            }
        } 



    } else {
           //create singtone baby 
     $input['BirthOrder'] = $input['MultiplePregnancyType'] = 'Singleton';
     $id = Baby::create($input)->BabyId; 
 }

 if (\Session::has('registration_start')) {
  $module_complete = (in_array('NEONATAL', \Session::get('write_permission'))) ? false : true ;
  $this->flow->flowlog('BABY_REG', $id, $input['MotherId'], null, $module_complete, null);
} 


        // $episodes   = Admission::where('BabyId', $id)->count();
        // $episodes  += 1;
        // $baby_id    = $id;
        // $admission_data = array(
        //         'BabyId'        => $id,
        //         'BMrNo'         => (isset($input['BMrNo']) && !empty($input['BMrNo'])) ? $input['BMrNo'] : null,
        //         'MotherId'      => $input['MotherId'],
        //         'AdmissionDate' => Carbon::now($this->time_zone)->format('Y-m-d'),
        //         'AdmissionTime' => Carbon::now($this->time_zone)->format('h') . ':' . Carbon::now($this->time_zone)->format('i') . ':' . Carbon::now($this->time_zone)->format('a'),
        //         'InOrOut'       => '',
        //         'AdmissionType' => '',
        //         'Status'        => "",
        //         'UserAdded'     => $this->auth->user()->id,
        //         'DateAdded'     => Carbon::now($this->time_zone)->format('Y-m-d'),
        //         'DateModified'  => Carbon::now($this->time_zone)->format('Y-m-d'),
        //         'episodes'      => 'Admission ' . $episodes,
        // );
        // $prev_admission_status = Admission::select('AdmissionId')->where('BabyId', $id)
        //                             ->where('Status', 'Inpatient')->first();
        // if(count($prev_admission_status) != 0)
        // {
        //     $admission = $prev_admission_status;
        // }
        // else
        // {
        //     $admission = Admission::create($admission_data)->AdmissionId;
        // }
        // // $id        = \SiteHelpers::encrypt_id($admission.'-'.$baby_id);

        // // $ward['ward_id']      = $input['ward_name'];
        // // $ward['ward_name']    = \SiteHelpers::gettable_values('ward', 'name', 'id', $input['ward_name']) ;
        // // $ward['room_id']      = $input['room_no'];
        // // $ward['room_no']      = \SiteHelpers::gettable_values('room', 'number', 'id', $input['room_no']);
        // // $ward['bed_id']       = $input['bed_no'];
        // // $ward['bed_no']       = \SiteHelpers::gettable_values('bed', 'number', 'id', $input['bed_no']);;
        // // $ward['baby_id']      = $baby_id;
        // // $ward['admission_id'] = $admission;
        // // $ward['DateAdded']    = Carbon::now($this->time_zone)->format('Y-m-d h:i a');
        // // $ward['UserAdded']    = $this->auth->user()->id;
        // // $ward['DateModified'] = Carbon::now($this->time_zone)->format('Y-m-d h:i a');
        // // $ward['UserModified'] = $this->auth->user()->id;
        // // $ward['IsDeleted']    = 0;


        // // Bed::where('id', $input['bed_no'])->update(['status'=>'Occupied']);
        // // $ward['status']       = 'Occupied';
        // // $patient_bed_log = BedLog::create($ward);

        // $ip_number['baby_id']      = $baby_id;
        // $ip_number['ip_number']    = (isset($input['ip_number']) && !empty($input['ip_number']))  ? $input['ip_number'] : null ;
        // $ip_number['status']       = 1;
        // $ip_number['DateAdded']    = Carbon::now($this->time_zone)->format('Y-m-d h:i a');
        // $ip_number['DateModified'] = Carbon::now($this->time_zone)->format('Y-m-d h:i a');
        // $ip_number['AdmissionId']  = $admission;

        // if (isset($input['ip_number']) && $input['ip_number'] != '' && !is_null($input['ip_number'])) { 
        //     IpNumber::create($ip_number);
        //  } 

         // Nicu dashboard data updating call
\SiteHelpers::updateDashboardAtFormUpdation($id, 'Baby Details');        

        //If we received savedhere we still maintain the same page in baby registration
if ($request->ajax())
{
    return \Response::json(['type' => 'success', 'message' => 'Time sheet added successfully !', 'id' => $id, 'edit_url' => action('Registration\BabyController@edit', \SiteHelpers::encrypt_id($id)), 'create_proforma_url' => action('Registration\NeonatalController@create').'/'.\SiteHelpers::encrypt_id($id), 'list_url' => action('Registration\BabyController@index'), 'op_create_url' => action('Registration\OpController@create').'/'.\SiteHelpers::encrypt_id($id)], 200);
}
if ($print_flag == 2) {
    return redirect(action('Registration\BabyController@edit', \SiteHelpers::encrypt_id($id)))->with('Success', 'Record saved successfully');
} elseif ($print_flag == 3) {

 if (in_array('NEONATAL', \Session::get('write_permission'))) {
  return redirect(action('Registration\NeonatalController@create').'/'.\SiteHelpers::encrypt_id($id))->with('Success', 'Baby record saved successfully');
} else {
  return redirect(action('Registration\BabyController@index'))->with('Success', 'Record saved successfully');

}

} elseif ($print_flag == 5) {
    return redirect(action('Registration\OpController@create').'/'.\SiteHelpers::encrypt_id($id))->with('Success', 'Baby record saved successfully');
} else {
 return redirect(action('Registration\BabyController@index'))->with('Success', 'Record saved successfully');

}
}

   /**
    * create multiple preganancy 
    *
    * @return type boolgen
    */

   public function MultipleBaby($feilds)
   {

    $babies = array();
    $count_of_preg_type = array('Twins'=>2,
     'Triplets'=>3,
     'Quadruplets'=>4,
     'Quintuplets'=>5,
     'Sextuplets'=>6,
     'Septuplets'=>7,
     'Octuplets'=>8);
    $noBaby =  $count_of_preg_type[$feilds['MultiplePregnancyType']];
    $babies[] = $feilds;
    for ($i=1; $i <= $noBaby ; $i++) { 
           // $s=$i+1;
        if ($i != $feilds['current_birth_order']) {

            $birth_order = str_singular($feilds['MultiplePregnancyType']).'-'.$i;
            if (!in_array($birth_order, $feilds['already_resgister'])) {

                $baby_temp = ['BabyName' =>$feilds['BabyName'].'-'.$birth_order, 
                'MotherId' =>$feilds['MotherId'],
                'MultiplePregnancy' =>$feilds['MultiplePregnancy'],
                'MultiplePregnancyType' =>$feilds['MultiplePregnancyType'],
                'Noofbabies' =>$feilds['Noofbabies'],
                'BirthStatus' =>$feilds['BirthStatus'],
                'BirthOrder' =>$birth_order,
                'DateAdded'   =>$feilds['DateAdded'],
                'UserAdded'   =>$this->auth->user()->id,
                'DateModified' =>$feilds['DateModified'],
                'UserModified' =>$this->auth->user()->id,
                'Gestation'=>$feilds['Gestation'],
                'DOB'=>$feilds['DOB'],
                'Noofbabies'=>$feilds['Noofbabies'],
            ];
            $baby_id = Baby::create($baby_temp)->BabyId;
        }
    }

}

return true;

}
    /**
     * This function is used to return data for ajax request of baby view
     *
     * @param  int $id
     */

    public function show($id)
    {
        $results = Baby::get_data($id);
        $results = (array)$results[0];
        if (date('Y', strtotime($results['DOB'])) > 1980) {
            $results['DOB'] = date('d-m-Y', strtotime($results['DOB']));
        } else {
            $results['DOB'] = '';
        }

        if (date('Y', strtotime($results['DOB'])) > 1980) { 
            $results['TOB_TIME']=(strlen($results['TOB_TIME'])==1)?('0'.$results['TOB_TIME']):$results['TOB_TIME'];
            $results['TOB_MINS']=(strlen($results['TOB_MINS'])==1)?('0'.$results['TOB_MINS']):$results['TOB_MINS'];
            $results['TOB'] = $results['TOB_TIME'].':'.$results['TOB_MINS'].' '.$results['TOB_AM'];
        } else {
            $results['TOB'] = '';
        }

        return json_encode($results);
    }

    /**
     * Show the form for editing the specified baby.
     *
     * @param  int $id
     */
    public function edit($id, $search = '', Request $request)
    {
        $flow_wise_register = $request->get('flow');
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
        $obstetric_consultant          = $results['obstetric_consultant'];


        $tob=\SiteHelpers::prepare_time();

        //Get ip details for baby
        $ip_details=IpNumber::getCurrent_ip($id);
        
        $ip_number = $ip_id =  '';
        if (count($ip_details) != 0) {
            if (isset($ip_details->ip_number)) {
                $ip_number = $ip_details->ip_number;
            }
            if (isset($ip_details->id)) {
                $ip_id = $ip_details->id;
            }
        }
        
        $babyname    = $results['BabyName'];
        $bmrno       = $results['BMrNo'];
        $sitesetting = Settings::get_record();
        $sitesetting = $sitesetting[0];

        $temp    = json_decode($results['Gestation']);
        $temp = is_array($temp) ? $temp : (array)$temp;
        $results->g_weeks =  isset($temp['g_weeks']) ? $temp['g_weeks'] : '';  
        $results->g_days  =  isset($temp['g_days'])? $temp['g_days'] : ''; 
        
        if ($results->neonatal_consultant == NULL || $results->neonatal_consultant == '') {
            $results->neonatal_consultant = 'a:4:{i:0;s:1:"8";i:1;s:1:"7";i:2;s:2:"21";i:3;s:2:"33";}';
        }
        if (\SiteHelpers::is_serialized($results->neonatal_consultant)) {
         $results->neonatal_consultant = unserialize($results->neonatal_consultant);
     } 

     $displaystyle = ($results['MultiplePregnancy'] == 'No') ? 'style = "display:none"' : '';

     $results['BirthWeight'] = !empty($results['BirthWeight']) ? $results['BirthWeight'] : 0;
     $previousNeonatal       = Neonatal::checkNeonatal($id);
     $nicu_admission         = Admission::where('BabyId', $id)
     ->orderby('AdmissionId','desc')
     ->first();   

     $ward_bed_list = BedLog::where('baby_id', $id)->orderby('id', 'desc')->first();
     $ward_id       = isset($ward_bed_list->ward_id) ? $ward_bed_list->ward_id : null;
     $room_id       = isset($ward_bed_list->room_id) ? $ward_bed_list->room_id : null;
     $bed_id        = isset($ward_bed_list->bed_id) ? $ward_bed_list->bed_id : null;


     $ward_list              = ward::admission_ward_list()->pluck('name', 'id')->toArray();
     $room_list              = Room::getroomlist($ward_id)->pluck('number', 'id')->toArray();
     $bed_list               = Bed::getBedDetailsEdit($room_id)->pluck('number', 'id')->toArray();

     return view('registration.baby_edit', compact('results', 'bed_list','obstetric_consultant','room_list','ward_bed_list','ward_list','no_of_babies','MultiplePregnancyType','multiple_pregnancy','mothers', 'previousNeonatal', 'navigate', 'sitesetting', 'search_data', 'id', 'babyname', 'tob', 'setting', 'bmrno', 'displaystyle', 'ip_number', 'ip_id', 'flow_wise_register'));

 }

    /**
     * Update the specified baby in storage.
     *
     * @param  int $id
     */
    public function update($id, BabyRequest $request)
    {
        $results = Baby::findOrfail($id);
        $input = $request->all();
        if (isset($input['BMrNo']) && !empty($input['BMrNo']) && !is_null($input['BMrNo'])) {
            $exist_mrn = Baby::where('BMrNo', $input['BMrNo'])->where('BabyId', '!=', $id)->count();
            if ($exist_mrn != 0) {
                if ($request->ajax())
                {
                    return \Response::json(['type' => 'error', 'message' => 'MRN number already exist...!', 'validate_mrn' => 'error'], 500);
                }
                return redirect()->back()->with('error', 'Baby MRN number already exist!');
            }
        }


        $print_flag = $input['print_flag'];
        unset($input['print_flag']);

        $input['BirthStatus']    = (isset($input['BirthStatus']) && $input['BirthStatus'] == 'on') ? 'Inborn' : 'Outborn';
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
        $input['obstetric_consultant'] = empty($input['obstetric_consultant']) ? null : $input['obstetric_consultant'];


        if (isset($input['MultiplePregnancy']) && $input['MultiplePregnancy'] == 'Yes') {
            $pregnancy_type = preg_replace('/[0-9-]/', '', $input['BirthOrder']);
            $pregnancy_type = strtolower($pregnancy_type);
            $temp_baby_name = strtolower($input['BabyName']);
            
            if (strpos($temp_baby_name, $pregnancy_type) === false) {
                $input['BabyName'] = $input['BabyName'].'-'.$input['BirthOrder'];
            }

        } else {
            $input['BirthOrder'] = $input['MultiplePregnancyType'] = 'Singleton';
        }

        $results->update($input);

        if (($print_flag == 1 || $print_flag == 2) && isset($input['hms_call']) && $input['hms_call']) {

            ErrorLogController::emergencyLogStat('Baby Details - Pump admission');

            $default_name = \Config::get('constants.HIS_QUICK_REG_BABY_NAME');
            $default_name = strtolower($default_name);

            if (str_contains(strtolower($input['BabyName']), $default_name) && $input['old_baby_name'] != $input['BabyName']) {

                $baby_admission_details = Admission::select('MotherId', 'BabyId', 'AdmissionId')->where('BabyId', $input['baby_id'])->orderBy('AdmissionId', 'desc')->first();

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

                $event_input['baby_name'] = $input['BabyName'];
                $event_input['baby_mrn'] = $input['BMrNo'];
                $event_input['status'] = 'EDIT';
                ErrorLogController::emergencyLogStat('Baby Details update ' . json_encode($event_input));
                broadcast(new WardEvent($event_input))->toOthers();

            }
        }

         // Nicu dashboard data updating call
        \SiteHelpers::updateDashboardAtFormUpdation($results->BabyId, 'Baby Details');

        if (isset($input['flow']) && $input['flow'] == 'from-dashboard' && isset($input['neonatal_proforma_id']) && !empty($input['neonatal_proforma_id'])) {
            $create_proforma_url = action('Registration\NeonatalController@edit', \SiteHelpers::encrypt_id($input['neonatal_proforma_id'])).'?flow=from-dashboard';
        }
        else if (isset($input['flow']) && $input['flow'] == 'from-dashboard' && (!isset($input['neonatal_proforma_id']) || empty($input['neonatal_proforma_id']))) {
            $create_proforma_url = action('Registration\NeonatalController@create').'/'.\SiteHelpers::encrypt_id($id).'?flow=from-dashboard';
        }
        else
        {
            $create_proforma_url = action('Registration\NeonatalController@create').'/'.\SiteHelpers::encrypt_id($id);
        }

        if ($request->ajax())
        {
            return \Response::json(['type' => 'success', 'message' => 'Time sheet added successfully !', 'id' => $id, 'edit_url' => action('Registration\BabyController@edit', \SiteHelpers::encrypt_id($id)), 'create_proforma_url' => $create_proforma_url, 'list_url' => action('Registration\BabyController@index'), 'op_create_url' => action('Registration\OpController@create').'/'.\SiteHelpers::encrypt_id($id)], 200);
        }
        if ($print_flag == 2) {
            return redirect(action('Registration\BabyController@edit', \SiteHelpers::encrypt_id($id)))->with('Success', 'Record updated successfully');
        } elseif ($print_flag == 3) {
            return redirect(action('Registration\NeonatalController@create').'/'.\SiteHelpers::encrypt_id($id))->with('Success', 'Baby record updated successfully');
        } elseif ($print_flag == 5) {
            return redirect(action('Registration\OpController@create').'/'.\SiteHelpers::encrypt_id($id))->with('Success', 'Baby record updated successfully');
        } else {
            return redirect(action('Registration\BabyController@index'))->with('Success', 'Record updated successfully');
        }
    }

    /**
     * Used for search form data fecthing.
     */
    public function searchData(Request $request)
    {
        $data = $request->get('data1');
        $results = Baby::GetSearchDatas($data);
        return json_encode($results);
    }

    /**
     * Update the baby as deleted and save the delete request for approval.
     *
     * @param  int $id
     */
    public function destroy($id)
    {
        $results = Baby::findOrfail($id);
        $user_detail = array(
            'UserDeleted' => $this->auth->user()->id,
            'DateModified' => Carbon::now(),
            'IsDeleted' => '1'
        );
        $results->update($user_detail);
        $delete_data = array(
            'Name' => $results['BabyName'],
            'ModuleController' => 'Registration\BabyController',
            'ModuleId' => $id,
            'ModuleName' => 'Baby Registration',
            'UserDeleted' => $this->auth->user()->id,
            'DateDeleted' => Carbon::now()
        );
        DeleteApproval::create($delete_data);
        return redirect(action('Registration\BabyController@index'))->with('info', 'Record deleted successfully !');
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
          if (isset($ipdata['ip_number']) && $ipdata['ip_number'] != '' && !is_null($ipdata['ip_number'])) { 
            IpNumber::create($ipdata);
        } 
        return json_encode(['status'=>true]);
    } else {
     return json_encode(['status'=>false,'message'=>'MRN already exists']);
 }  

}

    /**
     * checking mr no.
     *
     * @param  int $request
     */ 
    public function mrcheck(Request $request)
    {

        $input = $request->all();
        $mother_records= Baby::where('BMrNo', $input['BMrNo'])->where('IsDeleted', '0')->get();

        if (count($mother_records) > 0) {

            return \Response::json('Mr No already exists.', 200);

        } else {

           return \Response::json(true, 200);
       }


   }

    /**
     * checking mr no.
     *
     * @param  int $request
     */
    public function Check_mrno(Request $request)
    {
       $input = $request->all();
       $baby = Baby::where('BMrNo', $input['BMrNo']);
       if (isset($input['baby_id']) && $input['baby_id'] != '0') {
           $baby->where('BabyId', '!=', $input['baby_id']);
       }
       $baby = $baby->where('IsDeleted', 0)->count();

       if ($baby == 0 || (isset($input['module']) && $input['module'] == 'op')) {
        return \Response::json(['status'=>true, 'message'=>'MRN number not exist in table'], 200);
    } else {
        return \Response::json(['status'=>false, 'message'=>'MRN already exists'], 200);
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


           $birthDate = str_replace('GMT+0530 (India Standard Time)', '', $birthDate);
           $todayDate = str_replace('GMT+0530 (India Standard Time)', '', $todayDate);

           $birthDate = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($birthDate)));
           $todayDate = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($todayDate))); 

           $chronologicalAge['year']    = $birthDate->diff($todayDate)->format('%y');
           $chronologicalAge['month']   = $birthDate->diff($todayDate)->format('%m');
           $chronologicalAge['days']    = $birthDate->diff($todayDate)->format('%d');

           $correctedAge['year']  = 0;
           $correctedAge['month'] = 0;
           $correctedAge['days']  = 0;

           if($birthDate->copy()->addDays($preMatureDays) < $todayDate ) {
              $correctedAge['year']     = $birthDate->copy()->addDays($preMatureDays)->diff($todayDate)->format('%y');
              $correctedAge['month']    = $birthDate->copy()->addDays($preMatureDays)->diff($todayDate)->format('%m');
              $correctedAge['days']     = $birthDate->copy()->addDays($preMatureDays)->diff($todayDate)->format('%d');
          }

          return \Response::json(['status'=>'Success',
            'results'=>['chronologicalAge' =>$chronologicalAge,
            'correctedAge'     =>$correctedAge ]
        ], 200);

      } else {
        return \Response::json(['status'=>'error', 'results'=>'failed '], 500);

    }


}

private function wardDashboardUpdate($id, $input) {

    $input['ward_name']   = (isset($input['ward_name']) && !empty($input['ward_name'])) ? $input['ward_name'] : null;
    $input['room_no']     = (isset($input['room_no']) && !empty($input['room_no'])) ? $input['room_no'] : null;
    $input['bed_no']      = (isset($input['bed_no']) && !empty($input['bed_no'])) ? $input['bed_no'] : null;

    $ward['ward_id']      = isset($input['ward_name']) ? $input['ward_name'] : null;
    $ward['ward_name']    = \SiteHelpers::gettable_values('ward', 'name', 'id', $input['ward_name']) ;
    $ward['room_id']      = $input['room_no'];
    $ward['room_no']      = \SiteHelpers::gettable_values('room', 'number', 'id', $input['room_no']);
    $ward['bed_id']       = $input['bed_no'];
    $ward['bed_no']       = \SiteHelpers::gettable_values('bed', 'number', 'id', $input['bed_no']);
    $ward['baby_id']      = $id;
        //$ward['admission_id'] = ;
    $ward['status']       = 'Occupied';
    $ward['DateAdded']    = Carbon::now()->format('Y-m-d h:i a');
    $ward['UserAdded']    = $this->auth->user()->id;
    $ward['DateModified'] = Carbon::now()->format('Y-m-d h:i a');
    $ward['UserModified'] = $this->auth->user()->id;
    $ward['IsDeleted']    = 0;

    return $ward;

}

    /**
     * Fetch baby List.
     *
     */
    public function babyList(Request $request) {
        $check_auth = $request->all();
        $secure_user  = false;

        if (isset($check_auth)) {
            $api_key       = \SiteHelpers::decrypt_id($check_auth['api_key']);
            $user_password = \SiteHelpers::decrypt_id($check_auth['user_password']);

            $settings               = $this->site_settings->find(1);
            $settings_api_key       = \SiteHelpers::decrypt_id($settings->api_key);
            $settings_user_name     =  $settings->api_user_name;
            $settings_user_password = \SiteHelpers::decrypt_id($settings->api_password);

            if (($api_key == $settings_api_key) && ($check_auth['user_name'] == $settings_user_name) &&  ($user_password == $settings_user_password)) {
                $secure_user = true;
            }

        }
        if ($secure_user) {
            $babies = Baby::ListData();
            return $babies;
        } else {
            echo 'Invalid User';
        }
    }

    /**
     * Update Allegries
     *
     */
    public function updateAllegries(Request $request) {
        $input = $request->all();
        Baby::where('BabyId', $input['baby_id'])->update(['allegries'=>$input['allegries']]);
        return \Response::json(['type'=>'success', 'message'=>'Succcessfully'], 200);
    }

    public function checkRecordIsExists(Request $request) {

        $input = $request->all();

        $table               = $input['table_name'];
        $column_name         = $input['column_name_to_compare'];
        $id                  = $input['id'];
        $primary_column_name = $input['primary_column_name'];

        $result = \DB::table($table)->select($primary_column_name)->where($column_name, $id)->orderby($primary_column_name)->first();

        $url = action('Registration\NeonatalController@edit', \SiteHelpers::encrypt_id($result->NeonatalId));

        return \Response::json(['messageType'=>'success', 'message'=>'Succcessfully', 'url'=>$url], 200);

    }
    
    function isJson($string) {
     json_decode($string);
     return json_last_error() === JSON_ERROR_NONE;
 }

    // Get Baby and Mother details by baby mrn
 public function getBabyDetails($mrn)
 {
    $results = Baby::get_baby_by_mrn($mrn);

    return \Response::json(['results' => $results], 200);
}

    // Method to generate MRN for saraswathi nursing home
public function getSaraswathiMrn() {

    $result = \DB::table('baby')->where('BMrNo', 'ilike', '%SNH%')->orderBy('BabyId', 'desc')->first();

    $current_year = date('y');

    if (isset($result->BMrNo)) {
        $mrn = preg_replace('/[A-Z]/', '',$result->BMrNo);
        $last_year = substr($mrn, 0, 2);
        $temp_mrn = substr($mrn, 2);
        if ($current_year == $last_year) {
            $mrn = 'SNH'. $current_year . str_pad(($temp_mrn + 1), 4, '0', STR_PAD_LEFT);
        } else {
            $mrn = 'SNH'. $current_year.'0001';
        }
    } else {
        $mrn = 'SNH'. $current_year.'0001';
    }

    return \Response::json(['mrn' => $mrn], 200);

}

    // Method to generate IP for saraswathi nursing home
public function getSaraswathiIp() {

    $result = \DB::table('ip_numbers')->where('ip_number', 'ilike', '%SNH%')->orderBy('id', 'desc')->first();

    $current_year = date('y');

    if (isset($result->ip_number)) {
        $ip = preg_replace('/[A-Z\/]/', '',$result->ip_number);
        $last_year = substr($ip, 0, 2);
        $temp_ip = substr($ip, 2);
        if ($current_year == $last_year) {
            $ip = 'IP/SNH'. $current_year . str_pad(($temp_ip + 1), 4, '0', STR_PAD_LEFT);
        } else {
            $ip = 'IP/SNH'. $current_year.'0001';
        }
    } else {
        $ip = 'IP/SNH'. $current_year.'0001';
    }

    return \Response::json(['ip' => $ip], 200);

}

}

