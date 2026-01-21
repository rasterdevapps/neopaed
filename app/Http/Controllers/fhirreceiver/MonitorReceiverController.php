<?php

namespace App\Http\Controllers\fhirreceiver;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Models\Settings\Settings;
use App\Models\Machine\MachineData;
use Carbon\Carbon;
use App\Http\Controllers\Fhir\FhirFormateController;
use App\Http\Controllers\Fhir\ImportFhirController;

class MonitorReceiverController extends Controller
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
	public function __construct(Settings $site_settings, 
                                FhirFormateController $fhir_formate,
                                ImportFhirController $import_values)
	{
		$this->site_settings       = $site_settings;  
        $this->fhir_formate        = $fhir_formate;
        $this->import_values       = $import_values;

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
    	   $input = $request->all();
    	   $auth  = false;

            $machine_data['received'] = file_get_contents('php://input');
           // $machine_data['received'] = file_get_contents(public_path().'/sample.json');


            $machine_entry = (array)json_decode($machine_data['received']);

            //$machine_entry = json_decode($machine_entry['data'][0]); 


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
                 			$api_key  	   = $securityLabel->where('code', 'api_key')->first();
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
    		   return \Response::json(['status'=>'failure','message'=>'Invalid api key or  credentials !'], 401);
    	   }

	       $machine_data['received_time']  = Carbon::now();
	       $machine_data['is_parsed']      = false;
	       $machine_data['received_ip']    = $request->ip(); 
           $machine_data['received_date'] = Carbon::now()->format('Y-m-d');
           
	  	    MachineData::create($machine_data);
            //$this->fhir_formate->getformatfhir();
            //$this->import_values->creatensursesheet();
            

  	 	return \Response::json(['status'=>'success','message'=>'Content Added Successfully'], 200);
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

    	$settings        		= $this->site_settings->find(1);
    	$api_key         		= \SiteHelpers::decrypt_id($settings->api_key);
    	$user_name     		    =  $settings->api_user_name;
    	$user_password   		= \SiteHelpers::decrypt_id($settings->api_password);

        if (($input['api_key'] == $api_key) && ($input['user_name'] == $user_name) &&  ($input['user_password'] == $user_password)) {
             return true;
        } else {
        	 return false;
        }

    }
}
