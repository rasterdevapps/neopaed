<?php

namespace App\Http\Controllers\Reports;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AnnualReportsDateController extends Controller
{

   public $startDate;
   public $endDate = '' ; 	
   
   public function __construct($startDate, $endDate)
   {

   	  $this->startDate  = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($startDate)));
   	  $this->endDate    = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($endDate)));

    
   }

   public function differentsIn() 
   {

   	  $days = $this->differentsIndays();
      
      if ($days > 31) { 

          return "Y";

      } elseif ($days >= 28  && $days <= 31) {

       	   return 'M';

      } elseif ($days < 29 && ($days/7) > 1) {

      	   return 'W';

      } else {

      	    return 'D';
      }
          
   }

   public function differentsIndays()
   {

   	   return $this->startDate->diffInDays($this->endDate);
   }

   public function getMonth($flage = true, $format='M')
   {

      return date($format, strtotime($this->startDate));

   }

   

}
