<?php

namespace App\Models\Ward;

use Illuminate\Database\Eloquent\Model;

class PatientIpList extends Model
{
   protected   $table       = 'patient_ip_visit';
   protected   $primaryKey  = 'id';
   public      $timestamps  =  false;
   protected   $fillable    = ['ip_number', 'patientid', 'status', 'referral_type_id', 'referral_id',
                               'primary_consultant_id', 'secondary_consultant_id', 'departmentid', 'guardian_name', 
                               'guardian_mobile_number', 'desired_room_type', 'desired_room_type_id', 'gender_based',
                               'insurance_id', 'policy_number', 'valid_unit', 'insurance_notes', 'insurance_file_path', 
                               'claim_for_self', 'relationshipid', 'corporateid', 'employee_name', 'employee_code', 
                               'medicol_legal_case', 'fir_number', 'fir_copy_file_path', 'accident_case', 
                               'createdby', 'created_date', 'modified_by', 'modified_date'];

}
