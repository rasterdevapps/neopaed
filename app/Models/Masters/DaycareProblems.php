<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class DaycareProblems extends Model
{
    protected $table = 'mas_daycareproblems';
	protected $primaryKey = 'problem_id';
	public $timestamps  =  false;
	protected $fillable = ['problem_id','problem_name','problem_description','problem_fields','problem_status','problem_layout','IsDeleted','UserAdded','DateAdded','UserDeleted','UserModified','DateModified'];

   

    public function get_record($problem_id) 
    {

    	return \DB::table('mas_daycareproblems')
    	        ->where('problem_id', $problem_id)
    	        ->first();

    }

    public function GetList($page=1, $limit=50, $condition, $order=array()) 
    {

        $limitstart = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
        $limitend   = $limit;
        $search_txt = isset($condition) ? $condition : '';
        $status     = '';

        if (strtolower($search_txt) == 'inactive') {

           $status = 0;

        } elseif (strtolower($search_txt) == 'active') {

           $status = 1;

        }

    	$results =  \DB::table('mas_daycareproblems')
    	        ->where(['IsDeleted'=>'0'])
                ->where(function ($query) use ($search_txt, $status) {
                    
                    if ($search_txt != '') {
                     $query->where('problem_name', 'ilike', '%'.trim($search_txt).'%');
                    }

                    if ($status != '') {
                      $query->orwhere('problem_status', $status);
                    }

                });

        if (isset($order['sortby']) && isset($order['sortorder'])) {
            $results->orderBy($order['sortby'], $order['sortorder']);
        }

        $result['total'] = $results->get()->count();  
        $result['result'] = $results->limit($limitend)->offset($limitstart)->get();

        return $result;

    }
    public function GetTotal() 
    {
        return \DB::table('mas_daycareproblems')
                ->where('IsDeleted', '0')
                ->get();
    }

   public function get_problem_list()
   {
        return \DB::table('mas_daycareproblems')
                ->where('IsDeleted', '0')
                ->pluck('problem_name', 'problem_id')->toArray();
   }

}
