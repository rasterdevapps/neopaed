/*
    This script will load at the time of day care sheet only 


    */



    function Typeofbloodgas() {
     var list=['Ph','PaO2','PaCo2','HCO3','BE'];
     if($("#TypeOfBloodGas").val()=='Not done' || $("#TypeOfBloodGas").val()=='Not indicated' || $("#TypeOfBloodGas").val()==''){
      makeDisable(list) ;
      $('label[for="LastBG"]').parent().parent().slideUp();

    }else{
      removeDisable(list);
      $('label[for="LastBG"]').parent().parent().slideDown();

    }
  }

  function Ettube() {
    var list=['Size','Lips'];
    ($('#EtTube').val()=='No' || $('#EtTube').val()=='')? makeDisable(list) : removeDisable(list);

  }

  function AddedSounds() {
    var list=['DayCharacter'];
    ($('#AddedSounds').val()=='Present') ? removeDisable(list) : makeDisable(list);

  }

  function Murmur() {
   var list=['CharacterOfMurmur'];
   ($('#Murmur').val()=='Absent' || $('#Murmur').val()=='')? makeDisable(list) : removeDisable(list);

 }

 function Inotropes() {
   var list=['Dopamine','Dobutamine','Adrenaline','Noradrenaline','Milrinone'];

   ($('#Inotropes').val()=='No' || $('#Inotropes').val()=='')? makeDisable(list) : removeDisable(list);
 }


 function Hepatomegaly() {
   var list=['LiverSpan'];
   ($('#Hepatomegaly').val()=='No' || $('#Hepatomegaly').val()=='')? makeDisable(list) : removeDisable(list);

 }

 function Splenomegaly() {
   var list=['SpleenSpan'];
   ($('#Splenomegaly').val()=='No' || $('#Splenomegaly').val()=='')? makeDisable(list) : removeDisable(list);

 }

 function Seizures() {
   var list=['TypeOfSeizures'];
   ($('#Seizures').val()=='No' || $('#Seizures').val()=='')? makeDisable(list) : removeDisable(list);

 }

 function PeripheralCannula() {
   var list=['PvcComplication','pvc_number'];
   ($('#PeripheralCannula').val()=='No' || $('#PeripheralCannula').val()=='')? makeDisable(list) : removeDisable(list);

 }

 function Picc() {
   var list=['PiccSite','PiccDay','PiccComplication'];
   ($('#Picc').val()=='No' || $('#Picc').val()=='')? makeDisable(list) : removeDisable(list);
 }
 function daycare_uvc() {
   var list=['UvcPosition','UvcDay','UvcComplication'];
   ($('#Uvc').val()=='No' || $('#Uvc').val()=='')? makeDisable(list) : removeDisable(list);
 }

 function daycare_uac() {
   var list=['UacPosition','UacDay','UacComplication'];
   ($('#Uac').val()=='No' || $('#Uac').val()=='')? makeDisable(list) : removeDisable(list);
 }
 function daycare_pac() {
   var list=['PacSite','PacDay','PacComplication'];
   ($('#Pac').val()=='No' || $('#Pac').val()=='')? makeDisable(list) : removeDisable(list);
 }



 function daycareOI() {
   var list=['OI'];
   var map   = $('#MAP').val();
   var fio2_set  = $('#fio2_set').val();
   var fio2_delivered  = $('#fio2_delivered').val();
   var PaO2  = $('#PaO2').val();

   (map != '' && map != 0 && fio2_set != '' && fio2_set != 0 && PaO2 != '' && PaO2 != 0) ? removeDisable(list) : makeDisable(list);
 }
 function daycareAaDO2() {

   var list=['AaDO2'];

   ($('#PaO2').val()!= '' && $('#PaCo2').val()!= '') ? removeDisable(list) : makeDisable(list);

 }

 function calculateAaDO2() {

  var Pao2  = $('#PaO2').val();
  var paCo2 = $('#PaCo2').val();
  var fio2_set  = $('#fio2_set').val();
  var fio2_delivered  = $('#fio2_delivered').val();
  if(Pao2 != '' && paCo2 != '' && fio2_set != ''){
    var AaDO2 = (((713*fio2_set)/100) - paCo2) - Pao2;
    $('#AaDO2').val(AaDO2);
  }  

}

function calculateOI(){
 var Rate  = $('#Rate').val();
 var IT    = $('#IT').val();
 var PEEP  = $('#PEEP').val();
 var fio2_set  = $('#fio2_set').val();
 var fio2_delivered  = $('#fio2_delivered').val();
 var pip_set   = $('#pip_set').val();
 var pip_delivered   = $('#pip_delivered').val();
 var PaO2  = $('#PaO2').val();

 var OI = (((Rate*IT*pip_set*fio2_set) / 60)-((Rate*IT*PEEP*fio2_set) / 60 ) + (PEEP*fio2_set))/PaO2;

 $('#OI').val(OI);


}

function NEC() {
  var list=['NECtreatment'];

  ($("#NEC").val() == 'No' || $("#NEC").val() == '') ? makeDisable(list): removeDisable(list);
}

function InvasiveVentilation() {
  var list=['ModeOfVentilation'];
  ($('#InvasiveVentilation').val()=='No' || $('#InvasiveVentilation').val()=='')? makeDisable(list) : removeDisable(list);
  var list=['Cry'];
  ($('#InvasiveVentilation').val()=='Yes') ? makeDisable(list) : removeDisable(list);
  var list=['Ventilation_choose'];
  ($('#InvasiveVentilation').val()=='No') ? removeDisable(list):makeDisable(list); 
  if($('#InvasiveVentilation').val()=='Yes'){
    var option_values='<option selected="selected" value="">N/A</option>';
    option_values+='<option value="NonInvasiveVentilation">NonInvasive Ventilation</option>';
    option_values+='<option value="OtherRespiratorySupport">OtherRespiratory Support</option>';
    option_values+='<option value="Spontaneouslyventilating">Spontaneously  ventilating</option>';  
    $('#Ventilation_choose').html(option_values);
    $('#ModeOfVentilation').select2("val", "");
  } else if($('#InvasiveVentilation').val()=='No'){    
    $('#Ventilation_choose').select2("val", "");
  }
  Ventilation_choose();
}

$('#ModeOfVentilation').change(function() {
  var type = ['pip_set','pip_delivered', 'PEEP', 'fio2_set', 'fio2_delivered', 'Rate', 'MAP', 'frequency_rep', 'IT', 'amplitude', 'i_e_ratio'];
    makeDisable(type);
  if ($('#InvasiveVentilation').val() == 'Yes') {
  var type1 = ['pip_set','pip_delivered', 'PEEP', 'fio2_set', 'fio2_delivered', 'Rate'];
  var type2 = ['MAP', 'frequency_rep', 'IT', 'amplitude', 'i_e_ratio'];
  if ($(this).val() != 'HFO') {
    type2.push('IT');
    makeDisable(type2);
    removeDisable(type1);
  } else {
    type1.push('IT');
    makeDisable(type1);
    removeDisable(type2);
  }
    makeDisable(['Flow']);
  }
});

function Ventilation_choose() {
	var list=['NonInvasiveVentilation','Spontaneouslyventilating','OtherRespiratorySupport'];
	makeDisable(list);
  var ventilation_value=[$('#Ventilation_choose').val()];
  if($('#Ventilation_choose').val()!=''){
   removeDisable(ventilation_value);
 }
 makeallShow();

 if($('#Ventilation_choose').val() =='OtherRespiratorySupport'){
   otherRespiratory();
 }else if($('#Ventilation_choose').val() =='Spontaneouslyventilating'){
  Spontaneouslyventilating();
}else if($('#Ventilation_choose').val() =='NonInvasiveVentilation'){
  NoninvasiveVentilationoptions()
}

}

function makeallShow() {
  var list=['pip_set','pip_delivered','PEEP','MAP','Rate','frequency_rep','IT','fio2_set', 'fio2_delivered','Flow','DayOfVentilation','Indication'];
  removeDisable(list);
}


function otherRespiratory() {
	var list=['pip_set','pip_delivered','PEEP','MAP','Rate','frequency_rep','IT','i_e_ratio'];
  ($("#InvasiveVentilation").val() == 'No' && $("#Ventilation_choose").val() == 'OtherRespiratorySupport' ) ? makeDisable(list): removeDisable(list);
}

function Spontaneouslyventilating() {
  var list=['pip_set','pip_delivered','PEEP','MAP','Rate','frequency_rep','IT','fio2_set', 'fio2_delivered','Flow','DayOfVentilation','Indication','i_e_ratio'];
	var list1=['amplitude'];
 ($("#InvasiveVentilation").val() == 'No' && $("#Ventilation_choose").val() == 'Spontaneouslyventilating' && $("#Spontaneouslyventilating").val() =='Yes') ? makeDisable(list): removeDisable(list);
  makeDisable(list1);
}

function NoninvasiveVentilationoptions() {
  var mainList = ['pip_set','pip_delivered','MAP','Rate','frequency_rep','IT','PEEP','Flow','amplitude','i_e_ratio','fio2_set', 'fio2_delivered'];
  var list     = ['pip_set','pip_delivered','MAP','Rate','frequency_rep','IT','amplitude','i_e_ratio','fio2_set', 'fio2_delivered'];
  var list1    = ['pip_set','pip_delivered','MAP','Rate','frequency_rep','IT','PEEP','amplitude','i_e_ratio','fio2_set', 'fio2_delivered'];
  var list2    = ['frequency_rep','Flow', 'amplitude','i_e_ratio','fio2_set', 'fio2_delivered'];
  var list3    = ['pip_set','pip_delivered','Rate','IT','PEEP','Flow'];

  if($("#InvasiveVentilation").val() == 'No' && $("#Ventilation_choose").val() != 'NonInvasiveVentilation' && $('#NonInvasiveVentilation').val() == ' ') {
    $('#NonInvasiveVentilation').val(' ');
    removeDisable(mainList);
  } else if($("#InvasiveVentilation").val() == 'No' && $("#Ventilation_choose").val() == 'NonInvasiveVentilation' && $('#NonInvasiveVentilation').val() == 'HHHFNC') {
    removeDisable(mainList);
    makeDisable(list1);
  } else if($("#InvasiveVentilation").val() == 'No' && $("#Ventilation_choose").val() == 'NonInvasiveVentilation' && $('#NonInvasiveVentilation').val() == 'NIMV/NIPPV') {
    removeDisable(mainList);
    makeDisable(list2);
  } else if($("#InvasiveVentilation").val() == 'No' && $("#Ventilation_choose").val() == 'NonInvasiveVentilation' && $('#NonInvasiveVentilation').val() == 'CPAP') {
   removeDisable(mainList);
   makeDisable(list);
  } else if($("#InvasiveVentilation").val() == 'No' && $("#Ventilation_choose").val() == 'NonInvasiveVentilation' && $('#NonInvasiveVentilation').val() == 'nHFOV') {
   removeDisable(mainList);
   makeDisable(list3);
 }  
}

function typeOffeeds() {
	var list=['Feeds','Volume','TypeofFeeds'];
	(($('#directlybreastfeed').prop('checked')==true && $('#othertypefeed').prop('checked')==false) || $('#othertypefeed').prop('checked')==false) ? makeDisable(list):removeDisable(list); 
}

function tpnChanges() {
	var list=['Carbohydrates','Protein','Fat','total_energy'];
	($('#Tpn').val()=='No' || $('#Tpn').val()=='') ? makeDisable(list) : removeDisable(list);
}

function calculateFeeds() {

 var volume    = $('#Volume').val();
 var frequency = $('#Frequency').val();
 var workingweight = $('#workingWeight').val();
 var feeds = ((24/parseFloat(frequency))*parseFloat(volume))/(parseFloat(workingweight)/1000);
 if(!isNaN(feeds) && frequency !=0 && frequency !=5) {
  $('#Feeds').val(feeds.toFixed(1));
  totalfluides();
} else {
 $('#Feeds').val('0.00');
}  
}

function calulateFludes() {

  var iv_fluids    = $('#iv_fluids_ml_day').val();
  if (iv_fluids == null || iv_fluids == '') {
    iv_fluids = 0;
  }
 	 var drug_infusions = $('#drug_infusions_ml_day').val();
   if (drug_infusions == null || drug_infusions == '') {
      drug_infusions = 0;
   }

 	var other_drugs = $('#other_drugs').val();
  if (other_drugs == null || other_drugs == '') {
      other_drugs = 0;
      $('#other_drugs').val(other_drugs);
   }
   var workingweight = $('#workingWeight').val();
   var ivf = (parseInt(iv_fluids) + parseInt(drug_infusions) + parseInt(other_drugs)) / (parseInt(workingweight)/1000);
   if(!isNaN(ivf)) {
     $('#ivf').val(ivf.toFixed(2));
     totalfluides();
   } 

 }

 function ivFluidshourToday() {
   var ivFluids = $('#iv_fluids').val();
   if(ivFluids!='') {
     var resultFluid=parseFloat(ivFluids)*24;
     if(!isNaN(resultFluid)) {
       $('#iv_fluids_ml_day').val(parseInt(resultFluid));
     } else {
       $('#iv_fluids_ml_day').val('0.00');
     }  
   }
 }

 function drugInfutionhourToday() {
   var drugInfusions = $('#drug_infusions').val();
   if(drugInfusions != ''){
     var resultDruginfusions = parseFloat(drugInfusions)*24;
     if(!isNaN(resultDruginfusions)) {
       $('#drug_infusions_ml_day').val(resultDruginfusions.toFixed(2));
     } else {
      $('#drug_infusions_ml_day').val('0.00');
    }  	
  }
}

function calculateUrineoutput(flages) {
	var urine_hour = $('#UO').val();
	var urine_day = $('#urine_output_day').val();
	var workingWeight = $('#workingWeight').val();

  if(flages) {
    urine_hour = (parseInt(urine_day)/24)/(workingWeight/1000);
    if (urine_hour != 'Infinity' && $.isNumeric(urine_hour)) {
      $('#UO').val(urine_hour.toFixed(2));
    } else {
      $('#UO').val('');
    }
  }


}

function totalfluides() {
 var iv_fluids      = $('#iv_fluids_ml_day').val();
      iv_fluids = parseInt(iv_fluids) ? parseInt(iv_fluids) : 0;
 // var drug_infusions = $('#drug_infusions_ml_day').val();
 var other_drugs    = $('#other_drugs').val();
      other_drugs = parseInt(other_drugs) ? parseInt(other_drugs) : 0;
 var workingweight  = $('#workingWeight').val();

 // var iv             = (parseInt(iv_fluids)+parseInt(drug_infusions)+parseInt(other_drugs)) / (workingweight/1000);
 var iv             = (parseInt(iv_fluids)+parseInt(other_drugs)) / (workingweight/1000);
 var fe             = $('#Feeds').val();
      fe = parseInt(fe) ? parseInt(fe) : 0;

 if(!isNaN(parseInt(iv)) && !isNaN(parseInt(fe))) {
  var totalFluid = parseInt(iv)+parseInt(fe);
  $('#TotalFluid').val(totalFluid.toFixed(2));
  $('#total-fluid').val(totalFluid.toFixed(2));
}
}

function echoReport() {
  var list=['DayEcho','PDA','pphn'];
  if($('#echo_status').val()=='Yes') {
   removeDisable(list);

 } else {
   makeDisable(list);
   $('#DayEcho').val('');
 }
}

function pda() {
  var list=['PDATreatment'];
  if($('#PDA').val()=='Yes') {
   removeDisable(list);

 } else {
   makeDisable(list);
 }
}

function pphn() {
  var list=['pphn_treatement'];
  if($('#pphn').val()=='Yes') {
   removeDisable(list);

 } else {
   makeDisable(list);
 }
}

function neuro_sonogramReport() {
  var list=['Cuss'];
  if($('#neuro_sonogram').prop('checked')==false) {
   makeDisable(list);
   $('#Cuss').val('');
 } else {
   removeDisable(list);       
 }
}

function totalEnergycalculate() {

 var Carbohydrates =  $('#Carbohydrates').val();
 var Fat = $('#Fat').val();
 Carbohydrates = parseInt(Carbohydrates) * 4;
 Carbohydrates = isNaN(Carbohydrates) ? 0 : Carbohydrates;
 Fat = parseInt(Fat) * 10;
 Fat = isNaN(Fat) ? 0 : Fat;
 var totalEnergy =Carbohydrates + Fat; 
 $('#total_energy').val(totalEnergy);


}

function stoolsStatus() {
  var list = ['StoolNature'];

  ($('#Stools').prop('checked') == false) ? makeDisable(list) : removeDisable(list);
}

function calculateAmc() {
  var tlc         =  $('#TLC').val().trim();
  var Percentage  = $('#Percentage').val().trim();
  var amc         = (tlc*Percentage)/100;
  $('#ANC').val(parseInt(amc));

}


function girOptions() {
  var list = ['gir'];
  if($('#Hypoglycemia').prop('checked') == true || $('#Hyperglycemia').prop('checked') == true) {

    $('label[for="gir"]').show();
    $('input[name="gir"]').show();

  } else {

   $('label[for="gir"]').hide();
   $('input[name="gir"]').hide();
 } 

}

function ultraSoundabdominal(){

  var list = ['ultrasoundkeyfindings'];
  if($('#ultrasoundabdominal').prop('checked') == true ) {
   removeDisable(list);
 } else {
  makeDisable(list)
  $('#ultrasoundkeyfindings').val('');
}

}


function ultraSoundspine() {

  var list = ['ultrasound_spine_report'];
  if($('#ultrasound_spine').prop('checked') == true ) {
   removeDisable(list);
 } else {
  makeDisable(list)
  $('#ultrasound_spine_report').val('');
}

}


function ultrSoundrenal() {
 var list = ['renalultrasoundkeyfindings'];
 if($('#renalultrasound').prop('checked') == true ) {
   removeDisable(list);
 } else {
  makeDisable(list)
  $('#renalultrasoundkeyfindings').val('');
}
}

function mrictBrain(){

 var list=['mri_ct_brain'];
 if($('#mrict_brain_status').prop('checked')==false) {
   makeDisable(list);
   $('#mri_ct_brain').val('');
 } else {
  removeDisable(list);
}
}

function eegcfm() {

  var list=['eeg_cfm_report'];
  if($('#eeg_cfm').prop('checked')==false) {
   makeDisable(list);
   $('#eeg_cfm_report').val('');
 } else {
  removeDisable(list);
}

}

function sepsis_changes() {
  var list = ['CRP','TLC','Percentage','ANC','Platelets','BloodCulture','Organism','PositiveBlood','Meningitis'];
  if($('#Sepsis').val() == 'No sepsis' || $('#Sepsis').val()=='') {
   $('.sepsis-antibiotic').attr('disabled',true);
   $('.antibiotic,.antibiotic_add').hide();
   makeDisable(list);

 } else {
   $('.sepsis-antibiotic').removeAttr('disabled');
   $('.antibiotic,.antibiotic_add').show();
   removeDisable(list);

 }


}

function surfactantTherapy(){
  var list = ['surfactant_indication'];
  ($('#Surfactant_therapy_nicu').prop('checked') == false) ? makeDisable(list) : removeDisable(list);

}

function transfustionStatus(flage){

  if($('#Transfusion').val() == 'Yes'){
   $('.product-hidden').show();
   if(flage){
    getBloodproducts();
  }
}else{
 $('.product-hidden').hide();
 $('select[name="F_Product[]"]').parent().parent().remove();
}


}

function getBloodproducts(){

  var option = '<tr><td class="full-width"><select class="form-control" name="F_Product[]"><option value="">N/A</option><option value="Packed RBC">Packed RBC</option><option value="Whole Blood">Whole Blood</option><option value="Platelet Concentrate">Platelet Concentrate</option><option value="Fresh Frozen Plasma">Fresh Frozen Plasma</option><option value="Cryoprecipitate">Cryoprecipitate</option><option value="Washed maternal platelets">Washed maternal platelets</option><option value="NAIT - special platelets">NAIT - special platelets</option><option value="Immunoglobulin">Immunoglobulin</option></select></td>';
  option += '<td><input type="text" class="input-width-mini form-control" name="F_Volume[]" value="" /></td>';
  option += '<td><span class="fa fa-trash btn btn-danger btn-view remove-ivantibitic"></span></td>';
  option += '</tr>';
  $("table.product tbody").append(option);

}

function getIvfluids() {

 if ($('#FullEnteralFeeds').val() == 'Reached') {
   $('#iv_fluids, #iv_fluids_ml_day').attr('disabled','true');
   $('#iv_fluids').parent().parent().parent().parent().slideUp();
   $('#ivf').val(0);
 } else {
   $('#iv_fluids, #iv_fluids_ml_day').removeAttr('disabled');
   $('#iv_fluids').parent().parent().parent().parent().slideDown();
   // $('#ivf').val('');
 }

}

$('#FullEnteralFeeds').change(function() {
 getIvfluids();
});

$(".product_add").click(function() {
  getBloodproducts();
});
$('#echo_status').change(function() {
 echoReport();
});
$('#PDA').change(function() {
 pda();
});
$('#pphn').change(function() {
 pphn();
});

$('#neuro_sonogram').change(function() {
 neuro_sonogramReport();
});

$('#mrict_brain_status').change(function() {
 mrictBrain();
});

$('#Sepsis').change(function() {
  sepsis_changes(); 
});

$('#ultrasound_spine').change(function() {

 ultraSoundspine();
});

$('#eeg_cfm').change(function() {
  eegcfm();
});

$('#Surfactant_therapy_nicu').change(function(){
 surfactantTherapy();
});

surfactantTherapy();
eegcfm();
ultraSoundspine();
sepsis_changes();
mrictBrain();
totalfluides();
echoReport();
pda();
pphn();
tpnChanges();
NEC();
daycareAaDO2();
daycareOI();
Hepatomegaly();
Splenomegaly();
Typeofbloodgas();
Ettube();
AddedSounds();
Murmur();
Inotropes();
Seizures();
PeripheralCannula();
Picc();
daycare_uvc();
daycare_uac();
daycare_pac();
InvasiveVentilation();
typeOffeeds();
calculateFeeds();
neuro_sonogramReport();
girOptions();
ultrSoundrenal();
ultraSoundabdominal();
transfustionStatus(false);
getIvfluids();

$('#renalultrasound').on('change',function(){

 ultrSoundrenal();

});

$('#ultrasoundabdominal').on('change',function(){

 ultraSoundabdominal();

});

$('#TLC,#Percentage').on('blur',function(){
 calculateAmc();
});

$('#Carbohydrates,#Fat').on('change',function(){

  totalEnergycalculate();
});

$('#iv_fluids').on('blur',function(){

 ivFluidshourToday();

});

$('#NonInvasiveVentilation').on('change',function(){
  NoninvasiveVentilationoptions();
});

$('#drug_infusions').on('blur',function(){

 drugInfutionhourToday();

});

$('#Frequency,#workingWeight,#Volume').on('change',function(){

  calculateFeeds();
});

$('#iv_fluids, #drug_infusions, #other_drugs, #workingWeight, #Feeds').on('blur',function(){
 calulateFludes();
});

$('#urine_output_day').on('blur',function(){
 calculateUrineoutput(true);
});

$('#Tpn').change(function(){
 tpnChanges();
});


$('#directlybreastfeed,#othertypefeed').on('change',function(){
  typeOffeeds();
});

$('#Spontaneouslyventilating').on('change',function(){
 Spontaneouslyventilating();
});

$('#NEC').on('change',function(){
  NEC();

});
$('#Ventilation_choose').on('change',function(){
  Ventilation_choose();


});



$('#MAP , #fio2_set, #fio2_delivered , #PaO2, #PaCo2 ,#Rate, #IT, #PEEP, #pip_set, #pip_delivered').keyup(function(){
  daycareOI();
  daycareAaDO2();
  calculateAaDO2();
  calculateOI();
});



$('#InvasiveVentilation').on('change',function(){
  InvasiveVentilation();
});

$('#Murmur').on('change',function(){
 Murmur();
});

$("#TypeOfBloodGas").on('change',function(){
 Typeofbloodgas();
});

$("#EtTube").on('change',function(){
 Ettube();
});

$("#AddedSounds").on('change',function(){
 AddedSounds();
});

$('#Inotropes').on('change',function(){
 Inotropes();
});

$('#Hepatomegaly').on('change',function(){
 Hepatomegaly();
});

$('#Splenomegaly').on('change',function(){
 Splenomegaly();
});

$('#Seizures').on('change',function(){
 Seizures();
});

$('#PeripheralCannula').on('change',function(){
 PeripheralCannula();
});
$('#Picc').on('change',function(){
 Picc();
});
$('#Uvc').on('change',function(){
  daycare_uvc();
});
$('#Uac').on('change',function(){
  daycare_uac();
});
$('#Pac').on('change',function(){
  daycare_pac();
});

$('#Stools').on('change',function(){
  stoolsStatus();
});

$('#Hypoglycemia,#Hyperglycemia').on('change',function(){
 girOptions();
});


$('#Transfusion').change(function(){
 transfustionStatus(true);
});



$('#respiratory_problem').on('change',function(){
 if($(this).val()=='0'){
  $('#Retractions').val('No').trigger('change'); 
  $('#AirEntry').val('Equal').trigger('change');
  $('#ChestMovement').val('Symmetrical').trigger('change'); 
  $('#AddedSounds').val('Absent').trigger('change'); 
  $('#DayCharacter').val('Not applicable');  
  $('#RSFindings').val('');  

  $('#RSFindings').val('none');           
}else{
 $('#Retractions,#AddedSounds,#AirEntry,#ChestMovement').val('').trigger('change');
 $('#DayCharacter').val('');  
 $('#RSFindings').val('');    
}
});  

$('#Cardiovascular_problem').on('change',function(){

  if($(this).val()=='0'){
   $('#CentralPulses,#PeripheralPulses,#FemoralPulses').val('Normal').trigger('change'); 
   $('#PrecordialActivity,#Murmur').val('Absent').trigger('change');
   $('#S1S2').val('Normal').trigger('change');
   $('#CVSFindings,#DayEcho').val('');
   $('#CVSFindings').val('none');
   $('#CFT').val('< 3 Seconds').trigger('change');
   $('#Color').val('Pink').trigger('change');
   $('#Inotropes').val('No').trigger('change');
   $('#DayEcho').val('none');

 }else{
  $('#CentralPulses,#PeripheralPulses,#FemoralPulses,#PrecordialActivity,#Murmurm,#S1S2,#Inotropes,#CFT,#Color,#Inotropes').val('').trigger('change'); 
  $('#CVSFindings,#DayEcho').val('');

} 

}); 

$('#gastrointestinal_problem').change(function(){
  if($(this).val()=='0'){
    $('#AspirateVolume').val('0');
    $('#AspirateNature').val('Nil').trigger('change');
    $('#PAFindings').val('None');
    $('#Abdomen,#BowelSounds').val('Normal').trigger('change');
    $('#Umbilicus').val('Healthy').trigger('change');
    $('#NEC,#Hepatomegaly,#SpleenSpan,#Splenomegaly').val('No').trigger('change');
    $('#Herina').val('No hernia').trigger('change');
    $('#Genitalia').val('Normal');


  }else{
    $('#AspirateVolume,#PAFindings,#Genitalia').val('');
    $('#AspirateNature,#Abdomen,#BowelSounds,#Umbilicus,#NEC,#Hepatomegaly,#SpleenSpan,#Herina,#Splenomegaly').val('').trigger('change');

  }

});  
$('#central_problem,#sedation_paralysis').change(function(){
  if($('#central_problem').val() == '0' && $('#sedation_paralysis').val() == '0'){
   $('#TherapeuticHypothermia').val('No').trigger('change');
   $('#Pupils').val('Equal and reacting to light on both sides');
   $('#AnteriorFontanelle,#Activity,#Tone,#NeonatalReflexes').val('Normal').trigger('change');
   $('#Cry').val('Normal consolable').trigger('change');
   $('#Seizures').val('No').trigger('change');
   $('#CnsFindings').val('');
   $('#CnsFindings').val('none');

 }else if($('#central_problem').val() == '0' && $('#sedation_paralysis').val() == '1'){

   $('#TherapeuticHypothermia').val('No').trigger('change');
   $('#Pupils').val('Not applicable');
   $('#AnteriorFontanelle').val('Normal').trigger('change');
   $('#Cry,#Activity,#Tone,#NeonatalReflexes').val('Sedated/Paralysed').trigger('change');
   $('#Seizures').val('No').trigger('change');
   $('#CnsFindings').val('');
   $('#CnsFindings').val('none');
 }else{
   $('#TherapeuticHypothermia,#AnteriorFontanelle,#Cry,#Activity,#Tone,#NeonatalReflexes,#Seizures').val('').trigger('change');
   $('#Pupils').val('');
   $('#CnsFindings').val('');


 }
});






$('#Pupils').selectwithfreetext({
  mainclass   :'select-free4',
  list        : ['Equal and reacting to light on both sides'],
});


var seletorArray = ['lumbar_puncture','InvasiveVentilation','Spontaneouslyventilating','OtherRespiratorySupport','NonInvasiveVentilation','Retractions','AirEntry','ChestMovement','AddedSounds','EtTube','PulsePressure','PrecordialActivity','S1S2','Murmur','CFT','Color','Inotropes','PDA','PDATreatment','FullEnteralFeeds','Tpn','Abdomen','BowelSounds','NEC','Hepatomegaly','Splenomegaly','NNJTreatment','Immunoglobulins','TherapeuticHypothermia','AnteriorFontanelle','Seizures','UrineOutput','Transfusion','BloodCulture','PeripheralCannula','Picc','Uvc','Uac','Pac','UvcPosition','UacPosition','echo_status','pphn','pphn_treatement'];

$.each(seletorArray,function(index,value){

  buildSelector(value);

}); 








$( "#daycare-form" ).validate({
  rules: {

    //general information tab


    DayOfLife: {
      digits:true
    },
    cg_weeks: {
      digits:true,
      required: true
    },
    cg_days: {
      digits:true,
      required: true
    },
    Care:{
      required:true
    },
    // SeenBy:{
    //   required:SeenBy
    // },
    SeenBy:{
      required:true
    },
    DayDate:{
      required:true
    },
    DayTime:{
      required:true
    },
    DayTime_MINS:{
      required:true
    },
    DayTime_AM:{
      required:true
    },

    //Respiratory System tab

    // pip_set: {
    //   digits:true,
    //   min:8,
    //   max:60
    // },
    // pip_delivered: {
    //   digits:true,
    //   min:8,
    //   max:60
    // },
    // PEEP: {
    //   twodigitstwodecimal:true,
    //   min:0,
    //   max:15
    // },
    // MAP: {
    //   digits:true,
    //   min:4,
    //   max:25
    // },
    // fio2_set: {
    //   digits:true,
    //   min:21,
    //   max:100
    // },
    // fio2_delivered: {
    //   digits:true,
    //   min:21,
    //   max:100
    // },
    // Rate: {
    //   digits:true,
    //   min:1,
    //   max:600
    // },
    // frequency_rep: {
    //   digits:true,
    //   min:1,
    //   max:600
    // },
    // IT: {
    //   twodigitstwodecimal:true,
    //   min:0.2,
    //   max:1.5
    // },
    // Flow: {
    //   twodigitstwodecimal:true,
    //   min:0,
    //   max:12
    // },
    // RR: {
    //   digits:true,
    //   minlength:2,
    //   maxlength:3
    // },
    // Ph: {
    //   digitonedecimaltwo:true,
    //   min:6,
    //   max:8
    // },
    AbdominalGirth:{
      digitstwodecimalone:true,
      min:0,
      max:99
    },
     // PaO2: {
     //  digits:true,
     //  minlength:1,
     //  maxlength:3
     // },    
     // PaCo2: {
     //  digits:true,
     //  minlength:1,
     //  maxlength:3
     // },
    //  HCO3: {
    //   digitstwodecimalone:true,
    //   min:0,
    //   max:40
    // },
    // BE:{
    //   plusorminustwodigitsonedecimal:true,
    //   min:-50,
    //   max:50
    // },
    // Lactate: {
    //   digitstwodecimalone:true
    // },
    Lips: {
     digitstwodecimalone:true
   },
  //  SaO2PostDuctal: {
  //   digits:true,
  //   min:0,
  //   max:100
  // },
    // Cardiovascular Form
   //  HR:{
   //    digits:true,
   //    minlength:2,
   //    maxlength:3
   //  },
   //  systolic_bp: {
   //   digits:true,
   //   minlength:2,
   //   maxlength:3
   // },
   // diastolic_bp: {
   //   digits:true,
   //   minlength:2,
   //   maxlength:3
   // },
   // MeanBP: {
   //   digits:true,
   //   minlength:2,
   //   maxlength:3
   // },
   PeripheralTemperature:{
     // decimal_range_one:true,
     min:10,
     max:120
   },
   // CentralTemperature: {
   //   // decimal_range_one:true,
   //   min:10,
   //   max:120
   // },
    //Gastrointestinal System

    Volume: {
      decimal_range_one:true,
      min:0,
      max:150
    },
    workingWeight: {
     digits:true,
     minlength:3,
     maxlength:4
   },
   iv_fluids: {
    decimal_range_two:true
  },
  drug_infusions:{
    digitstwodecimalone:true,
    min:0,
    max:50
  },
  other_drugs: {
    decimal_range_one:true,
    min:0,
    max:100
  },
  Carbohydrates: {
    digitstwodecimalone:true,
    min:0,
    max:50
  },
  Protein: {
    onedigitonedecimal:true,
    min:0,
    max:6
  },
  Fat: {
    // digitonedecimaltwo:true,
    min:0,
    max:6
  },

  AspirateVolume: {
    decimal_range_one:true,
    min:0,
    max:999
  }, 
  LiverSpan: {
   digits:true,
   min:0,
   max:99
 },
 SpleenSpan:{
   digits:true,
   min:0,
   max:99
 },
 TSB: {
  // digitstwodecimalone:true,
  min:0,
  max:50
},
   //Renal fluids and balance 
   PreviousWt: {
    digits:true,
    minlength:3,
    maxlength:4,
    omitZeros : true
  },
  CurrentWt: {
    digits:true,
    minlength:3,
    maxlength:4,
    omitZeros : true
  },
  urine_output_day: {
    decimal_range_one:true,
    minlength:0,
    maxlength:999
  },
  BloodOut: {
    digitstwodecimalone:true,
    min:0,
    max:99
  },
  DrainOutput: {
    decimal_range_one:true,
    min:0,
    max:999
  },
  RBS: {
    digits:true,
    minlength:1,
    maxlength:4
  },
  gir:{
    digitstwodecimalone:true,
    min:0,
    max:99
  },
  'F_Volume[]':{
    digits:true,
    min:0,
    max:99
  },
     //Sepsis and Drugs Form
     'A_Day[]':{
       digits:true,
       min:0,
       max:999
     },
    //  CRP: {
    //   decimal_range_two:true,
    //   min:0,
    //   max:999
    // },
    TLC: {
      digits:true,
      minlength:0,
      maxlength:5
    },
    Percentage: {
      decimal_range_two:true,
      min:0,
      max:100  
    },
    ANC: {
      // digits:true
    },
    Platelets: {
      digits:true,
      minlength:4,
      maxlength:6
    },
     //Invasive Lines
     pvc_number:{
      digits:true,
      min:0,
      max:100
    },
    PiccDay:{
      digits:true,
      minlength:1,
      maxlength:3 
    },
    UvcDay:{
      digits:true,
      minlength:1,
      maxlength:3
    },
    UacDay:{
      digits:true,
      minlength:1,
      maxlength:3
    },
    PacDay:{
      digits:true,
      minlength:1,
      maxlength:3
    },
    phone:{
      digits:true,
      minlength:10,
      maxlength:10
    },
    head_circumference: {
      growthdayonlyrequired: true,
      omitZeros: true
    },
    length: {
      growthdayonlyrequired: true,
      omitZeros: true
    }
  },
  messages: {

    DayOfLife:{
      digits:'Day of Life must be digits.'
    },
    cg_weeks: {
     digits:'Weeks must be in digits.'
   },
   cg_days: {
     digits:'Days must be in digits.'
   },
   Care:{
    required:'Care is mandatory.'
  },
  SeenBy:{
    required:'SeenBy is mandatory.'
  },
  DayDate:{
    required:'Date of Record is mandatory.'
  },
  DayTime:{
   required:'Time of Record hours is mandatory.'
 },
 DayTime_MINS:{
   required:'Time of Record minutes is mandatory.'
 },
 DayTime_AM:{
   required:'Time of Record section is mandatory.'
 },

   //Respiratory System tab

   pip_set: {
    digits:'PIP Set must be in digits.',
    min:'PIP Set must be greater than or equalto 8.',
    max:'PIP Set must be less than or equalto 60.'
  },
   pip_delivered: {
    digits:'PIP Delivered must be in digits.',
    min:'PIP Delivered must be greater than or equalto 8.',
    max:'PIP Delivered must be less than or equalto 60.'
  },
  PEEP: {
    digits:'PEEP must be in digits.',
    min:'PEEP must be greater than or equalto 0.',
    max:'PEEP must be less than or equalto 15.'
  },
  MAP:{
    digits:'MAP must be in digits.',
    min:'MAP must be in greater than or equalto 4.',
    max:'MAP must be in less than or equalto 25.'
  },
  fio2_set:{
    digits:'FiO2 Set must be in digits.',
    min:'FiO2 Set must be greater than or equalto 21.',
    max:'FiO2 Set must be less than or equalto 100.'
  },
  fio2_delivered:{
    digits:'FiO2 Delivered must be in digits.',
    min:'FiO2 Delivered must be greater than or equalto 21.',
    max:'FiO2 Delivered must be less than or equalto 100.'
  },
  Rate:{
    digits:'Ventilator Rate must be in digits.',
    min:'Ventilator Rate must be greater than 1.',
    max:'Ventilator Rate must be less than 600.'
  },
  frequency_rep: {
    digits:'Frequency must be in digits.',
    min:'Frequency must be greater than 1.',
    max:'Frequency must be less than 600.'
  },
  IT: {
    onedigitonedecimal:'IT may be 1 digits and 1 decimal place.',
    min:'IT must be greater than or equalto 0.2.',
    max:'IT must be less than or equalto 1.5.'
  },
  Flow: {
    twodigitstwodecimal:'Flow may be 2 digits and 2 decimal places.',
    min:'Flow must be greater than or equalto 0.',
    max:'Flow must be less than or equalto 12.'
  },
  RR: {
    digits:'Respiratory Rate must be digits.',
    minlength:'Respiratory Rate must be greater than or equalto 2 digits.',
    maxlength:'Respiratory Rate must be less than or equalto 3 digits.',
  },
  Ph: {
    digitonedecimaltwo:'pH may be 1 digit and 2 decimal places.',
    min:'pH must be greater than or equalto 6.',
    max:'pH must be less than or equalto 8.',
  },
  AbdominalGirth:{
    digitstwodecimalone:'Abdominal Girth may be 2 digits and 1 decimal.',
    min:'Abdominal Girth must be greater than or equalto 0.',
    max:'Abdominal Girth must be less than or equalto 99.'
  },

    // PaO2: {
    //   digits:'PaO2 must be digits.',
    //   minlength:'PaO2 must be greater than or equalto 1 digit.',
    //   maxlength:'PaO2 must be less than or equalto 3 digits.'
    // },
    // PaCo2: {
    //   digits:'PaCo2 must be digits.',
    //   minlength:'PaCo2 must be greater than or equalto 1 digit.',
    //   maxlength:'PaCo2 must be less than or equalto 3 digits.'
    // },

    HCO3: {
      digitstwodecimalone:'HCO3 may be 2 digits and 1 decimal places.',
      min:'HCO3 must be greater than or equalto 0.',
      max:'HCO3 must be less than or equalto 40.'
    },
    BE:{
      plusorminustwodigitsonedecimal:'BE may be +/- with 2 digits and 1 decimal places.',
      min:'BE must be greater than or equalto -50.',
      max:'BE must be less than or equalto +50.'
    },
    Lactate:{
      digitstwodecimalone:'Lactate may be 2 digits and 1 decimal places.'
    },
    Lips: {
     digitstwodecimalone:'Cm at Lips may be 2 digit and 1 decimal places.'
   },
   SaO2PostDuctal: {
    digits:'SaO2 PostDuctal must be digits.',
    min:'SaO2 PostDuctal must be greater than or equalto 0.',
    max:'SaO2 PostDuctal must be less than or equalto 100.'
  },
  HR:{
    digits:'HR must be digits.',
    minlength:'HR must be greater than or equalto 2 digits.',
    maxlength:'HR must be less than or equalto 3 digits.'
  },
  systolic_bp: {
   digits:'Systolic BP must be digits.',
   minlength:'Systolic BP must be greater than or equalto 2 digits.',
   maxlength:'Systolic BP must be less than or equalto 3 digits.'
 },
 diastolic_bp: {
   digits:'Diastolic BP must be digits.',
   minlength:'Diastolic BP must be greater than or equalto 2 digits.',
   maxlength:'Diastolic BP must be less than or equalto 3 digits.'
 },
 MeanBP: {
   digits:'Mean BP must be digits.',
   minlength:'Mean BP must be greater than or equalto 2 digits.',
   maxlength:'Mean be must be less than or equalto 3 digits.'
 },

 CentralTemperature: {
   decimal_range_one:'Centarl Temperature may be 3 digits and 1 decimal places.',
   min:'Central Temperature must be greater than or equalto 10.',
   max:'Centarl Temperature must be less than or equalto 120.'
 },
 PeripheralTemperature:{
   decimal_range_one:'Peripheral Temperature may be 3 digits and 1 decimal places.',
   min:'Peripheral Temperature must be greater than or equalto 10.',
   max:'Peripheral Temperature must be less than or equalto 120.'
 },
 Volume: {
  decimal_range_one:'Volume can be 3 digits and 1 decimal places.',
  min:'Volume must be greater than or equalto 0.',
  max:'Volume must be less than or equalto 150.'
},
workingWeight: {
 digits:'Working weight must be digits.',
 minlength:'Working weight must be greater than or equalto 3 digits.',
 maxlength:'Working weight must be less than or equalto 4 digits.'
},

iv_fluids: {
  decimal_range_two:'IV fluids may be 3 digits and 2 decimal places.',
},
drug_infusions:{
  digitstwodecimalone:'Drug Infusions may be 2 digits and 1 decimal places.',
  min:'Drug Infusions must be greater than or equalto 0.',
  max:'Drug Infusions must be less than or equalto 50.'
},
other_drugs: {
  decimal_range_one:'Other Drugs may be 3 digits and 1 decimal places.',
  min:'Other Drugs must be greater than or equalto 0.',
  max:'Other Drugs must be less than or equalto 100.'
},
Carbohydrates: {
  digitstwodecimalone:'Carbohydrates may be 2 digits and 1 decimal places.',
  min:'Carbohydrates must be greater than or equalto 0.',
  max:'Carbohydrates must be less than or equalto 50.'
},
Protein: {
  onedigitonedecimal:'Amino Acid may be 1 digits and 1 decimal places.',
  min:'Amino Acid must be greater than or equalto 0.',
  max:'Amino Acid must be less than or equalto 6.'
},
Fat: {
  // digitonedecimaltwo:'Fat may be 1 digits and 2 decimal places.',
  min:'Fat must be greater than or equalto 0.',
  max:'Fat must be less than or equalto 6.'
},

AspirateVolume: {
  decimal_range_one:'Aspirate Volume may be 3 digits and 1 decimal places.',
  min:'Aspirate Volume must be greater than or equalto 0.',
  max:'Aspirate Volume must be less than or equalto 999.'
}, 
LiverSpan: {
  digits:'Liver Span must be digits.',
  min:'Liver Span must be greater than or equalto 0.',
  max:'Liver Span must be less than or equalto 99'
},
SpleenSpan:{
  digits:'Spleen Span must be digits.',
  min:'Spleen Span must be greater than or equalto 0.',
  max:'Spleen Span must be less than or equalto 99.'
}, 
TSB: {
  // digitstwodecimalone:'Maximum Bilirubin may be 2 digits and 1 decimal.',
  min:'Maximum Bilirubin must be greater than or equalto 0.',
  max:'Maximum Bilirubin must be less than or equalto 50.'
},

PreviousWt: {
  digits:'Previous Weight must be digits.',
  minlength:'Previous Weight must be greater than or equalto 3 digits.',
  maxlength:'Previous Weight must be less than or equalto 4 digits.',
  omitZeros: 'Invalid Previous Weight'
},
CurrentWt: {
  digits:'Current Weight must be digits.',
  minlength:'Current Weight must be greater than or equalto 3 digits.',
  maxlength:'Current Weight must be less than or equalto 4 digits.',
  omitZeros: 'Invalid Current Weight'
},
urine_output_day: {
  decimal_range_one:'UO ml (in 24 hours) can be 3 digits and 1 decimal places.',
  minlength:'UO ml (in 24 hours) be must greater than or equalto 0.',
  maxlength:'UO ml (in 24 hours) be must less than or equalto 999.'
},
BloodOut: {
  digitstwodecimalone:'Blood Out can be 2 digits and 1 decimal places.',
  min:'Blood Out must be greater than or equalto 0.',
  max:'Blood Out must be less than or equalto 99.'
},
DrainOutput: {
  decimal_range_one:'Drain Output can be 3 digits and  1 decimal places.',
  min:'Drain Output must be greater than or equalto 0',
  max:'Drain Output must be less than or equalto 999',
},
RBS: {
  digits:'RBS must be digits.',
  minlength:'RBS must be greater than or equalto 1 digits.',
  maxlength:'RBS must be less than or equalto 4 digits.'
},
gir:{
  digitstwodecimalone:'GIR can be 2 digits and 1 decimal.',
  min:'GIR must be greater than or equalto 0.',
  max:'GIR must be less than or equalto 99.'
},
'F_Volume[]':{
  digits:'Volume ml/kg must be digits.',
  min:'Volume ml/kg must be greater than or equalto 0.',
  max:'Volume ml/kg must be less than or equalto 99.'
},
'A_Day[]':{
  digits:'Day must be digits.',
  min:'Day must be greater than or equalto 0.',
  max:'Day must be less than or equalto 999.',
},
CRP: {
  decimal_range_two:'CRP can be 3 digits and 2 decimal places.',
  min:'CRP must be greater than or equalto 0.',
  max:'CRP must be less than or equalto 999.'
},
TLC: {
  digits:'TLC must be digits.',
  minlength:'TLC must be greater than or equalto 1 digits.',
  maxlength:'TLC must be less than or equalto 5 digits.'
},
Percentage: {
  decimal_range_one:'Percentage N can be 3 digits and 1 decimal places.',
  min:'Percentage N must be greater than or equalto 0.',
  max:'Percentage N must be less than or equalto 100.'  
},
ANC: {
  // digits:'ANC per cu.mm must be digits.',
},
Platelets: {
  digits:'Platelets per cu.mm must be digits.',
  minlength:'platelets per cu.mm must be greater than or equalto 4 digits.',
  maxlength:'platelets per cu.mm must be less than or equalto 6 digits.'
},
pvc_number:{
  digits:'PVC Number must be digits.',
  min:'PVC Number must be greater than or equalto 0.',
  max:'PVC Number must be less than or equalto 100.'
},
PiccDay:{
  digits:'Picc Day must be digits.',
  minlength:'Picc Day must be greater than or equalto 1 digits.',
  maxlength:'Picc Day must be less than or equalto 3 digits.' 
},
UvcDay:{
  digits:'UVC Day must be digits.',
  minlength:'UVC Day must be greater than or equalto 1 digits.',
  maxlength:'UVC Day must be less than or equalto 3 digits.'
},
UacDay:{
  digits:'Uac Day must be digits.',
  minlength:'Uac Day must be greater than or equalto 1 digits.',
  maxlength:'Uac Day must be less than or equalto 3 digits.'
},
PacDay:{
  digits:'PAC Day must be digits.',
  minlength:'PAC Day must be greater than or equalto 1 digits.',
  maxlength:'PAC Day must be less than or equalto 3 digits.'
},
phone:{
  digits:'Referal Doctor phone number must be digits.',
  minlength:'Referal Doctor phone number must be 10 digits.',
  maxlength:'Referal Doctor phone number must be 10 digits.'
},
length: {
  omitZeros: 'Invalid length'  
},
head_circumference: {
  omitZeros: 'Invalid head circumference'    
}
}, 
showErrors: function (errorMap, errorList) {

  if (typeof errorList[0] != "undefined") {
    var position = $(errorList[0].element).position().top;
    $('html, body').animate({
      scrollTop: position
    }, 300);
  }
  this.defaultShowErrors();
}
});

function touchHandler(event) {
  
  if(event.target.className == 'draggable-item'){
    // console.log(str2 + " found");
    var touch = event.changedTouches[0];

    var simulatedEvent = document.createEvent("MouseEvent");
    simulatedEvent.initMouseEvent({
      touchstart: "mousedown",
      touchmove: "mousemove",
      touchend: "mouseup"
    }[event.type], true, true, window, 1,
    touch.screenX, touch.screenY,
    touch.clientX, touch.clientY, false,
    false, false, false, 0, null);

    touch.target.dispatchEvent(simulatedEvent);
    event.preventDefault();
  }
}

function touch_init() {
  document.addEventListener("touchstart", touchHandler, true);
  document.addEventListener("touchmove", touchHandler, true);
    // document.addEventListener("touchend", touchHandler, true);
    // document.addEventListener("touchcancel", touchHandler, true);
  }
  touch_init();
  
  // $('#DayDate').trigger('change');

 //  $('#DayDate').on('change', function() {
 //   var g_weeks = $('input[name="g_weeks"]').val();
 //   var g_days = $('input[name="g_days"]').val();

 //   var dayDate  =  $('#DayDate').val();
 //   var dobDate        = $('#DOB').val();

 //   dobDate        = stringToDate(dobDate,'dd-mm-yyyy','-');
 //   dayDate  = stringToDate(dayDate,'dd-mm-yyyy','-');

 //   var tempDays = calculateDays(dobDate, dayDate);
 //   $('#DayOfLife').val(tempDays);
 //   correctedGestation(g_weeks, g_days, tempDays);
 // });
 //  $('#DayDate').on('change', function() {
 //  calculateCorrectedGestation();
 // });

// function calculateCorrectedGestation()
// {
//   var dob = $('#DOB').val();
//   dob        = stringToDate(dob,'dd-mm-yyyy','-');
//   var dischargeDate = $('#DayDate').datepicker('getDate');
//   var days = calculateDays(dob, dischargeDate);
  
//   var gestationWeeks = $('input[name="g_weeks"]').val();
//   var gestationDays = $('input[name="g_days"]').val();
//   if (gestationDays == '' || gestationDays == null) {
//     gestationDays = 0;
//   }
//   var total_gestation_days = parseInt(gestationWeeks) * 7;
//   total_gestation_days = parseInt(gestationDays) + total_gestation_days + days;

//   // var correctedweekDays = parseInt(gestationDays) + parseInt(days);
//   var correctedWeeks = parseInt(parseInt(total_gestation_days) / 7);
//   var correctedDays = parseInt(parseInt(total_gestation_days) % 7);
//   $('input[name=cg_weeks]').val(correctedWeeks);
//   $('input[name=cg_days]').val(correctedDays);

// }
