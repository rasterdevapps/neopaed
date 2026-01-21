<?php

namespace App\Models\Fhir;

use Illuminate\Database\Eloquent\Model;

class ObservationRange extends Model
{
    protected $table = 'observations_range';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['baby_id', 'loinc_local_map_id', 'range', 'result_date_time', 'percentage'];

    /**
     * Method to get data for chart
     *
     */
    public static function getData($baby_id, $from_date, $to_date)
    {
        $results = self::select('range', 'result_date_time', 'percentage')
                        ->selectRaw('local_description|| \' (\' ||unit|| \')\' as local_description')
                        ->leftjoin('local_code_group', 'loinc_local_map_id', 'local_code_group.id')
                        ->where('baby_id', $baby_id)
                        ->where(function ($query) use ($from_date, $to_date) {
                            if ($from_date != '' && $to_date != '') {
                                $query->whereBetween('result_date_time', [$from_date, $to_date]);
                            }
                        })
                        ->orderBy('local_code_group.id', 'desc')
                        ->get();
        return $results;
    }

    /**
     * Method to get data for hour wise table
     *
     */
    public static function getHourWiseData($baby_id, $from_date, $to_date)
    {
        $results = self::select('range', 'percentage')
                        ->selectRaw('local_description|| \' (\' ||unit|| \')\' as local_description')
                        ->selectRaw("TO_CHAR(result_date_time,'DD-MM-YYYY HH24:00') as temp_result_date_time")
                        ->leftjoin('local_code_group', 'loinc_local_map_id', 'local_code_group.id')
                        ->where('baby_id', $baby_id)
                        ->where(function ($query) use ($from_date, $to_date) {
                            if ($from_date != '' && $to_date != '') {
                                $query->whereBetween('result_date_time', [$from_date, $to_date]);
                            }
                        })
                        ->get();
        return $results;
    }

}
