<?php
$models = [
    'Surgeon' => \App\Models\Masters\Surgeon::class,
    'Doctor' => \App\Models\Masters\DoctorMaster::class,
    'Referral' => \App\Models\Masters\BookingPlace::class,
    'Complications' => \App\Models\Masters\Complications::class,
    'MedicalProblem' => \App\Models\Masters\ProblemMaster::class,
    'Procedures' => \App\Models\Masters\ProcedureMaster::class,
    'Antibiotics' => \App\Models\Masters\AntibioticMaster::class,
    'Drugs' => \App\Models\Masters\DrugIvFluidMaster::class,
    'Vaccines' => \App\Models\Masters\Vaccine::class,
    'ICD' => \App\Models\Icd::class
];

$output = [];

foreach ($models as $name => $class) {
    try {
        $query = $class::where('IsDeleted', '0');

        // Try to filter by active status if column exists. 
        // Common names: Status, status, Active, active.
        $instance = new $class;
        $cols = array_keys($instance->getAttributes()); // This is empty for new instance usually unless attributes set
        // Better:
        $sample = $class::first();
        if ($sample) {
            $cols = array_keys($sample->toArray());
            if (in_array('Status', $cols))
                $query->where('Status', 1);
            elseif (in_array('status', $cols))
                $query->where('status', 1);
            elseif (in_array('Active', $cols))
                $query->where('Active', 1);
            elseif (in_array('active', $cols))
                $query->where('active', 1);
        }

        if ($name == 'ICD') {
            $data = $query->take(20)->get();
        } else {
            $data = $query->get();
        }

        $list = [];
        foreach ($data as $item) {
            $id = $item->id ?? $item->Id ?? $item->ID ?? $item->ID;

            // Determine Name Column
            $val = null;
            if ($name == 'Surgeon')
                $val = $item->surgeon_name;
            elseif ($name == 'Doctor')
                $val = $item->Name; // DoctorMaster usually Name
            elseif ($name == 'Referral')
                $val = $item->referral_name ?? $item->Name;
            elseif ($name == 'Complications')
                $val = $item->complication_name ?? $item->Name;
            elseif ($name == 'MedicalProblem')
                $val = $item->problem_name ?? $item->Name;
            elseif ($name == 'Procedures')
                $val = $item->procedure_name ?? $item->Name;
            elseif ($name == 'Antibiotics')
                $val = $item->antibiotic_name ?? $item->Name;
            elseif ($name == 'Drugs')
                $val = $item->drug_name ?? $item->brand_name ?? $item->Name;
            elseif ($name == 'Vaccines')
                $val = $item->vaccine_name ?? $item->Name;
            elseif ($name == 'ICD')
                $val = ($item->icd_code ?? '') . ' - ' . ($item->icd_name ?? $item->Name ?? '');

            if (!$val) {
                // Fallback
                $val = $item->Name ?? $item->name ?? 'Unknown';
            }

            $list[] = ['id' => $id, 'name' => $val];
        }
        $output[$name] = $list;

    } catch (\Exception $e) {
        $output[$name] = "Error: " . $e->getMessage();
    }
}
echo json_encode($output, JSON_PRETTY_PRINT);
