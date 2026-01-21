@extends('print')
@section('content')
<style type="text/css">
    .female-baby {
        color: #FFB3B3;
    }
    .male-baby {
        color: #6e9ce8;
    }
    .baby-print table td.female-baby-frame {
        border: 10px solid #FFB3B3 !important;
        box-shadow: inset 0 0 10px #000000;
    }
    .baby-print table td.male-baby-frame {
        border: 10px solid #6e9ce8 !important;
        box-shadow: inset 0 0 10px #000000;
    }
</style>
<div class="temp-container baby-print">
	<div class="temp-row">
		<div class="col-md-12">
        @for ($i = 0; $i < @count($results); $i++)
        @for ($j = 0; $j < 2; $j++)
            <div class="content-block">
                <table class="table" border="0">
                    <thead>
                        <tr>	
                        	<th colspan="5" align="center"><span class="@if($results[$i]->Sex == 'Female') female-baby @else male-baby @endif"><strong>BABY IDENTIFICATION TAG</strong></span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                           <td align="right" width="20%" class="print-label-text">Name</td>
                           <td colspan="3" class="text-captialize"><strong>{{  $results[$i]->BabyName }}</strong></td>
                           <td rowspan="9" class="@if($results[$i]->Sex == 'Female') female-baby-frame @else male-baby-frame @endif" style="width: 250px"></td>
                        </tr>
                        <tr>
                            <td align="right" class="print-label-text">{{ Lang::get('home.mrn') }}.</td>
                            <td colspan="3"><strong>{{  $results[$i]->BMrNo }}</strong></td>
                        </tr>
                        <tr>
                            <td align="right" class="print-label-text">DOB</td>
                            @php $results[$i]->TOB_TIME = (strlen($results[$i]->TOB_TIME) == 1) ? '0'.$results[$i]->TOB_TIME : $results[$i]->TOB_TIME ; @endphp
                            @php $results[$i]->TOB_MINS = (strlen($results[$i]->TOB_MINS) == 1) ? '0'.$results[$i]->TOB_MINS : $results[$i]->TOB_MINS ; @endphp

                            <td ><strong>{{  !is_null($results[$i]->DOB) ? date('d-m-Y',strtotime($results[$i]->DOB)) : '' }} {{ $results[$i]->TOB_TIME.':'.$results[$i]->TOB_MINS.' '.$results[$i]->TOB_AM }}</strong></td>

                        </tr>                                
                        <tr>
                            <td align="right" class="print-label-text">Sex</td>
                            <td ><strong>{{  $results[$i]->Sex  }}</strong></td>
                        </tr> 
                        <tr>
                            <td align="right" class="print-label-text">B Wt (gms)</td>
                            <td> <strong>{{ $results[$i]->BirthWeight }}</strong> </td>
                        </tr>
                        <tr>
                            <td align="right" class="print-label-text">Gestation</td>
                            <td colspan="3"><strong>{{  \SiteHelpers::decode_gestation($results[$i]->Gestation) }}</strong></td>
                        </tr>
                        <tr>
                        	<td align="right" class="print-label-text">Delivery</td>
                            <td colspan="3"><strong>{{  $results[$i]->ModeOfDelivery }}</strong></td>
                        </tr>
                        <tr>
                        	<td align="right" class="print-label-text">Consultant</td>
                            <td colspan="3"><strong>{{ SiteHelpers::get_doctors_name($results[$i]->neonatal_consultant) }}</strong></td>
                        </tr>
                        @if($results[$i]->obstetric_consultant != 0 && !is_null($results[$i]->obstetric_consultant))
                        <tr>
                            <td align="right" class="print-label-text">Consultant OBG</td>
                            <td colspan="3"><strong>{{ ValuelistHelpers::mas_doctors_list($results[$i]->obstetric_consultant) }}</strong></td>
                        </tr>
                        @endif
                    </tbody>
				</table>
            </div>
        @endfor

            <!-- <div class="content-block">
                <table class="table" border="0">
                    <thead>
                        <tr>
                        	<th colspan="4" align="center"><span><strong>BABY IDENTIFICATION TAG</strong></span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td align="right" width="20%" class="print-label-text">Name</td>
                            <td colspan="3"><strong><strong>{{  $results[$i]->BabyName }}</strong></strong></td>
                        </tr>
                        <tr>
                        	<td align="right" class="print-label-text">MRN.</td>
                            <td colspan="3"><strong>{{  $results[$i]->BMrNo }}</strong></td>
                        </tr>
                        <tr>
                        	<td align="right" class="print-label-text">DOB</td>
                            <td ><strong>{{  date('d-m-Y',strtotime($results[$i]->DOB)) }}</strong></td>
                            <td width="30%" align="right" class="print-label-text">Time of Birth</td>
                            <td width="20%"><strong> {{ $results[$i]->TOB_TIME.':'.$results[$i]->TOB_MINS.':'.$results[$i]->TOB_AM }} </strong></td>
                        </tr>                                
                        <tr>
                        	<td align="right" class="print-label-text">Sex</td>
                            <td ><strong>{{  $results[$i]->Sex  }}</strong></td>
                            <td align="right" class="print-label-text">B Wt (gms)</td>
                            <td> <strong>{{ $results[$i]->BirthWeight }} </strong></td>
                        </tr> 
                        <tr>
                        	<td align="right" class="print-label-text">Gestation</td>
                            <td colspan="3"><strong>{{  \SiteHelpers::decode_gestation($results[$i]->Gestation) }}</strong></td>
                        </tr>
                        <tr>
                        	<td align="right" class="print-label-text">Delivery</td>
                            <td colspan="3"><strong>{{  $results[$i]->ModeOfDelivery }}</strong></td>
                        </tr>
                        <tr>
                        	<td align="right" class="print-label-text">Consultant</td>
                            <td colspan="3"><strong>{{ SiteHelpers::get_doctors_name($results[$i]->neonatal_consultant) }}</strong></td>
                        </tr>
                        @if($results[$i]->obstetric_consultant != 0 && !is_null($results[$i]->obstetric_consultant))
                        <tr>
                            <td align="right" class="print-label-text">Consultant OBG</td>
                            <td colspan="3"><strong>{{ ValuelistHelpers::mas_doctors_list($results[$i]->obstetric_consultant) }}</strong></td>
                        </tr>
                        @endif
                    </tbody>
				</table>
            </div> -->
        @endfor
    <div class="page-break"></div>
	</div>        
  </div>
</div>
@endsection
