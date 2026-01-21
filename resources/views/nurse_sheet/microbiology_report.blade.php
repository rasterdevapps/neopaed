<div role="tabpanel" class="tab-pane" id="microbiology">
	<div class="row mx-0">
		<div class="col-xs-2 hidden-print">
			<ul class="nav nav-tabs tabs-left microbiology-report">
				@php 
					$microbiology_tests_filter = collect($microbiology_tests)->unique()->toArray();
					$i = 0;
				@endphp
				@foreach ($microbiology_tests_filter as $key => $value)
					@php 
						$tab_name = str_replace(' ', '', $value);
						$tab_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $tab_name);
						$tab_name = strtolower($tab_name);
						$value = str_replace('BLOODCULTURE', 'BLOOD CULTURE', $value);
					@endphp
					@if ($i == 0)
						<li class="active"><a href="#{{$tab_name}}" data-toggle="tab">{{ $value }}</a></li>
					@else
						<li><a href="#{{$tab_name}}" data-toggle="tab">{{ $value }}</a></li>
					@endif
					@php $i++; @endphp
				@endforeach
			</ul>
		</div>
		<div class="col-xs-10 print-full-width p-must-0">
			<div class="tab-content">
				@php 
					$microbiology_results = $microbiology_results->toArray();
					$i = 0;
				@endphp
				@foreach ($microbiology_tests_filter as $key => $value)
					@php 
						$tab_name = str_replace(' ', '', $value);
						$tab_name = strtolower($tab_name);
						$tab_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $tab_name);
						$test_name_array = array_keys($microbiology_tests, $value);
						$culture_results = collect($microbiology_results)->where('specimen', '!=', '')->where('specimen', '!=', '*')->whereIn('test_name', $test_name_array)->sortBy('test_name')->toArray();
						$tab_content = '';
						$result_content = '';
					@endphp
					@if (str_contains($tab_name, 'csf'))
						@php $test_count = 0; @endphp
						@foreach ($culture_results as $result_key => $result_value)
							@php                        
								$sheet_name = $tab_name.'_test_'.$test_count;
							@endphp                        
							@if ($test_count == (count($culture_results) - 1))
								@php 
									$tab_content .= '<li class="active"><a href="#'.$sheet_name.'" data-toggle="tab">Test '. ($test_count + 1) .' </a></li>'; 
									$result_content .= '<div class="tab-pane active" id="'.$sheet_name.'">';
								@endphp
							@else
								@php 
									$tab_content .= '<li><a href="#'.$sheet_name.'" data-toggle="tab">Test '. ($test_count + 1) .' </a></li>'; 
									$result_content .= '<div class="tab-pane" id="'.$sheet_name.'">';
								@endphp
							@endif
							@php                        
								$result_content .= '<div class="full-width pull-left">
								<table style="float:right !important">
									<tr>
										<td style="border: 0px !important;">Collected On</td>
										<td style="border: 0px !important; width: 130px; text-align: left;"> :'.date('d/m/Y h:i A', strtotime($result_value->result_collect_time)).'</td>
									</tr>
									<tr>
										<td style="border: 0px !important">Reported On</td>';
							@endphp
							@if (isset($result_value->result_report_time) && !empty($result_value->result_report_time))
								@php $result_content .= '<td style="border: 0px !important; width: 130px; text-align: left;"> :'.date('d/m/Y h:i A', strtotime($result_value->result_report_time)).'<br /></td>'; @endphp
							@else
								@php $result_content .= '<td style="border: 0px !important; width: 130px; text-align: left;"> : <br /></td>'; @endphp
							@endif
							@php  
								$result_content .= '</tr>
									</table>
								</div>
								<h5><b>'.$result_value->test_name.'</b></h5>
								<table class="full-width">
									<tr>
										<td style="border-right: 0px !important;">SPECIMAN</td>
										<td class="text-left" style="border-left: 0px !important;padding-left: 5px !important; font-weight: normal;">'.strtoupper($result_value->specimen).'</td>
									</tr>
									<tr>
										<td style="border-right: 0px !important;">GRAM STAIN</td>
										<td class="text-left" style="border-left: 0px !important;padding-left: 5px !important; font-weight: normal;">'.$result_value->gram_stain.'</td>
									</tr>
									<tr>
										<td style="border-right: 0px !important;">CULTURE</td>
										<td class="text-left" style="border-left: 0px !important;padding-left: 5px !important; font-weight: normal;">'.$result_value->culture.'</td>
									</tr>
									<tr>
										<td colspan="2" style="border: 0px !important; margin-bottom: 0px">
										<br/>
										<br/>
										<br/>
										<h5><b>GRAM STAIN</b></h5></td>
									</tr>
									<tr>
										<td style="border-right: 0px !important;">SPECIMAN</td>
										<td class="text-left" style="border-left: 0px !important;padding-left: 5px !important; font-weight: normal;">'.strtoupper($result_value->specimen).'</td>
									</tr>
									<tr>
										<td style="border-right: 0px !important;">MICROSCOPIC</td>
										<td class="text-left" style="border-left: 0px !important;padding-left: 5px !important; font-weight: normal;">'.$result_value->gram_stain.'</td>
									</tr>
								</table>
							</div>';
								$test_count++;
							@endphp   
						@endforeach                     
					@else
						@php $test_count = 0; @endphp
						@foreach ($culture_results as $result_key => $result_value)
							@php                        
								$sheet_name = $tab_name.'_test_'.$test_count;
							@endphp                        
							@if ($test_count == (count($culture_results) - 1))
								@php 
									$tab_content .= '<li class="active"><a href="#'.$sheet_name.'" data-toggle="tab">Test '. ($test_count + 1) .' </a></li>'; 
									$result_content .= '<div class="tab-pane active" id="'.$sheet_name.'">';
								@endphp
							@else
								@php 
									$tab_content .= '<li><a href="#'.$sheet_name.'" data-toggle="tab">Test '. ($test_count + 1) .' </a></li>'; 
									$result_content .= '<div class="tab-pane" id="'.$sheet_name.'">';
								@endphp
							@endif
							@php
								$result_value_test_name = str_replace('BLOODCULTURE', 'BLOOD CULTURE ', $result_value->test_name);
								$result_content .= '<h5 class="text-center">'.$result_value_test_name.'</h5>
								<table style="float:right !important">
									<tr>
										<td style="border: 0px !important;">Collected On</td>
										<td style="border: 0px !important; width: 130px; text-align: left;"> :'.date('d/m/Y h:i A', strtotime($result_value->result_collect_time)).'</td>
									</tr>
									<tr>
										<td style="border: 0px !important">Reported On</td>';
							@endphp
							@if (isset($result_value->result_report_time) && !empty($result_value->result_report_time))
								@php $result_content .= '<td style="border: 0px !important; width: 130px; text-align: left;"> :'.date('d/m/Y h:i A', strtotime($result_value->result_report_time)).'<br /></td>'; @endphp
							@else
								@php $result_content .= '<td style="border: 0px !important; width: 130px; text-align: left;"> : <br /></td>'; @endphp
							@endif
							@php                        
								$result_content .= '</tr>
								</table>
								<br />
								<table class="table text-left">
									<tr>
										<td width="20%" align="left" style="border-right: 0px !important;"><strong>SPECIMEN</strong></td>
										<td align="left" style="border-left: 0px !important;padding-left: 5px !important;"><strong>'.strtoupper($result_value->specimen).'</strong></td>
									</tr>';
							@endphp
							@if(isset($result_value->isolate_one_result) && !empty($result_value->isolate_one_result))
								@php
									$result_content .= '<tr>
										<td align="left" style="border-right: 0px !important;"><strong>ISOLATE - 1</strong></td>
										<td align="left" style="border-left: 0px !important;padding-left: 5px !important;"><strong>'.$result_value->isolate_one_result.'</strong></td>
									</tr>';
								@endphp
							@elseif(isset($result_value->culture) && !empty($result_value->culture))
								@php
									$result_content .= '<tr>
										<td align="left" style="border-right: 0px !important;"><strong>CULTURE</strong></td>
										<td align="left" style="border-left: 0px !important;padding-left: 5px !important;"><strong>'.$result_value->culture.'</strong></td>
									</tr>';
								@endphp
							@endif
							@if(isset($result_value->isolate_two_result) && !empty($result_value->isolate_two_result))
								@php
									$result_content .= '<tr>
										<td align="left" style="border-right: 0px !important;"><strong>ISOLATE - 2</strong></td>
										<td align="left" style="border-left: 0px !important;padding-left: 5px !important;"><strong>'.$result_value->isolate_two_result.'</strong></td>
									</tr>';
								@endphp
							@endif
							@php
								$result_content .= '</table>';
								$urine_culture_results_antibiotics = $microbiology_results_items->where('report_id', $result_value->id)->sortBy('drug_name')->toArray();
							@endphp
							@if(count($urine_culture_results_antibiotics) > 0)
								@php
									$result_content .= '<br /><h5 style="text-align: center;">ANTIBIOTIC SUSCEPTIBILITY TESTING</h5>
									<table class="table">
										<tr>
											<td><strong>ANTIBIOTIC</strong></td>
											<td colspan="2"><strong>ISOLATE - 1</strong></td>
											<td colspan="2"><strong>ISOLATE - 2</strong></td>
										</tr>';
								@endphp
								@foreach($urine_culture_results_antibiotics as $item_key => $item_value)
									@php
										$result_value_1 = $result_value_2 = '';
										if(!is_null($item_value->result_one))
										{
											$result_value_1 = $item_value->result_one . ' '.$item_value->result_one_unit;
										}
										if(!is_null($item_value->result_two))
										{
											$result_value_2 = $item_value->result_two . ' '.$item_value->result_two_unit;
										}
										$result_content .= '<tr>
											<td>'. $item_value->drug_name .'</td>
											<td style="border-right: 0px !important;">'. $item_value->isolate_one .'</td>
											<td style="border-left: 0px !important;">'. $result_value_1 .'</td>
											<td style="border-right: 0px !important;">'. $item_value->isolate_two .'</td>
											<td style="border-left: 0px !important;">'. $result_value_2 .'</td>
										</tr>';
									@endphp
								@endforeach
								@php
									$result_content .= '</table>';
								@endphp
							@endif
							@php
								$result_content .= '</div>';
									$test_count++;
									@endphp
						@endforeach
					@endif
					@if ($i == 0)
					<div class="tab-pane active" id="{{$tab_name}}">
						<div class="hidden-print tabbable tabbable-custom pull-right">
							<ul class="nav nav-tabs tabs-left {{$tab_name}}_sheet">
								@php 
									echo $tab_content; 
								@endphp
							</ul>
						</div>
						<div class="print-full-width full-width pull-left">
							<div class="tab-content sub-content">
								@php 
									echo $result_content; 
								@endphp
							</div>
						</div>
					</div>
					@else
					<div class="tab-pane" id="{{$tab_name}}">
						<div class="hidden-print tabbable tabbable-custom pull-right">
							<ul class="nav nav-tabs tabs-left {{$tab_name}}_sheet">
								@php 
									echo $tab_content; 
								@endphp
							</ul>
						</div>
						<div class="print-full-width full-width pull-left">
							<div class="tab-content sub-content">
								@php 
									echo $result_content; 
								@endphp
							</div>
						</div>
					</div>
					@endif
					@php 
						$i++;
					@endphp
				@endforeach   
			</div>
		</div>
	</div>
</div>
