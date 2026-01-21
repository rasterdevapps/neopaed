<table class="table table-striped table-bordered table-responsive" id="data-list">
    <thead>
        <tr>
            <th>10% dextrose</th>
            <th>10% dextrose instruction</th>
            <th>Isolyte P</th>
            <th>Isolyte P instruction</th>
            <th>Aminoven</th>
            <th>Lipids</th>
            <th>Milk</th>
            <th>Type of milk</th>
        </tr>
    </thead>
    <tbody class="nutrition-data-body">
        @php
            $drug_dtl = $dextrose10 = $isolytep = $aminoven = $lipids = $data_set = [];
        @endphp

        @if (isset($drug_infused[$sheet_date]))
            @php 
                $drug_dtl = $drug_infused[$sheet_date];
                $dextrose10 = isset($drug_dtl[7]) ? $drug_dtl[7] : [];
                $isolytep = isset($drug_dtl[8]) ? $drug_dtl[8] : [];
                $aminoven = isset($drug_dtl[14]) ? $drug_dtl[14] : [];
                $lipids = isset($drug_dtl[15]) ? $drug_dtl[15] : [];
            @endphp
        @endif

        @if (is_array($dextrose10) && count($dextrose10) > 0)
            @php $i = 0; @endphp
            @foreach($dextrose10 as $item)
                @php $data_set[$i][0] = $item['day_infused']; @endphp
                @php $data_set[$i][1] = $item['instruction']; @endphp
                @php $i++; @endphp
            @endforeach
        @endif

        @if (is_array($isolytep) && count($isolytep) > 0)
            @php $k = 0; @endphp
            @foreach($isolytep as $item)
                @php $data_set[$k][2] = $item['day_infused']; @endphp
                @php $data_set[$k][3] = $item['instruction']; @endphp
                @php $k++; @endphp
            @endforeach
        @endif

        @if (is_array($aminoven) && count($aminoven) > 0)
            @php $m = 0; @endphp
            @foreach($aminoven as $item)
                @php $data_set[$m][4] = $item['day_infused']; @endphp
                @php $m++; @endphp
            @endforeach
        @endif

        @if (is_array($lipids) && count($lipids) > 0)
            @php $n = 0; @endphp
            @foreach($lipids as $item)
                @php $data_set[$n][5] = $item['day_infused']; @endphp
                @php $n++; @endphp
            @endforeach
        @endif

        @if (isset($day_wise_milk_volume[$sheet_date]))
            @php $o = 0; @endphp
            @foreach($day_wise_milk_volume[$sheet_date] as $type => $vol)
                @php $data_set[$o][6] = $vol; @endphp
                @php $data_set[$o][7] = $type; @endphp
                @php $o++; @endphp
            @endforeach
        @endif

        @if(count($data_set) > 0)
            @for ($i = 0; $i < count($data_set); $i++)
                <tr>
                    @for ($j = 0; $j < 8; $j++)
                        @if (isset($data_set[$i][$j]) && !empty($data_set[$i][$j]))
                            <td>{!! $data_set[$i][$j] !!}</td>
                        @else
                            <td>-</td>
                        @endif
                    @endfor
                </tr>
            @endfor
        @else
             <tr><td colspan="8" class="text-center">No Data Available</td></tr>
        @endif
    </tbody>
</table>
