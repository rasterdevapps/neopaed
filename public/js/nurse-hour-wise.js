$(document).ready(function() {

$('input[name^="last_bg_time"]').mdtimepicker();
  function bpmethod() {

    var bpMethod = $('#bp_method').val();
    if(bpMethod == 'Cuff') {
      $('.arterial_systalic_bp, .arterial_diastolic_bp, .arterial_mean_bp').parent().slideUp();
      $('.cuff_systalic_bp, .cuff_diastolic_bp, .cuff_mean_bp').parent().slideDown();

    } else if(bpMethod == 'Arterial') {

      $('.cuff_systalic_bp, .cuff_diastolic_bp, .cuff_mean_bp').parent().slideUp();
      $('.arterial_systalic_bp, .arterial_diastolic_bp, .arterial_mean_bp').parent().slideDown();

    } else {
      $('.cuff_systalic_bp, .cuff_diastolic_bp, .cuff_mean_bp').parent().slideDown();
      $('.arterial_systalic_bp, .arterial_diastolic_bp, .arterial_mean_bp').parent().slideDown();

    }
  }
    //mode_of_ventilation
   // mode_of_ventilation_invasive

   function modeofInvasivevendilation() {



     var ventilationMode  = $('#mode_of_ventilation_invasive').val();

     if (ventilationMode != '') {
      $('#mode_of_ventilation').val('').trigger('change');
      $('#fio2_measured, #humidifier_temp').val('');
      $('.fio2_measured, .humidifier_temp').parent().slideUp();
    }

    if (ventilationMode == 'HHHFNC' || ventilationMode == 'HBO2' || ventilationMode == 'NPO2') {

      $('.fio2, .flow').parent().slideDown();

      // $('#cpap_interface_change').parent().slideDown();
      $('#volume_targeting').attr('checked', false).trigger('change');
      $('#volume_targeting').parent().parent().slideUp();

      $('#targeted_tidal_volume, #p_amplitude, #pip_set, #pip_delivered, #peep, #map, #delivered_tidal_volume, #rate, #frequency, #it_rate, #it_rate_secound, #ie_r').val('');
      $('.targeted_tidal_volume, .p_amplitude, .pip_set, .pip_delivered, .peep, .map, .delivered_tidal_volume, .rate, .frequency, .it_rate, .it_rate_secound, .ie_r').parent().slideUp();
      $('#cpap_interface_change').parent().slideUp();

    } else if (ventilationMode == 'CPAP') {

      $('.peep, .fio2').parent().slideDown();

      $('#volume_targeting').attr('checked', false).trigger('change');
      $('#volume_targeting').parent().parent().slideUp();
      $('#cpap_interface_change').parent().slideDown();

      $('#targeted_tidal_volume, #p_amplitude, #pip_set, #pip_delivered, #map, #delivered_tidal_volume, #rate, #frequency, #it_rate, #it_rate_secound, #ie_r, #flow').val('');
      $('.targeted_tidal_volume, .p_amplitude, .pip_set, .pip_delivered, .map, .delivered_tidal_volume, .rate, .frequency, .it_rate, .it_rate_secound, .ie_r, .flow').parent().slideUp();
      $('#cpap_interface_change').parent().slideUp();

    } else if (ventilationMode == 'BiPAP' || ventilationMode == 'NIPPV') {

      $('.pip_set, .pip_delivered, .peep, .rate, .it_rate_secound').parent().slideDown();
      // $('#cpap_interface_change').parent().slideDown();

      $('#p_amplitude, #frequency, #it_rate').val('');
      $('.p_amplitude, .frequency, .it_rate').parent().slideUp();

      $('#targeted_tidal_volume, #p_amplitude, #map, #delivered_tidal_volume, #frequency, #it_rate, #ie_r, #fio2, #flow').val('');
      $('.targeted_tidal_volume, .p_amplitude, .map, .delivered_tidal_volume, .frequency, .it_rate, .ie_r, .fio2, .flow').parent().slideUp();

      $('#volume_targeting').parent().parent().slideUp();

      $('#cpap_interface_change').parent().slideUp();

    } else if(ventilationMode == 'Nasal HFOV') {

      $('.p_amplitude, .map, .frequency, .fio2').parent().slideDown();
      // $('#cpap_interface_change').parent().slideDown();

      $('#cpap_interface_change').parent().slideUp();

      $('#targeted_tidal_volume, #delivered_tidal_volume, #it_rate, #ie_r, #flow, #it_rate_secound, #pip_set, #pip_delivered, .peep, #rate').val('');
      $('.targeted_tidal_volume, .delivered_tidal_volume, .it_rate, .ie_r, .flow, .it_rate_secound, .pip_set, .pip_delivered, .peep, .rate').parent().slideUp();

      $('#volume_targeting').parent().parent().slideUp();

    } else if(ventilationMode == 'Incubator O2') {

      $('.fio2').parent().slideDown();

      $('#targeted_tidal_volume, #delivered_tidal_volume, #it_rate, #ie_r, #flow, #it_rate_secound, #p_amplitude, #pip_set, #pip_delivered, #peep, #map, #rate, #frequency').val('');
      $('.targeted_tidal_volume, .delivered_tidal_volume, .it_rate, .ie_r, .flow, .it_rate_secound, .p_amplitude, .pip_set, .pip_delivered, .peep, .map, .rate, .frequency').parent().slideUp();
      $('#volume_targeting').parent().parent().slideUp();
      $('#cpap_interface_change').parent().slideUp();

      }  else {

      $('#targeted_tidal_volume, #delivered_tidal_volume, #it_rate, #ie_r, #flow, #it_rate_secound, #p_amplitude, #pip_set, #pip_delivered, #peep, #map, #rate, #frequency, #fio2').val('');
      $('.targeted_tidal_volume, .delivered_tidal_volume, .it_rate, .ie_r, .flow, .it_rate_secound, .p_amplitude, .pip_set, .pip_delivered, .peep, .map, .rate, .frequency, .fio2').parent().slideUp();

      }


  }

  function modeofnoninvasivevendilation() {

    var ventilationMode  = $('#mode_of_ventilation').val();

    if (ventilationMode != '') {
      $('#mode_of_ventilation_invasive').val('').trigger('change');
    }
    if (ventilationMode == 'CMV' || ventilationMode == 'IMV' || ventilationMode == 'SIMV' || ventilationMode == 'PSV' || ventilationMode == 'PTV') {

      $('.targeted_tidal_volume, .p_amplitude, .pip_set, .pip_delivered, .peep, .map, .delivered_tidal_volume, .rate, .frequency, .it_rate, .it_rate_secound, .ie_r, .fio2, .flow').parent().slideDown();
      // $('#cpap_interface_change').parent().slideDown();

      $('#p_amplitude, #frequency, #it_rate').val('');
      $('.p_amplitude, .frequency, .it_rate').parent().slideUp();

      $('#cpap_interface_change').parent().slideUp();
      $('#volume_targeting').parent().slideDown();

    } else if(ventilationMode == 'HFO') {

      $('.targeted_tidal_volume, .p_amplitude, .pip_set, .pip_delivered, .peep, .map, .delivered_tidal_volume, .rate, .frequency, .it_rate, .it_rate_secound, .ie_r, .fio2, .flow').parent().slideDown();

      // $('#cpap_interface_change').parent().slideDown();

      $('#pip_set, #pip_delivered, #peep, #rate, #flow').val('');
      $('.pip_set, .pip_delivered, .peep, .rate, .flow').parent().slideUp();

      $('#cpap_interface_change').parent().slideUp();

      $('#volume_targeting').parent().slideDown();

    } else {

      $('.targeted_tidal_volume, .p_amplitude, .pip_set, .pip_delivered, .peep, .map, .delivered_tidal_volume, .rate, .frequency, .it_rate, .it_rate_secound, .ie_r, .fio2, .flow').parent().slideDown();
      // $('#cpap_interface_change').parent().slideDown();
      $('#cpap_interface_change').parent().slideUp();
      $('#volume_targeting').parent().slideDown();

    }

  }

  function volumeTargeting() {

    if ($('#volume_targeting').prop('checked') == true) {

      $('.targeted_tidal_volume').parent().slideDown();

    } else {

      $('.targeted_tidal_volume').parent().slideUp();
    }

  }

  $('#volume_targeting').change(function() {
   volumeTargeting();

 });

  $('#mode_of_ventilation_invasive').change(function() {
   modeofInvasivevendilation();

 });

  $('#mode_of_ventilation').change(function() {
    if ($(this).val() == '') {
      $('.ventilator_properties').hide();
    }
    else{
        modeofnoninvasivevendilation();
    }

 });



  volumeTargeting();



  

  var buildId = ['position','Transfusion','activity', 'mode_of_ventilation_invasive','replacement_fluids_status','bp_method','work_of_breathing','mode_of_ventilation','type_of_care','type_of_feeds','route_of_feeds','color','cpap_interface_change','air_entry','air_entry_right','air_entry_left', 'phototherapy_eyes', 'milk_feeds'];

  $.each(buildId,function(index, value) {
    buildSelector(value);
  });
  
  $('.drug_infusions_add').click(function() {

    var id  = parseInt($('.drug-solution').last().data('solution')) + 1 ;
    var options  = $('select[name="temp_drug_solution"]').html();  
    id = (isNaN(id) == true ) ? 0 : id;

    var custom_id = id;

    var drugInfusions    = '<td><select name="drug_solution[' + custom_id + ']" class="drug-solution input-width-xlarge permanant_saved not_saved" id="drug-solution-'+id+'" data-solution="'+id+'">'+options+'</select></td>';
    drugInfusions   += '<td><input class="form-control permanant_saved not_saved" name="drug_rate[' + custom_id + ']" data-solution='+id+' id="drug_rate" type="number"></td>';
    drugInfusions   += '<td><input class="form-control drug_total permanant_saved not_saved" name="drug_total[' + custom_id + ']"  id="drug-rate-'+id+'" type="number" readonly></td>';
    drugInfusions   += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>';
    var drugInfusionsSet = '<tr>'+drugInfusions+'</tr>';     
    $('.drug_infusions tbody').append(drugInfusionsSet);

    initiateSelecttwo('#drug-solution-'+id);


  });

  $('.replacement_fluids_add').click(function() {

   var options  = $('select[name="temp_drug_solution"]').html();  
   var id  = parseInt($('.replacement-fluids-solution').last().data('replacement')) + 1 ;
   id = (isNaN(id) == true ) ? 0 : id;

   var replacementFluids   = '<td> <select class="replacement-fluids-solution input-width-xlarge" name="replacement_fluids_solution[]" data-replacement="'+id+'" id="replacement-fluids-solution-'+id+'">'+options+'</select></td>';   
   replacementFluids  += '<td> <input class="form-control" name="replacement_fluids_rate[]" data-solution="'+id+'" id="replacement_fluids_solution" type="number"></td>';   
   replacementFluids  += '<td> <input class="form-control" name="replacement_fluids_total[]" id="replacement_fluids_total'+id+'" type="number"></td>';   
   replacementFluids   += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>';
   replacementFluidsSet = '<tr>'+replacementFluids+'</tr>';

   $('.replacement_fluids tbody').append(replacementFluidsSet);

   initiateSelecttwo('#replacement-fluids-solution-'+id);  

 });

  $('.product_add').click(function() {
   var productNameList= $('select[name="f_product_temp"]').html();
   var productList      = '<td><select name="F_Product[]" class="form-control">'+productNameList+'</select></td>';
   productList     += '<td><input type="number" class="form-control" name="F_Volume[]" value=""/></td>';
   productList     += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>';
   var productListSet   = '<tr>'+productList+'</tr>';
   $('table.product tbody').append(productListSet);

 });

  function addInfusiondrug(inserId){

    var infusionList = $('select[name="infusion_temp"]').html();
    var infusionGenList = $('select[name="infusion_gen_temp"]').html();

    var infusionLength = $('table.infusion-drugs tbody tr').length;
    infusionLength = (isNaN(infusionLength) == true) ? 0 : infusionLength;

    var infusionDoseunitsg    = $('select[name="infusion_dose_units_temp_g"]').html();
    var infusionDoseunitskg   = $('select[name="infusion_dose_units_temp_kg"]').html();
    var infusionDoseunitstime = $('select[name="infusion_dose_units_temp_time"]').html();

    var infusionQuantityunits = $('select[name="infusion_quantity_units_temp"]').html();
    var syringeSize           = $('select[name="temp_syringe"]').html();

    var id             = parseInt($('.infusion_brandname').last().data('drug'))+1;
    id             = (isNaN(id) == true ) ? 0 : id;
    var infusionId     = infusionLength+'-'+id;


    var infusionDoes  ='<table class="table-align-center">';
    infusionDoes +='<tbody><tr>';
    infusionDoes +='<td><input class="form-control input-width-sub-mini-1" name="infusion_dose[]" id="infusion_dose-'+infusionId+'" type="text"></td>';
    infusionDoes +='<td><select class="form-control infusion-dose-units-g input-width-mini" id="infusion-dose-units-g-'+infusionId+'" name="infusion_dose_units_g[]">'+infusionDoseunitsg+'</select></td>';
    infusionDoes +='<td><select class="form-control infusion-dose-units-kg input-width-mini" id="infusion-dose-units-kg-'+infusionId+'" name="infusion_dose_units_kg[]">'+infusionDoseunitskg+'</select></td>';
    infusionDoes +='<td><select class="form-control infusion-dose-units-time input-width-mini" id="infusion-dose-units-time-'+infusionId+'" name="infusion_dose_units_time[]">'+infusionDoseunitstime+'</select></td>';
    infusionDoes +='</tr></tbody>';
    infusionDoes +='</table>';

    var infusionQuantity  = '<table><tbody><tr>';
    infusionQuantity += '<td><input class="form-control input-width-sub-mini-1  infusion-quantity" id="infusion-quantity-'+infusionId+'" name="infusion_quantity[]" type="text"></td>';
    infusionQuantity += '<td><select class="form-control infusion-quantity-units input-width-mini" id="infusion-quantity-units-'+infusionId+'" name="infusion_quantity_units[]">'+infusionQuantityunits+'</select></td>';
    infusionQuantity += '</tr></tbody></table>';

    var infusionSyringe  = '<table><tbody><tr>';
    infusionSyringe += '<td><select class="form-control infusion-syringe" name="infusion_syringe[]" id="infusion-syringe-'+infusionId+'" type="text">'+syringeSize+'</select></td>';
    infusionSyringe += '<td class="unit-sub-elements"><span>ml</span></td>';
    infusionSyringe += '</tr></tbody></table>';

    var infusionRate   = '<table><tbody><tr>';   
    infusionRate  += '<td><input class="form-control infusion-rate-width" name="infusion_rate[]" data-drug="'+infusionId+'" id="infusion-rate-'+infusionId+'" type="text"></td>';
    infusionRate  += '<td><td class="unit-sub-elements"><span>ml/hr</span></td></td>';
    infusionRate  += '</tr></tbody></table>';

    var infusion  = '<td class="hide"><input id="iv-drug-infusion-'+infusionId+'" name="iv_drug_infusion_id" type="hidden" value="'+infusionId+'"></td>';
    infusion += '<td></td><td class="text-center"><input class="form-control input-width-sub-mini box-center" name="infusion_day[]" id="infusion-day-'+infusionId+'" type="text"></td>';
    infusion += '<td><select name="infusion_brandname[]" data-drug="'+infusionId+'" class="infusion_brandname input-width-medium" data-change-drug="'+infusionId+'" id="infusion-brandname-'+infusionId+'">'+infusionList+'</select></td>';
    infusion += '<td><select name="infusion_pharmacological[]" data-drug="'+infusionId+'" class="infusion_pharmacological input-width-medium" data-change-drug="'+infusionId+'" id="infusion-pharmacological-'+infusionId+'">'+infusionGenList+'</select></td>'; 
    infusion += '<td>'+infusionDoes+'</td>';
    infusion += '<td>'+infusionQuantity+'</td>';
    infusion += '<td>'+infusionSyringe+'</td>'; 
    infusion += '<td>'+infusionRate+'</td>'; 
    infusion += '<td><input class="form-control" name="infusion_instruction[]" id="infusion-instruction-'+infusionId+'" type="text"></td>';
            // infusion += '<td><input class="form-control date-prescribed" id="infusion-date-prescribed-'+id+'" name="infusion_date_prescribed[]" type="text"></td>';
            // infusion += '<td><input class="form-control time-prescribed" id="infusion-time-prescribed-'+id+'" name="infusion_time_prescribed[]" type="text"></td>';
            // infusion += '<td><input class="form-control date-prescribed" id="infusion-date-stopped-'+id+'" name="infusion_date_stopped[]" type="text"></td>';
            // infusion += '<td><input class="form-control time-prescribed" id="infusion-time-stopped-'+id+'" name="infusion_time_stopped[]" type="text"></td>';
            infusion += '<td><input class="form-control infusion-ivg-status" id="infusion-ivg-status-'+infusionId+'"  data-infusion-id="'+infusionId+'" name="infusion_ivg[]" type="checkbox" value="IVG"></td>';
            infusion += '<td colspan="4"><a href="javascript:void(0);" class="btn remove-prescription"><i class="fa fa-close"></i></a> '; 
            infusion += '<a href="javascript:void(0);" id="tick-'+infusionId+'" data-infusion-id="'+infusionId+'" class="btn submit-changes"><i class="fa fa-check"></i></a></td>';

            var infusionHidden = '<td class="hide"><input name="iv_drug_infusion_id[]" value="'+infusionId+'" type="hidden"></td>';

            var infusionListSet = '<tr data-base-id="'+infusionId+'" class="iv-enable-'+infusionId+'">'+infusionHidden+infusion+'</tr>';

            $(inserId).before(infusionListSet);
            // $('#infusion-time-prescribed-'+id).timeDropper();
            // $('#infusion-time-stopped-'+id).timeDropper({
            //   setCurrentTime:false
            // });
            // dateDropperSettings('infusion-date-prescribed-'+id);
            // dateDropperSettings('infusion-date-stopped-'+id);

            initiateSelecttwo('#infusion-brandname-'+infusionId);
            initiateSelecttwo('#infusion-pharmacological-'+infusionId);


          }

          $('.add-infusion').click(function() {
            var inserId = $(this).parent().parent();
            addInfusiondrug(inserId);

          });


      //edit view start
      
      $('.add-iv-drug-infusion').click(function() {

        var infusionList = $('select[name="infusion_temp"]').html();
        var infusionGenList = $('select[name="infusion_gen_temp"]').html();
        var timeSlot  =  $(this).data('infusion-header');

        var infusionDoseunitsg    = $('select[name="infusion_dose_units_temp_g"]').html();
        var infusionDoseunitskg   = $('select[name="infusion_dose_units_temp_kg"]').html();
        var infusionDoseunitstime = $('select[name="infusion_dose_units_temp_time"]').html();

        var infusionQuantityunits = $('select[name="infusion_quantity_units_temp"]').html();
        var infusionSyringes =  $('select[name="temp_syringe"]').html();


        var id = parseInt($('.infusion_brandname').last().data('drug'))+1;
        id = (isNaN(id) == true ) ? 0 : id;

        var idheader ='_'+id+'_'+timeSlot;
        var infusionDoesUnitHidden  = '<td class="hidden">' ;
        infusionDoesUnitHidden += '<input class="form-control" id="infusion_dose_units'+id+'" name="infusion_dose_units[infusion-dose-units'+idheader+']" type="hidden" value="">';   
        infusionDoesUnitHidden += '</td>';


        var infusionDoes  ='<table>';
        infusionDoes +='<tbody><tr>';
        infusionDoes +='<td><input class="form-control" name="infusion_dose[infusion-dose'+idheader+']" type="text"></td>';
        infusionDoes +='<td><select class="form-control infusion-dose-units-g input-width-mini" id="infusion_dose_units_'+id+'" name="infusion_dose_units_g[]">'+infusionDoseunitsg+'</select></td>';
        infusionDoes +='<td><select class="form-control infusion-dose-units-kg input-width-mini" id="infusion_dose_units_'+id+'" name="infusion_dose_units_kg[]">'+infusionDoseunitskg+'</select></td>';
        infusionDoes +='<td><select class="form-control infusion-dose-units-time input-width-mini" id="infusion_dose_units_'+id+'" name="infusion_dose_units_time[]">'+infusionDoseunitstime+'</select></td>';
        infusionDoes +='</tr></tbody>';
        infusionDoes +='</table>';

        var infusionQuantity  = '<table><tbody><tr>';
        infusionQuantity += '<td><input class="form-control infusion-quantity" name="infusion_quantity[infusion-quantity'+idheader+']" type="text"></td>';
        infusionQuantity += '<td><select class="form-control infusion-quantity-units input-width-mini" name="infusion_quantity_units[infusion-quantity-units'+idheader+']">'+infusionQuantityunits+'</select></td>';
        infusionQuantity += '</tr></tbody></table>';

        var infusionSyringe  = '<table><tbody><tr>';
        infusionSyringe += '<td><select class="form-control infusion-syringe" name="infusion_syringe[infusion-syringe'+idheader+']">'+infusionSyringes+'</select></td>';
        infusionSyringe += '<td class="unit-sub-elements"><span>ml</span></td>';
        infusionSyringe += '</tr></tbody></table>';

        var infusionRate   = '<table><tbody><tr>';   
        infusionRate  += '<td><input class="form-control" name="infusion_rate[infusion-rate'+idheader+']" type="text"></td>';
        infusionRate  += '<td><td class="unit-sub-elements"><span>ml/hr</span></td></td>';
        infusionRate  += '</tr></tbody></table>';

        var infusion  = infusionDoesUnitHidden;   
        infusion += '<td></td>';      
        infusion += '<td><input class="form-control input-width-sub-mini" name="infusion_day[infusion-day'+idheader+']" type="text"></td>';
        infusion += '<td><select name="infusion_brandname[infusion-brand'+idheader+']" data-drug="'+id+'" class="infusion_brandname input-width-large" id="infusion-brandname-'+id+'">'+infusionList+'</select></td>';
        infusion += '<td><select name="infusion_pharmacological[infusion-phara'+idheader+']" data-drug="'+id+'"  class="infusion_pharmacological input-width-large" id="infusion-pharmacological-'+id+'">'+infusionGenList+'</select></td>'; 
        infusion += '<td>'+infusionDoes+'</td>';
        infusion += '<td>'+infusionQuantity+'</td>';
        infusion += '<td>'+infusionSyringe+'</td>'; 
        infusion += '<td>'+infusionRate+'</td>'; 
        infusion += '<td><input class="form-control" name="infusion_instruction[infusion-instruction'+idheader+']" type="text"></td>';

        infusion += '<td><input class="form-control" id="infusion-date-prescribed-'+id+'" name="infusion_date_prescribed[infusion-date-prescribed'+idheader+']" type="text"></td>';
        infusion += '<td><input class="form-control" id="infusion-time-prescribed-'+id+'"  name="infusion_time_prescribed[infusion-time-prescribed'+idheader+']" type="text"></td>';
        infusion += '<td><input class="form-control" id="infusion-date-stopped-'+id+'"  name="infusion_date_stopped[infusion-date-stopped'+idheader+']" type="text"></td>';
        infusion += '<td><input class="form-control" id="infusion-time-stopped-'+id+'" name="infusion_time_stopped[infusion-time-stopped'+idheader+']" type="text"></td>';

        infusion += '<td><a href="javascript:void(0);" class="btn remove"><i class="fa fa-close"></i></a></td>'; 
        var infusionHidden = '<td class="hide"><input name="iv_drug_infusion_id[]" value="0" type="hidden"></td>';

        var infusionListSet   = '<tr>'+infusionHidden+infusion+'</tr>';

        $('.infusion_time_'+timeSlot).last().after(infusionListSet);
        initiateSelecttwo('#infusion-brandname-'+id);
        initiateSelecttwo('#infusion-pharmacological-'+id);

        $('#infusion-time-prescribed-'+id).timeDropper();
        $('#infusion-time-stopped-'+id).timeDropper({
          setCurrentTime:false
        });

        dateDropperSettings('infusion-date-prescribed-'+id);
        dateDropperSettings('infusion-date-stopped-'+id);


      });
      //edit view end


      $('.add-speical-fluids').click(function() {

        var id = parseInt($('.speical_name_one').last().data('fluids'))+1;
        id = (isNaN(id) == true ) ? 0 : id;

        var specialIvfluidLength = $('table.speical-fluids tbody tr').length;
        specialIvfluidLength = (isNaN(specialIvfluidLength) == true) ? 0 : specialIvfluidLength;
        var specialIVfluidId     = specialIvfluidLength+'-'+id;    

        var speical_fluids  =  $('select[name="temp_dextrose"]').html();    
        var speical_syringe =  $('select[name="temp_syringe"]').html();

        var speicalIvfluids1   = '<table>';    
        speicalIvfluids1  += '<tbody><tr>';
        speicalIvfluids1  += '<td><select data-fluids="'+specialIVfluidId+'" class="speical_name_one calculate-glucose width-75-must" id="speical_name_one_'+specialIVfluidId+'" name="speical_iv_fluid_name_one[]">'+speical_fluids+'</select></td>';
        speicalIvfluids1  += '<td class="hide"><input class="form-control input-width-small-mini" name="speical_iv_fluid_one[]" type="text"></td>';
        speicalIvfluids1  += '</tr></tbody>';
        speicalIvfluids1  += '</table>';

        var speicalIvfluids2   = '<table>';    
        speicalIvfluids2  += '<tbody><tr>';
        speicalIvfluids2  += '<td><select data-fluids="'+specialIVfluidId+'" class="speical_name_one calculate-glucose width-75-must" id="speical_name_two_'+specialIVfluidId+'" name="speical_iv_fluid_name_two[]">'+speical_fluids+'</select></td>';
            // speicalIvfluids2  += '<td class="hide"><input class="form-control input-width-small-mini" name="speical_iv_fluid_two[]" type="text"></td>';
            speicalIvfluids2  += '</tr></tbody>';
            speicalIvfluids2  += '</table>';

            var fluidsVolumeOne    = '<table><tbody><tr>';
            fluidsVolumeOne   += '<td><input class="form-control input-width-mini" data-fluids="'+specialIVfluidId+'" name="speical_fluid_vol_one[]" id="speical_fluid_vol_one_'+specialIVfluidId+'" readonly="true" type="text"></td>';
            fluidsVolumeOne   += '<td class="unit-sub-elements"><span>ml</span></td>';
            fluidsVolumeOne   += '</tr></tbody></table>';

            var fluidsVolumeTwo    = '<table><tbody><tr>';
            fluidsVolumeTwo   += '<td><input class="form-control input-width-mini" data-fluids="'+specialIVfluidId+'" name="speical_fluid_vol_two[]" id="speical_fluid_vol_two_'+specialIVfluidId+'" readonly="true" type="text"></td>';
            fluidsVolumeTwo   += '<td class="unit-sub-elements"><span>ml</span></td>';
            fluidsVolumeTwo   += '</tr></tbody></table>';   

            var fluidSyringe  = '<table class="table-align-center"><tbody><tr>';
            fluidSyringe += '<td><select class="form-control speical-iv-syringe calculate-glucose" data-fluids="'+specialIVfluidId+'" name="speical_iv_syringe[]" id="speical_iv_syringe_'+specialIVfluidId+'" type="text">'+speical_syringe+'</select></td>';
            fluidSyringe += '<td class="unit-sub-elements"><span>ml</span></td>';
            fluidSyringe += '</tr></tbody></table>';

            var fluidGlucose  = '<table class="table-align-center"><tbody><tr>';
            fluidGlucose += '<td><input class="form-control input-width-mini" data-fluids="'+specialIVfluidId+'" name="speical_iv_glucose[]" id="speical_iv_glucose_'+specialIVfluidId+'" type="text"></td>';
            fluidGlucose += '<td class="unit-sub-elements"><span>mg/kg/min</span></td>';
            fluidGlucose += '</tr></tbody></table>';  

            var fluidRate  = '<table class="table-align-center"><tbody><tr>';
            fluidRate += '<td><input class="form-control input-width-mini" data-fluids="'+specialIVfluidId+'" name="speical_iv_infusion_rate[]" id="speical_iv_infusion_rate_'+specialIVfluidId+'" type="text"></td>';
            fluidRate += '<td class="unit-sub-elements"><span>ml/h</span></td>';
            fluidRate += '</tr></tbody></table>';                


            var speical  = '<td></td><td class="text-center"><input class="form-control input-width-sub-mini box-center" name="speical_iv_day[]" id="speical_iv_day_'+specialIVfluidId+'" type="text"></td>';
            speical += '<td>'+speicalIvfluids1+'</td>'; 
            speical += '<td>'+fluidsVolumeOne+'</td>';  
            speical += '<td>'+speicalIvfluids2+'</td>';  
            speical += '<td>'+fluidsVolumeTwo+'</td>';  
            speical += '<td>'+fluidSyringe+'</td>';    
            speical += '<td><input class="form-control input-width-small" readonly="true" data-fluids="'+specialIVfluidId+'" id="speical_iv_dextrose_'+specialIVfluidId+'" name="speical_iv_dextrose[]" type="text"></td>';    
            speical += '<td>'+fluidGlucose+'</td>';    
            speical += '<td>'+fluidRate+'</td>';
            speical += '<td><input class="form-control" name="speical_iv_instruction[]" id="speical_iv_instruction_'+specialIVfluidId+'" type="text" ></td>' ;   

            speical += '<td> <input class="form-control infusion-ivg-status" id="speical-iv-pump-type-'+specialIVfluidId+'" name="speical_iv_pump_type" type="checkbox" value="IVG"></td>';

            speical += '<td colspan="4"><a href="javascript:void(0);" class="btn remove-prescription"><i class="fa fa-close"></i></a> '; 
            speical += '<a href="javascript:void(0);" id="tick-'+specialIVfluidId+'"class="btn speical-iv-infusion-changes" data-special-iv-fluids-id="'+specialIVfluidId+'"><i class="fa fa-check"></i></a></td>'; 

            var specialHidden = '<td class="hide"><input type="hidden" value="0" name="speical_iv_id[]"></td>';   

            var speicalData = '<tr class="special-iv-fluids-ls-'+specialIVfluidId+'">'+specialHidden+speical+'</tr>';

            $($(this).parent().parent()).before(speicalData);
            initiateSelecttwo('#speical_iv-time-prescribed-'+specialIVfluidId);
            initiateSelecttwo('#speical_iv-time-stopped-'+specialIVfluidId);
            initiateSelecttwo('#speical_name_one_'+specialIVfluidId);
            initiateSelecttwo('#speical_name_two_'+specialIVfluidId);


          });

    //edit view start
    $('.add-special-iv-fluids').click(function() {

      var id = parseInt($('.speical_name_one').last().data('fluids'))+1;
      id = (isNaN(id) == true ) ? 0 : id;

      var speicalFluidid  = $(this).data('special-fluids-header'); 

      var idheader ='_'+id+'_'+speicalFluidid;
      var syringeValue = $('select[name="temp_syringe"]').html();

      var speical_fluids  =  $('select[name="temp_dextrose"]').html();    

      var speicalIvfluids1   = '<table>';    
      speicalIvfluids1  += '<tbody><tr>';
      speicalIvfluids1  += '<td><select data-fluids="'+id+'" class="speical_name_one calculate-glucose input-width-medium" id="speical_name_one_'+id+'" name="speical_iv_fluid_name_one[speical-iv-fluid-name-one'+idheader+']">'+speical_fluids+'</select></td>';
      speicalIvfluids1  += '</tr></tbody>';
      speicalIvfluids1  += '</table>';

      var speicalIvfluids2   = '<table>';    
      speicalIvfluids2  += '<tbody><tr>';
      speicalIvfluids2  += '<td><select data-fluids="'+id+'" class="speical_name_one calculate-glucose input-width-medium" id="speical_name_two_'+id+'" name="speical_iv_fluid_name_two[speical-iv-fluid-name-two'+idheader+']">'+speical_fluids+'</select></td>';
      speicalIvfluids2  += '</tr></tbody>';
      speicalIvfluids2  += '</table>';

      var fluidsVolumeOne    = '<table><tbody><tr>';
      fluidsVolumeOne   += '<td><input class="form-control" data-fluids="'+id+'" name="speical_fluid_vol_one[speical-fluid-vol-one'+idheader+']" id="speical_fluid_vol_one_'+id+'" readonly="true" type="text"></td>';
      fluidsVolumeOne   += '<td class="unit-sub-elements"><span>ml</span></td>';
      fluidsVolumeOne   += '</tr></tbody></table>';

      var fluidsVolumeTwo    = '<table><tbody><tr>';
      fluidsVolumeTwo   += '<td><input class="form-control" data-fluids="'+id+'" name="speical_fluid_vol_two[speical-fluid-vol-two'+idheader+']"  id="speical_fluid_vol_two_'+id+'" readonly="true" type="text"></td>';
      fluidsVolumeTwo   += '<td class="unit-sub-elements"><span>ml</span></td>';
      fluidsVolumeTwo   += '</tr></tbody></table>';   

      var fluidSyringe  = '<table><tbody><tr>';
      fluidSyringe += '<td><select class="form-control speical-iv-syringe  calculate-glucose" data-fluids="'+id+'" id="speical_iv_syringe_'+id+'" name="speical_iv_syringe[speical-iv-syringe'+idheader+']">'+syringeValue+'</select></td>';
      fluidSyringe += '<td class="unit-sub-elements"><span>ml</span></td>';
      fluidSyringe += '</tr></tbody></table>';

      var fluidGlucose  = '<table><tbody><tr>';
      fluidGlucose += '<td><input class="form-control calculate-glucose" data-fluids="'+id+'" id="speical_iv_glucose_'+id+'" name="speical_iv_glucose[speical-iv-glucose'+idheader+']" type="text"></td>';
      fluidGlucose += '<td class="unit-sub-elements"><span>mg/kg/min</span></td>';
      fluidGlucose += '</tr></tbody></table>';  

      var fluidRate  = '<table><tbody><tr>';
      fluidRate += '<td><input class="form-control  calculate-glucose" data-fluids="'+id+'" id="speical_iv_infusion_rate_'+id+'" name="speical_iv_infusion_rate[speical-iv-infusion-rate'+idheader+']" type="text"></td>';
      fluidRate += '<td class="unit-sub-elements"><span>ml/h</span></td>';
      fluidRate += '</tr></tbody></table>';                

      var speical  = '<td></td>';        
      speical += '<td><input class="form-control input-width-sub-mini" data-fluids="'+id+'" name="speical_iv_day[speical-iv-day'+idheader+']" type="text"></td>';
      speical += '<td>'+speicalIvfluids1+'</td>';   
      speical += '<td>'+fluidsVolumeOne+'</td>';  
      speical += '<td>'+speicalIvfluids2+'</td>';  
      speical += '<td>'+fluidsVolumeTwo+'</td>';  
      speical += '<td>'+fluidSyringe+'</td>';    
      speical += '<td><input class="form-control"  readonly="true" data-fluids="'+id+'"  id="speical_iv_dextrose_'+id+'" name="speical_iv_dextrose[speical-iv-dextrose'+idheader+']" type="text"></td>';    
      speical += '<td>'+fluidGlucose+'</td>';    
      speical += '<td>'+fluidRate+'</td>';    
      speical += '<td><input data-fluids="'+id+'" class="form-control" id="speical_iv_instruction_'+id+'" name="speical_iv_instruction[speical-iv-instruction'+idheader+']" type="text"></td>';    

      speical += '<td><input class="form-control date-prescribed" id="speical_iv-date-prescribed-'+id+'" name="speical_iv_date_prescribed[speical-iv-date-prescribed'+idheader+']" type="text"></td>';
      speical += '<td><input class="form-control time-prescribed" id="speical_iv-time-prescribed-'+id+'" name="speical_iv_time_prescribed[speical-iv-time-prescribed'+idheader+']" type="text"></td>';
      speical += '<td><input class="form-control date-prescribed" id="speical_iv-date-stopped-'+id+'" name="speical_iv_date_stopped[speical-iv-date-stopped'+idheader+']" type="text"></td>';
      speical += '<td><input class="form-control time-prescribed" id="speical_iv-time-stopped-'+id+'" name="speical_iv_time_stopped[speical-iv-time-stopped'+idheader+']" type="text"></td>';


      speical += '<td><a href="javascript:void(0);" class="btn remove"><i class="fa fa-close"></i></a></td>'; 

      var specialHidden = '<td class="hide"><input type="hidden" value="0" name="speical_iv_id[]"></td>';   

      var speicalData = '<tr>'+specialHidden+speical+'</tr>';

      $('.special-body-'+speicalFluidid).last().after(speicalData);

      initiateSelecttwo('#speical_name_one_'+id);
      initiateSelecttwo('#speical_name_two_'+id);


      $('#speical_iv-time-prescribed-'+id).timeDropper();
      $('#speical_iv-time-stopped-'+id).timeDropper({
        setCurrentTime:false
      });

      dateDropperSettings('speical_iv-date-prescribed-'+id);
      dateDropperSettings('speical_iv-date-stopped-'+id);

    });
    //edit view end


    $('.add-other-iv-infusions').click(function() {

      var otherIvInfusionLength = $('table.other-iv-infusions tbody tr').length;
      otherIvInfusionLength = (isNaN(otherIvInfusionLength) == true) ? 0 : otherIvInfusionLength;

      var id = parseInt($('.other-infusions-brandname').last().data('other-infusions-brandname'))+1;
      id = (isNaN(id) == true ) ? 0 : id;

      var otherIvinfusionId = otherIvInfusionLength+'-'+id;    

      var otherIvinfusion   = $('select[name="infusion_gen_temp"]').html();    

      var volumeInfused  = '<table class="table-align-center"><tbody><tr>';
      volumeInfused += '<td><input class="form-control input-width-small" name="other_infusions_volume[]" data-duration-calculate="'+otherIvinfusionId+'" id="other_infusions_volume-'+otherIvinfusionId+'"  type="text"></td>';
      volumeInfused += '<td class="unit-sub-elements"><span>ml</span></td>';
      volumeInfused += '</tr></tbody></table>';     

      var infusionDuration  = '<table class="table-align-center"><tbody><tr>';       
      infusionDuration += '<td><input class="form-control input-width-small" name="other_infusions_duration[]" data-duration-calculate="'+otherIvinfusionId+'" id="other_infusions_duration-'+otherIvinfusionId+'" type="text"></td>'
      infusionDuration += '<td><select class="form-control other-infusions-durametnod input-width-mini" name="other_infusions_durametnod[]" data-duration-calculate="'+otherIvinfusionId+'" id="other_infusions_durametnod-'+otherIvinfusionId+'"><option value="min">min</option><option value="hr">hr</option></select></td>';
      infusionDuration += '</tr></tbody></table>'; 

      var volumeRate  = '<table class="table-align-center"><tbody><tr>';
      volumeRate += '<td><input class="input-width-sub-mini-1 form-control" name="other_infusions_rate[]" data-duration-calculate="'+otherIvinfusionId+'" id="other_infusions_rate-'+otherIvinfusionId+'" type="text"></td>';
      volumeRate += '<td class="unit-sub-elements"><span>ml/hr</span></td>';
      volumeRate += '</tr></tbody></table>';         

      var otherInfusions  = '<td></td><td class="text-center"><input class="form-control input-width-sub-mini box-center" name="other_infusions_day[]" data-duration-calculate="'+otherIvinfusionId+'" id="other_infusions_day-'+otherIvinfusionId+'" type="text"></td>';
      otherInfusions += '<td><select data-other-infusions-pharmacological="'+id+'" class="other-infusions-pharmacological input-width-large" data-duration-calculate="'+otherIvinfusionId+'" id="other_infusions_pharmacological-'+otherIvinfusionId+'" name="other_infusions_pharmacological[]">'+otherIvinfusion+'</select></td>';
      otherInfusions += '<td>'+volumeInfused+'</td>';
      otherInfusions += '<td>'+infusionDuration+'</td>';
      otherInfusions += '<td>'+volumeRate+'</td>';
      otherInfusions += '<td><input class="form-control" name="other_infusions_instruction[]" id="other_infusions_instruction-'+otherIvinfusionId+'" data-duration-calculate="'+otherIvinfusionId+'" type="text"></td>';

      otherInfusions += '<td> <input class="form-control infusion-ivg-status" id="other-infusions-pump-type-'+otherIvinfusionId+'" data-duration-calculate="'+otherIvinfusionId+'" name="other_infusions_pump_type" type="checkbox" value="IVG"></td>';

      otherInfusions += '<td colspan="4"><a href="javascript:void(0);" class="btn remove-prescription"><i class="fa fa-close"></i></a> ';
      otherInfusions += '<a href="javascript:void(0);" class="btn other-iv-infusion-changes" id="tick-'+otherIvinfusionId+'" data-other-infusion-id="'+otherIvinfusionId+'" data-duration-calculate="'+otherIvinfusionId+'"><i class="fa fa-check"></i></a></td>';

      var otherInfusionsHidden = '<td class="hide"><input type ="hidden" value="0" name="other_infusions_id[]" data-duration-calculate="'+otherIvinfusionId+'"></td>';

      var otherInfusionsData = '<tr class="other-iv-infusion-ls-'+otherIvinfusionId+'">'+otherInfusionsHidden+otherInfusions+'</tr>';
      $($(this).parent().parent()).before(otherInfusionsData);

      initiateSelecttwo('#other_infusions_pharmacological-'+otherIvinfusionId);

    });

    //edit view start

    $('.add-other-iv-edit-infusions').click(function() {

     var id = parseInt($('.other-infusions-brandname').last().data('other-infusions-brandname'))+1;
     id = (isNaN(id) == true ) ? 0 : id;

     var timeSlot = $(this).data('other-iv-infusion-header');   
     var pharam   =  $('select[name="infusion_gen_temp"]').html(); 

     var idheader ='_'+id+'_'+timeSlot;

     var volumeInfused  = '<table><tbody><tr>';
     volumeInfused += '<td><input class="form-control input-width-large" name="other_infusions_volume[other-infusions-volume'+idheader+']" type="text"></td>';
     volumeInfused += '<td class="unit-sub-elements"><span>ml</span></td>';
     volumeInfused += '</tr></tbody></table>';     

     var infusionDuration  = '<table><tbody><tr>';       
     infusionDuration += '<td><input class="form-control input-width-xxmedium" name="other_infusions_duration[other-infusions-duration'+idheader+']" type="text"></td>'
     infusionDuration += '<td><select class="form-control other-infusions-durametnod input-width-mini" name="other_infusions_durametnod[other-infusions-durametnod'+idheader+']"><option value="min">min</option><option value="hr">hr</option></select></td>';
     infusionDuration += '</tr></tbody></table>'; 

     var volumeRate  = '<table><tbody><tr>';
     volumeRate += '<td><input class="input-width-sub-mini-1 form-control" name="other_infusions_rate[other-infusions-rate'+idheader+']" type="text"></td>';
     volumeRate += '<td class="unit-sub-elements"><span>ml/hr</span></td>';
     volumeRate += '</tr></tbody></table>';         

     var otherInfusions  = '<td></td>'; 
     otherInfusions += '<td><input class="form-control input-width-sub-mini" name="other_infusions_day[other-infusions-day'+idheader+']" type="text"></td>';
     otherInfusions += '<td><select data-other-infusions-brandname="'+id+'" class="other-infusions-brandname  form-control input-width-large" id="other_infusions_brandname_'+id+'" name="other_infusions_pharmacological[other-infusions-pharmacological'+idheader+']">'+pharam+'</select></td>';
     otherInfusions += '<td>'+volumeInfused+'</td>';
     otherInfusions += '<td>'+infusionDuration+'</td>';
     otherInfusions += '<td>'+volumeRate+'</td>';
     otherInfusions += '<td><input class="form-control" name="other_infusions_instruction[other-infusions-instruction'+idheader+']" type="text"></td>';

     otherInfusions += '<td> <input class="form-control date-prescribed" id="other-infusions-date-prescribed-'+id+'" name="other_infusions_date_prescribed[other-infusions-date-prescribed'+idheader+']" type="text"></td>';
     otherInfusions += '<td> <input class="form-control time-prescribed" id="other-infusions-time-prescribed-'+id+'" name="other_infusions_time_prescribed[other-infusions-time-prescribed'+idheader+']" type="text"></td>';
     otherInfusions += '<td> <input class="form-control date-prescribed" id="other-infusions-date-stopped-'+id+'" name="other_infusions_date_stopped[other-infusions-date-stopped'+idheader+']" type="text"></td>';
     otherInfusions += '<td> <input class="form-control time-prescribed" id="other-infusions-time-stopped-'+id+'" name="other_infusions_time_stopped[other-infusions-time-stopped'+idheader+']" type="text"></td>';

     otherInfusions += '<td><a href="javascript:void(0);" class="btn remove"><i class="fa fa-close"></i></a></td>';
     var otherInfusionsHidden = '<td class="hide"><input type ="hidden" value="0" name="other_infusions_id[]"></td>';

     var otherInfusionsData = '<tr>'+otherInfusionsHidden+otherInfusions+'</tr>';

     $('.other-infusions-edit'+timeSlot).last().after(otherInfusionsData);

     $('#other-infusions-time-prescribed-'+id).timeDropper();
     $('#other-infusions-time-stopped-'+id).timeDropper({
      setCurrentTime:false
    });

     dateDropperSettings('other-infusions-date-prescribed-'+id);
     dateDropperSettings('other-infusions-date-stopped-'+id);


   });
     //edit view end

     $('.add-other-iv-drugs-nurse').click(function() {

      var syringeSize           = $('select[name="temp_syringe"]').html();
      var id = parseInt($('.other-iv-drugs-brandname').last().data('other-iv-drugs-brandname'))+1;
      id = (isNaN(id) == true ) ? 0 : id;

      var otherIvDrugsLength = $('table.other-iv-drugs tbody tr').length;
      otherIvDrugsLength = (isNaN(otherIvDrugsLength) == true) ? 0 : otherIvDrugsLength;
      var otherIvDrugId      = otherIvDrugsLength+'-'+id;

      var otherIvdrugname    = $('select[name="infusion_temp"]').html();    
      var otherIvdrugGenname = $('select[name="infusion_gen_temp"]').html(); 
      var otherFrequency     = $('select[name="temp_frequency"]').html(); 
      var requiredDoes       = $('select[name="infusion_dose_units_temp_g"]').html();

      var doesDrugs  = '<select class="form-control other_iv_drugs_dose-units-g input-width-mini"  name="other_iv_drugs_dose_units_g[]" id="other-iv-drugs-dose-units-'+otherIvDrugId+'">';
      doesDrugs += requiredDoes;
      doesDrugs += '</select>';

      var doesRequired  ='<table class="table-align-center">';
      doesRequired +='<tbody>';
      doesRequired += '<tr>';
      doesRequired += '<td>';
      doesRequired += '<input class="form-control input-width-sub-mini-1" name="other_iv_drugs_dose_required[]" id="other_iv_drugs_dose_required-'+otherIvDrugId+'" type="text">';
      doesRequired += '</td>';
      doesRequired += '<td>';
      doesRequired += doesDrugs;
      doesRequired += '</td>';
      doesRequired += '</tr>';
      doesRequired += '</tbody>';
      doesRequired += '</table>';


      var otherIvdrugs  = '<td></td><td class="text-center"> <input class="form-control input-width-sub-mini box-center" name="other_iv_drugs_day[]" id="other_iv_drugs_day-'+otherIvDrugId+'" type="text"></td>';
      otherIvdrugs += '<td> <select data-other-iv-drugs-brandname="'+otherIvDrugId+'"  class="other-iv-drugs-brandname input-width-medium" id="other-iv-drugs-brandname-'+otherIvDrugId+'" name="other_iv_drugs_brandname[]">'+otherIvdrugname+'</select></td>';    
      otherIvdrugs += '<td> <select data-other-iv-drugs-pharmacological="'+otherIvDrugId+'"  class="other-iv-drugs-pharmacological input-width-medium" name="other_iv_drugs_pharmacological[]" id="other-iv-drugs-pharmacological-'+otherIvDrugId+'">'+otherIvdrugGenname+'</select></td>';    
      otherIvdrugs += '<td>'+doesRequired+'</td>';
      otherIvdrugs += '<td> <select class="input-width-medium" id="other-iv-drugs-frequency-'+otherIvDrugId+'" name="other_iv_drugs_frequency[]">'+otherFrequency+'</select></td>';    
            // otherIvdrugs += '<td> <table><tbody><tr><td><select class="form-control infusion-syringe" name="other_iv_drugs_syringe[]" id="other_iv_drugs_syringe-'+otherIvDrugId+'" type="text">'+syringeSize+'</select></td><td class="unit-sub-elements"><span>ml</span></td></tr></tbody></table>';
            otherIvdrugs += '<td> <table class="table-align-center"><tbody><tr><td><input class="form-control input-width-sub-mini-1"" name="other_iv_drugs_syringe[]" id="other_iv_drugs_syringe-'+otherIvDrugId+'" type="text"></td><td class="unit-sub-elements padding-nonepa"><span>ml</span></td></tr></tbody></table>';
            otherIvdrugs += '<td> <table class="table-align-center"><tbody><tr><td><input class="form-control input-width-sub-mini-1" id ="other_iv_drugs_rate-'+otherIvDrugId+'" name="other_iv_drugs_rate[]" type="text"></td><td class="unit-sub-elements"><span>ml/hr</span></td></tr></tbody></table></td>';    
            otherIvdrugs += '<td> <input class="form-control other_iv_drugs_additional" name="other_iv_drugs_additional[]" id="other_iv_drugs_additional-'+otherIvDrugId+'" type="text"></td>';    
            otherIvdrugs += '<td> <input class="form-control infusion-ivg-status" id="other-iv-pump-type-'+otherIvDrugId+'" name="other_iv_pump_type[]" type="checkbox" value="IVG"></td>'; 

            otherIvdrugs += '<td colspan="4"><a href="javascript:void(0);" class="btn remove-prescription"><i class="fa fa-close"></i></a> ';
            otherIvdrugs += '<a href="javascript:void(0);" id="tick-'+otherIvDrugId+'" class="btn other-iv-drugs-changes" data-infusion-id="'+otherIvDrugId+'"><i class="fa fa-check"></i></a></td>';
            var otherIvdrugHidden = '<td class="hide"><input name="other_iv_drugs_id[]" value="'+otherIvDrugId+'" type="hidden"></td>';
            var otherIvdrugsTags  = '<tr class="other-iv-drugs-ls-'+otherIvDrugId+'" >'+otherIvdrugHidden+otherIvdrugs+'</tr>'; 

            $($(this).parent().parent()).before(otherIvdrugsTags);

            initiateSelecttwo('#other-iv-drugs-brandname-'+otherIvDrugId);
            initiateSelecttwo('#other-iv-drugs-pharmacological-'+otherIvDrugId);
            initiateSelecttwo('#other-iv-drugs-frequency-'+otherIvDrugId);


          });

    //edit view start

    $('.add-other-view-list').click(function() {


      var id = parseInt($('.other-iv-drugs-brandname').last().data('other-iv-drugs-brandname'))+1;
      id = (isNaN(id) == true ) ? 0 : id;
      var timeSlot = $(this).data('other-iv-drugs-header');    
      var idheader ='_'+id+'_'+timeSlot;

      var otherIvdrugname = $('select[name="infusion_temp"]').html();    
      var otherIvdrugGenname = $('select[name="infusion_gen_temp"]').html(); 
      var otherFrequency = $('select[name="temp_frequency"]').html();   

      var otherIvdrugs  = '<td></td>';
      otherIvdrugs += '<td> <input class="form-control input-width-sub-mini" name="other_iv_drugs_day[other-iv-drugs-day'+idheader+']" type="text"></td>';
      otherIvdrugs += '<td> <select data-other-iv-drugs-brandname="'+id+'" class="other-iv-drugs-brandname input-width-xlarge-minis" id="other-iv-drugs-brandname-'+id+'" name="other_iv_drugs_brandname[other-iv-drugs-brandname'+idheader+']">'+otherIvdrugname+'</select></td>';    
      otherIvdrugs += '<td> <select data-other-iv-drugs-pharmacological="'+id+'" class="other-iv-drugs-pharmacological input-width-xlarge-minis" name="other_iv_drugs_pharmacological[other-iv-drugs-pharmacological'+idheader+']" id="other-iv-drugs-pharmacological-'+id+'">'+otherIvdrugGenname+'</select></td>';    
      otherIvdrugs += '<td> <input class="form-control" name="other_iv_drugs_dose_required[other-iv-drugs-dose-required'+idheader+']" type="text"></td>';    
      otherIvdrugs += '<td> <select class="input-width-medium" id="other-iv-drugs-frequency-'+id+'" name="other_iv_drugs_frequency[other-iv-drugs-frequency'+idheader+']">'+otherFrequency+'</select></td>';    
      otherIvdrugs += '<td> <input class="form-control" name="other_iv_drugs_syringe[other-iv-drugs-volume-syringe'+idheader+']" type="text"></td>';    
      otherIvdrugs += '<td> <input class="form-control" name="other_iv_drugs_rate[other-iv-drugs-volume-rate'+idheader+']" type="text"></td>';    
      otherIvdrugs += '<td> <input class="form-control" name="other_iv_drugs_additional[other-iv-drugs-additional'+idheader+']" type="text"></td>';    

      otherIvdrugs += '<td> <input class="form-control date-prescribed" id="other-iv-drugs-date-prescribed-'+id+'" name="other_iv_drugs_date_prescribed[other-iv-drugs-date-prescribed'+idheader+']"></td>';
      otherIvdrugs += '<td> <input class="form-control time-prescribed" id="other-iv-drugs-time-prescribed-'+id+'" name="other_iv_drugs_time_prescribed[other-iv-drugs-time-prescribed'+idheader+']"></td>';         
      otherIvdrugs += '<td> <input class="form-control date-prescribed" id="other-iv-drugs-date-stopped-'+id+'" name="other_iv_drugs_date_stopped[other-iv-drugs-date-stopped'+idheader+']"></td>';
      otherIvdrugs += '<td> <input class="form-control time-prescribed" id="other-iv-drugs-time-stopped-'+id+'" name="other_iv_drugs_time_stopped[other-iv-drugs-time-stopped'+idheader+']"></td>';

      otherIvdrugs += '<td> <a href="javascript:void(0);" class="btn remove"><i class="fa fa-close"></i></a> </td>';
      var otherIvdrugHidden = '<td class="hide"><input name="other_iv_drugs_id[]" value="0" type="hidden"></td>';


      var otherIvdrugsTags = '<tr>'+otherIvdrugHidden+otherIvdrugs+'</tr>';    

      $('.other-iv-drug-body'+timeSlot).last().after(otherIvdrugsTags);

      initiateSelecttwo('#other-iv-drugs-brandname-'+id);
      initiateSelecttwo('#other-iv-drugs-pharmacological-'+id);
      initiateSelecttwo('#other-iv-drugs-frequency-'+id);

      $('#other-iv-drugs-time-prescribed-'+id).timeDropper();
      $('#other-iv-drugs-time-stopped-'+id).timeDropper({
        setCurrentTime:false
      });

      dateDropperSettings('other-iv-drugs-date-prescribed-'+id);
      dateDropperSettings('other-iv-drugs-date-stopped-'+id);



    });
    //edit view end 

    $('.add-oral-rectal').click(function() {

      var id = parseInt($('.oral-brand-name').last().data('oral-brand-name'))+1;
      id = (isNaN(id) == true ) ? 0 : id;

      var oralRectalLength = $('table.oral-rectal-drugs tbody tr').length;
      oralRectalLength = (isNaN(oralRectalLength) == true) ? 0 : oralRectalLength;    
      var oralRectalId     = oralRectalLength+'-'+id;    


      var oralRectalname    = $('select[name="oral_temp"]').html();    
      var oralRectalGenname = $('select[name="oral_gen_temp"]').html();    
      var oralFrequency     = $('select[name="temp_frequency"]').html();
      var oralRoute         = $('select[name="temp_oral_route"]').html();  

      var oralRectal  = '<td></td><td><input class="form-control input-width-sub-mini box-center" name="oral_days[]" id="oral_days-'+oralRectalId+'" type="text"></td>';
      oralRectal += '<td><select data-oral-brand-name="'+oralRectalId+'" class="oral-brand-name input-width-large" id="oral_brandname-'+oralRectalId+'" name="oral_brandname[]">'+oralRectalname+'</select></td>';
      oralRectal += '<td><select class="oral-pharmacological-name input-width-large" data-oral-pharmacological-name="'+oralRectalId+'" name="oral_pharmacological[]" id="oral_pharmacological-'+oralRectalId+'">'+oralRectalGenname+'</select></td>';
      oralRectal += '<td><input class="form-control" name="oral_dose_required[]" id="oral_dose_required-'+oralRectalId+'" type="text"></td>';
      oralRectal += '<td><select class="oral-frequency input-width-medium"  name="oral_frequency[]" id="oral_frequency-'+oralRectalId+'">'+oralFrequency+'</select></td>';
      oralRectal += '<td><select class="form-control width-99-must" name="oral_route[]" id="oral_route-'+oralRectalId+'">'+oralRoute+'</select></td>';

      oralRectal += '<td><input class="form-control" name="oral_additional[]" id="oral_additional-'+oralRectalId+'" type="text"></td>';
      oralRectal += '<td colspan="4"><a href="javascript:void(0);" class="btn remove-prescription"><i class="fa fa-close"></i></a> ';
      oralRectal += '<a href="javascript:void(0);" data-oral-id="'+oralRectalId+'" class="btn oral-rectal-changes"><i class="fa fa-check"></i></a></td>';
      oralRectalHidden = '<td class="hide"> <input type="hidden" value="0" name="oral_id[]"> </td>';

      var oralRectaltags = '<tr class="oral-rectal-ls-'+oralRectalId+'">'+oralRectalHidden+oralRectal+'</tr>';   

      $($(this).parent().parent()).before(oralRectaltags);


      initiateSelecttwo('#oral_brandname-'+oralRectalId);
      initiateSelecttwo('#oral_pharmacological-'+oralRectalId);
      initiateSelecttwo('#oral_frequency-'+oralRectalId);

    });

     //edit view start
     $('.oral-drugs-list').click(function() {

      var id = parseInt($('.oral-brand-name').last().data('oral-brand-name'))+1;
      id = (isNaN(id) == true ) ? 0 : id;
      var timeSlot = $(this).data('oral-header');  

      var idheader ='_'+id+'_'+timeSlot; 

      var oralRectalname = $('select[name="infusion_temp"]').html();    
      var oralRectalGenname = $('select[name="infusion_gen_temp"]').html();    
      var oralFrequency = $('select[name="temp_frequency"]').html();
      var oralRoute         = $('select[name="temp_oral_route"]').html();  

      var oralRectal  = '<td></td>';
      oralRectal += '<td><input class="form-control input-width-sub-mini" name="oral_days[oral-days'+idheader+']" type="text"></td>';
      oralRectal += '<td><select data-oral-brand-name="'+id+'" class="oral-brand-name input-width-large" id="oral-brand-name-'+id+'" name="oral_brandname[oral-brandname'+idheader+']">'+oralRectalname+'</select></td>';
      oralRectal += '<td><select class="oral-pharmacological-name input-width-large" data-oral-pharmacological-name="'+id+'" name="oral_pharmacological[oral-pharmacological'+idheader+']" id="oral-pharmacological-name-'+id+'">'+oralRectalGenname+'</select></td>';
      oralRectal += '<td><input class="form-control" name="oral_dose_required[oral-dose-required'+idheader+']" type="text"></td>';
      oralRectal += '<td><select class="oral-frequency input-width-medium"  name="oral_frequency[oral-frequency'+idheader+']" id="oral-frequency-'+id+'">'+oralFrequency+'</select></td>';
      oralRectal += '<td><select class="form-control" name="oral_route[oral-route'+idheader+']">'+oralRoute+'</select></td>';
      oralRectal += '<td><input class="form-control" name="oral_additional[oral-additional'+idheader+']" type="text"></td>';

      oralRectal += '<td><input class="form-control date-prescribed" id="oral-date-prescribed-'+id+'" name="oral_date_prescribed[oral-date-prescribed'+idheader+']" type="text"></td>';
      oralRectal += '<td><input class="form-control time-prescribed" id="oral-time-prescribed-'+id+'" name="oral_time_prescribed[oral-time-prescribed'+idheader+']" type="text"></td>';
      oralRectal += '<td><input class="form-control date-prescribed" id="oral-date-stopped-'+id+'" name="oral_date_stopped[oral-date-stopped'+idheader+']" type="text"></td>';
      oralRectal += '<td><input class="form-control time-prescribed" id="oral-time-stopped-'+id+'" name="oral_time_stopped[oral-time-stopped'+idheader+']" type="text"></td>';

      oralRectal += '<td><a href="javascript:void(0);" class="btn remove"><i class="fa fa-close"></i></a></td>';
      oralRectalHidden = '<td class="hide"> <input type="hidden" value="0" name="oral_id[]"> </td>';


      var oralRectaltags = '<tr>'+oralRectalHidden+oralRectal+'</tr>';   

      $('.oral-edit-body'+timeSlot).last().after(oralRectaltags);

      initiateSelecttwo('#oral-brand-name-'+id);
      initiateSelecttwo('#oral-pharmacological-name-'+id);
      initiateSelecttwo('#oral-frequency-'+id);


      $('#oral-time-prescribed-'+id).timeDropper();
      $('#oral-time-stopped-'+id).timeDropper({
        setCurrentTime:false
      });

      dateDropperSettings('oral-date-prescribed-'+id);
      dateDropperSettings('oral-date-stopped-'+id);

    });
     //edit view end




     $(".antibiotic_drug_add").click(function() {

       var id = $('.sepsis-antibiotic').last().data('antibiotic')+1;
       id = (isNaN(id) == true ) ? 0 : id;

       antibiotic_select  ='<select name="A_Antibiotic[]" class="sepsis-antibiotic input-width-xlarge" id="antiboitic'+id+'" data-antibiotic="'+id+'">';
       antibiotic_select += $("select[name='a_antibiotic_temp']").html();
       antibiotic_select +='</select>';
       option =  '<tr><td>'+antibiotic_select+'</td>'; 
       option += '<td><input type="number" class="form-control" name="A_Day[]" value="" /></td>';
       option += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>';
       option += '</tr>';
       $("table.antibiotic tbody").append(option);
       initiateSelecttwo('#antiboitic'+id);

     });

     $(".nurse_drugs_add").click(function() {

      var drugs  = $('select[name="temp_drugs"]').html();
      var id = parseInt($('.other_drugs').last().data('other-drug'))+1;
      id = (isNaN(id) == true ) ? 0 : id;
      var option = '<tr><td class="full-width"><select class="full-width other_drugs" id="other_drugs_'+id+'" data-other-drug="'+id+'" name="drugs[]">'+drugs+'</select></td>';
      option += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>';
      option += '</tr>';
      $("table.sep_drugs tbody").append(option);
      initiateSelecttwo('#other_drugs_'+id);

    });

//iv infusion start
$('.infusion_brandname, .infusion_pharmacological').change(function() {
  var id = $(this).attr('id');
  var fluidName = $('#'+id+' option:selected').text();

  if ($(this).hasClass('infusion_brandname')) {

    $('#infusion-pharmacological-'+$(this).data('drug')).select2('val', $(this).val());
        //changeDose($(this).data('drug'), fluidName);

      } else {

        $('#infusion-brandname-'+$(this).data('drug')).select2('val', $(this).val());
        //changeDose($(this).data('drug'), fluidName);

      }

    });


function changeDose(drugId, fluidName) {

  switch (fluidName) {
    case 'Sildenafil':
    $('#infusion-dose-units-g-'+drugId).val('2');
    $('#infusion-dose-units-kg-'+drugId).val('1');
    $('#infusion-dose-units-time-'+drugId).val('3');
    break;

    case 'Dopamine':
    $('#infusion-dose-units-g-'+drugId).val('3');
    $('#infusion-dose-units-kg-'+drugId).val('1');
    $('#infusion-dose-units-time-'+drugId).val('1');
    break;

    case 'Dobutamine':
    $('#infusion-dose-units-g-'+drugId).val('3');
    $('#infusion-dose-units-kg-'+drugId).val('1');
    $('#infusion-dose-units-time-'+drugId).val('1');
    break;

    case 'Adrenaline':
    $('#infusion-dose-units-g-'+drugId).val('4');
    $('#infusion-dose-units-kg-'+drugId).val('1');
    $('#infusion-dose-units-time-'+drugId).val('1');
    break;

    case 'Noradrenaline':
    $('#infusion-dose-units-g-'+drugId).val('4');
    $('#infusion-dose-units-kg-'+drugId).val('1');
    $('#infusion-dose-units-time-'+drugId).val('1');
    break;

    case 'Prostaglandin E2':
    $('#infusion-dose-units-g-'+drugId).val('4');
    $('#infusion-dose-units-kg-'+drugId).val('1');
    $('#infusion-dose-units-time-'+drugId).val('1');
    break;

    case 'Morphine':
    $('#infusion-dose-units-g-'+drugId).val('3');
    $('#infusion-dose-units-kg-'+drugId).val('1');
    $('#infusion-dose-units-time-'+drugId).val('2');
    break;

    case 'vecuronium':
    $('#infusion-dose-units-g-'+drugId).val('3');
    $('#infusion-dose-units-kg-'+drugId).val('1');
    $('#infusion-dose-units-time-'+drugId).val('2');
    break;

    case 'Vancomycin':
    $('#infusion-dose-units-g-'+drugId).val('2');
    $('#infusion-dose-units-kg-'+drugId).val('1');
    $('#infusion-dose-units-time-'+drugId).val('3');
    break;

    case 'midazolam':
    $('#infusion-dose-units-g-'+drugId).val('2');
    $('#infusion-dose-units-kg-'+drugId).val('1');
    $('#infusion-dose-units-time-'+drugId).val('3');
    break;

    case 'Aminoven / Aminoplan':
    $('#infusion-dose-units-g-'+drugId).val('1');
    $('#infusion-dose-units-kg-'+drugId).val('1');
    $('#infusion-dose-units-time-'+drugId).val('3');
    break;

    case 'LIPIDS':
    $('#infusion-dose-units-g-'+drugId).val('1');
    $('#infusion-dose-units-kg-'+drugId).val('1');
    $('#infusion-dose-units-time-'+drugId).val('3');
    break;




    default:

    break;
  }


}


$(document).on('change', '.infusion_brandname, .infusion_pharmacological', function() {


  var id = $(this).attr('id');
  var fluidName = $('#'+id+' option:selected').text();

  if ($(this).hasClass('infusion_brandname')) {
    $('#infusion-pharmacological-'+$(this).data('drug')).select2('val', $(this).val());
        //changeDose($(this).data('drug'), fluidName);
      } else {
        $('#infusion-brandname-'+$(this).data('drug')).select2('val', $(this).val());
        //changeDose($(this).data('drug'), fluidName);
      }


    });

//iv infusion end


//iv drugs start

$('.ivdrug_brandname, .ivdrug_genericname').change(function() {


  if($(this).hasClass('ivdrug_brandname')) {

   $('#ivdrug_genericname_'+$(this).data('ivdrug-brandname')).select2('val', $(this).val());

 } else {
  $('#ivdrug_brandname_'+$(this).data('ivdrug-genericname')).select2('val', $(this).val());

}

});

$(document).on('change', '.ivdrug_brandname, .ivdrug_genericname',function() {

  if($(this).hasClass('ivdrug_brandname')) {

   $('#ivdrug_genericname_'+$(this).data('ivdrug-brandname')).select2('val', $(this).val());

 } else {
  $('#ivdrug_brandname_'+$(this).data('ivdrug-genericname')).select2('val', $(this).val());

}

});

//iv drugs stop

$('.other-iv-drugs-brandname, .other-iv-drugs-pharmacological').change(function() {

  if($(this).hasClass('other-iv-drugs-brandname')) {

   $('#other-iv-drugs-pharmacological-'+$(this).data('other-iv-drugs-brandname')).select2('val', $(this).val());

 } else {
  $('#other-iv-drugs-brandname-'+$(this).data('other-iv-drugs-pharmacological')).select2('val', $(this).val());

}

});

$(document).on('change', '.other-iv-drugs-brandname, .other-iv-drugs-pharmacological',function() {

  if($(this).hasClass('other-iv-drugs-brandname')) {

   $('#other-iv-drugs-pharmacological-'+$(this).data('other-iv-drugs-brandname')).select2('val', $(this).val());

 } else {
  $('#other-iv-drugs-brandname-'+$(this).data('other-iv-drugs-pharmacological')).select2('val', $(this).val());

}

});




//oral rectal start

$(document).on('change', '.oral-brand-name, .oral-pharmacological-name',function() {


  if($(this).hasClass('oral-brand-name')) {

   $('#oral_pharmacological-'+$(this).data('oral-brand-name')).select2('val', $(this).val());

 } else {

  $('#oral_brandname-'+$(this).data('oral-pharmacological-name')).select2('val', $(this).val());

}

});

$('.oral-brand-name, .oral-pharmacological-name').change(function() {

  if($(this).hasClass('oral-brand-name')) {

   $('#oral-pharmacological-name-'+$(this).data('oral-brand-name')).select2('val', $(this).val());

 } else {

  $('#oral-brand-name-'+$(this).data('oral-pharmacological-name')).select2('val', $(this).val());

}

});
//oral rectal end



$(document).on('change','input[name^="drug_rate"]', function() {

 var drugRate = $(this).val();
 var solution_id = $(this).data('solution').toString();
     solution_id = solution_id.replace(/[a-zA-Z]/g, '');
 var drugId   = $('#drug-solution-'+solution_id).val();
 var drugName = $('#drug-solution-'+solution_id).attr('name');
 var targetId = '#drug-rate-'+solution_id;

 if (drugId == '') {
   Showalert('warning','Please select fluids !');
 } else {
   getrunning_total(drugRate, drugId, drugName, targetId);
 }

});



$(document).on('change', 'input[name="replacement_fluids_rate[]"]', function() {

 var drugRate = $(this).val();
 var drugId   = $('#replacement-fluids-solution-'+$(this).data('solution')).val();
 var drugName = $('#replacement-fluids-solution-'+$(this).data('solution')).attr('name');
 var targetId = '#replacement_fluids_total'+$(this).data('solution');
 if (drugId == '') {

   Showalert('warning','Please select fluids !');

 } else {

   getrunning_total(drugRate, drugId, drugName, targetId);
 }

});

$('input[name="gastric_aspirate_volume"]').change(function() {

 var drugRate = $(this).val();
 var drugName = $(this).attr('name');
 var targetId = '#gastric_aspirate_volume_total';
 var drugId   = '';

 getrunning_total(drugRate, drugId, drugName, targetId);

});

$(document).on('change', '#bowels', function() {

 var drugRate = ($(this).prop('checked') == true) ? 1 : 0 ;
 var drugName = $(this).attr('name');
 var targetId = '#stools_frequency';
 var drugId   = '';
 getrunning_total(drugRate, drugId, drugName, targetId);

});

$('input[name="urine_output"]').change(function() {

 var urineOutput = $(this).val();
 var drugName = $(this).attr('name');
 var targetId = '#urine_output_total';
 var drugId   = '';

 getrunning_total(urineOutput, drugId, drugName, targetId);
 getspoturine(urineOutput);

});


$('input[name="blood_volume_out"]').change(function() {

 var drugRate = $(this).val();
 var drugName = $(this).attr('name');
 var targetId = '#blood_volume_out_total';
 var drugId   = '';

 getrunning_total(drugRate, drugId, drugName, targetId);

});

$('input[name="stoma_output_hour"]').change(function() {

 var drugRate = $(this).val();
 var drugName = $(this).attr('name');
 var targetId = '#stoma_output_hour_total';
 var drugId   = '';

 getrunning_total(drugRate, drugId, drugName, targetId);

});




$('input[name="drain_output_r"]').change(function() {

 var drugRate = $(this).val();
 var drugName = $(this).attr('name');
 var targetId = '#drain_output_r_total';
 var drugId   = '';

 getrunning_total(drugRate, drugId, drugName, targetId);

});

$('input[name="drain_output_l"]').change(function() {

 var drugRate = $(this).val();
 var drugName = $(this).attr('name');
 var targetId = '#drain_output_l_total';
 var drugId   = '';

 getrunning_total(drugRate, drugId, drugName, targetId);

});

$('input[name="bowels_count"]').change(function() {

 var drugRate = $(this).val();
 var drugName = $(this).attr('name');
 var targetId = '#bowels_count_total';
 var drugId   = '';

 getrunning_total(drugRate, drugId, drugName, targetId);

});



$('input[name="milk_volume"]').change(function() {

 var drugRate = $(this).val();
 var drugName = $(this).attr('name');
 var targetId = '#milk_volume_total';
 var drugId   = '';

 getrunning_total(drugRate, drugId, drugName, targetId);

});


$('input[name="drug_total[]"]').change(function() {
  ivFluidsTotal();
});

$(document).on('change','input[name="drug_total[]"]', function() {
  ivFluidsTotal();
});

$('input[name="replacement_fluids_total[]"]').change(function() {
  replacementFluidstotal();
});

$('input[name="gastric_aspirate_volume_total"]').change(function() {
  $('input[name="aspirate_ml"]').val($(this).val()).trigger('change');
});

$(document).on('change', 'input[name="stoma_output_hour_total"]',function() {
  $('input[name="stoma_output"]').val($(this).val()).trigger('change');

});

$('input[name="drain_output_r_total"], input[name="drain_output_l_total"]').change(function() {
  var totalDrains = parseInt($('input[name="drain_output_r_total"]').val()) + parseInt($('input[name="drain_output_l_total"]').val());
  $('input[name="drains_ml"]').val(totalDrains).trigger('change');
});

$('input[name="urine_output_total"]').change(function() {
  var urineTotal    = $(this).val();
  var workingWeight = $('input[name="working_weight"]').val(); 
  var urineTotalKg  = ((urineTotal/workingWeight)/24);

  var urineTotaltext = urineTotal.toString();
  (urineTotaltext.indexOf('.') > 0) ? $('input[name="urine_total"]').val(urineTotal.toFixed(2)).trigger('change') : $('input[name="urine_total"]').val(urineTotal).trigger('change');

});

$('input[name="blood_volume_out_total"]').change(function() {

  $('input[name="blood_out_total_day"]').val($(this).val()).trigger('change');


});
$('input[name="blood_volume_out_total"]').change(function() {

  $('input[name="blood_out_total"]').val($(this).val()).trigger('change');

});

function ivFluidsTotal() {
  var totalIvdrugs = 0;

  $('input[name="drug_total[]"]').each(function() {
    if ($(this).val() != '') {
     var tempFluids = $(this).val();
     tempFluids = (tempFluids.indexOf('.') > 0 ) ? parseFloat(tempFluids) : parseInt(tempFluids);
     totalIvdrugs = totalIvdrugs + tempFluids;
   }
 });
  $('input[name="intravenous_fluids"]').val(totalIvdrugs).trigger('change');

}

function replacementFluidstotal() {

  var replacementTotal = 0;
  $('input[name="replacement_fluids_total[]"]').each(function() {
    replacementTotal = replacementTotal +  parseInt($(this).val());
  });
  var total = $('input[name="intravenous_fluids"]').val();

  if(total != '') {
    replacementTotal = replacementTotal +  parseInt(total);
  }

  $('input[name="intravenous_fluids"]').val(replacementTotal).trigger('change');
}

$('input[name="intravenous_fluids"], input[name="oral_fluids"], input[name="other_drugs"],input[name="working_weight"]').change(function() {
  calculateTotalfluids();
});

function calculateTotalfluids() {
  var intravenousFluids = $('input[name="intravenous_fluids"]').val();
  var oralFluids        = $('input[name="oral_fluids"]').val();
  var otherDrugs        = $('input[name="other_drugs"]').val();
  intravenousFluids = (intravenousFluids != '') ? intravenousFluids : 0;
  oralFluids        = (oralFluids != '') ? oralFluids : 0;
  otherDrugs        = (otherDrugs != '') ? otherDrugs : 0;

  intravenousFluids = (intravenousFluids.toString().indexOf('.') > 0) ? parseFloat(intravenousFluids) : parseInt(otherDrugs);    
  oralFluids        = (oralFluids.toString().indexOf('.') > 0) ? parseFloat(oralFluids) : parseInt(oralFluids);    
  otherDrugs        = (otherDrugs.toString().indexOf('.') > 0) ? parseFloat(otherDrugs) : parseInt(otherDrugs);    
  var calculatedFluid   = intravenousFluids + oralFluids + otherDrugs; 

  $('input[name="total_intake_ml"]').val(calculatedFluid).trigger('change');

  var workingWeight = $('input[name="working_weight"]').val();

  if(workingWeight != '') {

    var totalIntakekg = (calculatedFluid / (workingWeight/1000)) ; 
    var totalIntakekgstring = totalIntakekg.toString();
    (totalIntakekgstring.indexOf('.') > 0) ? $('input[name="total_intake_kg"]').val(totalIntakekg.toFixed(2)).trigger('change') : $('input[name="total_intake_kg"]').val(totalIntakekg).trigger('change');
  }

}

function calculateIObalance() {

 var totalIntake = $('input[name="total_intake_ml"]').val(); 
 var totalOutput = $('input[name="total_output"]').val();

 var balance  = totalIntake - totalOutput;
 var balanceText = balance.toString();
 (balanceText.indexOf('.') > 0) ? $('input[name="i_o_balance"]').val(balance.toFixed(2)).trigger('change') : $('input[name="i_o_balance"]').val(balance).trigger('change');


 var totalIntakeDay = $('input[name="total_intake_kg"]').val();
 var totalIntakeMlday = $('input[name="total_output_ml_day"]').val();
 var balanceDay  = totalIntakeDay - totalIntakeMlday;
 var balanceDayText = balanceDay.toString();

 (balanceDayText.indexOf('.') > 0) ? $('input[name="i_o_balance_ml_kg"]').val(balanceDay.toFixed(2)).trigger('change') : $('input[name="i_o_balance_ml_kg"]').val(balanceDay).trigger('change');


}

$('input[name="total_intake_ml"], input[name="total_intake_kg"], input[name="total_output"], input[name="total_output_ml_day"]').change(function() {
  calculateIObalance();
});

$('.total-intake-ml, .total-intake-kg, .total-output, .total-output-ml-day').change(function() {
  calculateIObalance();
});

$('input[name="aspirate_ml"], input[name="drains_ml"], input[name="urine_total"], input[name="blood_out_total_day"],input[name="stoma_output"], input[name="working_weight"]').change(function() {
  calculateTotaloutput();
});

$('input[name="milk_volume_total"]').change(function() {
  $('input[name="oral_fluids"]').val($(this).val()).trigger('change');

});



function calculateTotaloutput() {

  var aspirateMl         = $('input[name="aspirate_ml"]').val();
  var drainsMl           = $('input[name="drains_ml"]').val();
  var urineTotal         = $('input[name="urine_total"]').val();
  // var bloodutTotalday    = $('input[name="blood_out_total_day"]').val();
  var bloodutTotalday    = $('input[name="blood_out_total"]').val();
  var stomaOutput        = $('input[name="stoma_output"]').val();

  aspirateMl      = (aspirateMl != '') ? aspirateMl   :  0 ;
  drainsMl        = (drainsMl != '') ?  drainsMl    :  0 ;
  urineTotal      = (urineTotal != '') ? urineTotal   :  0 ;
  bloodutTotalday = (bloodutTotalday != '') ? bloodutTotalday : 0 ;
  stomaOutput     = (stomaOutput != '') ? stomaOutput : 0 ;


  var totalOutput = parseInt(aspirateMl) + parseInt(drainsMl) + parseInt(urineTotal) + parseInt(bloodutTotalday) + parseInt(stomaOutput); 

  $('input[name="total_output"]').val(totalOutput).trigger('change');

  var workingWeight = $('input[name="working_weight"]').val();

  if (workingWeight != '') {
    var outputMl = (totalOutput/(workingWeight/1000));

    $('input[name="total_output_ml_day"]').val(outputMl.toFixed(2)).trigger('change');

  }


}

function transfusionStatus() {

  var Transfusion =  $('select[name="Transfusion"]').val();

  if (Transfusion == '' || Transfusion == 'No') {
   $('select[name="F_Product[]"]').attr('disabled',true);
   $('select[name="F_Volume[]"]').attr('disabled',true);
   $('.product').parent().slideUp();

 } else {
   $('select[name="F_Product[]"]').attr('disabled',false);
   $('select[name="F_Volume[]"]').attr('disabled',false);
   $('.product').parent().slideDown();
 }

}

function replacementFluids() {
  var replacementFluids = $('select[name="replacement_fluids_status"]').val();

  if (replacementFluids == '' || replacementFluids == 'No') {
   $('select[name="replacement_fluids_solution[]"]').attr('disabled',true);
   $('select[name="replacement_fluids_rate[]"]').attr('disabled',true);
   $('select[name="replacement_fluids_total[]"]').attr('disabled',true);

   $('.replacement_fluids').parent().slideUp();

 } else {
   $('select[name="replacement_fluids_solution[]"]').attr('disabled',false);
   $('select[name="replacement_fluids_rate[]"]').attr('disabled',false);
   $('select[name="replacement_fluids_total[]"]').attr('disabled',true);

   $('.replacement_fluids').parent().slideDown();
 }

}

function calculateTemperature() {

  var Tone = $('input[name="core_temp"]').val();
  var Ttwo = $('input[name="peripheral_temp"]').val();

  if (Tone != '' && Ttwo != '') {
   var result =   Tone - Ttwo;
   result1 = result.toString();
   (result1.indexOf('.') > 0) ?  $('input[name="t1_t2"]').val(result.toFixed(1)) : $('input[name="t1_t2"]').val(result);
   $('input[name="t1_t2"]').addClass('not_saved');
 }
}

$('select[name="Transfusion"]').change(function() {
  transfusionStatus();
});

$('select[name="replacement_fluids_status"]').change(function() {
  replacementFluids();
});

$('#bp_method').change(function() {
 bpmethod();
});

$(document).on('change', 'input[name="core_temp"], input[name="peripheral_temp"]',function() {
  calculateTemperature();
});
calculateTemperature();
bpmethod();
transfusionStatus();
replacementFluids();




$('.daycare-date').datepicker({
  dateFormat: 'dd-mm-yy',
  yearRange: "-01:+00",
  changeMonth : true,
  changeYear : true,  
  maxDate:'+0M',
  minDate:'-12M'
});

$('input[name="it_rate_secound"]').change(function() {
 var itRateSecound = $(this).val();
 if (itRateSecound.indexOf('.') ==0) {
   $(this).val('0'+ $(this).val());
 }

});



$('.drug-solution').each(function() {
 initiateSelecttwo('#'+$(this).attr('id'));
});

$('.sepsis-antibiotic').each(function() {
 initiateSelecttwo('#'+$(this).attr('id'));
});

$('.other-drugs').each(function() {
  initiateSelecttwo('#'+$(this).attr('id'));
});

$('.ivdrug_brandname').each(function() {
  initiateSelecttwo('#'+$(this).attr('id'));
});

$('.infusion_brandname').each(function() {
  initiateSelecttwo('#'+$(this).attr('id'));
});

$('.infusion_pharmacological').each(function() {
  initiateSelecttwo('#'+$(this).attr('id'));
});

$('.oral_brandname').each(function() {
 initiateSelecttwo('#'+$(this).attr('id'));
});

$('.replacement-fluids-solution').each(function() {
 initiateSelecttwo('#'+$(this).attr('id'));

});



$('.ivdrug_genericname').each(function() {
  initiateSelecttwo('#'+$(this).attr('id'));
});

$('.ivdrug-brandname').each(function() {
  initiateSelecttwo('#'+$(this).attr('id'));
});


$('.ivdrug-genericname').each(function() {
  initiateSelecttwo('#'+$(this).attr('id'));
});

$('.oral_genericname').each(function() {
  initiateSelecttwo('#'+$(this).attr('id'));
});

$('.other_drugs').each(function() {
  initiateSelecttwo('#'+$(this).attr('id'));
});

$('.oral-brandname').each(function() {
  initiateSelecttwo('#'+$(this).attr('id'));
});

$('.oral-genericname').each(function() {
  initiateSelecttwo('#'+$(this).attr('id'));
});


    //changed prescription 
    $('.speical_name_one').each(function() {
      initiateSelecttwo('#'+$(this).attr('id'));

    });

    $('.speical_name_two').each(function() {
      initiateSelecttwo('#'+$(this).attr('id'));

    });

    $('.other-iv-drugs-brandname').each(function() {
      initiateSelecttwo('#'+$(this).attr('id'));

    });

    $('.other-iv-drugs-pharmacological').each(function() {
      initiateSelecttwo('#'+$(this).attr('id'));

    });
    
    $('.other-iv-drugs-frequency').each(function() {
      initiateSelecttwo('#'+$(this).attr('id'));

    });

    $('.oral-brand-name').each(function() {
     initiateSelecttwo('#'+$(this).attr('id'));
   });

    $('.oral-pharmacological-name').each(function() {
     initiateSelecttwo('#'+$(this).attr('id'));
   });

    $('.oral-frequency').each(function() {
     initiateSelecttwo('#'+$(this).attr('id'));
   });

    //iv fluids PN
    initiateSelecttwo("#drug-solution-0");
    initiateSelecttwo("#antiboitic0");
    initiateSelecttwo("#other_drugs_0");
    initiateSelecttwo("#replacement-fluids-solution-0");


    initiateSelecttwo("#infusion-brandname-0");
    initiateSelecttwo("#infusion-pharmacological-0");

    initiateSelecttwo("#speical_name_one_0");
    initiateSelecttwo("#speical_name_two_0");

    initiateSelecttwo("#other-iv-drugs-brandname-0");
    initiateSelecttwo('#other-iv-drugs-pharmacological-0');
    initiateSelecttwo('#other-iv-drugs-frequency-0');


    initiateSelecttwo('#oral-brand-name-0');
    initiateSelecttwo('#oral-pharmacological-name-0');
    initiateSelecttwo('#oral-frequency-0');

    milkfeedschanges();

    $('select[name="milk_feeds"]').change(function() {
      milkfeedschanges();
    });

    $('input[name="ivdrug_volume[]"],select[name="ivdrug_frequency[]"]').change(function() {
     ivdrugsTotal();
   });

    $(document).on('change','input[name="ivdrug_volume[]"], select[name="ivdrug_frequency[]"]',function() {
     ivdrugsTotal();
   });



    function ivdrugsTotal() {

      var ivdrugsTotal = 0 ;

      $('input[name="ivdrug_volume[]"]').each(function() {

        if ($(this).val() != '') {
          var drugNumber     = $(this).data('drugs-number');
          var drugFrequency  = $('#ivdrug_frequency'+drugNumber).val();
          ivdrugsTotal = ivdrugsTotal+($(this).val() * drugFrequency);
        }

      });

      $('input[name="other_drugs"]').val(ivdrugsTotal);

    }


    $('.add-iv-pn-fluids').click(function() {

      var id  = parseInt($('.drug-solution').length) + 1 ;
      var options  = $('select[name="temp_drug_solution"]').html();  
      id = (isNaN(id) == true ) ? 0 : id;

      var headerId = $(this).data('header-id');
      var ivFlu    = 'iv-flu_'+id+'_'+headerId;  
      var ivRate   = 'iv-rate_'+id+'_'+headerId;    
      var ivTotal  = 'iv-total_'+id+'_'+headerId;

      var drugInfusions    = '<td></td>';
      drugInfusions   += '<td><select name="drug_solution['+ivFlu+']" class="drug-solution input-width-xxlarge not_saved" id="drug-solution-'+id+'" data-solution="'+id+'">'+options+'</select></td>';
      drugInfusions   += '<td><input class="form-control not_saved" name="drug_rate['+ivRate+']" data-solution="'+id+'" id="drug_rate" type="number"></td>';
      drugInfusions   += '<td><input class="form-control drug_total not_saved" name="drug_total['+ivTotal+']"  id="drug-rate-'+id+'" type="number"></td>';
      drugInfusions   += '<td class="hide"> <span class="fa fa-remove btn btn-default remove"></span> </td>';
      drugInfusions   += '<td><a href="javascript:void(0);" data-select-id="'+id+'" class="btn btn-danger add-iv-pn-fluids-remove danger btn-view remove"><i class="fa fa-trash"></i></a></td>';
      var drugInfusionsSet = '<tr>'+drugInfusions+'</tr>';

      var lastNode = $(this).parent().parent().parent();
      $(drugInfusionsSet).insertBefore(lastNode);
      initiateSelecttwo('#drug-solution-'+id);


    });

    $(document).on('click', '.add-iv-pn-fluids-remove',function() {
     var selectId = $(this).data('select-id'); 
     $('#drug-solution-'+selectId).select2('destroy'); 
     $(this).parent('td').parent('tr').remove();

   });
    

    $('.add-replacement-list').click(function() {

     var options  = $('select[name="temp_drug_solution"]').html();  
     var id       = parseInt($('.replacement-fluids-solution').length) + 1 ;
     id       = (isNaN(id) == true ) ? 0 : id;

     var headerId  = $(this).data('replacement-header');
     var reFluids  = 'refluids_'+id+'_'+headerId;  
     var reRate    = 'rerate_'+id+'_'+headerId;  
     var reTotal   = 'retotal_'+id+'_'+headerId;  


     var replacementFluids   = '<td></td>';
     replacementFluids  += '<td> <select class="replacement-fluids-solution input-width-xxlarge not_saved" name="replacement_fluids_solution['+reFluids+']" data-replacement="'+id+'" id="replacement-fluids-solution-'+id+'">'+options+'</select></td>';   
     replacementFluids  += '<td> <input class="form-control replacement_fluids_rate not_saved" name="replacement_fluids_rate['+reRate+']" data-solution="'+id+'" id="replacement_fluids_solution" type="number"></td>';   
     replacementFluids  += '<td> <input class="form-control replacement_fluids_total not_saved" name="replacement_fluids_total['+reTotal+']" id="replacement_fluids_total'+id+'" type="number"></td>';   
     replacementFluids  += '<td> <span class="fa fa-trash btn btn-danger btn-view remove"></span></td>';
     replacementFluidsSet = '<tr>'+replacementFluids+'</tr>';

     var lastNode  =  $(this).parent().parent().parent();
     $(replacementFluidsSet).insertBefore(lastNode);



     initiateSelecttwo('#replacement-fluids-solution-'+id);  

   });


    $(".add-antibio-list").click(function() {

      var id = $('.sepsis-antibiotic').last().data('antibiotic')+1;
      id = (isNaN(id) == true ) ? 0 : id;
      var header_id = $(this).data('antibio-header');
      var antiBio = 'antibio_'+id+'_'+header_id;
      var antiDay = 'antiday_'+id+'_'+header_id;

      antibiotic_select  ='<select name="A_Antibiotic['+antiBio+']" class="sepsis-antibiotic full-width not_saved" id="antiboitic'+id+'" data-antibiotic="'+id+'">';
      antibiotic_select += $("select[name='a_antibiotic_temp']").html();
      antibiotic_select +='</select>';
      option =  '<tr><td class="full-width">'+antibiotic_select+'</td>'; 
      option += '<td><input type="text" class="input-width-mini form-control not_saved" name="A_Day['+antiDay+']" value="" /></td>';
      option += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></td>';
      option += '</tr>';

      var lastNode  =  $(this).parent().parent();

      $(option).insertBefore(lastNode);

      // $('.antibiotic tbody').append(option);

      initiateSelecttwo('#antiboitic'+id);

    });

    $(".add-other-drugs-list").click(function() {

      var drugs  = $('select[name="temp_drugs"]').html();

      var id = parseInt($('.other_drugs').parent().parent().parent().children().length);
      id = (isNaN(id) == true ) ? 0 : id;

      var header_id = $(this).data('other-header-id');
      var otherDrug = 'other_'+id+'_'+header_id;

        // var option = '<tr><td><select class="input-width-xmedium other_drugs" id="other_drugs['+id+']" data-other-drug="'+id+'" name="drugs['+id+']">'+drugs+'</select></td>';
        var option  = '<tr><td class="full-width-must"><select name="drugs[other_drug_'+id+']" id="other_drugs'+id+'" data-other-drug="'+id+'" class="input-width-xmedium other_drugs full-width-must not_saved">'+drugs+'</select></td>';
        option += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>';
        option += '</tr>';

        var lastNode  =  $(this).parent().parent();
        $(option).insertBefore(lastNode);
        // $('.other-drug-table tbody').append(option)
        initiateSelecttwo("#other_drugs"+id);

      });

    $('.add-blood-product-list').click(function() {

      var header_id = $(this).data('blood-header-id');
      var id  = parseInt($('table.product tbody tr').length) +1;
      id = (isNaN(id) == true ) ? 0 : id;

        // var bloodproduct = 'blood-product_'+id+'_'+header_id;
        // var bloodvolume  = 'blood-volume_'+id+'_'+header_id;
        var bloodproduct = 'blood-product_'+id;
        var bloodvolume  = 'blood-volume_'+id;


        var productNameList= $('select[name="f_product_temp"]').html();
        var productList      = '<td class="full-width"><select name="F_Product['+bloodproduct+']" class="form-control full-width not_saved">'+productNameList+'</select></td>';
        productList     += '<td><input type="text" class="form-control input-width-mini not_saved" name="F_Volume['+bloodvolume+']" value=""/></td>';
        productList     += '<td><span class="fa fa-trash btn btn-danger btn-view remove"></td>';
        var productListSet   = '<tr>'+productList+'</tr>';
        var lastNode  =  $(this).parent().parent();

        $(productListSet).insertBefore(lastNode);

      });

    $('.infusion-dose-units-g, .infusion-dose-units-kg, .infusion-dose-units-time').change(function() {

     var infusionId = $(this).data('infusion-id');
     var infusionDose     = [];
     infusionDose.push($('#infusion-dose-units-g-'+infusionId).val());
     infusionDose.push($('#infusion-dose-units-kg-'+infusionId).val());
     infusionDose.push($('#infusion-dose-units-time-'+infusionId).val());
     infusionDose     =  JSON.stringify(infusionDose);
     $('#infusion_dose_units'+infusionId).val(infusionDose);   
   });

    $('.calculate-glucose').change(function() {

      var id  =  $(this).data('fluids');
      var infusionRate        = $('#speical_iv_infusion_rate_'+id).val();
      var glucoseInfusionRate = $('#speical_iv_glucose_'+id).val();
      var syringeSize         = $('#speical_iv_syringe_'+id).val();
      var dextroseTwo         = $('#speical_name_two_'+id).val();
      var dextroseOne         = $('#speical_name_one_'+id).val();
      var weight              = $('#working_weight').val();

      if (weight != '') {

        var TotalDextroseMl   = infusionRate * 24;
        var TotalDextroseGms  =  glucoseInfusionRate * weight / 1000 * 60 * 24 / 1000;

        var Dextrose1Res = (TotalDextroseMl * dextroseTwo - TotalDextroseGms * 100)/(dextroseTwo-dextroseOne);
        var Dextrose2Res = (TotalDextroseMl * dextroseOne - TotalDextroseGms * 100)/(dextroseOne-dextroseTwo);

        var Dextrose1Res20 = Dextrose1Res / (Dextrose1Res+Dextrose2Res) * syringeSize;
        var Dextrose2Res20 = Dextrose2Res / (Dextrose1Res+Dextrose2Res) * syringeSize;

        var Total = TotalDextroseGms / TotalDextroseMl * 100;

        $("#speical_fluid_vol_one_"+id).val(Dextrose1Res20.toFixed (2));
        $("#speical_fluid_vol_two_"+id).val(Dextrose2Res20.toFixed (2));
        $('#speical_iv_dextrose_'+id).val(Total.toFixed(2));

        if (Total.toFixed(2) > 12.5) {
         $('#speical_iv_instruction_'+id).val('via central line');
       } else if(Total.toFixed(2) < 12.5) {
         $('#speical_iv_instruction_'+id).val('via central or peripheral line');
       }


     } else {

       Showalert('warning','Please fill working weight!');
     }



   });

    $(document).on('change', '.calculate-glucose', function() {

      var id  =  $(this).data('fluids');
      var infusionRate        = $('#speical_iv_infusion_rate_'+id).val();
      var glucoseInfusionRate = $('#speical_iv_glucose_'+id).val();
      var dextrosePercentage  = $('#speical_iv_dextrose_'+id).val();
      var syringeSize         = $('#speical_iv_syringe_'+id).val();
      var dextroseTwo         = $('#speical_name_two_'+id).val();
      var dextroseOne         = $('#speical_name_one_'+id).val();
      var weight              = $('#working_weight').val();

      var TotalDextroseMl   = infusionRate * 24;
      var TotalDextroseGms  =  glucoseInfusionRate * weight / 1000 * 60 * 24 / 1000;

      var Dextrose1Res = (TotalDextroseMl * dextroseTwo - TotalDextroseGms * 100)/(dextroseTwo-dextroseOne);
      var Dextrose2Res = (TotalDextroseMl * dextroseOne - TotalDextroseGms * 100)/(dextroseOne-dextroseTwo);
      
      var Dextrose1Res20 = Dextrose1Res / (Dextrose1Res+Dextrose2Res) * syringeSize;
      var Dextrose2Res20 = Dextrose2Res / (Dextrose1Res+Dextrose2Res) * syringeSize;

      var Total = TotalDextroseGms / TotalDextroseMl * 100;

      $("#speical_fluid_vol_one_"+id).val(Dextrose1Res20.toFixed (2));
      $("#speical_fluid_vol_two_"+id).val(Dextrose2Res20.toFixed (2));
      $('#speical_iv_dextrose_'+id).val(Total.toFixed(2));

      if (Total.toFixed(2) > 12.5) {
       $('#speical_iv_instruction_'+id).val('via central line');
     } else if(Total.toFixed(2) < 12.5) {
       $('#speical_iv_instruction_'+id).val('via central or peripheral line');
     }


   });

    $('.time-prescribed').each(function() {
      timeDropperSettings($(this).attr('id'), false, true);
    });

    $('.date-prescribed').each(function() {
      dateDropperSettings($(this).attr('id'));
    });


    timeDropperSettings('infusion-time-prescribed-0', false, true);
    timeDropperSettings('infusion-time-stopped-0', false, true);

    timeDropperSettings('speical_iv-time-prescribed-0', false, true);
    timeDropperSettings('speical_iv-time-stopped-0', false, true);

    timeDropperSettings('other-infusions-time-prescribed-0', false, true);
    timeDropperSettings('other-infusions-time-stopped-0', false, true);

    timeDropperSettings('other-iv-drugs-time-prescribed-0', false, true);
    timeDropperSettings('other-iv-drugs-time-stopped-0', false, true);

    timeDropperSettings('oral-time-prescribed-0', false, true);
    timeDropperSettings('oral-time-stopped-0', false, true);

    dateDropperSettings('infusion-date-prescribed-0');
    dateDropperSettings('infusion-date-stopped-0');

    dateDropperSettings('speical_iv-date-prescribed-0');
    dateDropperSettings('speical_iv-date-stopped-0');

    dateDropperSettings('other-infusions-date-prescribed-0');
    dateDropperSettings('other-infusions-date-stopped-0');

    dateDropperSettings('other-iv-drugs-date-prescribed-0');
    dateDropperSettings('other-iv-drugs-date-stopped-0');

    dateDropperSettings('oral-date-prescribed-0');
    dateDropperSettings('oral-date-stopped-0');



    function dateDropperSettings(id) {

     $('#'+id).datepicker({
      dateFormat: 'dd-mm-yy',
      yearRange: "-60:+02",
      changeMonth : true,
      changeYear : true,
      maxDate : '+0M',

    });

   }

   $('#blood_gas_type').change(function() {
     bloodGastype();
   });

   function therapeuticHypothermia() {
    if($('#therapeutic_hypothermia').prop('checked') === false) {
     $('#rectal_temp').attr('disabled',true);
     $('label[for="rectal_temp"]').parent().slideUp();
   } else {
    $('#rectal_temp').removeAttr('disabled');
    $('label[for="rectal_temp"]').parent().slideDown();
  }
}

$('#therapeutic_hypothermia').change(function() {
 therapeuticHypothermia();
});

therapeuticHypothermia();

function bloodGastype() {
  var bloodGas     = $('#blood_gas_type').val();
  var bloodGastype = ['blood_gas_bilirubin','blood_gas_ph', 'blood_gas_pao2', 'blood_gas_paco2', 'blood_gas_hco3', 'blood_gas_hco3', 'blood_gas_be', 
  'blood_gas_na','blood_gas_k','blood_gas_cl','blood_gas_hb', 'blood_gas_pcv', 'blood_gas_lactate', 
  'blood_gas_methemoglobin', 'last_bg_time', 'interface_blood_gas_bilirubin',
    'blood_sugar', 'interface_blood_gas_ph', 'interface_blood_gas_pao2', 'interface_blood_gas_paco2', 
    'interface_blood_gas_hco3', 'interface_blood_gas_etco2', 'interface_blood_gas_be', 'interface_blood_gas_na', 
    'interface_blood_gas_k','interface_blood_gas_cl','interface_blood_gas_hb', 'interface_blood_gas_pcv', 
    'interface_blood_gas_lactate', 'interface_blood_gas_methemoglobin', 'interface_blood_gas_calcium', 'tcpo2', 'tcpco2']; 

  if (bloodGas == '' || bloodGas == 'Not indicated' || bloodGas == 'Not done') {
   $('input[name="last_bg_time"]').val('');

   $.each(bloodGastype, function(index, value) {
     $('#'+value).attr('disabled', true);
     $('label[for="'+value+'"]').parent().slideUp();

   });

   $('.blood_gas_type_disable').addClass('display-none');
   $('.blood_gas_type_full').addClass('full-width');


 } else {

  $.each(bloodGastype, function(index, value) {
   $('#'+value).removeAttr('disabled');
   $('label[for="'+value+'"]').parent().slideDown();
 });
  $('.blood_gas_type_disable').removeClass('display-none');
  $('.blood_gas_type_full').removeClass('full-width');


}

}

bloodGastype();

function timeDropperSettings(id, setCurrentTime, initialValue) {

  $('#'+id).timeDropper({
   init_animation:'dropdown',
   setCurrentTime:setCurrentTime,
   initialValue:initialValue
 });

}

// timeDropperSettings('last_bg_time', true, false);


function milkfeedschanges() {
 var list=['type_of_feeds','route_of_feeds'];

 if ($('select[name="milk_feeds"]').val() == 'No') {

         // makeDisable(list);
         $('#human_milk_fortification').bootstrapToggle('off');
         $('.human_milk_fortification').slideUp();
         $('#milk_volume, #milk_volume_total').attr('disabled');
         $('.milk_volume').slideUp();
         $('label[for="type_of_feeds"]').parent().slideUp();  
         $('label[for="route_of_feeds"]').parent().slideUp();  

       } else {

        // removeDisable(list);
        $('.human_milk_fortification').slideDown();
        $('#milk_volume, #milk_volume_total').removeAttr('disabled');
        $('.milk_volume').slideDown();  
        $('label[for="type_of_feeds"]').parent().slideDown();  
        $('label[for="route_of_feeds"]').parent().slideDown();  

      }
    }

   function bowelsCount() {
    if($('#bowels').prop('checked') === false) {
     $('label[for="bowels_count"]').parent().slideUp();
   } else {
    $('label[for="bowels_count"]').parent().slideDown();
  }
}

$('#bowels').change(function() {
 bowelsCount();
});

bowelsCount();


    initiateSelecttwo('#added_nurse');

    function initiateSelecttwo(id) {
      $(id).select2({
        allowClear: true,
        dropdownAutoWidth : false,
        placeholderOption: 'first' });
    }

    
  });  

$(document).on('keyup', '#current_weight, #working_weight', function() {
    $(this).val(this.value.replace(/[^0-9]/g, ''));
});
