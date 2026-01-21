<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class DasiiquestionsMaster extends Model
{
    /**
     * Define the table name
     *
     * @var $table
     */
    protected $table = 'mas_dasii_questions';

    /**
     * Define the table primary key
     *
     * @var $primary key
     */
    protected $primaryKey = 'id';

    /**
     * Define the table timestamps
     *
     * @var $timestamps
     */
    public $timestamps    = false;

    /**
     * Define the table fillable columns
     *
     * @var $fillable
     */
    protected $fillable   = ['question_number', 'question', 'question_type', 'fiftieth_percentile', 'third_percentile', 'ninety_seventh_percentile', 'content_cluster', 'status', 'created_user', 'created_date', 'modified_user', 'modified_date', 'is_deleted', 'deleted_user', 'deleted_date_time'];
            

    public static function  list()
    {

        $results    = self:: select('*')
        ->where('is_deleted', 0)
        ->orderBy('id', 'desc')
        ->get();

        return $results;
    }

    public static function GetTotal() 
    {
        $results = self::where('is_deleted', 0)->get();    
        return count($results);     
    } 

    public static function getQuestions() 
    {
        $results = self::where('is_deleted', 0)->where('status', 1)->orderBy('question_number', 'asc')->get();
        return $results;     
    }   
}
