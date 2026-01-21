<?php

namespace App\Models\SummariesPrint;

use Illuminate\Database\Eloquent\Model;

class NicuProblemSummaryPrint extends Model
{
    protected $table = 'nicu_problem_summary_print';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['baby_mrn', 'baby_id', 'admission_id', 'summary_text', 'printed_date_time', 'printed_user_id', 'approved_user_ids', 'approved_date_time'];

	/**
     * Get the already print copy discharge summary details
     *
     * @param baby_id integer 
     * @param admission_id integer 
     * @return results array of objects 
     */
    public static function getPrintedContent($baby_id, $admission_id)
    {
    	$results = self::select('nicu_problem_summary_print.id', 'printed_date_time', 'name', 'approved_user_ids')
        ->leftjoin('users', 'users.id', 'printed_user_id')
        ->where('baby_id', $baby_id)
        ->where('admission_id', $admission_id)
        ->orderBy('printed_date_time', 'desc')
        ->get();
    	return $results;
    }

	/**
     * Get the already print copy discharge summary count
     *
     * @param baby_id integer 
     * @param admission_id integer 
     * @return results array count
     */
    public static function getPrintedContentCount($baby_id, $admission_id)
    {
    	$results = self::where('baby_id', $baby_id)->where('admission_id', $admission_id)->count();
    	return $results;
    }

	/**
     * Get the already print copy discharge summary content
     *
     * @param id integer 
     * @return results array of objects 
     */
    public static function getPrintedHtmlContent($id)
    {
    	$results = self::select('summary_text', 'approved_user_ids')->where('id', $id)->first();
    	return $results;
    }

}
