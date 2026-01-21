@extends('print')
@section('content')
@php  $public_url =url('public').'/'; @endphp

@if (isset($editor_gen) && $editor_gen)
<div class="editor_style">
    @include('editor_print')  
</div>
@endif
<style type="text/css">
    .print table.full-width-must td {
        padding-left: 0px !important;
        padding-right: 0px !important;
        padding-top: 0px !important;
    }
</style>
<div class="temp-container daycare">
    <div class="temp-row">
        <div class="col-md-11">
            <div class="col-md-4 col-sm-4 col-xs-4 custom-padding-0">
                <img src="{{ SiteHelpers::getNicuLogo($nicu_id) }}">
            </div>
        </div>
        <div class="col-md-11">
            <div class="col-md-12 col-sm-12 col-xs-12 custom-padding-0">
                <h3 class="print-head">DAY CARE SHEET - REASSESSMENT </h3>
            </div>
        </div>
        {{ Form::hidden('DayId', $results->DayId) }}
        <div class="col-md-12">
            <div class="content-block">
                <h4>Basic Details</h4>
                <div class="section-set">
                    <div  class="col-md-12">
                        <table class="full-width-must">
                            <tbody>
                                <tr>
                                    <td>
                                        <span><strong>{{ Lang::get('home.mrn') }}:</strong></span>
                                        <span> {!! $results->BMrNo; !!}</span>
                                    </td>
                                    <td colspan="2">
                                        <span><strong>Name:</strong></span>
                                        <span>{!! $results->BabyName; !!}</span>                 
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span><strong>DOB:</strong></span>
                                        <span>{!! date("d-m-Y",strtotime($results->DOB)) !!}</span> 
                                    </td>
                                    <td>
                                        <span><strong>Gestation:</strong></span>
                                        <span>{!! $results->Gestation; !!}</span>
                                    </td>
                                    <td>          
                                        <span><strong>CGA:</strong></span>
                                        <span>{!! $results->CGA; !!}</span> 
                                    </td>
                                </tr>
                                <tr>
                                    <td>              
                                        <span><strong>Day of life:</strong></span>
                                        <span> {!! $results->DayOfLife; !!}</span>       
                                    </td>
                                    <td>       
                                        <span><strong>Sex:</strong></span>
                                        <span> {!! $results->Sex; !!}</span>        
                                    </td>
                                    <td>                
                                        <span><strong>Care:</strong></span>
                                        <span>{!! $results->Care !!} </span> 
                                    </td>
                                </tr>
                                <tr>
                                    <td>                
                                        <span><strong>Mother BG:</strong></span>
                                        <span>  {!! $Mother_details->MotherBloodGroup !!}</span>          
                                    </td>
                                    <td>                
                                        <span><strong>Baby's BG:</strong></span>
                                        <span>{!! $results->BabyBloodGroup; !!}</span> 
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span><strong>Background:</strong></span>                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="pl-15">{!! $results->Background; !!}</span>                                        
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="page-break"></div>
            @if(isset($reassessment_result) && !empty($reassessment_result))
            @foreach($reassessment_result as $res_key => $res_val)
            <div class="content-block">
                <h4>Reassessment Details</h4>
                <div class="section-set row mx-0">
                    <div  class="col-md-12">
                        <table class="full-width-must">
                            <tbody>
                                <tr>
                                    <td>
                                        <span><strong>Reassessment Date:</strong></span>
                                        @if($res_val->reassessment_date != '')
                                        <span>{!! date("d-m-Y",strtotime($res_val->reassessment_date)); !!}</span>
                                        @else
                                        <span> - </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span><strong>Reassessment Time:</strong></span>
                                        <span> {!!$res_val->reassessment_time; !!}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span><strong>Ventilator Support:</strong></span>
                                        <span> {!! $res_val->reassessment_ventilater !!}</span>
                                    </td>
                                    <td>
                                        <span><strong>CPAP / HHHFNC:</strong></span>
                                        <span> {!! $res_val->reassessment_cpap !!}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span><strong>NC:</strong></span>
                                        <span> {!! $res_val->reassessment_nc !!}</span>
                                    </td>
                                    <td>
                                        <span><strong>Room Air:</strong></span>
                                        <span> {!! $res_val->reassesment_room_air !!}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span><strong>Systolic BP:</strong></span>
                                        <span> {!! $res_val->reassessment_systalic_bp !!}</span>
                                    </td>
                                    <td>
                                        <span><strong>SPO<sub>2</sub>:</strong></span>
                                        <span> {!! $res_val->reassessment_spo2 !!}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span><strong>Diastolic BP:</strong></span>
                                        <span> {!! $res_val->reassessment_diastolic_bp !!}</span>
                                    </td>
                                    <td>
                                        <span><strong>RR:</strong></span>
                                        <span> {!! $res_val->reassessment_rr !!}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span><strong>Mean BP:</strong></span>
                                        <span> {!! $res_val->reassessment_bp !!}</span>
                                    </td>
                                    <td>
                                        <span><strong>HR:</strong></span>
                                        <span> {!! $res_val->reassessment_hr !!}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span><strong>RS:</strong></span>                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="pl-15"> {!! $res_val->reassemant_rs !!}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span><strong>CVS:</strong></span>                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="pl-15"> {!! $res_val->reassemant_cvs !!}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span><strong>GI:</strong></span>                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="pl-15"> {!! $res_val->reassemant_gi !!}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span><strong>CNS:</strong></span>                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="pl-15"> {!! $res_val->reassemant_cns !!}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="content-block">
                <h4>Additional Information:</h4>
                <div class="section-set row mx-0">
                    <div class="col-xs-12 col-sm-12 col-md-12 mb-50">
                        <div class="form-group mtb-must-0">
                            <span class="print-value full-width-must">{!! $res_val->additional_assessment; !!}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-block">
                <h4>Seen By:</h4>
                <div class="section-set row mx-0">
                    <div class="col-xs-12 col-sm-12 col-md-12 mb-50">
                        <div class="form-group mtb-must-0 custom-seen-by">
                            @php
                            $seen_by = \ValuelistHelpers::signatureFormat($res_val->reassessment_seen_by);
                            @endphp
                            {!! $seen_by !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif

        <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0">
            <div class="col-xs-3 col-sm-3 col-md-3 mt-15 plr-sm-0">
                <p class=" col-md-11 plr-must-0">Date : <b>{!! date("d-m-Y",strtotime($results->DayDate)); !!}</b></p>
                <p class=" col-md-11 plr-must-0"> Place: <b>{{ env('LOCATION') }} </b></p>
            </div>
            <div class="col-xs-9 col-sm-9 col-md-9 pull-right text-center mt-15 pr-sm-0">
                {!! $results->rawdr !!}
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
            if(confirmed){    var day_id = $('input[name="DayId"]').val();
            var requestUrl = "{{ url('nicu-daycare-abbreviated/'.Request::segment(2)) }}";
            $.ajax({
                type: "GET",
                url: '{{ url("nicu-daycare-reports-editors") }}',
                data: {
                    dataUrl: requestUrl,
                    day_id: day_id
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
