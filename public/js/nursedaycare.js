var nurseday = ['Care','Frequency','UrineOutput','StoolNature','TypeofFeeds','AspirateNature', 'NNJTreatment', 'Immunoglobulins', 'Tpn', 'Transfusion', 'Sepsis', 'lumbar_puncture', 'PeripheralCannula', 'Picc', 'Uvc', 'Uac', 'Pac', 'UvcPosition', 'UacPosition'];

$.each(nurseday,function(index,value){

	buildSelector(value);

});

function nurseEtube(){

 var list=['Size','Lips'];
  ($('#EtTube').prop('checked')==true) ? removeDisable(list) : makeDisable(list);

}

function ivFluidshourToday() {
  var ivFluids = $('#iv_fluids').val();
  console.log(ivFluids);
  if(ivFluids!='') {
    var resultFluid=parseFloat(ivFluids)*24;
    console.log(resultFluid);
    if(!isNaN(resultFluid)) {
    console.log(parseInt(resultFluid));
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

function calulateFludes() {

   var iv_fluids    = $('#iv_fluids_ml_day').val();
   //var drug_infusions = $('#drug_infusions_ml_day').val();
  // var other_drugs = $('#other_drugs').val();
   var workingweight = $('#workingWeight').val();
   var ivf = parseInt(iv_fluids)/(parseInt(workingweight)/1000);
   //var Ivf = (parseInt(iv_fluids)+parseInt(drug_infusions)+parseInt(other_drugs))/(parseInt(workingweight)/1000);
   if(!isNaN(ivf)) {
     $('#Ivf').val(ivf.toFixed(2));
     totalfluides();
   } 

}
function totalfluides() {
  var iv_fluids      = $('#iv_fluids_ml_day').val();
  var drug_infusions = $('#drug_infusions_ml_day').val();
  var other_drugs    = $('#other_drugs').val();
  var workingweight  = $('#workingWeight').val();

  var iv = (parseInt(iv_fluids)+parseInt(drug_infusions)+parseInt(other_drugs)) / (workingweight/1000);
  var fe = $('#Feeds').val();
   if(!isNaN(parseInt(iv)) && !isNaN(parseInt(fe))) {
    var totalFluid = parseInt(iv)+parseInt(fe);

    $('#TotalFluid').val(totalFluid.toFixed(2));
   }  
}

function calculateAmc() {
  var tlc         =  $('#TLC').val().trim();
  var Percentage  = $('#Percentage').val().trim();
  var amc         = (tlc*Percentage)/100;
  $('#ANC').val(parseInt(amc));

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

function sepsis_changes() {
  var list = ['CRP','TLC','Percentage','ANC','Platelets'];
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

function calculateFeeds() {

 var volume    = $('#Volume').val();
 var frequency = $('#Frequency').val();
 var workingweight = $('#workingWeight').val();
 
 var feeds = ((24/parseFloat(frequency))*parseFloat(volume))/(parseFloat(workingweight)/1000);
  if(!isNaN(feeds) && frequency !=0 && frequency !=5) {
      $('#Feeds').val(feeds.toFixed(1));
     totalfluides();
  } else {
      $('#Feeds').val('0.0');
  }  
}

sepsis_changes();
nurseEtube();
PeripheralCannula();
Picc();
daycare_uvc();
daycare_uac();
daycare_pac();
calculateFeeds();

$('#Sepsis').change(function() {
    sepsis_changes(); 
});

$(".product_add").click(function() {
  var option = '<tr><td><select class="form-control" name="F_Product[]"><option value="">N/A</option><option value="Packed RBC">Packed RBC</option><option value="Whole Blood">Whole Blood</option><option value="Platelet Concentrate">Platelet Concentrate</option><option value="Fresh Frozen Plasma">Fresh Frozen Plasma</option><option value="Cryoprecipitate">Cryoprecipitate</option><option value="Washed maternal platelets">Washed maternal platelets</option><option value="NAIT - special platelets">NAIT - special platelets</option><option value="Immunoglobulin">Immunoglobulin</option></select></td>';
    option += '<td><input type="number" class="input-width-mini form-control" name="F_Volume[]" value="" /></td>';
    option += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>';
    option += '</tr>';
  $("table.product tbody").append(option);
});

$('#iv_fluids,#drug_infusions,#other_drugs').on('blur',function(){
   calulateFludes();
});

$('#EtTube').change(function(){
     nurseEtube();
});

$('#iv_fluids').on('blur',function(){
     ivFluidshourToday();
});

$('#drug_infusions').on('blur',function(){
     drugInfutionhourToday();
});

$('#TLC,#Percentage').on('blur',function(){
     calculateAmc();
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
$('#Frequency,#workingWeight,#Volume').on('change',function(){

    calculateFeeds();
});


$( "#nurse-daycare" ).validate({
  rules: {
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
  	DayOfLife:{
  		digits:true
  	},
  	cg_weeks:{
        digits:true,
        minlength:1,
  	},
  	cg_days:{
        digits:true,
        min:0,
        max:6
  	},
  	FiO2:{
       digits:true,
       min:21,
       max:100
  	},
  	RR:{
  	   digits:true,
  	   minlength:1 ,
  	   maxlength:3	
  	},
    Flow:{
   	   digitstwodecimalone:true,
   	   min:0.1,
   	   max:12
   },
   SaO2PostDuctal:{
   	   digits:true,
   	   min:0,
   	   max:100
   },
   Lips:{
   	   digitstwodecimalone:true,
   	   min:0,
   	   max:99
   },
   HR:{
     digits:true,
   	 minlength:2,
   	 maxlength:3
   },
   systolic_bp:{
   	 digits:true,
   	 minlength:2,
   	 maxlength:3
   },
   diastolic_bp:{
   	 digits:true,
   	 minlength:2,
   	 maxlength:3
   },
   MeanBP:{
   	 digits:true,
   	 minlength:2,
   	 maxlength:3
   },
   CentralTemperature:{
   	decimal_range_one:true,
   	min:10,
   	max:120
   },
   PeripheralTemperature:{
   	decimal_range_one:true,
   	min:10,
   	max:120
   },
   Volume:{
      decimal_range_one:true,
      min:0,
      max:150
   },
   AspirateVolume:{
    decimal_range_one:true,
    min:0,
    max:999
   },
   AbdominalGirth:{
    digitstwodecimalone:true,
    min:0,
    max:99
   },
   TSB:{
    digitstwodecimalone:true,
    min:0,
    max:50
   },
   PreviousWt:{
    digits:true,
    minlength:3,
    maxlength:4
   },
   CurrentWt:{
    digits:true,
    minlength:3,
    maxlength:4
   },
   BloodOut:{
    decimal_range_one:true,
    min:0,
    max:999
   },
   DrainOutput:{
    decimal_range_one:true,
    min:0,
    max:999
   },
   RBS:{
    fourdigitsonedecimal:true,
    min:0,
    max:9999

   }



  },
  messages: {
    DayDate:{
  		required:'Date of Record is mandatory.'
  	},
  	DayTime:{
  		required:'Time of Record is mandatory.'
  	},
    DayTime_MINS:{
  		required:'Time of Record is mandatory.'
  	},
  	DayTime_AM:{
  		required:'Time of Record is mandatory.'
  	},
  	DayOfLife:{
  		digits:'Day of Life must be digits.'
  	},
  	cg_weeks:{
        digits:'Weeks must be digits.'
  	},
  	cg_days:{
        digits:'Weeks must be digits.'
  	},
  	cg_weeks:{
        digits:'Weeks must be digits.',
        minlength:'Weeks must be greater than or equalto 1 digit.',
  	},
  	cg_days:{
        digits:'Days must be digits.',
        min:'Days must be greater than or equalto 0.',
        max:'Days must be less than or equalto 6.'
  	},
  	FiO2:{
       digits:'FiO2 must be digits',
       min:'FiO2 greater than or equalto 21.',
       max:'FiO2 less than or equalto 100.'
  	},
  	RR:{
  	   digits:'Respiratory Rate must be digits.',
  	   minlength:'Respiratory Rate must be greater than or equalto 1 digits.',
  	   maxlength:'Respiratory Rate must be less than or equalto 3 digits.'	
  	},
  	Flow:{
   	   digitstwodecimalone:'Flow can be 2 digits and 1 decimal.',
   	   min:'Flow must be greater than or equalto  0.1.',
   	   max:'Flow must be less than or equalto  12.'
    },
    SaO2PostDuctal:{
   	   digits:'SaO2 Post Ductal must be digits.',
   	   min:'SaO2 Post Ductal must be greater than or equalto 0.',
   	   max:'SaO2 Post Ductal must be less than or equalto 100.'
    },
    Lips:{
   	   digitstwodecimalone:'Cm at Lips can be 2 digits and 1 decimal.',
   	   min:'Cm at Lips must be greater than or equalto 0.',
   	   max:'Cm at Lips must be less than or equalto 99.'
    },
    HR:{
     digits:'HR must be digits,',
   	 minlength:'HR must be greater than or equalto 2 digits.',
   	 maxlength:'HR must be less than or equalto 3 digits.'
    },
    systolic_bp:{
   	 digits:'Systolic BP must be digits,',
   	 minlength:'Systolic BP must be greater than or equalto 2 digits.',
   	 maxlength:'Systolic BP must be less than or equalto 3 digits.'
    },
    diastolic_bp:{
   	 digits:'Diastolic BP must be digits,',
   	 minlength:'Diastolic BP must be greater than or equalto 2 digits.',
   	 maxlength:'Diastolic BP must be less than or equalto 3 digits.'
    },
    MeanBP:{
   	 digits:'Mean BP must be digits,',
   	 minlength:'Mean BP must be greater than or equalto 2 digits.',
   	 maxlength:'Mean BP must be less than or equalto 3 digits.'
    },
    CentralTemperature:{
   	decimal_range_one:'Central Temperature can be 3 digits and 1 decimal.',
   	min:'Central Temperature must be greater than or equalto 10.',
   	max:'Central Temperature must be less than or equalto 120.'
   },
   PeripheralTemperature:{
   	decimal_range_one:'Peripheral Temperature can be 3 digits and 1 decimal..',
  	min:'Peripheral Temperature must be greater than or equalto 10.',
   	max:'Peripheral Temperature must be less than or equalto 120.'
   },
   Volume:{
    decimal_range_one:'Volume can be 3 digits and 1 decimal places.',
    min:'Volume must be greater than or equalto 0.',
    max:'Volume must be less than or equalto 150.'
   },
   AspirateVolume:{
    decimal_range_one:'Aspirate Volume can be 3 digits and 1 decimal places.',
    min:'Aspirate Volume must be greater than or equalto 0.',
    max:'Aspirate Volume must be less than or equalto 999.',
   },
    AbdominalGirth:{
    digitstwodecimalone:'Abdominal Girth can be 2 digits and 1 decimal places.',
    min:'Abdominal Girth must be greater than or equalto 0.',
    max:'Abdominal Girth must be less than or equalto 99.'
   },
   TSB:{
    digitstwodecimalone:'Maximum Bilirubin can be 2 digits and 1 decimal places.',
    min:'Maximum Bilirubin must be greater than or equalto 0.',
    max:'Maximum Bilirubin must be less than or equalto 50.'
   },
   PreviousWt:{
    digits:'Previous Weight must be digits.',
    minlength:'Previous Weight must be greater than or equalto 3 digits.',
    maxlength:'Previous Weight must be less than or equalto 4 digits.',
   },
   CurrentWt:{
    digits:'Current Weight must be digits.',
    minlength:'Current Weight must be greater than or equalto 3 digits.',
    maxlength:'Current Weight must be less than or equalto 4 digits.',
   },
   BloodOut:{
    decimal_range_one:'Blood Out can be 3 digits and 1 decimal places.',
    min:'Blood Out must be greater than or equalto 0.',
    max:'Blood Out must be less than or equalto 999.'
   },
   DrainOutput:{
    decimal_range_one:'Drain Output can be 3 digits and 1 decimal places.',
    min:'Drain Output must be greater than or equalto 0.',
    max:'Drain Output must be less than or equalto 999.'
   },
   RBS:{
    fourdigitsonedecimal:'RBS can be 4 digits and 1 decimal places.',
    min:'RBS must be greater than or equalto 0',
    max:'RBS must be less than or equalto 9999'

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
