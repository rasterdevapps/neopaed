<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class prescriptionDetails extends Model
{

    /**
     * Define the table name
     *
     * @var $table
     */
    protected $table = 'prescription_dtl';

    /**
     * Define the table primary key 
     *
     * @var $primaryKey
     */
    protected $primaryKey = 'id';

    /**
     * Define the table timestamps
     *
     * @var $timestamps
     */
    public $timestamps  =  false;

    /**
     * Define the table fillable columns 
     *
     * @var $fillable
     */
    protected $fillable = ['pres_hdr_id', 'day', 'prescription_id', 'is_send', 'order_status', 'is_deleted', 'is_cancel', 'started_date', 'stopped_date',  'created_date', 'modified_date', 'created_user', 'modified_user', 'verify_user_id', 'verify_date' , 'event_time', 'cancel_datetime', 'cancel_reason', 'stop_reason', 'total_infused', 'started_user', 'stopped_user', 'cancelled_user', 'modified_started_date', 'modified_started_user', 'modified_stopped_date', 'modified_stop_reason', 'modified_total_infused', 'modified_stopped_user', 'modified_cancel_datetime', 'modified_cancel_reason', 'modified_cancelled_user', 'order_id', 'original_started_date', 'original_stopped_date', 'original_cancel_date', 'order_pump_type', 'order_pump_device_id'];

    public static function getGivenPrescription($hdr_id)
    {
        $result = \DB::table('prescription_dtl')
        ->where('pres_hdr_id', $hdr_id)
        ->where('order_status', '<>', 'RS')
        ->where('order_status', '<>', 'EP')
        ->where('is_send', '<>', 20)
        ->where('is_send', '<>', 21)
        ->where('is_send', '<>', 3)
        ->where('is_send', '<>', 8)
        ->where('is_send', '<>', 10)
        ->where('is_send', '<>', 11);
        $event_time = $result->min('event_time');
        $result = $result->where('event_time', $event_time)->first();

        return isset($result->id) ? $result->id : null;
    }

    public static function overInfusionDrugList($admission_id)
    {
        return \DB::table('prescription_dtl')
            ->select('prescription_dtl.prescription_id', 'volume', 'syringe_size', \DB::raw('MAX(CAST(infused AS FLOAT)) as max'))
            ->addSelect(\DB::raw('(CASE WHEN MAX(CAST(infused AS FLOAT)) > CAST(volume AS FLOAT) THEN \'active\' ELSE \'inactive\' END) AS infusion_status'))
            ->addSelect(\DB::raw('(CASE WHEN MAX(CAST(infused AS FLOAT)) > CAST(syringe_size AS FLOAT) THEN \'active\' ELSE \'inactive\' END) AS infusion_status1'))
            ->leftjoin('prescription_hdr', 'prescription_dtl.pres_hdr_id', 'prescription_hdr.id')
            ->leftjoin('prescription', 'prescription_dtl.prescription_id', 'prescription.prescription_id')
            ->where('admission_id', $admission_id)
            ->where('is_send', 5)
            ->groupBy('prescription_dtl.prescription_id', 'volume', 'syringe_size')
            ->get();
    }

}
