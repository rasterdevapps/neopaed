

function postnatalUacstatus() {
  var list = ['uac_position'];
   ($('#uac_status').prop('checked') == true) ? removeDisable(list) : makeDisable(list) ;

}
function postnatalUvcstatus() {
  var list = ['uvc_position'];
   ($('#uvc_status').prop('checked') == true) ? removeDisable(list) : makeDisable(list) ;

}

function postnatalinitialbloodgas() {

   var list = ['agetaken', 'ph', 'pao2', 'paco2', 'hco3', 'be', 'hct'];
   ($('#initialbloodgas').val() == 'Not done' || $('#initialbloodgas').val() == 'Not indicated') ?  makeDisable(list) : removeDisable(list);
  
}

function admissionGenitalia() {

   var list = ['genitalia_findings'];
   ($('#genitalia').val() == 'Normal') ? makeDisable(list) : removeDisable(list);
}


function Ventilation() {
  var idList=['pip','peep','rate','it','amplitude','mean_airway_pressure'];
   ($('#ventilation').prop('checked')==false)?  makeDisable(idList) : removeDisable(idList); 
   respiratorymode();
}

function respiratorymode() {
    var mainList = ['pip','peep','amplitude','mean_airway_pressure','rate','it','fio2','flow','rr'];
     removeDisable(mainList);
    if($('#mode').val() == 6) {

       var sva = ['pip','peep','amplitude','mean_airway_pressure','rate','it','fio2','flow'];
       makeDisable(sva);

    } else if($('#mode').val() == 7 || $('#mode').val() == 8) {

       var npo2 = ['pip','peep','amplitude','mean_airway_pressure','rate','it'];
       makeDisable(npo2);

    } else if($('#mode').val() == 9) {

        var cpap = ['pip','amplitude','mean_airway_pressure','rate','it'];
        makeDisable(cpap);

    } else if($('#mode').val() == 10 || $('#mode').val() == 11 || $('#mode').val() == 12 || $('#mode').val() == 13 || $('#mode').val() == 14) {

        var nimv = ['amplitude'];
        makeDisable(nimv);

    } else if($('#mode').val() == 15) {

        var ac = ['amplitude','rate'];
        makeDisable(ac);

    } else if($('#mode').val() == 16) {

        var hfo = ['pip','peep'];
        makeDisable(hfo);

    } else if($('#mode').val() == 17) {

        var hfnc = ['pip','peep','amplitude','mean_airway_pressure','rate','it'];
        makeDisable(hfnc);
        
    } else if($('#mode').val() == '') {

       var notavailable = ['pip','peep','amplitude','mean_airway_pressure','rate','it','fio2','flow'];
       makeDisable(notavailable);

    }

}

respiratorymode();

// function calculateCorrectedGestation()
// {
//   var dob = $('#DOB').val();
//   dob        = stringToDate(dob,'dd-mm-yyyy','-');
//   var dischargeDate = $('#admission_date').datepicker('getDate');
//   var days = calculateDays(dob, dischargeDate);
  
//   var gestationWeeks = $('input[name="g_weeks"]').val();
//   var gestationDays = $('input[name="g_days"]').val();
//   if (gestationWeeks < 37) {

//       if (gestationDays == '' || !gestationDays) {
//         gestationDays = 0;
//       }
//       var corrected_gestation_days = ((40 - parseInt(gestationWeeks)) * 7) + parseInt(gestationDays);
//         corrected_gestation_days = days - corrected_gestation_days;

//         if (corrected_gestation_days > 0) {
//             var correctedWeeks = parseInt(parseInt(corrected_gestation_days) / 7);
//             var correctedDays = parseInt(parseInt(corrected_gestation_days) % 7);
        
//             if (!isNaN(correctedWeeks) && !isNaN(correctedDays)) {

//                 $('input[name=cg_weeks]').val(correctedWeeks);
//                 $('input[name=cg_days]').val(correctedDays);
//             }
//         }
//         else
//         {
//             $('input[name=cg_weeks]').val('');
//             $('input[name=cg_days]').val('');
//         }
//   }
//   else
//   {
//         $('input[name=cg_weeks]').val('');
//         $('input[name=cg_days]').val('');

//   }

// }

function stringToDate(_date,_format,_delimiter)
{
            var formatLowerCase=_format.toLowerCase();
            var formatItems=formatLowerCase.split(_delimiter);
           if (typeof _date != 'undefined') {
            var dateItems=_date.split(_delimiter);
            var monthIndex=formatItems.indexOf("mm");
            var dayIndex=formatItems.indexOf("dd");
            var yearIndex=formatItems.indexOf("yyyy");
            var month=parseInt(dateItems[monthIndex]);
            month-=1;
            var formatedDate = new Date(dateItems[yearIndex],month,dateItems[dayIndex]);
          }
            return formatedDate;
}

function calculateAgeonadmission() {
    var admissionDate  =  $('#admission_date').val();
    var dobDate        = $('#DOB').val();
    if (typeof dobDate != "undefined" || typeof admissionDate != "undefined") {
        dobDate        = stringToDate(dobDate,'dd-mm-yyyy','-');
        admissionDate  = stringToDate(admissionDate,'dd-mm-yyyy','-');
    var tempDays       = calculateDays(dobDate,admissionDate);
    $('#ageonadmissionindays').val(tempDays);

   var g_weeks = $('input[name="g_weeks"]').val();
   var g_days = $('input[name="g_days"]').val();

    // correctedGestation(g_weeks, g_days, tempDays);
    }

}

function pupils() {
   var list=['nicu_pupils_findings'];
   ($('#nicu_pupils').val() == 'Abnormal') ? removeDisable(list) : makeDisable(list);
}


function initialxray() {

  var list=['xrayfindings','ageofcxr'];
  ($('#initialxray').val()=='Not done' || $('#initialxray').val()=='Not indicated')? makeDisable(list) : removeDisable(list);

}

function sepsisscreen() {

   if ($('#sepsisscreen').val() == 'No' || $('#sepsisscreen').val() == '') {
     
      $('#indications').attr('disabled',true).parent().parent().slideUp();
      $('.IVAntibiotic').parent().parent().slideUp();
      $('.ivantibitic_add').attr('disabled',true).slideUp();
      
   } else {

      $('#indications').removeAttr('disabled').parent().parent().slideDown();
      $('.IVAntibiotic').parent().parent().slideDown();
      $('.ivantibitic_add').removeAttr('disabled').slideDown();
   }

}

$('#sepsisscreen').change(function() {
  sepsisscreen();
});

$('#initialxray').change(function() {
  initialxray();
});



$('#nicu_pupils').change(function() {
   pupils();
});

$('#ventilation').change(function() {
     Ventilation();
});

$('#mode').change(function() {
    respiratorymode();
});


$('#uvc_status').change( function() {
   postnatalUvcstatus();
});

$('#uac_status').change( function() {
   postnatalUacstatus();
});

$('#initialbloodgas').change(function() {

    postnatalinitialbloodgas();
});

$('#admission_date').change(function() {
   calculateAgeonadmission();
   calculateCorrectedGestation();
});

$('#genitalia').change(function() {
    admissionGenitalia();
});

$(document).on('click', ".additional_diagnosis_add",function() {
    option =  '<tr>';
    option += '<td><input type="text" class="form-control full-width" name="additional_diagnosis[]"/></td>'; 
    option += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>';
    option += '</tr>';
    $("table.additional_diagnosis tbody").append(option);
});

 initialxray();
 postnatalUvcstatus();
 postnatalUacstatus();
 postnatalinitialbloodgas();
 calculateAgeonadmission();
 sepsisscreen();
 admissionGenitalia();
 pupils();
 // calculateCorrectedGestation();

var seletorArray = ['nicu_retractions','nicu_airentry','chest_movement','nicu_central_pulses','nicu_peripheral_pulses',
                    'nicu_femoral_pulses','s1s2','nicu_murmur','cft','nicu_color','nicu_abdomen','nicu_bowel_sounds','nicu_hepatomegaly',
                    'nicu_splenomegaly','genitalia','nicu_pupils','nicu_anteriorfontanelle','tone','nicu_seizures','nicu_neonatalreflexes'];
                 
$.each(seletorArray,function(index,value){
  
    buildSelector(value);

}); 

$( "#admissionProforma-form" ).validate({
  rules: {

      hospital_name:"required",
      cg_weeks:"required",
      cg_days:"required",
      admission_date:"required",
      admission_wt:"required",
      ip_number:{
        mrnumber:true,
        // minlength:10,
        // maxlength:10
      },
      discharge_date:"required",
      dcg_weeks:"required",
      dcg_days:"required",
      // discharge_wt:"required",
      // discharge_ofc:"required",
      // discharge_length:"required",

   },
   messages:{
     
     ip_number:{
        mrnumber:'IP Number not allows special character except "/"',
        minlength: 'IP Number must be 10 digits!',
        maxlength:'IP Number must be 10 digits!'
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



// $('#admission_date').change(function(){
//       calculateCorrectedGestation();
//   });

// function calculateCorrectedGestation()
// {
//   var dob = $('#DOB').val();
//   dob= stringToDate(dob,'dd-mm-yyyy','-');
//   var dischargeDate = $('#admission_date').datepicker('getDate');
//   var days = calculateDays(dob, dischargeDate);
//   var gestationWeeks = $('input[name="g_weeks"]').val();
//   var gestationDays = $('input[name="g_days"]').val();
//   var total_gestation_days = parseInt(gestationWeeks) * 7;
//   total_gestation_days = parseInt(gestationDays) + total_gestation_days + days;
//   var correctedWeeks = parseInt(parseInt(total_gestation_days) / 7);
//   var correctedDays = parseInt(parseInt(total_gestation_days) % 7);
//   if (!isNaN(correctedWeeks)) {
//     $('input[name=cg_weeks]').val(correctedWeeks);
//   }
//   if (!isNaN(correctedDays)) {
//     $('input[name=cg_days]').val(correctedDays);
//   }
// }
