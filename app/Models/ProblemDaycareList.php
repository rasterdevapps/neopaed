<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * All the curd of problem base daycare goes here
 *
 * @author Manikandan M
 */
class ProblemDaycareList extends Model
{

    /**
     *@var $table string
     */
    protected $table = 'pb_daycare_list';

    /**
     *@var $primaryKey string
     */
    protected $primaryKey = 'pb_day_id';

    /**
     *@var $timestamps
     */
    public $timestamps = false;

    /**
     *@var $fillable array
     */
    protected $fillable = ['baby_id', 'mother_id', 'admission_id', 'problem_id', 'IsDeleted', 'UserDeleted', 'DateDeleted'];

    /**
     *This method to fetch the problem base daycare baby list with search
     *
     * @param $page integer
     *
     * @param $limit integer
     *
     * @param $condition array
     *
     * @param $order array
     *
     * @return array of object
     */
    public function GetList($page = 1, $limit = 50, $condition = array() , $order = array() , $slug = '', $status = '')
    {

        $limitstart = (empty($page) || $page == 1) ? 0 : (($page - 1) * $limit);
        $limitend = $limit;
        $search_txt = isset($condition['search_txt']) ? $condition['search_txt'] : '';
        $checkdate = '';

        if (strpos($search_txt, '-') > 0)
        {
            $get_date = strtotime($search_txt);
            $checkdate = (!empty($get_date)) ? date('\'Y-m-d\'', $get_date) : '';
            $search_txt = '';
        }

        $results = \DB::table('baby')->select('baby.BabyId', 'baby.BabyName', 'baby.DOB', 'baby.BabyBloodGroup', 'baby.BMrNo', 'neonatal_proforma.NeonatalId')
            ->leftjoin('neonatal_proforma', 'neonatal_proforma.BabyId', '=', 'baby.BabyId')
            ->whereIn('baby.BabyId', function ($query) use ($status)
        {
            $query->select('BabyId')
                ->from('nicu_admission');
            if ($status == 'inpatient')
            {
                $query->where('status', 'Inpatient');
            }
            elseif ($status == 'discharged')
            {
                $query->where('status', '!=', 'Inpatient');
            }
            //         if (empty($search_txt)) {
            // $query->whereIn('status',['Inpatient']);
            //         }
        $query->where('IsDeleted', 0)
            ->groupby('BabyId')
                ->get()
                ->toArray();
        })->where(function ($query) use ($search_txt, $checkdate)
        {
            if ($search_txt)
            {
                $query->where('BabyName', 'ilike', '%' . trim($search_txt) . '%');
                $query->orwhere('baby.BMrNo', 'ilike', '%' . trim($search_txt) . '%');
                $query->orwhere('BabyBloodGroup', 'ilike', '%' . trim($search_txt) . '%');
            }
            else if ($checkdate)
            {
                $query->whereRaw('"baby"."DOB"::date=' . $checkdate);
            }

        })->where('baby.IsDeleted', 0)
            ->where('neonatal_proforma.IsDeleted', 0);
        if (isset($order['sortby']) && isset($order['sortorder']))
        {
            $results->orderBy($order['sortby'], $order['sortorder']);
        }

        if ($slug)
        {
            $result['total'] = $results->get()
                ->count();
            $result['result'] = $results->limit($limitend)->offset($limitstart)->get();
        }
        else
        {
            $result = $results->limit($limitend)->offset($limitstart)->get();
        }
        return $result;

    }

    /**
     *This method to fetch the problem base daycare baby list count
     *
     *
     * @return integer
     */
    public function GetTotal()
    {
        $results = \DB::table('baby')
        // ->whereIn('baby.BabyId', function ($query) {
        //  $query->select('baby_id')->from('pb_daycare_list')->groupby('baby_id')->get()->toArray();
        // })
        ->whereIn('baby.BabyId', function ($query)
        {
            $query->select('BabyId')
                ->from('nicu_admission')
            //->whereIn('status',['Inpatient','Transferred'])
            
                ->groupby('BabyId')
                ->get()
                ->toArray();
        })
            ->where('baby.IsDeleted', 0)
            ->get();
        return count($results);

    }

    /**
     *This method to fetch the problem base daycare baby list count
     *
     * @param $baby_id integer
     *
     * @return array of object
     */
    public function GetAdmissionList($baby_id)
    {
        $results = \DB::table('baby_admission')->select('baby_admission.AdmissionId', 'baby_admission.BabyId', 'baby_admission.episodes')
            ->addSelect('baby_admission.BMrNo', 'ip_numbers.ip_number', 'baby_admission.AdmissionDate')
            ->addSelect('baby.BabyName')
            ->join('baby', 'baby.BabyId', '=', 'baby_admission.BabyId')
            ->join('nicu_admission', 'nicu_admission.AdmissionId', '=', 'baby_admission.AdmissionId')
            ->leftjoin('ip_numbers', 'ip_numbers.AdmissionId', '=', 'baby_admission.AdmissionId')
            ->where('nicu_admission.IsDeleted', 0)
            ->where('baby.BabyId', $baby_id)->get()
            ->unique('AdmissionId');

        return $results;

    }

    /**
     *This method to fetch the problem episode's
     *
     * @param $baby_id
     *
     * @param $admission_id
     */
    public function GetEpisodesList($baby_id, $admission_id)
    {
        $results = \DB::table('pb_daycare_list')->select(\DB::raw("DISTINCT ON (pd_published.problem_id) pd_published.problem_id") , 'pb_daycare_list.*', 'baby.*', 'pd_published.*')
            ->join('pd_published', 'pd_published.problem_id', '=', 'pb_daycare_list.problem_id')
            ->join('baby', 'baby.BabyId', '=', 'pb_daycare_list.baby_id')
            ->where(['pb_daycare_list.baby_id' => $baby_id, 'pb_daycare_list.admission_id' => $admission_id])->where('pb_daycare_list.IsDeleted', 0)
        // ->orderBy('pb_daycare_list.problem_id', 'asc')
        
            ->get();

        // echo "<pre>"; print_r($results); exit;
        // $results = $results->unique('problem_id')->values()->all();
        $results = $results->values()
            ->all();
        return $results;

    }
    /**
     *This method to fetch the problem episode's
     *
     * @param $limit integer
     *
     * @param $offset integer
     */
    public function GetBabyList($limit, $offset)
    {
        $results = \DB::table('baby')->select('baby.*')
            ->join('baby_admission', 'baby_admission.BabyId', '=', 'baby.BabyId')
            ->join('nicu_admission', 'nicu_admission.BabyId', '=', 'baby.BabyId')
            ->where('nicu_admission.status', '!=', 'Inpatient')
            ->groupby('baby.BabyId')
            ->where(['baby.IsDeleted' => '0'])
            ->orderBy('BabyId', 'desc')
            ->offset($offset)->limit($limit)->get();
        return $results;

    }

    /**
     *This method to fetch the problem episode's
     *
     * @param $baby_id integer
     */
    public function GetAdmissionDetails($baby_id)
    {
        $results = \DB::table('baby_admission')->where(['BabyId' => $baby_id, ])->get();

        return $results;
    }

    /**
     *This method to fetch the problem episode's
     *
     * @param $baby_id integer
     *
     * @param $admissionId integer
     *
     * @param $problem_id integer
     */
    public function GetProblemGroup($baby_id, $admissionId, $problem_id)
    {
        $results = \DB::table('pb_daycare_list')->select('pb_day_id')
            ->where(['baby_id' => $baby_id, 'admission_id' => $admissionId, 'problem_id' => $problem_id])->where('IsDeleted', 0)
            ->first();
        return $results;

    }

    /**
     *This method to fetch the problem episode's
     *The list to episode has many releationship's
     */
    public function GetEpisodes()
    {

        return $this->hasMany('App\Models\ProblemDaycareEpisode', 'pb_day_id', 'pb_day_id')
            ->where('IsDeleted', '0')
            ->orderby('end_date', 'desc');
    }

    /**
     *This method to fetch the problem episode's
     *
     */
    public function GetBabyDetails()
    {
        return $this->belongsTo('App\Models\Baby', 'baby_id', 'BabyId');

    }

    /**
     *This method to fetch the problem episode's
     *
     */
    public function GetProblemList($baby_id, $admissionid)
    {
        $results = \DB::table('pd_published')->select('problem_name', 'problem_id', 'DateModified')
            ->orderby('DateModified', 'desc')
            ->where('problem_status', 1)
            ->groupby('problem_id', 'problem_name', 'DateModified')
            ->get();

        $results = $results->unique('problem_id')
            ->values()
            ->all();
        // $results = $results->values()->all();
        return $results;
    }

    /**
     * This method to fetch the problem episode's
     *
     * @param $baby_id type integer
     * @param $admissionid type integer
     * @param $problem_id type integer
     */
    public function CheckAdmission($baby_id, $admissionid, $problem_id)
    {
        $results = \DB::table('pb_daycare_list')->where(['baby_id' => $baby_id, 'admission_id' => $admissionid, 'problem_id' => $problem_id])->where('IsDeleted', 0)
            ->first();
        return $results;
    }

}

