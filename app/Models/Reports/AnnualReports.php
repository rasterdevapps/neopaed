<?php

namespace App\Models\Reports;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;



class AnnualReports extends Model
{

   /**
   * This method for get the inborn baby lists
   *
   *@param  $start  type date 
   *@param  $end    type date
   *@return Inborn baby Lists
   */
	public function inbornbabyList($start, $end)
  {
        return \DB::table('baby')
                ->join('neonatal_proforma', 'neonatal_proforma.BabyId', '=', 'baby.BabyId') 
                ->whereBetween('DOB', array(date('Y-m-d', strtotime($start)),date('Y-m-d', strtotime($end))))
                ->where('BirthStatus', 'Inborn')
                ->where('baby.IsDeleted', 0)
                ->where('neonatal_proforma.IsDeleted', 0)
                ->get();

	}
  /**
   * This method for get the inborn baby lists
   *
   *@param  $start  type date 
   *@param  $end    type date
   *@return Inborn Nicu admission baby Lists
   */
  public function inbornNicubabylist($start, $end)
  {

      return \DB::table('baby')
                ->join('nicu_admission', 'nicu_admission.BabyId', '=', 'baby.BabyId') 
                ->whereBetween('DOB', array(date('Y-m-d', strtotime($start)),date('Y-m-d', strtotime($end))))
                ->where('baby.BirthStatus', 'Inborn')
                ->where('baby.IsDeleted', 0)
                ->where('nicu_admission.IsDeleted', 0)
                ->get();

  }
  /**
   * This method for get the inborn baby lists
   *
   *@param  $start  type date 
   *@param  $end    type date
   *@return Inborn and outborn Nicu baby Lists
   */
  public function inoutbornNicubabylist($start, $end)
  {
    return \DB::table('baby')
                ->join('nicu_admission', 'nicu_admission.BabyId', '=', 'baby.BabyId') 
                ->whereBetween('AdmissionDate', array(date('Y-m-d', strtotime($start)), date('Y-m-d', strtotime($end))))
                ->where('baby.IsDeleted', 0)
                ->where('nicu_admission.IsDeleted', 0)
                ->get();
  }

  /**
   * This method for get the inborn baby lists
   *
   *@param  $start  type date 
   *@param  $end    type date
   *@return Inborn and outborn daycare baby Lists
   */

  public function daycareList($start, $end)
  {

      return \DB::table('baby')
                ->join('daycare', 'daycare.BabyId', '=', 'baby.BabyId') 
                ->whereBetween('DOB', array(date('Y-m-d', strtotime($start)), date('Y-m-d', strtotime($end))))
                ->where('baby.IsDeleted', 0)
                ->where('daycare.IsDeleted', 0)
                ->get();

  }

  /**
   * This method for get the inborn baby lists
   *
   *@param  $start  type date 
   *@param  $end    type date
   *@return Inborn and outborn Nicu live discharge  baby Lists
   */

  public function nicuListwithoutdied($start, $end)
  {

     return \DB::table('baby') 
                ->join('nicu_admission', 'nicu_admission.BabyId', '=', 'baby.BabyId') 
                ->whereBetween('DOB', array(date('Y-m-d', strtotime($start)), date('Y-m-d', strtotime($end))))
                ->where(['baby.IsDeleted'=>0, 'nicu_admission.IsDeleted'=>0])
                ->get();
  }

  /**
   * This method for get the inborn baby lists
   *
   *@param  $start  type date 
   *@param  $end    type date
   *@return Inborn and outborn died nicu and discharge summary  baby Lists
   */

  public function getDiedbabylist($start, $end)
  {

    return \DB::table('baby')
                ->select('baby.Gestation', 'baby.BirthWeight', 'discharge_summary.Problems')
                ->join('nicu_admission', 'nicu_admission.BabyId', '=', 'baby.BabyId') 
                ->join('discharge_summary', 'discharge_summary.baby_id', '=', 'baby.BabyId')
                ->whereBetween('DOB', array(date('Y-m-d', strtotime($start)), date('Y-m-d', strtotime($end))))
                ->where(['baby.IsDeleted'=>0, 'nicu_admission.IsDeleted'=>0])
                ->whereIn('nicu_admission.status', ['Died','Died (OCNR)'])
                ->get();
  }

  /**
   * This method for get the inborn baby lists
   *
   *@param  $start  type date 
   *@param  $end    type date
   *@return Inborn and outborn daycare  baby Lists
   */

  public function getProceduredaycarelist($start, $end)
  {
        return \DB::table('baby')
                ->select('daycare.* as dc', 'daycare_questions.* as dq', 'baby.* as b')
                ->join('daycare', 'daycare.BabyId', '=', 'baby.BabyId') 
                ->leftjoin('daycare_questions', 'daycare_questions.DayId', '=', 'daycare.DayId')
                ->whereBetween('DOB', array(date('Y-m-d', strtotime($start)), date('Y-m-d', strtotime($end))))
                ->where('baby.IsDeleted', 0)
                ->where('daycare.IsDeleted', 0)
                ->get();
  }
  
  /**
   * This method for get the inborn baby lists
   *
   *@param  $start  type date 
   *@param  $end    type date
   *@return Inborn and outborn nicu admission Lists
   */

  public function NicuadmissionList($start, $end)
  {

       return \DB::table('baby')
                ->join('nicu_admission', 'nicu_admission.BabyId', '=', 'baby.BabyId') 
                ->whereBetween('AdmissionDate', array(date('Y-m-d', strtotime($start)), date('Y-m-d', strtotime($end))))
                ->where('baby.IsDeleted', 0)
                ->where('nicu_admission.IsDeleted', 0)
                ->get();

  }


}
