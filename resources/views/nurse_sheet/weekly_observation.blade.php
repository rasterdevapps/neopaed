@extends('print')
@section('content')
<style type="text/css">
	.note-box {
		font-size: 12px;
		padding: 3px;
	}
	.print-value
	{
		margin-bottom: 10px !important;
	}
	.print table td, .print table th {
	    padding: 5px 4px !important;
	    white-space: nowrap;
	}
	.list-table td
	{
		padding: 5px 10px !important;
	}
	.current_date
	{
		background-color: #d7d043 !important;
	}
	table tr th:first-child {
	    position: sticky;
	    left: -16px;
    	background: white;
	}
	@media print
	{
		.weekly-observation-table tr th
		{
			background-color: #fff !important;
			color: #000 !important;
			font-weight: normal !important;
		}
	}
</style>
@php
	$site_url = url('/').'/public';
@endphp
<link href="{{ $site_url }}/css/plugins.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{ $site_url }}/js/libs/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="{{ $site_url }}/js/libs/jquery-ui.min.js" ></script>
<div class="temp-container nurse-sheet sheet-auto">
	<div class="temp-row">
		<!-- <div class="col-md-12 mt-30-print"></div> -->
		<div class="col-md-12 col-sm-12">
			<div class="col-md-12 plr-must-0">
				<div class="col-md-4 col-sm-4 plr-must-0">
					<img src="{{ ValuelistHelpers::printPagelogo($hospital_name) }}" style="width: auto !important; height: auto !important;">
				</div>
				<div class="col-md-4 col-sm-4 text-center">
					<h3>Weekly Observations</h3>
				</div>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-12 content-center hide pull-right">
				<table>
					<tr>
						@if(isset($ip_details->ip_number))
						<td colspan="2">{{ 'IP'.$ip_details->ip_number }}</td>
						@else
						<td></td>
						@endif
					</tr>	
					<tr>
						<td><p class="vericaltext">SKS</p></td>
						<td>
							@if(!empty($ip_details->ip_number) && !is_null($ip_details->ip_number))
							{!! '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($ip_details->ip_number, "C128",3,33,array(1,1,1), true) . '" alt="barcode"   />' !!}
							@else
							{!! '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG('123456789', "C128",3,33,array(1,1,1), true) . '" alt="barcode"   />' !!}
							@endif
						</td>
					</tr>
					<tr>
						<td colspan="2">{{ $baby->BMrNo }}</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="col-md-12 col-sm-12 basic-detail">
			<div class="content-block">
				<div class="section-set">
					<div class="col-xs-12 col-sm-4 col-md-4">
						<div class="form-group">
							<span class="print-label">{{ Lang::get('home.mrn') }}:</span>
							<span class="print-value">{{ $baby->BMrNo }}</span>
						</div>         	
						<div class="form-group">
							<span class="print-label">{{ Lang::get('home.ip') }}:</span>
							<span class="print-value">{{ (!empty($ip_details->ip_number) && !is_null($ip_details->ip_number)) ? $ip_details->ip_number : null }}</span>
						</div>         	
						<div class="form-group">
							<span class="print-label">Birth Weight:</span>
							<span class="print-value">{{ $baby->BirthWeight }}</span>
						</div>
						<div class="form-group">
							<span class="print-label">Date of admission:</span>
							<span class="print-value">{{ date('d-m-Y', strtotime($admission_date)) }}</span>
						</div>
					</div>
				</div>

				<div class="section-set">
					<div class="col-xs-12 col-sm-4 col-md-4">
						<div class="form-group">
							<span class="print-label">Name:</span>
							<span class="print-value text-captialize">{{ $baby->BabyName }}</span>
						</div>
						<div class="form-group">
							<span class="print-label">Gestation:</span>
							<span class="print-value">{{ SiteHelpers::decode_gestation($baby->Gestation) }}</span>
						</div>
					</div>
				</div> 
				<div class="section-set">
					<div class="col-xs-12 col-sm-4 col-md-4">
						<div class="form-group">
							<span class="print-label">Sex:</span>
							<span class="print-value">{{ $baby->Sex }}</span>
						</div>
						<div class="form-group">
							<span class="print-label">Corrected Gestational Age:</span>
							<span class="print-value">{{ ($corrected_gestation != 0) ? $corrected_gestation : '' }}</span>
						</div>
						<div class="form-group">
							<span class="print-label">Working Weight:</span>
							<span class="print-value">{{$working_weight}}</span>
						</div>
					</div> 	
				</div>	
			</div>	 
		</div>
		<div class="row hidden-print">
			<div class="col-md-12 col-sm-12 col-xs-12 mb-10 date-filter date-selection">
				<div class="pl-15 pull-right mt-20">
					<button type="button" class="btn btn-theme-primary filter_weekly_observations" style="margin-right: 10px;"><i class="fa fa-filter"></i></button>
				</div>
				<div class="pl-15 pull-right mt-20">
					<div class="pull-left mt-5 pr-5"><label for="todate">To Date :</label></div>
					<div class="pull-left plr-0"><input class="form-control daycare-date input-fields-shadow" name="todate" type="text" id="to_date" readonly="true" value="{{ date('d-m-Y', strtotime($end_date)) }}"></div>
				</div>
				<div class="pl-15 pull-right mt-20">
					<div class="pull-left mt-5 pr-5"><label for="fromdate">From Date :</label></div>
					<div class="pull-left plr-0"><input class="form-control daycare-date input-fields-shadow" name="fromdate" type="text" id="from_date" readonly="true" value="{{ date('d-m-Y', strtotime($week_start_date)) }}"></div>
				</div>
			</div>
		</div>
		<?php 

			
		 ?>
		<div class="row">
			<div class="col-md-12 mt-20 overflow-auto">
				<table class="table table-striped table-bordered list-table weekly-observation-table">
					{!! $table_content !!}
				</table>
			</div>
		</div>
<script type="text/javascript">
$(document).ready(function(){
	$("#from_date").datepicker({
		showMonthAfterYear: true,
		dateFormat: 'dd-mm-yy',
		onSelect: function(selected) {
			$("#to_date").datepicker("option", "minDate", selected);
		}
	});
	$("#to_date").datepicker({
		dateFormat: 'dd-mm-yy',
		showMonthAfterYear: true,
		onSelect: function(selected) { 
			$("#from_date").datepicker("option", "maxDate", selected);	
		}
	});
	$('.filter_weekly_observations').click(function()
	{
		var start_date = $("#from_date").val();
		if (!start_date || start_date == null || start_date == '') {
			Showalert('error', 'Enter From date');
			return false;
		}

		var to_date = $("#to_date").val();
		if (!to_date || to_date == null || to_date == '') {
			Showalert('error', 'Enter To date');
			return false;
		}
		$.ajax({
			url: '{{ url("nicu-nurse-sheets/get-weekly-observations/")."/".\SiteHelpers::encrypt_id($admission_id)."/".$admission_date }}',
			data:{
				fromdate: start_date,
				todate: to_date,
			},
			type: "GET",
			success:function(response)
			{
				$('.weekly-observation-table').html(response.table_content);
				upodateCurrentDate();
			},
			error:function()
			{
				Showalert('error', 'Something went wrong...!');
			}

		});
	});
});
upodateCurrentDate();
function upodateCurrentDate()
{
	var current_date_index = $('.weekly-observation-table tbody').children('tr:first').find('.current_date').index();
	$('.weekly-observation-table tbody tr').each(function()
	{
		$(this).children('td').eq(current_date_index - 1).addClass('current_date');
	});
}
</script>
@endsection
@section('scripts')
@endsection
