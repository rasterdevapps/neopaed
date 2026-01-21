<?php 
namespace App\Http\Controllers\admission;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\Admissions\NicuRequest;
use App\Models\Baby;
use App\Models\Complication;
// use App\Models\Masters\AntibioticMaster as AntibioticMaster;
use App\Models\Masters\Complications as ComplicationMaster;
use App\Models\Masters\DrugIvFluidMaster;
use App\Models\Masters\MediprobsMaster as MediprobsMaster;
use App\Models\Masters\ProblemMaster as ProblemMaster;
use App\Models\Masters\ProcedureMaster as ProcedureMaster;
use App\Models\Masters\Admissionmode as AdmissionmodeMaster;
use App\Models\Masters\AutoTagMasters;
use App\Models\Admission;
use App\Models\Masters\Indication;
use App\Models\Masters\DoctorMaster;
use App\Models\Masters\Vaccine as Vaccine;
use App\Models\Medications;
use App\Models\Nicu;
use App\Models\NicuNewborn;
use App\Models\Problems;
use App\Models\Icd;
use App\Models\Settings\DeleteApproval;
use App\Models\Usg;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use App\Models\IpNumber;
use App\Models\Delivery;
use App\Http\Controllers\Flow\FlowController;
use App\Models\PostnatalDischarge;
use App\Models\Neonatal;
use App\Exceptions\InvalidInputException;
use App\Models\Ward\BedLog;
use App\Models\Masters\Ward;
use App\Models\Masters\Room;
use App\Models\Masters\Bed;

use App\Models\Nurse\SyringePumpAdmisson;
use App\Models\DeviceStatusNotification;
use App\Models\Nurse\EmrLogHeader;
use App\Models\Nurse\EmrMoniterValues;
use App\Models\Nurse\EmrVentilatorValues;
use App\Models\Masters\Admissionmode;
use App\Http\Controllers\Nurse\DialpadSupportProperty;
use App\Models\FileUpload;
use App\Events\WardEvent;
use App\Http\Controllers\Errors\ErrorLogController;
use App\Http\Controllers\Fhir\PrescriptionToMirthController;

class NicuController extends Controller 
{
   /**
    * This is for usg flages
    *
    * @var $usg_flags type integer
    */ 
    public $usg_flags;

    /**
    * This is for auto loding tags 
    *
    * @var $tempTags type array
    */ 
    public $tempTags;

    /**
    * This is for comman fields for multiple pregancy 
    *
    * @var $common_felds type array
    */ 
    public $common_felds;

   /**
    * This is define the guard instance
    * 
    * @var $auth type instance 
    */
    public $auth;

    /**
    * This is define the current time zone
    * 
    * @var $zone type instance 
    */
    public $zone;

    /**
    * This is define the un formate 
    * 
    * @var $format_print type array 
    */
    public $unformat_print;

    /**
    * This is define the nicu module
    * 
    * @var $nicu_module type object 
    */
    public $nicu_module;

    /** 
     * Constructor Method  
     *
     * Initialize Module Property 
     */
    public function __construct(Guard $auth, FlowController $flow)
    {
        $this->middleware('role:NICU_FORM,write', ['only' => ['store', 'update', 'edit', 'create', 'show', 'destroy']]);
        $this->middleware('role:NICU_FORM,read', ['only' => ['index', 'printData']]);
        $this->auth         = $auth;
        $this->usg_flags    = 2;
        $this->tempTags     = ['DescriptionOfResuscitation', 'MajorComplaints', 'Plan', 'MattersDiscussed'];
        $this->common_felds = ['Smoking', 'Alcohol', 'Tobacco', 'ParentsSpokenTo', 'MattersDiscussed', 'TimeOfDiscussion', 'TimeOfDiscussion_MINS', 'TimeOfDiscussion_AM'];
        $this->zone         =  env('TIME_ZONE');
        $this->flow         = $flow;
        $this->unformat_print = ['G_Value', 'P_Value', 'L_Value', 'A_Value'];
        $this->nicu_module  = new Nicu(); 
        $this->time_zone = env('TIME_ZONE');        

    }
    

    /**
     * Display a listing of the nicu patients.
     *
     */
    public function index(Request $request)
    {
        $limit = 50;
        if (!empty($request->input('limit'))) {
            $request->session()->put('limit', $request->input('limit'));
            $limit = $request->session()->get('limit');
        } elseif ($request->session()->has('limit')) {
            $limit = $request->session()->get('limit');
        }


        $order['sortby']    = 'nicu_admission.NicuId';
        $order['sortorder'] = 'desc';  

        if (!empty($request->input('sortby')) && !empty($request->input('sortorder'))) {
          $order['sortby']     = \SiteHelpers::decrypt_id($request->input('sortby'));
          $order['sortorder']  = $request->input('sortorder');
        }    

        $search = array();
         $search['search_txt']='';
        if (!empty($request->input('search_txt'))) {
            $search['search_txt'] = $request->input('search_txt');
        }

        $navigate['main_nav'] = 'nicu';
        $navigate['sub_nav'] = 'nicu_proforma';

        $status = !empty($request->input('status')) ? $request->input('status') : 'inpatient';

        $page = !empty($request->input('page')) ? $request->input('page') : 1;
        $page = preg_replace( '/[^0-9]/', '', $page);

        $result   = Nicu::get_lists($page, $limit, $search, $order, 1, $status);
        
        $results  = $result['result'];
        // $getTotal = Nicu::GetTotal();
        $getTotal = count($result['result']);
        
        $total    = $result['total']; 

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

          foreach ($results as $key => $value) {
                $results[$key]->rowcolor ='';
                if (trim($results[$key]->status) == 'Inpatient' || empty(trim($results[$key]->status)) || trim($results[$key]->status) == "NULL") {
                  
                    $results[$key]->rowcolor ='info';
                } else {
                   $results[$key]->rowcolor =' success'; 
                }
          }
        $mr_no = collect($results)->pluck('BMrNo')->toArray();
        $admission_date = Nicu::get_admission($mr_no); 

        foreach ($admission_date as $key => $value) {
           $AdmissionDatelist[$value->BMrNo][] = $value;
        } 
       
        $AdmissionDatelist = isset($AdmissionDatelist) ? collect($AdmissionDatelist) : collect(array()) ;
        $this->flow->clearFlow();
        return view('admission.nicu.list', compact('results', 'navigate', 'pagination', 'order', 'search', 'AdmissionDatelist', 'getTotal'));
    }

    public function nicuSublists(Request $request, $id)
    {

        $baby_id = \SiteHelpers::decrypt_id($id);

        $navigate['main_nav'] = 'nicu';
        $navigate['sub_nav'] = 'nicu_proforma';
        $results   = Nicu::getBabywiseList($baby_id);
        $total = $results['total'];
        $results = $results['result'];

        foreach ($results as &$value) {
            $daycare_list      =  Nicu::getNicuadmissionDependancy($value->BabyId, $value->AdmissionId);
            $value->hasDaycare = count($daycare_list) > 0 ? true : false;
        }

        $visit_ids = $results->pluck('NicuId');

        $file_list = FileUpload::getList($visit_ids, 3);

        $babyName  = isset($results[0]->BabyName) ? $results[0]->BabyName :'';
        $babyMrno  = isset($results[0]->BMrNo) ? $results[0]->BMrNo : '';
        // $total = Nicu::GetTotal();

        return view('admission.nicu.nicu_sublist', compact('results', 'navigate', 'babyName', 'babyMrno', 'file_list'));

    }

    /**
     * Show the baby selection list to create admission.
     *
     *
     */
    public function chooseBaby()
    {
        $navigate['main_nav']    = 'nicu';
        $navigate['sub_nav']     = 'nicu_proforma';
        $nicuSlug                = \Session::get('nicu-create-slug');
        $babies                  =  array();
        $baby                    =  Baby::baby_list_nicu(); 

        $babies = \ValuelistHelpers::select2DataFormater($baby);
        
        $SubmitButtonText = "Start";

        return view('admission.nicu.select_patient', compact('SubmitButtonText', 'babies', 'navigate'));
    }

    /**
     * Store a newly created admission in storage.
     *
     * @return to listing page
     */
    public function store(NicuRequest $request)
    {
        $input = $request->all();   
        $print_flag = isset($input['print_flag']) ? $input['print_flag'] : 0;
        unset($input['print_flag']);

        $input['BirthStatus'] = (isset($input['BirthStatus']) && $input['BirthStatus'] == 'on') ? 'Inborn' : 'Outborn';

        $input['g_weeks'] = empty($input['g_weeks']) ? 0 : trim($input['g_weeks']);
        $input['g_days']  = empty($input['g_days']) ?  0 : trim($input['g_days']);

        $input['cg_weeks'] = (isset($input['cg_weeks']) && !empty($input['cg_weeks'])) ? $input['cg_weeks'] : 0;
        $input['cg_days']  = (isset($input['cg_days']) && !empty($input['cg_days'])) ?  $input['cg_days']  : 0;
        $input['dcg_weeks'] = !empty($input['dcg_weeks']) ? $input['dcg_weeks'] : null;
        $input['dcg_days']  = !empty($input['dcg_days']) ?  $input['dcg_days']  : null;
        
        // AutoTagMasters::auto_key_support($this->tempTags,$input);

        $input['indication_of_admission'] =  isset($input['indication_of_admission']) ? json_encode($input['indication_of_admission']) : null;

        $input['VentilationRequired'] = (isset($input['VentilationRequired']) && $input['VentilationRequired'] =='on') ? 'Yes' : 'No' ;
        $input['Ventilation'] = (isset($input['Ventilation']) && $input['Ventilation'] =='on') ? 'Yes' : 'No' ;
        $input['UAC'] = (isset($input['UAC']) && $input['UAC'] =='on') ? 'Yes' : 'No' ;
        $input['UVC'] = (isset($input['UVC']) && $input['UVC'] =='on') ? 'Yes' : 'No' ; 
        $input['ParentsSpokenTo'] = (isset($input['ParentsSpokenTo']) && $input['ParentsSpokenTo'] =='on') ? 'Yes' : 'No';
        $input['NextAppointmentStatus'] = (isset($input['NextAppointmentStatus']) && $input['NextAppointmentStatus'] =='on') ? 'Yes' : 'No';

        $baby                 = Baby::FindorFail($input['BabyId']);
        $get_admission_id     = Nicu::GetLastAdmissionId();
        
        $input['AdmissionNo'] = (!empty($get_admission_id['0']->AdmissionNo)) ? $get_admission_id['0']->AdmissionNo + 1 : 10000;
       
        $input['DOB']           = date('Y-m-d', strtotime($input['DOB']));
        $input['AdmissionDate'] = !empty($input['AdmissionDate']) ? date('Y-m-d', strtotime($input['AdmissionDate'])) : null;
        $input['DischargeDate'] = !empty($input['DischargeDate']) ?  date('Y-m-d', strtotime($input['DischargeDate'])) : null;

        $input['initial_assessment_completed_date'] = !empty($input['initial_assessment_completed_date']) ? date('Y-m-d', strtotime($input['initial_assessment_completed_date'])) : null;

        $input['NextAppointment']      = isset($input['NextAppointment']) ? date('Y-m-d', strtotime($input['NextAppointment'])) : null;
        $input['DateofAdministration'] = (isset($input['DateofAdministration']) && !empty($input['DateofAdministration'])) ? date('Y-m-d', strtotime($input['DateofAdministration'])): null;
        $input['DiscussionTime'] = $input['TimeOfDiscussion'].':'.$input['TimeOfDiscussion_MINS'].':'.$input['TimeOfDiscussion_AM'];
        $input['Gestation']                       = json_encode(array('g_weeks'=>$input['g_weeks'], 'g_days'=>$input['g_days'])); 
        $input['CorrectedGestation']              = json_encode(array('cg_weeks'=>$input['cg_weeks'], 'cg_days'=>$input['cg_days'])); 
        $input['corrected_gestation']             = json_encode(array('dcg_weeks'=>$input['dcg_weeks'], 'dcg_days'=>$input['dcg_days'])); 
        $input['TypeofTreatmen']                  = isset($input['TypeofTreatmen']) ? json_encode($input['TypeofTreatmen']) : json_encode(array());
        $input['delivery_cpap']                   = (isset($input['delivery_cpap']) && $input['delivery_cpap'] == 'on') ? 'Yes' : 'No' ;       
        $input['air_flow']                        = (isset($input['air_flow']) && !empty($input['air_flow'])) ? $input['air_flow'] : null;
        $input['oxgen_flow']                      = (isset($input['oxgen_flow']) && !empty($input['oxgen_flow'])) ? $input['oxgen_flow'] : null;
        $input['diastolic_bp']                    = (isset($input['diastolic_bp']) && !empty($input['diastolic_bp'])) ? $input['diastolic_bp'] : null; 
        $input['rop_follow_up']                   = (isset($input['rop_follow_up']) && !empty($input['rop_follow_up'])) ? $input['rop_follow_up'] : null; 
        $input['diedTime']                        = (isset($input['diedTime']) && !empty($input['diedTime'])) ? $input['diedTime'] : null; 
        $input['diedMins']                        = (isset($input['diedMins']) && !empty($input['diedMins'])) ? $input['diedMins'] : null; 
        $input['typeoftreatment_left']   = isset($input['typeoftreatment_left']) ?  json_encode($input['typeoftreatment_left']) : json_encode(array());
        $input['typeoftreatment_right']  = isset($input['typeoftreatment_right']) ? json_encode($input['typeoftreatment_right']) :  json_encode(array());

        $input['DateModified']= Carbon::now();
        $input['UserModified']= $this->auth->user()->id;
        $baby->update($input);
        $current = Carbon::now();

        if ($input['AdmissionId']== 0) {
            $episodes=Admission::where('BabyId', $input['BabyId'])->count();
            $episodes+=1;
            $admission_data = array(
                    'BabyId'        => $input['BabyId'],
                    'BMrNo'         => $baby['BMrNo'],
                    'MotherId'      => $input['MotherId'],
                    'AdmissionDate' => $current,
                    'AdmissionTime' => $current->format('g').':'.$current->format('i').':'.$current->format('A'),
                    'InOrOut'       => 'In',
                    'AdmissionType' => 'NICU',
                    'Status'        => "Inpatient",
                    'UserAdded'     => $this->auth->user()->id,
                    'DateAdded'     => $current,
                    'DateModified'  => $current,
                    'episodes'      =>'Admission '.$episodes,

                );

            $prev_admission_status = Admission::select('AdmissionId')->where('BabyId', $input['BabyId'])->where('Status', 'Inpatient')->orderBy('AdmissionId', 'desc')->first();
            if(count($prev_admission_status) != 0)
            {
                $admission = $prev_admission_status;
            }
            else
            {
                $admission = Admission::create($admission_data);
            }
            $input['AdmissionId'] = $admission->AdmissionId;

            $ip_data['baby_id']         =  $input['BabyId'];   
            $ip_data['ip_number']       =  (isset($input['ip_number']) && !empty($input['ip_number']))  ? $input['ip_number'] : null ;
            $ip_data['status']          =  1; 
            $ip_data['AdmissionId']     =  $input['AdmissionId'];
            $ip_data['DateAdded']       =  Carbon::now();
            $ip_data['DateModified']    =  Carbon::now();
            if (isset($input['ip_number']) && $input['ip_number'] != '' && !is_null($input['ip_number'])) { 
                IpNumber::create($ip_data);
            } 
        } else {
            Admission::where('AdmissionId', $input['AdmissionId'])->update(['AdmissionType'=>'NICU', 'Status'=>'Inpatient']);
        }

        $input['additional_diagnosis'] = (isset($input['additional_diagnosis']) && count($input['additional_diagnosis']) > 0) ? json_encode($input['additional_diagnosis']) :json_encode(array());
     

        $input['BMrNo']     = $baby['BMrNo'];
      //  $input['TransferDate'] = date('Y-m-d', strtotime($input['TransferDate']));

        $input['Vaccine']     = (isset($input['Vaccine']) && count($input['Vaccine']) != 0) ? json_encode($input['Vaccine']) : null;
        $input['VaccineDate'] = (isset($input['VaccineDate']) && count($input['VaccineDate']) != 0) ? json_encode($input['VaccineDate']) : null;
        
        $input['DifferentialDiagnosis'] = !empty($input['DifferentialDiagnosis']) ? json_encode($input['DifferentialDiagnosis']) : json_encode(array());
        if (isset($input['gestations'])) {
            $input['gestations']   = (count($input['gestations']) != 0) ? serialize($input['gestations']) : serialize(array());
            $input['findings']     = (count($input['findings']) != 0) ? serialize($input['findings']) : serialize(array());
        }   

        if (isset($input['IVAntibiotic'])) {
            $input['IVAntibiotic'] = (count($input['IVAntibiotic'])!=0) ? json_encode($input['IVAntibiotic']): json_encode(array());

        } else {
            $input['IVAntibiotic'] = json_encode(array());
        }

        $input['age_hours'] = (isset($input['age_hours']) && !empty($input['age_hours'])) ? $input['age_hours'] : 0;
        $input['age_mins'] = (isset($input['age_mins']) && !empty($input['age_mins'])) ? $input['age_mins'] : 0;

        $input['AgeTaken'] = $input['age_hours'] . ':' . $input['age_mins'];
        $input['status'] = 'Inpatient';
        $input['SeenBy'] = isset($input['SeenBy']) ? json_encode($input['SeenBy']) : null;

        $prev_nicu_admission = Nicu::where('status', 'Inpatient')->where('IsDeleted', 0)->where('BabyId', $input['BabyId'])->orderBy('AdmissionId', 'desc')->first();

        $input['form_status'] = 1;

        if (count($prev_nicu_admission) == 0) {
            $input['DateAdded'] = Carbon::now(); 
            $input['UserAdded']= $this->auth->user()->id;
            $nicu = Nicu::create($input);
        } else {
            $nicu = Nicu::findOrfail($prev_nicu_admission->NicuId);
            $nicu->update($input);
        }

        $input['MotherId'] = $baby['MotherId'];
        $newborn = NicuNewborn::find($input['BabyId']);
        if ($newborn) {
            $newborn->update($input);
        } else {
            $input['DateAdded'] = Carbon::now($this->time_zone)->format('Y-m-d h:i a');
            $input['UserAdded'] = $this->auth->user()->id;
            NicuNewborn::create($input);
        }
        $length = sizeof($input['Problems']);
        $pbm_data = Problems::where('BabyId', '=', $input['BabyId'])->delete();
        for ($i = 0; $i < $length; $i++) {
           if ($input['Problems'][$i]!=0) {
            $pbms = array(
                'Problem' => $input['Problems'][$i],
                'Medication' => $input['Medications'][$i],
                'MotherId' => $input['MotherId'],
                'BabyId' => $input['BabyId']
            );
            Problems::create($pbms);
           } 
        }

        $discharge_medications = Medications::where('BabyId', '=', $input['BabyId'])->where('AdmissionId', '=', 0) ->where('flag', '=', 2)->delete();
        if (isset($input['M_Drugs'])) {
            for ($i = 0; $i < sizeof($input['M_Drugs']); $i++) {
                $discharge_medications = array(
                    'Medication' => $input['M_Drugs'][$i],
                    'Dose' => $input['M_Dose'][$i],
                    'Frequency' => $input['M_Frequency'][$i],
                    'Duration' => $input['M_Duration'][$i],
                    'genericname'=>$input['m_generic_name'][$i],
                    'formulation'=>$input['formulation'][$i],
                    'AdmissionId' =>$input['AdmissionId'],
                    'BabyId' => $input['BabyId'],
                    'flag'   =>2,
                    'source_id'=>0

                );
                Medications::create($discharge_medications);
            }
        }

        Complication::where('BabyId', '=', $input['BabyId'])->delete();
        if (isset($input['Complication'])) {
            $com_length = sizeof($input['Complication']);
            for ($i=0; $i<$com_length; $i++) {
                if ($input['Complication'][$i]!='' && $input['Complication'][$i]!=0) {
                    $comps = array(
                        'Complication' => $input['Complication'][$i],
                        'Treatment' => $input['Treatments'][$i],
                        'AdmissionId'   => $input['AdmissionId'],
                        'BabyId'    => $input['BabyId'],
                        'flags'    => $this->usg_flags,
                    );
                    Complication::create($comps);
                }
            }
        }

         //create usg and findings for dating scan
        if ((isset($input['datingdate']) && !empty($input['datingdate'])) || (isset($input['datinggestations']) && !empty($input['datinggestations']))) {
                
            $usg_parameters['BabyId']   = $input['BabyId'];
            $usg_parameters['MotherId'] = $input['MotherId'];
            $usg_parameters['flags']    = 1;
            $usg_parameters['type']     = 1;
            Usg::where($usg_parameters)->delete();
                $usg_parameters['date'] = !empty($input['datingdate']) ? date('Y-m-d', strtotime($input['datingdate'])) : null;
                $usg_parameters['Gestation'] = $input['datinggestations'];
                $usg_parameters['Finding']   = (isset($input['datingfindings']) && !empty($input['datingfindings'])) ? $input['datingfindings'] : null;
                Usg::insert($usg_parameters);
            unset($usg_parameters);

        }
        //creating usg adn findings for anolog scan

        if ((isset($input['analogdate']) && !empty($input['analogdate'])) || (isset($input['analoggestations']) && !empty($input['analoggestations']))) {

            $usg_parameters['BabyId']   = $input['BabyId'];
            $usg_parameters['MotherId'] = $input['MotherId'];
            $usg_parameters['flags']    = 1;
            $usg_parameters['type']     = 2;
            Usg::where($usg_parameters)->delete();
                $usg_parameters['date'] = !empty($input['analogdate']) ? date('Y-m-d', strtotime($input['analogdate'])) : null;
                $usg_parameters['Gestation'] = $input['analoggestations'];
                $usg_parameters['Finding']   = (isset($input['analogfindings']) && !empty($input['analogfindings'])) ? $input['analogfindings'] : null;
                Usg::insert($usg_parameters);
            unset($usg_parameters);
        }

        //creating usg adn findings for other scan
        $usg_parameters['BabyId']   = $input['BabyId'];
        $usg_parameters['MotherId'] = $input['MotherId'];
        $usg_parameters['flags']    = $this->usg_flags;
        $usg_parameters['type']     = 3;
        Usg::where($usg_parameters)->delete();

        if (isset($input['otherdate']) || isset($input['othergestations'])) {

            for ($i=0; $i < count($input['othergestations']); $i++) { 
           
                if ((isset($input['otherdate'][$i]) && !empty($input['otherdate'][$i])) || (isset($input['othergestations'][$i]) && !empty($input['othergestations'][$i]))) {
                    $usg = array(
                        'date'      => !empty($input['otherdate'][$i]) ? date('Y-m-d', strtotime($input['otherdate'][$i])) : null,
                        'Gestation' => $input['othergestations'][$i],
                        'Finding'   => $input['otherfindings'][$i],
                        'MotherId'  => $input['MotherId'],
                        'BabyId'    => $input['BabyId'],
                        'flags'     => $this->usg_flags,
                        'type'      => 3,
                    );
                    Usg::insert($usg);
                }     

            }
        }

        //creating usg adn findings for doppler scan
        $usg_parameters['BabyId']   = $input['BabyId'];
        $usg_parameters['MotherId'] = $input['MotherId'];
        $usg_parameters['flags']    = $this->usg_flags;
        $usg_parameters['type']     = 4;
        Usg::where($usg_parameters)->delete();

        if (isset($input['dopplerdate']) || isset($input['dopplergestations'])) {

          for ($i=0; $i < count($input['dopplergestations']); $i++) { 
           
                if ((isset($input['dopplerdate'][$i]) && !empty($input['dopplerdate'][$i])) || (isset($input['dopplergestations'][$i]) && !empty($input['dopplergestations'][$i]))) {
                    $usg = array(
                        'date'      => !empty($input['dopplerdate'][$i]) ? date('Y-m-d', strtotime($input['dopplerdate'][$i])) : null,
                        'Gestation' => $input['dopplergestations'][$i],
                        'Finding'   => $input['dopplerfindings'][$i],
                        'MotherId'  => $input['MotherId'],
                        'BabyId'    => $input['BabyId'],
                        'flags'     => $this->usg_flags,
                        'type'      => 4,
                    );

                    Usg::insert($usg);
                }     

            }   

        }

        $check_bed_log = BedLog::where(['baby_id' => $input['BabyId'], 'status' => 'Occupied'])->get();
        $ward['ward_id'] = 1;
        $ward['ward_name'] = \SiteHelpers::gettable_values('ward', 'name', 'id', 1);
        $ward['room_id'] = $input['room_id'];
        $ward['room_no'] = \SiteHelpers::gettable_values('room', 'number', 'id', $input['room_id']);
        $ward['bed_id'] = $input['bed_id'];
        $ward['bed_no'] = \SiteHelpers::gettable_values('bed', 'number', 'id', $input['bed_id']);
        $ward['baby_id'] = $input['BabyId'];
        $ward['admission_id'] = (isset($input['AdmissionId']) ? $input['AdmissionId'] : 0);
        $ward['DateAdded'] = Carbon::now($this->time_zone)->format('Y-m-d h:i a');
        $ward['UserAdded'] = $this->auth->user()->id;
        $ward['DateModified'] = Carbon::now($this->time_zone)->format('Y-m-d h:i a');
        $ward['UserModified'] = $this->auth->user()->id;
        $ward['IsDeleted'] = 0;
        Bed::where('id', $input['bed_id'])->update(['status' => 'Occupied']);
        $ward['status'] = 'Occupied';

        if (count($check_bed_log) == 0)
        {
            $patient_bed_log = BedLog::create($ward);
        }
        else
        {

            $old_bed_no = $check_bed_log->bed_no;
            $old_room_no = $check_bed_log->room_no;

            if ($old_bed_no != $ward['bed_no']) {
                \SiteHelpers::emptyDashboardData($old_bed_no, $old_room_no);
            }

            BedLog::where(['baby_id' => $input['BabyId'], 'status' => 'Occupied'])->Update($ward);
        }

        $event_input['admission_id'] = $input['AdmissionId'];
        $event_input['status'] = 'ADMISSION';
        ErrorLogController::emergencyLogStat('NICU admission ' . json_encode($event_input));
        broadcast(new WardEvent($event_input))->toOthers();

         // Nicu dashboard data updating call
        \SiteHelpers::updateDashboardAtFormUpdation($input['BabyId'], 'NICU Admission');        

        if (\Session::has('registration_start')) {
              $this->flow->flowlog('NICU_FORM', $input['BabyId'], $input['MotherId'], $input['AdmissionId'], false, 'basicform');
        } 
        if ($request->ajax()) {
            return \Response::json(['type' => 'success', 'message' => 'NICU admission created successfully !', 'edit_url' => action('Admission\NicuController@edit', \SiteHelpers::encrypt_id($nicu->NicuId)), 'list_url' => action('Admission\NicuController@nicuSublists', \SiteHelpers::encrypt_id($input['BabyId'])), 'print_url'=> action('Admission\NicuController@printData', \SiteHelpers::encrypt_id($nicu->NicuId))], 200);
        }

        if ($print_flag == 1) {
            if (isset($nicu->NicuId)) {
                return redirect(action('Admission\NicuController@printData', \SiteHelpers::encrypt_id($nicu->NicuId)))->with('Success', 'Record saved successfully');
            }
            else
            {
                return redirect(action('Admission\NicuController@nicuSublists', \SiteHelpers::encrypt_id($input['BabyId'])))->with('Success', 'Record saved successfully!');
            }
        } elseif ($print_flag == 2) {
            if (isset($nicu->NicuId)) {

                return redirect(action('Admission\NicuController@edit', \SiteHelpers::encrypt_id($nicu->NicuId)))->with('Success', 'Record saved successfully !'); 
            }
            else
            {
                return redirect(action('Admission\NicuController@nicuSublists', \SiteHelpers::encrypt_id($input['BabyId'])))->with('Success', 'Record saved successfully!');
            }
        } else {
            return redirect(action('Admission\NicuController@nicuSublists', \SiteHelpers::encrypt_id($input['BabyId'])))->with('Success', 'Record saved successfully!');
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $id type integer
     * @return Response
     */
    public function create($id = 0, Request $request)
    {
        $id = \SiteHelpers::decrypt_id($id);
        if ($id == 0) {
            return redirect()->back()->with('error', 'Please choose the baby');
        }
        
        $admission_id = 0;
         if (strpos($id, '-') > 0 && count(explode('-', $id)) > 1) {
           $get_data=explode('-', $id);
               if (!empty(trim($get_data[0])) && !empty(trim($get_data[1]))) { 
                     $id           = $get_data[0]; 
                     $admission_id = $get_data[1];
               } else {
                   return redirect()->back()->with('error', 'Please check your choose');
               } 

         }

        $neonatalperforma = Baby::find($id);
        $neonatalperformaresults = $neonatalperforma->getNeonatal;

        // 
        $navigate['main_nav'] = 'nicu';
        $navigate['sub_nav'] = 'nicu_proforma';
        $baby_result = Nicu::get_newborn($id);
        $baby = $baby_result[0];
        $pbm_data = \SiteHelpers::convert_obj_to_array(Problems::getProblems($id)->toArray());
        $medications = Medications::where('BabyId', '=', $baby->BabyId)->where('AdmissionId', '=', 1)->get();
        $complication = Complication::where('BabyId', '=', $baby->BabyId)->where('flags', 1)->get();
        $usg_findings = Usg::where('MotherId', '=', $baby->MotherId)
                        ->where('BabyId', '=', $baby->BabyId)
                        ->where('flags', '=', 1)
                        ->first();
        $Probs                = MediprobsMaster::get_lists();
        $Complications        = ComplicationMaster::get_lists();
        // $Antibiotic           = AntibioticMaster::get_lists();
        $admissionmode_master = AdmissionmodeMaster::ListData();
        $ip_details           = IpNumber::getCurrent_ip($id);
        $old_ip               = (count($ip_details) > 0)? $ip_details->ip_number : '' ;


        if (isset($baby->Baby_group_id) && !is_null($baby->Baby_group_id) && !\Session::has('registration_start')) {
            $silibings = (array)Nicu::getSlibingsdata($baby->Baby_group_id, $admission_id);

             $baby =(array)$baby;
             if (count($baby)>0) {
               foreach ($silibings as $key => $value) {
                 if ($key != 'BabyId' && $key !='MotherId' && $key != 'NewBornId') {
                   $baby[$key] =$value; 
                }
              }  
             } 
             $baby['AdmissionId'] = 0;

             if (isset($baby['DiscussionTime'])) {
                 $temp_baby=explode(':', $baby['DiscussionTime']);
                 if (count($temp_baby)>0) {
                    $baby['TimeOfDiscussion']      = $temp_baby[0];
                    $baby['TimeOfDiscussion_MINS'] = $temp_baby[1];
                    $baby['TimeOfDiscussion_AM']   = $temp_baby[2];
                 }
             }

             $baby = (object)$baby;  

             $temp_problem=Problems::where('BabyId', '=', $baby->Baby_group_id)->get();
             if (count(Problems::getProblems($baby->Baby_group_id)) > 0) {
                $pbm_data = array_merge($pbm_data, \SiteHelpers::convert_obj_to_array(Problems::getProblems($baby->Baby_group_id)));
              }
        }


        
        $GetICD = Icd::where('ICDCode', '<>', '')->get();
        $ICD = array();
        foreach ($GetICD as $key => $value) {
            $ICD[$value->ICDCode] = $value->ICDDescription . '-' . $value->ICDCode;

        }

        // $antibiotic_master[0] = 'N/A';
        // foreach ($Antibiotic as $data) {
        //     $antibiotic_master[$data->Id] = $data->Name;
        // }

        $medi_probs_master[0] = 'N/A';
        foreach ($Probs as $data) {
            $medi_probs_master[$data->Id] = $data->Name;
        }
        $complication_master[0] = 'N/A';
        foreach ($Complications as $data) {
            $complication_master[$data->Id] = $data->Name;
        }

        $drugs = DrugIvFluidMaster::getOralDrug();
        $Vaccines = Vaccine::get_lists();
        $vaccine_master[0] = 'N/A';
        foreach ($Vaccines as $vac) {
            $vaccine_master[$vac->Id] = $vac->Name;
        }
        // $drug_master[0] = 'N/A';
        // foreach ($drugs as $drug) {
        //     $drug__master[$drug->Id] = $drug->Name;
        // }

        $drags= DrugIvFluidMaster::where('is_deleted', 0)->where('type', 'ORAL')->get();
        $drugnew_data[0]   = 'N/A';
        $drugnew_strgnth[0] = 'N/A';
        foreach ($drugs as $drug) {
            $drugnew_data[$drug->Id]    = $drug->Name;
            $drugnew_strgnth[$drug->Id] = $drug->Value;

        }

        // $antib_temp = AntibioticMaster::ListData();
        $procedure_temp = ProcedureMaster::ListData();

        // $antibiotic_data[0] = 'N/A';
        // foreach ($antib_temp as $data) {
        //     $antibiotic_data[$data->Id] = $data->Name;
        // }
        $procedure_master[0] = 'N/A';
        foreach ($procedure_temp as $data) {
            $procedure_master[$data->Id] = $data->Name;
        }

        $problem_temp = ProblemMaster::ListData();

        $problem_master[0] = 'N/A';
        foreach ($problem_temp as $data) {
            $problem_master[$data->Id] = $data->Name;
        }
        $NAT['time'] = array();
        $NAT['time']['']='N/A';
        for ($i = 1; $i <= 12; $i++) {
            $NAT['time'][$i] = (strlen($i) == 1) ? '0' . $i : $i;
        }
        $NAT['mins'] = array();
        $NAT['mins']['']='N/A';
        for ($i = 0; $i <= 59; $i++) {
            $NAT['mins'][$i] = (strlen($i) == 1) ? '0' . $i : $i;
        }
        $SubmitButtonText = "Save & Close";

        $admission['time'] = $admission['mins'] = array();
        for ($i = 1; $i <= 12; $i++) {
            $admission['time'][$i] = (strlen($i) == 1) ? '0' . $i : $i;
        }
        for ($i = 0; $i <= 59; $i++) {
            $admission['mins'][$i] = (strlen($i) == 1) ? '0' . $i : $i;
        }
      

        $Doctorslist = DoctorMaster::get_lists();
        $DoctorMaster = array();
        foreach ($Doctorslist as $doctor) {
            $DoctorMaster[$doctor->id]=$doctor->Name;
        }
        $baby->additional_diagnosis = '';

        $baby->TimeOfDiscussion      = isset($baby->TimeOfDiscussion) ? $baby->TimeOfDiscussion : '' ;
        $baby->TimeOfDiscussion_MINS = isset($baby->TimeOfDiscussion_MINS) ? $baby->TimeOfDiscussion_MINS : '' ;
        $baby->TimeOfDiscussion_AM   = isset($baby->TimeOfDiscussion_AM) ? $baby->TimeOfDiscussion_AM : '' ;
     
       
         $temp    = json_decode($baby->Gestation);
         $temp = is_array($temp) ? $temp : (array)$temp;
         $baby->g_weeks =  isset($temp['g_weeks']) ? $temp['g_weeks'] : null;  
         $baby->g_days  =  isset($temp['g_days']) ? $temp['g_days'] : null;
         unset($temp);

       
         if (!empty($baby->DOB) &&  date('Y', strtotime($baby->DOB)) > 1970) {
           $baby->DayOfLife = \SiteHelpers::calculate_day_of_life($baby->DOB);
         }

         if (!empty($baby->Gestation)) {

            $baby->Gestation = \SiteHelpers::convert_gestation_days($baby->Gestation);
         }

         if (isset($baby->DayOfLife) && !empty($baby->Gestation)) {
             $baby->CGA = \SiteHelpers::calculate_corrected_gestation($baby->Gestation, $baby->DayOfLife);
             $baby->cg_weeks =(int) $baby->CGA[0];
             $baby->cg_days  =(int) $baby->CGA[1];
         }
         
         $baby->DOB = date('Y', strtotime($baby->DOB)) > 1970 ? date('d-m-Y', strtotime($baby->DOB)) : '';

         $baby->DescriptionOfResuscitation = $neonatalperformaresults['OtherInformation'];

         $current_time    = (int)Carbon::now($this->zone)->format('h');
         $current_min     = (int)Carbon::now($this->zone)->format('i');
         $current_session = Carbon::now($this->zone)->format('A');
         $current_date    = Carbon::now($this->zone)->format('d-m-Y');

         $baby->AdmissionTime        = $current_time;
         $baby->AdmissionTime_MINS   = $current_min;
         $baby->AdmissionTime_AM     = $current_session;
         $baby->AdmissionDate        = $current_date;
         
         $baby->initial_assessment_completed_hr    = $current_time;
         $baby->initial_assessment_completed_min     = $current_min;
         $baby->initial_assessment_completed_session = $current_session;
         $baby->initial_assessment_completed_date    = $current_date;

         $admission_details  = IpNumber::where('AdmissionId', $admission_id)->first();
         $baby->ip_number    = isset($admission_details->ip_number) ? $admission_details->ip_number : '';
          
         $scanDetails     = Usg::where('BabyId', $id)->get();

        if (count($scanDetails) > 0) {
            $datingScan  = (array)$scanDetails->where('type',1)->where('flags',1)->first();
            $analogScan  = (array)$scanDetails->where('type',2)->where('flags',1)->first();
            $neonatalOtherscan   = $scanDetails->where('type',3)->where('flags',1)->toArray();
            $neonatalDopplerscan = $scanDetails->where('type',4)->where('flags',1)->toArray();
        }

         $nicuBedStatus = Nicu::where('BabyId', $id)->where('IsDeleted', 0)->get(); 
         $nicuBedStatus = count($nicuBedStatus) > 0 ? true : false; 
         $ward_list =  Ward::admission_ward_list()->pluck('name', 'id')->toArray();
         $room_list = array();
         $bed_list  = array();


            $neonatal = Neonatal::getNeonatalDependancy($id, 1);
            if(count($neonatal) > 0 && isset($neonatal[0])) {
                $neonatal = $neonatal[0];
                $baby->DescriptionOfResuscitation = $neonatal->OtherInformation;
          }
          $baby->ReferredBy = (!empty($baby->obstetric_consultant) ? \ValuelistHelpers::mas_referral_list($baby->obstetric_consultant) : '');
          
        // NICU - Machine Values
        // InitialBloodGas - Manual entry

        // $observation = DialpadSupportProperty::LOINC_LOCAL_CODE;
        // $observation = array_merge($observation, DialpadSupportProperty::EMR_LAB_VALUES);
        // $observation_field_name_list = [$observation[19], $observation[109], $observation[8], $observation[7], $observation[10], $observation[11], $observation[12], $observation[6], '', 'oxygen_saturation_index', $observation[90], $observation[91], $observation[92], $observation[93], $observation[94], $observation[146], $observation[175], $observation[6]];

        // $nicu_field_name_list = ['Mode', 'Mode_invasive', 'RR', 'HR', 'BP', 'diastolic_bp', 'MeanBP', 'Temperature', 'InitialBloodGas', 'SpO2', 'pH', 'PaO2', 'PaCo2', 'HCO3', 'BE', 'RBS', 'Hct', 'TemperatureAtAdmission'];
        
        // $monitor_results = EmrMoniterValues::getInterfacingData($id, $admission_id, $observation_field_name_list, '', '', 'asc');

        // $ventilator_results = EmrVentilatorValues::getInterfacingData($id, $admission_id, $observation_field_name_list, '', '', 'asc');

        // $lab_results = EmrLogHeader::getInterfacingData($id, $admission_id, $observation_field_name_list, '', '', 'asc');

        // $nurse_sheet_result = collect($monitor_results)->merge($ventilator_results);
        // $nurse_sheet_result = collect($nurse_sheet_result)->merge($lab_results);

        // $nurse_sheet_result = collect($nurse_sheet_result)->pluck('intf_ref_value', 'local_code');
        // $machine_data = [];

        // foreach ($observation_field_name_list as $key => $value) {
        //     if (isset($nicu_field_name_list[$key])) {
        //         $machine_key = $nicu_field_name_list[$key];
        //         if (!isset($results->$machine_key) && isset($nurse_sheet_result[$value])) {
        //             if ($machine_key == 'Mode' && !empty($nurse_sheet_result[$value])) {
        //                 $admission_mode = Admissionmode::ListData();
        //                 $machine_data[$machine_key] = array_search ($nurse_sheet_result[$value], $admission_mode);
        //             } else if ($machine_key == 'Mode_invasive' && !empty($nurse_sheet_result[$value])) {
        //                 $admission_mode = Admissionmode::ListData();
        //                 $machine_data[$machine_key] = array_search ($nurse_sheet_result[$value], $admission_mode);
        //             } else {
        //                 $machine_data[$machine_key] = $nurse_sheet_result[$value];
        //             }
        //         }
        //     }
        // }

        // if (count($lab_results) > 0 && !isset($results->age_hours) && !isset($results->age_mins)) {
        //     $first_lab_result = collect($lab_results)->first();
        //     $machine_data['age_hours'] = isset($first_lab_result->result_date_time) ? date('H', strtotime($first_lab_result->result_date_time)) : 0;
        //     $machine_data['age_mins'] = isset($first_lab_result->result_date_time) ? date('i', strtotime($first_lab_result->result_date_time)) : 0;
        // }

        // $baby = (array)$baby;

        // $baby = array_merge($baby, $machine_data);

        // $baby = (object)$baby;
          $baby->bed_id = $request->get('bed_id');
          $room_id = \SiteHelpers::getRoomBybed($baby->bed_id);
          $baby->room_id = isset($room_id->room_id) ? $room_id->room_id : '';

        $doctors_list = DoctorMaster::get_lists();
        $doctor_master = array('' => 'N/A');
        foreach ($doctors_list as $doctor)
        {
            $doctor_master[$doctor->id] = $doctor->Name;
        }

        // return view('admission.nicu.create', compact('SubmitButtonText', 'nicuBedStatus','room_list' , 'ward_list',  'bed_list','drugnew_data', 'neonatalDopplerscan','neonatalOtherscan','analogScan','datingScan','displayTypeofTreatment', 'baby', 'pbm_data', 'medications', 'complication', 'usg_findings', 'problem_master', 'procedure_master', 'antibiotic_master', 'drug_master', 'vaccine_master', 'complication_master', 'medi_probs_master', 'navigate', 'NAT', 'admission', 'ICD', 'old_ip', 'findings', 'gestations', 'DoctorMaster', 'admissionmode_master', 'admission_id'));
        return view('admission.nicu.create', compact('SubmitButtonText', 'nicuBedStatus','room_list' , 'ward_list',  'bed_list','drugnew_data', 'neonatalDopplerscan','neonatalOtherscan','analogScan','datingScan','displayTypeofTreatment', 'baby', 'pbm_data', 'medications', 'complication', 'usg_findings', 'problem_master', 'procedure_master', 'drug_master', 'vaccine_master', 'complication_master', 'medi_probs_master', 'navigate', 'NAT', 'admission', 'ICD', 'old_ip', 'findings', 'gestations', 'DoctorMaster', 'admissionmode_master', 'admission_id', 'doctor_master'));
    }

    /**
     * Display the admission form to create new admission.
     *
     * @param  int $id (The choosen baby id)
     *
     */
    public function show($id)
    {

        //
    }

    /**
     * Show the form for editing the specified record.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id, $search_data = '',  Request $request)
    {

        $id = \SiteHelpers::decrypt_id($id);
        if ($search_data == 'editmodule' || $search_data == '') {
            if (\Session::has('slug-nav')) {
                \Session::forget('slug-nav');
            }
        }

        $flow_wise_register = $request->get('flow');

        $navigate['main_nav'] = 'nicu';
        $navigate['sub_nav'] = 'nicu_proforma';

        if (\Session::has('slug-nav')) {
            $navigate['sub_nav'] = \Session::get('slug-nav');
        }

        $result = Nicu::get_record($id);

        $nicuChild = Nicu::find($id);

        $results = $result[0];

        $results->BMrNo = $results->baby_mr_no;

        if (date('Y', strtotime($results->DOB)) > 1980)
            $results->DOB = date('d-m-Y', strtotime($results->DOB));
        else
            $results->DOB = '';

        if (date('Y', strtotime($results->AdmissionDate)) > 1980)
            $results->AdmissionDate = date('d-m-Y', strtotime($results->AdmissionDate));
        else
            $results->AdmissionDate = '';

       // if (date('Y', strtotime($results->TransferDate)) > 1980)
           // $results->TransferDate = date('d-m-Y', strtotime($results->TransferDate));
     //   else
         //   $results->TransferDate = '';

        if (date('Y', strtotime($results->DischargeDate)) > 1980)
            $results->DischargeDate = date('d-m-Y', strtotime($results->DischargeDate));
        else
            $results->DischargeDate = '';

        if (date('Y', strtotime($results->initial_assessment_completed_date)) > 1980)
            $results->initial_assessment_completed_date = date('d-m-Y', strtotime($results->initial_assessment_completed_date));
        else
            $results->initial_assessment_completed_date = '';

        if (date('Y', strtotime($results->NextAppointment)) > 1980)
            $results->NextAppointment = date('d-m-Y', strtotime($results->NextAppointment));
        else
            $results->NextAppointment = '';

        if (date('Y', strtotime($results->DateofAdministration)) > 1980)
            $results->DateofAdministration = date('d-m-Y', strtotime($results->DateofAdministration));
        else
            $results->DateofAdministration = '';

        $vaccine = (!empty($results->Vaccine) && $results->Vaccine != null) ? json_decode($results->Vaccine) : [];
        $vaccine_date = (!empty($results->VaccineDate) && $results->VaccineDate != null) ? json_decode($results->VaccineDate) : [];
        
        $results->DifferentialDiagnosis = (!is_null($results->DifferentialDiagnosis) && !empty($results->DifferentialDiagnosis)) ? json_decode($results->DifferentialDiagnosis) : array();


        $results->TimeOfDiscussion = $results->TimeOfDiscussion_MINS = $results->TimeOfDiscussion_AM = '';
        
        if (isset($results->DiscussionTime) && !empty($results->DiscussionTime)) {
            $discussiontime=explode(':', $results->DiscussionTime);
            if (is_array($discussiontime) && count($discussiontime) > 1) {
                $results->TimeOfDiscussion       = $discussiontime[0];
                $results->TimeOfDiscussion_MINS  = $discussiontime[1];
                $results->TimeOfDiscussion_AM    = $discussiontime[2];
            }
        }

        $age_taken = explode(':', $results->AgeTaken);

        $results->age_hours = (isset($age_taken[0]) && !empty($age_taken[0])) ? $age_taken[0] : 0;
        $results->age_mins = (isset($age_taken[1]) && !empty($age_taken[1])) ? $age_taken[1] : 0;

        $admissionmode_master=AdmissionmodeMaster::ListData();

        $pbm_data = Problems::where('BabyId', '=', $results->BabyId)->get();
        $medications = Medications::where('BabyId', '=', $results->BabyId)->where('AdmissionId', '=', $results->AdmissionId)->where('flag', '=', 2)->get();
        $complication = Complication::where('BabyId', '=', $results->BabyId)->where('flags', $this->usg_flags)->get();
        $neonatal_complication =Complication::where('BabyId', '=', $results->BabyId)->where('flags', 1)->get(); 

        $usg_findings = Usg::where('MotherId', '=', $results->MotherId)
                          ->where('BabyId', '=', $results->BabyId)
                          ->where('flags', '=', $this->usg_flags)
                          ->first();
        $SubmitButtonText = "Update & Close";

        $Probs = MediprobsMaster::get_lists();
        $Complications = ComplicationMaster::get_lists();
        // $Antibiotic = AntibioticMaster::get_lists();

        // $antibiotic_master[0] = 'N/A';
        // foreach ($Antibiotic as $data) {
        //     $antibiotic_master[$data->Id] = $data->Name;
        // }

        $medi_probs_master[0] = 'N/A';
        foreach ($Probs as $data) {
            $medi_probs_master[$data->Id] = $data->Name;
        }
        $complication_master[0] = 'N/A';
        foreach ($Complications as $data) {
            $complication_master[$data->Id] = $data->Name;
        }

        $drugs = DrugIvFluidMaster::getOralDrug();
        $Vaccines = Vaccine::get_lists();
        $vaccine_master[0] = 'N/A';
        foreach ($Vaccines as $vac) {
            $vaccine_master[$vac->Id] = $vac->Name;
        }
        $drug_master[0] = 'N/A';
        foreach ($drugs as $drug) {
            $drug_master[$drug->Id] = $drug->Name;
        }
        $drug_value[0]='N/A';
        foreach ($drugs as $drugvalue) {
            $drug_value[$drug->Id] = $drug->Value;
        }


        // $antib_temp = AntibioticMaster::ListData();
        $procedure_temp = ProcedureMaster::ListData();

        // $antibiotic_data[0] = 'N/A';
        // foreach ($antib_temp as $data) {
        //     $antibiotic_data[$data->Id] = $data->Name;
        // }
        $procedure_master[0] = 'N/A';
        foreach ($procedure_temp as $data) {
            $procedure_master[$data->Id] = $data->Name;
        }

        $problem_temp = ProblemMaster::ListData();

        $problem_master[0] = 'N/A';
        foreach ($problem_temp as $data) {
            $problem_master[$data->Id] = $data->Name;
        }
        $NAT['time'] = array();
         $NAT['time']['']='N/A';
        for ($i = 1; $i <= 12; $i++) {
            $NAT['time'][$i] = (strlen($i) == 1) ? '0' . $i : $i;
        }
        $NAT['mins'] = array();
         $NAT['mins']['']='N/A';
        for ($i = 0; $i <= 59; $i++) {
            $NAT['mins'][$i] = (strlen($i) == 1) ? '0' . $i : $i;
        }

        $admission['time'] = $admission['mins'] = array();
        for ($i = 1; $i <= 12; $i++) {
            $admission['time'][$i] = (strlen($i) == 1) ? '0' . $i : $i;
        }
        for ($i = 0; $i <= 59; $i++) {
            $admission['mins'][$i] = (strlen($i) == 1) ? '0' . $i : $i;
        }
        $GetICD = Icd::where('ICDCode', '<>', '')->get();
        $ICD = array();
        foreach ($GetICD as $key => $value) {
            $ICD[$value->ICDCode] = $value->ICDDescription . '-' . $value->ICDCode;

        }
        $ip_details=IpNumber::getCurrent_ip($results->BabyId, $results->AdmissionId);
        $results->ip_number=(count($ip_details) > 0)? $ip_details->ip_number : '' ;

         $neonatal_usg_findings = Usg::where('MotherId', '=', $results->MotherId)
                                  ->where('BabyId', '=', $results->BabyId)
                                  ->where('flags', '=', 1)
                                  ->first();
       $empty_list=array();

      
       // $neonatal_findings = (count($neonatal_usg_findings) > 0)? unserialize($neonatal_usg_findings['Finding']) : $empty_list;
       // $neonatal_gestations = (count($neonatal_usg_findings) > 0)? unserialize($neonatal_usg_findings['Gestation']):$empty_list;

       //  $findings              = (count($usg_findings) > 0) ?  unserialize($usg_findings['Finding'])  : $empty_list;
       //  $gestations            = (count($usg_findings) > 0) ? unserialize($usg_findings['Gestation']) : $empty_list;


        $results->IVAntibiotic = ( !is_null($results->IVAntibiotic) && !empty($results->IVAntibiotic))?json_decode($results->IVAntibiotic)  : $empty_list;
        
        $displayTypeofTreatment = ($results->ROPTreatment == 'No') ? 'style = "display:none"' : '';

        $Doctorslist=DoctorMaster::get_lists();
        $DoctorMaster=array();
        foreach ($Doctorslist as $doctor) {
            $DoctorMaster[$doctor->id]=$doctor->Name;
        }
            
         $temp    = json_decode($results->CorrectedGestation);
         $temp    = is_array($temp) ? $temp : (array)$temp;
         $results->cg_weeks =  isset($temp['cg_weeks']) ? $temp['cg_weeks'] : null;  
         $results->cg_days  =  isset($temp['cg_days']) ? $temp['cg_days'] : null;
         unset($temp);

         $temp    = json_decode($results->Gestation);
         $temp = is_array($temp) ? $temp : (array)$temp;
         $results->g_weeks =  isset($temp['g_weeks']) ? $temp['g_weeks'] : null;  
         $results->g_days  =  isset($temp['g_days']) ? $temp['g_days'] : null;
         unset($temp);


         if (is_null($results->corrected_gestation)) {
             $results->DOB = date('Y-m-d', strtotime($results->DOB)) ;
             if (!empty($results->DOB)) {
               $results->DayOfLife = \SiteHelpers::calculate_day_of_life($results->DOB);
             }  
             if (!empty($results->Gestation)) {
                $results->Gestation = \SiteHelpers::convert_gestation_days($results->Gestation);
             }
              
             if (isset($results->DayOfLife) && !empty($results->DayOfLife)) {
                 $results->CGA = \SiteHelpers::calculate_corrected_gestation($results->Gestation, $results->DayOfLife);
                 $results->dcg_weeks =(int) $results->CGA[0];
                 $results->dcg_days  =(int) $results->CGA[1];
             }
         } else {
             $temp    = json_decode($results->corrected_gestation);
             $temp = is_array($temp) ? $temp : (array)$temp;
             $results->dcg_weeks =  $temp['dcg_weeks'];
             $results->dcg_days  =  $temp['dcg_days'];
             unset($temp);

         }

         
         $temp_gestation = is_numeric($results->Gestation) ? $results->Gestation :  \SiteHelpers::convert_gestation_days($results->Gestation);

         $neonatalOtherscan   = $nicuChild->getUsg->where('type', 3)->where('flags', 1)->toArray();
         $neonatalDopplerscan = $nicuChild->getUsg->where('type', 4)->where('flags', 1)->toArray();    

         $datingScan  = $nicuChild->getUsg->where('type', 1)->where('flags', 1)->first();
         $analogScan  = $nicuChild->getUsg->where('type', 2)->where('flags', 1)->first();
         $otherScan   = $nicuChild->getUsg->where('type', 3)->where('flags', $this->usg_flags)->toArray();
         $dopplerScan = $nicuChild->getUsg->where('type', 4)->where('flags', $this->usg_flags)->toArray();

         $procedure_master = ProcedureMaster::ListData()->pluck('Name', 'Id')->toArray();

         $datingScan  = (count($datingScan) > 0) ? $datingScan->toArray() : array();
         $analogScan  = (count($analogScan) > 0) ? $analogScan->toArray() : array();

         $results->TypeofTreatmen =  empty($results->TypeofTreatmen) ? array() : json_decode($results->TypeofTreatmen) ;

          $results->indication_of_admission = !is_null($results->indication_of_admission) ? json_decode($results->indication_of_admission) : array();
          if (isset($results->DOB) && !empty($results->DOB)) {
              $results->DOB = date('d-m-Y', strtotime($results->DOB));
          }

          if (empty($results->DescriptionOfResuscitation) || is_null($results->DescriptionOfResuscitation) || strlen($results->DescriptionOfResuscitation) <= 0) {
            $neonatal = Neonatal::getNeonatalDependancy($results->BabyId, 1);
            if(count($neonatal) > 0 && isset($neonatal[0])) {
                $neonatal = $neonatal[0];
                $results->DescriptionOfResuscitation = $neonatal->OtherInformation;
            }
          }
          $results->ReferredBy = (empty($results->ReferredBy) || is_null($results->ReferredBy) || strlen($results->ReferredBy) <= 0) ? (!empty($results->obstetric_consultant) ? \ValuelistHelpers::mas_referral_list($results->obstetric_consultant) : '') : $results->ReferredBy;
          
        // Discharge Lab Report - Machine Values
        // $lab_report_observe = DialpadSupportProperty::GLUCO_METER;

        // $lab_field_name_list = [$lab_report_observe[45], $lab_report_observe[26], '', $lab_report_observe[9], $lab_report_observe[10], $lab_report_observe[0], $lab_report_observe[2], $lab_report_observe[13], $lab_report_observe[41]];

        // $nicu_discharge_field_name_list = ['DischargeHb', 'DischargePCV', 'NicuDCT', 'DischargeTSB', 'direct_bilirubin', 'DischargeSerumCa', 'DischargeSerumPo4', 'DischargeSerumALP', 'DischargeSerumNa'];

        // $lab_results = EmrLogHeader::getInterfacingData($results->BabyId, $results->AdmissionId, $lab_field_name_list)->pluck('intf_ref_value', 'local_code');

        // $lab_interfacing_data = [];

        // foreach ($lab_field_name_list as $key => $value) {
        //     if (isset($nicu_discharge_field_name_list[$key])) {
        //         $lab_key = $nicu_discharge_field_name_list[$key];
        //         if (!isset($results->$lab_key) && isset($lab_results[$value])) {
        //             $lab_interfacing_data[$lab_key] = $lab_results[$value];
        //         }
        //     }
        // }

        // $results = (array)$results;

        // $results = array_merge($results, $lab_interfacing_data);

        // $results = (object)$results;

        // NICU Edit - Machine Values
        // InitialBloodGas - Manual entry

        // $observation = DialpadSupportProperty::LOINC_LOCAL_CODE;
        // $observation = array_merge($observation, DialpadSupportProperty::EMR_LAB_VALUES);
        // $observation_field_name_list = [$observation[19], $observation[109], $observation[8], $observation[7], $observation[10], $observation[11], $observation[12], $observation[6], '', 'oxygen_saturation_index', $observation[90], $observation[91], $observation[92], $observation[93], $observation[94], $observation[146], $observation[175], $observation[6]];

        // $nicu_field_name_list = ['Mode', 'Mode_invasive', 'RR', 'HR', 'BP', 'diastolic_bp', 'MeanBP', 'Temperature', 'InitialBloodGas', 'SpO2', 'pH', 'PaO2', 'PaCo2', 'HCO3', 'BE', 'RBS', 'Hct', 'TemperatureAtAdmission'];
        
        // $monitor_results = EmrMoniterValues::getInterfacingData($results->BabyId, $results->AdmissionId, $observation_field_name_list, '', '', 'asc');

        // $ventilator_results = EmrVentilatorValues::getInterfacingData($results->BabyId, $results->AdmissionId, $observation_field_name_list, '', '', 'asc');

        // $lab_results = EmrLogHeader::getInterfacingData($results->BabyId, $results->AdmissionId, $observation_field_name_list, '', '', 'asc');

        // $nurse_sheet_result = collect($monitor_results)->merge($ventilator_results);
        // $nurse_sheet_result = collect($nurse_sheet_result)->merge($lab_results);

        // $nurse_sheet_result = collect($nurse_sheet_result)->pluck('intf_ref_value', 'local_code');

        // $machine_data = [];

        // foreach ($observation_field_name_list as $key => $value) {
        //     if (isset($nicu_field_name_list[$key])) {
        //         $machine_key = $nicu_field_name_list[$key];
        //         if (!isset($results->$machine_key) && isset($nurse_sheet_result[$value])) {
        //             if ($machine_key == 'Mode' && !empty($nurse_sheet_result[$value])) {
        //                 $admission_mode = Admissionmode::ListData();
        //                 $machine_data[$machine_key] = array_search ($nurse_sheet_result[$value], $admission_mode);
        //             } else if ($machine_key == 'Mode_invasive' && !empty($nurse_sheet_result[$value])) {
        //                 $admission_mode = Admissionmode::ListData();
        //                 $machine_data[$machine_key] = array_search ($nurse_sheet_result[$value], $admission_mode);
        //             } else {
        //                 $machine_data[$machine_key] = $nurse_sheet_result[$value];
        //             }
        //         }
        //     }
        // }

        // if (count($lab_results) > 0 && !isset($results->age_hours) && !isset($results->age_mins)) {
        //     $first_lab_result = collect($lab_results)->first();
        //     $machine_data['age_hours'] = isset($first_lab_result->result_date_time) ? date('H', strtotime($first_lab_result->result_date_time)) : 0;
        //     $machine_data['age_mins'] = isset($first_lab_result->result_date_time) ? date('i', strtotime($first_lab_result->result_date_time)) : 0;
        // }

        $bed_logs = BedLog::where('baby_id', $results->BabyId)->orderBy('id', 'desc')->first();

        $results->room_id = isset($bed_logs->room_id) ? $bed_logs->room_id : 0;
        $results->bed_id = isset($bed_logs->bed_id) ? $bed_logs->bed_id : 0;
        $results->bed_no = isset($bed_logs->bed_no) ? $bed_logs->bed_no : 0;

        // $results = (array)$results;

        // $results = array_merge($results, $machine_data);

        // $results = (object)$results;

        // return view('admission.nicu.edit', compact('results', 'procedure_master', 'neonatalDopplerscan', 'temp_gestation', 'neonatalOtherscan', 'datingScan', 'analogScan', 'otherScan', 'dopplerScan', 'SubmitButtonText', 'pbm_data', 'medications', 'complication', 'usg_findings', 'problem_master', 'procedure_master', 'antibiotic_master', 'drug_master', 'vaccine_master', 'complication_master', 'medi_probs_master', 'search_data', 'navigate', 'NAT', 'admission', 'displayTypeofTreatment', 'vaccine', 'vaccine_date', 'ICD', 'old_ip', 'neonatal_complication', 'DoctorMaster', 'admissionmode_master', 'drug_value'));

        $doctors_list = DoctorMaster::get_lists();
        $doctor_master = array('' => 'N/A');
        foreach ($doctors_list as $doctor)
        {
            $doctor_master[$doctor->id] = $doctor->Name;
        }

        return view('admission.nicu.edit', compact('results', 'procedure_master', 'neonatalDopplerscan', 'temp_gestation', 'neonatalOtherscan', 'datingScan', 'analogScan', 'otherScan', 'dopplerScan', 'SubmitButtonText', 'pbm_data', 'medications', 'complication', 'usg_findings', 'problem_master', 'procedure_master', 'drug_master', 'vaccine_master', 'complication_master', 'medi_probs_master', 'search_data', 'navigate', 'NAT', 'admission', 'displayTypeofTreatment', 'vaccine', 'vaccine_date', 'ICD', 'old_ip', 'neonatal_complication', 'DoctorMaster', 'admissionmode_master', 'drug_value', 'flow_wise_register', 'id', 'doctor_master'));
    }

    /* PRINT DISPLAY FOR THE SPECIFIED RECORD */
    public function printData($id)
    {
        $id = \SiteHelpers::decrypt_id($id);
        $result = Nicu::get_record($id);
        $editor_gen_option = false;
        $results = $result[0];
        
        $pbm_data      = Problems::where('BabyId', '=', $results->BabyId)->get();
        $medications   = Medications::where('BabyId', '=', $results->BabyId)->where('AdmissionId', '=', $results->AdmissionId)->get();
        $complication  = Complication::where('BabyId', '=', $results->BabyId)->get();
        $usg_findings  = Usg::where('MotherId', '=', $results->MotherId)->where('BabyId', '=', $results->BabyId)->get();

        $Probs = MediprobsMaster::get_lists();
        $Complications = ComplicationMaster::get_lists();
        $delivery_details = Delivery::where('MotherId', '=', $results->MotherId)->get();


        $medi_probs_master[0] = '';
        foreach ($Probs as $data) {
            $medi_probs_master[$data->Id] = $data->Name;
        }
        $complication_master[0] = '';
        foreach ($Complications as $data) {
            $complication_master[$data->Id] = $data->Name;
        }

        $drugs = DrugIvFluidMaster::getOralDrug();
        $Vaccines = Vaccine::get_lists();
        $vaccine_master[0] = '';
        foreach ($Vaccines as $vac) {
            $vaccine_master[$vac->Id] = $vac->Name;
        }
        $drug_master[0] = '';
        foreach ($drugs as $drug) {
            $drug__master[$drug->Id] = $drug->Name;
        }

        // $antib_temp = AntibioticMaster::ListData();
        $procedure_temp = ProcedureMaster::ListData();

        // $antibiotic_data[0] = '';
        // foreach ($antib_temp as $data) {
        //     $antibiotic_data[$data->Id] = $data->Name;
        // }
        $procedure_master[0] = '';
        foreach ($procedure_temp as $data) {
            $procedure_master[$data->Id] = $data->Name;
        }

        $problem_temp = ProblemMaster::ListData();

        $problem_master[0] = '';
        foreach ($problem_temp as $data) {
            $problem_master[$data->Id] = $data->Name;
        }
        //create master lists
        $maternal_problems=array();
        foreach ($Probs as $key => $value) {

             $maternal_problems[$value->Id]=$value->Name;
        }
        $ip_details=IpNumber::getCurrent_ip($results->BabyId);
        $findings=$gestation=$date=array();

        // foreach ($usg_findings as $value) {

        //     $findings=(!empty($value->Finding))?array_merge($findings, (array)(@unserialize($value->Finding))):$findings;
        //     $gestation=(!empty($value->Gestation))?array_merge($gestation, (array)(@unserialize($value->Gestation))):$gestation;           
        // }

        foreach ($usg_findings as $value) {
            $date  = (!empty($value->date) || !empty($value->Gestation)) ? array_merge($date, (array)(!empty($value->date) ? date('d-m-Y', strtotime($value->date)) : '')):$date;
            $findings  = (!empty($value->Finding)) ? array_merge($findings, (array)$value->Finding):$findings;
            $gestation = (!empty($value->Gestation) || !empty($value->date)) ? array_merge($gestation, (array) $value->Gestation):$gestation;           
        }



        $icd_temp=Icd::get();
        $icd_master=array();
        foreach ($icd_temp as $icd_values) {
            $icd_master[$icd_values['ICDCode']]=$icd_values['ICDDescription'];    
        }

        $Indication = Indication::ListData();

        $mas_indication= array();
        foreach ($Indication as $indicate) {
            $mas_indication[$indicate->Id] = $indicate->indication_name; 
        }

        $closewinlink = action('Admission\NicuController@index');

        $results=(object)\SiteHelpers::formate_tags($this->tempTags, (array)$results);

        $editor_gen_option = $results->edited_content == NULL ? 1 : 0;

        foreach ($results as $key => &$value) {  

             $value = (empty($value) && !is_array($value) && !in_array($key, $this->unformat_print)) ? 'N/A' :  $value;  
        }


        // $results->neonatal_consultant = \SiteHelpers::formating_consultant_signature($results->neonatal_consultant, false, $results->hospital_name);
        $results->formatted_SeenBy = \ValuelistHelpers::signatureFormat($results->SeenBy);
        $results->neonatal_consultant = \ValuelistHelpers::signatureFormat($results->neonatal_consultant);
        //  $doctors = array();
        //  if (@unserialize($results->neonatal_consultant) !== false) {
        //      foreach(unserialize($results->neonatal_consultant) as $s_consultant) {
        //           if (trim($s_consultant) != '') {
        //               $temp_consultant[] = $s_consultant;
        //            }
        //      }
        //  }

        //  $consultant = array();
        // if (!is_null($results->neonatal_consultant) && count(@unserialize($results->neonatal_consultant)) > 0 && @unserialize($results->neonatal_consultant) !== false) {
        //   //$consultant =  array_filter(unserialize($results->neonatal_consultant), function($value) { return !is_null($value) || $value !== ''; });
        //      foreach(unserialize($results->neonatal_consultant) as $s_consultant) {
        //       if (trim($s_consultant) != '') {
        //           $consultant[] = $s_consultant;
        //        }
        //      }

        //   $doctors = DoctorMaster::whereIn('id', $consultant)->get();

        // }    


        $results->Gestation = \SiteHelpers::decode_gestation($results->Gestation);
        $results->CorrectedGestation = \SiteHelpers::decode_gestation($results->CorrectedGestation);

        $results->Indication= \SiteHelpers::get_master_formated_value($results->Indication, 'Indication', 'indication_name');
        
        $editor_gen = false;
        if (\Session::has('nicu-adm-editor'))
        {
            \Session::forget('nicu-adm-editor');
            $editor_gen = true;
            return view('admission.nicu.print', compact('results', 'pbm_data', 'medications', 'complication', 'usg_findings', 'problem_master', 'procedure_master', 'antibiotic_master', 'drug_master', 'vaccine_master', 'complication_master', 'medi_probs_master', 'ip_details', 'delivery_details', 'maternal_problems', 'findings', 'gestation', 'antibiotic_data', 'icd_master', 'mas_indication', 'closewinlink', 'doctors', 'editor_gen', 'editor_gen_option', 'date'))->renderSections();
        }

        return view('admission.nicu.print', compact('results', 'pbm_data', 'medications', 'complication', 'usg_findings', 'problem_master', 'procedure_master', 'antibiotic_master', 'drug_master', 'vaccine_master', 'complication_master', 'medi_probs_master', 'ip_details', 'delivery_details', 'maternal_problems', 'findings', 'gestation', 'antibiotic_data', 'icd_master', 'mas_indication', 'closewinlink', 'doctors', 'editor_gen_option', 'date'));
    }

    /**
     * Update the specified record in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id, NicuRequest $request)
    {
        $input = $request->all();

        $print_flag = isset($input['print_flag']) ? $input['print_flag'] : 0;
        unset($input['print_flag']);
        $nicu_details = Nicu::find($id);

        $input['BirthStatus'] = (isset($input['BirthStatus']) && $input['BirthStatus'] == 'on') ? 'Inborn' : 'Outborn';

        if ($input['status'] != 'Inpatient') {

            $baby_deitals = Baby::find($nicu_details['BabyId']);
            // $syringepump['baby_id']          = $nicu_details['BabyId'];
            // $syringepump['mother_id']        = isset($baby_deitals->MotherId) ? $baby_deitals->MotherId : null;
            // $syringepump['admission_id']     = $nicu_details['AdmissionId'];
            // $syringepump['admission_stauts'] = 4;

            // SyringePumpAdmisson::create($syringepump);

            $pump_condition['baby_id']      = $nicu_details['BabyId'];
            // $pump_condition['admission_id'] = $nicu_details['AdmissionId'];
            $pump_condition['status'] = 'Occupied';
            $pump_update['is_syringe_pump_connected'] = false;
            $pump_update['status']          = 'discharged';
            $pump_update['DateModified']    = Carbon::now($this->zone);
            $pump_update['UserModified']    = $this->auth->user()->id;

            $bed_log = BedLog::where($pump_condition)->orderby('id','desc')->first();
            BedLog::where($pump_condition)->Update($pump_update);
            if (count($bed_log) > 0) {
                Bed::where('id', $bed_log->bed_id)->Update(['status'=>null]);
                DeviceStatusNotification::where('baby_mrn', $baby_deitals->BMrNo)->Update(['status'=>false]);
            } 
        } else {
            if (isset($input['room_id']) && isset($input['bed_id'])) {
                $check_bed_log = BedLog::where(['baby_id' => $input['BabyId'], 'status' => 'Occupied'])->first();
                // $ward['ward_id'] = 1;
                $ward['ward_id'] = 1;
                $ward['ward_name'] = \SiteHelpers::gettable_values('ward', 'name', 'id', 1);
                $ward['room_id'] = $input['room_id'];
                $ward['room_no'] = \SiteHelpers::gettable_values('room', 'number', 'id', $input['room_id']);
                $ward['bed_id'] = $input['bed_id'];
                if ($input['bed_id'] != '' && !is_null($input['bed_id'])) {
                    $ward['bed_no'] = \SiteHelpers::gettable_values('bed', 'number', 'id', $input['bed_id']);
                }
                else
                {

                }
                $ward['baby_id'] = $input['BabyId'];
                $ward['admission_id'] = $nicu_details['AdmissionId'];
                $ward['DateAdded'] = Carbon::now($this->time_zone)->format('Y-m-d h:i a');
                $ward['UserAdded'] = $this->auth->user()->id;
                $ward['DateModified'] = Carbon::now($this->time_zone)->format('Y-m-d h:i a');
                $ward['UserModified'] = $this->auth->user()->id;
                $ward['IsDeleted'] = 0;
                $ward['status'] = 'Occupied';
                if (count($check_bed_log) == 0)
                {
                    $patient_bed_log = BedLog::create($ward);
                    Bed::where('id', $input['bed_id'])->update(['status' => 'Occupied']);
                }
                else
                {
                    BedLog::where(['baby_id' => $input['BabyId'], 'status' => 'Occupied'])->Update($ward);
                    
                    Bed::where('id', $check_bed_log->bed_id)->update(['status' => NULL]);

                    Bed::where('id', $input['bed_id'])->update(['status' => 'Occupied']);   
                }

            }
        }

        $input['g_weeks'] = !empty($input['g_weeks']) ? $input['g_weeks'] : null;
        $input['g_days']  = !empty($input['g_days']) ?  $input['g_days']  : 0;

        $input['cg_weeks'] = (isset($input['cg_weeks']) && !empty($input['cg_weeks'])) ? $input['cg_weeks'] : 0;
        $input['cg_days']  = (isset($input['cg_days']) && !empty($input['cg_days'])) ?  $input['cg_days']  : 0;
        
        // $input['cg_weeks'] = !empty($input['cg_weeks']) ? $input['cg_weeks'] : null;
        // $input['cg_days']  = !empty($input['cg_days']) ?  $input['cg_days']  : 0;
        $input['dcg_weeks'] = (isset($input['dcg_weeks']) && !empty($input['dcg_weeks']))? $input['dcg_weeks'] : 0;
        $input['dcg_days']  = (isset($input['dcg_days']) && !empty($input['dcg_days'])) ?  $input['dcg_days']  : 0;


        // AutoTagMasters::auto_key_support($this->tempTags,$input);

         
        $input['VentilationRequired'] = (isset($input['VentilationRequired']) && $input['VentilationRequired'] =='on') ? 'Yes' : 'No' ;

        $input['DateModified'] = Carbon::now();
        $input['DOB'] = date('Y-m-d', strtotime($input['DOB']));

        $input['AdmissionDate'] = !empty($input['AdmissionDate']) ? date('Y-m-d', strtotime($input['AdmissionDate'])) : null;

        $input['DischargeDate'] = !empty($input['DischargeDate']) ? date('Y-m-d', strtotime($input['DischargeDate'])) : null;
       // $input['TransferDate'] = date('Y-m-d', strtotime($input['TransferDate']));
        $input['initial_assessment_completed_date'] = !empty($input['initial_assessment_completed_date']) ? date('Y-m-d', strtotime($input['initial_assessment_completed_date'])) : null;
        
        $input['NextAppointmentStatus'] = (isset($input['NextAppointmentStatus']) && $input['NextAppointmentStatus'] =='on') ? 'Yes' : 'No';
        $input['indication_of_admission'] =  isset($input['indication_of_admission']) ? json_encode($input['indication_of_admission']) : null;

        $input['NextAppointment']        = (isset($input['NextAppointment']) && !empty($input['NextAppointment'])) ? date('Y-m-d', strtotime($input['NextAppointment'])) : null;
        $input['DateofAdministration']   = (isset($input['DateofAdministration']) && !empty($input['DateofAdministration'])) ? date('Y-m-d', strtotime($input['DateofAdministration'])): null;
        $input['Vaccine']                = (isset($input['VaccineDate']) && count($input['Vaccine']) != 0) ? json_encode($input['Vaccine']) : null;
        $input['VaccineDate']            = (isset($input['VaccineDate']) && count($input['VaccineDate']) != 0) ? json_encode($input['VaccineDate']) : null;
        
        $input['DifferentialDiagnosis']  = !empty($input['DifferentialDiagnosis']) ? json_encode($input['DifferentialDiagnosis']) : json_encode(array());
        $input['TimeOfDiscussion']       = (strlen($input['TimeOfDiscussion'])==1)?'0'.$input['TimeOfDiscussion']:$input['TimeOfDiscussion'];
        $input['TimeOfDiscussion_MINS']  = (strlen($input['TimeOfDiscussion_MINS'])==1)?'0'.$input['TimeOfDiscussion_MINS']:$input['TimeOfDiscussion_MINS'];
        $input['DiscussionTime']         = $input['TimeOfDiscussion'].':'.$input['TimeOfDiscussion_MINS'].':'.$input['TimeOfDiscussion_AM'];
        $input['additional_diagnosis']   = (isset($input['additional_diagnosis']) && count($input['additional_diagnosis']) > 0) ? json_encode($input['additional_diagnosis']) : json_encode(array());
        $input['Gestation']              = json_encode(array('g_weeks'=>$input['g_weeks'], 'g_days'=>$input['g_days'])); 
        $input['CorrectedGestation']     = json_encode(array('cg_weeks'=>$input['cg_weeks'], 'cg_days'=>$input['cg_days'])); 
        $input['corrected_gestation']    = json_encode(array('dcg_weeks'=>$input['dcg_weeks'], 'dcg_days'=>$input['dcg_days'])); 
        $input['TypeofTreatmen']         = isset($input['TypeofTreatmen']) ? json_encode($input['TypeofTreatmen']) : json_encode(array());
        $input['delivery_cpap']          = (isset($input['delivery_cpap']) && $input['delivery_cpap'] == 'on') ? 'Yes' : 'No' ;       
        $input['air_flow']               = (isset($input['air_flow']) && !empty($input['air_flow'])) ? $input['air_flow'] : null;
        $input['oxgen_flow']             = (isset($input['oxgen_flow']) && !empty($input['oxgen_flow'])) ? $input['oxgen_flow'] : null;
        $input['diastolic_bp']           = (isset($input['diastolic_bp']) && !empty($input['diastolic_bp'])) ? $input['diastolic_bp'] : null; 
        $input['typeoftreatment_left']   = isset($input['typeoftreatment_left']) ?  json_encode($input['typeoftreatment_left']) : json_encode(array());
        $input['typeoftreatment_right']  = isset($input['typeoftreatment_right']) ? json_encode($input['typeoftreatment_right']) :  json_encode(array());
        $input['procedures']             = isset($input['procedures']) ? json_encode($input['procedures']) : json_encode(array());
        if (isset($input['gestations'])) {
            $input['gestations']   = (count($input['gestations']) != 0) ? serialize($input['gestations']) : serialize(array());
            $input['findings']     = (count($input['findings']) != 0) ? serialize($input['findings']) : serialize(array());
        }   
        if (isset($input['IVAntibiotic'])) {
            $input['IVAntibiotic'] =(count($input['IVAntibiotic'])!=0) ? json_encode($input['IVAntibiotic']) : json_encode(array());

        } else {
            $input['IVAntibiotic'] = json_encode(array());
        }
        $baby = Baby::FindorFail($input['BabyId']);
        
        $input['DateModified'] = Carbon::now($this->time_zone)->format('Y-m-d h:i a');
        $input['UserModified'] = $this->auth->user()->id;

        $baby->update($input);

        $input['Ventilation'] = (isset($input['Ventilation']) && $input['Ventilation'] =='on') ? 'Yes' : 'No' ;
        $input['UAC'] = (isset($input['UAC']) && $input['UAC'] =='on') ? 'Yes' : 'No' ;
        $input['UVC'] = (isset($input['UVC']) && $input['UVC'] =='on') ? 'Yes' : 'No' ; 
        $input['ParentsSpokenTo'] = (isset($input['ParentsSpokenTo']) && $input['ParentsSpokenTo'] =='on') ? 'Yes' : 'No';

        $input['diedTime'] = !empty($input['diedTime']) ? $input['diedTime']: null;
        $input['diedMins'] = ($input['diedMins'] != '') ? $input['diedMins']: null;

        $input['discharge_femoral_pulses'] = !empty($input['discharge_femoral_pulses']) ? $input['discharge_femoral_pulses'] : null;

        $input['age_hours'] = (isset($input['age_hours']) && !empty($input['age_hours'])) ? $input['age_hours'] : 0;
        $input['age_mins'] = (isset($input['age_mins']) && !empty($input['age_mins'])) ? $input['age_mins'] : 0;

        $input['AgeTaken'] = $input['age_hours'] . ':' . $input['age_mins'];
        $input['SeenBy'] = isset($input['SeenBy']) ? json_encode($input['SeenBy']) : null;
        
        $results1 = Nicu::findOrfail($id);

        if ($results1['form_status'] != 2) {
            $input['form_status'] = !isset($input['formstatus']) ? 1 : $input['formstatus'];
        }
        $input['lab_lactate'] = isset($input['lab_lactate']) ? $input['lab_lactate'] : null;        
        $results1->update($input);

        $baby_admission = Admission::getBaby($input['BabyId']);
            if ($baby_admission->Status == 'Transferred' && $results1->status == 'Transferred') {
                $postnatalDischarge = PostnatalDischarge::getPostanatalDischargeeDetails($input['BabyId'], $baby_admission->AdmissionId);
                $postnatalDischargeStatus = PostnatalDischarge::find($postnatalDischarge->posdisid);
                $postnatalDischarge  = (array)$postnatalDischarge;
                $postnatalDischargeStatus->update($postnatalDischarge);

                $baby_admission->Status = 'Transferred';
                $nicu_discharge_status = Admission::find($baby_admission->AdmissionId);
                $baby_admission  = (array)$baby_admission;
                
                $nicu_discharge_status->Update($baby_admission); 
            } elseif ($results1->status == 'Discharged') {
                $baby_admission->Status = 'Discharged';
                $nicu_discharge_status = Admission::find($baby_admission->AdmissionId);
                $baby_admission  = (array)$baby_admission;
                $nicu_discharge_status->Update($baby_admission);
            }


        if ($input['status'] != 'Inpatient' && $input['status'] != 'Transferred') {

            $postnatalStatus['discharge_status'] = $input['status'];
            $postnatalDischarge = PostnatalDischarge::where('BabyId', $input['BabyId'])
                                                  ->where('AdmissionId', $results1->AdmissionId)
                                                  ->Update($postnatalStatus);
            $neonatalDischarge['Status'] = $input['status'];
            $neonatalDischarge['DateModified'] = Carbon::now();
            $neonatalDischarge['UserModified'] = $this->auth->user()->id;
            Neonatal::where('BabyId', $input['BabyId'])->Update($neonatalDischarge);

        }

        $newborn = NicuNewborn::find($input['BabyId']);
        if ($newborn) {
            $newborn->update($input);
        } else {
            $input['DateAdded'] = Carbon::now($this->time_zone)->format('Y-m-d h:i a');
            $input['UserAdded'] = $this->auth->user()->id;
            NicuNewborn::create($input);
        }

       

        $pbm_data = Problems::where('BabyId', '=', $input['BabyId'])->delete();
        if (isset($input['Problems'])) {
             $length = sizeof($input['Problems']);
            foreach ($input['Problems'] as $key => $value) {
              if ($input['Problems'][$key]!=0) {  
                $pbms = array(
                    'Problem' => $input['Problems'][$key],
                    'Medication' => $input['Medications'][$key],
                    'MotherId' => $input['MotherId'],
                    'BabyId' => $input['BabyId']
                );
                Problems::create($pbms);
              }  
            }
        }
      //   $discharge_medications = Medications::where('BabyId', '=', $input['BabyId'])
      //                             ->where('AdmissionId', '=', $results1->AdmissionId)
      //                             ->where('flag', '=', 2)
      //                             ->delete();
      // if (isset($input['M_Drugs'])) {                            
      //   for ($i = 0; $i < sizeof($input['M_Drugs']); $i++) {
      //       $discharge_medications = array(
      //           'Medication' => empty($input['formulation'][$i]) ? $input['M_Drugs'][$i] :$input['formulation'][$i] ,
      //           'Dose' => $input['M_Dose'][$i],
      //           'Frequency' => $input['M_Frequency'][$i],
      //           'Duration' => $input['M_Duration'][$i],
      //           'genericname'=>$input['m_generic_name'][$i],
      //          'formulation'=>$input['formulation'][$i],
      //           'AdmissionId' => $results1->AdmissionId,
      //           'BabyId' => $input['BabyId'],
      //           'flag'  => 2,
      //           'source_id'=>0
      //       );
      //       Medications::create($discharge_medications);
      //   }
      //  } 

        Complication::where('BabyId', '=', $input['BabyId'])->where('flags', $this->usg_flags)->delete();
       
        if (isset($input['Complication'])) {

            foreach ($input['Complication'] as $key => $value) {                
                if ($input['Complication'][$key]!='' && $input['Complication'][$key]!=0) {
                    $comps = array(
                        'Complication' => $input['Complication'][$key],
                        'Treatment' => $input['Treatments'][$key],
                        'AdmissionId'   => 1,
                        'BabyId'    => $input['BabyId'],
                        'flags'    =>$this->usg_flags,
                    );
                    Complication::create($comps);
                }
            }
        }

         //create usg and findings for dating scan

            if ((isset($input['datingdate']) && !empty($input['datingdate'])) || (isset($input['datinggestations']) && !empty($input['datinggestations']))) {
            $usg_parameters['BabyId']   = $input['BabyId'];
            $usg_parameters['MotherId'] = $input['MotherId'];
            $usg_parameters['flags']    = 1;
            $usg_parameters['type']     = 1;
            Usg::where($usg_parameters)->delete();
                $usg_parameters['date'] = !empty($input['datingdate']) ? date('Y-m-d', strtotime($input['datingdate'])) : null;
                $usg_parameters['Gestation'] = $input['datinggestations'];
                $usg_parameters['Finding']   = $input['datingfindings'];
                Usg::create($usg_parameters);
            unset($usg_parameters);
    }


        //creating usg adn findings for anolog scan
            if ((isset($input['analogdate']) && !empty($input['analogdate'])) || (isset($input['analoggestations']) && !empty($input['analoggestations']))) {
            $usg_parameters['BabyId']   = $input['BabyId'];
            $usg_parameters['MotherId'] = $input['MotherId'];
            $usg_parameters['flags']    = 1;
            $usg_parameters['type']     = 2;
            Usg::where($usg_parameters)->delete();
                $usg_parameters['date'] = !empty($input['analogdate']) ? date('Y-m-d', strtotime($input['analogdate'])) : null;
                $usg_parameters['Gestation'] = $input['analoggestations'];
                $usg_parameters['Finding']   = $input['analogfindings'];
                Usg::create($usg_parameters);
            unset($usg_parameters);
    }    

        //creating usg adn findings for other scan
        $usg_parameters['BabyId']   = $input['BabyId'];
        $usg_parameters['MotherId'] = $input['MotherId'];
        $usg_parameters['flags']    = $this->usg_flags;
        $usg_parameters['type']     = 3;
        Usg::where($usg_parameters)->delete();

        if (isset($input['otherdate']) || isset($input['othergestations'])) {

            foreach ($input['othergestations'] as $key => $value) {
           
            if ((isset($input['otherdate'][$key]) && !empty($input['otherdate'][$key])) || (isset($input['othergestations'][$key]) && !empty($input['othergestations'][$key]))) {
                $usg = array(
                    'date'      => !empty($input['otherdate'][$key]) ? date('Y-m-d', strtotime($input['otherdate'][$key])) : null,
                    'Gestation' => $input['othergestations'][$key],
                    'Finding'   => $input['otherfindings'][$key],
                    'MotherId'  => $input['MotherId'],
                    'BabyId'    => $input['BabyId'],
                    'flags'     => $this->usg_flags,
                    'type'      => 3,
                );
                Usg::create($usg);
              }     

            }   

        }

        //creating usg adn findings for doppler scan
        $usg_parameters['BabyId']   = $input['BabyId'];
        $usg_parameters['MotherId'] = $input['MotherId'];
        $usg_parameters['flags']    = $this->usg_flags;
        $usg_parameters['type']     = 4;
        Usg::where($usg_parameters)->delete();

        if (isset($input['dopplerdate']) || isset($input['dopplergestations'])) {

            foreach ($input['dopplergestations'] as $key => $value) {
           
             if ((isset($input['dopplerdate'][$key]) && !empty($input['dopplerdate'][$key])) || (isset($input['dopplergestations'][$key]) && !empty($input['dopplergestations'][$key]))) {
                $usg = array(
                    'date'      => !empty($input['dopplerdate'][$key]) ? date('Y-m-d', strtotime($input['dopplerdate'][$key])) : null,
                    'Gestation' => $input['dopplergestations'][$key],
                    'Finding'   => $input['dopplerfindings'][$key],
                    'MotherId'  => $input['MotherId'],
                    'BabyId'    => $input['BabyId'],
                    'flags'     => $this->usg_flags,
                    'type'      => 4,
                );

                Usg::create($usg);
              }     

            }   

        }
        $ip_number_old=IpNumber::getCurrent_ip($input['BabyId'], $results1->AdmissionId);
        $ip_data['baby_id']         =   $input['BabyId'];   
        $ip_data['ip_number']       =   $input['ip_number'];
        $ip_data['status']          =   1; 
        $ip_data['AdmissionId']     =   $results1->AdmissionId;
        if (count($ip_number_old)>0) {
            $ip_data['DateModified']    =  Carbon::now();
            $update_ip=IpNumber::findOrfail($ip_number_old->id);
            $update_ip->update($ip_data);
        } 
        else {

            $ip_data['DateAdded']       =  Carbon::now();
            $ip_data['DateModified']    =  Carbon::now();
            if (isset($input['ip_number']) && $input['ip_number'] != '' && !is_null($input['ip_number'])) { 
                IpNumber::create($ip_data);
             } 
        }

         $menu   = isset($_COOKIE['nicuform']) ? $_COOKIE['nicuform'] : '';
         $module =  (\Session::has('admission_module') && \Session::get('admission_module') =='NICU_ADMISSION') ? 'NICU_FORM' : 'NICU_DISCHARGE';

         // Nicu dashboard data updating call
        \SiteHelpers::updateDashboardAtFormUpdation($input['BabyId'], 'NICU Admission');        
       
        if ($request->ajax()) {
            return \Response::json(['type' => 'success', 'message' => 'Neonatal proforma created successfully !', 'edit_url' => action('Admission\NicuController@edit', \SiteHelpers::encrypt_id($id)), 'list_url' => action('Admission\NicuController@nicuSublists', \SiteHelpers::encrypt_id($input['BabyId'])), 'print_url'=> action('Admission\NicuController@printData', \SiteHelpers::encrypt_id($id)), 'daycare_summary_url'=> action('Reports\NicuDischargeController@index', \SiteHelpers::encrypt_id($input['BabyId'].'-'.$results1->AdmissionId)), 'problem_summary_url'=>action('Reports\ProblemDischargeController@dischargeSummary', \SiteHelpers::encrypt_id($input['BabyId'].'-'.$results1->AdmissionId)), 'discharge_list_url'=> action('Admission\NicuController@dischargeList').'?status=discharged', 'ward_dashboard_url'=> url('ward-dashboard')], 200);
        }

        if ($print_flag == 1) {
            if ($input['module'] == 'dischargeform') { 
                return redirect(action('Reports\NicuDischargeController@index', \SiteHelpers::encrypt_id($input['BabyId'].'-'.$results1->AdmissionId)))->with('Success', 'Record updated successfully !');
            } else {
                return redirect(action('Admission\NicuController@printData', \SiteHelpers::encrypt_id($id)))->with('Success', 'Record updated successfully ');
            }
        } elseif ($print_flag == 11) {
            if ($input['module'] == 'dischargeform') { 
                return redirect(action('Reports\ProblemDischargeController@dischargeSummary', \SiteHelpers::encrypt_id($input['BabyId'].'-'.$results1->AdmissionId)))->with('Success', 'Record updated successfully !');
            } else {
                return redirect(action('Admission\NicuController@printData', \SiteHelpers::encrypt_id($id)))->with('Success', 'Record updated successfully ');
            }
        } elseif ($print_flag == 2) {

           $this->flow->flowlog($module, $input['BabyId'], $input['MotherId'], $results1->AdmissionId, false, $menu);
           return redirect(action('Admission\NicuController@edit', \SiteHelpers::encrypt_id($id)))->with('Success', 'Record updated successfully !');

        } elseif($print_flag == 7) {

            $this->flow->flowlog($module, $input['BabyId'], $input['MotherId'], $results1->AdmissionId, true, $menu);
            $this->flow->clearFlow(); 

            return redirect(action('Reports\NicuDischargeController@index', \SiteHelpers::encrypt_id($input['BabyId'].'-'.$results1->AdmissionId)))->with('Success', 'Record updated successfully !');

        } elseif($print_flag == 8 && isset($input['admission_tag'])) {
            $admission_tag = ($input['admission_tag'] == 'NICU_MULTIPLE_PREGANANCY') ? 'NICU_ADMISSION' : 'POSTNATAL_ADMISSION';
            \Session::put('admission_module', $admission_tag);
            \Session::put('current_module', 'BABY_REG');
            $this->flow->flowlog('BABY_REG', 0, $input['MotherId'], 0, true, '');

            return redirect(action('Registration\BabyController@create', \Session::put('mother_id')))->with('Success', 'Record updated successfully !');

        } else {
            $this->flow->flowlog($module, $input['BabyId'], $input['MotherId'], $results1->AdmissionId, true, $menu);
            $this->flow->clearFlow(); 

            // if (\Session::has('slug-nav')) {
            //    return redirect(action('Admission\NicuController@dischargeList'). '?status=discharged')->with('Success', 'Record updated successfully !');
            // }
            return redirect(action('Admission\NicuController@nicuSublists', \SiteHelpers::encrypt_id($input['BabyId'])))->with('Success', 'Record updated successfully !');
        }
    }

    /**
     * Update the record as deleted and create the request for approval.
     *
     * @param  int $id
     */
    public function destroy($id)
    {
        $results = Nicu::findOrfail($id);
        $user_detail = array(
            'UserDeleted' => $this->auth->user()->id,
            'DateModified' => Carbon::now(),
            'IsDeleted' => '1'
        );
        $results->update($user_detail);
        $result = Nicu::get_record($id);
        $res = $result[0];

        $delete_data = array(
            'Name' => $res->BabyName,
            'AdmissionDate' => $results['AdmissionDate'],
            'ModuleController' => 'Admission\NicuController',
            'ModuleId' => $id,
            'ModuleName' => 'NICU Admission',
            'UserDeleted' => $this->auth->user()->id,
            'DateDeleted' => Carbon::now()
        );
        DeleteApproval::create($delete_data);
        return redirect(action('Admission\NicuController@index'))->with('info', 'Record deleted successfully !');
    }

    /* Fetch data for view popup via ajax */
    public function getData($id)
    {
        $result                        = Nicu::get_record($id);
        $results                       = (array)$result[0];
        $results['Gestation']          = \SiteHelpers::decode_gestation($results['Gestation']);
        $results['CorrectedGestation'] = \SiteHelpers::decode_gestation($results['CorrectedGestation']);
        $results['TestTime']           = $results['NAT_TIME'].':'.$results['NAT_MINS'].' '.$results['NAT_AM'];
        $results['AdmissionDate']      = date('d-m-Y', strtotime($results['AdmissionDate']));
        $results['AdmissionTime']      = (strlen($results['AdmissionTime'])==1)?('0'.$results['AdmissionTime']):$results['AdmissionTime'];
        $results['AdmissionTime_MINS'] = (strlen($results['AdmissionTime_MINS'])==1)?('0'.$results['AdmissionTime_MINS']):$results['AdmissionTime_MINS'];
        $results['AdmissionTime']      = $results['AdmissionTime'].':'.$results['AdmissionTime_MINS'].' '.$results['AdmissionTime_AM'];
        $results['DOB']                = date('d-m-Y', strtotime($results['DOB']));
        return json_encode($results);
    }

    /* Fetch data for search filter */
    public function searchData(Request $request)
    {
        $data = $request->get('data1');
        $results = Nicu::GetSearchDatas($data);
        return json_encode($results);
    }

    public function dischargeList(Request $request)
    {
        $limit = 50;
        if (!empty($request->input('limit'))) {
            $request->session()->put('limit', $request->input('limit'));
            $limit = $request->session()->get('limit');
        } elseif ($request->session()->has('limit')) {
            $limit = $request->session()->get('limit');
        }

        $order['sortby']    = 'baby.BabyId';
        $order['sortorder'] = 'desc';  

        if (!empty($request->input('sortby')) && !empty($request->input('sortorder'))) {
          $order['sortby']     = \SiteHelpers::decrypt_id($request->input('sortby'));
          $order['sortorder']  = $request->input('sortorder');
        }    

        $search = array();
         $search['search_txt']='';
        if (!empty($request->input('search_txt'))) {
            $search['search_txt'] = $request->input('search_txt');
        }

        $navigate['main_nav'] = 'nicu';
        $navigate['sub_nav'] = 'discharge-list';

	    $status = !empty($request->input('status')) ? $request->input('status') : 'inpatient';

        $page = !empty($request->input('page')) ? $request->input('page') : 1;
        $page = preg_replace( '/[^0-9]/', '', $page);

        $result   = Nicu::get_lists($page, $limit, $search, $order, 1, $status);
        $results  = $result['result'];
        $getTotal = Nicu::GetTotal();
        $total    = $result['total']; 

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

        foreach ($results as $key => $value) {
           $results[$key]->rowcolor ='';
            if (trim($results[$key]->status) == 'Inpatient') {
                $results[$key]->rowcolor ='info';
            } else {
                $results[$key]->rowcolor ='success';  
            } 
        }

        $admission_status = $request->input('admission_status') == 1 ? true : false;

        return view('admission.nicu.dischargelist', compact('results', 'navigate', 'pagination', 'order', 'search', 'getTotal', 'status', 'admission_status'));

    }
     public function dischargeSublist($id = '')
     {

        $navigate['main_nav'] = 'nicu';
        $navigate['sub_nav'] = 'discharge-list';
        $babyId  =  \SiteHelpers::decrypt_id($id);
        $results = Nicu::get_sub_lists($babyId);
        $total = Nicu::GetTotal();  
        $BabyName=isset($results[0]->BabyName) ? $results[0]->BabyName : '';
        $babyMrno=isset($results[0]->BMrNo) ? $results[0]->BMrNo : '';
        
        return view('admission.nicu.discharge_sub_list', compact('results', 'navigate', 'BabyName', 'babyMrno'));

    }

    public function nicuBabyadmission($baby_id = '')
    {
        $baby_id = \SiteHelpers::decrypt_id($baby_id);
        $results_temp  = Nicu::getBabyadmissonIds($baby_id);
        $admissionList = array(\SiteHelpers::encrypt_id($baby_id) => 0);
        if (count($results_temp) > 0) {
           foreach ($results_temp as $baby_list) {
            if (isset($baby_list->AdmissionId) && !empty($baby_list->AdmissionId)) {
              $admissionList[\SiteHelpers::encrypt_id($baby_list->BabyId.'-'.$baby_list->AdmissionId)] = $baby_list->episodes;  
            }  
              
           }
           return \Response::json(['status'=>true, 'message'=>$admissionList], 200);
        }

        return \Response::json(['status'=>false, 'message'=>$admissionList], 200);

    }

    public function nicuDischarge($baby_id = '')
    {

        if (empty($baby_id) || is_null($baby_id)) {
            throw new InvalidInputException(\SiteHelpers::getUserExceptionMessage('7001'), 7001);
        }
        $results = Nicu::getNicuDischarge($baby_id);
        return \Response::json(['status'=>true,'results'=> $results], 200);


    }

    /** 
     * This method to get age on admission in hours 
     *
     *  
     * @return type json
     */
   
    public function getageonadmission(Request $request)
    {
       $input = $request->all();  
       $baby  = Baby::find($input['babyId']);
       $input['admissionTime'] = strlen($input['admissionTime']) == 1 ? '0'.$input['admissionTime'] : $input['admissionTime'];
       $input['admissionMins'] = strlen($input['admissionMins']) == 1 ? '0'.$input['admissionMins'] : $input['admissionMins'];

       $end_date = $input['admissionDate'].' '.$input['admissionTime'].':'.$input['admissionMins'].' '.$input['admissionSession'];


       $baby->TOB_TIME = (isset($baby->TOB_TIME) && !empty($baby->TOB_TIME)) ? $baby->TOB_TIME : '00';
       $baby->TOB_MINS = (isset($baby->TOB_MINS) && !empty($baby->TOB_MINS)) ? $baby->TOB_MINS : '00';
       $baby->TOB_AM = (isset($baby->TOB_AM) && !empty($baby->TOB_AM)) ? $baby->TOB_AM : 'AM';
       
       $baby->TOB_TIME = strlen($baby->TOB_TIME) == 1 ? '0'.$baby->TOB_TIME : $baby->TOB_TIME ;
       $baby->TOB_MINS = strlen($baby->TOB_MINS) == 1 ? '0'.$baby->TOB_MINS : $baby->TOB_MINS ;

       $start_date     = $baby->DOB.' '.$baby->TOB_TIME.':'.$baby->TOB_MINS.' '.$baby->TOB_AM;
       $end_date       = date('Y-m-d h:i a', strtotime($end_date));

       $start_date      = Carbon::createFromFormat('Y-m-d h:i a', $start_date);
       $end_date        = Carbon::createFromFormat('Y-m-d h:i a', $end_date);
       $difference_hour = $start_date->diffInHours($end_date, false);

       return \Response::json(['age_on_admission'=> $difference_hour],200);
        
    }    

    /**
     * OPEN REPORT WITH FULL EDITOR
     *
     */
    public function getfullEditor(Request $request)
    {
        $input = $request->all();
        \Session::put('nicu-adm-editor', true);
        return \Response::json(['dataUrl' => $input['dataUrl'], 'nicu_id' => $input['nicu_id']], 200);

    }

    /**
     * OPEN REPORT WITH FULL EDITOR
     *
     */
    public function saveFullEditor(Request $request)
    {

        // assign inputs to variable
        $input = $request->all();

        $nicu = Nicu::findOrfail($input['nicu_id']);

        $nicu->update(['edited' => true, 'edited_content' => $input['nicu_report'], 'edited_time' => Carbon::now($this->time_zone) ]);

        // create slug for updated
        $nicu_id = $input['nicu_id'];
        
        if ($request->ajax()) {
            return \Response::json(['type'=>'success','msg' => 'Record Updated Successfully']);
        } 
        else {
            return redirect(action('Admission\NicuController@getAbbreviatedsummaryShow', $nicu_id))->with('success', 'Record updated successfully');
        }
    }

    public function getAbbreviatedsummaryShow(Request $request, $id)
    {
        $id_list = $id;

        $dischargeSummarymodified = array();

        if (isset($id_list) && !empty($id_list))
        {
            $dischage_summary['nicu_id'] = $nicu_id = $id_list;
        }
        else
        {

            return redirect(url('/'))->with('error', 'Invalid record');

        }

        $nicu = Nicu::findOrfail($id_list);

        \Session::put('nicu-adm-editor', true);

        if (count($nicu) > 0 && !empty($nicu['edited_content'])) {
            $discharge_details['content'] = $nicu['edited_content'];
        } 
        else {
            $discharge_details = $this->printData($id);
        }

        $editor_gen = false;
        \Session::forget('nicu-adm-editor');
        return view('admission.nicu.editor', compact('discharge_details', 'dischargeSummarymodified', 'dischage_summary'));
    }


    public function checkIpExist(Request $request)
    {
        $input = $request->all();
        if (isset($input['ip_number']) && !empty($input['ip_number'])) {
            $check_has_prefix = substr($input['ip_number'], 0, 3);
            if ($check_has_prefix != 'IP/') {
                $check_ip = IpNumber::where('ip_number', 'IP/'.$input['ip_number'])->first();
            }
            else
            {
                $check_ip = IpNumber::where('ip_number', $input['ip_number'])->first();
            }
            if (count($check_ip) != 0) {
                return \Response::json(['status'=>false, 'message'=>'IP number already exists'], 200);
            }
            else
            {
                return \Response::json(['status'=>true, 'message'=>'Not exist'], 200);
            }
        }
    }

    public function dischargeedit($id, $search_data = '', Request $request)
    {

        $id = \SiteHelpers::decrypt_id($id);
        // if ($search_data == 'editmodule' || $search_data == '') {
        //     if (\Session::has('slug-nav')) {
        //         \Session::forget('slug-nav');
        //     }
        // }
        $navigate['main_nav'] = 'nicu';
        $navigate['sub_nav'] = 'nicu_proforma';

        // if (\Session::has('slug-nav')) {
        //     $navigate['sub_nav'] = \Session::get('slug-nav');
        // }
        $flow_wise_register = $request->get('flow');
        $result = Nicu::get_record($id);

        $nicuChild = Nicu::find($id);

        $results = $result[0];

        $results->BMrNo = $results->baby_mr_no;

        if (date('Y', strtotime($results->DOB)) > 1980)
            $results->DOB = date('d-m-Y', strtotime($results->DOB));
        else
            $results->DOB = '';

        if (date('Y', strtotime($results->AdmissionDate)) > 1980)
            $results->AdmissionDate = date('d-m-Y', strtotime($results->AdmissionDate));
        else
            $results->AdmissionDate = '';

       // if (date('Y', strtotime($results->TransferDate)) > 1980)
           // $results->TransferDate = date('d-m-Y', strtotime($results->TransferDate));
     //   else
         //   $results->TransferDate = '';

        if (date('Y', strtotime($results->DischargeDate)) > 1980)
            $results->DischargeDate = date('d-m-Y', strtotime($results->DischargeDate));
        else
            $results->DischargeDate = '';

        if (date('Y', strtotime($results->NextAppointment)) > 1980)
            $results->NextAppointment = date('d-m-Y', strtotime($results->NextAppointment));
        else
            $results->NextAppointment = '';

        if (date('Y', strtotime($results->DateofAdministration)) > 1980)
            $results->DateofAdministration = date('d-m-Y', strtotime($results->DateofAdministration));
        else
            $results->DateofAdministration = '';

        $vaccine = (!empty($results->Vaccine) && $results->Vaccine != null) ? json_decode($results->Vaccine) : [];
        $vaccine_date = (!empty($results->VaccineDate) && $results->VaccineDate != null) ? json_decode($results->VaccineDate) : [];
        
        $results->DifferentialDiagnosis = (!is_null($results->DifferentialDiagnosis) && !empty($results->DifferentialDiagnosis)) ? json_decode($results->DifferentialDiagnosis) : array();


        $results->TimeOfDiscussion = $results->TimeOfDiscussion_MINS = $results->TimeOfDiscussion_AM = '';
        
        if (isset($results->DiscussionTime) && !empty($results->DiscussionTime)) {
            $discussiontime=explode(':', $results->DiscussionTime);
            if (is_array($discussiontime) && count($discussiontime) > 1) {
                $results->TimeOfDiscussion       = $discussiontime[0];
                $results->TimeOfDiscussion_MINS  = $discussiontime[1];
                $results->TimeOfDiscussion_AM    = $discussiontime[2];
            }
        }

        $age_taken = explode(':', $results->AgeTaken);

        $results->age_hours = (isset($age_taken[0]) && !empty($age_taken[0])) ? $age_taken[0] : 0;
        $results->age_mins = (isset($age_taken[1]) && !empty($age_taken[1])) ? $age_taken[1] : 0;

        $admissionmode_master=AdmissionmodeMaster::ListData();

        $pbm_data = Problems::where('BabyId', '=', $results->BabyId)->get();
        $medications = Medications::where('BabyId', '=', $results->BabyId)->where('AdmissionId', '=', $results->AdmissionId)->where('flag', '=', 2)->get();
        $complication = Complication::where('BabyId', '=', $results->BabyId)->where('flags', $this->usg_flags)->get();
        $neonatal_complication =Complication::where('BabyId', '=', $results->BabyId)->where('flags', 1)->get(); 

        $usg_findings = Usg::where('MotherId', '=', $results->MotherId)
                          ->where('BabyId', '=', $results->BabyId)
                          ->where('flags', '=', $this->usg_flags)
                          ->first();
        $SubmitButtonText = "Update & Close";

        $Probs = MediprobsMaster::get_lists();
        $Complications = ComplicationMaster::get_lists();
        // $Antibiotic = AntibioticMaster::get_lists();

        // $antibiotic_master[0] = 'N/A';
        // foreach ($Antibiotic as $data) {
        //     $antibiotic_master[$data->Id] = $data->Name;
        // }

        $medi_probs_master[0] = 'N/A';
        foreach ($Probs as $data) {
            $medi_probs_master[$data->Id] = $data->Name;
        }
        $complication_master[0] = 'N/A';
        foreach ($Complications as $data) {
            $complication_master[$data->Id] = $data->Name;
        }

        $drugs = DrugIvFluidMaster::getOralDrug();
        $Vaccines = Vaccine::get_lists();
        $vaccine_master[0] = 'N/A';
        foreach ($Vaccines as $vac) {
            $vaccine_master[$vac->Id] = $vac->Name;
        }
        $drug_master[0] = 'N/A';
        foreach ($drugs as $drug) {
            $drug_master[$drug->Id] = $drug->Name;
        }
        $drug_value[0]='N/A';
        foreach ($drugs as $drugvalue) {
            $drug_value[$drug->Id] = $drug->Value;
        }


        // $antib_temp = AntibioticMaster::ListData();
        $procedure_temp = ProcedureMaster::ListData();

        // $antibiotic_data[0] = 'N/A';
        // foreach ($antib_temp as $data) {
        //     $antibiotic_data[$data->Id] = $data->Name;
        // }
        $procedure_master[0] = 'N/A';
        foreach ($procedure_temp as $data) {
            $procedure_master[$data->Id] = $data->Name;
        }

        $problem_temp = ProblemMaster::ListData();

        $problem_master[0] = 'N/A';
        foreach ($problem_temp as $data) {
            $problem_master[$data->Id] = $data->Name;
        }
        $NAT['time'] = array();
         $NAT['time']['']='N/A';
        for ($i = 1; $i <= 12; $i++) {
            $NAT['time'][$i] = (strlen($i) == 1) ? '0' . $i : $i;
        }
        $NAT['mins'] = array();
         $NAT['mins']['']='N/A';
        for ($i = 0; $i <= 59; $i++) {
            $NAT['mins'][$i] = (strlen($i) == 1) ? '0' . $i : $i;
        }

        $admission['time'] = $admission['mins'] = array();
        for ($i = 1; $i <= 12; $i++) {
            $admission['time'][$i] = (strlen($i) == 1) ? '0' . $i : $i;
        }
        for ($i = 0; $i <= 59; $i++) {
            $admission['mins'][$i] = (strlen($i) == 1) ? '0' . $i : $i;
        }
        $GetICD = Icd::where('ICDCode', '<>', '')->get();
        $ICD = array();
        foreach ($GetICD as $key => $value) {
            $ICD[$value->ICDCode] = $value->ICDDescription . '-' . $value->ICDCode;

        }
        $ip_details=IpNumber::getCurrent_ip($results->BabyId, $results->AdmissionId);
        $results->ip_number=(count($ip_details) > 0)? $ip_details->ip_number : '' ;

         $neonatal_usg_findings = Usg::where('MotherId', '=', $results->MotherId)
                                  ->where('BabyId', '=', $results->BabyId)
                                  ->where('flags', '=', 1)
                                  ->first();
       $empty_list=array();

      
       // $neonatal_findings = (count($neonatal_usg_findings) > 0)? unserialize($neonatal_usg_findings['Finding']) : $empty_list;
       // $neonatal_gestations = (count($neonatal_usg_findings) > 0)? unserialize($neonatal_usg_findings['Gestation']):$empty_list;

       //  $findings              = (count($usg_findings) > 0) ?  unserialize($usg_findings['Finding'])  : $empty_list;
       //  $gestations            = (count($usg_findings) > 0) ? unserialize($usg_findings['Gestation']) : $empty_list;


        $results->IVAntibiotic = ( !is_null($results->IVAntibiotic) && !empty($results->IVAntibiotic))?json_decode($results->IVAntibiotic)  : $empty_list;
        
        $displayTypeofTreatment = ($results->ROPTreatment == 'No') ? 'style = "display:none"' : '';

        $Doctorslist=DoctorMaster::get_lists();
        $DoctorMaster=array();
        foreach ($Doctorslist as $doctor) {
            $DoctorMaster[$doctor->id]=$doctor->Name;
        }
            
         $temp    = json_decode($results->CorrectedGestation);
         $temp    = is_array($temp) ? $temp : (array)$temp;
         $results->cg_weeks =  isset($temp['cg_weeks']) ? $temp['cg_weeks'] : null;  
         $results->cg_days  =  isset($temp['cg_days']) ? $temp['cg_days'] : null;
         unset($temp);

         $temp    = json_decode($results->Gestation);
         $temp = is_array($temp) ? $temp : (array)$temp;
         $results->g_weeks =  isset($temp['g_weeks']) ? $temp['g_weeks'] : null;  
         $results->g_days  =  isset($temp['g_days']) ? $temp['g_days'] : null;
         unset($temp);


         if (is_null($results->corrected_gestation)) {
             $results->DOB = date('Y-m-d', strtotime($results->DOB)) ;
             if (!empty($results->DOB)) {
               $results->DayOfLife = \SiteHelpers::calculate_day_of_life($results->DOB);
             }  
             if (!empty($results->Gestation)) {
                $results->Gestation = \SiteHelpers::convert_gestation_days($results->Gestation);
             }
              
             if (isset($results->DayOfLife) && !empty($results->DayOfLife)) {
                 $results->CGA = \SiteHelpers::calculate_corrected_gestation($results->Gestation, $results->DayOfLife);
                 $results->dcg_weeks =(int) $results->CGA[0];
                 $results->dcg_days  =(int) $results->CGA[1];
             }
         } else {
             $temp    = json_decode($results->corrected_gestation);
             $temp = is_array($temp) ? $temp : (array)$temp;
             $results->dcg_weeks =  $temp['dcg_weeks'];
             $results->dcg_days  =  $temp['dcg_days'];
             unset($temp);

         }

         
         $temp_gestation = is_numeric($results->Gestation) ? $results->Gestation :  \SiteHelpers::convert_gestation_days($results->Gestation);

         $neonatalOtherscan   = $nicuChild->getUsg->where('type', 3)->where('flags', 1)->toArray();
         $neonatalDopplerscan = $nicuChild->getUsg->where('type', 4)->where('flags', 1)->toArray();    

         $datingScan  = $nicuChild->getUsg->where('type', 1)->where('flags', 1)->first();
         $analogScan  = $nicuChild->getUsg->where('type', 2)->where('flags', 1)->first();
         $otherScan   = $nicuChild->getUsg->where('type', 3)->where('flags', $this->usg_flags)->toArray();
         $dopplerScan = $nicuChild->getUsg->where('type', 4)->where('flags', $this->usg_flags)->toArray();

         $procedure_master = ProcedureMaster::ListData()->pluck('Name', 'Id')->toArray();

         $datingScan  = (count($datingScan) > 0) ? $datingScan->toArray() : array();
         $analogScan  = (count($analogScan) > 0) ? $analogScan->toArray() : array();

         $results->TypeofTreatmen =  empty($results->TypeofTreatmen) ? array() : json_decode($results->TypeofTreatmen) ;

          $results->indication_of_admission = !is_null($results->indication_of_admission) ? json_decode($results->indication_of_admission) : array();
          if (isset($results->DOB) && !empty($results->DOB)) {
              $results->DOB = date('d-m-Y', strtotime($results->DOB));
          }

          if (isset($results->DescriptionOfResuscitation) && empty(($results->DescriptionOfResuscitation))) {
            $neonatal = Neonatal::getNeonatalDependancy($results->BabyId, 1)[0];
            $results->DescriptionOfResuscitation = $neonatal->OtherInformation;
          }
          
        // Discharge Lab Report - Machine Values
        $lab_report_observe = DialpadSupportProperty::GLUCO_METER;

        $lab_field_name_list = [$lab_report_observe[45], $lab_report_observe[26], '', $lab_report_observe[9], $lab_report_observe[10], $lab_report_observe[0], $lab_report_observe[2], $lab_report_observe[13], $lab_report_observe[41]];

        $nicu_discharge_field_name_list = ['DischargeHb', 'DischargePCV', 'NicuDCT', 'DischargeTSB', 'direct_bilirubin', 'DischargeSerumCa', 'DischargeSerumPo4', 'DischargeSerumALP', 'DischargeSerumNa'];

        $lab_results = EmrLogHeader::getInterfacingData($results->BabyId, $results->AdmissionId, $lab_field_name_list)->pluck('intf_ref_value', 'local_code');

        $lab_interfacing_data = [];

        foreach ($lab_field_name_list as $key => $value) {
            if (isset($nicu_discharge_field_name_list[$key])) {
                $lab_key = $nicu_discharge_field_name_list[$key];
                if (!isset($results->$lab_key) && isset($lab_results[$value])) {
                    $lab_interfacing_data[$lab_key] = $lab_results[$value];
                }
            }
        }

        $results = (array)$results;

        $results = array_merge($results, $lab_interfacing_data);

        $results = (object)$results;

        // NICU Edit - Machine Values
        // InitialBloodGas - Manual entry

        $observation = DialpadSupportProperty::LOINC_LOCAL_CODE;
        $observation = array_merge($observation, DialpadSupportProperty::EMR_LAB_VALUES);
        $observation_field_name_list = [$observation[19], $observation[109], $observation[8], $observation[7], $observation[10], $observation[11], $observation[12], $observation[6], '', 'oxygen_saturation_index', $observation[90], $observation[91], $observation[92], $observation[93], $observation[94], $observation[146], $observation[175], $observation[6]];

        $nicu_field_name_list = ['Mode', 'Mode_invasive', 'RR', 'HR', 'BP', 'diastolic_bp', 'MeanBP', 'Temperature', 'InitialBloodGas', 'SpO2', 'pH', 'PaO2', 'PaCo2', 'HCO3', 'BE', 'RBS', 'Hct', 'TemperatureAtAdmission'];
        
        $monitor_results = EmrMoniterValues::getInterfacingData($results->BabyId, $results->AdmissionId, $observation_field_name_list, '', '', 'asc');

        $ventilator_results = EmrVentilatorValues::getInterfacingData($results->BabyId, $results->AdmissionId, $observation_field_name_list, '', '', 'asc');
        $lab_results = EmrLogHeader::getInterfacingData($results->BabyId, $results->AdmissionId, $observation_field_name_list);

        $nurse_sheet_result = collect($monitor_results)->merge($ventilator_results);
        $nurse_sheet_result = collect($nurse_sheet_result)->merge($lab_results);

        $nurse_sheet_result = collect($nurse_sheet_result)->pluck('intf_ref_value', 'local_code');

        $machine_data = [];

        foreach ($observation_field_name_list as $key => $value) {
            if (isset($nicu_field_name_list[$key])) {
                $machine_key = $nicu_field_name_list[$key];
                if (!isset($results->$machine_key) && isset($nurse_sheet_result[$value])) {
                    if ($machine_key == 'Mode' && !empty($nurse_sheet_result[$value])) {
                        $admission_mode = Admissionmode::ListData();
                        $machine_data[$machine_key] = array_search ($nurse_sheet_result[$value], $admission_mode);
                    } else if ($machine_key == 'Mode_invasive' && !empty($nurse_sheet_result[$value])) {
                        $admission_mode = Admissionmode::ListData();
                        $machine_data[$machine_key] = array_search ($nurse_sheet_result[$value], $admission_mode);
                    } else {
                        $machine_data[$machine_key] = $nurse_sheet_result[$value];
                    }
                }
            }
        }

        if (count($lab_results) > 0 && !isset($results->age_hours) && !isset($results->age_mins)) {
            $first_lab_result = collect($lab_results)->first();
            $machine_data['age_hours'] = isset($first_lab_result->result_date_time) ? date('H', strtotime($first_lab_result->result_date_time)) : 0;
            $machine_data['age_mins'] = isset($first_lab_result->result_date_time) ? date('i', strtotime($first_lab_result->result_date_time)) : 0;
        }

        $bed_logs = BedLog::where('baby_id', $results->BabyId)->orderBy('id', 'desc')->first();

        $results->room_id = isset($bed_logs->room_id) ? $bed_logs->room_id : 0;
        $results->bed_id = isset($bed_logs->bed_id) ? $bed_logs->bed_id : 0;
        $results->bed_no = isset($bed_logs->bed_no) ? $bed_logs->bed_no : 0;
        if (isset($bed_logs->iomt_discharged) && $bed_logs->iomt_discharged) {
            $results->patient_log_status = isset($bed_logs->status) ? $bed_logs->status : '';
        } else {
            $results->patient_log_status = '';            
        }

        $results = (array)$results;

        $results = array_merge($results, $machine_data);

        $results = (object)$results;

        $next_module = $request->get('module');

        // return view('admission.nicu.edit', compact('results', 'procedure_master', 'neonatalDopplerscan', 'temp_gestation', 'neonatalOtherscan', 'datingScan', 'analogScan', 'otherScan', 'dopplerScan', 'SubmitButtonText', 'pbm_data', 'medications', 'complication', 'usg_findings', 'problem_master', 'procedure_master', 'antibiotic_master', 'drug_master', 'vaccine_master', 'complication_master', 'medi_probs_master', 'search_data', 'navigate', 'NAT', 'admission', 'displayTypeofTreatment', 'vaccine', 'vaccine_date', 'ICD', 'old_ip', 'neonatal_complication', 'DoctorMaster', 'admissionmode_master', 'drug_value'));
        return view('discharge.nicu.edit', compact('results', 'procedure_master', 'neonatalDopplerscan', 'temp_gestation', 'neonatalOtherscan', 'datingScan', 'analogScan', 'otherScan', 'dopplerScan', 'SubmitButtonText', 'pbm_data', 'medications', 'complication', 'usg_findings', 'problem_master', 'procedure_master', 'drug_master', 'vaccine_master', 'complication_master', 'medi_probs_master', 'search_data', 'navigate', 'NAT', 'admission', 'displayTypeofTreatment', 'vaccine', 'vaccine_date', 'ICD', 'old_ip', 'neonatal_complication', 'DoctorMaster', 'admissionmode_master', 'drug_value', 'flow_wise_register', 'next_module'));
    }

    /**
     * Discharge the specified record in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function dischargeupdate($id, Request $request)
    {
        $input = $request->all();

        $print_flag = isset($input['print_flag']) ? $input['print_flag'] : 0;
        unset($input['print_flag']);
        $nicu_details = Nicu::find($id);

        $input['BabyId'] = $nicu_details['BabyId'];

        ErrorLogController::emergencyLogStat('NICU Discharged BabyId - ' . $input['BabyId']);
        ErrorLogController::emergencyLogStat('NICU Discharged status - ' . $input['status']);
        ErrorLogController::emergencyLogStat('NICU Discharged AdmissionId - ' . $nicu_details['AdmissionId']);

        if ($input['status'] != 'Inpatient') {

            $baby_deitals = Baby::find($nicu_details['BabyId']);
            $syringepump['baby_id']          = $nicu_details['BabyId'];
            $syringepump['mother_id']        = isset($baby_deitals->MotherId) ? $baby_deitals->MotherId : null;
            $syringepump['admission_id']     = $nicu_details['AdmissionId'];
            $syringepump['admission_stauts'] = 4;
            SyringePumpAdmisson::create($syringepump);
            PrescriptionToMirthController::admission();

            $pump_condition['baby_id']      = $nicu_details['BabyId'];
            $pump_update['is_syringe_pump_connected'] = false;
            $pump_update['status'] = 'discharged';
            $pump_update['DateModified'] = Carbon::now($this->zone);
            $pump_update['UserModified'] = $this->auth->user()->id;

            $patient_log_status = BedLog::where($pump_condition)->get();
            if (count($patient_log_status) > 0) {
                BedLog::where($pump_condition)->Update($pump_update);
                $bed_log = BedLog::where($pump_condition)->orderby('id','desc')->first();
                Bed::where('id', $bed_log->bed_id)->Update(['status'=>null]);  
                DeviceStatusNotification::where('baby_mrn', $baby_deitals->BMrNo)->Update(['status'=>false]);
            }else {

                $pump['baby_id']        = $nicu_details['BabyId']; 
                $pump['admission_id']   = $nicu_details['AdmissionId'];
                $pump['status']         = 'discharged';
                $pump['is_syringe_pump_connected'] = false;
                $pump['DateAdded'] = Carbon::now($this->zone);
                $pump['UserAdded'] = $this->auth->user()->id;
                $pump['DateModified'] = Carbon::now($this->zone);
                $pump['UserModified'] = $this->auth->user()->id;
                BedLog::create($pump);
                if (isset($input['bedId'])) {
                    Bed::where('id', $input['bedId'])->Update(['status'=>null]);  
                }
            }
            $discharged_log = array();
            $discharged_log['baby_id'] = $nicu_details['BabyId'];
            $discharged_log['admission_id'] = $nicu_details['AdmissionId'];
            $discharged_log['discharged_at'] = Carbon::now($this->time_zone);

            \DB::table('discharged_log')->insert($discharged_log);  

            Admission::where('AdmissionId', $nicu_details['AdmissionId'])->update(['Status'=> $input['status']]);

            $event_input['status'] = 'DISCHARGE';
            if ($input['status'] == 'Transferred') {                
                $event_input['status'] = 'TRANSFER';                
                if (isset($patient_log_status->bed_no) && isset($patient_log_status->room_no)) {
                    $bed_number = $patient_log_status->bed_no;
                    $room_number = $patient_log_status->room_no;                    
                    \SiteHelpers::emptyDashboardData($bed_number, $room_number);
                }
            }

            $event_input['admission_id'] = $nicu_details['AdmissionId'];
            ErrorLogController::emergencyLogStat('NICU Discharged - ' . json_encode($event_input));
            broadcast(new WardEvent($event_input))->toOthers();

        } else {
            if (isset($input['room_id']) && isset($input['bed_id'])) {
            
                $check_bed_log = BedLog::where(['baby_id' => $input['BabyId'], 'status' => 'Occupied'])->first();
                $ward['ward_id'] = 1;
                $ward['ward_name'] = \SiteHelpers::gettable_values('ward', 'name', 'id', 1);
                $ward['room_id'] = $input['room_id'];
                $ward['room_no'] = \SiteHelpers::gettable_values('room', 'number', 'id', $input['room_id']);
                $ward['bed_id'] = $input['bed_id'];
                if ($input['bed_id'] != '' && !is_null($input['bed_id'])) {
                    $ward['bed_no'] = \SiteHelpers::gettable_values('bed', 'number', 'id', $input['bed_id']);
                }
                else
                {

                }
                $ward['baby_id'] = $input['BabyId'];
                $ward['admission_id'] = $nicu_details['AdmissionId'];
                $ward['DateAdded'] = Carbon::now($this->time_zone)->format('Y-m-d h:i a');
                $ward['UserAdded'] = $this->auth->user()->id;
                $ward['DateModified'] = Carbon::now($this->time_zone)->format('Y-m-d h:i a');
                $ward['UserModified'] = $this->auth->user()->id;
                $ward['IsDeleted'] = 0;
                $ward['status'] = 'Occupied';
                if (count($check_bed_log) == 0)
                {
                    $patient_bed_log = BedLog::create($ward);
                    Bed::where('id', $input['bed_id'])->update(['status' => 'Occupied']);
                }
                else
                {
                    BedLog::where(['baby_id' => $input['BabyId'], 'status' => 'Occupied'])->Update($ward);
                    
                    Bed::where('id', $check_bed_log->bed_id)->update(['status' => NULL]);

                    Bed::where('id', $input['bed_id'])->update(['status' => 'Occupied']);   
                }
            } else {
                $ward['status'] = 'Occupied';
                $ward['DateModified'] = Carbon::now($this->time_zone);
                $ward['UserModified'] = $this->auth->user()->id;
                BedLog::where('admission_id',$nicu_details['AdmissionId'])->Update($ward);
            }
        }
        $input['dcg_weeks'] = (isset($input['dcg_weeks']) && !empty($input['dcg_weeks']))? $input['dcg_weeks'] : 0;
        $input['dcg_days']  = (isset($input['dcg_days']) && !empty($input['dcg_days'])) ?  $input['dcg_days']  : 0;
         
        $input['DateModified'] = Carbon::now();
        $input['UserModified'] = $this->auth->user()->id;

        $input['DischargeDate'] = !empty($input['DischargeDate']) ? date('Y-m-d', strtotime($input['DischargeDate'])) : null;
        
        $input['NextAppointmentStatus'] = (isset($input['NextAppointmentStatus']) && $input['NextAppointmentStatus'] =='on') ? 'Yes' : 'No';

        $input['NextAppointment']        = (isset($input['NextAppointment']) && !empty($input['NextAppointment'])) ? date('Y-m-d', strtotime($input['NextAppointment'])) : null;
        $input['Vaccine']                = (isset($input['VaccineDate']) && count($input['Vaccine']) != 0) ? json_encode($input['Vaccine']) : null;
        $input['VaccineDate']            = (isset($input['VaccineDate']) && count($input['VaccineDate']) != 0) ? json_encode($input['VaccineDate']) : null;
        
        $input['corrected_gestation']    = json_encode(array('dcg_weeks'=>$input['dcg_weeks'], 'dcg_days'=>$input['dcg_days'])); 
        $input['typeoftreatment_left']   = isset($input['typeoftreatment_left']) ?  json_encode($input['typeoftreatment_left']) : json_encode(array());
        $input['typeoftreatment_right']  = isset($input['typeoftreatment_right']) ? json_encode($input['typeoftreatment_right']) :  json_encode(array());
        $input['procedures']             = isset($input['procedures']) ? json_encode($input['procedures']) : json_encode(array());
        unset($input['DOB']);

        if (isset($input['g_weeks']) && ($input['g_weeks'] == '' || $input['g_weeks'] == null)) {
            unset($input['g_weeks']);
        }
        if (isset($input['g_days']) && ($input['g_days'] == '' || $input['g_days'] == null)) {
            unset($input['g_days']);
        }

        $baby = Baby::FindorFail($input['BabyId']);

        $baby->update($input);

        $input['diedTime'] = !empty($input['diedTime']) ? $input['diedTime']: null;
        $input['diedMins'] = ($input['diedMins'] != '') ? $input['diedMins']: null;

        $input['discharge_femoral_pulses'] = !empty($input['discharge_femoral_pulses']) ? $input['discharge_femoral_pulses'] : null;
        unset($input['DOB']);
        unset($input['AdmissionDate']);
        $results1 = Nicu::findOrfail($id);
        $results1->update($input);

        $this->makeAppointment($input, $id);

        $baby_admission = Admission::getBaby($input['BabyId']);

            if ($baby_admission->Status == 'Transferred' && $results1->status == 'Transferred') {
                // $postnatalDischarge = PostnatalDischarge::getPostanatalDischargeeDetails($input['BabyId'], $baby_admission->AdmissionId);
                // $postnatalDischargeStatus = PostnatalDischarge::find($postnatalDischarge->posdisid);
                // $postnatalDischarge  = (array)$postnatalDischarge;
                // $postnatalDischargeStatus->update($postnatalDischarge);

                $baby_admission->Status = 'Transferred';
                $nicu_discharge_status = Admission::find($baby_admission->AdmissionId);
                $baby_admission  = (array)$baby_admission;
                
                $nicu_discharge_status->Update($baby_admission); 
            } elseif ($results1->status == 'Discharged') {
                $baby_admission->Status = 'Discharged';
                $nicu_discharge_status = Admission::find($baby_admission->AdmissionId);
                $baby_admission  = (array)$baby_admission;
                $nicu_discharge_status->Update($baby_admission);
            }


        if ($input['status'] != 'Inpatient' && $input['status'] != 'Transferred') {

            $postnatalStatus['discharge_status'] = $input['status'];
            $postnatalDischarge = PostnatalDischarge::where('BabyId', $input['BabyId'])
                                                  ->where('AdmissionId', $results1->AdmissionId)
                                                  ->Update($postnatalStatus);
             $neonatalDischarge['Status']  = $input['status'];
             $neonatalDischarge['DateModified']  = Carbon::now();
             $neonatalDischarge['UserModified']  = $this->auth->user()->id;
             Neonatal::where('BabyId', $input['BabyId'])->Update($neonatalDischarge);

        }

        $newborn = NicuNewborn::find($input['BabyId']);
        if ($newborn) {
            $newborn->update($input);
        } else {
            $input['DateAdded'] = Carbon::now($this->time_zone)->format('Y-m-d h:i a');
            $input['UserAdded'] = $this->auth->user()->id;
            NicuNewborn::create($input);
        }

        $discharge_medications = Medications::where('BabyId', '=', $input['BabyId'])
                                  ->where('AdmissionId', '=', $results1->AdmissionId)
                                  ->where('flag', '=', 2)
                                  ->delete();
      if (isset($input['M_Drugs'])) {                            
        for ($i = 0; $i < sizeof($input['M_Drugs']); $i++) {
            if (isset($input['M_Drugs'][$i]) && !empty($input['M_Drugs'][$i])) {
                $discharge_medications = array(
                    'Medication' => $input['M_Drugs'][$i],
                    'Dose' => $input['M_Dose'][$i],
                    'Frequency' => $input['M_Frequency'][$i],
                    'Duration' => $input['M_Duration'][$i],
                    'genericname'=>$input['m_generic_name'][$i],
                    // 'formulation'=> $input['formulation'][$i],
                    'AdmissionId' => $results1->AdmissionId,
                    'BabyId' => $input['BabyId'],
                    'flag'  => 2,
                    'source_id'=>0,
                    'additional_instruction'=>$input['additional_instruction'][$i]
                );
                if (isset($input['formulation'][$i]) && !empty($input['formulation'][$i])) {
                    $discharge_medications['formulation'] = $input['formulation'][$i];
                }
                Medications::create($discharge_medications);
            }
        }
       } 


        $ip_number_old=IpNumber::getCurrent_ip($input['BabyId'], $results1->AdmissionId);
        $ip_data['baby_id']         =   $input['BabyId'];   
        $ip_data['ip_number']       =   $input['ip_number'];
        $ip_data['status']          =   1; 
        $ip_data['AdmissionId']     =   $results1->AdmissionId;
        if (count($ip_number_old)>0) {
            $ip_data['DateModified']    =  Carbon::now();
            $update_ip=IpNumber::findOrfail($ip_number_old->id);
            $update_ip->update($ip_data);
        } 
        else {

            $ip_data['DateAdded']       =  Carbon::now();
            $ip_data['DateModified']    =  Carbon::now();
            if (isset($input['ip_number']) && $input['ip_number'] != '' && !is_null($input['ip_number'])) { 
                IpNumber::create($ip_data);
             } 
        }

         $menu   = isset($_COOKIE['nicuform']) ? $_COOKIE['nicuform'] : '';
         $module =  (\Session::has('admission_module') && \Session::get('admission_module') =='NICU_ADMISSION') ? 'NICU_FORM' : 'NICU_DISCHARGE';
        
        \SiteHelpers::updateDashboardAtFormUpdation($input['BabyId'], 'NICU Discharge Form');        
               
        if ($request->ajax()) {
            return \Response::json(['type' => 'success', 'message' => 'Neonatal proforma created successfully !', 'edit_url' => action('Admission\NicuController@edit', \SiteHelpers::encrypt_id($id)), 'list_url' => action('Admission\NicuController@nicuSublists', \SiteHelpers::encrypt_id($input['BabyId'])), 'print_url'=> action('Admission\NicuController@printData', \SiteHelpers::encrypt_id($id)), 'daycare_summary_url'=> action('Reports\NicuDischargeController@index', \SiteHelpers::encrypt_id($input['BabyId'].'-'.$results1->AdmissionId)), 'problem_summary_url'=>action('Reports\ProblemDischargeController@dischargeSummary', \SiteHelpers::encrypt_id($input['BabyId'].'-'.$results1->AdmissionId)), 'discharge_list_url'=> action('Admission\NicuController@dischargeList').'?status=discharged','ward_dashboard_url'=> url('ward-dashboard')], 200);
        }

        if ($print_flag == 1) {
                return redirect(action('Reports\NicuDischargeController@index', \SiteHelpers::encrypt_id($input['BabyId'].'-'.$results1->AdmissionId)))->with('Success', 'Record updated successfully !');
        } elseif ($print_flag == 11) {
                return redirect(action('Reports\ProblemDischargeController@dischargeSummary', \SiteHelpers::encrypt_id($input['BabyId'].'-'.$results1->AdmissionId)))->with('Success', 'Record updated successfully !');
        } elseif ($print_flag == 2) {

           $this->flow->flowlog($module, $input['BabyId'], $input['MotherId'], $results1->AdmissionId, false, $menu);
            if ($input['next_module'] == 'transfertopostnatal') {
                return redirect(action('Admission\NicuController@dischargeedit', \SiteHelpers::encrypt_id($id)).'?module=transfertopostnatal')->with('Success', 'Record updated successfully !');
            } else {
                return redirect(action('Admission\NicuController@dischargeedit', \SiteHelpers::encrypt_id($id)))->with('Success', 'Record updated successfully !');
            }

        } elseif($print_flag == 7) {

            $this->flow->flowlog($module, $input['BabyId'], $input['MotherId'], $results1->AdmissionId, true, $menu);
            $this->flow->clearFlow(); 

            return redirect(action('Reports\NicuDischargeController@index', \SiteHelpers::encrypt_id($input['BabyId'].'-'.$results1->AdmissionId)))->with('Success', 'Record updated successfully !');

        } elseif($print_flag == 8 && isset($input['admission_tag'])) {
            $admission_tag = ($input['admission_tag'] == 'NICU_MULTIPLE_PREGANANCY') ? 'NICU_ADMISSION' : 'POSTNATAL_ADMISSION';
            \Session::put('admission_module', $admission_tag);
            \Session::put('current_module', 'BABY_REG');
            $this->flow->flowlog('BABY_REG', 0, $input['MotherId'], 0, true, '');

            return redirect(action('Registration\BabyController@create', \Session::put('mother_id')))->with('Success', 'Record updated successfully !');

        }  elseif($print_flag == 15) {
            $slug = $input['BabyId'].'-'.$results1->AdmissionId;

            return redirect(action('Admission\PostnatalController@show',\SiteHelpers::encrypt_id($slug)))->with('Success', 'Record updated successfully !');

        } else {
            $this->flow->flowlog($module, $input['BabyId'], $input['MotherId'], $results1->AdmissionId, true, $menu);
            $this->flow->clearFlow(); 

            return redirect(action('Admission\NicuController@dischargeList'). '?status=discharged')->with('Success', 'Record updated successfully !');
        }
    }

    /**
     * Store a newly created appointment.
     *
     */
    public function makeAppointment($input, $id = 0)
    {
        if ($input['NextAppointmentStatus'] == 'Yes' && (!is_null($input['NextAppointment']) && !empty($input['NextAppointment'])) && $id != 0) {
            $appointment_details = new Request([
                'category'   => 'Review Appointment',
                'date'       => $input['NextAppointment'],
                'time'       => $input['NAT_TIME'],
                'mins'       => $input['NAT_MINS'],
                'session'    => $input['NAT_AM'],
                'patient'    => $input['BabyId'],
                'ref_id'     => $id,
                'from'       => 4
            ]);
            FlowController::patientDetailUpdate($appointment_details, 0);
        }
    }

}
