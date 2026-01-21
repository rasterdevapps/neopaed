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
	@media print {
		html, body {
			height: 99%;
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
			<div class="col-md-12 col-xs-12">
				@if(isset($baby_detail->id))
				<img src="{{ ValuelistHelpers::printPagelogo($baby_detail->hospital_name) }}">
				@endif
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12 mt-15 plr-must-0">
				<div class="col-md-6 col-sm-6 op-pull-left">
                	{!! \ValuelistHelpers::headerContent(@$baby_detail->hospital_name, $headerContent) !!}
				</div>
				<div class="col-md-5 col-sm-6 op-pull-right">
					{!! $headerContent['discharge_report_right'] !!}
				</div>
			</div>
		</div>
		<br/>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<h3 class="print-head">OP Consultation Record</h3>
			<span class="pull-right font-bold text-right">Date : {!! date("d-m-Y",strtotime($baby_detail->op_date)); !!} </span>
		</div>
		@include('registration.pediatric.print_content')
		<div class="col-md-12 col-sm-12 col-xs-12 plr-must-0">
			<div class="col-md-6 text pull-left plr-must-0">
				<p class="col-md-12">Date : <b>{!! date("d-m-Y",strtotime($baby_detail->op_date)); !!} </b></p>
				<p class="col-md-12">Place: <b>{!! env('LOCATION')!!}</b></p>
			</div>
			<div class="col-md-6 text-center fontweight">
                    @if (!empty($baby_detail->seen_by))
                        @php 
                            $seen_by = $baby_detail->seen_by; 
                            $seen_by = (array)$seen_by;
                            $seen_by = json_encode($seen_by);
                            $seen_by = \ValuelistHelpers::signatureFormat($seen_by);
                        @endphp
                        {!! $seen_by !!}
                    @endif
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