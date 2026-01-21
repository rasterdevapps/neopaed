<?php namespace App\Http\Controllers\Masters;

use Carbon\Carbon;
use App\User;
use App\Models\Neonatal;
use App\Models\Settings\Settings;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\MotherRequest;
use App\Models\Settings\DeleteApproval;
use Illuminate\Http\Request;

class MultiplePregnancyCommonController extends Controller 
{
    /**
     *This variable for commen multiple pregnancy
     *
     *@var $common_mp_fields;
     */
     public $common_mp_fields;

    /**
     *This variable for commen multiple pregnancy
     *
     *@var $incetance;
     */
     public $incetance;
     
     /**
     *This variable for commen multiple pregnancy
     *
     *@var $inc;
     */
     public $inc;

     /**
     *This variable for commen multiple pregnancy
     *
     *@var $common_values;
     */
     public $common_values;


    /**
     * constructer
     *
     * @param $feld_id type integer
     */
     public function __construct($feld_id)
     {
        $this->inc = $feld_id;   
        $this->common_mp_fields['Neonatal'] = array('TestDate','TEST_TIME','TEST_MINS','TEST_AM','MotherName','MotherLastName',
                                   'MotherInitial','MotherTitle','PartnerTitle','PartnerInitial','Email','Address1',
                                   'Address2','Address3','Address4','Mobile','MotherDOB','City','State','Country',
                                   'PartnerName','PartnerContact','PartnerDOB','PartnerOccupation','LandLine','Occupation',
                                   'G_Value','P_Value','L_Value','A_Value','G_sequence','MMrNo','UserAdded','DateAdded',
                                   'DateModified','UserDeleted','IsDeleted','MothercYear','MotherEmail','PartnerMobile',
                                   'PartnercYear','PartnerLastName','Postcode','Address5','FatherAddress1','FatherAddress2',
                                   'MotherBloodGroup','FatherSpokenLanguages','MotherSpokenLanguages','Conception','LMP','EDDbyUSG',
                                   'EDDbyDates','MotherBloodGroup','HIV','HepatitisB','VDRL','Booked','Booking','Supervised',
                                   'PlaceofSupervision','MultiplePregnancy','PregnancyComplications','AntenatalSteroids',
                                   'LastDoseDeliveryInterval','TypeofAnesthesia','TypeofART','EmbryoTransfer','PlaceofART');
    }

    public function getFeilds()
    {
        return $this->common_mp_fields[$this->inc] ;
    }
   
   
   
  
}
