<?php
namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RespiratoryIndication extends Model
{
    /**
     * This method to get variable 
     * @var  $table string
     */
    protected $table = 'mas_respiratoryindication';

    /**
     * This method to get variable 
     * @var  $primaryKey primary key id
     */
    protected $primaryKey = 'id';

    /**
     * This method to get variable 
     * @var  $timestamps timestamp boolean
     */
    public $timestamps = false;

    /**
     * This method to get variable 
     * @var  $fillable array of object
     */
    protected $fillable = ['respiratory_name','respiratory_status','UserAdded','DateAdded','UserDeleted','DateModified','IsDeleted'];

    /**
     * This method to get variable 
     *  
     * @param $order type  array
     * @param $limit type array
     * @param $search type array
     * @return object type array 
     */
    public static function ListData()
    {
        $results = DB::table('mas_respiratoryindication')
            ->select('*')->where('IsDeleted', '0')
            ->get();    
      return $results;   
    }

    public static function list($page = 1, $limit = 50, $condition, $order = array(), $slug = '')
    {
        $limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend   = $limit;
        $search_txt =  isset($condition) ? trim($condition) : '';
        
        $results    = DB::table('mas_respiratoryindication')
                        ->select('*')
                        ->where('IsDeleted', '0')
                        ->where(function ($query) use ($search_txt) {
                            if ($search_txt) {
                                $query->where('respiratory_name', 'ilike', '%'.$search_txt.'%');
                            }
                        });

        if (isset($order['sortby']) && isset($order['sortorder'])) {
            $results->orderBy($order['sortby'], $order['sortorder']);  
        }

        if ($slug) {
            $result['total']  = $results->get()->count();  
            $result['result'] = $results->limit($limitend)->offset($limitstart)->get(); 
        } else {
            $result = $results->limit($limitend)->offset($limitstart)->get();           
        }
          
        return $result;
    }
    public static function getFieldvalue()
    {

     	 $results = DB::table('mas_respiratoryindication')
                 ->where(['IsDeleted'=>'0'])
                 ->pluck('respiratory_name', 'id');
          return $results;
    }
    /**
     * Get total count of admission mode
     *
     *@return antibiotic list in array
     */  
     public static function get_lists()
     {
       $results = DB::table('mas_respiratoryindication')
                  ->get()->count();    
       return $results;
     }
    /**
     * Get the respiratory indication name by id
     *
     * @param $id is integer
     * 
     * @return array of object
     */
    public static function getName($id)
    {
        $results = DB::table('mas_respiratoryindication')
            ->select('respiratory_name')
            ->where('id', $id)
            ->first();      
        return $results;
    }
}
