<?php

namespace App\Http\Controllers\Nurse;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Nurse\EmrLogDetails;
use App\Models\Nurse\EmrLogHeader;
use Carbon\Carbon;

/**
 * All the method  to create vendilator nurse chart 
 *
 * @author Manikandan M  
 */

class MachineVendilatorChartController extends Controller
{   

    /**
     * @var $time_zone type array
     */
     public $time_zone;

     /**
      * This method class  
      * constructor 
      *
      */
     public function __construct(NurseChartPropertyController $chart_property)
     {
       $this->chart_property       = $chart_property;
       $this->time_zone  = env('TIME_ZONE');
     }

  	/**
  	 * This method to get ventilator chart from machine 
  	 * data 
  	 *
  	 * @param $input type array 
  	 *
  	 * @param $baby_id type integer
  	 *
  	 * @param $periods type array 
  	 *
  	 * @return type array 
  	 */
    public function getventilatorfrommachinecompare($input, $baby_id, $admission_id, $periods)
    {
       $parameter_data      = EmrLogHeader::getmachinedata($baby_id, $admission_id, $input['parameters'], '', $periods);
       $ventilator_group    = array();

        foreach ($parameter_data as &$value) {
          $value->issued_date = date('d-m-Y H:i:s', strtotime($value->issued));
        }
        $date_list = $parameter_data->unique('issued_date')->pluck('issued_date');

        foreach ($date_list as $date_list_key => $date_list_value) {
          foreach ($this->chart_property->ventilator_group_one as $key => $value) {
            $value_set = $parameter_data->where('issued_date', $date_list_value)->where('local_code', $value)->first();
            $prefix     = str_replace('_', '', $value);

              if (count($value_set) > 0) {
                 $temp_vendilator['date']          = Carbon::createFromTimestamp(strtotime($value_set->issued))->format('d-M-y H:i:s');
                 $temp_vendilator[$prefix.'open']  = $value_set->open;
                 $temp_vendilator[$prefix.'high']  = $value_set->high;
                 $temp_vendilator[$prefix.'mid']   = $value_set->mid;
                 $temp_vendilator[$prefix.'low']   = $value_set->low;
                 $temp_vendilator[$prefix.'close'] = $value_set->close;
                 $temp_vendilator['slug']          = $value;
                 $ventilator_group[]               = $temp_vendilator;
                 unset($temp_vendilator);
              }

          }
        }

         if (count($ventilator_group) > 0) {
            $main_ventilator['ventilator_group1'] = $ventilator_group;
         }
          $ventilator_group = array();

          foreach ($date_list as $date_list_key => $date_list_value) {
          foreach ($this->chart_property->ventilator_group_two as $key => $value) {
            $value_set = $parameter_data->where('issued_date', $date_list_value)->where('local_code', $value)->first();
            $prefix     = str_replace('_', '', $value);

              if (count($value_set) > 0) {
                 $temp_vendilator['date']          = Carbon::createFromTimestamp(strtotime($value_set->issued))->format('d-M-y H:i:s');
                 $temp_vendilator[$prefix.'open']  = $value_set->open;
                 $temp_vendilator[$prefix.'high']  = $value_set->high;
                 $temp_vendilator[$prefix.'mid']   = $value_set->mid;
                 $temp_vendilator[$prefix.'low']   = $value_set->low;
                 $temp_vendilator[$prefix.'close'] = $value_set->close;
                 $temp_vendilator['slug']          = $value;
                 $ventilator_group[]               = $temp_vendilator;
                 unset($temp_vendilator);
              }

          }
        }
         if (count($ventilator_group) > 0){
            $main_ventilator['ventilator_group2'] = $ventilator_group;
         }
          $ventilator_group = array();

          foreach ($date_list as $date_list_key => $date_list_value) {
          foreach ($this->chart_property->ventilator_group_three as $key => $value) {
            $value_set = $parameter_data->where('issued_date', $date_list_value)->where('local_code', $value)->first();
            $prefix     = str_replace('_', '', $value);

              if (count($value_set) > 0) {
                 $temp_vendilator['date']          = Carbon::createFromTimestamp(strtotime($value_set->issued))->format('d-M-y H:i:s');
                 $temp_vendilator[$prefix.'open']  = $value_set->open;
                 $temp_vendilator[$prefix.'high']  = $value_set->high;
                 $temp_vendilator[$prefix.'mid']   = $value_set->mid;
                 $temp_vendilator[$prefix.'low']   = $value_set->low;
                 $temp_vendilator[$prefix.'close'] = $value_set->close;
                 $temp_vendilator['slug']          = $value;
                 $ventilator_group[]               = $temp_vendilator;
                 unset($temp_vendilator);
              }

          }
        }
         if (count($ventilator_group) > 0){
            $main_ventilator['ventilator_group3'] = $ventilator_group;
         }
         $ventilator_group = array(); 

        foreach ($date_list as $date_list_key => $date_list_value) {
          foreach ($this->chart_property->ventilator_group_four as $key => $value) {
            $value_set = $parameter_data->where('issued_date', $date_list_value)->where('local_code', $value)->first();
            $prefix     = str_replace('_', '', $value);

              if (count($value_set) > 0) {
                 $temp_vendilator['date']          = Carbon::createFromTimestamp(strtotime($value_set->issued))->format('d-M-y H:i:s');
                 $temp_vendilator[$prefix.'open']  = $value_set->open;
                 $temp_vendilator[$prefix.'high']  = $value_set->high;
                 $temp_vendilator[$prefix.'mid']   = $value_set->mid;
                 $temp_vendilator[$prefix.'low']   = $value_set->low;
                 $temp_vendilator[$prefix.'close'] = $value_set->close;
                 $temp_vendilator['slug']          = $value;
                 $ventilator_group[]               = $temp_vendilator;
                 unset($temp_vendilator);
              }

          }
        }
        if (count($ventilator_group) > 0){
            $main_ventilator['ventilator_group4'] = $ventilator_group;
        }
        $ventilator_group = array();

        foreach ($date_list as $date_list_key => $date_list_value) {
          foreach ($this->chart_property->ventilator_group_five as $key => $value) {
            $value_set = $parameter_data->where('issued_date', $date_list_value)->where('local_code', $value)->first();
            $prefix     = str_replace('_', '', $value);

              if (count($value_set) > 0) {
                 $temp_vendilator['date']          = Carbon::createFromTimestamp(strtotime($value_set->issued))->format('d-M-y H:i:s');
                 $temp_vendilator[$prefix.'open']  = $value_set->open;
                 $temp_vendilator[$prefix.'high']  = $value_set->high;
                 $temp_vendilator[$prefix.'mid']   = $value_set->mid;
                 $temp_vendilator[$prefix.'low']   = $value_set->low;
                 $temp_vendilator[$prefix.'close'] = $value_set->close;
                 $temp_vendilator['slug']          = $value;
                 $ventilator_group[]               = $temp_vendilator;
                 unset($temp_vendilator);
              }

          }
        }
        if (count($ventilator_group) > 0){
            $main_ventilator['ventilator_group5'] = $ventilator_group;
        }
        $ventilator_group = array();

        foreach ($date_list as $date_list_key => $date_list_value) {
          foreach ($this->chart_property->ventilator_group_six as $key => $value) {
            $value_set = $parameter_data->where('issued_date', $date_list_value)->where('local_code', $value)->first();
            $prefix     = str_replace('_', '', $value);

              if (count($value_set) > 0) {
                 $temp_vendilator['date']          = Carbon::createFromTimestamp(strtotime($value_set->issued))->format('d-M-y H:i:s');
                 $temp_vendilator[$prefix.'open']  = $value_set->open;
                 $temp_vendilator[$prefix.'high']  = $value_set->high;
                 $temp_vendilator[$prefix.'mid']   = $value_set->mid;
                 $temp_vendilator[$prefix.'low']   = $value_set->low;
                 $temp_vendilator[$prefix.'close'] = $value_set->close;
                 $temp_vendilator['slug']          = $value;
                 $ventilator_group[]               = $temp_vendilator;
                 unset($temp_vendilator);
              }

          }
        }
        if (count($ventilator_group) > 0){
            $main_ventilator['ventilator_group6'] = $ventilator_group;
        }
        $ventilator_group = array();

        return $main_ventilator;

    }


    /**
     * This method get ventilator chart from machine data 
     * 
     * @param $input type array 
     *
     * @param $baby_id integer
     *
     * @param $vendilator_periods
     *
     * @return type array 
     */
    public function getventilatorfrommachine($input, $baby_id, $admission_id, $ventilator_periods, $selected_date = '', $box_parameter_list, $dot_parameter_list)
    {

        $parameter_list = array_merge($box_parameter_list, $dot_parameter_list);

        $results      = EmrLogHeader::getmachinedata($baby_id, $admission_id, $parameter_list, '', $ventilator_periods, '', $selected_date);

        $parameters = $results->pluck('local_description', 'local_code')->unique()->toArray();

        $boxwhsiker_data = $results->where('chart_type', true);

        $boxwhsiker_data = $boxwhsiker_data->sortBy('issued')->toArray();

        $line_chart_data = $results->where('chart_type', false);

        $dot_parameters = $line_chart_data->pluck('local_description', 'local_code')->unique()->toArray();

        $line_chart_data = $line_chart_data->sortBy('issued')->toArray();
        
        $ventilator_param    = array();     

        $map_param = [];

	      foreach ($boxwhsiker_data as &$value) {	    	       
	        $value->issued_date = Carbon::createFromTimestamp(strtotime($value->issued))->format('d-M-y H:i:s');
          $value->temp_issued_date = Carbon::createFromTimestamp(strtotime($value->issued))->format('d-M-y');
          $value->uniquedate = Carbon::createFromTimestamp(strtotime($value->issued))->format('d-M-y H:').'00';
	      }        

        foreach ($boxwhsiker_data as $key => $value) {
           $temp_ventilator_param = array();
           $prefix = str_replace('_', '', $value->local_code);
           $temp_ventilator_param['date']     = Carbon::createFromTimestamp(strtotime($value->issued))->format('H:').'00';
           $temp_ventilator_param['tempDate'] = Carbon::createFromTimestamp(strtotime($value->issued))->format('d-M-y');

           $temp_ventilator_param[$prefix.'open']  = $value->open;
           $temp_ventilator_param[$prefix.'high']  = $value->high;
           $temp_ventilator_param[$prefix.'mid']   = $value->mid;
           $temp_ventilator_param[$prefix.'low']   = $value->low;
           $temp_ventilator_param[$prefix.'close'] = $value->close;
           $property = $value->local_code.':'.$prefix . 'mid:'.$value->color_code. ':'.$value->chart_type;
           $ventilator_param[$property][] = $temp_ventilator_param;

           $map_param[$value->local_code] = $property;
        }


        $line_ventilator = array();
        foreach ($line_chart_data as $key => $value) {

           $temp_ventilator_param = array();
           $prefix = str_replace('_', '', $value->local_code);

           $temp_ventilator_param['date']         = Carbon::createFromTimestamp(strtotime($value->issued))->format('H:').'00';
           $temp_ventilator_param['tempDate']     = Carbon::createFromTimestamp(strtotime($value->issued))->format('d-M-y');

           if($prefix == 'itratesecound') {

            $temp_ventilator_param[$prefix]        = number_format($value->mid,1);
           } else {
            $temp_ventilator_param[$prefix]        = $value->mid;
           }

           $property = $value->local_code.':'.$prefix . ':'.$value->color_code. ':'.$value->chart_type;

           $ventilator_param[$property][] = $temp_ventilator_param;
           
           $map_param[$value->local_code] = $property;
          
        }

        $ventilator_param_results['parameter_data'] = $ventilator_param;
        $ventilator_param_results['map_param'] = $map_param;
        $ventilator_param_results['parameters'] = $parameters;

        return $ventilator_param_results;   
    }
}
