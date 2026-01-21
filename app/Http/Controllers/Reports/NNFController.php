<?php

namespace App\Http\Controllers\Reports;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Nurse\EmrLogDetails;
use App\Models\DashboardEvent;
use App\User;
use Carbon\Carbon;

class NNFController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:REPORT_NNF,read');
    }

    /**
     * DISPLAY THE RECORDS ACCORDING TO THE FILTERS APPLIED
     *
     */
    public function index(Request $request)
    {
        $navigate['main_nav'] = 'report';
        $navigate['sub_nav']  = 'nnf';

        $input = $request->all();

        $start_date = date('Y-m-d', strtotime($input['StartDate']));
        $end_date = date('Y-m-d', strtotime($input['EndDate']));

        // 1
        $baby_count_query = 'SELECT count(*) FROM nicu_admission JOIN baby ON "nicu_admission"."BabyId" = "baby"."BabyId" WHERE ("DOB" >= \'' . $start_date . '\' AND "DOB" <= \'' . $end_date . '\') AND nicu_admission."IsDeleted" = \'0\' AND baby."IsDeleted" = \'0\';';

        $baby_count = \DB::select($baby_count_query);

        $baby_count = collect($baby_count)->pluck('count')->first();

        $inborn_baby_count_query = 'SELECT count(*) FROM nicu_admission JOIN baby ON "nicu_admission"."BabyId" = "baby"."BabyId" WHERE ("DOB" >= \'' . $start_date . '\' AND "DOB" <= \'' . $end_date . '\') AND "BirthStatus" = \'Inborn\' AND nicu_admission."IsDeleted" = \'0\' AND baby."IsDeleted" = \'0\';';

        $inborn_baby_count = \DB::select($inborn_baby_count_query);

        $inborn_baby_count = collect($inborn_baby_count)->pluck('count')->first();

        $outborn_baby_count_query = 'SELECT count(*) FROM nicu_admission JOIN baby ON "nicu_admission"."BabyId" = "baby"."BabyId" WHERE ("DOB" >= \'' . $start_date . '\' AND "DOB" <= \'' . $end_date . '\') AND "BirthStatus" = \'Outborn\' AND nicu_admission."IsDeleted" = \'0\' AND baby."IsDeleted" = \'0\';';

        $outborn_baby_count = \DB::select($outborn_baby_count_query);

        $outborn_baby_count = collect($outborn_baby_count)->pluck('count')->first();



        // 2
        $lbw_count_query = 'SELECT count(*) FROM baby JOIN nicu_admission ON "nicu_admission"."BabyId" = "baby"."BabyId" WHERE ("DOB" >= \'' . $start_date . '\' AND "DOB" <= \'' . $end_date . '\') AND NULLIF("BirthWeight", \'\')::int < 2500 AND nicu_admission."IsDeleted" = \'0\' AND baby."IsDeleted" = \'0\';';

        $lbw_count = \DB::select($lbw_count_query);

        $lbw_count = collect($lbw_count)->pluck('count')->first();

        $lbw_inborn_count_query = 'SELECT count(*) FROM baby JOIN nicu_admission ON "nicu_admission"."BabyId" = "baby"."BabyId" WHERE ("DOB" >= \'' . $start_date . '\' AND "DOB" <= \'' . $end_date . '\') AND NULLIF("BirthWeight", \'\')::int < 2500 AND "BirthStatus" = \'Inborn\' AND nicu_admission."IsDeleted" = \'0\' AND baby."IsDeleted" = \'0\';';

        $lbw_inborn_count = \DB::select($lbw_inborn_count_query);

        $lbw_inborn_count = collect($lbw_inborn_count)->pluck('count')->first();

        $lbw_outborn_count_query = 'SELECT count(*) FROM baby JOIN nicu_admission ON "nicu_admission"."BabyId" = "baby"."BabyId" WHERE ("DOB" >= \'' . $start_date . '\' AND "DOB" <= \'' . $end_date . '\') AND NULLIF("BirthWeight", \'\')::int < 2500 AND "BirthStatus" = \'Outborn\' AND nicu_admission."IsDeleted" = \'0\' AND baby."IsDeleted" = \'0\';';

        $lbw_outborn_count = \DB::select($lbw_outborn_count_query);

        $lbw_outborn_count = collect($lbw_outborn_count)->pluck('count')->first();

        $vlbw_count_query = 'SELECT count(*) FROM baby JOIN nicu_admission ON "nicu_admission"."BabyId" = "baby"."BabyId" WHERE ("DOB" >= \'' . $start_date . '\' AND "DOB" <= \'' . $end_date . '\') AND NULLIF("BirthWeight", \'\')::int < 1500 AND nicu_admission."IsDeleted" = \'0\' AND baby."IsDeleted" = \'0\';';

        $vlbw_count = \DB::select($vlbw_count_query);

        $vlbw_count = collect($vlbw_count)->pluck('count')->first();

        $vlbw_inborn_count_query = 'SELECT count(*) FROM baby JOIN nicu_admission ON "nicu_admission"."BabyId" = "baby"."BabyId" WHERE ("DOB" >= \'' . $start_date . '\' AND "DOB" <= \'' . $end_date . '\') AND NULLIF("BirthWeight", \'\')::int < 1500 AND "BirthStatus" = \'Inborn\' AND nicu_admission."IsDeleted" = \'0\' AND baby."IsDeleted" = \'0\';';

        $vlbw_inborn_count = \DB::select($vlbw_inborn_count_query);

        $vlbw_inborn_count = collect($vlbw_inborn_count)->pluck('count')->first();

        $vlbw_outborn_count_query = 'SELECT count(*) FROM baby JOIN nicu_admission ON "nicu_admission"."BabyId" = "baby"."BabyId" WHERE ("DOB" >= \'' . $start_date . '\' AND "DOB" <= \'' . $end_date . '\') AND NULLIF("BirthWeight", \'\')::int < 1500 AND "BirthStatus" = \'Outborn\' AND nicu_admission."IsDeleted" = \'0\' AND baby."IsDeleted" = \'0\';';

        $vlbw_outborn_count = \DB::select($vlbw_outborn_count_query);

        $vlbw_outborn_count = collect($vlbw_outborn_count)->pluck('count')->first();

        $elbw_count_query = 'SELECT count(*) FROM baby JOIN nicu_admission ON "nicu_admission"."BabyId" = "baby"."BabyId" WHERE ("DOB" >= \'' . $start_date . '\' AND "DOB" <= \'' . $end_date . '\') AND NULLIF("BirthWeight", \'\')::int < 1000 AND nicu_admission."IsDeleted" = \'0\' AND baby."IsDeleted" = \'0\';';

        $elbw_count = \DB::select($elbw_count_query);

        $elbw_count = collect($elbw_count)->pluck('count')->first();

        $elbw_inborn_count_query = 'SELECT count(*) FROM baby JOIN nicu_admission ON "nicu_admission"."BabyId" = "baby"."BabyId" WHERE ("DOB" >= \'' . $start_date . '\' AND "DOB" <= \'' . $end_date . '\') AND NULLIF("BirthWeight", \'\')::int < 1000 AND "BirthStatus" = \'Inborn\' AND nicu_admission."IsDeleted" = \'0\' AND baby."IsDeleted" = \'0\';';

        $elbw_inborn_count = \DB::select($elbw_inborn_count_query);

        $elbw_inborn_count = collect($elbw_inborn_count)->pluck('count')->first();

        $elbw_outborn_count_query = 'SELECT count(*) FROM baby JOIN nicu_admission ON "nicu_admission"."BabyId" = "baby"."BabyId" WHERE ("DOB" >= \'' . $start_date . '\' AND "DOB" <= \'' . $end_date . '\') AND NULLIF("BirthWeight", \'\')::int < 1000 AND "BirthStatus" = \'Outborn\' AND nicu_admission."IsDeleted" = \'0\' AND baby."IsDeleted" = \'0\';';

        $elbw_outborn_count = \DB::select($elbw_outborn_count_query);

        $elbw_outborn_count = collect($elbw_outborn_count)->pluck('count')->first();


        $refer_out_count_query = 'SELECT count(*) FROM baby JOIN nicu_admission ON "nicu_admission"."BabyId" = "baby"."BabyId" LEFT JOIN discharge_summary ON "discharge_summary"."baby_id" = "nicu_admission"."BabyId" WHERE ("DOB" >= \'' . $start_date . '\' AND "DOB" <= \'' . $end_date . '\') AND (summary LIKE \'%GKNM%\' OR summary LIKE \'%Narayana Hrudayalaya%\' OR summary LIKE \'%NH%\' OR summary LIKE \'%Ramachandra%\' OR summary LIKE \'%ICH%\' OR summary LIKE \'%Rainbow Hospital%\' OR summary LIKE \'%chennai%\') AND nicu_admission."IsDeleted" = \'0\' AND baby."IsDeleted" = \'0\';';

        // $refer_out_count_query = 'SELECT summary FROM baby JOIN nicu_admission ON "nicu_admission"."BabyId" = "baby"."BabyId" LEFT JOIN discharge_summary ON "discharge_summary"."baby_id" = "nicu_admission"."BabyId" WHERE (summary like \'%hospital%\' OR summary like \'%transfer%\' OR summary like \'%further%\' OR summary like \'%ambulance%\' OR summary like \'%refer%\') AND nicu_admission."IsDeleted" = \'0\' AND baby."IsDeleted" = \'0\' AND "baby"."BMrNo" NOT IN (\'601436\',\'585226\',\'602003\',\'585225\',\'602919\',\'593505\',\'597874\',\'622173\',\'602779\',\'603169\',\'622319\',\'622320\',\'641327\',\'603616\',\'622324\',\'622800\',\'641643\',\'604228\',\'597631\',\'603724\',\'622059\',\'643179\',\'659629\',\'625433\',\'606367\',\'607157\',\'606565\',\'627374\',\'607504\',\'626010\',\'644966\',\'644960\',\'661289\',\'597631\',\'597631\',\'608151\',\'607147\',\'645965\',\'564096\',\'660913\',\'663267\',\'609998\',\'629489\',\'559888\',\'629616\',\'611469\',\'626010\',\'590225\',\'610475\',\'566874\',\'630584\',\'607656\',\'614727\',\'590677\',\'590678\',\'648541\',\'610475\',\'616097\',\'615939\',\'665946\',\'617159\',\'616791\',\'628521\',\'631256\',\'596029\',\'617049\',\'572493\',\'564096\',\'617006\',\'573702\',\'573703\',\'615154\',\'561579\',\'562038\',\'573798\',\'588306\',\'562747\',\'589008\',\'576798\',\'571795\',\'576797\',\'564294\',\'577471\',\'577471\',\'587820\',\'564566\',\'577626\',\'634294\',\'619787\',\'578307\',\'565846\',\'590224\',\'579283\',\'566847\',\'619623\',\'567191\',\'567598\',\'577471\',\'577471\',\'565953\',\'590636\',\'587820\',\'580564\',\'566846\',\'591643\',\'591430\',\'591680\',\'590105\',\'600455\',\'570672\',\'582183\',\'582185\',\'583521\',\'592806\',\'598332\',\'599418\',\'599863\',\'599861\',\'600647\',\'600871\',\'600872\',\'601425\',\'600649\',\'634298\',\'618351\',\'652069\',\'651248\',\'668153\',\'652228\',\'652227\',\'667090\',\'650499\',\'668763\',\'653033\',\'636740\',\'636741\',\'653891\',\'637055\',\'649019\',\'649019\',\'656355\',\'656074\',\'656168\',\'656073\',\'650499\',\'672582\',\'672977\',\'672983\',\'658138\',\'671812\',\'672432\',\'657066\',\'674432\',\'674149\',\'675382\',\'668763\',\'676121\');';
        $refer_out_count = \DB::select($refer_out_count_query);

        $refer_out_count = collect($refer_out_count)->pluck('count')->first();


        // 5
        $died_count_query = 'SELECT count(*) FROM baby JOIN nicu_admission ON "nicu_admission"."BabyId" = "baby"."BabyId" WHERE ("DOB" >= \'' . $start_date . '\' AND "DOB" <= \'' . $end_date . '\') AND status like \'%Died%\' AND nicu_admission."IsDeleted" = \'0\' AND baby."IsDeleted" = \'0\';';

        $died_count = \DB::select($died_count_query);

        $died_count = collect($died_count)->pluck('count')->first();

        $inborn_died_count_query = 'SELECT count(*) FROM baby JOIN nicu_admission ON "nicu_admission"."BabyId" = "baby"."BabyId" WHERE ("DOB" >= \'' . $start_date . '\' AND "DOB" <= \'' . $end_date . '\') AND status like \'%Died%\' AND "BirthStatus" = \'Inborn\' AND nicu_admission."IsDeleted" = \'0\' AND baby."IsDeleted" = \'0\';';

        $inborn_died_count = \DB::select($inborn_died_count_query);

        $inborn_died_count = collect($inborn_died_count)->pluck('count')->first();

        $outborn_died_count_query = 'SELECT count(*) FROM baby JOIN nicu_admission ON "nicu_admission"."BabyId" = "baby"."BabyId" WHERE ("DOB" >= \'' . $start_date . '\' AND "DOB" <= \'' . $end_date . '\') AND status like \'%Died%\' AND "BirthStatus" = \'Outborn\' AND nicu_admission."IsDeleted" = \'0\' AND baby."IsDeleted" = \'0\';';

        $outborn_died_count = \DB::select($outborn_died_count_query);

        $outborn_died_count = collect($outborn_died_count)->pluck('count')->first();



        // 6
        $lbw_died_count_query = 'SELECT count(*) FROM baby JOIN nicu_admission ON "nicu_admission"."BabyId" = "baby"."BabyId" WHERE ("DOB" >= \'' . $start_date . '\' AND "DOB" <= \'' . $end_date . '\') AND NULLIF("BirthWeight", \'\')::int < 2500 AND (status = \'Died\' OR status = \'Died (OCNR)\') AND "nicu_admission"."IsDeleted" = \'0\' AND "baby"."IsDeleted" = \'0\' ;';

        $lbw_died_count = \DB::select($lbw_died_count_query);

        $lbw_died_count = collect($lbw_died_count)->pluck('count')->first();

        $lbw_inborn_died_count_query = 'SELECT count(*) FROM baby JOIN nicu_admission ON "nicu_admission"."BabyId" = "baby"."BabyId" WHERE ("DOB" >= \'' . $start_date . '\' AND "DOB" <= \'' . $end_date . '\') AND NULLIF("BirthWeight", \'\')::int < 2500 AND "BirthStatus" = \'Inborn\' AND (status = \'Died\' OR status = \'Died (OCNR)\') AND "nicu_admission"."IsDeleted" = \'0\' AND "baby"."IsDeleted" = \'0\' ;';

        $lbw_inborn_died_count = \DB::select($lbw_inborn_died_count_query);

        $lbw_inborn_died_count = collect($lbw_inborn_died_count)->pluck('count')->first();

        $lbw_outborn_died_count_query = 'SELECT count(*) FROM baby JOIN nicu_admission ON "nicu_admission"."BabyId" = "baby"."BabyId" WHERE ("DOB" >= \'' . $start_date . '\' AND "DOB" <= \'' . $end_date . '\') AND NULLIF("BirthWeight", \'\')::int < 2500 AND "BirthStatus" = \'Outborn\' AND (status = \'Died\' OR status = \'Died (OCNR)\') AND "nicu_admission"."IsDeleted" = \'0\' AND "baby"."IsDeleted" = \'0\' ;';

        $lbw_outborn_died_count = \DB::select($lbw_outborn_died_count_query);

        $lbw_outborn_died_count = collect($lbw_outborn_died_count)->pluck('count')->first();

        $vlbw_died_count_query = 'SELECT count(*) FROM baby JOIN nicu_admission ON "nicu_admission"."BabyId" = "baby"."BabyId" WHERE ("DOB" >= \'' . $start_date . '\' AND "DOB" <= \'' . $end_date . '\') AND NULLIF("BirthWeight", \'\')::int < 1500 AND (status = \'Died\' OR status = \'Died (OCNR)\') AND "nicu_admission"."IsDeleted" = \'0\' AND "baby"."IsDeleted" = \'0\';';

        $vlbw_died_count = \DB::select($vlbw_died_count_query);

        $vlbw_died_count = collect($vlbw_died_count)->pluck('count')->first();

        $vlbw_inborn_died_count_query = 'SELECT count(*) FROM baby JOIN nicu_admission ON "nicu_admission"."BabyId" = "baby"."BabyId" WHERE ("DOB" >= \'' . $start_date . '\' AND "DOB" <= \'' . $end_date . '\') AND NULLIF("BirthWeight", \'\')::int < 1500 AND "BirthStatus" = \'Inborn\' AND (status = \'Died\' OR status = \'Died (OCNR)\') AND "nicu_admission"."IsDeleted" = \'0\' AND "baby"."IsDeleted" = \'0\';';

        $vlbw_inborn_died_count = \DB::select($vlbw_inborn_died_count_query);

        $vlbw_inborn_died_count = collect($vlbw_inborn_died_count)->pluck('count')->first();

        $vlbw_outborn_died_count_query = 'SELECT count(*) FROM baby JOIN nicu_admission ON "nicu_admission"."BabyId" = "baby"."BabyId" WHERE ("DOB" >= \'' . $start_date . '\' AND "DOB" <= \'' . $end_date . '\') AND NULLIF("BirthWeight", \'\')::int < 1500 AND "BirthStatus" = \'Outborn\' AND (status = \'Died\' OR status = \'Died (OCNR)\') AND "nicu_admission"."IsDeleted" = \'0\' AND "baby"."IsDeleted" = \'0\';';

        $vlbw_outborn_died_count = \DB::select($vlbw_outborn_died_count_query);

        $vlbw_outborn_died_count = collect($vlbw_outborn_died_count)->pluck('count')->first();

        $elbw_died_count_query = 'SELECT count(*) FROM baby JOIN nicu_admission ON "nicu_admission"."BabyId" = "baby"."BabyId" WHERE ("DOB" >= \'' . $start_date . '\' AND "DOB" <= \'' . $end_date . '\') AND NULLIF("BirthWeight", \'\')::int < 1000 AND (status = \'Died\' OR status = \'Died (OCNR)\') AND "nicu_admission"."IsDeleted" = \'0\' AND "baby"."IsDeleted" = \'0\';';

        $elbw_died_count = \DB::select($elbw_died_count_query);

        $elbw_died_count = collect($elbw_died_count)->pluck('count')->first();

        $elbw_inborn_died_count_query = 'SELECT count(*) FROM baby JOIN nicu_admission ON "nicu_admission"."BabyId" = "baby"."BabyId" WHERE ("DOB" >= \'' . $start_date . '\' AND "DOB" <= \'' . $end_date . '\') AND NULLIF("BirthWeight", \'\')::int < 1000 AND "BirthStatus" = \'Inborn\' AND (status = \'Died\' OR status = \'Died (OCNR)\') AND "nicu_admission"."IsDeleted" = \'0\' AND "baby"."IsDeleted" = \'0\';';

        $elbw_inborn_died_count = \DB::select($elbw_inborn_died_count_query);

        $elbw_inborn_died_count = collect($elbw_inborn_died_count)->pluck('count')->first();

        $elbw_outborn_died_count_query = 'SELECT count(*) FROM baby JOIN nicu_admission ON "nicu_admission"."BabyId" = "baby"."BabyId" WHERE ("DOB" >= \'' . $start_date . '\' AND "DOB" <= \'' . $end_date . '\') AND NULLIF("BirthWeight", \'\')::int < 1000 AND "BirthStatus" = \'Outborn\' AND (status = \'Died\' OR status = \'Died (OCNR)\') AND "nicu_admission"."IsDeleted" = \'0\' AND "baby"."IsDeleted" = \'0\';';

        $elbw_outborn_died_count = \DB::select($elbw_outborn_died_count_query);

        $elbw_outborn_died_count = collect($elbw_outborn_died_count)->pluck('count')->first();



        // 7
        $LAMA_DOR_total_count_query = 'SELECT count(*) FROM baby JOIN nicu_admission ON "nicu_admission"."BabyId" = "baby"."BabyId" WHERE ("DOB" >= \'' . $start_date . '\' AND "DOB" <= \'' . $end_date . '\') AND (status like \'%Discharged at request%\' OR status like \'%Discharge at Request%\' OR status = \'Leaving against medical advice\' OR status = \'Discharge Against Medical Advice\') AND "nicu_admission"."IsDeleted" = \'0\' AND "baby"."IsDeleted" = \'0\' AND "baby"."IsDeleted" = \'0\';';

        $LAMA_DOR_total_count = \DB::select($LAMA_DOR_total_count_query);

        $LAMA_DOR_total_count = collect($LAMA_DOR_total_count)->pluck('count')->first();

        $LAMA_DOR_lbw_count_query = 'SELECT count(*) FROM baby JOIN nicu_admission ON "nicu_admission"."BabyId" = "baby"."BabyId" WHERE ("DOB" >= \'' . $start_date . '\' AND "DOB" <= \'' . $end_date . '\') AND NULLIF("BirthWeight", \'\')::int < 2500 AND (status like \'%Discharged at request%\' OR status like \'%Discharge at Request%\' OR status = \'Leaving against medical advice\' OR status = \'Discharge Against Medical Advice\') AND "nicu_admission"."IsDeleted" = \'0\' AND "baby"."IsDeleted" = \'0\' AND "baby"."IsDeleted" = \'0\';';

        $LAMA_DOR_lbw_count = \DB::select($LAMA_DOR_lbw_count_query);

        $LAMA_DOR_lbw_count = collect($LAMA_DOR_lbw_count)->pluck('count')->first();

        $LAMA_DOR_lbw_inborn_count_query = 'SELECT count(*) FROM baby JOIN nicu_admission ON "nicu_admission"."BabyId" = "baby"."BabyId" WHERE ("DOB" >= \'' . $start_date . '\' AND "DOB" <= \'' . $end_date . '\') AND NULLIF("BirthWeight", \'\')::int < 2500 AND "BirthStatus" = \'Inborn\' AND (status like \'%Discharged at request%\' OR status like \'%Discharge at Request%\' OR status = \'Leaving against medical advice\' OR status = \'Discharge Against Medical Advice\') AND "nicu_admission"."IsDeleted" = \'0\' AND "baby"."IsDeleted" = \'0\' AND "baby"."IsDeleted" = \'0\';';

        $LAMA_DOR_lbw_inborn_count = \DB::select($LAMA_DOR_lbw_inborn_count_query);

        $LAMA_DOR_lbw_inborn_count = collect($LAMA_DOR_lbw_inborn_count)->pluck('count')->first();

        $LAMA_DOR_lbw_outborn_count_query = 'SELECT count(*) FROM baby JOIN nicu_admission ON "nicu_admission"."BabyId" = "baby"."BabyId" WHERE ("DOB" >= \'' . $start_date . '\' AND "DOB" <= \'' . $end_date . '\') AND NULLIF("BirthWeight", \'\')::int < 2500 AND "BirthStatus" = \'Outborn\' AND (status like \'%Discharged at request%\' OR status like \'%Discharge at Request%\' OR status = \'Leaving against medical advice\' OR status = \'Discharge Against Medical Advice\') AND "nicu_admission"."IsDeleted" = \'0\' AND "baby"."IsDeleted" = \'0\' AND "baby"."IsDeleted" = \'0\';';

        $LAMA_DOR_lbw_outborn_count = \DB::select($LAMA_DOR_lbw_outborn_count_query);

        $LAMA_DOR_lbw_outborn_count = collect($LAMA_DOR_lbw_outborn_count)->pluck('count')->first();

        $LAMA_DOR_vlbw_count_query = 'SELECT count(*) FROM baby JOIN nicu_admission ON "nicu_admission"."BabyId" = "baby"."BabyId" WHERE ("DOB" >= \'' . $start_date . '\' AND "DOB" <= \'' . $end_date . '\') AND NULLIF("BirthWeight", \'\')::int < 1500 AND (status like \'%Discharged at request%\' OR status like \'%Discharge at Request%\' OR status = \'Leaving against medical advice\' OR status = \'Discharge Against Medical Advice\') AND "nicu_admission"."IsDeleted" = \'0\' AND "baby"."IsDeleted" = \'0\' AND "baby"."IsDeleted" = \'0\';';

        $LAMA_DOR_vlbw_count = \DB::select($LAMA_DOR_vlbw_count_query);

        $LAMA_DOR_vlbw_count = collect($LAMA_DOR_vlbw_count)->pluck('count')->first();

        $LAMA_DOR_vlbw_inborn_count_query = 'SELECT count(*) FROM baby JOIN nicu_admission ON "nicu_admission"."BabyId" = "baby"."BabyId" WHERE ("DOB" >= \'' . $start_date . '\' AND "DOB" <= \'' . $end_date . '\') AND NULLIF("BirthWeight", \'\')::int < 1500 AND "BirthStatus" = \'Inborn\' AND (status like \'%Discharged at request%\' OR status like \'%Discharge at Request%\' OR status = \'Leaving against medical advice\' OR status = \'Discharge Against Medical Advice\') AND "nicu_admission"."IsDeleted" = \'0\' AND "baby"."IsDeleted" = \'0\' AND "baby"."IsDeleted" = \'0\';';

        $LAMA_DOR_vlbw_inborn_count = \DB::select($LAMA_DOR_vlbw_inborn_count_query);

        $LAMA_DOR_vlbw_inborn_count = collect($LAMA_DOR_vlbw_inborn_count)->pluck('count')->first();

        $LAMA_DOR_vlbw_outborn_count_query = 'SELECT count(*) FROM baby JOIN nicu_admission ON "nicu_admission"."BabyId" = "baby"."BabyId" WHERE ("DOB" >= \'' . $start_date . '\' AND "DOB" <= \'' . $end_date . '\') AND NULLIF("BirthWeight", \'\')::int < 1500 AND "BirthStatus" = \'Outborn\' AND (status like \'%Discharged at request%\' OR status like \'%Discharge at Request%\' OR status = \'Leaving against medical advice\' OR status = \'Discharge Against Medical Advice\') AND "nicu_admission"."IsDeleted" = \'0\' AND "baby"."IsDeleted" = \'0\' AND "baby"."IsDeleted" = \'0\';';

        $LAMA_DOR_vlbw_outborn_count = \DB::select($LAMA_DOR_vlbw_outborn_count_query);

        $LAMA_DOR_vlbw_outborn_count = collect($LAMA_DOR_vlbw_outborn_count)->pluck('count')->first();

        $LAMA_DOR_elbw_count_query = 'SELECT count(*) FROM baby JOIN nicu_admission ON "nicu_admission"."BabyId" = "baby"."BabyId" WHERE ("DOB" >= \'' . $start_date . '\' AND "DOB" <= \'' . $end_date . '\') AND NULLIF("BirthWeight", \'\')::int < 1000 AND (status like \'%Discharged at request%\' OR status like \'%Discharge at Request%\' OR status = \'Leaving against medical advice\' OR status = \'Discharge Against Medical Advice\') AND "nicu_admission"."IsDeleted" = \'0\' AND "baby"."IsDeleted" = \'0\' AND "baby"."IsDeleted" = \'0\';';

        $LAMA_DOR_elbw_count = \DB::select($LAMA_DOR_elbw_count_query);

        $LAMA_DOR_elbw_count = collect($LAMA_DOR_elbw_count)->pluck('count')->first();

        $LAMA_DOR_elbw_inborn_count_query = 'SELECT count(*) FROM baby JOIN nicu_admission ON "nicu_admission"."BabyId" = "baby"."BabyId" WHERE ("DOB" >= \'' . $start_date . '\' AND "DOB" <= \'' . $end_date . '\') AND NULLIF("BirthWeight", \'\')::int < 1000 AND "BirthStatus" = \'Inborn\' AND (status like \'%Discharged at request%\' OR status like \'%Discharge at Request%\' OR status = \'Leaving against medical advice\' OR status = \'Discharge Against Medical Advice\') AND "nicu_admission"."IsDeleted" = \'0\' AND "baby"."IsDeleted" = \'0\' AND "baby"."IsDeleted" = \'0\';';

        $LAMA_DOR_elbw_inborn_count = \DB::select($LAMA_DOR_elbw_inborn_count_query);

        $LAMA_DOR_elbw_inborn_count = collect($LAMA_DOR_elbw_inborn_count)->pluck('count')->first();

        $LAMA_DOR_elbw_outborn_count_query = 'SELECT count(*) FROM baby JOIN nicu_admission ON "nicu_admission"."BabyId" = "baby"."BabyId" WHERE ("DOB" >= \'' . $start_date . '\' AND "DOB" <= \'' . $end_date . '\') AND NULLIF("BirthWeight", \'\')::int < 1000 AND "BirthStatus" = \'Outborn\' AND (status like \'%Discharged at request%\' OR status like \'%Discharge at Request%\' OR status = \'Leaving against medical advice\' OR status = \'Discharge Against Medical Advice\') AND "nicu_admission"."IsDeleted" = \'0\' AND "baby"."IsDeleted" = \'0\' AND "baby"."IsDeleted" = \'0\';';

        $LAMA_DOR_elbw_outborn_count = \DB::select($LAMA_DOR_elbw_outborn_count_query);

        $LAMA_DOR_elbw_outborn_count = collect($LAMA_DOR_elbw_outborn_count)->pluck('count')->first();



        $died_query = 'SELECT "baby"."BMrNo", "BirthStatus" FROM baby JOIN nicu_admission ON "nicu_admission"."BabyId" = "baby"."BabyId" WHERE ("DOB" >= \'' . $start_date . '\' AND "DOB" <= \'' . $end_date . '\') AND status like \'%Died%\' AND nicu_admission."IsDeleted" = \'0\' AND baby."IsDeleted" = \'0\';';

        $died = \DB::select($died_query);

        $transferred_query = 'SELECT "baby"."BMrNo" FROM baby JOIN nicu_admission ON "nicu_admission"."BabyId" = "baby"."BabyId" WHERE ("DOB" >= \'' . $start_date . '\' AND "DOB" <= \'' . $end_date . '\') AND status like \'%Transferred%\' AND nicu_admission."IsDeleted" = \'0\' AND baby."IsDeleted" = \'0\';';

        $transferred = \DB::select($transferred_query);

        $transferred = collect($transferred)->pluck('BMrNo')->toArray();

        $closewinlink = action('Reports\NNFController@filter');

        return view('reports.nnf.print', compact('results', 'navigate', 'closewinlink', 'start_date', 'end_date', 'baby_count', 'inborn_baby_count', 'outborn_baby_count', 'lbw_count', 'lbw_inborn_count', 'lbw_outborn_count', 'vlbw_count', 'vlbw_inborn_count', 'vlbw_outborn_count', 'elbw_count', 'elbw_inborn_count', 'elbw_outborn_count', 'LAMA_DOR_total_count', 'LAMA_DOR_lbw_count', 'LAMA_DOR_lbw_inborn_count', 'LAMA_DOR_lbw_outborn_count', 'LAMA_DOR_vlbw_count', 'LAMA_DOR_vlbw_inborn_count', 'LAMA_DOR_vlbw_outborn_count', 'LAMA_DOR_elbw_count', 'LAMA_DOR_elbw_inborn_count', 'LAMA_DOR_elbw_outborn_count', 'died_count', 'inborn_died_count', 'outborn_died_count', 'lbw_died_count', 'lbw_inborn_died_count', 'lbw_outborn_died_count', 'vlbw_died_count', 'vlbw_inborn_died_count', 'vlbw_outborn_died_count', 'elbw_died_count', 'elbw_inborn_died_count', 'elbw_outborn_died_count', 'died', 'transferred', 'refer_out_count'));
    }

    /**
     * DISPLAY THE FILTER FORM FOR OP REPORT
     * 
     */
    public function filter()
    {
        $navigate['main_nav'] = 'report';
        $navigate['sub_nav'] = 'nnf';

        $SubmitButtonText  = "Filter";

        $opname_list =  Config('exportfields.op_report');
        return view('reports.nnf.filter', compact('SubmitButtonText', 'navigate'));
    }
}
