<?php

namespace App\Models\Nurse;

use Illuminate\Database\Eloquent\Model;

class LabImportedTemporary extends Model
{
    protected $table = 'lab_temporary_data';
    protected $primaryKey = 'Id';
    public $timestamps  =  false;
    protected $fillable = ['resourceType', 'id', 'text', 'identifier', 'status', 'code', 'gender', 'subject', 'effectivePeriod', 'issued', 'performer', 'valueQuantity', 'interpretation', 'referenceRange'];


	/**
	 * Method to get all data's in the table
	 */
    public static function getList($id) {
    	return \DB::table('lab_temporary_data')
    				->where('id',$id)
    				->get();
    }
}
