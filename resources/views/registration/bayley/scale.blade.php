@php
$cg = 1;
$rc = 2;
$ec = 3;
$fm = 4;
$gm = 5;
$se = 6;
$ab_r = 7;
$ab_e = 8;
$ab_p = 9;
$ab_ir = 10;
$ab_pl = 11;
$table_id_score_cg = isset($table_id_score_cg) ? $table_id_score_cg : [];
$table_id_score_rc = isset($table_id_score_rc) ? $table_id_score_rc : [];
$table_id_score_ec = isset($table_id_score_ec) ? $table_id_score_ec : [];
$table_id_score_fm = isset($table_id_score_fm) ? $table_id_score_fm : [];
$table_id_score_gm = isset($table_id_score_gm) ? $table_id_score_gm : [];
$table_id_score_se = isset($table_id_score_se) ? $table_id_score_se : [];

$table_id_score_ab_r = isset($table_id_score_ab_r) ? $table_id_score_ab_r : [];
$table_id_score_ab_e = isset($table_id_score_ab_e) ? $table_id_score_ab_e : [];
$table_id_score_ab_p = isset($table_id_score_ab_p) ? $table_id_score_ab_p : [];
$table_id_score_ab_ir = isset($table_id_score_ab_ir) ? $table_id_score_ab_ir : [];
$table_id_score_ab_pl = isset($table_id_score_ab_pl) ? $table_id_score_ab_pl : [];
$table_id_other = isset($table_id_other) ? $table_id_other : [];
$last_cg = 0;
$last_rc = 0;
$last_ec = 0;
$last_fm = 0;
$last_gm = 0;
@endphp

{!! Form::hidden('start_point', null, ['class'=>'add-value']) !!}

{!! Form::hidden('table_id_score_cg', json_encode($table_id_score_cg), ['class'=>'add-value']) !!}
{!! Form::hidden('table_id_score_rc', json_encode($table_id_score_rc), ['class'=>'add-value']) !!}
{!! Form::hidden('table_id_score_ec', json_encode($table_id_score_ec), ['class'=>'add-value']) !!}
{!! Form::hidden('table_id_score_fm', json_encode($table_id_score_fm), ['class'=>'add-value']) !!}
{!! Form::hidden('table_id_score_gm', json_encode($table_id_score_gm), ['class'=>'add-value']) !!}
{!! Form::hidden('table_id_score_se', json_encode($table_id_score_se), ['class'=>'add-value']) !!}

{!! Form::hidden('table_id_score_ab_r', json_encode($table_id_score_ab_r), ['class'=>'add-value']) !!}
{!! Form::hidden('table_id_score_ab_e', json_encode($table_id_score_ab_e), ['class'=>'add-value']) !!}
{!! Form::hidden('table_id_score_ab_p', json_encode($table_id_score_ab_p), ['class'=>'add-value']) !!}
{!! Form::hidden('table_id_score_ab_ir', json_encode($table_id_score_ab_ir), ['class'=>'add-value']) !!}
{!! Form::hidden('table_id_score_ab_pl', json_encode($table_id_score_ab_pl), ['class'=>'add-value']) !!}
{!! Form::hidden('table_id_other', json_encode($table_id_other), ['class'=>'add-value']) !!}
<div class="row">
    <div class="col-xs-12 text-right back-to-screeening">
        <button type="button" class="btn btn-success back_to_screening"><i class="fa fa-chevron-circle-left"></i> BACK TO SCREENING</button>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        @if (isset($results->id))
        <!-- <button class="btn btn-default pull-right neuro_update_btn" data-flag="6" id="export-bayley">Export</button> -->
        @endif
        <div class="col-md-10 col-md-offset-1">
            <div class="table-responsive">
                <h3 class="text-center" style="display: flow-root;"><span class="pull-right">Age - <b id="age-label"></b></span></h3>
                {!! Form::hidden('whole_days') !!}
                <div class="panel-group" id="bayleyaccordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="bayleyHeadingOne">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#bayleyaccordion" href="#bayleyOne" aria-expanded="true" aria-controls="bayleyOne" class="collapsed">
                                    Cognitive (CG)
                                    <span class="color-black font-normal pull-right plr-15" id="cg">Raw score: <b>{!! @$results->cg !!}</b></span>
                                </a>
                            </h4>
                        </div>
                        <div id="bayleyOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="bayleyHeadingOne">
                            <div class="panel-body">
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
                                        $count = 1;
                                        $cg_pass_mark = 0;
                                        $cg_pass_manager = [];
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
                                        @if ($key == 0)
                                        @if ($start_point != $current_point)
                                        @php $count = 1; @endphp             
                                        @else
                                        @php $count++; @endphp                                            
                                        @endif
                                        @endif
                                        <tr data-category="{!! $cg !!}" data-question="{!! $question_key !!}" data-sub-question="{!! $sub_id !!}" data-type="{!! $value['type'] !!}" data-point="{!! $current_point !!}" data-count="{!! $count !!}" data-scale="{!! $value['score'] !!}">
                                            @endif
                                            @if ($key == 0)
                                            {!! Form::hidden("score_sub_id[$cg][$question_key]", @$score_sub_id_cg[$question_key],['class'=>'note-input', 'data-original'=>@$score_sub_id_cg[$question_key]]) !!}
                                            {!! Form::hidden("score[$cg][$question_key]", @$score_cg[$question_key],['class'=>'note-input cg-scale-score','id'=>'cg-ans-'.$question_key, 'data-ques-id'=> $question_key, 'data-manual'=> @$manual_cg[$question_key]]) !!}
                                            {!! Form::hidden("is_manual[$cg][$question_key]", @$manual_cg[$question_key],['class'=>'note-input','id'=>'cg-manual-'.$question_key]) !!}

                                            @if (isset($manual_cg[$question_key]) && isset($score_cg[$question_key]))
                                            @if ($manual_cg[$question_key] == 'true')
                                            @if ($score_cg[$question_key] == 2)
                                            @php 
                                            $cg_pass_mark++; 
                                            $cg_pass_manager[] = $question_key;
                                            @endphp
                                            @elseif (count($cg_pass_manager) < 3)
                                            @php 
                                            $cg_pass_mark = 0; 
                                            $cg_pass_manager = [];
                                            @endphp                                                           
                                            @endif
                                            @else
                                            @php 
                                            $cg_pass_mark = 0; 
                                            $cg_pass_manager = [];
                                            @endphp
                                            @endif
                                            @endif

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
                                            <td class="text-left score-bg score-bg-cg score-block {!! (isset($score_sub_id_cg[$question_key]) && $score_sub_id_cg[$question_key] == $sub_id && isset($score_cg[$question_key]) && ((int)$score_cg[$question_key] >= 0)) ? 'active-block' : ''; !!}" data-value="{!! $value['score'] !!}">{!! $value['title'] !!}</td>
                                            <td class="score-block {!! (isset($score_sub_id_cg[$question_key]) && $score_sub_id_cg[$question_key] == $sub_id && isset($score_cg[$question_key]) && ((int)$score_cg[$question_key] >= 0)) ? 'active-block' : ''; !!}" data-value="{!! $value['score'] !!}">{!! $value['score'] !!}</td>
                                            @elseif ($value['type'] == 2)
                                            <td colspan="2" class="text-left">
                                                {!! $value['title'] !!}
                                                {!! Form::textarea("note[$cg][$question_no][$sub_id]", @$note[$sub_id], ['class'=>'form-control note-input', 'rows'=>2]) !!}
                                            </td>     
                                            @elseif ($value['type'] == 4)
                                            <td colspan="2" class="text-left">
                                                {!! $value['title'] !!}
                                                {!! Form::text("note[$cg][$question_no][$sub_id]", @$note[$sub_id], ['class'=>'form-control note-input']) !!}
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
                                                    {!! Form::checkbox("correct[$cg][$question_no][$sub_id]", null, @$correct[$sub_id], ['class'=>'add-value', 'id'=>"correct[$cg][$question_no][$sub_id]"]) !!}
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
                                        @php $last_cg = $question_key; @endphp
                                        @endforeach
                                        {!! Form::hidden('cg_pass_mark', $cg_pass_mark) !!}
                                        {!! Form::hidden('cg_pass_manager', json_encode($cg_pass_manager)) !!}

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="bayleyHeadingTwo">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#bayleyaccordion" href="#bayleyTwo" aria-expanded="true" aria-controls="bayleyTwo" class="collapsed">
                                    Receptive Communication (RC)
                                    <span class="color-black font-normal pull-right plr-15" id="rc">Raw score: <b>{!! @$results->rc !!}</b></span>
                                </a>
                            </h4>
                        </div>
                        <div id="bayleyTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="bayleyHeadingTwo">
                            <div class="panel-body">
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
                                        $count = 1;
                                        $rc_pass_mark = 0;
                                        $rc_pass_manager = [];
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
                                        @if ($key == 0)
                                        @if ($start_point != $current_point)
                                        @php $count = 1; @endphp             
                                        @else
                                        @php $count++; @endphp                                            
                                        @endif
                                        @endif
                                        <tr data-category="{!! $rc !!}" data-question="{!! $question_key !!}" data-sub-question="{!! $sub_id !!}" data-type="{!! $value['type'] !!}" data-point="{!! $current_point !!}" data-count="{!! $count !!}" data-scale="{!! $value['score'] !!}">
                                            @endif
                                            @if ($key == 0)
                                            {!! Form::hidden("score_sub_id[$rc][$question_key]", @$score_sub_id_rc[$question_key],['class'=>'note-input', 'data-original'=>@$score_sub_id_rc[$question_key]]) !!}
                                            {!! Form::hidden("score[$rc][$question_key]", @$score_rc[$question_key],['class'=>'note-input rc-scale-score','id'=>'rc-ans-'.$question_key, 'data-ques-id'=> $question_key, 'data-manual'=> @$manual_rc[$question_key]]) !!}
                                            {!! Form::hidden("is_manual[$rc][$question_key]", @$manual_rc[$question_key],['class'=>'note-input','id'=>'rc-manual-'.$question_key]) !!}

                                            @if (isset($manual_rc[$question_key]) && isset($score_rc[$question_key]))
                                            @if ($manual_rc[$question_key] == 'true')
                                            @if ($score_rc[$question_key] == 2)
                                            @php 
                                            $rc_pass_mark++; 
                                            $rc_pass_manager[] = $question_key;
                                            @endphp
                                            @elseif (count($rc_pass_manager) < 3)
                                            @php 
                                            $rc_pass_mark = 0; 
                                            $rc_pass_manager = [];
                                            @endphp
                                            @endif
                                            @else
                                            @php 
                                            $rc_pass_mark = 0; 
                                            $rc_pass_manager = [];
                                            @endphp
                                            @endif
                                            @endif

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
                                            <td class="text-left score-bg score-bg-rc score-block  {!! (isset($score_sub_id_rc[$question_key]) && $score_sub_id_rc[$question_key] == $sub_id && isset($score_rc[$question_key]) && ((int)$score_rc[$question_key] >= 0)) ? 'active-block' : ''; !!}" data-value="{!! $value['score'] !!}">{!! $value['title'] !!}</td>
                                            <td class="score-block  {!! (isset($score_sub_id_rc[$question_key]) && $score_sub_id_rc[$question_key] == $sub_id && isset($score_rc[$question_key]) && ((int)$score_rc[$question_key] >= 0)) ? 'active-block' : ''; !!}" data-value="{!! $value['score'] !!}">{!! $value['score'] !!}</td>
                                            @elseif ($value['type'] == 2)
                                            <td colspan="2" class="text-left">
                                                {!! $value['title'] !!}
                                                {!! Form::textarea("note[$rc][$question_no][$sub_id]", @$note[$sub_id], ['class'=>'form-control note-input', 'rows'=>2]) !!}
                                            </td>     
                                            @elseif ($value['type'] == 4)
                                            <td colspan="2" class="text-left">
                                                {!! $value['title'] !!}
                                                {!! Form::text("note[$rc][$question_no][$sub_id]", @$note[$sub_id], ['class'=>'form-control note-input']) !!}
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
                                                    {!! Form::checkbox("correct[$rc][$question_no][$sub_id]", null, @$correct[$sub_id], ['class'=>'add-value', 'id'=>"correct[$rc][$question_no][$sub_id]"]) !!}
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
                                        @php $last_rc = $question_key; @endphp
                                        @endforeach
                                        {!! Form::hidden('rc_pass_mark', $rc_pass_mark) !!}
                                        {!! Form::hidden('rc_pass_manager', json_encode($rc_pass_manager)) !!}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="bayleyHeadingThree">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#bayleyaccordion" href="#bayleyThree" aria-expanded="true" aria-controls="bayleyThree" class="collapsed">
                                    Expressive Communication (EC)
                                    <span class="color-black font-normal pull-right plr-15" id="ec">Raw score: <b>{!! @$results->ec !!}</b></span>
                                </a>
                            </h4>
                        </div>
                        <div id="bayleyThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="bayleyHeadingThree">
                            <div class="panel-body">
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
                                        $count = 1;
                                        $ec_pass_mark = 0;
                                        $ec_pass_manager = [];
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
                                        @if ($key == 0)
                                        @if ($start_point != $current_point)
                                        @php $count = 1; @endphp             
                                        @else
                                        @php $count++; @endphp                                            
                                        @endif
                                        @endif
                                        <tr data-category="{!! $ec !!}" data-question="{!! $question_key !!}" data-sub-question="{!! $sub_id !!}" data-type="{!! $value['type'] !!}" data-point="{!! $current_point !!}" data-count="{!! $count !!}" data-scale="{!! $value['score'] !!}">
                                            @endif
                                            @if ($key == 0)
                                            {!! Form::hidden("score_sub_id[$ec][$question_key]", @$score_sub_id_ec[$question_key],['class'=>'note-input', 'data-original'=>@$score_sub_id_ec[$question_key]]) !!}
                                            {!! Form::hidden("score[$ec][$question_key]", @$score_ec[$question_key],['class'=>'note-input ec-scale-score','id'=>'ec-ans-'.$question_key, 'data-ques-id'=> $question_key, 'data-manual'=> @$manual_ec[$question_key]]) !!}
                                            {!! Form::hidden("is_manual[$ec][$question_key]", @$manual_ec[$question_key],['class'=>'note-input','id'=>'ec-manual-'.$question_key]) !!}

                                            @if (isset($manual_ec[$question_key]) && isset($score_ec[$question_key]))
                                            @if ($manual_ec[$question_key] == 'true')
                                            @if ($score_ec[$question_key] == 2)
                                            @php 
                                            $ec_pass_mark++; 
                                            $ec_pass_manager[] = $question_key;
                                            @endphp
                                            @elseif (count($ec_pass_manager) < 3)
                                            @php 
                                            $ec_pass_mark = 0; 
                                            $ec_pass_manager = [];
                                            @endphp
                                            @endif
                                            @else
                                            @php 
                                            $ec_pass_mark = 0; 
                                            $ec_pass_manager = [];
                                            @endphp
                                            @endif
                                            @endif

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
                                            <td class="text-left score-bg score-bg-ec score-block {!! (isset($score_sub_id_ec[$question_key]) && $score_sub_id_ec[$question_key] == $sub_id && isset($score_ec[$question_key]) && ((int)$score_ec[$question_key] >= 0)) ? 'active-block' : ''; !!}" data-value="{!! $value['score'] !!}">{!! $value['title'] !!}</td>
                                            <td class="score-block {!! (isset($score_sub_id_ec[$question_key]) && $score_sub_id_ec[$question_key] == $sub_id && isset($score_ec[$question_key]) && ((int)$score_ec[$question_key] >= 0)) ? 'active-block' : ''; !!}" data-value="{!! $value['score'] !!}">{!! $value['score'] !!}</td>
                                            @elseif ($value['type'] == 2)
                                            <td colspan="2" class="text-left">
                                                {!! $value['title'] !!}
                                                {!! Form::textarea("note[$ec][$question_no][$sub_id]", @$note[$sub_id], ['class'=>'form-control note-input', 'rows'=>2]) !!}
                                            </td>     
                                            @elseif ($value['type'] == 4)
                                            <td colspan="2" class="text-left">
                                                {!! $value['title'] !!}
                                                {!! Form::text("note[$ec][$question_no][$sub_id]", @$note[$sub_id], ['class'=>'form-control note-input']) !!}
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
                                                    {!! Form::checkbox("correct[$ec][$question_no][$sub_id]", null, @$correct[$sub_id], ['class'=>'add-value', 'id'=>"correct[$ec][$question_no][$sub_id]"]) !!}
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
                                        @php $last_ec = $question_key; @endphp
                                        @endforeach
                                        {!! Form::hidden('ec_pass_mark', $ec_pass_mark) !!}
                                        {!! Form::hidden('ec_pass_manager', json_encode($ec_pass_manager)) !!}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="bayleyHeadingFour">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#bayleyaccordion" href="#bayleyFour" aria-expanded="true" aria-controls="bayleyFour" class="collapsed">
                                    Fine Motor (FM)
                                    <span class="color-black font-normal pull-right plr-15" id="fm">Raw score: <b>{!! @$results->fm !!}</b></span>
                                </a>
                            </h4>
                        </div>
                        <div id="bayleyFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="bayleyHeadingFour">
                            <div class="panel-body">
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
                                        $count = 1;
                                        $fm_pass_mark = 0;
                                        $fm_pass_manager = [];
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
                                        @if ($key == 0)
                                        @if ($start_point != $current_point)
                                        @php $count = 1; @endphp             
                                        @else
                                        @php $count++; @endphp                                            
                                        @endif
                                        @endif
                                        <tr data-category="{!! $fm !!}" data-question="{!! $question_key !!}" data-sub-question="{!! $sub_id !!}" data-type="{!! $value['type'] !!}" data-point="{!! $current_point !!}" data-count="{!! $count !!}" data-scale="{!! $value['score'] !!}">
                                            @endif
                                            @if ($key == 0)
                                            {!! Form::hidden("score_sub_id[$fm][$question_key]", @$score_sub_id_fm[$question_key],['class'=>'note-input', 'data-original'=>@$score_sub_id_fm[$question_key]]) !!}
                                            {!! Form::hidden("score[$fm][$question_key]", @$score_fm[$question_key],['class'=>'note-input fm-scale-score','id'=>'fm-ans-'.$question_key, 'data-ques-id'=> $question_key, 'data-manual'=> @$manual_fm[$question_key]]) !!}
                                            {!! Form::hidden("is_manual[$fm][$question_key]", @$manual_fm[$question_key],['class'=>'note-input','id'=>'fm-manual-'.$question_key]) !!}

                                            @if (isset($manual_fm[$question_key]) && isset($score_fm[$question_key]))
                                            @if ($manual_fm[$question_key] == 'true')
                                            @if ($score_fm[$question_key] == 2)
                                            @php 
                                            $fm_pass_mark++; 
                                            $fm_pass_manager[] = $question_key;
                                            @endphp
                                            @elseif (count($fm_pass_manager) < 3)
                                            @php 
                                            $fm_pass_mark = 0; 
                                            $fm_pass_manager = [];
                                            @endphp
                                            @endif
                                            @else
                                            @php 
                                            $fm_pass_mark = 0; 
                                            $fm_pass_manager = [];
                                            @endphp
                                            @endif
                                            @endif

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
                                            <td class="text-left score-bg score-bg-fm score-block {!! (isset($score_sub_id_fm[$question_key]) && $score_sub_id_fm[$question_key] == $sub_id && isset($score_fm[$question_key]) && ((int)$score_fm[$question_key] >= 0)) ? 'active-block' : ''; !!}" data-value="{!! $value['score'] !!}">{!! $value['title'] !!}</td>
                                            <td class="score-block {!! (isset($score_sub_id_fm[$question_key]) && $score_sub_id_fm[$question_key] == $sub_id && isset($score_fm[$question_key]) && ((int)$score_fm[$question_key] >= 0)) ? 'active-block' : ''; !!}" data-value="{!! $value['score'] !!}">{!! $value['score'] !!}</td>
                                            @elseif ($value['type'] == 2)
                                            <td colspan="2" class="text-left">
                                                {!! $value['title'] !!}
                                                {!! Form::textarea("note[$fm][$question_no][$sub_id]", @$note[$sub_id], ['class'=>'form-control note-input', 'rows'=>2]) !!}
                                            </td>     
                                            @elseif ($value['type'] == 4)
                                            <td colspan="2" class="text-left">
                                                {!! $value['title'] !!}
                                                {!! Form::text("note[$fm][$question_no][$sub_id]", @$note[$sub_id], ['class'=>'form-control note-input']) !!}
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
                                                    {!! Form::checkbox("correct[$fm][$question_no][$sub_id]", null, @$correct[$sub_id], ['class'=>'add-value', 'id'=>"correct[$fm][$question_no][$sub_id]"]) !!}
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
                                        @php $last_fm = $question_key; @endphp
                                        @endforeach
                                        {!! Form::hidden('fm_pass_mark', $fm_pass_mark) !!}
                                        {!! Form::hidden('fm_pass_manager', json_encode($fm_pass_manager)) !!}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="bayleyHeadingFive">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#bayleyaccordion" href="#bayleyFive" aria-expanded="true" aria-controls="bayleyFive" class="collapsed">
                                    Gross Motor (GM)
                                    <span class="color-black font-normal pull-right plr-15" id="gm">Raw score: <b>{!! @$results->gm !!}</b></span>
                                </a>
                            </h4>
                        </div>
                        <div id="bayleyFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="bayleyHeadingFive">
                            <div class="panel-body">
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
                                        $count = 1;
                                        $gm_pass_mark = 0;
                                        $gm_pass_manager = [];
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
                                        @if ($key == 0)
                                        @if ($start_point != $current_point)
                                        @php $count = 1; @endphp             
                                        @else
                                        @php $count++; @endphp                                            
                                        @endif
                                        @endif
                                        <tr data-category="{!! $gm !!}" data-question="{!! $question_key !!}" data-sub-question="{!! $sub_id !!}" data-type="{!! $value['type'] !!}" data-point="{!! $current_point !!}" data-count="{!! $count !!}" data-scale="{!! $value['score'] !!}">
                                            @endif
                                            @if ($key == 0)
                                            {!! Form::hidden("score_sub_id[$gm][$question_key]", @$score_sub_id_gm[$question_key],['class'=>'note-input', 'data-original'=>@$score_sub_id_gm[$question_key]]) !!}
                                            {!! Form::hidden("score[$gm][$question_key]", @$score_gm[$question_key],['class'=>'note-input gm-scale-score','id'=>'gm-ans-'.$question_key, 'data-ques-id'=> $question_key, 'data-manual'=> @$manual_gm[$question_key]]) !!}
                                            {!! Form::hidden("is_manual[$gm][$question_key]", @$manual_gm[$question_key],['class'=>'note-input','id'=>'gm-manual-'.$question_key]) !!}

                                            @if (isset($manual_gm[$question_key]) && isset($score_gm[$question_key]))
                                            @if ($manual_gm[$question_key] == 'true')
                                            @if ($score_gm[$question_key] == 2)
                                            @php 
                                            $gm_pass_mark++; 
                                            $gm_pass_manager[] = $question_key;
                                            @endphp
                                            @elseif (count($gm_pass_manager) < 3)
                                            @php 
                                            $gm_pass_mark = 0;
                                            $gm_pass_manager = [];
                                            @endphp
                                            @endif
                                            @else
                                            @php 
                                            $gm_pass_mark = 0;
                                            $gm_pass_manager = [];
                                            @endphp
                                            @endif
                                            @endif

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
                                            <td class="text-left score-bg score-bg-gm score-block {!! (isset($score_sub_id_gm[$question_key]) && $score_sub_id_gm[$question_key] == $sub_id && isset($score_gm[$question_key]) && ((int)$score_gm[$question_key] >= 0)) ? 'active-block' : ''; !!}" data-value="{!! $value['score'] !!}">{!! $value['title'] !!}</td>
                                            <td class="score-block {!! (isset($score_sub_id_gm[$question_key]) && $score_sub_id_gm[$question_key] == $sub_id && isset($score_gm[$question_key]) && ((int)$score_gm[$question_key] >= 0)) ? 'active-block' : ''; !!}" data-value="{!! $value['score'] !!}">{!! $value['score'] !!}</td>
                                            @elseif ($value['type'] == 2)
                                            <td colspan="2" class="text-left">
                                                {!! $value['title'] !!}
                                                {!! Form::textarea("note[$gm][$question_no][$sub_id]", @$note[$sub_id], ['class'=>'form-control note-input', 'rows'=>2]) !!}
                                            </td>     
                                            @elseif ($value['type'] == 4)
                                            <td colspan="2" class="text-left">
                                                {!! $value['title'] !!}
                                                {!! Form::text("note[$gm][$question_no][$sub_id]", @$note[$sub_id], ['class'=>'form-control note-input']) !!}
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
                                                    {!! Form::checkbox("correct[$gm][$question_no][$sub_id]", null, @$correct[$sub_id], ['class'=>'add-value', 'id'=>"correct[$gm][$question_no][$sub_id]"]) !!}
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
                                        @php $last_gm = $question_key; @endphp
                                        @endforeach
                                        {!! Form::hidden('gm_pass_mark', $gm_pass_mark) !!}
                                        {!! Form::hidden('gm_pass_manager', json_encode($gm_pass_manager)) !!}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="bayleyHeadingSix">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#bayleyaccordion" href="#bayleySix" aria-expanded="true" aria-controls="bayleySix" class="collapsed">
                                    Social Emotional (SE)
                                    <span class="color-black font-normal pull-right plr-15" id="se">Raw score: <b>{!! @$results->se_raw_score !!}</b></span>
                                </a>
                            </h4>
                        </div>
                        <div id="bayleySix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="bayleyHeadingSix">
                            <div class="panel-body">
                                <span class="point" id="se-point"></span>
                                <table class="table table-bordered border-none">
                                    <thead>
                                        <tr>
                                            <th class="background-transparent border-0"></th>
                                            <th colspan="6">Behavior frequency</th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th class="vertical-align-center">All of<br/> the<br/> time</th>
                                            <th class="vertical-align-center">Most <br/>of the<br/> time</th>
                                            <th class="vertical-align-center">Half <br/>of the<br/> time</th>
                                            <th class="vertical-align-center">Some <br/>of the<br/> time</th>
                                            <th class="vertical-align-center">None <br/>of the<br/> time</th>
                                            <th class="vertical-align-center">Can’t <br/>tell</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bayley_master[$se] as $se_key => $se_value)
                                        <tr data-category="{!! $se !!}" data-question="{!! $se_key !!}" data-sub-question="{!! $se_value[0]['sub_id'] !!}">
                                            {!! Form::hidden("score_sub_id[$se][$se_key]", @$score_sub_id_se[$se_key],['class'=>'note-input', 'data-original'=>@$score_sub_id_se[$se_key]]) !!}
                                            {!! Form::hidden("score[$se][$se_key]", @$score_se[$se_key],['class'=>'note-input se-scale-score','id'=>'se-ans-'.$se_key, 'data-ques-id'=> $se_key]) !!}
                                            <td class="text-left">
                                                {!! $se_key !!}. {!! $se_value[0]['title'] !!}
                                            </td>
                                            <td class="score-bg score-bg-se score-block-2 {!! (isset($score_se[$se_key]) && $score_se[$se_key] == 5) ? 'active-block' : '' !!}" data-value="5">5</td>
                                            <td class="score-bg score-bg-se score-block-2 {!! (isset($score_se[$se_key]) && $score_se[$se_key] == 4) ? 'active-block' : '' !!}" data-value="4">4</td>
                                            <td class="score-bg score-bg-se score-block-2 {!! (isset($score_se[$se_key]) && $score_se[$se_key] == 3) ? 'active-block' : '' !!}" data-value="3">3</td>
                                            <td class="score-bg score-bg-se score-block-2 {!! (isset($score_se[$se_key]) && $score_se[$se_key] == 2) ? 'active-block' : '' !!}" data-value="2">2</td>
                                            <td class="score-bg score-bg-se score-block-2 {!! (isset($score_se[$se_key]) && $score_se[$se_key] == 1) ? 'active-block' : '' !!}" data-value="1">1</td>
                                            <td class="score-bg score-bg-se score-block-2 {!! (isset($score_se[$se_key]) && $score_se[$se_key] == 0) ? 'active-block' : '' !!}" data-value="0">0</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="bayleyHeadingSeven">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#bayleyaccordion" href="#bayleySeven" aria-expanded="true" aria-controls="bayleySeven" class="collapsed">
                                    Adaptive Behavior (AB)
                                </a>
                            </h4>
                        </div>
                        <div id="bayleySeven" class="panel-collapse collapse" role="tabpanel" aria-labelledby="bayleyHeadingSeven">
                            <div class="panel-body">
                                <span class="point" id="ab-point"></span>
                                <div id="ab-r" class="bayley-ab">
                                    <h3>
                                        <strong>
                                            <u>Receptive</u>
                                            <span class="color-black font-normal pull-right plr-15" id="ab_r">Raw score: <b>{!! @$results->rec_raw_score !!}</b></span>
                                        </strong>
                                    </h3>
                                    <table class="table table-bordered border-none">
                                        <thead>
                                            <tr>
                                                <th class="background-transparent border-0"></th>
                                                <th colspan="3">Behavior frequency</th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th class="vertical-align-center">Usually<br/>or often</th>
                                                <th class="vertical-align-center">Sometimes</th>
                                                <th class="vertical-align-center">Never</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($bayley_master[$ab_r] as $ab_key => $ab_value)
                                            <tr data-category="{!! $ab_r !!}" data-question="{!! $ab_key !!}" data-sub-question="{!! $ab_value[0]['sub_id'] !!}">
                                                {!! Form::hidden("score_sub_id[$ab_r][$ab_key]", @$score_sub_id_ab_r[$ab_key],['class'=>'note-input', 'data-original'=>@$score_sub_id_ab_r[$ab_key]]) !!}
                                                {!! Form::hidden("score[$ab_r][$ab_key]", @$score_ab_r[$ab_key],['class'=>'note-input ab_r-scale-score','id'=>'ab_r-ans-'.$ab_key, 'data-ques-id'=> $ab_key]) !!}
                                                <td class="text-left">
                                                    {!! $ab_key !!}. {!! $ab_value[0]['title'] !!}
                                                </td>
                                                <td class="score-bg score-bg-ab score-block-2 {!! (isset($score_ab_r[$ab_key]) && $score_ab_r[$ab_key] == 2) ? 'active-block' : '' !!}" data-value="2">2</td>
                                                <td class="score-bg score-bg-ab score-block-2 {!! (isset($score_ab_r[$ab_key]) && $score_ab_r[$ab_key] == 1) ? 'active-block' : '' !!}" data-value="1">1</td>
                                                <td class="score-bg score-bg-ab score-block-2 {!! (isset($score_ab_r[$ab_key]) && $score_ab_r[$ab_key] == 0) ? 'active-block' : '' !!}" data-value="0">0</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div id="ab-e" class="bayley-ab">
                                    <h3>
                                        <strong>
                                            <u>Expressive</u>
                                            <span class="color-black font-normal pull-right plr-15" id="ab_e">Raw score: <b>{!! @$results->exp_raw_score !!}</b></span>
                                        </strong>
                                    </h3>
                                    <table class="table table-bordered border-none">
                                        <thead>
                                            <tr>
                                                <th class="background-transparent border-0"></th>
                                                <th colspan="3">Behavior frequency</th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th class="vertical-align-center">Usually<br/>or often</th>
                                                <th class="vertical-align-center">Sometimes</th>
                                                <th class="vertical-align-center">Never</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($bayley_master[$ab_e] as $ab_key => $ab_value)
                                            <tr data-category="{!! $ab_e !!}" data-question="{!! $ab_key !!}" data-sub-question="{!! $ab_value[0]['sub_id'] !!}">
                                                {!! Form::hidden("score_sub_id[$ab_e][$ab_key]", @$score_sub_id_ab_e[$ab_key],['class'=>'note-input', 'data-original'=>@$score_sub_id_ab_e[$ab_key]]) !!}
                                                {!! Form::hidden("score[$ab_e][$ab_key]", @$score_ab_e[$ab_key],['class'=>'note-input ab_e-scale-score','id'=>'ab_e-ans-'.$ab_key, 'data-ques-id'=> $ab_key]) !!}
                                                <td class="text-left">
                                                    {!! $ab_key !!}. {!! $ab_value[0]['title'] !!}
                                                </td>
                                                <td class="score-bg score-bg-ab score-block-2 {!! (isset($score_ab_e[$ab_key]) && $score_ab_e[$ab_key] == 2) ? 'active-block' : '' !!}" data-value="2">2</td>
                                                <td class="score-bg score-bg-ab score-block-2 {!! (isset($score_ab_e[$ab_key]) && $score_ab_e[$ab_key] == 1) ? 'active-block' : '' !!}" data-value="1">1</td>
                                                <td class="score-bg score-bg-ab score-block-2 {!! (isset($score_ab_e[$ab_key]) && $score_ab_e[$ab_key] == 0) ? 'active-block' : '' !!}" data-value="0">0</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div id="ab-p" class="bayley-ab">
                                    <h3>
                                        <strong>
                                            <u>Personal</u>
                                            <span class="color-black font-normal pull-right plr-15" id="ab_p">Raw score: <b>{!! @$results->per_raw_score !!}</b></span>
                                        </strong>
                                    </h3>
                                    <table class="table table-bordered border-none">
                                        <thead>
                                            <tr>
                                                <th class="background-transparent border-0"></th>
                                                <th colspan="3">Behavior frequency</th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th class="vertical-align-center">Usually<br/>or often</th>
                                                <th class="vertical-align-center">Sometimes</th>
                                                <th class="vertical-align-center">Never</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($bayley_master[$ab_p] as $ab_key => $ab_value)
                                            <tr data-category="{!! $ab_p !!}" data-question="{!! $ab_key !!}" data-sub-question="{!! $ab_value[0]['sub_id'] !!}">
                                                {!! Form::hidden("score_sub_id[$ab_p][$ab_key]", @$score_sub_id_ab_p[$ab_key],['class'=>'note-input', 'data-original'=>@$score_sub_id_ab_p[$ab_key]]) !!}
                                                {!! Form::hidden("score[$ab_p][$ab_key]", @$score_ab_p[$ab_key],['class'=>'note-input ab_p-scale-score','id'=>'ab_p-ans-'.$ab_key, 'data-ques-id'=> $ab_key]) !!}
                                                <td class="text-left">
                                                    {!! $ab_key !!}. {!! $ab_value[0]['title'] !!}
                                                </td>
                                                <td class="score-bg score-bg-ab score-block-2 {!! (isset($score_ab_p[$ab_key]) && $score_ab_p[$ab_key] == 2) ? 'active-block' : '' !!}" data-value="2">2</td>
                                                <td class="score-bg score-bg-ab score-block-2 {!! (isset($score_ab_p[$ab_key]) && $score_ab_p[$ab_key] == 1) ? 'active-block' : '' !!}" data-value="1">1</td>
                                                <td class="score-bg score-bg-ab score-block-2 {!! (isset($score_ab_p[$ab_key]) && $score_ab_p[$ab_key] == 0) ? 'active-block' : '' !!}" data-value="0">0</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div id="ab-ir" class="bayley-ab">
                                    <h3>
                                        <strong>
                                            <u>Interpersonal Relationships</u>
                                            <span class="color-black font-normal pull-right plr-15" id="ab_ir">Raw score: <b>{!! @$results->ipr_raw_score !!}</b></span>
                                        </strong>
                                    </h3>
                                    <table class="table table-bordered border-none">
                                        <thead>
                                            <tr>
                                                <th class="background-transparent border-0"></th>
                                                <th colspan="3">Behavior frequency</th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th class="vertical-align-center">Usually<br/>or often</th>
                                                <th class="vertical-align-center">Sometimes</th>
                                                <th class="vertical-align-center">Never</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($bayley_master[$ab_ir] as $ab_key => $ab_value)
                                            <tr data-category="{!! $ab_ir !!}" data-question="{!! $ab_key !!}" data-sub-question="{!! $ab_value[0]['sub_id'] !!}">
                                                {!! Form::hidden("score_sub_id[$ab_ir][$ab_key]", @$score_sub_id_ab_e[$ab_key],['class'=>'note-input', 'data-original'=>@$score_sub_id_ab_e[$ab_key]]) !!}
                                                {!! Form::hidden("score[$ab_ir][$ab_key]", @$score_ab_ir[$ab_key],['class'=>'note-input ab_ir-scale-score','id'=>'ab_ir-ans-'.$ab_key, 'data-ques-id'=> $ab_key]) !!}
                                                <td class="text-left">
                                                    {!! $ab_key !!}. {!! $ab_value[0]['title'] !!}
                                                </td>
                                                <td class="score-bg score-bg-ab score-block-2 {!! (isset($score_ab_ir[$ab_key]) && $score_ab_ir[$ab_key] == 2) ? 'active-block' : '' !!}" data-value="2">2</td>
                                                <td class="score-bg score-bg-ab score-block-2 {!! (isset($score_ab_ir[$ab_key]) && $score_ab_ir[$ab_key] == 1) ? 'active-block' : '' !!}" data-value="1">1</td>
                                                <td class="score-bg score-bg-ab score-block-2 {!! (isset($score_ab_ir[$ab_key]) && $score_ab_ir[$ab_key] == 0) ? 'active-block' : '' !!}" data-value="0">0</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div id="ab-pl" class="bayley-ab">
                                    <h3>
                                        <strong>
                                            <u>Play and Leisure</u>
                                            <span class="color-black font-normal pull-right plr-15" id="ab_pl">Raw score: <b>{!! @$results->pla_raw_score !!}</b></span>
                                        </strong>
                                    </h3>
                                    <table class="table table-bordered border-none">
                                        <thead>
                                            <tr>
                                                <th class="background-transparent border-0"></th>
                                                <th colspan="3">Behavior frequency</th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th class="vertical-align-center">Usually<br/>or often</th>
                                                <th class="vertical-align-center">Sometimes</th>
                                                <th class="vertical-align-center">Never</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($bayley_master[$ab_pl] as $ab_key => $ab_value)
                                            <tr data-category="{!! $ab_pl !!}" data-question="{!! $ab_key !!}" data-sub-question="{!! $ab_value[0]['sub_id'] !!}">
                                                {!! Form::hidden("score_sub_id[$ab_pl][$ab_key]", @$score_sub_id_ab_pl[$ab_key],['class'=>'note-input', 'data-original'=>@$score_sub_id_ab_pl[$ab_key]]) !!}
                                                {!! Form::hidden("score[$ab_pl][$ab_key]", @$score_ab_pl[$ab_key],['class'=>'note-input ab_pl-scale-score','id'=>'ab_pl-ans-'.$ab_key, 'data-ques-id'=> $ab_key]) !!}
                                                <td class="text-left">
                                                    {!! $ab_key !!}. {!! $ab_value[0]['title'] !!}
                                                </td>
                                                <td class="score-bg score-bg-ab score-block-2 {!! (isset($score_ab_pl[$ab_key]) && $score_ab_pl[$ab_key] == 2) ? 'active-block' : '' !!}" data-value="2">2</td>
                                                <td class="score-bg score-bg-ab score-block-2 {!! (isset($score_ab_pl[$ab_key]) && $score_ab_pl[$ab_key] == 1) ? 'active-block' : '' !!}" data-value="1">1</td>
                                                <td class="score-bg score-bg-ab score-block-2 {!! (isset($score_ab_pl[$ab_key]) && $score_ab_pl[$ab_key] == 0) ? 'active-block' : '' !!}" data-value="0">0</td>
                                            </tr>
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
        <div class="col-md-1">
            <div id="cg-active-block" class="category-block hide">(CG)</div>
            <div id="rc-active-block" class="category-block hide">(RC)</div>
            <div id="ec-active-block" class="category-block hide">(EC)</div>
            <div id="fm-active-block" class="category-block hide">(FM)</div>
            <div id="gm-active-block" class="category-block hide">(GM)</div>
            <div id="se-active-block" class="category-block hide">(SE)</div>
            <div id="ab-active-block" class="category-block hide">(ADBE)</div>
        </div>
    </div>
    {!! Form::hidden('last_cg', $last_cg) !!}
    {!! Form::hidden('last_rc', $last_rc) !!}
    {!! Form::hidden('last_ec', $last_ec) !!}
    {!! Form::hidden('last_fm', $last_fm) !!}
    {!! Form::hidden('last_gm', $last_gm) !!}
    <div class="col-md-6 col-xs-12" id="scale-score">   
        <h3><b>Subtest/Subdomain Scaled Score Summary</b></h3>
        <table class="table table-bordered table-responsive table-fixed">
            <thead>
                <tr>
                    <th class="text-left">Scale<br/><span class="pl-15">Subtest/subdomain</span></th>
                    <th>Raw score</th>
                    <th>Scaled score</th>
                    <th>Age equivalent</th>
                    <th>Growth scale<br/>value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-left score-bg-cg" colspan="5"><b>Cognitive</b></td>
                </tr>
                <tr>
                    <td class="text-left plr-15 score-bg-cg">Cognitive (CG)</td>
                    <td class="input-width-medium score-bg-cg">{!! Form::text('cg', null, ['class'=>'form-control add-value', 'readonly']) !!}</td>
                    <td class="input-width-medium score-bg-cg">{!! Form::text('cg_scaled_score', null, ['class'=>'form-control add-value']) !!}</td>
                    <td class="score-bg-cg">{!! Form::text('cg_age_equivalent', null, ['class'=>'form-control add-value']) !!}</td>
                    <td class="input-width-medium score-bg-cg">{!! Form::text('cg_growth_scale', null, ['class'=>'form-control add-value']) !!}</td>
                </tr>
                <tr><td class="border-none"></td></tr>
                <tr>
                    <td class="text-left score-bg-rc" colspan="5"><b>Language</b></td>
                </tr>
                <tr>
                    <td class="text-left plr-15 score-bg-ec">Receptive<br/>Communication (RC)</td>
                    <td class="input-width-medium score-bg-rc">{!! Form::text('rc', null, ['class'=>'form-control add-value', 'readonly']) !!}</td>
                    <td class="input-width-medium score-bg-rc">{!! Form::text('rc_scaled_score', null, ['class'=>'form-control add-value']) !!}</td>
                    <td class="score-bg-rc">{!! Form::text('rc_age_equivalent', null, ['class'=>'form-control add-value']) !!}</td>
                    <td class="input-width-medium score-bg-rc">{!! Form::text('rc_growth_scale', null, ['class'=>'form-control add-value']) !!}</td>
                </tr>
                <tr>
                    <td class="text-left plr-15 score-bg-ec" score-bg-ec>Expressive<br/>Communication (EC)</td>
                    <td class="input-width-medium score-bg-ec">{!! Form::text('ec', null, ['class'=>'form-control add-value', 'readonly']) !!}</td>
                    <td class="input-width-medium score-bg-ec">{!! Form::text('ec_scaled_score', null, ['class'=>'form-control add-value']) !!}</td>
                    <td class="score-bg-ec">{!! Form::text('ec_age_equivalent', null, ['class'=>'form-control add-value']) !!}</td>
                    <td class="input-width-medium score-bg-ec">{!! Form::text('ec_growth_scale', null, ['class'=>'form-control add-value']) !!}</td>
                </tr>
                <tr>
                    <td class="text-right score-bg-ec">Sum of<br/>scaled scores</td>
                    <td class="score-bg-ec">Language<br/>(LANG)</td>
                    <td class="sinput-width-medium core-bg-ec">{!! Form::text('lang_scaled_score', null, ['class'=>'form-control add-value', 'readonly']) !!}</td>
                    <td class="border-none"></td>
                    <td class="border-none"></td>
                </tr>
                <tr><td class="border-none"></td></tr>
                <tr>
                    <td class="text-left score-bg-fm" colspan="5"><b>Motor</b></td>
                </tr>
                <tr>
                    <td class="text-left plr-15 score-bg-fm">Fine Motor (FM)</td>
                    <td class="input-width-medium score-bg-fm">{!! Form::text('fm', null, ['class'=>'form-control add-value', 'readonly']) !!}</td>
                    <td class="input-width-medium score-bg-fm">{!! Form::text('fm_scaled_score', null, ['class'=>'form-control add-value']) !!}</td>
                    <td class="score-bg-fm">{!! Form::text('fm_age_equivalent', null, ['class'=>'form-control add-value']) !!}</td>
                    <td class="input-width-medium score-bg-fm">{!! Form::text('fm_growth_scale', null, ['class'=>'form-control add-value']) !!}</td>
                </tr>
                <tr>
                    <td class="text-left plr-15 score-bg-fm">Gross Motor (GM)</td>
                    <td class="input-width-medium score-bg-gm">{!! Form::text('gm', null, ['class'=>'form-control add-value', 'readonly']) !!}</td>
                    <td class="input-width-medium score-bg-gm">{!! Form::text('gm_scaled_score', null, ['class'=>'form-control add-value']) !!}</td>
                    <td class="score-bg-gm">{!! Form::text('gm_age_equivalent', null, ['class'=>'form-control add-value']) !!}</td>
                    <td class="input-width-medium score-bg-gm">{!! Form::text('gm_growth_scale', null, ['class'=>'form-control add-value']) !!}</td>
                </tr>
                <tr>
                    <td class="text-right score-bg-gm">Sum of<br/>scaled scores</td>
                    <td class="score-bg-gm">Motor<br/>(MOT)</td>
                    <td class="input-width-medium score-bg-gm">{!! Form::text('mot_scaled_score', null, ['class'=>'form-control add-value', 'readonly']) !!}</td>
                    <td class="border-none"></td>
                    <td class="border-none"></td>
                </tr>
                <tr><td class="border-none"></td></tr>
                <tr>
                    <td class="text-left score-bg-se" colspan="5"><b>Social-Emotional</b></td>
                </tr>
                <tr>
                    <td class="text-left plr-15 score-bg-se">Social-Emotional (SE)</td>
                    <td class="input-width-medium score-bg-se">{!! Form::text('se_raw_score', null, ['class'=>'form-control add-value', 'readonly']) !!}</td>
                    <td class="input-width-medium score-bg-se">{!! Form::text('se_scaled_score', null, ['class'=>'form-control add-value']) !!}</td>
                    <td class="border-none"></td>
                    <td class="border-none"></td>
                </tr>
                <tr><td class="border-none"></td></tr>
                <tr>
                    <td class="text-left score-bg-ab" colspan="5"><b>Adaptive Behavior</b></td>
                </tr>
                <tr>
                    <td class="text-left plr-15 score-bg-ab">Receptive (REC)</td>
                    <td class="input-width-medium score-bg-ab">{!! Form::text('rec_raw_score', null, ['class'=>'form-control add-value', 'readonly']) !!}</td>
                    <td class="input-width-medium score-bg-ab">{!! Form::text('rec_scaled_score', null, ['class'=>'form-control add-value']) !!}</td>
                    <td class="score-bg-ab">{!! Form::text('rec_age_equivalent', null, ['class'=>'form-control add-value']) !!}</td>
                    <td class="input-width-medium score-bg-ab">{!! Form::text('rec_growth_scale', null, ['class'=>'form-control add-value']) !!}</td>
                </tr>
                <tr>
                    <td class="text-left plr-15 score-bg-ab">Expressive (EXP)</td>
                    <td class="input-width-medium score-bg-ab">{!! Form::text('exp_raw_score', null, ['class'=>'form-control add-value', 'readonly']) !!}</td>
                    <td class="input-width-medium score-bg-ab">{!! Form::text('exp_scaled_score', null, ['class'=>'form-control add-value']) !!}</td>
                    <td class="score-bg-ab">{!! Form::text('exp_age_equivalent', null, ['class'=>'form-control add-value']) !!}</td>
                    <td class="input-width-medium score-bg-ab">{!! Form::text('exp_growth_scale', null, ['class'=>'form-control add-value']) !!}</td>
                </tr>
                <tr>
                    <td class="text-left plr-15 score-bg-ab">Personal (PER)</td>
                    <td class="input-width-medium score-bg-ab">{!! Form::text('per_raw_score', null, ['class'=>'form-control add-value', 'readonly']) !!}</td>
                    <td class="input-width-medium score-bg-ab">{!! Form::text('per_scaled_score', null, ['class'=>'form-control add-value']) !!}</td>
                    <td class="score-bg-ab">{!! Form::text('per_age_equivalent', null, ['class'=>'form-control add-value']) !!}</td>
                    <td class="input-width-medium score-bg-ab">{!! Form::text('per_growth_scale', null, ['class'=>'form-control add-value']) !!}</td>
                </tr>
                <tr>
                    <td class="text-left plr-15 score-bg-ab">Interpersonal Relationships (IPR)</td>
                    <td class="input-width-medium score-bg-ab">{!! Form::text('ipr_raw_score', null, ['class'=>'form-control add-value', 'readonly']) !!}</td>
                    <td class="input-width-medium score-bg-ab">{!! Form::text('ipr_scaled_score', null, ['class'=>'form-control add-value']) !!}</td>
                    <td class="score-bg-ab">{!! Form::text('ipr_age_equivalent', null, ['class'=>'form-control add-value']) !!}</td>
                    <td class="input-width-medium score-bg-ab">{!! Form::text('ipr_growth_scale', null, ['class'=>'form-control add-value']) !!}</td>
                </tr>
                <tr>
                    <td class="text-left plr-15 score-bg-ab">Play and Leisure (PLA)</td>
                    <td class="input-width-medium score-bg-ab">{!! Form::text('pla_raw_score', null, ['class'=>'form-control add-value', 'readonly']) !!}</td>
                    <td class="input-width-medium score-bg-ab">{!! Form::text('pla_scaled_score', null, ['class'=>'form-control add-value']) !!}</td>
                    <td class="score-bg-ab">{!! Form::text('pla_age_equivalent', null, ['class'=>'form-control add-value']) !!}</td>
                    <td class="input-width-medium score-bg-ab">{!! Form::text('pla_growth_scale', null, ['class'=>'form-control add-value']) !!}</td>
                </tr>
                <tr>
                    <td class="text-left score-bg-ab">Sum of<br/>scaled scores</td>
                    <td class="score-bg-ab">Adaptive Behavior<br/>(ADBE)</td>
                    <td class="input-width-medium score-bg-ab">{!! Form::text('adbe_scaled_score', null, ['class'=>'form-control add-value', 'readonly']) !!}</td>
                    <td class="border-none"></td>
                    <td class="border-none"></td>
                </tr>
            </tbody>
        </table>  
    </div>
    <div class="col-md-6 col-xs-12" id="scale-score-2">        
        <h3><b>Standard Score Summary</b></h3>
        <table class="table table-bordered table-responsive table-fixed">
            <thead>
                <tr>
                    <th class="text-left">Scale<br/><span class="pl-15">Score</span></th>
                    <th>Sum of<br/>scaled<br/>scores</th>
                    <th>Standard<br/>score</th>
                    <th>Percentile<br/>rank</th>
                    <th>Confidence<br/>interval<div class="display-flex">{!! Form::text('confidence_interval', null, ['class'=>'form-control add-value']) !!}<span class="pl-must-5">%</span></div></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-left score-bg-cg" colspan="5"><b>Cognitive, Language, and Motor</b></td>
                </tr>
                <tr>
                    <td class="text-left">Cognitive (COG)</td>
                    <td class="input-width-medium">{!! Form::text('cg_scaled_score_copy', @$results->cg_scaled_score, ['class'=>'form-control', 'readonly']) !!}</td>
                    <td>{!! Form::text('cog_standard_score', null, ['class'=>'form-control add-value']) !!}</td>
                    <td>{!! Form::text('cog_percentile_rank', null, ['class'=>'form-control add-value']) !!}</td>
                    <td>
                        <div class="display-flex">
                            {!! Form::text('cog_confidence_interval_start', null, ['class'=>'form-control add-value']) !!}
                            <span class="plr-5">-</span>
                            {!! Form::text('cog_confidence_interval_end', null, ['class'=>'form-control add-value']) !!}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="text-left">Language (LANG)</td>
                    <td class="input-width-medium">{!! Form::text('lang_scaled_score_copy', @$results->lang_scaled_score, ['class'=>'form-control', 'readonly']) !!}</td>
                    <td>{!! Form::text('lang_standard_score', null, ['class'=>'form-control add-value']) !!}</td>
                    <td>{!! Form::text('lang_percentile_rank', null, ['class'=>'form-control add-value']) !!}</td>
                    <td>
                        <div class="display-flex">
                            {!! Form::text('lang_confidence_interval_start', null, ['class'=>'form-control add-value']) !!}
                            <span class="plr-5">-</span>
                            {!! Form::text('lang_confidence_interval_end', null, ['class'=>'form-control add-value']) !!}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="text-left">Motor (MOT)</td>
                    <td class="input-width-medium">{!! Form::text('mot_scaled_score_copy', @$results->mot_scaled_score, ['class'=>'form-control', 'readonly']) !!}</td>
                    <td>{!! Form::text('mot_standard_score', null, ['class'=>'form-control add-value']) !!}</td>
                    <td>{!! Form::text('mot_percentile_rank', null, ['class'=>'form-control add-value']) !!}</td>
                    <td>
                        <div class="display-flex">
                            {!! Form::text('mot_confidence_interval_start', null, ['class'=>'form-control add-value']) !!}
                            <span class="plr-5">-</span>
                            {!! Form::text('mot_confidence_interval_end', null, ['class'=>'form-control add-value']) !!}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="text-left score-bg-se" colspan="5"><b>Social-Emotional</b></td>
                </tr>
                <tr>
                    <td class="text-left">Social-Emotional (SOEM)</td>
                    <td class="input-width-medium">{!! Form::text('se_scaled_score_copy', @$results->se_scaled_score, ['class'=>'form-control', 'readonly']) !!}</td>
                    <td>{!! Form::text('soem_standard_score', null, ['class'=>'form-control add-value']) !!}</td>
                    <td>{!! Form::text('soem_percentile_rank', null, ['class'=>'form-control add-value']) !!}</td>
                    <td>
                        <div class="display-flex">
                            {!! Form::text('soem_confidence_interval_start', null, ['class'=>'form-control add-value']) !!}
                            <span class="plr-5">-</span>
                            {!! Form::text('soem_confidence_interval_end', null, ['class'=>'form-control add-value']) !!}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="text-left score-bg-ab" colspan="5"><b>Adaptive Behavior</b></td>
                </tr>
                <tr>
                    <td class="text-left">Communication (COM)</td>
                    <td class="input-width-medium">{!! Form::text('com_scaled_score', null, ['class'=>'form-control', 'readonly']) !!}</td>
                    <td>{!! Form::text('com_standard_score', null, ['class'=>'form-control add-value']) !!}</td>
                    <td>{!! Form::text('com_percentile_rank', null, ['class'=>'form-control add-value']) !!}</td>
                    <td>
                        <div class="display-flex">
                            {!! Form::text('com_confidence_interval_start', null, ['class'=>'form-control add-value']) !!}
                            <span class="plr-5">-</span>
                            {!! Form::text('com_confidence_interval_end', null, ['class'=>'form-control add-value']) !!}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="text-left">Daily Living Skills (DLS)</td>
                    <td class="input-width-medium">{!! Form::text('per_scaled_score_copy', @$results->per_scaled_score, ['class'=>'form-control', 'readonly']) !!}</td>
                    <td>{!! Form::text('dls_standard_score', null, ['class'=>'form-control add-value']) !!}</td>
                    <td>{!! Form::text('dls_percentile_rank', null, ['class'=>'form-control add-value']) !!}</td>
                    <td>
                        <div class="display-flex">
                            {!! Form::text('dls_confidence_interval_start', null, ['class'=>'form-control add-value']) !!}
                            <span class="plr-5">-</span>
                            {!! Form::text('dls_confidence_interval_end', null, ['class'=>'form-control add-value']) !!}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="text-left">Socialization (SOC)</td>
                    <td class="input-width-medium">{!! Form::text('soc_scaled_score', null, ['class'=>'form-control', 'readonly']) !!}</td>
                    <td>{!! Form::text('soc_standard_score', null, ['class'=>'form-control add-value']) !!}</td>
                    <td>{!! Form::text('soc_percentile_rank', null, ['class'=>'form-control add-value']) !!}</td>
                    <td>
                        <div class="display-flex">
                            {!! Form::text('soc_confidence_interval_start', null, ['class'=>'form-control add-value']) !!}
                            <span class="plr-5">-</span>
                            {!! Form::text('soc_confidence_interval_end', null, ['class'=>'form-control add-value']) !!}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="text-left">Adaptive Behavior (ADBE)</td>
                    <td class="input-width-medium">{!! Form::text('adbe_scaled_score_copy', @$results->adbe_scaled_score, ['class'=>'form-control', 'readonly']) !!}</td>
                    <td>{!! Form::text('adbe_standard_score', null, ['class'=>'form-control add-value']) !!}</td>
                    <td>{!! Form::text('adbe_percentile_rank', null, ['class'=>'form-control add-value']) !!}</td>
                    <td>
                        <div class="display-flex">
                            {!! Form::text('adbe_confidence_interval_start', null, ['class'=>'form-control add-value']) !!}
                            <span class="plr-5">-</span>
                            {!! Form::text('adbe_confidence_interval_end', null, ['class'=>'form-control add-value']) !!}
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 text-right">
        <button type="button" class="btn btn-success back_to_screening"><i class="fa fa-chevron-circle-left"></i> BACK TO SCREENING</button>
    </div>
</div>
