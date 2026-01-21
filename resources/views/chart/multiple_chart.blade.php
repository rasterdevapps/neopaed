@extends('app')
@section('content')
@php $i = 1; @endphp

<link href="{{ url('/') }}/public/css/nurse-chart.css" rel="stylesheet" type="text/css" />
<link href="{{ url('/') }}/public/plugins/amcharts/plugins/export/export.css" rel="stylesheet" type="text/css">
<link href="{{ url('/') }}/public/css/daterangepicker.css" rel="stylesheet" type="text/css" />

<script class="special-print-css" type="text/javascript" src="{{ url('/') }}/public/plugins/amcharts/amcharts.js"></script>
<script class="special-print-css" type="text/javascript" src="{{ url('/') }}/public/plugins/amcharts/serial.js"></script>
<script class="special-print-css" type="text/javascript" src="{{ url('/') }}/public/plugins/amcharts/amstock.js"></script>
<script class="special-print-css" type="text/javascript" src="{{ url('/') }}/public/plugins/amcharts/xy.js"></script>
<script class="special-print-css" type="text/javascript" src="{{ url('/') }}/public/plugins/amcharts/amexport_combined.js"></script>
<script class="special-print-css" type="text/javascript" src="{{ url('/') }}/public/plugins/amcharts/plugins/export/export.min.js"></script>
<script class="special-print-css" type="text/javascript" src="{{ url('/') }}/public/plugins/amcharts/themes/light.js"></script>
<script class="special-print-css" type="text/javascript" src="{{ url('/') }}/public/plugins/amcharts/plugins/export/libs/blob.js/blob.js"></script>
<script class="special-print-css" type="text/javascript" src="{{ url('/') }}/public/plugins/amcharts/plugins/export/libs/classList.js/classList.min.js"></script>
<script class="special-print-css" type="text/javascript" src="{{ url('/') }}/public/plugins/amcharts/plugins/export/libs/fabric.js/fabric.min.js"></script>
<script class="special-print-css" type="text/javascript" src="{{ url('/') }}/public/plugins/amcharts/plugins/export/libs/FileSaver.js/FileSaver.min.js"></script>
<script class="special-print-css" type="text/javascript" src="{{ url('/') }}/public/plugins/amcharts/plugins/export/libs/jszip/jszip.min.js"></script>
<script class="special-print-css" type="text/javascript" src="{{ url('/') }}/public/plugins/amcharts/plugins/export/libs/pdfmake/pdfmake.min.js"></script>
<script class="special-print-css" type="text/javascript" src="{{ url('/') }}/public/plugins/amcharts/plugins/export/libs/xlsx/xlsx.min.js"></script>
<script class="special-print-css" type="text/javascript" src="{{ url('/') }}/public/js/nurse-chart.js"></script>
<script class="special-print-css" type="text/javascript" src="{{ url('/') }}/public/js/nurse-dot-chart.js"></script>
<script class="special-print-css" type="text/javascript" src="{{ url('/') }}/public/js/moment.min.js"></script>
<script class="special-print-css" type="text/javascript" src="{{ url('/') }}/public/js/daterangepicker.min.js"></script>



<style type="text/css">
    fieldset {
        float: right;
    }

    fieldset>div {
        padding: 0px 10px;
    }

    .modal-body {
        padding-bottom: 15px !important;
    }

    #multichartdiv {        
        margin-top: 30px !important;
    }

    #multichartdiv div { 
        cursor: default !important;
    }

    .amcharts-stock-div {
        padding: 15px;
    }

    .amChartsLegend.amcharts-legend-div {
        background-color: black;
    }

    .amChartsLegend.amcharts-legend-div text {
        fill: white;
        transform: translate(10px, 10px);
    }

    #single-unit-observetion,
    #single-unit-vendilator {
        width: 100%;
        height: 600px;
    }

    .amcharts-chart-div>a {
        display: none !important;
    }

    .present-values {
        border: 1px solid;
        border-radius: 49%;
        padding: 0px 8px;
        margin: 0px 1px;
        background-color: #9cc580;
    }

    .previous-values {
        border: 1px solid;
        border-radius: 50%;
        padding: 1px 8px;
        margin: 0px 2px;
        background-color: #f99820;
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
        background-color: #e8230d;
    }

    .multiple-popup-create-container .modal-body>div {
        height: 600px;
        width: 100%;
    }

    .amcharts-stock-panel-div {    
        border-top: 2px solid transparent;
        box-shadow: 0 1px 2px rgb(77 77 77);
        border: 1px solid #e1e1e3;
        margin-top: 0px !important;
    }
    .amcharts-stock-panel-div:not(:last-child) .amcharts-chart-div > svg > g:nth-child(17) > g:last-child {
        display: none;
    }
    .amcharts-stock-panel-div:not(:last-child) .amcharts-balloon-div-categoryAxis {
        display: none;
    }
    .amcharts-period-selector-div {
        position: absolute;
        top: -27px;
        right: 15px;
    }
    .custom-filter-container {
        position: absolute;
        top: 5px;
        right: 25px;
    }
    .widget-header {
        position: relative;
    }
    #filter-btn {
        height: 32px;
    }
    .daterangepicker .ranges li:hover {
        color: black;
    }
    @media screen and (max-width: 1024px) {
        .custom-filter-container {
            top: 2px;
        }
        .widget-header .text-center {
            text-align: left;       
        }
    }
</style>
<div class="temp-container">
    <div class="temp-row">
        <div class="pull-right">
            @php
            $mrn = $baby_details->BMrNo;
            echo \SiteHelpers::menuList($mrn, $admission_id, 'multi_chart');
            @endphp
        </div>        
        <a href="{{$closewinlink}}" title="back" class="pull-right custom-close">
            <i class="fa fa-times fa-2x" aria-hidden="true"></i>
        </a>             
        <div class="col-md-12 px-0">
            <div class="widget box">
                <div class="widget-header">
                    <h3 class="text-center text-white mt-10"><strong>Baby's Details</strong></h3>
                </div>
                <div class="widget-content">
                    <div class="col-md-9 col-sm-12">
                        <div class="col-md-3 col-sm-6">
                            Baby Name : <b class="text-captialize">{{ $baby_details->BabyName }} </b>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            {{ Lang::get('home.mrn') }} : <b>{{ $baby_details->BMrNo }} </b>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            {{ Lang::get('home.ip') }} : <b>{{ $ip_number }} </b>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            Gestation : <b>{{ SiteHelpers::decode_gestation($baby_details->Gestation) }} </b>           
                        </div>

                        <div class="col-md-3 col-sm-6">
                            Gender : <b>{{ (isset($baby_details->Sex) && $baby_details->Sex != '') ? $baby_details->Sex : '' }} </b>
                        </div>

                        <div class="col-md-3 col-sm-6">
                            DOB : <b>{{ (isset($baby_details->DOB) && $baby_details->DOB != '') ? date('d-m-Y', strtotime($baby_details->DOB)) : '' }} </b>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="widget box mt-10 col-md-12 px-0">
    <div class="widget-header">
        <h3 class="text-center text-white mt-10">
            <strong>Baby's Observation Charts</strong>
        </h3>
        <div class="display-flex pull-right custom-filter-container">
            <div id="reportrange" class="form-control input-width-xlarge" style="padding: 6px;">
                <i class="fa fa-calendar"></i>&nbsp;
                <span></span> <i class="fa fa-caret-down"></i>
            </div>
        </div>
    </div>
    <div class="widget-content">
        <div id="multichartdiv"></div>
    </div>
</div>
<input type="hidden" class="baby_id" value="{{ $baby_details->BabyId }}">
<input type="hidden" class="admission_id" value="{{ $admission_id }}">
<input type="hidden" class="sheet_start_date" value="{{ $sheet_start_date }}">
<input type="hidden" class="sheet_end_date" value="{{ $sheet_end_date }}">
<input type="hidden" class="admission_start_date" value="{{ $header_start_date }}">
<input type="hidden" class="admission_end_date" value="{{ $header_end_date }}">
<input type="hidden" name="file_name" value="{{ $baby_details->BabyName }}-{{$baby_details->BMrNo}}">
<input type="hidden" name="monitor_interfacing_status" value="{{env('MONITOR_INTERFACE')}}">
<input type="hidden" name="ventilator_interfacing_status" value="{{env('VENTILATOR_MACHINE')}}">
<input type="hidden" name="color_code" value="{{ json_encode($color_code) }}">

<div class="modal fade chart-observation-modal flow-control-modal" id="chart-observation-model" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <h3 class="chart-fonts-style" id="chart-title">Observation Chart</h3>
                </h5>
                <button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true" style="color:white"><i class="fa fa-times"></i></button>
                <div class="pull-right chart-cursor-settings" style="margin-top: -6px;">
                    <select class="form-control filterValuesByDates" style="width: 90px; float: left; margin-right: 7px;">
                        <option value="" selected="selected">-- Select --</option>
                        <option value="0">1 Day</option>
                        <option value="1">2 Days</option>
                        <option value="7">1 Week</option>
                        <option value="30">1 Month</option>
                        <option value="all">All</option>
                    </select>
                    <span><input type="radio" value="on" name="pointer"> Pointer On</span>
                    <span><input type="radio" checked="true" value="off" name="pointer"> Pointer Off</span>
                </div>
                <div class="pull-right join-line-settings">
                    <span><input type="checkbox" value="on" name="line_join"> Line Join</span>
                    <span class="pl-15"><input type="checkbox" value="on" name="event"> Event</span>
                </div>
                <div class="pull-right join-line-settings hide">
                    <span class="vendilator-date-zoomed"></span>
                </div>
            </div>
            <div class="modal-body">
                <div id="single-unit-observetion">
                </div>
            </div>
            <div class="modal-footer bg-white">
            </div>
        </div>
    </div>
</div>
<div class="modal fade chart-vendilator-modal" id="chart-vendilator-model" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <h3 class="chart-fonts-style text-white" id="observe-name" style="margin-top: 10px; margin-bottom: 0px;">Observation Chart</h3>
                </h5>
                <button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true" style="color:white"><i class="fa fa-times"></i></button>
                <div class="pull-right chart-cursor-settings" style="margin-top: -10px;color: #fff;">
                    <select class="form-control filterValuesByDates" style="width: 90px; float: left; margin-right: 7px;">
                        <option value="" selected="selected">-- Select --</option>
                        <option value="0">1 Day</option>
                        <option value="1">2 Days</option>
                        <option value="7">1 Week</option>
                        <option value="30">1 Month</option>
                        <option value="all">All</option>
                    </select>
                    <span><input type="radio" value="on" name="line_pointer_vendilator"> Pointer On</span>
                    <span><input type="radio" checked="true" value="off" name="line_pointer_vendilator"> Pointer Off</span>
                </div>
                <div class="pull-right join-line-settings" style="margin-top: -6px;color: #fff;">
                    <span><input type="checkbox" value="on" name="line_join_vendilator"> Line Join</span>
                    <span class="pl-15"><input type="checkbox" value="on" name="event"> Event</span>
                </div>
                <div class="pull-right join-line-settings" style="margin-top: -6px;color: #fff;">
                    <span class="vendilator-date-zoomed"></span>
                </div>
            </div>
            <div class="modal-body">
                <div id="single-unit-vendilator">
                </div>
            </div>
            <div class="modal-footer bg-white">
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {

        var monitor_interfacing_status = $('input[name="monitor_interfacing_status"]').val();
        var ventilator_interfacing_status = $('input[name="ventilator_interfacing_status"]').val();

        var selected_start_date = $(".sheet_start_date").val();
        var selected_end_date = $(".sheet_end_date").val();
        var babyid = $(".baby_id").val();
        var admissionid = $(".admission_id").val();
        var first_insert = true;
        var chart_param = [];
        var label;
        var vital_label;
        var ventilator_label;
        updateChart(selected_start_date, selected_end_date, "multichartdiv");

        function updateChart(selected_start_date, selected_end_date, charttag) {
            $.ajax({
                type: "GET",
                url: "{{ url('multiple-list-chart') }}" + "/" + babyid + "/" + admissionid + "/" + selected_start_date + "/" + selected_end_date,
                beforeSend: function() {
                    $("#multichartdiv").html('<div id="loading"></div>');
                    $("#loading").html('<img src="{{url('public/img/icons/preloader.gif')}}" alt="Chart will Render Here..." />').css({
                        'height': $(window).height() - 252,
                        'display': 'flex',
                        'justify-content': 'center',
                        'align-items': 'center'
                    });
                },
                success: function(response) {
                    if (Object.values(response.chart_data).length > 1) {
                        var chartdate = response.chart_data.date;
                        var chartData = response.chart_data.param_value;
                        var parameter = response.chart_data.parameter;
                        var temp_vital_label = JSON.parse(response.vitals_label);
                        vital_label = JSON.parse(response.vitals_label);
                        ventilator_label = JSON.parse(response.ventilator_label);
                        label = Object.assign(temp_vital_label, ventilator_label);
                        chart_param = response.chart_param;
                        var i = 0;
                        var temp_chart_data = [];
                        $.each(chartData, function(key, value) {
                            var dateupdate = new Date(value.date).toString();
                            value.date = dateupdate.replace('-', '');
                            temp_chart_data.push(value);
                            i++;
                        });
                        var chart_height = parameter.length * 185;
                        $("#" + charttag).css({'height': chart_height,'display': 'block'});
                        generateChart(temp_chart_data, parameter, label, chartdate, charttag, '');
                    } else {
                        var height = $(window).height() - 97;
                        $("#" + charttag).html('No Data Found').css({
                            'display': 'flex',
                            'justify-content': 'center',
                            'align-items': 'center',
                            'height': height,
                            'font-weight': 'bold',
                            'margin-top': '0px',
                            'font-size': '20px'
                        });
                    }
                }
            });
        }

        var color = JSON.parse($('input[name="color_code"]').val());

        function lineGeneratePanels(panelindex, panelvalue, label, len) {
            var generatePanels = [];
            var panel = {};
            panel.showCategoryAxis = true;
            panel.precision = 2;
            panel.title = label[panelvalue];
            panel.percentHeight = 70;
            panel.stockGraphs = [{
                "id": "g" + panelindex,
                "valueField": panelvalue + "_lvalue",
                "type": "smoothedLine",
                "lineThickness": 0,
                "bullet": "round",
                "useDataSetColors": false,
                "lineColor": color[panelvalue],
                "lineAlpha": 1
            }];
            panel.stockLegend = {
                "valueTextRegular": " ",
                "markerType": "none"
            };
            generatePanels.push(panel);
            return generatePanels;
        }

        function boxToLineGeneratePanels(panelindex, panelvalue, label, len) {
            var generatePanels = [];
            var panel = {};
            panel.showCategoryAxis = true;
            panel.precision = 2;
            panel.title = label[panelvalue];
            panel.percentHeight = 70;
            panel.stockGraphs = [{
                "id": "g" + panelindex,
                "valueField": panelvalue + "_value",
                "type": "smoothedLine",
                "lineThickness": 0,
                "bullet": "round",
                "useDataSetColors": false,
                "lineColor": color[panelvalue],
                "lineAlpha": 1
            }];
            panel.stockLegend = {
                "valueTextRegular": " ",
                "markerType": "none"
            };
            generatePanels.push(panel);
            return generatePanels;
        }

        function lineFieldMapping(mapvalue) {
            var fieldMapping = [];
            var fieldmap = {};
            fieldmap.fromField = mapvalue + "_lvalue";
            fieldmap.toField = mapvalue + "_lvalue";
            fieldMapping.push(fieldmap);
            return fieldMapping;
        }

        function boxToLineFieldMapping(mapvalue) {
            var fieldMapping = [];
            var fieldmap = {};
            fieldmap.fromField = mapvalue + "_value";
            fieldmap.toField = mapvalue + "_value";
            fieldMapping.push(fieldmap);
            return fieldMapping;
        }

        function boxGeneratePanels(i, panelvalue, label, len) {
            var generatePanels = [];
            var panel = {};
            panel.showCategoryAxis = true;
            panel.precision = 2;
            panel.title = label[panelvalue];
            panel.percentHeight = 70;
            panel.stockGraphs = [basegraph(panelvalue, i), opengraph(panelvalue), lowgraph(panelvalue), midgraph(panelvalue)];
            panel.stockLegend = {
                "valueTextRegular": " ",
                "markerType": "none"
            };
            generatePanels.push(panel);
            return generatePanels;
        }

        function basegraph(panelvalue, i) {
            var boxgraph = {}
            boxgraph.id = "g" + i;
            boxgraph.type = "candlestick";
            boxgraph.highField = panelvalue + "_high";
            boxgraph.openField = panelvalue + "_open";
            boxgraph.closeField = panelvalue + "_close";
            boxgraph.valueField = panelvalue + "_close";
            boxgraph.lowField = panelvalue + "_low";
            boxgraph.balloonText = "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspMax: <b>[[high]]</b>\n Third Quartile: <b>[[close]]</b>\n &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspMedian: <b>[[value]]</b>\n First Quartile: <b>[[open]]</b>\n &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspMin: <b>[[low]]</b>";
            boxgraph.fillAlphas = 0;
            boxgraph.columnWidth = 0.15;
            boxgraph.useDataSetColors = false;
            boxgraph.lineColor = color[panelvalue];
            boxgraph.lineAlpha = 1;
            boxgraph.position = "start";
            return boxgraph;
        }

        function opengraph(panelvalue) {
            var boxgraph1 = {}
            boxgraph1.type = "column";
            boxgraph1.columnWidth = "0.1";
            boxgraph1.valueField = panelvalue + "_high";
            boxgraph1.openField = panelvalue + "_high";
            boxgraph1.lineThickness = 3;
            boxgraph1.showBalloon = false;
            boxgraph1.clustered = false;
            boxgraph1.useDataSetColors = false;
            boxgraph1.lineColor = color[panelvalue];
            boxgraph1.lineAlpha = 1;
            boxgraph1.position = "middle";
            return boxgraph1;
        }

        function lowgraph(panelvalue) {
            var boxgraph2 = {}
            boxgraph2.type = "column";
            boxgraph2.columnWidth = "0.1";
            boxgraph2.valueField = panelvalue + "_low";
            boxgraph2.openField = panelvalue + "_low";
            boxgraph2.lineThickness = 3;
            boxgraph2.showBalloon = false;
            boxgraph2.clustered = false;
            boxgraph2.useDataSetColors = false;
            boxgraph2.lineColor = color[panelvalue];
            boxgraph2.lineAlpha = 1;
            boxgraph2.position = "middle";
            return boxgraph2;
        }

        function midgraph(panelvalue) {
            var boxgraph3 = {}
            boxgraph3.type = "column";
            boxgraph3.columnWidth = "0.3";
            boxgraph3.valueField = panelvalue + "_volume";
            boxgraph3.openField = panelvalue + "_volume";
            boxgraph3.lineThickness = 3;
            boxgraph3.showBalloon = false;
            boxgraph3.clustered = false;
            boxgraph3.useDataSetColors = false;
            boxgraph3.lineColor = color[panelvalue];
            boxgraph3.lineAlpha = 1;
            boxgraph3.position = "start";
            return boxgraph3;
        }

        function boxFieldMapping(mapvalue) {
            var fieldMapping = [];
            var fieldmap = {};
            fieldmap.fromField = mapvalue + "_open";
            fieldmap.toField = mapvalue + "_open";
            fieldMapping.push(fieldmap);
            var fieldmap1 = {};
            fieldmap1.fromField = mapvalue + "_close";
            fieldmap1.toField = mapvalue + "_close";
            fieldMapping.push(fieldmap1);
            var fieldmap2 = {};
            fieldmap2.fromField = mapvalue + "_high";
            fieldmap2.toField = mapvalue + "_high";
            fieldMapping.push(fieldmap2);
            var fieldmap3 = {};
            fieldmap3.fromField = mapvalue + "_low";
            fieldmap3.toField = mapvalue + "_low";
            fieldMapping.push(fieldmap3);
            var fieldmap4 = {};
            fieldmap4.fromField = mapvalue + "_volume";
            fieldmap4.toField = mapvalue + "_volume";
            fieldMapping.push(fieldmap4);
            var fieldmap5 = {};
            fieldmap5.fromField = mapvalue + "_value";
            fieldmap5.toField = mapvalue + "_value";
            fieldMapping.push(fieldmap5);
            return fieldMapping;
        }

        function mapping(parameter) {
            var generateMap = [];
            var box, line = {};
            var param = Object.values(parameter);
            param.forEach(function(value, key) {
                charttype = value.split(":")[0];
                valparameter = value.split(":")[1];
                if (charttype == "box") {
                    if (monitor_interfacing_status) {
                        box = boxFieldMapping(valparameter);
                        box.forEach(function(paramvalue, paramkey) {
                            generateMap.push(paramvalue);
                        });
                    } else if (ventilator_interfacing_status) {
                        box = boxFieldMapping(valparameter);
                        box.forEach(function(paramvalue, paramkey) {
                            generateMap.push(paramvalue);
                        });
                    } else {
                        line = boxToLineFieldMapping(valparameter)[0];
                        generateMap.push(line);
                    }                
                } else {
                    line = lineFieldMapping(valparameter)[0];
                    generateMap.push(line);
                }
            });
            return generateMap;
        }

        function panels(parameter, label) {
            var generatePanel = [];
            var box, line = {};
            var param = Object.values(parameter);
            var len = parameter.length - 1;
            param.forEach(function(value, key) {
                charttype = value.split(":")[0];
                valparameter = value.split(":")[1];
                if (charttype == "box") {
                    if (monitor_interfacing_status) {
                        box = boxGeneratePanels(key, valparameter, label, len)[0];
                    } else if (ventilator_interfacing_status) {
                        box = boxGeneratePanels(key, valparameter, label, len)[0];
                    } else {
                        box = boxToLineGeneratePanels(key, valparameter, label, len)[0];
                    }
                    generatePanel.push(box);
                } else {
                    line = lineGeneratePanels(key, valparameter, label, len)[0];
                    generatePanel.push(line);
                }
            });
            return generatePanel;
        }

        function generateChart(chartData, parameter, label, chartdate, charttag, chartname = '') {
            scrollPosition = 'top';
            periodOptions = {
                "position": scrollPosition,
                "inputFieldsEnabled": false,
                "periods": [{
                    "period": "MAX",
                    "label": "MAX",
                }]
            };
            chart = AmCharts.makeChart(charttag, {
                "type": "stock",
                "theme": "light",
                "categoryAxesSettings": {
                    "minPeriod": "ff",
                    "gridAlpha": 0,
                    "equalSpacing": true,
                },
                "dataSets": [{
                    "fieldMappings": mapping(parameter),
                    "dataProvider": chartData,
                    "categoryField": "date",
                }],
                "panels": panels(parameter, label),
                "chartScrollbarSettings": {
                    "graph": "g1",
                    "usePeriod": "10mm",
                    "position": scrollPosition,
                    "backgroundAlpha":1,
                    "backgroundColor":"#84C4E2",
                    "selectedBackgroundColor":"#9AC380",
                    "selectedBackgroundAlpha":1
                },
                "valueAxesSettings": {
                    "inside": false,
                    "axisThickness": 50,
                    "labelOffset": -50,
                    "autoGridCount": true
                },
                "chartCursorSettings": {
                    "pan": true,
                    "valueBalloonsEnabled": true,
                },
                "periodSelector": periodOptions,
                "panelsSettings": {
                    "marginLeft": 30,
                    "marginRight": 15
                }
            });
            if (chartname != '') {
                first_insert = false;
            }
        }
        $(document).on("click", "#multichartdiv .amChartsPanel", function() {
            var chartname = $(this).find("svg > text > tspan").text();
            var parameters = [];
            parameters.push(chart_param[chartname]);
            if (vital_label.hasOwnProperty(chart_param[chartname]) && chart_param[chartname] != 'respiratory_rate') {
                getMVitalSingleUnit(parameters, 'single-view');
            } else if (ventilator_label.hasOwnProperty(chart_param[chartname])) {
                getMVentilatorSingleUnit(parameters, 'single-view');
            }
        });

        var temp_adm_start_date = $(".admission_start_date").val();
        var temp_adm_end_date = $(".admission_end_date").val();

        function getMVitalSingleUnit(parameters, viewType) {
            var flag = 3;
            var periods = 'All';
            var parameters = parameters;
            var startDate = '';
            var endDate = '';
            var dataFlag = 2;
            var parameter = parameters[0];
            $.ajax({
                type: 'GET',
                url: '{{ action("Nurse\NurseChartController@graphicaldata",[$baby_id, $admission_id])."?date=' + sheetdate[0] + '" }}',
                data: {
                    flag: flag,
                    periods: periods,
                    parameters: parameters,
                    startDate: startDate,
                    endDate: endDate,
                    eventstartDate: temp_adm_start_date,
                    eventendDate: temp_adm_end_date,
                    dataFlag: dataFlag,
                    viewType: viewType
                },
                beforeSend: function() {
                    $('#page-loader').fadeIn();
                    $('#vital-signs').html('<div class="loader"><i class="fa fa-spinner fa-pulse fa-5x fa-fw" aria-hidden="true"></i></div>');
                },
                success: function(data) {
                    $('.maximized-icon-vital').removeClass('maximized-icon-vital').removeClass('separate-view-container');
                    $('#maximized-icons-vitals').html('Observation Chart');
                    if (data.chart_type == 1) {
                        $('input[name="event"]').attr('checked', false);
                        $('input[name="line_join"]').attr('checked', false);
                        $('input[name="line_join"]').parent().removeClass('hide');
                        $('span:last-child input[value="off"]').prop('checked', true);
                        $('#chart-title').text(label[parameter]);
                        intiateLineChart(data.values, "single-unit-observetion", data.vitals_label[parameter], data.zoomPosition, selected_start_date, null, color[parameter], data.mid_value);
                    } else if (data.chart_type == 2) {
                        $('input[name="event"]').attr('checked', false);
                        $('input[name="line_join"]').attr('checked', false);
                        $('input[name="line_join"]').parent().addClass('hide');
                        $('span:last-child input[value="off"]').prop('checked', true);
                        $('#chart-title').text(label[parameter]);
                        if (monitor_interfacing_status) {
                            intiateBoxwhisker(data.values, "single-unit-observetion", data.vitals_label[parameter], data.zoomPosition, selected_start_date, color[parameter], data.mid_value);
                        } else {
                            intiateLineChart(data.values, "single-unit-observetion", data.vitals_label[parameter], data.zoomPosition, selected_start_date, null, color[parameter], data.mid_value, true);
                        }
                    }
                    $('#page-loader').fadeOut();
                    $('#chart-observation-model').modal({
                        backdrop: 'static',
                        show: true
                    });
                },
                error: function(data) {
                    Showalert('error', 'Data Missing Please Contact Admin !');
                    $('#page-loader').fadeOut();
                }
            });
        }

        function getMVentilatorSingleUnit(parameters, viewType) {
            var flag = 3;
            var periods = 'All';
            var parameters = parameters;
            var startDate = '';
            var endDate = '';
            var dataFlage = 2;
            var parameter = parameters[0];
            $.ajax({
                type: 'GET',
                url: '{{ action("Nurse\NurseChartController@vendilatorgraphicaldata",[$baby_id, $admission_id])."?date=' + sheetdate[0] + '" }}',
                data: {
                    flag: flag,
                    periods: periods,
                    parameters: parameters,
                    startDate: startDate,
                    endDate: endDate,
                    eventstartDate: temp_adm_start_date,
                    eventendDate: temp_adm_end_date,
                    viewType: viewType,
                    dataFlage: dataFlage
                },
                beforeSend: function() {
                    $('#page-loader').fadeIn();
                    $('#ventilator-settings').html('<div class="loader"><i class="fa fa-spinner fa-pulse fa-5x fa-fw" aria-hidden="true"></i></div>');
                },
                success: function(data) {
                     if (data.chart_type == 1) {
                        $('input[name="event"]').attr('checked', false);
                        $('input[name="line_join_vendilator"]').attr('checked', false);
                        $('span:last-child input[value="off"]').prop('checked', true);
                        $('input[name="line_join_vendilator"]').parent().removeClass('hide');
                        $('#observe-name').text(label[parameter]);
                        intiateLineChart(data.values, "single-unit-vendilator", data.ventilator_label[parameters], data.zoomPosition, selected_start_date, null, color[parameter], data.mid_value);
                    } else if (data.chart_type == 2) {
                        $('input[name="event"]').attr('checked', false);
                        $('input[name="line_join_vendilator"]').attr('checked', false);
                        $('span:last-child input[value="off"]').prop('checked', true);
                        $('input[name="line_join_vendilator"]').parent().addClass('hide');
                        $('#observe-name').text(label[parameter]);
                        if (ventilator_interfacing_status) {
                            intiateBoxwhisker(data.values, "single-unit-vendilator", data.ventilator_label[parameters], data.zoomPosition, selected_start_date, color[parameter], data.mid_value);
                        } else {                                    
                            intiateLineChart(data.values, "single-unit-vendilator", data.ventilator_label[parameters], data.zoomPosition, selected_start_date, null, color[parameter], data.mid_value, true);
                        }
                    }
                    $('#page-loader').fadeOut();
                    $('#chart-vendilator-model').modal({
                        backdrop: 'static',
                        show: true
                    });
                },
                error: function(data) {
                    $('#page-loader').fadeOut();
                    Showalert('error', 'Your messsage failed to sent !');
                }
            });
        }

        function getDateFormat(date) {
            date = new Date(date);
            var month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            var selected_month = month[date.getMonth()];
            var selected_date = ("0" + date.getDate()).slice(-2);
            var selected_year = date.getFullYear().toString().substr(-2);
            return selected_date + '-' + selected_month + '-' + selected_year;
        }
        
        var adm_start_date = $(".admission_start_date").val().split('-');
        var adm_end_date = $(".admission_end_date").val().split('-');
        
        var temp_admission_start_date = adm_start_date[0] +'-' + adm_start_date[1] +'-'+ adm_start_date[2];
        var temp_admission_end_date = adm_end_date[0] +'-' + adm_end_date[1] +'-'+ adm_end_date[2];

        var admission_start_date = moment(temp_admission_start_date, 'YYYY-MM-DD');
        var admission_end_date = moment(temp_admission_end_date, 'YYYY-MM-DD');

        var selected_start_date = $(".sheet_start_date").val().split('-');
        var selected_end_date = $(".sheet_end_date").val().split('-');

        var temp_start = selected_start_date[0] +'-' + selected_start_date[1] +'-'+ selected_start_date[2];
        var temp_end = selected_end_date[0] +'-' + selected_end_date[1] +'-'+ selected_end_date[2];

        var start = moment(temp_start, 'YYYY-MM-DD');
        var end = moment(temp_end, 'YYYY-MM-DD');

        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        $('#reportrange').daterangepicker({
            minDate: admission_start_date,
            maxDate: admission_end_date,
            ranges: {
             'Today': [moment(), moment()],
             'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
             'Last 7 Days': [moment().subtract(6, 'days'), moment()],
             'Last 30 Days': [moment().subtract(29, 'days'), moment()],
             'This Month': [moment().startOf('month'), moment().endOf('month')],
             'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
         }
     }, function(start, end, label) {
        updateChart(start.format('DD-MM-YYYY'), end.format('DD-MM-YYYY'), "multichartdiv");
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    });

        cb(start, end);

    });
</script>
@endsection
