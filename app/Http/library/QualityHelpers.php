<?php

namespace App\Http\Library;
/**
 * This Class for responsible for handling  
 * support fuction for formate and organize the data 
 * @author Manikandan M at raster
 */
class QualityHelpers
{

	
	/**
	 * This Method to sepsis type for mother 
	 *
	 * @param $id type integer  
	 * @return type  string or array 
	 */
	public static function GetSepsisMotherType($id = '')
	{
		$sepsis_type = array( '1'=>'Chorioamnionitis',
							  '2'=>'Unclean_vaginal_examination/ > 3 PV examination',
							  '3'=>'Leaking PV > 18hours / pPROM',
							  '4'=>'GBS in maternal recto-vaginal swab',
							  '5'=>'UTI in mother',
							  '6'=>'Maternal fever',
		                     );
		return !empty($id) ? $sepsis_type[$id] : $sepsis_type;
	}

	/**
	 * This Method to surfactant type 
	 *
	 * @param $id type integer  
	 * @return type  string or array 
	 */
	public static function GetSurfactantType($id = '')
	{
		$surfactant_type = array( '1'=>'Survanta',
							      '2'=>'Curosurf',
							      '3'=>'neosurf');

		return !empty($id) ? $surfactant_type[$id] : $surfactant_type;
	}

	/**
	 * This Method to sepsis type for baby 
	 *
	 * @param $id type integer  
	 * @return type  string or array 
	 */
	public static function GetSepsisType($id = '')
	{
		$sepsis_type = array( '1'=>'Fluid responsive',
							  '2'=>'Fluid resistant,catecholamine responsive',
							  '3'=>'Catecholamine resistant');

		return !empty($id) ? $sepsis_type[$id] : $sepsis_type;
	}

	/**
	 * This method to case of death 
	 *
	 * @param $id type integer  
	 * @return type  string or array 
	 */
	public static function GetCaseofDeath($id = '')
	{
		$case_death  = array( '1'=>'Extreme prematurity',
							  '2'=>'Respiratory failure',
							  '3'=>'Sepsis',
							  '4'=>'Perinatal asphyxia',
							  '5'=>'IVH',
							  '6'=>'NEC',
		                     );
		return !empty($id) ? $case_death[$id] : $case_death;
	}

	/**
	 * This method to  Central Line Type
	 *
	 * @param $id type integer  
	 * @return type  string or array 
	 */
	public static function GetCentralLine($id = '')
	{
		$case_death  = array( '1'=>'UVC',
							  '2'=>'UAC',
							  '3'=>'PICC',
							  '4'=>'Central line',
		                     );
		return !empty($id) ? $case_death[$id] : $case_death;
	}

	/**
	 * This method to maternal cause
	 *
	 * @param $id type integer  
	 * @return type  string or array 
	 */
	public static function GetMaternalCause($id = '')
	{
		$maternal_cause  = array( '1'=>'Pregnancy-induced hypertension',
								  '2'=>'pPROM',
								  '3'=>'Maternal infection',
								  '4'=>'Hypothyroidism',
								  '5'=>'Gestational Diabetes / Type I , II Diabetes',
								  '6'=>'Autoimmune disorder',
								  '7'=>'Previous preterm birth',
								  '8'=>'Chronic systemic illness',
								  '9'=>'Other');
		return !empty($id) ? $maternal_cause[$id] : $maternal_cause;
	}

	/**
	 * This method to fetal cause
	 *
	 * @param $id type integer  
	 * @return type  string or array 
	 */
	public static function GetFetalCause($id = '')
	{
		$fetal_cause  = array( '1'=>'Multiple Pregnancy',
							   '2'=>'Fetal Distress',
							   '3'=>'guGR/Placetal insufficiency',
							   '4'=>'Congenital malformations',
							   '5'=>'Hydrops fetalis',
							   '6'=>'Other');
		return !empty($id) ? $fetal_cause[$id] : $fetal_cause;
	}

	/**
	 * This indication for admission
	 *
	 * @param $id type integer  
	 * @return type  string or array 
	 */
	public static function GetAdmissionIndication($id = '')
	{
		$admission_indication  = array( '1'=>'Prematurity',
									    '2'=>'Low birth weight',
									    '3'=>'RD',
									    '4'=>'Birth asphyxia',
									    '5'=>'Sepsis',
									    '6'=>'Shock',
									    '7'=>'Jaundice');
		return !empty($id) ? $admission_indication[$id] : $admission_indication;
	}

	/**
	 * This indication for admission
	 *
	 * @param $id type integer  
	 * @return type  string or array 
	 */
	public static function GetUserBasedMail($email, $password)
    {

         $status = \DB::table('users')
                  ->join('user_group_map', 'user_group_map.user_id', '=', 'users.id')
                  ->join('user_group', 'user_group.group_id', '=', 'user_group_map.group_id')
                  ->where('users.email', trim($email))
                  ->first();

        return count($status) > 0 ? $status->status : false;         


    }

    /**
	 * This get max grade
	 *
	 * @param $id type integer  
	 */
    public static function GetMaxgrade($id = '')
    {
    	 $max_grade = array( '' => 'N/A',
    	 	                 '1'=>'Grade 1',
    	 					 '2'=>'Grade 2',
    	 					 '3'=>'Grade 3',
    	 					 '4'=>'Grade 4');
		return !empty($id) ? $max_grade[$id] : $max_grade;

    }

    /**
	 * This get max grade
	 *
	 * @param $id type integer  
	 */
    public static function GetMaxStage($id = '')
    {
    	 $max_stage = array( '' => 'N/A',
    	 	                 '1'=>'NEC 1',
    	 					 '2'=>'NEC 2',
    	 					 '3'=>'NEC 3');
		return !empty($id) ? $max_stage[$id] : $max_stage;

    }

      /**
  	* Method to check status
  	*/
  	public static function getUsageStatus($group_id) 
  	{
    	$results = \DB::table('demo_details')
                   ->where('group_id','=',$group_id)
                   ->get();
                  
    	return count($results); 
  	}

  	 /**
	  * Converting the gestation from json to string.
	  *
	  * @param $gestation json 
	  *
	  * @return string   
	  */
	public static function decodeGestation($gestation = '') 
	  {

	    $results = '';

	      if (!empty($gestation) && count(json_decode($gestation)) > 0) {
	          $temp_g = json_decode($gestation);
	          $temp_g = is_array($temp_g) ? $temp_g : (array)$temp_g; 
	          $keys = array_keys($temp_g);
	          $results = (!empty($temp_g[$keys[1]])) ? $temp_g[$keys[0]].'+'.$temp_g[$keys[1]] : $temp_g[$keys[0]] ;
	              
	      }
	     return  $results ;     

	 }


	 /**
	  * Converting the riskfactors from json to string.
	  *
	  * @param $riskfactors json 
	  *
	  * @return string   
	  */
	public static function decodeRiskfactors($riskfactors = '') 
    {
        $temp_risk = json_decode($riskfactors);
        $risks = array();
        foreach ($temp_risk as  $value) {
            if (!empty($value)) {

              $risks[] = self::GetSepsisMotherType($value);

         	}
        }

        return count($risks) > 0 ? implode(', ', $risks) : '';
	}

	/**
	 * Converting the indication for admission from json to string.
	 *
	 * @param $indication json 
	 *
	 * @return string   
	 */
	public static function decodeIndication($indication = '') 
    {
        $temp_indication = json_decode($indication);
        $indication = array();

        if (count($temp_indication) > 0) {
	        foreach ($temp_indication as  $value) {
	            if (!empty($value)) {

	              $indication[] = self::GetAdmissionIndication($value);

	         	}
	        }

	        return count($indication) > 0 ? implode(', ', $indication) : '';
	    } else {
	    	return '';
	    }   
	}

	/**
	 * Converting the surfactant type  from json to string.
	 *
	 * @param $surfactant json 
	 *
	 * @return string   
	 */
	public static function decodeSurfactant($surfactant = '') 
    {
        $temp_surfactant = json_decode($surfactant);
        $surfactant = array();

        if (count($temp_surfactant) > 0) {
	        foreach ($temp_surfactant as  $value) {
	            if (!empty($value)) {

	              $surfactant[] = self::GetSurfactantType($value);

	         	}
	        }

	        return count($surfactant) > 0 ? implode(', ', $surfactant) : '';
	    } else {
	    	return '';
	    }   
	}

	/**
	 * Converting the surfactant type  from json to string.
	 *
	 * @param $surfactant json 
	 *
	 * @return string   
	 */
	public static function decodeDeathCase($death = '') 
    {
        $temp_death = json_decode($death);
        $death = array();

        if (count($temp_death) > 0) {
	        foreach ($temp_death as  $value) {
	            if (!empty($value)) {

	              $death[] = self::GetCaseofDeath($value);

	         	}
	        }

	        return count($death) > 0 ? implode(', ', $death) : '';
	    } else {
	    	return '';
	    }   
	}


}
