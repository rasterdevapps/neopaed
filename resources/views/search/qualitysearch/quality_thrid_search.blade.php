<div class="col-md-12 plr-0">
    <div class="col-md-12">
        <h4><b><u>FEEDING</u></b></h4>
    </div>
    <div class="col-md-12 display-sm-inline-block full-width border-bottom mb-10">
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('started', 'STARTED',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex">
                <div class="col-md-8 col-sm-8 col-xs-8 plr-xs-0">{!! Form::text('feeding_start_hours',null,['class'=>'form-control shadow']) !!}</div>
                <div class="title col-xs-4 pr-0">hours /</div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-offset-0 col-md-7 col-sm-offset-5 col-sm-7 display-flex">
                <div class="col-md-8 col-sm-8 col-xs-8 plr-xs-0">{!! Form::text('feeding_start_dof',null,['class'=>'form-control shadow']) !!}</div>
                <div class="title col-xs-4 pr-0">days of life</div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 plr-0">
            <div class="col-md-6 plr-0">
                <div class="col-md-5 col-sm-5">{!! Form::label('feeding_amount_start', 'AMOUNT STARTED',['class'=>'title']) !!}</div>
                <div class="col-md-7 col-sm-7 display-flex">
                    <div class="col-md-8 col-sm-8 col-xs-8 plr-xs-0">{!! Form::text('feeding_amount_start',null,['class'=>'form-control shadow']) !!}</div>
                    <div class="title col-xs-4 pr-0">(ml / Kg / day)</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('full_feed_time', 'TIME TO ACHIEVE FULL FEEDS (150ml / kg) (Days)',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex">
                <div class="col-md-8 col-sm-8 col-xs-8 plr-xs-0">{!! Form::text('full_feed_time',null,['class'=>'form-control shadow']) !!}</div>
                <div class="title col-xs-4 pr-0">(ml / Kg / day)</div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('expired_prior_event_full_feed','EXPIRED PRIOR TO THE EVENT',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex">
                <div class="col-md-8 col-sm-8 col-xs-8 plr-xs-0">{!! Form::text('expired_prior_event_full_feed',null,['class'=>'form-control shadow']) !!}</div>
            </div>
        </div>
        <div class="col-md-12 plr-0">
            <div class="col-md-6 col-sm-12 plr-0">
                <div class="col-md-5 col-sm-5">{!! Form::label('regain_birth_weight','DAY OF REGAINING BIRTH WEIGHT',['class'=>'title']) !!}</div>
                <div class="col-md-7 col-sm-7 display-flex">
                    <div class="col-md-8 col-sm-8 col-xs-8 plr-xs-0">{!! Form::text('regain_birth_weight',null,['class'=>'form-control shadow']) !!}</div>
                    <div class="title col-xs-4 pr-0">(ml / Kg / day)</div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 plr-0">
                <div class="col-md-5 col-sm-5">{!! Form::label('expired_prior_event_regain_weight','EXPIRED PRIOR TO THE EVENT',['class'=>'title']) !!}</div>
                <div class="col-md-7 col-sm-7 display-flex">
                    <div class="col-md-8 col-sm-8 col-xs-8 plr-xs-0">{!! Form::text('expired_prior_event_regain_weight',null,['class'=>'form-control shadow']) !!}</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('probiotics', 'PROBIOTICS',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex plr-xs-0">
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('probiotics','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('probiotics','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('probiotics','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('brand_name','Name of the brand used',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex pr-0 plr-xs-0">
                <div class="col-md-4 col-sm-4 col-xs-4 pr-0">{!! Form::radio('brand_name','Rescunate') !!}{!! Form::label('rescunate','Rescunate',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4 pr-0">{!! Form::radio('brand_name','Darolac') !!}{!! Form::label('darolac','Darolac',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4 pr-0">{!! Form::radio('brand_name','Others') !!}{!! Form::label('others','Others',['class'=>'title']) !!}</div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('probiotics_usage','DURATION OF PROBIOTICS USAGE',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex">
                <div class="col-md-8 col-sm-8 col-xs-8 plr-xs-0">{!! Form::text('probiotics_usage',null,['class'=>'form-control shadow']) !!}</div>
                <div class="title col-xs-4 pr-0">(days)</div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('probiotics_stopped','PMA STOPPED AT',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex">
                <div class="col-md-8 col-sm-8 col-xs-8 plr-xs-0">{!! Form::text('probiotics_stopped',null,['class'=>'form-control shadow']) !!}</div>
                <div class="title col-xs-4 pr-0">(Weeks)</div>
            </div>
        </div>
    </div>
    <div class="col-md-12 display-inline-block full-width border-bottom mb-10 content-horizontal-center">
        <div class="col-md-6 col-sm-12 border-right mb-10 plr-0">
            <div class="col-md-12 col-sm-12 plr-0">
                <div class="col-md-5 col-sm-5">{!! Form::label('total_pn','WHETHER TOTAL PARENTERAL NUTRITION OR ivf INITIATED AT ADMISSION',['class'=>'title']) !!}</div>
                <div class="col-md-7 col-sm-7 display-flex plr-xs-0">
                    <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('total_pn','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                    <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('total_pn','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                    <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('total_pn','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 plr-0">
                <div class="col-md-5 col-sm-5">{!! Form::label('total_pn_duration','IF YES, THEN DURATION OF USE (in days)',['class'=>'title']) !!}</div>
                <div class="col-md-7 col-sm-7 display-flex">
                    <div class="col-md-8 col-sm-8 col-xs-8 plr-xs-0">{!! Form::text('total_pn_duration',null,['class'=>'form-control shadow']) !!}</div>
                    <div class="title col-xs-4 pr-0">(days)</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('hyperbilirubinemia','HYPERBILIRUBINEMIA',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex plr-xs-0">
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('hyperbilirubinemia','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('hyperbilirubinemia','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('hyperbilirubinemia','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
            </div>
        </div>
    </div>
    <div class="col-md-12 plr-30">
        <table class="table">
            <tbody class="tableborder">
                <tr>
                    <td class="overflow-auto">PHOTOTHERAPY (total)</td>
                    <td class="overflow-auto">
                        <div class="col-md-1 col-sm-2">HOURS</div>
                        <div class="col-md-11 col-sm-10">{!! Form::text('phototherapy_hours',null,['class'=>'custom-form-control form-control shadow']) !!}</div>
                    </td>
                </tr>
                <tr>
                    <td class="overflow-auto">DVET</td>
                    <td class="overflow-auto">
                        <div class="col-md-2 col-sm-4 col-xs-4">{!! Form::radio('dvet','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                        <div class="col-md-2 col-sm-4 col-xs-4">{!! Form::radio('dvet','one') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                        <div class="col-md-2 col-sm-4 col-xs-4">{!! Form::radio('dvet','two') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
                    </td>
                </tr>
                <tr>
                    <td class="overflow-auto">MAXIMUM BILIRUBIN (mg/dl)</td>
                    <td class="overflow-auto">{!! Form::text('max_bilirubin',null,['class'=>'custom-form-control form-control shadow']) !!}
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-12 display-inline-block full-width border-bottom mb-10">
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('seizures','SEIZURES',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex plr-xs-0">
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('seizures','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('seizures','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('seizures','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('anticonvulsants','ANTICONVULSANTS',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex plr-xs-0">
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('anticonvulsants','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('anticonvulsants','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('anticonvulsants','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
            </div>
        </div>
        <div class="col-md-offset-6 col-md-6 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('seizures_duration','DURATION OF ANTICONVULSANTS USE',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex">
                <div class="col-md-8 col-sm-8 col-xs-8 plr-xs-0">{!! Form::text('seizures_duration',null,['class'=>'form-control shadow']) !!}</div>
                <div class="title col-xs-4 pr-0">(Days)</div>
            </div>
        </div>
    </div>
    <div class="col-md-12 display-inline-block full-width border-bottom mb-10">
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('patent_ductus_arteriosus','HS PATENT DUCTUS ARTERIOSUS',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex plr-xs-0">
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('patent_ductus_arteriosus','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('patent_ductus_arteriosus','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('patent_ductus_arteriosus','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
            </div>
        </div>
    </div>
    <div class="col-md-10 display-inline-block full-width">
        <div class="col-md-3 col-sm-3">{!! Form::label('medical','MEDICAL &#8478;',['class'=>'title']) !!}</div>
        <div class="col-md-8 col-sm-9 display-flex plr-xs-0">
            <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('pda_medicine','Indomethacin') !!}{!! Form::label('pda_medicine','INDOMETHACIN',['class'=>'title']) !!}</div>
            <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('pda_medicine','Brufen') !!}{!! Form::label('pda_medicine','BRUFEN',['class'=>'title']) !!}</div>
            <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('pda_medicine','Paracetamol') !!}{!! Form::label('pda_medicine','PARACETAMOL',['class'=>'title']) !!}</div>
        </div>
    </div>
    <div class="col-md-12 display-inline-block full-width">
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('surgical_ligation','SURGICAL LIGATION',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex plr-xs-0">
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('surgical_ligation','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('surgical_ligation','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('surgical_ligation','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
            </div>
        </div>
    </div>
    <div class="col-md-12 display-inline-block full-width">
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('centeral_line','CENTRAL LINE',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex plr-xs-0">
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('centeralline','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('centeralline','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('centeralline','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
            </div>
        </div>
    </div>
    <div class="col-md-10 display-inline-block full-width">
        @php $central_line_type = (isset($baby->central_line_type) && !is_null($baby->central_line_type)) ? json_decode($baby->central_line_type) : array(); @endphp
        @php $linetype1 = (!is_null($central_line_type) && in_array('1',$central_line_type)) ? true : false; @endphp
        @php $linetype2 = (!is_null($central_line_type) && in_array('2',$central_line_type)) ? true : false; @endphp
        @php $linetype3 = (!is_null($central_line_type) && in_array('3',$central_line_type)) ? true : false; @endphp
        @php $linetype4 = (!is_null($central_line_type) && in_array('4',$central_line_type)) ? true : false; @endphp
        <div class="col-md-3 col-sm-3">{!! Form::label('central_line_type[]','CENTRAL LINE TYPE',['class'=>'title']) !!}</div>
        <div class="col-md-8 col-sm-9 display-flex plr-xs-0">
            <div class="col-md-2 col-sm-2 col-xs-3">
                {!! Form::checkbox('central_line_type[]','1',$linetype1) !!}
                {!! Form::label('uvc','UVC',['class'=>'title']) !!}
            </div>
            <div class="col-md-2 col-sm-2 col-xs-3">
                {!! Form::checkbox('central_line_type[]','2',$linetype2) !!}
                {!! Form::label('uac','UAC',['class'=>'title']) !!}
            </div>
            <div class="col-md-2 col-sm-2 col-xs-3">
                {!! Form::checkbox('central_line_type[]','3',$linetype3) !!}
                {!! Form::label('picc','PICC',['class'=>'title']) !!}
            </div>
            <div class="col-md-4 col-sm-4 col-xs-3">
                {!! Form::checkbox('central_line_type[]','4',$linetype4) !!}
                {!! Form::label('central_line','CENTRAL LINE',['class'=>'title']) !!}
            </div>
        </div>
    </div>
    <div class="col-md-12 display-inline-block full-width border-bottom mb-10">
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('total_duration_of_line','TOTAL DURATION OF LINE (Days)',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex">
                <div class="col-md-8 col-sm-8 col-xs-8 plr-xs-0">{!! Form::text('total_duration_of_line',null,['class'=>'form-control shadow']) !!}</div>
            </div>
        </div>
    </div>
    <div class="col-md-12 display-inline-block full-width border-bottom mb-10">
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('hearing_screen_done','HEARING SCREEN DONE',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex plr-xs-0">
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('hearing_screen_done','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('hearing_screen_done','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('hearing_screen_done','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('hearscreen_result','HEARING SCREEN RESULT',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex pr-0 plr-xs-0">
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('hearscreen_result','Normal') !!}{!! Form::label('hearscreen_result','Normal',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4 pr-0">{!! Form::radio('hearscreen_result','Abnormal') !!}{!! Form::label('hearscreen_result','Abnormal',['class'=>'title']) !!}</div>
            </div>
        </div>
    </div>
    <div class="col-md-12 display-inline-block full-width border-bottom">
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('caffeine_use','CAFFEINE USE',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex plr-xs-0">
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('caffeine_use','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('caffeine_use','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('caffeine_use','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('pma','PMA AT WHICH IT WAS STOPPED',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex">
                <div class="col-md-8 col-sm-8 col-xs-8 plr-xs-0">{!! Form::text('caffeine_use_val',null,['class'=>'form-control shadow']) !!}</div>
                <div class="title col-xs-4 pr-0"> (Weeks) </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <h4><u><b>BLOOD COMPONENT THERAPY</b></u></h4>
    </div>
    <div class="col-md-12 display-inline-block full-width border-bottom mb-10">
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('received_prbc','RECEIVED PRBC',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex plr-xs-0">
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('received_prbc','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('received_prbc','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('received_prbc','No') !!}{!! Form::label('no','NO',['class'=>'title']) !!}</div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('total_prbc_transfusions',' TOTAL NUMBER OF PRBC TRANSFUSIONS',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex">
                <div class="col-md-8 col-sm-8 col-xs-8 plr-xs-0">
                    {!! Form::text('total_prbc_transfusions',null,['class'=>'form-control shadow']) !!}
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('received_platelet','RECEIVED PLATELET',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex plr-xs-0">
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('receivedplatelet','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('receivedplatelet','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('receivedplatelet','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('fresh_frozen_plasma','FRESH FROZEN PLASMA',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex plr-xs-0">
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('freshfrozenplasma','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('freshfrozenplasma','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('freshfrozenplasma','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
            </div>
        </div>
    </div>
    <div class="col-md-12 display-inline-block full-width plr-0">
        <div class="col-md-6 col-sm-12 pl-0">
            <div class="col-md-5 col-sm-5">
                <h4><u><b>OUTCOMES</b></u></h4>
            </div>
            <div class="col-md-7 col-sm-7 display-flex pr-xs-0">
                <div class="col-md-8 col-sm-8 col-xs-8 pl-sm-25 pr-xs-5 pl-md-30 pr-0 pr-sm-15">
                    {!! Form::select('outcome_result',[''=>'N/A','Death'=>'Death','Discharge'=>'Discharge','LAMA'=>'LAMA'],null,['class'=>'form-control shadow']) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 display-inline-block full-width border-bottom">
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('hospital_stay','DURATION OF HOSPITAL STAY (days)',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex">
                <div class="col-md-8 col-sm-8 col-xs-8 plr-xs-0">
                    {!! Form::text('hospital_stay',null,['class'=>'form-control shadow']) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <h4><u><b>MORBIDITIES</b></u></h4>
    </div>
    <div class="col-md-12 display-inline-block full-width">
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('EUGR','EUGR',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex plr-xs-0">
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('eugr','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('eugr','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('eugr','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
            </div>
        </div>
    </div>
    <div class="col-md-12 display-inline-block full-width">
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('congenital_heart_disease','CONGENITAL HEART DISEASE (excluding PFO/PDA)',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex plr-xs-0">
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('congenital_heart_disease','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('congenital_heart_disease','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('congenital_heart_disease','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
            </div>
        </div>
    </div>
    <div class="col-md-12 display-inline-block full-width">
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('rds:','RESPIRATORY DISTRESS SYNDROME',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex plr-xs-0">
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('rds','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('rds','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('rds','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
            </div>
        </div>
    </div>
    <div class="col-md-12 display-inline-block full-width">
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('pneumothorax','PNEUMOTHORAX',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex plr-xs-0">
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('pneumothorax','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('pneumothorax','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('pneumothorax','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
            </div>
        </div>
    </div>
    <div class="col-md-12 display-inline-block full-width">
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('pphn','PPHN',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex plr-xs-0">
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('pphn','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('pphn','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('pphn','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
            </div>
        </div>
    </div>
    <div class="col-md-12 display-inline-block full-width border-bottom mb-10">
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('intar_hommorrhage','INTARVENTRICULAR HEMORRHAGE',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex plr-xs-0">
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('intar_hommorrhage','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('intar_hommorrhage','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('intar_hommorrhage','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
            </div>
        </div>
    </div>
    <div class="col-md-12 display-inline-block full-width">
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('max_grade','MAX GRADE',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 plr-xs-0">
                <div class="col-md-2 col-sm-2">{!! Form::label('max_grade_rt','Rt',['class'=>'title']) !!}</div>
                <div class="col-md-8 col-sm-8 display-flex plr-0">
                    <div class="col-md-12 col-sm-12 col-xs-8">
                        {!! Form::select('max_grade_rt',QualityHelpers::GetMaxgrade(),null,['class'=>'form-control shadow']) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-offset-0 col-md-7 col-sm-offset-5 col-sm-7 plr-xs-0">
                <div class="col-md-2 col-sm-2 pl-0 pl-xs-15 plr-sm-15">{!! Form::label('max_grade_lt','Lt',['class'=>'title']) !!}</div>
                <div class="col-md-8 col-sm-8 display-flex plr-0">
                    <div class="col-md-12 col-sm-12 col-xs-8">
                        {!! Form::select('max_grade_lt',QualityHelpers::GetMaxgrade(),null,['class'=>'form-control shadow']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 display-inline-block full-width border-bottom mb-10">
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('nec','NECROTISING ENTEROCOITIS (NEC)',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex plr-xs-0">
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('nec','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('nec','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('nec','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
            </div>
        </div>
    </div>
    <div class="col-md-12 display-inline-block full-width">
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('nec_max_stage','MAX STAGE',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex plr-xs-0">
                <div class="col-md-8 col-sm-8 col-xs-8">
                    {!! Form::select('nec_max_stage',QualityHelpers::GetMaxStage(),null,['class'=>'form-control shadow']) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 display-inline-block full-width">
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('PPD','PPD',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex plr-xs-0">
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('ppd','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('ppd','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('ppd','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('Surgery','SURGERY',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex plr-xs-0">
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('surgery','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('surgery','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('surgery','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
            </div>
        </div>
    </div>
    <div class="col-md-12 display-inline-block full-width ">
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('congenital_pneumonia','CONGENITAL PNEUMONIA',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex plr-xs-0">
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('congenital_pneumonia','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('congenital_pneumonia','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('congenital_pneumonia','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('pulmonary_hemorrahge','PULMONARY HEMORRAHGE',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex plr-xs-0">
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('pulmonary_hemorrahge','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('pulmonary_hemorrahge','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('pulmonary_hemorrahge','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
            </div>
        </div>
    </div>
    <div class="col-md-12 display-inline-block full-width">
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('rop','RETINOPATHY OF PREMATURITY',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex plr-xs-0">
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('rop','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('rop','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('rop','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
            </div>
        </div>
    </div>
    <div class="col-md-12 display-inline-block full-width">
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('rt_eye_grade','RT EYE : MAX GRADE / STAGE',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex">
                <div class="col-md-8 col-sm-8 col-xs-8 plr-xs-0">
                    {!! Form::text('rt_eye_grade',null,['class'=>'form-control shadow']) !!}
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('lt_eye_grade','LT EYE : MAX GRADE / STAGE',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex">
                <div class="col-md-8 col-sm-8 col-xs-8 plr-xs-0">
                    {!! Form::text('lt_eye_grade',null,['class'=>'form-control shadow']) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 display-inline-block full-width">
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('rop_treatment_required','ROP TREATMENT REQUIRED',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex plr-xs-0">
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('rop_treatment_required','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('rop_treatment_required','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('rop_treatment_required','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
            </div>
        </div>
    </div>
    <div class="col-md-12 display-inline-block full-width">
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('pventricular_leukomalacia','PERIVENTRICULAR LEUKOMALACIA',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex plr-xs-0">
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('pventricular_leukomalacia','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('pventricular_leukomalacia','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('pventricular_leukomalacia','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
            </div>
        </div>
    </div>
    <div class="col-md-12 display-inline-block full-width border-bottom mb-10">
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('cystic_pvl','CYSTIC PVL',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex plr-xs-0">
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('cystic_pvl','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('cystic_pvl','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('cystic_pvl','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
            </div>
        </div>
    </div>
    <div class="col-md-12 display-inline-block full-width border-bottom mb-10">
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('bronchopulmonary_dysplasia','BPD',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex plr-xs-0">
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('bronchopulmonary_dysplasia','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('bronchopulmonary_dysplasia','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('bronchopulmonary_dysplasia','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-offset-0 col-md-5 col-sm-offset-5 col-sm-7 plr-0 plr-sm-15 plr-xs-0">
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('dysplasia_stage','Mild') !!}{!! Form::label('mild','Mild',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4 plr-0 plr-sm-15 plr-xs-15">{!! Form::radio('dysplasia_stage','Moderate') !!}{!! Form::label('moderate','Moderate',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4 plr-0 plr-sm-15 plr-xs-15">{!! Form::radio('dysplasia_stage','severe') !!}{!! Form::label('severe','severe',['class'=>'title']) !!}</div>
            </div>
            <div class="col-md-offset-0 col-md-7 col-sm-offset-5 col-sm-7">
                <div class="col-md-8 col-sm-8 col-xs-8 plr-xs-0">
                    {!! Form::text('dysplasia_details',null,['class'=>'form-control shadow']) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 display-inline-block full-width">
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">
                {!! Form::label('acute_renal_failure','ACUTE RENAL FAILURE',['class'=>'title']) !!}
                <div class="title title-increase"><b>(Increase in Scr > 0.3 mg/dl from baseline)</b></div>
            </div>
            <div class="col-md-7 col-sm-7 display-flex plr-xs-0">
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('acute_renal_failure','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('acute_renal_failure','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('acute_renal_failure','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
            </div>
        </div>
    </div>
    <div class="col-md-12 display-inline-block full-width">
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('VAP','VAP',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex plr-xs-0">
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('vap','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('vap','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('vap','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
            </div>
        </div>
    </div>
    <div class="col-md-12 display-inline-block full-width">
        <div class="col-md-6 col-sm-12 plr-0">
            <div class="col-md-5 col-sm-5">{!! Form::label('osteopenia_prematurity','OSTEOPENIA OF PREMATURITY',['class'=>'title']) !!}</div>
            <div class="col-md-7 col-sm-7 display-flex plr-xs-0">
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('osteopenia_prematurity','N/A') !!}{!! Form::label('N/A','N/A',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('osteopenia_prematurity','Yes') !!}{!! Form::label('yes','Yes',['class'=>'title']) !!}</div>
                <div class="col-md-4 col-sm-4 col-xs-4">{!! Form::radio('osteopenia_prematurity','No') !!}{!! Form::label('no','No',['class'=>'title']) !!}</div>
            </div>
        </div>
    </div>
    <div class="col-md-12 plr-30">
        {!! Form::label('death','IN CASE OF DEATH , PREDOMINANT CAUSE',['class'=>'title']) !!}
        @php $case_death = (isset($baby->case_death) && !is_null($baby->case_death)) ? json_decode($baby->case_death) : array(); @endphp
        @php $case_death1 = (!is_null($case_death) && in_array('1',$case_death)) ? true : false; @endphp
        @php $case_death2 = (!is_null($case_death) && in_array('2',$case_death)) ? true : false; @endphp
        @php $case_death3 = (!is_null($case_death) && in_array('3',$case_death)) ? true : false; @endphp
        @php $case_death4 = (!is_null($case_death) && in_array('4',$case_death)) ? true : false; @endphp
        @php $case_death5 = (!is_null($case_death) && in_array('5',$case_death)) ? true : false; @endphp
        @php $case_death6 = (!is_null($case_death) && in_array('6',$case_death)) ? true : false; @endphp
        <div class="col-md-offset-1 col-md-11 plr-xs-0">
            {!! Form::checkbox('case_death[]','1', $case_death1) !!}
            {!! Form::label('extreme_prematurity','Extreme prematurity',['class'=>'title']) !!}
        </div>
        <div class="col-md-offset-1 col-md-11 plr-xs-0">
            {!! Form::checkbox('case_death[]','2', $case_death2) !!}
            {!! Form::label('respiratory_failure','Respiratory failure',['class'=>'title']) !!}
        </div>
        <div class="col-md-offset-1 col-md-11 plr-xs-0">
            {!! Form::checkbox('case_death[]','3', $case_death3) !!}
            {!! Form::label('sepsis','Sepsis',['class'=>'title']) !!}
        </div>
        <div class="col-md-offset-1 col-md-11 plr-xs-0">
            {!! Form::checkbox('case_death[]','4', $case_death4) !!}
            {!! Form::label('perinatal_asphyxia','Perinatal asphyxia',['class'=>'title']) !!}
        </div>
        <div class="col-md-offset-1 col-md-11 plr-xs-0">
            {!! Form::checkbox('case_death[]','5', $case_death5) !!}
            {!! Form::label('ivh','IVH',['class'=>'title']) !!}
        </div>
        <div class="col-md-offset-1 col-md-11 plr-xs-0">
            {!! Form::checkbox('case_death[]','6', $case_death6) !!}
            {!! Form::label('nec','NEC',['class'=>'title']) !!}
        </div>
    </div>
    <div class="col-md-12 border-bottom mb-10 plr-30">
        <h6><u><b>OTHERS</b></u></h6>
        <div class="col-md-offset-1 col-md-4 plr-xs-0">
            {!! Form::textarea('others_case_death',null,['class'=>'form-control shadow','rows'=> 3, 'cols'=> 40]) !!}
        </div>
    </div>
</div>
