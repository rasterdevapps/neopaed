<?php

namespace App\Http\Controllers\Sms;

use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\ReferalSmsDoc;

class SmsController extends Controller
{


    /**
    *The provider login id
    *
    *@var string
    */
    public $loginid;

    /**
    *The provider password
    *
    *@var string
    */
    public $password;

    /**
    *The provider Sender id
    *
    *@var string
    */
    public $sender_id; 

    /**
    *The provider url
    *
    *@var string
    */
    public $uri;

    /**
    *The sms settings 
    *
    *@var array
    */
    public $paramattribute;
    
    /**
    *The receiver mobile number  
    *
    *@var numeric
    */
    public $phone;

    /**
    *The receiver message   
    *
    *@var string
    */
    public $message;

    /**
    *The request module name 
    *
    *@var string
    */
    public $module; 

    /**
    *The request module record id
    *
    *@var integer
    */
    public $sourceid;


   public function __construct()
   {
     // The provider login id initializing 
     $this->loginid       = env('SMSLOGINID');
     // The provider password initializing
     $this->password      = env('SMSPASSWORD');
     // The provider sender id initializing
     $this->sender_id     = env('SMSSENDERID');
     // The provider Url initializing
     $this->uri           = env('SMSURI');
     // creating object for sms log 

     $this->referalSmsdoc = new ReferalSmsDoc();
    
   }

   /**
   * initializing the sms parameters
   *
   *@return array
   */
   private function setSmsparameter()
   {
     return $this->paramattribute =['loginid'=>$this->loginid,
                                     'password'=>$this->password,
                                     'sender_id'=>$this->sender_id,
                                     'to'=>$this->phone,
                                     'message'=>$this->message];  

   }

  /**
   * initializing the sms phone number,message,module,sourceid
   *
   *@param  phone     numeric
   *@param  message   string
   *@param  module    string
   *@param  sourceid  integer
   *@return true  bool
   */

   private function setCustomeparam($phone, $message, $module, $sourceid)
   {
         $this->phone    = $phone;
         $this->message  = $message;
         $this->module   = $module;
         $this->sourceid = $sourceid;

     return true;
   }

   /**
   * send message to the receiver 
   *
   *@param  phone     numeric
   *@param  message   string
   *@param  module    string
   *@param  sourceid  integer
   *@return true  bool
   */

   public function sendSms($phone, $message, $module = 'default', $sourceid = 0)
   {
      $this->setCustomeparam($phone, $message, $module, $sourceid);
      $this->setSmsparameter();
      $this->constructUri();
      $this->createSmslog();
      $client  = new \GuzzleHttp\Client();
      $smsrequest = new \GuzzleHttp\Psr7\Request('GET', $this->uri);
      $promise = $client->sendAsync($smsrequest)->then(function ($response) {
            return $response;
      });
     $promise->wait();

     return true;


   }

   /**
   * Constructing the provider url
   *@return provider url 
   */

   public function constructUri()
   {
    $this->uri .='?';
      $i=0;
       foreach ($this->paramattribute as $key => $value) {
         $this->uri .= ($i==0) ? $key.'='.$value : '&'.$key.'='.$value;
         $i++;
       }
       return $this->uri;
   }

   /**
   * Creating sms record
   *
   *@return sms record id integer
   */

   public function createSmslog()
   {
      $this->referalSmsdoc->message_receiver  =  $this->phone ;
      $this->referalSmsdoc->message_sender    =  \Auth::user()->id;
      $this->referalSmsdoc->message           =  $this->message;
      $this->referalSmsdoc->DateAdded         =  Carbon::now();
      $this->referalSmsdoc->sourceid          =  $this->sourceid;
      $this->referalSmsdoc->module            =  $this->module;
      $this->referalSmsdoc->save();
      return $this->referalSmsdoc->sms_id;
   }

    
}
