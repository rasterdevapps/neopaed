<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class MchatquestionsfollowupMaster extends Model
{
    /**
     * Define the table name
     *
     * @var $table
     */
    protected $table = 'm_chat_r_followup_questions_master';

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
    protected $fillable   = ['question', 'status', 'stage', 'created_by', 'created_time', 'modified_by', 'modified_time', 'is_deleted', 'deleted_by', 'correct_answer'];
            

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
        $results = self::where('is_deleted', 0)->where('status', 1)->orderBy('id', 'asc')->get()
        ->groupBy('id')->map(function ($item, $key)
        {
            return $item[0];
        });   
        return $results;     
    }   
}
