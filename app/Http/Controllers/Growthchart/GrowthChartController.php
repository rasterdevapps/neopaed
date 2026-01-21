<?php
namespace App\Http\Controllers\Growthchart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Growthchart\GrowthChartSupport;
use Illuminate\Contracts\Auth\Guard;
use App\Models\Baby as Baby;
use App\Http\Controllers\Flow\FlowController;
use App\Exceptions\InvalidInputException;
use App\Models\Neonatal;
use App\Models\Op;
use App\Models\Nicu;
use App\Models\PostnatalDischarge;
use App\Models\Postnatal;
use App\Models\Daycare;
use Carbon\Carbon;

class GrowthChartController extends Controller implements GrowthChartSupport
{

    public function __construct(Guard $auth, FlowController $flow)
    {

        $this->middleware('role:GROWTH_CHART,read', ['only' => ['index', 'GenearateGrowthChart']]);
        $this->auth = $auth;
        $this->flow = $flow;
    }

    public function index(Request $request)
    {

        $limit = 50; // Assign the Page limitation
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

        $order['sortby'] = 'DateAdded';
        $order['sortorder'] = 'desc';

        if (!empty($request->input('sortby')) && !empty($request->input('sortorder')))
        {
            $order['sortby'] = \SiteHelpers::decrypt_id($request->input('sortby'));
            $order['sortorder'] = $request->input('sortorder');
        }

        $search = array();
        $search['search_txt'] = '';
        if (!empty($request->input('search_txt')))
        {
            $search['search_txt'] = $request->input('search_txt');
        }
        // Assing Menu section
        $navigate['main_nav'] = 'growth_chart';
        $navigate['sub_nav'] = 'growth_chart';

        // Get Baby list using Baby models
        $result = Baby::ListDatawithSearch($request->input('page') , $limit, $search, $order, 1);
        $results = $result['result'];

        // Get Total For baby list.
        $getTotal = Baby::GetTotal();
        $total = $result['total'];

        // Set page
        $page = !empty($request->input('page')) ? $request->input('page') : 1;
        $pagecount = (!empty($search['search_txt'])) ? ceil($total / $limit) : ceil($total / $limit);
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

        $incomplete_baby = Baby::check_empty();
        // Assing data to View & define the blade file
        //   $this->flow->clearFlow();
        

        return view('growthchart.growth-baby-lists', compact('results', 'navigate', 'pagination', 'search', 'order', 'getTotal'));

    }

    /*Inner Growth chart for Preterm babies*/
    public function GenearateGrowthChart(Request $request, $id)
    {
        $id = \SiteHelpers::decrypt_id($id);
        if ($id == 0 && $id == '')
        {
            throw new InvalidInputException(\SiteHelpers::getUserExceptionMessage('7004') , 7004);
        }

        $baby_detail = Baby::find($id);
        $neonatal = Neonatal::where('BabyId', $id)->first();
        $boys_weight = $this->GrowthChartValues('WEIGHT', 'MALE');
        $girls_weight = $this->GrowthChartValues('WEIGHT', 'FEMALE');

        $boys_length = $this->GrowthChartValues('LENGTH', 'MALE');
        $girls_length = $this->GrowthChartValues('LENGTH', 'FEMALE');

        $boys_head = $this->GrowthChartValues('HEAD', 'MALE');
        $girls_head = $this->GrowthChartValues('HEAD', 'FEMALE');

        $term_girls_weight = $this->GrowthChartValues('TERM_WEIGHT', 'FEMALE');
        $term_boys_weight = $this->GrowthChartValues('TERM_WEIGHT', 'MALE');

        $term_girls_length = $this->GrowthChartValues('TERM_LENGTH', 'FEMALE');
        $term_boys_length = $this->GrowthChartValues('TERM_LENGTH', 'MALE');

        $term_girls_head = $this->GrowthChartValues('TERM_HEAD', 'FEMALE');
        $term_boys_head = $this->GrowthChartValues('TERM_HEAD', 'MALE');

        $sex = isset($baby_detail->Sex) ? ucfirst(strtolower($baby_detail->Sex)) : '';

        $nicu_admission = $nicu_discharge = Nicu::where('BabyId', $id)->where('IsDeleted', 0)
            ->get();
        $postnatal_discharge = PostnatalDischarge::where('BabyId', $id)->where('IsDeleted', 0)
            ->get();
        $postnatal_admission = Postnatal::where('BabyId', $id)->where('IsDeleted', 0)
            ->get();
        $nicuDaycare = Daycare::where('BabyId', $id)->where('IsDeleted', 0)
            ->get();

        $chart_days_from_daycare = \SiteHelpers::getDaysForChart();

        if (!isset($baby_detail->Sex) || empty($baby_detail->Sex))
        {

            return \Redirect::back()
                ->with('error', 'Gender not selected for this baby');
        }

        $growth_weight = $growth_height = $growth_head = $corrected_age_weight = $corrected_age_height = $corrected_age_head = array();

        $previous_op_all = Op::GetPreviousopAll($id);
        $previous_op_all = $previous_op_all->sortBy('OpDate');
        $last_op_details = $previous_op_all->last();

        $gestation_weeks = isset($baby_detail->Gestation) ? json_decode($baby_detail->Gestation)->g_weeks : null;
        $gestation_days = isset($baby_detail->Gestation) ? json_decode($baby_detail->Gestation)->g_days : 0;

        if (isset($baby_detail->DOB) && isset($last_op_details->OpDate)) {
            $corrected_gestation_weeks = $this->calculateCorrectedGestation($gestation_weeks, $gestation_days, $baby_detail->DOB, $last_op_details->OpDate);
        }

        $corrected_gestation_weeks = isset($corrected_gestation_weeks['corrected_age_weeks']) ? $corrected_gestation_weeks['corrected_age_weeks'] + number_format(($corrected_gestation_weeks['corrected_age_days'] / 7) , 1) : 63;

        if ($gestation_weeks < 37)
        {
            //Birth weight
            if (isset($baby_detail->BirthWeight) && !empty($baby_detail->BirthWeight))
            {

                $growth_weight[] = array(
                    'x7' => $baby_detail->g_weeks + number_format(($baby_detail->g_days / 7) , 1) ,
                    'y7' => number_format($baby_detail->BirthWeight / 1000, 1) ,
                    'value' => number_format($baby_detail->BirthWeight / 1000, 2)
                );
            }
            //Birth length
            if (isset($neonatal->Length) && !empty($neonatal->Length))
            {

                $growth_height[] = array(
                    'x7' => $baby_detail->g_weeks + number_format(($baby_detail->g_days / 7) , 1) ,
                    'y7' => number_format($neonatal->Length, 1) ,
                    'value' => number_format($neonatal->Length, 1)
                );
            }

            //Birth ofc
            if (isset($neonatal->OFC) && !empty($neonatal->OFC))
            {

                $growth_head[] = array(
                    'x7' => $baby_detail->g_weeks + number_format(($baby_detail->g_days / 7) , 1) ,
                    'y7' => number_format($neonatal->OFC, 1) ,
                    'value' => number_format($neonatal->OFC, 1)
                );
            }

            //Op weight, length and head
            foreach ($previous_op_all as $growthchartweight => $growth_value)
            {

                if (isset($baby_detail->DOB) && isset($growth_value->OpDate) && isset($baby_detail->g_weeks))
                {

                    $corrected_gestation = $this->calculateCorrectedGestation($gestation_weeks, $gestation_days, $baby_detail->DOB, $growth_value->OpDate);

                    if (is_array($corrected_gestation))
                    {

                        if (isset($baby_detail->g_days) && $baby_detail->g_days != 0) {
                            $corrected_gestation_plot = $corrected_gestation['corrected_age_weeks'] + $baby_detail->g_weeks + number_format(($baby_detail->g_days / 7) , 1) + number_format(($corrected_gestation['corrected_age_days'] / 7) , 1);
                        } else {
                            $corrected_gestation_plot = $corrected_gestation['corrected_age_weeks'] + $baby_detail->g_weeks + number_format(($corrected_gestation['corrected_age_days'] / 7) , 1);
                        }

                        if ($corrected_gestation_plot <= 64)
                        {

                            if (isset($growth_value->CurrentWt) && !empty($growth_value->CurrentWt))
                            {

                                $growth_weight[] = array(
                                    'x7' => $corrected_gestation_plot,
                                    'y7' => number_format($growth_value->CurrentWt / 1000, 1) ,
                                    'value' => number_format($growth_value->CurrentWt / 1000, 1)
                                );

                            }

                            if (isset($growth_value->CurrentLength) && !empty($growth_value->CurrentLength))
                            {

                                $growth_height[] = array(
                                    'x7' => $corrected_gestation_plot,
                                    'y7' => number_format($growth_value->CurrentLength, 1) ,
                                    'value' => number_format($growth_value->CurrentLength, 1)
                                );

                            }

                            if (isset($growth_value->CurrentOFC) && !empty($growth_value->CurrentOFC))
                            {

                                $growth_head[] = array(
                                    'x7' => $corrected_gestation_plot,
                                    'y7' => number_format($growth_value->CurrentOFC, 1) ,
                                    'value' => number_format($growth_value->CurrentOFC, 1)
                                );

                            }
                        }

                    }
                }

            }

            // nicu admission details
            foreach ($nicu_admission as $nakey => $navalue)
            {
                $corrected_gestation = $this->calculateCorrectedGestation($gestation_weeks, $gestation_days, $baby_detail->DOB, $navalue->AdmissionDate);

                if (is_array($corrected_gestation))
                {

                    $corrected_gestation_plot = $corrected_gestation['corrected_age_weeks'] + number_format(($corrected_gestation['corrected_age_days'] / 7) , 1);

                    if ($corrected_gestation_plot <= 64)
                    {

                        if (isset($navalue->AdmissionWt) && !empty($navalue->AdmissionWt))
                        {

                            $growth_weight[] = array(
                                'x7' => $corrected_gestation_plot,
                                'y7' => number_format($navalue->AdmissionWt / 1000, 1) ,
                                'value' => number_format($navalue->AdmissionWt / 1000, 1)
                            );

                        }

                    }

                }
            }

            // nicu daycare
            foreach ($nicuDaycare as $ndkey => $ndvalue)
            {

                $corrected_gestation = $this->calculateCorrectedGestation($gestation_weeks, $gestation_days, $baby_detail->DOB, $ndvalue->DayDate);

                if (is_array($corrected_gestation) && in_array(date('D', strtotime($ndvalue->DayDate)) , $chart_days_from_daycare))
                {

                    $corrected_gestation_plot = $corrected_gestation['corrected_age_weeks'] + number_format(($corrected_gestation['corrected_age_days'] / 7) , 1);

                    if ($corrected_gestation_plot <= 64)
                    {

                        if (isset($ndvalue->CurrentWt) && !empty($ndvalue->CurrentWt))
                        {

                            $growth_weight[] = array(
                                'x7' => $corrected_gestation_plot,
                                'y7' => number_format($ndvalue->CurrentWt / 1000, 1) ,
                                'value' => number_format($ndvalue->CurrentWt / 1000, 2)
                            );

                        }

                        if (isset($ndvalue->length) && !empty($ndvalue->length))
                        {

                            $growth_height[] = array(
                                'x7' => $corrected_gestation_plot,
                                'y7' => number_format($ndvalue->length, 1) ,
                                'value' => number_format($ndvalue->length, 1)
                            );

                        }

                        if (isset($ndvalue->head_circumference) && !empty($ndvalue->head_circumference))
                        {

                            $growth_head[] = array(
                                'x7' => $corrected_gestation_plot,
                                'y7' => number_format($ndvalue->head_circumference, 1) ,
                                'value' => number_format($ndvalue->head_circumference, 1)
                            );
                        }

                    }

                }
            }

            // postnatal admission detatils
            foreach ($postnatal_admission as $psa_key => $psa_value)
            {

                $corrected_gestation = $this->calculateCorrectedGestation($gestation_weeks, $gestation_days, $baby_detail->DOB, $psa_value->admission_date);

                if (is_array($corrected_gestation))
                {

                    $corrected_gestation_plot = $corrected_gestation['corrected_age_weeks'] + number_format(($corrected_gestation['corrected_age_days'] / 7) , 1);

                    if ($corrected_gestation_plot <= 64)
                    {

                        if (isset($psa_value->admission_wt) && !empty($psa_value->admission_wt))
                        {

                            $growth_weight[] = array(
                                'x7' => $corrected_gestation_plot,
                                'y7' => number_format($psa_value->admission_wt / 1000, 1) ,
                                'value' => number_format($psa_value->admission_wt / 1000, 2)
                            );

                        }

                    }

                }

            }

            //nicu weight, length and head
            foreach ($nicu_discharge as $key => $value)
            {

                $corrected_gestation = $this->calculateCorrectedGestation($gestation_weeks, $gestation_days, $baby_detail->DOB, $value->DischargeDate);

                if (is_array($corrected_gestation))
                {

                    $corrected_gestation_plot = $corrected_gestation['corrected_age_weeks'] + number_format(($corrected_gestation['corrected_age_days'] / 7) , 1);

                    if ($corrected_gestation_plot <= 64)
                    {

                        if (isset($value->DischargeWeight) && !empty($value->DischargeWeight))
                        {

                            $growth_weight[] = array(
                                'x7' => $corrected_gestation_plot,
                                'y7' => number_format($value->DischargeWeight / 1000, 1) ,
                                'value' => number_format($value->DischargeWeight / 1000, 2)
                            );

                        }

                        if (isset($value->Length) && !empty($value->Length))
                        {

                            $growth_height[] = array(
                                'x7' => $corrected_gestation_plot,
                                'y7' => number_format($value->Length, 1) ,
                                'value' => number_format($value->Length, 1)
                            );

                        }

                        if (isset($value->OFC) && !empty($value->OFC))
                        {

                            $growth_head[] = array(
                                'x7' => $corrected_gestation_plot,
                                'y7' => number_format($value->OFC, 1) ,
                                'value' => number_format($value->OFC, 1)
                            );

                        }
                    }
                }

            }

            //postnatal weight, length and head
            foreach ($postnatal_discharge as $key => $postnatal_value)
            {

                $corrected_gestation = $this->calculateCorrectedGestation($gestation_weeks, $gestation_days, $baby_detail->DOB, $postnatal_value->discharge_date);

                if (is_array($corrected_gestation))
                {

                    $corrected_gestation_plot = $corrected_gestation['corrected_age_weeks'] + number_format(($corrected_gestation['corrected_age_days'] / 7) , 1);

                    if ($corrected_gestation_plot <= 64)
                    {

                        if (isset($postnatal_value->discharge_wt) && !empty($postnatal_value->discharge_wt))
                        {

                            $growth_weight[] = array(
                                'x7' => $corrected_gestation_plot,
                                'y7' => number_format($postnatal_value->discharge_wt / 1000, 1) ,
                                'value' => number_format($postnatal_value->discharge_wt / 1000, 2)
                            );

                        }

                        if (isset($postnatal_value->discharge_length) && !empty($postnatal_value->discharge_length))
                        {

                            $growth_height[] = array(
                                'x7' => $corrected_gestation_plot,
                                'y7' => number_format($postnatal_value->discharge_length, 1) ,
                                'value' => number_format($postnatal_value->discharge_length, 1)
                            );

                        }

                        if (isset($postnatal_value->discharge_ofc) && !empty($postnatal_value->discharge_ofc))
                        {

                            $growth_head[] = array(
                                'x7' => $corrected_gestation_plot,
                                'y7' => number_format($postnatal_value->discharge_ofc, 1) ,
                                'value' => number_format($postnatal_value->discharge_ofc, 1)
                            );
                        }

                    }

                }

            }

        }

        $print_style = view('growthchart.growth_print', compact('gestation_weeks', 'corrected_gestation_weeks'))->render();

        $closewinlink = \URL::previous();
        if ($request->get('navigation') == 'growthchartlist')
        {
            $closewinlink = action('Growthchart\GrowthChartController@index');
        }
        $chart_name = "Intergrowth 21st Century Chart";
        $weight_label = "Weight";
        $length_label = "Length";
        $head_label = "Head Circumference";
        return view('growthchart.main', compact('boys_weight', 'corrected_age_head', 'corrected_age_height', 'corrected_age_weight', 'weight_label', 'length_label', 'head_label', 'chart_name', 'corrected_gestation_weeks', 'gestation_weeks', 'term_boys_head', 'term_girls_head', 'term_girls_length', 'term_boys_length', 'term_girls_weight', 'term_boys_weight', 'girls_weight', 'closewinlink', 'print_style', 'girls_head', 'boys_head', 'girls_length', 'boys_length', 'growth_weight', 'growth_height', 'growth_head', 'sex', 'baby_detail'));

    }

    public function GenearateWhoGrowthChart(Request $request, $id)
    {

        if ($id == 0 && $id == '')
        {
            throw new InvalidInputException(\SiteHelpers::getUserExceptionMessage('7004') , 7004);
        }
        $baby_detail = Baby::find($id);
        $neonatal = Neonatal::where('BabyId', $id)->first();
        $boys_weight = $this->GrowthChartValues('WEIGHT', 'MALE');
        $girls_weight = $this->GrowthChartValues('WEIGHT', 'FEMALE');

        $boys_length = $this->GrowthChartValues('LENGTH', 'MALE');
        $girls_length = $this->GrowthChartValues('LENGTH', 'FEMALE');

        $boys_head = $this->GrowthChartValues('HEAD', 'MALE');
        $girls_head = $this->GrowthChartValues('HEAD', 'FEMALE');

        $term_girls_weight = $this->GrowthChartValues('TERM_WEIGHT', 'FEMALE');
        $term_boys_weight = $this->GrowthChartValues('TERM_WEIGHT', 'MALE');

        $term_girls_length = $this->GrowthChartValues('TERM_LENGTH', 'FEMALE');
        $term_boys_length = $this->GrowthChartValues('TERM_LENGTH', 'MALE');

        $term_girls_head = $this->GrowthChartValues('TERM_HEAD', 'FEMALE');
        $term_boys_head = $this->GrowthChartValues('TERM_HEAD', 'MALE');

        $sex = isset($baby_detail->Sex) ? ucfirst(strtolower($baby_detail->Sex)) : '';

        $nicu_admission = $nicu_discharge = Nicu::where('BabyId', $id)->where('IsDeleted', 0)
            ->where('AdmissionWt', '<>', '')
            ->get();
        $postnatal_discharge = PostnatalDischarge::where('BabyId', $id)->where('IsDeleted', 0)
            ->get();
        $postnatal_admission = Postnatal::where('BabyId', $id)->where('IsDeleted', 0)
            ->get();
        $nicuDaycare = Daycare::where('BabyId', $id)->where('IsDeleted', 0)
            ->get();

        $chart_days_from_daycare = \SiteHelpers::getDaysForChart();

        if (!isset($baby_detail->Sex) || empty($baby_detail->Sex))
        {
            throw new InvalidInputException(\SiteHelpers::getUserExceptionMessage('7000') , 7000);
        }

        $growth_weight = $growth_height = $growth_head = $corrected_age_weight = $corrected_age_height = $corrected_age_head = array();

        $previous_op_all = Op::GetPreviousopAll($id);
        $previous_op_all = $previous_op_all->sortBy('OpDate');
        $last_op_details = $previous_op_all->last();

        $corrected_gestation_weeks = (isset($last_op_details->total_corrected_weeks) && isset($baby_detail->g_weeks)) ? $last_op_details->total_corrected_weeks + $baby_detail->g_weeks : 63;

        $gestation_weeks = json_decode($baby_detail->Gestation)->g_weeks;

        if (!$gestation_weeks < 37 && !$corrected_gestation_weeks < 64)
        {

            $baby_detail->g_weeks = $baby_detail->g_weeks / 4;
            $baby_detail->g_days = number_format(($baby_detail->g_days / 7) / 4, 1);

            if (isset($baby_detail->BirthWeight) && !empty($baby_detail->BirthWeight))
            {

                $growth_weight[] = array(
                    'x7' => $baby_detail->g_weeks + $baby_detail->g_days,
                    'y7' => number_format($baby_detail->BirthWeight / 1000, 1) ,
                    'value' => number_format($baby_detail->BirthWeight / 1000, 2)
                );
            }

            if (isset($neonatal->Length) && !empty($neonatal->Length))
            {

                $growth_height[] = array(
                    'x7' => $baby_detail->g_weeks + $baby_detail->g_days,
                    'y7' => number_format($neonatal->Length, 1) ,
                    'value' => number_format($neonatal->Length, 1)
                );
            }

            if (isset($neonatal->OFC) && !empty($neonatal->OFC))
            {

                $growth_head[] = array(
                    'x7' => $baby_detail->g_weeks + $baby_detail->g_days,
                    'y7' => number_format($neonatal->OFC, 1) ,
                    'value' => number_format($neonatal->OFC, 1)
                );
            }

            $premature_days = 0;
            $baby_gestation = !is_null($baby_detail->Gestation) ? json_decode($baby_detail->Gestation) : null;

            if (!is_null($baby_gestation))
            {
                $premature_days = (((40 - $baby_gestation->g_weeks) + 1) * 7) + (7 - $baby_gestation->g_days);

            }

            //Op weight, length and head
            foreach ($previous_op_all as $growthchartweight => $growth_value)
            {

                if (isset($baby_detail->DOB) && isset($growth_value->OpDate))
                {

                    $chronological_age = $this->getChronologicalage($baby_detail->DOB, $growth_value->OpDate);

                    $growth_weight[] = array(
                        'x7' => $chronological_age,
                        'y7' => number_format($growth_value->CurrentWt / 1000, 1) ,
                        'value' => number_format($growth_value->CurrentWt / 1000, 2)
                    );

                    $growth_height[] = array(
                        'x7' => $chronological_age,
                        'y7' => number_format($growth_value->CurrentLength, 1) ,
                        'value' => number_format($growth_value->CurrentLength, 1)
                    );

                    $growth_head[] = array(
                        'x7' => $chronological_age,
                        'y7' => number_format($growth_value->CurrentOFC, 1) ,
                        'value' => number_format($growth_value->CurrentOFC, 1)
                    );

                }
                // This applicable for only premature baby and the corrected age greater than 63 weeks
                if (isset($baby_detail->DOB) && isset($growth_value->OpDate) && $gestation_weeks < 37 && $corrected_gestation_weeks > 64)
                {

                    $birthDate = Carbon::createFromFormat('Y-m-d', $baby_detail->DOB);
                    $opDate = Carbon::createFromFormat('Y-m-d', $growth_value->OpDate);

                    $diffinmonths_day = $birthDate->diffInDays($opDate, true);
                    $diffinmonths_day = $diffinmonths_day - $premature_days;

                    if ($diffinmonths_day > 0)
                    {

                        $corrected_age_month = number_format($diffinmonths_day / 30, 1);

                        $corrected_age_weight[] = array(
                            'x8' => $corrected_age_month,
                            'y8' => number_format($growth_value->CurrentWt / 1000, 1) ,
                            'value' => number_format($growth_value->CurrentWt / 1000, 2)
                        );

                        $corrected_age_height[] = array(
                            'x8' => $corrected_age_month,
                            'y8' => number_format($growth_value->CurrentLength, 1) ,
                            'value' => number_format($growth_value->CurrentLength, 1)
                        );

                        $corrected_age_head[] = array(
                            'x8' => $corrected_age_month,
                            'y8' => number_format($growth_value->CurrentOFC, 1) ,
                            'value' => number_format($growth_value->CurrentOFC, 1)
                        );

                    }
                }

            }

            foreach ($nicu_admission as $nakey => $navalue)
            {

                $growth_weight[] = array(
                    'x7' => $this->getChronologicalage($baby_detail->DOB, $navalue->AdmissionDate) ,
                    'y7' => number_format($navalue->AdmissionWt / 1000, 1) ,
                    'value' => number_format($navalue->AdmissionWt / 1000, 2)
                );

            }

            foreach ($nicuDaycare as $ndkey => $ndvalue)
            {

                if (isset($ndvalue->CGA) && count((array)json_decode($ndvalue->CGA)) == 2 && in_array(date('D', strtotime($ndvalue->DayDate)) , $chart_days_from_daycare))
                {

                    if (isset($ndvalue->CurrentWt) && !empty($ndvalue->CurrentWt) && !is_null($ndvalue->DayDate))
                    {

                        $growth_weight[] = array(
                            'x7' => $this->getChronologicalage($baby_detail->DOB, $ndvalue->DayDate) ,
                            'y7' => number_format($ndvalue->CurrentWt / 1000, 1) ,
                            'value' => number_format($ndvalue->CurrentWt / 1000, 2)
                        );
                    }
                    if (isset($ndvalue->length) && !empty($ndvalue->length))
                    {

                        $growth_height[] = array(
                            'x7' => $this->getChronologicalage($baby_detail->DOB, $ndvalue->DayDate) ,
                            'y7' => number_format($ndvalue->length, 1) ,
                            'value' => number_format($ndvalue->length, 1)
                        );
                    }

                    if (isset($ndvalue->head_circumference) && !empty($ndvalue->head_circumference))
                    {

                        $growth_head[] = array(
                            'x7' => $this->getChronologicalage($baby_detail->DOB, $ndvalue->DayDate) ,
                            'y7' => number_format($ndvalue->head_circumference, 1) ,
                            'value' => number_format($ndvalue->head_circumference, 1)
                        );
                    }
                }

            }

            //nicu weight, length and head
            foreach ($nicu_discharge as $key => $value)
            {

                $chronological_age = $this->getChronologicalage($baby_detail->DOB, $value->DischargeDate);

                if (isset($value->DischargeWeight) && !empty($value->DischargeWeight))
                {

                    $growth_weight[] = array(
                        'x7' => $chronological_age,
                        'y7' => number_format($value->DischargeWeight / 1000, 1) ,
                        'value' => number_format($value->DischargeWeight / 1000, 2)
                    );

                }

                if (isset($value->Length) && !empty($value->Length))
                {

                    $growth_height[] = array(
                        'x7' => $chronological_age,
                        'y7' => number_format($value->Length, 1) ,
                        'value' => number_format($value->Length, 1)
                    );
                }

                if (isset($value->OFC) && !empty($value->OFC))
                {

                    $growth_head[] = array(
                        'x7' => $chronological_age,
                        'y7' => number_format($value->OFC, 1) ,
                        'value' => number_format($value->OFC, 1)
                    );
                }

            }

            foreach ($postnatal_discharge as $key => $postnatal_value)
            {

                if (!empty($postnatal_value->discharge_date))
                {
                    $chronological_age = $this->getChronologicalage($baby_detail->DOB, $postnatal_value->discharge_date);

                    if (isset($postnatal_value->discharge_wt) && !empty($postnatal_value->discharge_wt))
                    {

                        $growth_weight[] = array(
                            'x7' => $chronological_age,
                            'y7' => number_format($postnatal_value->discharge_wt / 1000, 1) ,
                            'value' => number_format($postnatal_value->discharge_wt / 1000, 2)
                        );
                    }

                    if (isset($postnatal_value->discharge_length) && !empty($postnatal_value->discharge_length))
                    {

                        $growth_height[] = array(
                            'x7' => $chronological_age,
                            'y7' => number_format($postnatal_value->discharge_length, 1) ,
                            'value' => number_format($postnatal_value->discharge_length, 2)
                        );
                    }

                    if (isset($postnatal_value->discharge_ofc) && !empty($postnatal_value->discharge_ofc))
                    {

                        $growth_head[] = array(
                            'x7' => $chronological_age,
                            'y7' => number_format($postnatal_value->discharge_ofc, 1) ,
                            'value' => number_format($postnatal_value->discharge_ofc, 1)
                        );
                    }
                }

            }
        }

        $print_style = view('growthchart.who_growth_print', compact('gestation_weeks', 'corrected_gestation_weeks'))->render();

        $closewinlink = \URL::previous();
        $chart_name = "WHO Growth Chart";
        $weight_label = "Weight";
        $length_label = "Length";
        $head_label = "Head Circumference";

        return view('growthchart.whochart', compact('boys_weight', 'corrected_age_head', 'corrected_age_height', 'corrected_age_weight', 'weight_label', 'length_label', 'head_label', 'chart_name', 'corrected_gestation_weeks', 'gestation_weeks', 'term_boys_head', 'term_girls_head', 'term_girls_length', 'term_boys_length', 'term_girls_weight', 'term_boys_weight', 'girls_weight', 'closewinlink', 'print_style', 'girls_head', 'boys_head', 'girls_length', 'boys_length', 'growth_weight', 'growth_height', 'growth_head', 'sex', 'baby_detail'));

    }

    public function growthwhochartzerotofiveyears($baby_id)
    {
        $baby_id = \SiteHelpers::decrypt_id($baby_id);

        $baby = Baby::find($baby_id);
        if (empty($baby->Gestation) || is_null($baby->Gestation)) {
            return redirect()->back()->with('error', 'Baby Gestation is empty...!');   
        }
        $neonatal = Neonatal::where('BabyId', $baby_id)->first();
        $chart_name = "WHO Growth Chart";
        $weight_label = "Weight";
        $length_label = "Length";
        $head_label = "Head Circumference";

        $boys_weight = $this->WhoGrowthChartValues('WEIGHT', 'MALE');
        $girls_weight = $this->WhoGrowthChartValues('WEIGHT', 'FEMALE');

        $boys_length = $this->WhoGrowthChartValues('LENGTH', 'MALE');
        $girls_length = $this->WhoGrowthChartValues('LENGTH', 'FEMALE');

        $boys_head = $this->WhoGrowthChartValues('HEAD', 'MALE');
        $girls_head = $this->WhoGrowthChartValues('HEAD', 'FEMALE');
        $growth_weight = $growth_height = $growth_head = $corrected_age_weight = $corrected_age_height = $corrected_age_head = array();
        $sex = isset($baby->Sex) ? ucfirst(strtolower($baby->Sex)) : '';

        $nicu_admission = $nicu_discharge = Nicu::where('BabyId', $baby_id)->where('IsDeleted', 0)
            ->where('AdmissionWt', '<>', '')
            ->get();
        $nicuDaycare = Daycare::where('BabyId', $baby_id)->where('IsDeleted', 0)
            ->get();
        $chart_days_from_daycare = \SiteHelpers::getDaysForChart();
        $postnatal_discharge = PostnatalDischarge::where('BabyId', $baby_id)->where('IsDeleted', 0)
            ->get();

        $previous_op_all = Op::GetPreviousopAll($baby_id);
        $previous_op_all = $previous_op_all->sortBy('OpDate');
        $last_op_details = $previous_op_all->last();

        $gestation_weeks = isset($baby->Gestation) ? json_decode($baby->Gestation)->g_weeks : null;
        $gestation_days = isset($baby->Gestation) ? json_decode($baby->Gestation)->g_days : null;

        if (isset($baby->DOB) && isset($last_op_details->OpDate)) {
         $corrected_gestation_weeks = $this->calculateCorrectedGestation($gestation_weeks, $gestation_days, $baby->DOB, $last_op_details->OpDate);
        }

        $corrected_gestation_weeks = isset($corrected_gestation_weeks['corrected_age_weeks']) ? $corrected_gestation_weeks['corrected_age_weeks'] + number_format(($corrected_gestation_weeks['corrected_age_days'] / 7) , 1) : 63;

        $premature_days = 0;

        $baby_gestation = !is_null($baby->Gestation) ? json_decode($baby->Gestation) : null;

        if (!is_null($baby_gestation) && $baby_gestation->g_weeks > 36)
        {
            $premature_days = (((40 - $baby_gestation->g_weeks) + 1) * 7);
            if (!empty($baby_gestation->g_days))
            {
                $premature_days = $premature_days + (7 - $baby_gestation->g_days);
            }

        }

        $baby->g_weeks = $baby->g_weeks / 4;
        $baby->g_days = number_format(($baby->g_days / 7) / 4, 1);

        if ($gestation_weeks >= 37 || ($corrected_gestation_weeks > 64 && $gestation_weeks < 37))
        {

            if ($gestation_weeks >= 37)
            {

                if (isset($baby->BirthWeight) && !empty($baby->BirthWeight))
                {
                    if ($gestation_weeks > 36)
                    {
                        $corrected_age_weight[] = array(
                            'x8' => '0.1',
                            'y8' => number_format($baby->BirthWeight / 1000, 1) ,
                            'value' => number_format($baby->BirthWeight / 1000, 2)
                        );
                    }
                }

                if (isset($neonatal->Length) && !empty($neonatal->Length))
                {

                    if ($gestation_weeks > 36)
                    {
                        $corrected_age_height[] = array(
                            'x8' => '0.1',
                            'y8' => number_format($neonatal->Length, 1) ,
                            'value' => number_format($neonatal->Length, 1)
                        );
                    }
                }

                if (isset($neonatal->OFC) && !empty($neonatal->OFC))
                {

                    if ($gestation_weeks > 36)
                    {
                        $corrected_age_head[] = array(
                            'x8' => '0.1',
                            'y8' => number_format($neonatal->OFC, 1) ,
                            'value' => number_format($neonatal->OFC, 1)
                        );
                    }
                }
            }
            else
            {

                if (isset($baby->BirthWeight) && !empty($baby->BirthWeight))
                {
                    if ($gestation_weeks > 36)
                    {
                        $corrected_age_weight[] = array(
                            'x8' => $baby->g_weeks + $baby->g_days,
                            'y8' => number_format($baby->BirthWeight / 1000, 1) ,
                            'value' => number_format($baby->BirthWeight / 1000, 2)
                        );
                    }
                }

                if (isset($neonatal->Length) && !empty($neonatal->Length))
                {

                    if ($gestation_weeks > 36)
                    {
                        $corrected_age_height[] = array(
                            'x8' => $baby->g_weeks + $baby->g_days,
                            'y8' => number_format($neonatal->Length, 1) ,
                            'value' => number_format($neonatal->Length, 1)
                        );
                    }
                }

                if (isset($neonatal->OFC) && !empty($neonatal->OFC))
                {

                    if ($gestation_weeks > 36)
                    {
                        $corrected_age_head[] = array(
                            'x8' => $baby->g_weeks + $baby->g_days,
                            'y8' => number_format($neonatal->OFC, 1) ,
                            'value' => number_format($neonatal->OFC, 1)
                        );
                    }
                }

            }
            foreach ($previous_op_all as $growthchartweight => $growth_value)
            {
                if (isset($baby->DOB) && isset($growth_value->OpDate))
                {

                    if ($gestation_weeks > 36)
                    {

                        $corrected_age_month = $this->getChronologicalage($baby->DOB, $growth_value->OpDate);

                        if ($corrected_age_month > 0)
                        {
                            if (isset($growth_value->CurrentWt) && !empty($growth_value->CurrentWt))
                            {

                                $corrected_age_weight[] = array(
                                    'x8' => $corrected_age_month,
                                    'y8' => number_format($growth_value->CurrentWt / 1000, 1) ,
                                    'value' => number_format($growth_value->CurrentWt / 1000, 2)
                                );

                            }

                            if (isset($growth_value->CurrentLength) && !empty($growth_value->CurrentLength))
                            {

                                $corrected_age_height[] = array(
                                    'x8' => $corrected_age_month,
                                    'y8' => number_format($growth_value->CurrentLength, 1) ,
                                    'value' => number_format($growth_value->CurrentLength, 1)
                                );

                            }

                            if (isset($growth_value->CurrentOFC) && !empty($growth_value->CurrentOFC))
                            {

                                $corrected_age_head[] = array(
                                    'x8' => $corrected_age_month,
                                    'y8' => number_format($growth_value->CurrentOFC, 1) ,
                                    'value' => number_format($growth_value->CurrentOFC, 1)
                                );

                            }

                        }
                    }
                    else
                    {
                        $corrected_age = $this->calculateCorrectedGestation($gestation_weeks, $gestation_days, $baby->DOB, $growth_value->OpDate);

                        $corrected_age_weeks = $corrected_age['corrected_age_weeks'] + number_format(($corrected_age['corrected_age_days'] / 7) , 1);

                        if ($corrected_age_weeks > 64)
                        {

                            $corrected_age_month = $this->calculateCorrectedAge($gestation_weeks, $gestation_days, $baby->DOB, $growth_value->OpDate);

                            $corrected_age_month = $corrected_age_month['corrected_age_in_months'];

                            if (isset($growth_value->CurrentWt) && !empty($growth_value->CurrentWt))
                            {

                                $corrected_age_weight[] = array(
                                    'x8' => $corrected_age_month,
                                    'y8' => number_format($growth_value->CurrentWt / 1000, 1) ,
                                    'value' => number_format($growth_value->CurrentWt / 1000, 2)
                                );

                            }

                            if (isset($growth_value->CurrentLength) && !empty($growth_value->CurrentLength))
                            {

                                $corrected_age_height[] = array(
                                    'x8' => $corrected_age_month,
                                    'y8' => number_format($growth_value->CurrentLength, 1) ,
                                    'value' => number_format($growth_value->CurrentLength, 1)
                                );

                            }

                            if (isset($growth_value->CurrentOFC) && !empty($growth_value->CurrentOFC))
                            {

                                $corrected_age_head[] = array(
                                    'x8' => $corrected_age_month,
                                    'y8' => number_format($growth_value->CurrentOFC, 1) ,
                                    'value' => number_format($growth_value->CurrentOFC, 1)
                                );

                            }
                        }
                    }
                }
            }

            foreach ($nicu_admission as $nakey => $navalue)
            {
                if (isset($navalue->AdmissionDate) && !empty($navalue->AdmissionDate) && !is_null($navalue->AdmissionDate))

                if ($gestation_weeks > 36)
                {

                    if (isset($navalue->AdmissionWt) && !empty($navalue->AdmissionWt))
                    {

                        $corrected_age_weight[] = array(
                            'x8' => $this->getChronologicalage($baby->DOB, $navalue->AdmissionDate) ,
                            'y8' => number_format($navalue->AdmissionWt / 1000, 1) ,
                            'value' => number_format($navalue->AdmissionWt / 1000, 2)
                        );

                    }
                }
                else
                {
                    $corrected_age = $this->calculateCorrectedGestation($gestation_weeks, $gestation_days, $baby->DOB, $navalue->AdmissionDate);

                    $corrected_age_weeks = $corrected_age['corrected_age_weeks'] + number_format(($corrected_age['corrected_age_days'] / 7) , 1);

                    if ($corrected_age_weeks > 64)
                    {

                        if (isset($navalue->AdmissionWt) && !empty($navalue->AdmissionWt))
                        {
                            
                            $corrected_age_month = $this->calculateCorrectedAge($gestation_weeks, $gestation_days, $baby->DOB, $growth_value->OpDate);

                            $corrected_age_month = $corrected_age_month['corrected_age_in_months'];
                            $corrected_age_month = number_format(($corrected_age_month / 4), 1);

                            $corrected_age_weight[] = array(
                                'x8' => $corrected_age_month,
                                'y8' => number_format($navalue->AdmissionWt / 1000, 1) ,
                                'value' => number_format($navalue->AdmissionWt / 1000, 2)
                            );

                        }

                    }
                }
            }
        }

        foreach ($nicuDaycare as $ndkey => $ndvalue)
        {

            if (in_array(date('D', strtotime($ndvalue->DayDate)) , $chart_days_from_daycare))
            {
                if ($gestation_weeks > 36)
                {
                    if (isset($ndvalue->CurrentWt) && !empty($ndvalue->CurrentWt) && !is_null($ndvalue->DayDate))
                    {
                        $corrected_age_weight[] = array(
                            'x8' => $this->getChronologicalage($baby->DOB, $ndvalue->DayDate) ,
                            'y8' => number_format($ndvalue->CurrentWt / 1000, 1) ,
                            'value' => number_format($ndvalue->CurrentWt / 1000, 2)
                        );

                    }

                    if (isset($ndvalue->length) && !empty($ndvalue->length))
                    {

                        $corrected_age_height[] = array(
                            'x8' => $this->getChronologicalage($baby->DOB, $ndvalue->DayDate),
                            'y8' => number_format($ndvalue->length, 1) ,
                            'value' => number_format($ndvalue->length, 2)
                        );
                    }

                    if (isset($ndvalue->head_circumference) && !empty($ndvalue->head_circumference))
                    {

                        $corrected_age_head[] = array(
                            'x8' => $this->getChronologicalage($baby->DOB, $ndvalue->DayDate),
                            'y8' => number_format($ndvalue->head_circumference, 1) ,
                            'value' => number_format($ndvalue->head_circumference, 1)
                        );
                    }
                }
                else
                {
                    $corrected_age = $this->calculateCorrectedGestation($gestation_weeks, $gestation_days, $baby->DOB, $ndvalue->DayDate);

                    $corrected_age_weeks = $corrected_age['corrected_age_weeks'] + number_format(($corrected_age['corrected_age_days'] / 7) , 1);

                    if ($corrected_age_weeks > 64)
                    {

                        $corrected_age_month = $this->calculateCorrectedAge($gestation_weeks, $gestation_days, $baby->DOB, $ndvalue->DayDate);

                        $corrected_age_month = $corrected_age_month['corrected_age_in_months'];
                        $corrected_age_month = number_format(($corrected_age_month / 4), 1);

                        if (isset($ndvalue->CurrentWt) && !empty($ndvalue->CurrentWt)) {
                            $corrected_age_weight[] = array(
                                'x8' => $corrected_age_month,
                                'y8' => number_format($ndvalue->CurrentWt / 1000, 1) ,
                                'value' => number_format($ndvalue->CurrentWt / 1000, 2)
                            );
                        }

                        if (isset($ndvalue->length) && !empty($ndvalue->length))
                        {

                            $corrected_age_height[] = array(
                                'x8' => $corrected_age_month,
                                'y8' => number_format($ndvalue->length, 1) ,
                                'value' => number_format($ndvalue->length, 2)
                            );
                        }

                        if (isset($ndvalue->head_circumference) && !empty($ndvalue->head_circumference))
                        {

                            $corrected_age_head[] = array(
                                'x8' => $corrected_age_month,
                                'y8' => number_format($ndvalue->head_circumference, 1) ,
                                'value' => number_format($ndvalue->head_circumference, 1)
                            );
                        }
                    }
                }
            }
        }

        //nicu weight, length and head
        foreach ($nicu_discharge as $key => $value)
        {
            if (isset($value->DischargeDate) && !empty($value->DischargeDate) && !is_null($value->DischargeDate))
            {
                if ($gestation_weeks > 36)
                {
                    $chronological_age = $this->getChronologicalage($baby->DOB, $value->DischargeDate);
                    if (isset($value->DischargeWeight) && !empty($value->DischargeWeight))
                    {

                        $corrected_age_weight[] = array(
                            'x8' => $chronological_age,
                            'y8' => number_format($value->DischargeWeight / 1000, 1) ,
                            'value' => number_format($value->DischargeWeight / 1000, 2)
                        );

                    }

                    if (isset($value->Length) && !empty($value->Length))
                    {

                        $corrected_age_height[] = array(
                            'x8' => $chronological_age,
                            'y8' => number_format($value->Length, 1) ,
                            'value' => number_format($value->Length, 2)
                        );
                    }

                    if (isset($value->OFC) && !empty($value->OFC))
                    {

                        $corrected_age_head[] = array(
                            'x8' => $chronological_age,
                            'y8' => number_format($value->OFC, 1) ,
                            'value' => number_format($value->OFC, 1)
                        );
                    }
                }
                else
                {
                    $corrected_age = $this->calculateCorrectedGestation($gestation_weeks, $gestation_days, $baby->DOB, $value->DischargeDate);

                    $corrected_age_weeks = $corrected_age['corrected_age_weeks'] + number_format(($corrected_age['corrected_age_days'] / 7) , 1);

                    if ($corrected_age_weeks > 64)
                    {
                    
                        $corrected_age_month = $this->calculateCorrectedAge($gestation_weeks, $gestation_days, $baby->DOB, $value->DischargeDate);

                        $corrected_age_month = $corrected_age_month['corrected_age_in_months'];
                        $corrected_age_month = number_format(($corrected_age_month / 4), 1);

                        if (isset($value->DischargeWeight) && !empty($value->DischargeWeight))
                        {

                            $corrected_age_weight[] = array(
                                'x8' => $corrected_age_month,
                                'y8' => number_format($value->DischargeWeight / 1000, 1) ,
                                'value' => number_format($value->DischargeWeight / 1000, 2)
                            );

                        }

                        if (isset($value->Length) && !empty($value->Length))
                        {

                            $corrected_age_height[] = array(
                                'x8' => $corrected_age_month,
                                'y8' => number_format($value->Length, 1) ,
                                'value' => number_format($value->Length, 2)
                            );
                        }

                        if (isset($value->OFC) && !empty($value->OFC))
                        {

                            $corrected_age_head[] = array(
                                'x8' => $corrected_age_month,
                                'y8' => number_format($value->OFC, 1) ,
                                'value' => number_format($value->OFC, 1)
                            );
                        }

                    }
                }

            }

        }

        foreach ($postnatal_discharge as $key => $postnatal_value)
        {
            if (isset($postnatal_value->discharge_date) && !is_null($postnatal_value->discharge_date) && !empty($postnatal_value->discharge_date))
            {
                if ($gestation_weeks > 36)
                {
                    $chronological_age = $this->getChronologicalage($baby->DOB, $postnatal_value->discharge_date);

                    if (isset($postnatal_value->discharge_wt) && !empty($postnatal_value->discharge_wt))
                    {

                        $corrected_age_weight[] = array(
                            'x8' => $chronological_age,
                            'y8' => number_format($postnatal_value->discharge_wt / 1000, 1) ,
                            'value' => number_format($postnatal_value->discharge_wt / 1000, 2)
                        );
                    }

                    if (isset($postnatal_value->discharge_length) && !empty($postnatal_value->discharge_length))
                    {

                        $corrected_age_height[] = array(
                            'x8' => $chronological_age,
                            'y8' => number_format($postnatal_value->discharge_length, 1) ,
                            'value' => number_format($postnatal_value->discharge_length, 1)
                        );
                    }

                    if (isset($postnatal_value->discharge_ofc) && !empty($postnatal_value->discharge_ofc))
                    {

                        $corrected_age_head[] = array(
                            'x8' => $chronological_age,
                            'y8' => number_format($postnatal_value->discharge_ofc, 1) ,
                            'value' => number_format($postnatal_value->discharge_ofc, 1)
                        );
                    }
                }
                else
                {
                    $corrected_age = $this->calculateCorrectedGestation($gestation_weeks, $gestation_days, $baby->DOB, $postnatal_value->discharge_date);

                    $corrected_age_weeks = $corrected_age['corrected_age_weeks'] + number_format(($corrected_age['corrected_age_days'] / 7) , 1);

                    if ($corrected_age_weeks > 64)
                    {

                        $corrected_age_month = $this->calculateCorrectedAge($gestation_weeks, $gestation_days, $baby->DOB, $postnatal_value->discharge_date);

                        $corrected_age_month = $corrected_age_month['corrected_age_in_months'];
                        $corrected_age_month = number_format(($corrected_age_month / 4), 1);

                        if (isset($postnatal_value->discharge_wt) && !empty($postnatal_value->discharge_wt))
                        {

                            $corrected_age_weight[] = array(
                                'x8' => $chronological_age,
                                'y8' => number_format($postnatal_value->discharge_wt / 1000, 1) ,
                                'value' => number_format($postnatal_value->discharge_wt / 1000, 2)
                            );
                        }

                        if (isset($postnatal_value->discharge_length) && !empty($postnatal_value->discharge_length))
                        {

                            $corrected_age_height[] = array(
                                'x8' => $chronological_age,
                                'y8' => number_format($postnatal_value->discharge_length, 1) ,
                                'value' => number_format($postnatal_value->discharge_length, 1)
                            );
                        }
                        if (isset($postnatal_value->discharge_ofc) && !empty($postnatal_value->discharge_ofc))
                        {
                            $corrected_age_head[] = array(
                                'x8' => $corrected_age_month,
                                'y8' => number_format($postnatal_value->discharge_ofc, 1) ,
                                'value' => number_format($postnatal_value->discharge_ofc, 1)
                            );
                        }
                    }

                }
            }

        }
        $closewinlink = \URL::previous();

        $chart_name = 'WHO Growth Chart - Birth to Five Years';
        return view('growthchart.whozerotofive', compact('baby', 'weight_label', 'length_label', 'head_label', 'boys_head', 'girls_head', 'growth_head', 'corrected_age_head', 'sex', 'boys_weight', 'girls_weight', 'corrected_age_weight', 'boys_length', 'girls_length', 'corrected_age_height', 'chart_name', 'closewinlink'));
    }

    private function WhoGrowthChartValues($type = '', $gender = '')
    {

        switch ($type)
        {
            case 'WEIGHT':

                if ($gender == 'MALE')
                {

                    $result = GrowthChartSupport::WHO_CHART_BOYS_WEIGHT;

                }
                elseif ($gender == 'FEMALE')
                {

                    $result = GrowthChartSupport::WHO_CHART_GIRLS_WEIGHT;

                }

            break;

            case 'LENGTH':

                if ($gender == 'MALE')
                {

                    $result = GrowthChartSupport::BOYS_CHART_LENGTH_DATA;

                }
                elseif ($gender == 'FEMALE')
                {

                    $result = GrowthChartSupport::GIRLS_CHART_LENGTH_DATA;

                }

            break;

            case 'HEAD':

                if ($gender == 'MALE')
                {

                    $result = GrowthChartSupport::WHO_CHART_BOYS_HEAD;

                }
                elseif ($gender == 'FEMALE')
                {

                    $result = GrowthChartSupport::WHO_CHART_GIRLS_HEAD;

                }

            break;

            default:

            break;
        }

        return $result = json_encode($result);

    }

    private function GrowthChartValues($type = '', $gender = '')
    {

        switch ($type)
        {
            case 'WEIGHT':

                if ($gender == 'MALE')
                {

                    $result = GrowthChartSupport::BOYS_CHART_WEIGHT_DATA;

                }
                elseif ($gender == 'FEMALE')
                {

                    $result = GrowthChartSupport::GIRLS_CHART_WEIGHT_DATA;

                }

            break;

            case 'LENGTH':

                if ($gender == 'MALE')
                {

                    $result = GrowthChartSupport::BOYS_CHART_LENGTH_DATA;

                }
                elseif ($gender == 'FEMALE')
                {

                    $result = GrowthChartSupport::GIRLS_CHART_LENGTH_DATA;

                }

            break;

            case 'HEAD':

                if ($gender == 'MALE')
                {

                    $result = GrowthChartSupport::BOYS_CHART_HEAD_DATA;

                }
                elseif ($gender == 'FEMALE')
                {

                    $result = GrowthChartSupport::GIRLS_CHART_HEAD_DATA;

                }

            break;

            case 'TERM_WEIGHT':

                if ($gender == 'MALE')
                {

                    $result = GrowthChartSupport::TERM_CHART_BOYS_WEIGHT;

                }
                elseif ($gender == 'FEMALE')
                {

                    $result = GrowthChartSupport::GROWTH_CHART_TERM_GIRL_WEIGHT;

                }

            break;

            case 'TERM_LENGTH':

                if ($gender == 'MALE')
                {

                    $result = GrowthChartSupport::TERM_CHART_BOYS_LENGTH;

                }
                elseif ($gender == 'FEMALE')
                {

                    $result = GrowthChartSupport::TERM_CHART_GIRL_LENGTH;

                }

            break;

            case 'TERM_HEAD':

                if ($gender == 'MALE')
                {

                    $result = GrowthChartSupport::TERM_CHART_BOYS_HEAD;

                }
                elseif ($gender == 'FEMALE')
                {

                    $result = GrowthChartSupport::TERM_CHART_GIRL_HEAD;

                }

            break;

            default:

            break;
        }

        return $result = json_encode($result);

    }

    /**
     * This method to calulate the chronological age in months
     * between birth to given date
     *
     * @param $start_date type date
     * @param $end_date type date
     *
     * @return type decimal or integer
     */
    private function getChronologicalage($start_date, $end_date)
    {
        $baby_dob = Carbon::createFromFormat('Y-m-d', $start_date);
        $day_date = Carbon::createFromFormat('Y-m-d', $end_date);

        $diffinmonths_day = $baby_dob->diff($day_date)->format('%y,%m,%d');

        $diffinmonths_day = explode(',', $diffinmonths_day);
        $diffinmonths_year = $diffinmonths_day[0] * 12;
        $diffinmonth = $diffinmonths_day[1] + $diffinmonths_year;
        $diffinmonths_day = ($diffinmonths_day[2] == 0) ? $diffinmonth + $diffinmonths_day[2] : number_format($diffinmonth + ($diffinmonths_day[2] / 30) , 1);
        return $diffinmonths_day;

    }

    /**
     * This method to calulate the corrected age in weeks and days
     * between birth to given date
     *
     * @param $gestation_weeks type date
     * @param $gestation_days type date
     *
     * @return type array
     */
    private function calculateCorrectedAge($gestation_weeks, $gestation_days, $dob, $calculate_date)
    {
        if ($gestation_weeks != '' && $dob != '' && $calculate_date != '')
        {
            
            $gestation_days = ($gestation_days == '' || $gestation_days == 0) ? 0 : $gestation_days;
            $total_days_to_subtract = ((40 - $gestation_weeks) * 7) + $gestation_days;

            $dob = strtotime($dob); // or your date as well
            $current_date = strtotime($calculate_date);
            $datediff = $current_date - $dob;
            $chronological_age_days = $datediff / (60 * 60 * 24);
            
            $corrected_age = $chronological_age_days - $total_days_to_subtract;

            $formatted_total_days_to_subtract = '-'.$total_days_to_subtract.' days';
            $calculated_days = strtotime($formatted_total_days_to_subtract, $current_date);
            $monthdiff = $calculated_days - $dob;
            $corrected_age_in_months = $monthdiff / (60 * 60 * 24 * 30);

            if ($corrected_age > 0)
            {
                return array(
                    'corrected_age_weeks' => intval($corrected_age / 7) ,
                    'corrected_age_days' => $corrected_age % 7,
                    'corrected_age_in_months' => number_format($corrected_age_in_months, 1)
                );
            }
            else
            {
                return array(
                    'corrected_age_weeks' => 0,
                    'corrected_age_days' => 0,
                    'corrected_age_in_months' => 0,
                );
            }
        }
        else
        {
            return array(
                'corrected_age_weeks' => 0,
                'corrected_age_days' => 0,
                'corrected_age_in_months' => 0,
            );
        }

    }

    private function calculateCorrectedGestation($gestation_weeks, $gestation_days, $dob, $calculate_date)
    {
        if ($gestation_weeks != '' && $dob != '' && $calculate_date != '')
        {
            if ($gestation_days == '' || $gestation_days == 0) {
                $gestation_days = 0;
            }
            $dob = strtotime($dob); // or your date as well
            $current_date = strtotime($calculate_date);
            $datediff = $current_date - $dob;
            $chronological_age_days = $datediff / (60 * 60 * 24);

            $corrected_age = $chronological_age_days + ($gestation_weeks * 7) + $gestation_days;

            if ($corrected_age > 0)
            {
                return array(
                    'corrected_age_weeks' => intval($corrected_age / 7) ,
                    'corrected_age_days' => $corrected_age % 7,
                );
            }
            else
            {
                return array(
                    'corrected_age_weeks' => 0,
                    'corrected_age_days' => 0,
                );
            }
        }
        else
        {
            return array(
                'corrected_age_weeks' => 0,
                'corrected_age_days' => 0,
            );
        }

    }

}

