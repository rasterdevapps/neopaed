<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class CBCLquestionsMaster extends Model
{
    /**
     * Define the table name
     *
     * @var $table
     */
    protected $table = 'mas_cbcl_questions';

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
    protected $fillable   = ['question', 'category', 'status', 'created_user_id', 'created_date_time', 'modified_user_id', 'modified_date_time', 'is_deleted', 'deleted_user_id', 'deleted_date_time', 'describe'];
            

    public static function  list()
    {

        $results = self:: select('*')
        ->where('is_deleted', 0)
        ->orderBy('id', 'asc')
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
        $results = self::where('is_deleted', 0)->where('status', 1)->orderBy('id', 'asc')->get();
        return $results;     
    }   
}
