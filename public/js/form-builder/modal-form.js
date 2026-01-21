/* get the components name with select box for modal depadancy */
function getComponentslists(optionNumber) {
  var componentLength = $('input[name="para_name[]"]').length;
  var para_name     = $('input[name="para_name[]"]'); 
  var componentList = '<select name="component_dependancy[]" class="input-width-large component-dependancy input-background" id="dependency'+optionNumber+'" multiple = true>' ; 
  for (var i = 1; i <=componentLength; i++) {

    componentList += '<option value="'+$('#para_name'+i).val().replace('[]','')+'">'+$('#para_label'+i).val()+'</option>';

  }
   componentList +='</select>';

   return componentList;

}

/* Initialze the select2 object for dependancy select box  */
function createMultipleselector(conditionSelectbox) {

    conditionSelectbox.select2({allowClear: true}).on('removed',function(e) {
              if(e && e.type=='removed') {
                 $('select[name="component_dependancy[]"]').each(function() {
                   $(this).children('option[value="'+e.val+'"]').removeAttr('disabled');
                 });

              }

    }).on('select2-selecting',function(e) {

               var id = $(this).attr('id');

              if(e && e.type == 'select2-selecting') {
                $('select[name="component_dependancy[]"]').each(function(){
                   if(id != $(this).attr('id')) {
                     $(this).children('option[value="'+e.val+'"]').prop('disabled',true);
                   }

                });

              }  
                
    });

}

/* create the toggle depandancy form fields */
function toggleDependency(component) {
  var dependencyCondition   ='<table class="table toggledependency-table">';
      dependencyCondition  +='<thead><tr>';
      dependencyCondition  +='<th>'+dependencyProperty.optionName+'</th>';
      dependencyCondition  +='<th>'+dependencyProperty.componentName+'</th>';
      dependencyCondition  +='</tr></thead>';
      dependencyCondition  +='<tbody>';
      dependencyCondition  +='<tr>';
      dependencyCondition  +='<td><input type="text" name="toggledependencyname[]" id="toggle_dependancy_on" class="form-control input-background" readonly="true" value="'+$('input[name="component_toggle_on"]').val()+'"></td>';
      dependencyCondition  +='<td>'+getComponentslists(1)+'</td>';
      dependencyCondition  +='</tr>';
      dependencyCondition  +='<tr>';
      dependencyCondition  +='<td><input type="text" name="toggledependencyname[]" id="toggle_dependancy_off" class="form-control input-background" readonly="true" value="'+$('input[name="component_toggle_off"]').val()+'"></td>';
      dependencyCondition  +='<td>'+getComponentslists(2)+'</td>';
      dependencyCondition  +='</tr>';
      dependencyCondition  +='</tbody>';
      dependencyCondition  +='</table>';
      if($('#fields-form > .modal-body > .col-md-12 > .form-group').hasClass('toggledependency-table')){
        $('.toggledependency-table').remove();
      }
      $('#fields-form > .modal-body > .col-md-12').append(dependencyCondition);

      createMultipleselector($('#dependency1'));
      createMultipleselector($('#dependency2'));

   
}

/* create the dropbox depandancy form fields */
function dropBoxdependency(component) {

  var multipleSelector =[];

  var dependencyCondition   ='<table class="table dependency-condition-table">';
      dependencyCondition  +='<thead><tr>';
      dependencyCondition  +='<th>'+dependencyProperty.optionName+'</th>';
      dependencyCondition  +='<th>'+dependencyProperty.componentName+'</th>';
      dependencyCondition  +='</tr></thead>';
      dependencyCondition  +='<tbody>';
  var optionNumber = 1;
      $('input[name="component_option_name[]"]').each(function() {
        multipleSelector.push('dependency'+optionNumber);
        dependencyCondition +='<tr>';
        dependencyCondition +='<td><input type="text" name="" class="form-control input-background" readonly="true" value="'+$(this).val()+'"></td>';
        dependencyCondition +='<td>'+getComponentslists(optionNumber)+'</td>';
        dependencyCondition +='</tr>';
        optionNumber++;
      });
      dependencyCondition  +='</tbody>';
      dependencyCondition  +='</table>';
      if(component.parent().siblings('table').hasClass('dependency-condition-table')){
        $('.dependency-condition-table').remove();
      }
      component.parent().after(dependencyCondition);

      $.each(multipleSelector,function(index,value) {
          var conditionSelectbox = $('#'+value);
          createMultipleselector(conditionSelectbox);
      });  

}

/* get the components name with select box for modal depadancy */
function getCalculationComponents(optionNumber, currentlabel = "") {
  var componentLength = $('input[name="para_name[]"]').length;
  var para_name     = $('input[name="para_name[]"]'); 
  var componentList = '<select name="component_dependancy[]" class="input-width-large component-dependancy input-background" id="dependency'+optionNumber+'">' ; 
      componentList += '<option value="N/A">N/A</option>';
  
  for (var i = 1; i <=componentLength; i++) {
    var field = $('#para_name'+i).val();
    if ($("input[name='"+field+"']").attr("type") == "number" && $('#para_name'+i).val() != currentlabel) {
      componentList += '<option value="'+$('#para_name'+i).val().replace('[]','')+'">'+$('#para_label'+i).val()+'</option>';
    }

  }
   componentList +='</select>';

   return componentList;

}

/* get the components name with select box for modal depadancy */
function getCalculation(optionNumber) {
  
  var manipulationval = ['Addition', 'Substraction', 'Multiplication', 'Division'];
  var manipulationlabel = ['Addition (+)', 'Substraction (-)', 'Multiplication (*)', 'Division (/)'];
  var actionList = '<select name="component_dependancy[]" class="input-width-large calculation-dependancy input-background" id="dependency'+optionNumber+'">'; 
  
  for (var i = 0; i < manipulationval.length; i++) {

    actionList += '<option value="'+manipulationval[i]+'">'+manipulationlabel[i]+'</option>';

  }
  actionList +='</select>';
  
  return actionList;

}

function decimalDependency(componentType) {
  var dependencyCondition   = '<table class="table toggledependency-table">';
      dependencyCondition  += '<thead><tr>';
      dependencyCondition  += '<th>Field</th>';
      dependencyCondition  += '<th>Action</th>';
      dependencyCondition  += '</tr></thead>';
      dependencyCondition  += '<tbody>';
      dependencyCondition  += '<tr data-len="1">';
      dependencyCondition  += '<input type="hidden" name="decimaldependencyname[]" id="decimal_dependancy" class="form-control input-background" readonly="true" value="'+$('input[name="component_name"]').val()+'">';
      dependencyCondition  += '<td>'+getCalculationComponents(1)+'</td>';
      // dependencyCondition  += '<td><span class="btn btn-default fa fa-calculator cal-add-button"></span><span class="btn btn-default fa fa-plus decimal-add-button"></span><span class="fa fa-remove btn btn-default remove-select remove-button"></span></td></td>';
      dependencyCondition  += '<td><span class="btn btn-default fa fa-calculator cal-add-button"></span><span class="fa fa-remove btn btn-default remove-toggle-select remove-button"></span></td></td>';
      dependencyCondition  += '</tr>';
      dependencyCondition  += '</tbody>';
      dependencyCondition  += '</table>';
      if($('#fields-form > .modal-body > .col-md-12 > .form-group').hasClass('toggledependency-table')){
        $('.toggledependency-table').remove();
      }
      $('#fields-form > .modal-body > .col-md-12').append(dependencyCondition);

      createMultipleselector($('#dependency1'));

}

$(document).on('click','.cal-add-button',function() {

  var dataList = $(".toggledependency-table tr, table tr").map(function() {
      return $(this).attr("data-len");
  }).get();
  ids = Math.max.apply(null, dataList) >= 0 ? Math.max.apply(null, dataList) + 1 : 0;

  var addDependency  = '<tr data-len="'+ids+'">';
      addDependency += '<input type="hidden" name="decimaldependencyname[]" id="decimal_dependancy" class="form-control input-background" readonly="true" value="'+$('input[name="component_name"]').val()+'">';
      addDependency += '<td>'+getCalculation(ids)+'</td>';
      addDependency += '<td><span class="btn btn-default fa fa-plus decimal-add-button"></span><span class="fa fa-remove btn btn-default remove-toggle-select remove-button"></span></td></td>';
      addDependency += '</tr>';
  $(this).parent().parent().after(addDependency);
      createMultipleselector($('#dependency'+ids));
});

$(document).on('click','.decimal-add-button',function() {

  var dependancyID = $(this).parent().parent().parent().find("input").data('og-element-id');
  if (typeof dependancyID != "undefined") {
    dependancyID = dependancyID.split("para_decimal_dependancy")[1];
    var currentlabel = $('#para_name'+dependancyID).val();
  }

  var dataList = $(".toggledependency-table tr, table tr").map(function() {
      return $(this).attr("data-len");
  }).get();
  ids = Math.max.apply(null, dataList) >= 0 ? Math.max.apply(null, dataList) + 1 : 0;

  var addDependency  = '<tr data-len="'+ids+'">';
      addDependency += '<input type="hidden" name="decimaldependencyname[]" id="decimal_dependancy" class="form-control input-background" readonly="true" value="'+$('input[name="component_name"]').val()+'">';
      addDependency += '<td>'+getCalculationComponents(ids, currentlabel)+'</td>';
      addDependency += '<td><span class="btn btn-default fa fa-calculator cal-add-button"></span><span class="fa fa-remove btn btn-default remove-toggle-select remove-button"></span></td></td>';
      addDependency += '</tr>';
  $(this).parent().parent().after(addDependency);
      createMultipleselector($('#dependency'+ids));

});


function digitDependency(componentType) {
  var dependencyCondition   = '<table class="table digitdependency-table">';
      dependencyCondition  += '<thead><tr>';
      dependencyCondition  += '<th>Field</th>';
      dependencyCondition  += '<th>Action</th>';
      dependencyCondition  += '</tr></thead>';
      dependencyCondition  += '<tbody>';
      dependencyCondition  += '<tr data-len="1">';
      dependencyCondition  += '<input type="hidden" name="digitdependencyname[]" id="digit_dependancy" class="form-control input-background" readonly="true" value="'+$('input[name="component_name"]').val()+'">';
      dependencyCondition  += '<td>'+getCalculationComponents(1)+'</td>';
      // dependencyCondition  += '<td><span class="btn btn-default fa fa-calculator cal-add-button"></span><span class="btn btn-default fa fa-plus decimal-add-button"></span><span class="fa fa-remove btn btn-default remove-select remove-button"></span></td></td>';
      dependencyCondition  += '<td><span class="btn btn-default fa fa-calculator digit-cal-add-button"></span><span class="fa fa-remove btn btn-default remove-toggle-select remove-button"></span></td></td>';
      dependencyCondition  += '</tr>';
      dependencyCondition  += '</tbody>';
      dependencyCondition  += '</table>';
      if($('#fields-form > .modal-body > .col-md-12 > .form-group').hasClass('digitdependency-table')){
        $('.digitdependency-table').remove();
      }
      $('#fields-form > .modal-body > .col-md-12').append(dependencyCondition);

      createMultipleselector($('#dependency1'));

}

$(document).on('click','.digit-cal-add-button',function() {

  var dataList = $(".digitdependency-table tr, table tr").map(function() {
      return $(this).attr("data-len");
  }).get();
  ids = Math.max.apply(null, dataList) >= 0 ? Math.max.apply(null, dataList) + 1 : 0;

  var addDependency  = '<tr data-len="'+ids+'">';
      addDependency += '<input type="hidden" name="digitdependencyname[]" id="digit_dependancy" class="form-control input-background" readonly="true" value="'+$('input[name="component_name"]').val()+'">';
      addDependency += '<td>'+getCalculation(ids)+'</td>';
      addDependency += '<td><span class="btn btn-default fa fa-plus digit-add-button"></span><span class="fa fa-remove btn btn-default remove-toggle-select remove-button"></span></td></td>';
      addDependency += '</tr>';
  $(this).parent().parent().after(addDependency);
      createMultipleselector($('#dependency'+ids));
});

$(document).on('click','.digit-add-button',function() {

  var dependancyID = $(this).parent().parent().parent().find("input").data('og-element-id');
  if (typeof dependancyID != "undefined") {
    dependancyID = dependancyID.split("para_digit_dependancy")[1];
    var currentlabel = $('#para_name'+dependancyID).val();
  }

  var dataList = $(".digitdependency-table tr, table tr").map(function() {
      return $(this).attr("data-len");
  }).get();
  ids = Math.max.apply(null, dataList) >= 0 ? Math.max.apply(null, dataList) + 1 : 0;

  var addDependency  = '<tr data-len="'+ids+'">';
      addDependency += '<input type="hidden" name="digitdependencyname[]" id="digit_dependancy" class="form-control input-background" readonly="true" value="'+$('input[name="component_name"]').val()+'">';
      addDependency += '<td>'+getCalculationComponents(ids, currentlabel)+'</td>';
      addDependency += '<td><span class="btn btn-default fa fa-calculator digit-cal-add-button"></span><span class="fa fa-remove btn btn-default remove-toggle-select remove-button"></span></td></td>';
      addDependency += '</tr>';
  $(this).parent().parent().after(addDependency);
      createMultipleselector($('#dependency'+ids));
});

/* initialize the depandancy to the fields */
function addDependency(componentType) {

   switch(componentType) {
       case 'type-select':
        //  dropBoxdependency(componentType);
       break; 
      case 'type-toggle':
         toggleDependency(componentType);
       break;
      case 'type-decimal':
        decimalDependency(componentType);
       break;
      case 'type-number':
        digitDependency(componentType);
       break;

   }

}
