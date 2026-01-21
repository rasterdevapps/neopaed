<style type="text/css">
    .col-md-12 {
        width: 100%;
    }
    .col-md-6 {
        width: 50%;
    }
    .consultant {
        font-size: 1em;
    }
    .pull-left {
        float: left;
    }
    .pull-right {
        float: right;
    }
    .line-height {
        line-height: 20px;
    }
    .print-head {
        text-align: center;
        margin-bottom: 2px;
    }
    .print-label {
        font-weight: bold;
    }
    table {
        border-collapse: collapse;
    }
    .padding {
        padding: 10px;
    }
    .padding-tb {
        padding: 10px;
    }
    .padding-lr {
        padding: 0 10px;
    }
    .padding-none td {
        padding: 0;
    }
    .border {
        border: 1px solid black;
        margin-top: 10px;
    }
    .padding-b {
        padding-bottom: 10px;
    }
    .padding-t {
        padding-top: 10px;
    }
    .big {
        /*border: 1px solid black;*/
        /*border-top: 1px solid black;*/
        page-break-inside: avoid;
        page-break-before: always;
    }
   /* @page {
        margin-bottom: 40px;
    }*/
   /* body:first-child {
        border-bottom: 1px solid black !important;

    }*/
</style>
<div class="container">
    <table class="col-md-12 padding-none">
        <tr>
            <td colspan="2">
                <img src="{{ ValuelistHelpers::printPagelogo() }}">
            </td>
        </tr>
        <tr>
            <td style="width: 59%">
                <span class="consultant"><u>CONSULTANTS</u></span>
                {!! $headerContent['discharge_report_left'] !!}
            </td>
            <td class="line-height">
                <span class="consultant"><u>CONSULTANTS</u></span>
                {!! $headerContent['discharge_report_right'] !!}
            </td>
        </tr>
    </table>
    <div>
        <h3 class="print-head">OP Consultation Record</h3>
        <span class="pull-right print-label">Date : {!! date("d-m-Y",strtotime($results->OpDate)); !!} </span>
    </div>
    <table class="border col-md-12 padding-t">
        <tr> 
            <td class="padding">
                <div>
                    <span class="print-label">{{ Lang::get('home.mrn') }}:</span> 
                    {!! $results->BMrNo; !!}
                </div>
                <div>
                    <span class="print-label">Name:</span> 
                    {!! $results->BabyName; !!}
                </div>
                <div>
                    <span class="print-label">DOB:</span> 
                    {!! date("d-m-Y",strtotime($results->DOB)); !!}
                </div>
                <div>
                    <span class="print-label">Sex:</span> 
                    {!! $results->Sex; !!}
                </div>                            
                <div>
                    <span class="print-label">Gestation (wks):</span> 
                    {!! $results->Gestation; !!}
                </div>
            </td>
            <td class="padding">
                <div>
                    <span class="print-label">Birth Weight(g):</span> 
                    {!! $results->BirthWeight; !!}
                </div>
                <div>
                    <span class="print-label">Current Weight(g):</span> 
                    {!! $results->CurrentWt; !!}
                </div> 
                <div>
                    <span class="print-label">OFC (cm):</span> 
                    {!! $results->CurrentOFC; !!}
                </div>
                <div>
                    <span class="print-label">Length (cm):</span> 
                    {!! $results->CurrentLength; !!}
                </div>                                
            </td>
            <td class="padding">
                <div>
                    <span class="print-label">Chronological Age:</span> 
                    {!! empty($results->chronological_year)  ? ' <b> Y </b> 0' : ' <b> Y </b>'.$results->chronological_year ;  !!}
                    {!! empty($results->chronological_month) ? ' <b> M </b> 0' : ' <b> M </b>'.$results->chronological_month;  !!} 
                    {!! empty($results->chronological_days)  ? ' <b> D </b> 0' : ' <b> D </b>'.$results->chronological_days ;  !!}   
                    {!! empty($results->chronological_weeks) ? ' <b> W </b> 0' : ' <b> W </b>'.$results->chronological_weeks;  !!}
                </div>
                <div>
                    <span class="print-label">Corrected Age:</span> 
                    {!! empty($results->corrected_year)  ? ' <b> Y </b> 0' : ' <b> Y </b> '.$results->corrected_year ;  !!}
                    {!! empty($results->corrected_month) ? ' <b> M </b> 0' : ' <b> M </b> '.$results->corrected_month;  !!} 
                    {!! empty($results->corrected_days)  ? ' <b> D </b> 0' : ' <b> D </b> '.$results->corrected_days ;  !!}   
                    {!! empty($results->corrected_weeks) ? ' <b> W </b> 0' : ' <b> W </b> '.$results->corrected_weeks;  !!}
                </div>
                <div>
                    <span class="print-label">Mother Blood Group:</span> 
                    {!! $results->mother_blood_group; !!}
                </div>
                <div>
                    <span class="print-label">Baby's Blood Group:</span> 
                    {!! $results->BabyBloodGroup; !!}
                </div>
            </td>
        </tr>
    </table>
    <div class="padding-t col-md-12 big">
        <table class="border col-md-12">
            <thead><tr><th></th></tr></thead>
            <tbody>
                <tr>
                    <td class="big">
                        <div class="print-label padding-tb">Background Details:</div> 
                        <div class="padding-lr">{!! $results->baby_background; !!}</div>
                    </td>
                </tr>                                                       
                <tr>
                    <td class="big">
                        <div class="print-label padding-tb">Status:</div>
                        <div class="padding-lr">{!! $results->Complaints; !!}</div>
                    </td>
                </tr>
                <tr>
                    <td class="big">
                        <div class="print-label padding-tb">Development:</div>
                        <div class="padding-lr">{!! $results->Development; !!}</div>
                    </td>
                </tr>
                <tr>
                    <td class="big">
                        <div class="print-label padding-tb">Examination:</div>
                        <div class="padding-lr">{!! $results->Examination; !!}</div>
                    </td>
                </tr>
                <tr>
                    <td class="big">
                        <div class="print-label padding-tb">Diagnosis:</div>                
                        <div class="padding-lr">{!! $results->Diagnosis; !!}</div>
                    </td>
                </tr>
                <tr>
                    <td class="big">
                        <div class="print-label padding-tb">Advice:</div>
                        <div class="padding-lr">{!! $results->Advice; !!}</div>
                    </td>
                </tr>
                <tr>
                    <td class="big">
                        <div class="print-label padding-tb">Echocardiogram Report:</div>
                        <div class="padding-lr">{!! ($results->echocardiogram_report != '') ? $results->echocardiogram_report : 'N/A'; !!}</div>
                    </td>
                </tr>
                <tr>
                    <td class="big">
                        <div class="print-label padding-tb">Neurosonogram Report:</div>
                        <div class="padding-lr padding-b">{!! ($results->neurosonogram_report != '') ? $results->neurosonogram_report : 'N/A'; !!}</div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <table class="border col-md-12">
        <thead><tr><th></th><th></th><th></th><th></th></tr></thead>
        <tr>
            <td class="print-label padding-tb"> Medications:</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="print-label padding-lr">Drug</td>
            <td class="print-label padding-lr">Dose</td>
            <td class="print-label padding-lr">Frequency</td>
            <td class="print-label padding-lr">Duration</td>
        </tr>
        @foreach($medications as $medicine)   
            <tr>
                <td class="padding-lr padding-b">{!! $drug_data[$medicine->Medication] !!}</td>
                <td class="padding-lr padding-b">{!! $medicine->Dose !!}</td>
                <td class="padding-lr padding-b">{!! $medicine->Frequency !!}</td>
                <td class="padding-lr padding-b">{!! $medicine->Duration !!}</td>
            </tr>  
        @endforeach 
    </table>
    <table class="border col-md-12">     
        <thead><tr><th></th><th></th></tr></thead>                          
        <tbody>
            <tr class="padding-t">
                <td>
                    <div class="print-label padding-lr">Immunization:</div>
                    <div>{!! $results->Immunization; !!}</div>
                </td>
                <td>
            </tr>
            @if(isset($results->Vaccine) && is_array($results->Vaccine) && count($results->Vaccine) > 0 && $results->Immunization == 'Given')
            <tr>
                <td>
                    <span class="print-label padding-lr">Vaccine: </span>
                </td>
            </tr>
            <tr>
                <td>
                    @php $count = 1;  @endphp
                    @php $vaccine_count = count($results->Vaccine); @endphp
                    @foreach($results->Vaccine as $vaccine_code)
                        @if(isset($vaccine[$vaccine_code]))
                            @if($count == $vaccine_count) 
                                {!! $count.'. '.$vaccine[$vaccine_code].'.' !!}
                            @else 
                                {!! $count.'. '.$vaccine[$vaccine_code].',  ' !!}
                            @endif 
                        @endif  
                        @php $count++; @endphp  
                    @endforeach 
                </td>
            </tr>
            @endif 
            <tr>
                <td class="print-label padding-lr col-md-6">Next Review:</td>
                <td class="col-md-6">@if(date("Y",strtotime($results->Review)) > 1970) {!! date("d-m-Y",strtotime($results->Review)); !!} {!! $results->review_time.':'.$results->review_min.':'.$results->review_session  !!} @else {{ title_case('A Review Appoinment not been made.') }}  @endif</td>
            </tr>            
            <tr>
                <td class="big" colspan="2">
                    <div class="print-label padding-lr col-md-12">Next Review Indication :</span></div>
                    <div class="padding-lr padding-b col-md-12">{!! $results->nextreviewindication; !!}</div>
                </td>
            </tr>
        </tbody>
    </table>
    <div>
        <div class="pull-left col-md-6">
            <p>Date : {!! date("d-m-Y",strtotime($results->OpDate)); !!} </p>
            <p>Place: {!! env('LOCATION')!!}</p>
        </div>
        <div class="print-head">
            @foreach($doctors as $key => $value)
                @if($key == $results->SeenBy)
                    <p>{!! $value !!}</p>
                @endif
            @endforeach
            <p>Signature</p>
        </div>
    </div>
</div>
<script type="text/javascript">
    window.onafterprint = function(){
   console.log("Printing completed...");
}
</script>
