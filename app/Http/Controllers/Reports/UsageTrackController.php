<?php

namespace App\Http\Controllers\Reports;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Nurse\EmrLogDetails;
use App\Models\DashboardEvent;
use App\User;
use Carbon\Carbon;

class UsageTrackController extends Controller
{
    /**
     * Display nurse sheet usage.
     *
     */
    public function list(Request $request)
    {
        //setting the navigation bar
        $navigate['main_nav'] = 'report';
        $navigate['sub_nav'] = 'usage_tracker';

        $input = $request->all();
        $from_date = null;
        $to_date = null;
        if (!empty($input['from_date']) && !empty($input['to_date'])) {
            $from_date = date('Y-m-d', strtotime($input['from_date'])) . ' 00:00:00';
            $to_date = date('Y-m-d', strtotime($input['to_date'])) . ' 23:59:59';
        } else {
            $from_date = new Carbon("first day of last month");
            $to_date = new Carbon("last day of last month");

            $from_date = $from_date->format('Y-m-d') . ' 00:00:00';
            $to_date = $to_date->format('Y-m-d') . ' 23:59:59';
        }
        $entry_results = EmrLogDetails::GetNursesUsage($from_date, $to_date);
        $event_results = DashboardEvent::GetNursesEventUsage($from_date, $to_date);

        $nurse_list = User::getNurse();
        $from_date = (isset($input['from_date']) && !empty($input['from_date'])) ? $input['from_date'] : date('d-m-Y', strtotime($from_date));
        $to_date = (isset($input['to_date']) && !empty($input['to_date'])) ? $input['to_date'] : date('d-m-Y', strtotime($to_date));

        return view('reports.usage_tracker', compact('entry_results', 'event_results', 'from_date', 'to_date', 'nurse_list', 'navigate'));
    }
}
