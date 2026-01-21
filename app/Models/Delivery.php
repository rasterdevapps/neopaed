<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Delivery extends Model 
{
	protected $table = 'delivery_history';
	protected $primaryKey = 'MotherId';
	public $timestamps  =  false;
	protected $fillable = ['MotherId','Year','Place','Delivery','Complications','Gender','GA','BW','Health','DateAdded','details'];

   /**
    * Methods to get the delivery details based on motherid
    *
    * @param $mother_id
    *
    * @return delivery history in array of objects 
    */
    public static function GetList($mother_id)
    {
    	return \DB::table('delivery_history')
    	           ->where('MotherId', $mother_id)
    	           ->get();

    }

}
