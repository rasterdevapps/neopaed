<?php

namespace App\Http\Controllers\Sockets;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class Hl7BaseController extends Controller
{
   public $_hl7Globals = array();
   public $_FeldsName  = array();
   public $_messagesegment=array();
   public $_appname='';
   public $_segmentlength='';


   public function __construct() 
   {

        $this->_hl7Globals['SEGMENT_SEPARATOR'] = '\015';
        $this->_hl7Globals['FIELD_SEPARATOR'] = '|';
        $this->_hl7Globals['NULL'] = '""';
        $this->_hl7Globals['COMPONENT_SEPARATOR'] = '^';
        $this->_hl7Globals['REPETITION_SEPARATOR'] = '~';
        $this->_hl7Globals['ESCAPE_CHARACTER'] = '\\';
        $this->_hl7Globals['SUBCOMPONENT_SEPARATOR'] = '&';
        $this->_hl7Globals['HL7_VERSION'] = '2.5';

        $this->_FeldsName['Gender']=['F'=>'Female',
                           'M'=>'Male',
                           'O'=>'Other',
                           'U'=>'Unknown',
                           'A'=>'Ambiguous',
                           'N'=>'Not applicable',
                           ''=>''];

        $this->_appname=env('APP_NAME');  

     
   } 

   public function Create_query()
   {

        $uni_number=strftime("%Y%m%d%H%M%S") . rand(10000, 99999); 
        $message="MSH|^~\&|OTHER_IBM_BRIDGE_TLS|IBM|PAT_IDENTITY_X_REF_MGR_MISYS|ALLSCRIPTS|20090226131520-0600||QBP^Q22^QBP_Q21|".$uni_number."|P|2.5 
        QPD|Q22^Find Candidates^HL7|4870964660388599565096567512128|@PID.3.1^320070
        RCP|I|10^RD";

   }

}
