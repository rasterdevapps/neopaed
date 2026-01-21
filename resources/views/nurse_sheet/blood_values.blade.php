<div class="col-md-12 pt-0  plr-0">
    <div class="col-md-12 col-lg-6 blood_gas_type_full">
        <div class="mt-10 widget box">
            <div class="widget-header">
                <h4><i class="fa fa-reorder"></i> </h4>
            </div>
            <div class="widget-content">
                <div class="form-group">
                    {!! Form::label('blood_gas_type','Type Of Blood Gas:') !!}
                    {!! Form::select('blood_gas_type',[''=>'N/A','Not done'=>'Not done','Arterial'=>'Arterial (A)','Venous'=>'Venous (V)','Capillary'=>'Capillary (C)','Not indicated'=>'Not indicated'],'',['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('last_bg_time','Last BG at:') !!}
                    {!! Form::text('last_bg_time',null,['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('interface_blood_gas_bilirubin','Bilirubin:') !!}
                    <div class="interface_blood_gas_bilirubin"></div>
                </div>
                <div class="form-group">
                    {!! Form::label('blood_sugar', 'Blood Sugar (mg/dl):') !!}
                    <div class="blood_sugar"></div>
                </div>
                <div class="form-group">
                    {!! Form::label('interface_blood_gas_ph','pH:') !!}
                    <div class="interface_blood_gas_ph"></div>
                </div>
                <div class="form-group">
                    {!! Form::label('interface_blood_gas_pao2', 'Pao2:') !!}
                    <div class="interface_blood_gas_pao2"></div>
                </div>
                <div class="form-group">
                    {!! Form::label('tcpo2', 'TcPO2:') !!}
                    <div class="tcpo2"></div>
                </div>
                <div class="form-group">
                    {!! Form::label('interface_blood_gas_paco2', 'PaCo2:') !!}
                    <div class="interface_blood_gas_paco2"></div>
                </div>
                <div class="form-group">
                    {!! Form::label('tcpco2', 'TcPCO2:') !!}
                    <div class="tcpco2"></div>
                </div>
                <div class="form-group">
                    {!! Form::label('interface_blood_gas_etco2', 'ETCO2:') !!}
                    <div class="interface_blood_gas_etco2"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-6 blood_gas_type_disable">
        <div class="mt-10 widget box">
            <div class="widget-header">
                <h4><i class="fa fa-reorder"></i> </h4>
            </div>
            <div class="widget-content">
                <div class="form-group">
                    {!! Form::label('interface_blood_gas_hco3', 'HCO3:') !!}
                    <div class="interface_blood_gas_hco3"></div>
                </div>
                <div class="form-group">
                    {!! Form::label('interface_blood_gas_be','BE:') !!}
                    <div class="interface_blood_gas_be"></div>
                </div>
                <div class="form-group">
                    {!! Form::label('interface_blood_gas_na','Na (sodium) (mmol/L):') !!}
                    <div class="interface_blood_gas_na"></div>
                </div>
                <div class="form-group">
                    {!! Form::label('interface_blood_gas_k','K (potassium) (mmol/L):') !!}
                    <div class="interface_blood_gas_k"></div>
                </div>
                <div class="form-group">
                    {!! Form::label('interface_blood_gas_cl','cl (Chloride) (mmol/L):') !!}
                    <div class="interface_blood_gas_cl"></div>
                </div>
                <div class="form-group">
                    {!! Form::label('interface_blood_gas_hb','HB (g/dL):') !!}
                    <div class="interface_blood_gas_hb"></div>
                </div>
                <div class="form-group">
                    {!! Form::label('interface_blood_gas_pcv','PCV (%):') !!}
                    <div class="interface_blood_gas_pcv"></div>
                </div>
                <div class="form-group">
                    {!! Form::label('interface_blood_gas_lactate','Lactate:') !!}
                    <div class="interface_blood_gas_lactate"></div>
                </div>
                <div class="form-group">
                    {!! Form::label('interface_blood_gas_methemoglobin','Methemoglobin:') !!}
                    <div class="interface_blood_gas_methemoglobin"></div>
                </div>
                <div class="form-group">
                    {!! Form::label('interface_blood_gas_calcium','Calcium (8.5-10.5 mg/dl):') !!}
                    <div class="interface_blood_gas_calcium"></div>
                </div>
            </div>
        </div>
    </div>
</div>
