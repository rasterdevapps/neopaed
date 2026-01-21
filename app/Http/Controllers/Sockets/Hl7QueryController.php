<?php

namespace App\Http\Controllers\Sockets;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Sockets\Hl7BaseController;

/* Important Note: Hl7BaseController is comman for   Hl7MessageController and Hl7QueryController  */

class Hl7QueryController extends Hl7BaseController
{
    public $_patient_id='';

   public function __construct() 
   {    
        Parent::__construct();
        //follow this order to create segements
        $this->_patient_id=$this->set_pid_felds('3.1', '000000');
        $this->set_segmentlength();
        $this->create_segement();
   } 


    
    // For fix the segment size 
   public function set_segmentlength($length = 17)
   {

     return $this->_segmentlength = $length;

   }

   // For create the segments based on segment size 
   public function create_segement()
   {

      for ($i=0 ; $i < $this->_segmentlength; $i++) {
            $this->_messagesegment[$i]='';
      } 
   }
  // For set the segment value base on column index 
   public function set_segmentvalue($index, $value)
   {

      if (!empty($index) && !empty($value)) {
         return $this->_messagesegment[$index] = $value;
      }

   }
   // return the created segment 
   public function get_segment() 
   {
        return $this->_messagesegment;
   }

   // create the Msh message formate 
   public function create_msh()
   {

     $this->_messagesegment[0] = 'MSH';
     $this->_messagesegment[1] = $this->_hl7Globals['COMPONENT_SEPARATOR'].$this->_hl7Globals['REPETITION_SEPARATOR'].$this->_hl7Globals['ESCAPE_CHARACTER'].$this->_hl7Globals['SUBCOMPONENT_SEPARATOR'];
     $this->_messagesegment[2] = $this->_appname;
     $this->_messagesegment[3] = 'IBM';
     
     return $this->_messagesegment;
   }

   public function set_pid_felds($fid, $pid)
   {
     return $this->_patient_id = "@PID.".$fid."^".$pid."\rRCP";
   }


   public function create_patient()
   {
     $this->create_msh();
     $this->_messagesegment[4] = 'PAT_IDENTITY_X_REF_MGR_MISYS';
     $this->_messagesegment[5] = 'ALLSCRIPTS';
     $this->_messagesegment[6] = '20090226131520-0600';
     $this->_messagesegment[7] = '';
     $this->_messagesegment[8] = 'QBP^Q22^QBP_Q21';
     $this->_messagesegment[9] = strftime("%Y%m%d%H%M%S") . rand(10000, 99999);
     $this->_messagesegment[10] = 'P';
     $this->_messagesegment[11] = $this->_hl7Globals['HL7_VERSION']."\rQPD";
     $this->_messagesegment[12] = 'Q22^Find Candidates^HL7';
     $this->_messagesegment[13] ='4870964660388599565096567512128';
     $this->_messagesegment[14] =$this->_patient_id;
     $this->_messagesegment[15] ='I';
     $this->_messagesegment[16] ='10^RD';

     return $this->_messagesegment;

   }
}
