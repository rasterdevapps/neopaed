<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SummaryDictionary extends Model
{
   	protected $table = 'summary_statement';
	protected $primaryKey = 'id';
	public $timestamps  =  false;
	protected $gaurded = ['id'];
	protected $fillable = ['statements', 'word_split_up'];


	/**
	 * get suggestion for search 
	 *
	 * @param $current 
	 * @param $previous 
	 *
	 */
	public static function search_suggesion($current, $previous) 
	{

        $summary =  SummaryDictionary::whereJsonContains('word_split_up->orignal', $current)
                                      ->whereJsonContains('word_split_up->prev', $previous)
                                          ->get();
        $next = array();
        foreach ($summary as $summary_key => $summary_value) {

           $next[] = json_decode($summary_value->word_split_up)->next;
              
        }
        // $next = collect($next)->unique()->toArray();
        $next = collect($next)->toArray();

        return $next;

	}

}
