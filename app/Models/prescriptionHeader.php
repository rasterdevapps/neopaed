<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class prescriptionHeader extends Model
{

    /**
     * Define the table name
     *
     * @var $table
     */
    protected $table = 'prescription_hdr';

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
    protected $fillable = ['brand_name', 'pharmacological_name', 'dose', 
			  'dose_units_g', 'alt_dose', 'alt_dose_units_g', 'dose_units_kg', 'dose_units_time', 'quantity', 'quantity_units', 
			  'syringe_size', 'infusion_type', 'rate', 'volume', 'duration', 'duration_time', 
			  'fluid_name_one', 'fluid_name_two', 'fluid_vol_one', 'fluid_vol_two', 'iv_dextrose',
			  'iv_glucose', 'glucose_infusion_rate', 'glucose_concentration', 'oral_route', 'frequency', 'instruction', 'prescription_date', 
			  'start_date', 'review_date', 'stop', 'baby_id', 'admission_id', 'mother_id', 'day_id', 'working_weight',
			  'created_date', 'modified_date', 'created_user', 'modified_user', 'terminate', 'terminate_reason', 'drug_added', 'dose_feq_addition', 'batch_no', 'prescribed_by', 'prescription_type'];

    /**
      * This method to sent infusion to syringe
      * pump
      *
      */
    public static function getDrugToPump()
    {
    	return \DB::table('prescription_hdr')
            ->leftjoin('prescription_dtl', 'prescription_dtl.pres_hdr_id', 'prescription_hdr.id')
            ->leftjoin('mas_drugivfluid', 'mas_drugivfluid.id', 'prescription_hdr.pharmacological_name')
            ->select('prescription_hdr.*', 'prescription_dtl.*', 'prescription_dtl.id as dtl_id')
            ->where('generic_pharmacological_name', '<>', null)
	    	->where('is_send','1')
	    	->where('prescription_dtl.is_deleted', 0)
            ->where('prescription_hdr.oral_route', null)
            ->orderBy('prescription_dtl.id', 'asc')
	    	->first();
    }

    /**
      * This method to sent infusion to syringe
      * pump
      *
      */
    public static function getDrugToCancel()
    {
    	return \DB::table('prescription_hdr')
            ->leftjoin('prescription_dtl', 'prescription_dtl.pres_hdr_id', 'prescription_hdr.id')
            ->select('prescription_hdr.*', 'prescription_dtl.*', 'prescription_dtl.id as dtl_id')
	    	->where('is_send','3')
	    	->where('is_cancel', false)
	    	->where('is_deleted', 0)
            ->where('oral_route', null)
	    	->orderBy('prescription_dtl.id', 'asc')
	    	->first();
    }

    /**
      * This method to complete infusion to syringe
      * pump
      *
      */
    public static function getDrugToComplete()
    {
        return \DB::table('prescription_hdr')
            ->leftjoin('prescription_dtl', 'prescription_dtl.pres_hdr_id', 'prescription_hdr.id')
            ->select('prescription_hdr.*', 'prescription_dtl.*', 'prescription_dtl.id as dtl_id')
            ->where('is_send','21')
            ->where('is_cancel', false)
            ->where('is_deleted', 0)
            ->where('oral_route', null)
            ->orderBy('prescription_dtl.id', 'asc')
            ->first();
    }
}
