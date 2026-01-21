<?php

namespace App\Http\Controllers\Sockets;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Sockets\Hl7BaseController;

/* Use of the controller is only for formate the response Note: only for patient Details

 Important Note: Hl7BaseController is comman for   Hl7MessageController and Hl7QueryController  */

class Hl7MessageController extends Hl7BaseController
{
    public $information='';
    public $check='';

   
   public function __construct($value='') 
   {
         Parent::__construct();

         $this->check   = $this->field_separate($value);
         $query_message = $this->field_separate($value);


             $this->information['Mr_Number']    = $this->component_seperate($query_message[2]);
             $this->information['Name']         = $this->component_seperate($query_message[5]);
             $this->information['Dob']          = date('d-m-Y', strtotime($query_message[7]));
             $this->information['Gender']       = $this->_FeldsName['Gender'][$query_message[8]];
             $this->information['Address']      = $this->component_seperate($query_message[11]);
             $this->information['PhoneNumber']  = $this->component_seperate($query_message[13]);
                       

   }
   
   // This will seprate the values based on $this->_hl7Globals['COMPONENT_SEPARATOR'] 
   public function component_seperate($component_value)
   {

     if (isset($component_value) && !empty($component_value) && stripos($component_value, $this->_hl7Globals['COMPONENT_SEPARATOR']) > 0) {
          return explode($this->_hl7Globals['COMPONENT_SEPARATOR'], $component_value);
        }

      return $component_value;
   }

   public function field_separate($field_value)
   {
      if (isset($field_value) && !empty($field_value) && stripos($field_value, $this->_hl7Globals['FIELD_SEPARATOR']) > 0) {

           return explode($this->_hl7Globals['FIELD_SEPARATOR'], $field_value);
       }
      return $field_value;

   }

     public function Get_details()
     {

        return $this->information;
    }
}
































