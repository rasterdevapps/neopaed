<?php

namespace App\Http\Controllers\Import;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewbornImportController extends Controller
{
   private function newbornImports() 
	{
		     //new born data 

       $newborn = Excel::load(public_path().'/im/newbornexamination.xls', function ($reader) {
			         
			         $newborn = $reader->skipRows(1)->takeRows(4000)->get();
		   
	    	      })->all();


		    foreach ($newborn as $newbornkey => $newbornvalue) {


		      	$baby = Baby::where(['BMrNo'=>$newbornvalue['mr_no.'], 'IsDeleted'=>0])->first();


                if (count($baby) > 0) {

			      	$data['BabyId']          	    = 	$baby->BabyId;
					$data['MotherId'] 	            = 	$baby->MotherId;
					$data['NbTestDate']      	    = 	$newbornvalue['date'];
					$data['NbTestTime']       	    = 	$newbornvalue['time'];
					$data['AbdomenShape']    	    = 	$newbornvalue['abdomen_shape'];
					$data['AddedSounds']     	    = 	$newbornvalue['added_sounds'];
					$data['AgeOfExamination'] 	    = 	$newbornvalue['age_of_examination'];
					$data['AirEntry'] 	            = 	$newbornvalue['air_entry'];
					$data['AnteriorFontanelle'] 	= 	$newbornvalue['anterior_fontanelle'];
					$data['Anus'] 	                = 	$newbornvalue['anus'];
					$data['AnyOtherAbnormality']    = 	$newbornvalue['any_other_abnormality'];
					$data['other_pa_findings'] 	    = 	'';
					$data['ApicalImpulse'] 		    = 	$newbornvalue['apical_impulse'];
					$data['BoundingPulses'] 	    = 	$newbornvalue['bounding_pulses'];
					$data['BreathSounds'] 		    = 	$newbornvalue['breath_sounds'];
					$data['CentralPulses'] 		    = 	$newbornvalue['central_pulses'];
					$data['NbCFT'] 	                = 	$newbornvalue['cft'];
					$data['CharacterOfAddedSounds'] = 	$newbornvalue['temperature_f'];
					$data['CharacterofMurmur']   	= 	$newbornvalue['character_of_murmur'];
					$data['NbChestMovement']     	= 	$newbornvalue['chest_movement'];
					$data['Colour'] 	            = 	$newbornvalue['colour'];
					$data['Cry'] 	                = 	$newbornvalue['cry'];
					$data['SeenBy'] 	            = 	'';
					$data['Diagnosis'] 	            = 	$newbornvalue['diagnosis'];
					$data['Ears']                	= 	$newbornvalue['ears'];
					$data['Esophagus']            	= 	$newbornvalue['esophagus'];
					$data['Eyes']                 	= 	$newbornvalue['eyes'];
					$data['FemoralPulses']        	= 	$newbornvalue['femoral_pulses'];
					$data['Flanks']               	= 	$newbornvalue['flanks'];
					$data['GeneralBodyMovements'] 	= 	$newbornvalue['general_body_movements'];
					$data['Genitalia']            	= 	$newbornvalue['genitalia'];
					$data['Hairs']                  = 	$newbornvalue['hairs'];
					$data['Hepatomegaly']         	= 	$newbornvalue['hepatomegaly'];
					$data['HernialOrifices']     	= 	$newbornvalue['hernial_orifices'];
					$data['Hips']                	= 	$newbornvalue['hips'];
					$data['NbHR']                	= 	$newbornvalue['hr_in_bpm'];
					$data['Jaundice']             	= 	$newbornvalue['jaundice'];
					$data['LevelOfConsciousness'] 	= 	$newbornvalue['level_of_consciousness'];
					$data['Lips'] 	                = 	$newbornvalue['lips'];
					$data['LiverSpan'] 	            = 	$newbornvalue['liver_span'];
					$data['LtLL'] 	                = 	$newbornvalue['lt_ll'];
					$data['LtUL'] 	                = 	$newbornvalue['lt_ul'];
					$data['Murmur'] 	            = 	$newbornvalue['murmur'];
					$data['Neck'] 	                = 	$newbornvalue['neck'];
					$data['NeonatalReflexes'] 	    = 	$newbornvalue['neonatal_reflexes'];
					$data['Nipples'] 	            = 	$newbornvalue['nipples'];
					$data['Nose'] 	                = 	$newbornvalue['nose'];
					$data['Nostrils'] 	            = 	$newbornvalue['nostrils'];
					$data['Palate'] 	            = 	$newbornvalue['palate'];
					$data['Pallor'] 	            = 	$newbornvalue['pallor'];
					$data['PeripheralPulses'] 	    = 	$newbornvalue['peripheral_pulses'];
					$data['PrecordialActivity'] 	= 	$newbornvalue['precordial_activity'];
					$data['NbRR'] 	                = 	'';
					$data['RtLL'] 	                = 	$newbornvalue['rt_ll'];
					$data['RtUL'] 	                = 	$newbornvalue['rt_ul'];
					$data['S1S2'] 	                = 	$newbornvalue['s1s2'];
					$data['Scalp'] 	                = 	$newbornvalue['scalp'];
					$data['Seizures']             	= 	$newbornvalue['seizures'];
					$data['SiteofAddedSounds']    	= 	$newbornvalue['site_of_added_sounds'];
					$data['SiteofMurmur']        	= 	$newbornvalue['site_of_murmur'];
					$data['Skin'] 	                = 	$newbornvalue['skin'];
					$data['Spine'] 	                = 	$newbornvalue['spine'];
					$data['NbSpO2'] 	            = 	$newbornvalue['spo2'];
					$data['SpontaneousActivity'] 	= 	$newbornvalue['spontaneous_activity'];
					$data['TemperatureF'] 	        = 	number_format($newbornvalue['temperature_f'], 1);
					$data['NbTone'] 	            = 	$newbornvalue['tone'];
					$data['TypeofSeizure'] 	        = 	$newbornvalue['type_of_seizure'];
					$data['UmbilicalCord'] 	        = 	$newbornvalue['umbilical_cord'];
					$data['Umbilicus'] 	            = 	$newbornvalue['umbilicus'];
					$data['SpleenSpan']             =   $newbornvalue['spleen_span'];
					$data['Splenomegaly']           =   $newbornvalue['splenomegaly'];
					$data['UserAdded'] 	            = 	0;
					$data['DateAdded'] 	            = 	$newbornvalue['date'];
					$data['DateModified'] 	        = 	$newbornvalue['date'];
					$data['other_cvs_findings'] 	= 	'';
					$data['other_rs_findings'] 	    = 	'';
					$data['other_cns_findings'] 	= 	'';

					Newborn::create($data);

					unset($data);

                }


		    }
	}

}
