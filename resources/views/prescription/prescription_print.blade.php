@php
$site_url = url('/').'/public';
@endphp
@extends('print')
@section('content')
<div class="col-md-12 col-sm-12 col-xs-12 change-order">
    {!! Form::label('inter-change','Change A3 Printer:') !!}
    <input name="inter-change" id="inter-change" data-size="small" data-off="No" data-on="Yes" data-width="100" data-toggle="toggle" class="form-control switch-input" type="checkbox">
</div>
<div class="col-md-12 col-sm-12 col-xs-12 mb-20 date-filter date-selection plr-must-0">
	<div class="mtb-20">
		<div class="pl-15 pull-right">
			<div class="pull-left mt-5 pr-5">{!! Form::label('todate', 'To Date :') !!}</div>
			<div class="pull-left plr-0">{!! Form::text('todate', null, ['class'=>'form-control input-fields-shadow', 'readonly']) !!}</div>
		</div>
		<div class="pl-15 pull-right">
			<div class="pull-left mt-5 pr-5">{!! Form::label('fromdate', 'From Date :') !!}</div>
			<div class="pull-left plr-0">{!! Form::text('fromdate', null, ['class'=>'form-control input-fields-shadow', 'readonly']) !!}</div>
		</div>
	</div>
</div>
<div class="temp-container" id="prescription-page">
	<div class="prescription-loader"></div>
	@include('prescription.prescription_print_interchange')
	<div class="temp-row">
		<div class="col-md-12 col-sm-12 col-xs-12 mb-5 plr-must-0">
			<div class="col-md-4 col-sm-4 col-xs-4 ">
				<img src="{{ ValuelistHelpers::printPagelogo($hospital_name) }}" class="header-logo-spacing">
			</div>
			<div class="col-md-4 col-sm-4 col-xs-4 text-center">
				<h4 class="m-0"><b>Form No. 4</b></h4>
				<h3 class="m-0 fs-20">MEDICATION CHART</h3>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-4 plr-must-0 barcode text-center mr-15">
				@if(!empty($ip_details->ip_number) && !is_null($ip_details->ip_number))
				<table class="">
					<tr>
						<td class="p-must-0"></td>
						<td class="custom-padding">
							<div class="col-md-6 plr-must-0">
								<b class="pull-left fs-16">{{$ip_details->ip_number}}</b>
							</div>
							<div class="col-md-6 plr-must-0">
								<span class="baby-mrn">{{ $baby->BMrNo }}</span>
							</div>
						</td>
					</tr>
					<tr>
						<td><b class="hosptial-name">SKSH</b></td>
						<td>
							<span class="barcode-content">
								@php $ipnumber = str_replace('IP/', '01', $ip_details->ip_number); @endphp
								<img src="data:image/png;base64,{{DNS1D::getBarcodePNG($ipnumber, 'C128', 2, 38)}}" alt="barcode" />
							</span>
						</td>
					</tr>
					<tr>
						<td></td>
						<td class="ptb-must-0">{{ str_replace('B/O ', 'Baby of.', $baby->BabyName) }}&nbsp/&nbsp{{ substr($baby->Sex, 0, 1) }}</td>
					</tr>
					<tr>
						<td></td>
						<td class="ptb-must-0">
							<!-- {{ \SiteHelpers::get_doctors_name($baby->neonatal_consultant) }} -->
						</td>
					</tr>
				</table>
				@else
				<span class="empty">Affix Barcode Label Here</span>
				@endif
			</div>
		</div>
		<div class="col-md-12 prescription-print-sheet">
			{{ Form::hidden('babyid', $baby->BabyId) }}
			{{ Form::hidden('admissionid', $admission_id) }}
			{{ Form::hidden('date', $date) }}
			{{ Form::hidden('prescribed') }}
			<div class="print-date pull-right mb-5"></div>
			<div class="col-md-12 col-sm-12 col-xs-12 prescription-data-list plr-must-0"></div>
		</div>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12 divFooter"><b>Medication Chart Version - 3 / 27-07-2021 SKSH India (P) Ltd., Salem, TN.</b></div>
</div>
<div class="temp-container" id="prescription-page-a3">
	<div class="prescription-loader"></div>
	@include('prescription.prescription_print_style')
	<div class="header-content">
		<div class="col-md-12 col-sm-12 col-xs-12 mb-5 plr-must-0 header-text">
			<div class="col-md-4 col-sm-4 col-xs-4 plr-must-0">
				<img src="{{ ValuelistHelpers::printPagelogo($hospital_name) }}" class="header-logo-spacing" style="width: auto !important; height: auto !important;">
			</div>
			<div class="col-md-4 col-sm-4 col-xs-4 plr-must-0 text-center">
				<h4 class="m-0"><b>Form No. 4</b></h4>
				<h3 class="m-0 fs-20">MEDICATION CHART</h3>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-4 plr-must-0 barcode text-center">
				@if(!empty($ip_details->ip_number) && !is_null($ip_details->ip_number))
				<table class="">
					<tr>
						<td class="p-must-0"></td>
						<td class="custom-padding">
							<div class="col-md-6 plr-must-0">
								<b class="pull-left fs-16">{{$ip_details->ip_number}}</b>
							</div>
							<div class="col-md-6 plr-must-0">
								<span class="baby-mrn">{{ $baby->BMrNo }}</span>
							</div>
						</td>
					</tr>
					<tr>
						<td><b class="hosptial-name">SKSH</b></td>
						<td>
							<span class="barcode-content">
								@php $ipnumber = str_replace('IP/', '01', $ip_details->ip_number); @endphp
								<img src="data:image/png;base64,{{DNS1D::getBarcodePNG($ipnumber, 'C128', 2, 38)}}" alt="barcode" />
							</span>
						</td>
					</tr>
					<tr>
						<td></td>
						<td class="ptb-must-0">{{ str_replace('B/O ', 'Baby of.', $baby->BabyName) }}&nbsp/&nbsp{{ substr($baby->Sex, 0, 1) }}</td>
					</tr>
					<tr>
						<td></td>
						<td class="ptb-must-0">
							<!-- {{ \SiteHelpers::get_doctors_name($baby->neonatal_consultant) }} -->
						</td>
					</tr>
				</table>
				@else
				<span class="empty">Affix Barcode Label Here</span>
				@endif
			</div>
		</div>
	</div>
	<div class="temp-row"></div>
	<div class="col-md-12 col-sm-12 col-xs-12 divFooter plr-must-0"><b>Medication Chart Version - 3 / 27-07-2021 SKSH India (P) Ltd., Salem, TN.</b></div>
</div>
@endsection
@include('prescription.prescription_print_script')
