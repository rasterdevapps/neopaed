<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Carbon\Carbon;
use App\Models\Reports\NeonatalSummary;
use App\Models\Settings\Settings;

use App\Models\Icd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\Guard;

/**
 * methods to neonatal summary details 
 *
 * @author Manikandan M  
 */
class NeonatalSummaryController extends Controller
{
  /**
   * Get the logged user details.
   *
   * @var $auth  
   */  
   public $auth;

  /**
   * Get the NeonatalSummary details.
   *
   * @var neonatalSummary
   */
   public  $neonatalSummary;

   /**
   * Used to bind the records to view resource.
   *
   * @var data
   */
   public  $data;
     
  /**
   * Display a listing of the resource.
   *
   * @param $auth instance of Illuminate\Contracts\Auth\Guard
   *
   * @param $neonatal_summary instance of App\Models\Reports\NeonatalSummary
   *
   * @return \Illuminate\Http\Response
   */
   public function __construct(Guard $auth, NeonatalSummary $neonatalSummary)
   {
       $this->middleware('role:POST_DISCHARGE,read', ['only'=>['index','show']]);   
       $this->neonatalSummary  = $neonatalSummary;  
       $this->data['title']    = 'Neonatal Summary';
   }

  /**
   * Display a listing of the resource.
   *
   * @param $request instance of Illuminate\Http\Request
   *
   * @return \Illuminate\Http\Response
   */
   public function index(Request $request)
   {
      
       $results = $this->neonatalSummary->get_neonatal_baby_list();

        $baby_list=array();
        foreach ($results as $key => $value) {
           $baby_name = (!empty($value->BMrNo)) ? $value->BabyName.'-'.$value->BMrNo :  $value->BabyName;

           $baby_list[\SiteHelpers::encrypt_id($value->BabyId)] =  $baby_name ;         
        }

        unset($results);
        $this->data['baby_list']         = $baby_list;
        $this->data['SubmitButtonText']  = "Start";
        
       
        return view('reports.neonatal-summary.list', $this->data);
        

   }

    /**
     * Display a report of the resource.
     *
     * @param $request instance of Illuminate\Http\Request
     *
     * @return \Illuminate\Http\Response
     */
    public function neonatal_summary(Request $request)
    {

          $input                                   = $request->all();
          $BabyId                                  = \SiteHelpers::decrypt_id($input['BabyId']);
          $this->data['vaccines']                  = array();          
          $this->data['results']                   =  $this->neonatalSummary->get_neonatal_summary($BabyId);
          $this->data['medical_problems']          =  $this->neonatalSummary->get_medical_problems($BabyId);
          $this->data['peganancy_complications']   =  $this->neonatalSummary->get_complications($BabyId);
          $this->data['discharge_medications']     =  $this->neonatalSummary->get_discharge_medicines($BabyId);
          $vaccine                                 =  $this->data['results']->Vaccine;
          $vaccineDate                             =  $this->data['results']->VaccineDate;
         if (!empty($vaccine) && !empty($vaccineDate)) { 

          if (\SiteHelpers::is_serialized($vaccine) && \SiteHelpers::is_serialized($vaccineDate)) {
            $tempvaccine                           = unserialize($vaccine);
            $tempvaccinedate                       = unserialize($vaccineDate);
              foreach ($tempvaccine as $key => $value) {
                if (!empty($value))
                  $this->data['vaccines'][]   = ['vaccineid'=>$value, 'vaccinedate'=>$tempvaccinedate[$key] ];

              }
          }

         } 
          unset($tempvaccine);
          unset($tempvaccinedate);
          unset($vaccine);
          unset($vaccineDate);
           $this->data['headerContent'] = Settings::findorfail(1);

           
           $this->data['consultant'] = \SiteHelpers::formating_consultant($this->data['results']->neonatal_consultant);
           
           $this->data['Gestation'] = \SiteHelpers::decode_gestation($this->data['results']->Gestation);

           $this->data['closewinlink']   = action('Reports\NeonatalSummaryController@index');

       return view('reports.neonatal-summary.print', $this->data);
    }

   
}
