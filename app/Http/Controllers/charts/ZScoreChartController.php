<?php
namespace App\Http\Controllers\charts;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Baby;
use App\Models\Neonatal;
use App\Models\Nicu;
use App\Models\Daycare;
use App\Models\PostnatalDischarge;
use App\Models\Op;
use App\Models\Oppediatric;
use App\Models\Pediatric;
use Carbon\Carbon;
use App\Models\NeuroVisit;

class ZScoreChartController extends Controller
{
    /**
     * Display a 0 to 5 chart.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $baby_id = $request->get('baby_id');




        $baby_id = \SiteHelpers::decrypt_id($baby_id);

        // echo "<pre>"; print_r($baby_id); exit;

        $baby = Baby::find($baby_id);

        if (empty($baby->Sex) || is_null($baby->Sex) || $baby->Sex == 'UNKNOWN')
        {
            return redirect()
            ->back()
            ->with('error', 'Baby Gender is empty...!');
        }

        $zscore = \DB::table('growth_chart_percentiles')->select('id', 'month_wise_age','chart_type', 'year', 'month', 'sd_3_neg', 'sd_2_neg', 'sd_1_neg', 'sd_0','sd_1','sd_2','sd_3', \DB::raw('(CASE WHEN year = 0 THEN \'Birth\' WHEN year = 1 THEN \'1 year\' WHEN year = 2 THEN \'2 years\' WHEN year = 3 THEN \'3 years\' WHEN year = 4 THEN \'4 years\' WHEN year = 5 THEN \'5 years\' END) AS age'), 'type')
        ->where('category', 'WHO_0_5')
        ->where('gender', $baby->Sex[0])
        ->where('type', '<>', 'Length/Height')
        ->where('chart_type','z_score')
        ->orderBy('month_wise_age', 'asc')
        ->orderBy('id', 'asc')
        ->get()
         ->toArray();


      //   $query =$zscore->toSql();
      //   print_r($query);
      //   exit;
       //echo "<pre>"; print_r($zscore); exit;

        
   
        $zscore_length_part1 = \DB::table('growth_chart_percentiles')->select('id', 'month_wise_age','chart_type' ,'year', 'month','sd_3_neg as sd_3_neg_part_1','sd_2_neg as sd_2_neg_part_1', 'sd_1_neg as sd_1_neg_part_1', 'sd_0 as sd_0_part_1','sd_1 as sd_1_part_1','sd_2 as sd_2_part_1','sd_3 as sd_3_part_1', \DB::raw('(CASE WHEN year = 0 THEN \'Birth\' WHEN year = 1 THEN \'1 year\' WHEN year = 2 THEN \'2 years\' WHEN year = 3 THEN \'3 years\' WHEN year = 4 THEN \'4 years\' WHEN year = 5 THEN \'5 years\' END) AS age') , 'type', \DB::raw('(CASE WHEN year = 0 THEN \'Birth\' WHEN year = 1 THEN \'1 year\' WHEN year = 2 THEN \'2 years\' WHEN year = 3 THEN \'3 years\' WHEN year = 4 THEN \'4 years\' WHEN year = 5 THEN \'5 years\' END) AS age'))
        ->where('category', 'WHO_0_5')
        ->where('gender', $baby->Sex[0])
        ->where('type', 'Length/Height')
        ->where('chart_type','z_score')
        ->orderBy('month_wise_age', 'asc')
        ->orderBy('id', 'asc')
        ->limit(25)
        ->get()
        ->toArray();

        $zscore_length_part2 = \DB::table('growth_chart_percentiles')->select('id', 'month_wise_age', 'year','chart_type', 'month', 'sd_3_neg as sd_3_neg_part_2','sd_2_neg as sd_2_neg_part_2', 'sd_1_neg as sd_1_neg_part_2', 'sd_0 as sd_0_part_2','sd_1 as sd_1_part_2','sd_2 as sd_2_part_2','sd_3 as sd_3_part_2', \DB::raw('(CASE WHEN year = 0 THEN \'Birth\' WHEN year = 1 THEN \'1 year\' WHEN year = 2 THEN \'2 years\' WHEN year = 3 THEN \'3 years\' WHEN year = 4 THEN \'4 years\' WHEN year = 5 THEN \'5 years\' END) AS age') , 'type', \DB::raw('(CASE WHEN year = 0 THEN \'Birth\' WHEN year = 1 THEN \'1 year\' WHEN year = 2 THEN \'2 years\' WHEN year = 3 THEN \'3 years\' WHEN year = 4 THEN \'4 years\' WHEN year = 5 THEN \'5 years\' END) AS age'))
        ->where('category', 'WHO_0_5')
        ->where('chart_type','z_score')
        ->where('gender', $baby->Sex[0])
        ->where('type', 'Length/Height')
        ->orderBy('month_wise_age', 'asc')
        ->orderBy('id', 'asc')
        ->offset(25)
        ->get()
        ->toArray();

        $zscore = collect($zscore)->groupBy('type');
       

        $zscore['Length/Height'] = array_merge($zscore_length_part1, $zscore_length_part2);


         $wt_zscore = $zscore['Weight'];
         $ht_zscore = $zscore['Length/Height'];
         $hc_zscore = $zscore['Head Circumference'];


        $wt_value_count = 0;
        $ht_value_count = 0;
        $hc_value_count = 0;

 
          $neonatal = Neonatal::select(\DB::raw("(regexp_matches(\"Length\", '[0-9]+\.?[0-9]*'))[1]::numeric AS \"Length\""), \DB::raw("(regexp_matches(\"OFC\", '[0-9]+\.?[0-9]*'))[1]::numeric AS \"OFC\""))->where('BabyId', $baby_id)->first();

        $growth_weight = $growth_height = $growth_head = $corrected_age_weight = $corrected_age_height = $corrected_age_head = array();
        $sex = isset($baby->Sex) ? ucfirst(strtolower($baby->Sex)) : '';

        $nicu_admission = $nicu_discharge = Nicu::select('AdmissionDate', \DB::raw("(regexp_matches(\"AdmissionWt\", '[0-9]+\.?[0-9]*'))[1]::numeric AS \"AdmissionWt\""), 'DischargeDate', \DB::raw("(regexp_matches(\"DischargeWeight\", '[0-9]+\.?[0-9]*'))[1]::numeric AS \"DischargeWeight\""), \DB::raw("(regexp_matches(\"Length\", '[0-9]+\.?[0-9]*'))[1]::numeric AS \"Length\""), \DB::raw("(regexp_matches(\"OFC\", '[0-9]+\.?[0-9]*'))[1]::numeric AS \"OFC\""))->where('BabyId', $baby_id)->where('IsDeleted', 0)
        ->where('AdmissionWt', '<>', '')
        ->get();
        $nicuDaycare = Daycare::select('DayDate', \DB::raw("(regexp_matches(\"CurrentWt\", '[0-9]+\.?[0-9]*'))[1]::numeric AS \"CurrentWt\""), 'length', 'head_circumference')->where('BabyId', $baby_id)->where('IsDeleted', 0);
      //  ->get();
        $chart_days_from_daycare = \SiteHelpers::getDaysForChart();
        $postnatal_discharge = PostnatalDischarge::select('discharge_date', \DB::raw("(regexp_matches(discharge_wt, '[0-9]+\.?[0-9]*'))[1]::numeric AS discharge_wt"), \DB::raw("(regexp_matches(discharge_length, '[0-9]+\.?[0-9]*'))[1]::numeric AS discharge_length"), \DB::raw("(regexp_matches(discharge_ofc, '[0-9]+\.?[0-9]*'))[1]::numeric AS discharge_ofc"))->where('BabyId', $baby_id)->where('IsDeleted', 0)
        ->get();

       // $query=$nicuDaycare->toSql();
       // print_r($query);exit;

        $previous_op_list = Op::GetPreviousopAll($baby_id);
        $previous_op_list = $previous_op_list->sortBy('OpDate');
        $last_op_details = $previous_op_list->last();

        $gestation_weeks = isset($baby->Gestation) ? json_decode($baby->Gestation)->g_weeks : null;
        $gestation_days = isset($baby->Gestation) ? json_decode($baby->Gestation)->g_days : null;
        $same_date_value_list = [];
        $same_date_value_list['wt'] = [];
        $same_date_value_list['len'] = [];
        $same_date_value_list['ofc'] = [];

        if (isset($baby->DOB) && isset($last_op_details->OpDate))
        {
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

        if ($gestation_weeks >= 37 || ($corrected_gestation_weeks > 64 && $gestation_weeks < 37) || $gestation_weeks == null)
        {

            if ($gestation_weeks >= 37 || $gestation_weeks == null)
            {

                if (isset($baby->BirthWeight) && !empty($baby->BirthWeight) && $baby->BirthWeight > 0)
                {
                  //  $wt_zscore[$this->getPosition(0, 0)]= new \stdClass();
                    $wt_zscore[$this->getPosition(0, 0)]->chronological_age = 0.1;
                    $wt_zscore[$this->getPosition(0, 0)]->cage = 0.1;
                    $wt_zscore[$this->getPosition(0, 0)]->value = number_format($baby->BirthWeight / 1000, 2);
                    $wt_zscore[$this->getPosition(0, 0)]->label_name = 'Chronological';
                    $wt_zscore[$this->getPosition(0, 0)]->data_from = 'Baby Details';
                    $wt_zscore[$this->getPosition(0, 0)]->display_age = '[bold]0[/]Y [bold]0[/]M [bold]1[/]D';                             
                }

                if (isset($neonatal->Length) && !empty($neonatal->Length) && $neonatal->Length > 0)
                {

                    $ht_zscore[$this->getPosition(0, 0)]->chronological_age = 0.1;
                    $ht_zscore[$this->getPosition(0, 0)]->cage = 0.1;
                    $ht_zscore[$this->getPosition(0, 0)]->value = number_format($neonatal->Length, 1);
                    $ht_zscore[$this->getPosition(0, 0)]->label_name = 'Chronological';
                    $ht_zscore[$this->getPosition(0, 0)]->data_from = 'Neonatal Performa';
                    $ht_zscore[$this->getPosition(0, 0)]->display_age = '[bold]0[/]Y [bold]0[/]M [bold]1[/]D';
                }

                if (isset($neonatal->OFC) && !empty($neonatal->OFC) && $neonatal->OFC > 0)
                {

                    $hc_zscore[$this->getPosition(0, 0)]->chronological_age = 0.1;
                    $hc_zscore[$this->getPosition(0, 0)]->cage = 0.1;
                    $hc_zscore[$this->getPosition(0, 0)]->value = number_format($neonatal->OFC, 1);
                    $hc_zscore[$this->getPosition(0, 0)]->label_name = 'Chronological';
                    $hc_zscore[$this->getPosition(0, 0)]->data_from = 'Neonatal Performa';
                    $hc_zscore[$this->getPosition(0, 0)]->display_age = '[bold]0[/]Y [bold]0[/]M [bold]1[/]D';
                }

            }

        }
         //echo "<pre>"; print_r($wt_zscore); exit;
        //print_r( $hc_zscore);exit;
        foreach ($previous_op_list as $growthchartweight => $growth_value)
        {
            if (isset($baby->DOB) && isset($growth_value->OpDate))
            {

                if ($gestation_weeks >= 37 || $gestation_weeks == null)
                {
                    $chronological_age = $this->getChronologicalage($baby->DOB, $growth_value->OpDate);

                    if ($chronological_age > 0)
                    {
                        if (isset($growth_value->CurrentWt) && !empty($growth_value->CurrentWt) && $growth_value->CurrentWt > 0)
                        {
                            $index = $this->getPosition($chronological_age['years'], $chronological_age['months']);
                            if (isset($wt_zscore[$index]))
                            {
                                if (!isset($wt_zscore[$index]->value) || (isset($wt_zscore[$index]->value) && empty($wt_zscore[$index]->value)))
                                {
                                    $wt_zscore[$index]->value = number_format($growth_value->CurrentWt / 1000, 2);
                                    $wt_zscore[$index]->chronological_age = $chronological_age['chronological_age'];
                                    $wt_zscore[$index]->cage = $chronological_age['chronological_age'];
                                    $wt_zscore[$index]->label_name = 'Chronological';
                                    $wt_zscore[$index]->display_age = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';                             
                                    $wt_zscore[$index]->data_from = 'OP (Neonatal)';
                                }
                                else
                                {
                                    $count = count(get_object_vars($wt_zscore[$index]));
                                    $count = $wt_value_count + 1;
                                    $wt_zscore[$index]->{"value_" . $count} = number_format($growth_value->CurrentWt / 1000, 2);
                                    $wt_zscore[$index]->{"chronological_age_" . $count} = $chronological_age['chronological_age'];
                                    $wt_zscore[$index]->{"cage_" . $count} = $chronological_age['chronological_age'];
                                    if ($count > $wt_value_count)
                                    {
                                        $wt_value_count = $count;
                                    }
                                    $wt_zscore[$index]->{"label_name_" . $count} = 'Chronological';
                                    $wt_zscore[$index]->{"display_age_" . $count} = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                    $wt_zscore[$index]->{"data_from_" . $count} = 'OP (Neonatal)';
                                }
                            }
                            $same_date_value_list['wt'][] = $growth_value->OpDate;
                        }

                        if (isset($growth_value->CurrentLength) && !empty($growth_value->CurrentLength) && $growth_value->CurrentLength > 0)
                        {
                            $index = $this->getPosition($chronological_age['years'], $chronological_age['months']);
                            if (isset($ht_zscore[$index]))
                            {
                                if (!isset($ht_zscore[$index]->value) || (isset($ht_zscore[$index]->value) && empty($ht_zscore[$index]->value)))
                                {
                                    $ht_zscore[$index]->value = number_format($growth_value->CurrentLength, 1);
                                    $ht_zscore[$index]->chronological_age = $chronological_age['chronological_age'];
                                    $ht_zscore[$index]->cage = $chronological_age['chronological_age'];
                                    $ht_zscore[$index]->label_name = 'Chronological';
                                    $ht_zscore[$index]->display_age = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                    $ht_zscore[$index]->data_from = 'OP (Neonatal)';
                                }
                                else
                                {
                                    $count = count(get_object_vars($ht_zscore[$index]));
                                    $count = $ht_value_count + 1;
                                    $ht_zscore[$index]->{"value_" . $count} = number_format($growth_value->CurrentLength, 1);
                                    $ht_zscore[$index]->{"chronological_age_" . $count} = $chronological_age['chronological_age'];
                                    $ht_zscore[$index]->{"cage_" . $count} = $chronological_age['chronological_age'];
                                    if ($count > $ht_value_count)
                                    {
                                        $ht_value_count = $count;
                                    }
                                    $ht_zscore[$index]->{"label_name_" . $count} = 'Chronological';
                                    $ht_zscore[$index]->{"display_age_" . $count} = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                    $ht_zscore[$index]->{"data_from_" . $count} = 'OP (Neonatal)';
                                }
                            }
                            $same_date_value_list['len'][] = $growth_value->OpDate;
                        }

                        if (isset($growth_value->CurrentOFC) && !empty($growth_value->CurrentOFC) && $growth_value->CurrentOFC > 0)
                        {
                            $index = $this->getPosition($chronological_age['years'], $chronological_age['months']);
                            if (isset($hc_zscore[$index]))
                            {
                                if (!isset($hc_zscore[$index]->value) || (isset($hc_zscore[$index]->value) && empty($hc_zscore[$index]->value)))
                                {
                                    $hc_zscore[$index]->value = number_format($growth_value->CurrentOFC, 1);
                                    $hc_zscore[$index]->chronological_age = $chronological_age['chronological_age'];
                                    $hc_zscore[$index]->cage = $chronological_age['chronological_age'];
                                    $hc_zscore[$index]->label_name = 'Chronological';
                                    $hc_zscore[$index]->display_age = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                    $hc_zscore[$index]->data_from = 'OP (Neonatal)';
                                }
                                else
                                {
                                    $count = count(get_object_vars($hc_zscore[$index]));
                                    $count = $hc_value_count + 1;
                                    $hc_zscore[$index]->{"value_" . $count} = number_format($growth_value->CurrentOFC, 1);
                                    $hc_zscore[$index]->{"chronological_age_" . $count} = $chronological_age['chronological_age'];
                                    $hc_zscore[$index]->{"cage_" . $count} = $chronological_age['chronological_age'];
                                    if ($count > $hc_value_count)
                                    {
                                        $hc_value_count = $count;
                                    }
                                    $hc_zscore[$index]->{"label_name_" . $count} = 'Chronological';
                                    $hc_zscore[$index]->{"display_age_" . $count} = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                    $hc_zscore[$index]->{"data_from_" . $count} = 'OP (Neonatal)';
                                }
                            }
                            $same_date_value_list['ofc'][] = $growth_value->OpDate;
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

                        if (isset($growth_value->CurrentWt) && !empty($growth_value->CurrentWt) && $growth_value->CurrentWt > 0)
                        {
                            $index = $this->getPosition($corrected_age_month['years'], $corrected_age_month['months']);
                            if (isset($wt_zscore[$index]))
                            {
                                if (!isset($wt_zscore[$index]->value) || (isset($wt_zscore[$index]->value) && empty($wt_zscore[$index]->value)))
                                {
                                    $wt_zscore[$index]->value = number_format($growth_value->CurrentWt / 1000, 2);
                                    $wt_zscore[$index]->chronological_age = $corrected_age_month['corrected_age'];
                                    $wt_zscore[$index]->cage = $corrected_age_month['corrected_age'];
                                    $wt_zscore[$index]->label_name = 'Corrected';
                                    $wt_zscore[$index]->display_age = '[bold]' . $corrected_age_month['years'] . '[/]Y [bold]' . $corrected_age_month['months'] . '[/]M [bold]' . $corrected_age_month['days'] . '[/]D';
                                    $wt_zscore[$index]->data_from = 'OP (Neonatal)';
                                }
                                else
                                {
                                    $count = count(get_object_vars($wt_zscore[$index]));
                                    $count = $wt_value_count + 1;
                                    $wt_zscore[$index]->{"value_" . $count} = number_format($growth_value->CurrentWt / 1000, 2);
                                    $wt_zscore[$index]->{"chronological_age_" . $count} = $corrected_age_month['corrected_age'];
                                    $wt_zscore[$index]->{"cage_" . $count} = $corrected_age_month['corrected_age'];
                                    if ($count > $wt_value_count)
                                    {
                                        $wt_value_count = $count;
                                    }
                                    $wt_zscore[$index]->{"label_name_" . $count} = 'Corrected';
                                    $wt_zscore[$index]->{"display_age_" . $count} = '[bold]' . $corrected_age_month['years'] . '[/]Y [bold]' . $corrected_age_month['months'] . '[/]M [bold]' . $corrected_age_month['days'] . '[/]D';
                                    $wt_zscore[$index]->{"data_from_" . $count} = 'OP (Neonatal)';
                                }
                            }
                            $same_date_value_list['wt'][] = $growth_value->OpDate;

                        }
                        if (isset($growth_value->CurrentLength) && !empty($growth_value->CurrentLength) && $growth_value->CurrentLength > 0)
                        {
                            $index = $this->getPosition($corrected_age_month['years'], $corrected_age_month['months']);
                            if (isset($ht_zscore[$index]))
                            {
                                if (!isset($ht_zscore[$index]->value) || (isset($ht_zscore[$index]->value) && empty($ht_zscore[$index]->value)))
                                {
                                    $ht_zscore[$index]->value = number_format($growth_value->CurrentLength, 1);
                                    $ht_zscore[$index]->chronological_age = $corrected_age_month['corrected_age'];
                                    $ht_zscore[$index]->cage = $corrected_age_month['corrected_age'];
                                    $ht_zscore[$index]->label_name = 'Corrected';
                                    $ht_zscore[$index]->display_age = '[bold]' . $corrected_age_month['years'] . '[/]Y [bold]' . $corrected_age_month['months'] . '[/]M [bold]' . $corrected_age_month['days'] . '[/]D';                                    
                                    $ht_zscore[$index]->data_from = 'OP (Neonatal)';
                                }
                                else
                                {
                                    $count = count(get_object_vars($ht_zscore[$index]));
                                    $count = $ht_value_count + 1;
                                    $ht_zscore[$index]->{"value_" . $count} = number_format($growth_value->CurrentLength, 1);
                                    $ht_zscore[$index]->{"chronological_age_" . $count} = $corrected_age_month['corrected_age'];
                                    $ht_zscore[$index]->{"cage_" . $count} = $corrected_age_month['corrected_age'];
                                    if ($count > $ht_value_count)
                                    {
                                        $ht_value_count = $count;
                                    }
                                    $ht_zscore[$index]->{"label_name_" . $count} = 'Corrected';
                                    $ht_zscore[$index]->{"display_age_" . $count} = '[bold]' . $corrected_age_month['years'] . '[/]Y [bold]' . $corrected_age_month['months'] . '[/]M [bold]' . $corrected_age_month['days'] . '[/]D';
                                    $ht_zscore[$index]->{"data_from_" . $count} = 'OP (Neonatal)';
                                }
                            }
                            $same_date_value_list['len'][] = $growth_value->OpDate;
                        }
                        if (isset($growth_value->CurrentOFC) && !empty($growth_value->CurrentOFC) && $growth_value->CurrentOFC > 0)
                        {
                            $index = $this->getPosition($corrected_age_month['years'], $corrected_age_month['months']);
                            if (isset($hc_zscore[$index]))
                            {
                                if (!isset($hc_zscore[$index]->value) || (isset($hc_zscore[$index]->value) && empty($hc_zscore[$index]->value)))
                                {
                                    $hc_zscore[$index]->value = number_format($growth_value->CurrentOFC, 1);
                                    $hc_zscore[$index]->chronological_age = $corrected_age_month['corrected_age'];
                                    $hc_zscore[$index]->cage = $corrected_age_month['corrected_age'];
                                    $hc_zscore[$index]->label_name = 'Corrected';
                                    $hc_zscore[$index]->display_age = '[bold]' . $corrected_age_month['years'] . '[/]Y [bold]' . $corrected_age_month['months'] . '[/]M [bold]' . $corrected_age_month['days'] . '[/]D';     
                                    $hc_zscore[$index]->data_from = 'OP (Neonatal)';
                                }
                                else
                                {
                                    $count = count(get_object_vars($hc_zscore[$index]));
                                    $count = $hc_value_count + 1;
                                    $hc_zscore[$index]->{"value_" . $count} = number_format($growth_value->CurrentOFC, 1);
                                    $hc_zscore[$index]->{"chronological_age_" . $count} = $corrected_age_month['corrected_age'];
                                    $hc_zscore[$index]->{"cage_" . $count} = $corrected_age_month['corrected_age'];
                                    if ($count > $hc_value_count)
                                    {
                                        $hc_value_count = $count;
                                    }
                                    $hc_zscore[$index]->{"label_name_" . $count} = 'Corrected';
                                    $hc_zscore[$index]->{"display_age_" . $count} = '[bold]' . $corrected_age_month['years'] . '[/]Y [bold]' . $corrected_age_month['months'] . '[/]M [bold]' . $corrected_age_month['days'] . '[/]D';
                                    $hc_zscore[$index]->{"data_from_" . $count} = 'OP (Neonatal)';
                                }
                            }
                            $same_date_value_list['ofc'][] = $growth_value->OpDate;
                        }

                    }
                }
            }
        }

        foreach ($nicu_admission as $nakey => $navalue)
        {
            if (isset($navalue->AdmissionDate) && !empty($navalue->AdmissionDate) && !is_null($navalue->AdmissionDate))

                if ($gestation_weeks >= 37 || $gestation_weeks == null)
                {

                    if (isset($navalue->AdmissionWt) && !empty($navalue->AdmissionWt) && $navalue->AdmissionWt > 0)
                    {
                        $chronological_age = $this->getChronologicalage($baby->DOB, $navalue->AdmissionDate);

                        $index = $this->getPosition($chronological_age['years'], $chronological_age['months']);
                        if (isset($wt_zscore[$index]))
                        {
                            if (!isset($wt_zscore[$index]->value) || (isset($wt_zscore[$index]->value) && empty($wt_zscore[$index]->value)))
                            {
                                $wt_zscore[$index]->value = number_format($navalue->AdmissionWt / 1000, 2);
                                $wt_zscore[$index]->chronological_age = $chronological_age['chronological_age'];
                                $wt_zscore[$index]->cage = $chronological_age['chronological_age'];
                                $wt_zscore[$index]->label_name = 'Chronological';
                                $wt_zscore[$index]->display_age = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                $wt_zscore[$index]->data_from = 'NICU Admission';
                            }
                            else
                            {
                                $count = count(get_object_vars($wt_zscore[$index]));
                                $count = $wt_value_count + 1;
                                $wt_zscore[$index]->{"value_" . $count} = number_format($navalue->AdmissionWt / 1000, 2);
                                $wt_zscore[$index]->{"chronological_age_" . $count} = $chronological_age['chronological_age'];
                                $wt_zscore[$index]->{"cage_" . $count} = $chronological_age['chronological_age'];
                                if ($count > $wt_value_count)
                                {
                                    $wt_value_count = $count;
                                }
                                $wt_zscore[$index]->{"label_name_" . $count} = 'Chronological';
                                $wt_zscore[$index]->{"display_age_" . $count} = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                $wt_zscore[$index]->{"data_from_" . $count} = 'NICU Admission';
                            }
                        }

                    }
                }
                else
                {
                    $corrected_age = $this->calculateCorrectedGestation($gestation_weeks, $gestation_days, $baby->DOB, $navalue->AdmissionDate);

                    $corrected_age_weeks = $corrected_age['corrected_age_weeks'] + number_format(($corrected_age['corrected_age_days'] / 7) , 1);

                    if ($corrected_age_weeks > 64)
                    {

                        if (isset($navalue->AdmissionWt) && !empty($navalue->AdmissionWt) && $navalue->AdmissionWt > 0)
                        {

                            $corrected_age_month = $this->calculateCorrectedAge($gestation_weeks, $gestation_days, $baby->DOB, $growth_value->OpDate);

                            $index = $this->getPosition($corrected_age_month['years'], $corrected_age_month['months']);
                            if (isset($wt_zscore[$index]))
                            {
                                if (!isset($wt_zscore[$index]->value) || (isset($wt_zscore[$index]->value) && empty($wt_zscore[$index]->value)))
                                {
                                    $wt_zscore[$index]->value = number_format($navalue->AdmissionWt / 1000, 2);
                                    $wt_zscore[$index]->chronological_age = $corrected_age_month['corrected_age'];
                                    $wt_zscore[$index]->cage = $corrected_age_month['corrected_age'];
                                    $wt_zscore[$index]->label_name = 'Corrected';
                                    $wt_zscore[$index]->display_age = '[bold]' . $corrected_age_month['years'] . '[/]Y [bold]' . $corrected_age_month['months'] . '[/]M [bold]' . $corrected_age_month['days'] . '[/]D';
                                    $wt_zscore[$index]->data_from = 'NICU Admission';
                                }
                                else
                                {
                                    $count = count(get_object_vars($wt_zscore[$index]));
                                    $count = $wt_value_count + 1;
                                    $wt_zscore[$index]->{"value_" . $count} = number_format($navalue->AdmissionWt / 1000, 2);
                                    $wt_zscore[$index]->{"chronological_age_" . $count} = $corrected_age_month['corrected_age'];
                                    $wt_zscore[$index]->{"cage_" . $count} = $corrected_age_month['corrected_age'];
                                    if ($count > $wt_value_count)
                                    {
                                        $wt_value_count = $count;
                                    }
                                    $wt_zscore[$index]->{"label_name_" . $count} = 'Corrected';
                                    $wt_zscore[$index]->{"display_age_" . $count} = '[bold]' . $corrected_age_month['years'] . '[/]Y [bold]' . $corrected_age_month['months'] . '[/]M [bold]' . $corrected_age_month['days'] . '[/]D';
                                    $wt_zscore[$index]->{"data_from_" . $count} = 'NICU Admission';
                                }
                            }

                        }

                    }
                }
            }



            foreach ($nicuDaycare as $ndkey => $ndvalue)
            {

                if (in_array(date('D', strtotime($ndvalue->DayDate)) , $chart_days_from_daycare))
                {
                    if ($gestation_weeks >= 37 || $gestation_weeks == null)
                    {
                        $chronological_age = $this->getChronologicalage($baby->DOB, $ndvalue->DayDate);
                        if (isset($ndvalue->CurrentWt) && !empty($ndvalue->CurrentWt) && $ndvalue->CurrentWt > 0 && !is_null($ndvalue->DayDate))
                        {
                            $index = $this->getPosition($chronological_age['years'], $chronological_age['months']);
                            if (isset($wt_zscore[$index]))
                            {
                                if (!isset($wt_zscore[$index]->value) || (isset($wt_zscore[$index]->value) && empty($wt_zscore[$index]->value)))
                                {
                                    $wt_zscore[$index]->value = number_format($ndvalue->CurrentWt / 1000, 2);
                                    $wt_zscore[$index]->chronological_age = $chronological_age['chronological_age'];
                                    $wt_zscore[$index]->cage = $chronological_age['chronological_age'];
                                    $wt_zscore[$index]->label_name = 'Chronological';
                                    $wt_zscore[$index]->display_age = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                    $wt_zscore[$index]->data_from = 'NICU Daycare';
                                }
                                else
                                {
                                    $count = count(get_object_vars($wt_zscore[$index]));
                                    $count = $wt_value_count + 1;
                                    $wt_zscore[$index]->{"value_" . $count} = number_format($ndvalue->CurrentWt / 1000, 2);
                                    $wt_zscore[$index]->{"chronological_age_" . $count} = $chronological_age['chronological_age'];
                                    $wt_zscore[$index]->{"cage_" . $count} = $chronological_age['chronological_age'];
                                    if ($count > $wt_value_count)
                                    {
                                        $wt_value_count = $count;
                                    }
                                    $wt_zscore[$index]->{"label_name_" . $count} = 'Chronological';
                                    $wt_zscore[$index]->{"display_age_" . $count} = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                    $wt_zscore[$index]->{"data_from_" . $count} = 'NICU Daycare';
                                }
                            }
                        }
                        if (isset($ndvalue->length) && !empty($ndvalue->length) && $ndvalue->length > 0)
                        {
                            $index = $this->getPosition($chronological_age['years'], $chronological_age['months']);
                            if (isset($ht_zscore[$index]))
                            {
                                if (!isset($ht_zscore[$index]->value) || (isset($ht_zscore[$index]->value) && empty($ht_zscore[$index]->value)))
                                {
                                    $ht_zscore[$index]->value = number_format($ndvalue->length, 1);
                                    $ht_zscore[$index]->chronological_age = $chronological_age['chronological_age'];
                                    $ht_zscore[$index]->cage = $chronological_age['chronological_age'];
                                    $ht_zscore[$index]->label_name = 'Chronological';
                                    $ht_zscore[$index]->display_age = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                    $ht_zscore[$index]->data_from = 'NICU Daycare';
                                }
                                else
                                {
                                    $count = count(get_object_vars($ht_zscore[$index]));
                                    $count = $ht_value_count + 1;
                                    $ht_zscore[$index]->{"value_" . $count} = number_format($ndvalue->length, 1);
                                    $ht_zscore[$index]->{"chronological_age_" . $count} = $chronological_age['chronological_age'];
                                    $ht_zscore[$index]->{"cage_" . $count} = $chronological_age['chronological_age'];
                                    if ($count > $ht_value_count)
                                    {
                                        $ht_value_count = $count;
                                    }
                                    $ht_zscore[$index]->{"label_name_" . $count} = 'Chronological';
                                    $ht_zscore[$index]->{"display_age_" . $count} = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                    $ht_zscore[$index]->{"data_from_" . $count} = 'NICU Daycare';
                                }
                            }
                        }
                        if (isset($ndvalue->head_circumference) && !empty($ndvalue->head_circumference) && $ndvalue->head_circumference > 0)
                        {
                            $index = $this->getPosition($chronological_age['years'], $chronological_age['months']);
                            if (isset($hc_zscore[$index]))
                            {
                                if (!isset($hc_zscore[$index]->value) || (isset($hc_zscore[$index]->value) && empty($hc_zscore[$index]->value)))
                                {
                                    $hc_zscore[$index]->value = number_format($ndvalue->head_circumference, 1);
                                    $hc_zscore[$index]->chronological_age = $chronological_age['chronological_age'];
                                    $hc_zscore[$index]->cage = $chronological_age['chronological_age'];
                                    $hc_zscore[$index]->label_name = 'Chronological';
                                    $hc_zscore[$index]->display_age = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                    $hc_zscore[$index]->data_from = 'NICU Daycare';
                                }
                                else
                                {
                                    $count = count(get_object_vars($hc_zscore[$index]));
                                    $count = $hc_value_count + 1;
                                    $hc_zscore[$index]->{"value_" . $count} = number_format($ndvalue->head_circumference, 1);
                                    $hc_zscore[$index]->{"chronological_age_" . $count} = $chronological_age['chronological_age'];
                                    $hc_zscore[$index]->{"cage_" . $count} = $chronological_age['chronological_age'];
                                    if ($count > $hc_value_count)
                                    {
                                        $hc_value_count = $count;
                                    }
                                    $hc_zscore[$index]->{"label_name_" . $count} = 'Chronological';
                                    $hc_zscore[$index]->{"display_age_" . $count} = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                    $hc_zscore[$index]->{"data_from_" . $count} = 'NICU Daycare';
                                }
                            }
                        }
                    }
                }
                else
                {
                    $corrected_age = $this->calculateCorrectedGestation($gestation_weeks, $gestation_days, $baby->DOB, $ndvalue->DayDate);

                    $corrected_age_weeks = $corrected_age['corrected_age_weeks'] + number_format(($corrected_age['corrected_age_days'] / 7) , 1);

                    if ($corrected_age_weeks > 64)
                    {
                        $corrected_age_month = $this->calculateCorrectedAge($gestation_weeks, $gestation_days, $baby->DOB, $ndvalue->DayDate);

                        if (isset($ndvalue->CurrentWt) && !empty($ndvalue->CurrentWt) && $ndvalue->CurrentWt > 0) {
                            $index = $this->getPosition($corrected_age_month['years'], $corrected_age_month['months']);
                            if (isset($wt_zscore[$index]))
                            {
                                if (!isset($wt_zscore[$index]->value) || (isset($wt_zscore[$index]->value) && empty($wt_zscore[$index]->value)))
                                {
                                    $wt_zscore[$index]->value = number_format($ndvalue->CurrentWt / 1000, 2);
                                    $wt_zscore[$index]->chronological_age = $corrected_age_month['corrected_age'];
                                    $wt_zscore[$index]->cage = $corrected_age_month['corrected_age'];
                                    $wt_zscore[$index]->label_name = 'Corrected';
                                    $wt_zscore[$index]->display_age = '[bold]' . $corrected_age_month['years'] . '[/]Y [bold]' . $corrected_age_month['months'] . '[/]M [bold]' . $corrected_age_month['days'] . '[/]D';
                                    $wt_zscore[$index]->data_from = 'NICU Daycare';
                                }
                                else
                                {
                                    $count = count(get_object_vars($wt_zscore[$index]));
                                    $count = $wt_value_count + 1;
                                    $wt_zscore[$index]->{"value_" . $count} = number_format($ndvalue->CurrentWt / 1000, 2);
                                    $wt_zscore[$index]->{"chronological_age_" . $count} = $corrected_age_month['corrected_age'];
                                    $wt_zscore[$index]->{"cage_" . $count} = $corrected_age_month['corrected_age'];
                                    if ($count > $wt_value_count)
                                    {
                                        $wt_value_count = $count;
                                    }
                                    $wt_zscore[$index]->{"label_name_" . $count} = 'Corrected';
                                    $wt_zscore[$index]->{"display_age_" . $count} = '[bold]' . $corrected_age_month['years'] . '[/]Y [bold]' . $corrected_age_month['months'] . '[/]M [bold]' . $corrected_age_month['days'] . '[/]D';
                                    $wt_zscore[$index]->{"data_from_" . $count} = 'NICU Daycare';
                                }
                            }
                        }
                        if (isset($ndvalue->length) && !empty($ndvalue->length) && $ndvalue->length > 0)
                        {
                            $index = $this->getPosition($corrected_age_month['years'], $corrected_age_month['months']);
                            if (isset($ht_zscore[$index]))
                            {
                                if (!isset($ht_zscore[$index]->value) || (isset($ht_zscore[$index]->value) && empty($ht_zscore[$index]->value)))
                                {
                                    $ht_zscore[$index]->value = number_format($ndvalue->length, 1);
                                    $ht_zscore[$index]->chronological_age = $corrected_age_month['corrected_age'];
                                    $ht_zscore[$index]->cage = $corrected_age_month['corrected_age'];
                                    $ht_zscore[$index]->label_name = 'Corrected';
                                    $ht_zscore[$index]->display_age = '[bold]' . $corrected_age_month['years'] . '[/]Y [bold]' . $corrected_age_month['months'] . '[/]M [bold]' . $corrected_age_month['days'] . '[/]D';                                    
                                    $ht_zscore[$index]->data_from = 'OP (Neonatal)';
                                }
                                else
                                {
                                    $count = count(get_object_vars($ht_zscore[$index]));
                                    $count = $ht_value_count + 1;
                                    $ht_zscore[$index]->{"value_" . $count} = number_format($ndvalue->length, 1);
                                    $ht_zscore[$index]->{"chronological_age_" . $count} = $corrected_age_month['corrected_age'];
                                    $ht_zscore[$index]->{"cage_" . $count} = $corrected_age_month['corrected_age'];
                                    if ($count > $ht_value_count)
                                    {
                                        $ht_value_count = $count;
                                    }
                                    $ht_zscore[$index]->{"label_name_" . $count} = 'Corrected';
                                    $ht_zscore[$index]->{"display_age_" . $count} = '[bold]' . $corrected_age_month['years'] . '[/]Y [bold]' . $corrected_age_month['months'] . '[/]M [bold]' . $corrected_age_month['days'] . '[/]D';
                                    $ht_zscore[$index]->{"data_from_" . $count} = 'OP (Neonatal)';
                                }
                            }
                        }
                        if (isset($ndvalue->head_circumference) && !empty($ndvalue->head_circumference) && $ndvalue->head_circumference > 0)
                        {
                            $index = $this->getPosition($corrected_age_month['years'], $corrected_age_month['months']);
                            if (isset($hc_zscore[$index]))
                            {
                                if (!isset($hc_zscore[$index]->value) || (isset($hc_zscore[$index]->value) && empty($hc_zscore[$index]->value)))
                                {
                                    $hc_zscore[$index]->value = number_format($ndvalue->head_circumference, 1);
                                    $hc_zscore[$index]->chronological_age = $corrected_age_month['corrected_age'];
                                    $hc_zscore[$index]->cage = $corrected_age_month['corrected_age'];
                                    $hc_zscore[$index]->label_name = 'Corrected';
                                    $hc_zscore[$index]->display_age = '[bold]' . $corrected_age_month['years'] . '[/]Y [bold]' . $corrected_age_month['months'] . '[/]M [bold]' . $corrected_age_month['days'] . '[/]D';     
                                    $hc_zscore[$index]->data_from = 'OP (Neonatal)';
                                }
                                else
                                {
                                    $count = count(get_object_vars($hc_zscore[$index]));
                                    $count = $hc_value_count + 1;
                                    $hc_zscore[$index]->{"value_" . $count} = number_format($ndvalue->head_circumference, 1);
                                    $hc_zscore[$index]->{"chronological_age_" . $count} = $corrected_age_month['corrected_age'];
                                    $hc_zscore[$index]->{"cage_" . $count} = $corrected_age_month['corrected_age'];
                                    if ($count > $hc_value_count)
                                    {
                                        $hc_value_count = $count;
                                    }
                                    $hc_zscore[$index]->{"label_name_" . $count} = 'Corrected';
                                    $hc_zscore[$index]->{"display_age_" . $count} = '[bold]' . $corrected_age_month['years'] . '[/]Y [bold]' . $corrected_age_month['months'] . '[/]M [bold]' . $corrected_age_month['days'] . '[/]D';
                                    $hc_zscore[$index]->{"data_from_" . $count} = 'OP (Neonatal)';
                                }
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
                    if ($gestation_weeks >= 37 || $gestation_weeks == null)
                    {
                        $chronological_age = $this->getChronologicalage($baby->DOB, $value->DischargeDate);

                        if (isset($value->DischargeWeight) && !empty($value->DischargeWeight) && $value->DischargeWeight > 0)
                        {
                            $index = $this->getPosition($chronological_age['years'], $chronological_age['months']);
                            if (isset($wt_zscore[$index]))
                            {
                                if (!isset($wt_zscore[$index]->value) || (isset($wt_zscore[$index]->value) && empty($wt_zscore[$index]->value)))
                                {
                                    $wt_zscore[$index]->value = number_format($value->DischargeWeight / 1000, 2);
                                    $wt_zscore[$index]->chronological_age = $chronological_age['chronological_age'];
                                    $wt_zscore[$index]->cage = $chronological_age['chronological_age'];
                                    $wt_zscore[$index]->label_name = 'Chronological';
                                    $wt_zscore[$index]->display_age = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                    $wt_zscore[$index]->data_from = 'NICU Discharge';
                                }
                                else
                                {
                                    $count = count(get_object_vars($wt_zscore[$index]));
                                    $count = $wt_value_count + 1;
                                    $wt_zscore[$index]->{"value_" . $count} = number_format($value->DischargeWeight / 1000, 2);
                                    $wt_zscore[$index]->{"chronological_age_" . $count} = $chronological_age['chronological_age'];
                                    $wt_zscore[$index]->{"cage_" . $count} = $chronological_age['chronological_age'];
                                    if ($count > $wt_value_count)
                                    {
                                        $wt_value_count = $count;
                                    }
                                    $wt_zscore[$index]->{"label_name_" . $count} = 'Chronological';
                                    $wt_zscore[$index]->{"display_age_" . $count} = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                    $wt_zscore[$index]->{"data_from_" . $count} = 'NICU Discharge';
                                }
                            }

                        }

                        if (isset($value->Length) && !empty($value->Length) && $value->Length > 0)
                        {
                            $index = $this->getPosition($chronological_age['years'], $chronological_age['months']);
                            if (isset($ht_zscore[$index]))
                            {
                                if (!isset($ht_zscore[$index]->value) || (isset($ht_zscore[$index]->value) && empty($ht_zscore[$index]->value)))
                                {
                                    $ht_zscore[$index]->value = number_format($value->Length, 1);
                                    $ht_zscore[$index]->chronological_age = $chronological_age['chronological_age'];
                                    $ht_zscore[$index]->cage = $chronological_age['chronological_age'];
                                    $ht_zscore[$index]->label_name = 'Chronological';
                                    $ht_zscore[$index]->display_age = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                    $ht_zscore[$index]->data_from = 'NICU Discharge';
                                }
                                else
                                {
                                    $count = count(get_object_vars($ht_zscore[$index]));
                                    $count = $ht_value_count + 1;
                                    $ht_zscore[$index]->{"value_" . $count} = number_format($value->Length, 1);
                                    $ht_zscore[$index]->{"chronological_age_" . $count} = $chronological_age['chronological_age'];
                                    $ht_zscore[$index]->{"cage_" . $count} = $chronological_age['chronological_age'];
                                    if ($count > $ht_value_count)
                                    {
                                        $ht_value_count = $count;
                                    }
                                    $ht_zscore[$index]->{"label_name_" . $count} = 'Chronological';
                                    $ht_zscore[$index]->{"display_age_" . $count} = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                    $ht_zscore[$index]->{"data_from_" . $count} = 'NICU Discharge';
                                }
                            }

                        }
                        if (isset($value->OFC) && !empty($value->OFC) && $value->OFC > 0)
                        {
                            $index = $this->getPosition($chronological_age['years'], $chronological_age['months']);
                            if (isset($hc_zscore[$index]))
                            {
                                if (!isset($hc_zscore[$index]->value) || (isset($hc_zscore[$index]->value) && empty($hc_zscore[$index]->value)))
                                {
                                    $hc_zscore[$index]->value = number_format($value->OFC, 1);
                                    $hc_zscore[$index]->chronological_age = $chronological_age['chronological_age'];
                                    $hc_zscore[$index]->cage = $chronological_age['chronological_age'];
                                    $hc_zscore[$index]->label_name = 'Chronological';
                                    $hc_zscore[$index]->display_age = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                    $hc_zscore[$index]->data_from = 'NICU Discharge';
                                }
                                else
                                {
                                    $count = count(get_object_vars($hc_zscore[$index]));
                                    $count = $hc_value_count + 1;
                                    $hc_zscore[$index]->{"value_" . $count} = number_format($value->OFC, 1);
                                    $hc_zscore[$index]->{"chronological_age_" . $count} = $chronological_age['chronological_age'];
                                    $hc_zscore[$index]->{"cage_" . $count} = $chronological_age['chronological_age'];
                                    if ($count > $hc_value_count)
                                    {
                                        $hc_value_count = $count;
                                    }
                                    $hc_zscore[$index]->{"label_name_" . $count} = 'Chronological';
                                    $hc_zscore[$index]->{"display_age_" . $count} = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                    $hc_zscore[$index]->{"data_from_" . $count} = 'NICU Discharge';
                                }
                            }

                        }
                    }
                    else
                    {
                        $corrected_age = $this->calculateCorrectedGestation($gestation_weeks, $gestation_days, $baby->DOB, $value->DischargeDate);

                        $corrected_age_weeks = $corrected_age['corrected_age_weeks'] + number_format(($corrected_age['corrected_age_days'] / 7) , 1);

                        if ($corrected_age_weeks > 64)
                        {
                            $corrected_age_month = $this->calculateCorrectedAge($gestation_weeks, $gestation_days, $baby->DOB, $value->DischargeDate);

                            if (isset($value->DischargeWeight) && !empty($value->DischargeWeight) && $value->DischargeWeight > 0)
                            {

                                $index = $this->getPosition($corrected_age_month['years'], $corrected_age_month['months']);
                                if (isset($wt_zscore[$index]))
                                {
                                    if (!isset($wt_zscore[$index]->value) || (isset($wt_zscore[$index]->value) && empty($wt_zscore[$index]->value)))
                                    {
                                        $wt_zscore[$index]->value = number_format($value->DischargeWeight, 2);
                                        $wt_zscore[$index]->chronological_age = $corrected_age_month['corrected_age'];
                                        $wt_zscore[$index]->cage = $corrected_age_month['corrected_age'];
                                        $wt_zscore[$index]->label_name = 'Corrected';
                                        $wt_zscore[$index]->display_age = '[bold]' . $corrected_age_month['years'] . '[/]Y [bold]' . $corrected_age_month['months'] . '[/]M [bold]' . $corrected_age_month['days'] . '[/]D';
                                        $wt_zscore[$index]->data_from = 'NICU Discharge';
                                    }
                                    else
                                    {
                                        $count = count(get_object_vars($wt_zscore[$index]));
                                        $count = $wt_value_count + 1;
                                        $wt_zscore[$index]->{"value_" . $count} = number_format($value->DischargeWeight / 1000, 2);
                                        $wt_zscore[$index]->{"chronological_age_" . $count} = $corrected_age_month['corrected_age'];
                                        $wt_zscore[$index]->{"cage_" . $count} = $corrected_age_month['corrected_age'];
                                        if ($count > $wt_value_count)
                                        {
                                            $wt_value_count = $count;
                                        }
                                        $wt_zscore[$index]->{"label_name_" . $count} = 'Corrected';
                                        $wt_zscore[$index]->{"display_age_" . $count} = '[bold]' . $corrected_age_month['years'] . '[/]Y [bold]' . $corrected_age_month['months'] . '[/]M [bold]' . $corrected_age_month['days'] . '[/]D';
                                        $wt_zscore[$index]->{"data_from_" . $count} = 'NICU Discharge';
                                    }
                                }

                            }

                            if (isset($value->Length) && !empty($value->Length) && $value->Length > 0)
                            {

                                $index = $this->getPosition($corrected_age_month['years'], $corrected_age_month['months']);
                                if (isset($ht_zscore[$index]))
                                {
                                    if (!isset($ht_zscore[$index]->value) || (isset($ht_zscore[$index]->value) && empty($ht_zscore[$index]->value)))
                                    {
                                        $ht_zscore[$index]->value = number_format($value->Length, 1);
                                        $ht_zscore[$index]->chronological_age = $corrected_age_month['corrected_age'];
                                        $ht_zscore[$index]->cage = $corrected_age_month['corrected_age'];
                                        $ht_zscore[$index]->label_name = 'Corrected';
                                        $ht_zscore[$index]->display_age = '[bold]' . $corrected_age_month['years'] . '[/]Y [bold]' . $corrected_age_month['months'] . '[/]M [bold]' . $corrected_age_month['days'] . '[/]D';
                                        $ht_zscore[$index]->data_from = 'NICU Discharge';
                                    }
                                    else
                                    {
                                        $count = count(get_object_vars($ht_zscore[$index]));
                                        $count = $ht_value_count + 1;
                                        $ht_zscore[$index]->{"value_" . $count} = number_format($value->Length, 1);
                                        $ht_zscore[$index]->{"chronological_age_" . $count} = $corrected_age_month['corrected_age'];
                                        $ht_zscore[$index]->{"cage_" . $count} = $corrected_age_month['corrected_age'];
                                        if ($count > $ht_value_count)
                                        {
                                            $ht_value_count = $count;
                                        }
                                        $ht_zscore[$index]->{"label_name_" . $count} = 'Corrected';
                                        $ht_zscore[$index]->{"display_age_" . $count} = '[bold]' . $corrected_age_month['years'] . '[/]Y [bold]' . $corrected_age_month['months'] . '[/]M [bold]' . $corrected_age_month['days'] . '[/]D';
                                        $ht_zscore[$index]->{"data_from_" . $count} = 'NICU Discharge';
                                    }
                                }

                            }

                            if (isset($value->OFC) && !empty($value->OFC) && $value->OFC > 0)
                            {

                                $index = $this->getPosition($corrected_age_month['years'], $corrected_age_month['months']);
                                if (isset($hc_zscore[$index]))
                                {
                                    if (!isset($hc_zscore[$index]->value) || (isset($hc_zscore[$index]->value) && empty($hc_zscore[$index]->value)))
                                    {
                                        $hc_zscore[$index]->value = number_format($value->OFC, 1);
                                        $hc_zscore[$index]->chronological_age = $corrected_age_month['corrected_age'];
                                        $hc_zscore[$index]->cage = $corrected_age_month['corrected_age'];
                                        $hc_zscore[$index]->label_name = 'Corrected';
                                        $hc_zscore[$index]->display_age = '[bold]' . $corrected_age_month['years'] . '[/]Y [bold]' . $corrected_age_month['months'] . '[/]M [bold]' . $corrected_age_month['days'] . '[/]D';
                                        $hc_zscore[$index]->data_from = 'NICU Discharge';
                                    }
                                    else
                                    {
                                        $count = count(get_object_vars($hc_zscore[$index]));
                                        $count = $hc_value_count + 1;
                                        $hc_zscore[$index]->{"value_" . $count} = number_format($value->OFC, 1);
                                        $hc_zscore[$index]->{"chronological_age_" . $count} = $corrected_age_month['corrected_age'];
                                        $hc_zscore[$index]->{"cage_" . $count} = $corrected_age_month['corrected_age'];
                                        if ($count > $hc_value_count)
                                        {
                                            $hc_value_count = $count;
                                        }
                                        $hc_zscore[$index]->{"label_name_" . $count} = 'Corrected';
                                        $hc_zscore[$index]->{"display_age_" . $count} = '[bold]' . $corrected_age_month['years'] . '[/]Y [bold]' . $corrected_age_month['months'] . '[/]M [bold]' . $corrected_age_month['days'] . '[/]D';
                                        $hc_zscore[$index]->{"data_from_" . $count} = 'NICU Discharge';
                                    }
                                }

                            }
                        }
                    }

                }

            }

            foreach ($postnatal_discharge as $key => $postnatal_value)
            {
                if (isset($postnatal_value->discharge_date) && !is_null($postnatal_value->discharge_date) && !empty($postnatal_value->discharge_date))
                {
                    if ($gestation_weeks >= 37 || $gestation_weeks == null)
                    {
                        $chronological_age = $this->getChronologicalage($baby->DOB, $postnatal_value->discharge_date);

                        if (isset($postnatal_value->discharge_wt) && !empty($postnatal_value->discharge_wt) && $postnatal_value->discharge_wt > 0)
                        {
                            $index = $this->getPosition($chronological_age['years'], $chronological_age['months']);
                            if (isset($wt_zscore[$index]))
                            {
                                if (!isset($wt_zscore[$index]->value) || (isset($wt_zscore[$index]->value) && empty($wt_zscore[$index]->value)))
                                {
                                    $wt_zscore[$index]->value = number_format($postnatal_value->discharge_wt / 1000, 2);
                                    $wt_zscore[$index]->chronological_age = $chronological_age['chronological_age'];
                                    $wt_zscore[$index]->cage = $chronological_age['chronological_age'];
                                    $wt_zscore[$index]->label_name = 'Chronological';
                                    $wt_zscore[$index]->display_age = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                    $wt_zscore[$index]->data_from = 'Postnatal Discharge';
                                }
                                else
                                {
                                    $count = count(get_object_vars($wt_zscore[$index]));
                                    $count = $wt_value_count + 1;
                                    $wt_zscore[$index]->{"value_" . $count} = number_format($postnatal_value->discharge_wt / 1000, 2);
                                    $wt_zscore[$index]->{"chronological_age_" . $count} = $chronological_age['chronological_age'];
                                    $wt_zscore[$index]->{"cage_" . $count} = $chronological_age['chronological_age'];
                                    if ($count > $wt_value_count)
                                    {
                                        $wt_value_count = $count;
                                    }
                                    $wt_zscore[$index]->{"label_name_" . $count} = 'Chronological';
                                    $wt_zscore[$index]->{"display_age_" . $count} = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                    $wt_zscore[$index]->{"data_from_" . $count} = 'Postnatal Discharge';
                                }
                            }
                        }

                        if (isset($postnatal_value->discharge_length) && !empty($postnatal_value->discharge_length) && $postnatal_value->discharge_length > 0)
                        {
                            $index = $this->getPosition($chronological_age['years'], $chronological_age['months']);
                            if (isset($ht_zscore[$index]))
                            {
                                if (!isset($ht_zscore[$index]->value) || (isset($ht_zscore[$index]->value) && empty($ht_zscore[$index]->value)))
                                {
                                    $ht_zscore[$index]->value = number_format($postnatal_value->discharge_length, 1);
                                    $ht_zscore[$index]->chronological_age = $chronological_age['chronological_age'];
                                    $ht_zscore[$index]->cage = $chronological_age['chronological_age'];
                                    $ht_zscore[$index]->label_name = 'Chronological';
                                    $ht_zscore[$index]->display_age = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                    $ht_zscore[$index]->data_from = 'Postnatal Discharge';
                                }
                                else
                                {
                                    $count = count(get_object_vars($ht_zscore[$index]));
                                    $count = $ht_value_count + 1;
                                    $ht_zscore[$index]->{"value_" . $count} = number_format($postnatal_value->discharge_length, 1);
                                    $ht_zscore[$index]->{"chronological_age_" . $count} = $chronological_age['chronological_age'];
                                    $ht_zscore[$index]->{"cage_" . $count} = $chronological_age['chronological_age'];
                                    if ($count > $ht_value_count)
                                    {
                                        $ht_value_count = $count;
                                    }
                                    $ht_zscore[$index]->{"label_name_" . $count} = 'Chronological';
                                    $ht_zscore[$index]->{"display_age_" . $count} = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                    $ht_zscore[$index]->{"data_from_" . $count} = 'Postnatal Discharge';
                                }
                            }
                        }

                        if (isset($postnatal_value->discharge_ofc) && !empty($postnatal_value->discharge_ofc) && $postnatal_value->discharge_ofc > 0)
                        {

                            $index = $this->getPosition($chronological_age['years'], $chronological_age['months']);
                            if (isset($hc_zscore[$index]))
                            {
                                if (!isset($hc_zscore[$index]->value) || (isset($hc_zscore[$index]->value) && empty($hc_zscore[$index]->value)))
                                {
                                    $hc_zscore[$index]->value = number_format($postnatal_value->discharge_ofc, 1);
                                    $hc_zscore[$index]->chronological_age = $chronological_age['chronological_age'];
                                    $hc_zscore[$index]->cage = $chronological_age['chronological_age'];
                                    $hc_zscore[$index]->label_name = 'Chronological';
                                    $hc_zscore[$index]->display_age = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                    $hc_zscore[$index]->data_from = 'Postnatal Discharge';
                                }
                                else
                                {
                                    $count = count(get_object_vars($hc_zscore[$index]));
                                    $count = $hc_value_count + 1;
                                    $hc_zscore[$index]->{"value_" . $count} = number_format($postnatal_value->discharge_ofc, 1);
                                    $hc_zscore[$index]->{"chronological_age_" . $count} = $chronological_age['chronological_age'];
                                    $hc_zscore[$index]->{"cage_" . $count} = $chronological_age['chronological_age'];
                                    if ($count > $hc_value_count)
                                    {
                                        $hc_value_count = $count;
                                    }
                                    $hc_zscore[$index]->{"label_name_" . $count} = 'Chronological';
                                    $hc_zscore[$index]->{"display_age_" . $count} = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                    $hc_zscore[$index]->{"data_from_" . $count} = 'Postnatal Discharge';
                                }
                            }
                        }
                    }
                    else
                    {
                        $corrected_age = $this->calculateCorrectedGestation($gestation_weeks, $gestation_days, $baby->DOB, $postnatal_value->discharge_date);

                        $corrected_age_weeks = $corrected_age['corrected_age_weeks'] + number_format(($corrected_age['corrected_age_days'] / 7) , 1);

                        if ($corrected_age_weeks > 64)
                        {

                            $corrected_age_month = $this->calculateCorrectedAge($gestation_weeks, $gestation_days, $baby->DOB, $postnatal_value->discharge_date);

                            if (isset($postnatal_value->discharge_wt) && !empty($postnatal_value->discharge_wt) && $postnatal_value->discharge_wt > 0)
                            {
                                $index = $this->getPosition($corrected_age_month['years'], $corrected_age_month['months']);
                                if (isset($wt_zscore[$index]))
                                {
                                    if (!isset($wt_zscore[$index]->value) || (isset($wt_zscore[$index]->value) && empty($wt_zscore[$index]->value)))
                                    {
                                        $wt_zscore[$index]->value = number_format($postnatal_value->discharge_wt, 2);
                                        $wt_zscore[$index]->chronological_age = $corrected_age_month['corrected_age'];
                                        $wt_zscore[$index]->cage = $corrected_age_month['corrected_age'];
                                        $wt_zscore[$index]->label_name = 'Corrected';
                                        $wt_zscore[$index]->display_age = '[bold]' . $corrected_age_month['years'] . '[/]Y [bold]' . $corrected_age_month['months'] . '[/]M [bold]' . $corrected_age_month['days'] . '[/]D';
                                        $wt_zscore[$index]->data_from = 'Postnatal Discharge';
                                    }
                                    else
                                    {
                                        $count = count(get_object_vars($wt_zscore[$index]));
                                        $count = $wt_value_count + 1;
                                        $wt_zscore[$index]->{"value_" . $count} = number_format($postnatal_value->discharge_wt / 1000, 2);
                                        $wt_zscore[$index]->{"chronological_age_" . $count} = $corrected_age_month['corrected_age'];
                                        $wt_zscore[$index]->{"cage_" . $count} = $corrected_age_month['corrected_age'];
                                        if ($count > $wt_value_count)
                                        {
                                            $wt_value_count = $count;
                                        }
                                        $wt_zscore[$index]->{"label_name_" . $count} = 'Corrected';
                                        $wt_zscore[$index]->{"display_age_" . $count} = '[bold]' . $corrected_age_month['years'] . '[/]Y [bold]' . $corrected_age_month['months'] . '[/]M [bold]' . $corrected_age_month['days'] . '[/]D';
                                        $wt_zscore[$index]->{"data_from_" . $count} = 'Postnatal Discharge';
                                    }
                                }
                            }

                            if (isset($postnatal_value->discharge_length) && !empty($postnatal_value->discharge_length) && $postnatal_value->discharge_length > 0)
                            {
                                $index = $this->getPosition($corrected_age_month['years'], $corrected_age_month['months']);
                                if (isset($ht_zscore[$index]))
                                {
                                    if (!isset($ht_zscore[$index]->value) || (isset($ht_zscore[$index]->value) && empty($ht_zscore[$index]->value)))
                                    {
                                        $ht_zscore[$index]->value = number_format($postnatal_value->discharge_length, 1);
                                        $ht_zscore[$index]->chronological_age = $corrected_age_month['corrected_age'];
                                        $ht_zscore[$index]->cage = $corrected_age_month['corrected_age'];
                                        $ht_zscore[$index]->label_name = 'Corrected';
                                        $ht_zscore[$index]->display_age = '[bold]' . $corrected_age_month['years'] . '[/]Y [bold]' . $corrected_age_month['months'] . '[/]M [bold]' . $corrected_age_month['days'] . '[/]D';
                                        $ht_zscore[$index]->data_from = 'Postnatal Discharge';
                                    }
                                    else
                                    {
                                        $count = count(get_object_vars($ht_zscore[$index]));
                                        $count = $ht_value_count + 1;
                                        $ht_zscore[$index]->{"value_" . $count} = number_format($postnatal_value->discharge_length, 1);
                                        $ht_zscore[$index]->{"chronological_age_" . $count} = $corrected_age_month['corrected_age'];
                                        $ht_zscore[$index]->{"cage_" . $count} = $corrected_age_month['corrected_age'];
                                        if ($count > $ht_value_count)
                                        {
                                            $ht_value_count = $count;
                                        }
                                        $ht_zscore[$index]->{"label_name_" . $count} = 'Corrected';
                                        $ht_zscore[$index]->{"display_age_" . $count} = '[bold]' . $corrected_age_month['years'] . '[/]Y [bold]' . $corrected_age_month['months'] . '[/]M [bold]' . $corrected_age_month['days'] . '[/]D';
                                        $ht_zscore[$index]->{"data_from_" . $count} = 'Postnatal Discharge';
                                    }
                                }
                            }
                            if (isset($postnatal_value->discharge_ofc) && !empty($postnatal_value->discharge_ofc) && $postnatal_value->discharge_ofc > 0)
                            {
                                $index = $this->getPosition($corrected_age_month['years'], $corrected_age_month['months']);
                                if (isset($hc_zscore[$index]))
                                {
                                    if (!isset($hc_zscore[$index]->value) || (isset($hc_zscore[$index]->value) && empty($hc_zscore[$index]->value)))
                                    {
                                        $hc_zscore[$index]->value = number_format($postnatal_value->discharge_ofc, 1);
                                        $hc_zscore[$index]->chronological_age = $corrected_age_month['corrected_age'];
                                        $hc_zscore[$index]->cage = $corrected_age_month['corrected_age'];
                                        $hc_zscore[$index]->label_name = 'Corrected';
                                        $hc_zscore[$index]->display_age = '[bold]' . $corrected_age_month['years'] . '[/]Y [bold]' . $corrected_age_month['months'] . '[/]M [bold]' . $corrected_age_month['days'] . '[/]D';
                                        $hc_zscore[$index]->data_from = 'Postnatal Discharge';
                                    }
                                    else
                                    {
                                        $count = count(get_object_vars($hc_zscore[$index]));
                                        $count = $hc_value_count + 1;
                                        $hc_zscore[$index]->{"value_" . $count} = number_format($postnatal_value->discharge_ofc, 1);
                                        $hc_zscore[$index]->{"chronological_age_" . $count} = $corrected_age_month['corrected_age'];
                                        $hc_zscore[$index]->{"cage_" . $count} = $corrected_age_month['corrected_age'];
                                        if ($count > $hc_value_count)
                                        {
                                            $hc_value_count = $count;
                                        }
                                        $hc_zscore[$index]->{"label_name_" . $count} = 'Corrected';
                                        $hc_zscore[$index]->{"display_age_" . $count} = '[bold]' . $corrected_age_month['years'] . '[/]Y [bold]' . $corrected_age_month['months'] . '[/]M [bold]' . $corrected_age_month['days'] . '[/]D';
                                        $hc_zscore[$index]->{"data_from_" . $count} = 'Postnatal Discharge';
                                    }
                                }
                            }
                        }

                    }
                }

            }

        //OP (Pediatric)
            $previous_pediatric_op_list = Oppediatric::getAllPreviousOp($baby_id);

            $previous_pediatric_op_list = $previous_pediatric_op_list->sortBy('op_date');
            foreach ($previous_pediatric_op_list as $key => $value)
            {
                if ((isset($baby->DOB) && !empty($baby->DOB)) && (isset($value->op_date) && !empty($value->op_date))) {

                    $chronological_age = $this->getChronologicalage($baby->DOB, $value->op_date);
                    if ($chronological_age >= 5 && ($gestation_weeks > 36 || empty($gestation_weeks)))
                    {
                        $index = $this->getPosition($chronological_age['years'], $chronological_age['months']);

                        if (isset($value->current_weight) && !empty($value->current_weight) && $value->current_weight > 0)
                        {
                            if (isset($wt_zscore[$index]))
                            {
                                if (!isset($wt_zscore[$index]->value) || (isset($wt_zscore[$index]->value) && empty($wt_zscore[$index]->value)))
                                {
                                    $wt_zscore[$index]->value = number_format($value->current_weight / 1000, 2);
                                    $wt_zscore[$index]->chronological_age = $chronological_age['chronological_age'];
                                    $wt_zscore[$index]->cage = $chronological_age['chronological_age'];
                                    $wt_zscore[$index]->label_name = 'Chronological';
                                    $wt_zscore[$index]->display_age = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                    $wt_zscore[$index]->data_from = 'OP (Pediatric)';
                                }
                                else
                                {
                                    $count = count(get_object_vars($wt_zscore[$index]));
                                    $count = $wt_value_count + 1;
                                    $wt_zscore[$index]->{"value_" . $count} = number_format($value->current_weight / 1000, 2);
                                    $wt_zscore[$index]->{"chronological_age_" . $count} = $chronological_age['chronological_age'];
                                    $wt_zscore[$index]->{"cage_" . $count} = $chronological_age['chronological_age'];
                                    if ($count > $wt_value_count)
                                    {
                                        $wt_value_count = $count;
                                    }
                                    $wt_zscore[$index]->{"label_name_" . $count} = 'Chronological';
                                    $wt_zscore[$index]->{"display_age_" . $count} = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                    $wt_zscore[$index]->{"data_from_" . $count} = 'OP (Pediatric)';
                                }
                            }
                            $same_date_value_list['wt'][] = $value->op_date;
                        }

                        if (isset($value->current_length) && !empty($value->current_length) && $value->current_length > 0)
                        {
                            if (isset($ht_zscore[$index]))
                            {
                                if (!isset($ht_zscore[$index]->value) || (isset($ht_zscore[$index]->value) && empty($ht_zscore[$index]->value)))
                                {
                                    $ht_zscore[$index]->value = number_format($value->current_length, 1);
                                    $ht_zscore[$index]->chronological_age = $chronological_age['chronological_age'];
                                    $ht_zscore[$index]->cage = $chronological_age['chronological_age'];
                                    $ht_zscore[$index]->label_name = 'Chronological';
                                    $ht_zscore[$index]->display_age = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                    $ht_zscore[$index]->data_from = 'OP (Pediatric)';
                                }
                                else
                                {
                                    $count = count(get_object_vars($ht_zscore[$index]));
                                    $count = $ht_value_count + 1;
                                    $ht_zscore[$index]->{"value_" . $count} = number_format($value->current_length, 1);
                                    $ht_zscore[$index]->{"chronological_age_" . $count} = $chronological_age['chronological_age'];
                                    $ht_zscore[$index]->{"cage_" . $count} = $chronological_age['chronological_age'];
                                    if ($count > $ht_value_count)
                                    {
                                        $ht_value_count = $count;
                                    }
                                    $ht_zscore[$index]->{"label_name_" . $count} = 'Chronological';
                                    $ht_zscore[$index]->{"display_age_" . $count} = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                    $ht_zscore[$index]->{"data_from_" . $count} = 'OP (Pediatric)';
                                }
                            }
                            $same_date_value_list['len'][] = $value->op_date;
                        }

                        if (isset($value->current_head_circumference) && !empty($value->current_head_circumference) && $value->current_head_circumference > 0)
                        {
                            if (isset($hc_zscore[$index]))
                            {
                                if (!isset($hc_zscore[$index]->value) || (isset($hc_zscore[$index]->value) && empty($hc_zscore[$index]->value)))
                                {
                                    $hc_zscore[$index]->value = number_format($value->current_head_circumference, 1);
                                    $hc_zscore[$index]->chronological_age = $chronological_age['chronological_age'];
                                    $hc_zscore[$index]->cage = $chronological_age['chronological_age'];
                                    $hc_zscore[$index]->label_name = 'Chronological';
                                    $hc_zscore[$index]->display_age = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                    $hc_zscore[$index]->data_from = 'OP (Pediatric)';
                                }
                                else
                                {
                                    $count = count(get_object_vars($hc_zscore[$index]));
                                    $count = $hc_value_count + 1;
                                    $hc_zscore[$index]->{"value_" . $count} = number_format($value->current_head_circumference, 1);
                                    $hc_zscore[$index]->{"chronological_age_" . $count} = $chronological_age['chronological_age'];
                                    $hc_zscore[$index]->{"cage_" . $count} = $chronological_age['chronological_age'];
                                    if ($count > $hc_value_count)
                                    {
                                        $hc_value_count = $count;
                                    }
                                    $hc_zscore[$index]->{"label_name_" . $count} = 'Chronological';
                                    $hc_zscore[$index]->{"display_age_" . $count} = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                    $hc_zscore[$index]->{"data_from_" . $count} = 'OP (Pediatric)';
                                }
                            }
                            $same_date_value_list['ofc'][] = $value->op_date;
                        }

                    }
                    else{
                        $corrected_age = $this->calculateCorrectedGestation($gestation_weeks, $gestation_days, $baby->DOB, $value->op_date);
                        $corrected_age_weeks = $corrected_age['corrected_age_weeks'] + number_format(($corrected_age['corrected_age_days'] / 7) , 1);

                        if ($corrected_age_weeks > 64)
                        {
                            $corrected_age_month = $this->calculateCorrectedAge($gestation_weeks, $gestation_days, $baby->DOB, $value->op_date);
                        }
                    }

                }

            }

        //Pediatric Admission
            $previous_pediatric_admission_list = Pediatric::getAllPreviousAdmission($baby_id);
            $previous_pediatric_admission_list = $previous_pediatric_admission_list->sortBy('admission_date');

            foreach ($previous_pediatric_admission_list as $key => $value)
            {
                if ((isset($baby->DOB) && !empty($baby->DOB)) && (isset($value->admission_date) && !empty($value->admission_date))) {

                    $chronological_age = $this->getChronologicalage($baby->DOB, $value->admission_date);

                    if ($chronological_age >= 5 && ($gestation_weeks > 36 || empty($gestation_weeks)))
                    {
                        $index = $this->getPosition($chronological_age['years'], $chronological_age['months']);

                        if (isset($value->current_weight) && !empty($value->current_weight) && $value->current_weight > 0)
                        {
                            if (isset($wt_zscore[$index]))
                            {
                                if (!isset($wt_zscore[$index]->value) || (isset($wt_zscore[$index]->value) && empty($wt_zscore[$index]->value)))
                                {
                                    $wt_zscore[$index]->value = number_format($value->current_weight / 1000, 2);
                                    $wt_zscore[$index]->chronological_age = $chronological_age['chronological_age'];
                                    $wt_zscore[$index]->cage = $chronological_age['chronological_age'];
                                    $wt_zscore[$index]->label_name = 'Chronological';
                                    $wt_zscore[$index]->display_age = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                    $wt_zscore[$index]->data_from = 'Pediatric Admission';
                                }
                                else
                                {
                                    $count = count(get_object_vars($wt_zscore[$index]));
                                    $count = $wt_value_count + 1;
                                    $wt_zscore[$index]->{"value_" . $count} = number_format($value->current_weight / 1000, 2);
                                    $wt_zscore[$index]->{"chronological_age_" . $count} = $chronological_age['chronological_age'];
                                    $wt_zscore[$index]->{"cage_" . $count} = $chronological_age['chronological_age'];
                                    if ($count > $wt_value_count)
                                    {
                                        $wt_value_count = $count;
                                    }
                                    $wt_zscore[$index]->{"label_name_" . $count} = 'Chronological';
                                    $wt_zscore[$index]->{"display_age_" . $count} = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                    $wt_zscore[$index]->{"data_from_" . $count} = 'Pediatric Admission';
                                }
                            }

                        }

                        if (isset($value->current_height) && !empty($value->current_height) && $value->current_height > 0)
                        {
                            if (isset($ht_zscore[$index]))
                            {
                                if (!isset($ht_zscore[$index]->value) || (isset($ht_zscore[$index]->value) && empty($ht_zscore[$index]->value)))
                                {
                                    $ht_zscore[$index]->value = number_format($value->current_height, 1);
                                    $ht_zscore[$index]->chronological_age = $chronological_age['chronological_age'];
                                    $ht_zscore[$index]->cage = $chronological_age['chronological_age'];
                                    $ht_zscore[$index]->label_name = 'Chronological';
                                    $ht_zscore[$index]->display_age = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                    $ht_zscore[$index]->data_from = 'Pediatric Admission';
                                }
                                else
                                {
                                    $count = count(get_object_vars($ht_zscore[$index]));
                                    $count = $ht_value_count + 1;
                                    $ht_zscore[$index]->{"value_" . $count} = number_format($value->current_height, 1);
                                    $ht_zscore[$index]->{"chronological_age_" . $count} = $chronological_age['chronological_age'];
                                    $ht_zscore[$index]->{"cage_" . $count} = $chronological_age['chronological_age'];
                                    if ($count > $ht_value_count)
                                    {
                                        $ht_value_count = $count;
                                    }
                                    $ht_zscore[$index]->{"label_name_" . $count} = 'Chronological';
                                    $ht_zscore[$index]->{"display_age_" . $count} = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                    $ht_zscore[$index]->{"data_from_" . $count} = 'Pediatric Admission';
                                }
                            }
                        }
                        if (isset($value->current_head_circumference) && !empty($value->current_head_circumference) && $value->current_head_circumference > 0)
                        {
                            if (isset($hc_zscore[$index]))
                            {
                                if (!isset($hc_zscore[$index]->value) || (isset($hc_zscore[$index]->value) && empty($hc_zscore[$index]->value)))
                                {
                                    $hc_zscore[$index]->value = number_format($value->current_head_circumference, 1);
                                    $hc_zscore[$index]->chronological_age = $chronological_age['chronological_age'];
                                    $hc_zscore[$index]->cage = $chronological_age['chronological_age'];
                                    $hc_zscore[$index]->label_name = 'Chronological';
                                    $hc_zscore[$index]->display_age = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                    $hc_zscore[$index]->data_from = 'Pediatric Admission';
                                }
                                else
                                {
                                    $count = count(get_object_vars($hc_zscore[$index]));
                                    $count = $hc_value_count + 1;
                                    $hc_zscore[$index]->{"value_" . $count} = number_format($value->current_head_circumference, 1);
                                    $hc_zscore[$index]->{"chronological_age_" . $count} = $chronological_age['chronological_age'];
                                    $hc_zscore[$index]->{"cage_" . $count} = $chronological_age['chronological_age'];
                                    if ($count > $hc_value_count)
                                    {
                                        $hc_value_count = $count;
                                    }
                                    $hc_zscore[$index]->{"label_name_" . $count} = 'Chronological';
                                    $hc_zscore[$index]->{"display_age_" . $count} = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                    $hc_zscore[$index]->{"data_from_" . $count} = 'Pediatric Admission';
                                }
                            }
                            $same_date_value_list['ofc'][] = $value->admission_date;
                        }
                        if ((isset($value->current_weight) && !empty($value->current_weight) && $value->current_weight > 0) && (isset($value->current_height) && !empty($value->current_height) && $value->current_height > 0))
                        {

                            $length = $value->current_height / 100;
                            $weight = $value->current_weight / 1000;
                            $bmi = $weight / ($length * $length);

                            if (isset($bmi_percentiles[$index]))
                            {
                                if (!isset($bmi_percentiles[$index]->value) || (isset($bmi_percentiles[$index]->value) && empty($bmi_percentiles[$index]->value)))
                                {
                                    $bmi_percentiles[$index]->value = number_format($bmi, 1);
                                    $bmi_percentiles[$index]->chronological_age = $chronological_age['chronological_age'];
                                    $bmi_percentiles[$index]->cage = $chronological_age['chronological_age'];
                                    $bmi_percentiles[$index]->label_name = 'Chronological';
                                    $bmi_percentiles[$index]->display_age = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                    $bmi_percentiles[$index]->data_from = 'Pediatric Admission';
                                }
                                else
                                {
                                    $count = count(get_object_vars($bmi_percentiles[$index]));
                                    $count = $bmi_value_count + 1;
                                    $bmi_percentiles[$index]->{"value_" . $count} = number_format($bmi, 1);
                                    $bmi_percentiles[$index]->{"chronological_age_" . $count} = $chronological_age['chronological_age'];
                                    $bmi_percentiles[$index]->{"cage_" . $count} = $chronological_age['chronological_age'];
                                    if ($count > $bmi_value_count)
                                    {
                                        $bmi_value_count = $count;
                                    }
                                    $bmi_percentiles[$index]->{"label_name_" . $count} = 'Chronological';
                                    $bmi_percentiles[$index]->{"display_age_" . $count} = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                    $bmi_percentiles[$index]->{"data_from_" . $count} = 'Pediatric Admission';
                                }
                            }
                        }
                    }
                }
            }

        //Pediatric Discharge
            $previous_pediatric_discharge_list = Pediatric::getAllPreviousDischarge($baby_id);
            $previous_pediatric_discharge_list = $previous_pediatric_discharge_list->sortBy('status_date');

            foreach ($previous_pediatric_discharge_list as $key => $value)
            {

                if ((isset($baby->DOB) && !empty($baby->DOB)) && (isset($value->status_date) && !empty($value->status_date))) {

                    $chronological_age = $this->getChronologicalage($baby->DOB, $value->status_date);

                    if ($chronological_age >= 5)
                    {
                        $index = $this->getPosition($chronological_age['years'], $chronological_age['months']);

                        if (isset($value->status_weight) && !empty($value->status_weight) && $value->status_weight > 0)
                        {
                            if (isset($wt_zscore[$index]))
                            {
                                if (!isset($wt_zscore[$index]->value) || (isset($wt_zscore[$index]->value) && empty($wt_zscore[$index]->value)))
                                {
                                    $wt_zscore[$index]->value = number_format($value->status_weight, 2);
                                    $wt_zscore[$index]->chronological_age = $chronological_age['chronological_age'];
                                    $wt_zscore[$index]->cage = $chronological_age['chronological_age'];
                                    $wt_zscore[$index]->label_name = 'Chronological';
                                    $wt_zscore[$index]->display_age = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                    $wt_zscore[$index]->data_from = 'Pediatric Discharge';
                                }
                                else
                                {
                                    $count = count(get_object_vars($wt_zscore[$index]));
                                    $count = $wt_value_count + 1;
                                    $wt_zscore[$index]->{"value_" . $count} = number_format($value->status_weight, 2);
                                    $wt_zscore[$index]->{"chronological_age_" . $count} = $chronological_age['chronological_age'];
                                    $wt_zscore[$index]->{"cage_" . $count} = $chronological_age['chronological_age'];
                                    if ($count > $wt_value_count)
                                    {
                                        $wt_value_count = $count;
                                    }
                                    $wt_zscore[$index]->{"label_name_" . $count} = 'Chronological';
                                    $wt_zscore[$index]->{"display_age_" . $count} = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                    $wt_zscore[$index]->{"data_from_" . $count} = 'Pediatric Discharge';
                                }
                            }

                        }

                    }

                }

            }
            $previous_neuro_op_list = NeuroVisit::GetNeuroVisitList($baby_id);

            foreach ($previous_neuro_op_list as $neuro_op_values)
            {
                if (isset($baby->DOB) && isset($neuro_op_values->visit_date))
                {

                    if ($gestation_weeks >= 37 || $gestation_weeks == null)
                    {
                        $chronological_age = $this->getChronologicalage($baby->DOB, $neuro_op_values->visit_date);

                        if ($chronological_age > 0)
                        {
                            if (isset($neuro_op_values->current_weight_g) && !empty($neuro_op_values->current_weight_g) && $neuro_op_values->current_weight_g > 0 && isset($same_date_value_list['wt']) &&  !in_array($neuro_op_values->visit_date, $same_date_value_list['wt']))
                            {
                                $index = $this->getPosition($chronological_age['years'], $chronological_age['months']);
                                if (isset($wt_zscore[$index]))
                                {
                                    if (!isset($wt_zscore[$index]->value) || (isset($wt_zscore[$index]->value) && empty($wt_zscore[$index]->value)))
                                    {
                                        $wt_zscore[$index]->value = number_format($neuro_op_values->current_weight_g / 1000, 2);
                                        $wt_zscore[$index]->chronological_age = $chronological_age['chronological_age'];
                                        $wt_zscore[$index]->cage = $chronological_age['chronological_age'];
                                        $wt_zscore[$index]->label_name = 'Chronological';
                                        $wt_zscore[$index]->display_age = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';                             
                                        $wt_zscore[$index]->data_from = 'OP (Neuro)';
                                    }
                                    else
                                    {
                                        $count = count(get_object_vars($wt_zscore[$index]));
                                        $count = $wt_value_count + 1;
                                        $wt_zscore[$index]->{"value_" . $count} = number_format($neuro_op_values->current_weight_g / 1000, 2);
                                        $wt_zscore[$index]->{"chronological_age_" . $count} = $chronological_age['chronological_age'];
                                        $wt_zscore[$index]->{"cage_" . $count} = $chronological_age['chronological_age'];
                                        if ($count > $wt_value_count)
                                        {
                                            $wt_value_count = $count;
                                        }
                                        $wt_zscore[$index]->{"label_name_" . $count} = 'Chronological';
                                        $wt_zscore[$index]->{"display_age_" . $count} = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                        $wt_zscore[$index]->{"data_from_" . $count} = 'OP (Neuro)';
                                    }
                                }

                            }

                            if (isset($neuro_op_values->current_length) && !empty($neuro_op_values->current_length) && $neuro_op_values->current_length > 0 && isset($same_date_value_list['len']) && !in_array($neuro_op_values->visit_date, $same_date_value_list['len']))
                            {
                                $index = $this->getPosition($chronological_age['years'], $chronological_age['months']);
                                if (isset($ht_zscore[$index]))
                                {
                                    if (!isset($ht_zscore[$index]->value) || (isset($ht_zscore[$index]->value) && empty($ht_zscore[$index]->value)))
                                    {
                                        $ht_zscore[$index]->value = number_format($neuro_op_values->current_length, 1);
                                        $ht_zscore[$index]->chronological_age = $chronological_age['chronological_age'];
                                        $ht_zscore[$index]->cage = $chronological_age['chronological_age'];
                                        $ht_zscore[$index]->label_name = 'Chronological';
                                        $ht_zscore[$index]->display_age = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                        $ht_zscore[$index]->data_from = 'OP (Neuro)';
                                    }
                                    else
                                    {
                                        $count = count(get_object_vars($ht_zscore[$index]));
                                        $count = $ht_value_count + 1;
                                        $ht_zscore[$index]->{"value_" . $count} = number_format($neuro_op_values->current_length, 1);
                                        $ht_zscore[$index]->{"chronological_age_" . $count} = $chronological_age['chronological_age'];
                                        $ht_zscore[$index]->{"cage_" . $count} = $chronological_age['chronological_age'];
                                        if ($count > $ht_value_count)
                                        {
                                            $ht_value_count = $count;
                                        }
                                        $ht_zscore[$index]->{"label_name_" . $count} = 'Chronological';
                                        $ht_zscore[$index]->{"display_age_" . $count} = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                        $ht_zscore[$index]->{"data_from_" . $count} = 'OP (Neuro)';
                                    }
                                }
                            }


                            if (isset($neuro_op_values->current_ofc) && !empty($neuro_op_values->current_ofc) && $neuro_op_values->current_ofc > 0 && isset($same_date_value_list['ofc']) && !in_array($neuro_op_values->visit_date, $same_date_value_list['ofc']))
                            {
                                $index = $this->getPosition($chronological_age['years'], $chronological_age['months']);
                                if (isset($hc_zscore[$index]))
                                {
                                    if (!isset($hc_zscore[$index]->value) || (isset($hc_zscore[$index]->value) && empty($hc_zscore[$index]->value)))
                                    {
                                        $hc_zscore[$index]->value = number_format($neuro_op_values->current_ofc, 1);
                                        $hc_zscore[$index]->chronological_age = $chronological_age['chronological_age'];
                                        $hc_zscore[$index]->cage = $chronological_age['chronological_age'];
                                        $hc_zscore[$index]->label_name = 'Chronological';
                                        $hc_zscore[$index]->display_age = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                        $hc_zscore[$index]->data_from = 'OP (Neuro)';
                                    }
                                    else
                                    {

                                        $count = count(get_object_vars($hc_zscore[$index]));
                                        $count = $hc_value_count + 1;
                                        $hc_zscore[$index]->{"value_" . $count} = number_format($neuro_op_values->current_ofc, 1);
                                        $hc_zscore[$index]->{"chronological_age_" . $count} = $chronological_age['chronological_age'];
                                        $hc_zscore[$index]->{"cage_" . $count} = $chronological_age['chronological_age'];
                                        if ($count > $hc_value_count)
                                        {
                                            $hc_value_count = $count;
                                        }
                                        $hc_zscore[$index]->{"label_name_" . $count} = 'Chronological';
                                        $hc_zscore[$index]->{"display_age_" . $count} = '[bold]' . $chronological_age['years'] . '[/]Y [bold]' . $chronological_age['months'] . '[/]M [bold]' . $chronological_age['days'] . '[/]D';
                                        $hc_zscore[$index]->{"data_from_" . $count} = 'OP (Neuro)';
                                    }
                                }
                            }

                        }
                    }
                    else
                    {
                        $corrected_age = $this->calculateCorrectedGestation($gestation_weeks, $gestation_days, $baby->DOB, $neuro_op_values->visit_date);

                        $corrected_age_weeks = $corrected_age['corrected_age_weeks'] + number_format(($corrected_age['corrected_age_days'] / 7) , 1);

                        if ($corrected_age_weeks > 64)
                        {
                            $corrected_age_month = $this->calculateCorrectedAge($gestation_weeks, $gestation_days, $baby->DOB, $neuro_op_values->visit_date);

                            if (isset($neuro_op_values->current_weight_g) && !empty($neuro_op_values->current_weight_g) && $neuro_op_values->current_weight_g > 0 && isset($same_date_value_list['wt']) && !in_array($neuro_op_values->visit_date, $same_date_value_list['wt']))
                            {
                                $index = $this->getPosition($corrected_age_month['years'], $corrected_age_month['months']);
                                if (isset($wt_zscore[$index]))
                                {
                                    if (!isset($wt_zscore[$index]->value) || (isset($wt_zscore[$index]->value) && empty($wt_zscore[$index]->value)))
                                    {
                                        $wt_zscore[$index]->value = number_format($neuro_op_values->current_weight_g / 1000, 2);
                                        $wt_zscore[$index]->chronological_age = $corrected_age_month['corrected_age'];
                                        $wt_zscore[$index]->cage = $corrected_age_month['corrected_age'];
                                        $wt_zscore[$index]->label_name = 'Corrected';
                                        $wt_zscore[$index]->display_age = '[bold]' . $corrected_age_month['years'] . '[/]Y [bold]' . $corrected_age_month['months'] . '[/]M [bold]' . $corrected_age_month['days'] . '[/]D';
                                        $wt_zscore[$index]->data_from = 'OP (Neuro)';
                                    }
                                    else
                                    {
                                        $count = count(get_object_vars($wt_zscore[$index]));
                                        $count = $wt_value_count + 1;
                                        $wt_zscore[$index]->{"value_" . $count} = number_format($neuro_op_values->current_weight_g / 1000, 2);
                                        $wt_zscore[$index]->{"chronological_age_" . $count} = $corrected_age_month['corrected_age'];
                                        $wt_zscore[$index]->{"cage_" . $count} = $corrected_age_month['corrected_age'];
                                        if ($count > $wt_value_count)
                                        {
                                            $wt_value_count = $count;
                                        }
                                        $wt_zscore[$index]->{"label_name_" . $count} = 'Corrected';
                                        $wt_zscore[$index]->{"display_age_" . $count} = '[bold]' . $corrected_age_month['years'] . '[/]Y [bold]' . $corrected_age_month['months'] . '[/]M [bold]' . $corrected_age_month['days'] . '[/]D';
                                        $wt_zscore[$index]->{"data_from_" . $count} = 'OP (Neuro)';
                                    }
                                }

                            }
                            if (isset($neuro_op_values->current_length) && !empty($neuro_op_values->current_length) && $neuro_op_values->current_length > 0 && isset($same_date_value_list['len']) && !in_array($neuro_op_values->visit_date, $same_date_value_list['len']))
                            {
                                $index = $this->getPosition($corrected_age_month['years'], $corrected_age_month['months']);
                                if (isset($ht_zscore[$index]))
                                {
                                    if (!isset($ht_zscore[$index]->value) || (isset($ht_zscore[$index]->value) && empty($ht_zscore[$index]->value)))
                                    {
                                        $ht_zscore[$index]->value = number_format($neuro_op_values->current_length, 1);
                                        $ht_zscore[$index]->chronological_age = $corrected_age_month['corrected_age'];
                                        $ht_zscore[$index]->cage = $corrected_age_month['corrected_age'];
                                        $ht_zscore[$index]->label_name = 'Corrected';
                                        $ht_zscore[$index]->display_age = '[bold]' . $corrected_age_month['years'] . '[/]Y [bold]' . $corrected_age_month['months'] . '[/]M [bold]' . $corrected_age_month['days'] . '[/]D';                                    
                                        $ht_zscore[$index]->data_from = 'OP (Neuro)';
                                    }
                                    else
                                    {
                                        $count = count(get_object_vars($ht_zscore[$index]));
                                        $count = $ht_value_count + 1;
                                        $ht_zscore[$index]->{"value_" . $count} = number_format($neuro_op_values->current_length, 1);
                                        $ht_zscore[$index]->{"chronological_age_" . $count} = $corrected_age_month['corrected_age'];
                                        $ht_zscore[$index]->{"cage_" . $count} = $corrected_age_month['corrected_age'];
                                        if ($count > $ht_value_count)
                                        {
                                            $ht_value_count = $count;
                                        }
                                        $ht_zscore[$index]->{"label_name_" . $count} = 'Corrected';
                                        $ht_zscore[$index]->{"display_age_" . $count} = '[bold]' . $corrected_age_month['years'] . '[/]Y [bold]' . $corrected_age_month['months'] . '[/]M [bold]' . $corrected_age_month['days'] . '[/]D';
                                        $ht_zscore[$index]->{"data_from_" . $count} = 'OP (Neuro)';
                                    }
                                }
                            }
                            if (isset($neuro_op_values->current_ofc) && !empty($neuro_op_values->current_ofc) && $neuro_op_values->current_ofc > 0 && isset($same_date_value_list['ofc']) && !in_array($neuro_op_values->visit_date, $same_date_value_list['ofc']))
                            {
                                $index = $this->getPosition($corrected_age_month['years'], $corrected_age_month['months']);
                                if (isset($hc_zscore[$index]))
                                {
                                    if (!isset($hc_zscore[$index]->value) || (isset($hc_zscore[$index]->value) && empty($hc_zscore[$index]->value)))
                                    {
                                        $hc_zscore[$index]->value = number_format($neuro_op_values->current_ofc, 1);
                                        $hc_zscore[$index]->chronological_age = $corrected_age_month['corrected_age'];
                                        $hc_zscore[$index]->cage = $corrected_age_month['corrected_age'];
                                        $hc_zscore[$index]->label_name = 'Corrected';
                                        $hc_zscore[$index]->display_age = '[bold]' . $corrected_age_month['years'] . '[/]Y [bold]' . $corrected_age_month['months'] . '[/]M [bold]' . $corrected_age_month['days'] . '[/]D';     
                                        $hc_zscore[$index]->data_from = 'OP (Neuro)';
                                    }
                                    else
                                    {
                                        $count = count(get_object_vars($hc_zscore[$index]));
                                        $count = $hc_value_count + 1;
                                        $hc_zscore[$index]->{"value_" . $count} = number_format($neuro_op_values->current_ofc, 1);
                                        $hc_zscore[$index]->{"chronological_age_" . $count} = $corrected_age_month['corrected_age'];
                                        $hc_zscore[$index]->{"cage_" . $count} = $corrected_age_month['corrected_age'];
                                        if ($count > $hc_value_count)
                                        {
                                            $hc_value_count = $count;
                                        }
                                        $hc_zscore[$index]->{"label_name_" . $count} = 'Corrected';
                                        $hc_zscore[$index]->{"display_age_" . $count} = '[bold]' . $corrected_age_month['years'] . '[/]Y [bold]' . $corrected_age_month['months'] . '[/]M [bold]' . $corrected_age_month['days'] . '[/]D';
                                        $hc_zscore[$index]->{"data_from_" . $count} = 'OP (Neuro)';
                                    }
                                }
                            }

                        }
                    }
                }
            }

            
            $wt_provider = collect($wt_zscore)->groupBy('age');
            $ht_provider = collect($ht_zscore)->groupBy('age');
            $hc_provider = collect($hc_zscore)->groupBy('age');

       // echo "<pre>"; print_r($ht_provider);exit;
  

            $closewinlink = $request->get('closewinlink');

            if ($closewinlink == 'pediatric_edit') {
                $pediatric_id = $request->get('id');
                $closewinlink = action('Registration\PediatricOpController@edit', $pediatric_id);

            } elseif ($closewinlink == 'pediatric_create') {
                $id = $request->get('baby_id');
                $closewinlink = action('Registration\PediatricOpController@create').'/'.$id;
            } elseif ($closewinlink == 'neonatal_edit') {
                $neonatal_id = $request->get('id');
                $closewinlink = action('Registration\OpController@edit', $neonatal_id);
            } elseif ($closewinlink == 'neonatal_create') {
                $id = $request->get('baby_id');
                $closewinlink = action('Registration\OpController@create').'/'.$id;
            } elseif ($closewinlink == 'neuro_edit') {
                $neuro_id = $request->get('id');
                $closewinlink = action('Registration\NeuroController@edit', $neuro_id);
            } elseif ($closewinlink == 'neuro_create') {
                $id = $request->get('baby_id');
                $closewinlink = action('Registration\NeuroController@create').'/'.$id;
            } elseif ($closewinlink == 'search-reports') {
                $id = $request->get('baby_id');
                $closewinlink = action('HomeController@search').'?baby_id='.$id;
            } elseif ($closewinlink == 'pediatric_admission_edit') {
                $id = $request->get('id');
                $closewinlink = action('Admission\PediatricController@edit', $id);
            } else {
                $closewinlink = url($request->get('closewinlink'));
            }


            if ($gestation_weeks >= 37 || $gestation_weeks == null)
            {
                $chronological_age = $this->getChronologicalage($baby->DOB, date('Y-m-d'));

                if ($chronological_age['years'] == 0) {
                    $corrected_gestation_plot = 'Birth_' . $chronological_age['months'];
                } else if ($chronological_age['years'] == 1) {
                    $corrected_gestation_plot = $chronological_age['years'] . ' year_' . $chronological_age['months'];
                } else {
                    $corrected_gestation_plot = $chronological_age['years'] . ' years_' . $chronological_age['months'];
                }
            }
            else
            {
                $corrected_age = $this->calculateCorrectedGestation($gestation_weeks, $gestation_days, $baby->DOB, date('Y-m-d'));

                $corrected_age_weeks = $corrected_age['corrected_age_weeks'] + number_format(($corrected_age['corrected_age_days'] / 7) , 1);

                $corrected_age_month = $this->calculateCorrectedAge($gestation_weeks, $gestation_days, $baby->DOB, date('Y-m-d'));

                if ($corrected_age_month['years'] == 0) {
                    $corrected_gestation_plot = 'Birth_' . $corrected_age_month['months'];
                } else if ($corrected_age_month['years'] == 1) {
                    $corrected_gestation_plot = $corrected_age_month['years'] . ' year_' . $corrected_age_month['months'];
                } else {
                    $corrected_gestation_plot = $corrected_age_month['years'] . ' years_' . $corrected_age_month['months'];
                }
            }


            if (strtolower($baby->Sex) == 'female' || strtolower($baby->Sex) == 'male')
            {
                return view('chart.zscore_chart', compact('wt_provider', 'ht_provider', 'hc_provider', 'wt_value_count', 'ht_value_count', 'hc_value_count', 'baby', 'closewinlink', 'corrected_gestation_plot'));
            }
            else
            {
                return redirect()
                ->back()
                ->with('error', 'Baby Gender is empty...!');
            }
        }

 private function calculateCorrectedGestation($gestation_weeks, $gestation_days, $dob, $calculate_date)
    {
        if ($gestation_weeks != '' && ($gestation_days != '' || $gestation_days == 0) && $dob != '' && $calculate_date != '')
        {
            $dob = strtotime($dob); // or your date as well
            $current_date = strtotime($calculate_date);
            $datediff = $current_date - $dob;
            $chronological_age_days = $datediff / (60 * 60 * 24);


      
            $corrected_age = 0;
            if (is_numeric($gestation_days)) {
                $corrected_age = $chronological_age_days + ($gestation_weeks * 7) + $gestation_days;
            } else {
                $corrected_age = $chronological_age_days + ($gestation_weeks * 7);                
            }

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
        $days = ($diffinmonths_day[2] == 0) ? $diffinmonth + $diffinmonths_day[2] : number_format($diffinmonth + ($diffinmonths_day[2] / 30) , 1);

        $result['years'] = $diffinmonths_day[0];
        $result['months'] = $diffinmonths_day[1];
        $result['days'] = $diffinmonths_day[2];
        $result['chronological_age'] = $days;


        //print_r($diffinmonths_day);exit;

        return $result;

    }

    
    private function calculateCorrectedAge($gestation_weeks, $gestation_days, $dob, $calculate_date)
    {

        if ($gestation_weeks != '' && ($gestation_days != '' || $gestation_days == 0) && $dob != '' && $calculate_date != '')
        {

            $add_days = 0;

            if (is_numeric($gestation_days)) {
                $add_days = (((40 - $gestation_weeks) * 7) + $gestation_days);
            } else {
                $add_days = ((40 - $gestation_weeks) * 7);
            }

            $baby_dob = Carbon::createFromFormat('Y-m-d', $dob)->addWeeks(40 - $gestation_weeks)->addDays($gestation_days);
            $day_date = Carbon::createFromFormat('Y-m-d', $calculate_date);

            $diffinmonths_day = $baby_dob->diff($day_date)->format('%y,%m,%d');

            $diffinmonths_day = explode(',', $diffinmonths_day);
            $diffinmonths_year = $diffinmonths_day[0] * 12;
            $diffinmonth = $diffinmonths_day[1] + $diffinmonths_year;
            $days = ($diffinmonths_day[2] == 0) ? $diffinmonth + $diffinmonths_day[2] : number_format($diffinmonth + ($diffinmonths_day[2] / 30) , 1);
            if ($diffinmonths_day > 0)
            {
                $result['years'] = $diffinmonths_day[0];
                $result['months'] = $diffinmonths_day[1];
                $result['days'] = $diffinmonths_day[2];
                $result['corrected_age'] = $days;
            }
            else
            {
                $result['years'] = 0;
                $result['months'] = 0;
                $result['days'] = 0;
                $result['corrected_age'] = 0;
            }
        }
        else
        {
            $result['years'] = 0;
            $result['months'] = 0;
            $result['days'] = 0;
            $result['corrected_age'] = 0;
        }

        return $result;
    }

    private function getPosition($year, $month, $slug = false)
    {
        if ($slug)
        {
            $year = $year - 5;
            return ($year * 12) + $month;
        }
        else
        {
            return ($year * 12) + $month;
        }

    }
   

    

}
