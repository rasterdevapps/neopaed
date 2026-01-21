<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DashboardEvent extends Model
{
    protected $table = 'dashboard_events';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['id', 'mrn', 'event', 'snomed_code', 'event_status', 'event_date_time', 'created_date_time', 'event_code', 'nurse_id', 'request_from_imot'];

    public static function getBabyInfo($mrn)
    {
        $results = \DB::table('baby')->selectRaw('DISTINCT ON ("baby"."BabyId") "BabyId"')
                    ->addSelect('baby.BabyName', 'baby.BMrNo' , 'baby.DOB', 'baby.Gestation', 'baby.Sex', 'ip_numbers.ip_number')
                    ->join('ip_numbers', 'ip_numbers.baby_id', '=', 'baby.BabyId')
                    ->where('baby.BMrNo', $mrn)
                    ->first();

        return $results;
    }

    public static function getEventdetails($mrn, $option = '')
    {
        if ($option == 'running_events') {
            
            $results = \DB::select("SELECT distinct on(event_code) event_code, event, event_date_time AS start, next_ts AS stop FROM ( SELECT *, lead(event_date_time) OVER (PARTITION BY event_code ORDER BY event_date_time) AS next_ts FROM dashboard_events WHERE event_status IN ('START', 'STOP') and mrn = '".$mrn."' order by event_date_time desc ) AS ts_pairs WHERE event_status = 'START' and next_ts IS NULL");
        }
        else{

            $results = \DB::select("SELECT distinct on(event_code) event_code, event, event_date_time AS start, next_ts AS stop FROM ( SELECT *, lead(event_date_time) OVER (PARTITION BY event_code ORDER BY event_date_time) AS next_ts FROM dashboard_events WHERE event_status IN ('START', 'STOP') and mrn = '".$mrn."' order by event_date_time desc ) AS ts_pairs WHERE event_status = 'START'");
        }
            
        return $results;
    }

    public static function getEvents()
    {
        $results = \DB::table('mas_event_details')->where('status', true)->whereNotNull('event_code')->where('is_deleted', false)->orderBy('sort_order', 'asc')->get();
        
        return $results;
    }

    public static function checkEventStatus($mrn, $event_name, $event_status)
    {
        $results = \DB::table('dashboard_events')->where('mrn', $mrn)->where('event', $event_name)->where('event_status', $event_status)->first();
        return $results;
    }
    public static function getBedBasedEvent($bed_id)
    {
        $results = \DB::table('bed')->select('bed.event_code', 'bed.event_status', 'bed.event_time', 'event_name')
                    ->join('mas_event_details', 'bed.event_code', '=', 'mas_event_details.event_code')
                    ->where('bed.id', $bed_id)->first();
        return $results;
    }

    public static function getNurseList(){
        $results = \DB::table('mas_nures')->select('id', 'name', 'register_no')
                    ->where('status', 'Active')
                    ->where('IsDeleted', false)
                    ->orderBy('id', 'ASC')
                    ->get();
        return $results;
    }

    /**
     * This will get the list of users who are using nurse sheet.
     *
     * @return array of object. 
     */
    public static function GetNursesEventUsage($from_date, $to_date) {
        $results = self::select(\DB::raw('count(*)'), 'nurse_id')
            ->whereNotNull('nurse_id')
            ->where('event_status', 'STOP');
            if (!is_null($from_date) && !is_null($to_date)) {
                $results = $results->whereBetween('event_date_time', [$from_date, $to_date]);
            }
        $results = $results->groupBy('nurse_id')->get()->pluck('count', 'nurse_id');

        return $results;
    } 

    public static function getEventCount($mrn, $from_date = null, $to_date = null)
    {
        $results = self::select(\DB::raw('count(*)'), 'event', 'bg_color')
                    ->leftjoin('mas_event_details', 'dashboard_events.event_code', 'mas_event_details.event_code')
                    ->where('mrn', $mrn)
                    ->where('event_status', 'STOP');
        if (!is_null($from_date) && !is_null($to_date)) {
            $results = $results->whereBetween('event_date_time', [$from_date, $to_date]);
        }
        $results = $results->orderBy('mas_event_details.id')->groupBy('event', 'bg_color', 'mas_event_details.id')->get()->toArray();

        return $results;
    }

}
