@extends('print')
@section('content')
@if (isset($editor_gen) && $editor_gen)
<div class="editor_style">
  @include('editor_print')  
</div>
@endif
<div class="temp-container post-daycare">
    <div class="temp-row">
        <div class="col-md-12">
            <img src="{{ SiteHelpers::getPostnatalLogo($pid) }}">
        </div>
        <div class="col-md-12 mt-10">
            <h3 class="print-head mt-0">POSTNATAL DAYCARE SHEET</h3>
        </div>
        <div class="col-md-12">
            <div class="content-block mt-must-0">
                <h4>Basic Details</h4>
                <div class="content-section">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <span class="print-label">Date:</span>
                            <span class="print-value"> {!! date("d-m-Y",strtotime($results->DayDate)); !!} </span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">{{ Lang::get('home.mrn') }}:</span>
                            <span class="print-value">{!! $results->BMrNo; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Name:</span> 
                            <span class="print-value">{!! $results->BabyName; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">DOB:</span> 
                            <span class="print-value">{!! date("d-m-Y",strtotime($results->DOB)); !!}</span>
                        </div>
                        <!-- <div class="form-group">
                            <span class="print-label">Background:</span><br /> {!! $results->Background; !!}
                        </div> -->
                        <div class="form-group">
                            <span class="print-label">Background:</span>
                        </div>
                        <div class="form-group">
                            <span class="print-value full-width-must">{!! $results->Background; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Mother Blood Group:</span>
                            <span class="print-value">{!! $results->MotherBloodGroup; !!}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <span class="print-label">Time:</span> 
                            <span class="print-value">{!! $results->DayTime !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">{{ Lang::get('home.ip') }}:</span>
                            <span class="print-value">{!! $ip_number; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Admission Type:</span> 
                            <span class="print-value">{!! isset($postanatal_admission->typeofcare) ? $postanatal_admission->typeofcare : ''; !!}</span>
                         </div>
                         <div class="form-group">
                            <span class="print-label">Sex:</span>
                            <span class="print-value">{!! $results->Sex; !!}</span>
                        </div> 
                        <div class="form-group">
                            <span class="print-label">Gestation:</span> 
                            <span class="print-value">{!! ValuelistHelpers::formateGestation($results->Gestation); !!}</span>
                        </div> 
                        <div class="form-group">
                            <span class="print-label">Day of life:</span> 
                            <span class="print-value">{!! $results->DayOfLife; !!}</span>
                        </div> 
                        <div class="form-group">
                            <span class="print-label">Baby\'s Blood Group:</span> 
                            <span class="print-value">{!! $results->BabyBloodGroup; !!}</span>
                       </div>  
                   </div>
               </div>
            </div>
            <div class="content-block">
                <h4>Problems</h4>
                <div class="content-section">
                    <div class="col-xs-12 col-md-12">
                        <div class="form-group">
                            <span class="print-label full-width-must">Current Problems:</span> 
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-12">
                        <div class="form-group">
                            <span class="print-value full-width-must">{!! str_replace('||', ', ', $results->CurrentProblems); !!} </span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-12">
                        <div class="form-group">
                            <span class="print-label full-width-must">Previous Problems:</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-12">
                        <div class="form-group">
                            <span class="print-value full-width-must">{!! str_replace('||', ', ', $results->PreviousProblems); !!}</span>
                        </div>
                    </div> 
                    <div class="col-xs-12 col-md-12">
                        <div class="form-group">
                            <span class="print-label full-width-must">Background:</span> 
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-12">
                        <div class="form-group">
                            <span class="print-value full-width-must">{!! $results->Background; !!}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-break"></div>
            <div class="content-block custom-print">
                <h4>OTHERS</h4>
                <div class="content-section">
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <div class="form-group">
                            <span class="print-label">Anterior Fontanelle:</span> 
                            <span class="print-value">{!! $results->AnteriorFontanelle; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Cephalhematoma:</span>
                            <span class="print-value"> {!! $results->Cephalhematoma; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Color:</span>
                            <span class="print-value">{!! $results->Color !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Activity:</span>
                            <span class="print-value">{!! $results->Activity; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Eye Infection:</span>
                            <span class="print-value"> {!! $results->EyeInfection; !!} </span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Passed Urine:</span>
                            <span class="print-value">{!! $results->PassedUrine; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Birth Weight (grams):</span>
                            <span class="print-value">{!! $results->BirthWeight; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Weight Change from Birth (grams):</span>
                            <span class="print-value">{!! $results->WtChangeBirth; !!}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <div class="form-group">
                            <span class="print-label">Genitalia:</span>
                            <span class="print-value">{!! $results->Genitalia; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Neonatal Jaundice:</span>
                            <span class="print-value">{!! $results->NeonatalJaundice; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">TcB mg/dl:</span>
                            <span class="print-value">{!! $results->TCB; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">TSB mg/dl:</span> 
                            <span class="print-value">{!! $results->TSB; !!} </span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Phototherapy:</span>
                            <span class="print-value"> {!! $results->Phototherapy; !!}</span>
                        </div>
                        <br>
                        <div class="form-group">
                            <span class="print-label">Previous Weight (grams):</span>
                            <span class="print-value">{!! $results->PreviousWt; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Weight Change from Previous (grams):</span>
                            <span class="print-value">{!! $results->WtChange; !!}</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <div class="form-group">
                            <span class="print-label">Respiratory Distress:</span> 
                            <span class="print-value">{!! $results->RespiratoryDistress; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Cardiac Murmur:</span>
                            <span class="print-value"> {!! $results->CardiacMurmur; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Femorals:</span>
                            <span class="print-value"> {!! $results->Femorals; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Umbilical Infection:</span> 
                            <span class="print-value">{!! $results->UmbilicalInfection; !!} </span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Hips:</span> 
                            <span class="print-value">{!! $results->Hips; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">BowelsOpen:</span>
                            <span class="print-value">{!! $results->BowelsOpen; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">Current Weight (grams):</span>
                            <span class="print-value">{!! $results->CurrentWt; !!}</span>
                        </div>
                        <div class="form-group">
                            <span class="print-label">HB:</span>
                            <span class="print-value">{!! $results->hb; !!}</span>
                        </div>
                    </div>
                    @php 
                        $drugs = json_decode($results->postnatal_other_drugs);
                        $mas_nont_antibio = ValuelistHelpers::getDrugIvFluidsNonAntibiotic();
                    @endphp
                    @if (is_array($drugs) && count($drugs) > 0)
                    <div class="clearfix"></div>
                    <table class="col-xs-6 col-sm-6 col-md-4 col-lg-4 plr-0">
                        <thead>
                            <tr>
                                <th><h5 class="m-0"><b>Drugs:</b></h5></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($drugs as $data)
                            <tr>
                                @if (preg_match('/[a-zA-Z]/', $data))
                                <td>{!! $data; !!}</td>
                                @else
                                <td>{!! isset($mas_nont_antibio[$data]) ? $mas_nont_antibio[$data] : ''; !!}</td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
            <div class="page-break"></div>

            <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0 page-break-page">         
                <div class="content-block">
                    <h4>Notes</h4>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="pl-10">{!! $results->Notes; !!}</div>
                        </div>
                    </div>
                </div>
                <div class="content-block">
                    <h4>Management Plan</h4>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="pl-10">{!! $results->Plan; !!}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12 plr-must-0  mt-15">
                    <div class="col-xs-3 col-sm-3 col-md-3 plr-sm-0">
                        <p class=" col-md-11 plr-must-0">Date : <b>{!! date("d-m-Y",strtotime($results->DayDate)); !!}</b></p>
                        <p class=" col-md-11 plr-must-0"> Place: <b>{{ env('LOCATION') }} </b></p>
                    </div>
                    @if (!empty($results->SeenBy))
                    <div class="col-xs-9 col-sm-9 col-md-9 pull-right text-center mt-15 pr-sm-0">
                        @php 
                            $seen_by = $results->SeenBy; 
                            $seen_by = (array)$seen_by;
                            $seen_by = json_encode($seen_by);
                            $seen_by = \ValuelistHelpers::signatureFormat($seen_by);
                        @endphp
                        {!! $seen_by !!}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')

<script type="text/javascript">
$('.open-editor').click(function() {
    bootbox.confirm("If you edit this document, the changes will not be reflected in the main database and vice versa. Do you still want to continue?",function(confirmed){
        if(confirmed){
            var requestUrl = "{{ url('postnatal-daycare-abbreviated/'.Request::segment(2)) }}";
            $.ajax({
                type: "GET",
                url: '{{ url("postnatal-daycare-reports-editors") }}',
                data: {
                    dataUrl: requestUrl,
              },
                cache: false,
                dataType: "json",
                success: function(responseText) {
                    window.location = requestUrl;
                },
                error: function(response) {}
            });
        }
    });
}); 
</script>
@endsection
    
