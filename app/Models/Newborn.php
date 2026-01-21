<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Newborn extends Model 
{

	protected $table = 'newborn_examination';
	protected $primaryKey = 'BabyId';
	public $timestamps  =  false;
	
	protected $fillable = ['BabyId','MotherId','NbTestDate','NbTestTime','AbdomenShape','AddedSounds','AgeOfExamination',
	                       'AirEntry','AnteriorFontanelle','Anus','AnyOtherAbnormality','other_pa_findings',
	                       'ApicalImpulse','BoundingPulses','BreathSounds','CentralPulses','NbCFT',
	                       'CharacterOfAddedSounds','CharacterofMurmur','NbChestMovement','Colour','Cry','SeenBy',
	                       'Diagnosis','Ears','Esophagus','Eyes','FemoralPulses','Flanks','GeneralBodyMovements',
	                       'Genitalia','Hairs','Hepatomegaly','HernialOrifices','Hips','NbHR','Jaundice',
	                       'LevelOfConsciousness','Lips','LiverSpan','LtLL','LtUL','Murmur','Neck','NeonatalReflexes',
	                       'Nipples','Nose','Nostrils','Palate','Pallor','PeripheralPulses','PrecordialActivity','NbRR',
	                       'RtLL','RtUL','S1S2','Scalp','Seizures','SiteofAddedSounds','SiteofMurmur','Skin','Spine',
	                       'SpleenSpan','Splenomegaly','NbSpO2','SpontaneousActivity','TemperatureF','NbTone',
	                       'TypeofSeizure','UmbilicalCord','Umbilicus','UserAdded','DateAdded','DateModified',
	                       'other_cvs_findings','other_rs_findings','other_cns_findings', 'UserModified'];

}
