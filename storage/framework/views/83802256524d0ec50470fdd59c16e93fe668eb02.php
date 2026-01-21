<?php $__env->startSection('content'); ?>
<?php
$site_url = url('/').'/public';
?>
<?php echo Form::hidden('baby_id', @$nurse_details_sheet->baby_id); ?>

<?php echo Form::hidden('admission_id', @$nurse_details_sheet->admission_id); ?>

<?php echo Form::hidden('start_time', $start_time); ?>

<?php echo Form::hidden('end_time', $endtime); ?>

<?php echo Form::hidden('approval_status', $approval_status); ?>

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
					<img src="<?php echo e(ValuelistHelpers::printPagelogo($hospital_name), false); ?>">
				</div>
				<div class="col-md-4 col-sm-4 col-xs-12 text-center">
					<h4 class="m-0"><b>Form No. 3A</b></h4>
					<h3>Neonatal Intensive Care Sheet</h3>
				</div>
				<div class="col-md-4 col-sm-4 col-xs-4 plr-must-0 barcode text-center">					
					<?php if(isset($ip_details->ip_number) && !empty($ip_details->ip_number) && !is_null($ip_details->ip_number)): ?>
					<table>
						<tr>
							<td style="padding: 0px !important"></td>
							<td style="padding: 0px 0px 0px 5px !important;">
								<div class="col-md-6 plr-must-0">
									<b style="font-size: 16px;" class="pull-left"><?php echo e($ip_details->ip_number, false); ?></b>
								</div>
								<div class="col-md-6 plr-must-0">
									<span class="baby-mrn"><?php echo e($baby->BMrNo, false); ?></span>
								</div>
							</td>
						</tr>
						<tr>
							<td><b class="hosptial-name">SKSH</b></td>
							<td>
								<span class="barcode-content">
									<?php $ipnumber = str_replace('IP/', '01', $ip_details->ip_number); ?>
									<img src="data:image/png;base64,<?php echo e(\DNS1D::getBarcodePNG($ipnumber, 'C128', 2, 38), false); ?>" alt="barcode" />
								</span>
							</td>
						</tr>
						<tr>
							<td></td>
							<td style="padding-bottom: 0px !important"><?php echo e(str_replace('B/O ', 'Baby of.', $baby->BabyName), false); ?>&nbsp/&nbsp<?php echo e(substr($baby->Sex, 0, 1), false); ?></td>
						</tr>
						<tr>
							<td></td>
							<td style="padding-bottom: 0px !important">
								<!-- <?php echo e(\SiteHelpers::get_doctors_name($baby->neonatal_consultant), false); ?> -->
							</td>
						</tr>
					</table>
					<?php else: ?>
					<span class="empty">Affix Barcode Label Here</span>
					<?php endif; ?>
				</div>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-4 content-center hide pull-right">
				<table>
					<tr>
						<?php if(isset($ip_details->ip_number)): ?>
						<td colspan="2"><?php echo e('IP'.$ip_details->ip_number, false); ?></td>
						<?php else: ?>
						<td></td>
						<?php endif; ?>
					</tr>	
					<tr>
						<td><p class="vericaltext">SKS</p></td>
						<td>
						</td>	
					</tr>
					<tr>
						<td colspan="2"><?php echo e($baby->BMrNo, false); ?></td>
					</tr>
				</table>
			</div>
		</div>

		<div class="col-md-12 col-sm-12 col-xs-12 basic-detail plr-must-0">
			<h4 class="mt-10 mb-5 plr-15 pull-left">Basic Details</h4>
			<?php $sheetdate = explode(' ', $sheet_date); ?>
			<?php if($last_column_span > 0): ?>
				<h4 class="mt-10 mb-5 plr-15 pull-right"><?php echo e($sheet_date, false); ?></h4>
			<?php else: ?>
				<h4 class="mt-10 mb-5 plr-15 pull-right"><?php echo e($sheetdate[0], false); ?></h4>
			<?php endif; ?>
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="content-block">				
					<div class="section-set"> 	
						<div class="col-xs-12 col-sm-4 col-md-4">
							<div class="form-group">
								<span class="print-label">Baby Name:</span>
								<span class="print-value text-captialize"><?php echo e($baby->BabyName, false); ?></span>
							</div>  
							<div class="form-group">
								<span class="print-label"><?php echo e(Lang::get('home.ip'), false); ?>:</span>
								<span class="print-value"><?php echo e(@$ip_details->ip_number, false); ?></span>
							</div>
						</div>
					</div>
					<div class="section-set"> 	
						<div class="col-xs-12 col-sm-4 col-md-4">
							<div class="form-group">
								<span class="print-label"><?php echo e(Lang::get('home.mrn'), false); ?>:</span>
								<span class="print-value text-captialize"><?php echo e($baby->BMrNo, false); ?></span>
							</div>
							<div class="form-group">
								<span class="print-label">Room No.:</span>
								<span class="print-value"><?php echo e(@$bed_details->room_name, false); ?></span>
							</div>
						</div>
					</div>
					<div class="section-set"> 	
						<div class="col-xs-12 col-sm-4 col-md-4">
							<br/>
							<div class="form-group">
								<span class="print-label">Cot No.:</span>
								<span class="print-value"><?php echo e(@$bed_details->bed_name, false); ?></span>
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
								<span class="print-value text-captialize"><?php echo e($baby->BabyName, false); ?></span>
							</div>   -->
							<div class="form-group">
								<span class="print-label">DOB:</span>
								<span class="print-value text-captialize"><?php echo e(empty($baby->DOB) ? '' : date('d-m-Y', strtotime($baby->DOB)), false); ?></span>
							</div>
							<div class="form-group">
								<span class="print-label">Age:</span>
								<span class="print-value"><?php echo e(SiteHelpers::calculate_day_of_life_two($baby->DOB, $current_date, true), false); ?></span>
							</div>   
							<div class="form-group">
								<span class="print-label">Gestation:</span>
								<span class="print-value"><?php echo e(SiteHelpers::decode_gestation($baby->Gestation), false); ?></span>
							</div>
							<div class="form-group">
								<span class="print-label">Corrected Gestation:</span>
								<span class="print-value"><?php echo e(($baby->Gestation != '' && $corrected_gestation != 0) ? $corrected_gestation : '', false); ?></span>
							</div>
						</div>
					</div>
					<div class="section-set">
						<div class="col-xs-12 col-sm-4 col-md-4">
							<div class="form-group">
								<span class="print-label">Sex:</span>
								<span class="print-value"><?php echo e($baby->Sex, false); ?></span>
							</div>    		
							<div class="form-group">
								<span class="print-label">Birth Weight:</span>
								<span class="print-value"><?php echo e($baby->BirthWeight, false); ?></span>
							</div>
							<div class="form-group">
								<span class="print-label">Working Weight:</span>
								<span class="print-value"><?php echo e(@$working_weight, false); ?></span>
							</div>   
							<div class="form-group">
								<span class="print-label">Baby's Blood Group:</span>
								<span class="print-value"><?php if($baby->BabyBloodGroup != 'Not Known'): ?><?php echo e($baby->BabyBloodGroup, false); ?> <?php endif; ?></span>
							</div>
						</div>
					</div> 
					<div class="section-set">
						<div class="col-xs-12 col-sm-4 col-md-4">
							<div class="form-group">
								<span class="print-label">ETT Size:</span>
								<span class="print-value"><?php echo e(empty($et_size) ? '-' : $et_size, false); ?></span>
							</div>
							<div class="form-group">
								<span class="print-label">ETT Length:</span>
								<span class="print-value"><?php echo e(empty($et_length) ? '-' : $et_length, false); ?></span>
							</div>
							<div class="form-group">
								<span class="print-label">NGT Size:</span>
								<span class="print-value"><?php echo e(empty($ngt_size) ? '-' : $ngt_size, false); ?></span>
							</div>
							<div class="form-group">
								<span class="print-label">NGT Length:</span>
								<span class="print-value"><?php echo e(empty($ngt_length) ? '-' : $ngt_length, false); ?></span>
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
						<?php if($last_column_span > 0): ?>
							<tr>
								<th rowspan="2" class="sticky">Date & Time</th>
								<th class="date-col" colspan="<?php echo e($first_column_span, false); ?>"><?php echo e($sheetdate[0], false); ?></th>
								<th class="date-col" colspan="<?php echo e($last_column_span, false); ?>"><?php echo e($sheetdate[3], false); ?></th>
							</tr>
						<?php endif; ?>
						<tr>
							<?php if($last_column_span == 0): ?>
								<th class="sticky">Date & Time</th>
							<?php endif; ?>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php $slot = explode(":", $slots)[1]; ?>
							<?php $slot1 = explode(":", $slots)[2]; ?>
							<th><?php echo e($slot, false); ?>:<?php echo e($slot1, false); ?></th>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>		    			
						</tr>
					</thead>
					<tbody>	
						<tr>
							<td>Type of Care</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'type_of_care')->first(); ?>
							<td>
								<?php if(!empty($values['intf_ref_value'])): ?>
								<?php if($values['intf_ref_value'] == 'Intensive Care'): ?>
								IC
								<?php elseif($values['intf_ref_value'] == 'High Dependancy Care'): ?>
								HD
								<?php elseif($values['intf_ref_value'] == 'Special Care'): ?>
								SC
								<?php elseif($values['intf_ref_value'] == 'N/A'): ?> -
								<?php else: ?>
								<?php echo e($values['intf_ref_value'], false); ?>

								<?php endif; ?>	
								<?php else: ?> 
								-
								<?php endif; ?>
							</td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>       		   
						<tr>
							<td>Warmer Temp&nbsp(C/F)</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $baby_observe[1])->first(); ?>
							<td>
								<?php if(!empty($values['intf_ref_value'])): ?>
								<?php echo e($values['intf_ref_value'], false); ?>

								<?php else: ?> 
								-
								<?php endif; ?>
							</td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Incubator Temp&nbsp(C/F)</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $baby_observe[2])->first(); ?>
							<td>
								<?php if(!empty($values['intf_ref_value'])): ?>
								<?php echo e($values['intf_ref_value'], false); ?>

								<?php else: ?> 
								-
								<?php endif; ?>
							</td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Measured Baby Temp&nbsp(C/F)</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $baby_observe[3])->first(); ?>
							<?php if(!empty($values['intf_ref_value'])): ?>
							<td>
								<?php echo e($values['intf_ref_value'], false); ?>

							</td>
							<?php else: ?> 
							<td>-</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<?php if($baby->BabyId != '4527'): ?>
						<tr>
							<td>Monitor - Temp&nbsp(C/F)</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $baby_observe[4])->first(); ?>
							<?php if(!empty($values['intf_ref_value'])): ?>
							<?php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							?>
							<td class="<?php echo e(($values['is_approved'] == false && $approval_status && $created_by == $monitor_user) ? 'bg-warninggg' : '', false); ?>" data-id="<?php echo e($values['id'], false); ?>">
								<?php echo e(is_numeric($values['intf_ref_value']) ? number_format($values['intf_ref_value'], 1) : $values['intf_ref_value'], false); ?>

							</td>
							<?php else: ?> 
							<td>-</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<?php endif; ?>
						<tr>
							<td>Therapeutic Hypothermia</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'therapeutic_hypothermia')->first(); ?>
							<td>
								<?php if(!empty($values['intf_ref_value'])): ?>
								<?php echo e(($values['intf_ref_value'] == 'on') ? 'Yes' : 'No', false); ?>

								<?php else: ?> 
								-
								<?php endif; ?>
							</td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Rectal Temp&nbsp(C/F)</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $baby_observe[5])->first(); ?>
							<td>
								<?php if(!empty($values['intf_ref_value'])): ?>
								<?php echo e($values['intf_ref_value'], false); ?>

								<?php else: ?> 
								-
								<?php endif; ?>
							</td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Heart Rate <span>(Beats/Min)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $baby_observe[6])->first(); ?>
							<?php if(!empty($values['intf_ref_value'])): ?>
							<?php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							?>
							<td class="<?php echo e(($values['is_approved'] == false && $approval_status && $created_by == $monitor_user) ? 'bg-warninggg' : '', false); ?>" data-id="<?php echo e($values['id'], false); ?>"><?php echo e(round($values['intf_ref_value']), false); ?></td>
							<?php else: ?> 
							<td>-</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>RR(Measured) <span>(RR/Min)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $baby_observe[19])->first(); ?>
							<td>
								<?php if(!empty($values['intf_ref_value'])): ?>
								<?php echo e(round($values['intf_ref_value']), false); ?>

								<?php else: ?> 
								-
								<?php endif; ?>
							</td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>RR(Monitor) <span>(RR/Min)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $baby_observe[7])->first(); ?>
							<?php if(!empty($values['intf_ref_value'])): ?>
							<?php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							?>
							<td class="<?php echo e(($values['is_approved'] == false && $approval_status && $created_by == $monitor_user) ? 'bg-warninggg' : '', false); ?>" data-id="<?php echo e($values['id'], false); ?>">
								<?php echo e(round($values['intf_ref_value']), false); ?>

							</td>
							<?php else: ?> 
							<td>-</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Cuff Systolic BP <span>(mm Hg)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $baby_observe[9])->first(); ?>
							<?php if(!empty($values['intf_ref_value'])): ?>
							<?php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							?>
							<td class="<?php echo e(($values['is_approved'] == false && $approval_status && $created_by == $monitor_user) ? 'bg-warninggg' : '', false); ?>" data-id="<?php echo e($values['id'], false); ?>">
								<?php echo e(round($values['intf_ref_value']), false); ?>

							</td>
							<?php else: ?> 
							<td>-</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Cuff Diastolic BP <span>(mm Hg)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $baby_observe[10])->first(); ?>
							<?php if(!empty($values['intf_ref_value'])): ?>
							<?php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							?>
							<td class="<?php echo e(($values['is_approved'] == false && $approval_status && $created_by == $monitor_user) ? 'bg-warninggg' : '', false); ?>" data-id="<?php echo e($values['id'], false); ?>">
								<?php echo e(round($values['intf_ref_value']), false); ?>

							</td>
							<?php else: ?> 
							<td>-</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Cuff Mean BP <span>(mm Hg)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $baby_observe[11])->first(); ?>
							<?php if(!empty($values['intf_ref_value'])): ?>
							<?php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							?>
							<td class="<?php echo e(($values['is_approved'] == false && $approval_status && $created_by == $monitor_user) ? 'bg-warninggg' : '', false); ?>" data-id="<?php echo e($values['id'], false); ?>">
								<?php echo e(round($values['intf_ref_value']), false); ?>

							</td>
							<?php else: ?> 
							<td>-</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Arterial Systolic BP <span>(mm Hg)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $baby_observe[12])->first(); ?>
							<?php if(!empty($values['intf_ref_value'])): ?>
							<?php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							?>
							<td class="<?php echo e(($values['is_approved'] == false && $approval_status && $created_by == $monitor_user) ? 'bg-warninggg' : '', false); ?>" data-id="<?php echo e($values['id'], false); ?>">
								<?php echo e(round($values['intf_ref_value']), false); ?>

							</td>
							<?php else: ?> 
							<td>-</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Arterial Diastolic BP <span>(mm Hg)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $baby_observe[13])->first(); ?>
							<?php if(!empty($values['intf_ref_value'])): ?>
							<?php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							?>
							<td class="<?php echo e(($values['is_approved'] == false && $approval_status && $created_by == $monitor_user) ? 'bg-warninggg' : '', false); ?>" data-id="<?php echo e($values['id'], false); ?>">
								<?php echo e(round($values['intf_ref_value']), false); ?>

							</td>
							<?php else: ?> 
							<td>-</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Arterial Mean BP <span>(mm Hg)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $baby_observe[14])->first(); ?>
							<?php if(!empty($values['intf_ref_value'])): ?>
							<?php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							?>
							<td class="<?php echo e(($values['is_approved'] == false && $approval_status && $created_by == $monitor_user) ? 'bg-warninggg' : '', false); ?>" data-id="<?php echo e($values['id'], false); ?>">
								<?php echo e(round($values['intf_ref_value']), false); ?>

							</td>
							<?php else: ?> 
							<td>-</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Preductal SaO<sub>2</sub> (%)</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $baby_observe[15])->first(); ?>
							<?php if(!empty($values['intf_ref_value'])): ?>
							<?php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							?>
							<td class="<?php echo e(($values['is_approved'] == false && $approval_status && $created_by == $monitor_user) ? 'bg-warninggg' : '', false); ?>" data-id="<?php echo e($values['id'], false); ?>">
								<?php echo e(round($values['intf_ref_value']), false); ?>

							</td>
							<?php else: ?> 
							<td>-</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Postductal SaO<sub>2</sub> (%)</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $baby_observe[16])->first(); ?>
							<?php if(!empty($values['intf_ref_value'])): ?>
							<?php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							?>
							<td class="<?php echo e(($values['is_approved'] == false && $approval_status && $created_by == $monitor_user) ? 'bg-warninggg' : '', false); ?>" data-id="<?php echo e($values['id'], false); ?>">
								<?php echo e(round($values['intf_ref_value']), false); ?>

							</td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Perfusion Index (%)</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'perfusion_index')->first(); ?>
							<?php if(!empty($values['intf_ref_value'])): ?>
							<?php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							?>
							<td class="<?php echo e(($values['is_approved'] == false && $approval_status && $created_by == $monitor_user) ? 'bg-warninggg' : '', false); ?>" data-id="<?php echo e($values['id'], false); ?>">
								<?php echo e(is_numeric($values['intf_ref_value']) ? number_format($values['intf_ref_value'], 2) : $values['intf_ref_value'], false); ?>

							</td>
							<?php else: ?> 
							<td>-</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Oxyen Saturation <span>Index</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'oxygen_saturation_index')->first(); ?>
							<td>
								<?php if(!empty($values['intf_ref_value'])): ?>
								<?php echo e(is_numeric($values['intf_ref_value']) ? number_format($values['intf_ref_value'], 2) : $values['intf_ref_value'], false); ?>

								<?php else: ?> 
								-
								<?php endif; ?>
							</td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>rSO2 (1)</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $respiratorty_support[27])->where('intf_ref_value', '!=', NULL)->first(); ?>
							<?php if(isset($values['intf_ref_value']) && !empty($values['intf_ref_value'])): ?>
							<?php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							?>
							<td class="<?php echo e(($values['is_approved'] == false && $approval_status && $created_by == $monitor_user) ? 'bg-warninggg' : '', false); ?>" data-id="<?php echo e($values['id'], false); ?>">
								<?php echo e($values['intf_ref_value'], false); ?>

							</td>
							<?php else: ?> 
							<td>-</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Baseline rSO2 (1)</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $respiratorty_support[29])->where('intf_ref_value', '!=', NULL)->first(); ?>
							<?php if(isset($values['intf_ref_value']) && !empty($values['intf_ref_value'])): ?>
							<?php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							?>
							<td class="<?php echo e(($values['is_approved'] == false && $approval_status && $created_by == $monitor_user) ? 'bg-warninggg' : '', false); ?>" data-id="<?php echo e($values['id'], false); ?>">
								<?php echo e($values['intf_ref_value'], false); ?>

							</td>
							<?php else: ?> 
							<td>-</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>rSO2 (2)</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $respiratorty_support[28])->where('intf_ref_value', '!=', NULL)->first(); ?>
							<?php if(isset($values['intf_ref_value']) && !empty($values['intf_ref_value'])): ?>
							<?php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							?>
							<td class="<?php echo e(($values['is_approved'] == false && $approval_status && $created_by == $monitor_user) ? 'bg-warninggg' : '', false); ?>" data-id="<?php echo e($values['id'], false); ?>">
								<?php echo e($values['intf_ref_value'], false); ?>

							</td>
							<?php else: ?> 
							<td>-</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Baseline rSO2 (2)</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $respiratorty_support[30])->where('intf_ref_value', '!=', NULL)->first(); ?>
							<?php if(isset($values['intf_ref_value']) && !empty($values['intf_ref_value'])): ?>
							<?php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							?>
							<td class="<?php echo e(($values['is_approved'] == false && $approval_status && $created_by == $monitor_user) ? 'bg-warninggg' : '', false); ?>" data-id="<?php echo e($values['id'], false); ?>">
								<?php echo e($values['intf_ref_value'], false); ?>

							</td>
							<?php else: ?> 
							<td>-</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>HeRO Score </td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'hero_score')->first(); ?>
							<?php if(!empty($values['intf_ref_value'])): ?>
							<td>
								<?php echo e(is_numeric($values['intf_ref_value']) ? number_format($values['intf_ref_value'], 2) : $values['intf_ref_value'], false); ?>

							</td>
							<?php else: ?> 
							<td>-</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>N-SOFA Score </td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($n_sofa_score[$slots])): ?>
							<td>
								<?php echo e($n_sofa_score[$slots], false); ?>

							</td>
							<?php else: ?> 
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Color</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $baby_observe[17])->first(); ?>
							<td>
								<div class="wrap">
									<?php if(!empty($values['intf_ref_value'])): ?>
									<?php if($values['intf_ref_value'] =='Acral Cyanosis'): ?>
									AC
									<?php elseif($values['intf_ref_value'] =='Central Cyanosis'): ?>
									CC
									<?php elseif($values['intf_ref_value'] =='Pale-Pink'): ?> 
									PP
									<?php else: ?>
									<?php echo e($values['intf_ref_value'], false); ?> 
									<?php endif; ?>	
									<?php else: ?> 
									-
									<?php endif; ?>
								</div>
							</td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Phototherapy</td>
							<?php $value = ''; ?>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($phototherapy[$slots]) && count($phototherapy[$slots]) > 0): ?>
							
							<?php $__currentLoopData = $phototherapy[$slots]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $values): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(!empty($values)): ?>
							<?php $value = $values; ?>
							<td><?php echo e(($value == 'on') ? 'Yes' : 'No', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Eyes Covered</td>
							<?php $value = ''; ?>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($phototherapy_eyes[$slots]) && count($phototherapy_eyes[$slots]) > 0): ?>
							<?php $__currentLoopData = $phototherapy_eyes[$slots]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $values): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(!empty($values)): ?>
							<?php $value = $values; ?>
							<td><?php echo e(($value == 'on' || $value == 'Yes') ? 'Yes' : 'No', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
						</tr>
						<tr>
							<td>
								<div class="active-tb">Activity</div>
							</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $baby_observe[18])->first(); ?>
							<td>
								<div class="activity">
									<?php if(!empty($values['intf_ref_value'])): ?>
									<?php if(strtolower($values['intf_ref_value']) == strtolower('Sleep')): ?>
									S
									<?php elseif(strtolower($values['intf_ref_value']) == strtolower('Normal')): ?>
									N
									<?php elseif(strtolower($values['intf_ref_value']) == strtolower('Lethargic')): ?>
									L
									<?php elseif(strtolower($values['intf_ref_value']) == strtolower('Comatosed')): ?>
									C 
									<?php elseif(strtolower($values['intf_ref_value']) == strtolower('Sedated / paralysed')): ?>
									SP 
									<?php elseif(strtolower($values['intf_ref_value']) == strtolower('normal')): ?>
									N
									<?php elseif(strtolower($values['intf_ref_value']) == strtolower('N/A')): ?>
									-
									<?php else: ?>
									<?php echo e($values['intf_ref_value'], false); ?>


									<?php endif; ?>
									<?php else: ?> 
									-
									<?php endif; ?>
								</div>
							</td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Position</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'position')->first(); ?>
							<td>
								<?php if(!empty($values['intf_ref_value']) && $values['intf_ref_value'] != 'N/A'): ?>
								<?php if($values['intf_ref_value'] == 'supine'): ?>
								Sup
								<?php elseif($values['intf_ref_value'] =='prone'): ?>
								Pro
								<?php elseif($values['intf_ref_value'] =='lateral'): ?>
								Lat
								<?php else: ?>
								<?php echo e($values['intf_ref_value'], false); ?>

								<?php endif; ?>   	
								<?php else: ?> 
								-
								<?php endif; ?>
							</td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
						<?php if($last_column_span > 0): ?>
							<tr>
								<th rowspan="2" class="sticky">Date & Time</th>
								<th class="date-col" colspan="<?php echo e($first_column_span, false); ?>"><?php echo e($sheetdate[0], false); ?></th>
								<th class="date-col" colspan="<?php echo e($last_column_span, false); ?>"><?php echo e($sheetdate[3], false); ?></th>
							</tr>
						<?php endif; ?>
						<tr>
							<?php if($last_column_span == 0): ?>
								<th class="sticky">Date & Time</th>
							<?php endif; ?>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php $slot = explode(":", $slots)[1]; ?>
							<?php $slot1 = explode(":", $slots)[2]; ?>
							<th><?php echo e($slot, false); ?>:<?php echo e($slot1, false); ?></th>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<div class="active-tb">Work Of Breathing</div>
							</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $respiratorty_support[0])->first(); ?>
							<td>
								<div>
									<?php if(!empty($values['intf_ref_value']) && $values['intf_ref_value'] != 'N/A'): ?>
									<?php if($values['intf_ref_value'] == 'Improved'): ?>
									IMP
									<?php elseif($values['intf_ref_value'] == 'Deteriorated'): ?>
									D
									<?php elseif($values['intf_ref_value'] == 'Stable'): ?>
									Stab
									<?php else: ?>
									<?php echo e($values['intf_ref_value'], false); ?>

									<?php endif; ?> 	
									<?php else: ?> 
									-
									<?php endif; ?>
								</div>
							</td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Mode Of Invasive <br/>Respiratory Support:</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $respiratorty_support[1])->first(); ?>
							<?php $values1 = collect($temp_data)->where('local_code', $respiratorty_support[31])->first(); ?>
							
							<?php if(!empty($values['intf_ref_value']) && in_array($values['intf_ref_value'], $invasive_ventilation) || !empty($values1['intf_ref_value']) && in_array($values1['intf_ref_value'], $invasive_ventilation)): ?>

							<?php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							?>

							<td class="<?php echo e(($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : '', false); ?>" data-id="<?php echo e($values['id'], false); ?>">
								<?php if($values['intf_ref_value'] =='High Flow O2' || $values1['intf_ref_value'] =='High Flow O2'): ?>
								HFNC
								<?php elseif($values['intf_ref_value']=='HHHFNC' || $values1['intf_ref_value']=='HHHFNC'): ?>
								HFNC	
								<?php elseif($values['intf_ref_value']=='CPAP' || $values1['intf_ref_value']=='CPAP'): ?>
								CPAP
								<?php elseif($values['intf_ref_value']=='BiPAP' || $values1['intf_ref_value']=='BiPAP'): ?>
								BPAP
								<?php elseif($values['intf_ref_value']=='NIPPV' || $values1['intf_ref_value']=='NIPPV'): ?>
								NIPV
								<?php elseif($values['intf_ref_value']=='Nasal HFOV' || $values1['intf_ref_value']=='Nasal HFOV'): ?>
								HFOV(n)
								<?php elseif($values['intf_ref_value']=='HBO2' || $values1['intf_ref_value']=='HBO2'): ?>
								HBO2
								<?php elseif($values['intf_ref_value']=='NPO2' || $values1['intf_ref_value']=='NPO2'): ?>
								NPO2
								<?php elseif($values['intf_ref_value']=='Incubator O2' || $values1['intf_ref_value']=='Incubator O2'): ?>
								InO2   	
								<?php elseif(!empty($values['intf_ref_value'])): ?>
								<?php echo e($values['intf_ref_value'], false); ?>   	
								<?php elseif(!empty($values1['intf_ref_value'])): ?>
								<?php echo e($values1['intf_ref_value'], false); ?>

								<?php endif; ?>
							</td>
							<?php else: ?> 
							<td>-</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Mode Of Non-Invasive <br/>Respiratory Support:</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $respiratorty_support[31])->first(); ?>
							<?php $values1 = collect($temp_data)->where('local_code', $respiratorty_support[1])->first(); ?>
							<?php if(!empty($values['intf_ref_value']) && in_array($values['intf_ref_value'], $non_invasive_ventilation) || !empty($values1['intf_ref_value']) && in_array($values1['intf_ref_value'], $non_invasive_ventilation)): ?>
							<?php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							?>
							<td class="<?php echo e(($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : '', false); ?>" data-id="<?php echo e($values['id'], false); ?>">
								<?php if($values['intf_ref_value'] =='High Flow O2' || $values1['intf_ref_value'] =='High Flow O2'): ?>
								HFNC
								<?php elseif($values['intf_ref_value']=='HHHFNC' || $values1['intf_ref_value']=='HHHFNC'): ?>
								HFNC	
								<?php elseif($values['intf_ref_value']=='CPAP' || $values1['intf_ref_value']=='CPAP'): ?>
								CPAP
								<?php elseif($values['intf_ref_value']=='BiPAP' || $values1['intf_ref_value']=='BiPAP'): ?>
								BPAP
								<?php elseif(($values['intf_ref_value']=='NIPPV Tr' || $values1['intf_ref_value']=='NIPPV Tr') || ($values['intf_ref_value']=='nippv tr' || $values1['intf_ref_value']=='nippv tr')): ?>
								NIPPV
								<?php elseif($values['intf_ref_value']=='NIPPV (D)' || $values1['intf_ref_value']=='NIPPV (D)'): ?>
								NIPPV
								<?php elseif($values['intf_ref_value']=='Nasal HFOV' || $values1['intf_ref_value']=='Nasal HFOV'): ?>
								HFOV(n)
								<?php elseif($values['intf_ref_value']=='HBO2' || $values1['intf_ref_value']=='HBO2'): ?>
								HBO2
								<?php elseif($values['intf_ref_value']=='NPO2' || $values1['intf_ref_value']=='NPO2'): ?>
								NPO2
								<?php elseif($values['intf_ref_value']=='Incubator O2' || $values1['intf_ref_value']=='Incubator O2'): ?>
								InO2	
								<?php elseif($values['intf_ref_value']=='SV' || $values1['intf_ref_value']=='SV'): ?>
								SVA						   	  		     	
								<?php elseif($values['intf_ref_value']=='NCPAP (D)' || $values1['intf_ref_value']=='NCPAP (D)'): ?>
								NCPAP (D)						   	  		     	
								<?php elseif($values['intf_ref_value']=='NHFOV (D)' || $values1['intf_ref_value']=='NHFOV (D)'): ?>
								NHFOV (D)						   	  		     	
								<?php elseif($values['intf_ref_value']=='NCPAP (S)' || $values1['intf_ref_value']=='NCPAP (S)'): ?>
								NCPAP (S)						   	  		     	
								<?php elseif($values['intf_ref_value']=='DUOPAP' || $values1['intf_ref_value']=='DUOPAP'): ?>
								DUOPAP							   	  		     	
								<?php elseif($values['intf_ref_value']=='nCPAP (D)' || $values1['intf_ref_value']=='nCPAP (D)'): ?>
								nCPAP (D)				   	  		     	
								<?php elseif(!empty($values['intf_ref_value'])): ?>
								<?php echo e($values['intf_ref_value'], false); ?>

								<?php elseif(!empty($values1['intf_ref_value'])): ?>
								<?php echo e($values1['intf_ref_value'], false); ?>

								<?php endif; ?>
							</td>
							<?php else: ?> 
							<td>-</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Volume Targeting</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>

							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php 
							$values = collect($temp_data)->where('local_code', $respiratorty_support[22])->first(); 
							$mode_of_ventilation = collect($temp_data)->where('local_code', $respiratorty_support[1])->where('intf_ref_value', '!=', NULL)->first();
							?>
							<td>
								<?php if(isset($values['intf_ref_value']) && !empty($values['intf_ref_value']) && !in_array($mode_of_ventilation['intf_ref_value'], $non_invasive)): ?>
								<?php echo e(($values['intf_ref_value'] == 'on') ? 'Yes' : 'No', false); ?>

								<?php elseif(isset($mode_of_ventilation['intf_ref_value']) && !empty($mode_of_ventilation['intf_ref_value'])  && !in_array($mode_of_ventilation['intf_ref_value'], $non_invasive)): ?>
								No
								<?php else: ?>
								-
								<?php endif; ?>
							</td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>

						<tr>
							<td>Targeted Tidal Vol <span>(ml)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $respiratorty_support[3])->first(); ?>
							<?php if(!empty($values['intf_ref_value'])): ?>
							<?php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							?>
							<td class="<?php echo e(($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : '', false); ?>" data-id="<?php echo e($values['id'], false); ?>">
								<?php echo e(is_numeric($values['intf_ref_value']) ? number_format($values['intf_ref_value'], 1) : $values['intf_ref_value'], false); ?>

							</td>
							<?php else: ?> 
							<td>
								-
							</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>	 
						<tr>
							<td>Delivered Tidal Vol <span>(ml)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $respiratorty_support[11])->first(); ?>
							<?php if(!empty($values['intf_ref_value'])): ?>
							<?php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							?>
							<td class="<?php echo e(($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : '', false); ?>" data-id="<?php echo e($values['id'], false); ?>">
								<?php echo e(is_numeric($values['intf_ref_value']) ? number_format($values['intf_ref_value'], 1) : $values['intf_ref_value'], false); ?>

							</td>
							<?php else: ?> 
							<td>
								-
							</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>   		   
						<tr>
							<td>&Delta; P/Amplitude</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $respiratorty_support[4])->first(); ?>
							<?php if(!empty($values['intf_ref_value'])): ?>
							<?php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							?>
							<td class="<?php echo e(($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : '', false); ?>" data-id="<?php echo e($values['id'], false); ?>">
								<?php echo e($values['intf_ref_value'], false); ?>

							</td>
							<?php else: ?> 
							<td>
								-
							</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>PIP Settings</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $respiratorty_support[5])->first(); ?>
							<?php if(!empty($values['intf_ref_value'])): ?>
							<?php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							?>
							<td class="<?php echo e(($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : '', false); ?>" data-id="<?php echo e($values['id'], false); ?>">
								<?php echo e($values['intf_ref_value'], false); ?>

							</td>
							<?php else: ?> 
							<td>
								-
							</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>PIP Delivered</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $respiratorty_support[6])->first(); ?>
							<?php if(!empty($values['intf_ref_value'])): ?>
							<?php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							?>
							<td class="<?php echo e(($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : '', false); ?>" data-id="<?php echo e($values['id'], false); ?>">
								<?php echo e(is_numeric($values['intf_ref_value']) ? number_format($values['intf_ref_value'], 1) : $values['intf_ref_value'], false); ?>

							</td>
							<?php else: ?> 
							<td>
								-
							</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>PEEP</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $respiratorty_support[7])->first(); ?>
							<?php if(!empty($values['intf_ref_value'])): ?>
							<?php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							?>
							<td class="<?php echo e(($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : '', false); ?>" data-id="<?php echo e($values['id'], false); ?>">
								<?php echo e($values['intf_ref_value'], false); ?>

							</td>
							<?php else: ?> 
							<td>
								-
							</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>MAP (Ventilator data)</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $respiratorty_support[8])->first(); ?>
							<?php if(!empty($values['intf_ref_value'])): ?>
							<?php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							?>
							<td class="<?php echo e(($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : '', false); ?>" data-id="<?php echo e($values['id'], false); ?>">
								<?php echo e($values['intf_ref_value'], false); ?>

							</td>
							<?php else: ?> 
							<td>
								-
							</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>

						<tr>
							<td>MAP (Calculated)</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>

                            <?php 
                                $peep_delivered = collect($temp_data)->where('local_code', $respiratorty_support[7])->first(); 
                                $pip_delivered = collect($temp_data)->where('local_code', $respiratorty_support[6])->first(); 
                                $it_s = collect($temp_data)->where('local_code', $respiratorty_support[15])->first();
                                $rr_set = collect($temp_data)->where('local_code', $respiratorty_support[12])->first();
                            ?>
							<?php if(
                                !empty($peep_delivered['intf_ref_value']) && is_numeric($peep_delivered['intf_ref_value']) &&
                                !empty($pip_delivered['intf_ref_value']) && is_numeric($pip_delivered['intf_ref_value']) &&
                                !empty($it_s['intf_ref_value']) && is_numeric($it_s['intf_ref_value']) &&
                                !empty($rr_set['intf_ref_value']) && is_numeric($rr_set['intf_ref_value'])
                            ): ?>
							<?php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
                            $map = $peep_delivered['intf_ref_value'] + ($pip_delivered['intf_ref_value'] - $peep_delivered['intf_ref_value']) * ($it_s['intf_ref_value'] * $rr_set['intf_ref_value'] / 60)
							?>
							<td class="<?php echo e(($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : '', false); ?>" data-id="<?php echo e($values['id'], false); ?>">
								<?php echo e(number_format($map, 2), false); ?>

							</td>
							<?php else: ?> 
							<td>
								-
							</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Oxygenie (CLACO)</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>

							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php 
							$values = collect($temp_data)->where('local_code', $respiratorty_support[32])->first(); 
							?>
							<?php if(isset($values['intf_ref_value']) && !empty($values['intf_ref_value'])): ?>
							<?php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							?>
							<td class="<?php echo e(($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : '', false); ?>" data-id="<?php echo e($values['id'], false); ?>">
								<?php echo e(($values['intf_ref_value'] == '2' || $values['intf_ref_value'] == '4' || $values['intf_ref_value'] == '3') ? 'Yes' : '-', false); ?>

							</td>
							<?php else: ?>
							<td>
								-
							</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Target SpO<sub>2</sub> range</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php 
							$values = collect($temp_data)->where('local_code', $respiratorty_support[35])->first(); 
							$oxygenie_values = collect($temp_data)->where('local_code', $respiratorty_support[32])->first(); 
							?>
							<?php if(!empty($values['intf_ref_value']) && ($oxygenie_values['intf_ref_value'] == '2' || $oxygenie_values['intf_ref_value'] == '4' || $oxygenie_values['intf_ref_value'] == '3')): ?>
							<?php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							?>
							<td class="<?php echo e(($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : '', false); ?>" data-id="<?php echo e($values['id'], false); ?>">
								<?php echo e(\SiteHelpers::ventilatorAutoO2TargetRange($values['intf_ref_value']), false); ?>

							</td>
							<?php else: ?> 
							<td>-</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>FiO<sub>2</sub> % (Set)</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $respiratorty_support[9])->first(); ?>
							<?php if(!empty($values['intf_ref_value'])): ?>
							<?php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							?>
							<td class="<?php echo e(($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : '', false); ?>" data-id="<?php echo e($values['id'], false); ?>">
								<?php echo e($values['intf_ref_value'], false); ?>

							</td>
							<?php else: ?> 
							<td>-</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>FiO<sub>2</sub> % (Delivered)</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $oxygene_mode = collect($temp_data)->where('local_code', $respiratorty_support[32])->first(); ?>
							<?php $values = collect($temp_data)->where('local_code', $respiratorty_support[33])->first(); ?>
							<?php if(isset($oxygene_mode['intf_ref_value']) && !empty($oxygene_mode['intf_ref_value']) && ($oxygene_mode['intf_ref_value'] == '2' || $oxygene_mode['intf_ref_value'] == '4' || $oxygene_mode['intf_ref_value'] == '3')): ?>
							<?php if(!empty($values['intf_ref_value'])): ?>
							<?php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							?>
							<td class="<?php echo e(($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : '', false); ?>" data-id="<?php echo e($values['id'], false); ?>">
								<?php echo e($values['intf_ref_value'], false); ?>

							</td>
							<?php else: ?> 
							<td>-</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Ventilator SpO<sub>2</sub></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php 
							$values = collect($temp_data)->where('local_code', $respiratorty_support[34])->first(); 
							$oxygenie_values = collect($temp_data)->where('local_code', $respiratorty_support[32])->first(); 
							?>
							<?php if(!empty($values['intf_ref_value']) && ($oxygenie_values['intf_ref_value'] == '2' || $oxygenie_values['intf_ref_value'] == '4' || $oxygenie_values['intf_ref_value'] == '3')): ?>
							<?php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							?>
							<td class="<?php echo e(($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : '', false); ?>" data-id="<?php echo e($values['id'], false); ?>">
								<?php echo e($values['intf_ref_value'], false); ?>

							</td>
							<?php else: ?> 
							<td>-</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>FLOW <span>(L/Min)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $respiratorty_support[10])->first(); ?>
							<?php if(!empty($values['intf_ref_value'])): ?>
							<?php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							?>
							<td class="<?php echo e(($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : '', false); ?>" data-id="<?php echo e($values['id'], false); ?>">
								<?php echo e($values['intf_ref_value'], false); ?>

							</td>
							<?php else: ?> 
							<td>-</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>RR(set)</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $respiratorty_support[12])->first(); ?>
							<?php if(!empty($values['intf_ref_value'])): ?>
							<?php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							?>
							<td class="<?php echo e(($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : '', false); ?>" data-id="<?php echo e($values['id'], false); ?>">
								<?php echo e($values['intf_ref_value'], false); ?>

							</td>
							<?php else: ?> 
							<td>
								-
							</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Trigger Count</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $respiratorty_support[26])->where('intf_ref_value', '!=', NULL)->first(); ?>
							<?php if(isset($values['intf_ref_value']) && !empty($values['intf_ref_value'])): ?>
							<?php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							?>
							<td class="<?php echo e(($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : '', false); ?>" data-id="<?php echo e($values['id'], false); ?>">
								<?php echo e($values['intf_ref_value'], false); ?>

							</td>
							<?php else: ?> 
							<td>
								-
							</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Frequency <span>(Hz)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $respiratorty_support[13])->first(); ?>
							<?php if(!empty($values['intf_ref_value'])): ?>
							<?php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							?>
							<td class="<?php echo e(($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : '', false); ?>" data-id="<?php echo e($values['id'], false); ?>">
								<?php echo e($values['intf_ref_value'], false); ?>

							</td>
							<?php else: ?> 
							<td>
								-
							</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>IT (%)</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $respiratorty_support[14])->first(); ?>
							<?php if(!empty($values['intf_ref_value'])): ?>
							<?php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							?>
							<td class="<?php echo e(($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : '', false); ?>" data-id="<?php echo e($values['id'], false); ?>">
								<?php echo e($values['intf_ref_value'], false); ?>

							</td>
							<?php else: ?> 
							<td>
								-
							</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>IT (S)</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $respiratorty_support[15])->first(); ?>
							<?php if(!empty($values['intf_ref_value'])): ?>
							<?php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							?>
							<td class="<?php echo e(($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : '', false); ?>" data-id="<?php echo e($values['id'], false); ?>">
								<?php echo e($values['intf_ref_value'], false); ?>

							</td>
							<?php else: ?> 
							<td>
								-
							</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Measured Ti</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $respiratorty_support[25])->where('intf_ref_value', '!=', NULL)->first(); ?>
							<?php if(!empty($values['intf_ref_value'])): ?>
							<?php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							?>
							<td class="<?php echo e(($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : '', false); ?>" data-id="<?php echo e($values['id'], false); ?>">
								<?php echo e($values['intf_ref_value'], false); ?>

							</td>
							<?php else: ?> 
							<td>
								-
							</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>IE RATIO</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $respiratorty_support[16])->first(); ?>
							<?php if(!empty($values['intf_ref_value'])): ?>
							<?php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							?>
							<td class="<?php echo e(($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : '', false); ?>" data-id="<?php echo e($values['id'], false); ?>">
								<?php echo e($values['intf_ref_value'], false); ?>

							</td>
							<?php else: ?> 
							<td>
								-
							</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>CPAP <span>Interface Change</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $respiratorty_support[17])->first(); ?>
							<?php if(!empty($values['intf_ref_value'])): ?>
							<?php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							?>
							<td class="<?php echo e(($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : '', false); ?>" data-id="<?php echo e($values['id'], false); ?>">
								<?php echo e($values['intf_ref_value'], false); ?>

							</td>
							<?php else: ?> 
							<td>
								-
							</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Humidifier/Temp</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $respiratorty_support[19])->first(); ?>
							<?php if(!empty($values['intf_ref_value'])): ?>
							<?php 
							$created_by = preg_replace('/\s+/', '', $values['create_user_id']); 
							$created_by = strtolower($created_by);
							?>
							<td class="<?php echo e(($values['is_approved'] == false && $approval_status && $created_by == $ventilator_user) ? 'bg-warninggg' : '', false); ?>" data-id="<?php echo e($values['id'], false); ?>">
								<?php echo e($values['intf_ref_value'], false); ?>

							</td>
							<?php else: ?> 
							<td>
								-
							</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Air Entry <span>(R)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $respiratorty_support[20])->first(); ?>
							<td>
								<?php if(!empty($values['intf_ref_value'])): ?>
								<?php if($values['intf_ref_value'] == 'Equal'): ?>
								E
								<?php elseif($values['intf_ref_value'] == 'Unequal'): ?>
								UnE
								<?php else: ?>
								<?php echo e($values['intf_ref_value'], false); ?>

								<?php endif; ?>	
								<?php else: ?> 
								-
								<?php endif; ?>
							</td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Air Entry <span>(L)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $respiratorty_support[21])->first(); ?>
							<td>
								<?php if(!empty($values['intf_ref_value'])): ?>
								<?php if($values['intf_ref_value'] == 'Equal'): ?>
								E
								<?php elseif($values['intf_ref_value'] == 'Unequal'): ?>
								UnE
								<?php else: ?>
								<?php echo e($values['intf_ref_value'], false); ?>

								<?php endif; ?>	
								<?php else: ?> 
								-
								<?php endif; ?>
							</td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Chest Physio</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $respiratorty_support[23])->first(); ?>
							<td>
								<?php if(!empty($values['intf_ref_value'])): ?>
								<?php echo e(($values['intf_ref_value'] == 'on') ? 'Yes' : 'No', false); ?>

								<?php else: ?> 
								-
								<?php endif; ?>
							</td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Suction</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $respiratorty_support[24])->first(); ?>
							<td>
								<?php if(!empty($values['intf_ref_value'])): ?>
								<?php echo e(($values['intf_ref_value'] == 'on') ? 'Yes' : 'No', false); ?>

								<?php else: ?> 
								-
								<?php endif; ?>
							</td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<?php $totalfeedvolume = 0; ?>
		<!-- tpn fluids -->
		<div class="col-md-12 col-sm-12 col-xs-12 infusions page-break-inside">
			<h4>Drug Infusions & PN</h4>
			<div class="table-border">
				<table class="table hour-wise-table fixed">
					<thead>
						<?php if($last_column_span > 0): ?>
							<tr>
								<th rowspan="3" class="sticky">Date & Time</th>
								<th class="date-col" colspan="<?php echo e($first_column_span * 2, false); ?>"><?php echo e($sheetdate[0], false); ?></th>
								<th class="date-col" colspan="<?php echo e($last_column_span * 2, false); ?>" class="not-sticky"><?php echo e($sheetdate[3], false); ?></th>
								<th rowspan="3" class="sticky">24/TOT</th>
							</tr>
						<?php endif; ?>
						<tr>
							<?php if($last_column_span == 0): ?>
								<th class="sticky">Date & Time</th>
							<?php endif; ?>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php $slot = explode(":", $slots)[1]; ?>
							<?php $slot1 = explode(":", $slots)[2]; ?>
							<th colspan="2"><?php echo e($slot, false); ?>:<?php echo e($slot1, false); ?></th>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php if($last_column_span == 0): ?>
								<th class="sticky">24/TOT</th>
							<?php endif; ?>
						</tr>
						<tr>
							<?php if($last_column_span == 0): ?>
								<th>&nbsp</th>
							<?php endif; ?>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<th>V/H</th>
							<th>TOT</th>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php if($last_column_span == 0): ?>
								<th class="sticky"></th>
							<?php endif; ?>
						</tr>
					</thead>
					<tbody>
						<?php 
						$temp_time_slots = $time_slots;
						?>
						<?php $totrate = 0; ?>
						<?php if(count($pn_fluids) > 0): ?>
						<?php $__currentLoopData = $pn_fluids; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fluids_Key => $fluids): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php $runningrate = 0; ?>
						<tr>
							<?php $fluidsKey = explode(':', $fluids_Key); ?>
							<?php if(is_array($fluidsKey) && count($fluidsKey) > 1): ?>
							<?php $fluidsKey = $fluidsKey[1]; ?>
							<?php else: ?>  
							<?php $fluidsKey = $fluidsKey[0]; ?>
							<?php endif; ?>				                    	
							<td> <?php echo e($fluidsKey, false); ?></td>
							<?php $__currentLoopData = $temp_time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>						
							<?php $fluids_set = isset($fluids[$slots]) ? collect($fluids[$slots])->toArray() : []; ?>
							<?php if(count($fluids_set) > 0): ?>							
							<?php if(isset($fluids_set['drug_rate'])): ?>  
							<td>
								<?php echo e(is_numeric($fluids_set['drug_rate']) ? number_format($fluids_set['drug_rate'], 2) : $fluids_set['drug_rate'], false); ?>

							</td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>								
							<?php if(isset($fluids_set['drug_total'])): ?>  
							<?php $hourtotal = (float)$fluids_set['drug_total']; ?>
							<?php $runningrate += $hourtotal; ?>
							<td class="vol-bg <?php echo e((isset($fluids_set['approval_status']) && $fluids_set['approval_status'] == false && $approval_status) ? 'bg-warninggg-must' : '', false); ?>" data-row-id="<?php echo e($fluids_Key, false); ?>" data-val-time="<?php echo e($slots, false); ?>">
								<?php echo e(is_numeric($hourtotal) ? number_format($hourtotal, 2) : $hourtotal, false); ?>

							</td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php else: ?> 
							<td>-</td>
							<td class="vol-bg"><strong>-</strong></td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<td><?php echo e(number_format($runningrate, 2), false); ?></td>
							<?php $totalfeedvolume = $totrate = $totrate + $runningrate; ?>
						</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
						<?php else: ?>
						<tr>
							<td>&nbsp</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<td>&nbsp</td>
							<td>&nbsp</td>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<td>&nbsp</td>
						</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
		<!-- tpn fluids -->
		<?php if(isset($replacement_fluids) && count($replacement_fluids) > 0): ?>
		<div class="col-md-12 col-sm-12 col-xs-12 replacement page-break-inside page-break-land page-break-portrait-a3-auto">
			<h4>Replacement Fluids</h4>
			<div class="table-border">
				<table class="table hour-wise-table fixed">
					<thead>
						<?php if($last_column_span > 0): ?>
							<tr>
								<th rowspan="3" class="sticky">Date & Time</th>
								<th class="date-col" colspan="<?php echo e($first_column_span * 2, false); ?>"><?php echo e($sheetdate[0], false); ?></th>
								<th class="date-col" colspan="<?php echo e($last_column_span * 2, false); ?>"><?php echo e($sheetdate[3], false); ?></th>
								<th rowspan="3" class="sticky">24/TOT</th>
							</tr>
						<?php endif; ?>
						<tr> 
							<?php if($last_column_span == 0): ?>
								<th class="sticky">Time</th>
							<?php endif; ?>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php $slot = explode(":", $slots)[1]; ?>
							<?php $slot1 = explode(":", $slots)[2]; ?>
							<th colspan="2"><?php echo e($slot, false); ?>:<?php echo e($slot1, false); ?></th>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<?php if($last_column_span == 0): ?>
								<th>&nbsp</th>
							<?php endif; ?>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<th>V/H</th>
							<th>TOT</th>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr> 
					</thead>
					<tbody>
						<?php $__currentLoopData = $replacement_fluids; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $replacement_fluidsKey => $replacement_fluids_value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>
							<?php 
							$replacement_total = 0;
							?>
							<td><?php echo e($ivfluids[$replacement_fluids_value], false); ?></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($temp_replacement_fluids[$slots])): ?>
							<?php $replacement_fluids_set = $temp_replacement_fluids[$slots]; ?>
							<?php  $fluids_set_temp = $replacement_fluids_set->where('value', $replacement_fluids_value)->last()  ?>
							<?php if(count($fluids_set_temp) > 0): ?>
							<?php $fluids_rate  =  $replacement_fluids_set->where('observe_id', $fluids_set_temp->id)->where('local_code', 'replacement_fluids_rate')->first(); ?>
							<?php $fluids_total =  $replacement_fluids_set->where('observe_id', $fluids_set_temp->id)->where('local_code', 'replacement_fluids_total')->first(); ?>
							<td>
								<?php if(isset($fluids_rate->value) && $fluids_rate->value != ''): ?>	
								<?php echo e($fluids_rate->value, false); ?>

								<?php else: ?>
								-
								<?php endif; ?>	
							</td>
							<td>
								<?php if(isset($fluids_total->value) && $fluids_total->value != ''): ?>	
								<?php echo e($fluids_total->value, false); ?>

								<?php else: ?>
								-
								<?php endif; ?>	
							</td>
							<?php if($fluids_total->value != ''): ?>
							<?php
								$replacement_total = $replacement_total + $fluids_total->value;
							?>
							<?php else: ?>
							<?php
								$replacement_total = $replacement_total;
							?>
							<?php endif; ?>
							<?php else: ?> 
							<td >-</td>
							<td >-</td>
							<?php endif; ?>
							<?php else: ?> 
							<td >-</td>
							<td >-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<td><?php echo e(number_format($replacement_total, 2), false); ?></td>
						</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</tbody>
				</table>
			</div>
		</div>
		<?php endif; ?>
		<div class="col-md-12 col-sm-12 col-xs-12 milk-feeds page-break-inside">
			<h4>Milk Feeds <span class="note-box">( SF - Spoon Feed; TF - Tube Feed; P/C - Paladai Cup; T+O - Tube + Oral )  </span></h4>
			<div class="table-border">
				<table class="table hour-wise-table fixed">
					<thead>
						<?php if($last_column_span > 0): ?>
							<tr>
								<th rowspan="2" class="sticky">Date & Time</th>
								<th class="date-col" colspan="<?php echo e($first_column_span, false); ?>"><?php echo e($sheetdate[0], false); ?></th>
								<th class="date-col" colspan="<?php echo e($last_column_span, false); ?>"><?php echo e($sheetdate[3], false); ?></th>
								<th rowspan="2" class="sticky">24/TOT</th>
							</tr>
						<?php endif; ?>
						<tr>
							<?php if($last_column_span == 0): ?>
								<th class="sticky">Time</th>	    				
							<?php endif; ?>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php $slot = explode(":", $slots)[1]; ?>
							<?php $slot1 = explode(":", $slots)[2]; ?>
							<th><?php echo e($slot, false); ?>:<?php echo e($slot1, false); ?></th>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
							<?php if($last_column_span == 0): ?>
								<th class="sticky">24/TOT</th>
							<?php endif; ?>
						</tr>
					</thead>
					<tbody>
						<?php $milk_vol = 0; ?>
						<?php unset($milk_feeds[5]); ?>
						<?php $__currentLoopData = $milk_feeds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $milk_feeds_key => $milk_feeds_value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>
							<?php if($milk_feeds_value =='human_milk_fortification'): ?>
							<td>Fortification</td>
							<?php elseif($milk_feeds_value =='stoma_output_hour_total'): ?>
							<td>Stoma Output</td>
							<?php elseif($milk_feeds_value == 'milk_volume'): ?>
							<td class="avoid-transparent">Milk Volume / Total</td>
							<?php else: ?>
							<td><?php echo e(title_case(str_replace('_', ' ', $milk_feeds_value)), false); ?></td>
							<?php endif; ?>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($temp_milk_feeds[$slots])): ?>
							<?php $milk_feed_set = $temp_milk_feeds[$slots]; ?>
							<?php $milk_feed_set_temp = collect($milk_feed_set)->where('local_code', $milk_feeds_value)->first(); ?>
							<?php if(!(count($milk_feed_set_temp) > 0) && $milk_feeds_value == 'milk_feeds'): ?>
							<?php $milk_feed_set_temp = collect($milk_feed_set)->where('local_code', 'type_of_feeds')->first(); ?>
							<?php endif; ?>
							<?php if(count($milk_feed_set_temp) > 0): ?>	           	 	      
							<?php if($milk_feeds_value == 'human_milk_fortification' && $milk_feed_set_temp['intf_ref_value'] == 'on'): ?>
							<td> Yes </td>
							<?php elseif($milk_feeds_value == 'human_milk_fortification' && $milk_feed_set_temp['intf_ref_value'] == 'off'): ?>
							<td> No </td>
							<?php elseif($milk_feeds_value == 'human_milk_fortification' && $milk_feed_set_temp['intf_ref_value'] == ''): ?> 
							<td>-</td>
							<?php elseif($milk_feeds_value == 'milk_volume'): ?>
							<td class="crossed">
								<?php $milk_feed_set_temp['intf_ref_value'] =  preg_replace('/[A-Z,a-z]/', '', $milk_feed_set_temp['intf_ref_value']) ?>
								<?php $milk_vol =  preg_replace('/[A-Z,a-z]/', '', $milk_vol) ?>
								<?php $milk_feed_set_temp['intf_ref_value'] =  preg_replace('/[A-Z,a-z]/', '', $milk_feed_set_temp['intf_ref_value']) ?>
								<?php $milk_feed_set_temp['intf_ref_value'] = $milk_feed_set_temp['intf_ref_value'] != '' ? (float)$milk_feed_set_temp['intf_ref_value'] : 0; ?>
								<?php $milk_vol_for_time = $milk_vol_for_time + $milk_feed_set_temp['intf_ref_value']; ?>
								<?php $milk_vol = $milk_vol + $milk_feed_set_temp['intf_ref_value']; ?>

								<div class="part1"><span class="text-center"><?php echo e($milk_feed_set_temp['intf_ref_value'], false); ?></span></div>
								<div class="crossed-line"></div>
								<?php $milk_feed_set_temp = collect($milk_feed_set)->where('local_code', 'milk_volume_total')->first(); ?>		           	 	  

								<div class="part2"><span class="text-center"><?php echo e($milk_vol, false); ?></span></div>
							</td>
							<?php elseif($milk_feeds_value == 'milk_feeds'): ?>
							<?php $type_of_feeds = collect($milk_feed_set)->where('local_code', 'type_of_feeds')->first(); ?>
							<?php if($type_of_feeds['intf_ref_value'] == 'NPO'): ?>
							<?php $milk_feed_set_temp['intf_ref_value'] = 'No'; ?>
							<?php elseif(!empty($type_of_feeds['intf_ref_value'])): ?>
							<?php $milk_feed_set_temp['intf_ref_value'] = 'Yes'; ?>
							<?php endif; ?>
							<?php if(empty($milk_feed_set_temp['intf_ref_value'])): ?>
							<td>-</td>								
							<?php else: ?>
							<td><?php echo e($milk_feed_set_temp['intf_ref_value'] == 'No' ? $milk_feed_set_temp['intf_ref_value'] . ' (NPO)' : $milk_feed_set_temp['intf_ref_value'], false); ?></td>								
							<?php endif; ?>
							<?php elseif($milk_feeds_value == 'type_of_feeds'): ?>
							<td>
							<?php echo e(empty($milk_feed_set_temp['intf_ref_value']) || $milk_feed_set_temp['intf_ref_value'] == 'NPO' ? '-' : $milk_feed_set_temp['intf_ref_value'], false); ?></td>								
							<?php else: ?> 
							<?php if($milk_feed_set_temp['intf_ref_value'] == 'Spoon Feed'): ?>
							<td>SF</td>
							<?php elseif($milk_feed_set_temp['intf_ref_value'] == 'Tube Feed'): ?>
							<td>TF</td>
							<?php elseif($milk_feed_set_temp['intf_ref_value'] == 'Paladai Cup'): ?>
							<td>P/C</td>
							<?php elseif($milk_feed_set_temp['intf_ref_value'] == 'Tube + Oral'): ?>
							<td>T+O</td>
							<?php else: ?>
							<td><?php echo e(!empty($milk_feed_set_temp['intf_ref_value']) ? $milk_feed_set_temp['intf_ref_value'] : '-', false); ?></td>
							<?php endif; ?>
							<?php endif; ?>          	 	   
							<?php else: ?>
							<td> - </td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php if(is_numeric($milk_vol) && $milk_feeds_value == 'milk_volume' && $milk_vol != 0): ?>
							<td><?php echo e(number_format($milk_vol, 2), false); ?></td>							
							<?php elseif(!is_numeric($milk_vol) && $milk_feeds_value == 'milk_volume' && $milk_vol != 0): ?>
							<td><?php echo e($milk_vol, false); ?></td>
							<?php else: ?>
							<td></td>
							<?php endif; ?>
						</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</tbody>
				</table>
			</div>
			<div class="col-md-12 full-width mt-10">
				<div class="row pull-right custom-total">
					<span class="plr-10"><strong>Total Input</strong></span>
					<?php $tot_input = $totalfeedvolume + $milk_vol; ?>
					<span class="box"><?php echo e($tot_input != 0 ? number_format($tot_input, 2) : '', false); ?></span>
				</div>
			</div>
			<div class="col-md-12 full-width mt-10">
				<div class="row pull-right custom-total">
					<?php if($nurse_details_sheet->total_input > 0): ?>
					<span class="box mlr-5 pull-left"><?php echo e($nurse_details_sheet->total_input_ml_per_kg, false); ?></span><span class="pull-right">ml/kg/day</span>
					<?php else: ?>
					<span class="box mlr-5 pull-left"></span><span class="pull-right">ml/kg/day</span>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12 output page-break-inside">
			<h4>Output <span class="note-box"> ( Milk - Milky; yell - Yellow; LG - Light green; DG - Dark green; B - Bloody; AB - Altered brown; Mec - Meconium; CP - Changing pattern; F.yell - Formed yellow; SSyell - Semi-solid yellow; Pale - Pale white; G - Green; L - Loose; D - Diarrhoea; )</span></h4>
			<div class="table-border">
				<table class="table hour-wise-table fixed">
					<thead>
						<?php if($last_column_span > 0): ?>
							<tr>
								<th rowspan="3" class="sticky">Date & Time</th>
								<th class="date-col" colspan="<?php echo e($first_column_span * 2, false); ?>"><?php echo e($sheetdate[0], false); ?></th>
								<th class="date-col" colspan="<?php echo e($last_column_span * 2, false); ?>"><?php echo e($sheetdate[3], false); ?></th>
								<th rowspan="3" class="sticky">24/TOT</th>
							</tr>
						<?php endif; ?>
						<tr>
							<?php if($last_column_span == 0): ?>
								<th class="sticky">Time</th>
							<?php endif; ?>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php $slot = explode(":", $slots)[1]; ?>
							<?php $slot1 = explode(":", $slots)[2]; ?>
							<th colspan="2"><?php echo e($slot, false); ?>:<?php echo e($slot1, false); ?></th>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php if($last_column_span == 0): ?>
								<th class="sticky">24/TOT</th>
							<?php endif; ?>
						</tr>
						<tr>
							<?php if($last_column_span == 0): ?>
								<th>&nbsp</th>
							<?php endif; ?>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<th>V/H</th>
							<th>TOT</th>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php if($last_column_span == 0): ?>
								<th class="sticky"></th>
							<?php endif; ?>
						</tr>
					</thead>           	  
					<tbody>
						<tr>
							<td>Gastric Aspirate <span>(ml)</span></td>
							<?php $gastric_aspirate = 0; ?>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($temp_output_groups[$slots])): ?>
							<?php $temp_data = $temp_output_groups[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = $temp_data->where('local_code', $output_groups[0])->first(); ?>
							<?php $values['intf_ref_value'] = preg_replace("/[^0-9,.]/", "", $values['intf_ref_value'] ); ?>					    			
							<?php if($values['intf_ref_value'] != 0): ?>
							<td><?php echo e($values['intf_ref_value'], false); ?></td>
							<?php $gastric_aspirate = $gastric_aspirate + $values['intf_ref_value']; ?>
							<td><strong><?php echo e(($gastric_aspirate != 0) ? $gastric_aspirate : '-', false); ?></strong></td>
							<?php else: ?>
							<td>-</td>
							<td>-</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<td><?php echo e($gastric_aspirate != 0 ? number_format($gastric_aspirate, 2) : '', false); ?></td>
						</tr>
						<tr>
							<td>Gastric Aspirate <span>(nature)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($temp_output_groups[$slots])): ?>
							<?php $temp_data = $temp_output_groups[$slots]; $temp_data = collect($temp_data); ?>

							<?php $values = collect($temp_data)->where('local_code', $output_groups[1])->first(); ?>
							<td colspan="2">
								
								<div class="wrap invert">
									<?php if(!empty($values['intf_ref_value'])): ?> 	
									<?php if($values['intf_ref_value'] == 'Milky'): ?>
									<div class="landscape"><?php echo e('Milk', false); ?></div>
									<?php elseif($values['intf_ref_value'] == 'Yellow'): ?>
									<div class="landscape"><?php echo e('yell', false); ?></div>
									<?php elseif($values['intf_ref_value'] == 'Light green'): ?>
									<div class="landscape"><?php echo e('LG', false); ?></div>
									<?php elseif($values['intf_ref_value'] == 'Dark green'): ?>
									<div class="landscape"><?php echo e('DG', false); ?></div>
									<?php elseif($values['intf_ref_value'] == 'Bloody'): ?>
									<div class="landscape"><?php echo e('B', false); ?></div>
									<?php elseif($values['intf_ref_value'] == 'Altered brown'): ?>
									<div class="landscape"><?php echo e('AB', false); ?></div>
									<?php else: ?>
									<div class="landscape"><?php echo e($values['intf_ref_value'], false); ?></div>
									<?php endif; ?>
									<?php else: ?>
									-
									<?php endif; ?>
								</div>
							</td>
							<?php else: ?>
							<td colspan="2">-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	               	
							<td></td>
						</tr>
						<tr>
							<td>Urine Output <span>(ml)</span></td>
							<?php $urine_output = 0; ?>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($temp_output_groups[$slots])): ?>
							<?php $temp_data = $temp_output_groups[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $output_groups[3])->first(); ?>
							<?php $values['intf_ref_value'] = preg_replace("/[^0-9,.]/", "", $values['intf_ref_value'] ); ?>					    			
							<?php if($values['intf_ref_value'] != 0): ?>
							<td><?php echo e($values['intf_ref_value'], false); ?></td>
							<?php $urine_output = $urine_output + $values['intf_ref_value']; ?>
							<td><strong><?php echo e(($urine_output != 0) ? $urine_output : '-', false); ?></strong></td>
							<?php else: ?>
							<td>-</td>
							<td>-</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
							<td><?php echo e($urine_output != 0 ? number_format($urine_output, 2) : '', false); ?></td>
						</tr>
						<tr>
							<td>Blood Volume Out <span>(ml)</span></td>
							<?php $blood_volume_out = 0; ?>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($temp_output_groups[$slots])): ?>
							<?php $temp_data = $temp_output_groups[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $output_groups[5])->first(); ?>
							<?php $values['intf_ref_value'] = preg_replace("/[^0-9,.]/", "", $values['intf_ref_value'] ); ?>					    			
							<?php if($values['intf_ref_value'] != 0): ?>
							<td><?php echo e($values['intf_ref_value'], false); ?></td>
							<?php $blood_volume_out = $blood_volume_out + $values['intf_ref_value']; ?>
							<td><strong><?php echo e(($blood_volume_out != 0) ? $blood_volume_out : '-', false); ?></strong></td>
							<?php else: ?>
							<td>-</td>
							<td>-</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
							<td><?php echo e($blood_volume_out != 0 ? number_format($blood_volume_out, 2) : '', false); ?></td>
						</tr>
						<tr>
							<td>Drain Output (R)</td>
							<?php $drain_output_r = 0; ?>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($temp_output_groups[$slots])): ?>
							<?php $temp_data = $temp_output_groups[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $output_groups[7])->first(); ?>
							<?php $values['intf_ref_value'] = preg_replace("/[^0-9,.]/", "", $values['intf_ref_value'] ); ?>					    			
							<?php if($values['intf_ref_value'] != 0): ?>
							<td><?php echo e($values['intf_ref_value'], false); ?></td>
							<?php $drain_output_r = $drain_output_r + $values['intf_ref_value']; ?>
							<td><strong><?php echo e(($drain_output_r != 0) ? $drain_output_r : '-', false); ?></strong></td>
							<?php else: ?>
							<td>-</td>
							<td>-</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
							<td><?php echo e($drain_output_r != 0 ? number_format($drain_output_r, 2) : '', false); ?></td>
						</tr>
						<tr>
							<td>Drain Output (L)</td>
							<?php $drain_output_l = 0; ?>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($temp_output_groups[$slots])): ?>
							<?php $temp_data = $temp_output_groups[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $output_groups[9])->first(); ?>
							<?php $values['intf_ref_value'] = preg_replace("/[^0-9,.]/", "", $values['intf_ref_value'] ); ?>					    			
							<?php if($values['intf_ref_value'] != 0): ?>
							<td><?php echo e($values['intf_ref_value'], false); ?></td>
							<?php $drain_output_l = $drain_output_l + $values['intf_ref_value']; ?>
							<td><strong><?php echo e(($drain_output_l != 0) ? $drain_output_l : '-', false); ?></strong></td>
							<?php else: ?>
							<td>-</td>
							<td>-</td>
							<?php endif; ?>

							<?php else: ?>
							<td>-</td>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
							<td><?php echo e($drain_output_l != 0 ? number_format($drain_output_l, 2) : '', false); ?></td>
						</tr>
						<tr>
							<td>Stoma Output</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($temp_output_groups[$slots])): ?>
							<?php $temp_data = $temp_output_groups[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $output_groups[16])->first(); ?>
							<td colspan="2"><?php echo e(($values['intf_ref_value'] != '') ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td colspan="2">-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
							<td></td>
						</tr>
						<tr>
							<td>Bowels Opened</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($temp_output_groups[$slots])): ?>
							<?php $temp_data = $temp_output_groups[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $output_groups[11])->first(); ?>
							<td colspan="2">
								<?php if(!empty($values['intf_ref_value'])): ?> 	
								<?php echo e(($values['intf_ref_value'] == 'on') ? 'Yes' : 'No', false); ?>

								<?php else: ?>
								-
								<?php endif; ?>
							</td>
							<?php else: ?>
							<td colspan="2">-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
							<td></td>
						</tr>
						<tr>
							<td>Stool Nature</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($temp_output_groups[$slots])): ?>
							<?php $temp_data = $temp_output_groups[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $output_groups[12])->first(); ?>
							<td colspan="2">
								
								<div class="wrap invert">
									<?php if(!empty($values['intf_ref_value'])): ?> 	
									<?php if($values['intf_ref_value'] == 'Changing stool pattern'): ?>
									<div class="landscape"><?php echo e('CP', false); ?></div>
									<?php elseif($values['intf_ref_value'] == 'Meconium'): ?>
									<div class="landscape"><?php echo e('Mec', false); ?></div>
									<?php elseif($values['intf_ref_value'] == 'Formed yellow'): ?>
									<div class="landscape"><?php echo e('F.yell', false); ?></div>
									<?php elseif($values['intf_ref_value'] == 'Semi-solid yellow'): ?>
									<div class="landscape"><?php echo e('SSyell', false); ?></div>
									<?php elseif($values['intf_ref_value'] == 'Pale white'): ?>
									<div class="landscape"><?php echo e('Pale', false); ?></div>
									<?php elseif($values['intf_ref_value'] == 'Green'): ?>
									<div class="landscape"><?php echo e('G', false); ?></div>
									<?php elseif($values['intf_ref_value'] == 'Loose'): ?>
									<div class="landscape"><?php echo e('L', false); ?></div>
									<?php elseif($values['intf_ref_value'] == 'Diarrhoea'): ?>
									<div class="landscape"><?php echo e('D', false); ?></div>
									<?php elseif($values['intf_ref_value'] == 'Bloody'): ?>
									<div class="landscape"><?php echo e('B', false); ?></div>
									<?php else: ?>
									<div class="landscape"><?php echo e($values['intf_ref_value'], false); ?></div>
									<?php endif; ?>
									<?php else: ?>
									-
									<?php endif; ?>
								</div>
							</td>
							<?php else: ?>
							<td colspan="2">-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
							<td></td>
						</tr>
						<tr>
							<td>KMC</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($temp_output_groups[$slots])): ?>
							<?php $temp_data = $temp_output_groups[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $output_groups[13])->first(); ?>
							<td colspan="2">
								<?php if(!empty($values['intf_ref_value'])): ?> 	
								<?php echo e(($values['intf_ref_value'] == 'on') ? 'Yes' : 'No', false); ?>

								<?php else: ?>
								-
								<?php endif; ?>
							</td>
							<?php else: ?>
							<td colspan="2">-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
							<td></td>
						</tr>
						<tr>
							<td>NNS</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($temp_output_groups[$slots])): ?>
							<?php $temp_data = $temp_output_groups[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $output_groups[14])->first(); ?>
							<td colspan="2">
								<?php if(!empty($values['intf_ref_value'])): ?> 	
								<?php echo e(($values['intf_ref_value'] == 'on') ? 'Yes' : 'No', false); ?>

								<?php else: ?>
								-
								<?php endif; ?>
							</td>
							<?php else: ?>
							<td colspan="2">-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
							<td></td>
						</tr>
						
					</tbody>
				</table>
			</div>
			<div class="col-md-12 full-width mt-10">
				<div class="row pull-right custom-total">
					<span class="plr-10"><strong>Total Output</strong></span>
					<?php $tot = $gastric_aspirate + $urine_output + $blood_volume_out + $drain_output_r + $drain_output_l; ?>
					<span class="box"><?php echo e($tot != 0 ? number_format($tot, 2) : '', false); ?></span>
				</div>
			</div>
			<div class="col-md-12 full-width mt-10">
				<div class="row pull-right custom-total">
					<?php if($nurse_details_sheet->total_output > 0): ?>
					<span class="box mlr-5 pull-left"><?php echo e($nurse_details_sheet->total_output_ml_per_kg, false); ?></span><span class="pull-right">ml/kg/day</span>
					<?php else: ?>
					<span class="box mlr-5 pull-left"></span><span class="pull-right">ml/kg/day</span>					
					<?php endif; ?>
				</div>
			</div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12 blood-value page-break-inside page-break-land page-break-portrait">
			<h4>Blood Gas <span class="note-box">( A - Arterial; V - Venous; C - Capillary; )</span></h4>
			<div class="table-border">
				<table class="table hour-wise-table fixed">
					<thead>
						<?php if($last_column_span > 0): ?>
							<tr>
								<th rowspan="2" class="sticky">Date & Time</th>
								<th class="date-col" colspan="<?php echo e($first_column_span, false); ?>"><?php echo e($sheetdate[0], false); ?></th>
								<th class="date-col" colspan="<?php echo e($last_column_span, false); ?>"><?php echo e($sheetdate[3], false); ?></th>
							</tr>
						<?php endif; ?>
						<tr>
							<?php if($last_column_span == 0): ?>
								<th class="sticky">Time</th>
							<?php endif; ?>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php $slot = explode(":", $slots)[1]; ?>
							<?php $slot1 = explode(":", $slots)[2]; ?>
							<th><?php echo e($slot, false); ?>:<?php echo e($slot1, false); ?></th>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Type Of Blood Gas</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'blood_gas_type')->first(); ?>
							<?php if(!empty($values['intf_ref_value'])): ?>
							<?php if($values['intf_ref_value'] == 'Arterial'): ?>
							<td><div class="wrap">A</div></td>
							<?php elseif($values['intf_ref_value'] == 'Venous'): ?>
							<td><div class="wrap">V</div></td>
							<?php elseif($values['intf_ref_value'] == 'Capillary'): ?>
							<td><div class="wrap">C</div></td>
							<?php else: ?>
							<td><div class="wrap">-</div></td>
							<?php endif; ?>
							<?php else: ?>
							<td><div class="wrap">-</div></td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Last BG at</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'last_bg_time')->first(); ?>
							<?php if(!empty($values['intf_ref_value'])): ?>
							<?php if(str_contains($values['intf_ref_value'], 'AM')): ?>
							<?php 
							$time = explode(':', $values['intf_ref_value']);
							$hour = (int)$time[0]; 
							$minutes = explode(' ', $time[1])[0]; 
							?>
							<?php if($hour == 12): ?>
							<?php $hour = '00'; ?>
							<?php endif; ?>
							<td><?php echo e($hour .':'. $minutes, false); ?></td>
							<?php else: ?>
							<?php 
							$time = explode(':', $values['intf_ref_value']);
							$hour = (int)$time[0]; 
							$minutes = explode(' ', $time[1])[0]; 
							?>
							<?php if($hour == 12): ?>
							<?php $hour = 23; ?>
							<?php else: ?>
							<?php $hour = $hour + 12;?>
							<?php endif; ?>
							<td><?php echo e($hour .':'. $minutes, false); ?></td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>pH</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'interface_blood_gas_ph')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Pao2</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'interface_blood_gas_pao2')->first(); ?>
							
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>TcPO2</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $baby_observe[21])->first(); ?>
							<td><?php echo e(($values['intf_ref_value'] != '') ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>PaCo2</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'interface_blood_gas_paco2')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>TcPCO2</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', $baby_observe[20])->first(); ?>
							<td><?php echo e(($values['intf_ref_value'] != '') ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>ETCO2</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'interface_blood_gas_etco2')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>HCO3</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'interface_blood_gas_hco3')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>			    		
						<tr>
							<td>BE</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'interface_blood_gas_be')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Na (sodium) <span>(mmol/L)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'interface_blood_gas_na')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>K (potassium) <span>(mmol/L)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'interface_blood_gas_k')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Calcium</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'interface_blood_gas_calcium')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Cl (Chloride) <span>(mmol/L)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'interface_blood_gas_cl')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>HB <span>(g/dL)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'interface_blood_gas_hb')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>PCV (%)</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'interface_blood_gas_pcv')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Lactate <span>(mmol/L)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'interface_blood_gas_lactate')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Bilirubin <span>(mg/dl)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'interface_blood_gas_bilirubin')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Blood Sugar <span>(mg/dl)</span><small>(Blood Gas)</small></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'interface_blood_gas_blood_sugar')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Blood Sugar <span>(mg/dl)</span><small>(Glucometer)</small></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'blood_sugar')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Methemoglobin</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'interface_blood_gas_methemoglobin')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
						<?php if($last_column_span > 0): ?>
							<tr>
								<th rowspan="2" class="sticky">Date & Time</th>
								<th class="date-col" colspan="<?php echo e($first_column_span, false); ?>"><?php echo e($sheetdate[0], false); ?></th>
								<th class="date-col" colspan="<?php echo e($last_column_span, false); ?>"><?php echo e($sheet_date[3], false); ?></th>
							</tr>
						<?php endif; ?>
						<tr>
							<?php if($last_column_span == 0): ?>
								<th>Time</th>
							<?php endif; ?>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php $slot = explode(":", $slots)[1]; ?>
							<?php $slot1 = explode(":", $slots)[2]; ?>
							<th><?php echo e($slot, false); ?>:<?php echo e($slot1, false); ?></th>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Na (sodium) <span>(mmol/L)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'blood_gas_na')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>K (potassium) <span>(mmol/L)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'blood_gas_k')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Cl (Chloride) <span>(mmol/L)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'blood_gas_cl')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Bilirubin  (mg/dl)</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'blood_gas_bilirubin')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Glucometer Sugar <span>(mg/dl)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'blood_sugar')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Methemoglobin</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'blood_gas_methemoglobin')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Calcium <span>(8.5-10.5 mg/dl)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'gluco_meter_calcium')->first(); ?>
							<td><div class="wrap"><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></div></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Magnesium <span>1.2 to 2.6 mg/dl</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'gluco_meter_magnesium')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Phosphorus <span>(2.7-4.5 mg/dl)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'gluco_meter_phosphorus')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>BUN <span>(6-20 mg/dl)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'gluco_meter_bun')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Creatintine <span>(0.6-1.4 mg/dl)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'gluco_meter_creatintine')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Glucose <span>(70-110 mg/dl)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'gluco_meter_glucose')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Creatine Kinase <span> (26-174 U/L)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'gluco_meter_creatinekinase')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>CK - MB <span>(&#60;6% of Total CK)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'gluco_meter_ckmb')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Trop. T</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'gluco_meter_trop')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Total bilirubin </td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'gluco_meter_totalbilirubin')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Direct bilirubin </td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'gluco_meter_directbilirubin')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>SGOT (AST) <span>(< 0-40 U/L)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'gluco_meter_sgot')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>SGPT (AST) <span>(< 0-40 U/L)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'gluco_meter_sgpt')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>ALP <span>(30-115 U/L)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'gluco_meter_alkalinephosphatase')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td class="custom">GGT <span>0 - 1 mo - 13 - 147 U/L</span><span>1-2 mo - 12 to 123 U/L</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'gluco_meter_gamagtp')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>LDH <span>(90-220 U/L)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'gluco_meter_ldh')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Amylase <span>(31-123 U/L)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'gluco_meter_amylase')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Lipase</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'gluco_meter_lipase')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Total Protein <span>(6-8.4 gm/dl)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'gluco_meter_totalprotein')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Albumin <span>(3.5-5.3 gm/dl)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'gluco_meter_albumin')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Total Cholesterol</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'gluco_meter_totalcholesterol')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>HDL</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'gluco_meter_hdl')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>LDL</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'gluco_meter_ldl')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>VLDL</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'gluco_meter_vldl')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Tri glycerides</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'gluco_meter_triglycerides')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Hemoglobin</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'blood_gas_hemoglobin')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>RBC <span>(3.5-5.5 *10<sup>6</sup>/&mu;)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'gluco_meter_rbc')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Haematocrit <span>(PCV) (35-55)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'gluco_meter_haematocrit')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Reticulocyte count <span>(0.5-1.5 %)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'gluco_meter_reticulocytecount')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td class="custom">WBC : Total Count <span>(4.000-11.0000/&mu;)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'gluco_meter_wbc')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>DC : Poly <span>(40-75 %)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'gluco_meter_dc')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Lymph <span>(0-75 %)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'gluco_meter_lymph')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Mono <span>(2-10 %)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'gluco_meter_mono')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Eos <span>(1-6 %)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'gluco_meter_eos')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Baso <span>(0-1 %)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'gluco_meter_baso')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Platelets</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'gluco_meter_platelets')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>ESR <span>(mm/hr)</span></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'gluco_meter_esr')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>PT(s)</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'gluco_meter_prothrombintime')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>APTT(s)</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'gluco_meter_aptt')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>INR</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'gluco_meter_inr')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>Fibrinogen</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'gluco_meter_fibrinogen')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td>FDP</td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(isset($result[$slots])): ?>
							<?php $temp_data = $result[$slots]; $temp_data = collect($temp_data); ?>
							<?php $values = collect($temp_data)->where('local_code', 'gluco_meter_fdp')->first(); ?>
							<td><?php echo e(!empty($values['intf_ref_value']) ? $values['intf_ref_value'] : '-', false); ?></td>
							<?php else: ?>
							<td>-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
		<?php if(isset($nurse_entered) && count($nurse_entered) > 0): ?>
		<div class="col-md-12 col-sm-12 col-xs-12 entered">
			<h5>Sheet Entered By:</h5>
			<div class="table-border">
				<table class="table fixed entered-by">
					<thead>
						<?php if($last_column_span > 0): ?>
							<tr>
								<th rowspan="2" class="sticky">Date & Time</th>
								<th class="date-col" colspan="<?php echo e($first_column_span, false); ?>"><?php echo e($sheetdate[0], false); ?></th>
								<th class="date-col" colspan="<?php echo e($last_column_span, false); ?>"><?php echo e($sheetdate[3], false); ?></th>
							</tr>
						<?php endif; ?>
						<tr>
							<?php if($last_column_span == 0): ?>
								<th class="sticky">Time</th>	    				
							<?php endif; ?>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php $slot = explode(":", $slots)[1]; ?>
							<?php $slot1 = explode(":", $slots)[2]; ?>
							<th class="text-center"><b><?php echo e($slot, false); ?>:<?php echo e($slot1, false); ?></b></th>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>		    			
						</tr>
					</thead>
					<tbody>	
						<tr>
							<td><b>Signature</b></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php $nurse_entered_id = isset($nurse_entered[$slots]) ? $nurse_entered[$slots] : null; ?>
							<?php if(isset($sign[$nurse_entered_id]) && $nurse_entered_id != null): ?>
							<td class="user-sign text-center">
								<img src="<?php echo e($site_url, false); ?>/img/users/<?php echo e($sign[$nurse_entered_id], false); ?>" />
							</td>
							<?php elseif(isset($initial[$nurse_entered_id]) && $nurse_entered_id != null): ?>
							<td class="user-sign text-center">
								<img src="<?php echo e($site_url, false); ?>/img/users/<?php echo e($initial[$nurse_entered_id], false); ?>" />
							</td>
							<?php else: ?>
							<td class="text-center">-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
						<tr>
							<td><b>Name</b></td>
							<?php $__currentLoopData = $time_slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slots): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php $nurse_entered_id = isset($nurse_entered[$slots]) ? $nurse_entered[$slots] : null; ?>
							<?php if($nurse_entered_id != null): ?>
							<td class="text-center">
								<?php echo e(@$nurse_master[$nurse_entered_id], false); ?>

								<br>
								<span class="font-normal">(<?php echo e(@$staff_id[$nurse_entered_id], false); ?>)</span>
							</td>
							<?php else: ?>
							<td class="text-center">-</td>
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<?php endif; ?>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="daily-notes">
				<span>Ward Rounds Instruction</span>
				<?php if(!empty($nurse_details_sheet['ward_rounds_instruction'])): ?>
				<p><?php echo e($nurse_details_sheet['ward_rounds_instruction'], false); ?></p>
				<?php endif; ?>
				<table>
					<tbody>
						<?php $__currentLoopData = $ward_rounds_instruction; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php if(!empty(trim($value))): ?>
						<tr>
							<td style="border: 0px !important; padding-left: 15px !important;">
								<b><?php echo e(date('d-m-Y H', strtotime($key)), false); ?>:00 : </b>
							</td>
							<td style="border: 0px !important;">
								&ensp;&ensp;<?php echo e(trim($value), false); ?>

							</td>
						</tr>
						<?php endif; ?>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div> 
<div class="col-md-12 col-sm-12 col-xs-12 divFooter">
	<b>Neonatal Intensive Care Sheet / Version - 1.0 / 07-01-2021 / SKSH India (P) Ltd., Salem, TN.</b>
</div>

<?php echo $__env->make('nurse_sheet.nurse_sheet_approval_modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">
	// $('.nurse-sheet.sheet-auto .infusions table > tbody > tr > td:nth-child(2)').css('left', $('.nurse-sheet .infusions table > tbody > tr > td:first-child').width()+4);
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('print', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>