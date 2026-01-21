var problemProperty = {
  'episodeBlock'     : 'single-problem',
  'episodeContentId' : '#content',
  'episodelist'      : 'problem-lists'
};


function getEpisodeContentId(contentNumber) {
  return problemProperty.episodeContentId+contentNumber ; 
}

function getEpisodecount() {

  var final_episode = $('.'+problemProperty.episodeBlock+':last-child > div > h5 > a').attr('data-pcontent');
  final_episode = (typeof final_episode == 'undefined') ? 0 : parseInt(final_episode);

  return episodeProperty = {
   'episodeCount'   : final_episode + 1,
 };

}
function getEpisode(episodeProperty,result) {

  var episodeContainer  = '<div class="'+problemProperty.episodeBlock+'">';
  episodeContainer += '<div><h5><a href="javascript:void(0);" data-pcontent="'+episodeProperty.episodeCount+'" class="edit-episode">Episode '+episodeProperty.episodeCount;+'</a>';
  episodeContainer += '<a href="javascript:void(0);" class="info-tick btn-info"><i class="fa fa-info" aria-hidden="true"></i></a>';
          // episodeContainer += '<a href="javascript:void(0);" data-pcontent="'+episodeProperty.episodeCount+'" class="pull-right edit-episode">';
          // episodeContainer += '<i class="fa fa-pencil" aria-hidden="true"></i></a>';
          episodeContainer += '<a href="javascript:void(0);" data-pcontent="'+episodeProperty.episodeCount+'" data-episode-id="0" class="pull-right remove-episode">';
          episodeContainer += '<i class="fa fa-trash" aria-hidden="true"></i></a>';
          episodeContainer += '</h5><div>'; 
          episodeContainer += '<div class="problem-contents" id="content'+episodeProperty.episodeCount+'">'+result+'</div>';
          episodeContainer += '</div>';
          return  episodeContainer;      

        }

        function expandEpisode(expande) {

          if(expande.hasClass('down')) {

            expande.addClass('up').removeClass('down').html('<i class="fa fa-angle-up fa-lg" aria-hidden="true"></i>');
            expande.parent().siblings().slideDown();

          }else if(expande.hasClass('up')){
            expande.addClass('down').removeClass('up').html('<i class="fa fa-angle-down fa-lg" aria-hidden="true"></i>');
            expande.parent().siblings().slideUp();

          }

        }
        function expandTitle(expandTitle) {
          if(expandTitle.hasClass('down')) {

            expandTitle.addClass('up').removeClass('down').html('<i class="fa fa-angle-up fa-lg" aria-hidden="true"></i>');
            $('.'+expandTitle.data('main-header')).slideDown();

          }else if(expandTitle.hasClass('up')){
            expandTitle.addClass('down').removeClass('up').html('<i class="fa fa-angle-down fa-lg" aria-hidden="true"></i>');
            $('.'+expandTitle.data('main-header')).slideUp();

          }

        }

        function addFormbuilder(result) { 

         if ($('.'+problemProperty.episodeBlock).last().length > 0) { 
          $('.'+problemProperty.episodeBlock).last().after(getEpisode(getEpisodecount(),result));
        } else {
         $('.'+problemProperty.episodelist).append(getEpisode(getEpisodecount(),result));
       }


     }


     function createToggle() {
      $('.initialze-toggle').each(function() {
        var name = $(this).attr('name');
        $('input[name="'+name+'"]').bootstrapToggle();
        $(this).removeClass('initialze-toggle');

      });
    }
    function createHorizontalselector() {

      $('.horizontal').each(function(){
        buildSelector($(this).attr('id'));
        $(this).removeClass('horizontal');
      });
    }



    function problemToggledepandancy(toggle) {

      var  uniqueId         = toggle.attr('id');
      var  toggleid         = toggle.data('toggle-id');
      var  name             = toggle.attr('name').replace('['+toggleid+']','')+'problem'; 
      var  depentancy       = toggle.data('dependancy');
      var  toggleOnLabel    = toggle.data('on').toString().replace('+',' ');
      var  toggleOffLabel   = toggle.data('off').toString().replace('+',' ');
      var  propertyChecked  = toggle.prop('checked');
      var  nottoggle;
           toggleid         = toggleid + 1;

      uniqueId   = uniqueId.replace(name, '');
      uniqueId   = 'problem'+uniqueId;
      depentancy = JSON.parse(decodeURIComponent(depentancy));

      $.each(depentancy,function(index,value) {
        if (value.dependencyName.replace(/\+/g, ' ').toLowerCase() == toggleOnLabel.toLowerCase()) {

          if (propertyChecked == true) {
           if (value.dependencyValue != null) {
            $.each(value.dependencyValue, function(dindex, dvalue) {
              if ($('input[name="'+dvalue+'[]"]').attr('type') == "radio") {
                $('input[name="'+dvalue+'[]"]').parents('.form-group').slideUp();
              } else {
                $('#'+dvalue+uniqueId).parents('.form-group').slideUp();
              }
              if ($('.'+dvalue).parents('table').hasClass('drug-module-depentancy')) {
                $('.'+dvalue).parents('table').parent().slideUp();
              }
              if ($('.'+dvalue).parents('table').hasClass('antibiotic-module-depentancy')) {
               $('.'+dvalue).parents('table').parent().slideUp();
             }
             if ($('.add-more-dropbox-'+dvalue+'-'+toggleid).hasClass('table')) {
               $('.add-more-dropbox-'+dvalue+'-'+toggleid).parent().slideUp();
             }

           });
          }  

        } else {
         if (value.dependencyValue != null) {
          $.each(value.dependencyValue, function(dindex, dvalue) {
            if ($('input[name="'+dvalue+'[]"]').attr('type') == "radio") {
              $('input[name="'+dvalue+'[]"]').parents('.form-group').slideDown();
            } else {
              $('#'+dvalue+uniqueId).parents('.form-group').slideDown();
            }
            if($('.'+dvalue).parents('table').hasClass('drug-module-depentancy')) {
              $('.'+dvalue).parents('table').parent().slideDown()
            } 
            if ($('.'+dvalue).parents('table').hasClass('antibiotic-module-depentancy')) {
             $('.'+dvalue).parents('table').parent().slideDown();
           } 
           if ($('.add-more-dropbox-'+dvalue+'-'+toggleid).hasClass('table')) {
             $('.add-more-dropbox-'+dvalue+'-'+toggleid).parent().slideDown();
           }
         });
        }  
      }  

    }
    if (value.dependencyName.replace(/\+/g, ' ').toLowerCase() == toggleOffLabel.toLowerCase()) {
      if (propertyChecked == false) {

        if (value.dependencyValue != null) {
          $.each(value.dependencyValue, function(dindex, dvalue) {
            if ($('input[name="'+dvalue+'[]"]').attr('type') == "radio") {
              $('input[name="'+dvalue+'[]"]').parents('.form-group').slideUp();
            } else {
              $('#'+dvalue+uniqueId).parents('.form-group').slideUp();
            } 
            if (value.dependencyName.replace('+',' ').toLowerCase() == "no" && $('input[name="'+dvalue+'[]"]').attr('type') == "checkbox") {
              if ($('input[name="'+dvalue+'[]"]').prop('checked') == true) {
                $('input[name="'+dvalue+'[]"]').prop('checked', false).trigger("change");
              }
            }
            if($('.'+dvalue).parents('table').hasClass('drug-module-depentancy')) {
              $('.'+dvalue).parents('table').parent().slideUp();
            }
            if ($('.'+dvalue).parents('table').hasClass('antibiotic-module-depentancy')) {
             $('.'+dvalue).parents('table').parent().slideUp();
           }
           if ($('.add-more-dropbox-'+dvalue+'-'+toggleid).hasClass('table')) {
            console.log('.add-more-dropbox-'+dvalue+'-'+toggleid);
             $('.add-more-dropbox-'+dvalue+'-'+toggleid).parent().slideUp();
           }
         });
        }
      }else {
        if (value.dependencyValue != null) {
          $.each(value.dependencyValue, function(dindex, dvalue) {
            if ($('input[name="'+dvalue+'[]"]').attr('type') == "radio") {
              $('input[name="'+dvalue+'[]"]').parents('.form-group').slideDown();
            } else {
              if (jQuery.inArray( dvalue, nottoggle ) < 0) {
                $('#'+dvalue+uniqueId).parents('.form-group').slideDown();
              }
            }
            if ($('input[name="'+dvalue+'[]"]').attr('type') == "checkbox") {
              if ($('#'+dvalue+uniqueId).prop('checked') == false) {
                var subdepentancy = $('#'+dvalue+uniqueId).data('dependancy');
                subdepentancy = eval(decodeURIComponent(subdepentancy));
                if (typeof subdepentancy != "undefined") {
                  $.each(subdepentancy,function(index1,value1) {
                    nottoggle = jQuery.makeArray(Object.values(value1)[1]);
                  });
                }
              }
            }
            if($('.'+dvalue).parents('table').hasClass('drug-module-depentancy')) {
              $('.'+dvalue).parents('table').parent().slideDown();
            } 
            if ($('.'+dvalue).parents('table').hasClass('antibiotic-module-depentancy')) {
             $('.'+dvalue).parents('table').parent().slideDown();
           } 
           if ($('.add-more-dropbox-'+dvalue+'-'+toggleid).hasClass('table')) {
             $('.add-more-dropbox-'+dvalue+'-'+toggleid).parent().slideDown();
           }
         });
        }  
      }  

    }

  });
}

$(document).ready(function() {

  $('.add-episode').click(function() {
   var problemId = $('input[name="problem_id_encrypt"]').val();
   getListofproblems(problemId);
 });

  $('.episodes,.problem-contents').hide();


  $('.expande-title').click(function() {
   expandTitle($(this));
 });

  $('.episodes').hide();
  createToggle();
  createHorizontalselector();

  
});

$(document).on('click','.expande',function() {
 expandEpisode($(this));
});

$(document).on('click','.edit-episode',function() {

  $('.edit-episode').each(function() {

    var contentId = getEpisodeContentId($(this).data('pcontent'));

    if ($(contentId).is(':visible')) {

      $(contentId).slideUp();
    } 

  }); 

  var contentId = getEpisodeContentId($(this).data('pcontent'));

  if ($(contentId).is(':visible')) {

    $(contentId).slideUp();

  } else {

    $(contentId).slideDown();
  }

});

$(document).on('click', '.add-medicine', function() {

 var id               = $(this).data('source-drug');
 var medicineName     = $(this).data('source-medicinename');
 var medicineDuration = $(this).data('source-medicineduration');
 var medicineDose     = $(this).data('source-medicinedose');

 drugSet  = '<tr>'; 
 drugSet += '<td class="input-width-xlarge"><select class="form-control" name="'+medicineName+'">'+'<option value="N/A">N/A</option>'+$('select[name="temp_medicine"]').html()+'</select></td>';
 drugSet += '<td class="input-width-xlarge"><input class="form-control" value="" name="'+medicineDuration+'" type="text"></td>';
 drugSet += '<td class="input-width-xlarge"><input class="form-control" value="" name="'+medicineDose+'" type="text"></td>';
 drugSet += '<td><a href="javascript:void(0);" class="btn remove-medicine"><i class="fa fa-times" aria-hidden="true"></i></a></td>';
 drugSet += '</tr>';

  // $('table[class="table add-more-drugs'+id+'"] tbody').append(drugSet);  
  $(this).parent().parent().children('table').append(drugSet);

});


$(document).on('click', '.add-text-box', function() {

  var textName   = $(this).data('source-textname');
  var id         = $(this).data('source-id');
  var tableName  = $(this).data('table-name');
  var textboxSet  = '<tr>';
  textboxSet += '<td>';
  textboxSet += '<input name="'+textName+'" value="" class="form-control" placeholder="" type="text">';  
  textboxSet += '</td>';
  textboxSet += '<td>';
  textboxSet += '<a href="javascript:void(0);" class="btn remove-text"><i class="fa fa-times" aria-hidden="true"></i></a>';
  textboxSet += '</td>';
  textboxSet += '<tr>';
  $('table[class="add-more-textbox'+tableName+'-'+id+' table"] tbody') .append(textboxSet);   
});


$(document).on('click', '.remove-text', function() {
 $(this).parent().parent().remove();
});

$(document).on('click', '.add-drop-box', function() {
  var droptName   = $(this).data('source-dropbox');
  var id          = $(this).data('source-id');
  var optionName  = $(this).data('option-name');
  var tableName   = $(this).data('table-name');

  var dropbox     =  '<tr>';
  dropbox     += '<td>';
  dropbox     += '<select name="'+droptName+'" class="input-width-xlarge form-control">'+$('select[name="'+optionName+'"]').html()+'</select>';
  dropbox     += '</td>';
  dropbox     += '<td>';
  dropbox     += '<a href="javascript:void(0);" class="btn remove-drop-down"><i class="fa fa-times" aria-hidden="true"></i></a>';
  dropbox     += '</td>';
  dropbox     += '</tr>';

  $('table[class="table add-more-dropbox-'+tableName+'-'+id+'"] tbody').append(dropbox);  

});

$(document).on('click', '.remove-drop-down', function() {

  $(this).parent().parent().remove();

});

$(document).on('click', '.add-antibiotic', function() {
 var antiobioticName    = $(this).data('antibioticname');
 var antibioticDuration = $(this).data('antibioticduration'); 
 var antibioticid       = $(this).data('antibioticid');

 var antibiotic  = [];
 var bioContent  = '<select class="form-control" name="'+antiobioticName+'">';
 bioContent += '<option value="N/A">N/A</option>'; 
 bioContent += $('select[name="temp_antibiotic"]').html(); 
 bioContent += '</select>';
 antibiotic.push(bioContent);  
 var bioContent  = '<input type="text" name="'+antibioticDuration+'" class="form-control">';  
 antibiotic.push(bioContent);  
 var bioContent  = '<a href="javascript:void(0);"class="btn remove-antibiotic">'; 
 bioContent += '<i class="fa fa-times" aria-hidden="true"></i>';
 bioContent += '</a>';
 antibiotic.push(bioContent);
 var antibioticRow = createTablerow(antibiotic);
   // $('table[class="table add-more-antibiotic-'+antibioticid+'"] tbody').append(antibioticRow);
   $(this).parent().parent().children('table').append(antibioticRow);

 });

function createTablerow(tableContent) {

  var tableRows ='<tr>';

  for (var i = 0; i < tableContent.length; i++) {
   tableRows += '<td class="input-width-xlarge">';
   tableRows += tableContent[i];
   tableRows +='</td>';
   
 }

 tableRows +='</tr>';
 return tableRows;

}
$(document).on('change','input[data-toggle="toggle"]',function() {
  problemToggledepandancy($(this));
});

$('input[data-toggle="toggle"]').each(function() {
  problemToggledepandancy($(this));
});

$(document).on('click', '.remove-medicine', function() {
  $(this).parent().parent().remove();
});
$(document).on('click', '.remove-antibiotic', function() {
  $(this).parent().parent().remove();
});

$(document).on('click', '.remove-episode', function() {
  var episodeObject = $(this);
  bootbox.confirm("Are you sure want remove episode ?",function(confirmed) {
    if (confirmed) {
     if (episodeObject.data('episode-id') == 0) {
       episodeObject.parent().parent().parent().remove();
       Showalert('info', 'Episode removed successfully');
     } else {
             // var  episodeId = episodeObject.data('episode-id');
             //   episodeObject.parent().parent().parent().remove();
             getRemoveEpisode(episodeObject);
           }
         }

       });

});

var dependancy = dependancysub = new Array();


$(document).on('keyup',"input[type='number']",function() {
  problemDigitdepandancies($(this));      
});

$("input[type='number']").each(function() {
  problemDigitdepandancy($(this));
});

function problemDigitdepandancy(numberfield) {

  var  uniqueId         = numberfield.attr('id');
  var  name             = numberfield.attr('name').replace('[]',''); 
  var  depentancy       = numberfield.data('dependancy');

  if (depentancy != "") {
    depentancy = JSON.parse(decodeURIComponent(depentancy));
    var sum = "";

    dependancyCreate(depentancy, uniqueId, name, sum);
  }

}

function problemDigitdepandancies(numberfield) {

  var  uniqueId1         = numberfield.attr('id');
  var  name             = numberfield.attr('name').replace('[]',''); 

  if (typeof dependancy[name] != "undefined") {
    $.each(dependancy[name],function(dependancyindex,dependancyvalue) {

      uniqueid1 = uniqueId1.split("-");

      dependencyField = "#"+dependancyvalue+"problem-"+uniqueid1[1]+"-"+uniqueid1[2];
      
      var  uniqueId         = $(dependencyField).attr('id');
      var  name             = $(dependencyField).attr('name').replace('[]',''); 
      var  depentancy       = $(dependencyField).data('dependancy');

      if (depentancy != "") {
        depentancy = JSON.parse(decodeURIComponent(depentancy));
        var sum = "";

        dependancyCreate(depentancy, uniqueId, name, sum);
      }

    });
  }
}

function dependancyCreate(depentancy, uniqueId, name, sum) {

  $.each(depentancy,function(index,value) {

    if (value.dependencyValue != "N/A" && value.dependencyName == name) {

      uniqueid = uniqueId.split("-");

      dependencyField = "#"+value.dependencyValue+"problem-"+uniqueid[1]+"-"+uniqueid[2];

      var calfield = $(".problem-lists").find(dependencyField).html();

      if (typeof calfield != "undefined") {

        if (dependancy.hasOwnProperty(value.dependencyValue)) {
          dependancysub = value.dependencyName;
          if ($.inArray( dependancysub, dependancy[value.dependencyValue]) == -1) {
            dependancy[value.dependencyValue].push(dependancysub);
          }
        } else {
          dependancy[value.dependencyValue] = new Array();            
          dependancysub = value.dependencyName;
          dependancy[value.dependencyValue].push(dependancysub);
        }

        sum += $(dependencyField).val();  
        if (sum.indexOf("+") != -1) {
          var temp = sum.split("+");
          sum = parseInt(temp[0]) + parseInt(temp[1]);
        } else if (sum.indexOf("-") != -1) {
          var temp = sum.split("-");
          sum = parseInt(temp[0]) - parseInt(temp[1]);
        } else if (sum.indexOf("*") != -1) {
          var temp = sum.split("*");
          sum = parseInt(temp[0]) * parseInt(temp[1]);
        } else if (sum.indexOf("/") != -1) {
          var temp = sum.split("/");
          sum = parseInt(temp[0]) / parseInt(temp[1]);
        }

      } else {
        if (value.dependencyValue == 'Addition') {
          sum +=  "+";
        } else if (value.dependencyValue == 'Substraction') {
          sum +=  "-";
        } else if (value.dependencyValue == 'Multiplication') {
          sum +=  "*";
        } else if (value.dependencyValue == 'Division') {
          sum +=  "/";
        }
      }

    }

    $("#"+uniqueId).val(sum); 
    $("#"+uniqueId).trigger("keyup");

    dependancysub = new Array();

  });

}
$(document).on('click', '.update_btn', function(e){

  if($('.problem-lists').find('.single-problem').length === 0)
  {
    e.preventDefault();
    alert('Please Create atleast one episode to continue...');
    return false;
  }
});
$(document).on('click', '.prblm_save_btn', function(e){
  if($('.problem-lists').find('.single-problem').length === 0)
  {
    e.preventDefault();
    alert('Please Create atleast one episode to continue...');
    return false;
  }
});
