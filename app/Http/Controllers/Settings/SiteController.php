<?php namespace App\Http\Controllers\Settings;

use Illuminate\Html\HtmlFacade as HTML;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\FileRequest;
use App\User;
use App\Models\Baby;
use App\Models\Settings\Settings;
use App\Models\Settings\SpecialPermission;
use Input;
use App\Models\OpPrintPageConfig;

class SiteController extends Controller
{

    public function __construct(Guard $auth)
    {
        $this->middleware('role:SITESETTING,write', ['only' => ['store', 'update', 'edit', 'create', 'destory']]);
        $this->middleware('auth');
        $this->auth = $auth;
        $this->lang_path = str_replace('app', '', app_path()) . 'resources/lang/' . \App::getLocale() . '/';

    }
    /**
     * DISPLAY THE SITE SETTINGS FORM.
     *
     *@return array of object to view
     */
    public function index()
    {
        $results = Settings::get_record();
        $speicalurl = action('Settings\SpecialPermissionController@create');
        return view('settings.general.form', compact('results', 'speicalurl'));
    }

    public function store(FileRequest $request)
    {
        $input = $request->all();

        print_r($input);
        exit;
    }
    /**
     * DISPLAY THE MRNO SETTINGS FORM.
     *
     */
    public function edit()
    {

        $menu_names = $this->getMenu('menu.php');
        $results = Settings::get_record();

        $settings = unserialize($results[0]->BMRSettings);
        $results[0]->BOption1 = isset($settings[1]) ? $settings[1] : '';
        $results[0]->BOption2 = isset($settings[2]) ? $settings[2] : '';
        $results[0]->BOption3 = isset($settings[3]) ? $settings[3] : '';
        $results[0]->BOption4 = isset($settings[4]) ? $settings[4] : '';

        $settings = unserialize($results[0]->MMRSettings);
        $results[0]->MOption1 = isset($settings[1]) ? $settings[1] : '';
        $results[0]->MOption2 = isset($settings[2]) ? $settings[2] : '';
        $results[0]->MOption3 = isset($settings[3]) ? $settings[3] : '';
        $results[0]->MOption4 = isset($settings[4]) ? $settings[4] : '';
        $results[0]->mirthIntegration = ($results[0]->mirthIntegration == 1) ? '' : $results[0]->mirthIntegration;
        $results[0]->dSummaryedit = ($results[0]->dSummaryedit == 1) ? '' : $results[0]->dSummaryedit;

        $results = $results[0];

        $results->print_logo = $results->PrintLogo;

        $speical_user_id = 0;
        if (\Session::has('speical_user_id'))
        {
            $speical_user_id = \Session::get('speical_user_id');
        }
        $User = User::get()->pluck('name', 'id')
            ->toArray();
        $speicalurl = action('Settings\SiteController@getPermissionform');
        $encrypted_csrf_token = \Crypt::encrypt(csrf_token());

        $toastrOption = json_decode(\SiteHelpers::toastrOptions()->custom_toastr);

        $period = explode(':', date('h:i:a', strtotime($results->period)));

        $results->period_hours = $period[0];
        $results->period_mins = $period[1];
        $results->period_session = strtoupper($period[2]);

        $op_print_page_user = OpPrintPageConfig::getUserBasedList();
        $op_print_page_ip = OpPrintPageConfig::getIpBasedList();

        return view('settings.general.mrform', compact('results', 'menu_names', 'speicalurl', 'User', 'speical_user_id', 'encrypted_csrf_token', 'toastrOption', 'op_print_page_user', 'op_print_page_ip'));
    }
    /**
     * UPDATE THE SETTINGS
     */
    public function update(Request $request)
    {
        $input = $request->all();
        $input['default_limit'] = isset($input['default_limit']) ? $input['default_limit'] : '';

        if (isset($input['limit_option'])) $post['pagenation_limit_options'] = json_encode(["limit_option" => $input['limit_option'], "default_limit" => $input['default_limit']]);
        else $post['pagenation_limit_options'] = '';

        $url = '';

        $this->putMenu('menu.php', $input);

        if (isset($input['image-upload']) && !empty($input['image-upload']))
        {

            $url = $this->moveImage($input['image-upload'], $input['image-upload-width'], $input['image-upload-height'], $input['image-upload-x'], $input['image-upload-y']);
        }

        $baby_settings[1] = $input['BOption1'];
        $baby_settings[2] = $input['BOption2'];
        $baby_settings[3] = $input['BOption3'];
        $baby_settings[4] = $input['BOption4'];

        $mother_settings[1] = $input['MOption1'];
        $mother_settings[2] = $input['MOption2'];
        $mother_settings[3] = $input['MOption3'];
        $mother_settings[4] = $input['MOption4'];

        if (isset($input['permissions']))
        {
            $permissions['user_id'] = $input['user_id'];
            $permissions['permissions'] = json_encode($input['permissions']);
            $permissions['UserDeleted'] = 0;

            $userPermission = SpecialPermission::where('user_id', $input['user_id'])->first();
            if (count($userPermission) > 0)
            {
                $permissions['UserModified'] = $this
                    ->auth
                    ->user()->id;
                $permissions['DateModified'] = Carbon::now();
                $permissions['DateAdded'] = Carbon::now();
                $sp = SpecialPermission::findorfail($userPermission->id);
                $sp->update($permissions);

            }
            else
            {
                $permissions['UserAdded'] = $this
                    ->auth
                    ->user()->id;
                $permissions['DateAdded'] = Carbon::now();
                SpecialPermission::create($permissions);
            }
            \Session::put('speical_user_id', $input['user_id']);

        }

        $post['BMRSettings'] = serialize($baby_settings);
        $post['MMRSettings'] = serialize($mother_settings);

        $post['DateModified'] = Carbon::now();
        $results = Settings::findorfail(1);
        $post['discharge_report_left'] = $input['discharge_report_left'];
        $post['discharge_report_right'] = $input['discharge_report_right'];
        $post['OverwriteBabyMR'] = !empty($input['OverwriteBabyMR']) ? 1 : 0;
        $post['OverwriteMotherMR'] = !empty($input['OverwriteMotherMR']) ? 1 : 0;
        $post['mirthIntegration'] = isset($input['mirthIntegration']) ? 2 : 1;
        $post['header_required'] = isset($input['header_required']) ? 2 : 1;
        $post['neonatal_highlight'] = isset($input['neonatal_highlight']) ? 2 : 1;
        $post['nicu_highlight'] = isset($input['nicu_highlight']) ? 2 : 1;
        $post['nicu_daycare_highlight'] = isset($input['nicu_daycare_highlight']) ? 2 : 1;
        $post['daycare_summary_highlight'] = isset($input['daycare_summary_highlight']) ? 2 : 1;
        $post['prblm_summary_highlight'] = isset($input['prblm_summary_highlight']) ? 2 : 1;
        $post['post_adm_highlight'] = isset($input['post_adm_highlight']) ? 2 : 1;
        $post['post_daycare_adm_highlight'] = isset($input['post_daycare_adm_highlight']) ? 2 : 1;
        $post['post_summary_highlight'] = isset($input['post_summary_highlight']) ? 2 : 1;
        $post['op_highlight'] = isset($input['op_highlight']) ? 2 : 1;
        $post['dSummaryedit'] = isset($input['dSummaryedit']) ? 2 : 1;
        $post['hospital_name'] = $input['hospital_name'];
        $post['hospital_contact'] = $input['hospital_contact'];
        $post['discharge_summary_footer'] = $input['discharge_summary_footer'];
        $post['nurse_entry_start'] = $input['nurse_entry_start'];
        $post['period'] = date('H:i:s', strtotime($input['period_hours'] . ':' . $input['period_mins'] . ' ' . $input['period_session']));
        $post['daycare_dates_for_chart'] = (isset($input['daycare_dates_for_chart']) && !empty($input['daycare_dates_for_chart'])) ? serialize($input['daycare_dates_for_chart']) : null;
        // $post['machine_interface']        = isset($input['machine_interface']) ?  1 : 0;
        $post['pediatric_discharge_summary'] = $input['pediatric_discharge_summary'];
        $post['condition_at_discharge'] = $input['condition_at_discharge'];
        $post['review_details'] = $input['review_details'];
        $post['neonatal_op_print_right'] = $input['neonatal_op_print_right'];
        

        if (!empty($url))
        {
            $post['PrintLogo'] = $url;
        }

        $post['discharge_instraction'] = $input['discharge_instraction'];

        if (isset($input["closeButton"]) && $input["closeButton"] == 1)
        {
            $input["closeButton"] = true;
        }
        else
        {
            $input["closeButton"] = false;
        }

        if (isset($input["debugInfo"]) && $input["debugInfo"] == 1)
        {
            $input["debugInfo"] = true;
        }
        else
        {
            $input["debugInfo"] = false;
        }

        if (isset($input["progressBar"]) && $input["progressBar"] == 1)
        {
            $input["progressBar"] = true;
        }
        else
        {
            $input["progressBar"] = false;
        }

        if (isset($input["preventDuplicates"]) && $input["preventDuplicates"] == 1)
        {
            $input["preventDuplicates"] = true;
        }
        else
        {
            $input["preventDuplicates"] = false;
        }

        if (isset($input["newestOnTop"]) && $input["newestOnTop"] == 1)
        {
            $input["newestOnTop"] = true;
        }
        else
        {
            $input["newestOnTop"] = false;
        }

        $post['custom_toastr'] = json_encode(["closeButton" => $input["closeButton"], "debug" => $input["debugInfo"], "newestOnTop" => $input["newestOnTop"], "progressBar" => $input["progressBar"], "positionClass" => $input["positionGroup"], "preventDuplicates" => $input["preventDuplicates"], "showDuration" => $input["showDuration"], "hideDuration" => $input["hideDuration"], "timeOut" => $input["timeOut"], "extendedTimeOut" => $input["extendedTimeOut"], "showEasing" => $input["showEasing"], "hideEasing" => $input["hideEasing"], "showMethod" => $input["showMethod"], "hideMethod" => $input["hideMethod"], "toastTypeGroup" => $input["toastTypeGroup"]

        ]);

        $results->update($post);

        $op_print_user_ids = isset($input['op_print_user_ids_list']) ? json_decode($input['op_print_user_ids_list']) : [];

        if (isset($input['op_print_user_id']) && is_array($input['op_print_user_id']))
        {

            foreach ($input['op_print_user_id'] as $key => $value)
            {
                if (!empty($value))
                {
                    $op_post['user_id'] = $value;
                    $op_post['ip_address'] = null;
                    $op_post['top_spacing'] = (isset($input['op_print_user_top_spacing'][$key]) && !empty($input['op_print_user_top_spacing'][$key])) ? $input['op_print_user_top_spacing'][$key] : 0;
                    $op_post['right_spacing'] = (isset($input['op_print_user_right_spacing'][$key]) && !empty($input['op_print_user_right_spacing'][$key])) ? $input['op_print_user_right_spacing'][$key] : 0;
                    $op_post['bottom_spacing'] = (isset($input['op_print_user_bottom_spacing'][$key]) && !empty($input['op_print_user_bottom_spacing'][$key])) ? $input['op_print_user_bottom_spacing'][$key] : 0;
                    $op_post['left_spacing'] = (isset($input['op_print_user_left_spacing'][$key]) && !empty($input['op_print_user_left_spacing'][$key])) ? $input['op_print_user_left_spacing'][$key] : 0;
                    $op_post['status'] = $input['op_print_user_status'][$key];
                    $op_post['modified_by'] = $this
                        ->auth
                        ->user()->id;
                    $op_post['modified_date_time'] = Carbon::now();

                    if (isset($input['op_print_user_ids'][$key]) && in_array($input['op_print_user_ids'][$key], $op_print_user_ids))
                    {
                        $op_user_config = OpPrintPageConfig::findorfail($input['op_print_user_ids'][$key]);
                        $op_user_config->update($op_post);
                        unset($op_print_user_ids[$key]);
                    }
                    else
                    {
                        $op_post['created_by'] = $this
                            ->auth
                            ->user()->id;
                        $op_post['create_date_time'] = Carbon::now();
                        OpPrintPageConfig::create($op_post);
                    }
                }
            }

        }
        OpPrintPageConfig::whereIn('id', $op_print_user_ids)->update(['is_deleted' => 1, 'deleted_by' => $this
            ->auth
            ->user()->id]);

        $op_print_ip_ids = isset($input['op_print_ip_ids_list']) ? json_decode($input['op_print_ip_ids_list']) : [];

        if (isset($input['op_print_ip_address']) && is_array($input['op_print_ip_address']))
        {

            foreach ($input['op_print_ip_address'] as $key => $value)
            {
                if (!empty($value))
                {
                    $op_post['user_id'] = null;
                    $op_post['ip_address'] = $value;
                    $op_post['top_spacing'] = (isset($input['op_print_ip_top_spacing'][$key]) && !empty($input['op_print_ip_top_spacing'][$key])) ? $input['op_print_ip_top_spacing'][$key] : 0;
                    $op_post['right_spacing'] = (isset($input['op_print_ip_right_spacing'][$key]) && !empty($input['op_print_ip_right_spacing'][$key])) ? $input['op_print_ip_right_spacing'][$key] : 0;
                    $op_post['bottom_spacing'] = (isset($input['op_print_ip_bottom_spacing'][$key]) && !empty($input['op_print_ip_bottom_spacing'][$key])) ? $input['op_print_ip_bottom_spacing'][$key] : 0;
                    $op_post['left_spacing'] = (isset($input['op_print_ip_left_spacing'][$key]) && !empty($input['op_print_ip_left_spacing'][$key])) ? $input['op_print_ip_left_spacing'][$key] : 0;
                    $op_post['status'] = $input['op_print_ip_status'][$key];
                    $op_post['modified_by'] = $this
                        ->auth
                        ->user()->id;
                    $op_post['modified_date_time'] = Carbon::now();

                    if (isset($input['op_print_ip_ids'][$key]) && in_array($input['op_print_ip_ids'][$key], $op_print_ip_ids))
                    {
                        $op_user_config = OpPrintPageConfig::findorfail($input['op_print_ip_ids'][$key]);
                        $op_user_config->update($op_post);
                        unset($op_print_ip_ids[$key]);
                    }
                    else
                    {
                        $op_post['created_by'] = $this
                            ->auth
                            ->user()->id;
                        $op_post['create_date_time'] = Carbon::now();
                        OpPrintPageConfig::create($op_post);
                    }
                }
            }
        }
        OpPrintPageConfig::whereIn('id', $op_print_ip_ids)->update(['is_deleted' => 1, 'deleted_by' => $this
            ->auth
            ->user()->id]);

        return redirect(action('Settings\SiteController@edit'))
            ->with('Success', 'Record updated successfully ');
    }

    public function moveImage($data, $width, $height, $x, $y)
    {

        list($type, $data) = explode(';', $data);
        list(, $data) = explode(',', $data);
        $data = base64_decode($data);
        $resizedImage = imagecreatetruecolor(301, 152);
        $color = imagecolorallocate($resizedImage, 255, 255, 255);
        imagefill($resizedImage, 0, 0, $color);

        if (\File::exists(public_path('/img/header.png')))
        {

            \File::delete(public_path('/img/header.png'));
        }

        imagepng($resizedImage, public_path('/img/header.png') , 0);
        file_put_contents(public_path('/img/header.png') , $data);

        $img_r = imagecreatefrompng(public_path('/img/header.png'));

        $final_image = imagecreatetruecolor($width, $height);
        $color = imagecolorallocate($final_image, 255, 255, 255);
        imagefill($final_image, 0, 0, $color);
        imagecopyresized($final_image, $img_r, 0, 0, $x - 12, $y - 12, $width, $height, $width, $height);
        imagepng($final_image, public_path('/img/header.png') , 0);

        return 'header.png';

    }
    /**
     * UPDATE THE SETTINGS
     */
    public function mroverwrite(Request $request)
    {
        $input = $request->all();

        $results = Settings::findorfail(1);
        $results->update($input);

        return redirect(action('Settings\SiteController@edit'));
    }

    /***
     * Return the permission form based on user
     *
    */
    public function getPermissionform(Request $request)
    {
        $input = $request->all();
        $permissionForm = '<span class="error-message">Please Select The User !</span>';
        if ($input['userId'] != 0)
        {
            $userPermission = SpecialPermission::select('permissions')->where('user_id', $input['userId'])->first();
            $permission_status = array();

            if (count($userPermission) > 0)
            {
                $permission_status = json_decode($userPermission->permissions);
            }

            $permissionForm = view('settings.specialpermisson.create', compact('permission_status'))->render();
        }
        return $permissionForm;
    }

    public function cropImage(Request $request)
    {
        $image = $request->file('img');

        $type = $image->getClientOriginalExtension();

        $name = 'header_temp.' . $type;

        $path = public_path() . '/img/';

        $image->move($path, $name);

        $url = url('public') . '/img/' . $name;

        list($width, $height, $type, $attr) = getimagesize($url);

        return \Response::json(["status" => 'success', "url" => $url, "width" => $width, "height" => $height], 200);

    }

    private function getMenu($file_name)
    {
        $file_name = $this->lang_path . $file_name;
        $menu_names = file_get_contents($file_name);
        $menu_names = preg_replace('/[\n]/', '', $menu_names);
        $menu_names = str_replace('"', '', $menu_names);
        $menu_names = str_replace('];', '', trim($menu_names));
        $menu_names = str_replace('<?php return [ ', '', trim($menu_names));
        $main_menu = explode(',', $menu_names);

        $menu_list = array();

        foreach ($main_menu as $key => $menu)
        {
            $temp_menu = explode('=>', trim($menu));

            if (isset($temp_menu[0]) && isset($temp_menu[1]))
            {

                $menu_list[trim($temp_menu[0]) ] = $temp_menu[1];

            }

        }

        return $menu_list;
    }

    private function putMenu($file_name, $values)
    {

        $menu_keys = array_keys($this->getMenu($file_name));
        $file_name = $this->lang_path . $file_name;

        $file_content = "<?php return [ ";

        foreach ($menu_keys as $key => $value)
        {
            $file_content .= '"' . $value . '" => "' . trim($values[$value]) . '",' . "\n";
        }

        $file_content .= '];';

        return file_put_contents($file_name, $file_content);

    }

    public function uploadImage(Request $request, $input)
    {

        // $input = $request->all();
        $jpeg_quality = 100;
        $name = 'header';
        $image_details = getimagesize($input['imgUrl']);

        switch (strtolower($image_details['mime']))
        {
            case 'image/png':
                $img_r = imagecreatefrompng($input['imgUrl']);
                $source_image = imagecreatefrompng($input['imgUrl']);
                $type = '.png';
            break;
            case 'image/jpeg':
                $img_r = imagecreatefromjpeg($input['imgUrl']);
                $source_image = imagecreatefromjpeg($input['imgUrl']);
                error_log("jpg");
                $type = '.jpeg';
            break;
            case 'image/gif':
                $img_r = imagecreatefromgif($input['imgUrl']);
                $source_image = imagecreatefromgif($input['imgUrl']);
                $type = '.gif';
            break;
            default:
                die('image type not supported');
        }
        $fileName = $name . $type;
        $output_filename = public_path() . '/img/' . $fileName;

        // resize the original image to size of editor
        $resizedImage = imagecreatetruecolor($input['imgW'], $input['imgH']);
        $color = imagecolorallocate($resizedImage, 255, 255, 255);
        imagefill($resizedImage, 0, 0, $color);
        imagecopyresampled($resizedImage, $source_image, 0, 0, 0, 0, $input['imgW'], $input['imgH'], $input['imgInitW'], $input['imgInitH']);

        // rotate the rezized image
        $rotated_image = imagerotate($resizedImage, -$input['rotation'], 0);

        // find new width & height of rotated image
        $rotated_width = imagesx($rotated_image);
        $rotated_height = imagesy($rotated_image);

        // diff between rotated & original sizes
        $dx = $rotated_width - $input['imgW'];
        $dy = $rotated_height - $input['imgH'];

        // crop rotated image to fit into original rezized rectangle
        $cropped_rotated_image = imagecreatetruecolor($input['imgW'], $input['imgH']);
        imagecolortransparent($cropped_rotated_image, imagecolorallocate($cropped_rotated_image, 255, 255, 255));
        imagecopyresampled($cropped_rotated_image, $rotated_image, 0, 0, $dx / 2, $dy / 2, $input['imgW'], $input['imgH'], $input['imgW'], $input['imgH']);

        //crop image into selected area
        $final_image = imagecreatetruecolor($input['cropW'], $input['cropH']);
        imagecolortransparent($final_image, imagecolorallocate($final_image, 255, 255, 255));
        imagecopyresampled($final_image, $resizedImage, 0, 0, $input['imgX1'], $input['imgY1'], $input['cropW'], $input['cropH'], $input['cropW'], $input['cropH']);

        if (\File::exists($output_filename))
        {
            \File::delete($output_filename);
        }

        imagejpeg($final_image, $output_filename, $jpeg_quality);

        return url('/public/img/' . $fileName);

        // // $response = Array(
        // //         "status" => 'success',
        // //         "url" => url('/public/img/'.$fileName),
        // // );
        // print json_encode($response);
        

        
    }

    public function cache()
    {
        foreach (glob(storage_path() . SiteHelpers::getConfigSettings('CLEAR_VIEWS')) as $filename)
        {
            unlink($filename);
        }
        $storage_path = storage_path() . SiteHelpers::getConfigSettings('CLEAR_CACHE');
        shell_exec('rm -rf ' . $storage_path);
        // mkdir($storage_path,0777,true);
        
    }

    public function opPageSpacing(Request $request)
    {
        $input = $request->all();
        if (!isset($input['config']))
        {
            return \Response::json(["status" => 'error', 'message' => 'Please select "User" or "Ip address"!'], 500);
        }
        else
        {
            if ($input['config'] == 'user')
            {
                $user_id = $this
                    ->auth
                    ->user()->id;
                $page['top_spacing'] = !empty($input['user_top_spacing']) ? $input['user_top_spacing'] : 0;
                $page['right_spacing'] = !empty($input['user_right_spacing']) ? $input['user_right_spacing'] : 0;
                $page['bottom_spacing'] = !empty($input['user_bottom_spacing']) ? $input['user_bottom_spacing'] : 0;
                $page['left_spacing'] = !empty($input['user_left_spacing']) ? $input['user_left_spacing'] : 0;
                $page['modified_by'] = $this
                    ->auth
                    ->user()->id;
                $page['modified_date_time'] = Carbon::now();
                if ($input['user_based'] != '')
                {
                    $result = OpPrintPageConfig::findorfail($input['user_based']);
                    $result->update($page);
                }
                else
                {
                    $result = OpPrintPageConfig::where('user_id', $user_id)->where('is_deleted', false)
                        ->first();
                    if (count($result) > 0)
                    {
                        $result->update($page);
                    }
                    else
                    {
                        $page['user_id'] = $user_id;
                        $page['created_by'] = $this
                            ->auth
                            ->user()->id;
                        $page['create_date_time'] = Carbon::now();
                        OpPrintPageConfig::create($page);
                    }
                }
            }
            if ($input['config'] == 'ip_address')
            {
                $ip_address = \Request::ip();
                $page['top_spacing'] = !empty($input['ip_top_spacing']) ? $input['ip_top_spacing'] : 0;
                $page['right_spacing'] = !empty($input['ip_right_spacing']) ? $input['ip_right_spacing'] : 0;
                $page['bottom_spacing'] = !empty($input['ip_bottom_spacing']) ? $input['ip_bottom_spacing'] : 0;
                $page['left_spacing'] = !empty($input['ip_left_spacing']) ? $input['ip_left_spacing'] : 0;
                $page['modified_by'] = $this
                    ->auth
                    ->user()->id;
                $page['modified_date_time'] = Carbon::now();
                if ($input['ip_based'] != '')
                {
                    $result = OpPrintPageConfig::findorfail($input['ip_based']);
                    $result->update($page);
                }
                else
                {
                    $result = OpPrintPageConfig::where('ip_address', $ip_address)->where('is_deleted', false)
                        ->first();
                    if (count($result) > 0)
                    {
                        $result->update($page);
                    }
                    else
                    {
                        $page['ip_address'] = \Request::ip();
                        $page['created_by'] = $this
                            ->auth
                            ->user()->id;
                        $page['create_date_time'] = Carbon::now();
                        OpPrintPageConfig::create($page);
                    }
                }
            }
            return \Response::json(["status" => 'success', 'message' => 'Updated succcessfully !'], 200);
        }
    }
}

