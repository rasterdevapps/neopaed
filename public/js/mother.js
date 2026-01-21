$("form").validate({
  rules:{
	   	MMrNo:{
	   	 	  mrnumber:true,
          //remote:checkuniqemr()
     	 },
       MotherInitial:{
          maxlength:5,
          characteronly:true
       },
       MotherName:{
          required:true,
          characteronly:true
       },
       MotherLastName:{
          characteronly:true
       },
       MothercYear:{
          digits:true,
          maxlength:2,
          minlength:2
       },
       Occupation:{
          characteronly:true
       },
       Mobile:{
         digits:true,
         maxlength:11,
         minlength:10
       },
       LandLine:{
          digits:true,
          maxlength:11,
          minlength:10
       },
       MotherEmail:{
          email:true
       },
       MotherSpokenLanguages:{
        charactercomma:true,
        alphanumeric: true
       },
       Address4:{
        digits:true,
        maxlength:6,
        minlength:6
       },
       Address5:{
        characteronly:true
       },
       PartnerInitial:{
        maxlength:5,
        characteronly:true

       },
       PartnerName:{
         characteronly:true
       },
       PartnerLastName:{
         characteronly:true
       },
       PartnerOccupation:{
         characteronly:true
       },
       PartnerContact:{
         digits:true,
         maxlength:11,
         minlength:10
       },
       PartnerMobile:{
           digits:true,
           maxlength:11,
           minlength:10
       },
       Email:{
          email:true
       },
       FatherSpokenLanguages:{
          charactercomma:true
       },
       Postcode:{
        digits:true,
        maxlength:6,
        minlength:6
       },
       Country:{
         characteronly:true
       }

    
  },
  messages:{
      MMrNo:{
      	   mrnumber:'Enter only alpha numeric and special character "/" ',
      },
      MotherInitial:{
           maxlength:'Enter upto 5 characters !'
      },
      MotherName:{
          characteronly:'Enter only alphabets !'
      },
      MotherLastName:{
          characteronly:'Enter only alphabets !'
      },
      MothercYear:{
          digits:'Enter only digits !',
          maxlength:'Enter only 2 digits !',
          minlength:'Enter only 2 digits !'
      },
      Occupation:{
          characteronly:'Enter only alphabets !'
      },
      Mobile:{
           digits:'Enter digits only !',
           maxlength:'Enter maximum 11 digits only !',
           minlength:'Enter minimum 10 digits only !'
      },
      LandLine:{
           digits:'Enter digits only !',
           maxlength:'Enter maximum 11 digits only !',
           minlength:'Enter minimum 10 digits only !'
      },
      MotherEmail:{
          email:'Enter valid email !'
      },
      MotherSpokenLanguages:{
        charactercomma:'Enter only alphabets and special characters ","',
        alphanumeric: 'Enter valid Languages'
      },
      Address4:{
        digits:'Enter digits only !',
        maxlength:'Enter only 6 digits !',
        minlength:'Enter only 6 digits !'
      },
      Address5:{
        characteronly:'Enter only alphabets !'
      },
      PartnerInitial:{
       maxlength:'Enter only 5 characters !'
      },
      PartnerName:{
        characteronly:'Enter only alphabets !'
      },
      PartnerLastName:{
         characteronly:'Enter only alphabets !'
      },
      PartnerOccupation:{
         characteronly:'Enter only alphabets !'
      },
      PartnerContact:{
           digits:'Enter digits only !',
           maxlength:'Enter maximum 11 digits only !',
           minlength:'Enter minimum 10 digits only !'
      },
      PartnerMobile:{
           digits:'Enter digits only !',
           maxlength:'Enter maximum 11 digits only !',
           minlength:'Enter minimum 10 digits only !'
      },
      Email:{
          email:'Enter valid email !'
      },
      FatherSpokenLanguages:{
        charactercomma:'Enter only alphabets and special characters ","'
      },
      Postcode:{
           digits:'Enter digits only !',
           maxlength:'Enter only 6 digits !',
           minlength:'Enter only 6 digits !'
      },
      Country:{
         characteronly:'Enter only alphabets !'
      }

  }
   
});

// parents dob birth 
var today = new Date();
$('.parents-dob').datepicker({
    dateFormat: 'dd-mm-yy',
    // yearRange: "-40:-15",
    yearRange: "-40:-0",
    changeMonth : true,
    changeYear :true,
    maxDate: today,
    viewMode: "years", 
  minViewMode: "years",
  updateViewDate: true,

});

$(document).on('change', '.mother_registration_form input, .mother_registration_form select', function()
{
  $(this).addClass('not_saved');
});