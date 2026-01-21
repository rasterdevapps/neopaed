<script type="text/javascript">



    $(document).ready(function() {



      $('#discharge_malinformation').on('change', function() {
          malformationDependancy();
      });

      $('#discharge_hearing_screen').on('change', function() {
          hearingDependancy();
      });

      $('#rop_screening_status').on('change', function () {
       ropDependancy();
   });

      $('#rop_treatment').on('change', function() {
       ropTreatementDependancy();
   });    

      $('#discharge_status').on('change', function() {
         addDieddate();
     }); 

      $('#echocardiography_status').on('change', function() {
        echoCardiographyReport();
    });

      $('#discharge_cuss').on('change', function() {
        cranialUltrasoundReport();
    });



      hearingDependancy();
      ropDependancy();
      ropTreatementDependancy();
      malformationDependancy();
      addDieddate();
      echoCardiographyReport();
      cranialUltrasoundReport();
      
      var horizontalSelectorsList = ['discharge_immunization', 'discharge_cardiac_murmur', 'discharge_femorals', 
      'discharge_hips', 'discharge_malinformation', 'neourological_status', 'discharge_home_oxygen',
      'discharge_cuss', 'discharge_new_born', 'discharge_hearing_screen',
      'rop_screening_status', 'rop_follow_up', 'rop_treatment','echocardiography_status','discharge_gentila'];

      $.each(horizontalSelectorsList,function(index,value){
        
          buildSelector(value);

      }); 

      @if($dischargeList->appoinment_status == 1)
      $('#appoinment_status').bootstrapToggle('on');
      @else
      $('#appoinment_status').bootstrapToggle('off');
      @endif
      appoinmentStatus();

      $('#appoinment_status').on('change', function() {
          appoinmentStatus();
      });

      function proceduresAdd() {

          var procedure =  '<tr>';
          procedure += '<td>';
          procedure += '<select name="procedures[]" class="form-control">';
          procedure += $('select[name="temp_procedures"]').html();
          procedure += '</select>';
          procedure += '</td>';
          procedure += '<td>';
          procedure += '<span class="fa fa-trash btn btn-danger btn-view remove"></span>';
          procedure += '</td>';
          procedure += '</tr>';
          $('.procedure-list tbody').append(procedure);   

      }

      $('.procedure_add').click(function() {
         proceduresAdd();
     });



  });



    function drugsStrength(drug_id, id) {
        if (drug_id == null || !(drug_id > 0)) {
            Showalert('error', 'Please select valid drug');
            $('.formulation' + id).html('');
            $('.generic_name' + id).val('');
        } else {

            $.ajax({
                Type:'GET',
                url :'{{ url("masters/drugs-strength/") }}' + '/' + drug_id,
                success:function(responseText) {

                    var option = '<option value="">N/A</option>';
                    var generic_name = '';
                    var i = 1;

                    $.each(responseText, function(index, values) {
                      
                      var medictionName = (i == 1) ? 'selected = "true"': '';
                      if (values.Value != '' && values.Value != null) {
                        option += '<option value="' + values.Id + '" '+medictionName+'>' + values.Value + '</option>';
                        generic_name = values.generic_name;
                        i++;  
                    }
                });


                    $('.formulation' + id).html(option);
                    $('.generic_name' + id).val(generic_name);
                },
                error:function(responseText) {

                    var option = '<option value="">No data found</option>';
                    var generic_name = 'No data found';
                    $('.formulation' + id).html(option);
                    $('.generic_name' + id).val(generic_name);
                }

            });
        }
    }

    $(document).on('change', '.drugs-changes', function() {
        var drug_id = $(this).val();
        var id = $(this).data('id');
        drugsStrength(drug_id, id);
    });


    $('#DischargeDate').change(function() {

        var dischargeDate = $(this).datepicker("getDate");
        var dob = $('#DOB').datepicker('getDate');
        var days = calculateDays(dob, dischargeDate);
        var gestationDays = $('input[name="temp_gestation"]').val();

        var correctedweekDays = parseInt(gestationDays) + parseInt(days);
        var correctedWeeks = parseInt(parseInt(correctedweekDays) / 7);
        var correctedDays = parseInt(parseInt(correctedweekDays) % 7);
        $('#dcg_weeks').val(correctedWeeks);
        $('#dcg_days').val(correctedDays);
        $('#DOLatDischarge').val(days);
    });



</script>