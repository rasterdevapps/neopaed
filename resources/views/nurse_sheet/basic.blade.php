<div class="col-md-12 pt-0 plr-0">
    <div class="col-md-12 col-lg-6">
        <!-- baby information -->
        <div class="mt-10 widget box">
            <div class="widget-header">
                <h4><i class="fa fa-reorder"></i> </h4>
            </div>
            <div class="widget-content">
                {!! Form::hidden('BabyId',$baby_id, ['class' => 'not_saved permanant_saved']); !!}
                {!! Form::hidden('AdmissionId',$admission_id, ['class' => 'not_saved permanant_saved']); !!}
                <div class="form-group">
                    {!! Form::label('type_of_care', 'Type of Care:') !!}
                    {!! Form::select('type_of_care',ValuelistHelpers::gettypeofcate(),null,['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('warmer','Warmer Temperature:') !!}
                    <div class="warmer"></div>
                </div>
                <div class="form-group">
                    {!! Form::label('incubator','Incubator Temperature:') !!}
                    <div class="incubator"></div>
                </div>
                <h3><u><b>Baby Observations :</b></u></h3>
                <div class="form-group">
                    {!! Form::label('core_temp','Baby\'s Measured Temperature:') !!}
                    <div class="core_temp"></div>
                </div>
                <div class="form-group">
                    {!! Form::label('peripheral_temp','Monitor Temperature:') !!}
                    <div class="peripheral_temp"></div>
                </div>
                <!-- <div class="form-group">
                    {!! Form::label('t1_t2','T1 - T2:') !!}
                    <div class="t1_t2"></div>
                </div> -->
                <div class="form-group">
                    {!! Form::label('therapeutic_hypothermia','Therapeutic Hypothermia:') !!}
                    <input id="therapeutic_hypothermia" name="therapeutic_hypothermia" data-on="Yes" data-off="No" data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                </div>
                <div class="form-group">
                    {!! Form::label('rectal_temp','Rectal Temperature:') !!} 
                    <div class="rectal_temp"></div>
                </div>
                <div class="form-group">
                    {!! Form::label('hr_rate','Heart Rate:') !!}
                    <div class="hr_rate"></div>
                </div>
                <div class="form-group">
                    {!! Form::label('respiratory_rate_measured','Baby\'s Respiratory Rate (Measured):') !!}
                    <div class="respiratory_rate_measured"></div>
                </div>
                <div class="form-group">
                    {!! Form::label('respiratory_rate','Baby\'s Respiratory Rate (Monitor):') !!}
                    <div class="respiratory_rate"></div>
                </div>
                <div class="form-group">
                    {!! Form::label('bp_method','BP Method:') !!}
                    {!! Form::select('bp_method',ValuelistHelpers::bpmethod(),null,['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('cuff_systalic_bp','Cuff Systolic BP:') !!}
                    <div class="cuff_systalic_bp"></div>
                </div>
                <div class="form-group">
                    {!! Form::label('cuff_diastolic_bp','Cuff Diastolic BP:') !!}
                    <div class="cuff_diastolic_bp"></div>
                </div>
                <div class="form-group">
                    {!! Form::label('cuff_mean_bp','Cuff Mean BP:') !!}
                    <div class="cuff_mean_bp"></div>
                </div>
                <div class="form-group">
                    {!! Form::label('arterial_systalic_bp','Arterial Systolic BP:') !!}
                    <div class="arterial_systalic_bp"></div>
                </div>
                <div class="form-group">
                    {!! Form::label('arterial_diastolic_bp','Arterial Diastolic BP:') !!}
                    <div class="arterial_diastolic_bp"></div>
                </div>
                <div class="form-group">
                    {!! Form::label('arterial_mean_bp','Arterial Mean BP:') !!}
                    <div class="arterial_mean_bp"></div>
                </div>
                <div class="form-group">
                    {!! Form::label('preductal_sao2','Sao2 (Preductal):') !!}
                    <div class="preductal_sao2"></div>
                </div>
                <div class="form-group">
                    {!! Form::label('postductal_sao2','Sao2 (Postductal):') !!}
                    <div class="postductal_sao2"></div>
                </div>
                <div class="form-group">
                    {!! Form::label('perfusion_index','Perfusion Index:') !!}
                    <div class="perfusion_index"></div>
                </div>
                <div class="form-group">
                    {!! Form::label('color','Colour:') !!}
                    {!! Form::select('color',['Yellow'=>'Yellow','Pale'=>'Pale','Pink'=>'Pink','Acral Cyanosis'=>'Acral Cyanosis','Central Cyanosis'=>'Central Cyanosis'],'Pink',['class'=>'form-control not_saved permanant_saved']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('phototherapy','Phototherapy:') !!}
                    <input id="phototherapy" name="phototherapy" data-on="Yes" data-off="No"  data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                </div>
                <div class="form-group">
                    {!! Form::label('phototherapy_eyes','Eyes Covered:') !!}
                    <!-- <input id="phototherapy_eyes" name="phototherapy_eyes" data-on="Yes" data-off="No" data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox"> -->
                    {!! Form::select('phototherapy_eyes',[''=>'N/A']+ValuelistHelpers::commonValues(),null,['class'=>'form-control eyes_covered_toggle', 'id' => 'phototherapy_eyes']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('activity','Activity :') !!}
                    {!! Form::select('activity', ValuelistHelpers::activityoption(),null,['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('position', 'Position:') !!}
                    {!! Form::select('position', ValuelistHelpers::positionoptions(),null,['class'=>'form-control']) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-6">
        <div class="mt-10 widget box">
            <div class="widget-header">
                <h4><i class="fa fa-reorder"></i> Respiratory Support:</h4>
            </div>
            <div class="widget-content">
                <div class="form-group">
                    {!! Form::label('work_of_breathing', 'Work Of Breathing:') !!}
                    {!! Form::select('work_of_breathing',ValuelistHelpers::workofbreathing(),null,['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('mode_of_ventilation', 'Mode Of Invasive Respiratory Support:') !!}
                    {!! Form::select('mode_of_ventilation',ValuelistHelpers::modeofventilation(),null,['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('mode_of_ventilation_invasive', 'Mode Of Non-Invasive Respiratory Support:') !!}
                    {!! Form::select('mode_of_ventilation_invasive',ValuelistHelpers::modeofinvasiveventilation(),null,['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('cpap_interface_change','CPAP Interface Change:') !!}
                    {!! Form::select('cpap_interface_change',ValuelistHelpers::cpapinterface(),null,['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('volume_targeting','Volume Targeting:') !!}
                    <input id="volume_targeting" name="volume_targeting" data-on="Yes" data-off="No" data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                </div>
                <div class="form-group ventilator_properties">
                    {!! Form::label('targeted_tidal_volume', 'Targeted Tidal Volume:') !!}
                    <div class="targeted_tidal_volume"></div>
                </div>
                <div class="form-group ventilator_properties">
                    {!! Form::label('p_amplitude', '&Delta;P/Amplitude:') !!}
                    <div class="p_amplitude"></div>
                </div>
                <div class="form-group ventilator_properties">
                    {!! Form::label('pip_set','PIP(set):') !!}
                    <div class="pip_set"></div>
                </div>
                <div class="form-group ventilator_properties">
                    {!! Form::label('pip_delivered','PIP(delivered):') !!}
                    <div class="pip_delivered"></div>
                </div>
                <div class="form-group ventilator_properties">
                    {!! Form::label('peep','PEEP:') !!}
                    <div class="peep"></div>
                </div>
                <div class="form-group ventilator_properties">
                    {!! Form::label('map','MAP:') !!}
                    <div class="map"></div>
                </div>
                <div class="form-group ventilator_properties">
                    {!! Form::label('fio2','FiO2 % :') !!}
                    <div class="fio2"></div>
                </div>
                <div class="form-group ventilator_properties">
                    {!! Form::label('fio2_measured','FiO2 % (Measured):') !!}
                    <div class="fio2_measured"></div>
                </div>
                <div class="form-group ventilator_properties">
                    {!! Form::label('flow','FLOW:') !!}
                    <div class="flow"></div>
                </div>
                <div class="form-group ventilator_properties">
                    {!! Form::label('delivered_tidal_volume','Delivered Tidal Volume:') !!}
                    <div class="delivered_tidal_volume"></div>
                </div>
                <div class="form-group ventilator_properties">
                    {!! Form::label('rate','RATE/V (Set Ventilator Rate):') !!}
                    <div class="rate"></div>
                </div>
                <div class="form-group ventilator_properties">
                    {!! Form::label('frequency','Frequency(H2):') !!}
                    <div class="frequency"></div>
                </div>
                <div class="form-group ventilator_properties">
                    {!! Form::label('it_rate','IT(%):') !!}
                    <div class="it_rate"></div>
                </div>
                <div class="form-group ventilator_properties">
                    {!! Form::label('it_rate_secound','IT(S):') !!}
                    <div class="it_rate_secound"></div>
                </div>
                <div class="form-group ventilator_properties">
                    {!! Form::label('ie_r','IE RATIO:') !!}
                    <div class="ie_r"></div>
                </div>
                {{-- <div class="form-group ventilator_properties"> --}}
                <div class="form-group">
                    {!! Form::label('humidifier_temp', 'Humidifier/Temp:') !!}
                    <div class="humidifier_temp"></div>
                </div>
                <div class="form-group">
                    {!! Form::label('air_entry_right','Air Entry (R):') !!}
                    {!! Form::select('air_entry_right',ValuelistHelpers::nurssheeteairentry(),null,['class'=>'form-control'])  !!}
                </div>
                <div class="form-group">
                    {!! Form::label('air_entry_left','Air Entry (L):') !!}
                    {!! Form::select('air_entry_left',ValuelistHelpers::nurssheeteairentry(),null,['class'=>'form-control'])  !!}
                </div>
                <div class="form-group">
                    {!! Form::label('physiotherapy','Chest Physiotherapy:') !!}
                    <input id="physiotherapy" name="physiotherapy" data-on="Yes" data-off="No"  data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                </div>
                <div class="form-group">
                    {!! Form::label('suction','Suction:') !!}
                    <input id="suction" name="suction" data-on="Yes" data-off="No" data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).on('change', '#phototherapy', function()
        {
          if (!$(this).is(':checked')) {
            $('#phototherapy_eyes').val('').trigger('change');
          }
        });
      $(document).on('change', '#phototherapy_eyes', function()
      {
        var pho_val = $(this).find('option').filter(':selected').val();
        if (pho_val == 'Yes') {
          $('#phototherapy').bootstrapToggle('on');
        }
      });
</script>
