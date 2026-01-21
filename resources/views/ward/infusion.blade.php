<table class="table syringe-pump-list-view">
	<thead>
		<tr>
			<th>Drug Name</th>
			<th>Infused Rate</th>
			<th>Remaining</th>
			<th>vitbi</th>
			<th>running</th>
			<th>programed</th>

		</tr>
	</thead>
	<body>
		@php $i=0; @endphp
		@foreach($list_drug_name as $drugs)
		@if( isset($list_infused[$i]->mean) && isset($list_drug_remaining[$i]->mean) && isset($list_drug_vtbi[$i]->mean) && isset($list_drug_running[$i]->mean) && isset($list_drug_programe[$i]->mean))
			<tr>
				@if(isset($drugs->mean))
				<td>{!! $drugs->mean !!}</td>
				@else<td></td>
				@endif
				@if(isset($list_infused[$i]->mean))
				<td>{!! $list_infused[$i]->mean !!}</td>
				@else
				<td></td>@endif
				@if(isset($list_drug_remaining[$i]->mean ))
				<td>{!! $list_drug_remaining[$i]->mean !!}</td> 
				@else
				 <td></td>
				@endif
				@if(isset($list_drug_vtbi[$i]->mean))
				<td>{!! $list_drug_vtbi[$i]->mean !!}</td>
				@else
				<td></td>
				@endif
				@if(isset($list_drug_running[$i]->mean))
				<td>{!! $list_drug_running[$i]->mean !!}</td>
                @else
                <td></td>
                @endif
                @if(isset($list_drug_programe[$i]->mean))
				<td>{!! $list_drug_programe[$i]->mean !!}</td>
				@else
				<td></td>
				@endif
			</tr>
	    @endif		
		@php $i++; @endphp
		@endforeach
		
	</body>
</table>