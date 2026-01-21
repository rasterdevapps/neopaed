<?php
namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Reports\AnnualReportsDateController;


interface AnnualReportsSupport
{

	/***
    *  store the color for charts 
    *
    * @var  
    *
	*/

   const CHART_TYPE    = [1=>'Single Columns Chart',2=>'Double Columns Chart'];

   const CHART_COLOR   = ["#FF0F00" ,"#FF6600","#FF9E01","#FCD202","#F8FF01", "#B0DE09","#04D215", "#0D8ECF","#0D52D1","#2A0CD0", "#8A0CCF","#CD0D74"];
 
   const SEXDP         = [["title"=>"Male","value"=>"Male"],["title"=>"Female","value"=>"Female"],["title"=>"Indeterminate","value"=>"Indeterminate"]];
   
   const CONCEPTION    = [['title'=>'Spontaneous','value'=>'spontaneous'],['title'=>'Medical ART','value'=>'medicalArt'],['title'=>'ART','value'=>'art'],['title'=>'IVF','value'=>'IVF'],['title'=>'ICSI','value'=>'ICSI']];

   const DELIVERYMODE  = [['title'=>'Vaginal','value'=>'Vaginal'],['title'=>'Instrumental','value'=>'Instrumental'],['title'=>'Caesarian Section','value'=>'Caesarian_section']];

   const GESTATION     = [['title'=>'< 28','value'=>'greater28'],['title'=>'28 – 30','value'=>'28–30'],['title'=>'31 - 32','value'=>'31-32'],['title'=>'33 - 36','value'=>'33-36'],['title'=>'37 - 38','value'=>'37-38'],['title'=>'39 - 40','value'=>'39-40'],['title'=>'41 - 42','value'=>'41-42'],['title'=>'> 42','value'=>'less42']]; 
   
   const BIRTHWEIGHT   = [['title'=>'< 1000','value'=>'0000-1000'],['title'=>'1001 - 1500','value'=>'1000-1499'],['title'=>'1501 - 2000','value'=>'1500-1999'],['title'=>'2001 - 2500','value'=>'2000-2499'],['title'=>'2501 - 3000','value'=>'2500-2999'],['title'=>'3001 - 3500','value'=>'3000-3499'],['title'=>'3501 - 4000','value'=>'3500-3999'],['title'=>'> 4001','value'=>'4000-9999']]; 

   const NICUADMISSION = [["title"=>"Intensive Care","value"=>"intensive_care"],["title"=>"Special Care","value"=>"special_care"],["title"=>"high dependancy care","value"=>"high_dependancy_care"]];

   const NICUADMISSION_BIRTHSTATUS = [["title"=>"Inborn","value"=>"Inborn"],["title"=>"Outborn","value"=>"Outborn"]];

   const PATIENTS_DAYS = [["title"=>"Patients Days","value"=>"patient_days"]];

   const CHRONIC       = [["title"=>"O2 requirement at day 28","value"=>"o2_requirement_day_28"],["title"=>"O2 requirement at 36 wks corrected age","value"=>"o2_requirement_week_36"],["title"=>"Home oxygen therapy","value"=>"homeOxygen"]];

   const RESPIRATORY_THERAPY = [["title"=>"Surfactant","value"=>"surfactant"],["title"=>"Invasive ventilation ( days )","value"=>"Invasive_ventilation_days"],["title"=>"CPAP ( days )","value"=>"CPAP"],["title"=>"NIPPV ( days )","value"=>"NIPPV"],["title"=>"HHHFNC ( days )","value"=>"HHHFNC"],["title"=>"Nasal prongs O2 ( days )","value"=>"nasal_prongs"],["title"=>"Head Box O2 ( days )","value"=>"head_box"]];
   
   const MPTYPES            =[['title'=>'singletone','value'=>'singleTone'],['title'=>'Twins','value'=>'Twins'],['title'=>'Triplets','value'=>'TripLets'],['title'=>'Quadruplets','value'=>'QuadrupLets'],['title'=>'Quintuplets','value'=>'QuintupLets'],['title'=>'Sextuplets','value'=>'SextupLets'],['title'=>'Septuplets','value'=>'SeptupLets'],['title'=>'Octuplets','value'=>'OctupLets']];

} 
