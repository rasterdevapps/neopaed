$("form").validate({
  rules: {
  	         //echocardiography_form 
	              Age :"required",
	              Outcome:"required",

	          //Cranial Ultrasonography
                TestDate:"required",
                Indication:"required",
                UsgRt:"required",
                UsgLt:"required",
                UsgGeneral:"required",
                Impression:"required",

            //Culture Registry
                SeenBy:"required",
                EntryDate:"required",              
                CollectionDate:"required",              
                DayOfLife:"required",              

  },
  messages: {

                Age: {
                    required:'Please Enter Age !'
                },
                Outcome: {
                  required:'Please Select Outcome !'
                },
                TestDate: {
                  required:'Please Select TestDate !'
                },
                Indication: {
                  required:'Please Enter Indication !'
                },
                UsgRt: {
                  required:'Please Enter USG Findings Rt Side !' 
                },
                UsgLt: {
                  required:'Please Enter USG Findings Lt Side !'
                },
                UsgGeneral: {
                  required:'Please Enter USG Findings General !'
                },
                ImpressionL: {
                  required:'Please Enter Impression !'
                },
                SeenBy: {
                  required:'Please Select SeenBy !'
                },
                EntryDate: {
                  required:'Please Select EntryDate !'
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
