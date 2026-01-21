<style type="text/css">
	.screening .table-bordered > tbody > tr > td, .head-screening .table-bordered > tbody > tr > td {
		text-align: left !important;
		vertical-align: middle;
		padding: 0px 8px;
	}
	.screening input[type="text"], .head-screening input[type="text"], .head-screening input[type="number"] {
		border: none;
		box-shadow: unset;
		background-color: unset !important;
		margin-bottom: unset;
		border-radius: 0px;
		text-align: center;
		border-bottom: 1px solid var(--theme-color);
	}
	.screening input[type="text"]:focus, .head-screening input[type="text"]:focus, .head-screening input[type="number"]:focus {
		border: none;
		outline: none;
		box-shadow: unset;
		border-bottom: 1px solid #1e1e2d;
	}
	.screening td div, .head-screening td div {
		display: flex;
		align-items: center;
		justify-content: center;
		overflow: hidden;
	}
	.screening td div .fas.fa-edit, .screening td div .fas.fa-calendar-day, .head-screening td div .fas.fa-edit, .head-screening td div .fas.fa-calendar-day {
		color: var(--bg-theme-light);
		font-size: 12px;
		display: none;
	}
	.screening select {
		border-top: 0px;
	    border-left: 0px;
	    border-right: 0px;
	    border-radius: 0px !important;
	    background-color: transparent;
	    border-color: var(--theme-color);
	}
	.screening select:focus {
		box-shadow: unset;
	}
	.screening .table-bordered > tbody > tr.previous_screening td, .head-screening .table-bordered > tbody > tr.previous_screening td {
		background-color: rgb(57 104 198 / 0.2);
		height: 32px;
		text-align: center !important;
		font-size: 13px;
	}
	.placeholder-style {
		color: #999C9F;
	}
</style>
@php
	$rowspan_rop = $rowspan_aabr_hearing_screening = $rowspan_oae_hearing_screening = $rowspan_oae_hearing_assessment = $rowspan_audiometery_hearing_assessment =
		$rowspan_ct = $rowspan_usg = $rowspan_mri = 1;
	$previous_rop = $previous_aabr_hearing_screening = $previous_oae_hearing_screening = $previous_oae_hearing_assessment = $previous_audiometery_hearing_assessment = $previous_ct = $previous_usg = $previous_mri = '';
@endphp
@if (isset($previous_screening))
	@foreach($previous_screening as $value)
	@php $apply_style = $hearing_screen_aabr_date_style = $hearing_screen_oae_date_style = $diagnostic_abr_date_style = $diagnostic_cpa_date_style = $ct_date_style = $usg_date_style = $mri_date_style = ''; @endphp
		@if (count(json_decode($value->rop_options)) > 0 && in_array('rop', json_decode($value->rop_options)))
			@if ($value->rop_date == 'DD-MM-YYYY')
				@php $apply_style = 'placeholder-style'; @endphp
			@endif
			@php 
				$rowspan_rop++; 
				$previous_rop .= '<tr class="previous_screening"><td class="'. $apply_style . '">'. $value->rop_date .'</td><td>'. $value->rop_right_hand_side .'</td><td>'. $value->rop_left_hand_side .'</td><td>'. $value->rop_remarks .'</td></tr>';
			@endphp
		@endif
		@if (count(json_decode($value->hearing_screen_options)) > 0)
			@if (in_array('aabr', json_decode($value->hearing_screen_options)))
				@if ($value->hearing_screen_aabr_date == 'DD-MM-YYYY')
					@php $hearing_screen_aabr_date_style = 'placeholder-style'; @endphp
				@endif
				@php 
					$rowspan_aabr_hearing_screening++; 
					$previous_aabr_hearing_screening .= '<tr class="previous_screening"><td class="'. $hearing_screen_aabr_date_style . '">'. $value->hearing_screen_aabr_date .'</td><td>'. $value->hearing_screen_aabr_right_hand_side .'</td><td>'. $value->hearing_screen_aabr_left_hand_side .'</td><td>'. $value->hearing_screen_aabr_remarks .'</td></tr>';
				@endphp
			@endif
			@if (in_array('oae', json_decode($value->hearing_screen_options)))
				@if ($value->hearing_screen_oae_date == 'DD-MM-YYYY')
					@php $hearing_screen_oae_date_style = 'placeholder-style'; @endphp
				@endif
				@php 
					$rowspan_oae_hearing_screening++; 
					$previous_oae_hearing_screening .= '<tr class="previous_screening"><td class="'. $hearing_screen_oae_date_style . '">'. $value->hearing_screen_oae_date .'</td><td>'. $value->hearing_screen_oae_right_hand_side .'</td><td>'. $value->hearing_screen_oae_left_hand_side .'</td><td>'. $value->hearing_screen_oae_remarks .'</td></tr>';
				@endphp
			@endif
		@endif
		@if (count(json_decode($value->diagnostic_abr_options)) > 0)
			@if (in_array('abr', json_decode($value->diagnostic_abr_options)))
				@if ($value->diagnostic_abr_date == 'DD-MM-YYYY')
					@php $diagnostic_abr_date_style = 'placeholder-style'; @endphp
				@endif
				@php 
					$rowspan_oae_hearing_assessment++; 
					$previous_oae_hearing_assessment .= '<tr class="previous_screening"><td class="'. $diagnostic_abr_date_style . '">'. $value->diagnostic_abr_date .'</td><td>'. $value->diagnostic_abr_right_hand_side .'</td><td>'. $value->diagnostic_abr_left_hand_side .'</td><td>'. $value->diagnostic_abr_remarks .'</td></tr>';
				@endphp
			@endif
			@if (in_array('cpa', json_decode($value->diagnostic_abr_options)))
				@if ($value->diagnostic_cpa_date == 'DD-MM-YYYY')
					@php $diagnostic_cpa_date_style = 'placeholder-style'; @endphp
				@endif
				@php 
					$rowspan_audiometery_hearing_assessment++; 
					$previous_audiometery_hearing_assessment .= '<tr class="previous_screening"><td class="'. $diagnostic_cpa_date_style . '">'. $value->diagnostic_cpa_date .'</td><td>'. $value->diagnostic_cpa_right_hand_side .'</td><td>'. $value->diagnostic_cpa_left_hand_side .'</td><td>'. $value->diagnostic_cpa_remarks .'</td></tr>';
				@endphp
			@endif
		@endif
		@if (count(json_decode($value->head_test)) > 0)
			@if (in_array('ct', json_decode($value->head_test)))
				@if ($value->ct_date == 'DD-MM-YYYY')
					@php $ct_date_style = 'placeholder-style'; @endphp
				@endif
				@php 
					$rowspan_ct++; 
					$previous_ct .= '<tr class="previous_screening"><td class="'. $ct_date_style . '">'. $value->ct_date .'</td><td>'. $value->ct_imperssion .'</td></tr>';
				@endphp
			@endif
			@if (in_array('usg', json_decode($value->head_test)))
				@if ($value->usg_date == 'DD-MM-YYYY')
					@php $usg_date_style = 'placeholder-style'; @endphp
				@endif
				@php 
					$rowspan_usg++; 
					$previous_usg .= '<tr class="previous_screening"><td class="'. $usg_date_style . '">'. $value->usg_date .'</td><td>'. $value->usg_imperssion .'</td></tr>';
				@endphp
			@endif
			@if (in_array('mri', json_decode($value->head_test)))
				@if ($value->mri_date == 'DD-MM-YYYY')
					@php $mri_date_style = 'placeholder-style'; @endphp
				@endif
				@php 
					$rowspan_mri++; 
					$previous_mri .= '<tr class="previous_screening"><td class="'. $mri_date_style . '">'. $value->mri_date .'</td><td>'. $value->mri_imperssion .'</td></tr>';
				@endphp
			@endif
		@endif
	@endforeach
@endif
<div class="screening">
	<div class="overflow-auto">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th colspan="2"></th>
					<th>Date</th>
					<!-- <th>PNA/CA</th> -->
					<th>Right</th>
					<th>Left</th>
					<th>Remarks</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td rowspan="{!! $rowspan_rop !!}">ROP screening</td>
					<td rowspan="{!! $rowspan_rop !!}">{!! Form::checkbox('rop_options[]','rop', null, ['class'=>'rop_check']) !!}</td>
					<td class="rop rop_screening">{!! Form::text('rop_date', null, ['class'=>'form-control screening-date', 'placeholder'=>'DD-MM-YYYY']) !!}</td>
					<!-- <td class="rop rop_screening">{{ Form::text('rop_pna_ca', null, ['class'=>'form-control']) }}</td> -->
					<td class="rop rop_screening">{{ Form::text('rop_right_hand_side', null, ['class'=>'form-control']) }}</td>
					<td class="rop rop_screening">{{ Form::text('rop_left_hand_side', null, ['class'=>'form-control']) }}</td>
					<td class="rop rop_screening">{{ Form::text('rop_remarks', null, ['class'=>'form-control']) }}</td>
				</tr>
				{!! $previous_rop !!}
				<tr>
					<td rowspan="{!! $rowspan_aabr_hearing_screening + $rowspan_oae_hearing_screening !!}">Hearing screening</td>
					<td rowspan="{!! $rowspan_aabr_hearing_screening !!}">(AABR) {!! Form::checkbox('hearing_screen_options[]','aabr', null, ['class'=>'hearing_screen_aabr']) !!}</td>
					<td class="aabr hearing_test_name">{!! Form::text('hearing_screen_aabr_date', null, ['class'=>'form-control screening-date', 'placeholder'=>'DD-MM-YYYY']) !!}</td>
					<!-- <td class="aabr hearing_test_name">{{ Form::text('hearing_screen_aabr_pna_ca', null, ['class'=>'form-control']) }}</td> -->
					<td class="aabr hearing_test_name">{{ Form::select('hearing_screen_aabr_right_hand_side', $right_options, null, ['class'=>'form-control']) }}</td>
					<td class="aabr hearing_test_name">{{ Form::select('hearing_screen_aabr_left_hand_side', $left_options, null, ['class'=>'form-control']) }}</td>
					<td class="aabr hearing_test_name">{{ Form::text('hearing_screen_aabr_remarks', null, ['class'=>'form-control']) }}</td>
				</tr>
				{!! $previous_aabr_hearing_screening !!}
				<tr>
					<td rowspan="{!! $rowspan_oae_hearing_screening !!}">(OAE) {!! Form::checkbox('hearing_screen_options[]','oae', null, ['class'=>'hearing_screen_oae']) !!}</td>
					<td class="oae hearing_test_name">{!! Form::text('hearing_screen_oae_date', null, ['class'=>'form-control screening-date', 'placeholder'=>'DD-MM-YYYY']) !!}</td>
					<!-- <td class="oae hearing_test_name">{{ Form::text('hearing_screen_oae_pna_ca', null, ['class'=>'form-control']) }}</td>					 -->
					<td class="oae hearing_test_name">{{ Form::select('hearing_screen_oae_right_hand_side', $right_options, null, ['class'=>'form-control']) }}</td>					
					<td class="oae hearing_test_name">{{ Form::select('hearing_screen_oae_left_hand_side', $left_options, null, ['class'=>'form-control']) }}</td>					
					<td class="oae hearing_test_name">{{ Form::text('hearing_screen_oae_remarks', null, ['class'=>'form-control']) }}</td>					
				</tr>
				{!! $previous_oae_hearing_screening !!}
				<tr>
					<td rowspan="{!! $rowspan_oae_hearing_assessment + $rowspan_audiometery_hearing_assessment !!}">Hearing Assessment</td>
					<td rowspan="{!! $rowspan_oae_hearing_assessment !!}">Diagnostic ABR {!! Form::checkbox('diagnostic_abr_options[]','abr', null, ['class'=>'diagnostic_abr']) !!}</td>
					<td class="abr diagnostic_test_name">{!! Form::text('diagnostic_abr_date', null, ['class'=>'form-control screening-date', 'placeholder'=>'DD-MM-YYYY']) !!}</td>
					<!-- <td class="abr diagnostic_test_name">{{ Form::text('diagnostic_abr_pna_ca', null, ['class'=>'form-control']) }}</td> -->
					<td class="abr diagnostic_test_name">{{ Form::text('diagnostic_abr_right_hand_side', null, ['class'=>'form-control']) }}</td>
					<td class="abr diagnostic_test_name">{{ Form::text('diagnostic_abr_left_hand_side', null, ['class'=>'form-control']) }}</td>
					<td class="abr diagnostic_test_name">{{ Form::text('diagnostic_abr_remarks', null, ['class'=>'form-control']) }}</td>
				</tr>
				{!! $previous_oae_hearing_assessment !!}
				<tr>
					<td rowspan="{!! $rowspan_audiometery_hearing_assessment !!}">Conditioning Play Audiometery {!! Form::checkbox('diagnostic_abr_options[]','cpa', null, ['class'=>'diagnostic_abr_cpa']) !!}</td>
					<td class="cpa diagnostic_test_name">{!! Form::text('diagnostic_cpa_date', null, ['class'=>'form-control screening-date', 'placeholder'=>'DD-MM-YYYY']) !!}</td>
					<!-- <td class="cpa diagnostic_test_name">{{ Form::text('diagnostic_cpa_pna_ca', null, ['class'=>'form-control']) }}</td> -->
					<td class="cpa diagnostic_test_name">{{ Form::select('diagnostic_cpa_right_hand_side', $right_options, null, ['class'=>'form-control']) }}</td>
					<td class="cpa diagnostic_test_name">{{ Form::select('diagnostic_cpa_left_hand_side', $left_options, null, ['class'=>'form-control']) }}</td>
					<td class="cpa diagnostic_test_name">{{ Form::text('diagnostic_cpa_remarks', null, ['class'=>'form-control']) }}</td>
				</tr>
				{!! $previous_audiometery_hearing_assessment !!}
			</tbody>
		</table>
	</div>
</div>
<div class="head-screening">
	<div class="overflow-auto">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Head Scan</th>
					<th>Date</th>
					<!-- <th>Age</th> -->
					<th>Impression</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td rowspan="{!! $rowspan_ct !!}">CT {!! Form::checkbox('head_test[]','ct', null, ['class'=>'head_test_ct']) !!}</td>
					<td class="ct">{!! Form::text('ct_date', null, ['class'=>'form-control screening-date', 'placeholder'=>'DD-MM-YYYY']) !!}</td>
					<!-- <td class="ct">{!! Form::text('ct_age', null, ['class'=>'form-control ct_age']) !!}</td> -->
					<td class="ct">{{ Form::text('ct_imperssion', null, ['class'=>'form-control']) }}</td>
				</tr>
				{!! $previous_ct !!}
				<tr>
					<td rowspan="{!! $rowspan_usg !!}">USG {!! Form::checkbox('head_test[]','usg', null, ['class'=>'head_test_usg']) !!}</td>
					<td class="usg">{!! Form::text('usg_date', null, ['class'=>'form-control screening-date', 'placeholder'=>'DD-MM-YYYY']) !!}</td>
					<!-- <td class="usg">{!! Form::text('usg_age', null, ['class'=>'form-control usg_age']) !!}</td> -->
					<td class="usg">{{ Form::text('usg_imperssion', null, ['class'=>'form-control']) }}</td>
				</tr>
				{!! $previous_usg !!}
				<tr>
					<td rowspan="{!! $rowspan_mri !!}">MRI {!! Form::checkbox('head_test[]','mri', null, ['class'=>'head_test_mri']) !!}</td>
					<td class="mri">{!! Form::text('mri_date', null, ['class'=>'form-control screening-date', 'placeholder'=>'DD-MM-YYYY']) !!}</td>
					<!-- <td class="mri">{!! Form::text('mri_age', null, ['class'=>'form-control mri_age']) !!}</td> -->
					<td class="mri">{{ Form::text('mri_imperssion', null, ['class'=>'form-control']) }}</td>
				</tr>
				{!! $previous_mri !!}
			</tbody>
		</table>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('#edit-neuro .rop_check').trigger('change');
		$('#edit-neuro .hearing_screen_aabr').trigger('change');
		$('#edit-neuro .hearing_screen_oae').trigger('change');
		$('#edit-neuro .diagnostic_abr').trigger('change');
		$('#edit-neuro .diagnostic_abr_cpa').trigger('change');
		$('#edit-neuro .head_test_ct').trigger('change');
		$('#edit-neuro .head_test_usg').trigger('change');
		$('#edit-neuro .head_test_mri').trigger('change');

		$('#create-neuro .rop_screening .form-control').addClass('display-none');
		$('#create-neuro .hearing_test_name .form-control').addClass('display-none');
		$('#create-neuro .diagnostic_test_name .form-control').addClass('display-none');
		$('#create-neuro .ct input').addClass('display-none');
		$('#create-neuro .usg input').addClass('display-none');
		$('#create-neuro .mri input').addClass('display-none');

        $('.screening-date').datepicker({ dateFormat: 'dd-mm-yy' });

	});

	$(document).on('change', '.rop_check', function() {
		var rop_screen = $(this).prop('checked');
		var value = $(this).val();
		if (rop_screen) {
			$('.' + value + ' .form-control').removeClass('display-none');
		} else {			
			$('.' + value + ' .form-control').addClass('display-none');
		}
	});

	$(document).on('change', '.hearing_screen_aabr', function() {
		var hearing_screen = $(this).prop('checked');
		var value = $(this).val();
		if (hearing_screen) {
			$('.' + value + ' .form-control').removeClass('display-none');
		} else {			
			$('.' + value + ' .form-control').addClass('display-none');
		}
	});

	$(document).on('change', '.hearing_screen_oae', function() {
		var hearing_screen = $(this).prop('checked');
		var value = $(this).val();
		if (hearing_screen) {
			$('.' + value + ' .form-control').removeClass('display-none');
		} else {			
			$('.' + value + ' .form-control').addClass('display-none');
		}
	});

	$(document).on('change', '.diagnostic_abr', function() {
		var diagnostic_abr = $(this).prop('checked');
		var value = $(this).val();
		if (diagnostic_abr) {
			$('.' + value + ' .form-control').removeClass('display-none');
		} else {			
			$('.' + value + ' .form-control').addClass('display-none');
		}
	});

	$(document).on('change', '.diagnostic_abr_cpa', function() {
		var diagnostic_abr = $(this).prop('checked');
		var value = $(this).val();
		if (diagnostic_abr) {
			$('.' + value + ' .form-control').removeClass('display-none');
		} else {			
			$('.' + value + ' .form-control').addClass('display-none');
		}
	});

	$(document).on('change', '.head_test_ct', function() {
		var head_test = $(this).prop('checked');
		if (head_test) {
			$('.ct input').removeClass('display-none');
		} else {			
			$('.ct input').addClass('display-none');
		}
	});

	$(document).on('change', '.head_test_usg', function() {
		var head_test = $(this).prop('checked');
		if (head_test) {
			$('.usg input').removeClass('display-none');
		} else {			
			$('.usg input').addClass('display-none');
		}
	});

	$(document).on('change', '.head_test_mri', function() {
		var head_test = $(this).prop('checked');
		if (head_test) {
			$('.mri input').removeClass('display-none');
		} else {			
			$('.mri input').addClass('display-none');
		}
	});
</script>
