<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OpPrintPageConfig extends Model 
{
	protected $table = 'op_print_page_config';
	protected $primaryKey = 'id';
	public $timestamps  =  false;
	protected $fillable = ['user_id','ip_address','top_spacing','right_spacing','bottom_spacing','left_spacing','status','created_by','create_date_time','modified_by','modified_date_time','is_deleted','deleted_by'];

    public static function getUserBasedList()
    {
        $result = self::whereNotNull('user_id')->where('is_deleted', 0)->get();

        return $result;
    }
    public static function getIpBasedList()
    {
        $result = self::whereNotNull('ip_address')->where('is_deleted', 0)->get();

        return $result;
    }

    public static function getUserConfig($user_id)
    {
        $result = self::where('user_id', $user_id)
                    ->where('is_deleted', 0)
                    ->where('status', 1)
                    ->first();

        return $result;
    }

    public static function getIpConfig($ip_address)
    {
        $result = self::where('ip_address', $ip_address)
                    ->where('is_deleted', 0)
                    ->where('status', 1)
                    ->first();

        return $result;
    }

    public static function getUserConfigProperty($user_id)
    {
        $result = self::where('user_id', $user_id)
                    ->where('is_deleted', 0)
                    ->where('status', 1)
                    ->where(function($query){
                        $query->orWhere('top_spacing', '<>',0)
                              ->orWhere('right_spacing', '<>',0)
                              ->orWhere('bottom_spacing', '<>',0)
                              ->orWhere('left_spacing', '<>',0);
                    })
                    ->first();

        return $result;
    }

    public static function getIpConfigProperty($ip_address)
    {
        $result = self::where('ip_address', $ip_address)
                    ->where('is_deleted', 0)
                    ->where('status', 1)
                    ->where(function($query){
                        $query->orWhere('top_spacing', '<>',0)
                              ->orWhere('right_spacing', '<>',0)
                              ->orWhere('bottom_spacing', '<>',0)
                              ->orWhere('left_spacing', '<>',0);
                    })
                    ->first();

        return $result;
    }

    
}
