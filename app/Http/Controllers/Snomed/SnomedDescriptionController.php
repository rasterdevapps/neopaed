<?php

namespace App\Http\Controllers\Snomed;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Snomed\SnomedConstants;
use App\Models\Snomed\SnomedDescription;
use Illuminate\Contracts\Auth\Guard;


class SnomedDescriptionController extends Controller
{

	/**
	 * instance of Guard 
	 * @var $auth
	 */

	 /**
	 * instance of SnomedConcept Model 
	 * @var $snomed_description
	 */

    /**
     *Class constructor 
     *
     */
    public function  __construct(Guard $auth, SnomedDescription $snomed_description)
    {
        $this->auth               = $auth;
        $this->snomed_description = $snomed_description;

    }

    public function getdescriptionlist($term, $status, $type, $limit = 10) 
    {
	    	$type     = SnomedConstants::GetConstants($type);
	    	$list = $this->snomed_description->getdescription($term, $status, $type, $limit);
	    	$list = $list->pluck('term','conceptid');
	        return \Response::json([$list]);

    }
   
}
