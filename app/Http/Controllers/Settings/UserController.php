<?php namespace App\Http\Controllers\Settings;

use Illuminate\Html\HtmlFacade as HTML;
use App\User;
use App\Models\Settings\Usergroups;
use Illuminate\Contracts\Auth\Guard;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\Masters\DoctorMaster;
use App\Models\Masters\NurseMaster;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\Settings\DeleteApproval;
use File;

class UserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders your application's "dashboard" for users that
    | are authenticated. Of course, you are free to change or remove the
    | controller as you wish. It is just here to get your app started!
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->middleware('auth');
        $this->auth = $auth;
    }

    /**
     * List the users.
     *
     *
     */
    public function index(Request $request)
    {

        //Initialize the record  limit  with 50
        $limit = 50;

        //set the limit as per the request
        if (!empty($request->input('limit')))
        {

            $request->session()
            ->put('limit', $request->input('limit'));
            $limit = $request->session()
            ->get('limit');

        }
        elseif ($request->session()
            ->has('limit'))
        {

            $limit = $request->session()
            ->get('limit');

        }

        //Initialize the record sorting key and order
        $order['sortby'] = 'id';
        $order['sortorder'] = 'desc';

        //set the records sorting key and order
        if (!empty($request->input('sortby')) && !empty($request->input('sortorder')))
        {

            $order['sortby'] = \SiteHelpers::decrypt_id($request->input('sortby'));
            $order['sortorder'] = $request->input('sortorder');

        }

        //initialize search parameter array
        $search = array();
        $search['search_txt'] = '';
        if (!empty($request->input('search_txt')))
        {

            $search['search_txt'] = $request->input('search_txt');

        }

        //get the mother record list form mother module
        $user_id = $this
        ->auth
        ->user()->id;
        $role_id = $this
        ->auth
        ->user()->RoleId;
        $result = User::ListUsers($user_id, $role_id, $request->input('page') , $limit, $search, $order, 1);

        $limitstart = (empty($request->input('page')) || $request->input('page') == 1) ? 0 : (($request->input('page') - 1) * $limit);

        $total = $result->get()
        ->count();

        $results = $result->limit($limit)->offset($limitstart)->get();

        $getTotal = User::GetTotal($user_id, $role_id);

        $page = !empty($request->input('page')) ? $request->input('page') : 1;
        $pagecount = ceil($total / $limit);
        $pagination['total'] = $total;
        $pagination['start'] = (($page - 2) < 1) ? 1 : ($page - 2);
        $pagination['end'] = ($pagecount < ($page + 3)) ? $pagecount : ($page + 3);
        $pagestart = $total != 0 ? ($page <= 1) ? $page : ($page - 1) * $limit + 1 : 0;
        $pagerecords = ($page == $pagination['end'] || $pagination['total'] == 0) ? $pagination['total'] : $page * $limit;
        $pagination['limit'] = array(
            $pagestart,
            $pagerecords
        );
        $pagination['limits'] = $limit;
        $pagination['previous'] = (($page - 1) < 1) ? 1 : ($page - 1);
        $pagination['next'] = ($pagecount < ($page + 1)) ? $pagecount : ($page + 1);

        return view('settings.users.list', compact('results', 'role_id', 'pagination', 'search', 'order', 'getTotal', 'user_id'));

    }

    /**
     * User create form
     *
     *
     */

    public function create()
    {

        $role_id = $this->auth->user()->RoleId;
        $roles = array(
            '' => '- - Select - -'
        );
        $role_data = Usergroups::get_list($role_id);

        foreach ($role_data as $role)
        {
            $roles[$role
                ->RoleId] = $role->RoleName;
            }
            return view('settings.users.create', compact('roles'));
        }

    /**
     * creating the user based on request
     *
     *
     */

    public function store(UserRequest $request)
    {
        $input = $request->all();

        $array['RoleId'] = $input['RoleId'];
        $array['name'] = $input['name'];
        $array['email'] = $input['email'];
        $array['password'] = bcrypt($input['password']);
        $array['name_prefix'] = $input['name_prefix'] . ' ';
        $array['isMaster'] = 0;
        $array['short_code'] = isset($input['short_code']) ? $input['short_code'] : null;
        $array['status'] = $input['status'] == 0 ? true : false;
        $array['created_at'] = Carbon::now(env('TIME_ZONE'));
        $array['created_user'] = $this->auth->user()->id;
        $array['updated_at'] = Carbon::now(env('TIME_ZONE'));
        $array['modified_user'] = $this->auth->user()->id;

        User::insert($array);

        $userId = User::getUserId($input['email']);

        if (isset($input['job_title']) || isset($input['Qualification']) || isset($input['type'])) {
            $post['Name'] = $input['name_prefix'] . ' ' . $input['name'];
            $post['status'] = $input['status'] == 0 ? 1 : 2;
            $post['DateAdded'] = Carbon::now();
            $post['UserAdded'] = $this->auth->user()->id;
            $post['DateModified'] = Carbon::now();
            $post['UserModified'] = $this->auth->user()->id;
            $post['type'] = $input['type'];
            $post['Qualification'] = $input['Qualification'];
            $post['userId'] = $userId->id;
            $post['job_title'] = $input['job_title'];
            $post['register_no'] = $input['register_no'];
            $post['IsDeleted'] = 0;
            $doctor_id = DoctorMaster::create($post)->id;

            $summary_approval = isset($input['summary_approval']) ? 1 : 0;
            User::where('id',$userId->id)->update(['mas_id'=> $doctor_id, 'summary_approval'=>$summary_approval]);
        } else if (isset($input['register_no'])) {
            $post['name'] = $input['name'];
            $post['register_no'] = $input['register_no'];
            $post['status'] = $input['status'] == 0 ? 'Active' : 'Inactive';
            $post['user_id'] = $userId->id;
            $post['DateAdded'] = Carbon::now();
            $post['UserAdded'] = $this->auth->user()->id;
            $post['DateModified'] = Carbon::now();
            $post['UserModified'] = $this->auth->user()->id;
            $post['IsDeleted'] = 0;
            $nurse_id = NurseMaster::create($post)->id;

            User::where('id',$userId->id)->update(['mas_id'=> $nurse_id]);
        }

        if (isset($input['short_signature']) && !empty($input['short_signature']))
        {
            $base64_string = $input['short_signature'];

            $base64_string = preg_replace('/^data:image\/\w+;base64,/', '', $base64_string);

            $image_data = base64_decode($base64_string);

            $directory = base_path() . '/public/img/users/';

            $path = $userId->id . '/short_signature/';

            $filename =  $path . time() . uniqid() . '.png';

            $file_path = $directory . $filename;

            if (!is_dir($directory . $path)) {
                mkdir($directory . $path, 0777, true);
            }

            file_put_contents($file_path, $image_data);

            User::where('id',$userId->id)->update(['initial'=> $filename]);
        }

        if (isset($input['full_signature']) && !empty($input['full_signature']))
        {

            $base64_string = $input['full_signature'];

            $base64_string = preg_replace('/^data:image\/\w+;base64,/', '', $base64_string);

            $image_data = base64_decode($base64_string);

            $directory = base_path() . '/public/img/users/';

            $path =  $userId->id . '/full_signature/';

            $filename =  $path . time() . uniqid() . '.png';

            $file_path = $directory . $filename;

            if (!is_dir($directory . $path)) {
                mkdir($directory . $path, 0777, true);
            }

            file_put_contents($file_path, $image_data);

            User::where('id',$userId->id)->update(['signature'=> $filename]);
        }

        return redirect(action('Settings\UserController@index'))->with('Success', 'Record added successfully !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return edit forms
     */
    public function edit($id)
    {
        $id = \SiteHelpers::decrypt_id($id);

        $role_id = $this->auth->user()->RoleId;
        $results = User::findOrfail($id)->toArray();

        $role_name = Usergroups::findOrfail($results['RoleId']);

        if (isset($results['mas_id']) && isset($role_name->RoleName) && strtolower($role_name->RoleName) == strtolower('Nurse')) {
            $masters_result = NurseMaster::findOrfail($results['mas_id'])->toArray();
        } elseif (isset($results['mas_id']) && isset($role_name->RoleName) && strtolower($role_name->RoleName) == strtolower('Doctor')) {
            $masters_result = DoctorMaster::findOrfail($results['mas_id'])->toArray();
        }

        if (isset($masters_result) && is_array($masters_result) && count($masters_result) > 0)
        {
            $result = array_merge($masters_result, $results);
        }
        else
        {
            $result = $results;
        }

        $roles = array(
            0 => 'Select'
        );
        $role_data = Usergroups::get_list($role_id);
        foreach ($role_data as $role)
        {
            $roles[$role
                ->RoleId] = $role->RoleName;
            }

            $result['status'] = (!empty($result['status']) && $result['status']) ? 0 : 1;

            return view('settings.users.edit', compact('roles', 'result'));
        }
    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @redirect listing page
     */
    public function update($id, UserRequest $request)
    {
        $results = User::findOrfail($id);

        $input = $request->all();

        if (isset($input['short_signature']) && !empty($input['short_signature']))
        {
            $base64_string = $input['short_signature'];

            $base64_string = preg_replace('/^data:image\/\w+;base64,/', '', $base64_string);

            $image_data = base64_decode($base64_string);

            $directory = base_path() . '/public/img/users/';

            $path = $results->id . '/short_signature/';

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

            $path =  $results->id . '/full_signature/';

            $filename =  $path . time() . uniqid() . '.png';

            $file_path = $directory . $filename;

            if (!is_dir($directory . $path)) {
                mkdir($directory . $path, 0777, true);
            }

            file_put_contents($file_path, $image_data);

            $array['signature'] = $filename;
        }

        $array['name'] = $input['name'];
        $array['email'] = $input['email'];
        if ($input['password'] != '')
        {
            $array['password'] = bcrypt($input['password']);
        }
        $array['updated_at'] = Carbon::now(env('TIME_ZONE'));
        $array['modified_user'] = $this->auth->user()->id;
        $array['name_prefix'] = $input['name_prefix'] . ' ';
        $array['short_code'] = isset($input['short_code']) ? $input['short_code'] : null;
        $array['status'] = $input['status'] == 0 ? true : false;

        $results->update($array);

        if (isset($input['job_title']) || isset($input['Qualification']) || isset($input['type'])) {

            $post['Name'] = $input['name_prefix'] . ' ' . $input['name'];
            $post['status'] = $input['status'] == 0 ? 1 : 2;
            $post['type'] = $input['type'];
            $post['Qualification'] = $input['Qualification'];
            $post['job_title'] = $input['job_title'];            
            $post['register_no'] = $input['register_no'];
            $post['IsDeleted'] = 0;

            if (!empty($input['temp_mas_id'])) {

                $doctor_result = DoctorMaster::findOrfail($input['temp_mas_id']);

                $post['DateModified'] = Carbon::now();
                $post['UserModified'] = $this->auth->user()->id;
                
                $doctor_result->update($post);

                $doctor_id = $input['temp_mas_id'];

            } else {

                $post['DateAdded'] = Carbon::now();
                $post['UserAdded'] = $this->auth->user()->id;
                $post['userId'] = $id;
                $doctor_id = DoctorMaster::create($post)->id;

            }
            $summary_approval = isset($input['summary_approval']) ? 1 : 0;

            User::where('id',$id)->update(['mas_id'=> $doctor_id, 'summary_approval'=> $summary_approval]);

        } else if (isset($input['register_no'])) {

            $post['name'] = $input['name'];
            $post['register_no'] = $input['register_no'];
            $post['status'] = $input['status'] == 0 ? 'Active' : 'Inactive';
            $post['IsDeleted'] = 0;

            if (!empty($input['temp_mas_id'])) {

                $nurse_result = NurseMaster::findOrfail($input['temp_mas_id']);

                $post['DateModified'] = Carbon::now();
                $post['UserModified'] = $this->auth->user()->id;
                
                $nurse_result->update($post);

            } else {

                $post['user_id'] = $id;
                $post['DateAdded'] = Carbon::now();
                $post['UserAdded'] = $this->auth->user()->id;
                $nurse_id = NurseMaster::create($post)->id;

                User::where('id',$id)->update(['mas_id'=> $nurse_id]);

            }

        }

        if ($results->RoleId == 1) {

            $post['updated_at'] = Carbon::now();
            $post['modified_user'] = $this->auth->user()->id;
            $post['summary_approval'] = isset($input['summary_approval']) ? 1 : 0;

            User::where('id',$id)->update($post);
        }

        return redirect(action('Settings\UserController@index'))->with('Success', 'Record updated successfully !');
    }
}

