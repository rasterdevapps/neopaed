@extends('print')
@section('content')

<?php echo "<style>"; ?>
@if(isset($tags))
    @foreach($tags as $tagss)
     {!! $tagss."{ background-color:yellow;}" !!}

    @endforeach

@endif
<?php echo "</style>"; ?>
@if (isset($editor_gen) && $editor_gen)
<div class="editor_style">
  @include('editor_print')  
</div>
@endif
@if(isset($page_config->id))
    @php 
        $top_spacing = $page_config->top_spacing;
        $right_spacing = $page_config->right_spacing;
        $bottom_spacing = $page_config->bottom_spacing;
        $left_spacing = $page_config->left_spacing;
    @endphp
@endif
<style type="text/css">
    .form-group span {
        font-weight: normal;
    }
    @if(isset($top_spacing))
        @page {
            margin: {{$top_spacing}}px {{$right_spacing}}px {{$bottom_spacing}}px {{$left_spacing}}px;
        }
    @endif
</style>
{{ Form::hidden('OpId', $results->OpId) }}
<div class="temp-container op-container">
    <div class="temp-row">
        <div class="@if(isset($page_config->id)) hidden-print @endif">
            <div class="col-md-11 col-sm-11 header-img">
                @if(isset($results->OpId))
                <img src="{{ SiteHelpers::getOpLogo($results->OpId) }}">
                @endif
            </div>
            <div class="col-md-11 col-sm-11 mt-15 plr-must-0">
                <div class="col-md-8 col-xs-8 ">
                    {!! \ValuelistHelpers::headerContent($results->hospital_name, $headerContent) !!}
                </div>
                <div class="col-md-4 col-xs-4">
                    {!! $headerContent['neonatal_op_print_right'] !!}
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-11 col-sm-11">
            <h3 class="print-head">OP Consultation Record</h3>
            <span class="pull-right font-bold text-right">Date : {!! date("d-m-Y",strtotime($results->OpDate)); !!} </span>
        </div>
        <div class="col-md-11 col-sm-11">
            <div class="content-block"> 
                <div class="col-md-12 col-sm-12 plr-must-0">
                    <div class="col-md-4 col-sm-4 col-xs-3 plr-must-0">
                        <div class="form-group">
                            <div>
                                <span class="op-print-label print-label-text">{{ Lang::get('home.mrn') }}:</span> 
                                <span class="print-label-value">{!! $results->BMrNo; !!}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <span class="op-print-label print-label-text">Name:</span> 
                                <span class="print-label-value">{!! $results->BabyName; !!}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <span class="op-print-label print-label-text">DOB:</span> 
                                <span class="print-label-value">{!! date("d-m-Y",strtotime($results->DOB)); !!}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <span class="op-print-label print-label-text">Sex:</span> 
                                <span class="print-label-value">{!! $results->Sex; !!}</span>
                            </div>                            
                        </div> 
                        <div class="form-group">
                            <div>
                                <span class="op-print-label print-label-text">Gestation (wks):</span> 
                                <span class="print-label-value">{!! $results->Gestation; !!}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3 plr-must-0">
                        <div class="form-group">
                            <div>
                                <span class="op-print-label print-label-text">Birth Weight(g):</span> 
                                <span class="print-label-value">{!! $results->BirthWeight; !!}</span>
                            </div>
                        </div>  
                        <div class="form-group">
                            <div>
                                <span class="op-print-label print-label-text">Current Weight :</span> 
                                <span class="print-label-value">{{ (!empty($results->CurrentWt) && $results->CurrentWt > 1000) ? number_format($results->CurrentWt / 1000, 2) . ' (KG)': $results->CurrentWt.' (G)'  }}</span>
                            </div>                            
                        </div> 
                        <div class="form-group">
                            <div>
                                <span class="op-print-label print-label-text">OFC (cm):</span> 
                                <span class="print-label-value">{!! $results->CurrentOFC; !!}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div>
                                <span class="op-print-label print-label-text">Length / Height (cm):</span> 
                                <span class="print-label-value">{!! $results->CurrentLength; !!}</span>
                            </div>                                
                        </div>   
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-4 plr-must-0">
                        @if($results->g_weeks == 0 || $results->g_weeks > 36 || ($results->g_weeks < 37 && $results->corrected_year > 1))
                        <div class="form-group">
                            <div>
                                <span class="op-print-label print-label-text">Age:</span> 
                                {!! empty($results->chronological_year)  ? '<b>0 </b>Year(s)' : ' <b>'.$results->chronological_year .' </b>Year(s)';  !!}
                                {!! empty($results->chronological_month) ? '<b>0 </b>Month(s)' : ' <b>'.$results->chronological_month.' </b>Month(s)';  !!} 
                                <!-- {!! empty($results->chronological_days)  ? ' D <b> 0 </b>' : ' D <b>'.$results->chronological_days .' </b>';  !!}   
                                {!! empty($results->chronological_weeks) ? ' W <b> 0 </b>' : ' W <b>'.$results->chronological_weeks.' </b>';  !!} -->
                            </div>
                        </div>
                        @else
                            <div class="form-group">
                                <div>
                                    <span class="op-print-label print-label-text">Chronological Age:</span> 
                                    {!! empty($results->chronological_year)  ? ' <b>0 </b>Year(s)' : ' <b>'.$results->chronological_year .' </b>Year(s)';  !!}
                                    {!! empty($results->chronological_month) ? ' <b>0 </b>Month(s)' : ' <b>'.$results->chronological_month.' </b>Month(s)';  !!} 
                                    <!-- {!! empty($results->chronological_days)  ? ' D <b> 0 </b>' : ' D <b>'.$results->chronological_days .' </b>';  !!}   
                                    {!! empty($results->chronological_weeks) ? ' W <b> 0 </b>' : ' W <b>'.$results->chronological_weeks.' </b>';  !!} -->
                                </div>
                            </div>
                            <div class="form-group">
                                <div>
                                    <span class="op-print-label print-label-text">Corrected Age:</span> 
                                    {!! empty($results->corrected_year)  ? '<b>0 </b>Year(s)' : ' <b>'.$results->corrected_year .' </b>Year(s)';  !!}
                                    {!! empty($results->corrected_month) ? '<b>0 </b>Month(s)' : ' <b>'.$results->corrected_month .' </b>Month(s)';  !!} 
                                    <!-- {!! empty($results->corrected_days)  ? ' <b> D </b> 0' : ' <b> D </b> '.$results->corrected_days ;  !!}   
                                    {!! empty($results->corrected_weeks) ? ' <b> W </b> 0' : ' <b> W </b> '.$results->corrected_weeks;  !!} -->
                                </div>
                            </div>
                        @endif
                        <div class="form-group">
                            <div>
                                <span class="op-print-label print-label-text">Mother Blood Group:</span> 
                                <span class="print-label-value">{!! $results->mother_blood_group; !!}</span>
                            </div>
                        </div> 
                        <div class="form-group">
                            <div>
                                <span class="op-print-label print-label-text">Baby's Blood Group:</span> 
                                <span class="print-label-value">{!! $results->BabyBloodGroup; !!}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-11 col-sm-11">
            <div class="content-block">
                <div class="form-group">
                    <span class="print-label print-label-text">Background Details:</span> 
                    <span class="op-value print-label-value">{!! $results->baby_background; !!}</span>
                </div>                                                        
                <div class="form-group">
                    <span class="print-label print-label-text">Status:</span> 
                    <span class="op-value print-label-value">{!! $results->Complaints; !!}</span>
                </div>               
                <div class="form-group">
                    <span class="print-label print-label-text">Development:</span> 
                    <span class="op-value print-label-value">{!! $results->Development; !!}</span>
                </div>               
                <div class="form-group">
                    <span class="print-label print-label-text">Examination:</span> 
                    <span class="op-value print-label-value">{!! $results->Examination; !!}</span>
                </div>                  
                <div class="form-group">
                    <span class="print-label print-label-text">Impression:</span>
                    <span class="op-value print-label-value">{!! $results->Diagnosis; !!}</span>
                </div> 
                <div class="form-group">
                    <span class="print-label print-label-text">Advice:</span> 
                    <span class="op-value print-label-value">{!! $results->Advice; !!}</span>
                </div> 
                @if (!empty($results->investigations))
                <div class="form-group">
                    <span class="print-label print-label-text">Investigations:</span> 
                    <span class="op-value print-label-value">{!! $results->investigations; !!}</span>
                </div>        
                @endif         
                <div class="form-group">
                    <span class="print-label print-label-text">Echocardiogram Report:</span> 
                    <span class="op-value print-label-value">{!! ($results->echocardiogram_report != '') ? $results->echocardiogram_report : 'N/A'; !!}</span>
                </div> 
                <div class="form-group">
                    <span class="print-label print-label-text">Neurosonogram Report:</span>
                    <span class="op-value print-label-value">{!! ($results->neurosonogram_report != '') ? $results->neurosonogram_report : 'N/A'; !!}</span>
                </div>  
            </div> 
        </div>
        <div class="col-md-11 col-sm-11">
            <div class="content-block">
                <table class="form-group medicine table overflow-auto-screen">
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
                        @php 
                            $frequency_list = ValuelistHelpers::drugFrequencyList();
                            $formulation = ValuelistHelpers::formulationStrength();
                            $route = ValuelistHelpers::route();
                            $medications = collect($medications)->groupBy('Medication');
                        @endphp
                        @foreach($medications as $temp_key => $temp_medicine)   
                            @foreach($temp_medicine as $key => $medicine)   
                                <tr>
                                    @if ($key == 0)
                                    @php $drug = explode('/', $drug_data[$medicine->Medication]); @endphp
                                    <td class="whitespace-nowrap">{!! isset($drug[0]) ? $drug[0] : '' !!}</td>
                                    <td class="whitespace-nowrap">{!! isset($drug[1]) ? $drug[1] : '' !!}</td>
                                    <td class="whitespace-nowrap">{!! (isset($medicine->formulation) && isset($formulation[$medicine->formulation])) ? $formulation[$medicine->formulation] : '' !!}</td>
                                    <td class="whitespace-nowrap">{!! (isset($medicine->route) && isset($route[$medicine->route])) ? $route[$medicine->route] : '' !!}</td>
                                    @else
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    @endif
                                    <td class="whitespace-nowrap">{!! $medicine->Dose !!}</td>
                                    <td class="whitespace-nowrap">{!! isset($frequency_list[$medicine->Frequency]) ? $frequency_list[$medicine->Frequency] : '' !!}</td>
                                    <td class="whitespace-nowrap">{!! $medicine->Duration !!}</td>
                                </tr>  
                            @endforeach 
                        @endforeach 
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-11 col-sm-11 plr-must-0">
            <div class="col-md-12 col-sm-12">                   
                <div class="content-block">
                    <div class="col-md-12 col-sm-12 plr-must-0">
                        <div class="form-group">
                            <div><span class="print-label print-label-text">Immunization:</span> 
                                <span class="print-label-value">{!! $results->Immunization; !!}</span></div>
                        </div>              
                    </div>
                    @if(isset($results->Vaccine) && is_array($results->Vaccine) && count($results->Vaccine) > 0 && $results->Immunization == 'Given')
                        <div class="col-md-12 col-sm-12 plr-must-0">
                            <div class="form-group">
                                <span class="print-label print-label-text">Vaccine: </span>
                            </div>
                            <div class="form-group">
                                <div class="vaccine-margin print-label-value">
                                @php $count = 1;  @endphp
                                @php $vaccine_count = count($results->Vaccine); @endphp
                                @foreach($results->Vaccine as $vaccine_code)
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
                        </div>
                    @endif  

                    <div class="col-md-12 col-sm-12 plr-must-0">
                        <div class="form-group">
                            <div><span class="print-label print-label-text">Next Review:</span>
                            <span class="print-label-value">@if(date("Y",strtotime($results->Review)) > 1970) {!! date("d-m-Y",strtotime($results->Review)); !!} {!! $results->review_time.':'.$results->review_min.':'.$results->review_session  !!} @else {{ title_case('A Review Appoinment not been made.') }}  @endif</span>
                            </div>
                        </div>  
                    </div>
                    <div class="col-md-12 col-sm-12 plr-must-0">
                        <div class="form-group">
                            <div><span class="print-label print-label-text">Next Review Indication :</span></div>
                        </div>   
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                            <div class="print-label-value">{!! $results->nextreviewindication; !!}</div>
                        </div>   
                    </div>
                   
                </div> 
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 mt-15 plr-must-0">
                <div class="col-md-6 text pull-left plr-must-0">
                    <p class="col-md-12">Date : <b>{!! date("d-m-Y",strtotime($results->OpDate)); !!} </b></p>
                    <p class="col-md-12">Place: <b>{!! env('LOCATION')!!}</b></p>
                </div>
                <div class="col-md-6 text-center fontweight">
                    <div class="pull-right">
                    @if (!empty($results->SeenBy))
                        @php 
                            $seen_by = $results->SeenBy; 
                            $seen_by = (array)$seen_by;
                            $seen_by = json_encode($seen_by);
                            $seen_by = \ValuelistHelpers::signatureFormat($seen_by);
                        @endphp
                        {!! $seen_by !!}
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>      
@endsection
@section('scripts')

<script type="text/javascript">
$('.open-editor').click(function() {
    bootbox.confirm("If you edit this document, the changes will not be reflected in the main database and vice versa. Do you still want to continue?",function(confirmed){
        if(confirmed){
            var requestUrl = "{{ url('op-abbreviated/'.Request::segment(2)) }}";
            $.ajax({
                type: "GET",
                url: '{{ url("op-reports-editors") }}',
                data: {
                    dataUrl: requestUrl
                },
                cache: false,
                dataType: "json",
                success: function(responseText) {
                    window.location = requestUrl;
                },
                error: function(response) {}
            });
        }
    });
}); 
</script>
@endsection

