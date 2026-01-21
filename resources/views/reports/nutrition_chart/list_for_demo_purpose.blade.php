@extends('app')
@section('content')
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li><i class="icon-home"></i><a href="{{url('/')}}">Dashboard</a></li>
        <li class="current"><a href="{{ action('Reports\NutritionChartController@index') }}">Nutrition Chart</a></li>       
    </ul>
</div>
<div class="row row-spacing">
    <div class="col-md-12">
        <div class="widget box table-view-shadow">
            <div class="widget-header">
                <h4>Nutrition Chart</h4>
            </div>
            <div class="widget-content">
                <div class="row mt-15 mb-20 p-10 multi-search display-grid" style="border: 1px solid #dddddd; border-radius: 5px; float: unset;">
                    <div class="col-md-3">
                        {{ Lang::get('home.mrn') }}:<span class="required-label"></span> {{ Form::text('mrn','',['id'=>'uhidSearch','class'=>'form-control']) }}
                    </div>
                    <div class="col-md-3" style="display: flex;flex-direction: row;justify-content: center;align-items: center;height: 70px;">
                        <button type="button" onclick="displayNutrition()" class="btn btn-primary save-button-shadow mr-10"> Search </button>
                        <button type="button" class="btn btn-default save-button-shadow mr-10" id="reset">Reset</button>
                    </div>
                </div>
                <div id="resultArea">
                    <p>Enter a UHID above to view the daily nutritional calculations.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    const babyData = [
            {
                "uhid": "785634",
                "name": "B/O Dhivya",
                "weight_kg": 3.00,
                // Concentrations are now ignored by the display function
                "Aminoven_conc": 10,
                "Lipid_conc": 20,
                "Milk_Protein_conc": 2.5,
                "Milk_Carb_conc": 6.9,
                "daily_log": {
                    "2025-10-01": {
                        "GIR_mg_kg_min": 4.18,
                        "Glucose_g_kg_day": 6.00,
                        "Protein_g_kg_day": 0.00,
                        "Lipid_g_kg_day": 0.00,
                        "Milk_mL_kg_day": 30.0,
                        "Energy_kcal_kg_day": 44.0
                    },
                    "2025-10-02": {
                        "GIR_mg_kg_min": 5.20,
                        "Glucose_g_kg_day": 7.50,
                        "Protein_g_kg_day": 3.00,
                        "Lipid_g_kg_day": 2.50,
                        "Milk_mL_kg_day": 60.0,
                        "Energy_kcal_kg_day": 100.0
                    },
                    "2025-10-03": {
                        "GIR_mg_kg_min": 0.00,
                        "Glucose_g_kg_day": 0.00,
                        "Protein_g_kg_day": 0.00,
                        "Lipid_g_kg_day": 0.00,
                        "Milk_mL_kg_day": 165.0,
                        "Energy_kcal_kg_day": 111.0
                    }
                }
            }
        ];

        // --- DISPLAY FUNCTION (Lookup Only - No Calculation) ---
        function displayNutrition() {
            const searchId = document.getElementById('uhidSearch').value.trim();
            const baby = babyData.find(b => b.uhid === searchId);
            const resultDiv = document.getElementById('resultArea');
            resultDiv.innerHTML = ''; 

            if (!baby) {
                resultDiv.innerHTML = ``;
                return;
            }

            const dailyLogs = baby.daily_log;
            const dates = Object.keys(dailyLogs).sort();

            let html = `
                <h2>Nutrition Log for ${baby.name} (UHID: ${baby.uhid})</h2>
                <p><strong>Weight:</strong> ${baby.weight_kg.toFixed(2)} kg</p>
                
                <table class="table table-striped table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th class="key-metric">GIR (mg/kg/min)</th>
                            <th class="key-metric">Glucose (g/kg/day)</th>
                            <th class="key-metric">Protein (g/kg/day)</th>
                            <th class="key-metric">Lipid (g/kg/day)</th>
                            <th class="key-metric">Milk (mL/kg/day)</th>
                            <th class="key-metric">Energy (kcal/kg/day)</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            dates.forEach((date, index) => {
                const log = dailyLogs[date];
                const dayLabel = `Day ${index + 1} (${date})`;

                html += `
                    <tr>
                        <td>${dayLabel}</td>
                        <td class="key-metric">${log.GIR_mg_kg_min.toFixed(2)}</td>
                        <td class="key-metric">${log.Glucose_g_kg_day.toFixed(2)}</td> 
                        <td class="key-metric">${log.Protein_g_kg_day.toFixed(2)}</td>
                        <td class="key-metric">${log.Lipid_g_kg_day.toFixed(2)}</td>
                        <td class="key-metric">${log.Milk_mL_kg_day.toFixed(1)}</td>
                        <td class="key-metric">${log.Energy_kcal_kg_day.toFixed(1)}</td>
                    </tr>
                `;
            });

            html += `</tbody></table>`;
            resultDiv.innerHTML = html;
        }

        // Automatically display the nutrition data when the page loads
        document.addEventListener('DOMContentLoaded', displayNutrition);
    </script>
@endsection