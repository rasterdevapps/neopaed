@extends('print')
@section('content')
<div class="temp-container">
    <div class="temp-row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="row">
                <img src="{{ ValuelistHelpers::printPagelogo(@$results->hospital_name) }}" >
                <h3 class="print-head">Ballard Score</h3>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="row pull-right">
                <span>Date: {!! date('d-m-Y', strtotime(@$results->TestDate)); !!} {!! @$results->TestTime; !!}</span>
            </div>
            <div class="row">
                <div class="content-block">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="row">
                            <h4>BASIC DETAILS:</h4>
                            <div class="col-xs-12 col-sm-12 col-md-12 overflow-auto">
                                <div class="row">
                                    <table class="table-layout-fixed">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <span class="font-weight-bold">{{ Lang::get('home.mrn') }}:</span>
                                                    <span>{!! @$results->BMrNo; !!}</span>
                                                </td>
                                                <td>
                                                    <span class="font-weight-bold">Baby Name:</span>
                                                    <span>{!! @$results->BabyName; !!}</span>
                                                </td>
                                                <td>
                                                    <span class="font-weight-bold">DOB:</span>
                                                    <span>{!! date('d-m-Y', strtotime(@$results->DOB)) !!}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="font-weight-bold">Birth Weight (In Gms):</span>
                                                    <span>{!! @$results->BirthWeight; !!}</span>
                                                </td>
                                                <td>
                                                    <span class="font-weight-bold">Gestation:</span>
                                                    <span>{!! @$results->g_weeks; !!}+{!! @$results->g_days; !!}</span>
                                                </td>
                                                <td>
                                                    <span class="font-weight-bold">Sex:</span>
                                                    <span>{!! @$results->Sex; !!}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="font-weight-bold">Age of Assessment:</span>
                                                    <span>{!! @$results->AssessmentAge; !!}</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-block">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="row">
                            <h4>Neuromuscular Maturity Sign:<span class="pull-right">Score: {{$results->NeuromuscularScore}}</span></h4></h4>
                            <div class="col-xs-12 col-sm-12 col-md-12 overflow-auto">
                                <div class="row">
                                    <table cellpadding="5" border="1" class="score-form">
                                        <thead>
                                            <tr>
                                                <th>Score</th>
                                                <th>-1</th>
                                                <th>0</th>
                                                <th>1</th>
                                                <th>2</th>                                      
                                                <th>3</th>                                      
                                                <th>4</th>                                      
                                                <th>5</th>
                                            </tr>                                      
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Posture <span class="ballard-value-block">({{$results->Posture}})</span></td>
                                                <td><div class="score-select @if(isset($results->Posture) && $results->Posture == -1) active @endif" id="Posture-1"></div></td>
                                                <td><div class="score-select @if(isset($results->Posture) && $results->Posture == 0) active @endif" id="Posture0"><img src="{{ url('/') }}/public/img/neurological_maturity/posture/0.svg" /></div></td>
                                                <td><div class="score-select @if(isset($results->Posture) && $results->Posture == 1) active @endif" id="Posture1"><img src="{{ url('/') }}/public/img/neurological_maturity/posture/1.svg" /></div></td>
                                                <td><div class="score-select @if(isset($results->Posture) && $results->Posture == 2) active @endif" id="Posture2"><img src="{{ url('/') }}/public/img/neurological_maturity/posture/2.svg" /></div></td>                                      
                                                <td><div class="score-select @if(isset($results->Posture) && $results->Posture == 3) active @endif" id="Posture3"><img src="{{ url('/') }}/public/img/neurological_maturity/posture/3.svg" /></div></td>                                      
                                                <td><div class="score-select @if(isset($results->Posture) && $results->Posture == 4) active @endif" id="Posture4"><img src="{{ url('/') }}/public/img/neurological_maturity/posture/4.svg" /></div></td>                                      
                                                <td class="empty-cell"></td>
                                            </tr>
                                            <tr>
                                                <td>Square Window (Wrist) <span class="ballard-value-block">({{$results->SquareWindow}})</span></td>
                                                <td><div class="score-select @if(isset($results->SquareWindow) && $results->SquareWindow == -1) active @endif" id="SquareWindow-1"><img src="{{ url('/') }}/public/img/neurological_maturity/square_window/-1.svg" /></div></td>
                                                <td><div class="score-select @if(isset($results->SquareWindow) && $results->SquareWindow == 0) active @endif" id="SquareWindow0"><img src="{{ url('/') }}/public/img/neurological_maturity/square_window/0.svg" /></div></td>
                                                <td><div class="score-select @if(isset($results->SquareWindow) && $results->SquareWindow == 1) active @endif" id="SquareWindow1"><img src="{{ url('/') }}/public/img/neurological_maturity/square_window/1.svg" /></div></td>                                     
                                                <td><div class="score-select @if(isset($results->SquareWindow) && $results->SquareWindow == 2) active @endif" id="SquareWindow2"><img src="{{ url('/') }}/public/img/neurological_maturity/square_window/2.svg" /></div></td>                                     
                                                <td><div class="score-select @if(isset($results->SquareWindow) && $results->SquareWindow == 3) active @endif" id="SquareWindow3"><img src="{{ url('/') }}/public/img/neurological_maturity/square_window/3.svg" /></div></td>                                     
                                                <td><div class="score-select @if(isset($results->SquareWindow) && $results->SquareWindow == 4) active @endif" id="SquareWindow4"><img src="{{ url('/') }}/public/img/neurological_maturity/square_window/4.svg" /></div></td>                                     
                                                <td class="empty-cell"></td>
                                            </tr>
                                            <tr>
                                                <td>Arm Recoil <span class="ballard-value-block">({{$results->ArmRecoil}})</span></td>
                                                <td><div class="score-select @if(isset($results->ArmRecoil) && $results->ArmRecoil == -1) active @endif" id="ArmRecoil-1"></div></td>
                                                <td><div class="score-select @if(isset($results->ArmRecoil) && $results->ArmRecoil == 0) active @endif" id="ArmRecoil0"><img src="{{ url('/') }}/public/img/neurological_maturity/arm_recoil/0.svg" /></div></td>
                                                <td><div class="score-select @if(isset($results->ArmRecoil) && $results->ArmRecoil == 1) active @endif" id="ArmRecoil1"><img src="{{ url('/') }}/public/img/neurological_maturity/arm_recoil/1.svg" /></div></td>                                        
                                                <td><div class="score-select @if(isset($results->ArmRecoil) && $results->ArmRecoil == 2) active @endif" id="ArmRecoil2"><img src="{{ url('/') }}/public/img/neurological_maturity/arm_recoil/2.svg" /></div></td>                                        
                                                <td><div class="score-select @if(isset($results->ArmRecoil) && $results->ArmRecoil == 3) active @endif" id="ArmRecoil3"><img src="{{ url('/') }}/public/img/neurological_maturity/arm_recoil/3.svg" /></div></td>                                        
                                                <td><div class="score-select @if(isset($results->ArmRecoil) && $results->ArmRecoil == 4) active @endif" id="ArmRecoil4"><img src="{{ url('/') }}/public/img/neurological_maturity/arm_recoil/4.svg" /></div></td>                                        
                                                <td class="empty-cell"></td>
                                            </tr>
                                            <tr>
                                                <td>Pop liteal Angle <span class="ballard-value-block">({{$results->PoplitealAngle}})</span></td>
                                                <td><div class="score-select @if(isset($results->PoplitealAngle) && $results->PoplitealAngle == -1) active @endif" id="PoplitealAngle-1"><img src="{{ url('/') }}/public/img/neurological_maturity/popliteal_angle/-1.svg" /></div></td>
                                                <td><div class="score-select @if(isset($results->PoplitealAngle) && $results->PoplitealAngle == 0) active @endif" id="PoplitealAngle0"><img src="{{ url('/') }}/public/img/neurological_maturity/popliteal_angle/0.svg" /></div></td>
                                                <td><div class="score-select @if(isset($results->PoplitealAngle) && $results->PoplitealAngle == 1) active @endif" id="PoplitealAngle1"><img src="{{ url('/') }}/public/img/neurological_maturity/popliteal_angle/1.svg" /></div></td>                                    
                                                <td><div class="score-select @if(isset($results->PoplitealAngle) && $results->PoplitealAngle == 2) active @endif" id="PoplitealAngle2"><img src="{{ url('/') }}/public/img/neurological_maturity/popliteal_angle/2.svg" /></div></td>                                       
                                                <td><div class="score-select @if(isset($results->PoplitealAngle) && $results->PoplitealAngle == 3) active @endif" id="PoplitealAngle3"><img src="{{ url('/') }}/public/img/neurological_maturity/popliteal_angle/3.svg" /></div></td>                                       
                                                <td><div class="score-select @if(isset($results->PoplitealAngle) && $results->PoplitealAngle == 4) active @endif" id="PoplitealAngle4"><img src="{{ url('/') }}/public/img/neurological_maturity/popliteal_angle/4.svg" /></div></td>                                       
                                                <td><div class="score-select @if(isset($results->PoplitealAngle) && $results->PoplitealAngle == 5) active @endif" id="PoplitealAngle5"><img src="{{ url('/') }}/public/img/neurological_maturity/popliteal_angle/5.svg" /></div></td>
                                            </tr>
                                            <tr>
                                                <td>Scarf Sign <span class="ballard-value-block">({{$results->ScarfSign}})</span></td>
                                                <td><div class="score-select @if(isset($results->ScarfSign) && $results->ScarfSign == -1) active @endif" id="ScarfSign-1"><img src="{{ url('/') }}/public/img/neurological_maturity/scarf_sign/-1.svg" /></div></td>
                                                <td><div class="score-select @if(isset($results->ScarfSign) && $results->ScarfSign == 0) active @endif" id="ScarfSign0"><img src="{{ url('/') }}/public/img/neurological_maturity/scarf_sign/0.svg" /></div></td>
                                                <td><div class="score-select @if(isset($results->ScarfSign) && $results->ScarfSign == 1) active @endif" id="ScarfSign1"><img src="{{ url('/') }}/public/img/neurological_maturity/scarf_sign/1.svg" /></div></td>                                        
                                                <td><div class="score-select @if(isset($results->ScarfSign) && $results->ScarfSign == 2) active @endif" id="ScarfSign2"><img src="{{ url('/') }}/public/img/neurological_maturity/scarf_sign/2.svg" /></div></td>                                        
                                                <td><div class="score-select @if(isset($results->ScarfSign) && $results->ScarfSign == 3) active @endif" id="ScarfSign3"><img src="{{ url('/') }}/public/img/neurological_maturity/scarf_sign/3.svg" /></div></td>                                        
                                                <td><div class="score-select @if(isset($results->ScarfSign) && $results->ScarfSign == 4) active @endif" id="ScarfSign4"><img src="{{ url('/') }}/public/img/neurological_maturity/scarf_sign/4.svg" /></div></td>                                     
                                            </tr>
                                            <tr>
                                                <td>Heel To Ear <span class="ballard-value-block">({{$results->HeelEar}})</span></td>
                                                <td><div class="score-select @if(isset($results->HeelEar) && $results->HeelEar == -1) active @endif" id="HeelEar-1"><img src="{{ url('/') }}/public/img/neurological_maturity/heel_to_ear/-1.svg" /></div></td>
                                                <td><div class="score-select @if(isset($results->HeelEar) && $results->HeelEar == 0) active @endif" id="HeelEar0"><img src="{{ url('/') }}/public/img/neurological_maturity/heel_to_ear/0.svg" /></div></td>
                                                <td><div class="score-select @if(isset($results->HeelEar) && $results->HeelEar == 1) active @endif" id="HeelEar1"><img src="{{ url('/') }}/public/img/neurological_maturity/heel_to_ear/1.svg" /></div></td>                                      
                                                <td><div class="score-select @if(isset($results->HeelEar) && $results->HeelEar == 2) active @endif" id="HeelEar2"><img src="{{ url('/') }}/public/img/neurological_maturity/heel_to_ear/2.svg" /></div></td>                                   
                                                <td><div class="score-select @if(isset($results->HeelEar) && $results->HeelEar == 3) active @endif" id="HeelEar3"><img src="{{ url('/') }}/public/img/neurological_maturity/heel_to_ear/3.svg" /></div></td>                                   
                                                <td><div class="score-select @if(isset($results->HeelEar) && $results->HeelEar == 4) active @endif" id="HeelEar4"><img src="{{ url('/') }}/public/img/neurological_maturity/heel_to_ear/4.svg" /></div></td>                                   
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-block">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="row">
                            <h4>Physical Maturity Sign:<span class="pull-right">Score: {{$results->PhysicalScore}}</span></h4>
                            <div class="col-xs-12 col-sm-12 col-md-12 overflow-auto">
                                <div class="row">                             
                                    <table cellpadding="5" border="1" class="score-form" id="physical-sign">
                                        <thead>
                                            <tr>
                                                <th>Score</th>
                                                <th>-1</th>
                                                <th>0</th>
                                                <th>1</th>
                                                <th>2</th>                                      
                                                <th>3</th>                                      
                                                <th>4</th>                                      
                                                <th>5</th>
                                            </tr>  
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Skin <span class="ballard-value-block">({{$results->Skin}})</span></td>
                                                <td><div class="score-select Skin @if(isset($results->Skin) && $results->Skin == -1) active @endif" id="Skin-1">Sticky, friable, transparent</div></td>
                                                <td><div class="score-select Skin @if(isset($results->Skin) && $results->Skin == 0) active @endif" id="Skin0">Gelatinous, red, translucent</div></td>
                                                <td><div class="score-select Skin @if(isset($results->Skin) && $results->Skin == 1) active @endif" id="Skin1">Smooth, pink; visible veins</div></td>
                                                <td><div class="score-select Skin @if(isset($results->Skin) && $results->Skin == 2) active @endif" id="Skin2">Superficial peeling and/or rash; few veins</div></td>
                                                <td><div class="score-select Skin @if(isset($results->Skin) && $results->Skin == 3) active @endif" id="Skin3">Cracking, pale areas; rare veins</div></td>                                     
                                                <td><div class="score-select Skin @if(isset($results->Skin) && $results->Skin == 4) active @endif" id="Skin4">Parchment, deep cracking; no vessels</div></td>                                     
                                                <td><div class="score-select Skin @if(isset($results->Skin) && $results->Skin == 5) active @endif" id="Skin5">Leathery, cracked, wrinkled</div></td>
                                            </tr>
                                            <tr>
                                                <td>Lanugo <span class="ballard-value-block">({{$results->Lanugo}})</span></td>
                                                <td><div class="score-select Lanugo @if(isset($results->Lanugo) && $results->Lanugo == -1) active @endif" id="Lanugo-1">None</div></td>
                                                <td><div class="score-select Lanugo @if(isset($results->Lanugo) && $results->Lanugo == 0) active @endif" id="Lanugo0">Sparse</div></td>
                                                <td><div class="score-select Lanugo @if(isset($results->Lanugo) && $results->Lanugo == 1) active @endif" id="Lanugo1">Abundant</div></td>                                       
                                                <td><div class="score-select Lanugo @if(isset($results->Lanugo) && $results->Lanugo == 2) active @endif" id="Lanugo2">Thinning</div></td>                                       
                                                <td><div class="score-select Lanugo @if(isset($results->Lanugo) && $results->Lanugo == 3) active @endif" id="Lanugo3">Bald areas</div></td>                                       
                                                <td><div class="score-select Lanugo @if(isset($results->Lanugo) && $results->Lanugo == 4) active @endif" id="Lanugo4">Mostly bald</div></td>                                       
                                            </tr>
                                            <tr>
                                                <td>Plantar Surface <span class="ballard-value-block">({{$results->PlantarSurface}})</span></td>
                                                <td><div class="score-select PlantarSurface @if(isset($results->PlantarSurface) && $results->PlantarSurface == -1) active @endif" id="PlantarSurface-1">Heel-toe 40-50 mm : -1 < 40mm : -2</div></td>
                                                <td><div class="score-select PlantarSurface @if(isset($results->PlantarSurface) && $results->PlantarSurface == 0) active @endif" id="PlantarSurface0">> 50 mm, no crease</div></td>
                                                <td><div class="score-select PlantarSurface @if(isset($results->PlantarSurface) && $results->PlantarSurface == 1) active @endif" id="PlantarSurface1">Faint red marks</div></td>
                                                <td><div class="score-select PlantarSurface @if(isset($results->PlantarSurface) && $results->PlantarSurface == 2) active @endif" id="PlantarSurface2">Anterior transverse crease only</div></td>
                                                <td><div class="score-select PlantarSurface @if(isset($results->PlantarSurface) && $results->PlantarSurface == 3) active @endif" id="PlantarSurface3">Creases anterior 2/3</div></td>
                                                <td><div class="score-select PlantarSurface @if(isset($results->PlantarSurface) && $results->PlantarSurface == 4) active @endif" id="PlantarSurface4">Creases over entire sole</div></td>
                                            </tr>
                                            <tr>
                                                <td>Breast <span class="ballard-value-block">({{$results->Breast}})</span></td>
                                                <td><div class="score-select Breast @if(isset($results->Breast) && $results->Breast == -1) active @endif" id="Breast-1">Imperceptible</div></td>
                                                <td><div class="score-select Breast @if(isset($results->Breast) && $results->Breast == 0) active @endif" id="Breast0">Barely perceptible</div></td>
                                                <td><div class="score-select Breast @if(isset($results->Breast) && $results->Breast == 1) active @endif" id="Breast1">Flat areola, no bud</div></td>                                    
                                                <td><div class="score-select Breast @if(isset($results->Breast) && $results->Breast == 2) active @endif" id="Breast2">Stippled areola, 1-2 mm bud</div></td><td><div class="score-select Breast @if(isset($results->Breast) && $results->Breast == 3) active @endif" id="Breast3">Raised areola, 3-4 mm bud</div></td>
                                                <td><div class="score-select Breast @if(isset($results->Breast) && $results->Breast == 4) active @endif" id="Breast4">Full areola, 5-10 mm bud</div></td>                                       
                                            </tr>
                                            <tr>
                                                <td>Eye/Ear <span class="ballard-value-block">({{$results->EyeEar}})</span></td>
                                                <td><div class="score-select EyeEar @if(isset($results->EyeEar) && $results->EyeEar == -1) active @endif" id="EyeEar-1">Lids fused loosely: -1 tightly: -2</div></td>
                                                <td><div class="score-select EyeEar @if(isset($results->EyeEar) && $results->EyeEar == 0) active @endif" id="EyeEar0">Lids open; pinna flat; stays folded</div></td>
                                                <td><div class="score-select EyeEar @if(isset($results->EyeEar) && $results->EyeEar == 1) active @endif" id="EyeEar1">Slightly curved pinna; soft; slow recoil</div></td>
                                                <td><div class="score-select EyeEar @if(isset($results->EyeEar) && $results->EyeEar == 2) active @endif" id="EyeEar2">Well curved pinna; soft but ready recoil</div></td><td><div class="score-select EyeEar @if(isset($results->EyeEar) && $results->EyeEar == 3) active @endif" id="EyeEar3">Formed and firm, instant recoil</div></td>                                       
                                                <td><div class="score-select EyeEar @if(isset($results->EyeEar) && $results->EyeEar == 4) active @endif" id="EyeEar4">Thick cartilage, ear stiff</div></td>
                                            </tr>
                                            @if (isset($results->Sex) && $results->Sex == 'Female')
                                            <tr>
                                                <td>Genitals (Female) <span class="ballard-value-block">({{$results->Genitals}})</span></td>
                                                <td><div class="score-select Genitals @if(isset($results->Genitals) && $results->Genitals == -1) active @endif" id="Genitals-1">Clitoris prominent, labia flat</div></td>
                                                <td><div class="score-select Genitals @if(isset($results->Genitals) && $results->Genitals == 0) active @endif" id="Genitals0">Clitoris prominent small labia minora</div></td>
                                                <td><div class="score-select Genitals @if(isset($results->Genitals) && $results->Genitals == 1) active @endif" id="Genitals1">Clitoris prominent, enlarging minora</div></td>
                                                <td><div class="score-select Genitals @if(isset($results->Genitals) && $results->Genitals == 2) active @endif" id="Genitals2">Majora and minora equaily prominent</div></td>
                                                <td><div class="score-select Genitals @if(isset($results->Genitals) && $results->Genitals == 3) active @endif" id="Genitals3">Majora large minora small</div></td>
                                                <td><div class="score-select Genitals @if(isset($results->Genitals) && $results->Genitals == 4) active @endif" id="Genitals4">Majora cover ciltoris and minora</div></td>
                                            </tr>
                                            @else
                                            <tr>
                                                <td>Genitals (Male) <span class="ballard-value-block">({{$results->Genitals}})</span></td>
                                                <td><div class="score-select Genitals @if(isset($results->Genitals) && $results->Genitals == -1) active @endif" id="FGenitals-1">Scrotum flat, smooth</div></td>
                                                <td><div class="score-select Genitals @if(isset($results->Genitals) && $results->Genitals == 0) active @endif" id="FGenitals0">Scrotum empty, faint rugae</div></td>
                                                <td><div class="score-select Genitals @if(isset($results->Genitals) && $results->Genitals == 1) active @endif" id="FGenitals1">Testes in upper canal, rare rugae</div></td><td><div class="score-select Genitals @if(isset($results->Genitals) && $results->Genitals == 2) active @endif" id="FGenitals2">Testes descending, few rugae</div></td>                                   
                                                <td><div class="score-select Genitals @if(isset($results->Genitals) && $results->Genitals == 3) active @endif" id="FGenitals3">Testes down, good rugae</div></td>
                                                <td><div class="score-select Genitals @if(isset($results->Genitals) && $results->Genitals == 4) active @endif" id="FGenitals4">Testes pendulous, deep rugae</div></td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>                
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0">
                    <div class="col-md-6 text pull-left plr-must-0 mt-15">
                        <p class="col-md-12">Date : <b>{!! date("d-m-Y",strtotime($results->TestDate)); !!} </b></p>
                        <p class="col-md-12">Place: <b>{!! env('LOCATION')!!}</b></p>
                    </div>
                    <div class="col-md-6">
                        <div class="pull-right">
                            <div class="text-center">
                                @if (!empty($results->Examiner))
                                @php 
                                $seen_by = $results->Examiner; 
                                $seen_by = (array)$seen_by;
                                $seen_by = json_encode($seen_by);
                                $seen_by = \ValuelistHelpers::signatureFormat($seen_by);
                                @endphp
                                {!! $seen_by !!}
                                <div class="full-width">Examiner</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
