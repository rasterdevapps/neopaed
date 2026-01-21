<?php

namespace App\Http\Controllers\Fhir;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Fhir\FhirJsonSchema;

class FhirSchemaController extends Controller
{

    public function index()
    {
    	$result = FhirJsonSchema::get_resource_schema();

    }
}
