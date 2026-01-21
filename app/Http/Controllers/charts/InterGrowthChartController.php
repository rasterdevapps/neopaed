<?php
namespace App\Http\Controllers\charts;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Baby;
use App\Models\Op;
use App\Models\Nicu;
use App\Models\Daycare;
use App\Models\Postnatal;
use App\Models\PostnatalDischarge;
use App\Models\Neonatal;
use App\Models\Oppediatric;
use App\Models\NeuroVisit;

class InterGrowthChartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $baby_id = $request->get('baby_id');

        $baby_id = \SiteHelpers::decrypt_id($baby_id);

        $baby_detail = Baby::find($baby_id);

        if (empty($baby_detail->Sex) || is_null($baby_detail->Sex) || $baby_detail->Sex == 'UNKNOWN')
        {
            return redirect()
            ->back()
            ->with('error', 'Baby Gender is empty...!');
        }
        
        $neonatal = Neonatal::select(\DB::raw("(regexp_matches(\"Length\", '[0-9]+\.?[0-9]*'))[1]::numeric AS \"Length\""), \DB::raw("(regexp_matches(\"OFC\", '[0-9]+\.?[0-9]*'))[1]::numeric AS \"OFC\""))->where('BabyId', $baby_id)->first();

        $percentiles = \DB::table('growth_chart_percentiles')->select('id', 'week_wise_age', 'chart_third_percentile as third_percentile', 'chart_tenth_percentile as tenth_percentile', 'chart_fiftieth_percentile as fiftieth_percentile', 'chart_ninety_percentile as ninety_percentile', 'chart_ninetyseventh_percentile as ninetyseventh_percentile', 'type')
            ->where('category', 'INTERGROWTH')
            ->where('gender', $baby_detail->Sex[0])
            ->orderBy('id', 'asc')
            ->get()
            ->toArray();

        $percentiles = collect($percentiles)->groupBy('type');

        $wt_percentiles = $percentiles['Weight'];
        $ht_percentiles = $percentiles['Height'];
        $hc_percentiles = $percentiles['Head Circumference'];

        $wt_value_count = 0;
        $ht_value_count = 0;
        $hc_value_count = 0;

        $gestation_weeks = isset($baby_detail->Gestation) ? json_decode($baby_detail->Gestation)->g_weeks : null;
        $gestation_days = isset($baby_detail->Gestation) ? json_decode($baby_detail->Gestation)->g_days : 0;

        if ($gestation_weeks < 37)
        {
            //Birth weight
            if (isset($baby_detail->BirthWeight) && !empty($baby_detail->BirthWeight) && $baby_detail->BirthWeight > 0)
            {
                $corrected_gestation_plot = $baby_detail->g_weeks + number_format(($baby_detail->g_days / 7) , 1);

                $index = $this->getPosition($baby_detail->g_weeks);

                $wt_percentiles[$index]->chronological_age = $corrected_gestation_plot;
                $wt_percentiles[$index]->cage = $corrected_gestation_plot;
                $wt_percentiles[$index]->value = number_format($baby_detail->BirthWeight / 1000, 1);
                $wt_percentiles[$index]->display_age = '[bold]' . $baby_detail->g_weeks . '[/]W [bold]' . $baby_detail->g_days . '[/]D';
                $wt_percentiles[$index]->data_from = 'Baby Details';

            }
            //Birth length
            if (isset($neonatal->Length) && !empty($neonatal->Length) && $neonatal->Length > 0)
            {
                $corrected_gestation_plot = $baby_detail->g_weeks + number_format(($baby_detail->g_days / 7) , 1);

                $index = $this->getPosition($baby_detail->g_weeks);

                $ht_percentiles[$index]->chronological_age = $corrected_gestation_plot;
                $ht_percentiles[$index]->cage = $corrected_gestation_plot;
                $ht_percentiles[$index]->value = number_format($neonatal->Length, 1);
                $ht_percentiles[$index]->display_age = '[bold]' . $baby_detail->g_weeks . '[/]W [bold]' . $baby_detail->g_days . '[/]D';
                $ht_percentiles[$index]->data_from = 'Baby Details';
            }

            //Birth ofc
            if (isset($neonatal->OFC) && !empty($neonatal->OFC) && $neonatal->OFC > 0)
            {
                $corrected_gestation_plot = $baby_detail->g_weeks + number_format(($baby_detail->g_days / 7) , 1);

                $index = $this->getPosition($baby_detail->g_weeks);

                $hc_percentiles[$index]->chronological_age = $corrected_gestation_plot;
                $hc_percentiles[$index]->cage = $corrected_gestation_plot;
                $hc_percentiles[$index]->value = number_format($neonatal->OFC, 1);
                $hc_percentiles[$index]->display_age = '[bold]' . $baby_detail->g_weeks . '[/]W [bold]' . $baby_detail->g_days . '[/]D';
                $hc_percentiles[$index]->data_from = 'Baby Details';

            }

            $nicu_admission = $nicu_discharge = Nicu::where('BabyId', $baby_id)->where('IsDeleted', 0)
                ->get();

            // nicu admission details
            foreach ($nicu_admission as $nakey => $navalue)
            {
                $corrected_gestation = $this->calculateCorrectedGestation($gestation_weeks, $gestation_days, $baby_detail->DOB, $navalue->AdmissionDate);

                if (is_array($corrected_gestation))
                {

                    $corrected_gestation_plot = $corrected_gestation['corrected_age_weeks'] + number_format(($corrected_gestation['corrected_age_days'] / 7) , 1);

                    if ($corrected_gestation_plot <= 64)
                    {

                        if (isset($navalue->AdmissionWt) && !empty($navalue->AdmissionWt) && $navalue->AdmissionWt > 0)
                        {

                            $index = $this->getPosition($corrected_gestation['corrected_age_weeks']);

                            if (!isset($wt_percentiles[$index]->value) || (isset($wt_percentiles[$index]->value) && empty($wt_percentiles[$index]->value)))
                            {
                                $wt_percentiles[$index]->chronological_age = $corrected_gestation_plot;
                                $wt_percentiles[$index]->cage = $corrected_gestation_plot;
                                $wt_percentiles[$index]->value = number_format($navalue->AdmissionWt / 1000, 1);
                                $wt_percentiles[$index]->display_age = '[bold]' . $corrected_gestation['corrected_age_weeks'] . '[/]W [bold]' . $corrected_gestation['corrected_age_days'] . '[/]D';
                                $wt_percentiles[$index]->data_from = 'NICU Admission';
                            }
                            else
                            {
                                $count = $wt_value_count + 1;
                                $wt_percentiles[$index]->{"chronological_age_" . $count} = $corrected_gestation_plot;
                                $wt_percentiles[$index]->{"cage_" . $count} = $corrected_gestation_plot;
                                $wt_percentiles[$index]->{"value_" . $count} = number_format($navalue->AdmissionWt / 1000, 1);
                                $wt_percentiles[$index]->{"display_age_" . $count} = '[bold]' . $corrected_gestation['corrected_age_weeks'] . '[/]W [bold]' . $corrected_gestation['corrected_age_days'] . '[/]D';
                                $wt_percentiles[$index]->{"data_from_" . $count} = 'NICU Admission';
                                if ($count > $wt_value_count)
                                {
                                    $wt_value_count = $count;
                                }
                            }
                        }

                    }

                }
            }

            $chart_days_from_daycare = \SiteHelpers::getDaysForChart();
            $nicuDaycare = Daycare::select('DayDate', \DB::raw("(regexp_matches(\"CurrentWt\", '[0-9]+\.?[0-9]*'))[1]::numeric AS \"CurrentWt\""), \DB::raw("(regexp_matches(length, '[0-9]+\.?[0-9]*'))[1]::numeric AS length"), \DB::raw("(regexp_matches(head_circumference, '[0-9]+\.?[0-9]*'))[1]::numeric AS head_circumference"))->where('BabyId', $baby_id)->where('IsDeleted', 0)
                ->get();

            // nicu daycare
            foreach ($nicuDaycare as $ndkey => $ndvalue)
            {

                $corrected_gestation = $this->calculateCorrectedGestation($gestation_weeks, $gestation_days, $baby_detail->DOB, $ndvalue->DayDate);

                if (is_array($corrected_gestation) && in_array(date('D', strtotime($ndvalue->DayDate)) , $chart_days_from_daycare))
                {

                    $corrected_gestation_plot = $corrected_gestation['corrected_age_weeks'] + number_format(($corrected_gestation['corrected_age_days'] / 7) , 1);

                    if ($corrected_gestation_plot <= 64)
                    {

                        if (isset($ndvalue->CurrentWt) && !empty($ndvalue->CurrentWt) && $ndvalue->CurrentWt > 0)
                        {

                            $index = $this->getPosition($corrected_gestation['corrected_age_weeks']);

                            if (!isset($wt_percentiles[$index]->value) || (isset($wt_percentiles[$index]->value) && empty($wt_percentiles[$index]->value)))
                            {
                                $wt_percentiles[$index]->chronological_age = $corrected_gestation_plot;
                                $wt_percentiles[$index]->cage = $corrected_gestation_plot;
                                $wt_percentiles[$index]->value = number_format($ndvalue->CurrentWt / 1000, 1);
                                $wt_percentiles[$index]->display_age = '[bold]' . $corrected_gestation['corrected_age_weeks'] . '[/]W [bold]' . $corrected_gestation['corrected_age_days'] . '[/]D';
                                $wt_percentiles[$index]->data_from = 'NICU Daycare';
                            }
                            else
                            {
                                $count = $wt_value_count + 1;
                                $wt_percentiles[$index]->{"chronological_age_" . $count} = $corrected_gestation_plot;
                                $wt_percentiles[$index]->{"cage_" . $count} = $corrected_gestation_plot;
                                $wt_percentiles[$index]->{"value_" . $count} = number_format($ndvalue->CurrentWt / 1000, 1);
                                $wt_percentiles[$index]->{"display_age_" . $count} = '[bold]' . $corrected_gestation['corrected_age_weeks'] . '[/]W [bold]' . $corrected_gestation['corrected_age_days'] . '[/]D';
                                $wt_percentiles[$index]->{"data_from_" . $count} = 'NICU Daycare';
                                if ($count > $wt_value_count)
                                {
                                    $wt_value_count = $count;
                                }
                            }

                        }

                        if (isset($ndvalue->length) && !empty($ndvalue->length) && $ndvalue->length > 0)
                        {

                            $index = $this->getPosition($corrected_gestation['corrected_age_weeks']);

                            if (!isset($ht_percentiles[$index]->value) || (isset($ht_percentiles[$index]->value) && empty($ht_percentiles[$index]->value)))
                            {
                                $ht_percentiles[$index]->chronological_age = $corrected_gestation_plot;
                                $ht_percentiles[$index]->cage = $corrected_gestation_plot;
                                $ht_percentiles[$index]->value = number_format($ndvalue->length, 1);
                                $ht_percentiles[$index]->display_age = '[bold]' . $corrected_gestation['corrected_age_weeks'] . '[/]W [bold]' . $corrected_gestation['corrected_age_days'] . '[/]D';
                                $ht_percentiles[$index]->data_from = 'NICU Daycare';
                            }
                            else
                            {
                                $count = $ht_value_count + 1;
                                $ht_percentiles[$index]->{"chronological_age_" . $count} = $corrected_gestation_plot;
                                $ht_percentiles[$index]->{"cage_" . $count} = $corrected_gestation_plot;
                                $ht_percentiles[$index]->{"value_" . $count} = number_format($ndvalue->length, 1);
                                $ht_percentiles[$index]->{"display_age_" . $count} = '[bold]' . $corrected_gestation['corrected_age_weeks'] . '[/]W [bold]' . $corrected_gestation['corrected_age_days'] . '[/]D';
                                $ht_percentiles[$index]->{"data_from_" . $count} = 'NICU Daycare';
                                if ($count > $ht_value_count)
                                {
                                    $ht_value_count = $count;
                                }
                            }

                        }

                        if (isset($ndvalue->head_circumference) && !empty($ndvalue->head_circumference) && $ndvalue->head_circumference > 0)
                        {

                            $index = $this->getPosition($corrected_gestation['corrected_age_weeks']);

                            if (!isset($hc_percentiles[$index]->value) || (isset($hc_percentiles[$index]->value) && empty($hc_percentiles[$index]->value)))
                            {
                                $hc_percentiles[$index]->chronological_age = $corrected_gestation_plot;
                                $hc_percentiles[$index]->cage = $corrected_gestation_plot;
                                $hc_percentiles[$index]->value = number_format($ndvalue->head_circumference, 1);
                                $hc_percentiles[$index]->display_age = '[bold]' . $corrected_gestation['corrected_age_weeks'] . '[/]W [bold]' . $corrected_gestation['corrected_age_days'] . '[/]D';
                                $hc_percentiles[$index]->data_from = 'NICU Daycare';
                            }
                            else
                            {
                                $count = $hc_value_count + 1;
                                $hc_percentiles[$index]->{"chronological_age_" . $count} = $corrected_gestation_plot;
                                $hc_percentiles[$index]->{"cage_" . $count} = $corrected_gestation_plot;
                                $hc_percentiles[$index]->{"value_" . $count} = number_format($ndvalue->head_circumference, 1);
                                $hc_percentiles[$index]->{"display_age_" . $count} = '[bold]' . $corrected_gestation['corrected_age_weeks'] . '[/]W [bold]' . $corrected_gestation['corrected_age_days'] . '[/]D';
                                $hc_percentiles[$index]->{"data_from_" . $count} = 'NICU Daycare';
                                if ($count > $hc_value_count)
                                {
                                    $hc_value_count = $count;
                                }
                            }

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

                        if (isset($value->DischargeWeight) && !empty($value->DischargeWeight) && $value->DischargeWeight > 0)
                        {

                            $index = $this->getPosition($corrected_gestation['corrected_age_weeks']);

                            if (!isset($wt_percentiles[$index]->value) || (isset($wt_percentiles[$index]->value) && empty($wt_percentiles[$index]->value)))
                            {
                                $wt_percentiles[$index]->chronological_age = $corrected_gestation_plot;
                                $wt_percentiles[$index]->cage = $corrected_gestation_plot;
                                $wt_percentiles[$index]->value = number_format($value->DischargeWeight / 1000, 1);
                                $wt_percentiles[$index]->display_age = '[bold]' . $corrected_gestation['corrected_age_weeks'] . '[/]W [bold]' . $corrected_gestation['corrected_age_days'] . '[/]D';
                                $wt_percentiles[$index]->data_from = 'NICU Discharge';
                            }
                            else
                            {
                                $count = $wt_value_count + 1;
                                $wt_percentiles[$index]->{"chronological_age_" . $count} = $corrected_gestation_plot;
                                $wt_percentiles[$index]->{"cage_" . $count} = $corrected_gestation_plot;
                                $wt_percentiles[$index]->{"value_" . $count} = number_format($value->DischargeWeight / 1000, 1);
                                $wt_percentiles[$index]->{"display_age_" . $count} = '[bold]' . $corrected_gestation['corrected_age_weeks'] . '[/]W [bold]' . $corrected_gestation['corrected_age_days'] . '[/]D';
                                $wt_percentiles[$index]->{"data_from_" . $count} = 'NICU Discharge';
                                if ($count > $wt_value_count)
                                {
                                    $wt_value_count = $count;
                                }
                            }

                        }

                        if (isset($value->Length) && !empty($value->Length) && $value->Length > 0)
                        {

                            $index = $this->getPosition($corrected_gestation['corrected_age_weeks']);

                            if (!isset($ht_percentiles[$index]->value) || (isset($ht_percentiles[$index]->value) && empty($ht_percentiles[$index]->value)))
                            {
                                $ht_percentiles[$index]->chronological_age = $corrected_gestation_plot;
                                $ht_percentiles[$index]->cage = $corrected_gestation_plot;
                                $ht_percentiles[$index]->value = number_format($value->Length, 1);
                                $ht_percentiles[$index]->display_age = '[bold]' . $corrected_gestation['corrected_age_weeks'] . '[/]W [bold]' . $corrected_gestation['corrected_age_days'] . '[/]D';
                                $ht_percentiles[$index]->data_from = 'NICU Discharge';
                            }
                            else
                            {
                                $count = $ht_value_count + 1;
                                $ht_percentiles[$index]->{"chronological_age_" . $count} = $corrected_gestation_plot;
                                $ht_percentiles[$index]->{"cage_" . $count} = $corrected_gestation_plot;
                                $ht_percentiles[$index]->{"value_" . $count} = number_format($value->Length, 1);
                                $ht_percentiles[$index]->{"display_age_" . $count} = '[bold]' . $corrected_gestation['corrected_age_weeks'] . '[/]W [bold]' . $corrected_gestation['corrected_age_days'] . '[/]D';
                                $ht_percentiles[$index]->{"data_from_" . $count} = 'NICU Discharge';
                                if ($count > $ht_value_count)
                                {
                                    $ht_value_count = $count;
                                }
                            }

                        }

                        if (isset($value->OFC) && !empty($value->OFC) && $value->OFC > 0)
                        {

                            $index = $this->getPosition($corrected_gestation['corrected_age_weeks']);

                            if (!isset($hc_percentiles[$index]->value) || (isset($hc_percentiles[$index]->value) && empty($hc_percentiles[$index]->value)))
                            {
                                $hc_percentiles[$index]->chronological_age = $corrected_gestation_plot;
                                $hc_percentiles[$index]->cage = $corrected_gestation_plot;
                                $hc_percentiles[$index]->value = number_format($value->OFC, 1);
                                $hc_percentiles[$index]->display_age = '[bold]' . $corrected_gestation['corrected_age_weeks'] . '[/]W [bold]' . $corrected_gestation['corrected_age_days'] . '[/]D';
                                $hc_percentiles[$index]->data_from = 'NICU Discharge';
                            }
                            else
                            {
                                $count = $hc_value_count + 1;
                                $hc_percentiles[$index]->{"chronological_age_" . $count} = $corrected_gestation_plot;
                                $hc_percentiles[$index]->{"cage_" . $count} = $corrected_gestation_plot;
                                $hc_percentiles[$index]->{"value_" . $count} = number_format($value->OFC, 1);
                                $hc_percentiles[$index]->{"display_age_" . $count} = '[bold]' . $corrected_gestation['corrected_age_weeks'] . '[/]W [bold]' . $corrected_gestation['corrected_age_days'] . '[/]D';
                                $hc_percentiles[$index]->{"data_from_" . $count} = 'NICU Discharge';
                                if ($count > $hc_value_count)
                                {
                                    $hc_value_count = $count;
                                }
                            }

                        }

                    }
                }

            }

            $postnatal_admission = Postnatal::select('admission_date', \DB::raw("(regexp_matches(admission_wt, '[0-9]+\.?[0-9]*'))[1]::numeric AS admission_wt"))->where('BabyId', $baby_id)->where('IsDeleted', 0)
                ->get();

            // postnatal admission detatils
            foreach ($postnatal_admission as $psa_key => $psa_value)
            {

                $corrected_gestation = $this->calculateCorrectedGestation($gestation_weeks, $gestation_days, $baby_detail->DOB, $psa_value->admission_date);

                if (is_array($corrected_gestation))
                {

                    $corrected_gestation_plot = $corrected_gestation['corrected_age_weeks'] + number_format(($corrected_gestation['corrected_age_days'] / 7) , 1);

                    if ($corrected_gestation_plot <= 64)
                    {

                        if (isset($psa_value->admission_wt) && !empty($psa_value->admission_wt) && $psa_value->admission_wt > 0)
                        {
                            $index = $this->getPosition($corrected_gestation['corrected_age_weeks']);

                            if (!isset($wt_percentiles[$index]->value) || (isset($wt_percentiles[$index]->value) && empty($wt_percentiles[$index]->value)))
                            {
                                $wt_percentiles[$index]->chronological_age = $corrected_gestation_plot;
                                $wt_percentiles[$index]->cage = $corrected_gestation_plot;
                                $wt_percentiles[$index]->value = number_format($psa_value->admission_wt / 1000, 1);
                                $wt_percentiles[$index]->display_age = '[bold]' . $corrected_gestation['corrected_age_weeks'] . '[/]W [bold]' . $corrected_gestation['corrected_age_days'] . '[/]D';
                                $wt_percentiles[$index]->data_from = 'Postnatal Admission';
                            }
                            else
                            {
                                $count = $wt_value_count + 1;
                                $wt_percentiles[$index]->{"chronological_age_" . $count} = $corrected_gestation_plot;
                                $wt_percentiles[$index]->{"cage_" . $count} = $corrected_gestation_plot;
                                $wt_percentiles[$index]->{"value_" . $count} = number_format($psa_value->admission_wt / 1000, 1);
                                $wt_percentiles[$index]->{"display_age_" . $count} = '[bold]' . $corrected_gestation['corrected_age_weeks'] . '[/]W [bold]' . $corrected_gestation['corrected_age_days'] . '[/]D';
                                $wt_percentiles[$index]->{"data_from_" . $count} = 'Postnatal Admission';
                                if ($count > $wt_value_count)
                                {
                                    $wt_value_count = $count;
                                }
                            }

                        }

                    }

                }

            }

            $postnatal_discharge = PostnatalDischarge::select('discharge_date', \DB::raw("(regexp_matches(discharge_wt, '[0-9]+\.?[0-9]*'))[1]::numeric AS discharge_wt"), \DB::raw("(regexp_matches(discharge_length, '[0-9]+\.?[0-9]*'))[1]::numeric AS discharge_length"), \DB::raw("(regexp_matches(discharge_ofc, '[0-9]+\.?[0-9]*'))[1]::numeric AS discharge_ofc"))->where('BabyId', $baby_id)->where('IsDeleted', 0)
                ->get();

            //postnatal weight, length and head
            foreach ($postnatal_discharge as $key => $postnatal_value)
            {

                $corrected_gestation = $this->calculateCorrectedGestation($gestation_weeks, $gestation_days, $baby_detail->DOB, $postnatal_value->discharge_date);

                if (is_array($corrected_gestation))
                {

                    $corrected_gestation_plot = $corrected_gestation['corrected_age_weeks'] + number_format(($corrected_gestation['corrected_age_days'] / 7) , 1);

                    if ($corrected_gestation_plot <= 64)
                    {

                        if (isset($postnatal_value->discharge_wt) && !empty($postnatal_value->discharge_wt) && $postnatal_value->discharge_wt > 0)
                        {

                            $index = $this->getPosition($corrected_gestation['corrected_age_weeks']);

                            if (!isset($wt_percentiles[$index]->value) || (isset($wt_percentiles[$index]->value) && empty($wt_percentiles[$index]->value)))
                            {
                                $wt_percentiles[$index]->chronological_age = $corrected_gestation_plot;
                                $wt_percentiles[$index]->cage = $corrected_gestation_plot;
                                $wt_percentiles[$index]->value = number_format($postnatal_value->discharge_wt / 1000, 1);
                                $wt_percentiles[$index]->display_age = '[bold]' . $corrected_gestation['corrected_age_weeks'] . '[/]W [bold]' . $corrected_gestation['corrected_age_days'] . '[/]D';
                                $wt_percentiles[$index]->data_from = 'Postnatal Discharge';
                            }
                            else
                            {
                                $count = $wt_value_count + 1;
                                $wt_percentiles[$index]->{"chronological_age_" . $count} = $corrected_gestation_plot;
                                $wt_percentiles[$index]->{"cage_" . $count} = $corrected_gestation_plot;
                                $wt_percentiles[$index]->{"value_" . $count} = number_format($postnatal_value->discharge_wt / 1000, 1);
                                $wt_percentiles[$index]->{"display_age_" . $count} = '[bold]' . $corrected_gestation['corrected_age_weeks'] . '[/]W [bold]' . $corrected_gestation['corrected_age_days'] . '[/]D';
                                $wt_percentiles[$index]->{"data_from_" . $count} = 'Postnatal Discharge';
                                if ($count > $wt_value_count)
                                {
                                    $wt_value_count = $count;
                                }
                            }

                        }

                        if (isset($postnatal_value->discharge_length) && !empty($postnatal_value->discharge_length) && $postnatal_value->discharge_length > 0)
                        {

                            $index = $this->getPosition($corrected_gestation['corrected_age_weeks']);

                            if (!isset($ht_percentiles[$index]->value) || (isset($ht_percentiles[$index]->value) && empty($ht_percentiles[$index]->value)))
                            {
                                $ht_percentiles[$index]->chronological_age = $corrected_gestation_plot;
                                $ht_percentiles[$index]->cage = $corrected_gestation_plot;
                                $ht_percentiles[$index]->value = number_format($postnatal_value->discharge_length, 1);
                                $ht_percentiles[$index]->display_age = '[bold]' . $corrected_gestation['corrected_age_weeks'] . '[/]W [bold]' . $corrected_gestation['corrected_age_days'] . '[/]D';
                                $ht_percentiles[$index]->data_from = 'Postnatal Discharge';
                            }
                            else
                            {
                                $count = $ht_value_count + 1;
                                $ht_percentiles[$index]->{"chronological_age_" . $count} = $corrected_gestation_plot;
                                $ht_percentiles[$index]->{"cage_" . $count} = $corrected_gestation_plot;
                                $ht_percentiles[$index]->{"value_" . $count} = number_format($postnatal_value->discharge_length, 1);
                                $ht_percentiles[$index]->{"display_age_" . $count} = '[bold]' . $corrected_gestation['corrected_age_weeks'] . '[/]W [bold]' . $corrected_gestation['corrected_age_days'] . '[/]D';
                                $ht_percentiles[$index]->{"data_from_" . $count} = 'Postnatal Discharge';
                                if ($count > $ht_value_count)
                                {
                                    $ht_value_count = $count;
                                }
                            }

                        }

                        if (isset($postnatal_value->discharge_ofc) && !empty($postnatal_value->discharge_ofc) && $postnatal_value->discharge_ofc > 0)
                        {

                            $index = $this->getPosition($corrected_gestation['corrected_age_weeks']);

                            if (!isset($hc_percentiles[$index]->value) || (isset($hc_percentiles[$index]->value) && empty($hc_percentiles[$index]->value)))
                            {
                                $hc_percentiles[$index]->chronological_age = $corrected_gestation_plot;
                                $hc_percentiles[$index]->cage = $corrected_gestation_plot;
                                $hc_percentiles[$index]->value = number_format($postnatal_value->discharge_ofc, 1);
                                $hc_percentiles[$index]->display_age = '[bold]' . $corrected_gestation['corrected_age_weeks'] . '[/]W [bold]' . $corrected_gestation['corrected_age_days'] . '[/]D';
                                $hc_percentiles[$index]->data_from = 'Postnatal Discharge';
                            }
                            else
                            {
                                $count = $hc_value_count + 1;
                                $hc_percentiles[$index]->{"chronological_age_" . $count} = $corrected_gestation_plot;
                                $hc_percentiles[$index]->{"cage_" . $count} = $corrected_gestation_plot;
                                $hc_percentiles[$index]->{"value_" . $count} = number_format($postnatal_value->discharge_ofc, 1);
                                $hc_percentiles[$index]->{"display_age_" . $count} = '[bold]' . $corrected_gestation['corrected_age_weeks'] . '[/]W [bold]' . $corrected_gestation['corrected_age_days'] . '[/]D';
                                $hc_percentiles[$index]->{"data_from_" . $count} = 'Postnatal Discharge';
                                if ($count > $hc_value_count)
                                {
                                    $hc_value_count = $count;
                                }
                            }

                        }

                    }
                }
            }

            $same_date_value_list = [];
            $same_date_value_list['wt'] = [];
            $same_date_value_list['len'] = [];
            $same_date_value_list['ofc'] = [];

            $previous_op_all = Op::GetPreviousopAll($baby_id);
            
            //Op weight, length and head
            foreach ($previous_op_all as $op_values)
            {
                if (isset($baby_detail->DOB) && isset($op_values->OpDate) && isset($baby_detail->g_weeks))
                {
                    $corrected_gestation = $this->calculateCorrectedGestation($gestation_weeks, $gestation_days, $baby_detail->DOB, $op_values->OpDate);

                    if (is_array($corrected_gestation))
                    {
                        $corrected_gestation_plot = $corrected_gestation['corrected_age_weeks'] + number_format(($corrected_gestation['corrected_age_days'] / 7) , 1);

                        if ($corrected_gestation_plot <= 64)
                        {

                            if (isset($op_values->CurrentWt) && !empty($op_values->CurrentWt) && $op_values->CurrentWt > 0)
                            {
                                $index = $this->getPosition($corrected_gestation['corrected_age_weeks']);

                                if (!isset($wt_percentiles[$index]->value) || (isset($wt_percentiles[$index]->value) && empty($wt_percentiles[$index]->value)))
                                {
                                    $wt_percentiles[$index]->chronological_age = $corrected_gestation_plot;
                                    $wt_percentiles[$index]->cage = $corrected_gestation_plot;
                                    $wt_percentiles[$index]->value = number_format($op_values->CurrentWt / 1000, 1);
                                    $wt_percentiles[$index]->display_age = '[bold]' . $corrected_gestation['corrected_age_weeks'] . '[/]W [bold]' . $corrected_gestation['corrected_age_days'] . '[/]D';
                                    $wt_percentiles[$index]->data_from = 'Neonatal OP';
                                }
                                else
                                {
                                    $count = $wt_value_count + 1;
                                    $wt_percentiles[$index]->{"chronological_age_" . $count} = $corrected_gestation_plot;
                                    $wt_percentiles[$index]->{"cage_" . $count} = $corrected_gestation_plot;
                                    $wt_percentiles[$index]->{"value_" . $count} = number_format($op_values->CurrentWt / 1000, 1);
                                    $wt_percentiles[$index]->{"display_age_" . $count} = '[bold]' . $corrected_gestation['corrected_age_weeks'] . '[/]W [bold]' . $corrected_gestation['corrected_age_days'] . '[/]D';
                                    $wt_percentiles[$index]->{"data_from_" . $count} = 'Neonatal OP';
                                    if ($count > $wt_value_count)
                                    {
                                        $wt_value_count = $count;
                                    }
                                }

                                $same_date_value_list['wt'][] = $op_values->OpDate;
                            }

                            if (isset($op_values->CurrentLength) && !empty($op_values->CurrentLength) && $op_values->CurrentLength > 0)
                            {
                                $index = $this->getPosition($corrected_gestation['corrected_age_weeks']);

                                if (!isset($ht_percentiles[$index]->value) || (isset($ht_percentiles[$index]->value) && empty($ht_percentiles[$index]->value)))
                                {
                                    $ht_percentiles[$index]->chronological_age = $corrected_gestation_plot;
                                    $ht_percentiles[$index]->cage = $corrected_gestation_plot;
                                    $ht_percentiles[$index]->value = number_format($op_values->CurrentLength, 1);
                                    $ht_percentiles[$index]->display_age = '[bold]' . $corrected_gestation['corrected_age_weeks'] . '[/]W [bold]' . $corrected_gestation['corrected_age_days'] . '[/]D';
                                    $ht_percentiles[$index]->data_from = 'Neonatal OP';
                                }
                                else
                                {
                                    $count = $ht_value_count + 1;
                                    $ht_percentiles[$index]->{"chronological_age_" . $count} = $corrected_gestation_plot;
                                    $ht_percentiles[$index]->{"cage_" . $count} = $corrected_gestation_plot;
                                    $ht_percentiles[$index]->{"value_" . $count} = number_format($op_values->CurrentLength, 1);
                                    $ht_percentiles[$index]->{"display_age_" . $count} = '[bold]' . $corrected_gestation['corrected_age_weeks'] . '[/]W [bold]' . $corrected_gestation['corrected_age_days'] . '[/]D';
                                    $ht_percentiles[$index]->{"data_from_" . $count} = 'Neonatal OP';
                                    if ($count > $ht_value_count)
                                    {
                                        $ht_value_count = $count;
                                    }
                                }
                                $same_date_value_list['len'][] = $op_values->OpDate;
                            }

                            if (isset($op_values->CurrentOFC) && !empty($op_values->CurrentOFC) && $op_values->CurrentOFC > 0)
                            {
                                $index = $this->getPosition($corrected_gestation['corrected_age_weeks']);

                                if (!isset($hc_percentiles[$index]->value) || (isset($hc_percentiles[$index]->value) && empty($hc_percentiles[$index]->value)))
                                {
                                    $hc_percentiles[$index]->chronological_age = $corrected_gestation_plot;
                                    $hc_percentiles[$index]->cage = $corrected_gestation_plot;
                                    $hc_percentiles[$index]->value = number_format($op_values->CurrentOFC, 1);
                                    $hc_percentiles[$index]->display_age = '[bold]' . $corrected_gestation['corrected_age_weeks'] . '[/]W [bold]' . $corrected_gestation['corrected_age_days'] . '[/]D';
                                    $hc_percentiles[$index]->data_from = 'Neonatal OP';
                                }
                                else
                                {
                                    $count = $hc_value_count + 1;
                                    $hc_percentiles[$index]->{"chronological_age_" . $count} = $corrected_gestation_plot;
                                    $hc_percentiles[$index]->{"cage_" . $count} = $corrected_gestation_plot;
                                    $hc_percentiles[$index]->{"value_" . $count} = number_format($op_values->CurrentOFC, 1);
                                    $hc_percentiles[$index]->{"display_age_" . $count} = '[bold]' . $corrected_gestation['corrected_age_weeks'] . '[/]W [bold]' . $corrected_gestation['corrected_age_days'] . '[/]D';
                                    $hc_percentiles[$index]->{"data_from_" . $count} = 'Neonatal OP';
                                    if ($count > $hc_value_count)
                                    {
                                        $hc_value_count = $count;
                                    }
                                }
                                $same_date_value_list['ofc'][] = $op_values->OpDate;
                            }

                        }
                    }
                }
            }
            
            // //pediatric Op weight, length and head
            // $previous_pediatric_op_list = Oppediatric::getAllPreviousOp($baby_id);
            // $previous_pediatric_op_list = $previous_pediatric_op_list->sortBy('op_date');
            // foreach ($previous_pediatric_op_list as $pediatric_key => $pediatric_value) {
            //     if (isset($baby_detail->DOB) && isset($pediatric_value->op_date) && isset($baby_detail->g_weeks))
            //     {

            //         $corrected_gestation = $this->calculateCorrectedGestation($gestation_weeks, $gestation_days, $baby_detail->DOB, $pediatric_value->op_date);

            //         if (is_array($corrected_gestation))
            //         {

            //             $corrected_gestation_plot = $corrected_gestation['corrected_age_weeks'] + number_format(($corrected_gestation['corrected_age_days'] / 7) , 1);

            //             if ($corrected_gestation_plot <= 64)
            //             {

            //                 if (isset($pediatric_value->current_weight) && !empty($pediatric_value->current_weight) && $pediatric_value->current_weight > 0)
            //                 {

            //                     $index = $this->getPosition($corrected_gestation['corrected_age_weeks']);

            //                     if (!isset($wt_percentiles[$index]->value) || (isset($wt_percentiles[$index]->value) && empty($wt_percentiles[$index]->value))){
            //                         $wt_percentiles[$index]->chronological_age = $corrected_gestation_plot;
            //                         $wt_percentiles[$index]->cage = $corrected_gestation_plot;
            //                         $wt_percentiles[$index]->value = number_format($pediatric_value->current_weight / 1000, 1);
            //                         $wt_percentiles[$index]->display_age = '[bold]' . $corrected_gestation['corrected_age_weeks'] . '[/]W [bold]' . $corrected_gestation['corrected_age_days'] . '[/]D';
            //                         $wt_percentiles[$index]->data_from = 'Pediatric OP';
            //                     } else {
            //                         $count = $wt_value_count + 1;
            //                         $wt_percentiles[$index]->{"chronological_age_" . $count} = $corrected_gestation_plot;
            //                         $wt_percentiles[$index]->{"cage_" . $count} = $corrected_gestation_plot;
            //                         $wt_percentiles[$index]->{"value_" . $count} = number_format($pediatric_value->current_weight / 1000, 1);
            //                         $wt_percentiles[$index]->{"display_age_" . $count} = '[bold]' . $corrected_gestation['corrected_age_weeks'] . '[/]W [bold]' . $corrected_gestation['corrected_age_days'] . '[/]D';
            //                         $wt_percentiles[$index]->{"data_from_" . $count} = 'Pediatric OP';
            //                         if ($count > $wt_value_count)
            //                         {
            //                             $wt_value_count = $count;
            //                         }
            //                     }

            //                     $same_date_value_list['wt'][] = $pediatric_value->op_date;
            //                 }

            //                 if (isset($pediatric_value->current_length) && !empty($pediatric_value->current_length) && $pediatric_value->current_length > 0)
            //                 {
            //                     $index = $this->getPosition($corrected_gestation['corrected_age_weeks']);

            //                     if (!isset($ht_percentiles[$index]->value) || (isset($ht_percentiles[$index]->value) && empty($ht_percentiles[$index]->value))){
            //                         $ht_percentiles[$index]->chronological_age = $corrected_gestation_plot;
            //                         $ht_percentiles[$index]->cage = $corrected_gestation_plot;
            //                         $ht_percentiles[$index]->value = number_format($pediatric_value->current_length, 1);
            //                         $ht_percentiles[$index]->display_age = '[bold]' . $corrected_gestation['corrected_age_weeks'] . '[/]W [bold]' . $corrected_gestation['corrected_age_days'] . '[/]D';
            //                         $ht_percentiles[$index]->data_from = 'Pediatric OP';
            //                     } else {
            //                         $count = $ht_value_count + 1;
            //                         $ht_percentiles[$index]->{"chronological_age_" . $count} = $corrected_gestation_plot;
            //                         $ht_percentiles[$index]->{"cage_" . $count} = $corrected_gestation_plot;
            //                         $ht_percentiles[$index]->{"value_" . $count} = number_format($pediatric_value->current_length, 1);
            //                         $ht_percentiles[$index]->{"display_age_" . $count} = '[bold]' . $corrected_gestation['corrected_age_weeks'] . '[/]W [bold]' . $corrected_gestation['corrected_age_days'] . '[/]D';
            //                         $ht_percentiles[$index]->{"data_from_" . $count} = 'Pediatric OP';
            //                         if ($count > $ht_value_count)
            //                         {
            //                             $ht_value_count = $count;
            //                         }
            //                     }

            //                     $same_date_value_list['len'][] = $pediatric_value->op_date;
            //                 }

            //                 if (isset($pediatric_value->current_ofc) && !empty($pediatric_value->current_ofc) && $pediatric_value->current_ofc > 0)
            //                 {

            //                     $index = $this->getPosition($corrected_gestation['corrected_age_weeks']);

            //                     if (!isset($hc_percentiles[$index]->value) || (isset($hc_percentiles[$index]->value) && empty($hc_percentiles[$index]->value))){
            //                         $hc_percentiles[$index]->chronological_age = $corrected_gestation_plot;
            //                         $hc_percentiles[$index]->cage = $corrected_gestation_plot;
            //                         $hc_percentiles[$index]->value = number_format($pediatric_value->current_ofc, 1);
            //                         $hc_percentiles[$index]->display_age = '[bold]' . $corrected_gestation['corrected_age_weeks'] . '[/]W [bold]' . $corrected_gestation['corrected_age_days'] . '[/]D';
            //                         $hc_percentiles[$index]->data_from = 'Pediatric OP';
            //                     } else {
            //                         $count = $hc_value_count + 1;
            //                         $hc_percentiles[$index]->{"chronological_age_" . $count} = $corrected_gestation_plot;
            //                         $hc_percentiles[$index]->{"cage_" . $count} = $corrected_gestation_plot;
            //                         $hc_percentiles[$index]->{"value_" . $count} = number_format($pediatric_value->current_ofc, 1);
            //                         $hc_percentiles[$index]->{"display_age_" . $count} = '[bold]' . $corrected_gestation['corrected_age_weeks'] . '[/]W [bold]' . $corrected_gestation['corrected_age_days'] . '[/]D';
            //                         $hc_percentiles[$index]->{"data_from_" . $count} = 'Pediatric OP';
            //                         if ($count > $hc_value_count)
            //                         {
            //                             $hc_value_count = $count;
            //                         }
            //                     }

            //                     $same_date_value_list['ofc'][] = $pediatric_value->op_date;
            //                 }
            //             }

            //         }
            //     }
            // }

            $previous_neuro_op_list = NeuroVisit::GetNeuroVisitList($baby_id);

            //Neuro Op weight, length and head
            foreach ($previous_neuro_op_list as $neuro_op_values)
            {
                if (isset($baby_detail->DOB) && isset($neuro_op_values->visit_date) && isset($baby_detail->g_weeks))
                {
                    $corrected_gestation = $this->calculateCorrectedGestation($gestation_weeks, $gestation_days, $baby_detail->DOB, $neuro_op_values->visit_date);

                    if (is_array($corrected_gestation))
                    {

                        $corrected_gestation_plot = $corrected_gestation['corrected_age_weeks'] + number_format(($corrected_gestation['corrected_age_days'] / 7) , 1);

                        if ($corrected_gestation_plot <= 64)
                        {

                            if (isset($neuro_op_values->current_weight_g) && !empty($neuro_op_values->current_weight_g) && $neuro_op_values->current_weight_g > 0 && !in_array($neuro_op_values->visit_date, $same_date_value_list['wt']))
                            {
                                $index = $this->getPosition($corrected_gestation['corrected_age_weeks']);

                                if (!isset($wt_percentiles[$index]->value) || (isset($wt_percentiles[$index]->value) && empty($wt_percentiles[$index]->value)))
                                {
                                    $wt_percentiles[$index]->chronological_age = $corrected_gestation_plot;
                                    $wt_percentiles[$index]->cage = $corrected_gestation_plot;
                                    $wt_percentiles[$index]->value = number_format($neuro_op_values->current_weight_g / 1000, 1);
                                    $wt_percentiles[$index]->display_age = '[bold]' . $corrected_gestation['corrected_age_weeks'] . '[/]W [bold]' . $corrected_gestation['corrected_age_days'] . '[/]D';
                                    $wt_percentiles[$index]->data_from = 'Neuro OP';
                                }
                                else
                                {
                                    $count = $wt_value_count + 1;
                                    $wt_percentiles[$index]->{"chronological_age_" . $count} = $corrected_gestation_plot;
                                    $wt_percentiles[$index]->{"cage_" . $count} = $corrected_gestation_plot;
                                    $wt_percentiles[$index]->{"value_" . $count} = number_format($neuro_op_values->current_weight_g / 1000, 1);
                                    $wt_percentiles[$index]->{"display_age_" . $count} = '[bold]' . $corrected_gestation['corrected_age_weeks'] . '[/]W [bold]' . $corrected_gestation['corrected_age_days'] . '[/]D';
                                    $wt_percentiles[$index]->{"data_from_" . $count} = 'Neuro OP';
                                    if ($count > $wt_value_count)
                                    {
                                        $wt_value_count = $count;
                                    }
                                }
                            }

                            if (isset($neuro_op_values->current_length) && !empty($neuro_op_values->current_length) && $neuro_op_values->current_length > 0 && !in_array($neuro_op_values->visit_date, $same_date_value_list['len']))
                            {
                                $index = $this->getPosition($corrected_gestation['corrected_age_weeks']);

                                if (!isset($ht_percentiles[$index]->value) || (isset($ht_percentiles[$index]->value) && empty($ht_percentiles[$index]->value)))
                                {
                                    $ht_percentiles[$index]->chronological_age = $corrected_gestation_plot;
                                    $ht_percentiles[$index]->cage = $corrected_gestation_plot;
                                    $ht_percentiles[$index]->value = number_format($neuro_op_values->current_length, 1);
                                    $ht_percentiles[$index]->display_age = '[bold]' . $corrected_gestation['corrected_age_weeks'] . '[/]W [bold]' . $corrected_gestation['corrected_age_days'] . '[/]D';
                                    $ht_percentiles[$index]->data_from = 'Neuro OP';
                                }
                                else
                                {
                                    $count = $ht_value_count + 1;
                                    $ht_percentiles[$index]->{"chronological_age_" . $count} = $corrected_gestation_plot;
                                    $ht_percentiles[$index]->{"cage_" . $count} = $corrected_gestation_plot;
                                    $ht_percentiles[$index]->{"value_" . $count} = number_format($neuro_op_values->current_length, 1);
                                    $ht_percentiles[$index]->{"display_age_" . $count} = '[bold]' . $corrected_gestation['corrected_age_weeks'] . '[/]W [bold]' . $corrected_gestation['corrected_age_days'] . '[/]D';
                                    $ht_percentiles[$index]->{"data_from_" . $count} = 'Neuro OP';
                                    if ($count > $ht_value_count)
                                    {
                                        $ht_value_count = $count;
                                    }
                                }
                            }

                            if (isset($neuro_op_values->current_ofc) && !empty($neuro_op_values->current_ofc) && $neuro_op_values->current_ofc > 0 && !in_array($neuro_op_values->visit_date, $same_date_value_list['ofc']))
                            {
                                $index = $this->getPosition($corrected_gestation['corrected_age_weeks']);

                                if (!isset($hc_percentiles[$index]->value) || (isset($hc_percentiles[$index]->value) && empty($hc_percentiles[$index]->value)))
                                {
                                    $hc_percentiles[$index]->chronological_age = $corrected_gestation_plot;
                                    $hc_percentiles[$index]->cage = $corrected_gestation_plot;
                                    $hc_percentiles[$index]->value = number_format($neuro_op_values->current_ofc, 1);
                                    $hc_percentiles[$index]->display_age = '[bold]' . $corrected_gestation['corrected_age_weeks'] . '[/]W [bold]' . $corrected_gestation['corrected_age_days'] . '[/]D';
                                    $hc_percentiles[$index]->data_from = 'Neuro OP';
                                }
                                else
                                {
                                    $count = $hc_value_count + 1;
                                    $hc_percentiles[$index]->{"chronological_age_" . $count} = $corrected_gestation_plot;
                                    $hc_percentiles[$index]->{"cage_" . $count} = $corrected_gestation_plot;
                                    $hc_percentiles[$index]->{"value_" . $count} = number_format($neuro_op_values->current_ofc, 1);
                                    $hc_percentiles[$index]->{"display_age_" . $count} = '[bold]' . $corrected_gestation['corrected_age_weeks'] . '[/]W [bold]' . $corrected_gestation['corrected_age_days'] . '[/]D';
                                    $hc_percentiles[$index]->{"data_from_" . $count} = 'Neuro OP';
                                    if ($count > $hc_value_count)
                                    {
                                        $hc_value_count = $count;
                                    }
                                }
                            }

                        }
                    }
                }
            }

        }

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
        }  else {
            $closewinlink = url($closewinlink);
        }

        $corrected_gestation = $this->calculateCorrectedGestation($gestation_weeks, $gestation_days, $baby_detail->DOB, date('Y-m-d'));

        $corrected_gestation_plot = $corrected_gestation['corrected_age_weeks'] + number_format(($corrected_gestation['corrected_age_days'] / 7) , 1);

        if (strtolower($baby_detail->Sex) == 'female' || strtolower($baby_detail->Sex) == 'male')
        {
            return view('chart.inter_growth', compact('wt_percentiles', 'ht_percentiles', 'hc_percentiles', 'baby_detail', 'closewinlink', 'wt_value_count', 'ht_value_count', 'hc_value_count', 'corrected_gestation_plot'));
        }
        else
        {
            return redirect()
                ->back()
                ->with('error', 'Baby Gender is empty...!');
        }

    }

    private function getPosition($weeks)
    {
        return ($weeks - 27) > 0 ? $weeks - 27 : 0;
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
}

