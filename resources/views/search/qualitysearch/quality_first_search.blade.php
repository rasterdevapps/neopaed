<div class="col-md-12 p-0 plr-0">
    @php $name = isset($baby_details->BabyName) ? $baby_details->BabyName : null; @endphp
    @php $mr_number = isset($baby_details->BMrNo) ? $baby_details->BMrNo : null; @endphp
    <div class="col-md-12 border-bottom mb-10 plr-0">
        <div class="col-md-6 border-right">
            <h4><b><u>DEMOGRAPHIC DETAILS</u></b></h4>
            <div class="col-md-12 display-sm-inline-block full-width border-bottom mb-10 plr-0">
                <div class="col-md-3 col-sm-3">
                    {!! Form::label('mr_number', 'MR NUMBER',['class'=>'title']) !!}
                </div>
                <div class="col-md-8 col-sm-8">
                    {!! Form::text('mr_number', $mr_number,['class'=>'form-control shadow']) !!}
                </div>
            </div>
            <div class="col-md-12 display-sm-inline-block full-width border-bottom mb-10 plr-0">
                <div class="col-md-3 col-sm-3">{!! Form::label('name', 'NAME',['class'=>'title']) !!}</div>
                <div class="col-md-8 col-sm-8">{!! Form::text('name', $name,['class'=>'form-control shadow']) !!}</div>
            </div>
            <div class="col-md-12 display-sm-inline-block full-width border-bottom mb-10 plr-0">
                <div class="col-md-6 col-sm-6 plr-0">
                    <div class="col-md-6 col-sm-6">{!! Form::label('maternal_age','MATERNAL AGE',['class'=>'title']) !!}</div>
                    <div class="col-md-5 col-sm-5">{!! Form::text('maternal_age',null,['class'=>'form-control shadow']) !!}</div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12">
                {!! Form::label('married_for','MARRIED SINCE ',['class'=>'title']) !!}
            </div>
            <div class="col-md-12 display-sm-inline-block full-width border-bottom mb-10 plr-0">
                <div class="col-md-6 col-sm-6 plr-0">
                    <div class="title col-md-6 col-sm-6">{!! Form::label('married_month','MONTHS',['class'=>'title']) !!}</div>
                    <div class="col-md-5 col-sm-5">{!! Form::text('married_month',null,['class'=>'form-control shadow']) !!}</div>
                </div>
                <div class="col-md-6 col-sm-6 plr-0">
                    <div class="title col-md-5 col-sm-5">{!! Form::label('married_years','YEARS',['class'=>'title']) !!}</div>
                    <div class="col-md-5 col-sm-5">{!! Form::text('married_years',null,['class'=>'form-control shadow']) !!}</div>
                </div>
            </div>
            <div class="col-md-12 display-sm-inline-block full-width plr-0">
                <div class="col-md-6 col-sm-6 plr-0">
                    <div class="col-md-6 col-sm-6">{!! Form::label('hwbstatus','HEIGHT / WEIGHT / BMI',['class'=>'title']) !!}</div>
                    <div class="col-md-6 col-sm-6">{!! Form::radio('hwbstatus','Not available') !!}{!! Form::label('hwbstatus','N/A',['class'=>'title']) !!}</div>
                </div>
                <div class="col-md-6 col-sm-6 plr-0">
                    <div class="col-md-5 col-sm-5">{!! Form::label('height','HEIGHT',['class'=>'title']) !!}</div>
                    <div class="col-md-5 col-sm-5">{!! Form::text('height',null,['class'=>'form-control shadow']) !!}</div>
                </div>
            </div>
            <div class="col-md-12 display-sm-inline-block full-width border-bottom mb-10 plr-0">
                <div class="col-md-6 col-sm-6 plr-0">
                    <div class="col-md-6 col-sm-6">{!! Form::label('weight','WEIGHT',['class'=>'title']) !!}</div>
                    <div class="col-md-5 col-sm-5">{!! Form::text('weight',null,['class'=>'form-control shadow']) !!}</div>
                </div>
                <div class="col-md-6 col-sm-6 plr-0">
                    <div class="col-md-5 col-sm-5">{!! Form::label('bmi','BMI',['class'=>'title']) !!}</div>
                    <div class="col-md-5 col-sm-5">{!! Form::text('bmi',null,['class'=>'form-control shadow']) !!}</div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 plr-0">
                <div class="col-md-6 col-sm-6 plr-0">
                    <div class="col-md-6 col-sm-6">{!! Form::label('gravida','GRAVIDA ',['class'=>'title']) !!}</div>
                    <div class="col-md-5 col-sm-5">{!! Form::text('gravida',null,['class'=>'form-control shadow']) !!}</div>
                </div>
                <div class="col-md-6 col-sm-6 plr-0">
                    <div class="col-md-5 col-sm-5">{!! Form::label('para','PARA',['class'=>'title']) !!}</div>
                    <div class="col-md-5 col-sm-5">{!! Form::text('para',null,['class'=>'form-control shadow']) !!}</div>
                </div>
            </div>
            <div class="col-md-12 display-sm-inline-block full-width border-bottom mb-10 plr-0">
                <div class="col-md-6 col-sm-6 plr-0">
                    <div class="col-md-6 col-sm-6">{!! Form::label('live','LIVE',['class'=>'title']) !!}</div>
                    <div class="col-md-5 col-sm-5">{!! Form::text('live',null,['class'=>'form-control shadow']) !!}</div>
                </div>
                <div class="col-md-6 col-sm-6 plr-0">
                    <div class="col-md-5 col-sm-5">{!! Form::label('abortions','ABORTIONS',['class'=>'title']) !!}</div>
                    <div class="col-md-5 col-sm-5">{!! Form::text('abortions',null,['class'=>'form-control shadow']) !!}</div>
                </div>
            </div>
            <div class="col-md-12 display-sm-inline-block full-width border-bottom mb-10 plr-0">
                <div class="col-md-3 col-sm-3">{!! Form::label('sex', 'SEX',['class'=>'title']) !!}</div>
                <div class="col-md-8 col-sm-8 display-flex plr-0">
                    <div class="col-md-5 col-sm-5 col-xs-5">{!! Form::radio('gender', 'Male') !!}{!! Form::label('male','Male',['class'=>'title']) !!}</div>
                    <div class="col-md-7 col-sm-7 col-xs-7 pl-0">{!! Form::radio('gender', 'Female') !!}{!! Form::label('female','Female',['class'=>'title']) !!}</div>
                </div>
            </div>
            <div class="col-md-12 display-sm-inline-block full-width border-bottom mb-10 plr-0">
                <div class="col-md-6 col-sm-6 plr-0">
                    <div class="col-md-6 col-sm-6">{!! Form::label('birth_weight', 'BIRTH WEIGHT (Grams)',['class'=>'title']) !!}</div>
                    <div class="col-md-5 col-sm-5">{!! Form::text('birth_weight', null,['class'=>'form-control shadow']) !!}</div>
                </div>
                <div class="col-md-6 col-sm-6 plr-0">
                    <div class="col-md-5 col-sm-5">{!! Form::label('admission_weight', 'ADMISSION WEIGHT (Grams)',['class'=>'title']) !!}</div>
                    <div class="col-md-5 col-sm-5">{!! Form::text('admission_weight', null,['class'=>'form-control shadow']) !!}</div>
                </div>
            </div>
            <div class="col-md-12 display-sm-inline-block full-width border-bottom mb-10 plr-0">
                <div class="col-md-6 col-sm-6 plr-0">
                    <div class="col-md-6 col-sm-6">{!! Form::label('dob','DOB',['class'=>'title']) !!}<br/><span style="font-size: 11px;">(DD-MM-YYYY)</span></div>
                    <div class="col-md-6 col-sm-5">{!! Form::text('dob',null,['class'=>'form-control shadow','id'=>'dob','placeholder'=>'dd-mm-yyyy']) !!}</div>
                </div>
                <div class="col-md-6 col-sm-6 plr-0">
                    <div class="col-md-5 col-sm-5">{!! Form::label('tob','TOB',['class'=>'title']) !!}<br/><span style="font-size: 11px;">(HH:MM:AM or PM)</span></div>
                    <div class="col-md-5 col-sm-5">{!! Form::text('tob',null,['class'=>'form-control shadow','id'=>'tob','placeholder'=>'--:--']) !!}</div>
                </div>
            </div>
            <div class="col-md-12 display-sm-inline-block full-width border-bottom mb-10 plr-0">
                <div class="col-md-3 col-sm-3 plr-0">
                    <div class="col-md-6 col-sm-6">{!! Form::label('age_at_admission','AGE AT ADMISSION IN',['class'=>'title']) !!}</div>
                </div>
                <div class="col-md-8 col-sm-8 display-flex plr-0">
                    <div class="col-md-5 col-sm-5 col-xs-5">{!! Form::radio('age_at_admission_method','HOURS') !!}{!! Form::label('age_at_admission_method','HOURS',['class'=>'title']) !!}</div>
                    <div class="col-md-7 col-sm-7 col-xs-7 plr-0">
                        <div class="col-md-5 col-sm-5 col-xs-5 plr-0">
                            {!! Form::radio('age_at_admission_method','DAYS') !!}
                            {!! Form::label('age_at_admission_method','DAYS',['class'=>'title']) !!}
                        </div>
                        <div class="col-md-7 col-sm-7 col-xs-7 plr-0">
                            &nbsp;(in hours if < 96 hours; in days if > 96 hours)
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 display-sm-inline-block full-width border-bottom mb-10 plr-0 age-admission-m">
                <div class="col-md-8 col-sm-8">{!! Form::label('age_at_admission_h','AGE AT ADMISSION IN (Hours)',['class'=>'title']) !!}</div>
                <div class="col-md-3 col-sm-3 plr-0">
                    <div class="col-md-offset-3 col-md-9 col-sm-offset-3 col-sm-9 pl-1">
                        {!! Form::text('age_at_admission_h',null,['class'=>'form-control shadow']) !!}
                    </div>
                </div>
            </div>
            <div class="col-md-12 display-sm-inline-block full-width border-bottom mb-10 plr-0 age-admission-y">
                <div class="col-md-8 col-sm-8">{!! Form::label('age_at_admission_d','AGE AT ADMISSION IN (Days)',['class'=>'title']) !!}</div>
                <div class="col-md-3 col-sm-3 plr-0">
                    <div class="col-md-offset-3 col-md-9 col-sm-offset-3 col-sm-9 pl-1">
                        {!! Form::text('age_at_admission_d',null,['class'=>'form-control shadow']) !!}
                    </div>
                </div>
            </div>
            <div class="col-md-12 display-sm-inline-block full-width border-bottom mb-10 plr-0">
                <div class="col-md-3 col-sm-3">{!! Form::label('birth_status','BIRTH STATUS',['class'=>'title']) !!}</div>
                <div class="col-md-8 col-sm-8 display-flex plr-0">
                    <div class="col-md-5 col-sm-5 col-xs-5">{!! Form::radio('intramural_extramural','Intramural') !!}{!! Form::label('intramural/extramural','Intramural',['class'=>'title']) !!}</div>
                    <div class="col-md-7 col-sm-7 col-xs-7 pl-0">{!! Form::radio('intramural_extramural','Extramural') !!}{!! Form::label('intramural/extramural','Extramural',['class'=>'title']) !!}</div>
                </div>
            </div>
            <div class="col-md-12 display-sm-inline-block full-width border-bottom mb-10 plr-0">
                <div class="col-md-3 col-sm-3">{!! Form::label('SGA','SGA',['class'=>'title']) !!}</div>
                <div class="col-md-8 col-sm-8 display-flex plr-0">
                    <div class="col-md-5 col-sm-5 col-xs-5">{!! Form::radio('sga','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                    <div class="col-md-4 col-sm-4 col-xs-4 plr-0">{!! Form::radio('sga','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
                    <div class="col-md-3 col-sm-3 col-xs-3 pr-0">{!! Form::radio('sga','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                </div>
            </div>
            <div class="col-md-12 display-sm-inline-block full-width border-bottom mb-10 plr-0">
                <div class="col-md-3 col-sm-3">{!! Form::label('gestation','GESTATION AGE',['class'=>'title']) !!}</div>
                <div class="col-md-9 col-sm-9 display-flex plr-0">
                    <div class="col-md-5 col-sm-5 col-xs-8 pr-5">
                        <table>
                            <tbody>
                                <tr>
                                    <td class="col-md-5 col-sm-5 col-xs-5 pl-0 pr-5">{!! Form::text('gestation_weeks', null,['class'=>'form-control shadow']) !!}</td>
                                    <td class="col-md-2 col-sm-2 col-xs-2 plus text-center">+</td>
                                    <td class="col-md-5 col-sm-5 col-xs-5 pl-5 pr-5">{!! Form::text('gestation_days', null,['class'=>'form-control shadow']) !!}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-4 title plr-0">(T1 USG f/b dates or Ballard)</div>
                </div>
            </div>
            <div class="col-md-12 display-inline-block full-width border-bottom mb-10 plr-0">
                <div class="col-md-3 col-sm-3 pr-0">{!! Form::label('mode_of_delivery', 'MODE OF DELIVERY',['class'=>'title']) !!}</div>
                <div class="col-md-5 col-sm-5 pr-10">{!! Form::select('mode_of_delivery', ['N/A'=>'N/A','NVD'=>'NVD', 'VD(Assisted)'=>'VD (Assisted)','LSCS(Elective)'=>'LSCS(Elective)','LSCS(Emergency)'=>'LSCS(Emergency)','Ventouse'=>'Ventouse','Caesarian'=>'Caesarian'],null,['class'=>'form-control shadow']) !!}</div>
            </div>
            <div class="col-md-12 display-inline-block full-width border-bottom mb-10 plr-0">
                <div class="col-md-3 col-sm-3">{!! Form::label('if_lscs', 'If LSCS',['class'=>'title']) !!}</div>
                <div class="col-md-8 col-sm-8 display-flex plr-0">
                    <div class="col-md-5 col-sm-5 col-xs-5 pr-0">{!! Form::radio('iflscs', 'Maternal Cause') !!}{!! Form::label('maternal_cause','Maternal Cause',['class'=>'title']) !!}</div>
                    <div class="col-md-7 col-sm-7 col-xs-7 pl-0">{!! Form::radio('iflscs', 'Fetal cause') !!}{!! Form::label('fetal_cause','Fetal Cause',['class'=>'title']) !!}</div>
                </div>
            </div>
            <div class="col-md-12 display-inline-block border-bottom mb-10 plr-0">
                <div class="col-md-12 col-sm-12">{!! Form::label('maternalcause', 'MATERNAL CAUSE',['class'=>' title']) !!}</div>
                <div class="col-md-offset-3 col-md-9 col-sm-offset-3 col-sm-9 col-xs-12">{!! Form::radio('maternalcause','1') !!}{!! Form::label('hypertension','Pregnancy-induced hypertension',['class'=>'title']) !!}</div>
                <div class="col-md-offset-3 col-md-9 col-sm-offset-3 col-sm-9 col-xs-12">{!! Form::radio('maternalcause','2') !!}{!! Form::label('pprom','pPROM',['class'=>'title']) !!}</div>
                <div class="col-md-offset-3 col-md-9 col-sm-offset-3 col-sm-9 col-xs-12">{!! Form::radio('maternalcause','3') !!}{!! Form::label('infection','Maternal infection',['class'=>'title']) !!}</div>
                <div class="col-md-offset-3 col-md-9 col-sm-offset-3 col-sm-9 col-xs-12">{!! Form::radio('maternalcause','4') !!}{!! Form::label('gestationaldiabetes','Hypothyroidism',['class'=>'title']) !!}</div>
                <div class="col-md-offset-3 col-md-9 col-sm-offset-3 col-sm-9 col-xs-12">{!! Form::radio('maternalcause','5') !!}{!! Form::label('gestationaldiabetes','Gestational Diabetes / Type I , II Diabetes',['class'=>'title']) !!}</div>
                <div class="col-md-offset-3 col-md-9 col-sm-offset-3 col-sm-9 col-xs-12">{!! Form::radio('maternalcause','6') !!}{!! Form::label('autoimmunedisorder','Autoimmune disorder',['class'=>'title']) !!}</div>
                <div class="col-md-offset-3 col-md-9 col-sm-offset-3 col-sm-9 col-xs-12">{!! Form::radio('maternalcause','7') !!}{!! Form::label('pretermbirth','Previous preterm birth',['class'=>'title']) !!}</div>
                <div class="col-md-offset-3 col-md-9 col-sm-offset-3 col-sm-9 col-xs-12">{!! Form::radio('maternalcause','8') !!}{!! Form::label('chronicsystemic','Chronic systemic illness',['class'=>'title']) !!}</div>
                <div class="col-md-offset-3 col-md-9 col-sm-offset-3 col-sm-9 col-xs-12">{!! Form::radio('maternalcause','9') !!}{!! Form::label('other','Other',['class'=>'title']) !!}</div>
            </div>
            <div class="col-md-12 display-inline-block border-bottom mb-10 plr-0">
                <div class="col-md-12 col-sm-12">{!! Form::label('fetalcause', 'FETAL CAUSE',['class'=>'title']) !!}</div>
                <div class="col-md-offset-3 col-md-9 col-sm-offset-3 col-sm-9 col-xs-12">{!! Form::radio('fetalcause','1') !!}{!! Form::label('multipregnancy','Multiple Pregnancy',['class'=>'title']) !!}</div>
                <div class="col-md-offset-3 col-md-9 col-sm-offset-3 col-sm-9 col-xs-12">{!! Form::radio('fetalcause','2') !!}{!! Form::label('fetaldistress','Fetal Distress',['class'=>'title']) !!}</div>
                <div class="col-md-offset-3 col-md-9 col-sm-offset-3 col-sm-9 col-xs-12">{!! Form::radio('fetalcause','3') !!}{!! Form::label('gugr','guGR / Placetal insufficiency',['class'=>'title']) !!}</div>
                <div class="col-md-offset-3 col-md-9 col-sm-offset-3 col-sm-9 col-xs-12">{!! Form::radio('fetalcause','4') !!}{!! Form::label('malformations','Congenital malformations',['class'=>'title']) !!}</div>
                <div class="col-md-offset-3 col-md-9 col-sm-offset-3 col-sm-9 col-xs-12">{!! Form::radio('fetalcause','5') !!}{!! Form::label('hydrops','Hydrops fetalis',['class'=>'title']) !!}</div>
                <div class="col-md-offset-3 col-md-9 col-sm-offset-3 col-sm-9 col-xs-12">{!! Form::radio('fetalcause','9') !!}{!! Form::label('other','Other',['class'=>'title']) !!}</div>
            </div>
            <div class="col-md-12 display-inline-block full-width border-bottom mb-10 plr-0">
                <div class="col-md-3 col-sm-3">{!! Form::label('antenatal_MgSO4','ANTENATAL MgSO4 FOR NEUROPROTECTION',['class'=>'title']) !!}</div>
                <div class="col-md-8 col-sm-8 display-flex plr-0">
                    <div class="col-md-5 col-sm-5 col-xs-5">{!! Form::radio('antenatalMgSO4','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                    <div class="col-md-4 col-sm-4 col-xs-4 plr-0">{!! Form::radio('antenatalMgSO4','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
                    <div class="col-md-3 col-sm-3 col-xs-3 pr-0">{!! Form::radio('antenatalMgSO4','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                </div>
            </div>
            <div class="col-md-12 display-inline-block full-width border-bottom mb-10 plr-0">
                <div class="col-md-3 col-sm-3">{!! Form::label('antenatal_steriods', 'ANTENATAL STERIODS COVERED',['class'=>'title']) !!}</div>
                <div class="col-md-8 col-sm-8 display-flex plr-0">
                    <div class="col-md-5 col-sm-5 col-xs-5">{!! Form::radio('antenatalsteriods', 'N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                    <div class="col-md-7 col-sm-7 col-xs-7 pl-0">{!! Form::radio('antenatalsteriods', 'Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                </div>
                <div class="col-md-8 col-sm-8 display-flex plr-0">
                    <div class="col-md-5 col-sm-5 col-xs-5">{!! Form::radio('antenatalsteriods', 'No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
                    <div class="col-md-7 col-sm-7 col-xs-7 pl-0">{!! Form::radio('antenatalsteriods', 'Partial') !!}{!! Form::label('partial','Partial',['class'=>'title']) !!}</div>
                </div>
            </div>
            <div class="col-md-12 display-inline-block full-width border-bottom mb-10 plr-0">
                <div class="col-md-12 col-sm-12 col-xs-12 plr-0">
                    <div class="col-md-7 col-sm-7 col-xs-10 plr-0">
                        <div class="col-md-5 col-sm-5 col-xs-5">{!! Form::label('steriod_last_dose','LAST DOSE',['class'=>'title']) !!}</div>
                        <div class="col-md-7 col-sm-7 col-xs-7">{!! Form::text('steriod_last_dose',null,['class'=>'form-control shadow']) !!}</div>
                    </div>
                    <div class="col-md-5 col-sm-5 col-xs-2 title plr-0">(hours before delivery)</div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12 plr-0">
                    <div class="col-md-3 col-sm-3">{!! Form::label('typeofsteroids','TYPE OF STEROIDS',['class'=>'title']) !!}</div>
                    <div class="col-md-8 col-sm-8 plr-0">
                        <div class="col-md-5 col-sm-5 col-xs-5">{!! Form::radio('dexa_beta','Dexa')!!}{!! Form::label('dexa','Dexa',['class'=>'title']) !!}</div>
                        <div class="col-md-7 col-sm-7 col-xs-7 pl-0">{!! Form::radio('dexa_beta','Beta') !!}{!! Form::label('beta','Beta',['class'=>'title']) !!}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 display-inline-block full-width border-bottom mb-10 plr-0">
                <div class="col-md-3 col-sm-3">{!! Form::label('sepsis_in_mother',' RISK FACTORS FOR SEPSIS IN MOTHERS',['class'=>'title']) !!}</div>
                <div class="col-md-8 col-sm-8 display-flex plr-0">
                    <div class="col-md-5 col-sm-5 col-xs-5">{!! Form::radio('sepsisinmother','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                    <div class="col-md-4 col-sm-4 col-xs-4 plr-0">{!! Form::radio('sepsisinmother','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                    <div class="col-md-3 col-sm-3 col-xs-3 pr-0">{!! Form::radio('sepsisinmother','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
                </div>
            </div>
            <div class="col-md-12 display-inline-block plr-0">
                @if (isset($baby->sepsis_in_mother_type))
                @php $sepsis_in_mother_type  = json_decode($baby->sepsis_in_mother_type); @endphp
                @else 
                @php $sepsis_in_mother_type  = ["0"];  @endphp
                @endif
                @php $sepsis_in_mother_type1 = in_array("1", $sepsis_in_mother_type) ? true : false; @endphp  
                @php $sepsis_in_mother_type2 = in_array("2", $sepsis_in_mother_type) ? true : false; @endphp  
                @php $sepsis_in_mother_type3 = in_array("3", $sepsis_in_mother_type) ? true : false; @endphp  
                @php $sepsis_in_mother_type4 = in_array("4", $sepsis_in_mother_type) ? true : false; @endphp  
                @php $sepsis_in_mother_type5 = in_array("5", $sepsis_in_mother_type) ? true : false; @endphp  
                @php $sepsis_in_mother_type6 = in_array("6", $sepsis_in_mother_type) ? true : false; @endphp  
                <h4><b><u>RISK FACTORS</u></b></h4>
                <div class="col-md-offset-3 col-md-9 col-sm-offset-3 col-sm-9 col-xs-12">
                    <div>{!! Form::checkbox('sepsis_in_mother_type[]','1',$sepsis_in_mother_type1) !!}{!! Form::label('chorioamnionitis','Chorioamnionitis',['class'=>'title']) !!}</div>
                    <div>{!! Form::checkbox('sepsis_in_mother_type[]','2',$sepsis_in_mother_type2) !!}{!! Form::label('unclean_vaginal_examination','Unclean vaginal examination / > 3 PV examination',['class'=>'title']) !!}
                    </div>
                    <div>{!! Form::checkbox('sepsis_in_mother_type[]','3',$sepsis_in_mother_type3) !!}{!! Form::label('leaking_pv','Leaking PV > 18hours / pPROM',['class'=>'title']) !!}</div>
                    <div>{!! Form::checkbox('sepsis_in_mother_type[]','4',$sepsis_in_mother_type4) !!}{!! Form::label('gbs_in_maternal_recto-vaginal_swab','GBS in maternal recto-vaginal swab',['class'=>'title']) !!}</div>
                    <div>{!! Form::checkbox('sepsis_in_mother_type[]','5',$sepsis_in_mother_type5) !!}{!! Form::label('uti_in_mother','UTI in mother',['class'=>'title']) !!}</div>
                    <div>{!! Form::checkbox('sepsis_in_mother_type[]','6',$sepsis_in_mother_type6) !!}{!! Form::label('maternal_fever','Maternal fever',['class'=>'title']) !!}</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 display-inline-block">
            <h4><b><u>RESUSCITATION DETAILS</u></b></h4>
            <div class="col-md-12 plr-0">
                <div class="col-md-5 col-sm-5">{!! Form::label('resuscitation_at_birth', 'RESUSCITATION REQUIRED AT BIRTH',['class'=>'title']) !!}</div>
                <div class="col-md-7 col-sm-7 display-flex plr-xs-0">
                    <div class="col-md-4 col-sm-4 col-xs-4">
                        {!! Form::radio('resuscitationatbirth', 'Not available') !!}
                        {!! Form::label('resuscitationatbirth','N/A',['class'=>'title']) !!}
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-4">
                        {!! Form::radio('resuscitationatbirth', 'Yes') !!}
                        {!! Form::label('yes','Yes',['class'=>'title']) !!}
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-4">
                        {!! Form::radio('resuscitationatbirth', 'No') !!}
                        {!! Form::label('no','No',['class'=>'title']) !!}
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 plr-0">
                <div class="col-md-5 col-sm-5">{!! Form::label('initial_steps', 'INITIAL STEPS',['class'=>'title'])!!}</div>
                <div class="col-md-7 col-sm-7 display-flex plr-xs-0">
                    <div class="col-md-4 col-sm-4 col-xs-4">
                        {!! Form::radio('initialsteps', 'N/A') !!}
                        {!! Form::label('N/A','N/A',['class'=>'title']) !!}
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-4">
                        {!! Form::radio('initialsteps', 'Yes') !!}
                        {!! Form::label('yes','Yes',['class'=>'title']) !!}
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-4">
                        {!! Form::radio('initialsteps', 'No') !!}
                        {!! Form::label('no','No',['class'=>'title']) !!}
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 plr-0">
                <div class="col-md-5 col-sm-5">
                    {!! Form::label('ffo2', 'FI O2',['class'=>'title'])!!}
                </div>
                <div class="col-md-7 col-sm-7 display-flex plr-xs-0">
                    <div class="col-md-4 col-sm-4 col-xs-4">
                        {!! Form::radio('ffo2', 'N/A') !!}
                        {!! Form::label('N/A','N/A',['class'=>'title']) !!}
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-4">
                        {!! Form::radio('ffo2', 'Yes') !!}
                        {!! Form::label('yes','Yes',['class'=>'title']) !!}
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-4">
                        {!! Form::radio('ffo2', 'No') !!}
                        {!! Form::label('no','No',['class'=>'title']) !!}
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 plr-0">
                <div class="col-md-9 col-sm-9 plr-0 plr-xs-0">
                    <div class="col-md-5 col-sm-5">
                        {!! Form::label('BMV', 'BMV',['class'=>'title'])!!}
                    </div>
                    <div class="col-md-7 col-sm-7 display-flex plr-0 plr-xs-0">
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            {!! Form::radio('bmv', 'N/A') !!}
                            {!! Form::label('N/A','N/A',['class'=>'title']) !!}
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            {!! Form::radio('bmv', 'Yes') !!}
                            {!! Form::label('yes','Yes',['class'=>'title']) !!}
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-4 pr-0 pl-25 pl-xs-15">
                            {!! Form::radio('bmv', 'No') !!}
                            {!! Form::label('no','No',['class'=>'title']) !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3 display-flex plr-0 plr-xs-0">
                    <div class="col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6 col-xs-9 pl-7 pr-0 plr-xs-15">
                        {!! Form::text('bmv_duration',null,['class'=>'form-control shadow']) !!}
                    </div>
                    <div class="title col-md-3 col-sm-3 col-xs-3 pl-7 pr-0">(sec)</div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 plr-0">
                <div class="col-md-9 col-sm-9 plr-0 plr-xs-0">
                    <div class="col-md-5 col-sm-5">{!! Form::label('BTV', 'BTV',['class'=>'title'])!!}</div>
                    <div class="col-md-7 col-sm-7 display-flex plr-0">
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            {!! Form::radio('btv', 'N/A') !!}
                            {!! Form::label('N/A','N/A',['class'=>'title']) !!}
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            {!! Form::radio('btv', 'Yes') !!}
                            {!! Form::label('yes','Yes',['class'=>'title']) !!}
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-4 pr-0 pl-25 pl-xs-15">
                            {!! Form::radio('btv', 'No') !!}
                            {!! Form::label('no','No',['class'=>'title']) !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3 display-flex plr-0 plr-xs-0">
                    <div class="col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6 col-xs-9 pl-7 pr-0 plr-xs-15">
                        {!! Form::text('btv_duration',null,['class'=>'form-control shadow']) !!}
                    </div>
                    <div class="title col-md-3 col-sm-3 col-xs-3 pl-7 pr-0">(sec)</div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 plr-0">
                <div class="col-md-9 col-sm-9 plr-0 plr-xs-0">
                    <div class="col-md-5 col-sm-5">
                        {!! Form::label('CC', 'CC',['class'=>'title'])!!}
                    </div>
                    <div class="col-md-7 col-sm-7 display-flex plr-0">
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            {!! Form::radio('cc', 'N/A') !!}
                            {!! Form::label('N/A','N/A',['class'=>'title']) !!}
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            {!! Form::radio('cc', 'Yes') !!}
                            {!! Form::label('yes','Yes',['class'=>'title']) !!}
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-4 pr-0 pl-25 pl-xs-15">
                            {!! Form::radio('cc', 'No') !!}
                            {!! Form::label('no','No',['class'=>'title']) !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3 display-flex plr-0 plr-xs-0">
                    <div class="col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6 col-xs-9 pl-7 pr-0 plr-xs-15">
                        {!! Form::text('cc_duration',null,['class'=>'form-control shadow']) !!}
                    </div>
                    <div class="title col-md-3 col-sm-3 col-xs-3 pl-7 pr-0">(sec)</div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 plr-0">
                <div class="col-md-5 col-sm-5">
                    {!! Form::label('Medications', 'MEDICATIONS',['class'=>'title'])!!}
                </div>
                <div class="col-md-7 col-sm-7 display-flex plr-xs-0">
                    <div class="col-md-4 col-sm-4 col-xs-4">
                        {!! Form::radio('medications', 'N/A') !!}
                        {!! Form::label('N/A','N/A',['class'=>'title']) !!}
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-4">
                        {!! Form::radio('medications', 'Yes') !!}
                        {!! Form::label('yes','Yes',['class'=>'title']) !!}
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-4">
                        {!! Form::radio('medications', 'No') !!}
                        {!! Form::label('no','No',['class'=>'title']) !!}
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 plr-0">
                <div class="col-md-5 col-sm-5 col-xs-5">
                    {!! Form::label('details','DETAILS',['class'=>'title']) !!}
                </div>
                <div class="col-md-4 col-sm-4 pr-0 plr-xs-0">
                    <div class="col-md-12 col-sm-12 pr-0 pr-xs-15">
                        {!! Form::select('medication_details',['N/A'=>'N/A','adr'=>'adr','NS'=>'NS','Naloxone'=>'Naloxone','Inotropes'=>'Inotropes','Dextrose Bolus' => 'Dextrose Bolus','Bicarbonate'=> 'Bicarbonate'],null,['class'=>'form-control shadow']) !!}
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 plr-0">
                <h4><b><u>APGAR SCORE</u></b></h4>
            </div>
            <div class="col-md-12 col-sm-12 display-flex plr-0">
                <div class="col-md-5 col-sm-5 col-xs-4">
                    {!! Form::label('apgar','APGAR',['class'=>'title']) !!}
                </div>
                <div class="col-md-7 col-sm-7 pl-30 pl-xs-15">
                    {!! Form::radio('apgarstatus','Not Available') !!}
                    {!! Form::label('apgarstatus','N/A',['class'=>'title']) !!}
                </div>
            </div>
            <div class="col-md-12 col-sm-12 title border-bottom mb-10 plr-0">
                <div class="col-md-12 col-sm-12 display-flex border-bottom mb-10 pr-0">
                    <div class="col-md-4 col-sm-4 col-xs-4 pl-0 pr-20"> 1 min </div>
                    <div class="col-md-4 col-sm-4 col-xs-4 plr-10"> 5 min </div>
                    <div class="col-md-4 col-sm-4 col-xs-4 pl-20 pr-0"> 10 min </div>
                </div>
                <div class="col-md-12 col-sm-12 display-flex">
                    <div class="col-md-4 col-sm-4 col-xs-4 pl-0 pr-20">
                        {!! Form::text('apgar_1_min', null,['class'=>'form-control shadow']) !!}
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-4 plr-10">
                        {!! Form::text('apgar_5_min', null,['class'=>'form-control shadow']) !!}
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-4 pl-20 pr-0">
                        {!! Form::text('apgar_10_min', null,['class'=>'form-control shadow']) !!}
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 display-flex">
                    <div class="col-md-4 col-sm-4 col-xs-4 pl-0 pr-20"> 15 min </div>
                    <div class="col-md-4 col-sm-4 col-xs-4 plr-10"> 20 min </div>
                </div>
                <div class="col-md-12 col-sm-12 display-flex">
                    <div class="col-md-4 col-sm-4 col-xs-4 pl-0 pr-20">
                        {!! Form::text('apgar_15_min', null,['class'=>'form-control shadow']) !!}
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-4 plr-10">
                        {!! Form::text('apgar_20_min', null,['class'=>'form-control shadow']) !!}
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 plr-0">
                <div class="col-md-5 col-sm-5">
                    {!! Form::label('cord_blood_gas','CORD BLOOD GAS',['class'=>'title']) !!}
                </div>
                <div class="col-md-7 col-sm-7 display-flex plr-xs-0">
                    <div class="col-md-4 col-sm-4 col-xs-4">
                        {!! Form::radio('cord_blood_gas','Not Available') !!}
                        {!! Form::label('notavailable',' N/A',['class'=>'title']) !!}
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-8">
                        {!! Form::radio('cord_blood_gas','Not Indicated') !!}
                        {!! Form::label('notindicated','Not Indicated',['class'=>'title']) !!}
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 title border-bottom mb-10 plr-0">
                <div class="col-md-12 col-sm-12 display-flex plr-0">
                    <div class="col-md-5 col-sm-5 col-xs-6">
                        {!! Form::label('ph','PH',['class'=>'title']) !!}
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-6 pr-0">
                        <div class="col-md-12 col-sm-12 pr-0">
                            {!! Form::label('base_deficit',' BASE DEFICIT',['class'=>'title']) !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 display-flex plr-0">
                    <div class="col-md-5 col-sm-5 col-xs-6">
                        {!! Form::text('ph',null,['class'=>'form-control shadow']) !!}
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-6 pr-0">
                        <div class="col-md-12 col-sm-12 pr-0">
                            {!! Form::text('base_deficit',null,['class'=>'form-control shadow']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 plr-0">
                <div class="col-md-5 col-sm-5">
                    {!! Form::label('severe_perinatal_asphyxia','SEVERE PERINATAL ASPHYXIA',['class'=>'title']) !!}
                </div>
                <div class="col-md-7 col-sm-7 display-flex plr-xs-0">
                    <div class="col-md-4 col-sm-4 col-xs-4">
                        {!! Form::radio('severeperinatalasphyxia','N/A') !!}
                        {!! Form::label('N/A','N/A',['class'=>'title']) !!}
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-4">
                        {!! Form::radio('severeperinatalasphyxia','Yes') !!}
                        {!! Form::label('yes','Yes',['class'=>'title']) !!}
                    </div>
                    <div class="col-md-5 col-sm-5 col-xs-4 pr-xs-0">
                        {!! Form::radio('severeperinatalasphyxia','No') !!}
                        {!! Form::label('no','No',['class'=>'title']) !!}
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 plr-0">
                <div class="col-md-5 col-sm-5">
                    {!! Form::label('delayed_cord_clamping','DELAYED CORD CLAMPING',['class'=>'title']) !!}
                </div>
                <div class="col-md-7 col-sm-7 display-flex plr-xs-0">
                    <div class="col-md-4 col-sm-4 col-xs-4">
                        {!! Form::radio('delayedcordclamping','Yes') !!}
                        {!! Form::label('yes','Yes',['class'=>'title']) !!}
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-4">
                        {!! Form::radio('delayedcordclamping','No') !!}
                        {!! Form::label('no','No',['class'=>'title']) !!}
                    </div>
                    <div class="col-md-5 col-sm-5 col-xs-4 pr-xs-0">
                        {!! Form::radio('delayedcordclamping', 'Not known') !!}
                        {!! Form::label('delayedcordclamping','Not known',['class'=>'title']) !!}
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 plr-0">
                <div class="col-md-5 col-sm-5">{!! Form::label('umbilical_cord_milking','UMBILICAL CORD MILKING',['class'=>'title']) !!}</div>
                <div class="col-md-7 col-sm-7 display-flex plr-xs-0">
                    <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('umbilicalcordmilking','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                    <div class="col-md-3 col-sm-3 col-xs-4">{!! Form::radio('umbilicalcordmilking','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
                    <div class="col-md-5 col-sm-5 col-xs-4 pr-xs-0">{!! Form::radio('umbilicalcordmilking', 'Not known') !!}{!! Form::label('umbilicalcordmilking','Not known',['class'=>'title']) !!}</div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 plr-0">
                <div class="col-md-5 col-sm-5">{!! Form::label('cut_cord_milking','CUT CORD MILKING',['class'=>'title']) !!}</div>
                <div class="col-md-7 col-sm-7 display-flex plr-xs-0">
                    <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('cutcordmilking','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                    <div class="col-md-3 col-sm-3 col-xs-4">{!! Form::radio('cutcordmilking','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
                    <div class="col-md-5 col-sm-5 col-xs-4 pr-xs-0">{!! Form::radio('cutcordmilking', 'Not known') !!}{!! Form::label('cutcordmilking','Not known',['class'=>'title']) !!}</div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 plr-0">
                <h4><b><u>ADMISSION / COURSE DURING STAY</u></b></h4>
                <div class="col-md-5 col-sm-5">{!! Form::label('indication_of_admission','INDICATION FOR ADMISSION',['class'=>'title']) !!}</div>
                <div class="col-md-7 col-sm-7 pl-30 pl-xs-15">
                    @php $indication = (isset($baby->indication_of_admission) && !is_null($baby->indication_of_admission)) ? json_decode($baby->indication_of_admission) : array() @endphp
                    @php $indication1 = (!is_null($indication) && in_array('1',$indication)) ? true : false; @endphp
                    @php $indication2 = (!is_null($indication) && in_array('2',$indication)) ? true : false; @endphp
                    @php $indication3 = (!is_null($indication) && in_array('3',$indication)) ? true : false; @endphp
                    @php $indication4 = (!is_null($indication) && in_array('4',$indication)) ? true : false; @endphp
                    @php $indication5 = (!is_null($indication) && in_array('5',$indication)) ? true : false; @endphp
                    @php $indication6 = (!is_null($indication) && in_array('6',$indication)) ? true : false; @endphp
                    @php $indication7 = (!is_null($indication) && in_array('7',$indication)) ? true : false; @endphp
                    <div>
                        {!! Form::checkbox('indication_of_admission[]',1,$indication1) !!}
                        {!! Form::label('Prematurity','Prematurity',['class'=>'title']) !!}
                    </div>
                    <div>
                        {!! Form::checkbox('indication_of_admission[]',2,$indication2) !!}
                        {!! Form::label('Low birth weight','Low birth weight',['class'=>'title']) !!}
                    </div>
                    <div>
                        {!! Form::checkbox('indication_of_admission[]',3,$indication3) !!}
                        {!! Form::label('RD','RD',['class'=>'title']) !!}
                    </div>
                    <div>
                        {!! Form::checkbox('indication_of_admission[]',4,$indication4) !!}
                        {!! Form::label('Birth asphyxia','Birth asphyxia',['class'=>'title']) !!}
                    </div>
                    <div>
                        {!! Form::checkbox('indication_of_admission[]',5,$indication5) !!}
                        {!! Form::label('Sepsis','Sepsis',['class'=>'title']) !!}
                    </div>
                    <div>
                        {!! Form::checkbox('indication_of_admission[]',6,$indication6) !!}
                        {!! Form::label('Shock','Shock',['class'=>'title']) !!}
                    </div>
                    <div>
                        {!! Form::checkbox('indication_of_admission[]',7,$indication7) !!}
                        {!! Form::label('Jaundice','Jaundice',['class'=>'title']) !!}
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 border-bottom mb-10 plr-0">
                <div class="col-md-5 col-sm-5">{!! Form::label('indication_of_admission_other','OTHERS (specify)',['class'=>'otherspecify title']) !!}</div>
                <div class="col-md-4 col-sm-4 pr-0 pl-xs-0">
                    <div class="col-md-12 col-sm-12 pr-0">
                        {!! Form::text('indication_of_admission_other',null,['class'=>'form-control shadow']) !!}
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 plr-0">
                <div class="col-md-5 col-sm-5">{!! Form::label('respiratory_distress_at_birth','RESPIRATORY DISTRESS AT BIRTH',['class'=>'title']) !!}</div>
                <div class="col-md-7 col-sm-7 display-flex plr-xs-0">
                    <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('respiratorydistressat_birth','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                    <div class="col-md-3 col-sm-3 col-xs-3">{!! Form::radio('respiratorydistressat_birth','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                    <div class="col-md-5 col-sm-5 col-xs-5">{!! Form::radio('respiratorydistressat_birth','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 plr-0">
                <div class="col-md-5 col-sm-5">{!! Form::label('surfactant_given','SURFACTANT GIVEN',['class'=>'title']) !!}</div>
                <div class="col-md-7 col-sm-7 display-flex plr-xs-0">
                    <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('surfactantgiven','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                    <div class="col-md-3 col-sm-3 col-xs-3">{!! Form::radio('surfactantgiven','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                    <div class="col-md-5 col-sm-5 col-xs-5">{!! Form::radio('surfactantgiven','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12">
                {!! Form::label('surfactant_type','TYPE',['class'=>'title']) !!}
                @php $sepsis_in_mother_type = (isset($baby->surfactant_type) && !is_null($baby->surfactant_type)) ? json_decode($baby->surfactant_type) : array() @endphp
                @php $surfactant_type1 = (!is_null($sepsis_in_mother_type) && in_array('1',$sepsis_in_mother_type)) ? true : false; @endphp
                @php $surfactant_type2 = (!is_null($sepsis_in_mother_type) && in_array('2',$sepsis_in_mother_type)) ? true : false; @endphp
                @php $surfactant_type3 = (!is_null($sepsis_in_mother_type) && in_array('3',$sepsis_in_mother_type)) ? true : false; @endphp
                <div class="col-md-offset-5 col-md-7 col-sm-offset-5 col-sm-7 pl-30 pl-xs-0">
                    <div>
                        {!! Form::checkbox('surfactant_type[]','1',$surfactant_type1) !!}
                        {!! Form::label('survanta','Survanta',['class'=>'title']) !!}
                    </div>
                    <div>
                        {!! Form::checkbox('surfactant_type[]','2',$surfactant_type2) !!}
                        {!! Form::label('curosurf','Curosurf',['class'=>'title']) !!}
                    </div>
                    <div>
                        {!! Form::checkbox('surfactant_type[]','3',$surfactant_type3) !!}
                        {!! Form::label('neosurf','neosurf',['class'=>'title']) !!}
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 border-bottom mb-10 plr-0">
                <h4><b><u>AGE AT ADMINISTRATION (hours)</u></b></h4>
                <div class="col-md-12 col-sm-12 display-flex title plr-0">
                    <div class="col-md-4 col-sm-4 col-xs-6"> First </div>
                    <div class="col-md-offset-1 col-md-4 col-sm-offset-1 col-sm-4 col-xs-6 pr-0">
                        <div class="col-md-12 col-sm-12 pr-0"> Second </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 display-flex title plr-0">
                    <div class="col-md-4 col-sm-4 col-xs-6">{!! Form::text('age_first', null,['class'=>'form-control shadow']) !!}</div>
                    <div class="col-md-offset-1 col-md-4 col-sm-offset-1 col-sm-4 col-xs-6 pr-0">
                        <div class="col-md-12 col-sm-12 pr-0">{!! Form::text('age_second', null,['class'=>'form-control shadow']) !!}</div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 display-flex title plr-0">
                    <div class="col-md-4 col-sm-4 col-xs-6"> Third </div>
                    <div class="col-md-offset-1 col-md-4 col-sm-offset-1 col-sm-4 col-xs-6 pr-0">
                        <div class="col-md-12 col-sm-12 pr-0"> Fourth </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 display-flex title plr-0">
                    <div class="col-md-4 col-sm-4 col-xs-6">{!! Form::text('age_third', null,['class'=>'form-control shadow']) !!}</div>
                    <div class="col-md-offset-1 col-md-4 col-sm-offset-1 col-sm-4 col-xs-6 pr-0">
                        <div class="col-md-12 col-sm-12 pr-0">{!! Form::text('age_fourth', null,['class'=>'form-control shadow']) !!}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 display-flex plr-0">
                <div class="col-md-5 col-sm-5 col-xs-6">{!! Form::label('total_number_of_doses','TOTAL NUMBER OF DOSES',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-6 pr-0">
                    <div class="col-md-12 col-sm-12 pr-0">
                        {!! Form::text('total_number_of_doses',null,['class'=>'form-control shadow margin-left']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
