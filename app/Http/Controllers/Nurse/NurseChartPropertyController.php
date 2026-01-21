<?php

namespace App\Http\Controllers\Nurse;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

/**
 * All the method to provide chart property 
 *
 * @author Manikandan M  
 */

class NurseChartPropertyController extends Controller 
{
  /**
   * @var $vitals_parameters type array
   */
   public $vitals_parameters;

   /**
   * @var $vitals_parameters type array
   */
   public $ventilator_parameters;

   /**
   * @var $vitals_group_one type array
   */
   public $vitals_group_one;

   /**
   * @var $vitals_group_two type array
   */
   public $vitals_group_two;

   /**
   * @var $vitals_group_three type array
   */
   public $vitals_group_three;

   /**
   * @var $vitals_group_four type array
   */
   public $vitals_group_four;

   /**
    * @var $vitals_parameter type array
    */
   public $vitals_parameter;

   
   /**
    * This method to get date periods 
    * based on parameter 
    *
    * @param $flag type sting 
    */   
   public function __construct()
   {
      $this->vitals_parameters        = json_decode(\SiteHelpers::getConfigSettings('VITALS_PARAMETERS'));

      $this->ventilator_parameters    = json_decode(\SiteHelpers::getConfigSettings('VENTILATOR_PARAMETERS'));

      $this->vitals_group_one       	= json_decode(\SiteHelpers::getConfigSettings('VITALS_GROUP_ONE'));

      $this->vitals_group_two       	= json_decode(\SiteHelpers::getConfigSettings('VITALS_GROUP_TWO'));
      $this->vitals_group_three       = json_decode(\SiteHelpers::getConfigSettings('VITALS_GROUP_THREE'));
      $this->vitals_group_four      	= json_decode(\SiteHelpers::getConfigSettings('VITALS_GROUP_FOUR'));
      $this->vitals_label             = json_decode(\SiteHelpers::getConfigSettings('VITALS_LABEL'));

      $this->ventilator_group_one  		= json_decode(\SiteHelpers::getConfigSettings('VENTILATOR_GROUP_ONE'));
      $this->ventilator_group_two   	= json_decode(\SiteHelpers::getConfigSettings('VENTILATOR_GROUP_TWO'));
      $this->ventilator_group_three   = json_decode(\SiteHelpers::getConfigSettings('VENTILATOR_GROUP_THREE'));
    
      $this->ventilator_group_four   	= json_decode(\SiteHelpers::getConfigSettings('VENTILATOR_GROUP_FOUR'));
      $this->ventilator_group_five  	= json_decode(\SiteHelpers::getConfigSettings('VENTILATOR_GROUP_FIVE'));
      $this->ventilator_group_six   	= json_decode(\SiteHelpers::getConfigSettings('VENTILATOR_GROUP_SIX'));
      $this->ventilator_group         = json_decode(\SiteHelpers::getConfigSettings('VENTILATOR_GROUP'));
      $this->ventilator_label         = json_decode(\SiteHelpers::getConfigSettings('VENTILATOR_LABELS'));
      
      $this->time_zone                = env('TIME_ZONE');


   }

   /**
    * This method to get date periods 
    * based on parameter 
    *
    * @param $flag type sting 
    */
   public function getchartvitalproperty($flag = 1) 
   {

        switch ($flag) {
          case '1':

            return json_decode(\SiteHelpers::getConfigSettings('VITALS_LINE_CHART_PROPERTY'));
          break;
          case '2':

            return json_decode(\SiteHelpers::getConfigSettings('VITALS_CANDLE_CHART_PROPERTY'));
          break;
          case '3':

            return json_decode(\SiteHelpers::getConfigSettings('VITALS_BOX_WHISKER_PROPERTY'));
          break;
        }
    }

   /**
    * This method to get date periods 
    * based on parameter 
    *
    * @param $flag type sting 
    */
    public function getvendilatorproperty($flag = 1) 
    {
      switch ($flag) {
          case '1':
            return json_decode(\SiteHelpers::getConfigSettings('VENTILATOR_LINE_CHART_PROPERTY'));
          break;
          case '2':
            return json_decode(\SiteHelpers::getConfigSettings('VITALS_CANDLE_CHART_PROPERTY'));
          break;
          case '3':
            return json_decode(\SiteHelpers::getConfigSettings('VENDILATOR_BOX_WHISKER_PROPERTY'));
          break;
        }


    }

   /**
    * This method to get date periods 
    * based on parameter 
    *
    * @param $date_slug type sting 
    */
    public function getdateduration($slug = "All")
    {
         switch ($slug) {
           case 'Today':
                $temp_date['period_start'] = $temp_date['period_end'] = Carbon::now($this->time_zone)->format('Y-m-d');
           break;
           case 'Weeks':
                $temp_now     = Carbon::now();
                $temp_date['period_end']   = Carbon::now()->format('Y-m-d');
                $temp_date['period_start'] = $temp_now->subWeek(1)->format('Y-m-d');
           break;
           case 'Month':
                $temp_now                  = Carbon::now();
                $temp_date['period_end']   = Carbon::now()->format('Y-m-d');
                $temp_date['period_start'] = $temp_now->subMonth(1)->format('Y-m-d');
           break;
           case 'All':
                $temp_date['period_end']   = '';
                $temp_date['period_start'] = '';
             break;
           
           default:
             break;
         }

         return $temp_date;

      }
}
