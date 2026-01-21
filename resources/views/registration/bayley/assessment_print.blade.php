@extends('print')
@section('content')
@php
$cg = 1;
$rc = 2;
$ec = 3;
$fm = 4;
$gm = 5;
@endphp
<div class="temp-container">
    <div class="temp-row">
        <div class="col-md-12">
            <div class="row">
                <div class="assessment-container col-md-12">
                    <div class="col-md-12">
                        <div class="row header-align">
                            <div class="col-xs-4">
                                <div class="row">
                                    <img src="{{ ValuelistHelpers::printPagelogo() }}" class="expect">
                                </div>
                            </div>
                            <div class="col-xs-4 text-center">
                                <div class="row">
                                    <h3 class="m-0"><b id="title">Bayley</b></h3>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="basic-details">
                                <table>
                                    <tr>
                                        <td class="text-left">{{ Lang::get('home.mrn') }}:</td>
                                        <td class="text-left"><b>{{ $results->BMrNo }}</b></td>
                                        <td class="text-left">Baby Name:</td>
                                        <td class="text-left"><b>{{ $results->BabyName }}</b></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">DOB:</td>
                                        <td class="text-left"><b>{{ date('d-m-Y', strtotime($results->DOB)) }}</b></td>
                                        @if($results->g_weeks == 0 || $results->g_weeks > 36 || ($results->g_weeks < 37 && $results->corrected_year > 1))
                                        <td class="text-left">Age:</td>
                                        <td class="text-left"><b>{{ $results->chronological_year > 0 ? $results->chronological_year . ' Y ' : '' }} {{ $results->chronological_month > 0 ? $results->chronological_month . ' M' : '' }} {{ $results->chronological_days > 0 ? $results->chronological_days . ' D' : '' }}</b></td>
                                        @else
                                        <td class="text-left">Chronological Age:</td>
                                        <td class="text-left"><b>{{ $results->chronological_year > 0 ? $results->chronological_year . ' Y ' : '' }} {{ $results->chronological_month > 0 ? $results->chronological_month . ' M' : '' }} {{ $results->chronological_days > 0 ? $results->chronological_days . ' D' : '' }}</b></td>
                                        <td class="text-left">Corrected Age:</td>
                                        <td class="text-left"><b>{{ $results->corrected_year > 0 ? $results->corrected_year . ' Y ' : '' }} {{ $results->corrected_month > 0 ? $results->corrected_month . ' M' : '' }} {{ $results->corrected_days > 0 ? $results->corrected_days . ' D' : '' }}</b></td>
                                        @endif
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            @include('registration.bayley.summary_print')
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <h2 class="text-center">Cognitive (CG)</h2>
                            <table class="table table-bordered border-none">
                                <thead>
                                    <tr>
                                        <th class="background-transparent border-0"></th>
                                        <th width="10%">Item</th>
                                        <th width="15%">Materials</th>
                                        <th>Scoring criteria</th>
                                        <th width="2%">Score</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php 
                                    $start_point = ''; 
                                    @endphp
                                    @foreach($bayley_master[$cg] as $question_key => $question_value)
                                    @php 
                                    $type_3 = 0;
                                    $type_3_count = collect($question_value)->where('type', 3)->pluck('type')->count();
                                    $temp = $type_3_count > 0 ? $type_3_count - 1 : $type_3_count;
                                    $row_count = count($question_value) - $temp;
                                    @endphp
                                    @foreach($question_value as $key => $value)
                                    @php
                                    $question_no = $value['question_no'];
                                    $sub_id = $value['sub_id'];
                                    $current_point = $value['start_point'];
                                    @endphp
                                    @if ($value['type'] != 3 || ($value['type'] == 3 && $type_3 == 0))
                                    <tr data-category="{!! $cg !!}" data-question="{!! $question_key !!}" data-sub-question="{!! $sub_id !!}" data-type="{!! $value['type'] !!}" data-point="{!! $current_point !!}">
                                        @endif
                                        @if ($key == 0)
                                        @if ($start_point != $current_point)
                                        @php 
                                        $start_point = $current_point; 
                                        $accurate_point = explode(',', $current_point);
                                        @endphp
                                        <td rowspan="{!! $row_count !!}" class="border-0">
                                            @foreach ($accurate_point as $point_name)
                                            <span class="point" id="cg-point-{!! $point_name !!}"></span>
                                            @endforeach
                                            <div class="display-flex">
                                                <div class="bookmark display-none"></div>
                                                <span class="position-highligher">
                                                    <div class="arrow-5"></div>
                                                    <b>{!! $accurate_point[0] !!}@if (count($accurate_point) - 1 != 0){!! '-'. $accurate_point[count($accurate_point) - 1] !!}@endif</b>
                                                </span>
                                            </div>
                                        </td>
                                        @else
                                        <td rowspan="{!! $row_count !!}" class="border-0"></td>
                                        @endif
                                        <td rowspan="{!! $row_count !!}" class="text-left">
                                            <div class="display-flex">
                                                <div class="pr-5">{!! $value['question_no'] !!}.</div>
                                                <div>{!! $value['item'] !!}</div>
                                            </div>
                                        </td>
                                        <td rowspan="{!! $row_count !!}" class="text-left">{!! $value['materials'] !!}</td>
                                        @endif
                                        @if ($value['type'] == 1)
                                        <td class="text-left score-bg score-bg-cg score-block {!! isset($score_sub_id_cg[$question_key]) && $score_sub_id_cg[$question_key] == $sub_id ? 'active-block' : ''; !!}" data-value="{!! $value['score'] !!}">{!! $value['title'] !!}</td>
                                        <td class="score-block {!! isset($score_sub_id_cg[$question_key]) && $score_sub_id_cg[$question_key] == $sub_id ? 'active-block' : ''; !!}" data-value="{!! $value['score'] !!}">{!! $value['score'] !!}</td>
                                        @elseif ($value['type'] == 2)
                                        <td colspan="2" class="text-left">
                                            {!! $value['title'] !!}
                                            {!! @$note[$sub_id] !!}
                                        </td>     
                                        @elseif ($value['type'] == 4)
                                        <td colspan="2" class="text-left">
                                            {!! $value['title'] !!}
                                            {!! @$note[$sub_id] !!}
                                        </td>                                               
                                        @elseif ($value['type'] == 3)
                                        @if ($type_3 == 0)
                                        <td colspan="2" class="text-left" class="border-bottom-0">
                                            Correct?
                                            <br/>
                                            @endif
                                            @php
                                            $title = $value['title'];
                                            $title = explode('*', $title);
                                            @endphp
                                            <div class="checkbox_view">
                                                {!! $title[0] !!} 
                                                {!! Form::checkbox("correct[$cg][$question_no][$sub_id]", @$correct[$sub_id], null, ['class'=>'note-input', 'disabled']) !!}
                                                {!! $title[1] !!}
                                            </div>
                                            @php $type_3++; @endphp
                                            @if ($type_3 == $type_3_count)
                                            @php $type_3 = 0; @endphp
                                        </td>
                                        @endif
                                        @endif
                                        @if ($value['type'] != 3 || ($value['type'] == 3 && $type_3 == 0))
                                    </tr>
                                    @endif
                                    @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <h2 class="text-center">Receptive Communication (RC)</h2>
                            <table class="table table-bordered border-none">
                                <thead>
                                    <tr>
                                        <th class="background-transparent border-0"></th>
                                        <th width="10%">Item</th>
                                        <th width="15%">Materials</th>
                                        <th>Scoring criteria</th>
                                        <th width="2%">Score</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php 
                                    $start_point = ''; 
                                    @endphp
                                    @foreach($bayley_master[$rc] as $question_key => $question_value)
                                    @php 
                                    $type_3 = 0;
                                    $type_3_count = collect($question_value)->where('type', 3)->pluck('type')->count();
                                    $temp = $type_3_count > 0 ? $type_3_count - 1 : $type_3_count;
                                    $row_count = count($question_value) - $temp;
                                    @endphp
                                    @foreach($question_value as $key => $value)
                                    @php
                                    $question_no = $value['question_no'];
                                    $sub_id = $value['sub_id'];
                                    $current_point = $value['start_point'];
                                    @endphp
                                    @if ($value['type'] != 3 || ($value['type'] == 3 && $type_3 == 0))
                                    <tr data-category="{!! $rc !!}" data-question="{!! $question_key !!}" data-sub-question="{!! $sub_id !!}" data-type="{!! $value['type'] !!}" data-point="{!! $current_point !!}">
                                        @endif
                                        @if ($key == 0)
                                        @if ($start_point != $current_point)
                                        @php 
                                        $start_point = $current_point; 
                                        $accurate_point = explode(',', $current_point);
                                        @endphp
                                        <td rowspan="{!! $row_count !!}" class="border-0">
                                            @foreach ($accurate_point as $point_name)
                                            <span class="point" id="rc-point-{!! $point_name !!}"></span>
                                            @endforeach
                                            <div class="display-flex">
                                                <div class="bookmark display-none"></div>
                                                <span class="position-highligher">
                                                    <div class="arrow-5"></div>
                                                    <b>{!! $accurate_point[0] !!}@if (count($accurate_point) - 1 != 0){!! '-'. $accurate_point[count($accurate_point) - 1] !!}@endif</b>
                                                </span>
                                            </div>
                                        </td>
                                        @else
                                        <td rowspan="{!! $row_count !!}" class="border-0"></td>
                                        @endif
                                        <td rowspan="{!! $row_count !!}" class="text-left">
                                            <div class="display-flex">
                                                <div class="pr-5">{!! $value['question_no'] !!}.</div>
                                                <div>{!! $value['item'] !!}</div>
                                            </div>
                                        </td>
                                        <td rowspan="{!! $row_count !!}" class="text-left">{!! $value['materials'] !!}</td>
                                        @endif
                                        @if ($value['type'] == 1)
                                        <td class="text-left score-bg score-bg-rc score-block  {!! isset($score_sub_id_rc[$question_key]) && $score_sub_id_rc[$question_key] == $sub_id ? 'active-block' : ''; !!}" data-value="{!! $value['score'] !!}">{!! $value['title'] !!}</td>
                                        <td class="score-block  {!! isset($score_sub_id_rc[$question_key]) && $score_sub_id_rc[$question_key] == $sub_id ? 'active-block' : ''; !!}" data-value="{!! $value['score'] !!}">{!! $value['score'] !!}</td>
                                        @elseif ($value['type'] == 2)
                                        <td colspan="2" class="text-left">
                                            {!! $value['title'] !!}
                                            {!! @$note[$sub_id] !!}
                                        </td>     
                                        @elseif ($value['type'] == 4)
                                        <td colspan="2" class="text-left">
                                            {!! $value['title'] !!}
                                            {!! @$note[$sub_id] !!}
                                        </td>                                               
                                        @elseif ($value['type'] == 3)
                                        @if ($type_3 == 0)
                                        <td colspan="2" class="text-left" class="border-bottom-0">
                                            Correct?
                                            <br/>
                                            @endif
                                            @php
                                            $title = $value['title'];
                                            $title = explode('*', $title);
                                            @endphp
                                            <div class="checkbox_view">
                                                {!! $title[0] !!} 
                                                {!! Form::checkbox("correct[$rc][$question_no][$sub_id]", @$correct[$sub_id], null, ['class'=>'note-input']) !!}
                                                {!! $title[1] !!}
                                            </div>
                                            @php $type_3++; @endphp
                                            @if ($type_3 == $type_3_count)
                                            @php $type_3 = 0; @endphp
                                        </td>
                                        @endif
                                        @endif
                                        @if ($value['type'] != 3 || ($value['type'] == 3 && $type_3 == 0))
                                    </tr>
                                    @endif
                                    @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <h2 class="text-center">Expressive Communication (EC)</h2>
                            <table class="table table-bordered border-none">
                                <thead>
                                    <tr>
                                        <th class="background-transparent border-0"></th>
                                        <th width="10%">Item</th>
                                        <th width="15%">Materials</th>
                                        <th>Scoring criteria</th>
                                        <th width="2%">Score</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php 
                                    $start_point = ''; 
                                    @endphp
                                    @foreach($bayley_master[$ec] as $question_key => $question_value)
                                    @php 
                                    $type_3 = 0;
                                    $type_3_count = collect($question_value)->where('type', 3)->pluck('type')->count();
                                    $temp = $type_3_count > 0 ? $type_3_count - 1 : $type_3_count;
                                    $row_count = count($question_value) - $temp;
                                    @endphp
                                    @foreach($question_value as $key => $value)
                                    @php
                                    $question_no = $value['question_no'];
                                    $sub_id = $value['sub_id'];
                                    $current_point = $value['start_point'];
                                    @endphp
                                    @if ($value['type'] != 3 || ($value['type'] == 3 && $type_3 == 0))
                                    <tr data-category="{!! $ec !!}" data-question="{!! $question_key !!}" data-sub-question="{!! $sub_id !!}" data-type="{!! $value['type'] !!}" data-point="{!! $current_point !!}">
                                        @endif
                                        @if ($key == 0)
                                        @if ($start_point != $current_point)
                                        @php 
                                        $start_point = $current_point; 
                                        $accurate_point = explode(',', $current_point);
                                        @endphp
                                        <td rowspan="{!! $row_count !!}" class="border-0">
                                            @foreach ($accurate_point as $point_name)
                                            <span class="point" id="ec-point-{!! $point_name !!}"></span>
                                            @endforeach
                                            <div class="display-flex">
                                                <div class="bookmark display-none"></div>
                                                <span class="position-highligher">
                                                    <div class="arrow-5"></div>
                                                    <b>{!! $accurate_point[0] !!}@if (count($accurate_point) - 1 != 0){!! '-'. $accurate_point[count($accurate_point) - 1] !!}@endif</b>
                                                </span>
                                            </div>
                                        </td>
                                        @else
                                        <td rowspan="{!! $row_count !!}" class="border-0"></td>
                                        @endif
                                        <td rowspan="{!! $row_count !!}" class="text-left">
                                            <div class="display-flex">
                                                <div class="pr-5">{!! $value['question_no'] !!}.</div>
                                                <div>{!! $value['item'] !!}</div>
                                            </div>
                                        </td>
                                        <td rowspan="{!! $row_count !!}" class="text-left">{!! $value['materials'] !!}</td>
                                        @endif
                                        @if ($value['type'] == 1)
                                        <td class="text-left score-bg score-bg-ec score-block {!! isset($score_sub_id_ec[$question_key]) && $score_sub_id_ec[$question_key] == $sub_id ? 'active-block' : ''; !!}" data-value="{!! $value['score'] !!}">{!! $value['title'] !!}</td>
                                        <td class="score-block {!! isset($score_sub_id_ec[$question_key]) && $score_sub_id_ec[$question_key] == $sub_id ? 'active-block' : ''; !!}" data-value="{!! $value['score'] !!}">{!! $value['score'] !!}</td>
                                        @elseif ($value['type'] == 2)
                                        <td colspan="2" class="text-left">
                                            {!! $value['title'] !!}
                                            {!! @$note[$sub_id] !!}
                                        </td>     
                                        @elseif ($value['type'] == 4)
                                        <td colspan="2" class="text-left">
                                            {!! $value['title'] !!}
                                            {!! @$note[$sub_id] !!}
                                        </td>                                               
                                        @elseif ($value['type'] == 3)
                                        @if ($type_3 == 0)
                                        <td colspan="2" class="text-left" class="border-bottom-0">
                                            Correct?
                                            <br/>
                                            @endif
                                            @php
                                            $title = $value['title'];
                                            $title = explode('*', $title);
                                            @endphp
                                            <div class="checkbox_view">
                                                {!! $title[0] !!} 
                                                {!! Form::checkbox("correct[$ec][$question_no][$sub_id]", @$correct[$sub_id], null, ['class'=>'note-input']) !!}
                                                {!! $title[1] !!}
                                            </div>
                                            @php $type_3++; @endphp
                                            @if ($type_3 == $type_3_count)
                                            @php $type_3 = 0; @endphp
                                        </td>
                                        @endif
                                        @endif
                                        @if ($value['type'] != 3 || ($value['type'] == 3 && $type_3 == 0))
                                    </tr>
                                    @endif
                                    @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <h2 class="text-center">Fine Motor (FM)</h2>
                            <table class="table table-bordered border-none">
                                <thead>
                                    <tr>
                                        <th class="background-transparent border-0"></th>
                                        <th width="10%">Item</th>
                                        <th width="15%">Materials</th>
                                        <th>Scoring criteria</th>
                                        <th width="2%">Score</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php 
                                    $start_point = ''; 
                                    @endphp
                                    @foreach($bayley_master[$fm] as $question_key => $question_value)
                                    @php 
                                    $type_3 = 0;
                                    $type_3_count = collect($question_value)->where('type', 3)->pluck('type')->count();
                                    $temp = $type_3_count > 0 ? $type_3_count - 1 : $type_3_count;
                                    $row_count = count($question_value) - $temp;
                                    @endphp
                                    @foreach($question_value as $key => $value)
                                    @php
                                    $question_no = $value['question_no'];
                                    $sub_id = $value['sub_id'];
                                    $current_point = $value['start_point'];
                                    @endphp
                                    @if ($value['type'] != 3 || ($value['type'] == 3 && $type_3 == 0))
                                    <tr data-category="{!! $fm !!}" data-question="{!! $question_key !!}" data-sub-question="{!! $sub_id !!}" data-type="{!! $value['type'] !!}" data-point="{!! $current_point !!}">
                                        @endif
                                        @if ($key == 0)
                                        @if ($start_point != $current_point)
                                        @php 
                                        $start_point = $current_point; 
                                        $accurate_point = explode(',', $current_point);
                                        @endphp
                                        <td rowspan="{!! $row_count !!}" class="border-0">
                                            @foreach ($accurate_point as $point_name)
                                            <span class="point" id="fm-point-{!! $point_name !!}"></span>
                                            @endforeach
                                            <div class="display-flex">
                                                <div class="bookmark display-none"></div>
                                                <span class="position-highligher">
                                                    <div class="arrow-5"></div>
                                                    <b>{!! $accurate_point[0] !!}@if (count($accurate_point) - 1 != 0){!! '-'. $accurate_point[count($accurate_point) - 1] !!}@endif</b>
                                                </span>
                                            </div>
                                        </td>
                                        @else
                                        <td rowspan="{!! $row_count !!}" class="border-0"></td>
                                        @endif
                                        <td rowspan="{!! $row_count !!}" class="text-left">
                                            <div class="display-flex">
                                                <div class="pr-5">{!! $value['question_no'] !!}.</div>
                                                <div>{!! $value['item'] !!}</div>
                                            </div>
                                        </td>
                                        <td rowspan="{!! $row_count !!}" class="text-left">{!! $value['materials'] !!}</td>
                                        @endif
                                        @if ($value['type'] == 1)
                                        <td class="text-left score-bg score-bg-fm score-block {!! isset($score_sub_id_fm[$question_key]) && $score_sub_id_fm[$question_key] == $sub_id ? 'active-block' : ''; !!}" data-value="{!! $value['score'] !!}">{!! $value['title'] !!}</td>
                                        <td class="score-block {!! isset($score_sub_id_fm[$question_key]) && $score_sub_id_fm[$question_key] == $sub_id ? 'active-block' : ''; !!}" data-value="{!! $value['score'] !!}">{!! $value['score'] !!}</td>
                                        @elseif ($value['type'] == 2)
                                        <td colspan="2" class="text-left">
                                            {!! $value['title'] !!}
                                            {!! @$note[$sub_id] !!}
                                        </td>     
                                        @elseif ($value['type'] == 4)
                                        <td colspan="2" class="text-left">
                                            {!! $value['title'] !!}
                                            {!! @$note[$sub_id] !!}
                                        </td>                                               
                                        @elseif ($value['type'] == 3)
                                        @if ($type_3 == 0)
                                        <td colspan="2" class="text-left" class="border-bottom-0">
                                            Correct?
                                            <br/>
                                            @endif
                                            @php
                                            $title = $value['title'];
                                            $title = explode('*', $title);
                                            @endphp
                                            <div class="checkbox_view">
                                                {!! $title[0] !!} 
                                                {!! Form::checkbox("correct[$cg][$question_no][$sub_id]", @$correct[$sub_id], null, ['class'=>'note-input']) !!}
                                                {!! $title[1] !!}
                                            </div>
                                            @php $type_3++; @endphp
                                            @if ($type_3 == $type_3_count)
                                            @php $type_3 = 0; @endphp
                                        </td>
                                        @endif
                                        @endif
                                        @if ($value['type'] != 3 || ($value['type'] == 3 && $type_3 == 0))
                                    </tr>
                                    @endif
                                    @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <h2 class="text-center">Gross Motor (GM)</h2>
                            <table class="table table-bordered border-none">
                                <thead>
                                    <tr>
                                        <th class="background-transparent border-0"></th>
                                        <th width="10%">Item</th>
                                        <th width="15%">Materials</th>
                                        <th>Scoring criteria</th>
                                        <th width="2%">Score</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php 
                                    $start_point = ''; 
                                    @endphp
                                    @foreach($bayley_master[$gm] as $question_key => $question_value)
                                    @php 
                                    $type_3 = 0;
                                    $type_3_count = collect($question_value)->where('type', 3)->pluck('type')->count();
                                    $temp = $type_3_count > 0 ? $type_3_count - 1 : $type_3_count;
                                    $row_count = count($question_value) - $temp;
                                    @endphp
                                    @foreach($question_value as $key => $value)
                                    @php
                                    $question_no = $value['question_no'];
                                    $sub_id = $value['sub_id'];
                                    $current_point = $value['start_point'];
                                    @endphp
                                    @if ($value['type'] != 3 || ($value['type'] == 3 && $type_3 == 0))
                                    <tr data-category="{!! $gm !!}" data-question="{!! $question_key !!}" data-sub-question="{!! $sub_id !!}" data-type="{!! $value['type'] !!}" data-point="{!! $current_point !!}">
                                        @endif
                                        @if ($key == 0)
                                        {!! Form::hidden("score_sub_id[$gm][$question_key]", @$score_sub_id_gm[$question_key],['class'=>'note-input']) !!}
                                        {!! Form::hidden("score[$gm][$question_key]", @$score[$sub_id],['class'=>'note-input']) !!}
                                        @if ($start_point != $current_point)
                                        @php 
                                        $start_point = $current_point; 
                                        $accurate_point = explode(',', $current_point);
                                        @endphp
                                        <td rowspan="{!! $row_count !!}" class="border-0">
                                            @foreach ($accurate_point as $point_name)
                                            <span class="point" id="gm-point-{!! $point_name !!}"></span>
                                            @endforeach
                                            <div class="display-flex">
                                                <div class="bookmark display-none"></div>
                                                <span class="position-highligher">
                                                    <div class="arrow-5"></div>
                                                    <b>{!! $accurate_point[0] !!}@if (count($accurate_point) - 1 != 0){!! '-'. $accurate_point[count($accurate_point) - 1] !!}@endif</b>
                                                </span>
                                            </div>
                                        </td>
                                        @else
                                        <td rowspan="{!! $row_count !!}" class="border-0"></td>
                                        @endif
                                        <td rowspan="{!! $row_count !!}" class="text-left">
                                            <div class="display-flex">
                                                <div class="pr-5">{!! $value['question_no'] !!}.</div>
                                                <div>{!! $value['item'] !!}</div>
                                            </div>
                                        </td>
                                        <td rowspan="{!! $row_count !!}" class="text-left">{!! $value['materials'] !!}</td>
                                        @endif
                                        @if ($value['type'] == 1)
                                        <td class="text-left score-bg score-bg-gm score-block {!! isset($score_sub_id_gm[$question_key]) && $score_sub_id_gm[$question_key] == $sub_id ? 'active-block' : ''; !!}" data-value="{!! $value['score'] !!}">{!! $value['title'] !!}</td>
                                        <td class="score-block {!! isset($score_sub_id_gm[$question_key]) && $score_sub_id_gm[$question_key] == $sub_id ? 'active-block' : ''; !!}" data-value="{!! $value['score'] !!}">{!! $value['score'] !!}</td>
                                        @elseif ($value['type'] == 2)
                                        <td colspan="2" class="text-left">
                                            {!! $value['title'] !!}
                                            {!! @$note[$sub_id] !!}
                                        </td>     
                                        @elseif ($value['type'] == 4)
                                        <td colspan="2" class="text-left">
                                            {!! $value['title'] !!}
                                            {!! @$note[$sub_id] !!}
                                        </td>                                               
                                        @elseif ($value['type'] == 3)
                                        @if ($type_3 == 0)
                                        <td colspan="2" class="text-left" class="border-bottom-0">
                                            Correct?
                                            <br/>
                                            @endif
                                            @php
                                            $title = $value['title'];
                                            $title = explode('*', $title);
                                            @endphp
                                            <div class="checkbox_view">
                                                {!! $title[0] !!} 
                                                {!! Form::checkbox("correct[$gm][$question_no][$sub_id]", @$correct[$sub_id], null, ['class'=>'note-input']) !!}
                                                {!! $title[1] !!}
                                            </div>
                                            @php $type_3++; @endphp
                                            @if ($type_3 == $type_3_count)
                                            @php $type_3 = 0; @endphp
                                        </td>
                                        @endif
                                        @endif
                                        @if ($value['type'] != 3 || ($value['type'] == 3 && $type_3 == 0))
                                    </tr>
                                    @endif
                                    @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection