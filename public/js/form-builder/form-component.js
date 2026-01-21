/* start component */ 
/* restricte the droping object  */
function restricteDrop(e) {

  e.preventDefault();
}

/* set the draging object into the events */
function dragComponent(e) {

  e.dataTransfer.setData("target-text", e.target.id);
  e.dataTransfer.setData("target-y", e.clientY);

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

function findParentClass(el,className) {

  className = className.toLowerCase();

  while (el && el.parentElement) {
    el = el.parentElement;
    if (el.classList.contains(className)) {
      return el;
    }
  }
  return null;

}

function initializePropertymodal(dragComId,dropContainer,formType, dropPosition) {

  $("#problem-form input[name='para_name[]']").each(function(index, elm){
    problemfield.push(elm.value);
  });

  var typeOfcomponent     = dragComId.getAttribute('data-feild-type');
  var baseLayout          = $('input[name="base_layout[]"]:checked').val();

  if(baseLayout == 'undefined' || typeOfcomponent == 'undefined' || baseLayout == '' || typeOfcomponent == '' ) {

    Showalert('error','Layout or Component type is not selected');

    return false;
  }
  $.ajax({
   type     :"GET",
   url      :$('input[name="formpropertyuri"]').val(),
   dataType :"html",
   data     :{ componentType:typeOfcomponent,baseLayout:baseLayout,formType:formType},
   success  :function(response){
    $('.form-property').html(response);  
    addDependency(typeOfcomponent);
  },
  complete :function(){
    $('#component_parameter_form').modal({backdrop: 'static', show: true, keyboard: false });
            if (dropPosition == 'box-right') {
                document.getElementById('component_position').value = 'problem-fields-right';
            } else {
                document.getElementById('component_position').value = 'problem-fields-left';
            }
  }
});
  
}

function getFieldproperty(groupId,componentType,formType) {

 $.ajax({
  type     :"GET",
  url      :$('input[name="formpropertyuri"]').val(),
  dataType :"html",
  data     :{ groupId:groupId,formType:formType,componentType:componentType},
  beforeSend :function() {
    var sidebarHeight = $('.sidebar-right').height();
    var layoutHeight  = $('.layout-options').height();
    var navtabHeight  = $('.nav-tabs').height() + $('.header').height() +70;
    sidebarHeight = sidebarHeight - (layoutHeight+navtabHeight);
    $('#field-propertice').css('min-height',sidebarHeight);
    $('.form-properties-lists').html('<div style="align-items: center; display: flex; justify-content: center;"><i class="fa fa-spinner fa-pulse fa-5x fa-fw" aria-hidden="true"></i></div>');

  },
  success  :function(response) {
   $('.form-properties-lists').html(response).removeAttr('style');

   getHiddenSettings(componentType,groupId);
 },
 complete :function() { 

  $('.form-part').children('.remove-component').addClass('hide');   
  $('.selected-component').children('.remove-component').removeClass('hide');
}
});

}

function refreshOrder() {
  var i = 1;
  $('input[name="para_order[]"]').each(function() {

    $(this).val(i);
    i++;
  });

}

function dropComponent(e) {
	e.preventDefault();

  var dragingComponent     = e.dataTransfer.getData("target-text");
  var dragComId            = document.getElementById(dragingComponent);
  var dropPosition         = document.elementFromPoint(e.clientX,e.clientY);
  var sourceYaxis          = e.dataTransfer.getData("target-y");
  var sourceContainer      = dragComId.parentNode;


  if(dragComId.classList.contains('basic-component-fields')) {
   var dropContainer  = findParentelement(dropPosition,'section');

   initializePropertymodal(dragComId,dropContainer,'modal');
   getRemoveHeader(dropPosition);


 } else {
  if(dropPosition.tagName =='SECTION') {
    getRemoveHeader(dropPosition);
    dropPosition.append(dragComId);
    checkingContainerlabel(sourceContainer);
    dragComId.children.namedItem('para_position[]').value = dropPosition.getAttribute('data-position');


  } else if(dropPosition.tagName =='H3') {

    var dropContainer    = findParentelement(dropPosition,'section');
    getRemoveHeader(dropPosition);
    dropContainer.append(dragComId); 
    checkingContainerlabel(sourceContainer);
    dragComId.children.namedItem('para_position[]').value = dropContainer.getAttribute('data-position');

  } else if (dropPosition.tagName == 'TEXTAREA' || dropPosition.tagName == 'INPUT' || dropPosition.tagName == 'SELECT' || dropPosition.tagName == 'LABEL') {

    var dropContainer         = findParentClass(dropPosition,'form-part');
    var dropContainerposition = findParentelement(dropPosition,'section');
    getRemoveHeader(dropPosition);
    dropContainer.after(dragComId); 
    checkingContainerlabel(sourceContainer);
    dragComId.children.namedItem('para_position[]').value = dropContainerposition.getAttribute('data-position');




  } else {

    var dropContainer    = findParentelement(dropPosition,'div');
    if(dropContainer != null && dropContainer.classList.contains('form-part')) {
      if(sourceYaxis > e.clientY){
        dropContainer.after(dragComId);
      }else{
       dropContainer.before(dragComId);
     }
   } else {
     var dropContainer    = findParentelement(dropPosition,'section');
     dropContainer.append(dragComId);

   }    
   getRemoveHeader(dropPosition);

   checkingContainerlabel(sourceContainer);

 } 

}
refreshOrder();

}


//add event listner for basic components 
function basicComponentListner(componentId) {

  var  basicComponent = document.getElementById(componentId);
  basicComponent.addEventListener('dragstart',dragComponent,false);
  basicComponent.addEventListener('drop',restricteDrop,false);
}

function basicLayoutListner(containerId) {
 var  baseContainer =  document.getElementById(containerId);
 baseContainer.addEventListener('dragover',restricteDrop,false);
 baseContainer.addEventListener('drop',dropComponent,false);

}

function setSinglelayoutposition(layoutSelector) {


  $('input[name="para_position[]"]').each(function() {
   $(this).val('problem-fields-center');
 });

}

function setDoublelayoutposition() {

  $('input[name="para_position[]"]').each(function() {
   $(this).val('problem-fields-left');
 });

}

function setComponentparent(self) {

  var draggableDiv  = '<div draggable="true" data-param-number="'+self.attr('data-param-number')+'" id="'+self.attr('id')+'" class="'+self.attr('class')+'">';
  draggableDiv += self.html(); 
  draggableDiv += '</div>';
  return draggableDiv; 
}

/* end component */ 

function setbaseLayout() {

  var layoutType    = $('input[name="base_layout[]"]:checked').val();
  var formContent   = '';
  var elementLength = 0;
  if($('.master-problem-fields div').hasClass('form-part')){      

    $(masterLayout.containerSelector).each(function(){
     $(this).children('h3').remove();
     formContent   +=  $(this).html();
     elementLength +=  $(this).children('div').length;
   });
  }

  switch (layoutType) {
   case  '1':
   $(masterLayout.mainClass).html(singleColumn(singleProperty)); 
   layoutListner();
   var layoutSelector = $('#'+singleProperty.layoutId);

   if(formContent != '') {
     layoutSelector.html('');
     layoutSelector.html(formContent);
     setSinglelayoutposition();
     formListner();
   }

   $('input[name="para_position[]"]').each(function(){
    $(this).val(singleProperty.layoutId)
  }); 

   $('input[name="problem_layout"]').val('1');

   break;
   case  '2':

   var leftformContent  ='';
   var rightformContent ='';
   $(masterLayout.containerSelector).each(function() {
     var childrenElement = $(this).children();
     var childrenElementcount = $(this).children().length; 
     var leftformcount = childrenElementcount / 2 ;
     var i = 1;
     childrenElement.each(function(){
      if(i <= leftformcount) {
        leftformContent +=setComponentparent($(this));

      }

      if(i > leftformcount && i <= childrenElementcount) {
       rightformContent +=setComponentparent($(this));
     }
     i++;

   });

   }); 
   $(masterLayout.mainClass).html(doubleColumn(doubleProperty));
   var leftlayoutSelector  = $('#'+doubleProperty.leftLayoutid);
   var rightlayoutSelector = $('#'+doubleProperty.rightLayoutid);
   layoutListner();

   if(formContent != '') {
    leftlayoutSelector.html('');
    leftlayoutSelector.html(leftformContent);
    rightlayoutSelector.html(rightformContent);
    setDoublelayoutposition();
    formListner();
  }
  $('input[name="para_position[]"]').each(function(){
   $(this).val($(this).parent().parent().attr('data-position'));
 });


  $('input[name="problem_layout"]').val('2');

  break;

  default:
  break;
}
}

function layoutListner() {
  var layoutType    = $('input[name="base_layout[]"]:checked').val();

  if(layoutType == 1 ) {

    basicLayoutListner(singleProperty.layoutId);

  }else if(layoutType == 2) {

    basicLayoutListner(doubleProperty.leftLayoutid);
    basicLayoutListner(doubleProperty.rightLayoutid);


  }


}

function formListner() {

 $('.form-part').each(function() {
  basicComponentListner($(this).attr('id'));
});

}



var detect_touch;
$(document).ready(function() {
  $('.has-error.help-block').css('display', 'none !important');

  $('.basic-component-fields').each(function() {

   basicComponentListner($(this).attr('id'));

 });

  $('input[name="base_layout[]"]').click(function() {

   setbaseLayout();


 });

  var base_layout = $('input[name="base_layout[]"]:checked').val();
  if (typeof base_layout == 'undefined' ) {
   $('input[name="base_layout[]"][value="2"]').click(); 
   setbaseLayout();
 }

 layoutListner();
 formListner();
    detect_touch = (('ontouchstart' in window) || (navigator.maxTouchPoints > 0) || (navigator.msMaxTouchPoints > 0));

    if (detect_touch) {
        $(".basic-component-group > .basic-component-fields").dragdrop({
            makeClone: true,
            sourceClass: "pendingDrop",
            dropClass: "highlight",
            container: $('.problem-parent'),
            didDrop: function($src, $dst) {
                if ($dst.attr("class") != "sidebar-right") $dst = $dst.parents("#box-left");
                var currentText = $dst.text();
                currentText += $src.text();
                $dst.text(currentText);
            }
        });
        // $(function() {
        //     var $srcElement;
        //     var srcIndex, dstIndex;
        //     $("#box-left>div").dragdrop({
        //         makeClone: true,
        //         sourceHide: true,
        //         dragClass: "shadow-left",
        //         canDrag: function($src, event) {
        //             $srcElement = $src;
        //             srcIndex = $srcElement.index();
        //             dstIndex = srcIndex;
        //             return $src;
        //         },
        //         canDrop: function($dst) {
        //             if ($dst.is(".form-part")) {
        //                 dstIndex = $dst.index();
        //                 if (srcIndex < dstIndex) $srcElement.insertAfter($dst);
        //                 else $srcElement.insertBefore($dst);
        //             }
        //             return true;
        //         },
        //         didDrop: function($src, $dst) {
        //             // Must have empty function in order to NOT move anything.
        //             // Everything that needs to be done has been done in canDrop.
        //             // if (srcIndex!=dstIndex) {
        //             //   var value = currentOrder[srcIndex];
        //             //   currentOrder.splice(srcIndex, 1);
        //             //   currentOrder.splice(dstIndex, 0, value);
        //             //   $("#msg").text("New order of items:" + currentOrder.join(", "));
        //             // }
        //         }
        //     });
        //     $("#box-right>div").dragdrop({
        //         makeClone: true,
        //         sourceHide: true,
        //         dragClass: "shadow-right",
        //         canDrag: function($src, event) {
        //             $srcElement = $src;
        //             srcIndex = $srcElement.index();
        //             dstIndex = srcIndex;
        //             return $src;
        //         },
        //         canDrop: function($dst) {
        //             if ($dst.is(".form-part")) {
        //                 dstIndex = $dst.index();
        //                 if (srcIndex < dstIndex) $srcElement.insertAfter($dst);
        //                 else $srcElement.insertBefore($dst);
        //             }
        //             return true;
        //         },
        //         didDrop: function($src, $dst) {
        //             // Must have empty function in order to NOT move anything.
        //             // Everything that needs to be done has been done in canDrop.
        //             // if (srcIndex!=dstIndex) {
        //             //   var value = currentOrder[srcIndex];
        //             //   currentOrder.splice(srcIndex, 1);
        //             //   currentOrder.splice(dstIndex, 0, value);
        //             //   $("#msg").text("New order of items:" + currentOrder.join(", "));
        //             // }
        //         }
        //     });
        // });
    }

});





$(document).on('click','.select-options-drop',function() {

  var dropDown  ='<tr>';
  dropDown +='<td><input class="form-control input-background" name="component_option_name[]" type="text"></td>';
  dropDown +='<td><input class="form-control input-background" name="component_option_value[]" type="text"></td>';
  dropDown +='<td><span class="select-options-drop btn btn-default fa fa-plus add-button"></span>';
  dropDown +='<span class="fa fa-remove btn btn-default remove-select remove-button"></span>';
  dropDown +='</td>';
  dropDown +='</tr>';
  $('.form-com-option tbody').append(dropDown);

});

$(document).on('click','.select-options-hdrop',function() {

 var horizontalDrop  = '<tr>';
 horizontalDrop += '<td><input class="form-control input-background" name="hcomponent_option_name[]" type="text"></td>';
 horizontalDrop += '<td><input class="form-control input-background" name="hcomponent_option_value[]" type="text"></td>';
 horizontalDrop += '<td><input class="form-control input-background input-width-small" name="hcomponent_option_color[]" type="text"></td>';
 horizontalDrop += '<td><span class="select-options-hdrop btn btn-default fa fa-plus add-button"></span>';
 horizontalDrop += '<span class="fa fa-remove btn btn-default remove-select remove-button"></span>';
 horizontalDrop += '</td>';
 horizontalDrop += '</tr>';
 $('.form-com-hoption tbody').append(horizontalDrop);

});

$(document).on('click','.remove-select',function() {

 var parentSelector = $(this).parent().parent();
 if(parentSelector.siblings().length > 1) {
  parentSelector.remove();
}else{
  Showalert('error','Need Atleast 2 option');
}

});

$(document).on('click','.check-option',function() {

  var checkOption  ='<tr>';
  checkOption +='<td><input class="form-control input-background" name="component_chkop_name[]" type="text"></td>';  
  checkOption +='<td><input class="form-control input-background" name="component_chkop_value[]" type="text"></td>';
  checkOption +='<td><span class="check-option btn btn-default add-button fa fa-plus"></span>';
  checkOption += '<span class="fa fa-remove btn btn-default remove-select remove-button"></span></td>';
  checkOption +='</tr>';
  $('.form-check-option tbody').append(checkOption);                            
});

var problemfield = [];
var currentselectedfield = '';
var currentselectedfieldid = '';

$("#problem-form input[name='para_name[]']").each(function(index, elm){
  problemfield.push(elm.value);
});

$(document).on('keyup','input[name="component_name"], input[name="fcomponent_name"]',function() {
  $(this).val(this.value.replace(/[^a-z]/g,''));
});
$(document).on('focusout','input[name="component_name"]',function() {

  var currentproblemfield = this.value.replace(/[^a-z]/g,'');

  if (problemfield.indexOf(currentproblemfield) >= 0) {
    $(this).parent().find('span.error-message').remove();
    $(this).parent().append('<span class="error-message">"'+currentproblemfield+'" already exists.</span>');
    currentproblemfield = '';
  } else {
    $(this).parent().find('span.error-message').remove();    
  }

  $(this).val(currentproblemfield);

});

$(document).on('focusout','input[name="fcomponent_name"]',function() {

  var currentproblemfield = this.value.replace(/[^a-z]/g,'');

  if (problemfield.indexOf(currentproblemfield) >= 0 && currentproblemfield != currentselectedfield) {
    $(this).parent().find('span.error-message').remove();
    $(this).parent().append('<span class="error-message">"'+currentproblemfield+'" already exists.</span>');
    currentproblemfield = '';
  } else {
    $(this).parent().find('span.error-message').remove();    
  }

  $(this).val(currentproblemfield); 
  $('#'+currentselectedfieldid).val(currentproblemfield);

});

var formchange = true;
$(document).on('focusout','input[name="fcomponent_label"], input[name="fcomponent_name"]',function() {
  if ($('.sidebar-right').children().find('#component-property').length > 0 && ($('#component-property #fcomponent_label').val() == '' || $('#component-property #fcomponent_name').val() == '')) {
    formchange = false;
    $('#component-property #fcomponent_label').css('border-color', 'red');
    $('#component-property #fcomponent_name').css('border-color', 'red');
  } else {
    formchange = true;
    $('#component-property #fcomponent_label').css('border-color', '#ccc');
    $('#component-property #fcomponent_name').css('border-color', '#ccc');
    $('.widget-content button').attr('disabled', false);  
  }
});

$(document).on('mouseout', '.sidebar-right', function() {
  $('.widget-content button').attr('disabled', false);  
});

$(document).on('click','button',function() {
  problemfield = [];
  $("#problem-form input[name='para_name[]']").each(function(index, elm){
    problemfield.push(elm.value);
  });

  if ($('.sidebar-right').children().find('#component-property').length > 0 && $('#component-property #fcomponent_label').val() != '' && $('#component-property #fcomponent_name').val() != '' && !(problemfield.indexOf("") == -1 ? false : true)) {
    $('.widget-content button').attr('disabled', false);  
  } else {
    if (problemfield.indexOf("") == -1 ? false : true) {
      formchange = false;
      $('.widget-content button').attr('disabled', true);
    } else {
      $('.widget-content button').attr('disabled', false);  
    }
  }
});

$(document).on('click','.problem-submits',function(e) {
 e.preventDefault();
 if (validateModal()) { 
   createComponent();
   $('#component_parameter_form').modal('hide');
 }   
});


$(document).on('click','.form-part',function() {

  currentselectedfield = '';


  var  groupId       = $(this).data('param-number');
  var  componentType = $('#para_type'+groupId).val();

  if ($('.selected-component').attr('id') != $(this).attr('id')) {

    if ($('.sidebar-right').children().find('#component-property').length > 0 && ($('#component-property #fcomponent_label').val() == '' || $('#component-property #fcomponent_name').val() == '')) {
      formchange = false;
      $('#component-property #fcomponent_label').css('border-color', 'red');
      $('#component-property #fcomponent_name').css('border-color', 'red');
    } else {
      formchange = true;
    }

    if (formchange) {
      $('.form-part').each( function() {
        $(this).removeClass('selected-component');
      });

      if(!$(this).hasClass('selected-component')) {

        $(this).addClass('selected-component');
        $('a[href="#field-propertice"]').trigger('click');

      }
      currentselectedfield = $(this).children('input[name="para_name[]"]').val();
      currentselectedfieldid = $(this).children('input[name="para_name[]"]').attr('id');

      getFieldproperty(groupId,componentType,'sidebar');  
    }   
  }   
});

$(document).on('click','.remove-component',function() {

  var formContainerId = $(this).parent().parent().attr('id');
  var formContainer  = document.getElementById(formContainerId);
  $(this).parent().remove();
  checkingContainerlabel(formContainer);


});

$(document).on('keyup','.field-property',function() {

  var sourceElement      = $(this);
  var id                 = sourceElement.data('og-element-id');
  var designationElement = $('#'+id);
  rebuildComponentproperty(sourceElement,designationElement); 

});

$(document).on('change', '.field-property-fontsize', function() {
  var sourceElement      = $(this);
  var id                 = sourceElement.data('og-element-id');
  var designationElement = $('#'+id);
  rebuildComponentproperty(sourceElement,designationElement); 
});

$(document).on('click','.field-required-property',function() {

  var sourceElement      = $(this);
  var id                 = sourceElement.data('og-element-id');
  var designationElement = $('#'+id);
  rebuildComponentproperty(sourceElement,designationElement); 

});

$(document).on('click','.add-drop-option',function() {

 var dropBoxselector = $(this).parent().parent().parent();

 if ((dropBoxselector.children('tr:first').children('td').length == 4) && ($('input[name="base_layout[]"]:checked').val() == 2)) {

   if (dropBoxselector.children('tr').length < 4) {

    var dropboxValue    = dropBoxselector.children('tr:first').html();  
    dropBoxselector.append('<tr>'+dropboxValue+'</tr>');

  } else {

   Showalert('info','Maximum 4 option only allowed !');
 } 

} else {
 var dropboxValue    = dropBoxselector.children('tr:first').html();  

 dropBoxselector.append('<tr>'+dropboxValue+'</tr>');
}   
});

$(document).on('click','.close-option',function() {

  var rebuildObject = $(this).parent().parent().siblings('tr:first').children('td:first').children('input');
  $(this).parent().parent().remove();
  rebuildObject.trigger('keyup');

});

$(document).on('keyup','input[name="component_toggle_on"],input[name="component_toggle_off"]',function() {

  $('#'+$(this).data('dependancy')).val($(this).val());

});

$(document).on('change','select[name="foption_dependancy_value[]"]',function() {
 var dependencyNameset = [];
 var i = 1;
 $('input[name="foption_dependancy_name[]"]').each(function(){
   var tempDependancy = {
     'dependencyName'  : $(this).val(),
     'dependencyValue' : $('#foption_dependancy'+i).val(),

   };

   dependencyNameset.push(tempDependancy);
   i++;
 });
 var sourceId =  $(this).data('og-element-id');
 $('#'+sourceId).val(encodeURIComponent(JSON.stringify(dependencyNameset)));

});

$('.form-part').children('.remove-component').addClass('hide');   


$(document).on('change','input[data-toggle="toggle"]', function() {

 $(this).parent().siblings('input[name="para_default[]"]').val($(this).prop('checked'));

});

$('.show-input').on('keyup', function() {

  $(this).siblings('input[name="para_default[]"]').val($(this).val());

});

$(document).on('change', 'select', function() {

  $(this).siblings('input[name="para_default[]"]').val($(this).val());

});

$(document).on('change', 'input[data-toggle="toggle"]', function() {

  toggleChanges($(this));

});

$(document).on('change', 'input[type="radio"]',function() {

  $(this).parent().parent().siblings('input[name="para_default[]"]').val($(this).val());

});
$(document).on('change', 'input[name="fval_required"]', function() {

  if ($(this).prop('checked') == true) {

    $('#'+$(this).data('og-element-id')).val(1);

  } else {

    $('#'+$(this).data('og-element-id')).val(0);

  }


});

function validateModal() {

 var flag = true;  

 if ($('input[name="component_label"]').val() == '') {
  addErrorbox($('input[name="component_label"]'));
  flag = false;
} else {
  removeErrorbox($('input[name="component_label"]'));

}  

if ($('input[name="component_name"]').val() == '') {
  addErrorbox($('input[name="component_name"]'));
  flag = false;
} else {
  removeErrorbox($('input[name="component_name"]'));
} 

checkEmptyoption($('input[name="component_option_name[]"]'));
checkEmptyoption($('input[name="component_option_value[]"]'));
checkEmptyoption($('input[name="component_option_color[]"]'));
checkEmptyoption($('input[name="component_chkop_name[]"]'));
checkEmptyoption($('input[name="component_chkop_value[]"]'));


if($('input[name="component_toggle_on"]').length > 0 && $('input[name="component_toggle_off"]').length > 0) { 

 if ($('input[name="component_toggle_on"]').val() == '' || $('input[name="component_toggle_off"]').val() == '' || $('input[name="component_toggle_width"]').val() == '') {

   flag = false;

   if ($('input[name="component_toggle_on"]').val() == '') {
     addErrorbox($('input[name="component_toggle_on"]'));
   } else {
     removeErrorbox($('input[name="component_toggle_on"]'));
   }

   if ($('input[name="component_toggle_off"]').val() == '') {
     addErrorbox($('input[name="component_toggle_off"]'));
   } else {
     removeErrorbox($('input[name="component_toggle_off"]'));
   }

   if ($('input[name="component_toggle_width"]').val() == '') {
     addErrorbox($('input[name="component_toggle_width"]'));
   } else {
     removeErrorbox($('input[name="component_toggle_width"]'));
   }

 } else {

  removeErrorbox($('input[name="component_toggle_on"]'));
  removeErrorbox($('input[name="component_toggle_off"]'));
  removeErrorbox($('input[name="component_toggle_width"]'));
}
}

  // if ($('input[name="component_option_name[]"]').length < 2) {
  //       flag = false;

  // }

  if (!flag) {

   $('.error-message').css('display','block');

 } else {

   $('.error-message').css('display','none');

 }

 return flag;  

}
function insertAfter(newNode, referenceNode) {
  referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
}

$(document).on('keyup','input[name="component_min"], input[name="component_max"], input[name="component_row"], input[name="component_col"]',function () {

 this.value = this.value.replace(/[^0-9]/g, '');


});


$('#problem-form').validate({
  rules: {
    problem_name: {
      required: true
    }
  },
  messages:{
    problem_name: {
      required: "Problem name is required !"
    }
  },
});

$('#component-property').validate({
  rules: {
    fcomponent_label: {
      required: true
    },
    fcomponent_name: {
      required: true
    }
  }
});


$(document).on('keyup','input[name="component_name"]',function() {
  $("input[name='decimaldependencyname[]']").val($(this).val());
  $("input[name='digitdependencyname[]']").val($(this).val());  
});

$(document).on('click','.remove-toggle-select',function() {

  var parentSelector = $(this).parent().parent();
  parentSelector.remove();

  if ($(".option-dependancy").find("tbody tr").length == 0) {

    var dependencyNameset = [];
    var sourceId =  $(".option-dependancy").find('input[name="foption_dependancy_name[]"]').data('og-element-id');
    $('#'+sourceId).val(encodeURIComponent(JSON.stringify(dependencyNameset)));

  }

});

$(document).on('change','select[name="foption_dependancy_value[]"], select[name="component_dependancy[]"], select[name="decimaldependencyname[]"]',function() {
 var dependencyNameset = [];
 var i = 1;
 $('select[name="foption_dependancy_value[]"], select[name="component_dependancy[]"], select[name="decimaldependencyname[]"]').each(function(){
   var tempDependancy = {
     'dependencyName'  : $(this).parent().parent().parent().parent().find('input[name="foption_dependancy_name[]"]').val(),
     'dependencyValue'  : $(this).val(),

   };
   dependencyNameset.push(tempDependancy);
   i++;
 });
 var sourceId =  $(this).parent().parent().parent().parent().find('input[name="foption_dependancy_name[]"]').data('og-element-id');
 $('#'+sourceId).val(encodeURIComponent(JSON.stringify(dependencyNameset)));
});

