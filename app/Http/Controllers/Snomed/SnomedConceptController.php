<?php

namespace App\Http\Controllers\Snomed;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Snomed\SnomedConcept;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Controllers\Snomed\SnomedConstants;



class SnomedConceptController extends Controller
{

	/**
	 * instance of Guard 
	 * @var $auth
	 */

	 /**
	 * instance of SnomedConcept Model 
	 * @var $snomed_concept
	 */

    /**
     *Class constructor 
     *
     */
    public function  __construct(Guard $auth, SnomedConcept $snomed_concept)
    {
        $this->auth           = $auth;
        $this->snomed_concept = $snomed_concept;

    }

    /**
     * This method to get concept list 
     * 
     *@param $limit type integer default 10
     *@param $definition type string default PRIMITIVE 
     *@param $status type integer default 1
     */
    public function getConceptlists($limit = 10, $definition = 'PRIMITIVE', $status = 1)
    {

		$definition     = SnomedConstants::GetConstants($definition);
		$snomed_concept = $this->snomed_concept->getconsceptlist($limit, $definition, $status);
		return \Response::json([$snomed_concept]);

    }

    /**
     * This method to get medicine  
     * based on search text 
     *
     */
    public function getMedicineLists($searchText = '')
    {
        $snomed_concept = $this->snomed_concept->getmedicineList($searchText);
        return \Response::json([$snomed_concept]);

    }
    /**
     * This method to get medicine  
     * based on search text 
     *
     */
    public function getMedicineView(Request $request)
    {
      return view('snomed.medicinelist');
    }




}
