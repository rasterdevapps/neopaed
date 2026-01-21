<?php

namespace App\Http\Controllers\Adtmessage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdtMessagePropertyController extends Controller 
{
  /**
   * @property syringe_pump_admission
   */
   public $syringe_pump_admission = 'A01';

  /**
   * @property syringe_pump_transfer
   */
   public $syringe_pump_transfer  = 'A02';

  /**
   * @property syringe_pump_discharge
   */
   public $syringe_pump_discharge = 'A03';
   
  /**
   * @property patient_details_update
   */
   public $patient_details_update = 'A08';

   /**
    * @property syringe_new_order
    */
    public $syringe_new_order      = 'RE'; 

    /**
    * @property syringe_change_order
    */
    public $syringe_change_order   = 'XO';

    /**
    * @property syringe_hold_order
    */
    public $syringe_hold_order      = 'HD';
 
    /**
    * @property syringe_release_order
    */
    public $syringe_release_order    = 'RL';

    /**
    * @property syringe_discontinue_order
    */
    public $syringe_discontinue_order = 'DC';

     /**
    * @property syringe_finished_order
    */
    public $syringe_finish_order	  = 'FN';


}







