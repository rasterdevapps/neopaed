<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class BayleyScaleSubMaster extends Model
{
   /**
    * Define the table name
    *
    *@var $table
    */
    protected $table = 'mas_bayley_scale_sub';

    /**
    * Define the table primary key 
    *
    *@var $primaryKey
    */
    protected $primaryKey = 'id';

    /**
    * Define the table timestamps
    *
    *@var $timestamps
    */
    public    $timestamps  =  false;

    /**
    * Define the table fillable columns 
    *
    *@var $fillable
    */
    protected $fillable = ['title', 'score', 'type', 'bayley_id'];

    public static function getList($id)
    {

        $results = self::select('*')
        ->where('bayley_id', $id)
        ->orderBy('id', 'asc')
        ->get();

        return $results;
    }

}
