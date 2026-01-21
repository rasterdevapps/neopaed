<div class="col-md-12 assessement-header assessement-header-container">                
    <div class="row header-align">
        <div class="col-xs-4">
            <div class="row">
                <img src="{{ ValuelistHelpers::printPagelogo() }}" class="expect">
            </div>
        </div>
        <div class="col-xs-8">
            <!-- <div class="col-xs-3 text-center"> -->
                <!-- <div class="row"> -->
                    <h3 class="m-0">
                        <b id="title"></b>
                    <!-- </h3> -->
                <!-- </div> -->
            <!-- </div> -->
            <!-- <div class="col-xs-9 text-center"> -->
                <!-- <div class="row"> -->
                    <!-- <h3 class="m-0 text-center"> -->
                        <span class="pull-right p-5 assessment-block">
                            <p><b class="assessment-score">&nbsp</b></p>
                            <p><b class="assessment-status">&nbsp</b></p>
                        </span>
                    </h3>
                <!-- </div> -->
            <!-- </div> -->
        </div>
    </div>
    <div class="row">
        <div class="basic-details">
            <table>
                <tr>
                    <td class="text-left">{{ Lang::get('home.mrn') }}:</td>
                    <td class="text-left"><b>{{ $baby_detail->BMrNo }}</b></td>
                    <td class="text-left">Baby Name:</td>
                    <td class="text-left"><b>{{ $baby_detail->BabyName }}</b></td>
                </tr>
                <tr>
                    <td class="text-left">DOB:</td>
                    <td class="text-left"><b>{{ date('d-m-Y', strtotime($baby_detail->DOB)) }}</b></td>
                    @if ($results->g_weeks > 36)
                    <td class="text-left">Chronological Age:</td>
                    <td class="text-left"><b>{{ $results->chronological_year > 0 ? $results->chronological_year . ' Y ' : '' }} {{ $results->chronological_month > 0 ? $results->chronological_month . ' M' : '' }} {{ $results->chronological_days > 0 ? $results->chronological_days . ' D' : '' }}</b></td>
                    @else
                    <td class="text-left">Corrected Age:</td>
                    <td class="text-left"><b>{{ $results->corrected_year > 0 ? $results->corrected_year . ' Y ' : '' }} {{ $results->corrected_month > 0 ? $results->corrected_month . ' M' : '' }} {{ $results->corrected_days > 0 ? $results->corrected_days . ' D' : '' }}</b></td>
                    @endif
                </tr>
            </table>
        </div>
    </div>
</div>
