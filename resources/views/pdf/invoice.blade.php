<table>
	<thead>
		<tr>
		   <th>
			Baby Name
		   </th>
		   <th>
		   	Baby {{ Lang::get('home.mrn') }} 
		   </th>
	   </tr> 
	</thead>
	
	<tbody>
		<tr>
			<td>
				{{ $baby->BabyName }}
			</td>
			<td>
				{{ $baby->BMrNo }}
			</td>
		</tr>
	</tbody>
</table>
