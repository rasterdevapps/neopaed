<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use App\Models\Masters\InvestigationsPackageMaster;

class MasterController extends Controller
{
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * This method to get Master Table Fileds to enter from various forms
     * @param $table_name 
     *
     */
    public function getMasterTableFields($table_name)
    {
        $query = "SELECT c.column_name,pgd.description
                    FROM pg_catalog.pg_statio_all_tables as st
                      inner join pg_catalog.pg_description pgd on (pgd.objoid=st.relid)
                      inner join information_schema.columns c on (pgd.objsubid=c.ordinal_position
                        and  c.table_schema=st.schemaname and c.table_name=st.relname) where pgd.description IS NOT NULL and c.table_name = '".$table_name."' order by c.ordinal_position";
        $result = \DB::select($query);
        if (count($result) > 0) {
            $html = '';
            foreach ($result as $key => $value) {
                $check_json = $this->isJson($value->description);
                if ($check_json == '1') {
                    $options_array = json_decode($value->description);
                    if ($options_array->type == 'select') {
                        $html .= '<div class="row form-group">';
                        $html .= '<div class="col-md-3 label-control text-right">';
                        $html .= '<label>'.ucfirst(str_replace('_', ' ', $value->column_name)).'</label>';
                        $html .= '</div>';
                        $html .= '<div class="col-md-9 custom-input">';
                        $html .='<select class="form-control master_required" name="'.$value->column_name.'">';
                        
                        if (count($options_array->values) > 0) {
                            foreach ($options_array->values as $opt_key => $opt_value) {
                                $html .= '<option value="'.$opt_key.'">'.$opt_value.'</option>';
                            }
                        }
                        $html .= '</select>';
                        $html .= '</div>';
                        $html .= '</div>';
                    }
                }
                else
                {

                    if ($table_name == 'mas_drugivfluid' && $value->column_name == 'value') {
                        $column_label_name = 'Formulation/Strength';
                    } else {
                        $column_label_name = $value->column_name;                       
                    }

                    switch ($value->description) {
                        case 'text':
                            $html .= '<div class="row form-group"><div class="col-md-3 label-control text-right"><label>'.ucfirst(str_replace('_', ' ', $column_label_name)).'</label></div><div class="col-md-9 custom-input"><input type="text" name="'.$value->column_name.'" class="form-control master_required"></div></div>';
                            break;

                        case 'email':
                            $html .= '<div class="row form-group"><div class="col-md-3 label-control text-right"><label>'.ucfirst(str_replace('_', ' ', $column_label_name)).'</label></div><div class="col-md-9 custom-input"><input type="email" name="'.$value->column_name.'" class="form-control master_required"></div></div>';
                            break;

                        case 'number':
                            $html .= '<div class="row form-group"><div class="col-md-3 label-control text-right"><label>'.ucfirst(str_replace('_', ' ', $column_label_name)).'</label></div><div class="col-md-9 custom-input"><input type="text" onkeypress="return isNumber(event, this);" name="'.$value->column_name.'" class="form-control master_required"></div></div>';
                            break;
                        
                        default:
                            
                            break;
                    }
                }
            }
            if ($table_name == 'mas_investigations_package') {
                $html.= '<div class="row form-group"><div class="col-md-5 col-md-offset-3 text-right"><table class="table investigations_popup_table"><tr><td class="text-right"><input type="text" name="test_name[]" value="" class="form-control input-fields-shadow master_required"></td><td width="5%"><button type="button" class="btn btn-success investigation_add_btn"><i class="fa fa-plus"></i></button></td></tr></table></div></div>';
            }
            return \Response::json(['status'=>true, 'html'=>$html], 200);
        }
        return \Response::json(['status'=>false, 'message'=>'Something went wrong...!'], 500);
    }
    /**
     * This method to check weather a string is JSON or not
     * @param $string 
     *
     */
    function isJson($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    /**
     * This method to store master data into DB from popup
     * @param $string 
     *
     */
    public function saveMasterData(Request $request) {
        $input = $request->all();
        if (isset($input['table_name']) && !empty($input['table_name'])) {
            $table_name = $input['table_name'];
            if ($table_name == 'mas_investigations_package') {
                $package_post['package_name']   = $input['package_name'];
                $package_post['package_status'] = $input['package_status'];

                $check_exist = \DB::table($table_name)
                                ->whereRaw('trim(lower("package_name")) like ' . "'" . trim(strtolower($package_post['package_name'])) . "%'")
                                ->first();
                if (count($check_exist) > 0) {
                    return \Response::json(['status'=>false], 200);
                } else {
                    $package_post['created_date_time'] = Carbon::now();
                    $package_post['created_user_id']   = $this->auth->user()->id;
                    $id = InvestigationsPackageMaster::create($package_post)->id;

                    $test_post['package_id']        = $id;
                    $test_post['created_date_time'] = Carbon::now();
                    $test_post['created_user_id']   = $this->auth->user()->id;
                    foreach ($input['test_name'] as $key => $value) {
                        $test_post['test_name']         = $input['test_name'][$key];
                        $test_post['test_status']       = true;
                        \DB::table('mas_investigations_test')->insert($test_post);
                    }
                }
            }
            else
            {
                if ($table_name == 'mas_doctors' && $input['type'] != '3') {
                    $input['Name'] = 'Dr ' . $input['Name'];
                }
                $check_data = $input;
                unset($check_data['status']);
                unset($check_data['Status']);
                unset($check_data['indication_status']);
                unset($check_data['table_name']);
                $check_exist = \DB::table($table_name)
                                ->where(function($query) use ($check_data) {
                                    foreach ($check_data as $key => $value) {
                                        if ($key == 'type') {
                                            $query->where($key, $value);
                                        } else if (($key == 'value' && $value == 0) || ($key == 'status' && ($value == 0 || $value == 1)) || ($key == 'anti_status' && $value == 1)) {
                                            $query->where($key, $value);
                                        } else {
                                            $query->whereRaw('trim(lower("' . $key . '")) like ' . "'" . trim(strtolower($value)) . "%'");                                            
                                        }
                                    }
                                })
                                ->first();
                if (count($check_exist) > 0) {
                    return \Response::json(['status'=>false], 200);
                } else {
                    if ($input['table_name'] == 'mas_drugivfluid' || $input['table_name'] == 'mas_frequency' || $input['table_name'] == 'mas_referral' || $input['table_name'] == 'mas_dose') {
                        $input['date_added'] = Carbon::now();
                        $input['user_added'] = $this->auth->user()->id;                 
                    } else {                    
                        $input['DateAdded'] = Carbon::now();
                        $input['UserAdded'] = $this->auth->user()->id;
                    }
                    unset($input['table_name']);
                    $id = \DB::table($table_name)->insert($input);
                    $id = \DB::getPdo()->lastInsertId();
                }
            }

            $status = false;
            if (isset($input['status']) && ($input['status'] != '0' && $input['status'] != '2' && $input['status'] != 'Inactive')) {
                $status = true;
            } 

            if (isset($input['Status']) && ($input['Status'] != '0' && $input['Status'] != '2' && $input['Status'] != 'Inactive')) {
                $status = true;
            } 

            if (isset($input['indication_status']) && $input['indication_status'] != '0') {
                $status = true;
            } 

            if (isset($input['respiratory_status']) && $input['respiratory_status'] != '0') {
                $status = true;
            }
            if (isset($input['package_status']) && $input['package_status'] != '0') {
                $status = true;
            }

            if ($status) {
                return \Response::json(['status'=>true, 'id'=>$id], 200);               
            } 
            else {
                return \Response::json(['status'=>false, 'id'=>$id], 200);
            }

        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function checkAlreadyExists(Request $request)
    {
        $input = $request->all();

        $table_name         = isset($input['tablename']) ? $input['tablename'] : '';
        $column_name        = isset($input['columnname']) ? $input['columnname'] : '';
        $column_value       = isset($input['columnvalue']) ? $input['columnvalue'] : '';
        $delete_column_name = isset($input['deletecolumnname']) ? $input['deletecolumnname'] : '';
        $sort_by            = isset($input['sortcolumnname']) ? $input['sortcolumnname'] : '';
        $column_name_2      = isset($input['columnname_2']) ? $input['columnname_2'] : '';
        $column_value_2     = isset($input['columnvalue_2']) ? $input['columnvalue_2'] : '';
        $column_name_3      = isset($input['columnname_3']) ? $input['columnname_3'] : '';
        $column_value_3     = isset($input['columnvalue_3']) ? $input['columnvalue_3'] : '';
        $column_name_4      = isset($input['columnname_4']) ? $input['columnname_4'] : '';
        $column_value_4     = isset($input['columnvalue_4']) ? $input['columnvalue_4'] : '';
        $column_name_5      = isset($input['columnname_5']) ? $input['columnname_5'] : '';
        $column_value_5     = isset($input['columnvalue_5']) ? $input['columnvalue_5'] : '';
        $column_name_6      = isset($input['columnname_6']) ? $input['columnname_6'] : '';
        $column_value_6     = isset($input['columnvalue_6']) ? $input['columnvalue_6'] : '';
        $column_name_7      = isset($input['columnname_7']) ? $input['columnname_7'] : '';
        $column_value_7     = isset($input['columnvalue_7']) ? $input['columnvalue_7'] : '';
        $column_name_8      = isset($input['columnname_8']) ? $input['columnname_8'] : '';
        $column_value_8     = isset($input['columnvalue_8']) ? $input['columnvalue_8'] : '';

        $result = \DB::table($table_name)
        ->where(function($query) use ($column_name, $column_value) {
            if ($column_name != '' && $column_value != '') {
                $query->whereRaw('trim(lower("' . $column_name . '")) like ' . "'" . trim(strtolower($column_value)) . "%'");
            }
        })
        ->where(function($query) use ($column_name_2, $column_value_2) {
            if ($column_name_2 != '' && $column_value_2 != '') {
                $query->orWhereRaw('trim(lower("' . $column_name_2 . '")) like ' . "'" . trim(strtolower($column_value_2)) . "%'");
                $query->orWhereNull($column_name_2);
            }
        })
        ->where(function($query) use ($column_name_3, $column_value_3) {
            if ($column_name_3 != '' && $column_value_3 != '') {
                $query->orWhereRaw('trim(lower("' . $column_name_3 . '")) like ' . "'" . trim(strtolower($column_value_3)) . "%'");
                $query->orWhereNull($column_name_3);
            }
        })
        ->where(function($query) use ($column_name_4, $column_value_4) {
            if ($column_name_4 != '' && $column_value_4 != '') {
                $query->orWhereRaw('trim(lower("' . $column_name_4 . '")) like ' . "'" . trim(strtolower($column_value_4)) . "%'");
                $query->orWhereNull($column_name_4);
            }
        })
        ->where(function($query) use ($column_name_5, $column_value_5) {
            if ($column_name_5 != '' && $column_value_5 != '') {
                $query->orWhereRaw('trim(lower("' . $column_name_5 . '")) like ' . "'" . trim(strtolower($column_value_5)) . "%'");
                $query->orWhereNull($column_name_5);
            }
        })
        ->where(function($query) use ($column_name_6, $column_value_6) {
            if ($column_name_6 != '' && $column_value_6 != '') {
                $query->orWhere($column_name_6, $column_value_6);
                $query->orWhereNull($column_name_6);
            }
        })
        ->where(function($query) use ($column_name_7, $column_value_7) {
            if ($column_name_7 != '' && $column_value_7 != '') {
                $query->orWhereRaw('trim(lower("' . $column_name_7 . '")) like ' . "'" . trim(strtolower($column_value_7)) . "%'");
                $query->orWhereNull($column_name_7);
            }
        })
        ->where(function($query) use ($column_name_8, $column_value_8) {
            if ($column_name_8 != '' && $column_value_8 != '') {
                $query->orWhere($column_name_8, $column_value_8);
                $query->orWhereNull($column_name_8);
            }
        })
        ->where(function($query) use ($delete_column_name) {
            if ($delete_column_name != '') {
                $query->where($delete_column_name, '0');
            }
        })
        ->orderBy($sort_by, 'desc')
        ->first();

        if (count($result) > 0) {
            return \Response::json(['status'=>true, 'message'=>'Already exists'], 200);
        } else {
            return \Response::json(['status'=>false, 'message'=>''], 200);
        }

    }

    public function checkBedAlreadyExists(Request $request)
    {
        $input = $request->all();

        $table_name         = isset($input['tablename']) ? $input['tablename'] : '';
        $column_name        = isset($input['columnname']) ? $input['columnname'] : '';
        $column_value       = isset($input['columnvalue']) ? $input['columnvalue'] : '';
        $delete_column_name = isset($input['deletecolumnname']) ? $input['deletecolumnname'] : '';
        $sort_by            = isset($input['sortcolumnname']) ? $input['sortcolumnname'] : '';
        $ward               = isset($input['ward']) ? $input['ward'] : '';
        $roomnumber         = isset($input['roomnumber']) ? $input['roomnumber'] : '';

        $result = \DB::table($table_name)
        ->select('bed.*')
        ->where(function($query) use ($column_name, $column_value, $table_name) {
            if ($column_name != '' && $column_value != '') {
                $query->where($table_name.'.'.$column_name, $column_value);
            }
        })
        ->where(function($query) use ($delete_column_name) {
            if ($delete_column_name != '') {
                $query->where($delete_column_name, '0');
            }
        })
        ->leftjoin('room', 'room.id', '=', $table_name.'.room_id')
        ->leftjoin('ward', 'ward.id', '=', 'room.ward_id')     
        ->where(function($query) use ($table_name, $roomnumber) {
            if ($roomnumber != '') {
                $query->where($table_name.'.room_id', $roomnumber);
            }
        })    
        ->where(function($query) use ($ward) {
            if ($ward != '') {
                $query->where('ward.id', $ward);
            }
        })
        ->orderBy($table_name.'.'.$sort_by, 'desc')
        ->first();

        if (count($result) > 0) {
            return \Response::json(['status'=>true, 'message'=>'Already exists'], 200);
        } else {
            return \Response::json(['status'=>false, 'message'=>''], 200);
        }
    }

    public function checkEditAlreadyExists(Request $request)
    {
        $input = $request->all();

        $table_name         = isset($input['tablename']) ? $input['tablename'] : '';
        $column_name        = isset($input['columnname']) ? $input['columnname'] : '';
        $column_value       = isset($input['columnvalue']) ? $input['columnvalue'] : '';
        $delete_column_name = isset($input['deletecolumnname']) ? $input['deletecolumnname'] : '';
        $sort_by            = isset($input['sortcolumnname']) ? $input['sortcolumnname'] : '';
        $currentId          = isset($input['currentId']) ? $input['currentId'] : '';
        $column_name_2      = isset($input['columnname_2']) ? $input['columnname_2'] : '';
        $column_value_2     = isset($input['columnvalue_2']) ? $input['columnvalue_2'] : '';
        $column_name_3      = isset($input['columnname_3']) ? $input['columnname_3'] : '';
        $column_value_3     = isset($input['columnvalue_3']) ? $input['columnvalue_3'] : '';
        $column_name_4      = isset($input['columnname_4']) ? $input['columnname_4'] : '';
        $column_value_4     = isset($input['columnvalue_4']) ? $input['columnvalue_4'] : '';
        $column_name_5      = isset($input['columnname_5']) ? $input['columnname_5'] : '';
        $column_value_5     = isset($input['columnvalue_5']) ? $input['columnvalue_5'] : '';
        $column_name_6      = isset($input['columnname_6']) ? $input['columnname_6'] : '';
        $column_value_6     = isset($input['columnvalue_6']) ? $input['columnvalue_6'] : '';
        $column_name_7      = isset($input['columnname_7']) ? $input['columnname_7'] : '';
        $column_value_7     = isset($input['columnvalue_7']) ? $input['columnvalue_7'] : '';
        $column_name_8      = isset($input['columnname_8']) ? $input['columnname_8'] : '';
        $column_value_8     = isset($input['columnvalue_8']) ? $input['columnvalue_8'] : '';

        $result = \DB::table($table_name)
        ->where(function($query) use ($column_name, $column_value) {
            if ($column_name != '' && $column_value != '') {
                $query->whereRaw('trim(lower("' . $column_name . '")) like ' . "'" . trim(strtolower($column_value)) . "%'");
            }
        })
        ->where(function($query) use ($column_name_2, $column_value_2) {
            if ($column_name_2 != '' && $column_value_2 != '') {
                $query->orWhereRaw('trim(lower("' . $column_name_2 . '")) like ' . "'" . trim(strtolower($column_value_2)) . "%'");
                $query->orWhereNull($column_name_2);
            }
        })
        ->where(function($query) use ($column_name_3, $column_value_3) {
            if ($column_name_3 != '' && $column_value_3 != '') {
                $query->orWhereRaw('trim(lower("' . $column_name_3 . '")) like ' . "'" . trim(strtolower($column_value_3)) . "%'");
                $query->orWhereNull($column_name_3);
            }
        })
        ->where(function($query) use ($column_name_4, $column_value_4) {
            if ($column_name_4 != '' && $column_value_4 != '') {
                $query->orWhereRaw('trim(lower("' . $column_name_4 . '")) like ' . "'" . trim(strtolower($column_value_4)) . "%'");
                $query->orWhereNull($column_name_4);
            }
        })
        ->where(function($query) use ($column_name_5, $column_value_5) {
            if ($column_name_5 != '' && $column_value_5 != '') {
                $query->orWhereRaw('trim(lower("' . $column_name_5 . '")) like ' . "'" . trim(strtolower($column_value_5)) . "%'");
                $query->orWhereNull($column_name_5);
            }
        })
        ->where(function($query) use ($column_name_6, $column_value_6) {
            if ($column_name_6 != '' && $column_value_6 != '') {
                $query->orWhere($column_name_6, $column_value_6);
                $query->orWhereNull($column_name_6);
            }
        })
        ->where(function($query) use ($column_name_7, $column_value_7) {
            if ($column_name_7 != '' && $column_value_7 != '') {
                $query->orWhereRaw('trim(lower("' . $column_name_7 . '")) like ' . "'" . trim(strtolower($column_value_7)) . "%'");
                $query->orWhereNull($column_name_7);
            }
        })
        ->where(function($query) use ($column_name_8, $column_value_8) {
            if ($column_name_8 != '' && $column_value_8 != '') {
                $query->orWhere($column_name_8, $column_value_8);
                $query->orWhereNull($column_name_8);
            }
        })
        ->where($input['sortcolumnname'], '<>', $currentId)
        ->where(function($query) use ($delete_column_name) {
            if ($delete_column_name != '') {
                $query->where($delete_column_name, '0');
            }
        })
        ->orderBy($table_name.'.'.$sort_by, 'desc')
        ->first();

        if (count($result) > 0) {
            return \Response::json(['status'=>true, 'message'=>'Already exists'], 200);
        } else {
            return \Response::json(['status'=>false, 'message'=>''], 200);
        }
    }

    public function checkEditBedAlreadyExists(Request $request)
    {
        $input = $request->all();

        $table_name         = isset($input['tablename']) ? $input['tablename'] : '';
        $column_name        = isset($input['columnname']) ? $input['columnname'] : '';
        $column_value       = isset($input['columnvalue']) ? $input['columnvalue'] : '';
        $delete_column_name = isset($input['deletecolumnname']) ? $input['deletecolumnname'] : '';
        $sort_by            = isset($input['sortcolumnname']) ? $input['sortcolumnname'] : '';
        $ward               = isset($input['ward']) ? $input['ward'] : '';
        $roomnumber         = isset($input['roomnumber']) ? $input['roomnumber'] : '';
        $currentId          = isset($input['currentId']) ? $input['currentId'] : '';

        $result = \DB::table($table_name)
        ->select('bed.*')
        ->where('bed.room_id', '<>', $currentId)
        ->where(function($query) use ($column_name, $column_value, $table_name) {
            if ($column_name != '' && $column_value != '') {
                $query->where($table_name.'.'.$column_name, $column_value);
            }
        })
        ->where(function($query) use ($delete_column_name) {
            if ($delete_column_name != '') {
                $query->where($delete_column_name, '0');
            }
        })
        ->leftjoin('room', 'room.id', '=', $table_name.'.room_id')
        ->leftjoin('ward', 'ward.id', '=', 'room.ward_id')     
        ->where(function($query) use ($table_name, $roomnumber) {
            if ($roomnumber != '') {
                $query->where($table_name.'.room_id', $roomnumber);
            }
        })    
        ->where(function($query) use ($ward) {
            if ($ward != '') {
                $query->where('ward.id', $ward);
            }
        })
        ->orderBy($table_name.'.'.$sort_by, 'desc')
        ->first();

        if (count($result) > 0) {
            return \Response::json(['status'=>true, 'message'=>'Already exists'], 200);
        } else {
            return \Response::json(['status'=>false, 'message'=>''], 200);
        }
    }

}
