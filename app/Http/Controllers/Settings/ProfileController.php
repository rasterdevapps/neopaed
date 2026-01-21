<?php  namespace App\Http\Controllers\Settings;

use Illuminate\Html\HtmlFacade  as HTML;
use App\User;
use Illuminate\Contracts\Auth\Guard;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use App\Models\Masters\DoctorMaster;
use App\Models\Masters\NurseMaster;
use File;

class ProfileController extends Controller 
{

	/**
	 * PROFILE CONTROLLER IS USED TO DISPLAY THE CURRENT LOGGED IN USER.
	 *
	 * @return void
	 */
	public function __construct(Guard $auth)
	{
		$this->middleware('auth');
		$this->auth = $auth;
        $this->time_zone = env('TIME_ZONE');
	}
	/**
	 * DISPLAY THE PROFILE INFORMATION OF THE LOGGED IN USER
	 * 
	 * 
	 */
	 public function index()
	 {
		$user_detail = $this->auth->user();
		$is_doctor = false;
		$is_nurse = false;
		if (!empty($user_detail['mas_id'])) {
			if ($user_detail['RoleId'] == 1 || $user_detail['RoleId'] == 2) {
				$doctor_master = DoctorMaster::findOrfail($user_detail['mas_id']);
				$user_detail = collect($user_detail)->toArray();
				$doctor_master = collect($doctor_master)->toArray();
				$user_detail = array_merge($user_detail, $doctor_master);
				$user_detail = collect($user_detail);
				$is_doctor = true;
			} elseif ($user_detail['RoleId'] == 3) {
				$nurse_master = NurseMaster::findOrfail($user_detail['mas_id']);
				$user_detail = collect($user_detail)->toArray();
				$nurse_master = collect($nurse_master)->toArray();
				$user_detail = array_merge($user_detail, $nurse_master);
				$user_detail = collect($user_detail);
				$is_nurse = true;
			}
		}
		return view('settings.profile.view', compact('user_detail', 'is_doctor', 'is_nurse')); 
	 } 
	 /**
	 * UPDATE THE PROFILE OF THE CURRENT LOGGED IN USER
	 */
	public function store(ProfileRequest $request)
	{
		$user_detail = $this->auth->user();
		$input = $request->all();
		$array['name'] = $input['name'];

		if ($input['new_password']!='') {
			$array['password'] = bcrypt($input['new_password']);
		}
        
        if (isset($input['short_signature']) && !empty($input['short_signature']))
        {
            $base64_string = $input['short_signature'];

            $base64_string = preg_replace('/^data:image\/\w+;base64,/', '', $base64_string);

            $image_data = base64_decode($base64_string);

            $directory = base_path() . '/public/img/users/';

            $path = $user_detail['id'] . '/short_signature/';

            $filename =  $path . time() . uniqid() . '.png';

            $file_path = $directory . $filename;

            if (!is_dir($directory . $path)) {
                mkdir($directory . $path, 0777, true);
            }

            file_put_contents($file_path, $image_data);

            $array['initial'] = $filename;;
        }

        if (isset($input['full_signature']) && !empty($input['full_signature']))
        {

            $base64_string = $input['full_signature'];

            $base64_string = preg_replace('/^data:image\/\w+;base64,/', '', $base64_string);

            $image_data = base64_decode($base64_string);

            $directory = base_path() . '/public/img/users/';

            $path =  $user_detail['id'] . '/full_signature/';

            $filename =  $path . time() . uniqid() . '.png';

            $file_path = $directory . $filename;

            if (!is_dir($directory . $path)) {
                mkdir($directory . $path, 0777, true);
            }

            file_put_contents($file_path, $image_data);

            $array['signature'] = $filename;
        }

		$user_detail->update($array);

		if (isset($input['doctor_id']) && !empty($input['doctor_id'])) {
			$doctor_master = DoctorMaster::findOrfail($user_detail['mas_id']);
			$post['Qualification'] = isset($input['Qualification']) ? $input['Qualification'] : null;
			$post['job_title'] = isset($input['job_title']) ? $input['job_title'] : null;
			$post['register_no'] = isset($input['register_no']) ? $input['register_no'] : null;
			$post['short_code'] = isset($input['short_code']) ? $input['short_code'] : null;
			$post['DateModified'] = Carbon::now($this->time_zone);
			$post['UserModified'] = $this->auth->user()['id'];
			$doctor_master->update($post);
		}
		if (isset($input['nurse_id']) && !empty($input['nurse_id'])) {
			$nurse_master = NurseMaster::findOrfail($user_detail['mas_id']);
			$post['register_no'] = isset($input['register_no']) ? $input['register_no'] : null;
			$post['DateModified'] = Carbon::now($this->time_zone);
			$post['UserModified'] = $this->auth->user()['id'];
			$nurse_master->update($post);		
		}
		return redirect(action('Settings\ProfileController@index'))->with('Success', 'Record added successfully !');
	}
}
