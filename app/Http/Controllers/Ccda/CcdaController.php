<?php

namespace App\Http\Controllers\Ccda;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Xml;
use App\Http\Controllers\Ccda\Array2XML;
use App\Models\Baby as Baby;
use App\Models\Nicu;



class CcdaController extends Controller
{
    /**
     * This variable refer the sample document
     * @var $sample_xml
     */
     public $sample_xml;


	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->sample_xml = public_path().'/discharge_summary.xml';

	}

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	 public function ccdadecorde(Request $request) 
	 {

		$yourResponseData = file_get_contents($this->sample_xml);

	    $xmltoarray =  Xml::decode($yourResponseData);
         echo '<pre>';print_r($xmltoarray['recordTarget']);exit;


		foreach ($xmltoarray as $key => $value) {

         echo '<pre>';print_r($key);
			
		}
		exit;

	}

    /**
	 * Create a new controller instance.
	 *
	 * @return void
	*/
	public function ccdaencode(Request $request, $baby_id) 
	{

		$baby = Baby::get_data($baby_id)->first();
		$this->header      = $this->createccdaheader();
		$this->patient     = $this->createccdaaddress($this->header, $baby);
		$this->hospital    = $this->createccdahospitaladdress($this->patient);
		$this->dataenterer = $this->createccdadataenterer($this->hospital);
		$this->custodaian  = $this->createccdacustodian($this->dataenterer);
		$this->information = $this->createccdainformation($this->custodaian);
		$this->legalauth   = $this->createlegalauthenticator($this->information);
		$this->body        = $this->createbody($this->legalauth, $baby_id);



		echo htmlentities($this->header->asXML());

		// return response($this->result, 200)->header('Content-Type', 'application/xml');

	}

	/**
	 * Create a new controller instance.
	 * 
	 * @param $element tag in string
	 */
	public function createbasenode($element) 
	{

		return new \SimpleXMLElement($element);

	}

    /**
	 * Create a new controller instance.
	 * 
	 * @param $element tag in string
	 */
    public function createccdaheader()
    {

        $this->header = $this->createbasenode('<ClinicalDocument xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"></ClinicalDocument>');
	    $this->header->addAttribute('classCode', 'DOCCLIN');
	    $this->header->addAttribute('moodCode', 'EVN');
	    $this->header->addAttribute('xmlns', 'urn:hl7-org:v3');

        // create realmcode tag
 		$this->realmcode = $this->header->addChild('realmCode');
		$this->realmcode->addAttribute('code', 'IN');
        // end realmcode 

        // create realmcode tag
 		$this->typeid = $this->header->addChild('typeId');
		$this->typeid->addAttribute('root', '2.16.840.1.113883.1.3');
		$this->typeid->addAttribute('extension', 'POCD_HD000040');
        // end realmcode tag
       
        // create templateId tag
 		$this->templateId = $this->header->addChild('templateId');
		$this->templateId->addAttribute('root', '2.16.840.1.113883.6.96');
        // end templateId tag

        // create realmcode tag
 		$this->id = $this->header->addChild('id');
		$this->id->addAttribute('root', '2.16.840.1.113883.6.96');
		$this->id->addAttribute('extension', 'Test CCDA');
        // end realmcode tag

        // create realmcode tag
 		$this->code = $this->header->addChild('code');
		$this->code->addAttribute('code', '371534008');
		$this->code->addAttribute('codeSystem', '2.16.840.1.113883.6.96');
		$this->code->addAttribute('codeSystemName', 'SNOMED CT');
		$this->code->addAttribute('displayName', 'Summary report');
        // end realmcode tag
       
        // create title tag
	    $this->title = $this->header->addChild('title', 'THE Health Summary');
		$this->title->addAttribute('mediaType', 'text/plain');
		$this->title->addAttribute('representation', 'TXT');
        // end title tag

        // create effectiveTime tag
	    $this->effectiveTime = $this->header->addChild('effectiveTime');
		$this->effectiveTime->addAttribute('value', '20190220100012.225');
        // end effectiveTime tag

        // create confidentialityCode tag
	    $this->confidentialitycode = $this->header->addChild('confidentialityCode');
		$this->confidentialitycode->addAttribute('code', 'N');
		$this->confidentialitycode->addAttribute('codeSystem', '2.16.840.1.113883.5.25');
		$this->confidentialitycode->addAttribute('displayName', 'normal');
        // end title tag

        $this->languagecode = $this->header->addChild('languageCode');
		$this->languagecode->addAttribute('code', 'en-US');

        return  $this->header;

    }


	/**
	 * Create a new controller instance.
	 * 
	 * @param $element tag in string
	 */
	public function createccdaaddress($header, $baby)
	{

		//echo '<pre>';print_r($baby);exit;


		$this->header    = $header;
		$this->address   = $this->header->addChild('recordTarget');
	    $this->address->addAttribute('typeCode', 'RCT');
	    $this->address->addAttribute('contextControlCode', 'OP');

	    //first id create 
	    $this->id_first  = $this->address->addChild('patientRole');
	    $this->id_first1 = $this->id_first->addChild('id');
	    $this->id_first1->addAttribute('root', '2.16.840.1.113883.6.96');
		$this->id_first1->addAttribute('extension', '2fde2b21-519b-428f-8c20-b94b6963774c');
		//first id create 

        //create id secound
	    $this->id_secound = $this->id_first->addChild('id');
	    $this->id_secound->addAttribute('root', '');
		$this->id_secound->addAttribute('extension', 'AadharNumber');
        //end id secound

        //create id three
	    $this->id_three = $this->id_first->addChild('id');
		$this->id_three->addAttribute('root', '2fde2b21-519b-428f-8c20-b94b6963774c');
		$this->id_three->addAttribute('extension', 'NeopaedPatientId');
        //end id three

        //create id four
	    $this->id_four = $this->id_first->addChild('id');
		$this->id_four->addAttribute('root', '2000000100000529');
		$this->id_four->addAttribute('extension', 'RecipientPatientId');
        //end id four
       
        //telecom
	    $this->telecom = $this->id_first->addChild('telecom');
        $this->telecom->addAttribute('value', $baby->Mobile);
        $this->telecom->addAttribute('use','MC');
		//telecom

        //create addr tag
		$this->addr = $this->id_first->addChild('addr');
		$this->addr->addAttribute('use', 'HP');
		$this->addr->addChild('streetAddressLine', $baby->Address1)->addAttribute('partType', 'SAL');
		$this->addr->addChild('city', $baby->Address2)->addAttribute('partType', 'CTY');
		$this->addr->addChild('state',  $baby->Address3)->addAttribute('partType', 'STA');
		$this->addr->addChild('postalCode', $baby->Address4)->addAttribute('partType', 'ZIP');
		$this->addr->addChild('country',  $baby->Country)->addAttribute('partType', 'CNT');
		//end addr tag
       
        //create patient tag
	    $this->patient = $this->id_first->addChild('patient');
		$this->patient->addAttribute('xsi:type', 'POCD_MT000040.Patient');
		$this->patient->addAttribute('classCode', 'PSN');
		$this->patient->addAttribute('determinerCode', 'INSTANCE');

		$this->name =  $this->patient->addChild('name');
		$this->name->addChild('given', $baby->BabyName)->addAttribute('partType', 'GIV');
		$this->name->addChild('family', '')->addAttribute('partType', 'FAM');

		//create administrativeGenderCode
		$this->administrative =  $this->patient->addChild('administrativeGenderCode');

		$gender_code  = '';

		if ($baby->Sex == 'Male') {

		  	$gender_code = '248153007';

		} elseif($baby->Sex == 'Female') {

			$gender_code = '248152002';

		} elseif($baby->Sex == 'Indeterminate') {

			$gender_code = '37791004';
		}

		
		$this->administrative->addAttribute('code', $gender_code);
		$this->administrative->addAttribute('codeSystem', '2.16.840.1.113883.6.96');
		$this->administrative->addAttribute('codeSystemName', 'SNOMED CT');
		$this->administrative->addAttribute('displayName', $baby->Sex);
		$this->administrative->addAttribute('value', $baby->Sex);
		//end administrativeGenderCode

		//end birthTime
	    $this->birthTime =  $this->patient->addChild('birthTime');
		$this->birthTime->addAttribute('value', str_replace('-', '', $baby->DOB));
        //edit birthTime 

		//end maritalStatusCode
	    $this->maritalStatusCode =  $this->patient->addChild('maritalStatusCode');
		$this->maritalStatusCode->addAttribute('code', '');
		$this->maritalStatusCode->addAttribute('codeSystem', '2.16.840.1.113883.6.96');
		$this->maritalStatusCode->addAttribute('codeSystemName', 'SNOMED CT');
		$this->maritalStatusCode->addAttribute('displayName', '');

		return $this->header;
	

	}

	/**
	 * adding hospital address.
	 * 
	 * @param $element tag in string
	 */
	public function createccdahospitaladdress($header)
	{

		$this->header    = $header;

		$this->hospital  = $this->header->addChild('author');
	    $this->hospital->addAttribute('typeCode', 'AUT');
	    $this->hospital->addAttribute('contextControlCode', 'OP');

	    $this->time  = $this->hospital->addChild('time');
		$this->time->addAttribute('value', time());

		$this->assignedauthor  = $this->hospital->addChild('assignedAuthor');
		$this->assignedauthor->addAttribute('classCode', 'ASSIGNED');

		$this->authorid  = $this->assignedauthor->addChild('id'); 
		$this->authorid->addAttribute('root', '2.16.840.1.113883.6.96');
		$this->authorid->addAttribute('extension', '1A82FAD8-ECD7-4656-8EC1-AFE88419C09F');

		$this->authorid1 = $this->assignedauthor->addChild('id');
		$this->authorid1->addAttribute('root', '1A82FAD8-ECD7-4656-8EC1-AFE88419C09F');
		$this->authorid1->addAttribute('extension', 'ClinicId');

		$this->codeset = $this->assignedauthor->addChild('code');
		$this->codeset->addAttribute('code', '22232009');
		$this->codeset->addAttribute('codeSystem', '2.16.840.1.113883.6.96');
		$this->codeset->addAttribute('codeSystemName', 'SNOMED CT');
		$this->codeset->addAttribute('displayName', 'Raster Hospital');

		  //create addr tag
		$this->addr1 = $this->assignedauthor->addChild('addr');
		$this->addr1->addChild('streetAddressLine', '#23, Raster Hospital Road, Alagapuram,')->addAttribute('partType', 'SAL');
		$this->addr1->addChild('city', 'Salem')->addAttribute('partType', 'CTY');
		$this->addr1->addChild('state', 'Tamilnadu')->addAttribute('partType', 'STA');
		$this->addr1->addChild('postalCode', '636 004')->addAttribute('partType', 'ZIP');
		$this->addr1->addChild('country',  'india')->addAttribute('partType', 'CNT');
		//end addr tag
       
		$this->telecom1 = $this->assignedauthor->addChild('telecom');
		$this->telecom1->addAttribute('value', '+91-427-403-3333');
		$this->telecom1->addAttribute('use', 'WP');

        $this->assignedperson = $this->assignedauthor->addChild('assignedPerson');
		$this->assignedperson->addAttribute('classCode', 'PSN');
		$this->assignedperson->addAttribute('determinerCode', 'INSTANCE');

		$this->name = $this->assignedperson->addChild('name');
		$this->name->addChild('given','raja')->addAttribute('partType', 'GIV');
		$this->name->addChild('family','')->addAttribute('partType', 'FAM');
		$this->name->addChild('suffix','Dr')->addAttribute('partType', 'SFX');

        return $this->header;


	}

	/**
	 * adding hospital address.
	 * 
	 * @param $element tag in string
	 */	
	public function createccdadataenterer($header)
	{
		$this->header      = $header;

        $this->dataenterer = $this->header->addChild('dataEnterer'); 
        $this->dataenterer->addAttribute('typeCode', 'ENT');
        $this->dataenterer->addAttribute('contextControlCode', 'OP');

        $this->assignedentity = $this->dataenterer->addChild('assignedEntity');
        $this->assignedentity->addAttribute('classCode', 'ASSIGNED');

        $this->assignedentityid = $this->assignedentity->addChild('id');
        $this->assignedentityid->addAttribute('root', '2.16.840.1.113883.6.96');
        $this->assignedentityid->addAttribute('extension', '678910');

        $this->codeset = $this->assignedentity->addChild('code');
		$this->codeset->addAttribute('code', '22232009');
		$this->codeset->addAttribute('codeSystem', '2.16.840.1.113883.6.96');
		$this->codeset->addAttribute('codeSystemName', 'SNOMED CT');
		$this->codeset->addAttribute('displayName', 'Raster Hospital');

        //create addr tag
		$this->addr2 = $this->assignedentity->addChild('addr');
		$this->addr2->addChild('streetAddressLine', '#23, Raster Hospital Road, Alagapuram,')->addAttribute('partType', 'SAL');
		$this->addr2->addChild('city', 'Salem')->addAttribute('partType', 'CTY');
		$this->addr2->addChild('state', 'Tamilnadu')->addAttribute('partType', 'STA');
		$this->addr2->addChild('postalCode', '636 004')->addAttribute('partType', 'ZIP');
		$this->addr2->addChild('country',  'india')->addAttribute('partType', 'CNT');
		//end addr tag
       
		$this->telecom2 = $this->assignedentity->addChild('telecom');
		$this->telecom2->addAttribute('value', '+91-427-403-3333');
		$this->telecom2->addAttribute('use', 'WP');

        $this->assignedperson = $this->assignedentity->addChild('assignedPerson');
		$this->assignedperson->addAttribute('classCode', 'PSN');
		$this->assignedperson->addAttribute('determinerCode', 'INSTANCE');

		$this->name = $this->assignedperson->addChild('name');
		$this->name->addChild('given','raja')->addAttribute('partType', 'GIV');
		$this->name->addChild('family','')->addAttribute('partType', 'FAM');
		$this->name->addChild('suffix','Dr')->addAttribute('partType', 'SFX');

		return $this->header;

	}

	public function createccdacustodian($header)
	{
        $this->header  = $header;

        $this->custodaian = $this->header->addChild('custodian');
        $this->custodaian->addAttribute('typeCode', 'CST');

        $this->assignedcustodian = $this->custodaian->addChild('assignedCustodian');
        $this->assignedcustodian->addAttribute('classCode', 'ASSIGNED');

        $this->represented = $this->assignedcustodian->addChild('representedCustodianOrganization');
        $this->represented->addAttribute('classCode', 'ORG');
        $this->represented->addAttribute('determinerCode', 'INSTANCE');

        $this->representedid = $this->represented->addChild('id');
        $this->representedid->addAttribute('root', '2.16.840.1.113883.6.96');
        $this->representedid->addAttribute('extension', '1A82FAD8-ECD7-4656-8EC1-AFE88419C09F');

        $this->representedname    =  $this->represented->addChild('name', 'Raster Hospital');

        $this->representedtelecom =  $this->represented->addChild('telecom');
        $this->representedtelecom->addAttribute('value', '+91-427-403-3333');
        $this->representedtelecom->addAttribute('use', 'WP');

        $this->representedaddr  = $this->represented->addChild('addr');
        $this->representedaddr->addChild('streetAddressLine', '#23, Raster Hospital Road, Alagapuram,')->addAttribute('partType', 'SAL');
		$this->representedaddr->addChild('city', 'Salem')->addAttribute('partType', 'CTY');
		$this->representedaddr->addChild('state', 'Tamilnadu')->addAttribute('partType', 'STA');
		$this->representedaddr->addChild('postalCode', '636 004')->addAttribute('partType', 'ZIP');
		$this->representedaddr->addChild('country',  'india')->addAttribute('partType', 'CNT');
		return $this->header;

	}

	/**
	 * adding hospital address.
	 * 
	 * @param $element tag in string
	 */
	public function createccdainformation($header)
	{

		$this->header          = $header;
        $this->informations    = $this->header->addChild('informationRecipient');
        $this->intended        = $this->informations->addChild('intendedRecipient');

        $this->intendedid      = $this->intended->addChild('id');
        $this->intendedid->addAttribute('root', '2.16.840.1.113883.6.96');
        $this->intendedid->addAttribute('extension', '23456');

        $this->informationrecipent =  $this->intended->addChild('informationRecipient');
        $this->informationrecipent->addAttribute('classCode', 'PSN');
        $this->informationrecipent->addAttribute('determinerCode', 'INSTANCE');

        $this->informationname = $this->informationrecipent->addChild('name');
        $this->informationname->addChild('given','arun')->addAttribute('partType', 'GIV');
		$this->informationname->addChild('family','')->addAttribute('partType', 'FAM');
		$this->informationname->addChild('suffix','Dr')->addAttribute('partType', 'SFX');

        $this->receivedorg  =   $this->intended->addChild('receivedOrganization'); 
		$this->receivedorg->addAttribute('classCode', 'ORG');
		$this->receivedorg->addAttribute('determinerCode', 'INSTANCE');

        $this->receivedorg->addChild('name','Raster');
        $this->rectelecom =  $this->receivedorg->addChild('telecom');
		$this->rectelecom->addAttribute('value', '9790123880');
		$this->rectelecom->addAttribute('use', 'MC');

        $this->receivedaddr  = $this->receivedorg->addChild('addr');
        $this->receivedaddr->addChild('streetAddressLine', '#23, Raster Hospital Road, Alagapuram,')->addAttribute('partType', 'SAL');
		$this->receivedaddr->addChild('city', 'Salem')->addAttribute('partType', 'CTY');
		$this->receivedaddr->addChild('state', 'Tamilnadu')->addAttribute('partType', 'STA');
		$this->receivedaddr->addChild('postalCode', '636 004')->addAttribute('partType', 'ZIP');
		$this->receivedaddr->addChild('country',  'india')->addAttribute('partType', 'CNT');

        $this->standardindustry = $this->receivedorg->addChild('standardIndustryClassCode');
		$this->standardindustry->addAttribute('code', '28411006');
        $this->standardindustry->addAttribute('codeSystem', '2.16.840.1.113883.6.96');
        $this->standardindustry->addAttribute('codeSystemName', 'SNOMED CT');
        $this->standardindustry->addAttribute('displayName', ' Neonatologist');

		return $this->header;

	}

	/**
	 * adding hospital address.
	 * 
	 * @param $element tag in string
	 */
	public function createlegalauthenticator($header)
	{
		$this->header    = $header;
		$this->legal     = $this->header->addChild('legalAuthenticator');
		$this->legal->addAttribute('typeCode', 'LA');
		$this->legal->addAttribute('contextControlCode', 'OP');

		$this->legaltime = $this->legal->addChild('time');
		$this->legaltime->addAttribute('value', time());

		$this->sign = $this->legal->addChild('signatureCode');
		$this->sign->addAttribute('code', 'S');

		$this->assign = $this->legal->addChild('assignedEntity');
		$this->assign->addAttribute('classCode', 'ASSIGNED');

		$this->assignid = $this->assign->addChild('id'); 
		$this->assignid->addAttribute('root', '2.16.840.1.113883.6.96');
		$this->assignid->addAttribute('extension', '1A82FAD8-ECD7-4656-8EC1-AFE88419C09F');


        $this->legalcodeset = $this->assign->addChild('code');
		$this->legalcodeset->addAttribute('code', '22232009');
		$this->legalcodeset->addAttribute('codeSystem', '2.16.840.1.113883.6.96');
		$this->legalcodeset->addAttribute('codeSystemName', 'SNOMED CT');
		$this->legalcodeset->addAttribute('displayName', 'Raster Hospital');


		$this->addr2 = $this->assign->addChild('addr');
		$this->addr2->addChild('streetAddressLine', '#23, Raster Hospital Road, Alagapuram,')->addAttribute('partType', 'SAL');
		$this->addr2->addChild('city', 'Salem')->addAttribute('partType', 'CTY');
		$this->addr2->addChild('state', 'Tamilnadu')->addAttribute('partType', 'STA');
		$this->addr2->addChild('postalCode', '636 004')->addAttribute('partType', 'ZIP');
		$this->addr2->addChild('country',  'india')->addAttribute('partType', 'CNT');
        
        $this->legaltelecom = $this->assign->addChild('telecom');
		$this->legaltelecom->addAttribute('value', '9790123880');
		$this->legaltelecom->addAttribute('use', 'WP');



        $this->legalassignedPerson = $this->assign->addChild('assignedPerson');
		$this->legalassignedPerson->addAttribute('classCode', 'PSN');
		$this->legalassignedPerson->addAttribute('determinerCode', 'INSTANCE');

		$this->legalname = $this->legalassignedPerson->addChild('name');
		$this->legalname->addChild('given','raja')->addAttribute('partType', 'GIV');
		$this->legalname->addChild('family','')->addAttribute('partType', 'FAM');
		$this->legalname->addChild('suffix','Dr')->addAttribute('partType', 'SFX');
        return $this->header;

	}
    /**
	 * adding hospital address.
	 * 
	 * @param $element tag in string
	 */

    public function createbody($header, $baby_id)
    {

        $nicu  = Nicu::where('BabyId', $baby_id)
                          ->get();
        $tempproblems = $nicu->pluck('DifferentialDiagnosis')->toArray(); 

        $problems = array();

        foreach ($tempproblems as $key => $value) {
        	$problems = array_merge($problems, json_decode($value));
        }                 

    	$this->header = $header;

    	$this->component   = $this->header->addChild('component');
    	$this->component->addAttribute('typeCode', 'COMP');
    	$this->component->addAttribute('contextConductionInd', 'true');

    	$this->structure = $this->component->addChild('structuredBody');
    	$this->structure->addAttribute('classCode', 'DOCBODY');
    	$this->structure->addAttribute('moodCode', 'EVN');

    	$this->problems   = $this->createproblems($this->structure);
    	$this->diagnosis  = $this->createdignosis($this->problems);
    	$this->medication = $this->createmedication($this->diagnosis);
    	//$this->vitalsign  = $this->createccdavitalsign($this->medication);
 
      return $this->header;



    }

    public function createproblems($structure) 
    {



    	$problem = ['Neonatal jaundice' ,'maternal fever'];
    	$problemcode = ['387712008', '386661006'];

        $this->structure  = $structure;

    	$this->component1   = $this->structure->addChild('component');
    	$this->component1->addAttribute('typeCode', 'COMP');
    	$this->component1->addAttribute('contextConductionInd', 'true');

    	$this->section   = $this->component1->addChild('section');
    	$this->section->addAttribute('classCode', 'DOCSECT');
    	$this->section->addAttribute('moodCode', 'EVN');

        $this->templateid   = $this->section->addChild('templateId');
    	$this->templateid->addAttribute('root', '2.16.840.1.113883.6.96');

        $this->problemcode   = $this->section->addChild('code');
    	$this->problemcode->addAttribute('code', '33962009');
    	$this->problemcode->addAttribute('codeSystem', '2.16.840.1.113883.6.96');
    	$this->problemcode->addAttribute('codeSystemName', 'SNOMED CT');
    	$this->problemcode->addAttribute('displayName', 'PROBLEM LIST');


        $this->problemtitle   = $this->section->addChild('title', 'PROBLEM LIST');
    	$this->problemtitle->addAttribute('mediaType', 'text/plain');
    	$this->problemtitle->addAttribute('representation', 'TXT');

    	$this->problemtext   = $this->section->addChild('text');
    	$this->problemtext->addAttribute('mediaType', 'text/x-hl7-text+xml');
    	$this->problemtext->addAttribute('language', 'en-US');

    	$this->problemcontent   = $this->problemtext->addChild('content');
    	$this->problemcontent->addAttribute('ID', 'problems');

    	$this->problemlist   = $this->problemtext->addChild('list');
    	$this->problemlist->addAttribute('listType', 'ordered');

        $i = 0;
    	foreach ($problem as $key => $value) {
    		$i = $key + 1;
	    	 $this->problemitem   = null;
		     $this->problemitem   = $this->problemlist->addChild('item');
		     $this->problemcontent =  $this->problemitem->addChild('content',$value);
		     $this->problemcontent->addAttribute('ID','problem'.$i); 
    	}

        $i = 0;

        foreach ($problem as $key => $value) {

    		$i = $key + 1;

	    	 $this->problementry   = null;

		     $this->problementry   = $this->section->addChild('entry');
             $this->problementry->addAttribute('contextConductionInd', 'true');

             $this->problemact  = $this->problementry->addChild('act');
             $this->problemact->addAttribute('classCode', 'ACT');
             $this->problemact->addAttribute('moodCode', 'EVN');

             $this->problemact->addChild('templateId')->addAttribute('root', '2.16.840.1.113883.6.96');
             $this->problemact->addChild('id')->addAttribute('root', '00000000-0000-0000-0000-000000000000');

             $this->problemactcode =  $this->problemact->addChild('code');
             $this->problemactcode->addAttribute('code', '33962009');
             $this->problemactcode->addAttribute('codeSystem', '2.16.840.1.113883.6.96');
             $this->problemactcode->addAttribute('displayName', 'Chief Complaint');
             $this->problemact->addChild('statusCode')->addAttribute('code','active');

             $this->problemacteffective =  $this->problemact->addChild('effectiveTime');
             $this->problemacteffective->addChild('low')->addAttribute('value', '20190220152458');

             $this->entryRelationship =  $this->problemact->addChild('entryRelationship');
             $this->entryRelationship->addAttribute('typeCode', 'SUBJ');
             $this->entryRelationship->addAttribute('contextConductionInd', 'true');

 			 $this->observ         = $this->entryRelationship->addChild('observation');
 			 $this->observ->addAttribute('classCode', 'OBS');
 			 $this->observ->addAttribute('moodCode', 'EVN');

 			 $this->observ->addChild('templateId')->addAttribute('root', '2.16.840.1.113883.6.96');
 			 $this->observ->addChild('id')->addAttribute('root', '00000000-0000-0000-0000-000000000000');

 			 $this->observcode =  $this->observ->addChild('code');
 			 $this->observcode->addAttribute('code', '409586006');
 			 $this->observcode->addAttribute('codeSystem', '2.16.840.1.113883.6.96');
 			 $this->observcode->addAttribute('codeSystemName', 'SNOMED CT');
 			 $this->observcode->addAttribute('displayName', 'Complaint');

  			 $this->observcodetext =  $this->observ->addChild('text');
  			 $this->observcodetext->addAttribute('representation', 'TXT');
  			 $this->observcodetext->addChild('reference')->addAttribute('value', '#problem'.$i);
			
			 $this->observ->addChild('statusCode')->addAttribute('code', 'completed');

             $this->observeffective =  $this->observ->addChild('effectiveTime');
             $this->observeffective->addChild('low')->addAttribute('value', '20190220152458');
			 
             $this->observvalue =  $this->observ->addChild('value');
			 $this->observvalue->addAttribute('xsi:type', 'CD','xsi');
			 $this->observvalue->addAttribute('code', $problemcode[$key]);
			 $this->observvalue->addAttribute('codeSystem', '2.16.840.1.113883.6.96');
			 $this->observvalue->addAttribute('codeSystemName', 'SNOMED CT');
			 $this->observvalue->addAttribute('displayName', $value);


    	}

    	return  $this->structure;

    }


    public function createdignosis($structure) 
    {



    	$problem = [' Dengue' ,' neonatal sepsis'];
    	$problemcode = ['38362002', '276669000'];

        $this->structure  = $structure;

    	$this->component1   = $this->structure->addChild('component');
    	$this->component1->addAttribute('typeCode', 'COMP');
    	$this->component1->addAttribute('contextConductionInd', 'true');

    	$this->section   = $this->component1->addChild('section');
    	$this->section->addAttribute('classCode', 'DOCSECT');
    	$this->section->addAttribute('moodCode', 'EVN');

        $this->templateid   = $this->section->addChild('templateId');
    	$this->templateid->addAttribute('root', '2.16.840.1.113883.10.20.22.2.43.2');

        $this->problemcode   = $this->section->addChild('code');
    	$this->problemcode->addAttribute('code', '439401001');
    	$this->problemcode->addAttribute('codeSystem', '2.16.840.1.113883.6.96');
    	$this->problemcode->addAttribute('codeSystemName', 'SNOMED CT');
    	$this->problemcode->addAttribute('displayName', 'DIAGNOSIS LIST');


        $this->problemtitle   = $this->section->addChild('title', 'DIAGNOSIS LIST');
    	$this->problemtitle->addAttribute('mediaType', 'text/plain');
    	$this->problemtitle->addAttribute('representation', 'TXT');

    	$this->problemtext   = $this->section->addChild('text');
    	$this->problemtext->addAttribute('mediaType', 'text/x-hl7-text+xml');
    	$this->problemtext->addAttribute('language', 'en-US');

    	$this->problemcontent   = $this->problemtext->addChild('content');
    	$this->problemcontent->addAttribute('ID', 'diagnosis');

    	$this->problemlist   = $this->problemtext->addChild('list');
    	$this->problemlist->addAttribute('listType', 'ordered');

    	foreach ($problem as $key => $value) {
	    	 $this->problemitem   = null;
		     $this->problemitem   = $this->problemlist->addChild('item');
		     $this->problemcontent =  $this->problemitem->addChild('content',$value);
		     $this->problemcontent->addAttribute('ID','diagnosis'.$key); 
    	}


        foreach ($problem as $key => $value) {


	    	 $this->problementry   = null;

		     $this->problementry   = $this->section->addChild('entry');
             $this->problementry->addAttribute('contextConductionInd', 'true');

             $this->problemact  = $this->problementry->addChild('act');
             $this->problemact->addAttribute('classCode', 'ACT');
             $this->problemact->addAttribute('moodCode', 'EVN');

             $this->problemact->addChild('templateId')->addAttribute('root', '2.16.840.1.113883.6.96');

             $this->problemact->addChild('id')->addAttribute('root', '00000000-0000-0000-0000-000000000000');


             $this->problemactcode =  $this->problemact->addChild('code');
             $this->problemactcode->addAttribute('code', '439401001');
             $this->problemactcode->addAttribute('codeSystem', '2.16.840.1.113883.6.96');
             $this->problemactcode->addAttribute('displayName', 'Diagnosis');


             $this->problemact->addChild('statusCode')->addAttribute('code','active');

             $this->problemacteffective =  $this->problemact->addChild('effectiveTime');
             $this->problemacteffective->addChild('low')->addAttribute('value', '20190220152458');

             $this->entryRelationship =  $this->problemact->addChild('entryRelationship');
             $this->entryRelationship->addAttribute('typeCode', 'SUBJ');
             $this->entryRelationship->addAttribute('contextConductionInd', 'true');

 			 $this->observ         = $this->entryRelationship->addChild('observation');
 			 $this->observ->addAttribute('classCode', 'OBS');
 			 $this->observ->addAttribute('moodCode', 'EVN');

 			 $this->observ->addChild('templateId')->addAttribute('root', '2.16.840.1.113883.6.96');
 			 $this->observ->addChild('id')->addAttribute('root', '00000000-0000-0000-0000-000000000000');

 			 $this->observcode =  $this->observ->addChild('code');
 			 $this->observcode->addAttribute('code', '439401001');
 			 $this->observcode->addAttribute('codeSystem', '2.16.840.1.113883.6.96');
 			 $this->observcode->addAttribute('codeSystemName', 'SNOMED CT');
 			 $this->observcode->addAttribute('displayName', 'DIAGNOSIS');

  			 $this->observcodetext =  $this->observ->addChild('text');
  			 $this->observcodetext->addAttribute('representation', 'TXT');
  			 $this->observcodetext->addChild('reference')->addAttribute('value', '#diagnosis'.$key);
			
			 $this->observ->addChild('statusCode')->addAttribute('code', 'completed');

             $this->observeffective =  $this->observ->addChild('effectiveTime');
             $this->observeffective->addChild('low')->addAttribute('value', '20190220152458');
			 
             $this->observvalue =  $this->observ->addChild('value');
			 $this->observvalue->addAttribute('xsi:type', 'CD', 'xsi');
			 $this->observvalue->addAttribute('code', $problemcode[$key]);
			 $this->observvalue->addAttribute('codeSystem', '2.16.840.1.113883.6.96');
			 $this->observvalue->addAttribute('codeSystemName', 'SNOMED CT');
			 $this->observvalue->addAttribute('displayName', $value);


    	}

    	return  $this->structure;

    }


    public function createmedication($structure) 
    {



    	$problem = ['Cefotaxime 2 ml once daily for 5days' ,'Amikacin 0.5 ml once daily for 15days', 'Hifital drops 0.5 ml once daily for 1 year'];
    	$problemcode = ['372704003', '387266001', '387307005'];

    	$unit = ['ml','ml','ml'];
    	$dose = ['2','0.5','0.5'];

        $this->structure  = $structure;

    	$this->component1   = $this->structure->addChild('component');
    	$this->component1->addAttribute('typeCode', 'COMP');
    	$this->component1->addAttribute('contextConductionInd', 'true');

    	$this->section   = $this->component1->addChild('section');
    	$this->section->addAttribute('classCode', 'DOCSECT');
    	$this->section->addAttribute('moodCode', 'EVN');

        $this->templateid   = $this->section->addChild('templateId');
    	$this->templateid->addAttribute('root', '2.16.840.1.113883.10.20.22.2.1');

        $this->problemcode   = $this->section->addChild('code');
    	$this->problemcode->addAttribute('displayName', 'HISTORY OF MEDICATION USE');


        $this->problemtitle   = $this->section->addChild('title', 'MEDICATIONS LIST');
    	$this->problemtitle->addAttribute('mediaType', 'text/plain');
    	$this->problemtitle->addAttribute('representation', 'TXT');

    	$this->problemtext   = $this->section->addChild('text');
    	$this->problemtext->addAttribute('mediaType', 'text/x-hl7-text+xml');
    	$this->problemtext->addAttribute('language', 'en-US');

   

    	$this->problemlist   = $this->problemtext->addChild('list');
    	$this->problemlist->addAttribute('listType', 'ordered');

    	foreach ($problem as $key => $value) {
	    	 $this->problemitem   = null;
		     $this->problemitem   = $this->problemlist->addChild('item');
		     $this->problemcontent =  $this->problemitem->addChild('content',$value);
		     $this->problemcontent->addAttribute('ID','medication'.$key); 
    	}


        foreach ($problem as $key => $value) {


	    	 $this->problementry   = null;

		     $this->problementry   = $this->section->addChild('entry');
             $this->problementry->addAttribute('contextConductionInd', 'true');

             $this->medicationsubstance  = $this->problementry->addChild('substanceAdministration');
             $this->medicationsubstance->addAttribute('classCode', 'SBADM');
             $this->medicationsubstance->addAttribute('moodCode', 'EVN');

             $this->medicationsubstance->addChild('templateId')->addAttribute('root', '2.16.840.1.113883.10.20.22.4.16');
             $this->medicationsubstance->addChild('id')->addAttribute('root', '00000000-0000-0000-0000-000000000000');
             
             $this->medicaltext = $this->medicationsubstance->addChild('text');
             $this->medicaltext->addAttribute('representation', 'TXT');
             $this->medicaltext->addChild('reference')->addAttribute('value', '#medication'.$key);

		 	 $this->medicationsubstance->addChild('statusCode')->addAttribute('code','active');

  			 $this->medicationeffective =  $this->medicationsubstance->addChild('effectiveTime');
             $this->medicationeffective->addChild('low')->addAttribute('value', '20190220152842'); 
             
             $this->medicationsubstance->addChild('routeCode')->addAttribute('displayName', $value);
             $this->dose =  $this->medicationsubstance->addChild('doseQuantity');
             $this->dose->addAttribute('unit', $unit[$key]);
             $this->dose->addAttribute('value', $dose[$key]);

             $this->consumable = $this->medicationsubstance->addChild('consumable');
             $this->consumable->addAttribute('typeCode', 'CSM');

             $this->manufacture = $this->consumable->addChild('manufacturedProduct');
 			 $this->manufacture->addAttribute('classCode', 'MANU'); 
 			 $this->manufacture->addChild('templateId')->addAttribute('root', '2.16.840.1.113883.10.20.22.4.23');

             $this->manufacturemate =  $this->manufacture->addChild('manufacturedMaterial');
             $this->manufacturemate->addAttribute('classCode', 'MMAT');

             $this->medicode = $this->manufacturemate->addChild('code');
			 $this->medicode->addAttribute('displayName',$value);

			 $this->mediorg = $this->medicode->addChild('originalText');
			 $this->mediorg->addAttribute('mediaType', 'text/x-hl7-text+xml');

			 $this->mediorg->addChild('reference')->addAttribute('value', '#medication'.$key);


    	}

    	return  $this->structure;

    }

    public function createccdavitalsign($vitals)
    {

    	$vitalspram = ['Body height', 'Body weight', 'Body temperature', 'Pulse rate', 'Blood oxygen saturation', 'Systolic blood pressure'];

    	$snomed = ['50373000'];

    	$vitals_value=['165'];



    	$this->vitals           = $vitals;
    	$this->vitalscomponent  = $this->vitals->addChild('component');
		$this->vitalscomponent->addAttribute('typeCode', 'COMP');
		$this->vitalscomponent->addAttribute('contextConductionInd', 'true');

		$this->vitalssection = $this->vitalscomponent->addChild('section');
		$this->vitalssection->addAttribute('classCode', 'DOCSECT');
		$this->vitalssection->addAttribute('moodCode', 'EVN');

		$this->vitalssection->addChild('templateId')->addAttribute('root', '2.16.840.1.113883.10.20.22.2.4');

		$this->vitalcode = $this->vitalssection->addChild('code');
		$this->vitalcode->addAttribute('code', '46680005');
		$this->vitalcode->addAttribute('codeSystem', '2.16.840.1.113883.6.96');
		$this->vitalcode->addAttribute('codeSystemName', 'SNOMED CT');
		$this->vitalcode->addAttribute('displayName', 'VITAL SIGNS');

		$this->vitalstitle = $this->vitalssection->addChild('title', 'VITAL SIGNS');
		$this->vitalstitle->addAttribute('mediaType', 'text/plain');
		$this->vitalstitle->addAttribute('representation', 'TXT');

		$this->vitalentry = $this->vitalssection->addChild('entry');
		$this->vitalentry->addAttribute('typeCode','DRIV');
		$this->vitalentry->addAttribute('contextConductionInd', 'true');

		$this->organizer = $this->vitalssection->addChild('organizer');
		$this->organizer->addAttribute('classCode', 'CLUSTER');
		$this->organizer->addAttribute('moodCode', 'EVN');

		$this->vitaltemplateid = $this->organizer->addChild('templateId');
		$this->vitaltemplateid->addAttribute('root', '2.16.840.1.113883.10.20.22.4.1');
        $this->organizer->addChild('id')->addAttribute('root', '00000000-0000-0000-0000-000000000000');

        $this->vitalscode2 = $this->organizer->addChild('code');
        $this->vitalscode2->addAttribute('code', '46680005');
        $this->vitalscode2->addAttribute('codeSystem', '2.16.840.1.113883.6.96');
        $this->vitalscode2->addAttribute('codeSystemName', 'SNOMED CT');
        $this->vitalscode2->addAttribute('displayName', 'Vital signs');
        $this->organizer->addChild('statusCode')->addAttribute('code', 'completed');



        $this->vitalcomponentcontext = $this->organizer->addChild('component');
        $this->vitalcomponentcontext->addAttribute('contextConductionInd', 'true');

        $this->vitalobservation  = $this->vitalcomponentcontext->addChild('observation');
		$this->vitalobservation->addAttribute('classCode', 'OBS');
		$this->vitalobservation->addAttribute('moodCode', 'EVN');

		$this->vitaltemplateid = $this->vitalobservation->addChild('templateId');
		$this->vitaltemplateid->addAttribute('root', '2.16.840.1.113883.10.20.22.4.2');



    }

       

}






