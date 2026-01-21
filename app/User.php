<?php 
namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract 
{

	use Authenticatable, CanResetPassword,Notifiable;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name_prefix','name', 'email', 'password','RoleId','isMaster', 'status', 'signature', 'initial', 'short_code', 'mas_id', 'summary_approval'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];
	
	public static function ListUsers($user_id, $role_id, $page=1, $limit=50, $condition = array(), $order=array(), $slug = '')
	{
		//$results = DB::table('users')->join('user_role', 'user_role.RoleId', '=', 'users.RoleId')->select('user_role.RoleName', 'users.*');
/*		if($role_id!=1){
			$results = $results->where('RoleId','!=',$role_id)->where('RoleId','!=',1);
		} */
		//$result =	$results->where('users.id', '!=', $user_id)
            //->get();	
$limitstart    = (empty($page) || $page == 1) ? 0 : (($page-1)*$limit);
		$limitend      = $limit;
		$search_txt    = isset($condition['search_txt']) ? trim($condition['search_txt']) : '';
        $checkdate     = '';

        if (strpos($search_txt, '-') > 0) {
            $get_date      = strtotime($search_txt);
            $checkdate     = (!empty($get_date)) ? date('\'Y-m-d\'', $get_date):'';
            $search_txt    = '';
        }
        
		$results = DB::table('users')
						->join('user_role', 'user_role.RoleId', '=', 'users.RoleId')
						->select('user_role.RoleName', 'users.*')
						->where(function ($query) use ($search_txt, $user_id, $role_id) {
							if ($search_txt) {
								$query->whereRaw('LOWER("name") like '."'%".strtolower($search_txt)."%'");
								$query->orWhereRaw('LOWER("email") like '."'%".strtolower($search_txt)."%'");
								$query->orWhereRaw('LOWER("user_role"."RoleName") like '."'%".strtolower($search_txt)."%'");
							}
							// if($role_id!=1) {
							// 	$query->where('RoleId','!=',$role_id)->where('RoleId','!=',1);
							// }
							if($user_id) {
								$query->where('users.id', '<>', $user_id);
							}
						});

		if (isset($order['sortby']) && isset($order['sortorder'])) {
			$results->orderBy($order['sortby'], $order['sortorder']);  
		}
		if ($slug) {
			return $results;
		} else {
			$result = $results->limit($limitend)->offset($limitstart)->get();           
		}
		return $result;			
	}

	public static function getUsers($user_id)
	{
		$results = DB::table('users')
			->where('id', '=', $user_id)
            ->get();	
		return $results;		
	}
	public static  function CheckRole($role_id, $module, $permission)
	{
		
		$results = DB::table('user_role')->where('RoleId', '=', $role_id)->get();
		$permissions = unserialize($results[0]->Permissions);	
		$read_permission = array_keys($permissions['read_permission']);
		$write_permission = array_keys($permissions['write_permission']);	
		if (isset($permissions['delete_permission'])) {
			$delete_permission = array_keys($permissions['delete_permission']);	
		}
		if ($permission=='read' && isset($read_permission) && in_array($module, $read_permission)) {
			return true;
		} elseif ($permission=='write' && isset($write_permission) && in_array($module, $write_permission)) {
			return true;
		}  elseif ($permission=='delete' && isset($delete_permission) && in_array($module, $delete_permission)) {
			return true;
		} 
			return false;
	}
	public static function getRoles($role_id)
	{
		if ($role_id == 0) {
			return array(); 
		} else {
			$results = DB::table('user_role')->where('RoleId', '=', $role_id)
			 ->get();
			$temp = $results[0]->Permissions;
			$permissions = unserialize($temp);	
			return $permissions;	
		}
	}

	public static function getSpecialpermissions($user_id)
	{
		 $results = DB::table("special_permissions")
		             ->where("user_id", "=", $user_id)
		             ->first();

          if (isset($results->permissions)) {
          	\Session::put('specialPermissions', json_decode($results->permissions));  
          } else {
             \Session::put('specialPermissions', array());
          }

       return true;
	}

	public static function getLicenceKey() 
	{
		$licence = \DB::table('site_settings')
		               ->select('licence_key')
		               ->first();
        

        if (isset($licence->licence_key) && !empty($licence->licence_key)) {
        	$licence_key = \SiteHelpers::decrypt_id($licence->licence_key);
            $licence_key = explode('-', $licence_key);

            return $licence_key[2];

        } else {
        	return null;
        }
        
	}

	public static function getUserId($mail) {
		return DB::table('users')->select('id')->where('email', $mail)->first();
	}


	public static function getDoctor($id) {
		$results = DB::table('mas_doctors')
					->select('userId','type','Name')
					->where('mas_doctors.userId', $id)
					->get();
		return $results;
	}

	public static function getNurse() {
		$results = DB::table('mas_nures')
		->select('id')
		->selectRaw('name|| \' (\' ||register_no|| \') \'as name')
		->where('status', 'Active')
		->where('IsDeleted', 0)
		->pluck('name', 'id');
		return $results;
	}

  	/**
     * FETCH NON DELETED DATA RECORD COUNT
     *
     * @return integer
     */	
	public static function GetTotal($user_id, $role_id) 
    {
		$result = DB::table('users')
						->join('user_role', 'user_role.RoleId', '=', 'users.RoleId')
						->where(function ($query) use ($user_id, $role_id) {
							// if($role_id!=1) {
							// 	$query->where('RoleId','!=',$role_id)->where('RoleId','!=',1);
							// }
							if($user_id) {
								$query->where('users.id', '!=', $user_id);
							}
						})->get()->count();
		return $result;
	}
}
