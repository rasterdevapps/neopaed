
function problemFieldsids(propertyNumber) {

  return property = {
          "label"       :"#para_label"+propertyNumber ,
          "placeholder" :"#para_placeholder"+propertyNumber,
          "type"        :"#para_type"+propertyNumber,
          "options"     :"#para_options"+propertyNumber
  }

}

function componentInitialvalues(type) {

     switch (type) {
           case 'text':
              return componentValue =  {
                    "label"       :"text",
                    "name"        :"text",
                    "class"       :"form-control",
                    "placeholder" :"Please Enter text"  
              };
              break;

           case 'textarea':
              return componentValue =  {
                    "label"       :"textarea",
                    "name"        :"textarea",
                    "class"       :"form-control",
                    "placeholder" :"Please Enter text"  
              };
            break;
          case 'select':
              return componentValue =  {
                    "label"       :"select component",
                    "name"        :"select",
                    "class"       :"form-control",
                    "placeholder" :"Please choose the options"  
              };
            break;  
           default:
              
               break;
      }

}

function fieldsPropertiesname() {
  return propertyNames = {
          "label"       :"flabel",
          "name"        :"fname",
          "class"       :"fclass",
          "placeholder" :"fplaceholder"  
  }
}

//generate label
function generateLabel(labelName) {

   return '<label for="'+labelName+'" class="show-label">'+labelName+'</label>';
}

//generate text box
function generateTextcomponent(textName,textClass,textPlaceholder) {

  return '<input name="'+textName+'" value="" class="'+textClass+' show-input" placeholder ="'+textPlaceholder+'" type="text">';  
    
}

//generate textarea
function generateTextareacomponent(textName,textClass,textPlaceholder){
  return '<textarea name="'+textName+'" value="" class="'+textClass+' show-input" placeholder ="'+textPlaceholder+'"> </textarea>';
}


//generate options

function getOptions(optionName,optionValue) {
   var options = [];
   for(i = 0; i < optionName.length; i++){

    if($(optionName[i]).val() != '' && $(optionValue[i]).val() != '')
      var tempOptions = {
             "optionName" : $(optionName[i]).val(),
             "optionValue": $(optionValue[i]).val()
      }
      options.push(tempOptions);
   
   }

  return JSON.stringify(options);

}

//generate select

function generateSelectcomponent(textName,textClass,textPlaceholder,options) {
  options = JSON.parse(options);

  var selectComponent  = '<select class="'+textClass+'" name="'+textName+'">';
   for(i = 0; i < options.length; i++){
      selectComponent += '<option value="'+options[i].optionValue+'">'+options[i].optionName+'</option>';
   }  
   selectComponent +='</select>'; 
   return selectComponent;

}


//generate form group
function generateFeildgroup(fieldTag,labelTag,hiddenParameter,groupId,groupElement){
   
   return '<div draggable="true" data-param-number="'+groupElement+'" id="'+groupId+'" class="form-group form-part">'+labelTag+fieldTag+hiddenParameter+'</div>';
}


//set parameter hidden fields
function addhiddenFields(name,label,placeholder,type,className,designation,groupElement,options){
  
   var parameters  = '<input type="hidden" name="para_name[]" value="'+name+'" id="para_name'+groupElement+'">';
       parameters += '<input type="hidden" name="para_label[]" value="'+label+'" id="para_label'+groupElement+'">';
       parameters += '<input type="hidden" name="para_placeholder[]" value="'+placeholder+'" id="para_placeholder'+groupElement+'">';
       parameters += '<input type="hidden" name="para_type[]" value="'+type+'" id="para_type'+groupElement+'">';
       parameters += '<input type="hidden" name="para_class[]" value="'+className+'" id="para_class'+groupElement+'">';
       parameters += '<input type="hidden" name="para_position[]" value="'+designation+'" id="para_position'+groupElement+'">';
    if(options!=null){
       parameters += '<input type="hidden" name="para_options[]" value="'+encodeURIComponent(options)+'" id="para_options'+groupElement+'">';

    }

    return parameters;
}
//construct the form label 
function constructGroup(){

    var name         = $('input[name="parameter_name"]').val();
    var label        = $('input[name="parameter_label"]').val();
    var placeholder  = $('input[name="parameter_placeholder"]').val();
    var type         = $('input[name="parameter_type"]').val();
    var className    = $('input[name="parameter_class"]').val(); 
    var designation  = $('select[name="parameter_position"]').val();
    var groupElement = $('.form-part').length+1;
    var groupId      = 'part'+groupElement;


     switch (type) {
           case 'text':
               var textFields      = generateTextcomponent(name,className,placeholder);
               var labelFields     = generateLabel(label);
               var hiddenParameter = addhiddenFields(name,label,placeholder,type,className,designation,groupElement,null);
               var fieldsGroup = generateFeildgroup(textFields,labelFields,hiddenParameter,groupId,groupElement); 
               break;

           case 'textarea':
               var textFields      = generateTextareacomponent(name,className,placeholder);
               var labelFields     = generateLabel(label);
               var hiddenParameter = addhiddenFields(name,label,placeholder,type,className,designation,groupElement,null);
               var fieldsGroup = generateFeildgroup(textFields,labelFields,hiddenParameter,groupId,groupElement); 
               break;
            case 'select':
               var options         = getOptions($('input[name="parameter_option_name[]"]'),$('input[name="parameter_option_value[]"]'));
               var selectFields    = generateSelectcomponent(name,className,placeholder,options);
               var labelFields     = generateLabel(label);
               var hiddenParameter = addhiddenFields(name,label,placeholder,type,className,designation,groupElement,options);
               var fieldsGroup     = generateFeildgroup(selectFields,labelFields,hiddenParameter,groupId,groupElement); 

               break;   
           default:
              
               break;
      }
      $('.'+designation+'> h3').remove();
      $('.'+designation).append(fieldsGroup);
      createEventlistner(groupId);
}
//add event listener for layout box
function containerEvents(){
  var sectionLeft  = document.getElementById('box-left');
  var sectionRight = document.getElementById('box-right');

     sectionLeft.addEventListener('dragover',restricteDrop,false);
     sectionLeft.addEventListener('drop', drop, false);
     sectionLeft.addEventListener('ondragover',restricteDrop,false);
     sectionLeft.addEventListener('ondrop', drop, false);

     sectionRight.addEventListener('dragover',restricteDrop,false);
     sectionRight.addEventListener('drop', drop, false);
     sectionRight.addEventListener('ondragover',restricteDrop,false);
     sectionRight.addEventListener('ondrop', drop, false);

}
//add event listener for form component
function createEventlistner(componentId){

    var  componentTag = document.getElementById(componentId);
         componentTag.addEventListener('dragstart',dragComponent,false);
         componentTag.addEventListener('drop',restricteDrop,false);
}



//find the parent element of the given tag
function findParentelement(el, tagName) {
  tagName = tagName.toLowerCase();

  while (el && el.parentNode) {
    el = el.parentNode;
    if (el.tagName && el.tagName.toLowerCase() == tagName) {
      return el;
    }
  }
  return null;
}


function drop(ev) {
  ev.preventDefault();
    var data     = ev.dataTransfer.getData("text");
    var sourceId = document.getElementById(data);
    var pbasedElement = document.elementFromPoint(ev.clientX,ev.clientY);
   
    if(sourceId.classList.contains('basic-component-fields')) {
     //trigger modal while drop the new component to the layout
       var pbasedParent  = findParentelement(pbasedElement,'section');
       initializePropertymodal(sourceId,pbasedParent);
       $('#fields-filter').modal('show');

    }else if(sourceId.classList.contains('form-part')) {

       var pbasedParent  = findParentelement(pbasedElement,'div');
        
         if(pbasedParent.classList.contains('form-part')){
           // move the component between two layout's based on drag 
           pbasedParent.after(sourceId);

         } else if(pbasedParent.classList.contains('master-problem-fields')) {
           var pbasedParent  = findParentelement(pbasedElement,'section');
            //need to add function
           console.log(pbasedParent);

         }  

    }
   
  
}




function restricteDrop(ev) {

  ev.preventDefault();
}

function dragComponent(ev) {
      
  ev.dataTransfer.setData("text", ev.target.id);

}
function addSelectoptions(){

  var optionElement  = '<tr>';    
      optionElement += '<td><input class="form-control" name="parameter_option_name[]" type="text"></td>';
      optionElement += '<td><input class="form-control" name="parameter_option_value[]" type="text"></td>';
      optionElement += '<td><span class="fa fa-remove btn btn-default remove-select"></span></td>';
      optionElement += '</tr>';
  $('.form-com-option tbody').append(optionElement);    
}






$(document).on('click','.remove-select',function(e){
    e.preventDefault();
     $(this).parent().parent().remove();
});


//component edit section

function feildPropertyelement(plabel,pname,pvalue,ogid,number) {

    var formProperies  = '<div class="form-group">';
        formProperies += '<label>'+plabel+'</label>';
        formProperies += '<input type="text" name="'+pname+'" value="'+pvalue+'" data-fnumber="'+number+'" data-og-id="'+ogid+'" class="form-control pfields-property">';
        formProperies +='</div>';
  return formProperies;     

}



function formProperty(propertyNumber){

  var problemId     = problemFieldsids(propertyNumber);
  var fieldNames    = fieldsPropertiesname();

  var labelName       = $(problemId.label).val();
  var textName        = $(problemId.name).val();
  var textClass       = $(problemId.class).val();
  var textPlaceholder = $(problemId.placeholder).val();
  var selectOptions   = decodeURIComponent($(problemId.options).val());



  var formProperies  = feildPropertyelement('Label',fieldNames.label,labelName, problemId.label, propertyNumber);
      formProperies += feildPropertyelement('Name',fieldNames.name,textName,problemId.name,propertyNumber);
      formProperies += feildPropertyelement('Class',fieldNames.class,textClass,problemId.class,propertyNumber);
      formProperies += feildPropertyelement('Placeholder',fieldNames.placeholder,textPlaceholder,problemId.placeholder,propertyNumber); 


     $('.form-properties-lists').html(formProperies);

}


function initializePropertymodal(sourceId,pbasedParent){

    var componentType = sourceId.getAttribute('data-feild-type');
    var intialValues  = componentInitialvalues(componentType);
    
    $('input[name="parameter_label"]').val(intialValues.label);
    $('input[name="parameter_name"]').val(intialValues.name);
    $('input[name="parameter_placeholder"]').val(intialValues.placeholder);
    $('input[name="parameter_class"]').val(intialValues.class);
    $('input[name="parameter_type"]').val(componentType);
    $('select[name="parameter_position"]').val(pbasedParent.getAttribute('data-position')).trigger('change');

    if(componentType == 'select'){
         $('#parameter_option_type').parent().parent().show();
    }else{
         $('#parameter_option_type').parent().parent().hide();

    }

}

function optionType(){
  if($('#parameter_option_type').prop('checked')==true) {
     $('.form-com-option').hide();
     $('#parameter_option_master').parent().show();
  }else{
      $('.form-com-option').show();
      $('#parameter_option_master').parent().hide();

  }
}


function addSelectoptions(){

  var optionElement  = '<tr>';    
      optionElement += '<td><input class="form-control" name="parameter_option_name[]" type="text"></td>';
      optionElement += '<td><input class="form-control" name="parameter_option_value[]" type="text"></td>';
      optionElement += '<td><input class="form-control" name="parameter_option_color[]" type="text"></td>';
      optionElement += '<td><span class="fa fa-remove btn btn-default remove-select"></span></td>';
      optionElement += '</tr>';
  $('.form-com-option tbody').append(optionElement);    
}

$(document).on('click','.remove-select',function(e){
    e.preventDefault();
     $(this).parent().parent().remove();
});

$(document).on('click','.form-part-remove',function(){
  $(this).parent().remove();
});


$(document).on('click','.form-part',function(){

  var propertyNumber = $(this).data('param-number');

      $('.form-part').each(function(){
        $(this).removeClass('selected-component');
      });

      if(!$(this).hasClass('selected-component')){
          $(this).addClass('selected-component');
      }
      formProperty(propertyNumber);


});

$(document).on('keyup','.pfields-property',function() {

   var sourceId        = $(this).data('og-id');
   var propertyNumber  = $(this).data('fnumber');
   var propertyName    = $(this).attr('name');
   var fieldNames      = fieldsPropertiesname();
   var problemId       = problemFieldsids(propertyNumber);
    if(fieldNames.label == propertyName) {
      $('#part'+propertyNumber+' > .show-label').html($(this).val());
    }
    if(fieldNames.placeholder == propertyName) {
      $('#part'+propertyNumber+' > .show-input').attr('placeholder',$(this).val());
    }

   $(sourceId).val($(this).val());
   

});
$(document).ready(function(){

    $('.basic-component-fields').each(function(){
       createEventlistner($(this).attr('id'));
    });
    $('.form-part').each(function(){
       createEventlistner($(this).attr('id'));
    });
     containerEvents();
     optionType();

    $('.problem-submits').click(function(e){
          e.preventDefault();
          constructGroup();
          $('#fields-filter').modal('hide');
    });

    $('.select-options').click(function(){
         addSelectoptions();
    });

    $('#parameter_option_type').change(function(){
         optionType();
    });



});






























