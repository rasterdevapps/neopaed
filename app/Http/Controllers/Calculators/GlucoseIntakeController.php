<?php namespace App\Http\Controllers\Calculators;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class GlucoseIntakeController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $baby_id = $request->input('baby_id');
        $date = $request->input('date', date('Y-m-d'));
        
        $data = [];
        $baby = null;

        if ($baby_id) {
            $baby = DB::table('baby')->where('BabyId', $baby_id)->first();
            
            if ($baby) {
                // Fetch prescriptions for this baby active on this date
                // We utilize prescription_infused_calculation which stores hourly infused data
                
                // Join prescription_infused_calculation with prescription_dtl -> prescription_hdr
                // actually prescription_infused_calculation has prescription_id which links to prescription links to prescription_dtl?
                // prescription_infused_calculation -> prescription_id is the unique ID from the machine/prescription table.
                // We need to link it back to our internal prescription_hdr to get glucose concentration.
                
                // prescription_infused_calculation (prescription_id) 
                // -> prescription_dtl (prescription_id) -> prescription_hdr (pres_hdr_id)
                
                // Let's assume prescription_id in calculation table is the same as in dtl/hdr or dtl.
                
                $start_time = Carbon::parse($date)->startOfDay();
                $end_time = Carbon::parse($date)->endOfDay();

                $infused_data = DB::table('prescription_infused_calculation as pic')
                    ->join('prescription_dtl as pd', 'pic.prescription_id', '=', 'pd.prescription_id')
                    ->join('prescription_hdr as ph', 'pd.pres_hdr_id', '=', 'ph.id')
                    ->select(
                        'pic.hour_infused',
                        'ph.glucose_concentration',
                        'ph.glucose_infusion_rate',
                        'ph.working_weight'
                    )
                    ->where('ph.baby_id', $baby_id)
                    ->whereBetween('pic.calculated_hour', [$start_time, $end_time])
                    ->whereNotNull('ph.glucose_concentration')
                    ->get();
                
                $total_glucose_grams = 0;
                $total_volume_ml = 0;
                $working_weight = 0;

                foreach ($infused_data as $row) {
                    $volume = $row->hour_infused;
                    $concentration = $row->glucose_concentration; // %
                    
                    if ($row->working_weight > 0) {
                        $working_weight = $row->working_weight;
                    }

                    if ($volume > 0 && $concentration > 0) {
                        $grams = ($volume * $concentration) / 100;
                        $total_glucose_grams += $grams;
                        $total_volume_ml += $volume;
                    }
                }

                // Use working weight if found in prescriptions, otherwise fallback to birth weight (converted to Kg if needed, but usually working weight is in Kg or grams? BirthWeight is in grams in DB usually)
                // Checking DB schema or usage: BirthWeight in baby table is usually Grams.
                // working_weight in prescription is likely Kg or Grams? 
                // In prescription view, label is usually just "Weight".
                // Based on "4 value is working weight", likely Kg.
                // Let's assume working_weight is Kg if < 10, or grams if > 100? 
                // Or standard is grams in this system? 
                // The prompt said "4 value is the working weight = 4kg". So if DB has 4, it is Kg.
                // Baby->BirthWeight is usually grams (e.g. 3000).
                
                $weight_used = 0;
                $weight_source = '';

                if ($working_weight > 0) {
                     // Check if working weight is likely grams or kg. 
                     // If it's 4, it's Kg. If it's 4000, it's g.
                     // Let's normalize to Kg for calculation.
                     if ($working_weight > 20) { // Assuming babies > 20kg are rare in NICU/Paed context if expressed as Kg. 
                         $weight_kg = $working_weight / 1000;
                     } else {
                         $weight_kg = $working_weight;
                     }
                     $weight_source = 'Working Weight';
                } else {
                    $weight_kg = ($baby->BirthWeight) / 1000;
                    $weight_source = 'Birth Weight';
                }
                
                // Doctor's Formula Implementation:
                // 1. Glucose (g) = (Volume * Concentration) / 100  (Accumulated above)
                // 2. Total Kcal = Glucose (g) * 4
                
                $total_kcal = $total_glucose_grams * 4;
                
                $kcal_per_kg = 0;
                if ($weight_kg > 0) {
                    $kcal_per_kg = $total_kcal / $weight_kg;
                }

                $data = [
                    'baby' => $baby,
                    'total_glucose_grams' => $total_glucose_grams,
                    'total_volume_ml' => $total_volume_ml,
                    'total_kcal' => $total_kcal,
                    'kcal_per_kg' => $kcal_per_kg,
                    'weight_kg' => $weight_kg,
                    'weight_source' => $weight_source
                ];
            }
        }

        return view('calculators.glucose.intake', compact('data', 'baby_id', 'date'));
    }
}
