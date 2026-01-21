<div class="col-md-12 plr-0">
    <div class="col-md-12 display-inline-block full-width plr-0">
        <div class="col-md-3 col-sm-5">{!! Form::label('primary_res_support','PRIMARY RESPIRATORY SUPPORT REQUIRED',['class'=>'title']) !!}</div>
        <div class="col-md-3 col-sm-4 display-flex plr-0">
            <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('primary_res_support','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
            <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('primary_res_support','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
            <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('primary_res_support','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
        </div>
        <div class="col-md-3 col-sm-3 pl-0 pl-xs-15">{!! Form::select('res_support_type',[''=>'N/A','O2 prongs, hood'=>'O2 prongs, hood','HHHFNC'=>'HHHFNC','CPAP'=>'CPAP','NIPPV'=>'NIPPV','Nasal HFOV'=>'Nasal HFOV','MV (Conventional)'=>'MV (Conventional)','MV(HFOV)'=>'MV(HFOV)'],null,['class'=>'form-control shadow']) !!}</div>
    </div>
    <div class="col-md-12"> Details of all types of respiratory support required ( Primary & weaning) : </div>
    <div class="col-md-12 scroll-x">
        <table class="table responsive-table">
            <thead class="tableborder">
                <tr>
                    <th></th>
                    <th class="text-center">HIGHEST SETTINGS (MAP or Pressure or Flow /FiO2)</th>
                    <th class="text-center">TOTAL DURATION OF RESPIRATORY SUPPORT(Hours)</th>
                    <th class="text-center">
                        <div>FAILURE OF PRIMARY RESPIRATORY SUPPORT</div>
                        <div> ( HHHFNC/ CPAP/ NIPPV/ Nasal HFOV)</div>
                        <div>EXTUBATION FAILURE MENTION Yes/No</div>
                    </th>
                </tr>
            </thead>
            <tbody class="tableborder">
                <tr>
                    <td class="overflow-auto">HHHFNC</td>
                    <td class="col-md-4 col-sm-4 col-xs-4 overflow-auto">
                        <div class="col-md-4 col-sm-7 col-xs-7">{!! Form::text('hhhnfc_settings_liter',null,['class'=>' form-control shadow']) !!}</div>
                        <div class="title col-md-2 col-sm-3 col-xs-3 plr-0"> L/MINS </div>
                        <div class="col-md-4 col-sm-7 col-xs-7">{!! Form::text('hhhnfc_settings_fio2',null,['class'=>' form-control shadow']) !!}</div>
                        <div class="title col-md-2 col-sm-3 col-xs-3 plr-0"> FIO2 (%) </div>
                    </td>
                    <td class="overflow-auto">
                        <div class="col-md-12">
                            {!! Form::text('hhhnfc_duration',null,['class'=>'custom-form-control form-control shadow']) !!}
                        </div>
                    </td>
                    <td class="col-md-3 col-sm-3 col-xs-3 overflow-auto">
                        <div class="col-md-4 col-sm-4 col-xs-4 plr-0 text-center">{!! Form::radio('hhhnfc_failure','N/A') !!}{!! Form::label('N/A','N/A') !!}</div>
                        <div class="col-md-4 col-sm-4 col-xs-4 plr-0 text-center">{!! Form::radio('hhhnfc_failure','yes') !!}{!! Form::label('yes','Yes') !!}</div>
                        <div class="col-md-4 col-sm-4 col-xs-4 plr-0 text-center">{!! Form::radio('hhhnfc_failure','no') !!}{!! Form::label('no','No') !!}</div>
                    </td>
                </tr>
                <tr>
                    <td class="overflow-auto">CPAP</td>
                    <td class="col-md-4 col-sm-4 col-xs-4 overflow-auto">
                        <div class="col-md-4 col-sm-7 col-xs-7">{!! Form::text('cpap_settings_peep',null,['class'=>' form-control shadow']) !!}</div>
                        <div class="title col-md-2 col-sm-3 col-xs-3 plr-0"> PEEP </div>
                        <div class="col-md-4 col-sm-7 col-xs-7">{!! Form::text('cpap_settings_fio2',null,['class'=>' form-control shadow']) !!}</div>
                        <div class="title col-md-2 col-sm-3 col-xs-3 plr-0"> FIO2 (%) </div>
                    </td>
                    <td class="overflow-auto">
                        <div class="col-md-12">
                            {!! Form::text('cpap_duration',null,['class'=>'custom-form-control form-control shadow']) !!}
                        </div>
                    </td>
                    <td class="col-md-3 col-sm-3 overflow-auto">
                        <div class="col-md-4 col-sm-4 col-xs-4 plr-0 text-center">{!! Form::radio('cpap_failure','N/A') !!}{!! Form::label('N/A','N/A') !!}</div>
                        <div class="col-md-4 col-sm-4 col-xs-4 plr-0 text-center">{!! Form::radio('cpap_failure','yes') !!}{!! Form::label('yes','Yes') !!}</div>
                        <div class="col-md-4 col-sm-4 col-xs-4 plr-0 text-center">{!! Form::radio('cpap_failure','no') !!}{!! Form::label('no','No') !!}</div>
                    </td>
                </tr>
                <tr>
                    <td class="overflow-auto">NIPPV</td>
                    <td class="overflow-auto">
                        <div class="col-md-12">
                            {!! Form::text('nippv_settings',null,['class'=>'custom-form-control form-control shadow']) !!}
                        </div>
                    </td>
                    <td class="overflow-auto">
                        <div class="col-md-12">
                            {!! Form::text('nippv_duration',null,['class'=>'custom-form-control form-control shadow']) !!}
                        </div>
                    </td>
                    <td class="col-md-3 col-sm-3 overflow-auto">
                        <div class="col-md-4 col-sm-4 col-xs-4 plr-0 text-center">{!! Form::radio('nippv_failure','N/A') !!}{!! Form::label('N/A','N/A') !!}</div>
                        <div class="col-md-4 col-sm-4 col-xs-4 plr-0 text-center">{!! Form::radio('nippv_failure','yes') !!}{!! Form::label('yes','Yes') !!}</div>
                        <div class="col-md-4 col-sm-4 col-xs-4 plr-0 text-center">{!! Form::radio('nippv_failure','no') !!}{!! Form::label('no','No') !!}</div>
                    </td>
                </tr>
                <tr>
                    <td class="overflow-auto">NASAL HFOV (Primary)</td>
                    <td class="col-md-4 col-sm-4 col-xs-4 overflow-auto">
                        <div class="col-md-4 col-sm-7 col-xs-7">{!! Form::text('nasal_hfov_pduration_map',null,['class'=>' form-control shadow']) !!}</div>
                        <div class="title col-md-2 col-sm-3 col-xs-3 plr-0"> MAP </div>
                        <div class="col-md-4 col-sm-7 col-xs-7">{!! Form::text('nasal_hfov_pduration_fio2',null,['class'=>' form-control shadow']) !!}</div>
                        <div class="title col-md-2 col-sm-3 col-xs-3 plr-0"> FIO2 (%) </div>
                        <div class="col-md-4 col-sm-7 col-xs-7">{!! Form::text('nasal_hfov_pduration_amp',null,['class'=>' form-control shadow']) !!}</div>
                        <div class="title col-md-2 col-sm-3 col-xs-3 plr-0"> AMP </div>
                        <div class="col-md-4 col-sm-7 col-xs-7">{!! Form::text('nasal_hfov_pduration_hz',null,['class'=>' form-control shadow']) !!}</div>
                        <div class="title col-md-2 col-sm-3 col-xs-3 plr-0"> HZ </div>
                    </td>
                    <td class="text-center overflow-auto">
                        <div class="col-md-12">
                            {!! Form::text('nasal_hfov_pduration',null,['class'=>'custom-form-control form-control shadow']) !!}
                        </div>
                    </td>
                    <td class="col-md-3 col-sm-3 overflow-auto">
                        <div class="col-md-4 col-sm-4 col-xs-4 plr-0 text-center">{!! Form::radio('nasal_hfov_pfailure','N/A') !!}{!! Form::label('N/A','N/A') !!}</div>
                        <div class="col-md-4 col-sm-4 col-xs-4 plr-0 text-center">{!! Form::radio('nasal_hfov_pfailure','yes') !!}{!! Form::label('yes','Yes') !!}</div>
                        <div class="col-md-4 col-sm-4 col-xs-4 plr-0 text-center">{!! Form::radio('nasal_hfov_pfailure','no') !!}{!! Form::label('no','No') !!}</div>
                    </td>
                </tr>
                <tr>
                    <td class="overflow-auto">NASAL HFOV (Secondary)</td>
                    <td class="col-md-4 col-sm-4 col-xs-4 overflow-auto">
                        <div class="col-md-4 col-sm-7 col-xs-7">{!! Form::text('nasal_hfov_ssettings_map',null,['class'=>' form-control shadow']) !!}</div>
                        <div class="title col-md-2 col-sm-3 col-xs-3 plr-0"> MAP </div>
                        <div class="col-md-4 col-sm-7 col-xs-7">{!! Form::text('nasal_hfov_ssettings_fio2',null,['class'=>' form-control shadow']) !!}</div>
                        <div class="title col-md-2 col-sm-3 col-xs-3 plr-0"> FIO2 (%) </div>
                        <div class="col-md-4 col-sm-7 col-xs-7">{!! Form::text('nasal_hfov_ssettings_amp',null,['class'=>' form-control shadow']) !!}</div>
                        <div class="title col-md-2 col-sm-3 col-xs-3 plr-0"> AMP </div>
                        <div class="col-md-4 col-sm-7 col-xs-7">{!! Form::text('nasal_hfov_ssettings_hz',null,['class'=>' form-control shadow']) !!}</div>
                        <div class="title col-md-2 col-sm-3 col-xs-3 plr-0"> HZ </div>
                    </td>
                    <td class="overflow-auto">
                        <div class="col-md-12">
                            {!! Form::text('nasal_hfov_sduration',null,['class'=>'custom-form-control form-control shadow']) !!}
                        </div>
                    </td>
                    <td class="col-md-3 col-sm-3 overflow-auto">
                        <div class="col-md-4 col-sm-4 col-xs-4 plr-0 text-center">{!! Form::radio('nasal_hfov_sfailure','N/A') !!}{!! Form::label('N/A','N/A') !!}</div>
                        <div class="col-md-4 col-sm-4 col-xs-4 plr-0 text-center">{!! Form::radio('nasal_hfov_sfailure','yes') !!}{!! Form::label('yes','Yes') !!}</div>
                        <div class="col-md-4 col-sm-4 col-xs-4 plr-0 text-center">{!! Form::radio('nasal_hfov_sfailure','no') !!}{!! Form::label('no','No') !!}</div>
                    </td>
                </tr>
                <tr>
                    <td class="overflow-auto">MECHANICAL VENTILATION (Conventional / Volume Grantee)</td>
                    <td class="col-md-4 col-sm-4 col-xs-4 overflow-auto">
                        <div class="col-md-4 col-sm-7 col-xs-7">{!! Form::text('mechanical_csettings_vol',null,['class'=>' form-control shadow']) !!}</div>
                        <div class="title col-md-2 col-sm-3 col-xs-3 plr-0"> VOL/ML/KG </div>
                        <div class="col-md-4 col-sm-7 col-xs-7">{!! Form::text('nmechanical_csettings_fio2',null,['class'=>' form-control shadow']) !!}</div>
                        <div class="title col-md-2 col-sm-3 col-xs-3 plr-0"> FIO2 (%) </div>
                    </td>
                    <td class="overflow-auto">
                        <div class="col-md-12">
                            {!! Form::text('mechanical_cduration',null,['class'=>'custom-form-control form-control shadow']) !!}
                        </div>
                    </td>
                    <td class="col-md-3 col-sm-3 overflow-auto">
                        <div class="col-md-4 col-sm-4 col-xs-4 plr-0 text-center">{!! Form::radio('mechanical_cfailure','N/A') !!}{!! Form::label('N/A','N/A') !!}</div>
                        <div class="col-md-4 col-sm-4 col-xs-4 plr-0 text-center">{!! Form::radio('mechanical_cfailure','yes') !!}{!! Form::label('yes','Yes') !!}</div>
                        <div class="col-md-4 col-sm-4 col-xs-4 plr-0 text-center">{!! Form::radio('mechanical_cfailure','no') !!}{!! Form::label('no','No') !!}</div>
                    </td>
                </tr>
                <tr>
                    <td class="overflow-auto">MECHANICAL VENTILATION (Conventional / Pressure Control)</td>
                    <td class="col-md-4 col-sm-4 col-xs-4 overflow-auto">
                        <div class="col-md-4 col-sm-7 col-xs-7">{!! Form::text('mechanical_pressure_map',null,['class'=>' form-control shadow']) !!}</div>
                        <div class="title col-md-2 col-sm-3 col-xs-3 plr-0"> MAP </div>
                        <div class="col-md-4 col-sm-7 col-xs-7">{!! Form::text('mechanical_csettings_fio2',null,['class'=>' form-control shadow']) !!}</div>
                        <div class="title col-md-2 col-sm-3 col-xs-3 plr-0"> FIO2 (%) </div>
                    </td>
                    <td class="overflow-auto">
                        <div class="col-md-12">
                            {!! Form::text('mechanical_pressureduration',null,['class'=>'custom-form-control form-control shadow']) !!}
                        </div>
                    </td>
                    <td class="col-md-3 col-sm-3 overflow-auto">
                        <div class="col-md-4 col-sm-4 col-xs-4 plr-0 text-center">{!! Form::radio('mechanical_pressurefailure','N/A') !!}{!! Form::label('N/A','N/A') !!}</div>
                        <div class="col-md-4 col-sm-4 col-xs-4 plr-0 text-center">{!! Form::radio('mechanical_pressurefailure','yes') !!}{!! Form::label('yes','Yes') !!}</div>
                        <div class="col-md-4 col-sm-4 col-xs-4 plr-0 text-center">{!! Form::radio('mechanical_pressurefailure','no') !!}{!! Form::label('no','No') !!}</div>
                    </td>
                </tr>
                <tr>
                    <td class="overflow-auto">MECHANICAL VENTILATION (HFO) (Primary)</td>
                    <td class="col-md-4 col-sm-4 col-xs-4 overflow-auto">
                        <div class="col-md-4 col-sm-7 col-xs-7">{!! Form::text('mechanical_psettings_map',null,['class'=>' form-control shadow']) !!}</div>
                        <div class="title col-md-2 col-sm-3 col-xs-3 plr-0"> MAP </div>
                        <div class="col-md-4 col-sm-7 col-xs-7">{!! Form::text('mechanical_psettings_fio2',null,['class'=>' form-control shadow']) !!}</div>
                        <div class="title col-md-2 col-sm-3 col-xs-3 plr-0"> FIO2 (%) </div>
                        <div class="col-md-4 col-sm-7 col-xs-7">{!! Form::text('mechanical_psettings_amp',null,['class'=>' form-control shadow']) !!}</div>
                        <div class="title col-md-2 col-sm-3 col-xs-3 plr-0"> AMP </div>
                        <div class="col-md-4 col-sm-7 col-xs-7">{!! Form::text('mechanical_psettings_hz',null,['class'=>' form-control shadow']) !!}</div>
                        <div class="title col-md-2 col-sm-3 col-xs-3 plr-0"> HZ </div>
                    </td>
                    <td class="overflow-auto">
                        <div class="col-md-12">
                            {!! Form::text('mechanical_pduration',null,['class'=>'custom-form-control form-control shadow']) !!}
                        </div>
                    </td>
                    <td class="col-md-3 col-sm-3 overflow-auto">
                        <div class="col-md-4 col-sm-4 col-xs-4 plr-0 text-center">{!! Form::radio('mechanical_pfailure','N/A') !!}{!! Form::label('N/A','N/A') !!}</div>
                        <div class="col-md-4 col-sm-4 col-xs-4 plr-0 text-center">{!! Form::radio('mechanical_pfailure','yes') !!}{!! Form::label('yes','Yes') !!}</div>
                        <div class="col-md-4 col-sm-4 col-xs-4 plr-0 text-center">{!! Form::radio('mechanical_pfailure','no') !!}{!! Form::label('no','No') !!}</div>
                    </td>
                </tr>
                <tr>
                    <td class="overflow-auto">MECHANICAL VENTILATION (HFO) (Rescue after failed conventional)</td>
                    <td class="col-md-4 col-sm-4 col-xs-4 overflow-auto">
                        <div class="col-md-4 col-sm-7 col-xs-7">{!! Form::text('mechanical_rcsettings_map',null,['class'=>' form-control shadow']) !!}</div>
                        <div class="title col-md-2 col-sm-3 col-xs-3 plr-0"> MAP </div>
                        <div class="col-md-4 col-sm-7 col-xs-7">{!! Form::text('mechanical_rcsettings_fio2',null,['class'=>' form-control shadow']) !!}</div>
                        <div class="title col-md-2 col-sm-3 col-xs-3 plr-0"> FIO2 (%) </div>
                        <div class="col-md-4 col-sm-7 col-xs-7">{!! Form::text('mechanical_rcsettings_amp',null,['class'=>' form-control shadow']) !!}</div>
                        <div class="title col-md-2 col-sm-3 col-xs-3 plr-0"> AMP </div>
                        <div class="col-md-4 col-sm-7 col-xs-7">{!! Form::text('mechanical_rcsettings_hz',null,['class'=>' form-control shadow']) !!}</div>
                        <div class="title col-md-2 col-sm-3 col-xs-3 plr-0"> HZ </div>
                    </td>
                    <td class="overflow-auto">
                        <div class="col-md-12">
                            {!! Form::text('mechanical_rcduration',null,['class'=>'custom-form-control form-control shadow']) !!}
                        </div>
                    </td>
                    <td class="col-md-3 col-sm-3 overflow-auto">
                        <div class="col-md-4 col-sm-4 col-xs-4 plr-0 text-center">{!! Form::radio('mechanical_rcfailure','N/A') !!}{!! Form::label('N/A','N/A') !!}</div>
                        <div class="col-md-4 col-sm-4 col-xs-4 plr-0 text-center">{!! Form::radio('mechanical_rcfailure','yes') !!}{!! Form::label('yes','Yes') !!}</div>
                        <div class="col-md-4 col-sm-4 col-xs-4 plr-0 text-center">{!! Form::radio('mechanical_rcfailure','no') !!}{!! Form::label('no','No') !!}</div>
                    </td>
                </tr>
                <tr>
                    <td class="overflow-auto">OXYGEN BY HOOD / PRONGS</td>
                    <td class="col-md-4 col-sm-4 overflow-auto">
                        <div class="col-md-10 col-sm-7 col-xs-7">{!! Form::text('oxygen_prongs_settings_fio2',null,['class'=>' form-control shadow']) !!}</div>
                        <div class="title col-md-2 col-sm-3 col-xs-3 plr-0"> FIO2 (%) </div>
                    </td>
                    <td class="overflow-auto">
                        <div class="col-md-12">
                            {!! Form::text('oxygen_prongs_duration',null,['class'=>'custom-form-control form-control shadow']) !!}
                        </div>
                    </td>
                    <td class="col-md-3 col-sm-3 overflow-auto">
                        <div class="col-md-4 col-sm-4 col-xs-4 plr-0 text-center">{!! Form::radio('oxygen_prongs_failure','N/A') !!}{!! Form::label('N/A','N/A') !!}</div>
                        <div class="col-md-4 col-sm-4 col-xs-4 plr-0 text-center">{!! Form::radio('oxygen_prongs_failure','yes') !!}{!! Form::label('yes','Yes') !!}</div>
                        <div class="col-md-4 col-sm-4 col-xs-4 plr-0 text-center">{!! Form::radio('oxygen_prongs_failure','no') !!}{!! Form::label('no','No') !!}</div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-12 col-sm-12 display-inline-block plr-0">
        <div class="col-md-6 col-sm-8 col-xs-12">{!! Form::label('mvc_total','TOTAL DURATION OF MECHANICAL VENTILATION (Conventional)',['class'=>'title']) !!}</div>
        <div class="col-md-3 col-sm-3 col-xs-9">{!! Form::text('mvc_total',null,['class'=>'form-control shadow']) !!}</div>
        <div class="title col-sm-1 col-xs-3"> (hours) </div>
    </div>
    <div class="col-md-12 col-sm-12 display-inline-block plr-0">
        <div class="col-md-6 col-sm-8 col-xs-12">{!! Form::label('hfov_total','TOTAL DURATION OF MECHANICAL VENTILATION (HFOV)',['class'=>'title']) !!}</div>
        <div class="col-md-3 col-sm-3 col-xs-9">{!! Form::text('hfov_total',null,['class'=>'form-control shadow']) !!}</div>
        <div class="title col-sm-1 col-xs-3"> (hours) </div>
    </div>
    <div class="col-md-12 col-sm-12 display-inline-block plr-0">
        <div class="col-md-6 col-sm-8 col-xs-12">{!! Form::label('hfov_mc_total','TOTAL DURATION OF MECHANICAL VENTILATION (Conventional & HFOV)',['class'=>'title']) !!}</div>
        <div class="col-md-3 col-sm-3 col-xs-9">{!! Form::text('hfov_mc_total',null,['class'=>'form-control shadow']) !!}</div>
        <div class="title col-sm-1 col-xs-3"> (hours) </div>
    </div>
    <div class="col-md-12 col-sm-12 display-inline-block plr-0 border-bottom mb-10">
        <div class="col-md-6 col-sm-8 col-xs-12">{!! Form::label('non_invasive_total','TOTAL DURATION OF NON-INVASIVE VENTILATION COMBINED (O2 prongs / HHFNC / CPAP / NIPPV)',['class'=>'title']) !!}</div>
        <div class="col-md-3 col-sm-3 col-xs-9">{!! Form::text('non_invasive_total',null,['class'=>'form-control shadow']) !!}</div>
        <div class="title col-sm-1 col-xs-3"> (hours) </div>
    </div>
    <div class="col-md-12 col-sm-12 border-bottom mb-10">
        <h4><b><u>SEPSIS</u></b></h4>
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-12 col-sm-12 plr-0">
                <div class="col-md-6 col-sm-6">{!! Form::label('sepsis','SEPSIS',['class'=>'title']) !!}<span class="title"> (Clinical sepsis, Suspect sepsis, Culture positive sepsis) </span> </div>
                <div class="col-md-6 col-sm-6 display-flex plr-0">
                    <div class="col-md-4 col-sm-4 col-xs-4 pl-8">{!! Form::radio('sepsis','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                    <div class="col-md-4 col-sm-4 col-xs-4 pl-10">{!! Form::radio('sepsis','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                    <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('sepsis','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 plr-0">
                <div class="col-md-6 col-sm-6">{!! Form::label('Sclerema','SCLEREMA',['class'=>'title']) !!}</div>
                <div class="col-md-6 col-sm-6 display-flex plr-0">
                    <div class="col-md-4 col-sm-4 col-xs-4 pl-8">{!! Form::radio('sclerema','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                    <div class="col-md-4 col-sm-4 col-xs-4 pl-10">{!! Form::radio('sclerema','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                    <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('sclerema','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 plr-0">
                <div class="col-md-6 col-sm-6">{!! Form::label('Meningitis','MENINGITIS',['class'=>'title']) !!}</div>
                <div class="col-md-6 col-sm-6 display-flex plr-0">
                    <div class="col-md-4 col-sm-4 col-xs-4 pl-8">{!! Form::radio('meningitis','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                    <div class="col-md-4 col-sm-4 col-xs-4 pl-10">{!! Form::radio('meningitis','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                    <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('meningitis','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-6">{!! Form::label('developed_shock','DEVELOPED SHOCK',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-6 display-flex plr-0">
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('developedshock','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('developedshock','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('developedshock','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="col-md-6 plr-0 border-right">
            <div class="col-md-6 col-sm-12">
                <h5><b class="title">TYPE (Tick any)</b></h5>
            </div>
            @php $spesis_type = (isset($baby_basic->spesis_type) && !is_null($baby_basic->spesis_type)) ? json_decode($baby_basic->spesis_type) : array(); @endphp
            @php $spesis_type1 = (!is_null($spesis_type) && in_array('1',$spesis_type)) ? true : false; @endphp
            @php $spesis_type2 = (!is_null($spesis_type) && in_array('2',$spesis_type)) ? true : false; @endphp
            @php $spesis_type3 = (!is_null($spesis_type) && in_array('3',$spesis_type)) ? true : false; @endphp
            <div class="col-md-offset-3 col-md-9 col-sm-offset-6 col-sm-6">
                {!! Form::checkbox('spesis_type[]','1',$spesis_type1) !!}
                {!! Form::label('spesis_type','Fluid responsive',['class'=>'title']) !!}
            </div>
            <div class="col-md-offset-3 col-md-9 col-sm-offset-6 col-sm-6">
                {!! Form::checkbox('spesis_type[]','2',$spesis_type2) !!}
                {!! Form::label('spesis_type','Fluid resistant,catecholamine responsive',['class'=>'title']) !!}
            </div>
            <div class="col-md-offset-3 col-md-9 col-sm-offset-6 col-sm-6">
                {!! Form::checkbox('spesis_type[]','3',$spesis_type3) !!}
                {!! Form::label('spesis_type','Catecholamine resistant',['class'=>'title']) !!}
            </div>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12 plr-0 pt-10">
            <div class="col-md-12 col-sm-12 col-xs-12 plr-0">
                <div class="col-md-5 col-sm-6">{!! Form::label('post_natal_steriod_used','POSTNATAL STERIOD USED',['class'=>'title']) !!}</div>
                <div class="col-md-7 col-sm-6 col-xs-12 plr-0">
                    <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('postnatalsteriodused','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                    <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('postnatalsteriodused','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                    <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('postnatalsteriodused','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 plr-0">
                <div class="col-md-5 col-sm-6">{!! Form::label('Type','STERIOD TYPE',['class'=>'title']) !!}</div>
                <div class="col-md-7 col-sm-6 col-xs-12 plr-0">
                    <div class="col-md-6 col-sm-6 col-xs-6 pr-0">{!! Form::radio('steriod_type','Dexamethasone') !!}{!! Form::label('steriod_type','Dexamethasone',['class'=>'title']) !!}</div>
                    <div class="col-md-6 col-sm-6 col-xs-6 pr-0">{!! Form::radio('steriod_type','Hydrocortisone') !!}{!! Form::label('steriod_type','Hydrocortisone',['class'=>'title']) !!}</div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 plr-0">
                <div class="col-md-5 col-sm-6">{!! Form::label('max_cumulative_dose','MAXIMUM CUMULATIVE DOSE',['class'=>'title']) !!}</div>
                <div class="col-md-3 col-sm-3 col-xs-9">{!! Form::text('max_cumulative_dose',null,['class'=>'form-control shadow']) !!}</div>
                <div class="col-md-4 col-sm-3 col-xs-3 title plr-0"> (per / kg body weight) </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 scroll-x">
        {!! Form::label('blood_culture','BLOOD CULTURE',['class'=>'title']) !!}
        <table class="table responsive-table">
            <thead class="tableborder">
                <tr>
                    <th></th>
                    <th>
                        <center>GRAM POSITIVE</center>
                    </th>
                    <th>
                        <center>GRAM NEGATIVE</center>
                    </th>
                    <th>
                        <center>FUNGUS</center>
                    </th>
                </tr>
            </thead>
            <tbody class="tableborder">
                @for ($i=1; $i<=3; $i++) 
                <tr>
                    <td class="overflow-auto"> @switch($i) @case(1) 1 <sup>st</sup> @break @case(2) 2 <sup>nd</sup> @break @case(3) 3 <sup>rd</sup> @break @default New @endswitch CULTURE </td>
                    <td class="overflow-auto">
                        <div class="downarrow">{!! Form::select('gram_positive_culture'.$i,['N/A'=>'N/A','CONS'=>'CONS','MRSA'=>'MRSA','VRE'=>'VRE','Sterile culture'=>'Sterile culture','Others'=>'Others'],null,['class'=>'custom-form-control form-control shadow']) !!}</div>
                    </td>
                    <td class="overflow-auto">
                        <div class="downarrow">{!! Form::select('gram_negative_culture'.$i,['N/A'=>'N/A','E.Coli'=>'E.Coli','Klebsiella'=>'Klebsiella','Acinetobacter'=>'Acinetobacter','Psrudomonas'=>'Psrudomonas','Sterile culture'=>'Sterile culture','Others'=>'Others'],null,['class'=>'custom-form-control form-control shadow']) !!}</div>
                    </td>
                    <td class="overflow-auto">
                        <div class="downarrow">{!! Form::select('fungus_culture'.$i,['N/A'=>'N/A','Albicans'=>'Albicans','Non albicans'=>'Non albicans','Sterile culture'=>'Sterile culture','Others'=>'Others'],null,['class'=>'custom-form-control form-control shadow']) !!}</div>
                    </td>
                </tr>
                @endfor 
            </tbody>
        </table>
    </div>
    <div class="col-md-12 display-inline-block full-width plr-0 border-bottom mb-10">
        <div class="col-md-3 col-sm-6">{!! Form::label('ext_spectrum','EXTENDED-SPECTRUM CEPHALOSPORINS',['class'=>'title']) !!}</div>
        <div class="col-md-3 col-sm-6 display-flex plr-0">
            <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('ext_spectrum','S') !!}{!! Form::label('s','S',['class'=>'title']) !!}</div>
            <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('ext_spectrum','R') !!}{!! Form::label('r','R',['class'=>'title']) !!}</div>
        </div>
    </div>
    <div class="col-md-12 display-inline-block full-width plr-0 border-bottom mb-10">
        <div class="col-md-3 col-sm-6">{!! Form::label('carbapenems','CARBAPENEMS',['class'=>'title']) !!}</div>
        <div class="col-md-3 col-sm-6 display-flex plr-0">
            <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('carbapenems','S') !!}{!! Form::label('s','S',['class'=>'title']) !!}</div>
            <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('carbapenems','R') !!}{!! Form::label('r','R',['class'=>'title']) !!}</div>
        </div>
    </div>
    <div class="col-md-12 display-inline-block full-width plr-0 border-bottom mb-10">
        <div class="col-md-3 col-sm-6">{!! Form::label('aminoglycosides','AMINOGLYCOSIDES',['class'=>'title']) !!}</div>
        <div class="col-md-3 col-sm-6 display-flex plr-0">
            <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('aminoglycosides','S') !!}{!! Form::label('s','S',['class'=>'title']) !!}</div>
            <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('aminoglycosides','R') !!}{!! Form::label('r','R',['class'=>'title']) !!}</div>
        </div>
    </div>
    <div class="col-md-12 display-inline-block full-width plr-0 border-bottom mb-10">
        <div class="col-md-3 col-sm-6">{!! Form::label('fluoroquinolones','FLUOROQUINOLONES',['class'=>'title']) !!}</div>
        <div class="col-md-3 col-sm-6 display-flex plr-0">
            <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('fluoroquinolones','S') !!}{!! Form::label('s','S',['class'=>'title']) !!}</div>
            <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('fluoroquinolones','R') !!}{!! Form::label('r','R',['class'=>'title']) !!}</div>
        </div>
    </div>
    <div class="col-md-12 display-inline-block full-width plr-0 border-bottom mb-10">
        <div class="col-md-3 col-sm-6">{!! Form::label('piperacillin_tazobactam','PIPERACILLIN-TAZOBACTAM',['class'=>'title']) !!}</div>
        <div class="col-md-3 col-sm-6 display-flex plr-0">
            <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('piperacillin_tazobactam','S') !!}{!! Form::label('s','S',['class'=>'title']) !!}</div>
            <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('piperacillin_tazobactam','R') !!}{!! Form::label('r','R',['class'=>'title']) !!}</div>
        </div>
    </div>
    <div class="col-md-12 display-inline-block full-width plr-0 border-bottom mb-10">
        <div class="col-md-3 col-sm-6">{!! Form::label('tetracycline','Tetracycline',['class'=>'title']) !!}</div>
        <div class="col-md-3 col-sm-6 display-flex plr-0">
            <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('tetracycline','S') !!}{!! Form::label('s','S',['class'=>'title']) !!}</div>
            <div class="col-md-4 col-sm-3 col-xs-4">{!! Form::radio('tetracycline','R') !!}{!! Form::label('r','R',['class'=>'title']) !!}</div>
        </div>
    </div>
    <div class="col-md-12 display-inline-block plr-0 border-bottom mb-10">
        <div class="col-md-12 col-sm-12 display-flex plr-0">
            <div class="col-md-3 col-sm-6 col-xs-4">{!! Form::label('first_antibotics','FIRST LINE ANTIBOTICS',['class'=>'title']) !!}</div>
            <div class="col-md-3 col-sm-3 col-xs-6">{!! Form::text('first_antibotics',null,['class'=>'form-control shadow']) !!}</div>
            <div class="title">(Duration)</div>
        </div>
        <div class="col-md-12 col-sm-12 display-flex plr-0">
            <div class="col-md-3 col-sm-6 col-xs-4">{!! Form::label('second_antibotics','SECOND LINE ANTIBOTICS',['class'=>'title']) !!}</div>
            <div class="col-md-3 col-sm-3 col-xs-6">{!! Form::text('second_antibotics',null,['class'=>'form-control shadow']) !!}</div>
            <div class="title">(Duration)</div>
        </div>
        <div class="col-md-12 col-sm-12 display-flex plr-0">
            <div class="col-md-3 col-sm-6 col-xs-4">{!! Form::label('third_antibotics','THIRD LINE ANTIBOTICS',['class'=>'title']) !!}</div>
            <div class="col-md-3 col-sm-3 col-xs-6">{!! Form::text('third_antibotics',null,['class'=>'form-control shadow']) !!}</div>
            <div class="title">(Duration)</div>
        </div>
        <div class="col-md-12 col-sm-12 display-flex plr-0">
            <div class="col-md-3 col-sm-6 col-xs-4">{!! Form::label('total_antibiotics_days','TOTAL DURATION OD ANTIBIOTICS IN DAYS',['class'=>'title']) !!}</div>
            <div class="col-md-3 col-sm-3 col-xs-6">{!! Form::text('total_antibiotics_days',null,['class'=>'form-control shadow']) !!}</div>
        </div>
    </div>
    <div class="col-md-12 display-inline-block plr-0 border-bottom mb-10">
        <div class="col-md-6 col-sm-6 plr-0">
            <h4 class="col-md-1 col-sm-1 col-xs-2"><u><b>EONS</b></u></h4>
            <span class="col-md-5 col-sm-7 col-xs-7 tick">(Tick one out of three)</span> 
        </div>
        <div class="col-md-12 col-sm-12">
            <div class="col-md-6 col-sm-6">{!! Form::label('eonsclinicalsepsis','CLINICAL SEPSIS : (Clinical course +, screen neg, culture neg) :',['class'=>'title']) !!}</div>
            <div class="col-md-6 col-sm-6 display-flex plr-0">
                <div class="col-md-2 col-sm-4 col-xs-4">{!! Form::radio('eonsclinicalsepsis','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                <div class="col-md-2 col-sm-4 col-xs-4">{!! Form::radio('eonsclinicalsepsis','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                <div class="col-md-2 col-sm-4 col-xs-4">{!! Form::radio('eonsclinicalsepsis','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12">
            <div class="col-md-6 col-sm-6">{!! Form::label('eonssuspectsepsis','SUSPECT SEPSIS : (Clinical course +, screen pos, culture neg) :',['class'=>'title']) !!}</div>
            <div class="col-md-6 col-sm-6 display-flex plr-0">
                <div class="col-md-2 col-sm-4 col-xs-4">{!! Form::radio('eonssuspectsepsis','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                <div class="col-md-2 col-sm-4 col-xs-4">{!! Form::radio('eonssuspectsepsis','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                <div class="col-md-2 col-sm-4 col-xs-4">{!! Form::radio('eonssuspectsepsis','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12">
            <div class="col-md-6 col-sm-6">{!! Form::label('eonsculturepositive_sepsis','CULTURE POSITIVE SEPSIS : (Clinical course +, screen neg /pos , culture pos) :',['class'=>'title']) !!}</div>
            <div class="col-md-6 col-sm-6 display-flex plr-0">
                <div class="col-md-2 col-sm-4 col-xs-4">{!! Form::radio('eonsculturepositive_sepsis','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                <div class="col-md-2 col-sm-4 col-xs-4">{!! Form::radio('eonsculturepositive_sepsis','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                <div class="col-md-2 col-sm-4 col-xs-4">{!! Form::radio('eonsculturepositive_sepsis','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
            </div>
        </div>
    </div>
    <div class="col-md-12 display-inline-block plr-0 border-bottom mb-10">
        <div class="col-md-6 col-sm-6 plr-0">
            <h4 class="col-md-1 col-sm-1 col-xs-2"><u><b>LONS</b></u></h4>
            <span class="col-md-5 col-sm-7 col-xs-7 tick">(Tick one out of three)</span> 
        </div>
        <div class="col-md-12 col-sm-12">
            <div class="col-md-6 col-sm-6">{!! Form::label('lonsclinical_sepsis','CLINICAL SEPSIS : (Clinical course +, screen neg, culture neg) :',['class'=>'title']) !!}</div>
            <div class="col-md-6 col-sm-6 display-flex plr-0">
                <div class="col-md-2 col-sm-4 col-xs-4">{!! Form::radio('lonsclinical_sepsis','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                <div class="col-md-2 col-sm-4 col-xs-4">{!! Form::radio('lonsclinical_sepsis','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                <div class="col-md-2 col-sm-4 col-xs-4">{!! Form::radio('lonsclinical_sepsis','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12">
            <div class="col-md-6 col-sm-6">{!! Form::label('lonssuspect_sepsis','SUSPECT SEPSIS :(Clinical course +, screen pos, culture neg) :',['class'=>'title']) !!}</div>
            <div class="col-md-6 col-sm-6 display-flex plr-0">
                <div class="col-md-2 col-sm-4 col-xs-4">{!! Form::radio('lonssuspect_sepsis','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                <div class="col-md-2 col-sm-4 col-xs-4">{!! Form::radio('lonssuspect_sepsis','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                <div class="col-md-2 col-sm-4 col-xs-4">{!! Form::radio('lonssuspect_sepsis','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12">
            <div class="col-md-6 col-sm-6">{!! Form::label('lonsculture_sepsis','CULTURE POSITIVE SEPSIS: (Clinical course +, screen neg /pos , culture pos) :',['class'=>'title']) !!}</div>
            <div class="col-md-6 col-sm-6 display-flex plr-0">
                <div class="col-md-2 col-sm-4 col-xs-4">{!! Form::radio('lonsculture_sepsis','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                <div class="col-md-2 col-sm-4 col-xs-4">{!! Form::radio('lonsculture_sepsis','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                <div class="col-md-2 col-sm-4 col-xs-4">{!! Form::radio('lonsculture_sepsis','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12">
            <div class="col-md-6 col-sm-6 col-sm-9">{!! Form::label('cumulative_antibiotic','CUMULATIVE DURATION OF ANTIBIOTIC THERAPY',['class'=>'title']) !!}</div>
            <div class="col-md-3 col-sm-3">{!! Form::text('cumulative_antibiotic',null,['class'=>'form-control shadow mlcumulative']) !!}</div>
        </div>
        <div class="col-md-12 col-sm-12">
            <div class="col-md-6 col-sm-6">{!! Form::label('anti_prophylaxis','ANTIFUNGAL PROPHYLAXIS',['class'=>'title']) !!}</div>
            <div class="col-md-6 col-sm-6 display-flex plr-0">
                <div class="col-md-2 col-sm-4 col-xs-4">{!! Form::radio('anti_prophylaxis','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                <div class="col-md-2 col-sm-4 col-xs-4">{!! Form::radio('anti_prophylaxis','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                <div class="col-md-2 col-sm-4 col-xs-4">{!! Form::radio('anti_prophylaxis','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
            </div>
        </div>
    </div>
</div>
