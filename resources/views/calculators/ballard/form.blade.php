@php
    $site_url = url('/').'/public';
@endphp
<div role="tabpanel" class="tab-pane active" id="basicform">
    <div class="col-md-6">
        <div class="mt-10 widget box">
            <div class="widget-header">
                <h4><i class="fa fa-reorder"></i> </h4>
            </div>
            <div class="widget-content">
                {!! Form::hidden('MotherId') !!}
                {!! Form::hidden('BabyId') !!}                            
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('BabyName','Baby Name:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('BabyName',null,['class'=>'form-control','readonly']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('BMrNo', Lang::get('home.mrn').':') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('BMrNo',null,['class'=>'form-control','readonly']) !!}
                    </div>
                </div>                            
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('DOB','DOB:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('DOB',null,['class'=>'form-control','readonly']) !!}
                    </div>
                </div>                                          
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control mt-0">
                        {!! Form::label('BirthWeight','Birth Weight (In Gms):') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('BirthWeight',null,['class'=>'form-control','readonly']) !!}
                    </div>
                </div>          
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                        {!! Form::label('Gestation','Gestation:') !!}
                    </div>
                    <div class="col-md-9 custom-input clear-xs">
                        <div class="row col-md-12 display-flex">
                            <div>
                                <small>(In Weeks)</small>
                                {!! Form::text('g_weeks',@$gestation->g_weeks,['class'=>'form-control','readonly']) !!}
                            </div>
                            <div class="inbeween_two_fields">
                                <span>+</span>
                            </div>
                            <div>
                                <small>(In Days)</small>
                                {!! Form::text('g_days',@$gestation->g_days,['class'=>'form-control','readonly']) !!}
                            </div>
                        </div>
                    </div>
                </div>   
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('Sex','Sex:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::select('Sex',['Male'=>'Male','Female'=>'Female','Indeterminate'=>'Indeterminate'],null,['class'=>'form-control','disabled']) !!}
                    </div>
                </div>                     
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('TOB','Time of Birth:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('TOB',null,['class'=>'form-control','readonly']) !!}
                    </div>
                </div>                
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mt-10 widget box">
            <div class="widget-header">
                <h4><i class="fa fa-reorder"></i> </h4>
            </div>
            <div class="widget-content">
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('TestDate','Date:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('TestDate',null,['class'=>'form-control datepicker', 'readonly']) !!}
                    </div>
                </div>                         
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('TestTime','Time:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('TestTime',null,['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control mt-0">
                        {!! Form::label('AssessmentAge','Age of Assessment:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('AssessmentAge',null,['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('Examiner','Examiner Name:', ['class'=>'required-label']) !!}
                        <a href="javascript:void(0)" class="add_master_data" data-modal_header="Examiner Name" data-destination_elements="Examiner" data-option_value="id" data-option_text="Name" data-mas_table="mas_doctors">
                            <i class="fa fa-info-circle bs-tooltip add-neo-consultant" data-placement="right" data-original-title="Add Doctor"></i>
                        </a>
                    </div>
                    <div class="col-md-9 custom-input custom-select">
                        {!! Form::select('Examiner',[''=>'N/A']+$doctor_master,null,['class'=>'form-control']) !!}
                    </div>
                </div>                        
            </div>
        </div>
    </div>
</div>
<div role="tabpanel" class="tab-pane" id="neuroform">
    <div class="mt-10 widget box row mx-0">
        <div class="widget-header">
            <h4><i class="fa fa-reorder"></i> </h4>
        </div>
        <div class="widget-content">
            <div class="col-md-8">
                <table cellpadding="5" border="1" class="score-form">
                    <thead>
                        <tr>
                            <th rowspan="2">Neuromuscular Maturity Sign</th>
                            <th colspan="8" align="center">Score</th>
                        </tr>
                        <tr>
                            <th>-1</th>
                            <th>0</th>
                            <th>1</th>
                            <th>2</th>                                    	
                            <th>3</th>                                    	
                            <th>4</th>                                    	
                            <th>5</th>
                            <th></th>
                        </tr>                                      
                    </thead>
                    <tbody>
                        <tr>
                            <td>Posture</td>
                            <td>
                                <div class="score-select Posture @if(isset($results->Posture) && $results->Posture == -1) active @endif" id="Posture-1" onClick="UpdateScore(-1,'Posture');">
                                </div>
                            </td>
                            <td>
                                <div class="score-select Posture @if(isset($results->Posture) && is_numeric($results->Posture) && $results->Posture == 0) active @endif" id="Posture0" onClick="UpdateScore(0,'Posture');">
                                    <img src="{{ url('/') }}/public/img/neurological_maturity/posture/0.svg" />
                                </div>
                            </td>
                            <td>
                                <div class="score-select Posture @if(isset($results->Posture) && $results->Posture == 1) active @endif" id="Posture1" onClick="UpdateScore(1,'Posture');">
                                    <img src="{{ url('/') }}/public/img/neurological_maturity/posture/1.svg" />                                    
                                </div>
                            </td>
                            <td>
                                <div class="score-select Posture @if(isset($results->Posture) && $results->Posture == 2) active @endif" id="Posture2" onClick="UpdateScore(2,'Posture');">
                                    <img src="{{ url('/') }}/public/img/neurological_maturity/posture/2.svg" />                                   
                                    
                                </div>
                            </td>                                    	
                            <td>
                                <div class="score-select Posture @if(isset($results->Posture) && $results->Posture == 3) active @endif" id="Posture3" onClick="UpdateScore(3,'Posture');">
                                    <img src="{{ url('/') }}/public/img/neurological_maturity/posture/3.svg" />
                                </div>
                            </td>                                    	
                            <td>
                                <div class="score-select Posture @if(isset($results->Posture) && $results->Posture == 4) active @endif" id="Posture4" onClick="UpdateScore(4,'Posture');">
                                    <img src="{{ url('/') }}/public/img/neurological_maturity/posture/4.svg" />
                                </div>
                            </td>                                    	
                            <td class="empty-cell"></td>
                            <td>{!! Form::text('Posture',null,['readonly']) !!}</td>                                        
                        </tr>
                        <tr>
                            <td>Square Window(Wrist)</td>
                            <td>
                                <div class="score-select SquareWindow @if(isset($results->SquareWindow) && $results->SquareWindow == -1) active @endif" id="SquareWindow-1" onClick="UpdateScore(-1,'SquareWindow');">
                                    <img src="{{ url('/') }}/public/img/neurological_maturity/square_window/-1.svg" />
                                </div>
                            </td>
                            <td>
                                <div class="score-select SquareWindow @if(isset($results->SquareWindow) && is_numeric($results->SquareWindow) && $results->SquareWindow == 0) active @endif" id="SquareWindow0" onClick="UpdateScore(0,'SquareWindow');">
                                    <img src="{{ url('/') }}/public/img/neurological_maturity/square_window/0.svg" />
                                </div>
                            </td>
                            <td>
                                <div class="score-select SquareWindow @if(isset($results->SquareWindow) && $results->SquareWindow == 1) active @endif" id="SquareWindow1" onClick="UpdateScore(1,'SquareWindow');">
                                    <img src="{{ url('/') }}/public/img/neurological_maturity/square_window/1.svg" />
                                </div>
                            </td>                                    	
                            <td>
                                <div class="score-select SquareWindow @if(isset($results->SquareWindow) && $results->SquareWindow == 2) active @endif" id="SquareWindow2" onClick="UpdateScore(2,'SquareWindow');">
                                    <img src="{{ url('/') }}/public/img/neurological_maturity/square_window/2.svg" />
                                </div>
                            </td>                                    	
                            <td>
                                <div class="score-select SquareWindow @if(isset($results->SquareWindow) && $results->SquareWindow == 3) active @endif" id="SquareWindow3" onClick="UpdateScore(3,'SquareWindow');">
                                    <img src="{{ url('/') }}/public/img/neurological_maturity/square_window/3.svg" />
                                </div>
                            </td>                                    	
                            <td>
                                <div class="score-select SquareWindow @if(isset($results->SquareWindow) && $results->SquareWindow == 4) active @endif" id="SquareWindow4" onClick="UpdateScore(4,'SquareWindow');">
                                    <img src="{{ url('/') }}/public/img/neurological_maturity/square_window/4.svg" />
                                </div>
                            </td>                                    	
                            <td class="empty-cell"></td>
                            <td>{!! Form::text('SquareWindow',null,['readonly']) !!}</td>
                        </tr>
                        <tr>
                            <td>Arm Recoil</td>
                            <td>
                                <div class="score-select ArmRecoil @if(isset($results->ArmRecoil) && $results->ArmRecoil == -1) active @endif" id="ArmRecoil-1" onClick="UpdateScore(-1,'ArmRecoil');">
                                </div>
                            </td>
                            <td>
                                <div class="score-select ArmRecoil @if(isset($results->ArmRecoil) && is_numeric($results->ArmRecoil) && $results->ArmRecoil == 0) active @endif" id="ArmRecoil0" onClick="UpdateScore(0,'ArmRecoil');">
                                    <img src="{{ url('/') }}/public/img/neurological_maturity/arm_recoil/0.svg" />
                                </div>
                            </td>
                            <td>
                                <div class="score-select ArmRecoil @if(isset($results->ArmRecoil) && $results->ArmRecoil == 1) active @endif" id="ArmRecoil1" onClick="UpdateScore(1,'ArmRecoil');">
                                    <img src="{{ url('/') }}/public/img/neurological_maturity/arm_recoil/1.svg" />
                                </div>
                            </td>                                    	
                            <td>
                                <div class="score-select ArmRecoil @if(isset($results->ArmRecoil) && $results->ArmRecoil == 2) active @endif" id="ArmRecoil2" onClick="UpdateScore(2,'ArmRecoil');">
                                    <img src="{{ url('/') }}/public/img/neurological_maturity/arm_recoil/2.svg" />
                                </div>
                            </td>                                    	
                            <td>
                                <div class="score-select ArmRecoil @if(isset($results->ArmRecoil) && $results->ArmRecoil == 3) active @endif" id="ArmRecoil3" onClick="UpdateScore(3,'ArmRecoil');">
                                    <img src="{{ url('/') }}/public/img/neurological_maturity/arm_recoil/3.svg" />
                                </div>
                            </td>                                    	
                            <td>
                                <div class="score-select ArmRecoil @if(isset($results->ArmRecoil) && $results->ArmRecoil == 4) active @endif" id="ArmRecoil4" onClick="UpdateScore(4,'ArmRecoil');">
                                    <img src="{{ url('/') }}/public/img/neurological_maturity/arm_recoil/4.svg" />
                                </div>
                            </td>                                    	
                            <td class="empty-cell"></td>
                            <td>{!! Form::text('ArmRecoil',null,['readonly']) !!}</td>
                        </tr>
                        <tr>
                            <td>Pop liteal Angle</td>
                            <td>
                                <div class="score-select PoplitealAngle @if(isset($results->PoplitealAngle) && $results->PoplitealAngle == -1) active @endif" id="PoplitealAngle-1" onClick="UpdateScore(-1,'PoplitealAngle');">
                                    <img src="{{ url('/') }}/public/img/neurological_maturity/popliteal_angle/-1.svg" />
                                </div>
                            </td>
                            <td>
                                <div class="score-select PoplitealAngle @if(isset($results->PoplitealAngle) && is_numeric($results->PoplitealAngle) && $results->PoplitealAngle == 0) active @endif" id="PoplitealAngle0" onClick="UpdateScore(0,'PoplitealAngle');">
                                    <img src="{{ url('/') }}/public/img/neurological_maturity/popliteal_angle/0.svg" />
                                </div>
                            </td>
                            <td>
                                <div class="score-select PoplitealAngle @if(isset($results->PoplitealAngle) && $results->PoplitealAngle == 1) active @endif" id="PoplitealAngle1" onClick="UpdateScore(1,'PoplitealAngle');">
                                    <img src="{{ url('/') }}/public/img/neurological_maturity/popliteal_angle/1.svg" />
                                </div>
                            </td>                                    
                            <td>
                                <div class="score-select PoplitealAngle @if(isset($results->PoplitealAngle) && $results->PoplitealAngle == 2) active @endif" id="PoplitealAngle2" onClick="UpdateScore(2,'PoplitealAngle');">
                                    <img src="{{ url('/') }}/public/img/neurological_maturity/popliteal_angle/2.svg" />
                                </div>
                            </td>                                    	
                            <td>
                                <div class="score-select PoplitealAngle @if(isset($results->PoplitealAngle) && $results->PoplitealAngle == 3) active @endif" id="PoplitealAngle3" onClick="UpdateScore(3,'PoplitealAngle');">
                                    <img src="{{ url('/') }}/public/img/neurological_maturity/popliteal_angle/3.svg" />
                                </div>
                            </td>                                    	
                            <td>
                                <div class="score-select PoplitealAngle @if(isset($results->PoplitealAngle) && $results->PoplitealAngle == 4) active @endif" id="PoplitealAngle4" onClick="UpdateScore(4,'PoplitealAngle');">
                                    <img src="{{ url('/') }}/public/img/neurological_maturity/popliteal_angle/4.svg" />
                                </div>
                            </td>                                    	
                            <td>
                                <div class="score-select PoplitealAngle @if(isset($results->PoplitealAngle) && $results->PoplitealAngle == 5) active @endif" id="PoplitealAngle5" onClick="UpdateScore(5,'PoplitealAngle');">
                                    <img src="{{ url('/') }}/public/img/neurological_maturity/popliteal_angle/5.svg" />
                                </div>
                            </td>
                            <td>{!! Form::text('PoplitealAngle',null,['readonly']) !!}</td>
                        </tr>
                        <tr>
                            <td>Scarf Sign</td>
                            <td>
                                <div class="score-select ScarfSign @if(isset($results->ScarfSign) && $results->ScarfSign == -1) active @endif" id="ScarfSign-1" onClick="UpdateScore(-1,'ScarfSign');">
                                    <img src="{{ url('/') }}/public/img/neurological_maturity/scarf_sign/-1.svg" />
                                </div>
                            </td>
                            <td>
                                <div class="score-select ScarfSign @if(isset($results->ScarfSign) && is_numeric($results->ScarfSign) && $results->ScarfSign == 0) active @endif" id="ScarfSign0" onClick="UpdateScore(0,'ScarfSign');">
                                    <img src="{{ url('/') }}/public/img/neurological_maturity/scarf_sign/0.svg" />
                                </div>
                            </td>
                            <td>
                                <div class="score-select ScarfSign @if(isset($results->ScarfSign) && $results->ScarfSign == 1) active @endif" id="ScarfSign1" onClick="UpdateScore(1,'ScarfSign');">
                                    <img src="{{ url('/') }}/public/img/neurological_maturity/scarf_sign/1.svg" />
                                </div>
                            </td>                                    	
                            <td>
                                <div class="score-select ScarfSign @if(isset($results->ScarfSign) && $results->ScarfSign == 2) active @endif" id="ScarfSign2" onClick="UpdateScore(2,'ScarfSign');">
                                    <img src="{{ url('/') }}/public/img/neurological_maturity/scarf_sign/2.svg" />
                                </div>
                            </td>                                    	
                            <td>
                                <div class="score-select ScarfSign @if(isset($results->ScarfSign) && $results->ScarfSign == 3) active @endif" id="ScarfSign3" onClick="UpdateScore(3,'ScarfSign');">
                                    <img src="{{ url('/') }}/public/img/neurological_maturity/scarf_sign/3.svg" />
                                </div>
                            </td>                                    	
                            <td>
                                <div class="score-select ScarfSign @if(isset($results->ScarfSign) && $results->ScarfSign == 4) active @endif" id="ScarfSign4"onClick="UpdateScore(4,'ScarfSign');">
                                    <img src="{{ url('/') }}/public/img/neurological_maturity/scarf_sign/4.svg" />
                                </div>
                            </td>                                    	
                            <td class="empty-cell"></td>
                            <td>{!! Form::text('ScarfSign',null,['readonly']) !!}</td>
                        </tr>
                        <tr>
                            <td>Heel To Ear</td>
                            <td>
                                <div class="score-select HeelEar @if(isset($results->HeelEar) && $results->HeelEar == -1) active @endif" id="HeelEar-1" onClick="UpdateScore(-1,'HeelEar');">
                                    <img src="{{ url('/') }}/public/img/neurological_maturity/heel_to_ear/-1.svg" />
                                </div>
                            </td>
                            <td>
                                <div class="score-select HeelEar @if(isset($results->HeelEar) && is_numeric($results->HeelEar) && $results->HeelEar == 0) active @endif" id="HeelEar0" onClick="UpdateScore(0,'HeelEar');">
                                    <img src="{{ url('/') }}/public/img/neurological_maturity/heel_to_ear/0.svg" />
                                </div>
                            </td>
                            <td>
                                <div class="score-select HeelEar @if(isset($results->HeelEar) && $results->HeelEar == 1) active @endif" id="HeelEar1" onClick="UpdateScore(1,'HeelEar');">
                                    <img src="{{ url('/') }}/public/img/neurological_maturity/heel_to_ear/1.svg" />
                                </div>
                            </td>                                    	
                            <td>
                                <div class="score-select HeelEar @if(isset($results->HeelEar) && $results->HeelEar == 2) active @endif" id="HeelEar2" onClick="UpdateScore(2,'HeelEar');">
                                    <img src="{{ url('/') }}/public/img/neurological_maturity/heel_to_ear/2.svg" />
                                </div>
                            </td>                                   
                            <td>
                                <div class="score-select HeelEar @if(isset($results->HeelEar) && $results->HeelEar == 3) active @endif" id="HeelEar3" onClick="UpdateScore(3,'HeelEar');">
                                    <img src="{{ url('/') }}/public/img/neurological_maturity/heel_to_ear/3.svg" />
                                </div>
                            </td>                                   
                            <td>
                                <div class="score-select HeelEar @if(isset($results->HeelEar) && $results->HeelEar == 4) active @endif" id="HeelEar4" onClick="UpdateScore(4,'HeelEar');">
                                    <img src="{{ url('/') }}/public/img/neurological_maturity/heel_to_ear/4.svg" />
                                </div>
                            </td>                                   
                            <td class="empty-cell"></td>
                            <td>{!! Form::text('HeelEar',null,['readonly']) !!}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div role="tabpanel" class="tab-pane" id="physcialform">
    <div class="mt-10 widget box">
        <div class="widget-header">
            <h4><i class="fa fa-reorder"></i> </h4>
        </div>
        <div class="widget-content">
            <div class="form-group overflow-auto">
                <table cellpadding="5" border="1" class="score-form">
                    <thead>
                        <tr>
                            <th rowspan="2">Physical Maturity Sign</th>
                            <th colspan="8" align="center">Score</th>
                        </tr>
                        <tr>
                            <th>-1</th>
                            <th>0</th>
                            <th>1</th>
                            <th>2</th>                                    	
                            <th>3</th>                                    	
                            <th>4</th>                                    	
                            <th>5</th>
                            <th></th>
                        </tr>  
                    </thead>
                    <tbody>
                        <tr>
                            <td>Skin</td>
                            <td>
                                <div class="score-select Skin @if(isset($results->Skin) && $results->Skin == -1) active @endif" id="Skin-1" onClick="UpdateScore(-1,'Skin');">Sticky, friable, transparent</div>
                            </td>
                            <td>
                                <div class="score-select Skin @if(isset($results->Skin) && is_numeric($results->Skin) && $results->Skin == 0) active @endif" id="Skin0" onClick="UpdateScore(0,'Skin');">Gelatinous, red, translucent</div>
                            </td>
                            <td>
                                <div class="score-select Skin @if(isset($results->Skin) && $results->Skin == 1) active @endif" id="Skin1" onClick="UpdateScore(1,'Skin');">Smooth, pink; visible veins</div>
                            </td>
                            <td>
                                <div class="score-select Skin @if(isset($results->Skin) && $results->Skin == 2) active @endif" id="Skin2" onClick="UpdateScore(2,'Skin');">Superficial peeling and/or rash; few veins</div>
                            </td>                                    	
                            <td>
                                <div class="score-select Skin @if(isset($results->Skin) && $results->Skin == 3) active @endif" id="Skin3" onClick="UpdateScore(3,'Skin');">Cracking, pale areas; rare veins</div>
                            </td>                                    	
                            <td>
                                <div class="score-select Skin @if(isset($results->Skin) && $results->Skin == 4) active @endif" id="Skin4" onClick="UpdateScore(4,'Skin');">Parchment, deep cracking; no vessels</div>
                            </td>                                    	
                            <td>
                                <div class="score-select Skin @if(isset($results->Skin) && $results->Skin == 5) active @endif" id="Skin5" onClick="UpdateScore(5,'Skin');">Leathery, cracked, wrinkled</div>
                            </td>
                            <td>{!! Form::text('Skin',null,['readonly']) !!}</td>                                        
                        </tr>
                        <tr>
                            <td>Lanugo</td>
                            <td>
                                <div class="score-select Lanugo @if(isset($results->Lanugo) && $results->Lanugo == -1) active @endif" id="Lanugo-1" onClick="UpdateScore(-1,'Lanugo');">None</div>
                            </td>
                            <td>
                                <div class="score-select Lanugo @if(isset($results->Lanugo) && is_numeric($results->Lanugo) && $results->Lanugo == 0) active @endif" id="Lanugo0" onClick="UpdateScore(0,'Lanugo');">Sparse</div>
                            </td>
                            <td>
                                <div class="score-select Lanugo @if(isset($results->Lanugo) && $results->Lanugo == 1) active @endif" id="Lanugo1" onClick="UpdateScore(1,'Lanugo');">Abundant</div>
                            </td>                                    	
                            <td>
                                <div class="score-select Lanugo @if(isset($results->Lanugo) && $results->Lanugo == 2) active @endif" id="Lanugo2" onClick="UpdateScore(2,'Lanugo');">Thinning</div>
                            </td>                                    	
                            <td>
                                <div class="score-select Lanugo @if(isset($results->Lanugo) && $results->Lanugo == 3) active @endif" id="Lanugo3" onClick="UpdateScore(3,'Lanugo');">Bald areas</div>
                            </td>                                    	
                            <td>
                                <div class="score-select Lanugo @if(isset($results->Lanugo) && $results->Lanugo == 4) active @endif" id="Lanugo4" onClick="UpdateScore(4,'Lanugo');">Mostly bald</div>
                            </td>                                    	
                            <td class="empty-cell"></td>
                            <td>{!! Form::text('Lanugo',null,['readonly']) !!}</td>
                        </tr>
                        <tr>
                            <td>Plantar Surface</td>
                            <td>
                                <div class="score-select PlantarSurface @if(isset($results->PlantarSurface) && $results->PlantarSurface == -1) active @endif" id="PlantarSurface-1" onClick="UpdateScore(-1,'PlantarSurface');">Heel-toe 40-50 mm : -1 < 40mm : -2</div>
                            </td>
                            <td>
                                <div class="score-select PlantarSurface @if(isset($results->PlantarSurface) && is_numeric($results->PlantarSurface) && $results->PlantarSurface == 0) active @endif" id="PlantarSurface0" onClick="UpdateScore(0,'PlantarSurface');">> 50 mm, no crease</div>
                            </td>
                            <td>
                                <div class="score-select PlantarSurface @if(isset($results->PlantarSurface) && $results->PlantarSurface == 1) active @endif" id="PlantarSurface1" onClick="UpdateScore(1,'PlantarSurface');">Faint red marks</div>
                            </td>                                    	
                            <td>
                                <div class="score-select PlantarSurface @if(isset($results->PlantarSurface) && $results->PlantarSurface == 2) active @endif" id="PlantarSurface2" onClick="UpdateScore(2,'PlantarSurface');">Anterior transverse crease only</div>
                            </td>                                    	
                            <td>
                                <div class="score-select PlantarSurface @if(isset($results->PlantarSurface) && $results->PlantarSurface == 3) active @endif" id="PlantarSurface3" onClick="UpdateScore(3,'PlantarSurface');">Creases anterior 2/3</div>
                            </td>                                    	
                            <td>
                                <div class="score-select PlantarSurface @if(isset($results->PlantarSurface) && $results->PlantarSurface == 4) active @endif" id="PlantarSurface4" onClick="UpdateScore(4,'PlantarSurface');">Creases over entire sole</div>
                            </td>                                    	
                            <td class="empty-cell"></td>
                            <td>{!! Form::text('PlantarSurface',null,['readonly']) !!}</td>
                        </tr>
                        <tr>
                            <td>Breast</td>
                            <td>
                                <div class="score-select Breast @if(isset($results->Breast) && $results->Breast == -1) active @endif" id="Breast-1" onClick="UpdateScore(-1,'Breast');">Imperceptible</div>
                            </td>
                            <td>
                                <div class="score-select Breast @if(isset($results->Breast) && is_numeric($results->Breast) && $results->Breast == 0) active @endif" id="Breast0" onClick="UpdateScore(0,'Breast');">Barely perceptible</div>
                            </td>
                            <td>
                                <div class="score-select Breast @if(isset($results->Breast) && $results->Breast == 1) active @endif" id="Breast1" onClick="UpdateScore(1,'Breast');">Flat areola, no bud</div>
                            </td>                                    
                            <td>
                                <div class="score-select Breast @if(isset($results->Breast) && $results->Breast == 2) active @endif" id="Breast2" onClick="UpdateScore(2,'Breast');">Stippled areola, 1-2 mm bud</div>
                            </td>                                    	
                            <td>
                                <div class="score-select Breast @if(isset($results->Breast) && $results->Breast == 3) active @endif" id="Breast3" onClick="UpdateScore(3,'Breast');">Raised areola, 3-4 mm bud</div>
                            </td>                                    	
                            <td>
                                <div class="score-select Breast @if(isset($results->Breast) && $results->Breast == 4) active @endif" id="Breast4" onClick="UpdateScore(4,'Breast');">Full areola, 5-10 mm bud</div>
                            </td>                                    	
                            <td class="empty-cell"></td>
                            <td>{!! Form::text('Breast',null,['readonly']) !!}</td>
                        </tr>
                        <tr>
                            <td>Eye/Ear</td>
                            <td>
                                <div class="score-select EyeEar @if(isset($results->EyeEar) && $results->EyeEar == -1) active @endif" id="EyeEar-1" onClick="UpdateScore(-1,'EyeEar');">Lids fused loosely: -1 tightly: -2</div>
                            </td>
                            <td>
                                <div class="score-select EyeEar @if(isset($results->EyeEar) && is_numeric($results->EyeEar) && $results->EyeEar == 0) active @endif" id="EyeEar0" onClick="UpdateScore(0,'EyeEar');">Lids open; pinna flat; stays folded</div>
                            </td>
                            <td>
                                <div class="score-select EyeEar @if(isset($results->EyeEar) && $results->EyeEar == 1) active @endif" id="EyeEar1" onClick="UpdateScore(1,'EyeEar');">Slightly curved pinna; soft; slow recoil</div>
                            </td>
                            <td>
                                <div class="score-select EyeEar @if(isset($results->EyeEar) && $results->EyeEar == 2) active @endif" id="EyeEar2" onClick="UpdateScore(2,'EyeEar');">Well curved pinna; soft but ready recoil</div>
                            </td>
                            <td>
                                <div class="score-select EyeEar @if(isset($results->EyeEar) && $results->EyeEar == 3) active @endif" id="EyeEar3" onClick="UpdateScore(3,'EyeEar');">Formed and firm, instant recoil</div>
                            </td>                                    	
                            <td>
                                <div class="score-select EyeEar @if(isset($results->EyeEar) && $results->EyeEar == 4) active @endif" id="EyeEar4"onClick="UpdateScore(4,'EyeEar');">Thick cartilage, ear stiff</div>
                            </td>                                    	
                            <td class="empty-cell"></td>
                            <td>{!! Form::text('EyeEar',null,['readonly']) !!}</td>
                        </tr>
                        <tr>
                        @if (isset($results->Sex) && $results->Sex == 'Female')
                            <td>Genitals (Female)</td>
                            <td>
                                <div class="score-select Genitals @if(isset($results->Genitals) && $results->Genitals == -1) active @endif" id="FGenitals-1" onClick="UpdateScore(-1,'FGenitals');">Clitoris prominent, labia flat</div>
                            </td>
                            <td>
                                <div class="score-select Genitals @if(isset($results->Genitals) && is_numeric($results->Genitals) && $results->Genitals == 0) active @endif" id="FGenitals0" onClick="UpdateScore(0,'FGenitals');">Clitoris prominent small labia minora</div>
                            </td>
                            <td>
                                <div class="score-select Genitals @if(isset($results->Genitals) && $results->Genitals == 1) active @endif" id="FGenitals1" onClick="UpdateScore(1,'FGenitals');">Clitoris prominent, enlarging minora</div>
                            </td>
                            <td>
                                <div class="score-select Genitals @if(isset($results->Genitals) && $results->Genitals == 2) active @endif" id="FGenitals2" onClick="UpdateScore(2,'FGenitals');">Majora and minora equaily prominent</div>
                            </td>
                            <td>
                                <div class="score-select Genitals @if(isset($results->Genitals) && $results->Genitals == 3) active @endif" id="FGenitals3" onClick="UpdateScore(3,'FGenitals');">Majora large minora small</div>
                            </td>
                            <td>
                                <div class="score-select Genitals @if(isset($results->Genitals) && $results->Genitals == 4) active @endif" id="FGenitals4" onClick="UpdateScore(4,'FGenitals');">Majora cover ciltoris and minora</div>
                            </td>
                            <td class="empty-cell">
                            </td>
                        @else
                            <td>Genitals (Male)</td>
                            <td>
                                <div class="score-select Genitals @if(isset($results->Genitals) && $results->Genitals == -1) active @endif" id="Genitals-1" onClick="UpdateScore(-1,'Genitals');">Scrotum flat, smooth</div>
                            </td>
                            <td>
                                <div class="score-select Genitals @if(isset($results->Genitals) && is_numeric($results->Genitals) && $results->Genitals == 0) active @endif" id="Genitals0" onClick="UpdateScore(0,'Genitals');">Scrotum empty, faint rugae</div>
                            </td>
                            <td>
                                <div class="score-select Genitals @if(isset($results->Genitals) && $results->Genitals == 1) active @endif" id="Genitals1" onClick="UpdateScore(1,'Genitals');">Testes in upper canal, rare rugae</div>
                            </td>
                            <td>
                                <div class="score-select Genitals @if(isset($results->Genitals) && $results->Genitals == 2) active @endif" id="Genitals2" onClick="UpdateScore(2,'Genitals');">Testes descending, few rugae</div>
                            </td>
                            <td>
                                <div class="score-select Genitals @if(isset($results->Genitals) && $results->Genitals == 3) active @endif" id="Genitals3" onClick="UpdateScore(3,'Genitals');">Testes down, good rugae</div>
                            </td>                                   
                            <td>
                                <div class="score-select Genitals @if(isset($results->Genitals) && $results->Genitals == 4) active @endif" id="Genitals4" onClick="UpdateScore(4,'Genitals');">Testes pendulous, deep rugae</div>
                            </td>
                            <td class="empty-cell">
                            </td>
                        @endif
                            <td> {!! Form::text('Genitals',null,['readonly']) !!}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>             
    </div>             
</div>
<div role="tabpanel" class="tab-pane" id="scoreform">
    <div class="col-md-12">
        <div class="mt-10 widget box">
            <div class="widget-header">
                <h4><i class="fa fa-reorder"></i> </h4>
            </div>
            <div class="widget-content">
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control  mt-0">
                        {!! Form::label('NeuromuscularScore','Total Neuromuscular Maturity Score:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('NeuromuscularScore',null,['class'=>'form-control','readonly']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control  mt-0">
                        {!! Form::label('PhysicalScore','Total Physical Maturity Score:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('PhysicalScore',null,['class'=>'form-control','readonly']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('TotalScore','Total Score:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('TotalScore',null,['class'=>'form-control','readonly']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control  mt-0">
                        {!! Form::label('AssessedGestationalAge','Assessed Gestational Age (wks):') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('AssessedGestationalAge',null,['class'=>'form-control','readonly']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('Weeks','Weeks:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('Weeks',null,['class'=>'form-control','readonly']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('Days','Days:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('Days',null,['class'=>'form-control','readonly']) !!}
                    </div>
                </div>                        	                                                               	
            </div>
        </div>
    </div>
</div>