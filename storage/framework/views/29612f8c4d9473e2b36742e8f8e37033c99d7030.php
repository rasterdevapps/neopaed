
<?php $results = (isset($baby_detail)) ? $baby_detail : $results; ?>
<script type="text/javascript">


  <?php if(@$results->Booked=='No' || is_null(@$results->Booked) || empty(@$results->Booked)): ?>
  $('#Booked').bootstrapToggle('off');
  <?php elseif(@$results->Booked== "Yes"): ?>
  $('#Booked').bootstrapToggle('on');
  <?php endif; ?>


  <?php if(@$results->Supervised == 'No' || is_null(@$results->Supervised) || empty(@$results->Supervised)): ?>
  $('#Supervised').bootstrapToggle('off');
  <?php elseif(@$results->Supervised == "Yes"): ?>
  $('#Supervised').bootstrapToggle('on');
  <?php endif; ?>


  <?php if(@$results->MultiplePregnancy == 'No' || is_null(@$results->MultiplePregnancy) || empty(@$results->MultiplePregnancy)): ?>
  $('#MultiplePregnancy').bootstrapToggle('off');
  <?php elseif(@$results->MultiplePregnancy == "Yes"): ?>
  $('#MultiplePregnancy').bootstrapToggle('on');
  <?php endif; ?>


  <?php if(@$results->PregnancyComplications == 'No' || is_null(@$results->PregnancyComplications) || empty(@$results->PregnancyComplications)): ?>
     $('#PregnancyComplications').bootstrapToggle('off');
  <?php elseif(@$results->PregnancyComplications == "Yes"): ?>
  $('#PregnancyComplications').bootstrapToggle('on');
  <?php endif; ?>

  <?php if(@$results->AntenatalSteroids == 'No' || is_null(@$results->AntenatalSteroids) || empty(@$results->AntenatalSteroids)): ?>
  $('#AntenatalSteroids').bootstrapToggle('off');
  <?php elseif(@$results->AntenatalSteroids == "Yes"): ?>
  $('#AntenatalSteroids').bootstrapToggle('on');
  <?php endif; ?>

  <?php if(@$results->Labour == 'No' || is_null(@$results->Labour) || empty(@$results->Labour)): ?>
  $('#Labour').bootstrapToggle('off');
  <?php elseif(@$results->Labour == "Yes"): ?>
  $('#Labour').bootstrapToggle('on');
  <?php endif; ?>

  <?php if(@$results->MaternalPyrexia == 'No' || is_null(@$results->MaternalPyrexia) || empty(@$results->MaternalPyrexia)): ?>
  $('#MaternalPyrexia').bootstrapToggle('off');
  <?php elseif(@$results->MaternalPyrexia == "Yes"): ?>
  $('#MaternalPyrexia').bootstrapToggle('on');
  <?php endif; ?>

  <?php if(@$results->PROM == 'No' || is_null(@$results->PROM) || empty(@$results->PROM)): ?>
  $('#PROM').bootstrapToggle('off');
  <?php elseif(@$results->PROM == "Yes"): ?>
  $('#PROM').bootstrapToggle('on');
  <?php endif; ?>

  <?php if(@$results->Resuscitation == 'No' || is_null(@$results->Resuscitation) || empty(@$results->Resuscitation)): ?>
   $('#Resuscitation').bootstrapToggle('off');
  <?php elseif(@$results->Resuscitation == "Yes"): ?> 
   $('#Resuscitation').bootstrapToggle('on');
  <?php endif; ?>

  <?php if(@$results->FacialOxygen == 'No' || is_null(@$results->FacialOxygen) || empty(@$results->FacialOxygen)): ?>
   $('#FacialOxygen').bootstrapToggle('off');
  <?php elseif(@$results->FacialOxygen == 'Yes'): ?> 
   $('#FacialOxygen').bootstrapToggle('on');
  <?php endif; ?>

  <?php if(@$results->Intubation == 'No' || is_null(@$results->Intubation) || empty(@$results->Intubation)): ?>
   $('#Intubation').bootstrapToggle('off');
  <?php elseif(@$results->Intubation == 'Yes'): ?> 
   $('#Intubation').bootstrapToggle('on');
  <?php endif; ?>

  <?php if(@$results->PPV == 'No' || is_null(@$results->PPV) || empty(@$results->PPV)): ?>
   $('#PPV').bootstrapToggle('off');
  <?php elseif(@$results->PPV == 'Yes'): ?> 
    $('#PPV').bootstrapToggle('on');
  <?php endif; ?>

  <?php if(@$results->CPR == 'No' || is_null(@$results->CPR) || empty(@$results->CPR)): ?>
   $('#CPR').bootstrapToggle('off');
  <?php elseif(@$results->CPR == 'Yes'): ?> 
   $('#CPR').bootstrapToggle('on'); 
  <?php endif; ?>

  <?php if(@$results->Drugs == 'No' || is_null(@$results->Drugs) || empty(@$results->Drugs)): ?>
   $('#Drugs').bootstrapToggle('off');
  <?php elseif(@$results->Drugs == 'Yes'): ?> 
   $('#Drugs').bootstrapToggle('on'); 
  <?php endif; ?>

  <?php if(@$results->Consanguinity =='No' || is_null(@$results->Consanguinity) || empty(@$results->Consanguinity)): ?>
   $('#Consanguinity').bootstrapToggle('off');
  <?php elseif(@$results->Consanguinity == 'Yes'): ?> 
   $('#Consanguinity').bootstrapToggle('on');     
  <?php endif; ?>

  <?php if(@$results->delivery_room_cpap =='No' || is_null(@$results->delivery_room_cpap) || empty(@$results->delivery_room_cpap)): ?>
   $('#delivery_room_cpap').bootstrapToggle('off');
  <?php elseif(@$results->delivery_room_cpap == 'Yes'): ?> 
   $('#delivery_room_cpap').bootstrapToggle('on');     
  <?php endif; ?>

  <?php if(@$results->bag_mask_ventilator =='No' || is_null(@$results->bag_mask_ventilator) || empty(@$results->bag_mask_ventilator)): ?>
   $('#bag_mask_ventilator').bootstrapToggle('off');
  <?php elseif(@$results->bag_mask_ventilator == 'Yes'): ?> 
   $('#bag_mask_ventilator').bootstrapToggle('on');     
  <?php endif; ?>

  <?php if(@$results->bag_mask_ventilator_duration =='Unknown' || is_null(@$results->bag_mask_ventilator_duration) || empty(@$results->bag_mask_ventilator_duration)): ?>
   $('#bag_mask_ventilator_duration').bootstrapToggle('off');
  <?php elseif(@$results->bag_mask_ventilator_duration == 'known'): ?> 
   $('#bag_mask_ventilator_duration').bootstrapToggle('on');     
  <?php endif; ?>





  <?php if(@$results->newbornStatus == 2 ): ?>
   $('#newbornStatus').bootstrapToggle('on'); 
  <?php endif; ?>
  
  <?php if(@$results->known_field == 1): ?>
   $('#known_field').bootstrapToggle('on');
  <?php endif; ?>

  <?php if(@$results->adjustedtrisomies == 2): ?>
   $('#adjustedtrisomies').bootstrapToggle('on');
   
       <?php if(!empty($results->AdjustedRiskForTrisomy21)): ?>
        $('#AdjustedRiskForTrisomy21').val('<?php echo e($results->AdjustedRiskForTrisomy21, false); ?>');
       <?php endif; ?>

       <?php if(!empty($results->AdjustedRiskForTrisomy18)): ?>
          $('#AdjustedRiskForTrisomy18').val('<?php echo e($results->AdjustedRiskForTrisomy18, false); ?>');
       <?php endif; ?>

       <?php if(!empty($results->AdjustedRiskForTrisomy13)): ?>
          $('#AdjustedRiskForTrisomy13').val('<?php echo e($results->AdjustedRiskForTrisomy13, false); ?>');
       <?php endif; ?>

  <?php endif; ?>

<?php if(@$results->timeofgasp_status == true): ?>
   $('#timeofgasp_status').bootstrapToggle('on');
<?php endif; ?>  

<?php if(@$results->regularrespiration_status == true): ?>
   $('#regularrespiration_status').bootstrapToggle('on');
<?php endif; ?>

<?php if(@$results->insertion_status == true): ?>
   $('#insertion_status').bootstrapToggle('on');
<?php else: ?> 
 $('#insertion_status').bootstrapToggle('off');
<?php endif; ?>

<?php if(@$results->ppv_status == true): ?>
   $('#ppv_status').bootstrapToggle('on');
<?php endif; ?>

<?php if(@$results->cpr_status == true): ?>
   $('#cpr_status').bootstrapToggle('on');
<?php endif; ?>
var neonatalArray = ['HIV','HepatitisB','VDRL','Maternal_antibiotics_status','LastDoseDeliveryInterval','NatureofLabour','CTG','delayed_cord_clamping','TypeofAnesthesia','ETTSize','VitaminK','DoseVitK','RouteVitK','DCT','NbCFT','Colour','Pallor','Nose','Lips','Palate','Neck','Nipples','Esophagus','UmbilicalCord','AnteriorFontanelle','Jaundice','Hips','Anus','Spine','Hairs','PrecordialActivity','ApicalImpulse','S1S2','Murmur','NbChestMovement','BreathSounds','AirEntry','AddedSounds','AbdomenShape','Hepatomegaly','Splenomegaly','Flanks','Seizures','TypeofSeizure','GeneralBodyMovements','SpontaneousActivity','Cry','NbTone','NeonatalReflexes','Syntocinon','wb_echo_status','wb_echo_report','antenatal_MgSO4', 'typeofsteroids', 'sepsis_in_mother', 'initial_steps','umbilicalcordmilking','cutcordmilking', 'ict'];

$.each(neonatalArray, function(index,value) {
    buildSelector(value);
});


$(document).ready(function(){

  var changenewbornstatus = ['#Jaundice','#Nostrils','#Esophagus','#Eyes','#Pallor','#Colour','#NbCFT','#Lips','#Palate','#Neck',
'#Nipples','#Umbilicus','#UmbilicalCord','#AnteriorFontanelle','#Ears','#Nose','#CentralPulses','#PeripheralPulses','#Scalp',
'#HernialOrifices','#FemoralPulses','#Hips','#Anus','#Spine','#RtUL','#RtLL','#LtUL','#LtLL','#Skin','#Hairs','#PrecordialActivity',
'#ApicalImpulse','#BoundingPulses','#Murmur','#S1S2','#NbChestMovement','#BreathSounds','#AirEntry','#AddedSounds',
'#AbdomenShape','#Hepatomegaly','#Splenomegaly','#Flanks','#LevelOfConsciousness','#Seizures','#GeneralBodyMovements',
'#SpontaneousActivity','#Cry','#NbTone','#NeonatalReflexes'];

$('#newbornStatus').change(function(){
    if($('#newbornStatus').prop('checked')) {

       $('select[name="Scalp[]"]').val('Normal').trigger('change');
       $('#NbCFT').val('< 3 Seconds').trigger('change');
       $('#Colour').val('Pink').trigger('change');
       $('#Pallor,#Jaundice,#PrecordialActivity,#BoundingPulses,#Murmur,#AddedSounds,#Hepatomegaly').val('Absent').trigger('change');
       $('#Splenomegaly').val('Absent').trigger('change');
       $('#Eyes').val('Normal with Red reflex').trigger('change');
       $('#Nostrils,#Esophagus').val('Patent').trigger('change');
       $('#Genitalia,#FemoralPulses,#Lips,#Palate,#Neck,#Nipples,#Umbilicus,#UmbilicalCord,#AnteriorFontanelle,#Ears,#Nose,#CentralPulses,#PeripheralPulses,#Scalp').val('Normal').trigger('change');
       $('#Hips,#Spine,#RtUL,#RtLL,#LtUL,#LtLL,#Skin,#Hairs,#ApicalImpulse,#S1S2,#AbdomenShape,#Flanks,#LevelOfConsciousness,#SpontaneousActivity,#NbTone,#NeonatalReflexes').val('Normal').trigger('change');
       $('#HernialOrifices').val('No hernia').trigger('change');
       $('#AnyOtherAbnormality,#other_cvs_findings').val('none');
       $('#CharacterofMurmur').val('Not applicable');
       $('#SiteofMurmur').val('N/A').trigger('change');
       $('#NbChestMovement,#GeneralBodyMovements').val('Symmetrical').trigger('change');
       $('#BreathSounds').val('Normal Vesicular').trigger('change');
       $('#AirEntry').val('Equal').trigger('change');
       $('#other_pa_findings,#other_cns_findings').val('none');
       $('#Seizures').val('No').trigger('change');
       $('#Cry').val('Normal consolable').trigger('change');
       $('#Anus').val('Patent').trigger('change');
       $('#other_rs_findings,#CharacterOfAddedSounds,#SiteofAddedSounds,#LiverSpan,#SpleenSpan').val('Not applicable');
       
    }else{

      $.each(changenewbornstatus,function(index,value){
          $(value).val('').trigger('change');
      });
      $('#AnyOtherAbnormality,#other_cvs_findings').val('');
      $('#CharacterofMurmur,#other_rs_findings,#CharacterOfAddedSounds,#SiteofAddedSounds,#LiverSpan,#SpleenSpan,#other_pa_findings,#other_cns_findings').val().empty();

      
    }
});

});




function resuscitation() {

    var timeofGasps = $('#timeofgasp_status').parent();
    var regularRespiration = $('#regularrespiration_status').parent();
    var initialsteps = $('#initial_steps').parent();
    var deliverycpap = $('#delivery_room_cpap').parent();
    var bagmask = $('#bag_mask_ventilator').parent();
    var intubation = $('#Intubation').parent();
    var ppv = $('#PPV').parent();
    var cpr = $('#CPR').parent();
    var drugs = $('#Drugs').parent();

  if(timeofGasps.hasClass('toggle') && timeofGasps.hasClass('toggle')) {  
      
    if($("#Resuscitation").prop('checked') == false){
      $('#timeofgasp_status').bootstrapToggle('off');
      $('#regularrespiration_status').bootstrapToggle('off');
      $('#delivery_room_cpap').bootstrapToggle('off');
      $('#bag_mask_ventilator').bootstrapToggle('off');
      $('#Intubation').bootstrapToggle('off');
      $('#insertion_status').bootstrapToggle('off');
      $('#PPV').bootstrapToggle('off');
      $('#ppv_status').bootstrapToggle('off');
      $('#CPR').bootstrapToggle('off');
      $('#cpr_status').bootstrapToggle('off');
      $('#Drugs').bootstrapToggle('off');
      timeofGasps.parent().parent().slideUp(); 
      regularRespiration.parent().parent().slideUp(); 

      initialsteps.parent().slideUp(); 
      deliverycpap.parent().parent().slideUp(); 
      bagmask.parent().parent().slideUp(); 
      intubation.parent().parent().slideUp(); 
      ppv.parent().parent().slideUp(); 
      cpr.parent().parent().slideUp(); 
      drugs.parent().parent().slideUp(); 
    }else{
      timeofGasps.parent().parent().slideDown(); 
      regularRespiration.parent().parent().slideDown();
      initialsteps.parent().slideDown(); 
      deliverycpap.parent().parent().slideDown(); 
      bagmask.parent().parent().slideDown(); 
      intubation.parent().parent().slideDown(); 
      ppv.parent().parent().slideDown(); 
      cpr.parent().parent().slideDown(); 
      drugs.parent().parent().slideDown(); 
    }
   }else{
      setTimeout(function(){
          resuscitation();
      },700);
   } 

}


function intubationChanges(){

   var depthofInsertion = $('#insertion_status').parent();
    
  if(depthofInsertion.hasClass('toggle')) {  
      if($('#Intubation').prop('checked')==false) {
         $('#insertion_status').bootstrapToggle('off');
         depthofInsertion.parent().parent().slideUp();
         $('#ETTSize').attr('readonly',true).val('0').parent().parent().slideUp(); 
      }else{
         depthofInsertion.parent().parent().slideDown(); 
         $('#ETTSize').removeAttr('readonly',true).parent().parent().slideDown();
      }

  }else{
       setTimeout(function(){
          intubationChanges();
      },700);
  }    

}

function ppvChanges() {

  var ppvStatus =  $('#ppv_status').parent(); 
  if(ppvStatus.hasClass('toggle')){

      if($('#PPV').prop('checked')==false){                 
          $('#ppv_status').bootstrapToggle('off');
           ppvStatus.parent().parent().slideUp();
      }else{
          ppvStatus.parent().parent().slideDown(); 
      }

  }else{
       setTimeout(function(){
          ppvChanges();
      },700);
  }    
  
}
function ppvStatus(){

  if($('#ppv_status').prop('checked')==false){   

      $('#DurationOfPPV').attr('readonly',true).val('').parent().parent().slideUp();
  }else{
      $('#DurationOfPPV').removeAttr('readonly',true).parent().parent().slideDown();

  }
}

function cprChanges(){

  var cprStatus =  $('#cpr_status').parent(); 
  if(cprStatus.hasClass('toggle')){

      if($('#CPR').prop('checked')==false){                 
          $('#cpr_status').bootstrapToggle('off');
           cprStatus.parent().parent().slideUp();
      }else{
          cprStatus.parent().parent().slideDown(); 
      }

  }else{
       setTimeout(function(){
          cprChanges();
      },700);
  }    
    
}

function cprStatus(){

   if($('#cpr_status').prop('checked')==false){                 
         $('#duration_of_cpr').attr('readonly',true).val('').parent().parent().slideUp();
   }else{
         $('#duration_of_cpr').removeAttr('readonly',true).parent().parent().slideDown();

   }

}

function bmvchanges() {

   if ($('#bag_mask_ventilator').prop('checked') == false ) {
      $('#bag_mask_ventilator_duration').bootstrapToggle('off');
      $('label[for="bag_mask_ventilator_duration"]').parent().slideUp();
      $('#bag_mask_ventilator_duration').parent().parent().slideUp();
       bmvDurationchanges();
   } else {
      $('label[for="bag_mask_ventilator_duration"]').parent().slideDown();
      $('#bag_mask_ventilator_duration').parent().parent().slideDown();
      bmvDurationchanges();
   }
  
}

function bmvDurationchanges() {
  var idList =['bag_mask_ventilator_min'];
   $('#bag_mask_ventilator_duration').prop('checked') == false ? makeDisable(idList) : removeDisable(idList);
}

bmvchanges();

$('#bag_mask_ventilator').on('change',function() {
      bmvchanges();
});
$('#bag_mask_ventilator_duration').on('change', function() {
     bmvDurationchanges();
});

$("#Resuscitation").on('change',function(){
   resuscitation();
});

$('#Intubation').change(function(){
    intubationChanges();
});

 $('#insertion_status').change(function(){
    depthInsertion();
});

$('#PPV').change(function(){
    ppvChanges();
});  

$('#ppv_status').change(function(){
    ppvStatus();
});

$('#CPR').change(function(){
     cprChanges();
});

$('#cpr_status').change(function(){
     cprStatus();
});

resuscitation();
intubationChanges();
depthInsertion();
ppvChanges();
cprChanges();

// $('#OtherInformation').tagsinput({
//          typeahead: {
//            local: <?php echo ValuelistHelpers::autoSuggestionvalue();; ?>,
//          },
//         allowDuplicates: true,
//         trimValue: true,
//         tagClass: 'big',
//         confirmKeys: [13,44],


//     });
//  $('#OtherInvestigations').tagsinput({
//         typeahead: {
//            local: <?php echo ValuelistHelpers::autoSuggestionvalue();; ?>,
//          },
//         allowDuplicates: true,
//         trimValue: true,
//         tagClass: 'big',
//         confirmKeys: [13,44],
        

//   });

//   $('#InitialExamination').tagsinput({
//         typeahead: {
//            local: <?php echo ValuelistHelpers::autoSuggestionvalue();; ?>,
//          },
//         allowDuplicates: true,
//         trimValue: true,
//         tagClass: 'big',
//         confirmKeys: [13,44],
        

//   });

//     $('#MalformationType').tagsinput({
//         typeahead: {
//            local: <?php echo ValuelistHelpers::autoSuggestionvalue();; ?>,
//          },
//         allowDuplicates: true,
//         trimValue: true,
//         tagClass: 'big',
//         confirmKeys: [13,44],
        

//   });


// $('#Background').tagsinput({
//         typeahead: {
//            local: <?php echo ValuelistHelpers::autoSuggestionvalue();; ?>,
//          },
//         allowDuplicates: true,
//         trimValue: true,
//         tagClass: 'big',
//         confirmKeys: [13],
//         splitOn: ':',
        

//   });

// $('#PLAN').tagsinput({
//         typeahead: {
//            local: <?php echo ValuelistHelpers::autoSuggestionvalue();; ?>,
//          },
//         allowDuplicates: true,
//         trimValue: true,
//         tagClass: 'big',
//         confirmKeys: [13,44],
        

//   });

// $('#AnyOtherAbnormality').tagsinput({
//         typeahead: {
//            local: <?php echo ValuelistHelpers::autoSuggestionvalue();; ?>,
//          },
//         allowDuplicates: true,
//         trimValue: true,
//         tagClass: 'big',
//         confirmKeys: [13,44],
        

//   });




</script>
