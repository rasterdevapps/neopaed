(function($) {

    $.fn.selectwithfreetext = function( options ) {
       
	        var settings = $.extend({
	            mainclass    : 'select-free-text1',
	            listClass    : 'select-free-text2',
	            list         :  null,
	        }, options);

	        var textid = $(this);

	        textid.keypress(function(e){
	             var a = [];
				 var k = e.which;
	            
	       	     $.each(settings.list,function(index,values){

	                if(values==$.trim(textid.val())){
	                	if(k!=8)
					      e.preventDefault();
					     else
					       textid.val('');
	                }

	         	});  

	       });
	        
	       textid.focusin(function() {

		       	 $('.'+settings.listClass).remove();
		        

		         poplists='<ul class="new-list list-group '+settings.listClass+'" style="list-style:none;">';
		        
		         $.each(settings.list,function(index,value){
		        
		             poplists+='<li class="select-values '+settings.mainclass+' list-group-item">'+value+'</li>';  
		    
		         });
		         
		         poplists+='</ul>';
		         
		         $( poplists ).insertAfter(this);
	        });

	       textid.focusout(function(e){

	          setTimeout(function(){

	            $('.'+settings.listClass).remove();

	          },300);  

	       });

	       $(document).on('click','.'+settings.mainclass,function(){
	        textid.val($(this).text()); 
	       	if ($(this).text() == 'Others') {
	       		$(this).parents('.form-group').next().removeClass('display-none');
	       	} else {
	       		$(this).parents('.form-group').next().addClass('display-none');	       		
	       	}
	       });
	       $(document).on('hover','.'+settings.mainclass,function(){
	           $(this).css('background','4D7496');
	       });

	    }

}(jQuery));