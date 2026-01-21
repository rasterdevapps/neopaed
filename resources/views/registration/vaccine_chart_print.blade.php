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
<div class="temp-container op-container">
	<div class="temp-row">
        <div class="@if(@$header) hidden-print @endif">
            <div class="col-md-6 col-xs-6">
                <img src="{{ ValuelistHelpers::printPagelogo($results->BMrNo) }}">
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6 plr-must-0 pull-right">
                {!! $headerContent['discharge_report_left'] !!}
            </div>
        </div>
		<!-- <div class="col-md-12 col-sm-12 col-xs-12">
			<h3 class="print-head">Vaccine Chart</h3>
            <span class="pull-right font-bold text-right">Date : {!! date("d-m-Y"); !!} </span>
        </div> -->
        <div class="col-md-12 col-sm-12" style="page-break-before: avoid;">
            <div class="content-block"> 
                <div class="col-md-12 col-sm-12 plr-must-0">
    				<div class="col-md-3 col-sm-3 col-xs-3 plr-must-0">
                        <div class="form-group">
                            <div>
                                <span class="op-print-label print-label-text">Name:</span> 
                                <span class="print-label-value">{!! $results->BabyName; !!}</span>
                            </div>
                        </div>
    				</div>
                    <div class="col-md-3 col-sm-3 col-xs-3 plr-must-0">
                         <div class="form-group">
                            <div>
                                <span class="op-print-label print-label-text">{{ Lang::get('home.mrn') }}:</span>
                                <span class="print-label-value">{!! $results->BMrNo; !!}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3 plr-must-0">
                        <div class="form-group">
                            <div>
                                <span class="op-print-label print-label-text">Sex:</span>
                                <span class="print-label-value">{!! $results->Sex; !!}</span>
                            </div>
                        </div> 
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3 plr-must-0">
                        <div class="form-group">
                            <div>
                                <span class="op-print-label print-label-text">DOB:</span> 
                                <span class="print-label-value">{!! empty($results->DOB) ? '' : date("d-m-Y",strtotime($results->DOB)); !!}</span>
                            </div>
                        </div>
                    </div>
                </div>
	  		</div>
        </div>
        <div class="col-md-12 col-sm-12">
            <div class="content-block no-border-at-print">
                @include('registration.vaccine_chart')  
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

