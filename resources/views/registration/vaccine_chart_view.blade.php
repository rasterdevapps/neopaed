@extends('app')
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
$header = ($top_spacing > 0 || $right_spacing > 0 || $bottom_spacing > 0 || $left_spacing > 0) ? true : false;
@endphp
@endif
<style type="text/css">
    .form-group span {
        font-weight: normal;
    }
    .print-head
    {
        margin-top: 0px;
        margin-bottom: 0px;
    }
    .print table td, .print table th {
        padding: 2px 0px !important;
    }
    .mt-10 {
        margin-top: 5px;
    }
    thead { 
        display: table-row-group 
    }
    table, th, td  {
        border-collapse: collapse;
    }
    thead {
        background-color: #d3d3d3
    }

    table {
        border-collapse: collapse;
        border-spacing: 0 !important;
    }

    th {
        border-bottom: 1px solid #e6e6e6;
        border-left: 1px solid #e6e6e6;
        font-size: 12px;
        font-weight: 700;
        text-align: center;
        padding: 12px 12px
    }

    th:last-child {
        border-right: 1px solid #e6e6e6   
    }

    thead>tr:first-child {
        border-top: 1px solid #e6e6e6
    }

    td {
        border-bottom: 1px solid #e6e6e6;
        border-top: 1px solid #e6e6e6;
        border-left: 1px solid #e6e6e6;
        font-size: 12px;
        font-weight: 400;
        padding: 8px 12px
    }
    h4
    {
        margin: 0px !important;
        font-size: 14px;
        white-space: nowrap;
    }
    .vaccine-container .col-md-12
    {
        padding: 0px !important;
    }
    body.print .content-block
    {
        margin-top: 5px !important;
    }
    p {
        margin: 0 0 3px !important;
    }
    body.print .content-block {
        page-break-after: auto !important;
        page-break-inside: auto !important;
    }
    #vaccine-chart-print-btn {
        margin: 2px;
    }
    @media print
    {
        .col-md-3
        {
            width: 25% !important;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #444 !important;
        }
        html, body {
            height: 99%;
        }
        table { page-break-after:auto  !important}
        tr    { page-break-inside:avoid !important; page-break-after:auto !important}
        td    { page-break-inside:avoid !important; page-break-after:auto !important; font-size: 10px !important;}
        th    { page-break-inside:avoid !important; page-break-after:auto !important; font-size: 10px !important;}
        td h4, td label
        {
            font-size: 10px !important;
        }
        /*thead { display:table-header-group !important}
        tfoot { display:table-footer-group !important}*/
        body.print .content-block.no-border-at-print
        {
            border: 0px !important;
        }
        @if(isset($top_spacing) && $top_spacing > 0)
        @page {
            margin-top: {{$top_spacing}}px;
        }
        @endif
        @if(isset($right_spacing) && $right_spacing > 0)
        @page {
            margin-right: {{$right_spacing}}px;
        }
        @endif
        @if(isset($bottom_spacing) && $bottom_spacing > 0)
        @page {
            margin-bottom: {{$bottom_spacing}}px;
        }
        @endif
        @if(isset($bottom_spacing) && $bottom_spacing > 0)
        @page {
            margin-left: {{$bottom_spacing}}px;
        }
        @endif
    }
</style>
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
        <li class="current"><a>Vaccine Chart</a></li>                                                 
    </ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="widget box">
                    <div class="widget-header">
                        <h4><i class="fa fa-reorder"></i> Vaccine Chart</h4>
                    </div>
                    <div class="widget-content row mx-0">
                        <div class="col-md-12 col-sm-12">
                            {!! Form::model(null, ['url' => action('Registration\OpController@saveVaccinePatientData'),'id'=>'vaccine-form']) !!}
                            <div class="col-md-12">
                                {!! Form::hidden('BabyId', $results->BabyId) !!}
                                {!! Form::hidden('flag') !!}
                                @include('registration.vaccine_chart')
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <button type="submit" class="btn btn-block save-button-shadow btn-info form-control" data-flag="1">
                                    <i class="fa fa-floppy-o"></i> 
                                    <span>Save</span>
                                </button>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <button type="submit" class="btn btn-block save-button-shadow btn-primary form-control" data-flag="2">
                                    <i class="fa fa-print"></i> 
                                    <span>Print</span>
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <a href="{{ action('HomeController@index') }}" class="btn btn-block save-button-shadow btn-default form-control" onclick="$('form')[0].reset();">
                                    <i class="fa fa-exclamation-circle"></i> 
                                    <span>Cancel</span>
                                </a>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>      
                </div>      
            </div>      
        </div>      
    </div>      
</div> 		
@endsection
@section('scripts')
<script type="text/javascript">    
    var vaccine_chart_link = $('#vaccine-chart-print-btn').attr('href');
    vaccine_chart_link = vaccine_chart_link + '?module=main';
    $('#vaccine-chart-print-btn').attr('href', vaccine_chart_link);
    $('button[type="submit"]').on('click', function(e) {
        e.preventDefault();
        var flag = $(this).attr('data-flag');
        $('input[name="flag"]').val(flag);
        $('#vaccine-form').submit();
    })
</script>
@endsection

