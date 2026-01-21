<?php

namespace App\Http\Controllers\Fhir;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Models\Fhir\FhirJsonSchema;

class FhirJsonSchemaController extends Controller
{
    function __construct(Guard $auth)
    {
        // $this->middleware('role:FHIR_JSON_SCHEMA,write', ['only' => ['store', 'update', 'edit', 'create', 'show', 'destroy']]);
        // $this->middleware('role:FHIR_JSON_SCHEMA,read', ['only' => ['index', 'printData']]);
        $this->middleware('auth');
        $this->auth = $auth;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $input = $request->all();

        $limit = 10;

        if (!empty($input['limit'])) {
            $request->session()->put('limit', $input['limit']);
            $limit = $request->session()->get('limit');
        } elseif ($request->session()->has('limit')) {
            $limit = $request->session()->get('limit');
        }

        $navigate['main_nav'] = 'fihr_json_schema';
        $navigate['sub_nav'] = 'fihr_json_schema';    

        $order['sortby'] = 'fihr_json_schema.resource_type';
        $order['sortorder'] = 'desc';

        if (!empty($input['sortby']) && !empty($input['sortorder'])) {
            $order['sortby'] = \SiteHelpers::decrypt_id($input['sortby']);
            $order['sortorder'] = $input['sortorder'];
        }

        $search_txt = '';

        if (!empty($request->input('search_txt'))) {
            $search_txt = $request->input('search_txt');
        }

        $input['page'] = 1;
        
        $lists = FhirJsonSchema::get_list($input['page'], $limit, $search_txt, $order);

        $count = FhirJsonSchema::getTotal();

        $pagination['limits'] = $limit;        

        return view('fihr_json_schema.list', compact('navigate','pagination','lists','search_txt', 'count')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $fhirjsonschema = FhirJsonSchema::find($id);
        $fhirjsonschema = FhirJsonSchema::get_record($id);

        return view('fihr_json_schema.show', compact('fhirjsonschema')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
