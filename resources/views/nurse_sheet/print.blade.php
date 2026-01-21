@extends('print')
@section('content')
@php
$site_url = url('/').'/public';
@endphp
{!! Form::hidden('baby_id', @$nurse_details_sheet->baby_id) !!}
{!! Form::hidden('admission_id', @$nurse_details_sheet->admission_id) !!}
{!! Form::hidden('start_time', $start_time) !!}
{!! Form::hidden('end_time', $endtime) !!}
{!! Form::hidden('approval_status', $approval_status) !!}
<style type="text/css">
	.bg-warninggg-must {
		background-color: #fbce7a !important;
	}
</style>
<div class="temp-container nurse-sheet sheet-auto">
	<div class="temp-row">
		<!-- <div class="col-md-12 mt-30-print"></div> -->
		<div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 0px">
			<div class="col-md-12 plr-must-0">
				<div class="col-md-4 col-sm-4 col-xs-12 plr-must-0">
					<img src="{{ ValuelistHelpers::printPagelogo($hospital_name) }}">
				</div>
				<div class="col-md-4 col-sm-4 col-xs-12 text-center">
					<h4 class="m-0"><b>Form No. 3A</b></h4>
					<h3>Neonatal Intensive Care Sheet</h3>
				</div>
				<div class="col-md-4 col-sm-4 col-xs-4 plr-must-0 barcode text-center">					
					@if(isset($ip_details->ip_number) && !empty($ip_details->ip_number) && !is_null($ip_details->ip_number))
					<table>
						<tr>
							<td style="padding: 0px !important"></td>
							<td style="padding: 0px 0px 0px 5px !important;">
								<div class="col-md-6 plr-must-0">
									<b style="font-size: 16px;" class="pull-left">{{$ip_details->ip_number}}</b>
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
									<img src="data:image/png;base64,{{\DNS1D::getBarcodePNG($ipnumber, 'C128', 2, 38)}}" alt="barcode" />
								</span>
							</td>
						</tr>
						<tr>
							<td></td>
							<td style="padding-bottom: 0px !important">{{ str_replace('B/O ', 'Baby of.', $baby->BabyName) }}&nbsp/&nbsp{{ substr($baby->Sex, 0, 1) }}</td>
						</tr>
						<tr>
							<td></td>
							<td style="padding-bottom: 0px !important">
								<!-- {{ \SiteHelpers::get_doctors_name($baby->neonatal_consultant) }} -->
							</td>
						</tr>
					</table>
					@else
					<span class="empty">Affix Barcode Label Here</span>
					@endif
				</div>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-4 content-center hide pull-right">
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
						</td>	
					</tr>
					<tr>
						<td colspan="2">{{ $baby->BMrNo }}</td>
					</tr>
				</table>
			</div>
		</div>

		<div class="col-md-12 col-sm-12 col-xs-12 basic-detail plr-must-0">
			<h4 class="mt-10 mb-5 plr-15 pull-left">Basic Details</h4>
			@php $sheetdate = explode(' ', $sheet_date); @endphp
			@if ($last_column_span > 0)
				<h4 class="mt-10 mb-5 plr-15 pull-right">{{ $sheet_date }}</h4>
			@else
				<h4 class="mt-10 mb-5 plr-15 pull-right">{{ $sheetdate[0] }}</h4>
			@endif
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="content-block">				
					<div class="section-set"> 	
						<div class="col-xs-12 col-sm-4 col-md-4">
							<div class="form-group">
								<span class="print-label">Baby Name:</span>
								<span class="print-value text-captialize">{{ $baby->BabyName }}</span>
							</div>  
							<div class="form-group">
								<span class="print-label">{{ Lang::get('home.ip') }}:</span>
								<span class="print-value">{{ @$ip_details->ip_number }}</span>
							</div>
						</div>
					</div>
					<div class="section-set"> 	
						<div class="col-xs-12 col-sm-4 col-md-4">
							<div class="form-group">
								<span class="print-label">{{ Lang::get('home.mrn') }}:</span>
								<span class="print-value text-captialize">{{ $baby->BMrNo }}</span>
							</div>
							<div class="form-group">
								<span class="print-label">Room No.:</span>
								<span class="print-value">{{ @$bed_details->room_name }}</span>
							</div>
						</div>
					</div>
					<div class="section-set"> 	
						<div class="col-xs-12 col-sm-4 col-md-4">
							<br/>
							<div class="form-group">
								<span class="print-label">Cot No.:</span>
								<span class="print-value">{{ @$bed_details->bed_name }}</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12 mt-10">
				<div class="content-block">
					<div class="section-set"> 	
						<div class="col-xs-12 col-sm-4 col-md-4">
							<!-- <div class="form-group">
								<span class="print-label">Baby Name:</span>
								<span class="print-value text-captialize">{{ $baby->BabyName }}</span>
							</div>   -->
							<div class="form-group">
								<span class="print-label">DOB:</span>
								<span class="print-value text-captialize">{{ empty($baby->DOB) ? '' : date('d-m-Y', strtotime($baby->DOB)) }}</span>
							</div>
							<div class="form-group">
								<span class="print-label">Age:</span>
								<span class="print-value">{{ SiteHelpers::calculate_day_of_life_two($baby->DOB, $current_date, true) }}</span>
							</div>   
							<div class="form-group">
								<span class="print-label">Gestation:</span>
								<span class="print-value">{{ SiteHelpers::decode_gestation($baby->Gestation) }}</span>
							</div>
							<div class="form-group">
								<span class="print-label">Corrected Gestation:</span>
								<span class="print-value">{{ ($baby->Gestation != '' && $corrected_gestation != 0) ? $corrected_gestation : '' }}</span>
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
								<span class="print-label">Birth Weight:</span>
								<span class="print-value">{{ $baby->BirthWeight }}</span>
							</div>
							<div class="form-group">
								<span class="print-label">Working Weight:</span>
								<span class="print-value">{{ @$working_weight }}</span>
							</div>   
							<div class="form-group">
								<span class="print-label">Baby's Blood Group:</span>
								<span class="print-value">@if($baby->BabyBloodGroup != 'Not Known'){{ $baby->BabyBloodGroup }} @endif</span>
							</div>
						</div>
					</div> 
					<div class="section-set">
						<div class="col-xs-12 col-sm-4 col-md-4">
							<div class="form-group">
								<span class="print-label">ETT Size:</span>
								<span class="print-value">{{ empty($et_size) ? '-' : $et_size }}</span>
							</div>
							<div class="form-group">
								<span class="print-label">ETT Length:</span>
								<span class="print-value">{{ empty($et_length) ? '-' : $et_length }}</span>
							</div>
							<div class="form-group">
								<span class="print-label">NGT Size:</span>
								<span class="print-value">{{ empty($ngt_size) ? '-' : $ngt_size }}</span>
							</div>
							<div class="form-group">
								<span class="print-label">NGT Length:</span>
								<span class="print-value">{{ empty($ngt_length) ? '-' : $ngt_length }}</span>
							</div>
						</div> 	
					</div>	
				</div>	 
			</div>	 
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12 observation">
			<h4 class="mt-0 mb-5">Baby Observations <span class="note-box">( IC - Intensive Care; HD - High Dependancy Care; SC - Special Care; AC - Acral Cyanosis; CC - Central Cyanosis; PP - Pale-Pink; S - Sleep; N - Normal; L - Lethargic; C - Comatosed; SP - Sedated / paralysed; Sup - Supine; Pro - Prone; Lat - Lateral; )    </span></h4>
			<div class="table-border">
				<table class="table hour-wise-table fixed">
					<thead>
						@if ($last_column_span > 0)
							<tr>
								<th rowspan="2" class="sticky">Date & Time</th>
								<th class="date-col" colspan="{{ $first_column_span }}">{{ $sheetdate[0] }}</th>
								<th class="date-col" colspan="{{ $last_column_span }}">{{ $sheetdate[3] }}</th>
							</tr>
						@endif
						<tr>
							@if ($last_column_span == 0)
								<th class="sticky">Date & Time</th>
							@endif
							@foreach ($time_slots as $slots)
							@php $slot = explode(":", $slots)[1]; @endphp
							@php $slot1 = explode(":", $slots)[2]; @endphp
							<th>{{ $slot }}:{{ $slot1 }}</th>
							@endforeach		    			
						</tr>
					</thead>
					<tbody>	
						<tr>
							<td>Type of Care</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'type_of_care')->first(); @endphp
							<td>
								@if(!empty($values['intf_ref_value']))
								@if($values['intf_ref_value'] == 'Intensive Care')
								IC
								@elseif($values['intf_ref_value'] == 'High Dependancy Care')
								HD
								@elseif($values['intf_ref_value'] == 'Special Care')
								SC
								@elseif($values['intf_ref_value'] == 'N/A') -
								@else
								{{ $values['intf_ref_value'] }}
								@endif	
								@else 
								-
								@endif
							</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>       		   
						<tr>
							<td>Warmer Temp&nbsp(C/F)</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $baby_observe[1])->first(); @endphp
							<td>
								@if(!empty($values['intf_ref_value']))
								{{ $values['intf_ref_value'] }}
								@else 
								-
								@endif
							</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Incubator Temp&nbsp(C/F)</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $baby_observe[2])->first(); @endphp
							<td>
								@if(!empty($values['intf_ref_value']))
								{{ $values['intf_ref_value'] }}
								@else 
								-
								@endif
							</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Measured Baby Temp&nbsp(C/F)</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $baby_observe[3])->first(); @endphp
							@if(!empty($values['intf_ref_value']))
							<td>
								{{ $values['intf_ref_value'] }}
							</td>
							@else 
							<td>-</td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						@if($baby->BabyId != '4527')
						<tr>
							<td>Monitor - Temp&nbsp(C/F)</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $baby_observe[4])->first(); @endphp
							@if(!empty($values['intf_ref_value']))
							@php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							@endphp
							<td class="{{($values['is_approved'] == false && $approval_status && $created_by == $monitor_user) ? 'bg-warninggg' : ''}}" data-id="{{$values['id']}}">
								{{ is_numeric($values['intf_ref_value']) ? number_format($values['intf_ref_value'], 1) : $values['intf_ref_value'] }}
							</td>
							@else 
							<td>-</td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						@endif
						<tr>
							<td>Therapeutic Hypothermia</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'therapeutic_hypothermia')->first(); @endphp
							<td>
								@if(!empty($values['intf_ref_value']))
								{{ ($values['intf_ref_value'] == 'on') ? 'Yes' : 'No' }}
								@else 
								-
								@endif
							</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Rectal Temp&nbsp(C/F)</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $baby_observe[5])->first(); @endphp
							<td>
								@if(!empty($values['intf_ref_value']))
								{{ $values['intf_ref_value'] }}
								@else 
								-
								@endif
							</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Heart Rate <span>(Beats/Min)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $baby_observe[6])->first(); @endphp
							@if(!empty($values['intf_ref_value']))
							@php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							@endphp
							<td class="{{($values['is_approved'] == false && $approval_status && $created_by == $monitor_user) ? 'bg-warninggg' : ''}}" data-id="{{$values['id']}}">{{ round($values['intf_ref_value']) }}</td>
							@else 
							<td>-</td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>RR(Measured) <span>(RR/Min)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $baby_observe[19])->first(); @endphp
							<td>
								@if(!empty($values['intf_ref_value']))
								{{ round($values['intf_ref_value']) }}
								@else 
								-
								@endif
							</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>RR(Monitor) <span>(RR/Min)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $baby_observe[7])->first(); @endphp
							@if(!empty($values['intf_ref_value']))
							@php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							@endphp
							<td class="{{($values['is_approved'] == false && $approval_status && $created_by == $monitor_user) ? 'bg-warninggg' : ''}}" data-id="{{$values['id']}}">
								{{ round($values['intf_ref_value']) }}
							</td>
							@else 
							<td>-</td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Cuff Systolic BP <span>(mm Hg)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $baby_observe[9])->first(); @endphp
							@if(!empty($values['intf_ref_value']))
							@php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							@endphp
							<td class="{{($values['is_approved'] == false && $approval_status && $created_by == $monitor_user) ? 'bg-warninggg' : ''}}" data-id="{{$values['id']}}">
								{{ round($values['intf_ref_value']) }}
							</td>
							@else 
							<td>-</td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Cuff Diastolic BP <span>(mm Hg)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $baby_observe[10])->first(); @endphp
							@if(!empty($values['intf_ref_value']))
							@php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							@endphp
							<td class="{{($values['is_approved'] == false && $approval_status && $created_by == $monitor_user) ? 'bg-warninggg' : ''}}" data-id="{{$values['id']}}">
								{{ round($values['intf_ref_value']) }}
							</td>
							@else 
							<td>-</td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Cuff Mean BP <span>(mm Hg)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $baby_observe[11])->first(); @endphp
							@if(!empty($values['intf_ref_value']))
							@php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							@endphp
							<td class="{{($values['is_approved'] == false && $approval_status && $created_by == $monitor_user) ? 'bg-warninggg' : ''}}" data-id="{{$values['id']}}">
								{{ round($values['intf_ref_value']) }}
							</td>
							@else 
							<td>-</td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Arterial Systolic BP <span>(mm Hg)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $baby_observe[12])->first(); @endphp
							@if(!empty($values['intf_ref_value']))
							@php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							@endphp
							<td class="{{($values['is_approved'] == false && $approval_status && $created_by == $monitor_user) ? 'bg-warninggg' : ''}}" data-id="{{$values['id']}}">
								{{ round($values['intf_ref_value']) }}
							</td>
							@else 
							<td>-</td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Arterial Diastolic BP <span>(mm Hg)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $baby_observe[13])->first(); @endphp
							@if(!empty($values['intf_ref_value']))
							@php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							@endphp
							<td class="{{($values['is_approved'] == false && $approval_status && $created_by == $monitor_user) ? 'bg-warninggg' : ''}}" data-id="{{$values['id']}}">
								{{ round($values['intf_ref_value']) }}
							</td>
							@else 
							<td>-</td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Arterial Mean BP <span>(mm Hg)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $baby_observe[14])->first(); @endphp
							@if(!empty($values['intf_ref_value']))
							@php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							@endphp
							<td class="{{($values['is_approved'] == false && $approval_status && $created_by == $monitor_user) ? 'bg-warninggg' : ''}}" data-id="{{$values['id']}}">
								{{ round($values['intf_ref_value']) }}
							</td>
							@else 
							<td>-</td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Preductal SaO<sub>2</sub> (%)</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $baby_observe[15])->first(); @endphp
							@if(!empty($values['intf_ref_value']))
							@php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							@endphp
							<td class="{{($values['is_approved'] == false && $approval_status && $created_by == $monitor_user) ? 'bg-warninggg' : ''}}" data-id="{{$values['id']}}">
								{{ round($values['intf_ref_value']) }}
							</td>
							@else 
							<td>-</td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Postductal SaO<sub>2</sub> (%)</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $baby_observe[16])->first(); @endphp
							@if(!empty($values['intf_ref_value']))
							@php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							@endphp
							<td class="{{($values['is_approved'] == false && $approval_status && $created_by == $monitor_user) ? 'bg-warninggg' : ''}}" data-id="{{$values['id']}}">
								{{ round($values['intf_ref_value']) }}
							</td>
							@else
							<td>-</td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Perfusion Index (%)</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'perfusion_index')->first(); @endphp
							@if(!empty($values['intf_ref_value']))
							@php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							@endphp
							<td class="{{($values['is_approved'] == false && $approval_status && $created_by == $monitor_user) ? 'bg-warninggg' : ''}}" data-id="{{$values['id']}}">
								{{ is_numeric($values['intf_ref_value']) ? number_format($values['intf_ref_value'], 2) : $values['intf_ref_value'] }}
							</td>
							@else 
							<td>-</td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Oxyen Saturation <span>Index</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'oxygen_saturation_index')->first(); @endphp
							<td>
								@if(!empty($values['intf_ref_value']))
								{{ is_numeric($values['intf_ref_value']) ? number_format($values['intf_ref_value'], 2) : $values['intf_ref_value'] }}
								@else 
								-
								@endif
							</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>rSO2 (1)</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $respiratorty_support[27])->where('intf_ref_value', '!=', NULL)->first(); @endphp
							@if(isset($values['intf_ref_value']) && !empty($values['intf_ref_value']))
							@php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							@endphp
							<td class="{{($values['is_approved'] == false && $approval_status && $created_by == $monitor_user) ? 'bg-warninggg' : ''}}" data-id="{{$values['id']}}">
								{{ $values['intf_ref_value'] }}
							</td>
							@else 
							<td>-</td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Baseline rSO2 (1)</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $respiratorty_support[29])->where('intf_ref_value', '!=', NULL)->first(); @endphp
							@if(isset($values['intf_ref_value']) && !empty($values['intf_ref_value']))
							@php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							@endphp
							<td class="{{($values['is_approved'] == false && $approval_status && $created_by == $monitor_user) ? 'bg-warninggg' : ''}}" data-id="{{$values['id']}}">
								{{ $values['intf_ref_value'] }}
							</td>
							@else 
							<td>-</td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>rSO2 (2)</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $respiratorty_support[28])->where('intf_ref_value', '!=', NULL)->first(); @endphp
							@if(isset($values['intf_ref_value']) && !empty($values['intf_ref_value']))
							@php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							@endphp
							<td class="{{($values['is_approved'] == false && $approval_status && $created_by == $monitor_user) ? 'bg-warninggg' : ''}}" data-id="{{$values['id']}}">
								{{ $values['intf_ref_value'] }}
							</td>
							@else 
							<td>-</td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Baseline rSO2 (2)</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $respiratorty_support[30])->where('intf_ref_value', '!=', NULL)->first(); @endphp
							@if(isset($values['intf_ref_value']) && !empty($values['intf_ref_value']))
							@php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							@endphp
							<td class="{{($values['is_approved'] == false && $approval_status && $created_by == $monitor_user) ? 'bg-warninggg' : ''}}" data-id="{{$values['id']}}">
								{{ $values['intf_ref_value'] }}
							</td>
							@else 
							<td>-</td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>HeRO Score </td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'hero_score')->first(); @endphp
							@if(!empty($values['intf_ref_value']))
							<td>
								{{ is_numeric($values['intf_ref_value']) ? number_format($values['intf_ref_value'], 2) : $values['intf_ref_value'] }}
							</td>
							@else 
							<td>-</td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>N-SOFA Score </td>
							@foreach($time_slots as $slots)
							@if (isset($n_sofa_score[$slots]))
							<td>
								{{ $n_sofa_score[$slots] }}
							</td>
							@else 
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Color</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $baby_observe[17])->first(); @endphp
							<td>
								<div class="wrap">
									@if(!empty($values['intf_ref_value']))
									@if($values['intf_ref_value'] =='Acral Cyanosis')
									AC
									@elseif($values['intf_ref_value'] =='Central Cyanosis')
									CC
									@elseif($values['intf_ref_value'] =='Pale-Pink') 
									PP
									@else
									{{ $values['intf_ref_value'] }} 
									@endif	
									@else 
									-
									@endif
								</div>
							</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Phototherapy</td>
							@php $value = ''; @endphp
							@foreach($time_slots as $slots)
							@if (isset($phototherapy[$slots]) && count($phototherapy[$slots]) > 0)
							
							@foreach($phototherapy[$slots] as $values)
							@if(!empty($values))
							@php $value = $values; @endphp
							<td>{{ ($value == 'on') ? 'Yes' : 'No' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
							
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Eyes Covered</td>
							@php $value = ''; @endphp
							@foreach($time_slots as $slots)
							@if (isset($phototherapy_eyes[$slots]) && count($phototherapy_eyes[$slots]) > 0)
							@foreach($phototherapy_eyes[$slots] as $values)
							@if(!empty($values))
							@php $value = $values; @endphp
							<td>{{ ($value == 'on' || $value == 'Yes') ? 'Yes' : 'No' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach	
							@else
							<td>-</td>
							@endif
							@endforeach	
						</tr>
						<tr>
							<td>
								<div class="active-tb">Activity</div>
							</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $baby_observe[18])->first(); @endphp
							<td>
								<div class="activity">
									@if(!empty($values['intf_ref_value']))
									@if(strtolower($values['intf_ref_value']) == strtolower('Sleep'))
									S
									@elseif(strtolower($values['intf_ref_value']) == strtolower('Normal'))
									N
									@elseif(strtolower($values['intf_ref_value']) == strtolower('Lethargic'))
									L
									@elseif(strtolower($values['intf_ref_value']) == strtolower('Comatosed'))
									C 
									@elseif(strtolower($values['intf_ref_value']) == strtolower('Sedated / paralysed'))
									SP 
									@elseif(strtolower($values['intf_ref_value']) == strtolower('normal'))
									N
									@elseif(strtolower($values['intf_ref_value']) == strtolower('N/A'))
									-
									@else
									{{ $values['intf_ref_value'] }}

									@endif
									@else 
									-
									@endif
								</div>
							</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Position</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'position')->first(); @endphp
							<td>
								@if(!empty($values['intf_ref_value']) && $values['intf_ref_value'] != 'N/A')
								@if($values['intf_ref_value'] == 'supine')
								Sup
								@elseif($values['intf_ref_value'] =='prone')
								Pro
								@elseif($values['intf_ref_value'] =='lateral')
								Lat
								@else
								{{ $values['intf_ref_value'] }}
								@endif   	
								@else 
								-
								@endif
							</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
					</tbody>	    		
				</table>
			</div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12 respiratory page-break-inside page-break-land">
			<h4>Respiratory Support <span class="note-box">( IMP - Improved; D - Deteriorated; Stab- Stable; HFNC - HHHFNC; BPAP - BiPAP; HFOV(n) - Nasal HFOV; InO2 - Incubator O2; HBO2 - Head Box Oxygen; NPO2 - Nasopharyngeal Oxygen; SVA - SV (in air); E - Equal; UnE - Unequal; )</span></h4>	    	
			<div class="table-border">
				<table class="table hour-wise-table fixed">
					<thead>
						@if ($last_column_span > 0)
							<tr>
								<th rowspan="2" class="sticky">Date & Time</th>
								<th class="date-col" colspan="{{ $first_column_span }}">{{ $sheetdate[0] }}</th>
								<th class="date-col" colspan="{{ $last_column_span }}">{{ $sheetdate[3] }}</th>
							</tr>
						@endif
						<tr>
							@if ($last_column_span == 0)
								<th class="sticky">Date & Time</th>
							@endif
							@foreach($time_slots as $slots)
							@php $slot = explode(":", $slots)[1]; @endphp
							@php $slot1 = explode(":", $slots)[2]; @endphp
							<th>{{ $slot }}:{{ $slot1 }}</th>
							@endforeach
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<div class="active-tb">Work Of Breathing</div>
							</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $respiratorty_support[0])->first(); @endphp
							<td>
								<div>
									@if(!empty($values['intf_ref_value']) && $values['intf_ref_value'] != 'N/A')
									@if($values['intf_ref_value'] == 'Improved')
									IMP
									@elseif($values['intf_ref_value'] == 'Deteriorated')
									D
									@elseif($values['intf_ref_value'] == 'Stable')
									Stab
									@else
									{{ $values['intf_ref_value'] }}
									@endif 	
									@else 
									-
									@endif
								</div>
							</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Mode Of Invasive <br/>Respiratory Support:</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $respiratorty_support[1])->first(); @endphp
							@php $values1 = collect($temp_data)->where('local_code', $respiratorty_support[31])->first(); @endphp
							{{-- @if(!empty($values['intf_ref_value']))
							{{ $values['intf_ref_value'] }}
							@else 
							-
							@endif --}}
							@if(!empty($values['intf_ref_value']) && in_array($values['intf_ref_value'], $invasive_ventilation) || !empty($values1['intf_ref_value']) && in_array($values1['intf_ref_value'], $invasive_ventilation))

							@php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							@endphp

							<td class="{{($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : ''}}" data-id="{{$values['id']}}">
								@if($values['intf_ref_value'] =='High Flow O2' || $values1['intf_ref_value'] =='High Flow O2')
								HFNC
								@elseif($values['intf_ref_value']=='HHHFNC' || $values1['intf_ref_value']=='HHHFNC')
								HFNC	
								@elseif($values['intf_ref_value']=='CPAP' || $values1['intf_ref_value']=='CPAP')
								CPAP
								@elseif($values['intf_ref_value']=='BiPAP' || $values1['intf_ref_value']=='BiPAP')
								BPAP
								@elseif($values['intf_ref_value']=='NIPPV' || $values1['intf_ref_value']=='NIPPV')
								NIPV
								@elseif($values['intf_ref_value']=='Nasal HFOV' || $values1['intf_ref_value']=='Nasal HFOV')
								HFOV(n)
								@elseif($values['intf_ref_value']=='HBO2' || $values1['intf_ref_value']=='HBO2')
								HBO2
								@elseif($values['intf_ref_value']=='NPO2' || $values1['intf_ref_value']=='NPO2')
								NPO2
								@elseif($values['intf_ref_value']=='Incubator O2' || $values1['intf_ref_value']=='Incubator O2')
								InO2   	
								@elseif(!empty($values['intf_ref_value']))
								{{ $values['intf_ref_value'] }}   	
								@elseif(!empty($values1['intf_ref_value']))
								{{ $values1['intf_ref_value'] }}
								@endif
							</td>
							@else 
							<td>-</td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Mode Of Non-Invasive <br/>Respiratory Support:</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $respiratorty_support[31])->first(); @endphp
							@php $values1 = collect($temp_data)->where('local_code', $respiratorty_support[1])->first(); @endphp
							@if(!empty($values['intf_ref_value']) && in_array($values['intf_ref_value'], $non_invasive_ventilation) || !empty($values1['intf_ref_value']) && in_array($values1['intf_ref_value'], $non_invasive_ventilation))
							@php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							@endphp
							<td class="{{($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : ''}}" data-id="{{$values['id']}}">
								@if($values['intf_ref_value'] =='High Flow O2' || $values1['intf_ref_value'] =='High Flow O2')
								HFNC
								@elseif($values['intf_ref_value']=='HHHFNC' || $values1['intf_ref_value']=='HHHFNC')
								HFNC	
								@elseif($values['intf_ref_value']=='CPAP' || $values1['intf_ref_value']=='CPAP')
								CPAP
								@elseif($values['intf_ref_value']=='BiPAP' || $values1['intf_ref_value']=='BiPAP')
								BPAP
								@elseif(($values['intf_ref_value']=='NIPPV Tr' || $values1['intf_ref_value']=='NIPPV Tr') || ($values['intf_ref_value']=='nippv tr' || $values1['intf_ref_value']=='nippv tr'))
								NIPPV
								@elseif($values['intf_ref_value']=='NIPPV (D)' || $values1['intf_ref_value']=='NIPPV (D)')
								NIPPV
								@elseif($values['intf_ref_value']=='Nasal HFOV' || $values1['intf_ref_value']=='Nasal HFOV')
								HFOV(n)
								@elseif($values['intf_ref_value']=='HBO2' || $values1['intf_ref_value']=='HBO2')
								HBO2
								@elseif($values['intf_ref_value']=='NPO2' || $values1['intf_ref_value']=='NPO2')
								NPO2
								@elseif($values['intf_ref_value']=='Incubator O2' || $values1['intf_ref_value']=='Incubator O2')
								InO2	
								@elseif($values['intf_ref_value']=='SV' || $values1['intf_ref_value']=='SV')
								SVA						   	  		     	
								@elseif($values['intf_ref_value']=='NCPAP (D)' || $values1['intf_ref_value']=='NCPAP (D)')
								NCPAP (D)						   	  		     	
								@elseif($values['intf_ref_value']=='NHFOV (D)' || $values1['intf_ref_value']=='NHFOV (D)')
								NHFOV (D)						   	  		     	
								@elseif($values['intf_ref_value']=='NCPAP (S)' || $values1['intf_ref_value']=='NCPAP (S)')
								NCPAP (S)						   	  		     	
								@elseif($values['intf_ref_value']=='DUOPAP' || $values1['intf_ref_value']=='DUOPAP')
								DUOPAP							   	  		     	
								@elseif($values['intf_ref_value']=='nCPAP (D)' || $values1['intf_ref_value']=='nCPAP (D)')
								nCPAP (D)				   	  		     	
								@elseif(!empty($values['intf_ref_value']))
								{{ $values['intf_ref_value'] }}
								@elseif(!empty($values1['intf_ref_value']))
								{{ $values1['intf_ref_value'] }}
								@endif
							</td>
							@else 
							<td>-</td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Volume Targeting</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))

							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php 
							$values = collect($temp_data)->where('local_code', $respiratorty_support[22])->first(); 
							$mode_of_ventilation = collect($temp_data)->where('local_code', $respiratorty_support[1])->where('intf_ref_value', '!=', NULL)->first();
							@endphp
							<td>
								@if(isset($values['intf_ref_value']) && !empty($values['intf_ref_value']) && !in_array($mode_of_ventilation['intf_ref_value'], $non_invasive))
								{{ ($values['intf_ref_value'] == 'on') ? 'Yes' : 'No' }}
								@elseif(isset($mode_of_ventilation['intf_ref_value']) && !empty($mode_of_ventilation['intf_ref_value'])  && !in_array($mode_of_ventilation['intf_ref_value'], $non_invasive))
								No
								@else
								-
								@endif
							</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>

						<tr>
							<td>Targeted Tidal Vol <span>(ml)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $respiratorty_support[3])->first(); @endphp
							@if(!empty($values['intf_ref_value']))
							@php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							@endphp
							<td class="{{($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : ''}}" data-id="{{$values['id']}}">
								{{ is_numeric($values['intf_ref_value']) ? number_format($values['intf_ref_value'], 1) : $values['intf_ref_value'] }}
							</td>
							@else 
							<td>
								-
							</td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>	 
						<tr>
							<td>Delivered Tidal Vol <span>(ml)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $respiratorty_support[11])->first(); @endphp
							@if(!empty($values['intf_ref_value']))
							@php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							@endphp
							<td class="{{($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : ''}}" data-id="{{$values['id']}}">
								{{ is_numeric($values['intf_ref_value']) ? number_format($values['intf_ref_value'], 1) : $values['intf_ref_value'] }}
							</td>
							@else 
							<td>
								-
							</td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>   		   
						<tr>
							<td>&Delta; P/Amplitude</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $respiratorty_support[4])->first(); @endphp
							@if(!empty($values['intf_ref_value']))
							@php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							@endphp
							<td class="{{($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : ''}}" data-id="{{$values['id']}}">
								{{ $values['intf_ref_value'] }}
							</td>
							@else 
							<td>
								-
							</td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>PIP Settings</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $respiratorty_support[5])->first(); @endphp
							@if(!empty($values['intf_ref_value']))
							@php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							@endphp
							<td class="{{($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : ''}}" data-id="{{$values['id']}}">
								{{ $values['intf_ref_value'] }}
							</td>
							@else 
							<td>
								-
							</td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>PIP Delivered</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $respiratorty_support[6])->first(); @endphp
							@if(!empty($values['intf_ref_value']))
							@php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							@endphp
							<td class="{{($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : ''}}" data-id="{{$values['id']}}">
								{{ is_numeric($values['intf_ref_value']) ? number_format($values['intf_ref_value'], 1) : $values['intf_ref_value'] }}
							</td>
							@else 
							<td>
								-
							</td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>PEEP</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $respiratorty_support[7])->first(); @endphp
							@if(!empty($values['intf_ref_value']))
							@php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							@endphp
							<td class="{{($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : ''}}" data-id="{{$values['id']}}">
								{{ $values['intf_ref_value'] }}
							</td>
							@else 
							<td>
								-
							</td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>MAP (Ventilator data)</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $respiratorty_support[8])->first(); @endphp
							@if(!empty($values['intf_ref_value']))
							@php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							@endphp
							<td class="{{($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : ''}}" data-id="{{$values['id']}}">
								{{ $values['intf_ref_value'] }}
							</td>
							@else 
							<td>
								-
							</td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>

						<tr>
							<td>MAP (Calculated)</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp

                            @php 
                                $peep_delivered = collect($temp_data)->where('local_code', $respiratorty_support[7])->first(); 
                                $pip_delivered = collect($temp_data)->where('local_code', $respiratorty_support[6])->first(); 
                                $it_s = collect($temp_data)->where('local_code', $respiratorty_support[15])->first();
                                $rr_set = collect($temp_data)->where('local_code', $respiratorty_support[12])->first();
                            @endphp
							@if(
                                !empty($peep_delivered['intf_ref_value']) && is_numeric($peep_delivered['intf_ref_value']) &&
                                !empty($pip_delivered['intf_ref_value']) && is_numeric($pip_delivered['intf_ref_value']) &&
                                !empty($it_s['intf_ref_value']) && is_numeric($it_s['intf_ref_value']) &&
                                !empty($rr_set['intf_ref_value']) && is_numeric($rr_set['intf_ref_value'])
                            )
							@php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
                            $map = $peep_delivered['intf_ref_value'] + ($pip_delivered['intf_ref_value'] - $peep_delivered['intf_ref_value']) * ($it_s['intf_ref_value'] * $rr_set['intf_ref_value'] / 60)
							@endphp
							<td class="{{($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : ''}}" data-id="{{$values['id']}}">
								{{ number_format($map, 2) }}
							</td>
							@else 
							<td>
								-
							</td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Oxygenie (CLACO)</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))

							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php 
							$values = collect($temp_data)->where('local_code', $respiratorty_support[32])->first(); 
							@endphp
							@if(isset($values['intf_ref_value']) && !empty($values['intf_ref_value']))
							@php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							@endphp
							<td class="{{($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : ''}}" data-id="{{$values['id']}}">
								{{ ($values['intf_ref_value'] == '2' || $values['intf_ref_value'] == '4' || $values['intf_ref_value'] == '3') ? 'Yes' : '-' }}
							</td>
							@else
							<td>
								-
							</td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Target SpO<sub>2</sub> range</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php 
							$values = collect($temp_data)->where('local_code', $respiratorty_support[35])->first(); 
							$oxygenie_values = collect($temp_data)->where('local_code', $respiratorty_support[32])->first(); 
							@endphp
							@if(!empty($values['intf_ref_value']) && ($oxygenie_values['intf_ref_value'] == '2' || $oxygenie_values['intf_ref_value'] == '4' || $oxygenie_values['intf_ref_value'] == '3'))
							@php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							@endphp
							<td class="{{($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : ''}}" data-id="{{$values['id']}}">
								{{ \SiteHelpers::ventilatorAutoO2TargetRange($values['intf_ref_value']) }}
							</td>
							@else 
							<td>-</td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>FiO<sub>2</sub> % (Set)</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $respiratorty_support[9])->first(); @endphp
							@if(!empty($values['intf_ref_value']))
							@php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							@endphp
							<td class="{{($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : ''}}" data-id="{{$values['id']}}">
								{{ $values['intf_ref_value'] }}
							</td>
							@else 
							<td>-</td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>FiO<sub>2</sub> % (Delivered)</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $oxygene_mode = collect($temp_data)->where('local_code', $respiratorty_support[32])->first(); @endphp
							@php $values = collect($temp_data)->where('local_code', $respiratorty_support[33])->first(); @endphp
							@if(isset($oxygene_mode['intf_ref_value']) && !empty($oxygene_mode['intf_ref_value']) && ($oxygene_mode['intf_ref_value'] == '2' || $oxygene_mode['intf_ref_value'] == '4' || $oxygene_mode['intf_ref_value'] == '3'))
							@if(!empty($values['intf_ref_value']))
							@php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							@endphp
							<td class="{{($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : ''}}" data-id="{{$values['id']}}">
								{{ $values['intf_ref_value'] }}
							</td>
							@else 
							<td>-</td>
							@endif
							@else
							<td>-</td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Ventilator SpO<sub>2</sub></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php 
							$values = collect($temp_data)->where('local_code', $respiratorty_support[34])->first(); 
							$oxygenie_values = collect($temp_data)->where('local_code', $respiratorty_support[32])->first(); 
							@endphp
							@if(!empty($values['intf_ref_value']) && ($oxygenie_values['intf_ref_value'] == '2' || $oxygenie_values['intf_ref_value'] == '4' || $oxygenie_values['intf_ref_value'] == '3'))
							@php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							@endphp
							<td class="{{($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : ''}}" data-id="{{$values['id']}}">
								{{ $values['intf_ref_value'] }}
							</td>
							@else 
							<td>-</td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>FLOW <span>(L/Min)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $respiratorty_support[10])->first(); @endphp
							@if(!empty($values['intf_ref_value']))
							@php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							@endphp
							<td class="{{($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : ''}}" data-id="{{$values['id']}}">
								{{ $values['intf_ref_value'] }}
							</td>
							@else 
							<td>-</td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>RR(set)</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $respiratorty_support[12])->first(); @endphp
							@if(!empty($values['intf_ref_value']))
							@php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							@endphp
							<td class="{{($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : ''}}" data-id="{{$values['id']}}">
								{{ $values['intf_ref_value'] }}
							</td>
							@else 
							<td>
								-
							</td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Trigger Count</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $respiratorty_support[26])->where('intf_ref_value', '!=', NULL)->first(); @endphp
							@if(isset($values['intf_ref_value']) && !empty($values['intf_ref_value']))
							@php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							@endphp
							<td class="{{($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : ''}}" data-id="{{$values['id']}}">
								{{ $values['intf_ref_value']  }}
							</td>
							@else 
							<td>
								-
							</td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Frequency <span>(Hz)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $respiratorty_support[13])->first(); @endphp
							@if(!empty($values['intf_ref_value']))
							@php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							@endphp
							<td class="{{($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : ''}}" data-id="{{$values['id']}}">
								{{ $values['intf_ref_value'] }}
							</td>
							@else 
							<td>
								-
							</td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>IT (%)</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $respiratorty_support[14])->first(); @endphp
							@if(!empty($values['intf_ref_value']))
							@php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							@endphp
							<td class="{{($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : ''}}" data-id="{{$values['id']}}">
								{{ $values['intf_ref_value'] }}
							</td>
							@else 
							<td>
								-
							</td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>IT (S)</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $respiratorty_support[15])->first(); @endphp
							@if(!empty($values['intf_ref_value']))
							@php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							@endphp
							<td class="{{($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : ''}}" data-id="{{$values['id']}}">
								{{ $values['intf_ref_value'] }}
							</td>
							@else 
							<td>
								-
							</td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Measured Ti</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $respiratorty_support[25])->where('intf_ref_value', '!=', NULL)->first(); @endphp
							@if(!empty($values['intf_ref_value']))
							@php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							@endphp
							<td class="{{($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : ''}}" data-id="{{$values['id']}}">
								{{ $values['intf_ref_value'] }}
							</td>
							@else 
							<td>
								-
							</td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>IE RATIO</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $respiratorty_support[16])->first(); @endphp
							@if(!empty($values['intf_ref_value']))
							@php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							@endphp
							<td class="{{($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : ''}}" data-id="{{$values['id']}}">
								{{ $values['intf_ref_value'] }}
							</td>
							@else 
							<td>
								-
							</td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>CPAP <span>Interface Change</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $respiratorty_support[17])->first(); @endphp
							@if(!empty($values['intf_ref_value']))
							@php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							@endphp
							<td class="{{($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : ''}}" data-id="{{$values['id']}}">
								{{ $values['intf_ref_value'] }}
							</td>
							@else 
							<td>
								-
							</td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Humidifier/Temp</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $respiratorty_support[19])->first(); @endphp
							@if(!empty($values['intf_ref_value']))
							@php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							@endphp
							<td class="{{($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : ''}}" data-id="{{$values['id']}}">
								{{ $values['intf_ref_value'] }}
							</td>
							@else 
							<td>
								-
							</td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Air Entry <span>(R)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $respiratorty_support[20])->first(); @endphp
							<td>
								@if(!empty($values['intf_ref_value']))
								@if($values['intf_ref_value'] == 'Equal')
								E
								@elseif($values['intf_ref_value'] == 'Unequal')
								UnE
								@else
								{{ $values['intf_ref_value'] }}
								@endif	
								@else 
								-
								@endif
							</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Air Entry <span>(L)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $respiratorty_support[21])->first(); @endphp
							<td>
								@if(!empty($values['intf_ref_value']))
								@if($values['intf_ref_value'] == 'Equal')
								E
								@elseif($values['intf_ref_value'] == 'Unequal')
								UnE
								@else
								{{ $values['intf_ref_value'] }}
								@endif	
								@else 
								-
								@endif
							</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Chest Physio</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $respiratorty_support[23])->first(); @endphp
							<td>
								@if(!empty($values['intf_ref_value']))
								{{ ($values['intf_ref_value'] == 'on') ? 'Yes' : 'No' }}
								@else 
								-
								@endif
							</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Suction</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $respiratorty_support[24])->first(); @endphp
							<td>
								@if(!empty($values['intf_ref_value']))
								{{ ($values['intf_ref_value'] == 'on') ? 'Yes' : 'No' }}
								@else 
								-
								@endif
							</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		@php $totalfeedvolume = 0; @endphp
		<!-- tpn fluids -->
		<div class="col-md-12 col-sm-12 col-xs-12 infusions page-break-inside">
			<h4>Drug Infusions & PN</h4>
			<div class="table-border">
				<table class="table hour-wise-table fixed">
					<thead>
						@if ($last_column_span > 0)
							<tr>
								<th rowspan="3" class="sticky">Date & Time</th>
								<th class="date-col" colspan="{{ $first_column_span * 2 }}">{{ $sheetdate[0] }}</th>
								<th class="date-col" colspan="{{ $last_column_span * 2 }}" class="not-sticky">{{ $sheetdate[3] }}</th>
								<th rowspan="3" class="sticky">24/TOT</th>
							</tr>
						@endif
						<tr>
							@if ($last_column_span == 0)
								<th class="sticky">Date & Time</th>
							@endif
							@foreach($time_slots as $slots)
							@php $slot = explode(":", $slots)[1]; @endphp
							@php $slot1 = explode(":", $slots)[2]; @endphp
							<th colspan="2">{{ $slot }}:{{ $slot1 }}</th>
							@endforeach
							@if ($last_column_span == 0)
								<th class="sticky">24/TOT</th>
							@endif
						</tr>
						<tr>
							@if ($last_column_span == 0)
								<th>&nbsp</th>
							@endif
							@foreach($time_slots as $slots)
							<th>V/H</th>
							<th>TOT</th>
							@endforeach
							@if ($last_column_span == 0)
								<th class="sticky"></th>
							@endif
						</tr>
					</thead>
					<tbody>
						@php 
						$temp_time_slots = $time_slots;
						@endphp
						@php $totrate = 0; @endphp
						@if (count($pn_fluids) > 0)
						@foreach($pn_fluids as $fluids_Key => $fluids)
						@php $runningrate = 0; @endphp
						<tr>
							@php $fluidsKey = explode(':', $fluids_Key); @endphp
							@if (is_array($fluidsKey) && count($fluidsKey) > 1)
							@php $fluidsKey = $fluidsKey[1]; @endphp
							@else  
							@php $fluidsKey = $fluidsKey[0]; @endphp
							@endif				                    	
							<td> {{ $fluidsKey }}</td>
							@foreach($temp_time_slots as $key => $slots)						
							@php $fluids_set = isset($fluids[$slots]) ? collect($fluids[$slots])->toArray() : []; @endphp
							@if(count($fluids_set) > 0)							
							@if(isset($fluids_set['drug_rate']))  
							<td>
								{{ is_numeric($fluids_set['drug_rate']) ? number_format($fluids_set['drug_rate'], 2) : $fluids_set['drug_rate'] }}
							</td>
							@else
							<td>-</td>
							@endif								
							@if(isset($fluids_set['drug_total']))  
							@php $hourtotal = (float)$fluids_set['drug_total']; @endphp
							@php $runningrate += $hourtotal; @endphp
							<td class="vol-bg {{(isset($fluids_set['approval_status']) && $fluids_set['approval_status'] == false && $approval_status) ? 'bg-warninggg-must' : ''}}" data-row-id="{{ $fluids_Key }}" data-val-time="{{ $slots }}">
								{{ is_numeric($hourtotal) ? number_format($hourtotal, 2) : $hourtotal }}
							</td>
							@else
							<td>-</td>
							@endif
							@else 
							<td>-</td>
							<td class="vol-bg"><strong>-</strong></td>
							@endif
							@endforeach
							<td>{{ number_format($runningrate, 2) }}</td>
							@php $totalfeedvolume = $totrate = $totrate + $runningrate; @endphp
						</tr>
						@endforeach	
						@else
						<tr>
							<td>&nbsp</td>
							@foreach ($time_slots as $slots)
							<td>&nbsp</td>
							<td>&nbsp</td>
							@endforeach
							<td>&nbsp</td>
						</tr>
						@endif
					</tbody>
				</table>
			</div>
		</div>
		<!-- tpn fluids -->
		@if(isset($replacement_fluids) && count($replacement_fluids) > 0)
		<div class="col-md-12 col-sm-12 col-xs-12 replacement page-break-inside page-break-land page-break-portrait-a3-auto">
			<h4>Replacement Fluids</h4>
			<div class="table-border">
				<table class="table hour-wise-table fixed">
					<thead>
						@if ($last_column_span > 0)
							<tr>
								<th rowspan="3" class="sticky">Date & Time</th>
								<th class="date-col" colspan="{{ $first_column_span * 2 }}">{{ $sheetdate[0] }}</th>
								<th class="date-col" colspan="{{ $last_column_span * 2 }}">{{ $sheetdate[3] }}</th>
								<th rowspan="3" class="sticky">24/TOT</th>
							</tr>
						@endif
						<tr> 
							@if ($last_column_span == 0)
								<th class="sticky">Time</th>
							@endif
							@foreach($time_slots as $slots)
							@php $slot = explode(":", $slots)[1]; @endphp
							@php $slot1 = explode(":", $slots)[2]; @endphp
							<th colspan="2">{{ $slot }}:{{ $slot1 }}</th>
							@endforeach
						</tr>
						<tr>
							@if ($last_column_span == 0)
								<th>&nbsp</th>
							@endif
							@foreach($time_slots as $slots)
							<th>V/H</th>
							<th>TOT</th>
							@endforeach
						</tr> 
					</thead>
					<tbody>
						@foreach($replacement_fluids as $replacement_fluidsKey => $replacement_fluids_value)
						<tr>
							@php 
							$replacement_total = 0;
							@endphp
							<td>{{ $ivfluids[$replacement_fluids_value] }}</td>
							@foreach($time_slots as $slots)
							@if (isset($temp_replacement_fluids[$slots]))
							@php $replacement_fluids_set = $temp_replacement_fluids[$slots]; @endphp
							@php  $fluids_set_temp = $replacement_fluids_set->where('value', $replacement_fluids_value)->last()  @endphp
							@if(count($fluids_set_temp) > 0)
							@php $fluids_rate  =  $replacement_fluids_set->where('observe_id', $fluids_set_temp->id)->where('local_code', 'replacement_fluids_rate')->first(); @endphp
							@php $fluids_total =  $replacement_fluids_set->where('observe_id', $fluids_set_temp->id)->where('local_code', 'replacement_fluids_total')->first(); @endphp
							<td>
								@if(isset($fluids_rate->value) && $fluids_rate->value != '')	
								{{ $fluids_rate->value }}
								@else
								-
								@endif	
							</td>
							<td>
								@if(isset($fluids_total->value) && $fluids_total->value != '')	
								{{ $fluids_total->value}}
								@else
								-
								@endif	
							</td>
							@if ($fluids_total->value != '')
							@php
								$replacement_total = $replacement_total + $fluids_total->value;
							@endphp
							@else
							@php
								$replacement_total = $replacement_total;
							@endphp
							@endif
							@else 
							<td >-</td>
							<td >-</td>
							@endif
							@else 
							<td >-</td>
							<td >-</td>
							@endif
							@endforeach
							<td>{{ number_format($replacement_total, 2) }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		@endif
		<div class="col-md-12 col-sm-12 col-xs-12 milk-feeds page-break-inside">
			<h4>Milk Feeds <span class="note-box">( SF - Spoon Feed; TF - Tube Feed; P/C - Paladai Cup; T+O - Tube + Oral )  </span></h4>
			<div class="table-border">
				<table class="table hour-wise-table fixed">
					<thead>
						@if ($last_column_span > 0)
							<tr>
								<th rowspan="2" class="sticky">Date & Time</th>
								<th class="date-col" colspan="{{ $first_column_span }}">{{ $sheetdate[0] }}</th>
								<th class="date-col" colspan="{{ $last_column_span }}">{{ $sheetdate[3] }}</th>
								<th rowspan="2" class="sticky">24/TOT</th>
							</tr>
						@endif
						<tr>
							@if ($last_column_span == 0)
								<th class="sticky">Time</th>	    				
							@endif
							@foreach ($time_slots as $slots)
							@php $slot = explode(":", $slots)[1]; @endphp
							@php $slot1 = explode(":", $slots)[2]; @endphp
							<th>{{ $slot }}:{{ $slot1 }}</th>
							@endforeach	
							@if ($last_column_span == 0)
								<th class="sticky">24/TOT</th>
							@endif
						</tr>
					</thead>
					<tbody>
						@php $milk_vol = 0; @endphp
						@php unset($milk_feeds[5]); @endphp
						@foreach($milk_feeds as $milk_feeds_key => $milk_feeds_value)
						<tr>
							@if($milk_feeds_value =='human_milk_fortification')
							<td>Fortification</td>
							@elseif($milk_feeds_value =='stoma_output_hour_total')
							<td>Stoma Output</td>
							@elseif ($milk_feeds_value == 'milk_volume')
							<td class="avoid-transparent">Milk Volume / Total</td>
							@else
							<td>{{ title_case(str_replace('_', ' ', $milk_feeds_value)) }}</td>
							@endif
							@foreach ($time_slots as $slots)
							@if (isset($temp_milk_feeds[$slots]))
							@php $milk_feed_set = $temp_milk_feeds[$slots]; @endphp
							@php $milk_feed_set_temp = collect($milk_feed_set)->where('local_code', $milk_feeds_value)->first(); @endphp
							@if (!(count($milk_feed_set_temp) > 0) && $milk_feeds_value == 'milk_feeds')
							@php $milk_feed_set_temp = collect($milk_feed_set)->where('local_code', 'type_of_feeds')->first(); @endphp
							@endif
							@if (count($milk_feed_set_temp) > 0)	           	 	      
							@if ($milk_feeds_value == 'human_milk_fortification' && $milk_feed_set_temp['intf_ref_value'] == 'on')
							<td> Yes </td>
							@elseif ($milk_feeds_value == 'human_milk_fortification' && $milk_feed_set_temp['intf_ref_value'] == 'off')
							<td> No </td>
							@elseif ($milk_feeds_value == 'human_milk_fortification' && $milk_feed_set_temp['intf_ref_value'] == '') 
							<td>-</td>
							@elseif ($milk_feeds_value == 'milk_volume')
							<td class="crossed">
								@php $milk_feed_set_temp['intf_ref_value'] =  preg_replace('/[A-Z,a-z]/', '', $milk_feed_set_temp['intf_ref_value']) @endphp
								@php $milk_vol =  preg_replace('/[A-Z,a-z]/', '', $milk_vol) @endphp
								@php $milk_feed_set_temp['intf_ref_value'] =  preg_replace('/[A-Z,a-z]/', '', $milk_feed_set_temp['intf_ref_value']) @endphp
								@php $milk_feed_set_temp['intf_ref_value'] = $milk_feed_set_temp['intf_ref_value'] != '' ? (float)$milk_feed_set_temp['intf_ref_value'] : 0; @endphp
								@php $milk_vol_for_time = $milk_vol_for_time + $milk_feed_set_temp['intf_ref_value']; @endphp
								@php $milk_vol = $milk_vol + $milk_feed_set_temp['intf_ref_value']; @endphp

								<div class="part1"><span class="text-center">{{ $milk_feed_set_temp['intf_ref_value'] }}</span></div>
								<div class="crossed-line"></div>
								@php $milk_feed_set_temp = collect($milk_feed_set)->where('local_code', 'milk_volume_total')->first(); @endphp		           	 	  

								<div class="part2"><span class="text-center">{{ $milk_vol }}</span></div>
							</td>
							@elseif ($milk_feeds_value == 'milk_feeds')
							@php $type_of_feeds = collect($milk_feed_set)->where('local_code', 'type_of_feeds')->first(); @endphp
							@if ($type_of_feeds['intf_ref_value'] == 'NPO')
							@php $milk_feed_set_temp['intf_ref_value'] = 'No'; @endphp
							@elseif (!empty($type_of_feeds['intf_ref_value']))
							@php $milk_feed_set_temp['intf_ref_value'] = 'Yes'; @endphp
							@endif
							@if (empty($milk_feed_set_temp['intf_ref_value']))
							<td>-</td>								
							@else
							<td>{{ $milk_feed_set_temp['intf_ref_value'] == 'No' ? $milk_feed_set_temp['intf_ref_value'] . ' (NPO)' : $milk_feed_set_temp['intf_ref_value'] }}</td>								
							@endif
							@elseif ($milk_feeds_value == 'type_of_feeds')
							<td>
							{{ empty($milk_feed_set_temp['intf_ref_value']) || $milk_feed_set_temp['intf_ref_value'] == 'NPO' ? '-' : $milk_feed_set_temp['intf_ref_value'] }}</td>								
							@else 
							@if($milk_feed_set_temp['intf_ref_value'] == 'Spoon Feed')
							<td>SF</td>
							@elseif($milk_feed_set_temp['intf_ref_value'] == 'Tube Feed')
							<td>TF</td>
							@elseif($milk_feed_set_temp['intf_ref_value'] == 'Paladai Cup')
							<td>P/C</td>
							@elseif($milk_feed_set_temp['intf_ref_value'] == 'Tube + Oral')
							<td>T+O</td>
							@else
							<td>{{ !empty($milk_feed_set_temp['intf_ref_value']) ? $milk_feed_set_temp['intf_ref_value'] : '-' }}</td>
							@endif
							@endif          	 	   
							@else
							<td> - </td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
							@if (is_numeric($milk_vol) && $milk_feeds_value == 'milk_volume' && $milk_vol != 0)
							<td>{{ number_format($milk_vol, 2) }}</td>							
							@elseif (!is_numeric($milk_vol) && $milk_feeds_value == 'milk_volume' && $milk_vol != 0)
							<td>{{ $milk_vol }}</td>
							@else
							<td></td>
							@endif
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div class="col-md-12 full-width mt-10">
				<div class="row pull-right custom-total">
					<span class="plr-10"><strong>Total Input</strong></span>
					@php $tot_input = $totalfeedvolume + $milk_vol; @endphp
					<span class="box">{{ $tot_input != 0 ? number_format($tot_input, 2) : '' }}</span>
				</div>
			</div>
			<div class="col-md-12 full-width mt-10">
				<div class="row pull-right custom-total">
					@if ($nurse_details_sheet->total_input > 0)
					<span class="box mlr-5 pull-left">{{ $nurse_details_sheet->total_input_ml_per_kg }}</span><span class="pull-right">ml/kg/day</span>
					@else
					<span class="box mlr-5 pull-left"></span><span class="pull-right">ml/kg/day</span>
					@endif
				</div>
			</div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12 output page-break-inside">
			<h4>Output <span class="note-box"> ( Milk - Milky; yell - Yellow; LG - Light green; DG - Dark green; B - Bloody; AB - Altered brown; Mec - Meconium; CP - Changing pattern; F.yell - Formed yellow; SSyell - Semi-solid yellow; Pale - Pale white; G - Green; L - Loose; D - Diarrhoea; )</span></h4>
			<div class="table-border">
				<table class="table hour-wise-table fixed">
					<thead>
						@if ($last_column_span > 0)
							<tr>
								<th rowspan="3" class="sticky">Date & Time</th>
								<th class="date-col" colspan="{{ $first_column_span * 2 }}">{{ $sheetdate[0] }}</th>
								<th class="date-col" colspan="{{ $last_column_span * 2 }}">{{ $sheetdate[3] }}</th>
								<th rowspan="3" class="sticky">24/TOT</th>
							</tr>
						@endif
						<tr>
							@if ($last_column_span == 0)
								<th class="sticky">Time</th>
							@endif
							@foreach($time_slots as $slots)
							@php $slot = explode(":", $slots)[1]; @endphp
							@php $slot1 = explode(":", $slots)[2]; @endphp
							<th colspan="2">{{ $slot }}:{{ $slot1 }}</th>
							@endforeach
							@if ($last_column_span == 0)
								<th class="sticky">24/TOT</th>
							@endif
						</tr>
						<tr>
							@if ($last_column_span == 0)
								<th>&nbsp</th>
							@endif
							@foreach($time_slots as $slots)
							<th>V/H</th>
							<th>TOT</th>
							@endforeach
							@if ($last_column_span == 0)
								<th class="sticky"></th>
							@endif
						</tr>
					</thead>           	  
					<tbody>
						<tr>
							<td>Gastric Aspirate <span>(ml)</span></td>
							@php $gastric_aspirate = 0; @endphp
							@foreach($time_slots as $slots)
							@if (isset($temp_output_groups[$slots]))
							@php $temp_data = $temp_output_groups[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = $temp_data->where('local_code', $output_groups[0])->first(); @endphp
							@php $values['intf_ref_value'] = preg_replace("/[^0-9,.]/", "", $values['intf_ref_value'] ); @endphp					    			
							@if ($values['intf_ref_value'] != 0)
							<td>{{ $values['intf_ref_value'] }}</td>
							@php $gastric_aspirate = $gastric_aspirate + $values['intf_ref_value']; @endphp
							<td><strong>{{ ($gastric_aspirate != 0) ? $gastric_aspirate : '-' }}</strong></td>
							@else
							<td>-</td>
							<td>-</td>
							@endif
							@else
							<td>-</td>
							<td>-</td>
							@endif
							@endforeach
							<td>{{ $gastric_aspirate != 0 ? number_format($gastric_aspirate, 2) : '' }}</td>
						</tr>
						<tr>
							<td>Gastric Aspirate <span>(nature)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($temp_output_groups[$slots]))
							@php $temp_data = $temp_output_groups[$slots]; $temp_data = collect($temp_data); @endphp

							@php $values = collect($temp_data)->where('local_code', $output_groups[1])->first(); @endphp
							<td colspan="2">
								{{-- <div class="wrap">{{ ($values['intf_ref_value'] != '') ? $values['intf_ref_value'] : '-' }}</div> --}}
								<div class="wrap invert">
									@if(!empty($values['intf_ref_value'])) 	
									@if($values['intf_ref_value'] == 'Milky')
									<div class="landscape">{{ 'Milk' }}</div>
									@elseif($values['intf_ref_value'] == 'Yellow')
									<div class="landscape">{{ 'yell' }}</div>
									@elseif($values['intf_ref_value'] == 'Light green')
									<div class="landscape">{{ 'LG' }}</div>
									@elseif($values['intf_ref_value'] == 'Dark green')
									<div class="landscape">{{ 'DG' }}</div>
									@elseif($values['intf_ref_value'] == 'Bloody')
									<div class="landscape">{{ 'B' }}</div>
									@elseif($values['intf_ref_value'] == 'Altered brown')
									<div class="landscape">{{ 'AB'}}</div>
									@else
									<div class="landscape">{{ $values['intf_ref_value']	}}</div>
									@endif
									@else
									-
									@endif
								</div>
							</td>
							@else
							<td colspan="2">-</td>
							@endif
							@endforeach	               	
							<td></td>
						</tr>
						<tr>
							<td>Urine Output <span>(ml)</span></td>
							@php $urine_output = 0; @endphp
							@foreach($time_slots as $slots)
							@if (isset($temp_output_groups[$slots]))
							@php $temp_data = $temp_output_groups[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $output_groups[3])->first(); @endphp
							@php $values['intf_ref_value'] = preg_replace("/[^0-9,.]/", "", $values['intf_ref_value'] ); @endphp					    			
							@if ($values['intf_ref_value'] != 0)
							<td>{{ $values['intf_ref_value'] }}</td>
							@php $urine_output = $urine_output + $values['intf_ref_value']; @endphp
							<td><strong>{{ ($urine_output != 0) ? $urine_output : '-' }}</strong></td>
							@else
							<td>-</td>
							<td>-</td>
							@endif
							@else
							<td>-</td>
							<td>-</td>
							@endif
							@endforeach	
							<td>{{ $urine_output != 0 ? number_format($urine_output, 2) : '' }}</td>
						</tr>
						<tr>
							<td>Blood Volume Out <span>(ml)</span></td>
							@php $blood_volume_out = 0; @endphp
							@foreach($time_slots as $slots)
							@if (isset($temp_output_groups[$slots]))
							@php $temp_data = $temp_output_groups[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $output_groups[5])->first(); @endphp
							@php $values['intf_ref_value'] = preg_replace("/[^0-9,.]/", "", $values['intf_ref_value'] ); @endphp					    			
							@if ($values['intf_ref_value'] != 0)
							<td>{{ $values['intf_ref_value'] }}</td>
							@php $blood_volume_out = $blood_volume_out + $values['intf_ref_value']; @endphp
							<td><strong>{{ ($blood_volume_out != 0) ? $blood_volume_out : '-' }}</strong></td>
							@else
							<td>-</td>
							<td>-</td>
							@endif
							@else
							<td>-</td>
							<td>-</td>
							@endif
							@endforeach	
							<td>{{ $blood_volume_out != 0 ? number_format($blood_volume_out, 2) : '' }}</td>
						</tr>
						<tr>
							<td>Drain Output (R)</td>
							@php $drain_output_r = 0; @endphp
							@foreach($time_slots as $slots)
							@if (isset($temp_output_groups[$slots]))
							@php $temp_data = $temp_output_groups[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $output_groups[7])->first(); @endphp
							@php $values['intf_ref_value'] = preg_replace("/[^0-9,.]/", "", $values['intf_ref_value'] ); @endphp					    			
							@if ($values['intf_ref_value'] != 0)
							<td>{{ $values['intf_ref_value'] }}</td>
							@php $drain_output_r = $drain_output_r + $values['intf_ref_value']; @endphp
							<td><strong>{{ ($drain_output_r != 0) ? $drain_output_r : '-' }}</strong></td>
							@else
							<td>-</td>
							<td>-</td>
							@endif
							@else
							<td>-</td>
							<td>-</td>
							@endif
							@endforeach	
							<td>{{ $drain_output_r != 0 ? number_format($drain_output_r, 2) : '' }}</td>
						</tr>
						<tr>
							<td>Drain Output (L)</td>
							@php $drain_output_l = 0; @endphp
							@foreach($time_slots as $slots)
							@if (isset($temp_output_groups[$slots]))
							@php $temp_data = $temp_output_groups[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $output_groups[9])->first(); @endphp
							@php $values['intf_ref_value'] = preg_replace("/[^0-9,.]/", "", $values['intf_ref_value'] ); @endphp					    			
							@if ($values['intf_ref_value'] != 0)
							<td>{{ $values['intf_ref_value'] }}</td>
							@php $drain_output_l = $drain_output_l + $values['intf_ref_value']; @endphp
							<td><strong>{{ ($drain_output_l != 0) ? $drain_output_l : '-' }}</strong></td>
							@else
							<td>-</td>
							<td>-</td>
							@endif

							@else
							<td>-</td>
							<td>-</td>
							@endif
							@endforeach	
							<td>{{ $drain_output_l != 0 ? number_format($drain_output_l, 2) : '' }}</td>
						</tr>
						<tr>
							<td>Stoma Output</td>
							@foreach($time_slots as $slots)
							@if (isset($temp_output_groups[$slots]))
							@php $temp_data = $temp_output_groups[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $output_groups[16])->first(); @endphp
							<td colspan="2">{{ ($values['intf_ref_value'] != '') ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td colspan="2">-</td>
							@endif
							@endforeach	
							<td></td>
						</tr>
						<tr>
							<td>Bowels Opened</td>
							@foreach($time_slots as $slots)
							@if (isset($temp_output_groups[$slots]))
							@php $temp_data = $temp_output_groups[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $output_groups[11])->first(); @endphp
							<td colspan="2">
								@if(!empty($values['intf_ref_value'])) 	
								{{ ($values['intf_ref_value'] == 'on') ? 'Yes' : 'No' }}
								@else
								-
								@endif
							</td>
							@else
							<td colspan="2">-</td>
							@endif
							@endforeach	
							<td></td>
						</tr>
						<tr>
							<td>Stool Nature</td>
							@foreach($time_slots as $slots)
							@if (isset($temp_output_groups[$slots]))
							@php $temp_data = $temp_output_groups[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $output_groups[12])->first(); @endphp
							<td colspan="2">
								{{-- <div class="wrap">
									@if(!empty($values['intf_ref_value'])) 	
									{{ $values['intf_ref_value'] }}
									@else
									-
									@endif
								</div> --}}
								<div class="wrap invert">
									@if(!empty($values['intf_ref_value'])) 	
									@if($values['intf_ref_value'] == 'Changing stool pattern')
									<div class="landscape">{{ 'CP'	}}</div>
									@elseif($values['intf_ref_value'] == 'Meconium')
									<div class="landscape">{{ 'Mec'	}}</div>
									@elseif($values['intf_ref_value'] == 'Formed yellow')
									<div class="landscape">{{ 'F.yell'	}}</div>
									@elseif($values['intf_ref_value'] == 'Semi-solid yellow')
									<div class="landscape">{{ 'SSyell'	}}</div>
									@elseif($values['intf_ref_value'] == 'Pale white')
									<div class="landscape">{{ 'Pale'	}}</div>
									@elseif($values['intf_ref_value'] == 'Green')
									<div class="landscape">{{ 'G' }}</div>
									@elseif($values['intf_ref_value'] == 'Loose')
									<div class="landscape">{{ 'L' }}</div>
									@elseif($values['intf_ref_value'] == 'Diarrhoea')
									<div class="landscape">{{ 'D' }}</div>
									@elseif($values['intf_ref_value'] == 'Bloody')
									<div class="landscape">{{ 'B' }}</div>
									@else
									<div class="landscape">{{ $values['intf_ref_value'] }}</div>
									@endif
									@else
									-
									@endif
								</div>
							</td>
							@else
							<td colspan="2">-</td>
							@endif
							@endforeach	
							<td></td>
						</tr>
						<tr>
							<td>KMC</td>
							@foreach($time_slots as $slots)
							@if (isset($temp_output_groups[$slots]))
							@php $temp_data = $temp_output_groups[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $output_groups[13])->first(); @endphp
							<td colspan="2">
								@if(!empty($values['intf_ref_value'])) 	
								{{ ($values['intf_ref_value'] == 'on') ? 'Yes' : 'No' }}
								@else
								-
								@endif
							</td>
							@else
							<td colspan="2">-</td>
							@endif
							@endforeach	
							<td></td>
						</tr>
						<tr>
							<td>NNS</td>
							@foreach($time_slots as $slots)
							@if (isset($temp_output_groups[$slots]))
							@php $temp_data = $temp_output_groups[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $output_groups[14])->first(); @endphp
							<td colspan="2">
								@if(!empty($values['intf_ref_value'])) 	
								{{ ($values['intf_ref_value'] == 'on') ? 'Yes' : 'No' }}
								@else
								-
								@endif
							</td>
							@else
							<td colspan="2">-</td>
							@endif
							@endforeach	
							<td></td>
						</tr>
						{{-- 	<tr>
							<td>Blood Sugar <span>(mg/dl)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($temp_output_groups[$slots]))
							@php $temp_data = $temp_output_groups[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $output_groups[15])->first(); @endphp
							<td colspan="2">{{ ($values['intf_ref_value'] != '') ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td colspan="2">-</td>
							@endif
							@endforeach	
							<td></td>
						</tr> --}}
					</tbody>
				</table>
			</div>
			<div class="col-md-12 full-width mt-10">
				<div class="row pull-right custom-total">
					<span class="plr-10"><strong>Total Output</strong></span>
					@php $tot = $gastric_aspirate + $urine_output + $blood_volume_out + $drain_output_r + $drain_output_l; @endphp
					<span class="box">{{ $tot != 0 ? number_format($tot, 2) : '' }}</span>
				</div>
			</div>
			<div class="col-md-12 full-width mt-10">
				<div class="row pull-right custom-total">
					@if ($nurse_details_sheet->total_output > 0)
					<span class="box mlr-5 pull-left">{{ $nurse_details_sheet->total_output_ml_per_kg }}</span><span class="pull-right">ml/kg/day</span>
					@else
					<span class="box mlr-5 pull-left"></span><span class="pull-right">ml/kg/day</span>					
					@endif
				</div>
			</div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12 blood-value page-break-inside page-break-land page-break-portrait">
			<h4>Blood Gas <span class="note-box">( A - Arterial; V - Venous; C - Capillary; )</span></h4>
			<div class="table-border">
				<table class="table hour-wise-table fixed">
					<thead>
						@if ($last_column_span > 0)
							<tr>
								<th rowspan="2" class="sticky">Date & Time</th>
								<th class="date-col" colspan="{{ $first_column_span }}">{{ $sheetdate[0] }}</th>
								<th class="date-col" colspan="{{ $last_column_span }}">{{ $sheetdate[3] }}</th>
							</tr>
						@endif
						<tr>
							@if ($last_column_span == 0)
								<th class="sticky">Time</th>
							@endif
							@foreach($time_slots as $slots)
							@php $slot = explode(":", $slots)[1]; @endphp
							@php $slot1 = explode(":", $slots)[2]; @endphp
							<th>{{ $slot }}:{{ $slot1 }}</th>
							@endforeach
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Type Of Blood Gas</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'blood_gas_type')->first(); @endphp
							@if (!empty($values['intf_ref_value']))
							@if ($values['intf_ref_value'] == 'Arterial')
							<td><div class="wrap">A</div></td>
							@elseif ($values['intf_ref_value'] == 'Venous')
							<td><div class="wrap">V</div></td>
							@elseif ($values['intf_ref_value'] == 'Capillary')
							<td><div class="wrap">C</div></td>
							@else
							<td><div class="wrap">-</div></td>
							@endif
							@else
							<td><div class="wrap">-</div></td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Last BG at</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'last_bg_time')->first(); @endphp
							@if (!empty($values['intf_ref_value']))
							@if (str_contains($values['intf_ref_value'], 'AM'))
							@php 
							$time = explode(':', $values['intf_ref_value']);
							$hour = (int)$time[0]; 
							$minutes = explode(' ', $time[1])[0]; 
							@endphp
							@if ($hour == 12)
							@php $hour = '00'; @endphp
							@endif
							<td>{{ $hour .':'. $minutes }}</td>
							@else
							@php 
							$time = explode(':', $values['intf_ref_value']);
							$hour = (int)$time[0]; 
							$minutes = explode(' ', $time[1])[0]; 
							@endphp
							@if ($hour == 12)
							@php $hour = 23; @endphp
							@else
							@php $hour = $hour + 12;@endphp
							@endif
							<td>{{ $hour .':'. $minutes }}</td>
							@endif
							@else
							<td>-</td>
							@endif
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>pH</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'interface_blood_gas_ph')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Pao2</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'interface_blood_gas_pao2')->first(); @endphp
							
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>TcPO2</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $baby_observe[21])->first(); @endphp
							<td>{{ ($values['intf_ref_value'] != '') ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>PaCo2</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'interface_blood_gas_paco2')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>TcPCO2</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', $baby_observe[20])->first(); @endphp
							<td>{{ ($values['intf_ref_value'] != '') ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>ETCO2</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'interface_blood_gas_etco2')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>HCO3</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'interface_blood_gas_hco3')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>			    		
						<tr>
							<td>BE</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'interface_blood_gas_be')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Na (sodium) <span>(mmol/L)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'interface_blood_gas_na')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>K (potassium) <span>(mmol/L)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'interface_blood_gas_k')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Calcium</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'interface_blood_gas_calcium')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Cl (Chloride) <span>(mmol/L)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'interface_blood_gas_cl')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>HB <span>(g/dL)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'interface_blood_gas_hb')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>PCV (%)</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'interface_blood_gas_pcv')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Lactate <span>(mmol/L)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'interface_blood_gas_lactate')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Bilirubin <span>(mg/dl)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'interface_blood_gas_bilirubin')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Blood Sugar <span>(mg/dl)</span><small>(Blood Gas)</small></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'interface_blood_gas_blood_sugar')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Blood Sugar <span>(mg/dl)</span><small>(Glucometer)</small></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'blood_sugar')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Methemoglobin</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'interface_blood_gas_methemoglobin')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12 blood-value page-break-inside page-break-portrait-a3-always hide">
			<h4>Blood Investigation</h4>
			<div class="table-border">
				<table class="table hour-wise-table fixed">
					<thead>
						@if ($last_column_span > 0)
							<tr>
								<th rowspan="2" class="sticky">Date & Time</th>
								<th class="date-col" colspan="{{ $first_column_span }}">{{ $sheetdate[0] }}</th>
								<th class="date-col" colspan="{{ $last_column_span }}">{{ $sheet_date[3] }}</th>
							</tr>
						@endif
						<tr>
							@if ($last_column_span == 0)
								<th>Time</th>
							@endif
							@foreach($time_slots as $slots)
							@php $slot = explode(":", $slots)[1]; @endphp
							@php $slot1 = explode(":", $slots)[2]; @endphp
							<th>{{ $slot }}:{{ $slot1 }}</th>
							@endforeach
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Na (sodium) <span>(mmol/L)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'blood_gas_na')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>K (potassium) <span>(mmol/L)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'blood_gas_k')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Cl (Chloride) <span>(mmol/L)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'blood_gas_cl')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Bilirubin  (mg/dl)</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'blood_gas_bilirubin')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Glucometer Sugar <span>(mg/dl)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'blood_sugar')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Methemoglobin</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'blood_gas_methemoglobin')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Calcium <span>(8.5-10.5 mg/dl)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'gluco_meter_calcium')->first(); @endphp
							<td><div class="wrap">{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</div></td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Magnesium <span>1.2 to 2.6 mg/dl</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'gluco_meter_magnesium')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Phosphorus <span>(2.7-4.5 mg/dl)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'gluco_meter_phosphorus')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>BUN <span>(6-20 mg/dl)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'gluco_meter_bun')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Creatintine <span>(0.6-1.4 mg/dl)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'gluco_meter_creatintine')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Glucose <span>(70-110 mg/dl)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'gluco_meter_glucose')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Creatine Kinase <span> (26-174 U/L)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'gluco_meter_creatinekinase')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>CK - MB <span>(&#60;6% of Total CK)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'gluco_meter_ckmb')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Trop. T</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'gluco_meter_trop')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Total bilirubin </td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'gluco_meter_totalbilirubin')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Direct bilirubin </td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'gluco_meter_directbilirubin')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>SGOT (AST) <span>(< 0-40 U/L)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'gluco_meter_sgot')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>SGPT (AST) <span>(< 0-40 U/L)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'gluco_meter_sgpt')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>ALP <span>(30-115 U/L)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'gluco_meter_alkalinephosphatase')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td class="custom">GGT <span>0 - 1 mo - 13 - 147 U/L</span><span>1-2 mo - 12 to 123 U/L</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'gluco_meter_gamagtp')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>LDH <span>(90-220 U/L)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'gluco_meter_ldh')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Amylase <span>(31-123 U/L)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'gluco_meter_amylase')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Lipase</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'gluco_meter_lipase')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Total Protein <span>(6-8.4 gm/dl)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'gluco_meter_totalprotein')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Albumin <span>(3.5-5.3 gm/dl)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'gluco_meter_albumin')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Total Cholesterol</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'gluco_meter_totalcholesterol')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>HDL</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'gluco_meter_hdl')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>LDL</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'gluco_meter_ldl')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>VLDL</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'gluco_meter_vldl')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Tri glycerides</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'gluco_meter_triglycerides')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Hemoglobin</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'blood_gas_hemoglobin')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>RBC <span>(3.5-5.5 *10<sup>6</sup>/&mu;)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'gluco_meter_rbc')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Haematocrit <span>(PCV) (35-55)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'gluco_meter_haematocrit')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Reticulocyte count <span>(0.5-1.5 %)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'gluco_meter_reticulocytecount')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td class="custom">WBC : Total Count <span>(4.000-11.0000/&mu;)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'gluco_meter_wbc')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>DC : Poly <span>(40-75 %)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'gluco_meter_dc')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Lymph <span>(0-75 %)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'gluco_meter_lymph')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Mono <span>(2-10 %)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'gluco_meter_mono')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Eos <span>(1-6 %)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'gluco_meter_eos')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Baso <span>(0-1 %)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'gluco_meter_baso')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Platelets</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'gluco_meter_platelets')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>ESR <span>(mm/hr)</span></td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'gluco_meter_esr')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>PT(s)</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'gluco_meter_prothrombintime')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>APTT(s)</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'gluco_meter_aptt')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>INR</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'gluco_meter_inr')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>Fibrinogen</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'gluco_meter_fibrinogen')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td>FDP</td>
							@foreach($time_slots as $slots)
							@if (isset($result[$slots]))
							@php $temp_data = $result[$slots]; $temp_data = collect($temp_data); @endphp
							@php $values = collect($temp_data)->where('local_code', 'gluco_meter_fdp')->first(); @endphp
							<td>{{ !empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-' }}</td>
							@else
							<td>-</td>
							@endif
							@endforeach
						</tr>
					</tbody>
				</table>
			</div>	
		</div>	
		
		<?php
		$nurse_list = \DB::table('users')->where('RoleId', env('NURSE_ROLE'))->get();

		$initial = $nurse_list->pluck('initial', 'mas_id')->toArray();
		$sign = $nurse_list->pluck('signature', 'mas_id')->toArray();
		$staff_id = $nurse_list->pluck('email', 'mas_id')->toArray();

		$nursesign = false;

		?>
		@if(isset($nurse_entered) && count($nurse_entered) > 0)
		<div class="col-md-12 col-sm-12 col-xs-12 entered">
			<h5>Sheet Entered By:</h5>
			<div class="table-border">
				<table class="table fixed entered-by">
					<thead>
						@if ($last_column_span > 0)
							<tr>
								<th rowspan="2" class="sticky">Date & Time</th>
								<th class="date-col" colspan="{{ $first_column_span }}">{{ $sheetdate[0] }}</th>
								<th class="date-col" colspan="{{ $last_column_span }}">{{ $sheetdate[3] }}</th>
							</tr>
						@endif
						<tr>
							@if ($last_column_span == 0)
								<th class="sticky">Time</th>	    				
							@endif
							@foreach ($time_slots as $slots)
							@php $slot = explode(":", $slots)[1]; @endphp
							@php $slot1 = explode(":", $slots)[2]; @endphp
							<th class="text-center"><b>{{ $slot }}:{{ $slot1 }}</b></th>
							@endforeach		    			
						</tr>
					</thead>
					<tbody>	
						<tr>
							<td><b>Signature</b></td>
							@foreach ($time_slots as $slots)
							@php $nurse_entered_id = isset($nurse_entered[$slots]) ? $nurse_entered[$slots] : null; @endphp
							@if (isset($sign[$nurse_entered_id]) && $nurse_entered_id != null)
							<td class="user-sign text-center">
								<img src="{{ $site_url }}/img/users/{{ $sign[$nurse_entered_id] }}" />
							</td>
							@elseif (isset($initial[$nurse_entered_id]) && $nurse_entered_id != null)
							<td class="user-sign text-center">
								<img src="{{ $site_url }}/img/users/{{ $initial[$nurse_entered_id] }}" />
							</td>
							@else
							<td class="text-center">-</td>
							@endif
							@endforeach
						</tr>
						<tr>
							<td><b>Name</b></td>
							@foreach ($time_slots as $slots)
							@php $nurse_entered_id = isset($nurse_entered[$slots]) ? $nurse_entered[$slots] : null; @endphp
							@if ($nurse_entered_id != null)
							<td class="text-center">
								{{ @$nurse_master[$nurse_entered_id] }}
								<br>
								<span class="font-normal">({{ @$staff_id[$nurse_entered_id] }})</span>
							</td>
							@else
							<td class="text-center">-</td>
							@endif
							@endforeach
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		@endif
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="daily-notes">
				<span>Ward Rounds Instruction</span>
				@if (!empty($nurse_details_sheet['ward_rounds_instruction']))
				<p>{{ $nurse_details_sheet['ward_rounds_instruction'] }}</p>
				@endif
				<table>
					<tbody>
						@foreach ($ward_rounds_instruction as $key => $value)
						@if (!empty(trim($value)))
						<tr>
							<td style="border: 0px !important; padding-left: 15px !important;">
								<b>{{ date('d-m-Y H', strtotime($key)) }}:00 : </b>
							</td>
							<td style="border: 0px !important;">
								&ensp;&ensp;{{ trim($value) }}
							</td>
						</tr>
						@endif
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div> 
<div class="col-md-12 col-sm-12 col-xs-12 divFooter">
	<b>Neonatal Intensive Care Sheet / Version - 1.0 / 07-01-2021 / SKSH India (P) Ltd., Salem, TN.</b>
</div>

@include('nurse_sheet.nurse_sheet_approval_modal')
@endsection

@section('scripts')
<script type="text/javascript">
	// $('.nurse-sheet.sheet-auto .infusions table > tbody > tr > td:nth-child(2)').css('left', $('.nurse-sheet .infusions table > tbody > tr > td:first-child').width()+4);
</script>
@endsection
