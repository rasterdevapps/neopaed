<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Surgeon extends Model
{

  protected $table = 'mas_surgons';
  protected $primaryKey = 'id';
  public $timestamps = false;
  protected $fillable = ['surgeon_name','status','UserAdded','DateAdded','UserDeleted','DateModified','IsDeleted'];


    public static function  ListData($order=array(), $limit=2, $search=array())
    {
        $results = DB::table('mas_surgons')
            ->select('*')->where('IsDeleted', '0')
            ->where(function ($query) use ($search)
           		 {
	                if ($search) {
	                    
	                    $query->where('surgeon_name', 'ilike', '%'.$search['search_txt'].'%');

	                }
                    if ($search['search_txt']=='Active' || $search['search_txt']=='Inactive') {
                       
                        $search['search_txt']=($search['search_txt']=='Active')? 1 : 0;

                    	$query->orwhere('status', $search['search_txt']);
                    }


          		 });

          if (isset($order['sortby']) && isset($order['sortorder'])) {          
            $results->orderby($order['sortby'], $order['sortorder']);
          }
          $result = $results->paginate($limit);
            
        return $result;
    }

   public static function getFieldvalue()
   {

   	 $results = DB::table('mas_surgons')
               ->where(['IsDeleted'=>'0', 'status'=>'0'])
               ->pluck('surgeon_name', 'id');
        return $results;
   }

}
