/*
    This script will load at the time of nicu admission -> admission performa  sheet only 
*/
$('#SexBirthWtGestation').keyup(function () {
            this.value = this.value.replace(/[^0-9\s]/g, '');
          
});
$('#TemperatureAtAdmission').keyup(function () {
    this.value = this.value.replace(/[^0-9]/g, '');
});
$('#BaseExcess').keyup(function () {
    this.value = this.value.replace(/[^0-9]/g, '');
});
$('#TotalCRIB2Score').keyup(function () {
    this.value = this.value.replace(/[^0-9]/g, '');
});

var input = $('[name="SexBirthWtGestation"],[name="TemperatureAtAdmission"],[name="BaseExcess"]'),
            input1 = $('[name="SexBirthWtGestation"]'),
            input2 = $('[name="TemperatureAtAdmission"]'),
            input3 = $('[name="BaseExcess"]');
    input4 = $('[name="TotalCRIB2Score"]');
    input.change(function () {
        if (input1.val() == "") {
        input1.val(0);
        }
        if (input2.val() == "") {
        input2.val(0);
        }
        if (input3.val() == "") {
        input3.val(0);
        }
        if (input4.val() == "") {
        input4.val(0);
        }
        var sum = parseInt(input1.val()) + parseInt(input2.val()) + parseInt(input3.val());
        input4.val(sum);
    });
 

function surfactantgiven() {
  var idList=['SurfactantType','Dose','DateofAdministration','TimeOfAdministration','TimeOfAdministration_MINS','TimeOfAdministration_AM','AgeAfterBirth'];
    
  if($('#SurfactantGiven').val()=='No' || $('#SurfactantGiven').val()==''){
    $('label[for="TimeOfAdministrations"]').attr('disabled',true).parent().slideUp();
        makeDisableFade(idList);
  } else {
    $('label[for="TimeOfAdministrations"]').removeAttr('disabled').parent().slideDown();
        removeDisableFade(idList);   
  } 
}

function invasiveVentilation(){
   idList=['SurfactantGiven'];
   if($('#VentilationRequired').is(':checked') == true) {
      removeDisableFade(idList);
   }else{ 
      $('#SurfactantGiven').val('').trigger('change');
       makeDisableFade(idList); 
   }
}

function initialbloodgas(){
   var idList=['AgeTaken','pH','PaO2','PaCo2','HCO3','BE','Hct'];
   ($('#InitialBloodGas').val()=='Not done' || $('#InitialBloodGas').val()=='Not indicated')?  makeDisableFade(idList) : removeDisableFade(idList); 
}

function Uac(){
   var list=['UACPosition'];
   ($('#UAC').prop('checked')== false )? makeDisableFade(list) : removeDisableFade(list);
   uacUvc();
}

function Uvc(){
   var list=['UVCPosition'];
   ($('#UVC').prop('checked')== false)? makeDisableFade(list) : removeDisableFade(list);
   uacUvc();
}

function uacUvc(){

     var list=['AlteredLinePosition'];
     ($('#UAC').prop('checked') == false && $('#UVC').prop('checked')== false )? makeDisableFade(list) : removeDisableFade(list);
}

function NextAppointmentStatus() {
  var idList=['NextAppointment'];
  if($('#NextAppointmentStatus').prop('checked')==false){
       makeDisableFade(idList);
       $('.NextAppointmentTime').slideUp();
   }else{
       removeDisableFade(idList); 
       $('.NextAppointmentTime').slideDown();
   }
   
  
}

function DischargeDate() {
    if($('#status').val()=='Died' || $('#status').val()=='Died (OCNR)') {
     $('label[for="DischargeDate"]').text('Date of Death:');
     $('.DiedTime').show();
     $('.DischargeTransferedTime').hide();
  }else{
     $('label[for="DischargeDate"]').text('Date of Discharge / Transfered:');
     $('.DiedTime').hide();
     $('.DischargeTransferedTime').show();
  }
}

function pupils() {

    var list=['nicu_pupils_findings'];
   ($('#nicu_pupils').val() == 'Abnormal') ? removeDisableFade(list) : makeDisableFade(list);

}
// $('#AdmissionDate').change(function(){
//     calculateCorrectedGestation();
// });

function InitialXray() {
   var list=['xrayfindings','AgeofCXR'];
   ($('#InitialXray').val()=='Not done' || $('#InitialXray').val()=='Not indicated')? makeDisableFade(list) : removeDisableFade(list);

}
// function calculateCorrectedGestation()
// {
//   var dob = $('#DOB').val();
//   if (typeof dob != 'undefined' && dob != null) {
//     dob        = stringToDate(dob,'dd-mm-yyyy','-');
//     var dischargeDate = $('#AdmissionDate').datepicker('getDate');
//     var days = calculateDays(dob, dischargeDate);

//     var gestationWeeks = $('input[name="g_weeks"]').val();
//     var gestationDays = $('input[name="g_days"]').val();
//     if (gestationWeeks < 37) {

//       if (gestationDays == '' || !gestationDays) {
//         gestationDays = 0;
//       }
//       var corrected_gestation_days = ((40 - parseInt(gestationWeeks)) * 7) + parseInt(gestationDays);
//       corrected_gestation_days = days - corrected_gestation_days;
//       if (corrected_gestation_days > 0) {
//         var correctedWeeks = parseInt(parseInt(corrected_gestation_days) / 7);
//         var correctedDays = parseInt(parseInt(corrected_gestation_days) % 7);
//         if (!isNaN(correctedWeeks) && !isNaN(correctedDays)) {
//           $('input[name=cg_weeks]').val(correctedWeeks);
//           $('input[name=cg_days]').val(correctedDays);
//         }
//       }
//       else
//       {
//         $('input[name=cg_weeks]').val('');
//         $('input[name=cg_days]').val('');
//       }
//     }
//     else
//     {
//       $('input[name=cg_weeks]').val('');
//       $('input[name=cg_days]').val('');
//     }
//   } else
//   {
//     $('input[name=cg_weeks]').val('');
//     $('input[name=cg_days]').val('');
//   }

// }

$(".additional_diagnosis_add").click(function(){
    option =  '<tr>';
    option += '<td class="full-width"><input type="text" class="form-control full-width" name="additional_diagnosis[]"/></td>'; 
    option += '<td><span class="fa fa-trash btn btn-danger btn-view remove-additional-diagnosis"></span></td>';
    option += '</tr>';
    $("table.additional_diagnosis tbody").append(option);
});
$(document).on('click',".remove-additional-diagnosis",function(){
    $(this).parent('td').parent('tr').remove();
});

function typeofTreatements() {
  var l = $('select[name="TypeofTreatmen[]"]').length;
  var option  ='<tr>';
      option +='<td><select name="typeoftreatment_left[]" class="form-control" id="typeoftreatment_left'+l+'">';
      option +=$("select[name='TypeofTreatmentemp']").html();
      option +='</select></td>';
      option +='<td><select name="typeoftreatment_right[]" class="form-control" id="typeoftreatment_right'+l+'">';
      option +=$("select[name='TypeofTreatmentemp']").html();
      option +='</select></td>';
      option +='<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td></tr>';
    $("table.TypeofTreatmenDiv tbody").append(option);
}

function Ventilation() {
  var idList=['pip_set','Pip','PEEP','amplitude_delta','mean_airway_pressure','map','Rate','IT', 'fio2_set', 'Fio2', 'Flow_l_min', 'RR', 'ratio', 'frequency'];
  console.log($('#Ventilation').prop('checked'));
   ($('#Ventilation').prop('checked')==false)?  makeDisableFade(idList) : removeDisableFade(idList); 
   respiratoryMode();
}

function respiratoryMode() {
    // var mainList = ['Pip','PEEP','amplitude_delta','mean_airway_pressure','Rate','IT','fio2_set','Fio2','Flow_l_min','RR'];
    var mainList=['pip_set','Pip','PEEP','amplitude_delta','mean_airway_pressure','map','Rate','IT', 'fio2_set', 'Fio2', 'Flow_l_min', 'RR', 'ratio', 'frequency'];
    removeDisableFade(mainList);

    if ($('#Mode').val() == 7 || $('#Mode').val() == 8) {

        var npo2_hbo2 = ['pip_set','Pip','PEEP','amplitude_delta','mean_airway_pressure','map','Rate','IT', 'RR', 'ratio', 'frequency'];
        makeDisableFade(npo2_hbo2);

    } else if($('#Mode').val() == 9) {

        var cpap = ['pip_set','Pip','amplitude_delta','mean_airway_pressure','map','Rate','IT', 'fio2_set', 'Fio2', 'RR', 'ratio', 'frequency'];
        makeDisableFade(cpap);        

    } else if($('#Mode').val() == 10) {

        var nimv_nippv=['amplitude_delta','mean_airway_pressure', 'fio2_set', 'Fio2', 'Flow_l_min', 'RR', 'ratio', 'frequency'];
        makeDisableFade(nimv_nippv);

    } else if($('#Mode').val() == 11 || $('#Mode').val() == 12 || $('#Mode').val() == 13 || $('#Mode').val() == 14 || $('#Mode').val() == 15) {

        var cmv_imv_simv_psv_ac=['amplitude_delta','mean_airway_pressure','map','IT', 'Flow_l_min', 'RR', 'ratio', 'frequency'];
        makeDisableFade(cmv_imv_simv_psv_ac);

    } else if($('#Mode').val() == 16) {
        
        var hfo=['pip_set','Pip','PEEP','mean_airway_pressure', 'Rate', 'fio2_set', 'Fio2', 'Flow_l_min', 'RR'];
        makeDisableFade(hfo);

    } else {

      var notavailable=['pip_set','Pip','PEEP','amplitude_delta','mean_airway_pressure','map','Rate','IT', 'fio2_set', 'Fio2', 'Flow_l_min', 'RR', 'ratio', 'frequency'];
       makeDisableFade(notavailable);

    }

}
function malInformation() {
   var list=['nicu_malformation_details'];
   ($('#nicu_malformation').val() == 'No') ?  makeDisableFade(list) : removeDisableFade(list); 
}

function nicuropDependancy() {

   if ($('#RopScreening').val() == 'Performed') {
       $('.rop-results').slideDown();
   } else {
       $('.rop-results-type').val('');
       $('#ROPTreatment').val('No').trigger('change');
       $('#rop_follow_up').val('1');
       $('.rop-results').slideUp();
   }
}

function nicuropTreatementDependancy() {

   if($('#ROPTreatment').val() == 'Yes' && $('#RopScreening').val() == 'Performed') {

      $('.rop_treatment').slideDown();


   } else {
       $('.rop_treatment-type').val('');
       $('.rop_treatment').slideUp();
   }

}

function nicuhearingDependancy() {

   if ($('#HearingScreening').val() == 'Performed') {
       $('.hearing-screen-type').slideDown();
   } else {
       $('.hearing-screen-type-value').val('');
       $('.hearing-screen-type').slideUp();
   }
}

function getGentilafindings() {

   var list=['gentila_findings'];
   ($('#gentila').val() == 'Normal') ? makeDisableFade(list) : removeDisableFade(list); 
}


function admissionGenitlafindings() {

  var list= ['nicu_genitalia_findings'];
  ($('#nicu_genitalia').val() == 'Normal') ? makeDisableFade(list) : removeDisableFade(list);

}


$('#nicu_genitalia').change(function() {
   admissionGenitlafindings();
});

$('#gentila').change(function() {
   getGentilafindings();
});

$('#Mode').on('change', function() {
    respiratoryMode();
});

$('.typeoftreatment_add').click(function() {
    typeofTreatements();
      
});

$('#nicu_malformation').change(function() {
  malInformation();
});

$('#nicu_pupils').change(function() {
   pupils();
});

function calculateFio2() {

   var airFlow,oxygenFlow; 
   airFlow         = $('#air_flow').val();
   oxygenFlow      = $('#oxgen_flow').val();
  

   if(airFlow !='' && oxygenFlow !=''){

      var totalFlow       = parseFloat(airFlow) + parseFloat(oxygenFlow) ;
      var totalValue      = 0;
      totalValue      = ((0.2*parseFloat(airFlow)) + parseFloat(oxygenFlow));
      var calculatedValue = (totalValue / totalFlow)*100;
      $('#TransferFiO2').val(parseInt(calculatedValue));

   }

}
$('#air_flow,#oxgen_flow').blur(function(){
 calculateFio2(); 

});


var nicuarray=['Immunization','NicuNewBornScreen','HearingScreening','HomeOxygen','DischargeCUSS','ROPTreatment','NeurologicalStatus', 
              'rop_follow_up','cardiacmurmur', 'FemoralPulses', 'Hips', 'gentila', 'nicu_malformation', 'RopScreening','discharge_cuss','echocardiography_status'];
$.each(nicuarray,function(index,value){
  buildSelector(value);
});


Uac();
Uvc();
surfactantgiven();
initialbloodgas();
Ventilation();
NextAppointmentStatus();
DischargeDate();
InitialXray();
invasiveVentilation();
respiratoryMode();
malInformation();
pupils();
getGentilafindings();
admissionGenitlafindings();
// calculateCorrectedGestation();

function proceduresAdd() {

  var procedure =  '<tr>';
      procedure += '<td>';
      procedure += '<select name="procedures[]" class="form-control">';
      procedure += $('select[name="temp_procedures"]').html();
      procedure += '</select>';
      procedure += '</td>';
      procedure += '<td>';
      procedure += '<span class="fa fa-trash btn btn-danger btn-view remove"></span>';
      procedure += '</td>';
      procedure += '</tr>';
   $('.procedure-list tbody').append(procedure);   

}

function stringToDate(_date,_format,_delimiter)
{
            var formatLowerCase=_format.toLowerCase();
            var formatItems=formatLowerCase.split(_delimiter);
            var dateItems=_date.split(_delimiter);
            var monthIndex=formatItems.indexOf("mm");
            var dayIndex=formatItems.indexOf("dd");
            var yearIndex=formatItems.indexOf("yyyy");
            var month=parseInt(dateItems[monthIndex]);
            month-=1;
            var formatedDate = new Date(dateItems[yearIndex],month,dateItems[dayIndex]);
            return formatedDate;
}


function calculateAgeonadmission() {
    var admissionDate  =  $('#AdmissionDate').val();
    var dobDate        = $('#DOB').val();
    if (typeof admissionDate != 'undefined' && typeof dobDate != 'undefined') {
        dobDate        = stringToDate(dobDate,'dd-mm-yyyy','-');
        admissionDate  = stringToDate(admissionDate,'dd-mm-yyyy','-');


    // var tempDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
    var tempDays = calculateDays(dobDate, admissionDate);
   var g_weeks = $('input[name="g_weeks"]').val();
   var g_days = $('input[name="g_days"]').val();

    // correctedGestation(g_weeks, g_days, tempDays);
    // calculateCorrectedGestation();
    // if (tempDays > 0) {
      if (tempDays > 3) {
        $('.age_on_admission_hours').hide();
        $('.age_on_admission_days').show();
        // $('input[name="AgeOnAdmissioninDays"]').val(tempDays+1);
        $('input[name="AgeOnAdmissioninDays"]').val(tempDays);
      }
      else
      {
        calculateAgeonAdmissionHour();
        $('input[name="AgeOnAdmissioninDays"]').val('0');
      }
    // }
    // else
    // {
     // $('input[name="AgeOnAdmissioninDays"]').val('0');
    // }
  }
}

$('select[name=AdmissionTime_AM], select[name=AdmissionTime], select[name=AdmissionTime_MINS]').change(function(){
   calculateAgeonadmission();

   // calculateAgeonAdmissionHour();
});

$('#AdmissionDate').on('change',function() {

   calculateAgeonadmission();
   calculateCorrectedGestation();
  });
$('.procedure_add').click(function() {
   proceduresAdd();
});

$('#VentilationRequired').change(function() {
    invasiveVentilation();
});


$('#InitialXray').change(function() {
    InitialXray();

});

$('#status').change(function() {

   DischargeDate();
});

$('#Ventilation').change(function() {
    Ventilation();
});
$('#NextAppointmentStatus').change(function() {
    NextAppointmentStatus();
});

$('#SurfactantGiven').change(function() {
    surfactantgiven();
});

$('#InitialBloodGas').change(function() {
     initialbloodgas();
});

$('#UAC').change(function() {
    Uac();
});

$('#UVC').change(function() {
    Uvc();
});

$( "#admissionProforma-form" ).validate({
  rules: {

      //Basics 
      AdmissionDate: {
        required: true
      },
      AdmissionWt: {
         digits:true,
         maxlength:4,
         minlength:3,
         required: true
      },
      AgeOnAdmissioninDays: {
        digits:true,
        minlength:0,
        maxlength:3
      },
      AgeOnAdmissionhour: {
        digits:true,
        min:0,
      },
      cg_weeks: {
        digits:true,
        // maxlength:3,
        // minlength:2,
        // required: true
      },
      cg_days: {
        digits:true,
        maxlength:1,
        max:6
      },
      ip_number:{
        // ip_number_validate:true,
        // mrnumber:true,
        // minlength:0,
        // maxlength:10
        required: true
      },
      AdmissionTime:"required",
      AdmissionTime_MINS:"required",
      AdmissionTime_AM:"required",
      SeenBy:"required",
      hospital_name:"required",
      room_id:"required",
      bed_id:"required",
      initial_assessment_completed_date:"required",
      initial_assessment_completed_hr:"required",
      initial_assessment_completed_min:"required",
      initial_assessment_completed_session:"required",


      //Medical History 

      // Smoking:"required",
      // Alcohol:"required",
      // Tobacco:"required",

      //preganacy

      datinggestations:{
        digits:true,
        min:0,
        max:43
      },
      analoggestations:{
        digits:true,
        min:0,
        max:24
      },
      'othergestations[]':{
        digits:true,
        min:0,
        max:43 
      },
      'dopplergestations[]':{
        digits:true,
        min:0,
        max:43 
      },

      //Baby Details

      Dose: {
        alphanumeric:true
      },
      AgeAfterBirth: {
        digits:true
      },
      air_flow:{
        digitonedecimaltwo:true
      },
      oxgen_flow:{
        digitonedecimaltwo:true
      },
     
     //Admissions Details
      Pip:{
        digits:true,
        min:8,
        max:60
      },
      PEEP:{
        digits:true,
        min:0,
        max:15
      },
      amplitude_delta:{
        digits:true,
        min:1,
        max:100
      },
      mean_airway_pressure:{
        digits:true,
        min:4,
        max:25
      },
      Rate:{
        digits:true,
        max:600
      },
      IT:{
        onedigitonedecimal:true,
        min:0.2,
        max:1.5

      },
      Fio2: {
        digits:true,
        min:21,
        max:100 
      },
      Flow_l_min: {
        twodigitstwodecimal:true,
        min:0,
        max:12
      },
      RR: {
        digits:true,
        minlength:2,
        maxlength:3
      },
      HR: {
        digits:true,
        minlength:2,
        maxlength:3
      },
      BP:{
        digits:true,
        minlength:2,
        maxlength:3
      },
      diastolic_bp:{
        digits:true,
        minlength:2,
        maxlength:3
      },
      MeanBP: {
        digits:true,
        minlength:2,
        maxlength:3
      },
      Temperature: {
        // decimal_range_one:true,
        min:10,
        max:120
      },
      nicu_genitalia:{
        characteronly:true
      },
      nicu_pupils:{
        alphanumeric:true
      },
      AgeTaken: {
        decimal_range_two:true
      },
      SpO2: {
        // digits:true,
        min:0,
        max:100
      },
      RBS:{
        digits:true,
        minlength:1,
        maxlength:4
      },
      //procedures

      Fluids:{
        digits:true,
        min:30,
        max:999
      },
      //CRIB II
      SexBirthWtGestation:{
        digits:true,
        min:0,
        max:15
      },
      TemperatureAtAdmission:{
        // digits:true,
        // min:0,
        // max:5
      },
      BaseExcess:{
        digits:true,
        min:0,
        max:7
      },
      TotalCRIB2Score:{
        digits:true,
        min:0,
        max:27
      },
      //SNAPPE II
      TotalSNAP2Score:{
        digits:true,
        min:0,
        max:115
      },
      TotalSNAPPE2Score:{
        digits:true,
        min:0,
        max:162
      },
      // pH: {
      //   digitonedecimaltwo:true,
      //   min:6,
      //   max:8
      // },
      // PaO2: {
      //   digit:true,
      //   minlength:1,
      //   maxlength:3
      // },
      // PaCo2: {
      //   digit:true,
      //   minlength:1,
      //   maxlength:3
      // },
      // HCO3: {
      //   digitstwodecimalone:true,
      //   minlength:0,
      //   maxlength:40
      // },
      BE:{
        plusorminustwodigitstwodecimal:true,
        minlength:-50,
        maxlength:50 
      },
      //discharge details
      DischargeDate:{
        required: true
      },
      DischargeWeight:{
        digits:true,
        minlength:3,
        maxlength:4,
        required: true,
        omitZeros: true
      },
      DOLatDischarge:{
        digits:true,
        minlength:1,
        maxlength:3
      },
      OFC:{
        digitstwodecimalone:true,
        min:0,
        max:99,
        required: true,
        omitZeros: true
      },
      Length:{
        digitstwodecimalone:true,
        min:0,
        max:99,
        required: true,
        omitZeros: true
      },
      // dcg_weeks:{
      //   digits:true,
      //   min:23,
      //   max:99
      // },
      // dcg_days:{
      //   digits:true,
      //   min:0,
      //   max:6
      // },
      DischargeHb:{
        digitstwodecimalone:true,
        min:1,
        max:30
      },
      DischargePCV:{
        digitstwodecimalone:true,
        min:1,
        max:99
      },

      DischargeTSB:{
        twodigitstwodecimal:true,
        min:0,
        max:50
      },
      direct_bilirubin:{
        twodigitstwodecimal:true,
        min:0,
        max:50
      },
      DischargeSerumCa:{
        digitstwodecimalone:true,
        min:0,
        max:15
      },
      DischargeSerumPo4:{
        digitstwodecimalone:true,
        min:0,
        max:15
      },
      DischargeSerumALP:{
        digits:true,
        minlength:2,
        maxlength:4
      },
      DischargeSerumNa:{
        digits:true,
        min:99,
        max:250
      },
      hospital_acquired_infection:{
        required: true
      },
      ventilator_associated_pneumonia:{
        required: true
      },
      blood_stream_infections:{
        required: true
      }
   },
   messages:{
     AdmissionWt: {
        digits:'Admission Weight must be in digits.', 
        maxlength:'Admission Weight must be lessthan or equalto 4.',
        minlength:'Admission Weight must be greaterthan or equalto 3.'

     },
     AgeOnAdmissioninDays: {
        digits:'Age On Admission must be in digits.',
        minlength:'Age On Admission must be greaterthan or equalto 1 digits.',
        maxlength:'Age On Admission must be lessthan or equalto 3 digits.' 
     },
     AgeOnAdmissioninDays: {
        digits:'Age On Admission Hours must be in digits.',
        min:'Age On Admission Hour must be greaterthan or equalto 0.'
     },
     cg_weeks: {
        digits:'Weeks must be in digits.',
        maxlength:'Weeks must in lessthan or equal to 3 digits.',
        minlength:'Weeks must in  greaterthan or equal to 2 digits.',
     },
     cg_days: {
        digits:'Days must be in digits.',
        maxlength:'Days must in 1 digit.',
        max:'Days must in lessthan or equal to 6.'
     },
      //pregnancy
      datinggestations:{
        digits:'Dating Scan Gestation must be in digits.',
        min:'Dating Scan Gestation lessthan or equalto 43.',
        max:'Dating Scan Gestation lessthan or equalto 43.'
      },
      analoggestations:{
        digits:'Anomaly Scan Gestation must be in digits.',
        min:'Anomaly Scan Gestation lessthan or equalto 24.',
        max:'Anomaly Scan Gestation lessthan or equalto 24.'
      },
      'othergestations[]':{
         digits:'Scan Gestation must be in digits.',
         min:'Scan Gestation lessthan or equalto 43.',
         max:'Scan Gestation lessthan or equalto 43.'
      },
      'dopplergestations[]':{
        digits:'Doppler Scan Gestation must be in digits.',
        min:'Doppler Scan Gestation lessthan or equalto 43.',
        max:'Doppler Scan Gestation lessthan or equalto 43.'
      },
      //Baby Details

      ip_number:{
        ip_number_validate:'Enter valid IP number',
        mrnumber:'IP Number not allows special character except "/"',
        minlength: 'IP Number must be 10 digits!',
        maxlength:'IP Number must be 10 digits!'
      },
      Dose: {
        alphanumeric:'Dose may include character\'s and numbers.'
      },
      air_flow:{
        digitonedecimaltwo:'Air Flow may include 2 decimal values.'
      },
      oxgen_flow:{
        digitonedecimaltwo:'Oxygen Flow may include 2 decimal values.'
      },
 
      transfer_fio_liter: {
        decimal_range_two:'Fio2 Flow may include two decimal places.'
      },
      Pip:{
        digits:'Pip must be in digits.',
        min:'Pip must be greaterthan or equalto 8.',
        max:'Pip must be lessthan or equalto 60.'
      },
       PEEP:{
        digits:'Peep must be in digits.',
        min:'Peep must be greaterthan or equalto 0.',
        max:'Peep must be lessthan or equalto 15.'
      },
      amplitude_delta:{
        digits:'Amplitude must be in digits.',
        min:'Amplitude must greaterthan or equalto 1.',
        max:'Amplitude must lessthan or equalto 100.'
      },
      mean_airway_pressure:{
        digits:'Mean Airway Pressure must be in digits.',
        min:'Mean Airway Pressure must greaterthan or equalto 4.',
        max:'Mean Airway Pressure must lessthan or equalto 25.',
      },
      Rate:{
        digits:'Rate must be in digits.',
        max:'Rate must lessthan or equalto 600.'
      },
      IT:{
        onedigitonedecimal:'IT may include one digits and one decimal.',
        min:'IT must be greater than or equalto 0.2.',
        max:'IT must be lessthan  or equalto 1.5.'
        
      },
      Fio2:{
        digits:'FIO2 must be digits.',
        min:'FIO2 must be greaterthan or equalto 21.',
        max:'FIO2 must be lessthan or equalto 100.',
      },
      Flow_l_min: {
        twodigitstwodecimal:'Flow may include 2 digits and 2 decimal.',
        min:'Flow must be greaterthan or equalto 0.',
        max:'Flow must be lessthan or equalto 12.'
      },
      RR: {
        digits:'RR must be in digits.',
        minlength:'RR must be greaterthan or equalto 2 digits.',
        maxlength:'RR must be lessthan or equalto 3 digits.'
      },
      HR: {
        digits:'HR must be in digits.',
        minlength:'HR must be greaterthan or equalto 2 digits.',
        maxlength:'HR must be lessthan or equalto 3 digits.'
      },
      BP:{
        digits:'Systolic BP must be in digits',
        minlength:'Systolic BP must be greaterthan or equalto 2 digits.',
        maxlength:'Systolic BP must be lessthan or equalto 3 digits.'
      },
      diastolic_bp:{
        digits:'Diastolic BP must be in digits',
        minlength:'Diastolic BP must be greaterthan or equalto 2 digits.',
        maxlength:'Diastolic BP must be lessthan or equalto 3 digits.'
      },
      MeanBP: {
        digits:'Mean BP must be in digits',
        minlength:'Mean BP must be greaterthan or equalto 2 digits.',
        maxlength:'Mean BP must be lessthan or equalto 3 digits.'
      },
      Temperature: {
        decimal_range_one:'Temperature may include 3 digits with 1 decimal places.',
        min:'Temperature must be greaterthan or equalto 10.',
        max:'Temperature must be lessthan or equalto 120.'
      },
      nicu_genitalia:{
        characteronly:'Genitalia must be character.'
      },
      nicu_pupils:{
        alphanumeric:'Pupils must be character or numbers.'
      },
      SpO2: {
        // digits:'SpO2 must be digits.',
        min:'SpO2 must be greaterthan or equalto 0.',
        max:'SpO2 must be lessthan or equalto 100.'
      },
      // pH: {
      //   digitonedecimaltwo:'pH can be 1 digits and 2 decimal.',
      //   min:'pH must be greaterthan or equalto 6.',
      //   max:'pH must be lessthan or equalto 8.'
      // },
      // PaO2: {
      //   digit:'PaO2 must be digits.',
      //   minlength:'PaO2 must be greaterthan or equalto 1 digit.',
      //   maxlength:'PaO2 must be lessthan or equalto 3 digits.'
      // },
      // PaCo2: {
      //   digit:'PaCo2 must be digits.',
      //   minlength:'PaCo2 must be greaterthan or equalto 1 digit.',
      //   maxlength:'PaCo2 must be lessthan or equalto 1 digits.'
      // },
      // HCO3: {
      //   digitstwodecimalone:'HCO3 can be 2 digits and 1 decimal.',
      //   minlength:'HCO3 must be greaterthan or equalto 0.',
      //   maxlength:'HCO3 must be lessthan or equalto 40.'
      // },
      // BE:{
      //   digitstwodecimaloneplus:'BE can be +/- with 2 digits 1 decimal.',
      //   minlength:'BE must be greaterthan or equalto -50.',
      //   maxlength:'BE must be lessthan or equalto 50.' 
      // },
      RBS:{
        digits:'RBS must be digits.',
        minlength:'RBS must be greaterthan or equalto 1 digit.',
        maxlength:'RBS must be lessthan or equalto 4 digits.'
      },
      Fluids:{
        digits:'Fluids/Feeds must be digits.',
        min:'Fluids/Feeds must be greaterthan or equalto 30.',
        max:'Fluids/Feeds must be lessthan or equalto 999.'
      },
      SexBirthWtGestation:{
        digits:'Sex,Birth Wt & Gestation must be in digits.',
        min:'Sex,Birth Wt & Gestation must be greaterthan or equalto 0.',
        max:'Sex,Birth Wt & Gestation must be lessthan or equalto 15.'
      },
      TemperatureAtAdmission:{
        // digits:'Temperature At Admission must be in digits.',
        // min:'Temperature At Admission must be greaterthan or equalto 0.',
        // max:'Temperature At Admission must be lessthan or equalto 5.'
      },
      BaseExcess:{
        digits:'BaseExcess must be in digits.',
        min:'BaseExcess must be greaterthan or equalto 0.',
        max:'BaseExcess must be lessthan or equalto 7.'
      },
      TotalCRIB2Score:{
        digits:'Total CRIB II Score must be in digits.',
        min:'Total CRIB II Score must be greaterthan or equalto 0.',
        max:'Total CRIB II Score must be lessthan or equalto 27.'
      },
      TotalSNAP2Score:{
        digits:'Total SNAP II Score must be in digits.',
        min:'Total SNAP II Score must be greaterthan or equalto 0.',
        max:'Total SNAP II Score must be lessthan or 115'
      },
      TotalSNAPPE2Score:{
        digits:'Total SNAPPE II Score must be in digits.',
        min:'Total SNAPPE II Score must be greaterthan or equalto 0.',
        max:'Total SNAPPE II Score must be lessthan or equalto 162.'
      },
      DischargeWeight:{
        digits:'Discharge Weight must be digits.',
        minlength:'Discharge Weight must greaterthan or equalto 3 digits.',
        maxlength:'Discharge Weight must lessthan or equalto 4 digits.',
        omitZeros: 'Invalid Weight'
      },
      DOLatDischarge:{
        digits:'DOL at Discharge must be digits.',
        minlength:'DOL at Discharge must greaterthan or equalto 1 digit.',
        maxlength:'DOL at Discharge must lessthan or equalto 3 digit.'
      },
      OFC:{
        digitstwodecimalone:'OFC in cm can be 2 digits and 1 decimal places.',
        min:'OFC in cm must be greaterthan or equalto 0.',
        max:'OFC in cm must be lessthan or equalto 99.',
        omitZeros: 'Invalid OFC'
      },
      Length:{
        digitstwodecimalone:'Length in cm can be 2 digits and 1 decimal places.',
        min:'Length in cm must greaterthan or equalto 0.',
        max:'Length in cm must lessthan or equalto 99.',
        omitZeros: 'Invalid Length'
      },
      // dcg_weeks:{
      //   digits:'Weeks must be in digits. ',
      //   min:'Weeks must be greaterthan or equalto 23.',
      //   max:'Weeks must be lessthan or equalto 99.'
      // },
      // dcg_days:{
      //   digits:'Days must be in digits. ',
      //   min:'Days must be greaterthan or equalto 0.',
      //   max:'Days must be lessthan or equalto 6.'
      // },
      DischargeHb:{
        digitstwodecimalone:'HB(g/dl) can be 2 digits and 1 decimal places.',
        min:'HB(g/dl) must be greaterthan or equalto 1',
        max:'HB(g/dl) must be lessthan or equalto 30'
      },
      DischargePCV:{
        digitstwodecimalone:'PCV can be 2 digits and 1 decimal places.',
        min:'PCV must be greaterthan or equalto 1.',
        max:'PCV must be lessthan or equalto 99.'
      },
      DischargeTSB:{
        twodigitstwodecimal:'Total Serum Bilirubin can be 2 digits and 2 decimal places.',
        min:'Total Serum Bilirubin must be greaterthan or equalto 0.',
        max:'Total Serum Bilirubin must be lessthan or equalto 50.'
      },
      direct_bilirubin:{
         twodigitstwodecimal:'Direct Bilirubin (mg/dl) can be 2 digits and 2 decimal places.',
         min:'Direct Bilirubin (mg/dl) must be greaterthan or equalto 0.',
         max:'Direct Bilirubin (mg/dl) must be lessthan or equalto 50.'
      },
      DischargeSerumCa:{
         digitstwodecimalone:'Ca (mg/dl) can be 2 digits and 1 decimal places.',
         min:'Ca (mg/dl) must be greaterthan or equalto 0.',
         max:'Ca (mg/dl) must be lessthan or equalto 15.'
      },
      DischargeSerumPo4:{
         digitstwodecimalone:'Po4 (mg/dl) can be 2 digits and 1 decimal places.',
         min:'Po4 (mg/dl) must be greaterthan or equalto 0.',
         max:'Po4 (mg/dl) must be lessthan or equalto 15.'
      },
      DischargeSerumALP:{
        digits:'ALP (IU/L) must be digits.',
        minlength:'ALP (IU/L) must be greaterthan or equalto 2 digits.',
        maxlength:'ALP (IU/L) must be greaterthan or equalto 4 digits.',

      },
      DischargeSerumNa:{
        digits:'Na (mmol/l) must be digits.',
        min:'Na (mmol/l) must be greaterthan or equalto 99.',
        max:'Na (mmol/l) must be lessthan or equalto 250.'
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
function makeDisableFade(idList) {
     $.each(idList,function(key,value){
        if($('#'+value).attr('type')=='text'){
          //$('#'+value).val('');
        }
      $('#'+value).attr('disabled',true).parent().parent().hide();
   });
}

function removeDisableFade(idList){
     $.each(idList,function(key,value){

      $('#'+value).removeAttr('disabled').parent().parent().show();

   });
}
$('input[name="datingdate"], input[name="analogdate"], input[name^="otherdate"], input[name^="dopplerdate"]').datepicker({
    dateFormat: 'dd-mm-yy',
    yearRange: "-60:+02",
    changeMonth: true,
    changeYear: true,
    maxDate: '+0M',
});
