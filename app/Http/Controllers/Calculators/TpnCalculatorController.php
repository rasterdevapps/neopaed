<?php

namespace App\Http\Controllers\Calculators;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Baby;
use App\Models\Nurse\NurseSheetMain;
use App\Models\DaycareQuestions;

class TpnCalculatorController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:CALCULATOR,read');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $baby_id = $request->baby_id;
        if (!empty($baby_id)) {
            $baby_id = \SiteHelpers::decrypt_id($baby_id);
        } else {
            $baby_id = null;
        }
        $navigate['main_nav'] = 'calc';
        $navigate['sub_nav'] = 'tpn_calc';

        $baby = Baby::babyListData();

        $babies = \ValuelistHelpers::select2DataFormater($baby);

        return view('calculators.tpn_calculator', compact('babies', 'navigate', 'baby_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLatestWeight($id)
    {
     
        $id = \SiteHelpers::decrypt_id($id);
        $nurse_sheet_prev_wt = NurseSheetMain::getPreviousWorkingWeight($id);
        $prev_wt = isset($nurse_sheet_prev_wt->working_weight) ? $nurse_sheet_prev_wt->working_weight : 0;
        if ($prev_wt == 0) {
            $daycare_prev_wt = DaycareQuestions::getPreviousWorkingWeight($id);
            $prev_wt = isset($daycare_prev_wt->workingWeight) ? $daycare_prev_wt->workingWeight : 0;
        }
        return \Response::json(['prev_wt' => $prev_wt]);
    }

}
