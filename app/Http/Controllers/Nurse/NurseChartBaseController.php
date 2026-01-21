<?php

namespace App\Http\Controllers\Nurse;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

abstract class NurseChartBaseController extends Controller
{
	/**
    * @var $auth type object 
    */
    public $auth;

   /**
    *@var $emr_log_head type object 
    */
    public $emr_log_head;
    
   /**
    * @var $time_zone type string 
    */
    public $time_zone;

    /**
     * @var $loinc_values type array 
     */
    public $loinc_values;

    /**
     * @var $loinc_group_values type array 
     */
    public $loinc_group_values;

    /**
     * @var $time_interval type integer 
     */
    public $time_interval;

    /**
     * @var $error_log type object 
     */
    public $error_log;

	 /**
     * @var $error_log type object 
     */
    public $chart_property;

    /**
     * @var $vital_chart
     */
    public $vital_chart;

    /**
     * @var $vendilator_chart type object
     */
    public $vendilator_chart;

    /**
     * @var $flag type integer
     */
    public $flag;
   
    



}
