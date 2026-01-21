<?php

namespace App\Http\Controllers\Errors;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Auth\Guard;


class ErrorLogController extends Controller
{
   /**
    *@var LOG_SCHDULE type const array 
    */
    public $log_schdule = ['daily'];

    /**
    *@var $logheader type instance  
    */
    public $logheader;

    /**
    *@var $auth type instance  
    */
    public $auth;

    /**
    *@var $logsettings type instance  
    */
    public $logsettings;

    public function __construct() 
    {
     
        $this->logsettings  = Log::channel('custom');

    }

   /**
    *This method to information log
    *
    *@param $message type string
    */ 
    public function infoLog($message = '')
    {
        $this->logsettings->info($message);
    }

   /**
    *This method to emergency log
    *
    *@param $message type string
    */ 
    public function emergencyLog($message = '')
    {
		$this->logsettings->emergency($message);
    }

   /**
    *This method to alert log
    *
    *@param $message type string
    */ 
    public function alertLog($message = '')
    {
    	$this->logsettings->alert($message);

    }

   /**
    *This method to critical log
    *
    *@param $message type string
    */
    public function criticalLog($message = '')
    {
		$this->logsettings->critical($message);

    }

   /**
    *This method to error log
    *
    *@param $message type string
    */
    public function errorLog($message = '')
    {
    	$this->logsettings->error($message);

    }

   /**
    *This method to warning log
    *
    *@param $message type string
    */
    public function warningLog($message = '')
    {
    	$this->logsettings->warning($message);

    }

   /**
    *This method to noice log
    *
    *@param $message type string
    */
    public function noticeLog($message = '')
    {
    	$this->logsettings->notice($message);

    }

   /**
    *This method to information log
    *
    *@param $message type string
    */
    public function debugLog($message = '')
    {
    	$this->logsettings->debug($message);

    }

   /**
    *This method to emergency log
    *
    *@param $message type string
    */ 
    public static function emergencyLogStat($message = '')
    {
        Log::channel('custom')->emergency($message);
    }

}









