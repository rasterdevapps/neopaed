
	function buildSelector(id){
		
	
		var selectorId =id;
		var hashtagSelectorId = "#" + selectorId;
		$(hashtagSelectorId).hide();
		$(hashtagSelectorId).addClass("hs-binded");
		var optionValueArray = optionValues($('#'+id));
		var optionHtmlArray = optionHtmls($('#'+id));
		var numberOfOptions = $('#'+id).children().size();
		var parent = $('#'+id).parent();
		var currentSelected = $('#'+id).val();
		var optionColorsArray = optionColors($('#'+id));
		construct(numberOfOptions,optionValueArray,optionColorsArray,selectorId,optionHtmlArray);
		setSelected(currentSelected);
		setSelected(currentSelected, selectorId);
  }			
	
		function construct(numberOfOptions,optionValueArray,optionColorsArray,selectorId,optionHtmlArray){
							
				// Create HTML for the new selector
				var existingSelector = selectorId+'-horizonal';
				var newHtml = "<table class='"+existingSelector+"'><tr>";
				
				for(i=0; i < numberOfOptions; i++){	
			        var colorText=colorConstruct(optionColorsArray,i);
					var value = optionHtmlArray[i];
					newHtml += "<th class='fixedWidth' style='color:"+colorText+"'><h6>"+ value +"</h6></th>";
					newHtml += "<th class='sliderSpacerHeading'>&nbsp;</th>";
				
				}

				
				newHtml += "</tr>";
				var getLength = selectorId + '-option-length';
				newHtml += "<tr id='selectorOptions' class='"+getLength+"'>";
				
				var x = 0
			    var colortextFirst=colorConstruct(optionColorsArray,0);

				newHtml += "<td option-id='"+ optionValueArray[x] + "' data-color='"+colortextFirst+"' selector-id='" + selectorId + "' class='hole first-hole'></td>";
				newHtml += "<td class='hole-spacer'></td>";
				
				x++;
				
				for(i=1; i < numberOfOptions - 1; i++){
			      var colortextMiddle=colorConstruct(optionColorsArray,i);
				
						newHtml += "<td option-id='" + optionValueArray[i] + "' data-color='"+colortextMiddle+"' selector-id='" + selectorId + "' class='hole between-hole'></td>";
						newHtml += "<td class='hole-spacer'></td>";	
						x++;
				}
				var colortextLast=colorConstruct(optionColorsArray,x);

				newHtml += "<td option-id='"+ optionValueArray[x] + "' data-color='"+colortextLast+"' selector-id='" + selectorId + "' class='hole last-hole'></td>";
				
				newHtml += "</tr>";
				
				newHtml += "</table>";

                // if($('#'+selectorId).siblings('table').hasClass(existingSelector)){
                //   $('.'+existingSelector).remove();
                // }
				

				$('#'+selectorId).parent().append(newHtml);			
		};		
		
		function optionValues(element){
			var array = [];
			element.children().each(function(){
				// The $(this) selector below refers to the child element !!
				array.push($(this).attr("value"));	
			});
			return array;
		};
		
		function optionHtmls(element){
			var array = [];
			element.children().each(function(){
				// The $(this) selector below refers to the child element !!
				array.push($(this).html());	
			});
			return array;
		};

		function optionColors(element){
			var array ;            
            array = element.attr("data-color");

            return (typeof array != 'undefined')? JSON.parse(array):null; 
		};

		function colorConstruct(colorArrays,y){
			return (colorArrays != null && colorArrays[y]!= '' && typeof colorArrays[y] != 'undefined') ? colorArrays[y] : '#2F9AD3' ;
		}
		
		function setSelected(selectedValue, destinationId){
			var selectHole = "td[option-id='" + selectedValue + "'][selector-id='" + destinationId + "']";
			var setColor = $(selectHole).attr('data-color');
			$(selectHole).addClass("selected-hole").css('background-color',setColor);
		}	
	
            $(document).on('click',"td.hole",function(){
				var destinationId = $(this).attr("selector-id");
				var previousSelected = "td.selected-hole[selector-id='" + destinationId + "']";
				$(previousSelected).removeClass("selected-hole").css('background-color','silver');	
				var colorSet = $(this).attr('data-color');		
				$(this).addClass("selected-hole").css('background','').css('background-color',colorSet);
				var newValue = $(this).attr("option-id");
				originalSelect = "#" + destinationId;
				$(originalSelect).val(newValue);
				$(originalSelect).change();
			});
			
			 $(document).on('change',".hs-binded",function() {	

				var destinationId = $(this).attr("id");		
				var previousSelected = "td.selected-hole[selector-id='" + destinationId + "']";
				$(previousSelected).removeClass("selected-hole").css('background-color','silver');
				var newValue = $(this).val();
				var selectHole = "td[option-id='" + newValue + "'][selector-id='" + destinationId + "']";
				var colorSet = $(selectHole).attr('data-color');
				$(selectHole).addClass("selected-hole").css('background','').css('background-color',colorSet);

			});



function addDiaelPad(Selectorclass, InputName, inputboxClass,panelColor, ratioOption,totalBox, pluseMinus) {
	var ratioClass =  (ratioOption) ? 'ratio-pad' : '';

	var dialPade  = '<table class="daile-pade-box '+ratioClass+'" data-source="'+Selectorclass+'">';
        dialPade += '<tbody>';
	    dialPade += '<tr class="hole-number">';
	    dialPade += '<td><input id="'+Selectorclass+'" style="border-color:'+panelColor+';" class="form-control input-fields-shadow '+inputboxClass+'"  name="'+InputName+'" style="margin-bottom:10px;" type="text"></td>';
		dialPade += '<td class="even-parent-node"><span class="even-server">&nbsp; &nbsp;</span></td>'; 

		if (pluseMinus) {
		   dialPade +='<td class="odd-parent-node un-bind"><span style="background:'+panelColor+';" class="odd-server btn select-number-'+Selectorclass+' save-button-shadow" data-value="+">+</span></td>';
		   dialPade +='<td class="even-parent-node"><span class="even-server">-</span></td>'; 
		   dialPade +='<td class="odd-parent-node un-bind"><span style="background:'+panelColor+';" class="odd-server btn select-number-'+Selectorclass+' save-button-shadow" data-value="-">-</span></td>';
		   dialPade +='<td class="even-parent-node"><span class="even-server">-</span></td>';	
		}

	    for (var i = 1; i < 10; i++) {
	        dialPade +='<td class="odd-parent-node un-bind"><span style="background:'+panelColor+';" class="odd-server btn select-number-'+Selectorclass+' save-button-shadow" data-value="'+i+'">'+i+'</span></td>';
		    dialPade +='<td class="even-parent-node"><span class="even-server">-</span></td>'; 
	    }
	      dialPade +='<td class="odd-parent-node un-bind"><span style="background:'+panelColor+';" class="odd-server btn select-number-'+Selectorclass+' save-button-shadow" data-value="0">0</span></td>';
		  dialPade +='<td class="even-parent-node"><span class="even-server">-</span></td>'; 


		 dialPade +='<td class="dot-node un-bind"><span style="background:'+panelColor+';" class="odd-server  dot-option btn save-button-shadow select-number-'+Selectorclass+'" data-value=".">.</span></td>';
	     dialPade +='<td class="even-parent-node"><span class="even-server">-</span></td>'; 
	   
		dialPade +='<td class="dot-node un-bind"><span style="background:'+panelColor+';" class="odd-server backspace-option btn save-button-shadow select-number-'+Selectorclass+'" data-value="<-"><i class="fa fa-arrow-left" aria-hidden="true"></i></span></td>';
		dialPade +='<td class="even-parent-node"><span class="even-server">-</span></td>'; 
		dialPade +='<td class="dot-node un-bind"><span style="background:'+panelColor+';" class="odd-server delete-option btn save-button-shadow select-number-'+Selectorclass+'" data-value="<-"><i class="fa fa-times" aria-hidden="true"></i></span></td>';

  		if(ratioOption) {
  			 dialPade +='<td class="even-parent-node"><span class="even-server">-</span></td>'; 

	     	 dialPade +='<td class="dot-node un-bind"><span style="background:'+panelColor+';" class="odd-server  ratio-option btn save-button-shadow select-number-'+Selectorclass+'" data-value=":">:</span></td>';
	     }
        if(totalBox) {
        	dialPade += '<td>&nbsp; &nbsp;</td>' 
        	dialPade += '<td><input style="border-color:'+panelColor+';" class="form-control input-fields-shadow '+inputboxClass+'"  name="'+InputName+'_total" id="'+InputName+'_total" style="margin-bottom:10px;" type="text"> </td>'
        }
		
		
		dialPade += '</tr>';
 		dialPade += '</tbody>';
		dialPade += '</table>';


       $('.'+Selectorclass).append(dialPade);		

   	   $(document).on('click', '.select-number-'+Selectorclass, function() {

   	   	 var  Id = $(this).parents('table').data('source');

        
             if ($(this).hasClass('dot-option')) {

               	var value =  $('#'+Id).val() + '.'; 
                $('#'+Id).val(value).trigger('change');

             } else if($(this).hasClass('backspace-option')) {

             	var value =  $('#'+Id).val();
                    value = value.substring(0, value.length - 1);
                    $('#'+Id).val(value).trigger('change');

             } else if($(this).hasClass('ratio-option')) {
             	  var value =  $('#'+Id).val() + ':'; 
                  $('#'+Id).val(value).trigger('change');

             } else if($(this).hasClass('delete-option')) {
             	 
             	 $('#'+Id).val('').trigger('change');

             } else {
             	var value =  $('#'+Id).val() + $(this).data('value'); 

                $('#'+Id).val(value).trigger('change');
             }
   	 
   	   });    
	   
}



  
		

		
