<?php

namespace App\Http\Controllers\Lab;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Baby;
use App\Models\lab\LabRequest;
use App\Models\Icd;
use App\Models\Masters\CollectionSites;
use App\Models\Masters\CollectionMethod;
use Illuminate\Contracts\Auth\Guard;
use Carbon\Carbon;
use App\Models\Settings\DeleteApproval;
use App\Models\IpNumber;
use App\Models\Nurse\EmrLogDetails;
use App\Http\Controllers\Errors\ErrorLogController;
use App\Models\Admission;


class LabRequestController extends Controller
{

    /**
     * This varible department
     * @var $department_id
     */
     private $department_id;

     /**
      *
      *
    
    /**
     * Initiate the required instance.
     *
     * @param $auth instance of  Illuminate\Contracts\Auth\Guard
     *
     * @return Response
     */
    public function __construct(Guard $auth)
    {
        $this->middleware('role:LABREQUEST,write', ['only' => ['store', 'update', 'edit', 'create', 'show', 'destroy']]);
        $this->middleware('role:LABREQUEST,read', ['only' => ['index', 'printData']]);

        $this->auth            = $auth;
        $this->department_id   = 3;
        $this->custom_error    = new ErrorLogController();
        $this->zone            =  env('TIME_ZONE');

        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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


        $order['sortby']    = 'lab_request.id';
        $order['sortorder'] = 'desc';
        if (!empty($request->input('sortby')) && !empty($request->input('sortorder'))) {
          $order['sortby']     = \SiteHelpers::decrypt_id($request->input('sortby'));
          $order['sortorder']  = $request->input('sortorder');
        }

        $search_txt = '';
        if (!empty($request->input('search_txt'))) {
            $search_txt = $request->input('search_txt');
        }

        $navigate['main_nav'] = 'lab_request';
        $navigate['sub_nav']  = 'lab_request';

        $result   = LabRequest::getList($request->input('page'), $limit, $search_txt, $order, 1);
        $results  = $result['result'];
        $getTotal = LabRequest::GetTotal();
        $total    = $result['total']; 

        $page                   = !empty($request->input('page')) ? $request->input('page') : 1;
        $pagecount              = (!empty($search_txt)) ? ceil($total/$limit) : ceil($total/$limit);
        $pagination['total']    = $total;
        $pagination['start']    = (($page-2) < 1) ? 1 : ($page-2);
        $pagination['end']      = ($pagecount < ($page+3)) ? $pagecount :   ($page+3);
        $pagestart              = $total != 0 ? ($page <= 1) ? $page : ($page-1)*$limit + 1 : 0;
        $pagerecords            = ($page == $pagination['end'] || $pagination['total'] == 0) ? $pagination['total'] : $page*$limit;
        $pagination['limit']    = array($pagestart, $pagerecords);
        $pagination['limits']   = $limit;
        $pagination['previous'] = (($page-1) < 1) ? 1 : ($page-1);
        $pagination['next']     = ($pagecount < ($page+1)) ? $pagecount :   ($page+1);

       return view('lab.list',compact('results', 'navigate', 'pagination', 'order', 'search_txt', 'getTotal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$babies = Baby::where('IsDeleted','0')->get();
      foreach ($babies as $key => $value) {
        if(!empty(trim($value->BabyName)) && trim($value->BabyName) != '')  {
          $temp_babies[$value->BabyId] = $value->BabyName .'-'.$value->BMrNo;
        }
      }
      $babies = $temp_babies;
    	$SubmitButtonText = 'submit';
        $navigate['main_nav'] = 'lab_request';
        $navigate['sub_nav']  = 'lab_request';

        return view('lab.select', compact('babies', 'SubmitButtonText', 'navigate'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $input = $request->all();
       
       $lab_request['baby_id']           = $input['baby_id'];
       $lab_request['department']        = $input['department'];
       $lab_request['collection_site']   = $input['collection_site'];
       $lab_request['collection_method'] = $input['collection_method'];
       $lab_request['test_date']         = date('Y-m-d', strtotime($input['test_date']));
       $lab_request['symptoms']          = $input['symptoms'];
       $lab_request['diagnosis']         = isset($input['diagnosis']) ? json_encode($input['diagnosis']) : null;
       $lab_request['credit']            = isset($input['credit']) ? true : false;
       $lab_request['stat']              = isset($input['stat'])   ? true : false;
       $lab_request['scheduled']         = isset($input['scheduled']) ? true : false;
     
       $admission_id =  LabRequest::getAdmissionNumber($input['baby_id']);
       if(isset($input['ip_number']) && isset($admission_id->AdmissionId)) {
         $ip_number['baby_id']      = $input['baby_id'];
         $ip_number['ip_number']    = $input['ip_number'];
         $ip_number['status']       = 1;
         $ip_number['DateAdded']    = Carbon::now(env('TIME_ZONE'));
         $ip_number['DateModified'] = Carbon::now(env('TIME_ZONE'));

         $ip_number['AdmissionId']  = $admission_id->AdmissionId;
         $ipnumber = IpNumber::where('ip_number', $input['ip_number'])->get();
         if(count($ipnumber) == 0) {
            IpNumber::create($ip_number);
         }
       }
       if (isset($lab_request['scheduled'])) {
        $lab_request['scheduled_date']      = (isset($input['scheduled_date']) && $input['scheduled_date'] != '') ? date('Y-m-d', strtotime($input['scheduled_date'])) : null;
        $lab_request['scheduled_time']      = $input['scheduled_time'];
        $lab_request['scheduled_mins']      = $input['scheduled_mins'];
        $lab_request['scheduled_sesstion']  = $input['scheduled_sesstion'];

       } else {
        $lab_request['scheduled_date']     = null;
        $lab_request['scheduled_time']     = null;
        $lab_request['scheduled_mins']     = null;
        $lab_request['scheduled_sesstion'] = null;
       }

       $lab_request['order_physician']   = !empty($input['order_physician']) ? $input['order_physician'] :null;
       $lab_request['investigations']    = isset($input['investigations']) ? json_encode($input['investigations']) : null; 

       $lab_request['admission_time']         = isset($input['admission_time']) ? $input['admission_time'] : null; 
       $lab_request['admissiontime_mins']     = isset($input['admissiontime_mins']) ? $input['admissiontime_mins'] : null; 
       $lab_request['admissiontime_sesstion'] = isset($input['admissiontime_sesstion']) ? $input['admissiontime_sesstion'] : null; 
       $lab_request['associate_doctor']       = $input['associate_doctor'];
       $lab_request['is_send'] = false;
       $id = LabRequest::create($lab_request)->id;
       $this->getSendRequest();

         if ($input['print_flag'] == 1) {
           return redirect(action('Lab\LabRequestController@edit', $id))->with('Success', 'Record update successfully');
         } elseif ($input['print_flag'] == 2) {
            return redirect(action('Lab\LabRequestController@index'))->with('Success', 'Record update successfully');
         }

    }

    /**
     * Display the specified resource.
     *     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    	$baby              = Baby::find($id);
      $diagnosis         = Icd::GetList()->pluck('icdcode','ICDCode')->toArray();
      $collection_sites  = CollectionSites::ListData()->pluck('name','id')->toArray();
      $collection_method = CollectionMethod::ListData()->pluck('name', 'id')->toArray();
      $ip_number         = IpNumber::where('baby_id', $baby->BabyId)
                               ->get(); 
      $ip_number = $ip_number->last();   

      $collection_sites['']= 'N/A';
      $collection_method['']= 'N/A';
      $associate_doctors = array();
      $SubmitButtonText = 'submit';
      if(env('LAB_INTERFACE')) {

      $master_doctor = array();
      $doctor_master_url = \SiteHelpers::getConfigSettings('GET_HMS_DOCTOR_MASTER');
      $client = new \GuzzleHttp\Client();
      $response = $client->request('GET', $doctor_master_url);
      $master_doctor = $response->getBody();
      $master_doctor = $master_doctor->getContents();
      if(isset(json_decode($master_doctor)->data)) {
          $master_doctor = collect(json_decode($master_doctor)->data)->pluck('name', 'id')->toArray();
          $associate_doctors = $master_doctor; 
          foreach ($master_doctor as $key => $value) {
            if($key != '208' && $key != '3096') {
              unset($master_doctor[$key]);
            }
         }
      }else {
        $master_doctor = array();
      }


      
      $department_master_url = \SiteHelpers::getConfigSettings('GET_HMS_DEPARTMENT_MASTER');
      $client = new \GuzzleHttp\Client();
      $response = $client->request('GET', $department_master_url);
      $master_department = $response->getBody();
      $master_department = $master_department->getContents();
      if(isset(json_decode($master_department)->data)) {
          $master_department = collect(json_decode($master_department)->data)->pluck('name', 'id')->toArray();
          foreach ($master_department as $key => $value) {
              if($value != 'LAB') {
               unset($master_department[$key]);
              }
          }
      } else {
          $master_department = array();
      }


       
       $mas_investigations = array();
       foreach ($master_department as $key => $value) {

         $investigations_master_url = \SiteHelpers::getConfigSettings('GET_HMS_INVESTIGATIONS_ID');
         $client = new \GuzzleHttp\Client();
         $response = $client->request('GET', $investigations_master_url.$key);
         $master_investigations = $response->getBody();
         $master_investigations = $master_investigations->getContents();
         $master_investigations = collect(json_decode($master_investigations)->data)->pluck('name', 'id')->toArray();
         
         $mas_investigations = array_merge($mas_investigations,$master_investigations);
       }
       $master_investigations = $mas_investigations;

      }else {
          $master_doctor = $master_department = $master_investigations = array();
          $master_doctor = \ValuelistHelpers::mas_doctors_list();
          $master_department = \ValuelistHelpers::getDepartment();
          $master_investigations = \ValuelistHelpers::getInvestigation();
          

      }
         $time["admission_time"]   = (int)Carbon::now($this->zone)->format('h');
         $time["admissiontime_mins"]   = (int)Carbon::now($this->zone)->format('i');
         $time["admissiontime_sesstion"]   = Carbon::now($this->zone)->format('A');
         
       $admission = \SiteHelpers::prepare_time();

      $navigate['main_nav'] = 'lab_request';
      $navigate['sub_nav']  = 'lab_request';

      $baby->DOB = !is_null($baby->DOB) ? date('d-m-Y', strtotime($baby->DOB)) : '';
      if(isset($ip_number->ip_number)) {
        $ip_number->ip_number = isset($ip_number->ip_number) ?  str_replace('IP/', '', $ip_number->ip_number) : '';
        $ip_number->ip_number = (isset($ip_number->ip_number) && !is_null($ip_number->ip_number)) ? 'IP/'.$ip_number->ip_number : 'IP/';

      }


      return view('lab.create',compact('baby', 'time','ip_number','SubmitButtonText', 'associate_doctors','master_investigations','admission','master_doctor','master_department','diagnosis', 'collection_sites', 'collection_method', 'navigate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lab_request       = LabRequest::find($id);
        $baby_id           = $lab_request->baby_id;
        $ip_number         = IpNumber::where('baby_id', $baby_id)->get();
        $ip_number         = $ip_number->last();
        $ip_number         = isset($ip_number->ip_number) ? $ip_number->ip_number : null;
        $baby              = Baby::find($baby_id);
        $diagnosis         = Icd::GetList()->pluck('icdcode','ICDCode')->toArray();
        $collection_sites  = CollectionSites::ListData()->pluck('name','id')->toArray();
        $collection_method = CollectionMethod::ListData()->pluck('name', 'id')->toArray();

        $collection_sites[''] = 'N/A';
        $collection_method['']= 'N/A';
      if(env('LAB_INTERFACE')) {
        
        $master_doctor = array();
        $doctor_master_url = \SiteHelpers::getConfigSettings('GET_HMS_DOCTOR_MASTER');
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $doctor_master_url);
        $master_doctor = $response->getBody();
        $master_doctor = $master_doctor->getContents();
        $master_doctor = collect(json_decode($master_doctor)->data)->pluck('name', 'id')->toArray();

        $department_master_url = \SiteHelpers::getConfigSettings('GET_HMS_DEPARTMENT_MASTER');
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $department_master_url);
        $master_department = $response->getBody();
        $master_department = $master_department->getContents();
        $master_department = collect(json_decode($master_department)->data)->pluck('name', 'id')->toArray();


        $mas_investigations = array();
        foreach ($master_department as $key => $value) {
         $investigations_master_url = \SiteHelpers::getConfigSettings('GET_HMS_INVESTIGATIONS_ID');
         $client = new \GuzzleHttp\Client();
         $response = $client->request('GET', $investigations_master_url.$key);

         $master_investigations = $response->getBody();
         $master_investigations = $master_investigations->getContents();
         $master_investigations = collect(json_decode($master_investigations)->data)->pluck('name', 'id')->toArray();
         $temp_invest[]   = $master_investigations;


        }

        foreach ($temp_invest as $key => $value) {
            $master_investigations  = array_replace_recursive($master_investigations,$value);;
        }  

      } else {
          $master_doctor = $master_department = $master_investigations = array();
          $master_doctor = \ValuelistHelpers::mas_doctors_list();
          $master_department = \ValuelistHelpers::getDepartment();
          $master_investigations = \ValuelistHelpers::getInvestigation();
      }

        $lab_request->scheduled_date = !is_null($lab_request->scheduled_date) ? date('d-m-Y', strtotime($lab_request->scheduled_date)) : null;


        $SubmitButtonText = 'submit';
        $admission = \SiteHelpers::prepare_time();

        $navigate['main_nav'] = 'lab_request';
        $navigate['sub_nav']  = 'lab_request';

        return view('lab.edit', compact('baby', 'ip_number','SubmitButtonText', 'master_investigations','admission','master_department','master_doctor','diagnosis', 'lab_request', 'collection_sites','collection_method', 'navigate'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $input                            = $request->all();

       $lab_request['baby_id']           = $input['baby_id'];
       $lab_request['department']        = $input['department'];
       $lab_request['collection_site']   = $input['collection_site'];
       $lab_request['collection_method'] = $input['collection_method'];
       $lab_request['test_date']         = date('Y-m-d', strtotime($input['test_date']));
       $lab_request['symptoms']          = $input['symptoms'];
       $lab_request['diagnosis']         = isset($input['diagnosis']) ? json_encode($input['diagnosis']) : null;
       $lab_request['credit']            = isset($input['credit']) ? true : false;
       $lab_request['stat']              = isset($input['stat'])   ? true : false;
       $lab_request['scheduled']         = isset($input['scheduled']) ? true : false;
       $lab_request['order_physician']   = !empty($input['order_physician']) ? $input['order_physician'] :null;
       $lab_request['investigations']    = isset($input['investigations']) ? json_encode($input['investigations']) : null; 
       
       $lab_request['admission_time']         = isset($input['admission_time']) ? $input['admission_time'] : null; 
       $lab_request['admissiontime_mins']     = isset($input['admissiontime_mins']) ? $input['admissiontime_mins'] : null; 
       $lab_request['admissiontime_sesstion'] = isset($input['admissiontime_sesstion']) ? $input['admissiontime_sesstion'] : null; 
       $lab_request['associate_doctor']       = $input['associate_doctor'];

       if (isset($lab_request['scheduled'])) {
        $lab_request['scheduled_date']      = (isset($input['scheduled_date']) && $input['scheduled_date'] != '') ? date('Y-m-d', strtotime($input['scheduled_date'])) : null;
        $lab_request['scheduled_time']      =  $input['scheduled_time'];
        $lab_request['scheduled_mins']      =  $input['scheduled_mins'];
        $lab_request['scheduled_sesstion']  =  $input['scheduled_sesstion'];

       } else {
        $lab_request['scheduled_date']     = null;
        $lab_request['scheduled_time']     = null;
        $lab_request['scheduled_mins']     = null;
        $lab_request['scheduled_sesstion'] = null;
       }
        //$lab_request['is_send'] = true;
       LabRequest::where('id',$id)->update($lab_request);
       $admission_id = Admission::where('BabyId', $input['baby_id'])->orderBy('AdmissionId', 'desc')->get();
       $admission_id = isset($admission_id->last()->AdmissionId) ? $admission_id->last()->AdmissionId : null;
      
       $ip_number['baby_id']     = $input['baby_id'];
       $ip_number['ip_number']   = $input['ip_number'];
       $ip_number['status']      = 1;
       $ip_number['AdmissionId'] = $admission_id;
       $ip_number_status = IpNumber::where('baby_id', $input['baby_id'])
                                    ->where('ip_number', $input['ip_number'])
                                    ->where('AdmissionId', $admission_id)
                                    ->first();
        if(count($ip_number_status) >0) {
          IpNumber::where('id',$ip_number_status->id)
                  ->update($ip_number);
        } else {
          IpNumber::create($ip_number);
        } 
         
        $this->getSendRequest();
    
       if ($input['print_flag'] == 1) {
         return redirect(action('Lab\LabRequestController@edit', $id))->with('Success', 'Record update successfully');
       }elseif($input['print_flag'] == 2) {
          return redirect(action('Lab\LabRequestController@index'))->with('Success', 'Record update successfully');

       }


    }
    /**
     * get the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getInvestigations($id)
    {

      $investigations_master_url = \SiteHelpers::getConfigSettings('GET_HMS_INVESTIGATIONS_ID');
      $client = new \GuzzleHttp\Client();
      $response = $client->request('GET', $investigations_master_url.$id);
      $master_investigations = $response->getBody();
      $master_investigations = $master_investigations->getContents();
      $master_investigations = collect(json_decode($master_investigations)->data)->pluck('name', 'id')->toArray();
      return \Response::json(['status'=>'Success','data'=>$master_investigations], 200);


    }
    /**
     * This method to get 
     * print sheet
     *
     */
     public function print($id)
     {  
       $results                 = LabRequest::find($id);
       $baby                    = Baby::find($results->baby_id);
       $baby->Gestation         = \SiteHelpers::decode_gestation($baby->Gestation);
       $results->investigations = (count(json_decode($results->investigations)) > 0)? json_decode($results->investigations) : null;
       $results->diagnosis      = (count(json_decode($results->diagnosis)) > 0)? json_decode($results->diagnosis) : null;
       $diagnosis_master        = Icd::GetList()->pluck('icdcode','ICDCode')->toArray();
       $collection_sites        = CollectionSites::ListData()->pluck('name','id');
       $collection_method       = CollectionMethod::ListData()->pluck('name', 'id');
       if(env('LAB_INTERFACE')) {
          $investigations_master_url = \SiteHelpers::getConfigSettings('GET_HMS_INVESTIGATIONS_ID');
          $client = new \GuzzleHttp\Client();
          $response = $client->request('GET', $investigations_master_url.$results->department);
          $master_investigations = $response->getBody();
          $master_investigations = $master_investigations->getContents();
          $master_investigations = collect(json_decode($master_investigations)->data)->pluck('name', 'id')->toArray();

        } else {
           $master_doctor = \ValuelistHelpers::mas_doctors_list();
           $master_department = \ValuelistHelpers::getDepartment();
           $master_investigations = \ValuelistHelpers::getInvestigation();

        }

        $closewinlink = action('Lab\LabRequestController@index');

       return view('lab.print', compact('results','closewinlink','baby', 'master_investigations', 'collection_method','collection_sites','diagnosis_master'));

     }

     public function getSendRequest()
      {
        $labRequest = LabRequest::where('is_send', false)
                                ->where('IsDeleted', false)
                                  ->get();
        $post_value   = array();                      
        if(count($labRequest) > 0) {
          foreach ($labRequest as $labRequest_key => $labRequest_value) {
            $this->custom_error->emergencyLog('Lab Request Send for hms start');

            $visit_number = LabRequest::getVisitNumber($labRequest_value->baby_id);

            if(!isset($visit_number->ip_number)) {
               LabRequest::where('id', $labRequest_value->id)->Update(['is_send'=>true]);
               $this->custom_error->emergencyLog('Visit Number Not Found:'.$labRequest_value->baby_id);
               // return 0;
               continue;
              //return \Response::json(['message'=>'Visit Number Not Found'],200);
            }
            if(empty($visit_number->ip_number)) {
               LabRequest::where('id', $labRequest_value->id)->Update(['is_send'=>true]);
               $this->custom_error->emergencyLog('Visit Number is empty:'.$labRequest_value->baby_id);
               // return 0;
               continue;
              //return \Response::json(['message'=>'Visit Number is empty'],200);
            }
            $post_value   = array();
            $mr_number    = Baby::find($labRequest_value->baby_id);
            $collection_sites  = CollectionSites::ListData()->pluck('name','id')->toArray();
            $collection_method = CollectionMethod::ListData()->pluck('name', 'id')->toArray();

            $post_value['visit_number']          = isset($visit_number->ip_number) ? $visit_number->ip_number : '';
            $post_value['mrn']                   = isset($mr_number->BMrNo) ? $mr_number->BMrNo : '';
            $post_value['department_id']         = $labRequest_value->department;
            $post_value['ordering_physisian_id'] = $labRequest_value->order_physician;
            $post_value['symptoms']              = $labRequest_value->symptoms;
            $post_value['diagnosis']             = $this->getDiagnosis($labRequest_value->diagnosis);
            $post_value['stat']                  = ($labRequest_value->stat == 1) ? "true" : "false";
            $post_value['scheduled']             = ($labRequest_value->scheduled ==1) ? "true" : "false";
            $scheduled_time = $labRequest_value->scheduled_time.':'.$labRequest_value->scheduled_mins.':'.$labRequest_value->scheduled_sesstion;

            if($labRequest_value->scheduled_date != '') {
              $post_value['scheduled_time']        = $labRequest_value->scheduled_date.' '.$scheduled_time;
            } 
            else{
              $post_value['scheduled_time']       = null;
            }

            $post_value['credit']                = ($labRequest_value->credit == 1) ? "true" : "false";
            $post_value['collection_site']       = isset($collection_sites[$labRequest_value->collection_site]) ? $collection_sites[$labRequest_value->collection_site] : 'null';
            $post_value['collection_method']     = isset($collection_method[$labRequest_value->collection_method]) ? $collection_method[$labRequest_value->collection_method] : 'null';
            $post_value['app_name']              = 'neonatal';
            $post_value['created_user_id']       = '1';
            $post_value['items']                 = $this->getInvestigation($labRequest_value->investigations, $labRequest_value->department);

            if(count($post_value['items']) > 0) {
                  $post_value        = json_encode($post_value);
                  $this->custom_error->emergencyLog('Lab Request Send for hms'.$post_value);
                  $request_post_url  = \SiteHelpers::getConfigSettings('GET_HMS_REQUEST');
                  $client            = new \GuzzleHttp\Client();
                  $response          = $client->request('POST', $request_post_url,['body' => $post_value]);
                  $lab_post          = $response->getBody()->getContents();
                  $lab_post          = json_decode($lab_post);

                  if(isset($lab_post->querystatus) && $lab_post->querystatus == 0) {
                      $request_success_details['request_id'] = $lab_post->request_id;
                      $request_success_details['is_send']    = true;
                     LabRequest::where('id', $labRequest_value->id)->Update($request_success_details);

                     $this->custom_error->emergencyLog('LAB Request :-'.$lab_post->message); 

                  }elseif(isset($lab_post->querystatus) && $lab_post->querystatus == 1){

                     LabRequest::where('id', $labRequest_value->id)->Update(['is_send'=>true]);
                     $this->custom_error->emergencyLog('LAB Request :-'.$lab_post->message); 

                  } elseif(isset($lab_post->querystatus) && $lab_post->querystatus == 2) {

                     LabRequest::where('id', $labRequest_value->id)->Update(['is_send'=>true]);
                     
                    $this->custom_error->emergencyLog('LAB Request :-'.$lab_post->message); 
                    // return 0;
                    continue;
                  }else {
                    $this->custom_error->emergencyLog('Request not send');
                     // return 0;
                    continue;
                  }
            } 
            else {
               LabRequest::where('id', $labRequest_value->id)->Update(['is_send'=>true]);
               $this->custom_error->emergencyLog('LAB Request :-test list are empty');
            }
            LabRequest::where('id', $labRequest_value->id)->Update(['is_send'=>true]);
            $this->custom_error->emergencyLog('Success');
             // return 0;
            continue;
          }

        }
        else
        {
          $this->custom_error->emergencyLog('No Record Found');
          return 0;
        }    

     }

     public function getDiagnosis($diagnosis)
     {

        $diagnosis_master        = Icd::GetList()->pluck('icdcode','ICDCode')->toArray();
        $diagnosis_set           = '';
        if(!is_null($diagnosis)) {
          foreach (json_decode($diagnosis) as $key => $value) {
            $diagnosis_set =$diagnosis_set.' '.$diagnosis_master[$value].',';
          } 
        }
        

        return $diagnosis_set;
     }

     public function getInvestigation($investigations, $department)
     {


      $investigations_master_url = \SiteHelpers::getConfigSettings('GET_HMS_INVESTIGATIONS_ID');
      $client = new \GuzzleHttp\Client();
      $response = $client->request('GET', $investigations_master_url.$department);
      $master_investigations = $response->getBody();
      $master_investigations = $master_investigations->getContents();
      $master_investigations = collect(json_decode($master_investigations)->data)->pluck('name', 'id')->toArray();
      $temp_item = array();
        if(count(json_decode($investigations)) > 0) {
           foreach (json_decode($investigations) as $key => $value) {
             if(isset($master_investigations[$value])) {
              $charg_item['charge_id']   = str_replace('"', '', json_decode($value));
              $charg_item['charge_name'] = $master_investigations[json_decode($value)]; 
              $charg_item['assosiate_doctor_id'] = "null";
              $temp_item[] = $charg_item;
            }
          } 
        }
        
       return $temp_item;
     }

     public function getResult() 
     {
         $lab_request = LabRequest::getIpnumberLabRequest();

         if (count($lab_request) == 0) {
          return 'Notfound';
         } 
         foreach ($lab_request as $key => $value) {
              echo $value->ip_number.',' ;
         }                              
        
     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $results = LabRequest::findOrfail($id);
      $this->getCancelRequest($results->request_id);

        $user_detail = array(
            'UserDeleted' => $this->auth->user()->id,
            'DateModified' => Carbon::now(),
            'IsDeleted' => '1'
        );
        $results->update($user_detail);
        $result = LabRequest::get_record($id);
        $res = $result[0];
        $baby = Baby::find($res->baby_id);

        $delete_data = array(
            'Name' => $baby->BabyName,
            'AdmissionDate' => $results['AdmissionDate'],
            'ModuleController' => 'Lab\LabRequestController',
            'ModuleId' => $id,
            'ModuleName' => 'Lab Request',
            'UserDeleted' => $this->auth->user()->id,
            'DateDeleted' => Carbon::now()
        );
        DeleteApproval::create($delete_data);
        return redirect(action('Lab\LabRequestController@index'))->with('info', 'Record deleted successfully !');
       
    }
     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getCancelRequest($request_number)
    {
       $request['request_id']       = $request_number;
       $request['cancel_reason']    = 'test';
       $request['canceled_user_id'] = '1';
       $request = json_encode($request);
       $request_post_url  = \SiteHelpers::getConfigSettings('GET_HMS_REQUEST_CANCEL');

       $client            = new \GuzzleHttp\Client();
       $response          = $client->request('POST', $request_post_url,['body' => $request]);
       $lab_post          = $response->getBody()->getContents();
       $lab_post          = json_decode($lab_post);
       
       if($lab_post->querystatus == 0) {
         $this->custom_error->emergencyLog('Lab Cancel:- Success '.$request_number.' '.$lab_post->message);
       } elseif($lab_post->querystatus == 1){
         $this->custom_error->emergencyLog('Lab Cancel:- Error '.$request_number.' '.$lab_post->message);
       } elseif($lab_post->querystatus == 2) {
         $this->custom_error->emergencyLog('Lab Cancel:- No Record Found '.$request_number.' '.$lab_post->message);
       } else {
         $this->custom_error->emergencyLog('Lab Cancel:- Status Unknown '.$request_number.' '.$lab_post->message);
       }
       return 0;
    }



}
