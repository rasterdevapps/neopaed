<style type="text/css">
    .bootbox-close-button.close {
        /*display: none;*/
    }
</style>
<div role="tabpanel" class="tabbable tabbable-custom">
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#observation"  role="tab" data-toggle="tab"> Baby Observations </a>
        </li>
        <li role="presentation">
            <a href="#respiratory_support" role="tab" data-toggle="tab">Respiratory Support</a>
        </li>
        <li role="presentation">
            <a href="#milk_feeds_output" role="tab" data-toggle="tab">Milk Feeds & Output</a>
        </li>
        <li role="presentation">
            <a href="#pn_drugs" role="tab" data-toggle="tab">PN & Drug Infusions</a>
        </li>
        <li role="presentation">
            <a href="#replacement_fluids" role="tab" data-toggle="tab">Replacement Fluids</a>
        </li>
        <li role="presentation">
            <a href="#input-output" role="tab" data-toggle="tab">Input & Output</a>
        </li>
        <li role="presentation" >
            <a href="#important-blood-values" role="tab" data-toggle="tab">Important Blood Values</a>
        </li>
        <li role="presentation">
            <a href="#gluco-meter" role="tab" data-toggle="tab" id="gluco-meters">Lab Results</a>
        </li>
        <li role="presentation">
            <a href="#ward-rounds" role="tab" data-toggle="tab">Ward Rounds Instruction</a>
        </li>
        <li role="presentation">
            <a href="#media_tab" role="tab" data-toggle="tab">Attachments</a>
        </li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content tab-view-shadow nurse-sheet-edit">
        <div class="hidden">
            {!! Form::select('temp_time_hour',$time_master['time'], null, ['class'=>'form-control']) !!}
            {!! Form::select('temp_time_min',$time_master['mins'], null, ['class'=>'form-control']) !!}
            {!! Form::select('temp_time_session',$time_master['session'], null, ['class'=>'form-control']) !!}
        </div>
        <div role="tabpanel" class="tab-pane active" id="observation" >
            <div class="col-md-12 plr-0">
                <table class="table table-wrapper">
                    <thead>
                        <tr>
                            <th></th>
                            @foreach($time_slots as $time_key => $timevalue)                           
                            @php $slot = explode(":", $timevalue)[1]; @endphp
                            @php $slot1 = explode(":", $timevalue)[2]; @endphp
                            <th class="text-center">{{ $slot }}:{{ $slot1 }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Type of Care:</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $typeofcare = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'type_of_care', 'intf_ref_value'); @endphp
                            @php $typeofcare_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'type_of_care', 'id', $i); @endphp                        
                            <td>{!! Form::select('type_of_care['.$typeofcare_code.']',ValuelistHelpers::gettypeofcate(),$typeofcare,['class'=>'form-control']) !!}</td>
                            @else
                            <td>{!! Form::select('type_of_care['.$time_slots[$i].']',ValuelistHelpers::gettypeofcate(),null,['class'=>'form-control']) !!}</td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>Warmer Temperature:</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $warmer = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'warmer', 'intf_ref_value'); @endphp
                            @php $warmer_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'warmer', 'id', $i); @endphp                        
                            <td>{!! Form::text('warmer['.$warmer_code.']',$warmer,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Warmer Temperature - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @else
                            <td>{!! Form::text('warmer['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Warmer Temperature - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>Incubator Temperature:</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $incubator = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'incubator', 'intf_ref_value'); @endphp
                            @php $incubator_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'incubator', 'id', $i); @endphp       
                            <td>{!! Form::text('incubator['.$incubator_code.']',$incubator,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Incubator Temperature - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @else
                            <td>{!! Form::text('incubator['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Incubator Temperature - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>Baby's Measured Temperature</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $core_temp = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'core_temp', 'intf_ref_value'); @endphp
                            @php $core_temp_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'core_temp', 'id', $i); @endphp
                            <td>{!! Form::text('core_temp['.$core_temp_code.']',$core_temp,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Core Temperature - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @else
                            <td>{!! Form::text('core_temp['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Core Temperature - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>Monitor - Temperature</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $peripheral_temp = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'peripheral_temp', 'intf_ref_value'); @endphp
                            @php $peripheral_temp_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'peripheral_temp', 'id', $i); @endphp                            
                            @php $peripheral_temp = ($peripheral_temp != '' && is_numeric($peripheral_temp)) ? number_format($peripheral_temp, 1):$peripheral_temp @endphp 
                            <td>{!! Form::text('peripheral_temp['.$peripheral_temp_code.']',$peripheral_temp,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Peripheral Temperature - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @else
                            <td>{!! Form::text('peripheral_temp['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Peripheral Temperature - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @endif
                            @endfor
                        </tr>
                        <!-- <tr>
                            <td>T1 - T2</td>
                             <?php 
                                // $t1_t2 = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 't1_t2', 'intf_ref_value');
                                // $t1_t2_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 't1_t2', 'id', $i);  
                                ?>
                            @for($i = 0; $i < count($time_slots); $i++)
                             @if (isset($result[$time_slots[$i]]))
                             
                            
                             @php $t1 = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'core_temp', 'intf_ref_value'); @endphp
                             @php $t2 = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'peripheral_temp', 'intf_ref_value'); @endphp
                             @php $t1_t2 = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 't1_t2', 'intf_ref_value'); @endphp
                             @php $t1_t2_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 't1_t2', 'id', $i); @endphp 
                             @if ($t1 == "" || !is_numeric($t1))
                             @php $t1 = 0; @endphp
                             @endif
                             @if ($t2 == "" || !is_numeric($t2))
                             @php $t2 = 0; @endphp                          
                             @endif
                             @if($t1 != 0 && $t2 != 0)
                                 @php $t1_t2 = $t1 - $t2; @endphp
                             @else
                                 @php $t1_t2 = ''; @endphp
                             @endif
                                 <td>{!! Form::text('t1_t2['.$t1_t2_code.']',$t1_t2,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'T1 - T2 - '.substr(@$time_slots[$i],3)]) !!}</td>
                             @else
                               <td>{!! Form::text('t1_t2['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'T1 - T2 - '.substr(@$time_slots[$i],3)]) !!}</td>
                             @endif
                            @endfor
                        </tr> -->
                        <tr>
                            <td>Therapeutic Hypothermia</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $therapeutic_hypothermia = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'therapeutic_hypothermia', 'intf_ref_value'); @endphp
                            @php $therapeutic_hypothermia_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'therapeutic_hypothermia', 'id',$i); @endphp
                            <td>
                                <input id="therapeutic_hypothermia{{$i}}" name="therapeutic_hypothermia[{{$therapeutic_hypothermia_code}}]" data-on="Yes" data-off="No" @if(!is_null($therapeutic_hypothermia) && $therapeutic_hypothermia =='on') checked="true" @endif data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                            </td>
                            @else
                            <td><input id="therapeutic_hypothermia{{$i}}" name="therapeutic_hypothermia[{{$time_slots[$i]}}]" data-on="Yes" data-off="No" data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox"></td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>Rectal Temperature</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $rectal_temp = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'rectal_temp', 'intf_ref_value'); @endphp
                            @php $rectal_temp_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'rectal_temp', 'id',$i); @endphp                      
                            <td>{!! Form::text('rectal_temp['.$rectal_temp_code.']',$rectal_temp,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Rectal Temperature - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @else
                            <td>{!! Form::text('rectal_temp['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Rectal Temperature - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>Heart Rate</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $hr_rate = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'hr_rate', 'intf_ref_value'); @endphp
                            @php $hr_rate_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'hr_rate', 'id',$i); @endphp
                            <td>{!! Form::text('hr_rate['.$hr_rate_code.']',$hr_rate,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Heart Rate - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @else
                            <td>{!! Form::text('hr_rate['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Heart Rate - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>Respiratory Rate (Measured)</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $respiratory_rate = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'respiratory_rate_measured', 'intf_ref_value'); @endphp
                            @php $respiratory_rate_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'respiratory_rate_measured', 'id',$i); @endphp
                            <td>{!! Form::text('respiratory_rate_measured['.$respiratory_rate_code.']',$respiratory_rate,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Respiratory Rate - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @else
                            <td>{!! Form::text('respiratory_rate_measured['.$time_slots[$i].']', null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Respiratory Rate - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>Respiratory Rate (Monitor)</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $respiratory_rate = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'respiratory_rate', 'intf_ref_value'); @endphp
                            @php $respiratory_rate_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'respiratory_rate', 'id',$i); @endphp
                            <td>{!! Form::text('respiratory_rate['.$respiratory_rate_code.']',$respiratory_rate,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Respiratory Rate - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @else
                            <td>{!! Form::text('respiratory_rate['.$time_slots[$i].']', null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Respiratory Rate - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>BP Method</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $bp_method = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'bp_method', 'intf_ref_value'); @endphp
                            @php $bp_method_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'bp_method', 'id',$i); @endphp
                            <td>{!! Form::select('bp_method['.$bp_method_code.']',[''=>'N/A']+ValuelistHelpers::bpmethod(),$bp_method,['class'=>'form-control']) !!} </td>
                            @else
                            <td>{!! Form::select('bp_method['.$time_slots[$i].']',[''=>'N/A']+ValuelistHelpers::bpmethod(),null,['class'=>'form-control']) !!} </td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>Cuff Systolic BP</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $cuff_systalic_bp = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'cuff_systalic_bp', 'intf_ref_value'); @endphp
                            @php $cuff_systalic_bp_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'cuff_systalic_bp', 'id',$i); @endphp
                            <td>{!! Form::text('cuff_systalic_bp['.$cuff_systalic_bp_code.']',$cuff_systalic_bp,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Cuff Systalic BP - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @else
                            <td>{!! Form::text('cuff_systalic_bp['.$time_slots[$i].']', null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Cuff Systlic BP - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>Cuff Diastolic BP</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $cuff_diastolic_bp = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'cuff_diastolic_bp', 'intf_ref_value'); @endphp
                            @php $cuff_diastolic_bp_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'cuff_diastolic_bp', 'id',$i); @endphp
                            <td>{!! Form::text('cuff_diastolic_bp['.$cuff_diastolic_bp_code.']',$cuff_diastolic_bp,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Cuff Diastolic BP - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @else
                            <td>{!! Form::text('cuff_diastolic_bp['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Cuff Diastolic BP - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>Cuff Mean BP</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $cuff_mean_bp = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'cuff_mean_bp', 'intf_ref_value'); @endphp
                            @php $cuff_mean_bp_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'cuff_mean_bp', 'id',$i); @endphp
                            <td>{!! Form::text('cuff_mean_bp['.$cuff_mean_bp_code.']',$cuff_mean_bp,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Cuff Mean BP - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @else
                            <td>{!! Form::text('cuff_mean_bp['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Cuff Mean BP - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>Arterial Systolic BP</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $arterial_systalic_bp = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'arterial_systalic_bp', 'intf_ref_value'); @endphp
                            @php $arterial_systalic_bp_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'arterial_systalic_bp', 'id',$i); @endphp
                            <td>{!! Form::text('arterial_systalic_bp['.$arterial_systalic_bp_code.']',$arterial_systalic_bp,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Arterial Systolic BP - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @else
                            <td>{!! Form::text('arterial_systalic_bp['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Arterial Systolic BP - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>Arterial Diastolic BP</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $arterial_diastolic_bp = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'arterial_diastolic_bp', 'intf_ref_value'); @endphp
                            @php $arterial_diastolic_bp_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'arterial_diastolic_bp', 'id',$i); @endphp
                            <td>{!! Form::text('arterial_diastolic_bp['.$arterial_diastolic_bp_code.']',$arterial_diastolic_bp,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Arterial Diastolic BP - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @else
                            <td>{!! Form::text('arterial_diastolic_bp['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Arterial Diastolic BP - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>Arterial Mean BP</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $arterial_mean_bp = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'arterial_mean_bp', 'intf_ref_value'); @endphp
                            @php $arterial_mean_bp_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'arterial_mean_bp', 'id',$i); @endphp
                            <td>{!! Form::text('arterial_mean_bp['.$arterial_mean_bp_code.']',$arterial_mean_bp,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Arterial Mean BP - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @else
                            <td>{!! Form::text('arterial_mean_bp['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Arterial Mean BP - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>Sao2 (Preductal)</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $preductal_sao2 = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'preductal_sao2', 'intf_ref_value'); @endphp
                            @php $preductal_sao2_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'preductal_sao2', 'id',$i); @endphp
                            <td>{!! Form::text('preductal_sao2['.$preductal_sao2_code.']',$preductal_sao2,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Sao2 (Preductal) - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @else
                            <td>{!! Form::text('preductal_sao2['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Sao2 (Preductal) - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>Sao2 (Postductal)</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $postductal_sao2 = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'postductal_sao2', 'intf_ref_value'); @endphp
                            @php $postductal_sao2_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'postductal_sao2', 'id',$i); @endphp
                            <td>{!! Form::text('postductal_sao2['.$postductal_sao2_code.']',$postductal_sao2,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Sao2 (Postductal) - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @else
                            <td>{!! Form::text('postductal_sao2['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Sao2 (Postductal) - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>Colour</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $color = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'color', 'intf_ref_value'); @endphp
                            @php $color_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'color', 'id',$i); @endphp
                            <td> {!! Form::select('color['.$color_code.']',[''=>'N/A','Yellow'=>'Yellow','Pale'=>'Pale','Pink'=>'Pink','Acral Cyanosis'=>'Acral Cyanosis','Central Cyanosis'=>'Central Cyanosis'],$color,['class'=>'form-control']) !!} </td>
                            @else
                            <td>{!! Form::select('color['.$time_slots[$i].']',[''=>'N/A','Yellow'=>'Yellow','Pale'=>'Pale','Pink'=>'Pink','Acral Cyanosis'=>'Acral Cyanosis','Central Cyanosis'=>'Central Cyanosis'],null,['class'=>'form-control']) !!} </td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>Phototherapy</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($phototherapy[$time_slots[$i]]))
                            @php $photokeys =  (isset($phototherapy[$time_slots[$i]]) && count($phototherapy[$time_slots[$i]]) > 0) ? array_keys($phototherapy[$time_slots[$i]])[0] : null @endphp
                            @php $photovalue = isset($phototherapy[$time_slots[$i]][$photokeys]) ? $phototherapy[$time_slots[$i]][$photokeys] : null @endphp
                            <td><input id="phototherapy{{ $i }}" name="phototherapy[{{$photokeys}}]" data-on="Yes" data-off="No" @if(!is_null($photovalue) && $photovalue == 'on') checked @endif data-toggle="toggle" data-width="100" data-size="small" class="form-control phototherapy_toggle" type="checkbox"></td>
                            @else
                            <td><input id="phototherapy{{$i}}" name="phototherapy[{{$time_slots[$i]}}]" data-on="Yes" data-off="No" data-toggle="toggle" data-width="100" data-size="small" class="form-control phototherapy_toggle" type="checkbox"></td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>Eyes Coverd</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($phototherapy_eyes[$time_slots[$i]]))
                            @php $photoeyekeys =  (isset($phototherapy_eyes[$time_slots[$i]]) && count($phototherapy_eyes[$time_slots[$i]]) > 0) ? array_keys($phototherapy_eyes[$time_slots[$i]])[0] : null @endphp
                            @php $photoeyevalue = isset($phototherapy_eyes[$time_slots[$i]][$photoeyekeys]) ? $phototherapy_eyes[$time_slots[$i]][$photoeyekeys] : null @endphp
                            <td>
                                <!-- <input id="phototherapy_eyes{{ $i }}" name="phototherapy_eyes[{{$photoeyekeys}}]" data-on="Yes" data-off="No" @if(!is_null($photoeyevalue) && $photoeyevalue == 'on') checked @endif data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox"> -->
                                @if($photoeyevalue == 'on' || $photoeyevalue == 'Yes')
                                @php $photoeyevalue = 'Yes'; @endphp
                                @elseif($photoeyevalue == 'off' || $photoeyevalue == 'No')
                                @php $photoeyevalue = 'No'; @endphp
                                @endif
                                {!! Form::select('phototherapy_eyes['.$photoeyekeys.']',[''=>'N/A']+ValuelistHelpers::commonValues(),$photoeyevalue,['class'=>'form-control eyes_covered_toggle', 'id' => 'phototherapy_eyes'.$i]) !!}
                            </td>
                            @else
                            <td>
                                <!-- <input id="phototherapy_eyes{{$i}}" name="phototherapy_eyes[{{$time_slots[$i]}}]" data-on="Yes" data-off="No"  data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox"> -->
                                {!! Form::select('phototherapy_eyes['.$time_slots[$i].']',[''=>'N/A']+ValuelistHelpers::commonValues(),null,['class'=>'form-control eyes_covered_toggle', 'id' => 'phototherapy_eyes'.$i]) !!}
                            </td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>Activity</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $activity = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'activity', 'intf_ref_value'); @endphp
                            @php $activity_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'activity', 'id',$i); @endphp
                            <td>{!! Form::select('activity['.$activity_code.']', ValuelistHelpers::activityoption(),$activity,['class'=>'form-control']) !!}</td>
                            @else
                            <td>{!! Form::select('activity['.$time_slots[$i].']', ValuelistHelpers::activityoption(),null,['class'=>'form-control']) !!}</td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>Position</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $position = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'position', 'intf_ref_value'); @endphp
                            @php $position_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'position', 'id',$i); @endphp
                            <td>{!! Form::select('position['.$position_code.']',ValuelistHelpers::positionoptions(),$position,['class'=>'form-control']) !!}</td>
                            @else
                            <td>{!! Form::select('position['.$time_slots[$i].']',ValuelistHelpers::positionoptions(),null,['class'=>'form-control']) !!}</td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>Added Nurse</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($added_nurse[$time_slots[$i]]))
                            <td>{!! Form::select('added_nurse['.$added_nurse[$time_slots[$i]]['header_id'].']', [''=>'N/A']+$nurse_master,$added_nurse[$time_slots[$i]]['time_sheet'],['class'=>'form-control']) !!}</td>
                            @else
                            <td>{!! Form::select('added_nurse['.$time_slots[$i].']', [''=>'N/A']+$nurse_master,null,['class'=>'form-control']) !!}</td>
                            @endif
                            @endfor
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="respiratory_support">
            <div class="col-md-12 plr-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th></th>
                            @foreach($time_slots as $time_key => $timevalue)
                            @php $slot = explode(":", $timevalue)[1]; @endphp
                            @php $slot1 = explode(":", $timevalue)[2]; @endphp
                            <th class="text-center">{{ $slot }}:{{ $slot1 }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Work Of Breathing</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $work_breathing = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'work_of_breathing', 'intf_ref_value'); @endphp
                            @php $work_breathing_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'work_of_breathing', 'id',$i); @endphp
                            <td>{!! Form::select('work_of_breathing['.$work_breathing_code.']', ValuelistHelpers::workofbreathing(),$work_breathing,['class'=>'form-control']) !!}</td>
                            @else
                            <td>{!! Form::select('work_of_breathing['.$time_slots[$i].']', ValuelistHelpers::workofbreathing(),null,['class'=>'form-control']) !!}</td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>Mode Of Ventilation</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $mode_of_ventilation = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'mode_of_ventilation', 'intf_ref_value'); @endphp
                            @php $mode_of_ventilation_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'mode_of_ventilation', 'id',$i); @endphp
                            <td>{!! Form::select('mode_of_ventilation['.$mode_of_ventilation_code.']', ValuelistHelpers::modeofventilation(),$mode_of_ventilation,['class'=>'form-control']) !!}</td>
                            @else
                            <td>{!! Form::select('mode_of_ventilation['.$time_slots[$i].']', ValuelistHelpers::modeofventilation(),null,['class'=>'form-control']) !!}</td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>Mode Of Ventilation</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $mode_of_ventilation = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'mode_of_ventilation', 'intf_ref_value'); @endphp
                            @if (!in_array($mode_of_ventilation, ValuelistHelpers::modeofinvasiveventilation()))
                            @if($mode_of_ventilation == '' || $mode_of_ventilation == 'N/A')
                            @php $mode_of_ventilation_invasive = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'mode_of_ventilation_invasive', 'intf_ref_value'); @endphp
                            @else
                            @php $mode_of_ventilation_invasive = ''; @endphp
                            @endif
                            @php $mode_of_ventilation_invasive_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'mode_of_ventilation_invasive', 'id',$i); @endphp
                            @else
                            @php $mode_of_ventilation_invasive = $mode_of_ventilation; @endphp
                            @php $mode_of_ventilation_invasive_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'mode_of_ventilation', 'id',$i); @endphp
                            @endif
                            <td>
                                {!! Form::select('mode_of_ventilation_invasive['.$mode_of_ventilation_invasive_code.']', ValuelistHelpers::modeofinvasiveventilation(),$mode_of_ventilation_invasive,['class'=>'form-control']) !!}
                            </td>
                            @else
                            <td>{!! Form::select('mode_of_ventilation_invasive['.$time_slots[$i].']', ValuelistHelpers::modeofinvasiveventilation(),null,['class'=>'form-control']) !!}</td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>Volume Targeting</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $volume_targeting = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'volume_targeting', 'intf_ref_value'); @endphp
                            @php $volume_targeting_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'volume_targeting', 'id',$i); @endphp
                            <td><input id="volume_targeting{{$i}}" name="volume_targeting[{{$volume_targeting_code}}]" data-on="Yes" data-off="No" @if(!is_null($volume_targeting) && $volume_targeting =='on') checked="true" @endif data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox"></td>
                            @else
                            <td><input id="volume_targeting{{$i}}" name="volume_targeting[{{$time_slots[$i]}}]" data-on="Yes" data-off="No" data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox"></td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>Targeted Tidal Volume</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $targeted_tidal_volume = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'targeted_tidal_volume', 'intf_ref_value'); @endphp
                            @php $targeted_tidal_volume_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'targeted_tidal_volume', 'id',$i); @endphp
                            <td>{!! Form::text('targeted_tidal_volume['.$targeted_tidal_volume_code.']', $targeted_tidal_volume,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Targeted Tidal Volume - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @else
                            <td>{!! Form::text('targeted_tidal_volume['.$time_slots[$i].']', null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Targeted Tidal Volume - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>ΔP/Amplitude</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $p_amplitude = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'p_amplitude', 'intf_ref_value'); @endphp
                            @php $p_amplitude_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'p_amplitude', 'id',$i); @endphp
                            <td>{!! Form::text('p_amplitude['.$p_amplitude_code.']',$p_amplitude,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'ΔP/Amplitude - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @else
                            <td>{!! Form::text('p_amplitude['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'ΔP/Amplitude - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>PIP(set)</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $pip_set = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'pip_set', 'intf_ref_value'); @endphp
                            @php $pip_set_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'pip_set', 'id',$i); @endphp
                            <td>{!! Form::text('pip_set['.$pip_set_code.']',$pip_set,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'PIP(set) - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @else
                            <td>{!! Form::text('pip_set['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'PIP(set) - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>PIP(delivered)</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $pip_delivered = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'pip_delivered', 'intf_ref_value'); @endphp
                            @php $pip_delivered_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'pip_delivered', 'id',$i); @endphp
                            <td>{!! Form::text('pip_delivered['.$pip_delivered_code.']',$pip_delivered,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'PIP(measured) - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @else
                            <td>{!! Form::text('pip_delivered['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'PIP(measured) - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>PEEP</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $peep = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'peep', 'intf_ref_value'); @endphp
                            @php $peep_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'peep', 'id',$i); @endphp
                            <td>{!! Form::text('peep['.$peep_code.']',$peep,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'PEEP - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @else
                            <td>{!! Form::text('peep['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'PEEP - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>MAP</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $map = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'map', 'intf_ref_value'); @endphp
                            @php $map_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'map', 'id',$i); @endphp
                            <td>{!! Form::text('map['.$map_code.']',$map,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'MAP - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @else
                            <td>{!! Form::text('map['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'MAP - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>FiO2% (set)</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $fio2 = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'fio2', 'intf_ref_value'); @endphp
                            @php $fio2_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'fio2', 'id',$i); @endphp
                            <td>{!! Form::text('fio2['.$fio2_code.']',$fio2,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'FiO2 % - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @else
                            <td>{!! Form::text('fio2['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'FiO2 % - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>FiO2% (delivered) </td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $fio2_measured = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'delivered_fio2', 'intf_ref_value'); @endphp
                            @php $fio2_measured_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'delivered_fio2', 'id',$i); @endphp
                            <td>{!! Form::text('delivered_fio2['.$fio2_measured_code.']',$fio2_measured,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'FiO2% (measured) - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @else
                            <td>{!! Form::text('delivered_fio2['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'FiO2% (measured) - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>Ventilator SpO<sub>2</sub></td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $spo2_measured = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'ventilator_saturation', 'intf_ref_value'); @endphp
                            @php $spo2_measured_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'ventilator_saturation', 'id',$i); @endphp
                            <td>{!! Form::text('ventilator_saturation['.$spo2_measured_code.']',$spo2_measured,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'SpO2 - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @else
                            <td>{!! Form::text('ventilator_saturation['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'SpO2 - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>FLOW </td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $flow = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'flow', 'intf_ref_value'); @endphp
                            @php $flow_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'flow', 'id',$i); @endphp
                            <td>{!! Form::text('flow['.$flow_code.']',$flow,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'FLOW - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @else
                            <td>{!! Form::text('flow['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'FLOW - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>Delivered Tidal Volume</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $delivered_tidal_volume = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'delivered_tidal_volume', 'intf_ref_value'); @endphp
                            @php $delivered_tidal_volume_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'delivered_tidal_volume', 'id',$i); @endphp
                            <td>{!! Form::text('delivered_tidal_volume['.$delivered_tidal_volume_code.']',$delivered_tidal_volume,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Delivered Tidal Volume - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @else
                            <td>{!! Form::text('delivered_tidal_volume['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Delivered Tidal Volume - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>RATE/V</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $rate = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'rate', 'intf_ref_value'); @endphp
                            @php $rate_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'rate', 'id',$i); @endphp
                            <td>{!! Form::text('rate['.$rate_code.']',$rate,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'RATE/V - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @else
                            <td>{!! Form::text('rate['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'RATE/V - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>Frequency(H2)</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $frequency = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'frequency', 'intf_ref_value'); @endphp
                            @php $frequency_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'frequency', 'id',$i); @endphp
                            <td>{!! Form::text('frequency['.$frequency_code.']',$frequency,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Frequency(H2) - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @else
                            <td>{!! Form::text('frequency['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Frequency(H2) - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>IT(%)</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $it_rate = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'it_rate', 'intf_ref_value'); @endphp
                            @php $it_rate_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'it_rate', 'id',$i); @endphp
                            <td>{!! Form::text('it_rate['.$it_rate_code.']',$it_rate,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'IT(%) - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @else
                            <td>{!! Form::text('it_rate['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'IT(%) - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>IT(S)</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $it_rate_secound = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'it_rate_secound', 'intf_ref_value'); @endphp
                            @php $it_rate_secound_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'it_rate_secound', 'id',$i); @endphp
                            <td>{!! Form::text('it_rate_secound['.$it_rate_secound_code.']',$it_rate_secound,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'IT(S) - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @else
                            <td>{!! Form::text('it_rate_secound['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'IT(S) - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>IE RATIO</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $ie_r = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'ie_r', 'intf_ref_value'); @endphp
                            @php $ie_r_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'ie_r', 'id',$i); @endphp
                            <td>{!! Form::text('ie_r['.$ie_r_code.']',$ie_r,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'IE RATIO - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @else
                            <td>{!! Form::text('ie_r['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'IE RATIO - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>CPAP Interface Change</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $cpap_interface_change = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'cpap_interface_change', 'intf_ref_value'); @endphp
                            @php $cpap_interface_changecode = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'cpap_interface_change', 'id',$i); @endphp
                            <td>{!! Form::select('cpap_interface_change['.$cpap_interface_changecode.']',ValuelistHelpers::cpapinterface(),$cpap_interface_change,['class'=>'form-control']) !!}</td>
                            @else
                            <td>{!! Form::select('cpap_interface_change['.$time_slots[$i].']',ValuelistHelpers::cpapinterface(),null,['class'=>'form-control']) !!}</td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>Humidifier/Temp</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $humidifier_temp = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'humidifier_temp', 'intf_ref_value'); @endphp
                            @php $humidifier_temp_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'humidifier_temp', 'id',$i); @endphp
                            <td>{!! Form::text('humidifier_temp['.$humidifier_temp_code.']',$humidifier_temp,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Humidifier/Temp - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @else
                            <td>{!! Form::text('humidifier_temp['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Humidifier/Temp - '.substr(@$time_slots[$i],3)]) !!}</td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>Air Entry (R)</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $air_entry_right = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'air_entry_right', 'intf_ref_value'); @endphp
                            @php $air_entry_right_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'air_entry_right', 'id',$i); @endphp
                            <td>{!! Form::select('air_entry_right['.$air_entry_right_code.']',ValuelistHelpers::nurssheeteairentry(),$air_entry_right,['class'=>'form-control']) !!}</td>
                            @else
                            <td>{!! Form::select('air_entry_right['.$time_slots[$i].']',ValuelistHelpers::nurssheeteairentry(),null,['class'=>'form-control']) !!}</td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>Air Entry (L):</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $air_entry_left = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'air_entry_left', 'intf_ref_value'); @endphp
                            @php $air_entry_left_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'air_entry_left', 'id',$i); @endphp
                            <td>{!! Form::select('air_entry_left['.$air_entry_left_code.']',ValuelistHelpers::nurssheeteairentry(),$air_entry_left,['class'=>'form-control']) !!}</td>
                            @else
                            <td>{!! Form::select('air_entry_left['.$time_slots[$i].']',ValuelistHelpers::nurssheeteairentry(),null,['class'=>'form-control']) !!}</td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>Chest Physiotherapy</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $physiotherapy = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'physiotherapy', 'intf_ref_value'); @endphp
                            @php $physiotherapy_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'physiotherapy', 'id',$i); @endphp
                            <td><input id="physiotherapy{{$i}}" name="physiotherapy[{{$physiotherapy_code}}]" data-on="Yes" data-off="No" @if(!is_null($physiotherapy) && $physiotherapy=='on')checked @endif data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox"></td>
                            @else
                            <td><input id="physiotherapy{{$i}}" name="physiotherapy[{{$time_slots[$i]}}]" data-on="Yes" data-off="No" data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox"></td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>Suction</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $suction = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'suction', 'intf_ref_value'); @endphp
                            @php $suction_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'suction', 'id',$i); @endphp
                            <td> <input id="suction{{$i}}" name="suction[{{$suction_code}}]" data-on="Yes" data-off="No" @if(!is_null($suction) && $suction =='on')checked @endif data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox"></td>
                            @else
                            <td> <input id="suction{{$i}}" name="suction[{{$time_slots[$i]}}]" data-on="Yes" data-off="No" data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox"></td>
                            @endif
                            @endfor
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="milk_feeds_output">
            <div class="col-md-12 plr-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th></th>
                            @foreach($time_slots as $time_key => $timevalue)
                            @php $slot = explode(":", $timevalue)[1]; @endphp
                            @php $slot1 = explode(":", $timevalue)[2]; @endphp
                            <th class="text-center">{{ $slot }}:{{ $slot1 }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="hide">
                            <td></td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $milk_feeds = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'milk_feeds', 'intf_ref_value'); @endphp
                            @php $milk_feeds_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'milk_feeds', 'id',$i); @endphp
                            <td class="milkfeeds-{{$i}}">{!! Form::hidden('milk_feeds['.$milk_feeds_code.']',$milk_feeds,['class'=>'form-control']) !!}</td>
                            @else
                            <td class="milkfeeds-{{$i}}">{!! Form::hidden('milk_feeds['.$time_slots[$i].']',null,['class'=>'form-control']) !!}</td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <td>Type Of Feeds</td>
                            @for($i = 0; $i < count($time_slots); $i++)
                            @if (isset($result[$time_slots[$i]]))
                            @php $type_of_feeds = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'type_of_feeds', 'intf_ref_value'); @endphp
                            @php $type_of_feeds_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'type_of_feeds', 'id',$i); @endphp
                            <td class="typeoffeeds-{{$i}}">{!! Form::select('type_of_feeds['.$type_of_feeds_code.']',[''=>'N/A']+ValuelistHelpers::typeoffeeds(),$type_of_feeds,['class'=>'form-control']) !!}</td>
                            @else
                            <td class="typeoffeeds-{{$i}}">{!! Form::select('type_of_feeds['.$time_slots[$i].']',[''=>'N/A']+ValuelistHelpers::typeoffeeds(),null,['class'=>'form-control']) !!}</td>
                            @endif
                            @endfor
                        </tr>
                        <tr>
                            <tr>
                                <td>Route of Feeds</td>
                                @for($i = 0; $i < count($time_slots); $i++)
                                @if (isset($result[$time_slots[$i]]))
                                @php $route_of_feeds = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'route_of_feeds', 'intf_ref_value'); @endphp
                                @php $route_of_feeds_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'route_of_feeds', 'id',$i); @endphp
                                <td>{!! Form::select('route_of_feeds['.$route_of_feeds_code.']',ValuelistHelpers::routeoffeed(),$route_of_feeds,['class'=>'form-control']) !!}</td>
                                @else
                                <td>{!! Form::select('route_of_feeds['.$time_slots[$i].']',ValuelistHelpers::routeoffeed(),null,['class'=>'form-control']) !!}</td>
                                @endif
                                @endfor
                            </tr>
                            <tr>
                                <td>Human Milk Fortification</td>
                                @for($i = 0; $i < count($time_slots); $i++)
                                @if (isset($result[$time_slots[$i]]))
                                @php $human_milk_fortification = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'human_milk_fortification', 'intf_ref_value'); @endphp
                                @php $human_milk_fortification_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'human_milk_fortification', 'id',$i); @endphp
                                <td><input id="human_milk_fortification" name="human_milk_fortification[{{ $human_milk_fortification_code }}]" data-on="Yes" data-off="No" @if(!is_null($human_milk_fortification) && $human_milk_fortification == 'on') checked @endif data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox"></td>
                                @else
                                <td><input id="human_milk_fortification" name="human_milk_fortification[{{$time_slots[$i]}}]" data-on="Yes" data-off="No" data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox"></td>
                                @endif
                                @endfor
                            </tr>
                            <tr>
                                <td>Milk Volume</td>
                                @for($i = 0; $i < count($time_slots); $i++)
                                @if (isset($result[$time_slots[$i]]))
                                @php $milk_volume = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'milk_volume', 'intf_ref_value'); @endphp
                                @php $milk_volume_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'milk_volume', 'id',$i); @endphp
                                <td>{!! Form::text('milk_volume['.$milk_volume_code.']',$milk_volume,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Milk Volume - '.substr(@$time_slots[$i],3)]) !!}</td>
                                @else
                                <td>{!! Form::text('milk_volume['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Milk Volume - '.substr(@$time_slots[$i],3)]) !!}</td>
                                @endif
                                @endfor
                            </tr>
                            <tr>
                                <td>KMC</td>
                                @for($i = 0; $i < count($time_slots); $i++)
                                @if (isset($result[$time_slots[$i]]))
                                @php $kmc = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'kmc', 'intf_ref_value'); @endphp
                                @php $kmc_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'kmc', 'id',$i); @endphp
                                <td><input id="kmc" name="kmc[{{$kmc_code}}]" data-on="Yes" data-off="No" @if(!is_null($kmc) && $kmc =='on') checked @endif data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox"></td>
                                @else
                                <td><input id="kmc" name="kmc[{{$time_slots[$i]}}]" data-on="Yes" data-off="No" data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox"></td>
                                @endif
                                @endfor
                            </tr>
                            <tr>
                                <td>NNS</td>
                                @for($i = 0; $i < count($time_slots); $i++)
                                @if (isset($result[$time_slots[$i]]))
                                @php $nns = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'nns', 'intf_ref_value'); @endphp
                                @php $nns_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'nns', 'id',$i); @endphp
                                <td> <input id="nns" name="nns[{{$nns_code}}]" data-on="Yes" data-off="No" @if(!is_null($nns) && $nns == 'on') checked @endif data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox"></td>
                                @else
                                <td> <input id="nns" name="nns[{{$time_slots[$i]}}]" data-on="Yes" data-off="No" data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox"></td>
                                @endif
                                @endfor
                            </tr>
                            <tr>
                                <td>Gastric Aspirate Volume (ml)</td>
                                @for($i = 0; $i < count($time_slots); $i++)
                                @if (isset($result[$time_slots[$i]]))
                                @php $gastric_aspirate_volume = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gastric_aspirate_volume', 'intf_ref_value'); @endphp
                                @php $gastric_aspirate_volume_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gastric_aspirate_volume', 'id',$i); @endphp
                                <td>{!! Form::text('gastric_aspirate_volume['.$gastric_aspirate_volume_code.']', $gastric_aspirate_volume,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Gastric Aspirate Volume (ml) - '.substr(@$time_slots[$i],3)]) !!}</td>
                                @else
                                <td>{!! Form::text('gastric_aspirate_volume['.$time_slots[$i].']', null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Gastric Aspirate Volume (ml) - '.substr(@$time_slots[$i],3)]) !!}</td>
                                @endif
                                @endfor
                            </tr>
                            <tr>
                                <td>Gastric Aspirate (nature)</td>
                                @for($i = 0; $i < count($time_slots); $i++)
                                @if (isset($result[$time_slots[$i]]))
                                @php $gastric_aspirate = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gastric_aspirate', 'intf_ref_value'); @endphp
                                @php $gastric_aspirate_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gastric_aspirate', 'id',$i); @endphp
                                <td> {!! Form::select('gastric_aspirate['.$gastric_aspirate_code.']', ValuelistHelpers::babygastricaspirate(),$gastric_aspirate,['class'=>'form-control']) !!} </td>
                                @else
                                <td> {!! Form::select('gastric_aspirate['.$time_slots[$i].']', ValuelistHelpers::babygastricaspirate(),null,['class'=>'form-control']) !!} </td>
                                @endif
                                @endfor
                            </tr>
                            <tr>
                                <td>Urine Output (ml)</td>
                                @for($i = 0; $i < count($time_slots); $i++)
                                @if (isset($result[$time_slots[$i]]))
                                @php $urine_output = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'urine_output', 'intf_ref_value'); @endphp
                                @php $urine_output_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'urine_output', 'id',$i); @endphp
                                <td> {!! Form::text('urine_output['.$urine_output_code.']',$urine_output,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Urine Output (ml) - '.substr(@$time_slots[$i],3)]) !!} </td>
                                @else
                                <td> {!! Form::text('urine_output['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Urine Output (ml) - '.substr(@$time_slots[$i],3)]) !!} </td>
                                @endif
                                @endfor
                            </tr>
                            <tr>
                                <td>Blood Volume Out (ml)</td>
                                @for($i = 0; $i < count($time_slots); $i++)
                                @if (isset($result[$time_slots[$i]]))
                                @php $blood_volume_out = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'blood_volume_out', 'intf_ref_value'); @endphp
                                @php $blood_volume_out_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'blood_volume_out', 'id',$i); @endphp
                                <td> {!! Form::text('blood_volume_out['.$blood_volume_out_code.']',$blood_volume_out,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Blood Volume Out (ml) - '.substr(@$time_slots[$i],3)]) !!} </td>
                                @else
                                <td> {!! Form::text('blood_volume_out['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Blood Volume Out (ml) - '.substr(@$time_slots[$i],3)]) !!} </td>
                                @endif
                                @endfor
                            </tr>
                            <tr>
                                <td>Drain Output (R)</td>
                                @for($i = 0; $i < count($time_slots); $i++)
                                @if (isset($result[$time_slots[$i]]))
                                @php $drain_output_r = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'drain_output_r', 'intf_ref_value'); @endphp
                                @php $drain_output_r_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'drain_output_r', 'id',$i); @endphp
                                <td> {!! Form::text('drain_output_r['.$drain_output_r_code.']',$drain_output_r,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Drain Output (R) - '.substr(@$time_slots[$i],3)]) !!} </td>
                                @else
                                <td> {!! Form::text('drain_output_r['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Drain Output (R) - '.substr(@$time_slots[$i],3)]) !!} </td>
                                @endif
                                @endfor
                            </tr>
                            <tr>
                                <td>Drain Output (L)</td>
                                @for($i = 0; $i < count($time_slots); $i++)
                                @if (isset($result[$time_slots[$i]]))
                                @php $drain_output_l = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'drain_output_l', 'intf_ref_value'); @endphp
                                @php $drain_output_l_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'drain_output_l', 'id',$i); @endphp
                                <td> {!! Form::text('drain_output_l['.$drain_output_l_code.']',$drain_output_l,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Drain Output (L) - '.substr(@$time_slots[$i],3)]) !!} </td>
                                @else
                                <td> {!! Form::text('drain_output_l['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Drain Output (L) - '.substr(@$time_slots[$i],3)]) !!} </td>
                                @endif
                                @endfor
                            </tr>
                            <tr>
                                <td>Bowels Opened</td>
                                @for($i = 0; $i < count($time_slots); $i++)
                                @if (isset($result[$time_slots[$i]]))
                                @php $bowels = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'bowels', 'intf_ref_value'); @endphp
                                @php $bowels_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'bowels', 'id',$i); @endphp
                                <td> <input id="bowels{{$i}}" name="bowels[{{$bowels_code}}]" data-on="Yes" data-off="No" @if(!is_null($bowels) && $bowels == 'on') checked @endif data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox"> </td>
                                @else
                                <td> <input id="bowels{{$i}}" name="bowels[{{$time_slots[$i]}}]" data-on="Yes" data-off="No" data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox"> </td>
                                @endif
                                @endfor
                            </tr>
                            <tr>
                                <td>Stools Nature</td>
                                @for($i = 0; $i < count($time_slots); $i++)
                                @if (isset($result[$time_slots[$i]]))
                                @php $stools_nature = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'stools_nature', 'intf_ref_value'); @endphp
                                @php $stools_nature_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'stools_nature', 'id',$i); @endphp
                                <td>{!! Form::select('stools_nature['.$stools_nature_code.']', ValuelistHelpers::nursesheetstoolsnature(),$stools_nature,['class'=>'form-control']) !!}</td>
                                @else
                                <td>{!! Form::select('stools_nature['.$time_slots[$i].']', ValuelistHelpers::nursesheetstoolsnature(),null,['class'=>'form-control']) !!}</td>
                                @endif
                                @endfor
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="hidden">
                {!! Form::select('temp_drug_solution',$ivfluids,null) !!}
            </div>
            <div role="tabpanel" class="tab-pane" id="pn_drugs">
                <div class="col-md-12 plr-0">
                    <h3><u><b>IV Fluids, Parenteral Nutrition And Drug Infusion</b></u></h3>
                    <table class="table">
                        <thead>
                            <th>Time</th>
                            <th>
                                Solution:
                                <a href="javascript:void(0)" class="add_master_data" data-modal_header="Drugs & Iv Fluids" data-destination_elements="temp_drug_solution,^drug_solution,^pump_drug_solution,^replacement_fluids_solution,infusion_temp,infusion_gen_temp" data-option_value="id" data-option_text="brand_name,generic_pharmacological_name" data-mas_table="mas_drugivfluid">
                                    <i class="fa fa-info-circle bs-tooltip" data-placement="right" data-original-title="Add Drugs & Iv Fluids"></i>
                                </a>
                            </th>
                            <th>Rate:</th>
                            <th colspan="2">Total:</th>
                        </thead>
                        <tbody>
                        @php  $i = 0; @endphp
                        @foreach($time_slots as $time_key => $timevalue)
                            @if(isset($drugs_list[$timevalue]))
                                @php  $start = 1; @endphp
                                @foreach($drugs_list[$timevalue] as $tempdrug)
                                    @php $tempdrug = collect($tempdrug)->toArray(); @endphp
                                    @if(isset($tempdrug['drug_id']) && isset($tempdrug['drug_rate_id']) && isset($tempdrug['drug_total_id']) )
                                        <tr>
                                            <td>
                                                @if($start ==1) 
                                                @php $slot = explode(":", $timevalue)[1]; @endphp
                                                @php $slot1 = explode(":", $timevalue)[2]; @endphp
                                                {{ $slot }}:{{ $slot1 }}
                                                @endif
                                            </td>
                                            <td>{!! Form::select('drug_solution['.$tempdrug['drug_id'].']',$ivfluids,$tempdrug['drug_name'],['class'=>'drug-solution input-width-xxlarge not_saved', 'id'=>'drug-solution'.$i, 'data-solution'=>$i]) !!}</td>
                                            <td>{!! Form::number('drug_rate['.$tempdrug['drug_rate_id'].']',$tempdrug['drug_rate'],['class'=>'form-control number_pad need_dialpad not_saved', 'data-info'=> 'Rate - '.$slot.':'.$slot1]) !!}</td>
                                            <td>{!! Form::number('drug_total['.$tempdrug['drug_total_id'].']',$tempdrug['drug_total'],['class'=>'form-control number_pad need_dialpad not_saved', 'data-info'=> 'Total - '.$slot.':'.$slot1]) !!}</td>
                                            <td><a href="javascript:void(0);" class="btn btn-danger danger btn-view remove"><i class="fa fa-trash"></i></a></td>
                                        </tr>
                                    @endif
                                    @if(isset($tempdrug['prescription_id']))
                                        <tr>
                                            <td>
                                                @if($start ==1) 
                                                @php $slot = explode(":", $timevalue)[1]; @endphp
                                                @php $slot1 = explode(":", $timevalue)[2]; @endphp
                                                {{ $slot }}:{{ $slot1 }}
                                                @endif
                                            </td>
                                            <td>{!! Form::select('pump_drug_solution['.$tempdrug['pres_pump_id'].']',$ivfluids,$tempdrug['drug_id'],['class'=>'drug-solution input-width-xxlarge not_saved', 'id'=>'drug-solution-'.$i, 'data-solution'=>$i]) !!}</td>
                                            <td>{!! Form::number('pump_drug_rate['.$tempdrug['pres_pump_id'].']',$tempdrug['rate'],['class'=>'form-control number_pad need_dialpad not_saved', 'data-info'=> 'Rate - '.$slot.':'.$slot1]) !!}</td>
                                            <td class="row-time" id="row-time-{{ $slot }}">{!! Form::number('pump_drug_total['.$tempdrug['pres_pump_id'].']',$tempdrug['infused'],['class'=>'form-control number_pad need_dialpad not_saved', 'data-info'=> 'Total - '.$slot.':'.$slot1]) !!}</td>
                                            <td><a href="javascript:void(0);" class="btn btn-danger danger btn-view remove"><i class="fa fa-trash"></i></a></td>
                                        </tr>
                                    @endif
                                    @if($start == count($drugs_list[$timevalue]))
                                        <tr class="add-more">
                                            <td colspan="5">
                                                <span class="pull-right">
                                                <a class="btn btn-primary add-iv-pn-fluids" data-header-id="{{ $timevalue }}" href="javascript:void(0);">
                                                <i class="fa fa-plus"></i>
                                                <span> Add More </span>
                                                </a>
                                                </span>
                                            </td>
                                        </tr>
                                    @endif
                                    @php  $i++; $start++; @endphp
                                @endforeach
                            @else
                                <tr>
                                    <!-- <td></td> -->
                                    <td>
                                        @php $slot = explode(":", $timevalue)[1]; @endphp
                                        @php $slot1 = explode(":", $timevalue)[2]; @endphp
                                        {{ $slot }}:{{ $slot1 }}
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr class="add-more">
                                    <td colspan="5">
                                        <span class="pull-right">
                                        <a class="btn btn-primary add-iv-pn-fluids" data-header-id="{{ $timevalue }}" href="javascript:void(0);">
                                        <i class="fa fa-plus"></i>
                                        <span> Add More </span>
                                        </a>
                                        </span>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
      </tbody>
  </table>
</div>
</div>
<div role="tabpanel" class="tab-pane" id="replacement_fluids">
    <div class="col-md-12">
        <h3><u><b>Replacement Fluids</b></u></h3>
        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th>
                        Solution:
                        <a href="javascript:void(0)" class="add_master_data" data-modal_header="Drugs & Iv Fluids" data-destination_elements="temp_drug_solution,^drug_solution,^pump_drug_solution,^replacement_fluids_solution,infusion_temp,infusion_gen_temp" data-option_value="id" data-option_text="brand_name,generic_pharmacological_name" data-mas_table="mas_drugivfluid">
                            <i class="fa fa-info-circle bs-tooltip" data-placement="right" data-original-title="Add Drugs & Iv Fluids"></i>
                        </a>
                    </th>
                    <th>Rate:</th>
                    <th>Total:</th>
                </tr>
            </thead>
            <tbody>
                @php  $i = 0; @endphp
                @foreach($time_slots as $time_key => $timevalue)
                @if(isset($replacement_fluids[$timevalue]))
                @php  $start = 1; @endphp
                @foreach($replacement_fluids[$timevalue] as $replacement_fluide)
                <tr>
                    <td> @if($start ==1) 
                        @php $slot = explode(":", $timevalue)[1]; @endphp
                        @php $slot1 = explode(":", $timevalue)[2]; @endphp
                        {{ $slot }}:{{ $slot1 }}
                        @endif
                    </td>
                    <td>{!! Form::select('replacement_fluids_solution['.$replacement_fluide['solution_id'].']', $ivfluids,$replacement_fluide['solution_name'],['class'=>'replacement-fluids-solution input-width-xlarge not_saved','id'=>'replacement-fluids-solution-'.$i, 'data-replacement'=>$i]) !!}</td>
                    <td>{!! Form::text('replacement_fluids_rate['.$replacement_fluide['rate_id'].']',$replacement_fluide['rate_name'],['class'=>'form-control number_pad need_dialpad not_saved', 'data-info'=> 'Rate - '.substr(@$time_slots[$i],3)]) !!}</td>
                    <td>{!! Form::text('replacement_fluids_total['.$replacement_fluide['total_id'].']',$replacement_fluide['total_name'],['class'=>'form-control number_pad need_dialpad not_saved', 'data-info'=> 'Total - '.substr(@$time_slots[$i],3)]) !!}</td>
                    <td> <span class="fa fa-remove btn btn-default remove"></span> </td>
                </tr>
                @if($start == count($replacement_fluids[$timevalue]))
                <tr class="add-more">
                    <td colspan="5" class="border-top-light-gray">
                        <span class="pull-right">
                            <a class="btn btn-primary add-replacement-list" data-replacement-header="{{ $timevalue }}" href="javascript:void(0);">
                                <i class="fa fa-plus"></i>
                                <span>
                                    Add More 
                                </span>
                            </a>
                        </span>
                    </td>
                </tr>
                @endif
                @php  $i++;$start++; @endphp
                @endforeach
                @else
                <tr>
                    <td> 
                        @php $slot = explode(":", $timevalue)[1]; @endphp
                        @php $slot1 = explode(":", $timevalue)[2]; @endphp
                        {{ $slot }}:{{ $slot1 }}
                    </td>
                    <td colspan="4"></td>
                </tr>
                <tr class="add-more">
                    <td colspan="5" class="border-top-light-gray">
                        <span class="pull-right">
                            <a class="btn btn-primary add-replacement-list" data-replacement-header="{{ $timevalue }}" href="javascript:void(0);">
                                <i class="fa fa-plus"></i>
                                <span>
                                    Add More 
                                </span>
                            </a>
                        </span>
                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div role="tabpanel" class="tab-pane" id="input-output">
    <div class="col-md-12 p-0">
        <div class="col-md-6">
            <h4><u><b>Input</b></u></h4>
            <div class="form-group">
                @php $intravenous_fluids = ValuelistHelpers::fetchloincvalue($inout_totals, 'intravenous_fluids', 'intf_ref_value'); @endphp
                @php $intravenous_fluids_code = ValuelistHelpers::fetchloincvalue($inout_totals, 'intravenous_fluids', 'id',$i); @endphp
                {!! Form::label('intravenous_fluids','Intravenous Fluids(ml) PN and Drug Infusions:') !!}
                @if ($intravenous_fluids != '')
                {!! Form::text('intravenous_fluids['.$intravenous_fluids_code.']',$intravenous_fluids,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Intravenous Fluids(ml) - '.substr(@$time_slots[$i],3)])!!}
                @else
                {!! Form::text('intravenous_fluids[]', null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Intravenous Fluids(ml) - '.substr(@$time_slots[$i],3)])!!}
                @endif
            </div>
            <div class="form-group">
                @php $oral_fluids = ValuelistHelpers::fetchloincvalue($inout_totals, 'oral_fluids', 'intf_ref_value'); @endphp
                @php $oral_fluids_code = ValuelistHelpers::fetchloincvalue($inout_totals, 'oral_fluids', 'id',$i); @endphp
                {!! Form::label('oral_fluids','Oral Fluids(ml):') !!}
                @if ($oral_fluids != '')
                {!! Form::text('oral_fluids['.$oral_fluids_code.']',$oral_fluids,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Oral Fluids(ml) - '.substr(@$time_slots[$i],3)]) !!}
                @else
                {!! Form::text('oral_fluids[]',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Oral Fluids(ml) - '.substr(@$time_slots[$i],3)]) !!}
                @endif
            </div>
            <div class="form-group">
                @php $other_drugs = ValuelistHelpers::fetchloincvalue($inout_totals, 'other_drugs', 'intf_ref_value'); @endphp
                @php $other_drugs_code = ValuelistHelpers::fetchloincvalue($inout_totals, 'other_drugs', 'id',$i); @endphp
                {!! Form::label('other_drugs','Other IV Drugs (ml):') !!}
                @if ($other_drugs != '')
                {!! Form::text('other_drugs['.$other_drugs_code.']',$other_drugs,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Other IV Drugs (ml) - '.substr(@$time_slots[$i],3)]) !!}
                @else
                {!! Form::text('other_drugs[]',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Other IV Drugs (ml) - '.substr(@$time_slots[$i],3)]) !!}
                @endif
            </div>
            <div class="form-group">
                @php $total_intake_ml = ValuelistHelpers::fetchloincvalue($inout_totals, 'total_intake_ml', 'intf_ref_value'); @endphp
                @php $total_intake_ml_code = ValuelistHelpers::fetchloincvalue($inout_totals, 'total_intake_ml', 'id',$i); @endphp
                {!! Form::label('total_intake_ml','Total Fluids (ml):') !!}
                @if ($total_intake_ml != '')
                {!! Form::text('total_intake_ml['.$total_intake_ml_code.']',$total_intake_ml,['class'=>'form-control total-intake-ml number_pad need_dialpad', 'data-info'=> 'Total Fluids (ml) - '.substr(@$time_slots[$i],3)]) !!}
                @else
                {!! Form::text('total_intake_ml[]',null,['class'=>'form-control total-intake-ml number_pad need_dialpad', 'data-info'=> 'Total Fluids (ml) - '.substr(@$time_slots[$i],3)]) !!}
                @endif
            </div>
            <div class="form-group">
                @php $total_intake_kg = ValuelistHelpers::fetchloincvalue($inout_totals, 'total_intake_kg', 'intf_ref_value'); @endphp
                @php $total_intake_kg_code = ValuelistHelpers::fetchloincvalue($inout_totals, 'total_intake_kg', 'id',$i); @endphp
                {!! Form::label('total_intake_kg','Total Fluids (ml/kg/day):') !!}
                @if ($total_intake_kg != '')
                {!! Form::text('total_intake_kg['.$total_intake_kg_code.']',$total_intake_kg,['class'=>'form-control total-intake-kg number_pad need_dialpad', 'data-info'=> 'Total Fluids (ml/kg/day) - '.substr(@$time_slots[$i],3)]) !!}
                @else
                {!! Form::text('total_intake_kg[]',null,['class'=>'form-control total-intake-kg number_pad need_dialpad', 'data-info'=> 'Total Fluids (ml/kg/day) - '.substr(@$time_slots[$i],3)]) !!}
                @endif
            </div>
            <div class="form-group">
                {!! Form::label('transfusion','Transfusion:') !!}
                {!! Form::select('Transfusion['.$transfusion['id'].']',[''=>'N/A','No' =>"No","Yes"=>"Yes"],$transfusion['intf_ref_value'],['class'=>'form-control']) !!}
            </div>
            <div class="hidden">
                {!! Form::select('f_product_temp',[''=>'N/A','Packed RBC'=>'Packed RBC','Whole Blood'=>'Whole Blood','Platelet Concentrate'=>'Platelet Concentrate','Fresh Frozen Plasma'=>'Fresh Frozen Plasma','Cryoprecipitate'=>'Cryoprecipitate','Washed maternal platelets'=>'Washed maternal platelets','NAIT - special platelets'=>'NAIT - special platelets','Immunoglobulin'=>'Immunoglobulin'],null,['class'=>'form-control']) !!} 
            </div>
            <div class="form-group">
                <table class="product table">
                    <thead>
                        <tr>
                            <th>Blood Product</th>
                            <th>Volume ml/kg</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($blood_tranfusion) && count($blood_tranfusion) > 0)
                        @foreach($blood_tranfusion as $i =>$blood_tranfusion_value )
                        <tr>
                            <td>{!! Form::select('F_Product['.$blood_tranfusion[$i]['product_id'].']',ValuelistHelpers::BloodProducts(),$blood_tranfusion[$i]['product_name'],['class'=>'form-control not_saved']) !!} </td>
                            <td> {!! Form::text('F_Volume['.$blood_tranfusion[$i]['product_volid'].']',$blood_tranfusion[$i]['product_volume'],['class'=>'input-width-mini form-control not_saved']) !!}</td>
                            <td><span class="fa fa-remove btn btn-default remove"></span></td>
                        </tr>
                        @endforeach
                        @endif
                        <tr>
                            <td colspan="3">
                                <a class="btn btn-primary pull-right add-blood-product-list btn_add" data-blood-header-id="{{ @$last_header }}" href="javascript:void(0);">
                                    <i class="fa fa-plus"></i>
                                    <span>Add More</span>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="hidden">
                {!! Form::select('a_antibiotic_temp',[''=>'--select--']+ValuelistHelpers::getAntibiotic(),'',['class'=>"input-width-medium form-control"]) !!}
            </div>
            <div class="form-group hide">
                <table class="antibiotic table">
                    <thead>
                        <tr>
                            <th>Antibiotic</th>
                            <th>Day</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($antibiotic_list) && count($antibiotic_list) > 0)
                        @foreach($antibiotic_list as $i => $antibiotic_names)
                        <tr>
                            <td>{!! Form::select('A_Antibiotic['.$antibiotic_list[$i]['antibiotic_id'].']',[''=>'N/A']+ValuelistHelpers::getAntibiotic(),$antibiotic_list[$i]['antibiotic_name'],['class'=>"sepsis-antibiotic input-width-xmediumx not_saved",'data-antibiotic'=>$i ,'id'=>'antiboitic'.$i ]) !!}</td>
                            <td><input type="text" class="input-width-mini form-control not_saved" name="A_Day[{{ $antibiotic_list[$i]['antibiotic_day_id'] }}]" value="{{ $antibiotic_list[$i]['antibiotic_day_name'] }}"/></td>
                            <td><span class="fa fa-remove btn btn-default remove"></span></td>
                        </tr>
                        @endforeach   
                        @endif                                 
                        <tr>
                            <td colspan="3">
                                <a class="btn btn-primary pull-right add-antibio-list" href="javascript:void(0);" data-antibio-header="{{ @$last_header }}"> 
                                    <i class="fa fa-plus"></i>
                                    <span> Add More </span>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="hidden">
                {{ Form::select('temp_drugs', $drugs, null,['class'=>'input-width-xlarge']) }}
            </div>
            <div class="form-group hide">
                <table class="table other-drug-table">
                    <thead>
                        <th>Other Drugs</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @php $i = 0; @endphp
                        @foreach($other_drugs_list as $drug_list)
                        <tr>
                            <td class="full-width-must">{!! Form::select('drugs['.$drug_list['drug_id'].']', $master_drugs, $drug_list['drug_name'],['class'=>'other_drugs input-width-xmedium full-width-must not_saved','id'=>'other-drugs'.$i]) !!}</td>
                            <td><span class="fa fa-remove btn btn-default remove"></span></td>
                        </tr>
                        @php $i++; @endphp
                        @endforeach  
                        <tr>
                            <td colspan="2">
                                <a class="btn btn-primary add-other-drugs-list pull-right" data-other-header-id="{{ @$last_header }}" href="javascript:void(0);">
                                    <i class="fa fa-plus"></i>
                                    <span>Add More</span>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <h4><u><b>Output</b></u></h4>
            <div class="form-group">
                @php $aspirate_ml = ValuelistHelpers::fetchloincvalue($inout_totals, 'aspirate_ml', 'intf_ref_value'); @endphp
                @php $aspirate_ml_code = ValuelistHelpers::fetchloincvalue($inout_totals, 'aspirate_ml', 'id',$i); @endphp
                {!! Form::label('aspirate_ml','Aspirate (ml):') !!}
                @if ($aspirate_ml != '')
                {!! Form::number('aspirate_ml['.$aspirate_ml_code.']',$aspirate_ml,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Aspirate (ml) - '.substr(@$time_slots[$i],3)]) !!}
                @else
                {!! Form::number('aspirate_ml[]',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Aspirate (ml) - '.substr(@$time_slots[$i],3)]) !!}
                @endif
            </div>
            <div class="form-group">
                @php $drains_ml = ValuelistHelpers::fetchloincvalue($inout_totals, 'drains_ml', 'intf_ref_value'); @endphp
                @php $drains_ml_code = ValuelistHelpers::fetchloincvalue($inout_totals, 'drains_ml', 'id',$i); @endphp
                {!! Form::label('drains_ml','Drains (ml):') !!}
                @if ($drains_ml != '')
                {!! Form::number('drains_ml['.$drains_ml_code.']',$drains_ml,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Drains (ml) - '.substr(@$time_slots[$i],3)]) !!}
                @else
                {!! Form::number('drains_ml[]',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Drains (ml) - '.substr(@$time_slots[$i],3)]) !!}
                @endif
            </div>
            <div class="form-group">
                @php $urine_total = ValuelistHelpers::fetchloincvalue($inout_totals, 'urine_total', 'intf_ref_value'); @endphp
                @php $urine_total_code = ValuelistHelpers::fetchloincvalue($inout_totals, 'urine_total', 'id',$i); @endphp
                {!! Form::label('urine_total','Urine Total (ml):') !!}
                @if ($urine_total != '')
                {!! Form::number('urine_total['.$urine_total_code.']',$urine_total,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Urine Total (ml) - '.substr(@$time_slots[$i],3)]) !!}
                @else
                {!! Form::number('urine_total[]',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Urine Total (ml) - '.substr(@$time_slots[$i],3)]) !!}
                @endif
            </div>
            <div class="form-group">
                @php $urine_total_full_day = ValuelistHelpers::fetchloincvalue($inout_totals, 'urine_total_full_day', 'intf_ref_value'); @endphp
                @php $urine_total_full_day_code = ValuelistHelpers::fetchloincvalue($inout_totals, 'urine_total_full_day', 'id',$i); @endphp
                {!! Form::label('urine_total_full_day','24 Hour Urine Output (ml/kg/day):') !!}
                @if ($total_intake_ml != '')
                {!! Form::number('urine_total_full_day['.$urine_total_full_day_code.']',$urine_total_full_day,['class'=>'form-control number_pad need_dialpad', 'data-info'=> '24 Hour Urine Output (ml/kg/day) - '.substr(@$time_slots[$i],3)]) !!}
                @else
                {!! Form::number('urine_total_full_day[]',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> '24 Hour Urine Output (ml/kg/day) - '.substr(@$time_slots[$i],3)]) !!}
                @endif
            </div>
            <div class="form-group">
                @php $urine_total_ml_kg = ValuelistHelpers::fetchloincvalue($inout_totals, 'urine_total_ml_kg', 'intf_ref_value'); @endphp
                @php $urine_total_ml_kg_code = ValuelistHelpers::fetchloincvalue($inout_totals, 'urine_total_ml_kg', 'id',$i); @endphp
                {!! Form::label('urine_total_ml_kg','Spot Urine (ml/kg/hour):') !!}
                @if ($urine_total_ml_kg != '')
                {!! Form::number('urine_total_ml_kg['.$urine_total_ml_kg_code.']',$urine_total_ml_kg,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Spot Urine (ml/kg/hour) - '.substr(@$time_slots[$i],3)]) !!}
                @else
                {!! Form::number('urine_total_ml_kg[]',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Spot Urine (ml/kg/hour) - '.substr(@$time_slots[$i],3)]) !!}
                @endif
            </div>
            <div class="form-group">
                @php $blood_out_total = ValuelistHelpers::fetchloincvalue($inout_totals, 'blood_out_total', 'intf_ref_value'); @endphp
                @php $blood_out_total_code = ValuelistHelpers::fetchloincvalue($inout_totals, 'blood_out_total', 'id',$i); @endphp
                {!! Form::label('blood_out_total','Blood Out Total (ml):') !!}
                @if ($blood_out_total != '')
                {!! Form::number('blood_out_total['.$blood_out_total_code.']',$blood_out_total,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Blood Out Total (ml) - '.substr(@$time_slots[$i],3)]) !!}
                @else
                {!! Form::number('blood_out_total[]',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Blood Out Total (ml) - '.substr(@$time_slots[$i],3)]) !!}
                @endif
            </div>
            <div class="form-group">
                @php $stools_frequency = ValuelistHelpers::fetchloincvalue($inout_totals, 'stools_frequency', 'intf_ref_value'); @endphp
                @php $stools_frequency_code = ValuelistHelpers::fetchloincvalue($inout_totals, 'stools_frequency', 'id',$i); @endphp
                {!! Form::label('stools_frequency','Stools (Frequency):') !!}
                @if ($stools_frequency != '')
                {!! Form::number('stools_frequency['.$stools_frequency_code.']',$stools_frequency,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Stools (Frequency) - '.substr(@$time_slots[$i],3)]) !!}
                @else
                {!! Form::number('stools_frequency[]',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Stools (Frequency) - '.substr(@$time_slots[$i],3)]) !!}
                @endif
            </div>
            <div class="form-group">
                @php $stoma_output = ValuelistHelpers::fetchloincvalue($inout_totals, 'stoma_output', 'intf_ref_value'); @endphp
                @php $stoma_output_code = ValuelistHelpers::fetchloincvalue($inout_totals, 'stoma_output', 'id',$i); @endphp
                {!! Form::label('stoma_output','Stoma Output (ml):') !!}
                @if ($stoma_output != '')
                {!! Form::number('stoma_output['.$stoma_output_code.']',$stoma_output,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Stoma Output (ml) - '.substr(@$time_slots[$i],3)]) !!}
                @else
                {!! Form::number('stoma_output[]',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Stoma Output (ml) - '.substr(@$time_slots[$i],3)]) !!}
                @endif
            </div>
            <div class="form-group">
                @php $total_output = ValuelistHelpers::fetchloincvalue($inout_totals, 'total_output', 'intf_ref_value'); @endphp
                @php $total_output_code = ValuelistHelpers::fetchloincvalue($inout_totals, 'total_output', 'id',$i); @endphp
                {!! Form::label('total_output','Total Output (ml):') !!}
                @if ($total_output != '')
                {!! Form::number('total_output['.$total_output_code.']',$total_output,['class'=>'form-control total-output number_pad need_dialpad', 'data-info'=> 'Total Output (ml) - '.substr(@$time_slots[$i],3)]) !!}
                @else
                {!! Form::number('total_output[]',null,['class'=>'form-control total-output number_pad need_dialpad', 'data-info'=> 'Total Output (ml) - '.substr(@$time_slots[$i],3)]) !!}
                @endif
            </div>
            <div class="form-group">
                @php $total_output_ml_day = ValuelistHelpers::fetchloincvalue($inout_totals, 'total_output_ml_day', 'intf_ref_value'); @endphp
                @php $total_output_ml_day_code = ValuelistHelpers::fetchloincvalue($inout_totals, 'total_output_ml_day', 'id',$i); @endphp
                {!! Form::label('total_output_ml_day','Total Output (ml/kg/day):') !!}
                @if ($total_output_ml_day != '')
                {!! Form::number('total_output_ml_day['.$total_output_ml_day_code.']',$total_output_ml_day,['class'=>'form-control total-output-ml-day number_pad need_dialpad', 'data-info'=> 'Total Output (ml/kg/day) - '.substr(@$time_slots[$i],3)]) !!}
                @else
                {!! Form::number('total_output_ml_day[]',null,['class'=>'form-control total-output-ml-day number_pad need_dialpad', 'data-info'=> 'Total Output (ml/kg/day) - '.substr(@$time_slots[$i],3)]) !!}
                @endif
            </div>
            <div class="form-group">
                @php $i_o_balance = ValuelistHelpers::fetchloincvalue($inout_totals, 'i_o_balance', 'intf_ref_value'); @endphp
                @php $i_o_balance_code = ValuelistHelpers::fetchloincvalue($inout_totals, 'i_o_balance', 'id',$i); @endphp
                {!! Form::label('i_o_balance','I/O Balance (ml):') !!}
                @if ($i_o_balance != '')
                {!! Form::number('i_o_balance['.$i_o_balance_code.']',$i_o_balance,['class'=>'form-control i-o-balance number_pad need_dialpad', 'data-info'=> 'I/O Balance (ml) - '.substr(@$time_slots[$i],3)]) !!}
                @else
                {!! Form::number('i_o_balance[]',null,['class'=>'form-control i-o-balance number_pad need_dialpad', 'data-info'=> 'I/O Balance (ml) - '.substr(@$time_slots[$i],3)]) !!}
                @endif
            </div>
            <div class="form-group">
                @php $i_o_balance_ml_kg = ValuelistHelpers::fetchloincvalue($inout_totals, 'i_o_balance_ml_kg', 'intf_ref_value'); @endphp
                @php $i_o_balance_ml_kg_code = ValuelistHelpers::fetchloincvalue($inout_totals, 'i_o_balance_ml_kg', 'id',$i); @endphp
                {!! Form::label('i_o_balance_ml_kg','I/O Balance (ml/kg/day):') !!}
                @if ($i_o_balance_ml_kg != '')
                {!! Form::number('i_o_balance_ml_kg['.$i_o_balance_ml_kg_code.']',$i_o_balance_ml_kg,['class'=>'form-control i-o-balance-ml-kg number_pad need_dialpad', 'data-info'=> 'I/O Balance (ml/kg/day) - '.substr(@$time_slots[$i],3)]) !!}
                @else
                {!! Form::number('i_o_balance_ml_kg[]',null,['class'=>'form-control i-o-balance-ml-kg number_pad need_dialpad', 'data-info'=> 'I/O Balance (ml/kg/day) - '.substr(@$time_slots[$i],3)]) !!}
                @endif
            </div>
        </div>
    </div>
</div>
<div role="tabpanel" class="tab-pane" id="ward-rounds">
    <div class="col-md-12 plr-0">
        <table class="table">
            <thead>
                <th>Time</th>
                <th>Instruction</th>
                <th></th>
            </thead>
            <tbody>
                @for($i = 0; $i < count($time_slots); $i++)
                <tr>
                    @php 
                    $temp_timevalue = explode(':', $time_slots[$i]);
                    $temp_timevalue = $temp_timevalue[1] . ':' . $temp_timevalue[2];
                    @endphp
                    <td>{!! $temp_timevalue !!}</td>
                    @if (isset($result[$time_slots[$i]]))
                    @php $ward_rounds_instruction = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'ward_rounds_instruction', 'intf_ref_value'); @endphp
                    @php $ward_rounds_instruction_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'ward_rounds_instruction', 'id',$i); @endphp
                    @if(!empty(trim($ward_rounds_instruction)))
                    <td>{!! Form::textarea('ward_rounds_instruction['.$ward_rounds_instruction_code.']', $ward_rounds_instruction,['class'=>'form-control', 'rows'=>2]) !!}</td>
                    <td></td>
                    @else
                    <td>{!! Form::textarea('ward_rounds_instruction['.$time_slots[$i].']', null,['class'=>'form-control display-none', 'rows'=>2, 'cols'=>50]) !!}</td>
                    <td>
                        <a class="btn btn-primary add-instruction pull-right" data-header-id="{{$time_slots[$i]}}" href="javascript:void(0);">
                            <i class="fa fa-plus"></i>
                            <span> Add Instruction </span>
                        </a>
                    </td>
                    @endif
                    @else
                    <td>{!! Form::textarea('ward_rounds_instruction['.$time_slots[$i].']', null,['class'=>'form-control display-none', 'rows'=>2, 'cols'=>50]) !!}</td>
                    <td>
                        <a class="btn btn-primary add-instruction pull-right" data-header-id="{{$time_slots[$i]}}" href="javascript:void(0);">
                            <i class="fa fa-plus"></i>
                            <span> Add Instruction </span>
                        </a>
                    </td>
                    @endif
                </tr>
                @endfor
            </tbody>
        </table>
    </div>
</div>
<!-- <div class="col-md-12 hidden">
    {!! Form::select('infusion_temp',$ivfluids ,null,['class'=>'form-control']) !!}
    {!! Form::select('infusion_gen_temp',$ivfluids_gen ,null,['class'=>'form-control']) !!}
    {!! Form::select('temp_frequency',ValuelistHelpers::drugFrequencyList(),'null') !!}
    {!! Form::select('infusion_dose_units_temp_g',ValuelistHelpers::infusiondoesunitgrams() ,null,['class'=>'form-control']) !!}
    {!! Form::select('infusion_dose_units_temp_kg',ValuelistHelpers::infusiondoeskilograms() ,null,['class'=>'form-control']) !!}
    {!! Form::select('infusion_dose_units_temp_time',ValuelistHelpers::infusiondoesduration() ,null,['class'=>'form-control']) !!}
    {!! Form::select('infusion_quantity_units_temp',ValuelistHelpers::infusionquantityunits() ,null,['class'=>'form-control']) !!}
    {!! Form::select('temp_syringe',ValuelistHelpers::getsyringesize() ,null,['class'=>'form-control']) !!}
    {!! Form::select('oral_temp',$drugs ,null,['class'=>'form-control']) !!}
    {!! Form::select('oral_gen_temp',$drugs_gen ,null,['class'=>'form-control']) !!}
</div> -->
<div role="tabpanel" class="tab-pane" id="important-blood-values">
    <h3 class="plr-15"><u><b>Important Blood Values</b></u></h3>
    <div class="col-md-12 plr-0">
        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    @foreach($time_slots as $time_key => $timevalue)
                    @php $slot = explode(":", $timevalue)[1]; @endphp
                    @php $slot1 = explode(":", $timevalue)[2]; @endphp
                    <th class="text-center">{{ $slot }}:{{ $slot1 }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Type Of Blood Gas:</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $blood_gas_type = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'blood_gas_type', 'intf_ref_value'); @endphp
                    @php $blood_gas_type_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'blood_gas_type', 'id',$i); @endphp
                    <td>{!! Form::select('blood_gas_type['.$blood_gas_type_code.']',[''=>'N/A','Not done'=>'Not done','Arterial'=>'Arterial','Venous'=>'Venous','Capillary'=>'Capillary','Not indicated'=>'Not indicated'],$blood_gas_type,['class'=>'form-control']) !!}</td>
                    @else
                    <td>{!! Form::select('blood_gas_type['.$time_slots[$i].']',[''=>'N/A','Not done'=>'Not done','Arterial'=>'Arterial','Venous'=>'Venous','Capillary'=>'Capillary','Not indicated'=>'Not indicated'],null,['class'=>'form-control']) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>Last BG at:</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $last_bg_time = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'last_bg_time', 'intf_ref_value'); @endphp
                    @php $last_bg_time_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'last_bg_time', 'id',$i); @endphp
                    <td>{!! Form::text('last_bg_time['.$last_bg_time_code.']',$last_bg_time,['class'=>'form-control', 'data-info'=> 'Last BG at - '.substr(@$time_slots[$i],3),'readonly']) !!}</td>
                    @else
                    <td>{!! Form::text('last_bg_time['.$time_slots[$i].']',null,['class'=>'form-control', 'data-info'=> 'Last BG at - '.substr(@$time_slots[$i],3),'readonly']) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>pH:</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $blood_gas_ph = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'interface_blood_gas_ph', 'intf_ref_value'); @endphp
                    @php $blood_gas_ph_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'interface_blood_gas_ph', 'id',$i); @endphp
                    <td>{!! Form::text('interface_blood_gas_ph['.$blood_gas_ph_code.']',$blood_gas_ph,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'pH - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('interface_blood_gas_ph['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'pH - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>Pao2:</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $blood_gas_pao2 = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'interface_blood_gas_pao2', 'intf_ref_value'); @endphp
                    @php $blood_gas_pao2_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'interface_blood_gas_pao2', 'id',$i); @endphp
                    <td>{!! Form::text('interface_blood_gas_pao2['.$blood_gas_pao2_code.']',$blood_gas_pao2,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Pao2 - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('interface_blood_gas_pao2['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Pao2 - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>TcPO2:</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $tcpo2 = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'tcpo2', 'intf_ref_value'); @endphp
                    @php $tcpo2_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'tcpo2', 'id',$i); @endphp
                    <td>{!! Form::text('tcpo2['.$tcpo2_code.']',$tcpo2,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'tcpo2 - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('tcpo2['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'tcpo2 - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>PaCo2:</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $blood_gas_paco2 = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'interface_blood_gas_paco2', 'intf_ref_value'); @endphp
                    @php $blood_gas_paco2_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'interface_blood_gas_paco2', 'id',$i); @endphp
                    <td>{!! Form::text('interface_blood_gas_paco2['.$blood_gas_paco2_code.']',$blood_gas_paco2,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'PaCo2 - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('interface_blood_gas_paco2['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'PaCo2 - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>TcPCO2:</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $tcpco2 = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'tcpco2', 'intf_ref_value'); @endphp
                    @php $tcpco2_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'tcpco2', 'id',$i); @endphp
                    <td>{!! Form::text('tcpco2['.$tcpco2_code.']',$tcpco2,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'tcpco2 - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('tcpco2['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'tcpco2 - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>ETCO2:</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $etco2 = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'interface_blood_gas_etco2', 'intf_ref_value'); @endphp
                    @php $etco2_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'interface_blood_gas_etco2', 'id',$i); @endphp
                    <td>{!! Form::text('etco2['.$etco2_code.']',$etco2,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'etco2 - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('etco2['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'etco2 - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>HCO3:</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $blood_gas_hco3 = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'interface_blood_gas_hco3', 'intf_ref_value'); @endphp
                    @php $blood_gas_hco3_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'interface_blood_gas_hco3', 'id',$i); @endphp
                    <td>{!! Form::text('interface_blood_gas_hco3['.$blood_gas_hco3_code.']',$blood_gas_hco3,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'HCO3 - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('interface_blood_gas_hco3['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'HCO3 - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>BE:</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $blood_gas_be = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'interface_blood_gas_be', 'intf_ref_value'); @endphp
                    @php $blood_gas_be_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'interface_blood_gas_be', 'id',$i); @endphp
                    <td>{!! Form::text('interface_blood_gas_be['.$blood_gas_be_code.']',$blood_gas_be,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'BE - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('interface_blood_gas_be['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'BE - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>Na (sodium) (mmol/L):</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $blood_gas_na = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'interface_blood_gas_na', 'intf_ref_value'); @endphp
                    @php $blood_gas_na_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'interface_blood_gas_na', 'id',$i); @endphp
                    <td>{!! Form::text('interface_blood_gas_na['.$blood_gas_na_code.']',$blood_gas_na,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Na (sodium) (mmol/L) - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('interface_blood_gas_na['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Na (sodium) (mmol/L) - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>K (potassium) (mmol/L):</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $blood_gas_k = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'interface_blood_gas_k', 'intf_ref_value'); @endphp
                    @php $blood_gas_k_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'interface_blood_gas_k', 'id',$i); @endphp
                    <td>{!! Form::text('interface_blood_gas_k['.$blood_gas_k_code.']',$blood_gas_k,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'K (potassium) (mmol/L) - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('interface_blood_gas_k['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'K (potassium) (mmol/L) - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>Calcium:</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $interface_blood_gas_calcium = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'interface_blood_gas_calcium', 'intf_ref_value'); @endphp
                    @php $blood_gas_calcium_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'interface_blood_gas_calcium', 'id',$i); @endphp
                    <td>{!! Form::text('interface_blood_gas_calcium['.$blood_gas_calcium_code.']',$interface_blood_gas_calcium,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Methemoglobin - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('interface_blood_gas_calcium['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Methemoglobin - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>cl (Chloride) (mmol/L):</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $blood_gas_cl = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'interface_blood_gas_cl', 'intf_ref_value'); @endphp
                    @php $blood_gas_cl_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'interface_blood_gas_cl', 'id',$i); @endphp
                    <td>{!! Form::text('interface_blood_gas_cl['.$blood_gas_cl_code.']',$blood_gas_cl,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'cl (Chloride) (mmol/L) - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('interface_blood_gas_cl['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'cl (Chloride) (mmol/L) - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>HB (g/dL):</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $blood_gas_hb = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'interface_blood_gas_hb', 'intf_ref_value'); @endphp
                    @php $blood_gas_hb_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'interface_blood_gas_hb', 'id',$i); @endphp
                    <td>{!! Form::text('interface_blood_gas_hb['.$blood_gas_hb_code.']',$blood_gas_hb,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'HB (g/dL) - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('interface_blood_gas_hb['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'HB (g/dL) - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>PCV (%):</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $blood_gas_pcv = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'interface_blood_gas_pcv', 'intf_ref_value'); @endphp
                    @php $blood_gas_pcv_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'interface_blood_gas_pcv', 'id',$i); @endphp
                    <td>{!! Form::text('interface_blood_gas_pcv['.$blood_gas_pcv_code.']',$blood_gas_pcv,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'PCV (%) - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('interface_blood_gas_pcv['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'PCV (%) - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>Lactate:</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $blood_gas_lactate = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'interface_blood_gas_lactate', 'intf_ref_value'); @endphp
                    @php $blood_gas_lactate_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'interface_blood_gas_lactate', 'id',$i); @endphp
                    <td>{!! Form::text('interface_blood_gas_lactate['.$blood_gas_lactate_code.']',$blood_gas_lactate,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Lactate - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('interface_blood_gas_lactate['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Lactate - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>Bilirubin:</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $interface_blood_gas_bilirubin = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'interface_blood_gas_bilirubin', 'intf_ref_value'); @endphp
                    @php $interface_blood_gas_bilirubin_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'interface_blood_gas_bilirubin', 'id',$i); @endphp
                    <td>{!! Form::text('interface_blood_gas_bilirubin['.$interface_blood_gas_bilirubin_code.']',$interface_blood_gas_bilirubin,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Bilirubin - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('interface_blood_gas_bilirubin['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Bilirubin - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>Blood Sugar (mg/dl) <small>(Blood Gas)</small></td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $interface_blood_gas_blood_sugar = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'interface_blood_gas_blood_sugar', 'intf_ref_value'); @endphp
                    @php $interface_blood_gas_blood_sugar_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'interface_blood_gas_blood_sugar', 'id',$i); @endphp
                    <td>{!! Form::text('interface_blood_gas_blood_sugar['.$interface_blood_gas_blood_sugar_code.']', $interface_blood_gas_blood_sugar,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Blood Sugar (mg/dl) - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('interface_blood_gas_blood_sugar['.$time_slots[$i].']', null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Blood Sugar (mg/dl) - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>Blood Sugar (mg/dl) <small>(Glucometer)</small></td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $blood_sugar = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'blood_sugar', 'intf_ref_value'); @endphp
                    @php $blood_sugar_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'blood_sugar', 'id',$i); @endphp
                    <td>{!! Form::text('blood_sugar['.$blood_sugar_code.']', $blood_sugar,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Blood Sugar (mg/dl) - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('blood_sugar['.$time_slots[$i].']', null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Blood Sugar (mg/dl) - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>Methemoglobin:</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $interface_blood_gas_methemoglobin = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'interface_blood_gas_methemoglobin', 'intf_ref_value'); @endphp
                    @php $interface_blood_gas_methemoglobin_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'interface_blood_gas_methemoglobin', 'id',$i); @endphp
                    <td>{!! Form::text('interface_blood_gas_methemoglobin['.$interface_blood_gas_methemoglobin_code.']',$interface_blood_gas_methemoglobin,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Methemoglobin - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('interface_blood_gas_methemoglobin['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Methemoglobin - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div role="tabpanel" class="tab-pane" id="gluco-meter">
    <h3 class="plr-15"><u><b>Gluco Meter</b></u></h3>
    <div class="col-md-12 plr-0">
        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    @foreach($time_slots as $time_key => $timevalue)
                    @php $slot = explode(":", $timevalue)[1]; @endphp
                    @php $slot1 = explode(":", $timevalue)[2]; @endphp
                    <th class="text-center">{{ $slot }}:{{ $slot1 }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Calcium (8.5-10.5 mg/dl):</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $gluco_meter_calcium = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_calcium', 'intf_ref_value'); @endphp
                    @php $gluco_meter_calcium_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_calcium', 'id',$i); @endphp
                    <td>{!! Form::text('gluco_meter_calcium['.$gluco_meter_calcium_code.']',$gluco_meter_calcium,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Calcium - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('gluco_meter_calcium['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Calcium - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>Magnesium (.6-1.1 nM/L):</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $gluco_meter_magnesium = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_magnesium', 'intf_ref_value'); @endphp
                    @php $gluco_meter_magnesium_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_magnesium', 'id',$i); @endphp
                    <td>{!! Form::text('gluco_meter_magnesium['.$gluco_meter_magnesium_code.']',$gluco_meter_magnesium,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Magnesium - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('gluco_meter_magnesium['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Magnesium - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>Phosphorus (2.7-4.5 mg/dl):</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $gluco_meter_phosphorus = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_phosphorus', 'intf_ref_value'); @endphp
                    @php $gluco_meter_phosphorus_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_phosphorus', 'id',$i); @endphp
                    <td>{!! Form::text('gluco_meter_phosphorus['.$gluco_meter_phosphorus_code.']',$gluco_meter_phosphorus,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Phosphorus - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('gluco_meter_phosphorus['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Phosphorus - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>BUN (6-20 mg/dl):</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $gluco_meter_bun = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_bun', 'intf_ref_value'); @endphp
                    @php $gluco_meter_bun_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_bun', 'id',$i); @endphp
                    <td>{!! Form::text('gluco_meter_bun['.$gluco_meter_bun_code.']',$gluco_meter_bun,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'BUN - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('gluco_meter_bun['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'BUN - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>Creatintine (0.6-1.4 mg/dl):</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $gluco_meter_creatintine = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_creatintine', 'intf_ref_value'); @endphp
                    @php $gluco_meter_creatintine_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_creatintine', 'id',$i); @endphp
                    <td>{!! Form::text('gluco_meter_creatintine['.$gluco_meter_creatintine_code.']',$gluco_meter_creatintine,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Creatintine - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('gluco_meter_creatintine['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Creatintine - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>Glucose (70-110 mg/dl):</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $gluco_meter_glucose = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_glucose', 'intf_ref_value'); @endphp
                    @php $gluco_meter_glucose_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_glucose', 'id',$i); @endphp
                    <td>{!! Form::text('gluco_meter_glucose['.$gluco_meter_glucose_code.']',$gluco_meter_glucose,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Glucose - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('gluco_meter_glucose['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Glucose - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>Creatine Kinase (CK) (26-174 U/L):</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $gluco_meter_creatinekinase = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_creatinekinase', 'intf_ref_value'); @endphp
                    @php $gluco_meter_creatinekinase_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_creatinekinase', 'id',$i); @endphp
                    <td>{!! Form::text('gluco_meter_creatinekinase['.$gluco_meter_creatinekinase_code.']',$gluco_meter_creatinekinase,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Creatine Kinase (CK) - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('gluco_meter_creatinekinase['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Creatine Kinase (CK) - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>CK - MB (&#60;6% of Total CK):</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $gluco_meter_ckmb = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_ckmb', 'intf_ref_value'); @endphp
                    @php $gluco_meter_ckmb_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_ckmb', 'id',$i); @endphp
                    <td>{!! Form::text('gluco_meter_ckmb['.$gluco_meter_ckmb_code.']',$gluco_meter_ckmb,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'CK - MB - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('gluco_meter_ckmb['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'CK - MB - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>Trop. T:</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $gluco_meter_trop = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_trop', 'intf_ref_value'); @endphp
                    @php $gluco_meter_trop_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_trop', 'id',$i); @endphp
                    <td>{!! Form::text('gluco_meter_trop['.$gluco_meter_trop_code.']',$gluco_meter_trop,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Trop. T - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('gluco_meter_trop['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Trop. T - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>Total bilirubin (&#60; 1 mg/dl):</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $gluco_meter_totalbilirubin = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_totalbilirubin', 'intf_ref_value'); @endphp
                    @php $gluco_meter_totalbilirubin_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_totalbilirubin', 'id',$i); @endphp
                    <td>{!! Form::text('gluco_meter_totalbilirubin['.$gluco_meter_totalbilirubin_code.']',$gluco_meter_totalbilirubin,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Total bilirubin - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('gluco_meter_totalbilirubin['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Total bilirubin - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>Direct bilirubin (&#60; 0.4 mg/dl):</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $gluco_meter_directbilirubin = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_directbilirubin', 'intf_ref_value'); @endphp
                    @php $gluco_meter_directbilirubin_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_directbilirubin', 'id',$i); @endphp
                    <td>{!! Form::text('gluco_meter_directbilirubin['.$gluco_meter_directbilirubin_code.']',$gluco_meter_directbilirubin,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Direct bilirubin - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('gluco_meter_directbilirubin['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Direct bilirubin - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>SGOT (AST) (&#60; 0-40 U/L):</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $gluco_meter_sgot = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_sgot', 'intf_ref_value'); @endphp
                    @php $gluco_meter_sgot_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_sgot', 'id',$i); @endphp
                    <td>{!! Form::text('gluco_meter_sgot['.$gluco_meter_sgot_code.']',$gluco_meter_sgot,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'SGOT (AST) - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('gluco_meter_sgot['.$time_slots[$i].']', null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'SGOT (AST) - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>SGPT (AST) (&#60; 0-40 U/L):</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $gluco_meter_sgpt = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_sgpt', 'intf_ref_value'); @endphp
                    @php $gluco_meter_sgpt_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_sgpt', 'id',$i); @endphp
                    <td>{!! Form::text('gluco_meter_sgpt['.$gluco_meter_sgpt_code.']',$gluco_meter_sgpt,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'SGPT (AST) - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('gluco_meter_sgpt['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'SGPT (AST) - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>Alkaline Phosphatase (30-115 U/L):</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $gluco_meter_alkalinephosphatase = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_alkalinephosphatase', 'intf_ref_value'); @endphp
                    @php $gluco_meter_alkalinephosphatase_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_alkalinephosphatase', 'id',$i); @endphp
                    <td>{!! Form::text('gluco_meter_alkalinephosphatase['.$gluco_meter_alkalinephosphatase_code.']',$gluco_meter_alkalinephosphatase,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Alkaline Phosphatase - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('gluco_meter_alkalinephosphatase['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Alkaline Phosphatase - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>Gama GTP (F5-55, M15-85 U/L):</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $gluco_meter_gamagtp = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_gamagtp', 'intf_ref_value'); @endphp
                    @php $gluco_meter_gamagtp_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_gamagtp', 'id',$i); @endphp
                    <td>{!! Form::text('gluco_meter_gamagtp['.$gluco_meter_gamagtp_code.']', $gluco_meter_gamagtp,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Gama GTP - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('gluco_meter_gamagtp['.$time_slots[$i].']', null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Gama GTP - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>LDH (90-220 U/L):</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $gluco_meter_ldh = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_ldh', 'intf_ref_value'); @endphp
                    @php $gluco_meter_ldh_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_ldh', 'id',$i); @endphp
                    <td>{!! Form::text('gluco_meter_ldh['.$gluco_meter_ldh_code.']',$gluco_meter_ldh,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'LDH - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('gluco_meter_ldh['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'LDH - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>Amylase (31-123 U/L):</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $gluco_meter_amylase = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_amylase', 'intf_ref_value'); @endphp
                    @php $gluco_meter_amylase_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_amylase', 'id',$i); @endphp
                    <td>{!! Form::text('gluco_meter_amylase['.$gluco_meter_amylase_code.']',$gluco_meter_amylase,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Amylase - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('gluco_meter_amylase['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Amylase - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>Lipase:</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $gluco_meter_lipase = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_lipase', 'intf_ref_value'); @endphp
                    @php $gluco_meter_lipase_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_lipase', 'id',$i); @endphp
                    <td>{!! Form::text('gluco_meter_lipase['.$gluco_meter_lipase_code.']',$gluco_meter_lipase,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Lipase - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('gluco_meter_lipase['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Lipase - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>Total Protein (6-8.4 gm/dl):</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $gluco_meter_totalprotein = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_totalprotein', 'intf_ref_value'); @endphp
                    @php $gluco_meter_totalprotein_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_totalprotein', 'id',$i); @endphp
                    <td>{!! Form::text('gluco_meter_totalprotein['.$gluco_meter_totalprotein_code.']',$gluco_meter_totalprotein,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Total Protein - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('gluco_meter_totalprotein['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Total Protein - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>Albumin (3.5-5.3 gm/dl):</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $gluco_meter_albumin = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_albumin', 'intf_ref_value'); @endphp
                    @php $gluco_meter_albumin_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_albumin', 'id',$i); @endphp
                    <td>{!! Form::text('gluco_meter_albumin['.$gluco_meter_albumin_code.']',$gluco_meter_albumin,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Albumin - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('gluco_meter_albumin['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Albumin - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>Total Cholesterol:</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $gluco_meter_totalcholesterol = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_totalcholesterol', 'intf_ref_value'); @endphp
                    @php $gluco_meter_totalcholesterol_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_totalcholesterol', 'id',$i); @endphp
                    <td>{!! Form::text('gluco_meter_totalcholesterol['.$gluco_meter_totalcholesterol_code.']',$gluco_meter_totalcholesterol,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Total Cholesterol - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('gluco_meter_totalcholesterol['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Total Cholesterol - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>HDL:</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $gluco_meter_hdl = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_hdl', 'intf_ref_value'); @endphp
                    @php $gluco_meter_hdl_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_hdl', 'id',$i); @endphp
                    <td>{!! Form::text('gluco_meter_hdl['.$gluco_meter_hdl_code.']',$gluco_meter_hdl,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'HDL - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('gluco_meter_hdl['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'HDL - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>LDL:</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $gluco_meter_ldl = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_ldl', 'intf_ref_value'); @endphp
                    @php $gluco_meter_ldl_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_ldl', 'id',$i); @endphp
                    <td>{!! Form::text('gluco_meter_ldl['.$gluco_meter_ldl_code.']',$gluco_meter_ldl,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'LDL - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('gluco_meter_ldl['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'LDL - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>VLDL:</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $gluco_meter_vldl = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_vldl', 'intf_ref_value'); @endphp
                    @php $gluco_meter_vldl_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_vldl', 'id',$i); @endphp
                    <td>{!! Form::text('gluco_meter_vldl['.$gluco_meter_vldl_code.']',$gluco_meter_vldl,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'VLDL - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('gluco_meter_vldl['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'VLDL - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>Tri Glycerides:</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $gluco_meter_triglycerides = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_triglycerides', 'intf_ref_value'); @endphp
                    @php $gluco_meter_triglycerides_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_triglycerides', 'id',$i); @endphp
                    <td>{!! Form::text('gluco_meter_triglycerides['.$gluco_meter_triglycerides_code.']',$gluco_meter_triglycerides,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Tri Glycerides - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('gluco_meter_triglycerides['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Tri Glycerides - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>RBC<span> (3.5-5.5 10<sup>6</sup>/ul)</span>:</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $gluco_meter_rbc = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_rbc', 'intf_ref_value'); @endphp
                    @php $gluco_meter_rbc_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_rbc', 'id',$i); @endphp
                    <td>{!! Form::text('gluco_meter_rbc['.$gluco_meter_rbc_code.']',$gluco_meter_rbc,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'RBC - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('gluco_meter_rbc['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'RBC - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>Haematocrit (PCV) (35-55):</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $gluco_meter_haematocrit = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_haematocrit', 'intf_ref_value'); @endphp
                    @php $gluco_meter_haematocrit_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_haematocrit', 'id',$i); @endphp
                    <td>{!! Form::text('gluco_meter_haematocrit['.$gluco_meter_haematocrit_code.']',$gluco_meter_haematocrit,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Haematocrit (PCV) - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('gluco_meter_haematocrit['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Haematocrit (PCV) - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>Reticulocyte count (0.5-1.5 %):</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $gluco_meter_reticulocytecount = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_reticulocytecount', 'intf_ref_value'); @endphp
                    @php $gluco_meter_reticulocytecount_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_reticulocytecount', 'id',$i); @endphp
                    <td>{!! Form::text('gluco_meter_reticulocytecount['.$gluco_meter_reticulocytecount_code.']',$gluco_meter_reticulocytecount,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Reticulocyte count - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('gluco_meter_reticulocytecount['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Reticulocyte count - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>WBC : Total Count (4.000-11.0000/ul):</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $gluco_meter_wbc = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_wbc', 'intf_ref_value'); @endphp
                    @php $gluco_meter_wbc_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_wbc', 'id',$i); @endphp
                    <td>{!! Form::text('gluco_meter_wbc['.$gluco_meter_wbc_code.']',$gluco_meter_wbc,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'WBC : Total Count - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('gluco_meter_wbc['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'WBC : Total Count - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>DC : Poly (40-75 %):</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $gluco_meter_dc = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_dc', 'intf_ref_value'); @endphp
                    @php $gluco_meter_dc_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_dc', 'id',$i); @endphp
                    <td>{!! Form::text('gluco_meter_dc['.$gluco_meter_dc_code.']',$gluco_meter_dc,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'DC : Poly - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('gluco_meter_dc['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'DC : Poly - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>Lymph (0-75 %):</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $gluco_meter_lymph = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_lymph', 'intf_ref_value'); @endphp
                    @php $gluco_meter_lymph_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_lymph', 'id',$i); @endphp
                    <td>{!! Form::text('gluco_meter_lymph['.$gluco_meter_lymph_code.']',$gluco_meter_lymph,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Lymph - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('gluco_meter_lymph['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Lymph - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>Mono (2-10 %):</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $gluco_meter_mono = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_mono', 'intf_ref_value'); @endphp
                    @php $gluco_meter_mono_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_mono', 'id',$i); @endphp
                    <td>{!! Form::text('gluco_meter_mono['.$gluco_meter_mono_code.']',$gluco_meter_mono,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Mono - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('gluco_meter_mono['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Mono - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>Eos (1-6 %):</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $gluco_meter_eos = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_eos', 'intf_ref_value'); @endphp
                    @php $gluco_meter_eos_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_eos', 'id',$i); @endphp
                    <td>{!! Form::text('gluco_meter_eos['.$gluco_meter_eos_code.']',$gluco_meter_eos,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Eos - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('gluco_meter_eos['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Eos - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>Baso (0-1 %):</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $gluco_meter_baso = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_baso', 'intf_ref_value'); @endphp
                    @php $gluco_meter_baso_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_baso', 'id',$i); @endphp
                    <td>{!! Form::text('gluco_meter_baso['.$gluco_meter_baso_code.']',$gluco_meter_baso,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Baso - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('gluco_meter_baso['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Baso - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>Platelets:</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $gluco_meter_platelets = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_platelets', 'intf_ref_value'); @endphp
                    @php $gluco_meter_platelets_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_platelets', 'id',$i); @endphp
                    <td>{!! Form::text('gluco_meter_platelets['.$gluco_meter_platelets_code.']',$gluco_meter_platelets,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Platelets - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('gluco_meter_platelets['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Platelets - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>ESR (M: 3-10; F: 5-20):</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $gluco_meter_esr = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_esr', 'intf_ref_value'); @endphp
                    @php $gluco_meter_esr_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_esr', 'id',$i); @endphp
                    <td>{!! Form::text('gluco_meter_esr['.$gluco_meter_esr_code.']',$gluco_meter_esr,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'ESR - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('gluco_meter_esr['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'ESR - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>Prothrombin Time:</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $gluco_meter_prothrombintime = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_prothrombintime', 'intf_ref_value'); @endphp
                    @php $gluco_meter_prothrombintime_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_prothrombintime', 'id',$i); @endphp
                    <td>{!! Form::text('gluco_meter_prothrombintime['.$gluco_meter_prothrombintime_code.']',$gluco_meter_prothrombintime,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Prothrombin Time - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('gluco_meter_prothrombintime['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Prothrombin Time - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>APTT:</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $gluco_meter_aptt = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_aptt', 'intf_ref_value'); @endphp
                    @php $gluco_meter_aptt_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_aptt', 'id',$i); @endphp
                    <td>{!! Form::text('gluco_meter_aptt['.$gluco_meter_aptt_code.']',$gluco_meter_aptt,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'APTT - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('gluco_meter_aptt['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'APTT - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>INR:</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $gluco_meter_inr = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_inr', 'intf_ref_value'); @endphp
                    @php $gluco_meter_inr_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_inr', 'id',$i); @endphp
                    <td>{!! Form::text('gluco_meter_inr['.$gluco_meter_inr_code.']',$gluco_meter_inr,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'INR - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('gluco_meter_inr['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'INR - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>Fibrinogen:</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $gluco_meter_fibrinogen = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_fibrinogen', 'intf_ref_value'); @endphp
                    @php $gluco_meter_fibrinogen_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_fibrinogen', 'id',$i); @endphp
                    <td>{!! Form::text('gluco_meter_fibrinogen['.$gluco_meter_fibrinogen_code.']',$gluco_meter_fibrinogen,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Fibrinogen - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('gluco_meter_fibrinogen['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'Fibrinogen - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
                <tr>
                    <td>FDP:</td>
                    @for($i = 0; $i < count($time_slots); $i++)
                    @if (isset($result[$time_slots[$i]]))
                    @php $gluco_meter_fdp = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_fdp', 'intf_ref_value'); @endphp
                    @php $gluco_meter_fdp_code = ValuelistHelpers::fetchloincvalue($result[$time_slots[$i]], 'gluco_meter_fdp', 'id',$i); @endphp
                    <td>{!! Form::text('gluco_meter_fdp['.$gluco_meter_fdp_code.']',$gluco_meter_fdp,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'FDP - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @else
                    <td>{!! Form::text('gluco_meter_fdp['.$time_slots[$i].']',null,['class'=>'form-control number_pad need_dialpad', 'data-info'=> 'FDP - '.substr(@$time_slots[$i],3)]) !!}</td>
                    @endif
                    @endfor
                </tr>
            </tbody>
        </table>
    </div>
</div>
        <div role="tabpanel" class="tab-pane" id="media_tab">
            <input type="hidden" name="module_name" value="2">
            <div class="m-15">
            @include('registration.media')
            </div>
        </div>
<div class="row col-md-12 mt-20">
    <input type="hidden" name="print_flag" value="0" id="print_flag"/>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <button type="button" data-flag="1" class="btn btn-block btn-primary save-button-shadow submit-btn">
            <i class="fa fa-floppy-o"></i>
            <span>{!! $SubmitButtonText !!}</span>
        </button>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <button type="button" data-flag="2" class="btn btn-block btn-primary save-button-shadow submit-btn">
            <i class="fa fa-floppy-o"></i>
            <span>{!! $SubmitClose !!}</span>
        </button>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <button type="button" data-flag="3" class="btn btn-block btn-info  save-button-shadow submit-btn">
            <i class="fa fa-print"></i>
            <span>Print</span>
        </button>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="{{url('nicu-nurse-sheet-day/' . \SiteHelpers::encrypt_id($baby_details->admission_id))}}" class="btn btn-block btn-default save-button-shadow" onclick="$('form')[0].reset();">
            <i class="fa fa-exclamation-circle"></i> 
            <span>Cancel</span>
        </a>
    </div>
</div>
</div>
</div>
