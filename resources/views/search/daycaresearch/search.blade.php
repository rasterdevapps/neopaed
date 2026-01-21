@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow nicu-daycare-search">
    <ul id="breadcrumbs" class="breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="{{ url('/') }}">Dashboard</a>
        </li>
        <li class="">
            <a title="" href="{{ action('Admission\DaycareController@index') }}">Daycare</a>
        </li>
        <li class="current">
            <a title="">Search @if(isset($baby->BabyName) && !empty($baby->BabyName)) For {{ $baby->BabyName }} @endif</a>
        </li>
    </ul>
    <?php 
    if (isset($daycareList)) {
        $getTotal = count($daycareList);
        $total = @$count;
        $page = @$current_page;
        $limit = 10;
        $pagecount = ceil($total / $limit);
        $pagination['total'] = $total;
        $pagination['start'] = (($page - 2) < 1) ? 1 : ($page - 2);
        $pagination['end'] = ($pagecount < ($page + 3)) ? $pagecount : ($page + 3);
        $pagestart = $total != 0 ? ($page <= 1) ? $page : ($page - 1) * $limit + 1 : 0;
        $pagerecords = ($page == $pagination['end'] || $pagination['total'] == 0) ? $pagination['total'] : $page * $limit;
        $pagination['limit'] = array(
            $pagestart,
            $pagerecords
        );
        $pagination['limits'] = $limit;
        $pagination['previous'] = (($page - 1) < 1) ? 1 : ($page - 1);
        $pagination['next'] = ($pagecount < ($page + 1)) ? $pagecount : ($page + 1);

        $last_page = ceil($total/10);
    }
    $page = isset($page) ? $page : 1;
    ?>
    <div class="pull-right">
        @if(isset($daycare_last) && is_array($daycare_last))
        <table class="table">
            <tr>
                @if (@$baby->day_id != $very_first)
                <td><a class="forward-boot-class" href="{{ action('Search\SearchDaycareController@index', \SiteHelpers::encrypt_id($very_first) . '?daycare_count=' . $count.'&page=1&query_log_id='.@$query_log_id . '&very_first=' . $very_first . '&very_last=' . $very_last) }}"><i class="fa fa-fast-backward fa-2x" title="Previous Page" aria-hidden="true"></i></a></td>
                @endif
                @if(isset($daycare_last[0]) &&  !empty($daycare_last[0]) && @$baby->day_id != $very_first)
                <td><a class="forward-boot-class"  href="{{ @$daycare_last[0] }}"><i class="fa fa-backward fa-2x" title="Previous Page"  aria-hidden="true"></i></a></td>
                @endif
                @if(isset($daycare_last[1]) &&  !empty($daycare_last[1]) && @$baby->day_id != $very_last)
                <td><a class="forward-boot-class" href="{{ @$daycare_last[1] }}"><i class="fa fa-forward fa-2x" title="Next Page" aria-hidden="true"></i></a></td>
                @endif
                @if (@$baby->day_id != $very_last)
                <td><a class="forward-boot-class"  href="{{ action('Search\SearchDaycareController@index', \SiteHelpers::encrypt_id($very_last) . '?daycare_count=' . $count.'&page='.$last_page.'&query_log_id='.@$query_log_id . '&very_first=' . $very_first . '&very_last=' . $very_last . '&last=true') }}"><i class="fa fa-fast-forward fa-2x" title="Next Page"  aria-hidden="true"></i></a></td>
                @endif
            </tr>
        </table>
        @endif    
    </div>
    <div class="pull-right reset-search">
        <table>
            <tr>
                @if(isset($count))
                <td class="p-10">No.Record : {{ $count }}</td>
                <td><a class="btn btn-info btn-basic-shadow reset-btn2" href="{{ action('Search\SearchDaycareController@create') }}"> Reset </a></td>
                <td><a class="btn btn-info btn-basic-shadow export reset-btn2" href="{{ url('daycare-search-export') }}"> Export </a></td>
                @endif
            </tr>
        </table>
    </div>
</div>
<!-- /Breadcrumbs line -->
<div class="row row-spacing">
    <div class="col-md-9 col-sm-9 col-xs-9 pr-0 daycare-edit tab-view-shadow">
        {!! Form::model($baby,['url' => action('Search\SearchDaycareController@index','0'),'method' => 'get']) !!}
        @include('errors.list')
        {!! Form::hidden('query_log_id', @$query_log_id) !!}
        <!-- Nav tabs -->
        <div role="tabpanel" class="tabbable tabbable-custom">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#generalform" role="tab" data-toggle="tab">
                        General Information
                    </a>
                </li>
                <li role="presentation">
                    <a href="#resform" role="tab" data-toggle="tab">
                        Respiratory System
                    </a>
                </li>
                <li role="presentation">
                    <a href="#cardioform" role="tab" data-toggle="tab">
                        Cardiovascular System
                    </a>
                </li>
                <li role="presentation">
                    <a href="#gasform" role="tab" data-toggle="tab">
                        Gastrointestinal System
                    </a>
                </li>
                <li role="presentation">
                    <a href="#centralform" role="tab" data-toggle="tab">
                        Central Nervous System
                    </a>
                </li>
                <li role="presentation">
                    <a href="#fluidform" role="tab" data-toggle="tab">
                        Renal, Fluid Balance & Bloods
                    </a>
                </li>
                <li role="presentation">
                    <a href="#sepsisform" role="tab" data-toggle="tab">
                        Sepsis & Drugs
                    </a>
                </li>
                <li role="presentation">
                    <a href="#invasform" role="tab" data-toggle="tab">
                        Invasive Lines
                    </a>
                </li>
                <li role="presentation">
                    <a href="#skinform" role="tab" data-toggle="tab">
                        Skin
                    </a>
                </li>
                <li role="presentation">
                    <a href="#ropform" role="tab" data-toggle="tab">
                        ROP & Plan
                    </a>
                </li>
                <li role="presentation">
                    <a href="#notesform" role="tab" data-toggle="tab">
                        Notes
                    </a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content tab-view-shadow">
                <!-- General Form -->
                <div role="tabpanel" class="tab-pane active" id="generalform">
                    <div class="col-md-6 col-sm-6">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content row mx-0">
                                <div class="form-group">
                                    {!! Form::label('BabyName','Baby Name:') !!}
                                    {!! Form::text('BabyName',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('BMrNo', Lang::get('home.mrn') .':') !!}
                                    {!! Form::text('BMrNo',@$baby->baby_mrno,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('DOB','DOB: (DD-MM-YYYY)') !!}
                                    {!! Form::text('DOB',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('DayOfLife','Day Of Life:') !!}
                                    {!! Form::text('DayOfLife',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('CorrectedGestation','Corrected Gestational Age:') !!}
                                    <table>
                                        <tr>
                                            <td>{!! Form::label('cg_weeks','Weeks:') !!}</td>
                                            <td></td>
                                            <td>{!! Form::label('cg_days','Days:') !!}</td>
                                        </tr>
                                        <tr>
                                            <td>{!! Form::text('cg_weeks',null,['class'=>'form-control input-width-medium']) !!}</td>
                                            <td>+</td>
                                            <td>{!! Form::text('cg_days',null,['class'=>'form-control  input-width-medium']) !!}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Care','Care:') !!}
                                    {!! Form::select('Care',[''=>'N/A','Intensive Care'=>'Intensive Care','Special Care'=>'Special Care','Ward Admission'=>'Ward Admission','High Dependancy Care'=>'High Dependancy Care'],null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('Care')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Sex','Sex:') !!}
                                    {!! Form::select('Sex',[''=>'N/A','Male'=>'Male','Female'=>'Female','Indeterminate'=>'Indeterminate'],null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('SeenBy','Seen By:') !!}
                                    {!! Form::select('seenby',[''=>'N/A']+$DoctorMaster,null,['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content row mx-0">
                                <div class="form-group">
                                    {!! Form::label('DayDate','Date of Record: (DD-MM-YYYY)') !!}
                                    {!! Form::text('DayDate',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('DayTime','Time of Record:(HH:MM:AM or PM)') !!}
                                    @if(isset($baby->DayTime) && isset($baby->DayTime_MINS) && isset($baby->DayTime_AM))
                                    @php $time    = strlen($baby->DayTime) == 1 ? '0'.$baby->DayTime : $baby->DayTime;  @endphp
                                    @php $mins    = strlen($baby->DayTime_MINS) == 1 ? '0'.$baby->DayTime_MINS : $baby->DayTime_MINS;  @endphp
                                    @php $session = $baby->DayTime_AM;  @endphp
                                    @php $time = $time.':'.$mins.':'.$session @endphp
                                    {!! Form::text('Day_Time',$time,['class'=>'form-control']) !!}
                                    @else
                                    {!! Form::text('Day_Time',null,['class'=>'form-control']) !!}
                                    @endif
                                </div>
                                <div class="form-group">
                                    {!! Form::label('CurrentProblems','Current Problems:') !!}
                                    <table>
                                        <tr>
                                            <td colspan="2">
                                                {!! Form::textarea('CurrentProblems',null,['class'=>'form-control','rows'=>5]) !!} 
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('PreviousProblems','Previous Problems:') !!}
                                    <table>
                                        <td colspan="2">
                                            {!! Form::textarea('PreviousProblems',null,['class'=>'form-control','rows'=>5]) !!}
                                        </td>
                                    </table>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Background','Background:') !!}
                                    {!! Form::text('Background',null,['class'=>'form-control','rows'=>5]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Respiratory Form -->
                <div role="tabpanel" class="tab-pane" id="resform">
                    <div class="col-md-12 col-sm-12">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content row mx-0">
                                <div class="form-group">
                                    {!! Form::label('ResICD','Respiratory ICD:') !!}
                                    {!! Form::select('ResICD[]',$ICD,@$NicuICD->ResICD,['class'=>'select2-select-00 full-width-fix','multiple']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('respiratory_problem','Are there any positive examination findings ?') !!}
                                    {!! Form::select('respiratory_problem',[''=>'N/A','0'=>'No','1'=>'Yes'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]) !!}  
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content row mx-0">
                                <div class="form-group">
                                    {!! Form::label('InvasiveVentilation','Invasive Ventilation:') !!}
                                    {!! Form::select('InvasiveVentilation',[''=>'N/A','Yes'=>'Yes','No'=>'No'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('InvasiveVentilation')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Ventilation_choose','Ventilation Choose:') !!}
                                    {!! Form::select('Ventilation_choose',[''=>'N/A','NonInvasiveVentilation'=>'NonInvasive Ventilation','OtherRespiratorySupport'=>'OtherRespiratory Support','Spontaneouslyventilating'=>'Spontaneously Ventilating in air'],null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('ModeOfVentilation','Invasive Ventilation Type:') !!}
                                    {!! Form::select('ModeOfVentilation',[''=>'N/A','CMV'=>'CMV','IMV'=>'IMV','SIMV'=>'SIMV','PSV'=>'PSV','A/C or PTV'=>'A/C or PTV','HFO'=>'HFO'],null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('NonInvasiveVentilation','Non-Invasive Ventilation:') !!}
                                    {!! Form::select('NonInvasiveVentilation',[''=>'N/A','CPAP'=>'CPAP','NIMV/NIPPV'=>'NIMV/NIPPV','HHHFNC'=>'HHHFNC'],null,['class'=>' form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('OtherRespiratorySupport','Other Respiratory Support:') !!}
                                    {!! Form::select('OtherRespiratorySupport',[''=>'N/A','NPO2'=>'NPO2','HBO2'=>'HBO2','Face mask oxygen'=>'Face mask oxygen'],null,['class'=>' form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Spontaneouslyventilating','Spontaneously Ventilating:') !!}
                                    {!! Form::select('Spontaneouslyventilating',[''=>'N/A','Yes'=>'Yes','No'=>'No'],null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('sp_ven')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('PIP','PIP:') !!}
                                    {!! Form::text('PIP',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('PEEP','PEEP') !!}
                                    {!! Form::text('PEEP',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('MAP','MAP:') !!}
                                    {!! Form::text('MAP',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('FiO2','FiO2:') !!}
                                    {!! Form::text('FiO2',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Rate','Ventilator Rate:') !!}
                                    {!! Form::text('Rate',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('frequency_rep','Frequency (Hz):') !!}
                                    {!! Form::text('frequency_rep',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('IT','IT in sec:') !!}
                                    {!! Form::text('IT',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Flow','Flow (L/min):') !!}
                                    {!! Form::text('Flow',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Indication','Respiratory Indication:') !!}
                                    {!! Form::select('Indication',ValuelistHelpers::Indications(),@$indication,['class'=>'select2-select-00 full-width','multiple','id'=>'Indication']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Surfactant_therapy_nicu','Surfactant therapy in the NICU:') !!}
                                    <input id="Surfactant_therapy_nicu" name="Surfactant_therapy_nicu" data-on="Yes" data-off="No" checked data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                                </div>
                                <div class="form-group">
                                    {!! Form::label('surfactant_indication','Indication For Surfactant:') !!}
                                    {!! Form::select('surfactant_indication[]',ValuelistHelpers::surfactant_indications(),@$surfactant_indication,['class'=>'select2-select-00 full-width','multiple','id'=>'surfactant_indication']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('RR','Baby\'s Respiratory Rate:') !!}
                                    {!! Form::text('RR',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Retractions','Retractions:') !!}
                                    {!! Form::select('Retractions',[''=>'N/A','No'=>'No','Mild'=>'Mild','Moderate'=>'Moderate','Severe'=>'Severe'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('Retractions')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('AirEntry','Air entry:') !!}
                                    {!! Form::select('AirEntry',[''=>'N/A','Equal'=>'Equal','Reduced Bilateral'=>'Reduced Bilateral','Reduced Rt'=>'Reduced Rt','Reduced Lt'=>'Reduced Lt'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('AirEntry')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('ChestMovement','Chest Movement:') !!}
                                    {!! Form::select('ChestMovement',[''=>'N/A','Symmetrical'=>'Symmetrical','Asymmetrical'=>'Asymmetrical'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('ChestMovement')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('AddedSounds','Added Sounds:') !!}
                                    {!! Form::select('AddedSounds',[''=>'N/A','Present'=>'Present','Absent'=>'Absent'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('AddedSounds')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('DayCharacter','Character:') !!}
                                    {!! Form::text('DayCharacter',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('CXRFindings','CXR Findings:') !!}
                                    {!! Form::text('CXRFindings',null,['class'=>'form-control','rows'=>4]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content row mx-0">
                                <div class="form-group">
                                    {!! Form::label('TypeOfBloodGas','Type Of Blood Gas:') !!}
                                    {!! Form::select('TypeOfBloodGas',[''=>'N/A','Not done'=>'Not done','Arterial'=>'Arterial','Venous'=>'Venous','Capillary'=>'Capillary','Not indicated'=>'Not indicated'],null,['class'=>'form-control']) !!}
                                </div>
                                @php $times = ValuelistHelpers::timeEngine(); @endphp
                                <div class="form-group LastBG">
                                    {!! Form::label('LastBG','Last BG at: (HH:MM:AM or PM)') !!}
                                    {!! Form::text('LastBG',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Ph','pH:') !!}
                                    {!! Form::text('Ph',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('PaO2','PaO2:') !!}
                                    {!! Form::text('PaO2',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('PaCo2','PaCo2:') !!}
                                    {!! Form::text('PaCo2',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('HCO3','HCO3:') !!}
                                    {!! Form::text('HCO3',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('BE','BE:') !!}
                                    {!! Form::text('BE',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Lactate','Lactate:') !!}
                                    {!! Form::text('Lactate',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('EtTube','ET Tube:') !!}
                                    {!! Form::select('EtTube',[''=>'N/A','Yes'=>'Yes','No'=>'No'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Size','Size in cm:') !!}
                                    {!! Form::select('Size',[''=>'N/A','None'=>'None','2.0'=>'2.0','2.5'=>'2.5','3.0'=>'3.0','3.5'=>'3.5','4.0'=>'4.0'],null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Lips','Cm at Lips:') !!}
                                    {!! Form::text('Lips',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('SaO2PostDuctal','SaO2 PostDuctal:') !!}
                                    {!! Form::text('SaO2PostDuctal',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('AaDO2','AaDO2:') !!}
                                    {!! Form::text('AaDO2',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('OI','OI:') !!}
                                    {!! Form::text('OI',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('RSFindings','Other RS Findings:') !!}
                                    {!! Form::text('RSFindings',null,['class'=>'form-control','rows'=>4]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('needlethoracentesis','Needle Thoracocentesis:') !!}
                                    <div>
                                        <input id="needlethoracentesis" name="needlethoracentesis" data-on="Yes" data-off="No" checked data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('intercostaldrain','Intercostal Drain:') !!}
                                    <div>
                                        <input id="intercostaldrain" name="intercostaldrain" data-on="Yes" data-off="No" checked data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('chronic_lung','Chronic Lung Disease:') !!}
                                    <div>
                                        <input id="chronic_lung" checked name="chronic_lung" data-on="Yes" data-off="No" checked data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Cardiovascular Form -->
                <div role="tabpanel" class="tab-pane" id="cardioform">
                    <div class="col-md-12 col-sm-12">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content row mx-0">
                                <div class="form-group">
                                    {!! Form::label('CarICD','Cardiovascular ICD:') !!}
                                    {!! Form::select('CarICD[]',$ICD,@$NicuICD->CarICD,['class'=>'select2-select-00 full-width-fix','multiple']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Cardiovascular_problem','Are there any positive examination findings ?') !!}
                                    {!! Form::select('Cardiovascular_problem',[''=>'N/A','0'=>'No','1'=>'Yes'],null,["class"=>"form-control"]) !!}  
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content row mx-0">
                                <div class="form-group">
                                    {!! Form::label('HR','HR:') !!}
                                    {!! Form::text('HR',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('systolic_bp','Systolic BP:') !!}
                                    {!! Form::text('systolic_bp',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('diastolic_bp','Diastolic BP:') !!}
                                    {!! Form::text('diastolic_bp',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('MeanBP','Mean BP') !!}
                                    {!! Form::text('MeanBP',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('PulsePressure','Pulse Pressure:') !!}
                                    {!! Form::select('PulsePressure',[''=>'N/A','Normal'=>'Normal','Wide'=>'Wide'],null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('PulsePressure')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('CentralPulses','Central Pulses') !!}
                                    {!! Form::select('CentralPulses',[''=>'N/A','Normal'=>'Normal','Bounding'=>'Bounding','Feeble/Weak'=>'Feeble/Weak','Absent'=>'Absent'],null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('PeripheralPulses')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('PeripheralPulses','Peripheral Pulses:') !!}
                                    {!! Form::select('PeripheralPulses',[''=>'N/A','Normal'=>'Normal','Bounding'=>'Bounding','Feeble/Weak'=>'Feeble/Weak','Absent'=>'Absent'],null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('PeripheralPulses')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('FemoralPulses','Femoral Pulses:') !!}
                                    {!! Form::select('FemoralPulses',[''=>'N/A','Normal'=>'Normal','Bounding'=>'Bounding','Feeble/Weak'=>'Feeble/Weak','Absent'=>'Absent'],null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('PeripheralPulses')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('PrecordialActivity','Precordial Activity:') !!}
                                    {!! Form::select('PrecordialActivity',[''=>'N/A','Present'=>'Present','Absent'=>'Absent'],null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('default')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('S1S2','S1S2:') !!}
                                    {!! Form::select('S1S2',[''=>'N/A','Normal'=>'Normal','Abnormal'=>'Abnormal'],null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Murmur','Murmur:') !!}
                                    {!! Form::select('Murmur',[''=>'N/A','Present'=>'Present','Absent'=>'Absent'],null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('default')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('CharacterOfMurmur','Character Of Murmur:') !!}
                                    {!! Form::text('CharacterOfMurmur',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('CVSFindings','Other CVS Findings:') !!}
                                    {!! Form::text('CVSFindings',null,['class'=>'form-control','rows'=>4]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content row mx-0">
                                <div class="form-group">
                                    {!! Form::label('CFT','CFT:') !!}
                                    {!! Form::select('CFT',[''=>'N/A','< 3 Seconds' => "< 3 Seconds",'3-5 Seconds' => "3-5 Seconds",'>5 Seconds' => ">5 Seconds","Prolonged"=>"Prolonged"],null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('sp_ven')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('CentralTemperature','Central Temperature:') !!}
                                    {!! Form::text('CentralTemperature',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('PeripheralTemperature','Peripheral Temperature:') !!}
                                    {!! Form::text('PeripheralTemperature',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Color','Color:') !!}
                                    {!! Form::select('Color',[''=>'N/A','Pale'=>'Pale','Pink' => "Pink","Acral Cyanosis"=>"Acral Cyanosis","Central Cyanosis"=>"Central Cyanosis"],null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('Color')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Inotropes','Inotropes:') !!}
                                    {!! Form::select('Inotropes',[''=>'N/A','No' =>"No","Yes"=>"Yes"],null,['class'=>' form-control','data-color'=>ValuelistHelpers::setColorvalue('default')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Dopamine','Dopamine (mcg/kg/min):') !!}
                                    {!! Form::text('Dopamine',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Dobutamine','Dobutamine (mcg/kg/min):') !!}
                                    {!! Form::text('Dobutamine',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Adrenaline','Adrenaline (ng/kg/min):') !!}
                                    {!! Form::text('Adrenaline',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Noradrenaline','Nor adrenaline (ng/kg/min):') !!}
                                    {!! Form::text('Noradrenaline',null,['class'=>'form-control','id'=>'Noradrenaline']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Milrinone','Milrinone (mcg/kg/hour):') !!}
                                    {!! Form::text('Milrinone',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group"> 
                                    {!! Form::label('echo_status','ECHO:') !!}
                                    {!! Form::select('echo_status',[''=>'N/A','No'=>'No','Yes'=>'Yes'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('DayEcho','ECHO Report:') !!}
                                    {!! Form::text('DayEcho',null,['class'=>'form-control','rows'=>4]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('PDA','PDA:') !!}
                                    {!! Form::select('PDA',[''=>'N/A','Yes' =>"Yes","No"=>"No"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('PDATreatment','PDA Treatment:') !!}
                                    {!! Form::select('PDATreatment',[""=>"N/A","None" =>"None","Medical"=>"Medical","Surgical"=>"Surgical"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('PDATreatment')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('pphn','PAH:') !!}
                                    {!! Form::select('pphn',[""=>"N/A","Yes"=>"Yes","No"=>"No"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('pphn_treatement','PAH Treatment:') !!}
                                    {!! Form::select('pphn_treatement',ValuelistHelpers::getPphntreatement(),null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('PDATreatment')]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Gastrointestinal System -->
                <div role="tabpanel" class="tab-pane" id="gasform">
                    <div class="col-md-12 col-sm-12">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content row mx-0">
                                <div class="form-group">
                                    {!! Form::label('GasICD','Gastrointestinal ICD:') !!}
                                    {!! Form::Select('GasICD[]',$ICD,@$NicuICD->GasICD,['class'=>'select2-select-00 full-width-fix','multiple']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('gastrointestinal_problem','Are there any positive examination findings ?') !!}
                                    {!! Form::select('gastrointestinal_problem',[''=>'N/A','0'=>'No','1'=>'Yes'],null,['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content row mx-0">
                                <div class="form-group">
                                    {!! Form::label('directlybreastfeed','Directly breast feed ?:') !!}
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    {!! Form::checkbox('directlybreastfeed',null,null,['data-on'=>'Yes','data-off'=>'No','data-toggle'=>'toggle','data-width'=>'100','data-size'=>'small','class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('othertypefeed','Other Type Of Feeds ? ') !!}
                                    &nbsp;
                                    <i class="fa fa-info-circle bs-tooltip" data-placement="top" data-original-title="including top up feeds"></i>
                                    &nbsp;
                                    {!! Form::checkbox('othertypefeed',null,null,['data-on'=>'Yes','data-off'=>'No','data-toggle'=>'toggle','data-width'=>'100','data-size'=>'small','class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Volume','Volume:') !!}
                                    {!! Form::text('Volume',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Frequency','Frequency:') !!}
                                    {!! Form::select('Frequency',ValuelistHelpers::frequencyList(),null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('workingWeight','Working Weight:') !!}
                                    {!! Form::text('workingWeight',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Feeds','Feeds ml/kg/d:') !!}
                                    {!! Form::text('Feeds',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('TypeofFeeds','Type of Feeds:') !!}
                                    {!! Form::select('TypeofFeeds',[""=>"N/A","Not applicable"=>"Not applicable","Maternal Expressed Breast Milk (MEBM)" =>"Maternal Expressed Breast Milk (MEBM)","Donor Expressed Breast Milk (DEBM)"=>"Donor Expressed Breast Milk (DEBM)", "Formula Milk" => "Formula Milk", "Fortified MEBM" =>"Fortified MEBM", "Fortified DEBM" => "Fortified DEBM"],null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('FullEnteralFeeds','Full Enteral Feeds:') !!}
                                    {!! Form::select('FullEnteralFeeds',[''=>'N/A','Reached' => "Reached","Not Reached"=>"Not Reached"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('FullEnteralFeeds')]) !!}
                                </div>
                                <table class="form-group col-md-12">
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                {!! Form::label('iv_fluids','IV fluids +/- PN ml/hour:') !!}
                                                {!! Form::text('iv_fluids',null,['class'=>'form-control input-width-medium']) !!}
                                            </div>
                                        </td>
                                        <td> = </td>
                                        <td>
                                            <div class="form-group">
                                                {!! Form::label('iv_fluids_ml_day','ml/day:') !!}
                                                {!! Form::text('iv_fluids_ml_day',null,['class'=>'form-control input-width-medium']) !!}
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                {!! Form::label('drug_infusions','Drug Infusions ml/hour:') !!}
                                                {!! Form::text('drug_infusions',null,['class'=>'form-control input-width-medium']) !!}
                                            </div>
                                        </td>
                                        <td> = </td>
                                        <td>
                                            <div class="form-group">
                                                {!! Form::label('drug_infusions_ml_day','ml/day:') !!}
                                                {!! Form::text('drug_infusions_ml_day',null,['class'=>'form-control input-width-medium']) !!}
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <div class="form-group">
                                    {!! Form::label('other_drugs','Other Drugs ml/day:') !!}
                                    {!! Form::text('other_drugs',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Ivf','IV fluids +/- PN ml/kg/d:') !!}
                                    {!! Form::text('Ivf',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Tpn','TPN:') !!}
                                    {!! Form::select('Tpn',[''=>'N/A','No'=>"No","Yes"=>"Yes"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Carbohydrates','Carbohydrates (g/kg/day)') !!}
                                    {!! Form::text('Carbohydrates',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Protein','Amino Acid  (g/kg/day)') !!}
                                    {!! Form::text('Protein',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Fat','Fat(g/kg/day)') !!}
                                    {!! Form::text('Fat',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('total_energy','Total Energy (kcal/kg/day):') !!}
                                    {!! Form::text('total_energy',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('AspirateVolume','Aspirate Volume:') !!}
                                    {!! Form::text('AspirateVolume',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('AspirateNature','AspirateNature:') !!}
                                    {!! Form::select('AspirateNature',[''=>'N/A','Nil' =>"Nil","Milky"=>"Milky","Yellow"=>"Yellow","Light green"=>"Light green","Dark green"=>"Dark green","Bloody"=>"Bloody","Altered brown"=>"Altered brown","Clear"=>"Clear"],null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Stools','Stools:') !!}
                                    {!! Form::checkbox('Stools',null,null,['data-on'=>'Bowels opened','data-off'=>'Bowels not opened','data-toggle'=>'toggle','data-width'=>'200','data-size'=>'small','class'=>'form-control']) !!}
                                    <!-- {!! Form::text('Stools',null,['class'=>'form-control']) !!} -->
                                </div>
                                <div class="form-group">
                                    {!! Form::label('StoolNature','Stool Nature:') !!}
                                    {!! Form::select('StoolNature',ValuelistHelpers::stoolNature(),null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Abdomen','Abdomen:') !!}
                                    {!! Form::select('Abdomen',[''=>'N/A','Normal'=>'Normal','Scaphoid'=>'Scaphoid','Distended'=>'Distended'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('Abdomen')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('BowelSounds','Bowel Sounds:') !!}
                                    {!! Form::select('BowelSounds',[''=>'N/A','Normal'=>"Normal","Increased"=>"Increased","Decreased"=>"Decreased","Absent"=>"Absent"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('BowelSounds')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('AbdominalGirth','Abdominal Girth:') !!}
                                    {!! Form::text('AbdominalGirth',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('PAFindings','Other PA Findings:') !!}
                                    {!! Form::text('PAFindings',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('NEC','NEC:') !!}
                                    {!! Form::select('NEC',[''=>'N/A','Yes'=>"Yes","No"=>"No"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default')]) !!}
                                </div>
                                <div class="form-group" id="NECtreatmentDiv">
                                    {!! Form::label('NECtreatment','NEC treatment:') !!}
                                    {!! Form::select('NECtreatment',[''=>'N/A','Medical' =>"Medical","Surgical"=>"Surgical"],null,['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content row mx-0">
                                <div class="form-group">
                                    {!! Form::label('Umbilicus','Umbilicus:') !!}
                                    {!! Form::select('Umbilicus',[''=>'N/A','Healthy' => "Healthy","Possible infection"=>"Possible infection","Omphalitis"=>"Omphalitis","Omphalocele"=>"Omphalocele","Gastroschisis"=>"Gastroschisis","Hernia"=>"Hernia"],null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Hepatomegaly','Hepatomegaly:') !!}
                                    {!! Form::select('Hepatomegaly',[''=>'N/A','No' =>"No","Yes"=>"Yes"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('LiverSpan','Liver Span:') !!}
                                    {!! Form::text('LiverSpan',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Splenomegaly','Splenomegaly:') !!}
                                    {!! Form::select('Splenomegaly',[''=>'N/A','No' =>"No","Yes"=>"Yes"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('SpleenSpan','Spleen Span:') !!}
                                    {!! Form::text('SpleenSpan',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Herina','Hernia:') !!}
                                    {!! Form::select('Herina',[''=>'N/A','No hernia' => "No hernia","Right Inguinal hernia"=>"Right Inguinal hernia","Left Inguinal hernia"=>"Left Inguinal hernia","Umbilical/para umbilical hernia"=>"Umbilical/para umbilical hernia","Obstructed/strangulated"=>"Obstructed/strangulated"],null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Genitalia','Genitalia:') !!}
                                    {!! Form::text('Genitalia',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('TSB','Maximum Bilirubin (in last 24 hours):') !!}
                                    {!! Form::text('TSB',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('NNJTreatment','NNJ Treatment:') !!}
                                    {!! Form::select('NNJTreatment',[''=>'N/A','None'=>'None','Phototherapy' => "Photo &#8478;","Exchange transfusion"=>"Exchange &#8478;"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorValue('NNJTreatment')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Immunoglobulins','Immunoglobulins:') !!}
                                    {!! Form::select('Immunoglobulins',[''=>'N/A','Yes' => "Yes","No"=>"No"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorValue('default')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('BabyBloodGroup','Baby Blood Group:') !!}
                                    {!! Form::select('BabyBloodGroup',[''=>'N/A']+ValuelistHelpers::Blood_groups(),null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('MotherBloodGroup','Mother Blood Group:') !!}
                                    {!! Form::select('MotherBloodGroup',[''=>'N/A']+ValuelistHelpers::Blood_groups(),null['MotherBloodGroup'],['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('AxrFindings','AXR Findings:') !!}
                                    {!! Form::text('AxrFindings',null,['class'=>'form-control','rows'=>4]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('ultrasoundabdominal','Ultrasound Abdominal:') !!}
                                    <input id="ultrasoundabdominal" name="ultrasoundabdominal" data-on="Yes" data-off="No"  data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                                </div>
                                <div>
                                    {!! Form::label('ultrasoundkeyfindings','Key Findings:') !!}
                                    {!! Form::textarea('ultrasoundkeyfindings',null,['class'=>'form-control','rows'=>4]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Central Form -->
                <div role="tabpanel" class="tab-pane" id="centralform">
                    <div class="col-md-12 col-sm-12">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content row mx-0">
                                <div class="form-group">
                                    {!! Form::label('CenICD','Central Nervous ICD:') !!}
                                    {!! Form::Select('CenICD[]',$ICD,@$NicuICD->CenICD,['class'=>'select2-select-00 full-width-fix','multiple']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('central_problem','Are there any positive examination findings ?') !!}
                                    {!! Form::select('central_problem',[''=>'N/A','0'=>'No','1'=>'Yes'],null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('sedation_paralysis','Is the baby under the influence of sedation/Paralysis ?') !!}
                                    {!! Form::select('sedation_paralysis',[''=>'N/A','0'=>'No','1'=>'Yes'],null,['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content row mx-0">
                                <div class="form-group">
                                    {!! Form::label('TherapeuticHypothermia','Therapeutic Hypothermia:') !!}
                                    {!! Form::select('TherapeuticHypothermia',[''=>'N/A',"No"=>"No",'Yes' => "Yes"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Pupils','Pupils:') !!}
                                    {!! Form::text('Pupils',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('AnteriorFontanelle','Anterior Fontanelle:') !!}
                                    {!! Form::select('AnteriorFontanelle',[''=>'N/A','Normal' =>"Normal","Depressed"=>"Depressed","Bulging"=>"Bulging"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('AnteriorFontanelle')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Activity','Activity:') !!}
                                    {!! Form::select('Activity',[''=>'N/A',"Normal" =>"Normal","Comatosed"=>"Comatosed","Decreased"=>"Decreased","Increased"=>"Increased","Irritable"=>"Irritable","Sedated/Paralysed"=>"Sedated/Paralysed"],null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Tone','Tone') !!}
                                    {!! Form::select('Tone',[''=>'N/A','Normal' =>"Normal","Hypotonia"=>"Hypotonia","Hypertonia"=>"Hypertonia","Sedated/Paralysed"=>"Sedated/Paralysed"],null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Cry','Cry:') !!}
                                    {!! Form::select('Cry',ValuelistHelpers::cryValues(),null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Seizures','Seizures:') !!}
                                    {!! Form::select('Seizures',[''=>'N/A','No' => "No","Yes"=>"Yes"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('TypeOfSeizures','Type Of Seizures:') !!}
                                    {!! Form::text('TypeOfSeizures',null,['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content row mx-0">
                                <div class="form-group">
                                    {!! Form::label('NeonatalReflexes','Neonatal Reflexes:') !!}
                                    {!! Form::select('NeonatalReflexes',[''=>'N/A','Normal' =>"Normal","Suppressed"=>"Suppressed","Absent"=>"Absent","Exaggerated"=>"Exaggerated","Sedated/Paralysed"=>"Sedated/Paralysed"],null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('CnsFindings','Other CNS Findings:') !!}
                                    {!! Form::text('CnsFindings',null,['class'=>'form-control','rows'=>4]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('neuro_sonogram','Neuro Sonogram:') !!}
                                    <input id="neuro_sonogram" name="neuro_sonogram"  data-on="performed" data-off="Not performed"  data-toggle="toggle" data-width="200" data-size="small" class="form-control" type="checkbox">
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Cuss','Neuro Sonogram Report:') !!}
                                    {!! Form::text('Cuss',null,['class'=>'form-control','rows'=>4]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('ultrasound_spine','Ultrasound Spine:') !!}
                                    <input id="ultrasound_spine" name="ultrasound_spine" data-on="performed" data-off="Not performed" data-toggle="toggle" data-width="200" data-size="small" class="form-control" type="checkbox">
                                </div>
                                <div class="form-group">
                                    {!! Form::label('ultrasound_spine_report','Ultrasound Spine Report:') !!}
                                    {!! Form::text('ultrasound_spine_report',null,['class'=>'form-control','rows'=>5]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('mrict_brain_status','MRI/CT Brain:') !!}
                                    <input id="mrict_brain_status" name="mrict_brain_status" data-on="Yes" data-off="No" data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                                </div>
                                <div class="form-group">
                                    {!! Form::label('mri_ct_brain','Key Findings:') !!}
                                    {!! Form::text('mri_ct_brain',null,['class'=>'form-control','rows'=>4]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('eeg_cfm','EEG/CFM:') !!}
                                    <input id="eeg_cfm" name="eeg_cfm" data-on="Performed" data-off="Not Performed" data-toggle="toggle" data-width="200" data-size="small" class="form-control" type="checkbox">
                                </div>
                                <div class="form-group">
                                    {!! Form::label('eeg_cfm_report','EEG/CFM Report:') !!}
                                    {!! Form::text('eeg_cfm_report',null,['class'=>'form-control','rows'=>'5']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fluid Balance Form -->
                <div role="tabpanel" class="tab-pane" id="fluidform">
                    <div class="col-md-12 col-sm-12">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content row mx-0">
                                <div class="form-group">
                                    {!! Form::label('FluidICD','Fluid Balance ICD:') !!}
                                    {!! Form::Select('FluidICD[]',$ICD,@$NicuICD->FluidICD,['class'=>'select2-select-00 full-width-fix','multiple']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content row mx-0">
                                <div class="form-group">
                                    {!! Form::label('TotalFluid','Total Fluid ml/kg/d:') !!}
                                    {!! Form::text('TotalFluid',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('PreviousWt','Previous Weight: (grams)') !!}
                                    {!! Form::text('PreviousWt',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('CurrentWt','Current Weight: (grams)') !!}
                                    {!! Form::text('CurrentWt',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('WtChange','Weight Change: (grams)') !!}
                                    {!! Form::text('WtChange',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('PercentageChange','Percentage Change:') !!}
                                    {!! Form::text('PercentageChange',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('UrineOutput','Urine Output:') !!}
                                    {!! Form::select('UrineOutput',[''=>'N/A','Passed' => "Passed","Not Passed"=>"Not Passed","Unmeasurable"=>"Unmeasurable"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('UrineOutput')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('urine_output_day','UO ml (in 24 hours):') !!} 
                                    {!! Form::text('urine_output_day',null,['class'=>'form-control']) !!}                                
                                </div>
                                <div class="form-group">
                                    {!! Form::label('UO','UO ml/kg/h:') !!}
                                    {!! Form::text('UO',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('BloodOut','Blood Out:') !!}
                                    {!! Form::text('BloodOut',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('DrainOutput','Drain Output:') !!}
                                    {!! Form::text('DrainOutput',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('renalultrasound','Renal Ultrasound:') !!}
                                    <div>
                                        <input id="renalultrasound" name="renalultrasound" data-on="Yes" data-off="No"  data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('renalultrasoundkeyfindings','Key Findings:') !!}
                                    {!! Form::textarea('renalultrasoundkeyfindings',null,['class'=>'form-control','row'=>4]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content row mx-0">
                                <div class="form-group">
                                    {!! Form::label('RBS','RBS:') !!}
                                    {!! Form::text('RBS',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('ElectrolyteAbnormalities','Glucose & Electrolyte Abnormalities:') !!}
                                </div>
                                <div class="form-group">
                                    <table class="table">
                                        <tr>
                                            <td class="plr-must-0 format-content"><label class="control-label glucose_label">Hypoglycemia: </label></td>
                                            <td class="format-content"><input id="Hypoglycemia" name="Hypoglycemia" data-on="Yes" data-off="No" data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox"></td>
                                            <td class="format-content">{!! Form::label('gir','GIR') !!}</td>
                                            <td class="format-content">{!! Form::text('gir',null,['class'=>'form-control']) !!}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="form-group">
                                    <label class="control-label glucose_label">Hyperglycemia: </label>
                                    <input id="Hyperglycemia" name="Hyperglycemia" data-on="Yes" data-off="No"  data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                                </div>
                                <div class="form-group">
                                    <label class="control-label glucose_label">Insulin Therapy: </label>
                                    <input id="InsulinTherapy" name="InsulinTherapy" data-on="Yes" data-off="No"  data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                                </div>
                                <div class="form-group">
                                    <label class="control-label glucose_label">Hyponatremia: </label>
                                    <input id="Hyponatremia" name="Hyponatremia" data-on="Yes" data-off="No"  data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                                </div>
                                <div class="form-group">
                                    <label class="control-label glucose_label">Hypernatremia: </label>
                                    <input id="Hypernatremia" name="Hypernatremia" data-on="Yes" data-off="No"  data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                                </div>
                                <div class="form-group">
                                    <label class="control-label glucose_label">Hypokalemia: </label>
                                    <input id="Hypokalemia" name="Hypokalemia" data-on="Yes" data-off="No"  data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                                </div>
                                <div class="form-group">
                                    <label class="control-label glucose_label">Hyperkalemia: </label>
                                    <input id="Hyperkalemia" name="Hyperkalemia" data-on="Yes" data-off="No"  data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                                </div>
                                <div class="form-group">
                                    <label class="control-label glucose_label">Hypocalcemia: </label>
                                    <input id="Hypocalcemia" name="Hyperkalemia" data-on="Yes" data-off="No"  data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                                </div>
                                <div class="form-group">
                                    <label class="control-label glucose_label">Hypercalcemia: </label>
                                    <input id="Hypercalcemia" name="Hypercalcemia" data-on="Yes" data-off="No"  data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                                </div>
                                <div class="form-group">
                                    <label class="control-label glucose_label"> Dilution Exchange: </label>
                                    <input id="dilution_exchange" name="dilution_exchange" data-on="Yes" data-off="No" data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Transfusion','Transfusion:') !!}
                                    {!! Form::select('Transfusion',[''=>'N/A','No' =>"No","Yes"=>"Yes"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('Transfusion')]) !!}
                                </div>
                                <div class="form-group">
                                    <table class="form-group product col-md-12">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Volume ml/kg</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($products) && count($products) > 0)
                                            @foreach ($products as $data)
                                            <tr>
                                                <td>
                                                    {!! Form::select('F_Product[]',[''=>'N/A','Packed RBC'=>'Packed RBC','Whole Blood'=>'Whole Blood','Platelet Concentrate'=>'Platelet Concentrate','Fresh Frozen Plasma'=>'Fresh Frozen Plasma','Cryoprecipitate'=>'Cryoprecipitate','Washed maternal platelets'=>'Washed maternal platelets','NAIT - special platelets'=>'NAIT - special platelets','Immunoglobulin'=>'Immunoglobulin'],$data->Product,['class'=>'form-control']) !!}
                                                </td>
                                                <td><input type="text" class="input-width-mini form-control" name="F_Volume[]" value="{!! $data->Volume; !!}"/>
                                                </td>
                                                <td><span class="fa fa-remove btn btn-default remove hide"></span></td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td> {!! Form::select('F_Product[]',[''=>'N/A','Packed RBC'=>'Packed RBC','Whole Blood'=>'Whole Blood','Platelet Concentrate'=>'Platelet Concentrate','Fresh Frozen Plasma'=>'Fresh Frozen Plasma','Cryoprecipitate'=>'Cryoprecipitate','Washed maternal platelets'=>'Washed maternal platelets','NAIT - special platelets'=>'NAIT - special platelets','Immunoglobulin'=>'Immunoglobulin'],null,['class'=>'form-control']) !!}</td>
                                                <td><input type="text" class="input-width-mini form-control" name="F_Volume[]" value=""/></td>
                                                <td><span class="fa fa-remove btn btn-default remove hide"></span></td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    <a class="btn product_add btn_add hide" href="javascript:void(0);"><i class="fa fa-plus"></i> <span>Add More</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Sepsis Form -->
                <div role="tabpanel" class="tab-pane" id="sepsisform">
                    <div class="col-md-12 col-sm-12">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content row mx-0">
                                <div class="form-group">
                                    {!! Form::label('SepsisICD','Sepsis ICD:') !!}
                                    {!! Form::Select('SepsisICD[]',$ICD,@$NicuICD->SepsisICD,['class'=>'select2-select-00 full-width-fix','multiple']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content row mx-0">
                                <div class="form-group">
                                    {!! Form::label('Sepsis','SEPSIS:') !!}
                                    {!! Form::select('Sepsis',[''=>'N/A','No sepsis' => "No sepsis","Suspect"=>"Suspect","Probable"=>"Probable","Proven"=>"Proven","Severe"=>"Severe"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('SEPSIS')]) !!}
                                </div>
                                <div class="hidden">
                                    {!! Form::select('a_antibiotic_temp',[''=>'N/A']+ValuelistHelpers::getAntibiotic(),null,['class'=>"input-width-medium  form-control"]) !!}
                                </div>
                                <div class="form-group">
                                    <table class="antibiotic form-group col-md-12">
                                        <thead>
                                            <tr>
                                                <th>Antibiotic</th>
                                                <th>Day</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($antibiotic) && count($antibiotic) > 0)
                                            @foreach ($antibiotic as $data)
                                            <tr>
                                                <td class="full-width">{!! Form::select('A_Antibiotic[]',[''=>'N/A']+ValuelistHelpers::getAntibiotic(),@$data->Antibiotic, ['class'=>"form-control sepsis-antibiotic"]) !!}</td>
                                                <td><input type="text" class="input-width-mini form-control" name="A_Day[]" value="{!! $data->Day; !!}"/></td>
                                                <td><span class="fa fa-remove btn btn-default remove hide"></span></td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td class="full-width">{!! Form::select('A_Antibiotic[]',[''=>'N/A']+ValuelistHelpers::getAntibiotic(), @$baby->antibiotic,['class'=>"form-control sepsis-antibiotic"]) !!}</td>
                                                <td><input type="text" class="input-width-mini form-control" name="A_Day[]"  value=""/></td>
                                                <td><span class="fa fa-remove btn btn-default remove hide"></span></td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    <a class="btn antibiotic_add btn_add hide" href="javascript:void(0);"><i class="fa fa-plus"></i><span>Add More</span></a>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('CRP','CRP mg per L:') !!}
                                    {!! Form::text('CRP',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('TLC','TLC per cu.mm:') !!}
                                    {!! Form::text('TLC',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Percentage','Percentage N:') !!}
                                    {!! Form::text('Percentage',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('ANC','ANC per cu.mm:') !!}
                                    {!! Form::text('ANC',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Platelets','Platelets per cu.mm:') !!}
                                    {!! Form::text('Platelets',null,['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content row mx-0">
                                <div class="form-group">
                                    <table class="form-group sep_drugs col-md-12">
                                        <thead>
                                            <tr>
                                                <th>Other Drugs</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @if(isset($drugs) && count($drugs) > 0)
                                            @foreach ($drugs as $data)
                                            <tr>
                                                <td class="full-width">{!! Form::select('drugs[]',[''=>'N/A']+ValuelistHelpers::getDrugIvFluidsNonAntibiotic(),@$data, ['class'=>"form-control"]) !!}</td>
                                                <td><span class="fa fa-remove btn btn-default remove hide"></span></td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td class="full-width">{!! Form::select('drugs[]',[''=>'N/A']+ValuelistHelpers::getDrugIvFluidsNonAntibiotic(), null,['class'=>"form-control"]) !!}</td>
                                                <td><span class="fa fa-remove btn btn-default remove hide"></span></td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    <a class="btn sep_drugs_add btn_add hide" href="javascript:void(0);"><i class="fa fa-plus"></i><span>Add More</span></a>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('BloodCulture','Blood Culture:') !!}
                                    {!! Form::select('BloodCulture',[''=>'N/A','Not sent' => "Not sent","Awaited"=>"Awaited","Negative"=>"Negative","Positive"=>"Positive"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('BloodCulture')])
                                    !!}
                                </div>
                                <div class="form-group">
                                    <table class="form-group organizam col-md-12">
                                        <thead>
                                            <tr>
                                                <th>{!! Form::label('Organism','Organism:') !!}</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($organism) && is_array($organism) && count($organism) > 0)
                                            @foreach($organism as $data)
                                            <tr>
                                                <td class="full-width">{!! Form::select('Organism[]',ValuelistHelpers::organizam(),$data,['class'=>'form-control']) !!}</td>
                                                <td><span class="fa fa-remove btn btn-default remove hide"></span></td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td class="full-width">{!! Form::select('Organism[]',ValuelistHelpers::organizam(),null,['class'=>'form-control']) !!}</td>
                                                <td><span class="fa fa-remove btn btn-default remove hide"></span></td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    <a class="btn organizam_add btn_add hide" href="javascript:void(0);"><i class="fa fa-plus"></i><span>Add More</span></a>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('PositiveBlood','Positive Blood Culture DOL:') !!}
                                    {!! Form::text('PositiveBlood',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('lumbar_puncture','Lumbar puncture:') !!}
                                    {!! Form::select('lumbar_puncture',[''=>'N/A', 'Performed'=>'Performed','Not Performed' => "Not Performed","Not Indicated"=>"Not Indicated"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('BloodCulture')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Meningitis','Meningitis:') !!}
                                    {!! Form::select('Meningitis',ValuelistHelpers::meningitisValue(),null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('Meningitis')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('viral_meningitis','Viral Meningitis/Encephalitis:') !!}
                                    <input id="viral_meningitis" name="viral_meningitis"  data-on="Yes" data-off="No"  data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Invasive Form -->
                <div role="tabpanel" class="tab-pane" id="invasform">
                    <div class="col-md-6 col-sm-6">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content row mx-0">
                                <div class="form-group">
                                    {!! Form::label('PeripheralCannula','Peripheral Cannula:') !!}
                                    {!! Form::select('PeripheralCannula',[''=>'N/A','No' => "No","Yes"=>"Yes"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('pvc_number','PVC Number:') !!}
                                    {!! Form::text('pvc_number',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('PvcComplication','Pvc Complication:') !!}
                                    {!! Form::text('PvcComplication',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Picc','Picc:') !!}
                                    {!! Form::select('Picc',[''=>'N/A','No' =>"No","Yes"=>"Yes"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('PiccSite','PiccSite:') !!}
                                    {!! Form::select('PiccSite',[''=>'N/A',"Rt Cubital" => "Rt Cubital","Lt Cubital"=>"Lt Cubital","Rt Subclavian"=>"Rt Subclavian","Lt Subclavian"=>"Lt Subclavian","Rt Saphenous"=>"Rt Saphenous","Lt Saphenous"=>"Lt Saphenous","Rt Femoral"=>"Rt Femoral","Lt Femoral"=>"Lt Femoral","Rt External Jugular"=>"Rt External Jugular","Lt External Jugular"=>"Lt External Jugular"],null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('PiccDay','PiccDay:') !!}
                                    {!! Form::text('PiccDay',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('PiccComplication','PiccComplication:') !!}
                                    {!! Form::text('PiccComplication',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Uvc','UVC:') !!}
                                    {!! Form::select('Uvc',[''=>'N/A','No' =>
                                    "No","Yes"=>"Yes"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('UvcPosition','UVC Position:') !!}
                                    {!! Form::select('UvcPosition',[''=>'N/A','High' =>"High","Low"=>"Low"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('UvcDay','UVC Day:') !!}
                                    {!! Form::text('UvcDay',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('UvcComplication','UVC Complication:') !!}
                                    {!! Form::text('UvcComplication',null,['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content row mx-0">
                                <div class="form-group">
                                    {!! Form::label('Uac','UAC:') !!}
                                    {!! Form::select('Uac',[''=>'N/A','No' =>
                                    "No","Yes"=>"Yes"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('UacPosition','UAC Position:') !!}
                                    {!! Form::select('UacPosition',[''=>'N/A','High' =>"High","Low"=>"Low"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('UacDay','UAC Day:') !!}
                                    {!! Form::text('UacDay',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('UacComplication','UAC Complication:') !!}
                                    {!! Form::text('UacComplication',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('Pac','PAC:') !!}
                                    {!! Form::select('Pac',[''=>'N/A','No' =>"No","Yes"=>"Yes"],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('default_normal')]) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('PacSite','PAC Site:') !!}
                                    {!! Form::select('PacSite',[''=>'N/A',"Rt Radial" => "Rt Radial","Lt Radial"=>"Lt Radial","Rt Ulnar"=>"Rt Ulnar","Lt Ulnar"=>"Lt Ulnar","Rt Posterior Tibial"=>"Rt Posterior Tibial","Lt Posterior Tibial"=>"Lt Posterior Tibial","Rt Dorsalis Pedis"=>"Rt Dorsalis Pedis","Lt Dorsalis Pedis"=>"Lt Dorsalis Pedis"],null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('PacDay','PAC Day:') !!}
                                    {!! Form::text('PacDay',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('PacComplication','PAC Complication:') !!}
                                    {!! Form::text('PacComplication',null,['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Notes Form -->
                <div role="tabpanel" class="tab-pane" id="skinform">
                    <div class="col-md-12 col-sm-12">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content row mx-0">
                                <div class="form-group">
                                    {!! Form::label('SkinICD','Skin ICD:') !!}
                                    {!! Form::Select('SkinICD[]',$ICD,@$NicuICD->SkinICD,['class'=>'select2-select-00 col-md-9 full-width-fix','multiple']) !!}
                                </div>
                                <div class="col-md-8 row">
                                    <div class="form-group">
                                        {!! Form::label('Skin','Skin:') !!}
                                        {!! Form::textarea('Skin',null,['class'=>'form-control','rows'=>5]) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Notes Form -->
                <div role="tabpanel" class="tab-pane" id="ropform">
                    <div class="col-md-12 col-sm-12">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content row mx-0">
                                <div class="form-group">
                                    {!! Form::label('RopICD','Rop ICD:') !!}
                                    {!! Form::Select('RopICD[]',$ICD,@$NicuICD->RopICD,['class'=>'select2-select-00 full-width-fix','multiple']) !!}
                                </div>
                                <div class="col-md-8 row">
                                    <div class="form-group">
                                        {!! Form::label('Rop','ROP:') !!}
                                        {!! Form::textarea('Rop',null,['class'=>'form-control','rows'=>3]) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('Plan','PLAN:') !!}
                                        {!! Form::textarea('Plan',null,['class'=>'form-control','rows'=>6]) !!}
                                    </div>
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
                <!-- Notes Form -->
                <div role="tabpanel" class="tab-pane" id="notesform">
                    <div class="col-md-12 col-sm-12">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content row mx-0">
                                <div class="col-md-8 ">
                                    <div class="form-group">
                                        {!! Form::label('Notes','Notes:') !!}
                                        {!! Form::textarea('Notes',null,['class'=>'form-control','rows'=>8]) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row col-md-11">
                    @if(isset($searchOption) && $searchOption == true)   
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary btn-basic-shadow form-control btn-block"><i class="fa fa-floppy-o"></i>
                            <span>{!! $SubmitButtonText !!}</span></button>
                        </div>
                        @endif  
                        <div class="col-md-3">
                            <a href="{{ action('Admission\DaycareController@index') }}" class="btn btn-default btn-basic-shadow form-control btn-block" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> <span>Cancel</span></a>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
        <div class="col-md-3 col-sm-3 col-xs-3 custom-fields-search-sidebar @if(isset($daycareList) && count($daycareList) > 0) sidebar-scroll-enable @endif">
            <div class="search-container">
                <table class="table table-striped table-bordered  table-responsive"  id="data-list">
                    <thead>
                        <tr class="hide">
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($daycareList) && count($daycareList) > 0)
                        @foreach($daycareList as $key => $value)
                        @php $value = collect($value)->toArray(); @endphp
                        <tr>
                            <td>
                                <div class="fields-search-list baby-name-list">
                                    <a href="{{ action('Search\SearchDaycareController@daycareSearchview',SiteHelpers::encrypt_id($value['DayId']).'?daycare_ids='.json_encode(@$daycare_ids).'&daycare_count='.@$count.'&query_log_id='.@$query_log_id . '&very_first=' . $very_first . '&very_last=' . $very_last.'&page='.$current_page) }}" class="@if(Request::get('last') && ($value['DayId'] == $very_last || $value['DayId'] == $last_id)) search-list-active @elseif (!Request::get('last') && SiteHelpers::decrypt_id(Request::segment(2)) == $value['DayId']) search-list-active @endif">
                                        {{ $value['BabyName'] }} - {{ $value['BMrNo'] }} ({{ $value['episodes'] }} -> {{ $value['day_name'] }})
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td>
                                <div class="fields-search-list">
                                    <div class="text-center"> No Records Found </div>
                                </div>
                            </td>
                        </tr>
                        @endif  
                    </tbody>
                </table>

            <div class="dataTables_footer clearfix">
                <div class="col-md-12 col-sm-12 col-xs-12 pagination-xs">
                    <div class="dataTables_paginate paging_bootstrap pagination_footer">
                        <ul class="pagination">
                            <li class="prev @if($page == '' || $page == @$pagination['start']) disabled @endif">
                                <a class="@if($page != @$pagination['start'] &&  $page != '') sort_with_page @endif" href="@if($page == @$pagination['start'] || $page == '') javascript:void(0); @else {{url('daycare-search-index/'.@$encrypt_id.'?page='.@$pagination['previous'].'&query_log_id='.@$query_log_id.'&daycare_count='.@$count . '&very_first=' . @$very_first . '&very_last=' . @$very_last)}}@endif">&#8592; Previous</a>
                            </li>
                            @if (@$getTotal > 0)
                            @for ($i = @$pagination['start']; $i <= @$pagination['end']; $i++) 
                            <li class="@if($i == $page) active @elseif($page == '' && $i == @$pagination['start']) active @endif">
                                <a class='sort_with_page' href="{{url('daycare-search-index/'.@$encrypt_id.'?page='.$i.'&query_log_id='.@$query_log_id.'&daycare_count='.@$count . '&very_first=' . @$very_first . '&very_last=' . @$very_last)}}">{{$i}}</a>
                            </li>
                            @endfor
                            @endif
                            <li class="next @if($page == @$pagination['end'] || @$pagination['total'] <= @$pagination['limits']) disabled @endif">
                                <a class="@if($page != @$pagination['end'] && @$pagination['start'] != @$pagination['end']) sort_with_page @endif" href="@if($page == @$pagination['end'] || @$pagination['total'] <= @$pagination['limits']) javascript:void(0); @else {{url('daycare-search-index/'.@$encrypt_id.'?page='.@$pagination['next'].'&query_log_id='.@$query_log_id.'&daycare_count='.@$count . '&very_first=' . @$very_first . '&very_last=' . @$very_last)}}@endif">Next → </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
                </div>
            </div>
        </div>
        @php $daycare_list =  Config('exportfields.daycare'); @endphp
        <div class="modal fade" id="exportModal" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="close-font">&times;</span>
                        </button>
                        <h5 class="modal-title">
                            <h3 class="text-center text-white">Choose Fields To Be Export</h3>
                        </h5>
                    </div>
                    <div class="modal-body row">
                        {!! Form::open(['url' => action('Search\SearchDaycareController@daycareListdownload'),'method' => 'post', 'id'=>'export-sheet']) !!}
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('file_name','Save As Name') !!}
                                    {!! Form::text('file_name','daycare-search-list',['class'=>'form-control'] ) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('file_format','Save As Format') !!}
                                    {!! Form::select('file_format',['xlsx'=>'xlsx','xlsm'=>'xlsm','csv'=>'csv'],null,['class'=>'form-control'] ) !!}
                                </div>
                            </div>
                        </div>
                        {{ Form::hidden('query_log_id', @$query_log_id) }}
                        {{ Form::hidden('daycare_id', json_encode(@$daycare_ids)) }}
                        {!! Form::hidden('daycare_export_list') !!}
                        <div class="col-md-12 plr-30">
                            <select multiple="multiple" size="10" id="daycare-options" name="daycare-options">
                                @foreach( $daycare_list as $listkey => $listvalue)
                                <option value="{{ $listkey }}">{{ $listvalue }}</option>
                                @endforeach   
                            </select>
                        </div>
                        {!! Form::close(); !!}
                    </div>
                    <div class="modal-footer plr-20">
                        <button type="button" class="btn btn-info btn-basic-shadow pull-right get-values">Export</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        @endsection
        @section('scripts')
        <script type="text/javascript">
            $('.search-sidebar').click(function(){

                $(this).parent().next('div').slideToggle('fast');

                if($(this).children('i').hasClass('fa-chevron-down')) {

                   $(this).children('i').removeClass('fa-chevron-down').addClass('fa-chevron-up');

               }else{

                   $(this).children('i').removeClass('fa-chevron-up').addClass('fa-chevron-down');
               }

           });

            $('.search-list-active').parent().prev('div').children('a').click();
            $('.search-list-active').parent().parent().prev('div').children('a').click();


            @if(@$baby->Surfactant_therapy_nicu == 'Yes')
            $('#Surfactant_therapy_nicu').bootstrapToggle('on');
            @else
            $('#Surfactant_therapy_nicu').bootstrapToggle('off');
            @endif


    // @if(@$baby->Stools == 'Bowels not opened')
    //   $('#Stools').bootstrapToggle('on');
    // @endif


            @if(@$baby->Hypoglycemia == 1)
            $('#Hypoglycemia').bootstrapToggle('on');
            @else 
            $('#Hypoglycemia').bootstrapToggle('off');  
            @endif

            @if(@$baby->Hyperglycemia == 1)
            $('#Hyperglycemia').bootstrapToggle('on');
            @else
            $('#Hyperglycemia').bootstrapToggle('off');    
            @endif

            @if(@$baby->InsulinTherapy == 1)
            $('#InsulinTherapy').bootstrapToggle('on');
            @else
            $('#InsulinTherapy').bootstrapToggle('off');    
            @endif

            @if(@$baby->Hyponatremia == 1)
            $('#Hyponatremia').bootstrapToggle('on');
            @else
            $('#Hyponatremia').bootstrapToggle('off');    
            @endif

            @if(@$baby->Hypernatremia == 1)
            $('#Hypernatremia').bootstrapToggle('on');
            @else  
            $('#Hypernatremia').bootstrapToggle('off');  
            @endif

            @if(@$baby->Hypokalemia == 1 )
            $('#Hypokalemia').bootstrapToggle('on');
            @else
            $('#Hypokalemia').bootstrapToggle('off');   
            @endif

            @if(@$baby->Hyperkalemia == 1)
            $('#Hyperkalemia').bootstrapToggle('on');
            @else
            $('#Hyperkalemia').bootstrapToggle('off');   
            @endif

            @if(@$baby->Hypocalcemia == 1)
            $('#Hypocalcemia').bootstrapToggle('on');
            @else
            $('#Hypocalcemia').bootstrapToggle('off');   
            @endif

            @if(@$baby->Hypercalcemia == 1)
            $('#Hypercalcemia').bootstrapToggle('on');
            @else
            $('#Hypercalcemia').bootstrapToggle('off');   
            @endif

            @if(@$baby->intercostaldrain == 2)
            $('#intercostaldrain').bootstrapToggle('on');
            @else
            $('#intercostaldrain').bootstrapToggle('off');   
            @endif

            @if(@$baby->needlethoracentesis == 2)
            $('#needlethoracentesis').bootstrapToggle('on');
            @else
            $('#needlethoracentesis').bootstrapToggle('off');   
            @endif

            @if(@$baby->ultrasoundabdominal == 2)
            $('#ultrasoundabdominal').bootstrapToggle('on');
            @else
            $('#ultrasoundabdominal').bootstrapToggle('off');    
            @endif

            @if(@$baby->renalultrasound == 2)
            $('#renalultrasound').bootstrapToggle('on');
            @else
            $('#renalultrasound').bootstrapToggle('off'); 
            @endif

            @if(@$baby->neuro_sonogram == 'performed')
            $('#neuro_sonogram').bootstrapToggle('on');
            @else
            $('#neuro_sonogram').bootstrapToggle('off');  
            @endif

            @if(@$baby->mrict_brain_status == 2)
            $('#mrict_brain_status').bootstrapToggle('on');
            @else
            $('#mrict_brain_status').bootstrapToggle('off');   
            @endif

            @if(@$baby->viral_meningitis == 2)
            $('#viral_meningitis').bootstrapToggle('on');
            @else
            $('#viral_meningitis').bootstrapToggle('off');   
            @endif

            @if(@$baby->ultrasound_spine == 2)
            $('#ultrasound_spine').bootstrapToggle('on');
            @else
            $('#ultrasound_spine').bootstrapToggle('off');   
            @endif

    // @if(@$baby->lumbar_puncture == 2)
    //    $('#lumbar_puncture').bootstrapToggle('on');
    // @endif

            @if(@$baby->eeg_cfm == 2)
            $('#eeg_cfm').bootstrapToggle('on');
            @else
            $('#eeg_cfm').bootstrapToggle('off');    
            @endif

            @if(@$baby->dilution_exchange == 2)
            $('#dilution_exchange').bootstrapToggle('on');
            @else
            $('#dilution_exchange').bootstrapToggle('off');    
            @endif

            @if(@$baby->chronic_lung == 2)
            $('#chronic_lung').bootstrapToggle('on');
            @else
            $('#chronic_lung').bootstrapToggle('off');    
            @endif
            $('.nav-tabs li a').click(function(){
                $.cookie('daycare', $(this).attr('href'));

            });

            var acive_id=$.cookie('daycare');
            if(acive_id!='' && acive_id!=null ) {
                $('.nav-tabs li').each(function() {
                    if($(this).hasClass('active')) {
                       $(this).removeClass('active');
                   }
               });
                $('.tab-pane').each(function() {
                    if($(this).hasClass('active')) {
                      $(this).removeClass('active');
                  }
              });
                $('a[href="'+acive_id+'"]').parent().addClass('active');
                $(acive_id).addClass('active');
            }
            $('.btn-success').click(function() {
                $(this).child('input').click();
            });
            $('.export').click(function(e){
               e.preventDefault();           
               $('#exportModal').modal('show');
           });
            $(document).ready(function(){
                new DualListbox("#daycare-options", {
                    availableTitle: "Available numbers",
                    selectedTitle: "Selected numbers",
                    addButtonText: ">",
                    removeButtonText: "<",
                    addAllButtonText: ">>",
                    removeAllButtonText: "<<",
                    searchPlaceholder: "search numbers",
                    enableDoubleClick: true,
                });
            });
            $('.get-values').click(function(e) {
                e.preventDefault();
                var value_list = [];
                $('.dual-listbox__selected li').each(function(){
                    value_list.push($(this).attr('data-id'));
                });
                var validate    =  false;
                $('.error-export').remove();
                $('input[name="daycare_export_list"]').val(JSON.stringify(value_list));
                if ($('input[name="file_name"]').val() == '') {
                 validate = true;
                 $('input[name="file_name"]').after('<span class="error-export"> This fields required</span>');
             } 
             if (value_list.length == 0) {
               validate = true;
               $('select[name="daycare-options_helper2"]').after('<span class="error-export"> Please Choose The Fields required</span>');
           }
           if (!validate) {
               $('#export-sheet').submit();
               $('#exportModal').modal('hide');
           }
       });
            $('.container').addClass('advance-search');
            $('#container').addClass('advance-search');

        </script>
        @endsection
