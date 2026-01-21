<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class IpNumber extends Model
{
    
    protected $table = 'ip_numbers';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable =['baby_id','ip_number','status','DateAdded', 'DateModified','AdmissionId'];


    public static function getCurrent_ip($baby_id='', $admission_id=0)
    {
        
    	$result = DB::table('ip_numbers')
    	            ->where(['baby_id'=>$baby_id,'status'=>1]);
                  if($admission_id != 0) {
                     $result = $result->where('AdmissionId',$admission_id);
                   }
           $result = $result->orderby('id', 'desc')
    	            ->first();

        return $result;            
        
    }

    public static function setChangestatus($id='')
    {

        return DB::table('ip_numbers')
                ->where(['baby_id'=>$id, 'status'=>1])
                ->update(['status'=>0]);

    }

    public static function get_all_ip($baby_id='', $admission_id=0)
    {
        
        $result = DB::table('ip_numbers')
                    ->where(['baby_id'=>$baby_id,'status'=>1]);
                  if($admission_id != 0) {
                     $result = $result->where('AdmissionId',$admission_id);
                   }
           $result = $result->orderby('id', 'desc')
                    ->get();

        return $result;
    }


}
