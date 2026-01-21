<?php
// header("Content-Type: application/vnd.ms-excel; charset=utf-8");
// header("Content-Type: application/xlsx");

// We'll be outputting an excel file
	
	// header('Content-type: application/vnd.ms-excel');
	// header("Content-Disposition: attachment; filename=".$file_name);  //File name extension was wrong
	// header("Expires: 0");
	// header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	// header("Cache-Control: private",false);
	// header("Pragma: no-cache"); 
	// ob_end_clean();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
	<table border="1">
		<tbody>
			<tr>
				<th style="color: red;">{{ $mrn }}</th>
				<th>{{ $babyname }}</th>
			</tr>
			<tr>
			<?php
				echo '<td></td>';
				$date_list = array_values($date_list);

				foreach ($date_list as $key => $value) {

							$temp_key = $key + 1;

							$j =  $temp_key % 10;
							$k =  $temp_key % 100;
							$suffix =  $temp_key . "th";
							if ($j == 1 && $k != 11) {
								$suffix =  $temp_key . "st";
							}
							if ($j == 2 && $k != 12) {
								$suffix =  $temp_key . "nd";
							}
							if ($j == 3 && $k != 13) {
								$suffix =  $temp_key . "rd";
							}

					if (isset($date_list[$key+1])) {

					echo '<td><strong>'.date('d M', strtotime($value)) . ' - ' . date('d M Y', strtotime($date_list[$key+1])). '<br/> (' . $suffix.') 24 Hrs</strong></td>';
				} else {
					echo '<td><strong>'.date('d M Y', strtotime($value)) .' (' . $suffix.')</strong></td>';
				}

				}
				echo "</tr>";
				foreach ($results as $result_key => $result_value) {
					echo '<tr>';
					echo '<td><strong>'.$result_key.':00</strong></td>';
					foreach ($result_value as $hero_key => $hero_value) {
						echo '<td>'.$hero_value[0]->mean.'</td>';
					}
					echo '</tr>';
				}

			?>
		</tbody>
	</table>
</body>
</html>