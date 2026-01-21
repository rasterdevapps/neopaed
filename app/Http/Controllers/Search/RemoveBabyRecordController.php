<?php

namespace App\Http\Controllers\Search;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Baby;
use App\Models\Op;
use App\Models\Nicu;
use App\Models\Pediatric;
use App\Models\Mother;
use App\Models\Neonatal;
use App\Models\Daycare;
use App\Models\Reports\NicuDischarge;
use App\Models\Postnatal;
use App\Models\PostDaycare;
use App\Models\PostnatalDischarge;
use App\Models\Reports\PostProblemDischargeSummary;
use App\Models\Cardio;
use App\Models\Ultra;
use Response;
use Illuminate\Contracts\Auth\Guard;
use Carbon\Carbon;
use App\Models\Settings\DeleteApproval;
use SiteHelpers;
use App\Models\DischargeSummary;

class RemoveBabyRecordController extends Controller
{
    /**
    * This is define the guard instance
    * 
    * @var $auth type instance 
    */
    public $auth;

    public function __construct(Guard $auth)
    {       
        $this->auth = $auth;
        $this->zone = env('TIME_ZONE');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($baby_id)
    { 
        $navigate['main_nav']    = 'dashboard';
 
        $navigate['sub_nav']     = '';

        $results['baby_list']    = Baby::baby_list_delete();
        $results['baby_list'][0] = '-- Select Baby --';
        ksort($results['baby_list']);

        $results['baby_id']      = Baby::where('BabyId', $baby_id)
                                        ->first();

        $results['baby_details'] = Baby::baby_delete_approval($baby_id);

        $results['motherrecord'] = Mother::mother_delete_approval($results['baby_id']->MotherId);

        $results['neonatal_list']= Neonatal::neonatal_delete_approval($baby_id);

        $results['nicuadmission']= Nicu::nicu_delete_approval($baby_id);

        $daycare_list            = Daycare::daycare_delete_approval($baby_id);

        $results['daycare_list'] = $daycare_list->unique('AdmissionId')
                                            ->pluck('episodes', 'AdmissionId')
                                            ->toArray();

        foreach ($results['daycare_list'] as $key => $admissionid) {

            $results['daycare_list'][$admissionid] = $daycare_list->where('AdmissionId', $key)->toArray();

            unset($results['daycare_list'][$key]);
        }   

        $results['nicu_summary_daycare'] = NicuDischarge::get_inpatient_baby_sublists($baby_id); 

        $results['postnatal_admmission'] = Postnatal::postnatal_delete_approval($baby_id);

        $postnatal_daycare_list          = PostDaycare::daycare_delete_approval($baby_id);

        $results['postnatal_daycare']    = $postnatal_daycare_list->unique('AdmissionId')
                                            ->pluck('episodes', 'AdmissionId')
                                            ->toArray();

        foreach ($results['postnatal_daycare'] as $key => $admissionid) {

               $results['postnatal_daycare'][$admissionid] = $postnatal_daycare_list->where('AdmissionId', $key)->toArray();

               unset($results['postnatal_daycare'][$key]);
        }   

        $results['postnatal_discharge'] =  PostnatalDischarge::Dischargelist_delete_approval($baby_id);

        $results['postnatal_summary']   = PostProblemDischargeSummary::getAdmissionList($baby_id);

        $results['op_visite']           = Op::Opvisit_delete_approval($baby_id);

        $results['echocardiogram']      = Cardio::GetList_delete_approval($baby_id);

        $results['ultraculture']        = Ultra::GetList_delete_approval($baby_id);               

        return view('search.remove-baby-record', compact('results', 'navigate', 'baby_id'));

    }

    /**
     * Remove the mother record based on mother id.
     *
     * @param $baby_id type integer
     *
     * @param $id type integer
     *
     * @return \Illuminate\Http\Response
     */
    public function mother_destroy($baby_id, $id)
    {
        $twin_baby_check = Baby::multiple_baby_check($id);

        $baby_status     = 0;

        foreach ($twin_baby_check as $key => $value) {
            $baby = Baby::baby_delete($value->BabyId);
            if (isset($baby) && $baby->Status == 'Approved') {
                $baby_status++;
            }
        } 

        if (count($twin_baby_check) == 0 || count($twin_baby_check) == $baby_status) {            
            $results = Mother::findOrfail($id);

            $user_detail = array(
                'UserDeleted'   => $this->auth->user()->id,
                'DateModified'  => Carbon::now($this->zone),
                'IsDeleted'     => '1'
            );
            $results->update($user_detail);

            $result = Mother::mother_delete_approval($id);

            $res    = $result[0];

            $delete_data = array(
                'Name'             => $res->MotherName,
                'ModuleController' => 'Registration\MotherController',
                'ModuleId'         => $id,
                'ModuleName'       => 'Mother Registration',
                'UserDeleted'      => $this->auth->user()->id,
                'DateDeleted'      => Carbon::now($this->zone)
            );
            DeleteApproval::create($delete_data);

            $text       = 'Delete Record Successfully';
            $type       = 'success';
            $status     = 'Waiting for an approval';
            $statuscode = 200;
        } else {
            $text       = 'Unable to delete.Because record is used by another module.';
            $type       = 'warning';
            $status     = '';
            $statuscode = 500;
        }        
        return Response::json(['text' => $text, 'type' => $type, 'status' => $status, 'statuscode' => $statuscode]);
    }

    /**
     * Remove the baby record based on baby id.
     * 
     * @param $id type integer
     *
     * @return \Illuminate\Http\Response
     */
    public function baby_destroy($id)
    {
        $neonatal_list   = Neonatal::neonatal_delete_approval($id);

        $neonatal_status = 0;

        foreach ($neonatal_list as $key => $value) {
            $neonatal    = Neonatal::neonatal_delete($id, $value->NeonatalId);
            if (isset($neonatal) && $neonatal->Status == 'Approved') {
                $neonatal_status++;
            }
        }
            
        if (count($neonatal_list) == 0 || count($neonatal_list) == $neonatal_status) {

            $results     = Baby::findOrfail($id);

            $user_detail = array(
                'UserDeleted'   => $this->auth->user()->id,
                'DateModified'  => Carbon::now($this->zone),
                'IsDeleted'     => '1'
            );
            $results->update($user_detail);

            $result = Baby::get_record($id);

            $res    = $result[0];

            $delete_data = array(
                'Name'             => $res->BabyName,
                'ModuleController' => 'Registration\BabyController',
                'ModuleId'         => $id,
                'ModuleName'       => 'Baby Registration',
                'UserDeleted'      => $this->auth->user()->id,
                'DateDeleted'      => Carbon::now($this->zone)
            );
            DeleteApproval::create($delete_data);

            $text       = 'Delete Record Successfully';
            $type       = 'success';
            $status     = 'Waiting for an approval';
            $statuscode = 200;
        } else {
            $text       = 'Access denied: This baby referred to another record!';
            $type       = 'warning';
            $status     = '';
            $statuscode = 500;
        }

        return Response::json(['text' => $text, 'type' => $type, 'status' => $status, 'statuscode' => $statuscode]);
    }

    /**
     * Remove the neonatal performa.
     *
     * @param $baby_id type integer
     *
     * @param $id type integer
     *
     * @return \Illuminate\Http\Response
     */
    public function neonatal_performa_destroy($baby_id,$id)
    {
        $neonatal_id = SiteHelpers::decrypt_id($id);

        $nicu_status = $postnatal_status = 0;

        $all_nicu_id = Nicu::nicu_delete_approval($baby_id);        

        foreach ($all_nicu_id as $key => $value) {
            $nicu    = Nicu::neonatal_delete($value->NicuId);
            if (isset($nicu) && $nicu->Status == 'Approved') {
                $nicu_status++;
            }
        }

        $all_postnatal_id = Postnatal::postnatal_delete_approval($baby_id);

        foreach ($all_postnatal_id as $key => $value) {
            $postnatal    = Postnatal::neonatal_delete($value->pid);
            if (isset($postnatal) && $postnatal->Status == 'Approved') {
                $postnatal_status++;
            }
        }

        if ((count($all_nicu_id) == 0 || count($all_nicu_id) == $nicu_status) && (count($all_postnatal_id) == 0 || count($all_postnatal_id) == $postnatal_status)) {

            $results = Neonatal::findOrfail($neonatal_id);

            $user_detail = array(
                'UserDeleted'   => $this->auth->user()->id,
                'DateModified'  => Carbon::now($this->zone),
                'IsDeleted'     => '1'
            );
            $results->update($user_detail);

            $result = Neonatal::get_record($neonatal_id);

            $res    = $result[0];

            $delete_data = array(
                'Name'             => $res->BabyName,
                'ModuleController' => 'Registration\NeonatalController',
                'ModuleId'         => $neonatal_id,
                'ModuleName'       => 'Neonatal Proforma',
                'UserDeleted'      => $this->auth->user()->id,
                'DateDeleted'      => Carbon::now($this->zone)
            );
            DeleteApproval::create($delete_data);

            $text       = 'Delete Record Successfully';
            $type       = 'success';
            $status     = 'Waiting for an approval';
            $statuscode = 200; 
        } else {
            $text       = 'Access denied: This neonatal proforma referred to a nicu or postnatal admission!';
            $type       = 'warning';
            $status     = '';
            $statuscode = 500;            
        }

        return Response::json(['text' => $text, 'type' => $type, 'status' => $status, 'statuscode' => $statuscode]);
    }

    /**
     * Remove the nicu record.
     *
     * @param $baby_id type integer
     *
     * @param $nicuid type integer
     *
     * @return \Illuminate\Http\Response
     */
    public function nicu_destroy($babyid, $nicuid)        
    {
        $daycare_list        = Daycare::daycare_delete_approval($babyid);

        $nicu_daycare_status = 0;

        foreach ($daycare_list as $key => $value) {
            $nicu_daycare    = Daycare::daycare_delete($nicuid, $value->DayId);
            if (isset($nicu_daycare) && $nicu_daycare->Status == 'Approved') {
                $nicu_daycare_status++;
            }
        }

        if (count($daycare_list) == 0 || count($daycare_list) == $nicu_daycare_status) {

            $results  = Nicu::findOrfail($nicuid);

            $user_detail = array(
                'UserDeleted'  => $this->auth->user()->id,
                'DateModified' => Carbon::now($this->zone),
                'IsDeleted'    => '1'
            );
            $results->update($user_detail);
            $result = Nicu::get_record($nicuid);
            $res    = $result[0];

            $delete_data = array(
                'Name'             => $res->BabyName,
                'AdmissionDate'    => $results['AdmissionDate'],
                'ModuleController' => 'Admission\NicuController',
                'ModuleId'         => $nicuid,
                'ModuleName'       => 'NICU Admission',
                'UserDeleted'      => $this->auth->user()->id,
                'DateDeleted'      => Carbon::now($this->zone)
            );
            DeleteApproval::create($delete_data);
            $text       = 'Delete Record Successfully';
            $type       = 'success';
            $status     = 'Waiting for an approval'; 
            $statuscode = 200;
        } else {
            $text       = 'Access denied: This nicu admission referred to a daycare entry!';
            $type       = 'warning';
            $status     = '';
            $statuscode = 500;
        }

        return Response::json(['text' => $text, 'type' => $type, 'status' => $status, 'statuscode' => $statuscode]);
    }

    /**
     * Remove the postnatal record.
     *
     * @param $baby_id type integer
     *
     * @param $id type integer
     *
     * @return \Illuminate\Http\Response
     */
    public function postnatal_destroy($baby_id, $id)
    {        
        $post_id                = SiteHelpers::decrypt_id($id);

        $post_daycare_status    = $postnatal_discharge_status = 0;

        $postnatal_daycare_list = PostDaycare::daycare_delete_approval($baby_id);

        foreach ($postnatal_daycare_list as $key => $value) {            
            $post_daycare   = PostDaycare::daycare_delete($post_id, $value->PDayId); 
            if (isset($post_daycare) && $post_daycare->Status == 'Approved') {
                $post_daycare_status++;
            }
        }
        
        $postnatal_discharge_list    =  PostnatalDischarge::Dischargelist_delete_approval($baby_id);

        foreach ($postnatal_discharge_list as $key => $value) {            
            $postnatal_discharge   = PostnatalDischarge::postnatal_delete($post_id, $value->posdisid);
            if (isset($postnatal_discharge) && $postnatal_discharge->Status == 'Approved') {
                $postnatal_discharge_status++;
            }
        }

        if ((count($postnatal_daycare_list) == 0 || count($postnatal_daycare_list) == $post_daycare_status) && (count($postnatal_discharge_list) == 0 || count($postnatal_discharge_list) == $postnatal_discharge_status)) {

            $results           = Postnatal::findOrfail($post_id);
            $discharge_details = PostnatalDischarge::where('BabyId', $results->BabyId)
                                         ->where('MotherId', $results->MotherId)
                                         ->where('AdmissionId', $results->AdmissionId)
                                         ->first();

            $user_detail = array(
                'UserDeleted'  => $this->auth->user()->id,
                'DateModified' => Carbon::now($this->zone),
                'IsDeleted'    => '1'
            );

            $baby =  Baby::find($results->BabyId);

            if (empty($discharge_details->posdisid)) {
               $discharge_results = PostnatalDischarge::findOrfail($discharge_details->posdisid);
               $discharge_results->update($user_detail);
            }

            $delete_data = array(
                'Name'             => $baby['BabyName'],
                'ModuleController' => 'Admission\PostnatalController',
                'ModuleId'         => $post_id,
                'ModuleName'       => 'Postnatal Admission',
                'UserDeleted'      => $this->auth->user()->id,
                'DateDeleted'      => Carbon::now($this->zone),
            );

            $results->update($user_detail);

            DeleteApproval::create($delete_data);

            $text       = 'Delete Record Successfully';
            $type       = 'success';
            $status     = 'Waiting for an approval';
            $statuscode = 200;
        } else {
            $text       = 'Access denied: This postnatal admission referred to a daycare or postnatal discharge!';
            $type       = 'warning';            
            $status     = '';
            $statuscode = 500;
        }

        return Response::json(['text' => $text, 'type' => $type, 'status' => $status, 'statuscode' => $statuscode]);
    }

    /**
     * Remove the nicu daycare list.
     * 
     * @param $id type integer
     *
     * @return \Illuminate\Http\Response
     */
    public function nicu_daycare_destroy($id)
    {
        $results = Daycare::findOrfail($id);

        $user_detail = array(
            'UserDeleted'  => $this->auth->user()->id,
            'DateModified' => Carbon::now($this->zone),
            'IsDeleted'    => '1'
        );
        $results->update($user_detail);
        $result = Daycare::getrecord($id);
        $res    = $result[0];

        $delete_data = array(
            'Name'             => $res->BabyName,
            'AdmissionDate'    => $results['DayDate'],
            'ModuleController' => 'Admission\DaycareController',
            'ModuleId'         => $id,
            'ModuleName'       => 'Daycare Sheet',
            'UserDeleted'      => $this->auth->user()->id,
            'DateDeleted'      => Carbon::now($this->zone)
        );
        DeleteApproval::create($delete_data);

        return redirect(action('Search\RemoveBabyRecordController@index',$res->BabyId))->with('Success','Record deleted successfully!');
    }

    /**
     * Remove the postnatal daycare list.
     *
     * @param $id type integer
     *
     * @return \Illuminate\Http\Response
     */
    public function postnatal_daycare_destroy($id)
    {
        $results = PostDaycare::findOrfail($id);

        $user_detail = array(
            'UserDeleted'   => $this->auth->user()->id,
            'DateModified'  => Carbon::now($this->zone),
            'IsDeleted'     => '1'
        );
        $results->update($user_detail);
        $result = PostDaycare::get_record($id);
        $res    = $result;
        
        $delete_data = array(
            'Name'             => $res->BabyName,
            'AdmissionDate'    => $results['DayDate'],
            'ModuleController' => 'Admission\PostnatalDaycareController',
            'ModuleId'         => $id,
            'ModuleName'       => 'Postnatal Daycare Sheet',
            'UserDeleted'      => $this->auth->user()->id,
            'DateDeleted'      => Carbon::now($this->zone)
        );
        DeleteApproval::create($delete_data);

        return redirect(action('Search\RemoveBabyRecordController@index',$res->BabyId))->with('Success','Record deleted successfully!');
    }

    /**
     * Remove the postnatal discharge details.
     *
     * @param $id type integer
     *
     * @return \Illuminate\Http\Response
     */
    public function postnatal_discharge_destroy($id)
    {
        $results           = PostnatalDischarge::findOrfail($id);

        $discharge_details = PostnatalDischarge::where('BabyId', $results->BabyId)
                                 ->where('MotherId', $results->MotherId)
                                 ->where('AdmissionId', $results->AdmissionId)
                                 ->first();
        $user_detail = array(
            'UserDeleted'  => $this->auth->user()->id,
            'DateModified' => Carbon::now($this->zone),
            'IsDeleted'    => '1'
        );

        $baby =  Baby::find($results->BabyId);

        if (empty($discharge_details->posdisid)) {
           $discharge_results = PostnatalDischarge::findOrfail($discharge_details->posdisid);
           $discharge_results->update($user_detail);
        }
        $delete_data = array(
            'Name'             => $baby['BabyName'],
            'ModuleController' => 'Admission\PostnatalDischargeController',
            'ModuleId'         => $id,
            'ModuleName'       => 'Postnatal Discharge',
            'UserDeleted'      => $this->auth->user()->id,
            'DateDeleted'      => Carbon::now($this->zone)            
        );
        $results->update($user_detail);

        DeleteApproval::create($delete_data);  

        return redirect(action('Search\RemoveBabyRecordController@index',$results->BabyId))->with('Success','Record deleted successfully!');
    }

    /**
     * Remove the op record.
     *
     * @param $id type integer
     *
     * @return \Illuminate\Http\Response
     */
    public function op_destroy($id)
    {
        $results = Op::findOrfail($id);

        $user_detail = array(
            'UserDeleted'   => $this->auth->user()->id,
            'DateModified'  => Carbon::now($this->zone),
            'IsDeleted'     => '1'
        );
        $results->update($user_detail);
        $result = Op::get_oprecord($id);
        $op_res = $result[0];
        $delete_data = array(
            'Name'             => $op_res->BabyName,
            'AdmissionDate'    => $results['OpDate'],
            'ModuleController' => 'Registration\OpController',
            'ModuleId'         => $id,
            'ModuleName'       => 'OP Registration',
            'UserDeleted'      => $this->auth->user()->id,
            'DateDeleted'      => Carbon::now($this->zone)
        );
        DeleteApproval::create($delete_data);

        return redirect(action('Search\RemoveBabyRecordController@index',$op_res->BabyId))->with('Success','Record deleted successfully!');
    }

    /**
     * Remove the Echocardiography record.
     *
     * @param $id type integer
     *
     * @return \Illuminate\Http\Response
     */
    public function echocardiography_destroy($id)
    {        
        $results = Cardio::findOrfail($id);

        $user_detail = array(
            'UserDeleted'   => $this->auth->user()->id,
            'DateModified'  => Carbon::now($this->zone),
            'IsDeleted'     => '1'
        );
        $results->update($user_detail);
        $result = Cardio::get_record($id);
        $res    = $result[0];
        
        $delete_data = array(
            'Name'             => $res->BabyName,
            'AdmissionDate'    => $results['TestDate'],
            'ModuleController' => 'Extras\CardioController',
            'ModuleId'         => $id,
            'ModuleName'       => 'Echocardiography',
            'UserDeleted'      => $this->auth->user()->id,
            'DateDeleted'      => Carbon::now($this->zone)
        );
        DeleteApproval::create($delete_data);

        return redirect(action('Search\RemoveBabyRecordController@index',$res->BabyId))->with('Success','Record deleted successfully!');
    }
    
    /**
     * Remove the Cranial Ultrasonography record.
     *
     * @param $id type integer
     *
     * @return \Illuminate\Http\Response
     */
    public function cranial_ultrasonography_destroy($id)
    {        
        $results = Ultra::findOrfail($id);

        $user_detail = array(
            'UserDeleted'   => $this->auth->user()->id,
            'DateModified'  => Carbon::now($this->zone),
            'IsDeleted'     => '1'
        );
        $results->update($user_detail);
        $result = Ultra::get_record($id);
        $res    = $result[0];
        
        $delete_data = array(
            'Name'             => $res->BabyName,
            'AdmissionDate'    => $results['TestDate'],
            'ModuleController' => 'Extras\UltraController',
            'ModuleId'         => $id,
            'ModuleName'       => 'Ultra Sound Scan',
            'UserDeleted'      => $this->auth->user()->id,
            'DateDeleted'      => Carbon::now($this->zone)
        );
        DeleteApproval::create($delete_data);

        return redirect(action('Search\RemoveBabyRecordController@index',$res->BabyId))->with('Success','Record deleted successfully!');
    }
}
