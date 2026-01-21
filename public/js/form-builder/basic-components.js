var singleProperty = {

	'layoutClass' : 'col-md-10 single-column-problem',
	'layoutId'    : 'single-column-problem',
	'positionAttribute' : 'problem-fields-center',
	'placeholder'       : '<h3 class="head-label-left">Please drag & drop components here.</h3>'

};

var doubleProperty = {

	'leftLayoutclass'    : 'col-md-5 problem-fields-left',
	'leftLayoutid'       : 'box-left',
	'leftPosition'       : 'problem-fields-left',
	'leftPlaceholder'    : '<h3 class="head-label-left">Please drag & drop components here.</h3>',
	'rightLayoutclass'   : 'col-md-5 problem-fields-right',
	'rightLayoutid'      : 'box-right',
	'rightPosition'      : 'problem-fields-right',
	'rightPlaceholder'   : '<h3 class="head-label-left">Please drag & drop components here.</h3>',
}

var masterLayout = {
	'mainClass': '.master-problem-fields',
	'containerSelector':'.master-problem-fields > section'
};

var componentInitialvalues = {
	'class'      : 'form-control',
	'groupClass' : '.form-part',
	'groupId'    : 'part' 
}
var dependencyProperty = {
	'optionName'    :'Option Names',
	'componentName' :'Hiding Component'
}
var drugMaster = ['Drug', 'Duration', 'Does'];
var antibioticMaster = ['Antibiotic', 'Duration'];


function checkingContainerlabel(formContainer) {

	if (formContainer.childElementCount == 0) {
		formContainer.innerHTML='<h3 class="head-label-left">Please drag & drop components here.</h3>';
	}

	return;

}

function getRemoveHeader(dropPosition) {
	var parentContainer = findParentelement(dropPosition,'section');

	if(parentContainer !=null && parentContainer.getElementsByTagName('h3').length != 0){
		parentContainer.innerHTML = '';
	}else if(parentContainer == null && dropPosition.nodeName =='SECTION' && dropPosition.getElementsByTagName('h3').length != 0){
		dropPosition.innerHTML = '';
	}

}


/* create the label */
/*
 *labelName text
 */

 function labelField(labelName,fontsize) {

 	return '<label for="'+labelName+'" style="font-size:'+fontsize+'px !important;" class="show-label">'+labelName+'</label>';
 }

 /* create the single line text box */
/*
	*labelName type text
	*feildName type text
	*feildClass type text
	*feildPlaceholder type text
	*/
	function singleLine(labelName,feildName,feildClass,feildPlaceholder) {
		var singleLineproperty   = '<label for="'+labelName+'" class="show-label">'+labelName+'</label>';
		singleLineproperty  += '<input name="'+feildName+'" value="" class="'+feildClass+' show-input" placeholder ="'+feildPlaceholder+'" type="text">'; 
		return singleLineproperty;
	}

	/* create the number box */
/*
	*labelName type text
	*feildName type text
	*feildClass type text
	*feildPlaceholder type text
	*/
	function numberBox(labelName,feildName,feildClass,feildPlaceholder) {
		var numberBoxproperty   = '<label for="'+labelName+'" class="show-label">'+labelName+'</label>';
		numberBoxproperty  += '<input name="'+feildName+'" value="" class="'+feildClass+' show-input" placeholder ="'+feildPlaceholder+'" type="number">'; 
		return numberBoxproperty;

	}

	/* create the decimal box */
/*
	*labelName type text
	*feildName type text
	*feildClass type text
	*feildPlaceholder type text
	*/

	function decimalBox(labelName,feildName,feildClass,feildPlaceholder) {
		var  decimalBoxproperty   = '<label for="'+labelName+'" class="show-label">'+labelName+'</label>';
		decimalBoxproperty  += '<input name="'+feildName+'" value="" class="'+feildClass+' show-input" placeholder ="'+feildPlaceholder+'" type="number">'; 
		return decimalBoxproperty;

	}


	/* create the multiple line text box */
/*
	*labelName type text
	*feildName type text
	*feildClass type text
	*feildPlaceholder type text
	*/
	function multipleLine(labelName,feildName,feildClass,noRow,noColumn) {
		var   multipleLineproperty = '<label for="'+labelName+'" class="show-label">'+labelName+'</label>';
		multipleLineproperty += '<textarea name="'+feildName+'" value="" class="'+feildClass+' show-input" row="'+noRow+'" col="'+noColumn+'"> </textarea>';
		return multipleLineproperty;

	}

	/* create the drop down box */
/*
	*labelName type text
	*feildName type text
	*feildClass type text
	*options type array 
	*/
	function dropBox(labelName,feildName,feildClass,optionName,optionValue) {
		var dropBoxproperty  ='<label for="'+labelName+'" class="show-label">'+labelName+'</label>';
		dropBoxproperty +='<select class="'+feildClass+'" name="'+feildName+'">';
		for(i = 0; i < optionName.length; i++) {
			dropBoxproperty += '<option value="'+optionValue[i]+'">'+optionName[i]+'</option>';
		} 
		dropBoxproperty +='</select>';  
		return dropBoxproperty;    

	}

	/* create the toggle box */
/*
	*labelName type text
	*feildName type text
	*feildClass type text
	*onbtnLabel type text
	*offbtnLabel type text
	*btnWidth type number
	*/
	function toggleBox(labelName,feildName,feildClass,onbtnLabel,offbtnLabel,btnWidth) {
		var toggleBoxproperty  = '<label for="'+labelName+'" class="show-label">'+labelName+'</label>';
		toggleBoxproperty += '<input id="'+feildName+'" name="'+feildName+'" id="'+feildName+'"  data-on="'+onbtnLabel+'" data-off="'+offbtnLabel+'"  data-toggle="toggle" data-width="'+btnWidth+'" data-size="small" class="'+feildClass+'" type="checkbox">';
		return toggleBoxproperty;
	}

	/* create the horizontaldot selector */
/*
	*labelName type text
	*feildName type text
	*feildClass type text
	*optionsColor type array
	*options type array 
	*/
	function horizontalDotselector(labelName,feildName,feildClass,optionsColor,optionsName,optionsValue) {

		var horizontalDot  = '<label for="'+labelName+'" class="show-label">'+labelName+'</label>';
		horizontalDot += "<select class='"+feildClass+"' name='"+feildName+"' id='"+feildName+"' data-color='"+optionsColor+"'>";
		for(i = 0; i < optionsName.length; i++) {
			horizontalDot += '<option value="'+optionsValue[i]+'">'+optionsName[i]+'</option>';
		} 
		horizontalDot +='</select>';
		return horizontalDot;

	}



	/* create the checkbox */
/*
	*labelName type text
	*feildNames type array  
	*feildValues type array
	*feildClass type text
	*/
	function checkBoxgroup(labelName,name,feildNames,feildValues,feildClass) {

		var checkboxproperty  ='<label for="'+labelName+'" class="show-label">'+labelName+'</label>'; 
		checkboxproperty +='<div class="checkbox-group">'; 
		for(i = 0; i < feildNames.length; i++) {
			checkboxproperty +='<label class="radio-inline">';
			checkboxproperty +='<input name="'+name+'[]" value="'+feildValues[i]+'"  type="checkbox">  '+feildNames[i]; 
			checkboxproperty +='</label>';
		} 
		checkboxproperty +='</div>';
		return checkboxproperty;

	}
/* create the radio 
 *labelName type text
 *feildNames type array  
 *feildValues type array
 *feildClass type text
 */
 function radioBox(labelName,name,feildNames,feildValues,feildClass) {

 	var radioBoxproperty  ='<label for="'+labelName+'" class="show-label">'+labelName+'</label>'; 
 	radioBoxproperty +='<div class="radio-group">';
 	for(i = 0; i < feildNames.length; i++) {
 		radioBoxproperty +='<label class="radio-inline">';
 		radioBoxproperty +='<input name="'+name+'[]" value="'+feildValues[i]+'"  type="radio">  '+feildNames[i]; 
 		radioBoxproperty +='</label>';
 	} 
 	radioBoxproperty +='</div>';
 	return radioBoxproperty;

 } 

/* create the medicine
*/

function medicineBox(labelName, name, feildClass) {

	var drugValues     = $('select[name="temp_medicine"]').html();
	var drugContainers = [];
	var tempmedicine = '<select name="'+name+'medicine[]" class="'+feildClass+'">'+drugValues+'</select>';
	drugContainers.push(tempmedicine);
	var tempmedicine = '<input type="text" class="'+feildClass+'" name="'+name+'duration[]">';
	drugContainers.push(tempmedicine);
	var tempmedicine = '<input type="text" class="'+feildClass+'" name="'+name+'dose[]">';
	drugContainers.push(tempmedicine);
	return createTable(drugMaster, drugContainers, 'table', labelName);

}
/* create the antibiotic 
*/

function antibioticBox(labelName, name, feildClass) {

	var antibioticValues     = $('select[name="temp_antibiotic"]').html();
	var antibioticContainers = [];
	var tempAntibiotic = '<select name="'+name+'antibiotic[]" class="'+feildClass+'">'+antibioticValues+'</select>';
	antibioticContainers.push(tempAntibiotic);
	var tempAntibiotic = '<input type="text" class="'+feildClass+'" name="'+name+'duration[]">';
	antibioticContainers.push(tempAntibiotic);
	return createTable(antibioticMaster, antibioticContainers, 'table', labelName);
}

/*create table */
function createTable(tableHeadings, tableDefine, tableClass, headerName) {

	var tableHeader  = '<thead>';
	tableHeader += '<tr>';
	for (var headIndex = 0; headIndex < tableHeadings.length; headIndex++) {
		tableHeader += '<th>'+tableHeadings[headIndex]+'</th>';
	}    
	tableHeader += '</tr>';
	tableHeader += '</thead>';

	var tableBody    = '<tbody>';
	tableBody    += '<tr>';
	for (var bodyIndex = 0; bodyIndex < tableDefine.length; bodyIndex++) {
		tableBody += '<th>'+tableDefine[bodyIndex]+'</th>';
	}    
	tableBody += '</tr>';
	tableBody += '</tbody>';

	var tableLabel = '<label for="'+headerName+'" class="show-label">'+headerName+'</label>';
	return tableLabel+'<table class="'+tableClass+'">'+tableHeader+tableBody+'</table>';    

}




function formGroupContainer(componentHtml,componentParameter,groupId,groupElement){

	return '<div draggable="true" data-param-number="'+groupElement+'" id="'+groupId+'" class="form-group form-part"> <i class="fa fa-times remove-component pull-right" aria-hidden="true"></i>'+componentHtml+componentParameter+'</div>';
}


function singleColumn(singleProperty){

	var singleColumnproperty   = '<section class="'+singleProperty.layoutClass+'" id="'+singleProperty.layoutId+'" data-position="'+singleProperty.positionAttribute+'">';
	singleColumnproperty  += singleProperty.placeholder
	singleColumnproperty  += '</section>';

	return singleColumnproperty; 
}


function doubleColumn(doubleProperty){
	var doubleColumnproperty   ='<section class="'+doubleProperty.leftLayoutclass+'" id="'+doubleProperty.leftLayoutid+'" data-position="'+doubleProperty.leftPosition+'">';
	doubleColumnproperty  += doubleProperty.leftPlaceholder;
	doubleColumnproperty  += '</section>';
	doubleColumnproperty  +='<section class="'+doubleProperty.rightLayoutclass+'" id="'+doubleProperty.rightLayoutid+'"  data-position="'+doubleProperty.rightPosition+'">' 
	doubleColumnproperty  += doubleProperty.rightPlaceholder;
	doubleColumnproperty  += '</section>';

	return doubleColumnproperty; 

}


function getOptionscollection(optionsSelector) {

	var option = [];

	for (var i = 0; i < optionsSelector.length; i++) {

		option.push( $(optionsSelector[i]).val());

	}
	return JSON.stringify(option);
}


function setDropboxConditions(optionCondition,designationConditionname,designationCondition,designationClass,groupId) {

	optionCondition = JSON.parse(decodeURIComponent(optionCondition));

	for (var i = 0; i < optionCondition.length; i++) {

		if(i==0){
			$(designationConditionname[i]).val(optionCondition[i]);
			$(designationCondition[i]).val(optionCondition[i]);
		} else {
			var optionSet  = '<tr>';
			optionSet +='<td><input class="form-control field-property"  value="'+optionName[i]+'" name="foption_condition_name[]" type="text"></td>';
			optionSet +='<td><input class="form-control field-property" data-og-element-id="foption_condition'+groupId+'" value="'+optionCondition[i]+'" name="foption_condition[]" type="text"></td>';
			optionSet +='<td><a href="javascript:void(0);" class="close-option"><i class="fa fa-times" aria-hidden="true"></i></a></td>';
			optionSet +='</tr>';

		}
		
	}
}


function setDropboxOptions(optionName,optionValue,designationOptionname,designationOptionvalue,designationClass,groupId) {

	optionName  = JSON.parse(decodeURIComponent(optionName));
	optionValue = JSON.parse(decodeURIComponent(optionValue));


	for (var i = 0; i < optionName.length; i++) {


		if (i==0) {
			$(designationOptionname[i]).val(optionName[i].replace(/\+/g ," "));
			$(designationOptionvalue[i]).val(optionValue[i].replace(/\+/g ," "));
		} else {
			var optionSet  ='<tr>';
			optionSet +='<td><input class="form-control field-property options-collection" data-og-element-id="para_option_name'+groupId+'" value="'+optionName[i].replace(/\+/g ," ")+'" name="foption_name[]" type="text"></td>';
			optionSet +='<td><input class="form-control field-property options-collection" data-og-element-id="para_option_value'+groupId+'" value="'+optionValue[i].replace(/\+/g ," ")+'" name="foption_value[]" type="text"></td>';
			optionSet +='<td>';
			optionSet +='<a href="javascript:void(0);" class="add-drop-option add-button-round"> <i class="fa fa-plus" aria-hidden="true"></i></a>';
			optionSet +='<a href="javascript:void(0);" class="close-option remove-button-round"><i class="fa fa-times" aria-hidden="true"></i></a>';
			optionSet +='</td>';
			optionSet +='</tr>';
			$('.'+designationClass+' tbody').append(optionSet);        
		}


	}

}

function setHorizontalselector(optionName,optionValue,optionColor,designationOptionname,designationOptionvalue ,designationOptioncolor,designationClass,groupId) {
	optionName  = JSON.parse(decodeURIComponent(optionName));
	optionValue = JSON.parse(decodeURIComponent(optionValue));
	optionColor = JSON.parse(decodeURIComponent(optionColor));    
	for (var i = 0; i < optionName.length; i++) {

		if(i==0) {
			$(designationOptionname[i]).val(optionName[i]);
			$(designationOptionvalue[i]).val(optionValue[i]);
			$(designationOptioncolor[i]).val(optionColor[i]);
		} else {
			var optionSet  ='<tr>';
			optionSet +='<td><input class="form-control field-property options-collection" data-og-element-id="hpara_option_name'+groupId+'" value="'+optionName[i]+'" name="hfoption_name[]" type="text"></td>';
			optionSet +='<td><input class="form-control field-property options-collection" data-og-element-id="hpara_option_value'+groupId+'" value="'+optionValue[i]+'" name="hfoption_value[]" type="text"></td>';
			optionSet +='<td><input class="form-control field-property options-collection" data-og-element-id="hpara_option_color'+groupId+'" value="'+optionColor[i]+'" name="hfoption_color[]" type="text"></td>'; 
			optionSet +='<td>';
			optionSet +='<a href="javascript:void(0);" class=" add-drop-option add-button-round"><i class="fa fa-plus" aria-hidden="true"></i></a>';
			optionSet +='<a href="javascript:void(0);" class=" close-option remove-button-round"> <i class="fa fa-times" aria-hidden="true"></i></a>';
			optionSet +='</td>';
			optionSet +='</tr>';
			$('.'+designationClass+' tbody').append(optionSet);        
		}


	}
}

function setCheckboxOption(optionName,optionValue,designationOptionname,designationOptionvalue,designationClass,groupId) {
	optionName  = JSON.parse(decodeURIComponent(optionName));
	optionValue = JSON.parse(decodeURIComponent(optionValue));

	for (var i = 0; i < optionName.length; i++) {

		if(i==0) {
			$(designationOptionname[i]).val(optionName[i]);
			$(designationOptionvalue[i]).val(optionValue[i]);
		} else {
			var optionSet  ='<tr>';
			optionSet +='<td><input class="form-control field-property options-collection" data-og-element-id="para_chkop_name'+groupId+'" value="'+optionName[i]+'" name="fchkop_name[]" type="text"></td>';
			optionSet +='<td><input class="form-control field-property options-collection" data-og-element-id="para_chkop_value'+groupId+'" value="'+optionValue[i]+'" name="fchkop_value[]" type="text"></td>';
			optionSet +='<td><a href="javascript:void(0);" class="add-drop-option add-button-round"> <i class="fa fa-plus" aria-hidden="true"></i></a>';
			optionSet +='<a href="javascript:void(0);" class="close-option remove-button-round"><i class="fa fa-times" aria-hidden="true"></i></a></td>';
			optionSet +='</tr>';
			$('.'+designationClass+' tbody').append(optionSet);        
		}

	}

}

function setRadioboxOption(optionName,optionValue,designationOptionname,designationOptionvalue,designationClass,groupId) {
	optionName  = JSON.parse(decodeURIComponent(optionName));
	optionValue = JSON.parse(decodeURIComponent(optionValue));

	for (var i = 0; i < optionName.length; i++) {

		if(i==0) {
			$(designationOptionname[i]).val(optionName[i]);
			$(designationOptionvalue[i]).val(optionValue[i]);
		} else {
			var optionSet  ='<tr>';
			optionSet +='<td><input class="form-control field-property options-collection" data-og-element-id="para_rdop_name'+groupId+'" value="'+optionName[i]+'" name="frdop_name[]" type="text"></td>';
			optionSet +='<td><input class="form-control field-property options-collection" data-og-element-id="para_rdop_value'+groupId+'" value="'+optionValue[i]+'" name="frdop_value[]" type="text"></td>';
			optionSet +='<td>';
			optionSet +='<a href="javascript:void(0);" class="add-drop-option add-button-round"> <i class="fa fa-plus" aria-hidden="true"></i></a>';
			optionSet +='<a href="javascript:void(0);" class="close-option remove-button-round"><i class="fa fa-times" aria-hidden="true"></i></a></td>';
			optionSet +='</tr>';
			$('.'+designationClass+' tbody').append(optionSet);        
		}


	}

}

function createDependancyinput(dependencyName) {

	var dependencyNameset = [];
	var i = 1;
	dependencyName.each(function(){

		var tempDependancy = {
			'dependencyName'  : $(this).val(),
			'dependencyValue' : $('#dependency'+i).val(),

		};

		dependencyNameset.push(tempDependancy);


		i++;
	});
	return JSON.stringify(dependencyNameset);

}

/* return the list of components for sidebar depentancy */
function getListofComponents(selectedComponentName, currentItem = "") {   
	var componentLength = $('input[name="para_name[]"]').length;
	var componentList = '';
	for (var i = 1; i <= componentLength; i++) {
		var field = $('#para_name'+i).val();
		if (field != currentItem) {  
			if (selectedComponentName != null) {
				$.each(selectedComponentName, function( index, value ) {
					var optionSelected = $('#para_name'+i).val().replace('[]','') == value ? 'selected ="true"' : '';
					componentList += '<option '+optionSelected+' value="'+$('#para_name'+i).val().replace('[]','')+'">'+$('#para_label'+i).val().replace(':','')+'</option>';
				});
			} else {
      			var optionSelected = (selectedComponentName != null && $('#para_name'+i).val().replace('[]','') == selectedComponentName) ? 'selected ="true"' : '';
      			if (typeof $('#para_name'+i).val() != 'undefined') {
       				componentList += '<option '+optionSelected+' value="'+$('#para_name'+i).val().replace('[]','')+'">'+$('#para_label'+i).val().replace(':','')+'</option>';
       			}
			}

		}
	}

	return componentList;

}

/* return the list of components for sidebar depentancy */
function getListofComponentsNumber(selectedComponentName, currentItem = "") {   

	var componentLength = $('input[name="para_name[]"]').length;
	var componentList = '';
	for (var i = 1; i <= componentLength; i++) {
		var field = $('#para_name'+i).val();
		if ($("input[name='"+field+"']").attr("type") == "number" && field != currentItem) {    
			var optionSelected = (selectedComponentName != null && $('#para_name'+i).val().replace('[]','') == selectedComponentName) ? 'selected ="true"' : '';
			componentList += '<option '+optionSelected+' value="'+$('#para_name'+i).val().replace('[]','')+'">'+$('#para_label'+i).val().replace(':','')+'</option>';
		}
	}

	return componentList;

}

/* return the list of components for sidebar depentancy */
function getListofActionComponents(selectedComponentName) {   

	var componentList = '';
	var manipulationval = ['Addition', 'Substraction', 'Multiplication', 'Division'];
	var manipulationlabel = ['Addition (+)', 'Substraction (-)', 'Multiplication (*)', 'Division (/)'];
	for (var i = 0; i < manipulationval.length; i++) {
		var optionSelected = (selectedComponentName != null && manipulationval[i] == selectedComponentName) ? 'selected ="true"' : '';
		componentList += '<option '+optionSelected+' value="'+manipulationval[i]+'">'+manipulationlabel[i]+'</option>';
	}

	return componentList;

}

/* set the toggle dependancy for sidebar */
function setToggledepentancy(groupId) {

	var dependancyValue = $('#para_toggle_dependancy'+groupId).val();

	var dependancyValue = JSON.parse(decodeURIComponent(dependancyValue));
	var toggleDependency  = '<div class="form-group option-dependancy">';
	toggleDependency += '<label for="fcondition">Dependancy Conditions : </label>';
	toggleDependency += '<table class="table">';
	toggleDependency += '<thead>';
	toggleDependency += '<tr>';
	toggleDependency += '<th>Options :</th>';
	toggleDependency += '<th>Fields :</th>';
	toggleDependency += '</tr>';
	toggleDependency += '</thead>';
	toggleDependency += '<tbody>';

	for (var i = 0; i < dependancyValue.length; i++) {
		var index = i +1;
		toggleDependency += '<tr>';
		toggleDependency += '<td><input class="form-control field-property" readonly="true" value="'+dependancyValue[i].dependencyName.replace(/\+/g ," ")+'" data-og-element-id="para_dependancy'+groupId+'" name="foption_dependancy_name[]" type="text"></td>';
		toggleDependency += '<td><select class="field-property input-width-medium" multiple = true id="foption_dependancy'+index+'"  data-og-element-id="para_toggle_dependancy'+groupId+'" name="foption_dependancy_value[]" >' ; 
		toggleDependency += getListofComponents(dependancyValue[i].dependencyValue, $('#para_name'+groupId).val());
		toggleDependency +='</select></td>';
		toggleDependency += '<tr>';

	}

	toggleDependency += '</tbody>';
	toggleDependency +='</div>';
	$('#component-property').append(toggleDependency);

	for (var i = 0; i < dependancyValue.length; i++) {
		var index = i +1;
		RebuildMultipleselector($('#foption_dependancy'+index));
	}  

}

/* Initialze the select2 object for dependancy select box  */
function RebuildMultipleselector(conditionSelectbox) {

	conditionSelectbox.select2({allowClear: true,width: 'resolve'}).on('removed',function(e) {
		if(e && e.type=='removed') {
			$('select[name="foption_dependancy_value[]"]').each(function() {
				$(this).children('option[value='+e.val+']').removeAttr('disabled');
			});

		}

	}).on('select2-selecting',function(e) {

		var id = $(this).attr('id');

		if(e && e.type == 'select2-selecting') {
			$('select[name="foption_dependancy_value[]"]').each(function() {
				if(id != $(this).attr('id')) {
					$(this).children('option[value='+e.val+']').prop('disabled',true);
				}

			});

		}  
	});

}


function setHiddenSetting(componentType,groupId) {

	var componentType        = $('input[name="component_type"]').val(); 
	var label                = $('input[name="component_label"]').val();

	if(componentType == 'type-drugs') {
		var name                 = $('input[name="component_name"]').val()+'medicine';   
	} else {
		var name                 = $('input[name="component_name"]').val();   
	}

	if(componentType == 'type-antibiotic') {
		var name                 = $('input[name="component_name"]').val()+'antibiotic';   
	} else {
		var name                 = $('input[name="component_name"]').val();   
	}




	var componentHidden      = '<input type="hidden" name="para_name[]"  value="'+name+'"  id="para_name'+groupId+'" >';
	componentHidden     += '<input type="hidden" name="para_label[]" value="'+label+'" id="para_label'+groupId+'" >';
	componentHidden     += '<input type="hidden" name="para_type[]"  value="'+componentType+'" id="para_type'+groupId+'" >';
	componentHidden     += '<input type="hidden" name="para_order[]"  value="'+groupId+'" id="para_order'+groupId+'" >';
	componentHidden     += '<input type="hidden" name="para_default[]"  value="" id="para_default'+groupId+'" >';

	if($('input[name="base_layout[]"]:checked').val() == 1) {

		componentHidden     += '<input type="hidden" name="para_position[]"  value="single-column-problem" id="para_position'+groupId+'" >';

	}else if($('input[name="base_layout[]"]:checked').val() == 2) {

		var position = $('select[name="component_position"]').val();
		componentHidden     += '<input type="hidden" name="para_position[]"  value="'+position+'" id="para_position'+groupId+'" >';

	}


	switch(componentType) {

		case 'type-text':
		var addmore          = $('input[name="component_addmore"]').val();
		var dischargeSummary = $('input[name="component_discharge"]').val();
		var placeholder      = $('input[name="component_placeholder"]').val();  
		var validateRequired = ($('input[name="component_val_req"]').prop('checked') == true) ? 1 : 0 ;
		componentHidden += '<input type="hidden" name="para_placeholder[]" value="'+placeholder+'"  id="para_placeholder'+groupId+'" >';
		componentHidden += '<input type="hidden" name="para_required[]" value="'+validateRequired+'"  id="para_required'+groupId+'" >';
		componentHidden += '<input type="hidden" name="para_addmore[]" value="'+addmore+'"  id="para_addmore'+groupId+'" >';
		componentHidden += '<input type="hidden" name="para_discharge[]" value="'+dischargeSummary+'"  id="para_discharge'+groupId+'" >';

		break;

		case 'type-number':
		var placeholder      = $('input[name="component_placeholder"]').val();  
		var validateRequired = ($('input[name="component_val_req"]').prop('checked') == true) ? 1 : 0 ;
		var dischargeSummary = $('input[name="component_discharge"]').val();
		var minValues        = $('input[name="component_min"]').val();
		var maxValues        = $('input[name="component_max"]').val();
		var digitDependency =  createDependancyDigit($('input[name="digitdependencyname[]"]'));

		componentHidden += '<input type="hidden" name="para_placeholder[]" value="'+placeholder+'"  id="para_placeholder'+groupId+'" >'; 
		componentHidden += '<input type="hidden" name="para_required[]" value="'+validateRequired+'"  id="para_required'+groupId+'" >';
		componentHidden += '<input type="hidden" name="para_min[]" value="'+minValues+'" id ="para_min'+groupId+'">';
		componentHidden += '<input type="hidden" name="para_max[]" value="'+maxValues+'" id ="para_max'+groupId+'">';
		componentHidden += '<input type="hidden" name="para_discharge[]" value="'+dischargeSummary+'"  id="para_discharge'+groupId+'" >';
		componentHidden += '<input type="hidden" name="para_digit_dependancy[]" value="'+encodeURIComponent(digitDependency)+'" id="para_digit_dependancy'+groupId+'" >';

		break; 

		case 'type-decimal':
		var placeholder       = $('input[name="component_placeholder"]').val();  
		var validateRequired  = ($('input[name="component_val_req"]').prop('checked') == true) ? 1 : 0 ;
		var minValues         = $('input[name="component_min"]').val();
		var maxValues         = $('input[name="component_max"]').val();
		var dischargeSummary  = $('input[name="component_discharge"]').val();
		var decimalDependency =  createDependancyDigit($('input[name="decimaldependencyname[]"]'));

		componentHidden += '<input type="hidden" name="para_placeholder[]" value="'+placeholder+'"  id="para_placeholder'+groupId+'" >'; 
		componentHidden += '<input type="hidden" name="para_required[]" value="'+validateRequired+'"  id="para_required'+groupId+'" >';
		componentHidden += '<input type="hidden" name="para_min[]"  value="'+minValues+'" id ="para_min'+groupId+'">';
		componentHidden += '<input type="hidden" name="para_max[]"  value="'+maxValues+'" id ="para_max'+groupId+'">';
		componentHidden += '<input type="hidden" name="para_discharge[]" value="'+dischargeSummary+'"  id="para_discharge'+groupId+'" >';
		componentHidden += '<input type="hidden" name="para_decimal_dependancy[]" value="'+encodeURIComponent(decimalDependency)+'" id="para_decimal_dependancy'+groupId+'" >';

		break; 

		case 'type-textarea':
		var placeholder      =  $('input[name="component_placeholder"]').val(); 
		var textRow          =  $('input[name="component_row"]').val();
		var textColumn       =  $('input[name="component_col"]').val();
		var validateRequired =  ($('input[name="component_val_req"]').prop('checked') == true) ? 1 : 0 ;
		var dischargeSummary =  $('input[name="component_discharge"]').val();

		componentHidden += '<input type="hidden" name="para_placeholder[]" value="'+placeholder+'"  id="para_placeholder'+groupId+'" >';  
		componentHidden += '<input type="hidden" name="para_row[]" value="'+textRow+'"  id="para_row'+groupId+'" >';  
		componentHidden += '<input type="hidden" name="para_column[]" value="'+textColumn+'"  id="para_column'+groupId+'" >';  
		componentHidden += '<input type="hidden" name="para_required[]" value="'+validateRequired+'"  id="para_required'+groupId+'" >';
		componentHidden += '<input type="hidden" name="para_discharge[]" value="'+dischargeSummary+'"  id="para_discharge'+groupId+'" >';

		break;

		case 'type-select':
		var addmore          = $('input[name="component_addmore"]').val();
		var optionName       =  getOptionscollection($('input[name="component_option_name[]"]'));
		var optionValue      =  getOptionscollection($('input[name="component_option_value[]"]'));
		var dischargeSummary =  $('input[name="component_discharge"]').val();

		componentHidden += '<input type="hidden" name="para_option_name[]" value="'+encodeURIComponent(optionName)+'" id="para_option_name'+groupId+'" >';
		componentHidden += '<input type="hidden" name="para_option_value[]" value="'+encodeURIComponent(optionValue)+'" id="para_option_value'+groupId+'" >';
		componentHidden += '<input type="hidden" name="para_addmore[]" value="'+addmore+'"  id="para_addmore'+groupId+'" >';
		componentHidden += '<input type="hidden" name="para_discharge[]" value="'+dischargeSummary+'"  id="para_discharge'+groupId+'" >';

		break;

		case 'type-toggle':
		var toggleOn         = $('input[name="component_toggle_on"]').val();
		var toggleOff        = $('input[name="component_toggle_off"]').val();
		var toggleWidth      = $('input[name="component_toggle_width"]').val();
		var toggleDependency =  createDependancyinput($('input[name="toggledependencyname[]"]'));
		var dischargeSummary =  $('input[name="component_discharge"]').val();
		componentHidden +='<input type="hidden" name="para_toggle_on[]" value="'+toggleOn+'" id="para_toggle_on'+groupId+'">';
		componentHidden +='<input type="hidden" name="para_toggle_off[]" value="'+toggleOff+'" id="para_toggle_off'+groupId+'">';
		componentHidden +='<input type="hidden" name="para_toggle_width[]" value="'+toggleWidth+'" id="para_toggle_width'+groupId+'">';   
		componentHidden +='<input type="hidden" name="para_toggle_dependancy[]" value="'+encodeURIComponent(toggleDependency)+'" id="para_toggle_dependancy'+groupId+'" >';
		componentHidden += '<input type="hidden" name="para_discharge[]" value="'+dischargeSummary+'"  id="para_discharge'+groupId+'" >';
		break;

		case 'type-horizontal-selector':

		var optionType  = $('input[name="component_option_type[]"]:checked').val();
		var optionName  =  getOptionscollection($('input[name="hcomponent_option_name[]"]'));
		var optionValue =  getOptionscollection($('input[name="hcomponent_option_value[]"]'));
		var optionColor =  getOptionscollection($('input[name="hcomponent_option_color[]"]'));
		var dischargeSummary =  $('input[name="component_discharge"]').val();

		componentHidden += '<input type="hidden" name="para_option_type[]" value="'+optionType+'" id="para_option_type'+groupId+'" >';
		componentHidden += '<input type="hidden" name="hpara_option_name[]" value="'+encodeURIComponent(optionName)+'" id="hpara_option_name'+groupId+'" >';
		componentHidden += '<input type="hidden" name="hpara_option_value[]" value="'+encodeURIComponent(optionValue)+'" id="hpara_option_value'+groupId+'" >';
		componentHidden += '<input type="hidden" name="hpara_option_color[]" value="'+encodeURIComponent(optionColor)+'" id="hpara_option_color'+groupId+'" >';
		componentHidden += '<input type="hidden" name="para_discharge[]"    value="'+dischargeSummary+'"  id="para_discharge'+groupId+'" >';

		break;

		case 'type-check-box':
		var chkName  = getOptionscollection($('input[name="component_chkop_name[]"]'));
		var chkValue = getOptionscollection($('input[name="component_chkop_value[]"]'));
		var dischargeSummary =  $('input[name="component_discharge"]').val();

		componentHidden += '<input type="hidden" name="para_chkop_name[]" value="'+encodeURIComponent(chkName)+'" id="para_chkop_name'+groupId+'" >';
		componentHidden += '<input type="hidden" name="para_chkop_value[]" value="'+encodeURIComponent(chkValue)+'" id="para_chkop_value'+groupId+'" >';
		componentHidden += '<input type="hidden" name="para_discharge[]"    value="'+dischargeSummary+'"  id="para_discharge'+groupId+'" >';

		break; 

		case 'type-radio': 
		var rdName  = getOptionscollection($('input[name="component_chkop_name[]"]'));
		var rdValue = getOptionscollection($('input[name="component_chkop_value[]"]'));
		var dischargeSummary =  $('input[name="component_discharge"]').val();

		componentHidden += '<input type="hidden" name="para_rdop_name[]" value="'+encodeURIComponent(rdName)+'" id="para_rdop_name'+groupId+'" >';
		componentHidden += '<input type="hidden" name="para_rdop_value[]" value="'+encodeURIComponent(rdValue)+'" id="para_rdop_value'+groupId+'" >';
		componentHidden += '<input type="hidden" name="para_discharge[]"    value="'+dischargeSummary+'"  id="para_discharge'+groupId+'" >';
		break; 

		case 'type-label':
		var dischargeSummary = $('input[name="component_discharge"]').val();
		var fontsize = $('input[name="component_fontsize"]').val(); 
		componentHidden +='<input type="hidden" name="para_fontsize[]" value="'+fontsize+'" id="para_fontsize'+groupId+'">';
		componentHidden += '<input type="hidden" name="para_discharge[]" value="'+dischargeSummary+'"  id="para_discharge'+groupId+'" >';

		break; 
		case 'type-drugs': 
		var dischargeSummary =  $('input[name="component_discharge"]').val();
		componentHidden += '<input type="hidden" name="para_discharge[]"    value="'+dischargeSummary+'"  id="para_discharge'+groupId+'" >';
		break; 
		case 'type-antibiotic': 
		var dischargeSummary =  $('input[name="component_discharge"]').val();
		componentHidden += '<input type="hidden" name="para_discharge[]"    value="'+dischargeSummary+'"  id="para_discharge'+groupId+'" >';
		break;     
		default:
		break;

	}
	return componentHidden;   
}

function setRequiredValue(validateRequired) {

	if (validateRequired == 1) {
		$('input[name="fval_required"]').prop('checked',true);
	} else {
		$('input[name="fval_required"]').prop('checked',false);
	}

}

function setAddmore(addMore) {
	if (addMore ==1) {
		$('input[name="fcomponent_addmore"]').prop('checked',true);

	} else {
		$('input[name="fcomponent_addmore"]').prop('checked',false);
	}
}

function setDischarge(dischargeSummary) {

	if (dischargeSummary ==1) {
		$('input[name="fcomponent_discharge"]').prop('checked',true);

	} else {
		$('input[name="fcomponent_discharge"]').prop('checked',false);
	}
}



function getHiddenSettings(componentType,groupId) {
	var name  = $('#para_name'+groupId).val();
	var label = $('#para_label'+groupId).val();

	switch (componentType) {
		case 'type-text':
		var placeholder      =  $('#para_placeholder'+groupId).val();
		var validateRequired =  $('#para_required'+groupId).val();
		var addMore          =  $('#para_addmore'+groupId).val();
		var dischargeSummary =  $('#para_discharge'+groupId).val();

		$('input[name="fcomponent_label"]').val(label);
		$('input[name="fcomponent_name"]').val(name);
		$('input[name="fcomponent_placeholder"]').val(placeholder);

		setAddmore(addMore);
		setRequiredValue(validateRequired);
		setDischarge(dischargeSummary);

		break;

		case 'type-number':
		var placeholder =  $('#para_placeholder'+groupId).val();
		var minLength   =  $('#para_min'+groupId).val();
		var maxLength   =  $('#para_max'+groupId).val();
		var dischargeSummary =  $('#para_discharge'+groupId).val();

		$('input[name="fcomponent_label"]').val(label);
		$('input[name="fcomponent_name"]').val(name);
		$('input[name="fcomponent_placeholder"]').val(placeholder);
		$('input[name="fmin"]').val(minLength);
		$('input[name="fmax"]').val(maxLength);
		setRequiredValue(validateRequired);
		setDischarge(dischargeSummary);
		setDigitdepentancy(groupId);

		break; 

		case 'type-decimal':
		var placeholder =  $('#para_placeholder'+groupId).val();
		var minLength   =  $('#para_min'+groupId).val();
		var maxLength   =  $('#para_max'+groupId).val();
		var dischargeSummary =  $('#para_discharge'+groupId).val();


		$('input[name="fcomponent_label"]').val(label);
		$('input[name="fcomponent_name"]').val(name);
		$('input[name="fcomponent_placeholder"]').val(placeholder);
		$('input[name="fmin"]').val(minLength);
		$('input[name="fmax"]').val(maxLength);
		setRequiredValue(validateRequired);
		setDischarge(dischargeSummary);
		setDecimaldepentancy(groupId);

		break; 

		case 'type-textarea':
		var rows =  $('#para_row'+groupId).val();
		var cols =  $('#para_column'+groupId).val();
		var dischargeSummary =  $('#para_discharge'+groupId).val();

		$('input[name="fcomponent_label"]').val(label);
		$('input[name="fcomponent_name"]').val(name);
		$('input[name="fnorow"]').val(rows);
		$('input[name="fnocolumn"]').val(cols);
		setRequiredValue(validateRequired);
		setDischarge(dischargeSummary);

		break;

		case 'type-select':
		var optionName      = $('#para_option_name'+groupId).val();
		var optionValue     = $('#para_option_value'+groupId).val();
		var optionType      = $('#para_option_type'+groupId).val();
		var optionCondition = $('#para_option_condition'+groupId).val();
		var addMore          =  $('#para_addmore'+groupId).val();
		var dischargeSummary =  $('#para_discharge'+groupId).val();


		$('input[name="fcomponent_label"]').val(label);
		$('input[name="fcomponent_name"]').val(name); 
		$('input[name="foption_type[]"]').each(function(){
			if($(this).val() == optionType){
				$(this).prop('checked',true);
			}
		});

		setDropboxOptions(optionName,optionValue,$('input[name="foption_name[]"]'),$('input[name="foption_value[]"]'),'drop-options',groupId);
		setAddmore(addMore);
		setDischarge(dischargeSummary);

		break;

		case 'type-toggle':
		var toggleOn    = $('#para_toggle_on'+groupId).val();
		var toggleOff   = $('#para_toggle_off'+groupId).val();
		var toggleWidth = $('#para_toggle_width'+groupId).val();
		var dischargeSummary =  $('#para_discharge'+groupId).val();


		$('input[name="fcomponent_label"]').val(label);
		$('input[name="fcomponent_name"]').val(name);
		$('input[name="ftoggleon"]').val(toggleOn);
		$('input[name="ftoggleoff"]').val(toggleOff);
		$('input[name="ftogglewidth"]').val(toggleWidth);
		setToggledepentancy(groupId);
		setDischarge(dischargeSummary);

		break;

		case 'type-horizontal-selector':
		var optionName  = $('#hpara_option_name'+groupId).val();
		var optionValue = $('#hpara_option_value'+groupId).val();
		var optionColor = $('#hpara_option_color'+groupId).val();
		var dischargeSummary =  $('#para_discharge'+groupId).val();

		$('input[name="fcomponent_label"]').val(label);
		$('input[name="fcomponent_name"]').val(name);
		setHorizontalselector(optionName,optionValue,optionColor,$('input[name="hfoption_name[]"]'),$('input[name="hfoption_value[]"]') ,$('input[name="hfoption_color[]"]'),'drop-options',groupId);
		setDischarge(dischargeSummary);

		break;

		case 'type-check-box':
		var chkopName  = $('#para_chkop_name'+groupId).val();
		var chkopValue = $('#para_chkop_value'+groupId).val(); 
		var dischargeSummary =  $('#para_discharge'+groupId).val();

		$('input[name="fcomponent_label"]').val(label);
		$('input[name="fcomponent_name"]').val(name); 
		setCheckboxOption(chkopName,chkopValue,$('input[name="fchkop_name[]"]'),$('input[name="fchkop_value[]"]'),'chk-options',groupId);
		setDischarge(dischargeSummary);

		break; 

		case 'type-radio': 
		var rdopName  = $('input[name="para_rdop_name[]"]').val();
		var rdopValue = $('input[name="para_rdop_value[]"]').val();
		var dischargeSummary =  $('#para_discharge'+groupId).val();

		$('input[name="fcomponent_label"]').val(label);
		$('input[name="fcomponent_name"]').val(name);
		setRadioboxOption(rdopName,rdopValue,$('input[name="frdop_name[]"]'),$('input[name="frdop_value[]"]'),'rdop-options',groupId);
		setDischarge(dischargeSummary);

		break;
		case 'type-label':
		var fontsize = $('#para_fontsize'+groupId).val();
		var dischargeSummary =  $('#para_discharge'+groupId).val();
		$('input[name="fcomponent_label"]').val(label);
		$('input[name="fcomponent_name"]').val(name);
		$('input[name="fcomponent_fontsize"]').val(fontsize);
		$('input[name="range_fontsize"]').val(fontsize);
		setDischarge(dischargeSummary);

		break;
		case 'type-drugs': 
		var dischargeSummary =  $('#para_discharge'+groupId).val();
		setDischarge(dischargeSummary);
		$('input[name="fcomponent_label"]').val(label);
		$('input[name="fcomponent_name"]').val(name);
		break;
		case 'type-antibiotic':
		var dischargeSummary =  $('#para_discharge'+groupId).val();
		setDischarge(dischargeSummary);
		$('input[name="fcomponent_label"]').val(label);
		$('input[name="fcomponent_name"]').val(name);
		break;  
		default:
		break;

	}

}





function getComponentoption(optionName) {
	var options = [];
	for (i = 0; i < optionName.length; i++) {
		if ($(optionName[i]).val() != '') {
			options.push($(optionName[i]).val());
		}

	}

	return options;

}

function getComponentdesignation() {

	var containerLength = $(masterLayout.containerSelector).length;
	if(containerLength == 1) {

		return 'single-column-problem';

	} else if(containerLength == 2) {

		return $('select[name="component_position"]').val();

	} 

	return false; 
}

function getOptionMaster(masterName) {

	var  masterName = masterName.toString();
	$.ajax({
		type     :"GET",
		url      :$('input[name="dropoptionuri"]').val(),
		dataType :"html",
		data     :{masterName:masterName},
		success  :function(response){

		},
		complete :function(){

		}
	});
}


function getComponentValues(componentSelector) {

	return $(componentSelector).val();

}

function addtoContainer(componentDesignation,componentGroup,componentId) {

	if(componentDesignation != false) {
		$('.'+componentDesignation+'> h3').remove();
		$('.'+componentDesignation).append(componentGroup);
		basicComponentListner(componentId);

	} else {
		Showalert('error','Layout Not Selected !');
	}
}

// function propertyNamingset(name) {
//   var tempName = trim(name);



// }



function createComponent() {
	var componentType        = $('input[name="component_type"]').val(); 
	var label                = $('input[name="component_label"]').val();
	var componentClass       = componentInitialvalues.class;  
	var Grouplength          = $(componentInitialvalues.groupClass).length+1;
	var groupId              = componentInitialvalues.groupId+Grouplength;
	var componentParameter   = setHiddenSetting(componentType,Grouplength);
	var componentDesignation = getComponentdesignation();
	 //var name                 = propertyNamingset(label);


	 switch (componentType) {
	 	case 'type-text':

	 	var name             = getComponentValues($('input[name="component_name"]')); 
	 	var placeholder      = getComponentValues($('input[name="component_placeholder"]')); 
	 	var componentHtml    = singleLine(label,name,componentClass,placeholder);
	 	var componentGroup   = formGroupContainer(componentHtml,componentParameter,groupId,Grouplength);
	 	addtoContainer(componentDesignation,componentGroup,groupId);
	 	break;

	 	case 'type-number':
	 	var name            = getComponentValues($('input[name="component_name"]')); 
	 	var placeholder     = getComponentValues($('input[name="component_placeholder"]')); 
	 	var componentHtml   = numberBox(label,name,componentClass,placeholder);
	 	var componentGroup  = formGroupContainer(componentHtml,componentParameter,groupId,Grouplength);
	 	addtoContainer(componentDesignation,componentGroup,groupId);
	 	break; 

	 	case 'type-decimal':
	 	var name            = getComponentValues($('input[name="component_name"]')); 
	 	var placeholder     = getComponentValues($('input[name="component_placeholder"]')); 
	 	var componentHtml   = decimalBox(label,name,componentClass,placeholder);
	 	var componentGroup  = formGroupContainer(componentHtml,componentParameter,groupId,Grouplength);
	 	addtoContainer(componentDesignation,componentGroup,groupId);
	 	break; 

	 	case 'type-textarea':
	 	var name            = getComponentValues($('input[name="component_name"]')); 
	 	var noRow           = getComponentValues($('input[name="component_row"]')); 
	 	var noColumn        = getComponentValues($('input[name="component_col"]')); 
	 	var componentHtml   = multipleLine(label,name,componentClass,noRow,noColumn);
	 	var componentGroup  = formGroupContainer(componentHtml,componentParameter,groupId,Grouplength);
	 	addtoContainer(componentDesignation,componentGroup,groupId);

	 	break;

	 	case 'type-select':
	 	var name            = getComponentValues($('input[name="component_name"]')); 
	 	var optionName       = getComponentoption($('input[name="component_option_name[]"]'));
	 	var optionValue      = getComponentoption($('input[name="component_option_value[]"]'));
	 	var componentHtml    = dropBox(label,name,componentClass,optionName,optionValue);
	 	var componentGroup  = formGroupContainer(componentHtml,componentParameter,groupId,Grouplength);
	 	addtoContainer(componentDesignation,componentGroup,groupId);
	 	break;

	 	case 'type-toggle':
	 	var name            = getComponentValues($('input[name="component_name"]')); 
	 	var toggleOn   = getComponentValues($('input[name="component_toggle_on"]')); 
	 	var toggleOff  = getComponentValues($('input[name="component_toggle_off"]')); 
	 	var toggleSize = getComponentValues($('input[name="component_toggle_width"]'));  
	 	var componentHtml = toggleBox(label,name,componentClass,toggleOn,toggleOff,toggleSize);
	 	var componentGroup  = formGroupContainer(componentHtml,componentParameter,groupId,Grouplength);
	 	addtoContainer(componentDesignation,componentGroup,groupId);
	 	$('#'+name).bootstrapToggle();

	 	break;

	 	case 'type-horizontal-selector':
	 	var optionName      = getComponentoption($('input[name="hcomponent_option_name[]"]'));
	 	var optionValue     = getComponentoption($('input[name="hcomponent_option_value[]"]')); 
	 	var optionColor     = getComponentoption($('input[name="hcomponent_option_color[]"]'));
	 	optionColor         = JSON.stringify(optionColor); 
	 	var componentHtml   = horizontalDotselector(label,name,componentClass,optionColor,optionName,optionValue); 
	 	var componentGroup  = formGroupContainer(componentHtml,componentParameter,groupId,Grouplength);
	 	addtoContainer(componentDesignation,componentGroup,groupId);
	 	buildSelector(name);
	 	break;

	 	case 'type-check-box':
	 	var name            = getComponentValues($('input[name="component_name"]')); 
	 	var optionName      = getComponentoption($('input[name="component_chkop_name[]"]'));
	 	var optionValue     = getComponentoption($('input[name="component_chkop_value[]"]')); 
	 	var componentHtml   = checkBoxgroup(label,name,optionName,optionValue,componentClass);
	 	var componentGroup  = formGroupContainer(componentHtml,componentParameter,groupId,Grouplength);
	 	addtoContainer(componentDesignation,componentGroup,groupId);
	 	break; 

	 	case 'type-radio': 
	 	var name            = getComponentValues($('input[name="component_name"]'));
	 	var optionName      = getComponentoption($('input[name="component_chkop_name[]"]'));
	 	var optionValue     = getComponentoption($('input[name="component_chkop_value[]"]')); 
	 	var componentHtml   = radioBox(label,name,optionName,optionValue,componentClass);
	 	var componentGroup  = formGroupContainer(componentHtml,componentParameter,groupId,Grouplength);
	 	addtoContainer(componentDesignation,componentGroup,groupId);
	 	break;

	 	case 'type-label':
	 	var name            = getComponentValues($('input[name="component_name"]'));
	 	var fontsize        = getComponentValues($('input[name="component_fontsize"]'));
	 	var componentHtml   = labelField(label, fontsize);
	 	var componentGroup  = formGroupContainer(componentHtml,componentParameter,groupId,Grouplength);
	 	addtoContainer(componentDesignation,componentGroup,groupId);
	 	break;

	 	case 'type-drugs':
	 	var name            = getComponentValues($('input[name="component_name"]'));
	 	var componentHtml   = medicineBox(label,name,componentClass);
	 	var componentGroup  = formGroupContainer(componentHtml,componentParameter,groupId,Grouplength);
	 	addtoContainer(componentDesignation,componentGroup,groupId);
	 	break;
	 	case 'type-antibiotic':
	 	var name            = getComponentValues($('input[name="component_name"]'));
	 	var componentHtml   = antibioticBox(label,name,componentClass);
	 	var componentGroup  = formGroupContainer(componentHtml,componentParameter,groupId,Grouplength);
	 	addtoContainer(componentDesignation,componentGroup,groupId);
	 	break;

	 	default:
	 	break;

	 }
	}


/* This will rebuild the dropbox and horizantal selector option 
 * parameter while trigger on keyup event
 *
 * designationElement type object
 */

 function rebuildOptionsencode(sourceElement,designationElement) {

 	var name    = sourceElement.attr('name');
 	var opValue = [];
 	$('input[name="'+name+'"]').each(function() {

 		opValue.push($(this).val());

 	});
 	designationElement.val(encodeURIComponent(JSON.stringify(opValue)));
 }


/* This will rebuild the dropbox and horizantal selector options 
 *
 * designationElement type object
 */
 function rebuildDropbox(designationElement) {

 	var componentType = designationElement.siblings('input[name="para_type[]"]').val();

 	if(designationElement.attr('name') == 'para_option_name[]') {

 		var optionName    =  designationElement.val();
 		optionName    =  JSON.parse(decodeURIComponent(optionName));

 		var optionValue   = designationElement.siblings('input[name="para_option_value[]"]').val();
 		optionValue   = JSON.parse(decodeURIComponent(optionValue));  

 		var optionColor   = designationElement.siblings('input[name="para_option_color[]"]').val();


 	} else if(designationElement.attr('name') == 'para_option_value[]') {

 		var optionName   = designationElement.siblings('input[name="para_option_name[]"]').val();
 		optionName   = JSON.parse(decodeURIComponent(optionName));

 		var optionValue   = designationElement.val();
 		optionValue   = JSON.parse(decodeURIComponent(optionValue));

 		var optionColor   = designationElement.siblings('input[name="para_option_color[]"]').val();


 	} else if(designationElement.attr('name') == 'hpara_option_name[]') {

 		var optionName    =  designationElement.val();
 		optionName    =  JSON.parse(decodeURIComponent(optionName));

 		var optionValue   = designationElement.siblings('input[name="hpara_option_value[]"]').val();
 		optionValue   = JSON.parse(decodeURIComponent(optionValue));  

 		var optionColor   = designationElement.siblings('input[name="hpara_option_color[]"]').val();


 	} else if(designationElement.attr('name') == 'hpara_option_value[]') {

 		var optionName   = designationElement.siblings('input[name="hpara_option_name[]"]').val();
 		optionName   = JSON.parse(decodeURIComponent(optionName));

 		var optionValue   = designationElement.val();
 		optionValue   = JSON.parse(decodeURIComponent(optionValue));

 		var optionColor   = designationElement.siblings('input[name="hpara_option_color[]"]').val();


 	} else if(designationElement.attr('name') == 'hpara_option_color[]') {

 		var optionName   = designationElement.siblings('input[name="hpara_option_name[]"]').val();
 		optionName   = JSON.parse(decodeURIComponent(optionName));

 		var optionValue   = designationElement.siblings('input[name="hpara_option_value[]"]').val();
 		optionValue   = JSON.parse(decodeURIComponent(optionValue));

 		var optionColor   = designationElement.val();

 	}

 	var optionsSelector = ''; 

 	for (var i = 0; i < optionName.length; i++) {
 		optionsSelector  +='<option value="'+optionValue[i].replace(/\+/g," ")+'">'+optionName[i].replace(/\+/g," ")+'</option>';        
 	}    

 	designationElement.siblings('select').html(optionsSelector);

 	if(componentType == 'type-horizontal-selector' && optionColor != 'undefind') {

 		optionColor = decodeURIComponent(optionColor);
 		designationElement.siblings('table').remove();
 		designationElement.siblings('select').removeClass('hs-binded').removeAttr('style');
 		designationElement.siblings('select').attr('data-color',optionColor);
 		var selectId = designationElement.siblings('select').attr('id');
 		buildSelector(selectId);

 	}



 }

/* This will rebuild the toggle buttons
 *
 * designationElement type object
 */

 function rebuildTogglebutton(designationElement) {

 	var toggleId      = designationElement.siblings('input[name="para_name[]"]').val();
 	var elementName   = designationElement.attr('name');

 	if(elementName == 'para_toggle_on[]') {

 		var toggleOnname   = designationElement.val();
 		var toggleOffname  = designationElement.siblings('input[name="para_toggle_off[]"]').val();
 		var toggleSize     = designationElement.siblings('input[name="para_toggle_width[]"]').val();

 	} else if(elementName == 'para_toggle_off[]') {

 		var toggleOnname   = designationElement.siblings('input[name="para_toggle_on[]"]').val();
 		var toggleOffname  = designationElement.val();
 		var toggleSize     = designationElement.siblings('input[name="para_toggle_width[]"]').val();

 	} else if(elementName == 'para_toggle_width[]') {

 		var toggleOnname   = designationElement.siblings('input[name="para_toggle_on[]"]').val();
 		var toggleOffname  = designationElement.siblings('input[name="para_toggle_off[]"]').val();
 		var toggleSize     = designationElement.val();

 	}
 	$('#'+toggleId).bootstrapToggle('destroy');
 	$('#'+toggleId).bootstrapToggle({ on: toggleOnname,
 		off: toggleOffname, 
 		width: toggleSize });


 }


/* This will rebuild the check box option
 *
 * designationElement type object
 */

 function rebuildCheckbox(designationElement) {

 	var typeofComponent = designationElement.attr('name');
 	var checkboxOption  = designationElement.siblings('input[name="para_name[]"]').val();

 	if(typeofComponent == 'para_chkop_name[]') {
 		var  checkName  = designationElement.val();
 		var  checkValue = designationElement.siblings('input[name="para_chkop_value[]"]').val();

 	} else if(typeofComponent == 'para_chkop_value[]') {
 		var  checkName  = designationElement.siblings('input[name="para_chkop_name[]"]').val();
 		var  checkValue = designationElement.val();
 	}

 	checkName = JSON.parse(decodeURIComponent(checkName));
 	checkValue = JSON.parse(decodeURIComponent(checkValue));

 	var checkboxHtml = '';
 	for (var i = 0; i < checkName.length; i++) {
 		checkboxHtml +='<label class="radio-inline"><input name="'+checkboxOption+'[]" value="'+checkValue[i]+'" type="checkbox">'+checkName[i]+'</label>';
 	}
 	designationElement.siblings('div[class="checkbox-group"]').html(checkboxHtml);

 }


/* This will rebuild the radio box
 *
 * designationElement type object
 */

 function rebuildRadiogroup(designationElement) {

 	var typeofComponent = designationElement.attr('name');
 	var checkboxOption  = designationElement.siblings('input[name="para_name[]"]').val();


 	if(typeofComponent == 'para_rdop_name[]') {

 		var  rdopName  = designationElement.val();
 		var  rdopValue = designationElement.siblings('input[name="para_rdop_value[]"]').val();

 	} else if(typeofComponent == 'para_rdop_value[]') {
 		var  rdopName  = designationElement.siblings('input[name="para_rdop_name[]"]').val();
 		var  rdopValue = designationElement.val();
 	}

 	var checkName = JSON.parse(decodeURIComponent(rdopName));
 	var checkValue = JSON.parse(decodeURIComponent(rdopValue));


 	var checkboxHtml = '';
 	for (var i = 0; i < checkName.length; i++) {
 		checkboxHtml +='<label class="radio-inline"><input name="'+checkboxOption+'[]" value="'+checkValue[i]+'" type="radio">'+checkName[i]+'</label>';
 	}
 	designationElement.siblings('div[class="radio-group"]').html(checkboxHtml);

 }

 function rebuildRequiredoption(sourceElement,designationElement) {

 	var validateRequiredName = sourceElement.attr('name');

 	if($('input[name="'+validateRequiredName+'"]').prop('checked') == true) {
 		designationElement.val('1');
 	} else {
 		designationElement.val('0');
 	} 

 }



/*This will rebuild components property  
 *
 *sourceElement type object
 *designationElement type object
 */

 function rebuildComponentproperty(sourceElement,designationElement) {

 	var typeOfproperty  = designationElement.attr('name');

 	switch(typeOfproperty) {
 		case 'para_label[]':
 		designationElement.siblings('label').text(sourceElement.val());
 		designationElement.val(sourceElement.val());
 		break;

 		case 'para_name[]':
 		designationElement.val(sourceElement.val());
 		designationElement.siblings('input[class="form-control show-input"]').attr('name',sourceElement.val());
 		break; 

 		case 'para_placeholder[]':
 		designationElement.val(sourceElement.val());
 		var name =  designationElement.siblings('input[name="para_name[]"]').val();
 		$('input[name="'+name+'"]').attr('placeholder',sourceElement.val());              
 		break; 

 		case 'para_row[]':
 		designationElement.val(sourceElement.val());
 		var name =  designationElement.siblings('input[name="para_name[]"]').val();
 		$('textarea[name="'+name+'"]').attr('rows',sourceElement.val());              
 		break;

 		case 'para_column[]':
 		designationElement.val(sourceElement.val());
 		var name =  designationElement.siblings('input[name="para_name[]"]').val();
 		$('textarea[name="'+name+'"]').attr('cols',sourceElement.val());  
 		break;

 		case 'para_option_type[]':
 		designationElement.val(sourceElement.val());

 		break;
 		case 'para_option_name[]':
 		rebuildOptionsencode(sourceElement,designationElement); 
 		rebuildDropbox(designationElement);
 		break;

 		case 'para_option_value[]':
 		rebuildOptionsencode(sourceElement,designationElement); 
 		rebuildDropbox(designationElement);
 		break;

 		case 'hpara_option_name[]':
 		rebuildOptionsencode(sourceElement,designationElement); 
 		rebuildDropbox(designationElement);
 		break;

 		case 'hpara_option_value[]':
 		rebuildOptionsencode(sourceElement,designationElement); 
 		rebuildDropbox(designationElement);
 		break;

 		case 'hpara_option_color[]':
 		rebuildOptionsencode(sourceElement,designationElement); 
 		rebuildDropbox(designationElement);
 		break;

 		case 'para_toggle_on[]':
 		designationElement.val(sourceElement.val());
 		rebuildTogglebutton(designationElement);
 		break;

 		case 'para_toggle_off[]':
 		designationElement.val(sourceElement.val());
 		rebuildTogglebutton(designationElement);
 		break;

 		case 'para_toggle_width[]':
 		designationElement.val(sourceElement.val());
 		rebuildTogglebutton(designationElement);
 		break; 

 		case 'para_chkop_name[]':
 		rebuildOptionsencode(sourceElement,designationElement); 
 		rebuildCheckbox(designationElement);
 		break; 

 		case 'para_chkop_value[]':
 		rebuildOptionsencode(sourceElement,designationElement); 
 		rebuildCheckbox(designationElement);
 		break;

 		case 'para_rdop_name[]':
 		rebuildOptionsencode(sourceElement,designationElement);
 		rebuildRadiogroup(designationElement);
 		break; 

 		case 'para_rdop_value[]':
 		rebuildOptionsencode(sourceElement,designationElement);
 		rebuildRadiogroup(designationElement);
 		break;

 		case 'para_required[]':
 		rebuildRequiredoption(sourceElement,designationElement);
 		break;
 		case 'para_min[]':
 		designationElement.val(sourceElement.val());
 		break;
 		case 'para_max[]':
 		designationElement.val(sourceElement.val());
 		break;
 		case "para_fontsize[]":
 		designationElement.val(sourceElement.val());
 		designationElement.siblings('label').attr('style', 'font-size:'+sourceElement.val()+'px !important;');
 		break;
 		case 'para_addmore[]':
 		rebuildRequiredoption(sourceElement,designationElement);
 		break;
 		case 'para_discharge[]':
 		rebuildRequiredoption(sourceElement,designationElement);
 		break;
 		default:
 		break;

 	}
 }


 function toggleChanges(toggle) {

 	var  dependancy        = toggle.parent().siblings('input[name="para_toggle_dependancy[]"]').val();
 	dependancy        = JSON.parse(decodeURIComponent(dependancy));
 	var  toggleOnLabel     = toggle.data('on').replace(/\+/g ," ");
 	var  toggleOffLabel    = toggle.data('off').replace(/\+/g ," ");
 	var  propertyChecked   = toggle.prop('checked');

 	$.each(dependancy,function(index,value) {

 		if (value.dependencyName.replace(/\+/g ," ") == toggleOnLabel) {

 			if (propertyChecked == true) {

 				if (value.dependencyValue != null) {
 					$.each(value.dependencyValue, function(dindex, dvalue) {
 						$('input[name="para_name[]"]').each(function(pIndex,pVaalue) {
 							if ( pVaalue.value.replace('[]','') == dvalue.replace('+',''))  {    
 								var parentClass = findParentClass($('input[name="para_name[]"][value="'+$(this).val()+'"]')[0],'form-part');
 								$('#'+parentClass.id).slideDown();
 							}
 						});
 					});
 				}  

 			}else {
 				if (value.dependencyValue != null) {
 					$.each(value.dependencyValue, function(dindex, dvalue) {

 						$('input[name="para_name[]"]').each(function(pIndex,pVaalue) {
 							if ( pVaalue.value.replace('[]','') == dvalue.replace('+',''))  {    
 								var parentClass = findParentClass($('input[name="para_name[]"][value="'+$(this).val()+'"]')[0],'form-part');
 								$('#'+parentClass.id).slideDown();
 							}
 						});

 					});
 				}  
 			}  

 		}

 		if (value.dependencyName.replace(/\+/g ," ") == toggleOffLabel) {

 			if (propertyChecked == false) {
 				if (value.dependencyValue != null) {
 					$.each(value.dependencyValue, function(dindex, dvalue) {
 						$('input[name="para_name[]"]').each(function(pIndex,pVaalue) {
 							if ( pVaalue.value.replace('[]','') == dvalue.replace('+',''))  {    
 								var parentClass = findParentClass($('input[name="para_name[]"][value="'+$(this).val()+'"]')[0],'form-part');
 								$('#'+parentClass.id).slideUp();
 							}
 						});
 					});
 				}  

 			}else {
 				if (value.dependencyValue != null) {
 					$.each(value.dependencyValue, function(dindex, dvalue) {
 						$('input[name="para_name[]"]').each(function(pIndex,pVaalue) {
 							if ( pVaalue.value.replace('[]','') == dvalue.replace('+',''))  {    
 								var parentClass = findParentClass($('input[name="para_name[]"][value="'+$(this).val()+'"]')[0],'form-part');
 								$('#'+parentClass.id).slideDown();
 							}
 						});
 					});
 				}  
 			}  

 		}

 	});
 }


 function addErrorbox(elementSelector) {

 	elementSelector.css('border-color','red');

 }

 function removeErrorbox(elementSelector) {

 	elementSelector.css('border-color','#ccc');

 }

 function checkEmptyoption(elementSelector,flage) {

 	elementSelector.each(function() {

 		if ($(this).val() == '') {
 			addErrorbox($(this));
 			flage = false;
 		} else {
 			removeErrorbox($(this));
 		} 

 	}); 

 	return flage;
 }


 /* set the toggle dependancy for sidebar */
 function setDecimaldepentancy(groupId) {

 	var dependancyValue = $('#para_decimal_dependancy'+groupId).val();

 	if (typeof dependancyValue != "undefined" && dependancyValue != "") {
 		var dependancyValue = JSON.parse(decodeURIComponent(dependancyValue));
 	} else {
 		var dependencyValue = [];
 	}

 	var deicmalDependency  = '<div class="form-group option-dependancy">';
 	deicmalDependency += '<label for="fcondition">Dependancy Conditions : </label>';
 	deicmalDependency += '<table class="table">';
 	deicmalDependency += '<thead>';
 	deicmalDependency += '<tr>';
 	deicmalDependency += '<th>Options :</th>';
 	deicmalDependency += '<th>Action :</th>';
 	deicmalDependency += '</tr>';
 	deicmalDependency += '</thead>';
 	deicmalDependency += '<tbody>';

 	var actionlist = ['Addition', 'Substraction', 'Multiplication', 'Division'];

 	if (typeof dependancyValue == "undefined" || dependancyValue.length == 0) {
 		var index = 1;
 		deicmalDependency += '<input class="form-control field-property" readonly="true" value="'+$('#para_name'+groupId).val()+'" data-og-element-id="para_decimal_dependancy'+groupId+'" name="foption_dependancy_name[]" type="hidden">';
 		deicmalDependency += '<tr data-len='+index+'>';
 		deicmalDependency += '<td><select class="field-property input-width-large" id="foption_dependancy'+index+'" data-og-element-id="para_decimal_dependancy'+groupId+'" name="foption_dependancy_value[]" >' ; 
 		deicmalDependency += '<option value="N/A" disabled>N/A</option>';
 		deicmalDependency += getListofComponentsNumber(null, $('#para_name'+groupId).val());
 		deicmalDependency += '</select></td>';
 		deicmalDependency += '<td><span class="btn btn-default fa fa-calculator cal-add-button"></span>';
 		deicmalDependency += '<span class="fa fa-remove btn btn-default remove-toggle-select remove-button"></span></td>';
 		deicmalDependency += '</tr>';
 		$('#component-property').append(deicmalDependency);
 		RebuildMultipleselector($('#foption_dependancy'+index));
 	} else {
 		for (var i = 0; i < dependancyValue.length; i++) {

 			var index = i +1;
 			deicmalDependency += '<input class="form-control field-property" readonly="true" value="'+dependancyValue[i].dependencyName+'" data-og-element-id="para_decimal_dependancy'+groupId+'" name="foption_dependancy_name[]" type="hidden">';
 			deicmalDependency += '<tr data-len='+index+'>';
 			deicmalDependency += '<td><select class="field-property input-width-large" id="foption_dependancy'+index+'" data-og-element-id="para_decimal_dependancy'+groupId+'" name="foption_dependancy_value[]" >' ; 
 			deicmalDependency += '<option value="N/A" disabled>N/A</option>';

 			if (actionlist.includes(dependancyValue[i].dependencyValue)) {
 				deicmalDependency += getListofActionComponents(dependancyValue[i].dependencyValue);
 			} else {
 				deicmalDependency += getListofComponentsNumber(dependancyValue[i].dependencyValue, $('#para_name'+groupId).val());
 			}
 			deicmalDependency += '</select></td>';
 			if (actionlist.includes(dependancyValue[i].dependencyValue)) {
 				deicmalDependency += '<td><span class="btn btn-default fa fa-plus decimal-add-button"></span>';
 			} else {
 				deicmalDependency += '<td><span class="btn btn-default fa fa-calculator cal-add-button"></span>';
 			}
 			deicmalDependency += '<span class="fa fa-remove btn btn-default remove-toggle-select remove-button"></span></td>';
 			deicmalDependency += '</tr>';
 		}

 		deicmalDependency += '</tbody>';
 		deicmalDependency += '</div>';
 		$('#component-property').append(deicmalDependency);

 		for (var i = 0; i < dependancyValue.length; i++) {
 			var index = i +1;
 			RebuildMultipleselector($('#foption_dependancy'+index));
 		}  
 	}

 }

 function createDependancyDigit(dependencyName) {

 	var dependencyNameset = [];
 	var i = 1;
 	dependencyName.each(function(){

 		var tempDependancy = {
 			'dependencyName'  : $(this).val(),
 			'dependencyValue' : $('#dependency'+i).val(),

 		};

 		dependencyNameset.push(tempDependancy);


 		i++;
 	});
 	return JSON.stringify(dependencyNameset);

 }

 /* set the digit dependancy for sidebar */
 function setDigitdepentancy(groupId) {

 	var dependancyValue = $('#para_digit_dependancy'+groupId).val();

 	if (typeof dependancyValue != "undefined" && dependancyValue != "") {
 		var dependancyValue = JSON.parse(decodeURIComponent(dependancyValue));
 	} else {
 		var dependencyValue = [];
 	}

 	var digitDependency  = '<div class="form-group option-dependancy">';
 	digitDependency += '<label for="fcondition">Dependancy Conditions : </label>';
 	digitDependency += '<table class="table">';
 	digitDependency += '<thead>';
 	digitDependency += '<tr>';
 	digitDependency += '<th>Options :</th>';
 	digitDependency += '<th>Action :</th>';
 	digitDependency += '</tr>';
 	digitDependency += '</thead>';
 	digitDependency += '<tbody>';
 	var actionlist = ['Addition', 'Substraction', 'Multiplication', 'Division'];

 	if (typeof dependancyValue == "undefined" || dependancyValue.length == 0) {
 		var index = 1;
 		digitDependency += '<input class="form-control field-property" readonly="true" value="'+$('#para_name'+groupId).val()+'" data-og-element-id="para_digit_dependancy'+groupId+'" name="foption_dependancy_name[]" type="hidden">';
 		digitDependency += '<tr data-len='+index+'>';
 		digitDependency += '<td><select class="field-property input-width-large" id="foption_dependancy'+index+'" data-og-element-id="para_digit_dependancy'+groupId+'" name="foption_dependancy_value[]" >' ; 
 		digitDependency += '<option value="N/A" disabled>N/A</option>';
 		digitDependency += getListofComponentsNumber(null, $('#para_name'+groupId).val());
 		digitDependency +='</select></td>';
 		digitDependency += '<td><span class="btn btn-default fa fa-calculator cal-add-button"></span>';
 		digitDependency += '<span class="fa fa-remove btn btn-default remove-toggle-select remove-button"></span></td>';
 		digitDependency += '</tr>';
 		$('#component-property').append(digitDependency);
 		RebuildMultipleselector($('#foption_dependancy'+index));
 	} else {
 		for (var i = 0; i < dependancyValue.length; i++) {
 			var index = i +1;
 			digitDependency += '<input class="form-control field-property" readonly="true" value="'+dependancyValue[i].dependencyName+'" data-og-element-id="para_digit_dependancy'+groupId+'" name="foption_dependancy_name[]" type="hidden">';
 			digitDependency += '<tr data-len='+index+'>';
 			digitDependency += '<td><select class="field-property input-width-large" id="foption_dependancy'+index+'" data-og-element-id="para_digit_dependancy'+groupId+'" name="foption_dependancy_value[]" >' ; 
 			digitDependency += '<option value="N/A" disabled>N/A</option>';

 			if (actionlist.includes(dependancyValue[i].dependencyValue)) {
 				digitDependency += getListofActionComponents(dependancyValue[i].dependencyValue);
 			} else {
 				digitDependency += getListofComponentsNumber(dependancyValue[i].dependencyValue, $('#para_name'+groupId).val());
 			} 
 			digitDependency +='</select></td>';
 			if (actionlist.includes(dependancyValue[i].dependencyValue)) {
 				digitDependency += '<td><span class="btn btn-default fa fa-plus digit-add-button"></span>';
 			} else {
 				digitDependency += '<td><span class="btn btn-default fa fa-calculator cal-add-button"></span>';
 			}
 			digitDependency += '<span class="fa fa-remove btn btn-default remove-toggle-select remove-button"></span></td>';
 			digitDependency += '</tr>';
 		}
 		digitDependency += '</tbody>';
 		digitDependency +='</div>';
 		$('#component-property').append(digitDependency);

 		for (var i = 0; i < dependancyValue.length; i++) {
 			var index = i +1;
 			RebuildMultipleselector($('#foption_dependancy'+index));
 		}  
 	}

 }





























