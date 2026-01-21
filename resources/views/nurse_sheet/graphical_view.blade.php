@extends('app')
@section('content')
@php
$current_date = $selected_date;
@endphp
<link href="{{ url('/') }}/public/css/nurse-chart.css" rel="stylesheet" type="text/css" />
<link href="{{ url('/') }}/public/plugins/amcharts/plugins/export/export.css" rel="stylesheet" type="text/css">
<script class="special-print-css" type="text/javascript" src="{{ url('/') }}/public/plugins/amcharts/amcharts.js"></script>
<script class="special-print-css" type="text/javascript" src="{{ url('/') }}/public/plugins/amcharts/serial.js"></script>
<script class="special-print-css" type="text/javascript" src="{{ url('/') }}/public/plugins/amcharts/amstock.js"></script>
<script class="special-print-css" type="text/javascript" src="{{ url('/') }}/public/plugins/amcharts/xy.js"></script>
<script class="special-print-css" type="text/javascript" src="{{ url('/') }}/public/plugins/amcharts/themes/light.js"></script>
<script class="special-print-css" type="text/javascript" src="{{ url('/') }}/public/js/nurse-chart.js"></script>
<script class="special-print-css" type="text/javascript" src="{{ url('/') }}/public/js/nurse-dot-chart.js"></script>
<script class="special-print-css" type="text/javascript" src="{{ url('/') }}/public/plugins/amcharts/plugins/export/export.min.js"></script>

<style type="text/css">
    #single-unit-observetion, #single-unit-vendilator{
        width: 100%;
        height: 600px;
    }
    .amcharts-chart-div > a {
        display: none !important;
    }
    .present-values {
        border: 1px solid;
        border-radius: 49%;
        padding: 0px 8px;
        margin: 0px 1px;
        background-color:#9cc580;
    }
    .previous-values {
        border: 1px solid;
        border-radius: 50%;
        padding: 1px 8px;
        margin: 0px 2px;
        background-color:#f99820;
    }
    .color-define {
        list-style: none;
        display: flex;
    }
    .past-values {
        border: 1px solid;
        border-radius: 50%;
        padding: 1px 8px;
        margin: 0px 2px;
        background-color:#e8230d;
    }
    .multiple-popup-create-container .modal-body > div
    {
        height: 600px;
        width: 100%;
    }
</style>
<div class="temp-container">
    <div class="temp-row nurse-chart-sheet">
        <div class="pull-right">
            @php
            $mrn = $baby_details->BMrNo;
            echo \SiteHelpers::menuList($mrn, $admission_id, 'single_chart');
            @endphp
        </div>     
        <input type="hidden" name="color_code" value="{{ json_encode($color_code) }}">
        <a href="{{$closewinlink}}" title="back" class="pull-right custom-close">
            <i class="fa fa-times fa-2x" aria-hidden="true"></i>
        </a>     
        <div class="col-md-12 plr-0">
            <div class="widget box pb-0">
                <div class="widget-header">
                    <h5 class="text-white">
                        <i class="fa fa-reorder"></i> Baby Info
                    </h5>
                </div>
                <!-- <div class="col-md-3">
                    <img src="{{ ValuelistHelpers::printPagelogo() }}">
                </div> -->
                <div class="widegt-content row mx-0">
                    <div class="col-md-4 col-sm-4">
                        <div class="baby-info">
                            <b>Baby Name : {{ $baby_details->BabyName }} </b>
                        </div>
                        <div class="baby-info">
                            <b>DOB : {{ !is_null($baby_details->DOB) ?  date('d-m-Y', strtotime($baby_details->DOB)) : '' }} </b>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <div class="baby-info">
                            <b>{{ Lang::get('home.mrn') }} : {{ $baby_details->BMrNo }} </b>
                        </div>
                        <div class="baby-info">
                            <b>Gestation : {{ SiteHelpers::decode_gestation($baby_details->Gestation) }} </b>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <div class="baby-info">
                            <b>{{ Lang::get('home.ip') }} : {{ $ip_number }} </b>
                        </div>
                        <div class="baby-info">
                            <b>Birth Weight : {{ $baby_details->BirthWeight }} </b>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="file_name" value="{{ $baby_details->BabyName }}-{{$baby_details->BMrNo}}">
        <div class="col-md-12 plr-0 mt-10">
            <div class="widget box">
                <div class="widget-header">
                    <h3 class="text-center text-white">{{ title_case("Nurse Observation Chart") }} </h3>
                </div>
                <div class="widegt-content row mx-0">
                    <div class="col-md-12 chart-fonts-style">
                        <h4 class="d-inline-block">Vital Signs</h4>
                        <div class="pull-right" style="margin-top:10px;">
                            <input type="hidden" name="data_start_date" value="{{collect($date_options)->first()}}">
                            <input type="hidden" name="data_end_date" value="{{collect($date_options)->last()}}">

                            <input type="hidden" name="monitor_interfacing_status" value="{{env('MONITOR_INTERFACE')}}">

                            <select id="nurse-chart-date-filter" class="form-control">
                                @if(count($date_options) > 0)
                                @foreach($date_options as $option_key => $option_val)
                                @if($option_key == $selected_date)
                                <option value="{{ $option_key }}" selected>{{ $option_val }}</option>
                                @else
                                <option value="{{ $option_key }}">{{ $option_val }}</option>
                                @endif
                                @endforeach
                                @else
                                <option value="" selected="selected" disabled="disabled">No data found...</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        @include('nurse_sheet.vitals')
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-2 chart-fonts-style">
                        <h4>Ventilator </h4>
                    </div>
                    <div class="col-md-3 pull-right">
                        <form action="{{url('/nicu-nurse-sheet-graph/').'/'.$encrypt_baby_id.'/'.$admission_id}}?date={{ $selected_date }}" id="vendilation_mode">
                            Mode: {!! Form::select('vendilation_mode',[''=>'N/A']+$vendilationModelist,$vendilationMode,['class'=>'form-control']) !!}
                            <input type="hidden" name="date" value="{{ $current_date }}">
                        </form>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-12">
                            <input type="hidden" name="ventilator_interfacing_status" value="{{env('VENTILATOR_MACHINE')}}">
                        @include('nurse_sheet.ventilator')
                    </div>
                </div>
            </div>
        </div>
        <!-- 
            <div class="col-md-12">
            </div> -->
            <div class="col-md-12">
                <div class="col-md-5">
                <!-- <div class="form-group">
                    <ul class="color-define">
                    	<li><span class="present-values"></span> &nbsp; Active Observation &nbsp;</li>
                    	<li><span class="previous-values"></span> &nbsp; Past Observation  &nbsp;</li>
                    	<li><span class="past-values"></span> &nbsp; Off Advanced Respiratory Support  &nbsp;</li>
                    
                    </ul>
                </div> -->
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    $('select[name="vendilation_mode"]').change(function () {
        $('#vendilation_mode').submit();

    });
    $('#nurse-chart-date-filter').change(function () {
        window.location.href = "{{ action('Nurse\NurseChartController@graphicalview',[\SiteHelpers::encrypt_id($baby_details->BabyId), $admission_id]) }}?date=" + $(this).val()+'&closewinlink={{ $redirect_option }}';
    });
    // $(document).ready(function () {
    //     setInterval(function () {
    //         $('tspan[y="5"]').each(function () {
    //             if ($(this).text().indexOf('.') > 0) {
    //                 $(this).text(parseFloat($(this).text()).toFixed(2))
    //             }
    //         });

    //         $("text[fill='#85c5e3']").each(function () {
    //             $(this).text('');
    //         });
    //         $("text[y='5']").each(function () {
    //             if ($(this).text().length > 6) {

    //                 var date = $(this).text().split(' ');
    //                 if (date[2] == '23:00' || date[2] == '00:00') {
    //                     $(this).text($(this).text());
    //                 } else {
    //                     $(this).text(date[2]);
    //                 }
    //             }
    //         });

    //         $("text[y='6']").each(function () {
    //             if ($(this).text().trim() != 'Peripheral Temp (T2)' && $(this).text().trim() != 'Heart Rate' &&
    //                 $(this).text().trim() != 'Cuff Systolic BP' && $(this).text().trim() != 'Cuff Diastolic BP' &&
    //                 $(this).text().trim() != 'Cuff Mean BP' && $(this).text().trim() != 'Cuff Mean BP' &&
    //                 $(this).text().trim() != 'Targeted Tidal Volume' && $(this).text().trim() != 'Delivered Tidal Volume' &&
    //                 $(this).text().trim() != 'ΔP/Amplitude' && $(this).text().trim() != 'PIP (set)' &&
    //                 $(this).text().trim() != 'PIP (delivered)' && $(this).text().trim() != 'PEEP' &&
    //                 $(this).text().trim() != 'MAP' && $(this).text().trim() != 'FiO2 %' &&
    //                 $(this).text().trim() != 'FLOW' && $(this).text().trim() != 'RATE/V (Set Ventilator Rate)' &&
    //                 $(this).text().trim() != 'IT(S)' && $(this).text().trim() != "Baby's RR(measured)" &&
    //                 $(this).text().trim() != 'ET Leak (%)' && $(this).text().trim() != 'Measured IT (s)' &&
    //                 $(this).text().trim() != 'DCO2' && $(this).text().trim() != 'c20/c' && $(this).text().trim() != 'Frequency (H2)' &&
    //                 $(this).text().trim() != 'Arterial Diastolic BP' && $(this).text().trim() != 'Arterial Mean BP' && $(this).text().trim() != 'Arterial Systolic BP' &&
    //                 $(this).text().trim() != 'Perfusion Index (%)' && $(this).text().trim() != 'Oxygen Saturation Index' &&
    //                 $(this).text().trim() != 'T1 - T2' && $(this).text().trim() != 'Baby\'s RR' &&
    //                 $(this).text().trim() != 'Fresh gas flow' && $(this).text().trim() != 'Oxygen Status' &&
    //                 $(this).text().trim() != 'Oxygen set' && $(this).text().trim() != 'Oxygen delivery') {
    //                 var date = $(this).text().split(' ');
    //                 if (date[1] == '23:00' || date[1] == '00:00') {
    //                     $(this).text($(this).text());
    //                 } else {
    //                     if (date[1] != '-') {
    //                         $(this).text(date[1]);
    //                     }
    //                 }
    //             }
    //         });

    //         $('tspan[y="5"]').each(function () {
    //             var decimal = $(this).text();
    //             if (decimal.indexOf('-') == 0) {
    //                 var decimal = parseFloat(decimal);
    //                 $(this).text(decimal.toFixed(2))
    //             } else {
    //                 var decimal = $(this).text().split(' ');
    //                 if (decimal[1] == '23:00' || decimal[1] == '00:00') {
    //                     $(this).text($(this).text());
    //                 } else {
    //                     if (decimal[1] != '-') {
    //                         $(this).text(decimal[1]);
    //                     }
    //                 }
    //             }

    //         });

    //     }, 1000);


    // });

    setInterval(function () {
        $('a[href="http://www.amcharts.com/javascript-charts/"]').addClass('hide');
    }, 10)
    

</script>
@endsection
