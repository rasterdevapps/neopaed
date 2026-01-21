<div class="col-md-12 col-sm-12">
    <div class="content-block">
        <div class="col-md-12 col-sm-12 plr-must-0">
            <div class="col-md-4 col-sm-4 col-xs-3 plr-must-0">
                <div class="form-group">
                    <div>
                        <span class="op-print-label print-label-text">{{ Lang::get('home.mrn') }}:</span> 
                        <span class="print-label-value">{!! $baby_detail->BMrNo; !!}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-3 plr-must-0">
                <div class="form-group">
                    <div>
                        <span class="op-print-label print-label-text">Name:</span> 
                        <span class="print-label-value">{!! $baby_detail->BabyName; !!}</span>
                    </div>
                </div>
            </div>
            @if (!empty($baby_detail->DOB))
            <div class="col-md-4 col-sm-4 col-xs-3 plr-must-0">
                <div class="form-group">
                    <div>
                        <span class="op-print-label print-label-text">DOB:</span> 
                        <span class="print-label-value">{!! date("d-m-Y",strtotime($baby_detail->DOB)); !!}</span>
                    </div>
                </div>
            </div>
            @endif
            @if (!empty($baby_detail->Sex))
            <div class="col-md-4 col-sm-4 col-xs-3 plr-must-0">
                <div class="form-group">
                    <div>
                        <span class="op-print-label print-label-text">Sex:</span> 
                        <span class="print-label-value">{!! $baby_detail->Sex; !!}</span>
                    </div>
                </div>
            </div>
            @endif
            @if (!empty($baby_detail->age_year) || !empty($baby_detail->age_month) || !empty($baby_detail->age_days))
            <div class="col-md-4 col-sm-4 col-xs-3 plr-must-0">
                <div class="form-group">
                    <div>
                        <span class="op-print-label print-label-text">Age:</span> 
                        <span class="print-label-value">{{ !empty($baby_detail->age_year) ? $baby_detail->age_year . ' Year' : '' }}  {{ !empty($baby_detail->age_month) ? $baby_detail->age_month . ' Month' : '' }}  {{ isset($baby_detail->age_days) ? $baby_detail->age_days . ' Days' : '' }} </span>
                    </div>
                </div>
            </div>
            @endif
            @if (!empty($baby_detail->current_weight))
            <div class="col-md-4 col-sm-4 col-xs-3 plr-must-0">
                <div class="form-group">
                    <div>
                        <span class="op-print-label print-label-text">Current Weight:</span> 
                        <span class="print-label-value">{{ (!empty($baby_detail->current_weight) && $baby_detail->current_weight > 1000) ? $baby_detail->current_weight / 1000 . ' (KG)': $baby_detail->current_weight.' (G)'  }}</span>
                    </div>
                </div>
            </div>
            @endif
            @if (!empty($baby_detail->current_ofc))
            <div class="col-md-4 col-sm-4 col-xs-3 plr-must-0">
                <div class="form-group">
                    <div>
                        <span class="op-print-label print-label-text">Head Circumference (cm):</span> 
                        <span class="print-label-value">{!! $baby_detail->current_ofc; !!}</span>
                    </div>
                </div>
            </div>
            @endif
            @if (!empty($baby_detail->current_length))
            <div class="col-md-4 col-sm-4 col-xs-3 plr-must-0">
                <div class="form-group">
                    <div>
                        <span class="op-print-label print-label-text">Length / Height (cm):</span> 
                        <span class="print-label-value">{!! $baby_detail->current_length; !!}</span>
                    </div>
                </div>
            </div>
            @endif
            @if (!empty($baby_detail->current_bmi))
            <div class="col-md-4 col-sm-4 col-xs-3 plr-must-0">
                <div class="form-group">
                    <div>
                        <span class="op-print-label print-label-text">BMI:</span> 
                        <span class="print-label-value">{!! $baby_detail->current_bmi; !!}</span>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@if (!empty($baby_detail->current_status) || !empty($baby_detail->hopi) || !empty($baby_detail->development) || !empty($baby_detail->immunization_content) || !empty($baby_detail->examination) || !empty($baby_detail->impression) || !empty($baby_detail->advice) || !empty($baby_detail->allegries))
<div class="col-md-12 col-sm-12">
    <div class="content-block">
        @if (!empty($baby_detail->current_status))
        <div class="form-group">
            <span class="print-label print-label-text">Presenting complaints:</span> 
            <span class="op-value print-label-value">{!! $baby_detail->current_status; !!}</span>
        </div>
        @endif
        @if (!empty($baby_detail->hopi))
        <div class="form-group">
            <span class="print-label print-label-text">HOPI:</span> 
            <span class="op-value print-label-value">{!! $baby_detail->hopi; !!}</span>
        </div>
        @endif
        @if (!empty($baby_detail->development))
        <div class="form-group">
            <span class="print-label print-label-text">Development:</span> 
            <span class="op-value print-label-value">{!! $baby_detail->development; !!}</span>
        </div>
        @endif
        @if (!empty($baby_detail->immunization_content))
        <div class="form-group">
            <span class="print-label print-label-text">Immunization:</span> 
            <span class="op-value print-label-value">{!! $baby_detail->immunization_content; !!}</span>
        </div>
        @endif
        @if (!empty($baby_detail->examination))
        <div class="form-group">
            <span class="print-label print-label-text">Examination:</span>
            <span class="op-value print-label-value">{!! $baby_detail->examination; !!}</span>
        </div>
        @endif
        @if (!empty($baby_detail->impression))
        <div class="form-group">
            <span class="print-label print-label-text">Impression:</span> 
            <span class="op-value print-label-value">{!! $baby_detail->impression; !!}</span>
        </div>
        @endif
        @if (!empty($baby_detail->advice))
        <div class="form-group">
            <span class="print-label print-label-text">Advice:</span> 
            <span class="op-value print-label-value">{!! $baby_detail->advice; !!}</span>
        </div>
        @endif
        @if (!empty($baby_detail->allegries))
        <div class="form-group">
            <span class="print-label print-label-text">Allergies:</span> 
            <span class="op-value print-label-value">{!! $baby_detail->allegries; !!}</span>
        </div>
        @endif
    </div>
</div>
@endif
@php 
$frequency_list = ValuelistHelpers::drugFrequencyList();
$formulation = ValuelistHelpers::formulationStrength();
$route = ValuelistHelpers::route();
$medications = collect($medications)->groupBy('Medication');
@endphp
@if (count($medications) > 0)
<div class="col-md-12 col-sm-12">
    <div class="content-block">
        <table class="form-group medicine table">
            <div class="form-group">
                <span class="print-label">
                    <b>Medications:</b>
                </span>
            </div>
            <thead>
                <tr>
                    <th><b>Drug</b></th>
                    <th><b>Generic Name</b></th>
                    <th><b>Formulation </b></th>
                    <th><b>Route</b></th>
                    <th><b>Dose</b></th>
                    <th><b>Frequency</b></th>
                    <th><b>Duration</b></th>
                </tr>
            </thead>
            <tbody>
                @foreach($medications as $temp_key => $temp_medicine)   
                @foreach($temp_medicine as $key => $medicine)   
                <tr>
                    @if ($key == 0)
                    @php $drug = explode('/', $drug_data[$medicine->Medication]); @endphp
                    <td>{!! isset($drug[0]) ? $drug[0] : '' !!}</td>
                    <td>{!! isset($drug[1]) ? $drug[1] : '' !!}</td>
                    <td>{!! (isset($medicine->formulation) && isset($formulation[$medicine->formulation])) ? $formulation[$medicine->formulation] : '' !!}</td>
                    <td>{!! (isset($medicine->route) && isset($route[$medicine->route])) ? $route[$medicine->route] : '' !!}</td>
                    @else
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    @endif
                    <td>{!! $medicine->Dose !!}</td>
                    <td>{!! isset($frequency_list[$medicine->Frequency]) ? $frequency_list[$medicine->Frequency] : '' !!}</td>
                    <td>{!! $medicine->Duration !!}</td>
                </tr>
                @endforeach 
                @endforeach 
            </tbody>
        </table>
    </div>
</div>
@endif
@if ((isset($baby_detail->schedule) && !empty($baby_detail->schedule)) || (isset($baby_detail->vaccine) && is_array($baby_detail->vaccine) && count($baby_detail->vaccine) > 0 && $baby_detail->immunization == 'Given') || (isset($baby_detail->immunization) && !empty($baby_detail->immunization)))
<div class="col-md-12 col-sm-12 col-xs-12 page-break-page mt-15 pediatric-schedule">
    <!-- <div class="content-block"> -->
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td><b>Schedule</b></td>
                    <td><b>Vaccine</b></td>
                    <td><b>Status</b></td>
                </tr>
                <tr>
                    <td>
                        @if (isset($baby_detail->schedule) && !empty($baby_detail->schedule))
                        {!! $baby_detail->schedule; !!}
                        @else
                        -
                        @endif
                    </td>
                    <td>
                        @if(isset($baby_detail->vaccine) && is_array($baby_detail->vaccine) && count($baby_detail->vaccine) > 0 && $baby_detail->immunization == 'Given')
                        @php $count = 1;  @endphp
                        @php $vaccine_count = count($baby_detail->vaccine); @endphp
                        @foreach($baby_detail->vaccine as $vaccine_code)
                        @if(isset($vaccine[$vaccine_code]))
                        @if($count == $vaccine_count) 
                        {!! $count.'. '.$vaccine[$vaccine_code].'.' !!}
                        @else 
                        {!! $count.'. '.$vaccine[$vaccine_code].',  ' !!}
                        @endif 
                        @endif  
                        @php $count++; @endphp  
                        @endforeach 
                        @else
                        -
                        @endif
                    </td>
                    <td>
                        @if (isset($baby_detail->immunization) && !empty($baby_detail->immunization))
                        {!! $baby_detail->immunization; !!}
                        @else
                        -
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="form-group">
            <h4 class=""><b>Next Review:<b></h4>
                <h4 class="">@if(date("Y",strtotime($baby_detail->review)) > 1970) {!! date("d-m-Y",strtotime($baby_detail->review)); !!} {!! $baby_detail->review_time.':'.(empty($baby_detail->review_min) ? '00' : $baby_detail->review_min).' '.$baby_detail->review_session  !!} @else {{ title_case('A Review Appoinment not been made.') }}  @endif</h4>
            </div>
            <!-- </div> -->
        </div>
        @endif
<!-- <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0 page-break-page">
    <div class="col-md-12 col-sm-12">
        <div class="content-block">
            <div class="col-md-12 col-sm-12 plr-must-0">
                @if (!empty($baby_detail->immunization))
                <div class="form-group">
                    <div>
                        <span class="print-label print-label-text">Immunization:</span> 
                        <span class="print-label-value">{!! $baby_detail->immunization; !!}</span>
                    </div>
                </div>
                @endif
                @if(isset($baby_detail->vaccine) && is_array($baby_detail->vaccine) && count($baby_detail->vaccine) > 0 && $baby_detail->immunization == 'Given')
                <div class="form-group">
                    <span class="print-label print-label-text">Vaccine: </span>
                </div>
                <div class="form-group">
                    <div class="vaccine-margin print-label-value">
                        @php $count = 1;  @endphp
                        @php $vaccine_count = count($baby_detail->vaccine); @endphp
                        @foreach($baby_detail->vaccine as $vaccine_code)
                        @if(isset($vaccine[$vaccine_code]))
                        @if($count == $vaccine_count) 
                        {!! $count.'. '.$vaccine[$vaccine_code].'.' !!}
                        @else 
                        {!! $count.'. '.$vaccine[$vaccine_code].',  ' !!}
                        @endif 
                        @endif  
                        @php $count++; @endphp  
                        @endforeach 
                    </div>
                </div>
                @endif  
                @if (!empty($baby_detail->schedule))
                <div class="form-group">
                    <div>
                        <span class="print-label print-label-text">Schedule:</span> 
                        <span class="print-label-value">{!! $baby_detail->schedule; !!}</span>
                    </div>
                </div>
                @endif  
                <div class="form-group">
                    <div>
                        <span class="print-label print-label-text">Next Review:</span>
                        <span class="print-label-value">@if(date("Y",strtotime($baby_detail->review)) > 1970) {!! date("d-m-Y",strtotime($baby_detail->review)); !!} {!! $baby_detail->review_time.':'.$baby_detail->review_min.' '.$baby_detail->review_session  !!} @else {{ title_case('A Review Appoinment not been made.') }}  @endif</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->
