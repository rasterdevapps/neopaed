function Multiplepregnancy(){

   var idList=['MultiplePregnancyType','BirthOrder','Noofbabies']; 
   ($( "#MultiplePregnancy" ).val() == 'No') ? makeDisable(idList) : removeDisable(idList);
}


Multiplepregnancy();

$('#MultiplePregnancyType').change(function(){
	 var mnps=$(this).val();
   if(mnps != ''){
    mnps = mnps.slice(0,-1);
     bootbox.confirm('Note: Choosing this option will create '+mnps+' babies !',function(confirm){
	      if(confirm){
                createBirthorder();
          }else{
            	$('select[name="MultiplePregnancyType"]').val('');
          }
     });
    }else{
      $( "#MultiplePregnancy" ).val('No');
      Multiplepregnancy();
    } 	

});



function createBirthorder(){
	var birthOrder = MptypeNobabies(true);
	var birthOptions = '<option value="">--Select--</option>';
	$.each(birthOrder,function(index,value){
		birthOptions += "<option value='"+value+"'>"+value+"</option>";
	}); 
	$('select[name="BirthOrder"]').html(birthOptions); 
}



$('#MultiplePregnancy').on('change', function() {

   Multiplepregnancy();

});

$("#baby_reg_form").validate({
  rules:{
      BMrNo:{
          mrnumber:true,
          required: true,
          maxlength: function(element) {
            var mrn = $('#BMrNo').val();
            if(mrn.substring(0, 3) == 'SNH') {
              return 9;
            } else{
              return 6;
            }  
          },
          minlength: function(element) {
            var mrn = $('#BMrNo').val();
            if(mrn.substring(0, 3) == 'SNH') {
              return 9;
            } else{
              return 6;
            }  
          }
      },
      BabyName:{
          characterwithslash:true
      },
      admission_date: {
        required: true
      },
      DOB: {
        required: true
      },
	   	MultiplePregnancyType:{
	   	 	  required:function(element){
	   	 	  	 if($('#MultiplePregnancy').val()=='Yes'){
	   	 	  	 	return true;
	   	 	  	 }else{
	   	 	  	 	return false;
	   	 	  	 }  
	   	 	  },
     	 },
     	Noofbabies:{
	   	  	required: function(element){
	   	 	  	 if($('#MultiplePregnancy').val()=='Yes'){
	   	 	  	 	return true;
	   	 	  	 }else{
	   	 	  	 	return false;
	   	 	  	 }  
	   	 	  },
	   	  	max: function(element){
                  return MptypeNobabies(false);
	   	  	},   
	   	},
      BirthOrder:{
          required:function(element){
             if($('#MultiplePregnancy').val()=='Yes'){
              
              return true;
           
             }else{
              
              return false;
            
             }  

          } 
      },
      Sex:{
        required: true
      },
      'neonatal_consultant[]':{
              required:true,
      },
      BirthWeight:{
              digits:true, 
              maxlength:4,
              minlength:3,
              required: true
      },
      g_weeks:{
            max:43,
            min:23,
            required:true
      },
      g_days:{
            max:6,
            min:0,
            // required:true
      },
      ward_name:{
        required: true
      },
      room_no:{
        required: true
      },
      bed_no:{
        required: true
      }

  },
  messages:{
       BMrNo:{
           mrnumber:'Enter only alpha numeric and special character "/" ',
           required:'Enter MRN Number !',
           // maxlength:'MRN Number must be 6 Digits !',
           // minlength:'MRN Number must be 6 Digits !'
      },
      BabyName:{
          characterwithslash:'Enter only alpha numeric and special character "/" '
      },
      MultiplePregnancyType:{
      	   required:'Select multiple pregnancy type !'
      },
      Noofbabies:{
      	   required:'Enter no of babies admitted !',
      	   max:'Enter the value based on multiple pregnancy type !',
      },
      BirthOrder:{
           required:'Select a birth order !'
      },
      'neonatal_consultant[]':{
           required:'Select a consultant !'
      },
      BirthWeight:{
           digits:'Enter birth weight in digits !',
           maxlength:'Enter no more than 4 digits !',
           minlength:'Enter at least 3 digits !'

      },
     
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

// baby dob birth 
$('.baby-dob').datepicker({
    dateFormat: 'dd-mm-yy',
    yearRange: "-16:-0",
    changeMonth : true,
    changeYear : true,
    maxDate : '-0M',

});
