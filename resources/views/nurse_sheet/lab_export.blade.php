	<table border="1">
		<tbody>
			<?php
			if ($sheet_name == 'tab1') {
				echo '<tr><td></td>';

				foreach ($date_list_1 as $date_time) {
					$date_time = substr_replace($date_time, ' (', '10', 1);
					echo '<td>'.$date_time.')</td>';
				}
				echo "</tr>";
				foreach ($test_names_1 as $result_key => $result_name) {
					if ($result_key == 'lba') {
						echo '<tr>';
						echo '<td colspan="'.(count($date_list_1)+1).'"><strong>BIOCHEMISTRY</strong></td>';
						echo '</tr>';
					}
					if ($result_key == 'lha') {
						echo '<tr>';
						echo '<td colspan="'.(count($date_list_1)+1).'"><strong>HAEMATOLOGY</strong></td>';
						echo '</tr>';
					}
					echo '<tr>';
					echo '<td>'.$result_name.'</td>';
					if (isset($results_1[$result_key]) && ($result_key != 'lhnb' && $result_key != 'lhob')) {
						$result_sub = '';
						if ($result_key == 'lhna') {
							$result_sub = isset($results_1['lhnb']) ? $results_1['lhnb'] : '';
						}
						if ($result_key == 'lhoa') {
							$result_sub = isset($results_1['lhob']) ? $results_1['lhob'] : '';
						}
						$result = $results_1[$result_key];
						foreach ($date_list_1 as $key => $value) {
							if (isset($result[$key])) {
								echo '<td>';
								$intf_ref_value = $result[$key][0]->intf_ref_value;
								$intf_ref_value = str_replace('<', '&lt;', $intf_ref_value);
								$intf_ref_value = str_replace('>', '&gt;', $intf_ref_value);
								echo $intf_ref_value;
								if (isset($result_sub[$key]) && count($result_sub[$key]) > 0 && isset($result_sub[$key][0]->intf_ref_value)) {
									echo '('.$result_sub[$key][0]->intf_ref_value.')';
								}
								echo '</td>';
							} else {
								echo '<td>-</td>';
							}
						}
					} else {
						foreach ($date_list_1 as $value) {
							echo '<td>-</td>';
						}
					}
					echo '</tr>';
				}
			} else if ($sheet_name == 'tab2') {
				echo '<tr><td></td>';

				foreach ($date_list_2 as $date_time) {
					$date_time = substr_replace($date_time, ' (', '10', 1);
					echo '<td>'.$date_time.')</td>';
				}
				echo "</tr>";
				foreach ($test_names_2 as $result_key => $result_name) {
					if ($result_key == 'lub') {
						echo '<tr>';
						echo '<td colspan="'.(count($date_list_2)+1).'"><strong>URINE</strong></td>';
						echo '</tr>';
					}
					if ($result_key == 'lpa') {
						echo '<tr>';
						echo '<td colspan="'.(count($date_list_2)+1).'"><strong>CSF / ASCITES / PLEURAL</strong></td>';
						echo '</tr>';
					}
					if ($result_key == 'lsa') {
						echo '<tr>';
						echo '<td colspan="'.(count($date_list_2)+1).'"><strong>STOOL</strong></td>';
						echo '</tr>';
					}
					echo '<tr>';
					echo '<td>'.$result_name.'</td>';
					if (isset($results_2[$result_key])) {
						$result = $results_2[$result_key];
						foreach ($date_list_2 as $key => $value) {
							if (isset($result[$key])) {
								echo '<td>'.$result[$key][0]->intf_ref_value.'</td>';
							} else {
								echo '<td>-</td>';
							}
						}
					} else {
						foreach ($date_list_2 as $value) {
							echo '<td>-</td>';
						}
					}					
					echo '</tr>';
				}
			} else if ($sheet_name == 'tab3') {
				foreach($results_3 as $tests_key => $tests_value) {
					echo '<tr><td colspan="5" style="border: 1px solid #000000; text-align: center;"><strong>'.$tests_key.'</strong></td></tr>';
					$gram_stain = false;
					$tests_value = collect($tests_value)->groupBy('temp_result_collect_time')->toArray();
					krsort($tests_value);
					foreach($tests_value as $test_key => $test_value) {
						foreach($test_value as $key => $value) {
							echo '<tr>
							<td><strong>Collected On: '.date('d-m-Y H:i A', strtotime($value->result_collect_time)).'</strong></td>
							<td><strong>Reported On: '.((!empty($value->result_report_time) && !is_null($value->result_report_time)) ? date('d-m-Y H:i A', strtotime($value->result_report_time)) : '').'</strong></td>
							</tr>';
							echo '<tr><td colspan="2" style="text-align: center;">'.$value->test_name.'</td></tr>';
							echo '<tr>
							<td>SPECIMEN</td>
							<td>'.strtoupper($value->specimen).'</td>
							</tr>';
							if (isset($value->gram_stain) && !empty($value->gram_stain) && str_contains($value->test_name, 'CSF')) {
								echo '<tr>
								<td>GRAM STAIN</td>
								<td>'.$value->gram_stain.'</td>
								</tr>';
								$gram_stain = true;
							}
							if (isset($value->culture) && !empty($value->culture)) {
								echo '<tr>
								<td>CULTURE</td>
								<td>'.$value->culture.'</td>
								</tr>';
							}
							if (isset($value->isolate_one_result) && !empty($value->isolate_one_result)) {
								echo '<tr>
								<td>ISOLATE - 1</td>
								<td>'.$value->isolate_one_result.'</td>
								</tr>';
							}
							if (isset($value->isolate_two_result) && !empty($value->isolate_two_result)) {
								echo '<tr>
								<td>ISOLATE - 2</td>
								<td>'.$value->isolate_two_result.'</td>
								</tr>';
							}
							if ($gram_stain && str_contains($value->test_name, 'CSF')) {
								echo '<tr>
								<td colspan="2" style="text-align: center;">GRAM STAIN</td>
								</tr>';
								echo '<tr>
								<td>SPECIMEN</td>
								<td>'.strtoupper($value->specimen).'</td>
								</tr>';
								echo '<tr>
								<td>MICROSCOPIC</td>
								<td>'.$value->gram_stain.'</td>
								</tr>';
							}
							$urine_culture_results_antibiotics = $microbiology_results_items->where('report_id', $value->id)->sortBy('drug_name')->toArray();
							if (count($urine_culture_results_antibiotics) > 0) {
								echo '<tr><td colspan="5"></td></tr>';
								echo '<tr>
								<td><strong>ANTIBIOTIC</strong></td>
								<td><strong>ISOLATE - 1</strong></td>
								<td><strong>ISOLATE - 2</strong></td>
								</tr>';
								foreach ($urine_culture_results_antibiotics as $micro_value) {
									$result_value_1 = $result_value_2 = '';
									if(!is_null($micro_value->result_one)) {
										$result_value_1 = $micro_value->result_one . ' '.$micro_value->result_one_unit;
									}
									if(!is_null($micro_value->result_two)) {
										$result_value_2 = $micro_value->result_two . ' '.$micro_value->result_two_unit;
									}
									$result_value_1 = str_replace('<', '&lt;', $result_value_1);
									$result_value_1 = str_replace('>', '&gt;', $result_value_1);
									echo '<tr>
									<td>'. $micro_value->drug_name .'</td>
									<td style="text-align: left;">'. $micro_value->isolate_one .'</td>
									<td style="text-align: left;">'. $result_value_1 .'</td>
									<td style="text-align: left;">'. $micro_value->isolate_two .'</td>
									<td style="text-align: left;">'. $result_value_2 .'</td>
									</tr>';
								}
							}
						}
					}
					echo '<tr><td colspan="5"></td></tr>';
					echo '<tr><td colspan="5"></td></tr>';
					echo '<tr><td colspan="5"></td></tr>';
					echo '<tr><td colspan="5"></td></tr>';
					echo '<tr><td colspan="5"></td></tr>';
				} 
			} else if ($sheet_name == 'tab4') {
				echo '<tr><td></td>';
				$date_list_4 = array_values($date_list_4);

				foreach ($date_list_4 as $date_time) {
					$date_time = substr_replace($date_time, ' (', '10', 1);
					echo '<td>'.$date_time.')</td>';
				}
				echo "</tr>";
				foreach ($test_names_4 as $result_key => $result_name) {
					echo '<tr>';
					echo '<td>'.$result_name.'</td>';
					if (isset($results_4[$result_key])) {
						$result = $results_4[$result_key];
						foreach ($date_list_4 as $value) {
							if (isset($result[$value])) {
								echo '<td>'.$result[$value][0]->intf_ref_value.'</td>';
							} else {
								echo '<td>-</td>';
							}
						}
					} else {
						foreach ($date_list_4 as $value) {
							echo '<td>-</td>';
						}
					}
					echo '</tr>';
				}
			} else if ($sheet_name == 'all_tab1') {
				echo '<tr><td></td>';
				$date_list_1 = array_values($date_list_1);

				foreach ($date_list_1 as $date_time) {
					$date_time = date('d-m-Y (H:i)', $date_time);
					echo '<td>'.$date_time.'</td>';
				}
				echo "</tr>";
				foreach ($test_names_1 as $result_key => $result_name) {
					if ($result_key == 'lba') {
						echo '<tr>';
						echo '<td colspan="'.(count($date_list_1)+1).'"><strong>BIOCHEMISTRY</strong></td>';
						echo '</tr>';
					}
					if ($result_key == 'lha') {
						echo '<tr>';
						echo '<td colspan="'.(count($date_list_1)+1).'"><strong>HAEMATOLOGY</strong></td>';
						echo '</tr>';
					}
					if ($result_name != 219 && $result_name != 223) {
						echo '<tr>';
						echo '<td>'.$description[$result_name].'</td>';
						if (isset($results_1[$result_name])) {
							$result_sub = '';
							if ($result_name == 218) {
								$result_sub = isset($results_1[219]) ? $results_1[219] : '';
							}
							if ($result_name == 222) {
								$result_sub = isset($results_1[223]) ? $results_1[223] : '';
							}
							$result = $results_1[$result_name];
							foreach ($date_list_1 as $value) {
								if (isset($result[$value])) {
									echo '<td>';
									$intf_ref_value = $result[$value][0]->rawResult;
									$intf_ref_value = str_replace('<', '&lt;', $intf_ref_value);
									$intf_ref_value = str_replace('>', '&gt;', $intf_ref_value);
									echo $intf_ref_value;
									if (isset($result_sub[$value]) && count($result_sub[$value]) > 0 && isset($result_sub[$value][0]->rawResult)) {
										echo '('.$result_sub[$value][0]->rawResult.')';
									}
									echo '</td>';
								} else {
									echo '<td>-</td>';
								}
							}
						} else {
							foreach ($date_list_1 as $value) {
								echo '<td>-</td>';
							}
						}
						echo '</tr>';
					}
				}
			} else if ($sheet_name == 'all_tab2') {
				echo '<tr><td></td>';
				$date_list_2 = array_values($date_list_2);

				foreach ($date_list_2 as $date_time) {
					$date_time = date('d-m-Y (H:i)', $date_time);
					echo '<td>'.$date_time.'</td>';
				}
				echo "</tr>";

				foreach ($test_names_2 as $result_key => $result_name) {
					if ($result_key == 'lub') {
						echo '<tr>';
						echo '<td colspan="'.(count($date_list_2)+1).'"><strong>URINE</strong></td>';
						echo '</tr>';
					}
					if ($result_key == 'lpa') {
						echo '<tr>';
						echo '<td colspan="'.(count($date_list_2)+1).'"><strong>CSF / ASCITES / PLEURAL</strong></td>';
						echo '</tr>';
					}
					if ($result_key == 'lsa') {
						echo '<tr>';
						echo '<td colspan="'.(count($date_list_2)+1).'"><strong>STOOL</strong></td>';
						echo '</tr>';
					}
					echo '<tr>';
					if ($result_key == 'lua') {
						echo '<td>Color</td>';
					} else if ($result_key == 'luu') {
						echo '<td>FE Na</td>';							
					} else if ($result_key == 'lpj') {							
						echo '<td>Miscellaneous</td>';
					} else {
						echo '<td>'.$description[$result_name].'</td>';
					}
					if (isset($results_2[$result_name])) {
						$result = $results_2[$result_name];
						foreach ($date_list_2 as $value) {
							if (isset($result[$value])) {
								echo '<td>'.$result[$value][0]->rawResult.'</td>';
							} else {
								echo '<td>-</td>';
							}
						}
					} else {
						foreach ($date_list_2 as $value) {
							echo '<td>-</td>';
						}
					}
					echo '</tr>';
				}
			} else if ($sheet_name == 'all_tab4') {
				echo '<tr><td></td>';
				$date_list_4 = array_values($date_list_4);

				foreach ($date_list_4 as $date_time) {
					$date_time = substr_replace($date_time, ' (', '10', 1);
					echo '<td>'.$date_time.')</td>';
				}
				echo "</tr>";
				foreach ($test_names_4 as $result_key => $result_name) {
					echo '<tr>';
					echo '<td>'.$result_name.'</td>';
					if (isset($results_4[$result_key])) {
						$result = $results_4[$result_key];
						foreach ($date_list_4 as $value) {
							if (isset($result[$value])) {
								echo '<td>'.$result[$value][0]->intf_ref_value.'</td>';
							} else {
								echo '<td>-</td>';
							}
						}
					} else {
						foreach ($date_list_4 as $value) {
							echo '<td>-</td>';
						}
					}
					echo '</tr>';
				}
			}
			?>
		</tbody>
	</table>