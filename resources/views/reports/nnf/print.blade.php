@extends('print')
@section('content')
<style type="text/css">
.vertical-align-middle, td {
    vertical-align: middle !important;
}
</style>
<div class="temp-container">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <img src="{{ ValuelistHelpers::printPagelogo() }}" >
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <h3 class="print-head">NNF Report ( {!! date('d-m-Y', strtotime($start_date)) !!} to {!! date('d-m-Y', strtotime($end_date)) !!} )</h3>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th colspan="5">A. UNIT'S PERFORMANCE DATA</th>
                </tr>
                <tr>
                    <th>S.No.</th>
                    <th>Parameter</th>
                    <th colspan="3">Value / Details</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td rowspan="3" class="vertical-align-middle">1.</td>
                    <td rowspan="3" class="vertical-align-middle">Total, inborn and outborn babies admitted</td>
                    <td colspan="2">Total</td>
                    <td>{!! $baby_count !!}</td>
                </tr>
                <tr>
                    <td colspan="2">Inborn</td>
                    <td>{!! $inborn_baby_count !!}</td>
                </tr>
                <tr>
                    <td colspan="2">Outborn</td>
                    <td>{!! $outborn_baby_count !!}</td>
                </tr>
                <tr>
                    <td rowspan="9" class="vertical-align-middle">2.</td>
                    <td rowspan="9" class="vertical-align-middle">Total number of babies admitted with LBW (low birth weight), VLBW and ELBW & their respective percentages</td>
                    <td rowspan="3">LBW</td>
                    <td>Total</td>
                    <td>{!! $lbw_count !!}</td>
                </tr>
                <tr>
                    <td>Inborn</td>
                    <td>{!! $lbw_inborn_count !!}</td>
                </tr>
                <tr>
                    <td>Outborn</td>
                    <td>{!! $lbw_outborn_count !!}</td>
                </tr>
                <tr>
                    <td rowspan="3">VLBW</td>
                    <td>Total</td>
                    <td>{!! $vlbw_count !!}</td>
                </tr>
                <tr>
                    <td>Inborn</td>
                    <td>{!! $vlbw_inborn_count !!}</td>
                </tr>
                <tr>
                    <td>Outborn</td>
                    <td>{!! $vlbw_outborn_count !!}</td>
                </tr>
                <tr>
                    <td rowspan="3">ELBW</td>
                    <td>Total</td>
                    <td>{!! $elbw_count !!}</td>
                </tr>
                <tr>
                    <td>Inborn</td>
                    <td>{!! $elbw_inborn_count !!}</td>
                </tr>
                <tr>
                    <td>Outborn</td>
                    <td>{!! $elbw_outborn_count !!}</td>
                </tr>
                <tr>
                    <td>3.</td>
                    <td>Total number of babies referred-out for surgical & nonsurglcal reasons</td>
                    <td colspan="3">{!! $refer_out_count !!}</td>
                </tr>
                <tr>
                    <td>4.</td>
                    <td>Total number of babies referred-in</td>
                    <td colspan="3"></td>
                </tr>
                <tr>
                    <td rowspan="3" class="vertical-align-middle">5.</td>
                    <td rowspan="3" class="vertical-align-middle">Mortality figures - total, inborn and out born and their group mortality %</td>
                    <td colspan="2">Total</td>
                    <td>{!! $died_count !!}</td>
                </tr>
                <tr>
                    <td colspan="2">Inborn</td>
                    <td>{!! $inborn_died_count !!}</td>
                </tr>
                <tr>
                    <td colspan="2">Outborn</td>
                    <td>{!! $outborn_died_count !!}</td>
                </tr>
                <tr>
                    <td rowspan="9" class="vertical-align-middle">6.</td>
                    <td rowspan="9" class="vertical-align-middle">Mortality in total, LBW, VLBW, ELBW babies and their group mortality %</td>
                    <td rowspan="3">LBW</td>
                    <td>Total</td>
                    <td>{!! $lbw_died_count !!}</td>
                </tr>
                <tr>
                    <td>Inborn</td>
                    <td>{!! $lbw_inborn_died_count !!}</td>
                </tr>
                <tr>
                    <td>Outborn</td>
                    <td>{!! $lbw_outborn_died_count !!}</td>
                </tr>
                <tr>
                    <td rowspan="3">VLBW</td>
                    <td>Total</td>
                    <td>{!! $vlbw_died_count !!}</td>
                </tr>
                <tr>
                    <td>Inborn</td>
                    <td>{!! $vlbw_inborn_died_count !!}</td>
                </tr>
                <tr>
                    <td>Outborn</td>
                    <td>{!! $vlbw_outborn_died_count !!}</td>
                </tr>
                <tr>
                    <td rowspan="3">ELBW</td>
                    <td>Total</td>
                    <td>{!! $elbw_died_count !!}</td>
                </tr>
                <tr>
                    <td>Inborn</td>
                    <td>{!! $elbw_inborn_died_count !!}</td>
                </tr>
                <tr>
                    <td>Outborn</td>
                    <td>{!! $elbw_outborn_died_count !!}</td>
                </tr>
                <tr>
                    <td rowspan="10" class="vertical-align-middle">7.</td>
                    <td rowspan="10" class="vertical-align-middle">LAMA (Left Against Medical Advice)/ DOR (Discharge On Request) rate in total, LBW, VLBW, ELBW babies and their group %</td>
                    <td colspan="2">Total</td>
                    <td>{!! $LAMA_DOR_total_count !!}</td>
                </tr>
                <tr>
                    <td rowspan="3">LBW</td>
                    <td>Total</td>
                    <td>{!! $LAMA_DOR_lbw_count !!}</td>
                </tr>
                <tr>
                    <td>Inborn</td>
                    <td>{!! $LAMA_DOR_lbw_inborn_count !!}</td>
                </tr>
                <tr>
                    <td>Outborn</td>
                    <td>{!! $LAMA_DOR_lbw_outborn_count !!}</td>
                </tr>
                <tr>
                    <td rowspan="3">VLBW</td>
                    <td>Total</td>
                    <td>{!! $LAMA_DOR_vlbw_count !!}</td>
                </tr>
                <tr>
                    <td>Inborn</td>
                    <td>{!! $LAMA_DOR_vlbw_inborn_count !!}</td>
                </tr>
                <tr>
                    <td>Outborn</td>
                    <td>{!! $LAMA_DOR_vlbw_outborn_count !!}</td>
                </tr>
                <tr>
                    <td rowspan="3">ELBW</td>
                    <td>Total</td>
                    <td>{!! $LAMA_DOR_elbw_count !!}</td>
                </tr>
                <tr>
                    <td>Inborn</td>
                    <td>{!! $LAMA_DOR_elbw_inborn_count !!}</td>
                </tr>
                <tr>
                    <td>Outborn</td>
                    <td>{!! $LAMA_DOR_elbw_outborn_count !!}</td>
                </tr>
            </tbody>
        </table>
    <!--     <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th colspan="2">Transferred to other Hospital ({!! count($transferred) !!})</th>
                </tr>
                <tr>
                    <th>S.No.</th>
                    <th>UHID</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transferred as $key => $value)
                <tr>
                    <td>{!! $key + 1 !!}</td>
                    <td>{!! $value !!}</td>
                </tr>
                @endforeach
            </tbody>
        </table> -->
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th colspan="2">Died ({!! count($died) !!})</th>
                </tr>
                <tr>
                    <th>S.No.</th>
                    <th>UHID</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($died as $key => $value)
                <tr>
                    <td>{!! $key + 1 !!}</td>
                    <td>{!! $value->BMrNo !!} - {!! $value->BirthStatus !!}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
